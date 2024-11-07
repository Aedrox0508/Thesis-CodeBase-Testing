-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2024 at 12:13 PM
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
-- Database: `movewave_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `gesture`
--

CREATE TABLE `gesture` (
  `gesture_id` int(11) NOT NULL,
  `gesture_name` varchar(100) NOT NULL,
  `gesture_value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gesture`
--

INSERT INTO `gesture` (`gesture_id`, `gesture_name`, `gesture_value`) VALUES
(1, 'Com1', 'Thumb'),
(2, 'Com2', 'Thumb Index'),
(3, 'Com3', 'Thumb Middle'),
(4, 'Com4', 'Thumb Ring'),
(5, 'Com5', 'Thumb Pinky'),
(6, 'Com6', 'Index'),
(7, 'Com7', 'Index Middle'),
(8, 'Com8', 'Index Ring'),
(9, 'Com9', 'Index Pinky'),
(10, 'Com10', 'Middle'),
(11, 'Com11', 'Middle Ring'),
(12, 'Com12', 'Middle Pinky'),
(13, 'Com13', 'Ring'),
(14, 'Com14', 'Ring Pinky'),
(15, 'Com15', 'Pinky'),
(16, 'Com 16', 'Index Middle Ring Pointer'),
(17, 'Com 17', 'Pointer Middle Ring'),
(18, 'Com 18', 'Thumb  Middle Ring '),
(19, 'Com19', 'Middle Pointer Pinky');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
