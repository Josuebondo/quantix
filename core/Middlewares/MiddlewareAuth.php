<?php

namespace Core\Middlewares;

use Core\Requete;
use Core\Reponse;
use Core\Session;

/**
 * MiddlewareAuth - Vérifie si l'utilisateur est authentifié
 * Redirige vers la page de connexion si non authentifié
 */
class MiddlewareAuth
{
    public function traiter(Requete $request, callable $next): Reponse
    {
        // dd(auth()->isAuthenticated());
        if (!auth()->isAuthenticated()) {
            //garder le route demandé pour redirection après login
            Session::enregistrer('url_intended', $request->url());
            // Rediriger vers la page de connexion
            redirection('/login');
        }

        return $next($request);
    }
}
