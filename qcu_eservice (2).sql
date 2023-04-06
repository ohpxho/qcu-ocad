-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 07, 2023 at 01:51 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qcu_eservice`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_document_requests`
--

CREATE TABLE `academic_document_requests` (
  `id` int(20) NOT NULL,
  `is_tor_included` int(2) NOT NULL,
  `tor_last_academic_year_attended` varchar(200) DEFAULT NULL,
  `gradeslip_academic_year` varchar(200) DEFAULT NULL,
  `gradeslip_semester` varchar(200) DEFAULT NULL,
  `is_gradeslip_included` int(2) NOT NULL,
  `is_ctc_included` int(2) NOT NULL,
  `ctc_document` varchar(200) DEFAULT NULL,
  `other_requested_document` varchar(200) DEFAULT NULL,
  `purpose_of_request` varchar(200) NOT NULL,
  `is_RA11261_beneficiary` varchar(200) NOT NULL,
  `barangay_certificate` varchar(200) DEFAULT NULL,
  `oath_of_undertaking` varchar(200) DEFAULT NULL,
  `student_id` int(20) NOT NULL,
  `is_diploma_included` int(2) NOT NULL,
  `diploma_year_graduated` varchar(200) DEFAULT NULL,
  `is_honorable_dismissal_included` int(2) DEFAULT NULL,
  `status` varchar(200) NOT NULL DEFAULT 'pending',
  `date_created` datetime DEFAULT NULL,
  `date_completed` datetime DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_document_requests`
--

INSERT INTO `academic_document_requests` (`id`, `is_tor_included`, `tor_last_academic_year_attended`, `gradeslip_academic_year`, `gradeslip_semester`, `is_gradeslip_included`, `is_ctc_included`, `ctc_document`, `other_requested_document`, `purpose_of_request`, `is_RA11261_beneficiary`, `barangay_certificate`, `oath_of_undertaking`, `student_id`, `is_diploma_included`, `diploma_year_graduated`, `is_honorable_dismissal_included`, `status`, `date_created`, `date_completed`, `remarks`, `type`) VALUES
(3, 0, NULL, '2023-2024', '1', 1, 0, '', '', 'test', '', NULL, NULL, 190837, 0, NULL, NULL, 'completed', '2023-03-22 22:43:04', '2023-03-23 22:47:48', '', 'student'),
(4, 0, NULL, '2022-2023', '1', 1, 0, '', '', 'test', '', NULL, NULL, 190837, 0, NULL, NULL, 'completed', '2023-03-23 11:15:54', '2023-03-23 22:57:22', '', 'student'),
(5, 0, NULL, '2022-2023', '1', 1, 0, '', '', 'test', '', NULL, NULL, 190837, 0, NULL, NULL, 'for claiming', '2023-03-23 11:16:01', '2023-03-23 22:10:22', '', 'student'),
(7, 0, NULL, '2022-2023', '1', 1, 0, '', '', 'test', '', NULL, NULL, 190837, 0, NULL, NULL, 'pending', '2023-03-23 13:05:46', '2023-03-23 21:12:52', '', 'student'),
(8, 0, '', NULL, NULL, 0, 0, NULL, NULL, 'test', 'no', '', '', 150836, 1, '2013', 0, 'pending', '2023-03-23 13:24:29', '2023-03-23 21:12:52', '', 'alumni');

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) NOT NULL,
  `actor` int(20) NOT NULL,
  `action` varchar(200) NOT NULL,
  `date_acted` datetime NOT NULL DEFAULT current_timestamp(),
  `description` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `actor`, `action`, `date_acted`, `description`) VALUES
(1, 190837, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-08 18:53:39', 'created new academic document request'),
(2, 190837, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-08 22:23:40', 'created new academic document request'),
(3, 190837, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-08 23:48:43', 'cancelled an academic document request'),
(4, 190837, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-08 23:50:19', 'cancelled an academic document request'),
(5, 190837, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-08 23:50:52', 'created new academic document request'),
(6, 190837, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-08 23:51:22', 'created new academic document request'),
(7, 190837, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-09 00:02:51', 'updated an academic document request'),
(8, 190837, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-09 00:33:22', 'cancelled an academic document request'),
(9, 190837, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-09 00:40:44', 'cancelled a good moral document request'),
(10, 190837, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-09 00:41:08', 'cancelled a good moral document request'),
(11, 190837, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-09 00:41:12', 'cancelled a good moral document request'),
(12, 190837, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-09 00:41:17', 'cancelled a good moral document request'),
(13, 190837, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-09 01:12:18', 'created new good moral document request'),
(14, 190837, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-09 01:15:22', 'updated good moral document request'),
(15, 190837, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-09 01:16:19', 'cancelled a good moral document request'),
(16, 190837, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-09 01:16:28', 'created new good moral document request'),
(17, 190837, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-09 01:17:30', 'cancelled a good moral document request'),
(18, 190837, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-09 01:17:35', 'created new good moral document request'),
(19, 190837, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-09 01:19:44', 'cancelled an academic document request'),
(20, 190837, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-09 01:20:06', 'created new academic document request'),
(21, 190837, 'SOA_DOCUMENT_REQUEST', '2023-03-09 01:45:05', 'created new statement of account document request'),
(22, 190837, 'SOA_DOCUMENT_REQUEST', '2023-03-09 01:45:20', 'cancelled a statement of account document request'),
(23, 190837, 'SOA_DOCUMENT_REQUEST', '2023-03-09 01:45:28', 'created new statement of account document request'),
(24, 190837, 'SOA_DOCUMENT_REQUEST', '2023-03-09 15:30:40', 'updated statement of account document request'),
(25, 190837, 'CONSULTATION', '2023-03-09 23:19:02', 'updated a consultation request'),
(26, 150001, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-10 23:32:12', 'updated a good moral document request'),
(27, 150001, 'CONSULTATION', '2023-03-10 23:41:02', 'resolved a consultation'),
(28, 150001, 'CONSULTATION', '2023-03-10 23:44:35', 'unresolved a consultation'),
(29, 150002, 'SOA_DOCUMENT_REQUEST', '2023-03-10 23:56:10', 'updated a statement of account document request'),
(30, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-11 00:01:55', 'updated an academic document request'),
(31, 150004, 'CONSULTATION', '2023-03-11 00:29:31', 'updated a consultation'),
(32, 150837, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-11 01:53:19', 'added new academic document request'),
(33, 10082, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-11 02:23:25', 'cancelled a academic document request'),
(34, 150837, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-11 02:23:44', 'added new academic document request'),
(35, 150837, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-11 08:41:47', 'updated academic document request'),
(36, 150837, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-11 08:41:52', 'updated academic document request'),
(37, 150837, 'ALUMNI', '2023-03-11 10:18:22', 'updated profile'),
(38, 150837, 'ALUMNI', '2023-03-11 10:18:29', 'updated profile'),
(39, 150837, 'ALUMNI', '2023-03-11 10:18:35', 'updated profile'),
(40, 150837, 'ALUMNI', '2023-03-11 10:18:43', 'updated profile'),
(41, 150837, 'ALUMNI', '2023-03-11 10:20:39', 'updated profile'),
(42, 150837, 'ALUMNI', '2023-03-11 10:20:44', 'updated profile'),
(43, 150837, 'ALUMNI', '2023-03-11 10:20:44', 'updated profile'),
(44, 150837, 'ALUMNI', '2023-03-11 10:22:23', 'updated profile'),
(45, 150837, 'ALUMNI', '2023-03-11 10:22:44', 'updated profile'),
(46, 150837, 'ALUMNI', '2023-03-11 10:22:50', 'updated profile'),
(47, 150837, 'ALUMNI', '2023-03-11 10:23:30', 'updated profile'),
(48, 150837, 'ALUMNI', '2023-03-11 10:23:51', 'updated profile'),
(49, 150837, 'ALUMNI', '2023-03-11 10:24:15', 'updated profile'),
(50, 150837, 'ALUMNI', '2023-03-11 10:25:28', 'updated profile'),
(51, 150837, 'ALUMNI', '2023-03-11 10:25:38', 'updated profile'),
(52, 150837, 'ALUMNI', '2023-03-11 10:25:51', 'updated profile'),
(53, 150837, 'ALUMNI', '2023-03-11 10:26:20', 'updated profile'),
(54, 150837, 'ALUMNI', '2023-03-11 10:28:52', 'updated profile'),
(55, 150837, 'ALUMNI', '2023-03-11 10:31:14', 'updated profile'),
(56, 150837, 'ALUMNI', '2023-03-11 10:37:33', 'updated profile'),
(57, 150836, 'ALUMNI', '2023-03-11 10:39:44', 'updated profile'),
(58, 150836, 'ALUMNI', '2023-03-11 10:43:37', 'updated profile'),
(59, 150836, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-11 10:43:57', 'added new academic document request'),
(60, 150836, 'ALUMNI', '2023-03-11 10:52:19', 'updated profile'),
(61, 150836, 'ALUMNI', '2023-03-11 10:52:28', 'updated profile'),
(62, 150836, 'ALUMNI', '2023-03-11 10:55:03', 'updated profile'),
(63, 150836, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-11 10:55:13', 'updated academic document request'),
(64, 150836, 'ALUMNI', '2023-03-11 10:55:27', 'updated profile'),
(65, 150836, 'ALUMNI', '2023-03-11 10:55:48', 'updated profile'),
(66, 150836, 'ALUMNI', '2023-03-11 10:55:52', 'updated profile'),
(67, 150836, 'ALUMNI', '2023-03-11 10:56:31', 'updated profile'),
(68, 150836, 'ALUMNI', '2023-03-11 11:00:13', 'updated profile'),
(69, 150836, 'ALUMNI', '2023-03-11 11:02:19', 'updated profile'),
(70, 150836, 'ALUMNI', '2023-03-11 11:03:05', 'updated profile'),
(71, 150836, 'ALUMNI', '2023-03-11 11:03:41', 'updated profile'),
(72, 150836, 'ALUMNI', '2023-03-11 11:04:14', 'updated profile'),
(73, 150836, 'ALUMNI', '2023-03-11 11:04:33', 'updated profile'),
(74, 150836, 'ALUMNI', '2023-03-11 11:07:31', 'updated profile'),
(75, 150836, 'ALUMNI', '2023-03-11 11:08:18', 'updated profile'),
(76, 150836, 'ALUMNI', '2023-03-11 11:09:44', 'updated profile'),
(77, 150836, 'ALUMNI', '2023-03-11 11:10:20', 'updated profile'),
(78, 150836, 'ALUMNI', '2023-03-11 11:11:24', 'updated profile'),
(79, 150836, 'ALUMNI', '2023-03-11 11:12:12', 'updated profile'),
(80, 150836, 'ALUMNI', '2023-03-11 11:12:52', 'updated profile'),
(81, 150836, 'ALUMNI', '2023-03-11 11:13:00', 'updated profile'),
(82, 150836, 'ALUMNI', '2023-03-11 11:13:26', 'updated profile'),
(83, 150836, 'ALUMNI', '2023-03-11 11:14:46', 'updated profile'),
(84, 150836, 'ALUMNI', '2023-03-11 11:15:16', 'updated profile'),
(85, 150836, 'ALUMNI', '2023-03-11 11:15:27', 'updated profile'),
(86, 150836, 'ALUMNI', '2023-03-11 11:15:33', 'updated profile'),
(87, 150836, 'ALUMNI', '2023-03-11 11:16:00', 'updated profile'),
(88, 150836, 'ALUMNI', '2023-03-11 11:16:19', 'updated profile'),
(89, 19940301, 'SYSADMIN', '2023-03-11 12:05:52', 'updated profile'),
(90, 19940301, 'SYSADMIN', '2023-03-11 12:06:21', 'updated profile'),
(91, 19940301, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-11 13:17:07', 'deleted multiple academic document request'),
(92, 19940301, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-11 13:20:55', 'deleted multiple academic document request'),
(93, 19940301, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-11 13:36:07', 'deleted multiple academic document request'),
(94, 19940301, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-11 13:37:13', 'deleted multiple academic document request'),
(95, 150836, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-12 00:17:52', 'added new academic document request'),
(96, 19940301, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-12 01:12:54', 'deleted multiple good moral document request'),
(97, 19940301, 'CONSULTATION', '2023-03-12 04:20:38', 'deleted a consultation'),
(98, 19940301, 'CONSULTATION', '2023-03-12 04:26:23', 'deleted a consultation'),
(99, 19940301, 'CONSULTATION', '2023-03-12 04:27:17', 'deleted a consultation'),
(100, 19940301, 'CONSULTATION', '2023-03-12 04:27:37', 'deleted a consultation'),
(101, 10094, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-12 09:34:58', 'cancelled a academic document request'),
(102, 150836, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-12 09:35:15', 'added new academic document request'),
(103, 190837, 'CONSULTATION', '2023-03-14 10:27:37', 'added new consultation request'),
(104, 190837, 'STUDENT', '2023-03-15 22:53:30', 'updated profile'),
(105, 19940301, 'USER_ACCOUNT', '2023-03-15 23:06:52', 'perform account approval'),
(106, 19940301, 'USER_ACCOUNT', '2023-03-15 23:08:02', 'perform account approval'),
(107, 19940301, 'USER_ACCOUNT', '2023-03-15 23:09:33', 'perform account approval'),
(108, 19940301, 'USER_ACCOUNT', '2023-03-16 10:43:09', 'perform account approval'),
(109, 19940301, 'USER_ACCOUNT', '2023-03-16 11:51:26', 'perform account approval'),
(110, 19940301, 'USER_ACCOUNT', '2023-03-16 11:53:11', 'perform account approval'),
(111, 19940301, 'USER_ACCOUNT', '2023-03-16 17:47:17', 'closed an account'),
(112, 19940301, 'USER_ACCOUNT', '2023-03-16 17:48:05', 'closed an account'),
(113, 19940301, 'USER_ACCOUNT', '2023-03-16 17:48:12', 'opened an account'),
(114, 19940301, 'USER_ACCOUNT', '2023-03-16 17:48:25', 'closed an account'),
(115, 19940301, 'USER_ACCOUNT', '2023-03-16 17:48:34', 'opened an account'),
(116, 19940301, 'USER_ACCOUNT', '2023-03-16 18:08:32', 'deleted an account'),
(117, 19940301, 'USER_ACCOUNT', '2023-03-16 18:08:46', 'closed an account'),
(118, 19940301, 'USER_ACCOUNT', '2023-03-16 18:09:06', 'opened an account'),
(119, 19940301, 'USER_ACCOUNT', '2023-03-16 18:09:13', 'closed an account'),
(120, 19940301, 'USER_ACCOUNT', '2023-03-16 18:09:24', 'opened an account'),
(121, 19940301, 'USER_ACCOUNT', '2023-03-16 18:23:28', 'blocked an account'),
(122, 19940301, 'USER_ACCOUNT', '2023-03-16 18:23:38', 'unblocked an account'),
(123, 19940301, 'USER_ACCOUNT', '2023-03-16 18:24:00', 'closed an account'),
(124, 19940301, 'USER_ACCOUNT', '2023-03-16 18:24:09', 'opened an account'),
(125, 19940301, 'USER_ACCOUNT', '2023-03-16 21:03:46', 'perform account approval'),
(126, 19940301, 'USER_ACCOUNT', '2023-03-16 21:04:09', 'perform account approval'),
(127, 19940301, 'USER_ACCOUNT', '2023-03-16 21:27:52', 'perform account approval'),
(128, 19940301, 'USER_ACCOUNT', '2023-03-16 22:22:14', 'perform account approval'),
(129, 19940301, 'USER_ACCOUNT', '2023-03-16 22:32:55', 'closed an account'),
(130, 19940301, 'USER_ACCOUNT', '2023-03-16 22:33:02', 'opened an account'),
(131, 19940301, 'USER_ACCOUNT', '2023-03-16 23:52:42', 'deleted multiple student account'),
(132, 19940301, 'USER_ACCOUNT', '2023-03-16 23:53:08', 'deleted multiple student account'),
(133, 19940301, 'USER_ACCOUNT', '2023-03-16 23:56:38', 'deleted multiple student account'),
(134, 19940301, 'USER_ACCOUNT', '2023-03-17 21:18:47', 'closed an account'),
(135, 19940301, 'USER_ACCOUNT', '2023-03-17 21:18:56', 'closed an account'),
(136, 19940301, 'USER_ACCOUNT', '2023-03-17 21:30:22', 'closed an account'),
(137, 19940301, 'USER_ACCOUNT', '2023-03-17 21:31:58', 'opened an account'),
(138, 19940301, 'USER_ACCOUNT', '2023-03-17 21:32:02', 'opened an account'),
(139, 19940301, 'USER_ACCOUNT', '2023-03-17 21:37:57', 'blocked an account'),
(140, 19940301, 'USER_ACCOUNT', '2023-03-17 21:38:26', 'unblocked an account'),
(141, 19940301, 'USER_ACCOUNT', '2023-03-17 21:38:33', 'closed an account'),
(142, 19940301, 'USER_ACCOUNT', '2023-03-17 21:38:38', 'opened an account'),
(143, 19940301, 'USER_ACCOUNT', '2023-03-17 21:41:32', 'perform account approval'),
(144, 19940301, 'USER_ACCOUNT', '2023-03-17 21:50:23', 'perform account approval'),
(145, 19940301, 'USER_ACCOUNT', '2023-03-17 21:55:07', 'perform account approval'),
(146, 19940301, 'USER_ACCOUNT', '2023-03-17 21:57:09', 'perform account approval'),
(147, 19940301, 'USER_ACCOUNT', '2023-03-17 21:57:15', 'perform account approval'),
(148, 19940301, 'USER_ACCOUNT', '2023-03-17 21:57:20', 'deleted multiple student account'),
(149, 19940301, 'USER_ACCOUNT', '2023-03-17 21:59:10', 'perform account approval'),
(150, 19940301, 'USER_ACCOUNT', '2023-03-17 21:59:18', 'deleted multiple student account'),
(151, 19940301, 'USER_ACCOUNT', '2023-03-17 22:05:42', 'deleted multiple student account'),
(152, 19940301, 'USER_ACCOUNT', '2023-03-17 22:06:40', 'deleted multiple student account'),
(153, 19940301, 'USER_ACCOUNT', '2023-03-17 22:06:40', 'deleted multiple student account'),
(154, 19940301, 'USER_ACCOUNT', '2023-03-17 22:07:43', 'deleted an account'),
(155, 19940301, 'USER_ACCOUNT', '2023-03-17 22:07:55', 'closed an account'),
(156, 19940301, 'USER_ACCOUNT', '2023-03-17 22:08:00', 'opened an account'),
(157, 19940301, 'USER_ACCOUNT', '2023-03-17 23:24:53', 'closed an account'),
(158, 19940301, 'USER_ACCOUNT', '2023-03-17 23:25:01', 'opened an account'),
(159, 19940301, 'USER_ACCOUNT', '2023-03-17 23:26:05', 'blocked an account'),
(160, 19940301, 'USER_ACCOUNT', '2023-03-17 23:26:26', 'blocked an account'),
(161, 19940301, 'USER_ACCOUNT', '2023-03-17 23:26:36', 'unblocked an account'),
(162, 19940301, 'USER_ACCOUNT', '2023-03-17 23:26:39', 'unblocked an account'),
(163, 19940301, 'USER_ACCOUNT', '2023-03-17 23:26:45', 'closed an account'),
(164, 19940301, 'USER_ACCOUNT', '2023-03-17 23:26:50', 'opened an account'),
(165, 19940301, 'USER_ACCOUNT', '2023-03-17 23:33:00', 'closed an account'),
(166, 19940301, 'USER_ACCOUNT', '2023-03-17 23:33:03', 'closed an account'),
(167, 19940301, 'USER_ACCOUNT', '2023-03-17 23:33:11', 'closed an account'),
(168, 19940301, 'USER_ACCOUNT', '2023-03-17 23:33:33', 'opened an account'),
(169, 19940301, 'USER_ACCOUNT', '2023-03-17 23:34:44', 'closed an account'),
(170, 19940301, 'USER_ACCOUNT', '2023-03-17 23:35:41', 'closed an account'),
(171, 19940301, 'USER_ACCOUNT', '2023-03-17 23:35:45', 'opened an account'),
(172, 19940301, 'USER_ACCOUNT', '2023-03-17 23:35:48', 'closed an account'),
(173, 19940301, 'USER_ACCOUNT', '2023-03-17 23:36:03', 'opened an account'),
(174, 19940301, 'USER_ACCOUNT', '2023-03-17 23:37:54', 'closed an account'),
(175, 19940301, 'USER_ACCOUNT', '2023-03-17 23:37:59', 'opened an account'),
(176, 19940301, 'USER_ACCOUNT', '2023-03-17 23:39:13', 'opened an account'),
(177, 19940301, 'USER_ACCOUNT', '2023-03-17 23:39:16', 'closed an account'),
(178, 19940301, 'USER_ACCOUNT', '2023-03-18 08:55:34', 'opened an account'),
(179, 19940301, 'USER_ACCOUNT', '2023-03-18 08:55:46', 'closed an account'),
(180, 19940301, 'USER_ACCOUNT', '2023-03-18 09:45:35', 'opened an account'),
(181, 19940301, 'USER_ACCOUNT', '2023-03-18 09:45:41', 'closed an account'),
(182, 19940301, 'USER_ACCOUNT', '2023-03-18 10:04:06', 'opened an account'),
(183, 19940301, 'USER_ACCOUNT', '2023-03-18 10:04:09', 'closed an account'),
(184, 19940301, 'USER_ACCOUNT', '2023-03-18 10:08:42', 'deleted multiple student account'),
(185, 19940301, 'USER_ACCOUNT', '2023-03-18 10:08:45', 'deleted multiple student account'),
(186, 19940301, 'USER_ACCOUNT', '2023-03-18 10:09:05', 'deleted an account'),
(187, 19940301, 'USER_ACCOUNT', '2023-03-18 12:48:05', 'closed an account'),
(188, 19940301, 'USER_ACCOUNT', '2023-03-18 12:48:09', 'deleted an account'),
(189, 19940301, 'USER_ACCOUNT', '2023-03-18 12:52:02', 'added new admin account'),
(190, 19940301, 'USER_ACCOUNT', '2023-03-18 12:53:04', 'blocked an account'),
(191, 19940301, 'USER_ACCOUNT', '2023-03-18 12:53:08', 'deleted an account'),
(192, 190837, 'SOA_DOCUMENT_REQUEST', '2023-03-21 00:01:31', 'created new SOA/Order of Payment document request'),
(193, 190837, 'SOA_DOCUMENT_REQUEST', '2023-03-21 00:01:37', 'created new SOA/Order of Payment document request'),
(194, 190837, 'SOA_DOCUMENT_REQUEST', '2023-03-21 00:01:59', 'created new SOA/Order of Payment document request'),
(195, 190837, 'SOA_DOCUMENT_REQUEST', '2023-03-21 00:02:16', 'cancelled a SOA/Order of Payment document request'),
(196, 190837, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-21 00:02:37', 'created new good moral document request'),
(197, 190837, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-21 00:17:24', 'created new academic document request'),
(198, 190837, 'CONSULTATION', '2023-03-21 22:05:13', 'added new consultation request'),
(199, 190837, 'CONSULTATION', '2023-03-21 22:05:25', 'added new consultation request'),
(200, 190837, 'CONSULTATION', '2023-03-21 22:05:26', 'added new consultation request'),
(201, 190837, 'CONSULTATION', '2023-03-21 22:05:40', 'added new consultation request'),
(202, 190837, 'CONSULTATION', '2023-03-21 22:05:47', 'added new consultation request'),
(203, 150001, 'CONSULTATION', '2023-03-21 22:07:31', 'updated a consultation'),
(204, 150001, 'CONSULTATION', '2023-03-21 22:32:33', 'resolved a consultation'),
(205, 150001, 'CONSULTATION', '2023-03-21 22:54:05', 'deleted a consultation'),
(206, 150001, 'CONSULTATION', '2023-03-21 22:55:05', 'deleted a consultation'),
(207, 150001, 'CONSULTATION', '2023-03-21 22:59:14', 'updated a consultation'),
(208, 150001, 'CONSULTATION', '2023-03-21 22:59:23', 'resolved a consultation'),
(209, 150001, 'CONSULTATION', '2023-03-21 22:59:59', 'updated a consultation'),
(210, 150001, 'CONSULTATION', '2023-03-21 23:00:33', 'resolved a consultation'),
(211, 150001, 'CONSULTATION', '2023-03-21 23:06:44', 'updated a consultation'),
(212, 150001, 'CONSULTATION', '2023-03-21 23:11:41', 'updated a consultation'),
(213, 150001, 'CONSULTATION', '2023-03-21 23:11:53', 'unresolved a consultation'),
(214, 150001, 'CONSULTATION', '2023-03-21 23:12:13', 'deleted a multiple consultation'),
(215, 150001, 'CONSULTATION', '2023-03-21 23:13:51', 'deleted a multiple consultation'),
(216, 150001, 'CONSULTATION', '2023-03-21 23:15:55', 'deleted a multiple consultation'),
(217, 150001, 'CONSULTATION', '2023-03-21 23:16:04', 'deleted a multiple consultation'),
(218, 150001, 'CONSULTATION', '2023-03-21 23:16:04', 'deleted a multiple consultation'),
(219, 150002, 'SOA_DOCUMENT_REQUEST', '2023-03-22 08:56:37', 'updated a SOA/Order of Payment document request'),
(220, 150002, 'SOA_DOCUMENT_REQUEST', '2023-03-22 09:05:43', 'updated a multiple SOA/Order of Payment document request'),
(221, 150002, 'SOA_DOCUMENT_REQUEST', '2023-03-22 09:06:57', 'updated a multiple SOA/Order of Payment document request'),
(222, 150002, 'SOA_DOCUMENT_REQUEST', '2023-03-22 09:07:40', 'updated a multiple SOA/Order of Payment document request'),
(223, 150002, 'SOA_DOCUMENT_REQUEST', '2023-03-22 09:53:03', 'updated a SOA/Order of Payment document request'),
(224, 150002, 'SOA_DOCUMENT_REQUEST', '2023-03-22 09:54:08', 'updated a multiple SOA/Order of Payment document request'),
(225, 150002, 'SOA_DOCUMENT_REQUEST', '2023-03-22 10:00:29', 'updated a SOA/Order of Payment document request'),
(226, 150002, 'SOA_DOCUMENT_REQUEST', '2023-03-22 10:00:34', 'updated a multiple SOA/Order of Payment document request'),
(227, 150836, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-22 20:40:06', 'created new academic document request'),
(228, 190837, 'CONSULTATION', '2023-03-22 20:50:54', 'added new consultation request'),
(229, 150004, 'CONSULTATION', '2023-03-22 20:51:50', 'updated a consultation'),
(230, 150004, 'CONSULTATION', '2023-03-22 20:52:08', 'unresolved a consultation'),
(231, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-22 21:51:18', 'updated an academic document request'),
(232, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-22 22:04:50', 'updated multiple academic document request'),
(233, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-22 22:12:31', 'updated an academic document request'),
(234, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-22 22:27:35', 'updated an academic document request'),
(235, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-22 22:30:14', 'updated an academic document request'),
(236, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-22 22:33:12', 'deleted an academic document request'),
(237, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-22 22:33:22', 'deleted an academic document request'),
(238, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-22 22:33:31', 'deleted multiple academic document request'),
(239, 190837, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-22 22:43:04', 'created new academic document request'),
(240, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-22 22:43:48', 'updated an academic document request'),
(241, 190837, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 11:15:55', 'created new academic document request'),
(242, 190837, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 11:16:01', 'created new academic document request'),
(243, 190837, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 11:16:08', 'created new academic document request'),
(244, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 11:16:58', 'updated an academic document request'),
(245, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 11:21:18', 'updated an academic document request'),
(246, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 11:28:55', 'updated an academic document request'),
(247, 190837, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-23 11:57:03', 'cancelled a good moral document request'),
(248, 190837, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-23 11:57:12', 'cancelled a good moral document request'),
(249, 190837, 'CONSULTATION', '2023-03-23 12:36:19', 'added new consultation request'),
(250, 150001, 'CONSULTATION', '2023-03-23 12:37:07', 'updated a consultation'),
(251, 190837, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 13:05:53', 'created new academic document request'),
(252, 190837, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-23 13:17:27', 'created new good moral document request'),
(253, 190837, 'SOA_DOCUMENT_REQUEST', '2023-03-23 13:17:50', 'created new SOA/Order of Payment document request'),
(254, 190837, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-23 13:18:21', 'cancelled a good moral document request'),
(255, 190837, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-23 13:18:28', 'created new good moral document request'),
(256, 190837, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 13:18:35', 'cancelled an academic document request'),
(257, 190837, 'SOA_DOCUMENT_REQUEST', '2023-03-23 13:18:42', 'updated SOA/Order of Payment document request'),
(258, 190837, 'SOA_DOCUMENT_REQUEST', '2023-03-23 13:19:38', 'updated SOA/Order of Payment document request'),
(259, 190837, 'SOA_DOCUMENT_REQUEST', '2023-03-23 13:19:44', 'cancelled a SOA/Order of Payment document request'),
(260, 190837, 'SOA_DOCUMENT_REQUEST', '2023-03-23 13:19:55', 'created new SOA/Order of Payment document request'),
(261, 150836, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 13:24:30', 'created new academic document request'),
(262, 150836, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-23 13:25:07', 'created new good moral document request'),
(263, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 18:25:14', 'updated an academic document request'),
(264, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 18:30:24', 'updated an academic document request'),
(265, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 18:48:03', 'updated an academic document request'),
(266, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 18:48:32', 'updated an academic document request'),
(267, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 18:49:13', 'updated an academic document request'),
(268, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 18:50:23', 'updated an academic document request'),
(269, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 18:50:51', 'updated an academic document request'),
(270, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 18:52:14', 'updated an academic document request'),
(271, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 18:54:22', 'updated an academic document request'),
(272, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 18:58:00', 'updated an academic document request'),
(273, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 19:00:32', 'updated an academic document request'),
(274, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 19:37:51', 'updated an academic document request'),
(275, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 19:38:10', 'updated an academic document request'),
(276, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 19:39:22', 'updated an academic document request'),
(277, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 19:40:40', 'updated an academic document request'),
(278, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 19:42:32', 'updated an academic document request'),
(279, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 19:43:23', 'updated an academic document request'),
(280, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 19:50:49', 'updated an academic document request'),
(281, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 19:51:43', 'updated an academic document request'),
(282, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 19:52:25', 'updated an academic document request'),
(283, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 21:12:51', 'updated multiple academic document request'),
(284, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 21:12:52', 'updated multiple academic document request'),
(285, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 21:12:52', 'updated multiple academic document request'),
(286, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 21:12:52', 'updated multiple academic document request'),
(287, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:06:16', 'updated multiple academic document request'),
(288, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:06:17', 'updated multiple academic document request'),
(289, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:09:35', 'updated multiple academic document request'),
(290, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:10:07', 'updated multiple academic document request'),
(291, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:10:22', 'updated multiple academic document request'),
(292, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:11:05', 'updated an academic document request'),
(293, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:11:33', 'updated multiple academic document request'),
(294, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:14:09', 'updated an academic document request'),
(295, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:14:27', 'updated an academic document request'),
(296, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:14:49', 'updated multiple academic document request'),
(297, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:15:58', 'updated multiple academic document request'),
(298, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:15:58', 'updated multiple academic document request'),
(299, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:25:36', 'updated an academic document request'),
(300, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:33:51', 'updated an academic document request'),
(301, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:38:44', 'updated an academic document request'),
(302, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:41:03', 'updated an academic document request'),
(303, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:47:49', 'updated an academic document request'),
(304, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:48:17', 'updated an academic document request'),
(305, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:48:29', 'updated an academic document request'),
(306, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:54:07', 'updated an academic document request'),
(307, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:54:14', 'updated an academic document request'),
(308, 150003, 'ACADEMIC_DOCUMENT_REQUEST', '2023-03-23 22:57:22', 'updated an academic document request'),
(309, 19940301, 'USER_ACCOUNT', '2023-03-23 23:45:24', 'perform account approval'),
(310, 19940301, 'SYSADMIN', '2023-03-27 07:08:53', 'updated profile'),
(311, 19940301, 'SYSADMIN', '2023-03-27 23:05:44', 'updated profile'),
(312, 150001, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-27 23:15:13', 'updated a good moral document request'),
(313, 150001, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-27 23:18:10', 'updated a good moral document request'),
(314, 150001, 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-03-27 23:19:09', 'updated a good moral document request'),
(315, 19940301, 'USER_ACCOUNT', '2023-03-28 02:16:13', 'added new admin account'),
(316, 19940301, 'USER_ACCOUNT', '2023-03-28 04:29:39', 'closed an account'),
(317, 19940301, 'USER_ACCOUNT', '2023-03-30 21:18:49', 'blocked an account'),
(318, 19940301, 'USER_ACCOUNT', '2023-03-30 21:18:59', 'blocked an account'),
(319, 19940301, 'USER_ACCOUNT', '2023-03-30 21:19:07', 'perform account approval'),
(320, 19940301, 'USER_ACCOUNT', '2023-03-30 21:19:15', 'blocked an account'),
(321, 19940301, 'USER_ACCOUNT', '2023-03-30 21:19:26', 'deleted multiple student account'),
(322, 19940301, 'USER_ACCOUNT', '2023-03-30 21:19:26', 'deleted multiple student account'),
(323, 19940301, 'USER_ACCOUNT', '2023-03-30 21:19:26', 'deleted multiple student account'),
(324, 19940301, 'USER_ACCOUNT', '2023-03-30 21:19:26', 'deleted multiple student account'),
(325, 19940301, 'USER_ACCOUNT', '2023-03-30 21:27:05', 'blocked an account'),
(326, 19940301, 'USER_ACCOUNT', '2023-03-30 21:27:15', 'blocked an account'),
(327, 19940301, 'USER_ACCOUNT', '2023-03-30 21:27:21', 'deleted multiple student account'),
(328, 19940301, 'USER_ACCOUNT', '2023-03-30 21:27:21', 'deleted multiple student account'),
(329, 19940301, 'USER_ACCOUNT', '2023-03-30 21:28:06', 'blocked an account'),
(330, 19940301, 'USER_ACCOUNT', '2023-03-30 21:28:09', 'blocked an account'),
(331, 19940301, 'USER_ACCOUNT', '2023-03-30 21:28:14', 'deleted multiple student account'),
(332, 19940301, 'USER_ACCOUNT', '2023-03-30 21:28:17', 'deleted multiple student account'),
(333, 19940301, 'USER_ACCOUNT', '2023-03-30 21:30:08', 'blocked an account'),
(334, 19940301, 'USER_ACCOUNT', '2023-03-30 21:30:11', 'blocked an account'),
(335, 19940301, 'USER_ACCOUNT', '2023-03-30 21:30:15', 'deleted multiple student account'),
(336, 19940301, 'USER_ACCOUNT', '2023-03-30 21:30:16', 'deleted multiple student account'),
(337, 19940301, 'USER_ACCOUNT', '2023-03-30 21:37:33', 'blocked an account'),
(338, 19940301, 'USER_ACCOUNT', '2023-03-30 21:37:36', 'blocked an account'),
(339, 19940301, 'USER_ACCOUNT', '2023-03-30 21:37:40', 'deleted multiple student account'),
(340, 19940301, 'USER_ACCOUNT', '2023-03-30 21:37:41', 'deleted multiple student account'),
(341, 19940301, 'USER_ACCOUNT', '2023-03-30 22:00:33', 'blocked an account'),
(342, 19940301, 'USER_ACCOUNT', '2023-03-30 22:00:37', 'blocked an account'),
(343, 19940301, 'USER_ACCOUNT', '2023-03-30 22:00:42', 'deleted multiple student account'),
(344, 19940301, 'USER_ACCOUNT', '2023-03-30 22:00:42', 'deleted multiple student account'),
(345, 19940301, 'USER_ACCOUNT', '2023-03-30 22:16:46', 'blocked an account'),
(346, 19940301, 'USER_ACCOUNT', '2023-03-30 22:16:51', 'blocked an account'),
(347, 19940301, 'USER_ACCOUNT', '2023-03-30 22:16:55', 'deleted multiple student account'),
(348, 19940301, 'USER_ACCOUNT', '2023-03-30 22:16:56', 'deleted multiple student account'),
(349, 19940301, 'USER_ACCOUNT', '2023-03-30 22:27:31', 'blocked an account'),
(350, 19940301, 'USER_ACCOUNT', '2023-03-30 22:27:36', 'blocked an account'),
(351, 19940301, 'USER_ACCOUNT', '2023-03-30 22:27:40', 'deleted multiple student account'),
(352, 19940301, 'USER_ACCOUNT', '2023-03-30 22:27:40', 'deleted multiple student account'),
(353, 19940301, 'USER_ACCOUNT', '2023-03-30 22:39:07', 'blocked an account'),
(354, 19940301, 'USER_ACCOUNT', '2023-03-30 22:39:19', 'blocked an account'),
(355, 19940301, 'USER_ACCOUNT', '2023-03-30 22:39:23', 'deleted multiple student account'),
(356, 19940301, 'USER_ACCOUNT', '2023-03-30 22:39:23', 'deleted multiple student account'),
(357, 19940301, 'USER_ACCOUNT', '2023-03-31 00:18:58', 'added new student account'),
(358, 19940301, 'USER_ACCOUNT', '2023-03-31 00:49:20', 'added new alumni account'),
(359, 190837, 'CONSULTATION', '2023-04-06 23:34:27', 'added new consultation request'),
(360, 190837, 'CONSULTATION', '2023-04-07 02:49:37', 'added new consultation request');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(20) NOT NULL,
  `lname` varchar(200) NOT NULL,
  `fname` varchar(200) NOT NULL,
  `mname` varchar(200) DEFAULT NULL,
  `email` varchar(200) NOT NULL,
  `department` varchar(200) DEFAULT NULL,
  `contact` varchar(200) NOT NULL,
  `gender` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `lname`, `fname`, `mname`, `email`, `department`, `contact`, `gender`) VALUES
(150001, 'Aruta', 'John', 'Miles', 'lemuelso000@gmail.com', 'guidance', '09562656847', 'Male'),
(150002, 'Valencia', 'Zyrus', NULL, 'lemuelso001@gmail.com', 'finance', '9562656847', 'Male'),
(150003, 'Orencia', 'Ralph', '', 'sol.qcydoqcu@gmail.com', 'registrar', '09562656847', 'Male'),
(150004, 'Layson', 'Jeremy', NULL, 'lemuelso002@gmail.com', 'clinic', '9562656847', 'Male'),
(150007, 'doe', 'john', '', 'test@gmail.com', 'guidance', '09123456789', 'Male'),
(19940301, 'Shapiro', 'Ben', '', 'lemuelkso1@gmail.com', 'Administrative', '09562656847', 'Male');

-- --------------------------------------------------------

--
-- Table structure for table `alumnis`
--

CREATE TABLE `alumnis` (
  `id` int(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `lname` varchar(200) NOT NULL,
  `fname` varchar(200) NOT NULL,
  `mname` varchar(200) DEFAULT NULL,
  `gender` varchar(200) NOT NULL,
  `contact` varchar(200) NOT NULL,
  `location` varchar(200) NOT NULL,
  `course` varchar(200) NOT NULL,
  `section` varchar(200) NOT NULL,
  `address` longtext NOT NULL,
  `year_graduated` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumnis`
--

INSERT INTO `alumnis` (`id`, `email`, `lname`, `fname`, `mname`, `gender`, `contact`, `location`, `course`, `section`, `address`, `year_graduated`) VALUES
(150836, 'test@gmail.com', 'Tiong', 'Jaimes', '', 'Male', '09123456789', 'QC', 'BSIT', '4G', 'San Bartolome Quezon City', 2013),
(150837, 'test.test01@gmail.com', 'Pelomina', 'John Rafael', '', 'Male', '09194804441', 'QC', 'BSIT', '4C', '8 Roxas St. Dona Faustina Nova QC', 1999),
(150877, 'dastdy@gmail.com', 'Dasdsa', 'Dsadasd', '', 'Male', '09123456789', 'QC', 'BSIT', '4E', 'Dasdsa', 2015);

-- --------------------------------------------------------

--
-- Table structure for table `blacklisted`
--

CREATE TABLE `blacklisted` (
  `id` int(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `reason` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `id` int(20) NOT NULL,
  `creator` int(20) NOT NULL,
  `creator_name` varchar(200) NOT NULL,
  `shared_with` longtext DEFAULT NULL,
  `purpose` varchar(200) NOT NULL,
  `problem` longtext NOT NULL,
  `shared_file_from_student` longtext DEFAULT NULL,
  `shared_file_from_advisor` longtext DEFAULT NULL,
  `date_requested` datetime NOT NULL DEFAULT current_timestamp(),
  `date_completed` datetime DEFAULT NULL,
  `schedule` date NOT NULL,
  `start_time` varchar(200) NOT NULL,
  `gmeet_link` varchar(200) DEFAULT NULL,
  `department` varchar(200) NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `adviser_id` int(20) NOT NULL,
  `adviser_name` varchar(200) DEFAULT NULL,
  `status` varchar(200) NOT NULL DEFAULT 'active',
  `remarks` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`id`, `creator`, `creator_name`, `shared_with`, `purpose`, `problem`, `shared_file_from_student`, `shared_file_from_advisor`, `date_requested`, `date_completed`, `schedule`, `start_time`, `gmeet_link`, `department`, `subject`, `adviser_id`, `adviser_name`, `status`, `remarks`) VALUES
(9, 190837, 'Lemuel K So', NULL, '1', 'test', '', NULL, '2023-04-06 23:34:27', NULL, '2023-04-07', '10:30', NULL, 'College of Computer Science and Information Technology', 'ALGO101', 1900001, 'Lalaine Carrao', 'active', NULL),
(10, 190837, 'Lemuel K So', NULL, '1', 'test', '', NULL, '2023-04-07 02:49:37', NULL, '2023-04-10', '8:00', NULL, 'College of Computer Science and Information Technology', 'ALGO101', 1900001, 'Lalaine Carrao', 'active', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `good_moral_requests`
--

CREATE TABLE `good_moral_requests` (
  `id` int(20) NOT NULL,
  `student_id` int(20) NOT NULL,
  `purpose` varchar(200) NOT NULL,
  `other_purpose` varchar(200) DEFAULT NULL,
  `identification_document` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_completed` datetime DEFAULT NULL,
  `status` varchar(200) NOT NULL DEFAULT 'pending',
  `remarks` longtext DEFAULT NULL,
  `type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `good_moral_requests`
--

INSERT INTO `good_moral_requests` (`id`, `student_id`, `purpose`, `other_purpose`, `identification_document`, `date_created`, `date_completed`, `status`, `remarks`, `type`) VALUES
(1, 190837, 'PNP Application', '', '', '2023-03-21 00:02:37', NULL, 'cancelled', NULL, 'student'),
(2, 190837, 'Enrollment / Transfer To Other School', '', '', '2023-03-23 13:17:27', NULL, 'cancelled', NULL, 'student'),
(3, 190837, 'Work / Employment', '', '', '2023-03-23 13:18:28', '2023-03-27 23:19:06', 'completed', '', 'student'),
(4, 150836, 'Masteral / Graduate Studies', '', '', '2023-03-23 13:25:07', NULL, 'pending', NULL, 'alumni');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(20) NOT NULL,
  `consultation_id` int(20) NOT NULL,
  `sender` int(20) NOT NULL,
  `receiver` int(20) NOT NULL,
  `message` longtext NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `is_seen` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `consultation_id`, `sender`, `receiver`, `message`, `datetime`, `is_seen`) VALUES
(1001, 1118, 190837, 1900001, 'Hi', '2023-02-18 17:38:32', 1),
(1002, 1118, 1900001, 190837, 'Hello', '2023-02-18 17:38:32', 1),
(1003, 1118, 1900001, 190837, 'How are you?', '2023-02-19 13:16:31', 1),
(1004, 1118, 1900001, 190837, 'We discuss this already', '2023-02-19 13:21:17', 1),
(1005, 1118, 190837, 1900001, 'I don&#39;t think so', '2023-02-19 16:18:41', 1),
(1006, 1118, 1900001, 190837, 'really?', '2023-02-19 16:21:31', 1),
(1007, 1118, 190837, 1900001, 'yup', '2023-02-19 16:22:36', 1),
(1008, 1118, 190837, 1900001, 'can we discuss it now?', '2023-02-19 16:24:50', 1),
(1013, 1118, 1900001, 190837, 'sure&nbsp;', '2023-02-19 17:30:39', 1),
(1016, 1118, 1900001, 190837, 'hmm.. I&#39;m sorry but something came up', '2023-02-19 17:33:22', 1),
(1017, 1118, 1900001, 190837, 'and I&#39;m afraid I need to cancel our meeting&nbsp;', '2023-02-19 17:34:20', 1),
(1018, 1118, 1900001, 190837, 'is it okay if I move it in saturday', '2023-02-19 17:34:46', 1),
(1019, 1118, 1900001, 190837, 'or moday?', '2023-02-19 17:44:32', 1),
(1020, 1118, 1900001, 190837, '*monday', '2023-02-19 17:44:38', 1),
(1021, 1118, 190837, 1900001, 'let me just check my schedule', '2023-02-19 17:45:27', 1),
(1022, 1118, 1900001, 190837, 'k.', '2023-02-19 17:45:46', 1),
(1023, 1118, 190837, 1900001, 'saturday works :)', '2023-02-19 18:13:39', 1),
(1024, 1118, 1900001, 190837, 'great! what time are you available?', '2023-02-19 18:15:35', 1),
(1025, 1118, 190837, 1900001, 'is 9:AM good?', '2023-02-19 18:26:08', 1),
(1026, 1118, 1900001, 190837, 'it is :)', '2023-02-19 18:28:14', 1),
(1027, 1118, 190837, 1900001, 'great! see you then', '2023-02-19 18:32:00', 1),
(1028, 1118, 1900001, 190837, 'k see you :)', '2023-02-19 18:35:51', 1),
(1029, 1118, 190837, 1900001, 'k.', '2023-02-19 18:38:49', 1),
(1038, 1121, 1900001, 190837, 'good eve', '2023-02-21 21:45:11', 1),
(1039, 1121, 1900001, 190837, 'kindly refer to the notes i uploaded in google classroom', '2023-02-21 21:46:04', 1),
(1040, 1121, 1900001, 190837, 'everything is noted down there', '2023-02-21 21:46:30', 1),
(1041, 1121, 1900001, 190837, 'thank you :)', '2023-02-21 21:46:35', 1),
(1042, 1121, 190837, 1900001, 'got it maam', '2023-02-21 21:48:33', 1),
(1043, 1121, 190837, 1900001, 'thank you!', '2023-02-21 21:48:38', 1),
(1072, 1118, 190837, 1900001, 'test', '2023-02-22 23:00:50', 1),
(1073, 1118, 190837, 1900001, 'test', '2023-02-22 23:02:24', 1),
(1074, 1121, 1900001, 190837, 'okay!', '2023-02-23 01:08:52', 1),
(1075, 1121, 1900001, 190837, 'see you :)', '2023-02-23 01:11:00', 1),
(1076, 1121, 1900001, 190837, 'in the meeting', '2023-02-23 01:11:49', 1),
(1083, 1123, 150001, 190837, 'I&#39;ll sched an online meeting for both of us to address your issue', '2023-02-24 22:38:15', 1),
(1084, 1123, 190837, 150001, 'okay :)', '2023-02-24 22:48:29', 1),
(1085, 1123, 190837, 150001, 'sir ?', '2023-02-27 01:02:34', 1),
(1086, 1127, 150001, 190837, 'hi', '2023-02-27 13:31:37', 1),
(1087, 1123, 150001, 190837, 'test', '2023-02-27 17:54:35', 1),
(1088, 1123, 190837, 150001, 'test', '2023-02-27 17:55:01', 1),
(1089, 1123, 150001, 190837, 'test', '2023-02-27 17:55:18', 1),
(1090, 1123, 190837, 150001, 'test', '2023-02-27 17:55:28', 1),
(1091, 1123, 190837, 150001, 'test', '2023-02-27 17:56:00', 1),
(1092, 1127, 190837, 150001, 'test', '2023-02-27 17:56:26', 1),
(1093, 1123, 190837, 150001, 'test', '2023-02-27 17:56:44', 1),
(1094, 1123, 190837, 150001, 'test', '2023-02-28 17:21:13', 1),
(1095, 1123, 190837, 150001, 'test&nbsp;', '2023-02-28 17:22:05', 1),
(1096, 1123, 150001, 190837, 'test', '2023-02-28 17:47:45', 1),
(1097, 1123, 150001, 190837, 'test', '2023-02-28 17:49:44', 1),
(1098, 1123, 150001, 190837, 'test', '2023-02-28 18:12:24', 1),
(1099, 1123, 190837, 150001, 'test', '2023-02-28 18:17:36', 1),
(1100, 1123, 150001, 190837, 'test', '2023-02-28 18:17:50', 1),
(1101, 1124, 190837, 1900001, 'test', '2023-02-28 23:47:51', 1),
(1102, 1124, 190837, 1900001, 'test', '2023-03-01 00:10:16', 1),
(1103, 1118, 190837, 1900001, 'test', '2023-03-01 00:10:27', 1),
(1104, 1128, 190837, 150001, 'hi', '2023-03-02 18:13:25', 1),
(1105, 1124, 190837, 1900001, 'test', '2023-03-02 22:20:59', 1),
(1106, 1128, 190837, 150001, '', '2023-03-04 11:21:24', 1),
(1107, 1128, 190837, 150001, '', '2023-03-04 11:21:51', 1),
(1108, 1124, 190837, 1900001, 'test', '2023-03-04 11:43:35', 1),
(1109, 1128, 150001, 190837, 'kamusta', '2023-03-04 19:06:11', 1),
(1110, 1128, 150001, 190837, 'sana ok kalang', '2023-03-04 19:06:26', 1),
(1111, 1129, 190837, 150001, 'hi', '2023-03-05 01:46:47', 1),
(1112, 1129, 150001, 190837, 'test', '2023-03-05 01:46:53', 1),
(1128, 1124, 190837, 1900001, 'test', '2023-03-10 00:31:17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `professors`
--

CREATE TABLE `professors` (
  `id` int(20) NOT NULL,
  `lname` varchar(200) NOT NULL,
  `fname` varchar(200) NOT NULL,
  `mname` varchar(200) DEFAULT NULL,
  `department` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(200) NOT NULL,
  `gender` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `professors`
--

INSERT INTO `professors` (`id`, `lname`, `fname`, `mname`, `department`, `email`, `contact`, `gender`) VALUES
(1900001, 'Carrao', 'Lalaine', '', 'College of Computer Science And Information Technology', 'lemuelso002@gmail.com', '09562656847', 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `advisor` varchar(200) NOT NULL,
  `monday` varchar(200) DEFAULT NULL,
  `tuesday` varchar(200) DEFAULT NULL,
  `wednesday` varchar(200) DEFAULT NULL,
  `thursday` varchar(200) DEFAULT NULL,
  `friday` varchar(200) DEFAULT NULL,
  `saturday` varchar(200) DEFAULT NULL,
  `sunday` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`advisor`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`) VALUES
('1900001', '8:00,8:30,9:00,9:30', '8:00,11:00,11:30,16:30,17:00', NULL, '10:30,11:00,11:30,12:00,12:30', '10:30,16:00,16:30,17:00,17:30,18:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `soa_requests`
--

CREATE TABLE `soa_requests` (
  `id` int(20) NOT NULL,
  `student_id` int(20) NOT NULL,
  `purpose` varchar(200) NOT NULL,
  `other_purpose` varchar(200) DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `date_completed` datetime DEFAULT NULL,
  `status` varchar(200) NOT NULL DEFAULT 'pending',
  `remarks` longtext DEFAULT NULL,
  `requested_document` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `soa_requests`
--

INSERT INTO `soa_requests` (`id`, `student_id`, `purpose`, `other_purpose`, `date_created`, `date_completed`, `status`, `remarks`, `requested_document`) VALUES
(1, 190837, 'Masteral / Graduate Studies', '', '2023-03-21 00:01:30', NULL, 'cancelled', NULL, 'soa'),
(2, 190837, 'Masteral / Graduate Studies', '', '2023-03-21 00:01:34', NULL, 'completed', '', 'soa'),
(3, 190837, 'Enrollment / Transfer To Other School', '', '2023-03-21 00:01:59', NULL, 'cancelled', '', 'order of payment'),
(4, 190837, 'Enrollment / Transfer To Other School', '', '2023-03-23 13:17:50', NULL, 'cancelled', NULL, 'soa'),
(5, 190837, 'Enrollment / Transfer To Other School', '', '2023-03-23 13:19:53', NULL, 'pending', NULL, 'soa');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(20) NOT NULL,
  `email` varchar(200) NOT NULL,
  `lname` varchar(200) NOT NULL,
  `fname` varchar(200) NOT NULL,
  `mname` varchar(200) DEFAULT NULL,
  `gender` varchar(200) NOT NULL,
  `contact` varchar(200) NOT NULL,
  `location` varchar(200) NOT NULL,
  `course` varchar(200) NOT NULL,
  `section` varchar(200) NOT NULL,
  `year` int(3) NOT NULL,
  `address` varchar(200) NOT NULL,
  `type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `email`, `lname`, `fname`, `mname`, `gender`, `contact`, `location`, `course`, `section`, `year`, `address`, `type`) VALUES
(190835, 'dsppoop@gmail.com', 'Dasdas', 'Dasdasd', '', 'Male', '09123456789', 'QC', 'BSIT', '1E', 1, 'Sdfdsfsd', 'REGULAR'),
(190837, 'lemuel.k.costuna.so@gmail.com', 'So', 'Lemuel k', 'Costuna', 'Male', '09562656847', 'QC', 'bsit', '4C', 4, '8 Roxas St. Dona Faustine Novaliches Quezon City', 'regular');

-- --------------------------------------------------------

--
-- Table structure for table `subject_codes`
--

CREATE TABLE `subject_codes` (
  `id` int(20) NOT NULL,
  `code` varchar(200) NOT NULL,
  `department` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_codes`
--

INSERT INTO `subject_codes` (`id`, `code`, `department`) VALUES
(1111, 'ALGO101', 'College of Computer Science And Information Technology');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `pass` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `type` varchar(200) NOT NULL DEFAULT 'student',
  `pic` varchar(200) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `remarks` longtext DEFAULT '',
  `status` varchar(200) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `pass`, `email`, `type`, `pic`, `createdAt`, `remarks`, `status`) VALUES
(150001, '$2y$10$j.FJDQ6Smo6NzuX9SyWpA.LF9hjxrl/hexxXQpF29vIZroEx74Hpa', 'lemuelso000@gmail.com', 'guidance', '', '2023-01-26 18:52:38', '', 'active'),
(150002, '$2y$10$j.FJDQ6Smo6NzuX9SyWpA.LF9hjxrl/hexxXQpF29vIZroEx74Hpa', 'lemuelso001@gmail.com', 'finance', '', '2023-01-26 18:54:47', '', 'active'),
(150003, '$2y$10$j.FJDQ6Smo6NzuX9SyWpA.LF9hjxrl/hexxXQpF29vIZroEx74Hpa', 'sol.qcydoqcu@gmail.com', 'registrar', '', '2023-01-26 18:54:47', '', 'active'),
(150004, '$2y$10$j.FJDQ6Smo6NzuX9SyWpA.LF9hjxrl/hexxXQpF29vIZroEx74Hpa', 'lemuelso002@gmail.com', 'clinic', '', '2023-01-26 18:52:38', '', 'active'),
(150007, '$2y$10$U/J2oVFsi.C95LYGHvMQ/eZp.qhRK/66jez/dtoxHQCH73w.LlB8O', 'testtest@gmail.com', 'guidance', '', '2023-03-28 02:15:48', '', 'active'),
(150836, '$2y$10$j.FJDQ6Smo6NzuX9SyWpA.LF9hjxrl/hexxXQpF29vIZroEx74Hpa', 'test@gmail.com', 'alumni', '', '2023-03-17 18:08:59', '', 'active'),
(150837, '$2y$10$j.FJDQ6Smo6NzuX9SyWpA.LF9hjxrl/hexxXQpF29vIZroEx74Hpa', 'test.test01@gmail.com', 'alumni', '', '2023-03-17 18:09:38', '', 'active'),
(150877, '$2y$10$8wIGo3Aj0COC1NKQDMRizeKzAnceC6B7/milXIYA4C9QhrM1AcI1W', 'dastdy@gmail.com', 'alumni', '', '2023-03-31 00:49:20', '', 'active'),
(190835, '$2y$10$maj.nhPjI3SN7q42T/1nveKftDXfKT0R2BYINl2QUus0KoYzcin1G', 'dsppoop@gmail.com', 'student', '', '2023-03-31 00:18:58', '', 'active'),
(190837, '$2y$10$oIdjoPA05Bn7GgkP84b2ker15ARYwS9dOp5VtMqCtQWAHtqzF0YkO', 'lemuel.k.costuna.so@gmail.com', 'student', '/public/assets/document/1x1.JPG', '2023-01-25 22:20:45', '', 'active'),
(1900001, '$2y$10$j.FJDQ6Smo6NzuX9SyWpA.LF9hjxrl/hexxXQpF29vIZroEx74Hpa', 'lemuelso003@gmail.com', 'professor', '', '2023-01-26 21:24:11', '', 'active'),
(19940301, '$2y$10$j.FJDQ6Smo6NzuX9SyWpA.LF9hjxrl/hexxXQpF29vIZroEx74Hpa', 'lemuelkso1@gmail.com', 'sysadmin', '', '2023-03-11 11:34:34', '', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_document_requests`
--
ALTER TABLE `academic_document_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alumnis`
--
ALTER TABLE `alumnis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blacklisted`
--
ALTER TABLE `blacklisted`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `good_moral_requests`
--
ALTER TABLE `good_moral_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `professors`
--
ALTER TABLE `professors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`advisor`);

--
-- Indexes for table `soa_requests`
--
ALTER TABLE `soa_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_codes`
--
ALTER TABLE `subject_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic_document_requests`
--
ALTER TABLE `academic_document_requests`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=361;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `good_moral_requests`
--
ALTER TABLE `good_moral_requests`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1129;

--
-- AUTO_INCREMENT for table `soa_requests`
--
ALTER TABLE `soa_requests`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subject_codes`
--
ALTER TABLE `subject_codes`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1112;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
