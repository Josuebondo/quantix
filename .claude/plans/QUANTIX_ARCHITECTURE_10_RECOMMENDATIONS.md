# 🏗️ Plan: Implémentation des 10 Recommandations Architecturales Quantix

## Context

Quantix a actuellement un flux d'onboarding fonctionnel mais qui mérite d'être optimisé selon les standards SaaS professionnels. Les 10 recommandations visent à:

1. **Clarifier la séparation des responsabilités** (Activation vs Onboarding vs Workspace)
2. **Corriger la logique d'activation** (vérification en cascade)
3. **Ajouter login automatique** après activation
4. **Réutiliser les sessions existantes** correctement
5. **Éviter la création double de Company**
6. **Ajouter l'atomicité** avec transactions SQL
7. **Utiliser last_saved_at** pour l'expiration
8. **Éviter double vérification JWT**
9. **Ajouter setup_step et setup_completed_at** pour tracking
10. **Maintenir l'idempotence** (déjà bien fait)

---

## Phase 1: Préparation (Base de Données)

### 1.1 Migration SQL - Ajouter les champs manquants

**Fichier**: Créer `databases/migrations/add_setup_tracking_to_companies.sql`

```sql
ALTER TABLE company ADD COLUMN (
    setup_step INT DEFAULT 0,
    setup_completed_at TIMESTAMP NULL
);

-- Mappe les valeurs existantes
UPDATE company SET setup_step = COALESCE(setup_step, 0);
```

**Raison**: Suivre précisément où l'utilisateur s'arrête dans le wizard (étapes 1-8, puis 100=complet)

### 1.2 Vérifier les champs d'activation

**Fichier**: `app/Modeles/users.php`

- Confirmer que `is_activated` (int 0/1) et `activated_at` (timestamp) existent
- **NE PAS** utiliser `activation_status` (enum) - garder consistance

---

## Phase 2: Services de Métier

### 2.1 Modifier CompanyService

**Fichier**: `app/Services/CompanyService.php`

#### Changement 2.1a: Séparer registerCompany et activateUserAccount

**Actuellement**:
- `registerCompany()` crée Company + User
- `activateUserAccount()` vérifie et... ne fait rien avec la Company existante

**À faire**:
1. `registerCompany()` continue à créer Company et User
2. `activateUserAccount()` UNIQUEMENT:
   - Vérifie le token JWT
   - Active le user (`is_activated = 1`, `activated_at = now()`)
   - LOGIN AUTOMATIQUE (`$this->authService->login($user)`)
   - Retourne les données de l'utilisateur

```php
public function activateUserAccount(string $token): array {
    // 1. Verify token
    $jwt = $this->authService->getAuth()->getTokenProvider();
    $verified = $jwt->verify($token);
    if (!$verified) return error('Token invalid', 401);

    // 2. Decode & get user
    $decoded = $jwt->verify($token);
    $user = users::where('id', $decoded['user_id'])->first();
    if (!$user) return error('User not found', 404);

    // 3. Already activated?
    if ($user->is_activated === 1) {
        return success([
            'userId' => $user->id,
            'message' => 'Account already activated',
            'redirect' => $this->getRedirectAfterActivation($user)
        ]);
    }

    // 4. Activate user
    $user->is_activated = 1;
    $user->activated_at = now();
    $user->save();

    // 5. AUTO-LOGIN
    $loginResult = $this->authService->login($user->email, ''); // No password needed
    // OR: auth()->login($user);

    return success([
        'userId' => $user->id,
        'user' => $user->toArray(),
        'tokens' => $loginResult['data']['tokens'] ?? null,
        'redirect' => $this->getRedirectAfterActivation($user)
    ]);
}

// Helper: Détermine où rediriger après activation
private function getRedirectAfterActivation($user): string {
    $company = company::find($user->company_id);
    
    if ($company->setup_completed_at) {
        return '/dashboard';
    }
    
    return '/welcome'; // Go to wizard
}
```

#### Changement 2.1b: Ajouter NO PASSWORD LOGIN

La fonction BAuthService->login() nécessite un password. Créer une méthode pour login sans password:

```php
// Dans BAuthService
public function loginUser($user): array {
    // Create token without password verification
    $payload = [
        'user_id' => $user->id,
        'email' => $user->email,
    ];
    
    $accessToken = $this->getAuth()
        ->getTokenProvider()
        ->generate($payload, 3600);
    
    $refreshToken = $this->getAuth()
        ->getTokenProvider()
        ->generate($payload, 604800);
    
    return [
        'success' => true,
        'data' => [
            'user' => $user,
            'tokens' => [
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
                'expires_in' => 3600,
                'token_type' => 'Bearer'
            ]
        ]
    ];
}
```

