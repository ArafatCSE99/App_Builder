<?php


$did=$_POST["did"];


session_start(); 

include "../connection.php";

$sqlsem = "SELECT * FROM districts where division_id=$did";

$resultse = $conn->query($sqlsem);

echo "<option hidden='' value=''>--Select District--</option>";

if ($resultse->num_rows > 0) {
   
    while($rowse = $resultse->fetch_assoc()) {
       	   
       $up_name=$rowse["name"];
       $bn_name=$rowse["bn_name"];
	    $upid=$rowse["id"];
	   	   
	  echo  "<option value='$upid'>".$up_name."</option>";
	   	
	   
    }
	
	
} else {
   
   echo  "<option >None</option>";
   
}
		


$conn->close();

?>