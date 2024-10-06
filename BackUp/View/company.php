<?php

include "../connection.php";

session_start(); 

$userid=$_SESSION["userid"];

// Content  ......................................................

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Company</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Company</li>
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
                <h3 class="card-title" >List of Companies</h3>
                <a href="#add"><span style="float:right; cursor:pointer;">Add New</span></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow:auto;">
                <table id="example1" style="width:100%;" class="table table-bordered" >
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Company Name</th>
                    <th>Mobile No</th>
                    <th>Address</th>
                    <th>Facebook Page</th>
                    <th style='text-align:center;'>Action</th>
                  </tr>
                  </thead>
                  <tbody style="width:100%;"> 

                  <?php

$slno=0;

$sql = "SELECT * FROM company where userid=$userid";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $name=$row["name"];

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='name'>".$name."</td>"; 
     echo "<td class='mobileno'>".$row["mobileno"]."</td>";
     echo "<td class='address'>".$row["address"]."</td>";
     echo "<td class='facebook'>".$row["facebook"]."</td>";
     
     echo "<td class='text-center py-0 align-middle' style='text-align:center;'>
                      <div class='btn-group btn-group-sm'>
                        <a onclick='updatedata($id,this)' class='btn btn-info'><i class='fas fa-edit'></i></a>
                        <a onclick=deletedata($id,this,'company') class='btn btn-danger'><i class='fas fa-trash'></i></a>
                      </div>
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
              <h3 class="card-title">Add Company</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">

              <div class="form-group">
                <label for="name">Company Name</label>
                <input type="text" id="name" style="width:25%" class="form-control" placeholder="Company Name">
              </div>

              <div class="form-group">
                <label for="mobileno">Mobile No</label>
                <input type="text" id="mobileno" style="width:25%" class="form-control"  placeholder="Mobile No">
              </div>

              <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" style="width:25%" class="form-control"  placeholder="Address">
              </div>

              <div class="form-group">
                <label for="facebook">Facebook Page</label>
                <input type="text" id="facebook" style="width:25%" class="form-control"  placeholder="Facebook">
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
