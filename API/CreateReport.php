<?php
include '../connection.php';

$form_id = $_GET['form_id'];

// Fetching form master data (view_name)
$form_master_sql = "SELECT * FROM `report_master` WHERE `id` = ?";
$stmt_master = $master_conn->prepare($form_master_sql);
$stmt_master->bind_param('i', $form_id);
$stmt_master->execute();
$form_master_result = $stmt_master->get_result();
$form_master_data = $form_master_result->fetch_assoc();
$view_name = $form_master_data['view_name'];


//Menu Create - - 
$features_category_id = $form_master_data['features_category_id'];
$menu_name = $form_master_data['menu_name'];

$sql = "
    INSERT INTO features (`name`, `file_name`, `menu_type`, `category_id`, `is_active`, `sequence`)
    SELECT '$menu_name', '$view_name', '', '$features_category_id', '1', '1'
    WHERE NOT EXISTS (
        SELECT 1 
        FROM features 
        WHERE `name` = '$menu_name' AND `category_id` = '$features_category_id'
    )";

if ($master_conn->query($sql) === TRUE) {
  //echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

// Fetching form details (columns and fields)
$form_details_sql = "SELECT `display_name`,is_search, `column_name`, `input_type`,is_required, `dropdown_table`, `dropdown_value_column`, `dropdown_option_column`, `onchange_table`, `onchange_value_column`, `onchange_option_column` 
                     FROM `report_details` WHERE `master_id` = ?";
$stmt_details = $master_conn->prepare($form_details_sql);
$stmt_details->bind_param('i', $form_id);
$stmt_details->execute();
$form_details_result = $stmt_details->get_result();

// Store form details in an array
$form_fields = [];
while ($row = $form_details_result->fetch_assoc()) {
    $form_fields[] = $row;
}

$stmt_master->close();
$stmt_details->close();


// Create the content for the PHP file
$php_content = "<?php\n\n";
$php_content .= "include '../connection.php';\n";
$php_content .= "include '../Classes/ReportComponentClass.php';\n";
$php_content .= "include '../Classes/ReportDynamicComponent.php';\n";
$php_content .= "\n";

$php_content.='session_start(); 
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
    </section>';


    $php_content.='<form class="form-inline" role="form"> <?php ';

$php_content .= "\$tableComponent = new TableComponent();\n";
$php_content .= "\$dynamicComponent = new DynamicComponent(\$master_conn);\n\n";

    // Creating the dynamic form fields
foreach ($form_fields as $field) {

  $is_required=$field['is_required'];

  $required="";
  if($is_required==1)
  {
     $required="required";
  }

  if($field['is_search']==1){
    
  if ($field['input_type'] == 'dropdown') {
      $php_content .= "echo \$dynamicComponent->createComponent('{$field['display_name']}', '0', '{$field['input_type']}', 'form-group', '{$field['column_name']}', '{$required}', '{$field['dropdown_table']}', '{$field['dropdown_value_column']}', '{$field['dropdown_option_column']}', '{$field['onchange_table']}', '{$field['onchange_value_column']}', '{$field['onchange_option_column']}');\n";
  } else {
      $php_content .= "echo \$dynamicComponent->createComponent('{$field['display_name']}', '', '{$field['input_type']}', 'form-group', '{$field['column_name']}', '{$required}');\n";
  }

}


}

    $php_content.=' ?> &nbsp;&nbsp; <button type="button" onclick="ReportRefresh()"
            class="btn btn-primary">Search</button>
    </form>';

    $php_content .='
    <!-- Table -->

    <section class="content">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <img src="dist/img/print.png" height="50px;" style="cursor:pointer;" id="print">
                            <img src="dist/img/pdf.png" height="50px;" style="cursor:pointer;" id="pdf">
                            <img src="dist/img/exel.jpg" height="50px;" style="cursor:pointer;" id="excel">
                        </h3>
                        <a href="#add"><span style="float:right; cursor:pointer;">Add New</span></a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body" style="overflow:auto;"> <?php ';
                

$php_content .= "\$headerComponent = new HeaderComponent();\n";
$php_content .= "echo \$headerComponent->GetHeader(\$master_conn,1,1,'Dinajpur','Birganj');\n\n";

// Creating the columns array
$php_content .= "\$columns = [\n";
foreach ($form_fields as $field) {
    if($field['is_search']==0){
    $php_content .= "    '{$field['column_name']}' => '{$field['display_name']}',\n";
    }
}
$php_content .= "];\n\n";

// Creating the table rendering code
$php_content .= "echo \$tableComponent->GetTable(\$master_conn, '{$view_name}', \$columns, \$page, \$limit, \$search);\n\n";


$php_content.='     
                ?>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>

        </div>

    </section>

    <!-- End Table -->
    ';

    // Close PHP tag
    $php_content .= "\n?>";

    // Define the file path to save the generated file
    $file_path = "../View/{$view_name}.php";

    // Save the content to the file
    file_put_contents($file_path, $php_content);

    echo "PHP file '{$view_name}.php' created successfully.";

    ?>