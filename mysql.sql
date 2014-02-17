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
INSERT INTO `ci_sessions` VALUES ('d22b402d9d234dfb3defc207f7b6a72e','127.0.0.1','Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/31.0.1650.63 Chrome/31.0.1650.63 Sa',1392607200,'a:5:{s:9:\"user_data\";s:0:\"\";s:6:\"userId\";s:2:\"52\";s:9:\"loginName\";s:6:\"tianyi\";s:6:\"bossId\";s:1:\"2\";s:7:\"storeId\";i:2;}');
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
INSERT INTO `item` VALUES (55,'sdfasdf','测试信息',NULL,2,0,232,123.00,'52_2013-12-27_19-49-57.jpg','',1,0,0,0,'52_2013-12-27_19-49-45.jpg','零食饮料;素材;鲜鱼|苹果',NULL,22),(56,'测试图片','测试信息',NULL,2,10800,2345,23.00,'52_2013-12-31_16-59-00.jpg','2,颜色,红色:52_2013-12-31_16-58-01.jpg,白色: |1000,23;1345,23',0,0,46,0,'52_2013-12-31_16-57-26.jpg','零食饮料;素材;鲜鱼|苹果',NULL,163),(57,'两种属性的测试','测试信息',NULL,2,0,1223,1222.00,'52_2014-01-01_13-17-28.jpg','3,3,重量,颜色,100k: ,400K: ,500K: ,白色: ,红色: ,绿色: |123,1222;1233,1220;1232,1221;1221,1222;21,1222;23,1222;221,1222;232,1222;2322,1222',0,0,0,0,'52_2014-01-01_13-15-35.jpg','零食饮料;素材;鲜鱼|苹果',NULL,12),(58,'asdfasdf','测<span style=\"font-size:32px;\">试信息sd</span>',NULL,2,1392137806,2323,3223.00,'52_2014-02-12_00-55-04.jpg','',0,0,0,0,'52_2014-02-12_00-54-37.jpg','零食饮料;饮料;橙汁|新鲜水梨',NULL,1),(59,'asdfasdf','测<span style=\"font-size:32px;\">试信息sd</span>','2014-02-12 00:57:57',2,1392137877,2323,3223.00,'52_2014-02-12_00-55-04.jpg','',0,0,0,0,'52_2014-02-12_00-54-37.jpg','零食饮料;饮料;橙汁|新鲜水梨',NULL,5);
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
  `orderId` char(30) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`seller`),
  KEY `item_id` (`item_id`),
  KEY `state` (`state`),
  KEY `ordor` (`ordor`)
) ENGINE=MyISAM AUTO_INCREMENT=188 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ord`
--

LOCK TABLES `ord` WRITE;
/*!40000 ALTER TABLE `ord` DISABLE KEYS */;
INSERT INTO `ord` VALUES (149,0,'&&&',0,55,'2013-12-29 15:17:37',2,52,'0'),(150,0,'&&&',2,55,'2013-12-29 15:17:37',2,52,'0'),(151,0,'&&&',2,55,'2013-12-29 15:17:37',2,52,'0'),(152,0,'&&&',2,55,'2013-12-29 15:17:37',2,52,'0'),(153,0,'&&&',2,55,'2013-12-29 15:17:37',2,52,'0'),(154,0,'&&&',2,55,'2013-12-29 15:17:37',2,52,'0'),(155,0,'&&&',2,55,'2013-12-29 15:17:37',2,52,'0'),(156,0,'&&&',2,55,'2013-12-29 15:17:37',2,52,'0'),(157,0,'&&&',2,55,'2013-12-29 15:17:37',2,52,'0'),(158,0,'&&&',2,55,'2013-12-29 15:17:37',2,52,'0'),(159,0,'&&&',2,55,'2013-12-29 15:17:37',2,52,'0'),(160,0,'2&这里是info，attr的内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0'),(161,0,'2&attr,内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0'),(162,0,'2&这里是info，attr的内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0'),(163,0,'2&attr,内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0'),(164,0,'2&这里是info，attr的内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0'),(165,0,'2&attr,内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0'),(166,0,'2&这里是info，attr的内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0'),(167,0,'2&attr,内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0'),(168,0,'2&这里是info，attr的内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0'),(169,0,'2&attr,内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0'),(170,0,'2&这里是info，attr的内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0'),(171,0,'2&attr,内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0'),(172,0,'2&这里是info，attr的内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0'),(173,0,'2&attr,内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0'),(174,0,'2&这里是info，attr的内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0'),(175,0,'2&attr,内容&123.00',2,55,'2013-12-29 15:17:37',2,52,'0'),(176,0,'1&&23.00',2,56,'2014-02-16 08:23:32',9,52,'0'),(177,0,'1&&23.00',2,56,'2014-02-16 08:23:32',9,52,'0'),(178,0,'1&&23.00',2,56,'2014-02-16 08:23:32',9,52,'0'),(179,0,'1&&23.00',2,56,'2014-02-16 08:23:32',9,52,'0'),(180,0,'1&&23.00',2,56,'2014-02-16 08:23:32',9,52,'0'),(181,0,'1&&23.00',2,56,'2014-02-16 08:23:32',9,52,'0'),(182,0,'1&&23.00',2,56,'2014-02-16 08:23:32',9,52,'0'),(183,0,'1&&23.00',2,56,'2014-02-16 08:23:32',9,52,'0'),(184,0,'1&false&23.00&',2,56,'2014-02-16 15:41:01',9,52,'0'),(185,0,'1&false&23.00',2,56,'2014-02-16 08:23:32',9,52,'0'),(186,0,'2&红色&23.00',2,56,'2014-01-17 12:29:33',0,53,'0'),(187,0,'2&红色&23.00',2,56,'2014-01-17 12:30:51',0,53,'0');
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
INSERT INTO `store` VALUES ('四季鲜水果',1,'',NULL,'232','13653033299',NULL,103.941,30.7595,'test|素菜|拼菜|sdf','百年品质，值得信赖，优良做工，钻石信誉',0,'8:0-11:30',1200,0.99,'dtuName=撒旦发随地方',9999.9,0,0),('苹果公司',2,'52_2014-01-13_19-24-49.jpg',NULL,'232','13653033299',NULL,103.945,30.7525,'asdf|苹果|新鲜水梨|香蕉','百年品质，值得信赖，优良做工，钻石信誉',2,'8:0-11:30',1900,0.00,'dtuName=撒旦发随地方',0.0,1,0);
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
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (51,'11111111',110,'2013-12-02',NULL,NULL,'','','13648044299',0.0000000,0.0000000,'ssdfasd','asdf',1),(52,'1111111',110,'2013-12-02',NULL,NULL,'','&豆家敏|13648044299|本科20栋404','11111111111',0.0000000,0.0000000,'tianyi','tianyi',0),(53,'111111',120,NULL,NULL,NULL,NULL,'',NULL,0.0000000,0.0000000,'','tian',0);
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
) ENGINE=MyISAM AUTO_INCREMENT=213 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wrong`
--

