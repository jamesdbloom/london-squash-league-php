-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: internal-db.s143442.gridserver.com
-- Generation Time: Apr 02, 2013 at 02:07 PM
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

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
(16, 2, '3', 9),
(17, 1, '1', 10),
(18, 1, '2', 10),
(19, 1, '3', 10),
(20, 1, '4', 10),
(21, 2, '1', 11),
(22, 2, '2', 11);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=311 ;

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
(41, 27, 9, '8', '9', '0-3', '2013-01-20 04:28:17'),
(42, 27, 6, '8', '9', '0-3', '2013-02-04 09:53:35'),
(43, 27, 3, '8', '9', '3-1', '2013-01-28 13:25:27'),
(44, 27, 23, '8', '9', '1-3', '2013-01-26 04:27:25'),
(45, 5, 9, '8', '9', NULL, NULL),
(46, 5, 6, '8', '9', '3-4', '2013-02-13 02:44:55'),
(47, 5, 3, '8', '9', '3-0', '2013-02-12 08:08:50'),
(48, 5, 23, '8', '9', NULL, NULL),
(49, 9, 6, '8', '9', '0-3', '2013-02-13 02:42:54'),
(50, 9, 3, '8', '9', '3-1', '2013-01-31 13:24:32'),
(51, 9, 23, '8', '9', NULL, NULL),
(52, 6, 3, '8', '9', NULL, NULL),
(53, 6, 23, '8', '9', NULL, NULL),
(54, 3, 23, '8', '9', '0-3', '2013-02-18 01:35:37'),
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
(122, 45, 10, '9', '14', '1-3', '2013-02-01 01:25:33'),
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
(133, 18, 63, '9', '15', '1-3', '2013-02-06 02:29:45'),
(134, 1, 28, '9', '15', NULL, NULL),
(135, 1, 36, '9', '15', NULL, NULL),
(136, 1, 63, '9', '15', NULL, NULL),
(137, 28, 36, '9', '15', NULL, NULL),
(138, 28, 63, '9', '15', '1-3', '2013-02-11 03:31:49'),
(139, 36, 63, '9', '15', '3-2', '2013-01-23 08:19:39'),
(140, 44, 15, '9', '16', NULL, NULL),
(141, 44, 58, '9', '16', NULL, NULL),
(142, 44, 12, '9', '16', NULL, NULL),
(143, 44, 53, '9', '16', NULL, NULL),
(144, 15, 58, '9', '16', NULL, NULL),
(145, 15, 12, '9', '16', NULL, NULL),
(146, 15, 53, '9', '16', '0-3', '2013-01-17 09:43:05'),
(147, 58, 12, '9', '16', NULL, NULL),
(148, 58, 53, '9', '16', NULL, NULL),
(149, 12, 53, '9', '16', NULL, NULL),
(150, 6, 9, '10', '17', NULL, NULL),
(151, 6, 23, '10', '17', '2-3', '2013-03-12 02:25:50'),
(152, 6, 27, '10', '17', '3-0', '2013-03-22 10:56:51'),
(153, 6, 5, '10', '17', NULL, NULL),
(154, 6, 3, '10', '17', '3-1', '2013-03-22 10:57:25'),
(155, 6, 49, '10', '17', NULL, NULL),
(156, 6, 40, '10', '17', '3-0', '2013-04-02 10:39:12'),
(157, 9, 23, '10', '17', NULL, NULL),
(158, 9, 27, '10', '17', NULL, NULL),
(159, 9, 5, '10', '17', NULL, NULL),
(160, 9, 3, '10', '17', '1-3', '2013-03-27 16:22:44'),
(161, 9, 49, '10', '17', NULL, NULL),
(162, 9, 40, '10', '17', NULL, NULL),
(163, 23, 27, '10', '17', NULL, NULL),
(164, 23, 5, '10', '17', '2-3', '2013-03-27 16:28:25'),
(165, 23, 3, '10', '17', '3-0', '2013-03-07 08:55:31'),
(166, 23, 49, '10', '17', NULL, NULL),
(167, 23, 40, '10', '17', NULL, NULL),
(168, 27, 5, '10', '17', NULL, NULL),
(169, 27, 3, '10', '17', NULL, NULL),
(170, 27, 49, '10', '17', NULL, NULL),
(171, 27, 40, '10', '17', NULL, NULL),
(172, 5, 3, '10', '17', '3-0', '2013-03-19 04:27:11'),
(173, 5, 49, '10', '17', NULL, NULL),
(174, 5, 40, '10', '17', '3-0', '2013-03-26 12:38:28'),
(175, 3, 49, '10', '17', NULL, NULL),
(176, 3, 40, '10', '17', NULL, NULL),
(177, 49, 40, '10', '17', NULL, NULL),
(178, 21, 60, '10', '18', NULL, NULL),
(179, 21, 7, '10', '18', NULL, NULL),
(180, 21, 34, '10', '18', NULL, NULL),
(181, 21, 51, '10', '18', NULL, NULL),
(182, 21, 47, '10', '18', NULL, NULL),
(183, 21, 17, '10', '18', NULL, NULL),
(184, 21, 50, '10', '18', NULL, NULL),
(185, 60, 7, '10', '18', NULL, NULL),
(186, 60, 34, '10', '18', NULL, NULL),
(187, 60, 51, '10', '18', NULL, NULL),
(188, 60, 47, '10', '18', NULL, NULL),
(189, 60, 17, '10', '18', NULL, NULL),
(190, 60, 50, '10', '18', NULL, NULL),
(191, 7, 34, '10', '18', NULL, NULL),
(192, 7, 51, '10', '18', NULL, NULL),
(193, 7, 47, '10', '18', NULL, NULL),
(194, 7, 17, '10', '18', NULL, NULL),
(195, 7, 50, '10', '18', NULL, NULL),
(196, 34, 51, '10', '18', NULL, NULL),
(197, 34, 47, '10', '18', NULL, NULL),
(198, 34, 17, '10', '18', NULL, NULL),
(199, 34, 50, '10', '18', NULL, NULL),
(200, 51, 47, '10', '18', NULL, NULL),
(201, 51, 17, '10', '18', NULL, NULL),
(202, 51, 50, '10', '18', NULL, NULL),
(203, 47, 17, '10', '18', NULL, NULL),
(204, 47, 50, '10', '18', NULL, NULL),
(205, 17, 50, '10', '18', NULL, NULL),
(206, 46, 43, '10', '19', NULL, NULL),
(207, 46, 39, '10', '19', NULL, NULL),
(208, 46, 8, '10', '19', NULL, NULL),
(209, 46, 55, '10', '19', NULL, NULL),
(210, 46, 14, '10', '19', NULL, NULL),
(211, 46, 31, '10', '19', NULL, NULL),
(212, 46, 33, '10', '19', NULL, NULL),
(213, 43, 39, '10', '19', NULL, NULL),
(214, 43, 8, '10', '19', NULL, NULL),
(215, 43, 55, '10', '19', NULL, NULL),
(216, 43, 14, '10', '19', NULL, NULL),
(217, 43, 31, '10', '19', NULL, NULL),
(218, 43, 33, '10', '19', NULL, NULL),
(219, 39, 8, '10', '19', NULL, NULL),
(220, 39, 55, '10', '19', NULL, NULL),
(221, 39, 14, '10', '19', NULL, NULL),
(222, 39, 31, '10', '19', NULL, NULL),
(223, 39, 33, '10', '19', NULL, NULL),
(224, 8, 55, '10', '19', NULL, NULL),
(225, 8, 14, '10', '19', NULL, NULL),
(226, 8, 31, '10', '19', NULL, NULL),
(227, 8, 33, '10', '19', NULL, NULL),
(228, 55, 14, '10', '19', NULL, NULL),
(229, 55, 31, '10', '19', NULL, NULL),
(230, 55, 33, '10', '19', NULL, NULL),
(231, 14, 31, '10', '19', NULL, NULL),
(232, 14, 33, '10', '19', NULL, NULL),
(233, 31, 33, '10', '19', NULL, NULL),
(234, 62, 37, '10', '20', NULL, NULL),
(235, 62, 32, '10', '20', NULL, NULL),
(236, 62, 59, '10', '20', NULL, NULL),
(237, 62, 42, '10', '20', NULL, NULL),
(238, 62, 16, '10', '20', NULL, NULL),
(239, 62, 20, '10', '20', NULL, NULL),
(240, 37, 32, '10', '20', NULL, NULL),
(241, 37, 59, '10', '20', NULL, NULL),
(242, 37, 42, '10', '20', NULL, NULL),
(243, 37, 16, '10', '20', NULL, NULL),
(244, 37, 20, '10', '20', NULL, NULL),
(245, 32, 59, '10', '20', NULL, NULL),
(246, 32, 42, '10', '20', NULL, NULL),
(247, 32, 16, '10', '20', NULL, NULL),
(248, 32, 20, '10', '20', NULL, NULL),
(249, 59, 42, '10', '20', NULL, NULL),
(250, 59, 16, '10', '20', NULL, NULL),
(251, 59, 20, '10', '20', NULL, NULL),
(252, 42, 16, '10', '20', NULL, NULL),
(253, 42, 20, '10', '20', NULL, NULL),
(254, 16, 20, '10', '20', NULL, NULL),
(255, 63, 10, '11', '21', NULL, NULL),
(256, 63, 36, '11', '21', '1-3', '2013-02-22 12:12:04'),
(257, 63, 53, '11', '21', NULL, NULL),
(258, 63, 45, '11', '21', NULL, NULL),
(259, 63, 28, '11', '21', NULL, NULL),
(260, 63, 18, '11', '21', NULL, NULL),
(261, 63, 15, '11', '21', NULL, NULL),
(262, 10, 36, '11', '21', NULL, NULL),
(263, 10, 53, '11', '21', NULL, NULL),
(264, 10, 45, '11', '21', NULL, NULL),
(265, 10, 28, '11', '21', '3-1', '2013-03-18 03:06:22'),
(266, 10, 18, '11', '21', '3-0', '2013-03-24 11:59:02'),
(267, 10, 15, '11', '21', NULL, NULL),
(268, 36, 53, '11', '21', NULL, NULL),
(269, 36, 45, '11', '21', NULL, NULL),
(270, 36, 28, '11', '21', '3-0', '2013-03-11 00:20:44'),
(271, 36, 18, '11', '21', NULL, NULL),
(272, 36, 15, '11', '21', NULL, NULL),
(273, 53, 45, '11', '21', NULL, NULL),
(274, 53, 28, '11', '21', NULL, NULL),
(275, 53, 18, '11', '21', NULL, NULL),
(276, 53, 15, '11', '21', NULL, NULL),
(277, 45, 28, '11', '21', NULL, NULL),
(278, 45, 18, '11', '21', NULL, NULL),
(279, 45, 15, '11', '21', NULL, NULL),
(280, 28, 18, '11', '21', NULL, NULL),
(281, 28, 15, '11', '21', NULL, NULL),
(282, 18, 15, '11', '21', NULL, NULL),
(283, 48, 29, '11', '22', NULL, NULL),
(284, 48, 4, '11', '22', NULL, NULL),
(285, 48, 19, '11', '22', NULL, NULL),
(286, 48, 1, '11', '22', NULL, NULL),
(287, 48, 44, '11', '22', NULL, NULL),
(288, 48, 58, '11', '22', NULL, NULL),
(289, 48, 12, '11', '22', NULL, NULL),
(290, 29, 4, '11', '22', NULL, NULL),
(291, 29, 19, '11', '22', NULL, NULL),
(292, 29, 1, '11', '22', NULL, NULL),
(293, 29, 44, '11', '22', NULL, NULL),
(294, 29, 58, '11', '22', NULL, NULL),
(295, 29, 12, '11', '22', NULL, NULL),
(296, 4, 19, '11', '22', NULL, NULL),
(297, 4, 1, '11', '22', NULL, NULL),
(298, 4, 44, '11', '22', NULL, NULL),
(299, 4, 58, '11', '22', NULL, NULL),
(300, 4, 12, '11', '22', NULL, NULL),
(301, 19, 1, '11', '22', NULL, NULL),
(302, 19, 44, '11', '22', NULL, NULL),
(303, 19, 58, '11', '22', NULL, NULL),
(304, 19, 12, '11', '22', NULL, NULL),
(305, 1, 44, '11', '22', NULL, NULL),
(306, 1, 58, '11', '22', NULL, NULL),
(307, 1, 12, '11', '22', NULL, NULL),
(308, 44, 58, '11', '22', NULL, NULL),
(309, 44, 12, '11', '22', NULL, NULL),
(310, 58, 12, '11', '22', NULL, NULL);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=82 ;

