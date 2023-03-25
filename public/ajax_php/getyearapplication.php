<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH .'/class/Employee.php');

    $year = $_GET['year'];
    $employee_id = $_GET['employee_id'];
    $employee = new Employee();
    
    // echo  $year . " " . $employee_id;
    $approved = "Processed";
    $pending = "Pending";
    $declined = "Declined";
    
    // $employeeYearRecord = $employee->getEmployeeYearRecord($employee_id, $year);
    $getleaveapplication = $employee->getleaveapplication($employee_id, $year);
    
?>

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