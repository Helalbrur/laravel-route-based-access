-- MySQL dump 10.13  Distrib 8.3.0, for Win64 (x86_64)
--
-- Host: localhost    Database: route_based_authentication
-- ------------------------------------------------------
-- Server version	8.3.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `buyer_payments`
--

DROP TABLE IF EXISTS `buyer_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `buyer_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buyer_id` bigint unsigned NOT NULL,
  `compoany_id` bigint unsigned NOT NULL,
  `date` date NOT NULL DEFAULT '2023-11-24',
  `amount` double(15,6) NOT NULL DEFAULT '0.000000',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buyer_payments`
--

LOCK TABLES `buyer_payments` WRITE;
/*!40000 ALTER TABLE `buyer_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `buyer_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expense_heads`
--

DROP TABLE IF EXISTS `expense_heads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expense_heads` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expense_heads`
--

LOCK TABLES `expense_heads` WRITE;
/*!40000 ALTER TABLE `expense_heads` DISABLE KEYS */;
/*!40000 ALTER TABLE `expense_heads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expenses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `head_id` bigint unsigned NOT NULL,
  `compoany_id` bigint unsigned NOT NULL,
  `date` date NOT NULL DEFAULT '2023-11-24',
  `amount` double(15,6) NOT NULL DEFAULT '0.000000',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses`
--

LOCK TABLES `expenses` WRITE;
/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
/*!40000 ALTER TABLE `expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `field_level_access`
--

DROP TABLE IF EXISTS `field_level_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `field_level_access` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `field_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_value` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mst_id` bigint unsigned NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `page_id` bigint unsigned NOT NULL,
  `field_id` bigint unsigned NOT NULL,
  `is_disable` bigint unsigned NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `field_level_access`
--

LOCK TABLES `field_level_access` WRITE;
/*!40000 ALTER TABLE `field_level_access` DISABLE KEYS */;
INSERT INTO `field_level_access` VALUES (6,'txt_item_group_code','12345',6,1,1,3,1,1,1,NULL,'2023-11-17 02:31:50','2023-11-17 02:31:50'),(7,'cbo_country_name','1',7,1,1,8,1,1,1,NULL,'2023-11-17 12:18:29','2023-11-17 12:18:29');
/*!40000 ALTER TABLE `field_level_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `field_managers`
--

DROP TABLE IF EXISTS `field_managers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `field_managers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `field_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_message` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `field_id` bigint unsigned NOT NULL,
  `is_hide` enum('Yes','No') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No',
  `user_id` bigint unsigned NOT NULL,
  `entry_form` bigint unsigned NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `field_managers`
--

LOCK TABLES `field_managers` WRITE;
/*!40000 ALTER TABLE `field_managers` DISABLE KEYS */;
/*!40000 ALTER TABLE `field_managers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image_uploads`
--

DROP TABLE IF EXISTS `image_uploads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `image_uploads` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `sys_no` bigint unsigned NOT NULL,
  `page_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image_uploads`
--

LOCK TABLES `image_uploads` WRITE;
/*!40000 ALTER TABLE `image_uploads` DISABLE KEYS */;
INSERT INTO `image_uploads` VALUES (31,'common_uploads/lgoin_pg_bg_white.png_1402091_company_profile.png','1',1,'company_profile',1,NULL,'2023-06-28 16:07:56','2023-06-28 16:07:56'),(29,'common_uploads/lgoin_pg_bg.png_509596_group_profile.png','1',5,'group_profile',1,NULL,'2023-06-28 16:00:44','2023-06-28 16:00:44');
/*!40000 ALTER TABLE `image_uploads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `income_heads`
--

DROP TABLE IF EXISTS `income_heads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `income_heads` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `income_heads`
--

LOCK TABLES `income_heads` WRITE;
/*!40000 ALTER TABLE `income_heads` DISABLE KEYS */;
/*!40000 ALTER TABLE `income_heads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `incomes`
--

DROP TABLE IF EXISTS `incomes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `incomes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `head_id` bigint unsigned NOT NULL,
  `compoany_id` bigint unsigned NOT NULL,
  `date` date NOT NULL DEFAULT '2023-11-24',
  `amount` double(15,6) NOT NULL DEFAULT '0.000000',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `incomes`
--

LOCK TABLES `incomes` WRITE;
/*!40000 ALTER TABLE `incomes` DISABLE KEYS */;
/*!40000 ALTER TABLE `incomes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inv_issue_master`
--

DROP TABLE IF EXISTS `inv_issue_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inv_issue_master` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `compoany_id` bigint unsigned NOT NULL,
  `sys_number_prefix` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sys_number_prefix_num` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sys_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `buyer_id` bigint unsigned DEFAULT NULL,
  `date` date NOT NULL DEFAULT '2023-11-24',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inv_issue_master`
--

LOCK TABLES `inv_issue_master` WRITE;
/*!40000 ALTER TABLE `inv_issue_master` DISABLE KEYS */;
/*!40000 ALTER TABLE `inv_issue_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inv_receive_master`
--

DROP TABLE IF EXISTS `inv_receive_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inv_receive_master` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `compoany_id` bigint unsigned NOT NULL,
  `sys_number_prefix` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sys_number_prefix_num` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sys_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `date` date NOT NULL DEFAULT '2023-11-24',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inv_receive_master`
--

LOCK TABLES `inv_receive_master` WRITE;
/*!40000 ALTER TABLE `inv_receive_master` DISABLE KEYS */;
/*!40000 ALTER TABLE `inv_receive_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inv_stores`
--

DROP TABLE IF EXISTS `inv_stores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inv_stores` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `barcode_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mst_id` bigint unsigned NOT NULL,
  `trans_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `store_id` bigint unsigned DEFAULT NULL,
  `room_rack_id` bigint unsigned DEFAULT NULL,
  `quantity` double(15,6) NOT NULL DEFAULT '0.000000',
  `rate` double(15,6) NOT NULL DEFAULT '0.000000',
  `amount` double(15,6) NOT NULL DEFAULT '0.000000',
  `date` date NOT NULL DEFAULT '2023-11-24',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inv_stores`
--

LOCK TABLES `inv_stores` WRITE;
/*!40000 ALTER TABLE `inv_stores` DISABLE KEYS */;
/*!40000 ALTER TABLE `inv_stores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inv_transaction`
--

DROP TABLE IF EXISTS `inv_transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inv_transaction` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` int NOT NULL,
  `mst_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `store_id` bigint unsigned DEFAULT NULL,
  `room_rack_id` bigint unsigned DEFAULT NULL,
  `quantity` double(15,6) NOT NULL DEFAULT '0.000000',
  `rate` double(15,6) NOT NULL DEFAULT '0.000000',
  `amount` double(15,6) NOT NULL DEFAULT '0.000000',
  `date` date NOT NULL DEFAULT '2023-11-24',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inv_transaction`
--

LOCK TABLES `inv_transaction` WRITE;
/*!40000 ALTER TABLE `inv_transaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `inv_transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_brand`
--

DROP TABLE IF EXISTS `lib_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_brand` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `buyer_id` bigint unsigned DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_brand`
--

LOCK TABLES `lib_brand` WRITE;
/*!40000 ALTER TABLE `lib_brand` DISABLE KEYS */;
INSERT INTO `lib_brand` VALUES (1,'Armani',2,1,NULL,'2025-02-08 13:49:53','2025-02-08 13:49:53',NULL),(2,'Gentle Park',1,1,NULL,'2025-02-08 13:53:51','2025-02-08 13:53:51',NULL),(3,'Local Brand',2,1,NULL,'2025-02-08 14:26:39','2025-02-08 14:26:39',NULL);
/*!40000 ALTER TABLE `lib_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_buyer`
--

DROP TABLE IF EXISTS `lib_buyer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_buyer` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buyer_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint DEFAULT NULL,
  `party_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tag_company` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_site` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_buyer`
--

LOCK TABLES `lib_buyer` WRITE;
/*!40000 ALTER TABLE `lib_buyer` DISABLE KEYS */;
INSERT INTO `lib_buyer` VALUES (1,'Md. Helal Uddin','Helal Uddin',1,'1,2,3,8','1',NULL,NULL,NULL,NULL,NULL,1,1,NULL,'2023-11-24 05:10:08','2025-02-16 09:01:50'),(2,'Mango','Mango',1,'1','1',NULL,NULL,NULL,'mango@gmail.com',NULL,1,1,NULL,'2025-02-08 13:08:57','2025-02-16 09:31:48');
/*!40000 ALTER TABLE `lib_buyer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_buyer_tag_company`
--

DROP TABLE IF EXISTS `lib_buyer_tag_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_buyer_tag_company` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buyer_id` bigint unsigned NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lib_buyer_tag_company_company_id_foreign` (`company_id`),
  KEY `lib_buyer_tag_company_buyer_id_foreign` (`buyer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_buyer_tag_company`
--

LOCK TABLES `lib_buyer_tag_company` WRITE;
/*!40000 ALTER TABLE `lib_buyer_tag_company` DISABLE KEYS */;
INSERT INTO `lib_buyer_tag_company` VALUES (23,1,1,'2025-02-16 09:36:20','2025-02-16 09:36:20'),(20,2,1,'2025-02-16 09:34:18','2025-02-16 09:34:18');
/*!40000 ALTER TABLE `lib_buyer_tag_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_buyer_tag_parties`
--

DROP TABLE IF EXISTS `lib_buyer_tag_parties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_buyer_tag_parties` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `buyer_id` bigint unsigned NOT NULL,
  `party_type` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lib_buyer_tag_parties_buyer_id_foreign` (`buyer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_buyer_tag_parties`
--

LOCK TABLES `lib_buyer_tag_parties` WRITE;
/*!40000 ALTER TABLE `lib_buyer_tag_parties` DISABLE KEYS */;
/*!40000 ALTER TABLE `lib_buyer_tag_parties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_category`
--

DROP TABLE IF EXISTS `lib_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_category` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_category`
--

LOCK TABLES `lib_category` WRITE;
/*!40000 ALTER TABLE `lib_category` DISABLE KEYS */;
INSERT INTO `lib_category` VALUES (1,'Electronics','Electronics',1,NULL,'2023-06-29 05:40:52','2023-06-29 05:40:52',NULL),(2,'Cloths','Cloths',1,NULL,'2023-06-29 07:28:00','2023-06-29 07:28:00',NULL);
/*!40000 ALTER TABLE `lib_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_color`
--

DROP TABLE IF EXISTS `lib_color`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_color` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `color_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `entry_form` int DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_color`
--

LOCK TABLES `lib_color` WRITE;
/*!40000 ALTER TABLE `lib_color` DISABLE KEYS */;
INSERT INTO `lib_color` VALUES (1,'Black',NULL,NULL,NULL,NULL,'2023-06-28 10:08:37','2023-12-15 06:26:17'),(2,'White',NULL,NULL,NULL,NULL,'2023-06-28 10:11:38','2023-12-15 06:25:03'),(5,'new color',NULL,NULL,NULL,'2023-12-15 07:09:34','2023-12-15 07:09:22','2023-12-15 07:09:34'),(6,'Green',NULL,NULL,NULL,NULL,'2023-12-15 07:09:26','2023-12-16 02:30:46'),(7,'Blue',NULL,NULL,NULL,NULL,'2025-02-16 09:55:56','2025-02-16 09:55:56');
/*!40000 ALTER TABLE `lib_color` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_company`
--

DROP TABLE IF EXISTS `lib_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_company` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_short_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_id` bigint unsigned NOT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_company`
--

LOCK TABLES `lib_company` WRITE;
/*!40000 ALTER TABLE `lib_company` DISABLE KEYS */;
INSERT INTO `lib_company` VALUES (1,'Sait','Sait',1,'Nishapur','sait.com','admin@sait.com','01758502951',NULL,1,NULL,'2023-06-28 01:34:16','2025-02-16 08:39:06',NULL);
/*!40000 ALTER TABLE `lib_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_country`
--

DROP TABLE IF EXISTS `lib_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_country` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `country_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_country`
--

LOCK TABLES `lib_country` WRITE;
/*!40000 ALTER TABLE `lib_country` DISABLE KEYS */;
INSERT INTO `lib_country` VALUES (1,'Bangladesh',NULL,'2023-06-28 11:48:20','2023-06-28 11:48:20'),(2,'UAE',NULL,'2023-06-28 11:48:50','2025-02-16 09:57:59'),(4,'Indonesia',NULL,'2025-02-16 09:58:12','2025-02-16 09:58:12');
/*!40000 ALTER TABLE `lib_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_employee`
--

DROP TABLE IF EXISTS `lib_employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_employee` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `id_card_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `national_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` int NOT NULL,
  `designation_id` bigint unsigned NOT NULL,
  `contact_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_employee`
--

LOCK TABLES `lib_employee` WRITE;
/*!40000 ALTER TABLE `lib_employee` DISABLE KEYS */;
/*!40000 ALTER TABLE `lib_employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_floor`
--

DROP TABLE IF EXISTS `lib_floor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_floor` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `floor_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `location_id` bigint unsigned NOT NULL,
  `store_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seq` int DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_floor`
--

LOCK TABLES `lib_floor` WRITE;
/*!40000 ALTER TABLE `lib_floor` DISABLE KEYS */;
INSERT INTO `lib_floor` VALUES (1,'1st Floor',1,2,'1',2,1,1,'2023-11-25 08:29:11','2025-02-22 05:56:36',NULL);
/*!40000 ALTER TABLE `lib_floor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_floor_room_rack_dtls`
--

DROP TABLE IF EXISTS `lib_floor_room_rack_dtls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_floor_room_rack_dtls` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `location_id` bigint unsigned NOT NULL,
  `store_id` bigint unsigned NOT NULL,
  `floor_id` bigint unsigned NOT NULL,
  `room_id` bigint unsigned DEFAULT NULL,
  `rack_id` bigint unsigned DEFAULT NULL,
  `shelf_id` bigint unsigned DEFAULT NULL,
  `bin_id` bigint unsigned DEFAULT NULL,
  `serial_no` int NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_floor_room_rack_dtls`
--

LOCK TABLES `lib_floor_room_rack_dtls` WRITE;
/*!40000 ALTER TABLE `lib_floor_room_rack_dtls` DISABLE KEYS */;
INSERT INTO `lib_floor_room_rack_dtls` VALUES (1,1,2,1,1,1,NULL,NULL,NULL,0,1,NULL,NULL,'2025-02-22 09:21:21','2025-02-22 09:21:21'),(2,1,2,1,1,2,NULL,NULL,NULL,0,1,NULL,NULL,'2025-02-22 10:45:56','2025-02-22 10:45:56');
/*!40000 ALTER TABLE `lib_floor_room_rack_dtls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_floor_room_rack_mst`
--

DROP TABLE IF EXISTS `lib_floor_room_rack_mst`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_floor_room_rack_mst` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint unsigned NOT NULL,
  `floor_room_rack_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_floor_room_rack_mst`
--

LOCK TABLES `lib_floor_room_rack_mst` WRITE;
/*!40000 ALTER TABLE `lib_floor_room_rack_mst` DISABLE KEYS */;
INSERT INTO `lib_floor_room_rack_mst` VALUES (1,1,'42th room',1,NULL,NULL,'2025-02-22 09:21:20','2025-02-22 09:21:20'),(2,1,'New Room',1,NULL,NULL,'2025-02-22 10:45:56','2025-02-22 10:45:56');
/*!40000 ALTER TABLE `lib_floor_room_rack_mst` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_generic`
--

DROP TABLE IF EXISTS `lib_generic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_generic` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `generic_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entry_form` int DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lib_generic_generic_name_unique` (`generic_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_generic`
--

LOCK TABLES `lib_generic` WRITE;
/*!40000 ALTER TABLE `lib_generic` DISABLE KEYS */;
/*!40000 ALTER TABLE `lib_generic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_group`
--

DROP TABLE IF EXISTS `lib_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_group` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_short_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint unsigned DEFAULT NULL,
  `website` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_group`
--

LOCK TABLES `lib_group` WRITE;
/*!40000 ALTER TABLE `lib_group` DISABLE KEYS */;
INSERT INTO `lib_group` VALUES (1,'Sait','Sait',1,'sait.com','Nishapur','admin@sait.com','789','Helal Uddin',1,1,NULL,NULL,'2023-06-27 13:11:42','2025-02-16 08:38:48');
/*!40000 ALTER TABLE `lib_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_item_group`
--

DROP TABLE IF EXISTS `lib_item_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_item_group` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `item_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_category_id` bigint unsigned NOT NULL,
  `conversion_factor` double(8,2) NOT NULL DEFAULT '1.00',
  `cons_uom` int DEFAULT NULL,
  `item_group_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_uom` int DEFAULT NULL,
  `item_type` int DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_item_group`
--

LOCK TABLES `lib_item_group` WRITE;
/*!40000 ALTER TABLE `lib_item_group` DISABLE KEYS */;
INSERT INTO `lib_item_group` VALUES (1,'Mobile',1,1.00,NULL,'E-00001',NULL,NULL,1,1,NULL,'2023-06-29 06:46:12','2023-06-29 07:41:22'),(2,'Computer',1,1.00,NULL,'E-00002',NULL,NULL,1,1,NULL,'2023-06-29 06:58:49','2023-06-29 07:37:03');
/*!40000 ALTER TABLE `lib_item_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_item_sub_category`
--

DROP TABLE IF EXISTS `lib_item_sub_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_item_sub_category` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `item_category_id` bigint unsigned DEFAULT NULL,
  `sub_category_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_item_sub_category`
--

LOCK TABLES `lib_item_sub_category` WRITE;
/*!40000 ALTER TABLE `lib_item_sub_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `lib_item_sub_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_item_sub_group`
--

DROP TABLE IF EXISTS `lib_item_sub_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_item_sub_group` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sub_group_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_category_id` bigint unsigned NOT NULL,
  `item_group_id` bigint unsigned NOT NULL,
  `sub_group_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_item_sub_group`
--

LOCK TABLES `lib_item_sub_group` WRITE;
/*!40000 ALTER TABLE `lib_item_sub_group` DISABLE KEYS */;
INSERT INTO `lib_item_sub_group` VALUES (1,'Apple',1,1,'I-00001',NULL,NULL,NULL,'2023-06-30 00:23:28','2023-06-30 00:23:28');
/*!40000 ALTER TABLE `lib_item_sub_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_location`
--

DROP TABLE IF EXISTS `lib_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_location` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `location_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `country_id` bigint unsigned DEFAULT NULL,
  `contact_person` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_location`
--

LOCK TABLES `lib_location` WRITE;
/*!40000 ALTER TABLE `lib_location` DISABLE KEYS */;
INSERT INTO `lib_location` VALUES (1,'Aricha',1,1,'Md. Helal Uddin','01758502951','info@sait.com','http://sait.com.com','Aricha Ghat , Shivalaya , Manikganj',1,1,NULL,'2023-11-18 08:35:57','2023-11-18 09:16:08'),(2,'Gulshan 2',1,1,'contact','98347939848','newmail@gmail.com','sait.com',NULL,1,1,NULL,'2023-11-24 04:58:09','2025-02-16 08:40:50');
/*!40000 ALTER TABLE `lib_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_report_template`
--

DROP TABLE IF EXISTS `lib_report_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_report_template` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `company_id` bigint NOT NULL,
  `module_id` bigint unsigned NOT NULL,
  `report_id` bigint unsigned NOT NULL,
  `format_id` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_report_template`
--

LOCK TABLES `lib_report_template` WRITE;
/*!40000 ALTER TABLE `lib_report_template` DISABLE KEYS */;
INSERT INTO `lib_report_template` VALUES (1,1,1,1,'1,2','1,2,3',1,NULL,'2023-12-16 04:31:50','2023-12-16 04:31:50',NULL);
/*!40000 ALTER TABLE `lib_report_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_size`
--

DROP TABLE IF EXISTS `lib_size`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_size` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `size_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `entry_form` int DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_size`
--

LOCK TABLES `lib_size` WRITE;
/*!40000 ALTER TABLE `lib_size` DISABLE KEYS */;
INSERT INTO `lib_size` VALUES (1,'32',NULL,NULL,NULL,NULL,'2023-06-28 10:55:19','2023-06-28 13:52:52'),(2,'36',NULL,NULL,NULL,NULL,'2023-06-28 10:56:22','2023-06-28 13:45:30'),(3,'44',NULL,NULL,NULL,NULL,'2023-06-28 13:01:06','2023-06-28 13:01:06'),(4,'57',NULL,NULL,NULL,NULL,'2023-06-28 15:32:57','2023-12-15 07:10:10');
/*!40000 ALTER TABLE `lib_size` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_store_location`
--

DROP TABLE IF EXISTS `lib_store_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_store_location` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `store_location` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` bigint unsigned NOT NULL,
  `location_id` bigint unsigned NOT NULL,
  `item_category_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_store_location`
--

LOCK TABLES `lib_store_location` WRITE;
/*!40000 ALTER TABLE `lib_store_location` DISABLE KEYS */;
INSERT INTO `lib_store_location` VALUES (1,'General Store','General Store',1,2,'1,2',NULL,NULL,NULL,'2023-11-25 02:27:44','2023-11-25 02:27:44');
/*!40000 ALTER TABLE `lib_store_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_store_tag_categories`
--

DROP TABLE IF EXISTS `lib_store_tag_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_store_tag_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `store_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lib_store_tag_categories_category_id_foreign` (`category_id`),
  KEY `lib_store_tag_categories_store_id_foreign` (`store_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_store_tag_categories`
--

LOCK TABLES `lib_store_tag_categories` WRITE;
/*!40000 ALTER TABLE `lib_store_tag_categories` DISABLE KEYS */;
INSERT INTO `lib_store_tag_categories` VALUES (3,1,1,'2023-11-25 06:59:57','2023-11-25 06:59:57'),(2,1,2,'2023-11-25 02:27:45','2023-11-25 02:27:45'),(4,1,2,'2023-11-25 06:59:57','2023-11-25 06:59:57');
/*!40000 ALTER TABLE `lib_store_tag_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_supplier`
--

DROP TABLE IF EXISTS `lib_supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_supplier` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint DEFAULT NULL,
  `party_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tag_company` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `web_site` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_supplier`
--

LOCK TABLES `lib_supplier` WRITE;
/*!40000 ALTER TABLE `lib_supplier` DISABLE KEYS */;
INSERT INTO `lib_supplier` VALUES (1,'Md. Helal Uddin','Helal',1,'1,5,6,130','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2023-11-24 12:47:02','2023-11-24 12:47:02');
/*!40000 ALTER TABLE `lib_supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_supplier_tag_company`
--

DROP TABLE IF EXISTS `lib_supplier_tag_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_supplier_tag_company` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` bigint unsigned NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lib_supplier_tag_company_company_id_foreign` (`company_id`),
  KEY `lib_supplier_tag_company_supplier_id_foreign` (`supplier_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_supplier_tag_company`
--

LOCK TABLES `lib_supplier_tag_company` WRITE;
/*!40000 ALTER TABLE `lib_supplier_tag_company` DISABLE KEYS */;
INSERT INTO `lib_supplier_tag_company` VALUES (1,1,1,'2023-11-24 12:47:02','2023-11-24 12:47:02');
/*!40000 ALTER TABLE `lib_supplier_tag_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_supplier_tag_parties`
--

DROP TABLE IF EXISTS `lib_supplier_tag_parties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_supplier_tag_parties` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` bigint unsigned NOT NULL,
  `party_type` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lib_supplier_tag_parties_supplier_id_foreign` (`supplier_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_supplier_tag_parties`
--

LOCK TABLES `lib_supplier_tag_parties` WRITE;
/*!40000 ALTER TABLE `lib_supplier_tag_parties` DISABLE KEYS */;
/*!40000 ALTER TABLE `lib_supplier_tag_parties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lib_uom`
--

DROP TABLE IF EXISTS `lib_uom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lib_uom` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uom_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entry_form` int DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lib_uom`
--

LOCK TABLES `lib_uom` WRITE;
/*!40000 ALTER TABLE `lib_uom` DISABLE KEYS */;
/*!40000 ALTER TABLE `lib_uom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_table`
--

DROP TABLE IF EXISTS `log_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_table` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `query` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `log_table_created_by_foreign` (`created_by`)
) ENGINE=MyISAM AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_table`
--

LOCK TABLES `log_table` WRITE;
/*!40000 ALTER TABLE `log_table` DISABLE KEYS */;
INSERT INTO `log_table` VALUES (86,'update `lib_color` set `color_name` = \'White color\', `lib_color`.`updated_at` = \'2023-12-15 11:04:08\' where `id` = 2','lib_color',1,'2023-12-15 05:04:08','2023-12-15 05:04:08'),(87,'update `lib_color` set `color_name` = \'White\', `lib_color`.`updated_at` = \'2023-12-15 11:04:24\' where `id` = 2','lib_color',1,'2023-12-15 05:04:24','2023-12-15 05:04:24'),(88,'update `lib_color` set `color_name` = \'White test\', `lib_color`.`updated_at` = \'2023-12-15 11:09:34\' where `id` = 2','lib_color',1,'2023-12-15 05:09:34','2023-12-15 05:09:34'),(89,'insert into `main_menu` (`m_module_id`, `root_menu`, `sub_root_menu`, `menu_name`, `m_menu_id`, `f_location`, `position`, `status`, `slno`, `report_menu`, `fabric_nature`, `is_mobile_menu`, `m_page_name`, `m_page_short_name`, `inserted_by`, `status_active`, `is_deleted`) values (1, 0, 0, \'Variable Setting\', 33, \'\', 1, 1, 5, 0, 0, 0, \'\', \'\', 1, 1, 0)','main_menu',1,'2023-12-15 21:50:48','2023-12-15 21:50:48'),(90,'delete from user_priv_mst where main_menu_id in( select m_menu_id from main_menu where m_module_id=1 and root_menu=33) and user_id in (1)','',1,'2023-12-15 21:51:13','2023-12-15 21:51:13'),(91,'delete from user_priv_mst where main_menu_id in ( select m_menu_id from main_menu where m_module_id=1) and user_id in (1) and main_menu_id=33','',1,'2023-12-15 21:51:13','2023-12-15 21:51:13'),(92,'insert into `user_priv_mst` (`user_id`, `main_menu_id`, `show_priv`, `delete_priv`, `save_priv`, `edit_priv`, `approve_priv`, `valid`, `inserted_by`, `entry_date`, `updated_at`, `created_at`) values (1, 33, 1, 1, 1, 1, 1, 1, 1, 1702684800, \'2023-12-16 03:51:13\', \'2023-12-16 03:51:13\')','user_priv_mst',1,'2023-12-15 21:51:13','2023-12-15 21:51:13'),(93,'insert into `main_menu` (`m_module_id`, `root_menu`, `sub_root_menu`, `menu_name`, `m_menu_id`, `f_location`, `position`, `status`, `slno`, `report_menu`, `fabric_nature`, `is_mobile_menu`, `m_page_name`, `m_page_short_name`, `inserted_by`, `status_active`, `is_deleted`) values (1, 33, 0, \'Report Setting\', 34, \'lib/variable_setting/report_setting\', 2, 1, 1, 0, 0, 0, \'\', \'\', 1, 1, 0)','main_menu',1,'2023-12-15 21:53:24','2023-12-15 21:53:24'),(94,'delete from user_priv_mst where main_menu_id in ( select m_menu_id from main_menu where m_module_id=1 and sub_root_menu in (34)) and user_id  in (1)','',1,'2023-12-15 21:53:45','2023-12-15 21:53:45'),(95,'delete from user_priv_mst where main_menu_id in ( select m_menu_id from main_menu where  m_module_id=1 ) and user_id in (1) and main_menu_id=33','',1,'2023-12-15 21:53:45','2023-12-15 21:53:45'),(96,'delete from user_priv_mst where main_menu_id in( select m_menu_id from main_menu where m_module_id=1) and user_id in (1) and main_menu_id=34','',1,'2023-12-15 21:53:45','2023-12-15 21:53:45'),(97,'insert into `user_priv_mst` (`user_id`, `main_menu_id`, `show_priv`, `delete_priv`, `save_priv`, `edit_priv`, `approve_priv`, `valid`, `inserted_by`, `entry_date`, `updated_at`, `created_at`) values (1, 33, 1, 1, 1, 1, 1, 1, 1, 1702684800, \'2023-12-16 03:53:45\', \'2023-12-16 03:53:45\')','user_priv_mst',1,'2023-12-15 21:53:45','2023-12-15 21:53:45'),(98,'insert into `user_priv_mst` (`user_id`, `main_menu_id`, `show_priv`, `delete_priv`, `save_priv`, `edit_priv`, `approve_priv`, `valid`, `inserted_by`, `entry_date`, `updated_at`, `created_at`) values (1, 34, 1, 1, 1, 1, 1, 1, 1, 1702684800, \'2023-12-16 03:53:45\', \'2023-12-16 03:53:45\')','user_priv_mst',1,'2023-12-15 21:53:45','2023-12-15 21:53:45'),(99,'create table `lib_report_template` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(191) not null, `module_id` bigint unsigned not null, `report_id` bigint unsigned not null, `format_id` bigint unsigned not null, `user_id` bigint unsigned not null, `created_by` bigint unsigned null, `updated_by` bigint unsigned null, `created_at` timestamp null, `updated_at` timestamp null, `deleted_at` timestamp null) default character set utf8mb4 collate \'utf8mb4_unicode_ci\'','',NULL,'2023-12-15 22:12:56','2023-12-15 22:12:56'),(100,'insert into `migrations` (`migration`, `batch`) values (\'2023_12_16_035835_create_report_settings_table\', 15)','migrations',NULL,'2023-12-15 22:12:56','2023-12-15 22:12:56'),(101,'update `main_module` set `mod_slno` = 9, `main_module`.`updated_at` = \'2023-12-16 06:40:40\' where `id` = 1','main_module',1,'2023-12-16 00:40:41','2023-12-16 00:40:41'),(102,'update `lib_color` set `color_name` = \'Blue\', `lib_color`.`updated_at` = \'2023-12-16 08:30:25\' where `id` = 6','lib_color',1,'2023-12-16 02:30:26','2023-12-16 02:30:26'),(103,'update `lib_color` set `color_name` = \'Green\', `lib_color`.`updated_at` = \'2023-12-16 08:30:46\' where `id` = 6','lib_color',1,'2023-12-16 02:30:46','2023-12-16 02:30:46'),(104,'insert into `image_uploads` (`file_name`, `file_type`, `sys_no`, `page_name`, `created_by`, `updated_at`, `created_at`) values (\'common_uploads/Screen Capture #008.png_59124_group_profile.png\', 1, 1, \'group_profile\', 1, \'2023-12-16 09:58:08\', \'2023-12-16 09:58:08\')','image_uploads',1,'2023-12-16 03:58:08','2023-12-16 03:58:08'),(105,'delete from `image_uploads` where `id` = 36','image_uploads',1,'2023-12-16 03:58:24','2023-12-16 03:58:24'),(106,'insert into `lib_report_template` (`company_id`, `module_id`, `report_id`, `format_id`, `user_id`, `created_by`, `updated_at`, `created_at`) values (1, 1, 1, \'1,2\', \'1,2,3\', 1, \'2023-12-16 10:31:50\', \'2023-12-16 10:31:50\')','lib_report_template',1,'2023-12-16 04:31:50','2023-12-16 04:31:50'),(107,'update `lib_floor` set `updated_by` = 1, `lib_floor`.`updated_at` = \'2023-12-16 17:38:33\' where `id` = 1','lib_floor',1,'2023-12-16 11:38:34','2023-12-16 11:38:34');
/*!40000 ALTER TABLE `log_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `main_menu`
--

DROP TABLE IF EXISTS `main_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `main_menu` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `m_menu_id` bigint unsigned NOT NULL,
  `m_module_id` bigint unsigned NOT NULL DEFAULT '0',
  `root_menu` bigint unsigned NOT NULL DEFAULT '0',
  `sub_root_menu` bigint unsigned NOT NULL DEFAULT '0',
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
  `inserted_by` bigint unsigned DEFAULT NULL,
  `insert_date` timestamp NULL DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT NULL,
  `status_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `main_menu`
--

LOCK TABLES `main_menu` WRITE;
/*!40000 ALTER TABLE `main_menu` DISABLE KEYS */;
INSERT INTO `main_menu` VALUES (1,5,10,0,0,'Menu Management','tools/create_menu','create_menu',0,1,1,2,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(2,4,10,0,0,'Module Management','tools/create_main_module','tools.create_main_module',0,1,1,1,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(3,3,10,0,0,'Privilege Management','tools/user_previledge','tools.user_previledge',113,1,1,3,0,0,NULL,NULL,NULL,NULL,NULL,NULL,1,0,NULL),(4,6,1,8,0,'Company','lib/company',NULL,113,2,1,1,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(5,7,1,0,0,'General','',NULL,113,1,1,1,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(8,8,1,0,0,'Cost Center','',NULL,113,1,1,1,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(9,9,1,8,0,'Group Profile','lib/group',NULL,113,2,1,0,0,0,NULL,NULL,2,NULL,NULL,NULL,1,0,NULL),(11,11,1,7,0,'Color Entry','lib/general/color',NULL,0,2,1,1,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(13,12,1,7,0,'Size Entry','lib/general/size',NULL,0,2,1,2,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(14,13,1,7,0,'Country Entry','lib/general/country',NULL,0,2,1,3,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(15,14,1,0,0,'Item Details','',NULL,0,1,1,3,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(16,15,1,14,0,'Item Category List','lib/item_details/item_category',NULL,0,2,1,1,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(17,16,1,14,0,'Item Group','lib/item_details/item_group',NULL,0,2,1,2,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(18,17,1,14,0,'Item Sub Group','lib/item_details/item_sub_group',NULL,0,2,1,4,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(19,18,10,0,0,'Mandatory Field','tools/mandatory_field',NULL,0,1,1,4,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(20,19,10,0,0,'Field Level Access','tools/field_level_access',NULL,0,1,1,5,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(21,20,10,0,0,'Manual Database Backup','db_backup',NULL,0,1,1,6,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(22,21,1,8,0,'Location','lib/location',NULL,0,2,1,3,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(23,22,1,0,0,'Contact Details','',NULL,0,1,1,1,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(24,23,1,22,0,'Buyer Profile','lib/buyer',NULL,0,2,1,1,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(25,24,1,22,0,'Supplier Prpfile','lib/supplier',NULL,0,2,1,2,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(26,25,1,0,0,'Inventory','',NULL,0,1,1,5,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(27,26,1,25,0,'Floor Setup','lib/inventory/floor',NULL,0,2,1,1,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(28,27,1,25,0,'Room','lib/inventory/room',NULL,0,2,1,2,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(29,28,1,25,0,'Rack','lib/inventory/rack',NULL,0,2,1,3,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(30,29,1,25,0,'Shelf','lib/inventory/shelf',NULL,0,2,1,4,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(31,30,1,25,0,'Bin','lib/inventory/bin',NULL,0,2,1,5,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(32,31,1,7,0,'Store Location','lib/general/store',NULL,0,2,1,4,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(33,32,10,0,0,'User Management','tools/user_management',NULL,0,1,1,7,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(34,33,1,0,0,'Variable Setting','',NULL,0,1,1,5,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(35,34,1,33,0,'Report Setting','lib/variable_setting/report_setting',NULL,0,2,1,1,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(36,35,1,7,0,'Brand Entry','lib/general/brand',NULL,0,2,1,5,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(37,36,1,7,0,'Generic','lib/general/generic',NULL,0,2,1,6,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL),(38,37,1,22,0,'Employee','lib/employee',NULL,0,2,1,3,0,0,NULL,NULL,1,NULL,NULL,NULL,1,0,NULL);
/*!40000 ALTER TABLE `main_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `main_module`
--

DROP TABLE IF EXISTS `main_module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `main_module` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `m_mod_id` bigint unsigned NOT NULL,
  `main_module` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin NOT NULL,
  `file_name` varchar(333) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `mod_slno` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `main_module_main_module_unique` (`main_module`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `main_module`
--

LOCK TABLES `main_module` WRITE;
/*!40000 ALTER TABLE `main_module` DISABLE KEYS */;
INSERT INTO `main_module` VALUES (1,10,'Admin',NULL,1,9,'2023-06-24 03:23:52','2023-12-16 00:40:40'),(2,1,'Lib',NULL,1,1,'2023-06-24 03:23:52','2023-11-18 10:35:27');
/*!40000 ALTER TABLE `main_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mandatory_field`
--

DROP TABLE IF EXISTS `mandatory_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mandatory_field` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `field_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_message` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_id` bigint unsigned NOT NULL,
  `field_id` bigint unsigned NOT NULL,
  `is_mandatory` bigint unsigned NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mandatory_field`
--

LOCK TABLES `mandatory_field` WRITE;
/*!40000 ALTER TABLE `mandatory_field` DISABLE KEYS */;
INSERT INTO `mandatory_field` VALUES (4,'txt_item_group_code','Item Group Code',3,1,0,1,NULL,'2023-10-14 02:35:19','2023-10-14 02:35:19'),(5,'cbo_country_name','Country Name',8,1,1,1,NULL,'2023-11-17 11:08:52','2023-11-17 11:08:52'),(6,'cbo_tag_company_name','Tag Company Name',9,1,1,1,NULL,'2023-11-24 04:28:48','2023-11-24 04:28:48'),(7,'cbo_tag_party_name','Tag Party Name',9,2,1,1,NULL,'2023-11-24 04:28:48','2023-11-24 04:28:48'),(9,'cbo_tag_company_name','Tag Company Name',10,1,1,1,NULL,'2023-11-24 12:24:23','2023-11-24 12:24:23'),(10,'cbo_tag_party_name','Tag Party Name',10,2,1,1,NULL,'2023-11-24 12:24:23','2023-11-24 12:24:23');
/*!40000 ALTER TABLE `mandatory_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2023_02_25_162743_create_permissions_table',1),(30,'2023_02_26_010050_create_logs_table',9),(7,'2023_03_30_135628_create_main_modules_table',1),(8,'2023_03_30_232043_create_main_menus_table',1),(9,'2023_03_31_002654_create_user_priv_modules_table',1),(10,'2023_03_31_004123_create_user_priv_msts_table',1),(31,'2023_04_05_150231_create_lib_item_category_lists_table',10),(27,'2023_06_24_120120_create_companies_table',7),(13,'2023_06_26_102110_create_groups_table',3),(14,'2023_06_26_102151_create_lib_suppliers_table',3),(15,'2023_06_26_102207_create_lib_buyers_table',3),(16,'2023_06_26_103917_create_lib_item_groups_table',3),(17,'2023_06_26_104001_create_lib_item_sub_groups_table',3),(18,'2023_06_26_104141_create_product_details_masters_table',3),(19,'2023_06_26_104304_create_lib_colors_table',4),(20,'2023_06_26_104316_create_lib_sizes_table',4),(21,'2023_06_26_104349_create_lib_locations_table',5),(22,'2023_06_26_104929_create_lib_store_locations_table',5),(23,'2023_06_26_104951_create_lib_employees_table',5),(24,'2023_06_26_105919_create_lib_floor_room_rack_msts_table',5),(25,'2023_06_26_105929_create_lib_floor_room_rack_dtls_table',5),(26,'2023_06_26_190145_create_image_uploads_table',6),(28,'2023_06_28_172131_create_lib_countries_table',8),(34,'2023_11_24_154706_create_lib_buyer_tag_companies_table',11),(35,'2023_11_24_183141_create_lib_supplier_tag_companies_table',12),(36,'2023_11_25_080618_create_lib_store_tag_categories_table',13),(37,'2023_11_25_133247_create_lib_floors_table',14),(38,'2023_12_16_035835_create_report_settings_table',15),(39,'2025_02_07_183434_create_brands_table',16),(40,'2025_02_08_035433_create_field_managers_table',17),(41,'2023_06_30_080542_create_mandatories_table',17),(42,'2023_06_30_080542_create_mandatories_table',17),(43,'2023_06_30_080608_create_field_level_accesses_table',17),(44,'2023_07_25_162720_create_inv_receive_masters_table',17),(45,'2023_07_25_162736_create_inv_issue_masters_table',17),(46,'2023_07_25_162752_create_inv_transactions_table',17),(47,'2023_07_25_162807_create_inv_stores_table',17),(48,'2023_07_25_163004_create_buyer_payments_table',17),(49,'2023_07_25_163028_create_supplier_payments_table',17),(50,'2023_07_25_163112_create_expense_heads_table',17),(51,'2023_07_25_163123_create_expenses_table',17),(52,'2023_07_25_163142_create_incomes_table',17),(53,'2023_07_25_172849_create_income_heads_table',17),(54,'2025_02_08_055747_create_lib_uom_table',18),(55,'2025_02_09_175732_create_lib_generic_table',18),(56,'2025_02_13_181223_create_lib_item_sub_category',18),(57,'2025_02_15_095338_create_lib_buyer_tag_parties_table',18),(58,'2025_02_15_095407_create_lib_supplier_tag_parties_table',18),(59,'2025_02_17_164451_add_multi_columns_to_product_details_master',18);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_user`
--

DROP TABLE IF EXISTS `permission_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permission_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_user_permission_id_foreign` (`permission_id`),
  KEY `permission_user_user_id_foreign` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_user`
--

LOCK TABLES `permission_user` WRITE;
/*!40000 ALTER TABLE `permission_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `route_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_details_master`
--

DROP TABLE IF EXISTS `product_details_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_details_master` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `item_description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_name_details` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uom` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` bigint unsigned NOT NULL,
  `item_category_id` bigint unsigned NOT NULL,
  `item_group_id` bigint unsigned NOT NULL,
  `supplier_id` bigint unsigned DEFAULT NULL,
  `store_id` bigint unsigned DEFAULT NULL,
  `detarmination_id` bigint unsigned DEFAULT NULL,
  `avg_rate_per_unit` double(15,6) NOT NULL DEFAULT '0.000000',
  `current_stock` double(15,6) NOT NULL DEFAULT '0.000000',
  `stock_value` double(15,6) NOT NULL DEFAULT '0.000000',
  `item_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_account` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `packing_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lot` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `generic_id` int DEFAULT NULL,
  `item_sub_category_id` int DEFAULT NULL,
  `item_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_origin` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand_id` int DEFAULT NULL,
  `dosage_form` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_uom` int DEFAULT NULL,
  `order_uom_qty` int DEFAULT NULL,
  `consuption_uom` int DEFAULT NULL,
  `consuption_uom_qty` int DEFAULT NULL,
  `conversion_fac` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size_id` int NOT NULL DEFAULT '1',
  `power` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_details_master`
--

LOCK TABLES `product_details_master` WRITE;
/*!40000 ALTER TABLE `product_details_master` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_details_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplier_payments`
--

DROP TABLE IF EXISTS `supplier_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supplier_payments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` bigint unsigned NOT NULL,
  `compoany_id` bigint unsigned NOT NULL,
  `date` date NOT NULL DEFAULT '2023-11-24',
  `amount` double(15,6) NOT NULL DEFAULT '0.000000',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplier_payments`
--

LOCK TABLES `supplier_payments` WRITE;
/*!40000 ALTER TABLE `supplier_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `supplier_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_priv_module`
--

DROP TABLE IF EXISTS `user_priv_module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_priv_module` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL DEFAULT '0',
  `module_id` bigint unsigned NOT NULL,
  `user_only` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `valid` int NOT NULL DEFAULT '0',
  `entry_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_priv_module`
--

LOCK TABLES `user_priv_module` WRITE;
/*!40000 ALTER TABLE `user_priv_module` DISABLE KEYS */;
INSERT INTO `user_priv_module` VALUES (1,1,10,NULL,1,NULL,'2023-06-24 03:23:52','2023-06-24 03:23:52'),(2,1,1,NULL,1,NULL,'2023-06-24 03:23:52','2023-06-24 03:23:52'),(5,2,10,NULL,1,NULL,'2023-06-29 03:33:08','2023-06-29 03:33:08'),(4,2,1,NULL,1,NULL,'2023-06-26 02:20:46','2023-06-26 02:20:46'),(6,0,1,NULL,1,NULL,'2025-02-08 12:55:03','2025-02-08 12:55:03'),(7,3,1,NULL,1,NULL,'2025-02-08 12:55:03','2025-02-08 12:55:03');
/*!40000 ALTER TABLE `user_priv_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_priv_mst`
--

DROP TABLE IF EXISTS `user_priv_mst`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_priv_mst` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL DEFAULT '0',
  `main_menu_id` bigint unsigned NOT NULL DEFAULT '0',
  `show_priv` bigint unsigned NOT NULL DEFAULT '2',
  `delete_priv` bigint unsigned NOT NULL DEFAULT '2',
  `save_priv` bigint unsigned NOT NULL DEFAULT '2',
  `edit_priv` bigint unsigned NOT NULL DEFAULT '2',
  `approve_priv` bigint unsigned NOT NULL DEFAULT '2',
  `entry_date` int NOT NULL DEFAULT '0',
  `user_only` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `last_updated_by` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `inserted_by` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL,
  `valid` int NOT NULL DEFAULT '0',
  `last_update_date` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_priv_mst`
--

LOCK TABLES `user_priv_mst` WRITE;
/*!40000 ALTER TABLE `user_priv_mst` DISABLE KEYS */;
INSERT INTO `user_priv_mst` VALUES (1,1,3,1,1,1,1,1,0,NULL,NULL,NULL,1,0,'2023-06-24 03:23:52','2023-06-24 03:23:52'),(2,1,4,1,1,1,1,1,0,NULL,NULL,NULL,1,0,'2023-06-24 03:23:52','2023-06-24 03:23:52'),(3,1,5,1,1,1,1,1,0,NULL,NULL,NULL,1,0,'2023-06-24 03:23:52','2023-06-24 03:23:52'),(19,1,9,1,1,1,1,1,1687737600,NULL,NULL,'2',1,0,'2023-06-26 10:25:55','2023-06-26 10:25:55'),(33,1,12,1,1,1,1,1,1687910400,NULL,NULL,'1',1,0,'2023-06-28 10:41:12','2023-06-28 10:41:12'),(11,1,6,1,1,1,1,1,1687737600,NULL,NULL,'1',1,0,'2023-06-26 01:14:22','2023-06-26 01:14:22'),(37,1,13,1,1,1,1,1,1687910400,NULL,NULL,'1',1,0,'2023-06-28 11:30:41','2023-06-28 11:30:41'),(35,2,12,1,1,1,1,1,1687910400,NULL,NULL,'1',1,0,'2023-06-28 10:41:12','2023-06-28 10:41:12'),(66,1,21,1,1,1,1,1,1700179200,NULL,NULL,'1',1,0,'2023-11-17 10:50:03','2023-11-17 10:50:03'),(91,1,31,1,1,1,1,1,1700870400,NULL,NULL,'1',1,0,'2023-11-25 00:52:28','2023-11-25 00:52:28'),(17,2,6,1,1,1,1,1,1687737600,NULL,NULL,'1',1,0,'2023-06-26 02:20:46','2023-06-26 02:20:46'),(65,1,8,1,1,1,1,1,1700179200,NULL,NULL,'1',1,0,'2023-11-17 10:50:03','2023-11-17 10:50:03'),(25,2,9,1,2,1,2,2,1687824000,NULL,NULL,'2',1,0,'2023-06-27 01:01:15','2023-06-27 01:01:15'),(27,2,10,1,2,2,2,2,1687824000,NULL,NULL,'2',1,0,'2023-06-27 01:03:19','2023-06-27 01:03:19'),(29,1,11,1,1,1,1,1,1687910400,NULL,NULL,'1',1,0,'2023-06-28 08:36:32','2023-06-28 08:36:32'),(99,0,35,1,1,1,1,1,1738972800,NULL,NULL,'1',1,0,'2025-02-08 12:55:03','2025-02-08 12:55:03'),(61,2,11,1,2,1,2,2,1690329600,NULL,NULL,'1',1,0,'2023-07-26 10:55:04','2023-07-26 10:55:04'),(39,2,13,1,1,1,1,1,1687910400,NULL,NULL,'1',1,0,'2023-06-28 11:30:41','2023-06-28 11:30:41'),(43,2,15,1,1,1,1,1,1687996800,NULL,NULL,'1',1,0,'2023-06-29 03:35:44','2023-06-29 03:35:44'),(47,1,16,1,1,1,1,1,1687996800,NULL,NULL,'1',1,0,'2023-06-29 06:05:06','2023-06-29 06:05:06'),(57,2,17,1,2,2,2,2,1688083200,NULL,NULL,'1',1,0,'2023-06-30 00:38:34','2023-06-30 00:38:34'),(45,1,15,1,1,1,1,1,1687996800,NULL,NULL,'1',1,0,'2023-06-29 03:35:44','2023-06-29 03:35:44'),(56,2,14,1,2,2,2,2,1688083200,NULL,NULL,'1',1,0,'2023-06-30 00:38:34','2023-06-30 00:38:34'),(49,2,16,1,1,1,1,1,1687996800,NULL,NULL,'1',1,0,'2023-06-29 06:05:06','2023-06-29 06:05:06'),(52,1,14,1,1,1,1,1,1688083200,NULL,NULL,'1',1,0,'2023-06-29 21:44:53','2023-06-29 21:44:53'),(53,1,17,1,1,1,1,1,1688083200,NULL,NULL,'1',1,0,'2023-06-29 21:44:53','2023-06-29 21:44:53'),(58,2,18,1,1,1,1,1,1688083200,NULL,NULL,'1',1,0,'2023-06-30 02:01:40','2023-06-30 02:01:40'),(59,1,18,1,1,1,1,1,1688083200,NULL,NULL,'1',1,0,'2023-06-30 02:01:40','2023-06-30 02:01:40'),(62,1,19,1,1,1,1,1,1697241600,NULL,NULL,'1',1,0,'2023-10-14 02:18:31','2023-10-14 02:18:31'),(63,1,20,1,1,1,1,1,1700179200,NULL,NULL,'1',1,0,'2023-11-16 23:50:38','2023-11-16 23:50:38'),(64,2,20,1,1,1,1,1,1700179200,NULL,NULL,'1',1,0,'2023-11-16 23:50:38','2023-11-16 23:50:38'),(67,2,8,1,1,1,1,1,1700179200,NULL,NULL,'1',1,0,'2023-11-17 10:50:03','2023-11-17 10:50:03'),(68,2,21,1,1,1,1,1,1700179200,NULL,NULL,'1',1,0,'2023-11-17 10:50:03','2023-11-17 10:50:03'),(108,1,22,1,1,1,1,1,1740182400,NULL,NULL,'1',1,0,'2025-02-21 23:41:29','2025-02-21 23:41:29'),(71,1,23,1,1,1,1,1,1700265600,NULL,NULL,'1',1,0,'2023-11-18 10:29:47','2023-11-18 10:29:47'),(73,1,24,1,1,1,1,1,1700784000,NULL,NULL,'1',1,0,'2023-11-24 12:19:20','2023-11-24 12:19:20'),(81,1,26,1,1,1,1,1,1700784000,NULL,NULL,'1',1,0,'2023-11-24 13:17:33','2023-11-24 13:17:33'),(83,1,27,1,1,1,1,1,1700784000,NULL,NULL,'1',1,0,'2023-11-24 13:17:40','2023-11-24 13:17:40'),(85,1,28,1,1,1,1,1,1700784000,NULL,NULL,'1',1,0,'2023-11-24 13:17:46','2023-11-24 13:17:46'),(87,1,29,1,1,1,1,1,1700784000,NULL,NULL,'1',1,0,'2023-11-24 13:17:51','2023-11-24 13:17:51'),(89,1,30,1,1,1,1,1,1700784000,NULL,NULL,'1',1,0,'2023-11-24 13:17:56','2023-11-24 13:17:56'),(88,1,25,1,1,1,1,1,1700784000,NULL,NULL,'1',1,0,'2023-11-24 13:17:56','2023-11-24 13:17:56'),(98,0,7,1,1,1,1,1,1738972800,NULL,NULL,'1',1,0,'2025-02-08 12:55:03','2025-02-08 12:55:03'),(93,2,31,1,1,1,1,1,1700870400,NULL,NULL,'1',1,0,'2023-11-25 00:52:28','2023-11-25 00:52:28'),(94,1,32,1,1,1,1,1,1702598400,NULL,NULL,'1',1,0,'2023-12-14 23:16:17','2023-12-14 23:16:17'),(96,1,33,1,1,1,1,1,1702684800,NULL,NULL,'1',1,0,'2023-12-15 21:53:45','2023-12-15 21:53:45'),(97,1,34,1,1,1,1,1,1702684800,NULL,NULL,'1',1,0,'2023-12-15 21:53:45','2023-12-15 21:53:45'),(106,1,7,1,1,1,1,1,1740182400,NULL,NULL,'1',1,0,'2025-02-21 23:37:49','2025-02-21 23:37:49'),(101,1,35,1,1,1,1,1,1738972800,NULL,NULL,'1',1,0,'2025-02-08 12:55:03','2025-02-08 12:55:03'),(102,2,7,1,1,1,1,1,1738972800,NULL,NULL,'1',1,0,'2025-02-08 12:55:03','2025-02-08 12:55:03'),(103,2,35,1,1,1,1,1,1738972800,NULL,NULL,'1',1,0,'2025-02-08 12:55:03','2025-02-08 12:55:03'),(104,3,7,1,1,1,1,1,1738972800,NULL,NULL,'1',1,0,'2025-02-08 12:55:03','2025-02-08 12:55:03'),(105,3,35,1,1,1,1,1,1738972800,NULL,NULL,'1',1,0,'2025-02-08 12:55:03','2025-02-08 12:55:03'),(107,1,36,1,1,1,1,1,1740182400,NULL,NULL,'1',1,0,'2025-02-21 23:37:49','2025-02-21 23:37:49'),(109,1,37,1,1,1,1,1,1740182400,NULL,NULL,'1',1,0,'2025-02-21 23:41:29','2025-02-21 23:41:29');
/*!40000 ALTER TABLE `user_priv_mst` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@gmail.com','2023-06-24 03:23:52','$2y$10$fm6ccsFPqIPTq8LG6qeub.Qsofm3gZx46BQCy5FyMkw3DjiGAY1H2','0000345',1,'5uX9NrpYfOkMEiGzVfwyxZSaHwGzC4DhiF7gjWhVTyEdzTfETKTngHzztUaY','2023-06-24 03:23:52','2025-02-13 09:49:15',NULL),(2,'Helal Uddin','helal@gmail.com',NULL,'$2y$10$vrUWyBfwKL0AeKzKf0C/5OkivLRmS.qLVA.Kcb.nXwQHz.UIx8Rpq','029458874',3,NULL,'2023-06-26 02:19:33','2025-02-13 09:49:04',NULL),(3,'Himel','himel@gmail.com',NULL,'$2y$10$4Fp5tI5eNs2pUl.1/iNUKez1flgXFhwaThs3b4BuTy5DoSAUIdlLi','123456',3,NULL,'2023-12-15 00:11:30','2023-12-15 02:37:50',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-22 23:29:52
