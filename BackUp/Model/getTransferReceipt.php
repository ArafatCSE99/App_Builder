
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



<table id="" class="table" style="width:100%; font-size:18px;">
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

$sql = "SELECT * FROM stock_transfer_master where id=$salesid";
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

$sqls = "SELECT name FROM branches where id=$customerid";
$results = $master_conn->query($sqls);

if ($results->num_rows > 0) {
// output data of each row
while($rows = $results->fetch_assoc()) {
$customer_name=$rows["name"];
//$customer_address=$rows["address"];
//$mobileno=$rows["mobileno"];
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

echo "<td style='width:20%'><b>Branch Name</b></td>"; 
echo "<td class='customer_name'>".$customer_name."</td>"; 

echo "</tr>";
/*
echo "<tr>";

echo "<td style='width:20%'><b>Customer Address</b></td>"; 
echo "<td class='customer_address'>".$customer_address."</td>"; 

echo "</tr>";

echo "<tr>";

echo "<td style='width:20%'><b>Mobile No</b></td>"; 
echo "<td class=''>".$mobileno."</td>"; 

echo "</tr>";

*/
echo "<tr>";

echo "<td style='width:20%'><b>Transfer Date</b></td>"; 
echo "<td class=''>".$row["sales_date"]."</td>"; 

echo "</tr>";


}
} else {

}
?>

</tbody>
</table>


<br>

<table id="" class="table" style="width:100%; font-size:18px;" >
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

$sql = "SELECT * FROM stock_transfer_detail where salesid=$salesid";
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
   
    $totalpay=0; //$totalpay+$row["amount"];
  }
} else {
}

$currentdue=$due-$totalpay;

?>

              </tbody>
                  <tfoot style="background-color:white; font-weight: bold;">
                     <tr> <td style='text-align:right;' colspan="3"><td style='text-align:right;' colspan="2">Total Qty : <?php echo $total_qty ?></td><td style='text-align:right;'>Discount : </td> <td><?php echo $master_discount ?></td> </tr>
                     <tr> <td style='text-align:right;' colspan="6">Grand Total : </td> <td><?php echo $grand_total ?></td> </tr>
                     <tr> <td style='text-align:right;' colspan="6">Paid : </td> <td><?php echo $paid ?></td> </tr>
                     <tr> <td style='text-align:right;' colspan="6">Due : </td> <td><?php echo $due ?></td> </tr>
                     
                     <?php if($totalpay>0){ ?>
                     <tr> <td style='text-align:right;' colspan="6">Payment : </td> <td><?php echo $totalpay ?></td> </tr>
                     <tr> <td style='text-align:right;' colspan="6">Current Due : </td> <td><?php echo $currentdue ?></td> </tr>
                     <?php } ?>

                  </tfoot>
                  </table>


                  <div id="footer"><table  class="table" style="width:100%; font-size:18px;"><tr style='border-top:none;'><td style='text-align:center;'>Received By</td> <td style='text-align:center;'>Prepared By</td> <td style='text-align:center;'>Checked By<br><?php echo $user_name." <br>".$sales_date ?></td> <td style='text-align:center;'>Authorized By</td> </tr>
</table></div>

</div>



<br>
                  <input type="button" style="width:20%; margin-left:0px; float:left;" onclick="printDiv('ContentDiv')" class="btn btn-success" value="Print receipt">
                  