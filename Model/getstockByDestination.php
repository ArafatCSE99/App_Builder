<?php 

include "../connection.php";

$id=$_POST["stockid"];
$des=$_POST["des"];


$current_stock=0;
if($des=="1"){
  $table="stock_branch";
}
else{
  $table="stock_warehouse";
}

$sqlc = "SELECT * FROM $table where id=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $current_stock=$rowc["current_stock"];
  }
} else {
 
}
echo $current_stock;

?>