-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2025 at 11:32 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventory_id` int(11) NOT NULL,
  `transaction_type` varchar(50) NOT NULL,
  `quantity_changed` int(11) NOT NULL,
  `date_updated` datetime NOT NULL,
  `remarks` text,
  `user_id` int(11) NOT NULL,
  `medicine_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `medicine_id` int(11) NOT NULL,
  `generic_name` varchar(100) NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `dosage_form` varchar(50) NOT NULL,
  `strength` varchar(50) NOT NULL,
  `expiration_date` date NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `reorder_level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`medicine_id`, `generic_name`, `brand_name`, `dosage_form`, `strength`, `expiration_date`, `unit_price`, `stock_quantity`, `reorder_level`) VALUES
(1, 'Paracetamol', 'Biogesic', 'Tablet', '500mg', '2026-01-15', '5.00', 200, 50),
(2, 'Ibuprofen', 'Advil', 'Capsule', '200mg', '2026-03-10', '8.50', 150, 40),
(3, 'Amoxicillin', 'Amoxil', 'Capsule', '500mg', '2025-11-20', '12.00', 100, 30),
(4, 'Cetirizine', 'Allerkid', 'Syrup', '5mg/5ml', '2026-05-05', '65.00', 80, 20),
(5, 'Metformin', 'Glucophage', 'Tablet', '500mg', '2027-02-18', '10.00', 120, 40),
(6, 'Losartan', 'Cozaar', 'Tablet', '50mg', '2026-08-22', '15.00', 90, 25),
(7, 'Amlodipine', 'Norvasc', 'Tablet', '5mg', '2026-12-30', '18.00', 110, 30),
(8, 'Omeprazole', 'Losec', 'Capsule', '20mg', '2027-03-12', '20.00', 95, 25),
(9, 'Salbutamol', 'Ventolin', 'Inhaler', '100mcg', '2026-09-14', '180.00', 60, 15),
(10, 'Ascorbic Acid', 'Ceelin', 'Syrup', '100mg/5ml', '2026-07-01', '50.00', 140, 35);

-- --------------------------------------------------------

--
-- Table structure for table `purchasedetails`
--

CREATE TABLE `purchasedetails` (
  `purchase_details_id` int(11) NOT NULL,
  `quantity_purchased` int(11) NOT NULL,
  `cost_per_unit` decimal(10,2) NOT NULL,
  `medicine_id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchase_id` int(11) NOT NULL,
  `purchase_date` datetime NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `full_name`, `role`, `password_hash`, `date_created`) VALUES
(1, 'admin01', 'Maria Dela Cruz', 'Admin', 'hash_pw1', '2025-09-04 17:32:10'),
(2, 'pharm01', 'Juan Santos', 'Pharmacist', 'hash_pw2', '2025-09-04 17:32:10'),
(3, 'pharm02', 'Ana Reyes', 'Pharmacist', 'hash_pw3', '2025-09-04 17:32:10'),
(4, 'cashier01', 'Jose Bautista', 'Cashier', 'hash_pw4', '2025-09-04 17:32:10'),
(5, 'cashier02', 'Rosa Garcia', 'Cashier', 'hash_pw5', '2025-09-04 17:32:10'),
(6, 'staff01', 'Pedro Aquino', 'Staff', 'hash_pw6', '2025-09-04 17:32:10'),
(7, 'staff02', 'Liza Mendoza', 'Staff', 'hash_pw7', '2025-09-04 17:32:10'),
(8, 'staff03', 'Marco Villanueva', 'Staff', 'hash_pw8', '2025-09-04 17:32:10'),
(9, 'manager01', 'Carmen Torres', 'Manager', 'hash_pw9', '2025-09-04 17:32:10'),
(10, 'auditor01', 'Ricardo Ramos', 'Auditor', 'hash_pw10', '2025-09-04 17:32:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventory_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `medicine_id` (`medicine_id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`medicine_id`);

--
-- Indexes for table `purchasedetails`
--
ALTER TABLE `purchasedetails`
  ADD PRIMARY KEY (`purchase_details_id`),
  ADD KEY `medicine_id` (`medicine_id`),
  ADD KEY `purchase_id` (`purchase_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `medicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `purchasedetails`
--
ALTER TABLE `purchasedetails`
  MODIFY `purchase_details_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`medicine_id`);

--
-- Constraints for table `purchasedetails`
--
ALTER TABLE `purchasedetails`
  ADD CONSTRAINT `purchasedetails_ibfk_1` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`medicine_id`),
  ADD CONSTRAINT `purchasedetails_ibfk_2` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`purchase_id`);

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
