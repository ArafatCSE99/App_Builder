<?php
include '../connection.php';

$form_id = $_GET['form_id'];

// Fetching form master data (view_name)
$form_master_sql = "SELECT * FROM `master_detail_form_master` WHERE `id` = ?";
$stmt_master = $master_conn->prepare($form_master_sql);
$stmt_master->bind_param('i', $form_id);
$stmt_master->execute();
$form_master_result = $stmt_master->get_result();
$form_master_data = $form_master_result->fetch_assoc();
$view_name = $form_master_data['view_name'];
$details_table_name = $form_master_data['details_table_name'];
$master_field_name = $form_master_data['master_field_name'];
$table_name = $form_master_data['table_name'];
$builder_id = $form_master_data['builder_id'];

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
$form_details_sql = "SELECT `display_name`, `column_name`,`view_column_name`, `input_type`,is_required, `dropdown_table`, `dropdown_value_column`, `dropdown_option_column`, `onchange_table`, `onchange_value_column`, `onchange_option_column` 
                     FROM `master_detail_form_details` WHERE `master_id` = ? and field_area_id=1";
$stmt_details = $master_conn->prepare($form_details_sql);
$stmt_details->bind_param('i', $form_id);
$stmt_details->execute();
$form_details_result = $stmt_details->get_result();

// Store form details in an array
$form_fields = [];
while ($row = $form_details_result->fetch_assoc()) {
    $form_fields[] = $row;
}

$form_details_sql = "SELECT *
                     FROM `master_detail_form_details` WHERE `master_id` = ? and field_area_id=3";
$stmt_details = $master_conn->prepare($form_details_sql);
$stmt_details->bind_param('i', $form_id);
$stmt_details->execute();
$form_details_result = $stmt_details->get_result();

// Store form details in an array
$form_fields3 = [];
while ($row = $form_details_result->fetch_assoc()) {
    $form_fields3[] = $row;
}

$stmt_master->close();
$stmt_details->close();


// Create the content for the PHP file
$php_content = "<?php\n\n";
$php_content .= "include '../connection.php';\n";
$php_content .= "include '../Classes/ComponentClass.php';\n";
$php_content .= "include '../Classes/DynamicComponent.php';\n";
$php_content .= "include '../Classes/DynamicDetailClass.php';\n";
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
              <div class="card-body" style="overflow:auto;">  <?php ';
                

$php_content .= "\$tableComponent = new TableComponent();\n";
$php_content .= "\$dynamicComponent = new DynamicComponent(\$master_conn);\n\n";
$php_content .= "\$dynamicDetail = new DynamicDetailClass(\$master_conn);\n\n";

// Creating the columns array
$php_content .= "\$columns = [\n";
foreach ($form_fields as $field) {
    $php_content .= "    '{$field['column_name']}' => '{$field['display_name']}',\n";
}
foreach ($form_fields3 as $field) {
  $php_content .= "    '{$field['column_name']}' => '{$field['display_name']}',\n";
}
$php_content .= "];\n\n";

// Creating the table rendering code
$php_content .= "echo \$tableComponent->GetTable(\$master_conn, '{$view_name}', \$columns, \$page, \$limit, \$search,true,'{$details_table_name}','{$master_field_name}','{$form_id}','{$builder_id}','{$table_name}');\n\n";


$php_content.='     
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
            <div class="card-body">  <?php ';

// Creating the dynamic form fields
foreach ($form_fields as $field) {

    $is_required=$field['is_required'];

    $required="";
    if($is_required==1)
    {
       $required="required";
    }


    if ($field['input_type'] == 'dropdown') {
        $php_content .= "echo \$dynamicComponent->createComponent('{$field['display_name']}', '0', '{$field['input_type']}', 'form-group', '{$field['column_name']}', '{$required}', '{$field['dropdown_table']}', '{$field['dropdown_value_column']}', '{$field['dropdown_option_column']}', '{$field['onchange_table']}', '{$field['onchange_value_column']}', '{$field['onchange_option_column']}');\n";
    } else {
        $php_content .= "echo \$dynamicComponent->createComponent('{$field['display_name']}', '', '{$field['input_type']}', 'form-group', '{$field['column_name']}', '{$required}');\n";
    }
}



