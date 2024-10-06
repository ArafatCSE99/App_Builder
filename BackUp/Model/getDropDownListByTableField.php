<?php

session_start(); 

$table=$_POST["table"];
$field=$_POST["field"];
$fieldValue=$_POST["fieldValue"];
$name=$_POST["name"];

$userid=$_SESSION["userid"];

if(isset($_POST["Param"]))
{
    $Param=$_POST["Param"];
}


include "../connection.php";

if($table=="branches")
{
    $subuser_branchid=0;
    if(isset($_SESSION["subuser_branchid"]))
    {
        $subuser_branchid=$_SESSION["subuser_branchid"];
    }
    $sqlsem = "SELECT * FROM $table where ($subuser_branchid=0 OR id=$subuser_branchid) and $field=$fieldValue  $Param";

}
else{
$sqlsem = "SELECT * FROM $table where $field=$fieldValue  $Param";
}
//echo $sqlsem;
$resultse = $master_conn->query($sqlsem);
 echo  "<option hidden='' value='' >Select $name</option>";
if ($resultse->num_rows > 0) {
    while($rowse = $resultse->fetch_assoc()) {  
	  $up_name=$rowse["name"];
      $upid=$rowse["id"];
	  echo  "<option value='$upid'>".$up_name."</option>";
    }

} else {
   echo  "<option value='0'>None</option>";
}
		
echo " </select>";

$master_conn->close();

?>