<?php 

include "../connection.php";

$id=$_POST["stock_warehouseid"];


$productid=0;
// Get Product Price .......
$sqlc = "SELECT * FROM stock_warehouse where id=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $productid=$rowc["productid"];
    
  }
} else {
 
}

echo $productid;

?>