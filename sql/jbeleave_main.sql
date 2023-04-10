-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2023 at 01:44 AM
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
-- Database: `jbeleave`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `branch_id` int(11) NOT NULL,
  `branch` varchar(100) NOT NULL,
  `region_id` int(11) NOT NULL,
  `branch_slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`branch_id`, `branch`, `region_id`, `branch_slug`) VALUES
(1, 'Abuja', 1, 'abuja'),
(2, 'Ajah', 1, 'ajah'),
(3, 'Factory', 1, 'factory'),
(4, 'Ikeja', 1, 'ikeja'),
(5, 'Kano', 1, 'kano'),
(6, 'Port Harcourt', 1, 'port_harcourt'),
(7, 'Victoria Island', 1, 'vi'),
(12, 'London', 11, 'london');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `department` varchar(100) NOT NULL,
  `department_slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department`, `department_slug`) VALUES
(1, 'Accounts', 'accounts'),
(2, 'Aftersales', 'aftersales'),
(3, 'Fabrication', 'fabrication'),
(4, 'Finance', 'finance'),
(5, 'Genset', 'genset'),
(6, 'Health Safety Environment', 'health_safety_environment'),
(7, 'Human Resources', 'human_resources'),
(8, 'Information Technology', 'information_technology'),
(9, 'Logistics', 'logistics'),
(10, 'Management', 'management'),
(11, 'Maintenace', 'maintenace'),
(12, 'Marketing', 'marketing'),
(13, 'Production', 'production'),
(14, 'Project Account', 'project_account'),
(15, 'Public Relation', 'public_relation'),
(16, 'Procurement', 'procurement'),
(17, 'Sales', 'sales'),
(18, 'Shipping', 'shipping'),
(19, 'Stores', 'stores'),
(20, 'Technical', 'technical'),
(21, 'Telecom', 'telecom'),
(22, 'Quality Assurance', 'quality_assurance');

-- --------------------------------------------------------

--
-- Table structure for table `jbe_employees`
--

CREATE TABLE `jbe_employees` (
  `employee_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email_phone` varchar(50) DEFAULT NULL,
  `staff_id` varchar(200) NOT NULL,
  `department` varchar(50) NOT NULL,
  `job_description` varchar(255) NOT NULL,
  `branch` varchar(100) NOT NULL,
  `region` varchar(50) NOT NULL,
  `employeetype` varchar(50) DEFAULT 'user',
  `linemanagername` varchar(255) NOT NULL,
  `linemanageremail` varchar(255) NOT NULL,
  `totalleave` int(20) NOT NULL,
  `status` varchar(20) DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `jbe_employees`
--

INSERT INTO `jbe_employees` (`employee_id`, `firstname`, `lastname`, `fullname`, `username`, `password`, `email_phone`, `staff_id`, `department`, `job_description`, `branch`, `region`, `employeetype`, `linemanagername`, `linemanageremail`, `totalleave`, `status`, `created_at`) VALUES
(1, 'Admin', 'JB', 'Admin', 'Admin', '$2y$10$ElJlJ.v55hp8o81k7H7SD.QW2wR4j3tDkZb8HL9QSYP7C.kg1/u1O', 'Ay_michael96@yahoo.com', '0-0000-000', 'Administrator', 'Administrator', 'Ikeja', 'Nigeria', 'admin', 'Administrator', 'Ay_michael96@yahoo.com', 0, 'active', '2023-04-10 21:50:38'),
(2, 'Ugoh', 'Akongwubel', 'Ugoh Akongwubel', 'Ugoh_Akongwubel', '$2y$10$mTgRL25x11/O7W9Uo2hm9OyKwiRgyjQ1CxWNO0T00YOvIPMRoRp2C', 'ugoh.akongwubel@jubailibros.com', '3-2011-001', 'Human Resources', 'HR Officer', 'Victoria Island', 'Nigeria', 'hr', 'Esther Ahbulimen', 'Esther.ahbulimen@jubailibros.com', 22, 'active', '2023-04-09 07:40:13'),
(3, 'Abdelmaleeq', 'Adebayo', 'Abdelmaleeq Adebayo', 'Abdelmaleeq_Adebayo', '$2y$10$lGQgCkJDl5A64Bwweb4yRuSS2txFYczy/PuV3mPbRXoX8kMwpA7AS', 'Abdelmaleeq.adebayo@jubailibros.com', '3-2007-003', 'Information Technology', 'IT Manager', 'Victoria Island', 'Nigeria', 'supervisor', 'Nabil Suleiman', 'Nabil.suleiman@jubailibros.com', 24, 'active', '2023-04-09 07:26:00'),
(4, 'Mohammed', 'Farhat', 'Mohammed Farhat', 'Mohammed_Farhat', '$2y$10$zeaq5kHY/Wj8y/7u9Ns09OdI69qBJWJyx1XOWS8iR/A.9FveMWWg2', 'Mohammad.Farhat@jubailibros.com', '3-2000-002', 'Management', 'Area Branch Manager', 'Victoria Island', 'Nigeria', 'management', 'Nabil Suleiman', 'Nabil.suleiman@jubailibros.com', 60, 'active', '2023-04-09 13:39:17'),
(5, 'Esther', 'Ahbulimen', 'Esther Ahbulimen', 'Esther_Ahbulimen', '$2y$10$VRaIFei/LDZx4Hg3SNb45eB9dxrnJE1ngiIPeKWH7OKN0KTOVsLq.', 'Esther.ahbulimen@jubailibros.com', '3-2004-005', 'Human Resources', 'HR Manager', 'Victoria Island', 'Nigeria', 'supervisor', 'Nabil Suleiman', 'Nabil.suleiman@jubailibros.com', 24, 'active', '2023-04-09 13:37:13'),
(6, 'Quzeem', 'Fijabi', 'Quzeem Fijabi', 'Quzeem_Fijabi', '$2y$10$EyqAUH/qyE2pSIpN0Spnmu2oTdKycLzZOD/k1ImjmicJsW4jeX9Qi', 'Quzeem.Fijabi@jubailibros.com', '3-2021-019', 'Accounts', 'Senior Accountant', 'Victoria Island', 'Nigeria', 'user', 'Mohammad Farhat', 'Mohammad.Farhat@jubailibros.com', 20, 'active', '2023-03-25 17:05:45'),
(7, 'Michael', 'Aroworade', 'Michael Aroworade', 'Michael_Aroworade', '$2y$10$LlLqUe1/bRwknMZyKcO03.QqI7dQUe26aNJtyGndJmxytO.80Xr6e', 'Ayoaro85@gmail.com', '3-2021-016', 'Information Technology', 'IT Engineer', 'Victoria Island', 'Nigeria', 'user', 'Abdelmaleeq Adebayo', 'Abdelmaleeq.adebayo@jubailibros.com', 18, 'active', '2023-03-25 19:15:15'),
(8, 'Fuad', 'Laguda', 'Fuad Laguda', 'Fuad_Laguda', '$2y$10$LS1uLFNYPUgGoIQ2Jp.tf..tOaWkKQalAMVYf5y/h1iumf9YEquBq', 'Fuad.Laguda@jubailibros.com', '3-2018-011', 'Information Technology', 'IT Support Engineer 2', 'Victoria Island', 'Nigeria', 'user', 'Abdelmaleeq Adebayo', 'Abdelmaleeq.adebayo@jubailibros.com', 22, 'active', '2023-03-26 08:50:07'),
(9, 'Eric', 'Imoh', 'Eric Imoh', 'Eric_Imoh', '$2y$10$sWmOjQDUPGYfgkmrq8FLue/ehPvwM7mMNZlOWMWYecb2JkZeFCcnG', 'purchases.vi@jubailibros.com', '3-2004-009', 'Procurement', 'Senior Facility Officer', 'Victoria Island', 'Nigeria', 'user', 'Mohammad Farhat', 'Mohammad.Farhat@jubailibros.com', 23, 'active', '2023-03-26 11:47:48'),
(10, 'Nabil', 'Suleiman', 'Nabil Suleiman', 'Nabil_Suleiman', '$2y$10$fdOLPzsXq1v./oWKmcbAR.wq32Mc1Vhs43TluZ1Ma1gm/TMbh6jzy', 'Nabil.suleiman@jubailibros.com', '3-2010-005', 'Management', 'General Manager', 'Victoria Island', 'Nigeria', 'management', 'Ramzi Jubaili', 'Ramzi.jubaiii@jubailibros.com', 60, 'active', '2023-03-26 16:27:04'),
(11, 'Osama', 'Tarsha', 'Osama Tarsha', 'Osama_Tarsha', '$2y$10$FOBqa6egjGhT6ealPxV3CeCCIe9e2Ive9mU7MpGIKj4M6U/EPiG9.', 'Osama.Tarsha@jubailibros.com', '3-2007-009', 'Management', 'Admin Supervisor', 'Victoria Island', 'Nigeria', 'management', 'Nabil Suleiman', 'Nabil.suleiman@jubailibros.com', 40, 'active', '2023-04-06 07:42:01'),
(12, 'Rami', 'Suleiman', 'Rami Suleiman', 'Rami_Suleiman', '$2y$10$DmrSncSDXKTOUC8zpW1XH.aQn338Q3LcJPcbm29s5zQIxPg5p7T7q', 'Rami.suleiman@jubailibros.com', '3-2001-002', 'Finance', 'Financial Controller', 'Victoria Island', 'Nigeria', 'management', 'Nabil Suleiman', 'Nabil.suleiman@jubailibros.com', 40, 'active', '2023-04-08 11:50:57'),
(13, 'Isaac', 'Bukola', 'Isaac Bukola', 'Isaac_Bukola', '$2y$10$WITxMRggnJGz3v87XS92au3aX5Z.K1ViVnXQoLuSsOclCgw2AJI5W', 'Payable.vi@jubailibros.com', '3-2015-001', 'Finance', 'Senior Financial Officer', 'Victoria Island', 'Nigeria', 'supervisor', 'Rami Suleiman', 'Rami.suleiman@jubailibros.com', 22, 'active', '2023-04-08 11:55:27');

-- --------------------------------------------------------

--
-- Table structure for table `jbe_employees_leave`
--

CREATE TABLE `jbe_employees_leave` (
  `employee_leave_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `staff_id` varchar(200) NOT NULL,
  `totalleave` int(11) NOT NULL,
  `daystaken` int(11) NOT NULL,
  `daysleft` int(11) NOT NULL,
  `start_date` varchar(100) NOT NULL,
  `end_date` varchar(100) NOT NULL,
  `noofdays` int(10) NOT NULL,
  `resumption_date` varchar(100) NOT NULL,
  `year` varchar(20) NOT NULL,
  `month` varchar(20) NOT NULL,
  `replacedby` varchar(255) NOT NULL,
  `leavetype` varchar(50) NOT NULL,
  `supervisor_status` varchar(50) DEFAULT 'Pending',
  `hr_status` varchar(10) DEFAULT 'Pending',
  `bm_status` varchar(10) DEFAULT 'Pending',
  `edited` varchar(10) NOT NULL DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `jbe_employees_leave`
