<?php 

include "../connection.php";

session_start(); 

$userid=$_SESSION["userid"];

$code=$_POST["code"];

// Get Product Price .......
$sqlc = "SELECT * FROM product where code='$code' and userid=$userid";
$resultc = $conn->query($sqlc);

$proid=0;

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $proid=$rowc["id"];
    
  }
} else {
 
}

echo $proid;

?>