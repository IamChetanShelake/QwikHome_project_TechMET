-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 10, 2025 at 04:06 AM
-- Server version: 8.0.43
-- PHP Version: 8.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qwikhom_adminweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `contact_details` text COLLATE utf8mb4_unicode_ci,
  `address_details` text COLLATE utf8mb4_unicode_ci,
  `type` enum('home','work','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `contact_details`, `address_details`, `type`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 11, '\"mayur, 9172593150\"', '\"near business bay\"', NULL, 0, '2025-10-09 05:57:35', '2025-10-09 08:35:50'),
(4, 11, '\"shivam, 917259345\"', '\"near business magnite\"', NULL, 0, '2025-10-09 08:32:20', '2025-10-09 08:54:46'),
(5, 11, '\"shivam, 917259345\"', '\"near business magnite\"', 'other', 1, '2025-10-09 08:54:46', '2025-10-09 08:56:02');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `description`, `status`, `image`, `created_at`, `updated_at`) VALUES
(17, NULL, NULL, 'active', '1759925563_.jpg', '2025-10-08 08:38:50', '2025-10-08 12:12:43'),
(18, NULL, NULL, 'active', '1759925574_.jpg', '2025-10-08 08:38:50', '2025-10-08 12:12:54'),
(19, NULL, NULL, 'active', '1759925588_.jpg', '2025-10-08 08:38:50', '2025-10-08 12:13:08');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `service_provider_id` bigint UNSIGNED NOT NULL,
  `vendor_id` bigint UNSIGNED NOT NULL,
  `booking_reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scheduled_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` enum('pending','ongoing','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `price` decimal(10,2) DEFAULT NULL,
  `customer_notes` text COLLATE utf8mb4_unicode_ci,
  `vendor_notes` text COLLATE utf8mb4_unicode_ci,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `campaigns`
--

INSERT INTO `campaigns` (`id`, `title`, `description`, `status`, `image`, `created_at`, `updated_at`) VALUES
(20, 'title1', NULL, 'active', '1759924971_.jpg', '2025-10-08 09:20:03', '2025-10-08 12:02:51'),
(21, 'title2', NULL, 'active', '1759924985_.jpg', '2025-10-08 09:20:03', '2025-10-08 12:03:05'),
(22, 'title3', NULL, 'active', '1759924997_.png', '2025-10-08 09:20:03', '2025-10-08 12:03:17');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`, `image`) VALUES
(1, 'Waxing', NULL, 'active', '2025-10-02 23:47:37', '2025-10-07 07:32:31', '1759822351.jpg'),
(2, 'Core Home Services', 'Essential cleaning, maintenance, and home care services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(3, 'Family Support', 'Support services for families including childcare and assistance', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(4, 'Personal Care', 'Beauty, grooming, and personal wellness services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(5, 'Home Maintenance & Interior', 'Home improvement, repairs, and maintenance services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(6, 'Vehicle & Legal Services', 'Vehicle maintenance and legal assistance services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(7, 'Lifestyle & Events', 'Event planning and lifestyle enhancement services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(8, 'Home Services', NULL, 'active', '2025-10-03 23:43:15', '2025-10-03 23:43:15', 'category1.jpg'),
(9, 'test category', 'test desc', 'active', '2025-10-07 08:17:50', '2025-10-07 08:17:50', '1759825070.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `complainant_type` enum('customer','service_provider') COLLATE utf8mb4_unicode_ci NOT NULL,
  `complaint_type` enum('late_delivery','poor_service','payment_issue','fraud','product_quality','communication','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','in_review','resolved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `attachment_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `original_filename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assigned_admin_id` bigint UNSIGNED DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `resolution_action` enum('refund','replacement','account_blocked','warning','none','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resolution_details` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `discount_type` enum('percentage','fixed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `expiry_date` datetime NOT NULL,
  `usage_limit` int DEFAULT NULL,
  `used_count` int NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `description`, `discount_type`, `discount_value`, `expiry_date`, `usage_limit`, `used_count`, `status`, `created_at`, `updated_at`) VALUES
(1, 'QHSAVE30', 'this will save 30 AED fewtgfdsvb', 'percentage', 30.00, '2025-09-24 10:47:00', NULL, 0, 1, '2025-10-03 00:47:50', '2025-10-03 00:57:42'),
(3, 'WERTY', NULL, 'percentage', 20.00, '2025-10-26 16:11:00', NULL, 0, 1, '2025-10-04 05:11:51', '2025-10-04 05:11:51');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `status`, `service_id`, `created_at`, `updated_at`) VALUES
(2, 'It means the admin has a dashboard/section to handle problems raised by users.', 'marketplace, or e-commerce platforms).\r\n\r\nIt means the admin has a dashboard/section to handle problems raised by users.\r\n\r\n🔹 Typical Features:\r\n\r\nComplaint/Dispute Submission\r\n\r\nCustomers or service providers can submit a complaint (e.g., late delivery, poor service, payment issue, fraud).\r\n\r\nUsually includes details: order ID / user ID, complaint category, description, attachments.\r\n\r\nAdmin Tracking\r\n\r\nAdmin can see all complaints in a table with status (Pending, In Review, Resolved, Rejected).\r\n\r\nFilter/search by date, type, user, or status.\r\n\r\nTwo-way Communication\r\n\r\nSometimes, a chat-like thread where admin and users can exchange messages about the issue.\r\n\r\nResolution Actions\r\n\r\nAdmin can mark th', 1, 2, '2025-10-03 03:25:27', '2025-10-03 03:38:23');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED DEFAULT NULL,
  `employee_id` bigint UNSIGNED DEFAULT NULL,
  `rating_service` tinyint UNSIGNED NOT NULL,
  `rating_employee` tinyint UNSIGNED DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_29_061958_create_personal_access_tokens_table', 2),
