-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 07, 2020 at 11:55 AM
-- Server version: 8.0.20
-- PHP Version: 7.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lizeva1q_mysite`
--
CREATE DATABASE IF NOT EXISTS `lizeva1q_mysite` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `lizeva1q_mysite`;

-- --------------------------------------------------------

--
-- Stand-in structure for view `balances`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `balances`;
CREATE TABLE IF NOT EXISTS `balances` (
`achternaam` varchar(50)
,`TotalBalance` decimal(33,0)
,`userid` bigint
,`voornaam` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `negativebalances`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `negativebalances`;
CREATE TABLE IF NOT EXISTS `negativebalances` (
`achternaam` varchar(50)
,`negativebalance` decimal(32,0)
,`userid` bigint
,`voornaam` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `positivebalances`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `positivebalances`;
CREATE TABLE IF NOT EXISTS `positivebalances` (
`achternaam` varchar(50)
,`positivebalance` decimal(32,0)
,`userid` int
,`voornaam` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `transactionoverwiew`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `transactionoverwiew`;
CREATE TABLE IF NOT EXISTS `transactionoverwiew` (
`amount` int
,`comment` varchar(200)
,`receiver` varchar(101)
,`receiverid` int
,`sender` varchar(101)
,`senderid` int
,`timestamp` timestamp
,`transactionId` int
);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `transactionId` int NOT NULL AUTO_INCREMENT,
  `sender` int DEFAULT NULL,
  `receiver` int NOT NULL,
  `amount` int NOT NULL,
  `comment` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`transactionId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Truncate table before insert `transactions`
--

TRUNCATE TABLE `transactions`;
--
-- Dumping data for table `transactions`
--
-- --------------------------------------------------------

--
-- Stand-in structure for view `userlookup`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `userlookup`;
CREATE TABLE IF NOT EXISTS `userlookup` (
`firstname` varchar(50)
,`lastname` varchar(50)
,`userid` int
,`username` varchar(150)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userid` int NOT NULL AUTO_INCREMENT,
  `username` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `PASSWORD` varchar(100) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Truncate table before insert `users`
--

TRUNCATE TABLE `users`;
--
-- Dumping data for table `users`
--
-- --------------------------------------------------------

--
-- Structure for view `balances`
--
DROP TABLE IF EXISTS `balances`;

DROP VIEW IF EXISTS `balances`;
CREATE ALGORITHM=UNDEFINED DEFINER=`lizeva1q_root`@`localhost` SQL SECURITY DEFINER VIEW `balances`  AS  select (coalesce(`pb`.`positivebalance`,0) - coalesce(`nb`.`negativebalance`,0)) AS `TotalBalance`,coalesce(`pb`.`userid`,`nb`.`userid`) AS `userid`,coalesce(`pb`.`voornaam`,`nb`.`voornaam`) AS `voornaam`,coalesce(`pb`.`achternaam`,`nb`.`achternaam`) AS `achternaam` from (`negativebalances` `nb` left join `positivebalances` `pb` on((`nb`.`userid` = `pb`.`userid`))) union select (coalesce(`pb`.`positivebalance`,0) - coalesce(`nb`.`negativebalance`,0)) AS `TotalBalance`,coalesce(`pb`.`userid`,`nb`.`userid`) AS `userid`,coalesce(`pb`.`voornaam`,`nb`.`voornaam`) AS `voornaam`,coalesce(`pb`.`achternaam`,`nb`.`achternaam`) AS `achternaam` from (`positivebalances` `pb` left join `negativebalances` `nb` on((`nb`.`userid` = `pb`.`userid`))) ;

-- --------------------------------------------------------

--
-- Structure for view `negativebalances`
--
DROP TABLE IF EXISTS `negativebalances`;

DROP VIEW IF EXISTS `negativebalances`;
CREATE ALGORITHM=UNDEFINED DEFINER=`lizeva1q_root`@`localhost` SQL SECURITY DEFINER VIEW `negativebalances`  AS  select coalesce(sum(`tr`.`amount`),0) AS `negativebalance`,coalesce(`senderlookup`.`userid`,0) AS `userid`,coalesce(`senderlookup`.`firstname`,'ADMIN') AS `voornaam`,coalesce(`senderlookup`.`lastname`,'M1000') AS `achternaam` from (`transactions` `tr` left join `userlookup` `senderlookup` on((`senderlookup`.`userid` = `tr`.`sender`))) group by `senderlookup`.`userid` ;

-- --------------------------------------------------------

--
-- Structure for view `positivebalances`
--
DROP TABLE IF EXISTS `positivebalances`;

DROP VIEW IF EXISTS `positivebalances`;
CREATE ALGORITHM=UNDEFINED DEFINER=`lizeva1q_root`@`localhost` SQL SECURITY DEFINER VIEW `positivebalances`  AS  select coalesce(sum(`tr`.`amount`),0) AS `positivebalance`,`receiverlookup`.`userid` AS `userid`,`receiverlookup`.`lastname` AS `voornaam`,`receiverlookup`.`firstname` AS `achternaam` from (`transactions` `tr` left join `userlookup` `receiverlookup` on((`receiverlookup`.`userid` = `tr`.`receiver`))) group by `receiverlookup`.`userid` ;

-- --------------------------------------------------------

--
-- Structure for view `transactionoverwiew`
--
DROP TABLE IF EXISTS `transactionoverwiew`;

DROP VIEW IF EXISTS `transactionoverwiew`;
CREATE ALGORITHM=UNDEFINED DEFINER=`lizeva1q_root`@`localhost` SQL SECURITY DEFINER VIEW `transactionoverwiew`  AS  select `tr`.`transactionId` AS `transactionId`,coalesce(concat(`ulsender`.`firstname`,' ',`ulsender`.`lastname`),'ADMIN M1000') AS `sender`,concat(`ulreceiver`.`firstname`,' ',`ulreceiver`.`lastname`) AS `receiver`,`tr`.`sender` AS `senderid`,`tr`.`receiver` AS `receiverid`,`tr`.`amount` AS `amount`,`tr`.`comment` AS `comment`,`tr`.`timestamp` AS `timestamp` from ((`transactions` `tr` left join `userlookup` `ulsender` on((`tr`.`sender` = `ulsender`.`userid`))) left join `userlookup` `ulreceiver` on((`tr`.`receiver` = `ulreceiver`.`userid`))) ;

-- --------------------------------------------------------

--
-- Structure for view `userlookup`
--
DROP TABLE IF EXISTS `userlookup`;

DROP VIEW IF EXISTS `userlookup`;
CREATE ALGORITHM=UNDEFINED DEFINER=`lizeva1q_root`@`localhost` SQL SECURITY DEFINER VIEW `userlookup`  AS  select `users`.`userid` AS `userid`,`users`.`firstname` AS `firstname`,`users`.`lastname` AS `lastname`,`users`.`username` AS `username` from `users` ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
