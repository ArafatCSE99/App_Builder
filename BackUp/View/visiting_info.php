<?php

include "../connection.php";

//session_start(); 

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
            <h1>visiting info</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">visiting info</li>
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
                <h3 class="card-title" >List of visiting info
                <button class='btn btn-primary' style='margin-left:10px;' onclick="getcontent('product_stock_price_Report')">View Product Stock Price</button>
                </h3>
                <a href="#add"><span style="float:right; cursor:pointer;">Add New</span></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow:auto;">
                <table id="example1" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Mobile No</th>
                    <th>Address</th>
                    <th>Reference Employee</th>
                    <th>Visiting Date</th>
                    <th>Note</th>
                  
                    <th style='text-align:center;'>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

$sql = "SELECT id,name,mobileno,address,reference,image,opening_due,month,employeeid,visiting_date,note FROM visiting_info where userid=$userid and companyid=$companyid and branchid=$branchid";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $name=$row["name"];
    $imageurl="";
    if($row["image"]!="")
    {
      $imageurl="imageUpload/uploads/".$row["image"];

    }
    
    $employeeid=$row["employeeid"];
    $departmentname="";
    $employeename="";
$sqlc = "SELECT * FROM employee where id=$employeeid";
$resultc = $conn->query($sqlc);
if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $employeename=$rowc["name"];
  }
}

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='name'>".$name."</td>"; 
     echo "<td class='image'><img src=$imageurl height='50px' width='50px'></td>"; 
     echo "<td class='mobileno'>".$row['mobileno']."</td>"; 
     echo "<td class='address'>".$row["address"]."</td>"; 
     echo "<td class='reference'>".$employeename."</td>"; 
     echo "<td class='visitng_date'>".$row['visiting_date']."</td>"; 
     echo "<td class='note'>".$row["note"]."</td>"; 
    
     echo "<td class='text-center py-0 align-middle' style='text-align:center;'>
                      <div class='btn-group btn-group-sm'>
                        <a onclick='updatedata($id,this)' class='btn btn-info'><i class='fas fa-edit'></i></a>";
                       
                        echo "<a onclick=deletedata($id,this,'visiting_info') class='btn btn-danger'><i class='fas fa-trash'></i></a>";
                        
                      echo "</div>
                    </td>";
     echo "</tr>";
      

  }
} else {
  
}
                ?>
                  
                </table>
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
              <h3 class="card-title">Add visiting info</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">

<div class="row">
    
    <div class="col-sm-8">

              <div class="form-group">
                <label for="category">Name</label>
                <input type="text" id="name" style="width:50%" class="form-control" placeholder=" Name">
              </div>
 
              <div class="form-group">
                <label for="category">Mobile No</label>
                <input type="text" id="mobileno" style="width:50%" class="form-control"  placeholder="Mobile No">
              </div>

              <div class="form-group">
                <label for="category">Address</label>
                <input type="text" id="address" style="width:50%" class="form-control"  placeholder="Address">
              </div>
              
<div class="form-group">
  <label for="category">Reference Employee</label>
  <?php
$sqlsem = "SELECT * FROM employee where userid=$userid and companyid=$companyid";
$resultse = $conn->query($sqlsem);
echo "<select style='width:50%' class='form-control' id='reference' name='reference' required>";
echo "<option hidden='' value=''>--Select employee--</option>";
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
                <input type="date" id="visit_date" style="width:50%; margin-left:0px;"  placeholder="" value="<?php echo date('Y-m-d'); ?>" class="form-control">
              </div>

              <div class="form-group">              
                <input type="text" id="note" style="width:50%; margin-left:0px;" placeholder="Notes" class="form-control">
              </div>
              
              <input type="button" onclick="savedata()"  value="Save" class="btn btn-success float-left">
              
              </div>
              
               <div class="col-sm-4">
                   
                   <form method="post" id="image-form" enctype="multipart/form-data" onSubmit="return false;">
				<div class="form-group">
					<input type="file" name="file" class="file">
					<div class="input-group my-3" style="width:350px;">
						<input type="text" style="width:20px; display:none;" class="form-control" disabled placeholder="Upload Product Image" id="file">
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
              
              
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        
      </div>
     
    </section>
    <!-- /.content -->




</div>
