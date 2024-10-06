
<style>

#footer {
    margin-top: 50%;
}

table tr td { padding:5px;}
/*
table.table-bordered{
    border:1px solid black;
  }
table.table-bordered > thead > tr > th{
    border:1px solid black;
}
table.table-bordered > tbody > tr > td{
    border:1px solid black;
}
table.table-bordered > tbody > tr > th{
    border:1px solid black;
}
*/
</style>

<?php 

include "../connection.php";

//session_start();

$salesid=$_POST["salesid"];

$user_name="No User";
if(isset($_SESSION["username"])){
$user_name=$_SESSION["username"];
}

$branch_Manager=$_SESSION["Branch_Manager_Name"];
$branch_Address=$_SESSION["Branch_Address"];
$branch_Phone=$_SESSION["Branch_Phone_No"];

// Show Sales Master ................................................................

?>

<div id="ContentDivs" >



<table id="" class="table" style="width:100%; font-size:16px;">
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
  $address=$custom_address.", ";
}


if($up_name!="" && $dis_name!="")
{
   $address=$address."".$up_name.",".$dis_name;
}



$slno=0;

$sql = "SELECT * FROM purchase_master where id=$salesid";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
// output data of each row
while($row = $result->fetch_assoc()) {
$slno++;
$id=$row["id"];
$customerid=$row["supplierid"];
$customer_name="";
$mobileno="";
$user_name=$row["username"];
$proprietor_name="";
/*$insDisCharge=$row["insDisCharge"];
$insDisChargePer=$row["insDisChargePer"];
$payment_no=$row["payment_no"];
$processing_fee=$row["processing_fee"];*/

$sqls = "SELECT name,mobileno,address FROM supplier where id=$customerid";
$results = $conn->query($sqls);

if ($results->num_rows > 0) {
// output data of each row
while($rows = $results->fetch_assoc()) {
$customer_name=$rows["name"];
$customer_address=$rows["address"];
$mobileno=$rows["mobileno"];
//$proprietor_name=$rows["proprietor_name"];
}
} else {
// echo "0 results";
}

$sales_date=$row["purchase_date"];
$grand_total=$row["grand_total"];
$paid=$row["paid"];
$due=$row["due"];
$master_discount=$row["discount"];
$note=$row["note"];

?>

<table id="" class="table" style="width:100%; font-size:16px;">
<thead class="thead-white">

</thead>
<tbody>

<?php

echo "<tr>";

echo "<td style='width:100px;'><img src=$logosrc height='100px' width='100px' style='border-radius:5px;' ></td>
<td style='text-align:left; float:left;'><b><span style='font-size:24px;  font-family: Lucida Console, Courier, monospace;'>".$companyname."</b></span><br>Branch Manager : ".$branch_Manager."<br>".$branch_Address."<br>Contact : ".$branch_Phone."</td>";
echo "<td>Invoice/Bill : <b>$salesid</b> </td>";

echo "</tr>";

echo "</tbody></table>";

?>

<table class="" style="width:100%; font-size:12px; border:1px solid black; padding:5px; ">
<thead class="thead-white">

</thead>
<tbody style="border:1px solid black; padding:5px;">

<?php

echo "<tr style='border:1px solid black; padding-left:5px;'><td colspan='2' style='text-align:left; padding:5px;'><b>Supplier Information</b></td>
<td colspan='2' style='text-align:left;'><b>Other Information</b></td>
</tr>";

echo "<tr>";

echo "<td style='width:20%'><b>Supplier Name</b></td>"; 
echo "<td class='customer_name'>".$customer_name."</td>"; 

echo "<td style='width:20%'><b>Branch Manager</b></td>"; 
echo "<td class='customer_name'>".$branch_Manager."</td>"; 

echo "</tr>";

echo "<tr>";
echo "<td style='width:20%'><b>Proprietor Name</b></td>"; 
echo "<td class='customer_name'>".$proprietor_name."</td>"; 

echo "<td style='width:20%'><b>Branch Address</b></td>"; 
echo "<td class='customer_name'>".$branch_Address."</td>";

echo "</tr>";

echo "<tr>";

echo "<td style='width:20%'><b>Supplier Address</b></td>"; 
echo "<td class='customer_address'>".$customer_address."</td>"; 

echo "<td style='width:20%'><b>Company Address</b></td>"; 
echo "<td class='customer_address'>".$address."</td>"; 

echo "</tr>";

echo "<tr>";

echo "<td style='width:20%'><b>Mobile No</b></td>"; 
echo "<td class=''>".$mobileno."</td>"; 

echo "<td style='width:20%'><b>Branch Mobile No</b></td>"; 
echo "<td class=''>".$branch_Phone."</td>"; 

echo "</tr>";


echo "<tr>";

echo "<td style='width:20%'><b>Date</b></td>"; 
echo "<td class=''>".$row["purchase_date"]."</td>";

echo "<td style='width:20%'><b>Company Mobile No</b></td>"; 
echo "<td class=''>".$mobilenoshop."</td>"; 

echo "</tr>";


}
} else {

}
?>