--
-- Dumping data for table `PLAYER`
--

INSERT INTO `PLAYER` (`PLAYER_ID`, `USER_ID`, `DIVISION_ID`, `LEAGUE_ID`, `STATUS`, `SEED`) VALUES
(1, 1, '22', '2', 'inactive', '2'),
(2, 1, '3', '1', 'inactive', '2'),
(3, 2, '17', '1', 'active', '3'),
(4, 3, '22', '2', 'active', '1'),
(5, 4, '17', '1', 'active', '2'),
(6, 5, '17', '1', 'active', '2'),
(7, 6, '18', '1', 'active', '1'),
(8, 7, '19', '1', 'active', '3'),
(9, 8, '17', '1', 'active', '3'),
(10, 9, '21', '2', 'active', '1'),
(11, 10, '10', '1', 'inactive', '3'),
(12, 10, '22', '2', 'active', '3'),
(13, 11, '', '', 'active', NULL),
(14, 12, '19', '1', 'active', '3'),
(15, 13, '21', '2', 'active', '3'),
(16, 14, '20', '1', 'active', '4'),
(17, 15, '18', '1', 'active', '2'),
(18, 16, '21', '2', 'active', '2'),
(19, 15, '22', '2', 'active', '2'),
(20, 17, '20', '1', 'active', '4'),
(21, 18, '18', '1', 'active', '1'),
(22, 19, '14', '2', 'inactive', '2'),
(23, 19, '17', '1', 'active', '3'),
(24, 20, '', '', 'active', NULL),
(25, 21, '', '', 'active', NULL),
(26, 21, '1', '1', 'inactive', '1'),
(27, 22, '17', '1', 'active', '3'),
(28, 23, '21', '2', 'active', '2'),
(29, 24, '22', '2', 'active', '1'),
(30, 24, '3', '1', 'inactive', '2'),
(31, 25, '19', '1', 'active', '3'),
(32, 26, '20', '1', 'active', '3'),
(33, 27, '19', '1', 'active', '3'),
(34, 28, '18', '1', 'active', '1'),
(35, 29, '6', '2', 'inactive', '2'),
(36, 30, '21', '2', 'active', '2'),
(37, 31, '20', '1', 'active', '3'),
(38, 31, '8', '2', 'inactive', '3'),
(39, 32, '19', '1', 'active', '3'),
(40, 33, '17', '1', 'active', '1'),
(41, 34, '1', '1', 'inactive', '1'),
(42, 35, '20', '1', 'active', '4'),
(43, 36, '19', '1', 'active', '2'),
(44, 36, '22', '2', 'active', '2'),
(45, 37, '21', '2', 'active', '1'),
(46, 38, '19', '1', 'active', '2'),
(47, 39, '18', '1', 'active', '2'),
(48, 40, '22', '2', 'active', '1'),
(49, 41, '17', '1', 'active', '1'),
(50, 42, '18', '1', 'active', '2'),
(51, 43, '18', '1', 'active', '1'),
(52, 44, '', '', 'active', NULL),
(53, 45, '21', '2', 'active', '3'),
(54, 45, '1', '1', 'inactive', '1'),
(55, 46, '19', '1', 'active', '3'),
(56, 47, '', '', 'active', NULL),
(57, 48, '1', '1', 'inactive', '1'),
(58, 48, '22', '2', 'active', '3'),
(59, 49, '20', '1', 'active', '4'),
(60, 50, '18', '1', 'active', '1'),
(61, 43, '5', '2', 'inactive', '1'),
(62, 51, '20', '1', 'active', '3'),
(63, 52, '21', '2', 'active', '2'),
(64, 57, NULL, '', 'active', NULL),
(65, 57, NULL, '1', 'active', NULL),
(66, 58, NULL, '', 'active', NULL),
(67, 58, NULL, '1', 'active', NULL),
(68, 58, NULL, '2', 'inactive', NULL),
(69, 59, NULL, '', 'active', NULL),
(70, 59, NULL, '1', 'active', NULL),
(71, 60, NULL, '', 'active', NULL),
(72, 60, NULL, '1', 'active', NULL),
(73, 61, NULL, '', 'active', NULL),
(74, 61, NULL, '1', 'active', NULL),
(75, 62, NULL, '', 'active', NULL),
(76, 62, NULL, '1', 'active', NULL),
(77, 63, NULL, '', 'active', NULL),
(78, 63, NULL, '1', 'active', NULL),
(79, 64, NULL, '', 'active', NULL),
(80, 64, NULL, '1', 'active', NULL),
(81, 65, NULL, '', 'active', NULL);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `ROUND`
--

