CREATE DATABASE  IF NOT EXISTS `apae29d7_apato` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `apae29d7_apato`;
-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: localhost    Database: apae29d7_apato
-- ------------------------------------------------------
-- Server version	5.7.16-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_super_admin` tinyint(1) NOT NULL DEFAULT '0',
  `apartment_id` int(11) NOT NULL DEFAULT '-1',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_username_unique` (`username`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'AAAAA','Tran Thi','manager01','$2y$10$8vJ0mQ2ocuE7W7o.NFCWZ.Kv7AY5HL4kOAQcVc9XzBwE3b0nipYfq','$2y$10$Wa4LScDV8uWmGZKGopTPj.C4mC7TssgUY7mXJNcBtRRov6elNn.7u','manager01@gmail.com',0,1,'fyPmZbSz6WMTi6DvkTiSyQUdz5me55asN490tsAsRvEawGzDLZhUsWAovRTc',NULL,'2017-05-18 22:29:32'),(2,'Baneaaaaxxwwwss','Nguyen','manager02','$2y$10$uDVboc6VCrUNG86kC09SWeQYJfUYiiTyldSrIh1d9iC/P0Fgf78ny','$2y$10$HBH8XfV9iusp69sDB64UnOxLYlPsbaEKixdBC2EIey2CULNoveBsW','manager02@gmail.com',0,2,'Ru4oKqh9CB7gONFNglvapk6UljQttqdR0mlPy42tmhAzMm4pZkdahxM43eZD',NULL,'2017-02-27 10:24:26'),(3,'TEO','TI','admin01','$2y$10$uDVboc6VCrUNG86kC09SWeQYJfUYiiTyldSrIh1d9iC/P0Fgf78ny','$2y$10$blp37cCx9BfmJ51KgD2Fgu/FQF30N/zpQfyGd2GFt7FxMID2wFj/W','admin@gmail.com',1,-1,'l6QNsCFUiY0tCszhJXXJjkFnjuCYD5Wp8x3VSWXsuo3NdMC80noUTN5XIgvE',NULL,'2017-05-18 22:29:54'),(4,'Trinh','Ngo','manager03','',NULL,'manager03',0,2,NULL,'2017-02-12 18:01:09','2017-02-12 18:01:09'),(5,'TTTTT','TEO','tanloi','$2y$10$PZV.GMRkkGEf3.TwLHyrcu1uncZywMJ3Zfe2h8prBqIOZmEAfymUe','$2y$10$qnb64msjNJVetca0baATKu3sMwJIoK6UU2o7m1JtvE2TJuCAMhzAq','tanloi',0,1,'rOFLkKG7MiYrLloP35fqzBkzKPIDjRlrD2Wj6uDupnVPDsvdhYT7cWx31S1T','2017-02-12 18:30:12','2017-02-12 18:30:28'),(6,'aA','TEO','manage123123213','$2y$10$1JwLH6EoUdJlV8SYCpokS.zCGXx75Un6m3ctcX7aM6zEYCEC41fZy','$2y$10$ekNz3j19SmxrYV1wqBz97uv7KKTeEbXGL1dYpJux.j9c7R9uAoN1q','manage123123213',0,1,NULL,'2017-02-17 09:56:17','2017-02-17 09:56:17');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `apartments`
--

