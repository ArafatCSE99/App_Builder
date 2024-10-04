
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
            <h1>Product Stock  Report  
            
           
            </h1> 

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product Stock Report</li>
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

     
         <div class = "form-group">
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
          
          <div class = "form-group">
            <label class = "sr-only" for = "dtfrom">Model</label>
            
  <select class="form-control" id="s_model">
    <?php 

$ctg_id=0;
$ctg_name="";
$sqlsem = "SELECT * FROM product where userid=$userid and companyid=$companyid";
$resultse = $conn->query($sqlsem);
echo "<option value='' hidden=''>All Model</option>";
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
                    <th style='text-align:center;'>#</th>
                    
                    <th>Model</th>
                    <th>Category</th>
                    <th>Purchase</th>
                    <th>Warehouse</th>
                    <th>Branch</th>
                    <th>Sales</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

     $Total_price=0;
     $Total_paid=0;
     $Total_due=0;

$sql = "SELECT * FROM product where userid=$userid and companyid=$companyid and (categoryid='$s_ctg' or '$s_ctg'='') and (id='$s_model' or '$s_model'='')";
//echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $name=$row["name"];
    $categoryid=$row["categoryid"];

    $categoryname="";

$sqlc = "SELECT * FROM category where id=$categoryid";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $categoryname=$rowc["name"];
  }
} else {
 
}

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='name' style='width:150px;'>".$name."</td>"; 
     echo "<td class='category'>".$categoryname."</td>"; 
     
     $total=0;
     
     // Purchase .......................
$sqlc = "SELECT * FROM purchase_master a,purchase_detail b where a.id=b.purchaseid and b.productid=$id";
$resultc = $conn->query($sqlc);
echo "<td>";
if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    
     echo $rowc["purchase_date"]." - ".$rowc["quantity"]." [".$rowc["unitprice"]."]<br>";
     $total=$total+$rowc["quantity"];
  }
}
echo "<br><b>Total Purchase - ".$total."</b>";
echo "</td>";


$total=0;
 // Warehouse .......................
$sqlc = "SELECT * FROM stock_warehouse where productid=$id";
$resultc = $conn->query($sqlc);
echo "<td>";
if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
     
     $whid=$rowc["warehouseid"];
     $whnm="";
$sqlcw = "SELECT * FROM warehouse where id=$whid";
$resultcw = $conn->query($sqlcw);
if ($resultcw->num_rows > 0) {
  // output data of each row
  while($rowcw = $resultcw->fetch_assoc()) {
      $whnm=$rowcw["name"];
  }
}
    
     echo $whnm." - Total Purchase - ".$rowc["initial_purchase"]." Current Stock - ".$rowc["current_stock"]."<br>";
     $total=$total+$rowc["current_stock"];
    
  }
}
echo "<br><b>Current Stock - ".$total."</b>";
echo "</td>";


$total=0;
 // branch .......................
$sqlc = "SELECT * FROM stock_branch where productid=$id";
$resultc = $conn->query($sqlc);
echo "<td>";
if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    
     $whid=$rowc["branchid"];
     $whnm="";
$sqlcw = "SELECT * FROM branches where id=$whid";
$resultcw = $master_conn->query($sqlcw);
if ($resultcw->num_rows > 0) {
  // output data of each row
  while($rowcw = $resultcw->fetch_assoc()) {
      $whnm=$rowcw["name"];
  }
}
     echo $whnm." - Total Received - ".$rowc["initial_purchase"]." Current Stock - ".$rowc["current_stock"]."<br>";
     $total=$total+$rowc["current_stock"];
    
  }
}
echo "<br><b>Current Stock - ".$total."</b>";
echo "</td>";

$total=0;
  // Sales .......................
$sqlc = "SELECT * FROM sales_master a,sales_detail b where a.id=b.salesid and b.productid=$id";
$resultc = $conn->query($sqlc);
echo "<td>";
if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    
     echo $rowc["sales_date"]." - ".$rowc["quantity"]."<br>";
     $total=$total+$rowc["quantity"];
    
  }
}
echo "<br><b>Total Sales - ".$total."</b>";
echo "</td>";

     
     
     echo "</tr>";


  }
} else {
  
}
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
