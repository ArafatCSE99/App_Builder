
<?php

include "../connection.php";

//session_start(); 

$userid=$_SESSION["userid"];
$companyid=$_SESSION["companyid"];
$branchid=$_SESSION["branchid"];

$branch="";
$sql = "SELECT * FROM branches where id=$branchid";
$result = $master_conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $branch=$row["name"];
  }
}

// Content  ......................................................

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Advance Installment Report</h1>
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



?>


<br>
           <span> 


      <form class = "form-inline" role = "form">

    
       <div class = "form-group">
            <label class = "sr-only" for = "">Month</label>
                <select class="form-control" id="s_dtfrom">
                  <option selected value='01'>Janaury</option>
    <option value='02'>February</option>
    <option value='03'>March</option>
    <option value='04'>April</option>
    <option value='05'>May</option>
    <option value='06'>June</option>
    <option value='07'>July</option>
    <option value='08'>August</option>
    <option value='09'>September</option>
    <option value='10'>October</option>
    <option value='11' selected>November</option>
    <option value='12'>December</option>
                </select>
         </div>
         
         &nbsp;&nbsp;
         
         <div class = "form-group">
            <label class = "sr-only" for = "">Year</label>
                <select class="form-control" id="s_dtto">
                    <option value='2022'>2022</option>
                    <option value='2023'>2023</option>
                    <option value='2024'>2024</option>
                </select>
         </div>
       


       &nbsp;&nbsp;
         <div class = "form-group" style='display:none;'>
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
         <button type = "button" onclick='ReportRefresh()' class = "btn btn-primary">Search</button>

      </form>

            </span> 

<?php

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



if($s_dtfrom!=''){

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
      <h6 style="margin-top:5px; margin-bottom:10px;"><b><?php echo "Advance Installment Report" ?></b><h6></span>
      <h6 style="margin-top:5px; margin-bottom:10px;"><b><?php echo "Branch : ".$branch." " ?></b><h6></span>
       <?php 
         if($s_dtfrom!="")
         {
          $str_month= "2012-".$s_dtfrom."-01";
          //echo $str_month;
          $monthName =date('F', strtotime($str_month));
          echo "<h6 style='margin-top:5px; margin-bottom:10px;'><b>".$monthName." ".$s_dtto."</b><h6></span>";
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
                    <th><b></b>Installment<br>This Month</b></th>
                    <th>Note</th>
                    <th>Reference</th>

                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;
$precustomerid=0;

     $Total_price=0;
     $Total_paid=0;
     $Total_due=0;
     $Total_payment=0;
     $Total_current_due=0;
     $total_dueThisMonth=0;

$sql = "SELECT * FROM sales_master where userid=$userid and companyid=$companyid and branchid=$branchid and customerid in (Select id from customer where isDefaulter!='checked') order by customerid";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    
    $id=$row["id"];
    $customerid=$row["customerid"];
    $customer_name="";
    $mobileno="";

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

$month=$s_dtfrom;
$year=$s_dtto;


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

//$total_cal=$sales_month." ".$sales_year." ".$month." ".$year." ".$month_diff." ".$divider." ".$payment_no." ".$dueThisMotnh." ".$due." ".$totalpay;

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
     
     $current_due=$due-$payment_amount;
     
     if($current_due>0){
     
     $slno++;

     


     $Total_price=$Total_price+$row["total_price"];
     $Total_paid= $Total_paid+$paid;
     $Total_due=$Total_due+$due;
     $Total_payment=$Total_payment+$payment_amount;
     $Total_current_due=$Total_current_due+$current_due;
     $total_dueThisMonth=$total_dueThisMonth+$dueThisMotnh;
     
     
     
     if($customerid!=$precustomerid && $precustomerid!=0)
     {
         
echo "<tr>";

echo "<td class='' colspan='4'><b>Customer Total</b></td>";
     echo "<td class=''><b>".$Customer_Total_price."</b></td>";
     echo "<td class=''><b>".$Customer_Total_paid."</b></td>";
     echo "<td class=''><b>".$Customer_Total_due."</b></td>";
     echo "<td class=''><b>".$Customer_Total_payment."</b></td>";
     echo "<td class=''><b>".$Customer_Total_current_due."</b></td>";
     echo "<td class=''><b>".$Customer_total_dueThisMonth."</b></td>";
     echo "<td class='' colspan='2'><b></b></td>";

echo "</tr>";

     $Customer_Total_price=0;
     $Customer_Total_paid= 0;
     $Customer_Total_due=0;
     $Customer_Total_payment=0;
     $Customer_Total_current_due=0;
     $Customer_total_dueThisMonth=0;
         
     }
     
     $precustomerid=$customerid;
     
     
     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td style='display:none;' class='customerid  HideAfterDT'>".$customerid."</td>"; 
     echo "<td class='customer_name'>".$customer_name."</td>"; 
     echo "<td class='mobileno'>".$mobileno."</td>"; 
     echo "<td class='sales_date' style='width:100px;'>".$row["sales_date"]."</td>";
     echo "<td class='total_price'>".$row["total_price"]."</td>";
     echo "<td class='paid'>".$paid."</td>";
     echo "<td class='due'>".$due."</td>";
     echo $payments;
     echo "<td class=''><b>".$current_due."</b></td>";
     echo "<td class=''><b>".round($dueThisMotnh,2)."</b></td>";
     echo "<td class='note'>".$note."<br>No of Payments: ".$payment_no."</td>";
     echo "<td class='' style='width:50px;'>".$reference."</td>";
     
     
     echo "</tr>";
     
     $Customer_Total_price=$Customer_Total_price+$row["total_price"];
     $Customer_Total_paid= $Customer_Total_paid+$paid;
     $Customer_Total_due=$Customer_Total_due+$due;
     $Customer_Total_payment=$Customer_Total_payment+$payment_amount;
     $Customer_Total_current_due=$Customer_Total_current_due+$current_due;
     $Customer_total_dueThisMonth=$Customer_total_dueThisMonth+$dueThisMotnh;
     
     
     }

}

  }
} else {
  
}


$actual=" ";//.$total_dueThisMonth." ".$_SESSION["due_previous"];
if(isset($_SESSION["due_previous"]))
{
  if(($total_dueThisMonth-$_SESSION["due_previous"]*1)>=0){
  $actual.="Actual This Month : ".($total_dueThisMonth-$_SESSION["due_previous"]*1);
  }
}

    $_SESSION["due_previous"]=$total_dueThisMonth;


echo "<tr>";

echo "<td class='' colspan='4'><b>Grand Total</b></td>";
     echo "<td class=''><b>".$Total_price."</b></td>";
     echo "<td class=''><b>".$Total_paid."</b></td>";
     echo "<td class=''><b>".$Total_due."</b></td>";
     echo "<td class=''><b>".$Total_payment."</b></td>";
     echo "<td class=''><b>".$Total_current_due."</b></td>";
     echo "<td class=''><b>".$total_dueThisMonth."</b></td>";
     echo "<td class='' colspan='2'><b>".$actual."</b></td>";

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


<?php

}

?>

</div>
