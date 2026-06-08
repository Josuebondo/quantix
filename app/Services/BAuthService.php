<?php

namespace App\Services;

use App\Modeles\role;
use App\Modeles\User_role;
use App\Modeles\users;
use Bmvc\BAuth\Adapters\BMVC\BmvcAuthProvider;
use Bmvc\BAuth\Auth;
use Bmvc\BAuth\Config;
use Bmvc\BAuth\Exceptions\AuthenticationException;
use Bmvc\BAuth\Exceptions\UserNotFoundException;
use Bmvc\BAuth\Support\Password;
use Core\Session;

class BAuthService
{
    protected Auth $auth;
    private const ACCESS_TOKEN_EXPIRES = 3600;      // 1 hour
    private const REFRESH_TOKEN_EXPIRES = 604800;   // 7 days

    public function __construct()
    {
        // Étape 1: Créer la configuration
        $config = new Config([
            'jwt' => [
                'secret' => $_ENV['AUTH_JWT_SECRET'] ?? 'dev-secret-change-me',
                'expiresIn' => self::ACCESS_TOKEN_EXPIRES,
                'algorithm' => 'HS256',
            ],
            'password' => [
                'algorithm' => PASSWORD_BCRYPT,
                'options' => ['cost' => 12],
            ],
        ]);

        // Étape 2: Créer l'instance Auth
        $auth = new Auth($config);

        // Étape 3: Configurer l'adaptateur BMVC
        $adapter = new BmvcAuthProvider($config, 'users');
        $auth->setAuthProvider($adapter);

        $this->auth = $auth;
    }

    /**
     * Connexão usuário
     * POST /api/auth/login
     */
    public function login(string $email, string $password): array
    {
        try {
            $v = validateur();
            $v->ajouter('email', ['email', 'requis']);
            $v->ajouter('password', ['min:8', 'requis']);
            if (!$v->valider(['email' => $email, 'password' => $password])) {

                return $this->error($v->premier(), 422, $v->erreurs());
            }



            // Utiliser BAuth pour authentifier
            $user = $this->auth->login($email, $password)['user'] ?? null;
            // dd($user);
            // Extraire les infos utilisateur
            if (!$user) {
                return $this->error('Utilisateur non trouvé', 404);
            }
            if ($user['activation_status'] !== 'activated') {
                return $this->error('Votre compte n\'est pas encore activé. Veuillez vérifier votre email pour le lien d\'activation.', 403);
            }
            $accessToken = $this->auth->getTokenProvider()->generate([
                'user_id' => $user['id'],
                'email' => $user['email'],
            ], self::ACCESS_TOKEN_EXPIRES);

            // Générer un refresh token avec une durée de vie plus longue
            $refreshToken = $this->generateRefreshToken($user['id']);
            $this->auth->getSessionProvider()->start($user, $accessToken);
            return $this->success(
                [
                    'user' => [
                        'id' => $user['id'],
                        'email' => $user['email'],
                        'first_name' => $user['first_name'] ?? '',
                        'last_name' => $user['last_name'] ?? '',
                        'company_id' => $user['company_id'] ?? '',
                    ],
                    'tokens' => [
                        'access_token' => $accessToken,
                        'refresh_token' => $refreshToken,
                        'expires_in' => self::ACCESS_TOKEN_EXPIRES,
                        'token_type' => 'Bearer',
                    ],
                    'redirect_url' => Session::obtenir('url_intended') ?? '/dashboard',
                ],
                'Connexion réussie',
                200
            );
        } catch (UserNotFoundException $e) {
            return $this->error('Utilisateur non trouvé', 404);
        } catch (AuthenticationException $e) {
            return $this->error('Mot de passe incorrect', 401);
        } catch (\Exception $e) {
            return $this->error('Erreur de connexion: ' . $e->getMessage(), 401);
        }
    }

