-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2021 at 07:12 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `users`
--
CREATE DATABASE IF NOT EXISTS `users` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `users`;

-- --------------------------------------------------------

--
-- Table structure for table `leaguetable`
--

DROP TABLE IF EXISTS `leaguetable`;
CREATE TABLE `leaguetable` (
  `league_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `league_name` varchar(255) NOT NULL,
  `league_starting_balance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leaguetable`
--

INSERT INTO `leaguetable` (`league_id`, `user_id`, `league_name`, `league_starting_balance`) VALUES
(32, 5, 'league1', 1234);

-- --------------------------------------------------------

--
-- Table structure for table `playertable`
--

DROP TABLE IF EXISTS `playertable`;
CREATE TABLE `playertable` (
  `user_id` int(11) NOT NULL,
  `league_id` int(11) NOT NULL,
  `stock` longtext NOT NULL,
  `balance` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `playertable`
--

INSERT INTO `playertable` (`user_id`, `league_id`, `stock`, `balance`) VALUES
(5, 32, '{\"AAPL\":\"1\"}', 1102.81),
(7, 32, '', 1234);

-- --------------------------------------------------------

--
-- Table structure for table `usertable`
--

DROP TABLE IF EXISTS `usertable`;
CREATE TABLE `usertable` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usertable`
--

INSERT INTO `usertable` (`user_id`, `username`, `email`, `password`) VALUES
(2, 'James', 'james@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(5, 'Aryaman', 'aryaman.narayanan@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(7, 'John', 'john@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `leaguetable`
--
ALTER TABLE `leaguetable`
  ADD PRIMARY KEY (`league_id`,`user_id`),
  ADD KEY `constraint1` (`user_id`);

--
-- Indexes for table `playertable`
--
ALTER TABLE `playertable`
  ADD PRIMARY KEY (`user_id`,`league_id`),
  ADD KEY `league_id` (`league_id`);

--
-- Indexes for table `usertable`
--
ALTER TABLE `usertable`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `leaguetable`
--
ALTER TABLE `leaguetable`
  MODIFY `league_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `usertable`
--
ALTER TABLE `usertable`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `leaguetable`
--
ALTER TABLE `leaguetable`
  ADD CONSTRAINT `constraint1` FOREIGN KEY (`user_id`) REFERENCES `usertable` (`user_id`);

--
-- Constraints for table `playertable`
--
ALTER TABLE `playertable`
  ADD CONSTRAINT `playertable_ibfk_1` FOREIGN KEY (`league_id`) REFERENCES `leaguetable` (`league_id`),
  ADD CONSTRAINT `playertable_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `usertable` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
