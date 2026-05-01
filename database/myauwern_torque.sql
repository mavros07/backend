-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 01, 2026 at 09:05 AM
-- Server version: 11.4.10-MariaDB-cll-lve-log
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myauwern_torque`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_audit_trails`
--

CREATE TABLE `admin_audit_trails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `method` varchar(10) NOT NULL,
  `path` varchar(255) NOT NULL,
  `route_name` varchar(255) DEFAULT NULL,
  `status_code` smallint(5) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(1000) DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_audit_trails`
--

INSERT INTO `admin_audit_trails` (`id`, `user_id`, `method`, `path`, `route_name`, `status_code`, `ip_address`, `user_agent`, `meta`, `created_at`, `updated_at`) VALUES
(1, 1, 'PUT', '/admin/pages/home', 'admin.pages.update', 302, '105.113.107.62', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-22 13:35:22', '2026-04-22 13:35:22'),
(2, 1, 'POST', '/admin/media', 'admin.media.upload', 201, '102.88.108.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 02:46:36', '2026-04-27 02:46:36'),
(3, 1, 'PUT', '/admin/pages/home', 'admin.pages.update', 302, '102.88.108.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 02:46:45', '2026-04-27 02:46:45'),
(4, 1, 'PUT', '/admin/pages/home', 'admin.pages.update', 302, '102.88.108.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 02:49:48', '2026-04-27 02:49:48'),
(5, 1, 'POST', '/admin/media', 'admin.media.upload', 201, '102.88.108.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 02:56:42', '2026-04-27 02:56:42'),
(6, 1, 'PUT', '/admin/pages/home', 'admin.pages.update', 302, '102.88.108.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 02:59:04', '2026-04-27 02:59:04'),
(7, 1, 'POST', '/admin/media', 'admin.media.upload', 201, '102.88.108.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 03:08:11', '2026-04-27 03:08:11'),
(8, 1, 'PUT', '/admin/pages/home', 'admin.pages.update', 302, '102.88.108.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 03:09:08', '2026-04-27 03:09:08'),
(9, 1, 'POST', '/admin/media', 'admin.media.upload', 201, '102.88.108.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 07:17:33', '2026-04-27 07:17:33'),
(10, 1, 'POST', '/admin/vehicles/49/approve', 'admin.vehicles.approve', 500, '102.88.108.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 07:18:07', '2026-04-27 07:18:07'),
(11, 1, 'POST', '/admin/vehicles/49/approve', 'admin.vehicles.approve', 500, '102.88.108.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 07:20:07', '2026-04-27 07:20:07'),
(12, 1, 'POST', '/admin/media', 'admin.media.upload', 201, '102.88.108.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 07:21:24', '2026-04-27 07:21:24'),
(13, 1, 'POST', '/admin/media', 'admin.media.upload', 201, '102.88.108.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 07:21:43', '2026-04-27 07:21:43'),
(14, 1, 'POST', '/admin/media', 'admin.media.upload', 201, '102.88.114.76', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 21:39:22', '2026-04-27 21:39:22'),
(15, 1, 'PUT', '/admin/pages/about', 'admin.pages.update', 302, '102.88.114.76', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(16, 1, 'POST', '/admin/media', 'admin.media.upload', 201, '102.88.114.76', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 21:46:22', '2026-04-27 21:46:22'),
(17, 1, 'PUT', '/admin/pages/about', 'admin.pages.update', 302, '102.88.114.76', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 21:46:34', '2026-04-27 21:46:34'),
(18, 1, 'POST', '/admin/media', 'admin.media.upload', 201, '102.88.114.76', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 21:50:21', '2026-04-27 21:50:21'),
(19, 1, 'PUT', '/admin/pages/about', 'admin.pages.update', 302, '102.88.114.76', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 21:50:32', '2026-04-27 21:50:32'),
(20, 1, 'POST', '/admin/media', 'admin.media.upload', 201, '102.88.114.76', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 21:56:36', '2026-04-27 21:56:36'),
(21, 1, 'PUT', '/admin/pages/about', 'admin.pages.update', 302, '102.88.114.76', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 21:56:46', '2026-04-27 21:56:46'),
(22, 1, 'POST', '/admin/media', 'admin.media.upload', 201, '102.88.114.76', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 21:58:16', '2026-04-27 21:58:16'),
(23, 1, 'PUT', '/admin/pages/about', 'admin.pages.update', 302, '102.88.114.76', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 21:58:26', '2026-04-27 21:58:26'),
(24, 1, 'POST', '/admin/media', 'admin.media.upload', 201, '102.88.114.76', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 22:47:18', '2026-04-27 22:47:18'),
(25, 1, 'PUT', '/admin/pages/about', 'admin.pages.update', 302, '102.88.114.76', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 22:47:49', '2026-04-27 22:47:49'),
(26, 1, 'PUT', '/admin/pages/faq', 'admin.pages.update', 302, '102.88.114.76', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(27, 1, 'PUT', '/admin/pages/faq', 'admin.pages.update', 302, '102.88.114.76', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-27 23:25:44', '2026-04-27 23:25:44'),
(28, 1, 'PUT', '/admin/pages/faq', 'admin.pages.update', 302, '102.88.114.206', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-28 05:14:11', '2026-04-28 05:14:11'),
(29, 1, 'PUT', '/admin/pages/faq', 'admin.pages.update', 302, '102.88.114.206', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-28 05:16:03', '2026-04-28 05:16:03'),
(30, 1, 'PUT', '/admin/pages/contact', 'admin.pages.update', 302, '102.88.114.206', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-28 05:28:43', '2026-04-28 05:28:43'),
(31, 1, 'PUT', '/admin/pages/contact', 'admin.pages.update', 302, '102.88.114.206', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-28 05:34:05', '2026-04-28 05:34:05'),
(32, 1, 'PUT', '/admin/pages/home', 'admin.pages.update', 302, '102.88.114.206', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-28 05:44:58', '2026-04-28 05:44:58'),
(33, 1, 'POST', '/admin/media', 'admin.media.upload', 422, '51.158.205.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-29 04:26:17', '2026-04-29 04:26:17'),
(34, 1, 'POST', '/admin/media', 'admin.media.upload', 422, '51.158.205.226', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-29 04:26:37', '2026-04-29 04:26:37'),
(35, 1, 'PUT', '/admin/settings', 'admin.settings.update', 302, '102.88.111.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-29 16:17:46', '2026-04-29 16:17:46'),
(36, 1, 'POST', '/admin/media', 'admin.media.upload', 422, '102.88.111.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-29 17:06:36', '2026-04-29 17:06:36'),
(37, 1, 'POST', '/admin/media', 'admin.media.upload', 201, '102.88.111.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-29 17:27:20', '2026-04-29 17:27:20'),
(38, 1, 'POST', '/admin/media', 'admin.media.upload', 201, '102.88.111.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-29 17:33:27', '2026-04-29 17:33:27'),
(39, 1, 'PUT', '/admin/settings', 'admin.settings.update', 302, '102.88.111.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '{\"query\":[]}', '2026-04-29 18:50:45', '2026-04-29 18:50:45');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('auto-torque-ltd-cache-0b69d02cdd2e6fcb8ad9206535b1a67c5dcac264', 'i:1;', 1776770965),
('auto-torque-ltd-cache-0b69d02cdd2e6fcb8ad9206535b1a67c5dcac264:timer', 'i:1776770965;', 1776770965),
('auto-torque-ltd-cache-0e7538763e75b144c8c0b83c23e95b9e296fba0d', 'i:1;', 1776776335),
('auto-torque-ltd-cache-0e7538763e75b144c8c0b83c23e95b9e296fba0d:timer', 'i:1776776335;', 1776776335),
('auto-torque-ltd-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:6;', 1777471449),
('auto-torque-ltd-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1777471449;', 1777471449),
('auto-torque-ltd-cache-5e8b071f8e64452c7e5dff5b59b28456341efc02', 'i:1;', 1777421906),
('auto-torque-ltd-cache-5e8b071f8e64452c7e5dff5b59b28456341efc02:timer', 'i:1777421906;', 1777421906),
('auto-torque-ltd-cache-6d94b43d72ee669923996a263dfb4fd56c8f3860', 'i:1;', 1776848931),
('auto-torque-ltd-cache-6d94b43d72ee669923996a263dfb4fd56c8f3860:timer', 'i:1776848931;', 1776848931),
('auto-torque-ltd-cache-86f0ba4a5592d58baf9da6df9208da07101db6bb', 'i:1;', 1777289589),
('auto-torque-ltd-cache-86f0ba4a5592d58baf9da6df9208da07101db6bb:timer', 'i:1777289589;', 1777289589),
('auto-torque-ltd-cache-89657785ba2f34f689d00cc12fde35b0b567d405', 'i:1;', 1777464997),
('auto-torque-ltd-cache-89657785ba2f34f689d00cc12fde35b0b567d405:timer', 'i:1777464997;', 1777464997),
('auto-torque-ltd-cache-8dc50036a4c6300e8189ada495c3c21a3f4eb2cf', 'i:1;', 1777338581),
('auto-torque-ltd-cache-8dc50036a4c6300e8189ada495c3c21a3f4eb2cf:timer', 'i:1777338581;', 1777338581),
('auto-torque-ltd-cache-95b5ad0feade317d38cefa91078cc1e2b2926cb9', 'i:1;', 1777241363),
('auto-torque-ltd-cache-95b5ad0feade317d38cefa91078cc1e2b2926cb9:timer', 'i:1777241363;', 1777241363),
('auto-torque-ltd-cache-a05f2211ca019e762b57cc64c51c230bd438c8d4', 'i:1;', 1776823478),
('auto-torque-ltd-cache-a05f2211ca019e762b57cc64c51c230bd438c8d4:timer', 'i:1776823478;', 1776823478),
('auto-torque-ltd-cache-d343154ca31cd76a5da6f4067be07ee8f946c572', 'i:1;', 1776795451),
('auto-torque-ltd-cache-d343154ca31cd76a5da6f4067be07ee8f946c572:timer', 'i:1776795451;', 1776795451),
('auto-torque-ltd-cache-dbfe4f480949e024f6a6dca434a598f91ada47f2', 'i:1;', 1777635997),
('auto-torque-ltd-cache-dbfe4f480949e024f6a6dca434a598f91ada47f2:timer', 'i:1777635997;', 1777635997),
('auto-torque-ltd-cache-e8d28703fb9a3a5b7acfaece54137244fb3837eb', 'i:1;', 1776786485),
('auto-torque-ltd-cache-e8d28703fb9a3a5b7acfaece54137244fb3837eb:timer', 'i:1776786485;', 1776786485),
('auto-torque-ltd-cache-eab37a33a4e074c6c45f6d87c1d6dc1a408ae501', 'i:1;', 1776711646),
('auto-torque-ltd-cache-eab37a33a4e074c6c45f6d87c1d6dc1a408ae501:timer', 'i:1776711646;', 1776711646),
('auto-torque-ltd-cache-fecb0e6b318639be56e4a2c1dd74de564c27a3a1', 'i:1;', 1777259505),
('auto-torque-ltd-cache-fecb0e6b318639be56e4a2c1dd74de564c27a3a1:timer', 'i:1777259505;', 1777259505),
('auto-torque-ltd-cache-fx_rates_USD', 'a:166:{s:3:\"USD\";d:1;s:3:\"AED\";d:3.6725;s:3:\"AFN\";d:64.088008;s:3:\"ALL\";d:82.055579;s:3:\"AMD\";d:370.661985;s:3:\"ANG\";d:1.79;s:3:\"AOA\";d:925.261182;s:3:\"ARS\";d:1381.0954;s:3:\"AUD\";d:1.393723;s:3:\"AWG\";d:1.79;s:3:\"AZN\";d:1.704298;s:3:\"BAM\";d:1.668982;s:3:\"BBD\";d:2;s:3:\"BDT\";d:122.889603;s:3:\"BGN\";d:1.668982;s:3:\"BHD\";d:0.376;s:3:\"BIF\";d:2981.180676;s:3:\"BMD\";d:1;s:3:\"BND\";d:1.274551;s:3:\"BOB\";d:6.945249;s:3:\"BRL\";d:4.990919;s:3:\"BSD\";d:1;s:3:\"BTN\";d:94.978356;s:3:\"BWP\";d:13.770097;s:3:\"BYN\";d:2.825093;s:3:\"BZD\";d:2;s:3:\"CAD\";d:1.361227;s:3:\"CDF\";d:2315.102755;s:3:\"CHF\";d:0.783348;s:3:\"CLF\";d:0.022987;s:3:\"CLP\";d:908.601375;s:3:\"CNH\";d:6.830965;s:3:\"CNY\";d:6.840908;s:3:\"COP\";d:3634.644882;s:3:\"CRC\";d:456.285983;s:3:\"CUP\";d:24;s:3:\"CVE\";d:94.093211;s:3:\"CZK\";d:20.824684;s:3:\"DJF\";d:177.721;s:3:\"DKK\";d:6.370414;s:3:\"DOP\";d:59.579269;s:3:\"DZD\";d:133.028975;s:3:\"EGP\";d:53.622122;s:3:\"ERN\";d:15;s:3:\"ETB\";d:156.135567;s:3:\"EUR\";d:0.853339;s:3:\"FJD\";d:2.209245;s:3:\"FKP\";d:0.737551;s:3:\"FOK\";d:6.370327;s:3:\"GBP\";d:0.737561;s:3:\"GEL\";d:2.688306;s:3:\"GGP\";d:0.737551;s:3:\"GHS\";d:11.220017;s:3:\"GIP\";d:0.737551;s:3:\"GMD\";d:74.160318;s:3:\"GNF\";d:8772.945317;s:3:\"GTQ\";d:7.66707;s:3:\"GYD\";d:209.244255;s:3:\"HKD\";d:7.833535;s:3:\"HNL\";d:26.682153;s:3:\"HRK\";d:6.429468;s:3:\"HTG\";d:130.90555;s:3:\"HUF\";d:311.712023;s:3:\"IDR\";d:17308.21837;s:3:\"ILS\";d:2.95092;s:3:\"IMP\";d:0.737551;s:3:\"INR\";d:94.978597;s:3:\"IQD\";d:1310.588483;s:3:\"IRR\";d:1233794.062752;s:3:\"ISK\";d:123.090005;s:3:\"JEP\";d:0.737551;s:3:\"JMD\";d:157.603692;s:3:\"JOD\";d:0.709;s:3:\"JPY\";d:157.16387;s:3:\"KES\";d:129.105102;s:3:\"KGS\";d:87.55248;s:3:\"KHR\";d:3993.586658;s:3:\"KID\";d:1.392349;s:3:\"KMF\";d:419.814315;s:3:\"KRW\";d:1475.699372;s:3:\"KWD\";d:0.307958;s:3:\"KYD\";d:0.833333;s:3:\"KZT\";d:463.419275;s:3:\"LAK\";d:21996.269724;s:3:\"LBP\";d:89500;s:3:\"LKR\";d:319.159144;s:3:\"LRD\";d:184.292454;s:3:\"LSL\";d:16.703927;s:3:\"LYD\";d:6.346061;s:3:\"MAD\";d:9.237592;s:3:\"MDL\";d:17.298334;s:3:\"MGA\";d:4150.837835;s:3:\"MKD\";d:52.693149;s:3:\"MMK\";d:2107.470519;s:3:\"MNT\";d:3588.166805;s:3:\"MOP\";d:8.068541;s:3:\"MRU\";d:39.996481;s:3:\"MUR\";d:47.030975;s:3:\"MVR\";d:15.472494;s:3:\"MWK\";d:1741.035206;s:3:\"MXN\";d:17.502106;s:3:\"MYR\";d:3.96835;s:3:\"MZN\";d:63.633173;s:3:\"NAD\";d:16.703927;s:3:\"NGN\";d:1375.420346;s:3:\"NIO\";d:36.903663;s:3:\"NOK\";d:9.291767;s:3:\"NPR\";d:151.965369;s:3:\"NZD\";d:1.697248;s:3:\"OMR\";d:0.384497;s:3:\"PAB\";d:1;s:3:\"PEN\";d:3.523752;s:3:\"PGK\";d:4.356724;s:3:\"PHP\";d:61.435668;s:3:\"PKR\";d:279.483507;s:3:\"PLN\";d:3.63497;s:3:\"PYG\";d:6268.908815;s:3:\"QAR\";d:3.64;s:3:\"RON\";d:4.421471;s:3:\"RSD\";d:100.258277;s:3:\"RUB\";d:74.983401;s:3:\"RWF\";d:1463.884288;s:3:\"SAR\";d:3.75;s:3:\"SBD\";d:7.938608;s:3:\"SCR\";d:14.299528;s:3:\"SDG\";d:511.710589;s:3:\"SEK\";d:9.249375;s:3:\"SGD\";d:1.274553;s:3:\"SHP\";d:0.737551;s:3:\"SLE\";d:24.673437;s:3:\"SLL\";d:24673.436702;s:3:\"SOS\";d:571.358482;s:3:\"SRD\";d:37.515711;s:3:\"SSP\";d:4640.524441;s:3:\"STN\";d:20.906758;s:3:\"SYP\";d:113.339083;s:3:\"SZL\";d:16.703927;s:3:\"THB\";d:32.555374;s:3:\"TJS\";d:9.40196;s:3:\"TMT\";d:3.49966;s:3:\"TND\";d:2.889591;s:3:\"TOP\";d:2.368712;s:3:\"TRY\";d:45.175087;s:3:\"TTD\";d:6.785845;s:3:\"TVD\";d:1.392349;s:3:\"TWD\";d:31.623552;s:3:\"TZS\";d:2607.967934;s:3:\"UAH\";d:44.083314;s:3:\"UGX\";d:3715.389324;s:3:\"UYU\";d:40.009691;s:3:\"UZS\";d:11920.873452;s:3:\"VES\";d:489.5547;s:3:\"VND\";d:26295.551967;s:3:\"VUV\";d:118.58241;s:3:\"WST\";d:2.69722;s:3:\"XAF\";d:559.752421;s:3:\"XCD\";d:2.7;s:3:\"XCG\";d:1.79;s:3:\"XDR\";d:0.730874;s:3:\"XOF\";d:559.752421;s:3:\"XPF\";d:101.830419;s:3:\"YER\";d:239.395056;s:3:\"ZAR\";d:16.704084;s:3:\"ZMW\";d:18.880587;s:3:\"ZWG\";d:25.3419;s:3:\"ZWL\";d:25.3419;}', 1777643991),
('auto-torque-ltd-cache-site_settings_array', 'a:24:{s:12:\"dealer_phone\";s:15:\"+1 212-226-3126\";s:14:\"dealer_address\";s:45:\"1840 E Garvey Ave South West Covina, CA 91791\";s:18:\"dealer_hours_label\";s:10:\"Work Hours\";s:18:\"dealer_sales_phone\";s:14:\"(888) 354-1781\";s:18:\"dealer_sales_hours\";s:79:\"Mon – Fri: 09:00AM – 09:00PM\r\nSaturday: 09:00AM – 07:00PM\r\nSunday: Closed\";s:12:\"footer_about\";s:271:\"Fusce interdum ipsum egestas urna amet fringilla, et placerat ex venenatis. Aliquet luctus pharetra. Proin sed fringilla lectus… ar sit amet tellus in mollis. Proin nec egestas nibh, eget egestas urna. Phasellus sit amet vehicula nunc. In hac habitasse platea dictumst.\";s:14:\"copyright_line\";s:12:\"MyAutoTorque\";s:15:\"social_facebook\";s:25:\"https://www.facebook.com/\";s:16:\"social_instagram\";s:26:\"https://www.instagram.com/\";s:15:\"social_linkedin\";s:25:\"https://www.linkedin.com/\";s:14:\"social_youtube\";s:24:\"https://www.youtube.com/\";s:17:\"site_display_name\";s:13:\"My AutoTorque\";s:14:\"currency_label\";s:14:\"Currency (USD)\";s:20:\"dealer_service_hours\";s:79:\"Monday - Friday: 09:00AM - 09:00PM\r\nSaturday: 09:00AM - 07:00PM\r\nSunday: Closed\";s:18:\"dealer_parts_hours\";s:79:\"Monday - Friday: 09:00AM - 09:00PM\r\nSaturday: 09:00AM - 07:00PM\r\nSunday: Closed\";s:14:\"footer_tagline\";s:135:\"Premium automotive retail experience. Redefining the way you browse and buy luxury vehicles with curated inventory and bespoke service.\";s:17:\"footer_blog_title\";s:17:\"Latest Blog Posts\";s:24:\"footer_blog_entries_json\";s:2:\"[]\";s:18:\"newsletter_enabled\";s:1:\"0\";s:15:\"newsletter_note\";s:30:\"Get latest updates and offers.\";s:18:\"footer_privacy_url\";s:1:\"#\";s:16:\"footer_terms_url\";s:1:\"#\";s:9:\"logo_path\";s:67:\"storage/site-settings/logo-1fd139c4-b4b5-497e-84fd-8555744c63aa.png\";s:13:\"currency_code\";s:3:\"USD\";}', 2092834246);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_pages`
--

CREATE TABLE `cms_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `meta_description` text DEFAULT NULL,
  `content_html` longtext DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_pages`
--

INSERT INTO `cms_pages` (`id`, `slug`, `title`, `meta_description`, `content_html`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'home', 'Home', 'Browse premium vehicles and find your next car.', '', 1, '2026-04-17 00:36:01', '2026-04-28 05:44:58'),
(2, 'about', 'About Us', 'Learn about our dealership and team.', '', 1, '2026-04-17 00:36:01', '2026-04-27 22:47:49'),
(3, 'faq', 'FAQ', 'Frequently asked questions about buying and selling vehicles.', '<!-- Breads -->\r\n		<div class=\"container\">\r\n\r\n					<div data-elementor-type=\"wp-page\" data-elementor-id=\"2085\" class=\"elementor elementor-2085\">\r\n						<section class=\"elementor-section elementor-top-section elementor-element elementor-element-e918e5b elementor-section-boxed elementor-section-height-default elementor-section-height-default\" data-id=\"e918e5b\" data-element_type=\"section\">\r\n						<div class=\"elementor-container elementor-column-gap-default\">\r\n					<div class=\"elementor-column elementor-col-66 elementor-top-column elementor-element elementor-element-db41fc9\" data-id=\"db41fc9\" data-element_type=\"column\">\r\n			<div class=\"elementor-widget-wrap elementor-element-populated\">\r\n						<div class=\"elementor-element elementor-element-b5b7e90 elementor-widget elementor-widget-accordion\" data-id=\"b5b7e90\" data-element_type=\"widget\" data-widget_type=\"accordion.default\">\r\n				<div class=\"elementor-widget-container\">\r\n			<style>/*! elementor - v3.20.0 - 13-03-2024 */\r\n.elementor-accordion{text-align:left}.elementor-accordion .elementor-accordion-item{border:1px solid #d5d8dc}.elementor-accordion .elementor-accordion-item+.elementor-accordion-item{border-top:none}.elementor-accordion .elementor-tab-title{margin:0;padding:15px 20px;font-weight:700;line-height:1;cursor:pointer;outline:none}.elementor-accordion .elementor-tab-title .elementor-accordion-icon{display:inline-block;width:1.5em}.elementor-accordion .elementor-tab-title .elementor-accordion-icon svg{width:1em;height:1em}.elementor-accordion .elementor-tab-title .elementor-accordion-icon.elementor-accordion-icon-right{float:right;text-align:right}.elementor-accordion .elementor-tab-title .elementor-accordion-icon.elementor-accordion-icon-left{float:left;text-align:left}.elementor-accordion .elementor-tab-title .elementor-accordion-icon .elementor-accordion-icon-closed{display:block}.elementor-accordion .elementor-tab-title .elementor-accordion-icon .elementor-accordion-icon-opened,.elementor-accordion .elementor-tab-title.elementor-active .elementor-accordion-icon-closed{display:none}.elementor-accordion .elementor-tab-title.elementor-active .elementor-accordion-icon-opened{display:block}.elementor-accordion .elementor-tab-content{display:none;padding:15px 20px;border-top:1px solid #d5d8dc}@media (max-width:767px){.elementor-accordion .elementor-tab-title{padding:12px 15px}.elementor-accordion .elementor-tab-title .elementor-accordion-icon{width:1.2em}.elementor-accordion .elementor-tab-content{padding:7px 15px}}.e-con-inner>.elementor-widget-accordion,.e-con>.elementor-widget-accordion{width:var(--container-widget-width);--flex-grow:var(--container-widget-flex-grow)}</style>		<div class=\"elementor-accordion\">\r\n							<div class=\"elementor-accordion-item\">\r\n					<div id=\"elementor-tab-title-1901\" class=\"elementor-tab-title\" data-tab=\"1\" role=\"button\" aria-controls=\"elementor-tab-content-1901\" aria-expanded=\"false\">\r\n													<span class=\"elementor-accordion-icon elementor-accordion-icon-left\" aria-hidden=\"true\">\r\n															<span class=\"elementor-accordion-icon-closed\"><i class=\"far fa-plus-square\"></i></span>\r\n								<span class=\"elementor-accordion-icon-opened\"><i class=\"far fa-minus-square\"></i></span>\r\n														</span>\r\n												<a class=\"elementor-accordion-title\" tabindex=\"0\">Do You Want to Sell a Car?</a>\r\n					</div>\r\n					<div id=\"elementor-tab-content-1901\" class=\"elementor-tab-content elementor-clearfix\" data-tab=\"1\" role=\"region\" aria-labelledby=\"elementor-tab-title-1901\"><p><span style=\"color: #262829;\"><img decoding=\"async\" class=\"size-full wp-image-5821 alignleft\" src=\"assets/images/wp-uploads/sites/24/2022/10/faq.jpeg\" alt=\"\" width=\"255\" height=\"170\" srcset=\"assets/images/wp-uploads/sites/24/2022/10/faq.jpeg 255w, assets/images/wp-uploads/sites/24/2022/10/faq-100x68.jpeg 100w\" sizes=\"(max-width: 255px) 100vw, 255px\" />Whatâ€™s your car worth? Receive the absolute best value for your trade-in vehicle. We even handle all paperwork. Schedule your appointment today!</span></p><p><span style=\"color: #262829;\">Mauris nulla lorem, interdum varius orci vitae, bibendum sagittis tellus. Nulla elementum dolor dui, vel condimentum erat vestibulum molestie. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse sit amet risus lacus. Suspendisse pellentesque tempus enim ac hendrerit. Morbi cursus sapien eu nisl viverra mattis. Integer vestibulum enim dolor, sit amet maximus urna imperdiet ut.</span></p><p><span style=\"color: #262829;\">Fusce eu massa nec diam fermentum imperdiet ac vel est. Morbi condimentum imperdiet lorem, quis gravida lacus placerat eget. Quisque nunc massa, laoreet sed consectetur sed, elementum eu quam. Donec non molestie metus. Suspendisse placerat ante ac pharetra scelerisque. Duis ut tellus aliquet, lacinia lacus et, ullamcorper risus. Vivamus risus arcu, tempus nec mi convallis, congue tempor nibh. Praesent ullamcorper commodo elementum. Donec ultrices neque nec turpis semper molestie. Duis pulvinar quam sit amet tempus hendrerit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;</span></p></div>\r\n				</div>\r\n							<div class=\"elementor-accordion-item\">\r\n					<div id=\"elementor-tab-title-1902\" class=\"elementor-tab-title\" data-tab=\"2\" role=\"button\" aria-controls=\"elementor-tab-content-1902\" aria-expanded=\"false\">\r\n													<span class=\"elementor-accordion-icon elementor-accordion-icon-left\" aria-hidden=\"true\">\r\n															<span class=\"elementor-accordion-icon-closed\"><i class=\"far fa-plus-square\"></i></span>\r\n								<span class=\"elementor-accordion-icon-opened\"><i class=\"far fa-minus-square\"></i></span>\r\n														</span>\r\n												<a class=\"elementor-accordion-title\" tabindex=\"0\">Are You Looking for a New Car?</a>\r\n					</div>\r\n					<div id=\"elementor-tab-content-1902\" class=\"elementor-tab-content elementor-clearfix\" data-tab=\"2\" role=\"region\" aria-labelledby=\"elementor-tab-title-1902\"><p><span style=\"color: #262829;\">We appreciate you taking the time today to visit our web site. Our goal is to give you an interactive tour of our new and used inventory, as well as allow you to conveniently get a quote, schedule a service appointment, or apply for financing. The search for a luxury car is filled with high expectations.</span></p><p><span style=\"color: #262829;\">Mauris nulla lorem, interdum varius orci vitae, bibendum sagittis tellus. Nulla elementum dolor dui, vel condimentum erat vestibulum molestie. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse sit amet risus lacus. Suspendisse pellentesque tempus enim ac hendrerit. Morbi cursus sapien eu nisl viverra mattis. Integer vestibulum enim dolor, sit amet maximus urna imperdiet ut.</span></p><p><span style=\"color: #262829;\">Fusce eu massa nec diam fermentum imperdiet ac vel est. Morbi condimentum imperdiet lorem, quis gravida lacus placerat eget. Quisque nunc massa, laoreet sed consectetur sed, elementum eu quam. Donec non molestie metus. Suspendisse placerat ante ac pharetra scelerisque. Duis ut tellus aliquet, lacinia lacus et, ullamcorper risus. Vivamus risus arcu, tempus nec mi convallis, congue tempor nibh. Praesent ullamcorper commodo elementum. Donec ultrices neque nec turpis semper molestie. Duis pulvinar quam sit amet tempus hendrerit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;</span></p></div>\r\n				</div>\r\n							<div class=\"elementor-accordion-item\">\r\n					<div id=\"elementor-tab-title-1903\" class=\"elementor-tab-title\" data-tab=\"3\" role=\"button\" aria-controls=\"elementor-tab-content-1903\" aria-expanded=\"false\">\r\n													<span class=\"elementor-accordion-icon elementor-accordion-icon-left\" aria-hidden=\"true\">\r\n															<span class=\"elementor-accordion-icon-closed\"><i class=\"far fa-plus-square\"></i></span>\r\n								<span class=\"elementor-accordion-icon-opened\"><i class=\"far fa-minus-square\"></i></span>\r\n														</span>\r\n												<a class=\"elementor-accordion-title\" tabindex=\"0\">Maintain your car to stay safe on the road</a>\r\n					</div>\r\n					<div id=\"elementor-tab-content-1903\" class=\"elementor-tab-content elementor-clearfix\" data-tab=\"3\" role=\"region\" aria-labelledby=\"elementor-tab-title-1903\"><p><img decoding=\"async\" class=\"size-full wp-image-5821 alignleft\" src=\"assets/images/wp-uploads/sites/24/2022/10/faq.jpeg\" alt=\"\" width=\"255\" height=\"170\" srcset=\"assets/images/wp-uploads/sites/24/2022/10/faq.jpeg 255w, assets/images/wp-uploads/sites/24/2022/10/faq-100x68.jpeg 100w\" sizes=\"(max-width: 255px) 100vw, 255px\" /></p><p><span style=\"color: #262829;\">Phasellus finibus pharetra ante, ut luctus lectus hendrerit non. Maecenas lacinia ligula sed molestie volutpat. Curabitur lobortis enim eget pretium consequat. Nunc maximus cursus magna sed vehicula. Mauris nulla lorem, interdum varius orci vitae, bibendum sagittis tellus. Nulla elementum dolor dui, vel condimentum erat vestibulum molestie. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse sit amet risus lacus. Suspendisse pellentesque tempus enim ac hendrerit. Morbi cursus sapien eu nisl viverra mattis. Integer vestibulum enim dolor, sit amet maximus urna imperdiet ut.</span></p><p><span style=\"color: #262829;\">Fusce eu massa nec diam fermentum imperdiet ac vel est. Morbi condimentum imperdiet lorem, quis gravida lacus placerat eget. Quisque nunc massa, laoreet sed consectetur sed, elementum eu quam. Donec non molestie metus. Suspendisse placerat ante ac pharetra scelerisque. Duis ut tellus aliquet, lacinia lacus et, ullamcorper risus. Vivamus risus arcu, tempus nec mi convallis, congue tempor nibh. Praesent ullamcorper commodo elementum. Donec ultrices neque nec turpis semper molestie. Duis pulvinar quam sit amet tempus hendrerit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;</span></p></div>\r\n				</div>\r\n							<div class=\"elementor-accordion-item\">\r\n					<div id=\"elementor-tab-title-1904\" class=\"elementor-tab-title\" data-tab=\"4\" role=\"button\" aria-controls=\"elementor-tab-content-1904\" aria-expanded=\"false\">\r\n													<span class=\"elementor-accordion-icon elementor-accordion-icon-left\" aria-hidden=\"true\">\r\n															<span class=\"elementor-accordion-icon-closed\"><i class=\"far fa-plus-square\"></i></span>\r\n								<span class=\"elementor-accordion-icon-opened\"><i class=\"far fa-minus-square\"></i></span>\r\n														</span>\r\n												<a class=\"elementor-accordion-title\" tabindex=\"0\">We know how to handle a wide range of car services.</a>\r\n					</div>\r\n					<div id=\"elementor-tab-content-1904\" class=\"elementor-tab-content elementor-clearfix\" data-tab=\"4\" role=\"region\" aria-labelledby=\"elementor-tab-title-1904\"><p><span style=\"color: #262829;\">Phasellus finibus pharetra ante, ut luctus lectus hendrerit non. Maecenas lacinia ligula sed molestie volutpat. Curabitur lobortis enim eget pretium consequat. Nunc maximus cursus magna sed vehicula. Mauris nulla lorem, interdum varius orci vitae, bibendum sagittis tellus. Nulla elementum dolor dui, vel condimentum erat vestibulum molestie. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse sit amet risus lacus. Suspendisse pellentesque tempus enim ac hendrerit. Morbi cursus sapien eu nisl viverra mattis. Integer vestibulum enim dolor, sit amet maximus urna imperdiet ut.</span></p><p><span style=\"color: #262829;\">Fusce eu massa nec diam fermentum imperdiet ac vel est. Morbi condimentum imperdiet lorem, quis gravida lacus placerat eget. Quisque nunc massa, laoreet sed consectetur sed, elementum eu quam. Donec non molestie metus. Suspendisse placerat ante ac pharetra scelerisque. Duis ut tellus aliquet, lacinia lacus et, ullamcorper risus. Vivamus risus arcu, tempus nec mi convallis, congue tempor nibh. Praesent ullamcorper commodo elementum. Donec ultrices neque nec turpis semper molestie. Duis pulvinar quam sit amet tempus hendrerit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;</span></p></div>\r\n				</div>\r\n								</div>\r\n				</div>\r\n				</div>\r\n					</div>\r\n		</div>\r\n				<div class=\"elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-38983ca\" data-id=\"38983ca\" data-element_type=\"column\">\r\n			<div class=\"elementor-widget-wrap elementor-element-populated\">\r\n						<div class=\"elementor-element elementor-element-29e0ad4 elementor-hidden-tablet elementor-hidden-mobile elementor-widget elementor-widget-heading\" data-id=\"29e0ad4\" data-element_type=\"widget\" data-widget_type=\"heading.default\">\r\n				<div class=\"elementor-widget-container\">\r\n			<style>/*! elementor - v3.20.0 - 13-03-2024 */\r\n.elementor-heading-title{padding:0;margin:0;line-height:1}.elementor-widget-heading .elementor-heading-title[class*=elementor-size-]>a{color:inherit;font-size:inherit;line-height:inherit}.elementor-widget-heading .elementor-heading-title.elementor-size-small{font-size:15px}.elementor-widget-heading .elementor-heading-title.elementor-size-medium{font-size:19px}.elementor-widget-heading .elementor-heading-title.elementor-size-large{font-size:29px}.elementor-widget-heading .elementor-heading-title.elementor-size-xl{font-size:39px}.elementor-widget-heading .elementor-heading-title.elementor-size-xxl{font-size:59px}</style><h4 class=\"elementor-heading-title elementor-size-default\">MEDIA LIBRARY</h4>		</div>\r\n				</div>\r\n				<div class=\"elementor-element elementor-element-0e1b783 elementor-hidden-tablet elementor-hidden-mobile elementor-widget elementor-widget-image-gallery\" data-id=\"0e1b783\" data-element_type=\"widget\" data-widget_type=\"image-gallery.default\">\r\n				<div class=\"elementor-widget-container\">\r\n			<style>/*! elementor - v3.20.0 - 13-03-2024 */\r\n.elementor-image-gallery .gallery-item{display:inline-block;text-align:center;vertical-align:top;width:100%;max-width:100%;margin:0 auto}.elementor-image-gallery .gallery-item img{margin:0 auto}.elementor-image-gallery .gallery-item .gallery-caption{margin:0}.elementor-image-gallery figure img{display:block}.elementor-image-gallery figure figcaption{width:100%}.gallery-spacing-custom .elementor-image-gallery .gallery-icon{padding:0}@media (min-width:768px){.elementor-image-gallery .gallery-columns-2 .gallery-item{max-width:50%}.elementor-image-gallery .gallery-columns-3 .gallery-item{max-width:33.33%}.elementor-image-gallery .gallery-columns-4 .gallery-item{max-width:25%}.elementor-image-gallery .gallery-columns-5 .gallery-item{max-width:20%}.elementor-image-gallery .gallery-columns-6 .gallery-item{max-width:16.666%}.elementor-image-gallery .gallery-columns-7 .gallery-item{max-width:14.28%}.elementor-image-gallery .gallery-columns-8 .gallery-item{max-width:12.5%}.elementor-image-gallery .gallery-columns-9 .gallery-item{max-width:11.11%}.elementor-image-gallery .gallery-columns-10 .gallery-item{max-width:10%}}@media (min-width:480px) and (max-width:767px){.elementor-image-gallery .gallery.gallery-columns-2 .gallery-item,.elementor-image-gallery .gallery.gallery-columns-3 .gallery-item,.elementor-image-gallery .gallery.gallery-columns-4 .gallery-item,.elementor-image-gallery .gallery.gallery-columns-5 .gallery-item,.elementor-image-gallery .gallery.gallery-columns-6 .gallery-item,.elementor-image-gallery .gallery.gallery-columns-7 .gallery-item,.elementor-image-gallery .gallery.gallery-columns-8 .gallery-item,.elementor-image-gallery .gallery.gallery-columns-9 .gallery-item,.elementor-image-gallery .gallery.gallery-columns-10 .gallery-item{max-width:50%}}@media (max-width:479px){.elementor-image-gallery .gallery.gallery-columns-2 .gallery-item,.elementor-image-gallery .gallery.gallery-columns-3 .gallery-item,.elementor-image-gallery .gallery.gallery-columns-4 .gallery-item,.elementor-image-gallery .gallery.gallery-columns-5 .gallery-item,.elementor-image-gallery .gallery.gallery-columns-6 .gallery-item,.elementor-image-gallery .gallery.gallery-columns-7 .gallery-item,.elementor-image-gallery .gallery.gallery-columns-8 .gallery-item,.elementor-image-gallery .gallery.gallery-columns-9 .gallery-item,.elementor-image-gallery .gallery.gallery-columns-10 .gallery-item{max-width:100%}}</style>		<div class=\"elementor-image-gallery\">\r\n			<div id=\'gallery-1\' class=\'gallery galleryid-2085 gallery-columns-3 gallery-size-thumbnail\'><figure class=\'gallery-item\'>\r\n			<div class=\'gallery-icon landscape\'>\r\n				<a data-elementor-open-lightbox=\"yes\" data-elementor-lightbox-slideshow=\"0e1b783\" data-elementor-lightbox-title=\"01-6-1 (1)\" data-e-action-hash=\"#elementor-action%3Aaction%3Dlightbox%26settings%3DeyJpZCI6NTA2MCwidXJsIjoiaHR0cHM6XC9cL21vdG9ycy5zdHlsZW1peHRoZW1lcy5jb21cL2VsZW1lbnRvci1kZWFsZXItdHdvXC93cC1jb250ZW50XC91cGxvYWRzXC9zaXRlc1wvMjRcLzIwMjFcLzAzXC8wMS02LTEtMS5qcGciLCJzbGlkZXNob3ciOiIwZTFiNzgzIn0%3D\" href=\'assets/images/wp-uploads/sites/24/2021/03/01-6-1-1.jpg\'><img decoding=\"async\" width=\"150\" height=\"150\" src=\"assets/images/wp-uploads/sites/24/2021/03/01-6-1-1-150x150.jpg\" class=\"attachment-thumbnail size-thumbnail\" alt=\"\" srcset=\"assets/images/wp-uploads/sites/24/2021/03/01-6-1-1-150x150.jpg 150w, assets/images/wp-uploads/sites/24/2021/03/01-6-1-1-120x120.jpg 120w, assets/images/wp-uploads/sites/24/2021/03/01-6-1-1-200x200.jpg 200w, assets/images/wp-uploads/sites/24/2021/03/01-6-1-1-100x100.jpg 100w\" sizes=\"(max-width: 150px) 100vw, 150px\" /></a>\r\n			</div></figure><figure class=\'gallery-item\'>\r\n			<div class=\'gallery-icon landscape\'>\r\n				<a data-elementor-open-lightbox=\"yes\" data-elementor-lightbox-slideshow=\"0e1b783\" data-elementor-lightbox-title=\"01-7-1 (1)\" data-e-action-hash=\"#elementor-action%3Aaction%3Dlightbox%26settings%3DeyJpZCI6NTA1OSwidXJsIjoiaHR0cHM6XC9cL21vdG9ycy5zdHlsZW1peHRoZW1lcy5jb21cL2VsZW1lbnRvci1kZWFsZXItdHdvXC93cC1jb250ZW50XC91cGxvYWRzXC9zaXRlc1wvMjRcLzIwMjFcLzAzXC8wMS03LTEtMS5qcGciLCJzbGlkZXNob3ciOiIwZTFiNzgzIn0%3D\" href=\'assets/images/wp-uploads/sites/24/2021/03/01-7-1-1.jpg\'><img decoding=\"async\" width=\"150\" height=\"150\" src=\"assets/images/wp-uploads/sites/24/2021/03/01-7-1-1-150x150.jpg\" class=\"attachment-thumbnail size-thumbnail\" alt=\"\" srcset=\"assets/images/wp-uploads/sites/24/2021/03/01-7-1-1-150x150.jpg 150w, assets/images/wp-uploads/sites/24/2021/03/01-7-1-1-120x120.jpg 120w, assets/images/wp-uploads/sites/24/2021/03/01-7-1-1-200x200.jpg 200w, assets/images/wp-uploads/sites/24/2021/03/01-7-1-1-100x100.jpg 100w\" sizes=\"(max-width: 150px) 100vw, 150px\" /></a>\r\n			</div></figure><figure class=\'gallery-item\'>\r\n			<div class=\'gallery-icon landscape\'>\r\n				<a data-elementor-open-lightbox=\"yes\" data-elementor-lightbox-slideshow=\"0e1b783\" data-elementor-lightbox-title=\"01-10-1\" data-e-action-hash=\"#elementor-action%3Aaction%3Dlightbox%26settings%3DeyJpZCI6NTA1NywidXJsIjoiaHR0cHM6XC9cL21vdG9ycy5zdHlsZW1peHRoZW1lcy5jb21cL2VsZW1lbnRvci1kZWFsZXItdHdvXC93cC1jb250ZW50XC91cGxvYWRzXC9zaXRlc1wvMjRcLzIwMjFcLzAzXC8wMS0xMC0xLmpwZyIsInNsaWRlc2hvdyI6IjBlMWI3ODMifQ%3D%3D\" href=\'assets/images/wp-uploads/sites/24/2021/03/01-10-1.jpg\'><img loading=\"lazy\" decoding=\"async\" width=\"150\" height=\"150\" src=\"assets/images/wp-uploads/sites/24/2021/03/01-10-1-150x150.jpg\" class=\"attachment-thumbnail size-thumbnail\" alt=\"\" srcset=\"assets/images/wp-uploads/sites/24/2021/03/01-10-1-150x150.jpg 150w, assets/images/wp-uploads/sites/24/2021/03/01-10-1-120x120.jpg 120w, assets/images/wp-uploads/sites/24/2021/03/01-10-1-200x200.jpg 200w, assets/images/wp-uploads/sites/24/2021/03/01-10-1-100x100.jpg 100w\" sizes=\"(max-width: 150px) 100vw, 150px\" /></a>\r\n			</div></figure><figure class=\'gallery-item\'>\r\n			<div class=\'gallery-icon landscape\'>\r\n				<a data-elementor-open-lightbox=\"yes\" data-elementor-lightbox-slideshow=\"0e1b783\" data-elementor-lightbox-title=\"01-24-1\" data-e-action-hash=\"#elementor-action%3Aaction%3Dlightbox%26settings%3DeyJpZCI6NTA0NCwidXJsIjoiaHR0cHM6XC9cL21vdG9ycy5zdHlsZW1peHRoZW1lcy5jb21cL2VsZW1lbnRvci1kZWFsZXItdHdvXC93cC1jb250ZW50XC91cGxvYWRzXC9zaXRlc1wvMjRcLzIwMjFcLzAzXC8wMS0yNC0xLmpwZyIsInNsaWRlc2hvdyI6IjBlMWI3ODMifQ%3D%3D\" href=\'assets/images/wp-uploads/sites/24/2021/03/01-24-1.jpg\'><img loading=\"lazy\" decoding=\"async\" width=\"150\" height=\"150\" src=\"assets/images/wp-uploads/sites/24/2021/03/01-24-1-150x150.jpg\" class=\"attachment-thumbnail size-thumbnail\" alt=\"\" srcset=\"assets/images/wp-uploads/sites/24/2021/03/01-24-1-150x150.jpg 150w, assets/images/wp-uploads/sites/24/2021/03/01-24-1-120x120.jpg 120w, assets/images/wp-uploads/sites/24/2021/03/01-24-1-200x200.jpg 200w, assets/images/wp-uploads/sites/24/2021/03/01-24-1-100x100.jpg 100w\" sizes=\"(max-width: 150px) 100vw, 150px\" /></a>\r\n			</div></figure><figure class=\'gallery-item\'>\r\n			<div class=\'gallery-icon landscape\'>\r\n				<a data-elementor-open-lightbox=\"yes\" data-elementor-lightbox-slideshow=\"0e1b783\" data-elementor-lightbox-title=\"porsche-1917x554\" data-e-action-hash=\"#elementor-action%3Aaction%3Dlightbox%26settings%3DeyJpZCI6MzkzNiwidXJsIjoiaHR0cHM6XC9cL21vdG9ycy5zdHlsZW1peHRoZW1lcy5jb21cL2VsZW1lbnRvci1kZWFsZXItdHdvXC93cC1jb250ZW50XC91cGxvYWRzXC9zaXRlc1wvMjRcLzIwMjJcLzA4XC9wb3JzY2hlLTE5MTd4NTU0LTEuanBnIiwic2xpZGVzaG93IjoiMGUxYjc4MyJ9\" href=\'assets/images/wp-uploads/sites/24/2022/08/porsche-1917x554-1.jpg\'><img loading=\"lazy\" decoding=\"async\" width=\"150\" height=\"150\" src=\"assets/images/wp-uploads/sites/24/2022/08/porsche-1917x554-1-150x150.jpg\" class=\"attachment-thumbnail size-thumbnail\" alt=\"\" srcset=\"assets/images/wp-uploads/sites/24/2022/08/porsche-1917x554-1-150x150.jpg 150w, assets/images/wp-uploads/sites/24/2022/08/porsche-1917x554-1-120x120.jpg 120w, assets/images/wp-uploads/sites/24/2022/08/porsche-1917x554-1-200x200.jpg 200w, assets/images/wp-uploads/sites/24/2022/08/porsche-1917x554-1-100x100.jpg 100w\" sizes=\"(max-width: 150px) 100vw, 150px\" /></a>\r\n			</div></figure><figure class=\'gallery-item\'>\r\n			<div class=\'gallery-icon landscape\'>\r\n				<a data-elementor-open-lightbox=\"yes\" data-elementor-lightbox-slideshow=\"0e1b783\" data-elementor-lightbox-title=\"slide_1.jpg\" data-e-action-hash=\"#elementor-action%3Aaction%3Dlightbox%26settings%3DeyJpZCI6MzkwMSwidXJsIjoiaHR0cHM6XC9cL21vdG9ycy5zdHlsZW1peHRoZW1lcy5jb21cL2VsZW1lbnRvci1kZWFsZXItdHdvXC93cC1jb250ZW50XC91cGxvYWRzXC9zaXRlc1wvMjRcL3JldnNsaWRlclwvaG9tZV9zbGlkZXIxXC9zbGlkZV8xLmpwZyIsInNsaWRlc2hvdyI6IjBlMWI3ODMifQ%3D%3D\" href=\'assets/images/wp-uploads/sites/24/revslider/home_slider1/slide_1.jpg\'><img loading=\"lazy\" decoding=\"async\" width=\"150\" height=\"150\" src=\"assets/images/wp-uploads/sites/24/revslider/home_slider1/slide_1-150x150.jpg\" class=\"attachment-thumbnail size-thumbnail\" alt=\"\" srcset=\"assets/images/wp-uploads/sites/24/revslider/home_slider1/slide_1-150x150.jpg 150w, assets/images/wp-uploads/sites/24/revslider/home_slider1/slide_1-120x120.jpg 120w, assets/images/wp-uploads/sites/24/revslider/home_slider1/slide_1-200x200.jpg 200w, assets/images/wp-uploads/sites/24/revslider/home_slider1/slide_1-100x100.jpg 100w\" sizes=\"(max-width: 150px) 100vw, 150px\" /></a>\r\n			</div></figure>\r\n		</div>\r\n		</div>\r\n				</div>\r\n				</div>\r\n				<div class=\"elementor-element elementor-element-486d94d elementor-widget elementor-widget-motors-single-listing-contact-info\" data-id=\"486d94d\" data-element_type=\"widget\" data-widget_type=\"motors-single-listing-contact-info.default\">\r\n				<div class=\"elementor-widget-container\">\r\n			<div class=\"contact-info-wrap\">\r\n	<div class=\"title_wrap\">\r\n		<i aria-hidden=\"true\" class=\"fas fa-address-book\"></i>		<h5 class=\"title\">Contact Information</h5>\r\n	</div>\r\n	<div class=\"contact-desc\">\r\n		Lorem Ipsum has been the industry&#039;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.	</div>\r\n	<div class=\"info-list-wrap\">\r\n		<div class=\"info-item\"><i class=\"stm-icon-phone\"></i><div class=\"info-data\"><span class=\"item-title\">Phone</span><span class=\"item-value\">123-456-7890</span></div></div><div class=\"info-item\"><i class=\"stmicon- stm-icon-mail\"></i><div class=\"info-data\"><span class=\"item-title\">E-mail</span><span class=\"item-value\"><a href=\"/cdn-cgi/l/email-protection\" class=\"__cf_email__\" data-cfemail=\"197d7c78757c6b6a7170695974787075377a767674\">[email&#160;protected]</a></span></div></div>	</div>\r\n</div>\r\n		</div>\r\n				</div>\r\n					</div>\r\n		</div>\r\n					</div>\r\n		</section>\r\n				</div>\r\n		\r\n			\r\n			<div class=\"clearfix\">\r\n							</div>\r\n		</div>', 1, '2026-04-17 00:36:01', '2026-04-28 05:16:03'),
(4, 'contact', 'Contact Us', 'Get in touch with our sales and service team.', '<style type=\"text/css\">\r\n        #wrapper {\r\n            background-color: #f0f2f5 !important;\r\n        }\r\n    </style>\r\n	\r\n	<!-- Breads -->\r\n		<div class=\"container\">\r\n\r\n					<div data-elementor-type=\"wp-page\" data-elementor-id=\"2080\" class=\"elementor elementor-2080\">\r\n						<section class=\"elementor-section elementor-top-section elementor-element elementor-element-2347557 elementor-section-full_width elementor-section-height-min-height elementor-section-stretched elementor-section-height-default elementor-section-items-middle\" data-id=\"2347557\" data-element_type=\"section\" data-settings=\"{&quot;stretch_section&quot;:&quot;section-stretched&quot;,&quot;background_background&quot;:&quot;classic&quot;}\">\r\n						<div class=\"elementor-container elementor-column-gap-default\">\r\n					<div class=\"elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-2848e57\" data-id=\"2848e57\" data-element_type=\"column\">\r\n			<div class=\"elementor-widget-wrap elementor-element-populated\">\r\n						<section class=\"elementor-section elementor-inner-section elementor-element elementor-element-bc070d6 elementor-section-boxed elementor-section-height-default elementor-section-height-default\" data-id=\"bc070d6\" data-element_type=\"section\" data-settings=\"{&quot;background_background&quot;:&quot;classic&quot;}\">\r\n						<div class=\"elementor-container elementor-column-gap-default\">\r\n					<div class=\"elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-6dd99ff\" data-id=\"6dd99ff\" data-element_type=\"column\" data-settings=\"{&quot;background_background&quot;:&quot;classic&quot;}\">\r\n			<div class=\"elementor-widget-wrap elementor-element-populated\">\r\n						<div class=\"elementor-element elementor-element-be9516d elementor-absolute elementor-widget__width-initial elementor-widget elementor-widget-stm-contact-form-seven\" data-id=\"be9516d\" data-element_type=\"widget\" data-settings=\"{&quot;_position&quot;:&quot;absolute&quot;}\" data-widget_type=\"stm-contact-form-seven.default\">\r\n				<div class=\"elementor-widget-container\">\r\n			\r\n<div class=\"stm-elementor-contact-form-seven \" id=\"single_contact_form_14103\">\r\n	<div class=\"icon-title\">\r\n					<h2 class=\"heading-font title\">\r\n				CONTACT US			</h2>\r\n			</div>\r\n\r\n	\r\n	\r\n<div class=\"wpcf7 no-js\" id=\"wpcf7-f2083-p2080-o1\" lang=\"en-US\" dir=\"ltr\">\r\n<div class=\"screen-reader-response\"><p role=\"status\" aria-live=\"polite\" aria-atomic=\"true\"></p> <ul></ul></div>', 1, '2026-04-17 00:36:01', '2026-04-28 05:34:05'),
(5, 'listing-detail', 'Vehicle Detail', 'Lorem ipsum dolor sit amet.', '', 1, '2026-04-20 18:35:49', '2026-04-21 11:21:12'),
(6, 'inventory', 'Inventory', 'Lorem ipsum dolor sit amet.', '', 1, '2026-04-20 18:35:49', '2026-04-21 11:21:12'),
(7, 'compare', 'Compare Vehicles', 'Lorem ipsum dolor sit amet.', '', 1, '2026-04-20 18:35:49', '2026-04-21 11:21:12');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `filename` varchar(255) NOT NULL,
  `original_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(100) DEFAULT NULL,
  `file_size` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `uploaded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `filename`, `original_name`, `file_path`, `file_type`, `file_size`, `uploaded_by`, `created_at`, `updated_at`) VALUES
(1, 'placeholder-lorem.svg', 'placeholder-lorem.svg', 'asset/images/media/placeholder-lorem.svg', 'svg', 727, NULL, '2026-04-21 03:32:45', '2026-04-21 03:32:45'),
(2, 'mers-1024x347-1776818445.jpg', 'mers-1024x347.jpg', 'asset/images/media/mers-1024x347-1776818445.jpg', 'jpg', 53922, 1, '2026-04-22 04:40:45', '2026-04-22 04:40:45'),
(3, 'slide-1-1777243596.jpg', 'slide_1.jpg', 'asset/images/media/slide-1-1777243596.jpg', 'jpg', 214615, 1, '2026-04-27 02:46:36', '2026-04-27 02:46:36'),
(4, 'mubashir-shoukat-a-6ymdpgmbu-unsplash-1-1777244202.jpg', 'mubashir-shoukat-A-6ymDPGMbU-unsplash (1).jpg', 'asset/images/media/mubashir-shoukat-a-6ymdpgmbu-unsplash-1-1777244202.jpg', 'jpg', 557627, 1, '2026-04-27 02:56:42', '2026-04-27 02:56:42'),
(5, '999-1-1777244891.jpg', '999 (1).jpg', 'asset/images/media/999-1-1777244891.jpg', 'jpg', 89330, 1, '2026-04-27 03:08:11', '2026-04-27 03:08:11'),
(6, '01-18-798x466-1777259853.jpeg', '01-18-798x466.jpeg', 'asset/images/media/01-18-798x466-1777259853.jpeg', 'jpeg', 75678, 1, '2026-04-27 07:17:33', '2026-04-27 07:17:33'),
(7, '03-18-798x466-1777260084.jpeg', '03-18-798x466.jpeg', 'asset/images/media/03-18-798x466-1777260084.jpeg', 'jpeg', 67555, 1, '2026-04-27 07:21:24', '2026-04-27 07:21:24'),
(8, '02-18-798x466-1777260103.jpeg', '02-18-798x466.jpeg', 'asset/images/media/02-18-798x466-1777260103.jpeg', 'jpeg', 46163, 1, '2026-04-27 07:21:43', '2026-04-27 07:21:43'),
(9, 'vadym-kudriavtsev-m09n69wts1o-unsplash-1-1777311562.jpg', 'vadym-kudriavtsev-m09N69WTs1o-unsplash (1).jpg', 'asset/images/media/vadym-kudriavtsev-m09n69wts1o-unsplash-1-1777311562.jpg', 'jpg', 312029, 1, '2026-04-27 21:39:22', '2026-04-27 21:39:22'),
(10, 'view-professional-handshake-business-people-1-1777311982.jpg', 'view-professional-handshake-business-people (1).jpg', 'asset/images/media/view-professional-handshake-business-people-1-1777311982.jpg', 'jpg', 158060, 1, '2026-04-27 21:46:22', '2026-04-27 21:46:22'),
(11, 'mahmoud-azmy-naazlhjen8s-unsplash-1-1777312221.jpg', 'mahmoud-azmy-NAAzLhJEN8s-unsplash (1).jpg', 'asset/images/media/mahmoud-azmy-naazlhjen8s-unsplash-1-1777312221.jpg', 'jpg', 240503, 1, '2026-04-27 21:50:21', '2026-04-27 21:50:21'),
(12, 'young-attractive-black-businessman-buys-new-car-he-holds-keys-his-hand-dreams-come-true-1-1777312596.jpg', 'young-attractive-black-businessman-buys-new-car-he-holds-keys-his-hand-dreams-come-true (1).jpg', 'asset/images/media/young-attractive-black-businessman-buys-new-car-he-holds-keys-his-hand-dreams-come-true-1-1777312596.jpg', 'jpg', 225423, 1, '2026-04-27 21:56:36', '2026-04-27 21:56:36'),
(13, 'row-new-cars-port-1-1777312696.jpg', 'row-new-cars-port (1).jpg', 'asset/images/media/row-new-cars-port-1-1777312696.jpg', 'jpg', 247918, 1, '2026-04-27 21:58:16', '2026-04-27 21:58:16'),
(14, '01-10-2-798x466-qBDrGr-1777315638.jpg', '01-10-2-798x466.jpg', 'asset/images/media/01-10-2-798x466-qBDrGr-1777315638.jpg', 'jpg', 74615, 1, '2026-04-27 22:47:18', '2026-04-27 22:47:18'),
(15, '01-20-1-798x466-zB4c63-1777315638.jpg', '01-20-1-798x466.jpg', 'asset/images/media/01-20-1-798x466-zB4c63-1777315638.jpg', 'jpg', 65211, 1, '2026-04-27 22:47:18', '2026-04-27 22:47:18'),
(16, '02-24-798x466-bXgGtF-1777315638.jpeg', '02-24-798x466.jpeg', 'asset/images/media/02-24-798x466-bXgGtF-1777315638.jpeg', 'jpeg', 67001, 1, '2026-04-27 22:47:18', '2026-04-27 22:47:18'),
(17, 'ux-01-1-798x466-edw4B1-1777315638.jpg', 'UX-01-1-798x466.jpg', 'asset/images/media/ux-01-1-798x466-edw4B1-1777315638.jpg', 'jpg', 70345, 1, '2026-04-27 22:47:18', '2026-04-27 22:47:18'),
(18, 'motor-1-795x463-1-768x447-uFcGeM-1777469240.jpg', 'motor-1-795x463-1-768x447.jpg', 'asset/images/media/motor-1-795x463-1-768x447-uFcGeM-1777469240.jpg', 'jpg', 38307, 1, '2026-04-29 17:27:20', '2026-04-29 17:27:20'),
(19, '7-1109x699-1-798x466-95m24X-1777469607.jpg', '7-1109x699-1-798x466.jpg', 'asset/images/media/7-1109x699-1-798x466-95m24X-1777469607.jpg', 'jpg', 52922, 1, '2026-04-29 17:33:27', '2026-04-29 17:33:27'),
(20, '5-1109x699-1-798x466-EuMR4C-1777469607.jpg', '5-1109x699-1-798x466.jpg', 'asset/images/media/5-1109x699-1-798x466-EuMR4C-1777469607.jpg', 'jpg', 103165, 1, '2026-04-29 17:33:27', '2026-04-29 17:33:27');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_16_163235_create_permission_tables', 1),
(5, '2026_04_16_163946_create_vehicles_table', 1),
(6, '2026_04_16_163948_create_vehicle_images_table', 1),
(7, '2026_04_17_120000_add_marketplace_fields_to_vehicles_table', 1),
(8, '2026_04_17_140000_create_vehicle_favorites_table', 1),
(9, '2026_04_17_140001_create_vehicle_inquiries_table', 1),
(10, '2026_04_17_200000_create_site_settings_table', 1),
(11, '2026_04_18_100000_create_cms_pages_table', 1),
(12, '2026_04_20_120000_change_vehicle_images_path_to_text', 2),
(13, '2026_04_20_220000_add_is_active_to_cms_pages_table', 2),
(14, '2026_04_20_220100_create_page_sections_table', 2),
(15, '2026_04_20_220200_create_media_table', 2),
(16, '2026_04_20_220300_drop_legacy_wordpress_tables_if_present', 2),
(17, '2026_04_21_000000_create_site_traffic_events_table', 2),
(18, '2026_04_22_120000_create_admin_audit_trails_table', 2),
(19, '2026_04_27_120000_add_is_special_to_vehicles_table', 3),
(20, '2026_04_28_164137_add_extra_details_to_vehicles_table', 4),
(21, '2026_04_28_191500_add_detail_page_config_to_vehicles_table', 4),
(22, '2026_04_29_000001_add_google_otp_avatar_to_users_table', 4),
(23, '2026_04_29_000002_create_vendor_profiles_table', 4),
(24, '2026_04_29_134000_add_show_financing_calculator_to_vehicles_table', 5),
(25, '2026_04_29_141000_add_currency_preferences_to_users_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `page_sections`
--

CREATE TABLE `page_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `page` varchar(255) NOT NULL,
  `section_key` varchar(255) NOT NULL,
  `content_type` varchar(50) NOT NULL DEFAULT 'text',
  `content` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `page_sections`
--

INSERT INTO `page_sections` (`id`, `page`, `section_key`, `content_type`, `content`, `created_at`, `updated_at`) VALUES
(1, 'home', 'hero_title', 'text', 'Welcome To My Autotorque', '2026-04-20 18:15:57', '2026-04-27 02:49:48'),
(2, 'home', 'hero_subtitle', 'text', 'The Smarter Way to Buy, Sell and Trade Vehicles', '2026-04-20 18:15:57', '2026-04-27 02:49:48'),
(3, 'home', 'hero_cta_text', 'text', 'View Listing', '2026-04-20 18:15:57', '2026-04-27 02:49:48'),
(4, 'home', 'hero_cta_href', 'text', '/inventory', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(5, 'home', 'home_search_label', 'text', 'search inventory', '2026-04-20 18:15:57', '2026-04-22 04:47:27'),
(6, 'home', 'recent_title', 'text', 'RECENT CARS', '2026-04-20 18:15:57', '2026-04-22 13:35:22'),
(7, 'home', 'recent_subtitle', 'textarea', 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Cards below are live listings.', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(8, 'home', 'hero_image', 'image', 'asset/images/media/slide-1-1777243596.jpg', '2026-04-20 18:15:57', '2026-04-27 02:46:45'),
(9, 'home', 'cta_left_image', 'image', 'asset/images/media/home-cta-left.jpg', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(10, 'home', 'cta_right_image', 'image', 'asset/images/media/home-cta-right.jpg', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(11, 'home', 'cta_left_title', 'text', 'LOOKING FOR A CAR?', '2026-04-20 18:15:57', '2026-04-22 04:48:53'),
(12, 'home', 'cta_left_body', 'textarea', 'Our cars are delivered fully-registered with all requirements completed. We’ll deliver your car wherever you are.', '2026-04-20 18:15:57', '2026-04-22 04:48:53'),
(13, 'home', 'cta_right_title', 'text', 'Consectetur adipiscing', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(14, 'home', 'cta_right_body', 'textarea', 'Elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(15, 'home', 'feat1_title', 'text', 'Lorem ipsum', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(16, 'home', 'feat1_body', 'textarea', 'Dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero.', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(17, 'home', 'feat2_title', 'text', 'Dolor sit amet', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(18, 'home', 'feat2_body', 'textarea', 'Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet.', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(19, 'home', 'feat3_title', 'text', 'Consectetur elit', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(20, 'home', 'feat3_body', 'textarea', 'Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla.', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(21, 'home', 'welcome_title', 'text', 'Lorem ipsum welcome block', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(22, 'home', 'welcome_body', 'textarea', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta.', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(23, 'home', 'testimonial_name', 'text', 'Lorem Ipsum', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(24, 'home', 'testimonial_role', 'text', 'Lorem role', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(25, 'home', 'testimonial_quote', 'textarea', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In fringilla, velit id laoreet hendrerit, sapien nisl varius dolor, eu consequat erat augue in eros.', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(26, 'inventory', 'heading', 'text', 'Vehicles For Sale', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(27, 'inventory', 'intro', 'textarea', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Inventory cards are dynamic and loaded from vehicle records.', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(28, 'inventory', 'fallback_image', 'image', 'asset/images/media/inventory-listing-fallback.jpg', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(29, 'contact', 'heading', 'text', 'Contact Us', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(30, 'contact', 'intro', 'textarea', 'Get in touch with our sales and service team.', '2026-04-20 18:15:57', '2026-04-28 05:34:05'),
(31, 'contact', 'hero_image', 'image', 'asset/images/media/row-new-cars-port-1-1777312696.jpg', '2026-04-20 18:15:57', '2026-04-28 05:28:43'),
(32, 'contact', 'map_image', 'image', 'asset/images/media/contact-map.jpg', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(33, 'compare', 'heading', 'text', 'Compare Vehicles', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(34, 'compare', 'intro', 'textarea', 'Lorem ipsum dolor sit amet. Compare list remains dynamic from selected inventory records.', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(35, 'listing-detail', 'heading', 'text', 'Vehicle Detail', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(36, 'listing-detail', 'intro', 'textarea', 'Lorem ipsum dolor sit amet. Gallery and specifications are loaded from listing data.', '2026-04-20 18:15:57', '2026-04-21 11:21:12'),
(109, 'home', 'dealer_cta_bg', 'image', 'asset/images/media/mubashir-shoukat-a-6ymdpgmbu-unsplash-1-1777244202.jpg', '2026-04-27 02:46:45', '2026-04-27 02:59:04'),
(110, 'home', 'dealer_cta_left_icon', 'text', 'directions_car', '2026-04-27 02:46:45', '2026-04-27 02:46:45'),
(111, 'home', 'dealer_cta_right_icon', 'text', 'sell', '2026-04-27 02:46:45', '2026-04-27 02:46:45'),
(112, 'home', 'cta_left_button_text', 'text', 'Inventory', '2026-04-27 02:46:45', '2026-04-27 02:46:45'),
(113, 'home', 'cta_left_button_href', 'text', '/inventory', '2026-04-27 02:46:45', '2026-04-27 02:46:45'),
(114, 'home', 'cta_right_button_text', 'text', 'Sell your car', '2026-04-27 02:46:45', '2026-04-27 02:46:45'),
(115, 'home', 'cta_right_button_href', 'text', '/register', '2026-04-27 02:46:45', '2026-04-27 02:46:45'),
(116, 'home', 'welcome_video_url', 'text', '', '2026-04-27 02:46:45', '2026-04-27 02:46:45'),
(117, 'home', 'stats_metric_1_label', 'text', 'CARS FOR SALE', '2026-04-27 02:46:45', '2026-04-27 03:09:08'),
(118, 'home', 'stats_metric_2_value', 'text', '8000', '2026-04-27 02:46:45', '2026-04-27 03:09:08'),
(119, 'home', 'stats_metric_2_label', 'text', 'VISITORS PER DAY', '2026-04-27 02:46:45', '2026-04-27 03:09:08'),
(120, 'home', 'stats_metric_3_value', 'text', '1200', '2026-04-27 02:46:45', '2026-04-27 03:09:08'),
(121, 'home', 'stats_metric_3_label', 'text', 'DEALER REVIEWS', '2026-04-27 02:46:45', '2026-04-27 03:09:08'),
(122, 'home', 'stats_metric_4_value', 'text', '4000', '2026-04-27 02:46:45', '2026-04-27 03:09:08'),
(123, 'home', 'stats_metric_4_label', 'text', 'Metric four', '2026-04-27 02:46:45', '2026-04-27 02:46:45'),
(124, 'home', 'stats_center_image', 'image', 'asset/images/media/999-1-1777244891.jpg', '2026-04-27 02:46:45', '2026-04-27 03:09:08'),
(125, 'home', 'testimonial_bg_image', 'image', 'asset/images/media/mers-1024x347-1776818445.jpg', '2026-04-27 02:46:45', '2026-04-28 05:44:58'),
(126, 'home', 'testimonial_overlay_opacity', 'text', '0.55', '2026-04-27 02:46:45', '2026-04-27 02:46:45'),
(127, 'about', 'hero_image', 'image', 'asset/images/media/vadym-kudriavtsev-m09n69wts1o-unsplash-1-1777311562.jpg', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(128, 'about', 'established_year', 'text', '1999', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(129, 'about', 'hero_stat_value', 'text', '25+', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(130, 'about', 'hero_stat_label', 'text', 'Years of Excellence', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(131, 'about', 'heading', 'text', 'WELCOME TO THE MOTORS', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(132, 'about', 'intro', 'textarea', 'Experience the pinnacle of automotive engineering and white-glove service. We curate the world\'s most exceptional vehicles for the discerning driver who demands nothing less than absolute mechanical perfection.', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(133, 'about', 'hero_primary_cta_text', 'text', 'Learn Our History', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(134, 'about', 'hero_primary_cta_href', 'text', '/about', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(135, 'about', 'values_title', 'text', 'CORE VALUES', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(136, 'about', 'val_1_title', 'text', 'Integrity First', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(137, 'about', 'val_1_body', 'textarea', 'Transparent pricing and rigorous history checks for every vehicle in our showroom.', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(138, 'about', 'val_2_title', 'text', 'Mechanical Excellence', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(139, 'about', 'val_2_body', 'textarea', 'Our master technicians conduct a 200-point inspection ensuring performance meets factory standards.', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(140, 'about', 'val_3_title', 'text', 'Client Concierge', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(141, 'about', 'val_3_body', 'textarea', 'Dedicated advisors providing personalized acquisition strategies and lifelong maintenance support.', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(142, 'about', 'values_grid_1', 'image', 'asset/images/media/young-attractive-black-businessman-buys-new-car-he-holds-keys-his-hand-dreams-come-true-1-1777312596.jpg', '2026-04-27 21:40:00', '2026-04-27 21:56:46'),
(143, 'about', 'values_grid_2', 'image', 'asset/images/media/row-new-cars-port-1-1777312696.jpg', '2026-04-27 21:40:00', '2026-04-27 21:58:26'),
(144, 'about', 'values_grid_3', 'image', 'asset/images/media/mahmoud-azmy-naazlhjen8s-unsplash-1-1777312221.jpg', '2026-04-27 21:40:00', '2026-04-27 21:50:32'),
(145, 'about', 'values_grid_4', 'image', 'asset/images/media/view-professional-handshake-business-people-1-1777311982.jpg', '2026-04-27 21:40:00', '2026-04-27 21:46:34'),
(146, 'about', 'gallery_title', 'text', 'Media Gallery', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(147, 'about', 'gallery_image_1', 'image', 'asset/images/media/about-gallery-1.jpg', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(148, 'about', 'gallery_image_2', 'image', 'asset/images/media/about-gallery-2.jpg', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(149, 'about', 'gallery_image_3', 'image', 'asset/images/media/about-gallery-3.jpg', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(150, 'about', 'gallery_image_4', 'image', 'asset/images/media/about-gallery-4.jpg', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(151, 'about', 'advantages_title', 'text', 'Quick Links', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(152, 'about', 'adv_1_icon', 'text', 'sell', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(153, 'about', 'adv_1_title', 'text', 'Do you want to sell a car?', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(154, 'about', 'adv_1_body', 'textarea', 'Get a competitive appraisal and same-day payment from our acquisition team.', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(155, 'about', 'adv_1_href', 'text', '/sell', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(156, 'about', 'adv_2_icon', 'text', 'directions_car', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(157, 'about', 'adv_2_title', 'text', 'Looking for a new car?', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(158, 'about', 'adv_2_body', 'textarea', 'Browse our curated collection of premium inventory and certified pre-owned units.', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(159, 'about', 'adv_2_href', 'text', '/inventory', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(160, 'about', 'adv_3_icon', 'text', 'build', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(161, 'about', 'adv_3_title', 'text', 'Schedule a service?', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(162, 'about', 'adv_3_body', 'textarea', 'Book an appointment with our specialist mechanics for maintenance or tuning.', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(163, 'about', 'adv_3_href', 'text', '/service', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(164, 'about', 'testimonials_title', 'text', 'Customer Testimonials', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(165, 'about', 'testimonial_1_body', 'textarea', 'The acquisition process for my vintage collection was handled with unparalleled professionalism. Velocity Motors doesn\'t just sell cars; they curate legacies.', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(166, 'about', 'testimonial_1_author', 'text', 'John Doe', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(167, 'about', 'testimonial_1_brand', 'text', 'Private Collector, London', '2026-04-27 21:40:00', '2026-04-27 21:40:00'),
(168, 'about', 'gallery', 'gallery', '[\"asset/images/media/01-10-2-798x466-qBDrGr-1777315638.jpg\",\"asset/images/media/01-20-1-798x466-zB4c63-1777315638.jpg\",\"asset/images/media/02-24-798x466-bXgGtF-1777315638.jpeg\",\"asset/images/media/ux-01-1-798x466-edw4B1-1777315638.jpg\",\"asset/images/media/02-18-798x466-1777260103.jpeg\"]', '2026-04-27 22:47:49', '2026-04-27 22:47:49'),
(169, 'faq', 'kicker', 'text', 'Need Help?', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(170, 'faq', 'heading', 'text', 'HELP CENTER', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(171, 'faq', 'intro', 'textarea', 'Everything you need to know about the Apex Automotive experience, from acquisition to elite performance servicing.', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(172, 'faq', 'hero_image', 'image', 'asset/images/media/slide-1-1777243596.jpg', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(173, 'faq', 'cat_1_title', 'text', 'Buying & Inventory', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(174, 'faq', 'cat_1_icon', 'text', 'directions_car', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(175, 'faq', 'faq_1_1_q', 'text', 'Can I reserve a vehicle before visiting the dealership?', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(176, 'faq', 'faq_1_1_a', 'textarea', 'Yes. We offer a digital reservation service where you can place a fully refundable deposit on any vehicle for up to 48 hours.', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(177, 'faq', 'faq_1_2_q', 'text', 'What kind of inspection do vehicles undergo?', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(178, 'faq', 'faq_1_2_a', 'textarea', 'Every vehicle in our inventory passes a rigorous 172-point Certification process by factory-trained technicians.', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(179, 'faq', 'faq_1_3_q', 'text', 'Do you offer nationwide shipping?', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(180, 'faq', 'faq_1_3_a', 'textarea', 'Absolutely. We utilize specialized enclosed carriers to ship vehicles anywhere in the continental United States.', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(181, 'faq', 'cat_2_title', 'text', 'Financing & Trade', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(182, 'faq', 'cat_2_icon', 'text', 'payments', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(183, 'faq', 'faq_2_1_q', 'text', 'How is my trade-in value determined?', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(184, 'faq', 'faq_2_1_a', 'textarea', 'We use real-time market data alongside a physical appraisal to provide the most competitive value.', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(185, 'faq', 'faq_2_2_q', 'text', 'Do you work with luxury-specific lenders?', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(186, 'faq', 'faq_2_2_a', 'textarea', 'Yes, our finance department partners with premier financial institutions that understand high-value vehicle assets.', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(187, 'faq', 'cat_3_title', 'text', 'Performance Service', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(188, 'faq', 'cat_3_icon', 'text', 'build_circle', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(189, 'faq', 'faq_3_1_q', 'text', 'What performance tuning services do you offer?', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(190, 'faq', 'faq_3_1_a', 'textarea', 'From stage 1 ECU remapping to full exhaust systems and suspension setups, our specialists handle it all.', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(191, 'faq', 'cat_4_title', 'text', 'Selling to Apex', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(192, 'faq', 'cat_4_icon', 'text', 'sell', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(193, 'faq', 'faq_4_1_q', 'text', 'What documents are needed to sell my car?', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(194, 'faq', 'faq_4_1_a', 'textarea', 'You\'ll need the title, valid ID, and maintenance records. Our team handles all transfer paperwork for you.', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(195, 'faq', 'cta_title', 'text', 'STILL SEEKING ANSWERS?', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(196, 'faq', 'cta_body', 'textarea', 'Our automotive concierges are available 7 days a week to assist with technical specifications or test drives.', '2026-04-27 23:22:43', '2026-04-27 23:22:43'),
(197, 'faq', 'cta_image', 'image', 'asset/images/media/mahmoud-azmy-naazlhjen8s-unsplash-1-1777312221.jpg', '2026-04-27 23:22:43', '2026-04-27 23:25:44'),
(198, 'faq', 'cat_1_faqs', 'repeater', '[{\"q\":\"Can I reserve a vehicle before visiting the dealership?\",\"a\":\"Yes. We offer a digital reservation service where you can place a fully refundable deposit on any vehicle for up to 48 hours.\"},{\"q\":\"What kind of inspection do vehicles undergo?\",\"a\":\"Every vehicle in our inventory passes a rigorous 172-point Certification process by factory-trained technicians.\"},{\"q\":\"Do you offer nationwide shipping?\",\"a\":\"Absolutely. We utilize specialized enclosed carriers to ship vehicles anywhere in the continental United States.\"}]', '2026-04-28 05:14:11', '2026-04-28 05:14:11'),
(199, 'faq', 'cat_2_faqs', 'repeater', '[{\"q\":\"How is my trade-in value determined?\",\"a\":\"We use real-time market data alongside a physical appraisal to provide the most competitive value.\"},{\"q\":\"Do you work with luxury-specific lenders?\",\"a\":\"Yes, our finance department partners with premier financial institutions that understand high-value vehicle assets.\"}]', '2026-04-28 05:14:11', '2026-04-28 05:16:03'),
(200, 'faq', 'cat_3_faqs', 'repeater', '[{\"q\":\"What performance tuning services do you offer?\",\"a\":\"From stage 1 ECU remapping to full exhaust systems and suspension setups, our specialists handle it all.\"}]', '2026-04-28 05:14:11', '2026-04-28 05:16:03'),
(201, 'faq', 'cat_4_faqs', 'repeater', '[{\"q\":\"What documents are needed to sell my car?\",\"a\":\"You\'ll need the title, valid ID, and maintenance records. Our team handles all transfer paperwork for you.\"}]', '2026-04-28 05:14:11', '2026-04-28 05:16:03'),
(202, 'contact', 'map_address', 'text', 'Block 10, Plot 2, The Lennox Mall, 3 Admiralty Wy, Lekki Phase 1, Lagos 100001, Lagos, Nigeria', '2026-04-28 05:28:43', '2026-04-28 05:28:43'),
(203, 'contact', 'map_embed_url', 'text', '', '2026-04-28 05:28:43', '2026-04-28 05:28:43'),
(204, 'contact', 'map_fallback_image', 'image', 'asset/images/media/contact-map.jpg', '2026-04-28 05:28:43', '2026-04-28 05:28:43'),
(205, 'contact', 'sales_address', 'textarea', 'Block 10, Plot 2, The Lennox Mall, 3 Admiralty Wy, Lekki Phase 1, Lagos 100001, Lagos, Nigeria', '2026-04-28 05:34:05', '2026-04-28 05:34:05'),
(206, 'contact', 'sales_phone', 'text', '+234 9135777722', '2026-04-28 05:34:05', '2026-04-28 05:34:05'),
(207, 'contact', 'sales_hours', 'textarea', 'Mon - Fri: 09:00AM - 09:00PM\r\nSaturday: 09:00AM - 07:00PM\r\nSunday: Closed', '2026-04-28 05:34:05', '2026-04-28 05:34:05'),
(208, 'contact', 'parts_address', 'textarea', 'Block 10, Plot 2, The Lennox Mall, 3 Admiralty Wy, Lekki Phase 1, Lagos 100001, Lagos, Nigeria', '2026-04-28 05:34:05', '2026-04-28 05:34:05'),
(209, 'contact', 'parts_phone', 'text', '+234 9135777722', '2026-04-28 05:34:05', '2026-04-28 05:34:05'),
(210, 'contact', 'parts_hours', 'textarea', 'Mon - Fri: 09:00AM - 09:00PM\r\nSaturday: 09:00AM - 07:00PM\r\nSunday: Closed', '2026-04-28 05:34:05', '2026-04-28 05:34:05'),
(211, 'contact', 'renting_address', 'textarea', '1840 E Garvey Ave South West Covina, CA 91791', '2026-04-28 05:34:05', '2026-04-28 05:34:05'),
(212, 'contact', 'renting_phone', 'text', '(888) 354-1783', '2026-04-28 05:34:05', '2026-04-28 05:34:05'),
(213, 'contact', 'renting_hours', 'textarea', 'Mon - Fri: 09:00AM - 09:00PM\r\nSaturday: 09:00AM - 07:00PM\r\nSunday: Closed', '2026-04-28 05:34:05', '2026-04-28 05:34:05'),
(214, 'home', 'testimonial_avatar', 'image', 'asset/images/media/home-testimonial-avatar.jpg', '2026-04-28 05:44:58', '2026-04-28 05:44:58');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2026-04-17 00:36:01', '2026-04-17 00:36:01'),
(2, 'user', 'web', '2026-04-17 00:36:01', '2026-04-17 00:36:01');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0XRv8ArKpoA52v7w4ZsVP05qtF6bVWRJL5cnqzi2', NULL, '88.151.33.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibEh3T2ZJanJidzJodW44Q3NzQ21QcjRFbXFuUjVTUnlpcFNjeG1STiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vc3RhZ2luZy5teWF1dG90b3JxdWUuY29tIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1777478955),
('6zyXdGYEPLa8OBiV7l8qrREuD0Si158U6qb8I9av', NULL, '142.250.32.37', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTmlhY2x6WEw4Y0Y2ekVwcUhXbHpsVHpRYW5zV2ZPSVhFVlZyMFBaWSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vc3RhZ2luZy5teWF1dG90b3JxdWUuY29tIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1777558983),
('aOTxFQMId1BaIuLXlFHIGtotkrYGOidxlsk2A4nR', NULL, '102.88.108.255', 'WhatsApp/2.23.20.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMWFZTWlWMExLMGJPbUZYTWxlSGg2TmhUakxHb1BBTjN2Wm9oTHIzYyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vc3RhZ2luZy5teWF1dG90b3JxdWUuY29tIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1777540082),
('bQTFDYwWrIh23wJOs9csL6wCu8j6GFazYUd9gBpV', NULL, '102.88.108.255', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZUczQmFwTVE3MGRYV3FNaEdaV3luTGE0M3VnM0poM2o2N0lXOEhnZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vc3RhZ2luZy5teWF1dG90b3JxdWUuY29tIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjc6ImNvbXBhcmUiO2E6MTp7czoxMToidmVoaWNsZV9pZHMiO2E6MTp7aTowO2k6NTA7fX19', 1777540314),
('Dd6vOei2vXkgkQrEURyZ9jsQAk1UUVPEBDI5whON', NULL, '88.151.33.117', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMUl2dWdBbEdMSHhvZ21mMlY1Zlg5cWNHOElQaDBuNHc2d2EyWkRnRCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vc3RhZ2luZy5teWF1dG90b3JxdWUuY29tIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1777478955),
('dQqpJMa4IspFNIUGnjWfgkPbxeif8ziwUQ9SCruI', NULL, '66.132.172.214', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNkxzQW9lVVZMc3FWWXRydUlIUzhMMjg2SVlTc1ZWcHQ5M3pTSkN1ZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vc3RhZ2luZy5teWF1dG90b3JxdWUuY29tIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1777472659),
('g7Lta0KZS88u86LTu9ZwaPP44QbpBaQdYh1M2Jp5', NULL, '142.250.32.38', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYTRFNnZta1dBV1pnWHpTZ0JHbXgwUHQwVGlpYm9ITmh0dm8xZ3NaeSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vc3RhZ2luZy5teWF1dG90b3JxdWUuY29tIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1777558984),
('im547tqpnKNrtQNWzv9VbkLWbdByOvgFbzRVwqQX', NULL, '146.190.147.95', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieGhXNDY5bUx3NUFMdDM3VW9LdUlObXJZMVFGZlFQYTRkUzhicjMxSiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vd3d3LnN0YWdpbmcubXlhdXRvdG9ycXVlLmNvbSI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777558631),
('Kbg9gHywBvttFNO8Ok9Y6FogebcDk2W5dRyWrCka', NULL, '102.88.108.255', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiekZ4ekd6cW1jb0ZIaGt0bU92Mnd3RXd2OEk3ZWVCQmVKb1h2WFphTyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTA2OiJodHRwczovL3N0YWdpbmcubXlhdXRvdG9ycXVlLmNvbS9tZWRpYS9zdG9yYWdlL3NpdGUtc2V0dGluZ3MvbG9nby0xZmQxMzljNC1iNGI1LTQ5N2UtODRmZC04NTU1NzQ0YzYzYWEucG5nIjtzOjU6InJvdXRlIjtzOjE4OiJtZWRpYS5zdG9yYWdlLnNob3ciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1777540054),
('N6VWuRKLlWlR3kesj1R0Qk97DL9zR2V8pT0D6ao0', NULL, '142.250.32.38', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQk1FTkJzNWFjc3FxZWU4d0d4ajU0VXpkdnpqMW01cDZBWXVLenBWYyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHBzOi8vc3RhZ2luZy5teWF1dG90b3JxdWUuY29tL2ludmVudG9yeSI7czo1OiJyb3V0ZSI7czoxNToiaW52ZW50b3J5LmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777559026),
('NNmLdh3anQVMpzq3sqZitQB7FQV9NA0EjUWyUPBi', NULL, '142.250.32.39', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicjl2cU9wZ1phVGxWS1dvelN4dnkzZmtKZ3JVdlg1RXNaZDM3VDFkMyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHBzOi8vc3RhZ2luZy5teWF1dG90b3JxdWUuY29tL2ludmVudG9yeSI7czo1OiJyb3V0ZSI7czoxNToiaW52ZW50b3J5LmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777559025),
('S4OumYnq49DEELMpR8K6SLc5NQKluJkFZNbDSoeA', NULL, '88.151.33.117', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidmF0N3RtZnVBdkhzN1phczk0NlIzbzBGZ0d3RVFieUJkbnRHYVR1VyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vc3RhZ2luZy5teWF1dG90b3JxdWUuY29tIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1777478957),
('TPj3yCinjlUi10hoXs0BAFwoBqOvcebAga9F1Ce1', NULL, '102.89.83.114', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRG9ZbjkwbVZsTjBJRjdLTFJrbVV4U2k0YXYwV2Vadk16VFFSdjkwZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vc3RhZ2luZy5teWF1dG90b3JxdWUuY29tIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1777559056),
('wd6Qy8mCGJTJb9fOLF66B28U2QOVtBDO85GN3YRI', 1, '51.15.22.23', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSHFWSTUxc0JJNWtSNVl5NGZOOTI4b3dpMkJ2a0tFQUpLdkp2NVo3NyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTg6Imh0dHBzOi8vc3RhZ2luZy5teWF1dG90b3JxdWUuY29tL2Rhc2hib2FyZC92ZWhpY2xlcy9jcmVhdGUiO3M6NToicm91dGUiO3M6MjU6ImRhc2hib2FyZC52ZWhpY2xlcy5jcmVhdGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1777636270),
('ws7x4osfMbJ5XcniSWyzgi68Op8B6iPnDOJxglVy', 1, '102.88.111.13', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiNThIaXNQejVhVm02cEJ4b2FFQmphbklhWmFxNEdJVUpkR2hRZmhHNiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vc3RhZ2luZy5teWF1dG90b3JxdWUuY29tL2NvbnRhY3QiO3M6NToicm91dGUiO3M6NzoiY29udGFjdCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTM6InNpdGVfY3VycmVuY3kiO3M6MzoiTkdOIjt9', 1777474909),
('wVkGNrYdBnSrRNo1Zzbx6JKFwv9Dr68tqjfbGD0K', NULL, '192.178.11.103', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWThlVzFOM2NrdnM3NVdTWnQzOFdSYkNkaURqUDNnQ1I1UDhIWmRlciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHBzOi8vc3RhZ2luZy5teWF1dG90b3JxdWUuY29tL2ludmVudG9yeSI7czo1OiJyb3V0ZSI7czoxNToiaW52ZW50b3J5LmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1777559025),
('XfqlmMpjgOTvwzDAr4xFmq0tWj7PDpRU0kvzRjly', NULL, '102.88.108.255', 'WhatsApp/2.23.20.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU0RBN0ExNUVZaXBGWW12WFFnMnZoVGQxSTY2RWZHYUQ3ajdWNmIwUiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vc3RhZ2luZy5teWF1dG90b3JxdWUuY29tIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1777540081),
('Xfw0v5q77eLsVyezWgYNSL8U95TFXxn8altISNVd', NULL, '142.250.32.37', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVnpTdGM0T2pCV2IyRW9VUWE5TmFtVjZlMHdqUno5ZDVQUjZlNU1OUiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vc3RhZ2luZy5teWF1dG90b3JxdWUuY29tIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1777558984),
('zh1PQ5cTwCLFkf2GOOwW5sGxM1VZeVQIIPDm4jAU', NULL, '142.93.181.168', 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiajhtYzkzYUpTTERkbHVEVFlTd2tWYWVWRFFwNWFVRTVERnFGT2F5SCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vc3RhZ2luZy5teWF1dG90b3JxdWUuY29tIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1777640392);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'dealer_phone', '+1 212-226-3126', '2026-04-17 00:36:01', '2026-04-17 00:36:01'),
(2, 'dealer_address', '1840 E Garvey Ave South West Covina, CA 91791', '2026-04-17 00:36:01', '2026-04-17 00:36:01'),
(3, 'dealer_hours_label', 'Work Hours', '2026-04-17 00:36:01', '2026-04-17 00:36:01'),
(4, 'dealer_sales_phone', '(888) 354-1781', '2026-04-17 00:36:01', '2026-04-17 00:36:01'),
(5, 'dealer_sales_hours', 'Mon – Fri: 09:00AM – 09:00PM\r\nSaturday: 09:00AM – 07:00PM\r\nSunday: Closed', '2026-04-17 00:36:01', '2026-04-29 16:17:46'),
(6, 'footer_about', 'Fusce interdum ipsum egestas urna amet fringilla, et placerat ex venenatis. Aliquet luctus pharetra. Proin sed fringilla lectus… ar sit amet tellus in mollis. Proin nec egestas nibh, eget egestas urna. Phasellus sit amet vehicula nunc. In hac habitasse platea dictumst.', '2026-04-17 00:36:01', '2026-04-17 00:36:01'),
(7, 'copyright_line', 'MyAutoTorque', '2026-04-17 00:36:01', '2026-04-17 00:36:01'),
(8, 'social_facebook', 'https://www.facebook.com/', '2026-04-17 00:36:01', '2026-04-17 00:36:01'),
(9, 'social_instagram', 'https://www.instagram.com/', '2026-04-17 00:36:01', '2026-04-17 00:36:01'),
(10, 'social_linkedin', 'https://www.linkedin.com/', '2026-04-17 00:36:01', '2026-04-17 00:36:01'),
(11, 'social_youtube', 'https://www.youtube.com/', '2026-04-17 00:36:01', '2026-04-17 00:36:01'),
(12, 'site_display_name', 'My AutoTorque', '2026-04-29 16:17:46', '2026-04-29 16:17:46'),
(13, 'currency_label', 'Currency (USD)', '2026-04-29 16:17:46', '2026-04-29 16:17:46'),
(14, 'dealer_service_hours', 'Monday - Friday: 09:00AM - 09:00PM\r\nSaturday: 09:00AM - 07:00PM\r\nSunday: Closed', '2026-04-29 16:17:46', '2026-04-29 16:17:46'),
(15, 'dealer_parts_hours', 'Monday - Friday: 09:00AM - 09:00PM\r\nSaturday: 09:00AM - 07:00PM\r\nSunday: Closed', '2026-04-29 16:17:46', '2026-04-29 16:17:46'),
(16, 'footer_tagline', 'Premium automotive retail experience. Redefining the way you browse and buy luxury vehicles with curated inventory and bespoke service.', '2026-04-29 16:17:46', '2026-04-29 16:17:46'),
(17, 'footer_blog_title', 'Latest Blog Posts', '2026-04-29 16:17:46', '2026-04-29 16:17:46'),
(18, 'footer_blog_entries_json', '[]', '2026-04-29 16:17:46', '2026-04-29 16:17:46'),
(19, 'newsletter_enabled', '0', '2026-04-29 16:17:46', '2026-04-29 16:17:46'),
(20, 'newsletter_note', 'Get latest updates and offers.', '2026-04-29 16:17:46', '2026-04-29 16:17:46'),
(21, 'footer_privacy_url', '#', '2026-04-29 16:17:46', '2026-04-29 16:17:46'),
(22, 'footer_terms_url', '#', '2026-04-29 16:17:46', '2026-04-29 16:17:46'),
(23, 'logo_path', 'storage/site-settings/logo-1fd139c4-b4b5-497e-84fd-8555744c63aa.png', '2026-04-29 18:50:45', '2026-04-29 18:50:45'),
(24, 'currency_code', 'USD', '2026-04-29 18:50:45', '2026-04-29 18:50:45');

-- --------------------------------------------------------

--
-- Table structure for table `site_traffic_events`
--

CREATE TABLE `site_traffic_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(1024) NOT NULL,
  `route_name` varchar(255) DEFAULT NULL,
  `url` text DEFAULT NULL,
  `method` varchar(10) NOT NULL DEFAULT 'GET',
  `referrer_host` varchar(255) DEFAULT NULL,
  `referrer_url` text DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `ip_hash` varchar(64) DEFAULT NULL,
  `session_id` varchar(120) DEFAULT NULL,
  `vehicle_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vehicle_slug` varchar(255) DEFAULT NULL,
  `viewed_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_traffic_events`
--

INSERT INTO `site_traffic_events` (`id`, `path`, `route_name`, `url`, `method`, `referrer_host`, `referrer_url`, `user_agent`, `ip_hash`, `session_id`, `vehicle_id`, `vehicle_slug`, `viewed_at`, `created_at`, `updated_at`) VALUES
(1, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '5bbfff9e8e480beed567f0dd576b8ae0a8bc6cf57850737a7bc984fcad50628b', '6umcS4bfGSk2vO6qp8jjAXFcAQ0GdSqMGti8MzQm', NULL, NULL, '2026-04-21 15:25:20', '2026-04-21 15:25:20', '2026-04-21 15:25:20'),
(2, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/admin/analytics', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '5bbfff9e8e480beed567f0dd576b8ae0a8bc6cf57850737a7bc984fcad50628b', 'F3vtlHlxqIAil6iKJGxDdLxbI1AXVUwSUOULivWt', NULL, NULL, '2026-04-21 15:26:21', '2026-04-21 15:26:21', '2026-04-21 15:26:21'),
(3, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko; compatible; BuiltWith/1.4; rb.gy/xprgqj) Chrome/124.0.0.0 Safari/537.36', 'd87e632077f78636a5ac339b0bb5df747133d359dd2e71b4b0f8446edb39776c', 'dBhhStpmnOCxHejtaZTexxvKKZmZv0DaCnLLv980', NULL, NULL, '2026-04-21 16:16:17', '2026-04-21 16:16:17', '2026-04-21 16:16:17'),
(4, 'inventory/2021-bmw-m4-competition', 'inventory.show', 'https://staging.myautotorque.com/inventory/2021-bmw-m4-competition', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko; compatible; BuiltWith/1.4; rb.gy/xprgqj) Chrome/124.0.0.0 Safari/537.36', 'd87e632077f78636a5ac339b0bb5df747133d359dd2e71b4b0f8446edb39776c', 'dBhhStpmnOCxHejtaZTexxvKKZmZv0DaCnLLv980', NULL, '2021-bmw-m4-competition', '2026-04-21 16:16:18', '2026-04-21 16:16:18', '2026-04-21 16:16:18'),
(5, 'inventory/2022-lexus-es-350', 'inventory.show', 'https://staging.myautotorque.com/inventory/2022-lexus-es-350', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko; compatible; BuiltWith/1.4; rb.gy/xprgqj) Chrome/124.0.0.0 Safari/537.36', 'd87e632077f78636a5ac339b0bb5df747133d359dd2e71b4b0f8446edb39776c', 'dBhhStpmnOCxHejtaZTexxvKKZmZv0DaCnLLv980', NULL, '2022-lexus-es-350', '2026-04-21 16:16:18', '2026-04-21 16:16:18', '2026-04-21 16:16:18'),
(6, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36', '6bdf18fe918741e557e8ddaaa74b548deb5b49f111568c236e338bf314255ca4', 'Fuw5qhq9FojLDpN9AyDqbOhxBGrWpGaZSmhfSzo4', NULL, NULL, '2026-04-21 16:55:20', '2026-04-21 16:55:20', '2026-04-21 16:55:20'),
(7, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.79 Safari/537.36', '6bdf18fe918741e557e8ddaaa74b548deb5b49f111568c236e338bf314255ca4', 'yLpykyhdzCByxMJjbUjdnjIC2qWIxYE4j5Pq5Xml', NULL, NULL, '2026-04-21 16:55:25', '2026-04-21 16:55:25', '2026-04-21 16:55:25'),
(8, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '1f0cea560d407ed52d6b173751518fb0b4105544afa61fbb81d52f4d71c848d5', 'F3vtlHlxqIAil6iKJGxDdLxbI1AXVUwSUOULivWt', NULL, NULL, '2026-04-21 16:56:52', '2026-04-21 16:56:52', '2026-04-21 16:56:52'),
(9, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', '3495c3c36f4dc2c3f318d1aaa9a4fe4d9f22c4be5f1cfcc290561b055c4a2118', 'jKb4R4P3IqORIK7Taj1nUiw1TYWgKBXoCf6Nap5c', NULL, NULL, '2026-04-21 17:34:00', '2026-04-21 17:34:00', '2026-04-21 17:34:00'),
(10, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/admin/analytics?range=7', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '47c66c40e0dd87e87c3442bc90228808fcf14038e3c99c72b7b04559da76f6b2', 'V9hlpv29xbQtouCz4ZRsLRewlPXf83eJXMQDu3gR', NULL, NULL, '2026-04-21 17:51:53', '2026-04-21 17:51:53', '2026-04-21 17:51:53'),
(11, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', '50f3422eb9dc311fcd5392025c67d7bef58eb7f8b82b273d0269adf048f66f22', 'bHu2S6YD5l4oimK68y5lMpuKUwdspwuU2HQFpo0J', NULL, NULL, '2026-04-21 18:43:10', '2026-04-21 18:43:10', '2026-04-21 18:43:10'),
(12, '/', 'home', 'https://www.staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', '197127623f61ee8652b4940cc2df2cf7d337548859a9d6d2d86590eb517843e8', 'Ri1yOKCRnAdgU7zQzV0HarW1AJfTeruXCndlAhcq', NULL, NULL, '2026-04-21 19:13:26', '2026-04-21 19:13:26', '2026-04-21 19:13:26'),
(13, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'e04a7222b22ee79ed6d5f49fe3790b8a11239d345d0745cb4ad2c7b13e8e3034', 'OmBSsqUL7lb69gF1PtN2jqKAEUnkNQ2QJYqCuHRm', NULL, NULL, '2026-04-21 20:09:18', '2026-04-21 20:09:18', '2026-04-21 20:09:18'),
(14, '/', 'home', 'https://www.staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'dc436644df7d895726f2f1e565188cc72aafb4dbdd9af03c256426d54341880c', 'ytSLn8szoavxHejqceppAP90JBnzP3DU7dVcWdbm', NULL, NULL, '2026-04-21 22:02:28', '2026-04-21 22:02:28', '2026-04-21 22:02:28'),
(15, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', '24193ae1754d610b18383845869b4fd9b22cd8d7706cb3aeac0ef43a9b2ce211', 'MyzEhZsDK8AMtWeEo9ZRdTCQAuVJBD6ExDd7JvVE', NULL, NULL, '2026-04-21 22:02:44', '2026-04-21 22:02:44', '2026-04-21 22:02:44'),
(16, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '333d4d8ff24337f70608cf02a92eb35439691ea243b0e03d3f02582d42724d58', 'UxYh6ZvkNj3wUO53IynJg1avC6A1A6kR7NZhomMV', NULL, NULL, '2026-04-22 04:29:40', '2026-04-22 04:29:40', '2026-04-22 04:29:40'),
(17, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '1f79020d38ae9a0fdd2bee3f701573a086fe0547819dc57f19dc0da41b89e066', 'HzWuZTNMrRdO12Vfp9wC8ViJvsUHNcP3oc0pRQri', NULL, NULL, '2026-04-22 04:41:14', '2026-04-22 04:41:14', '2026-04-22 04:41:14'),
(18, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.1.17 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36', '333d4d8ff24337f70608cf02a92eb35439691ea243b0e03d3f02582d42724d58', '3CZw8FBHHei5bpg0shWyGKC5Fgjj4kH5vQseIDTR', NULL, NULL, '2026-04-22 04:46:42', '2026-04-22 04:46:42', '2026-04-22 04:46:42'),
(19, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '1f79020d38ae9a0fdd2bee3f701573a086fe0547819dc57f19dc0da41b89e066', 'HzWuZTNMrRdO12Vfp9wC8ViJvsUHNcP3oc0pRQri', NULL, NULL, '2026-04-22 04:47:31', '2026-04-22 04:47:31', '2026-04-22 04:47:31'),
(20, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '702ba595121f9c4906530678fc2c1ae5c76a56fb2396958f10b1135a1c331dd0', 'HzWuZTNMrRdO12Vfp9wC8ViJvsUHNcP3oc0pRQri', NULL, NULL, '2026-04-22 04:51:33', '2026-04-22 04:51:33', '2026-04-22 04:51:33'),
(21, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.1.17 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36', '333d4d8ff24337f70608cf02a92eb35439691ea243b0e03d3f02582d42724d58', '3CZw8FBHHei5bpg0shWyGKC5Fgjj4kH5vQseIDTR', NULL, NULL, '2026-04-22 05:50:54', '2026-04-22 05:50:54', '2026-04-22 05:50:54'),
(22, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/admin/analytics', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '333d4d8ff24337f70608cf02a92eb35439691ea243b0e03d3f02582d42724d58', 'YFpY1Er97zX2O7L3yJ5ATBAp0ocA8TxfAnOElPl9', NULL, NULL, '2026-04-22 05:52:21', '2026-04-22 05:52:21', '2026-04-22 05:52:21'),
(23, 'inventory/2021-bmw-m4-competition', 'inventory.show', 'https://staging.myautotorque.com/inventory/2021-bmw-m4-competition', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '333d4d8ff24337f70608cf02a92eb35439691ea243b0e03d3f02582d42724d58', 'M5fKmAZrWOxo80udwI5yCBETLgM5SUwPCD3xYm7B', NULL, '2021-bmw-m4-competition', '2026-04-22 06:07:13', '2026-04-22 06:07:13', '2026-04-22 06:07:13'),
(24, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/admin/pages/home/edit', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '367b954134659657a60f155548b3d86614cedd6c2558cbe9c9af2e15c9c81f7a', 'idbTHdNuJadRXFspWkrG2ekU682C2wSw6w8deMR2', NULL, NULL, '2026-04-22 13:00:14', '2026-04-22 13:00:14', '2026-04-22 13:00:14'),
(25, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/admin/analytics', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.1.17 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36', '367b954134659657a60f155548b3d86614cedd6c2558cbe9c9af2e15c9c81f7a', '0JY9PDFcwJw6vCin62kF1NW2yYd2L7OHg76pdh8y', NULL, NULL, '2026-04-22 13:30:59', '2026-04-22 13:30:59', '2026-04-22 13:30:59'),
(26, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '367b954134659657a60f155548b3d86614cedd6c2558cbe9c9af2e15c9c81f7a', 'g4wZr58Zw1rSi9Ul7W9GvhQGucR4PhmqwtTQucpx', NULL, NULL, '2026-04-22 13:34:59', '2026-04-22 13:34:59', '2026-04-22 13:34:59'),
(27, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '367b954134659657a60f155548b3d86614cedd6c2558cbe9c9af2e15c9c81f7a', 'g4wZr58Zw1rSi9Ul7W9GvhQGucR4PhmqwtTQucpx', NULL, NULL, '2026-04-22 13:35:26', '2026-04-22 13:35:26', '2026-04-22 13:35:26'),
(28, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/admin/analytics', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.1.17 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36', '367b954134659657a60f155548b3d86614cedd6c2558cbe9c9af2e15c9c81f7a', '0JY9PDFcwJw6vCin62kF1NW2yYd2L7OHg76pdh8y', NULL, NULL, '2026-04-22 13:35:35', '2026-04-22 13:35:35', '2026-04-22 13:35:35'),
(29, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '7171c5cf032155c5992ea3e8b471b5f6a69b5145c04d7a7fd24d6a7d52734460', 'g4wZr58Zw1rSi9Ul7W9GvhQGucR4PhmqwtTQucpx', NULL, NULL, '2026-04-22 13:54:07', '2026-04-22 13:54:07', '2026-04-22 13:54:07'),
(30, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/admin/analytics', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.1.17 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36', '7171c5cf032155c5992ea3e8b471b5f6a69b5145c04d7a7fd24d6a7d52734460', '0JY9PDFcwJw6vCin62kF1NW2yYd2L7OHg76pdh8y', NULL, NULL, '2026-04-22 13:54:28', '2026-04-22 13:54:28', '2026-04-22 13:54:28'),
(31, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '7171c5cf032155c5992ea3e8b471b5f6a69b5145c04d7a7fd24d6a7d52734460', 'g4wZr58Zw1rSi9Ul7W9GvhQGucR4PhmqwtTQucpx', NULL, NULL, '2026-04-22 14:10:14', '2026-04-22 14:10:14', '2026-04-22 14:10:14'),
(32, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/admin/analytics', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.1.17 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36', '7171c5cf032155c5992ea3e8b471b5f6a69b5145c04d7a7fd24d6a7d52734460', '0JY9PDFcwJw6vCin62kF1NW2yYd2L7OHg76pdh8y', NULL, NULL, '2026-04-22 14:11:26', '2026-04-22 14:11:26', '2026-04-22 14:11:26'),
(33, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'fdb5c7c42f0ad4e3a0f8bbbe5a3623378164076c11540d77bf8c879555118bde', 'g4wZr58Zw1rSi9Ul7W9GvhQGucR4PhmqwtTQucpx', NULL, NULL, '2026-04-22 14:29:07', '2026-04-22 14:29:07', '2026-04-22 14:29:07'),
(34, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/admin/analytics', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.1.17 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36', 'fdb5c7c42f0ad4e3a0f8bbbe5a3623378164076c11540d77bf8c879555118bde', '0JY9PDFcwJw6vCin62kF1NW2yYd2L7OHg76pdh8y', NULL, NULL, '2026-04-22 14:29:18', '2026-04-22 14:29:18', '2026-04-22 14:29:18'),
(35, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'fdb5c7c42f0ad4e3a0f8bbbe5a3623378164076c11540d77bf8c879555118bde', 'g4wZr58Zw1rSi9Ul7W9GvhQGucR4PhmqwtTQucpx', NULL, NULL, '2026-04-22 14:45:35', '2026-04-22 14:45:35', '2026-04-22 14:45:35'),
(36, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/admin/analytics', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.1.17 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36', 'fdb5c7c42f0ad4e3a0f8bbbe5a3623378164076c11540d77bf8c879555118bde', '0JY9PDFcwJw6vCin62kF1NW2yYd2L7OHg76pdh8y', NULL, NULL, '2026-04-22 14:47:13', '2026-04-22 14:47:13', '2026-04-22 14:47:13'),
(37, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'fdb5c7c42f0ad4e3a0f8bbbe5a3623378164076c11540d77bf8c879555118bde', 'g4wZr58Zw1rSi9Ul7W9GvhQGucR4PhmqwtTQucpx', NULL, NULL, '2026-04-22 14:55:44', '2026-04-22 14:55:44', '2026-04-22 14:55:44'),
(38, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/admin/analytics', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.1.17 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36', 'fdb5c7c42f0ad4e3a0f8bbbe5a3623378164076c11540d77bf8c879555118bde', '0JY9PDFcwJw6vCin62kF1NW2yYd2L7OHg76pdh8y', NULL, NULL, '2026-04-22 14:56:03', '2026-04-22 14:56:03', '2026-04-22 14:56:03'),
(39, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'fdb5c7c42f0ad4e3a0f8bbbe5a3623378164076c11540d77bf8c879555118bde', 'g4wZr58Zw1rSi9Ul7W9GvhQGucR4PhmqwtTQucpx', NULL, NULL, '2026-04-22 15:04:14', '2026-04-22 15:04:14', '2026-04-22 15:04:14'),
(40, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'fdb5c7c42f0ad4e3a0f8bbbe5a3623378164076c11540d77bf8c879555118bde', 'g4wZr58Zw1rSi9Ul7W9GvhQGucR4PhmqwtTQucpx', NULL, NULL, '2026-04-22 15:04:50', '2026-04-22 15:04:50', '2026-04-22 15:04:50'),
(41, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'fdb5c7c42f0ad4e3a0f8bbbe5a3623378164076c11540d77bf8c879555118bde', 'g4wZr58Zw1rSi9Ul7W9GvhQGucR4PhmqwtTQucpx', NULL, NULL, '2026-04-22 15:05:13', '2026-04-22 15:05:13', '2026-04-22 15:05:13'),
(42, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/admin/analytics', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.1.17 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36', 'fdb5c7c42f0ad4e3a0f8bbbe5a3623378164076c11540d77bf8c879555118bde', '0JY9PDFcwJw6vCin62kF1NW2yYd2L7OHg76pdh8y', NULL, NULL, '2026-04-22 15:06:17', '2026-04-22 15:06:17', '2026-04-22 15:06:17'),
(43, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'fdb5c7c42f0ad4e3a0f8bbbe5a3623378164076c11540d77bf8c879555118bde', 'g4wZr58Zw1rSi9Ul7W9GvhQGucR4PhmqwtTQucpx', NULL, NULL, '2026-04-22 15:36:11', '2026-04-22 15:36:11', '2026-04-22 15:36:11'),
(44, '/', 'home', 'https://www.staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', 'd3f9591df3d7fd13b162e006ae9cf8f1fb948cc252c5d1917452dceca97b788f', 's66D13PJSMAYPM6Xps5FQENjv5vmfnI6hlbVkHVC', NULL, NULL, '2026-04-23 15:55:29', '2026-04-23 15:55:29', '2026-04-23 15:55:29'),
(45, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 'b831187bcffd149f6ffd32c9337a6cdce612584c25f19f902d0d439e7f56c36c', 'DJDmGlnH072R1crhH2Imbq6dEgNFUQyRtJO8tI6o', NULL, NULL, '2026-04-24 14:01:45', '2026-04-24 14:01:45', '2026-04-24 14:01:45'),
(46, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', '4dc2be81d03db0a3dde047dc4d1d548b0adb47efea4736886587657ede07f47b', 'AxSV9qqGq3FKiuJ9iU9sdYCyjPAbmfrIwgXY1Spv', NULL, NULL, '2026-04-24 19:12:39', '2026-04-24 19:12:39', '2026-04-24 19:12:39'),
(47, '/', 'home', 'https://www.staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', '7ac7c77c70ae33d2b65019a74f044b522e717aeb50e21975c66dafb76489c2c9', 'VnqW7WS0kMPOHRIDm9nmouWJBl5r0KLZpkE62Muz', NULL, NULL, '2026-04-24 22:03:36', '2026-04-24 22:03:36', '2026-04-24 22:03:36'),
(48, '/', 'home', 'https://www.staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36', 'a50a0dc2dfde8ef7b6194900c85dc498768136d275a3002bdf501cd275b48c33', 'xBXzmoelbs0HtazmZ44N2SWUyfAsQBam0J6mbOAx', NULL, NULL, '2026-04-25 14:20:21', '2026-04-25 14:20:21', '2026-04-25 14:20:21'),
(49, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36', '4cd030c72a3c62f4e9c4125a856236117a5f47fd3182e40eef2885e9ba4916a0', 'zgmRxGqp5AifOP1IUtA4eEUDivA9oFpL9hN3FjLo', NULL, NULL, '2026-04-26 05:22:38', '2026-04-26 05:22:38', '2026-04-26 05:22:38'),
(50, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'S1kcHHFGAnFamChqOD3SdXavlpkBMJjD7Cah2lqx', NULL, NULL, '2026-04-27 01:43:52', '2026-04-27 01:43:52', '2026-04-27 01:43:52'),
(51, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.1.17 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'HugMDgJ0ZVKbAIbONKGhfOtxqNsvdOtnvibcHr13', NULL, NULL, '2026-04-27 01:44:36', '2026-04-27 01:44:36', '2026-04-27 01:44:36'),
(52, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'o4CiWldG9U22QqyDuCv5rO2bJQ7Dj6T2vYG8YrfX', NULL, NULL, '2026-04-27 02:44:06', '2026-04-27 02:44:06', '2026-04-27 02:44:06'),
(53, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'o4CiWldG9U22QqyDuCv5rO2bJQ7Dj6T2vYG8YrfX', NULL, NULL, '2026-04-27 02:46:49', '2026-04-27 02:46:49', '2026-04-27 02:46:49'),
(54, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'o4CiWldG9U22QqyDuCv5rO2bJQ7Dj6T2vYG8YrfX', NULL, NULL, '2026-04-27 02:49:52', '2026-04-27 02:49:52', '2026-04-27 02:49:52'),
(55, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.1.17 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'HugMDgJ0ZVKbAIbONKGhfOtxqNsvdOtnvibcHr13', NULL, NULL, '2026-04-27 02:50:07', '2026-04-27 02:50:07', '2026-04-27 02:50:07'),
(56, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'o4CiWldG9U22QqyDuCv5rO2bJQ7Dj6T2vYG8YrfX', NULL, NULL, '2026-04-27 02:59:09', '2026-04-27 02:59:09', '2026-04-27 02:59:09'),
(57, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'o4CiWldG9U22QqyDuCv5rO2bJQ7Dj6T2vYG8YrfX', NULL, NULL, '2026-04-27 03:09:15', '2026-04-27 03:09:15', '2026-04-27 03:09:15'),
(58, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'o4CiWldG9U22QqyDuCv5rO2bJQ7Dj6T2vYG8YrfX', NULL, NULL, '2026-04-27 03:29:31', '2026-04-27 03:29:31', '2026-04-27 03:29:31'),
(59, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.1.17 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'HugMDgJ0ZVKbAIbONKGhfOtxqNsvdOtnvibcHr13', NULL, NULL, '2026-04-27 03:30:16', '2026-04-27 03:30:16', '2026-04-27 03:30:16'),
(60, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'o4CiWldG9U22QqyDuCv5rO2bJQ7Dj6T2vYG8YrfX', NULL, NULL, '2026-04-27 03:33:58', '2026-04-27 03:33:58', '2026-04-27 03:33:58'),
(61, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'o4CiWldG9U22QqyDuCv5rO2bJQ7Dj6T2vYG8YrfX', NULL, NULL, '2026-04-27 03:35:50', '2026-04-27 03:35:50', '2026-04-27 03:35:50'),
(62, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.1.17 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'HugMDgJ0ZVKbAIbONKGhfOtxqNsvdOtnvibcHr13', NULL, NULL, '2026-04-27 03:44:40', '2026-04-27 03:44:40', '2026-04-27 03:44:40'),
(63, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '82c514a1c31c651efec4cd84d456360a6dfe7b01e9f10c175c05d97d4501ea8e', 'o4CiWldG9U22QqyDuCv5rO2bJQ7Dj6T2vYG8YrfX', NULL, NULL, '2026-04-27 04:03:19', '2026-04-27 04:03:19', '2026-04-27 04:03:19'),
(64, 'inventory/2022-lexus-es-350', 'inventory.show', 'https://staging.myautotorque.com/inventory/2022-lexus-es-350', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '82c514a1c31c651efec4cd84d456360a6dfe7b01e9f10c175c05d97d4501ea8e', 'o4CiWldG9U22QqyDuCv5rO2bJQ7Dj6T2vYG8YrfX', NULL, '2022-lexus-es-350', '2026-04-27 04:03:32', '2026-04-27 04:03:32', '2026-04-27 04:03:32'),
(65, 'compare', 'compare', 'https://staging.myautotorque.com/compare', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '82c514a1c31c651efec4cd84d456360a6dfe7b01e9f10c175c05d97d4501ea8e', 'o4CiWldG9U22QqyDuCv5rO2bJQ7Dj6T2vYG8YrfX', NULL, NULL, '2026-04-27 04:15:19', '2026-04-27 04:15:19', '2026-04-27 04:15:19'),
(66, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/compare', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'a22c9e06aa44405b64c59224e3c4cbdb468f7547d185c47ec379645738ca117c', 'o4CiWldG9U22QqyDuCv5rO2bJQ7Dj6T2vYG8YrfX', NULL, NULL, '2026-04-27 04:15:36', '2026-04-27 04:15:36', '2026-04-27 04:15:36'),
(67, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'o4CiWldG9U22QqyDuCv5rO2bJQ7Dj6T2vYG8YrfX', NULL, NULL, '2026-04-27 05:09:53', '2026-04-27 05:09:53', '2026-04-27 05:09:53'),
(68, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'o4CiWldG9U22QqyDuCv5rO2bJQ7Dj6T2vYG8YrfX', NULL, NULL, '2026-04-27 05:16:47', '2026-04-27 05:16:47', '2026-04-27 05:16:47'),
(69, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'o4CiWldG9U22QqyDuCv5rO2bJQ7Dj6T2vYG8YrfX', NULL, NULL, '2026-04-27 05:16:58', '2026-04-27 05:16:58', '2026-04-27 05:16:58'),
(70, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'o4CiWldG9U22QqyDuCv5rO2bJQ7Dj6T2vYG8YrfX', NULL, NULL, '2026-04-27 06:15:44', '2026-04-27 06:15:44', '2026-04-27 06:15:44'),
(71, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/dashboard/vehicles/6/edit', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'AVUgLzaEVEegv1KQYME5QsHS9ZWRg7qNUJJW6hx5', NULL, NULL, '2026-04-27 07:10:25', '2026-04-27 07:10:25', '2026-04-27 07:10:25'),
(72, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/dashboard/vehicles/6/edit', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'AVUgLzaEVEegv1KQYME5QsHS9ZWRg7qNUJJW6hx5', NULL, NULL, '2026-04-27 07:10:31', '2026-04-27 07:10:31', '2026-04-27 07:10:31'),
(73, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'aEmml5kmP68QDGGxQZb0fWpawIXXUjnf48Dp1Axq', NULL, NULL, '2026-04-27 07:11:34', '2026-04-27 07:11:34', '2026-04-27 07:11:34'),
(74, 'inventory/2023-lamborghini-urus', 'inventory.show', 'https://staging.myautotorque.com/inventory/2023-lamborghini-urus', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'aEmml5kmP68QDGGxQZb0fWpawIXXUjnf48Dp1Axq', NULL, '2023-lamborghini-urus', '2026-04-27 07:15:49', '2026-04-27 07:15:49', '2026-04-27 07:15:49'),
(75, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory/2023-lamborghini-urus', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'aEmml5kmP68QDGGxQZb0fWpawIXXUjnf48Dp1Axq', NULL, NULL, '2026-04-27 07:19:56', '2026-04-27 07:19:56', '2026-04-27 07:19:56'),
(76, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory/2023-lamborghini-urus', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'aEmml5kmP68QDGGxQZb0fWpawIXXUjnf48Dp1Axq', NULL, NULL, '2026-04-27 07:21:59', '2026-04-27 07:21:59', '2026-04-27 07:21:59'),
(77, 'inventory/2023-lamborghini-urus-2', 'inventory.show', 'https://staging.myautotorque.com/inventory/2023-lamborghini-urus-2', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'aEmml5kmP68QDGGxQZb0fWpawIXXUjnf48Dp1Axq', 49, '2023-lamborghini-urus-2', '2026-04-27 07:22:15', '2026-04-27 07:22:15', '2026-04-27 07:22:15'),
(78, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory/2023-lamborghini-urus-2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'aEmml5kmP68QDGGxQZb0fWpawIXXUjnf48Dp1Axq', NULL, NULL, '2026-04-27 07:26:58', '2026-04-27 07:26:58', '2026-04-27 07:26:58'),
(79, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'aEmml5kmP68QDGGxQZb0fWpawIXXUjnf48Dp1Axq', NULL, NULL, '2026-04-27 07:27:03', '2026-04-27 07:27:03', '2026-04-27 07:27:03'),
(80, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'aEmml5kmP68QDGGxQZb0fWpawIXXUjnf48Dp1Axq', NULL, NULL, '2026-04-27 07:27:06', '2026-04-27 07:27:06', '2026-04-27 07:27:06'),
(81, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'aEmml5kmP68QDGGxQZb0fWpawIXXUjnf48Dp1Axq', NULL, NULL, '2026-04-27 07:30:58', '2026-04-27 07:30:58', '2026-04-27 07:30:58'),
(82, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'aEmml5kmP68QDGGxQZb0fWpawIXXUjnf48Dp1Axq', NULL, NULL, '2026-04-27 07:32:45', '2026-04-27 07:32:45', '2026-04-27 07:32:45'),
(83, 'inventory/2023-lamborghini-urus-2', 'inventory.show', 'https://staging.myautotorque.com/inventory/2023-lamborghini-urus-2', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'aEmml5kmP68QDGGxQZb0fWpawIXXUjnf48Dp1Axq', 49, '2023-lamborghini-urus-2', '2026-04-27 07:33:25', '2026-04-27 07:33:25', '2026-04-27 07:33:25'),
(84, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory/2023-lamborghini-urus-2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'aEmml5kmP68QDGGxQZb0fWpawIXXUjnf48Dp1Axq', NULL, NULL, '2026-04-27 07:33:45', '2026-04-27 07:33:45', '2026-04-27 07:33:45'),
(85, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'WhatsApp/2.23.20.0', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'yI3cnwrHJqJTLww8tyeQZJN8ZTB17BDhEO6DKBis', NULL, NULL, '2026-04-27 07:34:23', '2026-04-27 07:34:23', '2026-04-27 07:34:23'),
(86, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'WhatsApp/2.23.20.0', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'AnhVq2RGzWgZ2fNT69kc1p6DaGRgKqEAgzU8wNiG', NULL, NULL, '2026-04-27 07:34:24', '2026-04-27 07:34:24', '2026-04-27 07:34:24'),
(87, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'SbbbXkzuVUPUirdDtlLYJCSSEfc00JRUCASjef3L', NULL, NULL, '2026-04-27 07:34:36', '2026-04-27 07:34:36', '2026-04-27 07:34:36'),
(88, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'SbbbXkzuVUPUirdDtlLYJCSSEfc00JRUCASjef3L', NULL, NULL, '2026-04-27 07:35:31', '2026-04-27 07:35:31', '2026-04-27 07:35:31'),
(89, 'inventory/2023-lamborghini-urus-2', 'inventory.show', 'https://staging.myautotorque.com/inventory/2023-lamborghini-urus-2', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', '25167e008d343968fc78a5f012220f0e4dfe12c4b0c062ae2852810be61f6a55', 'SbbbXkzuVUPUirdDtlLYJCSSEfc00JRUCASjef3L', 49, '2023-lamborghini-urus-2', '2026-04-27 07:35:39', '2026-04-27 07:35:39', '2026-04-27 07:35:39'),
(90, '/', 'home', 'https://www.staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', '27bb9109516a9c83e281f54ff77bdfd9d96f04c0f1ad6c5176a070df596e2084', 'hykfgQ4AOE17W4wBY3InHa27mlkUw2vIQjgVWX2k', NULL, NULL, '2026-04-27 14:33:49', '2026-04-27 14:33:49', '2026-04-27 14:33:49'),
(91, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory/2023-lamborghini-urus-2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8040bb6293626fd88e363b8264fabba54ef8f27135369f6600b571eea940a3d3', '33qR4ZdOLW41How44SCCMcSu5XIxBS7ZTx1dFCT7', NULL, NULL, '2026-04-27 15:25:03', '2026-04-27 15:25:03', '2026-04-27 15:25:03'),
(92, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory/2023-lamborghini-urus-2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8040bb6293626fd88e363b8264fabba54ef8f27135369f6600b571eea940a3d3', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 15:32:29', '2026-04-27 15:32:29', '2026-04-27 15:32:29'),
(93, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.1.17 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36', '8040bb6293626fd88e363b8264fabba54ef8f27135369f6600b571eea940a3d3', '92g0Y4GnJqtVFJlWlci0G64D1Oh9X46DNGn5GPia', NULL, NULL, '2026-04-27 15:34:48', '2026-04-27 15:34:48', '2026-04-27 15:34:48'),
(94, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.1.17 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36', '8040bb6293626fd88e363b8264fabba54ef8f27135369f6600b571eea940a3d3', '92g0Y4GnJqtVFJlWlci0G64D1Oh9X46DNGn5GPia', NULL, NULL, '2026-04-27 15:36:36', '2026-04-27 15:36:36', '2026-04-27 15:36:36'),
(95, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.1.17 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36', '8040bb6293626fd88e363b8264fabba54ef8f27135369f6600b571eea940a3d3', '92g0Y4GnJqtVFJlWlci0G64D1Oh9X46DNGn5GPia', NULL, NULL, '2026-04-27 15:38:21', '2026-04-27 15:38:21', '2026-04-27 15:38:21'),
(96, '/', 'home', 'https://www.staging.myautotorque.com', 'GET', NULL, NULL, 'RecordedFuture Global Inventory Crawler', '42e4e65caebc862b6db664d54a8efec8e44395e6a78961ee0b98548d449dd592', 'G962zSS66EZQH8HJ8COycMm5o9xNPJgiTJvmiUa1', NULL, NULL, '2026-04-27 15:39:25', '2026-04-27 15:39:25', '2026-04-27 15:39:25'),
(97, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8040bb6293626fd88e363b8264fabba54ef8f27135369f6600b571eea940a3d3', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 15:56:24', '2026-04-27 15:56:24', '2026-04-27 15:56:24'),
(98, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.1.17 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36', '8040bb6293626fd88e363b8264fabba54ef8f27135369f6600b571eea940a3d3', '92g0Y4GnJqtVFJlWlci0G64D1Oh9X46DNGn5GPia', NULL, NULL, '2026-04-27 15:57:00', '2026-04-27 15:57:00', '2026-04-27 15:57:00'),
(99, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8040bb6293626fd88e363b8264fabba54ef8f27135369f6600b571eea940a3d3', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 15:57:20', '2026-04-27 15:57:20', '2026-04-27 15:57:20'),
(100, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.1.17 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36', '8040bb6293626fd88e363b8264fabba54ef8f27135369f6600b571eea940a3d3', '92g0Y4GnJqtVFJlWlci0G64D1Oh9X46DNGn5GPia', NULL, NULL, '2026-04-27 17:17:03', '2026-04-27 17:17:03', '2026-04-27 17:17:03'),
(101, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8040bb6293626fd88e363b8264fabba54ef8f27135369f6600b571eea940a3d3', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 17:58:22', '2026-04-27 17:58:22', '2026-04-27 17:58:22'),
(102, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8040bb6293626fd88e363b8264fabba54ef8f27135369f6600b571eea940a3d3', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 17:58:31', '2026-04-27 17:58:31', '2026-04-27 17:58:31'),
(103, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory?body_type=&condition=&drive=&fuel_type=&location=&make=&mileage_max=&mileage_min=&model=&price_max=&price_min=&q=2023&sort=newest&transmission=&year_max=&year_min=', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8040bb6293626fd88e363b8264fabba54ef8f27135369f6600b571eea940a3d3', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 17:59:15', '2026-04-27 17:59:15', '2026-04-27 17:59:15'),
(104, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory?q=2023&sort=newest&condition=&body_type=&make=&model=&transmission=&fuel_type=&drive=&location=&year_min=&year_max=&mileage_min=&mileage_max=&price_min=&price_max=', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8040bb6293626fd88e363b8264fabba54ef8f27135369f6600b571eea940a3d3', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 17:59:52', '2026-04-27 17:59:52', '2026-04-27 17:59:52'),
(105, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8040bb6293626fd88e363b8264fabba54ef8f27135369f6600b571eea940a3d3', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 18:00:45', '2026-04-27 18:00:45', '2026-04-27 18:00:45'),
(106, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8040bb6293626fd88e363b8264fabba54ef8f27135369f6600b571eea940a3d3', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 18:00:55', '2026-04-27 18:00:55', '2026-04-27 18:00:55'),
(107, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8040bb6293626fd88e363b8264fabba54ef8f27135369f6600b571eea940a3d3', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 18:11:49', '2026-04-27 18:11:49', '2026-04-27 18:11:49'),
(108, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8040bb6293626fd88e363b8264fabba54ef8f27135369f6600b571eea940a3d3', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 18:20:52', '2026-04-27 18:20:52', '2026-04-27 18:20:52'),
(109, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8040bb6293626fd88e363b8264fabba54ef8f27135369f6600b571eea940a3d3', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 18:29:40', '2026-04-27 18:29:40', '2026-04-27 18:29:40'),
(110, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.1.17 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36', '8040bb6293626fd88e363b8264fabba54ef8f27135369f6600b571eea940a3d3', '92g0Y4GnJqtVFJlWlci0G64D1Oh9X46DNGn5GPia', NULL, NULL, '2026-04-27 18:30:27', '2026-04-27 18:30:27', '2026-04-27 18:30:27'),
(111, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8040bb6293626fd88e363b8264fabba54ef8f27135369f6600b571eea940a3d3', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 18:36:48', '2026-04-27 18:36:48', '2026-04-27 18:36:48'),
(112, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8040bb6293626fd88e363b8264fabba54ef8f27135369f6600b571eea940a3d3', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 18:46:25', '2026-04-27 18:46:25', '2026-04-27 18:46:25'),
(113, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 20:38:29', '2026-04-27 20:38:29', '2026-04-27 20:38:29'),
(114, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 21:11:33', '2026-04-27 21:11:33', '2026-04-27 21:11:33'),
(115, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 21:19:32', '2026-04-27 21:19:32', '2026-04-27 21:19:32'),
(116, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 21:40:06', '2026-04-27 21:40:06', '2026-04-27 21:40:06');
INSERT INTO `site_traffic_events` (`id`, `path`, `route_name`, `url`, `method`, `referrer_host`, `referrer_url`, `user_agent`, `ip_hash`, `session_id`, `vehicle_id`, `vehicle_slug`, `viewed_at`, `created_at`, `updated_at`) VALUES
(117, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 21:46:42', '2026-04-27 21:46:42', '2026-04-27 21:46:42'),
(118, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 21:50:40', '2026-04-27 21:50:40', '2026-04-27 21:50:40'),
(119, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 21:58:32', '2026-04-27 21:58:32', '2026-04-27 21:58:32'),
(120, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', '2gjJavcXJX2sl0LoEHGU0pUjpQxaNGqByEkNcKMK', NULL, NULL, '2026-04-27 22:15:12', '2026-04-27 22:15:12', '2026-04-27 22:15:12'),
(121, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'www.google.com', 'https://www.google.com/', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/29.0 Chrome/136.0.0.0 Mobile Safari/537.36', 'b478381faccc4fc4ab10e2c10b7ec84c90e74be3dcff55fe90ef10eed377c841', '7D1tgni44dDZlqUWg4hk57jzD5e2QEPNGkLBlGqY', NULL, NULL, '2026-04-27 22:15:25', '2026-04-27 22:15:25', '2026-04-27 22:15:25'),
(122, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', '2gjJavcXJX2sl0LoEHGU0pUjpQxaNGqByEkNcKMK', NULL, NULL, '2026-04-27 22:15:25', '2026-04-27 22:15:25', '2026-04-27 22:15:25'),
(123, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 22:20:00', '2026-04-27 22:20:00', '2026-04-27 22:20:00'),
(124, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 22:47:53', '2026-04-27 22:47:53', '2026-04-27 22:47:53'),
(125, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 22:48:05', '2026-04-27 22:48:05', '2026-04-27 22:48:05'),
(126, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 22:51:58', '2026-04-27 22:51:58', '2026-04-27 22:51:58'),
(127, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', '2gjJavcXJX2sl0LoEHGU0pUjpQxaNGqByEkNcKMK', NULL, NULL, '2026-04-27 22:55:05', '2026-04-27 22:55:05', '2026-04-27 22:55:05'),
(128, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/about', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', '2gjJavcXJX2sl0LoEHGU0pUjpQxaNGqByEkNcKMK', NULL, NULL, '2026-04-27 22:58:33', '2026-04-27 22:58:33', '2026-04-27 22:58:33'),
(129, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', NULL, NULL, 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', '500ae0b92a7076cc39d9dae29b1b656fe98b43404f5cd720183b4d833c0ebcf5', 'fsTqOM2J4AZKr3rvQ0kupU6tjXlmFce7XVS13ok3', NULL, NULL, '2026-04-27 22:58:41', '2026-04-27 22:58:41', '2026-04-27 22:58:41'),
(130, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', NULL, NULL, 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', '500ae0b92a7076cc39d9dae29b1b656fe98b43404f5cd720183b4d833c0ebcf5', 'bXOx25PvK2BqnjHQNDew85zqu8TRQ1NLiY5Nn9Q5', NULL, NULL, '2026-04-27 22:58:41', '2026-04-27 22:58:41', '2026-04-27 22:58:41'),
(131, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/about', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', '2gjJavcXJX2sl0LoEHGU0pUjpQxaNGqByEkNcKMK', NULL, NULL, '2026-04-27 22:58:45', '2026-04-27 22:58:45', '2026-04-27 22:58:45'),
(132, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'www.google.com', 'https://www.google.com/', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', 'b478381faccc4fc4ab10e2c10b7ec84c90e74be3dcff55fe90ef10eed377c841', 'rybdZp6E8125wFvqrkbCI3h0IDcR9Xq4B7CaA9nZ', NULL, NULL, '2026-04-27 22:58:54', '2026-04-27 22:58:54', '2026-04-27 22:58:54'),
(133, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/about', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', '2gjJavcXJX2sl0LoEHGU0pUjpQxaNGqByEkNcKMK', NULL, NULL, '2026-04-27 22:59:11', '2026-04-27 22:59:11', '2026-04-27 22:59:11'),
(134, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 23:01:08', '2026-04-27 23:01:08', '2026-04-27 23:01:08'),
(135, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', '2gjJavcXJX2sl0LoEHGU0pUjpQxaNGqByEkNcKMK', NULL, NULL, '2026-04-27 23:01:48', '2026-04-27 23:01:48', '2026-04-27 23:01:48'),
(136, 'faq', 'faq', 'https://staging.myautotorque.com/faq', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/about', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 23:02:49', '2026-04-27 23:02:49', '2026-04-27 23:02:49'),
(137, 'faq', 'faq', 'https://staging.myautotorque.com/faq', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/about', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 23:21:05', '2026-04-27 23:21:05', '2026-04-27 23:21:05'),
(138, 'faq', 'faq', 'https://staging.myautotorque.com/faq', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/about', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 23:22:48', '2026-04-27 23:22:48', '2026-04-27 23:22:48'),
(139, 'faq', 'faq', 'https://staging.myautotorque.com/faq', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/about', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 23:22:53', '2026-04-27 23:22:53', '2026-04-27 23:22:53'),
(140, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/faq', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 23:23:29', '2026-04-27 23:23:29', '2026-04-27 23:23:29'),
(141, 'faq', 'faq', 'https://staging.myautotorque.com/faq', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/about', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 23:25:52', '2026-04-27 23:25:52', '2026-04-27 23:25:52'),
(142, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/faq', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 23:26:01', '2026-04-27 23:26:01', '2026-04-27 23:26:01'),
(143, 'faq', 'faq', 'https://staging.myautotorque.com/faq', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 23:26:04', '2026-04-27 23:26:04', '2026-04-27 23:26:04'),
(144, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/faq', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 23:26:10', '2026-04-27 23:26:10', '2026-04-27 23:26:10'),
(145, 'faq', 'faq', 'https://staging.myautotorque.com/faq', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 23:26:14', '2026-04-27 23:26:14', '2026-04-27 23:26:14'),
(146, 'faq', 'faq', 'https://staging.myautotorque.com/faq', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 23:38:51', '2026-04-27 23:38:51', '2026-04-27 23:38:51'),
(147, 'faq', 'faq', 'https://staging.myautotorque.com/faq', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 23:38:56', '2026-04-27 23:38:56', '2026-04-27 23:38:56'),
(148, 'contact', 'contact', 'https://staging.myautotorque.com/contact', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/faq', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 23:39:35', '2026-04-27 23:39:35', '2026-04-27 23:39:35'),
(149, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/contact', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 23:39:42', '2026-04-27 23:39:42', '2026-04-27 23:39:42'),
(150, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 23:41:23', '2026-04-27 23:41:23', '2026-04-27 23:41:23'),
(151, 'faq', 'faq', 'https://staging.myautotorque.com/faq', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/about', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'cb904ee288dbcdd2b6a6e4f15a6f43c3c9d08c543a655284d5a13b61a84f9b67', 'a1GwSDY2eYSZIkjg3NuvQXKdERb8a9se9EIwtNWd', NULL, NULL, '2026-04-27 23:42:24', '2026-04-27 23:42:24', '2026-04-27 23:42:24'),
(152, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/faq', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'K0EcoBF6gV6mE2SL0P8V7KwJ4GIlQsbRPoRBc7GB', NULL, NULL, '2026-04-28 04:53:11', '2026-04-28 04:53:11', '2026-04-28 04:53:11'),
(153, 'faq', 'faq', 'https://staging.myautotorque.com/faq', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/about', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'K0EcoBF6gV6mE2SL0P8V7KwJ4GIlQsbRPoRBc7GB', NULL, NULL, '2026-04-28 04:54:27', '2026-04-28 04:54:27', '2026-04-28 04:54:27'),
(154, 'faq', 'faq', 'https://staging.myautotorque.com/faq', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/about', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'K0EcoBF6gV6mE2SL0P8V7KwJ4GIlQsbRPoRBc7GB', NULL, NULL, '2026-04-28 05:07:45', '2026-04-28 05:07:45', '2026-04-28 05:07:45'),
(155, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/faq', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'K0EcoBF6gV6mE2SL0P8V7KwJ4GIlQsbRPoRBc7GB', NULL, NULL, '2026-04-28 05:08:17', '2026-04-28 05:08:17', '2026-04-28 05:08:17'),
(156, 'faq', 'faq', 'https://staging.myautotorque.com/faq', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/about', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'K0EcoBF6gV6mE2SL0P8V7KwJ4GIlQsbRPoRBc7GB', NULL, NULL, '2026-04-28 05:08:34', '2026-04-28 05:08:34', '2026-04-28 05:08:34'),
(157, 'faq', 'faq', 'https://staging.myautotorque.com/faq', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/faq', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:14:07', '2026-04-28 05:14:07', '2026-04-28 05:14:07'),
(158, 'faq', 'faq', 'https://staging.myautotorque.com/faq', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/about', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:14:15', '2026-04-28 05:14:15', '2026-04-28 05:14:15'),
(159, 'faq', 'faq', 'https://staging.myautotorque.com/faq', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/faq', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:16:07', '2026-04-28 05:16:07', '2026-04-28 05:16:07'),
(160, 'contact', 'contact', 'https://staging.myautotorque.com/contact', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/faq', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:16:26', '2026-04-28 05:16:26', '2026-04-28 05:16:26'),
(161, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'www.google.com', 'https://www.google.com/', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', 'c11008b73c9f14e0d82b138d71ce46d00f48fded93e7c6a6043bce70191e15c5', 'EGxJ55tvfSLzdAGLsrdWSRIM5ZpdvShQKJc9noFZ', NULL, NULL, '2026-04-28 05:23:39', '2026-04-28 05:23:39', '2026-04-28 05:23:39'),
(162, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/contact', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:24:22', '2026-04-28 05:24:22', '2026-04-28 05:24:22'),
(163, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory?body_type=&condition=used&drive=&fuel_type=&location=&make=&mileage_max=&mileage_min=&model=&price_max=&price_min=&q=&sort=newest&transmission=&year_max=&year_min=', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:24:40', '2026-04-28 05:24:40', '2026-04-28 05:24:40'),
(164, 'contact', 'contact', 'https://staging.myautotorque.com/contact', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory?q=&sort=newest&condition=used&body_type=&make=&model=&transmission=&fuel_type=&drive=&location=&year_min=&year_max=&mileage_min=&mileage_max=&price_min=&price_max=', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:26:12', '2026-04-28 05:26:12', '2026-04-28 05:26:12'),
(165, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/contact', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:27:41', '2026-04-28 05:27:41', '2026-04-28 05:27:41'),
(166, 'contact', 'contact', 'https://staging.myautotorque.com/contact', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:28:48', '2026-04-28 05:28:48', '2026-04-28 05:28:48'),
(167, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/contact', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:30:14', '2026-04-28 05:30:14', '2026-04-28 05:30:14'),
(168, 'contact', 'contact', 'https://staging.myautotorque.com/contact', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:31:48', '2026-04-28 05:31:48', '2026-04-28 05:31:48'),
(169, 'contact', 'contact', 'https://staging.myautotorque.com/contact', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:34:08', '2026-04-28 05:34:08', '2026-04-28 05:34:08'),
(170, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/contact', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:35:01', '2026-04-28 05:35:01', '2026-04-28 05:35:01'),
(171, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory?body_type=&condition=used&drive=&fuel_type=&location=nigeria&make=&mileage_max=&mileage_min=&model=&price_max=&price_min=&q=&sort=newest&transmission=&year_max=&year_min=', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:35:20', '2026-04-28 05:35:20', '2026-04-28 05:35:20'),
(172, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory?body_type=&condition=used&drive=&fuel_type=&location=united%20states&make=&mileage_max=&mileage_min=&model=&price_max=&price_min=&q=&sort=newest&transmission=&year_max=&year_min=', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory?q=&sort=newest&condition=used&body_type=&make=&model=&transmission=&fuel_type=&drive=&location=nigeria&year_min=&year_max=&mileage_min=&mileage_max=&price_min=&price_max=', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:37:38', '2026-04-28 05:37:38', '2026-04-28 05:37:38'),
(173, 'compare', 'compare', 'https://staging.myautotorque.com/compare', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory?q=&sort=newest&condition=used&body_type=&make=&model=&transmission=&fuel_type=&drive=&location=united+states&year_min=&year_max=&mileage_min=&mileage_max=&price_min=&price_max=', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:40:25', '2026-04-28 05:40:25', '2026-04-28 05:40:25'),
(174, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/compare', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:40:46', '2026-04-28 05:40:46', '2026-04-28 05:40:46'),
(175, 'inventory/2023-lamborghini-urus-2', 'inventory.show', 'https://staging.myautotorque.com/inventory/2023-lamborghini-urus-2', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', 49, '2023-lamborghini-urus-2', '2026-04-28 05:40:51', '2026-04-28 05:40:51', '2026-04-28 05:40:51'),
(176, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory/2023-lamborghini-urus-2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:41:45', '2026-04-28 05:41:45', '2026-04-28 05:41:45'),
(177, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory/2023-lamborghini-urus-2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:41:54', '2026-04-28 05:41:54', '2026-04-28 05:41:54'),
(178, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory/2023-lamborghini-urus-2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:45:01', '2026-04-28 05:45:01', '2026-04-28 05:45:01'),
(179, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory/2023-lamborghini-urus-2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:45:57', '2026-04-28 05:45:57', '2026-04-28 05:45:57'),
(180, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:46:56', '2026-04-28 05:46:56', '2026-04-28 05:46:56'),
(181, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:52:39', '2026-04-28 05:52:39', '2026-04-28 05:52:39'),
(182, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:56:15', '2026-04-28 05:56:15', '2026-04-28 05:56:15'),
(183, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:56:20', '2026-04-28 05:56:20', '2026-04-28 05:56:20'),
(184, 'contact', 'contact', 'https://staging.myautotorque.com/contact', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:56:24', '2026-04-28 05:56:24', '2026-04-28 05:56:24'),
(185, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/contact', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:56:29', '2026-04-28 05:56:29', '2026-04-28 05:56:29'),
(186, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/about', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8d6d573bac8030f980b99926121c09a892993944286f2b2a5582920cebbe9bee', 'Ubnoo2CQ6I0XV3JLmrBpUnluwyzesVWB1cecc4KZ', NULL, NULL, '2026-04-28 05:56:34', '2026-04-28 05:56:34', '2026-04-28 05:56:34'),
(187, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'be42e3a5826ff2ffea34973d254c461fdb5d698285fcbe0002a2aeddc0561279', 'ADcJTTHNl6Jn1I0KZeDg7mCRGTM5H83rTdaG7trG', NULL, NULL, '2026-04-28 11:25:40', '2026-04-28 11:25:40', '2026-04-28 11:25:40'),
(188, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'http://staging.myautotorque.com/', 'visionheight.com/scan Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Chrome/126.0.0.0 Safari/537.36', '79e71a89cdbacd76641a82b01c92cf410c990f9f997cb1efc9cf4043acd091d5', 'XI4z2A3GlTd2HeM3wwBiRPoVmZ4Litr1qd2lMov2', NULL, NULL, '2026-04-28 13:21:57', '2026-04-28 13:21:57', '2026-04-28 13:21:57'),
(189, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'visionheight.com/scan Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Chrome/126.0.0.0 Safari/537.36', '79e71a89cdbacd76641a82b01c92cf410c990f9f997cb1efc9cf4043acd091d5', 'mRoEzyoxxU7CtKEM7ytzXGmwUZI3trQkON0XE3u2', NULL, NULL, '2026-04-28 13:26:14', '2026-04-28 13:26:14', '2026-04-28 13:26:14'),
(190, '/', 'home', 'https://www.staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', '3495c3c36f4dc2c3f318d1aaa9a4fe4d9f22c4be5f1cfcc290561b055c4a2118', 'hWAfztVWioYLZ7dp6p1CkzkOGZO4XGc24xTHhOWF', NULL, NULL, '2026-04-28 17:09:13', '2026-04-28 17:09:13', '2026-04-28 17:09:13'),
(191, 'inventory/2023-lamborghini-urus-2', 'inventory.show', 'https://staging.myautotorque.com/inventory/2023-lamborghini-urus-2', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '592295cfe24709b96910eab5bcb8f9631e0fd542129bfb80ef88c1cf42fa7fc8', 'EJQpRFD2qMW7tc8oLxRleJ74jqD1xzwksaABTje6', 49, '2023-lamborghini-urus-2', '2026-04-28 18:55:59', '2026-04-28 18:55:59', '2026-04-28 18:55:59'),
(192, '/', 'home', 'https://www.staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', '1319121c6345006efd690e8939de5451dc1399dd1f99668501c71f37d798d239', 'euZUBTVQoz7WGdTxxzsv0Ni6c57tSnRR939HTLdw', NULL, NULL, '2026-04-28 19:13:40', '2026-04-28 19:13:40', '2026-04-28 19:13:40'),
(193, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '6348f6fa08be892382cc0d89d30029aa4e46d274f004dba139c881f3a0f22c71', 'EJQpRFD2qMW7tc8oLxRleJ74jqD1xzwksaABTje6', NULL, NULL, '2026-04-28 20:24:42', '2026-04-28 20:24:42', '2026-04-28 20:24:42'),
(194, 'inventory/2023-lamborghini-urus-2', 'inventory.show', 'https://staging.myautotorque.com/inventory/2023-lamborghini-urus-2', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '6348f6fa08be892382cc0d89d30029aa4e46d274f004dba139c881f3a0f22c71', 'EJQpRFD2qMW7tc8oLxRleJ74jqD1xzwksaABTje6', 49, '2023-lamborghini-urus-2', '2026-04-28 20:24:50', '2026-04-28 20:24:50', '2026-04-28 20:24:50'),
(195, '/', 'home', 'https://www.staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'b86f1c88343ce1e2af1501f9d393d9ffdf82a08e35a3605571fdd291e4671d74', '231j4mwJJieuEhgO4kOkfawZwegngUfLzNsV5Yfb', NULL, NULL, '2026-04-28 22:01:06', '2026-04-28 22:01:06', '2026-04-28 22:01:06'),
(196, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', '9e20d340ad5e9fb9d5af35cc85c546647be3c668e6b461f80f2e6d30ae202bb6', 'TRE8Ur1DVj461sT8gj7z0QDilkZaiG7r98RsKJTa', NULL, NULL, '2026-04-28 22:01:39', '2026-04-28 22:01:39', '2026-04-28 22:01:39'),
(197, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Cursor/3.2.11 Chrome/142.0.7444.265 Electron/39.8.1 Safari/537.36', 'e24d2077382e06083c05010af4c35a45583c5260703510b4992bddd9926604c4', 'LZR7oY1x6pBC8SPadZqLSXHbYi5mO6ifh6KZKTIa', NULL, NULL, '2026-04-29 03:41:49', '2026-04-29 03:41:49', '2026-04-29 03:41:49'),
(198, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'f785812cccacd33f35e29262c8c6f5e55399886b042f0f95f43dd50a2aa2457a', '8kispk8ByBdMDIS7sTTaPo0gmFSThJMUMsz4jKkX', NULL, NULL, '2026-04-29 03:42:40', '2026-04-29 03:42:40', '2026-04-29 03:42:40'),
(199, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'e24d2077382e06083c05010af4c35a45583c5260703510b4992bddd9926604c4', '1RgFIQkBC5YEekqPHKKE2s26W0SlUtplj3D6glrb', NULL, NULL, '2026-04-29 04:04:33', '2026-04-29 04:04:33', '2026-04-29 04:04:33'),
(200, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'e24d2077382e06083c05010af4c35a45583c5260703510b4992bddd9926604c4', '1RgFIQkBC5YEekqPHKKE2s26W0SlUtplj3D6glrb', NULL, NULL, '2026-04-29 04:05:11', '2026-04-29 04:05:11', '2026-04-29 04:05:11'),
(201, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory?condition=used&location=nigeria', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'e24d2077382e06083c05010af4c35a45583c5260703510b4992bddd9926604c4', '1RgFIQkBC5YEekqPHKKE2s26W0SlUtplj3D6glrb', NULL, NULL, '2026-04-29 04:05:40', '2026-04-29 04:05:40', '2026-04-29 04:05:40'),
(202, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory?condition=used&location=united%20states', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory?condition=used&location=nigeria', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'e24d2077382e06083c05010af4c35a45583c5260703510b4992bddd9926604c4', '1RgFIQkBC5YEekqPHKKE2s26W0SlUtplj3D6glrb', NULL, NULL, '2026-04-29 04:05:45', '2026-04-29 04:05:45', '2026-04-29 04:05:45'),
(203, 'about', 'about', 'https://staging.myautotorque.com/about', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory?condition=used&location=united%20states', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'e24d2077382e06083c05010af4c35a45583c5260703510b4992bddd9926604c4', '1RgFIQkBC5YEekqPHKKE2s26W0SlUtplj3D6glrb', NULL, NULL, '2026-04-29 04:05:47', '2026-04-29 04:05:47', '2026-04-29 04:05:47'),
(204, 'faq', 'faq', 'https://staging.myautotorque.com/faq', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/about', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'e24d2077382e06083c05010af4c35a45583c5260703510b4992bddd9926604c4', '1RgFIQkBC5YEekqPHKKE2s26W0SlUtplj3D6glrb', NULL, NULL, '2026-04-29 04:06:09', '2026-04-29 04:06:09', '2026-04-29 04:06:09'),
(205, 'contact', 'contact', 'https://staging.myautotorque.com/contact', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/faq', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'e24d2077382e06083c05010af4c35a45583c5260703510b4992bddd9926604c4', '1RgFIQkBC5YEekqPHKKE2s26W0SlUtplj3D6glrb', NULL, NULL, '2026-04-29 04:06:37', '2026-04-29 04:06:37', '2026-04-29 04:06:37'),
(206, 'inventory/2022-lexus-es-350', 'inventory.show', 'https://staging.myautotorque.com/inventory/2022-lexus-es-350', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2be7a3b7f23b82d1f09c7011a8d62ded51c059e57a2e7ca2d806c13c119a9aaf', 'b11JcT75emIti0EbSm9l4KvWcVcZnemzxHgPqtFg', NULL, '2022-lexus-es-350', '2026-04-29 04:21:01', '2026-04-29 04:21:01', '2026-04-29 04:21:01'),
(207, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2be7a3b7f23b82d1f09c7011a8d62ded51c059e57a2e7ca2d806c13c119a9aaf', 'b11JcT75emIti0EbSm9l4KvWcVcZnemzxHgPqtFg', NULL, NULL, '2026-04-29 04:27:07', '2026-04-29 04:27:07', '2026-04-29 04:27:07'),
(208, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'fcbb3d325c5c9eaf29a82e8ed177fe0048ebd95a3fb856d1aae15ec33d9ad518', 'b11JcT75emIti0EbSm9l4KvWcVcZnemzxHgPqtFg', NULL, NULL, '2026-04-29 04:27:27', '2026-04-29 04:27:27', '2026-04-29 04:27:27'),
(209, 'inventory/mercedes-benz-c-class', 'inventory.show', 'https://staging.myautotorque.com/inventory/mercedes-benz-c-class', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'fcbb3d325c5c9eaf29a82e8ed177fe0048ebd95a3fb856d1aae15ec33d9ad518', 'b11JcT75emIti0EbSm9l4KvWcVcZnemzxHgPqtFg', 50, 'mercedes-benz-c-class', '2026-04-29 04:28:01', '2026-04-29 04:28:01', '2026-04-29 04:28:01'),
(210, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '9cdcfcf356d5a682e99c21326d3b0b54eec4e76525abd7ffbc6d5c80560e4a53', 'VoRkrChhWSOUwLJRBhaYo4c9xPnKPIAFl0TBgnJL', NULL, NULL, '2026-04-29 15:56:52', '2026-04-29 15:56:52', '2026-04-29 15:56:52'),
(211, 'inventory/mercedes-benz-c-class', 'inventory.show', 'https://staging.myautotorque.com/inventory/mercedes-benz-c-class', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '9cdcfcf356d5a682e99c21326d3b0b54eec4e76525abd7ffbc6d5c80560e4a53', 'VoRkrChhWSOUwLJRBhaYo4c9xPnKPIAFl0TBgnJL', 50, 'mercedes-benz-c-class', '2026-04-29 16:14:01', '2026-04-29 16:14:01', '2026-04-29 16:14:01'),
(212, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '9cdcfcf356d5a682e99c21326d3b0b54eec4e76525abd7ffbc6d5c80560e4a53', 'ws7x4osfMbJ5XcniSWyzgi68Op8B6iPnDOJxglVy', NULL, NULL, '2026-04-29 16:15:51', '2026-04-29 16:15:51', '2026-04-29 16:15:51'),
(213, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory/mercedes-benz-c-class', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '9cdcfcf356d5a682e99c21326d3b0b54eec4e76525abd7ffbc6d5c80560e4a53', 'ws7x4osfMbJ5XcniSWyzgi68Op8B6iPnDOJxglVy', NULL, NULL, '2026-04-29 16:15:59', '2026-04-29 16:15:59', '2026-04-29 16:15:59'),
(214, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '9cdcfcf356d5a682e99c21326d3b0b54eec4e76525abd7ffbc6d5c80560e4a53', 'ws7x4osfMbJ5XcniSWyzgi68Op8B6iPnDOJxglVy', NULL, NULL, '2026-04-29 16:37:04', '2026-04-29 16:37:04', '2026-04-29 16:37:04'),
(215, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '9cdcfcf356d5a682e99c21326d3b0b54eec4e76525abd7ffbc6d5c80560e4a53', 'ws7x4osfMbJ5XcniSWyzgi68Op8B6iPnDOJxglVy', NULL, NULL, '2026-04-29 16:37:13', '2026-04-29 16:37:13', '2026-04-29 16:37:13'),
(216, 'inventory/mercedes-benz-c-class', 'inventory.show', 'https://staging.myautotorque.com/inventory/mercedes-benz-c-class', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '9cdcfcf356d5a682e99c21326d3b0b54eec4e76525abd7ffbc6d5c80560e4a53', 'ws7x4osfMbJ5XcniSWyzgi68Op8B6iPnDOJxglVy', 50, 'mercedes-benz-c-class', '2026-04-29 16:37:16', '2026-04-29 16:37:16', '2026-04-29 16:37:16'),
(217, 'inventory/mercedes-benz-c-class', 'inventory.show', 'https://staging.myautotorque.com/inventory/mercedes-benz-c-class', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '9cdcfcf356d5a682e99c21326d3b0b54eec4e76525abd7ffbc6d5c80560e4a53', 'ws7x4osfMbJ5XcniSWyzgi68Op8B6iPnDOJxglVy', 50, 'mercedes-benz-c-class', '2026-04-29 16:38:25', '2026-04-29 16:38:25', '2026-04-29 16:38:25'),
(218, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory/mercedes-benz-c-class', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '9cdcfcf356d5a682e99c21326d3b0b54eec4e76525abd7ffbc6d5c80560e4a53', 'ws7x4osfMbJ5XcniSWyzgi68Op8B6iPnDOJxglVy', NULL, NULL, '2026-04-29 18:02:54', '2026-04-29 18:02:54', '2026-04-29 18:02:54'),
(219, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'eb6b9d2e46ac71205b1a46ec9f900c631349fe59047e803a068882bdf1ebd3de', 'dQqpJMa4IspFNIUGnjWfgkPbxeif8ziwUQ9SCruI', NULL, NULL, '2026-04-29 18:24:19', '2026-04-29 18:24:19', '2026-04-29 18:24:19'),
(220, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '9cdcfcf356d5a682e99c21326d3b0b54eec4e76525abd7ffbc6d5c80560e4a53', 'ws7x4osfMbJ5XcniSWyzgi68Op8B6iPnDOJxglVy', NULL, NULL, '2026-04-29 18:50:08', '2026-04-29 18:50:08', '2026-04-29 18:50:08'),
(221, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '9cdcfcf356d5a682e99c21326d3b0b54eec4e76525abd7ffbc6d5c80560e4a53', 'ws7x4osfMbJ5XcniSWyzgi68Op8B6iPnDOJxglVy', NULL, NULL, '2026-04-29 18:50:52', '2026-04-29 18:50:52', '2026-04-29 18:50:52'),
(222, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '9cdcfcf356d5a682e99c21326d3b0b54eec4e76525abd7ffbc6d5c80560e4a53', 'ws7x4osfMbJ5XcniSWyzgi68Op8B6iPnDOJxglVy', NULL, NULL, '2026-04-29 18:50:58', '2026-04-29 18:50:58', '2026-04-29 18:50:58'),
(223, 'media/storage/site-settings/logo-1fd139c4-b4b5-497e-84fd-8555744c63aa.png', 'media.storage.show', 'https://staging.myautotorque.com/media/storage/site-settings/logo-1fd139c4-b4b5-497e-84fd-8555744c63aa.png', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/admin/settings', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '9cdcfcf356d5a682e99c21326d3b0b54eec4e76525abd7ffbc6d5c80560e4a53', 'ws7x4osfMbJ5XcniSWyzgi68Op8B6iPnDOJxglVy', NULL, NULL, '2026-04-29 19:00:56', '2026-04-29 19:00:56', '2026-04-29 19:00:56'),
(224, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '9cdcfcf356d5a682e99c21326d3b0b54eec4e76525abd7ffbc6d5c80560e4a53', 'ws7x4osfMbJ5XcniSWyzgi68Op8B6iPnDOJxglVy', NULL, NULL, '2026-04-29 19:01:01', '2026-04-29 19:01:01', '2026-04-29 19:01:01');
INSERT INTO `site_traffic_events` (`id`, `path`, `route_name`, `url`, `method`, `referrer_host`, `referrer_url`, `user_agent`, `ip_hash`, `session_id`, `vehicle_id`, `vehicle_slug`, `viewed_at`, `created_at`, `updated_at`) VALUES
(225, 'media/storage/site-settings/logo-1fd139c4-b4b5-497e-84fd-8555744c63aa.png', 'media.storage.show', 'https://staging.myautotorque.com/media/storage/site-settings/logo-1fd139c4-b4b5-497e-84fd-8555744c63aa.png', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '9cdcfcf356d5a682e99c21326d3b0b54eec4e76525abd7ffbc6d5c80560e4a53', 'ws7x4osfMbJ5XcniSWyzgi68Op8B6iPnDOJxglVy', NULL, NULL, '2026-04-29 19:01:02', '2026-04-29 19:01:02', '2026-04-29 19:01:02'),
(226, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '9cdcfcf356d5a682e99c21326d3b0b54eec4e76525abd7ffbc6d5c80560e4a53', 'ws7x4osfMbJ5XcniSWyzgi68Op8B6iPnDOJxglVy', NULL, NULL, '2026-04-29 19:01:34', '2026-04-29 19:01:34', '2026-04-29 19:01:34'),
(227, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '9cdcfcf356d5a682e99c21326d3b0b54eec4e76525abd7ffbc6d5c80560e4a53', 'ws7x4osfMbJ5XcniSWyzgi68Op8B6iPnDOJxglVy', NULL, NULL, '2026-04-29 19:01:39', '2026-04-29 19:01:39', '2026-04-29 19:01:39'),
(228, 'contact', 'contact', 'https://staging.myautotorque.com/contact', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '9cdcfcf356d5a682e99c21326d3b0b54eec4e76525abd7ffbc6d5c80560e4a53', 'ws7x4osfMbJ5XcniSWyzgi68Op8B6iPnDOJxglVy', NULL, NULL, '2026-04-29 19:01:49', '2026-04-29 19:01:49', '2026-04-29 19:01:49'),
(229, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '97ceb4dc18057ce3c6b09b62706bd30f214ced1036d2be19f1eee12e7ecd936d', '0XRv8ArKpoA52v7w4ZsVP05qtF6bVWRJL5cnqzi2', NULL, NULL, '2026-04-29 20:09:15', '2026-04-29 20:09:15', '2026-04-29 20:09:15'),
(230, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'http://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:137.0) Gecko/20100101 Firefox/137.0', '97ceb4dc18057ce3c6b09b62706bd30f214ced1036d2be19f1eee12e7ecd936d', 'Dd6vOei2vXkgkQrEURyZ9jsQAk1UUVPEBDI5whON', NULL, NULL, '2026-04-29 20:09:15', '2026-04-29 20:09:15', '2026-04-29 20:09:15'),
(231, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '97ceb4dc18057ce3c6b09b62706bd30f214ced1036d2be19f1eee12e7ecd936d', 'S4OumYnq49DEELMpR8K6SLc5NQKluJkFZNbDSoeA', NULL, NULL, '2026-04-29 20:09:17', '2026-04-29 20:09:17', '2026-04-29 20:09:17'),
(232, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '9745e5d3378076b9bda06f1b3c65345140167baefd01ce652923c5117001b06f', 'Kbg9gHywBvttFNO8Ok9Y6FogebcDk2W5dRyWrCka', NULL, NULL, '2026-04-30 13:07:33', '2026-04-30 13:07:33', '2026-04-30 13:07:33'),
(233, 'media/storage/site-settings/logo-1fd139c4-b4b5-497e-84fd-8555744c63aa.png', 'media.storage.show', 'https://staging.myautotorque.com/media/storage/site-settings/logo-1fd139c4-b4b5-497e-84fd-8555744c63aa.png', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '9745e5d3378076b9bda06f1b3c65345140167baefd01ce652923c5117001b06f', 'Kbg9gHywBvttFNO8Ok9Y6FogebcDk2W5dRyWrCka', NULL, NULL, '2026-04-30 13:07:34', '2026-04-30 13:07:34', '2026-04-30 13:07:34'),
(234, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'WhatsApp/2.23.20.0', '9745e5d3378076b9bda06f1b3c65345140167baefd01ce652923c5117001b06f', 'XfqlmMpjgOTvwzDAr4xFmq0tWj7PDpRU0kvzRjly', NULL, NULL, '2026-04-30 13:08:01', '2026-04-30 13:08:01', '2026-04-30 13:08:01'),
(235, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'WhatsApp/2.23.20.0', '9745e5d3378076b9bda06f1b3c65345140167baefd01ce652923c5117001b06f', 'aOTxFQMId1BaIuLXlFHIGtotkrYGOidxlsk2A4nR', NULL, NULL, '2026-04-30 13:08:02', '2026-04-30 13:08:02', '2026-04-30 13:08:02'),
(236, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', '9745e5d3378076b9bda06f1b3c65345140167baefd01ce652923c5117001b06f', 'bQTFDYwWrIh23wJOs9csL6wCu8j6GFazYUd9gBpV', NULL, NULL, '2026-04-30 13:08:22', '2026-04-30 13:08:22', '2026-04-30 13:08:22'),
(237, 'media/storage/site-settings/logo-1fd139c4-b4b5-497e-84fd-8555744c63aa.png', 'media.storage.show', 'https://staging.myautotorque.com/media/storage/site-settings/logo-1fd139c4-b4b5-497e-84fd-8555744c63aa.png', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', '9745e5d3378076b9bda06f1b3c65345140167baefd01ce652923c5117001b06f', 'bQTFDYwWrIh23wJOs9csL6wCu8j6GFazYUd9gBpV', NULL, NULL, '2026-04-30 13:08:24', '2026-04-30 13:08:24', '2026-04-30 13:08:24'),
(238, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', '9745e5d3378076b9bda06f1b3c65345140167baefd01ce652923c5117001b06f', 'bQTFDYwWrIh23wJOs9csL6wCu8j6GFazYUd9gBpV', NULL, NULL, '2026-04-30 13:10:12', '2026-04-30 13:10:12', '2026-04-30 13:10:12'),
(239, 'inventory/mercedes-benz-c-class', 'inventory.show', 'https://staging.myautotorque.com/inventory/mercedes-benz-c-class', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', '9745e5d3378076b9bda06f1b3c65345140167baefd01ce652923c5117001b06f', 'bQTFDYwWrIh23wJOs9csL6wCu8j6GFazYUd9gBpV', 50, 'mercedes-benz-c-class', '2026-04-30 13:10:30', '2026-04-30 13:10:30', '2026-04-30 13:10:30'),
(240, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory/mercedes-benz-c-class', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', '9745e5d3378076b9bda06f1b3c65345140167baefd01ce652923c5117001b06f', 'bQTFDYwWrIh23wJOs9csL6wCu8j6GFazYUd9gBpV', NULL, NULL, '2026-04-30 13:11:02', '2026-04-30 13:11:02', '2026-04-30 13:11:02'),
(241, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory?condition=used&location=nigeria', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', '9745e5d3378076b9bda06f1b3c65345140167baefd01ce652923c5117001b06f', 'bQTFDYwWrIh23wJOs9csL6wCu8j6GFazYUd9gBpV', NULL, NULL, '2026-04-30 13:11:18', '2026-04-30 13:11:18', '2026-04-30 13:11:18'),
(242, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory?condition=used&location=united%20states', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory?condition=used&location=nigeria', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', '9745e5d3378076b9bda06f1b3c65345140167baefd01ce652923c5117001b06f', 'bQTFDYwWrIh23wJOs9csL6wCu8j6GFazYUd9gBpV', NULL, NULL, '2026-04-30 13:11:21', '2026-04-30 13:11:21', '2026-04-30 13:11:21'),
(243, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory?condition=used&location=united%20states', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', '9745e5d3378076b9bda06f1b3c65345140167baefd01ce652923c5117001b06f', 'bQTFDYwWrIh23wJOs9csL6wCu8j6GFazYUd9gBpV', NULL, NULL, '2026-04-30 13:11:25', '2026-04-30 13:11:25', '2026-04-30 13:11:25'),
(244, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', '9745e5d3378076b9bda06f1b3c65345140167baefd01ce652923c5117001b06f', 'bQTFDYwWrIh23wJOs9csL6wCu8j6GFazYUd9gBpV', NULL, NULL, '2026-04-30 13:11:42', '2026-04-30 13:11:42', '2026-04-30 13:11:42'),
(245, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', '9745e5d3378076b9bda06f1b3c65345140167baefd01ce652923c5117001b06f', 'bQTFDYwWrIh23wJOs9csL6wCu8j6GFazYUd9gBpV', NULL, NULL, '2026-04-30 13:11:54', '2026-04-30 13:11:54', '2026-04-30 13:11:54'),
(246, '/', 'home', 'https://www.staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '00a20f06bef2bc1fa865981e4335168863a2f3f3eeb865c8b7d40a9175a8bc99', 'im547tqpnKNrtQNWzv9VbkLWbdByOvgFbzRVwqQX', NULL, NULL, '2026-04-30 18:17:11', '2026-04-30 18:17:11', '2026-04-30 18:17:11'),
(247, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', 'fe3b469ea5b8c89cbe3109e1730ffdb4c2d333687d2991b634724037eedac296', 'TPj3yCinjlUi10hoXs0BAFwoBqOvcebAga9F1Ce1', NULL, NULL, '2026-04-30 18:22:59', '2026-04-30 18:22:59', '2026-04-30 18:22:59'),
(248, 'media/storage/site-settings/logo-1fd139c4-b4b5-497e-84fd-8555744c63aa.png', 'media.storage.show', 'https://staging.myautotorque.com/media/storage/site-settings/logo-1fd139c4-b4b5-497e-84fd-8555744c63aa.png', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', 'fe3b469ea5b8c89cbe3109e1730ffdb4c2d333687d2991b634724037eedac296', 'TPj3yCinjlUi10hoXs0BAFwoBqOvcebAga9F1Ce1', NULL, NULL, '2026-04-30 18:23:00', '2026-04-30 18:23:00', '2026-04-30 18:23:00'),
(249, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'b3279e954ed1c24dfaabb3736b27bb9f5185e713a4df3e4caa280bc66d8dd9fe', '6zyXdGYEPLa8OBiV7l8qrREuD0Si158U6qb8I9av', NULL, NULL, '2026-04-30 18:23:03', '2026-04-30 18:23:03', '2026-04-30 18:23:03'),
(250, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'b3279e954ed1c24dfaabb3736b27bb9f5185e713a4df3e4caa280bc66d8dd9fe', 'Xfw0v5q77eLsVyezWgYNSL8U95TFXxn8altISNVd', NULL, NULL, '2026-04-30 18:23:04', '2026-04-30 18:23:04', '2026-04-30 18:23:04'),
(251, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', '4c73bc9d1efe38df3f57be4b2ef43dda8472473b32439bd2de4097298e382cb0', 'g7Lta0KZS88u86LTu9ZwaPP44QbpBaQdYh1M2Jp5', NULL, NULL, '2026-04-30 18:23:04', '2026-04-30 18:23:04', '2026-04-30 18:23:04'),
(252, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', 'fe3b469ea5b8c89cbe3109e1730ffdb4c2d333687d2991b634724037eedac296', 'TPj3yCinjlUi10hoXs0BAFwoBqOvcebAga9F1Ce1', NULL, NULL, '2026-04-30 18:23:42', '2026-04-30 18:23:42', '2026-04-30 18:23:42'),
(253, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', NULL, NULL, 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'ae9c67d6dd6e42f78cfeb363e8bc27b6c56719ece22017b1056de1a0e152d86f', 'NNmLdh3anQVMpzq3sqZitQB7FQV9NA0EjUWyUPBi', NULL, NULL, '2026-04-30 18:23:45', '2026-04-30 18:23:45', '2026-04-30 18:23:45'),
(254, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', NULL, NULL, 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', '3dc684472c9e164fd4f29c6e741d22df7431db320499cb14f47df8667700a609', 'wVkGNrYdBnSrRNo1Zzbx6JKFwv9Dr68tqjfbGD0K', NULL, NULL, '2026-04-30 18:23:45', '2026-04-30 18:23:45', '2026-04-30 18:23:45'),
(255, 'inventory', 'inventory.index', 'https://staging.myautotorque.com/inventory', 'GET', NULL, NULL, 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', '4c73bc9d1efe38df3f57be4b2ef43dda8472473b32439bd2de4097298e382cb0', 'N6VWuRKLlWlR3kesj1R0Qk97DL9zR2V8pT0D6ao0', NULL, NULL, '2026-04-30 18:23:46', '2026-04-30 18:23:46', '2026-04-30 18:23:46'),
(256, 'inventory/2023-lamborghini-urus-2', 'inventory.show', 'https://staging.myautotorque.com/inventory/2023-lamborghini-urus-2', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', 'fe3b469ea5b8c89cbe3109e1730ffdb4c2d333687d2991b634724037eedac296', 'TPj3yCinjlUi10hoXs0BAFwoBqOvcebAga9F1Ce1', 49, '2023-lamborghini-urus-2', '2026-04-30 18:23:49', '2026-04-30 18:23:49', '2026-04-30 18:23:49'),
(257, '/', 'home', 'https://staging.myautotorque.com', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/inventory/2023-lamborghini-urus-2', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', 'fe3b469ea5b8c89cbe3109e1730ffdb4c2d333687d2991b634724037eedac296', 'TPj3yCinjlUi10hoXs0BAFwoBqOvcebAga9F1Ce1', NULL, NULL, '2026-04-30 18:24:16', '2026-04-30 18:24:16', '2026-04-30 18:24:16'),
(258, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8e4be5bf4acb858b699fcdd81accc7aa92a98b8bd4f90bd120f2fa8cf381fd49', '2DgS8IxvGnJMNTKbtzO9DjlMa37lXCma9KHR5gbf', NULL, NULL, '2026-05-01 15:33:34', '2026-05-01 15:33:34', '2026-05-01 15:33:34'),
(259, 'media/storage/site-settings/logo-1fd139c4-b4b5-497e-84fd-8555744c63aa.png', 'media.storage.show', 'https://staging.myautotorque.com/media/storage/site-settings/logo-1fd139c4-b4b5-497e-84fd-8555744c63aa.png', 'GET', 'staging.myautotorque.com', 'https://staging.myautotorque.com/', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8e4be5bf4acb858b699fcdd81accc7aa92a98b8bd4f90bd120f2fa8cf381fd49', '2DgS8IxvGnJMNTKbtzO9DjlMa37lXCma9KHR5gbf', NULL, NULL, '2026-05-01 15:33:35', '2026-05-01 15:33:35', '2026-05-01 15:33:35'),
(260, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '8e4be5bf4acb858b699fcdd81accc7aa92a98b8bd4f90bd120f2fa8cf381fd49', 'wd6Qy8mCGJTJb9fOLF66B28U2QOVtBDO85GN3YRI', NULL, NULL, '2026-05-01 15:49:29', '2026-05-01 15:49:29', '2026-05-01 15:49:29'),
(261, '/', 'home', 'https://staging.myautotorque.com', 'GET', NULL, NULL, 'Mozilla/5.0 (X11; Linux x86_64; rv:142.0) Gecko/20100101 Firefox/142.0', '9763e1b6e0f2047b995aed9008e332b2e921ba55a5d497d2dfe8ed5e68a4a9c9', 'zh1PQ5cTwCLFkf2GOOwW5sGxM1VZeVQIIPDm4jAU', NULL, NULL, '2026-05-01 16:59:51', '2026-05-01 16:59:51', '2026-05-01 16:59:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `email_login_otp_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `preferred_currency` varchar(3) DEFAULT NULL,
  `currency_selection_prompt_dismissed` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `google_id`, `avatar`, `email_login_otp_enabled`, `preferred_currency`, `currency_selection_prompt_dismissed`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Demo Admin', 'admin@example.com', NULL, NULL, 0, NULL, 0, '2026-04-20 02:37:47', '$2y$12$BLe66cTv9eklAkhwlPgZyedtXpnvgomqPDjeQzFUBK1GsqzuNM5b.', 'SeYI3HtqJ7E80iWbgUgzW0bLQKaPmZwyCndiZ1qmiDRmjbvqLWP0tChotL98', '2026-04-20 02:37:47', '2026-04-21 15:24:49'),
(2, 'Demo User', 'demo@example.com', NULL, NULL, 0, NULL, 0, '2026-04-20 02:37:47', '$2y$10$pSP6FS1ZyY4rhex.nO85HePRoGFylbhNO6IsMw3UGDAIsgQmMogM2', '2BjTnBF1H7', '2026-04-20 02:37:47', '2026-04-20 02:37:47');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'draft',
  `year` int(10) UNSIGNED DEFAULT NULL,
  `make` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `price` int(10) UNSIGNED DEFAULT NULL,
  `msrp` int(10) UNSIGNED DEFAULT NULL,
  `finance_price` int(10) UNSIGNED DEFAULT NULL,
  `finance_interest_rate` decimal(5,2) DEFAULT NULL,
  `finance_term_months` smallint(5) UNSIGNED DEFAULT NULL,
  `finance_down_payment` int(10) UNSIGNED DEFAULT NULL,
  `show_financing_calculator` tinyint(1) NOT NULL DEFAULT 0,
  `mileage` int(10) UNSIGNED DEFAULT NULL,
  `transmission` varchar(255) DEFAULT NULL,
  `fuel_type` varchar(255) DEFAULT NULL,
  `drive` varchar(255) DEFAULT NULL,
  `body_type` varchar(255) DEFAULT NULL,
  `condition` varchar(20) DEFAULT NULL,
  `engine_size` varchar(64) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(64) DEFAULT NULL,
  `contact_address` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `map_location` varchar(255) DEFAULT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `exterior_color` varchar(255) DEFAULT NULL,
  `interior_color` varchar(255) DEFAULT NULL,
  `vin` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `overview` longtext DEFAULT NULL,
  `tech_specs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tech_specs`)),
  `is_special` tinyint(1) NOT NULL DEFAULT 0,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `city_mpg` smallint(5) UNSIGNED DEFAULT NULL,
  `hwy_mpg` smallint(5) UNSIGNED DEFAULT NULL,
  `engine_layout` varchar(255) DEFAULT NULL,
  `top_track_speed` varchar(255) DEFAULT NULL,
  `zero_to_sixty` varchar(255) DEFAULT NULL,
  `number_of_gears` varchar(255) DEFAULT NULL,
  `video_url` varchar(2048) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `user_id`, `title`, `slug`, `status`, `year`, `make`, `model`, `price`, `msrp`, `finance_price`, `finance_interest_rate`, `finance_term_months`, `finance_down_payment`, `show_financing_calculator`, `mileage`, `transmission`, `fuel_type`, `drive`, `body_type`, `condition`, `engine_size`, `location`, `contact_phone`, `contact_address`, `contact_email`, `map_location`, `features`, `exterior_color`, `interior_color`, `vin`, `description`, `overview`, `tech_specs`, `is_special`, `submitted_at`, `approved_at`, `approved_by`, `rejection_reason`, `created_at`, `updated_at`, `city_mpg`, `hwy_mpg`, `engine_layout`, `top_track_speed`, `zero_to_sixty`, `number_of_gears`, `video_url`) VALUES
(49, 1, '2023 Lamborghini Urus', '2023-lamborghini-urus-2', 'approved', 2023, 'Lamborghini', 'Urus', 29000, NULL, NULL, NULL, NULL, NULL, 0, 23433, 'Automatic', 'Petrol', 'AWD', 'SUV', 'new', '4.0L V8 twin-turbo', 'Los Angeles, CA', NULL, NULL, NULL, NULL, '[\"leathr seat\",\"wine glass\",\"sheets\"]', 'Giallo Auge', 'Nero Ade', '4224', 'Demo listing: Urus with aggressive styling, ANIMA drive modes, and daily usability. Includes six local media images.', NULL, NULL, 1, NULL, '2026-04-27 07:20:07', 1, NULL, '2026-04-27 07:17:42', '2026-04-27 07:20:07', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 1, 'Mercedes-Benz C-Class', 'mercedes-benz-c-class', 'approved', 2015, 'Mercedes-Benz', 'C-Class', 39600, NULL, NULL, NULL, NULL, NULL, 0, 100, 'Automatic', 'Hybrid', '4WD', 'Sedan', 'new', NULL, NULL, NULL, NULL, NULL, NULL, '[\"ABS\",\"Auxiliary heating\",\"Bluetooth\",\"CD player\",\"Central locking\",\"ESP\",\"Full LED headlights\",\"LED dynamic taillights\",\"Nitro\",\"Storage package\",\"Tire pressure monitoring system\",\"Turbo-engine\"]', 'Pearl White', 'Jet Red', 'WDDGJ5HB1CF', 'Quisque imperdiet dignissim enim dictum finibus. Sed consectetutr convallis enim eget laoreet. Aenean vitae nisl mollis, porta risus vel, dapibus lectus. Etiam ac suscipit eros, eget maximus\r\nEtiam sit amet ex pharetra, venenatis ante vehicula, gravida sapien. Fusce eleifend vulputate nibh, non cursus augue placerat pellentesque. Sed venenatis risus nec felis mollis, in pharetra urna euismod. Morbi aliquam ut turpis sit amet ultrices. Vestibulum mattis blandit nisl, et tristique elit scelerisque nec. Fusce eleifend laoreet dui eget aliquet. Ut rutrum risus et nunc pretium scelerisque. Fusce viverra, ligula quis pellentesque interdum, leo felis congue dui, ac accumsan sem nulla id lorem. Praesent ut tristique dui, nec condimentum lacus. Maecenas lobortis ante id egestas placerat. Nullam at ultricies lacus. Nam in nulla consectetur, suscipit mauris eu, fringilla augue. Phasellus gravida, dui quis dignissim tempus, tortor orci tristique leo, ut congue diam ipsum at massa. Pellentesque ut vestibulum erat. Donec a felis eget', 'Quisque imperdiet dignissim enim dictum finibus. Sed consectetutr convallis enim eget laoreet. Aenean vitae nisl mollis, porta risus vel, dapibus lectus. Etiam ac suscipit eros, eget maximus', '{\"drive_type\":\"4WD\"}', 0, NULL, '2026-04-29 04:26:55', 1, NULL, '2026-04-29 04:26:55', '2026-04-29 16:38:21', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_favorites`
--

CREATE TABLE `vehicle_favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_images`
--

CREATE TABLE `vehicle_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `path` text NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_images`
--

INSERT INTO `vehicle_images` (`id`, `vehicle_id`, `path`, `sort_order`, `created_at`, `updated_at`) VALUES
(294, 49, 'asset/images/media/01-18-798x466-1777259853.jpeg', 1, '2026-04-27 07:17:42', '2026-04-27 07:17:42'),
(295, 49, 'asset/images/media/03-18-798x466-1777260084.jpeg', 2, '2026-04-27 07:21:53', '2026-04-27 07:21:53'),
(296, 49, 'asset/images/media/02-18-798x466-1777260103.jpeg', 3, '2026-04-27 07:21:53', '2026-04-27 07:21:53'),
(301, 50, 'asset/images/media/motor-1-795x463-1-768x447-uFcGeM-1777469240.jpg', 1, '2026-04-29 18:49:53', '2026-04-29 18:49:53'),
(302, 50, 'asset/images/media/7-1109x699-1-798x466-95m24X-1777469607.jpg', 2, '2026-04-29 18:49:53', '2026-04-29 18:49:53'),
(303, 50, 'asset/images/media/5-1109x699-1-798x466-EuMR4C-1777469607.jpg', 3, '2026-04-29 18:49:53', '2026-04-29 18:49:53'),
(304, 50, 'asset/images/media/motor-1-795x463-1-768x447-uFcGeM-1777469240.jpg', 4, '2026-04-29 18:49:53', '2026-04-29 18:49:53');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_inquiries`
--

CREATE TABLE `vehicle_inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sender_name` varchar(255) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_profiles`
--

CREATE TABLE `vendor_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `public_email` varchar(255) DEFAULT NULL,
  `public_phone` varchar(64) DEFAULT NULL,
  `public_address` varchar(500) DEFAULT NULL,
  `map_location` varchar(500) DEFAULT NULL,
  `show_on_listings` tinyint(1) NOT NULL DEFAULT 1,
  `whatsapp` varchar(64) DEFAULT NULL,
  `website` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_audit_trails`
--
ALTER TABLE `admin_audit_trails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_audit_trails_created_at_index` (`created_at`),
  ADD KEY `admin_audit_trails_route_name_index` (`route_name`),
  ADD KEY `admin_audit_trails_method_index` (`method`),
  ADD KEY `admin_audit_trails_user_id_index` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `cms_pages`
--
ALTER TABLE `cms_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cms_pages_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_created_at_index` (`created_at`),
  ADD KEY `media_uploaded_by_foreign` (`uploaded_by`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `page_sections`
--
ALTER TABLE `page_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_sections_page_section_key_unique` (`page`,`section_key`),
  ADD KEY `page_sections_page_index` (`page`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `site_settings_key_unique` (`key`);

--
-- Indexes for table `site_traffic_events`
--
ALTER TABLE `site_traffic_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `site_traffic_events_viewed_at_path_index` (`viewed_at`,`path`(191)),
  ADD KEY `site_traffic_events_viewed_at_route_name_index` (`viewed_at`,`route_name`),
  ADD KEY `site_traffic_events_viewed_at_vehicle_id_index` (`viewed_at`,`vehicle_id`),
  ADD KEY `site_traffic_events_viewed_at_session_id_index` (`viewed_at`,`session_id`),
  ADD KEY `site_traffic_events_vehicle_id_foreign` (`vehicle_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_google_id_unique` (`google_id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicles_slug_unique` (`slug`),
  ADD KEY `vehicles_status_created_at_index` (`status`,`created_at`),
  ADD KEY `vehicles_condition_index` (`condition`),
  ADD KEY `vehicles_location_index` (`location`),
  ADD KEY `vehicles_user_id_foreign` (`user_id`),
  ADD KEY `vehicles_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `vehicle_favorites`
--
ALTER TABLE `vehicle_favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicle_favorites_user_id_vehicle_id_unique` (`user_id`,`vehicle_id`),
  ADD KEY `vehicle_favorites_vehicle_id_foreign` (`vehicle_id`);

--
-- Indexes for table `vehicle_images`
--
ALTER TABLE `vehicle_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_images_vehicle_id_sort_order_index` (`vehicle_id`,`sort_order`);

--
-- Indexes for table `vehicle_inquiries`
--
ALTER TABLE `vehicle_inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_inquiries_vehicle_id_created_at_index` (`vehicle_id`,`created_at`),
  ADD KEY `vehicle_inquiries_user_id_foreign` (`user_id`);

--
-- Indexes for table `vendor_profiles`
--
ALTER TABLE `vendor_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vendor_profiles_user_id_unique` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_audit_trails`
--
ALTER TABLE `admin_audit_trails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `cms_pages`
--
ALTER TABLE `cms_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `page_sections`
--
ALTER TABLE `page_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `site_traffic_events`
--
ALTER TABLE `site_traffic_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=262;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `vehicle_favorites`
--
ALTER TABLE `vehicle_favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle_images`
--
ALTER TABLE `vehicle_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=305;

--
-- AUTO_INCREMENT for table `vehicle_inquiries`
--
ALTER TABLE `vehicle_inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor_profiles`
--
ALTER TABLE `vendor_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_audit_trails`
--
ALTER TABLE `admin_audit_trails`
  ADD CONSTRAINT `admin_audit_trails_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_uploaded_by_foreign` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `site_traffic_events`
--
ALTER TABLE `site_traffic_events`
  ADD CONSTRAINT `site_traffic_events_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `vehicles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicle_favorites`
--
ALTER TABLE `vehicle_favorites`
  ADD CONSTRAINT `vehicle_favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehicle_favorites_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicle_images`
--
ALTER TABLE `vehicle_images`
  ADD CONSTRAINT `vehicle_images_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicle_inquiries`
--
ALTER TABLE `vehicle_inquiries`
  ADD CONSTRAINT `vehicle_inquiries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `vehicle_inquiries_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
