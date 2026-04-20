-- =============================================================================
-- Auto Torque Ltd — manual MySQL / MariaDB patches (phpMyAdmin or CLI)
-- =============================================================================
-- Primary path: `php artisan migrate` (Laravel migrations in `database/migrations/` are canonical).
-- Use this file only when migrations cannot be run on the server, or for one-off operational fixes.
--
-- Schema and data baseline: prefer Laravel migrations + seeders directly.
-- Site content (CMS HTML, settings, demo listings): use `php artisan db:seed`.
--
-- Fallback + hotfix SQL only (not routine deploys).
--
-- DEMO INVENTORY: six approved listings from `DemoData` / `VehiclesSeeder`, each with six gallery rows.
-- `vehicle_images.path` values are web paths under `public/` (e.g. asset/images/media/01-6-1-1.jpg), same as
-- the seeder — resolved in PHP via `asset()` / VehicleImageUrl (not filesystem paths like public/...). Safe to re-run.
-- =============================================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- -----------------------------------------------------------------------------
-- Repair: `migrations` table empty after manual SQL import (Laravel needs rows here)
-- Run only if your schema already matches `database/migrations/*.php`.
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
-- Duplicate safe with IF NOT EXISTS if you patch an old DB.
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
-- Image paths: `asset/images/media/*.jpg` (bundled under `public/asset/`), kept in sync with `DemoData::localDemoPool()`.
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
SELECT u.id, '2021 BMW M4 Competition', '2021-bmw-m4-competition', 'approved', 2021, 'BMW', 'M4', 89900, 12500, 'Automatic', 'Petrol', 'RWD', 'Coupe', 'used', '3.0L I6 twin-turbo', 'Miami, FL', '["M Sport package","Carbon roof","Live Cockpit Professional","Harman Kardon","Head-up display"]', 'Isle of Man Green', 'Silverstone', 'Demo listing: high-performance M4 Competition with adaptive M suspension and M Sport brakes. Includes six local media images.', @demo_ts, @demo_ts, approver.id, @demo_ts, @demo_ts
FROM `users` u
JOIN `users` approver ON approver.email = 'admin@example.com'
WHERE u.email = 'demo@example.com'
ON DUPLICATE KEY UPDATE `user_id` = VALUES(`user_id`), `title` = VALUES(`title`), `status` = VALUES(`status`), `year` = VALUES(`year`), `make` = VALUES(`make`), `model` = VALUES(`model`), `price` = VALUES(`price`), `mileage` = VALUES(`mileage`), `transmission` = VALUES(`transmission`), `fuel_type` = VALUES(`fuel_type`), `drive` = VALUES(`drive`), `body_type` = VALUES(`body_type`), `condition` = VALUES(`condition`), `engine_size` = VALUES(`engine_size`), `location` = VALUES(`location`), `features` = VALUES(`features`), `exterior_color` = VALUES(`exterior_color`), `interior_color` = VALUES(`interior_color`), `description` = VALUES(`description`), `submitted_at` = VALUES(`submitted_at`), `approved_at` = VALUES(`approved_at`), `approved_by` = VALUES(`approved_by`), `rejection_reason` = NULL, `updated_at` = VALUES(`updated_at`);
DELETE vi FROM `vehicle_images` vi
JOIN `vehicles` v ON v.id = vi.vehicle_id
WHERE v.slug = '2021-bmw-m4-competition';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-6-1-1.jpg', 0, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2021-bmw-m4-competition';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-7-1-1.jpg', 1, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2021-bmw-m4-competition';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-10-1.jpg', 2, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2021-bmw-m4-competition';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-24-1.jpg', 3, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2021-bmw-m4-competition';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-6-1-1.jpg', 4, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2021-bmw-m4-competition';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-7-1-1.jpg', 5, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2021-bmw-m4-competition';

