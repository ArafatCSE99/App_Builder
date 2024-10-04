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
            <h1>Stock Manager</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Stock Manager</li>
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
                <h3 class="card-title" >List of Products</h3>
                 <a href="#" onclick="getcontent('out_of_stock')" ><span style="float:right; cursor:pointer;">Out of Stock</span></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow:auto;">
                <table id="example1" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Model</th>
                    <th>Category</th>
                    <th style="min-width:120px;">Previous Qty</th>
                    <th>Purchase Qty</th>
                    <th>Sales Qty</th>
                    <th>Current Stock</th>
                    <th style='text-align:center; display:none;'>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

$sql = "SELECT * FROM product where userid=$userid";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $name=$row["name"];
    $model=$row["model"];
    $imageurl="Model/Uploads/images/".$row["image"];
    $categoryid=$row["categoryid"];

    $categoryname="";

$sqlc = "SELECT * FROM category where id=$categoryid";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $categoryname=$rowc["name"];
  }
} else {
 
}


$previous_qty=0;
$stockid=0;
// Get Previous_Qty .......
$sqlc = "SELECT * FROM stock_manager where productid=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
   
    $stockid=$rowc["id"];
    $previous_qty=$rowc["previous_qty"];
  }
} else {
 
}


$purchase_qty=0;

// Get purchase .......
$sqlc = "SELECT * FROM purchase_detail where productid=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
   
    $purchase_qty=$purchase_qty+$rowc["quantity"];
  }
} else {
 
}


$sales_qty=0;

// Get Sales .......
$sqlc = "SELECT * FROM sales_detail where productid=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
   
    $sales_qty=$sales_qty+$rowc["quantity"];
  }
} else {
 
}


$current_stock=($previous_qty+$purchase_qty)-$sales_qty;

// End Get Product stock ...


     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='code'>".$row['code']."</td>"; 
     echo "<td class='name'>".$name."</td>"; 
     echo "<td class='model'>".$model."</td>";
     echo "<td class='model'>".$categoryname."</td>";
     echo "<td class='previous_qty'><input onchange='savedata($stockid,$id,this)' class='form-control' type='number' value=".$previous_qty."></td>";  
     echo "<td class='purchase_qty'>".$purchase_qty."</td>"; 
     echo "<td class='sales_qty'>".$sales_qty."</td>"; 
     echo "<td class='current_stock'><b>".$current_stock."</b></td>"; 
     echo "<td class='text-center py-0 align-middle' style='text-align:center; display:none;'>
                      <div class='btn-group btn-group-sm' style='display:none;'>
                        <a onclick='savedata($stockid,$id,this)' class='btn btn-info'><i class='fas fa-edit'></i></a>
                        
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








    

</div>
