<?php

session_start(); 

$customerid=$_POST["customerid"];

$total_balance=0;

include "../connection.php";
$sqlsem = "SELECT * FROM app_customer_account where customerid=$customerid order by id desc limit 1";
$resultse = $conn->query($sqlsem);

if ($resultse->num_rows > 0) {
	
    while($rowse = $resultse->fetch_assoc()) {

	   $total_balance=$rowse["balance"];
	   
    }

} else {
   
   
    // Get Starting Amount . . . .

$sqlsema = "SELECT * FROM customer where id=$customerid";
$resultsea = $conn->query($sqlsema);

if ($resultsea->num_rows > 0) {

    while($rowsea = $resultsea->fetch_assoc()) {
        $total_balance=$rowsea["opening_due"];
    }

}

// . . . . . . . . . . . . . . . . .


}
		
echo $total_balance;

$conn->close();

?>