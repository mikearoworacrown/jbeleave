<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH .'/class/Employee.php');
    $requestPayload = file_get_contents("php://input");

    // echo $requestPayload;

    $employee = new Employee();

    $data = json_decode($requestPayload, true);

    if(isset($data['department_id'])){
        $department_id = $data['department_id'];
        $departmentDetail = $employee->getDepartment($department_id);
        $department = $departmentDetail[0]['department'];
        
        $lineManager = $employee->getLineManagerByDeparment($department);

        echo json_encode($lineManager);
    }else {
        $fullname = $data['fullname'];
        $lineManager = $employee->getLineManagerByName($fullname);

        echo json_encode($lineManager);
    }
?>