<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . '/class/Employee.php');
    $requestPayload = file_get_contents("php://input");

    $data = json_decode($requestPayload, true);
    $region_id = $data["regionEditId"];
    $employee = new Employee();
    $regionInfo = $employee->getRegion($region_id);

    echo json_encode($regionInfo);
?>