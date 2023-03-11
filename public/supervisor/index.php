<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . "/class/Employee.php");

    $page_title = "Leave Form";

    if(!isset($_SESSION['email-phone']) || $_SESSION['employeetype'] != 'supervisor'){
        header('Location: ../');
        exit();
    }
   
    unset($_SESSION['endDate']);
    unset($_SESSION['noofdays']);
    
    $employeeRecord = new Employee();
    $employeeDetails = $employeeRecord->getEmployee($_SESSION['email-phone']);
    $_SESSION['firstname'] = $employeeDetails[0]['firstname'];

    $year = date('Y');
    $employee_id = $_SESSION['employee-id'];
    $employeeYearDetails = $employeeRecord->getEmployeeYearRecord($employee_id, $year);
    $getleaveapplication = $employeeRecord->getleaveapplication($employee_id, $year);

    $_SESSION['department'] = $employeeDetails[0]['department'];
    $employeetype = "user";
    $supervisor_status = "Pending";

    $teamApplications =  $employeeRecord->getAllTeamApplication($_SESSION['department'], $employeetype, $supervisor_status);

    $leaveYears = $employeeRecord->getLeaveYears($employee_id);

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
            <a href="<?php echo url_for('/supervisor/leaveform.php')?>" class="h6 button">Apply For Leave</a>
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
                        <select class="indexselect leaveyearindex">
                            <?php
                                for($i = 0; $i < count($leaveYears); $i++){?>
                                    <option value='<?php echo $leaveYears[$i]['year'];?>' <?php if($year == $leaveYears[$i]['year']){ echo 'selected';} ?>><?php echo $leaveYears[$i]['year']; ?></option>
                          <?php } ?>
                        </select>
                        <script>
                            let leaveYear = document.querySelector(".leaveyearindex");
                            leaveYear.onchange = () => {
                                let employee_id = document.querySelector(".employee_id").value;
                                let year = leaveYear.value;
                                let toSend = {
                                    employee_id: employee_id,
                                    year: year
                                }
                                // console.log(value);
                                let xhr = new XMLHttpRequest(); //creating XML object
                                xhr.open("POST", "../ajax_php/getyearapplication.php", true);
                                xhr.onload = () => {
                                    if(xhr.readyState === XMLHttpRequest.DONE){
                                        if(xhr.status === 200){
                                            let data = xhr.response;
                                            let dataParsed = JSON.parse(data);
                                            // console.log(dataParsed);
                                            let tbody = document.querySelector("#tbody");
                                            if(dataParsed[0].hasOwnProperty('status')){
                                                let tbody = document.querySelector("#tbody");
                                                let daystaken = document.querySelector(".indexdaystaken");
                                                let daysleft = document.querySelector(".indexdaysremaining");
                                                let startdate = document.querySelector("#startdate");
                                                let enddate = document.querySelector("#enddate");
                                                let resumptiondate = document.querySelector("#resumptiondate");
                                                let noofdays = document.querySelector("#noofdays");
                                                let status = document.querySelector("#status");
                                                let replacedby = document.querySelector("#replacedby");
                                                let rownumber = document.querySelector("#rownumber");
                                                daystaken.innerHTML = dataParsed[0]['daystaken'];
                                                daysleft.innerHTML = dataParsed[0]['daysleft'];

                                                tbody.innerHTML = "";
                                                // console.log(dataParsed.length);
                                                for(let i = 0; i < dataParsed.length; i++){
                                                    let tbody = document.getElementById("tbody");
                                                    let tr = document.createElement("tr");
                                                    let th = document.createElement("th");
                                                    th.appendChild(document.createTextNode(i+1));
                                                    tr.appendChild(th);
                                                    let td1 = document.createElement('td');
                                                    td1.appendChild(document.createTextNode(dataParsed[i]['start_date']));
                                                    tr.appendChild(td1);
                                                    let td2 = document.createElement('td');
                                                    td2.appendChild(document.createTextNode(dataParsed[i]['end_date']));
                                                    tr.appendChild(td2);
                                                    let td3 = document.createElement('td');
                                                    td3.appendChild(document.createTextNode(dataParsed[i]['resumption_date']));
                                                    tr.appendChild(td3);
                                                    let td4 = document.createElement('td');
                                                    td4.appendChild(document.createTextNode(dataParsed[i]['noofdays']));
                                                    tr.appendChild(td4);
                                                    let td5 = document.createElement('td');
                                                    td5.appendChild(document.createTextNode(dataParsed[i]['replacedby']));
                                                    tr.appendChild(td5);
                                                    let td6 = document.createElement('td');
                                                    if(dataParsed[i]['supervisor_status'] == "Pending") {
                                                        let span = document.createElement('span');
                                                        span.appendChild(document.createTextNode("Pending"));
                                                        td6.appendChild(span);
                                                        span.style.backgroundColor = "#ffc107";
                                                        span.style.padding = "0.2rem";
                                                        span.style.borderRadius = "0.3rem";
                                                    } else if(dataParsed[i]['supervisor_status'] == "Approved") {
                                                        let span = document.createElement('span');
                                                        span.appendChild(document.createTextNode("Processed"));
                                                        td6.appendChild(span);
                                                        span.style.backgroundColor = "#198754";
                                                        span.style.padding = "0.2rem";
                                                        span.style.borderRadius = "0.3rem";
                                                    }else if(dataParsed[i]['status'] == "Declined") {
                                                        let span = document.createElement('span');
                                                        span.appendChild(document.createTextNode("Declined"));
                                                        td6.appendChild(span);
                                                        span.style.backgroundColor = "#D0312D";
                                                        span.style.padding = "0.2rem";
                                                        span.style.borderRadius = "0.3rem";
                                                    }
                                                    tr.appendChild(td6);
                                                    let td7 = document.createElement('td');
                                                    if(dataParsed[i]['supervisor_status'] == "Pending" && dataParsed[i]['hr_status'] == 'Pending') {
                                                        let span = document.createElement('span');
                                                        span.appendChild(document.createTextNode("---"));
                                                        td7.appendChild(span);
                                                    } else if(dataParsed[i]['supervisor_status'] == "Declined" && dataParsed[i]['hr_status'] == 'Pending') {
                                                        let span = document.createElement('span');
                                                        span.appendChild(document.createTextNode("---"));
                                                        td7.appendChild(span);
                                                    }else if(dataParsed[i]['supervisor_status'] == "Approved" && dataParsed[i]['hr_status'] == 'Pending') {
                                                        let span = document.createElement('span');
                                                        span.appendChild(document.createTextNode("Approved"));
                                                        td7.appendChild(span);
                                                        span.style.backgroundColor = "#198754";
                                                        span.style.padding = "0.2rem";
                                                        span.style.borderRadius = "0.3rem";
                                                    }else if(dataParsed[i]['supervisor_status'] == "Approved" && dataParsed[i]['hr_status'] == 'Declined') {
                                                        let span = document.createElement('span');
                                                        span.appendChild(document.createTextNode("Declined"));
                                                        td7.appendChild(span);
                                                        span.style.backgroundColor = "#D0312D";
                                                        span.style.padding = "0.2rem";
                                                        span.style.borderRadius = "0.3rem";
                                                    }
                                                    tr.appendChild(td6);
                                                    tbody.appendChild(tr);
                                                    // rownumber.innerHTML = i+1;
                                                    // startdate.innerHTML = dataParsed[i]['start_date'];
                                                    // enddate.innerHTML = dataParsed[i]['end_date'];
                                                    // resumptiondate.innerHTML = dataParsed[i]['resumption_date'];
                                                    // noofdays.innerHTML = dataParsed[i]['noofdays'];
                                                    // replacedby.innerHTML = dataParsed[i]['replacedby'];
                                                    // status.innerHTML = dataParsed[i]['status'];
                                                    
                                                }
                                            }else{
                                                tbody.innerHTML = "";
                                                let daystaken = document.querySelector(".indexdaystaken");
                                                let daysleft = document.querySelector(".indexdaysremaining");
                                                
                                                daystaken.innerHTML = dataParsed[0]['daystaken'];
                                                daysleft.innerHTML = dataParsed[0]['daysleft'];
                                            }
                                        }
                                    }
                                }
                                let jsonString = JSON.stringify(toSend);
                                // console.log(jsonString);
                                xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                                xhr.send(jsonString);
                            }
                        </script>
                    </h6>
                    <h6>Total Days of Leave: <span class="jbe__homepage-name"><?php echo $employeeDetails[0]['totalleave']  ?></span></h6>
                    <h6>Days Taken: <span class="jbe__homepage-name indexdaystaken"><?php echo $employeeYearDetails[0]['daystaken'] ?></span></h6>
                    <h6>Days Remaining: <span class="jbe__homepage-name indexdaysremaining"><?php echo $employeeYearDetails[0]['daysleft'] ?></span></h6>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="jbe__container-fluid jbe__table">
    <div class="jbe__container">
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
                </tr>
            </thead> 
            <tbody class="tbody" id="tbody">
                <?php
                if(!empty($getleaveapplication)){
                    for($i = 0; $i < count($getleaveapplication); $i++){
                        echo "
                        <tr>
                            <th scope='row' id='rownumber'>". $i+1 ."</th>
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
                                echo "<td><span id='status'>---</span></td>";
                            }else if($getleaveapplication[$i]['supervisor_status'] == 'Approved' && $getleaveapplication[$i]['hr_status'] == "Pending"){
                                echo "<td><span id='status' class='pending'>".$getleaveapplication[$i]['hr_status']."</span></td>";
                            }else if($getleaveapplication[$i]['supervisor_status'] == 'Approved' && $getleaveapplication[$i]['hr_status'] == "Declined"){
                                echo "<td><span id='status' class='declined'>".$getleaveapplication[$i]['hr_status']."</span></td>";
                            }else if($getleaveapplication[$i]['supervisor_status'] == 'Approved' && $getleaveapplication[$i]['hr_status'] == "Approved"){
                                echo "<td><span id='status' class='approved'>".$getleaveapplication[$i]['hr_status']."</span></td>";
                            } else if($getleaveapplication[$i]['supervisor_status'] == 'Declined' && $getleaveapplication[$i]['hr_status'] == "Pending"){
                                echo "<td><span id='status'>---</span></td>";
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


<section class="jbe__container-fluid mt-3">
    <div class="jbe__container" style="position: relative">
        <div>
            <h5 class="jbe__general-header-h5">Team Leave Request</h5>
            <h5>Branch: <span class="jbe__homepage-name"><?php echo $employeeDetails[0]['branch'];  ?></span></h5>
        </div>
        
        <div class="jbe__homepage-welcome" style="position: absolute; top: 1rem; right: 1rem;">
            <a href="<?php echo url_for('supervisor/teamrecord.php')?>" class="h6 button">View Team Record</a>
        </div>
    </div>
</section>

<section class="jbe__container-fluid jbe__table">
    <div class="jbe__container">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col" width="4%">S/N</th>
                    <th scope="col">Employee Name</th>
                    <th scope="col" width="9%">Total Leave</th>
                    <th scope="col" width="8%">Days Taken</th>
                    <th scope="col" width="8%">Days Left</th>
                    <th scope="col" width="15%">New Leave(No of days)</th>
                    <th scope="col">Replaced by</th>
                    <th scope="col">Status</th>
                    <th scope="col" width="7%">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if(!empty($teamApplications)){
                    for($i = 0; $i < count($teamApplications); $i++){
                        echo "
                        <tr>
                            <th scope='row' id='rownumber'>". $i+1 ."</th>
                            <td>". $teamApplications[$i]['firstname'] . " " . $teamApplications[$i]['lastname'] . "</td>
                            <td>". $teamApplications[$i]['totalleave'] ."</td>
                            <td>". $teamApplications[$i]['daystaken'] ."</td>
                            <td>". $teamApplications[$i]['daysleft'] ."</td>
                            <td>". $teamApplications[$i]['noofdays'] ."</td>
                            <td>". $teamApplications[$i]['replacedby'] ."</td>
                            <td><span id='status' class='pending'>". $teamApplications[$i]['supervisor_status'] ."<span></td>
                            <td><a href='userleaveform-edit.php?employee_id=".$teamApplications[$i]['employee_id']."&employee_leave_id=".$teamApplications[$i]['employee_leave_id']."' class='h5'><i class='fas fa-edit'></i></a></td>";
                          
                        "</tr>";
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