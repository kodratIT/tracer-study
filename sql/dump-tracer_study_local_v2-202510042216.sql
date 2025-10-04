-- MySQL dump 10.13  Distrib 9.4.0, for macos15.4 (arm64)
--
-- Host: localhost    Database: tracer_study_local_v2
-- ------------------------------------------------------
-- Server version	9.4.0

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
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `log_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_id` bigint unsigned DEFAULT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint unsigned DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `batch_uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `activity_logs_subject_id_subject_type_index` (`subject_id`,`subject_type`),
  KEY `activity_logs_causer_id_causer_type_index` (`causer_id`,`causer_type`),
  KEY `activity_logs_log_name_index` (`log_name`),
  KEY `activity_logs_event_index` (`event`),
  KEY `activity_logs_created_at_index` (`created_at`),
  KEY `activity_logs_batch_uuid_index` (`batch_uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `addresses` (
  `address_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `village` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Indonesia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`address_id`),
  KEY `addresses_city_province_index` (`city`,`province`),
  KEY `addresses_postal_code_index` (`postal_code`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
INSERT INTO `addresses` VALUES (1,'Psr. Baabur Royan No. 201','15.05','15.05.03','15.05.03.2014','15','36249','Indonesia','2025-10-04 02:04:19','2025-10-04 02:05:54',NULL),(2,'Jln. Urip Sumoharjo No. 389','Lubuklinggau',NULL,NULL,'Jawa Barat','13026','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(3,'Psr. Acordion No. 809','Manado',NULL,NULL,'Sulawesi Selatan','87684','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(4,'Dk. Villa No. 310','Administrasi Jakarta Utara',NULL,NULL,'Sulawesi Selatan','93168','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(5,'Psr. Fajar No. 770','Serang',NULL,NULL,'Banten','91005','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(6,'Psr. Bakti No. 969','Administrasi Jakarta Timur',NULL,NULL,'Sulawesi Selatan','32393','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(7,'Psr. Baranang No. 850','Tomohon',NULL,NULL,'Banten','32012','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(8,'Gg. Pasteur No. 636','Pekanbaru',NULL,NULL,'Sumatera Utara','30277','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(9,'Kpg. Imam Bonjol No. 455','Salatiga',NULL,NULL,'Sumatera Utara','81019','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(10,'Psr. Basuki Rahmat  No. 495','Administrasi Jakarta Utara',NULL,NULL,'Banten','47093','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(11,'Jln. Jayawijaya No. 430','Banda Aceh',NULL,NULL,'Jawa Tengah','97763','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(12,'Dk. R.E. Martadinata No. 285','Pekanbaru',NULL,NULL,'Jawa Barat','62735','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(13,'Ki. Surapati No. 321','Sorong',NULL,NULL,'Jawa Tengah','17997','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(14,'Jr. Warga No. 977','Bandar Lampung',NULL,NULL,'Banten','10359','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(15,'Jln. Pahlawan No. 129','Yogyakarta',NULL,NULL,'Jawa Timur','17508','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(16,'Psr. Baranangsiang No. 502','Serang',NULL,NULL,'Sumatera Barat','82956','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(17,'Kpg. M.T. Haryono No. 835','Parepare',NULL,NULL,'Yogyakarta','98074','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(18,'Gg. Arifin No. 739','Singkawang',NULL,NULL,'Jawa Barat','12848','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(19,'Kpg. Diponegoro No. 9','Payakumbuh',NULL,NULL,'Sulawesi Selatan','40416','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(20,'Jln. Sutami No. 598','Palembang',NULL,NULL,'DKI Jakarta','59918','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(21,'Jln. Pasirkoja No. 22','Tarakan',NULL,NULL,'Sumatera Utara','70740','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(22,'Psr. Abdullah No. 970','Tasikmalaya',NULL,NULL,'Banten','82623','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(23,'Kpg. Ters. Kiaracondong No. 996','Bandar Lampung',NULL,NULL,'Jawa Timur','27339','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(24,'Jr. Dipenogoro No. 177','Blitar',NULL,NULL,'Jawa Tengah','89952','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(25,'Ki. Salatiga No. 804','Parepare',NULL,NULL,'DKI Jakarta','72145','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(26,'Jln. Jamika No. 906','Bandung',NULL,NULL,'Banten','34303','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(27,'Dk. Ters. Buah Batu No. 525','Pangkal Pinang',NULL,NULL,'Yogyakarta','23739','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(28,'Dk. Kalimantan No. 228','Kotamobagu',NULL,NULL,'Sumatera Utara','15977','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(29,'Psr. Mulyadi No. 966','Parepare',NULL,NULL,'Jawa Tengah','38266','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(30,'Gg. HOS. Cjokroaminoto (Pasirkaliki) No. 539','Pematangsiantar',NULL,NULL,'Jawa Barat','55247','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(31,'Ki. Industri No. 450','Salatiga',NULL,NULL,'DKI Jakarta','52625','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(32,'Jln. Kebangkitan Nasional No. 272','Surabaya',NULL,NULL,'Banten','95776','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(33,'Ds. Raden No. 282','Tomohon',NULL,NULL,'Banten','69911','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(34,'Jr. Baabur Royan No. 370','Tegal',NULL,NULL,'Bali','73348','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(35,'Jr. Astana Anyar No. 338','Palembang',NULL,NULL,'Sumatera Utara','51762','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(36,'Dk. Setiabudhi No. 837','Metro',NULL,NULL,'Yogyakarta','93990','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(37,'Ki. Ki Hajar Dewantara No. 694','Tarakan',NULL,NULL,'Sumatera Utara','99397','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(38,'Dk. Madiun No. 543','Pariaman',NULL,NULL,'Bali','36694','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(39,'Ds. Sunaryo No. 549','Administrasi Jakarta Barat',NULL,NULL,'Jawa Tengah','83887','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(40,'Dk. Laksamana No. 840','Administrasi Jakarta Selatan',NULL,NULL,'DKI Jakarta','67616','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(41,'Jln. Basuki No. 716','Subulussalam',NULL,NULL,'Sulawesi Selatan','18522','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(42,'Ds. Casablanca No. 27','Cirebon',NULL,NULL,'Jawa Tengah','47901','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(43,'Gg. Baranang No. 334','Cirebon',NULL,NULL,'Sumatera Utara','36003','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(44,'Jr. Sudiarto No. 92','Kediri',NULL,NULL,'Bali','21902','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(45,'Jln. Tentara Pelajar No. 968','Blitar',NULL,NULL,'Jawa Barat','18443','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(46,'Ki. Bara No. 363','Pagar Alam',NULL,NULL,'Bali','55679','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(47,'Kpg. Baung No. 751','Yogyakarta',NULL,NULL,'DKI Jakarta','15172','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(48,'Ki. Bakin No. 619','Denpasar',NULL,NULL,'Sumatera Utara','11575','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(49,'Dk. Muwardi No. 158','Gorontalo',NULL,NULL,'Sumatera Utara','33343','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(50,'Ds. Sutan Syahrir No. 334','Pariaman',NULL,NULL,'Jawa Timur','87440','Indonesia','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(51,'Jalan Jambi - Palembang Km 27','15.05','15.05.05','15.05.05.1009','15','36364','Indonesia','2025-10-04 07:15:57','2025-10-04 07:16:24',NULL);
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `administrators`
--

DROP TABLE IF EXISTS `administrators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `administrators` (
  `admin_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('super_admin','admin','operator','viewer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'operator',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login` timestamp NULL DEFAULT NULL,
  `permissions` json DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `administrators_username_unique` (`username`),
  UNIQUE KEY `administrators_email_unique` (`email`),
  KEY `administrators_role_index` (`role`),
  KEY `administrators_is_active_index` (`is_active`),
  KEY `administrators_last_login_index` (`last_login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrators`
--

LOCK TABLES `administrators` WRITE;
/*!40000 ALTER TABLE `administrators` DISABLE KEYS */;
/*!40000 ALTER TABLE `administrators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alumni`
--

DROP TABLE IF EXISTS `alumni`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumni` (
  `alumni_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `graduation_year` int NOT NULL,
  `gpa` decimal(3,2) DEFAULT NULL,
  `program_id` bigint unsigned DEFAULT NULL,
  `address_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`alumni_id`),
  UNIQUE KEY `alumni_student_id_unique` (`student_id`),
  UNIQUE KEY `alumni_email_unique` (`email`),
  KEY `alumni_graduation_year_index` (`graduation_year`),
  KEY `alumni_program_id_index` (`program_id`),
  KEY `alumni_address_id_index` (`address_id`),
  KEY `alumni_student_id_index` (`student_id`),
  CONSTRAINT `alumni_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`address_id`) ON DELETE SET NULL,
  CONSTRAINT `alumni_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`program_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumni`
--

LOCK TABLES `alumni` WRITE;
/*!40000 ALTER TABLE `alumni` DISABLE KEYS */;
INSERT INTO `alumni` VALUES (1,'20210001','yunita','yunita68@example.com','$2y$12$ufaLdPmAo48ogGnTRz1LduGCj1Z0SoD9GuVYLNiNaT7sk2DmIMhpm',NULL,NULL,'+6287869588263','male','2001-01-24',2025,3.70,1,1,'2025-10-04 02:04:19','2025-10-04 07:33:33','2025-10-04 07:33:33'),(2,'20220002','Karsana Pranowo M.M.','jasmin.simbolon@example.com',NULL,NULL,NULL,'0395 1472 914','male','2002-07-25',2022,3.99,2,2,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(3,'20210003','Ida Nasyidah','gpuspasari@example.com',NULL,NULL,NULL,'(+62) 588 8585 079','male','2001-01-14',2021,3.39,4,3,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(4,'20240004','Salimah Zahra Wahyuni S.T.','suartini.heryanto@example.org',NULL,NULL,NULL,'(+62) 918 9953 030','female','1996-11-25',2024,2.92,4,4,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(5,'20230005','Bahuwirya Firgantoro','nashiruddin.aurora@example.net',NULL,NULL,NULL,'0907 4001 583','male','1995-01-20',2023,3.49,3,5,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(6,'20240006','Himawan Samosir','csimanjuntak@example.com',NULL,NULL,NULL,'0892 9430 1340','female','1998-02-16',2024,3.26,3,6,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(7,'20230007','Dadi Firmansyah','ida30@example.net',NULL,NULL,NULL,'0385 0988 897','male','1995-07-15',2023,3.73,2,7,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(8,'20210008','Prayitna Pratama','hartati.nyana@example.net',NULL,NULL,NULL,'(+62) 28 4774 5449','male','1999-05-24',2021,3.96,1,8,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(9,'20200009','Elma Zulaika M.Pd','ina.jailani@example.com',NULL,NULL,NULL,'(+62) 560 8623 6354','male','1996-07-20',2020,3.39,2,9,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(10,'20220010','Adika Ghani Prayoga','pradana.nadia@example.org',NULL,NULL,NULL,'0316 5563 476','female','1996-03-22',2022,3.75,4,10,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(11,'20200011','Padmi Ratna Susanti','hassanah.vicky@example.org',NULL,NULL,NULL,'0976 1413 931','male','2001-10-23',2020,3.40,4,11,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(12,'20210012','Uchita Pudjiastuti M.M.','mutia34@example.org',NULL,NULL,NULL,'(+62) 776 4074 5680','male','2002-08-29',2021,2.85,5,12,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(13,'20220013','Bakijan Situmorang','jfirgantoro@example.com',NULL,NULL,NULL,'029 0108 4526','male','1997-05-27',2022,3.16,4,13,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(14,'20210014','Rachel Mardhiyah S.Sos','sudiati.wakiman@example.org',NULL,NULL,NULL,'(+62) 20 1991 958','male','1997-07-12',2021,3.66,5,14,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(15,'20240015','Arta Tampubolon','januar.genta@example.com',NULL,NULL,NULL,'0415 9308 661','male','2002-04-26',2024,2.78,2,15,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(16,'20240016','Gada Saptono','jarwi.puspasari@example.org',NULL,NULL,NULL,'(+62) 704 3011 2038','female','1996-03-30',2024,3.71,4,16,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(17,'20230017','Rahmi Juli Mandasari','ppalastri@example.net',NULL,NULL,NULL,'0526 3114 295','female','1998-08-03',2023,2.51,4,17,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(18,'20230018','Winda Raina Mayasari S.IP','latupono.ilsa@example.com',NULL,NULL,NULL,'(+62) 343 1112 5043','male','1996-08-17',2023,2.58,2,18,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(19,'20200019','Farah Ade Yulianti','gwastuti@example.net',NULL,NULL,NULL,'0649 3583 3253','male','1997-04-04',2020,2.65,1,19,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(20,'20210020','Clara Oktaviani','fmardhiyah@example.org',NULL,NULL,NULL,'(+62) 466 5890 0117','female','2002-11-03',2021,3.94,2,20,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(21,'20230021','Saiful Eluh Mustofa M.Kom.','chutapea@example.net',NULL,NULL,NULL,'0527 6354 112','male','1998-08-12',2023,3.66,2,21,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(22,'20230022','Ani Wahyuni S.E.','yuliarti.salimah@example.com',NULL,NULL,NULL,'0254 1346 5943','female','1998-05-28',2023,2.74,4,22,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(23,'20230023','Rini Laksmiwati','maryadi24@example.com',NULL,NULL,NULL,'(+62) 320 9171 701','female','2001-07-05',2023,3.91,2,23,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(24,'20240024','Winda Andriani','saragih.cecep@example.com',NULL,NULL,NULL,'(+62) 252 6041 9325','male','1997-08-13',2024,2.90,3,24,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(25,'20240025','Ratna Wijayanti','rahmawati.daruna@example.com',NULL,NULL,NULL,'026 4576 763','male','1998-08-02',2024,2.88,2,25,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(26,'20220026','Ajimin Manullang S.Psi','tugiman81@example.net',NULL,NULL,NULL,'0810 0316 1069','male','1996-05-09',2022,2.86,4,26,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(27,'20200027','Prabawa Sabar Sitompul','balamantri.mulyani@example.com',NULL,NULL,NULL,'(+62) 961 1534 210','female','1997-04-17',2020,2.77,2,27,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(28,'20210028','Asman Labuh Mangunsong S.H.','hnugroho@example.net',NULL,NULL,NULL,'0961 5073 1645','male','1998-03-23',2021,2.88,2,28,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(29,'20240029','Niyaga Wasita M.Pd','lidya16@example.org',NULL,NULL,NULL,'0627 8452 7975','male','2001-11-23',2024,3.64,3,29,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(30,'20230030','Raihan Hasim Suwarno S.Ked','novitasari.cornelia@example.net',NULL,NULL,NULL,'0235 4023 346','female','2000-06-19',2023,3.07,1,30,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(31,'20200031','Maria Zalindra Pratiwi S.Ked','salimah16@example.org',NULL,NULL,NULL,'0777 1269 9401','female','1997-11-01',2020,3.63,5,31,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(32,'20210032','Amalia Permata','fpudjiastuti@example.com',NULL,NULL,NULL,'(+62) 488 1370 012','male','1999-10-23',2021,3.69,3,32,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(33,'20240033','Balapati Santoso S.Kom','nsuryono@example.com',NULL,NULL,NULL,'(+62) 511 4139 440','female','1998-01-28',2024,3.49,5,33,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(34,'20240034','Embuh Damanik','atmaja73@example.net',NULL,NULL,NULL,'0509 7126 250','male','1996-06-15',2024,3.02,3,34,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(35,'20210035','Galar Karta Gunawan S.Ked','handayani.ajimin@example.org',NULL,NULL,NULL,'0738 8469 7917','female','2002-08-25',2021,3.41,2,35,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(36,'20230036','Bakiadi Dabukke','amalia64@example.org',NULL,NULL,NULL,'(+62) 878 573 184','male','2000-08-30',2023,3.74,3,36,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(37,'20210037','Dadi Purwadi Mansur','ckurniawan@example.org',NULL,NULL,NULL,'0296 0087 897','female','1999-08-04',2021,2.80,5,37,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(38,'20230038','Chelsea Zelda Yulianti','tamba.aurora@example.com',NULL,NULL,NULL,'025 4802 096','male','2002-07-30',2023,3.43,4,38,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(39,'20200039','Kayla Kezia Nasyiah S.Ked','suwais@example.net',NULL,NULL,NULL,'0722 7810 6661','male','1997-10-09',2020,2.75,4,39,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(40,'20200040','Nasrullah Tedi Mangunsong S.IP','kusmawati.faizah@example.com',NULL,NULL,NULL,'0467 5621 222','male','1998-03-29',2020,2.89,4,40,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(41,'20240041','Prima Ade Pratama S.H.','bandriani@example.com',NULL,NULL,NULL,'(+62) 678 8513 664','female','1995-02-06',2024,3.88,3,41,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(42,'20210042','Asmuni Pradipta','yhakim@example.org',NULL,NULL,NULL,'0515 3636 416','female','2002-04-07',2021,3.86,3,42,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(43,'20210043','Amelia Aryani','dian.haryanti@example.org',NULL,NULL,NULL,'(+62) 749 6944 645','male','1996-12-25',2021,3.29,1,43,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(44,'20230044','Diah Pertiwi','hamzah.hidayat@example.com',NULL,NULL,NULL,'(+62) 667 2357 185','female','1996-05-22',2023,3.08,3,44,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(45,'20220045','Murti Marbun','awastuti@example.net',NULL,NULL,NULL,'0906 5694 5839','female','1995-10-31',2022,3.82,2,45,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(46,'20230046','Karja Leo Zulkarnain','zamira43@example.org',NULL,NULL,NULL,'(+62) 753 1638 041','male','1998-04-22',2023,3.50,5,46,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(47,'20200047','Asmadi Jailani','nwahyuni@example.com',NULL,NULL,NULL,'0379 5618 315','female','1998-09-14',2020,3.01,3,47,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(48,'20210048','Ajimat Nasim Najmudin S.E.','jayeng.lestari@example.org',NULL,NULL,NULL,'(+62) 346 0094 746','male','1996-12-20',2021,3.97,1,48,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(49,'20220049','Clara Kuswandari S.Psi','oktaviani.ganda@example.com',NULL,NULL,NULL,'0631 6406 0095','male','1995-10-13',2022,2.70,3,49,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(50,'20230050','Jais Budiyanto M.Ak','gangsar.setiawan@example.org',NULL,NULL,NULL,'0567 8592 021','female','1995-07-10',2023,3.00,4,50,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(51,'123456','Kodrat Pamungkas','kodratrader@gmail.com','$2y$12$35d7.cM5L3YNp4eUJCTsSOZCi6bWVtThCkTyxVnrSn.h8dbsnuFRW',NULL,NULL,'+6281414144185','male','2001-11-19',2025,3.88,3,51,'2025-10-04 07:13:27','2025-10-04 07:16:24',NULL);
/*!40000 ALTER TABLE `alumni` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alumni_skills`
--

DROP TABLE IF EXISTS `alumni_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumni_skills` (
  `alumni_skill_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `alumni_id` bigint unsigned NOT NULL,
  `skill_id` bigint unsigned NOT NULL,
  `proficiency_level` enum('beginner','intermediate','advanced','expert') COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`alumni_skill_id`),
  UNIQUE KEY `alumni_skills_alumni_id_skill_id_unique` (`alumni_id`,`skill_id`),
  KEY `alumni_skills_alumni_id_index` (`alumni_id`),
  KEY `alumni_skills_skill_id_index` (`skill_id`),
  KEY `alumni_skills_proficiency_level_index` (`proficiency_level`),
  CONSTRAINT `alumni_skills_alumni_id_foreign` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`alumni_id`) ON DELETE CASCADE,
  CONSTRAINT `alumni_skills_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`skill_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumni_skills`
--

LOCK TABLES `alumni_skills` WRITE;
/*!40000 ALTER TABLE `alumni_skills` DISABLE KEYS */;
INSERT INTO `alumni_skills` VALUES (1,1,1,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(2,1,2,'intermediate','Molestiae tenetur beatae quae quia cumque aperiam dolorum expedita.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(3,1,6,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(4,1,5,'expert','Mollitia possimus ratione eaque dicta ipsa.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(5,1,3,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(6,1,4,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(7,2,3,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(8,2,5,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(9,2,1,'beginner','Enim ullam consequatur quisquam.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(10,2,6,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(11,2,2,'intermediate','Non quas libero et omnis et.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(12,3,4,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(13,3,1,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(14,3,5,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(15,3,3,'beginner','Facilis amet sequi delectus sed.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(16,3,2,'beginner','Eaque rerum blanditiis id sequi necessitatibus et porro quo.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(17,3,6,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(18,4,2,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(19,4,3,'advanced','Aut itaque fugit occaecati aut vel delectus est.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(20,4,6,'advanced','Est veritatis ut error.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(21,4,1,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(22,4,5,'expert','Nihil ut assumenda magnam earum quia.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(23,5,1,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(24,5,3,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(25,5,6,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(26,5,2,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(27,5,5,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(28,6,6,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(29,6,3,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(30,6,4,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(31,7,6,'intermediate','Et sapiente provident neque impedit hic ab.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(32,7,5,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(33,7,1,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(34,7,3,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(35,7,2,'expert','Consequatur beatae dignissimos voluptas aperiam dolor non voluptates.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(36,7,4,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(37,8,2,'beginner','Pariatur explicabo tempore id mollitia et quae.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(38,8,4,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(39,8,5,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(40,8,3,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(41,9,1,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(42,9,2,'expert','Incidunt voluptatum reprehenderit voluptatibus sunt porro.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(43,10,4,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(44,10,5,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(45,10,2,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(46,10,3,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(47,10,1,'advanced','Saepe quo quae qui.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(48,10,6,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(49,11,2,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(50,11,4,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(51,11,1,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(52,11,3,'advanced','Facilis dignissimos et qui omnis.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(53,11,6,'beginner','Numquam quae ducimus et quo nostrum.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(54,11,5,'advanced','Est voluptatem sed sed beatae tempore dolorum aspernatur rerum.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(55,12,1,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(56,12,6,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(57,13,4,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(58,13,3,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(59,13,1,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(60,13,2,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(61,14,4,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(62,14,2,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(63,14,6,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(64,14,1,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(65,14,5,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(66,15,6,'advanced','Laudantium minus rerum voluptas explicabo.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(67,15,5,'expert','Quam eius quia itaque ex consequatur vel.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(68,15,2,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(69,15,1,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(70,16,1,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(71,16,4,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(72,16,3,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(73,17,1,'advanced','Aut vel repellendus tempore et ullam perspiciatis.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(74,17,3,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(75,17,4,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(76,17,5,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(77,17,6,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(78,17,2,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(79,18,1,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(80,18,2,'beginner','Sed magnam non deleniti et quos laboriosam.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(81,18,4,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(82,18,6,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(83,18,5,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(84,18,3,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(85,19,6,'intermediate','Ut nam eos deserunt distinctio.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(86,19,5,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(87,19,2,'intermediate','Atque minima nihil voluptatem adipisci minus consectetur similique ut.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(88,19,3,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(89,20,3,'intermediate','Sed fugiat dolores est hic nihil esse vero.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(90,20,4,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(91,20,5,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(92,20,6,'intermediate','Aspernatur ex non doloribus ex eos aliquid deleniti.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(93,20,2,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(94,21,4,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(95,21,1,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(96,21,2,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(97,21,5,'beginner','Hic beatae et facilis.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(98,21,3,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(99,22,4,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(100,22,5,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(101,22,1,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(102,22,6,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(103,22,2,'expert','Tempore autem exercitationem mollitia dolorum commodi iure.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(104,23,2,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(105,23,5,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(106,23,3,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(107,23,6,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(108,23,1,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(109,23,4,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(110,24,4,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(111,24,2,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(112,24,6,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(113,25,4,'advanced','Eum blanditiis repellendus sunt unde cumque.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(114,25,1,'expert','Et molestias voluptatem quae laboriosam ullam.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(115,25,2,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(116,25,5,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(117,26,2,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(118,26,4,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(119,26,5,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(120,26,1,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(121,26,6,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(122,27,2,'advanced','Nostrum qui corporis dolore reiciendis est.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(123,27,4,'expert','Inventore quia aut commodi.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(124,27,3,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(125,27,5,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(126,28,1,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(127,28,6,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(128,28,4,'beginner','Accusamus qui velit quos labore suscipit repellendus laudantium.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(129,28,5,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(130,28,3,'expert','Fuga sed et sint omnis.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(131,28,2,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(132,29,6,'advanced','Et hic reiciendis fuga at eos maxime.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(133,29,2,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(134,30,5,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(135,30,4,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(136,30,2,'intermediate','Voluptatem distinctio nihil quia nemo consectetur dolorem.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(137,31,6,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(138,31,1,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(139,31,4,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(140,32,6,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(141,32,1,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(142,32,4,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(143,32,2,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(144,33,3,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(145,33,6,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(146,34,3,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(147,34,5,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(148,35,2,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(149,35,1,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(150,35,6,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(151,36,4,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(152,36,6,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(153,36,5,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(154,37,6,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(155,37,4,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(156,38,3,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(157,38,2,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(158,39,2,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(159,39,3,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(160,39,4,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(161,39,5,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(162,39,1,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(163,40,4,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(164,40,3,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(165,40,2,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(166,40,5,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(167,41,5,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(168,41,2,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(169,41,3,'expert','Officia ex rerum et corporis qui.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(170,41,4,'beginner','Consectetur et reprehenderit sequi porro modi.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(171,41,1,'beginner','Doloremque ut molestiae quia voluptatem incidunt vel.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(172,42,2,'advanced','Voluptas odio aut voluptatem voluptas.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(173,42,5,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(174,42,4,'advanced','Nostrum et sint maiores eveniet omnis est.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(175,43,6,'expert','Adipisci soluta rerum ut aut quia.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(176,43,2,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(177,43,4,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(178,44,6,'expert','Qui voluptatem quas reiciendis quo.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(179,44,2,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(180,44,4,'intermediate','Cupiditate quia eum esse.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(181,44,1,'beginner','Laudantium distinctio animi veritatis incidunt ipsum enim non.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(182,44,3,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(183,45,5,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(184,45,4,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(185,45,1,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(186,45,6,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(187,46,1,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(188,46,5,'beginner','Accusamus nostrum reiciendis eos quos.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(189,46,6,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(190,46,2,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(191,46,4,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(192,46,3,'expert',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(193,47,4,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(194,47,5,'intermediate','Corrupti itaque rerum nisi fugiat.','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(195,48,2,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(196,48,4,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(197,48,3,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(198,49,2,'intermediate',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(199,49,1,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(200,50,6,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(201,50,1,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(202,50,3,'advanced',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(203,50,5,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(204,50,2,'beginner',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL);
/*!40000 ALTER TABLE `alumni_skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alumni_trainings`
--

DROP TABLE IF EXISTS `alumni_trainings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alumni_trainings` (
  `alumni_training_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `alumni_id` bigint unsigned NOT NULL,
  `training_id` bigint unsigned NOT NULL,
  `status` enum('registered','in_progress','completed','dropped','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL,
  `score` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `completion_date` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`alumni_training_id`),
  UNIQUE KEY `alumni_trainings_alumni_id_training_id_unique` (`alumni_id`,`training_id`),
  KEY `alumni_trainings_alumni_id_index` (`alumni_id`),
  KEY `alumni_trainings_training_id_index` (`training_id`),
  KEY `alumni_trainings_status_index` (`status`),
  CONSTRAINT `alumni_trainings_alumni_id_foreign` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`alumni_id`) ON DELETE CASCADE,
  CONSTRAINT `alumni_trainings_training_id_foreign` FOREIGN KEY (`training_id`) REFERENCES `training_courses` (`training_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumni_trainings`
--

LOCK TABLES `alumni_trainings` WRITE;
/*!40000 ALTER TABLE `alumni_trainings` DISABLE KEYS */;
/*!40000 ALTER TABLE `alumni_trainings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `answers` (
  `answer_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `response_id` bigint unsigned NOT NULL,
  `question_id` bigint unsigned NOT NULL,
  `option_id` bigint unsigned DEFAULT NULL,
  `answer_text` text COLLATE utf8mb4_unicode_ci,
  `rating_value` int DEFAULT NULL,
  `additional_data` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`answer_id`),
  KEY `answers_response_id_index` (`response_id`),
  KEY `answers_question_id_index` (`question_id`),
  KEY `answers_option_id_index` (`option_id`),
  KEY `answers_response_id_question_id_index` (`response_id`,`question_id`),
  CONSTRAINT `answers_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `survey_options` (`option_id`) ON DELETE SET NULL,
  CONSTRAINT `answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `survey_questions` (`question_id`) ON DELETE CASCADE,
  CONSTRAINT `answers_response_id_foreign` FOREIGN KEY (`response_id`) REFERENCES `survey_responses` (`response_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers`
--

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
INSERT INTO `answers` VALUES (1,1,1,NULL,'Cinta Pudjiastuti S.T.',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(2,1,2,NULL,'0442076909',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(3,1,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(4,1,4,NULL,'2.58',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(5,1,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(6,2,1,NULL,'Natalia Putri Yolanda M.M.',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(7,2,2,NULL,'3733488042',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(8,2,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(9,2,4,NULL,'2.53',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(10,2,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(11,3,1,NULL,'Aswani Rahman Santoso M.TI.',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(12,3,2,NULL,'2804672267',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(13,3,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(14,3,4,NULL,'3.25',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(15,3,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(16,4,1,NULL,'Zamira Hastuti',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(17,4,2,NULL,'0385837378',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(18,4,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(19,4,4,NULL,'3.8',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(20,4,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(21,5,1,NULL,'Umi Riyanti',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(22,5,2,NULL,'8217350318',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(23,5,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(24,5,4,NULL,'3.42',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(25,5,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(26,10,1,NULL,'Hafshah Palastri',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(27,10,2,NULL,'3485662667',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(28,10,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(29,10,4,NULL,'2.62',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(30,10,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(31,11,1,NULL,'Ganda Iswahyudi',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(32,11,2,NULL,'2925692386',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(33,11,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(34,11,4,NULL,'3.24',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(35,11,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(36,12,1,NULL,'Waluyo Permadi',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(37,12,2,NULL,'0056884236',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(38,12,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(39,12,4,NULL,'3.25',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(40,12,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(41,13,1,NULL,'Ratna Mandasari M.Farm',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(42,13,2,NULL,'6223494810',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(43,13,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(44,13,4,NULL,'3.96',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(45,13,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(46,14,1,NULL,'Jefri Habibi S.H.',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(47,14,2,NULL,'4900212419',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(48,14,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(49,14,4,NULL,'3.13',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(50,14,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(51,15,1,NULL,'Laras Ellis Purwanti',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(52,15,2,NULL,'8959592022',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(53,15,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(54,15,4,NULL,'3.13',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(55,15,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(56,17,1,NULL,'Ami Kusmawati',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(57,17,2,NULL,'3116063439',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(58,17,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(59,17,4,NULL,'3.23',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(60,17,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(61,18,1,NULL,'Ibun Widodo M.Kom.',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(62,18,2,NULL,'5589980627',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(63,18,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(64,18,4,NULL,'2.87',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(65,18,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(66,19,1,NULL,'Panca Tamba S.Pd',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(67,19,2,NULL,'5945517946',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(68,19,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(69,19,4,NULL,'2.62',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(70,19,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(71,20,1,NULL,'Asman Maulana',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(72,20,2,NULL,'0247912843',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(73,20,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(74,20,4,NULL,'3.77',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(75,20,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(76,21,1,NULL,'Zahra Nasyiah',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(77,21,2,NULL,'4173737059',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(78,21,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(79,21,4,NULL,'3.48',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(80,21,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(81,23,1,NULL,'Ulya Ira Melani',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(82,23,2,NULL,'1784496223',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(83,23,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(84,23,4,NULL,'2.79',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(85,23,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(86,24,1,NULL,'Maya Mulyani',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(87,24,2,NULL,'9029475033',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(88,24,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(89,24,4,NULL,'2.9',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(90,24,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(96,27,1,NULL,'Bambang Ardianto',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(97,27,2,NULL,'9485450431',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(98,27,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(99,27,4,NULL,'2.79',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(100,27,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(101,28,1,NULL,'Manah Aslijan Mangunsong',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(102,28,2,NULL,'8081880383',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(103,28,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(104,28,4,NULL,'3.95',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(105,28,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(106,31,1,NULL,'Prakosa Oman Zulkarnain S.Pd',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(107,31,2,NULL,'6305010744',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(108,31,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(109,31,4,NULL,'2.99',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(110,31,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(111,32,1,NULL,'Bakidin Tarihoran',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(112,32,2,NULL,'5421843462',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(113,32,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(114,32,4,NULL,'2.84',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(115,32,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(116,33,1,NULL,'Vicky Zulaika',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(117,33,2,NULL,'9949846569',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(118,33,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(119,33,4,NULL,'3.51',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(120,33,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(121,34,1,NULL,'Ratna Nasyiah S.Sos',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(122,34,2,NULL,'7154102815',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(123,34,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(124,34,4,NULL,'3.39',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(125,34,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(126,35,1,NULL,'Vera Putri Maryati M.Pd',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(127,35,2,NULL,'7607734297',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(128,35,3,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(129,35,4,NULL,'3.7',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(130,35,5,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(131,36,2,NULL,'f1e121034',NULL,NULL,'2025-10-04 02:09:26','2025-10-04 02:09:26',NULL),(132,36,4,NULL,'6 bulan',NULL,NULL,'2025-10-04 02:09:37','2025-10-04 02:09:37',NULL),(133,36,1,NULL,'kodrat',NULL,NULL,'2025-10-04 02:09:52','2025-10-04 02:09:52',NULL),(134,36,3,NULL,'2025',NULL,NULL,'2025-10-04 02:11:13','2025-10-04 02:11:13',NULL),(135,36,5,NULL,'puas',NULL,NULL,'2025-10-04 02:11:57','2025-10-04 02:11:57',NULL),(136,37,1,NULL,'kodrat pamungkas',NULL,NULL,'2025-10-04 07:26:20','2025-10-04 07:26:20',NULL),(137,37,2,NULL,'123456',NULL,NULL,'2025-10-04 07:26:23','2025-10-04 07:26:23',NULL),(138,37,3,NULL,'2025',NULL,NULL,'2025-10-04 07:26:25','2025-10-04 07:26:25',NULL),(139,37,4,NULL,'5',NULL,NULL,'2025-10-04 07:26:29','2025-10-04 07:26:29',NULL),(140,37,5,NULL,NULL,5,NULL,'2025-10-04 07:28:12','2025-10-04 07:28:13',NULL);
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6','i:2;',1759590914),('livewire-rate-limiter:16d36dff9abd246c67dfac3e63b993a169af77e6:timer','i:1759590914;',1759590914),('spatie.permission.cache','a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:151:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:18:\"view_any_dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:18:\"access_admin_panel\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:15:\"view_any_alumni\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:11:\"view_alumni\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:19:\"view_any_department\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:15:\"view_department\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:17:\"view_any_employer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:13:\"view_employer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:27:\"view_any_employment_history\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:23:\"view_employment_history\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:16:\"view_any_faculty\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:12:\"view_faculty\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:16:\"view_any_program\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:12:\"view_program\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:24:\"view_any_survey_question\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:20:\"view_survey_question\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:24:\"view_any_survey_response\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:20:\"view_survey_response\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:29:\"view_any_tracer_study_session\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:25:\"view_tracer_study_session\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:5;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:13:\"create_alumni\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:13:\"update_alumni\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:13:\"delete_alumni\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:17:\"delete_any_alumni\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:19:\"force_delete_alumni\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:23:\"force_delete_any_alumni\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:14:\"restore_alumni\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:18:\"restore_any_alumni\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:16:\"replicate_alumni\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:11:\"view_campus\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:15:\"view_any_campus\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:13:\"create_campus\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:13:\"update_campus\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:13:\"delete_campus\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:17:\"delete_any_campus\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:19:\"force_delete_campus\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:23:\"force_delete_any_campus\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:14:\"restore_campus\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:18:\"restore_any_campus\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:16:\"replicate_campus\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:17:\"create_department\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:17:\"update_department\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:17:\"delete_department\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:21:\"delete_any_department\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:23:\"force_delete_department\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:27:\"force_delete_any_department\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:18:\"restore_department\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:22:\"restore_any_department\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:20:\"replicate_department\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:14:\"create_faculty\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:14:\"update_faculty\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:14:\"delete_faculty\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:18:\"delete_any_faculty\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:20:\"force_delete_faculty\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:24:\"force_delete_any_faculty\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:15:\"restore_faculty\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:19:\"restore_any_faculty\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:17:\"replicate_faculty\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:14:\"create_program\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:59;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:14:\"update_program\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:60;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:14:\"delete_program\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:61;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:18:\"delete_any_program\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:62;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:20:\"force_delete_program\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:63;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:24:\"force_delete_any_program\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:64;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:15:\"restore_program\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:65;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:19:\"restore_any_program\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:66;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:17:\"replicate_program\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:67;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:15:\"create_employer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:68;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:15:\"update_employer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:69;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:15:\"delete_employer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:70;a:4:{s:1:\"a\";i:71;s:1:\"b\";s:19:\"delete_any_employer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:71;a:4:{s:1:\"a\";i:72;s:1:\"b\";s:21:\"force_delete_employer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:72;a:4:{s:1:\"a\";i:73;s:1:\"b\";s:25:\"force_delete_any_employer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:73;a:4:{s:1:\"a\";i:74;s:1:\"b\";s:16:\"restore_employer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:74;a:4:{s:1:\"a\";i:75;s:1:\"b\";s:20:\"restore_any_employer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:75;a:4:{s:1:\"a\";i:76;s:1:\"b\";s:18:\"replicate_employer\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:76;a:4:{s:1:\"a\";i:77;s:1:\"b\";s:15:\"view_employment\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:77;a:4:{s:1:\"a\";i:78;s:1:\"b\";s:19:\"view_any_employment\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:78;a:4:{s:1:\"a\";i:79;s:1:\"b\";s:17:\"create_employment\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:79;a:4:{s:1:\"a\";i:80;s:1:\"b\";s:17:\"update_employment\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:80;a:4:{s:1:\"a\";i:81;s:1:\"b\";s:17:\"delete_employment\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:81;a:4:{s:1:\"a\";i:82;s:1:\"b\";s:21:\"delete_any_employment\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:82;a:4:{s:1:\"a\";i:83;s:1:\"b\";s:23:\"force_delete_employment\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:83;a:4:{s:1:\"a\";i:84;s:1:\"b\";s:27:\"force_delete_any_employment\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:84;a:4:{s:1:\"a\";i:85;s:1:\"b\";s:18:\"restore_employment\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:85;a:4:{s:1:\"a\";i:86;s:1:\"b\";s:22:\"restore_any_employment\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:86;a:4:{s:1:\"a\";i:87;s:1:\"b\";s:20:\"replicate_employment\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:87;a:4:{s:1:\"a\";i:88;s:1:\"b\";s:22:\"create_survey_question\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:88;a:4:{s:1:\"a\";i:89;s:1:\"b\";s:22:\"update_survey_question\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:89;a:4:{s:1:\"a\";i:90;s:1:\"b\";s:22:\"delete_survey_question\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:90;a:4:{s:1:\"a\";i:91;s:1:\"b\";s:26:\"delete_any_survey_question\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:91;a:4:{s:1:\"a\";i:92;s:1:\"b\";s:28:\"force_delete_survey_question\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:92;a:4:{s:1:\"a\";i:93;s:1:\"b\";s:32:\"force_delete_any_survey_question\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:93;a:4:{s:1:\"a\";i:94;s:1:\"b\";s:23:\"restore_survey_question\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:94;a:4:{s:1:\"a\";i:95;s:1:\"b\";s:27:\"restore_any_survey_question\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:95;a:4:{s:1:\"a\";i:96;s:1:\"b\";s:25:\"replicate_survey_question\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:96;a:4:{s:1:\"a\";i:97;s:1:\"b\";s:22:\"create_survey_response\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:97;a:4:{s:1:\"a\";i:98;s:1:\"b\";s:22:\"update_survey_response\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:98;a:4:{s:1:\"a\";i:99;s:1:\"b\";s:22:\"delete_survey_response\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:99;a:4:{s:1:\"a\";i:100;s:1:\"b\";s:26:\"delete_any_survey_response\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:100;a:4:{s:1:\"a\";i:101;s:1:\"b\";s:28:\"force_delete_survey_response\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:101;a:4:{s:1:\"a\";i:102;s:1:\"b\";s:32:\"force_delete_any_survey_response\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:102;a:4:{s:1:\"a\";i:103;s:1:\"b\";s:23:\"restore_survey_response\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:103;a:4:{s:1:\"a\";i:104;s:1:\"b\";s:27:\"restore_any_survey_response\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:104;a:4:{s:1:\"a\";i:105;s:1:\"b\";s:25:\"replicate_survey_response\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:105;a:4:{s:1:\"a\";i:106;s:1:\"b\";s:27:\"create_tracer_study_session\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:106;a:4:{s:1:\"a\";i:107;s:1:\"b\";s:27:\"update_tracer_study_session\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:107;a:4:{s:1:\"a\";i:108;s:1:\"b\";s:27:\"delete_tracer_study_session\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:108;a:4:{s:1:\"a\";i:109;s:1:\"b\";s:31:\"delete_any_tracer_study_session\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:109;a:4:{s:1:\"a\";i:110;s:1:\"b\";s:33:\"force_delete_tracer_study_session\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:110;a:4:{s:1:\"a\";i:111;s:1:\"b\";s:37:\"force_delete_any_tracer_study_session\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:111;a:4:{s:1:\"a\";i:112;s:1:\"b\";s:28:\"restore_tracer_study_session\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:112;a:4:{s:1:\"a\";i:113;s:1:\"b\";s:32:\"restore_any_tracer_study_session\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:113;a:4:{s:1:\"a\";i:114;s:1:\"b\";s:30:\"replicate_tracer_study_session\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:114;a:4:{s:1:\"a\";i:115;s:1:\"b\";s:11:\"view_report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:115;a:4:{s:1:\"a\";i:116;s:1:\"b\";s:15:\"view_any_report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:116;a:4:{s:1:\"a\";i:117;s:1:\"b\";s:13:\"create_report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:117;a:4:{s:1:\"a\";i:118;s:1:\"b\";s:13:\"update_report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:118;a:4:{s:1:\"a\";i:119;s:1:\"b\";s:13:\"delete_report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:119;a:4:{s:1:\"a\";i:120;s:1:\"b\";s:17:\"delete_any_report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:120;a:4:{s:1:\"a\";i:121;s:1:\"b\";s:19:\"force_delete_report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:121;a:4:{s:1:\"a\";i:122;s:1:\"b\";s:23:\"force_delete_any_report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:122;a:4:{s:1:\"a\";i:123;s:1:\"b\";s:14:\"restore_report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:123;a:4:{s:1:\"a\";i:124;s:1:\"b\";s:18:\"restore_any_report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:124;a:4:{s:1:\"a\";i:125;s:1:\"b\";s:16:\"replicate_report\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:125;a:4:{s:1:\"a\";i:126;s:1:\"b\";s:9:\"view_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:126;a:4:{s:1:\"a\";i:127;s:1:\"b\";s:13:\"view_any_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:127;a:4:{s:1:\"a\";i:128;s:1:\"b\";s:11:\"create_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:128;a:4:{s:1:\"a\";i:129;s:1:\"b\";s:11:\"update_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:129;a:4:{s:1:\"a\";i:130;s:1:\"b\";s:11:\"delete_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:130;a:4:{s:1:\"a\";i:131;s:1:\"b\";s:15:\"delete_any_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:131;a:4:{s:1:\"a\";i:132;s:1:\"b\";s:17:\"force_delete_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:132;a:4:{s:1:\"a\";i:133;s:1:\"b\";s:21:\"force_delete_any_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:133;a:4:{s:1:\"a\";i:134;s:1:\"b\";s:12:\"restore_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:134;a:4:{s:1:\"a\";i:135;s:1:\"b\";s:16:\"restore_any_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:135;a:4:{s:1:\"a\";i:136;s:1:\"b\";s:14:\"replicate_role\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:136;a:4:{s:1:\"a\";i:137;s:1:\"b\";s:9:\"view_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:137;a:4:{s:1:\"a\";i:138;s:1:\"b\";s:13:\"view_any_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:138;a:4:{s:1:\"a\";i:139;s:1:\"b\";s:11:\"create_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:139;a:4:{s:1:\"a\";i:140;s:1:\"b\";s:11:\"update_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:140;a:4:{s:1:\"a\";i:141;s:1:\"b\";s:11:\"delete_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:141;a:4:{s:1:\"a\";i:142;s:1:\"b\";s:15:\"delete_any_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:142;a:4:{s:1:\"a\";i:143;s:1:\"b\";s:17:\"force_delete_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:143;a:4:{s:1:\"a\";i:144;s:1:\"b\";s:21:\"force_delete_any_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:144;a:4:{s:1:\"a\";i:145;s:1:\"b\";s:12:\"restore_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:145;a:4:{s:1:\"a\";i:146;s:1:\"b\";s:16:\"restore_any_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:146;a:4:{s:1:\"a\";i:147;s:1:\"b\";s:14:\"replicate_user\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:147;a:4:{s:1:\"a\";i:148;s:1:\"b\";s:14:\"page_Dashboard\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:148;a:4:{s:1:\"a\";i:149;s:1:\"b\";s:32:\"widget_TracerStudyOverviewWidget\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:149;a:4:{s:1:\"a\";i:150;s:1:\"b\";s:34:\"widget_AlumniEmploymentStatsWidget\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:150;a:4:{s:1:\"a\";i:151;s:1:\"b\";s:29:\"widget_AlumniTrendChartWidget\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}}s:5:\"roles\";a:4:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:11:\"super_admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:10:\"panel_user\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:5:\"staff\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:6:\"viewer\";s:1:\"c\";s:3:\"web\";}}}',1759677280);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `campuses`
--

DROP TABLE IF EXISTS `campuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `campuses` (
  `campus_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `campus_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`campus_id`),
  KEY `campuses_city_province_index` (`city`,`province`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campuses`
--

LOCK TABLES `campuses` WRITE;
/*!40000 ALTER TABLE `campuses` DISABLE KEYS */;
INSERT INTO `campuses` VALUES (1,'Universitas Indonesia','Depok','Jawa Barat','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(2,'Institut Teknologi Bandung','Bandung','Jawa Barat','2025-10-04 02:04:19','2025-10-04 07:31:33','2025-10-04 07:31:33'),(3,'Universitas Gadjah Mada','Yogyakarta','Yogyakarta','2025-10-04 02:04:19','2025-10-04 07:31:33','2025-10-04 07:31:33'),(4,'Institut Teknologi Sepuluh Nopember','Surabaya','Jawa Timur','2025-10-04 02:04:19','2025-10-04 07:31:33','2025-10-04 07:31:33'),(5,'Universitas Brawijaya','Malang','Jawa Timur','2025-10-04 02:04:19','2025-10-04 07:31:33','2025-10-04 07:31:33');
/*!40000 ALTER TABLE `campuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_methods`
--

DROP TABLE IF EXISTS `contact_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_methods` (
  `contact_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `alumni_id` bigint unsigned NOT NULL,
  `contact_type` enum('email','phone','whatsapp','linkedin','instagram','facebook','twitter','youtube','tiktok','github','website','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`contact_id`),
  KEY `contact_methods_alumni_id_contact_type_index` (`alumni_id`,`contact_type`),
  KEY `contact_methods_alumni_id_is_primary_index` (`alumni_id`,`is_primary`),
  CONSTRAINT `contact_methods_alumni_id_foreign` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`alumni_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_methods`
--

LOCK TABLES `contact_methods` WRITE;
/*!40000 ALTER TABLE `contact_methods` DISABLE KEYS */;
INSERT INTO `contact_methods` VALUES (1,1,'email','yunita68@example.com',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(2,1,'linkedin','https://linkedin.com/in/drajatjindraprasetyos.e.i',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(3,2,'instagram','@karsana_pranowo_m.m.',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(4,3,'linkedin','https://linkedin.com/in/idanasyidah',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(5,3,'phone','(+62) 588 8585 079',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(6,3,'email','gpuspasari@example.com',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(7,4,'linkedin','https://linkedin.com/in/salimahzahrawahyunis.t.',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(8,5,'linkedin','https://linkedin.com/in/bahuwiryafirgantoro',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(9,5,'phone','0907 4001 583',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(10,5,'email','nashiruddin.aurora@example.net',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(11,6,'phone','0892 9430 1340',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(12,6,'email','csimanjuntak@example.com',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(13,7,'instagram','@dadi_firmansyah',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(14,7,'linkedin','https://linkedin.com/in/dadifirmansyah',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(15,8,'phone','(+62) 28 4774 5449',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(16,8,'instagram','@prayitna_pratama',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(17,8,'linkedin','https://linkedin.com/in/prayitnapratama',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(18,9,'linkedin','https://linkedin.com/in/elmazulaikam.pd',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(19,9,'instagram','@elma_zulaika_m.pd',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(20,9,'email','ina.jailani@example.com',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(21,10,'phone','0316 5563 476',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(22,10,'email','pradana.nadia@example.org',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(23,10,'linkedin','https://linkedin.com/in/adikaghaniprayoga',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(24,11,'instagram','@padmi_ratna_susanti',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(25,11,'email','hassanah.vicky@example.org',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(26,12,'instagram','@uchita_pudjiastuti_m.m.',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(27,12,'phone','(+62) 776 4074 5680',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(28,12,'linkedin','https://linkedin.com/in/uchitapudjiastutim.m.',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(29,13,'email','jfirgantoro@example.com',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(30,14,'email','sudiati.wakiman@example.org',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(31,14,'instagram','@rachel_mardhiyah_s.sos',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(32,15,'email','januar.genta@example.com',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(33,15,'linkedin','https://linkedin.com/in/artatampubolon',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(34,15,'phone','0415 9308 661',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(35,16,'email','jarwi.puspasari@example.org',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(36,16,'instagram','@gada_saptono',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(37,17,'linkedin','https://linkedin.com/in/rahmijulimandasari',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(38,17,'email','ppalastri@example.net',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(39,18,'phone','(+62) 343 1112 5043',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(40,19,'phone','0649 3583 3253',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(41,20,'phone','(+62) 466 5890 0117',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(42,20,'linkedin','https://linkedin.com/in/claraoktaviani',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(43,20,'instagram','@clara_oktaviani',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(44,21,'email','chutapea@example.net',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(45,21,'phone','0527 6354 112',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(46,22,'linkedin','https://linkedin.com/in/aniwahyunis.e.',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(47,22,'phone','0254 1346 5943',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(48,23,'phone','(+62) 320 9171 701',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(49,23,'linkedin','https://linkedin.com/in/rinilaksmiwati',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(50,23,'email','maryadi24@example.com',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(51,24,'linkedin','https://linkedin.com/in/windaandriani',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(52,25,'instagram','@ratna_wijayanti',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(53,25,'linkedin','https://linkedin.com/in/ratnawijayanti',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(54,25,'email','rahmawati.daruna@example.com',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(55,26,'email','tugiman81@example.net',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(56,27,'linkedin','https://linkedin.com/in/prabawasabarsitompul',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(57,28,'email','hnugroho@example.net',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(58,29,'email','lidya16@example.org',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(59,29,'linkedin','https://linkedin.com/in/niyagawasitam.pd',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(60,29,'phone','0627 8452 7975',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(61,30,'email','novitasari.cornelia@example.net',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(62,30,'phone','0235 4023 346',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(63,30,'linkedin','https://linkedin.com/in/raihanhasimsuwarnos.ked',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(64,31,'email','salimah16@example.org',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(65,31,'phone','0777 1269 9401',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(66,31,'linkedin','https://linkedin.com/in/mariazalindrapratiwis.ked',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(67,32,'phone','(+62) 488 1370 012',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(68,33,'linkedin','https://linkedin.com/in/balapatisantosos.kom',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(69,34,'email','atmaja73@example.net',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(70,34,'phone','0509 7126 250',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(71,34,'linkedin','https://linkedin.com/in/embuhdamanik',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(72,35,'email','handayani.ajimin@example.org',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(73,35,'linkedin','https://linkedin.com/in/galarkartagunawans.ked',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(74,35,'phone','0738 8469 7917',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(75,36,'phone','(+62) 878 573 184',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(76,36,'linkedin','https://linkedin.com/in/bakiadidabukke',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(77,36,'email','amalia64@example.org',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(78,37,'phone','0296 0087 897',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(79,37,'linkedin','https://linkedin.com/in/dadipurwadimansur',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(80,37,'instagram','@dadi_purwadi_mansur',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(81,38,'instagram','@chelsea_zelda_yulianti',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(82,38,'linkedin','https://linkedin.com/in/chelseazeldayulianti',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(83,39,'email','suwais@example.net',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(84,40,'phone','0467 5621 222',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(85,40,'email','kusmawati.faizah@example.com',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(86,40,'instagram','@nasrullah_tedi_mangunsong_s.ip',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(87,41,'phone','(+62) 678 8513 664',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(88,41,'instagram','@prima_ade_pratama_s.h.',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(89,42,'phone','0515 3636 416',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(90,42,'email','yhakim@example.org',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(91,42,'linkedin','https://linkedin.com/in/asmunipradipta',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(92,43,'linkedin','https://linkedin.com/in/ameliaaryani',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(93,43,'phone','(+62) 749 6944 645',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(94,44,'instagram','@diah_pertiwi',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(95,44,'linkedin','https://linkedin.com/in/diahpertiwi',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(96,45,'instagram','@murti_marbun',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(97,45,'linkedin','https://linkedin.com/in/murtimarbun',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(98,46,'phone','(+62) 753 1638 041',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(99,47,'linkedin','https://linkedin.com/in/asmadijailani',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(100,47,'instagram','@asmadi_jailani',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(101,47,'email','nwahyuni@example.com',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(102,48,'phone','(+62) 346 0094 746',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(103,49,'email','oktaviani.ganda@example.com',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(104,49,'linkedin','https://linkedin.com/in/clarakuswandaris.psi',0,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(105,50,'email','gangsar.setiawan@example.org',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL);
/*!40000 ALTER TABLE `contact_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departments` (
  `department_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `department_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faculty_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`department_id`),
  KEY `departments_faculty_id_index` (`faculty_id`),
  CONSTRAINT `departments_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`faculty_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'Teknik Informatika',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(2,'Ilmu Komputer',2,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(3,'Sistem Informasi',2,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(4,'Teknik Informatika',3,'2025-10-04 02:04:19','2025-10-04 07:31:01','2025-10-04 07:31:01'),(5,'Teknik Informatika',4,'2025-10-04 02:04:19','2025-10-04 07:31:01','2025-10-04 07:31:01');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `education_histories`
--

DROP TABLE IF EXISTS `education_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `education_histories` (
  `education_history_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `alumni_id` bigint unsigned NOT NULL,
  `program_id` bigint unsigned DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `gpa` decimal(3,2) DEFAULT NULL,
  `thesis_title` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`education_history_id`),
  KEY `education_histories_alumni_id_index` (`alumni_id`),
  KEY `education_histories_program_id_index` (`program_id`),
  KEY `education_histories_start_date_end_date_index` (`start_date`,`end_date`),
  CONSTRAINT `education_histories_alumni_id_foreign` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`alumni_id`) ON DELETE CASCADE,
  CONSTRAINT `education_histories_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`program_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `education_histories`
--

LOCK TABLES `education_histories` WRITE;
/*!40000 ALTER TABLE `education_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `education_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employers`
--

DROP TABLE IF EXISTS `employers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employers` (
  `employer_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `employer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `industry_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`employer_id`),
  KEY `employers_industry_type_index` (`industry_type`),
  KEY `employers_address_id_index` (`address_id`),
  CONSTRAINT `employers_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`address_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employers`
--

LOCK TABLES `employers` WRITE;
/*!40000 ALTER TABLE `employers` DISABLE KEYS */;
INSERT INTO `employers` VALUES (1,'PT Gojek Indonesia','Technology',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(2,'PT Tokopedia','E-commerce',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(3,'PT Shopee International Indonesia','E-commerce',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(4,'PT Bank Central Asia Tbk','Banking',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(5,'PT Bank Mandiri (Persero) Tbk','Banking',NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL);
/*!40000 ALTER TABLE `employers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employment_histories`
--

DROP TABLE IF EXISTS `employment_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employment_histories` (
  `employment_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `alumni_id` bigint unsigned NOT NULL,
  `employer_id` bigint unsigned DEFAULT NULL,
  `job_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `salary_range` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contract_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employment_status` enum('employed','unemployed','studying','entrepreneur') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'employed',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `job_description` text COLLATE utf8mb4_unicode_ci,
  `company_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `institution_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `study_level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `major` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`employment_id`),
  KEY `employment_histories_alumni_id_index` (`alumni_id`),
  KEY `employment_histories_employer_id_index` (`employer_id`),
  KEY `employment_histories_start_date_end_date_index` (`start_date`,`end_date`),
  KEY `employment_histories_job_level_index` (`job_level`),
  KEY `employment_histories_contract_type_index` (`contract_type`),
  CONSTRAINT `employment_histories_alumni_id_foreign` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`alumni_id`) ON DELETE CASCADE,
  CONSTRAINT `employment_histories_employer_id_foreign` FOREIGN KEY (`employer_id`) REFERENCES `employers` (`employer_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employment_histories`
--

LOCK TABLES `employment_histories` WRITE;
/*!40000 ALTER TABLE `employment_histories` DISABLE KEYS */;
INSERT INTO `employment_histories` VALUES (1,9,2,'Data Analyst','UD Simanjuntak (Persero) Tbk','junior','2024-04-18','2025-06-15','15-20 juta','freelance','entrepreneur',0,'Porro et quia iste distinctio aliquid asperiores vel perspiciatis itaque praesentium veritatis dolore.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(2,11,2,'Technical Writer','Fa Yulianti Suryatmi (Persero) Tbk','lead','2023-12-16',NULL,'15-20 juta','freelance','entrepreneur',1,'Nobis ut ut accusamus ducimus eligendi voluptatem recusandae.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(3,19,2,'System Administrator','UD Wijaya Astuti','lead','2022-11-06','2024-12-17','5-10 juta','part_time','entrepreneur',0,'Qui et dolorem quis soluta excepturi pariatur corporis voluptas hic voluptatem.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(4,31,2,'Sales Executive','PJ Hartati Prasetya Tbk','entry','2023-02-25','2023-07-31','< 5 juta','internship','studying',0,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(5,39,4,'Graphic Designer','Perum Melani (Persero) Tbk','lead','2025-05-22','2025-08-01','> 20 juta','full_time','entrepreneur',0,'Consequatur perspiciatis non ab et nam dolore vel qui quisquam aliquid.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(6,40,1,'IT Support','Yayasan Thamrin (Persero) Tbk','junior','2025-06-28',NULL,'< 5 juta','internship','studying',1,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(7,47,1,'Project Manager','PJ Yuniar Novitasari','senior','2022-12-12',NULL,'15-20 juta','full_time','employed',1,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(8,1,3,'System Administrator','Perum Siregar','lead','2024-03-19',NULL,'15-20 juta','contract','employed',1,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(9,3,1,'Senior Software Engineer','Fa Hartati Suartini','junior','2025-01-05',NULL,'5-10 juta','contract','unemployed',1,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(10,12,1,'Full Stack Developer','Fa Pranowo Tbk','lead','2025-02-01','2025-04-27','15-20 juta','internship','studying',0,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(11,20,5,'Full Stack Developer','CV Oktaviani Usada','lead','2023-09-05','2025-10-02','15-20 juta','part_time','studying',0,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(12,28,2,'Frontend Developer','Perum Latupono Hasanah Tbk','entry','2024-06-11',NULL,'15-20 juta','full_time','employed',1,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(13,32,4,'System Administrator','PJ Kuswoyo Tbk','manager','2022-12-07','2024-10-18','> 20 juta','part_time','entrepreneur',0,'Aliquid praesentium deleniti asperiores adipisci omnis aut.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(14,35,4,'Backend Developer','Yayasan Nashiruddin (Persero) Tbk','senior','2025-06-02','2025-08-25','5-10 juta','contract','unemployed',0,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(15,37,1,'Technical Writer','Fa Firgantoro Prasetya','senior','2023-01-17',NULL,'< 5 juta','contract','studying',1,'Incidunt qui deleniti eum qui sit temporibus iure magnam iure nihil veritatis reprehenderit excepturi.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(16,42,3,'Sales Executive','CV Siregar','senior','2024-11-21','2025-01-01','> 20 juta','contract','studying',0,'Doloribus possimus excepturi at optio sed deserunt voluptatem suscipit eos cupiditate.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(17,43,4,'Sales Executive','PJ Kuswandari','manager','2023-09-12',NULL,'5-10 juta','internship','studying',1,'Qui dolor quidem nemo non pariatur voluptatem sequi consequatur dignissimos eum voluptas nulla numquam expedita.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(18,48,5,'Quality Assurance Engineer','PJ Wulandari Safitri Tbk','junior','2025-07-16',NULL,'10-15 juta','freelance','entrepreneur',1,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(19,2,4,'Digital Marketing Specialist','CV Mahendra','mid','2025-03-29',NULL,'5-10 juta','full_time','studying',1,'Facere reprehenderit est aliquam nobis eligendi dolores eveniet numquam possimus ipsum.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(20,10,3,'Cybersecurity Analyst','UD Riyanti','junior','2022-12-13','2025-10-02','< 5 juta','freelance','employed',0,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(21,13,3,'Backend Developer','UD Ardianto Wastuti (Persero) Tbk','manager','2024-12-01','2025-05-26','15-20 juta','part_time','employed',0,'Ut autem et aut iure consectetur suscipit ut earum ea praesentium voluptatem quos.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(22,26,4,'Project Manager','Yayasan Suartini Uwais','junior','2023-01-20','2024-07-17','> 20 juta','internship','entrepreneur',0,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(23,45,1,'Cybersecurity Analyst','Yayasan Uwais Tbk','entry','2023-07-06',NULL,'10-15 juta','full_time','entrepreneur',1,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(24,5,4,'IT Support','Perum Santoso Marpaung','lead','2024-03-08',NULL,'< 5 juta','freelance','entrepreneur',1,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(25,7,3,'Backend Developer','Yayasan Haryanto (Persero) Tbk','mid','2023-04-29',NULL,'10-15 juta','freelance','unemployed',1,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(26,17,3,'System Administrator','Fa Wibowo Wasita','junior','2024-02-21','2025-01-24','5-10 juta','contract','unemployed',0,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(27,18,5,'Software Engineer','UD Safitri Hassanah (Persero) Tbk','manager','2023-06-17','2024-09-20','> 20 juta','part_time','studying',0,'Occaecati officiis aut iste nam est earum accusamus aperiam.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(28,21,4,'Senior Software Engineer','PD Hutapea Kurniawan','lead','2024-10-11',NULL,'15-20 juta','freelance','unemployed',1,'Ipsum dolore sit exercitationem ullam consequatur voluptatem animi omnis eum maxime quidem.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(29,22,3,'Digital Marketing Specialist','Fa Suwarno Tbk','senior','2024-02-09','2024-04-19','< 5 juta','part_time','entrepreneur',0,'Sit aut aliquam dicta aliquid dicta ex totam.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(30,23,3,'Technical Writer','PD Simanjuntak (Persero) Tbk','entry','2023-10-07','2025-03-16','10-15 juta','internship','entrepreneur',0,'Velit incidunt quia possimus sint eaque sed.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(31,36,5,'Digital Marketing Specialist','PJ Marpaung Laksita','entry','2024-12-27',NULL,'15-20 juta','freelance','studying',1,'Ea rerum aut hic occaecati soluta facere ratione.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(32,38,3,'Senior Software Engineer','UD Mahendra Yolanda (Persero) Tbk','senior','2022-10-05',NULL,'15-20 juta','internship','unemployed',1,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(33,44,2,'Data Scientist','PJ Rahayu (Persero) Tbk','manager','2025-05-06','2025-08-12','10-15 juta','contract','employed',0,'Aut quo quidem aliquam laborum ad provident distinctio et expedita facere ea voluptas corrupti tenetur.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(34,46,1,'Technical Writer','Perum Pratiwi Simanjuntak','junior','2025-08-08','2025-09-19','< 5 juta','contract','employed',0,'Laboriosam qui voluptatem temporibus assumenda et incidunt et maiores similique esse ducimus totam sed.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(35,50,3,'Graphic Designer','PT Sihombing','mid','2024-09-17','2024-10-06','< 5 juta','full_time','entrepreneur',0,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(36,4,2,'Backend Developer','CV Utama (Persero) Tbk','mid','2024-08-17','2025-08-30','10-15 juta','contract','entrepreneur',0,'Saepe nostrum nihil eaque sit et expedita itaque neque doloremque.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(37,6,4,'Data Scientist','Perum Saptono Rahayu','mid','2025-02-21','2025-06-23','> 20 juta','contract','entrepreneur',0,'Et voluptatem atque aut et voluptas voluptas aut voluptates sit cum omnis et qui.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(38,15,4,'Project Manager','PJ Lazuardi','senior','2022-12-17','2024-08-03','10-15 juta','freelance','unemployed',0,'Dolor non soluta id architecto aliquam in esse porro ut neque iste repellat.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(39,16,4,'Software Engineer','PD Ardianto Hasanah Tbk','senior','2024-06-08',NULL,'< 5 juta','contract','entrepreneur',1,'Aspernatur deleniti provident omnis id reiciendis rem quod eum.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(40,24,5,'Machine Learning Engineer','PJ Yolanda (Persero) Tbk','manager','2024-12-30','2025-08-17','< 5 juta','part_time','studying',0,'Qui sed et exercitationem quos dolorum quia quas nisi quis cum debitis saepe qui.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(41,25,4,'IT Support','PD Fujiati','manager','2023-03-08',NULL,'10-15 juta','full_time','entrepreneur',1,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(42,29,3,'Frontend Developer','PT Saefullah Tbk','junior','2025-03-18',NULL,'10-15 juta','internship','unemployed',1,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(43,33,5,'Cloud Engineer','Yayasan Widodo Novitasari','entry','2024-02-25',NULL,'> 20 juta','contract','entrepreneur',1,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(44,34,1,'UI/UX Designer','PT Tampubolon','entry','2024-02-09','2024-12-06','5-10 juta','full_time','employed',0,NULL,NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(45,41,4,'Product Manager','Perum Purnawati','mid','2023-07-23','2024-05-04','10-15 juta','internship','studying',0,'Perspiciatis animi sint enim suscipit dolorum qui et veritatis pariatur placeat.',NULL,NULL,NULL,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(46,51,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'unemployed',1,NULL,NULL,NULL,NULL,NULL,'2025-10-04 07:19:31','2025-10-04 07:19:34','2025-10-04 07:19:34'),(47,51,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'unemployed',1,NULL,NULL,NULL,NULL,NULL,'2025-10-04 07:19:56','2025-10-04 07:19:59','2025-10-04 07:19:59'),(48,51,3,'Software Engginer',NULL,'entry',NULL,NULL,NULL,'full_time','employed',1,NULL,NULL,NULL,NULL,NULL,'2025-10-04 07:20:38','2025-10-04 07:20:38',NULL);
/*!40000 ALTER TABLE `employment_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faculties`
--

DROP TABLE IF EXISTS `faculties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faculties` (
  `faculty_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `faculty_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `campus_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`faculty_id`),
  KEY `faculties_campus_id_index` (`campus_id`),
  CONSTRAINT `faculties_campus_id_foreign` FOREIGN KEY (`campus_id`) REFERENCES `campuses` (`campus_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faculties`
--

LOCK TABLES `faculties` WRITE;
/*!40000 ALTER TABLE `faculties` DISABLE KEYS */;
INSERT INTO `faculties` VALUES (1,'Fakultas Teknik',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(2,'Fakultas Ilmu Komputer',1,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(3,'Sekolah Teknik Elektro dan Informatika',2,'2025-10-04 02:04:19','2025-10-04 07:30:51','2025-10-04 07:30:51'),(4,'Fakultas Teknik',3,'2025-10-04 02:04:19','2025-10-04 07:30:51','2025-10-04 07:30:51'),(5,'Fakultas Teknologi Elektro dan Informatika Cerdas',4,'2025-10-04 02:04:19','2025-10-04 07:30:51','2025-10-04 07:30:51');
/*!40000 ALTER TABLE `faculties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_09_30_100535_create_alumni_table',1),(5,'2025_09_30_102449_create_addresses_table',1),(6,'2025_09_30_102523_create_contact_methods_table',1),(7,'2025_09_30_102553_create_campuses_table',1),(8,'2025_09_30_102605_create_faculties_table',1),(9,'2025_09_30_102618_create_departments_table',1),(10,'2025_09_30_102631_create_programs_table',1),(11,'2025_09_30_102647_create_education_histories_table',1),(12,'2025_09_30_102705_create_employers_table',1),(13,'2025_09_30_102720_create_employment_histories_table',1),(14,'2025_09_30_102739_create_tracer_study_sessions_table',1),(15,'2025_09_30_102755_create_survey_questions_table',1),(16,'2025_09_30_102756_create_survey_responses_table',1),(17,'2025_09_30_102757_create_survey_options_table',1),(18,'2025_09_30_102802_create_answers_table',1),(19,'2025_09_30_102852_create_skills_table',1),(20,'2025_09_30_102853_create_training_courses_table',1),(21,'2025_09_30_102854_create_alumni_skills_table',1),(22,'2025_09_30_102901_create_alumni_trainings_table',1),(23,'2025_09_30_102902_create_administrators_table',1),(24,'2025_09_30_102955_create_activity_logs_table',1),(25,'2025_09_30_103018_add_foreign_keys_to_alumni_table',1),(26,'2025_09_30_103049_add_partitioning_to_survey_responses_table',1),(27,'2025_09_30_152457_update_contact_methods_table_add_more_contact_types',1),(28,'2025_09_30_154345_make_employer_id_nullable_in_employment_histories_table',1),(29,'2025_09_30_154940_make_program_id_nullable_in_education_histories_table',1),(30,'2025_09_30_160000_add_company_name_to_employment_histories_table',1),(31,'2025_09_30_160756_update_job_level_enum_in_employment_histories_table',1),(32,'2025_09_30_175742_remove_company_name_from_employment_histories_table',1),(33,'2025_10_01_012728_create_reports_table',1),(34,'2025_10_01_021328_add_file_columns_to_reports_table',1),(35,'2025_10_01_061403_add_auth_fields_to_alumni_table',1),(36,'2025_10_03_140021_add_district_village_to_addresses_table',1),(37,'2025_10_03_143838_add_additional_columns_to_employment_histories_table',1),(38,'2025_10_03_150340_update_employment_histories_table_remove_dates_add_new_fields',1),(39,'2025_10_03_151905_make_employment_columns_nullable',1),(40,'2025_10_03_153517_add_is_active_to_employment_histories',1),(41,'2025_10_04_062834_create_permission_tables',1),(42,'2025_10_04_141825_make_dates_nullable_in_employment_histories_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(3,'App\\Models\\User',2),(5,'App\\Models\\User',3);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=304 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'view_any_dashboard','web','2025-10-04 02:04:18','2025-10-04 02:04:18'),(2,'access_admin_panel','web','2025-10-04 02:04:18','2025-10-04 02:04:18'),(3,'view_any_alumni','web','2025-10-04 07:32:57','2025-10-04 07:32:57'),(4,'view_alumni','web','2025-10-04 07:32:57','2025-10-04 07:32:57'),(5,'view_any_department','web','2025-10-04 07:32:57','2025-10-04 07:32:57'),(6,'view_department','web','2025-10-04 07:32:57','2025-10-04 07:32:57'),(7,'view_any_employer','web','2025-10-04 07:32:57','2025-10-04 07:32:57'),(8,'view_employer','web','2025-10-04 07:32:57','2025-10-04 07:32:57'),(9,'view_any_employment_history','web','2025-10-04 07:32:57','2025-10-04 07:32:57'),(10,'view_employment_history','web','2025-10-04 07:32:57','2025-10-04 07:32:57'),(11,'view_any_faculty','web','2025-10-04 07:32:57','2025-10-04 07:32:57'),(12,'view_faculty','web','2025-10-04 07:32:57','2025-10-04 07:32:57'),(13,'view_any_program','web','2025-10-04 07:32:57','2025-10-04 07:32:57'),(14,'view_program','web','2025-10-04 07:32:57','2025-10-04 07:32:57'),(15,'view_any_survey_question','web','2025-10-04 07:32:57','2025-10-04 07:32:57'),(16,'view_survey_question','web','2025-10-04 07:32:57','2025-10-04 07:32:57'),(17,'view_any_survey_response','web','2025-10-04 07:32:57','2025-10-04 07:32:57'),(18,'view_survey_response','web','2025-10-04 07:32:57','2025-10-04 07:32:57'),(19,'view_any_tracer_study_session','web','2025-10-04 07:32:57','2025-10-04 07:32:57'),(20,'view_tracer_study_session','web','2025-10-04 07:32:57','2025-10-04 07:32:57'),(21,'create_alumni','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(22,'update_alumni','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(23,'delete_alumni','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(24,'delete_any_alumni','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(25,'force_delete_alumni','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(26,'force_delete_any_alumni','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(27,'restore_alumni','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(28,'restore_any_alumni','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(29,'replicate_alumni','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(30,'view_campus','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(31,'view_any_campus','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(32,'create_campus','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(33,'update_campus','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(34,'delete_campus','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(35,'delete_any_campus','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(36,'force_delete_campus','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(37,'force_delete_any_campus','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(38,'restore_campus','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(39,'restore_any_campus','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(40,'replicate_campus','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(41,'create_department','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(42,'update_department','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(43,'delete_department','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(44,'delete_any_department','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(45,'force_delete_department','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(46,'force_delete_any_department','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(47,'restore_department','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(48,'restore_any_department','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(49,'replicate_department','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(50,'create_faculty','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(51,'update_faculty','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(52,'delete_faculty','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(53,'delete_any_faculty','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(54,'force_delete_faculty','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(55,'force_delete_any_faculty','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(56,'restore_faculty','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(57,'restore_any_faculty','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(58,'replicate_faculty','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(59,'create_program','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(60,'update_program','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(61,'delete_program','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(62,'delete_any_program','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(63,'force_delete_program','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(64,'force_delete_any_program','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(65,'restore_program','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(66,'restore_any_program','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(67,'replicate_program','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(68,'create_employer','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(69,'update_employer','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(70,'delete_employer','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(71,'delete_any_employer','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(72,'force_delete_employer','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(73,'force_delete_any_employer','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(74,'restore_employer','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(75,'restore_any_employer','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(76,'replicate_employer','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(77,'view_employment','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(78,'view_any_employment','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(79,'create_employment','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(80,'update_employment','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(81,'delete_employment','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(82,'delete_any_employment','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(83,'force_delete_employment','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(84,'force_delete_any_employment','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(85,'restore_employment','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(86,'restore_any_employment','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(87,'replicate_employment','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(88,'create_survey_question','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(89,'update_survey_question','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(90,'delete_survey_question','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(91,'delete_any_survey_question','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(92,'force_delete_survey_question','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(93,'force_delete_any_survey_question','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(94,'restore_survey_question','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(95,'restore_any_survey_question','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(96,'replicate_survey_question','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(97,'create_survey_response','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(98,'update_survey_response','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(99,'delete_survey_response','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(100,'delete_any_survey_response','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(101,'force_delete_survey_response','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(102,'force_delete_any_survey_response','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(103,'restore_survey_response','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(104,'restore_any_survey_response','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(105,'replicate_survey_response','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(106,'create_tracer_study_session','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(107,'update_tracer_study_session','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(108,'delete_tracer_study_session','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(109,'delete_any_tracer_study_session','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(110,'force_delete_tracer_study_session','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(111,'force_delete_any_tracer_study_session','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(112,'restore_tracer_study_session','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(113,'restore_any_tracer_study_session','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(114,'replicate_tracer_study_session','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(115,'view_report','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(116,'view_any_report','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(117,'create_report','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(118,'update_report','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(119,'delete_report','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(120,'delete_any_report','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(121,'force_delete_report','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(122,'force_delete_any_report','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(123,'restore_report','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(124,'restore_any_report','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(125,'replicate_report','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(126,'view_role','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(127,'view_any_role','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(128,'create_role','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(129,'update_role','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(130,'delete_role','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(131,'delete_any_role','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(132,'force_delete_role','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(133,'force_delete_any_role','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(134,'restore_role','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(135,'restore_any_role','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(136,'replicate_role','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(137,'view_user','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(138,'view_any_user','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(139,'create_user','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(140,'update_user','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(141,'delete_user','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(142,'delete_any_user','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(143,'force_delete_user','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(144,'force_delete_any_user','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(145,'restore_user','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(146,'restore_any_user','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(147,'replicate_user','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(148,'page_Dashboard','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(149,'widget_TracerStudyOverviewWidget','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(150,'widget_AlumniEmploymentStatsWidget','web','2025-10-04 07:38:20','2025-10-04 07:38:20'),(151,'widget_AlumniTrendChartWidget','web','2025-10-04 07:38:20','2025-10-04 07:38:20');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programs`
--

DROP TABLE IF EXISTS `programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `programs` (
  `program_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `program_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` bigint unsigned NOT NULL,
  `accreditation_status` enum('A','B','C','Unggul','Baik Sekali','Baik') COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_year` int NOT NULL,
  `end_year` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`program_id`),
  KEY `programs_department_id_index` (`department_id`),
  KEY `programs_start_year_end_year_index` (`start_year`,`end_year`),
  CONSTRAINT `programs_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programs`
--

LOCK TABLES `programs` WRITE;
/*!40000 ALTER TABLE `programs` DISABLE KEYS */;
INSERT INTO `programs` VALUES (1,'S1 Teknik Informatika',1,'A',2010,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(2,'S1 Ilmu Komputer',2,'A',2005,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(3,'S1 Sistem Informasi',3,'B',2015,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(4,'S2 Ilmu Komputer',2,'A',2008,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(5,'S1 Teknik Informatika',4,'Unggul',2000,NULL,'2025-10-04 02:04:19','2025-10-04 07:31:09','2025-10-04 07:31:09');
/*!40000 ALTER TABLE `programs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reports` (
  `report_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_type` enum('employment_statistics','waiting_period','job_relevance','salary_analysis','geographic_distribution','satisfaction_survey','response_rate','alumni_tracking','competency_analysis','ban_pt_standard') COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_id` bigint unsigned DEFAULT NULL,
  `parameters` json DEFAULT NULL,
  `status` enum('pending','generating','completed','failed','expired') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_format` enum('pdf','excel','csv') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pdf',
  `generated_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`report_id`),
  KEY `reports_session_id_foreign` (`session_id`),
  KEY `reports_status_created_at_index` (`status`,`created_at`),
  KEY `reports_report_type_session_id_index` (`report_type`,`session_id`),
  KEY `reports_expires_at_index` (`expires_at`),
  KEY `reports_report_type_index` (`report_type`),
  KEY `reports_status_index` (`status`),
  CONSTRAINT `reports_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `tracer_study_sessions` (`session_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(22,1),(23,1),(24,1),(25,1),(26,1),(27,1),(28,1),(29,1),(30,1),(31,1),(32,1),(33,1),(34,1),(35,1),(36,1),(37,1),(38,1),(39,1),(40,1),(41,1),(42,1),(43,1),(44,1),(45,1),(46,1),(47,1),(48,1),(49,1),(50,1),(51,1),(52,1),(53,1),(54,1),(55,1),(56,1),(57,1),(58,1),(59,1),(60,1),(61,1),(62,1),(63,1),(64,1),(65,1),(66,1),(67,1),(68,1),(69,1),(70,1),(71,1),(72,1),(73,1),(74,1),(75,1),(76,1),(77,1),(78,1),(79,1),(80,1),(81,1),(82,1),(83,1),(84,1),(85,1),(86,1),(87,1),(88,1),(89,1),(90,1),(91,1),(92,1),(93,1),(94,1),(95,1),(96,1),(97,1),(98,1),(99,1),(100,1),(101,1),(102,1),(103,1),(104,1),(105,1),(106,1),(107,1),(108,1),(109,1),(110,1),(111,1),(112,1),(113,1),(114,1),(115,1),(116,1),(117,1),(118,1),(119,1),(120,1),(121,1),(122,1),(123,1),(124,1),(125,1),(126,1),(127,1),(128,1),(129,1),(130,1),(131,1),(132,1),(133,1),(134,1),(135,1),(136,1),(137,1),(138,1),(139,1),(140,1),(141,1),(142,1),(143,1),(144,1),(145,1),(146,1),(147,1),(148,1),(149,1),(150,1),(151,1),(1,2),(2,2),(1,3),(3,3),(4,3),(5,3),(6,3),(7,3),(8,3),(9,3),(10,3),(11,3),(12,3),(13,3),(14,3),(15,3),(16,3),(17,3),(18,3),(19,3),(20,3),(21,3),(22,3),(30,3),(31,3),(32,3),(33,3),(41,3),(42,3),(50,3),(51,3),(59,3),(60,3),(68,3),(69,3),(77,3),(78,3),(79,3),(80,3),(88,3),(89,3),(97,3),(98,3),(106,3),(107,3),(115,3),(116,3),(117,3),(118,3),(126,3),(127,3),(128,3),(129,3),(137,3),(138,3),(139,3),(140,3),(148,3),(149,3),(150,3),(151,3),(3,5),(4,5),(5,5),(6,5),(7,5),(8,5),(9,5),(10,5),(11,5),(12,5),(13,5),(14,5),(15,5),(16,5),(17,5),(18,5),(19,5),(20,5);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'super_admin','web','2025-10-04 02:04:18','2025-10-04 02:04:18'),(2,'panel_user','web','2025-10-04 02:04:18','2025-10-04 02:04:18'),(3,'staff','web','2025-10-04 02:04:18','2025-10-04 02:04:18'),(5,'viewer','web','2025-10-04 08:05:38','2025-10-04 08:05:38');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('qtcRDnZQcVrzWjws3NK4ae8cuAQzYDXAeXNw1y4B',3,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoidUNSU0dOY2lobE5uMlQyc00yaTM2QU03bHlYWXNxZ2dZYnh5N3hNNCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9lbXBsb3llcnMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTIkMXN5RkY4aHJyQ0o1RjZnZlBUS0Z0dThocVNEUS9HajNBRnl1amI4QWovamRxWnNPS0lHM3kiO3M6NjoidGFibGVzIjthOjM6e3M6NDA6ImEzZTIwMDRmYzUyODJjMDJlYTYxZTk1MjIzNzgyOTVlX2NvbHVtbnMiO2E6MTM6e2k6MDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMDoic3R1ZGVudF9pZCI7czo1OiJsYWJlbCI7czoxMDoiU3R1ZGVudCBJRCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6NDoibmFtZSI7czo1OiJsYWJlbCI7czoxMToiTmFtYSBBbHVtbmkiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjIwOiJwcm9ncmFtLnByb2dyYW1fbmFtZSI7czo1OiJsYWJlbCI7czoxMzoiUHJvZ3JhbSBTdHVkaSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjA7fWk6MzthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxNToiZ3JhZHVhdGlvbl95ZWFyIjtzOjU6ImxhYmVsIjtzOjU6Ikx1bHVzIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NDthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czozOiJncGEiO3M6NToibGFiZWwiO3M6MzoiSVBLIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NTthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo2OiJnZW5kZXIiO3M6NToibGFiZWwiO3M6NjoiR2VuZGVyIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9aTo2O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjU6InBob25lIjtzOjU6ImxhYmVsIjtzOjc6IlRlbGVwb24iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjowO31pOjc7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTc6ImVtcGxveW1lbnRfc3RhdHVzIjtzOjU6ImxhYmVsIjtzOjE2OiJTdGF0dXMgUGVrZXJqYWFuIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MDt9aTo4O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEzOiJzdXJ2ZXlfc3RhdHVzIjtzOjU6ImxhYmVsIjtzOjEzOiJTdGF0dXMgU3VydmV5IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MDt9aTo5O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEyOiJhZGRyZXNzLmNpdHkiO3M6NToibGFiZWwiO3M6NDoiS290YSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjA7fWk6MTA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTY6ImFkZHJlc3MucHJvdmluY2UiO3M6NToibGFiZWwiO3M6ODoiUHJvdmluc2kiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO31pOjExO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJjcmVhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjY6IkRpYnVhdCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjA7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjE7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtiOjE7fWk6MTI7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6InVwZGF0ZWRfYXQiO3M6NToibGFiZWwiO3M6MTA6IkRpcGVyYmFydWkiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjowO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjoxO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7YjoxO319czo0MDoiOThkZTFmMGY1N2ZmZmE2NzdhN2M1NjNiNjc1YjcwZmFfY29sdW1ucyI7YTo5OntpOjA7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTE6ImFsdW1uaS5uYW1lIjtzOjU6ImxhYmVsIjtzOjY6IkFsdW1uaSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjE7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6OToiam9iX3RpdGxlIjtzOjU6ImxhYmVsIjtzOjc6IkphYmF0YW4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToyO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjk6ImpvYl9sZXZlbCI7czo1OiJsYWJlbCI7czo1OiJMZXZlbCI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjM7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTM6ImNvbnRyYWN0X3R5cGUiO3M6NToibGFiZWwiO3M6NzoiS29udHJhayI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MjI6ImVtcGxveWVyLmluZHVzdHJ5X3R5cGUiO3M6NToibGFiZWwiO3M6ODoiSW5kdXN0cmkiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjE3OiJlbXBsb3ltZW50X3N0YXR1cyI7czo1OiJsYWJlbCI7czoxNToiU3RhdHVzIEtlZ2lhdGFuIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6NjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czo5OiJpc19hY3RpdmUiO3M6NToibGFiZWwiO3M6MTI6IlN0YXR1cyBBa3RpZiI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjc7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6NToibGFiZWwiO3M6NjoiRGlidWF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9aTo4O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJEaXBlcmJhcnVpIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9fXM6NDA6IjA5ZDRhNzM3MmNmZTg4NjY3NzlmMmFkNDBlOGU1NTcyX2NvbHVtbnMiO2E6Njp7aTowO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEzOiJlbXBsb3llcl9uYW1lIjtzOjU6ImxhYmVsIjtzOjE1OiJOYW1hIFBlcnVzYWhhYW4iO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aToxO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEzOiJpbmR1c3RyeV90eXBlIjtzOjU6ImxhYmVsIjtzOjg6IkluZHVzdHJpIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MTtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MDtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO047fWk6MjthOjc6e3M6NDoidHlwZSI7czo2OiJjb2x1bW4iO3M6NDoibmFtZSI7czoxMjoiYWRkcmVzcy5jaXR5IjtzOjU6ImxhYmVsIjtzOjQ6IktvdGEiO3M6ODoiaXNIaWRkZW4iO2I6MDtzOjk6ImlzVG9nZ2xlZCI7YjoxO3M6MTI6ImlzVG9nZ2xlYWJsZSI7YjowO3M6MjQ6ImlzVG9nZ2xlZEhpZGRlbkJ5RGVmYXVsdCI7Tjt9aTozO2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjI2OiJlbXBsb3ltZW50X2hpc3Rvcmllc19jb3VudCI7czo1OiJsYWJlbCI7czoxMzoiSnVtbGFoIEFsdW1uaSI7czo4OiJpc0hpZGRlbiI7YjowO3M6OToiaXNUb2dnbGVkIjtiOjE7czoxMjoiaXNUb2dnbGVhYmxlIjtiOjA7czoyNDoiaXNUb2dnbGVkSGlkZGVuQnlEZWZhdWx0IjtOO31pOjQ7YTo3OntzOjQ6InR5cGUiO3M6NjoiY29sdW1uIjtzOjQ6Im5hbWUiO3M6MTA6ImNyZWF0ZWRfYXQiO3M6NToibGFiZWwiO3M6NjoiRGlidWF0IjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9aTo1O2E6Nzp7czo0OiJ0eXBlIjtzOjY6ImNvbHVtbiI7czo0OiJuYW1lIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjU6ImxhYmVsIjtzOjEwOiJEaXBlcmJhcnVpIjtzOjg6ImlzSGlkZGVuIjtiOjA7czo5OiJpc1RvZ2dsZWQiO2I6MDtzOjEyOiJpc1RvZ2dsZWFibGUiO2I6MTtzOjI0OiJpc1RvZ2dsZWRIaWRkZW5CeURlZmF1bHQiO2I6MTt9fX19',1759590901);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `skills` (
  `skill_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `skill_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `skill_category` enum('technical','soft_skill','language','certification','other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`skill_id`),
  KEY `skills_skill_category_index` (`skill_category`),
  KEY `skills_skill_name_index` (`skill_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills`
--

LOCK TABLES `skills` WRITE;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
INSERT INTO `skills` VALUES (1,'PHP Programming','technical','Server-side programming language','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(2,'Laravel Framework','technical','PHP web application framework','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(3,'JavaScript','technical','Client-side programming language','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(4,'Communication','soft_skill','Effective verbal and written communication','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(5,'Project Management','soft_skill','Planning and executing projects','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(6,'English','language','English language proficiency','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL);
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `survey_options`
--

DROP TABLE IF EXISTS `survey_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `survey_options` (
  `option_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `question_id` bigint unsigned NOT NULL,
  `option_text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` int NOT NULL DEFAULT '0',
  `display_order` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`option_id`),
  KEY `survey_options_question_id_index` (`question_id`),
  KEY `survey_options_display_order_index` (`display_order`),
  CONSTRAINT `survey_options_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `survey_questions` (`question_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_options`
--

LOCK TABLES `survey_options` WRITE;
/*!40000 ALTER TABLE `survey_options` DISABLE KEYS */;
/*!40000 ALTER TABLE `survey_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `survey_questions`
--

DROP TABLE IF EXISTS `survey_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `survey_questions` (
  `question_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `session_id` bigint unsigned NOT NULL,
  `question_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_type` enum('text','textarea','radio','checkbox','select','rating','date') COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_order` int NOT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT '0',
  `validation_rules` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`question_id`),
  KEY `survey_questions_session_id_index` (`session_id`),
  KEY `survey_questions_display_order_index` (`display_order`),
  KEY `survey_questions_question_type_index` (`question_type`),
  CONSTRAINT `survey_questions_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `tracer_study_sessions` (`session_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_questions`
--

LOCK TABLES `survey_questions` WRITE;
/*!40000 ALTER TABLE `survey_questions` DISABLE KEYS */;
INSERT INTO `survey_questions` VALUES (1,1,'Nama Lengkap','text',1,1,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(2,1,'NIM','text',2,1,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(3,1,'Tahun Lulus','text',3,1,'[]','2025-10-04 02:04:19','2025-10-04 02:10:47',NULL),(4,1,'Berapa lama waktu tunggu Anda untuk memperoleh pekerjaan pertama? (dalam bulan)','text',4,1,NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(5,1,'Seberapa erat hubungan antara bidang studi dengan pekerjaan Anda?','rating',5,1,'[]','2025-10-04 02:04:19','2025-10-04 02:12:22',NULL);
/*!40000 ALTER TABLE `survey_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `survey_responses`
--

DROP TABLE IF EXISTS `survey_responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `survey_responses` (
  `response_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `session_id` bigint unsigned NOT NULL,
  `alumni_id` bigint unsigned NOT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `completion_status` enum('draft','partial','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`response_id`),
  KEY `survey_responses_alumni_id_session_id_index` (`alumni_id`,`session_id`),
  KEY `survey_responses_session_id_index` (`session_id`),
  KEY `survey_responses_completion_status_index` (`completion_status`),
  KEY `survey_responses_submitted_at_index` (`submitted_at`),
  CONSTRAINT `survey_responses_alumni_id_foreign` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`alumni_id`) ON DELETE CASCADE,
  CONSTRAINT `survey_responses_session_id_foreign` FOREIGN KEY (`session_id`) REFERENCES `tracer_study_sessions` (`session_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_responses`
--

LOCK TABLES `survey_responses` WRITE;
/*!40000 ALTER TABLE `survey_responses` DISABLE KEYS */;
INSERT INTO `survey_responses` VALUES (1,1,42,'2025-07-16 13:20:10','completed','{\"ip_address\": \"8.7.255.248\", \"user_agent\": \"Mozilla/5.0 (iPhone; CPU iPhone OS 14_2 like Mac OS X) AppleWebKit/533.2 (KHTML, like Gecko) Version/15.0 EdgiOS/99.01141.58 Mobile/15E148 Safari/533.2\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(2,1,41,'2025-09-24 14:50:08','completed','{\"ip_address\": \"56.205.203.117\", \"user_agent\": \"Mozilla/5.0 (Windows NT 5.0) AppleWebKit/536.1 (KHTML, like Gecko) Chrome/87.0.4837.31 Safari/536.1 Edg/87.01117.12\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(3,1,37,'2025-09-29 12:15:09','completed','{\"ip_address\": \"41.215.0.243\", \"user_agent\": \"Mozilla/5.0 (Windows NT 6.2) AppleWebKit/5350 (KHTML, like Gecko) Chrome/40.0.893.0 Mobile Safari/5350\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(4,1,19,'2025-07-31 17:20:32','completed','{\"ip_address\": \"141.78.224.65\", \"user_agent\": \"Mozilla/5.0 (Windows 98; Win 9x 4.90) AppleWebKit/5361 (KHTML, like Gecko) Chrome/38.0.857.0 Mobile Safari/5361\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(5,1,45,'2025-07-27 22:14:38','completed','{\"ip_address\": \"203.170.173.240\", \"user_agent\": \"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/536.1 (KHTML, like Gecko) Chrome/90.0.4331.20 Safari/536.1 Edg/90.01118.28\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(6,1,27,NULL,'partial','{\"ip_address\": \"49.68.45.37\", \"user_agent\": \"Mozilla/5.0 (Windows NT 5.0; nl-NL; rv:1.9.0.20) Gecko/20210425 Firefox/35.0\", \"completion_percentage\": 64}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(7,1,11,NULL,'partial','{\"ip_address\": \"168.29.178.13\", \"user_agent\": \"Opera/8.72 (X11; Linux x86_64; sl-SI) Presto/2.11.265 Version/12.00\", \"completion_percentage\": 53}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(8,1,40,NULL,'partial','{\"ip_address\": \"229.132.71.150\", \"user_agent\": \"Opera/8.58 (Windows NT 5.01; en-US) Presto/2.11.333 Version/10.00\", \"completion_percentage\": 81}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(9,1,6,NULL,'partial','{\"ip_address\": \"34.178.117.5\", \"user_agent\": \"Mozilla/5.0 (X11; Linux i686) AppleWebKit/5350 (KHTML, like Gecko) Chrome/36.0.863.0 Mobile Safari/5350\", \"completion_percentage\": 45}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(10,1,29,'2025-10-02 05:19:24','completed','{\"ip_address\": \"238.121.249.21\", \"user_agent\": \"Mozilla/5.0 (Windows NT 6.0; sl-SI; rv:1.9.2.20) Gecko/20250502 Firefox/37.0\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(11,1,44,'2025-08-16 14:38:53','completed','{\"ip_address\": \"251.141.217.113\", \"user_agent\": \"Mozilla/5.0 (X11; Linux i686; rv:6.0) Gecko/20181121 Firefox/35.0\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(12,1,5,'2025-09-20 23:35:25','completed','{\"ip_address\": \"99.218.153.216\", \"user_agent\": \"Opera/8.53 (X11; Linux i686; sl-SI) Presto/2.9.168 Version/10.00\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(13,1,50,'2025-07-25 02:49:17','completed','{\"ip_address\": \"186.242.14.118\", \"user_agent\": \"Mozilla/5.0 (iPhone; CPU iPhone OS 8_0_1 like Mac OS X; en-US) AppleWebKit/533.33.6 (KHTML, like Gecko) Version/4.0.5 Mobile/8B117 Safari/6533.33.6\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(14,1,39,'2025-08-28 13:22:33','completed','{\"ip_address\": \"197.237.239.33\", \"user_agent\": \"Mozilla/5.0 (compatible; MSIE 10.0; Windows CE; Trident/3.1)\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(15,1,30,'2025-08-26 14:05:50','completed','{\"ip_address\": \"7.231.204.128\", \"user_agent\": \"Mozilla/5.0 (Macintosh; PPC Mac OS X 10_7_9 rv:3.0) Gecko/20230617 Firefox/36.0\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(16,1,7,NULL,'partial','{\"ip_address\": \"230.204.20.6\", \"user_agent\": \"Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_1) AppleWebKit/5350 (KHTML, like Gecko) Chrome/40.0.812.0 Mobile Safari/5350\", \"completion_percentage\": 70}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(17,1,25,'2025-07-28 20:44:03','completed','{\"ip_address\": \"18.81.191.2\", \"user_agent\": \"Mozilla/5.0 (Windows; U; Windows NT 4.0) AppleWebKit/532.47.4 (KHTML, like Gecko) Version/4.0.3 Safari/532.47.4\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(18,1,20,'2025-07-13 15:23:23','completed','{\"ip_address\": \"158.15.55.158\", \"user_agent\": \"Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 4.0; Trident/3.1)\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(19,1,10,'2025-07-29 00:23:55','completed','{\"ip_address\": \"245.56.49.110\", \"user_agent\": \"Mozilla/5.0 (Windows; U; Windows NT 6.1) AppleWebKit/533.14.1 (KHTML, like Gecko) Version/4.0.1 Safari/533.14.1\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(20,1,35,'2025-09-28 22:33:32','completed','{\"ip_address\": \"112.83.75.18\", \"user_agent\": \"Mozilla/5.0 (Windows; U; Windows NT 4.0) AppleWebKit/533.15.3 (KHTML, like Gecko) Version/4.1 Safari/533.15.3\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(21,1,38,'2025-09-08 15:00:50','completed','{\"ip_address\": \"200.247.161.166\", \"user_agent\": \"Mozilla/5.0 (Windows 95) AppleWebKit/5360 (KHTML, like Gecko) Chrome/36.0.875.0 Mobile Safari/5360\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(22,1,33,NULL,'partial','{\"ip_address\": \"23.161.49.96\", \"user_agent\": \"Mozilla/5.0 (Macintosh; PPC Mac OS X 10_5_1 rv:2.0) Gecko/20221221 Firefox/35.0\", \"completion_percentage\": 41}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(23,1,9,'2025-08-16 23:35:02','completed','{\"ip_address\": \"188.170.214.63\", \"user_agent\": \"Mozilla/5.0 (iPhone; CPU iPhone OS 8_1_1 like Mac OS X; sl-SI) AppleWebKit/534.8.5 (KHTML, like Gecko) Version/3.0.5 Mobile/8B114 Safari/6534.8.5\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(24,1,32,'2025-07-18 18:04:29','completed','{\"ip_address\": \"42.205.75.19\", \"user_agent\": \"Mozilla/5.0 (Windows 95; sl-SI; rv:1.9.0.20) Gecko/20250428 Firefox/36.0\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(26,1,16,NULL,'partial','{\"ip_address\": \"39.216.21.87\", \"user_agent\": \"Mozilla/5.0 (Macintosh; PPC Mac OS X 10_6_5 rv:4.0) Gecko/20230530 Firefox/37.0\", \"completion_percentage\": 55}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(27,1,43,'2025-07-18 02:55:37','completed','{\"ip_address\": \"49.20.236.246\", \"user_agent\": \"Opera/9.59 (Windows CE; nl-NL) Presto/2.10.251 Version/12.00\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(28,1,12,'2025-08-16 17:56:36','completed','{\"ip_address\": \"21.153.70.148\", \"user_agent\": \"Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/531.1 (KHTML, like Gecko) Chrome/83.0.4186.29 Safari/531.1 EdgA/83.01013.36\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(29,1,2,NULL,'partial','{\"ip_address\": \"64.201.89.52\", \"user_agent\": \"Mozilla/5.0 (X11; Linux i686; rv:6.0) Gecko/20101008 Firefox/37.0\", \"completion_percentage\": 42}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(30,1,17,NULL,'partial','{\"ip_address\": \"17.224.238.5\", \"user_agent\": \"Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.2 (KHTML, like Gecko) Chrome/83.0.4749.31 Safari/535.2 EdgA/83.01009.73\", \"completion_percentage\": 54}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(31,1,28,'2025-09-11 16:23:46','completed','{\"ip_address\": \"248.119.207.147\", \"user_agent\": \"Mozilla/5.0 (Windows 98; nl-NL; rv:1.9.1.20) Gecko/20111202 Firefox/35.0\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(32,1,4,'2025-08-16 22:00:38','completed','{\"ip_address\": \"40.2.103.166\", \"user_agent\": \"Mozilla/5.0 (X11; Linux x86_64; rv:7.0) Gecko/20151231 Firefox/36.0\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(33,1,34,'2025-09-23 14:47:23','completed','{\"ip_address\": \"177.67.242.38\", \"user_agent\": \"Mozilla/5.0 (Windows; U; Windows 98) AppleWebKit/531.23.6 (KHTML, like Gecko) Version/5.0.2 Safari/531.23.6\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(34,1,13,'2025-09-13 14:13:31','completed','{\"ip_address\": \"210.229.235.136\", \"user_agent\": \"Mozilla/5.0 (compatible; MSIE 7.0; Windows NT 6.0; Trident/5.0)\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(35,1,8,'2025-10-01 05:05:36','completed','{\"ip_address\": \"201.190.222.205\", \"user_agent\": \"Mozilla/5.0 (compatible; MSIE 8.0; Windows 95; Trident/5.1)\", \"completion_percentage\": 100}','2025-10-04 02:04:19','2025-10-04 02:04:19',NULL),(36,1,1,'2025-10-04 02:12:42','completed','{\"ip_address\": \"127.0.0.1\", \"started_at\": \"2025-10-04 09:09:18\", \"user_agent\": \"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\", \"completed_at\": \"2025-10-04 09:12:42\", \"last_saved_at\": \"2025-10-04 09:12:33\", \"completion_duration\": 3.4053543666666664}','2025-10-04 02:09:18','2025-10-04 02:12:42',NULL),(37,1,51,'2025-10-04 07:29:02','completed','{\"ip_address\": \"127.0.0.1\", \"started_at\": \"2025-10-04 14:26:13\", \"user_agent\": \"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36\", \"completed_at\": \"2025-10-04 14:29:02\", \"completion_duration\": 2.825845716666666}','2025-10-04 07:26:13','2025-10-04 07:29:02',NULL);
/*!40000 ALTER TABLE `survey_responses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tracer_study_sessions`
--

DROP TABLE IF EXISTS `tracer_study_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tracer_study_sessions` (
  `session_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `year` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`session_id`),
  KEY `tracer_study_sessions_year_index` (`year`),
  KEY `tracer_study_sessions_start_date_end_date_index` (`start_date`,`end_date`),
  KEY `tracer_study_sessions_is_active_index` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tracer_study_sessions`
--

LOCK TABLES `tracer_study_sessions` WRITE;
/*!40000 ALTER TABLE `tracer_study_sessions` DISABLE KEYS */;
INSERT INTO `tracer_study_sessions` VALUES (1,2024,'2025-01-01','2025-12-31','Tracer Study Alumni 2024 - Standar BAN-PT',1,'2025-10-04 02:04:19','2025-10-04 02:07:42',NULL);
/*!40000 ALTER TABLE `tracer_study_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `training_courses`
--

DROP TABLE IF EXISTS `training_courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `training_courses` (
  `training_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `training_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `certificate` tinyint(1) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`training_id`),
  KEY `training_courses_start_date_end_date_index` (`start_date`,`end_date`),
  KEY `training_courses_provider_index` (`provider`),
  KEY `training_courses_category_index` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `training_courses`
--

LOCK TABLES `training_courses` WRITE;
/*!40000 ALTER TABLE `training_courses` DISABLE KEYS */;
/*!40000 ALTER TABLE `training_courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Super Admin','admin@tracerstudy.test','2025-10-04 02:04:18','$2y$12$W5SuaAk7iP6W7L12z6JTdOaxG7cWT2qFk4dyE.gMaUzeF4gcB9AkO',NULL,'2025-10-04 02:04:18','2025-10-04 02:04:18'),(2,'Staff User','staff@tracerstudy.test','2025-10-04 02:04:19','$2y$12$B7K2SM0Dos.ySqyj14nKlukWx98U/Ghs.uvwR6WIkt0x6V35u1Opq',NULL,'2025-10-04 02:04:19','2025-10-04 02:04:19'),(3,'Viewer User','viewer@tracerstudy.test','2025-10-04 02:04:19','$2y$12$1syFF8hrrCJ5F6gfPTKFtu8hqSDQ/Gj3AFyujb8Aj/jdqZsOKIG3y',NULL,'2025-10-04 02:04:19','2025-10-04 08:05:59');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'tracer_study_local_v2'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-04 22:16:32
