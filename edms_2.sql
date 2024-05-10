-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2024 at 09:37 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edms_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `calendar_events`
--

CREATE TABLE `calendar_events` (
  `id` int(11) NOT NULL,
  `title` varchar(20) DEFAULT NULL,
  `start_date` varchar(255) DEFAULT NULL,
  `end_date` varchar(255) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `user_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calendar_events`
--

INSERT INTO `calendar_events` (`id`, `title`, `start_date`, `end_date`, `description`, `department_id`, `user_id`) VALUES
(1, 'Board meeting', '2024-05-09', '2024-05-09', 'budget', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `department_id`) VALUES
(1, 'Procurements', '1');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`) VALUES
(1, 'ICT'),
(2, 'Library');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `doc_name_raw` varchar(255) DEFAULT NULL,
  `doc_name` varchar(255) DEFAULT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `category_id` varchar(100) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `date_saved` varchar(30) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `doc_name_raw`, `doc_name`, `user_id`, `category_id`, `department_id`, `date_saved`, `status`) VALUES
(1, '6. Farm office 2-Sugoi.pdf', '590bc06746856a585049686960a000ee.pdf', '1', '1', '1', '09/05/2024 10:17:21 am', '1');

-- --------------------------------------------------------

--
-- Table structure for table `documents_shared`
--

CREATE TABLE `documents_shared` (
  `id` int(11) NOT NULL,
  `user_id` varchar(20) DEFAULT NULL,
  `user_department_id` varchar(255) DEFAULT NULL,
  `department_id` varchar(50) DEFAULT NULL,
  `doc_name_raw` varchar(255) DEFAULT NULL,
  `doc_name` varchar(255) DEFAULT NULL,
  `date_shared` varchar(20) DEFAULT NULL,
  `random_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents_shared`
--

INSERT INTO `documents_shared` (`id`, `user_id`, `user_department_id`, `department_id`, `doc_name_raw`, `doc_name`, `date_shared`, `random_id`) VALUES
(1, '1', '1', '1', 'deliverynote.jpg', '09b7eb53d99a1c8e7c0d4f1bd79a16bc', '09/05/2024 10:37:20 ', '4195'),
(2, '1', '1', '1', '6. Farm office 2-Sugoi.pdf', '590bc06746856a585049686960a000ee.pdf', '09/05/2024 10:38:08 ', '4751'),
(3, '1', '1', '2', '6. Farm office 2-Sugoi.pdf', '590bc06746856a585049686960a000ee.pdf', '09/05/2024 11:33:45 ', '2168');

-- --------------------------------------------------------

--
-- Table structure for table `documents_shared_id`
--

CREATE TABLE `documents_shared_id` (
  `id` int(11) NOT NULL,
  `document_id` varchar(20) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `user_dep_id` varchar(50) DEFAULT NULL,
  `shared_user_id` varchar(100) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents_shared_id`
--

INSERT INTO `documents_shared_id` (`id`, `document_id`, `user_id`, `user_dep_id`, `shared_user_id`, `department_id`) VALUES
(1, '1', '1', '1', '2', '1'),
(2, '2', '1', '1', '1', '1'),
(3, '3', '1', '1', '2', '2');

-- --------------------------------------------------------

--
-- Table structure for table `document_comments`
--

CREATE TABLE `document_comments` (
  `id` int(11) NOT NULL,
  `doc_id` varchar(20) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `date_saved` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `document_comments`
--

INSERT INTO `document_comments` (`id`, `doc_id`, `department_id`, `user_id`, `comment`, `date_saved`) VALUES
(1, '1', '1', '1', '                    good\r\n                  ', '09/05/2024 10:20:46 am'),
(2, '1', '1', '2', '                    \r\n          can we add some pages        ', '09/05/2024 10:25:09 am'),
(3, '1', '1', '2', '       hey hello dan             \r\n                  ', '09/05/2024 10:34:29 am'),
(4, '1', '1', '1', '                    Am good test\r\n                  ', '09/05/2024 10:35:16 am'),
(5, '1', '1', '2', '                    \r\n                  ', '09/05/2024 10:35:53 am'),
(6, '1', '1', '2', '                    \r\n                  ', '09/05/2024 10:56:08 am'),
(7, '1', '1', '2', '                    \r\n                  hey', '09/05/2024 11:32:56 am');

-- --------------------------------------------------------

--
-- Table structure for table `system_logs`
--

CREATE TABLE `system_logs` (
  `id` int(11) NOT NULL,
  `user_id` varchar(20) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `activity` varchar(50) DEFAULT NULL,
  `date_logged` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_logs`
--

INSERT INTO `system_logs` (`id`, `user_id`, `department_id`, `activity`, `date_logged`) VALUES
(1, '1', '1', '6. Farm office 2-Sugoi.pdf Uploaded', '09/05/2024 10:17:21 am'),
(2, '1', '1', 'deliverynote.jpg Shared', '09/05/2024 10:37:20 am'),
(3, '1', '1', '6. Farm office 2-Sugoi.pdf Shared', '09/05/2024 10:38:08 am'),
(4, '1', '1', '6. Farm office 2-Sugoi.pdf Shared', '09/05/2024 11:33:45 am');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `department_id` varchar(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone_no` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `admin` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `department_id`, `name`, `phone_no`, `email`, `password`, `admin`, `status`) VALUES
(1, '1', 'Dan', '0726585782', 'ndongdan4@gmail.com', '$2y$10$Ysw7ALINr.lW8Q7aVbcpCuQjjFSR577kMlcl4saCUv10DGN1VDHBu', '1', '0'),
(2, '2', 'Test', '07', 'test@gmail.com', '$2y$10$Ysw7ALINr.lW8Q7aVbcpCuQjjFSR577kMlcl4saCUv10DGN1VDHBu', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `user_id` varchar(20) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_id`, `role`) VALUES
(1, '1', 'Admin'),
(2, '1', 'Upload Document'),
(3, '1', 'Read Document'),
(4, '1', 'Comment'),
(5, '1', 'Delete Document'),
(6, '1', 'Super Admin'),
(7, '1', 'Share Document'),
(8, '1', 'View Contact List'),
(9, '1', 'View System Logs'),
(10, '1', 'View Shared Document'),
(11, '2', 'Comment'),
(12, '2', 'Share Document');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calendar_events`
--
ALTER TABLE `calendar_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents_shared`
--
ALTER TABLE `documents_shared`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents_shared_id`
--
ALTER TABLE `documents_shared_id`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document_comments`
--
ALTER TABLE `document_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calendar_events`
--
ALTER TABLE `calendar_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `documents_shared`
--
ALTER TABLE `documents_shared`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `documents_shared_id`
--
ALTER TABLE `documents_shared_id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `document_comments`
--
ALTER TABLE `document_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
