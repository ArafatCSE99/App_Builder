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
            <h1>Change Password</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Change Password</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


     
<!-- Main content -->
<section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Change Password</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">


    <?php

    // Get Shop Data ...............................................

    $Old_Password="";
   
    $insertupdateid=0;
 
$sql = "SELECT * FROM users where id=$userid";
$result = $master_conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    
    $Old_Password=$row["password"];
    $insertupdateid=$row["id"];

  }
} else {
  

}


    ?>



            <div class="row">

    <div class="col-sm-4">


              <input type="hidden" id="insertupdateid" value="<?php echo $insertupdateid ?>">
              <input type="hidden" id="OldPassword" value="<?php echo $Old_Password ?>">
              
 
             <div class="form-group">
                <label for="name">Old Password</label>
                <input type="password" id="OldPass" style="width:90%" class="form-control" value="" placeholder="Old Password">
              </div>

 
              <div class="form-group">
                <label for="name">New Password</label>
                <input type="password" id="NewPassword" style="width:90%" class="form-control" value="" placeholder="New Password">
              </div>
              
           
</div>



</div> 


<input type="button" onclick="savedata()"  value="Save" class="btn btn-success float-left">
              
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        
      </div>
     
    </section>
    <!-- /.content -->



</div>
