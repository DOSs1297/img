-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 18, 2024 at 03:57 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

DROP TABLE IF EXISTS `booking`;
CREATE TABLE IF NOT EXISTS `booking` (
  `booking_id` int NOT NULL AUTO_INCREMENT,
  `room_id` int NOT NULL,
  `check_in` datetime NOT NULL,
  `check_out` datetime NOT NULL,
  `pax` int NOT NULL,
  `phone` text NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`booking_id`),
  KEY `room_id` (`room_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `room_id`, `check_in`, `check_out`, `pax`, `phone`, `user_id`) VALUES
(1, 1, '2024-06-17 00:00:00', '2024-06-24 18:06:00', 1, '09123456789', 21),
(2, 1, '2024-06-25 06:05:00', '2024-06-26 18:06:00', 1, '9123456789', 24);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE IF NOT EXISTS `rooms` (
  `room_id` int NOT NULL,
  `room_name` varchar(256) NOT NULL,
  `room_price` double(9,2) NOT NULL,
  `facility` text NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`room_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_name`, `room_price`, `facility`, `picture`) VALUES
(1, 'Cottage 1000', 2000.00, 'With Videoke', 'uploads/asdgasg_1718681695.png'),
(2, 'Function Hall', 1000.00, 'With Private,CR,Room,Kitchen', 'uploads/441877946_738622618206457_3998596668645224175_n_1718681701.jpg'),
(3, 'Room', 1000.00, 'With Two Bedroom and Aircon', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `User_Id` int NOT NULL AUTO_INCREMENT,
  `account_type` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `birthday` date DEFAULT NULL,
  `sex` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_profile_picture` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`User_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_Id`, `account_type`, `username`, `password`, `firstname`, `lastname`, `birthday`, `sex`, `user_email`, `user_profile_picture`) VALUES
(1, 1, 'Mickey', 'Mouse', '', '', NULL, '', '', ''),
(2, 0, 'Cheese', 'Hotdog', '', '', NULL, '', '', ''),
(3, 0, 'Foot', 'Long', '', '', NULL, '', '', ''),
(12, 0, 'Rey', 'pass', 'Rey', 'Malicse', '2002-03-03', 'male', '', ''),
(14, 0, 'anakniluka', 'mavs', 'dj', 'aquino', '2003-09-27', 'male', '', ''),
(21, 1, 'rey1', '$2y$10$PJXnifnJlFv4o5DxoC5G3esf7DmpRo8BNfmahFr1RxYaq3cjfgm4i', 'Rey ', 'Malicse', '2002-03-03', 'Male', 'reywillardd01@gmail.com', 'uploads/profile pic_1716340929.jpg'),
(23, 0, 'admin', '$2y$10$ZMFMvEoVvo9bza25XfuCserQ9dtrh93TzLE59/0bVu0fsgBCW5ow.', 'Rey Willard ', 'Malicse', '2002-03-30', 'Male', 'malicsuave@gmail.com', 'uploads/asdgasg_1718681322.png'),
(24, 1, 'customer', '$2y$10$keBynbf8p7mQTn4htB4zRO4jhuvMPwfXBCc6FXjIKDVEP65jtpFHC', 'John', 'Doe', '1232-03-12', 'Male', 'you@gmail.com', 'uploads/OIP_1716447605.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

DROP TABLE IF EXISTS `user_address`;
CREATE TABLE IF NOT EXISTS `user_address` (
  `user_add_id` int NOT NULL AUTO_INCREMENT,
  `User_Id` int DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `barangay` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `province` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`user_add_id`),
  KEY `User_Id` (`User_Id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`user_add_id`, `User_Id`, `street`, `barangay`, `city`, `province`) VALUES
(7, 21, 'Purok 1', 'Sico', 'Lipa City', 'Region IV-A (CALABARZON)'),
(9, 23, 'Purok 1', 'Sico', 'Lipa City', 'Region IV-A (CALABARZON)'),
(10, 24, '123', 'Sico', 'Lipa City', 'Region IV-A (CALABARZON)');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `user_address_ibfk_1` FOREIGN KEY (`User_Id`) REFERENCES `users` (`User_Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
