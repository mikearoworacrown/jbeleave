<?php 
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH .'/class/Employee.php');
    $employee = new Employee();
    
    $_SESSION['username'] = (h($_POST['username']));
    $_SESSION['password']= h($_POST['password']);

    
    if(!empty($_SESSION['username']) && !empty($_SESSION['password'])){
        $loginResult = $employee->loginEmployee($_SESSION['username']);
        echo $loginResult;
    }
    else {
        echo "Invalid Username or Password from login.php.";
    }
?>