-- MySQL dump 10.13  Distrib 5.1.69, for redhat-linux-gnu (i386)
--
-- Host: localhost    Database: edian
-- ------------------------------------------------------
-- Server version	5.1.69

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
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `art`
--

LOCK TABLES `art` WRITE;
/*!40000 ALTER TABLE `art` DISABLE KEYS */;
INSERT INTO `art` VALUES (1,'我卖的就是这么一种白色的大褂','有能力的人，就给我12块钱，然后自己去抢过来吧，哈哈哈哈哈哈',1,'2013-05-07 17:58:09',20,1367921166,62,1,1,19,12,'201367920689.jpg',''),(2,'凉鞋大减价了，10块钱就卖了','我说这就是我们销售的现场，哈哈哈，有谁相信吗？我是信了，',2,'2013-05-08 12:46:52',19,1367925253,41,1,0,20,15,'191367924950.jpg',''),(3,'上流社会的演唱会的门票','吊丝们，你们颤抖吧，这里是上层社会的演唱会的门票，想来吗？40块钱，让你有公爵般的体验',1,'2013-05-07 19:23:34',19,1367926779,58,2,0,19,40,'191367925814.jpg',''),(4,'卖帝王沙发，送美人一个','买帝王沙发，送每人一个保暖杯，让你体会到店家的温暖',7,'2013-05-08 13:02:12',19,1367926419,85,2,0,21,2000,'191367989331.jpg',''),(5,'火爆的销售现场','你知道，我们在销售什么吗？',1,'2013-05-08 12:52:15',19,1367990892,158,5,0,19,12,'real.png',''),(6,'tadfasd','asdvadsfasdf',1,'2013-05-08 12:59:57',19,1367991233,86,5,0,19,10,'191367989196.jpg',''),(7,'最美不过夕阳红','出售最美的夕阳',1,'2013-05-08 15:04:48',20,1367996851,19,0,0,0,1000,'201367996688.jpg',''),(8,'谁又不是从地球上生长呢','保护环境哦哦哦',9,'2013-05-08 19:00:07',19,1368011114,36,1,0,22,20,'191368010806.jpg',''),(9,'出一个宠物老鼠','听说是荷兰猪的一种，不清楚，廉价出手吧',11,'2013-05-08 21:04:10',21,1368018611,37,0,0,0,12,'211368018250.jpg',''),(10,'出售自己','我出售的，是自己心中黑暗的一面，恩，就是这个样子，23块钱，哈哈',1,'2013-05-08 21:12:30',22,1368018990,24,0,0,0,23,'221368018749.jpg',''),(11,'出售自己','我出售的，是自己心中黑暗的一面，恩，就是这个样子，23块钱，哈哈',1,'2013-05-08 21:15:50',22,1368019011,7,0,0,0,23,'221368018949.jpg',''),(12,'出售自己','我出售的，是自己心中黑暗的一面，恩，就是这个样子，23块钱，哈哈',1,'2013-08-22 14:50:08',22,1368019419,45,0,0,0,23,'221368018968.jpg',''),(13,'出售自己','我出售的，是自己心中黑暗的一面，恩，就是这个样子，23块钱，哈哈',1,'2013-05-08 21:16:25',22,1368019395,41,0,0,0,23,'221368018984.jpg',''),(14,'出售自己','我出售的，是自己心中黑暗的一面，恩，就是这个样子，23块钱，哈哈',1,'2013-05-08 21:17:15',22,1368020727,51,2,1,32,23,'221368019034.jpg',''),(15,'这个是我的桌面，给我钱，我给他配成这个样子','有谁干吗？',6,'2013-05-08 21:50:45',22,1368020860,120,0,0,0,12,'221368021044.jpg',''),(16,'血红色的眼睛，又能看多远','这个，是用来形容鼬的，我就用猫眼来代替吧',6,'2013-05-08 21:49:55',22,1368022267,92,1,0,21,33,'221368020773.jpg',''),(17,'出卖自己的那个哦','给自己标价多少呢，',4,'2013-05-08 21:59:48',22,1368021755,22,0,0,0,11,'real.png',''),(18,'检查中，','检查中，',1,'2013-05-08 22:09:22',22,1368022962,80,0,0,0,23,'221368022161.jpg',''),(19,'这里应该被压缩吧','压缩检查',1,'2013-05-08 22:12:25',22,1368024537,161,1,1,19,33,'221368022345.jpg',''),(20,'鸟，我想出售的的是这个','鸟人，哪里走',1,'2013-05-10 19:09:59',25,1368184599,40,0,0,0,22,'251368184199.jpg',''),(21,'出书','毕业季节',8,'2013-06-12 23:09:58',19,1368192274,32,0,0,0,22,'191368191994.jpg','二手市场;图书;其他;'),(22,'可以照见未来的水晶球，便宜出手了','你看看里面反映的，不是你的未来吧',1,'2013-05-23 22:26:32',19,1369319292,10,0,0,0,23,'191369319192.jpg',''),(23,'testting title','testing content',0,'2013-06-03 09:26:31',19,6443,0,0,0,0,57,'',''),(24,'testting title','testing content',3,'2013-06-03 09:27:19',19,1656,0,0,0,0,408,'191367926062.jpg',''),(25,'testting title','testing content',8,'2013-06-03 09:27:20',19,4753,2,0,0,0,734,'191367926062.jpg',''),(26,'testting title','testing content',8,'2013-06-03 09:27:20',19,4753,2,0,0,0,734,'191367926062.jpg',''),(27,'testting title','testing content',7,'2013-06-03 09:27:21',19,2749,0,0,0,0,58,'191367926062.jpg',''),(28,'testting title','testing content',7,'2013-06-03 09:27:21',19,2749,0,0,0,0,58,'191367926062.jpg',''),(29,'testting title','testing content',9,'2013-06-03 09:27:36',19,3132,0,0,0,0,852,'191367926062.jpg',''),(30,'testting title','testing content',9,'2013-06-03 09:27:36',19,3132,0,0,0,0,852,'191367926062.jpg',''),(31,'testting title','testing content',8,'2013-06-03 09:27:37',19,6153,0,0,0,0,676,'191367926062.jpg',''),(32,'testting title','testing content',8,'2013-06-03 09:27:37',19,6253,10,0,0,0,676,'191367926062.jpg',''),(33,'testting title','testing content',2,'2013-06-03 09:27:38',19,4222,1,0,0,0,498,'191367926062.jpg',''),(34,'testting title','testing content',2,'2013-06-03 09:27:38',19,4212,0,0,0,0,498,'191367926062.jpg',''),(35,'testting title','testing content',2,'2013-06-03 09:27:38',19,4612,40,0,0,0,498,'191367926062.jpg',''),(36,'testting title','testing content',6,'2013-06-03 09:27:39',19,2323,3,0,0,0,819,'191367926062.jpg',''),(37,'testting title','testing content',6,'2013-06-03 09:27:39',19,2293,0,0,0,0,819,'191367926062.jpg',''),(38,'testting title','testing content',6,'2013-06-03 09:27:39',19,2333,4,0,0,0,819,'191367926062.jpg',''),(39,'testting title','testing content',6,'2013-06-03 09:27:39',19,2293,0,0,0,0,819,'191367926062.jpg',''),(40,'testting title','testing content',0,'2013-06-03 09:27:40',19,244,0,0,0,0,136,'191367926062.jpg',''),(41,'testting title','testing content',4,'2013-06-03 09:27:41',19,8227,2,0,0,0,949,'191367926062.jpg',''),(42,'testting title','testing content',2,'2013-06-03 09:27:43',19,10613,17,2,0,19,592,'191367926062.jpg',''),(43,'testting title','testing content',2,'2013-06-03 09:27:43',19,9273,3,0,0,0,592,'191367926062.jpg',''),(44,'testting title','testing content',2,'2013-06-03 09:27:43',19,9263,2,0,0,0,592,'191367926062.jpg',''),(45,'testting title','testing content',2,'2013-06-03 09:27:43',19,9263,2,0,0,0,592,'191367926062.jpg',''),(46,'testting title','testing content',2,'2013-06-03 09:27:43',19,9253,1,0,0,0,592,'191367926062.jpg',''),(47,'testting title','testing content',7,'2013-06-03 09:27:44',19,2327,1,0,0,0,413,'191367926062.jpg',''),(48,'testting title','testing content',7,'2013-06-03 09:27:44',19,2327,1,0,0,0,413,'191367926062.jpg',''),(49,'testting title','testing content',7,'2013-06-03 09:27:44',19,2317,0,0,0,0,413,'191367926062.jpg',''),(50,'testting title','testing content',6,'2013-06-03 09:27:45',19,5343,0,0,0,0,236,'191367926062.jpg',''),(51,'testting title','testing content',6,'2013-06-03 09:27:45',19,5343,0,0,0,0,236,'191367926062.jpg',''),(52,'testting title','testing content',10,'2013-06-03 09:27:46',19,3386,0,0,0,0,555,'191367926062.jpg',''),(53,'testting title','testing content',10,'2013-06-03 09:27:46',19,3386,0,0,0,0,555,'191367926062.jpg',''),(54,'testting title','testing content',4,'2013-06-03 09:27:47',19,6485,9,0,0,0,870,'191367926062.jpg',''),(55,'testting title','testing content',4,'2013-06-03 09:27:47',19,6475,8,0,0,0,870,'191367926062.jpg',''),(56,'testting title','testing content',1,'2013-06-03 09:27:56',19,3679,0,0,0,0,757,'191367926062.jpg',''),(57,'testting title','testing content',1,'2013-06-03 09:27:56',19,3679,0,0,0,0,757,'191367926062.jpg',''),(58,'testting title','testing content',0,'2013-06-03 09:27:57',19,6641,0,0,0,0,576,'191367926062.jpg',''),(59,'testting title','testing content',0,'2013-06-03 09:27:57',19,6641,0,0,0,0,576,'191367926062.jpg',''),(60,'testting title','testing content',0,'2013-06-03 09:27:57',19,6641,0,0,0,0,576,'191367926062.jpg',''),(61,'testting title','testing content',4,'2013-06-03 09:27:58',19,9695,1,0,0,0,401,'191367926062.jpg',''),(62,'testting title','testing content',4,'2013-06-03 09:27:58',19,9685,0,0,0,0,401,'191367926062.jpg',''),(63,'testting title','testing content',4,'2013-06-03 09:27:58',19,9715,3,0,0,0,401,'191367926062.jpg',''),(64,'testting title','testing content',9,'2013-06-03 09:27:59',19,7634,0,0,0,0,708,'191367926062.jpg',''),(65,'testting title','testing content',9,'2013-06-03 09:27:59',19,7634,0,0,0,0,708,'191367926062.jpg',''),(66,'testting title','testing content',9,'2013-06-03 09:27:59',19,7644,1,0,0,0,708,'191367926062.jpg',''),(67,'testting title','testing content',2,'2013-06-03 09:28:00',19,5709,0,0,0,0,533,'191367926062.jpg',''),(68,'testting title','testing content',2,'2013-06-03 09:28:00',19,5709,0,0,0,0,533,'191367926062.jpg',''),(69,'testting title','testing content',2,'2013-06-03 09:28:00',19,5719,1,0,0,0,533,'191367926062.jpg',''),(70,'testting title','testing content',2,'2013-06-03 09:28:00',19,5729,2,0,0,0,533,'191367926062.jpg',''),(71,'testting title','testing content',7,'2013-06-03 09:28:01',19,3807,0,0,0,0,360,'191367926062.jpg',''),(72,'testting title','testing content',7,'2013-06-03 09:28:01',19,3807,0,0,0,0,360,'191367926062.jpg',''),(73,'testting title','testing content',7,'2013-06-03 09:28:01',19,3807,0,0,0,0,360,'191367926062.jpg',''),(74,'testting title','testing content',7,'2013-06-03 09:28:01',19,3807,0,0,0,0,360,'191367926062.jpg',''),(75,'testting title','testing content',7,'2013-06-03 09:28:01',19,3807,0,0,0,0,360,'191367926062.jpg',''),(76,'testting title','testing content',7,'2013-06-03 09:28:01',19,3807,0,0,0,0,360,'191367926062.jpg',''),(77,'testting title','testing content',7,'2013-06-03 09:28:01',19,3807,0,0,0,0,360,'191367926062.jpg',''),(78,'testting title','testing content',7,'2013-06-03 09:28:01',19,3807,0,0,0,0,360,'191367926062.jpg',''),(79,'testting title','testing content',7,'2013-06-03 09:28:01',19,3807,0,0,0,0,360,'191367926062.jpg',''),(80,'testting title','testing content',7,'2013-06-03 09:28:01',19,3807,0,0,0,0,360,'191367926062.jpg',''),(81,'testting title','testing content',7,'2013-06-03 09:28:01',19,3807,0,0,0,0,360,'191367926062.jpg',''),(82,'testting title','testing content',7,'2013-06-03 09:28:01',19,3807,0,0,0,0,360,'191367926062.jpg',''),(83,'testting title','testing content',7,'2013-06-03 09:28:01',19,3807,0,0,0,0,360,'191367926062.jpg',''),(84,'testting title','testing content',7,'2013-06-03 09:28:01',19,3807,0,0,0,0,360,'191367926062.jpg',''),(85,'testting title','testing content',7,'2013-06-03 09:28:01',19,3807,0,0,0,0,360,'191367926062.jpg',''),(86,'testting title','testing content',7,'2013-06-03 09:28:01',19,3807,0,0,0,0,360,'191367926062.jpg',''),(87,'testting title','testing content',7,'2013-06-03 09:28:01',19,3807,0,0,0,0,360,'191367926062.jpg',''),(88,'testting title','testing content',7,'2013-06-03 09:28:01',19,3967,16,0,0,0,360,'191367926062.jpg',''),(89,'testting title','testing content',7,'2013-06-03 09:28:01',19,3807,0,0,0,0,360,'191367926062.jpg',''),(90,'testting title','testing content',7,'2013-06-03 09:28:01',19,3807,0,0,0,0,360,'191367926062.jpg',''),(91,'testting title','testing content',7,'2013-06-03 09:28:01',19,3807,0,0,0,0,360,'191367926062.jpg',''),(92,'testting title','testing content',7,'2013-06-03 09:28:01',19,3807,0,0,0,0,360,'191367926062.jpg',''),(93,'testting title','testing content',1,'2013-06-03 09:28:02',19,6798,0,0,0,0,677,'191367926062.jpg',''),(94,'testting title','testing content',1,'2013-06-03 09:28:02',19,6808,1,0,0,0,677,'191367926062.jpg',''),(95,'testting title','testing content',1,'2013-06-03 09:28:02',19,6798,0,0,0,0,677,'191367926062.jpg',''),(96,'testting title','testing content',1,'2013-06-03 09:28:02',19,6808,1,0,0,0,677,'191367926062.jpg',''),(97,'testting title','testing content',1,'2013-06-03 09:28:02',19,6798,0,0,0,0,677,'191367926062.jpg',''),(98,'testting title','testing content',1,'2013-06-03 09:28:02',19,6798,0,0,0,0,677,'191367926062.jpg',''),(99,'testting title','testing content',1,'2013-06-03 09:28:02',19,6808,1,0,0,0,677,'191367926062.jpg',''),(100,'testting title','testing content',1,'2013-06-03 09:28:02',19,6798,0,0,0,0,677,'191367926062.jpg',''),(101,'testting title','testing content',1,'2013-06-03 09:28:02',19,6798,0,0,0,0,677,'191367926062.jpg',''),(102,'testting title','testing content',1,'2013-06-03 09:28:02',19,6798,0,0,0,0,677,'191367926062.jpg',''),(103,'testting title','testing content',1,'2013-06-03 09:28:02',19,6798,0,0,0,0,677,'191367926062.jpg',''),(104,'testting title','testing content',1,'2013-06-03 09:28:02',19,6798,0,0,0,0,677,'191367926062.jpg',''),(105,'testting title','testing content',1,'2013-06-03 09:28:02',19,6798,0,0,0,0,677,'191367926062.jpg',''),(106,'testting title','testing content',1,'2013-06-03 09:28:02',19,6798,0,0,0,0,677,'191367926062.jpg',''),(107,'testting title','testing content',1,'2013-06-03 09:28:02',19,6798,0,0,0,0,677,'191367926062.jpg',''),(108,'testting title','testing content',1,'2013-06-03 09:28:02',19,6798,0,0,0,0,677,'191367926062.jpg',''),(109,'testting title','testing content',1,'2013-06-03 09:28:02',19,6798,0,0,0,0,677,'191367926062.jpg',''),(110,'testting title','testing content',1,'2013-06-03 09:28:02',19,6798,0,0,0,0,677,'191367926062.jpg',''),(111,'testting title','testing content',1,'2013-06-03 09:28:02',19,6798,0,0,0,0,677,'191367926062.jpg',''),(112,'testting title','testing content',1,'2013-06-03 09:28:02',19,6798,0,0,0,0,677,'191367926062.jpg',''),(113,'testting title','testing content',1,'2013-06-03 09:28:02',19,6798,0,0,0,0,677,'191367926062.jpg',''),(114,'testting title','testing content',1,'2013-06-03 09:28:02',19,6808,1,0,0,0,677,'191367926062.jpg',''),(115,'testting title','testing content',1,'2013-06-03 09:28:02',19,6798,0,0,0,0,677,'191367926062.jpg',''),(116,'testting title','testing content',1,'2013-06-03 09:28:02',19,6808,1,0,0,0,677,'191367926062.jpg',''),(117,'testting title','testing content',1,'2013-06-03 09:28:02',19,6798,0,0,0,0,677,'191367926062.jpg',''),(118,'testting title','testing content',1,'2013-06-03 09:28:02',19,6798,0,0,0,0,677,'191367926062.jpg',''),(119,'testting title','testing content',5,'2013-06-03 09:28:03',19,4892,6,0,0,0,992,'191367926062.jpg',''),(120,'testting title','testing content',5,'2013-06-03 09:28:03',19,4872,4,0,0,0,992,'191367926062.jpg',''),(121,'testting title','testing content',5,'2013-06-03 09:28:03',19,4842,1,0,0,0,992,'191367926062.jpg',''),(122,'testting title','testing content',5,'2013-06-03 09:28:03',19,4832,0,0,0,0,992,'191367926062.jpg',''),(123,'testting title','testing content',5,'2013-06-03 09:28:03',19,4832,0,0,0,0,992,'191367926062.jpg',''),(124,'testting title','testing content',5,'2013-06-03 09:28:03',19,4852,2,0,0,0,992,'191367926062.jpg',''),(125,'testting title','testing content',5,'2013-06-03 09:28:03',19,4832,0,0,0,0,992,'191367926062.jpg',''),(126,'testting title','testing content',5,'2013-06-03 09:28:03',19,4832,0,0,0,0,992,'191367926062.jpg',''),(127,'testting title','testing content',5,'2013-06-03 09:28:03',19,4862,3,0,0,0,992,'191367926062.jpg',''),(128,'testting title','testing content',5,'2013-06-03 09:28:03',19,4852,2,0,0,0,992,'191367926062.jpg',''),(129,'testting title','testing content',5,'2013-06-03 09:28:03',19,4872,4,0,0,0,992,'191367926062.jpg',''),(130,'testting title','testing content',10,'2013-06-03 09:28:04',19,2868,0,0,0,0,318,'191367926062.jpg',''),(131,'testting title','testing content',8,'2013-06-03 09:53:13',19,4807,1,0,0,0,854,'221368022161.jpg',''),(132,'testting title','testing content',8,'2013-06-03 09:53:13',19,4797,0,0,0,0,854,'221368022161.jpg',''),(133,'testting title','testing content',1,'2013-06-03 09:53:14',19,7862,0,0,0,0,682,'191367926062.jpg',''),(134,'testting title','testing content',1,'2013-06-03 09:53:14',19,7872,1,0,0,0,682,'191367926062.jpg',''),(135,'testting title','testing content',1,'2013-06-03 09:53:14',19,7882,2,0,0,0,682,'191367926062.jpg',''),(136,'testting title','testing content',1,'2013-06-03 09:53:14',19,7862,0,0,0,0,682,'191367926062.jpg',''),(137,'testting title','testing content',0,'2013-06-03 09:53:15',19,921,0,0,0,0,996,'221368022161.jpg',''),(138,'testting title','testing content',0,'2013-06-03 09:53:15',19,921,0,0,0,0,996,'221368022161.jpg',''),(139,'testting title','testing content',0,'2013-06-03 09:53:15',19,921,0,0,0,0,996,'221368022161.jpg',''),(140,'testting title','testing content',5,'2013-06-03 09:53:16',19,3938,2,0,0,0,322,'191369575022.jpg',''),(141,'testting title','testing content',5,'2013-06-03 09:53:16',19,3918,0,0,0,0,322,'191369575022.jpg',''),(142,'我们的测试尚未结束','任重而到远',12,'2013-06-04 16:05:35',19,1370333335,20,0,0,0,23,'real.png',''),(143,'sdf asdlf asdkf alsdkf;asdjf;lk asdkfa;sd阿斯顿发ADS ASDFASDFASDFASDFASDFASDFASDFASDF','<img src=\"http://www.edian.cn/upload/month_1306/201306061832245766.jpg\" alt=\"\" />',1,'2013-06-06 18:36:47',20,1370516667,46,2,1,32,12,'201370515007.jpg',''),(144,'asdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasdfasd','<p><img src=\"http://www.edian.cn/upload/month_1306/201306061840387022.jpg\" alt=\"\" /></p><p>关于图片大小的测试中</p>',1,'2013-06-06 18:40:52',20,1370516102,85,0,0,0,56,'201370515251.jpg',''),(145,'阿德发','阿飞',4,'2013-06-10 10:15:24',20,1370830564,4,0,0,0,23,'real.png',''),(146,'桑拿了，桑拿了','速度发速度',3,'2013-06-10 13:08:40',20,1370841010,9,0,0,0,322,'201370840920.jpg',''),(147,'二手的轿车，还是新车的呢，便宜出了。','<p><img src=\"http://www.edian.cn/upload/month_1306/201306101310265776.jpg\" alt=\"\" /></p><p>如百合一般的车子，给你飞一般的享受，刚买不久，买股票发了大财，就把这个车卖了，买一个新的高级的车子，哈哈哈哈，恭喜我把</p>',9,'2013-06-10 13:26:10',20,1370842010,4,0,0,0,2000,'201370841970.jpg','轿车;现代;优惠;结实;日用百货;其他;'),(148,'泡澡便宜了','便宜了',3,'2013-06-10 15:09:49',20,1370848359,17,0,0,0,23,'real.png','优惠;折扣;降价;生活;泡澡;'),(149,'我们的商店开业了','<p>好好看，好好吃的火锅<img src=\"http://www.edian.cn/upload/month_1306/201306281243524066.JPG\" width=\"768\" height=\"768\" alt=\"\" /></p><p>你没有看错，吃夕阳红火锅，给你一种登峰造极的感觉，一种一览众山小的感觉</p>',1,'2013-06-28 12:45:07',27,1372394767,6,0,0,0,34,'271372394707.jpg','夕阳红火锅;火锅;饭店;烧烤;');
/*!40000 ALTER TABLE `art` ENABLE KEYS */;
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
INSERT INTO `ci_sessions` VALUES ('d7a6a375cbf302d33cb11d25fd623a5a','127.0.0.1','Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.63 Safari/537.31',1379059655,'a:2:{s:7:\"user_id\";s:2:\"19\";s:9:\"user_name\";s:6:\"tianyi\";}');
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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comItem`
--

LOCK TABLES `comItem` WRITE;
/*!40000 ALTER TABLE `comItem` DISABLE KEYS */;
INSERT INTO `comItem` VALUES (5,6,'我们都是一家人啊一家人，恩，一家人&同来一发|2013-07-28|tianyi&同水一发，:-)|2013-07-28|tianyi','2013-07-28',19,40,19),(6,3,'asdfasdf','2013-07-28',19,0,19),(7,2,'酱油，不解释','2013-07-28',19,0,19),(8,9,'感觉还行，打个高分吧','2013-08-06',19,47,19),(9,3,'楼上灌水啊','2013-08-06',19,47,19),(10,5,'呵呵，凑个热闹','2013-08-08',0,47,19),(11,9,'asdfasdf','2013-08-08',0,47,19),(12,2,'这个，是为了测试用的','2013-08-08',19,47,19),(13,9,'这次视为了测试评分的','2013-08-08',19,47,19),(14,9,'最后一次测试评分哦....a!,./','2013-08-08',19,47,19);
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
INSERT INTO `comment` VALUES ('这不坑爹吗？给一个美女图，送美人，草，居然打错字了','2013-05-07 11:48:11',20,181,4),('切','2013-05-08 05:15:24',19,182,1),('出洋相，是的话，你就是雇佣童工了','2013-05-08 06:32:56',20,183,2),('果然是上流社会，哈哈，我仿佛看到了香槟，红地毯，音乐和走动的性感女郎','2013-05-08 06:38:21',20,184,3),('真实不清楚，看不清，','2013-05-08 12:16:15',19,185,5),('或许是你这个家伙的自画像吧','2013-05-08 12:17:53',19,186,5),('那也就是说你在出售自己','2013-05-08 12:18:06',19,187,5),('也就是说，哈哈哈[face:11][face:11][face:11]','2013-05-08 12:18:16',19,188,5),('表示店家坑人','2013-05-08 12:21:25',21,189,4),('没有想到过外星人的存在吗？比如，绿灯下，绝地武士之类的','2013-05-08 13:01:59',22,190,8),('我想，这个是乱码的意思吧[face:11][face:11]','2013-05-08 14:00:27',22,191,6),('也或许是认真的呢','2013-05-08 14:15:34',21,192,6),('我想，只有作者自己知道吧','2013-05-08 14:16:37',21,193,6),('最后再帮顶一次','2013-05-08 14:30:19',21,194,6),('鼬，一个悲情人物哦','2013-05-08 14:31:10',21,195,16),('玩笑大了吧','2013-05-14 01:31:52',19,196,3),('不呵呵','2013-05-20 13:32:48',19,197,5),('234','2013-06-05 17:28:20',19,198,42),('asdfasd','2013-06-05 17:28:32',19,199,42),('为什么他们可以评论，而我不可乙','2013-06-16 02:29:36',19,200,19),('[face:41][face:52]','2013-08-20 06:54:12',19,201,6),('我在仰望，谁在歌唱','2013-08-22 08:15:43',32,202,143),('是谁的歌声','2013-08-22 08:16:50',32,203,143),('评论什么的都是浮云[face:52][face:52]','2013-08-25 06:56:41',32,204,14),('楼上是什么意思，远远不理解评论的整整内内行，恩，内行，明白深还是阿斯顿发速度发阿德搜发第三方阿斯顿发阿斯打法速度发啊第三方阿斯地方阿斯顿发搜地方','2013-08-25 06:58:08',32,205,14);
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `img`
--

DROP TABLE IF EXISTS `img`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `img` (
  `img_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `img_name` char(30) DEFAULT NULL,
  `upload_name` varchar(50) DEFAULT NULL,
  `upload_time` datetime DEFAULT NULL,
  PRIMARY KEY (`img_id`),
  KEY `user_id` (`user_id`),
  KEY `img_name` (`img_name`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `img`
--

LOCK TABLES `img` WRITE;
/*!40000 ALTER TABLE `img` DISABLE KEYS */;
INSERT INTO `img` VALUES (72,19,'191368016856.jpg','win8.jpg','2013-05-08 20:40:57'),(89,19,'191376230878.jpg','0028.JPG','2013-08-11 22:21:19'),(74,19,'191369575022.jpg','2e8d37a8a1d82077c9b636587ab6db94.jpg','2013-05-26 21:30:22'),(75,19,'191369575048.jpg','1366 (111).jpg','2013-05-26 21:30:48'),(76,19,'191369575205.jpg','12530224.jpg','2013-05-26 21:33:25'),(77,19,'191369575278.jpg','14140006.jpg','2013-05-26 21:34:39'),(78,19,'191369575303.jpg','14140010.jpg','2013-05-26 21:35:03'),(79,19,'191369988975.jpg','12530112.jpg','2013-05-31 16:29:35'),(80,19,'191374151197.jpg','胡歌0545.jpg','2013-07-18 20:39:57'),(81,19,'191374151353.jpg','动漫05418541.jpg','2013-07-18 20:42:33'),(82,19,'191374151394.jpg','020.JPG','2013-07-18 20:43:14'),(83,19,'191374324915.jpg','Penguins.jpg','2013-07-20 20:55:16'),(84,19,'191374325063.jpg','0012.JPG','2013-07-20 20:57:43'),(85,19,'191374325085.jpg','115.JPG','2013-07-20 20:58:05'),(86,19,'191374326184.jpg','0011.JPG','2013-07-20 21:16:24'),(87,19,'191374326217.jpg','Lighthouse.jpg','2013-07-20 21:16:57'),(88,19,'191374326227.jpg','0017.JPG','2013-07-20 21:17:07'),(90,19,'191376230890.jpg','车身1.jpg','2013-08-11 22:21:30'),(91,19,'191376230933.jpg','123.JPG','2013-08-11 22:22:14'),(92,19,'191376230944.jpg','42.jpg','2013-08-11 22:22:24');
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
INSERT INTO `imgComment` VALUES (17,'2013-05-26 22:04:08','win8霸气',72,19),(18,'2013-05-26 23:42:37','这个是什么星球？',74,19);
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
  `content` text,
  `time` datetime DEFAULT NULL,
  `author_id` int(10) unsigned DEFAULT '0',
  `value` int(10) unsigned DEFAULT '1',
  `visitor_num` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `store_num` smallint(5) unsigned DEFAULT NULL,
  `judgescore` int(10) unsigned NOT NULL DEFAULT '0',
  `price` float(10,2) NOT NULL DEFAULT '0.00',
  `img` tinytext,
  `keyword` char(50) DEFAULT NULL,
  `attr` tinytext,
  `promise` varchar(50) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `author_id` (`author_id`),
  KEY `price` (`price`),
  KEY `author_id_2` (`author_id`),
  FULLTEXT KEY `keyword` (`keyword`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES (27,'物美价廉',' 测试信息','2013-07-23 16:16:15',19,1374567375,23,123,0,13.00,'',';明天;美好;世界;零食;零食饮料;','','送货',0),(28,'物美价廉',' 测试信息','2013-07-23 16:16:31',19,1374567391,5,123,0,13.00,'',';明天;美好;世界;零食;零食饮料;','','送货',2),(30,'物美价廉',' 测试信息','2013-07-23 16:20:36',19,1374567636,3,123,0,13.00,'',';明天;美好;世界;零食;零食饮料;','','送货',0),(31,'物美价廉',' 测试信息','2013-07-23 16:21:07',19,1374567667,3,123,0,13.00,'',';明天;美好;世界;零食;零食饮料;','','送货',2),(32,'物美价廉',' 测试信息','2013-07-23 16:25:56',19,1374567956,4,123,0,13.00,'',';明天;美好;世界;零食;零食饮料;','','送货',2),(33,'物美价廉',' 测试信息','2013-07-23 16:35:37',19,1374568537,0,123,0,13.00,'191374326227.jpg|191374326217.jpg|191374326184.jpg|191374325085.jpg|191374325063.jpg|191374151394.jpg|',';明天;美好;世界;零食;零食饮料;','1,2,款式,颜色,款式是图片,红色12元13件,白色13元10件|13,12;10,13;','送货',2),(34,'物美价廉',' 测试信息','2013-07-23 16:38:45',19,1374568725,4,123,0,13.00,'191374324915.jpg|191374151394.jpg|',';明天;美好;世界;零食;零食饮料;','2,图片,191374326184.jpg,191374326217.jpg|13,10;14,10;','送货',2),(35,'物美价廉',' 测试信息','2013-07-26 13:24:10',19,1374816250,18,123,0,13.00,'191369575022.jpg|191368016876.jpg|191368016856.jpg|191374151353.jpg|191374151394.jpg|191374324915.jpg|',';明天;美好;世界;零食;零食饮料;','','送货',0),(36,'物美价廉',' 测试信息','2013-07-26 13:27:02',19,1374816422,10,123,0,13.00,'191374324915.jpg|191374325063.jpg',';明天;美好;世界;零食;零食饮料;','','送货',0),(37,'物美价廉',' 测试信息','2013-07-26 14:15:02',19,1374819302,27,123,0,13.00,'191369575278.jpg|191369575205.jpg',';明天;美好;世界;零食;零食饮料;','2,颜色,佰色,红色|12,10;12,10','送货',0),(38,'物美价廉',' 测试信息','2013-07-26 14:49:28',19,1374821368,67,123,0,13.00,'',';明天;美好;世界;零食;零食饮料;','','送货',0),(39,'物美价廉',' 测试信息','2013-07-26 14:51:58',19,1374821518,9,123,0,13.00,'',';明天;美好;世界;零食;零食饮料;','','送货',0),(40,'物美价廉',' 测试信息','2013-07-26 14:58:29',19,1374821909,26,123,0,13.00,'191374326227.jpg|191374326217.jpg|191374325085.jpg',';明天;美好;世界;零食;零食饮料;','2,2,图片,颜色,191374326184.jpg,191374326227.jpg,红色10元11个,白色10个10元|11,10;10,10;11,10;10,10','送货',2),(41,'物美价廉',' 测试信息','2013-08-03 22:51:59',19,1375541519,13,123,0,13.00,'',';明天;美好;世界;零食;零食饮料;','','送货',2),(42,'物美价廉',' 测试信息','2013-08-03 22:54:19',19,1375541659,1,123,0,13.00,'',';明天;美好;世界;零食;零食饮料;','','送货',2),(43,'物美价廉',' 测试信息','2013-08-03 22:57:20',19,1375541840,2,123,0,13.00,'',';明天;美好;世界;零食;零食饮料;','','送货',2),(44,'物美价廉','<p><strong><em><span style=\"font-size:48px;\">红色的字体，test</span></em></strong></p><p><span style=\"font-size:16px;\">卖场大优惠啊，买一送一</span></p>','2013-08-03 23:03:49',19,1375542229,35,123,0,13.00,'191374324915.jpg|191374324915.jpg|191374151394.jpg|191374151197.jpg|191374151353.jpg',';明天;美好;世界;零食;零食饮料;','2,颜色,100,阳光色:191374326217.jpg,23,粉色:191374151353.jpg|100,10;23,10','送货',2),(47,'物美价廉','<strong><span style=\"font-size:48px;color:#ff6666;\">青春</span></strong>舞会','2013-08-04 09:41:05',19,1375580465,122,123,21,13.00,'191374326217.jpg|191374326184.jpg|191374325085.jpg|191374324915.jpg',';明天;美好;世界;零食;零食饮料;','2,2,大小,颜色,X: ,XL: ,红色:191374151197.jpg,白色:191374324915.jpg|1,10;2,11;3,12;4,13','送货',2),(48,'物美价廉','<span style=\"font-size:32px;\"> TE<span style=\"color:#ffff00;\">S</span><u>Ting</u></span>','2013-08-04 09:45:48',19,1375580748,154,123,0,13.00,'191374325085.jpg|191374325063.jpg|191374151394.jpg|191374151353.jpg',';明天;美好;世界;零食;零食饮料;','2,大小,X: ,XL: |1,11;2,12','送货',2),(49,'上好的太湖烤鱼','有人想要吗，上好的太湖烤鱼，<strong>肉<u>质鲜美</u></strong>','2013-08-11 22:42:11',19,1376232131,30,123,0,13.00,'191374151197.jpg|191374326227.jpg|191374324915.jpg|191376230944.jpg',';美味;','2,3,重量,口感,1斤30元: ,1斤40元: ,微辣:191376230933.jpg,重辣: ,不辣: |12,10;12,10;123,10;12,10;11,10;11,10','新鲜烤鱼 优质  美味 现买现杀',2),(50,'上好五花肉烤出来的喷香烤肉','<p>想知道什么是<span style=\"font-size:32px;color:#ff0000;\"><strong>一流</strong></span>的烤肉吗？</p><p>想知道什么才是<span style=\"font-size:32px;color:#990000;\">回味</span>悠长吗？</p><p>本店郑重承诺，保质保量</p>','2013-08-20 20:43:10',19,1377002590,202,4000,0,23.00,'191376230933.jpg|191374151353.jpg|191374324915.jpg',';烤肉;送货;','2,2,风味,时间,红烧: ,喷香: ,一个月的烤肉: ,两个月的烤肉: |1000,23;1000,23;1000,23;1000,23','送货上门，优质烤肉',0);
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
INSERT INTO `message` VALUES (1,2,'欢迎来到新世界','NoBody','2013-05-08 01:39:42',0,1,0),(19,1,'有意求该','可以砍价吗？','2013-05-21 05:49:04',0,2,0),(19,1,'买东西','我不仅对你东西感兴趣，也对你人感兴趣，怎么办？','2013-05-26 10:51:23',0,3,0),(19,1,'呵呵','对我的提议感觉如何？','2013-05-26 10:52:23',0,4,0),(19,1,'adta','test','2013-05-26 11:10:30',0,5,0),(19,1,'test','asdfas','2013-05-26 11:11:27',0,6,0),(19,1,'asdfa','asdfa','2013-05-26 11:11:51',0,7,0),(19,1,'sda','sdfas','2013-05-26 11:12:28',0,8,0),(19,1,'sdf','','2013-05-26 11:13:23',0,9,0),(19,1,'asdfa','asdfa','2013-05-26 11:14:53',0,10,0),(19,1,'asdfasdf标题','','2013-05-26 11:15:48',0,11,0),(19,1,'asdfasd','','2013-05-26 11:16:27',0,12,0),(19,1,'asdfasdasdfa','asdfa','2013-05-26 11:17:49',0,13,0),(19,1,'同志 哦','阿德算法速度','2013-05-26 11:18:51',0,14,0),(19,1,'老鼠有多重？','可以用来吃肉吗？','2013-05-26 11:19:16',0,15,0),(19,22,'test','133','2013-05-26 12:06:43',0,16,0),(19,22,'hi','有事没事常联系哦','2013-05-26 12:07:51',0,17,0),(19,20,'test','test','2013-05-30 15:03:06',0,18,0),(19,22,'hi','招呼一下','2013-06-01 15:34:10',0,19,0),(19,22,'hi','招呼而已','2013-06-01 15:34:38',1,20,0),(19,NULL,NULL,'在说些什么嘛','2013-06-13 14:14:42',0,21,7),(19,19,'上好五花肉烤出来的喷香烤肉','想要一个吗？','2013-08-25 02:29:21',1,22,0);
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
) ENGINE=MyISAM AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ord`
--

LOCK TABLES `ord` WRITE;
/*!40000 ALTER TABLE `ord` DISABLE KEYS */;
INSERT INTO `ord` VALUES (65,0,'1&1斤30元|微辣&10&',19,49,'2013-08-17 16:39:41',3,19),(66,0,'1&X&11&',19,48,'2013-08-17 16:39:41',3,19),(67,0,'1&X&11&',19,48,'2013-08-17 16:39:41',3,19),(63,0,'1&X&11&',19,48,'2013-08-17 16:39:41',3,19),(64,0,'1&1斤30元|微辣&10&',19,49,'2013-08-17 16:39:41',3,19),(62,0,'1&X&11&',19,48,'2013-08-17 16:39:41',3,19),(61,0,'1&X&11&/.,,[[-p900989876785(*^^^(*)_)_(_(++_)+_',19,48,'2013-08-14 13:37:51',3,19),(59,0,'1&1斤30元: |微辣:191376230933.jpg&&',19,49,'2013-08-14 13:06:08',5,19),(60,0,'1&1斤30元|微辣&10&阿德发23；‘；。;..',19,49,'2013-08-15 17:13:57',5,19),(58,0,'1&佰色&&',19,37,'2013-08-14 13:01:44',5,19),(54,0,'1&X|红色&10&sdf..,,.,[][][-0-0-',19,47,'2013-08-15 17:13:57',5,19),(55,0,'1&100&&',19,44,'2013-08-14 12:55:44',5,19),(56,0,'1&红色&&',19,37,'2013-08-14 13:01:31',5,19),(57,0,'1&佰色&&',19,37,'2013-08-14 13:01:29',5,19),(53,0,'1&X|红色&10&',19,47,'2013-08-15 17:13:56',5,19),(52,0,'1&X|红色&10&',19,47,'2013-08-15 17:13:56',5,19),(50,0,'1&X|红色&10&',19,47,'2013-08-15 17:13:55',5,19),(51,0,'1&X|红色&10&',19,47,'2013-08-17 08:20:45',3,19),(40,0,'1&&&',19,47,'2013-08-15 17:13:28',5,19),(48,0,'1&100&10&',19,44,'2013-08-15 17:13:27',5,19),(49,0,'1&100&10&',19,44,'2013-08-17 16:19:08',3,19),(39,0,'1&&&',19,47,'2013-08-15 17:13:20',5,19),(41,0,'1&&&',19,47,'2013-08-15 17:13:20',5,19),(42,0,'1&&&',19,47,'2013-08-15 17:13:16',5,19),(43,0,'1&&&',19,47,'2013-08-15 17:13:18',5,19),(44,0,'1&&&',19,47,'2013-08-15 17:13:18',5,19),(45,0,'1&&&',19,47,'2013-08-15 17:13:18',5,19),(46,0,'1&&&',19,47,'2013-08-15 17:13:19',5,19),(47,0,'1&&&加点糖',19,47,'2013-08-15 17:13:19',5,19),(68,0,'1&X&11&',19,48,'2013-08-15 17:13:19',5,19),(69,0,'1&X&11&',19,48,'2013-08-15 17:13:27',5,19),(70,0,'1&X&11&',19,48,'2013-08-15 17:13:26',5,19),(71,1,'1&X&11&',19,48,'2013-08-15 17:13:25',5,19),(72,1,'1&X&11&',19,48,'2013-08-17 08:20:45',3,19),(73,1,'1&X&11&',19,48,'2013-08-17 08:20:45',3,19),(74,0,'1&佰色&10&',19,37,'2013-08-18 06:25:38',1,32),(75,0,'1&佰色&10&',19,37,'2013-08-18 06:44:38',1,32),(76,0,'1&佰色&10&',19,37,'2013-08-18 06:45:42',1,32),(77,1,'1&佰色&10&备注君下午好',19,37,'2013-08-18 06:56:44',1,32),(78,0,'1&红色|18号鞋子& 13.00&',19,35,'2013-08-18 06:59:21',0,32),(79,0,'1&喷香|两个月的烤肉&23&',19,50,'2013-08-24 11:23:02',7,19),(80,0,'1&红烧: |一个月的烤肉: &&',19,50,'2013-08-24 11:23:02',7,19),(81,0,'1&红烧: |一个月的烤肉: &&',19,50,'2013-08-24 11:23:01',7,19),(82,0,'&Array&&',19,50,'2013-08-24 11:23:01',7,19),(83,0,'&Array&&',19,50,'2013-08-24 11:23:01',7,19),(84,0,'&Array&&',19,50,'2013-08-24 11:23:01',7,19),(85,0,'&Array&&',19,50,'2013-08-24 11:23:01',7,19),(86,0,'&Array&&',19,50,'2013-08-24 11:23:00',7,19),(87,0,'&Array&&',19,50,'2013-08-24 11:23:00',7,19),(88,0,'&Array&&',19,50,'2013-08-24 11:23:03',7,19),(89,0,'1&红烧: |一个月的烤肉: &23&',19,50,'2013-08-24 11:33:16',7,19),(90,0,'1&红烧: |一个月的烤肉: &23&',19,50,'2013-08-24 11:33:16',7,19),(91,0,'1&红烧: |一个月的烤肉: &23&',19,50,'2013-08-24 11:33:18',7,19),(92,0,'1&红烧|两个月的烤肉: &23&',19,50,'2013-08-20 15:49:22',0,19),(93,0,'1&红烧|一个月的烤肉&23&',19,50,'2013-08-20 15:52:47',0,19),(94,0,'1&红烧|一个月的烤肉&23&',19,50,'2013-08-20 16:06:48',1,19),(95,0,'1&红烧|一个月的烤肉&23&',19,50,'2013-08-24 11:23:24',0,19),(96,0,'1&红烧|一个月的烤肉&23&',19,50,'2013-08-24 13:59:13',0,19),(97,0,'1&红烧|一个月的烤肉&23&',19,50,'2013-08-24 13:59:20',0,19);
/*!40000 ALTER TABLE `ord` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` char(40) DEFAULT NULL,
  `user_passwd` char(50) DEFAULT NULL,
  `user_type` tinyint(4) NOT NULL DEFAULT '2',
  `reg_time` date DEFAULT NULL,
  `user_photo` char(50) NOT NULL DEFAULT 'edianlogo.jpg',
  `block` tinyint(4) NOT NULL DEFAULT '2',
  `last_login_time` date DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `addr` tinytext NOT NULL,
  `intro` text,
  `contract1` char(15) DEFAULT NULL,
  `contract2` char(30) DEFAULT NULL,
  `mailNum` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `comNum` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `lng` double(10,7) DEFAULT '0.0000000',
  `lat` double(10,7) DEFAULT '0.0000000',
  `impress` text,
  `operst` time NOT NULL DEFAULT '09:00:00',
  `opered` time NOT NULL DEFAULT '17:00:00',
  `work` tinytext,
  `extro` text,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  KEY `user_photo` (`user_photo`),
  KEY `contra` (`contract1`),
  FULLTEXT KEY `user_name_2` (`user_name`,`work`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (19,'tianyi','123',1,'2013-05-07','1368191608.jpg',0,'2013-09-13','','&2343|1344|电子科大&田乙|18991782212|电子科大清水河&田乙|13648044288|电子科大-清水河->电子工程.3010：23:','12;12;12','13648044299','',0,1,103.9347430,30.7563300,NULL,'00:00:00','00:00:00','烧烤;外卖;;送货;送货;送货','dtuName:e点test,intro:,lestPrc:12,dtuNum:122,dtuId:2050'),(20,'tianyi2','123',2,'2013-05-07','1367920625.jpg',0,'2013-06-11','','成都市西源大道2006号电子科技大学电工学院本科20栋404房间','','13648044299','',1,1,103.9347430,30.7593300,NULL,'00:00:00','00:00:00',NULL,NULL),(21,'unasm4','1',2,'2013-05-08','1368015653.jpg',0,'2013-09-12','','成都市西源大道2006号电子科技大学电工学院本科20栋404房间','我是管理员','12346789233','douunasm@gmail.com',0,0,NULL,0.0000000,NULL,'00:00:00','00:00:00',NULL,NULL),(22,'123','123',2,'2013-05-08','edianlogo.jpg',0,'2013-06-20','','','','13648044299','',0,1,NULL,0.0000000,NULL,'00:00:00','00:00:00',NULL,NULL),(23,'tianyi12','123',2,'2013-05-10','edianlogo.jpg',0,'2013-05-10','douunasm@gmail.com','成都市西源大道2006号电子科技大学电工学院本科20栋404房间','大红花','13648044299','',0,0,NULL,0.0000000,NULL,'00:00:00','00:00:00',NULL,NULL),(24,'temp','123',2,'2013-05-10','edianlogo.jpg',0,'2013-05-10','','成都市西源大道2006号电子科技大学电工学院本科20栋404房间','asdasdf','13648044299','asd',0,0,NULL,0.0000000,NULL,'00:00:00','00:00:00',NULL,NULL),(25,'yitian','123',2,'2013-05-10','1368184077.jpg',1,'2013-05-10','','成都市西源大道2006号电子科技大学电工学院本科20栋404房间','','13648044299','',0,0,NULL,0.0000000,NULL,'00:00:00','00:00:00',NULL,NULL),(26,'unasm','123',1,'2013-06-11','1370935219.jpg',0,'2013-06-11','douunasm@gmail.com','china','顾客就是上课','13648044299','1264310280',0,0,NULL,0.0000000,NULL,'00:00:00','00:00:00',NULL,NULL),(27,'abc','abc',1,'2013-06-20','edianlogo.jpg',1,'2013-07-02','','成都市西源大道2006号电子科技大学电工学院本科20栋404房间','','13648044299','',0,0,103.9371170,30.7576070,NULL,'00:00:00','00:00:00',NULL,NULL),(28,'abcd','abc',1,'2013-06-20','1371714431.jpg',1,'2013-06-20','','成都市西源大道2006号电子科技大学电工学院本科20栋404房间','为人民服务','13648044299','',0,0,103.9370940,30.7574480,NULL,'00:00:00','00:00:00',NULL,NULL),(29,'bbb','abc',1,'2013-06-20','edianlogo.jpg',1,'2013-06-20','','成都市西源大道2006号电子科技大学电工学院本科20栋404房间','','13648044299','',0,0,103.9353280,30.7563960,NULL,'00:00:00','00:00:00',NULL,NULL),(30,'é¡ºæ±Ÿç«é”…åº—','123',1,'2013-08-01','edianlogo.jpg',1,NULL,'','æˆéƒ½å¸‚è¥¿æºå¤§é“2006å·ç”µå­ç§‘æŠ€å¤§å­¦ç”µå·¥å­¦é™¢æœ¬ç§‘20æ ‹404æˆ¿é—´','','13648044299','',0,0,0.0000000,0.0000000,NULL,'09:00:00','17:00:00',';é›¶é£Ÿ;çƒ§çƒ¤;å¤–å–;;送货',NULL),(31,'顺江烧烤店','123',1,'2013-08-01','1375337853.jpg',0,'2013-08-01','','成都市西源大道2006号电子科技大学电工学院本科20栋404房间','','13648044299','',0,0,0.0000000,0.0000000,NULL,'08:00:00','23:00:00',';零食;烧烤;外卖;;送货',NULL),(32,'edadmin','adminpasswd',3,'2013-08-16','edianlogo.jpg',0,'2013-08-25',NULL,'&星辰工作室|13648044299|电子科大清水河404房间&星辰|13648044299|电子科大清水河20#404房间',NULL,'136480044299',NULL,0,0,0.0000000,0.0000000,NULL,'09:00:00','17:00:00',NULL,'dtuName:,intro:,lestPrc:,dtuNum:');
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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wrong`
--

LOCK TABLES `wrong` WRITE;
/*!40000 ALTER TABLE `wrong` DISABLE KEYS */;
INSERT INTO `wrong` VALUES (11,'{\"info\":[{\"info\":\"u4f70u8272\",\"seller\":\"19\",\"item_id\":\"37\",\"buyNum\":\"1\",\"more\":\"u5907u6ce8u541bu4e0bu5348u597d\",\"price\":\"10\",\"ordId\":\"77\"}],\"addr\":\"1\",\"userId\":\"32\",\"pntState\":\"error\"}'),(12,'{\"info\":[{\"info\":\"\\u7ea2\\u8272|18\\u53f7\\u978b\\u5b50\",\"seller\":\"19\",\"item_id\":\"35\",\"buyNum\":\"1\",\"more\":\"\",\"price\":\" 13.00\",\"ordId\":\"78\"}],\"addr\":\"0\",\"userId\":\"32\",\"pntState\":\"error\"}'),(13,'{\"info\":[{\"info\":\"\\u7ea2\\u70e7|\\u4e00\\u4e2a\\u6708\\u7684\\u70e4\\u8089\",\"seller\":\"19\",\"item_id\":\"50\",\"buyNum\":\"1\",\"more\":\"\",\"price\":\"23\",\"ordId\":\"94\"}],\"addr\":\"0\",\"userId\":\"19\",\"pntState\":\"error\"}');
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

-- Dump completed on 2013-09-13 16:39:21
