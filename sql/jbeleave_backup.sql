SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `jbeleave`
--

-- --------------------------------------------------------

--
-- Table structure for table `jbe_employees` 
-- 
--

CREATE TABLE `jbe_employees` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL UNIQUE,
  `password` varchar(200) NOT NULL,
  `email_phone` varchar(50) NULL UNIQUE,
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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jbe_employees_leave` 
-- 
--
CREATE TABLE `jbe_employees_leave` (
  `employee_leave_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`employee_leave_id`),
  CONSTRAINT `jbe_employees_employee_id_fk1` FOREIGN KEY (`employee_id`)
  REFERENCES `jbe_employees` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `line-manager`
-- 
--
CREATE TABLE `line_manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `department` varchar(50) NOT NULL,
  `employeetype` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `jbe_employees_employee_id_fk2` FOREIGN KEY (`employee_id`)
  REFERENCES `jbe_employees` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `leave_years` 
-- 
--
CREATE TABLE `leave_years` (
  `leave_year_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `totalleave` int(11) NOT NULL,
  `daystaken` int(11) NOT NULL,
  `daysleft` int(11) NOT NULL,
  PRIMARY KEY (`leave_year_id`),
  CONSTRAINT `jbe_employees_employee_id_fk3` FOREIGN KEY (`employee_id`)
  REFERENCES `jbe_employees` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
    `department_id` int(11) NOT NULL,
    `department` varchar(100) NOT NULL,
    `department_slug` varchar(100) NOT NULL
);


ALTER TABLE `departments` 
    ADD PRIMARY KEY (`department_id`);

ALTER TABLE `departments`
    MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------
--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
    `region_id` int(11) NOT NULL,
    `region` varchar(100) NOT NULL,
    `region_slug` varchar(100) NOT NULL
);

ALTER TABLE `regions` 
    ADD PRIMARY KEY (`region_id`);

ALTER TABLE `regions`
    MODIFY `region_id` int(11) NOT NULL AUTO_INCREMENT;


-- --------------------------------------------------------
--
-- Table structure for table `branches`
--
CREATE TABLE `branches` (
    `branch_id` int(11) NOT NULL,
    `branch` varchar(100) NOT NULL,
    `region_id` int(11) NOT NULL,
    `branch_slug` varchar(100) NOT NULL
);

ALTER TABLE `branches`
    ADD PRIMARY KEY (`branch_id`);

ALTER TABLE `branches`
    MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `branches`
    ADD CONSTRAINT `regions_region_id_fk` FOREIGN KEY (`region_id`) REFERENCES `regions` (`region_id`);


-- --------------------------------------------------------
--
-- Table structure for table INSERT
--

INSERT INTO `departments` (`department`, `department_slug`) VALUES 
('Accounts', 'accounts'),
('Aftersales', 'aftersales'),
('Fabrication', 'fabrication'),
('Finance', 'finance'),
('Genset', 'genset'),
('Health Safety Environment', 'health_safety_environment'),
('Human Resources', 'human_resources'),
('Information Technology', 'information_technology'),
('Logistics', 'logistics'),
('Management', 'management'),
('Maintenace', 'maintenace'),
('Marketing', 'marketing'),
('Production', 'production'),
('Project Account', 'project_account'),
('Public Relation', 'public_relation'),
('Procurement', 'procurement'),
('Sales', 'sales'),
('Shipping', 'shipping'),
('Stores', 'stores'),
('Technical', 'technical'),
('Telecom', 'telecom');

INSERT INTO `regions` (`region`, `region_slug`) VALUES 
('Nigeria', 'nigeria'),
('Ghana', 'ghana'),
('Uganda', 'uganda'),
('South African', 'south_africa'),
('Lebanon', 'lebanon'),
('UAE', 'uae'),
('Afghanistan', 'afghanistan'),
('Kuwait', 'kuwait'),
('Qatar', 'qatar'),
('Pakistan', 'pakistan');

INSERT INTO `branches` (`branch`, `branch_slug`, `region_id`) VALUES 
('Abuja', 'abuja', 1),
('Ajah', 'ajah', 1),
('Factory', 'factory', 1),
('Ikeja', 'ikeja', 1),
('Kano', 'kano', 1),
('Port Harcourt', 'port_harcourt', 1),
('Victoria Island', 'vi', 1);

INSERT INTO `jbe_employees` VALUES ('1', 'Admin', 'JB', 'Admin', 'Admin', '$2y$10$h46J28gKqzAB78ufb5LtTuzZyAyz6IDFbrOP6vfO8jdvhO5noCd2G', 'Ay_michael96@yahoo.com', '0-0000-000', 'Administrator', 'Administrator', 'Ikeja', 'Nigeria', 'admin', 'Administrator', 'Ay_michael96@yahoo.com', '0', 'active', current_timestamp());
INSERT INTO `jbe_employees` VALUES ('2', 'Ugoh', 'Akongwubel', 'Ugoh Akongwubel', 'Ugoh_Akongwubel', '$2y$10$mTgRL25x11/O7W9Uo2hm9OyKwiRgyjQ1CxWNO0T00YOvIPMRoRp2C', 'ugoh.akongwubel@jubailibros.com', '3-2011-001', 'Human Resources', 'HR Officer', 'Victoria Island', 'Nigeria', 'hr', 'Esther Abhulimen', 'Ay_michael96@yhoo.com', '22', 'active', current_timestamp());

INSERT INTO `leave_years` (`leave_year_id`, `employee_id`, `year`, `totalleave`, `daystaken`, `daysleft`) VALUES ('1', '2', '2022', '22', '22', '0');
INSERT INTO `leave_years` (`leave_year_id`, `employee_id`, `year`, `totalleave`, `daystaken`, `daysleft`) VALUES ('2', '2', '2023', '22', '0', '22');


GRANT ALL PRIVILEGES ON jbeleave.* TO mike@localhost identified BY 'mike';

COMMIT;