</tbody>
</table>


<br>

<table id="" class="table table-bordered" style="width:100%; font-size:14px; border:1px solid black;" >
                 
                  
                  
                  
                  <tbody>
                 <tr>
                    <th style='text-align:center;'>#</th>
                    
                    <th>Category</th>
                    <th>Model</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    
                  </tr> 

<?php

// Show Sales Detail .....................................................................................


$sl=0;
$grand_total=0;
$total_qty=0;

$sql = "SELECT * FROM purchase_detail where purchaseid=$salesid";
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

$totalpay=0;



$currentdue=$due-$totalpay;

$sales_by="";
$sql = "SELECT * FROM employee a, sales_master b  where a.id=b.employeeid and b.id=$salesid";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
      $sales_by=$row["name"];
  }
} else {
}

?>

              </tbody>
                  <tfoot style="background-color:white; font-weight: bold;">
                     <tr> <td style='text-align:right;' colspan="3"><td style='text-align:right;' colspan="2">Total Qty : <?php echo $total_qty ?></td><td style='text-align:right;'>Discount : </td> <td><?php echo $master_discount ?></td> </tr>
                     <tr> 
                     <td style='text-align:right;' colspan="3">No of Payment : <?php echo $payment_no; ?><td style='text-align:right;' colspan="2">Installment Discount/Charge : <?php echo $insDisCharge." [".$insDisChargePer."%]"; ?></td>
                     <td style='text-align:right;' colspan="">Grand Total : </td> <td><?php echo $grand_total ?></td> </tr>
                     <tr> <td style='text-align:right;' colspan="5">Processing Fee : <?php echo $processing_fee; ?></td> <td style='text-align:right;' colspan="1">Paid : </td> <td><?php echo $paid ?></td> </tr>
                     <tr> <td style='text-align:right;' colspan="6">Due : </td> <td><?php echo $due ?></td> </tr>
                     
                     <?php if($totalpay>0){ ?>
                     <tr> <td style='text-align:right;' colspan="6">Payment : </td> <td><?php echo $totalpay ?></td> </tr>
                     <tr> <td style='text-align:right;' colspan="6">Current Due : </td> <td><?php echo $currentdue ?></td> </tr>
                     <?php } ?>

                  </tfoot>
                  </table>

                     <!-- $sales_date to date("Y-m-d") -->
                     
                     <?php $sales_date=date("Y-m-d"); ?>

                  <div id="footer"><table  class="table" style="width:100%; font-size:14px;"><tr style='border-top:none;'><td style='text-align:center;'><b>Received By</b></td> <td style='text-align:center;'><b>Prepared By</b><br><?php echo $sales_by." <br>".$sales_date ?></td> <td style='text-align:center;'><b>Checked By</b><br><?php echo $user_name." <br>".$sales_date ?></td> <td style='text-align:center;'><b>Authorized By</b></td> </tr>
</table></div>

</div>



<br>
                  <input type="button" style="width:20%; margin-left:0px; float:left;" onclick="printDiv('ContentDivs')" class="btn btn-success" value="Print receipt">
                  