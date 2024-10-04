
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
            <h1>Customer Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Customer Report</li>
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

<br>

<span>
    
    <form class = "form-inline" role = "form">
        
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
          
          
         <button type = "button" onclick='ReportRefresh()' class = "btn btn-primary">Search</button>

      </form>

    
</span>

      </div><!-- /.container-fluid -->
    </section>



  <?php

// Get Report Heading Data ////////////////////////////////////

$Branch_name="All";
if($s_code!=''){
$sqlb = "SELECT * FROM branches where id=$s_code";
$resultb = $master_conn->query($sqlb);
//echo $sqlb;

if ($resultb->num_rows > 0) {
  // output data of each row
  while($rowb = $resultb->fetch_assoc()) {
       $Branch_name = $rowb["name"];
  }
}

}

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
        <?php echo "<br><b>Branch : </b>".$Branch_name ?>
       <h5 style="margin-top:5px; margin-bottom:10px;"><b><?php echo "Customer Report" ?></b><h5></span>
      
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
                    <th>Customer</th>
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
               $Total_opening_due=0;
               $Total_total_pay=0;
               $Total_balance=0;

$sql = "SELECT id,name,mobileno,address,opening_due FROM customer where userid=$userid and (branchid='$s_code' or '$s_code'='') ";
//echo $sql;
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
$sqlc = "SELECT id FROM sales_master where customerid=$id";
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
     
$sqls = "SELECT sum(due) as total_due FROM sales_master where userid=$userid and customerid=$id";
$results = $conn->query($sqls);

if (mysqli_num_rows($results) > 0) {
  // output data of each row
  while($rows = mysqli_fetch_assoc($results)) {
   $total_duetk=$rows["total_due"];
  }
} else {
  $total_duetk=0;
}


$sqls = "SELECT sum(out_account) as total_due_app FROM app_customer_account where userid=$userid and customerid=$id";
$results = $conn->query($sqls);

if (mysqli_num_rows($results) > 0) {
  // output data of each row
  while($rows = mysqli_fetch_assoc($results)) {
   $total_due_app=$rows["total_due_app"];
  }
} else {
  $total_due_app=0;
}

$TotalDue=$row["opening_due"]+$total_duetk+$total_due_app;


// Payments ...................................

$sqls = "SELECT sum(in_account) as total_pay_app FROM app_customer_account where userid=$userid and customerid=$id";
$results = $conn->query($sqls);

if (mysqli_num_rows($results) > 0) {
  // output data of each row
  while($rows = mysqli_fetch_assoc($results)) {
   $total_pay_app=$rows["total_pay_app"];
  }
} else {
  $total_pay_app=0;
}


$sqls = "SELECT sum(amount) as sales_pay FROM sales_payment where  salesid in(select id from sales_master where customerid=$id)";
$results = $conn->query($sqls);

if (mysqli_num_rows($results) > 0) {
  // output data of each row
  while($rows = mysqli_fetch_assoc($results)) {
   $total_sales_pay=$rows["sales_pay"];
  }
} else {
  $total_sales_pay=0;
}

$total_pay=$total_sales_pay+$total_pay_app;

$balance=$TotalDue-$total_pay;

echo "<td class='current_due'>".$total_pay."</td>";

echo "<td class='current_due'>".$balance."</td>";
     
     
   
     echo "</tr>";
     
               $Total_opening_due=$Total_opening_due+$row["opening_due"];
               $Total_total_pay=$Total_total_pay+$total_pay;
               $Total_balance=$Total_balance+$balance;
      

  }
} else {
  
}

echo "<tr>";
echo "<td colspan='4'><b>Total</b></td>";
echo "<td class=''><b>".$Total_opening_due."</b></td>";
echo "<td class=''><b>".$Total_total_pay."</b></td>";
echo "<td class=''><b>".$Total_balance."</b></td>";
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
