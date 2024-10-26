<?php

include "../connection.php"; 
include "../Classes/ComponentClass.php";
include "../Classes/DynamicComponent.php";
include "../Classes/DynamicDetailClass.php";

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
            <h1>Employees</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Employees</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!-- Table -->  
    
    <section class="content">
      <div class="row">
        <div class="col-md-12">

    <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title" >List of Employees</h3>
                <a href="#add"><span style="float:right; cursor:pointer;">Add New</span></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow:auto;">
                

                  <?php

$tableComponent = new TableComponent();
$columns = [
    'name' => 'Full Name',
    'image_name' => 'Image',
    'department_name' => 'Department Name',
    'designation_name' => 'Designation Name',
    'is_active' => 'Is Active',
    'note' => 'Note',
];
echo $tableComponent->GetTable($master_conn,'employees_vw', $columns,$page,$limit,$search,true,'employees_project_detail','employee_id');

                ?>
                  
                
              </div>
              <!-- /.card-body -->
            </div>

            </div>
        
        </div>
       
      </section>

    <!-- End Table -->






    <!-- Main content -->
<section class="content" id="add">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Role</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">

            <!--
              <div class="form-group">
                <label for="role">Role Name</label>
                <input type="text" id="role" style="width:25%" class="form-control" placeholder="Role Name">
              </div>
            -->

            <?php

$dynamicComponent = new DynamicComponent($master_conn);
echo $dynamicComponent->createComponent('Employee Name', '', 'textbox', 'form-group','name','required');
echo $dynamicComponent->createComponent('Department', '0', 'dropdown', 'form-group','department_id','required', 'department', 'id', 'name','designation','id','name');
echo $dynamicComponent->createComponent('Designation', '0', 'dropdown', 'form-group','designation_id','required', 'designation', 'id', 'name');
echo $dynamicComponent->createComponent('Note', '', 'textarea', 'form-group','note','');
echo $dynamicComponent->createComponent('Image', '', 'image');




$columns = [
  ['header' => 'Project', 'type' => 'dropdown', 'name' => 'project_id', 'table' => 'project','valueField'=>'id','optionField'=>'name'],
  ['header' => 'Hours', 'type' => 'number', 'name' => 'hours'],
  ['header' => 'Client', 'type' => 'textbox', 'name' => 'client_name'],
];

// Fetch previous data if available
$previousData = []; // Get this data as per your logic

// Define number of rows to be initially displayed
$rowCount = 1;

// Define columns that need sum functionality
$sumColumns = ['hours'];

// Footer fields like Total, Paid, and Due
$footerFields = [
  ['label' => 'Total Hours', 'type' => 'text', 'name' => 'total_hours']
];

$dynamicDetail = new DynamicDetailClass($master_conn);
echo $dynamicDetail->createDetailTable($columns, $previousData, $rowCount, $sumColumns, true, $footerFields);


            ?>

              <input type="button"  onclick="saveMasterDetailData('employees','employees_project_detail','employee_id')"  value="Save" class="btn btn-success float-left saveButton">
              
              <input type="button"  onclick="checkData()"  value="Check Data" class="btn btn-success float-left">


            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        
      </div>
     
    </section>
    <!-- /.content -->


</div>
