
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
            <h1>Stock Details Report  
            
           
            </h1> 

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Stock Details Report</li>
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


include "../Model/Parameter_ReportSearch.php"; 

?>

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

           <div id="Report" style="border:2px solid gray; overflow:auto;">


  <div class="row">
    <div class="col-sm-2">
    <?php $logosrc="imageUpload/uploads/".$logo; if($logo=="") {echo "<img src='dist/img/global_logo.png' height='100px' width='100px' >"; } else { echo "<img src=$logosrc height='100px' width='100px' style='padding:10px; border-radius:20px;'>"; } ?>    </div>
    <div class="col-sm-8" >
       <center><h3 style="  font-family: Lucida Console, Courier, monospace;"><?php echo $shopname ?></h3></center>
       <center><?php echo $address ?></center>
       <center><?php echo "Contact No : ".$mobileno ?></center>
       <center><h5 style="margin-top:5px; margin-bottom:10px;"><b><?php echo "Stock Details Report" ?></b><h5></span></center>
      
    </div>
    <div class="col-sm-2" >
      <?php  ?>
    </div>
  </div>

                <table id="" class="table" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    
                    <th>Model</th>
                    <th>Category</th>
                   
                    <th>Purchase Qty</th>
                    <th>Sales Qty</th>
                    <th>Current stock</th>
                    
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

     $Total_price=0;
     $Total_paid=0;
     $Total_due=0;

$sql = "SELECT * FROM product where userid=$userid and (categoryid='$s_ctg' or '$s_ctg'='') and (model='$s_model' or '$s_model'='') and (code='$s_code' or '$s_code'='') and (name='$s_name' or '$s_name'='')";
//echo $sql;
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

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
    // echo "<td class='code'>".$row['code']."</td>"; 
  
     echo "<td class='image'>".$row['name']."</td>"; 
     echo "<td class='category'>".$categoryname."</td>"; 
     //echo "<td class='model'>".$row['model']."</td>"; 

$pre_qty=0;
$sqlc = "select sum(quantity) as previous_qty FROM purchase_detail where productid=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $pre_qty=$rowc["previous_qty"];
  }
} 

$sales_qty=0;
$sqlc = "SELECT sum(quantity) as sales_qty FROM sales_detail where productid=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $sales_qty=$rowc["sales_qty"];
  }
} 

$sales_qty=$sales_qty==""?0:$sales_qty;

$total_qty=$pre_qty+$sales_qty;

echo "<td class=''>".$total_qty."</td>"; 
echo "<td class=''>".$sales_qty."</td>"; 
echo "<td class=''>".$pre_qty."</td>"; 
     
     echo "</tr>";


  }
} else {
  
}
                ?>
                  
               </tbody> </table>


              </div> <!-- Report Div Close -->


              </div>
              <!-- /.card-body -->
            </div>


            </div>
        
        </div>
       
      </section>
        

    <!-- End Table -->



</div>
