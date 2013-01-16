-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: internal-db.s143442.gridserver.com
-- Generation Time: Jan 15, 2013 at 09:44 PM
-- Server version: 5.1.63-rel13.4
-- PHP Version: 5.3.15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db143442_squash`
--

-- --------------------------------------------------------

--
-- Table structure for table `CLUB`
--

DROP TABLE IF EXISTS `CLUB`;
CREATE TABLE IF NOT EXISTS `CLUB` (
  `CLUB_ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(25) DEFAULT NULL,
  `ADDRESS` varchar(125) DEFAULT NULL,
  PRIMARY KEY (`CLUB_ID`),
  UNIQUE KEY `unique_NAME` (`NAME`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `CLUB`
--

INSERT INTO `CLUB` (`CLUB_ID`, `NAME`, `ADDRESS`) VALUES
(1, 'Hammersmith GLL', 'Chalk Hill Road, Hammersmith, London, W6 8DW');

-- --------------------------------------------------------

--
-- Table structure for table `DIVISION`
--

DROP TABLE IF EXISTS `DIVISION`;
CREATE TABLE IF NOT EXISTS `DIVISION` (
  `DIVISION_ID` int(11) NOT NULL AUTO_INCREMENT,
  `LEAGUE_ID` int(11) NOT NULL,
  `NAME` varchar(25) DEFAULT NULL,
  `ROUND_ID` int(11) NOT NULL,
  PRIMARY KEY (`DIVISION_ID`),
  UNIQUE KEY `unique_ROUND_ID_NAME` (`ROUND_ID`,`NAME`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `DIVISION`
--

INSERT INTO `DIVISION` (`DIVISION_ID`, `LEAGUE_ID`, `NAME`, `ROUND_ID`) VALUES
(1, 1, '1', 1),
(3, 1, '2', 1),
(4, 1, '3', 1),
(5, 2, '1', 2),
(6, 2, '2', 2),
(7, 1, '4', 1),
(8, 2, '3', 2),
(9, 1, '1', 8),
(10, 1, '2', 8),
(11, 1, '3', 8),
(12, 1, '4', 8),
(13, 1, '5', 8),
(14, 2, '1', 9),
(15, 2, '2', 9),
(16, 2, '3', 9);

-- --------------------------------------------------------

--
-- Table structure for table `DIVISION_BACKUP`
--

DROP TABLE IF EXISTS `DIVISION_BACKUP`;
CREATE TABLE IF NOT EXISTS `DIVISION_BACKUP` (
  `DIVISION_ID` int(11) NOT NULL AUTO_INCREMENT,
  `LEAGUE_ID` int(11) NOT NULL,
  `NAME` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`DIVISION_ID`),
  UNIQUE KEY `unique_LEAGUE_ID_NAME` (`LEAGUE_ID`,`NAME`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `DIVISION_BACKUP`
--

INSERT INTO `DIVISION_BACKUP` (`DIVISION_ID`, `LEAGUE_ID`, `NAME`) VALUES
(1, 1, '1'),
(3, 1, '2'),
(4, 1, '3'),
(5, 2, '1'),
(6, 2, '2'),
(7, 1, '4'),
(8, 2, '3');

-- --------------------------------------------------------

--
-- Table structure for table `LEAGUE`
--

DROP TABLE IF EXISTS `LEAGUE`;
CREATE TABLE IF NOT EXISTS `LEAGUE` (
  `LEAGUE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CLUB_ID` int(11) NOT NULL,
  `NAME` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`LEAGUE_ID`),
  UNIQUE KEY `unique_CLUB_ID_NAME` (`CLUB_ID`,`NAME`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `LEAGUE`
--

INSERT INTO `LEAGUE` (`LEAGUE_ID`, `CLUB_ID`, `NAME`) VALUES
(1, 1, 'Evening'),
(2, 1, 'Lunchtime');

-- --------------------------------------------------------

--
-- Table structure for table `MATCHES`
--

DROP TABLE IF EXISTS `MATCHES`;
CREATE TABLE IF NOT EXISTS `MATCHES` (
  `MATCH_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PLAYER_ONE_ID` int(11) NOT NULL,
  `PLAYER_TWO_ID` int(11) NOT NULL,
  `ROUND_ID` varchar(25) DEFAULT NULL,
  `DIVISION_ID` varchar(25) DEFAULT NULL,
  `SCORE` varchar(25) DEFAULT NULL,
  `SCORE_ENTERED_DATE` datetime DEFAULT NULL,
  PRIMARY KEY (`MATCH_ID`),
  UNIQUE KEY `unique_PLAYER_ONE_ID_PLAYER_TWO_ID_ROUND_ID_DIVISION_ID` (`PLAYER_ONE_ID`,`PLAYER_TWO_ID`,`ROUND_ID`,`DIVISION_ID`),
  KEY `foreign_key_ROUND_ID` (`ROUND_ID`),
  KEY `foreign_key_PLAYER_ONE_ID_DIVISION_ID` (`PLAYER_ONE_ID`,`DIVISION_ID`),
  KEY `foreign_key_PLAYER_TWO_ID_DIVISION_ID` (`PLAYER_TWO_ID`,`DIVISION_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=150 ;

--
-- Dumping data for table `MATCHES`
--

INSERT INTO `MATCHES` (`MATCH_ID`, `PLAYER_ONE_ID`, `PLAYER_TWO_ID`, `ROUND_ID`, `DIVISION_ID`, `SCORE`, `SCORE_ENTERED_DATE`) VALUES
(1, 2, 5, '1', '3', NULL, NULL),
(2, 6, 2, '1', '3', NULL, NULL),
(3, 6, 5, '1', '3', '0-3', NULL),
(4, 8, 3, '1', '4', NULL, NULL),
(5, 8, 9, '1', '4', NULL, NULL),
(6, 3, 9, '1', '4', '1-3', NULL),
(7, 10, 4, '2', '5', NULL, NULL),
(8, 8, 11, '1', '4', NULL, NULL),
(9, 3, 11, '1', '4', '3-0', NULL),
(10, 9, 11, '1', '4', '3-0', NULL),
(11, 8, 14, '1', '4', NULL, NULL),
(12, 14, 3, '1', '4', NULL, NULL),
(13, 14, 9, '1', '4', NULL, NULL),
(14, 14, 11, '1', '4', NULL, NULL),
(15, 15, 12, '2', '8', NULL, NULL),
(16, 17, 6, '1', '3', '0-3', NULL),
(17, 17, 2, '1', '3', NULL, NULL),
(18, 17, 5, '1', '3', '0-3', NULL),
(19, 18, 1, '2', '6', NULL, NULL),
(20, 19, 18, '2', '6', NULL, NULL),
(21, 19, 1, '2', '6', NULL, NULL),
(22, 16, 20, '1', '7', '5-0', NULL),
(23, 21, 7, '1', '1', NULL, NULL),
(24, 22, 19, '2', '6', '3-1', NULL),
(25, 22, 18, '2', '6', NULL, NULL),
(26, 22, 1, '2', '6', NULL, NULL),
(27, 23, 8, '1', '4', NULL, NULL),
(28, 23, 14, '1', '4', NULL, NULL),
(29, 23, 3, '1', '4', NULL, NULL),
(30, 23, 9, '1', '4', NULL, NULL),
(31, 23, 11, '1', '4', NULL, NULL),
(32, 26, 21, '1', '1', NULL, NULL),
(33, 26, 7, '1', '1', NULL, NULL),
(34, 23, 27, '1', '4', '3-1', NULL),
(35, 8, 27, '1', '4', NULL, NULL),
(36, 27, 14, '1', '4', NULL, NULL),
(37, 27, 3, '1', '4', '3-2', NULL),
(38, 27, 9, '1', '4', '3-1', NULL),
(39, 27, 11, '1', '4', '3-0', NULL),
(40, 27, 5, '8', '9', NULL, NULL),
(41, 27, 9, '8', '9', NULL, NULL),
(42, 27, 6, '8', '9', NULL, NULL),
(43, 27, 3, '8', '9', NULL, NULL),
(44, 27, 23, '8', '9', NULL, NULL),
(45, 5, 9, '8', '9', NULL, NULL),
(46, 5, 6, '8', '9', NULL, NULL),
(47, 5, 3, '8', '9', NULL, NULL),
(48, 5, 23, '8', '9', NULL, NULL),
(49, 9, 6, '8', '9', NULL, NULL),
(50, 9, 3, '8', '9', NULL, NULL),
(51, 9, 23, '8', '9', NULL, NULL),
(52, 6, 3, '8', '9', NULL, NULL),
(53, 6, 23, '8', '9', NULL, NULL),
(54, 3, 23, '8', '9', NULL, NULL),
(55, 16, 11, '8', '10', NULL, NULL),
(56, 16, 17, '8', '10', NULL, NULL),
(57, 16, 20, '8', '10', NULL, NULL),
(58, 16, 49, '8', '10', NULL, NULL),
(59, 16, 21, '8', '10', NULL, NULL),
(60, 11, 17, '8', '10', NULL, NULL),
(61, 11, 20, '8', '10', NULL, NULL),
(62, 11, 49, '8', '10', NULL, NULL),
(63, 11, 21, '8', '10', NULL, NULL),
(64, 17, 20, '8', '10', NULL, NULL),
(65, 17, 49, '8', '10', NULL, NULL),
(66, 17, 21, '8', '10', NULL, NULL),
(67, 20, 49, '8', '10', NULL, NULL),
(68, 20, 21, '8', '10', NULL, NULL),
(69, 49, 21, '8', '10', NULL, NULL),
(70, 60, 7, '8', '11', NULL, NULL),
(71, 60, 34, '8', '11', NULL, NULL),
(72, 60, 47, '8', '11', NULL, NULL),
(73, 60, 50, '8', '11', NULL, NULL),
(74, 60, 46, '8', '11', NULL, NULL),
(75, 7, 34, '8', '11', NULL, NULL),
(76, 7, 47, '8', '11', NULL, NULL),
(77, 7, 50, '8', '11', NULL, NULL),
(78, 7, 46, '8', '11', NULL, NULL),
(79, 34, 47, '8', '11', NULL, NULL),
(80, 34, 50, '8', '11', NULL, NULL),
(81, 34, 46, '8', '11', NULL, NULL),
(82, 47, 50, '8', '11', NULL, NULL),
(83, 47, 46, '8', '11', NULL, NULL),
(84, 50, 46, '8', '11', NULL, NULL),
(85, 43, 39, '8', '12', NULL, NULL),
(86, 43, 8, '8', '12', NULL, NULL),
(87, 43, 55, '8', '12', NULL, NULL),
(88, 43, 14, '8', '12', NULL, NULL),
(89, 43, 31, '8', '12', NULL, NULL),
(90, 39, 8, '8', '12', NULL, NULL),
(91, 39, 55, '8', '12', NULL, NULL),
(92, 39, 14, '8', '12', NULL, NULL),
(93, 39, 31, '8', '12', NULL, NULL),
(94, 8, 55, '8', '12', NULL, NULL),
(95, 8, 14, '8', '12', NULL, NULL),
(96, 8, 31, '8', '12', NULL, NULL),
(97, 55, 14, '8', '12', NULL, NULL),
(98, 55, 31, '8', '12', NULL, NULL),
(99, 14, 31, '8', '12', NULL, NULL),
(100, 33, 62, '8', '13', NULL, NULL),
(101, 33, 37, '8', '13', NULL, NULL),
(102, 33, 32, '8', '13', NULL, NULL),
(103, 33, 59, '8', '13', NULL, NULL),
(104, 62, 37, '8', '13', NULL, NULL),
(105, 62, 32, '8', '13', NULL, NULL),
(106, 62, 59, '8', '13', NULL, NULL),
(107, 37, 32, '8', '13', NULL, NULL),
(108, 37, 59, '8', '13', NULL, NULL),
(109, 32, 59, '8', '13', NULL, NULL),
(110, 22, 19, '9', '14', NULL, NULL),
(111, 22, 48, '9', '14', NULL, NULL),
(112, 22, 45, '9', '14', NULL, NULL),
(113, 22, 10, '9', '14', NULL, NULL),
(114, 22, 29, '9', '14', NULL, NULL),
(115, 19, 48, '9', '14', NULL, NULL),
(116, 19, 45, '9', '14', NULL, NULL),
(117, 19, 10, '9', '14', NULL, NULL),
(118, 19, 29, '9', '14', NULL, NULL),
(119, 48, 45, '9', '14', NULL, NULL),
(120, 48, 10, '9', '14', NULL, NULL),
(121, 48, 29, '9', '14', NULL, NULL),
(122, 45, 10, '9', '14', NULL, NULL),
(123, 45, 29, '9', '14', NULL, NULL),
(124, 10, 29, '9', '14', NULL, NULL),
(125, 4, 18, '9', '15', NULL, NULL),
(126, 4, 1, '9', '15', NULL, NULL),
(127, 4, 28, '9', '15', NULL, NULL),
(128, 4, 36, '9', '15', NULL, NULL),
(129, 4, 63, '9', '15', NULL, NULL),
(130, 18, 1, '9', '15', NULL, NULL),
(131, 18, 28, '9', '15', NULL, NULL),
(132, 18, 36, '9', '15', NULL, NULL),
(133, 18, 63, '9', '15', NULL, NULL),
(134, 1, 28, '9', '15', NULL, NULL),
(135, 1, 36, '9', '15', NULL, NULL),
(136, 1, 63, '9', '15', NULL, NULL),
(137, 28, 36, '9', '15', NULL, NULL),
(138, 28, 63, '9', '15', NULL, NULL),
(139, 36, 63, '9', '15', NULL, NULL),
(140, 44, 15, '9', '16', NULL, NULL),
(141, 44, 58, '9', '16', NULL, NULL),
(142, 44, 12, '9', '16', NULL, NULL),
(143, 44, 53, '9', '16', NULL, NULL),
(144, 15, 58, '9', '16', NULL, NULL),
(145, 15, 12, '9', '16', NULL, NULL),
(146, 15, 53, '9', '16', NULL, NULL),
(147, 58, 12, '9', '16', NULL, NULL),
(148, 58, 53, '9', '16', NULL, NULL),
(149, 12, 53, '9', '16', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `MATCHES_BACKUP`
--

DROP TABLE IF EXISTS `MATCHES_BACKUP`;
CREATE TABLE IF NOT EXISTS `MATCHES_BACKUP` (
  `MATCH_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PLAYER_ONE_ID` int(11) NOT NULL,
  `PLAYER_TWO_ID` int(11) NOT NULL,
  `ROUND_ID` varchar(25) DEFAULT NULL,
  `DIVISION_ID` varchar(25) DEFAULT NULL,
  `SCORE` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`MATCH_ID`),
  UNIQUE KEY `unique_PLAYER_ONE_ID_PLAYER_TWO_ID_ROUND_ID_DIVISION_ID` (`PLAYER_ONE_ID`,`PLAYER_TWO_ID`,`ROUND_ID`,`DIVISION_ID`),
  KEY `foreign_key_ROUND_ID` (`ROUND_ID`),
  KEY `foreign_key_PLAYER_ONE_ID_DIVISION_ID` (`PLAYER_ONE_ID`,`DIVISION_ID`),
  KEY `foreign_key_PLAYER_TWO_ID_DIVISION_ID` (`PLAYER_TWO_ID`,`DIVISION_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `MATCHES_BACKUP`
--

INSERT INTO `MATCHES_BACKUP` (`MATCH_ID`, `PLAYER_ONE_ID`, `PLAYER_TWO_ID`, `ROUND_ID`, `DIVISION_ID`, `SCORE`) VALUES
(1, 2, 5, '1', '3', NULL),
(2, 6, 2, '1', '3', NULL),
(3, 6, 5, '1', '3', '0-3'),
(4, 8, 3, '1', '4', NULL),
(5, 8, 9, '1', '4', NULL),
(6, 3, 9, '1', '4', '1-3'),
(7, 10, 4, '2', '5', NULL),
(8, 8, 11, '1', '4', NULL),
(9, 3, 11, '1', '4', '3-0'),
(10, 9, 11, '1', '4', '3-0'),
(11, 8, 14, '1', '4', NULL),
(12, 14, 3, '1', '4', NULL),
(13, 14, 9, '1', '4', NULL),
(14, 14, 11, '1', '4', NULL),
(15, 15, 12, '2', '8', NULL),
(16, 17, 6, '1', '3', '0-3'),
(17, 17, 2, '1', '3', NULL),
(18, 17, 5, '1', '3', '0-3'),
(19, 18, 1, '2', '6', NULL),
(20, 19, 18, '2', '6', NULL),
(21, 19, 1, '2', '6', NULL),
(22, 16, 20, '1', '7', '5-0'),
(23, 21, 7, '1', '1', NULL),
(24, 22, 19, '2', '6', '3-1'),
(25, 22, 18, '2', '6', NULL),
(26, 22, 1, '2', '6', NULL),
(27, 23, 8, '1', '4', NULL),
(28, 23, 14, '1', '4', NULL),
(29, 23, 3, '1', '4', NULL),
(30, 23, 9, '1', '4', NULL),
(31, 23, 11, '1', '4', NULL),
(32, 26, 21, '1', '1', NULL),
(33, 26, 7, '1', '1', NULL),
(34, 23, 27, '1', '4', '3-1'),
(35, 8, 27, '1', '4', NULL),
(36, 27, 14, '1', '4', NULL),
(37, 27, 3, '1', '4', '3-2'),
(38, 27, 9, '1', '4', '3-1'),
(39, 27, 11, '1', '4', '3-0');

-- --------------------------------------------------------

--
-- Table structure for table `PLAYER`
--

DROP TABLE IF EXISTS `PLAYER`;
CREATE TABLE IF NOT EXISTS `PLAYER` (
  `PLAYER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `USER_ID` int(11) NOT NULL,
  `DIVISION_ID` varchar(25) DEFAULT NULL,
  `LEAGUE_ID` varchar(25) DEFAULT NULL,
  `STATUS` varchar(25) DEFAULT NULL,
  `SEED` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`PLAYER_ID`),
  UNIQUE KEY `unique_USER_ID_DIVISION_ID` (`USER_ID`,`DIVISION_ID`),
  UNIQUE KEY `unique_USER_ID_LEAGUE_ID` (`USER_ID`,`LEAGUE_ID`),
  KEY `foreign_key_DIVISION_ID` (`DIVISION_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `PLAYER`
--

INSERT INTO `PLAYER` (`PLAYER_ID`, `USER_ID`, `DIVISION_ID`, `LEAGUE_ID`, `STATUS`, `SEED`) VALUES
(1, 1, '15', '2', 'active', '2'),
(2, 1, '3', '1', 'inactive', '2'),
(3, 2, '9', '1', 'active', '3'),
(4, 3, '15', '2', 'active', '1'),
(5, 4, '9', '1', 'active', '2'),
(6, 5, '9', '1', 'active', '2'),
(7, 6, '11', '1', 'active', '1'),
(8, 7, '12', '1', 'active', '3'),
(9, 8, '9', '1', 'active', '3'),
(10, 9, '14', '2', 'active', '1'),
(11, 10, '10', '1', 'inactive', '3'),
(12, 10, '16', '2', 'active', '3'),
(13, 11, '', '', 'active', NULL),
(14, 12, '12', '1', 'active', '3'),
(15, 13, '16', '2', 'active', '3'),
(16, 14, '10', '1', 'active', '4'),
(17, 15, '10', '1', 'active', '2'),
(18, 16, '15', '2', 'active', '2'),
(19, 15, '14', '2', 'active', '2'),
(20, 17, '10', '1', 'active', '4'),
(21, 18, '10', '1', 'active', '1'),
(22, 19, '14', '2', 'active', '2'),
(23, 19, '9', '1', 'active', '3'),
(24, 20, '', '', 'active', NULL),
(25, 21, '', '', 'active', NULL),
(26, 21, '1', '1', 'inactive', '1'),
(27, 22, '9', '1', 'active', '3'),
(28, 23, '15', '2', 'active', '2'),
(29, 24, '14', '2', 'active', '1'),
(30, 24, '3', '1', 'inactive', '2'),
(31, 25, '12', '1', 'active', '3'),
(32, 26, '13', '1', 'active', '3'),
(33, 27, '13', '1', 'active', '3'),
(34, 28, '11', '1', 'active', '1'),
(35, 29, '6', '2', 'inactive', '2'),
(36, 30, '15', '2', 'active', '2'),
(37, 31, '13', '1', 'active', '3'),
(38, 31, '8', '2', 'inactive', '3'),
(39, 32, '12', '1', 'active', '3'),
(40, 33, '1', '1', 'active', '1'),
(41, 34, '1', '1', 'inactive', '1'),
(42, 35, '7', '1', 'active', '4'),
(43, 36, '12', '1', 'active', '2'),
(44, 36, '16', '2', 'active', '2'),
(45, 37, '14', '2', 'active', '1'),
(46, 38, '11', '1', 'active', '2'),
(47, 39, '11', '1', 'active', '2'),
(48, 40, '14', '2', 'active', '1'),
(49, 41, '10', '1', 'active', '1'),
(50, 42, '11', '1', 'active', '2'),
(51, 43, '1', '1', 'inactive', '1'),
(52, 44, '', '', 'active', NULL),
(53, 45, '16', '2', 'active', '3'),
(54, 45, '1', '1', 'inactive', '1'),
(55, 46, '12', '1', 'active', '3'),
(56, 47, '', '', 'active', NULL),
(57, 48, '1', '1', 'inactive', '1'),
(58, 48, '16', '2', 'active', '3'),
(59, 49, '13', '1', 'active', '4'),
(60, 50, '11', '1', 'active', '1'),
(61, 43, '5', '2', 'inactive', '1'),
(62, 51, '13', '1', 'active', '3'),
(63, 52, '15', '2', 'active', '2');

-- --------------------------------------------------------

--
-- Table structure for table `PLAYER_BACKUP`
--

DROP TABLE IF EXISTS `PLAYER_BACKUP`;
CREATE TABLE IF NOT EXISTS `PLAYER_BACKUP` (
  `PLAYER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `USER_ID` int(11) NOT NULL,
  `DIVISION_ID` varchar(25) DEFAULT NULL,
  `LEAGUE_ID` varchar(25) DEFAULT NULL,
  `STATUS` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`PLAYER_ID`),
  UNIQUE KEY `unique_USER_ID_DIVISION_ID` (`USER_ID`,`DIVISION_ID`),
  UNIQUE KEY `unique_USER_ID_LEAGUE_ID` (`USER_ID`,`LEAGUE_ID`),
  KEY `foreign_key_DIVISION_ID` (`DIVISION_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=64 ;

--
-- Dumping data for table `PLAYER_BACKUP`
--

INSERT INTO `PLAYER_BACKUP` (`PLAYER_ID`, `USER_ID`, `DIVISION_ID`, `LEAGUE_ID`, `STATUS`) VALUES
(1, 1, '6', '2', 'active'),
(2, 1, '3', '1', 'inactive'),
(3, 2, '4', '1', 'active'),
(4, 3, '5', '2', 'active'),
(5, 4, '3', '1', 'active'),
(6, 5, '3', '1', 'active'),
(7, 6, '1', '1', 'active'),
(8, 7, '4', '1', 'active'),
(9, 8, '4', '1', 'active'),
(10, 9, '5', '2', 'active'),
(11, 10, '4', '1', 'active'),
(12, 10, '8', '2', 'active'),
(13, 11, '', '', 'active'),
(14, 12, '4', '1', 'active'),
(15, 13, '8', '2', 'active'),
(16, 14, '7', '1', 'active'),
(17, 15, '3', '1', 'active'),
(18, 16, '6', '2', 'active'),
(19, 15, '6', '2', 'active'),
(20, 17, '7', '1', 'active'),
(21, 18, '1', '1', 'active'),
(22, 19, '6', '2', 'active'),
(23, 19, '4', '1', 'active'),
(24, 20, '', '', 'active'),
(25, 21, '', '', 'active'),
(26, 21, '1', '1', 'inactive'),
(27, 22, '4', '1', 'active'),
(28, 23, '6', '2', 'active'),
(29, 24, '5', '2', 'active'),
(30, 24, '3', '1', 'active'),
(31, 25, '4', '1', 'active'),
(32, 26, '4', '1', 'active'),
(33, 27, '4', '1', 'active'),
(34, 28, '1', '1', 'active'),
(35, 29, '6', '2', 'inactive'),
(36, 30, '6', '2', 'active'),
(37, 31, '4', '1', 'active'),
(38, 31, '8', '2', 'inactive'),
(39, 32, '4', '1', 'active'),
(40, 33, '1', '1', 'active'),
(41, 34, '1', '1', 'inactive'),
(42, 35, '7', '1', 'active'),
(43, 36, '3', '1', 'active'),
(44, 36, '6', '2', 'active'),
(45, 37, '5', '2', 'active'),
(46, 38, '3', '1', 'active'),
(47, 39, '3', '1', 'active'),
(48, 40, '5', '2', 'active'),
(49, 41, '1', '1', 'active'),
(50, 42, '3', '1', 'active'),
(51, 43, '1', '1', 'inactive'),
(52, 44, '', '', 'active'),
(53, 45, '8', '2', 'active'),
(54, 45, '1', '1', 'inactive'),
(55, 46, '4', '1', 'active'),
(56, 47, '', '', 'active'),
(57, 48, '1', '1', 'inactive'),
(58, 48, '8', '2', 'active'),
(59, 49, '7', '1', 'active'),
(60, 50, '1', '1', 'active'),
(61, 43, '5', '2', 'inactive'),
(62, 51, '4', '1', 'active'),
(63, 52, '6', '2', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `ROUND`
--

DROP TABLE IF EXISTS `ROUND`;
CREATE TABLE IF NOT EXISTS `ROUND` (
  `ROUND_ID` int(11) NOT NULL AUTO_INCREMENT,
  `START` datetime NOT NULL,
  `END` datetime NOT NULL,
  `LEAGUE_ID` int(11) NOT NULL,
  PRIMARY KEY (`ROUND_ID`),
  UNIQUE KEY `unique_LEAGUE_ID_START` (`LEAGUE_ID`,`START`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `ROUND`
--

INSERT INTO `ROUND` (`ROUND_ID`, `START`, `END`, `LEAGUE_ID`) VALUES
(1, '2012-11-14 00:00:00', '2013-01-15 00:00:00', 1),
(2, '2012-11-14 00:00:00', '2013-01-15 00:00:00', 2),
(8, '2013-01-16 00:00:00', '2013-02-20 00:00:00', 1),
(9, '2013-01-16 00:00:00', '2013-02-20 00:00:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ROUND_BACKUP`
--

DROP TABLE IF EXISTS `ROUND_BACKUP`;
CREATE TABLE IF NOT EXISTS `ROUND_BACKUP` (
  `ROUND_ID` int(11) NOT NULL AUTO_INCREMENT,
  `DIVISION_ID` int(11) NOT NULL,
  `START` datetime NOT NULL,
  `END` datetime NOT NULL,
  PRIMARY KEY (`ROUND_ID`),
  UNIQUE KEY `unique_DIVISION_ID_START` (`DIVISION_ID`,`START`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ROUND_BACKUP`
--

INSERT INTO `ROUND_BACKUP` (`ROUND_ID`, `DIVISION_ID`, `START`, `END`) VALUES
(1, 1, '2012-11-14 00:00:00', '2012-12-19 00:00:00'),
(2, 3, '2012-11-14 00:00:00', '2012-12-19 00:00:00'),
(3, 4, '2012-11-14 00:00:00', '2012-12-19 00:00:00'),
(4, 7, '2012-11-14 00:00:00', '2012-12-19 00:00:00'),
(5, 5, '2012-11-14 00:00:00', '2012-12-19 00:00:00'),
(6, 6, '2012-11-14 00:00:00', '2012-12-19 00:00:00'),
(7, 8, '2012-11-14 00:00:00', '2012-12-19 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `SESSION`
--

DROP TABLE IF EXISTS `SESSION`;
CREATE TABLE IF NOT EXISTS `SESSION` (
  `SESSION_ID` varchar(128) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `STATUS` varchar(12) DEFAULT NULL,
  `CREATED` datetime DEFAULT NULL,
  `LAST_ACTIVITY` datetime DEFAULT NULL,
  PRIMARY KEY (`SESSION_ID`),
  KEY `foreign_key_USER_ID` (`USER_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `SESSION`
--

INSERT INTO `SESSION` (`SESSION_ID`, `USER_ID`, `STATUS`, `CREATED`, `LAST_ACTIVITY`) VALUES
('189545841250f3ebdd49fae8.35361433AF2c064e2613bf24ff5fffdb3e0b65fb3c51d9d151', 22, 'inactive', '2013-01-14 03:28:29', '2013-01-14 03:36:32'),
('163392515950f3db33582e56.36973928AFfdf516f5f9c9a5e831d7a853f837b0687d4cc70e', 52, 'inactive', '2013-01-14 02:17:23', '2013-01-14 02:18:45'),
('184493748050f40c4a17a513.95874641AF285590812e61a5e65539df1ec418f70d89209622', 52, 'inactive', '2013-01-14 05:46:50', '2013-01-14 05:48:04'),
('203490449550f42702413144.72354479AFe9b600b7b0a751f3f4adbf9db1ece8f46c647a91', 4, 'inactive', '2013-01-14 07:40:50', '2013-01-14 07:41:04'),
('14757133450f2f4ad8e9000.05703858AFA2a22ea0c45af824bc935c41cda87268e2ff235ef', 1, 'inactive', '2013-01-13 09:53:49', '2013-01-13 10:01:40'),
('98771734750f63c17e5a290.37817932AFAfd11c82329d98dbc281ad45d72ab8a8243a30646', 1, 'active', '2013-01-15 21:35:19', '2013-01-15 21:42:40');

-- --------------------------------------------------------

--
-- Table structure for table `USER`
--

DROP TABLE IF EXISTS `USER`;
CREATE TABLE IF NOT EXISTS `USER` (
  `USER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(25) DEFAULT NULL,
  `PASSWORD` varchar(250) DEFAULT NULL,
  `HASH_SALT` varchar(125) DEFAULT NULL,
  `EMAIL` varchar(75) DEFAULT NULL,
  `MOBILE` varchar(25) DEFAULT NULL,
  `MOBILE_PRIVACY` varchar(25) DEFAULT NULL,
  `USER_ACTIVATION_KEY` varchar(20) DEFAULT NULL,
  `TYPE` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`USER_ID`),
  UNIQUE KEY `unique_EMAIL` (`EMAIL`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `USER`
--

INSERT INTO `USER` (`USER_ID`, `NAME`, `PASSWORD`, `HASH_SALT`, `EMAIL`, `MOBILE`, `MOBILE_PRIVACY`, `USER_ACTIVATION_KEY`, `TYPE`) VALUES
(1, 'James Bloom', '6ca2c17cbcc9c096e287cf9d036fae9b13aad066', '434396415090388604a6e1.15009229AFAF', 'jamesdbloom@gmail.com', '07515900569', 'opponent', '', 'player'),
(2, 'Paul Taylor', '2ea4723678d8cfe918c1c3006d594365ffc9a421', '13800889335092fd431a6514.11424365AF', 'email@paultaylor.me', '07545193120', 'opponent', '', 'player'),
(3, 'Robert Hotchkiss', '11a7359b9da9164512546b0bf0fc35af06017ba2', '133746342150936e007e33b5.00836054AF', 'robert.hotchkiss@cw.com', '07920535611', 'opponent', 'VnD^GZbW72f6TD5oye*A', 'player'),
(4, 'John KEEN', 'df45106f506a26380722ec9b4a6c923cd739d623', '12287692405093853c357893.98130114AF', 'jk@nowmedical.co.uk', '07960585315', 'opponent', '', 'player'),
(5, 'David Beguier-Barnett', 'd534686cff01c718d2308445e0fae23020593d59', '20821924445093ac414a0d44.99644596AF', 'david@beguier.com', '07770694009', 'opponent', '%TqTa^D7Ynt^F^AYOvO@', 'player'),
(6, 'Marco Cioni', '423d1ef4af1f187dc84d23aa3112213bcb40ba3e', '15147130325093be18379213.11328462AF', 'marco.cioni@haymarket.com', '07920581913', 'opponent', '', 'player'),
(7, 'Catherine', 'a86cf7a1d8f27534928b9e3752d0f9d2f4ce5397', '3369144905093e5a01b85d4.10152055AFA', 'catherinemlittle@gmail.com', '07968349595', 'opponent', '))iy%MLQ3FjepmOzzMag', 'player'),
(8, 'Ray Swanton', '1e6894f5a13358cedfad69ae227aae89732d3fc8', '20335988585094216252af38.68461495AF', 'swantonray@gmail.com', '07983530293', 'opponent', 'Iy^o&)O#yJQP#H)(m3qH', 'player'),
(9, 'jules townshend', '82f563d8804917f570d21d413f276fbf2aba5c07', '630280649509648a7227c30.38959100AFA', 'j.townshend@mmu.ac.uk', '037950996387', 'opponent', 'p9TAT&sRYT9kHN8Tekre', 'player'),
(10, 'Robin Bruce', 'b9e76f7217f9a86c7f579a23a9ac68473f4f8076', '6933252645096e5599b0456.90112112AFA', 'robin.bruce@gmail.com', '07811261892', 'opponent', '', 'player'),
(11, 'rebecca', '7d5609cc0e4f3e6c2d8b49320de22d23dcfd63fa', '123369053509a0c831b7542.11695494AFA', 'rebecca.long@gll.org', '00000000000', 'secret', 'mG8aFrO90sq&)#pOLH95', 'player'),
(12, 'Joanna Kennedy', '8c6a24920d5bcd2bd79444a0a951fa326dfeac96', '1595011920509a71d5e0bc57.24989126AF', 'jpakennedy@tiscali.co.uk', '07989711562', 'opponent', 'h4XOEM2&AHT@5#z0$yPB', 'player'),
(13, 'Matt Dold', '4b2dcd6b6e081855490d64c94f77b8574ea137ff', '2003569389509a7f68457437.14929108AF', 'matt@savioursnacks.com', '07597675810', 'opponent', 'HqM51sfVmTmbPMkCHOVw', 'player'),
(14, 'Jonathan Bouldin', '0fb82edefd5fca2e142d37e2f6bca8b76ef60243', '38354709509ab32676b2c7.70258006AFAF', 'jonathanbouldin@hotmail.com', '07970423563', 'opponent', 'nH2htJf%wBdYi5)K&LqC', 'player'),
(15, 'Bruna Petrillo', '42b9f47f83e06e9671bb1da289c99c2988fcdf06', '1473293582509ab4926d4180.06617393AF', 'bruninha.marchesi.p@gmail.com', '07810696608', 'opponent', 'Nl*ff0lEK7mwLl*MZuOU', 'player'),
(16, 'Greg Huszcza', '6e6720b9ab6a412f5d78712894f580ba98c31366', '1037376195509bcf9d35b170.23895572AF', 'greg.huszcza@hfbp.co.uk', '07908 810223', 'opponent', 'h7&K5@(blcBQBNS3np%^', 'player'),
(17, 'trovers', 'b1060dfd2624933a0488b24c68a5ed26aecc327f', '1042382789509cc8d09ec2c2.67174274AF', 'trovers@gmail.com', '07790348951', 'opponent', 'dpLdtrJTXJs1IZr&4Z9w', 'player'),
(18, 'Daniel Marks', 'f75aac31bd1ee2b39cbac2747d1fc4142e64b26d', '380626648509d9766b75679.82000359AFA', 'dan@dsmrisksolutions.co.uk', '07871811550', 'opponent', 'kqPTMyDvYD2OqjXl(8#Z', 'player'),
(19, 'Andrea Caldera', '41e4631a9faf7c856fc7f018518a7aeb76546f60', '156128162150a0d92b601bc2.60573851AF', 'andrea.caldera@gmail.com', '07850404421', 'opponent', '', 'player'),
(20, 'Shane Muckle', '568e0ffb4e4c547c0750c604396e6f8a87d96ca0', '190790886850a13b1dde7ba6.92729530AF', 'muxieb2@hotmail.com', '07503117740', 'opponent', 'EPH3g$qt(*V!dSB%Z49#', 'player'),
(21, 'Amy Rattray', 'fd99c6791c50397e05dcbdfb7542a844586d573c', '177431315150a13c676ba410.20703661AF', 'amyjunerattray@gmail.com', '07990685335', 'opponent', '', 'player'),
(22, 'James Trundle', '3ed0b44ee4768af9b313409efc370352b65d8f20', '214114767950a27e6e6332e4.33929817AF', 'jwtrundle@gmail.com', '07788108446', 'opponent', 'OybR*EwAC4Hz@r6zICUd', 'player'),
(23, 'Jardine Finn', '98dc71e0e1c6d613478927756f379d453af6a918', '18911083450a39e18757a53.62421208AFA', 'jardine.finn@lbhf.gov.uk', '07903864846', 'opponent', '', 'player'),
(24, 'Phil Harrison', 'cc830634b972872aa5b831bcb42ab57652eba08c', '169981571950a3a8e6acfa70.21533745AF', 'philipmharrison2@gmail.com', '07730822637', 'opponent', '', 'player'),
(25, 'Jon Blake', 'f78ff3f8ab72a90f418fd15e452b4ab89b7dcc3d', '122305434550a3c3902a2132.80645788AF', 'jonathan.blake@emimusic.com', '07916562559', 'opponent', 'M7QPp22ilRUa08%r6(7!', 'player'),
(26, 'Tim van Nispen', 'ec2617565a2b6e011cb87519e0a1c327ec12cfc0', '71978737050a3c3adcf2a97.57717894AFA', 'timvannispen@gmail.com', '07557949594', 'secret', '', 'player'),
(27, 'Kirsty Heeley', '72a79eece57be92d66d17649f97c166281c4b93d', '44985310750a3c3b2375e24.60558702AFA', 'k.heeley@savethechildren.org.uk', '07791397862', 'opponent', '^2b*uev7cBkOnN%u(U9@', 'player'),
(28, 'Peter Kim', 'e57be41bbda390107d4b24202a10d07e772c6995', '94862998250a3c5835e3b74.30995958AFA', 'pkim@arpllp.com', '', '', 'rs9@9UuGXd7EkyZy02X(', 'player'),
(29, 'Douglas Friedberg', 'b2ae40feca864b90f1b9112e44ce64b21fd7d546', '196433285950a3c64c77ba52.61521769AF', 'friedbergdvah@hotmail.com', '07810170063', 'secret', 'UtI&^D!Rmz6t8N3rbCq0', 'player'),
(30, 'Neil Malde', 'a951f2e6c9852cfa7f7f840effe7191d4ed4935d', '1423409950a3c723796232.12500680AFAF', 'nmalde@bechtel.com', '07733260764', 'opponent', '', 'player'),
(31, 'Mohamed Hamza', '702ffe7e63a419892cf946432d4121b68e3b14ab', '99848782850a3c9a29343c9.20482925AFA', 'mh3488@gmail.com', '07825169104', 'opponent', 'n#&EA0A2RD&OODlWkE#5', 'player'),
(32, 'Ben Cochrane', '1f5ad5758d3c0a6f9f7c24a82751a1729d0585db', '7265270450a3ca80be7c54.24543964AFAF', 'benjamin.j.cochrane@gmail.com', '07590505519', 'opponent', '', 'player'),
(33, 'Benoit Obadia', '74e1a2b868fad46a9fd7c19b6724da926a315ae6', '119900872250a3d65944f232.39515962AF', 'benoit.obadia@gmail.com', '07943834373', 'opponent', '', 'player'),
(34, 'Peadar Stack', '91723b862748855faba64f362ffb3d7d2a13a1cc', '62405756150a3f33f7f3441.19135960AFA', 'pstack04@hotmail.com', '07413526994', 'secret', 'GSz@IRqPMhOK456XxD0A', 'player'),
(35, 'Craig Kenworthy', '9e1afd287607ca238749e5ab656810d1c34ee3d9', '179083039950a3fbcb32ee71.31841096AF', 'craigkenworthy@hotmail.com', '07527766966', 'opponent', '8uR1s9vAAVxSC8B2rbSD', 'player'),
(36, 'Tom P', '946d819e2a4050f6733e5012ba962b027ea11e61', '99891468550a4158c284705.81228174AFA', 'tpearce@sebastianconran.com', '07775994289', 'opponent', '@W9fX6H9oin(4crf3PQd', 'player'),
(37, 'Joe Klimi', '3b31e5c9b3bf6c9fc75be2165a0bf3e73c73f137', '143604053150a49d0ba07566.55509223AF', 'joe@karenandjoe.co.uk', '07882432014', 'opponent', 'Hf6kV5IZ5A&L!IZ4Rum!', 'player'),
(38, 'taryn armitage', '7cf4271bd4a1cba15dd87e39fd493300a0627b08', '105158020350a4c21bbd1a52.75065471AF', 'tarynarmitage@gmail.com', '07523843257', 'secret', 'LD3neGbiNmvZEGmkJ#iy', 'player'),
(39, 'Brendan', '2ed859a7d595d5b6fa07279738105a8b9a875447', '199108446150a4c5a3cd7a97.88984815AF', 'brwoodnz@gmail.com', '07765111349', 'secret', 'uo&J7$%*b@JMpG6JdRvx', 'player'),
(40, 'Alistair Cossins', '19455feb0cf14e2b14f1322a17d3ebb5150a9e0b', '100501142750a4cdd546f248.93125444AF', 'alistair.cossins@disney.com', '', 'secret', '7@VAqcWTZL6Ya865n78(', 'player'),
(41, 'Ajith', '4cfe74542d6ef1af641f63ccbd5db7bbad70f0bd', '17247373050a4cead2f25b8.51827132AFA', 'writetoajith@gmail.com', '07846421279', 'opponent', '', 'player'),
(42, 'Patrick ONeill', '36ae64ad680366ced33962350582a0a62fca61d5', '156925413850aa314177e879.09154603AF', 'pjmon@hotmail.co.uk', '07879465663', 'opponent', '*$Q9*vtMGBJD)sPlCkvG', 'player'),
(43, 'Richard Pile', '2f2810927fd1738238d0177218245b6c0191eaab', '155542563950abb3ed8927e0.17737105AF', 'rlpile@gmail.com', '07947643747', 'opponent', 'zLSfbq(y)iz2V3F7eliE', 'player'),
(44, 'Administrator', '162504803c1074bb5e99431f89ccd06a508f048c', '140992476750ac0cf22cb121.66449547AF', 'james.bloom@betfair.com', '07515900569', 'opponent', 'hgm%IBEYr3uEK#w33U0p', 'player'),
(45, 'Scott Hands', '747d37477d7c24ca6791dc35494fa4709434dd21', '38372983750aca040be9564.90319492AFA', 'scott.hands@cw.com', '07822859394', 'opponent', 'swE^Npr*^9j0Gk0Xr3wA', 'player'),
(46, 'Dan Morley', '9a3ca9975dd89137ac21702dad02f7bde4caa729', '206701257050acc11245aee9.96338641AF', 'morley_daniel@yahoo.co.uk', '07793037582', 'opponent', '', 'player'),
(47, 'Tracey Evans', '439e02230e56c6a9f711de0c95c70f869e88ba7f', '6390585750ad2d889d2eb1.44955171AFAF', 'tracey.evans@gll.org', '', 'secret', '65^eTtV6PUYfjy&Ry49Y', 'player'),
(48, 'Rachael James', 'c8edac16fea23c18c275c55275eba200819b970a', '174023872750b0831cd71883.69632744AF', 'james.rachael@gmail.com', '07760669232', 'opponent', 'kIa*JSA%7IACpwKo*VYY', 'player'),
(49, 'Andrew Smith', 'bbf5d80b305e4f25f9994f1009dc4845dc6017cf', '87515557150b3e602325206.43256107AFA', 'andy.smith31@gmail.com', '07968039467', 'secret', 'q0BLG9OTzfpyFo@mARI7', 'player'),
(50, 'Joel Milnes', 'b3d0ce06d9bb9ea51b6c312c04094e5f724de665', '165953980250c0bbe9f34b70.36488273AF', 'joel.milnes1@gmail.com', '07966048018', 'opponent', 'yM$&$g)KRO#EhcsfFPzP', 'player'),
(51, 'Matt Hilton', '1eaf9953b7497dd5015c32f99516409150722d9c', '139648249650ea9f4581f5e1.04553938AF', 'm.hilton@m3c.co.uk', '07826948397', 'opponent', 'H8b$2Xm@FW3H9Iqo4y0q', 'player'),
(52, 'Nick Rice', '31f68eaafb9ca44e49516832b5c4eb862d4ed03c', '156272837050f09015ad9509.46231224AF', 'nikrice@aol.com', '07900838087', 'opponent', 'LJ*yESiUMm*Xp24v#rEI', 'player');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
