-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 09, 2021 at 11:44 AM
-- Server version: 5.7.31-cll-lve
-- PHP Version: 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u36477ca_cat`
--

-- --------------------------------------------------------

--
-- Table structure for table `cargo_audit`
--

CREATE TABLE `cargo_audit` (
  `id` int(11) NOT NULL,
  `SYS_CREATION_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `SYS_UPDATE_DATE` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `OPERATOR_ID` int(11) NOT NULL,
  `OPERATOR` varchar(512) CHARACTER SET latin1 DEFAULT NULL,
  `APP` int(11) NOT NULL DEFAULT '0' COMMENT 'GREECE=0, BULGARIA=1, BOTH=2',
  `IP` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `table` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `field` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `key` int(11) DEFAULT NULL,
  `new` varchar(256) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cargo_audit`
--

INSERT INTO `cargo_audit` (`id`, `SYS_CREATION_DATE`, `SYS_UPDATE_DATE`, `OPERATOR_ID`, `OPERATOR`, `APP`, `IP`, `table`, `field`, `key`, `new`) VALUES
(1, '2021-11-04 16:29:34', NULL, 2, 'cristian.ungureanu@gmail.com', 0, '188.27.125.94', 'cargo_request', 'NEW-ENTRY', NULL, '80'),
(2, '2021-11-04 16:32:53', NULL, 76, 'cvezasi@unit-hellas.gr', 0, '188.27.125.94', 'cargo_truck', 'NEW-ENTRY', NULL, '78'),
(3, '2021-11-05 10:35:40', NULL, 1, 'jo.ioana.pavel@gmail.com', 0, '188.27.125.94', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(4, '2021-11-05 10:37:51', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(5, '2021-11-05 10:38:08', NULL, 64, 'valentina.preda@rohel.ro', 0, '188.27.125.94', 'cargo_truck', 'NEW-ENTRY', NULL, '74'),
(6, '2021-11-05 10:50:14', NULL, 68, 'alina.ivascu@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(7, '2021-11-05 10:53:03', NULL, 68, 'alina.ivascu@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(8, '2021-11-05 10:55:19', NULL, 68, 'alina.ivascu@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(9, '2021-11-05 10:59:03', NULL, 69, 'adriana.goaga@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(10, '2021-11-05 10:59:58', NULL, 68, 'alina.ivascu@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(11, '2021-11-05 11:01:22', NULL, 69, 'adriana.goaga@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(12, '2021-11-05 11:02:12', NULL, 68, 'alina.ivascu@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(13, '2021-11-05 11:03:12', NULL, 69, 'adriana.goaga@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(14, '2021-11-05 11:03:43', NULL, 68, 'alina.ivascu@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(15, '2021-11-05 11:05:06', NULL, 68, 'alina.ivascu@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(16, '2021-11-05 11:05:17', NULL, 69, 'adriana.goaga@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(17, '2021-11-05 11:06:19', NULL, 68, 'alina.ivascu@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(18, '2021-11-05 11:07:49', NULL, 69, 'adriana.goaga@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(19, '2021-11-05 11:07:54', NULL, 68, 'alina.ivascu@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(20, '2021-11-05 11:09:15', NULL, 68, 'alina.ivascu@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '72'),
(21, '2021-11-05 11:09:28', NULL, 69, 'adriana.goaga@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(22, '2021-11-05 11:23:29', NULL, 72, 'tousios@unit-hellas.gr', 0, '62.74.160.130', 'cargo_request', 'NEW-ENTRY', NULL, '68'),
(23, '2021-11-05 11:27:58', NULL, 69, 'adriana.goaga@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '72'),
(24, '2021-11-05 11:30:31', NULL, 72, 'tousios@unit-hellas.gr', 0, '62.74.160.130', 'cargo_truck', 'status', 19, '3'),
(25, '2021-11-05 13:32:22', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(26, '2021-11-05 13:33:30', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(27, '2021-11-05 13:34:35', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(28, '2021-11-05 13:35:57', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(29, '2021-11-05 13:48:17', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(30, '2021-11-05 14:14:11', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(31, '2021-11-05 14:17:11', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(32, '2021-11-05 14:19:01', NULL, 2, 'cristian.ungureanu@gmail.com', 0, '188.27.125.94', 'cargo_request', 'status', 1, '4'),
(33, '2021-11-05 14:20:54', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(34, '2021-11-05 14:26:42', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(35, '2021-11-05 14:27:06', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'ameta', 36, 'IRO2111029'),
(36, '2021-11-05 14:27:29', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'ameta', 32, 'IRO2111025'),
(37, '2021-11-05 14:35:18', NULL, 64, 'valentina.preda@rohel.ro', 0, '188.27.125.94', 'cargo_truck', 'status', 22, '3'),
(38, '2021-11-05 14:35:39', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(39, '2021-11-05 14:37:43', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(40, '2021-11-05 14:52:30', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(41, '2021-11-05 14:54:49', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'freight', 39, '1110'),
(42, '2021-11-05 15:01:32', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '74'),
(43, '2021-11-05 15:21:26', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '74'),
(44, '2021-11-06 12:28:16', NULL, 2, 'cristian.ungureanu@gmail.com', 0, '188.27.125.94', 'cargo_request', 'NEW-ENTRY', NULL, '1'),
(45, '2021-11-06 12:32:25', NULL, 2, 'cristian.ungureanu@gmail.com', 0, '188.27.125.94', 'cargo_request', 'freight', 3, '130'),
(46, '2021-11-06 12:34:02', NULL, 2, 'cristian.ungureanu@gmail.com', 0, '188.27.125.94', 'cargo_request', 'status', 3, '4'),
(47, '2021-11-08 07:54:35', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'unloading_date', 25, '9-11-2021'),
(48, '2021-11-08 07:58:38', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(49, '2021-11-08 08:01:43', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '74'),
(50, '2021-11-08 08:08:17', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_request', 'NEW-ENTRY', NULL, '77'),
(51, '2021-11-08 08:22:24', NULL, 77, 'manou@unit-hellas.gr', 0, '195.46.23.115', 'cargo_comments', 'NEW-ENTRY', NULL, '0'),
(52, '2021-11-08 09:16:05', NULL, 68, 'alina.ivascu@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(53, '2021-11-08 09:46:17', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_request', 'NEW-ENTRY', NULL, '73'),
(54, '2021-11-08 09:49:27', NULL, 2, 'cristian.ungureanu@gmail.com', 0, '188.27.125.94', 'cargo_truck', 'NEW-ENTRY', NULL, '1'),
(55, '2021-11-08 09:49:41', NULL, 2, 'cristian.ungureanu@gmail.com', 0, '188.27.125.94', 'cargo_truck', 'ameta', 46, 'TEST-123456'),
(56, '2021-11-08 10:13:05', NULL, 66, 'gina.popescu@rohel.ro', 0, '212.146.100.194', 'cargo_request', 'NEW-ENTRY', NULL, '77'),
(57, '2021-11-08 10:15:33', NULL, 66, 'gina.popescu@rohel.ro', 0, '212.146.100.194', 'cargo_request', 'NEW-ENTRY', NULL, '77'),
(58, '2021-11-08 10:23:44', NULL, 1, 'jo.ioana.pavel@gmail.com', 0, '188.27.125.94', 'cargo_truck', 'status', 46, '2'),
(59, '2021-11-08 10:23:50', NULL, 1, 'jo.ioana.pavel@gmail.com', 0, '188.27.125.94', 'cargo_truck', 'status', 46, '3'),
(60, '2021-11-08 10:26:22', NULL, 2, 'cristian.ungureanu@gmail.com', 0, '188.27.125.94', 'cargo_request', 'NEW-ENTRY', NULL, '1'),
(61, '2021-11-08 11:02:24', NULL, 1, 'jo.ioana.pavel@gmail.com', 0, '188.27.125.94', 'cargo_request', 'acceptance', 8, '2021-11-08 13:02:24'),
(62, '2021-11-08 11:02:24', NULL, 1, 'jo.ioana.pavel@gmail.com', 0, '188.27.125.94', 'cargo_request', 'accepted_by', 8, '1'),
(63, '2021-11-08 11:02:24', NULL, 1, 'jo.ioana.pavel@gmail.com', 0, '188.27.125.94', 'cargo_request', 'status', 8, '2'),
(64, '2021-11-08 11:05:41', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'ameta', 39, 'IRO2111525'),
(65, '2021-11-08 11:17:49', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'ameta', 39, 'IRO2111026'),
(66, '2021-11-08 11:21:23', NULL, 64, 'valentina.preda@rohel.ro', 0, '212.146.100.194', 'cargo_comments', 'NEW-ENTRY', NULL, '0'),
(67, '2021-11-08 11:54:43', NULL, 73, 'maniaka@unit-hellas.gr', 0, '62.74.160.130', 'cargo_request', 'acceptance', 5, '2021-11-08 13:54:43'),
(68, '2021-11-08 11:54:43', NULL, 73, 'maniaka@unit-hellas.gr', 0, '62.74.160.130', 'cargo_request', 'accepted_by', 5, '73'),
(69, '2021-11-08 11:54:43', NULL, 73, 'maniaka@unit-hellas.gr', 0, '62.74.160.130', 'cargo_request', 'status', 5, '2'),
(70, '2021-11-08 12:32:49', NULL, 68, 'alina.ivascu@rohel.ro', 0, '212.146.100.194', 'cargo_request', 'NEW-ENTRY', NULL, '64'),
(71, '2021-11-08 12:47:05', NULL, 78, 'zahariou@unit-hellas.gr', 0, '195.46.23.115', 'cargo_request', 'NEW-ENTRY', NULL, '65'),
(72, '2021-11-08 13:20:56', NULL, 69, 'adriana.goaga@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(73, '2021-11-08 14:44:46', NULL, 69, 'adriana.goaga@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '72'),
(74, '2021-11-08 16:39:18', NULL, 2, 'cristian.ungureanu@gmail.com', 0, '188.27.125.94', 'cargo_request', 'NEW-ENTRY', NULL, '1'),
(75, '2021-11-08 16:42:06', NULL, 2, 'cristian.ungureanu@gmail.com', 0, '188.27.125.94', 'cargo_request', 'NEW-ENTRY', NULL, '1'),
(76, '2021-11-08 16:43:30', NULL, 2, 'cristian.ungureanu@gmail.com', 0, '188.27.125.94', 'cargo_request', 'from_address', 12, 'Basarab 94'),
(77, '2021-11-08 16:43:49', NULL, 1, 'jo.ioana.pavel@gmail.com', 0, '188.27.125.94', 'cargo_request', 'acceptance', 12, '2021-11-08 18:43:49'),
(78, '2021-11-08 16:43:49', NULL, 1, 'jo.ioana.pavel@gmail.com', 0, '188.27.125.94', 'cargo_request', 'accepted_by', 12, '1'),
(79, '2021-11-08 16:43:49', NULL, 1, 'jo.ioana.pavel@gmail.com', 0, '188.27.125.94', 'cargo_request', 'status', 12, '2'),
(80, '2021-11-09 08:42:52', NULL, 66, 'gina.popescu@rohel.ro', 0, '212.146.100.194', 'cargo_request', 'NEW-ENTRY', NULL, '77'),
(81, '2021-11-09 08:51:10', NULL, 69, 'adriana.goaga@rohel.ro', 0, '212.146.100.194', 'cargo_truck', 'NEW-ENTRY', NULL, '76'),
(82, '2021-11-09 08:57:29', NULL, 78, 'zahariou@unit-hellas.gr', 0, '195.46.23.115', 'cargo_request', 'NEW-ENTRY', NULL, '65'),
(83, '2021-11-09 09:00:58', NULL, 78, 'zahariou@unit-hellas.gr', 0, '195.46.23.115', 'cargo_request', 'order_type', 10, 'Confirmed'),
(84, '2021-11-09 09:01:11', NULL, 78, 'zahariou@unit-hellas.gr', 0, '195.46.23.115', 'cargo_request', 'order_type', 14, 'Confirmed'),
(85, '2021-11-09 09:04:28', NULL, 78, 'zahariou@unit-hellas.gr', 0, '195.46.23.115', 'cargo_request', 'acceptance', 4, '2021-11-09 11:04:28'),
(86, '2021-11-09 09:04:28', NULL, 78, 'zahariou@unit-hellas.gr', 0, '195.46.23.115', 'cargo_request', 'accepted_by', 4, '78'),
(87, '2021-11-09 09:04:28', NULL, 78, 'zahariou@unit-hellas.gr', 0, '195.46.23.115', 'cargo_request', 'status', 4, '2'),
(88, '2021-11-09 09:05:18', NULL, 77, 'manou@unit-hellas.gr', 0, '195.46.23.115', 'cargo_request', 'acceptance', 6, '2021-11-09 11:05:18'),
(89, '2021-11-09 09:05:18', NULL, 77, 'manou@unit-hellas.gr', 0, '195.46.23.115', 'cargo_request', 'accepted_by', 6, '77'),
(90, '2021-11-09 09:05:18', NULL, 77, 'manou@unit-hellas.gr', 0, '195.46.23.115', 'cargo_request', 'status', 6, '2'),
(91, '2021-11-09 09:05:56', NULL, 77, 'manou@unit-hellas.gr', 0, '195.46.23.115', 'cargo_comments', 'NEW-ENTRY', NULL, '0'),
(92, '2021-11-09 09:06:30', NULL, 77, 'manou@unit-hellas.gr', 0, '195.46.23.115', 'cargo_request', 'acceptance', 7, '2021-11-09 11:06:30'),
(93, '2021-11-09 09:06:30', NULL, 77, 'manou@unit-hellas.gr', 0, '195.46.23.115', 'cargo_request', 'accepted_by', 7, '77'),
(94, '2021-11-09 09:06:30', NULL, 77, 'manou@unit-hellas.gr', 0, '195.46.23.115', 'cargo_request', 'status', 7, '2'),
(95, '2021-11-09 09:06:43', NULL, 77, 'manou@unit-hellas.gr', 0, '195.46.23.115', 'cargo_comments', 'NEW-ENTRY', NULL, '0'),
(96, '2021-11-09 09:07:00', NULL, 77, 'manou@unit-hellas.gr', 0, '195.46.23.115', 'cargo_request', 'acceptance', 13, '2021-11-09 11:07:00'),
(97, '2021-11-09 09:07:00', NULL, 77, 'manou@unit-hellas.gr', 0, '195.46.23.115', 'cargo_request', 'accepted_by', 13, '77'),
(98, '2021-11-09 09:07:00', NULL, 77, 'manou@unit-hellas.gr', 0, '195.46.23.115', 'cargo_request', 'status', 13, '2'),
(99, '2021-11-09 09:07:12', NULL, 77, 'manou@unit-hellas.gr', 0, '195.46.23.115', 'cargo_comments', 'NEW-ENTRY', NULL, '0'),
(100, '2021-11-09 09:07:47', NULL, 77, 'manou@unit-hellas.gr', 0, '195.46.23.115', 'cargo_comments', 'NEW-ENTRY', NULL, '0'),
(101, '2021-11-09 09:21:48', NULL, 74, 'papadakis@unit-hellas.gr', 0, '62.74.160.130', 'cargo_truck', 'status', 41, '3'),
(102, '2021-11-09 09:38:01', NULL, 74, 'papadakis@unit-hellas.gr', 0, '62.74.160.130', 'cargo_truck', 'NEW-ENTRY', NULL, '64');

-- --------------------------------------------------------

--
-- Table structure for table `cargo_comments`
--

CREATE TABLE `cargo_comments` (
  `id` int(11) NOT NULL,
  `operator_id` int(11) DEFAULT NULL,
  `SYS_CREATION_DATE` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `SYS_UPDATE_DATE` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `cargo_id` int(11) NOT NULL,
  `comment` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cargo_comments`
