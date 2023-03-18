<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . "/class/Employee.php");

    if(!isset($_SESSION['email-phone']) || $_SESSION['employeetype'] != 'hr'){
        header('Location: ../');
        exit();
    }

    // var_dump($_POST);
    $supervisor_status = "Approved";
    $hr_status = "Approved";
    $employee_id = $_POST['employee-id'];
    $year = $_POST['year'];
    $employee_no = $_POST['employee-no'];

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

    $sql = "SELECT jbe_employees.staff_id, jbe_employees.firstname, jbe_employees.lastname, jbe_employees.linemanagername,
    jbe_employees.department, jbe_employees.totalleave, jbe_employees_leave.year, jbe_employees_leave.start_date,jbe_employees_leave.end_date,
    jbe_employees_leave.resumption_date,jbe_employees_leave.noofdays,jbe_employees_leave.replacedby,jbe_employees_leave.daystaken,
    jbe_employees_leave.daysleft FROM jbe_employees 
    INNER JOIN jbe_employees_leave on jbe_employees.employee_id = jbe_employees_leave.employee_id 
    WHERE jbe_employees.employee_id = '$employee_id' AND jbe_employees_leave.year = '$year' AND jbe_employees_leave.supervisor_status = '$supervisor_status' 
    AND jbe_employees_leave.hr_status = '$hr_status'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $timestamp = time();
        $filename = 'Employee_report_' . $timestamp . '.csv';
 
        // Headers for download 
        header("Content-Disposition: attachment; filename=\"$filename\""); 
        header("Content-Type: application/vnd.ms-excel"); 

        $csv = '"Employee ID","Employee Name","Department","Supervisor","Leave Year","Total Leave","Start Date","End Date","Resumption Date","Number of Days","Replace By","Days Taken","Day Left"' . "\n";
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $csv .= '"' . $row['staff_id'] . '",';
            $csv .= '"' . $row['firstname'] . " " . $row['lastname'] . '",';
            $csv .= '"' . $row['department'] . '",';
            $csv .= '"' . $row['linemanagername'] . '",';
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
    }else {
        $timestamp = time();
        $filename = 'Employee_report_' . $timestamp . '.csv';
 
        // Headers for download 
        header("Content-Disposition: attachment; filename=\"$filename\""); 
        header("Content-Type: application/vnd.ms-excel"); 

        $csv = '"Employee ID","Employee Name","Department","Supervisor","Leave Year","Total Leave","Start Date","End Date","Resumption Date","Number of Days","Replace By","Days Taken","Day Left"' . "\n";
        // output data of each row
        echo $csv;
    }

?>