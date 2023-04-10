<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . "/class/Employee.php");

    $employee = new Employee();
    $page_title = "leaveapplications";
    if(!isset($_SESSION['username']) || $_SESSION['employeetype'] != 'admin'){
        header('Location: ../');
        exit();
    }
    
    include(SHARED_PATH . "/admin-header.php");

    if(isset($_GET['year'])){
        $year = $_GET['year'];
    }else{
        $year = date('Y');
    }
    $dbYears = $employee->getYears();
    $employeeLeaveRecord = $employee->getAllLeaveApplication($year);
?>
<style>
    .jbe_employee-record {
        padding: 10px 0;
    }
</style>
<div class="jbe__mainbar">
    <div class="jbe__homepage-welcome">
        <div>
            <h5 class="jbe__general-header-h5">All Leave Application</h5>
        </div>
        <div form action="" method="post" class="yearreport">
            <h5><span class="jbe__homepage-name">Choose Year:</span></h5>
            <select class="indexselect leaveyearindex" onchange="showYear(this.value)">
                <?php
                    for($i = 0; $i < count($dbYears); $i++){?>
                        <option value='<?php echo $dbYears[$i]['year'];?>' <?php if($year == $dbYears[$i]['year']){ echo 'selected';} ?>><?php echo $dbYears[$i]['year']; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="jbe_employee-record" style="overflow:auto;">
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
                        ";
                    }
                }?>
            </tbody>
        </table>
    </div>

</div>
<script>
    function showYear(year) {
        location.href = "leaveapplications.php?year="+year;
    }
</script>
<?php
    include(SHARED_PATH . "/footer.php")
?>