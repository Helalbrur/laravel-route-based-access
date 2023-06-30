-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 30, 2023 at 01:27 PM
-- Server version: 8.0.31
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `route_based_authentication`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `log_table`;
CREATE TABLE IF NOT EXISTS `log_table` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `query` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `log_table_created_by_foreign` (`created_by`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_uploads`
--

DROP TABLE IF EXISTS `image_uploads`;
CREATE TABLE IF NOT EXISTS `image_uploads` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `file_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `sys_no` bigint UNSIGNED NOT NULL,
  `page_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `image_uploads`
--

INSERT INTO `image_uploads` (`id`, `file_name`, `file_type`, `sys_no`, `page_name`, `created_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(20, 'common_uploads/lgoin_pg_bg_white22.png_1402091_group_profile.png', '1', 1, 'group_profile', 1, NULL, '2023-06-28 08:24:03', '2023-06-28 08:24:03'),
(31, 'common_uploads/lgoin_pg_bg_white.png_1402091_company_profile.png', '1', 1, 'company_profile', 1, NULL, '2023-06-28 16:07:56', '2023-06-28 16:07:56'),
(17, 'common_uploads/Logic 01 copy.png_11244_group_profile.png', '1', 1, 'group_profile', 1, NULL, '2023-06-28 07:30:23', '2023-06-28 07:30:23'),
(21, 'common_uploads/lcation.png_4025_group_profile.png', '1', 1, 'group_profile', 1, NULL, '2023-06-28 08:24:34', '2023-06-28 08:24:34'),
(22, 'common_uploads/phone.png_3185_group_profile.png', '1', 1, 'group_profile', 1, NULL, '2023-06-28 08:27:16', '2023-06-28 08:27:16'),
(29, 'common_uploads/lgoin_pg_bg.png_509596_group_profile.png', '1', 5, 'group_profile', 1, NULL, '2023-06-28 16:00:44', '2023-06-28 16:00:44');

-- --------------------------------------------------------

--
-- Table structure for table `lib_buyer`
--

DROP TABLE IF EXISTS `lib_buyer`;
CREATE TABLE IF NOT EXISTS `lib_buyer` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `buyer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `party_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag_company` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_site` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lib_category`
--

DROP TABLE IF EXISTS `lib_category`;
CREATE TABLE IF NOT EXISTS `lib_category` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lib_category`
--

INSERT INTO `lib_category` (`id`, `category_name`, `short_name`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Electronics', 'Electronics', 1, NULL, '2023-06-29 05:40:52', '2023-06-29 05:40:52', NULL),
(2, 'Cloths', 'Cloths', 1, NULL, '2023-06-29 07:28:00', '2023-06-29 07:28:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lib_color`
--

DROP TABLE IF EXISTS `lib_color`;
CREATE TABLE IF NOT EXISTS `lib_color` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `color_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entry_form` int DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lib_color`
--

INSERT INTO `lib_color` (`id`, `color_name`, `entry_form`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Black', NULL, NULL, NULL, NULL, '2023-06-28 10:08:37', '2023-06-28 10:08:37'),
(2, 'White', NULL, NULL, NULL, NULL, '2023-06-28 10:11:38', '2023-06-28 10:11:38');

-- --------------------------------------------------------

--
-- Table structure for table `lib_company`
--

DROP TABLE IF EXISTS `lib_company`;
CREATE TABLE IF NOT EXISTS `lib_company` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `comapnay_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_short_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_id` bigint UNSIGNED NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lib_company`
--

INSERT INTO `lib_company` (`id`, `comapnay_name`, `company_short_name`, `group_id`, `address`, `website`, `email`, `contact_no`, `logo`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Sait', 'Sait', 5, 'Nihalpur', 'sait.com', 'admin@sait.com', '01758502951', NULL, 1, NULL, '2023-06-28 01:34:16', '2023-06-28 16:23:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lib_country`
--

DROP TABLE IF EXISTS `lib_country`;
CREATE TABLE IF NOT EXISTS `lib_country` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `country_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lib_country`
--

INSERT INTO `lib_country` (`id`, `country_name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Bangladesh', NULL, '2023-06-28 11:48:20', '2023-06-28 11:48:20'),
(2, 'India', NULL, '2023-06-28 11:48:50', '2023-06-28 11:48:50');

-- --------------------------------------------------------

--
-- Table structure for table `lib_employee`
--

DROP TABLE IF EXISTS `lib_employee`;
CREATE TABLE IF NOT EXISTS `lib_employee` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `full_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `id_card_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `national_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` int NOT NULL,
  `designation_id` bigint UNSIGNED NOT NULL,
  `contact_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lib_floor_room_rack_dtls`
--

DROP TABLE IF EXISTS `lib_floor_room_rack_dtls`;
CREATE TABLE IF NOT EXISTS `lib_floor_room_rack_dtls` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `company_id` bigint UNSIGNED NOT NULL,
  `location_id` bigint UNSIGNED NOT NULL,
  `store_id` bigint UNSIGNED NOT NULL,
  `floor_id` bigint UNSIGNED NOT NULL,
  `room_id` bigint UNSIGNED DEFAULT NULL,
  `rack_id` bigint UNSIGNED DEFAULT NULL,
  `shelf_id` bigint UNSIGNED DEFAULT NULL,
  `bin_id` bigint UNSIGNED DEFAULT NULL,
  `serial_no` int NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lib_floor_room_rack_mst`
--

DROP TABLE IF EXISTS `lib_floor_room_rack_mst`;
CREATE TABLE IF NOT EXISTS `lib_floor_room_rack_mst` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `company_id` bigint UNSIGNED NOT NULL,
  `floor_room_rack_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lib_group`
--

DROP TABLE IF EXISTS `lib_group`;
CREATE TABLE IF NOT EXISTS `lib_group` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `group_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_short_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint UNSIGNED DEFAULT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lib_group`
--

INSERT INTO `lib_group` (`id`, `group_name`, `group_short_name`, `country_id`, `website`, `address`, `email`, `contact_no`, `contact_person`, `created_by`, `updated_by`, `image`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Sait', 'Sait', 1, 'sait.com', 'Nihalpur', 'admin@sait.com', '789', 'Helal Uddin', 1, 1, NULL, NULL, '2023-06-27 13:11:42', '2023-06-29 04:29:05');

-- --------------------------------------------------------

--
-- Table structure for table `lib_item_group`
--

DROP TABLE IF EXISTS `lib_item_group`;
CREATE TABLE IF NOT EXISTS `lib_item_group` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_category_id` bigint UNSIGNED NOT NULL,
  `conversion_factor` double(8,2) NOT NULL DEFAULT '1.00',
  `cons_uom` int DEFAULT NULL,
  `item_group_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_uom` int DEFAULT NULL,
  `item_type` int DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lib_item_group`
--

INSERT INTO `lib_item_group` (`id`, `item_name`, `item_category_id`, `conversion_factor`, `cons_uom`, `item_group_code`, `order_uom`, `item_type`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Mobile', 1, 1.00, NULL, 'E-00001', NULL, NULL, 1, 1, NULL, '2023-06-29 06:46:12', '2023-06-29 07:41:22'),
(2, 'Computer', 1, 1.00, NULL, 'E-00002', NULL, NULL, 1, 1, NULL, '2023-06-29 06:58:49', '2023-06-29 07:37:03');

-- --------------------------------------------------------

--
-- Table structure for table `lib_item_sub_group`
--

DROP TABLE IF EXISTS `lib_item_sub_group`;
CREATE TABLE IF NOT EXISTS `lib_item_sub_group` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sub_group_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_category_id` bigint UNSIGNED NOT NULL,
  `item_group_id` bigint UNSIGNED NOT NULL,
  `sub_group_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lib_item_sub_group`
--

INSERT INTO `lib_item_sub_group` (`id`, `sub_group_name`, `item_category_id`, `item_group_id`, `sub_group_code`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Apple', 1, 1, 'I-00001', NULL, NULL, NULL, '2023-06-30 00:23:28', '2023-06-30 00:23:28');

-- --------------------------------------------------------

--
-- Table structure for table `lib_location`
--

DROP TABLE IF EXISTS `lib_location`;
CREATE TABLE IF NOT EXISTS `lib_location` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `location_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `country_id` bigint UNSIGNED DEFAULT NULL,
  `contact_person` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lib_size`
--

DROP TABLE IF EXISTS `lib_size`;
CREATE TABLE IF NOT EXISTS `lib_size` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `size_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entry_form` int DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lib_size`
--

INSERT INTO `lib_size` (`id`, `size_name`, `entry_form`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '32', NULL, NULL, NULL, NULL, '2023-06-28 10:55:19', '2023-06-28 13:52:52'),
(2, '36', NULL, NULL, NULL, NULL, '2023-06-28 10:56:22', '2023-06-28 13:45:30'),
(3, '44', NULL, NULL, NULL, NULL, '2023-06-28 13:01:06', '2023-06-28 13:01:06'),
(4, '56', NULL, NULL, NULL, NULL, '2023-06-28 15:32:57', '2023-06-28 15:32:57');

-- --------------------------------------------------------

--
-- Table structure for table `lib_store_location`
--

DROP TABLE IF EXISTS `lib_store_location`;
CREATE TABLE IF NOT EXISTS `lib_store_location` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `store_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `location_id` bigint UNSIGNED NOT NULL,
  `item_category_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lib_supplier`
--

DROP TABLE IF EXISTS `lib_supplier`;
CREATE TABLE IF NOT EXISTS `lib_supplier` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `party_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tag_company` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_site` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_table`
--




--
-- Table structure for table `main_menu`
--

DROP TABLE IF EXISTS `main_menu`;
CREATE TABLE IF NOT EXISTS `main_menu` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `m_menu_id` bigint UNSIGNED NOT NULL,
  `m_module_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `root_menu` bigint UNSIGNED NOT NULL DEFAULT '0',
  `sub_root_menu` bigint UNSIGNED NOT NULL DEFAULT '0',
  `menu_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `f_location` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `route_name` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `fabric_nature` int NOT NULL DEFAULT '0',
  `position` int NOT NULL DEFAULT '0',
  `status` int NOT NULL DEFAULT '0',
  `slno` int NOT NULL DEFAULT '0',
  `report_menu` int NOT NULL DEFAULT '0',
  `is_mobile_menu` int NOT NULL DEFAULT '0',
  `m_page_name` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `m_page_short_name` varchar(200) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `inserted_by` bigint UNSIGNED DEFAULT NULL,
  `insert_date` timestamp NULL DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT NULL,
  `status_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `main_menu`
--

INSERT INTO `main_menu` (`id`, `m_menu_id`, `m_module_id`, `root_menu`, `sub_root_menu`, `menu_name`, `f_location`, `route_name`, `fabric_nature`, `position`, `status`, `slno`, `report_menu`, `is_mobile_menu`, `m_page_name`, `m_page_short_name`, `inserted_by`, `insert_date`, `updated_by`, `update_date`, `status_active`, `is_deleted`, `deleted_at`) VALUES
(1, 5, 10, 0, 0, 'Menu Management', 'tools/create_menu', 'create_menu', 0, 1, 1, 2, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL),
(2, 4, 10, 0, 0, 'Module Management', 'tools/create_main_module', 'tools.create_main_module', 0, 1, 1, 1, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL),
(3, 3, 10, 0, 0, 'Privilege Management', 'tools/user_previledge', 'tools.user_previledge', 113, 1, 1, 3, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL),
(4, 6, 1, 8, 0, 'Company', 'lib/company', NULL, 113, 2, 1, 1, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL),
(5, 7, 1, 0, 0, 'General', '', NULL, 113, 1, 1, 1, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL),
(8, 8, 1, 0, 0, 'Cost Center', '', NULL, 113, 1, 1, 1, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL),
(9, 9, 1, 8, 0, 'Group Profile', 'lib/group', NULL, 113, 2, 1, 0, 0, 0, NULL, NULL, 2, NULL, NULL, NULL, 1, 0, NULL),
(11, 11, 1, 7, 0, 'Color Entry', 'lib/general/color', NULL, 0, 2, 1, 1, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL),
(13, 12, 1, 7, 0, 'Size Entry', 'lib/general/size', NULL, 0, 2, 1, 2, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL),
(14, 13, 1, 7, 0, 'Country Entry', 'lib/general/country', NULL, 0, 2, 1, 3, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL),
(15, 14, 1, 0, 0, 'Item Details', '', NULL, 0, 1, 1, 3, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL),
(16, 15, 1, 14, 0, 'Item Category List', 'lib/item_details/item_category', NULL, 0, 2, 1, 1, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL),
(17, 16, 1, 14, 0, 'Item Group', 'lib/item_details/item_group', NULL, 0, 2, 1, 2, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL),
(18, 17, 1, 14, 0, 'Item Sub Group', 'lib/item_details/item_sub_group', NULL, 0, 2, 1, 4, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL),
(19, 18, 10, 0, 0, 'Mandatory Field', 'tools/mandatory_field', NULL, 0, 1, 1, 4, 0, 0, NULL, NULL, 1, NULL, NULL, NULL, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `main_module`
--

DROP TABLE IF EXISTS `main_module`;
CREATE TABLE IF NOT EXISTS `main_module` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `m_mod_id` bigint UNSIGNED NOT NULL,
  `main_module` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `file_name` varchar(333) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `mod_slno` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `main_module_main_module_unique` (`main_module`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `main_module`
--

INSERT INTO `main_module` (`id`, `m_mod_id`, `main_module`, `file_name`, `status`, `mod_slno`, `created_at`, `updated_at`) VALUES
(1, 10, 'Admin', NULL, 1, 1, '2023-06-24 03:23:52', '2023-06-25 13:48:32'),
(2, 1, 'Lib', NULL, 1, 2, '2023-06-24 03:23:52', '2023-06-25 13:10:52');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_02_25_162743_create_permissions_table', 1),
(30, '2023_02_26_010050_create_logs_table', 9),
(7, '2023_03_30_135628_create_main_modules_table', 1),
(8, '2023_03_30_232043_create_main_menus_table', 1),
(9, '2023_03_31_002654_create_user_priv_modules_table', 1),
(10, '2023_03_31_004123_create_user_priv_msts_table', 1),
(31, '2023_04_05_150231_create_lib_item_category_lists_table', 10),
(27, '2023_06_24_120120_create_companies_table', 7),
(13, '2023_06_26_102110_create_groups_table', 3),
(14, '2023_06_26_102151_create_lib_suppliers_table', 3),
(15, '2023_06_26_102207_create_lib_buyers_table', 3),
(16, '2023_06_26_103917_create_lib_item_groups_table', 3),
(17, '2023_06_26_104001_create_lib_item_sub_groups_table', 3),
(18, '2023_06_26_104141_create_product_details_masters_table', 3),
(19, '2023_06_26_104304_create_lib_colors_table', 4),
(20, '2023_06_26_104316_create_lib_sizes_table', 4),
(21, '2023_06_26_104349_create_lib_locations_table', 5),
(22, '2023_06_26_104929_create_lib_store_locations_table', 5),
(23, '2023_06_26_104951_create_lib_employees_table', 5),
(24, '2023_06_26_105919_create_lib_floor_room_rack_msts_table', 5),
(25, '2023_06_26_105929_create_lib_floor_room_rack_dtls_table', 5),
(26, '2023_06_26_190145_create_image_uploads_table', 6),
(28, '2023_06_28_172131_create_lib_countries_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_user`
--

DROP TABLE IF EXISTS `permission_user`;
CREATE TABLE IF NOT EXISTS `permission_user` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `permission_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_user_permission_id_foreign` (`permission_id`),
  KEY `permission_user_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `product_details_master`
--

DROP TABLE IF EXISTS `product_details_master`;
CREATE TABLE IF NOT EXISTS `product_details_master` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_name_details` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint UNSIGNED NOT NULL,
  `item_category_id` bigint UNSIGNED NOT NULL,
  `item_group_id` bigint UNSIGNED NOT NULL,
  `supplier_id` bigint UNSIGNED DEFAULT NULL,
  `store_id` bigint UNSIGNED DEFAULT NULL,
  `detarmination_id` bigint UNSIGNED DEFAULT NULL,
  `avg_rate_per_unit` double(15,6) NOT NULL DEFAULT '0.000000',
  `current_stock` double(15,6) NOT NULL DEFAULT '0.000000',
  `stock_value` double(15,6) NOT NULL DEFAULT '0.000000',
  `item_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_account` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `packing_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lot` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '2023-06-24 03:23:52', '$2y$10$fm6ccsFPqIPTq8LG6qeub.Qsofm3gZx46BQCy5FyMkw3DjiGAY1H2', 'X3b2dOWEACepJfoOfnqNiOnFp16JsKp6HBu1sI5tSvkc6AieXs75cX8FVK0X', '2023-06-24 03:23:52', '2023-06-24 03:23:52'),
(2, 'Helal Uddin', 'helal@gmail.com', NULL, '$2y$10$vrUWyBfwKL0AeKzKf0C/5OkivLRmS.qLVA.Kcb.nXwQHz.UIx8Rpq', NULL, '2023-06-26 02:19:33', '2023-06-26 02:19:33');

-- --------------------------------------------------------

--
-- Table structure for table `user_priv_module`
--

DROP TABLE IF EXISTS `user_priv_module`;
CREATE TABLE IF NOT EXISTS `user_priv_module` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `module_id` bigint UNSIGNED NOT NULL,
  `user_only` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `valid` int NOT NULL DEFAULT '0',
  `entry_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_priv_module`
--

INSERT INTO `user_priv_module` (`id`, `user_id`, `module_id`, `user_only`, `valid`, `entry_date`, `created_at`, `updated_at`) VALUES
(1, 1, 10, NULL, 1, NULL, '2023-06-24 03:23:52', '2023-06-24 03:23:52'),
(2, 1, 1, NULL, 1, NULL, '2023-06-24 03:23:52', '2023-06-24 03:23:52'),
(5, 2, 10, NULL, 1, NULL, '2023-06-29 03:33:08', '2023-06-29 03:33:08'),
(4, 2, 1, NULL, 1, NULL, '2023-06-26 02:20:46', '2023-06-26 02:20:46');

-- --------------------------------------------------------

--
-- Table structure for table `user_priv_mst`
--

DROP TABLE IF EXISTS `user_priv_mst`;
CREATE TABLE IF NOT EXISTS `user_priv_mst` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `main_menu_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `show_priv` bigint UNSIGNED NOT NULL DEFAULT '2',
  `delete_priv` bigint UNSIGNED NOT NULL DEFAULT '2',
  `save_priv` bigint UNSIGNED NOT NULL DEFAULT '2',
  `edit_priv` bigint UNSIGNED NOT NULL DEFAULT '2',
  `approve_priv` bigint UNSIGNED NOT NULL DEFAULT '2',
  `entry_date` int NOT NULL DEFAULT '0',
  `user_only` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `last_updated_by` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `inserted_by` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `valid` int NOT NULL DEFAULT '0',
  `last_update_date` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_priv_mst`
--

INSERT INTO `user_priv_mst` (`id`, `user_id`, `main_menu_id`, `show_priv`, `delete_priv`, `save_priv`, `edit_priv`, `approve_priv`, `entry_date`, `user_only`, `last_updated_by`, `inserted_by`, `valid`, `last_update_date`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 1, 1, 1, 1, 1, 0, NULL, NULL, NULL, 1, 0, '2023-06-24 03:23:52', '2023-06-24 03:23:52'),
(2, 1, 4, 1, 1, 1, 1, 1, 0, NULL, NULL, NULL, 1, 0, '2023-06-24 03:23:52', '2023-06-24 03:23:52'),
(3, 1, 5, 1, 1, 1, 1, 1, 0, NULL, NULL, NULL, 1, 0, '2023-06-24 03:23:52', '2023-06-24 03:23:52'),
(19, 1, 9, 1, 1, 1, 1, 1, 1687737600, NULL, NULL, '2', 1, 0, '2023-06-26 10:25:55', '2023-06-26 10:25:55'),
(33, 1, 12, 1, 1, 1, 1, 1, 1687910400, NULL, NULL, '1', 1, 0, '2023-06-28 10:41:12', '2023-06-28 10:41:12'),
(11, 1, 6, 1, 1, 1, 1, 1, 1687737600, NULL, NULL, '1', 1, 0, '2023-06-26 01:14:22', '2023-06-26 01:14:22'),
(37, 1, 13, 1, 1, 1, 1, 1, 1687910400, NULL, NULL, '1', 1, 0, '2023-06-28 11:30:41', '2023-06-28 11:30:41'),
(35, 2, 12, 1, 1, 1, 1, 1, 1687910400, NULL, NULL, '1', 1, 0, '2023-06-28 10:41:12', '2023-06-28 10:41:12'),
(18, 1, 8, 1, 1, 1, 1, 1, 1687737600, NULL, NULL, '2', 1, 0, '2023-06-26 10:25:55', '2023-06-26 10:25:55'),
(36, 1, 7, 1, 1, 1, 1, 1, 1687910400, NULL, NULL, '1', 1, 0, '2023-06-28 11:30:41', '2023-06-28 11:30:41'),
(17, 2, 6, 1, 1, 1, 1, 1, 1687737600, NULL, NULL, '1', 1, 0, '2023-06-26 02:20:46', '2023-06-26 02:20:46'),
(24, 2, 8, 1, 2, 1, 2, 2, 1687824000, NULL, NULL, '2', 1, 0, '2023-06-27 01:01:15', '2023-06-27 01:01:15'),
(25, 2, 9, 1, 2, 1, 2, 2, 1687824000, NULL, NULL, '2', 1, 0, '2023-06-27 01:01:15', '2023-06-27 01:01:15'),
(27, 2, 10, 1, 2, 2, 2, 2, 1687824000, NULL, NULL, '2', 1, 0, '2023-06-27 01:03:19', '2023-06-27 01:03:19'),
(29, 1, 11, 1, 1, 1, 1, 1, 1687910400, NULL, NULL, '1', 1, 0, '2023-06-28 08:36:32', '2023-06-28 08:36:32'),
(31, 2, 11, 1, 1, 1, 1, 1, 1687910400, NULL, NULL, '1', 1, 0, '2023-06-28 08:36:45', '2023-06-28 08:36:45'),
(38, 2, 7, 1, 1, 1, 1, 1, 1687910400, NULL, NULL, '1', 1, 0, '2023-06-28 11:30:41', '2023-06-28 11:30:41'),
(39, 2, 13, 1, 1, 1, 1, 1, 1687910400, NULL, NULL, '1', 1, 0, '2023-06-28 11:30:41', '2023-06-28 11:30:41'),
(43, 2, 15, 1, 1, 1, 1, 1, 1687996800, NULL, NULL, '1', 1, 0, '2023-06-29 03:35:44', '2023-06-29 03:35:44'),
(47, 1, 16, 1, 1, 1, 1, 1, 1687996800, NULL, NULL, '1', 1, 0, '2023-06-29 06:05:06', '2023-06-29 06:05:06'),
(57, 2, 17, 1, 2, 2, 2, 2, 1688083200, NULL, NULL, '1', 1, 0, '2023-06-30 00:38:34', '2023-06-30 00:38:34'),
(45, 1, 15, 1, 1, 1, 1, 1, 1687996800, NULL, NULL, '1', 1, 0, '2023-06-29 03:35:44', '2023-06-29 03:35:44'),
(56, 2, 14, 1, 2, 2, 2, 2, 1688083200, NULL, NULL, '1', 1, 0, '2023-06-30 00:38:34', '2023-06-30 00:38:34'),
(49, 2, 16, 1, 1, 1, 1, 1, 1687996800, NULL, NULL, '1', 1, 0, '2023-06-29 06:05:06', '2023-06-29 06:05:06'),
(52, 1, 14, 1, 1, 1, 1, 1, 1688083200, NULL, NULL, '1', 1, 0, '2023-06-29 21:44:53', '2023-06-29 21:44:53'),
(53, 1, 17, 1, 1, 1, 1, 1, 1688083200, NULL, NULL, '1', 1, 0, '2023-06-29 21:44:53', '2023-06-29 21:44:53'),
(58, 2, 18, 1, 1, 1, 1, 1, 1688083200, NULL, NULL, '1', 1, 0, '2023-06-30 02:01:40', '2023-06-30 02:01:40'),
(59, 1, 18, 1, 1, 1, 1, 1, 1688083200, NULL, NULL, '1', 1, 0, '2023-06-30 02:01:40', '2023-06-30 02:01:40');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
