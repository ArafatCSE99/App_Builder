
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
            <h1>Purchase Detail Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Purchase Report</li>
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
            <label class = "sr-only" for = "">Category</label>
            
  <select class="form-control s_parameter" id="s_customer">
    <?php 

$ctg_id=0;
$ctg_name="";
$sqlsem = "SELECT * FROM category where userid=$userid and companyid=$companyid";
$resultse = $conn->query($sqlsem);
echo "<option value='0' hidden=''>Select Category</option>";
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
         
         
           <div class = "form-group"  id='customerDiv'>
            <label class = "sr-only" for = "">Model</label>
            
  <select class="form-control s_parameter" id="s_model">
    <?php 

$ctg_id=0;
$ctg_name="";
$sqlsem = "SELECT * FROM product where userid=$userid and companyid=$companyid";
$resultse = $conn->query($sqlsem);
echo "<option value='0' hidden=''>Select Model</option>";
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


 $sqls = "SELECT name FROM category where id=$s_customer";
    $results = $conn->query($sqls);

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
       <center><h5 style="margin-top:5px; margin-bottom:10px;"><b><?php echo "Purchase Report" ?></b><h5></span></center>
       <?php 
         if($s_dtfrom!="")
         {
          echo "<center><h5 style='margin-top:5px; margin-bottom:10px;'><b>Category : ".$customer_name." <br> Date From ".$s_dtfrom." To ".$s_dtto."</b><h5></span></center>";
         }
         else{
          echo "<center><h5 style='margin-top:5px; margin-bottom:10px;'><b>Category : ".$customer_name."</b><h5></span></center>";
         }
         
       ?>
    </div>
    <div class="col-sm-2" >
      <?php  ?>
    </div>
  </div>

                
                <!-- Purchase -->
                
                
                
                
                
                

  <table id="" class="table-design">
                  <thead class="thead-light">
                  <tr><th  colspan='9'><b>Purchase</b></th></tr>      
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Model</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Discount</th>
                    <th>Total Price</th>
                    <th>Unit Price(Avg)</th>
                    <th>Total Price(Avg)</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;
$grand_qty=0;
$grand_unitprice=0;
$grand_discount=0;
$grand_total_price=0;
$grand_unitprice_avg=0;
$grand_total_price_avg=0;
$total_discount_percentage=0;
$counter=0;

$sql = "SELECT a.id,a.name,a.image,a.categoryid,a.code,a.model,b.quantity,b.unitprice,b.msrp_price,b.percentage,b.total_price,c.purchase_date FROM product a,purchase_detail b,purchase_master c where a.id=b.productid and b.purchaseid=c.id and c.userid=$userid and (a.categoryid=$s_customer or $s_customer=0 ) and (a.id=$s_model or $s_model=0 )  order by c.purchase_Date";
//echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    
    $model=$row["name"];
    $purchase_date=$row["purchase_date"];
    $qty=$row["quantity"];
    $unitprice=$row["unitprice"];
    $msrp_price=$row["msrp_price"];
    $total_price=$row["total_price"];
    $discount=$msrp_price-$unitprice;
    $discount_percentage=$row["percentage"];
    
    $categoryid=$row["categoryid"];
    $categoryname="";
$sqlc = "SELECT * FROM category where id=$categoryid";
$resultc = $conn->query($sqlc);
if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $categoryname=$rowc["name"];
  }
} 


$productid=$row["id"];
$avg=0;
$sqlc = "SELECT sum(total_price)/sum(quantity) as avg FROM purchase_detail where productid=$productid and purchaseid in (select purchaseid from stock_warehouse where current_stock>0)";
$resultc = $conn->query($sqlc);
if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $avg=$rowc["avg"];
  }
} 

$total_avg=$avg*$qty;


$var = $row['purchase_date'];
$dt = str_replace('/', '-', $var);
$dt=date('Y-m-d', strtotime($dt));

if(($dt>=$s_dtfrom && $dt<=$s_dtto) or $s_dtfrom==""){




     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='customer_name' style='width:100px;'>".$purchase_date."</td>"; 
     echo "<td class='reference'>".$categoryname."</td>";
     echo "<td class='mobileno'>".$model."</td>"; 
     echo "<td class='payment_date'>".$qty."</td>";
     echo "<td class='payment_date'>".round($unitprice,2)."</td>";
      echo "<td class='mobileno'>".round($discount,2)." [".$discount_percentage."%]</td>"; 
     echo "<td class='reference'>".round($total_price,2)."</td>";
     echo "<td class='payment_date'>".round($avg,2)."</td>";
     echo "<td class='payment_date'>".round($total_avg,2)."</td>";
     echo "</tr>";
     
     
$grand_qty=$grand_qty+$qty;
$grand_unitprice=$grand_unitprice+$unitprice;
$grand_discount=$grand_discount+$discount;
$grand_total_price=$grand_total_price+$total_price;
$grand_unitprice_avg=$grand_unitprice_avg+$avg;
$grand_total_price_avg=$grand_total_price_avg+$total_avg;
$total_discount_percentage=$total_discount_percentage+$discount_percentage;
$counter++;
     
}


  }
} else {
  
}

if($total_discount_percentage>0){
$total_discount_percentage=round(($total_discount_percentage/$counter),2);
}

echo "<tr>";

echo "<td class='' colspan='4'><b>Total Purchase</b></td>";
    
echo "<td class=''><b>".round($grand_qty,2)."</b></td>";
echo "<td class=''><b>".round($grand_unitprice,2)."</b></td>";
echo "<td class=''><b>".round($grand_discount,2)." [".$total_discount_percentage."%]</b></td>";
echo "<td class=''><b>".round($grand_total_price,2)."</b></td>";
echo "<td class=''><b>".round($grand_unitprice_avg,2)."</b></td>";
echo "<td class=''><b>".round($grand_total_price_avg,2)."</b></td>";
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
