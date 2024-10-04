<html>
<head>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
<?php
include "DB/connection.php";
$email=$_POST["email"];
$pass=$_POST["pass"];
//session_start(); 
$_SESSION["subuser_branchid"]=0;
// Check .......................................................
$sql = "SELECT id,name,is_active FROM users where email='$email' and password='$pass' ";
$result = $master_conn->query($sql);
$validatuser=2;
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $_SESSION["userid"] = $row["id"];
    $_SESSION["subuserid"] = 0;
    $_SESSION["username"] = $row["name"];
    $validatuser=$row["is_active"];
  }
} else {

$sqls = "SELECT * FROM subuser where user_name='$email' and password='$pass' ";
$results = $master_conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $_SESSION["userid"] = $rows["userid"];
    $_SESSION["subuserid"] = $rows["id"];
    $_SESSION["username"] = $rows["name"];
    $_SESSION["subuser_branchid"] = $rows["branchId"];
    $validatuser=1;
  }
}

  
}
// Redirect .......................................................
if($validatuser==1)
{
echo "<script>
window.location.href='ChangeModule.php';
</script>";
}
else if($validatuser==0)
{
  echo "<script>
  swal('Login Successfull !','User is not Active Yet !')
    .then((willDelete) => {
if (willDelete) {
window.location.href='login.html';
}
});
</script>";

}
else{

  
echo "<script>
  swal('Login Failed !','Wrong Email or Password ! Try Again ')
    .then((willDelete) => {
if (willDelete) {

window.location.href='login.html';
  
}
});
</script>";

}

?>
</body>
</html>