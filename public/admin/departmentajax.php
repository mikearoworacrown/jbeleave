<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . '/class/Employee.php');
    $requestPayload = file_get_contents("php://input");

    $data = json_decode($requestPayload, true);
    $department_id = $data["departmentEditId"];
    $employee = new Employee();
    $departmentInfo = $employee->getDepartment($department_id);

    echo json_encode($departmentInfo);
?>