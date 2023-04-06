<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . "/class/Employee.php");

    $employee = new Employee();
    $page_title = "dashboard";

    if(!isset($_SESSION['username']) || $_SESSION['employeetype'] != 'admin'){
        header('Location: ../');
        exit();
    }
    
    include(SHARED_PATH . "/admin-header.php");
?>

<?php
    include("./dashboard.php");
?>


<?php
    include(SHARED_PATH . "/footer.php")
?>