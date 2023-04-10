<?php
require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
require_once(PROJECT_PATH . '/class/Employee.php');

$employee = new Employee();

$employee_id = h($_POST["employeeid"]);

$deleteEmployee = $employee->deleteEmployee($employee_id);

echo json_encode($deleteEmployee);



?>