# 🔍 AUDIT DB SCHEMA - Analysis du fichier base_de_donnes.sql réel

## ✅ CE QUI EXISTE

### Users Table (ligne 585+)

```sql
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `email` varchar(150),
  `password` varchar(255),
  `status` tinyint DEFAULT '1',
  `wizard_session_id` varchar(36),

  -- ✅ ACTIVATION FIELDS PRESENT
  `activation_status` enum('pending','activated') DEFAULT 'pending',
  `activated_at` timestamp NULL,
  `is_activated` tinyint(1) DEFAULT '0',  -- ⚠️ LEGACY (duplicate)

  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_users_company_email` (`company_id`,`email`),
  CONSTRAINT `fk_users_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
);
```

**Status**: ✅ Activation fields présentes

---

### Companies Table (ligne 125+)

```sql
CREATE TABLE `companies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `plan_id` bigint unsigned NOT NULL,
  `name` varchar(150),
  `slug` varchar(150) UNIQUE,
  `email` varchar(150),
  `phone` varchar(50),
  `status` tinyint DEFAULT '1',

  -- ✅ SETUP TRACKING
  `setup_completed_at` timestamp NULL,
  `wizard_session_id` varchar(36),
  `setup_step` int DEFAULT '0',

  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `fk_companies_plan` (`plan_id`),
  CONSTRAINT `fk_companies_plan` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`)
);
```

**Status**: ✅ Setup fields présentes

---

## ❌ PROBLÈMES CRITIQUES DÉTECTÉS

### Problem 1: WIZARD_SESSIONS TABLE MANQUANTE

**Location**: base_de_donnes.sql

**Missing**:

```sql
-- NOT IN base_de_donnes.sql but CRITICAL for wizard flow
CREATE TABLE `wizard_sessions` (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    wizard_session_id VARCHAR(36) UNIQUE NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    company_id BIGINT UNSIGNED NULL,
    status ENUM('draft', 'in_progress', 'completed', 'deployed'),
    current_step INT DEFAULT 1,
    state LONGTEXT,  -- JSON wizard state
    idempotency_key VARCHAR(36) UNIQUE NULL,
    deployment_metadata LONGTEXT,
    last_saved_at TIMESTAMP NULL,
    deployed_at TIMESTAMP NULL,
    ...
);
```

**Impact**: ❌ Code utilise WizardSession model mais table n'existe pas!

---

### Problem 2: ACTIVATION_TOKENS TABLE MANQUANTE

**Location**: base_de_donnes.sql

**Missing**:

```sql
-- NOT IN base_de_donnes.sql but needed for email activation
CREATE TABLE `activation_tokens` (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    token VARCHAR(255) UNIQUE NOT NULL,
    status ENUM('pending', 'used', 'expired') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP,
    activated_at TIMESTAMP NULL,
    CONSTRAINT fk_activation_tokens_user_id
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

**Impact**: ❌ No way to track activation tokens!

---

### Problem 3: LEGACY COLUMN `is_activated`

**Location**: users table, ligne 595

```sql
`is_activated` tinyint(1) DEFAULT '0',  -- ⚠️ DUPLICATE of activation_status
```

**Issue**:

- `activation_status` = real field (ENUM)
- `is_activated` = old field (TINYINT)
- Code uses `is_activated = 1` in CompanyService (LINE 254)
- Should use `activation_status = 'activated'` instead

**Action**: Keep `activation_status`, deprecate `is_activated`

---

### Problem 4: DATA TYPE INCONSISTENCY

**Location**: ID types across tables

**Current in base_de_donnes.sql**:

```sql
companies.id = BIGINT UNSIGNED AUTO_INCREMENT
users.id = BIGINT UNSIGNED AUTO_INCREMENT

