-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2024 at 10:36 AM
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
-- Database: `usermaanegemt`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `superAdmin` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `superAdmin`) VALUES
(1, 'admin', 'admin@admin.com', 'e10adc3949ba59abbe56e057f20f883e', 'no'),
(6, 'admin01', 'admin03@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'no'),
(9, 'admin055', 'admin055@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `deleteduser`
--

CREATE TABLE `deleteduser` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `deltime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `deleteduser`
--

INSERT INTO `deleteduser` (`id`, `email`, `deltime`) VALUES
(21, 'eleanor12@gmail.com', '2024-09-23 06:01:58'),
(22, '', '2024-09-23 06:05:13'),
(23, '', '2024-09-23 06:06:18');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `sender` varchar(50) NOT NULL,
  `reciver` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `feedbackdata` varchar(500) NOT NULL,
  `attachment` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `sender`, `reciver`, `title`, `feedbackdata`, `attachment`) VALUES
(19, 'fuad123e@gmail.com', 'Admin', 'heyy', 'ejejjeje', ' '),
(20, 'Admin', 'fuad123e@gmail.com', '', 'accepted', ''),
(21, 'fuad123e@gmail.com', 'Admin', 'heyy', 'ejejjeje', ' '),
(22, 'Hr12545@gmail.com', 'Admin', 'hey dudu test5', 'huu', ' ');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `notiuser` varchar(50) NOT NULL,
  `notireciver` varchar(50) NOT NULL,
  `notitype` varchar(50) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `notiuser`, `notireciver`, `notitype`, `time`) VALUES
(18, 'abc@gmail.com', 'Admin', 'Create Account', '2022-04-05 15:40:23'),
(19, 'fuad123e@gmail.com', 'Admin', 'Create Account', '2024-09-23 02:26:07'),
(20, 'fuad123e@gmail.com', 'Admin', 'Send Feedback', '2024-09-23 02:27:34'),
(21, 'Admin', 'fuad123e@gmail.com', 'Send Message', '2024-09-23 02:27:48'),
(22, 'fuad123e@gmail.com', 'Admin', 'Send Feedback', '2024-09-23 02:27:52'),
(23, 'admin058', 'Admin', 'Create Account', '2024-09-23 05:22:42'),
(24, 'admin058', 'Admin', 'Create Account', '2024-09-23 05:25:23'),
(25, 'admin058', 'Admin', 'Create Account', '2024-09-23 05:27:42'),
(26, 'Hr12545@gmail.com', 'Admin', 'Send Feedback', '2024-09-23 06:57:52');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'Data Collector'),
(2, 'Data Collector01'),
(3, 'Ada fi Toursim'),
(4, 'Adama City Municipal Office Manager : Firyad'),
(5, 'Adama City Municipal Office Vice  Manager : Habtam'),
(6, 'Adama City Municipal Office Vice  Manager : Nanoo'),
(7, 'Adama City Municipal Office Hr Team Leader : Sofiy'),
(8, 'Adama City Municipal Office Hr Team : '),
(9, 'Adama City Municipal Office : Construction Dept'),
(10, 'Adama City Municipal Office : House Condominium an'),
(11, 'Adama City Municipal Office : ID dept'),
(12, 'Adama City Municipal Office : IT dept'),
(13, 'Adama City Municipal Office : SaftNet'),
(14, 'Adama City Municipal Office : Greenery Dept'),
(15, 'Adama City Municipal Office : Other Dept'),
(16, 'Adama City Finance Office : Manager'),
(17, 'Adama City Finance Office :  Finance Team '),
(18, 'Adama City Education Office : Education Manager'),
(19, 'Adama City Education Office :  Team'),
(20, 'Adama City Health Office :Health Manager'),
(21, 'Adama City Health Office :Health  Team Mem.'),
(22, 'Adama City Trade Office : Trade Manager.'),
(23, 'Adama City Trade Office : Trade Team'),
(24, 'Adama City Cara Hoji Office : Cara Hoji Office Man'),
(25, 'Adama City Sport Office : Sport  Office Manager'),
(26, 'Adama City Mayor Office : Mayor Office Manager'),
(27, 'Adama City Mayor Office : Mayor Office  Vice Manag'),
(28, 'Data Collectoru');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `Location` varchar(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `status` int(10) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `gender`, `mobile`, `Location`, `image`, `status`, `role_id`) VALUES
(1, 'Heeran', 'heran123@gmail.com', '', 'Female', '0939241717', 'errrr', '01111.png', 0, 1),
(2, 'Fuad Awal', 'fuad1213@gmail.com', '', 'Male', '0939241717', 'errrrpl', 'y.jpg', 0, 1),
(3, 'Fuad Awal', 'user01@gmail.com', '$2y$10$T4fJiReO9.AlmlhW7zl0DuZ6plG.TAk9YQQ1rE2PYfv', 'Male', '0939241717', 'errrrp', 'y.jpg', 1, 1),
(5, 'Dara Collector', 'DaraCollector@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Male', '0658414222', 'Adama', 'y.jpg', 1, 1),
(6, 'Sofi', 'Hr12545@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Female', '0939241717', 'Adama', 'y.jpg', 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `users01`
--

CREATE TABLE `users01` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','employee') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users01`
--

INSERT INTO `users01` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Dudu', 'dudu@gmail.com', '$2y$10$Bf2zvskjydGOPwZzPJWpHuKogbkzVPkWMUrikPCyn.0ItLoFs2GhC', 'admin', '2024-09-23 01:17:32'),
(3, 'Heeran', 'heran123@gmail.com', '$2y$10$65nME4v9LKD8Yy6uH6/7MuGSgmB1gI/An3Mk15VgQdf.AhBlBFNfW', 'employee', '2024-09-23 01:19:17'),
(4, 'el', 'admin8@123.com', '$2y$10$U2A00mQGiEmzJrTUFKtOpOcNnaStpMYzTptO03GMuS./pbJIW0/v.', 'admin', '2024-09-23 01:54:11');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(11) NOT NULL,
  `visitor_name` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `department` int(11) NOT NULL,
  `reason` text NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Done','Make Appointment') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `visitor_name`, `gender`, `phone_no`, `address`, `department`, `reason`, `file`, `created_at`, `status`) VALUES
(1, 'Fuad144', 'Male', '25555', 'hy79', 19, 'fer', '', '2024-09-23 06:41:22', 'Pending'),
(2, 'Fuad', 'Female', '78', 'ada', 19, 'yu', '', '2024-09-23 06:44:03', 'Done');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deleteduser`
--
ALTER TABLE `deleteduser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `users01`
--
ALTER TABLE `users01`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department` (`department`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `deleteduser`
--
ALTER TABLE `deleteduser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users01`
--
ALTER TABLE `users01`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `visitors`
--
ALTER TABLE `visitors`
  ADD CONSTRAINT `visitors_ibfk_1` FOREIGN KEY (`department`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
