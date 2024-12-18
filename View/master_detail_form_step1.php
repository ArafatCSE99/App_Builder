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
                    <h1>Master Detail Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Master Detail Form</li>
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
    'menu_name' => 'Menu Name',
    'details_table_name' => 'Details Table Name',
    'master_field_name' => 'Master Field Name',
];

echo $tableComponent->GetTable($master_conn, 'master_detail_form_step1', $columns, $page, $limit, $search,true,'master_detail_form_details','master_id','26','2','master_detail_form_master');

     
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
echo $dynamicComponent->createComponent('Module', '0', 'dropdown', 'form-group', 'module_id', 'required', 'modules', 'id', 'name', 'features_category', 'id','name', 'module_id','features_category_id','module_id');
echo $dynamicComponent->createComponent('Feature Category', '0', 'dropdown', 'form-group', 'features_category_id', 'required', 'features_category', 'id', 'name', '', '','', '','','');
echo $dynamicComponent->createComponent('Menu Name', '', 'textbox', 'form-group', 'menu_name', 'required');
echo $dynamicComponent->createComponent('Details Table Name', '0', 'dropdown', 'form-group', 'details_table_name', 'required', 'schema_tables', 'table_name', 'table_name', 'schema_view_columns', 'column_name','column_name', 'details_table_name','master_field_name','name');
echo $dynamicComponent->createComponent('Master Field Name', '0', 'dropdown', 'form-group', 'master_field_name', 'required', 'schema_table_columns', 'column_name', 'column_name', '', '','', '','','');
echo $dynamicDetail->createDetailTable(array (
  0 => 
  array (
    'header' => 'Field Area',
    'type' => 'dropdown',
    'name' => 'field_area_id',
    'displayColumn' => 'false',
    'table' => 'field_area',
    'valueField' => 'id',
    'optionField' => 'name',
    'onchangeTable' => '',
    'onchangeValueField' => '',
    'onchangeOptionColumn' => '',
    'onchangeType' => '',
    'onchangeFieldTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
    'conditionField' => '',
  ),
  1 => 
  array (
    'header' => 'Display name',
    'type' => '',
    'name' => 'display_name',
    'displayColumn' => 'false',
  ),
  2 => 
  array (
    'header' => 'Table Name',
    'type' => 'dropdown',
    'name' => 'tbl_name',
    'displayColumn' => 'false',
    'table' => 'schema_views',
    'valueField' => 'view_name',
    'optionField' => 'view_name',
    'onchangeTable' => 'schema_view_columns',
    'onchangeValueField' => 'column_name',
    'onchangeOptionColumn' => 'column_name',
    'onchangeType' => 'Dropdown',
    'onchangeFieldTable' => '',
    'onchangeField' => 'tbl_name',
    'onchangeSetField' => 'column_name',
    'conditionField' => 'name',
  ),
  3 => 
  array (
    'header' => 'Column Name',
    'type' => 'dropdown',
    'name' => 'column_name',
    'displayColumn' => 'false',
    'table' => 'schema_table_columns',
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
  4 => 
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
  5 => 
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
  6 => 
  array (
    'header' => 'Dropdown Table',
    'type' => 'dropdown',
    'name' => 'dropdown_table',
    'displayColumn' => 'false',
    'table' => 'schema_views',
    'valueField' => 'view_name',
    'optionField' => 'view_name',
    'onchangeTable' => 'schema_view_columns',
    'onchangeValueField' => 'column_name',
    'onchangeOptionColumn' => 'column_name',
    'onchangeType' => 'Dropdown',
    'onchangeFieldTable' => '',
    'onchangeField' => 'dropdown_table',
    'onchangeSetField' => 'dropdown_value_column',
    'conditionField' => 'name',
  ),
  7 => 
  array (
    'header' => 'Dropdown Value Column',
    'type' => 'dropdown',
    'name' => 'dropdown_value_column',
    'displayColumn' => 'false',
    'table' => 'schema_view_columns',
    'valueField' => 'column_name',
    'optionField' => 'column_name',
    'onchangeTable' => 'schema_view_columns',
    'onchangeValueField' => 'column_name',
    'onchangeOptionColumn' => 'column_name',
    'onchangeType' => 'Dropdown',
    'onchangeFieldTable' => '',
    'onchangeField' => 'dropdown_table',
    'onchangeSetField' => 'dropdown_option_column',
    'conditionField' => 'name',
  ),
  8 => 
  array (
    'header' => 'Dropdown Option Column',
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
  9 => 
  array (
    'header' => 'OnchangeTable',
    'type' => 'dropdown',
    'name' => 'onchange_table',
    'displayColumn' => 'false',
    'table' => 'schema_views',
    'valueField' => 'view_name',
    'optionField' => 'view_name',
    'onchangeTable' => 'schema_view_columns',
    'onchangeValueField' => 'column_name',
    'onchangeOptionColumn' => 'column_name',
    'onchangeType' => 'Dropdown',
    'onchangeFieldTable' => '',
    'onchangeField' => 'onchange_table',
    'onchangeSetField' => 'onchange_value_column',
    'conditionField' => 'name',
  ),
  10 => 
  array (
    'header' => 'Onchange Value Column',
    'type' => 'dropdown',
    'name' => 'onchange_value_column',
    'displayColumn' => 'false',
    'table' => 'schema_view_columns',
    'valueField' => 'column_name',
    'optionField' => 'column_name',
    'onchangeTable' => 'schema_view_columns',
    'onchangeValueField' => 'column_name',
    'onchangeOptionColumn' => 'column_name',
    'onchangeType' => 'Dropdown',
    'onchangeFieldTable' => '',
    'onchangeField' => 'onchange_table',
    'onchangeSetField' => 'onchange_option_column',
    'conditionField' => 'name',
  ),
  11 => 
  array (
    'header' => 'Onchange Option Column',
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
  12 => 
  array (
    'header' => 'Onchange Type',
    'type' => 'dropdown',
    'name' => 'onchange_type',
    'displayColumn' => 'false',
    'table' => 'onchange_types',
    'valueField' => 'onchange_type',
    'optionField' => 'onchange_type',
    'onchangeTable' => '',
    'onchangeValueField' => '',
    'onchangeOptionColumn' => '',
    'onchangeType' => '',
    'onchangeFieldTable' => '',
    'onchangeField' => '',
    'onchangeSetField' => '',
    'conditionField' => '',
  ),
  13 => 
  array (
    'header' => 'Onchange Field  Table',
    'type' => 'dropdown',
    'name' => 'onchange_field_table',
    'displayColumn' => 'false',
    'table' => 'schema_tables',
    'valueField' => 'table_name',
    'optionField' => 'table_name',
    'onchangeTable' => 'schema_view_columns',
    'onchangeValueField' => 'column_name',
    'onchangeOptionColumn' => 'column_name',
    'onchangeType' => 'Dropdown',
    'onchangeFieldTable' => '',
    'onchangeField' => 'onchange_field_table',
    'onchangeSetField' => 'onchange_field',
    'conditionField' => 'name',
  ),
  14 => 
  array (
    'header' => 'Onchange Field',
    'type' => 'dropdown',
    'name' => 'onchange_field',
    'displayColumn' => 'false',
    'table' => 'schema_table_columns',
    'valueField' => 'column_name',
    'optionField' => 'column_name',
    'onchangeTable' => 'schema_view_columns',
    'onchangeValueField' => 'column_name',
    'onchangeOptionColumn' => 'column_name',
    'onchangeType' => 'Dropdown',
    'onchangeFieldTable' => '',
    'onchangeField' => 'onchange_field_table',
    'onchangeSetField' => 'condition_field',
    'conditionField' => 'name',
  ),
  15 => 
  array (
    'header' => 'Condition Field',
    'type' => 'dropdown',
    'name' => 'condition_field',
    'displayColumn' => 'false',
    'table' => 'schema_table_columns',
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
  16 => 
  array (
    'header' => 'Details Table Name',
    'type' => 'dropdown',
    'name' => 'details_table_name',
    'displayColumn' => 'false',
    'table' => 'schema_tables',
    'valueField' => 'table_name',
    'optionField' => 'table_name',
    'onchangeTable' => 'schema_view_columns',
    'onchangeValueField' => 'column_name',
    'onchangeOptionColumn' => 'column_name',
    'onchangeType' => 'Dropdown',
    'onchangeFieldTable' => '',
    'onchangeField' => 'details_table_name',
    'onchangeSetField' => 'onchange_set_field',
    'conditionField' => 'name',
  ),
  17 => 
  array (
    'header' => 'Onchange Set Field',
    'type' => 'dropdown',
    'name' => 'onchange_set_field',
    'displayColumn' => 'false',
    'table' => 'schema_table_columns',
    'valueField' => 'column_name',
    'optionField' => 'column_name',
    'onchangeTable' => 'schema_view_columns',
    'onchangeValueField' => 'column_name',
    'onchangeOptionColumn' => 'column_name',
    'onchangeType' => 'Dropdown',
    'onchangeFieldTable' => '',
    'onchangeField' => 'details_table_name',
    'onchangeSetField' => 'change_row_field',
    'conditionField' => 'name',
  ),
  18 => 
  array (
    'header' => 'Cahnge Row Field',
    'type' => 'dropdown',
    'name' => 'change_row_field',
    'displayColumn' => 'false',
    'table' => 'schema_table_columns',
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
  19 => 
  array (
    'header' => 'Equation',
    'type' => '',
    'name' => 'equation',
    'displayColumn' => 'false',
  ),
  20 => 
  array (
    'header' => 'Is Sum',
    'type' => 'dropdown',
    'name' => 'is_sum',
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
  21 => 
  array (
    'header' => 'Serial No',
    'type' => 'number',
    'name' => 'serial_no',
    'displayColumn' => 'false',
  ),
  22 => 
  array (
    'header' => 'Display Column',
    'type' => 'dropdown',
    'name' => 'is_display_column',
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
), array (
), 1, array (
), true, array (
));
 ?> <br><br><input type="button"
                            onclick="saveMasterDetailData('master_detail_form_master','master_detail_form_details','master_id')"
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