---

### 2.2 Modifier WizardService

**Fichier**: `app/Services/WizardService.php`

#### Changement 2.2a: Corriger initializeWizard - Réutiliser session existante

```php
public function initializeWizard(?array $user): array {
    $userId = $user['id'] ?? $user->id ?? null;
    if (!$userId) return error('Invalid user', 400);

    // Check if session exists and can be resumed
    $existing = WizardSession::where('user_id', $userId)
        ->whereIn('status', ['draft', 'in_progress'])
        ->first();

    if ($existing && $existing->canBeResumed()) {
        return success([
            'sessionId' => $existing->wizard_session_id,
            'status' => 'resumed',
            'step' => $existing->current_step,
            'message' => 'Session restored'
        ]);
    }

    // Create NEW session only if can't resume
    $sessionId = uuid();
    $session = WizardSession::create([
        'wizard_session_id' => $sessionId,
        'user_id' => $userId,
        'company_id' => null,
        'status' => 'draft',
        'current_step' => 1,
        'state' => json_encode($this->getDefaultState()),
        'last_saved_at' => now() // Initialize for expiration tracking
    ]);

    return success([
        'sessionId' => $sessionId,
        'status' => 'created',
        'message' => 'New wizard session created'
    ]);
}
```

#### Changement 2.2b: deployWizard - Ajouter transaction SQL

```php
public function deployWizard(string $sessionId, array $finalState, string $idempotencyKey): array {
    $session = WizardSession::findBySessionId($sessionId);
    if (!$session) return error('Session not found', 404);

    // Check idempotency FIRST
    if ($session->idempotency_key === $idempotencyKey && $session->status === 'deployed') {
        return success([
            'message' => 'Already deployed (idempotent)',
            'companyId' => $session->company_id,
            'status' => 'deployed'
        ]);
    }

    try {
        DB::beginTransaction();

        // 1. Update Company (NOT create - company already exists from registration)
        $company = company::find($session->company_id);
        if (!$company) throw new \Exception('Company not found');

        // 2. Create wizard data (sites, categories, etc)
        $this->createWizardData($session, $finalState);

        // 3. Mark company as setup complete
        $company->setup_step = 100;
        $company->setup_completed_at = now();
        $company->save();

        // 4. Mark session as deployed
        $session->status = 'deployed';
        $session->idempotency_key = $idempotencyKey;
        $session->deployed_at = now();
        $session->save();

        DB::commit();

        return success([
            'message' => 'Deployment successful',
            'companyId' => $company->id,
            'status' => 'deployed'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return error('Deployment failed: ' . $e->getMessage(), 500);
    }
}
```

#### Changement 2.2c: createWizardData - Implémenter la logique

```php
private function createWizardData(WizardSession $session, array $state): void {
    $companyId = $session->company_id;

    // 1. Create Sites
    if (!empty($state['siteName'])) {
        Site::create([
            'company_id' => $companyId,
            'name' => $state['siteName'],
            'type' => $state['siteType'] ?? 'depot',
            'address' => $state['siteAddress'] ?? '',
        ]);
    }

    // 2. Create Categories
    if (!empty($state['categories'])) {
        foreach ($state['categories'] as $catName) {
            Category::create([
                'company_id' => $companyId,
                'name' => $catName,
            ]);
        }
    }

    // 3. Create Roles
    if (!empty($state['roles'])) {
        foreach ($state['roles'] as $roleName) {
            Role::create([
                'company_id' => $companyId,
                'name' => $roleName,
            ]);
        }
    }

    // 4. Send invitations
    if (!empty($state['invitations'])) {
        foreach ($state['invitations'] as $invitation) {
            // Send email avec lien d'invitation
        }
    }
}
```

---

## Phase 3: Contrôleurs

### 3.1 Modifier CompanyController

**Fichier**: `app/Controleurs/CompanyController.php`

#### Changement 3.1a: Simplifier activate()

```php
public function activate(Requete $requete, Reponse $response) {
    $token = $requete->obtenir('token');

    if (!$token) {
        return vue('company.activation', [
            'error' => 'Missing token',
            'message' => 'Activation link is invalid or expired',
        ]);
    }

    $result = $this->companyService->activateUserAccount($token);

    if (!$result['success']) {
        return vue('company.activation', [
            'error' => 'Activation failed',
            'message' => $result['message'],
        ]);
    }

    // User is now logged in (auto-login done in activateUserAccount)
    // Redirect to appropriate page
    $redirectUrl = $result['data']['redirect'] ?? '/welcome';
    return redirection($redirectUrl);
}
```

