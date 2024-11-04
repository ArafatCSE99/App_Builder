<?php

include '../connection.php';
include '../Classes/ComponentClass.php';
include '../Classes/DynamicComponent.php';
include '../Classes/DynamicDetailClass.php';

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
              <div class="card-body" style="overflow:auto;">  <?php $tableComponent = new TableComponent();
$dynamicComponent = new DynamicComponent($master_conn);

$dynamicDetail = new DynamicDetailClass($master_conn);

$columns = [
    'name' => 'Employee Name',
    'department_name' => 'Department',
    'designation_name' => 'Designation',
    'note' => 'Note',
    'image_name' => 'Image',
    'total_hours_done' => 'Total Hours Done',
    'total_remaining_hours' => 'Total Remaining Hours',
];

echo $tableComponent->GetTable($master_conn, 'employees_view', $columns, $page, $limit, $search,true,'employees_project_detail','employee_id','1');

     
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
            <div class="card-body">  <?php echo $dynamicComponent->createComponent('Employee Name', '', 'textbox', 'form-group', 'name', 'required');
echo $dynamicComponent->createComponent('Department', '0', 'dropdown', 'form-group', 'department_id', 'required', 'department', 'id', 'name', 'designation', 'id', 'name');
echo $dynamicComponent->createComponent('Designation', '0', 'dropdown', 'form-group', 'designation_id', 'required', 'designation', 'id', 'name', '', '', '');
echo $dynamicComponent->createComponent('Note', '', 'textarea', 'form-group', 'note', 'required');
echo $dynamicComponent->createComponent('Image', '', 'image', 'form-group', 'image_name', '');
echo $dynamicDetail->createDetailTable(array (
  0 => 
  array (
    'header' => 'Project',
    'type' => 'dropdown',
    'name' => 'project_id',
    'displayColumn' => 'false',
    'table' => 'project',
    'valueField' => 'id',
    'optionField' => 'name',
    'onchangeTable' => 'project',
    'onchangeField' => 'project_hour',
    'onchangeSetField' => 'project_hours',
  ),
  1 => 
  array (
    'header' => 'Project Hours',
    'type' => 'text',
    'name' => 'project_hours',
    'displayColumn' => 'true',
  ),
  2 => 
  array (
    'header' => 'Hours',
    'type' => 'number',
    'name' => 'hours',
    'displayColumn' => 'false',
    'changeRowField' => 'remaining_hours',
    'equation' => 'project_hours-hours',
  ),
  3 => 
  array (
    'header' => 'Remaining Hours',
    'type' => 'text',
    'name' => 'remaining_hours',
    'displayColumn' => 'true',
  ),
  4 => 
  array (
    'header' => 'Client',
    'type' => 'text',
    'name' => 'client_name',
    'displayColumn' => 'false',
  ),
), array (
), 1, array (
  0 => 'hours',
), true, array (
  0 => 
  array (
    'label' => 'Total Hours Done',
    'type' => 'text',
    'name' => 'total_hours_done',
    'displayColumn' => 'false',
    'changeRowField' => 'total_remaining_hours',
    'equation' => 'hoursSum-total_hours_done',
  ),
  1 => 
  array (
    'label' => 'Total Remaining Hours',
    'type' => 'text',
    'name' => 'total_remaining_hours',
    'displayColumn' => 'true',
  ),
));
 ?> <input type="button"  onclick="saveMasterDetailData('employees','employees_project_detail','employee_id')"  value="Save" class="btn btn-success float-left saveButton">
              
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        
      </div>
     
    </section>
  
</div>

?>