    /**
     * Enregistrement nouvel utilisateur
     * POST /api/auth/register
     */
    public function register(array $userData): array
    {
        // Validation
        $v = validateur();
        $v->ajouter('email', ['email', 'requis']);
        $v->ajouter('password', ['min:8', 'requis']);
        $v->ajouter('first_name', ['requis']);
        $v->ajouter('last_name', ['requis']);
        $v->ajouter('company_id', ['requis']);

        if (!$v->valider($userData)) {
            return $this->error('Validation échouée', 422, $v->erreurs());
        }

        try {
            // Vérifier que l'email n'existe pas déjà
            $existingUser = users::ou('email', '=', $userData['email'])->premier();
            if ($existingUser) {
                return $this->error('Cet email est déjà utilisé', 409);
            }


            // hash du mot de passe
            $userData['password'] = Password::hash($userData['password']);
            // dd($userData);
            // Créer l'utilisateur via l'adaptateur BAuth
            $authProvider = $this->auth->getAuthProvider();
            $createdUser = $authProvider->createUser($userData);

            if (!$createdUser || !isset($createdUser['id'])) {
                return $this->error('Erreur lors de la création de l\'utilisateur', 400);
            }
            $role = role::creer([
                'company_id' => $userData['company_id'],
                'name' => 'owner',
                'code' => 'company.owner',
                'description' => 'les proprietaire de company'
            ]);
            $roleId = $role->id;
            $userRoles = User_role::creer([
                'user_id' => $createdUser['id'],
                'role_id' => $roleId
            ]);
            // Authentifier l'utilisateur nouvellement créé
            try {

                $accessToken = $this->auth->getTokenProvider()->generate([
                    'user_id' => $createdUser['id'],
                    'email' => $createdUser['email'],
                ], self::ACCESS_TOKEN_EXPIRES);
                $this->auth->getSessionProvider()->start($createdUser, $accessToken);
                // dd($loginResult);
            } catch (\Exception $e) {
                return $this->error('Utilisateur créé mais authentification échouée: ' . $e->getMessage(), 400);
            }

            // Générer refresh token
            $refreshToken = $this->generateRefreshToken($createdUser['id']);

            return $this->success(
                [
                    'user' => [
                        'id' => $createdUser['id'],
                        'email' => $createdUser['email'],
                        'first_name' => $userData['first_name'] ?? '',
                        'last_name' => $userData['last_name'] ?? '',
                        'company_id' => $userData['company_id'] ?? '',
                    ],
                    'tokens' => [
                        'access_token' => $accessToken,
                        'refresh_token' => $refreshToken,
                        'expires_in' => self::ACCESS_TOKEN_EXPIRES,
                        'token_type' => 'Bearer',
                    ],
                ],
                'Enregistrement réussi',
                201
            );
        } catch (\Exception $e) {
            return $this->error('Erreur d\'enregistrement: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Renouveler le refresh token
     * POST /api/auth/refresh
     */
    public function refreshToken(string $refreshToken): array
    {
        try {
            // Vérifier le refresh token
            $tokenData = $this->verifyRefreshToken($refreshToken);
            if (!$tokenData) {
                return $this->error('Refresh token invalide ou expiré', 401);
            }

            // Récupérer l'utilisateur
            $userModel = users::trouver($tokenData['user_id']);
            if (!$userModel) {
                return $this->error('Utilisateur non trouvé', 404);
            }

            $user = $userModel->enTableau();

            // Générer un nouvel access token
            $tokenProvider = $this->auth->getTokenProvider();
            $newAccessToken = $tokenProvider->generate([
                'user_id' => $user['id'],
                'email' => $user['email'],
            ], self::ACCESS_TOKEN_EXPIRES);

            // Optionnel: générer un nouveau refresh token
            $newRefreshToken = $this->generateRefreshToken($user['id']);

            return $this->success(
                [
                    'tokens' => [
                        'access_token' => $newAccessToken,
                        'refresh_token' => $newRefreshToken,
                        'expires_in' => self::ACCESS_TOKEN_EXPIRES,
                        'token_type' => 'Bearer',
                    ],
                ],
                'Tokens renouvelés',
                200
            );
        } catch (\Exception $e) {
            return $this->error('Erreur de renouvellement: ' . $e->getMessage(), 401);
        }
    }

    /**
     * Vérifier le token d'accès
     * GET /api/auth/verify
     */
    public function verify(?string $token = null)
    {
        try {
            // Vérifier le token avec BAuth
            $payload = $this->auth->verifyToken($token);

            if (!$payload) {
                return $this->error('Token invalide', 401);
            }

            // Récupérer les infos utilisateur complètes
            $userModel = users::trouver($payload['user_id'] ?? null);
            if (!$userModel) {
                return $this->error('Utilisateur non trouvé', 404);
            }

            $user = $userModel->enTableau();
        } catch (\Exception $e) {
            return $this->error('Token invalide: ' . $e->getMessage(), 401);
        }
    }

    /**
     * Déconnexion
     * POST /api/auth/logout
     */
    public function logout(): array
    {
        try {
            $this->auth->logout();
            return $this->success(
                [],
                'Déconnexion réussie',
                200
            );
        } catch (\Exception $e) {
            return $this->error('Erreur de déconnexion: ' . $e->getMessage(), 400);
        }
    }

    /**
     * Générer un refresh token
     */
    private function generateRefreshToken(string $userId): string
    {
        $tokenProvider = $this->auth->getTokenProvider();

        // Générer un token avec une durée de vie plus longue
        $refreshToken = $tokenProvider->generate(
            [
                'user_id' => $userId,
                'type' => 'refresh',
            ],
            self::REFRESH_TOKEN_EXPIRES
        );

        return $refreshToken;
    }

    /**
     * Vérifier un refresh token
     */
    private function verifyRefreshToken(string $refreshToken): ?array
    {
        try {
            $payload = $this->auth->verifyToken($refreshToken);

            if (!$payload || ($payload['type'] ?? null) !== 'refresh') {
                return null;
            }

            return $payload;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Réponse de succès
     */
    private function success(array $data, string $message = 'Succès', int $statut = 200): array
    {
        return [
            'success' => true,
            'message' => $message,
            'data' => $data,
            'statut' => $statut,
        ];
    }

    /**
     * Réponse d'erreur
     */
    private function error(string $message, int $statut = 400, array $errors = []): array
    {
        return [
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'statut' => $statut,
        ];
    }

    public function getAuth(): Auth
    {
        return $this->auth;
    }
}