--

INSERT INTO `jbe_employees_leave` (`employee_leave_id`, `employee_id`, `staff_id`, `totalleave`, `daystaken`, `daysleft`, `start_date`, `end_date`, `noofdays`, `resumption_date`, `year`, `month`, `replacedby`, `leavetype`, `supervisor_status`, `hr_status`, `bm_status`, `edited`, `created_at`) VALUES
(1, 2, '3-2011-001', 22, 0, 22, '03-04-2023', '18-04-2023', 12, '19-04-2023', '2023', '04', 'Esther Monday', 'Annual Leave', 'Pending', 'Pending', 'Pending', 'no', '2023-03-25 04:02:09'),
(2, 7, '3-2021-016', 18, 7, 11, '03-04-2023', '11-04-2023', 7, '12-04-2023', '2023', '04', 'Ishola Olayinka', 'Annual Leave', 'Approved', 'Approved', 'Approved', 'yes', '2023-04-10 00:14:12'),
(3, 3, '3-2007-003', 24, 0, 24, '28-03-2023', '30-03-2023', 3, '31-03-2023', '2023', '03', 'Saheed Jimoh', 'Annual Leave', 'Pending', 'Pending', 'Pending', 'no', '2023-03-25 19:42:49'),
(4, 8, '3-2018-011', 22, 2, 20, '28-03-2023', '29-03-2023', 2, '30-03-2023', '2023', '03', 'Ediomo Udofia', 'Annual Leave', 'Approved', 'Approved', 'Approved', 'no', '2023-03-26 15:58:15'),
(5, 9, '3-2004-009', 23, 4, 19, '27-03-2023', '30-03-2023', 4, '31-03-2023', '2023', '03', 'Akeem Mudashiru', 'Annual Leave', 'Approved', 'Approved', 'Approved', 'no', '2023-03-31 08:33:40'),
(6, 7, '3-2021-016', 18, 0, 18, '04-04-2023', '11-04-2023', 6, '12-04-2023', '2023', '04', 'Eric Imoh', 'Annual Leave', 'Approved', 'Declined', 'Pending', 'no', '2023-03-31 08:40:34');

