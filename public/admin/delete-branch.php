<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . "/class/Employee.php");

    $employee = new Employee();
    $page_title = "dashboard";


    if(!isset($_SESSION['username']) || $_SESSION['employeetype'] != 'admin'){
        header('Location: ../');
        exit();
    }

    
    $branch_id = $_GET['branch_id'];
    $region_id = $_GET['region_id'];
    $branch = $_GET['branch'];

    if(!isset($branch_id) && !isset($region_id)){
        header('Location: ../');
        exit();
    }
    
    include(SHARED_PATH . "/admin-header.php");

    $year = "2023";
    $regions = $employee->getRegions();
    $branches = $employee->getBranches($region_id);
    $department = $employee->getDepartments();
    $allEmployee = $employee->getAllEmployee();
    $leaveApplied = $employee->getLeaveApplied($year);
    $leaveApproved = $employee->getBMApprovedLeaveApplicationByYear($year);
    $leaveDeclined = $employee->getAllDeclinedLeaveByYear($year);
    $leavePending = $employee->getAllPendingLeaveByYear($year);
    $branchInfo = $employee->getBranch($branch_id);
    $regionInfo = $employee->getRegion($region_id);

?>
<style>
    .regioneditbtn, .brancheditbtn {
        color: var(--primary-color);
        cursor: pointer;
    }
    .regiondeletebtn, .branchdeletebtn{
        color: var(--color-danger);
        cursor: pointer;
    }
</style>

<section class="jbe__mainbar">
    <div class="jbe__homepage-welcome">
        <div>
            <h4 class="display-6" style="font-weight: 500;">VI Branch</h4>
        </div>

    </div>
    

   <div class="row">
        <div class="col-md-4">
            <div class="jbe__analysis-box">
                <h6>Employees</h6>
                <h6 class="display-4 count"><?php if($allEmployee){echo count($allEmployee);}else{echo 0;} ?></h6>
            </div>
            <div class="jbe__analysis-box">
                <h6>Departments</h6>
                <h6 class="display-4 count"><?php if($department){echo count($department);}else{echo 0;} ?></h6>
            </div>
        </div>
        <div class="col-md-4">
            <div class="jbe__analysis-box">
                <h6>Total Leave Applied</h4>
                <h6 class="display-4 count"><?php if($leaveApplied){echo count($leaveApplied);}else{echo 0;} ?></h6>
            </div>
            <div class="jbe__analysis-box">
                <h6>Total Leave Approved</h6>
                <h6 class="display-4 count"><?php if($leaveApproved){echo count($leaveApproved);}else{echo 0;} ?></h6>
            </div>
        </div>
        <div class="col-md-4">
            <div class="jbe__analysis-box">
                <h6>Total Leave Pending</h6>
                <h6 class="display-4 count"><?php if($leavePending){echo count($leavePending);}else{echo 0;} ?></h6>
            </div>
            <div class="jbe__analysis-box">
                <h6>Total Leave Declined</h6>
                <h6 class="display-4 count"><?php if($leaveDeclined){echo count($leaveDeclined);}else{echo 0;} ?></h6>
            </div>
        </div>
    </div>

    <div class="row">
    <!--------------------------------------- Region Table ------------------------------------------------->
        <div class="col-md-6">
            <div class="jbe__region" style="overflow: auto;">
                <div class="jbe__homepage-welcome">
                    <h5 class="jbe__general-header-h5">All Regions</h5>
                    <!-- Trigger/Open The Modal -->
                    <a id="btn-region" class="h6 button">Add Region</a>
                </div>
                <div class="region-table">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" width="4%">S/N</th>
                                <th scope="col">Region</th>
                                <th scope="col" width="4%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(!empty($regions)){
                                    for($i = 0; $i < count($regions); $i++){
                                        echo "<tr><th scope='row'>" . $i+1 . "</th>
                                        <td>" . $regions[$i]['region'] . "</td>
                                        <td>
                                            <input type='hidden' class='regionedit-id' name='regionedit-id' value='". $regions[$i]['region_id'] ."'/>
                                            <button class='h5 regioneditbtn'><i class='fas fa-edit'></i></button>
                                            <button class='h5 regiondeletebtn'><i class='fas fa-trash'></i></button>
                                        </td>
                                        </tr>";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--------------------------------------- Branch Table ------------------------------------------------->
        <div class="col-md-6">
            <div class="jbe__branch" style="overflow: auto;">
                <div class="jbe__homepage-welcome">
                    <select class="form-select region-select" name="region_id">
                        <option value='<?php echo $regionInfo[0]["region_id"];?>'><?php echo $regionInfo[0]["region"]?></option>
                    </select>
                    <a id="btn-branch" class="h6 button">Add Branch</a>
                </div>
                <div id="branch-table">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" width="4%">S/N</th>
                                <th scope="col">Branch</th>
                                <th scope="col" width="4%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(!empty($branches)){
                                    for($i = 0; $i < count($branches); $i++){
                                        echo "<tr><th scope='row'>" . $i+1 . "</th>
                                        <td>" . $branches[$i]['branch'] . "</td>
                                        <td>
                                            <input type='hidden' class='branchedit-id' name='branchedit-id' value='". $branches[$i]['branch_id'] ."'/>
                                            <button class='h5 brancheditbtn'><i class='fas fa-edit'></i></button>
                                            <button class='h5 branchdeletebtn'><i class='fas fa-trash'></i></button>
                                        </td></tr>";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <script>
                    function showBranch(region_id) {
                        let xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById("branch-table").innerHTML = this.responseText;
                            }
                        }
                        xhr.open("GET", "getbranches.php?region_id="+region_id, true);
                        xhr.send();
                    }
                </script>
            </div>
        </div>
    </div>



     <!-- The Modal to Delete Branch -->
     <div id="myModal4" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
        <span class="close">&times;</span>
            <div class="clearfix"></div>
            <form class="jbe__deletebranch" id="jbe__deletebranch">
                <div class="jbe__error-msg4" id="jbe__error-msg4">This is an error message</div>
                <div class="jbe__success-msg4" id="jbe__success-msg4">This is a success message</div>
                <div class="form-group">
                    <label for="branchdelete" id="label-branchdelete">Delete Branch</label>
                    <input type="text" class="form-control branchdelete" name="branchdelete" id="branchdelete" placeholder="Branch Name" value ="<?php echo $branchInfo[0]['branch']; ?>" disabled/>
                    <input type="hidden" class="form-control branchdeleteid" name="branchdeleteid" id="branchdeleteid" value ="<?php echo $branchInfo[0]['branch_id']; ?>" required/>
                    <input type="hidden" class="form-control branchregiondeleteid" name="branchregiondeleteid" id="branchregiondeleteid" value ="<?php echo $region_id; ?>" required/>
                </div>
                <div class="form-group">
                    <button type="button" id="jbe__deletebranch-submit" class="jbe__deletebranch-submit">Delete Branch</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        // Get the modal for Adding region
        let modal4= document.getElementById("myModal4");
        
        // Get the <span> element that closes the modal
        let span4 = document.getElementsByClassName("close")[0];

        modal4.style.display = "block";

        span4.onclick = function() {
            modal4.style.display = "none";
            location.href = "index.php";
        }
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal4) {
                modal4.style.display = "none";
                location.href = "index.php";
            }
        }
    </script>
</section>
<?php
    include(SHARED_PATH . "/footer.php");
    include(SHARED_PATH . "/admin-footer.php");
?>