<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . '/class/Employee.php');
    

    $employeeRecord = new Employee();

    $response = $employeeRecord->updateEmployeeLeave($_POST["process-employeeid"], $_POST["process-leave-employeeid"], $_POST['leave-status']);

    echo json_encode($response);
    
?>