INSERT INTO `vehicles` (`user_id`, `title`, `slug`, `status`, `year`, `make`, `model`, `price`, `mileage`, `transmission`, `fuel_type`, `drive`, `body_type`, `condition`, `engine_size`, `location`, `features`, `exterior_color`, `interior_color`, `description`, `submitted_at`, `approved_at`, `approved_by`, `created_at`, `updated_at`)
SELECT u.id, '2022 Audi RS6 Avant', '2022-audi-rs6-avant', 'approved', 2022, 'Audi', 'RS6 Avant', 112000, 5200, 'Automatic', 'Petrol', 'AWD', 'Wagon', 'used', '4.0L V8 twin-turbo', 'Austin, TX', '["RS sport exhaust","Matrix LED","Bang & Olufsen","Adaptive air suspension","Tour assist"]', 'Nardo Grey', 'Black', 'Demo listing: RS6 Avant with quattro sport differential and dynamic ride control. Includes six local media images.', @demo_ts, @demo_ts, approver.id, @demo_ts, @demo_ts
FROM `users` u
JOIN `users` approver ON approver.email = 'admin@example.com'
WHERE u.email = 'demo@example.com'
ON DUPLICATE KEY UPDATE `user_id` = VALUES(`user_id`), `title` = VALUES(`title`), `status` = VALUES(`status`), `year` = VALUES(`year`), `make` = VALUES(`make`), `model` = VALUES(`model`), `price` = VALUES(`price`), `mileage` = VALUES(`mileage`), `transmission` = VALUES(`transmission`), `fuel_type` = VALUES(`fuel_type`), `drive` = VALUES(`drive`), `body_type` = VALUES(`body_type`), `condition` = VALUES(`condition`), `engine_size` = VALUES(`engine_size`), `location` = VALUES(`location`), `features` = VALUES(`features`), `exterior_color` = VALUES(`exterior_color`), `interior_color` = VALUES(`interior_color`), `description` = VALUES(`description`), `submitted_at` = VALUES(`submitted_at`), `approved_at` = VALUES(`approved_at`), `approved_by` = VALUES(`approved_by`), `rejection_reason` = NULL, `updated_at` = VALUES(`updated_at`);
DELETE vi FROM `vehicle_images` vi
JOIN `vehicles` v ON v.id = vi.vehicle_id
WHERE v.slug = '2022-audi-rs6-avant';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-7-1-1.jpg', 0, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-audi-rs6-avant';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-10-1.jpg', 1, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-audi-rs6-avant';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-24-1.jpg', 2, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-audi-rs6-avant';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-6-1-1.jpg', 3, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-audi-rs6-avant';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-7-1-1.jpg', 4, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-audi-rs6-avant';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-10-1.jpg', 5, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-audi-rs6-avant';

INSERT INTO `vehicles` (`user_id`, `title`, `slug`, `status`, `year`, `make`, `model`, `price`, `mileage`, `transmission`, `fuel_type`, `drive`, `body_type`, `condition`, `engine_size`, `location`, `features`, `exterior_color`, `interior_color`, `description`, `submitted_at`, `approved_at`, `approved_by`, `created_at`, `updated_at`)
SELECT u.id, '2023 Porsche 911 GT3', '2023-porsche-911-gt3', 'approved', 2023, 'Porsche', '911 GT3', 185500, 850, 'PDK', 'Petrol', 'RWD', 'Coupe', 'used', '4.0L flat-6', 'Scottsdale, AZ', '["Clubsport package","PCCB","Front axle lift","LED-Matrix headlights","Track Precision app"]', 'Shark Blue', 'Black', 'Demo listing: track-focused 911 GT3 with Clubsport package and PCCB. Includes six local media images.', @demo_ts, @demo_ts, approver.id, @demo_ts, @demo_ts
FROM `users` u
JOIN `users` approver ON approver.email = 'admin@example.com'
WHERE u.email = 'demo@example.com'
ON DUPLICATE KEY UPDATE `user_id` = VALUES(`user_id`), `title` = VALUES(`title`), `status` = VALUES(`status`), `year` = VALUES(`year`), `make` = VALUES(`make`), `model` = VALUES(`model`), `price` = VALUES(`price`), `mileage` = VALUES(`mileage`), `transmission` = VALUES(`transmission`), `fuel_type` = VALUES(`fuel_type`), `drive` = VALUES(`drive`), `body_type` = VALUES(`body_type`), `condition` = VALUES(`condition`), `engine_size` = VALUES(`engine_size`), `location` = VALUES(`location`), `features` = VALUES(`features`), `exterior_color` = VALUES(`exterior_color`), `interior_color` = VALUES(`interior_color`), `description` = VALUES(`description`), `submitted_at` = VALUES(`submitted_at`), `approved_at` = VALUES(`approved_at`), `approved_by` = VALUES(`approved_by`), `rejection_reason` = NULL, `updated_at` = VALUES(`updated_at`);
DELETE vi FROM `vehicle_images` vi
JOIN `vehicles` v ON v.id = vi.vehicle_id
WHERE v.slug = '2023-porsche-911-gt3';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-10-1.jpg', 0, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-porsche-911-gt3';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-24-1.jpg', 1, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-porsche-911-gt3';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-6-1-1.jpg', 2, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-porsche-911-gt3';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-7-1-1.jpg', 3, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-porsche-911-gt3';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-10-1.jpg', 4, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-porsche-911-gt3';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-24-1.jpg', 5, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-porsche-911-gt3';

