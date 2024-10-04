
<?php

include "../connection.php";

session_start(); 

$userid=$_SESSION["userid"];

// Content  ......................................................

?>

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

           <div id="Report" style="border:2px solid gray; overflow:auto;" >


  <div class="row">
    <div class="col-sm-2">
      <?php $logosrc="imageUpload/uploads/".$logo; if($logo=="") {echo "<img src='dist/img/global_logo.png' height='100px' width='100px' >"; } else { echo "<img src=$logosrc height='100px' width='100px' style='padding:10px; border-radius:20px;'>"; } ?>
    </div>
    <div class="col-sm-8" >
       <center><h3 style="  font-family: Lucida Console, Courier, monospace;"><?php echo $shopname ?></h3></center>
       <center><?php echo $address ?></center>
       <center><?php echo "Contact No : ".$mobileno ?></center>
       <center><h5 style="margin-top:5px; margin-bottom:10px;"><b><?php echo "Profit Report" ?></b><h5></span></center>
      
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
                    <th>Customer</th>
                    <th>Mobile No</th>
                    <th>Date</th>
                    <th>Purchase Price</th>
                    <th>Sales Price</th>
                    <th>Profit</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

$Total_Purchase=0;
$Total_Sales=0;
$Total_Profit=0;

$sql = "SELECT * FROM sales_master where userid=$userid";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $customerid=$row["customerid"];
    $customer_name="";
    $mobileno="";

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
    $paid=$row["paid"]+$totalpay;
    $due=$row["due"]-$totalpay;
    $note=$row["note"];

    $purchase_price=0;

    // Get Purchase Price . . . .

    $sqlp="select sum(a.purchase_price*b.quantity) as price from price_manager a,sales_detail b where a.productid=b.productid and b.salesid=$id";
    $resultp = $conn->query($sqlp);
    $rowp = $resultp->fetch_assoc();
    $purchase_price=$rowp["price"];

    // . . . . . . . . . . . .  .
    $profit=$row["total_price"]-$purchase_price;

    $Total_Purchase=$Total_Purchase+$purchase_price;
    $Total_Sales=$Total_Sales+$row["total_price"];
    $Total_Profit=$Total_Profit+$profit;

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td style='display:none;' class='customerid  HideAfterDT'>".$customerid."</td>"; 
     echo "<td class='customer_name'>".$customer_name."</td>"; 
     echo "<td class='mobileno'>".$mobileno."</td>"; 
     echo "<td class='sales_date'>".$row["sales_date"]."</td>";
     echo "<td class=''>".$purchase_price."</td>";
     echo "<td class='total_price'>".$row["total_price"]."</td>";
     echo "<td class='profit'>".$profit."</td>";

     
     
     echo "</tr>";

  }
} else {
  
}


echo "<tr>";

echo "<td class='' colspan='4'><b>Grand Total</b></td>";
     echo "<td class=''><b>".$Total_Purchase."</b></td>";
     echo "<td class=''><b>".$Total_Sales."</b></td>";
     echo "<td class=''><b>".$Total_Profit."</b></td>";

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
