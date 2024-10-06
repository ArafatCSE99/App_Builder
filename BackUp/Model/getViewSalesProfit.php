
<style>

#footer {
    margin-top: 50%;
}
</style>

<?php 

include "../connection.php";

//session_start();

$salesid=$_POST["salesid"];

$user_name="No User";
if(isset($_SESSION["username"])){
$user_name=$_SESSION["username"];
}
// Show Sales Master ................................................................

?>

<div id="ContentDiv">



<table id="" class="" style="width:100%; font-size:16px;">
<thead class="thead-white">

</thead>
<tbody>

<?php

$companyid=$_SESSION["companyid"];
$branchid=$_SESSION["branchid"];

// Get Company Data ..................................................

$companyname="Shop Name";
$logosrc="dist/img/global_logo.png";

$sql = "SELECT * FROM basic_info where userid=(select userid from sales_master where id=$salesid) and companyid=$companyid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $companyname=$row["shop_name"];
    $logo=$row["logo"];
    $logosrc=$logo==""?"dist/img/global_logo.png":"imageUpload/uploads/".$logo;
 $mobilenoshop=$row["mobileno"];
 $facebook=$row["facebook"];
 $shopcategory=$row["shop_categoryid"];
 $division=$row["division_id"];
 $district=$row["district_id"];
 $upazilla=$row["upazila_id"];
 $custom_address=$row["address"];
  }
} else {
  
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
if($custom_address!="")
{
  $address=$custom_address."<br>";
}


if($up_name!="" && $dis_name!="")
{
   $address=$address."".$up_name.",".$dis_name;
}



$slno=0;

$sql = "SELECT * FROM sales_master where id=$salesid";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
// output data of each row
while($row = $result->fetch_assoc()) {
$slno++;
$id=$row["id"];
$customerid=$row["customerid"];
$customer_name="";
$mobileno="";
$user_name=$row["username"];
$proprietor_name="";
$sales_from=$row["sales_from"];

$sqls = "SELECT name,mobileno,address,proprietor_name FROM customer where id=$customerid";
$results = $conn->query($sqls);

if ($results->num_rows > 0) {
// output data of each row
while($rows = $results->fetch_assoc()) {
$customer_name=$rows["name"];
$customer_address=$rows["address"];
$mobileno=$rows["mobileno"];
$proprietor_name=$rows["proprietor_name"];
}
} else {
// echo "0 results";
}

$sales_date=$row["sales_date"];
$grand_total=$row["grand_total"];
$paid=$row["paid"];
$due=$row["due"];
$master_discount=$row["discount"];
$note=$row["note"];



echo "<tr>";

echo "<td style='width20%;'><img src=$logosrc height='100px' width='100px' style='border-radius:5px;' ></td><td style='width:20%;'></td>
<td style='text-align:center; float:left;'colspan='4'><b><span style='font-size:24px;  font-family: Lucida Console, Courier, monospace;'>".$companyname."</b></span><br>".$address."<br>Contact : ".$mobilenoshop."</td>";

echo "</tr>";

//echo "<tr><td colspan='5' style='text-align:center;'>Recipt</td></tr>";

echo "<tr>";
echo "<td style='width:20%'><b>Customer Name</b></td>"; 
echo "<td class=''>".$customer_name."</td>"; 
echo "</tr>";

echo "<tr>";
echo "<td style='width:20%'><b>Sales Date</b></td>"; 
echo "<td class=''>".$row["sales_date"]."</td>"; 
echo "</tr>";


}
} else {

}
?>

</tbody>
</table>


<br>

<table border='2' style="width:100%; font-size:16px; border:2px solid gray;" >
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    
                    <th>Category</th>
                    <th>Model</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    
                  </tr>
                  </thead>
                  <tbody>


<?php

// Show Sales Detail .....................................................................................


$sl=0;
$grand_total=0;
$total_qty=0;

$sql = "SELECT * FROM sales_detail where salesid=$salesid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {

    $sl++;
    $detailid=$row["id"];
    $productid=$row["productid"];
    
    // Get Product Name ........................................
    $productname="";
    $sqlp = "SELECT a.code,a.name,a.model,b.name as categoryname FROM product a, category b where a.id=$productid and a.categoryid=b.id";
    $resultp = $conn->query($sqlp);
    
    if ($resultp->num_rows > 0) {
      // output data of each row
      while($rowp = $resultp->fetch_assoc()) {
        $code=$rowp["code"];
        $productname=$rowp["name"];
        $model=$rowp["model"];
        $categoryname=$rowp["categoryname"];
      }
    } else {
      //echo "0 results";
    }

    $quantity=$row["quantity"];
    $total_price=$row["total_price"];
    $total_qty=$total_qty+$quantity;
    $grand_total=$grand_total+$total_price;
    
    $discount_percent=0;
    if($row["discount"]>0)
    {
        $discount_percent=( ($row["discount"]*100)/($row["unitprice"]*$row['quantity']) );
    }
    

    echo "<tr>";
    echo "<td style='text-align:center; width:15%;'>".$sl."</td>";
    echo "<td>".$categoryname."</td>";
    echo "<td>".$productname."</td>";
    echo "<td>".$row["unitprice"]."</td>";
    echo "<td>".$row["discount"]." (".$discount_percent."%)</td>";
    echo "<td>".$quantity."</td>";
    echo "<td>".$total_price."</td>";
    echo "</tr>";
    
    
    // Details TR 
    
    echo "<tr>";
    echo "<td  colspan='7'>Product Details <br>";
    echo "<table border='2' style='width:100%; font-size:16px; border:2px solid gray;'>";
    echo "<tr>";
    echo "<th>Purchase Date</th>";
    echo "<th>Purchase Price</th>";
    echo "<th>Purchase Qty</th>";
    echo "<th>Sales Qty</th>";
    echo "<th>Warehouse Stock</th>";
    echo "<th>Branch Stock</th>";
   // echo "<th>Average Price</th>";
    echo "</tr>";
    
