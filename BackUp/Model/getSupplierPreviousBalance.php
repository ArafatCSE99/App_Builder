<?php

session_start(); 

$bank_accountid=$_POST["bank_accountid"];

$total_balance=0;

include "../connection.php";
$sqlsem = "SELECT * FROM bank_transaction where bank_accountid=$bank_accountid order by id desc limit 1";
$resultse = $conn->query($sqlsem);

if ($resultse->num_rows > 0) {
	
    while($rowse = $resultse->fetch_assoc()) {

	   $total_balance=$rowse["current_balance"];
	   
    }

} else {
   
   
    // Get Starting Amount . . . .

$sqlsema = "SELECT * FROM bank_account where id=$bank_accountid";
$resultsea = $conn->query($sqlsema);

if ($resultsea->num_rows > 0) {

    while($rowsea = $resultsea->fetch_assoc()) {
        $total_balance=$rowsea["starting_amount"];
    }

}

// . . . . . . . . . . . . . . . . .


}
		
echo $total_balance;

$conn->close();

?>