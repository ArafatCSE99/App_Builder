
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
            <h1>Installment Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Installment Report</li>
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
  $s_dtfrom='';
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

           <div id="Report" style="border:0px solid gray;">


  <div class="row">
    <div class="col-sm-1">
    <?php $logosrc="imageUpload/uploads/".$logo; if($logo=="") {echo "<img src='dist/img/global_logo.png' height='80px' width='80px' >"; } else { echo "<img src=$logosrc height='80px' width='80px' style='padding:10px; border-radius:20px;'>"; } ?>    </div>
    <div class="col-sm-9" style="padding-left:20px;">
       <h3 style="  font-family: Lucida Console, Courier, monospace;"><?php echo $shopname ?></h3>
       <?php echo $address ?>
       <?php echo "Contact No : ".$mobileno ?>
       <h5 style="margin-top:5px; margin-bottom:10px;"><b><?php echo "Installment Report" ?></b><h5></span>
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
                    <th>Total Due</th>
                    <th>Payments</th>
                    <th>Current Due</th>
                    <th>Installment (This Month)</th>
                    <th>Note</th>

                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

     $Total_price=0;
     $Total_paid=0;
     $Total_due=0;
     $Total_payment=0;
     $Total_current_due=0;
     $Total_installment=0;

$sql = "SELECT * FROM sales_master where userid=$userid and companyid=$companyid and branchid=$branchid and customerid in (Select id from customer where isDefaulter='checked')";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $salesid=$row["id"];
    $customerid=$row["customerid"];
    $customer_name="";
    $mobileno="";
    $payment_type=$row["payment_type"];
    $payment_no=$row["payment_no"];

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
    $totalpay=$totalpay+$rowp["amount"];
  }

}

// . . . . . . . . .

    $sales_date=$row["sales_date"];
    $grand_total=$row["grand_total"];
    $paid=$row["paid"];
    $due=$row["due"];
    $note=$row["note"];

$var = $row['sales_date'];
$dt = str_replace('/', '-', $var);
$dt=date('Y-m-d', strtotime($dt));

if(($dt>=$s_dtfrom && $dt<=$s_dtto) or $s_dtfrom==""){

     if($due-$totalpay>0){

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td style='display:none;' class='customerid  HideAfterDT'>".$customerid."</td>"; 
     echo "<td class='customer_name'>".$customer_name."</td>"; 
     echo "<td class='mobileno'>".$mobileno."</td>"; 
     echo "<td class='sales_date'>".$row["sales_date"]."</td>";
     echo "<td class='total_price'>".$row["total_price"]."</td>";
     echo "<td class='paid'>".$paid."</td>";
     echo "<td class='due'>".$due."</td>";
     
     // Get Payments .....................

$payment_amount=0; 
$sqlpd = "SELECT * FROM sales_payment where salesid=$id";
$resultpd = $conn->query($sqlpd);

if ($resultpd->num_rows > 0) {
    echo "<td>";
     while($rowpd = $resultpd->fetch_assoc()) {
         echo $rowpd["amount"]." [".$rowpd["payment_date"]."] <br>";
         $payment_amount=$payment_amount+$rowpd["amount"];
     }
     echo "</td>";
}
else
{
    echo "<td>0 Payments</td>";
}

$current_due=$due-$payment_amount;
echo "<td class=''>".$current_due."</td>";

// ........................................................................
    
// Payment Fprecast . . .
echo "<td>";
$payment_types=$payment_type;
$installment=$due;
if($payment_type=="Monthly" || $payment_type=="Weekly")
{
    
if($row["due"]>0 && $payment_no!=0){
    $installment=round($row["due"]/$payment_no);
}
else
{
    $installment=0;
}

}
        
        
if($due>0)
{

$actualPaymentNo=0;
$rowno=$payment_no;
$sqli = "SELECT count(*) as actualPaymentNo FROM sales_payment where salesid=$salesid";
$resulti = $conn->query($sqli);

if ($resulti->num_rows > 0) {
    while($rowi = $resulti->fetch_assoc()) {
        $actualPaymentNo=$rowi["actualPaymentNo"];
    }
}

if($actualPaymentNo=='')
{
    $actualPaymentNo=0;
}


if($actualPaymentNo>$payment_no)
{
    $rowno=$actualPaymentNo;
}

$psl=1;

$installment_date=$sales_date;

for($i=0;$i<$rowno;$i++)
{
  
$tdt=date_create($installment_date);
if($payment_types=="Monthly"){
    date_add($tdt,date_interval_create_from_date_string("30 days"));
}
else
{
    date_add($tdt,date_interval_create_from_date_string("7 days"));
}
$tdt=date_format($tdt,"Y-m-d");
$installment_date=$tdt;
    
    $psl++;
    if($i<$payment_no){
    //echo "<td>".$installment_date."</td>";
    //echo "<td>".$installment."</td>";
    
       if(date("m", strtotime($installment_date)) == date("m"))
        {
           echo $installment."/= (".$installment_date.")<br>";
           $Total_installment=$Total_installment+$installment;
        }

    
    }
    else
    {
        //echo "<td></td>";
        //echo "<td></td>";
    }
    
/*
$sql = "SELECT * FROM sales_payment where salesid=$salesid limit $i,1";
//echo $sql;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $actualPayment_date=$row["payment_date"];
        $actualPayment=$row["amount"];
    }
}
else
{
        $actualPayment_date="";
        $actualPayment="";
}
*/
    //echo "<td>".$actualPayment_date."</td>";
    //echo "<td>".$actualPayment."</td>";

}


}
echo "</td>";
//........................................................................
     
     
     echo "<td class='note'>".$note."</td>";
     
     
     echo "</tr>";


     $Total_price=$Total_price+$row["total_price"];
     $Total_paid= $Total_paid+$paid;
     $Total_due=$Total_due+$due;
     $Total_payment=$Total_payment+$payment_amount;
     $Total_current_due=$Total_current_due+$current_due;
     
     }

}

  }
} else {
  
}


echo "<tr>";

echo "<td class='' colspan='4'><b>Grand Total</b></td>";
     echo "<td class=''><b>".$Total_price."</b></td>";
     echo "<td class=''><b>".$Total_paid."</b></td>";
     echo "<td class=''><b>".$Total_due."</b></td>";
     echo "<td class=''><b>".$Total_payment."</b></td>";
     echo "<td class=''><b>".$Total_current_due."</b></td>";
     echo "<td class=''><b>".$Total_installment."</b></td>";
     echo "<td></td>";

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
