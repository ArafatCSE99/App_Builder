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
            <h1>Price Manager</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Price Manager</li>
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
                    <th style="min-width:120px;">Purchase Price</th>
                    <th style="min-width:120px;">Sales Price</th>
                    <th style="min-width:120px;">Sales Price (SMRP)</th>
                    <th>Profit Per Unit</th>
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


$purchase_price=0;
$sales_price=0;
$priceid=0;
// Get Product Price .......
$sqlc = "SELECT * FROM price_manager where productid=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $priceid=$rowc["id"];
    $purchase_price=$rowc["purchase_price"];
    $sales_price=$rowc["sales_price"];
    $sales_price_smrp=$rowc["sales_price_smrp"];
  }
} else {
 
}

$profit=$sales_price-$purchase_price;
// End Get Product Price ...


     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='code'>".$row['code']."</td>"; 
     echo "<td class='name'>".$name."</td>"; 
     echo "<td class='model'>".$model."</td>";
     echo "<td class='purchase_price'><input onchange='savedata($priceid,$id,this)' class='form-control' type='number' value=".$purchase_price."></td>"; 
     echo "<td class='sales_price'><input onchange='savedata($priceid,$id,this)'  class='form-control' type='number' value=".$sales_price."></td>"; 
     
     echo "<td class='sales_price_smrp'><input onchange='savedata($priceid,$id,this)'  class='form-control' type='number' value=".$sales_price_smrp."></td>"; 
     
     echo "<td class='profit'>".$profit."/=</td>"; 
     echo "<td class='text-center py-0 align-middle' style='text-align:center; display:none;'>
                      <div class='btn-group btn-group-sm' style='display:none;'>
                        <a onclick='savedata($priceid,$id,this)' class='btn btn-info'><i class='fas fa-edit'></i></a>
                        
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
