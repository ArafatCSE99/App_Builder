
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
            <h1>Profit Detail Report  
            
           
            </h1> 

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Profit Detail Report</li>
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


include "../Model/Parameter_ReportSearch.php"; 

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

           <div id="Report" style="border:2px solid gray; overflow:auto;">


  <div class="row">
    <div class="col-sm-2">
    <?php $logosrc="imageUpload/uploads/".$logo; if($logo=="") {echo "<img src='dist/img/global_logo.png' height='100px' width='100px' >"; } else { echo "<img src=$logosrc height='100px' width='100px' style='padding:10px; border-radius:20px;'>"; } ?>    </div>
    <div class="col-sm-8" >
       <center><h3 style="  font-family: Lucida Console, Courier, monospace;"><?php echo $shopname ?></h3></center>
       <center><?php echo $address ?></center>
       <center><?php echo "Contact No : ".$mobileno ?></center>
       <center><h5 style="margin-top:5px; margin-bottom:10px;"><b><?php echo "Profit Detail Report" ?></b><h5></span></center>
       <?php 
         if($s_dtfrom!="")
         {
          echo "<center><h5 style='margin-top:5px; margin-bottom:10px;'><b>Date From ".$s_dtfrom." To ".$s_dtto."</b><h5></span></center>";
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
                    <th style='width:100px;'>Date</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th style='width:200px;'>Model/Type</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                    <th>Purchase Price</th>
                    <th>Profit</th>
                   
                    
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

     $Total_Qty=0;
     $Total_Price=0;
     $Total_Due=0;
     $Total_Purchase_Price=0;
     $Total_Profit=0;
     $Total_Payment=0;
     

$sql = "SELECT a.id,a.name,a.image,a.categoryid,a.code,a.model,b.quantity,b.unitprice,b.total_price,c.sales_date,c.id as sales_id,c.due FROM product a,sales_detail b,sales_master c where a.id=b.productid and b.salesid=c.id and a.userid=$userid and (a.categoryid='$s_ctg' or '$s_ctg'='') and (a.model='$s_model' or '$s_model'='') and (a.code='$s_code' or '$s_code'='') and (a.name='$s_name' or '$s_name'='')";
//echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $name=$row["name"];
    if($row["image"]!="")
    {
      $imageurl="imageUpload/uploads/".$row["image"];

    }
    else{
      $imageurl="dist/img/global_logo.png";
    }
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

$var = $row['sales_date'];
$dt = str_replace('/', '-', $var);
$dt=date('Y-m-d', strtotime($dt));

if(($dt>=$s_dtfrom && $dt<=$s_dtto) or $s_dtfrom==""){

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='total_price'>".$row['sales_date']."</td>"; 
     echo "<td class='code'>".$row['code']."</td>"; 
     echo "<td class='name'>".$name."</td>"; 
     
     echo "<td class='category'>".$categoryname."</td>"; 
     echo "<td class='model'>".$row['model']."</td>"; 

     echo "<td class='quantity'>".$row['quantity']."</td>"; 
     echo "<td class='unitprice'>".$row['unitprice']."</td>"; 
     echo "<td class='total_price'>".$row['total_price']."</td>"; 

$purchase_price=0;
$sqlc = "SELECT * FROM price_manager where productid=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    
    $purchase_price=$rowc["purchase_price"];
   
  }
} else {
 
}

$purchase_price=$purchase_price==""?0:$purchase_price;
$purchase_price=$purchase_price*$row['quantity'];
$purchase_price=$purchase_price==0?$row['total_price']:$purchase_price;

$profit=$row['total_price']-$purchase_price;

echo "<td class=''><b>".$purchase_price."</b></td>";
echo "<td class=''><b>".$profit."</b></td>";
     
    
     echo "</tr>";

     $Total_Qty=$Total_Qty+$row['quantity'];
     $Total_Price=$Total_Price+$row['total_price'];
     $Total_Purchase_Price= $Total_Purchase_Price+$purchase_price;
     $Total_Profit=$Total_Profit+$profit;
     $Total_Due=$Total_Due+$row['due'];
     
     
     // Payment ..........................
$sales_id=$row['sales_id'];
$totalpay=0;



$sqlp = "SELECT * FROM sales_payment where salesid=$sales_id";
$resultp = $conn->query($sqlp);

if ($resultp->num_rows > 0) {

  while($rowp = $resultp->fetch_assoc()) {
      
$var = $rowp['payment_date'];
$pt = str_replace('/', '-', $var);
$pt=date('Y-m-d', strtotime($pt));
      
      //if(($pt>=$s_dtfrom && $pt<=$s_dtto) or $s_dtfrom==""){
        $totalpay=$totalpay+$rowp["amount"];
      //}
  }

}

$Total_Payment=$Total_Payment+$totalpay;
     
     
     

}

  }
} else {
  
}

echo "<tr>";
echo "<td class='' colspan='6'><b>Grand Total</b></td>";
     echo "<td class=''><b>".$Total_Qty."</b></td>";
     echo "<td></td>";
     echo "<td class=''><b>".$Total_Price."</b></td>";
     echo "<td class=''><b>".$Total_Purchase_Price."</b></td>";
     echo "<td class=''><b>".$Total_Profit."</b></td>";
echo "</tr>";


// Get Expense ..................................

$expense=0;
$sqlc = "SELECT * FROM expense where userid=$userid";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    
   
$var = $rowc["expense_date"];
$dt = str_replace('/', '-', $var);
$dt=date('Y-m-d', strtotime($dt));

if(($dt>=$s_dtfrom && $dt<=$s_dtto) or $s_dtfrom==""){
    
    $expense=$expense+$rowc["amount"];
}


   
  }
} else {
 
}


echo "<tr>";
echo "<td class='' colspan='6'><b>Total Expense</b></td>";
     echo "<td class=''><b></b></td>";
     echo "<td></td>";
     echo "<td class=''><b></b></td>";
     echo "<td class=''><b></b></td>";
     echo "<td class=''><b>".$expense."</b></td>";
echo "</tr>";


//...............................................

$net_profit=$Total_Profit-$expense;

echo "<tr>";
echo "<td class='' colspan='6'><b>Net Profit</b></td>";
     echo "<td class=''><b></b></td>";
     echo "<td></td>";
     echo "<td class=''><b></b></td>";
     echo "<td class=''><b></b></td>";
     echo "<td class=''><b>".$net_profit."</b></td>";
echo "</tr>";


echo "<tr>";
echo "<td class='' colspan='6'><b>Total Due</b></td>";
     echo "<td class=''><b></b></td>";
     echo "<td></td>";
     echo "<td class=''><b></b></td>";
     echo "<td class=''><b></b></td>";
     echo "<td class=''><b>".$Total_Due."</b></td>";
echo "</tr>";


echo "<tr>";
echo "<td class='' colspan='6'><b>Total Payment</b></td>";
     echo "<td class=''><b></b></td>";
     echo "<td></td>";
     echo "<td class=''><b></b></td>";
     echo "<td class=''><b></b></td>";
     echo "<td class=''><b>".$Total_Payment."</b></td>";
echo "</tr>";


$Actual_Profit=$net_profit-$Total_Due+$Total_Payment;

if($Actual_Profit<0)
{
    $Actual_Profit=0;
}

echo "<tr>";
echo "<td class='' colspan='6'><b>Actual Profit</b></td>";
     echo "<td class=''><b></b></td>";
     echo "<td></td>";
     echo "<td class=''><b></b></td>";
     echo "<td class=''><b></b></td>";
     echo "<td class=''><b>".$Actual_Profit."</b></td>";
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
