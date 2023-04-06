<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . '/class/Employee.php');

    // echo var_dump($_POST);
    $region = h($_POST['regionadd']);
    $employee = new Employee();

    $addRegion = $employee->addRegion($region);

    echo json_encode($addRegion);
?>