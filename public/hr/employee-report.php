<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . "/class/Employee.php");

    if(!isset($_GET['employee_id'])&& !isset($_GET['employee_no']) && !isset($_GET['employee_no'])){
        header('Location: ../');
        exit();
    }

    $employee = new Employee();
    $employee_id = $_GET['employee_id'];
    $employee_no = $_GET['employee_no'];
    $year = $_GET['year'];
    $supervisor_status = "Approved";
    $hr_status = "Approved";

    $employeeRecord = $employee->getEmployeeByIdPlusLeaveYear($employee_id, $year, $supervisor_status, $hr_status);

    include(SHARED_PATH . "/header.php");
?>

<section class="jbe__container-fluid jbe__table jbe__employees-record">
    <div class="jbe__container">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col" width="4%">S/N</th>
                    <th scope="col">Employee ID</th>
                    <th scope="col">Employee Name</th>
                    <th scope="col">Department</th>
                    <th scope="col">Supervisor</th>
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
            <form action="exportemployeereport.php" method="POST" class="employeereportform">
                <input type="hidden" name="employee-id" value="<?php echo $employee_id; ?>">
                <input type="hidden" name="employee-no" value="<?php echo $employee_no; ?>">
                <input type="hidden" name="year" value="<?php echo $year; ?>">
                <button class="h6 button employeereportbtn">Export Employee Report</a>
            </form>
        </div>
    </div>
</section>

<!-- <script>
    const employeeReportForm = document.querySelector('.employeereportform');
    const employeeReportBtn = document.querySelector('.employeereportbtn');

    if(employeeReportForm){
        employeeReportForm.onsubmit = (e) => {
            e.preventDefault();
        }
    }

    if(employeeReportBtn) {
        employeeReportBtn.onclick = () => {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "../ajax_php/employeereportform.php", true)
            xhr.onload = () => {
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        
                    }
                }
            }
            let formData = new FormData(employeeReportForm); //creating new formData object
            xhr.send(formData); //sending the form data to php
        }
    }
</script> -->

<?php
    include(SHARED_PATH . "/footer.php");
?>