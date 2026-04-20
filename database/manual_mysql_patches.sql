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
--
-- DEMO INVENTORY: six approved placeholder listings from `DemoData` / `VehiclesSeeder`, each with
-- six gallery image URLs (same HTTPS set as the Laravel seeder — no WordPress upload paths). Safe to run multiple times.
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

-- =============================================================================
-- Demo approved inventory (keep in sync with database/seeders/DemoData.php)
-- =============================================================================
-- Prerequisite tables: `users`, `roles`, `model_has_roles`, `vehicles`, `vehicle_images`
-- Password hash below matches Laravel demo login from seeders (`password`).
-- Image paths match Motors Elementor Dealer Two exports (see `database/seed-data/cms-home-body.html`).
-- =============================================================================

SET @demo_ts = '2026-04-20 02:37:47';

INSERT IGNORE INTO `roles` (`name`, `guard_name`, `created_at`, `updated_at`) VALUES
  ('admin', 'web', @demo_ts, @demo_ts),
  ('user', 'web', @demo_ts, @demo_ts);

INSERT INTO `users` (`name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
  ('Demo Admin', 'admin@example.com', @demo_ts, '$2y$10$pSP6FS1ZyY4rhex.nO85HePRoGFylbhNO6IsMw3UGDAIsgQmMogM2', '2BjTnBF1H7', @demo_ts, @demo_ts),
  ('Demo User', 'demo@example.com', @demo_ts, '$2y$10$pSP6FS1ZyY4rhex.nO85HePRoGFylbhNO6IsMw3UGDAIsgQmMogM2', '2BjTnBF1H7', @demo_ts, @demo_ts)
ON DUPLICATE KEY UPDATE
  `name` = VALUES(`name`),
  `email_verified_at` = VALUES(`email_verified_at`),
  `password` = VALUES(`password`),
  `updated_at` = VALUES(`updated_at`);

INSERT IGNORE INTO `model_has_roles` (`role_id`, `model_type`, `model_id`)
SELECT r.id, 'App\\Models\\User', u.id
FROM `roles` r
JOIN `users` u ON (r.name = 'admin' AND u.email = 'admin@example.com')
   OR (r.name = 'user' AND u.email = 'demo@example.com');

-- Drop legacy 3-car demo slugs (replaced by six-vehicle grid)
DELETE vi FROM `vehicle_images` vi
JOIN `vehicles` v ON v.id = vi.vehicle_id
WHERE v.slug IN (
  '2016-mercedes-benz-c-class-c300-4matic',
  '2019-nissan-altima-25-sv',
  '2021-tesla-roadster'
);
DELETE FROM `vehicles` WHERE `slug` IN (
  '2016-mercedes-benz-c-class-c300-4matic',
  '2019-nissan-altima-25-sv',
  '2021-tesla-roadster'
);
-- Demo approved inventory mapped to the demo user
INSERT INTO `vehicles` (`user_id`, `title`, `slug`, `status`, `year`, `make`, `model`, `price`, `mileage`, `transmission`, `fuel_type`, `drive`, `body_type`, `condition`, `engine_size`, `location`, `features`, `exterior_color`, `interior_color`, `description`, `submitted_at`, `approved_at`, `approved_by`, `created_at`, `updated_at`)
SELECT u.id, '2021 BMW M4 Competition', '2021-bmw-m4-competition', 'approved', 2021, 'BMW', 'M4', 89900, 12500, 'Automatic', 'Petrol', 'RWD', 'Coupe', 'used', '3.0L I6 twin-turbo', 'Miami, FL', '["M Sport package","Carbon roof","Live Cockpit Professional","Harman Kardon","Head-up display"]', 'Isle of Man Green', 'Silverstone', 'Demo listing: high-performance M4 Competition with M carbon exterior accents, adaptive M suspension, and M Sport brakes. Gallery uses Motors theme stock photography.', @demo_ts, @demo_ts, approver.id, @demo_ts, @demo_ts
FROM `users` u
JOIN `users` approver ON approver.email = 'admin@example.com'
WHERE u.email = 'demo@example.com'
ON DUPLICATE KEY UPDATE `user_id` = VALUES(`user_id`), `title` = VALUES(`title`), `status` = VALUES(`status`), `year` = VALUES(`year`), `make` = VALUES(`make`), `model` = VALUES(`model`), `price` = VALUES(`price`), `mileage` = VALUES(`mileage`), `transmission` = VALUES(`transmission`), `fuel_type` = VALUES(`fuel_type`), `drive` = VALUES(`drive`), `body_type` = VALUES(`body_type`), `condition` = VALUES(`condition`), `engine_size` = VALUES(`engine_size`), `location` = VALUES(`location`), `features` = VALUES(`features`), `exterior_color` = VALUES(`exterior_color`), `interior_color` = VALUES(`interior_color`), `description` = VALUES(`description`), `submitted_at` = VALUES(`submitted_at`), `approved_at` = VALUES(`approved_at`), `approved_by` = VALUES(`approved_by`), `rejection_reason` = NULL, `updated_at` = VALUES(`updated_at`);
DELETE vi FROM `vehicle_images` vi
JOIN `vehicles` v ON v.id = vi.vehicle_id
WHERE v.slug = '2021-bmw-m4-competition';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuD5Swu_VfY8IYgBgtCLqdAKgXJhY0t8G3NFrL8qTkiU44-P7b0xd4dQziHP1ghsmtbfRVNSzKYN4RDBi9zLkHkSLlWh_MQLgPP5IWdw61BJqGpgJCUuLvD5fX9_6dUqcFkJAmJfmZcoyaA9zU5pGH58epqw7pyi0uub5aZwr3jLEE7KwIw_wOF1m2MiFcMriGWniMn-Mocixe-uP_EocYcG43OJR5FS36YbZiwJ724cuVrhr6wy1Ne2B3Ic9Gt21MmQSzmfFm5FTMM', 0, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2021-bmw-m4-competition';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuAx6Rclw6OJt765M0v-ShtMYuYxM_y7xXCmC2FWOUYhHoaBpcuHQ_KJ7U432s3IDy08d-jNUjzyUtjrTv1jbH1E59-vhzQO3QfBsBvZvd9ttRFKguhpJ7RHUegUn5CEsdKCh_JD7eNmc84LcZWvxUU7bbC2kglPs-P-iKm4P3YJiKw3lJbaxbZcXLsKnImzDI5NHX7HvvasSrEKgEzOC1WpY1_pgdnnZQldPOpnIuogs4UWhkjab70BFh_Yxwkpb66zzujg_lqW4f8', 1, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2021-bmw-m4-competition';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuCX2OnbrN_OlmcbFkbfG57QSrXZWDCFn0gdz7Ooq2J_eTeTNVshs0Ehow1j1v8Etk5TwG2d3aL3B-3PSL54wXSHv9sM8ch_GPPV6tz4LTfv0VB8pmGM6qR98icOkm6KUAvMy73QbwUUc-wOsPLTU-bKq8Dd-dWtTH2RlOU4Te226j03i-jCjg2D0VRm_-4gY3Zj4uTakTcSYZKgY19sHTzTbQ96sOdDfIlq_xm1I2PhBPnQEKtLeMT1Fr99fHWszJHsvtK2-2rsB5E', 2, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2021-bmw-m4-competition';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuB86za3jd2sQu83szzqHSezMl_I7t0cmFztbHt18TYAyJ1UTwT_-Sv49DKASvnObsTBNRUP2XxEm48L74HXFpt6qbjDyUZ-bowk-9vp_O6Mh9NQOQZFrCbDKa-YmKvMWQPibBJUYX_sXhBe9MidGIcbEIiwDdFo7Ff44VYcpVtO0aqdour27tUxwWoaSs9TYgV9JnGYCbE2mKe9LLJbQQi1AsKoWaWslpY9QgOtd3b71fQblFw0ymLrpBB81AgzAF_g1fbdj-U0oG8', 3, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2021-bmw-m4-competition';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuAtzOrMxv34w0a1iVMYHwMqfYMmJ6ZC5xS7IYi2vfEDIckK5RSiJoqyRLdBevA3Dvv0SVPuqouh4DaN2LWNJOgFzrt6KxJbVAF6a_UpzBaEJRVO0X3_7m7wi_-aOLf5oPqsc2Rd5LFbow0ghNr6mxCXEeO5VQ9rkdvfM-7sAM4ulNJjEUf_IAfTXhHU9sj6HK_SxBjA8tHF9zT1jOx59a36YjVrp6lAxcylS8PsDXWV5naerX7MTJHXV5cmlEdbW8uIMQwKS1Y2R2w', 4, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2021-bmw-m4-competition';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuDT52f15zUg_xA-xANN-dCaXv7HtCXjGvOrSZ3EEJfobbbIMXWZnm9mEktxeS-E2KwY3OW7xUAyDHJVZ4QnUm_Wcz3ynHdjeX8bjmSPbfsm0WgV8AScG_YwAVRR5_0R1Sqq6c7IiDfFvUXRK2gTpyNjYGBOBM3M5b0w18emsv6lamP5bIrTzY2Kp6U-glyBiFpFDAkW1yYtRMP9rA7R-XZVYQQmQiigVTdDw_rrO7GyjuVB_L4_9pqhuq9AgL7Li5CL7dVkdq9F7XE', 5, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2021-bmw-m4-competition';

INSERT INTO `vehicles` (`user_id`, `title`, `slug`, `status`, `year`, `make`, `model`, `price`, `mileage`, `transmission`, `fuel_type`, `drive`, `body_type`, `condition`, `engine_size`, `location`, `features`, `exterior_color`, `interior_color`, `description`, `submitted_at`, `approved_at`, `approved_by`, `created_at`, `updated_at`)
SELECT u.id, '2022 Audi RS6 Avant', '2022-audi-rs6-avant', 'approved', 2022, 'Audi', 'RS6 Avant', 112000, 5200, 'Automatic', 'Petrol', 'AWD', 'Wagon', 'used', '4.0L V8 twin-turbo', 'Austin, TX', '["RS sport exhaust","Matrix LED","Bang & Olufsen","Adaptive air suspension","Tour assist"]', 'Nardo Grey', 'Black', 'Demo listing: RS6 Avant with quattro sport differential and dynamic ride control. Images mirror the Nissan Altima gallery set from the Motors dealer snapshot.', @demo_ts, @demo_ts, approver.id, @demo_ts, @demo_ts
FROM `users` u
JOIN `users` approver ON approver.email = 'admin@example.com'
WHERE u.email = 'demo@example.com'
ON DUPLICATE KEY UPDATE `user_id` = VALUES(`user_id`), `title` = VALUES(`title`), `status` = VALUES(`status`), `year` = VALUES(`year`), `make` = VALUES(`make`), `model` = VALUES(`model`), `price` = VALUES(`price`), `mileage` = VALUES(`mileage`), `transmission` = VALUES(`transmission`), `fuel_type` = VALUES(`fuel_type`), `drive` = VALUES(`drive`), `body_type` = VALUES(`body_type`), `condition` = VALUES(`condition`), `engine_size` = VALUES(`engine_size`), `location` = VALUES(`location`), `features` = VALUES(`features`), `exterior_color` = VALUES(`exterior_color`), `interior_color` = VALUES(`interior_color`), `description` = VALUES(`description`), `submitted_at` = VALUES(`submitted_at`), `approved_at` = VALUES(`approved_at`), `approved_by` = VALUES(`approved_by`), `rejection_reason` = NULL, `updated_at` = VALUES(`updated_at`);
DELETE vi FROM `vehicle_images` vi
JOIN `vehicles` v ON v.id = vi.vehicle_id
WHERE v.slug = '2022-audi-rs6-avant';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuAx6Rclw6OJt765M0v-ShtMYuYxM_y7xXCmC2FWOUYhHoaBpcuHQ_KJ7U432s3IDy08d-jNUjzyUtjrTv1jbH1E59-vhzQO3QfBsBvZvd9ttRFKguhpJ7RHUegUn5CEsdKCh_JD7eNmc84LcZWvxUU7bbC2kglPs-P-iKm4P3YJiKw3lJbaxbZcXLsKnImzDI5NHX7HvvasSrEKgEzOC1WpY1_pgdnnZQldPOpnIuogs4UWhkjab70BFh_Yxwkpb66zzujg_lqW4f8', 0, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-audi-rs6-avant';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuCX2OnbrN_OlmcbFkbfG57QSrXZWDCFn0gdz7Ooq2J_eTeTNVshs0Ehow1j1v8Etk5TwG2d3aL3B-3PSL54wXSHv9sM8ch_GPPV6tz4LTfv0VB8pmGM6qR98icOkm6KUAvMy73QbwUUc-wOsPLTU-bKq8Dd-dWtTH2RlOU4Te226j03i-jCjg2D0VRm_-4gY3Zj4uTakTcSYZKgY19sHTzTbQ96sOdDfIlq_xm1I2PhBPnQEKtLeMT1Fr99fHWszJHsvtK2-2rsB5E', 1, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-audi-rs6-avant';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuB86za3jd2sQu83szzqHSezMl_I7t0cmFztbHt18TYAyJ1UTwT_-Sv49DKASvnObsTBNRUP2XxEm48L74HXFpt6qbjDyUZ-bowk-9vp_O6Mh9NQOQZFrCbDKa-YmKvMWQPibBJUYX_sXhBe9MidGIcbEIiwDdFo7Ff44VYcpVtO0aqdour27tUxwWoaSs9TYgV9JnGYCbE2mKe9LLJbQQi1AsKoWaWslpY9QgOtd3b71fQblFw0ymLrpBB81AgzAF_g1fbdj-U0oG8', 2, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-audi-rs6-avant';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuAtzOrMxv34w0a1iVMYHwMqfYMmJ6ZC5xS7IYi2vfEDIckK5RSiJoqyRLdBevA3Dvv0SVPuqouh4DaN2LWNJOgFzrt6KxJbVAF6a_UpzBaEJRVO0X3_7m7wi_-aOLf5oPqsc2Rd5LFbow0ghNr6mxCXEeO5VQ9rkdvfM-7sAM4ulNJjEUf_IAfTXhHU9sj6HK_SxBjA8tHF9zT1jOx59a36YjVrp6lAxcylS8PsDXWV5naerX7MTJHXV5cmlEdbW8uIMQwKS1Y2R2w', 3, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-audi-rs6-avant';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuDT52f15zUg_xA-xANN-dCaXv7HtCXjGvOrSZ3EEJfobbbIMXWZnm9mEktxeS-E2KwY3OW7xUAyDHJVZ4QnUm_Wcz3ynHdjeX8bjmSPbfsm0WgV8AScG_YwAVRR5_0R1Sqq6c7IiDfFvUXRK2gTpyNjYGBOBM3M5b0w18emsv6lamP5bIrTzY2Kp6U-glyBiFpFDAkW1yYtRMP9rA7R-XZVYQQmQiigVTdDw_rrO7GyjuVB_L4_9pqhuq9AgL7Li5CL7dVkdq9F7XE', 4, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-audi-rs6-avant';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuCI7GI67cd6jzTLSlhJmEPOJZZhrp1FjnHPa4Rlgs7i4cwb-9xchzGNUNwq8mM7M4QAR5uxfLKaO8NMhcsuSFlqks6D45EpzAWc02A80wuw4mFZLgNargnw7HF0FYvagQpNn1OvDuQwUa7WRLJ-TS5nH8vcIkhVBuer9OuPoUUGpxugQcGH5HKNrB1XDrtQhwbv_MsQZeq7xEtB-U573tnSPuIXIOzhs4AWLBtZ2l5iTeX-Dg5ddWxP5bRWGVW7N2PjBy88E9Z1pac', 5, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-audi-rs6-avant';

INSERT INTO `vehicles` (`user_id`, `title`, `slug`, `status`, `year`, `make`, `model`, `price`, `mileage`, `transmission`, `fuel_type`, `drive`, `body_type`, `condition`, `engine_size`, `location`, `features`, `exterior_color`, `interior_color`, `description`, `submitted_at`, `approved_at`, `approved_by`, `created_at`, `updated_at`)
SELECT u.id, '2023 Porsche 911 GT3', '2023-porsche-911-gt3', 'approved', 2023, 'Porsche', '911 GT3', 185500, 850, 'PDK', 'Petrol', 'RWD', 'Coupe', 'used', '4.0L flat-6', 'Scottsdale, AZ', '["Clubsport package","PCCB","Front axle lift","LED-Matrix headlights","Track Precision app"]', 'Shark Blue', 'Black', 'Demo listing: track-focused 911 GT3. Gallery blends Tesla Roadster hero assets, Porsche hero imagery, and slider frames from the Motors export.', @demo_ts, @demo_ts, approver.id, @demo_ts, @demo_ts
FROM `users` u
JOIN `users` approver ON approver.email = 'admin@example.com'
WHERE u.email = 'demo@example.com'
ON DUPLICATE KEY UPDATE `user_id` = VALUES(`user_id`), `title` = VALUES(`title`), `status` = VALUES(`status`), `year` = VALUES(`year`), `make` = VALUES(`make`), `model` = VALUES(`model`), `price` = VALUES(`price`), `mileage` = VALUES(`mileage`), `transmission` = VALUES(`transmission`), `fuel_type` = VALUES(`fuel_type`), `drive` = VALUES(`drive`), `body_type` = VALUES(`body_type`), `condition` = VALUES(`condition`), `engine_size` = VALUES(`engine_size`), `location` = VALUES(`location`), `features` = VALUES(`features`), `exterior_color` = VALUES(`exterior_color`), `interior_color` = VALUES(`interior_color`), `description` = VALUES(`description`), `submitted_at` = VALUES(`submitted_at`), `approved_at` = VALUES(`approved_at`), `approved_by` = VALUES(`approved_by`), `rejection_reason` = NULL, `updated_at` = VALUES(`updated_at`);
DELETE vi FROM `vehicle_images` vi
JOIN `vehicles` v ON v.id = vi.vehicle_id
WHERE v.slug = '2023-porsche-911-gt3';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuCX2OnbrN_OlmcbFkbfG57QSrXZWDCFn0gdz7Ooq2J_eTeTNVshs0Ehow1j1v8Etk5TwG2d3aL3B-3PSL54wXSHv9sM8ch_GPPV6tz4LTfv0VB8pmGM6qR98icOkm6KUAvMy73QbwUUc-wOsPLTU-bKq8Dd-dWtTH2RlOU4Te226j03i-jCjg2D0VRm_-4gY3Zj4uTakTcSYZKgY19sHTzTbQ96sOdDfIlq_xm1I2PhBPnQEKtLeMT1Fr99fHWszJHsvtK2-2rsB5E', 0, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-porsche-911-gt3';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuB86za3jd2sQu83szzqHSezMl_I7t0cmFztbHt18TYAyJ1UTwT_-Sv49DKASvnObsTBNRUP2XxEm48L74HXFpt6qbjDyUZ-bowk-9vp_O6Mh9NQOQZFrCbDKa-YmKvMWQPibBJUYX_sXhBe9MidGIcbEIiwDdFo7Ff44VYcpVtO0aqdour27tUxwWoaSs9TYgV9JnGYCbE2mKe9LLJbQQi1AsKoWaWslpY9QgOtd3b71fQblFw0ymLrpBB81AgzAF_g1fbdj-U0oG8', 1, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-porsche-911-gt3';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuAtzOrMxv34w0a1iVMYHwMqfYMmJ6ZC5xS7IYi2vfEDIckK5RSiJoqyRLdBevA3Dvv0SVPuqouh4DaN2LWNJOgFzrt6KxJbVAF6a_UpzBaEJRVO0X3_7m7wi_-aOLf5oPqsc2Rd5LFbow0ghNr6mxCXEeO5VQ9rkdvfM-7sAM4ulNJjEUf_IAfTXhHU9sj6HK_SxBjA8tHF9zT1jOx59a36YjVrp6lAxcylS8PsDXWV5naerX7MTJHXV5cmlEdbW8uIMQwKS1Y2R2w', 2, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-porsche-911-gt3';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuDT52f15zUg_xA-xANN-dCaXv7HtCXjGvOrSZ3EEJfobbbIMXWZnm9mEktxeS-E2KwY3OW7xUAyDHJVZ4QnUm_Wcz3ynHdjeX8bjmSPbfsm0WgV8AScG_YwAVRR5_0R1Sqq6c7IiDfFvUXRK2gTpyNjYGBOBM3M5b0w18emsv6lamP5bIrTzY2Kp6U-glyBiFpFDAkW1yYtRMP9rA7R-XZVYQQmQiigVTdDw_rrO7GyjuVB_L4_9pqhuq9AgL7Li5CL7dVkdq9F7XE', 3, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-porsche-911-gt3';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuCI7GI67cd6jzTLSlhJmEPOJZZhrp1FjnHPa4Rlgs7i4cwb-9xchzGNUNwq8mM7M4QAR5uxfLKaO8NMhcsuSFlqks6D45EpzAWc02A80wuw4mFZLgNargnw7HF0FYvagQpNn1OvDuQwUa7WRLJ-TS5nH8vcIkhVBuer9OuPoUUGpxugQcGH5HKNrB1XDrtQhwbv_MsQZeq7xEtB-U573tnSPuIXIOzhs4AWLBtZ2l5iTeX-Dg5ddWxP5bRWGVW7N2PjBy88E9Z1pac', 4, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-porsche-911-gt3';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuD5Swu_VfY8IYgBgtCLqdAKgXJhY0t8G3NFrL8qTkiU44-P7b0xd4dQziHP1ghsmtbfRVNSzKYN4RDBi9zLkHkSLlWh_MQLgPP5IWdw61BJqGpgJCUuLvD5fX9_6dUqcFkJAmJfmZcoyaA9zU5pGH58epqw7pyi0uub5aZwr3jLEE7KwIw_wOF1m2MiFcMriGWniMn-Mocixe-uP_EocYcG43OJR5FS36YbZiwJ724cuVrhr6wy1Ne2B3Ic9Gt21MmQSzmfFm5FTMM', 5, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-porsche-911-gt3';

INSERT INTO `vehicles` (`user_id`, `title`, `slug`, `status`, `year`, `make`, `model`, `price`, `mileage`, `transmission`, `fuel_type`, `drive`, `body_type`, `condition`, `engine_size`, `location`, `features`, `exterior_color`, `interior_color`, `description`, `submitted_at`, `approved_at`, `approved_by`, `created_at`, `updated_at`)
SELECT u.id, '2023 Lexus RX 350', '2023-lexus-rx-350', 'approved', 2023, 'Lexus', 'RX 350', 62000, 2000, 'Automatic', 'Petrol', 'AWD', 'SUV', 'used', '3.5L V6', 'Dallas, TX', '["Premium package","Panoramic roof","Mark Levinson","Hands-free liftgate","Safety System+ 3.0"]', 'Atomic Silver', 'Rioja Red', 'Demo listing: low-mile RX 350 AWD. Gallery uses the 2021/03 Motors media batch (01-xx series) for a full six-image carousel.', @demo_ts, @demo_ts, approver.id, @demo_ts, @demo_ts
FROM `users` u
JOIN `users` approver ON approver.email = 'admin@example.com'
WHERE u.email = 'demo@example.com'
ON DUPLICATE KEY UPDATE `user_id` = VALUES(`user_id`), `title` = VALUES(`title`), `status` = VALUES(`status`), `year` = VALUES(`year`), `make` = VALUES(`make`), `model` = VALUES(`model`), `price` = VALUES(`price`), `mileage` = VALUES(`mileage`), `transmission` = VALUES(`transmission`), `fuel_type` = VALUES(`fuel_type`), `drive` = VALUES(`drive`), `body_type` = VALUES(`body_type`), `condition` = VALUES(`condition`), `engine_size` = VALUES(`engine_size`), `location` = VALUES(`location`), `features` = VALUES(`features`), `exterior_color` = VALUES(`exterior_color`), `interior_color` = VALUES(`interior_color`), `description` = VALUES(`description`), `submitted_at` = VALUES(`submitted_at`), `approved_at` = VALUES(`approved_at`), `approved_by` = VALUES(`approved_by`), `rejection_reason` = NULL, `updated_at` = VALUES(`updated_at`);
DELETE vi FROM `vehicle_images` vi
JOIN `vehicles` v ON v.id = vi.vehicle_id
WHERE v.slug = '2023-lexus-rx-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuB86za3jd2sQu83szzqHSezMl_I7t0cmFztbHt18TYAyJ1UTwT_-Sv49DKASvnObsTBNRUP2XxEm48L74HXFpt6qbjDyUZ-bowk-9vp_O6Mh9NQOQZFrCbDKa-YmKvMWQPibBJUYX_sXhBe9MidGIcbEIiwDdFo7Ff44VYcpVtO0aqdour27tUxwWoaSs9TYgV9JnGYCbE2mKe9LLJbQQi1AsKoWaWslpY9QgOtd3b71fQblFw0ymLrpBB81AgzAF_g1fbdj-U0oG8', 0, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lexus-rx-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuAtzOrMxv34w0a1iVMYHwMqfYMmJ6ZC5xS7IYi2vfEDIckK5RSiJoqyRLdBevA3Dvv0SVPuqouh4DaN2LWNJOgFzrt6KxJbVAF6a_UpzBaEJRVO0X3_7m7wi_-aOLf5oPqsc2Rd5LFbow0ghNr6mxCXEeO5VQ9rkdvfM-7sAM4ulNJjEUf_IAfTXhHU9sj6HK_SxBjA8tHF9zT1jOx59a36YjVrp6lAxcylS8PsDXWV5naerX7MTJHXV5cmlEdbW8uIMQwKS1Y2R2w', 1, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lexus-rx-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuDT52f15zUg_xA-xANN-dCaXv7HtCXjGvOrSZ3EEJfobbbIMXWZnm9mEktxeS-E2KwY3OW7xUAyDHJVZ4QnUm_Wcz3ynHdjeX8bjmSPbfsm0WgV8AScG_YwAVRR5_0R1Sqq6c7IiDfFvUXRK2gTpyNjYGBOBM3M5b0w18emsv6lamP5bIrTzY2Kp6U-glyBiFpFDAkW1yYtRMP9rA7R-XZVYQQmQiigVTdDw_rrO7GyjuVB_L4_9pqhuq9AgL7Li5CL7dVkdq9F7XE', 2, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lexus-rx-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuCI7GI67cd6jzTLSlhJmEPOJZZhrp1FjnHPa4Rlgs7i4cwb-9xchzGNUNwq8mM7M4QAR5uxfLKaO8NMhcsuSFlqks6D45EpzAWc02A80wuw4mFZLgNargnw7HF0FYvagQpNn1OvDuQwUa7WRLJ-TS5nH8vcIkhVBuer9OuPoUUGpxugQcGH5HKNrB1XDrtQhwbv_MsQZeq7xEtB-U573tnSPuIXIOzhs4AWLBtZ2l5iTeX-Dg5ddWxP5bRWGVW7N2PjBy88E9Z1pac', 3, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lexus-rx-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuD5Swu_VfY8IYgBgtCLqdAKgXJhY0t8G3NFrL8qTkiU44-P7b0xd4dQziHP1ghsmtbfRVNSzKYN4RDBi9zLkHkSLlWh_MQLgPP5IWdw61BJqGpgJCUuLvD5fX9_6dUqcFkJAmJfmZcoyaA9zU5pGH58epqw7pyi0uub5aZwr3jLEE7KwIw_wOF1m2MiFcMriGWniMn-Mocixe-uP_EocYcG43OJR5FS36YbZiwJ724cuVrhr6wy1Ne2B3Ic9Gt21MmQSzmfFm5FTMM', 4, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lexus-rx-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuAx6Rclw6OJt765M0v-ShtMYuYxM_y7xXCmC2FWOUYhHoaBpcuHQ_KJ7U432s3IDy08d-jNUjzyUtjrTv1jbH1E59-vhzQO3QfBsBvZvd9ttRFKguhpJ7RHUegUn5CEsdKCh_JD7eNmc84LcZWvxUU7bbC2kglPs-P-iKm4P3YJiKw3lJbaxbZcXLsKnImzDI5NHX7HvvasSrEKgEzOC1WpY1_pgdnnZQldPOpnIuogs4UWhkjab70BFh_Yxwkpb66zzujg_lqW4f8', 5, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lexus-rx-350';

INSERT INTO `vehicles` (`user_id`, `title`, `slug`, `status`, `year`, `make`, `model`, `price`, `mileage`, `transmission`, `fuel_type`, `drive`, `body_type`, `condition`, `engine_size`, `location`, `features`, `exterior_color`, `interior_color`, `description`, `submitted_at`, `approved_at`, `approved_by`, `created_at`, `updated_at`)
SELECT u.id, '2022 Lexus ES 350', '2022-lexus-es-350', 'approved', 2022, 'Lexus', 'ES 350', 45900, 15000, 'Automatic', 'Petrol', 'FWD', 'Sedan', 'used', '3.5L V6', 'San Diego, CA', '["Ultra Luxury","Adaptive variable suspension","Panoramic monitor","Heated/ventilated seats"]', 'Obsidian', 'Acorn', 'Demo listing: comfortable ES 350 with strong highway manners. Gallery mixes hero slider and Mercedes stock stills from the Motors theme pack.', @demo_ts, @demo_ts, approver.id, @demo_ts, @demo_ts
FROM `users` u
JOIN `users` approver ON approver.email = 'admin@example.com'
WHERE u.email = 'demo@example.com'
ON DUPLICATE KEY UPDATE `user_id` = VALUES(`user_id`), `title` = VALUES(`title`), `status` = VALUES(`status`), `year` = VALUES(`year`), `make` = VALUES(`make`), `model` = VALUES(`model`), `price` = VALUES(`price`), `mileage` = VALUES(`mileage`), `transmission` = VALUES(`transmission`), `fuel_type` = VALUES(`fuel_type`), `drive` = VALUES(`drive`), `body_type` = VALUES(`body_type`), `condition` = VALUES(`condition`), `engine_size` = VALUES(`engine_size`), `location` = VALUES(`location`), `features` = VALUES(`features`), `exterior_color` = VALUES(`exterior_color`), `interior_color` = VALUES(`interior_color`), `description` = VALUES(`description`), `submitted_at` = VALUES(`submitted_at`), `approved_at` = VALUES(`approved_at`), `approved_by` = VALUES(`approved_by`), `rejection_reason` = NULL, `updated_at` = VALUES(`updated_at`);
DELETE vi FROM `vehicle_images` vi
JOIN `vehicles` v ON v.id = vi.vehicle_id
WHERE v.slug = '2022-lexus-es-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuAtzOrMxv34w0a1iVMYHwMqfYMmJ6ZC5xS7IYi2vfEDIckK5RSiJoqyRLdBevA3Dvv0SVPuqouh4DaN2LWNJOgFzrt6KxJbVAF6a_UpzBaEJRVO0X3_7m7wi_-aOLf5oPqsc2Rd5LFbow0ghNr6mxCXEeO5VQ9rkdvfM-7sAM4ulNJjEUf_IAfTXhHU9sj6HK_SxBjA8tHF9zT1jOx59a36YjVrp6lAxcylS8PsDXWV5naerX7MTJHXV5cmlEdbW8uIMQwKS1Y2R2w', 0, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-lexus-es-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuDT52f15zUg_xA-xANN-dCaXv7HtCXjGvOrSZ3EEJfobbbIMXWZnm9mEktxeS-E2KwY3OW7xUAyDHJVZ4QnUm_Wcz3ynHdjeX8bjmSPbfsm0WgV8AScG_YwAVRR5_0R1Sqq6c7IiDfFvUXRK2gTpyNjYGBOBM3M5b0w18emsv6lamP5bIrTzY2Kp6U-glyBiFpFDAkW1yYtRMP9rA7R-XZVYQQmQiigVTdDw_rrO7GyjuVB_L4_9pqhuq9AgL7Li5CL7dVkdq9F7XE', 1, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-lexus-es-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuCI7GI67cd6jzTLSlhJmEPOJZZhrp1FjnHPa4Rlgs7i4cwb-9xchzGNUNwq8mM7M4QAR5uxfLKaO8NMhcsuSFlqks6D45EpzAWc02A80wuw4mFZLgNargnw7HF0FYvagQpNn1OvDuQwUa7WRLJ-TS5nH8vcIkhVBuer9OuPoUUGpxugQcGH5HKNrB1XDrtQhwbv_MsQZeq7xEtB-U573tnSPuIXIOzhs4AWLBtZ2l5iTeX-Dg5ddWxP5bRWGVW7N2PjBy88E9Z1pac', 2, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-lexus-es-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuD5Swu_VfY8IYgBgtCLqdAKgXJhY0t8G3NFrL8qTkiU44-P7b0xd4dQziHP1ghsmtbfRVNSzKYN4RDBi9zLkHkSLlWh_MQLgPP5IWdw61BJqGpgJCUuLvD5fX9_6dUqcFkJAmJfmZcoyaA9zU5pGH58epqw7pyi0uub5aZwr3jLEE7KwIw_wOF1m2MiFcMriGWniMn-Mocixe-uP_EocYcG43OJR5FS36YbZiwJ724cuVrhr6wy1Ne2B3Ic9Gt21MmQSzmfFm5FTMM', 3, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-lexus-es-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuAx6Rclw6OJt765M0v-ShtMYuYxM_y7xXCmC2FWOUYhHoaBpcuHQ_KJ7U432s3IDy08d-jNUjzyUtjrTv1jbH1E59-vhzQO3QfBsBvZvd9ttRFKguhpJ7RHUegUn5CEsdKCh_JD7eNmc84LcZWvxUU7bbC2kglPs-P-iKm4P3YJiKw3lJbaxbZcXLsKnImzDI5NHX7HvvasSrEKgEzOC1WpY1_pgdnnZQldPOpnIuogs4UWhkjab70BFh_Yxwkpb66zzujg_lqW4f8', 4, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-lexus-es-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuCX2OnbrN_OlmcbFkbfG57QSrXZWDCFn0gdz7Ooq2J_eTeTNVshs0Ehow1j1v8Etk5TwG2d3aL3B-3PSL54wXSHv9sM8ch_GPPV6tz4LTfv0VB8pmGM6qR98icOkm6KUAvMy73QbwUUc-wOsPLTU-bKq8Dd-dWtTH2RlOU4Te226j03i-jCjg2D0VRm_-4gY3Zj4uTakTcSYZKgY19sHTzTbQ96sOdDfIlq_xm1I2PhBPnQEKtLeMT1Fr99fHWszJHsvtK2-2rsB5E', 5, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-lexus-es-350';

INSERT INTO `vehicles` (`user_id`, `title`, `slug`, `status`, `year`, `make`, `model`, `price`, `mileage`, `transmission`, `fuel_type`, `drive`, `body_type`, `condition`, `engine_size`, `location`, `features`, `exterior_color`, `interior_color`, `description`, `submitted_at`, `approved_at`, `approved_by`, `created_at`, `updated_at`)
SELECT u.id, '2023 Lamborghini Urus', '2023-lamborghini-urus', 'approved', 2023, 'Lamborghini', 'Urus', 305000, 1200, 'Automatic', 'Petrol', 'AWD', 'SUV', 'used', '4.0L V8 twin-turbo', 'Los Angeles, CA', '["ANIMA drive modes","Carbon ceramic brakes","Bang & Olufsen 3D","Night vision","Rear-wheel steering"]', 'Giallo Auge', 'Nero Ade', 'Demo listing: Urus with aggressive styling and daily usability. Gallery combines remaining Mercedes grid shots and Tesla hero frames.', @demo_ts, @demo_ts, approver.id, @demo_ts, @demo_ts
FROM `users` u
JOIN `users` approver ON approver.email = 'admin@example.com'
WHERE u.email = 'demo@example.com'
ON DUPLICATE KEY UPDATE `user_id` = VALUES(`user_id`), `title` = VALUES(`title`), `status` = VALUES(`status`), `year` = VALUES(`year`), `make` = VALUES(`make`), `model` = VALUES(`model`), `price` = VALUES(`price`), `mileage` = VALUES(`mileage`), `transmission` = VALUES(`transmission`), `fuel_type` = VALUES(`fuel_type`), `drive` = VALUES(`drive`), `body_type` = VALUES(`body_type`), `condition` = VALUES(`condition`), `engine_size` = VALUES(`engine_size`), `location` = VALUES(`location`), `features` = VALUES(`features`), `exterior_color` = VALUES(`exterior_color`), `interior_color` = VALUES(`interior_color`), `description` = VALUES(`description`), `submitted_at` = VALUES(`submitted_at`), `approved_at` = VALUES(`approved_at`), `approved_by` = VALUES(`approved_by`), `rejection_reason` = NULL, `updated_at` = VALUES(`updated_at`);
DELETE vi FROM `vehicle_images` vi
JOIN `vehicles` v ON v.id = vi.vehicle_id
WHERE v.slug = '2023-lamborghini-urus';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuDT52f15zUg_xA-xANN-dCaXv7HtCXjGvOrSZ3EEJfobbbIMXWZnm9mEktxeS-E2KwY3OW7xUAyDHJVZ4QnUm_Wcz3ynHdjeX8bjmSPbfsm0WgV8AScG_YwAVRR5_0R1Sqq6c7IiDfFvUXRK2gTpyNjYGBOBM3M5b0w18emsv6lamP5bIrTzY2Kp6U-glyBiFpFDAkW1yYtRMP9rA7R-XZVYQQmQiigVTdDw_rrO7GyjuVB_L4_9pqhuq9AgL7Li5CL7dVkdq9F7XE', 0, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lamborghini-urus';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuCI7GI67cd6jzTLSlhJmEPOJZZhrp1FjnHPa4Rlgs7i4cwb-9xchzGNUNwq8mM7M4QAR5uxfLKaO8NMhcsuSFlqks6D45EpzAWc02A80wuw4mFZLgNargnw7HF0FYvagQpNn1OvDuQwUa7WRLJ-TS5nH8vcIkhVBuer9OuPoUUGpxugQcGH5HKNrB1XDrtQhwbv_MsQZeq7xEtB-U573tnSPuIXIOzhs4AWLBtZ2l5iTeX-Dg5ddWxP5bRWGVW7N2PjBy88E9Z1pac', 1, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lamborghini-urus';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuD5Swu_VfY8IYgBgtCLqdAKgXJhY0t8G3NFrL8qTkiU44-P7b0xd4dQziHP1ghsmtbfRVNSzKYN4RDBi9zLkHkSLlWh_MQLgPP5IWdw61BJqGpgJCUuLvD5fX9_6dUqcFkJAmJfmZcoyaA9zU5pGH58epqw7pyi0uub5aZwr3jLEE7KwIw_wOF1m2MiFcMriGWniMn-Mocixe-uP_EocYcG43OJR5FS36YbZiwJ724cuVrhr6wy1Ne2B3Ic9Gt21MmQSzmfFm5FTMM', 2, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lamborghini-urus';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuAx6Rclw6OJt765M0v-ShtMYuYxM_y7xXCmC2FWOUYhHoaBpcuHQ_KJ7U432s3IDy08d-jNUjzyUtjrTv1jbH1E59-vhzQO3QfBsBvZvd9ttRFKguhpJ7RHUegUn5CEsdKCh_JD7eNmc84LcZWvxUU7bbC2kglPs-P-iKm4P3YJiKw3lJbaxbZcXLsKnImzDI5NHX7HvvasSrEKgEzOC1WpY1_pgdnnZQldPOpnIuogs4UWhkjab70BFh_Yxwkpb66zzujg_lqW4f8', 3, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lamborghini-urus';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuCX2OnbrN_OlmcbFkbfG57QSrXZWDCFn0gdz7Ooq2J_eTeTNVshs0Ehow1j1v8Etk5TwG2d3aL3B-3PSL54wXSHv9sM8ch_GPPV6tz4LTfv0VB8pmGM6qR98icOkm6KUAvMy73QbwUUc-wOsPLTU-bKq8Dd-dWtTH2RlOU4Te226j03i-jCjg2D0VRm_-4gY3Zj4uTakTcSYZKgY19sHTzTbQ96sOdDfIlq_xm1I2PhBPnQEKtLeMT1Fr99fHWszJHsvtK2-2rsB5E', 4, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lamborghini-urus';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'https://lh3.googleusercontent.com/aida-public/AB6AXuB86za3jd2sQu83szzqHSezMl_I7t0cmFztbHt18TYAyJ1UTwT_-Sv49DKASvnObsTBNRUP2XxEm48L74HXFpt6qbjDyUZ-bowk-9vp_O6Mh9NQOQZFrCbDKa-YmKvMWQPibBJUYX_sXhBe9MidGIcbEIiwDdFo7Ff44VYcpVtO0aqdour27tUxwWoaSs9TYgV9JnGYCbE2mKe9LLJbQQi1AsKoWaWslpY9QgOtd3b71fQblFw0ymLrpBB81AgzAF_g1fbdj-U0oG8', 5, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lamborghini-urus';

-- Ensure demo rows stay public if a DB had been partially edited
UPDATE `vehicles` v
JOIN `users` a ON a.email = 'admin@example.com'
SET
  v.`status` = 'approved',
  v.`approved_at` = COALESCE(v.`approved_at`, @demo_ts),
  v.`approved_by` = a.id,
  v.`rejection_reason` = NULL,
  v.`updated_at` = NOW()
WHERE v.`slug` IN (
  '2021-bmw-m4-competition',
  '2022-audi-rs6-avant',
  '2023-porsche-911-gt3',
  '2023-lexus-rx-350',
  '2022-lexus-es-350',
  '2023-lamborghini-urus'
);

-- -----------------------------------------------------------------------------
-- Add future one-off patches below (ALTER TABLE, indexes, data backfills).
-- Document each change with a date and the matching Laravel migration name if any.
-- -----------------------------------------------------------------------------

-- Example (commented):
-- -- 2026-04-20: example index — see migrations/2026_xx_xx_xxxx_example.php
-- ALTER TABLE `vehicles` ADD INDEX `vehicles_example_index` (`some_column`);
