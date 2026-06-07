<?php

/**
 * ======================================================================
 * Helpers - Fonctions Globales
 * ======================================================================
 * 
 * Fonctions utilitaires disponibles partout dans l'application
 */

if (!function_exists('env')) {
    /**
     * Obtient une variable d'environnement depuis le fichier .env
     */
    function env(string $cle, mixed $default = null): mixed
    {
        return \Core\Env::obtenir($cle, $default);
    }
}
if (!function_exists('config')) {
    /**
     * Obtient une valeur de configuration
     */
    function config(string $cle, mixed $default = null): mixed
    {
        $app = $GLOBALS['application'] ?? null;
        if (!$app) {
            return $default;
        }
        return $app->config($cle, $default);
    }
}

if (!function_exists('chemin')) {
    /**
     * Obtient un chemin de l'application
     */
    function chemin(string $cle): string
    {
        $app = $GLOBALS['application'] ?? null;
        if (!$app) {
            return '';
        }
        return $app->chemin($cle);
    }
}

if (!function_exists('url')) {
    /**
     * Génère une URL
     */
    function url(string $chemin = ''): string
    {
        $baseUrl = env('URL_APPLICATION', 'http://localhost');
        return rtrim($baseUrl, '/') . '/' . ltrim($chemin, '/');
    }
}

if (!function_exists('vue')) {
    /**
     * Crée et rend une vue
     */
    function vue(string $vue, array $donnees = []): string
    {
        $app = $GLOBALS['application'] ?? null;
        if (!$app) {
            return '';
        }
        $vueInstance = new \Core\Vue($app->chemin('vues'));
        return $vueInstance->rendre($vue, $donnees);
    }
}

if (!function_exists('redirection')) {
    /**
     * Redirige vers une URL
     */
    function redirection(string $url, int $statut = 302): void
    {
        $app = $GLOBALS['application'] ?? null;
        if ($app) {
            $app->reponse()->redirection($url, $statut);
        }
    }
}

if (!function_exists('json')) {
    /**
     * Retourne une réponse JSON
     */
    function json(array $donnees, int $statut = 200): void
    {
        $app = $GLOBALS['application'] ?? null;
        if ($app) {
            $app->reponse()->json($donnees, $statut);
        }
    }
}

if (!function_exists('dd')) {
    /**
     * Debug et dump avec die
     */
    function dd(mixed ...$vars): void
    {
        echo '<pre style="background: #f5f5f5; padding: 15px; border-radius: 4px; font-family: monospace;">';
        foreach ($vars as $var) {
            var_dump($var);
        }
        echo '</pre>';
        die();
    }
}

if (!function_exists('dump')) {
    /**
     * Dump sans die
     */
    function dump(mixed ...$vars): void
    {
        echo '<pre style="background: #f5f5f5; padding: 15px; border-radius: 4px; font-family: monospace;">';
        foreach ($vars as $var) {
            var_dump($var);
        }
        echo '</pre>';
    }
}

if (!function_exists('debut_section')) {
    /**
     * Débute une section de vue
     */
    function debut_section(string $nom): void
    {
        \Core\Vue::debut_section($nom);
    }
}

if (!function_exists('fin_section')) {
    /**
     * Termine une section de vue
     */
    function fin_section(string $nom): void
    {
        \Core\Vue::fin_section($nom);
    }
}

if (!function_exists('section')) {
    /**
     * Affiche le contenu d'une section
     */
    function section(string $nom, string $defaut = ''): void
    {
        \Core\Vue::section($nom, $defaut);
    }
}

if (!function_exists('etendre')) {
    /**
     * Définit le layout parent
     */
    function etendre(string $layout): void
    {
        \Core\Vue::extends($layout);
    }
}

if (!function_exists('e')) {
    /**
     * Échappe une valeur (protection XSS)
     */
    function e($valeur): string
    {
        return \Core\Vue::e($valeur);
    }
}

if (!function_exists('input')) {
    /**
     * Obtient un input POST/GET
     */
    function input(string $cle, $defaut = null)
    {
        return $_REQUEST[$cle] ?? $defaut;
    }
}

if (!function_exists('ancien')) {
    /**
     * Obtient une valeur ancien input
     */
    function ancien(string $cle, $defaut = ''): string
    {
        return htmlspecialchars($_SESSION['anciens_inputs'][$cle] ?? $defaut, ENT_QUOTES, 'UTF-8');
    }
}
if (!function_exists('session')) {
    /**
     * Accès à la session
     */
    function session(): \Core\Session
    {
        return new \Core\Session();
    }
}
if (!function_exists('deny')) {
    /**
     * garder erreur  à la session
     */
    function deny(array $data)
    {

        return \Core\Session::enregistrer('403', $data);
    }
}


if (!function_exists('generate_sku')) {

    /**
     * Générer un SKU unique
     */
    function generate_sku(
        string $name = 'PROD',
        string $category = 'GEN',
        string $prefix = 'SKU',
        int $randomLength = 6
    ): string {

        $nameCode = make_sku_code($name, 3);
        $catCode  = make_sku_code($category, 3);

        $random = strtoupper(substr(bin2hex(random_bytes(10)), 0, $randomLength));

        return "{$prefix}-{$nameCode}{$catCode}-{$random}";
    }
}

