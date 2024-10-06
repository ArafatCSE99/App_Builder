
<?php

include "../connection.php";

session_start(); 

$userid=$_SESSION["userid"];
$companyid=$_SESSION["companyid"];
$branchid=$_SESSION["branchid"];
$subuserid=$_SESSION["subuserid"];

// Content  ......................................................

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Baranch Payment Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Branch Ledger Report</li>
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

     
          
          <?php 
          if($subuserid==0){
            echo '<div class = "form-group">';
          }
          else
          {
             echo '<div class = "form-group" style="display:none;">';
          }
          ?>
            <label class = "sr-only" for = "dtfrom">Branch</label>
            
  <select class="form-control" id="s_code">
    <?php 

$ctg_id=0;
$ctg_name="";
$sqlsem = "SELECT * FROM branches where user_id=$userid  and company_id=$companyid";
//echo $sqlsem;
$resultse = $master_conn->query($sqlsem);
echo "<option value='0' hidden='0'>All Branch</option>";
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

if($subuserid==0){
    $branchid=$s_code;
}


$Branch_name="All";

if($branchid=="")
{
    $branchid=0;
}

$sqlb = "SELECT * FROM branches where id=$branchid";
//echo $sqlb;
$resultb = $master_conn->query($sqlb);
//echo $sqlb;

