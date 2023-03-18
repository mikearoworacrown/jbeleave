-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2023 at 06:17 PM
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
(7, 'Victoria Island', 1, 'vi');

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
(21, 'Telecom', 'telecom');

-- --------------------------------------------------------

--
-- Table structure for table `jbe_employees`
--

CREATE TABLE `jbe_employees` (
  `employee_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email_phone` varchar(50) NOT NULL,
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

INSERT INTO `jbe_employees` (`employee_id`, `firstname`, `lastname`, `password`, `email_phone`, `staff_id`, `department`, `job_description`, `branch`, `region`, `employeetype`, `linemanagername`, `linemanageremail`, `totalleave`, `status`, `created_at`) VALUES
(1, 'Ugoh', 'Akongwubel', '$2y$10$mTgRL25x11/O7W9Uo2hm9OyKwiRgyjQ1CxWNO0T00YOvIPMRoRp2C', 'ugoh.akongwubel@jubailibros.com', '3-2011-001', 'Human Resources', 'HR Officer', 'Victoria Island', 'Nigeria', 'hr', 'Esther Abhulimen', 'Ay_michael96@yhoo.com', 22, 'active', '2023-03-12 09:17:48'),
(2, 'Michael', 'Aroworade', '$2y$10$gyxaZrI/Cr45RELoFB9MpOJSiTuLtxX8sTk0vZyZPFV3thhhBnCi.', 'Ayoaro85@gmail.com', '3-2021-016', 'Information Technology', 'IT Support Engineer', 'Victoria Island', 'Nigeria', 'user', 'Abdelmaleeq Adebayo', 'Abdelmaleeq.Adebayo@jubailibros.com', 18, 'active', '2023-03-12 09:44:49'),
(3, 'Abdelmaleeq', 'Adebayo', '$2y$10$h./4wv7IvgIh.wpu6UaH1.tsmFv57Fe691Qj7j58F81AnGm03lsdi', 'Abdelmaleeq.adebayo@jubailibros.com', '3-2006-005', 'Information Technology', 'IT Manager', 'Ikeja', 'Nigeria', 'supervisor', 'Nabil Suleiman', 'Ay_michael96@yahoo.com', 24, 'active', '2023-03-12 09:48:50'),
(4, 'Fuad', 'Laguda', '$2y$10$TwUM0QgWX/X1lT9ad2L.Cu9azFlH94U.AbzJ89WwmyEai6ysZxfJG', 'fuad.laguda@jubailibros.com', '3-2018-009', 'Information Technology', 'IT Support Engineer 2', 'Ikeja', 'Nigeria', 'user', 'Abdelmaleeq Adebayo', 'Abdelmaleeq.adebayo@jubailibros.com', 22, 'active', '2023-03-12 11:08:53'),
(5, 'Saheed', 'Jimoh', '$2y$10$AimSbjwlh.Y0v1xRcyejKO.6.wxS2GYGImVzj0eQmIbirxbWbjyYu', 'Saheed.jimoh@jubailibros.com', '3-2011-003', 'Information Technology', 'IT Support Engineer 2', 'Ikeja', 'Nigeria', 'user', 'Abdelmaleeq Adebayo', 'Abdelmaleeq.adebayo@jubailibros.com', 22, 'active', '2023-03-12 13:42:10'),
(6, 'Esther', 'Abhulimen', '$2y$10$T2QEsvqurhal64s1uzW3m.kHkDaMLm52idpt6B4dQ.xg.rZRVpPiu', 'Esther.abhulimen@jubailibros.com', '3-2006-003', 'Human Resources', 'HR Manager', 'Victoria Island', 'Nigeria', 'supervisor', 'Nabil Suleiman', 'Ay_michael96@yahoo.com', 24, 'active', '2023-03-17 22:24:42'),
(7, 'Eric', 'Imoh', '$2y$10$Scvre3jfOrN6OlpLAhY2L.G4090sMpA8fTU1Ik1LNedO6fwS9aqWO', 'purchases.vi@jubailibros.com', '3-2004-008', 'Procurement', 'Senior Facility Officer', 'Victoria Island', 'Nigeria', 'user', 'Mohammad Farhat', 'Ay_michael96@yahoo.com', 23, 'active', '2023-03-17 22:12:49'),
(8, 'Akeem', 'Mudashiru', '$2y$10$hAbXip7xjzyyb2SQYhuzSuAMSxLUhNkW0llTcL99Gy37Y.syHHB/y', 'Akeem.mudashiru@jubailibros.com', '3-2018-006', 'Public Relation', 'PRO Officer', 'Victoria Island', 'Nigeria', 'user', 'Oladapo Sulaiman', 'Ay_michael96@yahoo.com', 18, 'active', '2023-03-17 22:14:34'),
(9, 'Sulaiman', 'Oladapo', '$2y$10$CsgqxSF1BgIF99jpQnxPuOlrXkE/ltXEI2.rIuxks9cYKJLP/wTIq', 'Sulaiman.oladapo@jubailibros.com', '3-2015-001', 'Public Relation', 'Senior PRO Officer', 'Victoria Island', 'Nigeria', 'supervisor', 'Mohammad Farhat', 'Ay_michael96@yahoo.com', 22, 'active', '2023-03-17 22:24:26'),
(10, 'Charles', 'Shonola', '$2y$10$Bev7f4NNXBrrRazE7nFWM.vN4P3PPYiouE36pLS79PnlprAOwOvCS', 'Charles.shonola@jubailibros.com', '3-2012-011', 'Aftersales', 'Asst. Aftersales Supervisor', 'Victoria Island', 'Nigeria', 'supervisor', 'Mohammad Farhat', 'Ay_michael96@yahoo.com', 22, 'active', '2023-03-17 22:24:17'),
(11, 'Femi', 'Abbey', '$2y$10$SzGqMXAlfnPlZLi1wsWXWOsc.pIbHmxZb0sUJ5dsuwfC4V3UF2i.S', 'Femi.abbey@jubailibros.com', '3-2017-009', 'Aftersales', 'Customer Care Representative', 'Victoria Island', 'Nigeria', 'user', 'Charles Shonola', 'Ay_michael96@yahoo.com', 20, 'active', '2023-03-17 22:22:35'),
(12, 'Kazeem', 'Anjorin', '$2y$10$Qfdl4Bgw1o/2W9VgzpvGAuNMSbs0pCTrkEImAU7caKb0YHVoxKR8q', 'Kazeem.anjorin@jubailibros.com', '3-2010-008', 'Aftersales', 'Admin Officer', 'Victoria Island', 'Nigeria', 'user', 'Charles Shonola', 'Ay_michael96@yahoo.com', 22, 'active', '2023-03-17 22:23:55'),
(13, 'Mohammad', 'Farhat', '$2y$10$e8B48JoDXgcMxC/1YbO0aesEErMW3gipz.pOfuhliRk1eh7Uv9o6a', 'Mohammad.farhat@jubailibros.com', '3-2002-001', 'Management', 'Area Manager', 'Victoria Island', 'Nigeria', 'management', 'Nabil Suleiman', 'Ay_michael96@yahoo.com', 60, 'active', '2023-03-17 23:55:48'),
(14, 'Nabil', 'Suleiman', '$2y$10$YGr3soQ5PH6hnVBeO3D7tO1qw76Y3yzJ4dc28J0fCHlLeKdnJMfAq', 'Nabil.Suleiman@jubailaibros.com', '3-2005-001', 'Management', 'General Manager', 'Victoria Island', 'Nigeria', 'management', 'Ramzi Jubaili', 'Ay_michael96@yahoo.com', 60, 'active', '2023-03-18 01:10:09');

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
  `month` varchar(50) NOT NULL,
  `replacedby` varchar(255) NOT NULL,
  `leavetype` varchar(50) NOT NULL,
  `supervisor_status` varchar(50) DEFAULT 'Pending',
  `hr_status` varchar(10) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `jbe_employees_leave`
--

INSERT INTO `jbe_employees_leave` (`employee_leave_id`, `employee_id`, `staff_id`, `totalleave`, `daystaken`, `daysleft`, `start_date`, `end_date`, `noofdays`, `resumption_date`, `year`, `month`, `replacedby`, `leavetype`, `supervisor_status`, `hr_status`, `created_at`) VALUES
(1, 1, '3-2011-001', 22, 0, 22, '27-03-2023', '30-03-2023', 4, '31-03-2023', '2023', '03', 'Esther Monday', 'Annual Leave', 'Pending', 'Pending', '2023-03-17 21:08:47'),
(2, 2, '3-2021-016', 18, 11, 7, '03-04-2023', '17-04-2023', 11, '18-04-2023', '2023', '04', 'Ishola Olayinka', 'Annual Leave', 'Approved', 'Approved', '2023-03-17 21:09:00'),
(3, 4, '3-2018-009', 22, 0, 22, '17-03-2023', '28-03-2023', 8, '29-03-2023', '2023', '03', 'Saheed Jimoh', 'Annual Leave', 'Declined', 'Pending', '2023-03-17 21:09:23'),
(4, 5, '3-2011-003', 22, 0, 22, '14-03-2023', '28-03-2023', 11, '29-03-2023', '2023', '03', 'Ediomo Udofia', 'Annual Leave', 'Approved', 'Declined', '2023-03-17 21:09:30'),
(5, 4, '3-2018-009', 22, 5, 17, '05-04-2023', '11-04-2023', 5, '12-04-2023', '2023', '04', 'Michael Aroworade', 'Annual Leave', 'Approved', 'Approved', '2023-03-17 21:22:49'),
(6, 8, '3-2018-006', 18, 7, 11, '20-03-2023', '28-03-2023', 7, '29-03-2023', '2023', '03', 'Oladapo Sulaiman', 'Annual Leave', 'Approved', 'Approved', '2023-03-17 22:32:44'),
(7, 11, '3-2017-009', 20, 5, 15, '20-03-2023', '24-03-2023', 5, '27-03-2023', '2023', '03', 'Bashir', 'Annual Leave', 'Approved', 'Approved', '2023-03-17 22:32:35'),
(8, 12, '3-2010-008', 22, 6, 16, '22-03-2023', '29-03-2023', 6, '30-03-2023', '2023', '03', 'Francis Anamayan', 'Annual Leave', 'Approved', 'Approved', '2023-03-17 22:32:25'),
(9, 10, '3-2012-011', 22, 8, 14, '20-03-2023', '29-03-2023', 8, '30-03-2023', '2023', '03', 'Edward Ekpo', 'Annual Leave', 'Approved', 'Approved', '2023-03-18 01:06:06'),
(10, 7, '3-2004-008', 23, 10, 13, '03-04-2023', '23-03-2023', 10, '24-03-2023', '2023', '04', 'Akeem Mudashiru', 'Annual Leave', 'Approved', 'Approved', '2023-03-18 01:05:56'),
(11, 9, '3-2015-001', 22, 5, 17, '19-04-2023', '25-04-2023', 5, '26-04-2023', '2023', '04', 'Akeem Mudashiru', 'Annual Leave', 'Approved', 'Approved', '2023-03-18 01:03:39'),
(12, 3, '3-2006-005', 24, 0, 24, '11-04-2023', '18-04-2023', 6, '19-04-2023', '2023', '04', 'Saheed Jimoh', 'Annual Leave', 'Approved', 'Pending', '2023-03-18 01:18:24'),
(13, 6, '3-2006-003', 24, 0, 24, '20-04-2023', '26-04-2023', 5, '27-04-2023', '2023', '04', 'Adeola', 'Annual Leave', 'Pending', 'Pending', '2023-03-18 01:11:11');

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
(1, 1, 2022, 22, 22, 0),
(2, 1, 2023, 22, 0, 22),
(3, 2, 2023, 18, 11, 7),
(4, 3, 2023, 24, 0, 24),
(5, 4, 2023, 22, 5, 17),
(6, 5, 2023, 22, 0, 22),
(7, 6, 2023, 24, 0, 24),
(8, 7, 2023, 23, 10, 13),
(9, 8, 2023, 18, 7, 11),
(10, 9, 2023, 22, 5, 17),
(11, 10, 2023, 22, 8, 14),
(12, 11, 2023, 20, 5, 15),
(13, 12, 2023, 22, 6, 16),
(14, 13, 2023, 60, 0, 60),
(15, 14, 2023, 60, 0, 60);

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
(4, 'South African', 'south_africa'),
(5, 'Lebanon', 'lebanon'),
(6, 'UAE', 'uae'),
(7, 'Afghanistan', 'afghanistan'),
(8, 'Kuwait', 'kuwait'),
(9, 'Qatar', 'qatar'),
(10, 'Pakistan', 'pakistan');

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
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `jbe_employees`
--
ALTER TABLE `jbe_employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `jbe_employees_leave`
--
ALTER TABLE `jbe_employees_leave`
  MODIFY `employee_leave_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `leave_years`
--
ALTER TABLE `leave_years`
  MODIFY `leave_year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `region_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  ADD CONSTRAINT `jbe_employees_employee_id_fk1` FOREIGN KEY (`employee_id`) REFERENCES `jbe_employees` (`employee_id`);

--
-- Constraints for table `leave_years`
--
ALTER TABLE `leave_years`
  ADD CONSTRAINT `jbe_employees_employee_id_fk2` FOREIGN KEY (`employee_id`) REFERENCES `jbe_employees` (`employee_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