if (!function_exists('make_sku_code')) {

    /**
     * Génère un code court depuis un texte
     */
    function make_sku_code(string $text, int $length = 3): string
    {
        $text = preg_replace('/[^a-zA-Z]/', '', $text);

        if (empty($text)) {
            return strtoupper(substr(bin2hex(random_bytes(2)), 0, $length));
        }

        return strtoupper(substr($text, 0, $length));
    }
}
if (!function_exists('maskEmail')) {
    function maskEmail(string $email): string
    {
        [$name, $domain] = explode('@', $email);

        if (strlen($name) <= 3) {
            $name = substr($name, 0, 1) . str_repeat('*', max(1, strlen($name) - 1));
        } else {
            $name = substr($name, 0, 3) . str_repeat('*', strlen($name) - 3);
        }

        return $name . '@' . $domain;
    }
}
if (!function_exists('flash')) {
    /**
     * Récupère un message flash
     */
    function flash(?string $type = null): ?string
    {
        if ($type === null) {
            $flash = $_SESSION['flash'] ?? [];
            unset($_SESSION['flash']);
            return !empty($flash) ? current($flash) : null;
        }

        $message = $_SESSION['flash'][$type] ?? null;
        unset($_SESSION['flash'][$type]);
        return $message;
    }
}

if (!function_exists('url')) {
    /**
     * Génère une URL de l'application
     */
    function url(string $chemin = ''): string
    {
        $base = getenv('URL_APPLICATION') ?: 'http://localhost';
        return $base . '/' . ltrim($chemin, '/');
    }
}

if (!function_exists('asset')) {
    /**
     * Génère l'URL publique d'un asset (CSS/JS/images)
     * Exemple: asset('css/app.css') => http://monsite/css/app.css
     */
    function asset(string $chemin = ''): string
    {
        $chemin = ltrim($chemin, '/');
        $base = getenv('URL_APPLICATION') ?: '';
        if ($base) {
            return rtrim($base, '/public/') . '/' . $chemin;
        }
        // Par défaut, retourner un chemin relatif depuis la racine publique
        return '/' . $chemin;
    }
}

if (!function_exists('auth')) {
    /**
     * Obtient le service d'authentification
     */

    function auth()
    {
        $bauth =  new \App\Services\BAuthService();
        return $bauth->getAuth();
    }
}
if (!function_exists('route')) {
    /**
     * Génère une URL à partir du nom d'une route
     */
    function route(string $nom, array $params = []): string
    {
        $app = $GLOBALS['application'] ?? null;
        if (!$app) {
            return '';
        }
        return $app->routeur()->genererUrl($nom, $params);
    }
}

if (!function_exists('est_connecte')) {
    /**
     * Vérifie si l'utilisateur est connecté
     */
    function est_connecte(): bool
    {
        return \Core\Auth::connecte();
    }
}

if (!function_exists('est_admin')) {
    /**
     * Vérifie si l'utilisateur est admin
     */
    function est_admin(): bool
    {
        return \Core\Auth::estAdmin();
    }
}

if (!function_exists('csrf_token')) {
    /**
     * Récupère le token CSRF
     */
    function csrf_token(): string
    {
        return \Core\CSRF::token();
    }
}

if (!function_exists('now')) {
    /**
     * Retourne la date/heure actuelle (format ISO 8601)
     */
    function now(): string
    {
        return date('Y-m-d H:i:s');
    }
}

if (!function_exists('diffInDays')) {
    /**
     * Calcule la différence en jours entre deux dates
     */
    function diffInDays(string $date1, string $date2): int
    {
        $d1 = new \DateTime($date1);
        $d2 = new \DateTime($date2);
        return abs($d2->diff($d1)->days);
    }
}

if (!function_exists('uuid')) {
    /**
     * Génère un UUID v4 (aléatoire)
     */
    function uuid(): string
    {
        // Si PHP 8.1+, utiliser la fonction native
        if (function_exists('\random_bytes')) {
            $bytes = random_bytes(16);
            $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40); // Version 4
            $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80); // Variant 10
            return implode('-', [
                bin2hex(substr($bytes, 0, 4)),
                bin2hex(substr($bytes, 4, 2)),
                bin2hex(substr($bytes, 6, 2)),
                bin2hex(substr($bytes, 8, 2)),
                bin2hex(substr($bytes, 10, 6))
            ]);
        }

        // Fallback sur uniqid (moins fiable mais compatible)
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}

