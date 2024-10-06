<?php

session_start(); 

$branchid=$_POST["branchid"];

$total_balance=0;

include "../connection.php";
$sqlsem = "SELECT * FROM app_branch_account where branchid=$branchid order by id desc limit 1";
$resultse = $conn->query($sqlsem);

if ($resultse->num_rows > 0) {
	
    while($rowse = $resultse->fetch_assoc()) {

	   $total_balance=$rowse["balance"];
	   
    }

} else {
   
   
    // Get Starting Amount . . . .
/*
$sqlsema = "SELECT * FROM branch where id=$branchid";
$resultsea = $conn->query($sqlsema);

if ($resultsea->num_rows > 0) {

    while($rowsea = $resultsea->fetch_assoc()) {
        $total_balance=$rowsea["opening_due"];
    }

}
*/

$total_balance=0;
// . . . . . . . . . . . . . . . . .


}
		
echo $total_balance;

$conn->close();

?>