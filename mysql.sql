-- MySQL dump 10.13  Distrib 5.5.34, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: edian
-- ------------------------------------------------------
-- Server version	5.5.34-0ubuntu0.13.10.1

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `boss`
--

LOCK TABLES `boss` WRITE;
/*!40000 ALTER TABLE `boss` DISABLE KEYS */;
INSERT INTO `boss` VALUES ('ssdfasd',1,'13648044299','11111111','22:33:47','','',NULL,'asdf'),('tianyi',2,'11111111111','1111111','22:37:39','','',NULL,'tianyi'),('',3,'11111111112','111111','15:46:51','','',NULL,'tianyis'),('??',4,'11111111113','111111','15:49:15','','',NULL,'tiansd');
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
INSERT INTO `ci_sessions` VALUES ('953bd7092e442bae3f9f23d85f5416ee','127.0.0.1','Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/31.0.1650.63 Chrome/31.0.1650.63 Sa',1393410082,'a:3:{s:9:\"user_data\";s:0:\"\";s:6:\"userId\";s:2:\"52\";s:9:\"loginName\";s:6:\"tianyi\";}');
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
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comItem`
--

LOCK TABLES `comItem` WRITE;
/*!40000 ALTER TABLE `comItem` DISABLE KEYS */;
INSERT INTO `comItem` VALUES (16,23,'52`56`2014-01-18 00:38:43`这里是第一条回复','2014-01-18',52,56,2),(17,23,'52`56`2014-01-18 00:39:00`这里是第er条回复','2014-01-18',52,56,2);
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
  `rating` int(10) unsigned NOT NULL DEFAULT '0',
  `storeNum` int(10) unsigned NOT NULL DEFAULT '0',
  `price` float(10,2) NOT NULL DEFAULT '0.00',
  `thumbnail` tinytext NOT NULL,
  `attr` tinytext,
  `state` tinyint(4) NOT NULL DEFAULT '0',
  `sellNum` int(10) unsigned NOT NULL DEFAULT '0',
  `satisfyScore` int(10) unsigned NOT NULL DEFAULT '0',
  `deliveryTime` int(10) unsigned NOT NULL DEFAULT '0',
  `mainThumbnail` char(40) NOT NULL,
  `category` char(50) NOT NULL,
  `briefInfo` tinytext,
  `visitorNum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `author_id` (`belongsTo`),
  KEY `price` (`price`),
  KEY `author_id_2` (`belongsTo`),
  KEY `belongsTo` (`belongsTo`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES (55,'sdfasdf','测试信息',NULL,2,0,232,123.00,'52_2013-12-27_19-49-57.jpg','',1,0,0,0,'52_2013-12-27_19-49-45.jpg','零食饮料;素材;鲜鱼|苹果',NULL,138),(56,'测试图片','测试信息',NULL,2,10800,2345,23.00,'52_2013-12-31_16-59-00.jpg','2,颜色,红色:52_2013-12-31_16-58-01.jpg,白色: |1000,23;1345,23',0,0,46,0,'52_2013-12-31_16-57-26.jpg','零食饮料;素材;鲜鱼|苹果',NULL,433),(57,'两种属性的测试','测试信息',NULL,2,0,1223,1222.00,'52_2014-01-01_13-17-28.jpg','3,3,重量,颜色,100k: ,400K: ,500K: ,白色: ,红色: ,绿色: |123,1222;1233,1220;1232,1221;1221,1222;21,1222;23,1222;221,1222;232,1222;2322,1222',0,0,0,0,'52_2014-01-01_13-15-35.jpg','零食饮料;素材;鲜鱼|苹果',NULL,58),(58,'asdfasdf','测<span style=\"font-size:32px;\">试信息sd</span>',NULL,2,1392137806,2323,3223.00,'52_2014-02-12_00-55-04.jpg','',0,0,0,0,'52_2014-02-12_00-54-37.jpg','零食饮料;饮料;橙汁|新鲜水梨',NULL,6),(59,'asdfasdf','测<span style=\"font-size:32px;\">试信息sd</span>','2014-02-12 00:57:57',2,1392137877,2323,3223.00,'52_2014-02-12_00-55-04.jpg','',0,0,0,0,'52_2014-02-12_00-54-37.jpg','零食饮料;饮料;橙汁|新鲜水梨',NULL,8);
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
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `state` tinyint(4) NOT NULL DEFAULT '0',
  `ordor` int(10) unsigned NOT NULL DEFAULT '0',
  `orderId` char(30) NOT NULL DEFAULT '0',
  `note` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `user_id` (`seller`),
  KEY `item_id` (`item_id`),
  KEY `state` (`state`),
  KEY `ordor` (`ordor`)
) ENGINE=MyISAM AUTO_INCREMENT=219 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ord`
--

LOCK TABLES `ord` WRITE;
/*!40000 ALTER TABLE `ord` DISABLE KEYS */;
INSERT INTO `ord` VALUES (149,0,'&&&',0,55,'2013-12-29 15:17:37',2,52,'0',''),(150,0,'&&&',2,55,'2013-12-29 15:17:37',2,52,'0',''),(151,0,'&&&',2,55,'2013-12-29 15:17:37',2,52,'0',''),(152,0,'&&&',2,55,'2013-12-29 15:17:37',2,52,'0',''),(153,0,'&&&',2,55,'2013-12-29 15:17:37',2,52,'0',''),(154,0,'&&&',2,55,'2013-12-29 15:17:37',2,52,'0',''),(155,0,'&&&',2,55,'2013-12-29 15:17:37',2,52,'0',''),(156,0,'&&&',2,55,'2013-12-29 15:17:37',2,52,'0',''),(157,0,'&&&',2,55,'2013-12-29 15:17:37',2,52,'0',''),(158,0,'&&&',2,55,'2013-12-29 15:17:37',2,52,'0',''),(159,0,'&&&',2,55,'2013-12-29 15:17:37',2,52,'0',''),(160,0,'2&这里是info，attr的内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0',''),(161,0,'2&attr,内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0',''),(162,0,'2&这里是info，attr的内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0',''),(163,0,'2&attr,内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0',''),(164,0,'2&这里是info，attr的内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0',''),(165,0,'2&attr,内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0',''),(166,0,'2&这里是info，attr的内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0',''),(167,0,'2&attr,内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0',''),(168,0,'2&这里是info，attr的内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0',''),(169,0,'2&attr,内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0',''),(170,0,'2&这里是info，attr的内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0',''),(171,0,'2&attr,内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0',''),(172,0,'2&这里是info，attr的内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0',''),(173,0,'2&attr,内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0',''),(174,0,'2&这里是info，attr的内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0',''),(175,0,'2&attr,内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0',''),(176,0,'1&&23.00',2,56,'2014-02-17 17:20:33',12,52,'0',''),(177,0,'1&&23.00',2,56,'2014-02-17 17:20:33',12,52,'0',''),(178,0,'1&&23.00',2,56,'2014-02-17 17:20:33',12,52,'0',''),(179,0,'1&&23.00',2,56,'2014-02-17 17:20:33',12,52,'0',''),(180,0,'1&&23.00',2,56,'2014-02-17 17:20:33',12,52,'0',''),(181,0,'1&&23.00',2,56,'2014-02-17 17:20:33',12,52,'0',''),(182,0,'1&&23.00',2,56,'2014-02-17 17:20:33',12,52,'0',''),(183,0,'1&&23.00',2,56,'2014-02-17 17:20:33',12,52,'0',''),(184,0,'1&false&23.00&',2,56,'2014-02-17 13:21:52',9,52,'0',''),(185,0,'1&false&23.00',2,56,'2014-02-17 17:20:33',12,52,'0',''),(186,0,'2&红色&23.00&',2,56,'2014-01-17 12:29:33',9,53,'0',''),(187,0,'2&红色&23.00&',2,56,'2014-01-17 12:30:51',9,53,'0',''),(189,0,'1&&23.00&',2,56,'2014-02-20 08:25:52',9,52,'0',''),(190,0,'1&&23.00',2,56,'2014-02-20 08:25:53',30,52,'0',''),(191,0,'1&&23.00',2,56,'2014-02-20 08:25:53',30,52,'0',''),(192,0,'1&&23.00',2,56,'2014-02-20 08:25:54',30,52,'0',''),(193,0,'1&&23.00',2,56,'2014-02-20 08:25:54',30,52,'0',''),(194,0,'1&&23.00&',2,56,'2014-02-20 08:25:54',9,52,'0',''),(195,0,'1&&23.00',2,56,'2014-02-20 08:25:54',30,52,'0',''),(196,0,'1&&23.00',2,56,'2014-02-20 08:25:54',30,52,'0',''),(197,0,'1&红色&23.00',2,56,'2014-02-20 08:25:57',30,52,'0',''),(198,0,'1&红色&23.00',2,56,'2014-02-20 08:25:57',30,52,'0',''),(199,0,'1&红色&23.00',2,56,'2014-02-20 08:25:58',30,52,'0',''),(200,0,'1&红色&23.00',2,56,'2014-02-20 08:25:58',30,52,'0',''),(201,0,'1&红色&23.00',2,56,'2014-02-20 08:26:05',30,52,'0',''),(202,0,'1&红色&23.00',2,56,'2014-02-20 13:39:06',30,52,'0',''),(203,0,'1&红色&23.00',2,56,'2014-02-20 13:48:17',30,52,'0',''),(204,0,'1&红色&23.00',2,56,'2014-02-20 13:48:20',30,52,'0',''),(205,0,'1&红色&23.00',2,56,'2014-02-20 13:48:34',30,52,'0',''),(206,0,'1&红色&23.00',2,56,'2014-02-20 13:53:19',30,52,'0',''),(207,0,'1&undefined|undefined&1222.00&',2,57,'2014-02-20 16:51:07',9,52,'0',''),(208,0,'1&undefined|undefined&1222.00',2,57,'2014-02-20 16:51:14',30,52,'0',''),(209,0,'1&红色&23.00&',2,56,'2014-02-21 05:59:29',9,52,'0',''),(210,0,'&400K|400K&1222.00',2,57,'2014-02-21 13:44:55',30,52,'0',''),(211,0,'1&400K|白色&1222.00&',2,57,'2014-02-21 14:32:39',9,52,'0',''),(212,0,'1&400K|红色&1222.00&',2,57,'2014-02-21 15:03:43',9,52,'0',''),(213,0,'1&红色&23.00&',2,56,'2014-02-22 04:51:35',9,52,'0',''),(214,0,'1&400K|白色&1222.00',2,57,'2014-02-24 06:19:11',0,52,'0',''),(215,0,'1&500K|白色&1222.00',2,57,'2014-02-24 07:00:37',0,52,'0',''),(216,0,'1&红色&23.00&',2,56,'2014-02-24 13:21:36',9,53,'0',''),(217,0,'1&红色&23.00',2,56,'2014-02-24 14:53:48',0,53,'0',''),(218,0,'4&400K|白色&1222.00',2,57,'2014-02-25 01:50:51',0,52,'0','');
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
  `credit` float(2,2) unsigned NOT NULL DEFAULT '0.00',
  `more` tinytext NOT NULL,
  `sendPrice` float(5,1) unsigned NOT NULL DEFAULT '0.0',
  `state` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `duration` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用于存储商店相关信息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `store`
--

LOCK TABLES `store` WRITE;
/*!40000 ALTER TABLE `store` DISABLE KEYS */;
INSERT INTO `store` VALUES ('四季鲜水果',1,'',NULL,'232','13653033299',NULL,103.941,30.7595,'test|素菜|拼菜|sdf','百年品质，值得信赖，优良做工，钻石信誉',0,'8:0-11:30',1200,0.99,'dtuName=撒旦发随地方',9999.9,0,0),('苹果公司',2,'52_2014-01-13_19-24-49.jpg',NULL,'232','13653033299',NULL,103.945,30.7525,'asdf|苹果|新鲜水梨|香蕉','百年老店，诚实精英',2,'8:0-11:30',1900,0.00,'dtuName=撒旦发随地方',12.0,1,0);
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
  `state` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `loginName` (`loginName`),
  KEY `user_photo` (`photo`),
  KEY `contra` (`phone`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (51,'11111111',110,'2013-12-02',NULL,NULL,'','','13648044299',0.0000000,0.0000000,'ssdfasd','asdf',1),(52,'1111111',110,'2013-12-02',NULL,NULL,'','&豆家敏|13648044299|本科20栋404&sdf|sdf|dfads','11111111111',0.0000000,0.0000000,'tianyi','tianyi',0),(53,'111111',120,NULL,NULL,NULL,NULL,'',NULL,0.0000000,0.0000000,'','tian',0),(54,'111111',0,'2014-02-23',NULL,NULL,'','','11111111112',0.0000000,0.0000000,'','tianyis',0),(55,'111111',110,'2014-02-23',NULL,NULL,'','撒旦发随地方','11111111113',0.0000000,0.0000000,'王二','tiansd',0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vote`
