
<?php

include "../connection.php";

session_start(); 

$userid=$_SESSION["userid"];
$companyid=$_SESSION["companyid"];
$branchid=$_SESSION["branchid"];

// Content  ......................................................

?>

<style>
  .table-design{  width:45%; float:left; margin-left:5%; margin-bottom:5px; margin-top:8px; border:1px solid gray;}
  .table-design tr th{border:1px solid gray; padding:2px;}
  .table-design tr td{border:1px solid gray; padding:2px;}
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cash Book Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Cash Book Report</li>
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

      <div class = "form-group"  id='customerDiv'>
            <label class = "sr-only" for = "">Branch</label>
            
  <select class="form-control s_parameter" id="s_customer">
    <?php 

$ctg_id=0;
$ctg_name="";
$sqlsem = "SELECT * FROM branches where user_id=$userid and company_id=$companyid";
$resultse = $master_conn->query($sqlsem);
echo "<option value='0' hidden=''>Select Branch</option>";
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


<?php 

$customer_name="All";

if($s_customer!=""){ 


 $sqls = "SELECT name FROM branches where id=$s_customer";
    $results = $master_conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $customer_name=$rows["name"];
  }
} else {
 // echo "0 results";
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
    <div class="col-sm-2">
      <?php $logosrc="imageUpload/uploads/".$logo; if($logo=="") {echo "<img src='dist/img/global_logo.png' height='100px' width='100px' >"; } else { echo "<img src=$logosrc height='100px' width='100px' style='padding:10px; border-radius:20px;'>"; } ?>
    </div>
    <div class="col-sm-8" >
       <center><h3 style="  font-family: Lucida Console, Courier, monospace;"><?php echo $shopname ?></h3></center>
       <center><?php echo $address ?></center>
       <center><?php echo "Contact No : ".$mobileno ?></center>
       <center><h5 style="margin-top:5px; margin-bottom:10px;"><b><?php echo "Cash Book Report" ?></b><h5></span></center>
       <?php 
         if($s_dtfrom!="")
         {
          echo "<center><h5 style='margin-top:5px; margin-bottom:10px;'><b>Branch : ".$customer_name." <br> Date From ".$s_dtfrom." To ".$s_dtto."</b><h5></span></center>";
         }
         else{
          echo "<center><h5 style='margin-top:5px; margin-bottom:10px;'><b>Branch : ".$customer_name."</b><h5></span></center>";
         }
         
       ?>
    </div>
    <div class="col-sm-2" >
      <?php  ?>
    </div>
  </div>


  <table id="" class="table-design" style="width:45%; float:left; margin-left:5%;">
                  <thead class="thead-light">
                  <tr><th  colspan='5'><b>Retail Sale Received</b></th></tr>      
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Customer</th>
                    <th>Mobile No</th>
                    <th style='width:20%;'>Sales Date</th>
                    <th>Debit</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;
$total_retail_sale=0;

$sql = "SELECT * FROM  sales_master where (branchid=$s_customer or $s_customer=0 ) and sales_mode=1  order by sales_Date";
//echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    
    $customerid=$row["customerid"];
    $customer_name="";
    $mobileno="";
    $sales_date=$row["sales_date"];
    $Amount=$row["paid"];
    
    // Get Customer Info . . .
$sqls = "SELECT name,mobileno,reference FROM customer where id=$customerid";
$results = $conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $customer_name=$rows["name"];
    $mobileno=$rows["mobileno"];
    $reference=$rows["reference"];
  }
} else {
 // echo "0 results";
}

$var = $row['sales_date'];
$dt = str_replace('/', '-', $var);
$dt=date('Y-m-d', strtotime($dt));

if(($dt>=$s_dtfrom && $dt<=$s_dtto) or $s_dtfrom==""){


     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='customer_name'>".$customer_name."</td>"; 
     echo "<td class='mobileno'>".$mobileno."</td>"; 
     echo "<td class='reference'>".$sales_date."</td>";
     echo "<td class='payment_date'>".$Amount."</td>";
     echo "</tr>";
     
     $total_retail_sale=$total_retail_sale+$Amount;
}


  }
} else {
  
}


echo "<tr>";

echo "<td class='' colspan='4'><b>Total Retail Sale</b></td>";
    
echo "<td class=''><b>".$total_retail_sale."</b></td>";

