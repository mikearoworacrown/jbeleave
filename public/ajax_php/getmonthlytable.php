<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . "/class/Employee.php");

    $year = $_GET['year'];
    if((int)$_GET['month'] < 10){
        $month = "0".$_GET['month'];
    }else{
        $month = $_GET['month'];
    }

    $monthswords = array(
        "January",
        "Febuary",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"
    );

    $monthsword =  $monthswords[$_GET['month']-1];

    // echo $year . $month . $monthsword;

    $employee = new Employee();
    $employeeRecord = $employee->getMonthlyReportPlusLeaveYear($month, $year, "Approved", "Approved");

?>

<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col" width="4%">S/N</th>
            <th scope="col">Employee ID</th>
            <th scope="col">Employee Name</th>
            <th scope="col">Department</th>
            <th scope="col">Supervisor</th>
            <th scope="col">Leave Month</th>
            <th scope="col">Leave Year</th>
            <th scope="col">Total Leave</th>
            <th scope="col">Start Date</th>
            <th scope="col">End Date</th>
            <th scope="col">Resumption Date</th>
            <th scope="col">Number of Days</th>
            <th scope="col">Replaced By</th>
            <th scope="col">Days Taken</th>
            <th scope="col">Days Left</th>
        </tr>
    </thead>
    <tbody>
    <?php
        if(!empty($employeeRecord)){
            for($i = 0; $i < count($employeeRecord); $i++){
                echo "<tr><th scope='row'>" . $i+1 . "</th>
                <td>" . $employeeRecord[$i]['staff_id']  . "</td>
                <td>" . $employeeRecord[$i]['firstname'] . ' ' . $employeeRecord[$i]['lastname']  . "</td>
                <td>" . $employeeRecord[$i]['department'] . "</td>
                <td>" . $employeeRecord[$i]['linemanagername'] . "</td>
                <td>" . $monthsword . "</td>
                <td>" . $employeeRecord[$i]['year'] . "</td>
                <td>" . $employeeRecord[$i]['totalleave'] . "</td>
                <td>" . $employeeRecord[$i]['start_date'] . "</td>
                <td>" . $employeeRecord[$i]['end_date'] . "</td>
                <td>" . $employeeRecord[$i]['resumption_date'] . "</td>
                <td>" . $employeeRecord[$i]['noofdays'] . "</td>
                <td>" . $employeeRecord[$i]['replacedby'] . "</td>
                <td>" . $employeeRecord[$i]['daystaken'] . "</td>
                <td>" . $employeeRecord[$i]['daysleft'] . "</td>
                ";
            }
        }?>
    </tbody>
</table>

<div class="jbe__homepage-welcome" style="margin-top: 2rem;">
    <form action="exportmonthlyreport.php" method="POST" class="yearlyreport">
        <input type="hidden" name="year" value="<?php echo $year; ?>">
        <input type="hidden" name="month" value="<?php echo $month; ?>">
        <input type="hidden" name="monthword" value="<?php echo $monthsword; ?>">
        <button class="h6 button yearlyreportbtn">Export Monthly Report</a>
    </form>
</div>