<?php

include "../connection.php"; 
include "../Classes/DynamicDetailClass.php";

$columns = [
    ['header' => 'Project', 'type' => 'dropdown', 'name' => 'project_id', 'table' => 'project','valueField'=>'id','optionField'=>'name'],
    ['header' => 'Hours', 'type' => 'number', 'name' => 'hours'],
    ['header' => 'Client', 'type' => 'textbox', 'name' => 'client_name'],
  ];
  
  // Fetch previous data if available
  $previousData = []; // Get this data as per your logic
  
  // Define number of rows to be initially displayed
  $rowCount = 1;
  
  // Define columns that need sum functionality
  $sumColumns = ['hours'];
  
  // Footer fields like Total, Paid, and Due
  $footerFields = [
    ['label' => 'Total Hours', 'type' => 'text', 'name' => 'total_hours']
  ];
  
$dynamicDetail = new DynamicDetailClass($master_conn);
$masterIdField='employee_id';
$masterIdValue=$_POST["id"];
$previousData = $dynamicDetail->getDetailData('employees_project_detail', $columns, $masterIdField, $masterIdValue);
echo $dynamicDetail->createDetailTable($columns, $previousData, $rowCount, $sumColumns, true, $footerFields);

?>