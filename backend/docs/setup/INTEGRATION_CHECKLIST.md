# ✅ WIZARD ONBOARDING - INTEGRATION CHECKLIST

## 1. DATABASE MIGRATION

**File**: `databases_migrations_wizard.sql`

**Status**: ✅ Ready to execute

**Action**:

```bash
# Execute migration file
mysql -u root -p quantix < databases_migrations_wizard.sql

# Verify tables created
mysql -u root -p quantix -e "SHOW TABLES LIKE 'wizard%';"
```

**Expected Output**:

```
Tables_in_quantix (wizard%)
wizard_sessions
activation_tokens
```

---

## 2. ADD ROUTES TO web.php

**File**: `routes/web.php`

**Status**: 🟡 Needs manual addition

**Action**: Add these lines to `routes/web.php` at the end:

```php
/**
 * ═══════════════════════════════════════════════════════════════════════════
 * WIZARD ONBOARDING - SaaS Flow Routes
 * ═══════════════════════════════════════════════════════════════════════════
 */

// Activation Flow
$router->get('/company/activate', 'CompanyController@activate');
$router->post('/api/company/activate', 'CompanyController@apiActivate');

// Welcome & Onboarding Start
$router->get('/welcome', 'CompanyController@welcome');

// Wizard Initialization & State Management
$router->post('/api/wizard/init', 'CompanyController@wizardInit');
$router->get('/workspace/setup', 'CompanyController@configurationInitiale');

// Wizard API Endpoints
$router->get('/api/wizard/resume', 'CompanyController@wizardResume');
$router->post('/api/wizard/autosave', 'CompanyController@wizardAutosave');
$router->post('/api/wizard/deploy', 'CompanyController@wizardDeploy');

// Wizard Helper Endpoints
$router->get('/api/wizard/permissions', 'CompanyController@wizardPermissions');
$router->post('/api/wizard/generate-sku', 'CompanyController@wizardGenerateSku');

// Post-Deployment
$router->get('/dashboard', 'CompanyController@dashboard');
```

---

## 3. VERIFY BACKEND FILES

**Status**: ✅ All files created/updated

### Files to Check

- [x] `app/Modeles/WizardSession.php` - ✅ Created
- [x] `app/Services/WizardService.php` - ✅ Created
- [x] `app/Services/CompanyService.php` - ✅ Updated
- [x] `app/Controleurs/CompanyController.php` - ✅ Updated

**Verification**:

```bash
# Check files exist
ls -la app/Modeles/WizardSession.php
ls -la app/Services/WizardService.php
ls -la app/Services/CompanyService.php
ls -la app/Controleurs/CompanyController.php

# Verify no syntax errors
php -l app/Modeles/WizardSession.php
php -l app/Services/WizardService.php
php -l app/Services/CompanyService.php
php -l app/Controleurs/CompanyController.php
```

---

## 4. VERIFY FRONTEND FILES

**Status**: ✅ All updated

### Files to Check

- [x] `public/js/company/config/config_initiale.js` - ✅ Updated
  - `init()` is now async
  - `WizardController.initialize()` called on load
  - `WizardController.resumeSession()` fetches state from backend
  - Debounce autosave integrated

**Verification**:

```bash
# Check syntax
node --check public/js/company/config/config_initiale.js

# Or in browser console (after page load):
# Type: wizardInfo()
# Should see wizard state logged
```

---

## 5. VERIFY VIEWS

**Status**: 🟡 Partial

### Files to Check

| File                              | Status     | Notes                    |
| --------------------------------- | ---------- | ------------------------ |
| `app/Vues/company/activation.php` | ⚠️ Exists  | May need verification    |
| `app/Vues/company/welcome.php`    | ✅ Created | Ready                    |
| `app/Vues/email/activation.php`   | ✅ Updated | Now uses $activationLink |

**Verification**:

```bash
# Check files exist and have content
wc -l app/Vues/company/welcome.php
# Should be > 50 lines

wc -l app/Vues/email/activation.php
# Should be > 100 lines
```

---

## 6. CONFIGURATION CHECK

**Status**: 🟡 Verify these are configured

### Environment Variables

```bash
# .env file should have:
JWT_SECRET=your_secret_key_here
MAIL_FROM_ADDRESS=noreply@quantix.com
MAIL_FROM_NAME=Quantix
```

### JWT Token Configuration

**File**: `config/app.php` or wherever JWT config lives

**Needed**:

```php
'jwt' => [
    'secret' => env('JWT_SECRET'),
    'expiration' => 86400, // 24 hours
    'activation_token_expiration' => 86400, // 24 hours
]
```

---

## 7. NAMESPACE & AUTOLOADING

**Status**: ✅ Check if needed

**If using namespaces**, ensure:

```php
// app/Modeles/WizardSession.php
namespace App\Modeles;

// app/Services/WizardService.php
namespace App\Services;

// app/Controleurs/CompanyController.php
namespace App\Controleurs;

// In composer.json autoload section
"psr-4": {
    "App\\": "app/"
}
```

Then run:

```bash
composer dump-autoload
```

---

## 8. TEST CONFIGURATION

**Status**: 🟡 Ready for testing

### Prerequisites

- [ ] Database migrated
- [ ] Routes added
- [ ] JWT secret configured
- [ ] Mail service configured
- [ ] All files exist with no syntax errors

### Minimal Test

```bash
# 1. Check API is reachable
curl http://localhost:8000/api/wizard/permissions

# 2. Check activation page loads
curl http://localhost:8000/company/activate?token=test

# 3. Check welcome page loads
curl http://localhost:8000/welcome

# 4. Check wizard page loads (needs session ID)
curl http://localhost:8000/workspace/setup?session=test-uuid
```

---

## 9. DATABASE VERIFICATION

**Status**: 🟡 Needs manual check

After migration, verify:

```sql
-- Check wizard_sessions table
DESCRIBE wizard_sessions;

-- Check activation_tokens table
DESCRIBE activation_tokens;

-- Check users table modifications
DESCRIBE users;
-- Should have: wizard_session_id, activation_status, activated_at

-- Check company table modifications
DESCRIBE company;
-- Should have: setup_completed_at, wizard_session_id
```

Expected user columns:

```
Field                   | Type
wizard_session_id       | varchar(255)
activation_status       | enum('pending','activated')
activated_at            | timestamp
```

Expected company columns:

```
Field                   | Type
setup_completed_at      | timestamp
wizard_session_id       | varchar(255)
```

---

## 10. PERMISSION & SECURITY SETUP

**Status**: 🟡 Verify

### Ensure these are authenticated

```php
// In CompanyController, add middleware to these methods:
// - apiActivate()
// - wizardInit()
// - wizardResume()
// - wizardAutosave()
// - wizardDeploy()
// - wizardPermissions()
// - wizardGenerateSku()

// Pattern in BaseControleur or middleware:
if (!$this->auth->isAuthenticated() && !in_array($action, ['activate', 'welcome'])) {
    return $this->unauthorized();
}
```

---

## 11. IMPLEMENTATION FLOW (Manual Testing)

**Status**: Ready to start

### Step 1: Registration

```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "company_name": "Test Corp",
    "company_email": "company@test.com",
    "admin_first_name": "Jean",
    "admin_email": "jean@test.com",
    "admin_password": "Pass123!"
  }'
```

**Expected**: User & company created, activation email sent

### Step 2: Get Activation Token

```sql
-- From database
SELECT token FROM activation_tokens WHERE user_id = X LIMIT 1;
```

### Step 3: Activate

```bash
curl -X POST http://localhost:8000/api/company/activate \
  -H "Content-Type: application/json" \
  -d '{"token": "..."}'
```

