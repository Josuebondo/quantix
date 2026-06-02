# 🔍 AUDIT DB SCHEMA - Vérification SaaS Flow

## ✅ Ce qui existe et est CORRECT

### Companies Table (databases.sql)

```sql
CREATE TABLE companies (
    id CHAR(36) PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150),
    phone VARCHAR(30),
    status VARCHAR(20) DEFAULT 0,
    setup_step INT DEFAULT 0,              ✅ CORRECT
    setup_completed_at TIMESTAMP NULL,     ✅ CORRECT
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Progression tracking**: setup_step (0→1→100) + setup_completed_at ✅

---

### WizardSessions Table (databases_migrations_wizard.sql)

```sql
CREATE TABLE wizard_sessions (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    wizard_session_id VARCHAR(36) UNIQUE NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    company_id BIGINT UNSIGNED NULL,
    status ENUM('draft', 'in_progress', 'completed', 'deployed') DEFAULT 'draft',
    current_step INT DEFAULT 1,
    state LONGTEXT COMMENT 'JSON state',
    idempotency_key VARCHAR(36) UNIQUE NULL,          ✅ Idempotency
    deployment_metadata LONGTEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_saved_at TIMESTAMP NULL,                     ✅ Expiration tracking (meilleur que created_at)
    deployed_at TIMESTAMP NULL,
    INDEXES and FKs...
);
```

**Points clés**:

- ✅ `last_saved_at` pour tracking expiration (30j inactivité)
- ✅ `idempotency_key` UNIQUE pour déploiement safe
- ✅ `deployment_metadata` JSON pour stocker résultats
- ✅ Foreign keys avec ON DELETE CASCADE

---

### Users Migrations (databases_migrations_wizard.sql)

```sql
ALTER TABLE `users` ADD COLUMN `wizard_session_id` VARCHAR(36);
ALTER TABLE `users` ADD COLUMN `activation_status` ENUM('pending', 'activated') DEFAULT 'pending';
ALTER TABLE `users` ADD COLUMN `activated_at` TIMESTAMP NULL;
```

**Points clés**:

- ✅ `activation_status` pour tracking activation
- ✅ `activated_at` pour audit
- ✅ `wizard_session_id` link to wizard

---

## ❌ PROBLÈMES DÉTECTÉS

### Problem 1: SPLIT Schema (Main vs Migrations)

**Location**: databases.sql vs databases_migrations_wizard.sql

**Issue**:

- `databases.sql` = base table creations (companies, users, roles)
- `databases_migrations_wizard.sql` = migrations/alter tables (wizard_sessions, new columns)

**Impact**:

- New deployments: Run databases.sql THEN databases_migrations_wizard.sql
- Risk: Migrations might fail if columns already exist (IF NOT EXISTS missing!)

**Example problem**:

```sql
-- This will FAIL on second run:
ALTER TABLE `users` ADD COLUMN `wizard_session_id` VARCHAR(36);
-- Error: Duplicate column name 'wizard_session_id'
```

### Problem 2: Missing Activation Tokens Table

**Location**: databases_migrations_wizard.sql has it, databases.sql doesn't

```sql
-- EXISTS in migrations but not main DB:
CREATE TABLE IF NOT EXISTS `activation_tokens` (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    token VARCHAR(255) UNIQUE NOT NULL,
    status ENUM('pending', 'used', 'expired') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP,
    activated_at TIMESTAMP NULL,
    ...
);
```

**Impact**: If running only databases.sql, no activation_tokens table!

### Problem 3: Users Table Missing Activation Fields

**Location**: databases.sql (lines 17-37)

**Missing columns**:

```sql
-- NOT IN databases.sql but IN migrations_wizard.sql:
activation_status ENUM('pending', 'activated') DEFAULT 'pending'
activated_at TIMESTAMP NULL
wizard_session_id VARCHAR(36)
```

**Impact**: Code expects these fields but they don't exist in base schema!

### Problem 4: Data Type Mismatch

**Location**: wizard_sessions FK vs users/companies ID types

**Current**:

```sql
-- In databases.sql:
CREATE TABLE companies (id CHAR(36) PRIMARY KEY, ...);
CREATE TABLE users (id CHAR(36) PRIMARY KEY, ...);

