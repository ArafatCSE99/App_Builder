
<?php

include "../connection.php";

session_start(); 

$userid=$_SESSION["userid"];
$companyid=$_SESSION["companyid"];
$branchid=$_SESSION["branchid"];

// Content  ......................................................

?>

<style>
  .table-design{  width:95%; float:left; margin-left:0%; margin-bottom:5px; margin-top:8px; border:1px solid gray;}
  .table-design tr th{border:1px solid gray; padding:2px;}
  .table-design tr td{border:1px solid gray; padding:2px;}
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profit Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Profit Report</li>
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
       <center><h5 style="margin-top:5px; margin-bottom:10px;"><b><?php echo "Profit Report" ?></b><h5></span></center>
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


<?php

$grand_full_cash_profit=0;
$grand_cash_profit=0;
$grand_due_profit=0;
$grand_expense=0;


?>


  <table id="" class="table-design" style="">
                  <thead class="thead-light">
                  <tr><th  colspan='6'><b>Retail Sale Profit</b></th></tr>      
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Customer</th>
                    <th>Mobile No</th>
                    <th style='width:20%;'>Sales Date</th>
                    <th>Debit</th>
                    <th>Full Cash</th>
                    <th>Cash Profit</th>
                    <th>Due Profit</th>
                    <th>Total Profit</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;
$total_retail_sale=0;
$retail_sale_full_cash_profit=0;
$retail_sale_cash_profit=0;
$retail_sale_due_profit=0;
$retail_sale_total_profit=0;

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
    $due_amount = $row["due"];
   
    
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


// Calculate Profit .............


include "../Model/profit_calculation.php";

/*
$total_price=$row["total_price"];
$due=$row["due"];
$masterid=$row["id"];
$total_profit=0;
$cash_profit=0;
$due_profit=0;

$sqls = "SELECT * FROM sales_detail where salesid=$masterid";
$results = $conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
      
    $quantity=$rows["quantity"];
    $unitprice=$rows["unitprice"]-($rows["discount"]/$quantity);
    $productid=$rows["productid"];
    

      // Find Product Purchase Unit Price 
$purchase_unitprice=$unitprice;
$sales_detailid=$rows["id"];
$sqla = "Select unitprice as avgprice from( select a.unitprice from purchase_detail a, sales_detail b, stock_branch c,sales_master d where b.stockid=c.id and c.purchaseid=a.purchaseid and c.productid=a.productid and b.salesid=d.id and b.id=$sales_detailid and d.sales_from=1 union all select a.unitprice from purchase_detail a, sales_detail b, stock_warehouse c,sales_master d where b.stockid=c.id and c.purchaseid=a.purchaseid and c.productid=a.productid and b.salesid=d.id and b.id=$sales_detailid and d.sales_from=2 ) as NewT
";



  $resulta = $conn->query($sqla);
  
  if ($resulta->num_rows > 0) {
    // output data of each row
    while($rowa = $resulta->fetch_assoc()) {
      $purchase_unitprice= $rowa["avgprice"];
    }
  } else {
    $purchase_unitprice= $unitprice;
  }
      // End ...........................
    
    $unit_profit=  $unitprice-$purchase_unitprice;
    $total_profit=$total_profit+($unit_profit*$quantity);
    
  }
} else {
  echo "0 results";
}

$total_profit=$total_profit-$row["discount"];
$cash_profit=($total_profit/$total_price)*$Amount;
if($due>0)
{
   $due_profit=($total_profit/$total_price)*$due;
}
*/
// End Calculate Profit .........

