<?php

namespace App\Services;

use App\Modeles\company;
use App\Modeles\users;
use App\Services\BAuthService;
use App\Services\MailService;
use Core\Validateur;
use Exception;

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
            'telephone',
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

            // 1. Verify token (UNE SEULE FOIS)
            $jwt = $this->authService->getAuth()->getTokenProvider();
            $decoded = $jwt->verify($token);

            if (!$decoded) {
                return $this->error('Token invalide ou expiré', 401);
            }

            $userId = $decoded['user_id'] ?? null;
            $userEmail = $decoded['email'] ?? null;

            if (!$userId || !$userEmail) {
                return $this->error('Token malformé', 401);
            }

            // 2. Find user
            $user = users::ou('id', '=', $userId)
                ->ou('email', '=', $userEmail)
                ->premier();

            if (!$user) {
                return $this->error('Utilisateur introuvable', 404);
            }

            // 3. Get company
            $company = company::ou('id', '=', $user->company_id)->premier();

            $alreadyActivated = ($user->activation_status === 'activated');

            // 4. Activate user if not already
            if (!$alreadyActivated) {
                $user->activated_at = now();
                $user->activation_status = 'activated';
                $user->sauvegarder();

                if ($company) {
                    $company->status = 1;

                    if (!$company->setup_step || $company->setup_step == 0) {
                        $company->setup_step = 1;
                    }

                    $company->sauvegarder();
                }
            }

            // 5. Generate tokens (always login)
            $tokenProvider = $this->authService->getAuth()->getTokenProvider();

            $accessToken = $tokenProvider->generate([
                'user_id' => $user->id,
                'email' => $user->email,
            ], 3600);

            $refreshToken = $tokenProvider->generate([
                'user_id' => $user->id,
                'type' => 'refresh',
            ], 604800);
            $user->last_login_at = now();
            $user->sauvegarder();
            $userdata = [
                'id' => $user->id,
                'email' => $user->email,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'company_id' => $user->company_id,
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
            ];
            $this->authService->getAuth()->getSessionProvider()->start($userdata, $accessToken);
            // 6. Compute next step (IMPORTANT FLOW LOGIC)
            $next = 'wizard';

            if ($company && $company->setup_completed_at || $company->setup_step == 100) {
                $next = 'app';
            }

            // 7. Response clean (STATE-BASED)
            return $this->success([
                'state' => $alreadyActivated ? 'already_activated' : 'activated',

                'user' => [
                    'id' => $user->id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                ],

                'company' => $company ? [
                    'id' => $company->id,
                    'name' => $company->name,
                    'setup_step' => $company->setup_step ?? 1,
                    'setup_completed_at' => $company->setup_completed_at,
                ] : null,

                'auth' => [
                    'access_token' => $accessToken,
                    'refresh_token' => $refreshToken,
                    'expires_in' => 3600,
                    'token_type' => 'Bearer',
                ],

                'redirectUrl' => $next,

            ], 'Activation traitée avec succès', 200);
        } catch (\Exception $e) {
            // dd($e);
            return $this->error('Erreur activation: token invalide ou expiré', 500);
        }
    }
    public function isActive(string $companyId): bool
    {
        $company = company::ou('id', '=', $companyId)->premier();
        if (!$company) {
            return false;
        }
        if ($company->status !== 1) {
            return false;
        }
        return true;
    }
    public static function isCompleted(string $companyId): bool
    {
        $company = company::ou('id', '=', $companyId)->premier();

        if (!$company->setup_completed_at || $company->setup_completed_at == null && $company->setup_step != 100) {
            return false;
        }
        return true;
    }
}
