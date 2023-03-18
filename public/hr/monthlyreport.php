<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . "/class/Employee.php");

    $page_title = "Yearly Report";

    $_SESSION['savedreportsearchvalue'] = "";

    if(!isset($_SESSION['email-phone']) || $_SESSION['employeetype'] != 'hr'){
        header('Location: ../');
        exit();
    }

    include(SHARED_PATH . "/header.php");

    $employee = new Employee();

    $dbYears = $employee->getYears();
    $year = date('Y');
    $month = date('m');
    $castMonth = (int)$month;
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

    $employeeRecord = $employee->getMonthlyReportPlusLeaveYear($month, $year, "Approved", "Approved");

?>

<section class="jbe__container-fluid jbe__employees-report">
    <div class="jbe__container">
        <div class="jbe__homepage-welcome">
            <div>
                <h5 class="jbe__general-header-h5">Monthly Report</h5>
                <h5>Branch: <span class="jbe__homepage-name">Victoria Island</span></h5>
            </div>
            <div form action="" method="post" class="yearreport">
                <h5><span class="jbe__homepage-name">Choose Year:</span></h5>
                <select class="indexselect leaveyearindex">
                    <?php
                        for($i = 0; $i < count($dbYears); $i++){?>
                            <option value='<?php echo $dbYears[$i]['year'];?>' <?php if($year == $dbYears[$i]['year']){ echo 'selected';} ?>><?php echo $dbYears[$i]['year']; ?></option>
                    <?php } ?>
                </select>
                <h5><span class="jbe__homepage-name">Choose Month:</span></h5>
                <select class="indexselect leaveyearindex" onchange="showMonth(this.value)">
                    <?php
                        for($i = 0; $i < $castMonth; $i++){?>
                            <option value='<?php echo $i+1;?>' <?php if($castMonth == $i+1){ echo 'selected';} ?>><?php echo $monthswords[$i]; $_SESSION['monthsword'] = $monthswords[$i];?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</section>

<script>
    function showMonth(month) {
        let year = document.querySelector(".leaveyearindex").value;
        let xml = new XMLHttpRequest();
        xml.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("monthlybody").innerHTML = this.responseText;
            }
        }
        xml.open("GET", "../ajax_php/getmonthlytable.php?month="+month+"&year="+year, true);
        xml.send();
    }
</script>

<section class="jbe__container-fluid jbe__table">
    <div class="jbe__container" id="monthlybody" style="overflow:auto;">
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
                        <td>" . $_SESSION['monthsword'] . "</td>
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
                <input type="hidden" name="monthword" value="<?php echo $_SESSION['monthsword']; ?>">
                <button class="h6 button yearlyreportbtn">Export Monthly Report</a>
            </form>
        </div>
    </div>
</section>

<?php
    include(SHARED_PATH . "/footer.php");
?>