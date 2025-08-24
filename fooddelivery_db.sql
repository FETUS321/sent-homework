-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 23, 2025 at 09:07 AM
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_db`
--
ALTER TABLE `cart_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_db`
--
ALTER TABLE `menu_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
