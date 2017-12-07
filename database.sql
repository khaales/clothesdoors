-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 10, 2017 at 09:11 PM
-- Server version: 5.6.35
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `clothesdoors`
--

-- --------------------------------------------------------

--
-- Table structure for table `Closet`
--

CREATE TABLE `Closet` (
  `ClosetID` int(100) NOT NULL,
  `UserID` int(100) DEFAULT NULL,
  `ClothesID` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Clothes`
--

CREATE TABLE `Clothes` (
  `ClothesID` int(11) NOT NULL DEFAULT '0',
  `ClosetID` int(11) NOT NULL DEFAULT '0',
  `TimesWorn` int(11) DEFAULT NULL,
  `Type` enum('shirt','shoes','pants','accessories') NOT NULL DEFAULT 'shirt',
  `image` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Outfit`
--

CREATE TABLE `Outfit` (
  `OutfitID` int(100) NOT NULL,
  `Outfit_Name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `OutfitList`
--

CREATE TABLE `OutfitList` (
  `OutfitID` int(100) NOT NULL,
  `ClothesID` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `UserID` int(100) NOT NULL,
  `ClosetID` int(100) DEFAULT NULL,
  `u_password` varchar(20) DEFAULT NULL,
  `fname` varchar(20) DEFAULT NULL,
  `lname` varchar(20) DEFAULT NULL,
  `email` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`UserID`, `ClosetID`, `u_password`, `fname`, `lname`, `email`) VALUES
(1, 1, 'bit4444', 'pera', 't', 'pt@vt.edu'),
(2, 2, 'bit4444', 'en', 'j', 'ej@vt.edu'),
(3, 3, 'bit4444', 'keily', 's', 'ks@vt.edu'),
(4, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Closet`
--
ALTER TABLE `Closet`
  ADD PRIMARY KEY (`ClosetID`),
  ADD UNIQUE KEY `UserID` (`UserID`);

--
-- Indexes for table `Clothes`
--
ALTER TABLE `Clothes`
  ADD PRIMARY KEY (`ClothesID`,`ClosetID`);

--
-- Indexes for table `Outfit`
--
ALTER TABLE `Outfit`
  ADD PRIMARY KEY (`OutfitID`);

--
-- Indexes for table `OutfitList`
--
ALTER TABLE `OutfitList`
  ADD PRIMARY KEY (`OutfitID`,`ClothesID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Closet`
--
ALTER TABLE `Closet`
  MODIFY `ClosetID` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Outfit`
--
ALTER TABLE `Outfit`
  MODIFY `OutfitID` int(100) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `UserID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
