# 🚀 ONBOARDING SAAS QUANTIX - FLOW COMPLET

## 📋 Architecture Globale

```
┌─────────────────────────────────────────────────────────────────┐
│                    EMAIL → ACTIVATION → WIZARD                  │
│                                                                 │
│  1. Email              2. Activation        3. Wizard          │
│  ├─ Token JWT          ├─ Verify token      ├─ Init Session    │
│  └─ Link               ├─ Activate user     ├─ Resume          │
│                        ├─ Create company    ├─ Autosave (x8)   │
│                        └─ /welcome page     └─ Deploy          │
└─────────────────────────────────────────────────────────────────┘
```

---

## 🔴 STEP 1: REGISTRATION (PHP)

### Endpoint

```http
POST /api/auth/register
Content-Type: application/json

{
  "company_name": "Zando Kinshasa",
  "company_email": "info@zando.cd",
  "company_phone": "+243xxx",
  "admin_first_name": "Jean",
  "admin_last_name": "Dupont",
  "admin_email": "jean@zando.cd",
  "admin_password": "SecurePass123!"
}
```

### Ce qui se passe

1. ✅ Créer `company` (status = 0 / inactive)
2. ✅ Créer `user` admin (activation_status = pending)
3. ✅ Générer JWT token
4. ✅ Envoyer email avec lien d'activation

### Response

```json
{
  "success": true,
  "message": "Compte créé. Vérifiez votre email",
  "data": {
    "user": {
      "id": 1,
      "email": "jean@zando.cd",
      "first_name": "Jean"
    },
    "company": {
      "id": 1,
      "name": "Zando Kinshasa",
      "email": "info@zando.cd"
    }
  }
}
```

---

## 🟠 STEP 2: ACTIVATION (User clicks email link)

### Page

```
GET /company/activate?token=eyJhbGc...
```

### Ce qui se passe

1. ✅ Vérifier JWT token
2. ✅ Marquer user comme `activation_status = activated`
3. ✅ Marquer company comme `status = 1` (active)
4. ✅ Rediriger vers `/welcome`

### Backend Flow

```
Token Valid?
├─ YES → Mark user.activated_at = now()
│        Mark company.status = 1
│        Return: { redirectUrl: /welcome }
│
└─ NO → Return error 401
```

---

## 🟡 STEP 3: WELCOME PAGE

### Page

```
GET /welcome
(requires auth)
```

### UI

- Message "Bienvenue Jean!"
- Résumé compte activé
- **CTA Principal**: "Commencer la configuration"
  - Calls: `POST /api/wizard/init`

### Response from /api/wizard/init

```json
{
  "success": true,
  "data": {
    "sessionId": "550e8400-e29b-41d4-a716-446655440000",
    "status": "created",
    "message": "Nouvelle session wizard créée"
  }
}
```

---

## 🟢 STEP 4: WIZARD INITIALIZATION

### Frontend calls

```javascript
POST /api/wizard/init
(auth required)

// No body needed - uses current user session
```

### Backend

1. ✅ Check for existing valid session
   - If exists & resumable → return existing
   - If exists & expired → create new
2. ✅ Create `wizard_sessions` record
3. ✅ Link to user: `user.wizard_session_id`
4. ✅ Return sessionId

### wizard_sessions table created

```
id: 1
wizard_session_id: "550e8400-e29b-41d4-a716-446655440000"
user_id: 1
company_id: null (sera rempli au deploy)
status: "draft"
current_step: 1
state: {...}  (JSON)
created_at: 2024-01-15T10:00:00Z
```

---

## 🔵 STEP 5: WIZARD PAGE LOAD

### Page

```
GET /workspace/setup?session=550e8400-e29b-41d4-a716-446655440000
```

### Frontend first call

```javascript
GET /api/wizard/resume?session=550e8400-e29b-41d4-a716-446655440000
```

### Response

