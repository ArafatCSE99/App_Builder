
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
            <h1>Product Stock Price Report  
            
           
            </h1> 

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


      <form class = "form" role = "form" style='display:none;'>

     
         <div class = "form-group">
            <label class = "sr-only" for = "dtfrom">Category</label>
            
  <select class="form-control" id="s_ctg" >
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
         
          <br>
          
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
         
         <br>
          
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
                <button class='btn btn-primary' style='margin-left:10px;' onclick="getcontent('visiting_info')">Add Visiting Info</button>
              </h3> 
              </div>
              <!-- /.card-header -->
              <div class="card-body" id="section-to-print">

           <div id="Report" style="border:0px solid gray; ">


  <?php
    include "../Model/ReportHeading.php";
  ?>

                <table id="example1" class="table table-bordered " style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='width:100%;'>Product Stock Price</th>
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


// Purchase .......................
$purchase_Qty=0;
$sqlc = "SELECT sum(quantity) as Purchase_qty FROM purchase_master a,purchase_detail b where a.id=b.purchaseid and b.productid=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    
     $purchase_Qty=$rowc["Purchase_qty"];
    
  }
}







// branch .......................
$branch_current_stock=0;
$sqlc = "SELECT sum(current_stock) as current_stock FROM stock_branch where productid=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
     
      $branch_current_stock=$rowc["current_stock"];
    
  }
}


  // Sales .......................
$sales_qty=0;
$sqlc = "SELECT sum(quantity) as total_quantity FROM sales_master a,sales_detail b where a.id=b.salesid and b.productid=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    
     $sales_qty=$rowc["total_quantity"];
    
  }
}

// avg Price .....................
$purchase_unitprice=0;


$sqla = "Select round( (Sum(unitprice*current_stock)/Sum(current_stock) ),2) as avgprice from ( Select a.unitprice,b.current_stock from purchase_detail a, stock_branch b where a.purchaseid=b.purchaseid and a.productid=b.productid  and b.current_stock>0 and a.productid=$id  ) NewT";
  $resulta = $conn->query($sqla);
  
  if ($resulta->num_rows > 0) {
    // output data of each row
    while($rowa = $resulta->fetch_assoc()) {
      $purchase_unitprice= $rowa["avgprice"];
    }
  } else {
    $purchase_unitprice= 0;
  }
  
  
  $purchase_unitprice_wh=0;


$sqla = "Select round( (Sum(unitprice*current_stock)/Sum(current_stock) ),2) as avgprice from (Select a.unitprice,b.current_stock from purchase_detail a, stock_warehouse b where a.purchaseid=b.purchaseid and a.productid=b.productid  and b.current_stock>0 and a.productid=$id ) NewT";
  $resulta = $conn->query($sqla);
  
  if ($resulta->num_rows > 0) {
    // output data of each row
    while($rowa = $resulta->fetch_assoc()) {
      $purchase_unitprice_wh= $rowa["avgprice"];
    }
  } else {
    $purchase_unitprice_wh= 0;
  }



     echo "<tr>";
     echo "<td>";
     echo "<b>Model :</b> ".$name."<br>";
     echo "<b>Category :</b> ".$categoryname."<br>";
      echo "<b>Purchase Qty :</b> ".$purchase_Qty."<br>";
       echo "<b>Sales Qty :</b> ".$sales_qty."<br>";
        //echo "<b>Warehouse Current Stock :</b> ".$warehouse_current_stock."<br>";
        
$ctg_id=0;
$ctg_name="";
$sqlsem = "SELECT * FROM warehouse where userid=$userid and companyid=$companyid";
$resultsem = $conn->query($sqlsem);
//echo $sqlsem;
if ($resultsem->num_rows > 0) {
   
    while($rowsem = $resultsem->fetch_assoc()) {
       $ctg_id=$rowsem["id"];
       $ctg_name=$rowsem["name"];
       
       

 // Warehouse .......................
$warehouse_current_stock=0;
$sqlc = "SELECT sum(current_stock) as current_stock FROM stock_warehouse where productid=$id and warehouseid=$ctg_id";
$resultc = $conn->query($sqlc);
//echo $sqlc;
if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
     
      $warehouse_current_stock=$rowc["current_stock"];
      echo "<b>".$ctg_name." :</b> ".$warehouse_current_stock."<br>";
  }
}

       
       

    }
} 



        
        
          echo "<b>Branch Current Stock :</b> ".$branch_current_stock."<br>";
          echo "<b>Average Price (Warehouse) :</b> ".$purchase_unitprice_wh."<br>";
          echo "<b>Average Price (Branch) :</b> ".$purchase_unitprice."<br>";
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
