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
            <h1>Warehouse Products</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Warehouse Product</li>
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
                <h3 class="card-title" >List of Warehouse Products</h3>
                <a href="#add"><span style="float:right; cursor:pointer;">Add New</span></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow:auto;">
                <table id="example1" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Model</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Warehouse</th>
                    <th>Initial<br>Purchase</th>
                    <th>Current<br>Stock</th>
                    <th>Update<br>Stock</th>
                    <th>Transfer Qty</th>
                    <th style='text-align:center;'>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

$sql = "SELECT a.id,a.name,a.image,a.categoryid,b.current_stock,b.purchaseid,b.id as stock_warehouseid,b.initial_purchase,b.warehouseid FROM product a,stock_warehouse b where a.id=b.productid  and a.userid=$userid and a.companyid=$companyid";
//echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $name=$row["name"];
    $initial_purchase=$row["initial_purchase"];
    $image_url=$row["image"];
    $current_stock=$row["current_stock"];
    $purchaseid=$row["purchaseid"];
    
    if($row["image"]!="")
    {
      $imageurl="imageUpload/uploads/".$row["image"];

    }
    else{
      $imageurl="dist/img/global_logo.png";
    }
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



$warehouseid=$row["warehouseid"];
$warehousename="";

$sqlc = "SELECT * FROM warehouse where id=$warehouseid";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $warehousename=$rowc["name"];
  }
} else {
 
}


     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     //echo "<td class='code'>".$row['code']."</td>"; 
     echo "<td class='name'>".$name."</td>"; 
     echo "<td class='image'><img src=$imageurl height='50px' width='50px'></td>"; 
     echo "<td class='category'>".$categoryname."</td>"; 
     echo "<td class='warehouse'>".$warehousename."</td>"; 
     
     $csst=$row['current_stock'];
     if($row['current_stock']<0)
     {
         $csst=0;
     }
     $initials=$row['initial_purchase'];
    // echo "<td class='model'>".$row['model']."</td>"; 
     echo "<td class='initial_purchase'>".$row['initial_purchase']."</td>"; 
     echo "<td class='current_stock'>".$csst."</td>"; 

     $cstock=$row['current_stock'];
      
     echo "<td><input type='number' onchange='Updatedata($id,$purchaseid,$warehouseid,this)' class='form-control update_qty' min='1' max='$initials' value='$cstock'></td>"; 
      
     if($cstock>0){
     echo "<td><input type='number' class='form-control transfer_qty' min='1' max='$cstock'></td>";     
     echo "<td class='text-center py-0 align-middle' style='text-align:center;'>
                      <div class='btn-group btn-group-sm'>
                        <a onclick=Adddata($id,$purchaseid,$warehouseid,this) class='btn btn-info'><i class='fas fa-create'>Add</i></a>
                        
                      </div>
                    </td>";
     }
     else{
      echo "<td>Out of Stock</td><td></td>";
     }
     
     
     
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







    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Transfered List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Branch Product</li>
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
                <h3 class="card-title" >List of Branch Products</h3>
                <a href="#add"><span style="float:right; cursor:pointer;">Add New</span></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow:auto;">
                <table id="example2" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Model</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Warehouse</th>
                    <th>Branch</th>
                    <th>Initial Stock</th>
                    <th>Current Stock</th>
                    <th>Update<br>Stock</th>
                    <th>Return</th>
                    <th>Transfer Date</th>
                    <!--<th>Transfer Qty</th>-->
                    <th style='text-align:center;'>Action</th> 
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

$sql = "SELECT a.id,a.name,a.image,a.categoryid,b.created_at,b.current_stock,b.purchaseid,b.id as stock_warehouseid,b.initial_purchase,b.warehouseid FROM product a,stock_branch b where a.id=b.productid and a.userid=$userid and a.companyid=$companyid and b.branchid=$branchid";
//echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $name=$row["name"];
    $initial_purchase=$row["initial_purchase"];
    $image_url=$row["image"];
    $current_stock=$row["current_stock"];
    $purchaseid=$row["purchaseid"];
    $stockid=$row["stock_warehouseid"];
    
    if($row["image"]!="")
    {
      $imageurl="imageUpload/uploads/".$row["image"];

    }
    else{
      $imageurl="dist/img/global_logo.png";
    }
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



$warehouseid=$row["warehouseid"];
$warehousename="";

$sqlc = "SELECT * FROM warehouse where id=$warehouseid";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $warehousename=$rowc["name"];
  }
} else {
 
}


$branchname="";

