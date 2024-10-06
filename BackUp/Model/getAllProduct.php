<?php 

include "../connection.php";


session_start(); 

$userid=$_SESSION["userid"];


// Get Product  .......
$sqlc = "SELECT * FROM product where userid=$userid";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $proid=$rowc["id"];
    $procode=$rowc["code"];
    $pronm=$rowc["name"];
    $proself=$rowc["self"];

    $return_arr[] = array("proid" => $proid,
    "procode" => $procode,
    "pronm" => $pronm,
    "proself" => $proself);

    

    
  }
} else {
 
}

echo json_encode($return_arr);


?>