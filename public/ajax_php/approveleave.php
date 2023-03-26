<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . '/class/Employee.php');
    
    $employeeRecord = new Employee();

    // var_dump($_POST);

    $response = $employeeRecord->approveEmployeeLeave($_POST["approve-employeeid"], $_POST["approve-leave-employeeid"], $_POST['approve-leave-status']);

    echo json_encode($response);
?>