LOCK TABLES `wrong` WRITE;
/*!40000 ALTER TABLE `wrong` DISABLE KEYS */;
INSERT INTO `wrong` VALUES (201,'在order/getData/403行orderId格式不符合要求,res[orderId] = ，当前用户的id为52','2014-02-16 03:08:36'),(200,'在order/getData/402行orderId格式不符合要求,res[orderId] = ，当前用户的id为52','2014-02-16 03:08:16'),(197,'','2014-02-15 16:29:46'),(198,'','2014-02-16 02:51:33'),(199,'在order/getData/402行orderId格式不符合要求,res[orderId] = ，当前用户的id为52','2014-02-16 02:59:06'),(22,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(23,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(24,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(25,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(26,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(27,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(28,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(29,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(30,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(31,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(32,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(33,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(34,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(35,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(36,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(37,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(38,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(39,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(40,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(41,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(42,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(43,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(44,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(45,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(46,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(47,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(48,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(49,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(50,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(51,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(52,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(53,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(54,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(55,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(56,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(57,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(58,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(59,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(60,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(61,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(62,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(63,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(64,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(65,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(66,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(67,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(68,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(69,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(70,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(71,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(72,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(73,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(74,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(75,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(76,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(77,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(78,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(79,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(80,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(81,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(82,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(83,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(84,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(85,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(86,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(87,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(88,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(89,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(90,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(91,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(92,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(93,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(94,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(95,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(96,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(97,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(98,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(99,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(100,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(101,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(102,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(103,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(104,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(105,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(106,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(107,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(108,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(109,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(110,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(111,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(112,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(113,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(114,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(115,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(116,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(117,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(118,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(119,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(120,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(121,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(122,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(123,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(124,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(125,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(126,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(127,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(128,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(129,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(130,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(131,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(132,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(133,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(134,'model/store/72行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(135,'model/store/72行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(136,'model/store/72行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(137,'model/store/72行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(138,'model/store/72行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(139,'model/store/72行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(140,'model/store/72行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(141,'model/store/72行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(142,'model/store/72行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(143,'model/store/72行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(144,'model/store/72行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(145,'model/store/72行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(146,'model/store/72行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(147,'model/store/72行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(148,'model/store/72行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(149,'model/store/72行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(150,'model/store/72行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(151,'model/store/73行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(152,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(153,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(154,'model/store/71行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(155,'model/store/80行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(156,'model/store/80行count的结果大于2，不应该出现,此时对应的参数str = ','0000-00-00 00:00:00'),(157,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-17 10:05:53&]','0000-00-00 00:00:00'),(158,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 09:30:28&]','0000-00-00 00:00:00'),(159,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 09:30:49&]','0000-00-00 00:00:00'),(160,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 09:35:26&]','0000-00-00 00:00:00'),(161,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 10:09:41&]','0000-00-00 00:00:00'),(162,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 10:09:58&]','0000-00-00 00:00:00'),(163,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 10:10:15&]','0000-00-00 00:00:00'),(164,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 10:10:56&]','0000-00-00 00:00:00'),(165,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 10:11:07&]','0000-00-00 00:00:00'),(166,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 10:16:19&]','0000-00-00 00:00:00'),(167,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 10:16:29&]','0000-00-00 00:00:00'),(168,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 10:18:42&]','0000-00-00 00:00:00'),(169,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 10:21:50&]','0000-00-00 00:00:00'),(170,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 03:24:58&]','0000-00-00 00:00:00'),(171,'text&[在fBusTime中oneTime的长度不为3, 现在时间是12-18 03:38:36&]','0000-00-00 00:00:00'),(172,'controller/bg/home/receiveStoreId/192bossId为2的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(173,'controller/bg/home/receiveStoreId/192bossId为2的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(174,'controller/bg/home/receiveStoreId/192bossId为2的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(175,'controller/bg/home/receiveStoreId/192bossId为2的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(176,'controller/bg/home/receiveStoreId/192bossId为2的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(177,'controller/bg/home/receiveStoreId/192bossId为2的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(178,'controller/bg/home/receiveStoreId/196bossId为52的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(179,'controller/bg/home/receiveStoreId/196bossId为52的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(180,'controller/bg/home/receiveStoreId/193bossId为2的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(181,'controller/bg/home/receiveStoreId/192bossId为2的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(182,'controller/bg/home/receiveStoreId/192bossId为2的用户选择索引了一个不属于自己的名下的storeid3','0000-00-00 00:00:00'),(183,'order/add/86 行出现非数字的itemId','0000-00-00 00:00:00'),(184,'order/add/88 行出现非数字的itemId','2013-12-28 07:19:49'),(185,'order/add/88 行出现非数字的itemId','2013-12-28 07:19:49'),(186,'order/add/88 行出现非数字的itemId :absd','2013-12-28 07:27:33'),(187,'order/add/88 行出现非数字的itemId :-1','2013-12-28 07:27:33'),(188,'order/add/88 行出现非数字的itemId :absd','2013-12-28 07:28:06'),(189,'order/add/88 行出现非数字的itemId :-1','2013-12-28 07:28:07'),(190,'order/add/88 行出现非数字的itemId :absd','2013-12-28 07:28:16'),(191,'order/add/88 行出现非数字的itemId :-1','2013-12-28 07:28:26'),(192,'controller/bg/home/receiveStoreId/200bossId为2的用户选择索引了一个不属于自己的名下的storeid3','2013-12-29 12:04:40'),(193,'order/ontime/751行发现在有userId的情况下，没有对应的storeId','2013-12-29 12:04:40'),(194,'controller/bg/home/receiveStoreId/199bossId为2的用户选择索引了一个不属于自己的名下的storeid3','2013-12-29 14:11:33'),(195,'controller/bg/home/receiveStoreId/200bossId为2的用户选择索引了一个不属于自己的名下的storeid3','2013-12-29 14:11:54'),(196,'controller/bg/home/receiveStoreId/200bossId为2的用户选择索引了一个不属于自己的名下的storeid3','2013-12-29 14:16:38'),(202,'在order/getData/403行orderId格式不符合要求,res[orderId] = ，当前用户的id为52','2014-02-16 03:11:21'),(203,'在order/getData/403行orderId格式不符合要求,res[orderId] = Array，当前用户的id为52','2014-02-16 03:11:51'),(204,'在order/getData/403行orderId格式不符合要求,res[orderId] = Array，当前用户的id为52','2014-02-16 03:15:03'),(205,'在order/getData/404行orderId格式不符合要求,res[orderId] = Array，当前用户的id为52','2014-02-16 04:38:43'),(206,'在order/getData/413行buyNums格式不符合要求,res[buyNum] = ，当前用户的id为52','2014-02-16 05:26:30'),(207,'在order/getData/406行orderId格式不符合要求,res[orderId] = Array，当前用户的id为52','2014-02-16 05:39:30'),(208,'在order/getData/406行orderId格式不符合要求,res[orderId] = Array，当前用户的id为52','2014-02-16 05:39:53'),(209,'在order/getData/406行orderId格式不符合要求,res[orderId] = Array，当前用户的id为52','2014-02-16 05:39:56'),(210,'在order/getData/406行orderId格式不符合要求,res[orderId] = Array，当前用户的id为52','2014-02-16 05:40:02'),(211,'在order/getData/406行orderId格式不符合要求,res[orderId] = Array，当前用户的id为52','2014-02-16 05:40:22'),(212,'在order/getData/406行orderId格式不符合要求,res[orderId] = Array，当前用户的id为52','2014-02-16 05:40:41');
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

-- Dump completed on 2014-02-17 12:06:23
