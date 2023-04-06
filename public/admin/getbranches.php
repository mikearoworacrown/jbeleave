<?php
    require_once("C:/xampp/htdocs/jbeleave/private/initialize.php");

    $region_id = $_GET['region_id'];

    require_once(PROJECT_PATH .'/class/Employee.php');
    $employee = new Employee();
    
    
    $branches = $employee->getbranches($region_id);

    if(!empty($branches)){
        echo "<table class='table'>
                <thead class='thead-dark'>
                    <tr>
                        <th scope='col' width='4%'>S/N</th>
                        <th scope='col'>Branch</th>
                        <th scope='col' width='4%'>Action</th>
                    </tr>
                </thead>
                <tbody>";
                    if(!empty($branches)){
                        for($i = 0; $i < count($branches); $i++){
                            echo "<tr><th scope='row'>" . $i+1 . "</th>
                            <td>" . $branches[$i]['branch'] . "</td>
                            <td>
                                <input type='hidden' class='branchedit-id' name='branchedit-id' value='". $branches[$i]['branch_id'] ."'/>
                                <a href='edit-branch.php?region_id=". $region_id . "&branch_id=" .$branches[$i]['branch_id']. "&branch=".$branches[$i]['branch']."'><i class='fas fa-edit'></i></a>
                                <a href='delete-branch.php?region_id=". $region_id . "&branch_id=" .$branches[$i]['branch_id']. "&branch=".$branches[$i]['branch']."' class='h5 branchdeletebtn'><i class='fas fa-trash'></i></a>
                            </td></tr>";
                        }
                    }
            echo "</tbody>
            </table>";
    }else{
        echo "<table class='table'>
            <thead class='thead-dark'>
                <tr>
                    <th scope='col' width='4%'>S/N</th>
                    <th scope='col'>Branch</th>
                    <th scope='col' width='4%'>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>";
        
    }
?>