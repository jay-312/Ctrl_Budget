-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2021 at 02:44 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `expense_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `amount` int(11) NOT NULL,
  `spent_by` varchar(255) NOT NULL,
  `bill` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expense_id`, `plan_id`, `title`, `date`, `amount`, `spent_by`, `bill`) VALUES
(1, 1, 'Food', '2021-05-18', 500, 'Jay Agrawal', NULL),
(2, 1, 'Movie', '2021-05-17', 1000, 'Lav', NULL),
(5, 1, 'Travel', '2021-05-21', 750, 'Abhishek', NULL),
(6, 2, 'Food', '2021-06-01', 1000, 'Jay Agrawal', NULL),
(8, 2, 'Movie', '2021-06-17', 500, 'Jay Agrawal', NULL),
(9, 2, 'Food', '2021-06-25', 200, 'Jay Agrawal', 'img/25-05-2021-1621955005.jpg'),
(10, 1, 'Food', '2021-05-18', 1000, 'Jayket', 'img/26-05-2021-1622032289.jpg'),
(11, 1, 'Drinks', '2021-05-21', 1000, 'Harshit', 'img/26-05-2021-1622032326.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `plan_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `budget` int(15) NOT NULL,
  `people` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`plan_id`, `user_id`, `title`, `date_from`, `date_to`, `budget`, `people`) VALUES
(1, 1, 'Trip to goa', '2021-05-17', '2021-05-23', 5000, 5),
(2, 1, 'Chennai', '2021-06-01', '2021-06-30', 10000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `plan_group`
--

CREATE TABLE `plan_group` (
  `plan_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plan_group`
--

INSERT INTO `plan_group` (`plan_id`, `name`, `amount`) VALUES
(1, 'Jay Agrawal', 500),
(1, 'Lav', 1000),
(1, 'Jayket', 1000),
(1, 'Harshit', 1000),
(1, 'Abhishek', 750),
(2, 'Jay Agrawal', 1700);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_no` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `phone_no`) VALUES
(1, 'Jay Agrawal', 'jayagarwal002@gmail.com', '4abe2e2fd94974b68a9bd3b2dd75db36', '8153837845');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`),
  ADD KEY `FK__plans_expense` (`plan_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`plan_id`),
  ADD KEY `FK__users_plans` (`user_id`);

--
-- Indexes for table `plan_group`
--
ALTER TABLE `plan_group`
  ADD KEY `FK__plans_plans_group` (`plan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `FK__plans_expense` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`plan_id`);

--
-- Constraints for table `plans`
--
ALTER TABLE `plans`
  ADD CONSTRAINT `FK__users_plans` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `plan_group`
--
ALTER TABLE `plan_group`
  ADD CONSTRAINT `FK__plans_plans_group` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`plan_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
