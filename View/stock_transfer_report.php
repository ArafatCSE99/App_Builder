
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
            <h1>Stock Transfer Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Stock Transfer Report</li>
            </ol>
          </div>
        </div>
        
        
        <?php


if(isset($_SESSION["s_dtfrom"])){
  $s_dtfrom=$_SESSION["s_dtfrom"];
  $s_dtto=$_SESSION["s_dtto"];
  $s_ctg=$_SESSION["s_ctg"];
  $s_model=$_SESSION["s_model"];
  $s_code=$_SESSION["s_code"];
  $s_name=$_SESSION["s_name"];
  $s_customer=$_SESSION["s_customer"];
  }
  else{
  $S_dtfrom='';
  $s_dtto='';
  $s_ctg='';
  $s_model='';
  $s_code='';
  $s_name='';
  $s_customer='';
  }
?>

<br>
           <span> 


      <form class = "form-inline" role = "form">

     
         <div class = "form-group">
            <label class = "sr-only" for = "dtfrom">Category</label>
            
  <select class="form-control" id="s_ctg">
    <?php 

$ctg_id=0;
$ctg_name="";
$sqlsem = "SELECT * FROM category where userid=$userid and companyid=$companyid";
$resultse = $conn->query($sqlsem);
echo "<option value='' hidden=''>All Category</option>";
if ($resultse->num_rows > 0) {
   
    while($rowse = $resultse->fetch_assoc()) {
       $ctg_id=$rowse["id"];
       $ctg_name=$rowse["name"];
       echo "<option value='$ctg_id'>".$ctg_name."</option>";

    }
} 

    ?>
  </select>

         </div>
         
          &nbsp;&nbsp;
          
          <div class = "form-group">
            <label class = "sr-only" for = "dtfrom">Model</label>
            
  <select class="form-control" id="s_model" style='width:200px;'>
    <?php 

$ctg_id=0;
$ctg_name="";
$sqlsem = "SELECT * FROM product where userid=$userid and companyid=$companyid";
$resultse = $conn->query($sqlsem);
echo "<option value='' hidden=''>All Model</option>";
if ($resultse->num_rows > 0) {
   
    while($rowse = $resultse->fetch_assoc()) {
       $ctg_id=$rowse["id"];
       $ctg_name=$rowse["name"];
       echo "<option value='$ctg_id'>".$ctg_name."</option>";

    }
} 

    ?>
  </select>

         </div>
         
         &nbsp;&nbsp;
          
          <div class = "form-group">
            <label class = "sr-only" for = "dtfrom">Branch</label>
            
  <select class="form-control" id="s_code">
    <?php 

$ctg_id=0;
$ctg_name="";
$sqlsem = "SELECT * FROM branches where user_id=$userid and company_id=$companyid";
//echo $sqlsem;
$resultse = $master_conn->query($sqlsem);
echo "<option value='' hidden=''>All Branch</option>";
if ($resultse->num_rows > 0) {
   
    while($rowse = $resultse->fetch_assoc()) {
       $ctg_id=$rowse["id"];
       $ctg_name=$rowse["name"];
       echo "<option value='$ctg_id'>".$ctg_name."</option>";

    }
} 

    ?>
  </select>

         </div>
         
         
          &nbsp;&nbsp;

         <div class = "form-group">
            <label class = "sr-only" for = "dtfrom">Date From</label>
            <input type = "date" class = "form-control" id = "s_dtfrom">
         </div>
         &nbsp;&nbsp;
         <div class = "form-group">
            <label class = "sr-only" for = "dtfrom">Date To</label>
            <input type = "date" class = "form-control" id = "s_dtto">
         </div>
         &nbsp;&nbsp;
          
          
         <button type = "button" onclick='ReportRefresh()' class = "btn btn-primary">Search</button>

      </form>

            </span> 


        
        
      </div><!-- /.container-fluid -->
    </section>



  <?php

// Get Report Heading Data ////////////////////////////////////

 // Get Shop Data ...............................................

 $shopname="";
 $mobileno="";
 $facebook="";
 $shopcategory='';
 $division='';
 $district='';
 $upazilla='';
 
 $insertupdateid=0;

$sql = "SELECT * FROM basic_info where userid=$userid and companyid=$companyid";
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
 $logo=$row["logo"];

}
}


// Get Upazilla ......................................

$up_name="";
$sqlsem = "SELECT * FROM upazilas where id=$upazilla";
$resultse = $conn->query($sqlsem);

if ($resultse->num_rows > 0) {
   
    while($rowse = $resultse->fetch_assoc()) {
       	   
       $up_name=$rowse["name"];

    }
} 


// Get District ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,

$dis_name="";
$sqlsem = "SELECT * FROM districts where id=$district";
$resultse = $conn->query($sqlsem);

if ($resultse->num_rows > 0) {
   
    while($rowse = $resultse->fetch_assoc()) {
       	   
       $dis_name=$rowse["name"];

    }
}

