-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2023 at 05:27 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `catering_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `ID` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `role` varchar(30) NOT NULL,
  `facility_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`ID`, `first_name`, `last_name`, `role`, `facility_ID`) VALUES
(1, 'tiemen', 'de jong', 'janitor', 8);

-- --------------------------------------------------------

--
-- Table structure for table `facility`
--

CREATE TABLE `facility` (
  `facility_ID` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `creation_date` date DEFAULT NULL,
  `location_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facility`
--

INSERT INTO `facility` (`facility_ID`, `name`, `creation_date`, `location_ID`) VALUES
(8, 'rotjeknor catering', '2023-03-16', 1),
(9, 'gouda catering', '2023-03-16', 2);

-- --------------------------------------------------------

--
-- Table structure for table `facility_tag`
--

CREATE TABLE `facility_tag` (
  `facility_ID` int(11) NOT NULL,
  `tag_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facility_tag`
--

INSERT INTO `facility_tag` (`facility_ID`, `tag_name`) VALUES
(8, 'tag3');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `ID` int(11) NOT NULL,
  `city` varchar(30) NOT NULL,
  `address` varchar(30) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `country_code` int(10) NOT NULL,
  `phone_number` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`ID`, `city`, `address`, `zip_code`, `country_code`, `phone_number`) VALUES
(1, 'Rotterdam', 'maasboulevard 5', '0010 xa', 31, 2147483647),
(2, 'Gouda', 'kaaslaan 12', '1234 xp', 31, 2147483647),
(3, 'Alphen a/d rijn', 'struikenpad 13', '1234 se', 31, 2147483647);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`name`) VALUES
('tag1'),
('tag2'),
('tag3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `facility_ID` (`facility_ID`);

--
-- Indexes for table `facility`
--
ALTER TABLE `facility`
  ADD PRIMARY KEY (`facility_ID`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `location_ID` (`location_ID`);

--
-- Indexes for table `facility_tag`
--
ALTER TABLE `facility_tag`
  ADD KEY `facility_tag_ibfk_1` (`facility_ID`),
  ADD KEY `tag_name` (`tag_name`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `location` (`city`,`address`,`zip_code`,`country_code`) USING BTREE;

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `facility`
--
ALTER TABLE `facility`
  MODIFY `facility_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`facility_ID`) REFERENCES `facility` (`facility_ID`);

--
-- Constraints for table `facility`
--
ALTER TABLE `facility`
  ADD CONSTRAINT `facility_ibfk_1` FOREIGN KEY (`location_ID`) REFERENCES `location` (`ID`);

--
-- Constraints for table `facility_tag`
--
ALTER TABLE `facility_tag`
  ADD CONSTRAINT `facility_tag_ibfk_1` FOREIGN KEY (`facility_ID`) REFERENCES `facility` (`facility_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `facility_tag_ibfk_2` FOREIGN KEY (`tag_name`) REFERENCES `tag` (`name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
