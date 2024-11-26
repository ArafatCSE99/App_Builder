<html>

<head>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
    <?php
include "connection.php";
session_start(); 
$_SESSION["companyid"]=$_POST["companyid"];
$_SESSION["branchid"]=$_POST["branchid"];
$_SESSION["moduleid"]=$_POST["moduleid"];
$moduleid=$_POST["moduleid"];

// Check .......................................................
$sql = "SELECT short_name FROM modules where id='$moduleid' ";
$result = $master_conn->query($sql);
$validatuser=0;
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $_SESSION["module_short_name"] = $row["short_name"];
    $validatuser=1;
  }
}
// Redirect .......................................................
if($validatuser==1)
{
echo "<script>
window.location.href='home.php';
</script>";
}
else{

}

?>
</body>

</html>