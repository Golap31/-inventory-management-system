-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 30, 2025 at 06:09 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventorymanagementsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `Customer_T`
--

CREATE TABLE `Customer_T` (
  `Customer_Name` varchar(50) NOT NULL,
  `Customer_Phone` varchar(14) NOT NULL,
  `Customer_Email` varchar(40) NOT NULL,
  `Customer_City` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `harvestbatch`
--

CREATE TABLE `harvestbatch` (
  `HarvestBatchID` int(100) NOT NULL,
  `HarvestDate` date NOT NULL,
  `HarvestProduct` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `harvestbatch`
--

INSERT INTO `harvestbatch` (`HarvestBatchID`, `HarvestDate`, `HarvestProduct`) VALUES
(1, '2025-04-01', 'Apples'),
(2, '2025-04-03', 'Grapes'),
(3, '2025-04-05', 'Wheat'),
(4, '2025-04-07', 'Tomatoes'),
(5, '2025-04-10', 'Carrots');

-- --------------------------------------------------------

--
-- Table structure for table `improvement_updates`
--

CREATE TABLE `improvement_updates` (
  `id` int(11) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `batch_id` varchar(50) NOT NULL,
  `farmer_name` varchar(100) NOT NULL,
  `farmer_id` varchar(50) NOT NULL,
  `update_status` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `improvement_updates`
--

INSERT INTO `improvement_updates` (`id`, `product_id`, `batch_id`, `farmer_name`, `farmer_id`, `update_status`, `created_at`) VALUES
(1, 'P001', 'B001', 'Ravi Kumar', 'F123', 'Farmer is improving. Has reduced fertilizer usage.', '2025-04-29 13:07:29'),
(2, 'P002', 'B002', 'Sita', 'F124', 'Farmer is not improving. No change in pesticide routine.', '2025-04-29 13:07:29');

-- --------------------------------------------------------

--
-- Table structure for table `lossanalysis`
--

CREATE TABLE `lossanalysis` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `batch_code` varchar(50) DEFAULT NULL,
  `harvest_date` date DEFAULT NULL,
  `storage_location` varchar(100) DEFAULT NULL,
  `detected_issue` enum('Physical Damage','Spoilage','Other') NOT NULL,
  `issue_description` text DEFAULT NULL,
  `reported_by` varchar(100) DEFAULT NULL,
  `detected_date` datetime DEFAULT current_timestamp(),
  `expiry_date` date DEFAULT NULL,
  `alert_status` enum('Pending','Alert Sent','Resolved') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lossanalysis`
--

INSERT INTO `lossanalysis` (`id`, `product_name`, `batch_code`, `harvest_date`, `storage_location`, `detected_issue`, `issue_description`, `reported_by`, `detected_date`, `expiry_date`, `alert_status`) VALUES
(1, 'Tomatoes123', 'BATCH001', '2025-04-10', 'Cold Storage A', 'Spoilage', 'Signs of mold on surface', '', '2025-04-25 00:00:00', '2025-04-25', 'Pending'),
(2, 'Bananas', 'BATCH002', '2025-04-12', 'Warehouse B', 'Physical Damage', 'Bruised during transport', NULL, '2025-04-23 02:04:59', '2025-04-24', 'Pending'),
(3, 'Spinach', 'BATCH003', '2025-04-15', 'Refrigerator Unit 3', 'Spoilage', 'Leaves turning yellow', NULL, '2025-04-23 02:04:59', '2025-04-20', 'Alert Sent'),
(4, 'Apples', 'BATCH004', '2025-04-05', 'Cold Storage A', 'Physical Damage', 'Cracks on the skin observed', NULL, '2025-04-23 02:04:59', '2025-05-01', 'Resolved'),
(5, 'Strawberries', 'BATCH005', '2025-04-16', 'Warehouse C', 'Spoilage', 'Soft patches and foul smell', NULL, '2025-04-23 02:04:59', '2025-04-22', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `notificationlog`
--

CREATE TABLE `notificationlog` (
  `id` int(11) NOT NULL,
  `loss_id` int(11) NOT NULL,
  `notification_type` enum('Email','Push','Banner','SMS') NOT NULL,
  `status` enum('Sent','Failed') DEFAULT 'Sent',
  `message` text DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notificationlog`
--

INSERT INTO `notificationlog` (`id`, `loss_id`, `notification_type`, `status`, `message`, `sent_at`) VALUES
(1, 1, 'Email', 'Sent', 'Alert: Tomatoes are expiring on 2025-04-25.', '2025-04-23 14:09:48'),
(2, 2, 'Push', 'Sent', 'Alert: Bananas in Batch002 are nearing expiry.', '2025-04-23 14:09:48'),
(3, 3, 'Email', 'Sent', 'Critical Spoilage Alert: Spinach expiring on 2025-04-20.', '2025-04-23 14:09:48'),
(4, 4, 'Banner', 'Sent', 'Notice: Apples have damage but are safe till 2025-05-01.', '2025-04-23 14:09:48'),
(5, 5, 'SMS', 'Failed', 'Urgent: Strawberries show spoilage and are near expiry.', '2025-04-23 14:09:48');

-- --------------------------------------------------------

--
-- Table structure for table `preventive_measures`
--

CREATE TABLE `preventive_measures` (
  `id` int(11) NOT NULL,
  `product_id` varchar(50) NOT NULL,
  `batch_id` varchar(50) NOT NULL,
  `farmer_name` varchar(100) NOT NULL,
  `farmer_id` varchar(50) NOT NULL,
  `reason` text NOT NULL,
  `suggestion` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `preventive_measures`
--

INSERT INTO `preventive_measures` (`id`, `product_id`, `batch_id`, `farmer_name`, `farmer_id`, `reason`, `suggestion`, `created_at`) VALUES
(5, 'P003', 'B003', 'Jarif', 'F122', 'Incorrect pesticide', 'Follow recommended pesticide.', '2025-04-29 18:15:42'),
(6, 'P001', 'B001', 'Mehedi Hasan', 'F121', 'Incorrect pesticide', 'Follow recommended pesticide.', '2025-04-29 18:34:29');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) NOT NULL,
  `productname` varchar(300) NOT NULL,
  `type` varchar(300) NOT NULL,
  `quantity` int(20) NOT NULL,
  `storagelocation` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `productname`, `type`, `quantity`, `storagelocation`) VALUES
(1, 'Cauliflower', 'Vegetable ', 17, 'Cold Storage A'),
(2, 'Cabbage', 'Vegetable ', 12, 'Cold Storage B'),
(3, 'Carrots', 'Vegetable ', 15, 'Storage Room 1'),
(4, 'Tomato', 'Vegetable ', 17, 'Warehouse 4');

-- --------------------------------------------------------

--
-- Table structure for table `Purchase_T`
--

CREATE TABLE `Purchase_T` (
  `Purchase_ID` varchar(10) NOT NULL,
  `Toal_Amount` int(10) NOT NULL,
  `Paid_Amount` int(10) NOT NULL,
  `Due_Amount` int(10) NOT NULL,
  `Product_Purchased` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `SALES_DISTRIBUTION`
--

CREATE TABLE `SALES_DISTRIBUTION` (
  `Sales_ID` varchar(10) NOT NULL,
  `Shipment_ID` varchar(10) NOT NULL,
  `Buyer_Name` text NOT NULL,
  `Quantity_Sold` int(5) NOT NULL,
  `SaleDate` date NOT NULL,
  `SalePricePerUnit` int(5) NOT NULL,
  `MarketLocation` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipment`
--

CREATE TABLE `shipment` (
  `Sipment_ID` varchar(10) NOT NULL,
  `Product_ID` varchar(10) NOT NULL,
  `warehouse_ID` varchar(10) NOT NULL,
  `Transport_Mode` text NOT NULL,
  `Departure_Date` datetime NOT NULL,
  `Arrival_Date` datetime NOT NULL,
  `Transportation_Damage` text NOT NULL,
  `QuantitySold` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(4, 'Barley', 1200, 'Truck', '2025-04-07', '2025-04-08', 60.00, 35.00, '2025-04-30 01:01:16');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `lastName` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `signUpDate` datetime NOT NULL DEFAULT current_timestamp(),
  `isSubscribed` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Vendor_T`
--

CREATE TABLE `Vendor_T` (
  `Vendor_name` varchar(50) NOT NULL,
  `Vendor_Email` varchar(40) NOT NULL,
  `Vendor_Phone` varchar(14) NOT NULL,
  `Vendor_city` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_t`
--

CREATE TABLE `warehouse_t` (
  `Warehouse Name` varchar(50) NOT NULL,
  `Quantity Available` int(50) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `Capacity` int(10) NOT NULL,
  `Humidity` int(10) NOT NULL,
  `Temperature` int(10) NOT NULL,
  `Date Time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Customer_T`
--
ALTER TABLE `Customer_T`
  ADD PRIMARY KEY (`Customer_Name`);

--
-- Indexes for table `harvestbatch`
--
ALTER TABLE `harvestbatch`
  ADD PRIMARY KEY (`HarvestBatchID`);

--
-- Indexes for table `improvement_updates`
--
ALTER TABLE `improvement_updates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lossanalysis`
--
ALTER TABLE `lossanalysis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notificationlog`
--
ALTER TABLE `notificationlog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loss_id` (`loss_id`);

--
-- Indexes for table `preventive_measures`
--
ALTER TABLE `preventive_measures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Purchase_T`
--
ALTER TABLE `Purchase_T`
  ADD PRIMARY KEY (`Purchase_ID`);

--
-- Indexes for table `SALES_DISTRIBUTION`
--
ALTER TABLE `SALES_DISTRIBUTION`
  ADD PRIMARY KEY (`Sales_ID`);

--
-- Indexes for table `shipment`
--
ALTER TABLE `shipment`
  ADD PRIMARY KEY (`Sipment_ID`);

--
-- Indexes for table `shipments`
--
ALTER TABLE `shipments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Vendor_T`
--
ALTER TABLE `Vendor_T`
  ADD PRIMARY KEY (`Vendor_name`);

--
-- Indexes for table `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouse_t`
--
ALTER TABLE `warehouse_t`
  ADD PRIMARY KEY (`Warehouse Name`(10));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `improvement_updates`
--
ALTER TABLE `improvement_updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lossanalysis`
--
ALTER TABLE `lossanalysis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `notificationlog`
--
ALTER TABLE `notificationlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `preventive_measures`
--
ALTER TABLE `preventive_measures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shipments`
--
ALTER TABLE `shipments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warehouse`
--
ALTER TABLE `warehouse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notificationlog`
--
ALTER TABLE `notificationlog`
  ADD CONSTRAINT `notificationlog_ibfk_1` FOREIGN KEY (`loss_id`) REFERENCES `lossanalysis` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
