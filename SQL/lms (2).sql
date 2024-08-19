-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2024 at 10:37 AM
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
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `adminid` varchar(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phno` varchar(10) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `age` int(2) DEFAULT NULL,
  `salary` int(6) DEFAULT NULL,
  `registerdate` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`adminid`, `name`, `email`, `phno`, `password`, `age`, `salary`, `registerdate`) VALUES
('LMA01', 'kumar', 'kumar@gmail.com', '0000000000', 'kumar123', 20, 45000, '2024-05-12');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `isbn` varchar(10) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `publicationyear` int(4) DEFAULT NULL,
  `cost` float DEFAULT NULL,
  `available` int(11) DEFAULT NULL,
  `updatedate` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issued`
--

CREATE TABLE `issued` (
  `studentid` varchar(10) NOT NULL,
  `bookid` varchar(10) NOT NULL,
  `issuedate` date NOT NULL,
  `returndate` date DEFAULT NULL,
  `returnstatus` int(1) DEFAULT NULL,
  `fee` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regstudents`
--

CREATE TABLE `regstudents` (
  `sno` int(11) NOT NULL,
  `id` varchar(10) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phno` varchar(10) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `registerdate` date DEFAULT NULL,
  `activebit` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `adminid` (`adminid`),
  ADD UNIQUE KEY `phno` (`phno`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`isbn`),
  ADD UNIQUE KEY `isbn` (`isbn`);

--
-- Indexes for table `issued`
--
ALTER TABLE `issued`
  ADD PRIMARY KEY (`studentid`,`bookid`,`issuedate`),
  ADD KEY `bookid` (`bookid`);

--
-- Indexes for table `regstudents`
--
ALTER TABLE `regstudents`
  ADD PRIMARY KEY (`sno`),
  ADD UNIQUE KEY `phno` (`phno`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `regstudents`
--
ALTER TABLE `regstudents`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `issued`
--
ALTER TABLE `issued`
  ADD CONSTRAINT `issued_ibfk_1` FOREIGN KEY (`studentid`) REFERENCES `regstudents` (`id`),
  ADD CONSTRAINT `issued_ibfk_2` FOREIGN KEY (`bookid`) REFERENCES `books` (`isbn`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
