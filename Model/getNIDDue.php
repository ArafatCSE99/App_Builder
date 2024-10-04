<?php 

include "../connection.php";

$type=$_POST["type"];
$nid=$_POST["nid"];

$due=0;

// Get Previous_due .......
if($type==1){
  $sqlc = "SELECT sum(due) as due FROM sales_master where cnid='$nid'";
}
else
{
  $sqlc = "SELECT sum(due) as due FROM sales_master where rnid='$nid'"; 
}
//echo $sqlc;
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $due=$rowc["due"];
  }
} else {
 $due=0;
}

if($due==""){
  $due=0;
}

echo $due;

?>