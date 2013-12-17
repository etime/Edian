-- MySQL dump 10.13  Distrib 5.5.34, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: edian
-- ------------------------------------------------------
-- Server version	5.5.34-0ubuntu0.13.04.1

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
-- Table structure for table `art`
--

DROP TABLE IF EXISTS `art`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `art` (
  `art_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) DEFAULT NULL,
  `content` text NOT NULL,
  `part_id` int(3) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `value` int(11) NOT NULL DEFAULT '0',
  `visitor_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `comment_num` smallint(5) unsigned NOT NULL DEFAULT '0',
  `new` tinyint(4) NOT NULL DEFAULT '0',
  `commer` int(10) unsigned NOT NULL DEFAULT '0',
  `price` mediumint(8) unsigned DEFAULT NULL,
  `img` char(25) NOT NULL DEFAULT 'edianlogo.jpg',
  `keyword` char(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`art_id`),
  KEY `art_title` (`title`),
  KEY `user_id` (`author_id`),
  KEY `value` (`value`),
  KEY `author_id` (`author_id`),
  KEY `title` (`title`),
  KEY `price` (`price`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `art`
--

LOCK TABLES `art` WRITE;
/*!40000 ALTER TABLE `art` DISABLE KEYS */;
/*!40000 ALTER TABLE `art` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `boss`
--

DROP TABLE IF EXISTS `boss`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `boss` (
  `nickname` char(20) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` char(13) NOT NULL,
  `password` varchar(20) NOT NULL,
  `registerTime` time NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `more` tinytext,
  `loginName` char(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`),
  UNIQUE KEY `loginName` (`loginName`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `boss`
--

LOCK TABLES `boss` WRITE;
/*!40000 ALTER TABLE `boss` DISABLE KEYS */;
INSERT INTO `boss` VALUES ('ssdfasd',1,'13648044299','11111111','22:33:47','','',NULL,'asdf'),('tianyi',2,'11111111111','1111111','22:37:39','','',NULL,'tianyi');
/*!40000 ALTER TABLE `boss` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `session_id` char(40) NOT NULL DEFAULT '0',
  `ip_address` char(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
INSERT INTO `ci_sessions` VALUES ('ae9be91b2f0e992846779a704dc579ef','127.0.0.1','Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/30.0.1599.114 Chrome/30.0.1599.114 ',1387252677,'a:2:{s:9:\"user_data\";s:0:\"\";s:6:\"userId\";s:2:\"52\";}');
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comItem`
--

DROP TABLE IF EXISTS `comItem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comItem` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `score` tinyint(4) NOT NULL DEFAULT '9',
  `context` text,
  `time` date DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `item_id` int(10) unsigned NOT NULL DEFAULT '0',
  `seller` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comItem`
--

LOCK TABLES `comItem` WRITE;
/*!40000 ALTER TABLE `comItem` DISABLE KEYS */;
/*!40000 ALTER TABLE `comItem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `comment` text,
  `reg_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(10) unsigned DEFAULT NULL,
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `art_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`),
  KEY `user_id` (`user_id`),
  KEY `art_id` (`art_id`)
) ENGINE=MyISAM AUTO_INCREMENT=206 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `img`
--

DROP TABLE IF EXISTS `img`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `img` (
  `imgName` char(40) NOT NULL,
  `uploadName` varchar(50) NOT NULL,
  `tag` varchar(40) NOT NULL,
  `usedByItem` varchar(200) NOT NULL,
  `uploadStore` int(10) unsigned NOT NULL,
  UNIQUE KEY `imgName` (`imgName`),
  KEY `img_name` (`imgName`),
  KEY `uploadStore` (`uploadStore`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `img`
--

LOCK TABLES `img` WRITE;
/*!40000 ALTER TABLE `img` DISABLE KEYS */;
/*!40000 ALTER TABLE `img` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imgComment`
--

DROP TABLE IF EXISTS `imgComment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imgComment` (
  `comId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `time` datetime DEFAULT NULL,
  `comment` text,
  `imgId` int(10) unsigned DEFAULT NULL,
  `userId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`comId`),
  KEY `imgId` (`imgId`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imgComment`
--

LOCK TABLES `imgComment` WRITE;
/*!40000 ALTER TABLE `imgComment` DISABLE KEYS */;
/*!40000 ALTER TABLE `imgComment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interest`
--

DROP TABLE IF EXISTS `interest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `interest` (
  `user_id` int(11) NOT NULL,
  `keyword` char(40) DEFAULT NULL,
  `keyValue` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interest`
--

LOCK TABLES `interest` WRITE;
/*!40000 ALTER TABLE `interest` DISABLE KEYS */;
/*!40000 ALTER TABLE `interest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) DEFAULT NULL,
  `detail` text,
  `putawayTime` datetime DEFAULT NULL,
  `belongsTo` int(10) unsigned DEFAULT NULL,
  `rating` int(10) unsigned DEFAULT NULL,
  `storeNum` int(10) unsigned DEFAULT NULL,
  `price` float(10,2) NOT NULL DEFAULT '0.00',
  `thumbnail` tinytext NOT NULL,
  `attr` tinytext,
  `state` tinyint(4) NOT NULL DEFAULT '0',
  `sellNum` int(10) unsigned DEFAULT NULL,
  `satisfyScore` int(10) unsigned DEFAULT NULL,
  `deliveryTime` int(10) unsigned DEFAULT NULL,
  `mailThumbnail` char(40) NOT NULL,
  `category` char(50) NOT NULL,
  `briefInfo` tinytext,
  `visitorNum` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `author_id` (`belongsTo`),
  KEY `price` (`price`),
  KEY `author_id_2` (`belongsTo`),
  KEY `belongsTo` (`belongsTo`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `senderId` int(10) unsigned DEFAULT NULL,
  `geterId` int(10) unsigned DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `body` text,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `read_already` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `messageId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `replyTo` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`messageId`),
  KEY `geterId` (`geterId`),
  KEY `senderId` (`senderId`),
  KEY `re` (`replyTo`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `online_user`
--

DROP TABLE IF EXISTS `online_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `online_user` (
  `session_id` varchar(35) NOT NULL DEFAULT '0',
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` char(40) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `passwd` char(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`session_id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `online_user`
--

LOCK TABLES `online_user` WRITE;
/*!40000 ALTER TABLE `online_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `online_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ord`
--

DROP TABLE IF EXISTS `ord`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ord` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `addr` tinyint(4) NOT NULL DEFAULT '0',
  `info` tinytext,
  `seller` int(10) unsigned NOT NULL DEFAULT '0',
  `item_id` int(10) unsigned NOT NULL DEFAULT '0',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `state` tinyint(4) NOT NULL DEFAULT '0',
  `ordor` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`seller`),
  KEY `item_id` (`item_id`),
  KEY `state` (`state`),
  KEY `ordor` (`ordor`)
) ENGINE=MyISAM AUTO_INCREMENT=149 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ord`
--

LOCK TABLES `ord` WRITE;
/*!40000 ALTER TABLE `ord` DISABLE KEYS */;
/*!40000 ALTER TABLE `ord` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `store`
--

DROP TABLE IF EXISTS `store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `store` (
  `name` varchar(20) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logo` tinytext NOT NULL,
  `topPicture` tinytext,
  `serviceQQ` varchar(13) NOT NULL,
  `servicePhone` varchar(13) NOT NULL,
  `address` tinytext,
  `longitude` float NOT NULL,
  `latitude` float NOT NULL,
  `category` mediumtext,
  `briefInfo` tinytext,
  `ownerId` int(11) NOT NULL,
  `deliveryTime` varchar(50) NOT NULL,
  `deliveryArea` int(10) unsigned DEFAULT NULL,
  `credit` float(2,2) DEFAULT NULL,
  `more` tinytext NOT NULL,
  `sendPrice` float(5,1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用于存储商店相关信息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store`
--

LOCK TABLES `store` WRITE;
/*!40000 ALTER TABLE `store` DISABLE KEYS */;
INSERT INTO `store` VALUES ('abc',1,'',NULL,'232','13653033299',NULL,123212,122.213,NULL,NULL,0,'0:0-0:0',1000,0.99,'',9999.9);
/*!40000 ALTER TABLE `store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `password` varchar(20) DEFAULT NULL,
  `credit` tinyint(4) DEFAULT '0',
  `registerTime` date DEFAULT NULL,
  `photo` char(40) DEFAULT NULL,
  `lastLoginTime` datetime DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `address` varchar(100) NOT NULL,
  `phone` char(13) DEFAULT NULL,
  `longitude` double(11,7) NOT NULL DEFAULT '0.0000000',
  `latitude` double(11,7) NOT NULL DEFAULT '0.0000000',
  `nickname` char(20) NOT NULL,
  `loginName` char(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `loginName` (`loginName`),
  KEY `user_photo` (`photo`),
  KEY `contra` (`phone`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (51,'11111111',110,'2013-12-02',NULL,NULL,'','','13648044299',0.0000000,0.0000000,'ssdfasd','asdf'),(52,'1111111',110,'2013-12-02',NULL,NULL,'','','11111111111',0.0000000,0.0000000,'tianyi','tianyi');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wrong`
--

DROP TABLE IF EXISTS `wrong`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wrong` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wrong`
--

LOCK TABLES `wrong` WRITE;
/*!40000 ALTER TABLE `wrong` DISABLE KEYS */;
INSERT INTO `wrong` VALUES (15,''),(16,'text&[, 现在时间是12-02 11:11:46&]'),(17,'text&[呵呵玩笑, 现在时间是12-02 11:11:51&]'),(18,'text&[呵呵玩笑, 现在时间是12-02 11:18:47&]'),(19,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(20,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(21,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(22,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(23,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(24,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(25,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(26,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(27,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(28,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(29,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(30,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(31,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(32,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(33,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(34,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(35,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(36,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(37,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(38,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(39,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(40,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(41,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(42,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(43,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(44,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(45,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(46,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(47,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(48,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(49,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(50,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(51,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(52,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(53,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(54,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(55,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(56,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(57,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(58,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(59,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(60,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(61,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(62,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(63,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(64,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(65,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(66,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(67,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(68,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(69,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(70,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(71,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(72,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(73,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(74,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(75,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(76,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(77,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(78,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(79,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(80,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(81,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(82,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(83,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(84,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(85,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(86,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(87,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(88,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(89,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(90,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(91,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(92,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(93,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(94,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(95,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(96,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(97,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(98,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(99,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(100,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(101,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(102,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(103,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(104,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(105,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = '),(106,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ');
/*!40000 ALTER TABLE `wrong` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-12-17 12:11:36
