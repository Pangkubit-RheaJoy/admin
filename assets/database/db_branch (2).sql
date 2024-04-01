-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2024 at 04:18 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_branch`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `UserId` int(11) NOT NULL,
  `LN` varchar(25) NOT NULL,
  `FN` varchar(25) NOT NULL,
  `MN` varchar(25) NOT NULL,
  `Cp` int(25) NOT NULL,
  `UserName` varchar(25) NOT NULL,
  `Pass` varchar(12) NOT NULL,
  `position` varchar(11) NOT NULL,
  `position_value` int(255) NOT NULL,
  `Employno` varchar(25) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`UserId`, `LN`, `FN`, `MN`, `Cp`, `UserName`, `Pass`, `position`, `position_value`, `Employno`, `branch_id`) VALUES
(1, 'Gamboa', 'Romel', 'S', 46654324, 'admin@admin', 'admin', 'SuperAdmin', 0, 'Main Branch', 0),
(2, 'Peralta', 'Marshiella', 'M', 2147483647, 'candaba@staff', 'Staff@1', 'Staff', 3, ' Candaba,Pampanga', 1),
(3, 'Gomez', 'Dexter', 'A', 32123242, 'staana@staff', 'Staff@2', 'Staff', 3, 'Sta.Ana,Pampanga', 2),
(4, 'Larin', 'Kyle', 'E', 546576435, 'sanluis@staff', 'Staff@3', 'Staff', 3, 'San Luis,Pampanga', 3),
(5, 'Estoque', 'Rence', 'P', 32435453, 'mexico@staff', 'Staff@4', 'Staff', 3, 'Mexico, Pampanga', 4),
(6, 'Gurr', 'Alexis', 'O', 983494292, 'arayat@staff', 'Staff@5', 'Staff', 3, 'Arayat, Pampanga', 5);

-- --------------------------------------------------------

--
-- Table structure for table `requested_materials`
--

CREATE TABLE `requested_materials` (
  `id` int(11) NOT NULL,
  `material` varchar(255) NOT NULL,
  `material_type` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `ticket_number` varchar(255) NOT NULL,
  `Request_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Confirm_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Shipping_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Received_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `Status_id` int(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requested_materials`
--

INSERT INTO `requested_materials` (`id`, `material`, `material_type`, `quantity`, `ticket_number`, `Request_date`, `Confirm_date`, `Shipping_date`, `Received_date`, `Status`, `message`, `Status_id`, `product_id`, `branch_id`) VALUES
(1, 'Vanilla', '', 95, '1711980392', '2024-04-01 14:11:39', '2024-04-01 23:07:42', '2024-04-01 23:07:45', '2024-04-01 23:07:50', 'Product Received', 'Hello! Our branch was requesting a product', 3, 1, 0),
(2, 'Straw', '', 91, '1711980392', '2024-04-01 14:11:39', '2024-04-01 23:07:42', '2024-04-01 23:07:45', '2024-04-01 23:07:50', 'Product Received', 'Hello! Our branch was requesting a product', 3, 2, 0),
(3, 'Cups', '', 91, '1711980392', '2024-04-01 14:11:39', '2024-04-01 23:07:42', '2024-04-01 23:07:45', '2024-04-01 23:07:50', 'Product Received', 'Hello! Our branch was requesting a product', 3, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_branch`
--

CREATE TABLE `tbl_branch` (
  `branch_id` int(11) NOT NULL,
  `location` text NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_branch`
--

INSERT INTO `tbl_branch` (`branch_id`, `location`, `name`, `number`) VALUES
(1, ' Candaba,Pampanga', 'Marshiella M Peralta', 2147483647),
(2, 'Sta.Ana,Pampanga', 'Dexter Gomez', 111111),
(3, 'San Luis,Pampanga', 'Kyle Larin', 32123242),
(4, 'Mexico, Pampanga', 'Rence Estoque', 2147483647),
(5, 'Arayat, Pampanga', 'Alexis Gurr', 983494292);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cashproduct`
--

CREATE TABLE `tbl_cashproduct` (
  `id` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `img` blob NOT NULL,
  `product_id` int(11) NOT NULL,
  `S_Price` int(11) NOT NULL,
  `M_price` int(11) NOT NULL,
  `L_price` int(11) NOT NULL,
  `S_Quantity` int(11) NOT NULL,
  `M_Quantity` int(11) NOT NULL,
  `L_Quantity` int(11) NOT NULL,
  `productType` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_cashproduct`
--

INSERT INTO `tbl_cashproduct` (`id`, `productName`, `img`, `product_id`, `S_Price`, `M_price`, `L_price`, `S_Quantity`, `M_Quantity`, `L_Quantity`, `productType`, `price`, `quantity`, `branch_id`, `menu_id`) VALUES
(2, 'Vanilla', 0x666f746f722d61692d32303233313130333233353431312e6a7067, 0, 80, 90, 100, 0, 0, 0, '', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu`
--

CREATE TABLE `tbl_menu` (
  `menu_id` int(11) NOT NULL,
  `PN` varchar(255) NOT NULL,
  `img` blob NOT NULL,
  `S_price` int(11) NOT NULL,
  `M_price` int(11) NOT NULL,
  `L_price` int(11) NOT NULL,
  `foodtype` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_menu`
--

INSERT INTO `tbl_menu` (`menu_id`, `PN`, `img`, `S_price`, `M_price`, `L_price`, `foodtype`, `price`, `quantity`) VALUES
(1, 'Spaghetti', 0x537061672e6a7067, 0, 0, 0, 'Food', 90, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `ProductID` int(11) NOT NULL,
  `image` blob NOT NULL,
  `Product_type` varchar(255) NOT NULL,
  `Product_type_value` int(10) NOT NULL,
  `Product_name` varchar(255) NOT NULL,
  `Product_quantity` int(255) NOT NULL,
  `Product_price` int(255) NOT NULL,
  `Product_unit` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`ProductID`, `image`, `Product_type`, `Product_type_value`, `Product_name`, `Product_quantity`, `Product_price`, `Product_unit`) VALUES
(1, '', '', 0, 'Vanilla', 400, 0, ' sachet'),
(2, '', '', 0, 'Straw', 400, 0, ' pieces'),
(3, '', '', 0, 'Cups', 400, 0, ' pieces');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_receipt`
--

CREATE TABLE `tbl_receipt` (
  `receiptID` int(11) NOT NULL,
  `P_name` varchar(255) NOT NULL,
  `P_price` int(255) NOT NULL,
  `P_Quantity` int(255) NOT NULL,
  `tendered` int(255) NOT NULL,
  `total` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_receipt`
--

INSERT INTO `tbl_receipt` (`receiptID`, `P_name`, `P_price`, `P_Quantity`, `tendered`, `total`) VALUES
(2, 'Nestie', 11, 2990, 0, 0),
(3, 'Nestie', 11, 2990, 0, 0),
(4, 'Nestie', 11, 2990, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_request`
--

CREATE TABLE `tbl_request` (
  `request_id` int(11) NOT NULL,
  `R_name` varchar(255) NOT NULL,
  `R_type` varchar(255) NOT NULL,
  `R_quantity` int(255) NOT NULL,
  `R_image` blob NOT NULL,
  `R_status` varchar(255) NOT NULL,
  `R_status_value` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_request_person`
--

CREATE TABLE `tbl_request_person` (
  `Request_PepId` int(11) NOT NULL,
  `Branch_id` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  `User_branch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_request_person`
--

INSERT INTO `tbl_request_person` (`Request_PepId`, `Branch_id`, `User_id`, `User_branch`) VALUES
(1, 1711980392, 6, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sales`
--

CREATE TABLE `tbl_sales` (
  `id` int(11) NOT NULL,
  `P_name` varchar(255) NOT NULL,
  `Price` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Total` int(11) NOT NULL,
  `Changed` int(11) NOT NULL,
  `Order_No` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `product_size` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_sales`
--

INSERT INTO `tbl_sales` (`id`, `P_name`, `Price`, `Quantity`, `Total`, `Changed`, `Order_No`, `branch_id`, `date`, `product_size`) VALUES
(1, 'Vanilla', 80, 5, 400, 100, 'ORD17119804801114103', 5, '2024-04-01 07:08:08', 'S'),
(2, 'Vanilla', 80, 5, 400, 100, 'ORD17119806235062459', 5, '2024-04-01 07:10:30', 'S'),
(3, 'Vanilla', 80, 4, 320, 80, 'ORD17119806505357575', 5, '2024-04-01 07:10:56', 'S'),
(4, 'Vanilla', 80, 5, 400, 100, 'ORD17119806895369492', 5, '2024-04-01 07:11:39', 'S');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`UserId`);

--
-- Indexes for table `requested_materials`
--
ALTER TABLE `requested_materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_branch`
--
ALTER TABLE `tbl_branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `tbl_cashproduct`
--
ALTER TABLE `tbl_cashproduct`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_menu`
--
ALTER TABLE `tbl_menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `tbl_receipt`
--
ALTER TABLE `tbl_receipt`
  ADD PRIMARY KEY (`receiptID`);

--
-- Indexes for table `tbl_request`
--
ALTER TABLE `tbl_request`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `tbl_request_person`
--
ALTER TABLE `tbl_request_person`
  ADD PRIMARY KEY (`Request_PepId`);

--
-- Indexes for table `tbl_sales`
--
ALTER TABLE `tbl_sales`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `requested_materials`
--
ALTER TABLE `requested_materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_branch`
--
ALTER TABLE `tbl_branch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_cashproduct`
--
ALTER TABLE `tbl_cashproduct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_menu`
--
ALTER TABLE `tbl_menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_receipt`
--
ALTER TABLE `tbl_receipt`
  MODIFY `receiptID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_request`
--
ALTER TABLE `tbl_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_request_person`
--
ALTER TABLE `tbl_request_person`
  MODIFY `Request_PepId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_sales`
--
ALTER TABLE `tbl_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
