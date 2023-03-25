CREATE TABLE `line_manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `department` varchar(50) NOT NULL,
  `employeetype` varchar(100) NOT NULL
  PRIMARY KEY (`id`),
  CONSTRAINT `jbe_employees_employee_id_fk2` FOREIGN KEY (`employee_id`)
  REFERENCES `jbe_employees` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;