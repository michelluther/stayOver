-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.24-0ubuntu0.12.04.1


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
CREATE TABLE  `stayOver`.`base_people` (
  `pernr` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `uname` char(1) NOT NULL,
  `is_child` tinyint(1) NOT NULL,
  PRIMARY KEY (`pernr`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Menschen im System';
INSERT INTO `stayOver`.`base_people` VALUES  (1,'Leo Levin','Luther','',1),
 (2,'Michel','Luther','b',0);
CREATE TABLE  `stayOver`.`base_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL DEFAULT '0',
  `last_activity` varchar(10) NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Sessiondaten';
INSERT INTO `stayOver`.`base_sessions` VALUES  ('60bd4e8d62ef5834f60739b158d1bbcc','127.0.0.1','Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.22+ ','1344939853','a:2:{s:5:\"uname\";s:1:\"b\";s:9:\"logged_in\";b:1;}'),
 ('5f13b5b020387d3527c495a5f357aadd','127.0.0.1','Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:14.0) Gec','1344941119','a:2:{s:5:\"uname\";s:1:\"b\";s:9:\"logged_in\";b:1;}');
CREATE TABLE  `stayOver`.`base_users` (
  `uname` char(20) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `password` text NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `salt` char(10) NOT NULL,
  `failed_attempts` smallint(6) NOT NULL,
  PRIMARY KEY (`uname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Benutzer im TTS-System';
INSERT INTO `stayOver`.`base_users` VALUES  ('b','2012-03-20 09:09:12','50b8f1337196b8037d8bae4aa364f7a2',0,'2081225274',0);
CREATE TABLE  `stayOver`.`sec_role_content` (
  `id` char(20) NOT NULL,
  `description` text NOT NULL,
  `navigation` tinyint(1) NOT NULL,
  `activity` char(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Role contents';
INSERT INTO `stayOver`.`sec_role_content` VALUES  ('overview','Überblick über alles',1,'stayOver/home'),
 ('kinder_termine','Kindertermine',1,'manageKidDates/start'),
 ('add_user','Benutzer hinzufügen',1,'admin/add_user');
CREATE TABLE  `stayOver`.`sec_role_content_assignments` (
  `role_id` char(20) NOT NULL,
  `content_id` char(20) NOT NULL,
  `index` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`role_id`,`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Content of roles';
INSERT INTO `stayOver`.`sec_role_content_assignments` VALUES  ('eltern','overview',1),
 ('helfer','overview',1),
 ('eltern','kinder_termine',2),
 ('admin','add_user',1);
CREATE TABLE  `stayOver`.`sec_role_user_assignments` (
  `role_id` char(20) NOT NULL,
  `uname` char(20) NOT NULL,
  PRIMARY KEY (`role_id`,`uname`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Role Assignments';
INSERT INTO `stayOver`.`sec_role_user_assignments` VALUES  ('admin','b'),
 ('eltern','b');
CREATE TABLE  `stayOver`.`sec_roles` (
  `role_id` char(20) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Roles';
INSERT INTO `stayOver`.`sec_roles` VALUES  ('eltern','Sorgeberechtigt (sic!)'),
 ('helfer','Helfende Hände'),
 ('admin','Administrator');
CREATE TABLE  `stayOver`.`so_dates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `child_id` int(11) NOT NULL,
  `title` tinytext NOT NULL,
  `begda` date NOT NULL,
  `endda` date NOT NULL,
  `begtime` time DEFAULT NULL,
  `endtime` time DEFAULT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
INSERT INTO `stayOver`.`so_dates` VALUES  (1,1,'Abendbrot','2012-04-18','2012-04-18','12:00:00','13:00:00','Essen gehen mit allen'),
 (3,1,'sdf','0000-00-00','0000-00-00','00:00:00','00:00:00',''),
 (8,1,'asd','2012-04-12','0000-00-00','00:00:00','00:00:00',''),
 (9,1,'asd','0000-00-00','0000-00-00','00:00:00','00:00:00',''),
 (10,1,'qweqwe','0000-00-00','0000-00-00','00:00:00','00:00:00',''),
 (11,1,'asdfasd','0000-00-00','0000-00-00','00:00:00','00:00:00',''),
 (12,1,'asdfasd','0000-00-00','0000-00-00','00:00:00','00:00:00',''),
 (13,1,'asdfasd','0000-00-00','0000-00-00','00:00:00','00:00:00',''),
 (14,1,'testtermin','0000-00-00','0000-00-00','00:00:00','00:00:00',''),
 (15,1,'Tag EinsZweiDrei','2012-07-29','2012-07-29',NULL,NULL,'...'),
 (16,1,'v1','2012-07-28','2012-07-28',NULL,NULL,'...'),
 (17,1,'Eine Sache mit Schuss','2012-08-31','2012-08-31',NULL,NULL,'Guck mal, ob Du was siehst'),
 (18,1,'Berliner Luft schnappen','2012-08-24','2012-08-24',NULL,NULL,'...'),
 (19,1,'testteser','2012-08-15','2012-08-15',NULL,NULL,'...'),
 (20,1,'testteser','2012-08-15','2012-08-15',NULL,NULL,'...');
CREATE TABLE  `stayOver`.`so_helper_child` (
  `child_id` int(11) NOT NULL,
  `helper_id` int(11) NOT NULL,
  PRIMARY KEY (`child_id`,`helper_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE  `stayOver`.`so_parent_child` (
  `parent_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  PRIMARY KEY (`parent_id`,`child_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
INSERT INTO `stayOver`.`so_parent_child` VALUES  (2,1);



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
