<?php

include "../connection.php"; 
include "../Classes/DynamicDetailClass.php";

$masterIdValue=$_POST["id"];
$form_id=$_POST["form_id"];

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

$stmt_master->close();

list($columns, $sumColumns) = generateDynamicColumns($master_conn,$form_id);
$footerFields = generateDynamicFooterFields($master_conn,$form_id);

  
  $previousData = []; // Get this data as per your logic
  
  $rowCount = 1;
  

$dynamicDetail = new DynamicDetailClass($master_conn);
$masterIdField=$master_field_name;

$previousData = $dynamicDetail->getDetailData($details_table_name, $columns, $masterIdField, $masterIdValue);
echo $dynamicDetail->createDetailTable($columns, $previousData, $rowCount, $sumColumns, true, $footerFields);



function generateDynamicColumns($db,$form_id) {
  // Fetch data from master_detail_form_details2 for $columns
  $columns = [];
  $sumColumns = [];

  $query1 = "SELECT `id`, `display_name`, `column_name`, `input_type`, `is_display_column`, `dropdown_table`, `dropdown_value_column`, `dropdown_option_column`, `onchange_table`, `onchange_value_column`, `onchange_option_column`,onchange_type,`onchange_field_table`, `onchange_field`, `onchange_set_field`, condition_field,`change_row_field`, `equation`, `is_sum` FROM `master_detail_form_details` where master_id=$form_id and field_area_id=2 ORDER BY serial_no";
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

          $column['onchangeType'] = $row['onchange_type'];
          $column['onchangeFieldTable'] = $row['onchange_field_table'];
          $column['onchangeField'] = $row['onchange_field'];
          $column['onchangeSetField'] = $row['onchange_set_field'];
          $column['conditionField'] = $row['condition_field'];
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

  $query2 = "SELECT `id`, `display_name`, `column_name`, `input_type`, `is_display_column`, `change_row_field`, `equation` FROM `master_detail_form_details` where master_id=$form_id and field_area_id=3";
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