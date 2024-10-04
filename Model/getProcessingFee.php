<?php 

include "../connection.php";


//session_start(); 

$userid=$_SESSION["userid"];
$id=$_POST["productid"];

// Get Product  .......
$sqlc = "SELECT a.*,b.processing_fee FROM product a,category b where a.categoryid=b.id and a.userid=$userid and a.id=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    
    echo $rowc["processing_fee"];
    
  }
} else {
    
    echo 0;
}


?>