<?php

namespace App\Controleurs;

use App\BaseControleur;
use App\Modeles\users;
use App\Services\BAuthService;
use App\Services\CompanyService;
use Core\Requete;
use Core\Reponse;
use Core\Session;
use Core\APIResponse;
use Bmvc\BAuth\Support\Password;

/**
 * AuthControleur - Gestion de l'authentification avec BAuth
 */
class AuthControleur extends BaseControleur
{
    private BAuthService $authService;
    private CompanyService $companyService;

    public function __construct()
    {
        parent::__construct();
        $this->authService = new BAuthService();
        $this->companyService = new CompanyService();
    }

    /**
     * Afficher la page de connexion
     */
    public function index(Requete $requete, Reponse $response): string
    {

        return vue('auth.index', ['titre' => 'Quantix | Connexion']);
    }
    public function sighin()
    {
        return vue('auth.sighin');
    }
    /**
     * API: Connexion utilisateur
     * POST /api/auth/login
     * Body: {email, password}
     */
    public function apiLogin(Requete $requete, Reponse $response)
    {
        $data = $requete->tousCorps();
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        // return $response->json(['message' => 'Tentative de connexion...', 'data' => $data], 200);
        if (empty($email) || empty($password)) {
            $error = APIResponse::erreur('Email et mot de passe requis', [], 422);
            return $response->json($error->json(), 422);
        }

        $result = $this->authService->login($email, $password);
        $statusCode = $result['statut'] ?? 200;

        return $response->json($result, $statusCode);
    }
    public function activeAcount(Requete $requete)
    {
        $email = $requete->obtenir('email', 'josuebondojw@gmail.com');
        $domain = strtolower(substr(strrchr($email, '@'), 1));
        $session = session();
        dd($session->tous());
        $mailUrl = null;
        $mailLabel = null;

        switch ($domain) {
            case 'gmail.com':
                $mailUrl = 'https://mail.google.com/';
                $mailLabel = 'Ouvrir Gmail';
                break;

            case 'outlook.com':
            case 'hotmail.com':
            case 'live.com':
                $mailUrl = 'https://outlook.live.com/mail/';
                $mailLabel = 'Ouvrir Outlook';
                break;

            case 'yahoo.com':
                $mailUrl = 'https://mail.yahoo.com/';
                $mailLabel = 'Ouvrir Yahoo Mail';
                break;

            case 'icloud.com':
            case 'me.com':
            case 'mac.com':
                $mailUrl = 'https://www.icloud.com/mail/';
                $mailLabel = 'Ouvrir iCloud Mail';
                break;
        }

        return  vue('company.nonActive', ['email' => $email, 'mailUrl' => $mailUrl, 'mailLabel' => $mailLabel]);
    }
    /**
     * Alias pour apiLogin (compatibilité)
     */
    public function login(Requete $requete, Reponse $response)
    {
        return $this->apiLogin($requete, $response);
    }

    /**
     * API: Enregistrement nouvel utilisateur
     * POST /api/auth/register
     * Body: {email, password, first_name, last_name, company_id}
     */
    public function apiRegister(Requete $requete, Reponse $response)
    {
        $data = $requete->tousCorps();

        if (empty($data['email']) || empty($data['password'])) {
            $error = APIResponse::erreur('Email et mot de passe requis', [], 422);
            return $response->json($error->json(), 422);
        }

        $result = $this->authService->register($data);
        $statusCode = $result['statut'] ?? 200;

        return $response->json($result, $statusCode);
    }

    /**
     * API: Renouveler les tokens
     * POST /api/auth/refresh
     * Body: {refresh_token}
     */
    public function apiRefresh(Requete $requete, Reponse $response)
    {
        $data = $requete->tousCorps();
        $refreshToken = $data['refresh_token'] ?? '';

        if (empty($refreshToken)) {
            $error = APIResponse::erreur('Refresh token requis', [], 422);
            return $response->json($error->json(), 422);
        }

        $result = $this->authService->refreshToken($refreshToken);
        $statusCode = $result['statut'] ?? 200;

        return $response->json($result, $statusCode);
    }

