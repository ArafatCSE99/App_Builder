<?php

include '../connection.php';
include '../Classes/ComponentClass.php';
include '../Classes/DynamicComponent.php';

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
                    <h1>Medicine</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Medicine</li>
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

$columns = [
    'name' => 'Name ',
    'generics_id' => 'Generics Name',
    'stock' => 'Stock',
    'purchase_price' => 'Purchase Price',
    'sales_price' => 'Sales Price',
];

echo $tableComponent->GetTable($master_conn, 'pha_medicine_vw', $columns, $page, $limit, $search);

     
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
                    <div class="card-body"> <?php echo $dynamicComponent->createComponent('Name ', '', 'textbox', 'form-group', 'name', 'required');
echo $dynamicComponent->createComponent('Generics Name', '0', 'dropdown', 'form-group', 'generics_id', 'required', 'pha_generics', 'id', 'name', '', '', '');
echo $dynamicComponent->createComponent('Stock', '', 'number', 'form-group', 'stock', 'required');
echo $dynamicComponent->createComponent('Purchase Price', '', 'number', 'form-group', 'purchase_price', 'required');
echo $dynamicComponent->createComponent('Sales Price', '', 'number', 'form-group', 'sales_price', 'required');
 ?> <input type="button" onclick="saveData('pha_madicine')" value="Save"
                            class="btn btn-success float-left saveButton">

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

        </div>

    </section>

</div>

?>