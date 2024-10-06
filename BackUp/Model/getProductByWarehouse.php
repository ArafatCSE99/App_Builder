<?php

include "../connection.php";

session_start(); 

$userid=$_SESSION["userid"];
$companyid=$_SESSION["companyid"];
$branchid=$_SESSION["branchid"];

$warehouseid=$_POST["warehouseid"];


$sqlsem = "SELECT a.*,b.current_stock,b.id as stockid,c.name as warehousename FROM product a,stock_warehouse b,warehouse c  where a.id=b.productid and b.warehouseid=c.id and b.current_stock>0 and a.userid=$userid and a.companyid=$companyid and b.warehouseid=$warehouseid";
$resultse = $conn->query($sqlsem);

//echo $sqlsem;

echo "<option hidden='' value=''>--Select Model--</option>";

if ($resultse->num_rows > 0) {

while($rowse = $resultse->fetch_assoc()) {

$up_name=$rowse["name"];
$upid=$rowse["id"];
$model=$rowse["model"];
$stockid=$rowse["stockid"];
$current_stock=$rowse["current_stock"];
$warehousename=$rowse["warehousename"];

$sqla = "Select round( (Sum(unitprice*current_stock)/Sum(current_stock) ),2) as avgprice from ( Select a.unitprice,b.current_stock from purchase_detail a, stock_warehouse b where a.purchaseid=b.purchaseid and a.productid=b.productid and b.current_stock>0 and a.productid=$upid ) NewT";
  $result = $conn->query($sqla);
  
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $avg_price= $row["avgprice"];
    }
  } else {
    $avg_price= 0;
  }

echo  "<option value='$stockid'>".$up_name." [B-".$stockid." Q-".$current_stock." W-".$warehousename."] [".$avg_price."]</option>";



}

} else {

echo  "<option >None</option>";

}


?>