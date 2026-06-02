<?php

namespace Core;

use Closure as Fermeture;

/**
 * ======================================================================
 * ROUTEUR - Gestion avancee des routes avec support complet des middlewares
 * ======================================================================
 *
 * Fonctionnalites :
 * - Support HTTP: GET, POST, PUT, DELETE, PATCH
 * - Parametres dynamiques: /utilisateur/{id}
 * - Middlewares multiples par route avec gestion avancee
 * - Groupes de routes avec prefixes et middlewares
 * - Nommage des routes
 * - Middlewares globaux, par route, par groupe
 * - Chainage et gestion des priorites
 * - Introspection des middlewares
 */
class Routeur
{
    protected static array $routes = [];
    protected static array $groupes = [];
    protected static string $prefixeActuel = '';
    protected static array $middlewaresActuels = [];
    protected static array $middlewaresGlobaux = [];
    protected static array $prioritesMiddlewares = [];

    // ========================================================================
    // METHODES DE REGISTRATION DES ROUTES
    // ========================================================================

    /**
     * Enregistre une route GET
     */
    public static function obtenir(string $chemin, $action): Route
    {
        return self::enregistrer('GET', $chemin, $action);
    }

    /**
     * Enregistre une route POST
     */
    public static function publier(string $chemin, $action): Route
    {
        return self::enregistrer('POST', $chemin, $action);
    }

    /**
     * Enregistre une route PUT
     */
    public static function mettre(string $chemin, $action): Route
    {
        return self::enregistrer('PUT', $chemin, $action);
    }

    /**
     * Enregistre une route DELETE
     */
    public static function supprimer(string $chemin, $action): Route
    {
        return self::enregistrer('DELETE', $chemin, $action);
    }

    /**
     * Enregistre une route PATCH
     */
    public static function patcher(string $chemin, $action): Route
    {
        return self::enregistrer('PATCH', $chemin, $action);
    }

    /**
     * Enregistre une route pour toutes les methodes
     */
    public static function tous(string $chemin, $action): array
    {
        return [
            self::obtenir($chemin, $action),
            self::publier($chemin, $action),
            self::mettre($chemin, $action),
            self::supprimer($chemin, $action),
            self::patcher($chemin, $action),
        ];
    }

    /**
     * Enregistre une route avec methode specifiee
     */
    protected static function enregistrer(string $methode, string $chemin, $action): Route
    {
        $chemin = self::$prefixeActuel . $chemin;

        $route = new Route($methode, $chemin, $action);

        // Ajouter les middlewares du groupe
        foreach (self::$middlewaresActuels as $middleware) {
            $route->middleware($middleware);
        }

        self::$routes[] = $route;
        return $route;
    }

    // ========================================================================
    // GESTION DES MIDDLEWARES GLOBAUX
    // ========================================================================

    /**
     * Ajoute un middleware global (applique a toutes les routes)
     * Optionnel: $priorite (0 = plus haute priorite)
     */
    public static function middlewareGlobal($middleware, ?int $priorite = null): void
    {
        if (!in_array($middleware, self::$middlewaresGlobaux, true)) {
            self::$middlewaresGlobaux[] = $middleware;

            if ($priorite !== null) {
                self::$prioritesMiddlewares[spl_object_id($middleware)] = $priorite;
            }
        }
    }

    /**
     * Ajoute plusieurs middlewares globaux a la fois
     */
    public static function middlewaresGlobaux(array $middlewares): void
    {
        foreach ($middlewares as $middleware) {
            self::middlewareGlobal($middleware);
        }
    }

    /**
     * Supprime un middleware global
     */
    public static function supprimerMiddlewareGlobal($middleware): bool
    {
        $key = array_search($middleware, self::$middlewaresGlobaux, true);
        if ($key !== false) {
            unset(self::$middlewaresGlobaux[$key]);
            unset(self::$prioritesMiddlewares[spl_object_id($middleware)]);
            return true;
        }
        return false;
    }

    /**
     * Obtient tous les middlewares globaux
     */
    public static function obtenirMiddlewaresGlobaux(): array
    {
        return self::$middlewaresGlobaux;
    }