**Expected**: Redirect to `/welcome`

### Step 4: Init Wizard

```bash
curl -X POST http://localhost:8000/api/wizard/init \
  -H "Authorization: Bearer {jwt_token}"
```

**Expected**: Get sessionId

### Step 5: Open Wizard

```
Visit: http://localhost:8000/workspace/setup?session={sessionId}
```

**Expected**: Wizard form loads, state retrieved from backend

### Step 6: Complete & Deploy

```bash
curl -X POST http://localhost:8000/api/wizard/deploy \
  -H "Authorization: Bearer {jwt_token}" \
  -H "X-Idempotency-Key: {uuid}" \
  -H "Content-Type: application/json" \
  -d '{"wizardSessionId": "...", "state": {...}}'
```

**Expected**: Company fully configured, redirect to dashboard

---

## 12. PENDING IMPLEMENTATION

**Status**: 🔴 Not yet implemented

These are stubs in WizardService that need completion:

### `createWizardData()` method

**Location**: `app/Services/WizardService.php` line ~180

**Current**: Stub only

**Needs Implementation**:

```php
private function createWizardData($company, $finalState)
{
    // 1. Create Site from $finalState['siteName']
    // 2. Create Categories from $finalState['categories']
    // 3. Create Roles from $finalState['roles']
    // 4. Assign Permissions to roles
    // 5. Send Invitation emails from $finalState['invitations']
    // 6. Set up default dashboard
}
```

**Priority**: HIGH - Blocks wizard functionality

---

## 13. COMPLETION CHECKLIST

### Pre-Launch

- [ ] Database migrations executed
- [ ] Routes added to web.php
- [ ] Environment variables configured
- [ ] Mail service tested
- [ ] JWT tokens working
- [ ] All PHP files syntax checked
- [ ] All views created/verified

### Post-Launch Testing

- [ ] Registration flow works
- [ ] Activation email received
- [ ] Account activation completes
- [ ] Welcome page displays
- [ ] Wizard initializes
- [ ] State autosaves (1.5s debounce)
- [ ] Page refresh resumes wizard
- [ ] All 8 wizard steps render
- [ ] Deploy creates company
- [ ] Dashboard loads
- [ ] Idempotent deploy works (call twice, same result)

### Security

- [ ] Activation tokens expire in 24h
- [ ] Sessions expire after 30 days
- [ ] Unauthorized access returns 401
- [ ] CSRF token validated
- [ ] Rate limiting on API endpoints
- [ ] Audit logging enabled

---

## 14. QUICK START COMMANDS

```bash
# 1. Run migrations
mysql -u root -p quantix < databases_migrations_wizard.sql

# 2. Check syntax
php -l app/Modeles/WizardSession.php
php -l app/Services/WizardService.php

# 3. Dump autoload (if using composer)
composer dump-autoload

# 4. Test database
mysql -u root -p quantix -e "SELECT * FROM wizard_sessions LIMIT 1;"

# 5. Check API endpoint
curl -v http://localhost:8000/api/wizard/permissions

# 6. Tail logs
tail -f storage/logs/app.log | grep -i wizard
```

---

## 15. SUPPORT & DEBUGGING

### Enable Debug Logging

```php
// In WizardService methods, add:
logger()->info('Wizard action', [
    'action' => 'deploy',
    'sessionId' => $sessionId,
    'userId' => $userId,
    'companyId' => $companyId
]);
```

### Common Issues

| Issue                   | Solution                            |
| ----------------------- | ----------------------------------- |
| Routes not found        | Add them to web.php, restart server |
| No database tables      | Run migration file                  |
| Activation token error  | Check JWT_SECRET in .env            |
| Email not sending       | Check MAIL\_\* config in .env       |
| State not saving        | Check database permissions          |
| Frontend not connecting | Check CORS headers                  |

---

**Next Steps**: Execute database migration, add routes, then proceed with testing.
