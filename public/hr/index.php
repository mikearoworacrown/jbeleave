<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . "/class/Employee.php");

    $page_title = "Leave Form";

    if(!isset($_SESSION['username']) || $_SESSION['employeetype'] != 'hr'){
        header('Location: ../');
        exit();
    }

    unset($_SESSION['endDate']);
    unset($_SESSION['noofdays']);
    
    $employeeRecord = new Employee();
    $employeeDetails = $employeeRecord->getEmployee($_SESSION['username']);

    $year = date('Y');
    $employee_id = $_SESSION['employee-id'];
    $employeeYearDetails = $employeeRecord->getEmployeeYearRecord($employee_id, $year);
    $getleaveapplication = $employeeRecord->getleaveapplication($employee_id, $year);

    $leaveYears = $employeeRecord->getLeaveYears($employee_id);

    $supervisor_status = "Approved";
    $hr_status  = "Pending";
    $approvedLeave = $employeeRecord->getApprovedLeaveApplication($supervisor_status, $hr_status);

    $approved = "Processed";
    $pending = "Pending";
    $declined = "Declined";


    include(SHARED_PATH . "/header.php");
?>

<section class="jbe__container-fluid jbe__homepage">
    <div class="jbe__container">
        <?php if(isset($_SESSION['message'])){
            echo "
                <div id='toastr-message'>
                    <h6>". $_SESSION['message'] ."</h6>
                </div>
            ";
        }
        unset($_SESSION['message']);
        ?>
        <div class="jbe__homepage-welcome">
            <h4>Welcome <span class="jbe__homepage-name"><?php echo $employeeDetails[0]['firstname'] . " " . $employeeDetails[0]['lastname'] ?></span></h4>
            <a href="<?php echo url_for('/hr/leaveform.php')?>" class="h6 button">Apply For Leave</a>
        </div>
        <h5 class="jbe__general-header-h5">Leave information</h5>
        <div class="jbe__homepage-leave-info">
            <div class="row">
                <div class="col-md-6">
                    <h6>Job Title: <span class="jbe__homepage-name"><?php echo $employeeDetails[0]['job_description'];  ?></span></h6>
                    <h6>Department: <span class="jbe__homepage-name"><?php echo $employeeDetails[0]['department'];  ?></span></h6>
                    <h6>Line Manager: <span class="jbe__homepage-name"><?php echo $employeeDetails[0]['linemanagername'];  ?></span></h6>
                    <h6>Branch: <span class="jbe__homepage-name"><?php echo $employeeDetails[0]['branch'];  ?></span></h6>
                    <h6>Country: <span class="jbe__homepage-name"><?php echo $employeeDetails[0]['region'];  ?></span></h6>
                </div>
                <div class="col-md-6">
                    <h6>Employee ID: <span class="jbe__homepage-name"><?php echo $employeeDetails[0]['staff_id'];  ?></span></h6>
                    <h6>Year:
                        <input type="hidden" class="employee_id" value="<?php echo $_SESSION['employee-id'];?>">
                        <select class="indexselect leaveyearindex" onchange="showYearRecord(this.value)">
                            <?php
                                for($i = 0; $i < count($leaveYears); $i++){?>
                                    <option value='<?php echo $leaveYears[$i]['year'];?>' <?php if($year == $leaveYears[$i]['year']){ echo 'selected';} ?>><?php echo $leaveYears[$i]['year']; ?></option>
                          <?php } ?>
                        </select>
                        <script>
                            let employee_id = document.querySelector(".employee_id").value;
                            function showYearRecord(year) {
                                let xhr = new XMLHttpRequest();
                                xhr.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        document.getElementById("yearapplication").innerHTML = this.responseText;
                                    }
                                }
                                xhr.open("GET", "../ajax_php/getyearapplication.php?year="+year+"&employee_id="+employee_id, true);
                                xhr.send();

                                let toSend = {
                                    employee_id: employee_id,
                                    year: year
                                }
                                let xhr1 = new XMLHttpRequest();
                                xhr1.open("POST", "../ajax_php/getyear.php", true);
                                xhr1.onload = () => {
                                    if(xhr1.readyState === XMLHttpRequest.DONE){
                                        if(xhr1.status === 200){
                                            let data = xhr1.response;
                                            let dataParsed = JSON.parse(data);

                                            let daystaken = document.querySelector(".indexdaystaken");
                                            let daysleft = document.querySelector(".indexdaysremaining"); 
                                            daystaken.innerHTML = dataParsed[0]['daystaken'];
                                            daysleft.innerHTML = dataParsed[0]['daysleft'];
                                        }
                                    }
                                }
                                let jsonString = JSON.stringify(toSend);
                                // console.log(jsonString);
                                xhr1.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                                xhr1.send(jsonString);
                            }
                        </script>
                    </h6>
                    <h6>Total Days of Leave: <span class="jbe__homepage-name"><?php echo  $employeeYearDetails[0]['totalleave']; ?></span></h6>
                    <h6>Days Taken: <span class="jbe__homepage-name indexdaystaken"><?php echo $employeeYearDetails[0]['daystaken']; ?></span></h6>
                    <h6>Days Remaining: <span class="jbe__homepage-name indexdaysremaining"><?php echo $employeeYearDetails[0]['daysleft']; ?></span></h6>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="jbe__container-fluid jbe__table">
    <div class="jbe__container" id="yearapplication" style="overflow:auto;">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col" width="4%">S/N</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Resumption Date</th>
                    <th scope="col" width="12%">Number of days</th>
                    <th scope="col">Replaced By</th>
                    <th scope="col">Supervisor Status</th>
                    <th scope="col">HR Status</th>
                    <th scope="col">BM Status</th>
                </tr>
            </thead> 
            <tbody class="tbody" id="tbody">
            <?php
                if(!empty($getleaveapplication)){
                    for($i = 0; $i < count($getleaveapplication); $i++){
                        echo "
                        <tr>
                            <th scope='row' id='rownumber'>". $i+1; 
                            if($getleaveapplication[$i]['edited'] == "yes"){
                                echo "<span style='color:red;' class='h5'>*</span>";
                            } 
                            echo "</th>
                            <td id='startdate'>". $getleaveapplication[$i]['start_date'] ."</td>
                            <td id='enddate'>". $getleaveapplication[$i]['end_date'] ."</td>
                            <td id='resumptiondate'>". $getleaveapplication[$i]['resumption_date'] ."</td>
                            <td id='noofdays'>". $getleaveapplication[$i]['noofdays'] ."</td>
                            <td id='replacedby'>". $getleaveapplication[$i]['replacedby'] ."</td>"; ?>
                            <?php if($getleaveapplication[$i]['supervisor_status'] == 'Pending'){ 
                                echo "<td><span id='status' class='pending'>". $pending ."</span></td>";
                            } else if($getleaveapplication[$i]['supervisor_status'] == 'Approved') {
                                echo "<td><span id='status' class='approved'>". $approved ."</span></td>";
                            } else if($getleaveapplication[$i]['supervisor_status'] == 'Declined'){
                                echo "<td><span id='status' class='declined'>". $declined ."</span></td>";
                            }

                            if($getleaveapplication[$i]['supervisor_status'] == 'Pending' && $getleaveapplication[$i]['hr_status'] == "Pending"){
                                echo "<td><span id='status'>---</span></td><td><span id='status'>---</span></td>";
                            }else if($getleaveapplication[$i]['supervisor_status'] == 'Approved' && $getleaveapplication[$i]['hr_status'] == "Pending"){
                                echo "<td><span id='status' class='pending'>".$getleaveapplication[$i]['hr_status']."</span></td>
                                <td><span id='status'>---</span></td>";
                            }else if($getleaveapplication[$i]['supervisor_status'] == 'Approved' && $getleaveapplication[$i]['hr_status'] == "Declined"){
                                echo "<td><span id='status' class='declined'>".$getleaveapplication[$i]['hr_status']."</span></td>
                                <td><span id='status'>---</span></td>";
                            } else if($getleaveapplication[$i]['supervisor_status'] == 'Declined' && $getleaveapplication[$i]['hr_status'] == "Pending"){
                                echo "<td><span id='status'>---</span></td>
                                <td><span id='status'>---</span></td>";
                            } else if($getleaveapplication[$i]['supervisor_status'] == 'Approved' && $getleaveapplication[$i]['hr_status'] == 'Approved' && $getleaveapplication[$i]['bm_status'] == 'Pending'){
                                echo "<td><span id='status' class='approved'>".$approved."</span></td>
                                <td><span id='status' class='pending'>".$getleaveapplication[$i]['bm_status']."</span></td>";
                            }else if($getleaveapplication[$i]['supervisor_status'] == 'Approved' && $getleaveapplication[$i]['hr_status'] == 'Approved' && $getleaveapplication[$i]['bm_status'] == 'Approved'){
                                echo "<td><span id='status' class='approved'>".$approved."</span></td>
                                <td><span id='status' class='approved'>".$getleaveapplication[$i]['bm_status']."</span></td>";
                            }


                            echo
                        "</tr>";
                    }
                }
            ?>
            </tbody>
        </table>
    </div>