echo "</tr>";
                ?>
                  
                </table>
                
                
                
                
                <!-- Reatil Sale Installment -->
                
                
                
                
  <table id="" class="table-design" style="">
                  <thead class="thead-light">
                  <tr><th  colspan='5'><b>Installment Received (Retail Sale) </b></th></tr>      
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Customer</th>
                    <th>Mobile No</th>
                    <th>Installment Date</th>
                    <th>Debit</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;
$total_retail_sale=0;

$sql = "SELECT a.customerid,b.payment_date as sales_date,pay_amount as paid FROM  sales_master a,sales_payment b where a.id=b.salesid and (a.branchid=$s_customer or $s_customer=0 ) and a.sales_mode=1 order by b.payment_date ";
//echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    
    $customerid=$row["customerid"];
    $customer_name="";
    $mobileno="";
    $sales_date=$row["sales_date"];
    $Amount=$row["paid"];
    
    // Get Customer Info . . .
$sqls = "SELECT name,mobileno,reference FROM customer where id=$customerid";
$results = $conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $customer_name=$rows["name"];
    $mobileno=$rows["mobileno"];
    $reference=$rows["reference"];
  }
} else {
 // echo "0 results";
}

$var = $row['sales_date'];
$dt = str_replace('/', '-', $var);
$dt=date('Y-m-d', strtotime($dt));

if(($dt>=$s_dtfrom && $dt<=$s_dtto) or $s_dtfrom==""){


     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='customer_name'>".$customer_name."</td>"; 
     echo "<td class='mobileno'>".$mobileno."</td>"; 
     echo "<td class='reference'>".$sales_date."</td>";
     echo "<td class='payment_date'>".$Amount."</td>";
     echo "</tr>";
     
     $total_retail_sale=$total_retail_sale+$Amount;
}


  }
} else {
  
}


echo "<tr>";

echo "<td class='' colspan='4'><b>Total Installment Received (Retail Sale)</b></td>";
    
echo "<td class=''><b>".$total_retail_sale."</b></td>";

echo "</tr>";
                ?>
                  
                </table>
                
                
                
                
                
                <br>
                <!-- Whole Sale -->
                
                





  <table id="" class="table-design">
                  <thead class="thead-light">
                  <tr><th  colspan='5'><b>WholeSale Received</b></th></tr>      
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Customer</th>
                    <th>Mobile No</th>
                    <th style='width:20%;'>Sales Date</th>
                    <th>Debit</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;
$total_retail_sale=0;

$sql = "SELECT * FROM  sales_master where (branchid=$s_customer or $s_customer=0 ) and sales_mode=2  order by sales_Date";
//echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    
    $customerid=$row["customerid"];
    $customer_name="";
    $mobileno="";
    $sales_date=$row["sales_date"];
    $Amount=$row["paid"];
    
    // Get Customer Info . . .
$sqls = "SELECT name,mobileno,reference FROM customer where id=$customerid";
$results = $conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $customer_name=$rows["name"];
    $mobileno=$rows["mobileno"];
    $reference=$rows["reference"];
  }
} else {
 // echo "0 results";
}

$var = $row['sales_date'];
$dt = str_replace('/', '-', $var);
$dt=date('Y-m-d', strtotime($dt));

if(($dt>=$s_dtfrom && $dt<=$s_dtto) or $s_dtfrom==""){


     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='customer_name'>".$customer_name."</td>"; 
     echo "<td class='mobileno'>".$mobileno."</td>"; 
     echo "<td class='reference'>".$sales_date."</td>";
     echo "<td class='payment_date'>".$Amount."</td>";
     echo "</tr>";
     
     $total_retail_sale=$total_retail_sale+$Amount;
}


  }
} else {
  
}


echo "<tr>";

echo "<td class='' colspan='4'><b>Total Whole Sale</b></td>";
    
echo "<td class=''><b>".$total_retail_sale."</b></td>";

echo "</tr>";
                ?>
                  
                </table>
                
                
                
                
                <!-- Whole Sale Installment -->
                
                
                
                
  <table id="" class="table-design">
                  <thead class="thead-light">
                  <tr><th  colspan='5'><b>Installment Received (WholeSale) </b></th></tr>      
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Customer</th>
                    <th>Mobile No</th>
                    <th>Installment Date</th>
                    <th>Debit</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;
$total_retail_sale=0;

