-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2023 at 09:57 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `taxicompany`
--

-- --------------------------------------------------------

--
-- Table structure for table `darbolaikas`
--

CREATE TABLE `darbolaikas` (
  `DarboLaiko_ID` int(11) NOT NULL,
  `DarboPradzia` time NOT NULL,
  `DarboPabaiga` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `darbolaikas`
--

INSERT INTO `darbolaikas` (`DarboLaiko_ID`, `DarboPradzia`, `DarboPabaiga`) VALUES
(1, '08:00:00', '17:00:00'),
(2, '17:00:00', '02:00:00'),
(3, '02:00:00', '08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `kainos`
--

CREATE TABLE `kainos` (
  `KainuID` int(11) NOT NULL,
  `KelionesID` int(11) NOT NULL,
  `KeleivioID` int(11) NOT NULL,
  `Kaina` decimal(10,2) NOT NULL,
  `Data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keleivis`
--

CREATE TABLE `keleivis` (
  `KeleivioID` int(11) NOT NULL,
  `TelNr` int(11) NOT NULL,
  `PaemimoAdresas` varchar(50) NOT NULL,
  `NuvezimoAdresas` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keliones`
--

CREATE TABLE `keliones` (
  `KelionesID` int(11) NOT NULL,
  `KeleivioID` int(11) NOT NULL,
  `VairuotojoID` int(11) NOT NULL,
  `PaemimoAdresas` varchar(50) NOT NULL,
  `NuvezimoAdresas` varchar(50) NOT NULL,
  `Kaina` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `masinos`
--

CREATE TABLE `masinos` (
  `MasinosID` int(3) NOT NULL,
  `Nr` varchar(6) NOT NULL,
  `Modelis` varchar(25) NOT NULL,
  `Spalva` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masinos`
--

INSERT INTO `masinos` (`MasinosID`, `Nr`, `Modelis`, `Spalva`) VALUES
(1, 'AAA111', 'Audi A8', 'Juoda'),
(2, 'BBB222', 'Audi A5', 'Balta'),
(3, 'EGF142', 'Toyota Auris', 'Pilka'),
(4, 'GIH412', 'BMW A5', 'Juoda');

-- --------------------------------------------------------

--
-- Table structure for table `vairuotojai`
--

CREATE TABLE `vairuotojai` (
  `VairuotojoID` int(11) NOT NULL,
  `Vardas` varchar(25) NOT NULL,
  `Pavarde` varchar(25) NOT NULL,
  `AsmensKodas` bigint(11) NOT NULL,
  `TelNr` bigint(20) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Adresas` varchar(50) NOT NULL,
  `MasinosID` int(11) NOT NULL,
  `DarboLaikoID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vairuotojai`
--

INSERT INTO `vairuotojai` (`VairuotojoID`, `Vardas`, `Pavarde`, `AsmensKodas`, `TelNr`, `Email`, `Adresas`, `MasinosID`, `DarboLaikoID`) VALUES
(1, 'Jonas', 'Jonaitis', 39805120036, 37061234567, 'jonas@example.com', 'Vilnius', 1, 1),
(2, 'Petras', 'Petraitis', 50110231027, 37062345678, 'petras@example.com', 'Kaunas', 2, 2),
(3, 'Antanas', 'Antanaitis', 47006190045, 37063456789, 'antanas@example.com', 'Jonava', 3, 3),
(4, 'Linas', 'Linaitis', 29302060037, 37064567890, 'linas@example.com', 'Vilnius', 4, 1),
(5, 'Giedrius', 'Giedraitis', 40210010048, 37065678901, 'linas@example.com', 'Kaunas', 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `darbolaikas`
--
ALTER TABLE `darbolaikas`
  ADD PRIMARY KEY (`DarboLaiko_ID`);

--
-- Indexes for table `kainos`
--
ALTER TABLE `kainos`
  ADD PRIMARY KEY (`KainuID`),
  ADD KEY `KelionesID` (`KelionesID`),
  ADD KEY `KeleivioID` (`KeleivioID`);

--
-- Indexes for table `keleivis`
--
ALTER TABLE `keleivis`
  ADD PRIMARY KEY (`KeleivioID`);

--
-- Indexes for table `keliones`
--
ALTER TABLE `keliones`
  ADD PRIMARY KEY (`KelionesID`),
  ADD KEY `KeleivioID` (`KeleivioID`),
  ADD KEY `VairuotojoID` (`VairuotojoID`);

--
-- Indexes for table `masinos`
--
ALTER TABLE `masinos`
  ADD PRIMARY KEY (`MasinosID`);

--
-- Indexes for table `vairuotojai`
--
ALTER TABLE `vairuotojai`
  ADD PRIMARY KEY (`VairuotojoID`),
  ADD KEY `MasinosID` (`MasinosID`),
  ADD KEY `DarboLaikoID` (`DarboLaikoID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kainos`
--
ALTER TABLE `kainos`
  ADD CONSTRAINT `kainos_ibfk_1` FOREIGN KEY (`KelionesID`) REFERENCES `keliones` (`KelionesID`),
  ADD CONSTRAINT `kainos_ibfk_2` FOREIGN KEY (`KeleivioID`) REFERENCES `keleivis` (`KeleivioID`);

--
-- Constraints for table `keliones`
--
ALTER TABLE `keliones`
  ADD CONSTRAINT `keliones_ibfk_1` FOREIGN KEY (`KeleivioID`) REFERENCES `keleivis` (`KeleivioID`),
  ADD CONSTRAINT `keliones_ibfk_2` FOREIGN KEY (`VairuotojoID`) REFERENCES `vairuotojai` (`VairuotojoID`);

--
-- Constraints for table `vairuotojai`
--
ALTER TABLE `vairuotojai`
  ADD CONSTRAINT `vairuotojai_ibfk_1` FOREIGN KEY (`MasinosID`) REFERENCES `masinos` (`MasinosID`),
  ADD CONSTRAINT `vairuotojai_ibfk_2` FOREIGN KEY (`DarboLaikoID`) REFERENCES `darbolaikas` (`DarboLaiko_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
