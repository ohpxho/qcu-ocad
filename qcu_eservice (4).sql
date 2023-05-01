-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2023 at 06:45 AM
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
  `student_id` varchar(200) NOT NULL,
  `is_diploma_included` int(2) NOT NULL,
  `diploma_year_graduated` varchar(200) DEFAULT NULL,
  `is_honorable_dismissal_included` int(2) DEFAULT NULL,
  `quantity` int(20) NOT NULL,
  `status` varchar(200) NOT NULL DEFAULT 'pending',
  `date_created` datetime DEFAULT NULL,
  `date_completed` datetime DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `price` decimal(20,2) NOT NULL,
  `type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic_document_requests`
--

INSERT INTO `academic_document_requests` (`id`, `is_tor_included`, `tor_last_academic_year_attended`, `gradeslip_academic_year`, `gradeslip_semester`, `is_gradeslip_included`, `is_ctc_included`, `ctc_document`, `other_requested_document`, `purpose_of_request`, `is_RA11261_beneficiary`, `barangay_certificate`, `oath_of_undertaking`, `student_id`, `is_diploma_included`, `diploma_year_graduated`, `is_honorable_dismissal_included`, `quantity`, `status`, `date_created`, `date_completed`, `remarks`, `price`, `type`) VALUES
(1, 0, NULL, '2023-2024', '1', 1, 0, '', '', 'for employment', '', NULL, NULL, '19-0837', 0, NULL, NULL, 2, 'cancelled', '2023-04-21 09:31:58', '2023-04-21 09:36:21', NULL, '0.00', 'student'),
(2, 0, NULL, '2017-2018', '1', 1, 0, '', '', 'tset', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'completed', '2023-04-21 19:21:13', '2023-04-22 18:37:57', '', '0.00', 'student'),
(3, 0, NULL, '2022-2023', '2', 1, 0, '', '', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'completed', '2023-04-22 18:39:50', '2023-04-22 23:26:37', '', '0.00', 'student'),
(5, 0, NULL, '2022-2023', '2', 1, 0, '', '', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'completed', '2023-04-23 01:22:29', '2023-04-23 02:34:09', '', '200.00', 'student'),
(6, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'completed', '2023-04-23 01:49:23', '2023-04-23 02:34:12', '', '151.50', 'student'),
(7, 0, NULL, '2022-2023', '2', 1, 0, '', '', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'completed', '2023-04-23 03:37:38', '2023-04-23 03:42:39', '', '100.00', 'student'),
(9, 0, NULL, '2022-2023', '2', 1, 0, '', '', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'cancelled', '2023-04-29 11:54:15', '2023-04-29 16:34:13', NULL, '0.00', 'student'),
(10, 1, '2012-2013', NULL, NULL, 0, 0, NULL, NULL, 'test', 'no', '', '', '15-0836', 0, '', 0, 1, 'cancelled', '2023-04-29 17:44:12', '2023-04-29 17:44:26', NULL, '0.00', 'alumni'),
(11, 0, NULL, '2023-2024', '1', 1, 0, '', '', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'cancelled', '2023-04-30 02:54:21', '2023-04-30 03:50:19', NULL, '0.00', 'student'),
(12, 0, NULL, '', '', 0, 0, '', 'test', 'rtse', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'cancelled', '2023-04-30 03:31:51', '2023-04-30 03:32:54', NULL, '0.00', 'student'),
(13, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'cancelled', '2023-04-30 03:49:46', '2023-04-30 03:52:46', NULL, '0.00', 'student'),
(14, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'cancelled', '2023-04-30 03:50:37', '2023-04-30 03:53:48', NULL, '0.00', 'student'),
(15, 0, NULL, '2023-2024', '2', 1, 0, '', '', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'rejected', '2023-04-30 03:52:59', '2023-04-30 04:05:13', '', '0.00', 'student'),
(16, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'rejected', '2023-04-30 03:53:54', '2023-04-30 04:05:16', '', '0.00', 'student'),
(17, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'rejected', '2023-04-30 03:54:04', '2023-04-30 04:05:19', '', '0.00', 'student'),
(18, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'rejected', '2023-04-30 03:54:45', '2023-04-30 04:05:22', '', '0.00', 'student'),
(19, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'rejected', '2023-04-30 03:55:27', '2023-04-30 04:05:24', '', '0.00', 'student'),
(20, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'rejected', '2023-04-30 03:56:49', '2023-04-30 04:05:27', '', '0.00', 'student'),
(21, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'rejected', '2023-04-30 03:57:03', '2023-04-30 04:05:30', '', '0.00', 'student'),
(22, 0, NULL, '', '', 0, 0, '', 'test', 'tes', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'cancelled', '2023-04-30 04:07:30', '2023-04-30 04:56:02', NULL, '0.00', 'student'),
(23, 0, NULL, '', '', 0, 0, '', 'test', 'tes', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'cancelled', '2023-04-30 04:09:01', '2023-04-30 09:10:43', NULL, '0.00', 'student'),
(24, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'cancelled', '2023-04-30 04:10:41', '2023-04-30 09:11:06', NULL, '0.00', 'student'),
(25, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'cancelled', '2023-04-30 04:10:47', '2023-04-30 09:11:19', NULL, '0.00', 'student'),
(26, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'cancelled', '2023-04-30 04:10:53', '2023-04-30 09:10:50', NULL, '0.00', 'student'),
(27, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'rejected', '2023-04-30 04:12:44', '2023-04-30 09:22:33', '', '0.00', 'student'),
(28, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'rejected', '2023-04-30 04:12:49', '2023-04-30 09:23:14', '', '0.00', 'student'),
(29, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'cancelled', '2023-04-30 04:13:04', '2023-04-30 04:56:50', NULL, '0.00', 'student'),
(30, 0, NULL, '2014-2015', '1', 1, 0, '', '', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'rejected', '2023-04-30 04:13:15', '2023-04-30 09:29:55', '', '0.00', 'student'),
(31, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'rejected', '2023-04-30 04:36:59', '2023-04-30 09:30:44', '', '0.00', 'student'),
(32, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'rejected', '2023-04-30 04:37:42', '2023-04-30 09:33:38', '', '0.00', 'student'),
(33, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'rejected', '2023-04-30 04:39:17', '2023-04-30 09:33:51', '', '0.00', 'student'),
(34, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'cancelled', '2023-04-30 04:40:04', '2023-04-30 09:34:59', NULL, '0.00', 'student'),
(35, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'cancelled', '2023-04-30 04:41:10', '2023-04-30 09:34:46', NULL, '0.00', 'student'),
(36, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'cancelled', '2023-04-30 04:41:23', '2023-04-30 09:35:07', '', '0.00', 'student'),
(37, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'completed', '2023-04-30 04:44:44', '2023-04-30 10:23:31', '', '0.00', 'student'),
(38, 0, NULL, '', '', 0, 0, '', 'test', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'for process', '2023-04-30 04:55:52', '2023-04-30 10:24:23', '', '200.00', 'student'),
(39, 0, NULL, '', '', 0, 0, '', 'test', 'tsetes', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'rejected', '2023-04-30 09:10:22', '2023-04-30 09:23:52', '', '0.00', 'student'),
(40, 0, NULL, '', '', 0, 0, '', 'TEST', 'TEST', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'rejected', '2023-04-30 09:41:22', '2023-04-30 10:23:44', '', '0.00', 'student'),
(41, 0, NULL, '', '', 0, 0, '', 'TEST', 'TEST', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'cancelled', '2023-04-30 09:41:24', '2023-04-30 09:44:03', NULL, '0.00', 'student'),
(42, 0, NULL, '', '', 0, 0, '', 'TEST', 'TEST', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'for process', '2023-04-30 09:41:26', '2023-05-01 10:12:56', '', '0.00', 'student'),
(43, 0, '', NULL, NULL, 0, 0, NULL, NULL, 'test', 'no', '', '', '15-0836', 1, '2021', 0, 1, 'cancelled', '2023-04-30 10:34:25', '2023-04-30 10:34:33', NULL, '0.00', 'alumni'),
(44, 0, '', NULL, NULL, 0, 0, NULL, NULL, 'test', 'no', '', '', '15-0836', 1, '2021', 0, 1, 'for process', '2023-04-30 10:35:09', NULL, '', '0.00', 'alumni'),
(45, 0, '', NULL, NULL, 0, 0, NULL, NULL, 'test', 'no', '', '', '15-0836', 0, '', 1, 1, 'cancelled', '2023-04-30 10:36:48', '2023-04-30 10:37:30', NULL, '0.00', 'alumni'),
(46, 1, '2020-2021', NULL, NULL, 0, 0, NULL, NULL, 'test', 'no', '', '', '15-0836', 0, '', 0, 1, 'for process', '2023-04-30 10:37:04', NULL, '', '200.00', 'alumni'),
(49, 0, NULL, '2022-2023', '2', 1, 0, '', '', 'test', '', NULL, NULL, '19-0837', 0, NULL, NULL, 1, 'awaiting payment confirmation', '2023-05-01 10:46:07', NULL, '', '200.75', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) NOT NULL,
  `actor` varchar(200) NOT NULL,
  `action` varchar(200) NOT NULL,
  `date_acted` datetime NOT NULL DEFAULT current_timestamp(),
  `description` longtext NOT NULL,
  `name` varchar(200) NOT NULL,
  `type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `actor`, `action`, `date_acted`, `description`, `name`, `type`) VALUES
(1, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 02:54:21', 'created new academic document request', 'Lemuel So', 'student'),
(2, '19940301', 'USER_ACCOUNT', '2023-04-30 03:00:40', 'updated student account', 'Been Shapiro', 'sysadmin'),
(3, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 03:31:51', 'created new academic document request', 'Lemuel So', 'student'),
(4, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 03:49:46', 'created new academic document request', 'Lemuel So', 'student'),
(5, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 03:50:19', 'cancelled an academic document request', 'Lemuel So', 'student'),
(6, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 03:50:37', 'created new academic document request', 'Lemuel So', 'student'),
(7, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 03:52:46', 'cancelled an academic document request', 'Lemuel So', 'student'),
(8, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 03:52:59', 'created new academic document request', 'Lemuel So', 'student'),
(9, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 03:53:48', 'cancelled an academic document request', 'Lemuel So', 'student'),
(10, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 03:53:54', 'created new academic document request', 'Lemuel So', 'student'),
(11, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 03:54:04', 'created new academic document request', 'Lemuel So', 'student'),
(12, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 03:54:45', 'created new academic document request', 'Lemuel So', 'student'),
(13, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 03:55:27', 'created new academic document request', 'Lemuel So', 'student'),
(14, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 03:56:49', 'created new academic document request', 'Lemuel So', 'student'),
(15, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 03:57:03', 'created new academic document request', 'Lemuel So', 'student'),
(16, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:05:13', 'updated multiple academic document request', 'Ralph Orencia', 'registrar'),
(17, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:05:16', 'updated multiple academic document request', 'Ralph Orencia', 'registrar'),
(18, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:05:19', 'updated multiple academic document request', 'Ralph Orencia', 'registrar'),
(19, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:05:22', 'updated multiple academic document request', 'Ralph Orencia', 'registrar'),
(20, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:05:24', 'updated multiple academic document request', 'Ralph Orencia', 'registrar'),
(21, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:05:27', 'updated multiple academic document request', 'Ralph Orencia', 'registrar'),
(22, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:05:30', 'updated multiple academic document request', 'Ralph Orencia', 'registrar'),
(23, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:07:30', 'created new academic document request', 'Lemuel So', 'student'),
(24, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:09:01', 'created new academic document request', 'Lemuel So', 'student'),
(25, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:10:41', 'created new academic document request', 'Lemuel So', 'student'),
(26, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:10:47', 'created new academic document request', 'Lemuel So', 'student'),
(27, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:10:53', 'created new academic document request', 'Lemuel So', 'student'),
(28, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:12:44', 'created new academic document request', 'Lemuel So', 'student'),
(29, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:12:49', 'created new academic document request', 'Lemuel So', 'student'),
(30, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:13:04', 'created new academic document request', 'Lemuel So', 'student'),
(31, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:13:15', 'created new academic document request', 'Lemuel So', 'student'),
(32, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:36:59', 'created new academic document request', 'Lemuel So', 'student'),
(33, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:37:42', 'created new academic document request', 'Lemuel So', 'student'),
(34, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:39:17', 'created new academic document request', 'Lemuel So', 'student'),
(35, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:40:04', 'created new academic document request', 'Lemuel So', 'student'),
(36, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:41:10', 'created new academic document request', 'Lemuel So', 'student'),
(37, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:41:23', 'created new academic document request', 'Lemuel So', 'student'),
(38, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:44:44', 'created new academic document request', 'Lemuel So', 'student'),
(39, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:55:52', 'created new academic document request', 'Lemuel So', 'student'),
(40, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:56:02', 'cancelled an academic document request', 'Lemuel So', 'student'),
(41, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:56:36', 'updated an academic document request', 'Lemuel So', 'student'),
(42, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 04:56:50', 'cancelled an academic document request', 'Lemuel So', 'student'),
(43, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:10:22', 'created new academic document request', 'Lemuel So', 'student'),
(44, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:10:43', 'cancelled an academic document request', 'Lemuel So', 'student'),
(45, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:10:50', 'cancelled an academic document request', 'Lemuel So', 'student'),
(46, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:11:00', 'updated an academic document request', 'Lemuel So', 'student'),
(47, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:11:06', 'cancelled an academic document request', 'Lemuel So', 'student'),
(48, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:11:19', 'cancelled an academic document request', 'Lemuel So', 'student'),
(49, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:22:33', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(50, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:23:14', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(51, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:23:52', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(52, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:29:56', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(53, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:30:44', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(54, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:32:34', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(55, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:33:38', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(56, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:33:51', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(57, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:34:46', 'cancelled an academic document request', 'Lemuel So', 'student'),
(58, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:34:59', 'cancelled an academic document request', 'Lemuel So', 'student'),
(59, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:35:07', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(60, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:39:24', 'updated multiple academic document request', 'Ralph Orencia', 'registrar'),
(61, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:39:27', 'updated multiple academic document request', 'Ralph Orencia', 'registrar'),
(62, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:41:22', 'created new academic document request', 'Lemuel So', 'student'),
(63, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:41:24', 'created new academic document request', 'Lemuel So', 'student'),
(64, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:41:26', 'created new academic document request', 'Lemuel So', 'student'),
(65, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:43:47', 'updated multiple academic document request', 'Ralph Orencia', 'registrar'),
(66, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:43:50', 'updated multiple academic document request', 'Ralph Orencia', 'registrar'),
(67, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 09:44:03', 'cancelled an academic document request', 'Lemuel So', 'student'),
(68, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:09:16', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(69, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:10:28', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(70, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:11:37', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(71, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:11:58', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(72, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:16:00', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(73, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:16:40', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(74, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:16:51', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(75, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:17:35', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(76, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:17:53', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(77, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:19:54', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(78, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:21:02', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(79, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:21:17', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(80, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:23:31', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(81, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:23:44', 'updated multiple academic document request', 'Ralph Orencia', 'registrar'),
(82, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:23:46', 'updated multiple academic document request', 'Ralph Orencia', 'registrar'),
(83, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:24:10', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(84, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:24:23', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(85, '19940301', 'USER_ACCOUNT', '2023-04-30 10:30:31', 'opened an account', 'Been Shapiro', 'sysadmin'),
(86, '15-0836', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:34:25', 'created new academic document request', 'Fdsaf Fsdf', 'alumni'),
(87, '15-0836', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:34:33', 'cancelled an academic document request', 'Fdsaf Fsdf', 'alumni'),
(88, '15-0836', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:35:09', 'created new academic document request', 'Fdsaf Fsdf', 'alumni'),
(89, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:35:38', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(90, '15-0836', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:36:48', 'created new academic document request', 'Fdsaf Fsdf', 'alumni'),
(91, '15-0836', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:37:04', 'created new academic document request', 'Fdsaf Fsdf', 'alumni'),
(92, '15-0836', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:37:30', 'cancelled an academic document request', 'Fdsaf Fsdf', 'alumni'),
(93, '15-0836', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:37:39', 'created new academic document request', 'Fdsaf Fsdf', 'alumni'),
(94, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:38:18', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(95, '15-0836', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:38:27', 'confirmed payment for requesting an academic document', 'Fdsaf Fsdf', 'alumni'),
(96, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:39:13', 'created new academic document request', 'Lemuel So', 'student'),
(97, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:39:27', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(98, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-04-30 10:46:46', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(99, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:01:33', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(100, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:01:48', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(101, '19-0837', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:01:57', 'created new good moral document request', 'Lemuel So', 'student'),
(102, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:02:07', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(103, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:02:46', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(104, '19-0837', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:02:53', 'created new good moral document request', 'Lemuel So', 'student'),
(105, '19-0837', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:04:00', 'cancelled a good moral document request', 'Lemuel So', 'student'),
(106, '19-0837', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:06:09', 'cancelled a good moral document request', 'Lemuel So', 'student'),
(107, '19-0837', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:06:17', 'created new good moral document request', 'Lemuel So', 'student'),
(108, '19-0837', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:07:14', 'cancelled a good moral document request', 'Lemuel So', 'student'),
(109, '19-0837', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:07:55', 'created new good moral document request', 'Lemuel So', 'student'),
(110, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:08:32', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(111, '19-0837', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:08:37', 'confirmed payment for requesting a good moral certificate', 'Lemuel So', 'student'),
(112, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:12:26', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(113, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:14:05', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(114, '19-0837', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:14:14', 'created new good moral document request', 'Lemuel So', 'student'),
(115, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:16:27', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(116, '15-0836', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:17:00', 'created new good moral document request', 'Fdsaf Fsdf', 'alumni'),
(117, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:17:12', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(118, '15-0836', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:17:16', 'confirmed payment for requesting a good moral certificate', 'Fdsaf Fsdf', 'alumni'),
(119, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:17:29', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(120, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-04-30 11:17:37', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(121, '19-0837', 'SOA_DOCUMENT_REQUEST', '2023-04-30 11:55:17', 'cancelled a student account document request', 'Lemuel So', 'student'),
(122, '19-0837', 'SOA_DOCUMENT_REQUEST', '2023-04-30 11:55:24', 'created new student account document request', 'Lemuel So', 'student'),
(123, '19-0837', 'SOA_DOCUMENT_REQUEST', '2023-04-30 11:56:21', 'created new student account document request', 'Lemuel So', 'student'),
(124, '150002', 'SOA_DOCUMENT_REQUEST', '2023-04-30 11:56:31', 'updated a student account document request', 'Zyrus Valencia', 'finance'),
(125, '19-0837', 'SOA_DOCUMENT_REQUEST', '2023-04-30 11:56:38', 'confirmed payment for requesting a student account document', 'Lemuel So', 'student'),
(126, '150002', 'SOA_DOCUMENT_REQUEST', '2023-04-30 11:56:49', 'updated a student account document request', 'Zyrus Valencia', 'finance'),
(127, '150002', 'SOA_DOCUMENT_REQUEST', '2023-04-30 11:57:08', 'updated a student account document request', 'Zyrus Valencia', 'finance'),
(128, '150002', 'SOA_DOCUMENT_REQUEST', '2023-04-30 11:57:17', 'updated a student account document request', 'Zyrus Valencia', 'finance'),
(129, '1900001', 'CONSULTATION', '2023-04-30 11:59:40', 'resolved a consultation', 'Lalaine Carrao', 'professor'),
(130, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-05-01 07:40:34', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(131, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-05-01 07:40:53', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(132, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-05-01 07:41:04', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(133, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-05-01 07:44:12', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(134, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-05-01 07:44:28', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(135, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-05-01 07:44:39', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(136, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-05-01 07:45:40', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(137, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-05-01 07:47:22', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(138, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-05-01 07:57:43', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(139, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-05-01 08:01:38', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(140, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-05-01 08:04:15', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(141, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-05-01 08:04:36', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(142, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-05-01 08:05:13', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(143, '150001', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-05-01 08:20:04', 'updated a good moral document request', 'John Rey Aruta', 'guidance'),
(144, '150002', 'SOA_DOCUMENT_REQUEST', '2023-05-01 09:24:07', 'updated a student account document request', 'Zyrus Valencia', 'finance'),
(145, '19940301', 'SOA_DOCUMENT_REQUEST', '2023-05-01 09:24:49', 'deleted a student account document request', 'Been Shapiro', 'sysadmin'),
(146, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-05-01 10:12:56', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(147, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-05-01 10:13:06', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(148, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-05-01 10:13:30', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(149, '19940301', 'ACADEMIC_DOCUMENT_REQUEST', '2023-05-01 10:14:05', 'deleted an academic document request', 'Been Shapiro', 'sysadmin'),
(150, '19940301', 'ACADEMIC_DOCUMENT_REQUEST', '2023-05-01 10:14:10', 'deleted an academic document request', 'Been Shapiro', 'sysadmin'),
(151, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-05-01 10:14:33', 'confirmed payment for requesting an academic document', 'Lemuel So', 'student'),
(152, '19-0837', 'GOOD_MORAL_DOCUMENT_REQUEST', '2023-05-01 10:14:37', 'confirmed payment for requesting a good moral certificate', 'Lemuel So', 'student'),
(153, '1900001', 'SCHEDULE', '2023-05-01 10:18:10', 'updated a schedule', 'Lalaine Carrao', 'professor'),
(154, '1900001', 'SCHEDULE', '2023-05-01 10:18:18', 'updated a schedule', 'Lalaine Carrao', 'professor'),
(155, '1900001', 'SCHEDULE', '2023-05-01 10:18:37', 'updated a schedule', 'Lalaine Carrao', 'professor'),
(156, '1900001', 'SCHEDULE', '2023-05-01 10:18:42', 'updated a schedule', 'Lalaine Carrao', 'professor'),
(157, '1900001', 'SCHEDULE', '2023-05-01 10:18:51', 'updated a schedule', 'Lalaine Carrao', 'professor'),
(158, '1900001', 'SCHEDULE', '2023-05-01 10:22:46', 'set availability of specific date', 'Lalaine Carrao', 'professor'),
(159, '1900001', 'SCHEDULE', '2023-05-01 10:37:56', 'set availability of specific date', 'Lalaine Carrao', 'professor'),
(160, '19-0837', 'ACADEMIC_DOCUMENT_REQUEST', '2023-05-01 10:46:07', 'created new academic document request', 'Lemuel So', 'student'),
(161, '150003', 'ACADEMIC_DOCUMENT_REQUEST', '2023-05-01 10:46:40', 'updated an academic document request', 'Ralph Orencia', 'registrar'),
(162, '19940301', 'USER_ACCOUNT', '2023-05-01 11:06:33', 'deleted an account', 'Been Shapiro', 'sysadmin'),
(163, '19940301', 'USER_ACCOUNT', '2023-05-01 11:07:16', 'added new admin account', 'Been Shapiro', 'sysadmin'),
(164, '19940301', 'USER_ACCOUNT', '2023-05-01 11:10:51', 'deleted an account', 'Been Shapiro', 'sysadmin'),
(165, '19940301', 'USER_ACCOUNT', '2023-05-01 11:10:57', 'added new student account', 'Been Shapiro', 'sysadmin'),
(166, '19940301', 'USER_ACCOUNT', '2023-05-01 11:11:27', 'deleted an account', 'Been Shapiro', 'sysadmin');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` varchar(200) NOT NULL,
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
('150001', 'Aruta', 'John Rey', 'Miles', 'lemuelso000@gmail.com', 'guidance', '09562656847', 'Male'),
('150002', 'Valencia', 'Zyrus', '', 'lemuelso001@gmail.com', 'finance', '09562656847', 'Male'),
('150003', 'Orencia', 'Ralph', '', 'sol.qcydoqcu@gmail.com', 'registrar', '09562656847', 'Male'),
('150004', 'Layson', 'Jeremy', '', 'lemuelso002@gmail.com', 'clinic', '09562656847', 'Male'),
('150007', 'doe', 'john', '', 'test@gmail.com', 'guidance', '09123456789', 'Male'),
('150011', 'asdas', 'dsad', 'dasd', 'guzmanossom@gmail.com', 'guidance', '09124556789', 'Male'),
('19940301', 'Shapiro', 'Been', '', 'lemuelkso1@gmail.com', 'Administrative', '09562656847', 'MALE');

