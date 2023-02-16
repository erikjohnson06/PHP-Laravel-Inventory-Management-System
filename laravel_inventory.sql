-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 16, 2023 at 06:26 PM
-- Server version: 5.7.36
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_id` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `categories`
--

TRUNCATE TABLE `categories`;
--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Laptops', 1, 6, NULL, '2023-02-11 16:10:22', NULL),
(2, 'Monitors', 1, 6, NULL, '2023-02-11 16:10:31', NULL),
(3, 'Tablets', 1, 6, NULL, '2023-02-11 16:10:39', NULL),
(4, 'Accessories', 1, 6, NULL, '2023-02-11 16:10:50', NULL),
(5, 'Desktop Computers', 1, 6, NULL, '2023-02-11 16:11:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category_statuses`
--

DROP TABLE IF EXISTS `category_statuses`;
CREATE TABLE IF NOT EXISTS `category_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `category_statuses`
--

TRUNCATE TABLE `category_statuses`;
--
-- Dumping data for table `category_statuses`
--

INSERT INTO `category_statuses` (`id`, `status`) VALUES
(1, 'Active'),
(2, 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_id` tinyint(4) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `customers`
--

TRUNCATE TABLE `customers`;
--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `image`, `phone`, `email`, `address`, `status_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'HoneyBee Services, Inc', 'upload/customers/1757534102905131.png', '800-123-4567', 'honeybeeservices@email.com', '123 Honey Lane', 1, 6, NULL, '2023-02-11 16:32:14', NULL),
(2, 'Action Industries', 'upload/customers/1757534147370219.png', '800-123-4455', 'actionindustries@email.com', '123 Action Street', 1, 6, NULL, '2023-02-11 16:32:56', NULL),
(3, 'Dynamic Service, LLC', 'upload/customers/1757534213761219.png', '800-123-4567', 'dynamicservices@email.com', '123 Dynamics Street', 1, 6, NULL, '2023-02-11 16:33:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_statuses`
--

DROP TABLE IF EXISTS `customer_statuses`;
CREATE TABLE IF NOT EXISTS `customer_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `customer_statuses`
--

TRUNCATE TABLE `customer_statuses`;
--
-- Dumping data for table `customer_statuses`
--

INSERT INTO `customer_statuses` (`id`, `status`) VALUES
(1, 'Active'),
(2, 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `failed_jobs`
--

TRUNCATE TABLE `failed_jobs`;
-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE IF NOT EXISTS `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_no` int(11) NOT NULL DEFAULT '0',
  `invoice_date` date DEFAULT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci,
  `status_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=Pending,2=Approved',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invoices_invoice_no_unique` (`invoice_no`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `invoices`
--

TRUNCATE TABLE `invoices`;
--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoice_no`, `invoice_date`, `comments`, `status_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1000, '2023-01-10', NULL, 2, 6, 6, '2023-02-11 16:50:02', '2023-02-11 16:54:30'),
(2, 1001, '2023-02-11', NULL, 2, 6, 6, '2023-02-11 16:52:59', '2023-02-11 16:54:36'),
(3, 1002, '2023-02-11', NULL, 2, 6, 6, '2023-02-11 16:54:03', '2023-02-11 16:54:43'),
(4, 1003, '2023-02-11', NULL, 2, 6, 6, '2023-02-11 16:55:32', '2023-02-11 16:55:44'),
(5, 1004, '2023-02-11', NULL, 1, 6, NULL, '2023-02-11 17:00:16', '2023-02-11 17:00:16');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