(5, '2025_09_30_085000_add_image_to_users_table', 3),
(6, '2025_09_30_072610_create_categories_table', 4),
(7, '2025_09_30_072617_create_subcategories_table', 4),
(8, '2025_09_30_072628_create_services_table', 4),
(9, '2025_10_01_123023_create_faqs_table', 5),
(10, '2025_10_03_061108_create_coupons_table', 6),
(11, '2025_10_03_063411_create_complaints_table', 7),
(12, '2025_10_03_083904_add_service_id_to_faqs_table', 8),
(13, '2025_10_03_092116_create_promocodes_table', 9),
(14, '2025_10_03_120000_add_image_to_categories_table', 10),
(15, '2025_10_03_121000_add_image_to_subcategories_table', 10),
(16, '2025_10_03_122000_add_image_to_services_table', 10),
(17, '2025_10_03_103833_create_vendors_table', 11),
(18, '2025_10_03_103846_create_service_providers_table', 11),
(19, '2025_10_03_111437_add_colum_to_users_table', 12),
(20, '2025_10_04_044610_create_bookings_table', 13),
(21, '2025_10_04_103703_update_coupons_table_discount_type_to_percentage_only', 14),
(22, '2025_10_06_064930_create_user_services_table', 15),
(23, '2025_10_06_085000_create_feedbacks_table', 16),
(25, '2025_10_03_104240_create_service_requirements_table', 17),
(26, '2025_10_04_052001_create_processes_table', 18);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `title`, `description`, `status`, `image`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'active', '1759925608.png', '2025-10-08 09:18:15', '2025-10-08 12:13:28'),
(2, NULL, NULL, 'active', '1759925619.jpg', '2025-10-08 09:18:15', '2025-10-08 12:13:39');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(7, 'App\\Models\\User', 22, 'API Token', '25adcc77ded61b1cb936dc3420a9153acdfd79d7b640caeaa165a25a30d484f7', '[\"*\"]', NULL, NULL, '2025-10-08 10:06:18', '2025-10-08 10:06:18'),
(11, 'App\\Models\\User', 18, 'API Token', '7e886b85d6310dd4b6e42bd69d1b6afffe9e43e6fd74cbc875bb8eb3e0627461', '[\"*\"]', NULL, NULL, '2025-10-09 07:29:00', '2025-10-09 07:29:00'),
(21, 'App\\Models\\User', 25, 'API Token', 'b62070c05e0f3b4cc14df71fdce41e591826a690fddb59c0c79564a1cdf81c66', '[\"*\"]', NULL, NULL, '2025-10-09 10:55:05', '2025-10-09 10:55:05'),
(52, 'App\\Models\\User', 24, 'API Token', 'f57b1f380dbf020bf34c2e4352f5b5a43839c4077230a9f0325316169c20c13b', '[\"*\"]', NULL, NULL, '2025-10-09 12:01:03', '2025-10-09 12:01:03');

-- --------------------------------------------------------

--
-- Table structure for table `processes`
--

