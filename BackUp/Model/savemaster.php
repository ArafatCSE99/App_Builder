<?php 

include "../connection.php";

$sql=$_POST["sql"];
$returnsql=$_POST["returnsql"];

if($returnsql=="Sales")
{
      $returnsql="SELECT max(id) as id FROM sales_master WHERE userid=1";
}
else if($returnsql=="stock_transfer")
{
      $returnsql="SELECT max(id) as id FROM stock_transfer_master WHERE userid=1";
}
else if($returnsql=="Product")
{
      $returnsql="SELECT max(id) as id FROM product WHERE userid=1";
}
else if($returnsql=="Customer")
{
      $returnsql="SELECT max(id) as id FROM customer WHERE userid=1";
}
else
{
    $returnsql="SELECT max(id) as id FROM purchase_master WHERE userid=1";
}


    if ($conn->query($sql) === TRUE) {
           
      $results = $conn->query($returnsql);     
      if ($results->num_rows > 0) {
        // output data of each row
        while($rows = $results->fetch_assoc()) {
         echo $rows["id"];
        }
      } else {
        echo "0 results";
      }


    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    


?>