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
            <h1>Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Category</li>
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
                <h3 class="card-title" >List of Categories</h3>
                <a href="#add"><span style="float:right; cursor:pointer;">Add New</span></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow:auto;">
                <table id="example1" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Category Name</th>
                    <th>Percentage</th>
                    <th>Processing Fee</th>
                    <th style='text-align:center;'>Install.Dis/Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

$sql = "SELECT id,name,percentage,processing_fee,isDiscountFormula FROM category where userid=$userid and companyid=$companyid";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $name=$row["name"];
    $percentage=$row["percentage"];
    $processing_fee=$row["processing_fee"];
    $isDiscountFormula=$row["isDiscountFormula"];

// Check Category is used . . .
$isDelete=true;
$sqlc = "SELECT id FROM product where categoryid=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $isDelete=false;
  }
}  

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='categoryname'>".$name."</td>"; 
     echo "<td class='percentage'>".$percentage."</td>";
     echo "<td class='processing_fee'>".$processing_fee."</td>";
     
     echo "<td class='text-center py-0 align-middle' style='text-align:center;'>
                      <div class='btn-group btn-group-sm'>
                      <input type='checkbox' onchange='updateDiscountFormula($id,this)' $isDiscountFormula>
                      &nbsp; &nbsp; &nbsp;
                        <a onclick='updatedata($id,this)' class='btn btn-info'><i class='fas fa-edit'></i></a>";
                       if($isDelete){
                       echo  "<a onclick=deletedata($id,this,'category') class='btn btn-danger'><i class='fas fa-trash'></i></a>";
                       }
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
              <h3 class="card-title">Add Category</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">

              <div class="form-group">
                <label for="category">Category Name</label>
                <input type="text" id="category" style="width:25%" class="form-control" placeholder="Category Name">
              </div>
              
               <div class="form-group">
                <label for="category">Percentage</label>
                <input type="number" id="percentage" style="width:25%" class="form-control" placeholder="Percentage">
              </div>

            <div class="form-group">
                <label for="category">Processing Fee</label>
                <input type="number" id="processing_fee" style="width:25%" class="form-control" placeholder="Processing Fee">
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
