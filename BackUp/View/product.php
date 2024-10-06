<?php

include "../connection.php";

//session_start(); 

$userid=$_SESSION["userid"];
$companyid=$_SESSION["companyid"];

// Content  ......................................................

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Products</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product</li>
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
                    <th>Sub Category</th>
                    <th>Price (MSRP)</th>
                    
                    <th style='text-align:center;'>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

$sql = "SELECT * FROM product where userid=$userid and companyid=$companyid";
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

    $subcategoryid=$row["subcategoryid"];
    $subcategoryname="";
$sqlc = "SELECT * FROM subcategory where subcategoryid=$subcategoryid";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $subcategoryname=$rowc["subcategoryname"];
  }
} else {
 
}

// Check Product is purchased . . .
$isDelete=true;
$sqlc = "SELECT productid FROM purchase_detail where productid=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $isDelete=false;
  }
} 



     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     //echo "<td class='code'>".$row['code']."</td>"; 
     echo "<td class='name'>".$name."</td>"; 
     echo "<td class='image'><img src=$imageurl height='50px' width='50px'></td>"; 
     echo "<td class='category'>".$categoryname."</td>"; 
     echo "<td class='subcategory'>".$subcategoryname."</td>"; 
     echo "<td class='model'>".$row['msrp_price']."</td>"; 
     //echo "<td class='self'>".$row['self']."</td>"; 
     echo "<td class='text-center py-0 align-middle' style='text-align:center;'>
                      <div class='btn-group btn-group-sm'>
                        <a onclick='updatedata($id,this)' class='btn btn-info'><i class='fas fa-edit'></i></a>";
                        if($isDelete){
                        echo "<a onclick=deletedata($id,this,'product') class='btn btn-danger'><i class='fas fa-trash'></i></a>";
                        }
                      echo "</div>
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

<div class="form-group" style='display:none;'>
  <label for="category">Product Code</label>
  <input type="text" id="code" name="code" style="width:80%" class="form-control" placeholder="Product Code">
</div>

<div class="form-group">
  <label for="category">Model Name</label>
  <input type="text" id="name" name="name" style="width:80%" class="form-control" placeholder="Model Name">
</div>

<div class="form-group">
  <label for="category">Category</label>
  <?php
$sqlsem = "SELECT * FROM category where userid=$userid and companyid=$companyid";
$resultse = $conn->query($sqlsem);
echo "<select onchange='getPercentage()' style='width:80%' class='form-control' id='category' name='category' required>";
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
  <label for="category">Sub Category</label>
  <?php
$sqlsem = "SELECT * FROM subcategory where admin_user_id=$userid";
$resultse = $conn->query($sqlsem);
echo "<select  style='width:80%' class='form-control' id='subcategory' name='subcategory' required>";
echo "<option hidden='' value=''>--Select Sub Category--</option>";
if ($resultse->num_rows > 0) {
while($rowse = $resultse->fetch_assoc()) {
$up_name=$rowse["subcategoryname"];
$upid=$rowse["subcategoryid"];
echo  "<option value='$upid'>".$up_name."</option>";
}
} else {
echo  "<option >None</option>";
}
echo " </select>";
?>

</div>

<input type="hidden" id="percentage" name="percentage" style="width:80%" >

             <div class="form-group" >
                <label for="">Price (MSRP)</label>
                <input type="number" id="msrp" name="msrp" style="width:80%" class="form-control" placeholder="Price (MSRP)">
              </div>
  
  </div>



  <div class="col-sm-4" style='display:none;'>
  
  
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
  
             <div class="form-group" style='display:none;'>
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
