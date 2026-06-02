<?php

namespace App\Services;

use App\Modeles\article;
use App\Modeles\categorie;
use App\Modeles\company;
use App\Modeles\users;
use App\Modeles\WizardSession;
use Core\BaseBD;

/**
 * WizardService - Gère le cycle de vie du wizard d'onboarding
 */
class WizardService
{
    /**
     * Initialize a new wizard session
     * Called when user clicks "Start Setup" button
     */
    public function initializeWizard(?array $user): array
    {
        try {
            // Get user ID
            $userId = is_array($user) ? ($user['id'] ?? null) : ($user->id ?? null);

            if (!$userId) {
                return $this->error('Utilisateur invalide', 400);
            }

            // Check if wizard session already exists and is valid
            $existingSession = WizardSession::ou('user_id', '=', $userId)
                ->ou('status', '<>', 'deployed')
                ->premier();

            if ($existingSession instanceof WizardSession && $existingSession->canBeResumed()) {
                return $this->success([
                    'sessionId' => $existingSession->wizard_session_id,
                    'status' => 'resumed',
                    'message' => 'Session wizard existante restaurée',
                ]);
            }

            // Create new wizard session
            $sessionId = uuid();

            $session = WizardSession::creer([
                'wizard_session_id' => $sessionId,
                'user_id' => $userId,
                'company_id' => null,
                'status' => 'draft',
                'current_step' => 1,
                'state' => json_encode($this->getDefaultState()),
            ]);

            // Link to user
            $userModel = users::ou('id', '=', $userId)->premier();
            if ($userModel) {
                $userModel->wizard_session_id = $sessionId;
                $userModel->sauvegarder();
            }

            return $this->success([
                'sessionId' => $sessionId,
                'status' => 'created',
                'message' => 'Nouvelle session wizard créée',
            ]);
        } catch (\Exception $e) {
            return $this->error('Erreur initialisation wizard: ' . $e->getMessage());
        }
    }

    /**
     * Resume wizard session
     * Called when user opens the wizard page
     */
    public function resumeWizard(string $sessionId): array
    {
        try {
            $session = WizardSession::findBySessionId($sessionId);

            if (!$session) {
                return $this->error('Session wizard introuvable', 404);
            }

            if (!$session->canBeResumed()) {
                return $this->error('Session expirée ou invalide', 410);
            }

            return $this->success([
                'sessionId' => $session->wizard_session_id,
                'step' => $session->current_step,
                'state' => $session->getState(),
                'status' => $session->status,
                'message' => 'Session wizard restaurée',
            ]);
        } catch (\Exception $e) {
            return $this->error('Erreur reprise wizard: ' . $e->getMessage());
        }
    }

    /**
     * Autosave wizard state
     * Called frequently from frontend with debounce
     */
    public function autosaveState(string $sessionId, array $state, int $step, ?array $dirtyFields = null): array
    {
        try {
            $session = WizardSession::findBySessionId($sessionId);

            if (!$session) {
                return $this->error('Session wizard introuvable', 404);
            }

            // Update state
            $state['currentStep'] = $step;
            $session->updateState($state, $dirtyFields);
            $session->status = 'in_progress';
            $session->current_step = $step;
            $session->sauvegarder();

            return $this->success([
                'message' => 'État sauvegardé',
                'lastSavedAt' => is_string($session->last_saved_at) ? $session->last_saved_at : $session->last_saved_at->format('c'),
            ]);
        } catch (\Exception $e) {
            return $this->error('Erreur autosave: ' . $e->getMessage());
        }
    }

