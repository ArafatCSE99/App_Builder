<?php


include "../connection.php";

$deletedid=$_POST["deletedid"];
$tablename=$_POST["tablename"];

// sql to delete a record
$sql = "DELETE FROM $tablename WHERE id=$deletedid";

if ($master_conn->query($sql) === TRUE) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . $master_conn->error;
}


?>