```json
{
  "success": true,
  "data": {
    "sessionId": "550e8400-e29b-41d4-a716-446655440000",
    "step": 1,
    "status": "draft",
    "state": {
      "workspaceName": "",
      "currency": "EUR",
      "categories": [],
      "roles": ["Admin", "Manager"],
      ...
    }
  }
}
```

### Frontend

- Restore state
- Load step 1
- Init autosave (debounce 1500ms)

---

## 💚 STEP 6: WIZARD INTERACTION (Steps 1-7)

### User types in form

```javascript
// Frontend detects change
inputField.addEventListener("input", (e) => {
  WizardController.updateField("workspaceName", e.target.value);
  // Marks dirty + triggers debounced autosave
});
```

### Autosave (every 1.5 sec max)

```http
POST /api/wizard/autosave

{
  "wizardSessionId": "550e8400-e29b-41d4-a716-446655440000",
  "state": {
    "workspaceName": "Zando",
    "currency": "EUR",
    "categories": ["Composants"],
    ...
  },
  "step": 2,
  "dirtyFields": ["workspaceName"]
}
```

### Backend

1. ✅ Find session
2. ✅ Merge state (deep merge)
3. ✅ Update `last_saved_at`
4. ✅ Set `status = in_progress`
5. ✅ Return success

### Response

```json
{
  "success": true,
  "data": {
    "message": "État sauvegardé",
    "lastSavedAt": "2024-01-15T10:05:23Z"
  }
}
```

---

## 💙 STEP 7: FINAL STEP (Step 8)

### User reaches last step

```
Step 8 → "Finaliser"
↓
Show loading animation
↓
Call /api/wizard/deploy
```

### Deploy Call

```http
POST /api/wizard/deploy
X-Idempotency-Key: 550e8400-e29b-41d4-a716-446655440000-deploy-1

{
  "wizardSessionId": "550e8400-e29b-41d4-a716-446655440000",
  "state": {
    "workspaceName": "Zando",
    "currency": "USD",
    "siteName": "Shop Kinshasa",
    "categories": ["Composants", "Accessoires"],
    "roles": ["Admin", "Manager", "Opérateur"],
    "invitations": [
      { "email": "manager@zando.cd", "role": "Manager" }
    ]
  }
}
```

### Backend - DEPLOY SEQUENCE

```
1. Check idempotency key
   ├─ If already deployed → return cached result
   └─ If new → proceed

2. Validate final state
   ├─ workspaceName required
   ├─ siteName required
   ├─ categories required
   └─ Send errors if invalid

3. Create company record
   ├─ name: "Zando"
   ├─ slug: "zando"
   ├─ currency: "USD"
   ├─ status: 1 (active)
   └─ setup_completed_at: now()

4. Update wizard_sessions
   ├─ company_id: 123
   ├─ status: "deployed"
   ├─ idempotency_key: set
   └─ deployment_metadata: save result

5. Create wizard data
   ├─ Sites from state.siteName
   ├─ Categories from state.categories
   ├─ Roles from state.roles
   └─ Send invitations

6. Return result
```

### Response (Success)

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

### Response (Idempotent - Already Deployed)

```json
{
  "success": true,
  "data": {
    "message": "Deployment idempotent - déjà complété",
    "companyId": 123,
    "status": "deployed",
    "metadata": {...}
  }
}
```

---

## 🎯 STEP 8: REDIRECT TO DASHBOARD

### Frontend

```javascript
// After deploy success
window.location.href = "/dashboard?company=zando";
```

### Final Page

```
GET /dashboard?company=zando
(auth required)
```

---

## 📊 DATABASE SCHEMA SUMMARY

### wizard_sessions

```sql
id: BIGINT PK
wizard_session_id: VARCHAR(36) UNIQUE - UUID
user_id: BIGINT FK (users)
company_id: BIGINT FK (company) - NULL until deployed
status: ENUM(draft, in_progress, completed, deployed)
current_step: INT (1-8)
state: LONGTEXT JSON
idempotency_key: VARCHAR(36) UNIQUE
deployment_metadata: LONGTEXT JSON
created_at, updated_at, last_saved_at, deployed_at
```

