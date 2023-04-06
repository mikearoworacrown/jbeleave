<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . "/class/Employee.php");

    $employee = new Employee();
    $page_title = "employees";
    if(!isset($_SESSION['username']) || $_SESSION['employeetype'] != 'admin'){
        header('Location: ../');
        exit();
    }

    $employeeRecord = $employee->getAllEmployee();
    
    include(SHARED_PATH . "/admin-header.php");
?>

<style>
    .jbe__mainbar{
        position: absolute;
        left: 300px;
        padding: 15px 0;
        width: calc(100% - 320px);
    }
    .editemployeebtn {
        border-right: 3px solid var(--primary-color);
        padding-right: 2px;
    }
    .deleteemployeebtn {
        color: var(--color-danger);
        border-right: 3px solid var(--primary-color);
        padding-right: 4px;
    }
</style>

<section class="jbe__mainbar">
    <div class="jbe__homepage-welcome">
        <div>
            <h5 class="display-4 jbe__general-header-h5 mb-3">Employees</h5>
        </div>
    </div>
    
    <div class="jbe__employee-record" style="overflow:auto;">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col" width="4%">S/N</th>
                    <th scope="col">Employee Name</th>
                    <th scope="col">Department</th>
                    <th scope="col">Job Description</th>
                    <th scope="col">Total Leave</th>
                    <th scope="col">Line Manager</th>
                    <th scope="col">Status</th>
                    <th scope="col" width="15%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(!empty($employeeRecord)){
                        for($i = 0; $i < count($employeeRecord); $i++){
                            echo "<tr><th scope='row'>" . $i+1 . "</th>
                            <td>" . $employeeRecord[$i]['fullname'] ."</td>
                            <td>" . $employeeRecord[$i]['department'] ."</td>
                            <td>" . $employeeRecord[$i]['job_description'] . "</td>
                            <td>" . $employeeRecord[$i]['totalleave'] . "</td>
                            <td>" . $employeeRecord[$i]['linemanagername'] . "</td>";
                            if($employeeRecord[$i]['status'] === 'active'){
                                echo "<td><span style='background-color:#198754; padding: 0.3rem; border-radius: 0.4rem;'>". $employeeRecord[$i]['status'] ."<span></td>";
                            }else{
                                echo "<td><span style='background-color:#D0312D; padding: 0.3rem; border-radius: 0.4rem;'>". $employeeRecord[$i]['status'] ."<span></td>";
                            }
                            echo "<td>
                                <a href='employee-edit.php?employee_id=". $employeeRecord[$i]['employee_id'] ."' class='h5 editemployeebtn'><i class='fas fa-edit'></i></a>
                                <a href='' class='h5 deleteemployeebtn'><i class='fas fa-trash'></i></a>
                                <a href='' class='h5 passwordemployeebtn'>Reset Password</a>";
                                
                          echo "</td></tr>";
                        }
                    } else if(empty($employeeRecord) && !isset($range1) && !isset($range2)){
                        //DISPLAY NOTHING
                    }
                    else{
                        for($i = $range1; $i < $range2; $i++){
                            echo "<tr><th scope='row'>" . $i+1 . "</th>
                            <td>" . $allEmployee[$i]['fullname'] . "</td>
                            <td>" . $allEmployee[$i]['department'] ."</td>
                            <td>" . $allEmployee[$i]['job_description'] . "</td>
                            <td>" . $allEmployee[$i]['totalleave'] . "</td>
                            <td>" . $allEmployee[$i]['linemanagername'] . "</td>";
                            if($allEmployee[$i]['status'] === 'active'){
                                echo "<td><span style='background-color:#198754; padding: 0.3rem; border-radius: 0.4rem;'>". $allEmployee[$i]['status'] ."<span></td>";
                            }else{
                                echo "<td><span style='background-color:#D0312D; padding: 0.3rem; border-radius: 0.4rem;'>". $allEmployee[$i]['status'] ."<span></td>";
                            }
                            echo "<td>
                                <a href='employee-edit.php?employee_id=". $allEmployee[$i]['employee_id'] ."' class='h5'><i class='fas fa-edit'></i></a>";
                          echo "</td></tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>

</section>



<?php
    include(SHARED_PATH . "/footer.php")
?>