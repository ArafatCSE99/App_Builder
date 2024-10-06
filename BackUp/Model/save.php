<?php 

include "../connection.php";

$sql=$_POST["sql"];


    if ($conn->query($sql) === TRUE) {
      echo "Data Successfully Saved ! ! !";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

?>