    /**
     * API: Vérifier le token
     * GET /api/auth/verify
     * Header: Authorization: Bearer <token>
     */
    public function apiVerify(Requete $requete, Reponse $response)
    {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? '';

        if (empty($authHeader)) {
            $error = APIResponse::erreur('Token requis', [], 422);
            return $response->json($error->json(), 422);
        }

        // Extraire le token du header "Bearer <token>"
        $parts = explode(' ', $authHeader);
        if (count($parts) !== 2 || $parts[0] !== 'Bearer') {
            $error = APIResponse::erreur('Format de token invalide', [], 401);
            return $response->json($error->json(), 401);
        }

        $token = $parts[1];
        $result = $this->authService->verify($token);
        $statusCode = $result['statut'] ?? 200;

        return $response->json($result, $statusCode);
    }

    /**
     * API: Déconnexion
     * POST /api/auth/logout
     */
    public function apiLogout(Requete $requete, Reponse $response)
    {
        $token = null;
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? '';

        if (!empty($authHeader)) {
            $parts = explode(' ', $authHeader);
            if (count($parts) === 2 && $parts[0] === 'Bearer') {
                $token = $parts[1];
            }
        }

        $result = $this->authService->logout($token);
        $statusCode = $result['statut'] ?? 200;

        return $response->json($result, $statusCode);
    }

    /**
     * Vue de déconnexion (session)
     * GET /logout
     */
    public function logout(Requete $requete, Reponse $response)
    {
        $this->authService->logout(); // Déconnecte l'utilisateur (session)


        // Rediriger vers la page de connexion
        return $response->redirection('/login');
    }
    public function sendActivationEmail(Requete $requete, Reponse $response)
    {
        $email = $requete->tousCorps()['email'] ?? '';

        if (empty($email)) {
            return $response->json(['success' => false, 'message' => 'Email requis'], 422);
        }

        $user = users::ou('email', '=', $email)->premier();

        if (!$user) {
            return $response->json(['success' => false, 'message' => 'Utilisateur non trouvé'], 404);
        }

        $this->companyService->sendActivationToken([
            'id' => $user->id,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'company_id' => $user->company_id,
        ]);

        return $response->json(['success' => true, 'message' => 'Email d\'activation envoyé']);
    }
    /**
     * Page d'inscription entreprise
     * GET /company/register
     */
    public function registerCompanyPage(): string
    {
        return vue('auth.registercompany');
    }

    /**
     * API: Enregistrement nouvelle entreprise
     * POST /api/auth/register-company
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
    public function apiRegisterCompany(Requete $requete, Reponse $response)
    {
        $data = $requete->tousCorps();

        if (empty($data['company_name']) || empty($data['admin_email']) || empty($data['admin_password'])) {
            $error = APIResponse::erreur('Données requises manquantes', [], 422);
            return $response->json($error->json(), 422);
        }

        $result = $this->companyService->registerCompany($data);
        $statusCode = $result['statut'] ?? 200;

        return $response->json($result, $statusCode);
    }
    public function me(Requete $requete, Reponse $response)
    {
        $auth = $this->authService->getAuth();
        $user = $auth->user();

        if (!$user) {
            return $response->json([
                'success' => false,
                'message' => 'Utilisateur non authentifié'
            ], 401);
        }


        $rbac = Users::getUserRolesWithPermissions($user['id']);

        return $response->json([
            'success' => true,
            'user' => [
                'id' => $user['id'],
                'email' => $user['email'],
                'first_name' => $user['first_name'] ?? '',
                'last_name' => $user['last_name'] ?? '',
                'company_id' => $user['company_id'] ?? '',
                'roles' => $rbac['roles'],
                'permissions' => $rbac['permissions'],
                'modules' => $rbac['modules']
            ]
        ]);
    }
}
