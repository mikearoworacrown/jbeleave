<?php
// echo $_SERVER['SCRIPT_FILENAME']; -- Absolute Path
require_once("C:/xampp/htdocs/jbeleave/class/DBController.php");

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require_once("C:/xampp/htdocs/jbeleave/vendor/autoload.php");

class Employee {
    private $db_handle;
    
    function __construct() {
        $this->db_handle = new DBController();
    }

    /**********************************************CHECK IF EMAIL OR PHONE EXIST********************************************************/
    public function isEmailExist($email_phone){
        $query = "SELECT * FROM jbe_employees WHERE email_phone = ?";
        $paramType = "s";
        $paramArray = array(
            $email_phone
        );
        $resultSet = $this->db_handle->select($query, $paramType, $paramArray);
        $count = 0;
        if(is_array($resultSet)){
            $count = count($resultSet);
        }
        if($count > 0){
            $result = true;
        }else{
            $result = false;
        }
        return $result;
    }

    /**********************************************GET EMPLOYEE FROM DATABASE********************************************************/
    public function getEmployee($username){
        if(strpos($username, " ")){
            $username = str_replace(" ","_",$username);
        }
        $query = "SELECT * FROM jbe_employees where username = ?";
        $paramType = 's';
        $paramArray = array(
            $username
        );
        $employeeRecord = $this->db_handle->select($query, $paramType, $paramArray);
        return $employeeRecord;
    }

    public function getTotalNumberOfEmployee(){
        $query = "SELECT * FROM jbe_employees WHERE NOT employeetype='admin'";
        $paramType = "";
        $paramArray = "";
        $totalNumOfEmployee  = $this->db_handle->select($query, $paramType, $paramArray);
        return count($totalNumOfEmployee);
    }

    public function getAllEmployee() {
        $query = "SELECT * FROM jbe_employees WHERE NOT employeetype='admin' ORDER BY employee_id DESC";
        $paramType = "";
        $paramArray = "";

        $allemployeeRecord = $this->db_handle->select($query, $paramType, $paramArray);
        return $allemployeeRecord;
    }

    public function getAllLeaveApplication($year) {
        $query = "SELECT jbe_employees.*, jbe_employees_leave.* FROM jbe_employees INNER JOIN jbe_employees_leave 
        on jbe_employees.employee_id = jbe_employees_leave.employee_id WHERE jbe_employees_leave.year = ? ORDER BY jbe_employees_leave.employee_leave_id DESC";

        $paramType = "s";
        $paramArray = array(
            $year
        );

        $employeeLeaveRecord = $this->db_handle->select($query, $paramType, $paramArray);
        return $employeeLeaveRecord;
    }
    
    public function getAllEmployeePlusLeaveYear($year) {
        $query = "SELECT jbe_employees.*, leave_years.* FROM jbe_employees INNER JOIN leave_years 
        on jbe_employees.employee_id = leave_years.employee_id WHERE leave_years.year = ?";
        $paramType = "s";
        $paramArray = array(
            $year
        );
        $allemployeeRecordPlusYear = $this->db_handle->select($query, $paramType, $paramArray);
        return $allemployeeRecordPlusYear;
    }

    public function getAllEmployeePlusLeaveYearByName($year, $like) {
        $query = "SELECT jbe_employees.*, leave_years.* FROM jbe_employees INNER JOIN leave_years on jbe_employees.employee_id = leave_years.employee_id
         WHERE leave_years.year = ? AND CONCAT(jbe_employees.firstname, jbe_employees.lastname, jbe_employees.email_phone) LIKE ? ORDER BY 
         jbe_employees.employee_id DESC";
 
        $likeappend = '%'.$like.'%';
        $paramType = "ss";
        $paramArray = array(
            $year,
            $likeappend
        );
        $allemployeeRecordPlusYearByName = $this->db_handle->select($query, $paramType, $paramArray);
        return $allemployeeRecordPlusYearByName;
    }
    
    public function getEmployeeByIdPlusLeaveYear($employee_id, $year, $supervisor_status, $hr_status) {
        $query = "SELECT jbe_employees.*, jbe_employees_leave.*, leave_years.* FROM jbe_employees 
        INNER JOIN jbe_employees_leave on jbe_employees.employee_id = jbe_employees_leave.employee_id 
        INNER JOIN leave_years on jbe_employees_leave.employee_id = leave_years.employee_id 
        WHERE jbe_employees.employee_id = ? AND leave_years.year = ? AND jbe_employees_leave.supervisor_status = ? 
        AND jbe_employees_leave.hr_status = ?";

        $paramType = "ssss";
        $paramArray = array(
            $employee_id,
            $year,
            $supervisor_status,
            $hr_status
        );

        $employeeRecord = $this->db_handle->select($query, $paramType, $paramArray);
        return $employeeRecord;
    }

    public function getEmployeeByIdPlusLeaveYearSpecifics($employee_id, $year, $supervisor_status, $hr_status) {
        $query = "SELECT jbe_employees.staff_id, jbe_employees.firstname, jbe_employees.lastname, jbe_employees.linemanagername,
        jbe_employees.department, jbe_employees.totalleave,jbe_employees_leave.start_date,jbe_employees_leave.end_date,
        jbe_employees_leave.resumption_date,jbe_employees_leave.noofdays,jbe_employees_leave.replacedby,jbe_employees_leave.daystaken,
        jbe_employees_leave.daysleft FROM jbe_employees 
        INNER JOIN jbe_employees_leave on jbe_employees.employee_id = jbe_employees_leave.employee_id 
        WHERE jbe_employees.employee_id = ? AND jbe_employees_leave.year = ? AND jbe_employees_leave.supervisor_status = ? 
        AND jbe_employees_leave.hr_status = ?";

        $paramType = "ssss";
        $paramArray = array(
            $employee_id,
            $year,
            $supervisor_status,
            $hr_status
        );

        $employeeRecord = $this->db_handle->select($query, $paramType, $paramArray);
        return $employeeRecord;
    }

    public function getYearReportPlusLeaveYear($year, $supervisor_status, $hr_status) {
        $query = "SELECT jbe_employees.*, jbe_employees_leave.* FROM jbe_employees INNER JOIN jbe_employees_leave 
        on jbe_employees.employee_id = jbe_employees_leave.employee_id WHERE jbe_employees_leave.year = ? 
        AND jbe_employees_leave.supervisor_status = ? AND jbe_employees_leave.hr_status = ?";

        $paramType = "sss";
        $paramArray = array(
            $year,
            $supervisor_status,
            $hr_status
        );

        $employeeRecord = $this->db_handle->select($query, $paramType, $paramArray);
        return $employeeRecord;
    }

    public function getMonthlyReportPlusLeaveYear($month, $year, $supervisor_status, $hr_status) {
        $query = "SELECT jbe_employees.*, jbe_employees_leave.* FROM jbe_employees INNER JOIN jbe_employees_leave 
        on jbe_employees.employee_id = jbe_employees_leave.employee_id WHERE jbe_employees_leave.month = ? AND jbe_employees_leave.year = ? 
        AND jbe_employees_leave.supervisor_status = ? AND jbe_employees_leave.hr_status = ?";

        $paramType = "ssss";
        $paramArray = array(
            $month,
            $year,
            $supervisor_status,
            $hr_status
        );

        $employeeRecord = $this->db_handle->select($query, $paramType, $paramArray);
        return $employeeRecord;
    }

    public function getEmployeeById($employee_id) {
        $query = "SELECT * FROM jbe_employees WHERE employee_id = ?";
        $paramType = "s";
        $paramArray = array(
            $employee_id
        );

        $employeeRecord = $this->db_handle->select($query, $paramType, $paramArray);
        return $employeeRecord;
    }

