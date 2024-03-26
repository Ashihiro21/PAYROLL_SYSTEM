-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2024 at 01:11 AM
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
-- Database: `payroll_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Employee_No` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Employee_No`, `first_name`, `last_name`, `department`, `position`, `username`, `password`, `email`, `images`) VALUES
(1, 'Marivic', 'Mitschek', 'ICTC', 'Admin', 'admin', 'admin123', '', 'img/dp.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `Employee_No` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `time_in` varchar(255) NOT NULL,
  `time_out` varchar(255) NOT NULL,
  `time_in2` varchar(255) NOT NULL,
  `overtime` varchar(255) NOT NULL,
  `time_out2` varchar(255) NOT NULL,
  `num_hr` int(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `admin_approve` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `Employee_No`, `location`, `date`, `time_in`, `time_out`, `time_in2`, `overtime`, `time_out2`, `num_hr`, `status`, `admin_approve`) VALUES
(257, 'DQILRX761947', 'itd office', '2024-03-25', '13:19', '13:19', '', '', '', 0, 'undertime', 'pending'),
(258, 'YFCKLE545246', 'itd office', '2024-03-25', '1:00', '15:50', '15:51', '15:52', '', 14, 'overtime', 'Approve'),
(259, 'PJOXNA355675', 'ictc office', '2024-03-25', '1:00', '16:35', '16:35', '16:36', '16:40', 15, 'overtime', 'Approve');

-- --------------------------------------------------------

--
-- Table structure for table `deduction`
--

CREATE TABLE `deduction` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deduction`
--

INSERT INTO `deduction` (`id`, `description`, `amount`) VALUES
(8, '   Philhealth   ', 2040),
(10, 'Pag-IBIG', 400),
(14, '   SSS   ', 1040);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `images` varchar(255) NOT NULL,
  `Employee_No` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `position_id` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `images`, `Employee_No`, `first_name`, `last_name`, `department`, `position_id`, `email`, `password`) VALUES
(38, 'img/elexis.jpg', 'DXNUJP778657', ' Elexis ', 'Falceso', ' ICTC ', '1', 'elexis.falceso.dit.cvsu@gmail.com', '1231231010'),
(39, 'img/dp.jpg', 'YFCKLE545246', 'Jenesis', 'Falceso', ' ICTC ', '7', 'jenesis_falceso@gmail.com', '1231231010'),
(43, 'img/dp.jpg', 'DQILRX761947', 'Louise', 'Garcia', 'ICTC', '1', 'louise.garcia@cvsu.edu.ph1', '1231231010'),
(44, 'img/dp.jpg', 'PJOXNA355675', 'Alvin', 'Hamor', 'ICTC', '1', 'alvin_hamor@gmail.com', '1231231010');

-- --------------------------------------------------------

--
-- Table structure for table `employee_leaves`
--

