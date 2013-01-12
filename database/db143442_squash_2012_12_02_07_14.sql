-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: internal-db.s143442.gridserver.com
-- Generation Time: Dec 01, 2012 at 11:13 PM
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
  PRIMARY KEY (`DIVISION_ID`),
  UNIQUE KEY `unique_LEAGUE_ID_NAME` (`LEAGUE_ID`,`NAME`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `DIVISION`
--

INSERT INTO `DIVISION` (`DIVISION_ID`, `LEAGUE_ID`, `NAME`) VALUES
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
  PRIMARY KEY (`MATCH_ID`),
  UNIQUE KEY `unique_PLAYER_ONE_ID_PLAYER_TWO_ID_ROUND_ID` (`PLAYER_ONE_ID`,`PLAYER_TWO_ID`,`ROUND_ID`),
  KEY `foreign_key_ROUND_ID` (`ROUND_ID`),
  KEY `foreign_key_PLAYER_ONE_ID_DIVISION_ID` (`PLAYER_ONE_ID`,`DIVISION_ID`),
  KEY `foreign_key_PLAYER_TWO_ID_DIVISION_ID` (`PLAYER_TWO_ID`,`DIVISION_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `MATCHES`
--

INSERT INTO `MATCHES` (`MATCH_ID`, `PLAYER_ONE_ID`, `PLAYER_TWO_ID`, `ROUND_ID`, `DIVISION_ID`, `SCORE`) VALUES
(1, 2, 5, '2', '3', NULL),
(2, 6, 2, '2', '3', NULL),
(3, 6, 5, '2', '3', NULL),
(4, 8, 3, '3', '4', NULL),
(5, 8, 9, '3', '4', NULL),
(6, 3, 9, '3', '4', '1-3'),
(7, 10, 4, '5', '5', NULL),
(8, 8, 11, '3', '4', NULL),
(9, 3, 11, '3', '4', NULL),
(10, 9, 11, '3', '4', '3-0'),
(11, 8, 14, '3', '4', NULL),
(12, 14, 3, '3', '4', NULL),
(13, 14, 9, '3', '4', NULL),
(14, 14, 11, '3', '4', NULL),
(15, 15, 12, '7', '8', NULL),
(16, 17, 6, '2', '3', NULL),
(17, 17, 2, '2', '3', NULL),
(18, 17, 5, '2', '3', '0-3'),
(19, 18, 1, '6', '6', NULL),
(20, 19, 18, '6', '6', NULL),
(21, 19, 1, '6', '6', NULL),
(22, 16, 20, '4', '7', '5-0'),
(23, 21, 7, '1', '1', NULL),
(24, 22, 19, '6', '6', NULL),
(25, 22, 18, '6', '6', NULL),
(26, 22, 1, '6', '6', NULL),
(27, 23, 8, '3', '4', NULL),
(28, 23, 14, '3', '4', NULL),
(29, 23, 3, '3', '4', NULL),
(30, 23, 9, '3', '4', NULL),
(31, 23, 11, '3', '4', NULL),
(32, 26, 21, '1', '1', NULL),
(33, 26, 7, '1', '1', NULL),
(34, 23, 27, '3', '4', NULL),
(35, 8, 27, '3', '4', NULL),
(36, 27, 14, '3', '4', NULL),
(37, 27, 3, '3', '4', NULL),
(38, 27, 9, '3', '4', NULL),
(39, 27, 11, '3', '4', '3-0');

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
  PRIMARY KEY (`PLAYER_ID`),
  UNIQUE KEY `unique_USER_ID_DIVISION_ID` (`USER_ID`,`DIVISION_ID`),
  UNIQUE KEY `unique_USER_ID_LEAGUE_ID` (`USER_ID`,`LEAGUE_ID`),
  KEY `foreign_key_DIVISION_ID` (`DIVISION_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

--
-- Dumping data for table `PLAYER`
--

INSERT INTO `PLAYER` (`PLAYER_ID`, `USER_ID`, `DIVISION_ID`, `LEAGUE_ID`, `STATUS`) VALUES
(1, 1, '6', '2', 'active'),
(2, 1, '3', '1', 'active'),
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
(51, 43, '1', '1', 'active'),
(52, 44, '', '', 'active'),
(53, 45, '8', '2', 'active'),
(54, 45, '1', '1', 'active'),
(55, 46, '4', '1', 'active'),
(56, 47, '', '', 'active'),
(57, 48, '1', '1', 'inactive'),
(58, 48, '8', '2', 'active'),
(59, 49, '7', '1', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `ROUND`
--

DROP TABLE IF EXISTS `ROUND`;
CREATE TABLE IF NOT EXISTS `ROUND` (
  `ROUND_ID` int(11) NOT NULL AUTO_INCREMENT,
  `DIVISION_ID` int(11) NOT NULL,
  `START` datetime NOT NULL,
  `END` datetime NOT NULL,
  PRIMARY KEY (`ROUND_ID`),
  UNIQUE KEY `unique_DIVISION_ID_START` (`DIVISION_ID`,`START`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ROUND`
--

INSERT INTO `ROUND` (`ROUND_ID`, `DIVISION_ID`, `START`, `END`) VALUES
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
('82815923150b5efd1cd22f3.24485018AFA5e0476b027b63dca566a02300a952ebaa16789dd', 19, 'inactive', '2012-11-28 03:04:49', '2012-11-28 04:06:55'),
('64203753350b61af8d74984.83486395AFAa3ba08f48ffe9c9a27ed3adcaa113e9bcb0589d3', 4, 'inactive', '2012-11-28 06:08:56', '2012-11-28 06:08:58'),
('72778518850b62258846c96.61455612AFA70bb86caec69303f11773a429056dd94ad805e31', 22, 'inactive', '2012-11-28 06:40:24', '2012-11-28 06:44:04'),
('201158264950b683e551c8f5.11512665AF52306f72813b5891af44984254deed17c2463e05', 2, 'inactive', '2012-11-28 13:36:37', '2012-11-28 13:47:44'),
('121901449250b68a2f93d2a0.03445020AF70871aaa73c384c38d639ade631a21799077b87d', 8, 'inactive', '2012-11-28 14:03:27', '2012-11-28 14:13:49'),
('39715274450b73d945a35a8.86922429AFAd463d2e6d6c57bc452a00f09f5fecc8f3fd6da9b', 8, 'inactive', '2012-11-29 02:48:52', '2012-11-29 02:48:52'),
('199978126250b74c63daede6.32704940AF34967bd3f53f8a4396aaa4df93e30523f06b1d5d', 19, 'inactive', '2012-11-29 03:52:03', '2012-11-29 03:52:12'),
('85662105750b78d578b86f5.91401913AFA05030541708d71d0c0ef2053a938d16c7e5b0e8b', 4, 'inactive', '2012-11-29 08:29:11', '2012-11-29 08:30:26'),
('83486712050b7ec09d61d52.41787139AFAddc28cea2b4968601c0248d20d10e75bc9e6e434', 8, 'inactive', '2012-11-29 15:13:13', '2012-11-29 15:13:21'),
('62726351450b9b7aecbbb41.63937967AFA9bdc343f1e4e79a48c9b3830783e19eecd352c1d', 1, 'active', '2012-11-30 23:54:22', '2012-11-30 23:57:53');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

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
(49, 'Andrew Smith', 'bbf5d80b305e4f25f9994f1009dc4845dc6017cf', '87515557150b3e602325206.43256107AFA', 'andy.smith31@gmail.com', '07968039467', 'secret', 'q0BLG9OTzfpyFo@mARI7', 'player');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