if (!function_exists('logger')) {
    /**
     * Instance du logger pour enregistrer les événements
     */
    function logger()
    {
        static $logger = null;
        if ($logger === null) {
            // Créer un logger simple basé sur les fichiers
            $logger = new class {
                private string $logDir = __DIR__ . '/../storage/logs';

                public function info(string $message, array $context = []): void
                {
                    $this->log('info', $message, $context);
                }

                public function warning(string $message, array $context = []): void
                {
                    $this->log('warning', $message, $context);
                }

                public function error(string $message, array $context = []): void
                {
                    $this->log('error', $message, $context);
                }

                public function debug(string $message, array $context = []): void
                {
                    $this->log('debug', $message, $context);
                }

                private function log(string $level, string $message, array $context = []): void
                {
                    if (!is_dir($this->logDir)) {
                        mkdir($this->logDir, 0755, true);
                    }

                    $logFile = $this->logDir . '/' . date('Y-m-d') . '.log';
                    $timestamp = date('Y-m-d H:i:s');
                    $contextStr = !empty($context) ? ' ' . json_encode($context) : '';
                    $logEntry = "[{$timestamp}] {$level}: {$message}{$contextStr}\n";

                    file_put_contents($logFile, $logEntry, FILE_APPEND);
                }
            };
        }

        return $logger;
    }
}

if (!function_exists('csrf_input')) {
    /**
     * Génère un input CSRF
     */
    function csrf_input(): string
    {
        return \Core\CSRF::input();
    }
}

if (!function_exists('flash')) {
    /**
     * Enregistre un message flash
     */
    function flash(string $type, string $message): void
    {
        if (!isset($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }
        $_SESSION['flash'][$type] = $message;
    }
}

if (!function_exists('ancien')) {
    /**
     * Récupère une ancienne valeur d'input
     */
    function ancien(string $cle, string $default = ''): string
    {
        $anciens = $_SESSION['anciens_inputs'] ?? [];
        return htmlspecialchars($anciens[$cle] ?? $default, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('validateur')) {
    /**
     * Crée une nouvelle instance de Validateur
     */
    function validateur(): \Core\Validateur
    {
        return new \Core\Validateur();
    }
}

if (!function_exists('notification')) {
    /**
     * Obtient le service de notification
     */
    function notification(): \App\Services\NotificationService
    {
        static $service;
        if (!$service) {
            $service = new \App\Services\NotificationService();
        }
        return $service;
    }
}

if (!function_exists('upload')) {
    /**
     * Obtient le service d'upload
     */
    function upload(): \App\Services\UploadService
    {
        static $service;
        if (!$service) {
            $service = new \App\Services\UploadService();
        }
        return $service;
    }
}

if (!function_exists('auth_service')) {
    /**
     * Obtient le service d'authentification
     */
    function auth_service(): \App\Services\BAuthService
    {
        static $service;
        if (!$service) {
            $service = new \App\Services\BAuthService();
        }
        return $service;
    }
}

if (!function_exists('validation_service')) {
    /**
     * Obtient le service de validation
     */
    function validation_service(): \App\Services\ValidationService
    {
        static $service;
        if (!$service) {
            $service = new \App\Services\ValidationService();
        }
        return $service;
    }
}
if (!function_exists('fichier_url')) {
    /**
     * Génère l'URL d'un fichier dans le dossier storage
     */
    function fichier_url(string $chemin_fichier): string
    {
        $baseUrl = env('URL_APPLICATION', 'http://localhost');
        $chemin_fichier = ltrim($chemin_fichier, '/');
        return rtrim($baseUrl, '/') . '/storage/' . $chemin_fichier;
    }
}

if (!function_exists('menu_image_url')) {
    /**
     * Génère l'URL d'une image de menu
     * Gère à la fois les chemins complets et les noms de fichiers simples
     */
    function menu_image_url(?string $image): ?string
    {
        if (!$image) {
            return null;
        }

        // Utiliser StorageManager pour générer l'URL
        return \Core\Storage\StorageManager::url($image);
    }
}

if (!function_exists('log_app')) {
    /**
     * Log applicatif (info/debug)
     */
    function log_app(string $message, string $type = 'INFO'): void
    {
        \Core\GestionnaireErreurs::log($message, $type);
    }
}
if (!function_exists('generer_uuid')) {
    /**
     * Génère un UUID v4 (aléatoire)
     * Format: 550e8400-e29b-41d4-a716-446655440000
     */
    function generer_uuid(): string
    {
        $data = random_bytes(16);

        // Définir la version à 4 et le variant à RFC 4122
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}

if (!function_exists('log')) {
    /**
     * Log applicatif (info/debug)
     */
    function log(string $message, string $type = 'INFO'): void
    {
        \Core\GestionnaireErreurs::log($message, $type);
    }
}
if (!function_exists('q')) {
    /**
     * Log applicatif (info/debug)
     */
    function q(): void
    {
        exit();
    }
}

if (!function_exists('inclure')) {
    /**
     * Inclut une vue partielle et retourne son contenu
     */
    function inclure(string $vue, array $donnees = []): string
    {
        $app = $GLOBALS['application'] ?? null;
        if (!$app) {
            return '';
        }
        $vueInstance = new \Core\Vue($app->chemin('vues'));
        return $vueInstance->inclure($vue, $donnees);
    }
}
