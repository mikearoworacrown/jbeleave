<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . "/class/Employee.php");

    $employee = new Employee();

    $_SESSION['employeereportsearchvalue'] = $_POST['searchvalue'];

    echo json_encode($_SESSION['employeereportsearchvalue']);

?>