$sql = "SELECT a.customerid,b.payment_date as sales_date,pay_amount as paid FROM  sales_master a,sales_payment b where a.id=b.salesid and (a.branchid=$s_customer or $s_customer=0 ) and a.sales_mode=2 order by b.payment_date ";
//echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    
    $customerid=$row["customerid"];
    $customer_name="";
    $mobileno="";
    $sales_date=$row["sales_date"];
    $Amount=$row["paid"];
    
    // Get Customer Info . . .
$sqls = "SELECT name,mobileno,reference FROM customer where id=$customerid";
$results = $conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $customer_name=$rows["name"];
    $mobileno=$rows["mobileno"];
    $reference=$rows["reference"];
  }
} else {
 // echo "0 results";
}

$var = $row['sales_date'];
$dt = str_replace('/', '-', $var);
$dt=date('Y-m-d', strtotime($dt));

if(($dt>=$s_dtfrom && $dt<=$s_dtto) or $s_dtfrom==""){


     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='customer_name'>".$customer_name."</td>"; 
     echo "<td class='mobileno'>".$mobileno."</td>"; 
     echo "<td class='reference'>".$sales_date."</td>";
     echo "<td class='payment_date'>".$Amount."</td>";
     echo "</tr>";
     
     $total_retail_sale=$total_retail_sale+$Amount;
}


  }
} else {
  
}


echo "<tr>";

echo "<td class='' colspan='4'><b>Total Installment Received (WholeSale)</b></td>";
    
echo "<td class=''><b>".$total_retail_sale."</b></td>";

echo "</tr>";
                ?>
                  
                </table>                
                
             
              <!-- Upcoming Payments This Month -->
                
                
                
                
  <table id="" class="table-design">
                  <thead class="thead-light">
                  <tr><th  colspan='5'><b>Advance Payments</b></th></tr>      
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Customer</th>
                    <th>Mobile No</th>
                    <th>Sales Date</th>
                    <th>Debit</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;
$total_retail_sale=0;

$sql = "SELECT a.customerid,a.sales_date as sales_date,a.payment_amount FROM  sales_master a where (a.branchid=$s_customer or $s_customer=0 ) and a.payment_amount>0 
    and a.id not in (select salesid from sales_payment)
    order by a.sales_date ";
//echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    
    $customerid=$row["customerid"];
    $customer_name="";
    $mobileno="";
    $sales_date=$row["sales_date"];
    $Amount=$row["payment_amount"];
    
    // Get Customer Info . . .
$sqls = "SELECT name,mobileno,reference FROM customer where id=$customerid";
$results = $conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $customer_name=$rows["name"];
    $mobileno=$rows["mobileno"];
    $reference=$rows["reference"];
  }
} else {
 // echo "0 results";
}

$var = $row['sales_date'];
$dt = str_replace('/', '-', $var);
$dt=date('Y-m-d', strtotime($dt));

if(($dt>=$s_dtfrom && $dt<=$s_dtto) or $s_dtfrom==""){


     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='customer_name'>".$customer_name."</td>"; 
     echo "<td class='mobileno'>".$mobileno."</td>"; 
     echo "<td class='reference'>".$sales_date."</td>";
     echo "<td class='payment_date'>".$Amount."</td>";
     echo "</tr>";
     
     $total_retail_sale=$total_retail_sale+$Amount;
}


  }
} else {
  
}


echo "<tr>";

echo "<td class='' colspan='4'><b>Total Advance Payment</b></td>";
    
echo "<td class=''><b>".$total_retail_sale."</b></td>";

echo "</tr>";
                ?>
                  
                </table>                
          
          
          <!-- Advance Installments -->      
                
       <table id="" class="table-design">
                  <thead class="thead-light">
                  <tr><th  colspan='5'><b>Advance Installments</b></th></tr>      
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Customer</th>
                    <th>Mobile No</th>
                    <th>Sales Date</th>
                    <th>Debit</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;
$total_retail_sale=0;

$sql = "SELECT * FROM sales_master where userid=$userid and companyid=$companyid and branchid=$branchid and customerid in (Select id from customer where isDefaulter!='checked') order by customerid";
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
    
    // Get Customer Info . . .
$sqls = "SELECT name,mobileno,reference FROM customer where id=$customerid";
$results = $conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $customer_name=$rows["name"];
    $mobileno=$rows["mobileno"];
    $reference=$rows["reference"];
  }
} else {
 // echo "0 results";
}


// . . . . . . . . . .

