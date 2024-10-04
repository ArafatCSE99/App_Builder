<?php 

include "../connection.php";

$id=$_POST["productid"];

$purchase_price=0;
$sales_price=0;
$priceid=0;
// Get Product Price .......
$sqlc = "SELECT * FROM price_manager where productid=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $priceid=$rowc["id"];
    $purchase_price=$rowc["purchase_price"];
    $sales_price=$rowc["sales_price"];
  }
} else {
 
}

echo $sales_price;

?>