-- --------------------------------------------------------

--
-- Table structure for table `leave_years`
--

CREATE TABLE `leave_years` (
  `leave_year_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `totalleave` int(11) NOT NULL,
  `daystaken` int(11) NOT NULL,
  `daysleft` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `leave_years`
--

INSERT INTO `leave_years` (`leave_year_id`, `employee_id`, `year`, `totalleave`, `daystaken`, `daysleft`) VALUES
(1, 2, 2022, 22, 22, 0),
(2, 2, 2023, 22, 0, 22),
(3, 3, 2023, 24, 0, 24),
(4, 4, 2023, 60, 0, 60),
(5, 5, 2023, 24, 0, 24),
(6, 6, 2023, 20, 0, 20),
(7, 7, 2023, 18, 7, 11),
(8, 8, 2023, 22, 2, 20),
(9, 9, 2023, 23, 4, 19),
(10, 10, 2023, 60, 0, 60),
(11, 11, 2023, 30, 0, 30),
(12, 12, 2023, 40, 0, 40),
(13, 13, 2023, 22, 0, 22);

-- --------------------------------------------------------

--
-- Table structure for table `line_manager`
--

CREATE TABLE `line_manager` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `department` varchar(50) NOT NULL,
  `job_description` varchar(50) NOT NULL,
  `employeetype` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `line_manager`
--

INSERT INTO `line_manager` (`id`, `employee_id`, `fullname`, `username`, `email`, `department`, `job_description`, `employeetype`) VALUES
(1, 3, 'Abdelmaleeq Adebayo', 'Abdelmaleeq_Adebayo', 'Abdelmaleeq.adebayo@jubailibros.com', 'Information Technology', 'IT Manager', 'supervisor'),
(2, 4, 'Mohammad Farhat', 'Mohammad_Farhat', 'Mohammad.Farhat@jubailibros.com', 'Management', 'Area Branch Manager', 'management'),
(3, 5, 'Esther Ahbulimen', 'Esther_Ahbulimen', 'Esther.ahbulimen@jubailibros.com', 'Human Resources', 'HR Manager', 'supervisor'),
(5, 10, 'Nabil Suleiman', 'Nabil_Suleiman', 'Nabil.suleiman@jubailibros.com', 'Management', 'General Manager', 'management'),
(6, 11, 'Osama Tarsha', 'Osama_Tarsha', 'Osama.Tarsha@jubailibros.com', 'Management', 'Admin Supervisor', 'management'),
(7, 12, 'Rami Suleiman', 'Rami_Suleiman', 'Rami.suleiman@jubailibros.com', 'Finance', 'Financial Controller', 'management'),
(8, 13, 'Isaac Bukola', 'Isaac_Bukola', 'Payable.vi@jubailibros.com', 'Finance', 'Senior Financial Officer', 'supervisor'),
(9, 4, 'Mohammed Farhat', 'Mohammed_Farhat', 'Mohammad.Farhat@jubailibros.com', 'Management', 'Area Branch Manager', 'management');

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `region_id` int(11) NOT NULL,
  `region` varchar(100) NOT NULL,
  `region_slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`region_id`, `region`, `region_slug`) VALUES
