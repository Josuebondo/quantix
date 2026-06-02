<?php

/**
 * Helpers pour l'authentification - Utilise BAuth
 * Fonctions utilitaires simplifiées utilisant la librairie BAuth
 */

use App\Services\BAuthService;
use App\Modeles\users;
use Bmvc\BAuth\Providers\JWTProvider;
use Bmvc\BAuth\Config;

/**
 * Obtenir le service d'authentification
 */
function auth(): BAuthService
{
    return new BAuthService();
}

/**
 * Vérifier si l'utilisateur est authentifié
 */
function estAuthentifie(): bool
{
    try {
        $jwtProvider = getJWTProvider();
        $token = $jwtProvider->extractFromRequest();
        return $token && $jwtProvider->verify($token) !== null;
    } catch (\Exception $e) {
        return false;
    }
}

/**
 * Obtenir l'utilisateur actuel
 */
function utilisateurActuel(): ?users
{
    try {
        $jwtProvider = getJWTProvider();
        $token = $jwtProvider->extractFromRequest();
        if (!$token) return null;

        $decoded = $jwtProvider->verify($token);
        if (!$decoded || !isset($decoded['user_id'])) return null;

        return users::parId($decoded['user_id']);
    } catch (\Exception $e) {
        return null;
    }
}

/**
 * Obtenir l'ID utilisateur actuel
 */
function idUtilisateur(): ?string
{
    return utilisateurActuel()?->donnees['id'] ?? null;
}

/**
 * Obtenir l'email utilisateur actuel
 */
function emailUtilisateur(): ?string
{
    return utilisateurActuel()?->donnees['email'] ?? null;
}

/**
 * Vérifier si l'utilisateur a une permission
 */
function aLaPermission(string $permission): bool
{
    $user = utilisateurActuel();
    if (!$user) return false;

    foreach ($user->obtenirPermissions() as $perm) {
        if ($perm['code'] === $permission) return true;
    }
    return false;
}

/**
 * Vérifier si l'utilisateur a un rôle
 */
function aLeRole(string $role): bool
{
    $user = utilisateurActuel();
    if (!$user) return false;

    foreach ($user->obtenirRoles() as $r) {
        if ($r['name'] === $role) return true;
    }
    return false;
}

/**
 * Exiger l'authentification
 */
function exigerAuth(): void
{
    if (!estAuthentifie()) {
        header('Content-Type: application/json');
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Authentification requise', 'status' => 401]);
        exit;
    }
}

/**
 * Exiger une permission
 */
function exigerPermission(string $permission): void
{
    exigerAuth();
    if (!aLaPermission($permission)) {
        header('Content-Type: application/json');
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Permission refusée', 'status' => 403]);
        exit;
    }
}

/**
 * Exiger un rôle
 */
function exigerRole(string $role): void
{
    exigerAuth();
    if (!aLeRole($role)) {
        header('Content-Type: application/json');
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Rôle requis: ' . $role, 'status' => 403]);
        exit;
    }
}

/**
 * Obtenir le JWT Provider de BAuth
 */
function getJWTProvider(): JWTProvider
{
    $config = new Config([
        'jwt' => [
            'secret' => env('AUTH_JWT_SECRET') ?? 'your-secret-key-change-in-env',
            'algorithm' => 'HS256',
        ],
    ]);
    return new JWTProvider($config);
}

/**
 * Obtenir le token actuel
 */
function tokenActuel(): ?string
{
    return getJWTProvider()->extractFromRequest();
}

/**
 * Obtenir l'authorization header
 */
function getAuthHeader(): ?array
{
    $token = tokenActuel();
    if (!$token) return null;

    return [
        'Authorization' => 'Bearer ' . $token,
        'Content-Type' => 'application/json'
    ];
}