DROP TABLE IF EXISTS `invoice_details`;
CREATE TABLE IF NOT EXISTS `invoice_details` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `sales_qty` double DEFAULT '0',
  `unit_price` double DEFAULT '0',
  `sales_price` double DEFAULT '0',
  `status_id` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `invoice_details_invoice_id_foreign` (`invoice_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `invoice_details`
--

TRUNCATE TABLE `invoice_details`;
--
-- Dumping data for table `invoice_details`
--

INSERT INTO `invoice_details` (`id`, `invoice_id`, `invoice_date`, `category_id`, `product_id`, `sales_qty`, `unit_price`, `sales_price`, `status_id`) VALUES
(1, 1000, '2023-01-10', 1, 6, 5, 550, 2750, 2),
(2, 1000, '2023-01-10', 1, 4, 5, 575, 2875, 2),
(3, 1000, '2023-01-10', 1, 3, 10, 600, 6000, 2),
(4, 1001, '2023-02-11', 2, 8, 2, 200, 400, 2),
(5, 1001, '2023-02-11', 2, 7, 2, 200, 400, 2),
(6, 1002, '2023-02-11', 3, 9, 5, 350, 1750, 2),
(7, 1002, '2023-02-11', 3, 2, 5, 450, 2250, 2),
(8, 1002, '2023-02-11', 3, 1, 5, 250, 1250, 2),
(9, 1003, '2023-02-11', 1, 6, 2, 550, 1100, 2),
(10, 1003, '2023-02-11', 1, 4, 2, 550, 1100, 2),
(11, 1003, '2023-02-11', 1, 3, 4, 500, 2000, 2),
(12, 1004, '2023-02-11', 2, 5, 5, 200, 1000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_statuses`
--

DROP TABLE IF EXISTS `invoice_statuses`;
CREATE TABLE IF NOT EXISTS `invoice_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `invoice_statuses`
--

TRUNCATE TABLE `invoice_statuses`;
--
-- Dumping data for table `invoice_statuses`
--

INSERT INTO `invoice_statuses` (`id`, `status`) VALUES
(1, 'Pending'),
(2, 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `migrations`
--

TRUNCATE TABLE `migrations`;
--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_01_16_100039_create_suppliers_table', 1),
(6, '2023_01_18_103755_create_customers_table', 1),
(7, '2023_01_19_202210_create_customer_statuses_table', 1),
(8, '2023_01_20_194251_create_units_table', 1),
(9, '2023_01_20_203509_create_categories_table', 1),
(10, '2023_01_20_204646_create_category_statuses_table', 1),
(11, '2023_01_20_205031_rename_category_status', 1),
(12, '2023_01_20_212314_rename_supplier_status', 1),
(13, '2023_01_20_212512_create_supplier_statuses_table', 1),
(14, '2023_01_20_214059_create_products_table', 1),
(15, '2023_01_20_215428_create_product_statuses_table', 1),
(16, '2023_01_20_215536_rename_product_status', 1),
(17, '2023_01_22_102041_create_purchase_orders_table', 1),
(18, '2023_01_22_104938_create_purchase_order_statuses_table', 1),
(19, '2023_01_27_190933_create_invoices_table', 1),
(20, '2023_01_27_191056_create_invoice_details_table', 1),
(21, '2023_01_27_191628_create_payments_table', 1),
(22, '2023_01_27_191701_create_payment_details_table', 1),
(23, '2023_01_27_200944_create_invoice_statuses_table', 1),
(24, '2023_01_28_103006_update_invoice_table', 1),
(25, '2023_01_28_110132_create_payment_statuses_table', 1),
(26, '2023_01_31_103451_update_invoice_table_keys', 1),
(27, '2023_01_31_104138_update_payment_table_keys', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `password_resets`
--

TRUNCATE TABLE `password_resets`;
-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `status_id` tinyint(4) DEFAULT '0',
  `payment_amount` double DEFAULT '0',
  `discount_amount` double DEFAULT '0',
  `due_amount` double DEFAULT '0',
  `total_amount` double DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_invoice_id_foreign` (`invoice_id`),
  KEY `payments_customer_id_foreign` (`customer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `payments`
--

TRUNCATE TABLE `payments`;
--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `invoice_id`, `customer_id`, `payment_date`, `status_id`, `payment_amount`, `discount_amount`, `due_amount`, `total_amount`, `created_at`, `updated_at`) VALUES
(1, 1000, 1, '2023-02-11', 1, 11625, 0, 0, 11625, '2023-02-11 16:50:02', '2023-02-11 16:50:02'),
(2, 1001, 2, '2023-02-11', 1, 790, 10, 0, 790, '2023-02-11 16:52:59', '2023-02-11 16:52:59'),
(3, 1002, 3, '2023-02-11', 1, 5240, 10, 0, 5240, '2023-02-11 16:54:03', '2023-02-11 16:54:03'),
(4, 1003, 1, '2023-02-11', 3, 4000, 0, 200, 4200, '2023-02-11 16:55:32', '2023-02-11 16:57:05'),
(5, 1004, 2, '2023-02-11', 1, 1000, 0, 0, 1000, '2023-02-11 17:00:16', '2023-02-11 17:00:16');

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

DROP TABLE IF EXISTS `payment_details`;
CREATE TABLE IF NOT EXISTS `payment_details` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_amount` double DEFAULT '0',
  `current_paid_amount` double DEFAULT '0',
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_details_invoice_id_foreign` (`invoice_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `payment_details`
--

TRUNCATE TABLE `payment_details`;
--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`id`, `invoice_id`, `payment_date`, `payment_amount`, `current_paid_amount`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1000, '2023-02-11', 0, 11625, 6, '2023-02-11 16:50:02', '2023-02-11 16:50:02'),
(2, 1001, '2023-02-11', 0, 790, 6, '2023-02-11 16:52:59', '2023-02-11 16:52:59'),
(3, 1002, '2023-02-11', 0, 5240, 6, '2023-02-11 16:54:03', '2023-02-11 16:54:03'),
(4, 1003, '2023-02-11', 0, 2000, 6, '2023-02-11 16:55:32', '2023-02-11 16:55:32'),
(5, 1003, '2023-02-11', 0, 2000, 6, '2023-02-11 16:57:05', '2023-02-11 16:57:05'),
(6, 1004, '2023-02-11', 0, 1000, 6, '2023-02-11 17:00:16', '2023-02-11 17:00:16');

-- --------------------------------------------------------

--
-- Table structure for table `payment_statuses`
--

DROP TABLE IF EXISTS `payment_statuses`;
CREATE TABLE IF NOT EXISTS `payment_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `payment_statuses`
--

TRUNCATE TABLE `payment_statuses`;
--
-- Dumping data for table `payment_statuses`
--

INSERT INTO `payment_statuses` (`id`, `status`) VALUES
(1, 'Paid in Full'),
(2, 'Due Amount Payment'),
(3, 'Partial Payment');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `personal_access_tokens`
--

TRUNCATE TABLE `personal_access_tokens`;
-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `quantity` double DEFAULT '0',
  `status_id` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `products`
--

TRUNCATE TABLE `products`;
--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `supplier_id`, `unit_id`, `category_id`, `quantity`, `status_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Amazon - Fire HD 8 (2022) 8\" HD tablet with Wi-Fi 32 GB - Black', 2, 1, 3, 35, 1, 6, NULL, '2023-02-11 16:14:48', '2023-02-11 16:54:43'),
(2, 'Apple - 10.2-Inch iPad with Wi-Fi - 64GB - Space Gray', 3, 1, 3, 35, 1, 6, NULL, '2023-02-11 16:15:15', '2023-02-11 16:54:43'),
(3, 'ASUS - 11.6\" Laptop - Intel Celeron N4020 - 4GB Memory - 64GB eMMC - Star Black', 4, 1, 1, 11, 1, 6, NULL, '2023-02-11 16:15:33', '2023-02-11 16:55:44'),
(4, 'HP - 15.6\" Touch-Screen - Laptop - Intel Core i5 - 12GB Memory - 256GB SSD - Natural Silver', 6, 1, 1, 18, 1, 6, NULL, '2023-02-11 16:15:49', '2023-02-11 16:55:44'),
(5, 'HP - 24\" IPS LED FHD FreeSync Monitor (HDMI, VGA) - Silver and Black', 6, 1, 2, 20, 1, 6, NULL, '2023-02-11 16:16:04', '2023-02-11 16:42:27'),
(6, 'Lenovo - Ideapad 3i 15.6\" HD Touch Laptop - Core i3-1115G4 - 8GB Memory - 256GB SSD - Platinum Grey', 5, 1, 1, 18, 1, 6, NULL, '2023-02-11 16:16:18', '2023-02-11 16:55:44'),
(7, 'LG - 22” LED FHD FreeSync Monitor (HDMI) - Black', 7, 1, 2, 18, 1, 6, NULL, '2023-02-11 16:16:43', '2023-02-11 16:54:36'),
(8, 'LG - 32” UltraGear QHD Nano IPS 1ms 165Hz HDR Monitor withG-SYNC Compatibility - Black', 7, 1, 2, 18, 1, 6, NULL, '2023-02-11 16:17:28', '2023-02-11 16:54:36'),
(9, 'Samsung - Galaxy Tablet A8 10.5\" 32GB (Latest Model) - Wi-Fi - Gray', 1, 1, 3, 15, 1, 6, NULL, '2023-02-11 16:18:08', '2023-02-11 16:54:43'),
(10, 'Samsung - Galaxy Tablet S7 FE - 12.4\" 64GB - Wi-Fi - with S-Pen - Mystic Black', 1, 1, 3, 20, 1, 6, NULL, '2023-02-11 16:18:31', '2023-02-11 16:41:58');

-- --------------------------------------------------------

--
-- Table structure for table `product_statuses`
--

DROP TABLE IF EXISTS `product_statuses`;
CREATE TABLE IF NOT EXISTS `product_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `product_statuses`
--

TRUNCATE TABLE `product_statuses`;
--
-- Dumping data for table `product_statuses`
--

INSERT INTO `product_statuses` (`id`, `status`) VALUES
(1, 'Active'),
(2, 'Closeout'),
(3, 'On Hold'),
(4, 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

DROP TABLE IF EXISTS `purchase_orders`;
CREATE TABLE IF NOT EXISTS `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `po_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `po_date` date NOT NULL,
  `po_description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `purchase_qty` double NOT NULL DEFAULT '0',
  `unit_price` double NOT NULL DEFAULT '0',
  `purchase_price` double NOT NULL DEFAULT '0',
  `status_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0=Pending,1=Approved,2=Canceled',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `purchase_orders`
--

TRUNCATE TABLE `purchase_orders`;
--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `po_number`, `po_date`, `po_description`, `product_id`, `supplier_id`, `category_id`, `purchase_qty`, `unit_price`, `purchase_price`, `status_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '4044-HBC', '2023-02-11', '', 2, 3, 3, 40, 350, 14000, 2, 6, NULL, '2023-02-11 16:39:30', '2023-02-11 16:41:49'),
(2, '4044-HBC', '2023-02-11', '', 1, 2, 3, 40, 200, 8000, 2, 6, NULL, '2023-02-11 16:39:30', '2023-02-11 16:41:53'),
(3, '4044-HBC', '2023-02-11', '', 10, 1, 3, 20, 150, 3000, 2, 6, NULL, '2023-02-11 16:39:30', '2023-02-11 16:41:58'),
(4, '4044-HBC', '2023-02-11', '', 9, 1, 3, 20, 125, 2500, 2, 6, NULL, '2023-02-11 16:39:30', '2023-02-11 16:42:01'),
(5, '4045-HBC', '2023-02-11', '', 4, 6, 1, 25, 350, 8750, 2, 6, NULL, '2023-02-11 16:40:35', '2023-02-11 16:42:05'),
(6, '4045-HBC', '2023-02-11', '', 6, 5, 1, 25, 425, 10625, 2, 6, NULL, '2023-02-11 16:40:35', '2023-02-11 16:42:09'),
(7, '4045-HBC', '2023-02-11', '', 3, 4, 1, 25, 400, 10000, 2, 6, NULL, '2023-02-11 16:40:35', '2023-02-11 16:42:11'),
(8, '4046-HBC', '2023-02-11', '', 8, 7, 2, 20, 80, 1600, 2, 6, NULL, '2023-02-11 16:41:23', '2023-02-11 16:42:14'),
(9, '4046-HBC', '2023-02-11', '', 7, 7, 2, 20, 85, 1700, 2, 6, NULL, '2023-02-11 16:41:23', '2023-02-11 16:42:19'),
(10, '4046-HBC', '2023-02-11', '', 5, 6, 2, 20, 90, 1800, 2, 6, NULL, '2023-02-11 16:41:23', '2023-02-11 16:42:27'),
(11, '4047-HBC', '2023-02-11', '', 9, 1, 3, 10, 150, 1500, 1, 6, NULL, '2023-02-11 16:42:52', '2023-02-11 16:42:52'),
(12, '4048-HBC', '2023-02-11', '', 1, 2, 3, 10, 150, 1500, 1, 6, NULL, '2023-02-11 16:43:14', '2023-02-11 16:43:14');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_statuses`
--

DROP TABLE IF EXISTS `purchase_order_statuses`;
CREATE TABLE IF NOT EXISTS `purchase_order_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `purchase_order_statuses`
--

