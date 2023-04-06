<!DOCTYPE html>
<html lang="en">
<head>
    <!--META CHARSET-->
    <meta charset="UTF-8">
    <!--META EDGE-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--META VIEWPORT-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--TITLE-->
    <title>Jubailibros Leave Form <?php if(isset($page_title)){ echo ' - ' . h($page_title); }?> </title>
    <!--FAVICON-->
    <link rel="icon" type="image/x-icon" href="<?php echo url_for('img/favicon.png?v=') . time();?>">
    <!--META DESCRIPTION-->
    <meta name="Description" content="">
    <!--META KEYWORDS-->
    <meta name="keywords" content="">
    <!--META AUTHOR-->
    <meta name="author" content="Michael Aroworade">
    <!--Style Links-->
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">  
    <link rel="stylesheet" href="<?php echo url_for('css/utilities.css?v=') . time();?>">
    <link rel="stylesheet" href="<?php echo url_for('css/styles.css?v=') . time(); ?>">
    <link rel="stylesheet" href="<?php echo url_for('css/admin.css?v=') . time(); ?>">
    <link rel="stylesheet" href="<?php echo url_for('css/jquery-ui.css?v=') . time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
</head>
<style>
    .jbe__sidebar {
        position: fixed;
        height: 100vh;
        width: 280px;
        background: linear-gradient(to right, var(--gray-dark), var(--gray-dark));
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        overflow-y: auto;
    }
    .jbe__sidebar-brand {
        display: block;
        margin-top: 15px; 
        padding-left: 20px;
    }
    .jbe__sidebar-brand img {
        width: 180px; 
        height: 80px;
    }
    .jbe__sidebar-header{
        margin-top: 20px;
        color: black;
        padding-left: 10px;
        margin-bottom: 10px;
    }
    .jbe__general-link{
        display: block;
        color: var(--primary-color);
        padding: 5px;
    }

    .jbe__general-link:hover{
        background-color: var(--primary-color);
        color: var(--gray-light);
        padding: 5px;
    }

    .logout {
        margin-top: 30px;
        padding-left: 15px;
    }

    .logout:hover {
        margin-top: 30px;
        padding-left: 15px;
    }

    .jbe__mainbar{
        position: absolute;
        left: 300px;
        padding: 15px 0;
        width: calc(100% - 320px);
    }
</style>
<body>
<section class="jbe__sidebar">
    <a href="<?php echo url_for('index.php?v=') . time();?>" class="jbe__sidebar-brand">
        <img src="<?php echo url_for('img/jbe.png?v=') . time();?>" alt="Leave Form">
    </a>

    <div class="jbe__sidebar-header">
        <h6>JBE DASHBOARD</h6>
        <a href="<?php echo url_for('admin/index.php');?>" class="h6 jbe__general-link <?php $current_page = "dashboard"; if($current_page == $page_title){echo "sidebar-active";}?>">Analysis</a>
    </div>

    <div class="jbe__sidebar-header">
        <h6>JBE DEPARTMENT</h6>
        <a href="<?php echo url_for('admin/departments.php');?>" class="h6 jbe__general-link <?php $current_page = "departments"; if($current_page == $page_title){echo "sidebar-active";}?>">All Departments</a>
    </div>

    <div class="jbe__sidebar-header">
        <h6>JBE EMPLOYEE</h6>
        <a href="<?php echo url_for('admin/employees.php');?>" class="h6 jbe__general-link <?php $current_page = "employees"; if($current_page == $page_title){echo "sidebar-active";}?>">All Employees</a>
    </div>

    <div class="jbe__sidebar-header">
        <h6>JBE LEAVE APPLICATION</h6>
        <a href="<?php echo url_for('admin/leaveapplications.php');?>" class="h6 jbe__general-link <?php $current_page = "leaveapplications"; if($current_page == $page_title){echo "sidebar-active";}?>">All Leave Requests</a>
        <a href="<?php echo url_for('admin/approvedleave.php');?>" class="h6 jbe__general-link <?php $current_page = "approvedleave"; if($current_page == $page_title){echo "sidebar-active";}?>">BM Approved Leave Requests</a>
        <a href="<?php echo url_for('admin/pendingleave.php');?>" class="h6 jbe__general-link <?php $current_page = "pendingleave"; if($current_page == $page_title){echo "sidebar-active";}?>">Pending Leave Requests</a>
        <a href="<?php echo url_for('admin/declinedleave.php');?>" class="h6 jbe__general-link <?php $current_page = "declinedleave"; if($current_page == $page_title){echo "sidebar-active";}?>">Declined Leave Requests</a>
    </div>
l
    <a href="../logout.php" class="h6 jbe__general-link logout">Logout</a>
</section>