if ($resultb->num_rows > 0) {
  // output data of each row
  while($rowb = $resultb->fetch_assoc()) {
       $Branch_name = $rowb["name"];
  }
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
      <?php $logosrc="imageUpload/uploads/".$logo; if($logo=="") {echo "<img src='dist/img/global_logo.png' height='100px' width='100px' >"; } else { echo "<img src=$logosrc height='100px' width='100px' style='padding:10px; border-radius:20px;'>"; } ?>
    </div>
    <div class="col-sm-8" >
       <center><h3 style="  font-family: Lucida Console, Courier, monospace;"><?php echo $shopname ?></h3></center>
       <center><?php echo $address ?></center>
       <center><?php echo "Contact No : ".$mobileno ?></center>
       <center><h5 style="margin-top:5px; margin-bottom:10px;"><b><?php echo "Branch Payment Report - ".$Branch_name ?> </b><h5></span></center>
       <?php 
         if($s_dtfrom=="")
         {
             $s_dtfrom="2024-02-01";
             $s_dtto=date("Y-m-d");
         }
       
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


  <table id="" class="table" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th style = "display:none;" class="HideAfterDT">Customerid</th>
                    <!--<th>Customer</th>-->
                    <!--<th>Mobile No</th>-->
                    <th>Previous Balance</th>
                    <th>Transaction Date</th>
                    <th>Transaction Type</th>
                    <th>Amount</th>
                    <th>Current Balance</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

     $Previous_Balance=0;
     $Current_Balance=0;


$sql = "SELECT Transaction_Date,Type,Amount FROM
(
  SELECT date as Transaction_Date,'Opening Balance' as Type,sum(amount) as Amount FROM branch_payment_new where userid=$userid and (branchid=$branchid or $branchid=0)  and transaction_type='Opening Balance' group by Transaction_Date,Type
  union all
  SELECT date as Transaction_Date,'Deposit' as Type,sum(amount)  as Amount FROM branch_payment_new where userid=$userid and (branchid=$branchid or $branchid=0) and transaction_type='Deposit' group by Transaction_Date,Type
  union all
  SELECT date as Transaction_Date,'Admin Balance' as Type,sum(amount)  as Amount FROM branch_payment_new where userid=$userid and (branchid=$branchid or $branchid=0) and transaction_type='Admin Balance' group by Transaction_Date,Type
  union all
  SELECT date as Transaction_Date,'Deposit Purchase' as Type,sum(amount)  as Amount FROM branch_payment_new where userid=$userid and (branchid=$branchid or $branchid=0)  and transaction_type='Deposit Purchase' group by Transaction_Date,Type
  union all
  SELECT sales_date as Transaction_Date,'Sales Paid' as Type,sum(paid)  as Amount FROM sales_master where userid=$userid and (branchid=$branchid or $branchid=0) and paid>0 group by Transaction_Date,Type
  union all
  SELECT payment_date as Transaction_Date,'Sales Payment' as Type,sum(pay_amount)  as Amount FROM sales_payment where  salesid in(select id from sales_master where userid=$userid and (branchid=$branchid or $branchid=0)) group by Transaction_Date,Type
  union all
  SELECT expense_date as Transaction_Date,'Expense' as Type,sum(amount)  as Amount FROM expense where userid=$userid and (branchid=$branchid or $branchid=0) group by Transaction_Date,Type
) m order by m.Transaction_Date 
";

if(1==1)
{
    
$sql = "SELECT Transaction_Date,Type,Amount FROM
(
  SELECT date as Transaction_Date,'Opening Balance' as Type,sum(amount) as Amount FROM branch_payment_new where userid=$userid and (branchid=$branchid or $branchid=0)  and transaction_type='Opening Balance' group by Transaction_Date,Type
  union all
  SELECT date as Transaction_Date,'Deposit' as Type,sum(amount)  as Amount FROM branch_payment_new where userid=$userid and (branchid=$branchid or $branchid=0) and transaction_type='Deposit' group by Transaction_Date,Type
  union all
  SELECT date as Transaction_Date,'Admin Balance' as Type,sum(amount)  as Amount FROM branch_payment_new where userid=$userid and (branchid=$branchid or $branchid=0) and transaction_type='Admin Balance' group by Transaction_Date,Type
  union all
  SELECT date as Transaction_Date,'Deposit Purchase' as Type,sum(amount)  as Amount FROM branch_payment_new where userid=$userid and (branchid=$branchid or $branchid=0)  and transaction_type='Deposit Purchase' group by Transaction_Date,Type
  union all
  SELECT sales_date as Transaction_Date,'Sales Paid' as Type,sum(paid)  as Amount FROM sales_master where userid=$userid and (branchid=$branchid or $branchid=0) and paid>0 group by Transaction_Date,Type
  union all
  SELECT payment_date as Transaction_Date,'Sales Payment' as Type,sum(pay_amount)  as Amount FROM sales_payment where  salesid in(select id from sales_master where userid=$userid and (branchid=$branchid or $branchid=0)) group by Transaction_Date,Type
  union all
  SELECT expense_date as Transaction_Date,'Expense' as Type,sum(amount)  as Amount FROM expense where userid=$userid and (branchid=$branchid or $branchid=0) and expense_from='Branch' group by Transaction_Date,Type
) m order by m.Transaction_Date 
";

//echo $sql;

}

//echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    
    $Transaction_Date=$row["Transaction_Date"];
    //$customer_name="";
    //$mobileno="";
    $Type=$row["Type"];
    $Amount=$row["Amount"];

$var = $row['Transaction_Date'];
$dt = str_replace('/', '-', $var);
$dt=date('Y-m-d', strtotime($dt));


$start_dt="2024-02-01";

if($start_dt<=$Transaction_Date){
    
$color="";
$bgcolor="";
if($Type=="Opening Balance" || $Type=="Admin Balance" || $Type=="Sales Paid" || $Type=="Sales Payment")
{
    $Current_Balance=$Previous_Balance+$Amount;
}
else
{
    $Current_Balance=$Previous_Balance-$Amount;
    $bgcolor="#e8e8e8";
    $color="";
}



if(($dt>=$s_dtfrom && $dt<=$s_dtto) or $s_dtfrom==""){


     echo "<tr style='background-color:$bgcolor; color:$color;'>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td style='display:none;' class='customerid  HideAfterDT'>".$customerid."</td>"; 
     //echo "<td class='customer_name'>".$customer_name."</td>"; 
     //echo "<td class='mobileno'>".$mobileno."</td>"; 
     echo "<td class='reference'>".$Previous_Balance."</td>";
     echo "<td class='payment_date'>".$row["Transaction_Date"]."</td>";
     echo "<td class='payment_date'>".$row["Type"]."</td>";
     echo "<td class='total_price'>".$row["Amount"]."</td>";
     echo "<td class='reference'>".$Current_Balance."</td>";
    
     
     echo "</tr>";
}

}

$Previous_Balance=$Current_Balance;


  }
} else {
  
}


echo "<tr>";

echo "<td class='' colspan='5'><b>Balance</b></td>";
    
echo "<td class=''><b>".$Current_Balance."</b></td>";

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