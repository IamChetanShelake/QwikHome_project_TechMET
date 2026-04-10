-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 17, 2025 at 05:11 AM
-- Server version: 8.0.43
-- PHP Version: 8.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qwikhom_webadmin`
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
(1, 11, '\"mayur, 9172593150\"', '\"near business bay\"', NULL, 0, '2025-10-09 05:57:35', '2025-10-16 13:07:29'),
(3, 11, '\"mmm, 234567876\"', '\"near business cpmex\"', 'home', 0, '2025-10-15 04:36:42', '2025-10-16 13:07:29'),
(4, 11, '\"mmm, 21344\"', '\"near sadfbv cpmex\"', 'home', 0, '2025-10-15 04:37:06', '2025-10-16 13:07:29'),
(5, 11, '\"mmm, 21344\"', '\"near sadfbv cpmex\"', 'home', 0, '2025-10-15 04:38:23', '2025-10-16 13:07:29'),
(6, 11, '\"mmm, 21344\"', '\"near sadfbv cpmexcvfev\"', 'home', 1, '2025-10-15 04:38:41', '2025-10-16 13:07:29'),
(7, 11, '\"mmm, 21344\"', '\"near cvmfoqnefwrj cpmexcvfev\"', 'home', 0, '2025-10-15 04:39:35', '2025-10-16 13:07:29'),
(8, 11, '\"mmm, 234567876\"', '\"near business cpmex\"', 'home', 0, '2025-10-15 06:32:05', '2025-10-16 13:07:29'),
(18, 18, '\"prathamesh\"', '\"namak,  Nashik, Maharashtra, 129, Tidke Colony, Nashik, Maharashtra, 129, Tidke Colony, Nashik, Maharashtra\"', 'other', 0, '2025-10-15 09:36:09', '2025-10-16 14:12:19'),
(27, 18, '\"meh\"', '\"kal, 129, Nashik, Maharashtra\"', 'home', 0, '2025-10-15 10:10:57', '2025-10-16 14:12:19'),
(31, 18, '\"pratham\"', '\"suyojit lawns C17, Kamgar Nagar, Satpur Colony, Nashik, Maharashtra, India\"', 'home', 1, '2025-10-15 11:22:30', '2025-10-16 14:12:19'),
(32, 18, '\"niiiiilesh\"', '\"business bay 4th floor, 129, Tidke Colony, Nashik, Maharashtra, 129, Tidke Colony, Nashik, Maharashtra\"', 'home', 0, '2025-10-15 12:16:01', '2025-10-16 14:12:19'),
(33, 11, '\"cdhfb , 21344\"', '\"near cvmfoqnefwrj cpmexcvfev\"', 'home', 0, '2025-10-16 04:13:45', '2025-10-16 13:07:29'),
(35, 11, '\"mmm, 234567876\"', '\"near business cpmex\"', 'home', 0, '2025-10-16 11:08:44', '2025-10-16 13:07:29'),
(36, 11, '\"mmm, 234567876\"', '\"near business cpmex\"', 'other', 0, '2025-10-16 11:08:55', '2025-10-16 13:07:29');

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
(17, NULL, NULL, 'active', '1760501040_.jpg', '2025-10-08 08:38:50', '2025-10-15 04:04:00'),
(18, NULL, NULL, 'active', '1760501051_.jpg', '2025-10-08 08:38:50', '2025-10-15 04:04:11'),
(19, NULL, NULL, 'active', '1760501062_.jpg', '2025-10-08 08:38:50', '2025-10-15 04:04:22');

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
(20, 'title1', NULL, 'active', '1759920603_0_68e641db21fcb.jpg', '2025-10-08 09:20:03', '2025-10-08 09:20:03'),
(21, 'title2', NULL, 'active', '1759920603_1_68e641db239df.jpg', '2025-10-08 09:20:03', '2025-10-08 09:20:03'),
(22, 'title3', NULL, 'active', '1759920603_2_68e641db23db1.jpg', '2025-10-08 09:20:03', '2025-10-08 09:20:03');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('active','abandoned','converted','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `expires_at` timestamp NULL DEFAULT NULL,
  `applied_coupons` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `cart_metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint UNSIGNED NOT NULL,
  `cart_id` bigint UNSIGNED NOT NULL,
  `item_type` enum('service','subscription_plan','combo_offer','addon_only') COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` bigint UNSIGNED NOT NULL,
  `item_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `quantity` int NOT NULL DEFAULT '1',
  `providers_count` int NOT NULL DEFAULT '1',
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `service_frequency_id` bigint UNSIGNED DEFAULT NULL,
  `scheduled_date` date DEFAULT NULL,
  `preferred_time` time DEFAULT NULL,
  `subscription_plan_id` bigint UNSIGNED DEFAULT NULL,
  `auto_renew` tinyint(1) DEFAULT NULL,
  `combo_offer_id` bigint UNSIGNED DEFAULT NULL,
  `combo_services_config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `combo_discount_applied` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `selected_addons` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `addon_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `include_material` tinyint(1) NOT NULL DEFAULT '0',
  `base_price` decimal(10,2) NOT NULL,
  `addons_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `custom_configurations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `customer_notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `special_requirements` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `preferred_service_provider_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('active','removed','saved_for_later') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `item_metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

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
(1, 'Waxing', NULL, 'active', '2025-10-02 23:47:37', '2025-10-15 04:07:59', '1760501279.jpg'),
(2, 'Core Home Services', 'Essential cleaning, maintenance, and home care services', 'active', '2025-10-03 00:06:31', '2025-10-15 04:08:18', '1760501298.jpg'),
(3, 'Family Support', 'Support services for families including childcare and assistance', 'active', '2025-10-03 00:06:31', '2025-10-15 04:08:31', '1760501311.jpg'),
(4, 'Personal Care', 'Beauty, grooming, and personal wellness services', 'active', '2025-10-03 00:06:31', '2025-10-16 06:40:32', '1760596832.jpg'),
(5, 'Home Maintenance & Interior', 'Home improvement, repairs, and maintenance services', 'active', '2025-10-03 00:06:31', '2025-10-16 06:40:42', '1760596842.jpg'),
(6, 'Vehicle & Legal Services', 'Vehicle maintenance and legal assistance services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(7, 'Lifestyle & Events', 'Event planning and lifestyle enhancement services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(8, 'Home Services', NULL, 'active', '2025-10-03 23:43:15', '2025-10-03 23:43:15', 'category1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `combo_offers`
--

CREATE TABLE `combo_offers` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `original_price` decimal(10,2) NOT NULL,
  `combo_price` decimal(10,2) NOT NULL,
  `discount_percentage` decimal(5,2) DEFAULT NULL,
  `fixed_discount` decimal(10,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `max_bookings_per_customer` int DEFAULT NULL,
  `usage_limit` int DEFAULT NULL,
  `used_count` int NOT NULL DEFAULT '0',
  `terms_conditions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `status` enum('active','inactive','expired','draft') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `custom_fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `combo_offer_services`
--

CREATE TABLE `combo_offer_services` (
  `id` bigint UNSIGNED NOT NULL,
  `combo_offer_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `pricing_type` enum('standard','included','discounted') COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_price` decimal(10,2) DEFAULT NULL,
  `discount_percentage` decimal(5,2) DEFAULT NULL,
  `custom_configurations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

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
  `applicable_to` enum('all_services','specific_services') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'all_services',
  `service_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `description`, `discount_type`, `discount_value`, `expiry_date`, `usage_limit`, `used_count`, `status`, `applicable_to`, `service_ids`, `created_at`, `updated_at`) VALUES
(1, 'QHSAVE30', 'this will save 30 AED fewtgfdsvb', 'percentage', 30.00, '2025-09-24 10:47:00', NULL, 0, 1, 'all_services', NULL, '2025-10-03 00:47:50', '2025-10-03 00:57:42'),
(3, 'WERTY', NULL, 'percentage', 20.00, '2025-10-26 16:11:00', NULL, 0, 1, 'all_services', NULL, '2025-10-04 05:11:51', '2025-10-04 05:11:51');

-- --------------------------------------------------------

--
-- Table structure for table `disclaimers`
--

CREATE TABLE `disclaimers` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `disclaimers`
--

INSERT INTO `disclaimers` (`id`, `title`, `content`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Disclaimer', 'Welcome to Qwikhom — a technology-based platform connecting users with verified home and personal service professionals.\r\nWhile we strive to ensure accuracy, reliability, and quality in all information and services displayed on our website and mobile application, Qwikhom does not guarantee or warrant that all content, information, or services will always be accurate, complete, or up to date.\r\n________________________________________\r\n1. Service Provider Relationship\r\nQwikhom acts solely as a facilitator between customers and independent service professionals.\r\nAll services are rendered by third-party professionals who operate as independent contractors, not employees or agents of Qwikhom.\r\nWe are not directly responsible for the conduct, actions, or outcomes of services performed by these professionals.\r\n________________________________________\r\n2. Accuracy of Information\r\nAll prices, service details, and promotional offers listed on our Platform are subject to change without prior notice.\r\nQwikhom makes reasonable efforts to ensure information accuracy, but we do not guarantee that all data, descriptions, or visuals are error-free, current, or applicable to every customer situation.\r\n________________________________________\r\n3. Limitation of Liability\r\nTo the fullest extent permitted by UAE law, Qwikhom shall not be held liable for:\r\n•	Any direct, indirect, incidental, or consequential damages arising from service use or reliance on Platform content.\r\n•	Property loss, damage, or personal injury resulting from services provided by third-party professionals.\r\n•	Delays, cancellations, or interruptions caused by external factors beyond Qwikhom’s control.\r\nUsers are advised to exercise discretion and verify all service-related details before booking.\r\n________________________________________\r\n4. External Links\r\nOur Platform may include links to third-party websites or applications for user convenience.\r\nQwikhom does not control, endorse, or take responsibility for the content, products, or policies of these third-party sites.\r\n________________________________________\r\n5. No Guarantee of Outcomes\r\nAlthough all Qwikhom service partners are trained and verified, results may vary depending on service conditions, user requirements, and environment.\r\nQwikhom does not promise guaranteed outcomes, performance, or timelines for any service.\r\n________________________________________\r\n6. Jurisdiction\r\nThis Disclaimer shall be governed by and interpreted in accordance with the laws of the United Arab Emirates.\r\nAny disputes shall fall under the exclusive jurisdiction of the courts in Dubai, UAE.\r\n________________________________________\r\n7. Contact Us\r\nIf you have questions or concerns regarding this Disclaimer, please contact us:\r\n📧 support@qwikhom.com \r\n🌐 www.qwikhom.com', 'active', '2025-10-14 02:58:05', '2025-10-14 02:58:05');

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
(2, 'It means the admin has a dashboard/section to handle problems raised by users.', 'marketplace, or e-commerce platforms).\r\n\r\nIt means the admin has a dashboard/section to handle problems raised by users.\r\n\r\n🔹 Typical Features:\r\n\r\nComplaint/Dispute Submission\r\n\r\nCustomers or service providers can submit a complaint (e.g., late delivery, poor service, payment issue, fraud).\r\n\r\nUsually includes details: order ID / user ID, complaint category, description, attachments.\r\n\r\nAdmin Tracking\r\n\r\nAdmin can see all complaints in a table with status (Pending, In Review, Resolved, Rejected).\r\n\r\nFilter/search by date, type, user, or status.\r\n\r\nTwo-way Communication\r\n\r\nSometimes, a chat-like thread where admin and users can exchange messages about the issue.\r\n\r\nResolution Actions\r\n\r\nAdmin can mark th', 1, 2, '2025-10-03 03:25:27', '2025-10-03 03:38:23'),
(3, 'question one', '<p>answe one&nbsp;</p>', 1, 49, '2025-10-16 06:12:29', '2025-10-16 06:12:29'),
(4, 'question two', '<p>answer two</p>', 1, 49, '2025-10-16 06:12:29', '2025-10-16 06:12:29'),
(5, 'question three', '<p>answer three</p>', 1, 49, '2025-10-16 06:13:13', '2025-10-16 06:13:13');

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
(26, '2025_10_04_052001_create_processes_table', 18),
(27, '2025_10_07_161425_make_password_nullable_in_users_table', 19),
(28, '2025_10_08_115100_add_is_deleted_and_deleted_at_columns_to_users_table', 20),
(29, '2025_10_08_125042_create_banners_table', 21),
(30, '2025_10_08_125108_create_campaigns_table', 22),
(31, '2025_10_08_125056_create_offers_table', 23),
(32, '2025_10_08_150059_add_qwikpick_and_beauty_easy_columns_to_services_table', 24),
(33, '2025_10_09_103632_create_service_frequencies_table', 25),
(34, '2025_10_09_103653_create_service_addons_table', 26),
(35, '2025_10_09_103716_create_service_subscription_plans_table', 27),
(36, '2025_10_09_103739_create_combo_offers_table', 28),
(37, '2025_10_09_103803_create_combo_offer_services_table', 29),
(38, '2025_10_09_103833_create_carts_table', 30),
(39, '2025_10_09_103855_create_cart_items_table', 31),
(40, '2025_10_09_110542_create_addresses_table', 32),
(41, '2025_10_09_124726_add_type_to_addresses_table', 33),
(42, '2025_10_09_150116_create_service_reviews_table', 34),
(43, '2025_10_09_150203_create_service_provider_reviews_table', 35),
(44, '2025_10_09_150953_add_average_rating_to_services_table', 36),
(45, '2025_10_09_165000_add_average_rating_to_users_table', 37),
(46, '2025_10_10_090814_create_disclaimers_table', 38),
(47, '2025_10_10_090951_create_privacy_policies_table', 38),
(48, '2025_10_10_091020_create_refund_policies_table', 38),
(49, '2025_10_10_091042_create_terms_conditions_table', 38),
(50, '2024_01_15_000000_create_service_materials_table', 39),
(51, '2025_10_13_105545_add_duration_and_description_fields_to_services_table', 40),
(52, '2025_10_13_105809_create_service_frequency_options_table', 41),
(53, '2025_10_03_111307_drop_description_from_service_requirements_table', 42),
(54, '2025_10_06_061826_add_active_column_to_users_table', 42),
(55, '2025_10_07_140633_rename_service_image_to_media_in_services_table', 43),
(56, '2025_10_07_141124_add_vendor_documents_and_payment_terms_to_users_table', 43),
(57, '2025_10_07_143411_migrate_existing_service_images_to_media', 44),
(58, '2025_10_13_145430_create_service_offers_table', 44),
(59, '2025_10_08_094536_add_payment_terms_to_user_services_table', 45),
(60, '2025_10_13_151800_create_push_notifications_table', 45),
(61, '2025_10_13_151900_create_notifications_table', 45),
(62, '2025_10_13_154230_add_service_selection_to_coupons_table', 45),
(63, '2025_10_13_164345_add_fcm_token_to_users_table', 45),
(64, '2025_10_14_154419_create_wishlists_table', 46);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(13, 'App\\Models\\User', 19, 'API Token', 'bada8f3f9d96951e5f6947b9307679d7e99f3f3930cf927aac7f9f667e8397a4', '[\"*\"]', NULL, NULL, '2025-10-16 14:37:46', '2025-10-16 14:37:46'),
(14, 'App\\Models\\User', 18, 'API Token', '66a3309337805aeae18749b9ea5cd302bb4f95dc46ecff65830a7d4b6dac705d', '[\"*\"]', NULL, NULL, '2025-10-17 08:38:26', '2025-10-17 08:38:26');

-- --------------------------------------------------------

--
-- Table structure for table `privacy_policies`
--

CREATE TABLE `privacy_policies` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `privacy_policies`
--

INSERT INTO `privacy_policies` (`id`, `title`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, 'privacy policy', 'Effective Date: [Insert Date]\nWelcome to Qwikhom\nThis Privacy Policy explains how we collect, use, disclose, and safeguard your personal\ninformation when you visit or use our website, mobile application, and related services.\nBy accessing or using Qwikhom, you agree to the practices described in this Policy. If you do\nnot agree, please discontinue use of the Platform.\n1. Information We Collect\nWe collect information to provide, improve, and personalize our services:\n1.1 Personal Information you provide us:\n Name, email address, phone number, and address\n Payment details (processed through secure gateways; Qwikhom does not store full\ncard data)\n Location, booking details, and service preferences\n Identification documents (if required for verification)\n1.2 Automatically collected information:\n Device type, operating system, IP address, and browser details\n Usage data such as pages visited, time spent, and app activity\n Cookies and similar tracking technologies (see Section 8)\n2. How We Use Your Information\nWe may use your information to:\n Process bookings, payments, and confirmations\n Communicate service updates, offers, or promotions\n Verify your identity and prevent fraud\n Improve our Platform and service quality\n Comply with applicable UAE laws and regulations\n\n3. How We Share Information\nWe may share your information only when necessary to:\n Assign service professionals (“Partners”) to fulfill your booking\n Process payments through secure third-party payment providers\n Comply with legal or regulatory obligations\n Respond to law-enforcement or government requests\nWe do not sell, rent, or trade your personal data to third parties for marketing purposes.\n4. Data Retention\nYour personal information is retained only for as long as needed to fulfill the purposes\ndescribed in this Policy or as required by UAE law. When data is no longer required, it is\nsecurely deleted or anonymized.\n\n\n5. Data Security\nWe employ industry-standard administrative, technical, and physical safeguards to protect\nyour information from unauthorized access, loss, misuse, or alteration.\nHowever, no electronic storage or transmission is completely secure; you use the Platform at\nyour own risk.\n6. Your Rights\nUnder UAE data-protection laws, you have the right to:\n Access the personal data we hold about you\n Request correction or deletion of inaccurate or outdated information\n Withdraw consent to marketing communications at any time\n Request restriction or objection to data processing (subject to legal limits)\nRequests can be sent to privacy@qwikhom.com or support@qwikhom.com.\n7. Third-Party Links and Services\nOur Platform may include links to external websites or services.\nWe are not responsible for the privacy practices or content of third-party websites. Please\nreview their policies before sharing any personal data.\n8. Cookies and Tracking Technologies\nQwikhom uses cookies to enhance user experience, remember preferences, and analyze\nusage.\nYou can modify your browser settings to block or delete cookies; however, some features of\nthe Platform may not function properly if cookies are disabled.\n9. Children’s Privacy\nOur services are intended for adults aged 18 and above.\nWe do not knowingly collect personal data from minors. If we learn that data from a child has\nbeen collected, we will delete it promptly.\n10. Updates to This Policy\nQwikhom may update this Privacy Policy periodically. Any changes will be posted on this\npage with an updated “Effective Date.”\nContinued use of the Platform after such updates constitutes your acceptance of the revised\nPolicy.\n11. Contact Us\nFor questions or concerns regarding this Privacy Policy or your personal data, please contact:\n\n📧support@qwikhom.com\n🌐www.qwikhom.com\n📍 Dubai, United Arab Emirates', 'active', '2025-10-14 02:50:00', '2025-10-14 03:12:55');

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
(5, 32, 'test', 'test', '', 0, '2025-10-10 09:49:11', '2025-10-10 09:49:11'),
(9, 33, 'test', 'test', '', 0, '2025-10-10 10:13:11', '2025-10-10 10:13:11'),
(10, 34, 'Molestias enim ex et', 'Expedita similique s', '', 0, '2025-10-10 10:15:55', '2025-10-10 10:15:55'),
(11, 35, 'Pariatur Ut archite', 'Sequi voluptatem ull', '', 0, '2025-10-10 10:35:37', '2025-10-10 10:35:37'),
(12, 36, 'Ullamco eveniet et', 'Officiis mollitia ex', '', 0, '2025-10-10 10:48:51', '2025-10-10 10:48:51'),
(13, 37, 'Unde praesentium por', 'Illo nihil qui ipsam', '', 0, '2025-10-13 03:19:09', '2025-10-13 03:19:09'),
(15, 38, 'Rerum aliquam volupt', 'Quis aliquid pariatu', '', 0, '2025-10-13 03:54:01', '2025-10-13 03:54:01'),
(16, 39, 'Consectetur iure iur', 'Aliqua Quia nobis n', '', 0, '2025-10-13 03:55:10', '2025-10-13 03:55:10'),
(17, 40, 'Vero velit sit mol', 'Adipisci nostrud con', '', 0, '2025-10-13 04:15:14', '2025-10-13 04:15:14'),
(18, 41, 'Quia quo ut ea id do', 'Quasi pariatur Est', '', 0, '2025-10-13 04:25:22', '2025-10-13 04:25:22'),
(21, 44, 'Expedita repudiandae', 'Consequatur eos qui', '', 0, '2025-10-13 04:55:13', '2025-10-13 04:55:13'),
(22, 45, 'Omnis ea culpa odit', 'Eaque incidunt volu', '', 0, '2025-10-13 05:06:38', '2025-10-13 05:06:38'),
(23, 46, 'Suscipit et saepe et', 'Duis elit dolor eos', '', 0, '2025-10-13 05:08:44', '2025-10-13 05:08:44'),
(24, 47, 'Deleniti eveniet ut', 'Quia aut eiusmod eiu', '', 0, '2025-10-13 05:11:18', '2025-10-13 05:11:18'),
(26, 48, 'test', 'test', '1760340037_process_0_61JfZmU4WjL.jpg', 0, '2025-10-13 05:50:37', '2025-10-13 05:50:37'),
(27, 1, 'test proces', 'process desc', '', 0, '2025-10-15 07:27:00', '2025-10-15 07:27:00'),
(52, 51, 'Ratione ea perferend', 'Inventore dolorem vo', '', 0, '2025-10-16 11:02:02', '2025-10-16 11:02:02'),
(53, 52, 'Sunt quas illo labor', 'Nihil occaecat conse', '', 0, '2025-10-16 11:03:23', '2025-10-16 11:03:23'),
(54, 49, 'process one', 'dasv', '', 0, '2025-10-16 12:44:46', '2025-10-16 12:44:46'),
(55, 49, 'process two', 'sfd', '', 1, '2025-10-16 12:44:46', '2025-10-16 12:44:46');

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
-- Table structure for table `push_notifications`
--

CREATE TABLE `push_notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `audience` enum('vendor','serviceprovider','user','all') COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `refund_policies`
--

