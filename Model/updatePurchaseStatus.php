<?php 

include "../connection.php";

session_start(); 
$userid=$_SESSION["userid"];
$id=$_POST["id"];

  $sql="UPDATE purchase_master SET status='Approved' where id=$id";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}


$branchid=0;
$warehouseid=0;
$companyid=0;
$sql = "SELECT * FROM purchase_master where id=$id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $branchid=$row["branchid"];
     $warehouseid=$row["warehouseid"];
     $companyid=$row["companyid"];
  }
} else {
  $branchid=0;
}


if($branchid==0)
{
    $sql="INSERT INTO stock_warehouse (purchaseid,userid, companyid, warehouseid, productid, initial_purchase, current_stock) Select purchaseid,userid,$companyid,$warehouseid,productid,quantity,quantity from purchase_detail where purchaseid=$id";
    
if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
    
}
else
{
    $sql="INSERT INTO stock_branch (purchaseid,userid, companyid, branchid, productid, initial_purchase, current_stock) Select purchaseid,userid,$companyid,$branchid,productid,quantity,quantity from purchase_detail where purchaseid=$id";
    
if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

}

?>



