<?php


include "../connection.php";

$deletedid=$_POST["deletedid"];
$tablename=$_POST["tablename"];
$detailtablename=$_POST["detailtablename"];
$masteridname=$_POST["masteridname"];


if($tablename=="sales_master"){

  // update stock .................................

$sql = "SELECT b.stockid,b.quantity,a.sales_from FROM sales_master a,sales_detail b where a.id=b.salesid and a.id=$deletedid";
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
if($tablename=="stock_transfer_master"){

  // update stock .................................

$sql = "SELECT b.stockid,b.quantity,a.sales_from FROM stock_transfer_master a,stock_transfer_detail b where a.id=b.salesid and a.id=$deletedid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {

      $stock_table="stock_warehouse";
      $stockid=$row["stockid"];
      $qty=$row["quantity"];
      $sqls="update $stock_table set current_stock=current_stock+$qty where id=$stockid";
      if ($conn->query($sqls) === TRUE) {
        //echo "Record deleted successfully";
      } else {
        //echo "Error deleting record: " . $conn->error;
      } 
      
      //.................................
      
       $sqls="Delete from stock_branch  where stock_transfer_masterid=$deletedid";
      if ($conn->query($sqls) === TRUE) {
        //echo "Record deleted successfully";
      } else {
        //echo "Error deleting record: " . $conn->error;
      }  
      
      //.................................
    
  }
} else {
  
}

}

if($tablename=="purchase_master")
{
  // update stock ..................
  $sqls="delete from stock_warehouse where purchaseid=$deletedid";
  if ($conn->query($sqls) === TRUE) {
    //echo "Record deleted successfully";
  } else {
    //echo "Error deleting record: " . $conn->error;
  } 
  
  
  // update stock ..................
  $sqls="delete from stock_branch where purchaseid=$deletedid";
  if ($conn->query($sqls) === TRUE) {
    //echo "Record deleted successfully";
  } else {
    //echo "Error deleting record: " . $conn->error;
  } 
  
  
}


// sql to delete a record Detail 
$sql = "DELETE FROM $detailtablename WHERE $masteridname=$deletedid";

if ($conn->query($sql) === TRUE) {
  //echo "Record deleted successfully";
} else {
  //echo "Error deleting record: " . $conn->error;
}


// sql to delete a record master
$sql = "DELETE FROM $tablename WHERE id=$deletedid";

if ($conn->query($sql) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
}


?>