DROP TABLE IF EXISTS `apartments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `apartments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `register_code` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `register_code_UNIQUE` (`register_code`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apartments`
--

LOCK TABLES `apartments` WRITE;
/*!40000 ALTER TABLE `apartments` DISABLE KEYS */;
INSERT INTO `apartments` VALUES (1,'Tân Lợi Hiệp Thành','34 Phan Xích Long','123','2016-12-26 17:00:00',NULL,NULL),(2,'Phú Mỹ Hưng','55 Quận 7','456','2016-11-10 17:00:00',NULL,NULL),(3,'Nam Long','Tp Hồ Chí Minh','789','2016-11-10 17:00:00',NULL,NULL),(4,'Nova land','Sài Gòn',NULL,'2016-11-10 17:00:00',NULL,NULL),(5,'Đpartment 1','Tp Hồ Chí Minh',NULL,'2016-11-10 17:00:00',NULL,NULL),(6,'Apartment 2','Tp Hồ Chí Minh',NULL,'2016-11-10 17:00:00',NULL,NULL),(7,'Apartment 3','Tp Hồ Chí Minh',NULL,'2016-11-10 17:00:00',NULL,NULL),(8,'Apartment 4','Tp Hồ Chí Minh',NULL,'2016-11-10 17:00:00',NULL,NULL),(9,'Apartment 5','Tp Hồ Chí Minh',NULL,'2016-11-10 17:00:00',NULL,NULL),(10,'Apartment 6','Tp Hồ Chí Minh',NULL,'2016-11-10 17:00:00',NULL,NULL),(11,'Apartment 7','Tp Hồ Chí Minh',NULL,'2016-11-10 17:00:00',NULL,NULL),(12,'Apartment 8','Tp Hồ Chí Minh',NULL,'2016-11-10 17:00:00',NULL,NULL),(13,'Apartment 9','Tp Hồ Chí Minh',NULL,'2016-11-10 17:00:00',NULL,NULL),(14,'Apartment 10','Tp Hồ Chí Minh',NULL,'2016-11-10 17:00:00',NULL,NULL),(15,'Apartment 11','Tp Hồ Chí Minh',NULL,'2016-11-10 17:00:00',NULL,NULL),(16,'Apartment 12','Tp Hồ Chí Minh',NULL,'2016-11-10 17:00:00',NULL,NULL),(17,'Apartment 13','Tp Hồ Chí Minh',NULL,'2016-11-10 17:00:00',NULL,NULL),(18,'Apartment 14','Tp Hồ Chí Minh',NULL,'2016-11-10 17:00:00',NULL,NULL),(19,'Apartment 15','Tp Hồ Chí Minh',NULL,'2016-11-10 17:00:00',NULL,NULL);
/*!40000 ALTER TABLE `apartments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blocks`
--

DROP TABLE IF EXISTS `blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blocks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `apartment_id` int(11) NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blocks`
--

LOCK TABLES `blocks` WRITE;
/*!40000 ALTER TABLE `blocks` DISABLE KEYS */;
INSERT INTO `blocks` VALUES (5,'A1',1,0,NULL,NULL,NULL),(6,'A2',1,0,NULL,NULL,NULL),(7,'A3',1,0,NULL,NULL,NULL),(8,'Đ1',2,0,NULL,NULL,NULL),(9,'A1',2,0,NULL,NULL,NULL),(10,'F1',2,0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `floors`
--

DROP TABLE IF EXISTS `floors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `floors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL,
  `block_id` int(11) NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `floors`
--

LOCK TABLES `floors` WRITE;
/*!40000 ALTER TABLE `floors` DISABLE KEYS */;
INSERT INTO `floors` VALUES (1,1,5,0,NULL,NULL,NULL),(2,2,5,0,NULL,NULL,NULL),(3,1,8,0,NULL,NULL,NULL),(4,3,5,0,NULL,NULL,NULL),(5,4,5,0,NULL,NULL,NULL),(6,5,5,0,NULL,NULL,NULL),(7,2,8,0,NULL,NULL,NULL),(8,3,8,0,NULL,NULL,NULL),(9,4,8,0,NULL,NULL,NULL),(10,5,8,0,NULL,NULL,NULL),(11,6,8,0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `floors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2017_05_19_001248_create_admins_table',1),(2,'2017_05_19_001248_create_apartments_table',1),(3,'2017_05_19_001248_create_blocks_table',1),(4,'2017_05_19_001248_create_floors_table',1),(5,'2017_05_19_001248_create_notifications_table',1),(6,'2017_05_19_001248_create_password_resets_table',1),(7,'2017_05_19_001248_create_provider_service_types_table',1),(8,'2017_05_19_001248_create_providers_table',1),(9,'2017_05_19_001248_create_requirement_images_table',1),(10,'2017_05_19_001248_create_requirements_table',1),(11,'2017_05_19_001248_create_rooms_table',1),(12,'2017_05_19_001248_create_service_apartments_table',1),(13,'2017_05_19_001248_create_service_calls_table',1),(14,'2017_05_19_001248_create_service_clicks_table',1),(15,'2017_05_19_001248_create_service_re_calls_table',1),(16,'2017_05_19_001248_create_service_types_table',1),(17,'2017_05_19_001248_create_services_table',1),(18,'2017_05_19_001248_create_settings_table',1),(19,'2017_05_19_001248_create_survey_options_table',1),(20,'2017_05_19_001248_create_user_surveys_table',1),(21,'2017_05_19_001248_create_users_table',1),(22,'2017_05_20_090844_alter_users_table_for_admin_residential',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Empty',
  `subTitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Empty',
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `privacyType` tinyint(1) NOT NULL DEFAULT '0',
  `remindDate` datetime DEFAULT NULL,
  `isStickyHome` tinyint(1) NOT NULL DEFAULT '0',
  `notificationType` tinyint(1) NOT NULL DEFAULT '0',
  `apartment_id` int(11) DEFAULT NULL,
  `type_check` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=327 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (319,'[Thông báo] Đề phòng trộm cắp trong tầng hầm chung cư','Gần đây, các đơn vị của CATP Hà Nội đã liên tiếp phát hiện, bắt giữ nhiều đối tượng trà trộn vào khu vực trông giữ xe trong tầng hầm các chung cư để lấy trộm xe đạp điện.','<p>Cơ quan CSĐT C&ocirc;ng an quận Thanh Xu&acirc;n, H&agrave; Nội đ&atilde; khởi tố bị can, tạm giam đối với Nguyễn Phi Kh&aacute;nh (SN 1994), tr&uacute; tại huyện Diễn Ch&acirc;u, tỉnh Nghệ An về h&agrave;nh vi trộm cắp t&agrave;i sản. Giữa th&aacute;ng 1-2016, Kh&aacute;nh đi xe m&aacute;y điện v&agrave;o tầng hầm B3, Trung t&acirc;m thương mại R.C ở đường &nbsp;Nguyễn Tr&atilde;i, phường Thượng Đ&igrave;nh, quận Thanh Xu&acirc;n với &yacute; định trộm cắp t&agrave;i sản. Ph&aacute;t hiện một chiếc xe m&aacute;y điện nh&atilde;n hiệu Takuda X - Men m&agrave;u xanh t&iacute;m, kh&ocirc;ng kh&oacute;a bảo hiểm chống trộm, Kh&aacute;nh mon men tới gần cậy y&ecirc;n xe t&igrave;m v&eacute; xe của chủ sở hữu để trong cốp. Tưởng đ&atilde; ngon ăn, Kh&aacute;nh dắt xe ra nhưng bị bảo vệ chặn lại v&igrave; ảnh in tr&ecirc;n thẻ xe kh&ocirc;ng giống Kh&aacute;nh. Kh&ocirc;ng chứng minh được nguồn gốc chiếc xe, Kh&aacute;nh bị bảo vệ giữ lại v&agrave; gọi chủ xe l&agrave; anh Trần Thanh Long, ở chung cư R.C xuống đối chứng.&nbsp;<br />\r\n<br />\r\nLực lượng bảo vệ t&ograve;a nh&agrave; R.C sau đ&oacute; đ&atilde; lập bi&ecirc;n bản, giao Kh&aacute;nh c&ugrave;ng tang vật cho CAP Thượng Đ&igrave;nh, quận Thanh Xu&acirc;n xử l&yacute;. Kh&aacute;nh khai đ&atilde; c&oacute; 1 tiền &aacute;n, 1 tiền sự trộm cắp, hiện l&agrave;m nghề cắt t&oacute;c tự do. V&igrave; cần tiền ăn chơi, Kh&aacute;nh đ&atilde; đến tầng hầm chung cư để trộm cắp xe đạp điện. Ngay sau đ&oacute;, lực lượng CSHS - CAQ Thanh Xu&acirc;n đ&atilde; phối hợp với CAP Thượng Đ&igrave;nh mở rộng điều tra, l&agrave;m r&otilde; thợ cắt t&oacute;c n&agrave;y c&ograve;n g&acirc;y ra nhiều vụ trộm xe m&aacute;y điện, xe đạp điện kh&aacute;c tại tầng hầm c&aacute;c chung cư tr&ecirc;n địa b&agrave;n th&agrave;nh phố. Chiếc xe m&aacute;y điện Kh&aacute;nh sử dụng đi đến tầng hầm chung cư R.C cũng l&agrave; một trong những tang vật c&aacute;c vụ trộm do Kh&aacute;nh g&acirc;y ra tại tầng hầm chung cư T.C, ở quận Hai B&agrave; Trưng, H&agrave; Nội.&nbsp;</p>\r\n',0,NULL,0,0,1,0,NULL,'2017-02-28 08:01:37','2017-02-28 08:01:37'),(320,'[Thông báo]  Tăng phí trông giữ xe đạp, xe máy, ô tô','Theo đó, phí trông giữ xe máy 3.000 đồng/lượt ban ngày, 5.000 đồng/lượt ban đêm, 7.000 đồng/lượt cả ngày và đêm và 70.000 đồng/xe theo tháng.','<p>Ng&agrave;y 20/8, UBND th&agrave;nh phố H&agrave; Nội ban h&agrave;nh quyết định số 69/2014/QĐ-UBND về thu ph&iacute; tr&ocirc;ng giữ xe đạp (kể cả xe đạp điện, xe m&aacute;y điện) tr&ecirc;n địa b&agrave;n TP H&agrave; Nội.</p>\r\n\r\n<p>Mức ph&iacute; đối với c&aacute;c phương tiện xe đạp (kể cả xe đạp điện, xe m&aacute;y điện), xe m&aacute;y, quy định thời gian ban ng&agrave;y từ 6h đến 18h, thời gian ban đ&ecirc;m từ sau 18h đến trước 6h s&aacute;ng h&ocirc;m sau.</p>\r\n',0,NULL,0,0,1,0,NULL,'2017-02-28 08:02:48','2017-02-28 08:02:48'),(321,'Dịch vụ trông xe tận nơi','Nhằm tạo điều kiện cho công ty, cửa hàng… của quý khách chỉ chú tâm vào kinh doanh không phải vướng bận khó khăn trong việc sắp xếp chỗ để xe cho khách hàng của mình vào tham quan mua sắm','<p>Dịch vụ tr&ocirc;ng xe tận nơi l&agrave; một trong những dịch vụ giữ xe chuy&ecirc;n nghiệp của ch&uacute;ng t&ocirc;i với đội ngũ nh&acirc;n vi&ecirc;n phục vụ c&oacute; uy t&iacute;nh với th&aacute;i độ phục vụ c&oacute; thể khiến cho kh&aacute;ch h&agrave;ng vừa l&ograve;ng.<br />\r\n+ Giữ xe &ocirc; t&ocirc;, xe m&aacute;y trong khu&ocirc;n vi&ecirc;n b&atilde;i giữ xe.<br />\r\n+ Sắp xếp, ph&acirc;n loại c&aacute;c xe theo l&ocirc; v&agrave; h&agrave;ng kh&aacute;c nhau để dễ kiểm so&aacute;t<br />\r\n+ Thường xuy&ecirc;n tuần tra ngăn chặn những h&agrave;nh vi trộm cắp xe v&agrave; phụ t&ugrave;ng xe</p>\r\n\r\n<p><img src=\"http://www.trongxe.com/wp-content/uploads/2014/10/giu-xe-tan-noi.jpg\" style=\"height:auto; width:100%\" /></p>\r\n',0,NULL,1,0,1,0,NULL,'2017-02-28 08:04:12','2017-02-28 08:04:12'),(322,'[Khảo sát] Xây dưng phòng tập gym cho chung cư','Hỏi đáp ý kiến về chi phí, quyết định xây dựng về phòng tập gym cho chung cư','<p>Quang Trung fitness Club - 162 (s&ocirc;́ cũ 33) Quang Trung, P10, Q G&ograve; Vấp ( liền kề si&ecirc;u thị dienmay.com ) Dt 500m2, chỗ để xe miễn ph&iacute;, dụng cụ hiện đại Lifefitness, SportsArt fitness</p>\r\n\r\n<p><a href=\"https://www.facebook.com/quangtrungfitnessclub/photos/a.1172559579520826.1073741831.640126369430819/1172559172854200/?type=3\"><img src=\"https://scontent.fsgn5-2.fna.fbcdn.net/v/t1.0-0/s480x480/16002936_1172559172854200_7045865061493388428_n.jpg?oh=c743d24887692510ad27bec12ab8dff0&amp;oe=5943C07A\" style=\"height:auto; width:100%\" /></a></p>\r\n',0,NULL,1,1,1,0,NULL,'2017-02-28 08:07:53','2017-02-28 08:07:53'),(323,'Sở QH-KT Hà Nội dừng thông báo chung cư phải có 3 tầng hầm','CafeLand - Sở Quy hoạch - Kiến trúc Hà Nội vừa có Thông báo số 2929/TB-QHKT thay thế Thông báo 1823/TB-QHKT quy định công trình cao tầng phải bố trí tối thiểu 3 tầng hầm để xe và xây dựng nhà vệ sinh công cộng.','<p>heo đ&oacute;, trong thời gian chưa c&oacute; quy định của UBND th&agrave;nh phố, Sở Quy hoạch Kiến tr&uacute;c H&agrave; Nội y&ecirc;u cầu c&aacute;c ph&ograve;ng, ban, đơn vị tiếp tục duy tr&igrave; việc giải quyết hồ sơ, c&ocirc;ng văn theo đề nghị của c&aacute;c c&aacute; nh&acirc;n, tổ chức theo đ&uacute;ng quy hoạch, quy chế được cấp c&oacute; thẩm quyền ph&ecirc; duyệt. Việc ph&ecirc; duyệt sẽ tu&acirc;n thủ quy chuẩn, ti&ecirc;u chuẩn hiện h&agrave;nh, đảm bảo tiến độ theo quy định.</p>\r\n\r\n<p>Trước đ&oacute;, ng&agrave;y 14/4, cơ quan n&agrave;y c&oacute; văn bản th&ocirc;ng b&aacute;o về việc c&aacute;c c&ocirc;ng tr&igrave;nh cao tầng phải c&oacute; 3 tầng hầm để xe. Ng&agrave;y 12/5, UBND th&agrave;nh phố đ&atilde; c&oacute; văn bản hỏa tốc chỉ đạo c&aacute;c sở, ng&agrave;nh chức năng nghi&ecirc;n cứu, đề xuất c&aacute;c biện ph&aacute;p, ch&iacute;nh s&aacute;ch để cụ thể h&oacute;a c&aacute;c nội dung.</p>\r\n',0,NULL,0,0,2,0,NULL,'2017-02-28 08:32:53','2017-02-28 08:32:53'),(324,'Thông báo phân công chuẩn bị HNNCC lần 2','Căn cứ biên bản cuộc họp ban tổ chức hội nghị nhà chung cư lần 2 năm 2016 vào lúc 20 giờ ngày 11 tháng 01 năm 2017.','<p>Ban tổ chức HNNCC lần 2 năm 2016, tr&acirc;n trọng th&ocirc;ng b&aacute;o đến c&aacute;c th&agrave;nh vi&ecirc;n ban tổ chức về việc ph&acirc;n c&ocirc;ng chuẩn bị nội dung v&agrave; tổ chức hội nghị nh&agrave; chung cư lần 2 với tr&aacute;ch nhiệm của từng th&agrave;nh vi&ecirc;n cụ thể như sau:</p>\r\n\r\n<ol>\r\n	<li>Soạn thảo b&aacute;o c&aacute;o hoạt động BQT năm 2016: Giao &Ocirc;ng B&ugrave;i Minh Nghĩa chuẩn bị v&agrave; gửi BTC HNNCC lần 2 trước ng&agrave;y 15/1/2017.</li>\r\n	<li>Soạn thảo b&aacute;o c&aacute;o t&agrave;i ch&iacute;nh BQT năm 2016: Giao B&agrave; Huỳnh Thị Như Ngọc chuẩn bị v&agrave; gửi BTC HNNCC lần 2 trước ng&agrave;y 15/1/2017.</li>\r\n	<li>Soạn thảo quy chế hoạt động BQT: Giao &Ocirc;ng Nguyễn Đức Nhi&ecirc;n chuẩn bị v&agrave; gửi BTC HNNCC lần 2 trước ng&agrave;y 14/1/2017.</li>\r\n	<li>Soạn thảo quy chế thu chi t&agrave;i ch&iacute;nh BQT: Giao &Ocirc;ng Trần Dục Thức chuẩn bị v&agrave; gửi BTC HNNCC lần 2 trước ng&agrave;y 14/1/2017.</li>\r\n	<li>Soạn thảo c&aacute;c biểu mẫu, t&agrave;i liệu cho việc tổ chức hội nghị: Giao &Ocirc;ng L&ecirc; Cảnh H&ugrave;ng chuẩn bị v&agrave; gửi BTC HNNCC lần 2 trước ng&agrave;y 13/1/2017.</li>\r\n	<li>C&ocirc;ng t&aacute;c hậu cần phục vụ hội nghị: Giao &Ocirc;ng Tạ Thanh Vũ phối hợp c&ugrave;ng BQL (Cty MTSS) chuẩn bị v&agrave; b&aacute;o c&aacute;o tiến độ về BTC HNNCC lần 2.</li>\r\n</ol>\r\n\r\n<p>C&aacute;c th&agrave;nh vi&ecirc;n c&ograve;n lại c&ugrave;ng phối hợp theo kế hoạch nh&acirc;n sự đ&atilde; thống nhất trong cuộc họp để ho&agrave;n th&agrave;nh nhiệm vụ được giao.</p>\r\n\r\n<p>Để hội nghị được tổ chức th&agrave;nh c&ocirc;ng, cũng như đảm bảo quyền lợi cho cư d&acirc;n tại chung cư Ph&uacute; Thạnh, k&iacute;nh mong &ocirc;ng/ b&agrave; sắp xếp thời gian thực hiện nhiệm vụ v&agrave; kịp thời th&ocirc;ng b&aacute;o đến BTC HNNCC lần 2 khi cần sự hỗ trợ.</p>\r\n',0,NULL,1,0,2,0,NULL,'2017-02-28 08:33:46','2017-02-28 08:33:46'),(325,' Về giá trị của các văn bản do BQT ban hành','BQT CCPT xin được thông báo đến toàn thể quý cư dân về tính giá trị của các văn bản do BQT ban hành.','<p>Căn cứ điều 25 th&ocirc;ng tư 02/TT-BXD ban h&agrave;nh ng&agrave;y 15/02/2016 th&igrave; tất cả c&aacute;c văn bản do BQT ban h&agrave;nh chỉ c&oacute; gi&aacute; trị khi v&agrave; chỉ khi nội dung đ&atilde; được hơn 50% th&agrave;nh vi&ecirc;n BQT t&aacute;n th&agrave;nh v&agrave; th&ocirc;ng qua trong cuộc họp BQT.</p>\r\n\r\n<p>Trong trường hợp BQT chưa c&oacute; quy chế hoạt động th&igrave; Trưởng ban chỉ l&agrave; người đại diện khi được c&aacute;c th&agrave;nh vi&ecirc;n BQT uỷ quyền v&agrave; c&oacute; quyền biểu quyết trong c&aacute;c cuộc họp c&oacute; tỷ lệ biểu quyết 50% &ndash; 50%, do đ&oacute; Trưởng ban kh&ocirc;ng được ph&eacute;p ban h&agrave;nh bất kỳ quyết định n&agrave;o khi chưa th&ocirc;ng qua cuộc họp BQT c&oacute; hơn 50% th&agrave;nh vi&ecirc;n BQT biểu quyết.</p>\r\n\r\n<p><strong><em>Tr&iacute;ch khoản 1, Điều 25, Th&ocirc;ng tư 02/TT-BXT&nbsp;</em></strong><br />\r\n<em>&ldquo;C&aacute;c quyết định của Ban quản trị nh&agrave; chung cư, cụm nh&agrave; chung cư được th&ocirc;ng qua bằng h&igrave;nh</em><br />\r\n<em>thức biểu quyết hoặc bỏ phiếu theo quy chế hoạt động của Ban quản trị, được lập th&agrave;nh bi&ecirc;n bản,</em><br />\r\n<em>c&oacute; chữ k&yacute; của thư k&yacute; cuộc họp, c&aacute;c th&agrave;nh vi&ecirc;n Ban quản trị dự họp v&agrave; c&oacute; đ&oacute;ng dấu của Ban quản</em><br />\r\n<em>trị (đối với trường hợp c&oacute; con dấu). Trường hợp tỷ lệ biểu quyết t&aacute;n th&agrave;nh đạt 50% số th&agrave;nh vi&ecirc;n</em><br />\r\n<em>Ban quản trị th&igrave; kết quả cuối c&ugrave;ng được x&aacute;c định theo biểu quyết của Trưởng ban hoặc Ph&oacute; ban</em><br />\r\n<em>chủ tr&igrave; cuộc họp (nếu vắng Trưởng ban), trừ trường hợp quy định tại Khoản 2 v&agrave; Khoản 3 Điều</em><br />\r\n<em>n&agrave;y.&rdquo;</em></p>\r\n\r\n<p>Do vậy, BQT CCPT xin được th&ocirc;ng tin đến to&agrave;n thể qu&yacute; cư d&acirc;n về việc &Ocirc;ng B&ugrave;i Minh Nghĩa nh&acirc;n danh trưởng BQT tự &yacute; k&yacute; kết hợp đồng với đối t&aacute;c v&agrave; ban h&agrave;nh nhiều văn bản trong thời gian vừa qua l&agrave; vi phạm điều 25 th&ocirc;ng tư 02/TT-BXD v&agrave; ho&agrave;n to&agrave;n kh&ocirc;ng c&oacute; gi&aacute; trị.</p>\r\n\r\n<p>Ban quản trị chung cư Ph&uacute; Thạnh sẽ kh&ocirc;ng chịu bất kỳ tr&aacute;ch nhiệm n&agrave;o đối với c&aacute;c hợp đồng v&agrave; văn bản do &ocirc;ng B&ugrave;i Minh Nghĩa tự &yacute; ban h&agrave;nh.</p>\r\n',0,NULL,0,0,2,0,NULL,'2017-02-28 08:35:28','2017-02-28 08:35:28'),(326,'Khảo sát điều kiện sống','Khảo sát điều kiện sống của cư dân chung cư','<p>Khảo s&aacute;t điều kiện sống của cư d&acirc;n chung cư&nbsp;Khảo s&aacute;t điều kiện sống của cư d&acirc;n chung cư</p>\r\n',0,NULL,0,1,2,0,NULL,'2017-02-28 08:36:26','2017-02-28 08:36:26');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provider_service_types`
--

DROP TABLE IF EXISTS `provider_service_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provider_service_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `provider_id` int(11) NOT NULL,
  `service_type_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provider_service_types`
--

LOCK TABLES `provider_service_types` WRITE;
/*!40000 ALTER TABLE `provider_service_types` DISABLE KEYS */;
INSERT INTO `provider_service_types` VALUES (86,29,23,'2017-02-20 18:15:15','2017-02-20 18:15:15',NULL),(87,29,22,'2017-02-20 18:15:15','2017-02-20 18:15:15',NULL),(88,29,21,'2017-02-20 18:15:15','2017-02-20 18:15:15',NULL),(89,29,20,'2017-02-20 18:15:15','2017-02-20 18:15:15',NULL),(90,30,20,'2017-02-20 18:15:44','2017-02-20 18:15:44',NULL),(91,30,26,'2017-02-20 18:15:44','2017-02-20 18:15:44',NULL),(92,31,33,'2017-02-20 18:16:12','2017-02-20 18:16:12',NULL),(93,31,34,'2017-02-20 18:16:12','2017-02-20 18:16:12',NULL),(94,32,22,'2017-02-20 18:16:50','2017-02-20 18:16:50',NULL),(95,32,21,'2017-02-20 18:16:50','2017-02-22 01:27:42','2017-02-22 01:27:42'),(96,32,20,'2017-02-20 18:16:50','2017-02-22 01:27:42','2017-02-22 01:27:42'),(97,33,23,'2017-02-20 18:17:06','2017-02-20 18:17:20','2017-02-20 18:17:20'),(98,33,22,'2017-02-20 18:17:06','2017-02-20 18:17:06',NULL),(99,33,21,'2017-02-20 18:17:06','2017-02-20 18:17:06',NULL),(100,33,25,'2017-02-20 18:17:20','2017-02-20 18:17:20',NULL),(101,33,28,'2017-02-20 18:17:20','2017-02-20 18:17:20',NULL),(102,33,23,'2017-02-20 18:18:24','2017-02-20 18:18:24',NULL),(103,32,23,'2017-02-20 18:20:06','2017-02-22 01:27:42','2017-02-22 01:27:42'),(104,34,22,'2017-02-21 16:08:18','2017-02-21 16:08:18',NULL),(105,34,21,'2017-02-21 16:08:18','2017-02-21 16:08:18',NULL),(106,35,37,'2017-02-22 01:16:03','2017-02-22 01:16:03',NULL);
/*!40000 ALTER TABLE `provider_service_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `providers`
--

DROP TABLE IF EXISTS `providers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `providers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `providers`
--

LOCK TABLES `providers` WRITE;
/*!40000 ALTER TABLE `providers` DISABLE KEYS */;
INSERT INTO `providers` VALUES (29,'Toyota',0,'2017-02-20 18:15:15','2017-02-20 18:38:05',NULL),(30,'FPT COMPANY',0,'2017-02-20 18:15:44','2017-02-20 18:15:44',NULL),(31,'Viettel viễn thông quân đội',0,'2017-02-20 18:16:12','2017-02-20 18:16:17',NULL),(32,'FPT Telecom',0,'2017-02-20 18:16:50','2017-02-22 01:27:42',NULL),(33,'Đông Phương',0,'2017-02-20 18:17:06','2017-02-20 18:17:06',NULL),(34,'Công ty VNPT',0,'2017-02-21 16:08:18','2017-02-21 16:08:18',NULL),(35,'LeverFood',0,'2017-02-22 01:16:03','2017-02-22 01:16:03',NULL);
/*!40000 ALTER TABLE `providers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requirement_images`
--

DROP TABLE IF EXISTS `requirement_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requirement_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `requirement_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requirement_images`
--

LOCK TABLES `requirement_images` WRITE;
/*!40000 ALTER TABLE `requirement_images` DISABLE KEYS */;
INSERT INTO `requirement_images` VALUES (2,'images/21484399171.694.jpg',49,'2017-01-14 06:06:11','2017-01-14 06:06:11'),(3,'images/31484399171.7514.jpg',49,'2017-01-14 06:06:11','2017-01-14 06:06:11'),(4,'images/41484399427.7153.jpg',52,'2017-01-14 06:10:27','2017-01-14 06:10:27'),(5,'images/51484399427.7711.jpg',52,'2017-01-14 06:10:27','2017-01-14 06:10:27'),(6,'images/61484399560.2904.jpg',53,'2017-01-14 06:12:40','2017-01-14 06:12:40'),(7,'images/71484399560.76.jpg',53,'2017-01-14 06:12:40','2017-01-14 06:12:40'),(8,'images/81484399791.4874.jpg',56,'2017-01-14 06:16:31','2017-01-14 06:16:31'),(9,'images/91484399791.4981.jpg',56,'2017-01-14 06:16:31','2017-01-14 06:16:31'),(10,'images/101484420087.0042.jpg',57,'2017-01-14 11:54:46','2017-01-14 11:54:47'),(11,'images/111484420087.5891.jpg',57,'2017-01-14 11:54:47','2017-01-14 11:54:47'),(12,'images/121484691925.1281.jpg',58,'2017-01-17 15:25:25','2017-01-17 15:25:25'),(13,'images/131484691925.1883.jpg',58,'2017-01-17 15:25:25','2017-01-17 15:25:25'),(14,'images/141484693118.2014.jpg',59,'2017-01-17 15:45:18','2017-01-17 15:45:18'),(15,'images/151484693118.232.jpg',59,'2017-01-17 15:45:18','2017-01-17 15:45:18'),(16,'images/161484693245.4234.jpg',60,'2017-01-17 15:47:25','2017-01-17 15:47:25'),(17,'images/171484693451.6464.jpg',61,'2017-01-17 15:50:51','2017-01-17 15:50:51'),(18,'images/181484693451.6521.jpg',61,'2017-01-17 15:50:51','2017-01-17 15:50:51'),(19,'images/191484693608.0227.jpg',62,'2017-01-17 15:53:28','2017-01-17 15:53:28'),(20,'images/201484693608.0278.jpg',62,'2017-01-17 15:53:28','2017-01-17 15:53:28'),(21,'images/211484693712.9561.jpg',63,'2017-01-17 15:55:12','2017-01-17 15:55:12'),(22,'images/221487613268.3835.jpg',65,'2017-02-20 17:54:28','2017-02-20 17:54:28'),(23,'images/231487613268.4197.jpg',65,'2017-02-20 17:54:28','2017-02-20 17:54:28'),(24,'images/241487649212.85.jpg',66,'2017-02-21 03:53:32','2017-02-21 03:53:32'),(25,'images/251487649212.86.jpg',66,'2017-02-21 03:53:32','2017-02-21 03:53:32'),(26,'images/261487731557.83.jpg',67,'2017-02-22 02:45:57','2017-02-22 02:45:57'),(27,'images/271487731557.84.jpg',67,'2017-02-22 02:45:57','2017-02-22 02:45:57'),(28,'images/281487731557.84.jpg',67,'2017-02-22 02:45:57','2017-02-22 02:45:57'),(29,'images/291487731557.84.jpg',67,'2017-02-22 02:45:57','2017-02-22 02:45:57'),(30,'images/301487955690.35.jpg',68,'2017-02-24 17:01:30','2017-02-24 17:01:30'),(31,'images/311487978281.13.jpg',69,'2017-02-24 23:18:01','2017-02-24 23:18:01'),(32,'images/321488075416.77.jpg',70,'2017-02-26 02:16:56','2017-02-26 02:16:56'),(33,'images/331488269403.74.jpg',72,'2017-02-28 08:10:03','2017-02-28 08:10:03'),(34,'images/341488269403.75.jpg',72,'2017-02-28 08:10:03','2017-02-28 08:10:03'),(35,'images/351488334731.19.jpg',74,'2017-03-01 02:18:51','2017-03-01 02:18:51'),(36,'images/361488334731.19.jpg',74,'2017-03-01 02:18:51','2017-03-01 02:18:51');
/*!40000 ALTER TABLE `requirement_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requirements`
--

DROP TABLE IF EXISTS `requirements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requirements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `is_repeat_problem` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requirements`
--

LOCK TABLES `requirements` WRITE;
/*!40000 ALTER TABLE `requirements` DISABLE KEYS */;
INSERT INTO `requirements` VALUES (72,'demo',0,0,'demo',1,1,'2017-02-28 08:10:03','2017-02-28 08:10:03'),(73,'xu ly van de an ninh',1,2,'van de an ninh khong dam bao',1,7,'2017-02-28 08:37:50','2017-02-28 08:37:50'),(74,'',0,0,'',0,2,'2017-03-01 02:18:51','2017-03-01 02:18:51');
/*!40000 ALTER TABLE `requirements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `floor_id` int(11) NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (1,'A1-21',2,0,NULL,NULL,NULL),(2,'Đ1-11',3,0,NULL,NULL,NULL),(3,'A1-11',1,0,NULL,NULL,NULL),(4,'Đ1-21',7,0,NULL,NULL,NULL),(5,'Đ1-22',7,0,NULL,NULL,NULL),(6,'A1-12',1,0,NULL,NULL,NULL),(7,'Đ1-23',7,0,NULL,NULL,NULL),(8,'A1-22',2,0,NULL,NULL,NULL),(9,'A1-23',2,0,NULL,NULL,NULL),(10,'A1-24',2,0,NULL,NULL,NULL),(11,'Đ1-12',3,0,NULL,NULL,NULL),(12,'Đ1-13',3,0,NULL,NULL,NULL),(13,'Đ1-14',3,0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_apartments`
--

DROP TABLE IF EXISTS `service_apartments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_apartments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `apartment_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=339 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_apartments`
--

LOCK TABLES `service_apartments` WRITE;
/*!40000 ALTER TABLE `service_apartments` DISABLE KEYS */;
INSERT INTO `service_apartments` VALUES (183,10,4,'2017-02-20 18:34:30','2017-02-20 18:34:30',NULL),(184,10,1,'2017-02-20 18:34:31','2017-02-20 18:34:31',NULL),(241,11,14,'2017-02-21 04:05:05','2017-02-21 04:05:05',NULL),(242,11,15,'2017-02-21 04:05:05','2017-02-21 04:05:05',NULL),(243,11,16,'2017-02-21 04:05:05','2017-02-21 04:05:05',NULL),(244,11,17,'2017-02-21 04:05:05','2017-02-21 04:05:05',NULL),(245,11,9,'2017-02-21 04:05:05','2017-02-21 04:05:05',NULL),(246,11,3,'2017-02-21 04:05:05','2017-02-21 04:05:05',NULL),(247,11,2,'2017-02-21 04:05:05','2017-02-21 04:05:05',NULL),(248,11,1,'2017-02-21 04:05:05','2017-02-21 04:05:05',NULL),(289,12,17,'2017-02-22 01:33:00','2017-02-22 01:33:00',NULL),(290,12,19,'2017-02-22 01:33:00','2017-02-22 01:33:00',NULL),(291,12,7,'2017-02-22 01:33:00','2017-02-22 01:33:00',NULL),(292,12,8,'2017-02-22 01:33:00','2017-02-22 01:33:00',NULL),(293,12,9,'2017-02-22 01:33:00','2017-02-22 01:33:00',NULL),(294,12,4,'2017-02-22 01:33:00','2017-02-22 01:33:00',NULL),(295,12,2,'2017-02-22 01:33:00','2017-02-22 01:33:00',NULL),(296,12,1,'2017-02-22 01:33:00','2017-02-22 01:33:00',NULL),(297,9,13,'2017-02-22 01:37:37','2017-02-22 01:37:37',NULL),(298,9,5,'2017-02-22 01:37:37','2017-02-22 01:37:37',NULL),(299,9,3,'2017-02-22 01:37:37','2017-02-22 01:37:37',NULL),(300,9,4,'2017-02-22 01:37:37','2017-02-22 01:37:37',NULL),(301,9,2,'2017-02-22 01:37:37','2017-02-22 01:37:37',NULL),(302,9,1,'2017-02-22 01:37:37','2017-02-22 01:37:37',NULL),(307,13,14,'2017-02-22 01:41:12','2017-02-22 01:41:12',NULL),(308,13,17,'2017-02-22 01:41:12','2017-02-22 01:41:12',NULL),(309,13,2,'2017-02-22 01:41:12','2017-02-22 01:41:12',NULL),(310,13,1,'2017-02-22 01:41:12','2017-02-22 01:41:12',NULL),(325,14,14,'2017-02-22 01:56:51','2017-02-22 01:56:51',NULL),(326,14,15,'2017-02-22 01:56:51','2017-02-22 01:56:51',NULL),(327,14,16,'2017-02-22 01:56:51','2017-02-22 01:56:51',NULL),(328,14,17,'2017-02-22 01:56:51','2017-02-22 01:56:51',NULL),(329,14,18,'2017-02-22 01:56:51','2017-02-22 01:56:51',NULL),(330,14,19,'2017-02-22 01:56:51','2017-02-22 01:56:51',NULL),(331,14,6,'2017-02-22 01:56:51','2017-02-22 01:56:51',NULL),(332,14,7,'2017-02-22 01:56:51','2017-02-22 01:56:51',NULL),(333,14,8,'2017-02-22 01:56:51','2017-02-22 01:56:51',NULL),(334,14,9,'2017-02-22 01:56:51','2017-02-22 01:56:51',NULL),(335,14,3,'2017-02-22 01:56:51','2017-02-22 01:56:51',NULL),(336,14,4,'2017-02-22 01:56:51','2017-02-22 01:56:51',NULL),(337,14,2,'2017-02-22 01:56:51','2017-02-22 01:56:51',NULL),(338,14,1,'2017-02-22 01:56:51','2017-02-22 01:56:51',NULL);
/*!40000 ALTER TABLE `service_apartments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_calls`
--

DROP TABLE IF EXISTS `service_calls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_calls` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_calls`
--

LOCK TABLES `service_calls` WRITE;
/*!40000 ALTER TABLE `service_calls` DISABLE KEYS */;
INSERT INTO `service_calls` VALUES (16,12,1,'2017-02-21 04:02:33','2017-02-21 04:02:33'),(17,9,1,'2017-02-21 04:02:49','2017-02-21 04:02:49'),(18,12,2,'2017-02-21 04:02:51','2017-02-21 04:02:51'),(19,12,2,'2017-02-21 06:46:34','2017-02-21 06:46:34'),(20,12,1,'2017-02-21 10:50:59','2017-02-21 10:50:59'),(21,13,2,'2017-02-21 16:11:51','2017-02-21 16:11:51'),(22,9,2,'2017-02-21 16:14:23','2017-02-21 16:14:23'),(23,9,2,'2017-02-22 02:35:47','2017-02-22 02:35:47'),(24,12,2,'2017-02-23 06:30:47','2017-02-23 06:30:47'),(25,9,2,'2017-02-24 23:15:02','2017-02-24 23:15:02'),(26,12,7,'2017-02-28 08:40:30','2017-02-28 08:40:30'),(27,12,1,'2017-02-28 20:11:19','2017-02-28 20:11:19'),(28,14,2,'2017-03-01 01:37:13','2017-03-01 01:37:13'),(29,13,2,'2017-03-01 03:41:42','2017-03-01 03:41:42'),(30,9,2,'2017-03-22 03:41:32','2017-03-22 03:41:32');
/*!40000 ALTER TABLE `service_calls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_clicks`
--

DROP TABLE IF EXISTS `service_clicks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_clicks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_clicks`
--

LOCK TABLES `service_clicks` WRITE;
/*!40000 ALTER TABLE `service_clicks` DISABLE KEYS */;
INSERT INTO `service_clicks` VALUES (46,9,1,'2017-02-21 04:02:59','2017-02-21 04:02:59'),(47,11,1,'2017-02-21 04:03:05','2017-02-21 04:03:05'),(48,9,1,'2017-02-21 04:03:11','2017-02-21 04:03:11'),(49,11,1,'2017-02-21 04:03:59','2017-02-21 04:03:59'),(50,10,1,'2017-02-21 04:05:51','2017-02-21 04:05:51'),(51,10,2,'2017-02-21 05:25:12','2017-02-21 05:25:12'),(52,10,2,'2017-02-21 05:25:24','2017-02-21 05:25:24'),(53,9,2,'2017-02-21 06:46:53','2017-02-21 06:46:53'),(54,13,2,'2017-02-21 16:11:48','2017-02-21 16:11:48'),(55,13,2,'2017-02-21 16:11:50','2017-02-21 16:11:50'),(56,13,2,'2017-02-21 16:11:50','2017-02-21 16:11:50'),(57,9,2,'2017-02-21 16:12:00','2017-02-21 16:12:00'),(58,9,2,'2017-02-21 16:12:03','2017-02-21 16:12:03'),(59,11,2,'2017-02-21 16:12:08','2017-02-21 16:12:08'),(60,13,1,'2017-02-21 16:17:28','2017-02-21 16:17:28'),(61,14,1,'2017-02-22 01:35:26','2017-02-22 01:35:26'),(62,12,7,'2017-02-22 01:47:18','2017-02-22 01:47:18'),(63,12,7,'2017-02-22 01:49:41','2017-02-22 01:49:41'),(64,13,1,'2017-02-22 02:55:31','2017-02-22 02:55:31'),(65,9,2,'2017-02-23 06:30:56','2017-02-23 06:30:56'),(66,12,2,'2017-02-25 04:40:01','2017-02-25 04:40:01'),(67,13,1,'2017-02-28 02:53:34','2017-02-28 02:53:34'),(68,14,1,'2017-02-28 19:23:16','2017-02-28 19:23:16'),(69,14,1,'2017-02-28 19:23:18','2017-02-28 19:23:18'),(70,14,1,'2017-02-28 19:23:18','2017-02-28 19:23:18'),(71,12,1,'2017-02-28 20:04:19','2017-02-28 20:04:19'),(72,12,2,'2017-03-01 02:27:27','2017-03-01 02:27:27'),(73,12,2,'2017-03-01 02:28:10','2017-03-01 02:28:10'),(74,14,2,'2017-03-01 02:32:09','2017-03-01 02:32:09'),(75,13,2,'2017-03-01 03:41:39','2017-03-01 03:41:39'),(76,12,1,'2017-03-06 09:30:49','2017-03-06 09:30:49'),(77,13,2,'2017-03-22 07:12:31','2017-03-22 07:12:31'),(78,14,2,'2017-03-22 07:13:18','2017-03-22 07:13:18'),(79,14,2,'2017-03-22 07:13:22','2017-03-22 07:13:22'),(80,9,2,'2017-03-22 07:16:51','2017-03-22 07:16:51');
/*!40000 ALTER TABLE `service_clicks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_re_calls`
--

DROP TABLE IF EXISTS `service_re_calls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_re_calls` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `note` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_re_calls`
--

LOCK TABLES `service_re_calls` WRITE;
/*!40000 ALTER TABLE `service_re_calls` DISABLE KEYS */;
/*!40000 ALTER TABLE `service_re_calls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_types`
--

DROP TABLE IF EXISTS `service_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_types`
--

LOCK TABLES `service_types` WRITE;
/*!40000 ALTER TABLE `service_types` DISABLE KEYS */;
INSERT INTO `service_types` VALUES (20,'Du lịch','images/201487725620.23.jpg',0,'2017-02-20 18:06:25','2017-02-22 01:07:00',NULL),(21,'Dịch vụ viễn thông','images/1487614054.0256.jpg',1,'2017-02-20 18:07:33','2017-02-22 01:05:53',NULL),(22,'Internet','images/1487614231.5645.jpg',0,'2017-02-20 18:10:31','2017-02-22 01:05:38',NULL),(23,'Nội ngoại thất','images/231487726040.75.jpg',0,'2017-02-20 18:11:11','2017-02-22 01:14:00',NULL),(24,'Type 01','images/1487614312.6235.jpg',1,'2017-02-20 18:11:52','2017-02-20 18:24:25',NULL),(25,'Type02','images/1487614329.5312.jpg',1,'2017-02-20 18:12:09','2017-02-20 22:01:20',NULL),(26,'Type03','images/1487614339.093.jpg',1,'2017-02-20 18:12:19','2017-02-22 01:07:32',NULL),(27,'Type04','images/1487614348.8523.jpg',1,'2017-02-20 18:12:28','2017-02-20 22:01:13',NULL),(28,'Type05','images/1487614357.2915.jpg',1,'2017-02-20 18:12:37','2017-02-20 18:24:34',NULL),(29,'Type06','images/1487614370.662.jpg',1,'2017-02-20 18:12:50','2017-02-20 22:01:24',NULL),(30,'Type07','images/1487614381.9543.jpg',1,'2017-02-20 18:13:01','2017-02-20 18:24:39',NULL),(31,'Type08','images/1487614392.3719.jpg',1,'2017-02-20 18:13:12','2017-02-20 18:24:41',NULL),(32,'Type09','images/1487614403.8792.jpg',1,'2017-02-20 18:13:23','2017-02-20 18:24:43',NULL),(33,'Type10','images/1487614413.9636.jpg',1,'2017-02-20 18:13:33','2017-02-20 18:24:45',NULL),(34,'Type11','images/1487614422.1327.jpg',1,'2017-02-20 18:13:42','2017-02-20 18:24:47',NULL),(35,'Type12','images/1487614436.749.jpg',1,'2017-02-20 18:13:56','2017-02-20 18:24:49',NULL),(36,'type14','images/1487614454.3503.jpg',1,'2017-02-20 18:14:14','2017-02-20 18:24:51',NULL),(37,'Thực phẩm sạch','images/1487726132.27.jpg',0,'2017-02-22 01:15:32','2017-02-22 01:15:32',NULL),(38,'ssssssss','images/1487726299.33.jpg',1,'2017-02-22 01:18:19','2017-02-22 01:19:39',NULL);
/*!40000 ALTER TABLE `service_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `content` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `re_call` tinyint(1) NOT NULL DEFAULT '1',
  `provider_service_type_id` int(11) NOT NULL,
  `start_at` date DEFAULT NULL,
  `end_at` date DEFAULT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (9,'Gói 40Mps khuyến mãi tặng FSHARE, IP tĩnh, cước, WIFI','images/1487615008.5852.jpg','https://www.facebook.com/','0914991139','Giảm cước liên tục trong 24 tháng.\r\nMiễn phí 1 IP tĩnh 24 tháng.\r\nMiễn phí Account VIP FShare 6 tháng – 12 tháng.\r\nThủ tục đơn giản – lắp đặt nhanh 24h.',1,94,'2017-01-20','2017-02-22',0,'2017-02-20 18:23:28','2017-02-22 01:37:37',NULL),(10,'Bán thiết bị viễn thông apato','images/1487615567.3173.jpg','http://google.com.vn','','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',1,88,'2017-02-14','2017-06-23',0,'2017-02-20 18:32:46','2017-02-20 18:34:30',NULL),(11,'Viettel internet','images/1487615750.558.jpg','http://google.com.vn','0990777777','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).',0,87,'2018-01-21','2016-11-22',1,'2017-02-20 18:35:50','2017-02-22 01:41:48',NULL),(12,'Bộ nội thất 20 triệu Ehome 54m2','images/121487727180.06.jpg','http://hacker.com','01929e1311','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).',1,102,'2017-02-07','2017-02-22',0,'2017-02-20 18:38:50','2017-02-22 01:33:00',NULL),(13,'Gói 30Mps VNPT tặng 3 tháng cước, WIFI chỉ 150k/tháng','images/131487727672.77.jpg','http://www.vnpt.com.vn','0983992435','Cáp Quang VNPT siêu tốc 12M chỉ còn 150.000 đồng/tháng\r\nTặng thêm từ 1->3 tháng cước sử dụng.\r\nTruyền hình MyTV hơn 150 kênh đặc sắc chỉ còn 40.5K/tháng\r\nMiễn 100% phí lắp internet và truyền hình VNPT\r\nTrang bị miễn phí Modem WiFi và Set Top Box\r\nLắp ngay trong ngày hoặc theo giờ hẹn của khách hàng\r\nCó chính sách riêng cho khách hàng có thẻ Sài Gòn Coop Mart, Sinh viên…',1,104,'2017-02-21','2017-02-23',0,'2017-02-21 16:10:55','2017-02-22 01:41:12',NULL),(14,'LEVERFOOD','images/1487726804.01.jpg','https://www.leverfood.com','0901660002','Sản phẩm chủ đạo là thực phẩm tươi sống như thịt lợn sinh học thảo dược, thịt gà, thịt bò, rau củ quả, trứng gia cầm, gạo và thực phẩm khô…Tất cả được thực hiện theo quy trình khép kín từ khâu chọn nguyên liệu đầu vào, giống vật nuôi, thức ăn, cơ sở vật chất đến khâu giến mổ, chế biến dưới sự tâm giám sát của các cơ quan ban ngành, đảm bảo thực phẩm luon tươi ngon và có giấy kiểm định nguồn gốc trước khi giao hàng.\r\n Khách hàng của An Việt bao gồm trên 100 trường học, các nhà hàng khách sạn, các đại lý cửa hàng cung cấp thực phẩm sạch tại Hà Nội, các bà nội trợ, những nhóm khách hàng là cán bộ các cơ quan ban ngành…',1,106,'2017-02-22','2017-02-28',0,'2017-02-22 01:26:44','2017-02-22 01:56:51',NULL);
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `apartment_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'[{\"id\":0,\"content\":\"Báo sự cố\"},{\"id\":1,\"content\":\"Đóng góp ý kiến\"}]','[{\"id\":0,\"content\":\"Thang Máy\"},{\"id\":1,\"content\":\"Hồ Bơi\"},{\"id\":2,\"content\":\"Security\"},{\"id\":3,\"content\":\"Điện Nước\"}]',1,'2016-11-10 17:00:00','2016-11-10 17:00:00'),(2,'[{\"id\":0,\"content\":\"Báo sự cố\"},{\"id\":1,\"content\":\"Đóng góp ý kiến\"},{\"id\":2,\"content\":\"Hợp tác\"}]','[{\"id\":0,\"content\":\"Thang Máy\"},{\"id\":1,\"content\":\"Hồ Bơi\"},{\"id\":2,\"content\":\"Security\"},{\"id\":3,\"content\":\"Điện Nước\"},{\"id\":4,\"content\":\"Tạp Hóa\"}]',2,'2016-11-10 17:00:00','2016-11-10 17:00:00');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `survey_options`
--

DROP TABLE IF EXISTS `survey_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `survey_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `notification_id` int(11) NOT NULL,
  `content` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `is_other` tinyint(1) NOT NULL DEFAULT '0',
  `color` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_options`
--

LOCK TABLES `survey_options` WRITE;
/*!40000 ALTER TABLE `survey_options` DISABLE KEYS */;
INSERT INTO `survey_options` VALUES (5,74,'Coca cola',0,'#a34475','2017-01-09 07:47:35','2017-01-09 07:47:35'),(6,74,'Coffee',0,'#2f7495','2017-01-09 07:47:35','2017-01-09 07:47:35'),(7,74,'Ca Cao',0,'#12b990','2017-01-09 07:47:35','2017-01-09 07:47:35'),(8,74,'Ý Kiến Khác',1,'#8700b3','2017-01-09 07:47:35','2017-01-09 07:47:35'),(9,75,'Tuy Hoa',0,'#1955af','2017-01-09 07:50:58','2017-01-09 07:50:58'),(10,75,'Sai Gon',0,'#d2e303','2017-01-09 07:50:58','2017-01-09 07:50:58'),(11,75,'Vung Tau',0,'#593400','2017-01-09 07:50:58','2017-01-09 07:50:58'),(12,75,'Vinh Long',0,'#5d3a65','2017-01-09 07:50:58','2017-01-09 07:50:58'),(13,75,'Ý Kiến Khác',1,'#5862c6','2017-01-09 07:50:58','2017-01-09 07:50:58'),(14,76,'Viet Nam',0,'#de067f','2017-01-09 07:53:43','2017-01-09 07:53:43'),(15,76,'Han Quoc',0,'#832369','2017-01-09 07:53:43','2017-01-09 07:53:43'),(16,76,'Mi',0,'#b9c957','2017-01-09 07:53:43','2017-01-09 07:53:43'),(17,76,'Nhat Ban',0,'#267bd0','2017-01-09 07:53:43','2017-01-09 07:53:43'),(18,76,'Ý Kiến Khác',1,'#fd3e69','2017-01-09 07:53:43','2017-01-09 07:53:43'),(19,79,'a',0,'#f0c3ef','2017-01-15 09:33:36','2017-01-15 09:33:36'),(20,79,'s',0,'#739e70','2017-01-15 09:33:36','2017-01-15 09:33:36'),(21,79,'c',0,'#b415a5','2017-01-15 09:33:36','2017-01-15 09:33:36'),(22,79,'Ý Kiến Khác',1,'#5c35ed','2017-01-15 09:33:36','2017-01-15 09:33:36'),(23,80,'A',0,'#21375a','2017-01-15 09:35:10','2017-01-15 09:35:10'),(24,80,'b',0,'#1adb70','2017-01-15 09:35:10','2017-01-15 09:35:10'),(25,80,'c',0,'#efc0c3','2017-01-15 09:35:10','2017-01-15 09:35:10'),(26,80,'Ý Kiến Khác',1,'#06dd34','2017-01-15 09:35:10','2017-01-15 09:35:10'),(27,83,'a',0,'#81feb4','2017-01-15 10:05:45','2017-01-15 10:05:45'),(28,83,'c',0,'#7ebd63','2017-01-15 10:05:45','2017-01-15 10:05:45'),(29,83,'v',0,'#ea38c6','2017-01-15 10:05:45','2017-01-15 10:05:45'),(30,83,'Ý Kiến Khác',1,'#727a74','2017-01-15 10:05:45','2017-01-15 10:05:45'),(31,84,'a',0,'#083ffc','2017-01-15 10:06:17','2017-01-15 10:06:17'),(32,84,'c',0,'#35c64e','2017-01-15 10:06:17','2017-01-15 10:06:17'),(33,84,'d',0,'#2025c0','2017-01-15 10:06:17','2017-01-15 10:06:17'),(34,84,'Ý Kiến Khác',1,'#acdf02','2017-01-15 10:06:17','2017-01-15 10:06:17'),(35,85,'a',0,'#f82ea1','2017-01-15 10:08:20','2017-01-15 10:08:20'),(36,85,'c',0,'#92b48e','2017-01-15 10:08:21','2017-01-15 10:08:21'),(37,85,'d',0,'#022b49','2017-01-15 10:08:21','2017-01-15 10:08:21'),(38,85,'Ý Kiến Khác',1,'#6570b1','2017-01-15 10:08:21','2017-01-15 10:08:21'),(39,91,'a',0,'#767a84','2017-01-17 03:49:04','2017-01-17 03:49:04'),(40,91,'c',0,'#a8c17d','2017-01-17 03:49:04','2017-01-17 03:49:04'),(41,91,'d',0,'#de3fcd','2017-01-17 03:49:04','2017-01-17 03:49:04'),(42,91,'Ý Kiến Khác',1,'#0afc58','2017-01-17 03:49:04','2017-01-17 03:49:04'),(43,96,'a',0,'#71987a','2017-01-17 03:51:08','2017-01-17 03:51:08'),(44,96,'c',0,'#08ecb3','2017-01-17 03:51:08','2017-01-17 03:51:08'),(45,96,'d',0,'#85a01f','2017-01-17 03:51:08','2017-01-17 03:51:08'),(46,96,'Ý Kiến Khác',1,'#95c33d','2017-01-17 03:51:08','2017-01-17 03:51:08'),(47,97,'a',0,'#f6636c','2017-01-17 03:51:33','2017-01-17 03:51:33'),(48,97,'c',0,'#ace16d','2017-01-17 03:51:33','2017-01-17 03:51:33'),(49,97,'d',0,'#c22a22','2017-01-17 03:51:33','2017-01-17 03:51:33'),(50,97,'Ý Kiến Khác',1,'#61e14d','2017-01-17 03:51:33','2017-01-17 03:51:33'),(51,98,'a',0,'#57e6dd','2017-01-17 03:51:57','2017-01-17 03:51:57'),(52,98,'d',0,'#bfbc90','2017-01-17 03:51:57','2017-01-17 03:51:57'),(53,98,'d',0,'#a70848','2017-01-17 03:51:57','2017-01-17 03:51:57'),(54,98,'Ý Kiến Khác',1,'#80d1d6','2017-01-17 03:51:57','2017-01-17 03:51:57'),(55,135,'asd',0,'#a5cba3','2017-01-17 05:44:24','2017-01-17 05:44:24'),(56,135,'asd',0,'#08a2f6','2017-01-17 05:44:24','2017-01-17 05:44:24'),(57,135,'Ý Kiến Khác',1,'#3bcbee','2017-01-17 05:44:24','2017-01-17 05:44:24'),(58,136,'a',0,'#78c7a3','2017-01-17 05:46:24','2017-01-17 05:46:24'),(59,136,'c',0,'#7bce19','2017-01-17 05:46:24','2017-01-17 05:46:24'),(60,136,'d',0,'#98e047','2017-01-17 05:46:24','2017-01-17 05:46:24'),(61,136,'Ý Kiến Khác',1,'#91e5b0','2017-01-17 05:46:24','2017-01-17 05:46:24'),(62,137,'a',0,'#187a37','2017-01-17 05:47:16','2017-01-17 05:47:16'),(63,137,'d',0,'#361c42','2017-01-17 05:47:16','2017-01-17 05:47:16'),(64,137,'e',0,'#f7a391','2017-01-17 05:47:16','2017-01-17 05:47:16'),(65,137,'Ý Kiến Khác',1,'#4b4cdb','2017-01-17 05:47:16','2017-01-17 05:47:16'),(66,140,'a',0,'#eeb616','2017-01-17 05:48:48','2017-01-17 05:48:48'),(67,140,'d',0,'#22a9cf','2017-01-17 05:48:48','2017-01-17 05:48:48'),(68,140,'e',0,'#2944ee','2017-01-17 05:48:48','2017-01-17 05:48:48'),(69,140,'Ý Kiến Khác',1,'#4d2e1e','2017-01-17 05:48:48','2017-01-17 05:48:48'),(70,143,'a',0,'#3405d0','2017-01-17 05:49:52','2017-01-17 05:49:52'),(71,143,'d',0,'#ff8c75','2017-01-17 05:49:52','2017-01-17 05:49:52'),(72,143,'e',0,'#68982d','2017-01-17 05:49:52','2017-01-17 05:49:52'),(73,143,'Ý Kiến Khác',1,'#19a0bc','2017-01-17 05:49:52','2017-01-17 05:49:52'),(74,160,'a wadawd',0,'#4e6a4c','2017-01-17 08:37:24','2017-01-17 08:37:24'),(75,160,'aw dawd',0,'#af591c','2017-01-17 08:37:24','2017-01-17 08:37:24'),(76,160,'aw daw dawd',0,'#d308d2','2017-01-17 08:37:24','2017-01-17 08:37:24'),(77,160,'Ý Kiến Khác',1,'#95faf0','2017-01-17 08:37:24','2017-01-17 08:37:24'),(78,161,'asdsa',0,'#e2799a','2017-01-17 08:38:12','2017-01-17 08:38:12'),(79,161,'asd as',0,'#7001ec','2017-01-17 08:38:12','2017-01-17 08:38:12'),(80,161,'as das',0,'#164072','2017-01-17 08:38:12','2017-01-17 08:38:12'),(81,161,'Ý Kiến Khác',1,'#be3b87','2017-01-17 08:38:12','2017-01-17 08:38:12'),(82,162,'24',0,'#cb7cf0','2017-01-17 08:38:40','2017-01-17 08:38:40'),(83,162,'asd',0,'#f88068','2017-01-17 08:38:40','2017-01-17 08:38:40'),(84,162,'sdfsd',0,'#fb919c','2017-01-17 08:38:40','2017-01-17 08:38:40'),(85,162,'Ý Kiến Khác',1,'#008ffe','2017-01-17 08:38:40','2017-01-17 08:38:40'),(86,179,'1',0,'#f782d0','2017-01-17 15:42:48','2017-01-17 15:42:48'),(87,179,'2',0,'#ce93c2','2017-01-17 15:42:48','2017-01-17 15:42:48'),(88,179,'3',0,'#6680a5','2017-01-17 15:42:48','2017-01-17 15:42:48'),(89,179,'Ý Kiến Khác',1,'#25f697','2017-01-17 15:42:48','2017-01-17 15:42:48'),(90,180,'aaa',0,'#b38b9e','2017-01-17 15:43:38','2017-01-17 15:43:38'),(91,180,'ccc',0,'#55481a','2017-01-17 15:43:38','2017-01-17 15:43:38'),(92,180,'ddd',0,'#a45d20','2017-01-17 15:43:38','2017-01-17 15:43:38'),(93,181,'a',0,'#f1e686','2017-01-17 15:44:17','2017-01-17 15:44:17'),(94,181,'c',0,'#153fd9','2017-01-17 15:44:17','2017-01-17 15:44:17'),(95,181,'d',0,'#3fe823','2017-01-17 15:44:17','2017-01-17 15:44:17'),(96,182,'a',0,'#aaa4d8','2017-01-17 16:17:49','2017-01-17 16:17:49'),(97,182,'s',0,'#16b327','2017-01-17 16:17:49','2017-01-17 16:17:49'),(98,182,'d',0,'#5ae90a','2017-01-17 16:17:49','2017-01-17 16:17:49'),(99,182,'Ý Kiến Khác',1,'#1a8878','2017-01-17 16:17:49','2017-01-17 16:17:49'),(100,188,'a',0,'#fb4cba','2017-01-21 02:17:15','2017-01-21 02:17:15'),(101,188,'sd',0,'#dec70f','2017-01-21 02:17:15','2017-01-21 02:17:15'),(102,188,'sdsd',0,'#1f1f86','2017-01-21 02:17:15','2017-01-21 02:17:15'),(103,188,'asdsad',0,'#7b190a','2017-01-21 02:17:15','2017-01-21 02:17:15'),(104,188,'Ý Kiến Khác',1,'#ae1c26','2017-01-21 02:17:15','2017-01-21 02:17:15'),(105,189,'Ý Kiến Khác',1,'#e4f17c','2017-01-21 02:24:52','2017-01-21 02:24:52'),(106,190,'a',0,'#899eb6','2017-01-21 19:57:46','2017-01-21 19:57:46'),(107,190,'c',0,'#4c7aba','2017-01-21 19:57:46','2017-01-21 19:57:46'),(108,190,'d',0,'#6bc3b3','2017-01-21 19:57:46','2017-01-21 19:57:46'),(109,190,'Ý Kiến Khác',1,'#458165','2017-01-21 19:57:46','2017-01-21 19:57:46'),(110,191,'A',0,'#40a9be','2017-01-23 08:59:30','2017-01-23 08:59:30'),(111,191,'C',0,'#beefb3','2017-01-23 08:59:30','2017-01-23 08:59:30'),(112,191,'D',0,'#763e61','2017-01-23 08:59:30','2017-01-23 08:59:30'),(113,191,'Ý Kiến Khác',1,'#41b35b','2017-01-23 08:59:30','2017-01-23 08:59:30'),(114,192,'aa',0,'#e7a652','2017-01-23 09:14:25','2017-01-23 09:14:25'),(115,192,'ccc',0,'#1af1b7','2017-01-23 09:14:25','2017-01-23 09:14:25'),(116,192,'dd',0,'#1c4b90','2017-01-23 09:14:25','2017-01-23 09:14:25'),(117,192,'Ý Kiến Khác',1,'#2507e4','2017-01-23 09:14:25','2017-01-23 09:14:25'),(118,193,'a',0,'#d643db','2017-02-09 13:17:50','2017-02-09 13:17:50'),(119,193,'c',0,'#2e3a8f','2017-02-09 13:17:50','2017-02-09 13:17:50'),(120,193,'d',0,'#2fa1fb','2017-02-09 13:17:50','2017-02-09 13:17:50'),(121,193,'Ý Kiến Khác',1,'#d6ca60','2017-02-09 13:17:50','2017-02-09 13:17:50'),(122,312,'aa',0,'#086b3a','2017-02-24 17:03:08','2017-02-24 17:03:08'),(123,312,'dd',0,'#b3cf52','2017-02-24 17:03:08','2017-02-24 17:03:08'),(124,312,'cc',0,'#f3b2e8','2017-02-24 17:03:08','2017-02-24 17:03:08'),(125,312,'Ý Kiến Khác',1,'#eb1f93','2017-02-24 17:03:08','2017-02-24 17:03:08'),(126,317,'toi',0,'#24d8a6','2017-02-27 10:29:39','2017-02-27 10:29:39'),(127,317,'ban',0,'#563acc','2017-02-27 10:29:39','2017-02-27 10:29:39'),(128,322,'200 000/ tháng',0,'#21228d','2017-02-28 08:07:53','2017-02-28 08:07:53'),(129,322,'250 000 / tháng',0,'#4d7423','2017-02-28 08:07:53','2017-02-28 08:07:53'),(130,322,'300 000 / tháng',0,'#2b01eb','2017-02-28 08:07:53','2017-02-28 08:07:53'),(131,322,'Ý Kiến Khác',1,'#a1b73f','2017-02-28 08:07:53','2017-02-28 08:07:53'),(132,326,'Tốt',0,'#bb7481','2017-02-28 08:36:26','2017-02-28 08:36:26'),(133,326,'Rất tốt',0,'#0bb735','2017-02-28 08:36:26','2017-02-28 08:36:26'),(134,326,'Cũng Tạm',0,'#d5ab63','2017-02-28 08:36:26','2017-02-28 08:36:26'),(135,326,'Ý Kiến Khác',1,'#f7ccbc','2017-02-28 08:36:26','2017-02-28 08:36:26'),(136,369,'a',0,'#ca1e1d','2017-03-01 05:43:19','2017-03-01 05:43:19'),(137,369,'s',0,'#1662fa','2017-03-01 05:43:19','2017-03-01 05:43:19'),(138,369,'d',0,'#3a8ddc','2017-03-01 05:43:19','2017-03-01 05:43:19'),(139,369,'Ý Kiến Khác',1,'#6a168c','2017-03-01 05:43:19','2017-03-01 05:43:19'),(140,370,'a',0,'#a91a87','2017-03-01 05:43:33','2017-03-01 05:43:33'),(141,370,'d',0,'#66107c','2017-03-01 05:43:33','2017-03-01 05:43:33'),(142,370,'e',0,'#6c5ac1','2017-03-01 05:43:33','2017-03-01 05:43:33');
/*!40000 ALTER TABLE `survey_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_surveys`
--

DROP TABLE IF EXISTS `user_surveys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_surveys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `survey_options_id` int(11) NOT NULL,
  `other_content` varchar(500) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Empty',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1291 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_surveys`
--

LOCK TABLES `user_surveys` WRITE;
/*!40000 ALTER TABLE `user_surveys` DISABLE KEYS */;
INSERT INTO `user_surveys` VALUES (750,1,41,'Empty','2017-01-17 03:49:13','2017-01-17 03:49:13'),(751,1,53,'Empty','2017-01-17 03:52:03','2017-01-17 03:52:03'),(752,1,56,'Empty','2017-01-17 05:44:32','2017-01-17 05:44:32'),(753,1,63,'Empty','2017-01-17 05:47:31','2017-01-17 05:47:31'),(754,1,64,'Empty','2017-01-17 05:47:31','2017-01-17 05:47:31'),(755,1,67,'Empty','2017-01-17 05:48:56','2017-01-17 05:48:56'),(756,1,70,'Empty','2017-01-17 05:50:00','2017-01-17 05:50:00'),(757,1,71,'Empty','2017-01-17 05:50:00','2017-01-17 05:50:00'),(758,1,73,'','2017-01-17 05:50:00','2017-01-17 05:50:00'),(778,2,91,'Empty','2017-01-17 15:43:53','2017-01-17 15:43:53'),(780,2,93,'Empty','2017-01-17 15:44:48','2017-01-17 15:44:48'),(781,2,94,'Empty','2017-01-17 15:44:48','2017-01-17 15:44:48'),(782,2,95,'Empty','2017-01-17 15:44:48','2017-01-17 15:44:48'),(783,2,86,'Empty','2017-01-17 15:53:51','2017-01-17 15:53:51'),(795,7,14,'Empty','2017-01-17 16:15:30','2017-01-17 16:15:30'),(797,7,12,'Empty','2017-01-17 16:15:40','2017-01-17 16:15:40'),(800,9,87,'Empty','2017-01-17 16:16:56','2017-01-17 16:16:56'),(801,9,88,'Empty','2017-01-17 16:16:56','2017-01-17 16:16:56'),(803,9,96,'Empty','2017-01-17 16:18:05','2017-01-17 16:18:05'),(805,8,97,'Empty','2017-01-17 16:20:07','2017-01-17 16:20:07'),(806,8,93,'Empty','2017-01-17 16:20:15','2017-01-17 16:20:15'),(807,8,94,'Empty','2017-01-17 16:20:15','2017-01-17 16:20:15'),(810,2,98,'Empty','2017-01-17 16:21:08','2017-01-17 16:21:08'),(830,1,101,'Empty','2017-01-21 02:18:24','2017-01-21 02:18:24'),(831,1,105,'jckxnx\nc\n','2017-01-21 02:25:15','2017-01-21 02:25:15'),(937,3,117,'djdnx\ncmcmc','2017-01-23 09:16:45','2017-01-23 09:16:45'),(955,3,7,'Empty','2017-01-23 10:14:48','2017-01-23 10:14:48'),(956,3,8,'ddkd\ndmdmxmc\ndmxmxmc\nxmxmxkc','2017-01-23 10:14:48','2017-01-23 10:14:48'),(982,3,112,'Empty','2017-01-23 10:41:23','2017-01-23 10:41:23'),(990,3,11,'Empty','2017-01-25 21:45:02','2017-01-25 21:45:02'),(1001,3,14,'Empty','2017-01-25 21:57:16','2017-01-25 21:57:16'),(1002,3,15,'Empty','2017-01-25 21:57:16','2017-01-25 21:57:16'),(1121,2,6,'Empty','2017-02-21 04:03:46','2017-02-21 04:03:46'),(1122,2,7,'Empty','2017-02-21 04:03:46','2017-02-21 04:03:46'),(1136,1,110,'Empty','2017-02-22 03:02:12','2017-02-22 03:02:12'),(1137,1,111,'Empty','2017-02-22 03:02:12','2017-02-22 03:02:12'),(1153,1,116,'Empty','2017-02-22 10:10:26','2017-02-22 10:10:26'),(1161,2,111,'Empty','2017-02-24 23:17:07','2017-02-24 23:17:07'),(1162,2,112,'Empty','2017-02-24 23:17:07','2017-02-24 23:17:07'),(1163,1,14,'Empty','2017-02-25 04:17:38','2017-02-25 04:17:38'),(1164,1,15,'Empty','2017-02-25 04:17:38','2017-02-25 04:17:38'),(1165,1,16,'Empty','2017-02-25 04:17:38','2017-02-25 04:17:38'),(1166,2,119,'Empty','2017-02-26 02:17:07','2017-02-26 02:17:07'),(1167,1,121,'fjjf xnxnxnx cncncncnc','2017-02-27 08:07:07','2017-02-27 08:07:07'),(1168,2,126,'Empty','2017-02-27 10:30:55','2017-02-27 10:30:55'),(1169,2,14,'Empty','2017-02-27 10:32:19','2017-02-27 10:32:19'),(1170,1,11,'Empty','2017-02-28 02:51:22','2017-02-28 02:51:22'),(1173,1,7,'Empty','2017-02-28 07:11:38','2017-02-28 07:11:38'),(1177,7,132,'Empty','2017-02-28 08:37:03','2017-02-28 08:37:03'),(1178,7,134,'Empty','2017-02-28 08:37:03','2017-02-28 08:37:03'),(1286,1,128,'Empty','2017-03-06 09:56:44','2017-03-06 09:56:44'),(1287,1,129,'Empty','2017-03-06 09:56:44','2017-03-06 09:56:44'),(1288,1,130,'Empty','2017-03-06 09:56:44','2017-03-06 09:56:44'),(1289,2,128,'Empty','2017-03-22 09:14:14','2017-03-22 09:14:14'),(1290,2,129,'Empty','2017-03-22 09:14:14','2017-03-22 09:14:14');
/*!40000 ALTER TABLE `user_surveys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `api_token` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `room_id` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `gender` int(11) NOT NULL DEFAULT '0',
  `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `id_card` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `magnetic_card_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `married` tinyint(1) NOT NULL,
  `population` int(11) NOT NULL,
  `family_register_status` tinyint(1) NOT NULL,
  `start_at` timestamp NULL DEFAULT NULL,
  `note` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `locked` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_api_token_unique` (`api_token`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Nguyen Thanh','Đa','user01','quocts','$2y$10$blp37cCx9BfmJ51KgD2Fgu/FQF30N/zpQfyGd2GFt7FxMID2wFj/W','123',1,'123123','2016-11-10 17:00:00',NULL,NULL,0,'','','','2017-05-22 14:05:59',0,0,0,NULL,'',0),(2,'Đồng Vinh','A','user02','nva@gmail.com','$2y$10$blp37cCx9BfmJ51KgD2Fgu/FQF30N/zpQfyGd2GFt7FxMID2wFj/W','456',1,'123123','2016-11-10 17:00:00','2017-05-17 14:31:27',NULL,2,'0908144144','012345678','123456','1991-05-08 00:00:00',0,2,0,'2017-02-17 00:00:00','Ghi chú',0),(3,'Nguyen Trung','Ha','user03','tvh@gmail.com','$2y$10$blp37cCx9BfmJ51KgD2Fgu/FQF30N/zpQfyGd2GFt7FxMID2wFj/W','555',1,'123123','2016-11-10 17:00:00',NULL,NULL,0,'','','','2017-05-22 14:05:59',0,0,0,NULL,'',0),(7,'Nguyen Van Ti','Nguyen B','user04','nvt@gmail.com','$2y$10$blp37cCx9BfmJ51KgD2Fgu/FQF30N/zpQfyGd2GFt7FxMID2wFj/W','5553',2,'123123','2016-11-10 17:00:00',NULL,NULL,0,'','','','2017-05-22 14:05:59',0,0,0,NULL,'',0),(8,'Le Van Thy','Nguyen B','user05','user05@gmail.com','$2y$10$blp37cCx9BfmJ51KgD2Fgu/FQF30N/zpQfyGd2GFt7FxMID2wFj/W','12ef3',2,'123123','2016-11-10 17:00:00',NULL,NULL,0,'','','','2017-05-22 14:05:59',0,0,0,NULL,'',0),(9,'Nguyen Van Dung','Nguyen B','user06','user06@gmg.com','$2y$10$blp37cCx9BfmJ51KgD2Fgu/FQF30N/zpQfyGd2GFt7FxMID2wFj/W','sada33',2,'123123','2016-11-10 17:00:00',NULL,NULL,0,'','','','2017-05-22 14:05:59',0,0,0,NULL,'',0),(14,'tung','vo','tungvhq','tungvhq@test.com','$2y$10$rxc553HEpZVmWZ8/irAtXOQ0KSQ2fRdcXlSoTvcSGKLDHOOEbzN9i','rUS9KfOayMpZCCbeBc56jxQl8o3m6a95qLTJt0N56BIlvWrStFY0uSNrM4HO',1,NULL,'2017-03-20 09:44:28','2017-03-20 09:44:28',NULL,0,'','','','2017-05-22 14:05:59',0,0,0,NULL,'',0),(15,'vo hoang','quoc tung','tungdaica','tungdaica@test.com','$2y$10$43fgAAnJaFICqIHpLp3A1.EZ.XSHxzeaKfGm5O/qiWvZaH0YfskBO','DORJhk9h546T08s8fiYzgby9Zzs8XbxQP8WDf0tJhe9wEOF27SsxqC7xTAeo',10,NULL,'2017-03-20 16:48:53','2017-03-20 16:48:53',NULL,0,'','','','2017-05-22 14:05:59',0,0,0,NULL,'',0),(16,'teo','ti','abc123','abc123@test.com','$2y$10$at4itvaPYV2b9UDSf2HXkOLuMwwhFwzVvxvn2CiqZ.aUz59IiXJDa','XNHGiyTLT1He8Ib7QYThoxMuGDXyacCmSTCuNlFWTLVbbqjNWqLMwa2LMwoq',13,NULL,'2017-03-20 16:49:58','2017-03-20 16:49:58',NULL,0,'','','','2017-05-22 14:05:59',0,0,0,NULL,'',0),(17,'gf','cc','test01','test01@test.com','$2y$10$WRIuipFYu92Lavt2508rIeFwJ89cCahUMPZPBB6iwRvFjcCFpBRh.','hjCCB8q5G1hbIVwUyHxkmw04hfMm0rYq18f0l09oW2zYeSrEwaaNcQB8Zz07',9,NULL,'2017-03-20 17:36:00','2017-03-20 17:36:00',NULL,0,'','','','2017-05-22 14:05:59',0,0,0,NULL,'',0),(18,'Đồng Vinh','A','user18','nva_1@gmail.com','$2y$10$blp37cCx9BfmJ51KgD2Fgu/FQF30N/zpQfyGd2GFt7FxMID2wFj/W','1122',3,'123123','2016-11-10 10:00:00','2017-05-14 16:54:08',NULL,2,'0908144144','012345678','123456','1988-05-02 00:00:00',0,2,1,NULL,'A_DongVinh_Id_18',0),(19,'Vo Hoang','Quoc Tung','0914991139','quoctung1194@gmail.com','$2y$10$KxNjRO1zMPe1.wifonZB7OHGG0h0A0jmErymUOBO3C3ktlWFcoeIS','2pV9TljfaKylXuESIY4Ac11BLyFiY4bH8si56tICejalkXyWkCNmAmFfqdEX',3,NULL,'2017-05-23 18:13:41','2017-05-23 18:13:41',NULL,0,'','','','0000-00-00 00:00:00',0,0,0,NULL,'',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'apartmentmanagement'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-24  1:22:46
