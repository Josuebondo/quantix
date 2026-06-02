<?php

namespace App\Services;

use App\Modeles\company;
use App\Modeles\users;
use App\Services\BAuthService;
use App\Services\MailService;
use Core\Validateur;

/**
 * CompanyService - Service de gestion des entreprises
 */
class CompanyService
{
    private BAuthService $authService;

    public function __construct()
    {
        $this->authService = new BAuthService();
    }

    /**
     * Enregistrer une nouvelle entreprise avec son administrateur
     * 
     * Body: {
     *   company_name,
     *   company_email,
     *   company_phone,
     *   admin_first_name,
     *   admin_last_name,
     *   admin_email,
     *   admin_password
     * }
     */
    public function registerCompany(array $companyData): array
    {
        try {
            // Validation des données
            $validation = $this->validateCompanyData($companyData);
            if (!$validation['valid']) {
                return $this->error('Validation échouée', 422, $validation['errors']);
            }

            // Vérifier que l'email de l'admin n'existe pas déjà
            $existingUser = users::ou('email', '=', $companyData['admin_email'])->premier();
            if ($existingUser) {
                return $this->error('Cet email d\'administrateur est déjà utilisé', 409);
            }

            // Créer l'entreprise avec les données requises
            $company = company::creer([
                'plan_id' => 1, // ID du plan par défaut
                'slug' => $this->generer_slug($companyData['company_name']),
                'name' => $companyData['company_name'],
                'email' => $companyData['company_email'],
                'phone' => $companyData['company_phone'] ?? '',
                'status' => 0, // Inactif jusqu'à activation
                'setup_step' => 0, // ✅ Initialize setup step
            ]);
            $companyId = $company->id;

            // Créer l'utilisateur administrateur
            $userData = [
                'email' => $companyData['admin_email'],
                'password' => $companyData['admin_password'],
                'first_name' => $companyData['admin_first_name'],
                'last_name' => $companyData['admin_last_name'],
                'company_id' => $companyId,
            ];

            // Utiliser le service d'authentification pour créer l'utilisateur
            $result = $this->authService->register($userData);
            // dd($result);
            if (!isset($result['success']) || !$result['success']) {
                // Supprimer l'entreprise créée en cas d'erreur
                $company->supprimer();
                return $result;
            }

            // Retourner les données d'enregistrement avec l'ID de l'entreprise
            $result['data']['company'] = [
                'id' => $companyId,
                'name' => $company->name,
                'email' => $company->email,
                'phone' => $company->phone,
            ];

            return $result;
        } catch (\Exception $e) {
            return $this->error(
                'Erreur d\'enregistrement d\'entreprise: ' . $e->getMessage(),
                400
            );
        }
    }

    /**
     * Valider les données de création d'entreprise qvec validateur bmvc
     */
    private function validateCompanyData(array $data): array
    {
        $errors = [];
        $v = new Validateur();
        $v->ajouter('company_name', [
            'required',
            'string',
            'max:255'
        ]);
        $v->ajouter('company_email', [
            'required',
            'email',
            'max:255'
        ]);
        $v->ajouter('company_phone', [
            'string',
            'max:20'
        ]);
        $v->ajouter('admin_first_name', [
            'required',
            'string',
            'max:255'
        ]);
        $v->ajouter('admin_last_name', [
            'required',
            'string',
            'max:255'
        ]);
        $v->ajouter('admin_email', [
            'required',
            'email',
            'max:255'
        ]);
        $v->ajouter('admin_password', [
            'required',
            'string',
            'min:8'
        ],);

        if (!$v->valider($data)) {
            $errors = $v->erreurs();
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }

    /**
     * Formater une réponse de succès
     */
    private function success(array $data, string $message = '', int $code = 200): array
    {
        return [
            'success' => true,
            'statut' => $code,
            'message' => $message ?: 'Opération réussie',
            'data' => $data,
        ];
    }

    /**
     * Formater une réponse d'erreur
     */
    private function error(string $message, int $code = 400, array $errors = []): array
    {
        return [
            'success' => false,
            'statut' => $code,
            'message' => $message,
            'errors' => $errors,
        ];
    }

    /**
     * Générer un slug unique pour l'entreprise
     */
    private function generer_slug(string $name): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $count = company::ou('slug', 'LIKE', "$slug%")->compter();
        return $count > 0 ? "$slug-$count" : $slug;
    }
    public function sendActivationToken(array $user)
    {
        $jwt = $this->authService->getAuth()->getTokenProvider();

        $token = $jwt->generate([
            'type'       => 'company_activation',
            'user_id'    => $user['id'],
            'company_id' => $user['company_id'],
            'email'      => $user['email'],
        ], 86400); // 24h expirationdesqwx
        $mailService = new MailService();

        $activationLink = env('URL_APPLICATION') . "/company/activate?token=$token";
        $pricingLink = env('URL_APPLICATION') . "/pricing";


        $message = inclure('email.activation', [
            'activationLink' => $activationLink,
            'pricingLink' => $pricingLink,
            'admin_name' => $user['first_name'] ?? 'Administrateur',
            'logo_url' => asset('images/logo_quantix.png'),
        ]);

        return $mailService->send(
            $user['email'],
            'Bienvenue sur Quantix - Activez votre compte',
            $message
        );
    }

