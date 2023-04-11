<?php
    $year = "2023";
    $region_id = 1;
    $regions = $employee->getRegions();
    $branches = $employee->getBranches($region_id);
    $department = $employee->getDepartments();
    $allEmployee = $employee->getAllEmployee();
    $leaveApplied = $employee->getLeaveApplied($year);
    $leaveApproved = $employee->getBMApprovedLeaveApplicationByYear($year);
    $leaveDeclined = $employee->getAllDeclinedLeaveByYear($year);
    $leavePending = $employee->getAllPendingLeaveByYear($year);
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
            <h4 class="display-6" style="font-weight: 500;"></h4>
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
        <script>  //Script to Edit Region-------------------------------------------------------------------------
            let regionEditButton = document.querySelectorAll(".regioneditbtn");
            let regionEditId = document.querySelectorAll(".regionedit-id");

            //console.log(regionEditButton.length);

            for(let i = 0; i < regionEditButton.length; i++){
                regionEditButton[i].addEventListener('click', function(){
                    let toSend = {
                        regionEditId: regionEditId[i].value
                    }
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "regionajax.php", true);
                    xhr.onload = () => {
                        if(xhr.readyState === XMLHttpRequest.DONE){
                            if(xhr.status === 200){
                                let data = xhr.response;
                                let dataParsed = JSON.parse(data);
                                console.log(dataParsed);
                                let modal = document.getElementById("myModal");
                                var span = document.getElementsByClassName("close")[0];
                                var inputRegion = document.getElementById('regionedit');
                                var inputRegionId = document.getElementById('regioneditid');
                                inputRegion.value = dataParsed[0]["region"];
                                inputRegionId.value = dataParsed[0]["region_id"];

                                modal.style.display = "block";
                                span.onclick = function() {
                                    modal.style.display = "none";
                                    location.reload();
                                }
                                // When the user clicks anywhere outside of the modal, close it
                                window.onclick = function(event) {
                                    if (event.target == modal) {
                                        modal.style.display = "none";
                                        location.reload();
                                    }
                                }
                            }
                        }
                    }
                    let toSendId = JSON.stringify(toSend);
                    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                    xhr.send(toSendId);
                })
            }
            //End of Script to edit Region--------------------------------------------------------------
        </script> 

        <script>  //Script to Delete Region-------------------------------------------------------------------------
            let regionDeleteButton = document.querySelectorAll(".regiondeletebtn");
            let regionDeleteId = document.querySelectorAll(".regionedit-id");

            // console.log(regionDeleteButton.length);

            for(let i = 0; i < regionDeleteButton.length; i++){
                regionDeleteButton[i].addEventListener('click', function(){
                    let toSend = {
                        regionEditId: regionDeleteId[i].value // Left it as regionEdit to use one ajax file for both edit and delete
                    }
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "regionajax.php", true);
                    xhr.onload = () => {
                        if(xhr.readyState === XMLHttpRequest.DONE){
                            if(xhr.status === 200){
                                let data = xhr.response;
                                let dataParsed = JSON.parse(data);
                                console.log(dataParsed);
                                let modal2 = document.getElementById("myModal2");
                                var span2 = document.getElementsByClassName("close")[2];
                                var inputRegion = document.getElementById('regiondelete');
                                var inputRegionId = document.getElementById('regiondeleteid');
                                inputRegion.value = dataParsed[0]["region"];
                                inputRegionId.value = dataParsed[0]["region_id"];

                                modal2.style.display = "block";
                                span2.onclick = function() {
                                    modal2.style.display = "none";
                                    location.reload();
                                }
                                // When the user clicks anywhere outside of the modal, close it
                                window.onclick = function(event) {
                                    if (event.target == modal2) {
                                        modal2.style.display = "none";
                                        location.reload();
                                    }
                                }
                            }
                        }
                    }
                    let toSendId = JSON.stringify(toSend);
                    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                    xhr.send(toSendId);
                })
            }
            //End of Script to Delete Region--------------------------------------------------------------
        </script> 


        <!--------------------------------------- Branch Table ------------------------------------------------->
        <div class="col-md-6">
            <div class="jbe__branch" style="overflow: auto;">
                <div class="jbe__homepage-welcome">
                    <select class="form-select region-select" name="region_id" onchange="showBranch(this.value)">
                        <?php
                            for($i = 0; $i < count($regions); $i++){?>
                                <option value='<?php echo $regions[$i]["region_id"];?>'><?php echo $regions[$i]["region"]?></option>
                        <?php } ?>
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

    <script>  //Script to Edit Branch Name -------------------------------------------------------------------------
        let branchEditButton = document.querySelectorAll(".brancheditbtn");
        let branchEditId = document.querySelectorAll(".branchedit-id");

        // console.log(branchEditButton.length);
        // console.log(branchEditId);

        for(let i = 0; i < branchEditButton.length; i++){
            branchEditButton[i].addEventListener('click', function(){
                let toSend = {
                    branchEditId: branchEditId[i].value
                }
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "branchajax.php", true);
                xhr.onload = () => {
                    if(xhr.readyState === XMLHttpRequest.DONE){
                        if(xhr.status === 200){
                            let data = xhr.response;
                            let dataParsed = JSON.parse(data);
                            console.log(dataParsed);
                            let modal3 = document.getElementById("myModal3");
                            var span3 = document.getElementsByClassName("close")[3];
                            var inputBranch = document.getElementById('branchedit');
                            var inputBranchId = document.getElementById('brancheditid');
                            var inputRegionId =document.getElementById('branchregioneditid');
                            inputBranch.value = dataParsed[0]["branch"];
                            inputBranchId.value = dataParsed[0]["branch_id"];
                            inputRegionId.value = dataParsed[0]["region_id"];

                            modal3.style.display = "block";
                            span3.onclick = function() {
                                modal3.style.display = "none";
                                location.reload();
                            }
                            // When the user clicks anywhere outside of the modal, close it
                            window.onclick = function(event) {
                                if (event.target == modal3) {
                                    modal3.style.display = "none";
                                    location.reload();
                                }
                            }
                        }
                    }
                }
                let toSendId = JSON.stringify(toSend);
                xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                xhr.send(toSendId);
            })
        }
        //End of Script to edit Region--------------------------------------------------------------
    </script> 

    <script>  //Script to Delete Branch -------------------------------------------------------------------------
        let branchDeleteButton = document.querySelectorAll(".branchdeletebtn");
        let branchDeleteId = document.querySelectorAll(".branchedit-id");

        // console.log(branchDeleteButton.length);
        // console.log(branchDeleteId);

        for(let i = 0; i < branchDeleteButton.length; i++){
            branchDeleteButton[i].addEventListener('click', function(){
                let toSend = {
                    branchEditId: branchDeleteId[i].value
                }
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "branchajax.php", true);
                xhr.onload = () => {
                    if(xhr.readyState === XMLHttpRequest.DONE){
                        if(xhr.status === 200){
                            let data = xhr.response;
                            let dataParsed = JSON.parse(data);
                            console.log(dataParsed);
                            let modal4 = document.getElementById("myModal4");
                            var span4 = document.getElementsByClassName("close")[4];
                            var inputBranch = document.getElementById('branchdelete');
                            var inputBranchId = document.getElementById('branchdeleteid');
                            var inputRegionId =document.getElementById('branchregiondeleteid');
                            inputBranch.value = dataParsed[0]["branch"];
                            inputBranchId.value = dataParsed[0]["branch_id"];
                            inputRegionId.value = dataParsed[0]["region_id"];

                            modal4.style.display = "block";
                            span4.onclick = function() {
                                modal4.style.display = "none";
                                location.reload();
                            }
                            // When the user clicks anywhere outside of the modal, close it
                            window.onclick = function(event) {
                                if (event.target == modal4) {
                                    modal4.style.display = "none";
                                    location.reload();
                                }
                            }
                        }
                    }
                }
                let toSendId = JSON.stringify(toSend);
                xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                xhr.send(toSendId);
            })
        }
        //End of Script to edit Region--------------------------------------------------------------
    </script> 



    <!-- The Modal to Edit Region -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
        <span class="close">&times;</span>
            <div class="clearfix"></div>
            <form class="jbe__editregion" id="jbe__editregion">
                <div class="jbe__error-msg" id="jbe__error-msg">This is an error message</div>
                <div class="jbe__success-msg" id="jbe__success-msg">This is a success message</div>
                <div class="form-group">
                    <label for="regionedit" id="label-regionedit">Edit Region Name<span class="jbe__required jbe__error" id="regionedit-info"></span></label>
                    <input type="text" class="form-control regionedit" name="regionedit" id="regionedit" placeholder="Region Name" value ="" required/>
                    <input type="hidden" class="form-control regioneditid" name="regioneditid" id="regioneditid" value ="" required/>
                </div>
                <div class="form-group">
                    <button type="button" id="jbe__editregion-submit" class="jbe__editregion-submit" name="jbe__editregion-submit">Update Region</button>
                </div>
            </form>
        </div>
    </div>

    <!-- The Modal to Add Region-->
    <div id="myModal1" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
        <span class="close">&times;</span>
            <div class="clearfix"></div>
            <form class="jbe__addregion" id="jbe__addregion">
                <div class="jbe__error-msg1" id="jbe__error-msg1">This is an error message</div>
                <div class="jbe__success-msg1" id="jbe__success-msg1">This is a success message</div>
                <div class="form-group">
                    <label for="regionadd" id="label-regionadd">Region Name<span class="jbe__required jbe__error" id="regionadd-info"></span></label>
                    <input type="text" class="form-control regionadd" name="regionadd" id="regionadd" placeholder="Region Name" value ="" required/>
                </div>
                <div class="form-group">
                    <button type="button" id="jbe__addregion-submit" class="jbe__addregion-submit" name="jbe__addregion-submit">Add Region</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Get the modal for Adding region
        let modal1= document.getElementById("myModal1");
        // Get the button that opens the modal
        let btnRegion = document.getElementById("btn-region");
        // Get the <span> element that closes the modal
        let span1 = document.getElementsByClassName("close")[1];
        // When the user clicks on the button, open the modal
        btnRegion.onclick = function() {
            modal1.style.display = "block";
        }
        // When the user clicks on <span> (x), close the modal
        span1.onclick = function() {
            modal1.style.display = "none";
            location.reload();
        }
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal1) {
                modal1.style.display = "none";
                location.reload();
            }
        }
    </script>


    <!-- The Modal to Delete Region -->
    <div id="myModal2" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
        <span class="close">&times;</span>
            <div class="clearfix"></div>
            <form class="jbe__deleteregion" id="jbe__deleteregion">
                <div class="jbe__error-msg2" id="jbe__error-msg2">This is an error message</div>
                <div class="jbe__success-msg2" id="jbe__success-msg2">This is a success message</div>
                <div class="form-group">
                    <label for="regiondelete" id="label-regiondelete">Delete Region</label>
                    <input type="text" class="form-control regiondelete" name="regiondelete" id="regiondelete" placeholder="Region Name" value ="" disabled/>
                    <input type="hidden" class="form-control regiondeleteid" name="regiondeleteid" id="regiondeleteid" value ="" required/>
                </div>
                <div class="form-group">
                    <button type="button" id="jbe__deleteregion-submit" class="jbe__deleteregion-submit">Delete Region</button>
                </div>
            </form>
        </div>
    </div>



    <!-- The Modal to Edit Branch Name -->
    <div id="myModal3" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
        <span class="close">&times;</span>
            <div class="clearfix"></div>
            <form class="jbe__editregion" id="jbe__editregion">
                <div class="jbe__error-msg3" id="jbe__error-msg3">This is an error message</div>
                <div class="jbe__success-msg3" id="jbe__success-msg3">This is a success message</div>
                <div class="form-group">
                    <label for="branchedit" id="label-branchedit">Edit Branch Name<span class="jbe__required jbe__error" id="branchedit-info"></span></label>
                    <input type="text" class="form-control branchedit" name="branchedit" id="branchedit" placeholder="Branch Name" value ="" required/>
                    <input type="hidden" class="form-control brancheditid" name="brancheditid" id="brancheditid" value ="" required/>
                    <input type="hidden" class="form-control branchregioneditid" name="branchregioneditid" id="branchregioneditid" value ="" required/>
                </div>
                <div class="form-group">
                    <button type="button" id="jbe__editbranch-submit" class="jbe__editbranch-submit">Update Branch</button>
                </div>
            </form>
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
                    <input type="text" class="form-control branchdelete" name="branchdelete" id="branchdelete" placeholder="Branch Name" value ="" disabled/>
                    <input type="hidden" class="form-control branchdeleteid" name="branchdeleteid" id="branchdeleteid" value ="" required/>
                    <input type="hidden" class="form-control branchregiondeleteid" name="branchregiondeleteid" id="branchregiondeleteid" value ="" required/>
                </div>
                <div class="form-group">
                    <button type="button" id="jbe__deletebranch-submit" class="jbe__deletebranch-submit">Delete Branch</button>
                </div>
            </form>
        </div>
    </div>


    <!-- The Modal to Add Branch -->
    <div id="myModal5" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="clearfix"></div>
            <form class="jbe__addbranch" id="jbe__addbranch" action="" autocomplete="off">
                <div class="jbe__error-msg5" id="jbe__error-msg5">This is an error message</div>
                <div class="jbe__success-msg5" id="jbe__success-msg5">This is a success message</div>
                <div class="form-group">
                    <label for="region_id" id="label-region_id">Select Region<span class="jbe__required jbe__error" id="region_id-info"></span></label>
                    <select class="form-select region-select1" name="region_id" id="region_id">
                        <?php
                            for($i = 0; $i < count($regions); $i++){?>
                                <option value='<?php echo $regions[$i]["region_id"];?>'><?php echo $regions[$i]["region"]?></option>
                        <?php } ?>
                    </select>
                    <label for="branch" id="label-branch">Branch Name<span class="jbe__required jbe__error" id="branch-info"></span></label>
                    <input type="text" class="form-control branch" name="branch" id="branch" placeholder="Branch Name" value ="" required/>
                </div>
                <div class="form-group">
                    <button type="submit" id="jbe__addbranch-submit" class="jbe__addbranch-submit" name="jbe__addbranch-submit">Add Branch</button>
                </div>
                
            </form>
        </div>
    </div>

    <!-- Script to display add branch model -->
    <script>
        // Get the modal for Adding region
        let modal5= document.getElementById("myModal5");
        // Get the button that opens the modal
        let btnbranch = document.getElementById("btn-branch");
        // Get the <span> element that closes the modal
        let span5 = document.getElementsByClassName("close")[5];
        // When the user clicks on the button, open the modal
        btnbranch.onclick = function() {
            modal5.style.display = "block";
        }
        // When the user clicks on <span> (x), close the modal
        span5.onclick = function() {
            modal5.style.display = "none";
            location.reload();
        }
        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal5) {
                modal5.style.display = "none";
                location.reload();
            }
        }
    </script>



</section>

<?php
    include(SHARED_PATH . "/admin-footer.php");
?>