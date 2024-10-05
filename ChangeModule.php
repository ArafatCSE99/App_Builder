<?php
include "connection.php";
session_start(); 
$userid=$_SESSION["userid"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mkrow | Modules</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  
<style>
.Gradient4
{

background: linear-gradient(to right, #33cccc 0%, #66ffcc 100%);
color:white;

}
</style>
  
</head>
<body class="hold-transition login-page" style="background-image: url('dist/img/Design/background.png'); ">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary" >
    <div class="card-header text-center Gradient4" style=" color:white">
      <a href="index2.html" class="h1"><b>Mkrow</b> ERP</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Select Company Branch and Module</p>

      <form action="ChangeModulePost.php" method="post">
        <div class="input-group mb-3">
          <select class="form-control" name="companyid" id="companyid" onchange="getBranch()" required>
            <!-- <option hidden="" value="">Select Company</option> -->
            <?php
            $sql = "SELECT id,name FROM companies where user_id='$userid' and is_active=1";
            $result = $master_conn->query($sql);
            $validatuser=0;
            if ($result->num_rows > 0) {
              // output data of each row
              while($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $name = $row["name"];
                echo "<option value=$id>".$name."</option>";
              }
            } 
            ?>
          </select>
        </div>

        <div class="input-group mb-3">
          <select class="form-control" name="branchid" id="branchid" required>
            <option hidden="" value="">Select Branch</option>
          </select>
        </div>

        <div class="input-group mb-3">
          <select class="form-control" name="moduleid" required>
            <option hidden="" value="">Select Module</option>
            <?php
            $sql = "SELECT id,name FROM modules where id in (select module_id from user_wise_modules where user_id=$userid) ";
            echo $sql;
            $result = $master_conn->query($sql);
            $validatuser=0;
            if ($result->num_rows > 0) {
              // output data of each row
              while($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $name = $row["name"];
                echo "<option value=$id>".$name."</option>";
              }
            } 
            ?>
          </select>
        </div>

        <div class="input-group mb-3">
         
        </div>
        <div class="row">
          <div class="col-8">
          
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Get In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="login.html">Log Out</a>
      </p>
      <p class="mb-0">
       <!-- <a href="#" class="text-center">Register a new membership</a> -->
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
<script>
  
var Param="";

function getDropDownListByTableField(table,field,getFromId,SetToId,name)
{
var fieldValue=document.getElementById(getFromId).value;
var dataString = 'table='+table+'&field='+field+'&fieldValue=' + fieldValue+'&name='+name+'&Param='+Param;
// AJAX code to submit form.
$.ajax({
type: "POST",
url: "Model/getDropDownListByTableField.php",
data: dataString,
cache: false,
async:false,
success: function(html) {
 document.getElementById(SetToId).innerHTML = html;
 Param="";
}
});
}

function getBranch()
{
  getDropDownListByTableField('branches','company_id','companyid','branchid','Branch');
}

getBranch();
</script>