INSERT INTO `vehicles` (`user_id`, `title`, `slug`, `status`, `year`, `make`, `model`, `price`, `mileage`, `transmission`, `fuel_type`, `drive`, `body_type`, `condition`, `engine_size`, `location`, `features`, `exterior_color`, `interior_color`, `description`, `submitted_at`, `approved_at`, `approved_by`, `created_at`, `updated_at`)
SELECT u.id, '2023 Lexus RX 350', '2023-lexus-rx-350', 'approved', 2023, 'Lexus', 'RX 350', 62000, 2000, 'Automatic', 'Petrol', 'AWD', 'SUV', 'used', '3.5L V6', 'Dallas, TX', '["Premium package","Panoramic roof","Mark Levinson","Hands-free liftgate","Safety System+ 3.0"]', 'Atomic Silver', 'Rioja Red', 'Demo listing: low-mile RX 350 AWD with Premium package and Safety System+ 3.0. Includes six local media images.', @demo_ts, @demo_ts, approver.id, @demo_ts, @demo_ts
FROM `users` u
JOIN `users` approver ON approver.email = 'admin@example.com'
WHERE u.email = 'demo@example.com'
ON DUPLICATE KEY UPDATE `user_id` = VALUES(`user_id`), `title` = VALUES(`title`), `status` = VALUES(`status`), `year` = VALUES(`year`), `make` = VALUES(`make`), `model` = VALUES(`model`), `price` = VALUES(`price`), `mileage` = VALUES(`mileage`), `transmission` = VALUES(`transmission`), `fuel_type` = VALUES(`fuel_type`), `drive` = VALUES(`drive`), `body_type` = VALUES(`body_type`), `condition` = VALUES(`condition`), `engine_size` = VALUES(`engine_size`), `location` = VALUES(`location`), `features` = VALUES(`features`), `exterior_color` = VALUES(`exterior_color`), `interior_color` = VALUES(`interior_color`), `description` = VALUES(`description`), `submitted_at` = VALUES(`submitted_at`), `approved_at` = VALUES(`approved_at`), `approved_by` = VALUES(`approved_by`), `rejection_reason` = NULL, `updated_at` = VALUES(`updated_at`);
DELETE vi FROM `vehicle_images` vi
JOIN `vehicles` v ON v.id = vi.vehicle_id
WHERE v.slug = '2023-lexus-rx-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-24-1.jpg', 0, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lexus-rx-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-6-1-1.jpg', 1, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lexus-rx-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-7-1-1.jpg', 2, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lexus-rx-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-10-1.jpg', 3, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lexus-rx-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-24-1.jpg', 4, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lexus-rx-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-6-1-1.jpg', 5, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lexus-rx-350';

