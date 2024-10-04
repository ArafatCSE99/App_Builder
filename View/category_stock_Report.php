
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
            <h1>Stock Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Stock Report</li>
            </ol>
          </div>
        </div>
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
       <h5 style="margin-top:5px; margin-bottom:10px;"><b><?php echo "Stock Report (Category Wise)" ?></b><h5></span>
      
    </div>
    <div class="col-sm-2" >
      <?php  ?>
    </div>
  </div>


  <table id="" class="table" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                  <th style='text-align:center;'>#</th>
                    <th>Category</th>
                    
                    <th>Purchase Qty</th>
                    <th>Sales Qty</th>
                    <th>Current Stock</th>

                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

     $Total_Purchase=0;
     $Total_Sales= 0;
     $Total_Stock=0;


$sql = "SELECT * FROM category where userid=$userid and companyid=$companyid";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $name=$row["name"];
   

$previous_qty=0;
$stockid=0;
// Get Previous_Qty .......
$sqlc = "SELECT * FROM stock_manager where productid in (select id from product where categoryid=$id)";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
   
    $stockid=$rowc["id"];
   // $previous_qty=$previous_qty+$rowc["previous_qty"];
  }
} else {
 
}


$purchase_qty=0;

// Get purchase .......
$sqlc = "SELECT * FROM purchase_detail where productid in (select id from product where categoryid=$id) and purchaseid in (select id from purchase_master where companyid=$companyid)";
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
$sqlc = "SELECT * FROM sales_detail where productid in (select id from product where categoryid=$id)";
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
     echo "<td class='name'>".$name."</td>"; 
     //echo "<td class=''>".$previous_qty."</td>"; 
     echo "<td class=''>".$purchase_qty."</td>"; 
     echo "<td class=''>".$sales_qty."</td>"; 
     echo "<td class=''><b>".$current_stock."</b></td>"; 
    
     echo "</tr>";
      
     $Total_Purchase=$Total_Purchase+$purchase_qty;
     $Total_Sales= $Total_Sales+$sales_qty;
     $Total_Stock=$Total_Stock+$current_stock;

  }
} else {
  
}



echo "<tr>";

echo "<td class='' colspan='2'><b>Grand Total</b></td>";
     echo "<td class=''><b>".$Total_Purchase."</b></td>";
     echo "<td class=''><b>".$Total_Sales."</b></td>";
     echo "<td class=''><b>".$Total_Stock."</b></td>";

echo "</tr>";
                ?>
                  
                </table>


              </div> <!-- Report Div Close -->


              </div>
              <!-- /.card-body -->
            </div>


            </div>
        
        </div>
       
      </section>
        

    <!-- End Table -->



</div>
