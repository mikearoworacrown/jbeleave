<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . "/class/Employee.php");

    $employee = new Employee();
    $year = $_GET['year'];

    $employeeLeaveRecord = $employee->getBMApprovedLeaveApplicationByYear($year);
?>

<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col" width="4%">S/N</th>
            <th scope="col">Employee ID</th>
            <th scope="col">Employee Name</th>
            <th scope="col">Department</th>
            <th scope="col">Supervisor</th>
            <th scope="col">Total Leave</th>
            <th scope="col">Start Date</th>
            <th scope="col">End Date</th>
            <th scope="col">Resumption Date</th>
            <th scope="col">Number of Days</th>
            <th scope="col">Replaced By</th>
            <th scope="col">Days Taken</th>
            <th scope="col">Days Left</th>
            <th scope="col">Action</th>
            <th scope="col">Edited</th>
        </tr>
    </thead>
    <tbody>
    <?php
        if(!empty($employeeLeaveRecord)){
            for($i = 0; $i < count($employeeLeaveRecord); $i++){
                echo "<tr><th scope='row'>" . $i+1 . "</th>
                <td>" . $employeeLeaveRecord[$i]['staff_id']  . "</td>
                <td>" . $employeeLeaveRecord[$i]['firstname'] . ' ' . $employeeLeaveRecord[$i]['lastname']  . "</td>
                <td>" . $employeeLeaveRecord[$i]['department'] . "</td>
                <td>" . $employeeLeaveRecord[$i]['linemanagername'] . "</td>
                <td>" . $employeeLeaveRecord[$i]['totalleave'] . "</td>
                <td>" . $employeeLeaveRecord[$i]['start_date'] . "</td>
                <td>" . $employeeLeaveRecord[$i]['end_date'] . "</td>
                <td>" . $employeeLeaveRecord[$i]['resumption_date'] . "</td>
                <td>" . $employeeLeaveRecord[$i]['noofdays'] . "</td>
                <td>" . $employeeLeaveRecord[$i]['replacedby'] . "</td>
                <td>" . $employeeLeaveRecord[$i]['daystaken'] . "</td>
                <td>" . $employeeLeaveRecord[$i]['daysleft'] . "</td>
                <td><a href='employeeleaveform-edit.php?employee_id=". $employeeLeaveRecord[$i]['employee_id'] ."&employee_leave_id=".$employeeLeaveRecord[$i]['employee_leave_id']."&year=".$employeeLeaveRecord[$i]['year']."' class='h5'><i class='fa fa-edit'></i></a></td>
                <td><p class='h5' style='color: red;'>".$employeeLeaveRecord[$i]['edited']."</p></td>
                ";
            }
        }?>
    </tbody>
</table>