-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2025 at 02:52 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `malasakit`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin') DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$lmmqijtWwwzrKK.vBkZZcuikmUSVktmB/RqRgzHU78/kEh5H1OJGm', 'admin', '2025-01-02 02:35:23');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `status` enum('for_approval','for_processing','pending','released') NOT NULL,
  `amount` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_name` varchar(50),
  `name_extension` varchar(10),
  `contact_number` varchar(20),
  `address` varchar(255),
  `date_of_birth` date,
  `age` int(3),
  `sex` enum('Male', 'Female'),
  `civil_status` enum('Single', 'Married', 'Widow'),
  `place_of_birth` varchar(255),
  `religion` varchar(50),
  `educational_attainment` varchar(50),
  `occupation` varchar(50),
  `employment_status` varchar(50),
  `daily_income` decimal(10,2),
  `monthly_income` decimal(10,2),
  `sectoral_membership` varchar(255),
  `companion_name` varchar(50),
  `companion_address` varchar(255),
  `companion_contact` varchar(20),
  `admission_date` date,
  `diagnosis` text,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_registered` DATE,
  `image_path` varchar(255) DEFAULT NULL, 
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Table structure for table `patient_status`
--

CREATE TABLE patient_status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    status VARCHAR(50) NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE
);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

COMMIT;

CREATE TABLE med_inventory (
    Drug_Code VARCHAR(255) NOT NULL,
    Drug_Name VARCHAR(255),
    Specification_Model VARCHAR(255),
    Production_Batch VARCHAR(255),
    Period_Validity DATE,
    Manufacturer VARCHAR(255),
    Quantity INT,
    Unit_Price DECIMAL(10, 2),
    Amount DECIMAL(10, 2),
    Remarks TEXT
);
