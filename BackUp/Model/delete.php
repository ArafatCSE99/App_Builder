<?php


include "../connection.php";

$deletedid=$_POST["deletedid"];
$tablename=$_POST["tablename"];


// Before Delete Execution .....................

if($tablename=="stock_branch")
{
  $sql = "SELECT purchaseid,productid,initial_purchase from stock_branch where id=$deletedid";
  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
  
        $purchaseid=$row["purchaseid"];
        $productid=$row["productid"];
        $qty=$row["initial_purchase"];
        $sqls="update stock_warehouse set current_stock=current_stock+$qty where purchaseid=$purchaseid and productid=$productid";
        if ($conn->query($sqls) === TRUE) {
          //echo "Record deleted successfully";
        } else {
          //echo "Error deleting record: " . $conn->error;
        }  
      
    }
  } else {
    
  }
}


if($tablename=="purchase_detail")
{
   // update stock ..................
  $sqls="delete from stock_warehouse where purchaseid=(select purchaseid from purchase_detail where id=$deletedid) and productid=(select productid from purchase_detail where id=$deletedid) ";
  if ($conn->query($sqls) === TRUE) {
    //echo "Record deleted successfully";
  } else {
    //echo "Error deleting record: " . $conn->error;
  } 
}


if($tablename=="sales_detail"){

  // update stock .................................

$sql = "SELECT b.stockid,b.quantity,a.sales_from FROM sales_master a,sales_detail b where a.id=b.salesid and b.id=$deletedid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {

      $stock_table=$row["sales_from"]==1?"stock_branch":"stock_warehouse";
      $stockid=$row["stockid"];
      $qty=$row["quantity"];
      $sqls="update $stock_table set current_stock=current_stock+$qty where id=$stockid";
      if ($conn->query($sqls) === TRUE) {
        //echo "Record deleted successfully";
      } else {
        //echo "Error deleting record: " . $conn->error;
      }  
    
  }
} else {
  
}

}

// sql to delete a record
if($tablename=='subcategory')
{
    $sql = "DELETE FROM $tablename WHERE subcategoryid=$deletedid";
}
else{
$sql = "DELETE FROM $tablename WHERE id=$deletedid";
}

if ($conn->query($sql) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
}


?>