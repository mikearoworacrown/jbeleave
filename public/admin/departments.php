<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . "/class/Employee.php");

    $employee = new Employee();
    $page_title = "departments";
    if(!isset($_SESSION['username']) || $_SESSION['employeetype'] != 'admin'){
        header('Location: ../');
        exit();
    }
    
    include(SHARED_PATH . "/admin-header.php");

    $departments = $employee->getDepartments();
    $lineManagers = $employee-> getLineManagers();
?>
<style>
    .jbe__mainbar{
        position: absolute;
        left: 300px;
        padding: 15px 0;
        width: calc(100% - 320px);
    }

    .departmenteditbtn {
        color: var(--primary-color);
        cursor: pointer;
    }
    .departmentdeletebtn{
        color: var(--color-danger);
        cursor: pointer;
    }
</style>

<section class="jbe__mainbar">
    <div class="jbe__homepage-welcome">
        <div>
            <h5 class="display-4 jbe__general-header-h5 mb-3">Departments</h5>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="jbe__region" style="overflow: auto;">
                <div class="jbe__homepage-welcome">
                    <h5 class="jbe__general-header-h5">All Departments</h5>
                    <a id="btn-department" class="h6 button">Add Department</a>
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
                                if(!empty($departments)){
                                    for($i = 0; $i < count($departments); $i++){
                                        echo "<tr><th scope='row'>" . $i+1 . "</th>
                                        <td>" . $departments[$i]['department'] . "</td>
                                        <td>
                                            <input type='hidden' class='departmentedit-id' name='departmentedit-id' value='". $departments[$i]['department_id'] ."'/>
                                            <button class='h5 departmenteditbtn'><i class='fas fa-edit'></i></button>
                                            <button class='h5 departmentdeletebtn'><i class='fas fa-trash'></i></button>
                                        </td></tr>";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>  //Script to Edit department-------------------------------------------------------------------------
            let departmentEditButton = document.querySelectorAll(".departmenteditbtn");
            let departmentEditId = document.querySelectorAll(".departmentedit-id");

            // console.log(departmentEditButton.length);

            for(let i = 0; i < departmentEditButton.length; i++){
                departmentEditButton[i].addEventListener('click', function(){
                    let toSend = {
                        departmentEditId: departmentEditId[i].value
                    }
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "departmentajax.php", true);
                    xhr.onload = () => {
                        if(xhr.readyState === XMLHttpRequest.DONE){
                            if(xhr.status === 200){
                                let data = xhr.response;
                                let dataParsed = JSON.parse(data);
                                console.log(dataParsed);
                                let modal = document.getElementById("myModal");
                                var span = document.getElementsByClassName("close")[0];
                                var inputDepartment = document.getElementById('departmentedit');
                                var inputDepartmentId = document.getElementById('departmenteditid');
                                inputDepartment.value = dataParsed[0]["department"];
                                inputDepartmentId.value = dataParsed[0]["department_id"];

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
            //End of Script to department Region--------------------------------------------------------------
        </script> 

        <script>  //Script to Delete department-------------------------------------------------------------------------
            let departmentDeleteButton = document.querySelectorAll(".departmentdeletebtn");
            let departmentDeleteId = document.querySelectorAll(".departmentedit-id");

            // console.log(departmentDeleteButton.length);

            for(let i = 0; i < departmentDeleteButton.length; i++){
                departmentDeleteButton[i].addEventListener('click', function(){
                    let toSend = {
                        departmentEditId: departmentDeleteId[i].value // Left it as regionEdit to use one ajax file for both edit and delete
                    }
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "departmentajax.php", true);
                    xhr.onload = () => {
                        if(xhr.readyState === XMLHttpRequest.DONE){
                            if(xhr.status === 200){
                                let data = xhr.response;
                                let dataParsed = JSON.parse(data);
                                console.log(dataParsed);
                                let modal2 = document.getElementById("myModal2");
                                var span2 = document.getElementsByClassName("close")[2];
                                var inputdepartment = document.getElementById('departmentdelete');
                                var inputdepartmentId = document.getElementById('departmentdeleteid');
                                inputdepartment.value = dataParsed[0]["department"];
                                inputdepartmentId.value = dataParsed[0]["department_id"];

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
            //End of Script to Delete department--------------------------------------------------------------
        </script> 


        <div class="col-md-6">
            <div class="jbe__branch" style="overflow: auto;">
                <div class="jbe__homepage-welcome">
                <h5 class="jbe__general-header-h5">Line Managers</h5>
                </div>
                <div id="branch-table">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" width="4%">S/N</th>
                                <th scope="col">Line Manager</th>
                                <th scope="col">Job Description</th>
                                <th scope="col">Email Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(!empty($lineManagers)){
                                    for($i = 0; $i < count($lineManagers); $i++){
                                        echo "<tr><th scope='row'>" . $i+1 . "</th>
                                        <td>" . $lineManagers[$i]['fullname'] . "</td>
                                        <td>" . $lineManagers[$i]['job_description'] . "</td>
                                        <td>" . $lineManagers[$i]['email'] . "</td></tr>";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- The Modal to Edit Department -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
    <span class="close">&times;</span>
        <div class="clearfix"></div>
        <form class="jbe__editdepartment" id="jbe__editdepartment">
            <div class="jbe__error-msg" id="jbe__error-msg">This is an error message</div>
            <div class="jbe__success-msg" id="jbe__success-msg">This is a success message</div>
            <div class="form-group">
                <label for="departmentedit" id="label-departmentedit">Edit Region Name<span class="jbe__required jbe__error" id="departmentedit-info"></span></label>
                <input type="text" class="form-control departmentedit" name="departmentedit" id="departmentedit" placeholder="Region Name" value ="" required/>
                <input type="hidden" class="form-control departmenteditid" name="departmenteditid" id="departmenteditid" value ="" required/>
            </div>
            <div class="form-group">
                <button type="button" id="jbe__editdepartment-submit" class="jbe__editdepartment-submit">Update Department</button>
            </div>
        </form>
    </div>
</div>

<!-- The Modal to add department-->
<div id="myModal1" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
    <span class="close">&times;</span>
        <div class="clearfix"></div>
        <form class="jbe__adddepartment" id="jbe__adddepartment" action="" autocomplete="off">
            <div class="jbe__error-msg1" id="jbe__error-msg1">This is an error message</div>
            <div class="jbe__success-msg1" id="jbe__success-msg1">This is a success message</div>
            <div class="form-group">
                <label for="department" id="label-department">Department Name<span class="jbe__required jbe__error" id="department-info"></span></label>
                <input type="text" class="form-control department" name="department" id="department" placeholder="Department Name" value ="" required/>
            </div>
            <div class="form-group">
                <button type="submit" id="jbe__adddepartment-submit" class="jbe__adddepartment-submit" name="jbe__adddepartment-submit">Add Department</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Get the modal
    var modal1 = document.getElementById("myModal1");
    // Get the button that opens the modal
    var btnDepartment = document.getElementById("btn-department");
    // Get the <span> element that closes the modal
    var span1 = document.getElementsByClassName("close")[1];
    // When the user clicks on the button, open the modal
    btnDepartment.onclick = function() {
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
            <form class="jbe__deletedepartment" id="jbe__deletedepartment">
                <div class="jbe__error-msg2" id="jbe__error-msg2">This is an error message</div>
                <div class="jbe__success-msg2" id="jbe__success-msg2">This is a success message</div>
                <div class="form-group">
                    <label for="departmentdelete" id="label-departmentdelete">Delete Department</label>
                    <input type="text" class="form-control departmentdelete" name="departmentdelete" id="departmentdelete" placeholder="Department Name" value ="" disabled/>
                    <input type="hidden" class="form-control departmentdeleteid" name="departmentdeleteid" id="departmentdeleteid" value ="" required/>
                </div>
                <div class="form-group">
                    <button type="button" id="jbe__deletedepartment-submit" class="jbe__deletedepartment-submit">Delete Department</button>
                </div>
            </form>
        </div>
    </div>


<?php
    include(SHARED_PATH . "/footer.php");
    include(SHARED_PATH . "/admin-footer.php");
?>