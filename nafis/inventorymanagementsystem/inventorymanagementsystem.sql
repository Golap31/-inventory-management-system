-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2025 at 03:02 AM
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
-- Database: `real_time_monitoring_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `shipments`
--

CREATE TABLE `shipments` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `transport_mode` varchar(100) NOT NULL,
  `departure_date` date NOT NULL,
  `arrival_date` date NOT NULL,
  `loading_loss` decimal(10,2) NOT NULL,
  `unloading_loss` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipments`
--

INSERT INTO `shipments` (`id`, `product_name`, `quantity`, `transport_mode`, `departure_date`, `arrival_date`, `loading_loss`, `unloading_loss`, `created_at`) VALUES
(1, 'Rice', 1000, 'Truck', '2025-04-01', '2025-04-02', 50.00, 30.00, '2025-04-30 01:01:16'),
(2, 'Wheat', 2000, 'Train', '2025-04-03', '2025-04-04', 100.00, 40.00, '2025-04-30 01:01:16'),
(3, 'Corn', 1500, 'Ship', '2025-04-05', '2025-04-06', 75.00, 50.00, '2025-04-30 01:01:16'),
(4, 'Barley', 1200, 'Truck', '2025-04-07', '2025-04-08', 60.00, 35.00, '2025-04-30 01:01:16'),
(5, 'Soybeans', 800, 'Train', '2025-04-09', '2025-04-10', 40.00, 25.00, '2025-04-30 01:01:16');

-- --------------------------------------------------------

--
-- Table structure for table `warehouse`
--

CREATE TABLE `warehouse` (
  `id` int(11) NOT NULL,
  `sensor_id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `address` text DEFAULT NULL,
  `capacity` varchar(50) DEFAULT NULL,
  `temperature` decimal(5,2) DEFAULT NULL,
  `humidity` decimal(5,2) DEFAULT NULL,
  `last_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warehouse`
--

INSERT INTO `warehouse` (`id`, `sensor_id`, `name`, `location`, `address`, `capacity`, `temperature`, `humidity`, `last_updated`) VALUES
(1, 'SEN-101', 'Warehouse A', 'Naogaon', '123 Main Road, Naogaon', '2000 kg', 26.50, 60.20, '2025-04-30 06:31:01'),
(2, 'SEN-102', 'Warehouse B', 'Dhaka', '456 Industrial Zone, Dhaka', '3000 kg', 28.00, 55.80, '2025-04-30 06:31:01'),
(3, 'SEN-103', 'Warehouse C', 'Rajshahi', '789 Depot St, Rajshahi', '1500 kg', 25.00, 65.00, '2025-04-30 06:31:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `shipments`
--
ALTER TABLE `shipments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `shipments`
--
ALTER TABLE `shipments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `warehouse`
--
ALTER TABLE `warehouse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