    /**
     * Deploy the wizard - Create company and finalize
     * Called when user completes step 8
     * IDEMPOTENT: si déjà deployé, retourne le résultat précédent
     */
    public function deployWizard(string $sessionId, array $finalState, string $idempotencyKey): array
    {
        try {
            $session = WizardSession::findBySessionId($sessionId);

            if (!$session) {
                return $this->error('Session wizard introuvable', 404);
            }

            // ✅ IDEMPOTENCY CHECK
            if ($session->idempotency_key && $session->idempotency_key === $idempotencyKey) {
                if ($session->status === 'deployed') {
                    return $this->success([
                        'message' => 'Deployment idempotent - déjà complété',
                        'companyId' => $session->company_id,
                        'status' => 'deployed',
                        'metadata' => $session->getDeploymentMetadata(),
                    ]);
                }
            }

            // Validate final state
            $validation = $this->validateFinalState($finalState);
            if (!$validation['valid']) {
                return $this->error('État final invalide', 422, $validation['errors']);
            }

            // ✅ TRANSACTION WRAPPER - All or nothing
            $db = BaseBD::obtenir();
            $db->commencer();

            try {
                // ✅ CRITICAL FIX: Get existing company instead of creating new one
                $existingCompany = company::ou('id', '=', $session->company_id)->premier();

                if (!$existingCompany) {
                    $db->annuler();
                    return $this->error('Company not found - was it deleted?', 404);
                }

                $company = $existingCompany;

                // Update existing company with finalized data
                $company->name = $finalState['workspaceName'] ?? $company->name;
                $company->slug = $this->generateSlug($finalState['workspaceName']);
                $company->currency = $finalState['currency'] ?? 'EUR';
                $company->country = $finalState['country'] ?? 'FR';
                $company->timezone = $finalState['timezone'] ?? 'UTC+1';
                $company->status = 1; // Active
                $company->setup_step = 100; // ✅ Completed
                $company->setup_completed_at = now();
                $company->sauvegarder();

                // Create wizard data (sites, categories, roles, etc.) - may throw exception
                $this->createWizardData($company, $finalState);

                // Update session
                $session->company_id = $company->id;
                $session->status = 'deployed';
                $session->deployed_at = now();
                $session->idempotency_key = $idempotencyKey;
                // Always store metadata as JSON string
                $session->deployment_metadata = json_encode([
                    'company_id' => $company->id,
                    'company_slug' => $company->slug,
                    'deployed_at' => now(),
                    'wizard_state' => $finalState,
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                $session->sauvegarder();

                // ✅ COMMIT if everything succeeded
                $db->valider();

                return $this->success([
                    'message' => 'Workspace créé avec succès',
                    'companyId' => $company->id,
                    'companySlug' => $company->slug,
                    'redirectUrl' => "/dashboard?company={$company->slug}",
                ]);
            } catch (\Exception $transactionError) {
                $db->annuler(); // ✅ ROLLBACK everything
                throw $transactionError;
            }
        } catch (\Exception $e) {
            return $this->error('Erreur deployment: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Create wizard data from final state
     * Creates: sites, categories, products, roles, and sends invitations
     * MUST be called inside a transaction (parent level handles rollback)
     */
    private function createWizardData(company $company, array $state): void
    {
        // ✅ Create Primary Site
        if (!empty($state['siteName'])) {
            $site = \App\Modeles\warehouse::creer([
                'company_id' => $company->id,
                'name' => $state['siteName'],
                'type' => $state['siteType'] ?? 'depot',
                'address' => $state['siteAddress'] ?? '',
                'is_default' => true,
                'status' => 1,
            ]);
            if (!$site) {
                throw new \Exception('Impossible de créer le site principal');
            }
        }

        // ✅ Create Categories
        if (!empty($state['categories']) && is_array($state['categories'])) {
            foreach ($state['categories'] as $categoryName) {
                if (!empty(trim($categoryName))) {
                    $category = categorie::creer([
                        'company_id' => $company->id,
                        'name' => trim($categoryName),
                        'type' => 'category',
                        'status' => 1,
                    ]);
                    if (!$category) {
                        throw new \Exception("Impossible de créer la catégorie: {$categoryName}");
                    }
                }
            }
        }

        // ✅ Create Default Product
        if (!empty($state['productName'])) {
            $product = article::creer([
                'company_id' => $company->id,
                'name' => $state['productName'],
                'sku' => $state['productSku'] ?? 'PROD-' . uniqid(),
                'description' => '',
                'price' => (float)($state['productPrice'] ?? 0),
                'stock' => (int)($state['productStock'] ?? 0),
                'status' => 1,
            ]);
            if (!$product) {
                throw new \Exception('Impossible de créer le produit initial');
            }
        }

        // ✅ Create Roles
        if (!empty($state['roles']) && is_array($state['roles'])) {
            $defaultPermissions = [
                'read' => true,
                'create' => true,
                'update' => true,
                'delete' => false,
            ];

            foreach ($state['roles'] as $roleName) {
                if (!empty(trim($roleName))) {
                    $role = \App\Modeles\role::creer([
                        'company_id' => $company->id,
                        'name' => trim($roleName),
                        'description' => '',
                        'permissions' => json_encode($defaultPermissions, JSON_UNESCAPED_UNICODE),
                        'status' => 1,
                    ]);
                    if (!$role) {
                        throw new \Exception("Impossible de créer le rôle: {$roleName}");
                    }
                }
            }
        }

        // ✅ Send Invitations
        if (!empty($state['invitations']) && is_array($state['invitations'])) {
            $mailService = new MailService();

            foreach ($state['invitations'] as $invitation) {
                if (!empty($invitation['email'])) {
                    $invitedUser = \App\Modeles\users::ou('email', '=', $invitation['email'])
                        ->ou('company_id', '=', $company->id)
                        ->premier();

                    if (!$invitedUser) {
                        $invitedUser = \App\Modeles\users::creer([
                            'company_id' => $company->id,
                            'email' => $invitation['email'],
                            'first_name' => $invitation['firstName'] ?? 'Utilisateur',
                            'last_name' => $invitation['lastName'] ?? 'Invité',
                            'password' => password_hash(bin2hex(random_bytes(16)), PASSWORD_BCRYPT),
                            'activation_status' => 'pending',
                        ]);
                    }

                    if ($invitedUser) {
                        $invitationLink = route('api.auth.activate', ['token' => bin2hex(random_bytes(32))]);
                        $message = vue('emails.invitation', [
                            'recipient_name' => $invitedUser->first_name ?? 'Utilisateur',
                            'company_name' => $company->name,
                            'invitationLink' => $invitationLink,
                            'logo_url' => asset('images/logo_quantix.png'),
                        ]);

                        $mailService->send(
                            $invitedUser->email,
                            "Invitation - Rejoignez {$company->name} sur Quantix",
                            $message
                        );
                    }
                }
            }
        }
    }

    private function validateFinalState(array $state): array
    {
        $errors = [];

        if (empty($state['workspaceName'])) {
            $errors[] = 'Le nom du workspace est requis';
        }

        if (empty($state['siteName'])) {
            $errors[] = 'Au moins un site est requis';
        }

        if (empty($state['categories'])) {
            $errors[] = 'Au moins une catégorie est requise';
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
        ];
    }

    /**
     * Generate unique slug
     */
    private function generateSlug(string $name): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $count = company::ou('slug', 'LIKE', "$slug%")->compter();
        return $count > 0 ? "$slug-$count" : $slug;
    }

    /**
     * Get default wizard state
     */
    private function getDefaultState(): array
    {
        return [
            'workspaceName' => '',
            'slug' => '',
            'currency' => 'EUR',
            'country' => 'FR',
            'timezone' => 'UTC+1',
            'unitSystem' => 'metric',
            'siteName' => '',
            'siteType' => 'depot',
            'siteAddress' => '',
            'categories' => [],
            'productName' => '',
            'productSku' => '',
            'productCategory' => '',
            'productPrice' => 0,
            'productStock' => 0,
            'skuPrefix' => 'QTX-',
            'roles' => ['Admin', 'Manager'],
            'selectedRole' => 'Admin',
            'invitations' => [],
            'stockAlertEnabled' => true,
            'negativeStockAllowed' => false,
        ];
    }

    /**
     * Helper: Success response
     */
    private function success(array $data, string $message = '', int $code = 200): array
    {
        return [
            'success' => true,
            'code' => $code,
            'message' => $message ?: 'Opération réussie',
            'data' => $data,
        ];
    }

    /**
     * Helper: Error response
     */
    private function error(string $message, int $code = 400, array $errors = []): array
    {
        return [
            'success' => false,
            'code' => $code,
            'message' => $message,
            'errors' => $errors,
        ];
    }
}
