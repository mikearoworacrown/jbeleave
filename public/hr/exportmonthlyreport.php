<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . "/class/DBController.php");

    if(!isset($_SESSION['username']) || $_SESSION['employeetype'] != 'hr'){
        header('Location: ../');
        exit();
    }

    // var_dump($_POST);
    $month = $_POST['month'];
    $year = $_POST['year'];
    $supervisor_status = 'Approved';
    $hr_status = 'Approved';

    $servername = "localhost";
    $username = "mike";
    $password = "mike";
    $dbname = "jbeleave";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT jbe_employees.*, jbe_employees_leave.* FROM jbe_employees INNER JOIN jbe_employees_leave 
    on jbe_employees.employee_id = jbe_employees_leave.employee_id WHERE jbe_employees_leave.month = '$month' AND jbe_employees_leave.year = '$year'
    AND jbe_employees_leave.supervisor_status = '$supervisor_status' AND jbe_employees_leave.hr_status = '$hr_status'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $timestamp = time();
        $filename = 'monthly_report_' . $timestamp . '.csv';
 
        // Headers for download 
        header("Content-Disposition: attachment; filename=\"$filename\""); 
        header("Content-Type: application/vnd.ms-excel"); 

        $csv = '"Employee ID","Employee Name","Department","Supervisor","Leave Month","Leave Year","Total Leave","Start Date","End Date","Resumption Date","Number of Days","Replaced By","Days Taken","Day Left"' . "\n";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $csv .= '"' . $row['staff_id'] . '",';
            $csv .= '"' . $row['firstname'] . " " . $row['lastname'] . '",';
            $csv .= '"' . $row['department'] . '",';
            $csv .= '"' . $row['linemanagername'] . '",';
            $csv .= '"' . $_SESSION['monthsword'] . '",';
            $csv .= '"' . $row['year'] . '",';
            $csv .= '"' . $row['totalleave'] . '",';
            $csv .= '"' . $row['start_date'] . '",';
            $csv .= '"' . $row['end_date'] . '",';
            $csv .= '"' . $row['resumption_date'] . '",';
            $csv .= '"' . $row['noofdays'] . '",';
            $csv .= '"' . $row['replacedby'] . '",';
            $csv .= '"' . $row['daystaken'] . '",';
            $csv .= '"' . $row['daysleft'] . '"' . "\n";
        }
        echo $csv;
    }else{
        $timestamp = time();
        $filename = 'monthly_report_' . $timestamp . '.csv';
 
        // Headers for download 
        header("Content-Disposition: attachment; filename=\"$filename\""); 
        header("Content-Type: application/vnd.ms-excel"); 

        $csv = '"Employee ID","Employee Name","Department","Supervisor","Leave Month","Leave Year","Total Leave","Start Date","End Date","Resumption Date","Number of Days","Replaced By","Days Taken","Day Left"' . "\n";
        echo $csv;
    }
?>