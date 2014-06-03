-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 14, 2012 at 08:33 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `stayOver`
--

-- --------------------------------------------------------

--
-- Table structure for table `base_log`
--

CREATE TABLE IF NOT EXISTS `base_log` (
  `activity` char(1) NOT NULL,
  `user_id` char(1) NOT NULL,
  `source_type` char(1) NOT NULL,
  `source_id` int(11) NOT NULL,
  `target_type` char(1) NOT NULL,
  `target_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `base_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `base_people`
--

CREATE TABLE IF NOT EXISTS `base_people` (
  `pernr` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `uname` char(1) NOT NULL,
  `is_child` tinyint(1) NOT NULL,
  PRIMARY KEY (`pernr`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Menschen im System';

--
-- Dumping data for table `base_people`
--

INSERT INTO `base_people` (`pernr`, `first_name`, `last_name`, `uname`, `is_child`) VALUES
(1, 'Leo Levin', 'Luther', '', 1),
(2, 'Michel', 'Luther', 'b', 0),
(5, 'Janosch', 'Luther', '', 0),
(4, 'Lennart', 'Luther', '', 1),
(3, 'Katja', 'Luther', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `base_sessions`
--

CREATE TABLE IF NOT EXISTS `base_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL DEFAULT '0',
  `last_activity` varchar(10) NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Sessiondaten';

--
-- Dumping data for table `base_sessions`
--

INSERT INTO `base_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('50db528036624f53d3262505d2c9983a', '0.0.0.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:12', '1355513888', 'a:2:{s:5:"uname";s:1:"b";s:9:"logged_in";b:1;}'),
('c2ae0e8127e899d773504f6736e7c807', '0.0.0.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:12', '1355259482', 'a:2:{s:5:"uname";s:1:"b";s:9:"logged_in";b:1;}');

-- --------------------------------------------------------

--
-- Table structure for table `base_users`
--

CREATE TABLE IF NOT EXISTS `base_users` (
  `uname` char(20) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `password` text NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `salt` char(10) NOT NULL,
  `email` text NOT NULL,
  `failed_attempts` smallint(6) NOT NULL,
  PRIMARY KEY (`uname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Benutzer im TTS-System';

--
-- Dumping data for table `base_users`
--

INSERT INTO `base_users` (`uname`, `date_created`, `password`, `locked`, `salt`, `email`, `failed_attempts`) VALUES
('b', '2012-12-08 13:26:01', '50b8f1337196b8037d8bae4aa364f7a2', 0, '2081225274', 'michel.luther@gmail.com', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sec_roles`
--

CREATE TABLE IF NOT EXISTS `sec_roles` (
  `role_id` char(20) NOT NULL,
  `description` text NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Roles';

--
-- Dumping data for table `sec_roles`
--

INSERT INTO `sec_roles` (`role_id`, `description`, `changed_at`, `deleted`) VALUES
('eltern', 'Sorgeberechtigt (sic!)', '0000-00-00 00:00:00', NULL),
('helfer', 'Helfende Hände', '0000-00-00 00:00:00', NULL),
('admin', 'Administrator', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sec_role_content`
--

CREATE TABLE IF NOT EXISTS `sec_role_content` (
  `id` char(20) NOT NULL,
  `description` text NOT NULL,
  `navigation` tinyint(1) NOT NULL,
  `activity` char(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Role contents';

--
-- Dumping data for table `sec_role_content`
--

INSERT INTO `sec_role_content` (`id`, `description`, `navigation`, `activity`) VALUES
('overview', 'Überblick über alles', 1, 'stayOver/home'),
('kinder_termine', 'Kindertermine', 1, 'manageKidDates/start'),
('add_user', 'Benutzer hinzufügen', 1, 'admin/add_user'),
('settings', 'Einstellungen', 1, 'settings/start'),
('helfer_termine', 'Helfertermine', 1, 'helperDates/start');

-- --------------------------------------------------------

--
-- Table structure for table `sec_role_content_assignments`
--

CREATE TABLE IF NOT EXISTS `sec_role_content_assignments` (
  `role_id` char(20) NOT NULL,
  `content_id` char(20) NOT NULL,
  `index` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`role_id`,`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Content of roles';

--
-- Dumping data for table `sec_role_content_assignments`
--

INSERT INTO `sec_role_content_assignments` (`role_id`, `content_id`, `index`) VALUES
('eltern', 'overview', 1),
('helfer', 'overview', 1),
('eltern', 'kinder_termine', 2),
('admin', 'add_user', 1),
('eltern', 'settings', 99),
('helfer', 'helfer_termine', 4);

-- --------------------------------------------------------

--
-- Table structure for table `sec_role_user_assignments`
--

CREATE TABLE IF NOT EXISTS `sec_role_user_assignments` (
  `role_id` char(20) NOT NULL,
  `uname` char(20) NOT NULL,
  PRIMARY KEY (`role_id`,`uname`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Role Assignments';

--
-- Dumping data for table `sec_role_user_assignments`
--

INSERT INTO `sec_role_user_assignments` (`role_id`, `uname`) VALUES
('admin', 'b'),
('eltern', 'b'),
('helfer', 'b');

-- --------------------------------------------------------

--
-- Table structure for table `so_dates`
--

CREATE TABLE IF NOT EXISTS `so_dates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext NOT NULL,
  `begda` date NOT NULL,
  `endda` date NOT NULL,
  `begtime` time DEFAULT NULL,
  `endtime` time DEFAULT NULL,
  `note` text NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `so_dates`
--

INSERT INTO `so_dates` (`id`, `title`, `begda`, `endda`, `begtime`, `endtime`, `note`, `changed_at`, `deleted`) VALUES
(50, 'testTermin123', '2012-12-20', '2012-12-20', NULL, NULL, 'Sach mal watt', '2012-12-06 21:36:19', 0),
(51, 'Ein Tag am Mehr', '2012-12-24', '2012-12-24', NULL, NULL, 'Pack die Badehose ein, nimm dein kleines Schwesterlein ...', '2012-12-06 22:32:31', 0),
(52, 'Weihnachtsgeschenke kaufen', '2012-12-30', '2012-12-30', NULL, NULL, '...', '2012-12-08 13:11:34', 0);

-- --------------------------------------------------------

--
-- Table structure for table `so_date_child`
--

CREATE TABLE IF NOT EXISTS `so_date_child` (
  `date_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`date_id`,`child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `so_date_child`
--

INSERT INTO `so_date_child` (`date_id`, `child_id`, `changed_at`, `deleted`) VALUES
(50, 1, '2012-12-06 21:36:19', NULL),
(51, 1, '2012-12-08 13:10:33', NULL),
(52, 4, '2012-12-08 13:11:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `so_date_helper`
--

CREATE TABLE IF NOT EXISTS `so_date_helper` (
  `date_id` int(11) NOT NULL,
  `helper_id` int(11) NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`date_id`,`helper_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `so_date_helper`
--

INSERT INTO `so_date_helper` (`date_id`, `helper_id`, `changed_at`, `deleted`) VALUES
(50, 3, '2012-12-06 21:36:52', 0);

-- --------------------------------------------------------

--
-- Table structure for table `so_helper_child`
--

CREATE TABLE IF NOT EXISTS `so_helper_child` (
  `child_id` int(11) NOT NULL,
  `helper_id` int(11) NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`child_id`,`helper_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `so_helper_child`
--

INSERT INTO `so_helper_child` (`child_id`, `helper_id`, `changed_at`, `deleted`) VALUES
(5, 2, '2012-10-05 19:37:00', NULL),
(4, 3, '2012-12-10 22:03:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `so_parent_child`
--

CREATE TABLE IF NOT EXISTS `so_parent_child` (
  `parent_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`parent_id`,`child_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `so_parent_child`
--

INSERT INTO `so_parent_child` (`parent_id`, `child_id`, `changed_at`, `deleted`) VALUES
(2, 1, '0000-00-00 00:00:00', 0),
(1, 5, '2012-10-05 20:21:26', 0),
(2, 4, '0000-00-00 00:00:00', 0);
