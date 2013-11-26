-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 11 月 26 日 19:43
-- 服务器版本: 5.5.34-0ubuntu0.13.04.1
-- PHP 版本: 5.4.9-4ubuntu2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `edian`
--

-- --------------------------------------------------------

--
-- 表的结构 `art`
--

CREATE TABLE IF NOT EXISTS `art` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `boss`
--

CREATE TABLE IF NOT EXISTS `boss` (
  `nickname` char(10) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` char(40) NOT NULL DEFAULT '0',
  `ip_address` char(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('5f0b00838cbeebe452df54223a9d57a8', '127.0.0.1', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36', 1385403177, '');

-- --------------------------------------------------------

--
-- 表的结构 `comItem`
--

CREATE TABLE IF NOT EXISTS `comItem` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `comment` text,
  `reg_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(10) unsigned DEFAULT NULL,
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `art_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`),
  KEY `user_id` (`user_id`),
  KEY `art_id` (`art_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=206 ;

-- --------------------------------------------------------

--
-- 表的结构 `img`
--

CREATE TABLE IF NOT EXISTS `img` (
  `imgName` char(40) NOT NULL,
  `uploadName` varchar(50) NOT NULL,
  `tag` varchar(40) NOT NULL,
  `usedByItem` varchar(200) NOT NULL,
  `uploadStore` int(10) unsigned NOT NULL,
  UNIQUE KEY `imgName` (`imgName`),
  KEY `img_name` (`imgName`),
  KEY `uploadStore` (`uploadStore`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `imgComment`
--

CREATE TABLE IF NOT EXISTS `imgComment` (
  `comId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `time` datetime DEFAULT NULL,
  `comment` text,
  `imgId` int(10) unsigned DEFAULT NULL,
  `userId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`comId`),
  KEY `imgId` (`imgId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- 表的结构 `interest`
--

CREATE TABLE IF NOT EXISTS `interest` (
  `user_id` int(11) NOT NULL,
  `keyword` char(40) DEFAULT NULL,
  `keyValue` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `item`
--

CREATE TABLE IF NOT EXISTS `item` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55 ;

-- --------------------------------------------------------

--
-- 表的结构 `message`
--

CREATE TABLE IF NOT EXISTS `message` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- 表的结构 `online_user`
--

CREATE TABLE IF NOT EXISTS `online_user` (
  `session_id` varchar(35) NOT NULL DEFAULT '0',
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` char(40) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `passwd` char(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`session_id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `ord`
--

CREATE TABLE IF NOT EXISTS `ord` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=149 ;

-- --------------------------------------------------------

--
-- 表的结构 `store`
--

CREATE TABLE IF NOT EXISTS `store` (
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
  `deliveryTime` tinytext,
  `deliveryArea` varchar(20) NOT NULL,
  `credit` float(2,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用于存储商店相关信息' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
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
  `nickname` char(10) NOT NULL,
  `loginName` char(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `loginName` (`loginName`),
  KEY `user_photo` (`photo`),
  KEY `contra` (`phone`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=51 ;

-- --------------------------------------------------------

--
-- 表的结构 `wrong`
--

CREATE TABLE IF NOT EXISTS `wrong` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