(1, 'Nigeria', 'nigeria'),
(2, 'Ghana', 'ghana'),
(3, 'Uganda', 'uganda'),
(4, 'South Africa', 'south_africa'),
(5, 'Lebanon', 'lebanon'),
(6, 'UAE', 'uae'),
(7, 'Afghanistan', 'afghanistan'),
(8, 'Kuwait', 'kuwait'),
(9, 'Qatar', 'qatar'),
(10, 'Pakistan', 'pakistan'),
(11, 'United Kingdom', 'united_kingdom'),
(13, 'Canada', 'canada');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`branch_id`),
  ADD KEY `regions_region_id_fk` (`region_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `jbe_employees`
--
ALTER TABLE `jbe_employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email_phone` (`email_phone`);

--
-- Indexes for table `jbe_employees_leave`
--
ALTER TABLE `jbe_employees_leave`
  ADD PRIMARY KEY (`employee_leave_id`),
  ADD KEY `jbe_employees_employee_id_fk1` (`employee_id`);

--
-- Indexes for table `leave_years`
--
ALTER TABLE `leave_years`
  ADD PRIMARY KEY (`leave_year_id`),
  ADD KEY `jbe_employees_employee_id_fk3` (`employee_id`);

--
-- Indexes for table `line_manager`
--
ALTER TABLE `line_manager`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jbe_employees_employee_id_fk2` (`employee_id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`region_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `jbe_employees`
--
ALTER TABLE `jbe_employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `jbe_employees_leave`
--
ALTER TABLE `jbe_employees_leave`
  MODIFY `employee_leave_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `leave_years`
--
ALTER TABLE `leave_years`
  MODIFY `leave_year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `line_manager`
--
ALTER TABLE `line_manager`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `region_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `regions_region_id_fk` FOREIGN KEY (`region_id`) REFERENCES `regions` (`region_id`);

--
-- Constraints for table `jbe_employees_leave`
--
ALTER TABLE `jbe_employees_leave`
  ADD CONSTRAINT `jbe_employees_employee_id_fk1` FOREIGN KEY (`employee_id`) REFERENCES `jbe_employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leave_years`
--
ALTER TABLE `leave_years`
  ADD CONSTRAINT `jbe_employees_employee_id_fk3` FOREIGN KEY (`employee_id`) REFERENCES `jbe_employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `line_manager`
--
ALTER TABLE `line_manager`
  ADD CONSTRAINT `jbe_employees_employee_id_fk2` FOREIGN KEY (`employee_id`) REFERENCES `jbe_employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
