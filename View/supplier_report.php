
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
            <h1>Supplier Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Supplier Report</li>
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


//include "../Model/Parameter_ReportSearch.php"; 

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
       <h5 style="margin-top:5px; margin-bottom:10px;"><b><?php echo "Supplier Report" ?></b><h5></span>
      
    </div>
    <div class="col-sm-2" >
      <?php  ?>
    </div>
  </div>


  <table id="" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th style = "display:none;" class="HideAfterDT">Customerid</th>
                    <th>Supplier</th>
                    <th>Mobile No</th>
                    <th>Address</th>
                    <th>Opening Balance</th>
                    <th>Paid Amount</th>
                    <th>Current Balance</th>
                   
                  </tr>
                  </thead>
                  <tbody>
<?php
               $slno=0;

$sql = "SELECT id,name,mobileno,address,opening_due FROM supplier where userid=$userid ";
//and companyid=$companyid and branchid=$branchid
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $name=$row["name"];


// Check Supplier is in Purchase . . .
$isDelete=true;
$sqlc = "SELECT id FROM purchase_master where supplierid=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $isDelete=false;
  }
}  

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='name'>".$name."</td>"; 
     echo "<td class='mobileno'>".$row['mobileno']."</td>"; 
     echo "<td class='address'>".$row["address"]."</td>"; 
     echo "<td class='opening_due'>".$row["opening_due"]."</td>"; 
     
     // Balance calculation ...........................
     
$sqls = "SELECT sum(due) as total_due FROM purchase_master where userid=$userid and supplierid=$id";
$results = $conn->query($sqls);

if (mysqli_num_rows($results) > 0) {
  // output data of each row
  while($rows = mysqli_fetch_assoc($results)) {
   $total_duetk=$rows["total_due"];
  }
} else {
  $total_duetk=0;
}


$sqls = "SELECT sum(out_account) as total_due_app FROM app_supplier_account where userid=$userid and supplierid=$id";
$results = $conn->query($sqls);

if (mysqli_num_rows($results) > 0) {
  // output data of each row
  while($rows = mysqli_fetch_assoc($results)) {
   $total_due_app=$rows["total_due_app"];
  }
} else {
  $total_due_app=0;
}




// Payments ...................................

$sqls = "SELECT sum(in_account) as total_pay_app FROM app_supplier_account where userid=$userid and supplierid=$id";
$results = $conn->query($sqls);

if (mysqli_num_rows($results) > 0) {
  // output data of each row
  while($rows = mysqli_fetch_assoc($results)) {
   $total_pay_app=$rows["total_pay_app"];
  }
} else {
  $total_pay_app=0;
}


$sqls = "SELECT sum(amount) as sales_pay FROM purchase_payment_inv where  purchaseid in(select id from purchase_master where supplierid=$id)";
$results = $conn->query($sqls);

if (mysqli_num_rows($results) > 0) {
  // output data of each row
  while($rows = mysqli_fetch_assoc($results)) {
   $total_sales_pay=$rows["sales_pay"];
  }
} else {
  $total_sales_pay=0;
}

$TotalDue=$row["opening_due"]+$total_duetk+$total_pay_app;

$total_pay=$total_sales_pay+$total_due_app;

$balance=$TotalDue-$total_pay;

echo "<td class='current_due'>".$total_pay."</td>";

echo "<td class='current_due'>".$balance."</td>";
     
     
   
     echo "</tr>";
      

  }
} else {
  
}
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
