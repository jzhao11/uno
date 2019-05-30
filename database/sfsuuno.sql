-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 21, 2019 at 08:42 AM
-- Server version: 5.7.21
-- PHP Version: 7.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sfsuuno`
--

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

DROP TABLE IF EXISTS `card`;
CREATE TABLE IF NOT EXISTS `card` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `card`
--

INSERT INTO `card` (`id`, `number`, `color`, `img`) VALUES
(0, 0, 'blue', 'blue_0.png'),
(1, 1, 'blue', 'blue_1.png'),
(2, 1, 'blue', 'blue_1.png'),
(3, 2, 'blue', 'blue_2.png'),
(4, 2, 'blue', 'blue_2.png'),
(5, 3, 'blue', 'blue_3.png'),
(6, 3, 'blue', 'blue_3.png'),
(7, 4, 'blue', 'blue_4.png'),
(8, 4, 'blue', 'blue_4.png'),
(9, 5, 'blue', 'blue_5.png'),
(10, 5, 'blue', 'blue_5.png'),
(11, 6, 'blue', 'blue_6.png'),
(12, 6, 'blue', 'blue_6.png'),
(13, 7, 'blue', 'blue_7.png'),
(14, 7, 'blue', 'blue_7.png'),
(15, 8, 'blue', 'blue_8.png'),
(16, 8, 'blue', 'blue_8.png'),
(17, 9, 'blue', 'blue_9.png'),
(18, 9, 'blue', 'blue_9.png'),
(19, 10, 'blue', 'blue_10.png'),
(20, 10, 'blue', 'blue_10.png'),
(21, 11, 'blue', 'blue_11.png'),
(22, 11, 'blue', 'blue_11.png'),
(23, 12, 'blue', 'blue_12.png'),
(24, 12, 'blue', 'blue_12.png'),
(25, 0, 'green', 'green_0.png'),
(26, 1, 'green', 'green_1.png'),
(27, 1, 'green', 'green_1.png'),
(28, 2, 'green', 'green_2.png'),
(29, 2, 'green', 'green_2.png'),
(30, 3, 'green', 'green_3.png'),
(31, 3, 'green', 'green_3.png'),
(32, 4, 'green', 'green_4.png'),
(33, 4, 'green', 'green_4.png'),
(34, 5, 'green', 'green_5.png'),
(35, 5, 'green', 'green_5.png'),
(36, 6, 'green', 'green_6.png'),
(37, 6, 'green', 'green_6.png'),
(38, 7, 'green', 'green_7.png'),
(39, 7, 'green', 'green_7.png'),
(40, 8, 'green', 'green_8.png'),
(41, 8, 'green', 'green_8.png'),
(42, 9, 'green', 'green_9.png'),
(43, 9, 'green', 'green_9.png'),
(44, 10, 'green', 'green_10.png'),
(45, 10, 'green', 'green_10.png'),
(46, 11, 'green', 'green_11.png'),
(47, 11, 'green', 'green_11.png'),
(48, 12, 'green', 'green_12.png'),
(49, 12, 'green', 'green_12.png'),
(50, 0, 'red', 'red_0.png'),
(51, 1, 'red', 'red_1.png'),
(52, 1, 'red', 'red_1.png'),
(53, 2, 'red', 'red_2.png'),
(54, 2, 'red', 'red_2.png'),
(55, 3, 'red', 'red_3.png'),
(56, 3, 'red', 'red_3.png'),
(57, 4, 'red', 'red_4.png'),
(58, 4, 'red', 'red_4.png'),
(59, 5, 'red', 'red_5.png'),
(60, 5, 'red', 'red_5.png'),
(61, 6, 'red', 'red_6.png'),
(62, 6, 'red', 'red_6.png'),
(63, 7, 'red', 'red_7.png'),
(64, 7, 'red', 'red_7.png'),
(65, 8, 'red', 'red_8.png'),
(66, 8, 'red', 'red_8.png'),
(67, 9, 'red', 'red_9.png'),
(68, 9, 'red', 'red_9.png'),
(69, 10, 'red', 'red_10.png'),
(70, 10, 'red', 'red_10.png'),
(71, 11, 'red', 'red_11.png'),
(72, 11, 'red', 'red_11.png'),
(73, 12, 'red', 'red_12.png'),
(74, 12, 'red', 'red_12.png'),
(75, 0, 'yellow', 'yellow_0.png'),
(76, 1, 'yellow', 'yellow_1.png'),
(77, 1, 'yellow', 'yellow_1.png'),
(78, 2, 'yellow', 'yellow_2.png'),
(79, 2, 'yellow', 'yellow_2.png'),
(80, 3, 'yellow', 'yellow_3.png'),
(81, 3, 'yellow', 'yellow_3.png'),
(82, 4, 'yellow', 'yellow_4.png'),
(83, 4, 'yellow', 'yellow_4.png'),
(84, 5, 'yellow', 'yellow_5.png'),
(85, 5, 'yellow', 'yellow_5.png'),
(86, 6, 'yellow', 'yellow_6.png'),
(87, 6, 'yellow', 'yellow_6.png'),
(88, 7, 'yellow', 'yellow_7.png'),
(89, 7, 'yellow', 'yellow_7.png'),
(90, 8, 'yellow', 'yellow_8.png'),
(91, 8, 'yellow', 'yellow_8.png'),
(92, 9, 'yellow', 'yellow_9.png'),
(93, 9, 'yellow', 'yellow_9.png'),
(94, 10, 'yellow', 'yellow_10.png'),
(95, 10, 'yellow', 'yellow_10.png'),
(96, 11, 'yellow', 'yellow_11.png'),
(97, 11, 'yellow', 'yellow_11.png'),
(98, 12, 'yellow', 'yellow_12.png'),
(99, 12, 'yellow', 'yellow_12.png'),
(100, 13, 'wild', 'wild_13.png'),
(101, 13, 'wild', 'wild_13.png'),
(102, 13, 'wild', 'wild_13.png'),
(103, 13, 'wild', 'wild_13.png'),
(104, 14, 'wild', 'wild_14.png'),
(105, 14, 'wild', 'wild_14.png'),
(106, 14, 'wild', 'wild_14.png'),
(107, 14, 'wild', 'wild_14.png');

-- --------------------------------------------------------

--
-- Table structure for table `channel`
--

DROP TABLE IF EXISTS `channel`;
CREATE TABLE IF NOT EXISTS `channel` (
  `game_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_host` tinyint(1) NOT NULL DEFAULT '0',
  `turn` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`game_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `channel`