CREATE TABLE `refund_policies` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `refund_policies`
--

INSERT INTO `refund_policies` (`id`, `title`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, 'refund & Cancellation policy', 'At Qwikhom, customer satisfaction is our top priority. We aim to provide a smooth and reliable experience across all home and personal care services.\r\nThis Refund & Cancellation Policy outlines the terms under which cancellations, refunds, or reschedules may be processed.\r\n________________________________________\r\n1. Service Bookings\r\nWhen you book a service through the Qwikhom platform (website or mobile app), you agree to the specific terms, pricing, and timing mentioned for that booking.\r\nAll bookings are confirmed only after successful payment or confirmation by Qwikhom.\r\n________________________________________\r\n2. Cancellation by Customer\r\nYou may cancel or reschedule your booking before the service professional has been dispatched.\r\n•	Free cancellation: Available if you cancel at least 2 hours before the scheduled service time.\r\n•	Late cancellation: If you cancel within 2 hours of the service, a cancellation fee may apply.\r\n•	No-show: If the professional arrives and the customer is unavailable or unresponsive, the booking may be marked as completed and no refund will be issued.\r\n________________________________________\r\n3. Cancellation by Qwikhom\r\nQwikhom reserves the right to cancel any booking due to:\r\n•	Unavailability of service professionals\r\n•	Safety concerns or incorrect location details\r\n•	Unforeseen technical or operational issues\r\nIn such cases, a full refund will be initiated to your original payment method.\r\n________________________________________\r\n4. Refund Eligibility\r\nRefunds may be issued in the following cases:\r\n•	Service cancelled by Qwikhom\r\n•	Customer cancelled within the allowed cancellation window\r\n•	Service not delivered or completed due to professional’s non-arrival or quality issues verified by Qwikhom\r\nOnce the issue is reviewed and approved, the refund will be processed within 7 to 10 working days (depending on your bank or payment provider).\r\nAll refunds are processed in UAE Dirhams (AED) via the original mode of payment.\r\n________________________________________\r\n5. Non-Refundable Situations\r\nRefunds will not be issued if:\r\n•	The customer provided incomplete or incorrect service details.\r\n•	The service was completed as per booking but did not meet personal expectations without valid quality proof.\r\n•	The customer violated Qwikhom’s Terms & Conditions or misused promotional offers.\r\n________________________________________\r\n6. Rescheduling\r\nCustomers can request rescheduling up to 2 hours before the original service time, subject to professional availability.\r\nQwikhom will make every effort to accommodate the new schedule without additional charges.\r\n________________________________________\r\n7. Quality & Service Concerns\r\nIf you are not satisfied with the service provided, you may raise a complaint within 24 hours of service completion by contacting our support team.\r\nQwikhom will review the issue, verify the concern, and take appropriate action which may include partial refund, complimentary reservice, or partner replacement.\r\n________________________________________\r\n8. Contact Us\r\nFor refund, cancellation, or reschedule requests, please reach out to:\r\n📧 support@qwikhom.com\r\n🌐 www.qwikhom.com\r\nOur support team is available 7 days a week to assist you.\r\n9. Jurisdiction\r\nThis Refund & Cancellation Policy is governed by the laws of the United Arab Emirates, and any disputes shall be subject to the exclusive jurisdiction of the courts in Dubai, UAE.', 'active', '2025-10-14 02:50:15', '2025-10-14 02:59:16');

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
  `price_onetime_description` text COLLATE utf8mb4_unicode_ci,
  `duration_onetime` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price_weekly` decimal(10,2) DEFAULT NULL,
  `price_weekly_description` text COLLATE utf8mb4_unicode_ci,
  `price_monthly` decimal(10,2) DEFAULT NULL,
  `price_monthly_description` text COLLATE utf8mb4_unicode_ci,
  `price_yearly` decimal(10,2) DEFAULT NULL,
  `price_yearly_description` text COLLATE utf8mb4_unicode_ci,
  `is_arabic` tinyint(1) NOT NULL DEFAULT '0',
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `media` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qwikpick` tinyint(1) NOT NULL DEFAULT '0',
  `beauty_and_easy` tinyint(1) NOT NULL DEFAULT '0',
  `average_rating` decimal(3,1) NOT NULL DEFAULT '0.0',
  `total_reviews` int NOT NULL DEFAULT '0'
) ;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `category_id`, `subcategory_id`, `name`, `description`, `whats_include`, `short_description`, `price_onetime`, `price_onetime_description`, `duration_onetime`, `price_weekly`, `price_weekly_description`, `price_monthly`, `price_monthly_description`, `price_yearly`, `price_yearly_description`, `is_arabic`, `duration`, `status`, `created_at`, `updated_at`, `media`, `qwikpick`, `beauty_and_easy`, `average_rating`, `total_reviews`) VALUES
(1, 1, 1, 'salon', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent ac sem euismod, facilisis augue ut, porttitor eros. Integer vitae ligula id orci hendrerit luctus ut vel libero. Curabitur euismod purus vitae turpis sodales, at varius orci tincidunt. Maecenas blandit feugiat nunc, nec fermentum sem mattis ac. Suspendisse potenti. Sed sit amet purus a velit cursus consequat. Donec ultricies nisi sit amet luctus sodales. Vivamus vulputate, ligula sed laoreet dictum, magna ex cursus justo, nec eleifend elit justo eget erat. Quisque eu odio lorem. Vestibulum interdum diam id nibh lacinia, a bibendum nisl hendrerit. Morbi fermentum, est nec aliquam gravida, justo libero efficitur purus, non volutpat sapien neque eget arcu. Pellentesque dignissim nunc in felis cursus fermentum. Aliquam erat volutpat. Integer sit amet elit leo. Sed ac libero luctus, fringilla est sed, euismod velit.', '[\"test inclusion desc\"]', 'long desc added', 117.00, NULL, NULL, 118.00, NULL, 119.00, NULL, 200.00, NULL, 1, '2  hours', 'active', '2025-10-02 23:48:49', '2025-10-15 07:27:00', '1759819362_Black Minimal Motivation Quote LinkedIn Banner.png', 0, 1, 4.0, 32),
(2, 2, 2, 'Maids – Subscription & on-demand cleaning', 'Professional house cleaning services available on subscription or one-time basis', NULL, NULL, 500.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2-4 hours', 'active', '2025-10-03 00:06:31', '2025-10-08 09:40:19', NULL, 0, 1, 3.0, 20),
(3, 2, 2, 'Deep Cleaning – Kitchen, bathroom, full home', 'Thorough deep cleaning of kitchen, bathroom, and entire home', NULL, NULL, 2000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '4-6 hours', 'active', '2025-10-03 00:06:31', '2025-10-08 09:40:21', NULL, 0, 1, 2.0, 15),
(4, 2, 2, 'Move-in/Move-out Cleaning', 'Specialized cleaning service for property transitions', NULL, NULL, 3000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '6-8 hours', 'active', '2025-10-03 00:06:31', '2025-10-08 09:40:26', NULL, 1, 0, 0.0, 0),
(5, 2, 2, 'Refrigerator Cleaning', 'Professional refrigerator deep cleaning and sanitization', NULL, NULL, 800.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2 hours', 'active', '2025-10-03 00:06:31', '2025-10-08 09:40:27', NULL, 1, 0, 0.0, 0),
(6, 2, 3, 'Laundry at Home – Ironing, folding, wardrobe assistance', 'Complete laundry service including ironing, folding, and wardrobe organization', NULL, NULL, 600.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '3-4 hours', 'active', '2025-10-03 00:06:31', '2025-10-08 09:40:29', NULL, 1, 0, 0.0, 0),
(7, 2, 3, 'Laundry Collection – Clothes, carpets, shoes', 'Professional laundry collection service for clothes, carpets, and shoes', NULL, NULL, 300.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2 hours', 'active', '2025-10-03 00:06:31', '2025-10-08 09:40:16', NULL, 0, 1, 0.0, 0),
(8, 2, 4, 'Pest Control', 'Professional pest management and extermination services', NULL, NULL, 1500.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2-3 hours', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL, 0, 0, 0.0, 0),
(9, 2, 4, 'Disinfection Services', 'Complete disinfection and sanitization of home spaces', NULL, NULL, 1000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2-3 hours', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL, 0, 0, 0.0, 0),
(10, 2, 5, 'Movers and Packers for home/office relocation', 'Professional moving and packing services for home or office relocation', NULL, NULL, 5000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Full day', 'active', '2025-10-03 00:06:31', '2025-10-08 09:40:32', NULL, 1, 0, 0.0, 0),
(11, 3, 6, 'Nanny Services', 'Professional childcare and nanny services for families', NULL, NULL, 800.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '4-8 hours', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL, 0, 0, 0.0, 0),
(12, 3, 7, 'Post-Maternity Care Staff', 'Post-delivery maternal care and newborn assistance', NULL, NULL, 1200.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '12-24 hours', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL, 0, 0, 0.0, 0),
(14, 3, 9, 'Cook Services – 2 meals/day, 2-hour schedule', 'Home cooking service providing 2 meals per day with 2-hour schedule', NULL, NULL, 1000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2 hours', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL, 0, 0, 0.0, 0),
(16, 4, 11, 'Salon Services – Unisex + kids (hair, waxing, facial, grooming)', 'Complete salon services including hair, waxing, facial, and grooming for all ages', NULL, NULL, 800.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '1-3 hours', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL, 0, 0, 0.0, 0),
(17, 4, 12, 'Spa Services – Massage, mani-pedi', 'Professional spa services including massage therapy and pedicure', NULL, NULL, 1200.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '1-2 hours', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL, 0, 0, 0.0, 0),
(18, 5, 13, 'Curtains & Blinds – Installation & repair', 'Professional installation and repair of curtains and blinds', NULL, NULL, 1000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2-4 hours', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL, 0, 0, 0.0, 0),
(19, 5, 14, 'Painting Services', 'Professional interior and exterior painting services', NULL, NULL, 2500.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Full day', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL, 0, 0, 0.0, 0),
(20, 5, 15, 'Carpentry & Furniture Repair', 'Woodworking and furniture repair and restoration services', NULL, NULL, 1200.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2-6 hours', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL, 0, 0, 0.0, 0),
(21, 5, 16, 'Home Appliance Maintenance – AC, fridge, washing machine', 'Maintenance and repair services for AC, refrigerator, and washing machine', NULL, NULL, 1200.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '1-3 hours', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL, 0, 0, 0.0, 0),
(22, 5, 17, 'Landscape Maintenance', 'Garden and outdoor space maintenance and landscaping', NULL, NULL, 800.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2-4 hours', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL, 0, 0, 0.0, 0),
(23, 6, 18, 'Vehicle Recovery', 'Professional vehicle recovery and towing services', NULL, NULL, 800.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Variable', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL, 0, 0, 0.0, 0),
(24, 6, 18, 'Vehicle Renewal Services', 'Help with vehicle registration renewal and documentation', NULL, NULL, 1500.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '1-2 days', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL, 0, 0, 0.0, 0),
(25, 6, 18, 'Bicycle Maintenance', 'Bicycle repair and maintenance services', NULL, NULL, 400.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '1-2 hours', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL, 0, 0, 0.0, 0),
(26, 6, 19, 'Family Visa Renewal Services', 'Assistance with family visa renewal and documentation', NULL, NULL, 3000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '1-2 weeks', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL, 0, 0, 0.0, 0),
(27, 7, 20, 'Party Organizer', 'Complete party planning and organization services', NULL, NULL, 5000.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Event-based', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL, 0, 0, 0.0, 0),
(28, 7, 21, 'Pet Care & Grooming – Bathing, nail trimming, brushing', 'Complete pet care including bathing, nail trimming, and grooming services', NULL, NULL, 600.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '1-2 hours', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL, 0, 0, 0.0, 0),
(32, 2, 6, 'baby care', 'test', '[\"test\",\"test\"]', 'test baby care', 100.00, NULL, NULL, 10.00, NULL, 20.00, NULL, 30.00, NULL, 0, NULL, 'active', '2025-10-10 07:57:47', '2025-10-10 09:48:18', '1760095098_logo (1).png', 0, 0, 0.0, 0),
(33, 2, 3, 'laundry 1', 'test', '[\"test\",\"test\"]', 'test', 10.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'active', '2025-10-10 10:00:23', '2025-10-10 10:00:23', '1760095823_61yy3cVsjvL.jpg', 0, 0, 0.0, 0),
(34, 5, 10, 'Hoyt Hunt', 'Vel similique minima', '[\"Velit eos voluptatu\"]', 'Officia expedita ess', 753.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 'inactive', '2025-10-10 10:15:55', '2025-10-10 10:15:55', '1760096755_logo (1).png', 0, 0, 0.0, 0),
(35, 3, 12, 'Sybill Mays', 'Quisquam expedita ad', '[\"Et officia pariatur\"]', 'Praesentium necessit', 134.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 'inactive', '2025-10-10 10:35:37', '2025-10-10 10:35:37', '1760097937_61JfZmU4WjL.jpg', 0, 0, 0.0, 0),
(36, 8, 11, 'Allen Cruz', 'Veniam omnis vero a', '[\"Facilis veniam quis\"]', 'Enim excepteur volup', 284.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'inactive', '2025-10-10 10:48:51', '2025-10-10 10:48:51', '1760098731_61B1WzJ426L.jpg', 0, 0, 0.0, 0),
(37, 6, 7, 'testn1', 'Unde deserunt qui ne', '[\"Reprehenderit eu con\"]', 'Dolores minus in aut', 962.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 'active', '2025-10-13 03:19:09', '2025-10-13 03:19:09', '', 0, 0, 0.0, 0),
(38, 3, NULL, 'Joan George', 'Mollit delectus est', '[\"Dolor cupidatat tene\"]', 'Ullam laboriosam di', 389.00, NULL, NULL, 340.00, NULL, NULL, NULL, 354.00, NULL, 0, 'Sequi et Nam sint do', 'inactive', '2025-10-13 03:53:26', '2025-10-13 03:54:01', '', 0, 0, 0.0, 0),
(39, 8, 6, 'Anthony Dickson', 'Quia dolor reprehend', '[\"Deserunt omnis illum\"]', 'Ad nobis eum officia', 470.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 'inactive', '2025-10-13 03:55:10', '2025-10-13 03:55:10', '', 0, 0, 0.0, 0),
(40, 2, 3, 'Arden Ewing', 'Ea blanditiis totam', '[\"Nulla vel cum autem\"]', 'Minus amet inventor', 99.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'active', '2025-10-13 04:15:14', '2025-10-13 04:15:14', '', 0, 0, 0.0, 0),
(41, 3, 17, 'Pamela Thornton', 'Fugit facere Nam ut', '[\"Nihil odit veniam r\"]', 'Fuga Nostrum invent', 909.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 'inactive', '2025-10-13 04:25:22', '2025-10-13 04:25:22', '', 0, 0, 0.0, 0),
(44, 3, 9, 'Tyrone Kidd', 'Dignissimos qui fuga', '[\"Ut maxime quos quam\"]', 'Sit eos sed minus no', 519.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'inactive', '2025-10-13 04:55:13', '2025-10-13 04:55:13', '', 0, 0, 0.0, 0),
(45, 3, 12, 'Brenna Riley', 'Qui minus ullamco of', '[\"Veritatis eveniet v\"]', 'Nostrud reprehenderi', 44.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'inactive', '2025-10-13 05:06:38', '2025-10-13 05:06:38', '', 0, 0, 0.0, 0),
(46, 5, 18, 'Lance Morin', 'Ad a aute dolorem se', '[\"Accusantium officiis\"]', 'Adipisci assumenda c', 45.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 'inactive', '2025-10-13 05:08:44', '2025-10-13 05:08:44', '', 0, 0, 0.0, 0),
(47, 1, 11, 'August Terrell', 'Sunt qui unde nisi', '[\"Dolorem eveniet min\"]', 'Pariatur At consect', 110.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 'inactive', '2025-10-13 05:11:18', '2025-10-13 05:11:18', '', 0, 0, 0.0, 0),
(48, 1, 1, 'test service', 'test', '[\"test\",\"test\"]', 'test', 45.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'active', '2025-10-13 05:37:20', '2025-10-15 09:55:49', '1760340037_logo (1).png', 0, 0, 0.0, 0),
(49, 2, 2, 'basin cleaning', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sed nisl convallis, feugiat tortor at, lacinia ligula. Quisque tristique, mauris ut gravida gravida, nulla metus fermentum lorem, in malesuada nunc felis non lorem. Curabitur dignissim mi ac velit porttitor, ac egestas sem fringilla. Nullam finibus, turpis et malesuada tincidunt, felis sapien tempus nisi, in feugiat ligula enim nec neque. Donec vehicula massa nec dolor sodales, eget iaculis elit tristique. Vivamus consequat neque nec lorem fermentum porta. Integer ac purus nec arcu feugiat convallis. Suspendisse ac mattis lectus, at interdum enim. Mauris a metus non erat rhoncus vulputate. Proin sit amet tincidunt lacus. Fusce bibendum urna vitae justo bibendum, nec mattis arcu efficitur. Sed tempor, neque in aliquam tincidunt, odio urna feugiat magna, ut fringilla leo turpis et massa.', '[\"incluson one\",\"demo\",\"demo\",\"fewnovjn\"]', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sed nisl convallis, feugiat tortor at, lacinia ligula. Quisque tristique, mauris ut gravida gravida, nulla metus fermentum lorem, in malesuada nunc felis non lorem. Curabitur dignissim mi ac velit porttitor, ac egestas sem fringilla. Nullam finibus, turpis et malesuada tincidunt, felis sapien tempus nisi, in feugiat ligula enim nec neque', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'active', '2025-10-15 09:40:34', '2025-10-16 12:44:46', '[\"1760596760_0_about.jpg\",\"1760596760_1_laravel_archi.jpg\"]', 1, 1, 0.0, 0),
(50, 3, 6, 'Fallon Santiago', 'Quo nemo error eos d', '[\"Omnis necessitatibus\"]', 'Dignissimos explicab', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'inactive', '2025-10-16 06:55:53', '2025-10-16 06:55:53', NULL, 0, 0, 0.0, 0),
(51, 3, 6, 'abc', 'Quo nemo error eos d', '[\"Omnis necessitatibus\"]', 'Dignissimos explicab', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'active', '2025-10-16 06:56:56', '2025-10-16 11:02:02', NULL, 0, 0, 0.0, 0),
(52, 2, 4, 'Wyatt Emerson', 'Impedit voluptas of', '[\"Nam qui inventore au\"]', 'Dolor unde et sed ut', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 'inactive', '2025-10-16 11:03:23', '2025-10-16 11:03:23', NULL, 0, 0, 0.0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `service_addons`
--

CREATE TABLE `service_addons` (
  `id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `price` decimal(10,2) NOT NULL,
  `frequency_id` bigint UNSIGNED DEFAULT NULL,
  `type` enum('material','equipment','labor','premium','custom') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'custom',
  `is_required` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `quantity_limit` int DEFAULT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `service_frequencies`
--

CREATE TABLE `service_frequencies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `days_multiplier` int NOT NULL DEFAULT '1',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `service_frequency_options`
--

CREATE TABLE `service_frequency_options` (
  `id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `frequency_type` enum('weekly','monthly','yearly','onetime') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_of_times` int NOT NULL,
  `duration` int DEFAULT NULL,
  `price_per_time` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_frequency_options`
--

INSERT INTO `service_frequency_options` (`id`, `service_id`, `frequency_type`, `no_of_times`, `duration`, `price_per_time`, `description`, `created_at`, `updated_at`) VALUES
(58, 51, 'onetime', 1, 1, 456.00, 'Dolores impedit con', '2025-10-16 11:02:02', '2025-10-16 11:02:02'),
(59, 51, 'weekly', 1, 1, 676.00, 'Dolore iure est quod', '2025-10-16 11:02:02', '2025-10-16 11:02:02'),
(60, 51, 'monthly', 1, 1, 686.00, NULL, '2025-10-16 11:02:02', '2025-10-16 11:02:02'),
(61, 51, 'yearly', 1, 1, 454.00, 'Dolor magnam et amet', '2025-10-16 11:02:02', '2025-10-16 11:02:02'),
(62, 52, 'onetime', 1, 6, 634.00, 'Cillum iure enim rep', '2025-10-16 11:03:23', '2025-10-16 11:03:23'),
(63, 52, 'weekly', 5, 8, 528.00, 'Vitae laboriosam qu', '2025-10-16 11:03:23', '2025-10-16 11:03:23'),
(64, 52, 'yearly', 4, 7, 300.00, 'Odit suscipit est v', '2025-10-16 11:03:23', '2025-10-16 11:03:23'),
(65, 49, 'onetime', 1, 1, 100.00, 'tets', '2025-10-16 12:44:46', '2025-10-16 12:44:46'),
(66, 49, 'weekly', 1, 1, 200.00, 'test dsrse', '2025-10-16 12:44:46', '2025-10-16 12:44:46'),
(67, 49, 'weekly', 3, 6, 600.00, 'demo', '2025-10-16 12:44:46', '2025-10-16 12:44:46'),
(68, 49, 'monthly', 1, 1, 30.00, 'desc', '2025-10-16 12:44:46', '2025-10-16 12:44:46'),
(69, 49, 'yearly', 1, 1, 400.00, 'desc', '2025-10-16 12:44:46', '2025-10-16 12:44:46');

-- --------------------------------------------------------

--
-- Table structure for table `service_materials`
--

CREATE TABLE `service_materials` (
  `id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `material_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `material_description` text COLLATE utf8mb4_unicode_ci,
  `applicable_to` enum('onetime','weekly','monthly','yearly','all') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'onetime',
  `material_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `material_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_materials`
--

INSERT INTO `service_materials` (`id`, `service_id`, `material_name`, `material_description`, `applicable_to`, `material_price`, `material_image`, `created_at`, `updated_at`) VALUES
(4, 32, 'materials a', 'test baby', 'onetime', 10.00, '1760095151_68e8ebaf9cfcb_material_0_61yy3cVsjvL.jpg', '2025-10-10 09:49:11', '2025-10-10 09:49:11'),
(5, 32, 'materials b', 'test', 'weekly', 10.00, '', '2025-10-10 09:49:11', '2025-10-10 09:49:11'),
(12, 33, 'iron 2', 'test', 'weekly', 10.00, '1760096591_68e8f14fb964f_material_0_download.png', '2025-10-10 10:13:11', '2025-10-10 10:13:11'),
(13, 33, 'iron', 'will provide irons , and its cables and several things related to it', 'yearly', 10.00, '1760096591_68e8f14fbc2cb_material_1_61B1WzJ426L.jpg', '2025-10-10 10:13:11', '2025-10-10 10:13:11'),
(14, 33, 'test 3', 'test', 'monthly', 4.00, '1760096591_68e8f14fbf0f8_material_2_WhatsApp Image 2025-10-04 at 16.52.50_8750c696.jpg', '2025-10-10 10:13:11', '2025-10-10 10:13:11'),
(15, 34, 'Regan Cline', 'Explicabo Omnis obc', 'monthly', 776.00, '1760096755_68e8f1f358842_material_0_61yy3cVsjvL.jpg', '2025-10-10 10:15:55', '2025-10-10 10:15:55'),
(16, 35, 'Sierra Griffith', 'Consequat Fugiat d', 'onetime', 177.00, '1760097937_68e8f691ec815_material_0_61B1WzJ426L.jpg', '2025-10-10 10:35:37', '2025-10-10 10:35:37'),
(17, 36, 'material 1', 'Sint amet molestiae', 'yearly', 327.00, '1760098731_68e8f9ab939ef_material_0_61B1WzJ426L.jpg', '2025-10-10 10:48:51', '2025-10-10 10:48:51'),
(18, 37, 'm1', 'Id maiores eiusmod', 'monthly', 478.00, '', '2025-10-13 03:19:10', '2025-10-13 03:19:10'),
(20, 38, 'Andrew Gray', 'Reprehenderit in ad', 'onetime', 624.00, '', '2025-10-13 03:54:01', '2025-10-13 03:54:01'),
(21, 38, 'Quincy Ortega', 'Molestias maxime acc', 'monthly', 37.00, '', '2025-10-13 03:54:01', '2025-10-13 03:54:01'),
(22, 39, 'm1', 'Duis ut eos eos au', 'onetime', 708.00, '', '2025-10-13 03:55:10', '2025-10-13 03:55:10'),
(23, 40, 'm1', 'Quas quis dignissimo', 'monthly', 38.00, '', '2025-10-13 04:15:15', '2025-10-13 04:15:15'),
(24, 41, 'm 1', 'In omnis aut deserun', 'onetime', 724.00, '', '2025-10-13 04:25:22', '2025-10-13 04:25:22'),
(27, 44, 'm 1', 'Voluptatem a at lab', 'onetime', 647.00, '', '2025-10-13 04:55:13', '2025-10-13 04:55:13'),
(28, 45, 'm 1', 'Labore perferendis d', 'monthly', 602.00, '', '2025-10-13 05:06:38', '2025-10-13 05:06:38'),
(29, 45, 'm2', 'test', 'onetime', 45.00, '', '2025-10-13 05:06:38', '2025-10-13 05:06:38'),
(30, 46, 'test 1', 'Est blanditiis ut qu', 'weekly', 45.00, '', '2025-10-13 05:08:44', '2025-10-13 05:08:44'),
(31, 46, 'test 2', 'test', 'onetime', 45.00, '', '2025-10-13 05:08:44', '2025-10-13 05:08:44'),
(32, 46, 'test 3', 'test', 'monthly', 45.00, '', '2025-10-13 05:08:44', '2025-10-13 05:08:44'),
(33, 46, 'test 4', 'test', 'yearly', 45.00, '', '2025-10-13 05:08:44', '2025-10-13 05:08:44'),
(34, 47, 'test 1', 'Recusandae Consequa', 'onetime', 45.00, '', '2025-10-13 05:11:18', '2025-10-13 05:11:18'),
(35, 47, 'test 2', 'test', 'monthly', 45.00, '', '2025-10-13 05:11:18', '2025-10-13 05:11:18'),
(39, 48, 'm 1', 'test', 'onetime', 45.00, '1760340037_68eca84516d75_material_0_61yy3cVsjvL.jpg', '2025-10-13 05:50:37', '2025-10-13 05:50:37'),
(40, 48, 'm 2', 'test', 'weekly', 45.00, '1760340037_68eca84518885_material_1_logo (1).png', '2025-10-13 05:50:37', '2025-10-13 05:50:37'),
(41, 48, 'm 3', 'test', 'monthly', 48.00, '1760340037_68eca8451a977_material_2_download (5).jpeg', '2025-10-13 05:50:37', '2025-10-13 05:50:37'),
(42, 1, 'material 1', NULL, 'onetime', 100.00, '', '2025-10-15 07:27:00', '2025-10-15 07:27:00'),
(58, 51, 'Juliet Britt', 'Irure et recusandae', 'onetime', 444.00, '', '2025-10-16 11:02:02', '2025-10-16 11:02:02'),
(59, 52, 'Shay Wilkerson', 'Repudiandae quibusda', 'yearly', 265.00, '', '2025-10-16 11:03:23', '2025-10-16 11:03:23'),
(60, 49, 'material one', 'demo', 'onetime', 200.00, '', '2025-10-16 12:44:46', '2025-10-16 12:44:46'),
(61, 49, 'm 2', 'demo', 'weekly', 400.00, '', '2025-10-16 12:44:46', '2025-10-16 12:44:46');

-- --------------------------------------------------------

--
-- Table structure for table `service_offers`
--

CREATE TABLE `service_offers` (
  `id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `discount_type` enum('percentage','flat') COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `discounted_price_onetime` decimal(10,2) DEFAULT NULL,
  `discounted_price_weekly` decimal(10,2) DEFAULT NULL,
  `discounted_price_monthly` decimal(10,2) DEFAULT NULL,
  `discounted_price_yearly` decimal(10,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_offers`
--

INSERT INTO `service_offers` (`id`, `service_id`, `name`, `description`, `discount_type`, `discount_value`, `discounted_price_onetime`, `discounted_price_weekly`, `discounted_price_monthly`, `discounted_price_yearly`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Diwali Dhamak Offer', 'this will be the biggest offer festive at qwikhome', 'flat', 20.00, 115.00, 114.00, 100.00, 90.00, '2025-10-13', '2025-11-21', 'active', '2025-10-13 10:17:50', '2025-10-16 06:29:14'),
(8, 2, 'Harrison Campos', 'Eum qui proident ut', 'percentage', 89.00, 219.00, NULL, NULL, NULL, '2025-10-23', '2025-10-31', 'inactive', '2025-10-13 10:34:09', '2025-10-13 10:34:09'),
(9, 1, 'cad s', 'vdsivj i', 'percentage', 20.00, 193.00, 99.00, 229.00, 596.00, '2025-10-13', '2025-11-21', 'active', '2025-10-13 10:45:15', '2025-10-13 10:45:15'),
(10, 1, 'cad s', 'vdsivj i', 'percentage', 20.00, 193.00, 99.00, 229.00, 596.00, '2025-10-13', '2025-11-21', 'active', '2025-10-13 10:47:48', '2025-10-13 10:47:48'),
(11, 1, 'diwali offer', 'desc', 'percentage', 20.00, 100.00, 90.00, 80.00, 70.00, '2025-10-14', '2025-11-27', 'active', '2025-10-14 07:41:43', '2025-10-14 07:41:43'),
(12, 1, 'diwali offer', 'desc', 'percentage', 20.00, 100.00, 90.00, 80.00, 70.00, '2025-10-14', '2025-11-27', 'active', '2025-10-14 07:43:14', '2025-10-14 07:43:14'),
(13, 1, 'diwali offer', 'desc', 'percentage', 20.00, 100.00, 90.00, 80.00, 70.00, '2025-10-14', '2025-11-27', 'active', '2025-10-14 07:44:05', '2025-10-14 07:44:05');

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

-- --------------------------------------------------------

--
-- Table structure for table `service_requirements`
--

CREATE TABLE `service_requirements` (
  `id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_requirements`
--

INSERT INTO `service_requirements` (`id`, `service_id`, `title`, `image`, `created_at`, `updated_at`) VALUES
(6, 32, 'test', '', '2025-10-10 09:49:11', '2025-10-10 09:49:11'),
(10, 33, 'test', '', '2025-10-10 10:13:11', '2025-10-10 10:13:11'),
(11, 34, 'Et consequatur Debi', '', '2025-10-10 10:15:55', '2025-10-10 10:15:55'),
(12, 35, 'Aut ut elit possimu', '', '2025-10-10 10:35:37', '2025-10-10 10:35:37'),
(13, 36, 'Laudantium eum poss', '', '2025-10-10 10:48:51', '2025-10-10 10:48:51'),
(14, 37, 'Odit quia similique', '', '2025-10-13 03:19:09', '2025-10-13 03:19:09'),
(16, 38, 'Anim sequi quisquam', '', '2025-10-13 03:54:01', '2025-10-13 03:54:01'),
(17, 39, 'Et obcaecati est id', '', '2025-10-13 03:55:10', '2025-10-13 03:55:10'),
(18, 40, 'Velit accusantium a', '', '2025-10-13 04:15:14', '2025-10-13 04:15:14'),
(19, 41, 'Eu Nam quisquam prae', '', '2025-10-13 04:25:22', '2025-10-13 04:25:22'),
(22, 44, 'Qui et distinctio P', '', '2025-10-13 04:55:13', '2025-10-13 04:55:13'),
(23, 45, 'Quisquam commodo in', '', '2025-10-13 05:06:38', '2025-10-13 05:06:38'),
(24, 46, 'Ratione ex earum vol', '', '2025-10-13 05:08:44', '2025-10-13 05:08:44'),
(25, 47, 'Omnis cupidatat rem', '', '2025-10-13 05:11:18', '2025-10-13 05:11:18'),
(27, 48, 'test', '1760340037_0_61B1WzJ426L.jpg', '2025-10-13 05:50:37', '2025-10-13 05:50:37'),
(28, 1, 'test requirements', '', '2025-10-15 07:27:00', '2025-10-15 07:27:00'),
(53, 51, 'Et iste magna exercih', '', '2025-10-16 11:02:02', '2025-10-16 11:02:02'),
(54, 52, 'Irure autem voluptas', '', '2025-10-16 11:03:23', '2025-10-16 11:03:23'),
(55, 49, 'req one', '', '2025-10-16 12:44:46', '2025-10-16 12:44:46'),
(56, 49, 'req two', '', '2025-10-16 12:44:46', '2025-10-16 12:44:46');

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

-- --------------------------------------------------------

--
-- Table structure for table `service_subscription_plans`
--

CREATE TABLE `service_subscription_plans` (
  `id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `base_price` decimal(10,2) NOT NULL,
  `billing_frequency_id` bigint UNSIGNED NOT NULL,
  `duration_months` int NOT NULL,
  `billing_cycle` enum('monthly','quarterly','yearly') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'monthly',
  `setup_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `auto_renew` tinyint(1) NOT NULL DEFAULT '1',
  `renewal_reminder_days` int NOT NULL DEFAULT '7',
  `included_addons` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `discount_percentage` decimal(5,2) NOT NULL DEFAULT '0.00',
  `max_services_per_period` int NOT NULL DEFAULT '1',
  `status` enum('active','inactive','draft') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `custom_configurations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

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
('8YgwGU3w89tVIezilTuZRPyJKpLFZ2UUmmHjcQ7T', 1, '103.178.126.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoibEF5QkNRNDl3WHdoZENoUlV5aHFMZ2hYalJBZmJWMWltb0loV0prVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly9hZG1pbi5xd2lraG9tLmFlL3NlcnZpY2VzP3BhZ2U9MyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjE6e3M6ODoiaW50ZW5kZWQiO3M6Mzk6Imh0dHA6Ly9hZG1pbi5xd2lraG9tLmFlL3NlcnZpY2VzL2NyZWF0ZSI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzYwNjc0MDE3O319', 1760675068),
('lAIfyc73Y1nprKPhKulL2Au9xtNfobg75zM1vlht', NULL, '44.214.108.11', 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.20.25 (KHTML, like Gecko) Version/5.0.4 Safari/533.20.27', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiem1uY3FjdHJicHRsZGNUWnpaanFpQXRQcEJQVzV4blI2VEs4MEhVRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vYWRtaW4ucXdpa2hvbS5hZS9yZWZ1bmQtcG9saWN5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760674496);

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
(1, 1, 'spatula waxing', NULL, 'active', '2025-10-02 23:48:08', '2025-10-16 06:40:57', '1760596857.jpg'),
(2, 2, 'Cleaning Services', 'Professional cleaning and hygiene services', 'active', '2025-10-03 00:06:31', '2025-10-16 06:41:24', '1760596884.jpg'),
(3, 2, 'Laundry Services', 'Clothing and fabric care services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(4, 2, 'Pest & Disinfection Services', 'Pest control and disinfection services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(5, 2, 'Moving & Relocation Services', 'Professional moving and relocation assistance', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(6, 3, 'Child Care', 'Childcare and nanny services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(7, 3, 'Post-Maternity Care', 'Post-delivery maternal care and assistance', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(8, 3, 'Education Support', 'Tutoring and educational assistance services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(9, 3, 'Food Services', 'Home cooking and meal preparation services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(10, 3, 'Transportation', 'Family transportation and driver services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
(11, 4, 'Salon Services', 'Professional hair, beauty, and grooming services', 'active', '2025-10-03 00:06:31', '2025-10-03 00:06:31', NULL),
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
-- Table structure for table `terms_conditions`
--

CREATE TABLE `terms_conditions` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms_conditions`
--

INSERT INTO `terms_conditions` (`id`, `title`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, 'terms and conditions', 'WelcometoQwikhom!\r\nThese Terms and Conditions (“Terms”) govern your access to and use of the Qwikhom website, mobile application, and related services (collectively, the “Platform”). By accessing or using our Platform, you agree to comply with and be bound by these Terms.\r\nPlease read them carefully before using our services.\r\n________________________________________\r\n1. Overview\r\nQwikhom is a technology-driven platform based in the United Arab Emirates (UAE) that connects customers with trained and verified service professionals (“Partners”) for various home and personal care services. Qwikhom facilitates service booking and payment transactions between customers and service providers but does not directly employ the service professionals.\r\n________________________________________\r\n2. Eligibility and Use\r\n•	You must be 18 years or older to register and use our services.\r\n•	You agree to provide accurate, current, and complete information during registration and booking.\r\n•	You are responsible for maintaining the confidentiality of your account login details.\r\n•	Misuse of the Platform, fraudulent activity, or violation of these Terms may result in account suspension or legal action.\r\n________________________________________\r\n3. Services Offered\r\nQwikhom enables users to book professional services including but not limited to:\r\nhome cleaning, plumbing, electrical work, appliance repair, painting, pest control, beauty care, grooming, and wellness treatments.\r\nAll services are provided by independent professionals verified by Qwikhom. The quality and outcome of each service may vary depending on the scope and condition at the service location.\r\n________________________________________\r\n4. Pricing and Payments\r\n•	Service prices are listed on the Platform and may vary by location, time, and nature of the service.\r\n•	Payments can be made through secure online payment gateways, debit/credit cards, or other approved digital methods.\r\n•	Qwikhom reserves the right to modify pricing, introduce offers, or apply service charges at its discretion.\r\n•	All payments are processed in UAE Dirhams (AED).\r\n________________________________________\r\n5. Cancellations and Refunds\r\n•	You may cancel or reschedule a service before the professional is dispatched.\r\n•	Refunds (if applicable) will be processed in accordance with our Refund Policy.\r\n•	Qwikhom reserves the right to cancel any booking due to unavailability or unforeseen circumstances.\r\n•	In case of a refund, the amount will be credited to your original payment method within a reasonable period as per UAE banking norms.\r\n________________________________________\r\n6. User Responsibilities\r\nYou agree not to:\r\n•	Misuse or attempt to interfere with the operation of the Platform.\r\n•	Post or transmit any misleading, harmful, or illegal content.\r\n•	Violate UAE laws, regulations, or moral standards.\r\n•	Copy, modify, or distribute Platform content without written consent from Qwikhom.\r\n________________________________________\r\n7. Partner Responsibilities\r\n•	All service professionals are required to perform their services with due care, skill, and professionalism.\r\n•	Partners are independent contractors, not employees or representatives of Qwikhom.\r\n•	Any issues or disputes between users and partners should be reported to Qwikhom for mediation and resolution support.\r\n________________________________________\r\n8. Limitation of Liability\r\nQwikhom acts solely as a facilitator between users and service professionals. While we ensure that professionals are verified and trained, Qwikhom shall not be liable for:\r\n•	Any direct or indirect damages caused during or after service completion.\r\n•	Loss or damage to property, or personal injury resulting from the service.\r\n•	Service delays or failures beyond Qwikhom’s reasonable control.\r\n________________________________________\r\n9. Intellectual Property\r\nAll trademarks, designs, software, and content available on the Qwikhom Platform are owned by Qwikhom or its licensors. No material may be copied, reproduced, or distributed without prior written permission.\r\n________________________________________\r\n10. Privacy and Data Protection\r\nYour personal data is collected, stored, and processed in compliance with applicable UAE data protection laws. For details, please refer to our Privacy Policy. By using our Platform, you consent to our data practices as described therein.\r\n________________________________________\r\n11. Updates and Modifications\r\nQwikhom reserves the right to update or amend these Terms at any time. Changes will be effective upon posting on the Platform. Continued use of our services constitutes acceptance of the updated Terms.\r\n________________________________________\r\n12. Governing Law and Jurisdiction\r\nThese Terms and Conditions are governed by the laws of the United Arab Emirates. Any disputes arising under or in connection with these Terms shall be subject to the exclusive jurisdiction of the courts of Dubai, UAE.\r\n________________________________________\r\n13. Contact Us\r\nFor any queries, feedback, or concerns, please contact us:\r\n📧 support@qwikhom.com (change it as per requirement)\r\n🌐 www.qwikhom.com (change it as per requirement)', 'active', '2025-10-14 02:49:39', '2025-10-14 02:56:36');

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
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor_id` int DEFAULT NULL,
  `active` int NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `application_document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trade_license_document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vat_certificate_document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `staff_documents` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contract_document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_type` enum('fixed_rate','commission','revenue_share') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'commission',
  `fixed_rate_amount` decimal(10,2) DEFAULT NULL,
  `commission_rate` decimal(5,2) DEFAULT NULL,
  `revenue_share_ratio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `average_rating` decimal(3,2) DEFAULT '0.00',
  `fcm_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `image`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `vendor_id`, `active`, `is_deleted`, `deleted_at`, `address`, `application_document`, `trade_license_document`, `vat_certificate_document`, `staff_documents`, `contract_document`, `payment_type`, `fixed_rate_amount`, `commission_rate`, `revenue_share_ratio`, `average_rating`, `fcm_token`) VALUES
(1, 'Admin', 'admin@gmail.com', '1111111111', NULL, '2025-09-29 05:09:13', '$2y$12$jltDtsVVsQdN44eQPrJd0.pVa2O6sYi32GtCumw6PW.46Kw8mNGx.', 'nnuHegwXzDa2hmE7K4MoAcP3h0pzF6o5DKplalDqH1HB60jJuKKmnjJ0M4fO', '2025-09-29 05:09:13', '2025-09-29 05:09:13', 'admin', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'commission', NULL, NULL, NULL, 0.00, NULL),
(2, 'Vendor', 'vendor@gmail.com', '5555555555', '1759494600.jpg', '2025-09-29 23:29:34', '$2y$12$NqOezJgewb68KlxAtXNdgu/Q2LLkiTUdNGIGysQ/tmSID6Z/rvqEu', 'NMlHZPHc2YALguL19ifZyxxzW7GqumzZRhylXNt8ipFclJ2GtT18kM17HOcI', '2025-09-29 23:29:34', '2025-10-03 07:00:00', 'vendor', NULL, 0, 0, NULL, 'nashik , india', NULL, NULL, NULL, NULL, NULL, 'commission', NULL, NULL, NULL, 0.00, NULL),
(3, 'user', 'user@gmail.com', '0000000000', NULL, '2025-09-29 23:29:34', '$2y$12$NM1NJ4s4a8/P0XkqFAfZd.Qo502cuY8Sge78WIhyEELo8BcCyDyBS', 'aacdjLqjKY', '2025-09-29 23:29:34', '2025-10-06 00:55:26', 'user', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'commission', NULL, NULL, NULL, 0.00, NULL),
(6, 'chetan', 'chetan@gmail.com', '7777777777', '1759492396.jpg', NULL, '$2y$12$WfWRTBZJWNAjb5Mnc7/xD.95MuIrYuYmDxBNxEc5cgML0LBkgAmzC', NULL, '2025-10-03 06:23:16', '2025-10-03 06:23:16', 'serviceprovider', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'commission', NULL, NULL, NULL, 0.00, NULL),
(8, 'John Smith', 'john.smith@example.com', '+1987654321', NULL, NULL, '$2y$12$u9BdluXhEGt1BS9Eej4f8upoFRCymY9UB1USx6Jq5SBuMpmQ35aTa', NULL, '2025-10-03 23:43:13', '2025-10-03 23:43:13', 'serviceprovider', NULL, 1, 0, NULL, '456 Worker Ave, City, State 12346', NULL, NULL, NULL, NULL, NULL, 'commission', NULL, NULL, NULL, 0.00, NULL),
(9, 'Sarah Johnson', 'sarah.johnson@example.com', '+1555123456', NULL, NULL, '$2y$12$c7DX6OE.H.jdOyVngBmcZeY3699DTcsyHAgr.0qSnngSwifxRqAES', NULL, '2025-10-03 23:43:13', '2025-10-03 23:43:13', 'serviceprovider', NULL, 1, 0, NULL, '789 Provider Rd, City, State 12347', NULL, NULL, NULL, NULL, NULL, 'commission', NULL, NULL, NULL, 0.00, NULL),
(10, 'Mike Davis', 'mike.davis@example.com', '+1444987654', NULL, NULL, '$2y$12$XAG06NhLvozFbpTUmA4AAur9T/AMSe4Q4N3rTPu5MWgUKcbvyuJJS', NULL, '2025-10-03 23:43:13', '2025-10-03 23:43:13', 'serviceprovider', NULL, 1, 0, NULL, '321 Service Ln, City, State 12348', NULL, NULL, NULL, NULL, NULL, 'commission', NULL, NULL, NULL, 0.00, NULL),
(11, 'Alice Cooper', 'alice.cooper@example.com', '+1777123456', NULL, NULL, '$2y$12$/HfQm/RLJDhknsXiXU9sz.SnBlOiRJaz1.PhtRPZwMZioCm2vatw.', NULL, '2025-10-03 23:43:14', '2025-10-06 00:55:29', 'user', NULL, 0, 0, NULL, '111 Customer St, City, State 12349', NULL, NULL, NULL, NULL, NULL, 'commission', NULL, NULL, NULL, 0.00, NULL),
(12, 'Bob Wilson', 'bob.wilson@example.com', '+1666234567', NULL, NULL, '$2y$12$oNQLwKKC7pn0f.cEWiZmYuqRVRNgmiwcQ0OJ8romRdEMxy.yxOWt6', NULL, '2025-10-03 23:43:14', '2025-10-03 23:43:14', 'user', NULL, 0, 0, NULL, '222 Client Ave, City, State 12350', NULL, NULL, NULL, NULL, NULL, 'commission', NULL, NULL, NULL, 0.00, NULL),
(13, 'Carol Brown', 'carol.brown@example.com', '+1555345678', NULL, NULL, '$2y$12$cIiAVOIviqrMua9mw8aGtO8jAaQaDxC/Njok4w/2N9smnl6YcOT2i', NULL, '2025-10-03 23:43:14', '2025-10-06 00:55:06', 'user', NULL, 1, 0, NULL, '333 Patron Rd, City, State 12351', NULL, NULL, NULL, NULL, NULL, 'commission', NULL, NULL, NULL, 0.00, NULL),
(14, 'David Lee', 'david.lee@example.com', '+1444456789', NULL, NULL, '$2y$12$UHXTVSKimJ1b3OYegaQP1u6aLJMaT3nKMPYsAqNsmJBVXEgT5sYgq', NULL, '2025-10-03 23:43:15', '2025-10-06 00:29:09', 'user', NULL, 0, 1, '2025-10-08 06:47:00', '444 Consumer Ln, City, State 12352', NULL, NULL, NULL, NULL, NULL, 'commission', NULL, NULL, NULL, 0.00, NULL),
(15, 'new vendor', 'vendor2@gmail.com', '4556675645', '', NULL, '$2y$12$VhNY23Z7iG6.8e.6V1cwCeWsf8BWNidjIHmqCeUwfSbIa54CdzRJe', NULL, '2025-10-06 01:24:32', '2025-10-06 01:24:32', 'serviceprovider', NULL, 0, 0, NULL, 'wanowrie , pune , india', NULL, NULL, NULL, NULL, NULL, 'commission', NULL, NULL, NULL, 0.00, NULL),
(17, 'employee', 'emp@gmail.com', '5656565656', '', NULL, '$2y$12$XWU/bCM/y1qc/wFHr5rglekWAKmT77R1uEqzr1q8f3vR1G0ROZfp2', NULL, '2025-10-06 01:50:02', '2025-10-06 01:50:02', 'serviceprovider', NULL, 0, 0, NULL, 'nashik', NULL, NULL, NULL, NULL, NULL, 'commission', NULL, NULL, NULL, 0.00, NULL),
(18, 'prathamesh', 'rathodprathamesh23@gmail.com', '7757872473', NULL, NULL, NULL, NULL, '2025-10-15 06:58:27', '2025-10-16 16:26:19', 'user', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'commission', NULL, NULL, NULL, 0.00, NULL),
(19, 'Pritesh Pawar', 'pritesh@gmail.com', '9876543210', NULL, NULL, NULL, NULL, '2025-10-15 06:58:54', '2025-10-15 06:58:54', 'user', NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'commission', NULL, NULL, NULL, 0.00, NULL),
(20, 'Chetan Shelake', 'chetan123@gmail.com', '7696986799', '1760596392.jpg', NULL, '$2y$12$RCjVl9unVnNAuc368yHhfO5iYwpQVGvRTpsBN/Boqs1G4OAvaP4Si', NULL, '2025-10-16 06:32:29', '2025-10-16 06:33:12', 'serviceprovider', 2, 0, 0, NULL, 'demo', NULL, NULL, NULL, NULL, NULL, 'commission', NULL, NULL, NULL, 0.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_services`
--

CREATE TABLE `user_services` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `payment_type` enum('fixed_rate','commission','revenue_share') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fixed_rate_amount` decimal(10,2) DEFAULT NULL,
  `commission_rate` decimal(5,2) DEFAULT NULL,
  `revenue_share_ratio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_services`
--

INSERT INTO `user_services` (`id`, `user_id`, `service_id`, `created_at`, `updated_at`, `payment_type`, `fixed_rate_amount`, `commission_rate`, `revenue_share_ratio`) VALUES
(1, 17, 5, '2025-10-06 01:50:02', '2025-10-06 01:50:02', NULL, NULL, NULL, NULL),
(2, 17, 19, '2025-10-06 01:50:02', '2025-10-06 01:50:02', NULL, NULL, NULL, NULL),
(3, 17, 24, '2025-10-06 01:50:02', '2025-10-06 01:50:02', NULL, NULL, NULL, NULL),
(4, 17, 25, '2025-10-06 01:50:02', '2025-10-06 01:50:02', NULL, NULL, NULL, NULL),
(5, 17, 26, '2025-10-06 01:50:02', '2025-10-06 01:50:02', NULL, NULL, NULL, NULL),
(6, 20, 26, '2025-10-16 06:32:29', '2025-10-16 06:32:29', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `offer_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `service_id`, `offer_id`, `created_at`, `updated_at`) VALUES
(7, 3, 1, NULL, '2025-10-15 11:05:29', '2025-10-15 11:05:29'),
(24, 18, 1, NULL, '2025-10-16 16:27:58', '2025-10-16 16:27:58'),
(25, 18, 48, NULL, '2025-10-16 16:28:01', '2025-10-16 16:28:01'),
(26, 3, 5, NULL, '2025-10-16 16:32:23', '2025-10-16 16:32:23'),
(27, 3, 4, NULL, '2025-10-16 16:33:02', '2025-10-16 16:33:02'),
(28, 18, 16, NULL, '2025-10-17 08:38:47', '2025-10-17 08:38:47');

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
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_session_id_index` (`session_id`),
  ADD KEY `carts_user_id_index` (`user_id`),
  ADD KEY `carts_status_expires_at_index` (`status`,`expires_at`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_service_frequency_id_foreign` (`service_frequency_id`),
  ADD KEY `cart_items_preferred_service_provider_id_foreign` (`preferred_service_provider_id`),
  ADD KEY `cart_items_item_type_item_id_index` (`item_type`,`item_id`),
  ADD KEY `cart_items_cart_id_index` (`cart_id`),
  ADD KEY `cart_items_subscription_plan_id_index` (`subscription_plan_id`),
  ADD KEY `cart_items_combo_offer_id_index` (`combo_offer_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `combo_offers`
--
ALTER TABLE `combo_offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `combo_offer_services`
--
ALTER TABLE `combo_offer_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `combo_offer_services_combo_offer_id_service_id_unique` (`combo_offer_id`,`service_id`),
  ADD KEY `combo_offer_services_service_id_foreign` (`service_id`);

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
-- Indexes for table `disclaimers`
--
ALTER TABLE `disclaimers`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `faqs_service_id_foreign` (`service_id`);

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

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
-- Indexes for table `privacy_policies`
--
ALTER TABLE `privacy_policies`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `push_notifications`
--
ALTER TABLE `push_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `push_notifications_created_by_foreign` (`created_by`);

--
-- Indexes for table `refund_policies`
--
ALTER TABLE `refund_policies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_category_id_foreign` (`category_id`),
  ADD KEY `services_subcategory_id_foreign` (`subcategory_id`);

--
-- Indexes for table `service_addons`
--
ALTER TABLE `service_addons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_addons_service_id_foreign` (`service_id`),
  ADD KEY `service_addons_frequency_id_foreign` (`frequency_id`);

--
-- Indexes for table `service_frequencies`
--
ALTER TABLE `service_frequencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_frequencies_slug_unique` (`slug`);

--
-- Indexes for table `service_frequency_options`
--
ALTER TABLE `service_frequency_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_frequency_options_service_id_frequency_type_index` (`service_id`,`frequency_type`);

--
-- Indexes for table `service_materials`
--
ALTER TABLE `service_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_materials_service_id_applicable_to_index` (`service_id`,`applicable_to`);

--
-- Indexes for table `service_offers`
--
ALTER TABLE `service_offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_offers_service_id_foreign` (`service_id`);

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
-- Indexes for table `service_subscription_plans`
--
ALTER TABLE `service_subscription_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_subscription_plans_service_id_foreign` (`service_id`),
  ADD KEY `service_subscription_plans_billing_frequency_id_foreign` (`billing_frequency_id`);

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
-- Indexes for table `terms_conditions`
--
ALTER TABLE `terms_conditions`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_user_id_foreign` (`user_id`),
  ADD KEY `wishlists_service_id_foreign` (`service_id`),
  ADD KEY `wishlists_offer_id_foreign` (`offer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

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
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `combo_offers`
--
ALTER TABLE `combo_offers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `combo_offer_services`
--
ALTER TABLE `combo_offer_services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disclaimers`
--
ALTER TABLE `disclaimers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `privacy_policies`
--
ALTER TABLE `privacy_policies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `processes`
--
ALTER TABLE `processes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `promocodes`
--
ALTER TABLE `promocodes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `push_notifications`
--
ALTER TABLE `push_notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `refund_policies`
--
ALTER TABLE `refund_policies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_addons`
--
ALTER TABLE `service_addons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_frequencies`
--
ALTER TABLE `service_frequencies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_frequency_options`
--
ALTER TABLE `service_frequency_options`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `service_materials`
--
ALTER TABLE `service_materials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `service_offers`
--
ALTER TABLE `service_offers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `service_provider_reviews`
--
ALTER TABLE `service_provider_reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_requirements`
--
ALTER TABLE `service_requirements`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `service_reviews`
--
ALTER TABLE `service_reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_subscription_plans`
--
ALTER TABLE `service_subscription_plans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `terms_conditions`
--
ALTER TABLE `terms_conditions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user_services`
--
ALTER TABLE `user_services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

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
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_combo_offer_id_foreign` FOREIGN KEY (`combo_offer_id`) REFERENCES `combo_offers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_preferred_service_provider_id_foreign` FOREIGN KEY (`preferred_service_provider_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cart_items_service_frequency_id_foreign` FOREIGN KEY (`service_frequency_id`) REFERENCES `service_frequency_options` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `cart_items_subscription_plan_id_foreign` FOREIGN KEY (`subscription_plan_id`) REFERENCES `service_subscription_plans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `combo_offer_services`
--
ALTER TABLE `combo_offer_services`
  ADD CONSTRAINT `combo_offer_services_combo_offer_id_foreign` FOREIGN KEY (`combo_offer_id`) REFERENCES `combo_offers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `combo_offer_services_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `push_notifications`
--
ALTER TABLE `push_notifications`
  ADD CONSTRAINT `push_notifications_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `services_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `service_addons`
--
ALTER TABLE `service_addons`
  ADD CONSTRAINT `service_addons_frequency_id_foreign` FOREIGN KEY (`frequency_id`) REFERENCES `service_frequencies` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `service_addons_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_frequency_options`
--
ALTER TABLE `service_frequency_options`
  ADD CONSTRAINT `service_frequency_options_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_materials`
--
ALTER TABLE `service_materials`
  ADD CONSTRAINT `service_materials_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_offers`
--
ALTER TABLE `service_offers`
  ADD CONSTRAINT `service_offers_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `service_subscription_plans`
--
ALTER TABLE `service_subscription_plans`
  ADD CONSTRAINT `service_subscription_plans_billing_frequency_id_foreign` FOREIGN KEY (`billing_frequency_id`) REFERENCES `service_frequencies` (`id`),
  ADD CONSTRAINT `service_subscription_plans_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

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

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_offer_id_foreign` FOREIGN KEY (`offer_id`) REFERENCES `service_offers` (`id`),
  ADD CONSTRAINT `wishlists_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`),
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
