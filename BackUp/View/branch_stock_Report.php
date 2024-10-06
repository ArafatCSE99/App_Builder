
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
            <h1>Stock Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Stock Report</li>
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
          
          <div class = "form-group">
            <label class = "sr-only" for = "dtfrom">Branch</label>
            
  <select class="form-control" id="s_code">
    <?php 

$subuser_branchid=0;
    if(isset($_SESSION["subuser_branchid"]))
    {
        $subuser_branchid=$_SESSION["subuser_branchid"];
    }

$ctg_id=0;
$ctg_name="";
$sqlsem = "SELECT * FROM branches where user_id=$userid  and company_id=$companyid and ($subuser_branchid=0 OR id=$subuser_branchid)";
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
       <h5 style="margin-top:5px; margin-bottom:10px;"><b><?php echo "Stock Report (Branch)" ?></b><h5></span>
      
    </div>
    <div class="col-sm-2" >
      <?php  ?>
    </div>
  </div>


  <table id="" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                  <th style='text-align:center;'>#</th>
                    <th>Category</th>
                    <th>Model</th>
                    <!--<th style="min-width:120px;">Previous Qty</th>-->
                    <!--<th>Purchase Qty</th>-->
                    <!--<th>Sales Qty</th>-->
                    <th>Current Stock</th>
                    <th>Unit Price (AVG)</th>
                    <th>Total Price (AVG)</th>
                     <th>Discount</th>

                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

     $Total_Purchase=0;
     $Total_Sales= 0;
     $Total_Stock=0;
     $grand_unit_price=0;
     $grand_total_price=0;
     $total_discount=0;


//$sql = "SELECT * FROM category where userid=$userid";
$sql = "SELECT  b.id,b.name as model,a.name FROM category a,product b  where a.id=b.categoryid and a.userid=$userid and a.companyid=$companyid and (categoryid='$s_ctg' or '$s_ctg'='') and (b.id='$s_model' or '$s_model'='' )
";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $name=$row["name"];
    $model=$row["model"];

  

$previous_qty=0;
$stockid=0;
$current_stock=0;
// Get Previous_Qty .......
$sqlc = "SELECT * FROM stock_branch where productid=$id and (branchid='$s_code' or '$s_code'='') ";
$resultc = $conn->query($sqlc);
//echo $sqlc;
if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
   
    
    $current_stock=$current_stock+$rowc["current_stock"];
  }
} else {
 
}

$previous_qty=0;


$purchase_qty=0;
$unit_price=0;
$total_price=0;
$discount_percentage=0;
$times=0;

// Get purchase .......
$sqlc = "SELECT * FROM purchase_detail where productid in (select id from product where id=$id) and 
purchaseid in (
Select purchaseid from stock_warehouse where productid=$id and current_stock>0
union 
Select purchaseid from stock_branch where productid=$id and current_stock>0
)";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
   
    $purchase_qty=$purchase_qty+$rowc["quantity"];
    $unit_price=$unit_price+$rowc["unitprice"];
    $discount_percentage=$discount_percentage+$rowc["percentage"];
    $times++;
  }
} else {
 
}




$sqla = "Select round( (Sum(unitprice*current_stock)/Sum(current_stock) ),2) as avgprice from ( Select a.unitprice,b.current_stock from purchase_detail a, stock_branch b where a.purchaseid=b.purchaseid and a.productid=b.productid and b.current_stock>0 and a.productid=$id  and (branchid='$s_code' or '$s_code'='') ) NewT";
  $resulta = $conn->query($sqla);
  
  if ($resulta->num_rows > 0) {
    // output data of each row
    while($rowa = $resulta->fetch_assoc()) {
      $avg_price= $rowa["avgprice"];
    }
  } else {
    $avg_price= 0;
  }

if($times>0)
{
    $unit_price=$avg_price;//$unit_price/$times;
    $total_price=$unit_price*$current_stock;
    $discount_percentage=$discount_percentage/$times;
}


$sales_qty=0;

// Get Sales .......
$sqlc = "SELECT * FROM sales_detail where productid in (select id from product where id=$id )";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
   
    $sales_qty=$sales_qty+$rowc["quantity"];
  }
} else {
 
}


//$current_stock=($previous_qty+$purchase_qty)-$sales_qty;

// End Get Product stock ...

     if($current_stock>0){

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='name'>".$name."</td>"; 
     echo "<td class=''>".$model."</td>"; 
    // echo "<td class=''>".$purchase_qty."</td>"; 
    // echo "<td class=''>".$sales_qty."</td>"; 
     echo "<td class=''><b>".$current_stock."</b></td>"; 
     echo "<td class=''><b>".round($unit_price,2)."</b></td>"; 
     echo "<td class=''><b>".round($total_price,2)."</b></td>"; 
     echo "<td class=''>".round($discount_percentage,2)." %</td>"; 
     echo "</tr>";
      
     $Total_Purchase=$Total_Purchase+$purchase_qty;
     $Total_Sales= $Total_Sales+$sales_qty;
     $Total_Stock=$Total_Stock+$current_stock;
     $grand_unit_price=$grand_unit_price+$unit_price;
     $grand_total_price=$grand_total_price+$total_price;
     $total_discount=$total_discount+$discount_percentage;
     
     }

  }
} else {
  
}

$td=($total_discount/$slno);

echo "<tr>";

echo "<td class='' colspan='3'><b>Grand Total</b></td>";
    // echo "<td class=''><b>".$Total_Purchase."</b></td>";
    // echo "<td class=''><b>".$Total_Sales."</b></td>";
     echo "<td class=''><b>".$Total_Stock."</b></td>";
      echo "<td class=''><b>".round($grand_unit_price,2)."</b></td>";
     echo "<td class=''><b>".round($grand_total_price,2)."</b></td>";
     echo "<td class=''><b>".round( $td,2)." %</b></td>";

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
