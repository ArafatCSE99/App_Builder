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

?>