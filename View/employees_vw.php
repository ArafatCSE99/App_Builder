<?php

include "../connection.php"; 
include "../Classes/ComponentClass.php";
include "../Classes/DynamicComponent.php";

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
    'id' => 'ID',
    'name' => 'Full Name',
    'department_name' => 'Department Name',
    'designation_name' => 'Designation Name',
    'is_active' => 'Is Active',
    'note' => 'Note',
];
echo $tableComponent->GetTable($master_conn,'employees_vw', $columns,$page,$limit,$search);

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
echo $dynamicComponent->createComponent('Employee Name', '', 'textbox', 'form-group','name');
echo $dynamicComponent->createComponent('Department', '1', 'dropdown', 'form-group','department_id', 'department', 'id', 'name','designation');
echo $dynamicComponent->createComponent('Designation', '1', 'dropdown', 'form-group','designation_id', 'designation', 'id', 'name','');
echo $dynamicComponent->createComponent('Note', '', 'textarea', 'form-group','note');


            ?>

              <input type="button" id="saveButton" onclick="saveData('employees')"  value="Save" class="btn btn-success float-left">
              
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        
      </div>
     
    </section>
    <!-- /.content -->


</div>
