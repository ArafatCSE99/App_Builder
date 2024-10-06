<?php 

include "../connection.php";

session_start(); 
$userid=$_SESSION["userid"];
$roleid=$_POST["roleid"];
$featureid=$_POST["featureid"];
$field=$_POST["field"];
$flag=$_POST["flag"];

$count=0;
$sql = "SELECT roleid FROM role_permissions where roleid=$roleid and featureid=$featureid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $count++;
  }
} else {
  $count=0;
}

if($count>0)
{
  $sql="UPDATE role_permissions SET $field=$flag where roleid=$roleid and featureid=$featureid";

}
else{
  $sql="INSERT INTO role_permissions (roleid, featureid, $field)
  VALUES ($roleid,$featureid,$flag)";
}

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

?>



