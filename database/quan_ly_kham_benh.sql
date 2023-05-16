-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2023 at 08:30 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quan_ly_kham_benh`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `Appointment_time` datetime NOT NULL,
  `note` varchar(255) NOT NULL,
  `doctors_id` int(11) NOT NULL,
  `Appointment_id` int(11) NOT NULL,
  `patients_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`Appointment_time`, `note`, `doctors_id`, `Appointment_id`, `patients_id`) VALUES
('2023-05-17 10:00:00', 'Chụp X-quang ngực', 101, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `Doctor_id` int(11) NOT NULL,
  `Doctor_name` varchar(50) NOT NULL,
  `Specialized` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`Doctor_id`, `Doctor_name`, `Specialized`) VALUES
(101, 'Dr. Johnson', 'Nội khoa'),
(102, 'Dr. Anderson', 'Răng hàm mặt');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `Patients_name` varchar(255) NOT NULL,
  `date_of_birth` datetime NOT NULL,
  `gender` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `number` int(11) NOT NULL,
  `patients_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`Patients_name`, `date_of_birth`, `gender`, `address`, `number`, `patients_id`) VALUES
('John Smith', '1980-05-12 00:00:00', 1, '123 ABC St, City', 1234567890, 1),
('Jane Doe', '1992-09-28 00:00:00', 0, '456 XYZ St, City', 987654321, 2);

-- --------------------------------------------------------

--
-- Table structure for table `testresults`
--

CREATE TABLE `testresults` (
  `result_id` int(11) NOT NULL,
  `type_of_result` varchar(100) NOT NULL,
  `result_description` varchar(255) NOT NULL,
  `patients_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `testresults`
--

INSERT INTO `testresults` (`result_id`, `type_of_result`, `result_description`, `patients_id`) VALUES
(1, 'Xét nghiệm máu', 'Bình thường', 1),
(2, 'Chụp X-quang', 'Không phát hiện bất thường', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`Appointment_id`),
  ADD KEY `doctors_id_fk` (`doctors_id`),
  ADD KEY `patients_id_fk` (`patients_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`Doctor_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patients_id`);

--
-- Indexes for table `testresults`
--
ALTER TABLE `testresults`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `patients_id_fk` (`patients_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `Appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `Doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patients_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `testresults`
--
ALTER TABLE `testresults`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `testresults`
--
ALTER TABLE `testresults`
  ADD CONSTRAINT `testresults_ibfk_1` FOREIGN KEY (`patients_id`) REFERENCES `patients` (`patients_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
