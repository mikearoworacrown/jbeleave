<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");
    require_once(PROJECT_PATH . "/class/Employee.php");

    $employee = new Employee();
    $page_title = "employees";

    //Pagination
    //Get the total number of pages .........................
    $totalEmployee =  $employee->getTotalNumberOfEmployee();

    //Variable to store the number of rows per page .............
    $limit = 20;

    //Get required number of number ........................
    $total_pages = ceil ($totalEmployee / $limit);

    if(!isset($_GET['page'])){
        $page_number = 1;
    }else {
        $page_number = $_GET['page'];
        if($page_number > $total_pages){
            header('Location: employees.php');
            exit();
        }
    }


    //get the initial page number .......................
    $initial_page = ($page_number - 1) * $limit;

    $range1 = $initial_page;
    $range2 = $initial_page + $limit;
    if($totalEmployee <= $range2){
        $range2 = $totalEmployee;
    }

    if(!isset($_SESSION['username']) || $_SESSION['employeetype'] != 'admin'){
        header('Location: ../');
        exit();
    }

    $employeeRecord = $employee->getAllEmployeeByLimit($initial_page, $limit);

    if(isset($_GET['searchvalue'])) {
        $searchValue = h($_GET['searchvalue']); 
        $employeeRecord = $employee->getEmployeeByName($searchValue);
        if(empty($employeeRecord)){
            header('Location: employees.php');
            exit();
        }
    }
    
    include(SHARED_PATH . "/admin-header.php");
?>

<input type="hidden" id="pagenumber" value="<?php echo $page_number; ?>">
<section class="jbe__mainbar">
    <div class="jbe__container-fluid">
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
    <div class="jbe__homepage-welcome">
        <div>
            <h5 class="display-4 jbe__general-header-h5 mb-3">Employees</h5>
            <form action="" class="searchemployee">
                <input type="text" class="form-control searchemployeevalue" name="searchemployeevalue" value="" placeholder="Search Employee">
                <button type="button" class="searchemployeebtn"><i class="fas fa-search"></i></button>
            </form>
        </div>
        
        <a href="<?php echo url_for('/admin/register.php')?>" class="h6 button">Register New Employee</a>
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
                        for($j = $range1, $i = 0; $j < $range2, $i < count($employeeRecord); $j++, $i++){
                            echo "<tr><th scope='row'>" . $j+1 . "</th>
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
                            echo "<td style='white-space:nowrap'>
                                <a href='employee-edit.php?employee_id=". $employeeRecord[$i]['employee_id'] ."' class='h5 editemployeebtn'><i class='fas fa-edit'></i></a>
                                <a href='delete-employee.php?employee_id=". $employeeRecord[$i]['employee_id'] ."' class='h5 deleteemployeebtn'><i class='fas fa-trash'></i></a>
                                <a href='resetpassword.php?employee_id=". $employeeRecord[$i]['employee_id'] ."' class='h5 passwordemployeebtn'>Reset Password</a>";
                          echo "</td></tr>";
                        }
                    } 
                ?>
            </tbody>
        </table>
    </div>
    <div class="employeepages">
        <?php
            //show page number with link
            for($page_number = 1; $page_number <= $total_pages; $page_number++){
                echo "<a class='h5 pagelinks' href='employees.php?page=" .$page_number. "'>".$page_number."</a>";
            }
        ?>
    </div>
    <script>
        let pageslink = document.querySelectorAll('.pagelinks');
        let pageNumber = document.getElementById("pagenumber").value;
        // console.log(pageslink);
        // console.log(pageNumber);
        pageslink[pageNumber-1].style.color = 'white';
        pageslink[pageNumber-1].style.backgroundColor = '#091281';




        const searchEmployee = document.querySelector(".searchemployee");
        const searchEmployeeBtn = document.querySelector(".searchemployeebtn");

        if(searchEmployee){
            searchEmployee.onsubmit = (e) => {
                e.preventDefault();
            }
        }

        let searchValue = document.querySelector(".searchemployeevalue");
        searchValue.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                // event.preventDefault();
                document.querySelector('.searchemployeebtn').click();
            }
        });

        if(searchEmployeeBtn){
            searchEmployeeBtn.onclick = () => {
                let searchValue = document.querySelector(".searchemployeevalue");
                if(searchValue.value != ""){
                    location.href = "employees.php?searchvalue="+searchValue.value;
                   
                }

            }
        }
    </script>


</section>



<?php
    include(SHARED_PATH . "/footer.php");
    include(SHARED_PATH . "/admin-footer.php");
?>