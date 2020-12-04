-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2020 at 06:51 PM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asansafar_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminId` int(10) NOT NULL,
  `adminFullName` varchar(50) NOT NULL,
  `adminEmail` varchar(50) NOT NULL,
  `adminMobile` varchar(20) NOT NULL,
  `adminPassword` varchar(50) NOT NULL,
  `admintRegisterDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `admintUserModificationDate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `admintStatus` int(11) NOT NULL DEFAULT '1',
  `role` varchar(20) DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminId`, `adminFullName`, `adminEmail`, `adminMobile`, `adminPassword`, `admintRegisterDate`, `admintUserModificationDate`, `admintStatus`, `role`) VALUES
(12, 'Admin', 'admin@gmail.com', '7978767678678', '7488e331b8b64e5794da3fa4eb10ad5d', '2020-02-21 16:50:03', NULL, 1, 'admin'),
(13, 'Operator', 'operator@gmail.com', '7897878789', '4a29c04162f10e70040fd79285129489', '2020-02-21 16:52:35', NULL, 1, 'operator'),
(14, 'shams', 'shams@gmail.com', '345435435', '1be56293d44a8bc2bff5f0c838aaa9e7', '2020-10-21 17:01:12', '2020-10-21 17:02:29', 1, 'operator'),
(15, 'Ghulab', 'ghulab@gmail.com', '87987878', '5afb2b0856a8dfdbff9d2220a9f3c900', '2020-12-04 01:25:27', NULL, 1, 'operator');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `clientId` int(10) NOT NULL,
  `clientFullName` varchar(50) NOT NULL,
  `clientEmail` varchar(50) NOT NULL,
  `clientMobile` varchar(20) NOT NULL,
  `clientPermenantAddress` varchar(30) NOT NULL,
  `clientCurrentAddress` varchar(30) NOT NULL,
  `clientPassword` varchar(50) NOT NULL,
  `clientRegisterDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `clientUserModificationDate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `clientStatus` int(11) NOT NULL DEFAULT '1',
  `passwordResetCode` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`clientId`, `clientFullName`, `clientEmail`, `clientMobile`, `clientPermenantAddress`, `clientCurrentAddress`, `clientPassword`, `clientRegisterDate`, `clientUserModificationDate`, `clientStatus`, `passwordResetCode`) VALUES
(81, 'Akbar', 'akbar@gmail.com', '798845454545', 'Kabul', 'Ghazni', '06164d0aec2797ddbb7ae667194f4c46', '2020-03-08 00:19:15', NULL, 1, NULL),
(82, 'Chenar Gul', 'chenargul@hotmail.com', '475545454887', 'Kabul', 'Ghazni', '07c3bb8e858fef99270bf2c9e891188b', '2020-03-08 00:19:59', NULL, 1, NULL),
(83, 'Matin', 'matin@yahoo.com', '878545487878', 'Kabul', 'Kunduz', '4f3cef58d2c924c277cd84caa1755996', '2020-03-08 00:20:30', '2020-12-04 01:31:01', 0, NULL),
(85, 'Asad', 'mahdi2.samim@gmail.com', '54353453453', 'Kabul', 'Mazar', '0a0aea65268423da350f0762c3426b47', '2020-12-03 23:35:43', '2020-12-04 12:32:44', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clientfeedback`
--

CREATE TABLE `clientfeedback` (
  `id` int(2) NOT NULL,
  `question` varchar(300) NOT NULL,
  `optionA` varchar(100) NOT NULL,
  `optionB` varchar(100) NOT NULL,
  `optionC` varchar(100) NOT NULL,
  `optionD` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clientfeedback`
--

INSERT INTO `clientfeedback` (`id`, `question`, `optionA`, `optionB`, `optionC`, `optionD`) VALUES
(1, 'How do you rate your overall experience?', 'good', 'very good', 'bad', 'very bad'),
(2, 'Are you satisfied with our services?', 'Yes, totally satisfied', 'Yes, partially satisfied', 'No, not satisfied', 'No, partially not satisfied'),
(3, 'How do your rate the behavior of driver and our partners?', 'Good', 'Very good', 'Bad', 'Very bad'),
(4, 'How did you know about Asan Safar?', 'Heard on TVs', 'Heard from friends', 'Saw on newspapers', 'Saw on social medias');

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `address` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contactNoOne` varchar(25) NOT NULL,
  `contactNoTwo` varchar(25) NOT NULL,
  `webShortDesc` varchar(500) NOT NULL,
  `domainName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`address`, `email`, `contactNoOne`, `contactNoTwo`, `webShortDesc`, `domainName`) VALUES
