<?php

include "../connection.php";


//session_start(); 

$userid=$_SESSION["userid"];

// Content  ......................................................

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Role Permission</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Permission</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


<div class="form-group" style="margin-left:20px;">
  <label for="category">Role</label>
  <?php
$sqlsem = "SELECT * FROM roles where userid=$userid";
$resultse = $conn->query($sqlsem);
echo "<select onchange='getRolePermission()' style='width:40%' class='form-control' id='roles' name='roles' required>";
echo "<option hidden='' value=''>--Select Role --</option>";
if ($resultse->num_rows > 0) {
while($rowse = $resultse->fetch_assoc()) {
$up_name=$rowse["name"];
$upid=$rowse["id"];
echo  "<option value='$upid'>".$up_name."</option>";
}
} else {
echo  "<option >None</option>";
}
echo " </select>";
?>
</div>

    <!-- Table -->  
    
    <section class="content">
      
       
    </section>

    <!-- End Table -->



</div>
