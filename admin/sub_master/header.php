<?php
	include_once('../../Functions.php');

	$exam=new Functions;
	$exam->sub_master_access();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" type="text/css" href="../../assets/css/bootstrap.min.css">

  <!--DataTables CSS-->
  <link rel="stylesheet" type="text/css" href="../../assets/datatable/datatables.min.css">
  
  <!--Date Time Picker-->
  <link rel="stylesheet" type="text/css" href="../../assets/css/bootstrap-datetimepicker.css">
  
  <!--Custom CSS-->
  <link rel="stylesheet" type="text/css" href="../../assets/css/custom.css">

  <title>Online_exam</title>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-danger">
  <div class="container">
      <a class="navbar-brand text-light" href="index.php">Dashboard - Examiner</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link text-light" href="exam_list.php">Exam</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="../logout.php">Logout</a>
          </li>
        </ul>
      </div> 
  </div>
</nav>


