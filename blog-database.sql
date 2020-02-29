-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql312.epizy.com
-- Generation Time: Nov 25, 2018 at 10:37 AM
-- Server version: 5.6.41-84.1
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `epiz_23017640_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `content` text CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `uid`, `title`, `content`, `created`, `updated`) VALUES
(3, 2, 'My first title', 'My first content My first content My first content My first content My first content My first content My first content My first content My first content', '2018-11-25 03:41:19', '2018-11-25 03:41:19'),
(4, 2, 'My first title', 'My first content My first content My first content My first content My first content My first content My first content My first content My first content My first content My first content My first content', '2018-11-25 03:41:23', '2018-11-25 03:41:23'),
(5, 2, 'My first title', 'My first content My first content My first content My first content My first content My first content My first content My first content My first contentMy first content My first content My first content My first content My first content My first content My first content My first content My first content', '2018-11-25 03:42:46', '2018-11-25 03:42:46'),
(6, 2, 'My first title', 'My first content My first content My first content My first content My first content My first content My first content My', '2018-11-25 03:45:37', '2018-11-25 03:45:37'),
(7, 2, 'My first title', 'My first content My first content My first content My first content My first content My first content My first content My first content My first content', '2018-11-25 03:46:33', '2018-11-25 03:46:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `last_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `admin` tinyint(4) NOT NULL,
  `approved` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `admin`, `approved`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '$2y$10$6Br06SbGlJ5JchB9U/ayFecyIMLSrR6u7.Wua60oeno/KTIHMEQ1y', 1, 1),
(2, 'Asi', 'Kapner', 'webmas1@gmail.com', '$2y$10$6Br06SbGlJ5JchB9U/ayFecyIMLSrR6u7.Wua60oeno/KTIHMEQ1y', 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