    /**
     * Vide tous les middlewares globaux
     */
    public static function viderMiddlewaresGlobaux(): void
    {
        self::$middlewaresGlobaux = [];
        self::$prioritesMiddlewares = [];
    }

    // ========================================================================
    // GESTION DES GROUPES DE ROUTES
    // ========================================================================

    /**
     * Groupe de routes avec prefixe et middlewares
     */
    public static function groupe(array $options, Fermeture $callback): void
    {
        $prefixePrecedent = self::$prefixeActuel;
        $middlewaresPrecedents = self::$middlewaresActuels;

        // Appliquer le prefixe
        if (isset($options['prefixe'])) {
            self::$prefixeActuel = $prefixePrecedent . '/' . trim($options['prefixe'], '/');
        }

        // Appliquer les middlewares
        if (isset($options['middlewares'])) {
            $middlewares = is_array($options['middlewares']) ? $options['middlewares'] : [$options['middlewares']];
            self::$middlewaresActuels = array_merge(self::$middlewaresActuels, $middlewares);
        }

        // Executer le callback
        $callback();

        // Restaurer l'etat precedent
        self::$prefixeActuel = $prefixePrecedent;
        self::$middlewaresActuels = $middlewaresPrecedents;
    }

    // ========================================================================
    // DISPATCHER ET EXECUTION
    // ========================================================================

    /**
     * Dispatcher la requete et executer la route correspondante
     */
    public function dispatcher(Requete $requete, Reponse $reponse): void
    {
        $methode = $requete->methode();
        $chemin = $requete->chemin();

        // Trouver la route correspondante
        $route = $this->trouverRoute($methode, $chemin);

        if ($route === null) {
            throw new \Core\Exceptions\HttpNotFoundException("Page non trouvee: $chemin");
        }

        // Recuperer tous les middlewares (globaux + route)
        $middlewares = array_merge(self::$middlewaresGlobaux, $route->obtenirMiddlewares());
        $middlewares = $this->trierMiddlewares($middlewares);

        $index = 0;

        $suivant = function (Requete $req) use (&$index, $middlewares, $route, $reponse, &$suivant): Reponse {
            if ($index >= count($middlewares)) {
                $this->executerRoute($route, $req, $reponse);
                return $reponse;
            }

            $middleware = $middlewares[$index++];

            if ($middleware instanceof Fermeture) {
                $resultat = $middleware($req, $suivant);
                return $resultat instanceof Reponse ? $resultat : $reponse;
            }

            if (is_string($middleware)) {
                $classeMiddleware = class_exists($middleware) ? $middleware : "Core\\Middlewares\\$middleware";

                if (!class_exists($classeMiddleware)) {
                    throw new \Exception("Middleware non trouve: $classeMiddleware");
                }

                $instance = new $classeMiddleware();

                if (!method_exists($instance, 'traiter')) {
                    throw new \Exception("Methode traiter() introuvable sur le middleware: $classeMiddleware");
                }

                $resultat = $instance->traiter($req, $suivant);
                return $resultat instanceof Reponse ? $resultat : $reponse;
            }

            // si un tables envoyer dans le middleware
            if (is_array($middleware)) {
                foreach ($middleware as $mw) {
                    $classeMiddleware = class_exists($mw) ? $mw : "Core\\Middlewares\\$mw";

                    if (!class_exists($classeMiddleware)) {
                        throw new \Exception("Middleware non trouve: $classeMiddleware");
                    }

                    $instance = new $classeMiddleware();

                    if (!method_exists($instance, 'traiter')) {
                        throw new \Exception("Methode traiter() introuvable sur le middleware: $classeMiddleware");
                    }

                    $resultat = $instance->traiter($req, $suivant);
                    if ($resultat instanceof Reponse) {
                        return $resultat;
                    }
                }
                return $reponse;
            }

            throw new \Exception('Type de middleware invalide.');
        };

        $suivant($requete);
    }

