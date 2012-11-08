-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 03. Nov 2012 um 14:13
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
-- Tabellenstruktur für Tabelle `base_log`
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

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `base_people`
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
-- Daten für Tabelle `base_people`
--

INSERT INTO `base_people` (`pernr`, `first_name`, `last_name`, `uname`, `is_child`) VALUES
(1, 'Leo Levin', 'Luther', '', 1),
(2, 'Michel', 'Luther', 'b', 0),
(5, 'Janosch', 'Luther', '', 0),
(4, 'Lennart', 'Luther', '', 1),
(3, 'Katja', 'Luther', '', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `base_sessions`
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
-- Daten für Tabelle `base_sessions`
--

INSERT INTO `base_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('13deae0f78397742e8d304a81c473b73', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1; rv:16.0) Gecko/201001', '1351713413', ''),
('171bec9b8f7f7d46ed7f1dc4c0fdaf5d', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1; rv:16.0) Gecko/201001', '1351754898', ''),
('5b8bed15bde5e24b7a6bfe712d90e862', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1; rv:15.0) Gecko/201001', '1350550214', 'a:2:{s:5:"uname";s:1:"b";s:9:"logged_in";b:1;}'),
('f02125a45a10496e02eb458924381a70', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1; rv:16.0) Gecko/201001', '1351712773', 'a:2:{s:5:"uname";s:1:"b";s:9:"logged_in";b:1;}');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `base_users`
--

CREATE TABLE IF NOT EXISTS `base_users` (
  `uname` char(20) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `password` text NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `salt` char(10) NOT NULL,
  `failed_attempts` smallint(6) NOT NULL,
  PRIMARY KEY (`uname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Benutzer im TTS-System';

--
-- Daten für Tabelle `base_users`
--

INSERT INTO `base_users` (`uname`, `date_created`, `password`, `locked`, `salt`, `failed_attempts`) VALUES
('b', '2012-03-20 08:09:12', '50b8f1337196b8037d8bae4aa364f7a2', 0, '2081225274', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sec_roles`
--

CREATE TABLE IF NOT EXISTS `sec_roles` (
  `role_id` char(20) NOT NULL,
  `description` text NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Roles';

--
-- Daten für Tabelle `sec_roles`
--

INSERT INTO `sec_roles` (`role_id`, `description`, `changed_at`, `deleted`) VALUES
('eltern', 'Sorgeberechtigt (sic!)', '0000-00-00 00:00:00', NULL),
('helfer', 'Helfende Hände', '0000-00-00 00:00:00', NULL),
('admin', 'Administrator', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sec_role_content`
--

CREATE TABLE IF NOT EXISTS `sec_role_content` (
  `id` char(20) NOT NULL,
  `description` text NOT NULL,
  `navigation` tinyint(1) NOT NULL,
  `activity` char(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Role contents';

--
-- Daten für Tabelle `sec_role_content`
--

INSERT INTO `sec_role_content` (`id`, `description`, `navigation`, `activity`) VALUES
('overview', 'Überblick über alles', 1, 'stayOver/home'),
('kinder_termine', 'Kindertermine', 1, 'manageKidDates/start'),
('add_user', 'Benutzer hinzufügen', 1, 'admin/add_user'),
('settings', 'Einstellungen', 0, 'settings/start');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sec_role_content_assignments`
--

CREATE TABLE IF NOT EXISTS `sec_role_content_assignments` (
  `role_id` char(20) NOT NULL,
  `content_id` char(20) NOT NULL,
  `index` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`role_id`,`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Content of roles';

--
-- Daten für Tabelle `sec_role_content_assignments`
--

INSERT INTO `sec_role_content_assignments` (`role_id`, `content_id`, `index`) VALUES
('eltern', 'overview', 1),
('helfer', 'overview', 1),
('eltern', 'kinder_termine', 2),
('admin', 'add_user', 1),
('eltern', 'settings', 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sec_role_user_assignments`
--

CREATE TABLE IF NOT EXISTS `sec_role_user_assignments` (
  `role_id` char(20) NOT NULL,
  `uname` char(20) NOT NULL,
  PRIMARY KEY (`role_id`,`uname`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Role Assignments';

--
-- Daten für Tabelle `sec_role_user_assignments`
--

INSERT INTO `sec_role_user_assignments` (`role_id`, `uname`) VALUES
('admin', 'b'),
('eltern', 'b'),
('helfer', 'b');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `so_dates`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Daten für Tabelle `so_dates`
--

INSERT INTO `so_dates` (`id`, `title`, `begda`, `endda`, `begtime`, `endtime`, `note`, `changed_at`, `deleted`) VALUES
(1, 'Abendbrot', '2012-04-18', '2012-04-18', '12:00:00', '13:00:00', 'Essen gehen mit allen', '0000-00-00 00:00:00', NULL),
(15, 'Tag EinsZweiDrei', '2012-07-29', '2012-07-29', NULL, NULL, '...', '0000-00-00 00:00:00', NULL),
(16, 'v1', '2012-07-28', '2012-07-28', NULL, NULL, '...', '0000-00-00 00:00:00', NULL),
(17, 'Eine Sache mit Schuss', '2012-08-31', '2012-08-31', NULL, NULL, 'Guck mal, ob Du was siehst', '0000-00-00 00:00:00', NULL),
(18, 'Berliner Luft schnappen', '2012-08-24', '2012-08-24', NULL, NULL, '...', '0000-00-00 00:00:00', NULL),
(19, 'testteser', '2012-08-15', '2012-08-15', NULL, NULL, '...', '0000-00-00 00:00:00', NULL),
(20, 'testteser', '2012-08-15', '2012-08-15', NULL, NULL, '...', '0000-00-00 00:00:00', NULL),
(21, 'aafdsf', '2012-08-16', '2012-08-24', NULL, NULL, '...', '0000-00-00 00:00:00', NULL),
(22, 'Ein Test im Debugger', '2012-09-22', '2012-09-22', NULL, NULL, 'Nichts zu holen.', '2012-08-31 11:16:12', NULL),
(23, 'Ein Test im Debugger', '2012-09-22', '2012-09-22', NULL, NULL, 'Nichts zu holen.', '2012-08-31 11:17:00', NULL),
(24, 'Ein Termin mit Josch', '2012-10-25', '2012-10-25', NULL, NULL, '...', '2012-10-05 17:49:03', NULL),
(26, 'Ein Termin mit vielen Kindern', '2012-10-31', '2012-10-31', NULL, NULL, 'Kommt alle vorbei, wir brauchen mehr Helfer als alle anderen.', '2012-10-05 18:39:20', NULL),
(27, 'Ein Termin mit vielen Kindern', '2012-10-31', '2012-10-31', NULL, NULL, 'Kommt alle vorbei, wir brauchen mehr Helfer als alle anderen.', '2012-10-05 18:39:27', NULL),
(28, 'Ein Termin mit vielen Kindern', '2012-10-31', '2012-10-31', NULL, NULL, 'Kommt alle vorbei, wir brauchen mehr Helfer als alle anderen.', '2012-10-05 18:41:53', NULL),
(29, 'Ein Termin mit vielen Kindern', '2012-10-31', '2012-10-31', NULL, NULL, 'Kommt alle vorbei, wir brauchen mehr Helfer als alle anderen.', '2012-10-05 18:42:05', NULL),
(30, 'Ein Termin mit vielen Kindern', '2012-10-31', '2012-10-31', NULL, NULL, 'Kommt alle vorbei, wir brauchen mehr Helfer als alle anderen.', '2012-10-05 18:42:24', NULL),
(31, 'Ein Termin mit vielen Kindern', '2012-10-31', '2012-10-31', NULL, NULL, 'Kommt alle vorbei, wir brauchen mehr Helfer als alle anderen.', '2012-10-05 18:42:26', NULL),
(32, 'Ein Termin mit vielen Kindern', '2012-10-31', '2012-10-31', NULL, NULL, 'Kommt alle vorbei, wir brauchen mehr Helfer als alle anderen.', '2012-10-05 18:42:35', NULL),
(33, '4', '2012-10-31', '2012-11-15', NULL, NULL, 'Ein Text, ein guter Text, das ist das beste was es gibt in der Welt.', '2012-10-08 18:28:09', NULL),
(34, '4', '2012-10-31', '2012-11-16', NULL, NULL, 'Ob der wohl richtig ankommt ...', '2012-10-08 18:32:18', NULL),
(35, '1', '2012-10-12', '2012-10-24', NULL, NULL, '...', '2012-10-08 20:02:44', NULL),
(36, 'So neww', '2012-10-12', '2012-10-24', NULL, NULL, '...', '2012-10-08 20:05:05', NULL),
(37, 'So neww', '2012-10-12', '2012-10-24', NULL, NULL, '...', '2012-10-08 20:05:17', NULL),
(38, 'Total neuer Termin, vielleicht mit Kind', '2012-10-31', '2012-11-08', NULL, NULL, '...', '2012-10-08 20:07:46', NULL),
(39, 'Total neuer Termin, vielleicht mit Kind', '2012-10-31', '2012-11-08', NULL, NULL, '...', '2012-10-08 20:07:55', NULL),
(40, 'Total neuer Termin, vielleicht mit Kind', '2012-10-31', '2012-11-08', NULL, NULL, '...', '2012-10-08 20:12:20', NULL),
(41, 'So neww', '2012-10-12', '2012-10-24', NULL, NULL, '...', '2012-10-08 20:13:01', NULL),
(43, 'Testtermin, zum gleich löschen', '2012-10-25', '2012-10-25', NULL, NULL, 'Ganz neu, dieser Termin, und zwar toll', '2012-10-16 14:52:05', NULL),
(44, 'Deleted = 0', '2012-10-31', '2012-10-31', NULL, NULL, 'TestAnmerkung', '2012-10-17 05:55:45', 1),
(45, 'Ein total guter Tag', '2012-10-31', '2012-10-31', NULL, NULL, 'Ein total guter, dieser Tag', '2012-10-17 06:00:28', 1),
(46, 'ein Taaaag', '2012-10-25', '2012-10-26', NULL, NULL, 'Ein e Notiz', '2012-10-17 18:40:03', 0),
(47, 'Ein gannz neues Teil', '2012-11-16', '2012-11-16', NULL, NULL, '...', '2012-10-31 19:19:06', 1),
(48, 'Ein gannz neues Teil', '2012-11-16', '2012-11-16', NULL, NULL, '...', '2012-10-31 19:23:16', 1),
(49, 'Ein gannz neues Teil', '2012-11-16', '2012-11-16', NULL, NULL, '...', '2012-10-31 19:49:38', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `so_date_child`
--

CREATE TABLE IF NOT EXISTS `so_date_child` (
  `date_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`date_id`,`child_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `so_date_child`
--

INSERT INTO `so_date_child` (`date_id`, `child_id`, `changed_at`, `deleted`) VALUES
(1, 1, '0000-00-00 00:00:00', NULL),
(15, 1, '2012-10-05 16:46:45', NULL),
(16, 1, '2012-10-05 16:46:45', NULL),
(17, 1, '0000-00-00 00:00:00', NULL),
(17, 5, '0000-00-00 00:00:00', NULL),
(18, 2, '2012-10-05 16:47:37', NULL),
(19, 1, '2012-10-05 16:47:37', NULL),
(19, 2, '2012-10-05 16:47:37', NULL),
(20, 1, '2012-10-05 16:47:37', NULL),
(21, 1, '2012-10-05 16:47:37', NULL),
(22, 1, '2012-10-05 16:47:37', NULL),
(23, 1, '2012-10-05 16:48:12', NULL),
(24, 5, '2012-10-05 18:07:00', NULL),
(25, 1, '2012-10-05 18:33:46', NULL),
(41, 1, '2012-10-08 20:13:01', NULL),
(42, 1, '2012-10-16 05:56:36', NULL),
(43, 4, '2012-10-16 14:52:05', NULL),
(44, 4, '2012-10-17 05:55:45', NULL),
(45, 1, '2012-10-17 06:00:28', NULL),
(46, 4, '2012-10-17 18:40:03', NULL),
(47, 1, '2012-10-31 19:19:06', NULL),
(48, 1, '2012-10-31 19:23:16', NULL),
(49, 1, '2012-10-31 19:49:38', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `so_date_helper`
--

CREATE TABLE IF NOT EXISTS `so_date_helper` (
  `date_id` int(11) NOT NULL,
  `helper_id` int(11) NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`date_id`,`helper_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `so_helper_child`
--

CREATE TABLE IF NOT EXISTS `so_helper_child` (
  `child_id` int(11) NOT NULL,
  `helper_id` int(11) NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`child_id`,`helper_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `so_helper_child`
--

INSERT INTO `so_helper_child` (`child_id`, `helper_id`, `changed_at`, `deleted`) VALUES
(5, 2, '2012-10-05 17:37:00', NULL),
(1, 3, '2012-10-17 18:49:24', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `so_parent_child`
--

CREATE TABLE IF NOT EXISTS `so_parent_child` (
  `parent_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`parent_id`,`child_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `so_parent_child`
--

INSERT INTO `so_parent_child` (`parent_id`, `child_id`, `changed_at`, `deleted`) VALUES
(2, 1, '0000-00-00 00:00:00', 0),
(1, 5, '2012-10-05 18:21:26', 0),
(2, 4, '0000-00-00 00:00:00', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