    /**
     * Activate user account with token
     * 
     * Called when user clicks activation link
     * 1. Verify token
     * 2. Mark user as activated
     * 3. Create wizard session
     * 4. Return activation data
     */
    public function activateUserAccount(string $token): array
    {

        try {
            // Verify JWT token
            $jwt = $this->authService->getAuth()->getTokenProvider();
            $verified = $jwt->verify($token);

            if (!$verified) {
                return $this->error('Token invalide ou expiré', 401);
            }

            // Decode to get user data
            $decoded = $jwt->verify($token);
            $userId = $decoded['user_id'] ?? null;
            $userEmail = $decoded['email'] ?? null;

            if (!$userId || !$userEmail) {
                return $this->error('Token malformé', 401);
            }

            // Find user
            $user = users::ou('id', '=', $userId)->ou('email', '=', $userEmail)->premier();
            if (!$user) {
                return $this->error('Utilisateur introuvable', 404);
            }
            // Get associated company
            $company = company::ou('id', '=', $user->company_id)->premier();

            // Already activated?
            if ($user->activation_status === 'activated') {
                // Compte already activated - just return tokens for login
                $tokenProvider = $this->authService->getAuth()->getTokenProvider();
                $accessToken = $tokenProvider->generate([
                    'user_id' => $user->id,
                    'email' => $user->email,
                ], 3600);

                $refreshToken = $tokenProvider->generate([
                    'user_id' => $user->id,
                    'type' => 'refresh',
                ], 604800);

                // Redirect based on setup status
                $redirectUrl = ($company && $company->setup_completed_at)
                    ? '/dashboard'
                    : '/welcome';

                return $this->success([
                    'user' => [
                        'id' => $user->id,
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'email' => $user->email,
                        'company' => [
                            'id' => $company->id ?? null,
                            'name' => $company->name ?? null,
                            'setup_completed_at' => $company->setup_completed_at ?? null,
                        ],
                    ],
                    'tokens' => [
                        'access_token' => $accessToken,
                        'refresh_token' => $refreshToken,
                        'expires_in' => 3600,
                        'token_type' => 'Bearer',
                    ],
                    'message' => 'Compte déjà activé',
                    'redirectUrl' => $redirectUrl,
                    'already_activated' => true,
                ], 'Déjà activé - Auto-login', 200);
            }

            // Mark user as activated
            $user->activated_at = now();
            $user->activation_status = 'activated'; // ✅ Correct field name
            $user->sauvegarder();

            // Get associated company
            $company = company::ou('id', '=', $user->company_id)->premier();
            if ($company) {
                $company->status = 1; // Activate company
                $company->setup_step = 1; // ✅ Initialize setup step
                $company->sauvegarder();
            }

            // ✅ PHASE 2: Generate tokens for auto-login
            $tokenProvider = $this->authService->getAuth()->getTokenProvider();
            $accessToken = $tokenProvider->generate([
                'user_id' => $user->id,
                'email' => $user->email,
            ], 3600); // 1 hour expiration

            $refreshToken = $tokenProvider->generate([
                'user_id' => $user->id,
                'type' => 'refresh',
            ], 604800); // 7 days expiration

            return $this->success([
                'user' => [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'company_id' => $company->id ?? null,
                ],
                'company' => $company ? [
                    'id' => $company->id,
                    'name' => $company->name,
                    'setup_step' => 1,
                ] : null,
                'tokens' => [
                    'access_token' => $accessToken,
                    'refresh_token' => $refreshToken,
                    'expires_in' => 3600,
                    'token_type' => 'Bearer',
                ],
                'message' => 'Compte activé avec succès',
                'redirectUrl' => '/welcome',
                'already_actived' => false,
            ], 'Activation réussie - Auto-login activé', 200);
        } catch (\Exception $e) {
            return $this->error('Erreur activation: ' . $e->getMessage() . $e->getCode(), 500);
        }
    }
}