-- But wizard_sessions should use:
user_id BIGINT UNSIGNED NOT NULL
company_id BIGINT UNSIGNED NULL
```

**Status**: ✅ OK - All use BIGINT UNSIGNED

**Note**: My corrected schema used CHAR(36) for UUID - NOT needed here since code uses AUTO_INCREMENT

---

### Problem 5: MISSING INDEXES

**Location**: users table

**Current indexes**:

```sql
PRIMARY KEY (`id`)
UNIQUE KEY `uq_users_company_email` (`company_id`,`email`)
```

**Missing**:

```sql
KEY `idx_activation_status` (`activation_status`)
KEY `idx_activated_at` (`activated_at`)
KEY `idx_wizard_session_id` (`wizard_session_id`)
```

**Impact**: ⚠️ Slow queries on activation checks

---

## 📋 COMPARISON: base_de_donnes.sql vs Corrected Schema

| Aspect                             | Base File             | Corrected | Status       |
| ---------------------------------- | --------------------- | --------- | ------------ |
| companies.id type                  | BIGINT AUTO_INCREMENT | CHAR(36)  | ⚠️ Different |
| users.id type                      | BIGINT AUTO_INCREMENT | CHAR(36)  | ⚠️ Different |
| activation_status                  | ✅ YES                | ✅ YES    | ✅ Match     |
| activated_at                       | ✅ YES                | ✅ YES    | ✅ Match     |
| setup_step                         | ✅ YES                | ✅ YES    | ✅ Match     |
| setup_completed_at                 | ✅ YES                | ✅ YES    | ✅ Match     |
| wizard_sessions table              | ❌ NO                 | ✅ YES    | ❌ MISSING   |
| activation_tokens table            | ❌ NO                 | ✅ YES    | ❌ MISSING   |
| last_saved_at in wizard_sessions   | ❌ NO                 | ✅ YES    | ❌ MISSING   |
| idempotency_key in wizard_sessions | ❌ NO                 | ✅ YES    | ❌ MISSING   |
| is_activated (legacy)              | ✅ YES (bad)          | ❌ NO     | ⚠️ Cleanup   |

---

## 🛠️ CORRECTIONS NÉCESSAIRES

### 1. ADD wizard_sessions TABLE to base_de_donnes.sql

```sql
CREATE TABLE `wizard_sessions` (
  `id` BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `wizard_session_id` VARCHAR(36) UNIQUE NOT NULL,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `company_id` BIGINT UNSIGNED NULL,
  `status` ENUM('draft', 'in_progress', 'completed', 'deployed') DEFAULT 'draft',
  `current_step` INT DEFAULT 1,
  `state` LONGTEXT,
  `idempotency_key` VARCHAR(36) UNIQUE NULL,
  `deployment_metadata` LONGTEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_saved_at` TIMESTAMP NULL,
  `deployed_at` TIMESTAMP NULL,

  CONSTRAINT fk_wizard_sessions_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_wizard_sessions_company_id FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE,

  UNIQUE KEY uk_wizard_session_id (wizard_session_id),
  KEY idx_user_id (user_id),
  KEY idx_company_id (company_id),
  KEY idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 2. ADD activation_tokens TABLE to base_de_donnes.sql

```sql
CREATE TABLE `activation_tokens` (
  `id` BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `token` VARCHAR(255) UNIQUE NOT NULL,
  `status` ENUM('pending', 'used', 'expired') DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `expires_at` TIMESTAMP NULL,
  `activated_at` TIMESTAMP NULL,

  CONSTRAINT fk_activation_tokens_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,

  KEY idx_user_id (user_id),
  KEY idx_token (token),
  KEY idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

### 3. ADD INDEXES to users table

```sql
ALTER TABLE users ADD KEY idx_activation_status (activation_status);
ALTER TABLE users ADD KEY idx_activated_at (activated_at);
ALTER TABLE users ADD KEY idx_wizard_session_id (wizard_session_id);
```

---

### 4. REMOVE LEGACY COLUMN (optional cleanup)

```sql
ALTER TABLE users DROP COLUMN is_activated;
```

**Note**: Keep for backward compat if code still uses it. After Phase 2 auto-login fix, can deprecate.

---

## ✅ CODE ALIGNMENT WITH REAL DB

### CompanyService.php Code Impact

**Current (BROKEN)**:

```php
$user->is_activated = 1;  // ❌ Will work but is_activated exists
```

**After Phase 1 fix (CORRECT)**:

```php
$user->activation_status = 'activated';  // ✅ activation_status exists
```

**Status**: ✅ Will work with real DB

---

### WizardService.php Code Impact

**Current (BROKEN)**:

```php
WizardSession::findBySessionId($sessionId);  // ❌ Table doesn't exist!
```

**Impact**: Fatal error on wizard init

**Fix**: Add wizard_sessions table to base_de_donnes.sql

---

## 📊 DEPLOYMENT CHECKLIST

- [ ] Add wizard_sessions table to base_de_donnes.sql
- [ ] Add activation_tokens table to base_de_donnes.sql
- [ ] Add indexes on users table
- [ ] Verify FK constraints reference correct data types (BIGINT OK)
- [ ] Test: User registration → creates company + user
- [ ] Test: User activation → updates activation_status
- [ ] Test: Wizard init → creates wizard_sessions record
- [ ] Test: Wizard deploy → updates company + wizard_sessions

---

## 🔑 SUMMARY

| Item                     | Status     | Severity    | Action                  |
| ------------------------ | ---------- | ----------- | ----------------------- |
| activation_status field  | ✅ Exists  | -           | Keep as-is              |
| activated_at field       | ✅ Exists  | -           | Keep as-is              |
| setup_step field         | ✅ Exists  | -           | Keep as-is              |
| setup_completed_at field | ✅ Exists  | -           | Keep as-is              |
| wizard_sessions table    | ❌ MISSING | 🔴 CRITICAL | Add NOW                 |
| activation_tokens table  | ❌ MISSING | 🔴 CRITICAL | Add NOW                 |
| is_activated column      | ⚠️ Legacy  | 🟡 MEDIUM   | Deprecate after Phase 2 |
| Missing indexes          | ⚠️ Slow    | 🟡 MEDIUM   | Add for performance     |

**NEXT STEP**: Update base_de_donnes.sql to add wizard_sessions + activation_tokens tables
