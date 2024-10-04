<?php 

include "../connection.php";

//session_start(); 
$userid=$_SESSION["userid"];
$subuserid=$_SESSION["subuserid"];
$file_name=$_POST["file_name"];

$roleid=0;
$featureid=0;
//$username=="";

$sqlr = "SELECT roleid FROM subuser where id=$subuserid";
$resultr = $master_conn->query($sqlr);
if ($resultr->num_rows > 0) {
  while($rowr = $resultr->fetch_assoc()) {
    $roleid=$rowr["roleid"];
    //$username=$rowr["user_name"];
  }
}

$sqlr = "SELECT * FROM `features` where `file_name`='$file_name' and userid=$userid";
$resultr = $conn->query($sqlr);
if ($resultr->num_rows > 0) {
  while($rowr = $resultr->fetch_assoc()) {
    $featureid=$rowr["id"];
  }
}

$sqlr = "SELECT * FROM role_permissions where roleid=$roleid and featureid=$featureid";
//echo $sqlr;
$resultr = $conn->query($sqlr);

if ($resultr->num_rows > 0) {
  // output data of each row
  while($rowr = $resultr->fetch_assoc()) {
    $view=$rowr["is_view"];
    $add=$rowr["is_add"];
    $edit=$rowr["is_edit"];
    $delete=$rowr["is_delete"];

    $return_arr[] = array("view_permission" => $view,
    "add_permission" => $add,
    "edit_permission" => $edit,
    "delete_permission" => $delete); 
  }
} else {
    
    
  $view="0";
  $add="0";
  $edit="0";
  $delete="0";
  
  if($subuserid==7 && ($file_name=="Advance_Installment_report" || $file_name=="expense_report") ){
     $view="1";
     $add="1";
     $edit="1";
     $delete="1"; 
  }

  $return_arr[] = array("view_permission" => $view,
    "add_permission" => $add,
    "edit_permission" => $edit,
    "delete_permission" => $delete); 
}


echo json_encode($return_arr);

?>