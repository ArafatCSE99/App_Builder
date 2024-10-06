
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
            <h1>Sales Report Installment</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sales Report Installment</li>
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

      <div class = "form-group" style='display:none;'>
            <label class = "sr-only" for = "">Customer</label>
            
  <select class="form-control s_parameter" id="s_customer">
    <?php 

$ctg_id=0;
$ctg_name="";
$sqlsem = "SELECT * FROM customer where userid=$userid and companyid=$companyid";
$resultse = $conn->query($sqlsem);
echo "<option value='' hidden=''>All Customer</option>";
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
         <div class = "form-group">
            <label class = "sr-only" for = "dtfrom">Sales By</label>
            
  <select class="form-control" id="s_ctg">
    <?php 

$ctg_id=0;
$ctg_name="";
$sqlsem = "SELECT * FROM employee where userid=$userid and companyid=$companyid";
$resultse = $conn->query($sqlsem);
echo "<option value='' hidden=''>Sales By</option>";
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
            <input type = "text" class = "form-control" id = "s_model" placeholder='All Model'>
          </div>
          &nbsp;&nbsp;
          <div class = "form-group">
            <label class = "sr-only" for = "dtfrom">code</label>
            <input type = "text" class = "form-control" id = "s_code" placeholder='Code'  style='width:150px;'>
          </div>
          &nbsp;&nbsp;
          <div class = "form-group">
            <label class = "sr-only" for = "dtfrom">Name</label>
            <input type = "text" class = "form-control" id = "s_name" placeholder='Name'>
          </div>
          &nbsp;&nbsp;
         <button type = "button" onclick='ReportRefresh()' class = "btn btn-primary">Search</button>

      </form>

            </span> 



      </div><!-- /.container-fluid -->
    </section>



  <?php
  
  if($s_ctg=='')
  {
      $s_ctg=0;
  }

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
      <?php $logosrc="imageUpload/uploads/".$logo; if($logo=="") {echo "<img src='dist/img/global_logo.png' height='80px' width='80px' >"; } else { echo "<img src=$logosrc height='80px' width='80px' style='padding:10px; border-radius:20px;'>"; } ?>
    </div>
    <div class="col-sm-9" style="padding-left:20px;">
       <h3 style="  font-family: Lucida Console, Courier, monospace;"><?php echo $shopname ?></h3>
       <?php echo $address ?>
       <?php echo "Contact No : ".$mobileno ?>
       <h5 style="margin-top:5px; margin-bottom:10px;"><b><?php echo "Sales Report Installment" ?></b><h5></span>
       <?php 
         if($s_dtfrom!="")
         {
          echo "<h5 style='margin-top:5px; margin-bottom:10px;'><b>Date From ".$s_dtfrom." To ".$s_dtto."</b><h5></span>";
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
                    <th style = "display:none;" class="HideAfterDT">Customerid</th>
                    <th>Customer</th>
                    <th>Mobile No</th>
                    <th>Date</th>
                    <th>Total Price</th>
                    <th>Paid</th>
                    <th>Processing Fee</th>
                    <th>Due</th>
                    <th>Discount</th>
                    <th>Details</th>
                    <th>Note</th>

                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

     $Total_price=0;
     $Total_paid=0;
     $Total_processingfee=0;
     $Total_due=0;

$sql = "SELECT * FROM sales_master where userid=$userid and companyid=$companyid and branchid=$branchid  and payment_type!='Cash'  and (employeeid=$s_ctg or $s_ctg=0)";
//echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $customerid=$row["customerid"];
    $customer_name="";
    $mobileno="";

    $sqls = "SELECT name,mobileno FROM customer where id=$customerid";
    $results = $conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $customer_name=$rows["name"];
    $mobileno=$rows["mobileno"];
  }
} else {
 // echo "0 results";
}


// . . . . . . . . . .

$totalpay=0;

$sqlp = "SELECT * FROM sales_payment where salesid=$id";
$resultp = $conn->query($sqlp);

if ($resultp->num_rows > 0) {

  while($rowp = $resultp->fetch_assoc()) {
   // $totalpay=$totalpay+$rowp["amount"];
   $totalpay=0;
  }

}

// . . . . . . . . .

    $sales_date=$row["sales_date"];
    $grand_total=$row["grand_total"];
    $paid=$row["paid"]+$totalpay;
    $due=$row["due"]-$totalpay;
    $note=$row["note"];
    $discount=$row["discount"];

$var = $row['sales_date'];
$dt = str_replace('/', '-', $var);
$dt=date('Y-m-d', strtotime($dt));

if(($dt>=$s_dtfrom && $dt<=$s_dtto) or $s_dtfrom==""){
//echo $sql;

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td style='display:none;' class='customerid  HideAfterDT'>".$customerid."</td>"; 
     echo "<td class='customer_name'>".$customer_name."</td>"; 
     echo "<td class='mobileno'>".$mobileno."</td>"; 
     echo "<td class='sales_date'>".$row["sales_date"]."</td>";
     echo "<td class='total_price'>".$row["total_price"]."</td>";
     echo "<td class='paid'>".$paid."</td>";
     echo "<td class='processingfee'>".$row["processing_fee"]."</td>";
     echo "<td class='due'>".$due."</td>";
     echo "<td class='discount'>".$discount."</td>";
     echo "<td>";
     // Get Details .............
$sqlp = "SELECT a.*,b.name FROM sales_detail a,product b where a.productid=b.id and salesid=$id";
$resultp = $conn->query($sqlp);
if ($resultp->num_rows > 0) {
  while($rowp = $resultp->fetch_assoc()) {
     $model=$rowp["name"];
     $discount=$rowp["discount"];
     $unitprice=$rowp['unitprice'];
     $discount_percent=0;
    if($rowp["discount"]>0)
    {
        $discount_percent=(($rowp["discount"]*100)/($rowp["unitprice"]*$rowp['quantity']));
    }
    
    echo $model." | ".$unitprice." | ".$discount."[".$discount_percent."%]<br>";
  }
}
     echo "</td>";
     echo "<td class='note'>".$note."</td>";
     
     
     echo "</tr>";


     $Total_price=$Total_price+$row["total_price"];
     $Total_paid= $Total_paid+$paid;
     $Total_processingfee=$Total_processingfee+$row["processing_fee"];
     $Total_due=$Total_due+$due;

}

  }
} else {
  
}


echo "<tr>";

echo "<td class='' colspan='4'><b>Grand Total</b></td>";
     echo "<td class=''><b>".$Total_price."</b></td>";
     echo "<td class=''><b>".$Total_paid."</b></td>";
     echo "<td class=''><b>".$Total_processingfee."</b></td>";
     echo "<td class=''><b>".$Total_due."</b></td>";

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
