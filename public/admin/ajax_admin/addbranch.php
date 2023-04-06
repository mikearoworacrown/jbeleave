<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . '/class/Employee.php');

    $region_id = h($_POST["region_id"]);
    $branch = h($_POST["branch"]);

    $employee = new Employee();

    $addBranch = $employee->addBranch($region_id, $branch);

    echo json_encode($addBranch);
?>