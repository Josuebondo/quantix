<?php

namespace Core\Middlewares;

use Bmvc\BAuth\Providers\JWTProvider;
use Bmvc\BAuth\Config;
use Core\Requete;
use Core\APIResponse;

/**
 * Middleware d'authentification JWT utilisant BAuth
 * Utilise JWTProvider de BAuth pour validation simplifiée
 */
class MiddlewareJWTAuth
{
    private JWTProvider $jwtProvider;

    public function __construct()
    {
        $config = new Config([
            'jwt' => [
                'secret' => $_ENV['AUTH_JWT_SECRET'] ?? 'dev-secret-change-me',
                'algorithm' => 'HS256',
            ],
        ]);
        $this->jwtProvider = new JWTProvider($config);
    }

    public function traiter(Requete $requete, \Closure $suivant)
    {
        try {
            $token = $this->jwtProvider->extractFromRequest();
            if (!$token) {
                return $this->reponseNonAutorisee('Token requis');
            }

            $decoded = $this->jwtProvider->verify($token);
            if (!$decoded) {
                return $this->reponseNonAutorisee('Token invalide');
            }


            return $suivant($requete);
        } catch (\Exception $e) {
            return $this->reponseNonAutorisee('Token expiré ou invalide: ' . $e->getMessage());
        }
    }

    private function reponseNonAutorisee(string $message): void
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(401);

        $response = [
            'success' => false,
            'message' => $message,
            'statut' => 401,
        ];

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
