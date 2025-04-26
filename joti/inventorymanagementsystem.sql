-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 25, 2025 at 10:59 PM
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


-- Create table
CREATE TABLE distribution_records (
  id INT AUTO_INCREMENT PRIMARY KEY,
  shipment_id VARCHAR(20) NOT NULL,
  item VARCHAR(255) NOT NULL,
  quantity INT NOT NULL,
  transport_mode VARCHAR(100) NOT NULL,
  receiver VARCHAR(255) NOT NULL,
  distribution_date DATE NOT NULL,
  departure_date DATE NOT NULL,
  arrival_date DATE NOT NULL,
  loading_loss INT DEFAULT 0,
  unloading_loss INT DEFAULT 0,
  harvest_loss INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    price_per_unit DECIMAL(10,2) NOT NULL,
    total_amount DECIMAL(12,2) NOT NULL,
    due_amount DECIMAL(12,2) NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    sale_date DATE NOT NULL
);


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
-- Indexes for table `warehouse_t`
--
ALTER TABLE `warehouse_t`
  ADD PRIMARY KEY (`Warehouse Name`(10));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
