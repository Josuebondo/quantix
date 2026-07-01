CREATE DATABASE quantix_db;
USE quantix_db;
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2026 at 10:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quantix_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `company_id`, `name`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Boissons', 'Produits boissons', '2026-05-16 10:46:11', '2026-05-16 10:46:11', NULL),
(2, 1, 'Alimentaire', 'Produits alimentaires', '2026-05-16 10:46:11', '2026-05-16 10:46:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `plan_id` bigint unsigned NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_general_ci,
  `status` tinyint DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `setup_completed_at` timestamp NULL DEFAULT NULL COMMENT 'Quand le wizard est terminé',
  `wizard_session_id` varchar(36) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'UUID de la session wizard',
  `setup_step` int DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `fk_companies_plan` (`plan_id`),
  CONSTRAINT `fk_companies_plan` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `plan_id`, `name`, `slug`, `email`, `phone`, `address`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'Quantix Demo Store', 'quantix-demo-store', 'demo@quantix.app', '+243900000001', 'Kinshasa, RDC', 1, '2026-05-16 10:46:11', '2026-05-16 10:46:11', NULL),
(4, 1, 'Wade and Kirby Co', 'wade-and-kirby-co', 'felipe@mailinator.com', '+1 (263) 838-9517', NULL, 0, '2026-05-16 11:19:28', '2026-05-16 11:19:28', NULL),
(5, 1, 'Gomez and Barrera Trading', 'gomez-and-barrera-trading', 'vumyza@mailinator.com', '+1 (698) 893-1673', NULL, 0, '2026-05-16 11:20:37', '2026-05-16 11:20:37', NULL),
(6, 1, 'Osborne Workman Co', 'osborne-workman-co', 'wuduryj@mailinator.com', '+1 (123) 994-1178', NULL, 0, '2026-05-16 11:23:29', '2026-05-16 11:23:29', NULL),
(7, 1, 'Osborne and Haley Inc', 'osborne-and-haley-inc', 'xanobi@mailinator.com', '+1 (675) 958-5639', NULL, 0, '2026-05-16 11:31:46', '2026-05-16 11:31:46', NULL),
(8, 1, 'Morrison and Knox Co', 'morrison-and-knox-co', 'rywupy@mailinator.com', '+1 (476) 109-1601', NULL, 0, '2026-05-16 11:38:25', '2026-05-16 11:38:25', NULL),
(9, 1, 'Nunez Skinner LLC', 'nunez-skinner-llc', 'mofu@mailinator.com', '+1 (387) 464-8435', NULL, 0, '2026-05-16 11:43:41', '2026-05-16 11:43:41', NULL),
(10, 1, 'Ortega and Jimenez Trading', 'ortega-and-jimenez-trading', 'qewikogotu@mailinator.com', '+1 (627) 689-6307', NULL, 0, '2026-05-16 11:45:20', '2026-05-16 11:45:20', NULL),
(11, 1, 'Avery Gilbert Co', 'avery-gilbert-co', 'tadukic@mailinator.com', '+1 (989) 422-2318', NULL, 0, '2026-05-16 11:49:51', '2026-05-16 11:49:51', NULL),
(12, 1, 'Brennan Mccormick Plc', 'brennan-mccormick-plc', 'hylomadil@mailinator.com', '+1 (847) 454-8875', NULL, 0, '2026-05-16 11:53:35', '2026-05-16 11:53:35', NULL),
(13, 1, 'Sears Fowler Trading', 'sears-fowler-trading', 'vehibo@mailinator.com', '+1 (769) 365-8752', NULL, 0, '2026-05-16 12:06:09', '2026-05-16 12:06:09', NULL),
(14, 1, 'Austin Pickett Traders', 'austin-pickett-traders', 'bapu@mailinator.com', '+1 (503) 384-9741', NULL, 0, '2026-05-16 12:06:39', '2026-05-16 12:06:39', NULL),
(15, 1, 'Moody and Ward Co', 'moody-and-ward-co', 'varez@mailinator.com', '+1 (797) 971-9242', NULL, 0, '2026-05-16 12:16:06', '2026-05-16 12:16:06', NULL),
(16, 1, 'Mathis Hebert Inc', 'mathis-hebert-inc', 'xuqekedina@mailinator.com', '+1 (667) 416-6391', NULL, 0, '2026-05-16 12:17:40', '2026-05-16 12:17:40', NULL),
(17, 1, 'Witt Carney Associates', 'witt-carney-associates', 'zukywykuzy@mailinator.com', '+1 (816) 874-4894', NULL, 0, '2026-05-16 12:26:59', '2026-05-16 12:26:59', NULL),
(18, 1, 'Campos Vazquez Traders', 'campos-vazquez-traders', 'wabu@mailinator.com', '+1 (771) 596-9414', NULL, 0, '2026-05-16 12:27:57', '2026-05-16 12:27:57', NULL),
(19, 1, 'Bennett Norris LLC', 'bennett-norris-llc', 'kasole@mailinator.com', '+1 (138) 894-7281', NULL, 0, '2026-05-16 12:32:27', '2026-05-16 12:32:27', NULL),
(20, 1, 'Vance Payne Plc', 'vance-payne-plc', 'cebubypo@mailinator.com', '+1 (588) 357-6127', NULL, 0, '2026-05-16 12:34:52', '2026-05-16 12:34:52', NULL),
(21, 1, 'Booker and Snider Trading', 'booker-and-snider-trading', 'hanuvijun@mailinator.com', '+1 (163) 276-2799', NULL, 0, '2026-05-16 12:39:30', '2026-05-16 12:39:30', NULL),
(22, 1, 'Cantu and Patton Plc', 'cantu-and-patton-plc', 'xaxacaca@mailinator.com', '+1 (682) 636-6796', NULL, 0, '2026-05-16 13:13:20', '2026-05-16 13:13:20', NULL),
(23, 1, 'Snow Sawyer Trading', 'snow-sawyer-trading', 'bogugoho@mailinator.com', '+1 (213) 798-4365', NULL, 0, '2026-05-16 13:15:02', '2026-05-16 13:15:02', NULL),
(24, 1, 'Clemons Key Associates', 'clemons-key-associates', 'mucus@mailinator.com', '+1 (341) 415-6059', NULL, 0, '2026-05-16 13:50:08', '2026-05-16 13:50:08', NULL),
(25, 1, 'Gordon Justice Co', 'gordon-justice-co', 'hilaqu@mailinator.com', '+1 (435) 733-1589', NULL, 0, '2026-05-16 13:55:02', '2026-05-16 13:55:02', NULL),
(26, 1, 'Mcgowan and Riggs Co', 'mcgowan-and-riggs-co', 'suxa@mailinator.com', '+1 (573) 857-5036', NULL, 0, '2026-05-16 13:57:43', '2026-05-16 13:57:43', NULL),
(27, 1, 'Mcgowan Willis Trading', 'mcgowan-willis-trading', 'somuk@mailinator.com', '+1 (856) 279-9764', NULL, 0, '2026-05-16 14:04:27', '2026-05-16 14:04:27', NULL),
(28, 1, 'Mejia Collier Trading', 'mejia-collier-trading', 'pugyrywubo@mailinator.com', '+1 (448) 726-9758', NULL, 0, '2026-05-16 14:16:48', '2026-05-16 14:16:48', NULL),
(29, 1, 'Gardner Orr Inc', 'gardner-orr-inc', 'gicupuvu@mailinator.com', '+1 (888) 275-1282', NULL, 0, '2026-05-16 14:18:59', '2026-05-16 14:18:59', NULL),
(30, 1, 'Thompson Baldwin LLC', 'thompson-baldwin-llc', 'qomote@mailinator.com', '+1 (737) 403-5809', NULL, 0, '2026-05-16 14:21:08', '2026-05-16 14:21:08', NULL),
(31, 1, 'Cobb and Glover Traders', 'cobb-and-glover-traders', 'pajud@mailinator.com', '+1 (946) 513-4091', NULL, 0, '2026-05-16 14:24:30', '2026-05-16 14:24:30', NULL),
(32, 1, 'Benson Rasmussen LLC', 'benson-rasmussen-llc', 'jyxyziqyg@mailinator.com', '+1 (987) 545-8587', NULL, 0, '2026-05-16 14:25:54', '2026-05-16 14:25:54', NULL),
(33, 1, 'Romero Odom Associates', 'romero-odom-associates', 'qucukuko@mailinator.com', '+1 (244) 508-6639', NULL, 0, '2026-05-16 14:27:45', '2026-05-16 14:27:45', NULL),
(34, 1, 'Bennett Bates Co', 'bennett-bates-co', 'ditom@mailinator.com', '+1 (883) 446-2205', NULL, 0, '2026-05-16 14:30:25', '2026-05-16 14:30:25', NULL),
(35, 1, 'Gross Le Associates', 'gross-le-associates', 'josue@quantix.com', '+1 (757) 615-9449', NULL, 0, '2026-05-16 14:41:00', '2026-05-16 14:41:00', NULL),
(36, 1, 'Blanchard and Ayers Traders', 'blanchard-and-ayers-traders', 'wuvy@mailinator.com', '+1 (222) 738-6554', NULL, 0, '2026-05-16 14:42:12', '2026-05-16 14:42:12', NULL),
(37, 1, 'Decker Anderson Associates', 'decker-anderson-associates', 'culelol@mailinator.com', '+1 (195) 379-7146', NULL, 0, '2026-05-16 14:43:00', '2026-05-16 14:43:00', NULL),
(38, 1, 'Blair and Ramirez Inc', 'blair-and-ramirez-inc', 'pyripo@mailinator.com', '+1 (291) 951-9164', NULL, 0, '2026-05-16 14:44:04', '2026-05-16 14:44:04', NULL),
(39, 1, 'Shepard Fitzgerald Co', 'shepard-fitzgerald-co', 'xatire@mailinator.com', '+1 (843) 818-7172', NULL, 0, '2026-05-16 14:44:55', '2026-05-16 14:44:55', NULL),
(40, 1, 'Dorsey Crane Trading', 'dorsey-crane-trading', 'cuva@mailinator.com', '+1 (711) 952-6118', NULL, 0, '2026-05-16 14:47:38', '2026-05-16 14:47:38', NULL),
(41, 1, 'Horton and Moon Trading', 'horton-and-moon-trading', 'piza@mailinator.com', '+1 (611) 138-1359', NULL, 0, '2026-05-16 14:52:02', '2026-05-16 14:52:02', NULL),
(42, 1, 'Jacobson and Melton Plc', 'jacobson-and-melton-plc', 'fokolomasu@mailinator.com', '+1 (651) 929-5605', NULL, 0, '2026-05-16 15:57:06', '2026-05-16 15:57:06', NULL),
(43, 1, 'Parrish and Nash Inc', 'parrish-and-nash-inc', 'bemufuziqa@mailinator.com', '+1 (545) 123-9893', NULL, 0, '2026-05-16 16:01:32', '2026-05-16 16:01:32', NULL),
(44, 1, 'Greer and Blackwell Plc', 'greer-and-blackwell-plc', 'gahyj@mailinator.com', '+1 (476) 872-4978', NULL, 0, '2026-05-16 16:08:06', '2026-05-16 16:08:06', NULL),
(45, 1, 'Bond and Miranda Plc', 'bond-and-miranda-plc', 'bosysuxeni@mailinator.com', '+1 (504) 475-1525', NULL, 0, '2026-05-16 16:09:02', '2026-05-16 16:09:02', NULL),
(46, 1, 'quan sy clls ', 'quan-sy-clls-', 'support.quantix@gmail.com', '278399794763', NULL, 0, '2026-05-16 16:18:39', '2026-05-16 16:18:39', NULL),
(47, 1, 'Cooke and Bates LLC', 'cooke-and-bates-llc', 'wimasytim@mailinator.com', '+1 (143) 101-8252', NULL, 0, '2026-05-16 17:28:22', '2026-05-16 17:28:22', NULL),
(48, 1, 'Hendrix and Wilkins Co', 'hendrix-and-wilkins-co', 'xinoqyfy@mailinator.com', '+1 (704) 156-9371', NULL, 0, '2026-05-16 17:39:24', '2026-05-16 17:39:24', NULL),
(49, 1, 'Reid Garrison Co', 'reid-garrison-co', 'hyvufa@mailinator.com', '+1 (775) 191-9274', NULL, 0, '2026-05-16 17:41:19', '2026-05-16 17:41:19', NULL),
(50, 1, 'Houston and Mayo Co', 'houston-and-mayo-co', 'xuwab@mailinator.com', '+1 (764) 885-7448', NULL, 0, '2026-05-16 17:52:14', '2026-05-16 17:52:14', NULL),
(51, 1, 'Oconnor Ashley Co', 'oconnor-ashley-co', 'noxiv@mailinator.com', '+1 (662) 869-7901', NULL, 0, '2026-05-16 18:07:04', '2026-05-16 18:07:04', NULL),
(52, 1, 'Riggs and Henry Traders', 'riggs-and-henry-traders', 'cojojify@mailinator.com', '+1 (752) 809-1257', NULL, 0, '2026-05-16 18:23:36', '2026-05-16 18:23:36', NULL),
(53, 1, 'Walters and Navarro Plc', 'walters-and-navarro-plc', 'laco@mailinator.com', '+1 (632) 756-1352', NULL, 0, '2026-05-16 18:32:55', '2026-05-16 18:32:55', NULL),
(54, 1, 'Leblanc and Henry Associates', 'leblanc-and-henry-associates', 'ganiq@mailinator.com', '+1 (891) 244-7715', NULL, 0, '2026-05-16 18:34:57', '2026-05-16 18:34:57', NULL),
(55, 1, 'quan sy clls ', 'quan-sy-clls--1', 'support.quantix@gmail.com', '278399794763', NULL, 0, '2026-05-16 22:34:25', '2026-05-16 22:34:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_settings`
--

CREATE TABLE `company_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `currency` varchar(10) COLLATE utf8mb4_general_ci DEFAULT 'USD',
  `timezone` varchar(100) COLLATE utf8mb4_general_ci DEFAULT 'Africa/Kinshasa',
  `language` varchar(10) COLLATE utf8mb4_general_ci DEFAULT 'fr',
  `stock_alert_enabled` tinyint(1) DEFAULT '1',
  `low_stock_threshold` int DEFAULT '5',
  `stock_calculation_method` enum('fifo','lifo','average') COLLATE utf8mb4_general_ci DEFAULT 'average',
  `invoice_prefix` varchar(20) COLLATE utf8mb4_general_ci DEFAULT 'FAC',
  `invoice_start_number` int DEFAULT '1',
  `tax_enabled` tinyint(1) DEFAULT '0',
  `tax_percentage` decimal(5,2) DEFAULT '0.00',
  `date_format` varchar(20) COLLATE utf8mb4_general_ci DEFAULT 'd/m/Y',
  `dark_mode` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_id` (`company_id`),
  CONSTRAINT `fk_company_settings_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subscription_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `reference` varchar(150) DEFAULT NULL,
  `method` enum('mpesa','airtel_money','orange_money','card','cash') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) DEFAULT 'USD',
  `status` enum('pending','successful','failed','refunded') DEFAULT 'pending',
  `transaction_id` varchar(255) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--<

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `module` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `code`, `module`, `created_at`) VALUES
(1, 'Create Product', 'product.create', 'products', '2026-05-16 10:46:11'),
(2, 'Update Product', 'product.update', 'products', '2026-05-16 10:46:11'),
(3, 'Delete Product', 'product.delete', 'products', '2026-05-16 10:46:11'),
(4, 'View Stock', 'stock.view', 'stocks', '2026-05-16 10:46:11'),
(5, 'Adjust Stock', 'stock.adjust', 'stocks', '2026-05-16 10:46:11'),
(6, 'Create Sale', 'sale.create', 'sales', '2026-05-16 10:46:11'),
(7, 'Manage Users', 'user.manage', 'users', '2026-05-16 10:46:11'),
(8, 'Manage Roles', 'role.manage', 'roles', '2026-05-16 10:46:11');


-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `warehouses_limit` int(11) DEFAULT 1,
  `users_limit` int(11) DEFAULT 1,
  `products_limit` int(11) DEFAULT 100,
  `price` decimal(10,2) DEFAULT 0.00,
  `billing_cycle` enum('monthly','yearly','lifetime') DEFAULT 'monthly',
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `is_free` tinyint(1) DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `name`, `description`, `slug`, `warehouses_limit`, `users_limit`, `products_limit`, `price`, `billing_cycle`, `features`, `is_free`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Free', 'Parfait pour commencer avec une petite entreprise.', 'free', 1, 2, 100, 0.00, 'monthly', '{\r\n  \"users_limit\": 2,\r\n  \"warehouses_limit\": 1,\r\n  \"products_limit\": 100,\r\n\r\n  \"reports\": false,\r\n  \"barcode\": false,\r\n  \"exports\": false,\r\n  \"api_access\": false,\r\n  \"multi_warehouse\": false,\r\n  \"priority_support\": false,\r\n  \"custom_roles\": false,\r\n  \"inventory_history\": true,\r\n  \"stock_alerts\": true,\r\n  \"dashboard_analytics\": false,\r\n  \"multi_currency\": false,\r\n  \"invoice_management\": true,\r\n  \"purchase_management\": true,\r\n  \"sales_management\": true\r\n}', 1, 1, '2026-05-16 10:46:11', '2026-05-17 09:32:20'),
(2, 'Pro', 'Idéal pour les entreprises en croissance avec plusieurs utilisateurs.', 'pro', 5, 10, 5000, 49.99, 'monthly', '{\r\n  \"users_limit\": 10,\r\n  \"warehouses_limit\": 5,\r\n  \"products_limit\": 5000,\r\n\r\n  \"reports\": true,\r\n  \"barcode\": true,\r\n  \"exports\": true,\r\n  \"api_access\": false,\r\n  \"multi_warehouse\": true,\r\n  \"priority_support\": false,\r\n  \"custom_roles\": true,\r\n  \"inventory_history\": true,\r\n  \"stock_alerts\": true,\r\n  \"dashboard_analytics\": true,\r\n  \"multi_currency\": true,\r\n  \"invoice_management\": true,\r\n  \"purchase_management\": true,\r\n  \"sales_management\": true\r\n}', 0, 1, '2026-05-16 10:46:11', '2026-05-17 09:32:20'),
(3, 'Business', 'Solution complète pour les grandes entreprises avec besoins avancés.', 'business', 20, 50, 50000, 199.99, 'monthly', '{\r\n  \"users_limit\": 50,\r\n  \"warehouses_limit\": 20,\r\n  \"products_limit\": 50000,\r\n\r\n  \"reports\": true,\r\n  \"barcode\": true,\r\n  \"exports\": true,\r\n  \"api_access\": true,\r\n  \"multi_warehouse\": true,\r\n  \"priority_support\": true,\r\n  \"custom_roles\": true,\r\n  \"inventory_history\": true,\r\n  \"stock_alerts\": true,\r\n  \"dashboard_analytics\": true,\r\n  \"multi_currency\": true,\r\n  \"invoice_management\": true,\r\n  \"purchase_management\": true,\r\n  \"sales_management\": true\r\n}', 0, 1, '2026-05-16 10:46:11', '2026-05-17 09:32:20');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `sku` varchar(100) NOT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `cost_price` decimal(12,2) DEFAULT 0.00,
  `selling_price` decimal(12,2) DEFAULT 0.00,
  `quantity_alert` decimal(12,2) DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `company_id`, `category_id`, `name`, `sku`, `barcode`, `cost_price`, `selling_price`, `quantity_alert`, `image`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'Coca Cola 50cl', 'COCA-50', '100000001', 0.50, 1.00, 10.00, NULL, 1, '2026-05-16 10:46:11', '2026-05-16 10:46:11', NULL),
(2, 1, 1, 'Fanta Orange', 'FANTA-50', '100000002', 0.45, 0.95, 10.00, NULL, 1, '2026-05-16 10:46:11', '2026-05-16 10:46:11', NULL),
(3, 1, 2, 'Riz 25kg', 'RIZ-25', '100000003', 18.00, 25.00, 5.00, NULL, 1, '2026-05-16 10:46:11', '2026-05-16 10:46:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `company_id`, `name`, `code`, `description`, `created_at`, `deleted_at`) VALUES
(1, 0, 'Super Admin', 'super_admin', 'Accès complet', '2026-05-16 10:46:11', NULL),
(2, 1, 'Owner', 'manager', 'Gestion stock et ventes', '2026-05-16 10:46:11', NULL),
(3, 1, 'Cashier', 'cashier', 'Gestion ventes seulement', '2026-05-16 10:46:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(2, 1),
(2, 2),
(2, 4),
(2, 5),
(2, 6),
(3, 4),
(3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(12,2) DEFAULT 0.00,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `warehouse_id`, `product_id`, `quantity`, `updated_at`) VALUES
(1, 1, 1, 120.00, '2026-05-16 10:46:11'),
(2, 1, 2, 80.00, '2026-05-16 10:46:11'),
(3, 1, 3, 25.00, '2026-05-16 10:46:11'),
(4, 2, 1, 40.00, '2026-05-16 10:46:11'),
(5, 2, 2, 20.00, '2026-05-16 10:46:11');

-- --------------------------------------------------------

--
-- Table structure for table `stock_movements`
--

CREATE TABLE `stock_movements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('purchase','sale','adjustment','transfer_in','transfer_out','loss') NOT NULL,
  `quantity` decimal(12,2) NOT NULL,
  `unit_price` decimal(12,2) DEFAULT 0.00,
  `total_price` decimal(12,2) DEFAULT 0.00,
  `contact_name` varchar(150) DEFAULT NULL,
  `reference` varchar(150) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_movements`
--

INSERT INTO `stock_movements` (`id`, `company_id`, `warehouse_id`, `product_id`, `user_id`, `type`, `quantity`, `unit_price`, `total_price`, `contact_name`, `reference`, `note`, `created_at`) VALUES
(1, 1, 1, 1, 1, 'purchase', 120.00, 0.50, 60.00, 'Congo Distribution', 'PUR-0001', 'Stock initial Coca', '2026-05-16 10:46:11'),
(2, 1, 1, 2, 1, 'purchase', 80.00, 0.45, 36.00, 'Congo Distribution', 'PUR-0002', 'Stock initial Fanta', '2026-05-16 10:46:11'),
(3, 1, 1, 3, 1, 'purchase', 25.00, 18.00, 450.00, 'Food Market RDC', 'PUR-0003', 'Stock initial Riz', '2026-05-16 10:46:11');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `plan_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','trial','active','expired','cancelled') DEFAULT 'pending',
  `starts_at` datetime DEFAULT NULL,
  `ends_at` datetime DEFAULT NULL,
  `trial_ends_at` datetime DEFAULT NULL,
  `cancelled_at` datetime DEFAULT NULL,
  `auto_renew` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `first_name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint DEFAULT '1',
  `wizard_session_id` varchar(36) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'UUID de la session wizard en cours',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `activation_status` enum('pending','activated') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `activated_at` timestamp NULL DEFAULT NULL,
  `is_activated` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_users_company_email` (`company_id`,`email`),
  CONSTRAINT `fk_users_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `company_id`, `first_name`, `last_name`, `email`, `password`, `status`, `last_login_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Admin Quantix', NULL, 'admin@demo.com', '$2y$12$9DvWuQSyli0nVEywoI20.O0LIPmbAHueCEq3TEUtR6bFSHVr8Qs3W', 1, NULL, '2026-05-16 10:46:11', '2026-05-16 10:48:34', NULL),
(2, 12, 'Melanie', 'Mathews', 'jimyvegivu@mailinator.com', '$2y$12$sXRmmGwASEikzL14IkmlcOrFNVlU0w.1hz2Mvk.ruV1quND7uZVku', 1, NULL, '2026-05-16 11:53:36', '2026-05-16 11:53:36', NULL),
(3, 15, 'Nicole', 'Abbott', 'wujoqim@mailinator.com', '$2y$12$qVdKp9SNLwRskaXePyHT2uWI2DsQhTF4XQFcKOlCfeLRVIHkvSp4a', 1, NULL, '2026-05-16 12:16:07', '2026-05-16 12:16:07', NULL),
(4, 16, 'Keane', 'Tanner', 'mocewil@mailinator.com', '$2y$12$NmEvM.1S8S66EHqcHQmb0eTW5c/BrE91cmHxuBY0qHhnoiB/H6LDu', 1, NULL, '2026-05-16 12:17:41', '2026-05-16 12:17:41', NULL),
(5, 17, 'Gretchen', 'Roman', 'fida@mailinator.com', '$2y$12$8RBMrFJVG5MbgbODhLfnte6T9NRth081mzANl2FiY1co8IqF.aAae', 1, NULL, '2026-05-16 12:27:00', '2026-05-16 12:27:00', NULL),
(6, 18, 'Kelsey', 'Saunders', 'wezow@mailinator.com', '$2y$12$nO9MtWT2gNgU2wxL408uDuitPjEM9Gc58x6ZAgLSBnen4boAnAMfO', 1, NULL, '2026-05-16 12:27:58', '2026-05-16 12:27:58', NULL),
(7, 19, 'Brittany', 'Bray', 'ceqipo@mailinator.com', '$2y$12$jNq2qKoQiwmy9I55kTrBvekw7SC5d20t.yjzOjQs/LqVKK4D2dW3.', 1, NULL, '2026-05-16 12:32:28', '2026-05-16 12:32:28', NULL),
(8, 20, 'Kyla', 'Rowe', 'fidulelu@mailinator.com', '$2y$12$mV8ioh/FF3cyUST6HySS7O/SXeRO0G5zu1oete2ahzLsre6Q2NLCO', 1, NULL, '2026-05-16 12:34:52', '2026-05-16 12:34:52', NULL),
(9, 21, 'Colin', 'Carr', 'byvekyxut@mailinator.com', '$2y$12$/sQVVxgOvkkqWCEM9WGdC.iqc6J2CsacUUdrxaTGh9ILbJ8lah5.O', 1, NULL, '2026-05-16 12:39:30', '2026-05-16 12:39:30', NULL),
(10, 22, 'Cherokee', 'Rice', 'jovuf@mailinator.com', '$2y$12$nNQU3MaG.yQrzS0JPb15r.e4qaKkjtOQwVCG7pBPT5RhGSqG2/SuG', 1, NULL, '2026-05-16 13:13:21', '2026-05-16 13:13:21', NULL),
(11, 23, 'Ashton', 'Mathews', 'naju@mailinator.com', '$2y$12$hwi.PJFljAtnPSOhMW1UNeVtr3NikgUFAlBHkbh1W5OU2tGtbRENO', 1, NULL, '2026-05-16 13:15:03', '2026-05-16 13:15:03', NULL),
(12, 24, 'Tashya', 'Richmond', 'lasohy@mailinator.com', '$2y$12$UVrkySS2gyEn0JN7nFQgx..WqjNBVad9fPRSTdAfsCE/yrt0M./Se', 1, NULL, '2026-05-16 13:50:08', '2026-05-16 13:50:08', NULL),
(13, 25, 'Ainsley', 'Buchanan', 'gahu@mailinator.com', '$2y$12$FzNXdvE4G3.1jnee4WUG.uTz6XZzCBCdfRDqS.mjHSCRXk3XAfGBO', 1, NULL, '2026-05-16 13:55:02', '2026-05-16 13:55:02', NULL),
(14, 26, 'Nomlanga', 'Odonnell', 'dydocawig@mailinator.com', '$2y$12$JToAtczcSj94sGB9IObvO.2XH0Z5zov2QrPeC8SpEk8a8ANRGE4gC', 1, NULL, '2026-05-16 13:57:44', '2026-05-16 13:57:44', NULL),
(15, 27, 'Melvin', 'Carey', 'gejylejep@mailinator.com', '$2y$12$JCHb6kXy3VVq1rWqIES6OuBy0MUP6sLr.DeSzElsTFKzKUPGt3P8u', 1, NULL, '2026-05-16 14:04:27', '2026-05-16 14:04:27', NULL),
(16, 28, 'Nevada', 'Stevenson', 'pazak@mailinator.com', '$2y$12$b.LZy.xLh44XPJNGI9qqPOcQquAtC0tIWL/FFt1ojPqEsNsD9gdGy', 1, NULL, '2026-05-16 14:16:48', '2026-05-16 14:16:48', NULL),
(17, 29, 'Dahlia', 'Fernandez', 'jimymol@mailinator.com', '$2y$12$dU7fkMwvD2D/j7WwUEdl.eHIsXAIQK6ya2LC2ehRCSt/oT.DpYUo2', 1, NULL, '2026-05-16 14:18:59', '2026-05-16 14:18:59', NULL),
(18, 30, 'Stone', 'Anthony', 'hyterupa@mailinator.com', '$2y$12$j5G.IRpz2a3NDsBxHiOauu35.Z3kTBISndQtps4kBVuzdI6S5bkqq', 1, NULL, '2026-05-16 14:21:09', '2026-05-16 14:21:09', NULL),
(19, 31, 'Mark', 'Floyd', 'tumivo@mailinator.com', '$2y$12$dfCIbgWKGJ7RXcMszSomKe5ssQKinx1BD8mVBFblk9xWvpGtrqEqm', 1, NULL, '2026-05-16 14:24:30', '2026-05-16 14:24:30', NULL),
(20, 32, 'Sharon', 'Torres', 'tywuxihe@mailinator.com', '$2y$12$MLuyu9AyVOjR3DfSVLVaF.ypRp42IbtWL1YGy5QVplMgzJ4oOx6sq', 1, NULL, '2026-05-16 14:25:55', '2026-05-16 14:25:55', NULL),
(21, 33, 'Priscilla', 'Spears', 'naxapug@mailinator.com', '$2y$12$cW65lfmqjEfOtp9PDkJyM.zakHlT2Vu4/kNFAClJK83.npf.IBmxu', 1, NULL, '2026-05-16 14:27:45', '2026-05-16 14:27:45', NULL),
(22, 34, 'Debra', 'Glover', 'lysyfo@mailinator.com', '$2y$12$itVmVPW54xTIqdZX2qaGKelzgQ8ksXq.y3l39REEiNgfwFHJaEZsy', 1, NULL, '2026-05-16 14:30:25', '2026-05-16 14:30:25', NULL),
(23, 35, 'Dane', 'Meyers', 'hejerum@mailinator.com', '$2y$12$RnI/4EJ33dzAhaorFC145.U8Tj7wBF/N9Dr5f5.d7UVp5br5HQKXi', 1, NULL, '2026-05-16 14:41:01', '2026-05-16 14:41:01', NULL),
(24, 36, 'Drake', 'Raymond', 'nevenuw@mailinator.com', '$2y$12$71ukirCUONxNF9kolMUXAOEB2xqsENV9SiWk4c47TcF9j/9THqtye', 1, NULL, '2026-05-16 14:42:13', '2026-05-16 14:42:13', NULL),
(25, 37, 'Barry', 'Mullins', 'hoqykorava@mailinator.com', '$2y$12$mhglFw1aw3HtlIm1hzyhNewFQB0hqCaV/WddU/IZHJY.ldzPDxNey', 1, NULL, '2026-05-16 14:43:01', '2026-05-16 14:43:01', NULL),
(26, 38, 'Elijah', 'Carr', 'degysa@mailinator.com', '$2y$12$V7gr3v3e7ibky8DltMoZgeiI9GvMh.kmfQTuvRBKT2QoQwdeiOIim', 1, NULL, '2026-05-16 14:44:05', '2026-05-16 14:44:05', NULL),
(27, 39, 'Anne', 'Jarvis', 'kira@mailinator.com', '$2y$12$duv6HsSDSuuRIaHzij5dqOK90reOPJW1Lk02ihlxLAPfC/DJb1XEK', 1, NULL, '2026-05-16 14:44:55', '2026-05-16 14:44:55', NULL),
(28, 40, 'Rae', 'Schroeder', 'xatoja@mailinator.com', '$2y$12$Le05055ZmIF5K7FVdjyCOex3fy8MwAs1U0ID8hjBirfTvW8cn.nMG', 1, NULL, '2026-05-16 14:47:38', '2026-05-16 14:47:38', NULL),
(29, 41, 'Eric', 'Giles', 'jole@mailinator.com', '$2y$12$MHYeNwjyHFWEM6yYETOXduthPAhoswf3fuptJvtY6vEHTzd/gtrXy', 1, NULL, '2026-05-16 14:52:02', '2026-05-16 14:52:02', NULL),
(30, 42, 'Winifred', 'Carr', 'dojyfufat@mailinator.com', '$2y$12$4TBYYmSXRdruoK/GdjzENef17UnJ93bQmPK1tOlkR86BN1arLDNva', 1, NULL, '2026-05-16 15:57:06', '2026-05-16 15:57:06', NULL),
(31, 43, 'Ocean', 'Vargas', 'fyju@mailinator.com', '$2y$12$GklrGghLMrnwS38JsPaMIOfpQTU8AcRYljkc3Swxei4rhJqbs30pq', 1, NULL, '2026-05-16 16:01:32', '2026-05-16 16:01:32', NULL),
(32, 44, 'Owen', 'Jacobs', 'josuebondojw@gmail.com', '$2y$12$IJ1VhIV1Yl4F7xAaWvuM8eT/vP1li9XoA/UOjXfc36Kaa0Ch0YmaG', 1, NULL, '2026-05-16 16:08:07', '2026-05-16 16:08:07', NULL),
(33, 45, 'Wesley', 'Drake', 'ldc.agency@gmail.com', '$2y$12$lozJKzxSm0xPpzP0agjOc.Hxhr3pmuAK9LJoF2gPBJrlZ1GsGA8s6', 1, NULL, '2026-05-16 16:09:02', '2026-05-16 16:09:02', NULL),
(34, 46, 'jans pa bondonga', 'Quantix', 'quantix@gmail.com', '$2y$12$AxSOCcNW/X7RnTh0/StqIOUovMYL/RZtHWkSg9N2bWAc085QjiJaS', 1, NULL, '2026-05-16 16:18:39', '2026-05-16 17:27:32', NULL),
(35, 47, 'Gretchen', 'Schroeder', 'port.quantix@gmail.com', '$2y$12$dqSqb4iBhyg2GWIA4jyUfeecCsnLZ4FQ1D/20mXkL9tCy87rxe2Qa', 1, NULL, '2026-05-16 17:28:23', '2026-05-16 17:38:46', NULL),
(36, 48, 'Cherokee', 'Wyatt', 'support.antix@gmail.com', '$2y$12$IBpnX4mKTQHHYBt6TYN6XeIihLEiyE0obJKKuLEYDJlKSKtXk4Tlm', 1, NULL, '2026-05-16 17:39:24', '2026-05-16 17:40:55', NULL),
(37, 49, 'Maryam', 'Mathews', 'support.qantix@gmail.com', '$2y$12$IXTNbu/XiDgE5s.qk20K7OJEvMkV1JHtJhTQXm8zox1T6yOZyhs3q', 1, NULL, '2026-05-16 17:41:19', '2026-05-16 17:48:18', NULL),
(38, 50, 'Imogene', 'Wall', 'support.antix@gmail.com', '$2y$12$xGOdiqFP8p0O4allrBr36uy7zFA39quL8acnTcyF5bpOVD6a1qjDu', 1, NULL, '2026-05-16 17:52:15', '2026-05-16 18:06:41', NULL),
(39, 51, 'Maryam', 'Mathews', 'uantix@gmail.com', '$2y$12$bqnUVnsOPS//oRO8UWQ0COpJSNNhsqQzV.CtuqjCYOUOqwXxbpkL.', 1, NULL, '2026-05-16 18:07:04', '2026-05-16 18:22:33', NULL),
(40, 52, 'Rae', 'Vaughan', '.quantix@gmail.com', '$2y$12$9n5F0EhAd6JB0GciqMs/pe8cOa8W1mmPIe9/6sZddsJZ/s5oIk8D2', 1, NULL, '2026-05-16 18:23:37', '2026-05-16 18:30:36', NULL),
(41, 53, 'Isabelle', 'Cabrera', 'suport.quantix@gmail.com', '$2y$12$kX20vT5UgOGqbbHMO4J8oeV7vGcf6mgq0F/eMQhsrfm0dvgNVdvhW', 1, NULL, '2026-05-16 18:32:55', '2026-05-16 18:34:37', NULL),
(42, 54, 'Elliott', 'Craig', 'support.quantix@gmail.com', '$2y$12$brvn4WpChUoiHNbQPNKff.B/Xkd3uV0acqDLI5ug/NE/Fmxk/IjpG', 1, NULL, '2026-05-16 18:34:58', '2026-05-16 18:34:58', NULL),
(43, 55, 'jans pa bondonga', 'Quantix', 'josue@quantix.com', '$2y$12$msjI46R0s6v2Qi4XYRjOP.F/tTeHwYRUfyV2MOLRzwqj.rvNBsbim', 1, NULL, '2026-05-16 22:34:26', '2026-05-16 22:34:26', NULL);

-- ========================================================
-- WIZARD SESSIONS - Core onboarding/wizard management
-- ========================================================

CREATE TABLE `wizard_sessions` (
  `id` BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `wizard_session_id` VARCHAR(36) UNIQUE NOT NULL COMMENT 'UUID for public reference',
  
  `user_id` BIGINT UNSIGNED NOT NULL,
  `company_id` BIGINT UNSIGNED NULL COMMENT 'NULL until created',
  
  `status` ENUM('draft', 'in_progress', 'completed', 'deployed') DEFAULT 'draft',
  `current_step` INT DEFAULT 1,
  
  `state` LONGTEXT COMMENT 'JSON state of wizard steps',
  `idempotency_key` VARCHAR(36) UNIQUE NULL COMMENT 'For idempotent deployment',
  `deployment_metadata` LONGTEXT COMMENT 'Deployment results (JSON)',
  
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_saved_at` TIMESTAMP NULL COMMENT 'For 30-day inactivity expiration',
  `deployed_at` TIMESTAMP NULL,
  
  CONSTRAINT `fk_wizard_sessions_user_id` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_wizard_sessions_company_id` FOREIGN KEY (`company_id`) REFERENCES `companies`(`id`) ON DELETE CASCADE,
  
  UNIQUE KEY `uk_wizard_session_id` (`wizard_session_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_company_id` (`company_id`),
  KEY `idx_status` (`status`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_last_saved_at` (`last_saved_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================
-- ACTIVATION TOKENS - Email activation tokens
-- ========================================================

CREATE TABLE `activation_tokens` (
  `id` BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  
  `token` VARCHAR(255) UNIQUE NOT NULL COMMENT 'JWT token',
  `status` ENUM('pending', 'used', 'expired') DEFAULT 'pending',
  
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `expires_at` TIMESTAMP NULL,
  `activated_at` TIMESTAMP NULL,
  
  CONSTRAINT `fk_activation_tokens_user_id` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  
  KEY `idx_user_id` (`user_id`),
  KEY `idx_token` (`token`),
  KEY `idx_status` (`status`),
  KEY `idx_expires_at` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `code` varchar(50) NOT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `company_id`, `name`, `code`, `address`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Entrepot Principal', 'MAIN', 'Gombe', '2026-05-16 10:46:11', '2026-05-16 10:46:11', NULL),
(2, 1, 'Entrepot Est', 'EST', 'Limete', '2026-05-16 10:46:11', '2026-05-16 10:46:11', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categories_company` (`company_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_companies_plan` (`plan_id`);

--
-- Indexes for table `company_settings`
--
ALTER TABLE `company_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_id` (`company_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference` (`reference`),
  ADD KEY `fk_payments_subscription` (`subscription_id`),
  ADD KEY `fk_payments_company` (`company_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_products_company_sku` (`company_id`,`sku`),
  ADD KEY `idx_products_company_name` (`company_id`,`name`),
  ADD KEY `fk_products_category` (`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_roles_company_code` (`company_id`,`code`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `fk_role_permissions_permission` (`permission_id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_stocks_warehouse_product` (`warehouse_id`,`product_id`),
  ADD KEY `fk_stocks_product` (`product_id`);

--
-- Indexes for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_stock_movements_type` (`type`),
  ADD KEY `idx_stock_movements_created_at` (`created_at`),
  ADD KEY `idx_stock_movements_company_created` (`company_id`,`created_at`),
  ADD KEY `idx_stock_movements_product_created` (`product_id`,`created_at`),
  ADD KEY `idx_stock_movements_warehouse_created` (`warehouse_id`,`created_at`),
  ADD KEY `fk_stock_movements_user` (`user_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_subscriptions_company` (`company_id`),
  ADD KEY `fk_subscriptions_plan` (`plan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_users_company_email` (`company_id`,`email`),
  ADD KEY `idx_activation_status` (`activation_status`),
  ADD KEY `idx_activated_at` (`activated_at`),
  ADD KEY `idx_wizard_session_id` (`wizard_session_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `fk_user_roles_role` (`role_id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_warehouses_company_code` (`company_id`,`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `company_settings`
--
ALTER TABLE `company_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stock_movements`
--
ALTER TABLE `stock_movements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_categories_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `fk_companies_plan` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`);

--
-- Constraints for table `company_settings`
--
ALTER TABLE `company_settings`
  ADD CONSTRAINT `fk_company_settings_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payments_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_payments_subscription` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_products_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `fk_roles_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `fk_role_permissions_permission` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_role_permissions_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `fk_stocks_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_stocks_warehouse` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_movements`
--
ALTER TABLE `stock_movements`
  ADD CONSTRAINT `fk_stock_movements_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `fk_stock_movements_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_stock_movements_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_stock_movements_warehouse` FOREIGN KEY (`warehouse_id`) REFERENCES `warehouses` (`id`);

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `fk_subscriptions_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_subscriptions_plan` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `fk_user_roles_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_user_roles_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD CONSTRAINT `fk_warehouses_company` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
