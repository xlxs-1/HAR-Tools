-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2021 at 05:27 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `content_types_ages`
--

CREATE TABLE `content_types_ages` (
  `type` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `age` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `content_types_ages_v2`
--

CREATE TABLE `content_types_ages_v2` (
  `type` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `age` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `entries_timings`
--

CREATE TABLE `entries_timings` (
  `timing` int(11) NOT NULL,
  `content_type` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `date_time` datetime NOT NULL,
  `http_method` tinyint(4) NOT NULL,
  `isp` varchar(100) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `http_requests`
--

CREATE TABLE `http_requests` (
  `email` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `type` varchar(8) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `request_method_stats`
--

CREATE TABLE `request_method_stats` (
  `get` int(11) NOT NULL,
  `head` int(11) NOT NULL,
  `post` int(11) NOT NULL,
  `put` int(11) NOT NULL,
  `delete_` int(11) NOT NULL,
  `connect` int(11) NOT NULL,
  `options` int(11) NOT NULL,
  `trace` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `request_urls`
--

CREATE TABLE `request_urls` (
  `url` varchar(100) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `response_status_stats`
--

CREATE TABLE `response_status_stats` (
  `informational` int(11) NOT NULL,
  `successful` int(11) NOT NULL,
  `redirection` int(11) NOT NULL,
  `client_error` int(11) NOT NULL,
  `server_error` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `email` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `last_upload` datetime NOT NULL,
  `number_of_uploads` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `users_footprint`
--

CREATE TABLE `users_footprint` (
  `email` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `isp` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `ip` varchar(100) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `users_footprint`
--
ALTER TABLE `users_footprint`
  ADD PRIMARY KEY (`email`,`isp`,`ip`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