$full_cash=0;
if($due_amount==0)
{
    $full_cash=$cash_profit;
    $cash_profit=0;
}

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='customer_name'>".$customer_name."</td>"; 
     echo "<td class='mobileno'>".$mobileno."</td>"; 
     echo "<td class='reference'>".$sales_date."</td>";
     echo "<td class='payment_date'>".$Amount."</td>";
     echo "<td class='reference'>".round($full_cash,2)."</td>";
     echo "<td class='reference'>".round($cash_profit,2)."</td>";
     echo "<td class='payment_date'>".round($due_profit,2)."</td>";
     echo "<td class='mobileno' onclick='ViewSalesProfit($masterid,this)' title='$profit_view'>".round($total_profit,2)."</td>"; 
     echo "</tr>";
     
     $total_retail_sale=$total_retail_sale+$Amount;
     $retail_sale_full_cash_profit = $retail_sale_full_cash_profit+$full_cash;
     $retail_sale_cash_profit=$retail_sale_cash_profit+$cash_profit;
     $retail_sale_due_profit=$retail_sale_due_profit+$due_profit;
     $retail_sale_total_profit=$retail_sale_total_profit+$total_profit;
}


  }
} else {
  
}


echo "<tr>";

echo "<td class='' colspan='4'><b>Total Retail Sale Profit</b></td>";
    
echo "<td class=''><b>".$total_retail_sale."</b></td>";
echo "<td class=''><b>".round($retail_sale_full_cash_profit,2)."</b></td>";
echo "<td class=''><b>".round($retail_sale_cash_profit,2)."</b></td>";
echo "<td class=''><b>".round($retail_sale_due_profit,2)."</b></td>";
echo "<td class=''><b>".round($retail_sale_total_profit,2)."</b></td>";

echo "</tr>";

$grand_full_cash_profit=$grand_full_cash_profit+$retail_sale_full_cash_profit;
$grand_cash_profit=$grand_cash_profit+$retail_sale_cash_profit;
$grand_due_profit=$grand_due_profit+$retail_sale_due_profit;


                ?>
                  
                </table>
                
                
                
                
                <!-- Reatil Sale Installment -->
                
                
                
                
  <table id="" class="table-design" style="">
                  <thead class="thead-light">
                  <tr><th  colspan='5'><b>Installment Profit (Retail Sale) </b></th></tr>      
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Customer</th>
                    <th>Mobile No</th>
                    <th>Installment Date</th>
                    <th>Debit</th>
                    <th>Cash Profit</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;
$total_retail_sale=0;
$retail_sale_cash_profit=0;

$sql = "SELECT a.id,a.total_price,a.due,a.customerid,b.payment_date as sales_date,b.pay_amount as paid,a.sales_from,a.branchid,a.discount FROM  sales_master a,sales_payment b where a.id=b.salesid and (a.branchid=$s_customer or $s_customer=0 ) and a.sales_mode=1 order by b.payment_date ";
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



// Calculate Profit .............

include "../Model/profit_calculation_installment.php";
/*
$total_price=$row["total_price"];
$due=$row["due"];
$masterid=$row["id"];
$total_profit=0;
$cash_profit=0;

$sqls = "SELECT * FROM sales_detail where salesid=$masterid";
$results = $conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $quantity=$rows["quantity"];
    $unitprice=$rows["unitprice"]-($rows["discount"]/$quantity);
    $productid=$rows["productid"];
    
$purchase_unitprice=$unitprice;
$sales_detailid=$rows["id"];
$sqla = "Select unitprice as avgprice from( select a.unitprice from purchase_detail a, sales_detail b, stock_branch c,sales_master d where b.stockid=c.id and c.purchaseid=a.purchaseid and c.productid=a.productid and b.salesid=d.id and b.id=$sales_detailid and d.sales_from=1 union all select a.unitprice from purchase_detail a, sales_detail b, stock_warehouse c,sales_master d where b.stockid=c.id and c.purchaseid=a.purchaseid and c.productid=a.productid and b.salesid=d.id and b.id=$sales_detailid and d.sales_from=2 ) as NewT
";
  $resulta = $conn->query($sqla);
  

  
  if ($resulta->num_rows > 0) {
    // output data of each row
    while($rowa = $resulta->fetch_assoc()) {
      $purchase_unitprice= $rowa["avgprice"];
    }
  } else {
    $purchase_unitprice= $unitprice;
  }
      // End ...........................
      
    $unit_profit=  $unitprice-$purchase_unitprice;
    $total_profit=$total_profit+($unit_profit*$quantity);
    
  }
} else {
  echo "0 results";
}


$total_profit=$total_profit-$row["discount"];
$cash_profit=($total_profit/$total_price)*$Amount;
*/
// End Calculate Profit .........



     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='customer_name'>".$customer_name."</td>"; 
     echo "<td class='mobileno'>".$mobileno."</td>"; 
     echo "<td class='reference'>".$sales_date."</td>";
     echo "<td class='payment_date'>".$Amount."</td>";
     echo "<td class='payment_date' title='$profit_view'>".round($cash_profit,2)."</td>";
     echo "</tr>";
     
     $total_retail_sale=$total_retail_sale+$Amount;
     $retail_sale_cash_profit=$retail_sale_cash_profit+$cash_profit;
}


  }
} else {
  
}


