<?php

include "../connection.php"; 
include "../Classes/DynamicDetailClass.php";

$columns = [
    ['header' => 'Project', 'type' => 'dropdown', 'name' => 'project_id', 'table' => 'project','valueField'=>'id','optionField'=>'name','onchangeTable'=>'project','onchangeField'=>'project_hour','onchangeSetField'=>'project_hours'],
    ['header' => 'Project Hours', 'type' => 'text', 'name' => 'project_hours', 'displayColumn' => 'true' ],
    ['header' => 'Hours', 'type' => 'number', 'name' => 'hours','changeRowField'=>'remaining_hours','equation'=>'project_hours-hours'],
    ['header' => 'Remaining Hours', 'type' => 'text', 'name' => 'remaining_hours', 'displayColumn' => 'true' ],
    ['header' => 'Client', 'type' => 'textbox', 'name' => 'client_name'],
  ];
  
  // Fetch previous data if available
  $previousData = []; // Get this data as per your logic
  
  // Define number of rows to be initially displayed
  $rowCount = 1;
  
  // Define columns that need sum functionality
  //$sumColumns = [];
  $sumColumns = ['hours'];
  
  // Footer fields like Total, Paid, and Due
  $footerFields = [
    ['label' => 'Total Hours Done', 'type' => 'text', 'name' => 'total_hours_done','changeRowField'=>'total_remaining_hours','equation'=>'hoursSum-total_hours_done' ],
    ['label' => 'Total Remaining Hours', 'type' => 'text', 'name' => 'total_remaining_hours', 'displayColumn' => 'true' ]
  ];
  
$dynamicDetail = new DynamicDetailClass($master_conn);
$masterIdField='employee_id';
$masterIdValue=$_POST["id"];
$previousData = $dynamicDetail->getDetailData('employees_project_detail', $columns, $masterIdField, $masterIdValue);
echo $dynamicDetail->createDetailTable($columns, $previousData, $rowCount, $sumColumns, true, $footerFields);



function generateDynamicColumns($db) {
  // Fetch data from master_detail_form_details2 for $columns
  $columns = [];
  $sumColumns = [];

  $query1 = "SELECT `id`, `header`, `column_name`, `input_type`, `is_display_column`, `data_table`, `value_field`, `option_field`, `onchange_table`, `onchange_field`, `onchange_set_field`, `change_row_field`, `equation`, `is_sum` FROM `master_detail_form_details2`";
  $result1 = $db->query($query1);

  while ($row = $result1->fetch_assoc()) {
      $column = [
          'header' => $row['header'],
          'type' => $row['input_type'],
          'name' => $row['column_name'],
          'displayColumn' => $row['is_display_column'] ? 'true' : 'false',
      ];

      if ($row['input_type'] === 'dropdown') {
          $column['table'] = $row['data_table'];
          $column['valueField'] = $row['value_field'];
          $column['optionField'] = $row['option_field'];
          $column['onchangeTable'] = $row['onchange_table'];
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

function generateDynamicFooterFields($db) {
  // Fetch data from master_detail_form_details3 for $footerFields
  $footerFields = [];

  $query2 = "SELECT `id`, `label`, `column_name`, `input_type`, `is_display_field`, `change_row_field`, `equation` FROM `master_detail_form_details3`";
  $result2 = $db->query($query2);

  while ($row = $result2->fetch_assoc()) {
      $footerField = [
          'label' => $row['label'],
          'type' => $row['input_type'],
          'name' => $row['column_name'],
          'displayColumn' => $row['is_display_field'] ? 'true' : 'false',
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