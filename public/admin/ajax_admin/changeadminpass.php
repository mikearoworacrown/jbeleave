<?php
require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
require_once(PROJECT_PATH . '/class/Employee.php');

$employee = new Employee();

// var_dump($_POST);
$employee_id = h($_POST["employeeid"]);
$currentPassword = h($_POST["password"]);
$newPassword = h($_POST["newpassword"]);


$passCheck = $employee->verifyCurrentPassword($employee_id, $currentPassword);
// echo $passCheck;

if($passCheck) {
    // Validate strong password
    $password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";

    $password = preg_match($password_regex, $newPassword);

    if($password){
        $response = $employee->changeAdminPassword($employee_id, $newPassword);
        echo json_encode($response);
    }else{
        $response = array(
            "status" => "error",
            "message" => "Password must contain minimum of 8 characters, at least one uppercase, one lowercase one digit and a special character"
        );
        echo json_encode($response);
    }
}else{
    $response = array(
        "status" => "error",
        "message" => "Current Password Incorrect"
    );
    echo json_encode($response);
}

?>