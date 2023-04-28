-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 28, 2023 at 10:55 PM
-- Server version: 8.0.32
-- PHP Version: 8.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `G20973951_CO2717`
--

-- --------------------------------------------------------

--
-- Table structure for table `BasketContents`
--

CREATE TABLE `BasketContents` (
  `ProductId` int NOT NULL,
  `UserId` int NOT NULL,
  `Quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `GolfBooking`
--

CREATE TABLE `GolfBooking` (
  `BookingId` int NOT NULL,
  `UserId` int NOT NULL,
  `BookingDate` date NOT NULL,
  `BookingTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `GolfBooking`
--

INSERT INTO `GolfBooking` (`BookingId`, `UserId`, `BookingDate`, `BookingTime`) VALUES
(23, 1, '2023-04-24', '07:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `GolfBookingPlayers`
--

CREATE TABLE `GolfBookingPlayers` (
  `BookingId` int NOT NULL,
  `PlayerId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `GolfBookingPlayers`
--

INSERT INTO `GolfBookingPlayers` (`BookingId`, `PlayerId`) VALUES
(23, 2);

-- --------------------------------------------------------

--
-- Table structure for table `GolfTimes`
--

CREATE TABLE `GolfTimes` (
  `TimeId` int NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `TimeIncrement` time NOT NULL
) ;

--
-- Dumping data for table `GolfTimes`
--

INSERT INTO `GolfTimes` (`TimeId`, `StartDate`, `EndDate`, `StartTime`, `EndTime`, `TimeIncrement`) VALUES
(1, '1970-01-01', '1970-01-01', '07:00:00', '19:00:00', '00:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `OrderItems`
--

CREATE TABLE `OrderItems` (
  `OrderId` int NOT NULL,
  `ItemId` int NOT NULL,
  `Quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `OrderItems`
--

INSERT INTO `OrderItems` (`OrderId`, `ItemId`, `Quantity`) VALUES
(10, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

CREATE TABLE `Orders` (
  `UserId` int NOT NULL,
  `OrderId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Orders`
--

INSERT INTO `Orders` (`UserId`, `OrderId`) VALUES
(1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `ProductCategories`
--

CREATE TABLE `ProductCategories` (
  `CategoryName` varchar(50) NOT NULL,
  `AgeRestriction` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ProductCategories`
--

INSERT INTO `ProductCategories` (`CategoryName`, `AgeRestriction`) VALUES
('BOTTLED', 18),
('DRAUGHT', 18),
('FORTIFIED WINE', 18),
('LIQUERS', 18),
('MINERALS', NULL),
('SNACKS', NULL),
('SPIRITS', 18),
('WINE', 18);

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE `Products` (
  `ProductId` int NOT NULL,
  `ProductName` varchar(50) NOT NULL,
  `ProductCategory` varchar(50) NOT NULL,
  `Price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Products`
--

INSERT INTO `Products` (`ProductId`, `ProductName`, `ProductCategory`, `Price`) VALUES
(1, 'Carling', 'DRAUGHT', 3.99),
(2, 'San Miguel', 'DRAUGHT', 4.5),
(3, 'Angelo Poretti', 'DRAUGHT', 3.5),
(4, 'Stella Artois', 'DRAUGHT', 3.5);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `UserId` int NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Firstname` varchar(20) NOT NULL,
  `Lastname` varchar(20) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `DateOfBirth` date NOT NULL,
  `PrivilegeLevel` int NOT NULL DEFAULT '1'
) ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`UserId`, `Email`, `Password`, `Firstname`, `Lastname`, `Address`, `DateOfBirth`, `PrivilegeLevel`) VALUES
(1, 'corkillw@gmail.com', '$2y$10$kSrIswcmK.o.0EvXiDs62O8AAHtrSTnba7Kw93halRgjb7TyStTf6', 'Will', 'Corkill', '123 Central Drive, Walney, Barrow-in-Furness, Cumbria, LA14 3HZ', '2003-06-04', 6),
(2, 'test@test.com', 'password', 'Test', 'User', '1 Ironworks Road, , Barrow-in-Furness, Cumbria, LA14 3NL', '2022-10-04', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `BasketContents`
--
ALTER TABLE `BasketContents`
  ADD PRIMARY KEY (`ProductId`,`UserId`);

--
-- Indexes for table `GolfBooking`
--
ALTER TABLE `GolfBooking`
  ADD PRIMARY KEY (`BookingId`);

--
-- Indexes for table `GolfBookingPlayers`
--
ALTER TABLE `GolfBookingPlayers`
  ADD PRIMARY KEY (`BookingId`,`PlayerId`);

--
-- Indexes for table `GolfTimes`
--
ALTER TABLE `GolfTimes`
  ADD PRIMARY KEY (`TimeId`);

--
-- Indexes for table `OrderItems`
--
ALTER TABLE `OrderItems`
  ADD PRIMARY KEY (`OrderId`,`ItemId`);

--
-- Indexes for table `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`OrderId`);

--
-- Indexes for table `ProductCategories`
--
ALTER TABLE `ProductCategories`
  ADD PRIMARY KEY (`CategoryName`);

--
-- Indexes for table `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`ProductId`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`UserId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `GolfBooking`
--
ALTER TABLE `GolfBooking`
  MODIFY `BookingId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `GolfBookingPlayers`
--
ALTER TABLE `GolfBookingPlayers`
  MODIFY `BookingId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `GolfTimes`
--
ALTER TABLE `GolfTimes`
  MODIFY `TimeId` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Orders`
--
ALTER TABLE `Orders`
  MODIFY `OrderId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Products`
--
ALTER TABLE `Products`
  MODIFY `ProductId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `UserId` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
