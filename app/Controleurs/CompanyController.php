<?php

namespace App\Controleurs;

use App\BaseControleur;
use App\Modeles\permission;
use App\Services\CompanyService;
use App\Services\WizardService;
use Core\Reponse;
use Core\Requete;

/**
 * CompanyController - Gère l'onboarding SaaS complet
 */
class CompanyController extends BaseControleur
{
    private CompanyService $companyService;
    private WizardService $wizardService;

    public function __construct()
    {
        $this->companyService = new CompanyService();
        $this->wizardService = new WizardService();
    }

    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * ACTIVATION FLOW
     * ═══════════════════════════════════════════════════════════════════════════
     */

    /**
     * GET /company/activate?token=abc123
     * Page d'activation - Utilisateur clique le lien depuis l'email
     */
    public function activate(Requete $requete, Reponse $response)
    {
        $token = $requete->obtenir('token');
        // dd($token);
        if (!$token) {
            return vue('company.setup_error', [
                'status' => 'error',
                'title' => 'Token manquant',
                'message' => 'Le lien d\'activation est invalide ou a expiré. Veuillez réessayer.',
            ]);
        }

        // Appeler le endpoint d'activation
        $result = $this->companyService->activateUserAccount($token);
        // dd($result);
        // Cas d'erreur (token invalide, expiré, etc.)
        if (!$result['success']) {
            return vue('company.setup_error', [
                'status' => 'error',
                'title' => 'Activation échouée',
                'message' => $result['message'],
            ]);
        }
        // cas où le compte est déjà activé

        // Success: afficher page de bienvenue
        return vue('company.activation', [
            'status' => 'success',
            'title' => 'Activation réussie',
            'message' => 'Compte activé avec succès !',
            'redirectUrl' => $result['data']['redirectUrl'],
            'email' => $result['data']['user']['email'],
            'first_name' => $result['data']['user']['first_name'],
            'last_name' => $result['data']['user']['last_name'],
            'name' => $result['data']['user']['first_name'] . ' ' . $result['data']['user']['last_name'],
            'user' => $result['data']['user'],
            'company' => $result['data']['company'],
        ]);
    }

    /**
     * POST /api/company/activate
     * Endpoint d'activation (appelé via AJAX ou form POST)
     */
    public function apiActivate(Requete $requete, Reponse $response)
    {
        $token = $requete->obtenir('token') ?? '';

        $result = $this->companyService->activateUserAccount($token);

        return $response->json($result, $result['code'] ?? 200);
    }

    /**
     * GET /welcome
     * Page de bienvenue après activation
     */
    public function welcome(Requete $requete, Reponse $response)
    {
        // Utilisateur doit être authentifié  
        //gere par midleware


        $user = auth()->user();

        return vue('company.welcome', [
            'user' => $user,
            'company' => is_array($user) ? ($user['company'] ?? null) : ($user->company ?? null),
        ]);
    }

    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * WIZARD INITIALIZATION
     * ═══════════════════════════════════════════════════════════════════════════
     */

    /**
     * POST /api/wizard/init
     * Initialiser une nouvelle session wizard (ou reprendre existante)
     */
    public function wizardInit(Requete $requete, Reponse $response)
    {


        $authUser = auth()->user();
        if (!$authUser) {
            return $response->json([
                'success' => false,
                'message' => 'Utilisateur non valide',
            ], 401);
        }

        $result = $this->wizardService->initializeWizard($authUser);

        return $response->json($result, $result['code'] ?? 200);
    }

    /**
     * GET /workspace/setup?session=abc123
     * Page du wizard d'onboarding
     */
    public function configurationInitiale(Requete $requete, Reponse $response)
    {


        $sessionId = $requete->obtenir('session');
        $user = auth()->user();
        if (!$sessionId) {
            // Pas de session ID, initialiser une nouvelle session wizard
            $initResult = $this->wizardService->initializeWizard($user);
            if (!$initResult['success']) {
                return vue('company.setup_error', [
                    'status' => 'error',
                    'title' => 'Erreur d\'initialisation de la configuration',
                    'message' => $initResult['message'],
                ]);
            }

            $sessionId = $initResult['data']['sessionId'] ?? null;
            if (!$sessionId) {
                return vue('company.setup_error', [
                    'status' => 'error',
                    'title' => 'Session de configuration introuvable',
                    'message' => 'Impossible de démarrer la configuration. Veuillez réessayer.',
                ]);
            }
        }
        // Fetch real wizard session data from backend
        $wizardData = $this->wizardService->resumeWizard($sessionId);

        return vue('company.configuration_initiale', [
            'sessionId' => $sessionId,
            'user' => $user,
            'wizardData' => $wizardData, // Pass real backend data
            'currentStep' => $wizardData['success'] ? ($wizardData['data']['step'] ?? 1) : 1,
            'wizardState' => $wizardData['success'] ? ($wizardData['data']['state'] ?? []) : [],
        ]);
    }

    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * WIZARD ENDPOINTS
     * ═══════════════════════════════════════════════════════════════════════════
     */

