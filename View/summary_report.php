
<?php

include "../connection.php";

//session_start(); 

$userid=$_SESSION["userid"];
$companyid=$_SESSION["companyid"];

// Content  ......................................................

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Summary Report  
            </h1> 
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Summary Report</li>
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


  <?php
    include "../Model/ReportHeading.php";
  ?>

                <table id="" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th rowspan="2" style='text-align:center;'>#</th>
                    <th rowspan="2">WH/Branch</th>
                    <th colspan="2">Total Purchase</th>
                    <th colspan="2">Current Stock</th>
                    <th colspan="2">Total Sale</th>
                  </tr>
                  <tr>
                    <th>Qty</th>
                    <th>Amount</th>
                    <th>Qty</th>
                    <th>Amount</th>
                    <th>Qty</th>
                    <th>Amount</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

    $slno=0;
    
    $Super_totalpurchaseQty=0;
    $Super_totalpurchase=0;
    $Super_currentpurchaseQty=0;
    $Super_currentpurchase=0;
    $Super_totalsalesQty=0;
    $Super_totalsales=0;
    
    $Grand_totalpurchaseQty=0;
    $Grand_totalpurchase=0;
    $Grand_currentpurchaseQty=0;
    $Grand_currentpurchase=0;
    $Grand_totalsalesQty=0;
    $Grand_totalsales=0;

$sql = "SELECT * FROM warehouse where userid=$userid and companyid=$companyid;";
//echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $name=$row["name"];
    
    // Get Purchase Data ........................
    $totalpurchaseQty=0;
    $totalpurchase=0;
    $currentpurchaseQty=0;
    $currentpurchase=0;
$sqls="select sum(a.initial_purchase) as totalpurchaseQty,sum(a.current_stock) as currentpurchaseQty,sum(b.total_price) as totalpurchase,sum(a.current_stock*b.unitprice) as currentpurchase from stock_warehouse a,purchase_detail b where a.purchaseid=b.purchaseid and a.productid=b.productid and a.warehouseid=$id;";
$results = $conn->query($sqls);
if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $totalpurchaseQty=$rows["totalpurchaseQty"];
    $totalpurchase=$rows["totalpurchase"];
    $currentpurchase=$rows["currentpurchase"];
    $currentpurchaseQty=$rows["currentpurchaseQty"];
  }
}

// Get Sales Data ........................
    $totalsalesQty=0;
    $totalsales=0;
$sqls="select sum(quantity) as totalsalesQty,sum(total_price) as totalsales from sales_detail where stockid in (select id from stock_warehouse where warehouseid=$id) and salesid in(select id from sales_master where sales_from=2)";
$results = $conn->query($sqls);
if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $totalsalesQty=$rows["totalsalesQty"];
    $totalsales=$rows["totalsales"];
  }
}
    
     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='name'>".$name."</td>"; 
     echo "<td class='totalpurchaseQty'>".round($totalpurchaseQty,2)."</td>"; 
     echo "<td class='totalpurchase'>".round($totalpurchase,2)."</td>"; 
     echo "<td class='currentpurchaseQty'>".round($currentpurchaseQty,2)."</td>";
     echo "<td class='currentpurchase'>".round($currentpurchase,2)."</td>"; 
     echo "<td class='totalsaleQty'>".round($totalsalesQty,2)."</td>"; 
     echo "<td class='totalsale'>".round($totalsales,2)."</td>"; 
     echo "</tr>";
     
    $Grand_totalpurchaseQty=$Grand_totalpurchaseQty+$totalpurchaseQty;
    $Grand_totalpurchase=$Grand_totalpurchase+$totalpurchase;
    $Grand_currentpurchase=$Grand_currentpurchase+$currentpurchase;
    $Grand_currentpurchaseQty=$Grand_currentpurchaseQty+$currentpurchaseQty;
    $Grand_totalsalesQty=$Grand_totalsalesQty+$totalsalesQty;
    $Grand_totalsales=$Grand_totalsales+$totalsales;
    
    $Super_totalpurchaseQty=$Super_totalpurchaseQty+$totalpurchaseQty;
    $Super_totalpurchase=$Super_totalpurchase+$totalpurchase;
    $Super_currentpurchaseQty=$Super_currentpurchaseQty+$currentpurchaseQty;
    $Super_currentpurchase=$Super_currentpurchase+$currentpurchase;
    $Super_totalsalesQty=$Super_totalsalesQty+$totalsalesQty;
    $Super_totalsales=$Super_totalsales+$totalsales;


  }
} else {
  
}

     echo "<tr>";
     echo "<td style='text-align:center;'><b>Total</b></td>";
     echo "<td class='name'><b>Warehous</b></td>"; 
     echo "<td class='totalpurchaseQty'><b>".round($Grand_totalpurchaseQty,2)."</td>"; 
     echo "<td class='totalpurchase'><b>".round($Grand_totalpurchase,2)."</td>"; 
     echo "<td class='currentpurchaseQty'><b>".round($Grand_currentpurchaseQty,2)."</td>";
     echo "<td class='currentpurchase'><b>".round($Grand_currentpurchase,2)."</td>"; 
     echo "<td class='totalsaleQty'><b>".round($Grand_totalsalesQty,2)."</td>"; 
     echo "<td class='totalsale'><b>".round($Grand_totalsales,2)."</td>"; 
     echo "</tr>";
     
     
     
     // For Branch .................................................................................
     
     $slno=0;
    $Grand_totalpurchaseQty=0;
    $Grand_totalpurchase=0;
    $Grand_currentpurchaseQty=0;
    $Grand_currentpurchase=0;
    $Grand_totalsalesQty=0;
    $Grand_totalsales=0;

