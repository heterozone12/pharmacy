-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Oct 20, 2025 at 05:55 AM
-- Server version: 8.0.43
-- PHP Version: 8.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharmacyinventory_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `medicine_id` int NOT NULL,
  `generic_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `brand_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dosage_form` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `strength` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int DEFAULT NULL,
  `reorder_level` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`medicine_id`, `generic_name`, `brand_name`, `dosage_form`, `strength`, `expiration_date`, `unit_price`, `stock_quantity`, `reorder_level`) VALUES
(20, 'Montana Norman', 'Kirk Dorsey', 'Proident et ut in p', 'Iste provident dolo', '2025-01-10', 183.00, 108, 33),
(21, 'Montana Norman', 'Kirk Dorsey', 'Proident et ut in p', 'Iste provident dolo', '2025-01-10', 183.00, 108, 33),
(22, 'Dalton Welch', 'Jessamine Sargent', 'Quis totam aut recus', 'Qui quo animi aliqu', '2001-11-19', 831.00, 909, 100),
(23, 'Fiona Boone', 'Xenos Owen', 'Voluptatum molestias', 'Quia amet quae cons', '1970-04-02', 797.00, 720, 11);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `user_id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` varchar(50) DEFAULT 'User',
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`user_id`, `username`, `full_name`, `role`, `date_created`) VALUES
(6, 'dezub', 'Katelyn Mcconnell', 'Manager', '2025-10-09 13:30:27'),
(7, 'mybipud', 'Nash Delacruz', 'User', '2025-10-09 13:34:54'),
(8, 'tolynutajy', 'Eden Hickman', 'Admin', '2025-10-09 13:54:59'),
(9, 'cogehos', 'Madeline Shepard', 'Admin', '2025-10-14 02:57:05'),
(10, 'nijefomi', 'Gail Kerr', 'Admin', '2025-10-20 04:39:07'),
(11, 'jehelyd', 'Phillip Griffin', 'User', '2025-10-20 04:44:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('Admin','Staff','Customer') COLLATE utf8mb4_general_ci DEFAULT 'Customer',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `full_name`, `email`, `role`, `date_created`) VALUES
(1, 'admin', 'admin123', 'Admin User', 'admin@example.com', 'Admin', '2025-09-22 13:14:30'),
(3, 'dave', '', 'jay dave danas', NULL, 'Admin', '2025-09-22 13:14:49'),
(4, 'ashley', '', 'ashley villamor', NULL, 'Admin', '2025-09-22 13:39:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`medicine_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `medicine_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