-- In databases_migrations_wizard.sql:
CREATE TABLE wizard_sessions (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,                    ❌ BIGINT
    company_id BIGINT UNSIGNED NULL,                     ❌ BIGINT
    CONSTRAINT `fk_wizard_user_id` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) -- ❌ CHAR(36)
);
```

**Problem**: FK constraint will FAIL! CHAR(36) ≠ BIGINT UNSIGNED

### Problem 5: Missing Indexes for Performance

**Location**: databases.sql

**Missing on users table**:

```sql
-- Should have:
INDEX `idx_activation_status` (`activation_status`),
INDEX `idx_activated_at` (`activated_at`),
INDEX `idx_company_id` (`company_id`),
INDEX `idx_email` (`email`),
```

---

## 🛠️ CORRECTIONS RECOMMANDÉES

### Fix 1: Consolidate into Single Base Schema

**Action**: Move wizard_sessions + activation_tokens into databases.sql (as primary creations)

### Fix 2: Fix Data Type Mismatch

**Action**: wizard_sessions should use CHAR(36) for foreign keys OR all IDs use BIGINT UNSIGNED

### Fix 3: Add Migration Guards

**Action**: Wrap all ALTER TABLE in `IF NOT EXISTS` checks

### Fix 4: Add Missing Indexes

**Action**: Add performance indexes to users table

### Fix 5: Complete Users Table

**Action**: Include activation_status, activated_at, wizard_session_id in base schema

---

## 📋 FLOW VALIDATION

### Registration Flow

```
1. users.registration (POST /api/auth/register)
   ├─ Créer: companies (setup_step=0)
   ├─ Créer: users (activation_status='pending')
   └─ Créer: activation_tokens

2. users.sendActivationEmail
   ├─ Generate token (JWT)
   └─ Send email with activation link

3. users.activateAccount (GET /api/auth/activate?token=...)
   ├─ Verify activation_tokens.token
   ├─ Update: users (activation_status='activated', activated_at=now)
   ├─ Update: companies (setup_step=1)
   └─ Créer: wizard_sessions (status='draft')
```

### Wizard Flow

```
1. wizard.initialize
   ├─ Check: WizardSession exists && canBeResumed()
   └─ Créer: new WizardSession OR resume existing

2. wizard.autosave (frequent)
   ├─ Update: wizard_sessions.state (JSON)
   ├─ Update: wizard_sessions.last_saved_at = now() ✅ For expiration
   └─ Update: wizard_sessions.current_step

3. wizard.deploy (final step)
   ├─ DB.beginTransaction()
   ├─ Update: companies (setup_step=100, setup_completed_at=now)
   ├─ Créer: sites, categories, products, roles (from wizard_sessions.state)
   ├─ Update: wizard_sessions (status='deployed', deployed_at=now)
   └─ DB.commit() or DB.rollBack()
```

---

## 🔑 KEY METRICS

| Aspect               | Status        | Notes                                      |
| -------------------- | ------------- | ------------------------------------------ |
| Activation tracking  | ⚠️ Incomplete | Fields in migrations but not base schema   |
| Setup progression    | ✅ OK         | setup_step + setup_completed_at exist      |
| Wizard state storage | ✅ OK         | LONGTEXT JSON in wizard_sessions           |
| Session resumption   | ✅ OK         | last_saved_at + created_at + status        |
| Idempotency          | ✅ OK         | Unique idempotency_key                     |
| Expiration logic     | ✅ OK         | last_saved_at better than created_at       |
| Transaction safety   | ✅ Code OK    | DB wrapper implemented (not DB schema)     |
| Foreign keys         | ❌ BROKEN     | Data type mismatch CHAR(36) vs BIGINT      |
| Base schema          | ⚠️ Incomplete | Missing wizard_sessions, activation_tokens |
| Migration guards     | ❌ MISSING    | No IF EXISTS checks                        |

---

## 🚨 CRITICAL ISSUES SUMMARY

1. **CRITICAL**: FK constraint will FAIL (CHAR(36) vs BIGINT UNSIGNED mismatch)
2. **HIGH**: wizard_sessions not in base schema (only in migrations)
3. **HIGH**: Users table missing activation columns in base schema
4. **HIGH**: activation_tokens table not in base schema
5. **MEDIUM**: No IF EXISTS in migrations (will fail on re-run)
6. **MEDIUM**: Missing indexes on frequently queried columns