$sqlc = "SELECT * FROM branches where id=$branchid";
$resultc = $master_conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $branchname=$rowc["name"];
  }
} else {
 
}

     $csst=$row['current_stock'];
     if($row['current_stock']<0)
     {
         $csst=0;
     }


     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     //echo "<td class='code'>".$row['code']."</td>"; 
     echo "<td class='name'>".$name."</td>"; 
     echo "<td class='image'><img src=$imageurl height='50px' width='50px'></td>"; 
     echo "<td class='category'>".$categoryname."</td>"; 
     echo "<td class='warehouse'>".$warehousename."</td>"; 
     echo "<td class='branchname'>".$branchname."</td>"; 
     
     $initials=$row['initial_purchase'];
    // echo "<td class='model'>".$row['model']."</td>"; 
     echo "<td class='initial_purchase'>".$row['initial_purchase']."</td>"; 
     echo "<td class='current_stock'>".$csst."</td>";
     
      echo "<td>";
      //if($warehousename!=""){
      echo "<input type='number' onchange='UpdatedataBranch($id,$stockid,$purchaseid,$warehouseid,this)' class='form-control update_qty' min='0' max='$initials' value='$csst'>";
      //}
      echo "</td>";
     
     echo "<td>";
     if($csst>0){
         if($warehousename!=""){
     echo "<input type='number' style='width:60px;' class='transfer_qty' min='1' max='$cstock'>
                      <br><div class='btn-group btn-group-sm'>
                        <a onclick=Returndata($id,$stockid,$purchaseid,$warehouseid,this) class='btn btn-info'><i class='fas fa-create'>Return</i></a>
                        
                      </div>";
         }
     }
     echo "</p></td>"; 
     echo "<td class='created_at'>".$row['created_at']."</td>";   
     //echo "<td><input type='number' class='form-control transfer_qty'></td>";
     if($row['initial_purchase']==$row['current_stock']){
     echo "<td class='text-center py-0 align-middle' style='text-align:center;'>";
     
                if($warehousename!=""){
                  echo    "<div class='btn-group btn-group-sm'>
                       <a onclick=deletedata($stockid,this,'stock_branch',1) class='btn btn-danger'><i class='fas fa-trash'></i></a>
                      </div>";
                }
                      
                    echo "</td>";
     }
     else{
      echo "<td></td>";
     }
     
     
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
<section class="content" id="add" style='display:none;'>
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Product</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">

  <div class="row">


  <div class="col-sm-4">
  
  <input type="hidden" name="productid" id="productid"  value="0">   

<div class="form-group">
  <label for="category">Product Code</label>
  <input type="text" id="code" name="code" style="width:80%" class="form-control" placeholder="Product Code">
</div>

<div class="form-group">
  <label for="category">Product Name</label>
  <input type="text" id="name" name="name" style="width:80%" class="form-control" placeholder="Product Name">
</div>

<div class="form-group">
  <label for="category">Category</label>
  <?php

$sqlsem = "SELECT * FROM category where userid=$userid";
$resultse = $conn->query($sqlsem);

echo "<select style='width:80%' class='form-control' id='category' name='category' required>";

echo "<option hidden='' value=''>--Select Category--</option>";

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
  <label for="category">Warehouse</label>
  <?php

if($userid==1 || $userid==4 || $userid==10 || $userid==12  ){
$sqlsem = "SELECT id,name FROM warehouse where (userid=1 or userid=4 or userid=10 or userid=12) ";
}
else
{
    $sqlsem = "SELECT id,name FROM warehouse where userid=$userid";
}
//$sqlsem = "SELECT * FROM warehouse";// where userid=$userid";
$resultse = $conn->query($sqlsem);

echo "<select style='width:80%' class='form-control' id='warehouse' name='warehouse' required>";

echo "<option hidden='' value=''>--Select Warehouse--</option>";

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

?>



</div>




             <div class="form-group">
                <label for="">Stock</label>
                <input type="number" id="stock" name="stock" style="width:80%" class="form-control" placeholder="Stock">
              </div>
  
  </div>



  <div class="col-sm-4">
  
  
             <div class="form-group">
                <label for="category">Model/Type</label>
                <input type="text" id="model" name="model" style="width:80%" class="form-control" placeholder="Model/Type">
              </div>

              <div class="form-group">
                <label for="">Self No</label>
                <input type="text" id="selfno" name="selfno" style="width:80%" class="form-control" placeholder="Self No">
              </div>
  
              
              <div class="form-group">
                <label for="category">Purchase Price</label>
                <input type="number"  id="purchaseprice" name="price" style="width:80%" class="form-control" placeholder="Puchase Price">
              </div>

              <div class="form-group">
                <label for="category">Sales Price</label>
                <input type="number"  id="salesprice" name="price" style="width:80%" class="form-control" placeholder="Sales Price">
              </div>
  </div>


  <div class="col-sm-4">
  
             <div class="form-group">
                <label for="category">Sales Price (SMRP)</label>
                <input type="number"  id="salespricesmrp" name="pricesmrp" style="width:80%" class="form-control" placeholder="Sales Price (SMRP)">
              </div>

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



      
        <br>
        <input type="button" onclick="savedata()" class="btn btn-success float-left" value="Save" name="image_upload" id="image_upload" class="btn"/>
         <input type="button" onclick="reload()" style="margin-left:20px;" class="btn btn-success float-left" value="Refresh Page" name="" id="" class="btn"/>
        
      

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