CREATE TABLE `processes` (
  `id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `processes`
--

INSERT INTO `processes` (`id`, `service_id`, `title`, `description`, `image`, `order`, `created_at`, `updated_at`) VALUES
(4, 1, 'test proces', 'process desc', '1759822311_process_0_mothersday.jpeg', 0, '2025-10-07 07:31:51', '2025-10-07 07:31:51');

-- --------------------------------------------------------

--
-- Table structure for table `promocodes`
--

CREATE TABLE `promocodes` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `for_active_subscription` tinyint(1) NOT NULL DEFAULT '1',
  `is_used` tinyint(1) NOT NULL DEFAULT '0',
  `expiry_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promocodes`
--

INSERT INTO `promocodes` (`id`, `code`, `discount`, `for_active_subscription`, `is_used`, `expiry_date`, `created_at`, `updated_at`) VALUES
(1, 'QWAPPLY200', 200.00, 1, 0, '2025-10-31 14:57:00', '2025-10-03 03:57:43', '2025-10-03 03:57:43');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `subcategory_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `whats_include` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `price_onetime` decimal(10,2) DEFAULT NULL,
  `price_onetime_desc` text COLLATE utf8mb4_unicode_ci,
  `price_weekly` decimal(10,2) DEFAULT NULL,
  `price_weekly_desc` text COLLATE utf8mb4_unicode_ci,
  `price_monthly` decimal(10,2) DEFAULT NULL,
  `price_monthly_desc` text COLLATE utf8mb4_unicode_ci,
  `price_yearly` decimal(10,2) DEFAULT NULL,
  `price_yearly_desc` text COLLATE utf8mb4_unicode_ci,
  `is_arabic` tinyint(1) NOT NULL DEFAULT '0',
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `qwikpick` tinyint NOT NULL DEFAULT '0',
  `beauty_and_easy` tinyint NOT NULL DEFAULT '0',
  `average_rating` decimal(3,1) DEFAULT '0.0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `category_id`, `subcategory_id`, `name`, `description`, `whats_include`, `short_description`, `price_onetime`, `price_onetime_desc`, `price_weekly`, `price_weekly_desc`, `price_monthly`, `price_monthly_desc`, `price_yearly`, `price_yearly_desc`, `is_arabic`, `duration`, `status`, `qwikpick`, `beauty_and_easy`, `average_rating`, `created_at`, `updated_at`, `image`) VALUES
(1, 1, 1, 'salon', 'Ullamco nemo vel eve', '[\"test inclusion desc\"]', 'long desc added', 117.00, NULL, 118.00, NULL, 119.00, NULL, 200.00, NULL, 1, '2  hours', 'active', 1, 1, 3.0, '2025-10-02 23:48:49', '2025-10-09 12:04:05', '1759822311_download (1).jpeg'),
(2, 2, 2, 'Maids – Subscription & on-demand cleaning', 'Professional house cleaning services available on subscription or one-time basis', NULL, NULL, 500.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2-4 hours', 'active', 0, 1, NULL, '2025-10-03 00:06:31', '2025-10-08 12:14:04', NULL),
(3, 2, 2, 'Deep Cleaning – Kitchen, bathroom, full home', 'Thorough deep cleaning of kitchen, bathroom, and entire home', NULL, NULL, 2000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '4-6 hours', 'active', 0, 1, NULL, '2025-10-03 00:06:31', '2025-10-08 12:14:05', NULL),
(4, 2, 2, 'Move-in/Move-out Cleaning', 'Specialized cleaning service for property transitions', NULL, NULL, 3000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '6-8 hours', 'active', 1, 0, NULL, '2025-10-03 00:06:31', '2025-10-08 12:14:08', NULL),
(5, 2, 2, 'Refrigerator Cleaning', 'Professional refrigerator deep cleaning and sanitization', NULL, NULL, 800.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2 hours', 'active', 1, 0, NULL, '2025-10-03 00:06:31', '2025-10-08 12:14:10', NULL),
(6, 2, 3, 'Laundry at Home – Ironing, folding, wardrobe assistance', 'Complete laundry service including ironing, folding, and wardrobe organization', NULL, NULL, 600.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '3-4 hours', 'active', 1, 0, NULL, '2025-10-03 00:06:31', '2025-10-08 12:14:11', NULL),
(7, 2, 3, 'Laundry Collection – Clothes, carpets, shoes', 'Professional laundry collection service for clothes, carpets, and shoes', NULL, NULL, 300.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2 hours', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(8, 2, 4, 'Pest Control', 'Professional pest management and extermination services', NULL, NULL, 1500.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2-3 hours', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(9, 2, 4, 'Disinfection Services', 'Complete disinfection and sanitization of home spaces', NULL, NULL, 1000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2-3 hours', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(10, 2, 5, 'Movers and Packers for home/office relocation', 'Professional moving and packing services for home or office relocation', NULL, NULL, 5000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Full day', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(11, 3, 6, 'Nanny Services', 'Professional childcare and nanny services for families', NULL, NULL, 800.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '4-8 hours', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(12, 3, 7, 'Post-Maternity Care Staff', 'Post-delivery maternal care and newborn assistance', NULL, NULL, 1200.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '12-24 hours', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(13, 3, 8, 'Home Tutor', 'Professional home tutoring services for all subjects and grades', NULL, NULL, 600.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2 hours', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(14, 3, 9, 'Cook Services – 2 meals/day, 2-hour schedule', 'Home cooking service providing 2 meals per day with 2-hour schedule', NULL, NULL, 1000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2 hours', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(15, 3, 10, 'Driver on Demand – 6-hour or overnight', 'On-demand driver services for 6-hour shifts or overnight requirements', NULL, NULL, 1500.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '6-24 hours', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(16, 4, 11, 'Salon Services – Unisex + kids (hair, waxing, facial, grooming)', 'Complete salon services including hair, waxing, facial, and grooming for all ages', NULL, NULL, 800.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '1-3 hours', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(17, 4, 12, 'Spa Services – Massage, mani-pedi', 'Professional spa services including massage therapy and pedicure', NULL, NULL, 1200.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '1-2 hours', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(18, 5, 13, 'Curtains & Blinds – Installation & repair', 'Professional installation and repair of curtains and blinds', NULL, NULL, 1000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2-4 hours', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(19, 5, 14, 'Painting Services', 'Professional interior and exterior painting services', NULL, NULL, 2500.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Full day', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(20, 5, 15, 'Carpentry & Furniture Repair', 'Woodworking and furniture repair and restoration services', NULL, NULL, 1200.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2-6 hours', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(21, 5, 16, 'Home Appliance Maintenance – AC, fridge, washing machine', 'Maintenance and repair services for AC, refrigerator, and washing machine', NULL, NULL, 1200.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '1-3 hours', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(22, 5, 17, 'Landscape Maintenance', 'Garden and outdoor space maintenance and landscaping', NULL, NULL, 800.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2-4 hours', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(23, 6, 18, 'Vehicle Recovery', 'Professional vehicle recovery and towing services', NULL, NULL, 800.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Variable', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(24, 6, 18, 'Vehicle Renewal Services', 'Help with vehicle registration renewal and documentation', NULL, NULL, 1500.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '1-2 days', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(25, 6, 18, 'Bicycle Maintenance', 'Bicycle repair and maintenance services', NULL, NULL, 400.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '1-2 hours', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(26, 6, 19, 'Family Visa Renewal Services', 'Assistance with family visa renewal and documentation', NULL, NULL, 3000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '1-2 weeks', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(27, 7, 20, 'Party Organizer', 'Complete party planning and organization services', NULL, NULL, 5000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Event-based', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(28, 7, 21, 'Pet Care & Grooming – Bathing, nail trimming, brushing', 'Complete pet care including bathing, nail trimming, and grooming services', NULL, NULL, 600.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '1-2 hours', 'active', 0, 0, NULL, '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `service_provider_reviews`
--

CREATE TABLE `service_provider_reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `service_provider_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint NOT NULL COMMENT '1 to 5',
  `review` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_provider_reviews`
--

INSERT INTO `service_provider_reviews` (`id`, `user_id`, `service_provider_id`, `rating`, `review`, `created_at`, `updated_at`) VALUES
(1, 11, 8, 4, 'this was a nice serviceprovider', '2025-10-09 12:22:32', '2025-10-09 12:22:32');

-- --------------------------------------------------------

--
-- Table structure for table `service_requirements`
--

CREATE TABLE `service_requirements` (
  `id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_requirements`
--

INSERT INTO `service_requirements` (`id`, `service_id`, `title`, `description`, `image`, `created_at`, `updated_at`) VALUES
(5, 1, 'test requirements', NULL, '1759822311_0_Black Minimal Motivation Quote LinkedIn Banner.png', '2025-10-07 07:31:51', '2025-10-07 07:31:51');

-- --------------------------------------------------------

--
-- Table structure for table `service_reviews`
--

CREATE TABLE `service_reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `rating` tinyint NOT NULL COMMENT '1 to 5',
  `review` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_reviews`
--

INSERT INTO `service_reviews` (`id`, `user_id`, `service_id`, `rating`, `review`, `created_at`, `updated_at`) VALUES
(1, 11, 1, 3, NULL, '2025-10-09 11:54:32', '2025-10-09 11:54:32'),
(2, 12, 1, 3, NULL, '2025-10-09 12:04:05', '2025-10-09 12:04:05');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('8fdWZVo2GbHldEFCtr18rBi5AX60brcL0YBenTfD', NULL, '91.231.89.126', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:134.0) Gecko/20100101 Firefox/134.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR1hmWkFOUVhKZkg0M3FzUFljTW9VWmNEbnhGT3lOeHVNS3h3UzdzaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly9hZG1pbi5xd2lraG9tLmFlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760042904),
('99RvXgUojXQz0YfWQcoFFDEaBpUZ5AozHesnEVrU', NULL, '98.81.36.6', 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia1MwMm12YjdGN0hETGJDUmJEQzBEd2tZZ0RHd3RjNkxnb1Q1UnFDSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8vYWRtaW4ucXdpa2hvbS5hZS9yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1760049678),
('DLA7e3Ml5h1MOFrO7WMrdx5z46CuHpDa9JU7voe3', NULL, '157.143.122.60', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMUY3ZDJqSFBtR0hwOGs2RXRPc1ZjUWZkaTRUOVVpdmRETWdBTzBjUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYWRtaW4ucXdpa2hvbS5hZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1760029380),
('ERRcsjuLJDZkMaPnSCbd0FDXtOGMkYTAEIK629Ko', 1, '103.178.126.229', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiUG1EempHd2ptQVp1M3o0SkloS2FvQ01RNVdvcndRSllrdFdBUEU3SCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozOToiaHR0cDovL2FkbWluLnF3aWtob20uYWUvc2VydmljZXMvMi9lZGl0Ijt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9hZG1pbi5xd2lraG9tLmFlL3NlcnZpY2VzLzEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc1OTk4MTQ0MTt9fQ==', 1760012729),
('fZSxW7NjxHQP6KcmYlvWd6F09EWE6YZFU7dDNz47', NULL, '157.143.122.60', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiczJMT09zRXd4QTNYbElucU1Pd1Ria0daVUVreTQ1cGVRMTI0a0dnbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYWRtaW4ucXdpa2hvbS5hZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1760055571),
('hMUrDhEamV4NuLAuooAmfR7mXLgWULXsCTMAqrvJ', NULL, '91.231.89.33', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:134.0) Gecko/20100101 Firefox/134.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUlRrd0x3RnU5RmpFRlVQT2pLWDhDTlhBWXN3VmNXTzFNSXZxT3RoYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYWRtaW4ucXdpa2hvbS5hZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1760042865),
('I2eEyduqQy7Ss7GMbZ4SKTEKKa64r0mRN3rW6dlZ', NULL, '23.27.145.171', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoielVJZUx2eTVPS3VYUXBHZzBNYXJXT0ZXWGRvQjJ5cEMyVWxlOGUydCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYWRtaW4ucXdpa2hvbS5hZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1760020106),
('NFFd572IgQEuXdYIw9XXCdFRLu9e3G23lPAH1FQD', NULL, '23.27.145.33', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVzN1VU12TEZUOVBKazg4ek5IalozQzdIMTQ1SzEzN3ZIdmUzRkFWSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYWRtaW4ucXdpa2hvbS5hZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1760010113),
('NSNcBSc87NogzE57rm8cOtO2XJjtj8xtwmrTT4Q0', NULL, '143.110.165.147', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoickluMlJUWDVkSUFyY3kyZzN5U2xTcDdPR2kza1JocEVVZXJkWk5wSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly9hZG1pbi5xd2lraG9tLmFlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760045165),
('UKweqzSdSufTQBuOvli80B1JoCxFhZOzh3OR7Vn8', NULL, '143.110.165.147', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidXhMeHRkSW1oMDNXVjBnRXNLUUFXTTF5S08xandXdnJUTmh4SGw2UiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYWRtaW4ucXdpa2hvbS5hZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1760045167),
('Z2pigJOhwPMVioemq37AsYWBsahZh96Ui9SkZLRC', 1, '103.178.126.229', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiT1VHZnc1NTlqSHFpMmlWN0h3MjNGNlZxYWkzVVI5bFA0dWU4MXI5biI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNDoiaHR0cDovL2FkbWluLnF3aWtob20uYWUvc2VydmljZXMvMSI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI5OiJodHRwOi8vYWRtaW4ucXdpa2hvbS5hZS9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzYwMDY3ODcwO319', 1760067871);

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `name`, `description`, `status`, `created_at`, `updated_at`, `image`) VALUES
(1, 1, 'spatula waxing', NULL, 'active', '2025-10-02 23:48:08', '2025-10-07 07:32:17', '1759822337.jpg'),
(2, 2, 'Cleaning Services', 'Professional cleaning and hygiene services', 'active', '2025-10-03 00:06:31', '2025-10-07 08:25:23', '1759825523.jpg'),
(3, 2, 'Laundry Services', 'Clothing and fabric care services', 'active', '2025-10-03 00:06:31', '2025-10-09 10:16:24', '1760004984.jpg'),
(4, 2, 'Pest & Disinfection Services', 'Pest control and disinfection services', 'active', '2025-10-03 00:06:31', '2025-10-09 10:16:34', '1760004994.jpg'),
(5, 2, 'Moving & Relocation Services', 'Professional moving and relocation assistance', 'active', '2025-10-03 00:06:31', '2025-10-09 10:16:45', '1760005005.jpg'),
(6, 3, 'Child Care', 'Childcare and nanny services', 'active', '2025-10-03 00:06:31', '2025-10-09 10:16:57', '1760005017.png'),
(7, 3, 'Post-Maternity Care', 'Post-delivery maternal care and assistance', 'active', '2025-10-03 00:06:31', '2025-10-09 10:17:06', '1760005026.jpg'),
(8, 3, 'Education Support', 'Tutoring and educational assistance services', 'active', '2025-10-03 00:06:31', '2025-10-09 10:17:16', '1760005036.jpg'),
(9, 3, 'Food Services', 'Home cooking and meal preparation services', 'active', '2025-10-03 00:06:31', '2025-10-09 10:17:24', '1760005044.jpg'),
(10, 3, 'Transportation', 'Family transportation and driver services', 'active', '2025-10-03 00:06:31', '2025-10-09 10:17:46', '1760005066.jpg'),
(11, 4, 'Salon Services', 'Professional hair, beauty, and grooming services', 'active', '2025-10-03 00:06:31', '2025-10-09 10:17:58', '1760005078.png'),
(12, 4, 'Spa Services', 'Relaxation and wellness spa treatments', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(13, 5, 'Window Treatments', 'Curtain and blind installation and repair services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(14, 5, 'Painting & Decoration', 'Interior painting and decorative services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(15, 5, 'Carpentry Services', 'Woodworking and furniture repair services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(16, 5, 'Appliance Maintenance', 'Home appliance repair and maintenance services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(17, 5, 'Landscape Maintenance', 'Garden and outdoor space maintenance', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(18, 6, 'Vehicle Services', 'Vehicle maintenance and recovery services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(19, 6, 'Legal Services', 'Legal assistance and renewal services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(20, 7, 'Event Planning', 'Party and event organization services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(21, 7, 'Pet Care Services', 'Pet care, grooming, and wellness services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `average_rating` decimal(3,1) DEFAULT '0.0',
  `address` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `image`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `active`, `is_deleted`, `deleted_at`, `average_rating`, `address`) VALUES
(1, 'Admin', 'admin@gmail.com', '1111111111', NULL, '2025-09-29 05:09:13', '$2y$12$jltDtsVVsQdN44eQPrJd0.pVa2O6sYi32GtCumw6PW.46Kw8mNGx.', '4GkAlS9jKFAWQZGzANZWdw7gRK87bWfqv1W31mz5QZYPS1S3zwJoeJhY52VT', '2025-09-29 05:09:13', '2025-09-29 05:09:13', 'admin', 0, 0, NULL, 0.0, NULL),
(2, 'Vendor', 'vendor@gmail.com', '5555555555', '1759494600.jpg', '2025-09-29 23:29:34', '$2y$12$NqOezJgewb68KlxAtXNdgu/Q2LLkiTUdNGIGysQ/tmSID6Z/rvqEu', 'G6hy1zZWFkRuw2LUk5BqPYwMHXH79f18tQ3peOGcB6QXQRxZDSlCIwIiRn2E', '2025-09-29 23:29:34', '2025-10-03 07:00:00', 'vendor', 0, 0, NULL, 0.0, 'nashik , india'),
(3, 'user', 'user@gmail.com', '0000000000', NULL, '2025-09-29 23:29:34', '$2y$12$NM1NJ4s4a8/P0XkqFAfZd.Qo502cuY8Sge78WIhyEELo8BcCyDyBS', 'aacdjLqjKY', '2025-09-29 23:29:34', '2025-10-08 06:54:05', 'user', 0, 0, NULL, 0.0, NULL),
(6, 'chetan', 'chetan@gmail.com', '7777777777', '1759492396.jpg', NULL, '$2y$12$WfWRTBZJWNAjb5Mnc7/xD.95MuIrYuYmDxBNxEc5cgML0LBkgAmzC', NULL, '2025-10-03 06:23:16', '2025-10-03 06:23:16', 'serviceprovider', 0, 0, NULL, 0.0, NULL),
(8, 'John Smith', 'john.smith@example.com', '+1987654321', NULL, NULL, '$2y$12$u9BdluXhEGt1BS9Eej4f8upoFRCymY9UB1USx6Jq5SBuMpmQ35aTa', NULL, '2025-10-03 23:43:13', '2025-10-09 12:22:32', 'serviceprovider', 1, 0, NULL, 4.0, '456 Worker Ave, City, State 12346'),
(9, 'Sarah Johnson', 'sarah.johnson@example.com', '+1555123456', NULL, NULL, '$2y$12$c7DX6OE.H.jdOyVngBmcZeY3699DTcsyHAgr.0qSnngSwifxRqAES', NULL, '2025-10-03 23:43:13', '2025-10-03 23:43:13', 'serviceprovider', 1, 0, NULL, 0.0, '789 Provider Rd, City, State 12347'),
(10, 'Mike Davis', 'mike.davis@example.com', '+1444987654', NULL, NULL, '$2y$12$XAG06NhLvozFbpTUmA4AAur9T/AMSe4Q4N3rTPu5MWgUKcbvyuJJS', NULL, '2025-10-03 23:43:13', '2025-10-03 23:43:13', 'serviceprovider', 1, 0, NULL, 0.0, '321 Service Ln, City, State 12348'),
(11, 'Alice Cooper', 'alice.cooper@example.com', '+1777123456', NULL, NULL, '$2y$12$/HfQm/RLJDhknsXiXU9sz.SnBlOiRJaz1.PhtRPZwMZioCm2vatw.', NULL, '2025-10-03 23:43:14', '2025-10-07 10:38:30', 'user', 0, 0, NULL, 0.0, '111 Customer St, City, State 12349'),
(12, 'Bob Wilson', 'bob.wilson@example.com', '+1666234567', NULL, NULL, '$2y$12$oNQLwKKC7pn0f.cEWiZmYuqRVRNgmiwcQ0OJ8romRdEMxy.yxOWt6', NULL, '2025-10-03 23:43:14', '2025-10-03 23:43:14', 'user', 0, 0, NULL, 0.0, '222 Client Ave, City, State 12350'),
(13, 'mathew', 'mathew@gmail.com', '123456543212', NULL, NULL, '$2y$12$cIiAVOIviqrMua9mw8aGtO8jAaQaDxC/Njok4w/2N9smnl6YcOT2i', NULL, '2025-10-03 23:43:14', '2025-10-08 07:33:50', 'user', 0, 0, NULL, 0.0, '333 Patron Rd, City, State 12351'),
(14, 'David Lee', 'david.lee@example.com', '+1444456789', NULL, NULL, '$2y$12$UHXTVSKimJ1b3OYegaQP1u6aLJMaT3nKMPYsAqNsmJBVXEgT5sYgq', NULL, '2025-10-03 23:43:15', '2025-10-08 06:46:11', 'user', 0, 1, '2025-10-08 06:46:11', 0.0, '444 Consumer Ln, City, State 12352'),
(15, 'new vendor', 'vendor2@gmail.com', '4556675645', '', NULL, '$2y$12$VhNY23Z7iG6.8e.6V1cwCeWsf8BWNidjIHmqCeUwfSbIa54CdzRJe', NULL, '2025-10-06 01:24:32', '2025-10-06 01:24:32', 'serviceprovider', 0, 0, NULL, 0.0, 'wanowrie , pune , india'),
(18, 'Mayur Jawale', 'mj@gmail.com', '9172593150', NULL, NULL, '$2y$12$nJPij649WccgdLkA8pxkaehPw53PEanrGnK33L9TW3XUwFAFjHaDu', NULL, '2025-10-07 09:26:42', '2025-10-07 12:07:08', 'user', 0, 0, NULL, 0.0, NULL),
(19, 'employee', 'emplyoee@gmail.com', '1234567890', '1759830982.jpg', NULL, '$2y$12$IZWnpRGhGTbE5C/hS6/THOoXFvL6A1YX8tbMrwO6WUjx4esXn.onS', NULL, '2025-10-07 09:56:22', '2025-10-07 09:56:22', 'serviceprovider', 0, 0, NULL, 0.0, 'nashik , india'),
(20, 'Mayur Jawale', 'mayur@gmail.com', '1234567895', NULL, NULL, NULL, NULL, '2025-10-07 12:21:51', '2025-10-07 12:21:51', 'user', 0, 0, NULL, 0.0, NULL),
(21, 'vivek', 'vivek@gmail.com', '123456787', NULL, NULL, NULL, NULL, '2025-10-08 05:04:28', '2025-10-08 05:04:28', 'user', 0, 0, NULL, 0.0, NULL),
(22, 'Pritesh Pawar', 'pritesh@gmail.com', '9876543210', NULL, NULL, NULL, NULL, '2025-10-08 08:21:43', '2025-10-08 08:21:43', 'user', 0, 0, NULL, 0.0, NULL),
(23, 'Mayur Jawale', 'mr@gmail.com', '0123456770', NULL, NULL, NULL, NULL, '2025-10-09 05:35:08', '2025-10-09 05:35:08', 'user', 0, 0, NULL, 0.0, NULL),
(24, 'Prathamesh', 'rathodprathamesh23@gmail.com', '9960523475', NULL, NULL, NULL, NULL, '2025-10-09 06:02:37', '2025-10-09 06:02:37', 'user', 0, 0, NULL, 0.0, NULL),
(25, 'vivek', 'vivvek@gmail.com', '1122334455', NULL, NULL, NULL, NULL, '2025-10-09 09:29:51', '2025-10-09 09:29:51', 'user', 0, 0, NULL, 0.0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_services`
--

CREATE TABLE `user_services` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_services`
--

INSERT INTO `user_services` (`id`, `user_id`, `service_id`, `created_at`, `updated_at`) VALUES
(6, 19, 1, '2025-10-07 09:56:22', '2025-10-07 09:56:22'),
(7, 19, 4, '2025-10-07 09:56:22', '2025-10-07 09:56:22'),
(8, 19, 8, '2025-10-07 09:56:22', '2025-10-07 09:56:22'),
(9, 19, 10, '2025-10-07 09:56:22', '2025-10-07 09:56:22'),
(10, 19, 11, '2025-10-07 09:56:22', '2025-10-07 09:56:22'),
(11, 19, 16, '2025-10-07 09:56:22', '2025-10-07 09:56:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookings_booking_reference_unique` (`booking_reference`),
  ADD KEY `bookings_service_id_foreign` (`service_id`),
  ADD KEY `bookings_customer_id_foreign` (`customer_id`),
  ADD KEY `bookings_service_provider_id_foreign` (`service_provider_id`),
  ADD KEY `bookings_vendor_id_foreign` (`vendor_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `complaints_user_id_foreign` (`user_id`),
  ADD KEY `complaints_assigned_admin_id_foreign` (`assigned_admin_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faqs_service_id_unique` (`service_id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `feedbacks_booking_id_unique` (`booking_id`),
  ADD KEY `feedbacks_user_id_foreign` (`user_id`),
  ADD KEY `feedbacks_service_id_foreign` (`service_id`),
  ADD KEY `feedbacks_employee_id_foreign` (`employee_id`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `processes`
--
ALTER TABLE `processes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `processes_service_id_foreign` (`service_id`);

--
-- Indexes for table `promocodes`
--
ALTER TABLE `promocodes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `promocodes_code_unique` (`code`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_category_id_foreign` (`category_id`),
  ADD KEY `services_subcategory_id_foreign` (`subcategory_id`);

--
-- Indexes for table `service_provider_reviews`
--
ALTER TABLE `service_provider_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_provider_reviews_user_id_foreign` (`user_id`),
  ADD KEY `service_provider_reviews_service_provider_id_foreign` (`service_provider_id`);

--
-- Indexes for table `service_requirements`
--
ALTER TABLE `service_requirements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_requirements_service_id_foreign` (`service_id`);

--
-- Indexes for table `service_reviews`
--
ALTER TABLE `service_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_reviews_user_id_foreign` (`user_id`),
  ADD KEY `service_reviews_service_id_foreign` (`service_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subcategories_category_id_foreign` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_services`
--
ALTER TABLE `user_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_services_user_id_service_id_unique` (`user_id`,`service_id`),
  ADD KEY `user_services_service_id_foreign` (`service_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `processes`
--
ALTER TABLE `processes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `promocodes`
--
ALTER TABLE `promocodes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_provider_reviews`
--
ALTER TABLE `service_provider_reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service_requirements`
--
ALTER TABLE `service_requirements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `service_reviews`
--
ALTER TABLE `service_reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user_services`
--
ALTER TABLE `user_services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_service_provider_id_foreign` FOREIGN KEY (`service_provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_assigned_admin_id_foreign` FOREIGN KEY (`assigned_admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `complaints_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `faqs`
--
ALTER TABLE `faqs`
  ADD CONSTRAINT `faqs_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feedbacks_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feedbacks_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feedbacks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `processes`
--
ALTER TABLE `processes`
  ADD CONSTRAINT `processes_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `services_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `service_provider_reviews`
--
ALTER TABLE `service_provider_reviews`
  ADD CONSTRAINT `service_provider_reviews_service_provider_id_foreign` FOREIGN KEY (`service_provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_provider_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_requirements`
--
ALTER TABLE `service_requirements`
  ADD CONSTRAINT `service_requirements_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_reviews`
--
ALTER TABLE `service_reviews`
  ADD CONSTRAINT `service_reviews_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_services`
--
ALTER TABLE `user_services`
  ADD CONSTRAINT `user_services_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_services_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
