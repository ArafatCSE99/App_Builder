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
                    <h1>Sales</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Sales</li>
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
    'customer_name' => 'Customer Name',
    'mobile_number' => 'Mobile Number',
    'address' => 'Address',
    'memo_no' => 'Memo Number',
    'date' => 'Date',
    'paid' => 'Paid',
    'due' => 'Due',
];

echo $tableComponent->GetTable($master_conn, 'pha_sales_master', $columns, $page, $limit, $search,true,'pha_sales_details','master_id','30','0','pha_sales_master');

     
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
                    <div class="card-body"> <?php echo $dynamicComponent->createComponent('Customer Name', '', 'textbox', 'form-group', 'customer_name', 'required');
echo $dynamicComponent->createComponent('Mobile Number', '', 'textbox', 'form-group', 'mobile_number', '');
echo $dynamicComponent->createComponent('Address', '', 'textbox', 'form-group', 'address', 'required');
echo $dynamicComponent->createComponent('Memo Number', '', 'textbox', 'form-group', 'memo_no', 'required');
echo $dynamicComponent->createComponent('Date', '', 'date', 'form-group', 'date', 'required');
echo $dynamicDetail->createDetailTable(array (
  0 => 
  array (
    'header' => 'Medicine',
    'type' => 'dropdown',
    'name' => 'medicine_id',
    'displayColumn' => 'false',
    'table' => 'pha_madicine',
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
    'header' => 'Quantity',
    'type' => 'number',
    'name' => 'quantity',
    'displayColumn' => 'false',
  ),
  2 => 
  array (
    'header' => 'Price',
    'type' => 'number',
    'name' => 'prize',
    'displayColumn' => 'false',
  ),
), array (
), 1, array (
  0 => 'quantity',
  1 => 'prize',
), true, array (
  0 => 
  array (
    'label' => 'Paid',
    'type' => 'number',
    'name' => 'paid',
    'displayColumn' => 'false',
    'changeRowField' => 'due',
    'equation' => 'prizeSum-paid',
  ),
  1 => 
  array (
    'label' => 'Due',
    'type' => 'number',
    'name' => 'due',
    'displayColumn' => 'true',
  ),
));
 ?> <br><br><input type="button"
                            onclick="saveMasterDetailData('pha_sales_master','pha_sales_details','master_id')"
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