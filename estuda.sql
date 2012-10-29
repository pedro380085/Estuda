-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 14, 2012 at 01:33 AM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `estuda`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternative`
--

CREATE TABLE `alternative` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `questionID` int(11) NOT NULL COMMENT 'oneToOne',
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

--
-- Dumping data for table `alternative`
--

INSERT INTO `alternative` VALUES(57, 2, 'Altere o texto da sua alternativa.');
INSERT INTO `alternative` VALUES(58, 2, 'Altere o texto da sua alternativa.');
INSERT INTO `alternative` VALUES(59, 2, 'gfgf');
INSERT INTO `alternative` VALUES(60, 3, 'Altere o texto da sua alternativa.');
INSERT INTO `alternative` VALUES(65, 4, 'Altere o texto da sua alternativa.');
INSERT INTO `alternative` VALUES(66, 4, 'gfgf');
INSERT INTO `alternative` VALUES(67, 4, 'Altere o texto da sua alternativa.');
INSERT INTO `alternative` VALUES(68, 4, 'Altere o texto da sua alternativa.');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `theme` varchar(50) NOT NULL,
  `author` varchar(100) NOT NULL,
  `statement` text NOT NULL,
  `correctAlternative` smallint(11) NOT NULL COMMENT 'questionID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `question`
--

INSERT INTO `question` VALUES(2, 'Gustavo', 'Tecnologia', 'Gustavo', 'Mat&eacute;rias relacionada a dados do sistema', 1);
INSERT INTO `question` VALUES(3, 'Pedro', 'Ci&ecirc;ncia', 'Pedro', 'Informa&ccedil;&otilde;es sobre o sistema de comunica&ccedil;&atilde;o de dados', 0);
INSERT INTO `question` VALUES(4, 'T&iacute;tulo bonito', 'Algas', 'Op&ccedil;&otilde;es', 'Novo sistema de Televis&atilde;o!', -1);
