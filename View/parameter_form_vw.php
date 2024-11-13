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
    'table_name' => 'Table Name',
    'view_name' => 'View Name',
];

echo $tableComponent->GetTable($master_conn, 'parameter_form_vw', $columns, $page, $limit, $search,true,'parameter_form_details','master_id','2');

     
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
            <div class="card-body">  <?php echo $dynamicComponent->createComponent('Table Name', '0', 'dropdown', 'form-group', 'table_name', 'required', 'schema_tables', 'table_name', 'table_name', '', '', '');
echo $dynamicComponent->createComponent('View Name', '0', 'dropdown', 'form-group', 'view_name', 'required', 'schema_views', 'view_name', 'view_name', '', '', '');
echo $dynamicDetail->createDetailTable(array (
  0 => 
  array (
    'header' => 'Display name',
    'type' => 'text',
    'name' => 'display_name',
    'displayColumn' => 'false',
  ),
  1 => 
  array (
    'header' => 'Table Name',
    'type' => 'dropdown',
    'name' => 'tbl_name',
    'displayColumn' => 'false',
    'table' => 'schema_tables',
    'valueField' => 'table_name',
    'optionField' => 'table_name',
    'onchangeTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
  ),
  2 => 
  array (
    'header' => 'Column Name',
    'type' => 'dropdown',
    'name' => 'column_name',
    'displayColumn' => 'false',
    'table' => 'schema_table_columns',
    'valueField' => 'column_name',
    'optionField' => 'table_column_name',
    'onchangeTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
  ),
  3 => 
  array (
    'header' => 'Input Type',
    'type' => 'dropdown',
    'name' => 'input_type',
    'displayColumn' => 'false',
    'table' => 'input_types',
    'valueField' => 'input_type',
    'optionField' => 'input_type',
    'onchangeTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
  ),
  4 => 
  array (
    'header' => 'Is Required',
    'type' => 'dropdown',
    'name' => 'is_required',
    'displayColumn' => 'false',
    'table' => 'yes_no_option',
    'valueField' => 'option_value',
    'optionField' => 'option',
    'onchangeTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
  ),
  5 => 
  array (
    'header' => 'Dropdown Table',
    'type' => 'dropdown',
    'name' => 'dropdown_table',
    'displayColumn' => 'false',
    'table' => 'schema_tables',
    'valueField' => 'table_name',
    'optionField' => 'table_name',
    'onchangeTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
  ),
  6 => 
  array (
    'header' => 'Dropdown Value Column',
    'type' => 'dropdown',
    'name' => 'dropdown_value_column',
    'displayColumn' => 'false',
    'table' => 'schema_table_columns',
    'valueField' => 'column_name',
    'optionField' => 'column_name',
    'onchangeTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
  ),
  7 => 
  array (
    'header' => 'Dropdown Option Column',
    'type' => 'dropdown',
    'name' => 'dropdown_option_column',
    'displayColumn' => 'false',
    'table' => 'schema_table_columns',
    'valueField' => 'column_name',
    'optionField' => 'table_column_name',
    'onchangeTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
  ),
  8 => 
  array (
    'header' => 'OnchangeTable',
    'type' => 'dropdown',
    'name' => 'onchange_table',
    'displayColumn' => 'false',
    'table' => 'schema_tables',
    'valueField' => 'table_name',
    'optionField' => 'table_name',
    'onchangeTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
  ),
  9 => 
  array (
    'header' => 'Onchange Value Column',
    'type' => 'dropdown',
    'name' => 'onchange_value_column',
    'displayColumn' => 'false',
    'table' => 'schema_table_columns',
    'valueField' => 'column_name',
    'optionField' => 'table_column_name',
    'onchangeTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
  ),
  10 => 
  array (
    'header' => 'Onchange Option Column',
    'type' => 'dropdown',
    'name' => 'onchange_option_column',
    'displayColumn' => 'false',
    'table' => 'schema_table_columns',
    'valueField' => 'column_name',
    'optionField' => 'column_name',
    'onchangeTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
  ),
), array (
), 1, array (
), true, array (
));
 ?> <br><br><input type="button"  onclick="saveMasterDetailData('parameter_form_master','parameter_form_details','master_id')"  value="Save" class="btn btn-success float-left saveButton">
              
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        
      </div>
     
    </section>
  
</div>

?>