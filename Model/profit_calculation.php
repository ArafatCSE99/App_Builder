<?php
// Calculate Profit .............

//echo "<script>alert('hello');</script>";

$total_price=$row["total_price"];
$due=$row["due"];
$masterid=$row["id"];
$sales_from=$row["sales_from"];
$total_profit=0;
$cash_profit=0;
$due_profit=0;
$profit_view="";
$sales_branch=$row["branchid"];

$totalpay=0;
$pay_count=0;

$sqlp = "SELECT * FROM sales_payment where salesid=$masterid";
$resultp = $conn->query($sqlp);

if ($resultp->num_rows > 0) {

  while($rowp = $resultp->fetch_assoc()) {
    $totalpay=$totalpay+$rowp["amount"];
    $pay_count++;
  }

}

$paid=$row["paid"];//+$totalpay;
$due=$row["due"]-$totalpay;

$sqls = "SELECT * FROM sales_detail where salesid=$masterid";
$results = $conn->query($sqls);
if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {  // All Sales Detail loop 
    $sales_detailid=$rows["id"];
    $quantity=$rows["quantity"];
    $unitprice=$rows["unitprice"]-($rows["discount"]/$quantity);
    $productid=$rows["productid"];
 
   

      // Find Product Purchase Unit Price ................ 
$purchase_unitprice=0;
$sqlsp = "SELECT avg(unitprice) as unitprice  FROM purchase_detail where productid=$productid 
    and purchaseid in (select purchaseid from stock_branch where id in (select stockid from sales_detail where id=$sales_detailid) )";
if($sales_from==2)
{
    $sqlsp = "SELECT avg(unitprice) as unitprice  FROM purchase_detail where productid=$productid 
    and purchaseid in (select purchaseid from stock_warehouse where id in (select stockid from sales_detail where id=$sales_detailid) )";
}
$resultsp = $conn->query($sqlsp);

if ($resultsp->num_rows > 0) {
  // output data of each row
  while($rowsp = $resultsp->fetch_assoc()) {
    $purchase_unitprice=$rowsp["unitprice"];
  }
}
else
{
    //echo "0 result";
    $purchase_unitprice=0;
}

  // End .............................
  
  // Find Product Purchase Unit Price NEW ................ 
/*
$_total_price=0;
$_total_stock=0;

$sqlsp = "SELECT a.id as purchaseid,b.unitprice,a.purchase_date  FROM purchase_detail b,purchase_master a where a.id=b.purchaseid and productid=$productid and a.purchase_date<='$sales_date'";  
//echo $sqlsp;
$resultsp = $conn->query($sqlsp);

if ($resultsp->num_rows > 0) {
  // output data of each row
  while($rowsp = $resultsp->fetch_assoc()) {
    $_purchaseid=$rowsp["purchaseid"];
    $_unitprice=$rowsp["unitprice"];
    $_purchase_date=$rowsp["purchase_date"];

// Find Current Stock .................
$_current_stock=0;    
$_purchase_qty=0; 

$sqlsq = "SELECT initial_purchase as purchase_qty ,id as stockid from stock_branch where purchaseid=$_purchaseid and branchid=$sales_branch and productid=$productid and created_at<='$sales_date'";
if($sales_from==2)
{
   $sqlsq = "SELECT initial_purchase as purchase_qty ,id as stockid from stock_warehouse where purchaseid=$_purchaseid and productid=$productid "; 
}
//echo $sqlsq;
$resultsq = $conn->query($sqlsq);

if ($resultsq->num_rows > 0) {
  // output data of each row
  while($rowsq = $resultsq->fetch_assoc()) {
      $_purchase_qty=$rowsq["purchase_qty"];
      $_stockid=$rowsq["stockid"];
      
// Find All Sales ...............
$_sales_quantity=0;
$sqlsr = "SELECT sum(b.quantity) As quantity FROM sales_detail b,sales_master a where a.id=b.salesid and a.sales_date<='$sales_date' and a.id!=$masterid and b.stockid=$_stockid and a.sales_from=$sales_from";
//echo $sqlsr;
$resultsr = $conn->query($sqlsr);

if ($resultsr->num_rows > 0) {
  // output data of each row
  while($rowsr = $resultsr->fetch_assoc()) {
    $_sales_quantity=$rowsr["quantity"];
  }
}
    
       // Find Transfer .............
$_transfer_quantity=0;

$sqlsr = "SELECT sum(initial_purchase) as transfer_qty ,id as stockid from stock_branch where purchaseid=$_purchaseid  and productid=$productid and created_at<='$sales_date'";

//echo $sqlsr;
$resultsr = $conn->query($sqlsr);

if ($resultsr->num_rows > 0) {
  // output data of each row
  while($rowsr = $resultsr->fetch_assoc()) {
    $_transfer_quantity=$rowsr["transfer_qty"];
  }
}

if($_transfer_quantity=="")
{
    $_transfer_quantity=0;
}

      // End Sales ...................
     // echo $_current_stock." ".$_purchase_qty." ".$_sales_quantity." ".$_transfer_quantity."<br>";
      if($sales_from==2){
           $_current_stock+=$_purchase_qty-$_sales_quantity-$_transfer_quantity;
      }
      else{
           $_current_stock+=$_purchase_qty-$_sales_quantity;
      }
      if($_current_stock<0 )
      {
        $_current_stock=0;  
      }
      
  }
}
// End Currenct Stock ....................    
    
    $_total_price+=$_unitprice*$_current_stock;
    $_total_stock+=$_current_stock;
    
    if($_current_stock>0 || 1==1){
    $profit_view.="Purchase Date : ".$_purchase_date." Purchase UnitPrice : ".$_unitprice." Qty : ".$_purchase_qty." Stock Before This Sale : ".$_current_stock."\n";
    }
    
    
  }
}


if($_total_stock>0){
$purchase_unitprice=$_total_price/$_total_stock;
}
else
{
   $purchase_unitprice= $unitprice;
}


$profit_view.="Total Price : ".$_total_price." Total Stock : ".$_total_stock."\n";


// End Product Purchase Unit Price NEW ................ 
*/   
    $unit_profit=  $unitprice-$purchase_unitprice;
    $this_profit=($unit_profit*$quantity);
    $total_profit=$total_profit+($unit_profit*$quantity);
    
    $profit_view.="Purchase Price : ".$purchase_unitprice." Sales Price : ".$unitprice." Sale Qty : ".$quantity." Profit : ".$this_profit."\n";
    
  }
} else {
  echo "0 results";
}

// End Profit Calculation ...........................
$original_profit=$total_profit;
$total_profit=$total_profit-$row["discount"];

$profit_view.="Total Profit : ".$original_profit." Discount : ".$row["discount"]." Net Profit : ".$total_profit."\n";

$cash_profit=($total_profit/$total_price)*$paid;
if($due>0)
{
   $due_profit=($total_profit/$total_price)*$due;
}

// End Calculate Profit .........
?>