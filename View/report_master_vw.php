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
                    <h1>Report Builder</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Report Builder</li>
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
                        <h3 class="card-title">List of Data</h3>
                        <a href="#add"><span style="float:right; cursor:pointer;">Add New</span></a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="overflow:auto;"> <?php $tableComponent = new TableComponent();
$dynamicComponent = new DynamicComponent($master_conn);

$dynamicDetail = new DynamicDetailClass($master_conn);

$columns = [
    'table_name' => 'Table Name',
    'view_name' => 'View Name',
    'module_id' => 'Module',
    'features_category_id' => 'Feature Category',
    'menu_name' => 'Menu name',
];

echo $tableComponent->GetTable($master_conn, 'report_master_vw', $columns, $page, $limit, $search,true,'report_details','master_id','11','3','report_master');

     
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
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body"> <?php echo $dynamicComponent->createComponent('Table Name', '0', 'dropdown', 'form-group', 'table_name', 'required', 'schema_tables', 'table_name', 'table_name', '', '','', '','','');
echo $dynamicComponent->createComponent('View Name', '0', 'dropdown', 'form-group', 'view_name', 'required', 'schema_views', 'view_name', 'view_name', '', '','', '','','');
echo $dynamicComponent->createComponent('Module', '0', 'dropdown', 'form-group', 'module_id', 'required', 'modules', 'id', 'name', '', '','', '','','');
echo $dynamicComponent->createComponent('Feature Category', '0', 'dropdown', 'form-group', 'features_category_id', 'required', 'features_category', 'id', 'name', '', '','', '','','');
echo $dynamicComponent->createComponent('Menu name', '', 'textbox', 'form-group', 'menu_name', 'required');
echo $dynamicDetail->createDetailTable(array (
  0 => 
  array (
    'header' => 'Display Name',
    'type' => 'textbox',
    'name' => 'display_name',
    'displayColumn' => 'false',
  ),
  1 => 
  array (
    'header' => 'Column Name',
    'type' => 'dropdown',
    'name' => 'column_name',
    'displayColumn' => 'false',
    'table' => 'schema_view_columns',
    'valueField' => 'column_name',
    'optionField' => 'column_name',
    'onchangeTable' => '',
    'onchangeValueField' => '',
    'onchangeOptionColumn' => '',
    'onchangeType' => '',
    'onchangeFieldTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
    'conditionField' => '',
  ),
  2 => 
  array (
    'header' => 'Is Search',
    'type' => 'dropdown',
    'name' => 'is_search',
    'displayColumn' => 'false',
    'table' => 'yes_no_option',
    'valueField' => 'option_value',
    'optionField' => 'option',
    'onchangeTable' => '',
    'onchangeValueField' => '',
    'onchangeOptionColumn' => '',
    'onchangeType' => '',
    'onchangeFieldTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
    'conditionField' => '',
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
    'onchangeValueField' => '',
    'onchangeOptionColumn' => '',
    'onchangeType' => '',
    'onchangeFieldTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
    'conditionField' => '',
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
    'onchangeValueField' => '',
    'onchangeOptionColumn' => '',
    'onchangeType' => '',
    'onchangeFieldTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
    'conditionField' => '',
  ),
  5 => 
  array (
    'header' => 'Dropdown Table',
    'type' => 'dropdown',
    'name' => 'dropdown_table',
    'displayColumn' => 'false',
    'table' => 'schema_views',
    'valueField' => 'view_name',
    'optionField' => 'view_name',
    'onchangeTable' => '',
    'onchangeValueField' => '',
    'onchangeOptionColumn' => '',
    'onchangeType' => '',
    'onchangeFieldTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
    'conditionField' => '',
  ),
  6 => 
  array (
    'header' => 'Dropdown Value',
    'type' => 'dropdown',
    'name' => 'onchange_value_column',
    'displayColumn' => 'false',
    'table' => 'schema_view_columns',
    'valueField' => 'column_name',
    'optionField' => 'column_name',
    'onchangeTable' => '',
    'onchangeValueField' => '',
    'onchangeOptionColumn' => '',
    'onchangeType' => '',
    'onchangeFieldTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
    'conditionField' => '',
  ),
  7 => 
  array (
    'header' => 'Dropdown Option',
    'type' => 'dropdown',
    'name' => 'dropdown_option_column',
    'displayColumn' => 'false',
    'table' => 'schema_view_columns',
    'valueField' => 'column_name',
    'optionField' => 'column_name',
    'onchangeTable' => '',
    'onchangeValueField' => '',
    'onchangeOptionColumn' => '',
    'onchangeType' => '',
    'onchangeFieldTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
    'conditionField' => '',
  ),
  8 => 
  array (
    'header' => 'Onchange Table ',
    'type' => 'dropdown',
    'name' => 'onchange_table',
    'displayColumn' => 'false',
    'table' => 'schema_views',
    'valueField' => 'view_name',
    'optionField' => 'view_name',
    'onchangeTable' => '',
    'onchangeValueField' => '',
    'onchangeOptionColumn' => '',
    'onchangeType' => '',
    'onchangeFieldTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
    'conditionField' => '',
  ),
  9 => 
  array (
    'header' => 'Oncahange Value',
    'type' => 'dropdown',
    'name' => 'onchange_value_column',
    'displayColumn' => 'false',
    'table' => 'schema_view_columns',
    'valueField' => 'column_name',
    'optionField' => 'column_name',
    'onchangeTable' => '',
    'onchangeValueField' => '',
    'onchangeOptionColumn' => '',
    'onchangeType' => '',
    'onchangeFieldTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
    'conditionField' => '',
  ),
  10 => 
  array (
    'header' => 'Onchange Option',
    'type' => 'dropdown',
    'name' => 'onchange_option_column',
    'displayColumn' => 'false',
    'table' => 'schema_view_columns',
    'valueField' => 'column_name',
    'optionField' => 'column_name',
    'onchangeTable' => '',
    'onchangeValueField' => '',
    'onchangeOptionColumn' => '',
    'onchangeType' => '',
    'onchangeFieldTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
    'conditionField' => '',
  ),
), array (
), 1, array (
), true, array (
));
 ?> <br><br><input type="button"
                            onclick="saveMasterDetailData('report_master','report_details','master_id')"
                            value="Save" class="btn btn-success float-left saveButton">

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

        </div>

    </section>

</div>

?>