--

DROP TABLE IF EXISTS `vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vote` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filename` char(50) DEFAULT NULL,
  `name` char(50) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vote`
--

LOCK TABLES `vote` WRITE;
/*!40000 ALTER TABLE `vote` DISABLE KEYS */;
INSERT INTO `vote` VALUES (1,'. 1_1.png .','unasm','首先选择评论的图片'),(2,'1_2.png','adf','sadf');
/*!40000 ALTER TABLE `vote` ENABLE KEYS */;
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
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=332 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wrong`
--

LOCK TABLES `wrong` WRITE;
/*!40000 ALTER TABLE `wrong` DISABLE KEYS */;
INSERT INTO `wrong` VALUES (201,'在order/getData/403行orderId格式不符合要求,res[orderId] = ，当前用户的id为52','2014-02-16 03:08:36'),(200,'在order/getData/402行orderId格式不符合要求,res[orderId] = ，当前用户的id为52','2014-02-16 03:08:16'),(220,'controller/bg/home/118出现非数字的bossId = ','2014-02-24 10:20:15'),(221,'controller/bg/home/118出现非数字的bossId = ','2014-02-24 10:21:28'),(222,'在order.php/593行没有检测到需要修改订单状态的订单，请检查数据ordId = 2','2014-02-24 15:27:50'),(331,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 09:03:30'),(330,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 09:03:30'),(329,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 09:03:30'),(328,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 09:00:41'),(327,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 09:00:41'),(326,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 09:00:41'),(325,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 08:59:58'),(324,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 08:59:58'),(323,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 08:59:58'),(322,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 08:55:45'),(321,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 08:55:45'),(320,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 08:55:45'),(319,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 08:55:44'),(318,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 08:55:44'),(317,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 08:55:44'),(316,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 08:55:43'),(315,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 08:55:43'),(314,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 08:55:43'),(313,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 08:55:41'),(312,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 08:55:41'),(311,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 08:55:41'),(310,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 08:55:17'),(309,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 08:55:17'),(308,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 08:55:17'),(307,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 05:02:42'),(306,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 05:02:42'),(305,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 05:02:42'),(304,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 04:33:46'),(303,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 04:33:46'),(302,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 04:33:46'),(301,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 03:45:48'),(300,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 03:45:48'),(299,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 03:45:48'),(298,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 03:45:48'),(297,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 03:45:48'),(296,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 03:45:48'),(295,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 03:37:50'),(294,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 03:37:50'),(293,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 03:37:50'),(292,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 03:37:47'),(291,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 03:37:47'),(290,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 03:37:47'),(289,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 03:37:47'),(288,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 03:37:47'),(287,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 03:37:47'),(286,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:35:28'),(285,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:35:28'),(284,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:35:28'),(283,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:35:20'),(282,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:35:20'),(281,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:35:20'),(280,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:35:14'),(279,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:35:14'),(278,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:35:14'),(277,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:35:06'),(276,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:35:06'),(275,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:35:06'),(274,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:35:05'),(273,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:35:05'),(272,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:35:05'),(271,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:21'),(270,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:21'),(269,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:21'),(268,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:20'),(267,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:20'),(266,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:20'),(265,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:18'),(264,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:18'),(263,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:18'),(262,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:17'),(261,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:17'),(260,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:17'),(259,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:16'),(258,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:16'),(257,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:16'),(256,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:15'),(255,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:15'),(254,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:15'),(253,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:14'),(252,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:14'),(251,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:14'),(250,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:12'),(249,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:12'),(248,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:12'),(247,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:10'),(246,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:10'),(245,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:34:10'),(244,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:33:23'),(243,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:33:23'),(242,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:33:23'),(241,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:32:49'),(240,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:32:49'),(239,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:32:49'),(238,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:32:49'),(237,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:32:49'),(236,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 02:32:49'),(235,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 01:36:50'),(234,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 01:36:50'),(233,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 01:36:50'),(232,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 01:36:50'),(231,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 01:36:50'),(230,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 01:36:50'),(229,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 01:35:03'),(228,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 01:35:03'),(227,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 01:35:03'),(226,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 01:35:03'),(225,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 01:35:03'),(224,'userid= 53 的用户使用了不存在的地址下单购买了，地址下表为0','2014-02-25 01:35:03'),(223,'在order.php/624行没有检测有item_id 但是却没有查找到，请检查一下temp[item_id]','2014-02-24 15:27:50'),(219,'storeId = 2 的用户输入了不存在的订单状态state = 12','2014-02-24 09:29:10'),(217,'这里是个测试','2014-02-24 06:58:49'),(218,'这里是个测试','2014-02-24 06:58:52'),(157,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-17 10:05:53&]','0000-00-00 00:00:00'),(158,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 09:30:28&]','0000-00-00 00:00:00'),(159,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 09:30:49&]','0000-00-00 00:00:00'),(160,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 09:35:26&]','0000-00-00 00:00:00'),(161,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 10:09:41&]','0000-00-00 00:00:00'),(162,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 10:09:58&]','0000-00-00 00:00:00'),(163,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 10:10:15&]','0000-00-00 00:00:00'),(164,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 10:10:56&]','0000-00-00 00:00:00'),(165,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 10:11:07&]','0000-00-00 00:00:00'),(166,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 10:16:19&]','0000-00-00 00:00:00'),(167,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 10:16:29&]','0000-00-00 00:00:00'),(168,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 10:18:42&]','0000-00-00 00:00:00'),(169,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 10:21:50&]','0000-00-00 00:00:00'),(170,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 03:24:58&]','0000-00-00 00:00:00'),(171,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 03:38:36&]','0000-00-00 00:00:00'),(172,'controller/bg/home/receiveStoreId/192bossId为2的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(173,'controller/bg/home/receiveStoreId/192bossId为2的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(174,'controller/bg/home/receiveStoreId/192bossId为2的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(175,'controller/bg/home/receiveStoreId/192bossId为2的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(176,'controller/bg/home/receiveStoreId/192bossId为2的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(177,'controller/bg/home/receiveStoreId/192bossId为2的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(178,'controller/bg/home/receiveStoreId/196bossId为52的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(179,'controller/bg/home/receiveStoreId/196bossId为52的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(180,'controller/bg/home/receiveStoreId/193bossId为2的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(181,'controller/bg/home/receiveStoreId/192bossId为2的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(182,'controller/bg/home/receiveStoreId/192bossId为2的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(183,'order/add/86 行出现非数字的itemId','0000-00-00 00:00:00'),(184,'order/add/88 行出现非数字的itemId','2013-12-28 07:19:49'),(185,'order/add/88 行出现非数字的itemId','2013-12-28 07:19:49'),(186,'order/add/88 行出现非数字的itemId :absd','2013-12-28 07:27:33'),(187,'order/add/88 行出现非数字的itemId :-1','2013-12-28 07:27:33'),(188,'order/add/88 行出现非数字的itemId :absd','2013-12-28 07:28:06'),(189,'order/add/88 行出现非数字的itemId :-1','2013-12-28 07:28:07'),(190,'order/add/88 行出现非数字的itemId :absd','2013-12-28 07:28:16'),(191,'order/add/88 行出现非数字的itemId :-1','2013-12-28 07:28:26'),(192,'controller/bg/home/receiveStoreId/200bossId为2的用户选择索引了一个不属于自己的名下的storeid3','2013-12-29 12:04:40'),(193,'order/ontime/751行发现在有userId的情况下，没有对应的storeId','2013-12-29 12:04:40'),(194,'controller/bg/home/receiveStoreId/199bossId为2的用户选择索引了一个不属于自己的名下的storeid3','2013-12-29 14:11:33'),(195,'controller/bg/home/receiveStoreId/200bossId为2的用户选择索引了一个不属于自己的名下的storeid3','2013-12-29 14:11:54'),(196,'controller/bg/home/receiveStoreId/200bossId为2的用户选择索引了一个不属于自己的名下的storeid3','2013-12-29 14:16:38'),(202,'在order/getData/403行orderId格式不符合要求,res[orderId] = ，当前用户的id为52','2014-02-16 03:11:21'),(203,'在order/getData/403行orderId格式不符合要求,res[orderId] = Array，当前用户的id为52','2014-02-16 03:11:51'),(204,'在order/getData/403行orderId格式不符合要求,res[orderId] = Array，当前用户的id为52','2014-02-16 03:15:03'),(205,'在order/getData/404行orderId格式不符合要求,res[orderId] = Array，当前用户的id为52','2014-02-16 04:38:43'),(206,'在order/getData/413行buyNums格式不符合要求,res[buyNum] = ，当前用户的id为52','2014-02-16 05:26:30'),(207,'在order/getData/406行orderId格式不符合要求,res[orderId] = Array，当前用户的id为52','2014-02-16 05:39:30'),(208,'在order/getData/406行orderId格式不符合要求,res[orderId] = Array，当前用户的id为52','2014-02-16 05:39:53'),(209,'在order/getData/406行orderId格式不符合要求,res[orderId] = Array，当前用户的id为52','2014-02-16 05:39:56'),(210,'在order/getData/406行orderId格式不符合要求,res[orderId] = Array，当前用户的id为52','2014-02-16 05:40:02'),(211,'在order/getData/406行orderId格式不符合要求,res[orderId] = Array，当前用户的id为52','2014-02-16 05:40:22'),(212,'在order/getData/406行orderId格式不符合要求,res[orderId] = Array，当前用户的id为52','2014-02-16 05:40:41'),(213,'有人非法入侵bg/order/changeNote 229','2014-02-17 17:18:21'),(214,'有人非法入侵bg/order/changeNote 229','2014-02-17 17:18:28'),(215,'在order.php/561行没有检测到需要修改订单状态的订单，请检查数据ordId = ','2014-02-19 07:43:29'),(216,'在order.php/592行没有检测有item_id 但是却没有查找到，请检查一下temp[item_id]','2014-02-19 07:43:29');
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

-- Dump completed on 2014-02-26 18:30:47
