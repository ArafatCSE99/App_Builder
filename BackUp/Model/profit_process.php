
<?php


session_start(); 

include "../connection.php";

$userid=$_SESSION["userid"];
$companyid=$_SESSION["companyid"];
$branchid=$_SESSION["branchid"];
//$sales_id=1712;//$_POST["masterid"];


$data=0;    
$sql = "SELECT a.total_price,a.due,a.id,a.branchid,a.sales_from,a.paid,a.due,a.discount,a.sales_date FROM sales_master a, sales_detail b where a.id=b.salesid and a.userid=$userid and a.companyid=$companyid and a.total_cash_profit=0 and a.total_due_profit=0";
//echo $sql;
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
      
      $sales_date=$row["sales_date"];
      
      include "profit_calculation.php"; 
      
   
      //echo "Cash ".$cash_profit;
      //echo "Due ".$due_profit;
      //echo $profit_view;
      
$sqli = "update sales_master set total_cash_profit=$cash_profit,total_due_profit=$due_profit,profit_view='$profit_view' where id=$masterid";

if ($conn->query($sqli) === TRUE) {
  //echo "New record created successfully";
} else {
  //echo "Error: " . $sql . "<br>" . $conn->error;
}
   
   
  }
} else {
  $data=0;
}