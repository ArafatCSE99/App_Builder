<?php

include "../connection.php";

session_start(); 

$userid=$_SESSION["userid"];
$companyid=$_SESSION["companyid"];
$branchid=$_SESSION["branchid"];
// Content  ......................................................

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Employees</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Employee</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>





    <!-- Table -->   
    <section class="content">
      <div class="row">
        <div class="col-md-12">

    <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title" >List of Employees</h3>
                <a href="#add"><span style="float:right; cursor:pointer;">Add New</span></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow:auto;">
                <table id="example1" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Mobile No</th>
                    <th>Joining Date</th>
                    <th>Salary</th>
                    <th>Address</th>
                    <th style='text-align:center;'>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

$sql = "SELECT * FROM employee where userid=$userid and companyid=$companyid";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $name=$row["name"];
    if($row["image"]!="")
    {
      $imageurl="imageUpload/uploads/".$row["image"];

    }
    else{
      $imageurl="dist/img/global_logo.png";
    }
    $designationid=$row["designationid"];
    $designationname="";
$sqlc = "SELECT * FROM designation where id=$designationid";
$resultc = $conn->query($sqlc);
if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $designationname=$rowc["name"];
  }
}

    $departmentid=$row["departmentid"];
    $departmentname="";
$sqlc = "SELECT * FROM department where id=$departmentid";
$resultc = $conn->query($sqlc);
if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $departmentname=$rowc["name"];
  }
}
     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='code'>".$row['employeeid']."</td>"; 
     echo "<td class='name'>".$name."</td>"; 
     echo "<td class='image'><img src=$imageurl height='50px' width='50px'></td>"; 
     echo "<td class='department'>".$departmentname."</td>"; 
     echo "<td class='designation'>".$designationname."</td>"; 
     echo "<td class='mobile_no'>".$row['mobile_no']."</td>"; 
     echo "<td class='joining_date'>".$row['joining_date']."</td>"; 
     echo "<td class='salary'>".$row['salary']."</td>"; 
     echo "<td class='address'>".$row['address']."</td>";
     echo "<td class='text-center py-0 align-middle' style='text-align:center;'>
                      <div class='btn-group btn-group-sm'>
                        <a onclick='updatedata($id,this)' class='btn btn-info'><i class='fas fa-edit'></i></a>
                        <a onclick=deletedata($id,this,'employee') class='btn btn-danger'><i class='fas fa-trash'></i></a>
                      </div>
                    </td>";
     echo "</tr>";
      

  }
} else {
  
}
                ?>
                  
                </tbody></table>
              </div>
              <!-- /.card-body -->
            </div>

            </div>
        
        </div>
       
      </section>

    <!-- End Table -->



<!-- Main content -->
<section class="content" id="add">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Employee</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">

  <div class="row">


  <div class="col-sm-4">
  
  <input type="hidden" name="employeeid" id="employeeid"  value="0">   

<div class="form-group">
  <label for="category">Employee Code</label>
  <input type="text" id="code" name="code" style="width:80%" class="form-control" placeholder="Employee Code">
</div>

<div class="form-group">
  <label for="category">Employee Name</label>
  <input type="text" id="name" name="name" style="width:80%" class="form-control" placeholder="Employee Name">
</div>


<div class="form-group">
  <label for="category">Departmeny</label>
  <?php
$sqlsem = "SELECT * FROM department where userid=$userid and companyid=$companyid";
$resultse = $conn->query($sqlsem);
echo "<select style='width:80%' class='form-control' id='department' name='department' required>";
echo "<option hidden='' value=''>--Select department--</option>";
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

<div class="form-group">
  <label for="category">Designation</label>
  <?php
$sqlsem = "SELECT * FROM designation where userid=$userid and companyid=$companyid";
$resultse = $conn->query($sqlsem);
echo "<select style='width:80%' class='form-control' id='designation' name='designation' required>";
echo "<option hidden='' value=''>--Select designation--</option>";
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

  
  </div>



  <div class="col-sm-4">
  
             
             <div class="form-group">
                <label for="">Joining Date</label>
                <input type="date" id="joining_date" name="joining_date" style="width:80%" class="form-control" placeholder="Joining Date">
              </div>
              
              <div class="form-group">
                <label for="category">Salary</label>
                <input type="number" id="salary" name="salary" style="width:80%" class="form-control" placeholder="Salary">
              </div>
  
             <div class="form-group">
                <label for="category">Mobile No</label>
                <input type="text" id="mobile_no" name="mobile_no" style="width:80%" class="form-control" placeholder="Mobile No">
              </div>

              <div class="form-group">
                <label for="">Address</label>
                <input type="text" id="address" name="address" style="width:80%" class="form-control" placeholder="Address">
              </div>
  
              
            
  </div>


  <div class="col-sm-4">
  
            

  <form method="post" id="image-form" enctype="multipart/form-data" onSubmit="return false;">
				<div class="form-group">
					<input type="file" name="file" class="file">
					<div class="input-group my-3" style="width:350px;">
						<input type="text" style="width:20px; display:none;" class="form-control" disabled placeholder="Upload Employee Image" id="file">
						<div class="input-group-append">
							<button type="button" style="display:none;" class="browse btn btn-primary">Browse...</button>
						</div>
					</div>
				</div>

      <div class="form-group">
       
					<img src="dist/img/global_logo.png" height="400px;" width="150px;" id="preview" class="img-thumbnail">
			
      </div>

				<div class="form-group">
					<input type="submit" name="submit" value="Upload" style="display:none;" class="btn btn-danger">
				</div>
    </form>

  
  
  </div>


  
</div>



      
        <br>
        <input type="button" onclick="savedata()" class="btn btn-success float-left" value="Save" name="image_upload" id="image_upload" class="btn"/>
        
      

        <!-- for image upload -->

                             
              
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        
      </div>
     
    </section>
    <!-- /.content -->





    

</div>