$totalpay=0;
$no_of_payment_done=0;
$last_pay_date="";

$sqlp = "SELECT * FROM sales_payment where salesid=$id";
$resultp = $conn->query($sqlp);

if ($resultp->num_rows > 0) {

  while($rowp = $resultp->fetch_assoc()) {
    $totalpay=$totalpay+$rowp["amount"];
    $no_of_payment_done++;
    $last_pay_date=$rowp["payment_date"];
  }

}

// . . . . . . . . .

    $sales_date=$row["sales_date"];
    $grand_total=$row["grand_total"];
    $paid=$row["paid"];
    $due=$row["due"];
    $payment_no=$row["payment_no"];
    $note=$row["note"];

$var = $row['sales_date'];
$dt = str_replace('/', '-', $var);
$dt=date('Y-m-d', strtotime($dt));

$arr=explode("-", $var);

$sales_month=$arr[1]+1;
$sales_year=$arr[0];

$date_str =$s_dtfrom;
$year = substr($date_str, 0, 4);
$month = substr($date_str, 5, 2);


$arrp=explode("-", $last_pay_date);
$last_pay_month=$arrp[1];

$month_diff=$month-$sales_month;
$total_cal=$month." ".$sales_month." ".$month_diff;
if($year>$sales_year)
{
   $month_diff= $month+12-$sales_month;
}



if($due>0 && $payment_no>0){
    
    if($month_diff==$payment_no){
        $divider=0;  
    }
    else if($month_diff<$payment_no)
    {
        $divider=$payment_no-$month_diff;
    }
    else{
        $divider=$month_diff-$payment_no;
    }

$dueThisMotnh=$due-$totalpay;
if($divider>0){
    
  $dueThisMotnh=( ($due-$totalpay)/$divider );
}

if($last_pay_month==$month || ($month+1)==$sales_month)
{
    $dueThisMotnh=0;
}

//$total_cal=$sales_month." sales year:".$sales_year." month:".$month." year:".$year." month-diff:".$month_diff." divider:".$divider." pno:".$payment_no." due_this_month:".$dueThisMotnh." due:".$due." total_pay:".$totalpay."<br><br>";
//echo $total_cal;

 // Get Payments .....................

$payment_amount=0; 
$sqlpd = "SELECT * FROM sales_payment where salesid=$id";
$resultpd = $conn->query($sqlpd);
$payments="";
if ($resultpd->num_rows > 0) {
    $payments.= "<td>";
     while($rowpd = $resultpd->fetch_assoc()) {
         $payments.= $rowpd["amount"]." [".$rowpd["payment_date"]."] <br>";
         $payment_amount=$payment_amount+$rowpd["amount"];
     }
     $payments.= "</td>";
}
else
{
    $payments= "<td>0 Payments</td>";
}
//.......


if($dueThisMotnh>0){

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='customer_name'>".$customer_name."</td>"; 
     echo "<td class='mobileno'>".$mobileno."</td>"; 
     echo "<td class='reference'>".$sales_date."</td>";
     echo "<td class='payment_date'>".$dueThisMotnh."</td>";
     echo "</tr>";
     
     $total_retail_sale=$total_retail_sale+$dueThisMotnh;
}


}  // End of Due>0 ...................................

  }
} else {
  
}


echo "<tr>";

echo "<td class='' colspan='4'><b>Total Advance Installment</b></td>";
    
echo "<td class=''><b>".$total_retail_sale."</b></td>";

echo "</tr>";
                ?>
                  
                </table>               
                
                
                <!-- Purchase -->
                
                
                
                
                
                

  <table id="" class="table-design">
                  <thead class="thead-light">
                  <tr><th  colspan='5'><b>Purchase</b></th></tr>      
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Supplier</th>
                    <th>Mobile No</th>
                    <th style='width:20%;'>Purchase Date</th>
                    <th>Credit</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;
$total_retail_sale=0;

$sql = "SELECT * FROM  purchase_master where (branchid=$s_customer or $s_customer=0 )  order by purchase_Date";
//echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    
    $customerid=$row["supplierid"];
    $customer_name="";
    $mobileno="";
    $sales_date=$row["purchase_date"];
    $Amount=$row["paid"];
    
    // Get Customer Info . . .
$sqls = "SELECT name,mobileno FROM supplier where id=$customerid";
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

$var = $row['sales_date'];
$dt = str_replace('/', '-', $var);
$dt=date('Y-m-d', strtotime($dt));