    /**
     * Trie les middlewares selon leur priorite
     */
    protected function trierMiddlewares(array $middlewares): array
    {
        usort($middlewares, function ($a, $b) {
            $prioriteA = self::$prioritesMiddlewares[spl_object_id($a)] ?? PHP_INT_MAX;
            $prioriteB = self::$prioritesMiddlewares[spl_object_id($b)] ?? PHP_INT_MAX;
            return $prioriteA <=> $prioriteB;
        });
        return $middlewares;
    }

    /**
     * Trouve une route correspondant a la requete
     */
    protected function trouverRoute(string $methode, string $chemin): ?Route
    {
        foreach (self::$routes as $route) {
            if ($route->obtenirMethode() === $methode && $route->correspond($chemin)) {
                return $route;
            }
        }
        return null;
    }

    /**
     * Execute une route
     */
    protected function executerRoute(Route $route, Requete $requete, Reponse $reponse): void
    {
        $action = $route->obtenirAction();

        if (is_string($action)) {
            $this->executerControleur($action, $requete, $reponse, $route->obtenirParametres());
        } elseif ($action instanceof Fermeture) {
            call_user_func_array($action, [$requete, $reponse, $route->obtenirParametres()]);
        }
    }

    /**
     * Execute un controleur
     */
    protected function executerControleur(string $action, Requete $requete, Reponse $reponse, array $parametres): void
    {
        [$controleur, $methode] = explode('@', $action);

        $classe = "App\\Controleurs\\$controleur";

        if (!class_exists($classe)) {
            throw new \Exception("Controleur non trouve: $classe");
        }

        $instance = new $classe();

        if (!method_exists($instance, $methode)) {
            throw new \Exception("Methode non trouvee: $classe@$methode");
        }

        $reflexion = new MethodeReflexion($instance, $methode);
        $params = [];

        foreach ($reflexion->obtenirParametres() as $param) {
            $type = $param->getType();

            if ($type && $type->getName() === Requete::class) {
                $params[] = $requete;
            } elseif ($type && $type->getName() === Reponse::class) {
                $params[] = $reponse;
            } else {
                $nomParam = $param->getName();
                $params[] = $parametres[$nomParam] ?? null;
            }
        }

        $result = call_user_func_array([$instance, $methode], $params);

        if (is_string($result)) {
            echo $result;
        }
    }

    // ========================================================================
    // INTROSPECTION DES ROUTES
    // ========================================================================

    /**
     * Obtient toutes les routes enregistrees
     */
    public static function obtenirRoutes(): array
    {
        return self::$routes;
    }

    /**
     * Trouve une route par son nom
     */
    public static function trouverParNom(string $nom): ?Route
    {
        foreach (self::$routes as $route) {
            if ($route->obtenirNom() === $nom) {
                return $route;
            }
        }
        return null;
    }

    /**
     * Trouve une route par son action
     */
    public static function trouverParAction(string $action): ?Route
    {
        foreach (self::$routes as $route) {
            if ($route->obtenirAction() === $action) {
                return $route;
            }
        }
        return null;
    }

    /**
     * Obtient les middlewares d'une route
     */
    public static function obtenirMiddlewaresRoute(string $nom): array
    {
        $route = self::trouverParNom($nom);
        if ($route) {
            return $route->obtenirMiddlewares();
        }
        return [];
    }

    /**
     * Obtient les middlewares d'une action
     */
    public static function obtenirMiddlewaresAction(string $action): array
    {
        $route = self::trouverParAction($action);
        if ($route) {
            return $route->obtenirMiddlewares();
        }
        return [];
    }

    /**
     * Verifie si une route a un middleware specifique
     */
    public static function aMiddleware(string $nom, $middleware): bool
    {
        $middlewares = self::obtenirMiddlewaresRoute($nom);
        return in_array($middleware, $middlewares, true);
    }

    /**
     * Compte le nombre de middlewares pour une route
     */
    public static function compterMiddlewares(string $nom): int
    {
        return count(self::obtenirMiddlewaresRoute($nom));
    }