    public function getEmployeeByName($like) {
        $query = 'SELECT * FROM jbe_employees WHERE CONCAT(jbe_employees.firstname, jbe_employees.lastname, jbe_employees.email_phone) 
        LIKE ? ORDER BY employee_id DESC';

        $likeappend = '%'.$like.'%';

        $paramType = "s";
        $paramArray = array(
            $likeappend
        );

        $employeeRecord = $this->db_handle->select($query, $paramType, $paramArray);
        return $employeeRecord;
    }
    
    public function getLineManagers() {
        $query = "SELECT * FROM line_manager";
        $paramType = "";
        $paramArray = "";

        $allManager = $this->db_handle->select($query, $paramType, $paramArray);
        return $allManager;
    }

    public function getLineManagerByName($fullname){
        $query = "SELECT * FROM line_manager WHERE fullname = ?";
        $paramType = "s";
        $paramArray = array(
            $fullname
        );

        $lineManager = $this->db_handle->select($query, $paramType, $paramArray);
        return $lineManager;
    }

    public function getLineManagerByDeparment($department) {
        $query = "SELECT * FROM line_manager WHERE department = ?";
        $paramType = "s";
        $paramArray = array(
            $department
        );

        $lineManager = $this->db_handle->select($query, $paramType, $paramArray);

        if($lineManager){
            return $lineManager;
        }else {
            // $query = "SELECT * FROM line_manager WHERE CONCAT(line_manager.job_description) LIKE ?";
            // $like = "Branch";
            // $likeappend = '%'.$like.'%';
            // $paramType = "s";
            // $paramArray = array(
            //     $likeappend
            // );
            // $lineManager = $this->db_handle->select($query, $paramType, $paramArray);
            $lineManager = $this->getLineManagers();
            return $lineManager;
        }
        
    }

    public function getBranchManager() {
        $query = "SELECT * FROM line_manager WHERE CONCAT(line_manager.job_description) LIKE ?";

        $like = "Branch";
        $likeappend = '%'.$like.'%';

        $paramType = "s";
        $paramArray = array(
            $likeappend
        );

        $branchManager = $this->db_handle->select($query, $paramType, $paramArray);
        return $branchManager;
    } 

    public function getHrByName($like) {
        $query = "SELECT * FROM jbe_employees WHERE CONCAT(jbe_employees.fullname) LIKE ?";
        $likeappend = '%'.$like.'%';

        $paramType = "s";
        $paramArray = array(
            $likeappend
        );

        $hr = $this->db_handle->select($query, $paramType, $paramArray);
        return $hr;
    }

