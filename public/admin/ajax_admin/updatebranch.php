<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . '/class/Employee.php');

    $region_id = h($_GET['region_id']);
    $branch_id = h($_GET['branch_id']);
    $branch = h($_GET['branch']);

    $employee = new Employee();

    $updateBranch = $employee->updateBranch($branch_id, $branch);

    echo json_encode($updateBranch);
?>