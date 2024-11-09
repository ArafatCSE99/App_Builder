<?php

include '../connection.php';
include '../Classes/ReportComponentClass.php';
include '../Classes/ReportDynamicComponent.php';

session_start(); 
$userid=$_SESSION["userid"];

$page=$_POST["page"];
$limit=$_POST["limit"];
$search=$_POST["search"];

// Content  ......................................................

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Report</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section><form class = "form-inline" role = "form"> <?php $tableComponent = new TableComponent();
$dynamicComponent = new DynamicComponent($master_conn);

echo $dynamicComponent->createComponent('Employee Name', '', 'textbox', 'form-group', 'name', 'required');
echo $dynamicComponent->createComponent('Department', '0', 'dropdown', 'form-group', 'department_id', 'required', 'department', 'id', 'name', '', '', '');
 ?> &nbsp;&nbsp; <button type = "button" onclick="ReportRefresh()" class = "btn btn-primary">Search</button>
</form><!-- Table -->  
    
    <section class="content">
      <div class="row">
        <div class="col-md-12">

    <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title" >
                <img src="dist/img/print.png" height="50px;" style="cursor:pointer;" id="print">
                <img src="dist/img/pdf.png" height="50px;" style="cursor:pointer;" id="pdf">
                <img src="dist/img/exel.jpg" height="50px;" style="cursor:pointer;" id="excel">
                </h3>
                <a href="#add"><span style="float:right; cursor:pointer;">Add New</span></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow:auto;">  <?php $headerComponent = new HeaderComponent();
echo $headerComponent->GetHeader($master_conn,1,1,'Dinajpur','Birganj');

$columns = [
    'name' => 'Full Name',
    'image_name' => 'Image',
    'department_name' => 'Department Name',
    'designation_name' => 'Designation Name',
    'is_active' => 'Is Active',
    'note' => 'Note',
    'total_hours_done' => 'Total Hours Done',
    'total_remaining_hours' => 'Total Remaining Hours',
];

echo $tableComponent->GetTable($master_conn, 'employees_report', $columns, $page, $limit, $search);

     
                ?>
              </div>
              <!-- /.card-body -->
            </div>

            </div>
        
        </div>
       
      </section>

    <!-- End Table -->

?>