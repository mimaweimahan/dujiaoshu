-- MySQL dump 10.13  Distrib 5.7.44, for Linux (x86_64)
--
-- Host: localhost    Database: session_dpdns_or
-- ------------------------------------------------------
-- Server version	5.7.44-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_menu`
--

DROP TABLE IF EXISTS `admin_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_menu` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uri` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extension` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `show` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_menu`
--

LOCK TABLES `admin_menu` WRITE;
/*!40000 ALTER TABLE `admin_menu` DISABLE KEYS */;
INSERT INTO `admin_menu` VALUES (1,0,1,'Index','feather icon-bar-chart-2','/','',1,'2021-05-16 02:06:08',NULL),(2,0,2,'Admin','feather icon-settings','','',1,'2021-05-16 02:06:08',NULL),(3,2,3,'Users','','auth/users','',1,'2021-05-16 02:06:08',NULL),(4,2,4,'Roles','','auth/roles','',1,'2021-05-16 02:06:08',NULL),(5,2,5,'Permission','','auth/permissions','',1,'2021-05-16 02:06:08',NULL),(6,2,6,'Menu','','auth/menu','',1,'2021-05-16 02:06:08',NULL),(7,2,7,'Extensions','','auth/extensions','',1,'2021-05-16 02:06:08',NULL),(11,0,9,'Goods_Manage','fa-shopping-bag',NULL,'',1,'2021-05-16 11:39:55','2021-05-23 20:44:20'),(12,11,11,'Goods','fa-shopping-bag','/goods','',1,'2021-05-16 11:44:35','2021-05-23 20:44:20'),(13,11,10,'Goods_Group','fa-star-half-o','/goods-group','',1,'2021-05-16 17:08:43','2021-05-23 20:44:20'),(14,0,12,'Carmis_Manage','fa-credit-card-alt',NULL,'',1,'2021-05-17 21:29:50','2021-05-23 20:44:20'),(15,14,13,'Carmis','fa-credit-card','/carmis','',1,'2021-05-17 21:37:59','2021-05-23 20:44:20'),(16,14,14,'Import_Carmis','fa-plus-circle','/import-carmis','',1,'2021-05-18 14:46:35','2021-05-23 20:44:20'),(17,18,16,'Coupon','fa-dollar','/coupon','',1,'2021-05-18 17:29:53','2021-05-23 20:44:20'),(18,0,15,'Coupon_Manage','fa-diamond',NULL,'',1,'2021-05-18 17:32:03','2021-05-18 17:32:03'),(19,0,17,'Configuration','fa-wrench',NULL,'',1,'2021-05-20 20:06:47','2021-05-23 20:44:20'),(20,19,18,'Email_Template_Configuration','fa-envelope','/emailtpl','',1,'2021-05-20 20:17:07','2021-05-23 20:44:20'),(21,19,19,'Pay_Configuration','fa-cc-visa','/pay','',1,'2021-05-20 20:41:24','2021-05-23 20:44:20'),(22,0,8,'Order_Manage','fa-table',NULL,'',1,'2021-05-23 20:43:43','2021-05-23 20:44:20'),(23,22,20,'Order','fa-heart','/order','',1,'2021-05-23 20:46:13','2021-05-23 20:47:16'),(24,19,21,'System_Setting','fa-cogs','/system-setting','',1,'2021-05-26 10:26:34','2021-05-26 10:26:34'),(25,19,22,'Email_Test','fa-envelope','/email-test','',1,'2022-07-26 12:09:34','2022-07-26 12:17:21'),(27,0,24,'邀请返利','fa-indent',NULL,'',1,'2022-11-01 13:15:25','2022-11-01 13:15:25'),(28,27,26,'返利记录','fa-calendar-check-o','/invite','',1,'2022-11-01 13:17:03','2022-11-01 13:18:51'),(29,27,27,'提现记录','fa-usd','/withdraw','',1,'2022-11-01 13:17:57','2022-11-01 13:18:51'),(30,27,25,'用户管理','fa-users','/user','',1,'2022-11-01 13:18:35','2022-11-01 13:18:51'),(31,0,28,'Article_Manage','fa-newspaper-o','','',1,'2023-07-10 22:05:50','2023-07-10 22:05:50'),(32,31,29,'Article_Category','fa-star-half-o','/article-category','',1,NULL,NULL),(33,31,30,'Article','fa-newspaper-o','/article','',1,NULL,NULL),(34,0,31,'other','fa-times-rectangle',NULL,'',1,'2025-09-29 01:38:44','2025-09-29 01:41:41'),(35,34,32,'Langs','fa-asl-interpreting','langs','',1,'2025-09-29 01:39:23','2025-09-29 01:39:23'),(36,34,33,'Buttons','fa-align-justify','buttons','',1,'2025-09-29 01:51:20','2025-09-29 01:51:20');
/*!40000 ALTER TABLE `admin_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_permission_menu`
--

DROP TABLE IF EXISTS `admin_permission_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_permission_menu` (
  `permission_id` bigint(20) NOT NULL,
  `menu_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `admin_permission_menu_permission_id_menu_id_unique` (`permission_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_permission_menu`
--

LOCK TABLES `admin_permission_menu` WRITE;
/*!40000 ALTER TABLE `admin_permission_menu` DISABLE KEYS */;
INSERT INTO `admin_permission_menu` VALUES (1,35,'2025-09-29 01:39:23','2025-09-29 01:39:23'),(1,36,'2025-09-29 01:51:20','2025-09-29 01:51:20'),(2,35,'2025-09-29 01:39:23','2025-09-29 01:39:23'),(2,36,'2025-09-29 01:51:20','2025-09-29 01:51:20'),(3,35,'2025-09-29 01:39:23','2025-09-29 01:39:23'),(3,36,'2025-09-29 01:51:20','2025-09-29 01:51:20'),(4,35,'2025-09-29 01:39:23','2025-09-29 01:39:23'),(4,36,'2025-09-29 01:51:20','2025-09-29 01:51:20'),(5,35,'2025-09-29 01:39:23','2025-09-29 01:39:23'),(5,36,'2025-09-29 01:51:20','2025-09-29 01:51:20'),(6,35,'2025-09-29 01:39:23','2025-09-29 01:39:23'),(6,36,'2025-09-29 01:51:20','2025-09-29 01:51:20');
/*!40000 ALTER TABLE `admin_permission_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_permissions`
--

DROP TABLE IF EXISTS `admin_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `http_path` longtext COLLATE utf8mb4_unicode_ci,
  `order` int(11) NOT NULL DEFAULT '0',
  `parent_id` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_permissions_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_permissions`
--

LOCK TABLES `admin_permissions` WRITE;
/*!40000 ALTER TABLE `admin_permissions` DISABLE KEYS */;
INSERT INTO `admin_permissions` VALUES (1,'Auth management','auth-management','','',1,0,'2021-05-16 02:06:08',NULL),(2,'Users','users','','/auth/users*',2,1,'2021-05-16 02:06:08',NULL),(3,'Roles','roles','','/auth/roles*',3,1,'2021-05-16 02:06:08',NULL),(4,'Permissions','permissions','','/auth/permissions*',4,1,'2021-05-16 02:06:08',NULL),(5,'Menu','menu','','/auth/menu*',5,1,'2021-05-16 02:06:08',NULL),(6,'Extension','extension','','/auth/extensions*',6,1,'2021-05-16 02:06:08',NULL);
/*!40000 ALTER TABLE `admin_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_role_menu`
--

DROP TABLE IF EXISTS `admin_role_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_role_menu` (
  `role_id` bigint(20) NOT NULL,
  `menu_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `admin_role_menu_role_id_menu_id_unique` (`role_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_role_menu`
--

LOCK TABLES `admin_role_menu` WRITE;
/*!40000 ALTER TABLE `admin_role_menu` DISABLE KEYS */;
INSERT INTO `admin_role_menu` VALUES (1,35,'2025-09-29 01:39:23','2025-09-29 01:39:23'),(1,36,'2025-09-29 01:51:20','2025-09-29 01:51:20');
/*!40000 ALTER TABLE `admin_role_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_role_permissions`
--

DROP TABLE IF EXISTS `admin_role_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_role_permissions` (
  `role_id` bigint(20) NOT NULL,
  `permission_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `admin_role_permissions_role_id_permission_id_unique` (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_role_permissions`
--

LOCK TABLES `admin_role_permissions` WRITE;
/*!40000 ALTER TABLE `admin_role_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_role_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_role_users`
--

DROP TABLE IF EXISTS `admin_role_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_role_users` (
  `role_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `admin_role_users_role_id_user_id_unique` (`role_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_role_users`
--

LOCK TABLES `admin_role_users` WRITE;
/*!40000 ALTER TABLE `admin_role_users` DISABLE KEYS */;
INSERT INTO `admin_role_users` VALUES (1,1,'2021-05-16 02:06:08','2021-05-16 02:06:08');
/*!40000 ALTER TABLE `admin_role_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_roles`
--

DROP TABLE IF EXISTS `admin_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_roles_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_roles`
--

LOCK TABLES `admin_roles` WRITE;
/*!40000 ALTER TABLE `admin_roles` DISABLE KEYS */;
INSERT INTO `admin_roles` VALUES (1,'Administrator','administrator','2021-05-16 02:06:08','2021-05-16 02:06:08');
/*!40000 ALTER TABLE `admin_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_settings`
--

DROP TABLE IF EXISTS `admin_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_settings` (
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_settings`
--

LOCK TABLES `admin_settings` WRITE;
/*!40000 ALTER TABLE `admin_settings` DISABLE KEYS */;
INSERT INTO `admin_settings` VALUES ('system-setting','{\"title\":\"\\u72ec\\u89d2\\u6570\\u5361\",\"img_logo\":null,\"text_logo\":null,\"keywords\":null,\"description\":null,\"template\":\"hyper\",\"language\":\"zh_CN\",\"manage_email\":null,\"is_open_anti_red\":0,\"is_open_wenzhang\":0,\"notice\":null,\"footer\":null,\"is_open_server_jiang\":0,\"server_jiang_token\":null,\"is_open_telegram_push\":0,\"telegram_bot_token\":null,\"telegram_userid\":null,\"is_open_bark_push\":0,\"is_open_bark_push_url\":0,\"bark_server\":null,\"bark_token\":null,\"is_open_qywxbot_push\":0,\"qywxbot_key\":null,\"driver\":\"smtp\",\"host\":null,\"port\":\"587\",\"username\":null,\"password\":null,\"encryption\":null,\"from_address\":null,\"from_name\":null,\"rjtitle\":\"\\u4eba\\u673a\\u9a8c\\u8bc1\",\"is_cn_allow\":0,\"cntitle\":\"\\u62b1\\u6b49\\uff0c\\u6682\\u65f6\\u4e0d\\u5bf9\\u4e2d\\u56fd\\u5730\\u533a\\u63d0\\u4f9b\\u8bbf\\u95ee\",\"is_cn_challenge\":1,\"is_open_pass\":1,\"cnpass\":\"8888\",\"is_open_login\":1,\"is_open_reg\":1,\"is_openreg_img_code\":0,\"is_openlogin_img_code\":0,\"is_openregxianzhi\":1,\"reg_ip_limits\":\"1\",\"open_czid\":\"0\",\"telegram_bot_api_token\":\"7974830006:AAHwVjB_S8vBI8md_U4cYIe_Je8DdGB6xsM\",\"telegram_bot_username\":\"huifeng001_bot\",\"telegram_api_proxy\":null,\"telegram_chat_id\":\"-1003076366863\",\"telegram_chat_id_notify\":null,\"is_open_new_goods_notify\":1,\"is_open_replenishment_notify\":1,\"is_open_price_reduce_notify\":1,\"order_expire_time\":\"5\",\"is_open_img_code\":0,\"order_ip_limits\":\"1000000\",\"is_open_search_pwd\":0,\"global_currency\":\"\\u00a5\",\"is_open_mail\":1,\"jg\":\"price\",\"geetest_id\":null,\"geetest_key\":null,\"is_open_geetest\":0,\"recharge_promotion\":[{\"amount\":\"50\",\"value\":\"0\"},{\"amount\":\"100\",\"value\":\"0\"},{\"amount\":\"300\",\"value\":\"0\"},{\"amount\":\"500\",\"value\":\"0\"},{\"amount\":\"1000\",\"value\":\"0\"},{\"amount\":\"1500\",\"value\":\"0\"}],\"regmoney\":0,\"daili_text\":null,\"gonggao_text\":null,\"guize_text\":null,\"tixian_text\":null,\"xn_products\":null,\"xn_quantities\":null,\"is_open_xn\":1,\"energy_api_token\":\"7eac9eddb7045a9507120aee4fdea4e9\",\"energy_api_secret\":\"ad6eb62c52ddb4c37ea655331c96b234288b4d8ffb92debf280dc1db73078b5c\",\"energy_buy_config\":\"{\\\"one_pen_amount\\\":1.5,\\\"one_pen_energy\\\":32000,\\\"two_pen_amount\\\":3,\\\"two_pen_energy\\\":64000}\",\"energy_address\":\"THPFdxnzvji6jezBsk3pj99RXPHF9puSui\",\"tronscan_api\":null,\"subscribe_api\":\"http:\\/\\/127.0.0.1:8008\",\"subscribe_buy_config\":\"{\\\"3\\\":12,\\\"6\\\":24,\\\"12\\\":48}\",\"fragment_hash\":\"7d79cb298f342a8c5b\",\"fragment_cookie\":\"stel_ssid=a281e0fcc4ab55d9cf_1944161465459466695; stel_dt=-480; stel_token=85b5c7c49e25cfc9ed50fe48272b4dfa85b5c7de85b5ca50cd9e87266b47ab8c5ab7a; stel_ton_token=qAPIX8Gq098JF7PWfhT7M55N80FbFPy2eXER1SIi3jFUOUedgZwvTJIKCyVytMStwElm7nn9QPmtZGLewis7rR-ZWlslMS0O2Vj72LpOyqOD8Sy9t-sksTnu5_eQrIl6zyUmBxcHwn8FT-KDtGNygikP6vmIeevfgoFviEAdmnXrqpRjAdlzFAxrlxaxkp60RXKhhvIJ\",\"chang_huiyuan\":\"api\",\"search_keyword\":\"q\",\"pay_image\":null,\"pay_image_api\":\"https:\\/\\/my.tv.sohu.com\\/user\\/a\\/wvideo\\/getQRCode.do?text=\",\"huilv\":\"7.2\",\"mini_deposit_amount\":\"10\",\"max_deposit_amount\":\"10000\",\"submit_search\":1,\"recharge_text\":\"USDT\",\"license_code\":\"28BF6986-A225-F53C-C1C7-76F7EA53D306\"}',NULL,'2025-10-20 14:11:58');
/*!40000 ALTER TABLE `admin_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES (1,'admin','$2y$10$e7z99Mhxm9BOHL55xHZTx.QcNTZJC6ftRXHCR/ZkBja/jBeasVeBy','Administrator',NULL,'4UAXF2BEw9EL1Tr2aGmwkv5DKwxqRF6djOMAHSiBMSOrPfPNHYrjCCQMtnTC','2021-05-16 02:06:08','2021-05-16 02:06:08');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article_category`
--

DROP TABLE IF EXISTS `article_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `category_name` varchar(100) DEFAULT NULL COMMENT '分类名称',
  `ord` int(11) DEFAULT NULL COMMENT '排序',
  `is_open` tinyint(1) DEFAULT NULL COMMENT '是否启用',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_category`
--

LOCK TABLES `article_category` WRITE;
/*!40000 ALTER TABLE `article_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `article_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `category_id` int(11) DEFAULT NULL COMMENT '文章分类',
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '文章链接',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文章标题',
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文章关键字',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文章描述',
  `picture` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '文章图片',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文章内容',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `idx_cat_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buttons`
--

DROP TABLE IF EXISTS `buttons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buttons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) DEFAULT NULL COMMENT '标题',
  `keyword` varchar(30) DEFAULT NULL COMMENT '关键词',
  `lang` varchar(30) DEFAULT NULL COMMENT '所属语言',
  `content` text COMMENT '内容',
  `mode` enum('HTML','MarkDown','MarkDownV2','') NOT NULL DEFAULT 'HTML' COMMENT '模式',
  `is_show` varchar(2) NOT NULL DEFAULT '0' COMMENT '是否展示url',
  `button_type` varchar(10) DEFAULT NULL,
  `button_json` text COMMENT '按钮内容',
  `created_at` varchar(30) NOT NULL COMMENT '创建时间',
  `updated_at` varchar(30) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buttons`
--

LOCK TABLES `buttons` WRITE;
/*!40000 ALTER TABLE `buttons` DISABLE KEYS */;
INSERT INTO `buttons` VALUES (1,'开始按钮','start','zh-CN','🌈欢迎光临TG机器人店铺,祝各位老板2025顺风顺水\r\n\r\n ✅本店业务 \r\n\r\n发卡机器人，索引机器人,  机器人定制开发 !\r\nTelegram营销工具，定制营销工具等 !\r\n________________________________________________________\r\n\r\n❗️ 未使用过的本店商品的，请先少量购买测试，以免造成不必要的争执！谢谢合作！\r\n\r\n❗️ 免责声明：本店所有商品，仅用于娱乐测试，不得用于违法活动！ 请遵守当地法律法规！\r\n\r\n✅近期风控严重，特友情提示\r\n\r\n‼️请先少量取货测试，如正常 可继续购买\r\n‼️批量取货完毕，请按照比例抽查帐号情况\r\n‼️如帐号有问题请两小时内留言我处理 过期不侯\r\n    不接受使用后售后\r\n________________________________________________________\r\n\r\n☎️ 客服： @111111  @22222\r\n🔊 频道： @33333     @44444\r\n♻️能量租用&TRX兑换:  @55555\r\n\r\n⚙️ /start   ⬅️点击命令打开底部菜单‼️','MarkDownV2','0',NULL,'[\r\n  [\r\n    \"👓用户中心\",\r\n    \"💳余额充值\"\r\n  ],\r\n  [\r\n    \"🛒购买商品\",\r\n    \"🛒自助开会员\"\r\n  ],\r\n  [\r\n    \"♻️订单列表\",\r\n    \"🌐修改语言\"\r\n  ]\r\n]','2025-09-29 01:55:11','2025-10-19 13:07:45'),(2,'帮助','help','zh-CN','欢迎使用发卡机器人\r\n我们的功能有发卡系统，能量租用系统，会员自助开通系统，星星购买系统\r\n发送 /start 为开始\r\n发送 /help 为帮助\r\n发送 /energy 为能量租用\r\n发送 /premium 为会员购买\r\n发送 /stars 为购买星星','HTML','0',NULL,'asdfasd','2025-09-29 04:11:17','2025-09-29 04:11:31'),(3,'能量购买','energy','zh-CN','1️⃣1.5TRX = 32000能量(转一笔)\r\n\r\n2️⃣3TRX = 64000能量(转2笔)\r\n\r\n💲转账地址`THPFdxnzvji6jezBsk3pj99RXPHF9puSui`\r\n\r\n转账成功能量自动到账','MarkDownV2','0',NULL,NULL,'2025-09-29 04:13:59','2025-10-09 20:48:30'),(4,'🛒自助开会员','premium','zh-CN','❗会员购买价格\r\n\r\n3️⃣3个月-12U\r\n\r\n6️⃣6个月-24U\r\n\r\n🔢12个月-48U\r\n\r\n购买后即刻到账，请选择下列选项','MarkDownV2','0',NULL,'[\r\n  [\r\n    {\r\n      \"text\": \"©️为自己购买\",\r\n      \"callback_data\": \"premiumself\"\r\n    },\r\n    {\r\n      \"text\": \"®️为他人购买\",\r\n      \"callback_data\": \"premiumother\"\r\n    }\r\n  ],\r\n  [\r\n    {\r\n      \"text\": \"❎关闭\",\r\n      \"callback_data\": \"close\"\r\n    }\r\n  ]\r\n]','2025-09-29 04:31:18','2025-10-09 21:42:55'),(5,'🛒购买商品','shoplist','zh-CN','🛒选择你需要的商品：\r\n❗️发送你需要的商品，会返回带有你输入的关键词的全部商品\r\n❗️购买本店商品，请先少量购买测试，避免造成不必要的争执！','MarkDownV2','0',NULL,NULL,'2025-09-29 05:33:59','2025-10-09 20:05:52'),(6,'关闭按钮','clone','zh-CN','关闭按钮','MarkDownV2','0',NULL,NULL,'2025-09-29 05:45:48','2025-09-29 05:45:48'),(7,'使用文档','use','zh-CN','这是使用说明','MarkDownV2','0',NULL,NULL,'2025-09-29 05:47:44','2025-09-29 05:49:36'),(8,'👓用户中心','my','zh-CN','您的ID:`{id}`\r\n用户名:@{username}\r\n余额:{amount} USDT','MarkDownV2','0',NULL,NULL,'2025-09-29 05:52:11','2025-10-19 10:11:50'),(9,'💳余额充值','recharge','zh-CN','💹选择下面充值订单金额️\r\n\r\n‼️点击对应金额 请严格按照提示小数点转账\r\n\r\n‼️请认真核对充值地址后十位 ：1234567890','MarkDownV2','0',NULL,NULL,'2025-09-29 05:58:55','2025-10-20 14:07:24'),(10,'选择支付方式','rechargeamount','zh-CN','请选择支付方式进行支付','MarkDownV2','0',NULL,NULL,'2025-09-29 18:54:46','2025-09-29 18:54:46'),(11,'充值确认页面','confirmrecharge','zh-CN','💰充值金额:{payamount} USDT(赠送 {amount} USDT)\r\n\r\n💸支付方式:{paytype}\r\n\r\n点击下方确认进行支付','MarkDownV2','0',NULL,'[\r\n  [\r\n    {\r\n      \"text\": \"✅确认\",\r\n      \"callback_data\": \"gorechargepay_{paytype}_{amount}\"\r\n    },\r\n    {\r\n      \"text\": \"❎关闭\",\r\n      \"callback_data\": \"close\"\r\n    }\r\n  ]\r\n]','2025-09-29 19:08:47','2025-10-09 20:52:56'),(12,'支付充值订单','gorechargepay','zh-CN','🔊订单号:`{ordersn}`\r\n\r\n💰支付金额:`{payamount}` USDT\r\n\r\n💵支付方式:{paytype}\r\n\r\n💲收款地址:`{address}`','MarkDownV2','0',NULL,'[\r\n  [\r\n    {\r\n      \"text\": \"♻️跳转支付\",\r\n      \"url\": \"{url}\"\r\n    }\r\n  ],\r\n  [\r\n    {\r\n      \"text\": \"✅支付完成\",\r\n      \"callback_data\": \"payrechargesuccess_{orderid}\"\r\n    },\r\n    {\r\n      \"text\": \"❎关闭订单\",\r\n      \"callback_data\": \"closerecharge_{orderid}\"\r\n    }\r\n  ]\r\n]','2025-09-29 19:28:03','2025-10-09 20:55:05'),(13,'分类下的商品列表','goods','zh-CN','🛒选择你需要的商品：\r\n❗️发送你需要的商品，会返回带有你输入的关键词的全部商品\r\n❗️购买本店商品，请先少量购买测试，避免造成不必要的争执！','MarkDownV2','0',NULL,NULL,'2025-09-29 22:05:19','2025-10-09 20:13:26'),(14,'商品详情','goodsinfo','zh-CN','✅您正在购买:  {gd_name}\r\n\r\n💰 价格： {price} USDT\r\n\r\n🏢 库存： {cardscount}\r\n\r\n⚔️ 发货方式：{type}\r\n\r\n❗️ 未使用过的本店商品的，请先少量购买测试，以免造成不必要的争执！谢谢合作！','MarkDownV2','0',NULL,'[\r\n  [\r\n    {\r\n      \"text\": \"✅购买\",\r\n      \"callback_data\": \"goodsbuy_{id}\"\r\n    },\r\n    {\r\n      \"text\": \"🗓️使用说明\",\r\n      \"callback_data\": \"usegoods_{id}\"\r\n    }\r\n  ],\r\n  [\r\n    {\r\n      \"text\": \"👩‍⚕️联系客服\",\r\n      \"url\": \"https://t.me/easSearchs\"\r\n    },\r\n    {\r\n      \"text\": \"✖️关闭\",\r\n      \"callback_data\": \"close\"\r\n    }\r\n  ]\r\n]','2025-09-29 22:25:36','2025-10-09 20:12:34'),(15,'输入购买数量','goodsbuy','zh-CN','请输入购买数量\r\n输入规则为 `购买 10` 或者  `10`  则为购买10件','MarkDownV2','0',NULL,NULL,'2025-09-29 23:57:19','2025-09-29 23:58:05'),(16,'选择支付方式','changpaytype','zh-CN','🛒商品名:{gd_name}\r\n\r\n💰价格:{price}\r\n\r\n📶购买数量:{number}\r\n\r\n请点击下方按钮选择支付方式','MarkDownV2','0',NULL,NULL,'2025-09-30 00:11:21','2025-10-09 20:28:26'),(17,'确认订单','confirmorder','zh-CN','🔊订单号:{ordersn}\r\n\r\n✅商品名:{gd_name}\r\n\r\n💰商品价格:{price} USDT\r\n\r\n🏢购买数量:{number}\r\n\r\n💵支付方式:{paytype}','MarkDownV2','0',NULL,'[\r\n  [\r\n    {\r\n      \"text\": \"✅确认\",\r\n      \"callback_data\": \"gopay_{ordersn}\"\r\n    },\r\n    {\r\n      \"text\": \"❌关闭\",\r\n      \"callback_data\": \"close\"\r\n    }\r\n  ]\r\n]','2025-09-30 01:16:58','2025-10-09 20:32:43'),(18,'购买商品去支付','gopay','zh-CN','🔊订单号:`{ordersn} `\r\n\r\n💰支付金额:`{payamount} ` USDT\r\n\r\n💵支付方式:{paytype} \r\n\r\n💲收款地址:`{address}`','MarkDownV2','0',NULL,'[\r\n  [\r\n    {\r\n      \"text\": \"♻️跳转支付\",\r\n      \"url\": \"{url}\"\r\n    }\r\n  ],\r\n  [\r\n    {\r\n      \"text\": \"✅支付完成\",\r\n      \"callback_data\": \"payrechargesuccess_{orderid}\"\r\n    },\r\n    {\r\n      \"text\": \"❎关闭订单\",\r\n      \"callback_data\": \"closerecharge_{orderid}\"\r\n    }\r\n  ]\r\n]','2025-09-30 06:06:28','2025-10-09 20:36:57'),(19,'自定义充值金额','customrecharge','zh-CN','请输入您要充值的金额，必须整数','MarkDownV2','0',NULL,NULL,'2025-09-30 06:49:31','2025-09-30 06:49:31'),(20,'发货','fahuo','zh-CN','订单号:{ordersn}','MarkDownV2','0',NULL,NULL,'2025-10-05 12:07:17','2025-10-05 12:07:17'),(21,'为自己购买会员','premiumself','zh-CN','❗注意:购买Telegram会员只能使用余额进行支付\r\n\r\n需要充值的用户名:{username}','MarkDownV2','0',NULL,NULL,'2025-10-06 15:10:23','2025-10-09 20:56:21'),(22,'为他人购买会员','premiumother','zh-CN','请回复对方的TG用户名，比如 @BotFather','MarkDownV2','0',NULL,NULL,'2025-10-06 15:34:47','2025-10-06 15:34:47'),(23,'确认开通会员','confirmrehuiyuan','zh-CN','❓用户名:{username}\r\n\r\n🈷️月份:{month}\r\n\r\n💰金额:{amount}','MarkDownV2','0',NULL,'[\r\n  [\r\n    {\r\n      \"text\": \"💵去支付\",\r\n      \"callback_data\": \"payhuiyuan_{username}_{month}\"\r\n    }\r\n  ],\r\n  [\r\n    {\r\n      \"text\": \"❌关闭\",\r\n      \"callback_data\": \"close\"\r\n    }\r\n  ]\r\n]','2025-10-07 06:39:11','2025-10-09 20:58:54'),(24,'购买会员成功','payhuiyuan','zh-CN','会员购买成功!扣除余额{amount} USDT','MarkDownV2','0',NULL,NULL,'2025-10-08 00:24:51','2025-10-08 00:24:51'),(25,'查询订单','queryorder','zh-CN','🔊订单号:{ordersn}\r\n\r\n💰支付金额:{amount}  USDT\r\n\r\n✅商品名:{gd_name}\r\n\r\n💸支付方式:{paytype}\r\n\r\n♻️订单状态:{paystatus}','MarkDownV2','0',NULL,NULL,'2025-10-08 00:38:28','2025-10-09 21:00:29'),(26,'♻️订单列表','orderlist','zh-CN','12','MarkDownV2','0',NULL,NULL,'2025-10-08 02:29:06','2025-10-09 20:02:13'),(27,'🌐修改语言','lang','zh-CN','点击下方按钮修改你要选择的语言','HTML','0',NULL,NULL,'2025-10-08 02:43:15','2025-10-09 20:02:25'),(28,'搜索商品','searcgoods','zh-CN','❗点击下方搜索出来的数据即可查看商品详情','HTML','0',NULL,NULL,'2025-10-08 04:27:58','2025-10-09 21:00:52');
/*!40000 ALTER TABLE `buttons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carmis`
--

DROP TABLE IF EXISTS `carmis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carmis` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL COMMENT '所属商品',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态 1未售出 2已售出',
  `is_loop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '循环卡密 1是 0否',
  `carmi` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '卡密',
  `info` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '卡密说明',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_goods_id` (`goods_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='卡密表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carmis`
--

LOCK TABLES `carmis` WRITE;
/*!40000 ALTER TABLE `carmis` DISABLE KEYS */;
INSERT INTO `carmis` VALUES (1,1,2,0,'1242341','1234123','2025-09-27 03:56:21','2025-10-08 07:45:50','2025-10-08 07:45:50'),(2,1,2,0,'asdf',NULL,'2025-10-05 05:59:37','2025-10-08 07:45:50','2025-10-08 07:45:50'),(3,1,2,0,'2.txt',NULL,'2025-10-05 12:57:21','2025-10-08 07:45:50','2025-10-08 07:45:50'),(4,1,2,0,'1.txt',NULL,'2025-10-05 12:57:21','2025-10-08 07:45:50','2025-10-08 07:45:50'),(5,1,1,0,'2',NULL,'2025-10-05 13:06:06','2025-10-08 07:45:50','2025-10-08 07:45:50'),(6,1,1,0,'1',NULL,'2025-10-05 13:06:06','2025-10-08 07:45:50','2025-10-08 07:45:50'),(7,16,1,0,'1234123',NULL,'2025-10-09 20:24:18','2025-10-09 20:24:18',NULL),(8,16,1,0,'123412341234',NULL,'2025-10-09 20:24:18','2025-10-09 20:24:18',NULL),(9,16,1,0,'12341234123',NULL,'2025-10-09 20:24:18','2025-10-09 20:24:18',NULL),(10,16,1,0,'asdfasd',NULL,'2025-10-09 21:29:23','2025-10-09 21:29:23',NULL),(11,16,1,0,'adsfasdfasdf',NULL,'2025-10-09 21:29:23','2025-10-09 21:29:23',NULL),(12,16,1,0,'asdfasdfasdfa',NULL,'2025-10-09 21:29:23','2025-10-09 21:29:23',NULL),(13,17,1,0,'卡密内容2','卡密说明2','2025-10-09 21:29:23','2025-10-20 15:13:42','2025-10-20 15:13:42'),(14,17,1,0,'卡密内容','卡密说明','2025-10-09 21:29:23','2025-10-20 15:13:34','2025-10-20 15:13:34'),(15,17,1,0,'卡密列表1',NULL,'2025-10-20 15:12:43','2025-10-20 17:45:12','2025-10-20 17:45:12'),(16,17,1,0,'+44英国',NULL,'2025-10-20 17:44:31','2025-10-20 17:44:31',NULL);
/*!40000 ALTER TABLE `carmis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠金额',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '优惠类型 1百分比优惠 2固定金额优惠',
  `is_open` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用 1是 0否',
  `coupon` varchar(150) COLLATE utf8_unicode_ci NOT NULL COMMENT '优惠码',
  `ret` int(11) NOT NULL DEFAULT '0' COMMENT '剩余使用次数',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_coupon` (`coupon`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='优惠码表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons_goods`
--

DROP TABLE IF EXISTS `coupons_goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupons_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `coupons_id` int(11) NOT NULL COMMENT '优惠码id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='优惠码关联商品表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons_goods`
--

LOCK TABLES `coupons_goods` WRITE;
/*!40000 ALTER TABLE `coupons_goods` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupons_goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emailtpls`
--

DROP TABLE IF EXISTS `emailtpls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emailtpls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tpl_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '邮件标题',
  `tpl_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '邮件内容',
  `tpl_token` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '邮件标识',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail_token` (`tpl_token`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emailtpls`
--

LOCK TABLES `emailtpls` WRITE;
/*!40000 ALTER TABLE `emailtpls` DISABLE KEYS */;
INSERT INTO `emailtpls` VALUES (2,'【{webname}】感谢您的购买，请查收您的收据','<!DOCTYPE html>\r\n<html\r\n    style=\"font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<head>\r\n    <meta name=\"viewport\" content=\"width=device-width\"/>\r\n    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>\r\n    <title>Billing e.g. invoices and receipts</title>\r\n\r\n    <style type=\"text/css\">\r\n        img {\r\n            max-width: 100%;\r\n        }\r\n\r\n        body {\r\n            -webkit-font-smoothing: antialiased;\r\n            -webkit-text-size-adjust: none;\r\n            width: 100% !important;\r\n            height: 100%;\r\n            line-height: 1.6em;\r\n        }\r\n\r\n        body {\r\n            background-color: #f6f6f6;\r\n        }\r\n\r\n        @media only screen and (max-width: 640px) {\r\n            body {\r\n                padding: 0 !important;\r\n            }\r\n\r\n            h1 {\r\n                font-weight: 800 !important;\r\n                margin: 20px 0 5px !important;\r\n            }\r\n\r\n            h2 {\r\n                font-weight: 800 !important;\r\n                margin: 20px 0 5px !important;\r\n            }\r\n\r\n            h3 {\r\n                font-weight: 800 !important;\r\n                margin: 20px 0 5px !important;\r\n            }\r\n\r\n            h4 {\r\n                font-weight: 800 !important;\r\n                margin: 20px 0 5px !important;\r\n            }\r\n\r\n            h1 {\r\n                font-size: 22px !important;\r\n            }\r\n\r\n            h2 {\r\n                font-size: 18px !important;\r\n            }\r\n\r\n            h3 {\r\n                font-size: 16px !important;\r\n            }\r\n\r\n            .container {\r\n                padding: 0 !important;\r\n                width: 100% !important;\r\n            }\r\n\r\n            .content {\r\n                padding: 0 !important;\r\n            }\r\n\r\n            .content-wrap {\r\n                padding: 10px !important;\r\n            }\r\n\r\n            .invoice {\r\n                width: 100% !important;\r\n            }\r\n        }\r\n    </style>\r\n</head>\r\n\r\n<body itemscope itemtype=\"http://schema.org/EmailMessage\"\r\n      style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;\"\r\n      bgcolor=\"#f6f6f6\">\r\n\r\n<table class=\"body-wrap\"\r\n       style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;\"\r\n       bgcolor=\"#f6f6f6\">\r\n    <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n        <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;\"\r\n            valign=\"top\"></td>\r\n        <td class=\"container\" width=\"600\"\r\n            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;\"\r\n            valign=\"top\">\r\n            <div class=\"content\"\r\n                 style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;\">\r\n                <table class=\"main\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\"\r\n                       style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;\"\r\n                       bgcolor=\"#fff\">\r\n                    <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                        <td class=\"content-wrap aligncenter\"\r\n                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 20px;\"\r\n                            align=\"center\" valign=\"top\">\r\n                            <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\"\r\n                                   style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;\"\r\n                                        valign=\"top\">\r\n                                        <h1 class=\"aligncenter\"\r\n                                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,\'Lucida Grande\',sans-serif; box-sizing: border-box; font-size: 32px; color: #000; line-height: 1.2em; font-weight: 500; text-align: center; margin: 40px 0 0;\"\r\n                                            align=\"center\"> {ord_title} </h1>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;\"\r\n                                        valign=\"top\">\r\n                                        <h2 class=\"aligncenter\"\r\n                                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,\'Lucida Grande\',sans-serif; box-sizing: border-box; font-size: 24px; color: #000; line-height: 1.2em; font-weight: 400; text-align: center; margin: 40px 0 0;\"\r\n                                            align=\"center\">感谢您的购买。</h2>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block aligncenter\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\"\r\n                                        align=\"center\" valign=\"top\">\r\n                                        <table class=\"invoice\"\r\n                                               style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; text-align: left; width: 80%; margin: 40px auto;\">\r\n                                            <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                                <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;\" valign=\"top\">\r\n                                                    订单号: {order_id}<br style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\"/>\r\n                                                    {created_at}<br style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\"/>\r\n                                                    以下是您的卡密信息：<br style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\"/>\r\n                                                    {ord_info}\r\n                                                </td>\r\n                                            </tr>\r\n                                            <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                                <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;\"\r\n                                                    valign=\"top\">\r\n                                                    <table class=\"invoice-items\" cellpadding=\"0\" cellspacing=\"0\"\r\n                                                           style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; margin: 0;\">\r\n                                                        <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                                            <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;\"\r\n                                                                valign=\"top\">{product_name}\r\n                                                            </td>\r\n                                                            <td class=\"alignright\"\r\n                                                                style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;\"\r\n                                                                align=\"right\" valign=\"top\">x {buy_amount}\r\n                                                            </td>\r\n                                                        </tr>\r\n\r\n                                                        <tr class=\"total\"\r\n                                                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                                            <td class=\"alignright\" width=\"80%\"\r\n                                                                style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0;\"\r\n                                                                align=\"right\" valign=\"top\">总价\r\n                                                            </td>\r\n                                                            <td class=\"alignright\"\r\n                                                                style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0;\"\r\n                                                                align=\"right\" valign=\"top\">{ord_price} ¥\r\n                                                            </td>\r\n                                                        </tr>\r\n                                                    </table>\r\n                                                </td>\r\n                                            </tr>\r\n                                        </table>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block aligncenter\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\"\r\n                                        align=\"center\" valign=\"top\">\r\n                                        <a href=\"{weburl}\"\r\n                                           style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #348eda; text-decoration: underline; margin: 0;\">{webname}</a>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block aligncenter\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\"\r\n                                        align=\"center\" valign=\"top\">\r\n                                        {webname} Inc. {created_at}\r\n                                    </td>\r\n                                </tr>\r\n                            </table>\r\n                        </td>\r\n                    </tr>\r\n                </table>\r\n                <div class=\"footer\"\r\n                     style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;\">\r\n                    <table width=\"100%\"\r\n                           style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                        <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n\r\n                        </tr>\r\n                    </table>\r\n                </div>\r\n            </div>\r\n        </td>\r\n        <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;\"\r\n            valign=\"top\"></td>\r\n    </tr>\r\n</table>\r\n</body>\r\n</html>','card_send_user_email','2020-04-06 13:27:56','2021-05-20 20:24:42',NULL),(3,'【{webname}】新订单等待处理！','<p><span style=\"\">尊敬的管理员：</span></p><p><span style=\"\">客户购买的商品：<span style=\"\"><span style=\"\">【{product_name}】</span></span> 已支付成功，请及时处理。</span></p><p>订单号：{order_id}<br></p><p>数量：{buy_amount}<br></p><p>金额：{ord_price}<br></p><p>时间：<span style=\"\">{created_at}</span><br></p><hr><p>{ord_info}</p><hr><p style=\"margin-left: 40px;\"><b>来自{webname} -{weburl}</b></p>','manual_send_manage_mail','2020-04-06 13:32:03','2020-04-06 13:32:18',NULL),(4,'【{webname}】订单处理失败！','<!DOCTYPE html>\r\n<html\r\n    style=\"font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<head>\r\n    <meta name=\"viewport\" content=\"width=device-width\"/>\r\n    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>\r\n    <title>Billing e.g. invoices and receipts</title>\r\n\r\n    <style type=\"text/css\">\r\n        img {\r\n            max-width: 100%;\r\n        }\r\n\r\n        body {\r\n            -webkit-font-smoothing: antialiased;\r\n            -webkit-text-size-adjust: none;\r\n            width: 100% !important;\r\n            height: 100%;\r\n            line-height: 1.6em;\r\n        }\r\n\r\n        body {\r\n            background-color: #f6f6f6;\r\n        }\r\n\r\n        @media only screen and (max-width: 640px) {\r\n            body {\r\n                padding: 0 !important;\r\n            }\r\n\r\n            h1 {\r\n                font-weight: 800 !important;\r\n                margin: 20px 0 5px !important;\r\n            }\r\n\r\n            h2 {\r\n                font-weight: 800 !important;\r\n                margin: 20px 0 5px !important;\r\n            }\r\n\r\n            h3 {\r\n                font-weight: 800 !important;\r\n                margin: 20px 0 5px !important;\r\n            }\r\n\r\n            h4 {\r\n                font-weight: 800 !important;\r\n                margin: 20px 0 5px !important;\r\n            }\r\n\r\n            h1 {\r\n                font-size: 22px !important;\r\n            }\r\n\r\n            h2 {\r\n                font-size: 18px !important;\r\n            }\r\n\r\n            h3 {\r\n                font-size: 16px !important;\r\n            }\r\n\r\n            .container {\r\n                padding: 0 !important;\r\n                width: 100% !important;\r\n            }\r\n\r\n            .content {\r\n                padding: 0 !important;\r\n            }\r\n\r\n            .content-wrap {\r\n                padding: 10px !important;\r\n            }\r\n\r\n            .invoice {\r\n                width: 100% !important;\r\n            }\r\n        }\r\n    </style>\r\n</head>\r\n\r\n<body itemscope itemtype=\"http://schema.org/EmailMessage\"\r\n      style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;\"\r\n      bgcolor=\"#f6f6f6\">\r\n\r\n<table class=\"body-wrap\"\r\n       style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;\"\r\n       bgcolor=\"#f6f6f6\">\r\n    <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n        <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;\"\r\n            valign=\"top\"></td>\r\n        <td class=\"container\" width=\"600\"\r\n            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;\"\r\n            valign=\"top\">\r\n            <div class=\"content\"\r\n                 style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;\">\r\n                <table class=\"main\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\"\r\n                       style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;\"\r\n                       bgcolor=\"#fff\">\r\n                    <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                        <td class=\"content-wrap aligncenter\"\r\n                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 20px;\"\r\n                            align=\"center\" valign=\"top\">\r\n                            <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\"\r\n                                   style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;\"\r\n                                        valign=\"top\">\r\n                                        <h1 class=\"aligncenter\"\r\n                                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,\'Lucida Grande\',sans-serif; box-sizing: border-box; font-size: 32px; color: #000; line-height: 1.2em; font-weight: 500; text-align: center; margin: 40px 0 0;\"\r\n                                            align=\"center\"> {ord_title} </h1>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;\"\r\n                                        valign=\"top\">\r\n                                        <h2 class=\"aligncenter\"\r\n                                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,\'Lucida Grande\',sans-serif; box-sizing: border-box; font-size: 24px; color: #000; line-height: 1.2em; font-weight: 400; text-align: center; margin: 40px 0 0;\"\r\n                                            align=\"center\">非常遗憾，您的订单处理失败(╥﹏╥).</h2>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block aligncenter\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\"\r\n                                        align=\"center\" valign=\"top\">\r\n                                        <table class=\"invoice\"\r\n                                               style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; text-align: left; width: 80%; margin: 40px auto;\">\r\n                                            <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                                <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;\" valign=\"top\">\r\n                                                    订单号: {order_id}<br style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\"/>\r\n                                                    {created_at}<br style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\"/>\r\n                                                    尊敬的客户，十分抱歉，订单处理失败，请联系网站工作人员核查原因。\r\n                                                </td>\r\n                                            </tr>\r\n                                            <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                                <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;\"\r\n                                                    valign=\"top\">\r\n                                                    <table class=\"invoice-items\" cellpadding=\"0\" cellspacing=\"0\"\r\n                                                           style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; margin: 0;\">\r\n                                                        <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                                            <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;\"\r\n                                                                valign=\"top\">{ord_title}\r\n                                                            </td>\r\n                                                            <td class=\"alignright\"\r\n                                                                style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;\"\r\n                                                                align=\"right\" valign=\"top\">\r\n                                                            </td>\r\n                                                        </tr>\r\n\r\n                                                        <tr class=\"total\"\r\n                                                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                                            <td class=\"alignright\" width=\"80%\"\r\n                                                                style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0;\"\r\n                                                                align=\"right\" valign=\"top\">总价\r\n                                                            </td>\r\n                                                            <td class=\"alignright\"\r\n                                                                style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0;\"\r\n                                                                align=\"right\" valign=\"top\">{ord_price} ¥\r\n                                                            </td>\r\n                                                        </tr>\r\n                                                    </table>\r\n                                                </td>\r\n                                            </tr>\r\n                                        </table>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block aligncenter\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\"\r\n                                        align=\"center\" valign=\"top\">\r\n                                        <a href=\"{weburl}\"\r\n                                           style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #348eda; text-decoration: underline; margin: 0;\">{webname}</a>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block aligncenter\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\"\r\n                                        align=\"center\" valign=\"top\">\r\n                                        {webname} Inc. {created_at}\r\n                                    </td>\r\n                                </tr>\r\n                            </table>\r\n                        </td>\r\n                    </tr>\r\n                </table>\r\n                <div class=\"footer\"\r\n                     style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;\">\r\n                    <table width=\"100%\"\r\n                           style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                        <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n\r\n                        </tr>\r\n                    </table>\r\n                </div>\r\n            </div>\r\n        </td>\r\n        <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;\"\r\n            valign=\"top\"></td>\r\n    </tr>\r\n</table>\r\n</body>\r\n</html>','failed_order','2020-06-30 09:54:58','2020-06-30 10:47:21',NULL),(5,'【{webname}】您的订单已经处理完成！','<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<table class=\"body-wrap\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;\" bgcolor=\"#f6f6f6\">\r\n<tbody>\r\n<tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;\" valign=\"top\">&nbsp;</td>\r\n<td class=\"container\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;\" valign=\"top\" width=\"600\">\r\n<div class=\"content\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;\">\r\n<table class=\"main\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#fff\">\r\n<tbody>\r\n<tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<td class=\"content-wrap aligncenter\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 20px;\" align=\"center\" valign=\"top\">\r\n<table style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<td class=\"content-block\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;\" valign=\"top\">\r\n<h1 class=\"aligncenter\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,\'Lucida Grande\',sans-serif; box-sizing: border-box; font-size: 32px; color: #000; line-height: 1.2em; font-weight: 500; text-align: center; margin: 40px 0 0;\" align=\"center\">{ord_title}</h1>\r\n</td>\r\n</tr>\r\n<tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<td class=\"content-block\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;\" valign=\"top\">\r\n<h2 class=\"aligncenter\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,\'Lucida Grande\',sans-serif; box-sizing: border-box; font-size: 24px; color: #000; line-height: 1.2em; font-weight: 400; text-align: center; margin: 40px 0 0;\" align=\"center\">您的订单已完成。</h2>\r\n</td>\r\n</tr>\r\n<tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<td class=\"content-block aligncenter\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\" align=\"center\" valign=\"top\">\r\n<table class=\"invoice\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; text-align: left; width: 80%; margin: 40px auto;\">\r\n<tbody>\r\n<tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;\" valign=\"top\">订单号: {order_id}<br style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\" />{created_at}<br style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\" />尊敬的客户，您的订单已经处理完毕，请及时前往网站核对处理结果，如有疑问请联系网站工作人员！</td>\r\n</tr>\r\n<tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;\" valign=\"top\">\r\n<table class=\"invoice-items\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; margin: 0;\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;\" valign=\"top\"><span style=\"font-size: 14pt;\">{ord_title}</span></td>\r\n<td class=\"alignright\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;\" align=\"right\" valign=\"top\">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td style=\"font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border-top: 1px solid #eeeeee; margin: 0px; padding: 5px 0px;\">{ord_info}</td>\r\n<td style=\"font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top: 1px solid #eeeeee; margin: 0px; padding: 5px 0px;\">&nbsp;</td>\r\n</tr>\r\n<tr class=\"total\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<td class=\"alignright\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: bold; margin: 0; padding: 5px 0;\" align=\"right\" valign=\"top\" width=\"80%\">总价</td>\r\n<td class=\"alignright\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: bold; margin: 0; padding: 5px 0;\" align=\"right\" valign=\"top\">{ord_price} &yen;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<td class=\"content-block aligncenter\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\" align=\"center\" valign=\"top\"><a style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #348eda; text-decoration: underline; margin: 0;\" href=\"{weburl}\">{webname}</a></td>\r\n</tr>\r\n<tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<td class=\"content-block aligncenter\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\" align=\"center\" valign=\"top\">{webname} Inc. {created_at}</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<div class=\"footer\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;\">&nbsp;</div>\r\n</div>\r\n</td>\r\n<td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;\" valign=\"top\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>','completed_order','2022-05-08 15:41:49','2022-05-08 15:47:26',NULL),(6,'【{webname}】已收到您的订单，请等候处理','<!DOCTYPE html>\r\n<html\r\n    style=\"font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<head>\r\n    <meta name=\"viewport\" content=\"width=device-width\"/>\r\n    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>\r\n    <title>Billing e.g. invoices and receipts</title>\r\n\r\n    <style type=\"text/css\">\r\n        img {\r\n            max-width: 100%;\r\n        }\r\n\r\n        body {\r\n            -webkit-font-smoothing: antialiased;\r\n            -webkit-text-size-adjust: none;\r\n            width: 100% !important;\r\n            height: 100%;\r\n            line-height: 1.6em;\r\n        }\r\n\r\n        body {\r\n            background-color: #f6f6f6;\r\n        }\r\n\r\n        @media only screen and (max-width: 640px) {\r\n            body {\r\n                padding: 0 !important;\r\n            }\r\n\r\n            h1 {\r\n                font-weight: 800 !important;\r\n                margin: 20px 0 5px !important;\r\n            }\r\n\r\n            h2 {\r\n                font-weight: 800 !important;\r\n                margin: 20px 0 5px !important;\r\n            }\r\n\r\n            h3 {\r\n                font-weight: 800 !important;\r\n                margin: 20px 0 5px !important;\r\n            }\r\n\r\n            h4 {\r\n                font-weight: 800 !important;\r\n                margin: 20px 0 5px !important;\r\n            }\r\n\r\n            h1 {\r\n                font-size: 22px !important;\r\n            }\r\n\r\n            h2 {\r\n                font-size: 18px !important;\r\n            }\r\n\r\n            h3 {\r\n                font-size: 16px !important;\r\n            }\r\n\r\n            .container {\r\n                padding: 0 !important;\r\n                width: 100% !important;\r\n            }\r\n\r\n            .content {\r\n                padding: 0 !important;\r\n            }\r\n\r\n            .content-wrap {\r\n                padding: 10px !important;\r\n            }\r\n\r\n            .invoice {\r\n                width: 100% !important;\r\n            }\r\n        }\r\n    </style>\r\n</head>\r\n\r\n<body itemscope itemtype=\"http://schema.org/EmailMessage\"\r\n      style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;\"\r\n      bgcolor=\"#f6f6f6\">\r\n\r\n<table class=\"body-wrap\"\r\n       style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;\"\r\n       bgcolor=\"#f6f6f6\">\r\n    <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n        <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;\"\r\n            valign=\"top\"></td>\r\n        <td class=\"container\" width=\"600\"\r\n            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;\"\r\n            valign=\"top\">\r\n            <div class=\"content\"\r\n                 style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;\">\r\n                <table class=\"main\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\"\r\n                       style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;\"\r\n                       bgcolor=\"#fff\">\r\n                    <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                        <td class=\"content-wrap aligncenter\"\r\n                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 20px;\"\r\n                            align=\"center\" valign=\"top\">\r\n                            <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\"\r\n                                   style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;\"\r\n                                        valign=\"top\">\r\n                                        <h1 class=\"aligncenter\"\r\n                                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,\'Lucida Grande\',sans-serif; box-sizing: border-box; font-size: 32px; color: #000; line-height: 1.2em; font-weight: 500; text-align: center; margin: 40px 0 0;\"\r\n                                            align=\"center\"> {ord_title} </h1>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;\"\r\n                                        valign=\"top\">\r\n                                        <h2 class=\"aligncenter\"\r\n                                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,\'Lucida Grande\',sans-serif; box-sizing: border-box; font-size: 24px; color: #000; line-height: 1.2em; font-weight: 400; text-align: center; margin: 40px 0 0;\"\r\n                                            align=\"center\">感谢您的惠顾。</h2>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block aligncenter\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\"\r\n                                        align=\"center\" valign=\"top\">\r\n                                        <table class=\"invoice\"\r\n                                               style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; text-align: left; width: 80%; margin: 40px auto;\">\r\n                                            <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                                <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;\" valign=\"top\">\r\n                                                    订单号: {order_id}<br style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\"/>\r\n                                                    {created_at}<br style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\"/>\r\n                                                    系统已向工作人员发送订单通知，代充类商品需要工作人员手动处理，请耐心等待通知！\r\n                                                </td>\r\n                                            </tr>\r\n                                            <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                                <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;\"\r\n                                                    valign=\"top\">\r\n                                                    <table class=\"invoice-items\" cellpadding=\"0\" cellspacing=\"0\"\r\n                                                           style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; margin: 0;\">\r\n                                                        <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                                            <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;\"\r\n                                                                valign=\"top\">{ord_title}\r\n                                                            </td>\r\n                                                            <td class=\"alignright\"\r\n                                                                style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 1px; border-top-color: #eee; border-top-style: solid; margin: 0; padding: 5px 0;\"\r\n                                                                align=\"right\" valign=\"top\">\r\n                                                            </td>\r\n                                                        </tr>\r\n\r\n                                                        <tr class=\"total\"\r\n                                                            style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                                            <td class=\"alignright\" width=\"80%\"\r\n                                                                style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0;\"\r\n                                                                align=\"right\" valign=\"top\">总价\r\n                                                            </td>\r\n                                                            <td class=\"alignright\"\r\n                                                                style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: right; border-top-width: 2px; border-top-color: #333; border-top-style: solid; border-bottom-color: #333; border-bottom-width: 2px; border-bottom-style: solid; font-weight: 700; margin: 0; padding: 5px 0;\"\r\n                                                                align=\"right\" valign=\"top\">{ord_price} ¥\r\n                                                            </td>\r\n                                                        </tr>\r\n                                                    </table>\r\n                                                </td>\r\n                                            </tr>\r\n                                        </table>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block aligncenter\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\"\r\n                                        align=\"center\" valign=\"top\">\r\n                                        <a href=\"{weburl}\"\r\n                                           style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #348eda; text-decoration: underline; margin: 0;\">{webname}</a>\r\n                                    </td>\r\n                                </tr>\r\n                                <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                                    <td class=\"content-block aligncenter\"\r\n                                        style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\"\r\n                                        align=\"center\" valign=\"top\">\r\n                                        {webname} Inc. {created_at}\r\n                                    </td>\r\n                                </tr>\r\n                            </table>\r\n                        </td>\r\n                    </tr>\r\n                </table>\r\n                <div class=\"footer\"\r\n                     style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;\">\r\n                    <table width=\"100%\"\r\n                           style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n                        <tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n\r\n                        </tr>\r\n                    </table>\r\n                </div>\r\n            </div>\r\n        </td>\r\n        <td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;\"\r\n            valign=\"top\"></td>\r\n    </tr>\r\n</table>\r\n</body>\r\n</html>','pending_order','2020-06-30 09:55:55','2020-06-30 10:45:40',NULL),(7,'【{webname}】注册验证码','<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<table class=\"body-wrap\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;\" bgcolor=\"#f6f6f6\">\r\n<tbody>\r\n<tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;\" valign=\"top\">&nbsp;</td>\r\n<td class=\"container\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;\" valign=\"top\" width=\"600\">\r\n<div class=\"content\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;\">\r\n<table class=\"main\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#fff\">\r\n<tbody>\r\n<tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<td class=\"content-wrap aligncenter\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 20px;\" align=\"center\" valign=\"top\">\r\n<table style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<td class=\"content-block\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;\" valign=\"top\">\r\n<h1 class=\"aligncenter\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,\'Lucida Grande\',sans-serif; box-sizing: border-box; font-size: 32px; color: #000; line-height: 1.2em; font-weight: 500; text-align: center; margin: 40px 0 0;\" align=\"center\">{webname}</h1>\r\n</td>\r\n</tr>\r\n<tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<td class=\"content-block\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;\" valign=\"top\">\r\n<h2 class=\"aligncenter\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,\'Lucida Grande\',sans-serif; box-sizing: border-box; font-size: 24px; color: #000; line-height: 1.2em; font-weight: 400; text-align: center; margin: 40px 0 0;\" align=\"center\">感谢注册</h2>\r\n</td>\r\n</tr>\r\n<tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<td class=\"content-block aligncenter\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\" align=\"center\" valign=\"top\">\r\n<table class=\"invoice\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; text-align: left; width: 80%; margin: 40px auto;\">\r\n<tbody>\r\n<tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;\" valign=\"top\">\r\n<p>验证码: <strong>{code}</strong></p>\r\n<p><br style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\" />您好，请在10分钟以内复制上面的验证码到网站完成注册操作！</p>\r\n</td>\r\n</tr>\r\n<tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 5px 0;\" valign=\"top\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<td class=\"content-block aligncenter\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\" align=\"center\" valign=\"top\"><a style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #348eda; text-decoration: underline; margin: 0;\" href=\"{weburl}\">{webname}</a></td>\r\n</tr>\r\n<tr style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;\">\r\n<td class=\"content-block aligncenter\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; text-align: center; margin: 0; padding: 0 0 20px;\" align=\"center\" valign=\"top\">{webname} Inc. {created_at}</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<div class=\"footer\" style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;\">&nbsp;</div>\r\n</div>\r\n</td>\r\n<td style=\"font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;\" valign=\"top\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>','register_code','2022-10-30 09:55:55','2022-10-30 20:26:26',NULL);
/*!40000 ALTER TABLE `emailtpls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
INSERT INTO `failed_jobs` VALUES (1,'redis','default','{\"timeout\":30,\"id\":\"jTwFFrDlSxmMM28YyWqZJ8hUi7ECZuXa\",\"data\":{\"command\":\"O:29:\\\"App\\\\Jobs\\\\GoodsPriceReducePush\\\":14:{s:5:\\\"tries\\\";i:2;s:7:\\\"timeout\\\";i:30;s:43:\\\"\\u0000App\\\\Jobs\\\\GoodsPriceReducePush\\u0000goodsService\\\";O:24:\\\"App\\\\Service\\\\GoodsService\\\":0:{}s:39:\\\"\\u0000App\\\\Jobs\\\\GoodsPriceReducePush\\u0000goods_id\\\";i:17;s:40:\\\"\\u0000App\\\\Jobs\\\\GoodsPriceReducePush\\u0000old_price\\\";d:800;s:40:\\\"\\u0000App\\\\Jobs\\\\GoodsPriceReducePush\\u0000new_price\\\";d:1;s:6:\\\"\\u0000*\\u0000job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\",\"commandName\":\"App\\\\Jobs\\\\GoodsPriceReducePush\"},\"displayName\":\"App\\\\Jobs\\\\GoodsPriceReducePush\",\"timeoutAt\":null,\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":2,\"delay\":null,\"attempts\":1}','GuzzleHttp\\Exception\\ClientException: Client error: `POST https://api.telegram.org/bot7974830006:AAHwVjB_S8vBI8md_U4cYIe_Je8DdGB6xsM/sendMessage` resulted in a `400 Bad Request` response:\n{\"ok\":false,\"error_code\":400,\"description\":\"Bad Request: chat not found\"}\n in /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/guzzle/src/Exception/RequestException.php:111\nStack trace:\n#0 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/guzzle/src/Middleware.php(72): GuzzleHttp\\Exception\\RequestException::create()\n#1 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/Promise.php(209): GuzzleHttp\\Middleware::GuzzleHttp\\{closure}()\n#2 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/Promise.php(158): GuzzleHttp\\Promise\\Promise::callHandler()\n#3 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/TaskQueue.php(52): GuzzleHttp\\Promise\\Promise::GuzzleHttp\\Promise\\{closure}()\n#4 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/Promise.php(251): GuzzleHttp\\Promise\\TaskQueue->run()\n#5 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/Promise.php(227): GuzzleHttp\\Promise\\Promise->invokeWaitFn()\n#6 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/Promise.php(272): GuzzleHttp\\Promise\\Promise->waitIfPending()\n#7 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/Promise.php(229): GuzzleHttp\\Promise\\Promise->invokeWaitList()\n#8 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/Promise.php(69): GuzzleHttp\\Promise\\Promise->waitIfPending()\n#9 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/guzzle/src/Client.php(189): GuzzleHttp\\Promise\\Promise->wait()\n#10 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/guzzle/src/ClientTrait.php(95): GuzzleHttp\\Client->request()\n#11 /www/wwwroot/session.dpdns.org/app/Jobs/GoodsPriceReducePush.php(104): GuzzleHttp\\Client->post()\n#12 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): App\\Jobs\\GoodsPriceReducePush->handle()\n#13 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/Util.php(37): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#14 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#15 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#16 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/Container.php(590): Illuminate\\Container\\BoundMethod::call()\n#17 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call()\n#18 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(130): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}()\n#19 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(105): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#20 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then()\n#21 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(83): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#22 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(130): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}()\n#23 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(105): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#24 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(85): Illuminate\\Pipeline\\Pipeline->then()\n#25 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(59): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#26 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(88): Illuminate\\Queue\\CallQueuedHandler->call()\n#27 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(368): Illuminate\\Queue\\Jobs\\Job->fire()\n#28 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(314): Illuminate\\Queue\\Worker->process()\n#29 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(134): Illuminate\\Queue\\Worker->runJob()\n#30 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(112): Illuminate\\Queue\\Worker->daemon()\n#31 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(96): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#32 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#33 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/Util.php(37): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#34 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#35 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#36 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/Container.php(590): Illuminate\\Container\\BoundMethod::call()\n#37 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Console/Command.php(134): Illuminate\\Container\\Container->call()\n#38 /www/wwwroot/session.dpdns.org/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute()\n#39 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Console/Command.php(121): Symfony\\Component\\Console\\Command\\Command->run()\n#40 /www/wwwroot/session.dpdns.org/vendor/symfony/console/Application.php(1021): Illuminate\\Console\\Command->run()\n#41 /www/wwwroot/session.dpdns.org/vendor/symfony/console/Application.php(275): Symfony\\Component\\Console\\Application->doRunCommand()\n#42 /www/wwwroot/session.dpdns.org/vendor/symfony/console/Application.php(149): Symfony\\Component\\Console\\Application->doRun()\n#43 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Console/Application.php(93): Symfony\\Component\\Console\\Application->run()\n#44 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(131): Illuminate\\Console\\Application->run()\n#45 /www/wwwroot/session.dpdns.org/artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle()\n#46 {main}','2025-10-20 15:09:54'),(2,'redis','default','{\"timeout\":30,\"id\":\"jaGd0We8XdEk8AnNkMauaH6Y0v7nqCXn\",\"data\":{\"command\":\"O:24:\\\"App\\\\Jobs\\\\CreateCarmiPush\\\":13:{s:5:\\\"tries\\\";i:2;s:7:\\\"timeout\\\";i:30;s:38:\\\"\\u0000App\\\\Jobs\\\\CreateCarmiPush\\u0000goodsService\\\";O:24:\\\"App\\\\Service\\\\GoodsService\\\":0:{}s:34:\\\"\\u0000App\\\\Jobs\\\\CreateCarmiPush\\u0000goods_id\\\";i:17;s:32:\\\"\\u0000App\\\\Jobs\\\\CreateCarmiPush\\u0000counts\\\";i:1;s:6:\\\"\\u0000*\\u0000job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\",\"commandName\":\"App\\\\Jobs\\\\CreateCarmiPush\"},\"displayName\":\"App\\\\Jobs\\\\CreateCarmiPush\",\"timeoutAt\":null,\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":2,\"delay\":null,\"attempts\":1}','GuzzleHttp\\Exception\\ClientException: Client error: `POST https://api.telegram.org/bot7974830006:AAHwVjB_S8vBI8md_U4cYIe_Je8DdGB6xsM/sendMessage` resulted in a `400 Bad Request` response:\n{\"ok\":false,\"error_code\":400,\"description\":\"Bad Request: chat not found\"}\n in /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/guzzle/src/Exception/RequestException.php:111\nStack trace:\n#0 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/guzzle/src/Middleware.php(72): GuzzleHttp\\Exception\\RequestException::create()\n#1 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/Promise.php(209): GuzzleHttp\\Middleware::GuzzleHttp\\{closure}()\n#2 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/Promise.php(158): GuzzleHttp\\Promise\\Promise::callHandler()\n#3 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/TaskQueue.php(52): GuzzleHttp\\Promise\\Promise::GuzzleHttp\\Promise\\{closure}()\n#4 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/Promise.php(251): GuzzleHttp\\Promise\\TaskQueue->run()\n#5 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/Promise.php(227): GuzzleHttp\\Promise\\Promise->invokeWaitFn()\n#6 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/Promise.php(272): GuzzleHttp\\Promise\\Promise->waitIfPending()\n#7 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/Promise.php(229): GuzzleHttp\\Promise\\Promise->invokeWaitList()\n#8 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/Promise.php(69): GuzzleHttp\\Promise\\Promise->waitIfPending()\n#9 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/guzzle/src/Client.php(189): GuzzleHttp\\Promise\\Promise->wait()\n#10 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/guzzle/src/ClientTrait.php(95): GuzzleHttp\\Client->request()\n#11 /www/wwwroot/session.dpdns.org/app/Jobs/CreateCarmiPush.php(101): GuzzleHttp\\Client->post()\n#12 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): App\\Jobs\\CreateCarmiPush->handle()\n#13 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/Util.php(37): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#14 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#15 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#16 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/Container.php(590): Illuminate\\Container\\BoundMethod::call()\n#17 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call()\n#18 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(130): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}()\n#19 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(105): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#20 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then()\n#21 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(83): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#22 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(130): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}()\n#23 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(105): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#24 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(85): Illuminate\\Pipeline\\Pipeline->then()\n#25 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(59): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#26 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(88): Illuminate\\Queue\\CallQueuedHandler->call()\n#27 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(368): Illuminate\\Queue\\Jobs\\Job->fire()\n#28 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(314): Illuminate\\Queue\\Worker->process()\n#29 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(134): Illuminate\\Queue\\Worker->runJob()\n#30 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(112): Illuminate\\Queue\\Worker->daemon()\n#31 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(96): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#32 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#33 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/Util.php(37): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#34 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#35 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#36 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/Container.php(590): Illuminate\\Container\\BoundMethod::call()\n#37 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Console/Command.php(134): Illuminate\\Container\\Container->call()\n#38 /www/wwwroot/session.dpdns.org/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute()\n#39 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Console/Command.php(121): Symfony\\Component\\Console\\Command\\Command->run()\n#40 /www/wwwroot/session.dpdns.org/vendor/symfony/console/Application.php(1021): Illuminate\\Console\\Command->run()\n#41 /www/wwwroot/session.dpdns.org/vendor/symfony/console/Application.php(275): Symfony\\Component\\Console\\Application->doRunCommand()\n#42 /www/wwwroot/session.dpdns.org/vendor/symfony/console/Application.php(149): Symfony\\Component\\Console\\Application->doRun()\n#43 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Console/Application.php(93): Symfony\\Component\\Console\\Application->run()\n#44 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(131): Illuminate\\Console\\Application->run()\n#45 /www/wwwroot/session.dpdns.org/artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle()\n#46 {main}','2025-10-20 15:12:47'),(3,'redis','default','{\"timeout\":30,\"id\":\"T7kn1hj4NwMmknkcnFBiHPxExYOPH0ap\",\"data\":{\"command\":\"O:24:\\\"App\\\\Jobs\\\\CreateCarmiPush\\\":13:{s:5:\\\"tries\\\";i:2;s:7:\\\"timeout\\\";i:30;s:38:\\\"\\u0000App\\\\Jobs\\\\CreateCarmiPush\\u0000goodsService\\\";O:24:\\\"App\\\\Service\\\\GoodsService\\\":0:{}s:34:\\\"\\u0000App\\\\Jobs\\\\CreateCarmiPush\\u0000goods_id\\\";i:17;s:32:\\\"\\u0000App\\\\Jobs\\\\CreateCarmiPush\\u0000counts\\\";i:1;s:6:\\\"\\u0000*\\u0000job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\",\"commandName\":\"App\\\\Jobs\\\\CreateCarmiPush\"},\"displayName\":\"App\\\\Jobs\\\\CreateCarmiPush\",\"timeoutAt\":null,\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":2,\"delay\":null,\"attempts\":1}','GuzzleHttp\\Exception\\ClientException: Client error: `POST https://api.telegram.org/bot7974830006:AAHwVjB_S8vBI8md_U4cYIe_Je8DdGB6xsM/sendMessage` resulted in a `400 Bad Request` response:\n{\"ok\":false,\"error_code\":400,\"description\":\"Bad Request: chat not found\"}\n in /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/guzzle/src/Exception/RequestException.php:111\nStack trace:\n#0 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/guzzle/src/Middleware.php(72): GuzzleHttp\\Exception\\RequestException::create()\n#1 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/Promise.php(209): GuzzleHttp\\Middleware::GuzzleHttp\\{closure}()\n#2 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/Promise.php(158): GuzzleHttp\\Promise\\Promise::callHandler()\n#3 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/TaskQueue.php(52): GuzzleHttp\\Promise\\Promise::GuzzleHttp\\Promise\\{closure}()\n#4 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/Promise.php(251): GuzzleHttp\\Promise\\TaskQueue->run()\n#5 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/Promise.php(227): GuzzleHttp\\Promise\\Promise->invokeWaitFn()\n#6 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/Promise.php(272): GuzzleHttp\\Promise\\Promise->waitIfPending()\n#7 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/Promise.php(229): GuzzleHttp\\Promise\\Promise->invokeWaitList()\n#8 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/promises/src/Promise.php(69): GuzzleHttp\\Promise\\Promise->waitIfPending()\n#9 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/guzzle/src/Client.php(189): GuzzleHttp\\Promise\\Promise->wait()\n#10 /www/wwwroot/session.dpdns.org/vendor/guzzlehttp/guzzle/src/ClientTrait.php(95): GuzzleHttp\\Client->request()\n#11 /www/wwwroot/session.dpdns.org/app/Jobs/CreateCarmiPush.php(101): GuzzleHttp\\Client->post()\n#12 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): App\\Jobs\\CreateCarmiPush->handle()\n#13 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/Util.php(37): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#14 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#15 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#16 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/Container.php(590): Illuminate\\Container\\BoundMethod::call()\n#17 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(94): Illuminate\\Container\\Container->call()\n#18 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(130): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}()\n#19 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(105): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#20 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(98): Illuminate\\Pipeline\\Pipeline->then()\n#21 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(83): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#22 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(130): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}()\n#23 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(105): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#24 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(85): Illuminate\\Pipeline\\Pipeline->then()\n#25 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(59): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#26 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(88): Illuminate\\Queue\\CallQueuedHandler->call()\n#27 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(368): Illuminate\\Queue\\Jobs\\Job->fire()\n#28 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(314): Illuminate\\Queue\\Worker->process()\n#29 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(134): Illuminate\\Queue\\Worker->runJob()\n#30 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(112): Illuminate\\Queue\\Worker->daemon()\n#31 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(96): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#32 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#33 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/Util.php(37): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#34 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#35 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#36 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Container/Container.php(590): Illuminate\\Container\\BoundMethod::call()\n#37 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Console/Command.php(134): Illuminate\\Container\\Container->call()\n#38 /www/wwwroot/session.dpdns.org/vendor/symfony/console/Command/Command.php(255): Illuminate\\Console\\Command->execute()\n#39 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Console/Command.php(121): Symfony\\Component\\Console\\Command\\Command->run()\n#40 /www/wwwroot/session.dpdns.org/vendor/symfony/console/Application.php(1021): Illuminate\\Console\\Command->run()\n#41 /www/wwwroot/session.dpdns.org/vendor/symfony/console/Application.php(275): Symfony\\Component\\Console\\Application->doRunCommand()\n#42 /www/wwwroot/session.dpdns.org/vendor/symfony/console/Application.php(149): Symfony\\Component\\Console\\Application->doRun()\n#43 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Console/Application.php(93): Symfony\\Component\\Console\\Application->run()\n#44 /www/wwwroot/session.dpdns.org/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(131): Illuminate\\Console\\Application->run()\n#45 /www/wwwroot/session.dpdns.org/artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle()\n#46 {main}','2025-10-20 17:44:34');
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods`
--

DROP TABLE IF EXISTS `goods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL COMMENT '所属分类id',
  `gd_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品名称',
  `gd_description` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品描述',
  `gd_keywords` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商品关键字',
  `retail_price` decimal(10,2) DEFAULT '0.00' COMMENT '零售价',
  `picture` longtext COLLATE utf8_unicode_ci COMMENT '商品图片',
  `actual_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际售价',
  `preselection` decimal(10,2) DEFAULT '0.00' COMMENT '自选加价',
  `in_stock` int(11) NOT NULL DEFAULT '0' COMMENT '库存',
  `sales_volume` int(11) DEFAULT '0' COMMENT '销量',
  `ord` int(11) DEFAULT '1' COMMENT '排序权重 越大越靠前',
  `payment_limit` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '仅允许的支付方式',
  `buy_limit_num` int(11) NOT NULL DEFAULT '0' COMMENT '限制单次购买最大数量，0为不限制',
  `min_buy_num` int(11) NOT NULL DEFAULT '0' COMMENT '限制单次购买最小数量，0为不限制',
  `buy_prompt` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '购买提示',
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '商品描述',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '商品类型  1自动发货 2人工处理',
  `wholesale_price_cnf` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '批发价配置',
  `other_ipu_cnf` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '其他输入框配置',
  `api_hook` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '回调事件',
  `is_open` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用，1是 0否',
  `open_rebate` tinyint(3) NOT NULL DEFAULT '1' COMMENT '是否开启返利',
  `grade_0` decimal(10,2) DEFAULT '0.00' COMMENT '默认没有代理价格，不加入统计',
  `grade_1` decimal(10,2) DEFAULT '0.00' COMMENT '一级代理价格',
  `grade_2` decimal(10,2) DEFAULT '0.00' COMMENT '二级代理价格',
  `grade_3` decimal(10,2) DEFAULT '0.00' COMMENT '三级代理价格',
  `min_buy_count` int(11) DEFAULT '1' COMMENT '最小购买数量',
  `max_buy_count` int(11) DEFAULT '999' COMMENT '最大购买数量',
  `rebate_rate` decimal(5,2) DEFAULT '0.00' COMMENT '返利比例',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='商品表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods`
--

LOCK TABLES `goods` WRITE;
/*!40000 ALTER TABLE `goods` DISABLE KEYS */;
INSERT INTO `goods` VALUES (1,1,'测试商品1','测试商品描述','测试',0.00,NULL,1.00,0.00,0,28,1,'[]',0,0,'<p>测试购买提示</p>','<p>1111</p>',1,NULL,NULL,NULL,1,1,0.00,98.00,92.00,90.00,1,1,0.00,'2025-09-27 03:56:02','2025-10-08 07:45:50','2025-10-08 07:45:50'),(2,1,'123','测试描述','测试关键词',0.00,NULL,0.00,0.00,0,0,1,'[]',0,0,NULL,NULL,1,NULL,NULL,NULL,1,1,0.00,0.00,0.00,0.00,1,1,0.00,'2025-10-08 03:04:42','2025-10-08 03:36:51','2025-10-08 03:36:51'),(3,1,'1234123','1234123','1234123',0.00,NULL,0.00,0.00,0,0,1,'[]',0,0,NULL,'<p>12342341234123</p>',1,NULL,NULL,NULL,1,1,0.00,0.00,0.00,0.00,1,1,0.00,'2025-10-08 03:21:29','2025-10-08 03:36:51','2025-10-08 03:36:51'),(4,1,'1234123','1234123','1234123',0.00,NULL,0.00,0.00,0,0,1,'[]',0,0,NULL,'<p>12342341234123</p>',1,NULL,NULL,NULL,1,1,0.00,0.00,0.00,0.00,1,1,0.00,'2025-10-08 03:23:33','2025-10-08 03:36:51','2025-10-08 03:36:51'),(5,1,'1234123','1234123','1234123',0.00,NULL,0.00,0.00,0,0,1,'[]',0,0,NULL,'<p>12342341234123</p>',1,NULL,NULL,NULL,1,1,0.00,0.00,0.00,0.00,1,1,0.00,'2025-10-08 03:25:05','2025-10-08 03:36:51','2025-10-08 03:36:51'),(6,1,'1234123','1234123','1234123',0.00,NULL,0.00,0.00,0,0,1,'[]',0,0,NULL,'<p>12342341234123</p>',1,NULL,NULL,NULL,1,1,0.00,0.00,0.00,0.00,1,1,0.00,'2025-10-08 03:28:19','2025-10-08 03:36:51','2025-10-08 03:36:51'),(7,1,'123','1234','12345',0.00,NULL,0.00,0.00,0,0,1,'[]',0,0,NULL,NULL,1,NULL,NULL,NULL,1,1,0.00,0.00,0.00,0.00,1,1,0.00,'2025-10-08 03:37:20','2025-10-08 05:36:56','2025-10-08 05:36:56'),(8,1,'234','2345','23456',0.00,NULL,0.00,0.00,0,0,1,'[]',0,0,NULL,NULL,1,NULL,NULL,NULL,1,1,0.00,0.00,0.00,0.00,1,1,0.00,'2025-10-08 03:38:36','2025-10-08 05:36:56','2025-10-08 05:36:56'),(9,1,'234','2345','23456',0.00,NULL,0.00,0.00,0,0,1,'[]',0,0,NULL,NULL,1,NULL,NULL,NULL,1,1,0.00,0.00,0.00,0.00,1,1,0.00,'2025-10-08 03:38:55','2025-10-08 05:36:56','2025-10-08 05:36:56'),(10,1,'234','2345','23456',0.00,NULL,0.00,0.00,0,0,1,'[]',0,0,NULL,NULL,1,NULL,NULL,NULL,1,1,0.00,0.00,0.00,0.00,1,1,0.00,'2025-10-08 03:39:29','2025-10-08 05:36:56','2025-10-08 05:36:56'),(11,1,'234','2345','23456',0.00,NULL,0.00,0.00,0,0,1,'[]',0,0,NULL,NULL,1,NULL,NULL,NULL,1,1,0.00,0.00,0.00,0.00,1,1,0.00,'2025-10-08 03:39:58','2025-10-08 05:36:56','2025-10-08 05:36:56'),(12,1,'234','2345','23456',0.00,NULL,0.00,0.00,0,0,1,'[]',0,0,NULL,NULL,1,NULL,NULL,NULL,1,1,0.00,0.00,0.00,0.00,1,1,0.00,'2025-10-08 03:41:12','2025-10-08 05:36:56','2025-10-08 05:36:56'),(13,1,'234','2345','23456',0.00,NULL,0.00,0.00,0,0,1,'[]',0,0,NULL,NULL,1,NULL,NULL,NULL,1,1,0.00,0.00,0.00,0.00,1,1,0.00,'2025-10-08 03:41:43','2025-10-08 05:36:56','2025-10-08 05:36:56'),(14,1,'234','2345','23456',0.00,NULL,0.00,0.00,0,0,1,'[]',0,0,NULL,NULL,1,NULL,NULL,NULL,1,1,0.00,0.00,0.00,0.00,1,1,0.00,'2025-10-08 03:42:30','2025-10-08 05:36:56','2025-10-08 05:36:56'),(15,1,'234','2345','23456',0.00,NULL,0.00,0.00,0,0,1,'[]',0,0,NULL,NULL,1,NULL,NULL,NULL,1,1,0.00,0.00,0.00,0.00,1,1,0.00,'2025-10-08 03:42:51','2025-10-08 05:36:56','2025-10-08 05:36:56'),(16,1,'🧑‍🦽‍➡️telegram发卡机器人系统源码','telegram发卡机器人系统源码','发卡',0.00,NULL,150.00,0.00,0,0,1,'[]',0,0,'<p>asdfasdf</p>','<p>asdfasd</p>',1,NULL,NULL,NULL,1,1,0.00,120.00,90.00,75.00,1,1,0.00,'2025-10-08 07:47:13','2025-10-09 20:16:27',NULL),(17,1,'🫧telegram索引机器人系统','telegram索引机器人系统','telegram索引机器人系统',0.00,NULL,1.00,0.00,0,0,1,'[]',0,0,'<p>这是购买提示</p>','<p>这是商品描述</p>',1,NULL,NULL,NULL,1,1,0.00,1.00,1.00,1.00,1,1,0.00,'2025-10-08 07:50:00','2025-10-22 16:36:45',NULL);
/*!40000 ALTER TABLE `goods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `goods_group`
--

DROP TABLE IF EXISTS `goods_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goods_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gp_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '分类名称',
  `is_open` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用，1是 0否',
  `ord` int(11) NOT NULL DEFAULT '1' COMMENT '排序权重 越大越靠前',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='商品分类表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `goods_group`
--

LOCK TABLES `goods_group` WRITE;
/*!40000 ALTER TABLE `goods_group` DISABLE KEYS */;
INSERT INTO `goods_group` VALUES (1,'🙋机器人商品',1,1,'2025-09-27 03:55:00','2025-10-09 20:15:46',NULL);
/*!40000 ALTER TABLE `goods_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invite_user`
--

DROP TABLE IF EXISTS `invite_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `invite_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
  `order_id` int(11) unsigned NOT NULL COMMENT '订单号ID',
  `amount` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '返利金额',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `withdraw_id` int(11) DEFAULT NULL COMMENT '提现ID',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invite_user`
--

LOCK TABLES `invite_user` WRITE;
/*!40000 ALTER TABLE `invite_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `invite_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `langs`
--

DROP TABLE IF EXISTS `langs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `langs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(30) DEFAULT NULL COMMENT '图标',
  `title` varchar(30) DEFAULT NULL COMMENT '语言标题',
  `code` varchar(30) DEFAULT NULL COMMENT '语言代码',
  `created_at` varchar(60) DEFAULT NULL COMMENT '创建时间',
  `updated_at` varchar(60) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `langs`
--

LOCK TABLES `langs` WRITE;
/*!40000 ALTER TABLE `langs` DISABLE KEYS */;
INSERT INTO `langs` VALUES (1,'🇨🇳','简体中文','zh-CN','2025-09-29 01:54:42','2025-09-29 01:54:42');
/*!40000 ALTER TABLE `langs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(150) COLLATE utf8_unicode_ci NOT NULL COMMENT '订单号',
  `goods_id` int(11) NOT NULL COMMENT '关联商品id',
  `coupon_id` int(11) DEFAULT '0' COMMENT '关联优惠码id',
  `title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '订单名称',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1自动发货 2人工处理',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品单价',
  `buy_amount` int(11) NOT NULL DEFAULT '1' COMMENT '购买数量',
  `coupon_discount_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '优惠码优惠价格',
  `wholesale_discount_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '批发价优惠',
  `total_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '订单总价',
  `actual_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '实际支付价格',
  `search_pwd` varchar(200) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '查询密码',
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT '下单邮箱',
  `info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT '订单详情',
  `pay_id` int(11) DEFAULT NULL COMMENT '支付通道id',
  `buy_ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '购买者下单IP地址',
  `trade_no` varchar(200) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '第三方支付订单号',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1待支付 2待处理 3处理中 4已完成 5处理失败 6异常 -1过期',
  `aff` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'aff邀请码',
  `carmi_id` int(11) DEFAULT NULL COMMENT '关联预选卡密ID',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_order_sn` (`order_sn`) USING BTREE,
  KEY `idx_goods_id` (`goods_id`) USING BTREE,
  KEY `idex_email` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='订单表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'YDRLIPJ8WGBIT7BE',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','chaonimadeya@outlook.com','',23,'89.185.27.143','',1,NULL,1,'2025-09-27 03:57:00','2025-09-27 03:57:00',NULL),(2,'PTKGSsyr6zoasYCn',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-29 19:35:59','2025-09-29 19:35:59',NULL),(3,'F7UD0KJ6xTa4Z3Rw',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-29 19:36:01','2025-09-29 19:36:01',NULL),(4,'A0BbPo5tKpzDYfsZ',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-29 19:36:05','2025-09-29 19:36:05',NULL),(5,'l9N7w51lZ10vZGGM',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-29 19:36:13','2025-09-29 19:36:13',NULL),(6,'cIqz3V7pMijh2b03',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-29 19:36:23','2025-09-29 19:36:23',NULL),(7,'goKdET3vx24J6ITF',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-29 19:36:26','2025-09-29 19:36:26',NULL),(8,'rMoB1YOOHU1YeC8p',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-29 19:36:42','2025-09-29 19:36:42',NULL),(9,'38PtLqaH3mZZj9y7',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-29 19:37:19','2025-09-29 19:37:19',NULL),(10,'3YrGhXiqRGua70Ib',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6022284971@qq.com','用户余额充值',23,'59.188.192.46','',1,NULL,NULL,'2025-09-29 19:43:22','2025-09-29 19:43:22',NULL),(11,'xsOgzjpUuO2KjwUj',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-29 19:56:54','2025-09-29 19:56:54',NULL),(12,'4qPRCtDQQjodNBBa',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-29 19:58:10','2025-09-29 19:58:10',NULL),(13,'QxzAqsbbkPn4kF4N',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-29 19:59:44','2025-09-29 19:59:44',NULL),(14,'CNHm0IKBicZYPl1W',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-29 19:59:57','2025-09-29 19:59:57',NULL),(15,'lHKKecgaO0UfIcqM',0,0,'余额充值',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-29 20:01:47','2025-09-29 20:01:47',NULL),(16,'ptIcc9CPLBMy9OmW',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-29 20:12:49','2025-09-29 20:12:49',NULL),(17,'3oZHRAedU4IO8SlB',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-29 20:21:18','2025-09-29 20:21:18',NULL),(18,'4QKWgDbniM8iL0TG',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-29 20:21:20','2025-09-29 20:21:20',NULL),(19,'kQ7mO9hsSueSjYy6',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-29 20:21:59','2025-09-29 20:21:59',NULL),(20,'3TbvV6D9NvNPZXNR',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-29 20:25:03','2025-09-29 20:25:03',NULL),(21,'jRyqIEagqdUfHFZp',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-29 20:35:35','2025-09-29 20:35:35',NULL),(22,'3qY3zA13QAS35G2d',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-29 20:36:37','2025-09-29 20:36:37',NULL),(23,'AqOIVBFCukSAdTa4',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',19,'8.8.8.8','',1,NULL,NULL,'2025-09-29 20:58:10','2025-09-29 20:58:10',NULL),(24,'orTd48FRw6dlyHGp',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',19,'8.8.8.8','',1,NULL,NULL,'2025-09-29 20:58:40','2025-09-29 20:58:40',NULL),(25,'1fqdRkKGJzPv0VH7',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',19,'8.8.8.8','',1,NULL,NULL,'2025-09-29 20:59:16','2025-09-29 20:59:16',NULL),(26,'FbOM30H92VwaQyBj',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',19,'8.8.8.8','',1,NULL,NULL,'2025-09-29 21:04:12','2025-09-29 21:04:12',NULL),(27,'0GBstnu2pIxAlLkj',0,0,'余额充值',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com','用户余额充值',19,'8.8.8.8','',1,NULL,NULL,'2025-09-29 21:06:43','2025-09-29 21:06:43',NULL),(28,'d6pbmuGCKZcO1JOQ',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',13,'8.8.8.8','',1,NULL,NULL,'2025-09-29 21:17:10','2025-09-29 21:17:10',NULL),(29,'P0uEkWni81SECDtL',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',13,'8.8.8.8','',1,NULL,NULL,'2025-09-29 21:17:12','2025-09-29 21:17:12',NULL),(30,'rveu1mHRea7yVeIm',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',13,'8.8.8.8','',1,NULL,NULL,'2025-09-29 21:17:16','2025-09-29 21:17:16',NULL),(31,'C4P8YDRZ80NGWAcG',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',13,'8.8.8.8','',1,NULL,NULL,'2025-09-29 21:17:22','2025-09-29 21:17:22',NULL),(32,'3fKHs4Tqdi7lHlgK',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',13,'8.8.8.8','',1,NULL,NULL,'2025-09-29 21:17:33','2025-09-29 21:17:33',NULL),(33,'M4S9lUJUzUcF7a9H',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',13,'8.8.8.8','',1,NULL,NULL,'2025-09-29 21:17:51','2025-09-29 21:17:51',NULL),(34,'Pnwh5ljybpcZCJLJ',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',13,'8.8.8.8','',1,NULL,NULL,'2025-09-29 21:18:26','2025-09-29 21:18:26',NULL),(35,'LKUyHyjdya0JKkrI',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',13,'8.8.8.8','',1,NULL,NULL,'2025-09-29 21:24:42','2025-09-29 21:24:42',NULL),(36,'2pkMkinWYvGOp8vp',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',13,'8.8.8.8','',1,NULL,NULL,'2025-09-29 21:39:54','2025-09-29 21:39:54',NULL),(37,'BOKMSkY3Ga7aU1pu',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',13,'8.8.8.8','',1,NULL,NULL,'2025-09-29 21:42:11','2025-09-29 21:42:11',NULL),(38,'JXGjJht5HB0sW5QH',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',13,'8.8.8.8','',1,NULL,NULL,'2025-09-29 21:44:09','2025-09-29 21:44:09',NULL),(39,'KO8EPfXuMDw0vYOx',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',13,'8.8.8.8','',1,NULL,NULL,'2025-09-29 21:44:14','2025-09-29 21:44:14',NULL),(40,'RkGRWmV1oMqJCxp9',0,0,'余额充值',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com','用户余额充值',13,'8.8.8.8','',1,NULL,NULL,'2025-09-29 21:49:25','2025-09-29 21:49:25',NULL),(41,'X8RHBH5BXP4QKZ6H',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','chaonimadeya@outlook.com','',19,'59.188.192.21','',1,NULL,0,'2025-09-30 05:29:12','2025-09-30 05:29:12',NULL),(42,'B9TWZUJHQKJSA0IN',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com',NULL,19,'8.8.8.8','',1,'',NULL,'2025-09-30 05:54:48','2025-09-30 05:54:48',NULL),(43,'RSQ203084RUYBBQY',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com',NULL,19,'8.8.8.8','',1,'',NULL,'2025-09-30 05:55:15','2025-09-30 05:55:15',NULL),(44,'TE2TO42YBCCI59RI',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com',NULL,19,'8.8.8.8','',1,'',NULL,'2025-09-30 06:00:12','2025-09-30 06:00:12',NULL),(45,'GJEERLGYJIHJ3SDC',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com',NULL,19,'8.8.8.8','',1,'',NULL,'2025-09-30 06:01:01','2025-09-30 06:01:01',NULL),(46,'FQCXPNYST6NANTCF',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com',NULL,19,'8.8.8.8','',1,'',NULL,'2025-09-30 06:03:40','2025-09-30 06:03:40',NULL),(47,'UNUKC070SEMTK6UE',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','chaonimadeya@outlook.com','',19,'59.188.192.21','',1,NULL,0,'2025-09-30 06:10:04','2025-09-30 06:10:04',NULL),(48,'Q1PSBMGHQK4BPEZ3',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com',NULL,19,'8.8.8.8','',1,'',NULL,'2025-09-30 06:18:44','2025-09-30 06:18:44',NULL),(49,'ME61IYCBGNJUCR0K',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com',NULL,19,'8.8.8.8','',1,'',NULL,'2025-09-30 06:19:15','2025-09-30 06:19:15',NULL),(50,'DGX5SNPICQEMNFBT',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com',NULL,12,'8.8.8.8','',1,'',NULL,'2025-09-30 06:19:38','2025-09-30 06:19:38',NULL),(51,'DUC2WFHOPU7YQHQS',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6022284971','',0,'59.188.192.21','',1,NULL,0,'2025-09-30 06:24:05','2025-09-30 06:24:05',NULL),(52,'2EC68L7IDA0ZXJZE',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6022284971','',0,'59.188.192.21','',1,NULL,0,'2025-09-30 06:25:50','2025-09-30 06:25:50',NULL),(53,'2RZH5S2PUWTYWAO9',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com',NULL,0,'8.8.8.8','',1,'',NULL,'2025-09-30 06:26:51','2025-09-30 06:26:51',NULL),(54,'QQS91PA776Q2ME6O',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com',NULL,0,'8.8.8.8','',1,'',NULL,'2025-09-30 06:26:54','2025-09-30 06:26:54',NULL),(55,'B6AMOS2XRYE6AAPH',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com',NULL,0,'8.8.8.8','',1,'',NULL,'2025-09-30 06:26:58','2025-09-30 06:26:58',NULL),(56,'UHZMCZDXCP9MJE7E',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com',NULL,0,'8.8.8.8','',1,'',NULL,'2025-09-30 06:27:06','2025-09-30 06:27:06',NULL),(57,'IZ225SQOZ4ZBSBYR',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com',NULL,0,'8.8.8.8','',1,'',NULL,'2025-09-30 06:27:13','2025-09-30 06:27:13',NULL),(58,'QVASZDRNYVHASATK',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com',NULL,0,'8.8.8.8','',1,'',NULL,'2025-09-30 06:27:19','2025-09-30 06:27:19',NULL),(59,'UI1I477J8U40QN9O',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com',NULL,0,'8.8.8.8','',1,'',NULL,'2025-09-30 06:27:44','2025-09-30 06:27:44',NULL),(60,'B0ZOGSPQ8FTYBJ20',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com',NULL,0,'8.8.8.8','',1,'',NULL,'2025-09-30 06:28:21','2025-09-30 06:28:21',NULL),(61,'6X5L6RDPCNJZPK6X',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com',NULL,0,'8.8.8.8','',1,'',NULL,'2025-09-30 06:29:29','2025-09-30 06:29:29',NULL),(62,'POHFHNOBCB7FUOQD',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com',NULL,0,'8.8.8.8','',1,'',NULL,'2025-09-30 06:29:52','2025-09-30 06:29:52',NULL),(63,'DUMJRUBABAXD27B8',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com',NULL,0,'8.8.8.8','',1,'',NULL,'2025-09-30 06:44:43','2025-09-30 06:44:43',NULL),(64,'JGSv6VQBliKUqND1',0,0,'余额充值',1,10.00,1,0.00,0.00,10.00,10.00,'','6575617620@qq.com','用户余额充值',19,'8.8.8.8','',1,NULL,NULL,'2025-09-30 06:56:20','2025-09-30 06:56:20',NULL),(65,'ucYFhNRXVJ7et6uv',0,0,'余额充值',1,100.00,1,0.00,0.00,100.00,100.00,'','6575617620@qq.com','用户余额充值',19,'8.8.8.8','',1,NULL,NULL,'2025-09-30 07:00:47','2025-09-30 07:00:47',NULL),(66,'EEAqPsu528ZvwJqb',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-30 07:01:04','2025-09-30 07:01:04',NULL),(67,'IvfG9yxvD60m3iVw',0,0,'余额充值',1,21.00,1,0.00,0.00,21.00,21.00,'','6575617620@qq.com','用户余额充值',19,'8.8.8.8','',1,NULL,NULL,'2025-09-30 07:01:44','2025-09-30 07:01:44',NULL),(68,'cOAbqhSlTwZ04pDJ',0,0,'余额充值',1,21.00,1,0.00,0.00,21.00,21.00,'','6575617620@qq.com','用户余额充值',19,'8.8.8.8','',1,NULL,NULL,'2025-09-30 07:02:02','2025-09-30 07:02:02',NULL),(69,'n5LOyI9bJK4Us2CT',0,0,'余额充值',1,21.00,1,0.00,0.00,21.00,21.00,'','6575617620@qq.com','用户余额充值',19,'8.8.8.8','',1,NULL,NULL,'2025-09-30 07:02:54','2025-09-30 07:02:54',NULL),(70,'uWjHd6HZvr9F1IT7',0,0,'余额充值',1,20.00,1,0.00,0.00,20.00,20.00,'','6575617620@qq.com','用户余额充值',19,'8.8.8.8','',1,NULL,NULL,'2025-09-30 07:04:22','2025-09-30 07:04:22',NULL),(71,'glQoVWZOwaeK9x3G',0,0,'余额充值',1,21.00,1,0.00,0.00,21.00,21.00,'','6575617620@qq.com','用户余额充值',19,'8.8.8.8','',1,NULL,NULL,'2025-09-30 07:04:33','2025-09-30 07:04:33',NULL),(72,'92VKk92EGZSBbTHo',0,0,'余额充值',1,21.00,1,0.00,0.00,21.00,21.00,'','6575617620@qq.com','用户余额充值',19,'8.8.8.8','',1,NULL,NULL,'2025-09-30 07:05:12','2025-09-30 07:05:12',NULL),(73,'0MgBzi34H73mxem7',0,0,'余额充值',1,21.00,1,0.00,0.00,21.00,21.00,'','6575617620@qq.com','用户余额充值',19,'8.8.8.8','',1,NULL,NULL,'2025-09-30 07:06:39','2025-09-30 07:06:39',NULL),(74,'41k8yBf7oiSlB6g6',0,0,'余额充值',1,21.00,1,0.00,0.00,21.00,21.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-30 07:07:03','2025-09-30 07:07:03',NULL),(75,'mGorckbFgZGfT8Qz',0,0,'余额充值',1,11.00,1,0.00,0.00,11.00,11.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',1,NULL,NULL,'2025-09-30 07:08:29','2025-09-30 07:08:29',NULL),(76,'gO3zhAAcm91zCMsi',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','6575617620@qq.com','用户余额充值',23,'8.8.8.8','',4,NULL,NULL,'2025-09-30 07:09:56','2025-10-08 10:12:15',NULL),(77,'9XQPLY675ZUHMN6T',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6022284971','1242341',0,'112.54.92.141','0',4,NULL,0,'2025-10-05 05:45:13','2025-10-05 05:47:07',NULL),(78,'FEOV14JBUSEN66DH',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6022284971','1242341',0,'112.54.92.141','0',4,NULL,0,'2025-10-05 05:58:19','2025-10-05 05:58:21',NULL),(79,'35BBMWG151EWTB6X',1,0,'测试商品1 x 1',1,100.00,1,0.00,0.00,100.00,100.00,'','6022284971','',0,'112.54.92.141','',1,NULL,0,'2025-10-05 05:58:58','2025-10-05 05:58:58',NULL),(80,'ZW16OH38TA45F5UN',1,0,'测试商品1 x 2',1,1.00,2,0.00,0.00,2.00,2.00,'','6022284971','1242341\nasdf',0,'112.54.92.141','0',4,NULL,0,'2025-10-05 06:00:04','2025-10-05 06:11:16',NULL),(81,'JJSIMTMVUY21BQSV',1,0,'测试商品1 x 2',1,1.00,2,0.00,0.00,2.00,2.00,'','6022284971','1242341\nasdf',0,'112.54.92.141','0',4,NULL,0,'2025-10-05 06:15:01','2025-10-05 06:15:03',NULL),(82,'48P92KBSNM47M3HH',1,0,'测试商品1 x 2',1,1.00,2,0.00,0.00,2.00,2.00,'','6022284971','1242341\nasdf',0,'112.54.92.141','0',4,NULL,0,'2025-10-05 06:16:20','2025-10-05 06:16:22',NULL),(83,'AVMFFFP9E0TFRZ67',1,0,'测试商品1 x 2',1,1.00,2,0.00,0.00,2.00,2.00,'','6022284971','1242341\nasdf',0,'112.54.92.141','0',4,NULL,0,'2025-10-05 11:36:03','2025-10-05 11:36:05',NULL),(84,'A9DWXFHWTCEHW0FW',1,0,'测试商品1 x 2',1,1.00,2,0.00,0.00,2.00,2.00,'','6022284971','1242341\nasdf',0,'112.54.92.141','0',4,NULL,0,'2025-10-05 11:37:27','2025-10-05 11:37:30',NULL),(85,'RAUE55MWJPCPIDBT',1,0,'测试商品1 x 2',1,1.00,2,0.00,0.00,2.00,2.00,'','6022284971','1242341\nasdf',0,'112.54.92.141','0',4,NULL,0,'2025-10-05 11:38:54','2025-10-05 11:38:56',NULL),(86,'YLMM9DHWNWTDLO3V',1,0,'测试商品1 x 2',1,1.00,2,0.00,0.00,2.00,2.00,'','6022284971','1242341\nasdf',0,'112.54.92.141','0',4,NULL,0,'2025-10-05 11:49:57','2025-10-05 12:00:05',NULL),(87,'KQE8LXRBKCNCJSM3',1,0,'测试商品1 x 1',1,1.00,1,0.00,0.00,1.00,1.00,'','6022284971','',0,'89.185.27.143','',1,NULL,0,'2025-10-05 12:04:41','2025-10-05 12:04:41',NULL),(88,'J4LMX0X4IZIC3KGN',1,0,'测试商品1 x 2',1,1.00,2,0.00,0.00,2.00,2.00,'','6022284971','1242341\nasdf',0,'89.185.27.143','0',4,NULL,0,'2025-10-05 12:04:46','2025-10-05 12:04:48',NULL),(89,'1LTU7RC5DLATMAPF',1,0,'测试商品1 x 2',1,1.00,2,0.00,0.00,2.00,2.00,'','6022284971','1242341\nasdf',0,'89.185.27.143','0',4,NULL,0,'2025-10-05 12:06:13','2025-10-05 12:06:15',NULL),(90,'K6WFTAZEBJTISYLK',1,0,'测试商品1 x 2',1,1.00,2,0.00,0.00,2.00,2.00,'','6022284971','2.txt\n1.txt',0,'89.185.27.143','0',4,NULL,0,'2025-10-05 12:58:15','2025-10-05 13:04:34',NULL),(91,'PBYN5QOZF138ZHI7',1,0,'测试商品1 x 2',1,1.00,2,0.00,0.00,2.00,2.00,'','6022284971','2\n1',0,'89.185.27.143','0',4,NULL,0,'2025-10-05 13:06:30','2025-10-05 13:14:45',NULL),(92,'4CFIQ0OW3NISVTSQ',1,0,'测试商品1 x 2',1,1.00,2,0.00,0.00,2.00,2.00,'','6022284971','2\n1',0,'89.185.27.143','0',4,NULL,0,'2025-10-05 13:16:46','2025-10-05 13:16:48',NULL),(93,'DZO7XOLYS7WBQVI7',1,0,'测试商品1 x 2',1,1.00,2,0.00,0.00,2.00,2.00,'','6575617620@qq.com',NULL,0,'8.8.8.8','',1,'',NULL,'2025-10-05 13:18:53','2025-10-05 13:18:53',NULL),(94,'FMPI3YHPHAZVCGFS',1,0,'测试商品1 x 2',1,1.00,2,0.00,0.00,2.00,2.00,'','6022284971@qq.com','2.txt\n1.txt',0,'8.8.8.8','0',4,'',NULL,'2025-10-05 13:19:35','2025-10-05 13:19:38',NULL),(95,'z4rdC7FsIz3QPekI',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','7681132581@qq.com','用户余额充值',23,'8.8.8.8','',-1,NULL,NULL,'2025-10-08 12:07:41','2025-10-09 21:31:50',NULL),(96,'MJ63cYyASrTpyTf2',0,0,'余额充值',1,50.00,1,0.00,0.00,50.00,50.00,'','7681132581@qq.com','用户余额充值',12,'8.8.8.8','',-1,NULL,NULL,'2025-10-09 20:18:10','2025-10-09 21:31:50',NULL),(97,'LCB1WMAJEJ2CTQ6I',16,0,'🧑‍🦽‍➡️telegram发卡机器人系统源码 x 1',1,150.00,1,0.00,0.00,150.00,150.00,'','6022284971@qq.com',NULL,23,'8.8.8.8','',-1,'',NULL,'2025-10-09 20:29:12','2025-10-09 21:31:50',NULL),(98,'6KGUKZGGEVTXYPLZ',16,0,'🧑‍🦽‍➡️telegram发卡机器人系统源码 x 1',1,150.00,1,0.00,0.00,150.00,150.00,'','6022284971@qq.com',NULL,23,'8.8.8.8','',-1,'',NULL,'2025-10-09 20:32:58','2025-10-09 21:31:50',NULL),(99,'IFJW1OA65VWFOKYU',16,0,'🧑‍🦽‍➡️telegram发卡机器人系统源码 x 1',1,150.00,1,0.00,0.00,150.00,150.00,'','6022284971@qq.com',NULL,23,'8.8.8.8','',-1,'',NULL,'2025-10-09 20:37:20','2025-10-09 21:31:50',NULL),(100,'XSMHMXVEMPZN1GEU',16,0,'🧑‍🦽‍➡️telegram发卡机器人系统源码 x 1',1,150.00,1,0.00,0.00,150.00,150.00,'','6022284971@qq.com',NULL,23,'8.8.8.8','',-1,'',NULL,'2025-10-09 20:53:42','2025-10-09 21:31:50',NULL),(101,'YQX27OPVIRC4XYPK',16,0,'🧑‍🦽‍➡️telegram发卡机器人系统源码 x 1',1,150.00,1,0.00,0.00,150.00,150.00,'','7681132581@qq.com',NULL,23,'8.8.8.8','',-1,'',NULL,'2025-10-09 21:54:32','2025-10-09 21:59:33',NULL),(102,'HO4MESQCS2DMLDYF',16,0,'🧑‍🦽‍➡️telegram发卡机器人系统源码 x 1',1,150.00,1,0.00,0.00,150.00,150.00,'','7681132581@qq.com',NULL,0,'8.8.8.8','',1,'',NULL,'2025-10-19 09:54:21','2025-10-19 09:54:21',NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pays`
--

DROP TABLE IF EXISTS `pays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pay_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '支付名称',
  `pay_check` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '支付标识',
  `pay_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '通道费率',
  `is_openfee` tinyint(1) NOT NULL COMMENT '费率是否启用 1是 0否',
  `pay_qhuilv` decimal(10,2) NOT NULL DEFAULT '1.00' COMMENT '汇率比例',
  `pay_operation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '*' COMMENT '汇率运算符号',
  `is_openhui` tinyint(1) NOT NULL COMMENT '强制汇率是否启用 1是 0否',
  `pay_method` tinyint(1) NOT NULL COMMENT '支付方式 1跳转 2扫码',
  `pay_client` tinyint(1) NOT NULL DEFAULT '1' COMMENT '支付场景：1电脑pc 2手机 3全部',
  `merchant_id` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '商户 ID',
  `merchant_key` longtext COLLATE utf8mb4_unicode_ci COMMENT '商户 KEY',
  `merchant_pem` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '商户密钥',
  `pay_handleroute` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '支付处理路由',
  `controller` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '控制器',
  `is_open` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用 1是 0否',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_pay_check` (`pay_check`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pays`
--

LOCK TABLES `pays` WRITE;
/*!40000 ALTER TABLE `pays` DISABLE KEYS */;
INSERT INTO `pays` VALUES (1,'支付宝当面付','zfbf2f',0.00,0,1.00,'*',0,2,3,'商户号','支付宝公钥','商户私钥','/pay/alipay','AlipayController',0,'2025-09-26 19:43:12','2025-09-26 19:43:12',NULL),(2,'支付宝 PC','aliweb',0.00,0,1.00,'*',0,1,1,'商户号','','密钥','/pay/alipay','AlipayController',0,'2025-09-26 19:43:12','2025-09-26 19:43:12',NULL),(3,'支付宝 WAP','aliwap',0.00,0,1.00,'*',0,1,2,'商户号','','密钥','/pay/alipay','AlipayController',0,'2025-09-26 19:43:12','2025-09-26 19:43:12',NULL),(4,'微信扫码','wescan',0.00,0,1.00,'*',0,2,1,'商户号','','V2密钥','/pay/wepay','WepayController',0,'2025-09-26 19:43:12','2025-09-26 19:43:12',NULL),(5,'微信小程序','miniapp',0.00,0,1.00,'*',0,1,2,'商户号','','V2密钥','/pay/wepay','WepayController',0,'2025-09-26 19:43:12','2025-09-26 19:43:12',NULL),(6,'码支付 QQ','mqq',0.00,0,1.00,'*',0,1,1,'商户号','','密钥','/pay/mapay','MapayController',0,'2025-09-26 19:43:12','2025-09-26 19:43:12',NULL),(7,'码支付支付宝','mzfb',0.00,0,1.00,'*',0,1,1,'商户号','','密钥','/pay/mapay','MapayController',0,'2025-09-26 19:43:12','2025-09-26 19:43:12',NULL),(8,'码支付微信','mwx',0.00,0,1.00,'*',0,1,1,'商户号','','密钥','/pay/mapay','MapayController',0,'2025-09-26 19:43:12','2025-09-26 19:43:12',NULL),(9,'Paysapi 支付宝','pszfb',0.00,0,1.00,'*',0,1,1,'商户号','','密钥','/pay/paysapi',NULL,0,'2025-09-26 19:43:12','2025-09-26 19:43:12',NULL),(10,'Paysapi 微信','pswx',0.00,0,1.00,'*',0,1,1,'商户号','','密钥','/pay/paysapi',NULL,0,'2025-09-26 19:43:12','2025-09-26 19:43:12',NULL),(11,'Payjs 微信扫码','payjswescan',0.00,0,1.00,'*',0,1,1,'商户号','','密钥','/pay/payjs',NULL,0,'2025-09-26 19:43:12','2025-09-26 19:43:12',NULL),(12,'易支付-支付宝','alipay',0.00,0,1.00,'*',0,1,1,'4762','http://api.uz6.cn/','HZKrgaKlAM5QMfQvqz2NaLVrQjRLLu2L','/pay/yipay','YipayController',0,'2025-09-26 19:43:12','2025-10-19 09:59:02',NULL),(13,'易支付-微信','wxpay',0.00,0,1.00,'*',0,1,1,'4762','http://api.uz6.cn/','HZKrgaKlAM5QMfQvqz2NaLVrQjRLLu2L','/pay/yipay','YipayController',0,'2025-09-26 19:43:12','2025-10-19 09:59:03',NULL),(14,'易支付-QQ 钱包','qqpay',0.00,0,1.00,'*',0,1,1,'商户号',NULL,'密钥','/pay/yipay','YipayController',0,'2025-09-26 19:43:12','2025-09-26 19:43:12',NULL),(15,'PayPal','paypal',0.00,0,1.00,'*',0,1,1,'商户号',NULL,'密钥','/pay/paypal',NULL,0,'2025-09-26 19:43:12','2025-09-26 19:43:12',NULL),(16,'V 免签支付宝','vzfb',0.00,0,1.00,'*',0,1,1,'V 免签通讯密钥',NULL,'V 免签地址 例如 https://vpay.qq.com/ 结尾必须有/','pay/vpay',NULL,0,'2025-09-26 19:43:12','2025-09-26 19:43:12',NULL),(17,'V 免签微信','vwx',1.00,0,1.00,'*',0,1,1,'V 免签通讯密钥',NULL,'V 免签地址 例如 https://vpay.qq.com/ 结尾必须有/','pay/vpay',NULL,0,'2025-09-26 19:43:12','2025-09-26 19:43:12',NULL),(18,'Stripe[微信支付宝]','stripe',0.00,0,1.00,'*',0,1,1,'pk开头的可发布密钥',NULL,'sk开头的密钥','pay/stripe',NULL,0,'2025-09-26 19:43:12','2025-09-26 19:43:12',NULL),(19,'Epusdt[trc20]','epusdt',0.00,0,1.00,'*',0,1,3,'qwe12345','不填即可','https://epusdt.oo-oo.eu.org/api/v1/order/create-transaction','pay/epusdt','EpusdtController',0,'2025-09-26 19:43:12','2025-10-19 09:59:08',NULL),(20,'Coinbase[加密货币]','coinbase',0.00,0,1.00,'*',0,1,3,'费率','API密钥','共享密钥','pay/coinbase',NULL,0,'2025-09-26 19:43:12','2025-09-26 19:43:12',NULL),(21,'币安支付','binance',0.00,0,1.00,'*',0,1,3,'USDT','API密钥','密钥','pay/binance',NULL,0,'2025-09-26 19:43:12','2025-09-26 19:43:12',NULL),(22,'TRX','tokenpay-trx',0.00,0,1.00,'*',0,1,3,'TRX','你的API密钥','https://token-pay.xxx.com','pay/tokenpay','TokenPayController',0,'2025-09-26 19:43:12','2025-09-27 03:54:18',NULL),(23,'USDT-TRC20','tokenpay-usdt-trc',0.00,0,1.00,'*',0,1,3,'USDT_TRC20','666666','https://tokenpay.8br.dpdns.org','pay/tokenpay','TokenPayController',1,'2025-09-26 19:43:12','2025-09-27 03:54:43',NULL),(24,'ETH','tokenpay-eth',0.00,0,1.00,'*',0,1,3,'EVM_ETH_ETH','你的API密钥','https://token-pay.xxx.com','pay/tokenpay','TokenPayController',0,'2025-09-26 19:43:12','2025-09-27 03:54:20',NULL),(25,'USDT-ERC20','tokenpay-usdt-erc',0.00,0,1.00,'*',0,1,3,'EVM_ETH_USDT_ERC20','你的API密钥','https://token-pay.xxx.com','pay/tokenpay','TokenPayController',0,'2025-09-26 19:43:12','2025-09-27 03:54:21',NULL),(26,'USDC-ERC20','tokenpay-usdc-erc',0.00,0,1.00,'*',0,1,3,'EVM_ETH_USDC_ERC20','你的API密钥','https://token-pay.xxx.com','pay/tokenpay','TokenPayController',0,'2025-09-26 19:43:12','2025-09-27 03:54:22',NULL),(27,'BNB','tokenpay-bnb',0.00,0,1.00,'*',0,1,3,'EVM_BSC_BNB','你的API密钥','https://token-pay.xxx.com','pay/tokenpay','TokenPayController',0,'2025-09-26 19:43:12','2025-09-27 03:54:25',NULL),(28,'USDT-BSC','tokenpay-usdt-bsc',0.00,0,1.00,'*',0,1,3,'EVM_BSC_USDT_BEP20','你的API密钥','https://token-pay.xxx.com','pay/tokenpay','TokenPayController',0,'2025-09-26 19:43:12','2025-09-27 03:54:27',NULL),(29,'USDC-BSC','tokenpay-usdc-bsc',0.00,0,1.00,'*',0,1,3,'EVM_BSC_USDC_BEP20','你的API密钥','https://token-pay.xxx.com','pay/tokenpay','TokenPayController',0,'2025-09-26 19:43:12','2025-09-27 03:54:28',NULL),(30,'MATIC','tokenpay-matic',0.00,0,1.00,'*',0,1,3,'EVM_Polygon_MATIC','你的API密钥','https://token-pay.xxx.com','pay/tokenpay','TokenPayController',0,'2025-09-26 19:43:12','2025-09-27 03:54:29',NULL),(31,'USDT-Polygon','tokenpay-usdt-matic',0.00,0,1.00,'*',0,1,3,'EVM_Polygon_USDT_ERC20','你的API密钥','https://token-pay.xxx.com','pay/tokenpay','TokenPayController',0,'2025-09-26 19:43:12','2025-09-27 03:54:31',NULL),(32,'USDC-Polygon','tokenpay-usdc-matic',0.00,0,1.00,'*',0,1,3,'EVM_Polygon_USDC_ERC20','你的API密钥','https://token-pay.xxx.com','pay/tokenpay','TokenPayController',0,'2025-09-26 19:43:12','2025-09-27 03:54:32',NULL);
/*!40000 ALTER TABLE `pays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '邮箱',
  `telegram_id` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'tg的id',
  `telegram_nick` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'tg的昵称',
  `telegram_username` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'tg的用户名',
  `platform` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'web' COMMENT '注册平台',
  `lang` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT 'zh-CN' COMMENT '所属语言',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '密码',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '余额',
  `last_ip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '最后登录IP',
  `last_login` timestamp NULL DEFAULT NULL COMMENT '最后登录时间',
  `register_at` timestamp NULL DEFAULT NULL COMMENT '注册时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '账号状态 1:正常 2:禁止登陆',
  `invite_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '邀请码',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级用户ID',
  `remark` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '备注',
  `remember_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade` int(11) DEFAULT '0' COMMENT '等级',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `user_email_unique` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'chaonimadeya@outlook.com',NULL,NULL,NULL,'web','zh-CN','$2y$10$vrSlqZYf1DMlQRh3vpJpQe2NNHd83BQAW3hfAAzU9XOCvdO6lU4Km',0.00,'58.177.58.159','2025-09-28 04:40:46','2025-09-28 04:40:02',1,'ENMPw7YB',0,NULL,'rSybX14jaaIcDwDpbRMJu3KxsE8IJGG13IKr1AILrUudRL2Z5HOzoyI3WG4X',0,'2025-09-28 04:40:02','2025-09-28 04:40:46',NULL),(2,NULL,'6022284971','不知 归期','buzhiguiqi','web','zh-CN','$2y$10$BRRivYLKYIKIZ/PPMTPD/Oi8X9SFZU8uguwkB/UzvpDm4ttwyutb2',0.00,'140.238.12.79','2025-10-08 02:30:53','2025-09-28 05:09:53',1,'jxXLSGup',0,NULL,'gqmIvrAZWNJqwCsbkamqSL4GZNYfVxaZsFZ2UJXwIlkSTmv4Ozw7rYElUM1C',0,'2025-09-28 05:09:53','2025-10-08 10:09:44',NULL),(3,NULL,'6575617620','Cade Steph','easSearchs','telegram_bot','zh-CN','$2y$10$Lg56B2N3z3TtrJ48cne8S.ihfL9RQIgmfHNauobedrqxanvST8uRm',8000.00,NULL,'2025-09-29 03:57:25','2025-09-29 03:57:25',1,'sCgb1wtr',0,NULL,NULL,0,'2025-09-29 03:57:25','2025-10-07 23:58:43',NULL),(4,NULL,'1643234665','Tony ','Tuiwnwp','telegram_bot','zh-CN','$2y$10$r9D1GrskD.Pu4SeIUl9nAeBRXs0H5lRAlkFW.RChjhThX3NDYKAEa',0.00,NULL,'2025-09-29 04:23:35','2025-09-29 04:23:35',1,'HPJatFKo',0,NULL,NULL,0,'2025-09-29 04:23:35','2025-09-29 04:23:35',NULL),(5,NULL,'6584332082','Diya ','Diauid','telegram_bot','zh-CN','$2y$10$6Kvq6Sgaj4dB1oWgJ8cW2uJfUt1JWljbpkyChL20QM3W9..zAvwu.',0.00,NULL,'2025-09-30 00:32:24','2025-09-30 00:32:24',1,'BOfFWJf3',0,NULL,NULL,0,'2025-09-30 00:32:24','2025-09-30 00:32:24',NULL),(6,NULL,'5809832805','mini k','wienvsuw','telegram_bot','zh-CN','$2y$10$1z./P2xNF7sa1qzUwpDRt.vNsWylghpPb4z1GvOz5mapPCFm5f21.',0.00,NULL,'2025-09-30 00:33:54','2025-09-30 00:33:54',1,'SD1fktuz',0,NULL,NULL,0,'2025-09-30 00:33:54','2025-09-30 00:33:54',NULL),(7,NULL,'7681132581','渣渣辉 ','laosiji1116','telegram_bot','zh-CN','$2y$10$ECk5RjrOZv0ljJcoYs7LcutKcyb3qf3UW53aOvukj8H6abfGIm63m',0.00,NULL,'2025-10-06 12:53:48','2025-10-06 12:53:48',1,'L8ac1gyc',0,NULL,NULL,0,'2025-10-06 12:53:48','2025-10-06 12:53:48',NULL),(8,NULL,'8147560562','冷杖 ','lengzhang','telegram_bot','zh-CN','$2y$10$qJs6BLQ1EF8fc5ttK4SIIezUtdjtkBvG/omBeA4d3o191tBiyDUhy',0.00,NULL,'2025-10-09 12:32:02','2025-10-09 12:32:02',1,'M9dr8z49',0,NULL,NULL,0,'2025-10-09 12:32:02','2025-10-09 12:32:02',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `verify_codes`
--

DROP TABLE IF EXISTS `verify_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `verify_codes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(168) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '邮箱',
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '验证码',
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '是否使用0: 未使用 1:已使用 2:已失效',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verify_codes`
--

LOCK TABLES `verify_codes` WRITE;
/*!40000 ALTER TABLE `verify_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `verify_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `withdraw`
--

DROP TABLE IF EXISTS `withdraw`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `withdraw` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
  `amount` decimal(8,2) NOT NULL DEFAULT '0.00' COMMENT '提现金额',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1: 转余额 2：提现',
  `account` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '账号',
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '提现状态',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `withdraw`
--

LOCK TABLES `withdraw` WRITE;
/*!40000 ALTER TABLE `withdraw` DISABLE KEYS */;
/*!40000 ALTER TABLE `withdraw` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'session_dpdns_or'
--

--
-- Dumping routines for database 'session_dpdns_or'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-01 13:48:42
