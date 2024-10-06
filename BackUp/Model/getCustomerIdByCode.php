<?php 

include "../connection.php";
session_start();
$userid=$_SESSION["userid"];

$code=$_POST["code"];

// Get Product Price .......
$sqlc = "SELECT * FROM customer where userid=$userid";
$resultc = $conn->query($sqlc);

$custid=0;
$sl=0;
if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $sl++;
    if($sl==$code){
    $custid=$rowc["id"];
    }
    
  }
} else {
 
}

echo $custid;

?>