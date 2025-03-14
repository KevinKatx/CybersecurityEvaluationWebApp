-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2025 at 11:13 AM
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
-- Database: `employee_eval`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('M','F') NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('Admin','Employee') NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `first_name`, `last_name`, `age`, `gender`, `phone`, `email`, `role`, `password`) VALUES
(3, 'Uriel Andrew', 'Peralta', 19, 'M', '09201088207', 'urielandrewperalta@gmail.com', 'Admin', '$2y$10$PHf9XywgpqG94FJtxHBSIOlx7IeYZ1zT13m7jk.T7pnhb1nHf.WFC'),
(4, 'Kevin', 'Katz', 20, 'M', '09471999915', 'kenjibossing@gmail.com', 'Admin', '$2y$10$FneU9qCni/DgXd9P5iIMMu74EplFor51b0gZbhxC26rttjoU2DfCq'),
(5, 'John', 'Doe', 20, 'M', '09475837162', 'johndoe@gmail.com', 'Employee', '$2y$10$gnPT80pLSPkxp0wqd14RJOYCNvaN9kxQbpk2jRHUwvsrjLbvpJkna'),
(10, 'Uriel Andrew', 'Peralta', 19, 'M', '09201088207', 'uriel@email.com', 'Employee', '$2y$10$bWjsmmuqdKS62zzMUp9r5OeFRlIBqGRD9AacNWa2T4hrYLSDNXVXS'),
(11, 'Kthanid', 'Vicar', 20, 'M', '09201088207', 'kthanid@gmail.com', 'Employee', '$2y$10$xyRTBoJK3Nk9wr.JKfylqeQgpcbo9gfjTwFqzOCkBbNRNCRlkMAju'),
(12, 'evelyn', 'Peralta', 46, 'F', '91894307050', 'peralta_edz@yahoo.com.ph', 'Employee', '$2y$10$ZOCs8kN6AyktWznCR9KVz.L21b5o9oYlrg.zeJUQIF40b2Gc8Q.Ia');

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE `evaluation` (
  `evalID` int(11) NOT NULL,
  `employeeID` int(11) DEFAULT NULL,
  `scoreP1` int(11) DEFAULT NULL,
  `scoreP2` int(11) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `evaluation`
--

INSERT INTO `evaluation` (`evalID`, `employeeID`, `scoreP1`, `scoreP2`, `date`) VALUES
(40, 5, 19, 0, '2025-03-14 14:42:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`evalID`),
  ADD KEY `employeeID` (`employeeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `evalID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `evaluation_ibfk_1` FOREIGN KEY (`employeeID`) REFERENCES `employee` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