INSERT INTO `ROUND` (`ROUND_ID`, `START`, `END`, `LEAGUE_ID`) VALUES
(1, '2012-11-14 00:00:00', '2013-01-15 00:00:00', 1),
(2, '2012-11-14 00:00:00', '2013-01-15 00:00:00', 2),
(8, '2013-01-16 00:00:00', '2013-02-20 00:00:00', 1),
(9, '2013-01-16 00:00:00', '2013-02-20 00:00:00', 2),
(10, '2013-02-21 00:00:00', '2013-04-04 00:00:00', 1),
(11, '2013-02-21 00:00:00', '2013-04-04 00:00:00', 2);

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
  `SESSION_ID` varchar(250) NOT NULL,
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
('487749688515b17974f23c5.52297572AFA47d4be95838857809635a0fe3005828c8a469b593651724b9815219d81e8100ac6a4b95e595307daeb3cb7c68c2df9a6abed538c5338e84c', 5, 'active', '2013-04-02 10:38:31', '2013-04-02 10:39:13'),
('1328840431515b1f0f369da0.00060920AF75fe9b0cdcc50370124990ba3f876d9b5898de79ed51ef8ea0299672dd1b6222f5b6821ca4d2e3cd8903fd6699f8401d851b49ced30cf967', 4, 'active', '2013-04-02 11:10:23', '2013-04-02 11:10:54'),
('1512272172515ac463de1269.05049303AFa6dbecfbc3f388369b7b7ca407a857b8d54d7d6f03de15d341de48ba54f7c495f61da9f894aaa634950f451974ee7d6de3c9bbcae9023f23', 2, 'active', '2013-04-02 04:43:31', '2013-04-02 04:43:34'),
('1918384686515874812ed116.58959342AF9faf7454236c191cdf22a3a5e18848c0e240e15c8855059a67a6ab8676ee3004d942be0a3a9c2e6f3c3cd282e3a9ad2bf2ef6ce3932d96f5', 4, 'active', '2013-03-31 10:38:09', '2013-03-31 10:38:23'),
('10963919865159cfbf6b97e4.99691205AF35072797f2304c7673e3a33c9c3798204b7b49439a896be74670e1893f19a1b457c57b4884f83c29aa7eca97d53b303a2b04761aaea3c83f', 4, 'active', '2013-04-01 11:19:43', '2013-04-01 11:21:32'),
('1257262576515b3add060114.49696500AF37a802ef1c5c448577b228e62c76b0ccbf47084f8c6bdc9d6c6283a35f272b6c170c5ac3f4e854fadf0f28a2c00894911577ca732ab3cc02', 1, 'active', '2013-04-02 13:09:01', '2013-04-02 13:18:05');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

