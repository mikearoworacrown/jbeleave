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
    $year = date('Y');
    $dbYears = $employee->getYears();
    $employeeLeaveRecord = $employee->getAllLeaveApplication($year);

    if(isset($_GET['searchvalue'])) {
        $searchValue = h($_GET['searchvalue']); 
        $employeeLeaveRecord = $employee->getAllLeaveApplicationByLike($year, $searchValue);
        if(empty($employeeLeaveRecord)){
            header('Location: leaveapplication.php');
            exit();
        }
    }
?>
<style>
    .jbe_employee-record {
        padding: 10px 0;
    }
</style>
<div class="jbe__mainbar">
    <div class="jbe__homepage-welcome">
        <div>
            <h5 class="jbe__general-header-h5">All Leave Applications</h5>
            <form action="" class="searchemployee">
                <input type="text" class="form-control searchemployeevalue" name="searchemployeevalue" value="" placeholder="Search Employee">
                <button type="button" class="searchemployeebtn"><i class="fas fa-search"></i></button>
            </form>
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

    <div class="jbe_employee-record" id="jbe_employee-record" style="overflow:auto;">
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
        let xml = new XMLHttpRequest();
        xml.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("jbe_employee-record").innerHTML = this.responseText;
            }
        }
        xml.open("GET", "ajax_admin/yearlyleaveapplicaion.php?year="+year, true);
        xml.send();
    }

    const searchEmployee = document.querySelector(".searchemployee");
        const searchEmployeeBtn = document.querySelector(".searchemployeebtn");

        if(searchEmployee){
            searchEmployee.onsubmit = (e) => {
                e.preventDefault();
            }
        }

        let searchValue = document.querySelector(".searchemployeevalue");
        searchValue.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                // event.preventDefault();
                document.querySelector('.searchemployeebtn').click();
            }
        });

        if(searchEmployeeBtn){
            searchEmployeeBtn.onclick = () => {
                let searchValue = document.querySelector(".searchemployeevalue");
                if(searchValue.value != ""){
                    location.href = "approvedleave.php?searchvalue="+searchValue.value;
                   
                }

            }
        }
</script>
<?php
    include(SHARED_PATH . "/footer.php")
?>