echo "<tr>";

echo "<td class='' colspan='4'><b>Total Installment Profit (Retail Sale)</b></td>";
    
echo "<td class=''><b>".$total_retail_sale."</b></td>";
echo "<td class=''><b>".round($retail_sale_cash_profit,2)."</b></td>";
echo "</tr>";

$grand_cash_profit=$grand_cash_profit+$retail_sale_cash_profit;

                ?>
                  
                </table>
                
                
                
                
                
                <br>
                <!-- Whole Sale -->
                
                





  <table id="" class="table-design">
                  <thead class="thead-light">
                  <tr><th  colspan='5'><b>WholeSale Profit</b></th></tr>      
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Customer</th>
                    <th>Mobile No</th>
                    <th style='width:20%;'>Sales Date</th>
                    <th>Debit</th>
                    <th>Full Cash</th>
                    <th>Cash Profit</th>
                    <th>Due Profit</th>
                    <th>Total Profit</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;
$total_retail_sale=0;
$retail_sale_full_cash_profit=0;
$retail_sale_cash_profit=0;
$retail_sale_due_profit=0;
$retail_sale_total_profit=0;

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
    $due_amount = $row["due"];
    
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

// Calculate Profit .............

include "../Model/profit_calculation.php";
/*
$total_price=$row["total_price"];
$due=$row["due"];
$masterid=$row["id"];
$total_profit=0;
$cash_profit=0;
$due_profit=0;

$sqls = "SELECT * FROM sales_detail where salesid=$masterid";
$results = $conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $quantity=$rows["quantity"];
    $unitprice=$rows["unitprice"]-($rows["discount"]/$quantity);
    $productid=$rows["productid"];
    
$purchase_unitprice=$unitprice;
$sales_detailid=$rows["id"];
$sqla = "Select unitprice as avgprice from( select a.unitprice from purchase_detail a, sales_detail b, stock_branch c,sales_master d where b.stockid=c.id and c.purchaseid=a.purchaseid and c.productid=a.productid and b.salesid=d.id and b.id=$sales_detailid and d.sales_from=1 union all select a.unitprice from purchase_detail a, sales_detail b, stock_warehouse c,sales_master d where b.stockid=c.id and c.purchaseid=a.purchaseid and c.productid=a.productid and b.salesid=d.id and b.id=$sales_detailid and d.sales_from=2 ) as NewT
";
  $resulta = $conn->query($sqla);
  

  if ($resulta->num_rows > 0) {
    // output data of each row
    while($rowa = $resulta->fetch_assoc()) {
      $purchase_unitprice= $rowa["avgprice"];
    }
  } else {
    $purchase_unitprice= $unitprice;
  }
      // End ...........................
      
    $unit_profit=  $unitprice-$purchase_unitprice;
    $total_profit=$total_profit+($unit_profit*$quantity);
    
if($masterid==1195)
{
   //  echo $sqla;
   //echo  $unitprice." ".$purchase_unitprice." ".$total_profit."<br>";
}
  
    
  }
} else {
  echo "0 results";
}

$total_profit=$total_profit-$row["discount"];
$cash_profit=($total_profit/$total_price)*$Amount;
if($due>0)
{
   $due_profit=($total_profit/$total_price)*$due;
}
*/
// End Calculate Profit .........

