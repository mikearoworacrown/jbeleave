<section class="jbe__container-fluid mt-3">
    <div class="jbe__container" style="position: relative">
        <div>
            <h5 class="jbe__general-header-h5">Employee Leave Request (Branch Manager)</h5>
        </div>
        
        <div class="jbe__homepage-welcome" style="position: absolute; top: -0.5rem; right: 1rem;">
            <a href="<?php echo url_for('management/allemployeerecord.php')?>" class="h6 button">View All Employee Record (Branch Manager)</a>
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
                    <th scope="col" width="9%">Total Leave</th>
                    <th scope="col" width="8%">Days Taken</th>
                    <th scope="col" width="8%">Days Left</th>
                    <th scope="col" width="15%">New Leave(No of days)</th>
                    <th scope="col">Replaced by</th>
                    <th scope="col">Supervisor Status</th>
                    <th scope="col">HR Status</th>
                    <th scope="col">BM Status</th>
                    <th scope="col" width="7%">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if(!empty($allEmployeeApplications)){
                    for($i = 0; $i < count($allEmployeeApplications); $i++){
                        echo "
                        <tr>
                            <th scope='row' id='rownumber'>". $i+1 ."</th>
                            <td>". $allEmployeeApplications[$i]['fullname'] . "</td>
                            <td>". $allEmployeeApplications[$i]['totalleave'] ."</td>
                            <td>". $allEmployeeApplications[$i]['daystaken'] ."</td>
                            <td>". $allEmployeeApplications[$i]['daysleft'] ."</td>
                            <td>". $allEmployeeApplications[$i]['noofdays'] ."</td>
                            <td>". $allEmployeeApplications[$i]['replacedby'] ."</td>
                            <td><span id='status' class='approved'>". "Processed" ."<span></td>
                            <td><span id='status' class='approved'>". "Processed" ."<span></td>
                            <td><span id='status' class='pending'>". $allEmployeeApplications[$i]['bm_status'] ."<span></td>
                            <td><a href='employeeleaveform-edit.php?employee_id=".$allEmployeeApplications[$i]['employee_id']."&employee_leave_id=".$allEmployeeApplications[$i]['employee_leave_id']."' class='h5'><i class='fas fa-edit'></i></a></td>";
                          
                        "</tr>";
                    }
                }
            ?>
            </tbody>
        </table>
    </div>
</section>