<?php

namespace Core\Middlewares;

use Core\APIResponse;
use Core\CSRF;
use Core\Reponse;
use Core\Requete;

use function PHPUnit\Framework\throwException;

/**
 * Middleware CSRF - Protège contre les attaques CSRF
 * Verifie le token CSRF pour les requetes POST/PUT/DELETE/PATCH
 */
class MiddlewareCSRF
{
    /**
     * Verifie le token CSRF pour les requetes POST/PUT/DELETE/PATCH
     */
    public function traiter(Requete $requete, callable $suivant)
    {
        // Ne verifier que pour les methodes dangereuses
        $methode = strtoupper($requete->methode());
        if (!in_array($methode, ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            return $suivant($requete);
        }

        // Recuperer le token CSRF depuis plusieurs sources
        $data = $requete->json() ?? [];
        $token = $requete->entete('X-CSRF-Token')
            ?? $data['csrf_token']
            ?? $requete->obtenir('csrf_token')
            ?? $requete->obtenir('_token')
            ?? null;

        // Verifier le token
        if (!$token || !CSRF::verifier($token)) {
            $reponse = new Reponse();
            $reponse->statut(403);
            $reponse->entete('Content-Type', 'application/json; charset=utf-8');
            $reponse->contenu(json_encode([
                'success' => false,
                'message' => 'Token CSRF invalide ou manquant',
                'code' => 403,
            ], JSON_UNESCAPED_UNICODE));
            $reponse->envoyer();
            return $reponse;
        }

        // Token valide - passer au suivant
        return $suivant($requete);
    }
}