-- --------------------------------------------------------

--
-- Table structure for table `alumnis`
--

CREATE TABLE `alumnis` (
  `id` varchar(200) NOT NULL,
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
('15-0836', 'fsdfddd@gmail.com', 'Fsdf', 'Fdsaf', '', 'Male', '09122456789', 'QC', 'BSIT', '4E', 'Sadasd', 2021);

-- --------------------------------------------------------

--
-- Table structure for table `availabilities`
--

CREATE TABLE `availabilities` (
  `id` int(20) NOT NULL,
  `advisor` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `timeslots` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `availabilities`
--

INSERT INTO `availabilities` (`id`, `advisor`, `date`, `timeslots`) VALUES
(1, '1900001', '2023-04-08', '8:30,9:00'),
(2, '1900001', '2023-04-13', '11:00,11:30,12:00,12:30'),
(3, '1900001', '2023-04-14', '16:00,16:30,17:00,17:30,18:00'),
(5, 'guidance', '2023-04-10', '8:00,8:30,9:00,9:30,10:00,13:30,15:00'),
(6, 'guidance', '2023-04-18', '8:00,8:30,9:00,9:30,10:00,10:30,11:00,11:30,12:00,12:30,14:00,14:30,15:00,16:30,17:00,17:30'),
(7, '1900001', '2023-05-08', '10:30,11:30,12:30');

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
  `creator` varchar(200) NOT NULL,
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
  `adviser_id` varchar(200) NOT NULL,
  `adviser_name` varchar(200) DEFAULT NULL,
  `status` varchar(200) NOT NULL DEFAULT 'pending',
  `mode` varchar(200) NOT NULL,
  `remarks` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`id`, `creator`, `creator_name`, `shared_with`, `purpose`, `problem`, `shared_file_from_student`, `shared_file_from_advisor`, `date_requested`, `date_completed`, `schedule`, `start_time`, `gmeet_link`, `department`, `subject`, `adviser_id`, `adviser_name`, `status`, `mode`, `remarks`) VALUES
(4, '19-0837', 'Lemuel So', NULL, '7', 'test', '', NULL, '2023-04-21 13:14:41', '2023-04-21 13:22:42', '2023-04-24', '8:30', NULL, 'Guidance', '', '150001', 'John Aruta', 'resolved', 'online', ''),
(5, '19-0837', 'Lemuel So', NULL, '9', 'test', '/public/assets/document/QCU OCAD (1).xlsx', NULL, '2023-04-21 13:36:46', NULL, '2023-05-01', '8:30', NULL, 'Clinic', '', '150004', 'Jeremy Layson', 'active', 'online', ''),
(6, '19-0837', 'Lemuel So', NULL, '7', 'test', '', '', '2023-04-21 16:53:49', '2023-04-24 13:09:44', '2023-04-24', '9:30', NULL, 'Guidance', '', '150001', 'John Aruta', 'resolved', 'online', ''),
(7, '19-0837', 'Lemuel So', NULL, '1', 'test', '', NULL, '2023-04-21 17:40:36', '2023-04-30 11:59:40', '2023-04-26', '11:00', NULL, 'College of Computer Science and Information Technology', 'ALGO101', '1900001', 'Lalaine Carrao', 'resolved', 'online', ''),
(8, '19-0837', 'Lemuel So', NULL, '1', 'advising', '', NULL, '2023-04-21 19:28:13', '2023-04-24 11:54:16', '2023-04-24', '11:30', 'https://meet.google.com/mkf-zcir-mui', 'College of Computer Science and Information Technology', 'CAP101', '1900001', 'Lalaine Carrao', 'unresolved', 'online', ''),
(9, '19-0837', 'Lemuel So', NULL, '1', 'advising', '', NULL, '2023-04-21 20:19:57', '2023-04-21 20:23:18', '2023-04-22', '13:00', 'https://github.com/ohpxho/qcu-ocad.git', 'College of Computer Science and Information Technology', 'CAP102', '1900001', 'Lalaine Carrao', 'resolved', 'online', ''),
(10, '19-0837', 'Lemuel So', NULL, '1', 'test', '', NULL, '2023-04-22 11:56:07', '2023-04-22 13:56:48', '2023-04-25', '11:00', NULL, 'College of Computer Science and Information Technology', 'CAP102', '1900001', 'Lalaine Carrao', 'unresolved', 'online', NULL),
(11, '19-0837', 'Lemuel So', NULL, '1', 'test', '', NULL, '2023-04-22 13:21:14', '2023-04-22 13:56:53', '2023-04-25', '11:00', NULL, 'College of Computer Science and Information Technology', 'CAP102', '1900001', 'Lalaine Carrao', 'unresolved', 'online', NULL),
(12, '19-0837', 'Lemuel So', NULL, '1', 'test', '', NULL, '2023-04-22 13:26:39', '2023-04-22 13:58:37', '2023-04-25', '11:00', NULL, 'College of Computer Science and Information Technology', 'CAP102', '1900001', 'Lalaine Carrao', 'unresolved', 'online', NULL),
(13, '19-0837', 'Lemuel So', NULL, '1', 'test', '', NULL, '2023-04-22 13:55:56', '2023-04-24 12:37:47', '2023-04-28', '9:00', NULL, 'College of Computer Science and Information Technology', 'CAP101', '1900001', 'Lalaine Carrao', 'resolved', 'online', ''),
(14, '19-0837', 'Lemuel So', NULL, '1', 'test', '', NULL, '2023-04-22 13:56:25', NULL, '2023-04-29', '13:00', '', 'College of Computer Science and Information Technology', 'CAP101', '1900001', 'Lalaine Carrao', 'active', 'online', ''),
(15, '19-0837', 'Lemuel So', NULL, '4', 'test', '', NULL, '2023-04-22 18:16:33', '2023-04-24 11:57:06', '2023-04-25', '10:30', NULL, 'College of Computer Science and Information Technology', 'CAP101', '1900001', 'Lalaine Carrao', 'resolved', 'online', ''),
(16, '19-0837', 'Lemuel So', NULL, '1', 'test', '', '/public/assets/document/341840027_800745391670161_7037618189758548574_n.png', '2023-04-24 11:59:48', '2023-04-24 12:37:27', '2023-04-25', '11:30', NULL, 'College of Computer Science and Information Technology', 'CAP101', '1900001', 'Lalaine Carrao', 'resolved', 'online', ''),
(17, '19-0837', 'Lemuel So', NULL, '4', 'test', '', NULL, '2023-04-24 12:00:43', NULL, '2023-05-01', '17:00', NULL, 'College of Computer Science and Information Technology', 'ALGO101', '1900001', 'Lalaine Carrao', 'pending', 'online', NULL),
(18, '19-0837', 'Lemuel So', NULL, '4', 'test', '', NULL, '2023-04-29 16:58:35', NULL, '2023-05-02', '11:00', NULL, 'College of Computer Science and Information Technology', 'ALGO101', '1900001', 'Lalaine Carrao', 'pending', 'online', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `consultation_acceptance`
--

CREATE TABLE `consultation_acceptance` (
  `advisor` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultation_acceptance`
--

INSERT INTO `consultation_acceptance` (`advisor`, `status`) VALUES
('1900001', 'open'),
('clinic', 'open'),
('guidance', 'open');

-- --------------------------------------------------------

--
-- Table structure for table `good_moral_requests`
--

CREATE TABLE `good_moral_requests` (
  `id` int(20) NOT NULL,
  `student_id` varchar(200) NOT NULL,
  `purpose` varchar(200) NOT NULL,
  `other_purpose` varchar(200) DEFAULT NULL,
  `identification_document` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_completed` datetime DEFAULT NULL,
  `quantity` int(20) NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `status` varchar(200) NOT NULL DEFAULT 'pending',
  `remarks` longtext DEFAULT NULL,
  `type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `good_moral_requests`
--

INSERT INTO `good_moral_requests` (`id`, `student_id`, `purpose`, `other_purpose`, `identification_document`, `date_created`, `date_completed`, `quantity`, `price`, `status`, `remarks`, `type`) VALUES
(2, '19-0837', 'Scholarship / Financial Assistance', '', '', '2023-04-21 09:40:01', '2023-04-21 13:09:30', 1, '0.00', 'completed', '', 'student'),
(4, '19-0837', 'Scholarship / Financial Assistance', '', '', '2023-04-21 19:55:00', '2023-04-21 19:58:07', 1, '0.00', 'cancelled', NULL, 'student'),
(5, '19-0837', 'Scholarship / Financial Assistance', '', '', '2023-04-21 20:17:17', '2023-04-23 03:46:10', 1, '0.00', 'cancelled', '', 'student'),
(6, '19-0837', 'Scholarship / Financial Assistance', '', '', '2023-04-23 03:46:22', '2023-04-23 04:00:04', 1, '150.00', 'completed', '', 'student'),
(9, '19-0837', 'Scholarship / Financial Assistance', '', '', '2023-04-27 11:39:28', '2023-04-27 11:53:52', 1, '0.00', 'completed', '', 'student'),
(10, '19-0837', 'Scholarship / Financial Assistance', '', '', '2023-04-27 11:54:10', '2023-04-27 12:15:39', 1, '150.00', 'for process', '', 'student'),
(11, '19-0837', 'Scholarship / Financial Assistance', '', '', '2023-04-28 18:38:32', '2023-04-29 16:50:02', 1, '0.00', 'cancelled', NULL, 'student'),
(12, '19-0837', 'Enrollment / Transfer To Other School', '', '', '2023-04-29 16:50:20', '2023-04-30 11:01:48', 1, '0.00', 'cancelled', '', 'student'),
(14, '15-0836', 'PNP Application', '', '', '2023-04-29 17:49:29', '2023-04-29 17:49:40', 1, '0.00', 'cancelled', NULL, 'alumni'),
(15, '15-0836', 'Masteral / Graduate Studies', '', '', '2023-04-29 17:50:15', '2023-04-30 11:02:07', 1, '0.00', 'cancelled', '', 'alumni'),
(16, '19-0837', 'Enrollment / Transfer To Other School', '', '', '2023-04-30 11:01:57', '2023-04-30 11:02:46', 1, '0.00', 'rejected', '', 'student'),
(17, '19-0837', 'Scholarship / Financial Assistance', '', '', '2023-04-30 11:02:53', '2023-05-01 07:57:43', 1, '0.00', 'for process', '', 'student'),
(18, '19-0837', 'Enrollment / Transfer To Other School', '', '', '2023-04-30 11:06:17', '2023-05-01 08:04:36', 1, '0.00', 'for process', '', 'student'),
(19, '19-0837', 'Enrollment / Transfer To Other School', '', '', '2023-04-30 11:07:55', '2023-04-30 11:14:05', 1, '100.00', 'for claiming', '', 'student'),
(20, '19-0837', 'Scholarship / Financial Assistance', '', '', '2023-04-30 11:14:14', '2023-04-30 11:16:27', 1, '0.00', 'for claiming', '', 'student'),
(21, '15-0836', 'Masteral / Graduate Studies', '', '', '2023-04-30 11:17:00', '2023-05-01 07:40:53', 1, '100.00', 'for claiming', '', 'alumni');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(20) NOT NULL,
  `consultation_id` int(20) NOT NULL,
  `sender` varchar(200) NOT NULL,
  `receiver` varchar(200) NOT NULL,
  `message` longtext NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `is_seen` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `consultation_id`, `sender`, `receiver`, `message`, `datetime`, `is_seen`) VALUES
(1, 2, '1900001', '19-0837', 'hi', '2023-04-21 11:56:54', 1),
(2, 6, '150001', '19-0837', 'yow', '2023-04-21 16:54:56', 1),
(3, 6, '19-0837', '150001', 'yes?', '2023-04-21 16:55:02', 1),
(4, 7, '1900001', '19-0837', 'yow', '2023-04-21 17:41:14', 1),
(5, 7, '19-0837', '1900001', 'yow yow', '2023-04-21 17:42:03', 1),
(6, 7, '1900001', '19-0837', 'sup', '2023-04-21 17:46:03', 1),
(7, 7, '19-0837', '1900001', 'sup sup', '2023-04-21 17:48:08', 1),
(8, 8, '1900001', '19-0837', 'hi', '2023-04-21 19:30:20', 1),
(9, 8, '19-0837', '1900001', 'hi', '2023-04-21 19:30:33', 1),
(10, 9, '1900001', '19-0837', 'hi', '2023-04-21 20:22:26', 1),
(11, 9, '19-0837', '1900001', 'hi', '2023-04-21 20:22:37', 1),
(12, 6, '150001', '19-0837', 'yow', '2023-04-23 10:45:27', 1),
(13, 7, '1900001', '19-0837', 'hey', '2023-04-30 11:58:17', 1),
(14, 7, '19-0837', '1900001', 'halo', '2023-04-30 11:58:30', 1),
(15, 7, '1900001', '19-0837', 'im good', '2023-04-30 11:58:36', 1),
(16, 7, '19-0837', '1900001', 'ok', '2023-04-30 11:58:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_of_payments`
--

CREATE TABLE `order_of_payments` (
  `id` varchar(200) NOT NULL,
  `type` varchar(200) NOT NULL,
  `request_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_of_payments`
--

INSERT INTO `order_of_payments` (`id`, `type`, `request_id`) VALUES
('OP-20230422-877', 'ACADEMIC_DOCUMENT_REQUEST', 5),
('OP-20230422-402', 'ACADEMIC_DOCUMENT_REQUEST', 6),
('OP-20230422-453', 'ACADEMIC_DOCUMENT_REQUEST', 7),
('OP-20230422-938', 'GOOD_MORAL_REQUEST', 6),
('OP-20230422-134', 'SOA_DOCUMENT_REQUEST', 3),
('OP-20230422-081', 'SOA_DOCUMENT_REQUEST', 3),
('OP-20230422-240', 'ACADEMIC_DOCUMENT_REQUEST', 8),
('OP-20230422-878', 'GOOD_MORAL_REQUEST', 7),
('OP-20230427-649', 'GOOD_MORAL_REQUEST', 8),
('OP-20230427-774', 'GOOD_MORAL_REQUEST', 10),
('OP-20230430-190', 'ACADEMIC_DOCUMENT_REQUEST', 46),
('OP-20230430-423', 'GOOD_MORAL_REQUEST', 19),
('OP-20230430-047', 'GOOD_MORAL_REQUEST', 21),
('OP-20230430-737', 'SOA_DOCUMENT_REQUEST', 6),
('OP-20230501-532', 'GOOD_MORAL_REQUEST', 10),
('OP-20230501-287', 'ACADEMIC_DOCUMENT_REQUEST', 38),
('OP-20230501-688', 'ACADEMIC_DOCUMENT_REQUEST', 49);

-- --------------------------------------------------------

--
-- Table structure for table `professors`
--

CREATE TABLE `professors` (
  `id` varchar(200) NOT NULL,
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
('1900001', 'Carrao', 'Lalaine', '', 'College of Computer Science and Information Technology', 'lemuel.k.costuna.so@gmail.com', '09562656847', 'Female');

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
('1900001', '11:00,12:00', '', '', '', '', '', NULL),
('clinic', '8:30', NULL, NULL, NULL, NULL, NULL, NULL),
('guidance', '8:00,8:30,9:00,9:30,10:00', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `soa_requests`
--

CREATE TABLE `soa_requests` (
  `id` int(20) NOT NULL,
  `student_id` varchar(200) NOT NULL,
  `purpose` varchar(200) NOT NULL,
  `other_purpose` varchar(200) DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `date_completed` datetime DEFAULT NULL,
  `status` varchar(200) NOT NULL DEFAULT 'pending',
  `remarks` longtext DEFAULT NULL,
  `requested_document` varchar(200) NOT NULL,
  `quantity` int(20) NOT NULL,
  `price` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `soa_requests`
--

INSERT INTO `soa_requests` (`id`, `student_id`, `purpose`, `other_purpose`, `date_created`, `date_completed`, `status`, `remarks`, `requested_document`, `quantity`, `price`) VALUES
(2, '19-0837', 'Proof of Payment', '', '2023-04-21 09:44:29', '2023-04-21 13:33:11', 'completed', '', 'order of payment', 1, '0.00'),
(3, '19-0837', 'Proof of Payment', '', '2023-04-23 04:03:25', '2023-04-23 04:31:43', 'completed', '', 'soa', 1, '150.00'),
(4, '19-0837', 'Proof of Payment', '', '2023-04-28 18:54:54', '2023-04-30 11:55:17', 'cancelled', NULL, 'order of payment', 1, '0.00'),
(5, '19-0837', 'Account Reconciliation', '', '2023-04-28 19:05:12', '2023-04-29 16:57:35', 'cancelled', NULL, 'soa', 1, '0.00'),
(7, '19-0837', 'Account Reconciliation', '', '2023-04-30 11:56:21', NULL, 'for process', '', 'order of payment', 1, '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `lname` varchar(200) NOT NULL,
  `fname` varchar(200) NOT NULL,
  `mname` varchar(200) DEFAULT NULL,
  `gender` varchar(200) NOT NULL,
  `contact` varchar(200) NOT NULL,
  `location` varchar(200) NOT NULL,
  `course` varchar(200) NOT NULL,
  `section` varchar(200) NOT NULL,
  `year` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `email`, `lname`, `fname`, `mname`, `gender`, `contact`, `location`, `course`, `section`, `year`, `address`, `type`) VALUES
('19-0837', 'lemuel.k.costuna.so@gmail.com', 'So', 'Lemuel', NULL, 'MALE', '09562656847', 'QC', 'BSIT', '4C', '4th', 'San Bartolome, Qc', 'REGULAR');

-- --------------------------------------------------------

--
-- Table structure for table `subject_codes`
--

CREATE TABLE `subject_codes` (
  `id` int(20) NOT NULL,
  `code` varchar(200) NOT NULL,
  `title` varchar(200) NOT NULL,
  `department` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_codes`
--

INSERT INTO `subject_codes` (`id`, `code`, `title`, `department`) VALUES
(1112, 'ALGO101', 'Algorithm and data Structure 101', 'College of Computer Science and Information Technology'),
(1113, 'CAP102', 'Capstone Project And Research 2', 'College Of Computer Science And Information Technology'),
(1114, 'CAP101', 'Capstone Project And Research 1', 'College Of Computer Science And Information Technology');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(200) NOT NULL,
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
('15-0836', '$2y$10$j.FJDQ6Smo6NzuX9SyWpA.LF9hjxrl/hexxXQpF29vIZroEx74Hpa', 'fsdfddd@gmail.com', 'alumni', '', '2023-04-30 01:52:40', '', 'active'),
('150001', '$2y$10$j.FJDQ6Smo6NzuX9SyWpA.LF9hjxrl/hexxXQpF29vIZroEx74Hpa', 'lemuelso000@gmail.com', 'guidance', '', '2023-04-20 18:37:17', '', 'active'),
('150002', '$2y$10$j.FJDQ6Smo6NzuX9SyWpA.LF9hjxrl/hexxXQpF29vIZroEx74Hpa', 'lemuelso001@gmail.com', 'finance', '', '2023-04-20 18:36:41', '', 'active'),
('150003', '$2y$10$j.FJDQ6Smo6NzuX9SyWpA.LF9hjxrl/hexxXQpF29vIZroEx74Hpa', 'sol.qcydoqcu@gmail.com', 'registrar', '', '2023-04-20 18:04:59', '', 'active'),
('150004', '$2y$10$j.FJDQ6Smo6NzuX9SyWpA.LF9hjxrl/hexxXQpF29vIZroEx74Hpa', 'lemuelso002@gmail.com', 'clinic', '', '2023-04-20 18:05:01', '', 'active'),
('19-0837', '$2y$10$j.FJDQ6Smo6NzuX9SyWpA.LF9hjxrl/hexxXQpF29vIZroEx74Hpa', 'lemuel.k.costuna.so@gmail.com', 'student', '', '2023-04-29 23:25:22', '', 'active'),
('1900001', '$2y$10$j.FJDQ6Smo6NzuX9SyWpA.LF9hjxrl/hexxXQpF29vIZroEx74Hpa', 'lemuel.k.costuna.so@gmail.com', 'professor', '', '2023-04-20 18:47:43', '', 'active'),
('19940301', '$2y$10$j.FJDQ6Smo6NzuX9SyWpA.LF9hjxrl/hexxXQpF29vIZroEx74Hpa', 'lemuelkso1@gmail.com', 'sysadmin', '', '2023-03-11 11:34:34', '', 'active');

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
-- Indexes for table `availabilities`
--
ALTER TABLE `availabilities`
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
-- Indexes for table `consultation_acceptance`
--
ALTER TABLE `consultation_acceptance`
  ADD PRIMARY KEY (`advisor`);

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
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT for table `availabilities`
--
ALTER TABLE `availabilities`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `good_moral_requests`
--
ALTER TABLE `good_moral_requests`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `soa_requests`
--
ALTER TABLE `soa_requests`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subject_codes`
--
ALTER TABLE `subject_codes`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1115;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