--

INSERT INTO `cargo_comments` (`id`, `operator_id`, `SYS_CREATION_DATE`, `SYS_UPDATE_DATE`, `cargo_id`, `comment`) VALUES
(1, 77, '2021-11-08 08:22:24', NULL, 4, 'noted'),
(2, 64, '2021-11-08 11:21:23', NULL, 4, 'thx'),
(3, 77, '2021-11-09 09:05:56', NULL, 6, 'collection today'),
(4, 77, '2021-11-09 09:06:43', NULL, 7, 'collection today'),
(5, 77, '2021-11-09 09:07:12', NULL, 13, 'collection tomorrow'),
(6, 77, '2021-11-09 09:07:47', NULL, 4, 'collection today');

-- --------------------------------------------------------

--
-- Table structure for table `cargo_countries`
--

CREATE TABLE `cargo_countries` (
  `id` int(11) NOT NULL,
  `operator` varchar(128) DEFAULT 'webmaster@rohel.ro',
  `SYS_CREATION_DATE` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `SYS_UPDATE_DATE` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cargo_countries`
--

INSERT INTO `cargo_countries` (`id`, `operator`, `SYS_CREATION_DATE`, `SYS_UPDATE_DATE`, `name`) VALUES
(1, 'webmaster@rohel.ro', '2021-10-13 14:40:11', NULL, 'Romania'),
(2, 'webmaster@rohel.ro', '2021-10-13 14:40:11', NULL, 'Greece');

-- --------------------------------------------------------

--
-- Table structure for table `cargo_match`
--

CREATE TABLE `cargo_match` (
  `id` int(11) NOT NULL,
  `operator` varchar(128) DEFAULT 'webmaster@rohel.ro',
  `SYS_CREATION_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `SYS_UPDATE_DATE` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `originator_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 = available, \r\n2 = needed, \r\n3 = free, \r\n4 = new,\r\n5 = partial, \r\n6 = solved',
  `from_city` varchar(128) DEFAULT NULL,
  `to_city` varchar(128) DEFAULT NULL,
  `availability` datetime DEFAULT NULL,
  `details` varchar(512) DEFAULT NULL,
  `plate_number` varchar(64) DEFAULT NULL,
  `ameta` varchar(64) DEFAULT NULL,
  `order_type` varchar(64) DEFAULT NULL,
  `adr` varchar(256) DEFAULT NULL,
  `loading_meters` float NOT NULL DEFAULT '0',
  `weight` float NOT NULL DEFAULT '0',
  `volume` float NOT NULL DEFAULT '0',
  `item_id` int(11) NOT NULL DEFAULT '0',
  `item_kind` varchar(32) DEFAULT NULL,
  `item_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cargo_match`
--

INSERT INTO `cargo_match` (`id`, `operator`, `SYS_CREATION_DATE`, `SYS_UPDATE_DATE`, `originator_id`, `recipient_id`, `status`, `from_city`, `to_city`, `availability`, `details`, `plate_number`, `ameta`, `order_type`, `adr`, `loading_meters`, `weight`, `volume`, `item_id`, `item_kind`, `item_date`) VALUES
(1, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 74, 64, 1, 'CRAIOVA', 'Greece', '2021-11-11 00:00:00', 'DRAGOMIR MARIN', 'B24XIE/B80YAJ', 'ERO2111032', 'N/A', '', 11.2, 3000, 50, 50, 'truckInfo', '2021-11-09 11:38:01'),
(2, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 74, 64, 1, 'BUCHAREST', 'Greece', '2021-11-11 00:00:00', 'DRAGOMIR MARIN', 'B24XIE/B80YAJ', 'ERO2111032', 'N/A', '', 2.4, 2000, 10, 50, 'truckInfo', '2021-11-09 11:38:01'),
(3, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 69, 76, 1, 'ATENA', 'Romania', '2021-11-11 00:00:00', 'COJOCARELU GHEORGHE', 'DB57ADL/DB12GOU', 'IRO2111578', 'N/A', '', 13.6, 23, 0, 49, 'truckInfo', '2021-11-09 10:51:10'),
(4, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 69, 72, 1, 'LARISSA', 'Romania', '2021-11-11 00:00:00', 'ANDREI GABRIEL +40 741 604 737', 'AG06TZU/AG07TZU', 'IRO2111576', 'N/A', '', 13.6, 23, 0, 48, 'truckInfo', '2021-11-08 16:44:46'),
(5, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 69, 76, 1, 'PELLA', 'Romania', '2021-11-11 00:00:00', 'PAVEL CATALIN; +40 726 819 663', 'DB82 PAV/DB 08 PAV', 'IRO2111574', 'N/A', '', 7, 10000, 0, 47, 'truckInfo', '2021-11-08 15:20:56'),
(6, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 69, 76, 1, 'MEGARA', 'Romania', '2021-11-11 00:00:00', 'PAVEL CATALIN; +40 726 819 663', 'DB82 PAV/DB 08 PAV', 'IRO2111574', 'N/A', '', 6.6, 12000, 0, 47, 'truckInfo', '2021-11-08 15:20:56'),
(7, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 68, 76, 1, 'Schimatari ', 'Romania', '2021-11-11 00:00:00', '-', 'VL44TEA/VL82TEA', 'ERO2111570', 'N/A', '', 13.6, 23000, 75, 44, 'truckInfo', '2021-11-08 11:16:05'),
(8, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 64, 74, 1, 'RUSE', 'Romania', '2021-11-10 00:00:00', 'MIHALEA CORNEL 0722627718', 'B930STC/B929STC', 'IRO2111033', 'N/A', '', 0, 0, 0, 43, 'truckInfo', '2021-11-08 10:01:43'),
(9, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 64, 74, 1, 'SALONIC', 'Romania', '2021-11-10 00:00:00', 'MIHALEA CORNEL 0722627718', 'B930STC/B929STC', 'IRO2111033', 'N/A', '', 0, 0, 0, 43, 'truckInfo', '2021-11-08 10:01:43'),
(10, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 64, 76, 3, 'ASPROPIRGOS', 'Romania', '2021-11-10 00:00:00', 'MARTOIU CONSTANTIN â€“0748456352', 'GJ26MIT/B79UUI', 'IRO2111034', 'N/A', '', 13.6, 20000, 80, 42, 'truckInfo', '2021-11-08 09:58:38'),
(11, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 64, 74, 6, 'SALONIC', 'Romania', '2021-11-08 00:00:00', 'DRAGOMIR MARIN 0744329019', 'B24XIE/B80YAJ', 'IRO2111032', 'N/A', '', 13.6, 0, 0, 41, 'truckInfo', '2021-11-05 17:21:26'),
(12, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 64, 74, 1, 'SALONIC', 'Romania', '2021-11-08 00:00:00', 'VADUVA STELIAN 720048316', 'IF02ATE/IF11ATE', 'IRO2111030', 'N/A', '', 4.8, 0, 0, 40, 'truckInfo', '2021-11-05 17:01:32'),
(13, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 64, 74, 1, 'SALONIC', 'Romania', '2021-11-08 00:00:00', 'VADUVA STELIAN 720048316', 'IF02ATE/IF11ATE', 'IRO2111030', 'N/A', '', 13, 0, 0, 40, 'truckInfo', '2021-11-05 17:01:32'),
(14, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 64, 76, 1, 'ALMYRO', 'Romania', '2021-11-08 00:00:00', 'LIXANDRU 0734198664', 'DB84EMY/DB85EMY', 'IRO2111026', 'N/A', '', 6.6, 11000, 0, 39, 'truckInfo', '2021-11-05 16:52:30'),
(15, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 64, 76, 1, 'ASPROPIRGOS', 'Romania', '2021-11-08 00:00:00', 'LIXANDRU 0734198664', 'DB84EMY/DB85EMY', 'IRO2111026', 'N/A', '', 6.8, 5153, 0, 39, 'truckInfo', '2021-11-05 16:52:30'),
(16, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 64, 76, 3, 'SALONIC', 'Romania', '2021-11-08 00:00:00', 'BLINDU VICTOR  0754455163', 'GJ25MIT/GJ55MIT', 'IRO2111018', 'N/A', '', 0.8, 0, 0, 38, 'truckInfo', '2021-11-05 16:37:42'),
(17, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 64, 76, 3, 'ATENA', 'Romania', '2021-11-08 00:00:00', 'BLINDU VICTOR  0754455163', 'GJ25MIT/GJ55MIT', 'IRO2111018', 'N/A', '', 12.4, 0, 0, 38, 'truckInfo', '2021-11-05 16:37:42'),
(18, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 64, 76, 1, 'SCHIMATARI', 'Romania', '2021-11-08 00:00:00', 'MIHAI IONEL 722256984', 'B67GOT/B65GOT', 'IRO2111012', 'N/A', '', 6, 6000, 0, 37, 'truckInfo', '2021-11-05 16:35:39'),
(19, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 64, 76, 1, 'ATENA', 'Romania', '2021-11-08 00:00:00', 'MIHAI IONEL 722256984', 'B67GOT/B65GOT', 'IRO2111012', 'N/A', '', 7.2, 4007, 0, 37, 'truckInfo', '2021-11-05 16:35:39'),
(20, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 64, 76, 1, 'KOLONOS', 'Romania', '2021-11-08 00:00:00', 'NITU MIHAI 757010115', 'IF85NMS/IF69NMS', 'IRO2111029', 'N/A', '', 8, 0, 0, 36, 'truckInfo', '2021-11-05 16:26:42'),
(21, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 64, 76, 1, 'ASPROPIRGOS', 'Romania', '2021-11-08 00:00:00', 'NITU MIHAI 757010115', 'IF85NMS/IF69NMS', 'IRO2111029', 'N/A', '', 2.4, 0, 0, 36, 'truckInfo', '2021-11-05 16:26:42'),
(22, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 64, 76, 1, 'VOTANIKOS', 'Romania', '2021-11-08 00:00:00', 'NITU MIHAI 757010115', 'IF85NMS/IF69NMS', 'IRO2111029', 'N/A', '', 2, 4500, 0, 36, 'truckInfo', '2021-11-05 16:26:42'),
(23, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 64, 76, 1, 'KOROPI', 'Romania', '2021-11-08 00:00:00', 'ALIMAN GHEORGHE 728374556', 'IF60NMS/IF61NMS', 'IRO2111028', 'N/A', '', 8, 0, 0, 35, 'truckInfo', '2021-11-05 16:20:54'),
(24, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 64, 76, 1, 'ASPROPIRGOS', 'Romania', '2021-11-08 00:00:00', 'ALIMAN GHEORGHE 728374556', 'IF60NMS/IF61NMS', 'IRO2111028', 'N/A', '', 2, 4200, 0, 35, 'truckInfo', '2021-11-05 16:20:54'),
(25, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:53', NULL, 64, 76, 1, 'KOROPI', 'Romania', '2021-11-08 00:00:00', 'BULUMAC MARIAN 0721557328', 'IF50LDT/IF77LDT', 'IRO2111024', 'N/A', '', 9.9, 1000, 0, 34, 'truckInfo', '2021-11-05 16:17:11'),
(26, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 64, 76, 1, 'ACHARNES', 'Romania', '2021-11-08 00:00:00', 'BULUMAC MARIAN 0721557328', 'IF50LDT/IF77LDT', 'IRO2111024', 'N/A', '', 2.4, 2618, 0, 34, 'truckInfo', '2021-11-05 16:17:11'),
(27, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 64, 76, 1, 'RENTIS', 'Romania', '2021-11-08 00:00:00', 'BULUMAC MARIAN 0721557328', 'IF50LDT/IF77LDT', 'IRO2111024', 'N/A', '', 2, 3000, 0, 34, 'truckInfo', '2021-11-05 16:17:11'),
(28, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 64, 76, 1, 'ASPROPIRGOS', 'Romania', '2021-11-08 00:00:00', 'UTA FLORIN  766710272', 'IF05MBC/B108CUO', 'IRO2111027', 'N/A', '', 7.4, 6700, 0, 33, 'truckInfo', '2021-11-05 16:14:11'),
(29, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 64, 76, 1, 'KOROPI', 'Romania', '2021-11-08 00:00:00', 'UTA FLORIN  766710272', 'IF05MBC/B108CUO', 'IRO2111027', 'N/A', '', 6, 15570, 0, 33, 'truckInfo', '2021-11-05 16:14:11'),
(30, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 64, 76, 1, 'ASPROPIRGOS', 'Romania', '2021-11-08 00:00:00', 'PETRIS FLORIN  723309005', 'TR05XFP/TR08XFP', 'IRO2111025', 'N/A', '', 2.2, 134.2, 0, 32, 'truckInfo', '2021-11-05 15:48:17'),
(31, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 64, 76, 1, 'ASPROPIRGOS', 'Romania', '2021-11-08 00:00:00', 'PETRIS FLORIN  723309005', 'TR05XFP/TR08XFP', 'IRO2111025', 'N/A', '', 2.8, 1630, 0, 32, 'truckInfo', '2021-11-05 15:48:17'),
(32, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 64, 76, 1, 'KOROPI', 'Romania', '2021-11-08 00:00:00', 'PETRIS FLORIN  723309005', 'TR05XFP/TR08XFP', 'IRO2111025', 'N/A', '', 8.7, 13500, 0, 32, 'truckInfo', '2021-11-05 15:48:17'),
(33, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 64, 76, 1, 'MANDRA', 'Romania', '2021-11-09 00:00:00', 'VELEA ION  0744345428', 'B801CRS/B802CRS', 'IRO2111017', 'N/A', '', 13.6, 20000, 80, 25, 'truckInfo', '2021-11-05 15:35:57'),
(34, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 64, 76, 1, 'MANDRA', 'Romania', '2021-11-08 00:00:00', 'Nicolae Pavel', 'TR36PRO/TR38PRO', 'IRO2111016', 'N/A', '', 13.6, 20000, 80, 24, 'truckInfo', '2021-11-05 15:34:35'),
(35, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 64, 76, 1, 'MANDRA', 'Romania', '2021-11-09 00:00:00', '+40 751 420 150', 'AG99GMA/AG99GMC', 'IRO2111015', 'N/A', '', 13.6, 20000, 80, 23, 'truckInfo', '2021-11-05 15:33:30'),
(36, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 69, 72, 1, 'KILKIS', 'Romania', '2021-11-10 00:00:00', 'GIGI GOLICI ; +40 735 576 350', 'IF07BYS/IF06BYS', 'IRO2111562', 'N/A', '', 0, 23, 75, 21, 'truckInfo', '2021-11-05 13:27:58'),
(37, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 69, 76, 1, 'SCHIMATARI', 'Romania', '2021-11-10 00:00:00', 'NEAGU CIPRIAN', 'PH23RCC/PH12RCC', 'IRO2111560', 'N/A', 'yes', 0, 23, 75, 20, 'truckInfo', '2021-11-05 13:09:28'),
(38, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 68, 72, 1, 'kilkis', 'Romania', '2021-11-09 00:00:00', 'Paun Adrian', 'DB 72 PGS/AG 80 PGS', 'IRO2111558', 'N/A', '', 0, 23000, 75, 19, 'truckInfo', '2021-11-05 13:09:15'),
(39, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 68, 76, 1, 'Corinth', 'Romania', '2021-11-10 00:00:00', 'Cioaga Laurentiu, 0749175604', 'B540BAG/B550BAG', 'IRO2111553', 'N/A', '', 0, 23000, 75, 18, 'truckInfo', '2021-11-05 13:07:54'),
(40, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 69, 76, 1, 'ATENA', 'Romania', '2021-11-08 00:00:00', '-', 'TR36PRO/TR38PRO', 'IRO2111016', 'N/A', '', 0, 23, 75, 17, 'truckInfo', '2021-11-05 13:07:49'),
(41, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 68, 76, 1, 'Inofita', 'Romania', '2021-11-08 00:00:00', 'Patrascoiu Ion', 'GJ66XXL/GJ68XXL', 'IRO2110760', 'N/A', 'yes', 0, 23000, 75, 16, 'truckInfo', '2021-11-05 13:06:19'),
(42, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 69, 76, 1, 'ASPROPIRGOS', 'Romania', '2021-11-09 00:00:00', 'Dimineata Anton; +40 757 657 920', 'BZ16LRT/BZ20LRT', 'IRO2111541', 'N/A', '', 0, 23, 75, 15, 'truckInfo', '2021-11-05 13:05:16'),
(43, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 68, 76, 1, 'Thiva', 'Romania', '2021-11-08 00:00:00', 'Dinu Elvis', 'VL 43 MRD/VL 34 MRD', 'IRO2111551', 'N/A', '', 0, 23000, 75, 14, 'truckInfo', '2021-11-05 13:05:06'),
(44, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 68, 76, 1, 'Schimatari ', 'Romania', '2021-11-08 00:00:00', 'Cutoiu Marius, +40 732 428 474', 'DB77EVY/DB05CTF', 'IRO2111534', 'N/A', '', 0, 23000, 75, 13, 'truckInfo', '2021-11-05 13:03:43'),
(45, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 69, 76, 1, 'SCHIMATARI', 'Romania', '2021-11-08 00:00:00', 'GEORGESCU AUREL; +40 748 011 418', 'AG95GMA/B394GMA', 'IRO2111542', 'N/A', 'yes', 0, 23, 75, 12, 'truckInfo', '2021-11-05 13:03:12'),
(46, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 68, 76, 1, 'Atena', 'Romania', '2021-11-09 00:00:00', 'Nenciu Mihai', 'AG99GMA/AG99GMC', 'IRO2111015', 'N/A', 'YES', 0, 23000, 75, 11, 'truckInfo', '2021-11-05 13:02:11'),
(47, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 69, 76, 1, 'CORINTH', 'Romania', '2021-11-08 00:00:00', 'SARU VALENTIN; 0741274441', 'AG15SCV/B24SPB', 'IRO2111546', 'N/A', '', 0, 23, 75, 10, 'truckInfo', '2021-11-05 13:01:22'),
(48, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 68, 76, 1, 'Atena', 'Romania', '2021-11-08 00:00:00', '-', 'B450PGT/B451PGT', 'IRO2111530', 'N/A', '', 0, 230000, 75, 9, 'truckInfo', '2021-11-05 12:59:58'),
(49, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 69, 76, 1, 'corinth', 'Romania', '2021-11-08 00:00:00', 'Mihai Doroftei ; +40 754 539 808', 'AG92DBY/AG99DBY', 'IRO2111555', 'N/A', 'yes', 0, 23, 75, 8, 'truckInfo', '2021-11-05 12:59:03'),
(50, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 68, 76, 1, 'Atena', 'Romania', '2021-11-08 00:00:00', 'Saru', 'B300SCM/CV07BED', 'IRO2111527', 'N/A', '', 0, 23000, 75, 7, 'truckInfo', '2021-11-05 12:55:18'),
(51, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 68, 76, 1, 'Atena', 'Romania', '2021-11-08 00:00:00', 'Georgescu Marius, +40 755 309 934', 'A94GMA/AG49GMA', 'IRO2111524', 'N/A', '', 0, 23000, 75, 6, 'truckInfo', '2021-11-05 12:53:03'),
(52, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 68, 76, 1, 'Aspropirgos', 'Romania', '2021-11-08 00:00:00', 'Bratut Adrian,+40 765 440 991', 'B500BAG/B600BAG', 'IRO2111512', 'N/A', 'yes', 0, 23000, 75, 5, 'truckInfo', '2021-11-05 12:50:14'),
(53, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 64, 76, 1, 'ASPROPIRGOS', 'Romania', '2021-11-08 00:00:00', 'PETRIS FLORIN', 'TR05XFP/TR08XFP', 'IRO2111025', 'N/A', '', 2.8, 1800, 0, 3, 'truckInfo', '2021-11-05 12:37:51'),
(54, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 64, 76, 1, 'KOROPI', 'Romania', '2021-11-08 00:00:00', 'PETRIS FLORIN', 'TR05XFP/TR08XFP', 'IRO2111025', 'N/A', '', 7.9, 12400, 0, 3, 'truckInfo', '2021-11-05 12:37:51'),
(55, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 78, 65, 2, 'MURES', 'SPATA', '2021-11-11 00:00:00', '', '', '', 'Confirmed', '', 2, 2000, 0, 14, 'cargoInfo', '2021-11-09 10:57:29'),
(56, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 66, 77, 2, 'ATHENS', 'BUCHAREST', '2021-11-09 00:00:00', '', '', '', 'Confirmed', '', 0, 3, 0, 13, 'cargoInfo', '2021-11-09 10:42:52'),
(57, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 78, 65, 2, 'COMUNA BRADU', '18233 RENTIS ', '2021-11-10 00:00:00', '', '', '', 'Confirmed', '', 1.2, 810, 4.608, 10, 'cargoInfo', '2021-11-08 14:47:05'),
(58, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 68, 64, 2, 'Zarnesti', 'Inofita', '2021-11-09 00:00:00', '', '', '', 'Bid', '', 13.6, 23000, 75, 9, 'cargoInfo', '2021-11-08 14:32:49'),
(59, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 66, 77, 2, 'ATHENS', 'Clinceni', '2021-11-08 00:00:00', '', '', '', 'Confirmed', '', 0, 0, 0, 7, 'cargoInfo', '2021-11-08 12:15:33'),
(60, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 66, 77, 2, 'KOROPI', 'Clinceni', '2021-11-08 00:00:00', '', '', '', 'Confirmed', '', 0, 11, 0.064, 6, 'cargoInfo', '2021-11-08 12:13:05'),
(61, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 64, 73, 2, 'SALONIC', 'CONSTANTA', '2021-11-08 00:00:00', '', '', '', 'Confirmed', '', 0.4, 104, 0, 5, 'cargoInfo', '2021-11-08 11:46:17'),
(62, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 64, 77, 2, 'ASPROPIRGOS', 'BUCHAREST', '2021-11-08 00:00:00', '', '', '', 'Confirmed', '', 0.8, 240, 0, 4, 'cargoInfo', '2021-11-08 10:08:17'),
(63, 'cristian.ungureanu@gmail.com', '2021-11-09 09:41:54', NULL, 72, 68, 2, 'Orestiada', 'Bucharest', '2021-11-08 00:00:00', '', '', '', 'Bid', '', 13.6, 24000, 50, 2, 'cargoInfo', '2021-11-05 13:23:29');

-- --------------------------------------------------------

--
-- Table structure for table `cargo_notifications`
--

CREATE TABLE `cargo_notifications` (
  `id` int(11) NOT NULL,
  `operator` varchar(128) DEFAULT 'webmaster@rohel.ro',
  `SYS_CREATION_DATE` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `SYS_UPDATE_DATE` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `originator_id` int(11) NOT NULL,
  `notification_kind` int(11) DEFAULT NULL COMMENT '1 - new item, 2 - changed item, 3 - approved item, 4 - cancelled',
  `entity_kind` int(11) DEFAULT NULL COMMENT '1 - cargo, 2 - truck, 3 - truck stop, 4 - cargo note',
  `entity_id` int(11) DEFAULT NULL,
  `viewed` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cargo_notifications`
--

INSERT INTO `cargo_notifications` (`id`, `operator`, `SYS_CREATION_DATE`, `SYS_UPDATE_DATE`, `user_id`, `originator_id`, `notification_kind`, `entity_kind`, `entity_id`, `viewed`) VALUES
(1, 'cristian.ungureanu@gmail.com', '2021-11-04 16:29:34', NULL, 80, 2, 1, 1, 1, 0),
(2, 'cvezasi@unit-hellas.gr', '2021-11-04 16:32:53', NULL, 78, 76, 1, 2, 1, 0),
(3, 'jo.ioana.pavel@gmail.com', '2021-11-05 10:35:40', NULL, 76, 1, 1, 2, 2, 0),
(4, 'valentina.preda@rohel.ro', '2021-11-05 10:37:51', NULL, 76, 64, 1, 2, 3, 0),
(5, 'valentina.preda@rohel.ro', '2021-11-05 10:38:08', NULL, 74, 64, 1, 2, 4, 0),
(6, 'valentina.preda@rohel.ro', '2021-11-05 10:39:02', NULL, 76, 64, 1, 3, 3, 0),
(7, 'alina.ivascu@rohel.ro', '2021-11-05 10:50:14', NULL, 76, 68, 1, 2, 5, 0),
(8, 'alina.ivascu@rohel.ro', '2021-11-05 10:53:03', NULL, 76, 68, 1, 2, 6, 0),
(9, 'alina.ivascu@rohel.ro', '2021-11-05 10:55:19', NULL, 76, 68, 1, 2, 7, 0),
(10, 'adriana.goaga@rohel.ro', '2021-11-05 10:59:03', NULL, 76, 69, 1, 2, 8, 0),
(11, 'alina.ivascu@rohel.ro', '2021-11-05 10:59:58', NULL, 76, 68, 1, 2, 9, 0),
(12, 'adriana.goaga@rohel.ro', '2021-11-05 11:01:22', NULL, 76, 69, 1, 2, 10, 0),
(13, 'alina.ivascu@rohel.ro', '2021-11-05 11:02:12', NULL, 76, 68, 1, 2, 11, 0),
(14, 'adriana.goaga@rohel.ro', '2021-11-05 11:03:12', NULL, 76, 69, 1, 2, 12, 0),
(15, 'alina.ivascu@rohel.ro', '2021-11-05 11:03:43', NULL, 76, 68, 1, 2, 13, 0),
(16, 'alina.ivascu@rohel.ro', '2021-11-05 11:05:06', NULL, 76, 68, 1, 2, 14, 0),
(17, 'adriana.goaga@rohel.ro', '2021-11-05 11:05:17', NULL, 76, 69, 1, 2, 15, 0),
(18, 'alina.ivascu@rohel.ro', '2021-11-05 11:06:19', NULL, 76, 68, 1, 2, 16, 0),
(19, 'adriana.goaga@rohel.ro', '2021-11-05 11:07:49', NULL, 76, 69, 1, 2, 17, 0),
(20, 'alina.ivascu@rohel.ro', '2021-11-05 11:07:54', NULL, 76, 68, 1, 2, 18, 0),
(21, 'alina.ivascu@rohel.ro', '2021-11-05 11:09:15', NULL, 72, 68, 1, 2, 19, 0),
(22, 'adriana.goaga@rohel.ro', '2021-11-05 11:09:28', NULL, 76, 69, 1, 2, 20, 0),
(23, 'tousios@unit-hellas.gr', '2021-11-05 11:23:29', '2021-11-05 11:25:00', 68, 72, 1, 1, 2, 1),
(24, 'adriana.goaga@rohel.ro', '2021-11-05 11:27:58', NULL, 72, 69, 1, 2, 21, 0),
(25, 'tousios@unit-hellas.gr', '2021-11-05 11:30:31', NULL, 72, 72, 4, 2, 19, 0),
(26, 'valentina.preda@rohel.ro', '2021-11-05 13:32:22', NULL, 76, 64, 1, 2, 22, 0),
(27, 'valentina.preda@rohel.ro', '2021-11-05 13:33:30', NULL, 76, 64, 1, 2, 23, 0),
(28, 'valentina.preda@rohel.ro', '2021-11-05 13:34:35', NULL, 76, 64, 1, 2, 24, 0),
(29, 'valentina.preda@rohel.ro', '2021-11-05 13:35:57', NULL, 76, 64, 1, 2, 25, 0),
(30, 'valentina.preda@rohel.ro', '2021-11-05 13:48:17', NULL, 76, 64, 1, 2, 32, 0),
(31, 'valentina.preda@rohel.ro', '2021-11-05 14:14:11', NULL, 76, 64, 1, 2, 33, 0),
(32, 'valentina.preda@rohel.ro', '2021-11-05 14:17:11', NULL, 76, 64, 1, 2, 34, 0),
(33, 'cristian.ungureanu@gmail.com', '2021-11-05 14:19:02', NULL, 80, 2, 4, 1, 1, 0),
(34, 'valentina.preda@rohel.ro', '2021-11-05 14:20:54', NULL, 76, 64, 1, 2, 35, 0),
(35, 'valentina.preda@rohel.ro', '2021-11-05 14:26:42', NULL, 76, 64, 1, 2, 36, 0),
(36, 'valentina.preda@rohel.ro', '2021-11-05 14:27:06', NULL, 76, 64, 2, 2, 36, 0),
(37, 'valentina.preda@rohel.ro', '2021-11-05 14:27:29', NULL, 76, 64, 2, 2, 32, 0),
(38, 'valentina.preda@rohel.ro', '2021-11-05 14:35:18', NULL, 76, 64, 4, 2, 22, 0),
(39, 'valentina.preda@rohel.ro', '2021-11-05 14:35:39', NULL, 76, 64, 1, 2, 37, 0),
(40, 'valentina.preda@rohel.ro', '2021-11-05 14:37:43', NULL, 76, 64, 1, 2, 38, 0),
(41, 'valentina.preda@rohel.ro', '2021-11-05 14:52:30', NULL, 76, 64, 1, 2, 39, 0),
(42, 'valentina.preda@rohel.ro', '2021-11-05 14:54:49', NULL, 76, 64, 2, 2, 39, 0),
(43, 'valentina.preda@rohel.ro', '2021-11-05 15:01:32', NULL, 74, 64, 1, 2, 40, 0),
(44, 'valentina.preda@rohel.ro', '2021-11-05 15:21:26', NULL, 74, 64, 1, 2, 41, 0),
(45, 'cristian.ungureanu@gmail.com', '2021-11-06 12:28:16', '2021-11-08 07:45:38', 1, 2, 1, 1, 3, 1),
(46, 'cristian.ungureanu@gmail.com', '2021-11-06 12:32:25', '2021-11-08 07:45:38', 1, 2, 2, 1, 3, 1),
(47, 'cristian.ungureanu@gmail.com', '2021-11-06 12:34:02', '2021-11-08 07:45:38', 1, 2, 4, 1, 3, 1),
(48, 'valentina.preda@rohel.ro', '2021-11-08 07:54:35', NULL, 76, 64, 2, 2, 25, 0),
(49, 'valentina.preda@rohel.ro', '2021-11-08 07:58:38', NULL, 76, 64, 1, 2, 42, 0),
(50, 'valentina.preda@rohel.ro', '2021-11-08 08:01:43', '2021-11-09 09:44:39', 74, 64, 1, 2, 43, 1),
(51, 'valentina.preda@rohel.ro', '2021-11-08 08:08:17', '2021-11-08 08:18:26', 77, 64, 1, 1, 4, 1),
(52, 'manou@unit-hellas.gr', '2021-11-08 08:22:24', '2021-11-08 15:49:03', 64, 77, 1, 4, 4, 1),
(53, 'alina.ivascu@rohel.ro', '2021-11-08 09:16:05', NULL, 76, 68, 1, 2, 44, 0),
(54, 'valentina.preda@rohel.ro', '2021-11-08 09:46:17', '2021-11-08 09:51:57', 73, 64, 1, 1, 5, 1),
(55, 'cristian.ungureanu@gmail.com', '2021-11-08 09:49:27', '2021-11-08 10:45:33', 1, 2, 1, 2, 46, 1),
(56, 'cristian.ungureanu@gmail.com', '2021-11-08 09:49:41', '2021-11-08 10:45:33', 1, 2, 2, 2, 46, 1),
(57, 'gina.popescu@rohel.ro', '2021-11-08 10:13:05', '2021-11-08 10:22:50', 77, 66, 1, 1, 6, 1),
(58, 'gina.popescu@rohel.ro', '2021-11-08 10:15:33', '2021-11-08 10:23:16', 77, 66, 1, 1, 7, 1),
(59, 'jo.ioana.pavel@gmail.com', '2021-11-08 10:23:44', '2021-11-08 10:53:03', 1, 1, 4, 2, 46, 1),
(60, 'jo.ioana.pavel@gmail.com', '2021-11-08 10:23:50', '2021-11-08 10:53:03', 1, 1, 4, 2, 46, 1),
(61, 'cristian.ungureanu@gmail.com', '2021-11-08 10:26:22', '2021-11-08 10:27:04', 1, 2, 1, 1, 8, 1),
(62, 'jo.ioana.pavel@gmail.com', '2021-11-08 11:02:24', '2021-11-08 11:05:50', 2, 1, 3, 1, 8, 1),
(63, 'valentina.preda@rohel.ro', '2021-11-08 11:05:41', NULL, 76, 64, 2, 2, 39, 0),
(64, 'valentina.preda@rohel.ro', '2021-11-08 11:17:49', NULL, 76, 64, 2, 2, 39, 0),
(65, 'valentina.preda@rohel.ro', '2021-11-08 11:21:23', NULL, 77, 64, 1, 4, 4, 0),
(66, 'maniaka@unit-hellas.gr', '2021-11-08 11:54:43', '2021-11-08 13:13:56', 64, 73, 3, 1, 5, 1),
(67, 'alina.ivascu@rohel.ro', '2021-11-08 12:32:49', '2021-11-08 13:11:43', 64, 68, 1, 1, 9, 1),
(68, 'zahariou@unit-hellas.gr', '2021-11-08 12:47:05', NULL, 65, 78, 1, 1, 10, 0),
(69, 'adriana.goaga@rohel.ro', '2021-11-08 13:20:56', NULL, 76, 69, 1, 2, 47, 0),
(70, 'adriana.goaga@rohel.ro', '2021-11-08 14:44:46', NULL, 72, 69, 1, 2, 48, 0),
(75, 'gina.popescu@rohel.ro', '2021-11-09 08:42:52', '2021-11-09 08:46:11', 77, 66, 1, 1, 13, 1),
(76, 'adriana.goaga@rohel.ro', '2021-11-09 08:51:10', NULL, 76, 69, 1, 2, 49, 0),
(77, 'zahariou@unit-hellas.gr', '2021-11-09 08:57:29', NULL, 65, 78, 1, 1, 14, 0),
(78, 'zahariou@unit-hellas.gr', '2021-11-09 09:00:58', NULL, 65, 78, 2, 1, 10, 0),
(79, 'zahariou@unit-hellas.gr', '2021-11-09 09:01:11', NULL, 65, 78, 2, 1, 14, 0),
(80, 'zahariou@unit-hellas.gr', '2021-11-09 09:04:28', NULL, 64, 78, 3, 1, 4, 0),
(81, 'manou@unit-hellas.gr', '2021-11-09 09:05:18', NULL, 66, 77, 3, 1, 6, 0),
(82, 'manou@unit-hellas.gr', '2021-11-09 09:05:56', NULL, 66, 77, 1, 4, 6, 0),
(83, 'manou@unit-hellas.gr', '2021-11-09 09:06:30', NULL, 66, 77, 3, 1, 7, 0),
(84, 'manou@unit-hellas.gr', '2021-11-09 09:06:43', NULL, 66, 77, 1, 4, 7, 0),
(85, 'manou@unit-hellas.gr', '2021-11-09 09:07:00', NULL, 66, 77, 3, 1, 13, 0),
(86, 'manou@unit-hellas.gr', '2021-11-09 09:07:12', NULL, 66, 77, 1, 4, 13, 0),
(87, 'manou@unit-hellas.gr', '2021-11-09 09:07:47', NULL, 64, 77, 1, 4, 4, 0),
(88, 'papadakis@unit-hellas.gr', '2021-11-09 09:21:48', NULL, 74, 74, 2, 2, 41, 0),
(89, 'papadakis@unit-hellas.gr', '2021-11-09 09:38:01', NULL, 64, 74, 1, 2, 50, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cargo_offices`
--

CREATE TABLE `cargo_offices` (
  `id` int(11) NOT NULL,
  `operator` varchar(128) DEFAULT 'webmaster@rohel.ro',
  `SYS_CREATION_DATE` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `SYS_UPDATE_DATE` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(64) DEFAULT NULL,
  `importance` int(11) NOT NULL,
  `country` int(11) NOT NULL DEFAULT '1' COMMENT '1 = Romania, 2 = Greece, 3 = Serbia, 4 = Moldova'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cargo_offices`
--

INSERT INTO `cargo_offices` (`id`, `operator`, `SYS_CREATION_DATE`, `SYS_UPDATE_DATE`, `name`, `importance`, `country`) VALUES
(1, 'webmaster@rohel.ro', '2021-10-13 07:05:04', '2021-10-13 15:48:03', 'Bucharest', 1, 1),
(2, 'webmaster@rohel.ro', '2021-10-13 07:07:04', '2021-10-13 15:48:11', 'Deva', 4, 1),
(3, 'webmaster@rohel.ro', '2021-10-13 07:07:04', '2021-10-13 15:48:13', 'Pucioasa', 5, 1),
(4, 'webmaster@rohel.ro', '2021-10-13 07:07:04', '2021-10-15 11:34:50', 'Athens', 2, 2),
(5, 'webmaster@rohel.ro', '2021-10-13 07:07:04', '2021-10-15 11:34:53', 'Salonic', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `cargo_request`
--

CREATE TABLE `cargo_request` (
  `id` int(11) NOT NULL,
  `SYS_CREATION_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `SYS_UPDATE_DATE` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 = new 2 = accepted 3 = closed 4 = cancelled 5 = expired',
  `operator` varchar(128) DEFAULT NULL,
  `client` varchar(256) DEFAULT NULL,
  `from_city` varchar(256) DEFAULT NULL,
  `from_address` varchar(512) NOT NULL,
  `loading_date` datetime DEFAULT NULL,
  `description` varchar(512) DEFAULT NULL,
  `instructions` varchar(64) DEFAULT NULL,
  `freight` float DEFAULT '0',
  `accepted_by` int(11) DEFAULT NULL,
  `status_changed_by` int(11) NOT NULL DEFAULT '0',
  `acceptance` datetime DEFAULT NULL,
  `expiration` datetime DEFAULT NULL,
  `plate_number` varchar(64) DEFAULT NULL,
  `ameta` varchar(64) DEFAULT NULL,
  `order_type` varchar(64) DEFAULT NULL,
  `adr` varchar(256) DEFAULT NULL,
  `to_city` varchar(128) DEFAULT NULL,
  `to_address` varchar(256) DEFAULT NULL,
  `unloading_date` datetime DEFAULT NULL,
  `collies` int(11) NOT NULL DEFAULT '0',
  `weight` float NOT NULL DEFAULT '0',
  `volume` float NOT NULL DEFAULT '0',
  `loading_meters` float NOT NULL DEFAULT '0',
  `dimensions` varchar(128) DEFAULT NULL,
  `package` varchar(128) DEFAULT NULL,
  `originator_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cargo_request`
--

INSERT INTO `cargo_request` (`id`, `SYS_CREATION_DATE`, `SYS_UPDATE_DATE`, `status`, `operator`, `client`, `from_city`, `from_address`, `loading_date`, `description`, `instructions`, `freight`, `accepted_by`, `status_changed_by`, `acceptance`, `expiration`, `plate_number`, `ameta`, `order_type`, `adr`, `to_city`, `to_address`, `unloading_date`, `collies`, `weight`, `volume`, `loading_meters`, `dimensions`, `package`, `originator_id`, `recipient_id`) VALUES
(2, '2021-11-05 11:23:29', '2021-11-05 17:36:24', 1, 'tousios@unit-hellas.gr', 'Green Cola Bulgaria SA ', 'Orestiada', 'GREEN COLA ELLAS A.E. LEPTI, EVROS coordinates:41.499036, 26.485630', '2021-11-08 00:00:00', 'Refreshments', 'Client', 1000, NULL, 0, NULL, '2021-11-09 00:00:00', NULL, NULL, 'Bid', NULL, 'Bucharest', 'ELGEKA FERFELIS DRUMUL ÃŽNTRE TARLALE 150-158 BUCURESTI 032982 ROMANIA Coordinates:44.411897, 26.217789', '2021-11-10 00:00:00', 30, 24000, 50, 13.6, '1.2X0.8X1.6', 'Pallets', 72, 68),
(4, '2021-11-08 08:08:17', '2021-11-09 09:04:28', 2, 'valentina.preda@rohel.ro', 'VIVRE DECO SA', 'ASPROPIRGOS', 'VAMVAX - Tzaverdella , -, 19300, Aspropyrgos, Greece,', '2021-11-08 00:00:00', 'DEOCRATIVE PRODUCTS', 'Client', 120, 78, 78, '2021-11-09 11:04:28', '2021-11-12 00:00:00', NULL, NULL, 'Confirmed', NULL, 'BUCHAREST', 'VIVRE - Soseaua Giurgiului 321, 040667, Bucuresti', '2021-11-12 00:00:00', 2, 240, 0, 0.8, '120*80', '', 64, 77),
(5, '2021-11-08 09:46:17', '2021-11-08 11:54:43', 2, 'valentina.preda@rohel.ro', 'VICTORIAN 128 EVENTS SRL ', 'SALONIC', 'ALEXANDROS ILIADIS SA - 7th km THESSALONIKI - LAGADA road, tel 0030 2310 685148', '2021-11-08 00:00:00', 'DEOCRATIVE PRODUCTS', 'Local', 160, 73, 0, '2021-11-08 13:54:43', '2021-11-08 00:00:00', NULL, NULL, 'Confirmed', NULL, 'CONSTANTA', 'VICTORIAN 128 EVENTS SRL , Strada Fagetului nr 40 A , CONSTANTA - 0722692552', '2021-11-12 00:00:00', 1, 104, 0, 0.4, '120*80*215', '', 64, 73),
(6, '2021-11-08 10:13:05', '2021-11-09 09:05:18', 2, 'gina.popescu@rohel.ro', 'BALDUR LIGHTING  SRL', 'KOROPI', 'VIOKEF NIKOLAOS TH. KAKKOS KOROPI 19400', '2021-11-08 00:00:00', '', 'Client', 0, 77, 77, '2021-11-09 11:05:18', '2021-11-15 00:00:00', NULL, NULL, 'Confirmed', NULL, 'Clinceni', 'BALDUR LIGHTING - DEPO ROHEL', '2021-11-12 00:00:00', 1, 11, 0.064, 0, ' 40*40*40', '', 66, 77),
(7, '2021-11-08 10:15:33', '2021-11-09 09:06:30', 2, 'gina.popescu@rohel.ro', 'BALDUR LIGHTING  SRL', 'ATHENS', 'BRIGHT SPECIAL LIGHTING ATHENS ', '2021-11-08 00:00:00', '', 'Depo', 0, 77, 77, '2021-11-09 11:06:30', '2021-11-15 00:00:00', NULL, NULL, 'Confirmed', NULL, 'Clinceni', 'BALDUR LIGHTING - DEPO ROHEL', '2021-11-12 00:00:00', 0, 0, 0, 0, '', '', 66, 77),
(9, '2021-11-08 12:32:49', NULL, 1, 'alina.ivascu@rohel.ro', 'DS Smith', 'Zarnesti', 'Zarnesti', '2021-11-09 00:00:00', '', 'Client', 0, NULL, 0, NULL, '2021-11-10 00:00:00', NULL, NULL, 'Bid', NULL, 'Inofita', 'Inofita', '2021-11-11 00:00:00', 0, 23000, 75, 13.6, '', '', 68, 64),
(10, '2021-11-08 12:47:05', '2021-11-09 09:00:58', 1, 'zahariou@unit-hellas.gr', 'TSACHAKIS BROS ', 'COMUNA BRADU', 'GF Casting Solutions S.R.L. ,Sat Geamana, Str. Drumul 23 Nr. 44 ,117141 Comuna Bradu (AG) ', '2021-11-10 00:00:00', 'PACKANGING MATERIAS', 'Local', 340, NULL, 0, NULL, '2021-11-16 00:00:00', NULL, NULL, 'Confirmed', NULL, '18233 RENTIS ', 'TSACHAKIS BROS , AGIAS LAURAS 12 PARDOS XATZIANESTI , RENTIS ', '2021-11-14 00:00:00', 3, 810, 4.608, 1.2, '1.2X0.8X1.6', 'PAL', 78, 65),
(13, '2021-11-09 08:42:52', '2021-11-09 09:07:00', 2, 'gina.popescu@rohel.ro', 'ALPHA MEDICAL', 'ATHENS', 'VIOBREATH OE, 405 VOULIAGMENIS ,16346', '2021-11-09 00:00:00', '', 'Client', 100, 77, 77, '2021-11-09 11:07:00', '2021-11-15 00:00:00', NULL, NULL, 'Confirmed', NULL, 'BUCHAREST', 'ALPHA MEDICAL BUCHAREST', '2021-11-12 00:00:00', 1, 3, 0, 0, '40*37*24', '', 66, 77),
(14, '2021-11-09 08:57:29', '2021-11-09 09:01:11', 1, 'zahariou@unit-hellas.gr', 'STEFMAR SA', 'MURES', 'Expert company group- Export Sales team,Ungheni 547, Judet Mures, Platform Nr 1, Hala-Blok C302,Tel: +40365807850605,Mob: +40724240979 Mr Stefan Domocos ', '2021-11-11 00:00:00', 'COMPUTER ITEMS ', 'Client', 520, NULL, 78, NULL, '2021-11-15 00:00:00', NULL, NULL, 'Confirmed', NULL, 'SPATA', 'RENEW COMPUTER COMPANY ,20KM SPATA AVENUE ,19004 SPATA', '2021-11-14 00:00:00', 5, 2000, 0, 2, '1.2X0.8X1.8 ', 'PAL', 78, 65);

-- --------------------------------------------------------

--
-- Table structure for table `cargo_settings`
--

CREATE TABLE `cargo_settings` (
  `operator` varchar(128) DEFAULT NULL,
  `SYS_CREATION_DATE` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `SYS_UPDATE_DATE` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `key` varchar(64) NOT NULL,
  `value` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cargo_settings`
--

INSERT INTO `cargo_settings` (`operator`, `SYS_CREATION_DATE`, `SYS_UPDATE_DATE`, `key`, `value`) VALUES
(NULL, '2021-10-17 08:48:16', '2021-11-09 09:41:53', 'changes', '0');

-- --------------------------------------------------------

--
-- Table structure for table `cargo_truck`
--

CREATE TABLE `cargo_truck` (
  `id` int(11) NOT NULL,
  `operator` varchar(128) DEFAULT NULL,
  `SYS_CREATION_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `SYS_UPDATE_DATE` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `originator_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `accepted_by` int(11) DEFAULT '0',
  `status_changed_by` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 = available, \r\n2 = free, \r\n3 = new, \r\n4 = partially solved, \r\n5 = fully solved, \r\n6 = cancelled',
  `from_city` varchar(128) DEFAULT NULL,
  `from_address` varchar(256) DEFAULT NULL,
  `freight` float DEFAULT NULL,
  `availability` datetime DEFAULT NULL,
  `acceptance` datetime DEFAULT NULL,
  `expiration` datetime DEFAULT NULL,
  `details` varchar(512) DEFAULT NULL,
  `plate_number` varchar(64) DEFAULT NULL,
  `ameta` varchar(64) DEFAULT NULL,
  `cargo_type` varchar(64) DEFAULT NULL,
  `contract_type` varchar(64) DEFAULT NULL,
  `truck_type` varchar(64) DEFAULT NULL,
  `loading_date` datetime DEFAULT NULL,
  `unloading_date` datetime DEFAULT NULL,
  `adr` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cargo_truck`
--

INSERT INTO `cargo_truck` (`id`, `operator`, `SYS_CREATION_DATE`, `SYS_UPDATE_DATE`, `originator_id`, `recipient_id`, `accepted_by`, `status_changed_by`, `status`, `from_city`, `from_address`, `freight`, `availability`, `acceptance`, `expiration`, `details`, `plate_number`, `ameta`, `cargo_type`, `contract_type`, `truck_type`, `loading_date`, `unloading_date`, `adr`) VALUES
(3, 'valentina.preda@rohel.ro', '2021-11-05 10:37:51', NULL, 64, 76, 0, 0, 1, 'BUCHAREST', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'PETRIS FLORIN', 'TR05XFP/TR08XFP', 'IRO2111025', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(5, 'alina.ivascu@rohel.ro', '2021-11-05 10:50:14', NULL, 68, 76, 0, 0, 1, 'Urlati', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Bratut Adrian,+40 765 440 991', 'B500BAG/B600BAG', 'IRO2111512', NULL, 'Round-trip', NULL, '2021-11-04 00:00:00', '2021-11-08 00:00:00', 'yes'),
(6, 'alina.ivascu@rohel.ro', '2021-11-05 10:53:03', NULL, 68, 76, 0, 0, 1, 'Oradea', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Georgescu Marius, +40 755 309 934', 'A94GMA/AG49GMA', 'IRO2111524', NULL, 'Round-trip', NULL, '2021-11-04 00:00:00', '2021-11-08 00:00:00', NULL),
(7, 'alina.ivascu@rohel.ro', '2021-11-05 10:55:18', NULL, 68, 76, 0, 0, 1, 'Bucuresti', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Saru', 'B300SCM/CV07BED', 'IRO2111527', NULL, 'Round-trip', NULL, '2021-11-03 00:00:00', '2021-11-08 00:00:00', NULL),
(8, 'adriana.goaga@rohel.ro', '2021-11-05 10:59:03', NULL, 69, 76, 0, 0, 1, 'zarnesti', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Mihai Doroftei ; +40 754 539 808', 'AG92DBY/AG99DBY', 'IRO2111555', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', 'yes'),
(9, 'alina.ivascu@rohel.ro', '2021-11-05 10:59:58', NULL, 68, 76, 0, 0, 1, 'Bucuresti', '', 1, NULL, NULL, '1970-01-01 02:00:00', '-', 'B450PGT/B451PGT', 'IRO2111530', NULL, 'Round-trip', NULL, '2021-11-03 00:00:00', '2021-11-08 00:00:00', NULL),
(10, 'adriana.goaga@rohel.ro', '2021-11-05 11:01:22', NULL, 69, 76, 0, 0, 1, 'BUCURESTI', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'SARU VALENTIN; 0741274441', 'AG15SCV/B24SPB', 'IRO2111546', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(11, 'alina.ivascu@rohel.ro', '2021-11-05 11:02:11', NULL, 68, 76, 0, 0, 1, 'Bucuresti', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Nenciu Mihai', 'AG99GMA/AG99GMC', 'IRO2111015', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-09 00:00:00', 'YES'),
(12, 'adriana.goaga@rohel.ro', '2021-11-05 11:03:12', NULL, 69, 76, 0, 0, 1, 'ZARNESTI', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'GEORGESCU AUREL; +40 748 011 418', 'AG95GMA/B394GMA', 'IRO2111542', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', 'yes'),
(13, 'alina.ivascu@rohel.ro', '2021-11-05 11:03:43', NULL, 68, 76, 0, 0, 1, 'Zarnesti', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Cutoiu Marius, +40 732 428 474', 'DB77EVY/DB05CTF', 'IRO2111534', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(14, 'alina.ivascu@rohel.ro', '2021-11-05 11:05:06', NULL, 68, 76, 0, 0, 1, 'Slatina', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Dinu Elvis', 'VL 43 MRD/VL 34 MRD', 'IRO2111551', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(15, 'adriana.goaga@rohel.ro', '2021-11-05 11:05:16', NULL, 69, 76, 0, 0, 1, 'URLATI', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Dimineata Anton; +40 757 657 920', 'BZ16LRT/BZ20LRT', 'IRO2111541', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-09 00:00:00', NULL),
(16, 'alina.ivascu@rohel.ro', '2021-11-05 11:06:19', NULL, 68, 76, 0, 0, 1, 'Turceni', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Patrascoiu Ion', 'GJ66XXL/GJ68XXL', 'IRO2110760', NULL, 'Round-trip', NULL, '2021-11-03 00:00:00', '2021-11-08 00:00:00', 'yes'),
(17, 'adriana.goaga@rohel.ro', '2021-11-05 11:07:49', NULL, 69, 76, 0, 0, 1, 'BUCURESTI', '', 1, NULL, NULL, '1970-01-01 02:00:00', '-', 'TR36PRO/TR38PRO', 'IRO2111016', NULL, 'Round-trip', NULL, '2021-11-04 00:00:00', '2021-11-08 00:00:00', NULL),
(18, 'alina.ivascu@rohel.ro', '2021-11-05 11:07:54', NULL, 68, 76, 0, 0, 1, 'Zarnesti', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Cioaga Laurentiu, 0749175604', 'B540BAG/B550BAG', 'IRO2111553', NULL, 'Round-trip', NULL, '2021-11-08 00:00:00', '2021-11-10 00:00:00', NULL),
(19, 'alina.ivascu@rohel.ro', '2021-11-05 11:09:15', '2021-11-09 08:15:32', 68, 72, 0, 0, 1, 'Giurgiu', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Paun Adrian', 'DB 72 PGS/AG 80 PGS', 'IRO2111558', NULL, 'Round-trip', NULL, '2021-11-08 00:00:00', '2021-11-09 00:00:00', NULL),
(20, 'adriana.goaga@rohel.ro', '2021-11-05 11:09:28', NULL, 69, 76, 0, 0, 1, 'ZARNESTI', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'NEAGU CIPRIAN', 'PH23RCC/PH12RCC', 'IRO2111560', NULL, 'Round-trip', NULL, '2021-11-08 00:00:00', '2021-11-10 00:00:00', 'yes'),
(21, 'adriana.goaga@rohel.ro', '2021-11-05 11:27:58', NULL, 69, 72, 0, 0, 1, 'GIURGIU', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'GIGI GOLICI ; +40 735 576 350', 'IF07BYS/IF06BYS', 'IRO2111562', NULL, 'Round-trip', NULL, '2021-11-09 00:00:00', '2021-11-10 00:00:00', NULL),
(22, 'valentina.preda@rohel.ro', '2021-11-05 13:32:22', '2021-11-05 14:35:18', 64, 76, 0, 0, 6, 'BUCHAREST', '', 1025, NULL, NULL, '1970-01-01 02:00:00', '+40 751 420 150', 'AG99GMA/AG99GMC', 'IRO2111015', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-09 00:00:00', NULL),
(23, 'valentina.preda@rohel.ro', '2021-11-05 13:33:30', NULL, 64, 76, 0, 0, 1, 'BUCHAREST', '', 1025, NULL, NULL, '1970-01-01 02:00:00', '+40 751 420 150', 'AG99GMA/AG99GMC', 'IRO2111015', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-09 00:00:00', NULL),
(24, 'valentina.preda@rohel.ro', '2021-11-05 13:34:35', NULL, 64, 76, 0, 0, 1, 'BUCHAREST', '', 1025, NULL, NULL, '1970-01-01 02:00:00', 'Nicolae Pavel', 'TR36PRO/TR38PRO', 'IRO2111016', NULL, 'Round-trip', NULL, '2021-11-04 00:00:00', '2021-11-08 00:00:00', NULL),
(25, 'valentina.preda@rohel.ro', '2021-11-05 13:35:57', '2021-11-08 07:54:35', 64, 76, 0, 0, 1, 'BUCHAREST', '', 1025, NULL, NULL, '1970-01-01 02:00:00', 'VELEA ION  0744345428', 'B801CRS/B802CRS', 'IRO2111017', NULL, 'Round-trip', NULL, '2021-11-06 00:00:00', '2021-11-09 00:00:00', NULL),
(26, 'valentina.preda@rohel.ro', '2021-11-05 13:39:13', NULL, 64, 76, 0, 0, 2, 'MEDIAS', '', 1300, NULL, NULL, '1970-01-01 02:00:00', 'BLINDU VICTOR  0754455163', 'GJ25MIT/GJ55MIT', 'IRO2111018', NULL, 'One-way', NULL, '2021-11-05 00:00:00', '2021-11-09 00:00:00', NULL),
(27, 'valentina.preda@rohel.ro', '2021-11-05 13:39:20', NULL, 64, 76, 0, 0, 2, 'MEDIAS', '', 1300, NULL, NULL, '1970-01-01 02:00:00', 'BLINDU VICTOR  0754455163', 'GJ25MIT/GJ55MIT', 'IRO2111018', NULL, 'One-way', NULL, '2021-11-05 00:00:00', '2021-11-09 00:00:00', NULL),
(28, 'valentina.preda@rohel.ro', '2021-11-05 13:40:25', NULL, 64, 76, 0, 0, 2, 'MEDIAS', '', 1300, NULL, NULL, '1970-01-01 02:00:00', 'BLINDU VICTOR  0754455163', 'GJ25MIT/GJ55MIT', 'IRO2111018', NULL, 'One-way', NULL, '2021-11-05 00:00:00', '2021-11-09 00:00:00', NULL),
(29, 'valentina.preda@rohel.ro', '2021-11-05 13:40:34', NULL, 64, 76, 0, 0, 2, 'MEDIAS', '', 1300, NULL, NULL, '1970-01-01 02:00:00', 'BLINDU VICTOR  0754455163', 'GJ25MIT/GJ55MIT', 'IRO2111018', NULL, 'One-way', NULL, '2021-11-05 00:00:00', '2021-11-09 00:00:00', NULL),
(30, 'valentina.preda@rohel.ro', '2021-11-05 13:44:37', NULL, 64, 76, 0, 0, 1, 'BUCHAREST', '', 1190, NULL, NULL, '1970-01-01 02:00:00', 'PETRIS FLORIN  723309005', 'TR05XFP/TR08XFP', 'IRO2111025', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(31, 'valentina.preda@rohel.ro', '2021-11-05 13:45:06', NULL, 64, 76, 0, 0, 1, 'BUCHAREST', '', 1190, NULL, NULL, '1970-01-01 02:00:00', 'PETRIS FLORIN  723309005', 'TR05XFP/TR08XFP', 'IRO2111025', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(32, 'valentina.preda@rohel.ro', '2021-11-05 13:48:17', '2021-11-05 14:27:28', 64, 76, 0, 0, 1, 'BUCHAREST', '', 1190, NULL, NULL, '1970-01-01 02:00:00', 'PETRIS FLORIN  723309005', 'TR05XFP/TR08XFP', 'IRO2111025', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(33, 'valentina.preda@rohel.ro', '2021-11-05 14:14:11', NULL, 64, 76, 0, 0, 1, 'BUCHAREST', '', 1130, NULL, NULL, '1970-01-01 02:00:00', 'UTA FLORIN  766710272', 'IF05MBC/B108CUO', 'IRO2111027', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(34, 'valentina.preda@rohel.ro', '2021-11-05 14:17:11', NULL, 64, 76, 0, 0, 1, 'BUCHAREST', '', 1190, NULL, NULL, '1970-01-01 02:00:00', 'BULUMAC MARIAN 0721557328', 'IF50LDT/IF77LDT', 'IRO2111024', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(35, 'valentina.preda@rohel.ro', '2021-11-05 14:20:54', NULL, 64, 76, 0, 0, 1, 'BUCHAREST', '', 1160, NULL, NULL, '1970-01-01 02:00:00', 'ALIMAN GHEORGHE 728374556', 'IF60NMS/IF61NMS', 'IRO2111028', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(36, 'valentina.preda@rohel.ro', '2021-11-05 14:26:42', '2021-11-05 14:27:06', 64, 76, 0, 0, 1, 'BUCHAREST', '', 1110, NULL, NULL, '1970-01-01 02:00:00', 'NITU MIHAI 757010115', 'IF85NMS/IF69NMS', 'IRO2111029', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(37, 'valentina.preda@rohel.ro', '2021-11-05 14:35:39', NULL, 64, 76, 0, 0, 1, 'PLOIESTI', '', 1160, NULL, NULL, '1970-01-01 02:00:00', 'MIHAI IONEL 722256984', 'B67GOT/B65GOT', 'IRO2111012', NULL, 'Round-trip', NULL, '2021-11-04 00:00:00', '2021-11-08 00:00:00', NULL),
(38, 'valentina.preda@rohel.ro', '2021-11-05 14:37:42', NULL, 64, 76, 0, 0, 2, 'MEDIAS', '', 1300, NULL, NULL, '1970-01-01 02:00:00', 'BLINDU VICTOR  0754455163', 'GJ25MIT/GJ55MIT', 'IRO2111018', NULL, 'One-way', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(39, 'valentina.preda@rohel.ro', '2021-11-05 14:52:30', '2021-11-08 11:17:49', 64, 76, 0, 0, 1, 'BUCHAREST', '', 1110, NULL, NULL, '1970-01-01 02:00:00', 'LIXANDRU 0734198664', 'DB84EMY/DB85EMY', 'IRO2111026', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(40, 'valentina.preda@rohel.ro', '2021-11-05 15:01:32', NULL, 64, 74, 0, 0, 1, 'BUCHAREST', '', 660, NULL, NULL, '1970-01-01 02:00:00', 'VADUVA STELIAN 720048316', 'IF02ATE/IF11ATE', 'IRO2111030', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(41, 'valentina.preda@rohel.ro', '2021-11-05 15:21:26', '2021-11-09 09:21:48', 64, 74, 0, 74, 5, 'BUCHAREST', '', 600, NULL, NULL, '1970-01-01 02:00:00', 'DRAGOMIR MARIN 0744329019', 'B24XIE/B80YAJ', 'IRO2111032', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(42, 'valentina.preda@rohel.ro', '2021-11-08 07:58:38', NULL, 64, 76, 0, 0, 2, 'SIGHISOARA', '', 1200, NULL, NULL, '1970-01-01 02:00:00', 'MARTOIU CONSTANTIN â€“0748456352', 'GJ26MIT/B79UUI', 'IRO2111034', NULL, 'One-way', NULL, '2021-11-08 00:00:00', '2021-11-10 00:00:00', NULL),
(43, 'valentina.preda@rohel.ro', '2021-11-08 08:01:43', NULL, 64, 74, 0, 0, 1, 'BUCHAREST', '', 630, NULL, NULL, '1970-01-01 02:00:00', 'MIHALEA CORNEL 0722627718', 'B930STC/B929STC', 'IRO2111033', NULL, 'Round-trip', NULL, '2021-11-08 00:00:00', '2021-11-10 00:00:00', NULL),
(44, 'alina.ivascu@rohel.ro', '2021-11-08 09:16:05', NULL, 68, 76, 0, 0, 1, 'Zarnesti', '', 1, NULL, NULL, '1970-01-01 02:00:00', '-', 'VL44TEA/VL82TEA', 'ERO2111570', NULL, 'Round-trip', NULL, '2021-11-09 00:00:00', '2021-11-11 00:00:00', NULL),
(47, 'adriana.goaga@rohel.ro', '2021-11-08 13:20:56', NULL, 69, 76, 0, 0, 1, 'SLOBOZIA', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'PAVEL CATALIN; +40 726 819 663', 'DB82 PAV/DB 08 PAV', 'IRO2111574', NULL, 'Round-trip', NULL, '2021-11-09 00:00:00', '2021-11-11 00:00:00', NULL),
(48, 'adriana.goaga@rohel.ro', '2021-11-08 14:44:46', NULL, 69, 72, 0, 0, 1, 'ZARNESTI', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'ANDREI GABRIEL +40 741 604 737', 'AG06TZU/AG07TZU', 'IRO2111576', NULL, 'Round-trip', NULL, '2021-11-09 00:00:00', '2021-11-11 00:00:00', NULL),
(49, 'adriana.goaga@rohel.ro', '2021-11-09 08:51:10', NULL, 69, 76, 0, 69, 1, 'SLATINA', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'COJOCARELU GHEORGHE', 'DB57ADL/DB12GOU', 'IRO2111578', NULL, 'Round-trip', NULL, '2021-11-09 00:00:00', '2021-11-11 00:00:00', NULL),
(50, 'papadakis@unit-hellas.gr', '2021-11-09 09:38:01', NULL, 74, 64, 0, 74, 1, 'THESSALONIKI', '', 960, NULL, NULL, '1970-01-01 02:00:00', 'DRAGOMIR MARIN', 'B24XIE/B80YAJ', 'ERO2111032', NULL, 'Round-trip', NULL, '2021-11-10 00:00:00', '2021-11-11 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cargo_truck_comments`
--

CREATE TABLE `cargo_truck_comments` (
  `id` int(11) NOT NULL,
  `operator` varchar(128) DEFAULT NULL,
  `SYS_CREATION_DATE` timestamp NULL DEFAULT NULL,
  `SYS_UPDATE_DATE` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `truck_id` int(11) NOT NULL DEFAULT '0',
  `comment` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cargo_truck_stops`
--

CREATE TABLE `cargo_truck_stops` (
  `id` int(11) NOT NULL,
  `operator` varchar(128) DEFAULT NULL,
  `SYS_CREATION_DATE` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `SYS_UPDATE_DATE` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `truck_id` int(11) NOT NULL DEFAULT '0',
  `stop_id` int(11) NOT NULL DEFAULT '0',
  `city` varchar(128) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `cmr` int(11) DEFAULT '0',
  `loading_meters` float NOT NULL DEFAULT '0',
  `volume` float NOT NULL DEFAULT '0',
  `weight` float NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cargo_truck_stops`
--

INSERT INTO `cargo_truck_stops` (`id`, `operator`, `SYS_CREATION_DATE`, `SYS_UPDATE_DATE`, `truck_id`, `stop_id`, `city`, `address`, `cmr`, `loading_meters`, `volume`, `weight`) VALUES
(3, 'valentina.preda@rohel.ro', '2021-11-05 10:37:51', NULL, 3, 0, 'ASPROPIRGOS', '', 0, 2.8, 0, 1800),
(6, 'valentina.preda@rohel.ro', '2021-11-05 10:39:02', NULL, 3, 1, 'KOROPI', '', 1, 7.9, 0, 12400),
(7, 'alina.ivascu@rohel.ro', '2021-11-05 10:50:14', NULL, 5, 0, 'Aspropirgos', '', 0, 0, 75, 23000),
(8, 'alina.ivascu@rohel.ro', '2021-11-05 10:53:03', NULL, 6, 0, 'Atena', '', 0, 0, 75, 23000),
(9, 'alina.ivascu@rohel.ro', '2021-11-05 10:55:19', NULL, 7, 0, 'Atena', '', 0, 0, 75, 23000),
(10, 'adriana.goaga@rohel.ro', '2021-11-05 10:59:03', NULL, 8, 0, 'corinth', '', 0, 0, 75, 23),
(11, 'alina.ivascu@rohel.ro', '2021-11-05 10:59:58', NULL, 9, 0, 'Atena', '', 0, 0, 75, 230000),
(12, 'adriana.goaga@rohel.ro', '2021-11-05 11:01:22', NULL, 10, 0, 'CORINTH', '', 0, 0, 75, 23),
(13, 'alina.ivascu@rohel.ro', '2021-11-05 11:02:12', NULL, 11, 0, 'Atena', '', 0, 0, 75, 23000),
(14, 'adriana.goaga@rohel.ro', '2021-11-05 11:03:12', NULL, 12, 0, 'SCHIMATARI', '', 0, 0, 75, 23),
(15, 'alina.ivascu@rohel.ro', '2021-11-05 11:03:43', NULL, 13, 0, 'Schimatari ', '', 0, 0, 75, 23000),
(16, 'alina.ivascu@rohel.ro', '2021-11-05 11:05:06', NULL, 14, 0, 'Thiva', '', 0, 0, 75, 23000),
(17, 'adriana.goaga@rohel.ro', '2021-11-05 11:05:16', NULL, 15, 0, 'ASPROPIRGOS', '', 0, 0, 75, 23),
(18, 'alina.ivascu@rohel.ro', '2021-11-05 11:06:19', NULL, 16, 0, 'Inofita', '', 0, 0, 75, 23000),
(19, 'adriana.goaga@rohel.ro', '2021-11-05 11:07:49', NULL, 17, 0, 'ATENA', '', 0, 0, 75, 23),
(20, 'alina.ivascu@rohel.ro', '2021-11-05 11:07:54', NULL, 18, 0, 'Corinth', '', 0, 0, 75, 23000),
(21, 'alina.ivascu@rohel.ro', '2021-11-05 11:09:15', NULL, 19, 0, 'kilkis', '', 0, 0, 75, 23000),
(22, 'adriana.goaga@rohel.ro', '2021-11-05 11:09:28', NULL, 20, 0, 'SCHIMATARI', '', 0, 0, 75, 23),
(23, 'adriana.goaga@rohel.ro', '2021-11-05 11:27:58', NULL, 21, 0, 'KILKIS', '', 0, 0, 75, 23),
(24, 'valentina.preda@rohel.ro', '2021-11-05 13:32:22', NULL, 22, 0, 'MANDTA', '', 0, 13.6, 80, 20000),
(25, 'valentina.preda@rohel.ro', '2021-11-05 13:33:30', NULL, 23, 0, 'MANDRA', '', 0, 13.6, 80, 20000),
(26, 'valentina.preda@rohel.ro', '2021-11-05 13:34:35', NULL, 24, 0, 'MANDRA', '', 0, 13.6, 80, 20000),
(27, 'valentina.preda@rohel.ro', '2021-11-05 13:35:57', NULL, 25, 0, 'MANDRA', '', 0, 13.6, 80, 20000),
(28, 'valentina.preda@rohel.ro', '2021-11-05 13:48:17', NULL, 32, 0, 'ASPROPIRGOS', 'kamposos', 0, 2.2, 0, 134.2),
(29, 'valentina.preda@rohel.ro', '2021-11-05 13:48:17', NULL, 32, 1, 'ASPROPIRGOS', '', 0, 2.8, 0, 1630),
(30, 'valentina.preda@rohel.ro', '2021-11-05 13:48:17', NULL, 32, 2, 'KOROPI', '', 0, 8.7, 0, 13500),
(31, 'valentina.preda@rohel.ro', '2021-11-05 14:14:11', NULL, 33, 0, 'ASPROPIRGOS', '', 0, 7.4, 0, 6700),
(32, 'valentina.preda@rohel.ro', '2021-11-05 14:14:11', NULL, 33, 1, 'KOROPI', '', 0, 6, 0, 15570),
(33, 'valentina.preda@rohel.ro', '2021-11-05 14:17:11', NULL, 34, 0, 'KOROPI', '', 0, 9.9, 0, 1000),
(34, 'valentina.preda@rohel.ro', '2021-11-05 14:17:11', NULL, 34, 1, 'ACHARNES', '', 0, 2.4, 0, 2618),
(35, 'valentina.preda@rohel.ro', '2021-11-05 14:17:11', NULL, 34, 2, 'RENTIS', '', 0, 2, 0, 3000),
(36, 'valentina.preda@rohel.ro', '2021-11-05 14:20:54', NULL, 35, 0, 'KOROPI', '', 0, 8, 0, 0),
(37, 'valentina.preda@rohel.ro', '2021-11-05 14:20:54', NULL, 35, 1, 'ASPROPIRGOS', '', 0, 2, 0, 4200),
(38, 'valentina.preda@rohel.ro', '2021-11-05 14:26:42', NULL, 36, 0, 'KOLONOS', '', 0, 8, 0, 0),
(39, 'valentina.preda@rohel.ro', '2021-11-05 14:26:42', NULL, 36, 1, 'ASPROPIRGOS', '', 0, 2.4, 0, 0),
(40, 'valentina.preda@rohel.ro', '2021-11-05 14:26:42', NULL, 36, 2, 'VOTANIKOS', '', 0, 2, 0, 4500),
(41, 'valentina.preda@rohel.ro', '2021-11-05 14:35:39', NULL, 37, 0, 'SCHIMATARI', '', 0, 6, 0, 6000),
(42, 'valentina.preda@rohel.ro', '2021-11-05 14:35:39', NULL, 37, 1, 'ATENA', '', 0, 7.2, 0, 4007),
(43, 'valentina.preda@rohel.ro', '2021-11-05 14:37:43', NULL, 38, 0, 'SALONIC', '', 0, 0.8, 0, 0),
(44, 'valentina.preda@rohel.ro', '2021-11-05 14:37:43', NULL, 38, 1, 'ATENA', '', 0, 12.4, 0, 0),
(45, 'valentina.preda@rohel.ro', '2021-11-05 14:52:30', NULL, 39, 0, 'ALMYRO', '', 0, 6.6, 0, 11000),
(46, 'valentina.preda@rohel.ro', '2021-11-05 14:52:30', NULL, 39, 1, 'ASPROPIRGOS', '', 0, 6.8, 0, 5153),
(47, 'valentina.preda@rohel.ro', '2021-11-05 15:01:32', NULL, 40, 0, 'SALONIC', '', 0, 4.8, 0, 0),
(48, 'valentina.preda@rohel.ro', '2021-11-05 15:01:32', NULL, 40, 1, 'SALONIC', '', 0, 13, 0, 0),
(49, 'valentina.preda@rohel.ro', '2021-11-05 15:21:26', NULL, 41, 0, 'SALONIC', '', 0, 13.6, 0, 0),
(50, 'valentina.preda@rohel.ro', '2021-11-08 07:58:38', NULL, 42, 0, 'ASPROPIRGOS', '', 0, 13.6, 80, 20000),
(51, 'valentina.preda@rohel.ro', '2021-11-08 08:01:43', NULL, 43, 0, 'RUSE', '', 0, 0, 0, 0),
(52, 'valentina.preda@rohel.ro', '2021-11-08 08:01:43', NULL, 43, 1, 'SALONIC', '', 0, 0, 0, 0),
(53, 'alina.ivascu@rohel.ro', '2021-11-08 09:16:05', NULL, 44, 0, 'Schimatari ', '', 0, 13.6, 75, 23000),
(55, 'adriana.goaga@rohel.ro', '2021-11-08 13:20:56', NULL, 47, 0, 'PELLA', '', 0, 7, 0, 10000),
(56, 'adriana.goaga@rohel.ro', '2021-11-08 13:20:56', NULL, 47, 1, 'MEGARA', '', 0, 6.6, 0, 12000),
(57, 'adriana.goaga@rohel.ro', '2021-11-08 14:44:46', NULL, 48, 0, 'LARISSA', '', 0, 13.6, 0, 23),
(58, 'adriana.goaga@rohel.ro', '2021-11-09 08:51:10', NULL, 49, 0, 'ATENA', '', 0, 13.6, 0, 23),
(59, 'papadakis@unit-hellas.gr', '2021-11-09 09:38:01', NULL, 50, 0, 'CRAIOVA', '', 0, 11.2, 50, 3000),
(60, 'papadakis@unit-hellas.gr', '2021-11-09 09:38:01', NULL, 50, 1, 'BUCHAREST', '', 0, 2.4, 10, 2000);

-- --------------------------------------------------------

--
-- Table structure for table `cargo_users`
--

CREATE TABLE `cargo_users` (
  `id` int(11) NOT NULL,
  `SYS_CREATION_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `SYS_UPDATE_DATE` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `username` varchar(128) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `class` int(11) NOT NULL DEFAULT '1' COMMENT '0=admin, 1=regular, 2=debug, 3=deleted',
  `office_id` int(11) NOT NULL DEFAULT '1',
  `insert` int(11) NOT NULL DEFAULT '1',
  `reports` int(11) NOT NULL DEFAULT '0',
  `reset_key` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cargo_users`
--

INSERT INTO `cargo_users` (`id`, `SYS_CREATION_DATE`, `SYS_UPDATE_DATE`, `username`, `name`, `password`, `class`, `office_id`, `insert`, `reports`, `reset_key`) VALUES
(1, '2021-10-13 09:01:25', NULL, 'jo.ioana.pavel@gmail.com', 'Ioana', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 3, 1, 1, NULL),
(2, '2015-06-29 14:28:43', '2021-11-08 16:31:08', 'cristian.ungureanu@gmail.com', 'Cristian', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 4, 1, 1, '848d40e6a03d6b9ed8b9dfa5c3977d1891476f6734311a3155d828d77c0d7404'),
(64, '2021-10-19 13:57:52', NULL, 'valentina.preda@rohel.ro', 'Valentina', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 1, 1, 1, NULL),
(65, '2021-10-19 13:58:18', NULL, 'ramona.caciulita@rohel.ro', 'Ramona', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 1, 1, 1, NULL),
(66, '2021-10-19 13:58:36', NULL, 'gina.popescu@rohel.ro', 'Gina', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 1, 1, 1, NULL),
(67, '2021-10-19 13:58:54', NULL, 'razvan.mira@rohel.ro', 'Razvan', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 1, 1, 1, NULL),
(68, '2021-10-19 13:59:28', NULL, 'alina.ivascu@rohel.ro', 'Alina', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 3, 1, 1, NULL),
(69, '2021-10-19 13:59:46', NULL, 'adriana.goaga@rohel.ro', 'Adriana', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 3, 1, 1, NULL),
(70, '2021-10-19 14:00:15', NULL, 'cristina.tamas@rohel.ro', 'Cristina', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 2, 1, 1, NULL),
(71, '2021-10-19 14:00:34', NULL, 'erika.hiri@rohel.ro', 'Erika', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 2, 1, 1, NULL),
(72, '2021-10-19 14:01:11', '2021-11-08 11:25:12', 'tousios@unit-hellas.gr', 'Mihalis', '6276c948e1863518ab77a77e4415098a73b75d7867fc2961a2bdf5a48f18ff19', 1, 5, 1, 1, NULL),
(73, '2021-10-19 14:01:29', '2021-11-08 11:40:02', 'maniaka@unit-hellas.gr', 'Dimitra', '1889053df391034d18cd9132b11a5e9f456aae1210cb3aa19c0a2a35088537cd', 1, 5, 1, 1, NULL),
(74, '2021-10-19 14:01:49', NULL, 'papadakis@unit-hellas.gr', 'Oreste', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 5, 1, 1, NULL),
(75, '2021-10-19 14:02:16', '2021-11-08 11:59:35', 'markousov@unit-hellas.gr', 'Stergios', '2243ffb083547e438bcc13b64b0318d82d421e666b1aa5cb42e1fe60a74c15ca', 1, 5, 1, 1, NULL),
(76, '2021-10-19 14:02:45', NULL, 'cvezasi@unit-hellas.gr', 'Camelia', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 4, 1, 1, NULL),
(77, '2021-10-19 14:03:17', NULL, 'manou@unit-hellas.gr', 'Manou', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 4, 1, 1, NULL),
(78, '2021-10-19 14:03:37', '2021-11-08 12:50:44', 'zahariou@unit-hellas.gr', 'Irini', '52329fe80607fc9f5880ecbb829678e9e769752ef2dfcde2e7d654ff8a8cdf0c', 1, 4, 1, 1, NULL),
(79, '2021-10-21 09:30:03', NULL, 'gheorghe.patrascu@rohel.ro', 'Gheorghe', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 1, 1, 1, NULL),
(80, '2021-11-04 16:24:41', NULL, 'grecia@rohel.ro', 'Grecia', NULL, 1, 1, 0, 0, NULL),
(81, '2021-11-05 13:19:48', NULL, 'adrian.bilbie@rohel.ro', 'Adrian', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 1, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cargo_user_audit`
--

CREATE TABLE `cargo_user_audit` (
  `id` int(11) NOT NULL,
  `SYS_CREATION_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `SYS_UPDATE_DATE` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `OPERATOR_ID` int(11) NOT NULL,
  `IP` varchar(45) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cargo_user_audit`
--

INSERT INTO `cargo_user_audit` (`id`, `SYS_CREATION_DATE`, `SYS_UPDATE_DATE`, `OPERATOR_ID`, `IP`) VALUES
(1, '2021-11-04 16:31:17', NULL, 76, '188.27.125.94'),
(2, '2021-11-05 06:53:53', NULL, 66, '5.12.250.18'),
(3, '2021-11-05 08:31:29', NULL, 79, '212.146.100.194'),
(4, '2021-11-05 10:28:07', NULL, 1, '188.27.125.94'),
(5, '2021-11-05 10:29:15', NULL, 2, '188.27.125.94'),
(6, '2021-11-05 10:29:50', NULL, 64, '212.146.100.194'),
(7, '2021-11-05 10:33:00', NULL, 68, '212.146.100.194'),
(8, '2021-11-05 10:36:49', NULL, 64, '188.27.125.94'),
(9, '2021-11-05 10:51:19', NULL, 69, '212.146.100.194'),
(10, '2021-11-05 10:53:35', NULL, 79, '212.146.100.194'),
(11, '2021-11-05 11:01:27', NULL, 76, '195.46.23.115'),
(12, '2021-11-05 11:08:05', NULL, 78, '195.46.23.115'),
(13, '2021-11-05 11:10:03', NULL, 72, '62.74.160.130'),
(14, '2021-11-05 11:58:43', NULL, 79, '212.146.100.194'),
(15, '2021-11-05 13:07:49', NULL, 79, '212.146.100.194'),
(16, '2021-11-05 13:09:48', NULL, 69, '212.146.100.194'),
(17, '2021-11-05 13:14:13', NULL, 1, '188.27.125.94'),
(18, '2021-11-05 13:14:57', NULL, 1, '188.27.125.94'),
(19, '2021-11-05 13:20:17', NULL, 2, '188.27.125.94'),
(20, '2021-11-05 13:20:32', NULL, 81, '188.27.125.94'),
(21, '2021-11-05 13:23:06', NULL, 81, '188.27.125.94'),
(22, '2021-11-05 13:24:03', NULL, 79, '212.146.100.194'),
(23, '2021-11-05 13:29:43', NULL, 64, '212.146.100.194'),
(24, '2021-11-05 13:34:19', NULL, 81, '212.146.100.194'),
(25, '2021-11-05 13:35:10', NULL, 79, '212.146.100.194'),
(26, '2021-11-05 13:39:32', NULL, 64, '212.146.100.194'),
(27, '2021-11-05 13:40:46', NULL, 64, '212.146.100.194'),
(28, '2021-11-05 13:45:23', NULL, 64, '212.146.100.194'),
(29, '2021-11-05 13:50:30', NULL, 81, '212.146.100.194'),
(30, '2021-11-05 13:50:54', NULL, 81, '212.146.100.194'),
(31, '2021-11-05 14:17:42', NULL, 2, '188.27.125.94'),
(32, '2021-11-05 14:17:47', NULL, 2, '188.27.125.94'),
(33, '2021-11-05 14:30:03', NULL, 64, '188.27.125.94'),
(34, '2021-11-05 17:30:05', NULL, 2, '188.27.125.94'),
(35, '2021-11-06 11:26:45', NULL, 2, '188.27.125.94'),
(36, '2021-11-06 12:03:17', NULL, 2, '188.27.125.94'),
(37, '2021-11-06 13:12:35', NULL, 2, '188.27.125.94'),
(38, '2021-11-06 13:24:05', NULL, 2, '188.27.125.94'),
(39, '2021-11-07 10:34:12', NULL, 2, '188.27.125.94'),
(40, '2021-11-07 10:34:23', NULL, 2, '188.27.125.94'),
(41, '2021-11-07 11:03:09', NULL, 2, '188.27.125.94'),
(42, '2021-11-07 11:03:19', NULL, 2, '188.27.125.94'),
(43, '2021-11-07 11:20:40', NULL, 2, '188.27.125.94'),
(44, '2021-11-08 07:44:21', NULL, 1, '188.27.125.94'),
(45, '2021-11-08 07:47:36', NULL, 2, '188.27.125.94'),
(46, '2021-11-08 07:53:09', NULL, 73, '62.74.160.130'),
(47, '2021-11-08 07:53:16', NULL, 64, '212.146.100.194'),
(48, '2021-11-08 07:53:48', NULL, 64, '212.146.100.194'),
(49, '2021-11-08 07:59:57', NULL, 64, '212.146.100.194'),
(50, '2021-11-08 08:03:46', NULL, 66, '212.146.100.194'),
(51, '2021-11-08 08:17:14', NULL, 77, '195.46.23.115'),
(52, '2021-11-08 08:18:16', NULL, 72, '62.74.160.130'),
(53, '2021-11-08 08:20:06', NULL, 72, '62.74.160.130'),
(54, '2021-11-08 08:23:03', NULL, 72, '62.74.160.130'),
(55, '2021-11-08 08:27:32', NULL, 2, '188.27.125.94'),
(56, '2021-11-08 08:31:44', NULL, 72, '62.74.160.130'),
(57, '2021-11-08 08:34:35', NULL, 68, '212.146.100.194'),
(58, '2021-11-08 09:20:30', NULL, 1, '188.27.125.94'),
(59, '2021-11-08 09:21:50', NULL, 1, '188.27.125.94'),
(60, '2021-11-08 09:23:58', NULL, 74, '62.74.160.130'),
(61, '2021-11-08 09:31:46', NULL, 2, '188.27.125.94'),
(62, '2021-11-08 09:42:36', NULL, 64, '212.146.100.194'),
(63, '2021-11-08 09:50:34', NULL, 73, '62.74.160.130'),
(64, '2021-11-08 09:56:17', NULL, 66, '212.146.100.194'),
(65, '2021-11-08 10:07:05', NULL, 69, '212.146.100.194'),
(66, '2021-11-08 10:11:44', NULL, 66, '212.146.100.194'),
(67, '2021-11-08 10:22:34', NULL, 77, '195.46.23.115'),
(68, '2021-11-08 10:23:13', NULL, 1, '188.27.125.94'),
(69, '2021-11-08 11:09:00', NULL, 72, '62.74.160.130'),
(70, '2021-11-08 11:25:43', NULL, 72, '62.74.160.130'),
(71, '2021-11-08 11:25:59', NULL, 72, '62.74.160.130'),
(72, '2021-11-08 11:40:27', NULL, 73, '62.74.160.130'),
(73, '2021-11-08 11:56:32', NULL, 73, '62.74.160.130'),
(74, '2021-11-08 11:57:31', NULL, 78, '195.46.23.115'),
(75, '2021-11-08 12:01:36', NULL, 75, '62.74.160.130'),
(76, '2021-11-08 12:02:22', NULL, 75, '62.74.160.130'),
(77, '2021-11-08 12:03:03', NULL, 1, '188.27.125.94'),
(78, '2021-11-08 12:03:20', NULL, 75, '62.74.160.130'),
(79, '2021-11-08 12:05:23', NULL, 75, '62.74.160.130'),
(80, '2021-11-08 12:13:20', NULL, 75, '62.74.160.130'),
(81, '2021-11-08 12:27:19', NULL, 76, '195.46.23.115'),
(82, '2021-11-08 12:40:09', NULL, 78, '195.46.23.115'),
(83, '2021-11-08 12:53:52', NULL, 78, '195.46.23.115'),
(84, '2021-11-08 12:54:34', NULL, 73, '62.74.160.130'),
(85, '2021-11-08 12:54:54', NULL, 78, '195.46.23.115'),
(86, '2021-11-08 13:01:20', NULL, 74, '62.74.160.130'),
(87, '2021-11-08 13:14:31', NULL, 64, '212.146.100.194'),
(88, '2021-11-08 14:56:12', NULL, 72, '62.74.160.130'),
(89, '2021-11-08 15:46:29', NULL, 64, '188.27.125.94'),
(90, '2021-11-08 15:49:24', NULL, 2, '188.27.125.94'),
(91, '2021-11-08 16:16:29', NULL, 2, '188.27.125.94'),
(92, '2021-11-08 16:25:52', NULL, 2, '188.27.125.94'),
(93, '2021-11-08 16:37:55', NULL, 2, '188.27.125.94'),
(94, '2021-11-08 16:42:23', NULL, 1, '188.27.125.94'),
(95, '2021-11-08 18:33:13', NULL, 2, '79.115.21.165'),
(96, '2021-11-08 18:42:00', NULL, 2, '79.115.21.165'),
(97, '2021-11-09 07:31:55', NULL, 72, '62.74.160.130'),
(98, '2021-11-09 07:34:19', NULL, 1, '188.27.125.94'),
(99, '2021-11-09 07:38:05', NULL, 66, '109.166.135.175'),
(100, '2021-11-09 07:38:46', NULL, 66, '109.166.135.175'),
(101, '2021-11-09 07:39:50', NULL, 72, '62.74.160.130'),
(102, '2021-11-09 07:50:04', NULL, 73, '62.74.160.130'),
(103, '2021-11-09 07:56:09', NULL, 74, '62.74.160.130'),
(104, '2021-11-09 07:59:39', NULL, 1, '188.27.125.94'),
(105, '2021-11-09 08:04:41', NULL, 75, '62.74.160.130'),
(106, '2021-11-09 08:06:02', NULL, 2, '188.27.125.94'),
(107, '2021-11-09 08:15:26', NULL, 75, '62.74.160.130'),
(108, '2021-11-09 08:36:53', NULL, 66, '212.146.100.194'),
(109, '2021-11-09 08:38:06', NULL, 66, '212.146.100.194'),
(110, '2021-11-09 08:45:40', NULL, 77, '195.46.23.115'),
(111, '2021-11-09 08:45:57', NULL, 64, '212.146.100.194'),
(112, '2021-11-09 08:48:31', NULL, 78, '195.46.23.115'),
(113, '2021-11-09 08:49:16', NULL, 69, '212.146.100.194'),
(114, '2021-11-09 08:59:28', NULL, 77, '195.46.23.115'),
(115, '2021-11-09 09:00:03', NULL, 74, '62.74.160.130'),
(116, '2021-11-09 09:04:49', NULL, 73, '62.74.160.130'),
(117, '2021-11-09 09:04:50', NULL, 78, '195.46.23.115'),
(118, '2021-11-09 09:18:02', NULL, 72, '62.74.160.130'),
(119, '2021-11-09 09:31:42', NULL, 2, '188.27.125.94'),
(120, '2021-11-09 09:35:38', NULL, 73, '62.74.160.130');

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `user` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `query` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_length` text COLLATE utf8_bin,
  `col_collation` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) COLLATE utf8_bin DEFAULT '',
  `col_default` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `column_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `settings_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `export_type` varchar(10) COLLATE utf8_bin NOT NULL,
  `template_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `template_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sqlquery` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('36477cristian', '[{\"db\":\"cat_rohel_ro_db\",\"table\":\"cargo_notifications\"},{\"db\":\"cat_rohel_ro_db\",\"table\":\"cargo_settings\"},{\"db\":\"cat_rohel_ro_db\",\"table\":\"cargo_match\"},{\"db\":\"cat_rohel_ro_db\",\"table\":\"cargo_request\"},{\"db\":\"cat_rohel_ro_db\",\"table\":\"cargo_truck\"},{\"db\":\"cat_rohel_ro_db\",\"table\":\"cargo_truck_stops\"},{\"db\":\"cat_rohel_ro_db\",\"table\":\"cargo_users\"},{\"db\":\"cat_rohel_ro_db\",\"table\":\"cargo_user_audit\"},{\"db\":\"cat_rohel_ro_db\",\"table\":\"cargo_audit\"},{\"db\":\"cat_rohel_ro_db\",\"table\":\"cargo_offices\"}]'),
('u36477catr', '[{\"db\":\"u36477ca_cat\",\"table\":\"cargo_notifications\"},{\"db\":\"u36477ca_cat\",\"table\":\"cargo_settings\"},{\"db\":\"u36477ca_cat\",\"table\":\"cargo_request\"},{\"db\":\"u36477ca_cat\",\"table\":\"cargo_truck\"},{\"db\":\"u36477ca_cat\",\"table\":\"cargo_audit\"},{\"db\":\"u36477ca_cat\",\"table\":\"cargo_users\"},{\"db\":\"u36477ca_cat\",\"table\":\"cargo_comments\"},{\"db\":\"u36477ca_cat\",\"table\":\"cargo_user_audit\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT '0',
  `x` float UNSIGNED NOT NULL DEFAULT '0',
  `y` float UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `display_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `prefs` text COLLATE utf8_bin NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

--
-- Dumping data for table `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('36477cristian', 'cat_rohel_ro_db', 'cargo_match', '{\"sorted_col\":\"`cargo_match`.`ameta`  DESC\"}', '2021-11-08 12:57:43'),
('36477cristian', 'cat_rohel_ro_db', 'cargo_notifications', '{\"sorted_col\":\"`cargo_notifications`.`SYS_CREATION_DATE` DESC\"}', '2021-11-08 10:47:15'),
('36477cristian', 'cat_rohel_ro_db', 'cargo_request', '{\"sorted_col\":\"`cargo_request`.`SYS_CREATION_DATE` DESC\"}', '2021-11-08 07:51:03'),
('36477cristian', 'cat_rohel_ro_db', 'cargo_truck', '{\"sorted_col\":\"`cargo_truck`.`id` ASC\"}', '2021-11-08 11:14:39'),
('36477cristian', 'cat_rohel_ro_db', 'cargo_truck_stops', '{\"sorted_col\":\"`cargo_truck_stops`.`SYS_CREATION_DATE` DESC\"}', '2021-11-08 09:40:36'),
('36477cristian', 'cat_rohel_ro_db', 'cargo_user_audit', '{\"sorted_col\":\"`cargo_user_audit`.`SYS_CREATION_DATE` DESC\"}', '2021-11-08 07:44:06'),
('u36477catr', 'u36477ca_cat', 'cargo_notifications', '{\"sorted_col\":\"`cargo_notifications`.`SYS_CREATION_DATE` DESC\"}', '2021-11-08 16:42:59'),
('u36477catr', 'u36477ca_cat', 'cargo_request', '{\"sorted_col\":\"`cargo_request`.`SYS_CREATION_DATE`  DESC\"}', '2021-11-08 16:45:10'),
('u36477catr', 'u36477ca_cat', 'cargo_truck', '{\"sorted_col\":\"`cargo_truck`.`SYS_CREATION_DATE` DESC\"}', '2021-11-08 16:46:44');

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text COLLATE utf8_bin NOT NULL,
  `schema_sql` text COLLATE utf8_bin,
  `data_sql` longtext COLLATE utf8_bin,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') COLLATE utf8_bin DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `config_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('36477cristian', '2021-11-08 16:17:07', '{\"Console\\/Mode\":\"collapse\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL,
  `tab` varchar(64) COLLATE utf8_bin NOT NULL,
  `allowed` enum('Y','N') COLLATE utf8_bin NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cargo_audit`
--
ALTER TABLE `cargo_audit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cargo_comments`
--
ALTER TABLE `cargo_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key` (`cargo_id`),
  ADD KEY `CARGO_COMMENTS_OPERATOR_FK` (`operator_id`);

--
-- Indexes for table `cargo_countries`
--
ALTER TABLE `cargo_countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cargo_match`
--
ALTER TABLE `cargo_match`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CARGO_TRUCK_ORIGINATOR_FK` (`originator_id`),
  ADD KEY `CARGO_TRUCK_RECIPIENT_FK` (`recipient_id`);

--
-- Indexes for table `cargo_notifications`
--
ALTER TABLE `cargo_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CARGO_NOTIFICATIONS_USER_FK` (`user_id`),
  ADD KEY `CARGO_NOTIFICATIONS_ORIGINATOR_FK` (`originator_id`);

--
-- Indexes for table `cargo_offices`
--
ALTER TABLE `cargo_offices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cargo_request`
--
ALTER TABLE `cargo_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CARGO_REQUEST_ACCEPTED_FK` (`accepted_by`),
  ADD KEY `CARGO_REQUEST_ORIGINATOR_FK` (`originator_id`),
  ADD KEY `CARGO_REQUEST_RECIPIENT_FK` (`recipient_id`);

--
-- Indexes for table `cargo_settings`
--
ALTER TABLE `cargo_settings`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cargo_truck`
--
ALTER TABLE `cargo_truck`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CARGO_TRUCK_ORIGINATOR_FK` (`originator_id`),
  ADD KEY `CARGO_TRUCK_RECIPIENT_FK` (`recipient_id`);

--
-- Indexes for table `cargo_truck_comments`
--
ALTER TABLE `cargo_truck_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cargo_truck_stops`
--
ALTER TABLE `cargo_truck_stops`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cargo_truck_id_FK` (`truck_id`);

--
-- Indexes for table `cargo_users`
--
ALTER TABLE `cargo_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CARGO_USERS_OFFICE_FK` (`office_id`);

--
-- Indexes for table `cargo_user_audit`
--
ALTER TABLE `cargo_user_audit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cargo_audit`
--
ALTER TABLE `cargo_audit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `cargo_comments`
--
ALTER TABLE `cargo_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cargo_countries`
--
ALTER TABLE `cargo_countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cargo_match`
--
ALTER TABLE `cargo_match`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `cargo_notifications`
--
ALTER TABLE `cargo_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `cargo_offices`
--
ALTER TABLE `cargo_offices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cargo_request`
--
ALTER TABLE `cargo_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cargo_truck`
--
ALTER TABLE `cargo_truck`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `cargo_truck_comments`
--
ALTER TABLE `cargo_truck_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cargo_truck_stops`
--
ALTER TABLE `cargo_truck_stops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `cargo_users`
--
ALTER TABLE `cargo_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `cargo_user_audit`
--
ALTER TABLE `cargo_user_audit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cargo_comments`
--
ALTER TABLE `cargo_comments`
  ADD CONSTRAINT `CARGO_COMMENTS_ID_FK` FOREIGN KEY (`cargo_id`) REFERENCES `cargo_request` (`id`),
  ADD CONSTRAINT `CARGO_COMMENTS_OPERATOR_FK` FOREIGN KEY (`operator_id`) REFERENCES `cargo_users` (`id`);

--
-- Constraints for table `cargo_match`
--
ALTER TABLE `cargo_match`
  ADD CONSTRAINT `CARGO_MATCH_ORIGINATOR_ID` FOREIGN KEY (`originator_id`) REFERENCES `cargo_users` (`id`),
  ADD CONSTRAINT `CARGO_MATCH_RECIPIENT_ID` FOREIGN KEY (`recipient_id`) REFERENCES `cargo_users` (`id`);

--
-- Constraints for table `cargo_notifications`
--
ALTER TABLE `cargo_notifications`
  ADD CONSTRAINT `CARGO_NOTIFICATIONS_ORIGINATOR_FK` FOREIGN KEY (`originator_id`) REFERENCES `cargo_users` (`id`),
  ADD CONSTRAINT `CARGO_NOTIFICATIONS_USER_FK` FOREIGN KEY (`user_id`) REFERENCES `cargo_users` (`id`);

--
-- Constraints for table `cargo_request`
--
ALTER TABLE `cargo_request`
  ADD CONSTRAINT `CARGO_REQUEST_ACCEPTED_FK` FOREIGN KEY (`accepted_by`) REFERENCES `cargo_users` (`id`),
  ADD CONSTRAINT `CARGO_REQUEST_ORIGINATOR_FK` FOREIGN KEY (`originator_id`) REFERENCES `cargo_users` (`id`),
  ADD CONSTRAINT `CARGO_REQUEST_RECIPIENT_FK` FOREIGN KEY (`recipient_id`) REFERENCES `cargo_users` (`id`);

--
-- Constraints for table `cargo_truck`
--
ALTER TABLE `cargo_truck`
  ADD CONSTRAINT `CARGO_TRUCK_ORIGINATOR_FK` FOREIGN KEY (`originator_id`) REFERENCES `cargo_users` (`id`),
  ADD CONSTRAINT `CARGO_TRUCK_RECIPIENT_FK` FOREIGN KEY (`recipient_id`) REFERENCES `cargo_users` (`id`);

--
-- Constraints for table `cargo_truck_stops`
--
ALTER TABLE `cargo_truck_stops`
  ADD CONSTRAINT `cargo_truck_id_FK` FOREIGN KEY (`truck_id`) REFERENCES `cargo_truck` (`id`);

--
-- Constraints for table `cargo_users`
--
ALTER TABLE `cargo_users`
  ADD CONSTRAINT `CARGO_USERS_OFFICE_FK` FOREIGN KEY (`office_id`) REFERENCES `cargo_offices` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