#### Changement 3.1b: configurationInitiale() - Utiliser les vraies données

Vous avez déjà fait ce changement! ✅

---

## Phase 4: Logique de Vérification

### 4.1 Corriger la logique d'activation dans welcome/wizard

**Fichier**: Ajouter middleware ou check au niveau du contrôleur

```php
public function welcome(Requete $requete, Reponse $response) {
    $user = auth()->user();
    
    // Check 1: User activated?
    if (!$user->is_activated) {
        return redirection('/activate');
    }

    // Check 2: Setup completed?
    $company = company::find($user->company_id);
    
    if ($company->setup_completed_at) {
        return redirection('/dashboard');
    }

    // Go to wizard
    return vue('company.welcome', [
        'user' => $user,
        'company' => $company,
    ]);
}
```

---

## Phase 5: Frontend

### 5.1 Mettre à jour config_initiale.js

- ✅ Déjà fait (vous utilisez les vraies données)

### 5.2 Afficher le setup_step dans le wizard

```javascript
// Initialiser à partir du backend
const currentStep = BACKEND_CURRENT_STEP || 1;
const setupStep = BACKEND_SETUP_STEP || 1;

// Afficher progression "Étape 4/8" basée sur setup_step réel
```

---

## Phase 6: Test & Validation

### Test Flow Complet

```
1. INSCRIPTION
   - POST /api/auth/register
   - ✅ Company créée (setup_step = 0)
   - ✅ User créé (is_activated = 0)
   - ✅ Email d'activation envoyé

2. ACTIVATION
   - GET /company/activate?token=xyz
   - ✅ Token vérifié
   - ✅ User activé (is_activated = 1)
   - ✅ Login automatique
   - ✅ Redirect vers /welcome

3. WELCOME
   - GET /welcome
   - ✅ User authentifié
   - ✅ Setup not complete → Afficher CTA "Start Setup"

4. WIZARD INIT
   - POST /api/wizard/init
   - ✅ Créer/reprendre session (last_saved_at = now)

5. WIZARD FORM
   - GET /workspace/setup?session=xyz
   - ✅ Charger l'état existant
   - ✅ POST /api/wizard/autosave (debounced)

6. WIZARD DEPLOY
   - POST /api/wizard/deploy
   - ✅ Transaction SQL
   - ✅ Créer sites, catégories, rôles
   - ✅ setup_step = 100
   - ✅ setup_completed_at = now()
   - ✅ Marquer session deployed

7. DASHBOARD
   - GET /dashboard
   - ✅ Setup complété → Afficher dashboard complet
```

---

## Fichiers à Modifier (Priorité)

| Priority | Fichier | Changes |
|----------|---------|---------|
| 🔴 HIGH | `app/Services/CompanyService.php` | activateUserAccount(), NO PASSWORD LOGIN |
| 🔴 HIGH | `app/Services/WizardService.php` | deployWizard() + transactions |
| 🔴 HIGH | `app/Services/BAuthService.php` | loginUser() method |
| 🟡 MED | `app/Controleurs/CompanyController.php` | Simplify activate() |
| 🟡 MED | `databases/migrations/...` | Add setup_step + setup_completed_at |
| 🟡 MED | `app/Modeles/WizardSession.php` | ✅ Already fixed diffInDays |
| 🟢 LOW | Views & JS | Already updated |

---

## Avantages de cette Architecture

✅ **Separation of Concerns** - Activation ≠ Onboarding ≠ Workspace  
✅ **Atomicité** - Transactions SQL pour data consistency  
✅ **Idempotence** - Redeploy safe  
✅ **Progression Tracking** - setup_step pour reprendre  
✅ **Session Resilience** - last_saved_at pour expiration  
✅ **Professional UX** - Auto-login + clear flow  
✅ **SaaS Production-Ready** - Comme Notion, Stripe Atlas, Odoo  

---

## Estimated Effort

- CompanyService: 2h
- WizardService: 2h
- BAuthService: 1h
- Controllers: 30m
- Database: 30m
- Testing: 2h
- **Total: ~8 hours**

---

## Validation Checklist

- [ ] All 10 recommendations implemented
- [ ] No Company created twice
- [ ] Auto-login after activation works
- [ ] Wizard session can be resumed
- [ ] Transactions rollback on error
- [ ] setup_step tracks correctly
- [ ] last_saved_at used for expiration
- [ ] No double JWT verification
- [ ] End-to-end flow tested
- [ ] Idempotency key validated
