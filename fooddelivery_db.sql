-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 24, 2025 at 06:22 PM
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
-- Database: `fooddelivery_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_db`
--

CREATE TABLE `cart_db` (
  `id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `rating` tinyint(4) DEFAULT NULL CHECK (`rating` between 1 and 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `food_id`, `username`, `comment`, `create_at`, `rating`) VALUES
(1, 1, 'FETUS', 'กหดเ้่รานย', '2025-08-23 08:11:36', NULL),
(2, 1, 'กกก', 'กกก', '2025-08-23 08:13:18', NULL),
(3, 1, 'FETUSก', 'กกก', '2025-08-23 08:13:55', NULL),
(4, 1, 'FETUSก', 'กกก', '2025-08-23 08:14:06', NULL),
(5, 1, 'หห', 'หห', '2025-08-23 08:14:25', NULL),
(6, 1, 'FETUS', 'หกกหดด', '2025-08-23 08:14:54', NULL),
(7, 2, 'FETUS', 'ฟหกฟกหก', '2025-08-23 08:15:16', NULL),
(8, 1, 'FETUS', '้เเร', '2025-08-23 08:42:59', 5),
(9, 1, 'หกด', 'หกด', '2025-08-23 09:40:53', 1),
(10, 1, 'FETUS', 'ๅ/_ๅ/_ๅ/_', '2025-08-24 09:15:09', 4);

-- --------------------------------------------------------

--
-- Table structure for table `menu_db`
--

CREATE TABLE `menu_db` (
  `id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `category` enum('ข้าว','ของทอด','ยำ') NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `detail` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu_db`
--

INSERT INTO `menu_db` (`id`, `food_name`, `category`, `price`, `detail`) VALUES
(1, 'ข้าวไข่ข้น', 'ข้าว', 40.00, 'ไขข้นๆ คนจนลืมคนเก่า'),
(2, 'ข้าวไข่ข้นกุ้ง', 'ข้าว', 50.00, 'มันกุ้งเยิมๆ ทำให้คิดถึงใคร'),
(3, 'ข้าวไข่ข้นหมูกรอบ', 'ข้าว', 50.00, 'หมูกรอบๆ แกรบๆ'),
(4, 'ข้าวไก่ทอด', 'ของทอด', 50.00, 'ไก่ที่ถูกทอดทิ้ง'),
(5, 'ข้าวหมูทอด', 'ของทอด', 50.00, 'หมูถึงงิด คิดถึงหนู'),
(6, 'นักเก็ต', 'ของทอด', 50.00, 'นักเก็ต นักรัก อร๊าย'),
(7, 'ยำหมูยอ', 'ยำ', 50.00, 'ยำงี้ รุมเลยดีกว่า'),
(8, 'ยำวุ้นเส้น', 'ยำ', 40.00, 'ยำวุ้นเส้น วะกะกะ');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL,
  `final_total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `total`, `discount`, `final_total`, `created_at`, `order_date`) VALUES
(1, 160.00, 4.80, 155.20, '2025-08-24 08:46:15', '2025-08-24 08:46:15'),
(2, 160.00, 4.80, 155.20, '2025-08-24 08:46:19', '2025-08-24 08:46:19'),
(3, 160.00, 4.80, 155.20, '2025-08-24 08:46:57', '2025-08-24 08:46:57'),
(4, 160.00, 4.80, 155.20, '2025-08-24 08:47:42', '2025-08-24 08:47:42'),
(5, 15870.00, 1587.00, 14283.00, '2025-08-24 08:49:59', '2025-08-24 08:49:59'),
(6, 1200.00, 120.00, 1080.00, '2025-08-24 08:50:57', '2025-08-24 08:50:57'),
(7, 90.00, 0.00, 90.00, '2025-08-24 09:17:02', '2025-08-24 09:17:02'),
(8, 200.00, 6.00, 194.00, '2025-08-24 09:17:49', '2025-08-24 09:17:49');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `food_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `food_name`, `price`, `quantity`, `subtotal`) VALUES
(1, 4, 'ข้าวไข่ข้น', 40.00, 4, NULL),
(2, 5, 'ข้าวไข่ข้น', 40.00, 18, NULL),
(3, 5, 'ข้าวไข่ข้นกุ้ง', 50.00, 27, NULL),
(4, 5, 'ข้าวไข่ข้นหมูกรอบ', 50.00, 54, NULL),
(5, 5, 'ข้าวไก่ทอด', 50.00, 40, NULL),
(6, 5, 'ข้าวหมูทอด', 50.00, 30, NULL),
(7, 5, 'นักเก็ต', 50.00, 49, NULL),
(8, 5, 'ยำหมูยอ', 50.00, 63, NULL),
(9, 5, 'ยำวุ้นเส้น', 40.00, 50, NULL),
(10, 6, 'ยำวุ้นเส้น', 40.00, 30, NULL),
(11, 7, 'ข้าวไข่ข้น', 40.00, 1, NULL),
(12, 7, 'ข้าวไข่ข้นกุ้ง', 50.00, 1, NULL),
(13, 8, 'ข้าวไข่ข้น', 40.00, 5, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_db`
--
ALTER TABLE `cart_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_db`
--
ALTER TABLE `menu_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_db`
--
ALTER TABLE `cart_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `menu_db`
--
ALTER TABLE `menu_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
