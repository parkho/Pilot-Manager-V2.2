<<<<<<< HEAD
=======
-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Dec 20, 2015 at 09:21 PM
-- Server version: 5.5.45-cll-lve
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Table structure for table `pilot_manager`
--
>>>>>>> origin/master

CREATE TABLE IF NOT EXISTS `pilot_manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(12) NOT NULL,
  `pfname` varchar(50) NOT NULL DEFAULT '',
  `plname` varchar(50) NOT NULL,
  `blank` int(12) NOT NULL DEFAULT '0',
  `warning` int(12) NOT NULL,
  `welcome` int(12) NOT NULL,
  `message` text NOT NULL,
  `datesent` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pid` (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

