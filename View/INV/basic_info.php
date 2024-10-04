<?php

include "../../DB/connection.php";

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
            <h1>Shop Info</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Shop Info</li>
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
              <h3 class="card-title">Add / Update Shop Information</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">


    <?php

    // Get Shop Data ...............................................

    $shopname="";
    $mobileno="";
    $facebook="";
    $shopcategory='';
    $division='';
    $district='';
    $upazilla='';
    $caddress='';
    
    $insertupdateid=0;
 
$sql = "SELECT * FROM basic_info where userid=$userid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    
    $shopname=$row["shop_name"];
    $mobileno=$row["mobileno"];
    $facebook=$row["facebook"];
    $shopcategory=$row["shop_categoryid"];
    $division=$row["division_id"];
    $district=$row["district_id"];
    $upazilla=$row["upazila_id"];
    $caddress=$row["address"];

    $insertupdateid=$row["id"];
    $logo=$row["logo"];

  }
} else {
  

}


    ?>



            <div class="row">

    <div class="col-sm-4">


              <input type="hidden" id="insertupdateid" value="<?php echo $insertupdateid ?>">
              <input type="hidden" id="updatedistrict" value="<?php echo $district ?>">
              <input type="hidden" id="updateupazila" value="<?php echo $upazilla ?>">
 
              <div class="form-group">
                <label for="name">Shop Name</label>
                <input type="text" id="name" style="width:90%" class="form-control" value="<?php echo $shopname ?>" placeholder="Shop Name">
              </div>

              <?php

$sqlsem = "SELECT * FROM shop_category";
$resultse = $conn->query($sqlsem);
echo '<div class="form-group"><label for="name">Shop Cactegory</label>';
echo "<select  class='form-control clsselect2' style='width:90%; margin-left:0px;' id='shop_category' name='shop_category' required>";

echo "<option hidden='' value=''>--Select Category--</option>";

if ($resultse->num_rows > 0) {

while($rowse = $resultse->fetch_assoc()) {

$up_name=$rowse["name"];
$upid=$rowse["id"];

if($upid==$shopcategory){

  echo  "<option value='$upid' selected>".$up_name."</option>";

}
else{
  echo  "<option value='$upid'>".$up_name."</option>";

}


}

} else {

echo  "<option >None</option>";

}

echo " </select></div>";

?>

              <div class="form-group">
                <label for="mobileno">Mobile No</label>
                <input type="text" id="mobileno" style="width:90%" class="form-control"  value="<?php echo $mobileno ?>" placeholder="Mobile No">
              </div>


              <div class="form-group">
                <label for="facebook">Facebook Page</label>
                <input type="text" id="facebook" style="width:90%" class="form-control"  value="<?php echo $facebook ?>" placeholder="Facebook">
              </div>

             


</div>

<div class="col-sm-4">


<?php

$sqlsem = "SELECT * FROM divisions";
$resultse = $conn->query($sqlsem);
echo '<div class="form-group"><label for="name">Division</label>';
echo "<select  class='form-control' onchange='getdistrict()' style='width:90%; margin-left:0px;' id='division' name='division'>";

echo "<option hidden='' value=''>--Select Division--</option>";

if ($resultse->num_rows > 0) {

while($rowse = $resultse->fetch_assoc()) {

$name=$rowse["name"];
$bnname=$rowse["bn_name"];
$id=$rowse["id"];
if($id==$division)
{
  echo  "<option value='$id' selected>".$name."</option>";

}
else{
  echo  "<option value='$id'>".$name."</option>";

}


}

} else {

echo  "<option >None</option>";

}

echo " </select></div>";

?>



<?php

echo '<div class="form-group"><label for="name">District</label>';
echo "<select  class='form-control' onchange='getupazilla()' style='width:90%; margin-left:0px;' id='district' name='district' required>";

echo "<option hidden='' value=''>--Select District--</option>";

echo " </select></div>";

?>



<?php

echo '<div class="form-group"><label for="name">Upazilla</label>';
echo "<select  class='form-control' style='width:90%; margin-left:0px;' id='upazilla' name='upazilla' required>";

echo "<option hidden='' value=''>--Select Upazilla--</option>";


echo " </select></div>";

?>

              <div class="form-group">
                <label for="caddress">Address</label>
                <input type="text" id="caddress" style="width:90%" class="form-control"  value="<?php echo $caddress ?>" placeholder="Custom Address">
              </div>

</div>


<div class="col-sm-4">


<form method="post" id="image-form" enctype="multipart/form-data" onSubmit="return false;">
				<div class="form-group">
					<input type="file" name="file" class="file">
					<div class="input-group my-3" style="width:350px;">
						<input type="text" style="width:20px; display:none;" class="form-control" disabled placeholder="Upload Logo" id="file">
						<div class="input-group-append">
							<button type="button" style="display:none;" class="browse btn btn-primary">Browse...</button>
						</div>
					</div>
				</div>
				<div class="form-group">
				   
        <?php if($logo=="") { ?>
					<img src="dist/img/global_logo.png" height="400px;" width="150px;" id="preview" class="img-thumbnail">
        <?php }else { ?> 
          <img src=<?php echo "imageUpload/uploads/".$logo ?> height="400px;" width="150px;" id="preview" class="img-thumbnail">
        <?php } ?>
				</div>
				<div class="form-group">
					<input type="submit" name="submit" value="Upload" style="display:none;" class="btn btn-danger">
				</div>
      </form>
      

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