list($columns, $sumColumns) = generateDynamicColumns($master_conn,$form_id);
$footerFields = generateDynamicFooterFields($master_conn,$form_id);

$previousData = [];
$rowCount = 1;

$php_content .= 'echo $dynamicDetail->createDetailTable(' 
             . var_export($columns, true) . ', ' 
             . var_export($previousData, true) . ', ' 
             . var_export($rowCount, true) . ', ' 
             . var_export($sumColumns, true) . ', true, ' 
             . var_export($footerFields, true) 
             . ");\n";

$php_content.=' ?> <br><br><input type="button"  onclick="saveMasterDetailData(\''.$table_name.'\',\''.$details_table_name.'\',\''.$master_field_name.'\')"  value="Save" class="btn btn-success float-left saveButton">
              
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        
      </div>
     
    </section>
  
</div>
';

// Close PHP tag
$php_content .= "\n?>";

// Define the file path to save the generated file
$file_path = "../View/{$view_name}.php";

// Save the content to the file
file_put_contents($file_path, $php_content);

echo "PHP file '{$view_name}.php' created successfully.";


// Functions -------------------------------------------------------

function generateDynamicColumns($db,$form_id) {
  // Fetch data from master_detail_form_details2 for $columns
  $columns = [];
  $sumColumns = [];

  $query1 = "SELECT `id`, `display_name`, `column_name`, `input_type`, `is_display_column`, `dropdown_table`, `dropdown_value_column`, `dropdown_option_column`, `onchange_table`, `onchange_value_column`, `onchange_option_column`,`onchange_field_table`, `onchange_field`, `onchange_set_field`, `change_row_field`, `equation`, `is_sum` FROM `master_detail_form_details` where master_id=$form_id and field_area_id=2 ORDER BY CASE WHEN `display_name` = 'Field Area' THEN 0 ELSE 1 END";
  $result1 = $db->query($query1);

  while ($row = $result1->fetch_assoc()) {
      $column = [
          'header' => $row['display_name'],
          'type' => $row['input_type'],
          'name' => $row['column_name'],
          'displayColumn' => $row['is_display_column'] ? 'true' : 'false',
      ];

      if ($row['input_type'] === 'dropdown') {
          $column['table'] = $row['dropdown_table'];
          $column['valueField'] = $row['dropdown_value_column'];
          $column['optionField'] = $row['dropdown_option_column'];

          $column['onchangeTable'] = $row['onchange_table'];
          $column['onchangeValueField'] = $row['onchange_value_column'];
          $column['onchangeOptionColumn'] = $row['onchange_option_column'];

          $column['onchangeFieldTable'] = $row['onchange_field_table'];
          $column['onchangeField'] = $row['onchange_field'];
          $column['onchangeSetField'] = $row['onchange_set_field'];
      }

      if (!empty($row['change_row_field'])) {
          $column['changeRowField'] = $row['change_row_field'];
          $column['equation'] = $row['equation'];
      }

      $columns[] = $column;

      if ($row['is_sum']) {
          $sumColumns[] = $row['column_name'];
      }
  }

  return [$columns, $sumColumns];
}

function generateDynamicFooterFields($db,$form_id) {
  // Fetch data from master_detail_form_details3 for $footerFields
  $footerFields = [];

  $query2 = "SELECT `id`, `display_name`, `column_name`, `input_type`, `is_display_column`, `change_row_field`, `equation` FROM `master_detail_form_details`  where master_id=$form_id and field_area_id=3";
  $result2 = $db->query($query2);

  while ($row = $result2->fetch_assoc()) {
      $footerField = [
          'label' => $row['display_name'],
          'type' => $row['input_type'],
          'name' => $row['column_name'],
          'displayColumn' => $row['is_display_column'] ? 'true' : 'false',
      ];

      if (!empty($row['change_row_field'])) {
          $footerField['changeRowField'] = $row['change_row_field'];
          $footerField['equation'] = $row['equation'];
      }

      $footerFields[] = $footerField;
  }

  return $footerFields;
}




?>