INSERT INTO `vehicles` (`user_id`, `title`, `slug`, `status`, `year`, `make`, `model`, `price`, `mileage`, `transmission`, `fuel_type`, `drive`, `body_type`, `condition`, `engine_size`, `location`, `features`, `exterior_color`, `interior_color`, `description`, `submitted_at`, `approved_at`, `approved_by`, `created_at`, `updated_at`)
SELECT u.id, '2022 Lexus ES 350', '2022-lexus-es-350', 'approved', 2022, 'Lexus', 'ES 350', 45900, 15000, 'Automatic', 'Petrol', 'FWD', 'Sedan', 'used', '3.5L V6', 'San Diego, CA', '["Ultra Luxury","Adaptive variable suspension","Panoramic monitor","Heated/ventilated seats"]', 'Obsidian', 'Acorn', 'Demo listing: comfortable ES 350 with Ultra Luxury package and strong highway manners. Includes six local media images.', @demo_ts, @demo_ts, approver.id, @demo_ts, @demo_ts
FROM `users` u
JOIN `users` approver ON approver.email = 'admin@example.com'
WHERE u.email = 'demo@example.com'
ON DUPLICATE KEY UPDATE `user_id` = VALUES(`user_id`), `title` = VALUES(`title`), `status` = VALUES(`status`), `year` = VALUES(`year`), `make` = VALUES(`make`), `model` = VALUES(`model`), `price` = VALUES(`price`), `mileage` = VALUES(`mileage`), `transmission` = VALUES(`transmission`), `fuel_type` = VALUES(`fuel_type`), `drive` = VALUES(`drive`), `body_type` = VALUES(`body_type`), `condition` = VALUES(`condition`), `engine_size` = VALUES(`engine_size`), `location` = VALUES(`location`), `features` = VALUES(`features`), `exterior_color` = VALUES(`exterior_color`), `interior_color` = VALUES(`interior_color`), `description` = VALUES(`description`), `submitted_at` = VALUES(`submitted_at`), `approved_at` = VALUES(`approved_at`), `approved_by` = VALUES(`approved_by`), `rejection_reason` = NULL, `updated_at` = VALUES(`updated_at`);
DELETE vi FROM `vehicle_images` vi
JOIN `vehicles` v ON v.id = vi.vehicle_id
WHERE v.slug = '2022-lexus-es-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-6-1-1.jpg', 0, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-lexus-es-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-7-1-1.jpg', 1, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-lexus-es-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-10-1.jpg', 2, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-lexus-es-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-24-1.jpg', 3, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-lexus-es-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-6-1-1.jpg', 4, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-lexus-es-350';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-7-1-1.jpg', 5, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2022-lexus-es-350';

INSERT INTO `vehicles` (`user_id`, `title`, `slug`, `status`, `year`, `make`, `model`, `price`, `mileage`, `transmission`, `fuel_type`, `drive`, `body_type`, `condition`, `engine_size`, `location`, `features`, `exterior_color`, `interior_color`, `description`, `submitted_at`, `approved_at`, `approved_by`, `created_at`, `updated_at`)
SELECT u.id, '2023 Lamborghini Urus', '2023-lamborghini-urus', 'approved', 2023, 'Lamborghini', 'Urus', 305000, 1200, 'Automatic', 'Petrol', 'AWD', 'SUV', 'used', '4.0L V8 twin-turbo', 'Los Angeles, CA', '["ANIMA drive modes","Carbon ceramic brakes","Bang & Olufsen 3D","Night vision","Rear-wheel steering"]', 'Giallo Auge', 'Nero Ade', 'Demo listing: Urus with aggressive styling, ANIMA drive modes, and daily usability. Includes six local media images.', @demo_ts, @demo_ts, approver.id, @demo_ts, @demo_ts
FROM `users` u
JOIN `users` approver ON approver.email = 'admin@example.com'
WHERE u.email = 'demo@example.com'
ON DUPLICATE KEY UPDATE `user_id` = VALUES(`user_id`), `title` = VALUES(`title`), `status` = VALUES(`status`), `year` = VALUES(`year`), `make` = VALUES(`make`), `model` = VALUES(`model`), `price` = VALUES(`price`), `mileage` = VALUES(`mileage`), `transmission` = VALUES(`transmission`), `fuel_type` = VALUES(`fuel_type`), `drive` = VALUES(`drive`), `body_type` = VALUES(`body_type`), `condition` = VALUES(`condition`), `engine_size` = VALUES(`engine_size`), `location` = VALUES(`location`), `features` = VALUES(`features`), `exterior_color` = VALUES(`exterior_color`), `interior_color` = VALUES(`interior_color`), `description` = VALUES(`description`), `submitted_at` = VALUES(`submitted_at`), `approved_at` = VALUES(`approved_at`), `approved_by` = VALUES(`approved_by`), `rejection_reason` = NULL, `updated_at` = VALUES(`updated_at`);
DELETE vi FROM `vehicle_images` vi
JOIN `vehicles` v ON v.id = vi.vehicle_id
WHERE v.slug = '2023-lamborghini-urus';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-7-1-1.jpg', 0, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lamborghini-urus';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-10-1.jpg', 1, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lamborghini-urus';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-24-1.jpg', 2, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lamborghini-urus';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-6-1-1.jpg', 3, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lamborghini-urus';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-7-1-1.jpg', 4, @demo_ts, @demo_ts
FROM `vehicles` v
WHERE v.slug = '2023-lamborghini-urus';
INSERT INTO `vehicle_images` (`vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`)
SELECT v.id, 'asset/images/media/01-10-1.jpg', 5, @demo_ts, @demo_ts
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
