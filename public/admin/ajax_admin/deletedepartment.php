<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . '/class/Employee.php');

    
    $department_id = h($_GET['department_id']);
    $department = h($_GET['department']);

    $employee = new Employee();

    $deleteDepartment = $employee->deleteDepartment($department_id);

    echo json_encode($deleteDepartment);
?>