</section>

<section class="jbe__container-fluid jbe__employees-record">
    <div class="jbe__container">
        <div class="jbe__homepage-welcome">
            <div>
                <h5 class="jbe__general-header-h5">Employees Leave Requests</h5>
                <h5>Branch: <span class="jbe__homepage-name"><?php echo $employeeDetails[0]['branch'];  ?></span></h5>
            </div>
            <a href="<?php echo url_for('/hr/report.php')?>" class="h6 button">Employees Leave Reports</a>
        </div>
    </div>
</section>
<section class="jbe__container-fluid jbe__table">
    <div class="jbe__container" style="overflow:auto;">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col" width="4%">S/N</th>
                    <th scope="col">Employee Name</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col" width="11%">Number of days</th>
                    <th scope="col">Resumption Date</th>
                    <th scope="col">Replaced By</th>
                    <th scope="col">Suppervisor Status</th>
                    <th scope="col">HR Status</th>
                    <th scope="col">BM Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if(!empty($approvedLeave)){
                    for($i = 0; $i < count($approvedLeave); $i++){
                        echo "
                        <tr>
                            <th scope='row' id='rownumber'>". $i+1 . "</th>
                            <td>". $approvedLeave[$i]['firstname'] . " " . $approvedLeave[$i]['lastname'] . "</td>
                            <td>". $approvedLeave[$i]['start_date'] ."</td>
                            <td>". $approvedLeave[$i]['end_date'] ."</td>
                            <td>". $approvedLeave[$i]['noofdays'] ."</td>
                            <td>". $approvedLeave[$i]['resumption_date'] ."</td>
                            <td>". $approvedLeave[$i]['replacedby'] ."</td>
                            <td><span id='status' class='approved'>". $approvedLeave[$i]['supervisor_status'] ."</span></td>
                            <td><span id='status' class='pending'>". $approvedLeave[$i]['hr_status'] ."</span></td>
                            <td><span id='status'>---</span></td>
                            <td>
                                <a class='h5' href='employeeleaveform-edit.php?employee_id=".$approvedLeave[$i]['employee_id']."&employee_leave_id=".$approvedLeave[$i]['employee_leave_id']."'><i class='fas fa-edit'></i></a>
                            </td>
                        </tr>";
                    } 
                }
            ?>
            </tbody>
        </table>
    </div>
</section>


<?php

    include(SHARED_PATH . "/footer.php");
?>