TRUNCATE TABLE `purchase_order_statuses`;
--
-- Dumping data for table `purchase_order_statuses`
--

INSERT INTO `purchase_order_statuses` (`id`, `status`) VALUES
(1, 'Pending'),
(2, 'Approved'),
(3, 'Cancelled');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_id` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `suppliers`
--

TRUNCATE TABLE `suppliers`;
--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `phone`, `email`, `status_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Samsung', '800-123-1234', 'samsung@test.com', 1, 6, NULL, '2023-02-11 16:04:41', NULL),
(2, 'Amazon', '800-123-4455', 'amazon@test.com', 1, 6, NULL, '2023-02-11 16:05:21', NULL),
(3, 'Apple', '800-123-4567', 'apple@test.com', 1, 6, NULL, '2023-02-11 16:05:42', NULL),
(4, 'ASUS', '800-555-1234', 'asus@test.com', 1, 6, NULL, '2023-02-11 16:06:06', NULL),
(5, 'Lenovo', '800-123-1234', 'lenovo@test.com', 1, 6, NULL, '2023-02-11 16:06:24', NULL),
(6, 'Hewlett Packard (HP)', '800-123-4455', 'hp@test.com', 1, 6, NULL, '2023-02-11 16:07:05', NULL),
(7, 'LG', '800-123-0987', 'lg@test.com', 1, 6, NULL, '2023-02-11 16:07:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_statuses`
--

DROP TABLE IF EXISTS `supplier_statuses`;
CREATE TABLE IF NOT EXISTS `supplier_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `supplier_statuses`
--

TRUNCATE TABLE `supplier_statuses`;
--
-- Dumping data for table `supplier_statuses`
--

INSERT INTO `supplier_statuses` (`id`, `status`) VALUES
(1, 'Active'),
(2, 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
CREATE TABLE IF NOT EXISTS `units` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `units`
--

TRUNCATE TABLE `units`;
--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Each', 1, NULL, NULL, NULL, NULL),
(2, 'Piece', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `users`
--

TRUNCATE TABLE `users`;
--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `username`, `profile_image`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test User', 'test@email.com', '2023-01-03 20:06:38', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'testuser', '2023021110537274952.jpg', 'MAeg3M56ywETWdzT3OBpyor5dxGhTjl5AjLL8VC5KFQQkasxvZyJJX6aPnKa', '2023-01-03 20:06:11', '2023-02-11 15:53:47');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
