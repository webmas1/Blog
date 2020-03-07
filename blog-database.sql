-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2020 at 09:17 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `content` text CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `uid`, `title`, `content`, `created`, `updated`) VALUES
(3, 2, 'My first title', 'My first content My first content My first content My first content My first content My first content My first content My first content My first content', '2018-11-25 03:41:19', '2018-11-25 03:41:19'),
(4, 2, 'My first title', 'My first content My first content My first content My first content My first content My first content My first content My first content My first content My first content My first content My first content', '2018-11-25 03:41:23', '2018-11-25 03:41:23'),
(5, 2, 'My first title', 'My first content My first content My first content My first content My first content My first content My first content My first content My first contentMy first content My first content My first content My first content My first content My first content My first content My first content My first content', '2018-11-25 03:42:46', '2018-11-25 03:42:46'),
(6, 2, 'My first title', 'My first content My first content My first content My first content My first content My first content My first content My', '2018-11-25 03:45:37', '2018-11-25 03:45:37'),
(7, 2, 'My first title', 'My first content My first content My first content My first content My first content My first content My first content My first content My first content', '2018-11-25 03:46:33', '2018-11-25 03:46:33'),
(12, 2, 'Etiam porttitor ipsum ligula', 'Nulla imperdiet, mauris et sollicitudin pretium, dui mi imperdiet odio, in sollicitudin tellus magna id nulla. Sed fermentum erat quam, sed pretium erat fringilla vitae. Integer dapibus nulla tellus, a auctor justo bibendum at. Sed rutrum eget enim eget tincidunt. Quisque maximus scelerisque mauris, non eleifend odio convallis eget. Aenean sit amet efficitur nulla. Cras posuere egestas risus quis mollis. Donec non vehicula neque. Etiam porttitor ipsum ligula, in tincidunt velit pharetra id. Nullam vel quam id metus pulvinar condimentum posuere et eros. Sed bibendum rutrum nisl eu dictum. Curabitur non erat porta, dignissim metus vitae, molestie ipsum. Suspendisse ullamcorper magna nec enim blandit, vel ultrices nisl porta. Ut sapien lectus, ullamcorper eget tortor ut, sodales dictum risus. Sed laoreet, ex sit amet venenatis volutpat, ex nisl ullamcorper ipsum, eget scelerisque augue ipsum ut mi.', '2020-03-07 19:58:46', '2020-03-07 19:58:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `last_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `admin` tinyint(4) NOT NULL,
  `approved` tinyint(4) NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT 'img\\avatars\\default_avatar.jpg'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `admin`, `approved`, `avatar`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '$2y$10$r7QKjGP1dXZ.E3DEPbZU.uwzVmpovGA8A15.InNKW8JIGMFXJ5H8a', 1, 1, 'img/avatars/default_avatar.jpg'),
(2, 'Asi', 'Kapner', 'webmas1@gmail.com', '$2y$10$r7QKjGP1dXZ.E3DEPbZU.uwzVmpovGA8A15.InNKW8JIGMFXJ5H8a', 0, 1, 'img/avatars/default_avatar.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