    /**
     * GET /api/wizard/resume?session=abc123
     * Reprendre une session wizard existante
     */
    public function wizardResume(Requete $requete, Reponse $response)
    {


        $sessionId = $requete->obtenir('session') ?? '';

        if (!$sessionId) {
            return $response->json([
                'success' => false,
                'message' => 'Session ID manquant',
            ], 400);
        }

        $result = $this->wizardService->resumeWizard($sessionId);

        return $response->json($result, $result['code'] ?? 200);
    }

    /**
     * POST /api/wizard/autosave
     * Sauvegarder l'état du wizard (appelé fréquemment avec debounce)
     */
    public function wizardAutosave(Requete $requete, Reponse $response)
    {

        $data = $requete->tousCorps();

        $sessionId = $data['wizardSessionId'] ?? '';
        $state = $data['state'] ?? [];
        $step = $data['step'] ?? 1;
        $dirtyFields = $data['dirtyFields'] ?? null;

        if (!$sessionId) {
            return $response->json([
                'success' => false,
                'message' => 'Session ID manquant',
            ], 400);
        }

        $result = $this->wizardService->autosaveState($sessionId, $state, $step, $dirtyFields);

        return $response->json($result, $result['statut'] ?? 200);
    }

    /**
     * POST /api/wizard/deploy
     * Finaliser le wizard et créer le workspace
     * IDEMPOTENT: X-Idempotency-Key header
     */
    public function wizardDeploy(Requete $requete, Reponse $response)
    {
        if (!auth()->isAuthenticated()) {
            return $response->json([
                'success' => false,
                'message' => 'Non authentifié',
            ], 401);
        }

        $data = $requete->json();
        $headers = $requete->headers();

        $sessionId = $data['wizardSessionId'] ?? '';
        $finalState = $data['state'] ?? [];
        $idempotencyKey = $headers['X-Idempotency-Key'] ?? '';

        if (!$sessionId || !$finalState || !$idempotencyKey) {
            return $response->json([
                'success' => false,
                'message' => 'Données manquantes',
                'required' => ['wizardSessionId', 'state', 'X-Idempotency-Key header'],
            ], 400);
        }

        $result = $this->wizardService->deployWizard($sessionId, $finalState, $idempotencyKey);

        return $response->json($result, $result['code'] ?? 200);
    }

    /**
     * ═══════════════════════════════════════════════════════════════════════════
     * WIZARD HELPER ENDPOINTS
     * ═══════════════════════════════════════════════════════════════════════════
     */

    /**
     * GET /api/wizard/permissions
     * Récupérer les modules de permissions disponibles depuis la DB
     */
    public function wizardPermissions(Requete $requete, Reponse $response)
    {
        try {
            // Récupérer toutes les permissions depuis la table et les convertir en tableaux
            $allPermissions = permission::ou('id', '>', 0)->obtenir();
            if (!$allPermissions) {
                throw new \Exception('Aucune permission trouvée');
            }

            // Convertir les modèles en tableaux simples pour consommation JS
            $permissions = array_map(function ($p) {
                return is_object($p) && method_exists($p, 'enTableau') ? $p->enTableau() : (array)$p;
            }, $allPermissions);

            // Extraire les modules uniques depuis les permissions
            $modules = [];
            foreach ($permissions as $perm) {
                $module = $perm['module'] ?? null;
                if ($module && !in_array($module, $modules)) {
                    $modules[] = $module;
                }
            }

            if (empty($modules)) {
                // Si pas de modules, retourner liste par défaut
                $modules = ['Inventaire', 'Sites', 'Commandes', 'Analyses', 'Utilisateurs'];
            } else {
                sort($modules);
            }

            return $response->json([
                'success' => true,
                'data' => $modules,
                'permissions' => $permissions,
            ]);
        } catch (\Exception $e) {
            // Retourner liste par défaut en cas d'erreur
            return $response->json([
                'success' => true,
                'data' => ['Inventaire', 'Sites', 'Commandes', 'Analyses', 'Utilisateurs'],
                'permissions' => [],
            ]);
        }
    }

    /**
     * POST /api/wizard/generate-sku
     * Générer un SKU unique
     */
    public function wizardGenerateSku(Requete $requete, Reponse $response)
    {
        $data = $requete->tousCorps();

        $productName = $data['productName'] ?? 'PROD';
        $productCategory = $data['productCategory'] ?? 'GEN';
        $skuPrefix = $data['skuPrefix'] ?? 'SKU-';

        // Génération simple
        $sku = generate_sku($productName, $productCategory, $skuPrefix);

        return $response->json([
            'success' => true,
            'data' => [
                'sku' => $sku,
            ],
        ]);
    }

    /**
     * GET /dashboard (placeholder)
     * Page dashboard après setup complet
     */
    public function dashboard(Requete $requete, Reponse $response)
    {

        $user = auth()->user();

        return vue('dashboard.index', [
            'user' => $user,
        ]);
    }
}
