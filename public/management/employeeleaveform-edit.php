<?php 
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . "/class/Employee.php");

    $page_title = "Edit User Leave Form";

    if(!isset($_SESSION['username']) || $_SESSION['employeetype'] != 'management'){
        header('Location: ../');
        exit();
    }

    $employee = new Employee();

    $employee_id = $_GET['employee_id'];
    $employee_leave_id = $_GET['employee_leave_id'];
    $today = date('d/m/Y');

    $employeeLeaveDetail = $employee->getHRApprovedApplicationById($employee_id, $employee_leave_id);

    if(empty($employeeLeaveDetail)){
        header('Location: ../');
        exit();
    }

    include(SHARED_PATH . "/header.php");
?>


<section class="jbe__container-fluid jbe__request-form">
    <div class="jbe__container">
        <div class="jbe__request-form-h4">
            <div class="line1"></div>
            <h4>Leave Request Form - Locals</h4>
            <div class="line2"></div>
        </div>
        <form action="" method="post" class="approveleave-request-form">
            <div class="row leaveform-row1">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="leave-name">Name: </label>
                        <input type="hidden" name="approve-employeeid" value="<?php echo $employee_id; ?>"/>
                        <input type="hidden" name="approve-leave-employeeid" value="<?php echo $employee_leave_id; ?>"/>
                        <input type="text" class="form-control" name="leave-name" id="leave-name" value="<?php echo $employeeLeaveDetail[0]['firstname'] . " " . $employeeLeaveDetail[0]['lastname']?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="leave-department">Department: </label>
                        <input type="text" class="form-control" name="leave-department" id="leave-department" value="<?php echo $employeeLeaveDetail[0]['department']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="leave-branch">Branch: </label>
                        <input type="text" class="form-control" name="leave-branch" id="leave-branch" value="<?php echo $employeeLeaveDetail[0]['branch']; ?>" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="leave-employeeid">Employee ID: </label>
                        <input type="text" class="form-control" name="leave-employeeid" id="leave-employeeid" value="<?php echo $employeeLeaveDetail[0]['staff_id']; ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="leave-year">Leave Year: <span class="jbe__required jbe__error daysleft" id="daysleft"><?php echo $employeeLeaveDetail[0]['daysleft']; ?></span><span class="jbe__required"> day(s) left</span></label>
                        <input type="text" class="form-control" name="leave-year" id="leave-year" value="<?php echo $employeeLeaveDetail[0]['year']; ?>" disabled>
                        <input type="hidden" name="approve-leave-year" value="<?php echo $employeeLeaveDetail[0]['year']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="leave-date">Date: </label>
                        <input type="text" class="form-control" name="leave-date" id="leave-date" value="<?php echo $today; ?>" disabled>
                    </div>
                </div>
            </div>

            <div class="row leaveform-row2">
                <div class="leave-type">
                    <h4 class="mb-5">Leave Type</h4>
                </div>
                
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="leave-type" id="leave-type1" value="Annual Leave" checked disabled>
                        <label class="form-check-label" for="leave-type1">
                            Annual Leave
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="leave-type" id="leave-type2" value="Casual Leave" disabled>
                        <label class="form-check-label" for="leave-type2">
                            Casual Leave
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="leave-type" id="leave-type3" value="Sick Leave" disabled>
                        <label class="form-check-label" for="leave-type3">
                            Sick Leave
                        </label>
                    </div>
                </div>

                <div class="col-md-6 pb-5">
                     <div class="form-check">
                        <input class="form-check-input" type="radio" name="leave-type" id="leave-type4" value="Leave Without Pay" disabled>
                        <label class="form-check-label" for="leave-type4">
                            Leave Without Pay
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input mt-3" type="radio" name="leave-type" id="leave-type5" value="Other: " disabled>
                        <label class="form-check-label" for="leave-type5">
                            Other <input type="text" class="form-control mt-1 ms-1" name="leave-type-other" id="leave-type-other" placeholder="Identify Reason" disabled>
                        </label>
                    </div>
                </div>

                <hr />

                <div class="col-md-6 pt-5">
                    <div class="form-group">
                        <label for="leave-commencing">Commencing Date: <span class="jbe__required jbe__error date-error"></span></label>
                        <input type="text" class="form-control leave-commencing" name="leave-commencing" id="datepicker1" value="<?php echo $employeeLeaveDetail[0]['start_date']; ?>" required disabled>
                    </div>
                    <div class="form-group">
                        <label for="leave-resumption">Resumption Date: <span class="jbe__required jbe__error"></span></label>
                        <input type="text" class="form-control leave-resumption" name="leave-resumption" id="datepicker3" value="<?php echo $employeeLeaveDetail[0]['resumption_date']; ?>" required disabled>
                    </div>
                    <div class="form-group">
                        <label for="leave-ending">Ending Date: <span class="jbe__required jbe__error"></span></label>
                        <input type="text" class="form-control leave-ending" name="leave-ending" id="datepicker2" value="<?php echo $employeeLeaveDetail[0]['end_date']; ?>" disabled>
                    </div>
                </div>  

                <div class="col-md-6 pt-5">
                    <div class="form-group">
                        <label for="leave-replace">To be Replaced By: <span class="jbe__required jbe__error"></span></label>
                        <input type="text" class="form-control" name="leave-replace" id="leave-replace" value="<?php echo $employeeLeaveDetail[0]['replacedby']; ?>" required disabled>
                    </div>
                    <div class="form-group">
                        <label for="leave-status">Status: <span class="jbe__required jbe__error"></span></label>
                        <select class="form-select" name="approve-leave-status" id="leave-status" style="color:#ffc107;" required>
                            <option value="Pending" style="color:#ffc107;" selected>Pending</option>
                            <option value="Approved" style="color:green">Approved</option>
                            <option value="Declined" style="color:red">Declined</option>
                        </select>
                        <script>
                            let select = document.querySelector('#leave-status');
                            select.onchange = () => {
                                if(select.value == "Pending") {
                                    select.style.color = "#ffc107";
                                }else if(select.value == "Approved"){
                                    select.style.color = "#198754";
                                }else if(select.value == "Declined"){
                                    select.style.color = "#D0312D";
                                }
                            }
                        </script>
                    </div>
                    <div class="form-group">
                        <label for="leave-noofdays">Number of days: <span class="jbe__required jbe__error daysleft1"><?php echo $employeeLeaveDetail[0]['daysleft'] . " "; ?> days left</span></label>
                        <input type="text" class="form-control leave-noofdays" name="leave-noofdays" id="leave-noofdays" value="<?php echo $employeeLeaveDetail[0]['noofdays']; ?>"  disabled>
                    </div>
                </div>
            </div>
            <div class="loader"></div>
            <button type="submit" class="jbe__approveLeave-submit" id="jbe__approveLeave-submit">Approve Leave Application</button>
        </form>
    </div>
</section>


<?php
    include(SHARED_PATH . "/footer.php");
?>