-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: my25470.d36477.myhost.ro
-- Generation Time: Nov 07, 2021 at 01:22 PM
-- Server version: 5.7.30-33-log
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cat_rohel_ro_db`
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
(46, '2021-11-06 12:34:02', NULL, 2, 'cristian.ungureanu@gmail.com', 0, '188.27.125.94', 'cargo_request', 'status', 3, '4');

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
(1, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 74, 1, 'SALONIC', 'Romania', '2021-11-08 00:00:00', 'DRAGOMIR MARIN 0744329019', 'B24XIE/B80YAJ', 'IRO2111032', 'N/A', '', 13.6, 0, 0, 41, 'truckInfo', '2021-11-05 17:21:26'),
(2, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 74, 1, 'SALONIC', 'Romania', '2021-11-08 00:00:00', 'VADUVA STELIAN 720048316', 'IF02ATE/IF11ATE', 'IRO2111030', 'N/A', '', 4.8, 0, 0, 40, 'truckInfo', '2021-11-05 17:01:32'),
(3, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 74, 1, 'SALONIC', 'Romania', '2021-11-08 00:00:00', 'VADUVA STELIAN 720048316', 'IF02ATE/IF11ATE', 'IRO2111030', 'N/A', '', 13, 0, 0, 40, 'truckInfo', '2021-11-05 17:01:32'),
(4, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 1, 'ALMYRO', 'Romania', '2021-11-08 00:00:00', 'LIXANDRU 0734198664', 'DB84EMY/DB85EMY', 'IRO2111026', 'N/A', '', 6.6, 11000, 0, 39, 'truckInfo', '2021-11-05 16:52:30'),
(5, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 1, 'ASPROPIRGOS', 'Romania', '2021-11-08 00:00:00', 'LIXANDRU 0734198664', 'DB84EMY/DB85EMY', 'IRO2111026', 'N/A', '', 6.8, 5153, 0, 39, 'truckInfo', '2021-11-05 16:52:30'),
(6, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 3, 'SALONIC', 'Romania', '2021-11-08 00:00:00', 'BLINDU VICTOR  0754455163', 'GJ25MIT/GJ55MIT', 'IRO2111018', 'N/A', '', 0.8, 0, 0, 38, 'truckInfo', '2021-11-05 16:37:42'),
(7, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 3, 'ATENA', 'Romania', '2021-11-08 00:00:00', 'BLINDU VICTOR  0754455163', 'GJ25MIT/GJ55MIT', 'IRO2111018', 'N/A', '', 12.4, 0, 0, 38, 'truckInfo', '2021-11-05 16:37:42'),
(8, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 1, 'SCHIMATARI', 'Romania', '2021-11-08 00:00:00', 'MIHAI IONEL 722256984', 'B67GOT/B65GOT', 'IRO2111012', 'N/A', '', 6, 6000, 0, 37, 'truckInfo', '2021-11-05 16:35:39'),
(9, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 1, 'ATENA', 'Romania', '2021-11-08 00:00:00', 'MIHAI IONEL 722256984', 'B67GOT/B65GOT', 'IRO2111012', 'N/A', '', 7.2, 4007, 0, 37, 'truckInfo', '2021-11-05 16:35:39'),
(10, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 1, 'KOLONOS', 'Romania', '2021-11-08 00:00:00', 'NITU MIHAI 757010115', 'IF85NMS/IF69NMS', 'IRO2111029', 'N/A', '', 8, 0, 0, 36, 'truckInfo', '2021-11-05 16:26:42'),
(11, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 1, 'ASPROPIRGOS', 'Romania', '2021-11-08 00:00:00', 'NITU MIHAI 757010115', 'IF85NMS/IF69NMS', 'IRO2111029', 'N/A', '', 2.4, 0, 0, 36, 'truckInfo', '2021-11-05 16:26:42'),
(12, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 1, 'VOTANIKOS', 'Romania', '2021-11-08 00:00:00', 'NITU MIHAI 757010115', 'IF85NMS/IF69NMS', 'IRO2111029', 'N/A', '', 2, 4500, 0, 36, 'truckInfo', '2021-11-05 16:26:42'),
(13, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 1, 'KOROPI', 'Romania', '2021-11-08 00:00:00', 'ALIMAN GHEORGHE 728374556', 'IF60NMS/IF61NMS', 'IRO2111028', 'N/A', '', 8, 0, 0, 35, 'truckInfo', '2021-11-05 16:20:54'),
(14, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 1, 'ASPROPIRGOS', 'Romania', '2021-11-08 00:00:00', 'ALIMAN GHEORGHE 728374556', 'IF60NMS/IF61NMS', 'IRO2111028', 'N/A', '', 2, 4200, 0, 35, 'truckInfo', '2021-11-05 16:20:54'),
(15, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 1, 'KOROPI', 'Romania', '2021-11-08 00:00:00', 'BULUMAC MARIAN 0721557328', 'IF50LDT/IF77LDT', 'IRO2111024', 'N/A', '', 9.9, 1000, 0, 34, 'truckInfo', '2021-11-05 16:17:11'),
(16, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 1, 'ACHARNES', 'Romania', '2021-11-08 00:00:00', 'BULUMAC MARIAN 0721557328', 'IF50LDT/IF77LDT', 'IRO2111024', 'N/A', '', 2.4, 2618, 0, 34, 'truckInfo', '2021-11-05 16:17:11'),
(17, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 1, 'RENTIS', 'Romania', '2021-11-08 00:00:00', 'BULUMAC MARIAN 0721557328', 'IF50LDT/IF77LDT', 'IRO2111024', 'N/A', '', 2, 3000, 0, 34, 'truckInfo', '2021-11-05 16:17:11'),
(18, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 1, 'ASPROPIRGOS', 'Romania', '2021-11-08 00:00:00', 'UTA FLORIN  766710272', 'IF05MBC/B108CUO', 'IRO2111027', 'N/A', '', 7.4, 6700, 0, 33, 'truckInfo', '2021-11-05 16:14:11'),
(19, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 1, 'KOROPI', 'Romania', '2021-11-08 00:00:00', 'UTA FLORIN  766710272', 'IF05MBC/B108CUO', 'IRO2111027', 'N/A', '', 6, 15570, 0, 33, 'truckInfo', '2021-11-05 16:14:11'),
(20, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 1, 'ASPROPIRGOS', 'Romania', '2021-11-08 00:00:00', 'PETRIS FLORIN  723309005', 'TR05XFP/TR08XFP', 'IRO2111025', 'N/A', '', 2.2, 134.2, 0, 32, 'truckInfo', '2021-11-05 15:48:17'),
(21, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 1, 'ASPROPIRGOS', 'Romania', '2021-11-08 00:00:00', 'PETRIS FLORIN  723309005', 'TR05XFP/TR08XFP', 'IRO2111025', 'N/A', '', 2.8, 1630, 0, 32, 'truckInfo', '2021-11-05 15:48:17'),
(22, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 1, 'KOROPI', 'Romania', '2021-11-08 00:00:00', 'PETRIS FLORIN  723309005', 'TR05XFP/TR08XFP', 'IRO2111025', 'N/A', '', 8.7, 13500, 0, 32, 'truckInfo', '2021-11-05 15:48:17'),
(23, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 1, 'MANDRA', 'Romania', '2021-11-10 00:00:00', 'VELEA ION  0744345428', 'B801CRS/B802CRS', 'IRO2111017', 'N/A', '', 13.6, 20000, 80, 25, 'truckInfo', '2021-11-05 15:35:57'),
(24, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 1, 'MANDRA', 'Romania', '2021-11-08 00:00:00', 'Nicolae Pavel', 'TR36PRO/TR38PRO', 'IRO2111016', 'N/A', '', 13.6, 20000, 80, 24, 'truckInfo', '2021-11-05 15:34:35'),
(25, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 64, 76, 1, 'MANDRA', 'Romania', '2021-11-09 00:00:00', '+40 751 420 150', 'AG99GMA/AG99GMC', 'IRO2111015', 'N/A', '', 13.6, 20000, 80, 23, 'truckInfo', '2021-11-05 15:33:30'),
(26, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 69, 72, 1, 'KILKIS', 'Romania', '2021-11-10 00:00:00', 'GIGI GOLICI ; +40 735 576 350', 'IF07BYS/IF06BYS', 'IRO2111562', 'N/A', '', 0, 23, 75, 21, 'truckInfo', '2021-11-05 13:27:58'),
(27, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 69, 76, 1, 'SCHIMATARI', 'Romania', '2021-11-10 00:00:00', 'NEAGU CIPRIAN', 'PH23RCC/PH12RCC', 'IRO2111560', 'N/A', 'yes', 0, 23, 75, 20, 'truckInfo', '2021-11-05 13:09:28'),
(28, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 68, 72, 6, 'kilkis', 'Romania', '2021-11-09 00:00:00', 'Paun Adrian', 'DB 72 PGS/AG 80 PGS', 'IRO2111558', 'N/A', '', 0, 23000, 75, 19, 'truckInfo', '2021-11-05 13:09:15'),
(29, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 68, 76, 1, 'Corinth', 'Romania', '2021-11-10 00:00:00', 'Cioaga Laurentiu, 0749175604', 'B540BAG/B550BAG', 'IRO2111553', 'N/A', '', 0, 23000, 75, 18, 'truckInfo', '2021-11-05 13:07:54'),
(30, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 69, 76, 1, 'ATENA', 'Romania', '2021-11-08 00:00:00', '-', 'TR36PRO/TR38PRO', 'IRO2111016', 'N/A', '', 0, 23, 75, 17, 'truckInfo', '2021-11-05 13:07:49'),
(31, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 68, 76, 1, 'Inofita', 'Romania', '2021-11-08 00:00:00', 'Patrascoiu Ion', 'GJ66XXL/GJ68XXL', 'IRO2110760', 'N/A', 'yes', 0, 23000, 75, 16, 'truckInfo', '2021-11-05 13:06:19'),
(32, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 69, 76, 1, 'ASPROPIRGOS', 'Romania', '2021-11-09 00:00:00', 'Dimineata Anton; +40 757 657 920', 'BZ16LRT/BZ20LRT', 'IRO2111541', 'N/A', '', 0, 23, 75, 15, 'truckInfo', '2021-11-05 13:05:16'),
(33, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:57', NULL, 68, 76, 1, 'Thiva', 'Romania', '2021-11-08 00:00:00', 'Dinu Elvis', 'VL 43 MRD/VL 34 MRD', 'IRO2111551', 'N/A', '', 0, 23000, 75, 14, 'truckInfo', '2021-11-05 13:05:06'),
(34, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:58', NULL, 68, 76, 1, 'Schimatari ', 'Romania', '2021-11-08 00:00:00', 'Cutoiu Marius, +40 732 428 474', 'DB77EVY/DB05CTF', 'IRO2111534', 'N/A', '', 0, 23000, 75, 13, 'truckInfo', '2021-11-05 13:03:43'),
(35, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:58', NULL, 69, 76, 1, 'SCHIMATARI', 'Romania', '2021-11-08 00:00:00', 'GEORGESCU AUREL; +40 748 011 418', 'AG95GMA/B394GMA', 'IRO2111542', 'N/A', 'yes', 0, 23, 75, 12, 'truckInfo', '2021-11-05 13:03:12'),
(36, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:58', NULL, 68, 76, 1, 'Atena', 'Romania', '2021-11-09 00:00:00', 'Nenciu Mihai', 'AG99GMA/AG99GMC', 'IRO2111015', 'N/A', 'YES', 0, 23000, 75, 11, 'truckInfo', '2021-11-05 13:02:11'),
(37, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:58', NULL, 69, 76, 1, 'CORINTH', 'Romania', '2021-11-08 00:00:00', 'SARU VALENTIN; 0741274441', 'AG15SCV/B24SPB', 'IRO2111546', 'N/A', '', 0, 23, 75, 10, 'truckInfo', '2021-11-05 13:01:22'),
(38, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:58', NULL, 68, 76, 1, 'Atena', 'Romania', '2021-11-08 00:00:00', '-', 'B450PGT/B451PGT', 'IRO2111530', 'N/A', '', 0, 230000, 75, 9, 'truckInfo', '2021-11-05 12:59:58'),
(39, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:58', NULL, 69, 76, 1, 'corinth', 'Romania', '2021-11-08 00:00:00', 'Mihai Doroftei ; +40 754 539 808', 'AG92DBY/AG99DBY', 'IRO2111555', 'N/A', 'yes', 0, 23, 75, 8, 'truckInfo', '2021-11-05 12:59:03'),
(40, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:58', NULL, 68, 76, 1, 'Atena', 'Romania', '2021-11-08 00:00:00', 'Saru', 'B300SCM/CV07BED', 'IRO2111527', 'N/A', '', 0, 23000, 75, 7, 'truckInfo', '2021-11-05 12:55:18'),
(41, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:58', NULL, 68, 76, 1, 'Atena', 'Romania', '2021-11-08 00:00:00', 'Georgescu Marius, +40 755 309 934', 'A94GMA/AG49GMA', 'IRO2111524', 'N/A', '', 0, 23000, 75, 6, 'truckInfo', '2021-11-05 12:53:03'),
(42, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:58', NULL, 68, 76, 1, 'Aspropirgos', 'Romania', '2021-11-08 00:00:00', 'Bratut Adrian,+40 765 440 991', 'B500BAG/B600BAG', 'IRO2111512', 'N/A', 'yes', 0, 23000, 75, 5, 'truckInfo', '2021-11-05 12:50:14'),
(43, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:58', NULL, 64, 76, 1, 'ASPROPIRGOS', 'Romania', '2021-11-08 00:00:00', 'PETRIS FLORIN', 'TR05XFP/TR08XFP', 'IRO2111025', 'N/A', '', 2.8, 1800, 0, 3, 'truckInfo', '2021-11-05 12:37:51'),
(44, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:58', NULL, 64, 76, 1, 'KOROPI', 'Romania', '2021-11-08 00:00:00', 'PETRIS FLORIN', 'TR05XFP/TR08XFP', 'IRO2111025', 'N/A', '', 7.9, 12400, 0, 3, 'truckInfo', '2021-11-05 12:37:51'),
(45, 'cristian.ungureanu@gmail.com', '2021-11-06 13:12:58', NULL, 72, 68, 2, 'Orestiada', 'Bucharest', '2021-11-08 00:00:00', '', '', '', 'Bid', '', 13.6, 24000, 50, 2, 'cargoInfo', '2021-11-05 13:23:29');

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
(45, 'cristian.ungureanu@gmail.com', '2021-11-06 12:28:16', NULL, 1, 2, 1, 1, 3, 0),
(46, 'cristian.ungureanu@gmail.com', '2021-11-06 12:32:25', NULL, 1, 2, 2, 1, 3, 0),
(47, 'cristian.ungureanu@gmail.com', '2021-11-06 12:34:02', NULL, 1, 2, 4, 1, 3, 0);

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

INSERT INTO `cargo_request` (`id`, `SYS_CREATION_DATE`, `SYS_UPDATE_DATE`, `status`, `operator`, `client`, `from_city`, `from_address`, `loading_date`, `description`, `instructions`, `freight`, `accepted_by`, `acceptance`, `expiration`, `plate_number`, `ameta`, `order_type`, `adr`, `to_city`, `to_address`, `unloading_date`, `collies`, `weight`, `volume`, `loading_meters`, `dimensions`, `package`, `originator_id`, `recipient_id`) VALUES
(1, '2021-11-04 16:29:34', '2021-11-05 17:36:15', 4, 'cristian.ungureanu@gmail.com', 'HP', 'Atena', 'HP HELLAS', '2021-11-08 00:00:00', 'laptops', 'Client', 1300, NULL, NULL, '2021-11-11 00:00:00', NULL, NULL, 'Forecast', NULL, 'Bucuresti', 'HP ROMANIA', '2021-11-12 00:00:00', 33, 20000, 70, 13.6, '', '', 2, 80),
(2, '2021-11-05 11:23:29', '2021-11-05 17:36:24', 1, 'tousios@unit-hellas.gr', 'Green Cola Bulgaria SA ', 'Orestiada', 'GREEN COLA ELLAS A.E. LEPTI, EVROS coordinates:41.499036, 26.485630', '2021-11-08 00:00:00', 'Refreshments', 'Client', 1000, NULL, NULL, '2021-11-09 00:00:00', NULL, NULL, 'Bid', NULL, 'Bucharest', 'ELGEKA FERFELIS DRUMUL ÃŽNTRE TARLALE 150-158 BUCURESTI 032982 ROMANIA Coordinates:44.411897, 26.217789', '2021-11-10 00:00:00', 30, 24000, 50, 13.6, '1.2X0.8X1.6', 'Pallets', 72, 68),
(3, '2021-11-06 12:28:16', '2021-11-06 12:34:02', 4, 'cristian.ungureanu@gmail.com', 'iedutu Ltd.', 'Bucuresti', 'ACME Inc.', '2021-11-14 00:00:00', '', 'Client', 130, NULL, NULL, '2021-11-27 00:00:00', NULL, NULL, 'Bid', NULL, 'Atena', 'Lefkados 4', '2021-11-16 00:00:00', 0, 450, 10, 6, '', '', 2, 1);

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
(NULL, '2021-10-17 08:48:16', '2021-11-06 13:12:58', 'changes', '0');

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

INSERT INTO `cargo_truck` (`id`, `operator`, `SYS_CREATION_DATE`, `SYS_UPDATE_DATE`, `originator_id`, `recipient_id`, `accepted_by`, `status`, `from_city`, `from_address`, `freight`, `availability`, `acceptance`, `expiration`, `details`, `plate_number`, `ameta`, `cargo_type`, `contract_type`, `truck_type`, `loading_date`, `unloading_date`, `adr`) VALUES
(1, 'cvezasi@unit-hellas.gr', '2021-11-04 16:32:53', '2021-11-05 17:39:04', 76, 78, 0, 6, 'Atena', '', 1100, NULL, NULL, '1970-01-01 02:00:00', 'popescu 004075546851', 'B-555-DDE', '', NULL, 'New', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(2, 'jo.ioana.pavel@gmail.com', '2021-11-05 10:35:40', '2021-11-05 17:39:08', 1, 76, 0, 6, 'Bucuresti', 'Strada Matei Basarab 94', 1100, NULL, NULL, '1970-01-01 02:00:00', 'Cristi 0745454655', 'b555zex', 'iro test`', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-07 00:00:00', NULL),
(3, 'valentina.preda@rohel.ro', '2021-11-05 10:37:51', NULL, 64, 76, 0, 1, 'BUCHAREST', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'PETRIS FLORIN', 'TR05XFP/TR08XFP', 'IRO2111025', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(4, 'valentina.preda@rohel.ro', '2021-11-05 10:38:08', '2021-11-05 17:39:12', 64, 74, 0, 6, 'Bucuresti', 'Strada Matei Basarab 94', 800, NULL, NULL, '1970-01-01 02:00:00', 'Popescu 078766567', 'b177shm', 'iro test 1', NULL, 'One-way', NULL, '2021-11-05 00:00:00', '2021-11-07 00:00:00', 'YES'),
(5, 'alina.ivascu@rohel.ro', '2021-11-05 10:50:14', NULL, 68, 76, 0, 1, 'Urlati', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Bratut Adrian,+40 765 440 991', 'B500BAG/B600BAG', 'IRO2111512', NULL, 'Round-trip', NULL, '2021-11-04 00:00:00', '2021-11-08 00:00:00', 'yes'),
(6, 'alina.ivascu@rohel.ro', '2021-11-05 10:53:03', NULL, 68, 76, 0, 1, 'Oradea', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Georgescu Marius, +40 755 309 934', 'A94GMA/AG49GMA', 'IRO2111524', NULL, 'Round-trip', NULL, '2021-11-04 00:00:00', '2021-11-08 00:00:00', NULL),
(7, 'alina.ivascu@rohel.ro', '2021-11-05 10:55:18', NULL, 68, 76, 0, 1, 'Bucuresti', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Saru', 'B300SCM/CV07BED', 'IRO2111527', NULL, 'Round-trip', NULL, '2021-11-03 00:00:00', '2021-11-08 00:00:00', NULL),
(8, 'adriana.goaga@rohel.ro', '2021-11-05 10:59:03', NULL, 69, 76, 0, 1, 'zarnesti', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Mihai Doroftei ; +40 754 539 808', 'AG92DBY/AG99DBY', 'IRO2111555', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', 'yes'),
(9, 'alina.ivascu@rohel.ro', '2021-11-05 10:59:58', NULL, 68, 76, 0, 1, 'Bucuresti', '', 1, NULL, NULL, '1970-01-01 02:00:00', '-', 'B450PGT/B451PGT', 'IRO2111530', NULL, 'Round-trip', NULL, '2021-11-03 00:00:00', '2021-11-08 00:00:00', NULL),
(10, 'adriana.goaga@rohel.ro', '2021-11-05 11:01:22', NULL, 69, 76, 0, 1, 'BUCURESTI', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'SARU VALENTIN; 0741274441', 'AG15SCV/B24SPB', 'IRO2111546', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(11, 'alina.ivascu@rohel.ro', '2021-11-05 11:02:11', NULL, 68, 76, 0, 1, 'Bucuresti', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Nenciu Mihai', 'AG99GMA/AG99GMC', 'IRO2111015', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-09 00:00:00', 'YES'),
(12, 'adriana.goaga@rohel.ro', '2021-11-05 11:03:12', NULL, 69, 76, 0, 1, 'ZARNESTI', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'GEORGESCU AUREL; +40 748 011 418', 'AG95GMA/B394GMA', 'IRO2111542', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', 'yes'),
(13, 'alina.ivascu@rohel.ro', '2021-11-05 11:03:43', NULL, 68, 76, 0, 1, 'Zarnesti', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Cutoiu Marius, +40 732 428 474', 'DB77EVY/DB05CTF', 'IRO2111534', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(14, 'alina.ivascu@rohel.ro', '2021-11-05 11:05:06', NULL, 68, 76, 0, 1, 'Slatina', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Dinu Elvis', 'VL 43 MRD/VL 34 MRD', 'IRO2111551', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(15, 'adriana.goaga@rohel.ro', '2021-11-05 11:05:16', NULL, 69, 76, 0, 1, 'URLATI', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Dimineata Anton; +40 757 657 920', 'BZ16LRT/BZ20LRT', 'IRO2111541', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-09 00:00:00', NULL),
(16, 'alina.ivascu@rohel.ro', '2021-11-05 11:06:19', NULL, 68, 76, 0, 1, 'Turceni', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Patrascoiu Ion', 'GJ66XXL/GJ68XXL', 'IRO2110760', NULL, 'Round-trip', NULL, '2021-11-03 00:00:00', '2021-11-08 00:00:00', 'yes'),
(17, 'adriana.goaga@rohel.ro', '2021-11-05 11:07:49', NULL, 69, 76, 0, 1, 'BUCURESTI', '', 1, NULL, NULL, '1970-01-01 02:00:00', '-', 'TR36PRO/TR38PRO', 'IRO2111016', NULL, 'Round-trip', NULL, '2021-11-04 00:00:00', '2021-11-08 00:00:00', NULL),
(18, 'alina.ivascu@rohel.ro', '2021-11-05 11:07:54', NULL, 68, 76, 0, 1, 'Zarnesti', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Cioaga Laurentiu, 0749175604', 'B540BAG/B550BAG', 'IRO2111553', NULL, 'Round-trip', NULL, '2021-11-08 00:00:00', '2021-11-10 00:00:00', NULL),
(19, 'alina.ivascu@rohel.ro', '2021-11-05 11:09:15', '2021-11-05 11:30:31', 68, 72, 0, 5, 'Giurgiu', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'Paun Adrian', 'DB 72 PGS/AG 80 PGS', 'IRO2111558', NULL, 'Round-trip', NULL, '2021-11-08 00:00:00', '2021-11-09 00:00:00', NULL),
(20, 'adriana.goaga@rohel.ro', '2021-11-05 11:09:28', NULL, 69, 76, 0, 1, 'ZARNESTI', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'NEAGU CIPRIAN', 'PH23RCC/PH12RCC', 'IRO2111560', NULL, 'Round-trip', NULL, '2021-11-08 00:00:00', '2021-11-10 00:00:00', 'yes'),
(21, 'adriana.goaga@rohel.ro', '2021-11-05 11:27:58', NULL, 69, 72, 0, 1, 'GIURGIU', '', 1, NULL, NULL, '1970-01-01 02:00:00', 'GIGI GOLICI ; +40 735 576 350', 'IF07BYS/IF06BYS', 'IRO2111562', NULL, 'Round-trip', NULL, '2021-11-09 00:00:00', '2021-11-10 00:00:00', NULL),
(22, 'valentina.preda@rohel.ro', '2021-11-05 13:32:22', '2021-11-05 14:35:18', 64, 76, 0, 6, 'BUCHAREST', '', 1025, NULL, NULL, '1970-01-01 02:00:00', '+40 751 420 150', 'AG99GMA/AG99GMC', 'IRO2111015', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-09 00:00:00', NULL),
(23, 'valentina.preda@rohel.ro', '2021-11-05 13:33:30', NULL, 64, 76, 0, 1, 'BUCHAREST', '', 1025, NULL, NULL, '1970-01-01 02:00:00', '+40 751 420 150', 'AG99GMA/AG99GMC', 'IRO2111015', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-09 00:00:00', NULL),
(24, 'valentina.preda@rohel.ro', '2021-11-05 13:34:35', NULL, 64, 76, 0, 1, 'BUCHAREST', '', 1025, NULL, NULL, '1970-01-01 02:00:00', 'Nicolae Pavel', 'TR36PRO/TR38PRO', 'IRO2111016', NULL, 'Round-trip', NULL, '2021-11-04 00:00:00', '2021-11-08 00:00:00', NULL),
(25, 'valentina.preda@rohel.ro', '2021-11-05 13:35:57', NULL, 64, 76, 0, 1, 'BUCHAREST', '', 1025, NULL, NULL, '1970-01-01 02:00:00', 'VELEA ION  0744345428', 'B801CRS/B802CRS', 'IRO2111017', NULL, 'Round-trip', NULL, '2021-11-06 00:00:00', '2021-11-10 00:00:00', NULL),
(26, 'valentina.preda@rohel.ro', '2021-11-05 13:39:13', NULL, 64, 76, 0, 2, 'MEDIAS', '', 1300, NULL, NULL, '1970-01-01 02:00:00', 'BLINDU VICTOR  0754455163', 'GJ25MIT/GJ55MIT', 'IRO2111018', NULL, 'One-way', NULL, '2021-11-05 00:00:00', '2021-11-09 00:00:00', NULL),
(27, 'valentina.preda@rohel.ro', '2021-11-05 13:39:20', NULL, 64, 76, 0, 2, 'MEDIAS', '', 1300, NULL, NULL, '1970-01-01 02:00:00', 'BLINDU VICTOR  0754455163', 'GJ25MIT/GJ55MIT', 'IRO2111018', NULL, 'One-way', NULL, '2021-11-05 00:00:00', '2021-11-09 00:00:00', NULL),
(28, 'valentina.preda@rohel.ro', '2021-11-05 13:40:25', NULL, 64, 76, 0, 2, 'MEDIAS', '', 1300, NULL, NULL, '1970-01-01 02:00:00', 'BLINDU VICTOR  0754455163', 'GJ25MIT/GJ55MIT', 'IRO2111018', NULL, 'One-way', NULL, '2021-11-05 00:00:00', '2021-11-09 00:00:00', NULL),
(29, 'valentina.preda@rohel.ro', '2021-11-05 13:40:34', NULL, 64, 76, 0, 2, 'MEDIAS', '', 1300, NULL, NULL, '1970-01-01 02:00:00', 'BLINDU VICTOR  0754455163', 'GJ25MIT/GJ55MIT', 'IRO2111018', NULL, 'One-way', NULL, '2021-11-05 00:00:00', '2021-11-09 00:00:00', NULL),
(30, 'valentina.preda@rohel.ro', '2021-11-05 13:44:37', NULL, 64, 76, 0, 1, 'BUCHAREST', '', 1190, NULL, NULL, '1970-01-01 02:00:00', 'PETRIS FLORIN  723309005', 'TR05XFP/TR08XFP', 'IRO2111025', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(31, 'valentina.preda@rohel.ro', '2021-11-05 13:45:06', NULL, 64, 76, 0, 1, 'BUCHAREST', '', 1190, NULL, NULL, '1970-01-01 02:00:00', 'PETRIS FLORIN  723309005', 'TR05XFP/TR08XFP', 'IRO2111025', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(32, 'valentina.preda@rohel.ro', '2021-11-05 13:48:17', '2021-11-05 14:27:28', 64, 76, 0, 1, 'BUCHAREST', '', 1190, NULL, NULL, '1970-01-01 02:00:00', 'PETRIS FLORIN  723309005', 'TR05XFP/TR08XFP', 'IRO2111025', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(33, 'valentina.preda@rohel.ro', '2021-11-05 14:14:11', NULL, 64, 76, 0, 1, 'BUCHAREST', '', 1130, NULL, NULL, '1970-01-01 02:00:00', 'UTA FLORIN  766710272', 'IF05MBC/B108CUO', 'IRO2111027', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(34, 'valentina.preda@rohel.ro', '2021-11-05 14:17:11', NULL, 64, 76, 0, 1, 'BUCHAREST', '', 1190, NULL, NULL, '1970-01-01 02:00:00', 'BULUMAC MARIAN 0721557328', 'IF50LDT/IF77LDT', 'IRO2111024', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(35, 'valentina.preda@rohel.ro', '2021-11-05 14:20:54', NULL, 64, 76, 0, 1, 'BUCHAREST', '', 1160, NULL, NULL, '1970-01-01 02:00:00', 'ALIMAN GHEORGHE 728374556', 'IF60NMS/IF61NMS', 'IRO2111028', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(36, 'valentina.preda@rohel.ro', '2021-11-05 14:26:42', '2021-11-05 14:27:06', 64, 76, 0, 1, 'BUCHAREST', '', 1110, NULL, NULL, '1970-01-01 02:00:00', 'NITU MIHAI 757010115', 'IF85NMS/IF69NMS', 'IRO2111029', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(37, 'valentina.preda@rohel.ro', '2021-11-05 14:35:39', NULL, 64, 76, 0, 1, 'PLOIESTI', '', 1160, NULL, NULL, '1970-01-01 02:00:00', 'MIHAI IONEL 722256984', 'B67GOT/B65GOT', 'IRO2111012', NULL, 'Round-trip', NULL, '2021-11-04 00:00:00', '2021-11-08 00:00:00', NULL),
(38, 'valentina.preda@rohel.ro', '2021-11-05 14:37:42', NULL, 64, 76, 0, 2, 'MEDIAS', '', 1300, NULL, NULL, '1970-01-01 02:00:00', 'BLINDU VICTOR  0754455163', 'GJ25MIT/GJ55MIT', 'IRO2111018', NULL, 'One-way', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(39, 'valentina.preda@rohel.ro', '2021-11-05 14:52:30', '2021-11-05 14:54:49', 64, 76, 0, 1, 'BUCHAREST', '', 1110, NULL, NULL, '1970-01-01 02:00:00', 'LIXANDRU 0734198664', 'DB84EMY/DB85EMY', 'IRO2111026', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(40, 'valentina.preda@rohel.ro', '2021-11-05 15:01:32', NULL, 64, 74, 0, 1, 'BUCHAREST', '', 660, NULL, NULL, '1970-01-01 02:00:00', 'VADUVA STELIAN 720048316', 'IF02ATE/IF11ATE', 'IRO2111030', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL),
(41, 'valentina.preda@rohel.ro', '2021-11-05 15:21:26', NULL, 64, 74, 0, 1, 'BUCHAREST', '', 600, NULL, NULL, '1970-01-01 02:00:00', 'DRAGOMIR MARIN 0744329019', 'B24XIE/B80YAJ', 'IRO2111032', NULL, 'Round-trip', NULL, '2021-11-05 00:00:00', '2021-11-08 00:00:00', NULL);

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
(1, 'cvezasi@unit-hellas.gr', '2021-11-04 16:32:53', NULL, 1, 0, 'Bucuresti', '', 0, 0, 100, 20000),
(2, 'jo.ioana.pavel@gmail.com', '2021-11-05 10:35:40', NULL, 2, 0, 'atena ', '3411 Lathrop St', 0, 13.6, 50, 20000),
(3, 'valentina.preda@rohel.ro', '2021-11-05 10:37:51', NULL, 3, 0, 'ASPROPIRGOS', '', 0, 2.8, 0, 1800),
(4, 'valentina.preda@rohel.ro', '2021-11-05 10:38:08', NULL, 4, 0, 'salonic', '', 0, 7, 30, 10000),
(5, 'valentina.preda@rohel.ro', '2021-11-05 10:38:08', NULL, 4, 1, 'kilkis', '', 0, 6, 20, 10000),
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
(49, 'valentina.preda@rohel.ro', '2021-11-05 15:21:26', NULL, 41, 0, 'SALONIC', '', 0, 13.6, 0, 0);

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
(2, '2015-06-29 14:28:43', '2021-11-07 11:02:45', 'cristian.ungureanu@gmail.com', 'Cristian', 'daa53ab4a07c9b60ef3261b5ff35053f4882e22d7707c8e75d6b25f4d5dddd5a', 1, 4, 1, 1, NULL),
(64, '2021-10-19 13:57:52', NULL, 'valentina.preda@rohel.ro', 'Valentina', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 1, 1, 1, NULL),
(65, '2021-10-19 13:58:18', NULL, 'ramona.caciulita@rohel.ro', 'Ramona', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 1, 1, 1, NULL),
(66, '2021-10-19 13:58:36', NULL, 'gina.popescu@rohel.ro', 'Gina', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 1, 1, 1, NULL),
(67, '2021-10-19 13:58:54', NULL, 'razvan.mira@rohel.ro', 'Razvan', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 1, 1, 1, NULL),
(68, '2021-10-19 13:59:28', NULL, 'alina.ivascu@rohel.ro', 'Alina', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 3, 1, 1, NULL),
(69, '2021-10-19 13:59:46', NULL, 'adriana.goaga@rohel.ro', 'Adriana', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 3, 1, 1, NULL),
(70, '2021-10-19 14:00:15', NULL, 'cristina.tamas@rohel.ro', 'Cristina', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 2, 1, 1, NULL),
(71, '2021-10-19 14:00:34', NULL, 'erika.hiri@rohel.ro', 'Erika', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 2, 1, 1, NULL),
(72, '2021-10-19 14:01:11', NULL, 'tousios@unit-hellas.gr', 'Mihalis', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 5, 1, 1, NULL),
(73, '2021-10-19 14:01:29', NULL, 'maniaka@unit-hellas.gr', 'Dimitra', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 5, 1, 1, NULL),
(74, '2021-10-19 14:01:49', NULL, 'papadakis@unit-hellas.gr', 'Oreste', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 5, 1, 1, NULL),
(75, '2021-10-19 14:02:16', NULL, 'markousov@unit-hellas.gr', 'Stergios', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 5, 1, 1, NULL),
(76, '2021-10-19 14:02:45', NULL, 'cvezasi@unit-hellas.gr', 'Camelia', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 4, 1, 1, NULL),
(77, '2021-10-19 14:03:17', NULL, 'manou@unit-hellas.gr', 'Manou', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 4, 1, 1, NULL),
(78, '2021-10-19 14:03:37', NULL, 'zahariou@unit-hellas.gr', 'Irini', 'B4B6E5DEEEC1253972CD0EC230E2951C5B2518C19CF9AA4198EE8731FEE58795', 1, 4, 1, 1, NULL),
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
(43, '2021-11-07 11:20:40', NULL, 2, '188.27.125.94');

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
('36477cristian', '[{\"db\":\"cat_rohel_ro_db\",\"table\":\"cargo_countries\"},{\"db\":\"cat_rohel_ro_db\",\"table\":\"cargo_audit\"},{\"db\":\"cat_rohel_ro_db\",\"table\":\"cargo_comments\"},{\"db\":\"cat_rohel_ro_db\",\"table\":\"cargo_user_audit\"},{\"db\":\"cat_rohel_ro_db\",\"table\":\"cargo_users\"},{\"db\":\"cat_rohel_ro_db\",\"table\":\"cargo_request\"}]');

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
('36477cristian', '2021-11-07 11:22:06', '{\"Console\\/Mode\":\"collapse\"}');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `cargo_comments`
--
ALTER TABLE `cargo_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cargo_countries`
--
ALTER TABLE `cargo_countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cargo_match`
--
ALTER TABLE `cargo_match`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `cargo_notifications`
--
ALTER TABLE `cargo_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `cargo_offices`
--
ALTER TABLE `cargo_offices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cargo_request`
--
ALTER TABLE `cargo_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cargo_truck`
--
ALTER TABLE `cargo_truck`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `cargo_truck_comments`
--
ALTER TABLE `cargo_truck_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cargo_truck_stops`
--
ALTER TABLE `cargo_truck_stops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `cargo_users`
--
ALTER TABLE `cargo_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `cargo_user_audit`
--
ALTER TABLE `cargo_user_audit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

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
