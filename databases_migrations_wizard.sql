-- ═══════════════════════════════════════════════════════════════════════════
-- WIZARD SESSIONS TABLE - Core de l'onboarding SaaS
-- ═══════════════════════════════════════════════════════════════════════════

CREATE TABLE IF NOT EXISTS `wizard_sessions` (
  `id` BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `wizard_session_id` VARCHAR(36) UNIQUE NOT NULL COMMENT 'UUID unique pour le wizard',
  `user_id` BIGINT UNSIGNED NOT NULL,
  `company_id` BIGINT UNSIGNED NULL COMMENT 'NULL tant que pas créée',
  `status` ENUM('draft', 'in_progress', 'completed', 'deployed') DEFAULT 'draft',
  `current_step` INT DEFAULT 1,
  
  -- 🔵 JSONB State - Contient TOUT l'état du wizard
  `state` LONGTEXT COMMENT 'JSON state du wizard',
  
  -- 🔐 Idempotency
  `idempotency_key` VARCHAR(36) UNIQUE NULL COMMENT 'Pour deploy idempotent',
  `deployment_metadata` LONGTEXT COMMENT 'Résultats du déploiement',
  
  -- Timestamps
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_saved_at` TIMESTAMP NULL,
  `deployed_at` TIMESTAMP NULL,
  
  -- Indexes
  UNIQUE KEY `uk_wizard_session_id` (`wizard_session_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_company_id` (`company_id`),
  KEY `idx_status` (`status`),
  KEY `idx_created_at` (`created_at`),
  
  -- Foreign Keys
  CONSTRAINT `fk_wizard_user_id` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_wizard_company_id` FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ═══════════════════════════════════════════════════════════════════════════
-- ACTIVATION TOKENS TABLE - Pour les tokens d'activation
-- ════════════════════════════════════════════════════════════════════════════

CREATE TABLE IF NOT EXISTS `activation_tokens` (
  `id` BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `token` VARCHAR(255) UNIQUE NOT NULL,
  `status` ENUM('pending', 'used', 'expired') DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `expires_at` TIMESTAMP,
  `activated_at` TIMESTAMP NULL,
  
  KEY `idx_user_id` (`user_id`),
  KEY `idx_token` (`token`),
  KEY `idx_status` (`status`),
  
  CONSTRAINT `fk_activation_user_id` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ═══════════════════════════════════════════════════════════════════════════
-- ADD COLUMNS TO USERS TABLE (if not exists)
-- ═══════════════════════════════════════════════════════════════════════════

ALTER TABLE `users` ADD COLUMN `wizard_session_id` VARCHAR(36)  COMMENT 'UUID de la session wizard en cours' AFTER `status`;
ALTER TABLE `users` ADD COLUMN `activation_status` ENUM('pending', 'activated') DEFAULT 'pending';
ALTER TABLE `users` ADD COLUMN  `activated_at` TIMESTAMP NULL;

-- ═══════════════════════════════════════════════════════════════════════════
-- ADD COLUMNS TO COMPANY TABLE (if not exists)
-- ═══════════════════════════════════════════════════════════════════════════

ALTER TABLE `companies` ADD COLUMN `setup_completed_at` TIMESTAMP NULL COMMENT 'Quand le wizard est terminé';
ALTER TABLE `companies` ADD COLUMN `wizard_session_id` VARCHAR(36) COMMENT 'UUID de la session wizard';