$sql = "SELECT * FROM branches where user_id=$userid and company_id=$companyid;";
//echo $sql;
$result = $master_conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $name=$row["name"];
    
    // Get Purchase Data ........................
    $totalpurchaseQty=0;
    $totalpurchase=0;
    $currentpurchaseQty=0;
    $currentpurchase=0;
$sqls="select sum(a.initial_purchase) as totalpurchaseQty,sum(a.current_stock) as currentpurchaseQty,sum(b.total_price) as totalpurchase,sum(a.current_stock*b.unitprice) as currentpurchase from stock_branch a,purchase_detail b where a.purchaseid=b.purchaseid and a.productid=b.productid and a.userid=$userid and a.companyid=$companyid and a.branchid=$id;";
$results = $conn->query($sqls);
if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $totalpurchaseQty=$rows["totalpurchaseQty"];
    $totalpurchase=$rows["totalpurchase"];
    $currentpurchase=$rows["currentpurchase"];
    $currentpurchaseQty=$rows["currentpurchaseQty"];
  }
}

// Get Sales Data ........................
    $totalsalesQty=0;
    $totalsales=0;
$sqls="select sum(quantity) as totalsalesQty,sum(total_price) as totalsales from sales_detail where stockid in (select id from stock_branch where branchid=$id) and salesid in(select id from sales_master where sales_from=1)";
$results = $conn->query($sqls);
if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $totalsalesQty=$rows["totalsalesQty"];
    $totalsales=$rows["totalsales"];
  }
}
    
     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='name'>".$name."</td>"; 
     echo "<td class='totalpurchaseQty'>".round($totalpurchaseQty,2)."</td>"; 
     echo "<td class='totalpurchase'>".round($totalpurchase,2)."</td>"; 
     echo "<td class='currentpurchaseQty'>".round($currentpurchaseQty,2)."</td>";
     echo "<td class='currentpurchase'>".round($currentpurchase,2)."</td>"; 
     echo "<td class='totalsaleQty'>".round($totalsalesQty,2)."</td>"; 
     echo "<td class='totalsale'>".round($totalsales,2)."</td>"; 
     echo "</tr>";
     
    $Grand_totalpurchaseQty=$Grand_totalpurchaseQty+$totalpurchaseQty;
    $Grand_totalpurchase=$Grand_totalpurchase+$totalpurchase;
    $Grand_currentpurchase=$Grand_currentpurchase+$currentpurchase;
    $Grand_currentpurchaseQty=$Grand_currentpurchaseQty+$currentpurchaseQty;
    $Grand_totalsalesQty=$Grand_totalsalesQty+$totalsalesQty;
    $Grand_totalsales=$Grand_totalsales+$totalsales;
    
    $Super_totalpurchaseQty=$Super_totalpurchaseQty+$totalpurchaseQty;
    $Super_totalpurchase=$Super_totalpurchase+$totalpurchase;
    $Super_currentpurchaseQty=$Super_currentpurchaseQty+$currentpurchaseQty;
    $Super_currentpurchase=$Super_currentpurchase+$currentpurchase;
    $Super_totalsalesQty=$Super_totalsalesQty+$totalsalesQty;
    $Super_totalsales=$Super_totalsales+$totalsales;


  }
} else {
  
}

     echo "<tr>";
     echo "<td style='text-align:center;'><b>Total</b></td>";
     echo "<td class='name'><b>Branch</b></td>"; 
     echo "<td class='totalpurchaseQty'><b>".round($Grand_totalpurchaseQty,2)."</td>"; 
     echo "<td class='totalpurchase'><b>".round($Grand_totalpurchase,2)."</td>"; 
     echo "<td class='currentpurchaseQty'><b>".round($Grand_currentpurchaseQty,2)."</td>";
     echo "<td class='currentpurchase'><b>".round($Grand_currentpurchase,2)."</td>"; 
     echo "<td class='totalsaleQty'><b>".round($Grand_totalsalesQty,2)."</td>"; 
     echo "<td class='totalsale'><b>".round($Grand_totalsales,2)."</td>"; 
     echo "</tr>";
     
     
      echo "<tr>";
     echo "<td style='text-align:center;'><b>Grand</b></td>";
     echo "<td class='name'><b>Total</b></td>"; 
     echo "<td class='totalpurchaseQty'><b>".round($Super_totalpurchaseQty,2)."</td>"; 
     echo "<td class='totalpurchase'><b>".round($Super_totalpurchase,2)."</td>"; 
     echo "<td class='currentpurchaseQty'><b>".round($Super_currentpurchaseQty,2)."</td>";
     echo "<td class='currentpurchase'><b>".round($Super_currentpurchase,2)."</td>"; 
     echo "<td class='totalsaleQty'><b>".round($Super_totalsalesQty,2)."</td>"; 
     echo "<td class='totalsale'><b>".round($Super_totalsales,2)."</td>"; 
     echo "</tr>";



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
