<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . '/class/Employee.php');

    
    $region_id = h($_GET['region_id']);
    $region = h($_GET['region']);

    $employee = new Employee();

    $updateRegion = $employee->updateRegion($region_id, $region);

    echo json_encode($updateRegion);
?>