--
-- Dumping data for table `USER`
--

INSERT INTO `USER` (`USER_ID`, `NAME`, `PASSWORD`, `HASH_SALT`, `EMAIL`, `MOBILE`, `MOBILE_PRIVACY`, `USER_ACTIVATION_KEY`, `TYPE`) VALUES
(1, 'James Bloom', 'e4a543d0fe33eb8a41670e2fa02ff94c0e121272732db310813fb13bcec8278e31606a9a6d0158dfdf8ccfbeaa38ab2727d037452f1ee056', '434396415090388604a6e1.15009229AFAF', 'jamesdbloom@gmail.com', '07515900569', 'opponent', '', 'player'),
(2, 'Paul Taylor', 'c9f89abf5207961cbb7d722c5070d5291afcae654c7756b45b502afb65879cb8561f142b61be80b96f36964b46ee0e38f0b806189bc17957', '13800889335092fd431a6514.11424365AF', 'email@paultaylor.me', '07545193120', 'opponent', '', 'player'),
(3, 'Robert Hotchkiss', '11a7359b9da9164512546b0bf0fc35af06017ba2', '133746342150936e007e33b5.00836054AF', 'robert.hotchkiss@cw.com', '07920535611', 'opponent', 'VnD^GZbW72f6TD5oye*A', 'player'),
(4, 'John KEEN', 'bc42db4401815d30f42b0dae0fa99eb6701dbda3942dc42d40ce2055a47ee74f014a244162cd1f35152cebac3d6787277b0493ab34a9ee7f', '12287692405093853c357893.98130114AF', 'jk@nowmedical.co.uk', '07960585315', 'opponent', '', 'player'),
(5, 'David Beguier-Barnett', '0a041d9fb1d0d7ac9a52ce1a136f40960b007f64fa59c974c3ab77a531c46d05a7b362889d8b3811b15effffd0192eb2fc21eb4bb37d5405', '20821924445093ac414a0d44.99644596AF', 'david@beguier.com', '07770694009', 'opponent', '', 'player'),
(6, 'Marco Cioni', '423d1ef4af1f187dc84d23aa3112213bcb40ba3e', '15147130325093be18379213.11328462AF', 'marco.cioni@haymarket.com', '07920581913', 'opponent', '', 'player'),
(7, 'Catherine', '7cdd0b01a52c5abc05384f40d2f7de4f91daedec526f6fc647b5270fea9a014ddfb740052c8c4ce927091520d8dfcb7b64aea45a2e31d0d1', '3369144905093e5a01b85d4.10152055AFA', 'catherinemlittle@gmail.com', '07968349595', 'opponent', '', 'player'),
(8, 'Ray Swanton', '8df63264c8c4b408ed53493b1e9e9822d55fcdf6e96393a4408385211053f47fc52782176b1962579a4fb6e54437697c07fd7f4e8c69d451', '20335988585094216252af38.68461495AF', 'swantonray@gmail.com', '07983530293', 'opponent', '', 'player'),
(9, 'jules townshend', 'cf875abc7f4f8f3b48738ded0e4e5bd62885f437d0884413404895299b99229e52f54207b55b5f2ece37e59330653584a2956b1901edb410', '630280649509648a7227c30.38959100AFA', 'j.townshend@mmu.ac.uk', '037950996387', 'opponent', '', 'player'),
(10, 'Robin Bruce', 'b9e76f7217f9a86c7f579a23a9ac68473f4f8076', '6933252645096e5599b0456.90112112AFA', 'robin.bruce@gmail.com', '07811261892', 'opponent', '', 'player'),
(11, 'rebecca', '7d5609cc0e4f3e6c2d8b49320de22d23dcfd63fa', '123369053509a0c831b7542.11695494AFA', 'rebecca.long@gll.org', '00000000000', 'secret', 'mG8aFrO90sq&)#pOLH95', 'player'),
(12, 'Joanna Kennedy', '8c6a24920d5bcd2bd79444a0a951fa326dfeac96', '1595011920509a71d5e0bc57.24989126AF', 'jpakennedy@tiscali.co.uk', '07989711562', 'opponent', 'h4XOEM2&AHT@5#z0$yPB', 'player'),
(13, 'Matt Dold', 'dd28eecad4a9d2ca25ddd4c0e81c6c9d21a962ad31a1349019d4d53a03ab1a9991f44f373b5fba93ccf30999d347fb3625e84b39dc9d7c74', '2003569389509a7f68457437.14929108AF', 'matt@savioursnacks.com', '07597675810', 'opponent', '', 'player'),
(14, 'Jonathan Bouldin', '0fb82edefd5fca2e142d37e2f6bca8b76ef60243', '38354709509ab32676b2c7.70258006AFAF', 'jonathanbouldin@hotmail.com', '07970423563', 'opponent', 'nH2htJf%wBdYi5)K&LqC', 'player'),
(15, 'Bruna Petrillo', '42b9f47f83e06e9671bb1da289c99c2988fcdf06', '1473293582509ab4926d4180.06617393AF', 'bruninha.marchesi.p@gmail.com', '07810696608', 'opponent', 'Nl*ff0lEK7mwLl*MZuOU', 'player'),
(16, 'Greg Huszcza', '6e6720b9ab6a412f5d78712894f580ba98c31366', '1037376195509bcf9d35b170.23895572AF', 'greg.huszcza@hfbp.co.uk', '07908 810223', 'opponent', '', 'player'),
(17, 'trovers', 'b1060dfd2624933a0488b24c68a5ed26aecc327f', '1042382789509cc8d09ec2c2.67174274AF', 'trovers@gmail.com', '07790348951', 'opponent', 'dpLdtrJTXJs1IZr&4Z9w', 'player'),
(18, 'Daniel Marks', 'f75aac31bd1ee2b39cbac2747d1fc4142e64b26d', '380626648509d9766b75679.82000359AFA', 'dan@dsmrisksolutions.co.uk', '07871811550', 'opponent', 'kqPTMyDvYD2OqjXl(8#Z', 'player'),
(19, 'Andrea Caldera', '8b4c2357fb5df3ab7b2fb03eac076e145d76df59f6734a3bfd46bffda278e13d9d478252e2a1f19a5b3f9850d686e26431bc77c3f209e5cb', '156128162150a0d92b601bc2.60573851AF', 'andrea.caldera@gmail.com', '07850404421', 'opponent', '', 'player'),
(20, 'Shane Muckle', '568e0ffb4e4c547c0750c604396e6f8a87d96ca0', '190790886850a13b1dde7ba6.92729530AF', 'muxieb2@hotmail.com', '07503117740', 'opponent', 'EPH3g$qt(*V!dSB%Z49#', 'player'),
(21, 'Amy Rattray', 'fd99c6791c50397e05dcbdfb7542a844586d573c', '177431315150a13c676ba410.20703661AF', 'amyjunerattray@gmail.com', '07990685335', 'opponent', '', 'player'),
(22, 'James Trundle', '7cdfc8ad628eecf7326503682d67fe03513bf976d20f913da1a4109ade852b2df187c8fc68e88a8a087b7cdc41ecc1b3bf4209beddf69a0e', '214114767950a27e6e6332e4.33929817AF', 'jwtrundle@gmail.com', '07788108446', 'opponent', '', 'player'),
(23, 'Jardine Finn', '98dc71e0e1c6d613478927756f379d453af6a918', '18911083450a39e18757a53.62421208AFA', 'jardine.finn@lbhf.gov.uk', '07903864846', 'opponent', '', 'player'),
(24, 'Phil Harrison', 'cc830634b972872aa5b831bcb42ab57652eba08c', '169981571950a3a8e6acfa70.21533745AF', 'philipmharrison2@gmail.com', '07730822637', 'opponent', '', 'player'),
(25, 'Jon Blake', 'f78ff3f8ab72a90f418fd15e452b4ab89b7dcc3d', '122305434550a3c3902a2132.80645788AF', 'jonathan.blake@emimusic.com', '07916562559', 'opponent', 'M7QPp22ilRUa08%r6(7!', 'player'),
(26, 'Tim van Nispen', 'ec2617565a2b6e011cb87519e0a1c327ec12cfc0', '71978737050a3c3adcf2a97.57717894AFA', 'timvannispen@gmail.com', '07557949594', 'secret', '', 'player'),
(27, 'Kirsty Heeley', '72a79eece57be92d66d17649f97c166281c4b93d', '44985310750a3c3b2375e24.60558702AFA', 'k.heeley@savethechildren.org.uk', '07791397862', 'opponent', '^2b*uev7cBkOnN%u(U9@', 'player'),
(28, 'Peter Kim', 'e57be41bbda390107d4b24202a10d07e772c6995', '94862998250a3c5835e3b74.30995958AFA', 'pkim@arpllp.com', '', '', 'rs9@9UuGXd7EkyZy02X(', 'player'),
(29, 'Douglas Friedberg', 'b2ae40feca864b90f1b9112e44ce64b21fd7d546', '196433285950a3c64c77ba52.61521769AF', 'friedbergdvah@hotmail.com', '07810170063', 'secret', 'UtI&^D!Rmz6t8N3rbCq0', 'player'),
(30, 'Neil Malde', '81001d1dc64729d8207b21e1656894233b76af6d2261e58c6109eff7b16d0758d125798b0d20c0dd4e67cbfbb35ffa3d4f54695764cceccb', '1423409950a3c723796232.12500680AFAF', 'nmalde@bechtel.com', '07733260764', 'opponent', '', 'player'),
(31, 'Mohamed Hamza', '702ffe7e63a419892cf946432d4121b68e3b14ab', '99848782850a3c9a29343c9.20482925AFA', 'mh3488@gmail.com', '07825169104', 'opponent', 'n#&EA0A2RD&OODlWkE#5', 'player'),
(32, 'Ben Cochrane', 'e14b4e406365d3f70ea94a250b26ad61fde0fbd0e7f168584bbe82adb832b157f0c790445d77c072b0fe9ec0fab2f9c1101a93017006659b', '7265270450a3ca80be7c54.24543964AFAF', 'benjamin.j.cochrane@gmail.com', '07590505519', 'opponent', '', 'player'),
(33, 'Benoit Obadia', '74e1a2b868fad46a9fd7c19b6724da926a315ae6', '119900872250a3d65944f232.39515962AF', 'benoit.obadia@gmail.com', '07943834373', 'opponent', '', 'player'),
(34, 'Peadar Stack', '91723b862748855faba64f362ffb3d7d2a13a1cc', '62405756150a3f33f7f3441.19135960AFA', 'pstack04@hotmail.com', '07413526994', 'secret', 'GSz@IRqPMhOK456XxD0A', 'player'),
(35, 'Craig Kenworthy', '9e1afd287607ca238749e5ab656810d1c34ee3d9', '179083039950a3fbcb32ee71.31841096AF', 'craigkenworthy@hotmail.com', '07527766966', 'opponent', '8uR1s9vAAVxSC8B2rbSD', 'player'),
(36, 'Tom P', '946d819e2a4050f6733e5012ba962b027ea11e61', '99891468550a4158c284705.81228174AFA', 'tpearce@sebastianconran.com', '07775994289', 'opponent', '@W9fX6H9oin(4crf3PQd', 'player'),
(37, 'Joe Klimis', '9b9ba4bd505ccb7e4a508e9d83624e31e6cbc23ed34037925a7f25f68af749dfdfff4e893de911af6834140aaf5b8e6f883cdf9fabaad995', '143604053150a49d0ba07566.55509223AF', 'joe@karenandjoe.co.uk', '07882432014', 'opponent', '', 'player'),
(38, 'taryn armitage', '7cf4271bd4a1cba15dd87e39fd493300a0627b08', '105158020350a4c21bbd1a52.75065471AF', 'tarynarmitage@gmail.com', '07523843257', 'secret', 'LD3neGbiNmvZEGmkJ#iy', 'player'),
(39, 'Brendan', '2ed859a7d595d5b6fa07279738105a8b9a875447', '199108446150a4c5a3cd7a97.88984815AF', 'brwoodnz@gmail.com', '07765111349', 'secret', 'uo&J7$%*b@JMpG6JdRvx', 'player'),
(40, 'Alistair Cossins', '19455feb0cf14e2b14f1322a17d3ebb5150a9e0b', '100501142750a4cdd546f248.93125444AF', 'alistair.cossins@disney.com', '', 'secret', '7@VAqcWTZL6Ya865n78(', 'player'),
(41, 'Ajith', '4cfe74542d6ef1af641f63ccbd5db7bbad70f0bd', '17247373050a4cead2f25b8.51827132AFA', 'writetoajith@gmail.com', '07846421279', 'opponent', '', 'player'),
(42, 'Patrick ONeill', '36ae64ad680366ced33962350582a0a62fca61d5', '156925413850aa314177e879.09154603AF', 'pjmon@hotmail.co.uk', '07879465663', 'opponent', '*$Q9*vtMGBJD)sPlCkvG', 'player'),
(43, 'Richard Pile', '2f2810927fd1738238d0177218245b6c0191eaab', '155542563950abb3ed8927e0.17737105AF', 'rlpile@gmail.com', '07947643747', 'opponent', 'zLSfbq(y)iz2V3F7eliE', 'player'),
(44, 'Administrator', '162504803c1074bb5e99431f89ccd06a508f048c', '140992476750ac0cf22cb121.66449547AF', 'james.bloom@betfair.com', '07515900569', 'opponent', 'hgm%IBEYr3uEK#w33U0p', 'player'),
(45, 'Scott Hands', '747d37477d7c24ca6791dc35494fa4709434dd21', '38372983750aca040be9564.90319492AFA', 'scott.hands@cw.com', '07822859394', 'opponent', 'swE^Npr*^9j0Gk0Xr3wA', 'player'),
(46, 'Dan Morley', '6dd40a3fc5812a3df21b75b6f5a547846d38673e02643f048ecbfe48e5ce608a2acf2b5352d08c2ea9915bb2a20de587e8debcdc30a88235', '206701257050acc11245aee9.96338641AF', 'morley_daniel@yahoo.co.uk', '07793037582', 'opponent', '', 'player'),
(47, 'Tracey Evans', '3acae5b0a2c4c54d3c3dbd89dfb627f8493d2b0b05f0d52bf6f0ed1d26d8965b4e37f836df9380ae5a3a85eae2f29ad746933de093d05211', '6390585750ad2d889d2eb1.44955171AFAF', 'tracey.evans@gll.org', '', 'secret', '', 'player'),
(48, 'Rachael James', 'c8edac16fea23c18c275c55275eba200819b970a', '174023872750b0831cd71883.69632744AF', 'james.rachael@gmail.com', '07760669232', 'opponent', 'kIa*JSA%7IACpwKo*VYY', 'player'),
(49, 'Andrew Smith', 'bbf5d80b305e4f25f9994f1009dc4845dc6017cf', '87515557150b3e602325206.43256107AFA', 'andy.smith31@gmail.com', '07968039467', 'secret', '', 'player'),
(50, 'Joel Milnes', 'b3d0ce06d9bb9ea51b6c312c04094e5f724de665', '165953980250c0bbe9f34b70.36488273AF', 'joel.milnes1@gmail.com', '07966048018', 'opponent', 'yM$&$g)KRO#EhcsfFPzP', 'player'),
(51, 'Matt Hilton', '1eaf9953b7497dd5015c32f99516409150722d9c', '139648249650ea9f4581f5e1.04553938AF', 'm.hilton@m3c.co.uk', '07826948397', 'opponent', 'H8b$2Xm@FW3H9Iqo4y0q', 'player'),
(52, 'Nick Rice', '9e9acf2b76dea890f4de3418e2ce40b7d6d4e7244d5daf7d1f84a28ecc88c2cc56866eb1e10d12a90649e9a13719e6a7703587eaebb97911', '156272837050f09015ad9509.46231224AF', 'nikrice@aol.com', '07900838087', 'opponent', '', 'player'),
(53, 'Chris Price', '67da1b91b47fd1f66aafcb92f941eb2f162a17f8', '150530508250f6ae19d95d31.92594961AF', 'cprice@caci.co.uk', '07702171045', 'opponent', 'Lk08qSapw&5GasqPkY7h', 'player'),
(54, 'Chris Price', 'f503ede3636a2d89e719d55e535a27c321a13c04', '207652471950f6ae36607746.58730601AF', 'chris800price@hotmail.com', '07702171045', 'opponent', 'aqztqo#VfH9pv9xLulrT', 'player'),
(55, 'Craig Tucker', 'd5be1356de5b0c28d70cde20116832fbd28a8770', '55452235050f9643ae064a4.24492784AFA', 'ctlm72@hotmail.com', '07891999021', 'opponent', 'b9Kkh@)sDxItjBpL!RQW', 'player'),
(56, 'Mary Gi', '454a5f9bb66c986633abff589af6bafb7ac7c8ef', '103722147450fd6479c1f736.56023245AF', 'mari.g2007@yahoo.com', '07976093099', 'opponent', 'o4z5VIyMUuOb)HOklIqy', 'player'),
(57, 'Larry Shoemaker', '6a693db38a3ef6a50058454a3b12d6349bd7fc52ae7cf2c426570f9a39a92ab9332f6519224d6a3e31c98bfa72533a5ec48109761599358b', '201789545251053eeca7ba35.33515118AF', 'lkshoe@yahoo.com', '07850859265', 'opponent', '', 'player'),
(58, 'Rishi Shah', '5e328aab8be5b731ef90aff136bc8a47de0adea337a91fbead96bef234e4aa70d328ec188f76a7abee7352d8821c17fc5d297d809d23c87e', '1444399017510ea9616d3d69.12974701AF', 'rishi_s@hotmail.com', '07415553601', 'secret', '', 'player'),
(59, 'Samy Iralour', '385cbb1551bb113ab85c913450dcf5725bc99e793961a8cfb361c7ae1aa1846440f84a0bdf485edc3d08c997c08cb5e74881f51cffa3672d', '153463084151152a3a3519d9.19612368AF', 'samy.iralour@gmail.com', '07587141276', 'opponent', '', 'player'),
(60, 'Anthony', 'c557ed7e94ef027ca66227336f08cc03383d5f6379e7cc10d3de3270076834b2b392054dc0710130caa2756d34b45af2451e4aaf179a75f4', '733263268512ab6e21150f4.05663604AFA', 'att_coulton@hotmail.com', '07890646437', 'opponent', '', 'player'),
(61, 'Johnny craike', 'd75b49eb7e27d7409111908e98a9c6d7e4c4f2da2fe971cbcc16dfac6e74bbd3c6b9526a2752a82b84c51a53598c015f9ab8a34188965c29', '701437428512cbed4a7cad7.35150183AFA', 'earthcraike@gmail.com', '07730606565', 'opponent', '', 'player'),
(62, 'colin ingram', '7adab058d506b83e7fdd731cf0ffac98ec001b16c246d2111991ade2b35f2fb77ad60ac89c3cd0187de362467aa3c40199b652888ba699f9', '121235195513f5f3d900cd6.11828817AFA', 'cin6304173@aol.com', '07787375914', 'opponent', '', 'player'),
(63, 'paul', '8029ccdd835520e717e96d263e884e8fbcf44ed367788c8eaed1519a6e758d8c302c4648ca19b16f1b86641a969f7ab011b32180d80a9b8b', '195467950451476fe72b7af5.77693843AF', 'pauladdington@hotmail.com', '07884388030', 'opponent', '', 'player'),
(64, 'Tom', '1b4658037485ecdc4b208d66b224fb7d3cecbd2d33d60a9388d97c1e0cc7060b6d3d823dde888826e128bafceafb60769e143626570e53a4', '138661126151478d2dc53968.50768584AF', 'tom_in_boots@yahoo.co.uk', '07919152901', 'opponent', 'HxXvGdxUZGUgANrXdAJn', 'player'),
(65, 'becki long', 'b5ac385c3aee02b6af978063d5744da0fffa30f0006a0d98ccbc2cc2e4160aaacef6b39f38918f5f626ec5d19c670c4ff29124e1944d6f95', '3752245075149b20cf40be7.31969586AFA', 'beckilong@hotmail.co.uk', '07917445447', 'secret', '(uqN7JwPcBlxcQ8Q1$85', 'player');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
