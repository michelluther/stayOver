-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.22-0ubuntu1


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

--
-- Create schema stayOver
--

CREATE DATABASE IF NOT EXISTS stayOver;
USE stayOver;

--
-- Definition of table `stayOver`.`base_people`
--

DROP TABLE IF EXISTS `stayOver`.`base_people`;
CREATE TABLE  `stayOver`.`base_people` (
  `pernr` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `uname` char(1) NOT NULL,
  `is_child` tinyint(1) NOT NULL,
  PRIMARY KEY (`pernr`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Menschen im System';

--
-- Dumping data for table `stayOver`.`base_people`
--

/*!40000 ALTER TABLE `base_people` DISABLE KEYS */;
LOCK TABLES `base_people` WRITE;
INSERT INTO `stayOver`.`base_people` VALUES  (1,'Leo Levin','Luther','',1),
 (2,'Michel','Luther','b',0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `base_people` ENABLE KEYS */;


--
-- Definition of table `stayOver`.`base_sessions`
--

DROP TABLE IF EXISTS `stayOver`.`base_sessions`;
CREATE TABLE  `stayOver`.`base_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL DEFAULT '0',
  `last_activity` varchar(10) NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Sessiondaten';

--
-- Dumping data for table `stayOver`.`base_sessions`
--

/*!40000 ALTER TABLE `base_sessions` DISABLE KEYS */;
LOCK TABLES `base_sessions` WRITE;
INSERT INTO `stayOver`.`base_sessions` VALUES  ('d597a6438428c107aa74248bf2528aa7','127.0.0.1','Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.22+ ','1337505400','a:2:{s:5:\"uname\";s:1:\"b\";s:9:\"logged_in\";b:1;}'),
 ('b1c07199ba44d00ec389910302ab0df6','127.0.0.1','Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:12.0) Gec','1337583831',''),
 ('e4fd1d8004e74887768d68f7b20096c2','127.0.0.1','Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:12.0) Gec','1337536889',''),
 ('b6fc32f998decb85dc234542b2f1fb32','127.0.0.1','Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.22+ ','1337536936','');
UNLOCK TABLES;
/*!40000 ALTER TABLE `base_sessions` ENABLE KEYS */;


--
-- Definition of table `stayOver`.`base_users`
--

DROP TABLE IF EXISTS `stayOver`.`base_users`;
CREATE TABLE  `stayOver`.`base_users` (
  `uname` char(20) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `password` text NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `salt` char(10) NOT NULL,
  `failed_attempts` smallint(6) NOT NULL,
  PRIMARY KEY (`uname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Benutzer im TTS-System';

--
-- Dumping data for table `stayOver`.`base_users`
--

/*!40000 ALTER TABLE `base_users` DISABLE KEYS */;
LOCK TABLES `base_users` WRITE;
INSERT INTO `stayOver`.`base_users` VALUES  ('b','2012-03-20 09:09:12','50b8f1337196b8037d8bae4aa364f7a2',0,'2081225274',0);
UNLOCK TABLES;
/*!40000 ALTER TABLE `base_users` ENABLE KEYS */;


--
-- Definition of table `stayOver`.`sec_role_content`
--

DROP TABLE IF EXISTS `stayOver`.`sec_role_content`;
CREATE TABLE  `stayOver`.`sec_role_content` (
  `id` char(20) NOT NULL,
  `description` text NOT NULL,
  `navigation` tinyint(1) NOT NULL,
  `activity` char(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Role contents';

--
-- Dumping data for table `stayOver`.`sec_role_content`
--

/*!40000 ALTER TABLE `sec_role_content` DISABLE KEYS */;
LOCK TABLES `sec_role_content` WRITE;
INSERT INTO `stayOver`.`sec_role_content` VALUES  ('overview','Überblick über alles',1,'stayOver/home'),
 ('kinder_termine','Kindertermine',1,'manageKidDates/start'),
 ('add_user','Benutzer hinzufügen',1,'admin/add_user');
UNLOCK TABLES;
/*!40000 ALTER TABLE `sec_role_content` ENABLE KEYS */;


--
-- Definition of table `stayOver`.`sec_role_content_assignments`
--

DROP TABLE IF EXISTS `stayOver`.`sec_role_content_assignments`;
CREATE TABLE  `stayOver`.`sec_role_content_assignments` (
  `role_id` char(20) NOT NULL,
  `content_id` char(20) NOT NULL,
  `index` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`role_id`,`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Content of roles';

--
-- Dumping data for table `stayOver`.`sec_role_content_assignments`
--

/*!40000 ALTER TABLE `sec_role_content_assignments` DISABLE KEYS */;
LOCK TABLES `sec_role_content_assignments` WRITE;
INSERT INTO `stayOver`.`sec_role_content_assignments` VALUES  ('eltern','overview',1),
 ('helfer','overview',1),
 ('eltern','kinder_termine',2),
 ('admin','add_user',1);
UNLOCK TABLES;
/*!40000 ALTER TABLE `sec_role_content_assignments` ENABLE KEYS */;


--
-- Definition of table `stayOver`.`sec_role_user_assignments`
--

DROP TABLE IF EXISTS `stayOver`.`sec_role_user_assignments`;
CREATE TABLE  `stayOver`.`sec_role_user_assignments` (
  `role_id` char(20) NOT NULL,
  `uname` char(20) NOT NULL,
  PRIMARY KEY (`role_id`,`uname`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Role Assignments';

--
-- Dumping data for table `stayOver`.`sec_role_user_assignments`
--

/*!40000 ALTER TABLE `sec_role_user_assignments` DISABLE KEYS */;
LOCK TABLES `sec_role_user_assignments` WRITE;
INSERT INTO `stayOver`.`sec_role_user_assignments` VALUES  ('admin','b'),
 ('eltern','b');
UNLOCK TABLES;
/*!40000 ALTER TABLE `sec_role_user_assignments` ENABLE KEYS */;


--
-- Definition of table `stayOver`.`sec_roles`
--

DROP TABLE IF EXISTS `stayOver`.`sec_roles`;
CREATE TABLE  `stayOver`.`sec_roles` (
  `role_id` char(20) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Roles';

--
-- Dumping data for table `stayOver`.`sec_roles`
--

/*!40000 ALTER TABLE `sec_roles` DISABLE KEYS */;
LOCK TABLES `sec_roles` WRITE;
INSERT INTO `stayOver`.`sec_roles` VALUES  ('eltern','Sorgeberechtigt (sic!)'),
 ('helfer','Helfende Hände'),
 ('admin','Administrator');
UNLOCK TABLES;
/*!40000 ALTER TABLE `sec_roles` ENABLE KEYS */;


--
-- Definition of table `stayOver`.`so_dates`
--

DROP TABLE IF EXISTS `stayOver`.`so_dates`;
CREATE TABLE  `stayOver`.`so_dates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `child_id` int(11) NOT NULL,
  `title` tinytext NOT NULL,
  `begda` date NOT NULL,
  `endda` date NOT NULL,
  `begtime` time NOT NULL,
  `endtime` time NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stayOver`.`so_dates`
--

/*!40000 ALTER TABLE `so_dates` DISABLE KEYS */;
LOCK TABLES `so_dates` WRITE;
INSERT INTO `stayOver`.`so_dates` VALUES  (1,1,'Abendbrot','2012-04-18','2012-04-18','12:00:00','13:00:00','Essen gehen mit allen'),
 (3,1,'sdf','0000-00-00','0000-00-00','00:00:00','00:00:00',''),
 (8,1,'asd','2012-04-12','0000-00-00','00:00:00','00:00:00',''),
 (9,1,'asd','0000-00-00','0000-00-00','00:00:00','00:00:00',''),
 (10,1,'qweqwe','0000-00-00','0000-00-00','00:00:00','00:00:00',''),
 (11,1,'asdfasd','0000-00-00','0000-00-00','00:00:00','00:00:00',''),
 (12,1,'asdfasd','0000-00-00','0000-00-00','00:00:00','00:00:00',''),
 (13,1,'asdfasd','0000-00-00','0000-00-00','00:00:00','00:00:00',''),
 (14,1,'testtermin','0000-00-00','0000-00-00','00:00:00','00:00:00','');
UNLOCK TABLES;
/*!40000 ALTER TABLE `so_dates` ENABLE KEYS */;


--
-- Definition of table `stayOver`.`so_helper_child`
--

DROP TABLE IF EXISTS `stayOver`.`so_helper_child`;
CREATE TABLE  `stayOver`.`so_helper_child` (
  `child_id` int(11) NOT NULL,
  `helper_id` int(11) NOT NULL,
  PRIMARY KEY (`child_id`,`helper_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stayOver`.`so_helper_child`
--

/*!40000 ALTER TABLE `so_helper_child` DISABLE KEYS */;
LOCK TABLES `so_helper_child` WRITE;
UNLOCK TABLES;
/*!40000 ALTER TABLE `so_helper_child` ENABLE KEYS */;


--
-- Definition of table `stayOver`.`so_parent_child`
--

DROP TABLE IF EXISTS `stayOver`.`so_parent_child`;
CREATE TABLE  `stayOver`.`so_parent_child` (
  `parent_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  PRIMARY KEY (`parent_id`,`child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stayOver`.`so_parent_child`
--

/*!40000 ALTER TABLE `so_parent_child` DISABLE KEYS */;
LOCK TABLES `so_parent_child` WRITE;
INSERT INTO `stayOver`.`so_parent_child` VALUES  (2,1);
UNLOCK TABLES;
/*!40000 ALTER TABLE `so_parent_child` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
