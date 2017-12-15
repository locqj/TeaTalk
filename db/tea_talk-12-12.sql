-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: localhost    Database: tea_talk
-- ------------------------------------------------------
-- Server version	5.7.18-1

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
-- Table structure for table `chat_logs`
--

DROP TABLE IF EXISTS `chat_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `relation_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `content` text CHARACTER SET utf8,
  `time` varchar(125) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_logs`
--

LOCK TABLES `chat_logs` WRITE;
/*!40000 ALTER TABLE `chat_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_relation`
--

DROP TABLE IF EXISTS `chat_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `user_codes` text CHARACTER SET utf8 NOT NULL COMMENT '用户关系',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_relation`
--

LOCK TABLES `chat_relation` WRITE;
/*!40000 ALTER TABLE `chat_relation` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat_relation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,'D0','行政管理'),(2,'D1','信息科学技术'),(3,'D2','电子信息科学与技术'),(4,'D3','管理科学');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `level_code`
--

DROP TABLE IF EXISTS `level_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `level_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `upcount` int(11) DEFAULT NULL,
  `downcount` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `level_code`
--

LOCK TABLES `level_code` WRITE;
/*!40000 ALTER TABLE `level_code` DISABLE KEYS */;
/*!40000 ALTER TABLE `level_code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `moments`
--

DROP TABLE IF EXISTS `moments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `content` text CHARACTER SET utf8,
  `img` text CHARACTER SET utf8,
  `status_del` int(11) DEFAULT '1',
  `year` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `day` int(11) DEFAULT NULL,
  `time` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `sharenear` int(11) DEFAULT NULL,
  `sharepublic` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moments`
--