--

INSERT INTO `channel` (`game_id`, `user_id`, `is_host`, `turn`) VALUES
(1, 1, 1, 0),
(2, 2, 1, 0),
(3, 4, 1, 1),
(4, 1, 1, NULL),
(11, 1, 1, NULL),
(12, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

DROP TABLE IF EXISTS `game`;
CREATE TABLE IF NOT EXISTS `game` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `host_user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`id`, `host_user_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 0, '2019-04-23 09:58:21', '2019-05-21 03:27:44'),
(2, 2, 0, '2019-04-23 09:58:26', '2019-05-21 06:09:25'),
(3, 4, 0, '2019-04-23 09:58:33', '2019-05-16 20:27:51'),
(4, 1, 0, '2019-04-23 09:58:37', '2019-04-23 09:58:37'),
(11, 1, 0, '2019-05-13 05:25:02', '2019-05-13 05:25:02'),
(12, 1, 0, '2019-05-13 05:25:12', '2019-05-18 18:05:31');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_04_13_000000_create_user_table', 1),
(2, '2019_04_22_000000_create_game_table', 2),
(4, '2019_04_22_000000_create_channel_table', 3),
(5, '2019_04_22_000000_create_card_table', 4),
(6, '2019_04_22_000000_create_record_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `record`
--

DROP TABLE IF EXISTS `record`;
CREATE TABLE IF NOT EXISTS `record` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `result` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `record`
--

INSERT INTO `record` (`id`, `user_id`, `game_id`, `result`, `created_at`, `updated_at`) VALUES
(2, 2, 1, -1, '2019-05-14 10:15:25', '2019-05-14 10:15:25'),
(3, 1, 1, 1, '2019-05-14 10:15:25', '2019-05-14 10:15:25'),
(4, 1, 1, -1, '2019-05-14 10:59:31', '2019-05-14 10:59:31'),
(5, 2, 1, 1, '2019-05-14 10:59:31', '2019-05-14 10:59:31'),
(6, 1, 1, -1, '2019-05-15 14:03:28', '2019-05-15 14:03:28'),
(7, 2, 1, 1, '2019-05-15 14:03:29', '2019-05-15 14:03:29'),
(8, 1, 1, 1, '2019-05-15 19:36:18', '2019-05-15 19:36:18'),
(9, 2, 1, -1, '2019-05-15 19:36:18', '2019-05-15 19:36:18'),
(10, 1, 1, 1, '2019-05-15 19:37:07', '2019-05-15 19:37:07'),
(11, 2, 1, -1, '2019-05-15 19:37:07', '2019-05-15 19:37:07'),
(12, 2, 1, 1, '2019-05-15 19:43:09', '2019-05-15 19:43:09'),
(13, 1, 1, -1, '2019-05-15 19:43:09', '2019-05-15 19:43:09'),
(14, 2, 1, -1, '2019-05-15 23:05:03', '2019-05-15 23:05:03'),
(15, 1, 1, 1, '2019-05-15 23:05:03', '2019-05-15 23:05:03'),
(16, 2, 1, -1, '2019-05-15 23:13:09', '2019-05-15 23:13:09'),
(17, 1, 1, 1, '2019-05-15 23:13:09', '2019-05-15 23:13:09'),
(18, 2, 1, 1, '2019-05-15 23:16:19', '2019-05-15 23:16:19'),
(19, 1, 1, -1, '2019-05-15 23:16:19', '2019-05-15 23:16:19'),
(20, 1, 1, -1, '2019-05-16 07:09:51', '2019-05-16 07:09:51'),
(21, 2, 1, 1, '2019-05-16 07:09:51', '2019-05-16 07:09:51'),
(22, 1, 1, 1, '2019-05-16 07:21:12', '2019-05-16 07:21:12'),
(23, 2, 1, -1, '2019-05-16 07:21:12', '2019-05-16 07:21:12'),
(24, 1, 1, -1, '2019-05-16 07:21:59', '2019-05-16 07:21:59'),
(25, 2, 1, 1, '2019-05-16 07:22:00', '2019-05-16 07:22:00'),
(26, 2, 1, 1, '2019-05-16 07:27:59', '2019-05-16 07:27:59'),
(27, 1, 1, -1, '2019-05-16 07:28:00', '2019-05-16 07:28:00'),
(28, 1, 1, 1, '2019-05-16 08:08:14', '2019-05-16 08:08:14'),
(29, 2, 1, -1, '2019-05-16 08:08:14', '2019-05-16 08:08:14'),
(30, 1, 1, -1, '2019-05-16 08:10:29', '2019-05-16 08:10:29'),
(31, 2, 1, 1, '2019-05-16 08:10:29', '2019-05-16 08:10:29'),
(32, 1, 1, 1, '2019-05-16 01:17:17', '2019-05-16 01:17:17'),
(33, 2, 1, -1, '2019-05-16 01:17:17', '2019-05-16 01:17:17'),
(34, 2, 2, -1, '2019-05-16 01:19:17', '2019-05-16 01:19:17'),
(35, 1, 2, 1, '2019-05-16 01:19:18', '2019-05-16 01:19:18'),
(36, 2, 2, -1, '2019-05-16 01:20:57', '2019-05-16 01:20:57'),
(37, 1, 2, 1, '2019-05-16 01:20:57', '2019-05-16 01:20:57'),
(38, 1, 2, -1, '2019-05-16 01:23:40', '2019-05-16 01:23:40'),
(39, 2, 2, 1, '2019-05-16 01:23:40', '2019-05-16 01:23:40'),
(40, 4, 3, -1, '2019-05-16 05:41:13', '2019-05-16 05:41:13'),
(41, 2, 3, 1, '2019-05-16 05:41:13', '2019-05-16 05:41:13'),
(42, 2, 2, 1, '2019-05-16 05:52:47', '2019-05-16 05:52:47'),
(43, 4, 2, -1, '2019-05-16 05:52:48', '2019-05-16 05:52:48'),
(44, 2, 2, -1, '2019-05-16 17:42:52', '2019-05-16 17:42:52'),
(45, 1, 2, 1, '2019-05-16 17:42:52', '2019-05-16 17:42:52'),
(46, 2, 2, -1, '2019-05-16 17:45:11', '2019-05-16 17:45:11'),
(47, 1, 2, 1, '2019-05-16 17:45:11', '2019-05-16 17:45:11'),
(48, 2, 2, 1, '2019-05-16 17:45:59', '2019-05-16 17:45:59'),
(49, 1, 2, -1, '2019-05-16 17:46:00', '2019-05-16 17:46:00'),
(50, 2, 2, 1, '2019-05-16 17:47:57', '2019-05-16 17:47:57'),
(51, 1, 2, -1, '2019-05-16 17:47:57', '2019-05-16 17:47:57'),
(52, 2, 3, -1, '2019-05-16 20:02:44', '2019-05-16 20:02:44'),
(53, 4, 3, 1, '2019-05-16 20:02:44', '2019-05-16 20:02:44'),
(54, 1, 2, 1, '2019-05-16 20:06:38', '2019-05-16 20:06:38'),
(55, 2, 2, -1, '2019-05-16 20:06:38', '2019-05-16 20:06:38'),
(56, 2, 3, -1, '2019-05-16 20:27:50', '2019-05-16 20:27:50'),
(57, 4, 3, 1, '2019-05-16 20:27:50', '2019-05-16 20:27:50'),
(58, 2, 20, 1, '2019-05-16 20:51:45', '2019-05-16 20:51:45'),
(59, 1, 20, -1, '2019-05-16 20:51:45', '2019-05-16 20:51:45'),
(60, 1, 20, -1, '2019-05-16 21:48:03', '2019-05-16 21:48:03'),
(61, 2, 20, 1, '2019-05-16 21:48:04', '2019-05-16 21:48:04'),
(62, 2, 1, -1, '2019-05-16 22:39:51', '2019-05-16 22:39:51'),
(63, 1, 1, 1, '2019-05-16 22:39:51', '2019-05-16 22:39:51'),
(64, 1, 1, -1, '2019-05-17 00:18:39', '2019-05-17 00:18:39'),
(65, 2, 1, 1, '2019-05-17 00:18:39', '2019-05-17 00:18:39'),
(66, 1, 1, 1, '2019-05-17 07:24:50', '2019-05-17 07:24:50'),
(67, 2, 1, -1, '2019-05-17 07:24:50', '2019-05-17 07:24:50'),
(68, 1, 1, 1, '2019-05-17 07:26:50', '2019-05-17 07:26:50'),
(69, 2, 1, -1, '2019-05-17 07:26:51', '2019-05-17 07:26:51'),
(70, 2, 12, -1, '2019-05-18 17:59:01', '2019-05-18 17:59:01'),
(71, 1, 12, 1, '2019-05-18 17:59:01', '2019-05-18 17:59:01'),
(72, 2, 12, 1, '2019-05-18 18:00:47', '2019-05-18 18:00:47'),
(73, 1, 12, -1, '2019-05-18 18:00:48', '2019-05-18 18:00:48'),
(74, 5, 12, 1, '2019-05-18 18:05:30', '2019-05-18 18:05:30'),
(75, 2, 12, -1, '2019-05-18 18:05:30', '2019-05-18 18:05:30'),
(76, 1, 12, -1, '2019-05-18 18:05:30', '2019-05-18 18:05:30'),
(77, 1, 1, -1, '2019-05-18 22:59:10', '2019-05-18 22:59:10'),
(78, 2, 1, 1, '2019-05-18 22:59:10', '2019-05-18 22:59:10'),
(79, 5, 2, -1, '2019-05-18 23:18:45', '2019-05-18 23:18:45'),
(80, 2, 2, -1, '2019-05-18 23:18:45', '2019-05-18 23:18:45'),
(81, 1, 2, 1, '2019-05-18 23:18:45', '2019-05-18 23:18:45'),
(82, 2, 1, 1, '2019-05-21 03:19:20', '2019-05-21 03:19:20'),
(83, 1, 1, -1, '2019-05-21 03:19:20', '2019-05-21 03:19:20'),
(84, 2, 1, -1, '2019-05-21 03:27:43', '2019-05-21 03:27:43'),
(85, 1, 1, 1, '2019-05-21 03:27:43', '2019-05-21 03:27:43'),
(86, 6, 1, -1, '2019-05-21 03:27:43', '2019-05-21 03:27:43'),
(87, 1, 2, -1, '2019-05-21 03:36:56', '2019-05-21 03:36:56'),
(88, 2, 2, 1, '2019-05-21 03:36:56', '2019-05-21 03:36:56'),
(89, 1, 2, 1, '2019-05-21 03:38:20', '2019-05-21 03:38:20'),
(90, 2, 2, -1, '2019-05-21 03:38:20', '2019-05-21 03:38:20'),
(91, 1, 2, 1, '2019-05-21 03:39:39', '2019-05-21 03:39:39'),
(92, 2, 2, -1, '2019-05-21 03:39:39', '2019-05-21 03:39:39'),
(93, 2, 2, 1, '2019-05-21 03:40:24', '2019-05-21 03:40:24'),
(94, 1, 2, -1, '2019-05-21 03:40:24', '2019-05-21 03:40:24'),
(95, 2, 2, 1, '2019-05-21 06:05:02', '2019-05-21 06:05:02'),
(96, 7, 2, -1, '2019-05-21 06:05:02', '2019-05-21 06:05:02'),
(97, 2, 2, 1, '2019-05-21 06:06:26', '2019-05-21 06:06:26'),
(98, 7, 2, -1, '2019-05-21 06:06:26', '2019-05-21 06:06:26'),
(99, 2, 2, 1, '2019-05-21 06:08:34', '2019-05-21 06:08:34'),
(100, 7, 2, -1, '2019-05-21 06:08:34', '2019-05-21 06:08:34'),
(101, 7, 2, -1, '2019-05-21 06:09:25', '2019-05-21 06:09:25'),
(102, 2, 2, 1, '2019-05-21 06:09:25', '2019-05-21 06:09:25');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'jzhao11', NULL, '96e79218965eb72c92a549dd5a330112', '2019-04-15 09:27:49', '2019-04-15 09:27:49'),
(2, 'christianz', NULL, '96e79218965eb72c92a549dd5a330112', '2019-04-15 09:31:34', '2019-04-15 09:31:34'),
(3, 'testme', 'a@a.com', 'e10adc3949ba59abbe56e057f20f883e', '2019-04-19 23:50:30', '2019-04-19 23:50:30'),
(4, 'hank4457', NULL, '86c6c389eb773b047034392adb8437ac', '2019-04-20 20:52:22', '2019-04-20 20:52:22'),
(5, 'pyu3', NULL, '96e79218965eb72c92a549dd5a330112', '2019-05-18 18:02:11', '2019-05-18 18:02:11'),
(6, 'alansfsu', NULL, '96e79218965eb72c92a549dd5a330112', '2019-05-18 18:06:45', '2019-05-18 18:06:45'),
(7, 'eric96', NULL, '96e79218965eb72c92a549dd5a330112', '2019-05-18 18:07:39', '2019-05-18 18:07:39');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
