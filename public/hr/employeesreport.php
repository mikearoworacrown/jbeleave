<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . "/class/Employee.php");

    $page_title = "Employee Report";

    $_SESSION['savedreportsearchvalue'] = "";

    if(!isset($_SESSION['username']) || $_SESSION['employeetype'] != 'hr'){
        header('Location: ../');
        exit();
    }
    $_SESSION['savedemployeereportsearchvalue'] = "";

    include(SHARED_PATH . "/header.php");

    $employee = new Employee();

    $dbYears = $employee->getYears();
    $year = date('Y');
    $today = date("d-m-Y");


    if(isset($_SESSION['employeereportsearchvalue'])) {
        $employeeRecord = $employee->getAllEmployeePlusLeaveYearByName($year, $_SESSION['employeereportsearchvalue']);
        $_SESSION['savedemployeereportsearchvalue'] = $_SESSION['employeereportsearchvalue'];
        unset($_SESSION['employeereportsearchvalue']);
    }else{
        $employeeRecord = $employee->getAllEmployeePlusLeaveYear($year);
    }

?>

<style>
    .searchform {
        display: flex;
        flex-direction: row;
    }
    .searchform input {
        border: 0.19rem solid var(--primary-color);
    }
    .searchform button {
        border: 0.19rem solid var(--primary-color);
        margin-left: 3px;
        border-radius: 0.5rem;
        background-color: #fff;
        padding: 0 0.6rem;
        cursor: pointer;
    }
    .searchform button i {
        font-size: 1rem;
        color: var(--primary-color);
    }
</style>

<section class="jbe__container-fluid jbe__employees-report">
    <div class="jbe__container">
        <?php if(isset($_SESSION['update-message'])){
            echo "
                <div id='toastr-message'>
                    <h6>". $_SESSION['update-message'] ."</h6>
                </div>
            ";
        }
        unset($_SESSION['update-message']);
        ?>
    </div>
    <div class="jbe__container">
        <div class="jbe__homepage-welcome">
            <div>
                <h5 class="jbe__general-header-h5">Employees Report</h5>
                <form action="" method="post" class="searchform">
                    <input type="text" class="form-control searchvalue" name="searchvalue" value="<?php if(isset($_SESSION['savedemployeereportsearchvalue'])){ echo $_SESSION['savedemployeereportsearchvalue'];}?>" placeholder="Search Employee">
                    <button type="button" class="searchformbtn"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div form action="" method="post" class="yearreport">
                <h5><span class="jbe__homepage-name">Choose Year:</span></h5>
                <select class="indexselect leaveyearindex">
                    <?php
                        for($i = 0; $i < count($dbYears); $i++){?>
                            <option value='<?php echo $dbYears[$i]['year'];?>' <?php if($year == $dbYears[$i]['year']){ echo 'selected';} ?>><?php echo $dbYears[$i]['year']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>
</section>
<style>
    .pages{
        top: 15px;
        text-align: center;
    }
    .pages a{
        font-size: 1.2rem;
        border: 2px solid var(--primary-color);
        padding: 2px 4px;
        margin-left: 3px;
    }
    .pagbtn.active{
        background-color: var(--primary-color);
        color: #fff;
        border: 2px solid var(--primary-color);
    }
    .activatedeactivate {
        cursor: pointer;
    }
    
</style>
<section class="jbe__container-fluid jbe__table">
    <div class="jbe__container">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col" width="4%">S/N</th>
                    <th scope="col">Employee ID</th>
                    <th scope="col">Employee Name</th>
                    <th scope="col">Email Address/Phone Number</th>
                    <th scope="col">Total Leave</th>
                    <th scope="col">Days Taken</th>
                    <th scope="col">Days Left</th>
                    <th scope="col" width="5%">View</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(!empty($employeeRecord)){
                        for($i = 0; $i < count($employeeRecord); $i++){
                            echo "<tr><th scope='row'>" . $i+1 . "</th>
                            <td>" . $employeeRecord[$i]['staff_id']  . "</td>
                            <td>" . $employeeRecord[$i]['firstname'] . ' ' . $employeeRecord[$i]['lastname']  . "</td>
                            <td>" . $employeeRecord[$i]['email_phone']  . "</td>
                            <td>" . $employeeRecord[$i]['totalleave'] . "</td>
                            <td>" . $employeeRecord[$i]['daystaken'] . "</td>
                            <td>" . $employeeRecord[$i]['daysleft'] . "</td>
                            <td><a href='employee-report.php?employee_id=". $employeeRecord[$i]['employee_id'] ."&employee_no=". $employeeRecord[$i]['staff_id']. "&year=" .$year. "' class='h5'><i class='fas fa-eye'></i></a></td>";
                        }
                    }?>
            </tbody>
        </table>
    </div>
</section>

<script>
    const searchForm = document.querySelector('.searchform');
    const searchFormBtn = document.querySelector('.searchformbtn');

    if(searchForm){
        searchForm.onsubmit = (e) => {
            e.preventDefault();
        }
    }

    let searchValue = document.querySelector(".searchvalue");
    searchValue.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            // event.preventDefault();
            document.querySelector('.searchformbtn').click();
        }
    });
        
    if(searchFormBtn) {
        let searchValue = document.querySelector(".searchvalue");
        searchFormBtn.onclick = () => {
            if(searchValue.value != ""){
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "../ajax_php/searchemployeereport.php", true)
                xhr.onload = () => {
                    if(xhr.readyState === XMLHttpRequest.DONE){
                        if(xhr.status === 200){
                            let data = xhr.response;
                            let dataParsed = JSON.parse(data);
                            if(dataParsed !== ""){
                                location.href = "employeesreport.php";
                            }
                        }
                    }
                }
                let formData = new FormData(searchForm); //creating new formData object
                xhr.send(formData); //sending the form data to php
            }
        }
    }
</script>

<script>
    const pagNavigation = document.querySelectorAll('.pagbtn');

    function pagination() {
        //Button clicked
        for(let i = 0; i < pagNavigation.length; i++)
        {
            pagNavigation[i].addEventListener('click', function(){
                let pageNum = {
                    page: pagNavigation[i].textContent,
                }
                let xhr = new XMLHttpRequest(); //creating XML object
                xhr.open("POST", "../ajax_php/pagination.php", true);
                xhr.onload = () => {
                    if(xhr.readyState === XMLHttpRequest.DONE){
                        if(xhr.status === 200){
                            let data = xhr.response;
                            let dataParsed = JSON.parse(data);
                            if(dataParsed['page'] !== ""){
                                location.href = "employees.php";
                            }
                        }
                    }
                }
                let pageNum1 = JSON.stringify(pageNum);
                xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                xhr.send(pageNum1);
            })
        }
    }

    pagination();
</script>

<script>
    const pagenumber = document.querySelector('.inputpage');
    const pagNav = document.querySelectorAll('.pagbtn');
    for(let i = 0; i < pagNav.length; i++){
        if(pagNav[i].innerHTML === pagenumber.value){
            pagNav[i].classList.add('active');
        }
    }
    
</script>
<?php
    unset($_SESSION['range1']);
    unset($_SESSION['range2']);
    unset($_SESSION['page']);
    unset($_SESSION['employeesearchvalue']);
    include(SHARED_PATH . "/footer.php");
?>