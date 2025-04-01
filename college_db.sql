-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2025 at 07:00 PM
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
-- Database: `college_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `branch` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `first_name`, `last_name`, `username`, `password`, `branch`, `created_at`) VALUES
(1, 'Rahul', 'Sharma', 'rahul_admin', '$2y$10$wHqBvXgGp8T5/jG/TXo.OeGC2uDZwZLjxZ7uU8yJsCz8Wq.Pc2a.i', 'CSE', '2025-03-18 13:59:39'),
(2, 'Rahul', 'patle', 'karanhelp2003@gmail.com', '$2y$10$imuIJVxwOMEFn/bpcKvLUeA3Kxb6Kv.Q1Nh7P3rjAsxj8pb/u1Xw2', 'CIVIL', '2025-03-18 14:32:05'),
(3, 'Rahul', 'patle', 'RAJU', '$2y$10$s9CgV6MJzdiMrBsir7fUcu7QAhWRNepwGF8Eo6ByyUGi7urjWWoDS', 'MECH', '2025-03-18 16:21:32'),
(4, 'anas', 'kumar', 'kor233@gmail.com', '$2y$10$1mdv8tDuj8QPFB2MD.oubOd3kQXZBHcy8g/WtCxHZIebAig90RDeq', 'HUMINI', '2025-03-18 16:22:53'),
(5, 'admin', 'demo2', 'google', '$2y$10$eLK3PUQJQuUfHJ8YvkC3dehdru0Ff/.fZet5Z4cYPhudRVUt45.I.', 'CIVIL', '2025-03-18 16:24:55'),
(6, 'kumar', 'sangkara', 'kumar', '$2y$10$FGy7FD9xVZcJVPQQTIpV8e0m.y8MXAikx8SVIuLzwp5KiIogzAiGi', 'CIVIL', '2025-03-18 16:30:53'),
(7, 'shailesh', 'pardhi', 'shailesh20', '$2y$10$g9FViKnzuZKR5jBzKn3mc.05yQMGMPEQK8aPzpxrniWqeC1VDUs52', 'CSE', '2025-03-18 16:55:12');

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `fc_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `qualification` varchar(255) NOT NULL,
  `experience` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`fc_id`, `name`, `department`, `position`, `qualification`, `experience`, `email`, `mobile`, `pic`, `created_at`) VALUES
(1, 'karan kumar', 'cse', 'developer ', 'diploma ', '2 years', 'karan34@gmail.com', '7784845659', 'faculty_uploads/1742319931_41Ficeq9V6L.jpg', '2025-03-18 17:45:31'),
(5, 'karan kumar 34', 'cse4', 'developer ,designer', 'diploma ', '22 years', 'karan364@gmail.com', '7784845647', 'uploads/faculty/1742320108_closeup-shot-beautiful-hydrangea-flowers.jpg', '2025-03-18 17:48:28');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `title`, `category`, `description`, `image_url`, `uploaded_at`) VALUES
(1, 'pic of latest event ', 'Event', 'event for my dude ', 'uploads/gallery/1742319375_OIP.jpg', '2025-03-18 17:36:15'),
(2, 'pic of latest event ', 'Event', 'sdfdsfsdf', 'uploads/gallery/1742319392_istockphoto-1317649161-612x612.jpg', '2025-03-18 17:36:32');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `image`, `created_at`) VALUES
(4, 'news 2 is here ', 'reating pseudo-random numbers on Lottery scratch cards\r\nreCAPTCHA on login forms uses a random number generator to define different numbers and images', 'uploads/news/blue jacaranda.png', '2025-03-18 17:35:21');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `attachments` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supporting_staff`
--

CREATE TABLE `supporting_staff` (
  `ssf_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `qualification` varchar(255) NOT NULL,
  `experience` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supporting_staff`
--

INSERT INTO `supporting_staff` (`ssf_id`, `name`, `department`, `position`, `qualification`, `experience`, `email`, `mobile`, `pic`, `created_at`) VALUES
(1, 'Rahul Patle', 'zvsd', 'sdgsf', 'sdgsd', 'dsg', 'patler044@gmail.com', '09098842899', 'uploads/1742320755_4873260935_eae496bfa8.jpg', '2025-03-18 17:59:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`fc_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supporting_staff`
--
ALTER TABLE `supporting_staff`
  ADD PRIMARY KEY (`ssf_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `fc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supporting_staff`
--
ALTER TABLE `supporting_staff`
  MODIFY `ssf_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