LOCK TABLES `moments` WRITE;
/*!40000 ALTER TABLE `moments` DISABLE KEYS */;
INSERT INTO `moments` VALUES (1,'C4','asdsa','',1,2017,12,4,'1512354762','M0',0,1),(2,'C4','asdasd ','',1,2017,12,4,'1512354856','M1',0,1),(3,'C0','test have image','[\"b2017-12-07-16-03-39-5a28f5dbd9d9a.jpg\",\"b2017-12-07-16-03-39-5a28f5dbdd753.jpg\",\"b2017-12-07-16-03-39-5a28f5dbddb7f.jpg\"]',1,2017,12,7,'1512633823','M2',0,1),(4,'C3','test mometn','[\"b2017-12-12-16-11-47-5a2f8f43bc1fb.jpg\",\"b2017-12-12-16-11-47-5a2f8f43bed98.jpg\",\"b2017-12-12-16-11-47-5a2f8f43bf4fc.jpg\"]',1,2017,12,12,'1513066310','M3',0,1),(5,'C3','sadsa','',1,2017,12,12,'1513066524','M4',0,1),(6,'C3','asdsd','[\"b2017-12-12-16-16-05-5a2f90452dba3.jpg\",\"b2017-12-12-16-16-05-5a2f90452e49a.jpg\"]',1,2017,12,12,'1513066566','M5',0,1);
/*!40000 ALTER TABLE `moments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `moments_comment`
--

DROP TABLE IF EXISTS `moments_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moments_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `parent_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `content` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `status_del` int(11) DEFAULT '1',
  `user_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `to_user_code` varchar(255) CHARACTER SET utf8 NOT NULL,
  `moment_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `moments_comment`
--

LOCK TABLES `moments_comment` WRITE;
/*!40000 ALTER TABLE `moments_comment` DISABLE KEYS */;
INSERT INTO `moments_comment` VALUES (1,'MC0','FMC0M1','的撒大所多',1,'C4','C4','M1','1512531780'),(2,'MC1','MC0','test1',1,'C4','C4','M1','1512538047'),(3,'MC1','MC0','test1',1,'C4','C4','M0','1512538049'),(4,'MC3','MC1','撒大声地',1,'C4','C4','M1','1512543619'),(5,'MC4','MC3','fuck',1,'C4','C4','M1','1512543660'),(6,'MC5','MC4','的撒奥多',1,'C0','C4','M1','1512543703'),(7,'MC6','FMC0M0','呵呵',1,'C0','C4','M0','1512543716'),(8,'MC7','FMC0M0','傻逼啊',1,'C0','C4','M0','1512543731'),(9,'MC8','MC7','你才傻逼吧',1,'C0','C0','M0','1512543743'),(10,'MC9','MC5','爱仕达所大所',1,'C0','C0','M1','1512545531'),(11,'MC10','MC9','阿萨德撒',1,'C0','C0','M1','1512613948'),(12,'MC11','FMC0M0','萨达所',1,'C0','C4','M0','1512614326'),(13,'MC12','FMC0M0','安达市多',1,'C0','C4','M0','1512624907'),(14,'MC13','FMC0M0','爱仕达所大所',1,'C0','C4','M0','1512624913'),(15,'MC14','FMC0M1','test',1,'C0','C4','M1','1512625119'),(16,'MC15','FMC0M0','asdasd',1,'C0','C4','M0','1512625132'),(17,'MC16','FMC0M1','test',1,'C0','C4','M1','1512625174'),(18,'MC17','FMC0M1','撒旦撒',1,'C0','C4','M1','1512625186'),(19,'MC18','FMC0M0','fuck',1,'C0','C4','M0','1512625266'),(20,'MC19','MC7','阿萨德撒',1,'C0','C4','M0','1512625561'),(21,'MC20','MC10','十大',1,'C0','C0','M1','1512625583'),(22,'MC21','FMC0M1','撒大声地',1,'C0','C4','M1','1512625588'),(23,'MC22','FMC0M1','大叔大婶',1,'C0','C4','M1','1512625619'),(24,'MC23','FMC0M1','阿萨德撒',1,'C0','C4','M1','1512625712'),(25,'MC24','MC23','大声道撒',1,'C0','C4','M1','1512626014');
/*!40000 ALTER TABLE `moments_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school`
--

DROP TABLE IF EXISTS `school`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school`
--

LOCK TABLES `school` WRITE;
/*!40000 ALTER TABLE `school` DISABLE KEYS */;
INSERT INTO `school` VALUES (1,'S0','澳门高等校际学院'),(2,'S1','兰州大学'),(3,'S2','北京大学'),(4,'S3','合肥工业大学'),(5,'S4','厦门大学');
/*!40000 ALTER TABLE `school` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `school_department`
--

DROP TABLE IF EXISTS `school_department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `department_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `school_department`
--

LOCK TABLES `school_department` WRITE;
/*!40000 ALTER TABLE `school_department` DISABLE KEYS */;
INSERT INTO `school_department` VALUES (1,'S0','D0'),(2,'S1','D1'),(3,'S2','D2'),(4,'S2','D0'),(5,'S3','D3'),(6,'S4','D0');
/*!40000 ALTER TABLE `school_department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_details`
--

DROP TABLE IF EXISTS `user_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `birth` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `img` text CHARACTER SET utf8,
  `school_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `department_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `sex` int(11) NOT NULL COMMENT '0-女， 1-男',
  `phone` varchar(15) CHARACTER SET utf8 DEFAULT NULL,
  `last_ip` varchar(125) CHARACTER SET utf8 DEFAULT NULL,
  `last_time` varchar(125) CHARACTER SET utf8 DEFAULT NULL,
  `nickname` varchar(255) CHARACTER SET utf8 NOT NULL,
  `province` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `signlog` text CHARACTER SET utf8,
  `first_word` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `first_ascii` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_details`
--

LOCK TABLES `user_details` WRITE;
/*!40000 ALTER TABLE `user_details` DISABLE KEYS */;
INSERT INTO `user_details` VALUES (1,'C3','1994-06-30','b2017-12-01-17-23-54-5a211faa6c4d6.jpg','S1','D1',2,'13428065437','127.0.0.1','2017-11-28 16:11:00','cqjasd','北京','爱仕达所大所','c','99'),(2,'C4','1994-06-30','b2017-12-01-17-23-54-5a211faa6c4d6.jpg','S2','D2',2,'13428065437','127.0.0.1','2017-11-28 16:11:05','asdsadjask','北京','爱仕达所大所','a','97'),(3,'C0','1994-06-30','b2017-12-01-17-23-54-5a211faa6c4d6.jpg','S2','D2',2,'13428065437','127.0.0.1','2017-11-28 16:11:05','asdsadjask12121','北京','爱仕达所大所','a','97'),(4,'C1','1994-06-30','b2017-12-01-17-23-54-5a211faa6c4d6.jpg','S2','D2',2,'13428065437','127.0.0.1','2017-11-28 16:11:05','陈lllfuck','北京','hello','l','108'),(5,'C2','1994-06-30','b2017-12-01-17-23-54-5a211faa6c4d6.jpg','S2','D2',1,'13428063452','127.0.0.1','2017-11-28 16:11:05','baby','北京','fuck','f','102'),(7,'C5','1994-06-30','b2017-12-11-14-20-35-5a2e23b37a8a2.jpg','S2','D0',2,'13428065437','127.0.0.1','2017-12-11 14:12:26','asd','北京','123123asd',NULL,NULL),(8,'C6','1994-06-30','b2017-12-11-15-33-41-5a2e34d534e97.jpg','S4','D0',1,'13428065437','127.0.0.1','2017-12-11 15:12:17','asdasd','福建省','asdsadsa',NULL,NULL),(9,'C7','1994-06-30','b2017-12-11-15-39-05-5a2e361989efb.jpg','S2','D0',1,'13428065437','127.0.0.1','2017-12-11 15:12:35','locqjasd','北京','asdasd',NULL,NULL);
/*!40000 ALTER TABLE `user_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_level_count`
--

DROP TABLE IF EXISTS `user_level_count`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_level_count` (
  `int` int(11) NOT NULL AUTO_INCREMENT,
  `user_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `count` int(11) DEFAULT '0',
  PRIMARY KEY (`int`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_level_count`
--

LOCK TABLES `user_level_count` WRITE;
/*!40000 ALTER TABLE `user_level_count` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_level_count` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_location`
--

DROP TABLE IF EXISTS `user_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location_x` varchar(125) CHARACTER SET utf8 NOT NULL,
  `location_y` varchar(125) CHARACTER SET utf8 NOT NULL,
  `count` int(11) DEFAULT '0',
  `user_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_location`
--

LOCK TABLES `user_location` WRITE;
/*!40000 ALTER TABLE `user_location` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_manages`
--

DROP TABLE IF EXISTS `user_manages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_manages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `friend_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `status` int(11) DEFAULT '0' COMMENT '0-等待处理 1-通过已经是好友 2-拒绝',
  `status_del` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_manages`
--

LOCK TABLES `user_manages` WRITE;
/*!40000 ALTER TABLE `user_manages` DISABLE KEYS */;
INSERT INTO `user_manages` VALUES (1,'C0','C1',1,1),(3,'C0','C2',0,1),(4,'C0','C3',1,1),(5,'C4','C0',0,1),(9,'C1','C0',1,1),(10,'C1','C2',0,1),(11,'C1','C3',0,1),(12,'C1','C4',0,1);
/*!40000 ALTER TABLE `user_manages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` text COLLATE utf8mb4_unicode_ci,
  `status_del` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'loxxx','locqj@163.com','$2y$10$IAcwW1vRPQAzXM66KwgztO2u.1hkt3lXZEpZe0gPCPbv3u7MIwIKm',NULL,'2017-11-28 08:49:08','2017-11-28 08:49:08','C0',NULL,1),(3,'loxxx1','locqj@163.com','$2y$10$IAcwW1vRPQAzXM66KwgztO2u.1hkt3lXZEpZe0gPCPbv3u7MIwIKm',NULL,'2017-11-28 08:52:12','2017-11-28 08:52:12','C1',NULL,1),(4,'loxxx2','locqj@163.com','$2y$10$IAcwW1vRPQAzXM66KwgztO2u.1hkt3lXZEpZe0gPCPbv3u7MIwIKm',NULL,'2017-11-28 08:53:56','2017-11-28 08:53:56','C2',NULL,1),(5,'loxxx3','locqj@163.com','$2y$10$IAcwW1vRPQAzXM66KwgztO2u.1hkt3lXZEpZe0gPCPbv3u7MIwIKm',NULL,'2017-11-28 08:55:00','2017-11-28 08:55:00','C3',NULL,1),(6,'loxxx4','locqj@163.com','$2y$10$IAcwW1vRPQAzXM66KwgztO2u.1hkt3lXZEpZe0gPCPbv3u7MIwIKm',NULL,'2017-11-28 08:59:05','2017-11-28 08:59:05','C4',NULL,1),(26,'test','locqj@163.com','$2y$10$bW2o3NAIrtdOw4R56ijoHOOHhvSdxtBCoXQh8a5FCnCP65pmyxjky',NULL,'2017-12-11 06:23:26','2017-12-11 06:23:26','C5',NULL,1),(27,'testaaa','locqj@163.com','$2y$10$0Vg6FD21lpA.5jFP6iLwQOhBc9IVWJhFc/3gofOc16A1eLp57nm52',NULL,'2017-12-11 07:34:17','2017-12-11 07:34:17','C6',NULL,1),(28,'hello','locqj@63.com','$2y$10$H9eKz14XyngIjO.ftVaOgult4D1qlE5dwrejR9O3SeKs2AEzXL0su',NULL,'2017-12-11 07:39:35','2017-12-11 07:39:35','C7',NULL,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zans`
--

DROP TABLE IF EXISTS `zans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `moment_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `user_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zans`
--

LOCK TABLES `zans` WRITE;
/*!40000 ALTER TABLE `zans` DISABLE KEYS */;
INSERT INTO `zans` VALUES (12,'M0','C0'),(13,'M1','C4'),(16,'M1','C0'),(17,'M2','C0');
/*!40000 ALTER TABLE `zans` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-12 16:32:26
