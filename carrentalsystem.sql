-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2024 at 12:28 PM
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
-- Database: `carrentalsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, 'John', 'Doe', 'admin@gmail.com', '$2y$10$B2zCnbd8ekPOBaxHWFY/leWLIuwpAhzsZEtYELt8Ol7wuhTtW6Zhy');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `status` enum('active','out of service','rented') NOT NULL,
  `office_id` int(11) DEFAULT NULL,
  `price_per_day` decimal(10,2) NOT NULL,
  `plate_id` varchar(10) NOT NULL,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `model`, `year`, `status`, `office_id`, `price_per_day`, `plate_id`, `image`) VALUES
(1, 'Toyota Corolla', 2020, 'rented', 1, 3000.00, '', 'bmw-i5.png'),
(2, 'Honda Accord', 2019, 'rented', 1, 2000.00, '', 'bmw-i7.png'),
(3, 'Ford Mustang', 2021, 'active', 2, 1500.00, '', 'bmw-ix.png'),
(4, 'Chevrolet Malibu', 2018, 'active', 3, 2333.00, '', 'BMW-ix2.png'),
(5, 'Tesla Model 3', 2022, 'active', 2, 2000.00, '', 'bmw-i5.png'),
(10, 'adf', 2343, 'rented', 1, 2000.00, '', 'bmw-ix.png'),
(11, 'mbw', 2003, 'rented', 1, 480.00, '', 'bmw-i7.png'),
(12, 'bmw', 2003, 'active', 3, 140.00, '', 'bmw-i7.png'),
(13, 'bmw', 2003, 'active', 1, 300.00, '', 'bmw-ix.png'),
(14, 'mercedes', 2000, 'active', 3, 2300.00, '', 'BMW-ix2.png'),
(20, 'asdf', 23, 'active', 1, 200.00, '', 'bmw-i7.png'),
(21, 'asdf', 234, 'active', 1, 200.00, '', 'bmw-ix.png'),
(22, 'adsf', 2323, 'active', 1, 20.00, '', 'bmw-i7.png'),
(23, 'asdf', 234, 'active', 1, 20.00, '', 'bmw-i7.png'),
(24, 'asdf', 2000, 'active', 1, 2300.00, '', 'bmw-ix.png'),
(25, 'sdfg', 2300, 'active', 1, 2300.00, '', 'bmw-i5.png'),
(26, 'klasdjf', 2300, 'active', 1, 2300.00, '', 'bmw-i7.png'),
(27, 'asdf', 234, 'active', 1, 2300.00, '', 'bmw-ix.png'),
(28, 'adsf', 23, 'active', 1, 20.00, '', 'bmw-ix.png'),
(29, 'asdf', 2300, 'active', 1, 23000.00, '', 'bmw-i7.png'),
(30, 'sdf', 23, 'active', 1, 230.00, '', 'bmw-ix.png');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `first_name`, `last_name`, `email`, `phone_number`, `password`) VALUES
(1, 'ahmed', 'adel', 'ahmed@gmail.com', '01029957328', '$2y$10$BI.Mm/cxwHdH/nlF54K2KO7snldcltUAd9KmzvDolTtIUWiGMk7u6'),
(2, 'yehia', 'Doe', 'johndoe@example.com', '555-123-4567', 'password123'),
(3, 'Jane', 'Smith', 'janesmith@example.com', '555-234-5678', 'mypassword'),
(4, 'Alice', 'Johnson', 'alicej@example.com', '555-345-6789', 'securepass'),
(5, 'Bob', 'Brown', 'admin@gmail.com', '555-456-7890', '12345678'),
(6, 'ahmed', 'adel', 'ahmed@gmail.com', '01029957328', '$2y$10$GSnUo4JYXP1AJh8FJ8KpNuA59z0tdwUDLj3jyRXaWgRiMTMFcFCKy'),
(7, 'ahmed', 'adel', 'ahmed@gmail.com', '01029957328', '$2y$10$jQgPRjW6AA0lKeysWQ19DehkmZ7B6t.xxakGEfDL8J0gaxbuM6a/W'),
(8, 'ahmed', 'ahmed', 'ahmed2@gmail.com', '01029958', '$2y$10$UYNBXaxeBb5IXkcTPuZyJ.EJnKo8hd3TiYup3XWSX.Okv/feklPOK'),
(9, 'ahmeeeeeed', 'adddddddddddel', 'ahmed12@gmail.com', '01029957324', '$2y$10$.sAbQNxVvaKYUxAuWrmZU.x4It1SsNMrdhrYSXF1O9g2Oy6fPGzHa'),
(10, 'admin', 'admin', 'admin@gmail.com', '01000000000', '$2y$10$B2zCnbd8ekPOBaxHWFY/leWLIuwpAhzsZEtYELt8Ol7wuhTtW6Zhy');

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `office_id` int(11) NOT NULL,
  `office_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offices`
--

INSERT INTO `offices` (`office_id`, `office_name`, `location`, `phone_number`, `email`) VALUES
(1, 'Downtown Office', 'Alexandria', '123-456-7890', 'downtown@carrental.com'),
(2, 'Airport Office', 'Cairo', '234-567-8901', 'airport@carrental.com'),
(3, 'Elsisi office', 'Alexandria', '345-678-9012', 'suburban@carrental.com'),
(4, 'new_office', 'Alexandria', '019237843', 'a@gm.com');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `car_id` int(11) DEFAULT NULL,
  `reservation_status` enum('rented','upcoming') NOT NULL,
  `office_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `customer_id`, `car_id`, `reservation_status`, `office_id`, `start_date`, `end_date`, `total_price`) VALUES
(21, 1, 1, 'rented', 1, '2024-12-29', '2024-12-30', 3000.00),
(22, 1, 2, 'rented', 1, '2024-12-29', '2024-12-31', 2000.00),
(23, 1, 10, 'rented', 1, '2024-12-29', '2024-12-30', 2000.00),
(24, 1, 11, 'rented', 1, '2024-12-30', '2024-12-31', 480.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`),
  ADD KEY `office_id` (`office_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`office_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`) USING BTREE,
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `office_id` (`office_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `office_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`office_id`) REFERENCES `offices` (`office_id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`),
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`office_id`) REFERENCES `offices` (`office_id`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `manage_car_reservation_status` ON SCHEDULE EVERY 1 SECOND STARTS '2024-12-29 00:12:42' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    -- Set status of the car to 'active' when the reservation has ended
    UPDATE Cars c
    JOIN Reservations r ON c.car_id = r.car_id
    SET c.status = 'active'
    WHERE r.reservation_status = 'active'
      AND r.end_date < CURRENT_DATE;

	UPDATE cars c 
    JOIN reservations r on c.car_id = r.car_id
    set c.status = 'rented', 
    r.reservation_status = 'rented'
    WHERE r.start_date <= CURRENT_DATE;

    -- Delete the reservation that has ended
    DELETE FROM Reservations
    WHERE reservation_status = 'rented'
      AND end_date < CURRENT_DATE;

    -- Optionally: Update cars with 'active' status if they have no active reservations
    UPDATE Cars c
    LEFT JOIN Reservations r ON c.car_id = r.car_id
    SET c.status = 'active'
    WHERE r.car_id IS NULL OR r.end_date < CURRENT_DATE;
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
