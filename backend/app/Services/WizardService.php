<?php

namespace App\Services;

use App\Modeles\article;
use App\Modeles\categorie;
use App\Modeles\company;
use App\Modeles\permision;
use App\Modeles\product;
use App\Modeles\role_permission;
use App\Modeles\users;
use App\Modeles\WizardSession;
use App\Services\MailService;
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
            // Get user ID and company ID
            $userId = is_array($user) ? ($user['id'] ?? null) : ($user->id ?? null);
            $companyId = is_array($user) ? ($user['company_id'] ?? null) : ($user->company_id ?? null);

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
                'company_id' => $companyId,
                'status' => 'draft',
                'current_step' => 1,
                'state' => json_encode($this->getDefaultState()),
                'last_saved_at' => now(), // Initialize for expiration tracking
            ]);

            // Link to user
            $userModel = users::trouver($userId);
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
            // dd($session->company_id);
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
                $existingCompany = company::trouver($session->company_id);
                // dd($existingCompany);<
                if (!$existingCompany) {
                    $db->annuler();
                    return $this->error('Company not found - was it deleted?', 404);
                }

                $company = $existingCompany;

                // Update existing company with finalized data
                $company->name = $finalState['workspaceName'] ?? $company->name;
                $company->slug = $this->generateSlug($finalState['workspaceName']);
                $company->currency = $this->normalizeCurrency($finalState['currency'] ?? 'USD');
                $company->country = $this->normalizeBoundedString($finalState['country'] ?? 'RDC', 100);
                $company->timezone = $this->normalizeBoundedString($finalState['timezone'] ?? 'UTC+1', 50);
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
                    'redirectUrl' => "/app?company={$company->slug}",
                ]);
            } catch (\Exception $transactionError) {
                $db->annuler(); // ✅ ROLLBACK everything
                throw $transactionError;
            }
        } catch (\Exception $e) {
            return $this->error('Erreur deployment: ' . $e->getMessage(), 500);
        }
    }
    public function generateCode(string $type, string $name): string
    {
        $prefix = strtoupper(substr($type ?? 'DEP', 0, 3));
        $name = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $name), 0, 4));
        $random = rand(1000, 9999);
        $code = $prefix . '-' . $name . '-' . $random;
        return  $code;
    }
    /**
     * Create wizard data from final state
     * Creates: sites, categories, products, roles, and sends invitations
     * MUST be called inside a transaction (parent bmvc handles rollback)
     */
    private function createWizardData(company $company, array $state): void
    {
        // ✅ Create Primary Site
        if (!empty($state['siteName'])) {


            $site = \App\Modeles\warehouse::creer([
                'company_id' => $company->id,
                'name' => $state['siteName'],
                'type' => $state['siteType'] ?? 'depot',
                'code' => $this->generateCode($state['siteType'], $state['siteName']),
                'address' => $state['siteAddress'] ?? '',
            ]);
            if (!$site) {
                throw new \Exception('Impossible de créer le site principal');
            }
        }
        $category = null;
        // ✅ Create Categories
        if (!empty($state['categories']) && is_array($state['categories'])) {
            foreach ($state['categories'] as $categoryName) {
                if (!empty(trim($categoryName))) {
                    $category = categorie::creer([
                        'company_id' => $company->id,
                        'name' => trim($categoryName),
                        'description' => ''
                    ]);

                    if (!$category) {
                        throw new \Exception("Impossible de créer la catégorie: {$categoryName}");
                    }
                }
            }
        }
        $categoryId = $category->ou('name', '=', $state['productCategory'] ?? '')->premier()->id ?? null;
        // ✅ Create Default Product
        if (!empty($state['productName'])) {
            $product = product::creer([
                'company_id' => $company->id,
                'category_id' => $categoryId,
                'name' => $state['productName'],
                'sku' => $state['productSku'] ?? 'PROD-' . uniqid(),
            ]);
            if (!$product) {
                throw new \Exception('Impossible de créer le produit initial');
            }
        }

        // ✅ create Roles
        $this->createRolesAndPermissions($company, $state);

        // ✅ Send Invitations
        if (!empty($state['invitations']) && is_array($state['invitations'])) {
            $invService = new InvitationService();

            foreach ($state['invitations'] as $invitation) {
                if (!is_array($invitation)) {
                    continue;
                }

                $email = trim((string)($invitation['email'] ?? ''));
                if ($email === '') {
                    continue;
                }

                $roleId = $this->resolveRoleIdForInvitation($company->id, $invitation, $state);
                if (!$roleId) {
                    error_log("[WIZARD] Invitation ignorée (rôle introuvable): {$email}");
                    continue;
                }

                $name = trim((string)($invitation['name'] ?? ''));
                if ($name === '') {
                    $name = explode('@', $email)[0] ?? $email;
                }

                $payload = [
                    'email' => $email,
                    'role_id' => $roleId,
                    'name' => $name,
                    'warehouse' => $invitation['warehouse'] ?? null,
                ];

                $result = $invService->createInvitation($payload, $company);
                if (empty($result['success'])) {
                    $message = $result['message'] ?? "Échec d'envoi d'invitation pour {$email}";
                    log_app("[WIZARD] Invitation non envoyée: {$message}");
                    continue;
                }
            }
        }
    }

    private function resolveRoleIdForInvitation(int $companyId, array $invitation, array $state): ?int
    {
        $candidateRoleId = $invitation['role_id'] ?? null;
        if (!empty($candidateRoleId)) {
            $role = \App\Modeles\role::ou('id', '=', $candidateRoleId)
                ->et('company_id', '=', $companyId)
                ->premier();

            if ($role) {
                return (int)$role->id;
            }
        }

        $candidateRoleName = trim((string)($invitation['role'] ?? $state['selectedRole'] ?? ''));
        if ($candidateRoleName !== '') {
            $role = \App\Modeles\role::ou('name', '=', $candidateRoleName)
                ->et('company_id', '=', $companyId)
                ->premier();

            if ($role) {
                return (int)$role->id;
            }
        }

        return null;
    }

    public function createRolesAndPermissions(company $company, array $state): void
    {
        $createdRoles = [];

        // 1. CREATE ROLES
        if (!empty($state['roles']) && is_array($state['roles'])) {

            foreach ($state['roles'] as $roleName) {

                $roleName = trim($roleName);

                if (!empty($roleName)) {
                    $roleCode = strtoupper(
                        preg_replace('/[^A-Za-z0-9]/', '_', trim($roleName))
                    );

                    $existingRole = \App\Modeles\role::ou('company_id', '=', $company->id)
                        ->et('code', '=', $roleCode)
                        ->premier();

                    if ($existingRole) {
                        $createdRoles[$roleName] = $existingRole->id;
                        continue;
                    }

                    $role = \App\Modeles\role::creer([
                        'company_id' => $company->id,
                        'name' => $roleName,
                        'description' => '',
                        'code' => $roleCode,
                    ]);

                    if (!$role) {
                        throw new \Exception("Impossible de créer le rôle: {$roleName}");
                    }

                    $createdRoles[$roleName] = $role->id;
                }
            }
        }

        // 2. GET SELECTED ROLE
        $selectedRoleId = null;

        if (!empty($state['selectedRole'])) {

            $selectedRole = \App\Modeles\role::ou('name', '=', $state['selectedRole'])
                ->et('company_id', '=', $company->id)
                ->premier();

            $selectedRoleId = $selectedRole->id ?? null;
        }

        // 3. ASSIGN PERMISSIONS
        if (
            !empty($state['selectedPermissions']) &&
            is_array($state['selectedPermissions']) &&
            $selectedRoleId
        ) {

            foreach ($state['selectedPermissions'] as $permissionCode) {

                $permission = \App\Modeles\permission::ou('code', '=', $permissionCode)->premier();

                if (!$permission) {
                    continue; // ignore invalid permissions
                }

                // avoid duplicates
                $exists = \App\Modeles\role_permission::ou('role_id', '=', $selectedRoleId)
                    ->et('permission_id', '=', $permission->id)
                    ->premier();

                if (!$exists) {
                    \App\Modeles\role_permission::creer([
                        'role_id' => $selectedRoleId,
                        'permission_id' => $permission->id
                    ]);
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
     * Normalize currency input from UI labels to ISO-like code (max 10 chars).
     * Accepts values like "US Dollar (USD)", "USD - Dollar", or "usd".
     */
    private function normalizeCurrency(string $raw): string
    {
        $value = trim((string)$raw);
        if ($value === '') {
            return 'USD';
        }

        if (preg_match('/\(([A-Za-z]{3,10})\)/', $value, $m)) {
            return strtoupper(substr($m[1], 0, 10));
        }

        if (preg_match('/\b([A-Za-z]{3,10})\b/', $value, $m)) {
            return strtoupper(substr($m[1], 0, 10));
        }

        return strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $value), 0, 10)) ?: 'USD';
    }

    /**
     * Safely trim any user-provided scalar to a DB-friendly bounded string.
     */
    private function normalizeBoundedString(string $raw, int $max): string
    {
        $value = trim((string)$raw);
        if ($value === '') {
            return '';
        }

        return substr($value, 0, $max);
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
