-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 31. Mrz 2012 um 12:58
-- Server Version: 5.5.16
-- PHP-Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `stayover`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tts_ci_sessions`
--

CREATE TABLE IF NOT EXISTS `tts_ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL DEFAULT '0',
  `last_activity` varchar(10) NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Sessiondaten';

--
-- Daten für Tabelle `tts_ci_sessions`
--

INSERT INTO `tts_ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('e46b3869f5ba7a27000f442a5ada3f9f', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1; rv:11.0) Gecko/201001', '1332831859', 'a:2:{s:5:"uname";s:1:"b";s:9:"logged_in";b:1;}'),
('08ce84e39d268d1f80a2ada0e42869e8', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1; rv:11.0) Gecko/201001', '1333042436', 'a:2:{s:5:"uname";s:1:"b";s:9:"logged_in";b:1;}');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tts_dates`
--

CREATE TABLE IF NOT EXISTS `tts_dates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `child_id` int(11) NOT NULL,
  `title` tinytext NOT NULL,
  `begda` date NOT NULL,
  `endda` date NOT NULL,
  `begtime` time NOT NULL,
  `endtime` time NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Daten für Tabelle `tts_dates`
--

INSERT INTO `tts_dates` (`id`, `child_id`, `title`, `begda`, `endda`, `begtime`, `endtime`, `note`) VALUES
(1, 1, 'Abendbrot', '2012-04-18', '2012-04-18', '12:00:00', '13:00:00', 'Essen gehen mit allen');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tts_helper_child`
--

CREATE TABLE IF NOT EXISTS `tts_helper_child` (
  `child_id` int(11) NOT NULL,
  `helper_id` int(11) NOT NULL,
  PRIMARY KEY (`child_id`,`helper_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tts_parent_child`
--

CREATE TABLE IF NOT EXISTS `tts_parent_child` (
  `parent_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  PRIMARY KEY (`parent_id`,`child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `tts_parent_child`
--

INSERT INTO `tts_parent_child` (`parent_id`, `child_id`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tts_people`
--

CREATE TABLE IF NOT EXISTS `tts_people` (
  `pernr` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `uname` char(1) NOT NULL,
  `is_child` tinyint(1) NOT NULL,
  PRIMARY KEY (`pernr`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Menschen im TTS-System';

--
-- Daten für Tabelle `tts_people`
--

INSERT INTO `tts_people` (`pernr`, `first_name`, `last_name`, `uname`, `is_child`) VALUES
(1, 'Leo Levin', 'Luther', '', 1),
(2, 'Michel', 'Luther', 'b', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tts_roles`
--

CREATE TABLE IF NOT EXISTS `tts_roles` (
  `role_id` char(20) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Roles';

--
-- Daten für Tabelle `tts_roles`
--

INSERT INTO `tts_roles` (`role_id`, `description`) VALUES
('eltern', 'Sorgeberechtigt (sic!)'),
('helfer', 'Helfende Hände'),
('admin', 'Administrator');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tts_role_content`
--

CREATE TABLE IF NOT EXISTS `tts_role_content` (
  `id` char(20) NOT NULL,
  `description` text NOT NULL,
  `navigation` tinyint(1) NOT NULL,
  `activity` char(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Role contents';

--
-- Daten für Tabelle `tts_role_content`
--

INSERT INTO `tts_role_content` (`id`, `description`, `navigation`, `activity`) VALUES
('overview', 'Überblick über alles', 1, 'stayOver/home'),
('kinder_termine', 'Kindertermine', 1, 'manageKidDates/start'),
('add_user', 'Benutzer hinzufügen', 1, 'admin/add_user');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tts_role_content_assignments`
--

CREATE TABLE IF NOT EXISTS `tts_role_content_assignments` (
  `role_id` char(20) NOT NULL,
  `content_id` char(20) NOT NULL,
  `index` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`role_id`,`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Content of roles';

--
-- Daten für Tabelle `tts_role_content_assignments`
--

INSERT INTO `tts_role_content_assignments` (`role_id`, `content_id`, `index`) VALUES
('eltern', 'overview', 1),
('helfer', 'overview', 1),
('eltern', 'kinder_termine', 2),
('admin', 'add_user', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tts_role_user_assignments`
--

CREATE TABLE IF NOT EXISTS `tts_role_user_assignments` (
  `role_id` char(20) NOT NULL,
  `uname` char(20) NOT NULL,
  PRIMARY KEY (`role_id`,`uname`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Role Assignments';

--
-- Daten für Tabelle `tts_role_user_assignments`
--

INSERT INTO `tts_role_user_assignments` (`role_id`, `uname`) VALUES
('admin', 'b'),
('eltern', 'b');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tts_users`
--

CREATE TABLE IF NOT EXISTS `tts_users` (
  `uname` char(20) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `password` text NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `salt` char(10) NOT NULL,
  `failed_attempts` smallint(6) NOT NULL,
  PRIMARY KEY (`uname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Benutzer im TTS-System';

--
-- Daten für Tabelle `tts_users`
--

INSERT INTO `tts_users` (`uname`, `date_created`, `password`, `locked`, `salt`, `failed_attempts`) VALUES
('b', '2012-03-20 08:09:12', '50b8f1337196b8037d8bae4aa364f7a2', 0, '2081225274', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
