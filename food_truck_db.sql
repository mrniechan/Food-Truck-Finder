-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2024 at 08:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_truck_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `food_trucks`
--

CREATE TABLE `food_trucks` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `menu` text DEFAULT NULL,
  `schedule` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_trucks`
--

INSERT INTO `food_trucks` (`id`, `name`, `latitude`, `longitude`, `menu`, `schedule`) VALUES
(6, 'Food Truck Anjung Siswa ', 6.44885, 100.28024, 'Ice cream, Coconut Milk Shake ', 'Daily:\r\n10:00 AM-12:00 PM'),
(7, 'Food Truck Kompleks Star', 6.4522602, 100.279151, 'Nasi Kerabu, Mee Sup', 'Weekend: 16:00 PM - 19:00 PM'),
(8, 'Food Truck Perpustakaan', 6.4500554, 100.2755085, 'Dessert and Drink', 'Friday: 16:00 PM - 19:00 PM'),
(9, 'Food Truck Padang Kawad', 6.4506131, 100.2750801, 'Puffs, Noodles, Soft Drinks', 'Mon - Wed : \r\n8:00 AM - 13:00 PM'),
(10, 'Food Truck Academic Heights', 6.4478841, 100.2743729, 'Coffee, Spaghetti, Soft Drinks', 'Weekend : 19:00 PM - 22:00 PM'),
(11, 'Food Truck Masjid An-Nur', 6.4477437, 100.2782532, 'Puffs, Nasi Lemak, Omelet, Teh Tarik', 'Thu - Fri : 8:00 AM - 13:00 PM');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_trucks`
--
ALTER TABLE `food_trucks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `food_trucks`
--
ALTER TABLE `food_trucks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