$full_cash=0;
if($due_amount==0)
{
    $full_cash=$cash_profit;
    $cash_profit=0;
}

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='customer_name'>".$customer_name."</td>"; 
     echo "<td class='mobileno'>".$mobileno."</td>"; 
     echo "<td class='reference'>".$sales_date."</td>";
     echo "<td class='reference'>".$Amount."</td>";
     echo "<td class='reference'>".round($full_cash,2)."</td>";
     echo "<td class='reference'>".round($cash_profit,2)."</td>";
     echo "<td class='payment_date'>".round($due_profit,2)."</td>";
     echo "<td class='mobileno' title='$profit_view'>".round($total_profit,2)."</td>"; 
     echo "</tr>";
     
     $total_retail_sale=$total_retail_sale+$Amount;
     $retail_sale_full_cash_profit=$retail_sale_full_cash_profit+$full_cash;
     $retail_sale_cash_profit=$retail_sale_cash_profit+$cash_profit;
     $retail_sale_due_profit=$retail_sale_due_profit+$due_profit;
     $retail_sale_total_profit=$retail_sale_total_profit+$total_profit;
}


  }
} else {
  
}


echo "<tr>";

echo "<td class='' colspan='4'><b>Total Whole Sale</b></td>";
    
echo "<td class=''><b>".$total_retail_sale."</b></td>";
echo "<td class=''><b>".round($retail_sale_full_cash_profit,2)."</b></td>";
echo "<td class=''><b>".round($retail_sale_cash_profit,2)."</b></td>";
echo "<td class=''><b>".round($retail_sale_due_profit,2)."</b></td>";
echo "<td class=''><b>".round($retail_sale_total_profit,2)."</b></td>";

echo "</tr>";

$grand_full_cash_profit=$grand_full_cash_profit+$retail_sale_full_cash_profit;
$grand_cash_profit=$grand_cash_profit+$retail_sale_cash_profit;
$grand_due_profit=$grand_due_profit+$retail_sale_due_profit;

                ?>
                  
                </table>
                
                
                
                
                <!-- Whole Sale Installment -->
                
                
                
                
  <table id="" class="table-design">
                  <thead class="thead-light">
                  <tr><th  colspan='5'><b>Installment Profit (WholeSale) </b></th></tr>      
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Customer</th>
                    <th>Mobile No</th>
                    <th>Installment Date</th>
                    <th>Debit</th>
                    <th>Cash Profit</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;
$total_retail_sale=0;
$retail_sale_cash_profit=0;
$sql = "SELECT a.id,a.total_price,a.due,a.customerid,b.payment_date as sales_date,pay_amount as paid,a.sales_from,a.discount,a.branchid FROM  sales_master a,sales_payment b where a.id=b.salesid and (a.branchid=$s_customer or $s_customer=0 ) and a.sales_mode=2 order by b.payment_date ";
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


// Calculate Profit .............

include "../Model/profit_calculation_installment.php";