$address="";
if($up_name!="" && $dis_name!="")
{
   $address=$up_name.",".$dis_name;
}

  ?>




    <!-- Table -->   

    <section class="content">
      <div class="row">
        <div class="col-md-12">

    <div class="card ">
              <div class="card-header">
                <h3 class="card-title" >
                <img src="dist/img/print.png" height="50px;" style="cursor:pointer;" id="print">
                <img src="dist/img/pdf.png" height="50px;" style="cursor:pointer;" id="pdf">
                <img src="dist/img/exel.jpg" height="50px;" style="cursor:pointer;" id="excel">
              </h3> 
              </div>
              <!-- /.card-header -->
              <div class="card-body" id="section-to-print">

           <div id="Report" style="border:0px solid gray; ">


  <div class="row">
    <div class="col-sm-1">
    <?php $logosrc="imageUpload/uploads/".$logo; if($logo=="") {echo "<img src='dist/img/global_logo.png' height='80px' width='80px' >"; } else { echo "<img src=$logosrc height='80px' width='80px' style='padding:10px; border-radius:20px;'>"; } ?>    </div>
    <div class="col-sm-9" style="padding-left:20px;">
       <h3 style="  font-family: Lucida Console, Courier, monospace;"><?php echo $shopname ?></h3>
       <?php echo $address ?>
       <?php echo "Contact No : ".$mobileno ?>
       <h5 style="margin-top:5px; margin-bottom:10px;"><b><?php echo "Stock Transfer Report" ?></b><h5></span>
       <?php
         if($s_dtfrom!="")
         {
          echo "<center><h5 style='margin-top:5px; margin-bottom:10px;'><b> Date From ".$s_dtfrom." To ".$s_dtto."</b><h5></span></center>";
         }
         ?>
      
    </div>
    <div class="col-sm-2" >
      <?php  ?>
    </div>
  </div>


  <table id="" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Model</th>
                    <th>Category</th>
                    <th>Warehouse</th>
                    <th>Branch</th>
                    <th>Transfer Qty</th>
                    <th>Current Stock</th>
                    <th>Transfer Date</th>
                    <th>Purchase Price</th>
                  </tr>
                  </thead>
                  <tbody>

                 <?php

$slno=0;
$total_purchase=0;

$sql = "SELECT a.id,a.name,a.image,a.categoryid,b.created_at,b.current_stock,b.purchaseid,b.id as stock_warehouseid,b.initial_purchase,b.warehouseid,b.branchid FROM product a,stock_branch b where a.id=b.productid and a.userid=$userid and a.companyid=$companyid and (a.categoryid='$s_ctg' or '$s_ctg'='') and (a.id='$s_model' or '$s_model'='' ) and (b.branchid='$s_code' or '$s_code'='')";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
   
    $id=$row["id"];
    $name=$row["name"];
    $initial_purchase=$row["initial_purchase"];
    $image_url=$row["image"];
    $current_stock=$row["current_stock"];
    $purchaseid=$row["purchaseid"];
    $stockid=$row["stock_warehouseid"];
    $branchesid=$row["branchid"];
    
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

$sqlc = "SELECT * FROM branches where id=$branchesid";
$resultc = $master_conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $branchname=$rowc["name"];
  }
} else {
 
}


$purchase_price=0;
$sqlc = "SELECT avg(total_price) as purchase_price FROM purchase_detail where productid=$id";
//echo $sqlc;
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $purchase_price=$rowc["purchase_price"];
  }
}

     $csst=$row['current_stock'];
     if($row['current_stock']<0)
     {
         $csst=0;
     }


$var = $row['created_at'];
$dt = str_replace('/', '-', $var);
$dt=date('Y-m-d', strtotime($dt));

if(($dt>=$s_dtfrom && $dt<=$s_dtto) or $s_dtfrom==""){
    
     $slno++;

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     //echo "<td class='code'>".$row['code']."</td>"; 
     echo "<td class='name'>".$name."</td>"; 
     echo "<td class='category'>".$categoryname."</td>"; 
     echo "<td class='warehouse'>".$warehousename."</td>"; 
     echo "<td class='branchname'>".$branchname."</td>"; 
     $initials=$row['initial_purchase'];
    // echo "<td class='model'>".$row['model']."</td>"; 
     echo "<td class='initial_purchase'>".$row['initial_purchase']."</td>"; 
     echo "<td class='current_stock'>".$csst."</td>";
     echo "<td class='created_at'>".$row['created_at']."</td>"; 
     echo "<td class='purchase_price'>".round($purchase_price,2)."</td>";   
     //echo "<td><input type='number' class='form-control transfer_qty'></td>";
     echo "</tr>";
     
     $total_purchase=$total_purchase+$purchase_price;
     
}
     
      

  }
} else {
  
}

echo "<tr>";
echo "<td colspan='8'><b>Total</b></td>";
echo "<td>".round($total_purchase,2)."</td>";
echo "</tr>";

                ?>
                  
                </tbody></table>


              </div> <!-- Report Div Close -->


              </div>
              <!-- /.card-body -->
            </div>


            </div>
        
        </div>
       
      </section>
        

    <!-- End Table -->



</div>
