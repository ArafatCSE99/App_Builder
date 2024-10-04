<?php 

include "../connection.php";

$id=$_POST["productid"];



$previous_qty=0;
$stockid=0;
// Get Previous_Qty .......
$sqlc = "SELECT * FROM stock_manager where productid=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
   
    $stockid=$rowc["id"];
   // $previous_qty=$rowc["previous_qty"];
  }
} else {
 
}


$purchase_qty=0;

// Get purchase .......
$sqlc = "SELECT * FROM purchase_detail where productid=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
   
    $purchase_qty=$purchase_qty+$rowc["quantity"];
  }
} else {
 
}


$sales_qty=0;

// Get Sales .......
$sqlc = "SELECT * FROM sales_detail where productid=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
   
    $sales_qty=$sales_qty+$rowc["quantity"];
  }
} else {
 
}


$current_stock=($previous_qty+$purchase_qty)-$sales_qty;


echo $current_stock;

?>