/*

$total_price=$row["total_price"];
$due=$row["due"];
$masterid=$row["id"];
$total_profit=0;
$cash_profit=0;

$sqls = "SELECT * FROM sales_detail where salesid=$masterid";
$results = $conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $quantity=$rows["quantity"];
    $unitprice=$rows["unitprice"]-($rows["discount"]/$quantity);
    $productid=$rows["productid"];
    
$purchase_unitprice=$unitprice;
$sales_detailid=$rows["id"];
$sqla = "Select unitprice as avgprice from( select a.unitprice from purchase_detail a, sales_detail b, stock_branch c,sales_master d where b.stockid=c.id and c.purchaseid=a.purchaseid and c.productid=a.productid and b.salesid=d.id and b.id=$sales_detailid and d.sales_from=1 union all select a.unitprice from purchase_detail a, sales_detail b, stock_warehouse c,sales_master d where b.stockid=c.id and c.purchaseid=a.purchaseid and c.productid=a.productid and b.salesid=d.id and b.id=$sales_detailid and d.sales_from=2 ) as NewT
";
  $resulta = $conn->query($sqla);
  
  if ($resulta->num_rows > 0) {
    // output data of each row
    while($rowa = $resulta->fetch_assoc()) {
      $purchase_unitprice= $rowa["avgprice"];
    }
  } else {
    $purchase_unitprice= $unitprice;
  }
      // End ...........................
      
    $unit_profit=  $unitprice-$purchase_unitprice;
    $total_profit=$total_profit+($unit_profit*$quantity);
    
  }
} else {
  echo "0 results";
}


$total_profit=$total_profit-$row["discount"];
$cash_profit=($total_profit/$total_price)*$Amount;

*/

// End Calculate Profit .........


     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='customer_name'>".$customer_name."</td>"; 
     echo "<td class='mobileno'>".$mobileno."</td>"; 
     echo "<td class='reference'>".$sales_date."</td>";
     echo "<td class='payment_date'>".$Amount."</td>";
     echo "<td class='payment_date' title='$profit_view'>".round($cash_profit,2)."</td>";
     echo "</tr>";
     
     $total_retail_sale=$total_retail_sale+$Amount;
     $retail_sale_cash_profit=$retail_sale_cash_profit+$cash_profit;
}


  }
} else {
  
}


echo "<tr>";

echo "<td class='' colspan='4'><b>Total Installment Received (WholeSale)</b></td>";
    
echo "<td class=''><b>".$total_retail_sale."</b></td>";
echo "<td class=''><b>".round($retail_sale_cash_profit,2)."</b></td>";

echo "</tr>";

$grand_cash_profit=$grand_cash_profit+$retail_sale_cash_profit;

                ?>
                  
                </table>                
                
                
                
                
               
                
                
                <!-- Expense -->

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
     
     $total_retail_sale=$total_retail_sale+$Amount;
}


  }
} else {
  
}


$grand_expense=$grand_expense+$total_retail_sale;

                ?>
                
                
                
                <!-- Net Profit -->
                
                
                 <table id="" class="table-design">
                  <thead class="thead-light">
                  <tr><th  colspan='4'><b>Profit Summary</b></th></tr>      
                  </thead>
                  <tbody>

                  <?php

echo "<tr>";
echo "<td class='' colspan='3'><b>Full Cash Profit</b></td>";
echo "<td class=''><b>".round($grand_full_cash_profit,2)."</b></td>";
echo "</tr>";

echo "<tr>";
echo "<td class='' colspan='3'><b>Cash Profit</b></td>";
echo "<td class=''><b>".round($grand_cash_profit,2)."</b></td>";
echo "</tr>";

echo "<tr>";

echo "<tr>";
echo "<td class='' colspan='3'><b>Due Profit</b></td>";
echo "<td class=''><b>".round($grand_due_profit,2)."</b></td>";
echo "</tr>";

$ground_total_profit=$grand_full_cash_profit+$grand_cash_profit+$grand_due_profit;

echo "<tr>";
echo "<td class='' colspan='3'><b>Total Profit</b></td>";
echo "<td class=''><b>".round($ground_total_profit,2)."</b></td>";
echo "</tr>";

echo "<tr>";
echo "<td class='' colspan='3'><b>Total Expense</b></td>";
echo "<td class=''><b>".round($grand_expense,2)."</b></td>";
echo "</tr>";

$gorund_net_profit=$ground_total_profit-$grand_expense;
echo "<tr>";
echo "<td class='' colspan='3'><b>Net Profit</b></td>";
echo "<td class=''><b>".round($gorund_net_profit,2)."</b></td>";
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
