-- =============================================================================
-- Auto Torque Ltd — manual MySQL / MariaDB patches (phpMyAdmin or CLI)
-- =============================================================================
-- Primary path: `php artisan migrate` (Laravel migrations in `database/migrations/` are canonical).
-- Use this file only when migrations cannot be run on the server, or for one-off operational fixes.
--
-- Full baseline schema (structure only): import `myauto_torque_db.sql` first.
-- Site content (CMS HTML, settings, demo listings): prefer `php artisan db:seed`.
--
-- Same role as Stay Eazi `manual_mysql_patches.sql`: fallback + hotfixes, not routine deploys.
-- =============================================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- -----------------------------------------------------------------------------
-- Repair: `migrations` table empty after manual SQL import (Laravel needs rows here)
-- Run only if your schema already matches `database/migrations/*.php` (same as myauto_torque_db.sql).
-- Backup first. If duplicates exist, run: TRUNCATE TABLE `migrations`;
-- -----------------------------------------------------------------------------
/*
INSERT INTO `migrations` (`migration`, `batch`) VALUES
  ('0001_01_01_000000_create_users_table', 1),
  ('0001_01_01_000001_create_cache_table', 1),
  ('0001_01_01_000002_create_jobs_table', 1),
  ('2026_04_16_163235_create_permission_tables', 1),
  ('2026_04_16_163946_create_vehicles_table', 1),
  ('2026_04_16_163948_create_vehicle_images_table', 1),
  ('2026_04_17_120000_add_marketplace_fields_to_vehicles_table', 1),
  ('2026_04_17_140000_create_vehicle_favorites_table', 1),
  ('2026_04_17_140001_create_vehicle_inquiries_table', 1),
  ('2026_04_17_200000_create_site_settings_table', 1),
  ('2026_04_18_100000_create_cms_pages_table', 1);
*/

-- -----------------------------------------------------------------------------
-- Example: ensure sessions table exists (SESSION_DRIVER=database)
-- (Included in myauto_torque_db.sql — duplicate safe with IF NOT EXISTS if you patch an old DB.)
-- -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- Add future one-off patches below (ALTER TABLE, indexes, data backfills).
-- Document each change with a date and the matching Laravel migration name if any.
-- -----------------------------------------------------------------------------

-- Example (commented):
-- -- 2026-04-20: example index — see migrations/2026_xx_xx_xxxx_example.php
-- ALTER TABLE `vehicles` ADD INDEX `vehicles_example_index` (`some_column`);
