<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . "/class/Employee.php");

    $employee = new Employee();

    $supervisor_status = "Approved";
    $hr_status  = "Approved";
    $_SESSION['searchvalue'] = $_POST['searchvalue'];

    $grantedLeave = $employee->getApprovedLeaveApplicationLike($supervisor_status, $hr_status, $_SESSION['searchvalue']);

    echo json_encode($grantedLeave);

?>