$sqlsp = "SELECT a.id as purchaseid,b.unitprice,b.quantity,a.purchase_date  FROM purchase_detail b,purchase_master a where a.id=b.purchaseid and productid=$productid and a.purchase_date<='$sales_date'";  
//echo $sqlsp;
$resultsp = $conn->query($sqlsp);

if ($resultsp->num_rows > 0) {
  // output data of each row
  while($rowsp = $resultsp->fetch_assoc()) {
    $_purchaseid=$rowsp["purchaseid"];
    $_purchase_price=$rowsp["unitprice"];
    $_purchase_date=$rowsp["purchase_date"];
    $_purchase_qty=$rowsp["quantity"];
    echo "<tr>";
    echo "<td>".$_purchase_date."</td>";
    echo "<td>".$_purchase_price."</td>";
    echo "<td>".$_purchase_qty."</td>";
    
    $_sales_qty=0;
   
         $sqlsq = "
         select sum(t.quantity) as quantity from
         (SELECT sum(quantity) as quantity from sales_detail where stockid in(select id from stock_branch where purchaseid=$_purchaseid) and productid=$productid 
            union all
            SELECT sum(quantity) as quantity from sales_detail where stockid in(select id from stock_warehouse where purchaseid=$_purchaseid) and productid=$productid) as t ";
    //echo $sqlsq;
    $resultsq = $conn->query($sqlsq);

if ($resultsq->num_rows > 0) {
  // output data of each row
  while($rowsq = $resultsq->fetch_assoc()) {
      $_sales_qty=$rowsq["quantity"];
  }
}
    
    $_warehouse_stock=0;
    $sqlsq = "SELECT current_stock from stock_warehouse where purchaseid=$_purchaseid and productid=$productid ";
    $resultsq = $conn->query($sqlsq);
    //echo $sqlsq;
if ($resultsq->num_rows > 0) {
  // output data of each row
  while($rowsq = $resultsq->fetch_assoc()) {
      $_warehouse_stock=$rowsq["current_stock"];
  }
}


$_branch_stock=0;
    $sqlsq = "SELECT current_stock from stock_branch where purchaseid=$_purchaseid and productid=$productid ";
    $resultsq = $conn->query($sqlsq);

if ($resultsq->num_rows > 0) {
  // output data of each row
  while($rowsq = $resultsq->fetch_assoc()) {
      $_branch_stock=$rowsq["current_stock"];
  }
}
    
    echo "<td>".$_sales_qty."</td>";
    echo "<td>".$_warehouse_stock."</td>";
    echo "<td>".$_branch_stock."</td>";
    //echo "<td></td>";
    echo "</tr>";
    
  }
}
    
    
    echo "</table>";
    echo "<td>";
    echo "<tr>";

    

  }
} else {
  
}





// Payment . . . . . . . .

$sql = "SELECT * FROM sales_payment where salesid=$salesid";
$result = $conn->query($sql);

$totalpay=0;

if ($result->num_rows > 0) {
  $psl=1;
  
  while($row = $result->fetch_assoc()) {
    $id=$row["id"];
   
    $totalpay=$totalpay+$row["amount"];
  }
} else {
}

$currentdue=$due-$totalpay;

$sales_by="";
$sql = "SELECT * FROM employee a, slaes_master b  where a.id=b.empolyeeid and b.id=$salesid";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
      $sales_by=$row["name"];
  }
} else {
}

?>

              </tbody>
                  <tfoot style="background-color:white; font-weight: bold; display:none;">
                     <tr> <td style='text-align:right;' colspan="3"><td style='text-align:right;' colspan="2">Total Profit : <?php echo $total_qty ?></td> </tr>
                  </tfoot>
                  </table>

                     <!-- $sales_date to date("Y-m-d") -->
                     
                     <?php $sales_date=date("Y-m-d"); ?>

</div>



<br>
                  <input type="button" style="width:20%; margin-left:0px; float:left;" onclick="printDiv('ContentDiv')" class="btn btn-success" value="Print Sales Profit">
                  