    /**
     * Liste toutes les routes avec leurs middlewares
     */
    public static function listerRoutesAvecMiddlewares(): array
    {
        $resultat = [];
        foreach (self::$routes as $route) {
            $resultat[] = [
                'methode' => $route->obtenirMethode(),
                'chemin' => $route->obtenirChemin(),
                'action' => $route->obtenirAction(),
                'nom' => $route->obtenirNom(),
                'middlewares' => $route->obtenirMiddlewares(),
                'nombre_middlewares' => count($route->obtenirMiddlewares()),
            ];
        }
        return $resultat;
    }

    // ========================================================================
    // GENERATION D'URL
    // ========================================================================

    /**
     * Genere une URL a partir du nom de la route et des parametres
     */
    public static function genererUrl(string $nom, array $parametres = []): string
    {
        $route = self::trouverParNom($nom);

        if ($route === null) {
            throw new \Exception("Route non trouvee pour le nom: $nom");
        }

        $chemin = $route->obtenirChemin();

        foreach ($parametres as $cle => $valeur) {
            $chemin = str_replace('{' . $cle . '}', $valeur, $chemin);
        }

        return $chemin;
    }

    /**
     * Genere une URL complete avec le domaine
     */
    public static function genererUrlComplete(string $nom, array $parametres = [], bool $https = true): string
    {
        $schema = $https ? 'https' : 'http';
        $domaine = $_SERVER['HTTP_HOST'] ?? 'localhost';
        return $schema . '://' . $domaine . self::genererUrl($nom, $parametres);
    }

    // ========================================================================
    // UTILITAIRES
    // ========================================================================

    /**
     * Applique un middleware a toutes les routes correspondant a une action
     */
    public static function appliquerMiddlewareAction(string $action, $middleware): int
    {
        $count = 0;
        foreach (self::$routes as $route) {
            if (str_contains($route->obtenirAction(), $action)) {
                $route->middleware($middleware);
                $count++;
            }
        }
        return $count;
    }

    /**
     * Applique un middleware a toutes les routes d'une methode HTTP specifique
     */
    public static function appliquerMiddlewareMethode(string $methode, $middleware): int
    {
        $count = 0;
        foreach (self::$routes as $route) {
            if ($route->obtenirMethode() === strtoupper($methode)) {
                $route->middleware($middleware);
                $count++;
            }
        }
        return $count;
    }

    /**
     * Applique un middleware a toutes les routes commencant par un prefixe
     */
    public static function appliquerMiddlewarePrefixe(string $prefixe, $middleware): int
    {
        $count = 0;
        foreach (self::$routes as $route) {
            if (str_starts_with($route->obtenirChemin(), $prefixe)) {
                $route->middleware($middleware);
                $count++;
            }
        }
        return $count;
    }

    /**
     * Obtient des statistiques sur les routes et middlewares
     */
    public static function obtenirStatistiques(): array
    {
        $totalRoutes = count(self::$routes);
        $totalMiddlewaresGlobaux = count(self::$middlewaresGlobaux);
        $totalMiddlewaresRoutes = 0;

        foreach (self::$routes as $route) {
            $totalMiddlewaresRoutes += count($route->obtenirMiddlewares());
        }

        $methodes = [];
        foreach (self::$routes as $route) {
            $methode = $route->obtenirMethode();
            $methodes[$methode] = ($methodes[$methode] ?? 0) + 1;
        }

        return [
            'total_routes' => $totalRoutes,
            'total_middlewares_globaux' => $totalMiddlewaresGlobaux,
            'total_middlewares_routes' => $totalMiddlewaresRoutes,
            'distribution_methodes' => $methodes,
            'moyenne_middlewares_par_route' => $totalRoutes > 0 ? $totalMiddlewaresRoutes / $totalRoutes : 0,
        ];
    }

    /**
     * Reinitialise tous les parametres du routeur
     */
    public static function reinitialiser(): void
    {
        self::$routes = [];
        self::$groupes = [];
        self::$prefixeActuel = '';
        self::$middlewaresActuels = [];
        self::$middlewaresGlobaux = [];
        self::$prioritesMiddlewares = [];
    }
}
