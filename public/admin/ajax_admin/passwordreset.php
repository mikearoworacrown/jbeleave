<?php
require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
require_once(PROJECT_PATH . '/class/Employee.php');

$employee = new Employee();

// var_dump($_POST);
$employee_id = h($_POST["employeeid"]);
$passwordReg = h($_POST["newpassword"]);
// Validate strong password
$password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";

$password = preg_match($password_regex, $passwordReg);

if($password){
    $response = $employee->resetEmployeePassword($employee_id, $passwordReg);
    echo json_encode($response);
}else{
    $response = array(
        "status" => "error",
        "message" => "Password must contain minimum of 8 characters, at least one uppercase, one lowercase one digit and a special character"
    );
    echo json_encode($response);
}


?>