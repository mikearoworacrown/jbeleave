<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . '/class/Employee.php');
    $requestPayload = file_get_contents("php://input");

    $data = json_decode($requestPayload, true);
    $branch_id = $data["branchEditId"];
    $employee = new Employee();
    $branchInfo = $employee->getBranch($branch_id);

    echo json_encode($branchInfo);
?>