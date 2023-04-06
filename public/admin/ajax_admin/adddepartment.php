<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . '/class/Employee.php');

    // echo var_dump($_POST);
    $department = h($_POST['department']);
    $employee = new Employee();

    $addDepartment = $employee->addDepartment($department);

    echo json_encode($addDepartment);
?>