('Kabul, Timany, AF', 'info@asansafar.af', '+ 93 (0) 20 300 40 500', '+ 93 (0) 79 889 89 899', 'Asan Safar helps you to easily reserve a set for your trip from any place to any destination within Afghanistan. With Asan Safar you will have a conveient trip.', 'asansafar.af');

-- --------------------------------------------------------

--
-- Table structure for table `dailyincome`
--

CREATE TABLE `dailyincome` (
  `ticketId` int(15) NOT NULL,
  `ticketPrice` varchar(5) NOT NULL,
  `ourShare` int(3) NOT NULL,
  `clientId` int(10) NOT NULL,
  `bookingDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `feedbackcollections`
--

CREATE TABLE `feedbackcollections` (
  `feedbackId` int(5) NOT NULL,
  `clientId` int(10) DEFAULT NULL,
  `question1` varchar(150) DEFAULT NULL,
  `answer1` varchar(100) DEFAULT NULL,
  `question2` varchar(150) DEFAULT NULL,
  `answer2` varchar(100) DEFAULT NULL,
  `question3` varchar(150) DEFAULT NULL,
  `answer3` varchar(100) DEFAULT NULL,
  `question4` varchar(150) DEFAULT NULL,
  `answer4` varchar(100) DEFAULT NULL,
  `suggestion` varchar(300) DEFAULT NULL,
  `customerFullName` varchar(100) DEFAULT NULL,
  `customerAddress` varchar(100) DEFAULT NULL,
  `customerMobileNumber` varchar(100) DEFAULT NULL,
  `customerEmail` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedbackcollections`
--

INSERT INTO `feedbackcollections` (`feedbackId`, `clientId`, `question1`, `answer1`, `question2`, `answer2`, `question3`, `answer3`, `question4`, `answer4`, `suggestion`, `customerFullName`, `customerAddress`, `customerMobileNumber`, `customerEmail`) VALUES
(13, 81, 'How do you rate your overall experience?', 'good', 'Are you satisfied with our services?', 'Yes, totally satisfied', 'How do your rate the behavior of driver and our partners?', 'Good', 'How did you know about Asan Safar?', 'Heard on TVs', 'Very good TMS', 'Akbar Khan', 'Kabul', '789789798789', 'akbar@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `logging`
--

CREATE TABLE `logging` (
  `logId` int(10) NOT NULL,
  `userName` varchar(50) DEFAULT NULL,
  `userType` varchar(50) DEFAULT NULL,
  `activityType` varchar(100) DEFAULT NULL,
  `logMsg` varchar(300) DEFAULT NULL,
  `logDatetime` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logging`
--

INSERT INTO `logging` (`logId`, `userName`, `userType`, `activityType`, `logMsg`, `logDatetime`) VALUES
(409, 'admin@gmail.com', 'Admin', 'Login as an admin', 'The admin admin@gmail.com Successfully logged in', '2020-03-08 00:07:10'),
(410, '12', 'Admin', 'Admin Logout', 'Admin 12 Successfully logged out', '2020-03-08 00:10:23'),
(411, 'operator@gmail.com', 'Operator', 'Login as an operator', 'The operator operator@gmail.com Successfully logged in', '2020-03-08 00:10:53'),
(412, '13', 'Operator', 'Client registeration', 'The client mahdi2.samim@gmail.com has been successfully registerd by 13 successfully', '2020-03-08 00:18:36'),
(413, '13', 'Operator', 'Client registeration', 'The client akbar@gmail.com has been successfully registerd by 13 successfully', '2020-03-08 00:19:15'),
(414, '13', 'Operator', 'Client registeration', 'The client chenargul@hotmail.com has been successfully registerd by 13 successfully', '2020-03-08 00:19:59'),
(415, '13', 'Operator', 'Client registeration', 'The client matin@yahoo.com has been successfully registerd by 13 successfully', '2020-03-08 00:20:30'),
(416, '13', 'Operator', 'Client registeration', 'The client hakim@gmail.com has been successfully registerd by 13 successfully', '2020-03-08 00:21:00'),
(417, '13', 'Operator', 'Agency registeration', 'The agency has been added by operator 13', '2020-03-08 00:25:40'),
(418, '13', 'Operator', 'Agency registeration', 'The agency has been added by operator 13', '2020-03-08 00:26:39'),
(419, '13', 'Operator', 'Agency registeration', 'The agency has been added by operator 13', '2020-03-08 00:27:33'),
(420, '13', 'Operator', 'Vehicle registeration', 'The vehicle added by operator 13', '2020-03-08 00:29:07'),
(421, '13', 'Operator', 'Vehicle registeration', 'The vehicle added by operator 13', '2020-03-08 00:30:32'),
(422, '13', 'Operator', 'Vehicle registeration', 'The vehicle added by operator 13', '2020-03-08 00:31:30'),
(423, '13', 'Operator', 'Vehicle registeration', 'The vehicle added by operator 13', '2020-03-08 00:32:24'),
(424, '13', 'Operator', 'Vehicle registeration', 'The vehicle added by operator 13', '2020-03-08 00:33:22'),
(425, '13', 'Operator', 'Vehicle registeration', 'The vehicle added by operator 13', '2020-03-08 00:34:20'),
(426, '13', 'Operator', 'Vehicle registeration', 'The vehicle added by operator 13', '2020-03-08 00:35:17'),
(427, '13', 'Operator', 'Vehicle registeration', 'The vehicle added by operator 13', '2020-03-08 00:36:07'),
(428, '13', 'Operator', 'Vehicle registeration', 'The vehicle added by operator 13', '2020-03-08 00:37:44'),
(429, '13', 'Operator', 'Vehicle registeration', 'The vehicle added by operator 13', '2020-03-08 00:38:46'),
(430, '13', 'Operator', 'Ticket registeration', 'The ticket has been added by operator 13', '2020-03-08 00:41:03'),
(431, '13', 'Operator', 'Ticket registeration', 'The ticket has been added by operator 13', '2020-03-08 00:41:55'),
(432, '13', 'Operator', 'Ticket registeration', 'The ticket has been added by operator 13', '2020-03-08 00:42:46'),
(433, '13', 'Operator', 'Ticket registeration', 'The ticket has been added by operator 13', '2020-03-08 00:43:37'),
(434, '13', 'Operator', 'Ticket registeration', 'The ticket has been added by operator 13', '2020-03-08 00:44:37'),
(435, '13', 'Operator', 'Ticket registeration', 'The ticket has been added by operator 13', '2020-03-08 00:45:32'),
(436, '13', 'Operator', 'Ticket registeration', 'The ticket has been added by operator 13', '2020-03-08 00:46:17'),
(437, '13', 'Operator', 'Ticket registeration', 'The ticket has been added by operator 13', '2020-03-08 00:47:03'),
(438, '13', 'Operator', 'Granting membership', 'The membership granted to the agency by operator 13', '2020-03-08 00:49:45'),
(439, '13', 'Operator', 'Granting membership', 'The membership granted to the agency by operator 13', '2020-03-08 00:52:13'),
(440, '13', 'Operator', 'Vehicle update', 'The vehicle 25 details has been updated by operator 13', '2020-03-08 01:02:04'),
(441, 'operator@gmail.com', 'Operator', 'Login as an operator', 'The operator operator@gmail.com Successfully logged in', '2020-03-08 01:10:55'),
(442, '13', 'Operator', 'Operator Logout', 'Operator 13 Successfully logged out', '2020-03-08 01:12:49'),
(443, 'admin@gmail.com', 'Admin', 'Login as an admin', 'The admin admin@gmail.com Successfully logged in', '2020-03-08 01:13:02'),
(444, '12', 'Admin', 'Admin Logout', 'Admin 12 Successfully logged out', '2020-03-08 01:17:36'),
(445, 'operator@gmail.com', 'Operator', 'Login as an operator', 'The operator operator@gmail.com Successfully logged in', '2020-03-08 01:17:42'),
(446, 'operator@gmail.com', 'Operator', 'Login as an operator', 'The operator operator@gmail.com Successfully logged in', '2020-08-22 19:38:31'),
(447, '13', 'Operator', 'Operator Logout', 'Operator 13 Successfully logged out', '2020-08-22 19:39:12'),
(448, 'admin@gmail.com', 'Admin', 'Login as an admin', 'The admin admin@gmail.com Successfully logged in', '2020-08-22 19:41:28'),
(449, 'admin@gmail.com', 'Admin', 'Login as an admin', 'The admin admin@gmail.com Successfully logged in', '2020-10-21 00:37:59'),
(450, '12', 'Admin', 'Admin Logout', 'Admin 12 Successfully logged out', '2020-10-21 00:39:28'),
(451, 'admin@gmail.com', 'Admin', 'Login as an admin', 'The admin admin@gmail.com Successfully logged in', '2020-10-21 00:39:33'),
(452, '12', 'Admin', 'Admin Logout', 'Admin 12 Successfully logged out', '2020-10-21 00:41:20'),
(453, 'operator@gmail.com', 'Operator', 'Login as an operator', 'The operator operator@gmail.com Successfully logged in', '2020-10-21 00:41:39'),
(454, 'admin@gmail.com', 'Admin', 'Login as an admin', 'The admin admin@gmail.com Successfully logged in', '2020-10-21 16:55:24'),
(455, '12', 'Admin', 'Website about us details', 'The website about us has been updated successfully by admin with ID 12', '2020-10-21 16:56:24'),
(456, '12', 'Admin', 'Updating website feedback', 'The feedback has been updated by admin with ID 12', '2020-10-21 16:57:26'),
(457, 'shams@gmail.com', 'Admin', 'Registering an operator', 'Registeration failed,  the password does not match!', '2020-10-21 17:00:35'),
(458, 'shams@gmail.com', 'Admin', 'Registering an operator', 'The admin shams@gmail.com Successfuly registered', '2020-10-21 17:01:12'),
(459, '12', 'Admin', 'Admin Logout', 'Admin 12 Successfully logged out', '2020-10-21 17:01:17'),
(460, 'shams@gmail.com', 'Operator', 'Login as an operator', 'Login failed, invalid user name and password', '2020-10-21 17:01:29'),
(461, 'shams@gmail.com', 'Operator', 'Login as an operator', 'The operator shams@gmail.com Successfully logged in', '2020-10-21 17:01:49'),
(462, 'shams@gmail.com', 'Operator', 'Operator Reset password', 'Wrong password for user shams@gmail.com entered', '2020-10-21 17:02:10'),
(463, 'shams@gmail.com', 'Operator', 'Operator Reset password', 'The user shams@gmail.com has reset his/her password', '2020-10-21 17:02:29'),
(464, 'shams@gmail.com', 'Operator', 'Login as an operator', 'The operator shams@gmail.com Successfully logged in', '2020-10-21 17:02:42'),
(465, 'admin@gmail.com', 'Admin', 'Login as an admin', 'The admin admin@gmail.com Successfully logged in', '2020-11-29 19:12:03'),
(466, '12', 'Admin', 'Admin Logout', 'Admin 12 Successfully logged out', '2020-11-29 19:13:11'),
(467, 'operator@gmail.com', 'Operator', 'Login as an operator', 'The operator operator@gmail.com Successfully logged in', '2020-11-29 19:13:20'),
(468, 'asad@hotmail.com', 'Client', 'Client registeration', 'The client asad@hotmail.com has been successfully registerd', '2020-12-03 23:35:43'),
(469, 'mahdi2.samim@gmail.com', 'Client', 'Client update', 'The client mahdi2.samim@gmail.com has been updated by client}', '2020-12-03 23:41:32'),
(470, 'admin@gmail.com', 'Admin', 'Login as an admin', 'The admin admin@gmail.com Successfully logged in', '2020-12-04 01:21:30'),
(471, '12', 'Admin', 'Changing website name and logo', 'The website name has been successfully updated by admin with ID 12', '2020-12-04 01:21:52'),
(472, '12', 'Admin', 'Changing website name and logo', 'The website name has been successfully updated by admin with ID 12', '2020-12-04 01:22:42'),
(473, '12', 'Admin', 'Website about us details', 'The website about us has been updated successfully by admin with ID 12', '2020-12-04 01:23:05'),
(474, '12', 'Admin', 'Updating website feedback', 'The feedback has been updated by admin with ID 12', '2020-12-04 01:23:42'),
(475, 'ghulab@gmail.com', 'Admin', 'Registering an operator', 'The admin ghulab@gmail.com Successfuly registered', '2020-12-04 01:25:27'),
(476, '12', 'Operator', 'Deleting client', 'The client with ID 84 succesfully deleted by operator 12 ', '2020-12-04 01:30:05'),
(477, '12', 'Operator', 'Client update', 'The client matin@yahoo.com has been updated by 12', '2020-12-04 01:30:21'),
(478, '12', 'Operator', 'Client update', 'The client matin@yahoo.com has been updated by 12', '2020-12-04 01:30:43'),
(479, '12', 'Operator', 'Client update', 'The client matin@yahoo.com has been updated by 12', '2020-12-04 01:31:01'),
(480, '12', 'Operator', 'Client update', 'The client mahdi2.samim@gmail.com has been updated by 12', '2020-12-04 01:32:16'),
(481, 'admin@gmail.com', 'Admin', 'Login as an admin', 'The admin admin@gmail.com Successfully logged in', '2020-12-04 01:33:30'),
(482, '12', 'Admin', 'Admin Logout', 'Admin 12 Successfully logged out', '2020-12-04 01:34:09'),
(483, 'operator@gmail.com', 'Operator', 'Login as an operator', 'The operator operator@gmail.com Successfully logged in', '2020-12-04 01:34:19'),
(484, 'mahdi2.samim@gmail.com', 'Client', 'Client Reset password', 'The user mahdi2.samim@gmail.com has reset his/her password', '2020-12-04 12:32:44'),
(485, 'mahdi2.samim@gmail.com', 'Admin', 'Login as an admin', 'Login failed, invalid user name and password', '2020-12-04 21:52:39');

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `membershipId` int(10) NOT NULL,
  `agencyId` int(10) DEFAULT NULL,
  `agentFullName` varchar(100) NOT NULL,
  `membershipDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `agencyAddress` varchar(200) NOT NULL,
  `totalNoOfVehicles` int(20) NOT NULL,
  `vehiclesDescription` varchar(300) NOT NULL,
  `membershipFee` int(10) NOT NULL,
  `paidAmount` int(10) NOT NULL,
  `remainingAmount` int(10) DEFAULT NULL,
  `contractFileName` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`membershipId`, `agencyId`, `agentFullName`, `membershipDate`, `agencyAddress`, `totalNoOfVehicles`, `vehiclesDescription`, `membershipFee`, `paidAmount`, `remainingAmount`, `contractFileName`) VALUES
(5, 14, 'kabul Agency', '2020-03-04 00:00:00', 'Kabul Agency have 5 branches in Kabul', 10, '2 Bus 480  and 20 Corola and 20 Sarycha', 5000, 3000, 2000, 'membership_contract_form (1).pdf'),
(6, 13, 'Mazar Agency', '2020-03-06 00:00:00', 'Mazar Travel Agency', 15, '5 Bus 480 - 7 Corolla and 8 Sarycha', 12000, 8000, 4000, 'membership_contract_form (3).pdf');

-- --------------------------------------------------------

--
-- Table structure for table `operator`
--

CREATE TABLE `operator` (
  `operatorId` int(10) NOT NULL,
  `operatorFullName` varchar(100) NOT NULL,
  `operatorEmail` varchar(50) NOT NULL,
  `operatorMobile` varchar(20) NOT NULL,
  `operatorPassword` varchar(30) NOT NULL,
  `operatorRegisterDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `operatorUserModificationDate` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `operatorStatus` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `route`
--

CREATE TABLE `route` (
  `routeId` int(3) NOT NULL,
  `placeName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticketId` int(10) NOT NULL,
  `srcPlacce` varchar(50) NOT NULL,
  `destPlace` varchar(50) NOT NULL,
  `distance` int(3) DEFAULT NULL,
  `departureDate` varchar(20) NOT NULL,
  `arrivalDate` varchar(20) NOT NULL,
  `departureTime` varchar(20) NOT NULL,
  `arrivalTime` varchar(20) NOT NULL,
  `vehicleId` int(50) NOT NULL,
  `setNo` int(2) NOT NULL,
  `price` varchar(10) NOT NULL,
  `discount` int(2) NOT NULL,
  `status` int(1) DEFAULT '0',
  `bookingDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `clientId` int(5) DEFAULT '0',
  `vehicleType` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticketId`, `srcPlacce`, `destPlace`, `distance`, `departureDate`, `arrivalDate`, `departureTime`, `arrivalTime`, `vehicleId`, `setNo`, `price`, `discount`, `status`, `bookingDate`, `clientId`, `vehicleType`) VALUES
(12, 'Kabul', 'Laghman', 789, '2020-03-02', '2020-03-04', '12:40 AM', '8:40 AM', 19, 4, '420 AFN', 3, 1, '2020-12-04 12:56:27', 85, 'Corola'),
(13, 'Mazar', 'Kabul', 1258, '2020-03-04', '2020-03-06', '5:41 AM', '12:41 AM', 20, 44, '490 AFN', 4, 1, '2020-12-03 11:39:25', 85, 'Corola'),
(14, 'Laghman', 'Qandhar', 2586, '2020-03-03', '2020-03-05', '4:46 AM', '10:42 PM', 22, 4, '500 AFN', 10, 1, '2020-12-04 02:08:39', 85, 'Saraycha'),
(15, 'Parwan', 'Qandhar', 550, '2020-03-05', '2020-03-05', '3:45 AM', '8:40 PM', 25, 10, '550 AFN', 8, 1, '2020-03-08 01:06:18', 81, 'Bus 480'),
(16, 'Mazar', 'Parwan', 5879, '2020-03-06', '2020-03-07', '2:48 PM', '8:41 PM', 25, 3, '780 AFN', 0, 1, '2020-03-08 01:03:47', 80, 'Bus 480'),
(17, 'Mazar', 'Laghman', 698, '2020-03-02', '2020-03-06', '1:42 AM', '1:43 PM', 19, 17, '530 AFN', 4, 1, '2020-03-08 01:06:48', 81, 'Corola'),
(18, 'Takhar', 'Kabul', 980, '2020-03-04', '2020-03-05', '4:47 AM', '2:42 AM', 23, 12, '400 AFN', 0, 1, '2020-03-08 01:06:34', 81, 'Tunnes'),
(19, 'Laghman', 'Parwan', 890, '2020-03-06', '2020-03-08', '3:46 AM', '8:46 PM', 19, 10, '370 AFN', 2, 0, '2020-03-08 00:47:03', 0, 'Corola');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `trn_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `vehicleId` int(10) NOT NULL,
  `vehiclePlanteNo` varchar(20) NOT NULL,
  `vehicleType` varchar(20) NOT NULL,
  `numberOfSets` int(2) NOT NULL,
  `comnSrcPlace` varchar(50) NOT NULL,
  `comnDestPlace` varchar(50) NOT NULL,
  `vehicleImg` varchar(150) DEFAULT NULL,
  `travelAgencyDetails` varchar(250) DEFAULT NULL,
  `driverDetails` varchar(200) DEFAULT NULL,
  `cleanerDetails` varchar(200) DEFAULT NULL,
  `ownerId` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`vehicleId`, `vehiclePlanteNo`, `vehicleType`, `numberOfSets`, `comnSrcPlace`, `comnDestPlace`, `vehicleImg`, `travelAgencyDetails`, `driverDetails`, `cleanerDetails`, `ownerId`) VALUES
(18, '64545454', 'Corola', 5, 'Kabul', 'Mazar', 'taxi1.png', 'Kabul Agency in Baharustan', 'Hakim Khan from Mazar 34534543543', 'Jamil Khan', 12),
(19, '79898787', 'Corola', 5, 'Laghman', 'Takhar', 'taxi2.jpg', 'Kabul Agency in Kotaye sange', 'Jamil Khan', 'Ghulam Khan', 13),
(20, '14798421', 'Corola', 5, 'Mazar', 'Takhar', 'taxi3.jpg', 'Yousuf Khan Mazar 67678687687', 'Timor khan', 'Nabi Khan', 13),
(21, '7742126', 'Saraycha', 5, 'Laghman', 'Kabul', 'sarycha1.jpg', 'Laghman Agency', 'Rasikh Khan', 'Hamid Khan', 14),
(22, '154878121', 'Saraycha', 5, 'Laghman', 'Mazar', 'sarycha3.jpg', 'Laghman Agency', 'Fardin Khan 53434234324', 'Sami Laghmani', 14),
(23, '49895454', 'Tunnes', 10, 'Kabul', 'Mazar', 'tunees1.jpg', 'Kabul Tunness Agency', 'Edar Khan', 'Jamila Khanum', 12),
(24, '7981542', 'Tunnes', 10, 'Mazar', 'Kabul', 'tunees4.jpg', 'Kabul Agency Kartayee char', 'Ibrahim Sanami', 'Ghandar Khan', 13),
(25, '13985211', 'Bus 480', 50, 'Parwan', 'Qandhar', 'bus2.png', 'Qandhar Agency', 'Tamkin Khan', 'Parwina Khan', 14),
(26, '1326702545', 'Bus 404', 50, 'Kabul', 'Qandhar', 'bus4.jpg', 'Rabin Agency', 'Batur kahn', 'Sangeen Khan', 14),
(27, '139797', 'Bus 480', 64, 'Parwan', 'Qandhar', 'bus3.jpg', 'Payenda Agency', 'Omar Khan', 'Nabizada Hakimi', 13);

-- --------------------------------------------------------

--
-- Table structure for table `vehicleowner`
--

CREATE TABLE `vehicleowner` (
  `ownerId` int(10) NOT NULL,
  `ownerFullName` varchar(50) NOT NULL,
  `ownerEmail` varchar(50) NOT NULL,
  `ownertMobile` varchar(20) NOT NULL,
  `ownerRegisterDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `onwerTazkira` varchar(200) DEFAULT NULL,
  `gurantorDetails` varchar(300) DEFAULT NULL,
  `gurantorTazkira` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vehicleowner`
--

INSERT INTO `vehicleowner` (`ownerId`, `ownerFullName`, `ownerEmail`, `ownertMobile`, `ownerRegisterDate`, `onwerTazkira`, `gurantorDetails`, `gurantorTazkira`) VALUES
(12, 'Kabul Agency', 'kabulagency@gmail.com', '54878784545', '2020-03-08 00:25:39', 'tazkira.pdf', 'Hamid Khan from Mazar', 'guarantortazkira.pdf'),
(13, 'Mazar Agency', 'mazaragency@yahoo.com', '64565465345345', '2020-03-08 00:26:39', 'tazkira.pdf', 'Ghulam Khan', 'guarantortazkira.pdf'),
(14, 'Laghman Agency', 'laghman@gmail.com', '6453535345345', '2020-03-08 00:27:33', 'tazkira.pdf', 'Hamayoon - 68767868767', 'guarantortazkira.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `websiteabout`
--

CREATE TABLE `websiteabout` (
  `about` varchar(3000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `websiteabout`
--

INSERT INTO `websiteabout` (`about`) VALUES
('Asan Safar Bus Management System is a system that developed to make the management of bus driver and bus trip at Transnasional Express Sdn Bhd Kuantan Branch become easier. At this time, this company only has online ticketing system and still do not has computerized management system for their company operation. Therefore, all the data and information that related with driver and bus trip is documented and kept in file base system. Manual system in record keeping make an important data or information has a potential to lost or damage. Besides, driver scheduling is assigned by operation officer manually and the operation officer must prepare the schedule everyday before the driver start their trip. Therefore, computerized driver scheduling is suggested to make the management of driver schedule become easier. RAD model is used as a process model and Microsoft Visual Basic 6.0 and Microsoft Access is used as a tool for Bus Management System development. Besides, the prototype for bus management system successfully developed to make the management work become more effective.');

-- --------------------------------------------------------

--
-- Table structure for table `websitenamelogo`
--

CREATE TABLE `websitenamelogo` (
  `websiteName` varchar(50) NOT NULL DEFAULT 'AsanSafar',
  `websiteLogo` varchar(200) NOT NULL DEFAULT 'asan_safar.png'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `websitenamelogo`
--

INSERT INTO `websitenamelogo` (`websiteName`, `websiteLogo`) VALUES
('AsanSafar', 'asan_safar.png');

-- --------------------------------------------------------

--
-- Table structure for table `webslide`
--

CREATE TABLE `webslide` (
  `id` int(2) NOT NULL,
  `slideImg` varchar(200) NOT NULL,
  `slideTitle` varchar(200) NOT NULL,
  `slideDescription` varchar(350) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webslide`
--

INSERT INTO `webslide` (`id`, `slideImg`, `slideTitle`, `slideDescription`) VALUES
(1, 'slideshow_1.png', 'A convenient way to travel', 'We are here to help you with your travel'),
(2, 'slideshow_2.png', 'Asan Safar', 'The Afghanistan First Online Ticket Booking System'),
(3, 'slideshow_3.png', 'Transportation Management System (TMS)', 'We bring comfortness in people life using technology');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminId`),
  ADD UNIQUE KEY `adminEmail` (`adminEmail`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`clientId`),
  ADD UNIQUE KEY `clientEmail` (`clientEmail`);

--
-- Indexes for table `clientfeedback`
--
ALTER TABLE `clientfeedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dailyincome`
--
ALTER TABLE `dailyincome`
  ADD KEY `ticketId` (`ticketId`),
  ADD KEY `clientId` (`clientId`);

--
-- Indexes for table `feedbackcollections`
--
ALTER TABLE `feedbackcollections`
  ADD PRIMARY KEY (`feedbackId`),
  ADD KEY `clientId` (`clientId`);

--
-- Indexes for table `logging`
--
ALTER TABLE `logging`
  ADD PRIMARY KEY (`logId`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`membershipId`),
  ADD KEY `agencyId` (`agencyId`);

--
-- Indexes for table `operator`
--
ALTER TABLE `operator`
  ADD PRIMARY KEY (`operatorId`),
  ADD UNIQUE KEY `operatorEmail` (`operatorEmail`),
  ADD UNIQUE KEY `operatorMobile` (`operatorMobile`);

--
-- Indexes for table `route`
--
ALTER TABLE `route`
  ADD PRIMARY KEY (`routeId`),
  ADD UNIQUE KEY `placeName` (`placeName`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticketId`),
  ADD KEY `vehicleId` (`vehicleId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`vehicleId`),
  ADD UNIQUE KEY `vehiclePlanteNo` (`vehiclePlanteNo`),
  ADD KEY `ownerId` (`ownerId`);

--
-- Indexes for table `vehicleowner`
--
ALTER TABLE `vehicleowner`
  ADD PRIMARY KEY (`ownerId`),
  ADD UNIQUE KEY `ownerEmail` (`ownerEmail`);

--
-- Indexes for table `webslide`
--
ALTER TABLE `webslide`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `clientId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `clientfeedback`
--
ALTER TABLE `clientfeedback`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `feedbackcollections`
--
ALTER TABLE `feedbackcollections`
  MODIFY `feedbackId` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `logging`
--
ALTER TABLE `logging`
  MODIFY `logId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=486;

--
-- AUTO_INCREMENT for table `membership`
--
ALTER TABLE `membership`
  MODIFY `membershipId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `operator`
--
ALTER TABLE `operator`
  MODIFY `operatorId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `route`
--
ALTER TABLE `route`
  MODIFY `routeId` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticketId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `vehicleId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `vehicleowner`
--
ALTER TABLE `vehicleowner`
  MODIFY `ownerId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `webslide`
--
ALTER TABLE `webslide`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dailyincome`
--
ALTER TABLE `dailyincome`
  ADD CONSTRAINT `dailyincome_ibfk_1` FOREIGN KEY (`ticketId`) REFERENCES `ticket` (`ticketId`),
  ADD CONSTRAINT `dailyincome_ibfk_2` FOREIGN KEY (`clientId`) REFERENCES `client` (`clientId`);

--
-- Constraints for table `feedbackcollections`
--
ALTER TABLE `feedbackcollections`
  ADD CONSTRAINT `feedbackcollections_ibfk_1` FOREIGN KEY (`clientId`) REFERENCES `client` (`clientId`);

--
-- Constraints for table `membership`
--
ALTER TABLE `membership`
  ADD CONSTRAINT `membership_ibfk_1` FOREIGN KEY (`agencyId`) REFERENCES `vehicleowner` (`ownerId`);

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`vehicleId`) REFERENCES `vehicle` (`vehicleId`);

--
-- Constraints for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD CONSTRAINT `vehicle_ibfk_1` FOREIGN KEY (`ownerId`) REFERENCES `vehicleowner` (`ownerId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