if(($dt>=$s_dtfrom && $dt<=$s_dtto) or $s_dtfrom==""){


     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='customer_name'>".$customer_name."</td>"; 
     echo "<td class='mobileno'>".$mobileno."</td>"; 
     echo "<td class='reference'>".$sales_date."</td>";
     echo "<td class='payment_date'>".$Amount."</td>";
     echo "</tr>";
     
     $total_retail_sale=$total_retail_sale+$Amount;
}


  }
} else {
  
}


echo "<tr>";

echo "<td class='' colspan='4'><b>Total Purchase</b></td>";
    
echo "<td class=''><b>".$total_retail_sale."</b></td>";

echo "</tr>";
                ?>
                  
                </table>
                
                
                
                
                <!-- Purchase Payment -->
                
                
                
                
  <table id="" class="table-design">
                  <thead class="thead-light">
                  <tr><th  colspan='5'><b>Purchase Payment </b></th></tr>      
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Supplier</th>
                    <th>Mobile No</th>
                    <th>Payment Date</th>
                    <th>Credit</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;
$total_retail_sale=0;

$sql = "SELECT b.supplierid as customerid,b.transaction_date as sales_date,out_account as paid FROM app_supplier_account b where supplierid in( select id from supplier where (branchid=$s_customer or $s_customer=0 ) ) and out_account>0 order by b.transaction_date ";
//echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    
    $customerid=$row["customerid"];
    $customer_name="";
    $mobileno="";
    $sales_date=$row["sales_date"];
    $Amount=$row["paid"];
    
    // Get Customer Info . . .
$sqls = "SELECT name,mobileno,reference FROM customer where id=$customerid";
$results = $conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $customer_name=$rows["name"];
    $mobileno=$rows["mobileno"];
    $reference=$rows["reference"];
  }
} else {
 // echo "0 results";
}

$var = $row['sales_date'];
$dt = str_replace('/', '-', $var);
$dt=date('Y-m-d', strtotime($dt));

if(($dt>=$s_dtfrom && $dt<=$s_dtto) or $s_dtfrom==""){


     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='customer_name'>".$customer_name."</td>"; 
     echo "<td class='mobileno'>".$mobileno."</td>"; 
     echo "<td class='reference'>".$sales_date."</td>";
     echo "<td class='payment_date'>".$Amount."</td>";
     echo "</tr>";
     
     $total_retail_sale=$total_retail_sale+$Amount;
}


  }
} else {
  
}


echo "<tr>";

echo "<td class='' colspan='4'><b>Total Purchase Payment</b></td>";
    
echo "<td class=''><b>".$total_retail_sale."</b></td>";

echo "</tr>";
                ?>
                  
                </table>                
                
                
                
                <!-- Expense -->
                
                
                 <table id="" class="table-design">
                  <thead class="thead-light">
                  <tr><th  colspan='4'><b>Expense </b></th></tr>      
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Expense For</th>
                    <th>Expense Date</th>
                    <th>Credit</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;
$total_retail_sale=0;

$sql = "SELECT b.expense_head_id as customerid,b.expense_date as sales_date,amount as paid FROM expense b where  (branchid=$s_customer or $s_customer=0 ) order by b.expense_date ";
//echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    
    $customerid=$row["customerid"];
    $customer_name="";
    $mobileno="";
    $sales_date=$row["sales_date"];
    $Amount=$row["paid"];
    
    // Get Customer Info . . .
$sqls = "SELECT name FROM expense_head where id=$customerid";
$results = $conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $customer_name=$rows["name"];
  }
} else {
 // echo "0 results";
}

$var = $row['sales_date'];
$dt = str_replace('/', '-', $var);
$dt=date('Y-m-d', strtotime($dt));

if(($dt>=$s_dtfrom && $dt<=$s_dtto) or $s_dtfrom==""){


     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='customer_name'>".$customer_name."</td>"; 
     echo "<td class='reference'>".$sales_date."</td>";
     echo "<td class='payment_date'>".$Amount."</td>";
     echo "</tr>";
     
     $total_retail_sale=$total_retail_sale+$Amount;
}


  }
} else {
  
}


echo "<tr>";

echo "<td class='' colspan='3'><b>Total Expense</b></td>";
    
echo "<td class=''><b>".$total_retail_sale."</b></td>";

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
        
        <?php } ?>

    <!-- End Table -->



</div>
