# 🚀 GUIDE D'IMPLÉMENTATION - ONBOARDING SAAS QUANTIX

## ✅ Ce qui a été fait

### Backend (PHP)

- [x] **Migrations SQL** - Tables `wizard_sessions`, `activation_tokens`
- [x] **Model WizardSession** - Gestion de la session wizard
- [x] **WizardService** - Logique métier (init, resume, autosave, deploy)
- [x] **CompanyService** - Amélioration activation complète
- [x] **CompanyController** - 8 endpoints API complets
  - POST `/api/company/activate` - Activation du compte
  - GET `/api/wizard/init` - Créer session
  - GET `/api/wizard/resume` - Reprendre session
  - POST `/api/wizard/autosave` - Sauvegarder état
  - POST `/api/wizard/deploy` - Finaliser et créer company
  - GET `/api/wizard/permissions` - Charger modules
  - POST `/api/wizard/generate-sku` - Générer SKU
  - GET `/welcome` - Page de bienvenue

### Frontend (JavaScript)

- [x] **Architecture propre** - Triple séparation d'état
  - `wizardSession` - Identifiant unique
  - `wizardDraftState` - Single source of truth
  - `uiState` - État UI uniquement
- [x] **WizardController** - Couche de contrôle
  - `initialize()` - Charger wizard
  - `resumeSession()` - Reprendre depuis backend
  - `updateField()` - Modifier avec dirty check
  - `autosave()` - Sauvegarder avec debounce
  - `generateSKU()` - Générer SKU via API
  - `loadPermissions()` - Charger permissions
  - `deployWizard()` - Finaliser avec idempotency
- [x] **Intégration API** - Tous les endpoints connectés
- [x] **Debounce autosave** - Pas de spam (1.5s)
- [x] **Idempotency** - Deploy sécurisé et répétable

---

## 📋 CHECKLIST D'IMPLÉMENTATION RESTANTE

### Database

- [ ] Exécuter les migrations SQL
- [ ] Vérifier les foreign keys
- [ ] Créer les indexes

### Backend Completion

- [ ] Implémenter `createWizardData()` dans WizardService
  - Créer Sites depuis `state.siteName`
  - Créer Categories depuis `state.categories`
  - Créer Roles depuis `state.roles`
  - Assigner Permissions
- [ ] Implémenter envoi d'invitations (`state.invitations`)
- [ ] Ajouter logging/audit trail
- [ ] Tests unitaires pour WizardService

### Frontend Completion

- [ ] Page `/welcome` - Ajouter CTA pour start wizard
- [ ] Page `/workspace/setup` - Vérifier charge correctement
- [ ] Gestion erreurs réseau
- [ ] Offline support (local storage backup)
- [ ] Mobile responsiveness

### Views/Templates

- [ ] `company/activation.php` - Page d'activation
- [ ] `company/welcome.php` - Page bienvenue
- [ ] `company/configuration_initiale.php` - Vérifier complète
- [ ] `email/activation.php` - Template email

### Routes

- [ ] Ajouter routes dans `routes/web.php`

```php
// Activation
$router->get('/company/activate', 'CompanyController@activate');
$router->post('/api/company/activate', 'CompanyController@apiActivate');

// Welcome
$router->get('/welcome', 'CompanyController@welcome');

// Wizard
$router->post('/api/wizard/init', 'CompanyController@wizardInit');
$router->get('/workspace/setup', 'CompanyController@configurationInitiale');
$router->get('/api/wizard/resume', 'CompanyController@wizardResume');
$router->post('/api/wizard/autosave', 'CompanyController@wizardAutosave');
$router->post('/api/wizard/deploy', 'CompanyController@wizardDeploy');
$router->get('/api/wizard/permissions', 'CompanyController@wizardPermissions');
$router->post('/api/wizard/generate-sku', 'CompanyController@wizardGenerateSku');

// Dashboard
$router->get('/dashboard', 'CompanyController@dashboard');
```

---

## 🧪 TESTING GUIDE

### 1. Registration

```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "company_name": "Test Company",
    "company_email": "company@test.com",
    "company_phone": "+1234567890",
    "admin_first_name": "Jean",
    "admin_last_name": "Dupont",
    "admin_email": "jean@test.com",
    "admin_password": "SecurePass123!"
  }'
```

**Expected Response:**

```json
{
  "success": true,
  "message": "Compte créé",
  "data": {
    "user": { "id": 1, "email": "jean@test.com" },
    "company": { "id": 1, "name": "Test Company" }
  }
}
```

### 2. Activation (Extract token from email or logs)

```bash
# Extract token from database or test email service
DB Query: SELECT token FROM activation_tokens WHERE user_id = 1 LIMIT 1

curl -X POST http://localhost:8000/api/company/activate \
  -H "Content-Type: application/json" \
  -d '{"token": "eyJhbGc..."}'
```

**Expected Response:**

```json
{
  "success": true,
  "data": {
    "userId": 1,
    "email": "jean@test.com",
    "redirectUrl": "/welcome"
  }
}
```

### 3. Check Account Activated

```bash
# In database
SELECT * FROM users WHERE id = 1;
# Should show: activation_status = 'activated', activated_at = NOW()

SELECT * FROM company WHERE id = 1;
# Should show: status = 1
```

### 4. Init Wizard

```bash
curl -X POST http://localhost:8000/api/wizard/init \
  -H "Authorization: Bearer {jwt_token_from_auth}"
```

**Expected Response:**

```json
{
  "success": true,
  "data": {
    "sessionId": "550e8400-e29b-41d4-a716-446655440000",
    "status": "created"
  }
}
```

### 5. Open Wizard