    /**********************************************LOGIN EMPLOYEE*********************************************************/
    public function loginEmployee(){
        $employeeRecord = $this->getEmployee($_SESSION["username"]);
        $loginPassword = 0;
        if (!empty($employeeRecord)) {
            if (!empty($_SESSION["password"])) {
                $password = $_SESSION["password"];
            }
            $hashedPassword = $employeeRecord[0]["password"];
            $loginPassword = 0;
            if (password_verify($password, $hashedPassword)) {
                if($employeeRecord[0]["status"] != 'active'){
                    $loginPassword = 0;
                }else {
                    $loginPassword = 1;
                }
            }
        } 
        else {
            $loginPassword = 0;
        }

        if ($loginPassword == 1) {
            $_SESSION["username"] = $employeeRecord[0]["username"];
            $_SESSION["fullname"] = $employeeRecord[0]["fullname"];
            $_SESSION["employee-id"] = $employeeRecord[0]["employee_id"];
            $_SESSION["staff-id"] = $employeeRecord[0]["staff_id"];
            $_SESSION["totalleave"] = $employeeRecord[0]["totalleave"];
            $_SESSION["employeetype"] = $employeeRecord[0]["employeetype"];
            $_SESSION["firstname"] = $employeeRecord[0]["firstname"];
            $_SESSION["lastname"] = $employeeRecord[0]["lastname"];
            $_SESSION["department"] = $employeeRecord[0]["department"];
            $_SESSION['linemanageremail'] = $employeeRecord[0]["linemanageremail"];
            $_SESSION['linemanagername'] = $employeeRecord[0]["linemanagername"];
            if(isset($_SESSION['employee-id']) && isset($_SESSION["employeetype"]))
            {
                if ($_SESSION["employeetype"] == "user"){
                    $loginStatus = "user";
                } else if ($_SESSION["employeetype"] == "supervisor") {
                    $loginStatus = "supervisor";
                }else if ($_SESSION["employeetype"] == "hr") {
                    $loginStatus = "hr";
                }else if ($_SESSION["employeetype"] == "management") {
                    $loginStatus = "management";
                }else if ($_SESSION["employeetype"] == "admin") {
                    $loginStatus = "admin";
                }
                return $loginStatus;
            }
        } 
        else if ($loginPassword == 0) {
            $loginStatus = "Invalid username or password in Employee.php";
            return $loginStatus;
        }else {
            $loginStatus = "Something went wrong";
            return $loginStatus;
        }
    }

/**********************************************REGISTER EMPLOYEE*********************************************************/
    public function registerEmployee()
    {
        $isEmailExist = $this->isEmailExist($_POST['email-phone']);
        if ($isEmailExist) 
        {
            $response = array(
                "status" => "error",
                "message" => "Email/phone number already exists."
            );
        } 
        else
        {
            if (!empty($_POST['password'])) {
                // PHP's password_hash is the best choice to use to store passwords
                // do not attempt to do your own encryption, it is not safe
                $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }
            $fullname = $_POST['firstname'] . " " . $_POST['lastname'];
            $username = $_POST['firstname'] . "_" . $_POST['lastname'];

            $query = 'INSERT INTO jbe_employees (firstname, lastname, fullname, username, password, email_phone, department, staff_id, job_description, branch, region, 
             linemanagername, linemanageremail, totalleave) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $paramType = 'ssssssssssssss';
            $paramValue = array(
                $_POST['firstname'],
                $_POST['lastname'],
                $fullname,
                $username,
                $hashedPassword,
                $_POST['email-phone'],
                $_POST['department'],
                $_POST['employee-no'],
                $_POST['job-title'],
                $_POST['branch'],
                $_POST['region'],
                $_POST['line-manager'],
                $_POST['manager-email'],
                $_POST['total-leave']
            );
            $employeeId = $this->db_handle->insert($query, $paramType, $paramValue);

            if (!empty($employeeId)) {
                $year = date("Y");
                $daystaken = 0;
                $daysleft = $_POST['total-leave'];
                
                $query = 'INSERT INTO leave_years (employee_id, year, totalleave, daystaken, daysleft)
                VALUES (?, ?, ?, ?, ?)';

                $paramType = 'sssss';
                $paramValue = array(
                    $employeeId,
                    $year,
                    $_POST['total-leave'],
                    $daystaken,
                    $daysleft
                );
                $leaveId = $this->db_handle->insert($query, $paramType, $paramValue);
                
                if(!empty($leaveId)){
                    $response = array(
                        "status" => "success",
                        "message" => "Employee registered successfully."
                    );
                }                
            }
        }
         return $response;
    }

    public function lineManagerExist($username) {
        $query = "SELECT * FROM line_manager WHERE username = ?";
        $paramType = "s";
        $paramArray = array(
            $username
        );
        $resultSet = $this->db_handle->select($query, $paramType, $paramArray);
        $count = 0;
        if(is_array($resultSet)){
            $count = count($resultSet);
        }
        if($count > 0){
            $result = true;
        }else{
            $result = false;
        }
        return $result;
    }

    public function updateEmployeeRecord() {
        if($_SESSION['database-email_phone'] !== $_POST['email-phone']){
            $isEmailExist = $this->isEmailExist($_POST['email-phone']);
            if ($isEmailExist) 
            {
                $response = array(
                    "status" => "error",
                    "message" => "Email already exists."
                );
            }
        }else{
            $query = 'UPDATE jbe_employees SET firstname = ?, lastname = ?, fullname = ?, username = ?, email_phone = ?, staff_id = ?, department = ?, employeetype = ?, job_description = ?, branch = ?, 
            linemanagername = ?, linemanageremail = ?, totalleave = ?, status = ?  WHERE employee_id = ?';
            $fullname = $_POST['firstname'] . " " . $_POST['lastname'];
            $username = $_POST['firstname'] . "_" . $_POST['lastname'];
            $paramType = 'ssssssssssssssi';
            $paramValue = array(
                $_POST['firstname'],
                $_POST['lastname'],
                $fullname,
                $username,
                $_POST['email-phone'],
                $_POST['employee-no'],
                $_POST['department'],
                $_POST['employee-type'],
                $_POST['job-description'],
                $_POST['branch'],
                $_POST['line-manager'],
                $_POST['line-manage-email'],
                $_POST['total-leave'],
                $_POST['employee-status'],
                $_POST['employee_id']
            );

            $this->db_handle->update($query, $paramType, $paramValue);

            if($_POST['employee-type'] == "supervisor" || $_POST['employee-type'] == "management"){
                $line_manager = $this->lineManagerExist($username);
                if(!$line_manager){
                    $query = 'INSERT INTO line_manager (employee_id, fullname, username, email, department, job_description, employeetype)
                    VALUES (?, ?, ?, ?, ?, ?, ?)';

                    $paramType = 'issssss';
                    $paramValue = array (
                        $_POST['employee_id'],
                        $fullname,
                        $username,
                        $_POST['email-phone'],
                        $_POST['department'],
                        $_POST['job-description'],
                        $_POST['employee-type']
                    );
                    $linManagerId = $this->db_handle->insert($query, $paramType, $paramValue);
                }
            }else if($_POST['employee-type'] == "hr" || $_POST['employee-type'] == "user"){
                $line_manager = $this->lineManagerExist($username);
                if($line_manager){
                    $query = 'DELETE FROM line_manager WHERE username = ?';
                    $paramType = "s";
                    $paramValue = array(
                        $username
                    );
                    $this->db_handle->delete($query, $paramType, $paramValue);
                }
            }
            $_SESSION['update-message'] = $_POST['firstname'] . " Employee Record Updated Succesfully";
            $response = array(
                "status" => "success",
                "message" => "Successfully Updated."
            );
        }

        return $response;
        
    }

    /**********************************************GET LEAVE YEAR RECORD*********************************************************/
    public function getEmployeeYearRecord($employee_id, $year){
        $query = "SELECT jbe_employees.employee_id, leave_years.* FROM jbe_employees INNER JOIN 
        leave_years ON jbe_employees.employee_id = leave_years.employee_id WHERE leave_years.employee_id = ? AND year = ?";
        
        $paramType = 'ss';
        $paramArray = array(
            $employee_id,
            $year
        );
        $employeeYearRecord = $this->db_handle->select($query, $paramType, $paramArray); 
        return $employeeYearRecord;
    }


    /**********************************************GET DEPARTMENT BASED ON DEPARTMENT ID*********************************************************/
    public function getDepartment($department_id) {
        $query = "SELECT * FROM departments WHERE department_id = ?";

        $paramType = "s";
        $paramArray = array(
            $department_id
        );

        $department = $this->db_handle->select($query, $paramType, $paramArray);
        return $department;
    }

    /**********************************************GET ALL DEPARTMENT*********************************************************/
    public function getDepartments() {
        $query = "SELECT * FROM departments";

        $paramType = "";
        $paramArray = "";

        $allDepartments = $this->db_handle->select($query, $paramType, $paramArray);
        return $allDepartments;
    }

    /**********************************************GET REGION BASED ON REGION ID*********************************************************/
    public function getRegion($region_id) {
        $query = "SELECT * FROM regions WHERE region_id = ?";

        $paramType = "s";
        $paramArray = array(
            $region_id
        );

        $region = $this->db_handle->select($query, $paramType, $paramArray);
        return $region;
    }

    /**********************************************GET ALL REGION*********************************************************/
    public function getRegions() {
        $query = "SELECT * FROM regions";

        $paramType = "";
        $paramArray = "";

        $allRegions = $this->db_handle->select($query, $paramType, $paramArray);
        return $allRegions;
    }

    /**********************************************GET BRANCH BASED OF BRANCH ID*********************************************************/
    public function getBranch($branch_id) {
        $query = "SELECT * FROM branches WHERE branch_id = ?";

        $paramType = "s";
        $paramArray = array(
            $branch_id
        );

        $branch = $this->db_handle->select($query, $paramType, $paramArray);
        return $branch;
    }

    public function getEmployeeBranch() {
        $query = "SELECT * FROM branches";

        $paramType = "";
        $paramArray = "";

        $branch = $this->db_handle->select($query, $paramType, $paramArray);
        return $branch;
    }

    /**********************************************GET ALL BRANCHES BASED ON REGION ID*********************************************************/
    public function getBranches($region_id) {
        $query = "SELECT * FROM branches WHERE region_id = ?";

        $paramType = "s";
        $paramArray = array(
            $region_id
        );

        $allBranches = $this->db_handle->select($query, $paramType, $paramArray);
        return $allBranches;
    }

    /*******************************************************GET LEAVE YEARS*************************************************/
    public function getYears() {
        $query = "SELECT DISTINCT year FROM leave_years";

        $paramType = "";
        $paramArray = "";

        $dbYears = $this->db_handle->select($query, $paramType, $paramArray);
        return $dbYears;
    }

    public function getLeaveYears($employee_id){
        $query = "SELECT year FROM leave_years WHERE employee_id = ?";

        $paramType = "s";
        $paramArray = array(
            $employee_id
        );

        $leaveYears = $this->db_handle->select($query, $paramType, $paramArray);
        return $leaveYears;

    }

    public function getLeaveApplied($year) {
        $query = "SELECT * FROM jbe_employees_leave WHERE year = ?";

        $paramType = "s";
        $paramArray = array(
            $year
        );

        $appliedLeave = $this->db_handle->select($query, $paramType, $paramArray);
        return $appliedLeave;
    }
    
    /**********************************************APPLY FOR LEAVE*********************************************************/
    public function applyforleave() {
        $getYearRecord = $this->getEmployeeYearRecord($_SESSION["employee-id"], $_POST["leave-year"]);

        $_SESSION['daystaken'] = $getYearRecord[0]['daystaken'];
        $_SESSION['daysleft'] = $getYearRecord[0]['daysleft'];

        $month = date('m', strtotime($_POST["leave-commencing"]));

        $query = 'INSERT INTO jbe_employees_leave (employee_id, staff_id, totalleave, daystaken, daysleft, start_date, end_date, noofdays, resumption_date, year, month, replacedby, leavetype) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $paramType = 'sssssssssssss';
        $paramValue = array(
            $_SESSION["employee-id"],
            $_SESSION["staff-id"],
            $_SESSION["totalleave"],
            $_SESSION["daystaken"],
            $_SESSION["daysleft"],
            $_POST["leave-commencing"],
            $_SESSION['endDate'],
            $_SESSION['noofdays'],
            $_POST["leave-resumption"],
            $_POST["leave-year"],
            $month,
            $_POST["leave-replace"],
            $_POST['leave-type']
        );

        $employeeLeaveId = $this->db_handle->insert($query, $paramType, $paramValue);
        if(!empty($employeeLeaveId)) {
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'mail.qualisbusinesssupport.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'jbetest@qualisbusinesssupport.com';                     //SMTP username
                $mail->Password   = 'K3l3shamm@';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('jbetest@qualisbusinesssupport.com', 'Leave Application - Jubailibros Engineering');
                // $mail->AddAddress($_SESSION["linemanageremail"], $_SESSION["linemanagername"]);	
                $mail->AddAddress("Ayoaro85@gmail.com", "Ayodele Aroworade"); 

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Leave Application - '. $_SESSION['firstname'] . ' ' . $_SESSION['lastname']; 
                $content = '<div style="background-color: white; padding: 5px;">
                <h5 style="font-size: 1.25rem">Dear ' .  $_SESSION['linemanagername'] . '</h5>
                <h6 style="font-size: 1rem">Kindly Approve <span style="color:#091281">' . $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] . '</span> Leave Application </h6>
                <a style="font-size: 1rem" style="padding-top: 1px;" href="http://localhost/jbeleave/public/">Click on link for rediection</a>
                <h6 style="font-size: 1rem">Best Regards</h6>
                </div>';
                $mail->MsgHTML($content);
                // $mail->Body    = 'Dear ' . $_SESSION['linemanagername'] . ' Kindly head to your Porter and Approve ' . $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] . ' Leave Application.' . ' Best Regards';

                $mail->send();
                $_SESSION['message'] = "Leave Application Sent to your Supervisor";
                $response = array(
                    "status" => "success",
                    "message" => $_SESSION['message']
                );
            } catch (Exception $e) {
                $_SESSION['message'] = "Message could not be sent. Updated Regardless";
                $response = array(
                    "status" => "error",
                    "message" => $_SESSION['message']
                );
            }
           
        }else{
            $_SESSION['message'] = "Something Went Wrong";
            $response = array(
                "status" => "error",
                "message" => $_SESSION['message']
            );
            
        }
        return $response;
    }

    public function updateTeamLeave($team_employee_id, $team_employee_leave_id, $supervisor_status){
        $teamLeaveRecord = $this->getEmployeeLeaveRecord($team_employee_leave_id, $team_employee_id, "Pending");
        $hr_name = "Ugoh Akongwubel";
        $hr = $this->getHrByName($hr_name);

        $hr_fullname = $hr[0]['fullname'];
        $hr_email = $hr[0]['email_phone'];
        $firstname = $teamLeaveRecord[0]['firstname'];
        $lastname = $teamLeaveRecord[0]['lastname'];
        $employee_fullname = $firstname . " " . $lastname;
        $employee_email = $teamLeaveRecord[0]['email_phone'];

        if($_SESSION['team-leave-status'] == "Pending"){
            $query = "UPDATE jbe_employees_leave SET replacedby = ?, supervisor_status = ? WHERE employee_id = ? AND employee_leave_id = ?";
           
            $paramType = "ssii";
            $paramArray = array(
                $_SESSION['team-leave-replaceby'],
                $_SESSION['team-leave-status'],
                $team_employee_id,
                $team_employee_leave_id
            );

            $this->db_handle->update($query, $paramType, $paramArray);

            $_SESSION['message'] = "Team Record Updated!";
            $response = array(
                "status" => "success",
                "message" => $_SESSION['message']
            );
            
            return $response;  
        }else if ($_SESSION['team-leave-status'] == "Declined") {
            $query = "UPDATE jbe_employees_leave SET replacedby = ?, supervisor_status = ? WHERE employee_id = ? AND employee_leave_id = ?";
           
            $paramType = "ssii";
            $paramArray = array(
                $_SESSION['team-leave-replaceby'],
                $_SESSION['team-leave-status'],
                $team_employee_id,
                $team_employee_leave_id
            );

            $this->db_handle->update($query, $paramType, $paramArray);

            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'mail.qualisbusinesssupport.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'jbetest@qualisbusinesssupport.com';                     //SMTP username
                $mail->Password   = 'K3l3shamm@';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('jbetest@qualisbusinesssupport.com', 'Leave Application - Jubailibros Engineering');
                $mail->AddAddress("Ayoaro85@gmail.com", "Mike");	
                // $mail->AddAddress($employee_email, $employee_fullname); 

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Leave Application - '. $employee_fullname; 
                $content = '<div style="background-color: white; padding: 5px;">
                <h5 style="font-size: 1.25rem">Dear '. $employee_fullname .'</h5>
                <h6 style="font-size: 1rem">Your Leave Application have been declined</h6>
                <a style="font-size: 1rem" style="padding-top: 1px;" href="http://localhost/jbeleave/public/">Click on link for rediection</a>
                <h6 style="font-size: 1rem">Best Regards</h6>
                </div>';
                $mail->MsgHTML($content);
                // $mail->Body    = 'Dear ' . $_SESSION['linemanagername'] . ' Kindly head to your Porter and Approve ' . $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] . ' Leave Application.' . ' Best Regards';

                $mail->send();
                $_SESSION['message'] = $employee_fullname . " Leave Application Sent to HR";
                $response = array(
                    "status" => "success",
                    "message" => $_SESSION['message']
                );
            } catch (Exception $e) {
                $_SESSION['message'] = "Message could not be sent. Updated Regardless";
                $response = array(
                    "status" => "error",
                    "message" => $_SESSION['message']
                );
            }
            return $response;
             
        }
        else if($_SESSION['team-leave-status'] == "Approved" ){
            if (isset($_SESSION['team-leave-enddate']) && isset($_SESSION['team-leave-noofdays'])){
                $month = date('m', strtotime($_SESSION['team-leave-startdate']));
                $query = "UPDATE jbe_employees_leave SET start_date = ?, month = ?, resumption_date = ?, end_date = ?, noofdays = ?, replacedby = ?, supervisor_status = ? 
                WHERE employee_id = ? AND employee_leave_id = ?";
    
                $paramType = "sssssssii";
                $paramArray = array(
                    $_SESSION['team-leave-startdate'],
                    $month,
                    $_SESSION['team-leave-resumption'],
                    $_SESSION['team-leave-enddate'],
                    $_SESSION['team-leave-noofdays'],
                    $_SESSION['team-leave-replaceby'],
                    $_SESSION['team-leave-status'],
                    $team_employee_id,
                    $team_employee_leave_id
                );
    
                $this->db_handle->update($query, $paramType, $paramArray);
            }else{
                $query = "UPDATE jbe_employees_leave SET start_date = ?, resumption_date = ?, replacedby = ?, supervisor_status = ? 
                WHERE employee_id = ? AND employee_leave_id = ?";

                $paramType = "ssssii";
                $paramArray = array(
                    $_SESSION['team-leave-startdate'],
                    $_SESSION['team-leave-resumption'],
                    $_SESSION['team-leave-replaceby'],
                    $_SESSION['team-leave-status'],
                    $team_employee_id,
                    $team_employee_leave_id
                );

                $this->db_handle->update($query, $paramType, $paramArray);
            }
            
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'mail.qualisbusinesssupport.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'jbetest@qualisbusinesssupport.com';                     //SMTP username
                $mail->Password   = 'K3l3shamm@';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('jbetest@qualisbusinesssupport.com', 'Leave Application - Jubailibros Engineering');
                $mail->AddAddress("Ayoaro85@gmail.com", "Personnel VI");	
                // $mail->AddAddress($hr_email, $hr_fullname); 

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Leave Application - '. $employee_fullname; 
                $content = '<div style="background-color: white; padding: 5px;">
                <h5 style="font-size: 1.25rem">Dear '. $hr_fullname .'</h5>
                <h6 style="font-size: 1rem">Kindly find <span style="color:#091281">' . $employee_fullname . '</span> Leave Application </h6>
                <a style="font-size: 1rem" style="padding-top: 1px;" href="http://localhost/jbeleave/public/">Click on link for rediection</a>
                <h6 style="font-size: 1rem">Best Regards</h6>
                </div>';
                $mail->MsgHTML($content);
                // $mail->Body    = 'Dear ' . $_SESSION['linemanagername'] . ' Kindly head to your Porter and Approve ' . $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] . ' Leave Application.' . ' Best Regards';

                $mail->send();
                $_SESSION['message'] = $employee_fullname . " Leave Application Sent to HR";
                $response = array(
                    "status" => "success",
                    "message" => $_SESSION['message']
                );
            } catch (Exception $e) {
                $_SESSION['message'] = "Message could not be sent. Updated Regardless";
                $response = array(
                    "status" => "error",
                    "message" => $_SESSION['message']
                );
            }
            return $response;            
        }

    }

    public function getTotalNumberOfGrantedLeave(){
        $query = 'SELECT * FROM jbe_employees_leave';
        $paramType = "";
        $paramArray = "";
        $totalNumOfGrantedLeave  = $this->db_handle->select($query, $paramType, $paramArray);
        return count($totalNumOfGrantedLeave);
    }

    public function getApprovedLeaveApplication($supervisor_status, $hr_status) {
        $query = 'SELECT jbe_employees.firstname, jbe_employees.lastname, jbe_employees.email_phone, jbe_employees.department, jbe_employees.branch, jbe_employees_leave.* FROM jbe_employees 
        INNER JOIN jbe_employees_leave ON jbe_employees.employee_id = jbe_employees_leave.employee_id WHERE jbe_employees_leave.supervisor_status = ? 
        AND jbe_employees_leave.hr_status = ? ORDER BY employee_leave_id DESC lIMIT 10';

        $paramType = 'ss';
        $paramArray = array (
            $supervisor_status,
            $hr_status
        );

        $approvedLeaveApplication = $this->db_handle->select($query, $paramType, $paramArray);
        return $approvedLeaveApplication;
    }

    public function getBMApprovedLeaveApplication($bm_status){
        $query = 'SELECT jbe_employees.firstname, jbe_employees.lastname, jbe_employees.email_phone, jbe_employees.department, jbe_employees.branch, jbe_employees_leave.* FROM jbe_employees 
        INNER JOIN jbe_employees_leave ON jbe_employees.employee_id = jbe_employees_leave.employee_id WHERE jbe_employees_leave.bm_status = ? ORDER BY employee_leave_id DESC';

        $paramType = 's';
        $paramArray = array (
            $bm_status
        );

        $approvedLeaveApplication = $this->db_handle->select($query, $paramType, $paramArray);
        return $approvedLeaveApplication;
    }

    public function getBMApprovedLeaveApplicationByYear($year){
        $bm_status = "Approved";
        $query = 'SELECT jbe_employees.*, jbe_employees_leave.* FROM jbe_employees INNER JOIN jbe_employees_leave 
        ON jbe_employees.employee_id = jbe_employees_leave.employee_id WHERE jbe_employees_leave.bm_status = ? 
        AND jbe_employees_leave.year = ? ORDER BY employee_leave_id DESC';

        $paramType = 'ss';
        $paramArray = array (
            $bm_status,
            $year
        );

        $approvedLeaveApplication = $this->db_handle->select($query, $paramType, $paramArray);
        return $approvedLeaveApplication;
    }

    public function getAllPendingLeaveByYear($year){
        $query = 'SELECT jbe_employees.*, jbe_employees_leave.* FROM jbe_employees INNER JOIN jbe_employees_leave 
        ON jbe_employees.employee_id = jbe_employees_leave.employee_id WHERE 
        (jbe_employees_leave.supervisor_status = "Pending" AND jbe_employees_leave.hr_status = "Pending" AND jbe_employees_leave.bm_status = "Pending") 
        OR (jbe_employees_leave.supervisor_status = "Approved" AND jbe_employees_leave.hr_status = "Pending" AND jbe_employees_leave.bm_status = "Pending") 
        OR (jbe_employees_leave.supervisor_status = "Approved" AND jbe_employees_leave.hr_status = "Approved" AND jbe_employees_leave.bm_status = "Pending") 
        AND jbe_employees_leave.year = ? ORDER BY employee_leave_id DESC';

        $paramType = 's';
        $paramArray = array (
            $year
        );

        $pendingLeaveApplication = $this->db_handle->select($query, $paramType, $paramArray);
        return $pendingLeaveApplication;
    }

    public function  getAllDeclinedLeaveByYear($year){
        $bm_status = "Declined";
        $hr_status = "Declined";
        $supervisor_status = "Declined";
        $query = 'SELECT jbe_employees.*, jbe_employees_leave.* FROM jbe_employees INNER JOIN jbe_employees_leave 
        ON jbe_employees.employee_id = jbe_employees_leave.employee_id WHERE jbe_employees_leave.supervisor_status = ? OR jbe_employees_leave.hr_status = ?
        OR jbe_employees_leave.bm_status = ? AND jbe_employees_leave.year = ? ORDER BY employee_leave_id DESC';

        $paramType = 'ssss';
        $paramArray = array (
            $supervisor_status,
            $hr_status,
            $bm_status,
            $year
        );

        $pendingLeaveApplication = $this->db_handle->select($query, $paramType, $paramArray);
        return $pendingLeaveApplication;
    }

    public function getApprovedLeaveApplicationLike($supervisor_status, $hr_status, $like) {
        $query = 'SELECT jbe_employees.firstname, jbe_employees.lastname, jbe_employees.email_phone, jbe_employees.department, jbe_employees.branch, jbe_employees_leave.* FROM jbe_employees 
        INNER JOIN jbe_employees_leave ON jbe_employees.employee_id = jbe_employees_leave.employee_id WHERE jbe_employees_leave.supervisor_status = ? 
        AND jbe_employees_leave.hr_status = ? AND CONCAT(jbe_employees.firstname, jbe_employees.lastname, jbe_employees.email_phone) LIKE ? ORDER BY employee_leave_id DESC';

        $likeappend = '%'.$like.'%';

        $paramType = 'sss';
        $paramArray = array (
            $supervisor_status,
            $hr_status,
            $likeappend
        );

        $approvedLeaveApplicationLike = $this->db_handle->select($query, $paramType, $paramArray);
        return $approvedLeaveApplicationLike;
    }

    public function getBMApprovedLeaveApplicationLike($bm_status, $like){
        $query = 'SELECT jbe_employees.firstname, jbe_employees.lastname, jbe_employees.email_phone, jbe_employees.department, jbe_employees.branch, jbe_employees_leave.* FROM jbe_employees 
        INNER JOIN jbe_employees_leave ON jbe_employees.employee_id = jbe_employees_leave.employee_id WHERE jbe_employees_leave.bm_status = ? AND CONCAT(jbe_employees.firstname, jbe_employees.lastname, jbe_employees.email_phone) LIKE ? ORDER BY employee_leave_id DESC';

        $likeappend = '%'.$like.'%';

        $paramType = 'ss';
        $paramArray = array (
            $bm_status,
            $likeappend
        );

        $approvedLeaveApplicationLike = $this->db_handle->select($query, $paramType, $paramArray);
        return $approvedLeaveApplicationLike;
    }

    public function getAllHRApprovedApplication($supervisor_status, $hr_status, $bm_status){
        $query = 'SELECT jbe_employees.firstname, jbe_employees.lastname, jbe_employees.fullname, jbe_employees.email_phone, 
        jbe_employees.department, jbe_employees.branch, jbe_employees_leave.* FROM jbe_employees 
        INNER JOIN jbe_employees_leave ON jbe_employees.employee_id = jbe_employees_leave.employee_id 
        WHERE jbe_employees_leave.supervisor_status = ? AND jbe_employees_leave.hr_status = ? AND jbe_employees_leave.bm_status = ? ORDER BY employee_leave_id';

        $paramType = "sss";
        $paramValue = array(
            $supervisor_status, 
            $hr_status,
            $bm_status
        );

        $allapprovedleave = $this->db_handle->select($query, $paramType, $paramValue);
        return $allapprovedleave;
    }

    public function getHRApprovedApplicationById($employee_id, $employee_leave_id) {
        $query = 'SELECT jbe_employees.firstname, jbe_employees.lastname, jbe_employees.fullname, jbe_employees.email_phone, 
        jbe_employees.department, jbe_employees.branch, jbe_employees_leave.* FROM jbe_employees INNER JOIN jbe_employees_leave 
        ON jbe_employees.employee_id = jbe_employees_leave.employee_id WHERE jbe_employees_leave.employee_id = ? AND 
        jbe_employees_leave.employee_leave_id = ?';

        $paramType = "ii";
        $paramValue = array(
            $employee_id, 
            $employee_leave_id
        );

        $hrapprovedleave = $this->db_handle->select($query, $paramType, $paramValue);
        return $hrapprovedleave;
    }

    public function updateEmployeeLeave($employee_id, $employee_leave_id, $hr_status) {
        $supervisor_status = "Approved";
        $employeeLeaveRecord = $this->getEmployeeLeaveRecord($employee_leave_id, $employee_id, $supervisor_status);
        $branchManager = $this->getBranchManager();

        $bm_fullname = $branchManager[0]['fullname'];
        $bm_email = $branchManager[0]['email'];
        $hr_fullname = $_SESSION["fullname"];
        $firstname = $employeeLeaveRecord[0]['firstname'];
        $lastname = $employeeLeaveRecord[0]['lastname'];
        $employee_fullname = $firstname . " " . $lastname;
        $employee_email = $employeeLeaveRecord[0]['email_phone'];

        if($hr_status == "Pending"){
            $query = "UPDATE jbe_employees_leave SET hr_status = ? WHERE employee_id = ? AND employee_leave_id = ?";
            $paramType = "sii";
            $paramArray = array(
                $_POST['leave-status'],
                $_POST["process-employeeid"],
                $_POST["process-leave-employeeid"]
            );

            $this->db_handle->update($query, $paramType, $paramArray);

            $_SESSION['message'] = "Employee Record Updated!";
            $response = array(
                "status" => "success",
                "message" => $_SESSION['message']
            );
            
            return $response;  
        }else if ($hr_status == "Declined"){
            $query = "UPDATE jbe_employees_leave SET hr_status = ? WHERE employee_id = ? AND employee_leave_id = ?";
            $paramType = "sii";
            $paramArray = array(
                $_POST['leave-status'],
                $_POST["process-employeeid"],
                $_POST["process-leave-employeeid"]
            );
            $this->db_handle->update($query, $paramType, $paramArray);

             //Create an instance; passing `true` enables exceptions
             $mail = new PHPMailer(true);

             try {
                 //Server settings
                 // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                 $mail->isSMTP();                                            //Send using SMTP
                 $mail->Host       = 'mail.qualisbusinesssupport.com';                     //Set the SMTP server to send through
                 $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                 $mail->Username   = 'jbetest@qualisbusinesssupport.com';                     //SMTP username
                 $mail->Password   = 'K3l3shamm@';                               //SMTP password
                 $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                 $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
 
                 //Recipients
                 $mail->setFrom('jbetest@qualisbusinesssupport.com', 'Leave Application - Jubailibros Engineering');	
                 $mail->AddAddress($employee_email, $employee_fullname); 
 
                 //Content
                 $mail->isHTML(true);                                  //Set email format to HTML
                 $mail->Subject = 'Leave Application - '. $employee_fullname; 
                 $content = '<div style="background-color: white; padding: 2px;">
                 <h5 style="font-size: 1.25rem">Dear ' . $employee_fullname . '</h5>
                 <h6 style="font-size: 1rem"> Your Leave Request Have Been Declined. Kindly check your porter for more information.</h6>
                 <a style="font-size: 1rem" href="http://localhost/jbeleave">Click on link for rediection</a>
                 <h6 style="font-size: 1rem">Best Regards</h6>
                 </div>';
                 $mail->MsgHTML($content);
 
                 $mail->send();
                 $_SESSION['message'] =  $firstname . " " . $lastname . " Leave Application have been processed Successfully.";
                 $response = array(
                     "status" => "success",
                     "message" => $_SESSION['message']
                 );
             } catch (Exception $e) {
                 $_SESSION['message'] = "Message could not be sent. " . $employee_fullname . " Record Updated Regardless";
                 $response = array(
                     "status" => "error",
                     "message" => $_SESSION['message']
                 );
             }
             return $response; 
        }else if($hr_status == "Approved") {
            $query = "UPDATE jbe_employees_leave SET hr_status = ? WHERE employee_id = ? AND employee_leave_id = ?";
            $paramType = "sii";
            $paramArray = array(
                $_POST['leave-status'],
                $_POST["process-employeeid"],
                $_POST["process-leave-employeeid"]
            );
            $this->db_handle->update($query, $paramType, $paramArray);

            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'mail.qualisbusinesssupport.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'jbetest@qualisbusinesssupport.com';                     //SMTP username
                $mail->Password   = 'K3l3shamm@';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('jbetest@qualisbusinesssupport.com', 'Leave Application - Jubailibros Engineering');
                $mail->AddAddress("Ayoaro85@gmail.com", "Mohammad Farhat");	
                // $mail->AddAddress($bm_email, $bm_fullname); 

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Leave Application - '. $employee_fullname; 
                $content = '<div style="background-color: white; padding: 2px;">
                <h5 style="font-size: 1.25rem">Dear ' . $bm_fullname . '</h5>
                <h6 style="font-size: 1rem">Kindly Approve '. $employee_fullname .' Leave Application</h6>
                <a style="font-size: 1rem" href="http://localhost/jbeleave/">Click on link for rediection</a>
                <h6 style="font-size: 1rem">Best Regards</h6>
                </div>';
                $mail->MsgHTML($content);

                $mail->send();
                $_SESSION['message'] = $employee_fullname . " Leave Application have been processed Successfully.";
                $response = array(
                    "status" => "success",
                    "message" => $_SESSION['message']
                );
            } catch (Exception $e) {
                $_SESSION['message'] = "Message could not be sent. " . $employee_fullname . " Record Updated Regardless";
                $response = array(
                    "status" => "error",
                    "message" => $_SESSION['message']
                );
            }
            return $response;
        }
    }

    public function approveEmployeeLeave($employee_id, $employee_leave_id, $bm_status){
        $employeeLeaveDetail = $this->getHRApprovedApplicationById($employee_id, $employee_leave_id);
        $employee_fullname = $employeeLeaveDetail[0]["fullname"];
        $employee_email = $employeeLeaveDetail[0]["email_phone"];

        if($bm_status == "Pending"){
            $query = "UPDATE jbe_employees_leave SET bm_status = ? WHERE employee_id = ? AND employee_leave_id = ?";
            $paramType = "sii";
            $paramArray = array(
                $bm_status,
                $employee_id,
                $employee_leave_id
            );
            $this->db_handle->update($query, $paramType, $paramArray);

            $_SESSION['message'] = "Employee Record Updated!";
            $response = array(
                "status" => "success",
                "message" => $_SESSION['message']
            );
            
            return $response;  
        }else if ($bm_status == "Declined"){
            $query = "UPDATE jbe_employees_leave SET bm_status = ? WHERE employee_id = ? AND employee_leave_id = ?";
            $paramType = "sii";
            $paramArray = array(
                $bm_status,
                $employee_id,
                $employee_leave_id
            );
            $this->db_handle->update($query, $paramType, $paramArray);

             //Create an instance; passing `true` enables exceptions
             $mail = new PHPMailer(true);

             try {
                 //Server settings
                 // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                 $mail->isSMTP();                                            //Send using SMTP
                 $mail->Host       = 'mail.qualisbusinesssupport.com';                     //Set the SMTP server to send through
                 $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                 $mail->Username   = 'jbetest@qualisbusinesssupport.com';                     //SMTP username
                 $mail->Password   = 'K3l3shamm@';                               //SMTP password
                 $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                 $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
 
                 //Recipients
                 $mail->setFrom('jbetest@qualisbusinesssupport.com', 'Leave Application - Jubailibros Engineering');	
                 $mail->AddAddress($employee_email, $employee_fullname); 
 
                 //Content
                 $mail->isHTML(true);                                  //Set email format to HTML
                 $mail->Subject = 'Leave Application - '. $employee_fullname; 
                 $content = '<div style="background-color: white; padding: 2px;">
                 <h5 style="font-size: 1.25rem">Dear ' . $employee_fullname . '</h5>
                 <h6 style="font-size: 1rem"> Your Leave Request Have Been Declined. Kindly check your porter for more information.</h6>
                 <a style="font-size: 1rem" href="http://localhost/jbeleave">Click on link for rediection</a>
                 <h6 style="font-size: 1rem">Best Regards</h6>
                 </div>';
                 $mail->MsgHTML($content);
 
                 $mail->send();
                 $_SESSION['message'] =  $employee_fullname . " Leave Application have been processed Successfully.";
                 $response = array(
                     "status" => "success",
                     "message" => $_SESSION['message']
                 );
             } catch (Exception $e) {
                 $_SESSION['message'] = "Message could not be sent. " . $employee_fullname . " Record Updated Regardless";
                 $response = array(
                     "status" => "error",
                     "message" => $_SESSION['message']
                 );

                 return $response; 
             }
        }else if ($bm_status == "Approved"){
            $totalleave = $employeeLeaveDetail[0]['totalleave'];
            $daystaken = $employeeLeaveDetail[0]['daystaken'] + $employeeLeaveDetail[0]['noofdays'];
            $daysleft = $totalleave - $daystaken;
            $year = $_POST["approve-leave-year"];

            $query = "UPDATE leave_years SET daystaken = ?, daysleft = ? WHERE employee_id = ? AND year = ?";
            $paramType = "iiis";
            $paramArray = array(
                $daystaken,
                $daysleft,
                $employee_id,
                $year
            );
            $this->db_handle->update($query, $paramType, $paramArray);
            
            $query = "UPDATE jbe_employees_leave SET daystaken = ?, daysleft = ?, bm_status = ? WHERE employee_id = ? AND employee_leave_id = ?";

            $paramType = "iisii";
            $paramArray = array(
                $daystaken,
                $daysleft,
                $bm_status,
                $employee_id,
                $employee_leave_id
            );

            $this->db_handle->update($query, $paramType, $paramArray);
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'mail.qualisbusinesssupport.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'jbetest@qualisbusinesssupport.com';                     //SMTP username
                $mail->Password   = 'K3l3shamm@';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('jbetest@qualisbusinesssupport.com', 'Leave Application - Jubailibros Engineering');
                // $mail->AddAddress("Ayoaro85@gmail.com", "Ugoh Akongwubel");	
                $mail->AddAddress($employee_email, $employee_fullname); 

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Leave Application - '. $employee_fullname; 
                $content = '<div style="background-color: white; padding: 2px;">
                <h5 style="font-size: 1.25rem">Dear ' . $employee_fullname . '</h5>
                <h6 style="font-size: 1rem"> Your Leave Request Have Been Approved And Processeed. Kindly check your porter for more information.</h6>
                <a style="font-size: 1rem" href="http://localhost/jbeleave/">Click on link for rediection</a>
                <h6 style="font-size: 1rem">Best Regards</h6>
                </div>';
                $mail->MsgHTML($content);

                $mail->send();
                $_SESSION['message'] = $employee_fullname . " Leave Application have been processed Successfully.";
                $response = array(
                    "status" => "success",
                    "message" => $_SESSION['message']
                );
            } catch (Exception $e) {
                $_SESSION['message'] = "Message could not be sent. " . $employee_fullname . " Record Updated Regardless";
                $response = array(
                    "status" => "error",
                    "message" => $_SESSION['message']
                );
            }
            return $response;
        }
    }

    public function getleaveapplication($employee_id, $year){
        $query = 'SELECT * FROM jbe_employees_leave WHERE employee_id = ? AND year = ? ORDER BY employee_leave_id DESC';
        
        $paramType = 'ss';
        $paramArray = array (
            $employee_id,
            $year
        );

        $leaveapplication = $this->db_handle->select($query, $paramType, $paramArray);
        return $leaveapplication;
    }


    public function getAllTeam($department, $employeetype){
        $query = 'SELECT * FROM jbe_employees WHERE department = ? AND employeetype = ?';

        $paramType = 'ss';
        $paramArray = array (
            $department,
            $employeetype
        );

        $allTeam = $this->db_handle->select($query, $paramType, $paramArray);
        return $allTeam;
    }

    public function getAllTeamApplication($department, $employeetype, $supervisor_status) {
        $query = 'SELECT jbe_employees.employee_id, jbe_employees.firstname, jbe_employees.lastname, jbe_employees_leave.* FROM jbe_employees 
        INNER JOIN jbe_employees_leave ON jbe_employees.employee_id = jbe_employees_leave.employee_id WHERE 
        jbe_employees.department = ? AND jbe_employees.employeetype = ? AND jbe_employees_leave.supervisor_status = ?';

        $paramType = 'sss';
        $paramArray = array (
            $department,
            $employeetype,
            $supervisor_status
        );

        $teamApplication = $this->db_handle->select($query, $paramType, $paramArray);
        return $teamApplication;
    }

    public function getAllSubordinateApplication($line_manager, $supervisor_status) {
        $query = 'SELECT jbe_employees.employee_id, jbe_employees.firstname, jbe_employees.lastname, jbe_employees_leave.* FROM jbe_employees 
        INNER JOIN jbe_employees_leave ON jbe_employees.employee_id = jbe_employees_leave.employee_id WHERE 
        jbe_employees.linemanagername = ? AND jbe_employees_leave.supervisor_status = ?';

        $paramType = 'ss';
        $paramArray = array (
            $line_manager,
            $supervisor_status
        );

        $subordinateApplication = $this->db_handle->select($query, $paramType, $paramArray);
        return $subordinateApplication;
    }

    public function getTeamLeaveRecord($department, $employeetype, $year) {
        $query = 'SELECT jbe_employees.*, leave_years.* FROM jbe_employees INNER JOIN leave_years ON jbe_employees.employee_id = leave_years.employee_id 
        WHERE jbe_employees.department = ? AND jbe_employees.employeetype = ? AND leave_years.year = ?';

        $paramType = 'sss';
        $paramArray = array (
            $department,
            $employeetype,
            $year
        );

        $teamLeaveRecord = $this->db_handle->select($query, $paramType, $paramArray);
        return $teamLeaveRecord;
    }

    public function getSubordinateLeaveRecord($line_manager, $year){
        $query = 'SELECT jbe_employees.*, leave_years.* FROM jbe_employees INNER JOIN leave_years ON jbe_employees.employee_id = leave_years.employee_id 
        WHERE jbe_employees.linemanagername = ? AND leave_years.year = ?';
        
        $paramType = 'ss';
        $paramArray = array (
            $line_manager,
            $year
        );

        $subordinateLeaveRecord = $this->db_handle->select($query, $paramType, $paramArray);
        return $subordinateLeaveRecord;
    }

    public function getAllEmployeeLeaveRecord($year) {
        $query = 'SELECT jbe_employees.*, leave_years.* FROM jbe_employees INNER JOIN leave_years ON jbe_employees.employee_id = leave_years.employee_id 
        WHERE leave_years.year = ?';
        
        $paramType = 's';
        $paramArray = array (
            $year
        );

        $subordinateLeaveRecord = $this->db_handle->select($query, $paramType, $paramArray);
        return $subordinateLeaveRecord;
    }

    public function getEmployeeLeaveRecord($employee_leave_id, $employee_id, $supervisor_status) {
        $query = 'SELECT jbe_employees.firstname, jbe_employees.lastname, jbe_employees.email_phone, jbe_employees.branch, jbe_employees.department, jbe_employees_leave.* FROM jbe_employees 
        INNER JOIN jbe_employees_leave ON jbe_employees.employee_id = jbe_employees_leave.employee_id WHERE jbe_employees.employee_id = ? 
        AND jbe_employees_leave.employee_leave_id = ? AND jbe_employees_leave.supervisor_status = ?';

        $paramType = 'sss';
        $paramArray = array (
            $employee_id,
            $employee_leave_id,
            $supervisor_status
        );

        $employeeLeaveDetail = $this->db_handle->select($query, $paramType, $paramArray);
        return $employeeLeaveDetail;
    }

    public function printedGrantedLeave($employee_id, $employee_leave_id){
        $query = 'SELECT jbe_employees.firstname, jbe_employees.lastname, jbe_employees.email_phone, jbe_employees.branch, jbe_employees.department, jbe_employees_leave.* FROM jbe_employees 
        INNER JOIN jbe_employees_leave ON jbe_employees.employee_id = jbe_employees_leave.employee_id WHERE jbe_employees.employee_id = ? 
        AND jbe_employees_leave.employee_leave_id = ?';

        $paramType = 'ii';
        $paramArray = array (
            $employee_id,
            $employee_leave_id
        );

        $printForm = $this->db_handle->select($query, $paramType, $paramArray);
        return $printForm;
    }


    public function isRegionExist($region){
        $query = "SELECT * FROM regions WHERE region = ?";
        $paramType = "s";
        $paramArray = array(
            $region
        );
        $resultSet = $this->db_handle->select($query, $paramType, $paramArray);
        $count = 0;
        if(is_array($resultSet)){
            $count = count($resultSet);
        }
        if($count > 0){
            $result = true;
        }else{
            $result = false;
        }
        return $result;
    }

    public function addRegion($region) {
        $isRegionExist = $this->isRegionExist($region);
        if ($isRegionExist) 
        {
            $response = array(
                "status" => "error",
                "message" => "Region already exists."
            );
        } 
        else
        {
            $query = 'INSERT INTO regions (region, region_slug) VALUES (?, ?)';
            $region_slug = strtolower($region);
            $region_slug = str_replace(" ","_",$region_slug);
            $paramType = 'ss';
            $paramValue = array(
                $region,
                $region_slug
            );
            $regionId = $this->db_handle->insert($query, $paramType, $paramValue);

            if(!empty($regionId)){
                $response = array(
                    "status" => "success",
                    "message" => "Region Added successfully."
                );
            }
        }
        return $response;
    }

    public function updateRegion($region_id, $region) {
        $query = 'UPDATE regions SET region = ?, region_slug = ? WHERE region_id = ?';

        $region_slug = strtolower($region);
        $region_slug = str_replace(" ","_",$region_slug);
        $paramType = 'sss';
        $paramValue = array(
            $region,
            $region_slug,
            $region_id,
        );
        $this->db_handle->update($query, $paramType, $paramValue);

        $response = array(
            "status" => "success",
            "message" => "Region Updated successfully."
        );

        return $response;
    }

    public function deleteRegion($region_id) {
        // $branches = $this->getBranches($region_id);
        $query = 'DELETE FROM branches WHERE region_id = ?';
        $paramType = 's';
        $paramValue = array(
            $region_id
        );
        $this->db_handle->delete($query, $paramType, $paramValue);

        $query = 'DELETE FROM regions WHERE region_id = ?';
        $paramType = 's';
        $paramValue = array(
            $region_id
        );
        $this->db_handle->delete($query, $paramType, $paramValue);

        $response = array(
            "status" => "success",
            "message" => "Region Deleted successfully."
        );

        return $response;
    }

    public function isBranchExist($region_id, $branch){
        $query = "SELECT * FROM branches WHERE region_id = ? AND branch = ?";
        $paramType = "ss";
        $paramArray = array(
            $region_id,
            $branch
        );
        $resultSet = $this->db_handle->select($query, $paramType, $paramArray);
        $count = 0;
        if(is_array($resultSet)){
            $count = count($resultSet);
        }
        if($count > 0){
            $result = true;
        }else{
            $result = false;
        }
        return $result;
    }

    public function addBranch($region_id, $branch){
        $isBranchExist = $this->isBranchExist($region_id, $branch);
        if ($isBranchExist) 
        {
            $response = array(
                "status" => "error",
                "message" => "Branch already exists."
            );
        } 
        else
        {
            $query = 'INSERT INTO branches (branch, region_id, branch_slug) VALUES (?, ?, ?)';
            $branch_slug = strtolower($branch);
            $branch_slug = str_replace(" ","_",$branch_slug);
            $paramType = 'sis';
            $paramValue = array(
                $branch,
                $region_id,
                $branch_slug
            );
            $regionId = $this->db_handle->insert($query, $paramType, $paramValue);

            if(!empty($regionId)){
                $response = array(
                    "status" => "success",
                    "message" => "Branch Added successfully."
                );
            }
        }
        return $response;
    }

    public function updateBranch($branch_id, $branch) {
        $query = 'UPDATE branches SET branch = ?, branch_slug = ? WHERE branch_id = ?';

        $branch_slug = strtolower($branch);
        $branch_slug = str_replace(" ","_",$branch_slug);
        $paramType = 'sss';
        $paramValue = array(
            $branch,
            $branch_slug,
            $branch_id,
        );
        $this->db_handle->update($query, $paramType, $paramValue);

        $response = array(
            "status" => "success",
            "message" => "Branch Updated successfully."
        );

        return $response;
    }

    public function deleteBranch($branch_id) {
        $query = 'DELETE FROM branches WHERE branch_id = ?';
        $paramType = 's';
        $paramValue = array(
            $branch_id
        );
        $this->db_handle->delete($query, $paramType, $paramValue);

        $response = array(
            "status" => "success",
            "message" => "Branch Deleted successfully."
        );

        return $response;
    }

    
    public function updateDepartment($department_id, $department) {
        $isDepartmentExist = $this->isDepartmentExist($department);
        if ($isDepartmentExist) 
        {
            $response = array(
                "status" => "error",
                "message" => "Department already exists."
            );
        } 
        else
        {
            $query = 'UPDATE departments SET department = ?, department_slug = ? WHERE department_id = ?';

            $department_slug = strtolower($department);
            $department_slug = str_replace(" ","_",$department_slug);
            $paramType = 'sss';
            $paramValue = array(
                $department,
                $department_slug,
                $department_id,
            );
            $this->db_handle->update($query, $paramType, $paramValue);

            $response = array(
                "status" => "success",
                "message" => "Department Updated successfully."
            );
        }

        return $response;
    }

    public function deleteDepartment($department_id) {
        $query = 'DELETE FROM departments WHERE department_id = ?';
        $paramType = 's';
        $paramValue = array(
            $department_id
        );
        $this->db_handle->delete($query, $paramType, $paramValue);

        $response = array(
            "status" => "success",
            "message" => "Department Deleted successfully."
        );

        return $response;
    }
    
    public function isDepartmentExist($department){
        $query = "SELECT * FROM departments WHERE department = ?";
        $paramType = "s";
        $paramArray = array(
            $department
        );
        $resultSet = $this->db_handle->select($query, $paramType, $paramArray);
        $count = 0;
        if(is_array($resultSet)){
            $count = count($resultSet);
        }
        if($count > 0){
            $result = true;
        }else{
            $result = false;
        }
        return $result;
    }

    public function addDepartment($department) {
        $isDepartmentExist = $this->isDepartmentExist($department);
        if ($isDepartmentExist) 
        {
            $response = array(
                "status" => "error",
                "message" => "Department already exists."
            );
        } 
        else
        {
            $query = 'INSERT INTO departments (department, department_slug) VALUES (?, ?)';
            $department_slug = strtolower($department);
            $department_slug = str_replace(" ","_",$department_slug);
            $paramType = 'ss';
            $paramValue = array(
                $department,
                $department_slug
            );
            $departmentId = $this->db_handle->insert($query, $paramType, $paramValue);

            if(!empty($departmentId )){
                $response = array(
                    "status" => "success",
                    "message" => "Department Added successfully."
                );
            }
        }
        return $response;
    }

}

?>