### activation_tokens

```sql
id: BIGINT PK
user_id: BIGINT FK
token: VARCHAR(255) UNIQUE
status: ENUM(pending, used, expired)
created_at, expires_at, activated_at
```

### users (additions)

```sql
wizard_session_id: VARCHAR(36)
activation_status: ENUM(pending, activated)
activated_at: TIMESTAMP NULL
```

### company (additions)

```sql
setup_completed_at: TIMESTAMP NULL
wizard_session_id: VARCHAR(36)
```

---

## 🔐 Security & Idempotency

### Idempotency Key

```
Format: {uuid}-deploy-{timestamp}

Backend logic:
if (session.idempotency_key === provided_key) {
  if (session.status === 'deployed') {
    return cached_result;
  }
}
```

### Token Expiration

```
JWT expires: 24 hours
wizard_sessions cleanup: 30 days old drafts
```

### Auth Required

- ✅ All /api/wizard/\* endpoints
- ✅ /workspace/setup
- ✅ /dashboard

---

## 📝 ERROR HANDLING

### 401 Unauthorized

```json
{
  "success": false,
  "code": 401,
  "message": "Non authentifié"
}
```

### 404 Session Not Found

```json
{
  "success": false,
  "code": 404,
  "message": "Session wizard introuvable"
}
```

### 410 Session Expired

```json
{
  "success": false,
  "code": 410,
  "message": "Session expirée ou invalide"
}
```

### 422 Validation Error

```json
{
  "success": false,
  "code": 422,
  "message": "État final invalide",
  "errors": [
    "Le nom du workspace est requis",
    "Au moins une catégorie est requise"
  ]
}
```

---

## 🚀 TESTING THE FLOW

### 1. Register

```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "company_name": "Test Company",
    "company_email": "test@company.com",
    "admin_first_name": "Admin",
    "admin_last_name": "User",
    "admin_email": "admin@company.com",
    "admin_password": "Test123456!"
  }'
```

### 2. Activate (with token from email or response)

```bash
curl -X POST http://localhost:8000/api/company/activate \
  -H "Content-Type: application/json" \
  -d '{"token": "eyJhbGc..."}'
```

### 3. Init Wizard

```bash
curl -X POST http://localhost:8000/api/wizard/init \
  -H "Authorization: Bearer {token}"
```

### 4. Resume Wizard

```bash
curl -X GET "http://localhost:8000/api/wizard/resume?session=550e8400-e29b-41d4-a716-446655440000" \
  -H "Authorization: Bearer {token}"
```

### 5. Autosave

```bash
curl -X POST http://localhost:8000/api/wizard/autosave \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {token}" \
  -d '{
    "wizardSessionId": "550e8400-e29b-41d4-a716-446655440000",
    "state": {"workspaceName": "Zando"},
    "step": 1
  }'
```

### 6. Deploy

```bash
curl -X POST http://localhost:8000/api/wizard/deploy \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer {token}" \
  -H "X-Idempotency-Key: 550e8400-e29b-41d4-a716-446655440000-deploy" \
  -d '{
    "wizardSessionId": "550e8400-e29b-41d4-a716-446655440000",
    "state": {...}
  }'
```

---

## ✅ CHECKLIST

- [x] Registration endpoint
- [x] Activation with JWT
- [x] Welcome page
- [x] Wizard init
- [x] Wizard resume
- [x] Autosave debounced
- [x] Generate SKU endpoint
- [x] Deploy with idempotency
- [x] Database schema
- [x] Error handling
- [ ] Create wizard data (sites, roles, etc.)
- [ ] Send invitations
- [ ] Dashboard page
- [ ] Email templates
- [ ] Frontend integration
