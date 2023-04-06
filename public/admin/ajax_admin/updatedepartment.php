<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . '/class/Employee.php');

    // var_dump($_GET);
    $department_id = h($_GET['department_id']);
    $department = h($_GET['department']);

    $employee = new Employee();

    $updateDepartment = $employee->updateDepartment($department_id, $department);

    echo json_encode($updateDepartment);
?>