```
Visit: http://localhost:8000/workspace/setup?session=550e8400-e29b-41d4-a716-446655440000
```

Frontend should:

- Call `/api/wizard/resume?session=550e8400...`
- Load state
- Show Step 1

### 6. Autosave Test

```bash
curl -X POST http://localhost:8000/api/wizard/autosave \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "wizardSessionId": "550e8400-e29b-41d4-a716-446655440000",
    "state": {
      "workspaceName": "Zando Kinshasa",
      "currency": "USD"
    },
    "step": 1
  }'
```

**Expected Response:**

```json
{
  "success": true,
  "data": {
    "message": "État sauvegardé",
    "lastSavedAt": "2024-01-15T10:05:23Z"
  }
}
```

### 7. Generate SKU

```bash
curl -X POST http://localhost:8000/api/wizard/generate-sku \
  -H "Content-Type: application/json" \
  -d '{
    "wizardSessionId": "550e8400-e29b-41d4-a716-446655440000",
    "productName": "Workstation",
    "productCategory": "Hardware",
    "skuPrefix": "ZAN"
  }'
```

**Expected Response:**

```json
{
  "success": true,
  "data": {
    "sku": "ZAN-HW-ABC123"
  }
}
```

### 8. Deploy

```bash
curl -X POST http://localhost:8000/api/wizard/deploy \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {token}" \
  -H "X-Idempotency-Key: 550e8400-e29b-41d4-a716-446655440000-deploy" \
  -d '{
    "wizardSessionId": "550e8400-e29b-41d4-a716-446655440000",
    "state": {
      "workspaceName": "Zando",
      "siteName": "Shop Kinshasa",
      "siteType": "point_de_vente",
      "categories": ["Composants", "Accessoires"],
      "roles": ["Admin", "Manager"],
      "currency": "USD",
      "country": "CD",
      "timezone": "Africa/Kinshasa",
      "invitations": [
        {"email": "manager@zando.cd", "role": "Manager"}
      ]
    }
  }'
```

**Expected Response (First Call):**

```json
{
  "success": true,
  "data": {
    "message": "Workspace créé avec succès",
    "companyId": 123,
    "companySlug": "zando",
    "redirectUrl": "/dashboard?company=zando"
  }
}
```

**Expected Response (Idempotent Second Call):**

```json
{
  "success": true,
  "data": {
    "message": "Deployment idempotent - déjà complété",
    "companyId": 123,
    "status": "deployed"
  }
}
```

---

## 🔍 DEBUGGING

### Enable Logging

```php
// In WizardService, CompanyService
logger()->info('Action', ['data' => $var]);
```

### Check Database

```sql
-- Voir toutes les sessions wizard
SELECT * FROM wizard_sessions;

-- Voir une session spécifique
SELECT * FROM wizard_sessions WHERE wizard_session_id = 'abc123';

-- Voir l'état JSON
SELECT wizard_session_id, status, current_step, state FROM wizard_sessions;

-- Vérifier les activations
SELECT * FROM activation_tokens WHERE user_id = 1;
```

### Browser Console

```javascript
// Log wizard state
wizardInfo();

// See all state
console.log(wizardDraftState);
console.log(wizardSession);
console.log(uiState);

// Monitor autosave
// Look for [API] logs
```

---

## 🚀 PERFORMANCE TIPS

### 1. Optimize autosave

- Current: 1500ms debounce ✅
- Consider: 2000ms for slower networks

### 2. Database indexes

```sql
-- Déjà créés mais vérifier
SHOW INDEX FROM wizard_sessions;

-- Si manquant:
CREATE INDEX idx_wizard_session_id ON wizard_sessions(wizard_session_id);
CREATE INDEX idx_user_id ON wizard_sessions(user_id);
```

### 3. JSON compression

State peut devenir gros. Considérer:

- Gzip compression
- Incremental updates (seulement les champs dirty)

### 4. Cache

- Frontend: LocalStorage backup
- Backend: Redis cache pour sessions fréquentes

---

## 🔐 SECURITY CHECKLIST

- [x] JWT token expiration (24h)
- [x] Session wizard cleanup (30 jours)
- [x] Idempotency key pour deploy
- [x] Auth required sur tous /api/wizard/\*
- [ ] Rate limiting sur endpoints
- [ ] CSRF token validation
- [ ] Input sanitization/validation
- [ ] Logging d'audit complet

---

## 📊 MONITORING

### Events à logger

1. **User Registration**

```
event: user.registered
data: {user_id, company_id, email}
```

2. **Account Activation**

```
event: user.activated
data: {user_id, timestamp}
```

3. **Wizard Init**

```
event: wizard.initialized
data: {session_id, user_id}
```

4. **Wizard Autosave**

```
event: wizard.autosaved
data: {session_id, step, dirty_fields_count}
```

5. **Wizard Deploy**

```
event: wizard.deployed
data: {session_id, company_id, duration_ms}
```

---

## 🎯 NEXT STEPS

### Phase 1: Finalize (Today)

- [ ] Add routes
- [ ] Run migrations
- [ ] Create views
- [ ] Test full flow

### Phase 2: Enhancement (This week)

- [ ] Implement `createWizardData()`
- [ ] Send invitations
- [ ] Add validation on frontend
- [ ] Mobile optimization

### Phase 3: Production (Next week)

- [ ] Error handling & recovery
- [ ] Monitoring & logging
- [ ] Rate limiting
- [ ] Analytics tracking
- [ ] A/B testing

---

## 📞 SUPPORT

Pour questions ou problèmes :

1. Vérifier logs: `storage/logs/`
2. Vérifier database state
3. Check browser console
4. Test avec curl commands