CREATE TABLE `employee_leaves` (
  `id` int(11) NOT NULL,
  `Employee_No` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `leave_type` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_leaves`
--

INSERT INTO `employee_leaves` (`id`, `Employee_No`, `first_name`, `last_name`, `email`, `leave_type`, `start_date`, `end_date`, `status`) VALUES
(35, 'DXNUJP778657', ' Elexis ', 'Falceso', 'elexis.falceso.dit.cvsu@gmail.com', 'Annual', '2024-03-25', '2024-03-30', 'Approve'),
(36, 'YFCKLE545246', 'Jenesis', 'Falceso', 'jenesis_falceso@gmail.com', 'Annual', '2024-03-26', '2024-03-30', 'Approve'),
(37, 'DQILRX761947', 'Louise', 'Garcia', 'louise.garcia@cvsu.edu.ph1', 'Annual', '2024-03-26', '2024-03-28', 'Approve'),
(38, 'PJOXNA355675', 'Alvin', 'Hamor', 'alvin_hamor@gmail.com', 'Annual', '2024-03-25', '2024-03-30', 'Approve');

-- --------------------------------------------------------

--
-- Table structure for table `excess_time`
--

CREATE TABLE `excess_time` (
  `id` int(11) NOT NULL,
  `Employee_No` int(11) NOT NULL,
  `excess_times` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `excess_time`
--

INSERT INTO `excess_time` (`id`, `Employee_No`, `excess_times`, `created_at`) VALUES
(1, 0, 180, '2024-03-14 07:45:18'),
(2, 0, 180, '2024-03-14 07:45:18'),
(3, 0, 180, '2024-03-14 07:45:19'),
(4, 0, 180, '2024-03-14 07:45:46'),
(5, 0, 180, '2024-03-14 07:56:36'),
(6, 0, 180, '2024-03-14 07:56:36'),
(7, 0, 180, '2024-03-14 07:56:57'),
(8, 0, 180, '2024-03-14 07:57:13'),
(9, 0, 180, '2024-03-14 07:57:41'),
(10, 0, 180, '2024-03-14 07:57:41'),
(11, 0, 180, '2024-03-14 07:57:41'),
(12, 0, 180, '2024-03-14 07:57:41'),
(13, 0, 180, '2024-03-14 08:16:03'),
(14, 0, 25200, '2024-03-14 23:12:09'),
(15, 0, 25200, '2024-03-14 23:13:53'),
(16, 0, 25200, '2024-03-14 23:13:53'),
(17, 0, 25200, '2024-03-14 23:14:11'),
(18, 0, 25200, '2024-03-14 23:14:22'),
(19, 0, 25200, '2024-03-14 23:14:22'),
(20, 0, 25200, '2024-03-14 23:14:41'),
(21, 0, 25200, '2024-03-14 23:14:46'),
(22, 0, 25200, '2024-03-14 23:14:46'),
(23, 0, 25200, '2024-03-14 23:14:46'),
(24, 0, 25200, '2024-03-14 23:15:49'),
(25, 0, 25200, '2024-03-14 23:22:39'),
(26, 0, 25200, '2024-03-14 23:22:39'),
(27, 0, 25200, '2024-03-14 23:22:40'),
(28, 0, 25200, '2024-03-14 23:22:41'),
(29, 0, 25200, '2024-03-14 23:22:41'),
(30, 0, 25200, '2024-03-14 23:22:41');

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

CREATE TABLE `holiday` (
  `id` int(10) UNSIGNED NOT NULL,
  `tittle` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `holiday`
--

INSERT INTO `holiday` (`id`, `tittle`, `description`, `date`, `type`) VALUES
(1, '      Araw ng Kagitingan      ', '      This is National Heroes Day      ', '2024-03-15', 'Restricted'),
(5, 'New Years', 'All Employee Needs Vacation to enjoy your family', '2025-01-01', 'Complosory'),
(8, '  New Year  ', '  All Employee Needs Vacation to enjoy your family  ', '2024-03-19', 'Compolsory');

-- --------------------------------------------------------

--
-- Table structure for table `insertion`
--

CREATE TABLE `insertion` (
  `id` int(6) UNSIGNED NOT NULL,
  `Employee_No` varchar(255) NOT NULL,
  `time_in` varchar(255) NOT NULL,
  `time_out` varchar(255) NOT NULL,
  `num_hr` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `insertion`
--

INSERT INTO `insertion` (`id`, `Employee_No`, `time_in`, `time_out`, `num_hr`) VALUES
(14, 'GVBLNE227097 ', '12:29:34 am', '', ''),
(15, ' GVBLNE227097 ', '12:29:48 am', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE `leaves` (
  `id` int(11) NOT NULL,
  `leave_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`id`, `leave_type`) VALUES
(4, 'Annual'),
(8, 'Sick'),
(9, 'Maternity');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `position` varchar(255) NOT NULL,
  `rate` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `position`, `rate`) VALUES
(1, '  Full Stack Developer ', '  1000  '),
(7, 'Graphic Design', '300');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `time_in`, `time_out`) VALUES
(1, '07:00:00', '16:00:00'),
(2, '08:00:00', '17:00:00'),
(6, '09:00:00', '18:00:00'),
(8, '10:00:00', '19:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Employee_No`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deduction`
--
ALTER TABLE `deduction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_leaves`
--
ALTER TABLE `employee_leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `excess_time`
--
ALTER TABLE `excess_time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `insertion`
--
ALTER TABLE `insertion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaves`
--
ALTER TABLE `leaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Employee_No` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=260;

--
-- AUTO_INCREMENT for table `deduction`
--
ALTER TABLE `deduction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `employee_leaves`
--
ALTER TABLE `employee_leaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `excess_time`
--
ALTER TABLE `excess_time`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `holiday`
--
ALTER TABLE `holiday`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `insertion`
--
ALTER TABLE `insertion`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `leaves`
--
ALTER TABLE `leaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
