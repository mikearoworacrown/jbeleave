<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . '/class/Employee.php');
    
    $employeeRecord = new Employee();

    if(!isset($_SESSION['endDate'])){
        $_SESSION['endDate'] = $_POST['notchangedenddate'];
        $edited = "no";
    }else{
        $edited = "yes";
    }

    if(!isset($_SESSION['noofdays'])){
        $_SESSION['noofdays'] = $_POST['notchangednoofdays'];
    }
    $leave_commence = $_POST["leave-commencing"];
    $leave_resumption = $_POST["leave-resumption"];
    $leave_enddate = $_SESSION['endDate'];
    $leave_noofdays = $_SESSION['noofdays'];
    $leave_daystaken = $leave_noofdays;
    $leave_daysleft = $_SESSION['daysleft'] + ($_SESSION['daystaken'] - $leave_noofdays);
    $response = $employeeRecord->adminUpdateEmployeeLeave($leave_commence, $leave_enddate, $leave_resumption, $leave_noofdays, $leave_daystaken, $leave_daysleft, $edited);

    echo json_encode($response);
?>