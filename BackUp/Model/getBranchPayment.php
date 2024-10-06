<?php 

include "../connection.php";

$sales_branchid=$_POST["branchid"];
$due=$_POST["due"];
$companyid=$_SESSION["companyid"];
$branchid=$_SESSION["branchid"];
// Get Company Data ..................................................

$companyname="Shop Name";
$logosrc="dist/img/global_logo.png";

$sql = "SELECT * FROM basic_info where companyid=$companyid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $companyname=$row["shop_name"];
    $logo=$row["logo"];
    $logosrc="imageUpload/uploads/".$logo;
 $mobilenoshop=$row["mobileno"];
 $facebook=$row["facebook"];
 $shopcategory=$row["shop_categoryid"];
 $division=$row["division_id"];
 $district=$row["district_id"];
 $upazilla=$row["upazila_id"];
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
if($up_name!="" && $dis_name!="")
{
   $address=$up_name.",".$dis_name;
}




    $customer_name="";
    $mobileno="";

    $sqls = "SELECT name FROM branches where id=$sales_branchid";
    $results = $master_conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $customer_name=$rows["name"];
  }
} else {
}


// Show Sales Master ................................................................

?>

<div id="ContentDiv">

<div class="row">
    <div class="col-sm-2">
      <?php $logosrc="imageUpload/uploads/".$logo; if($logo=="") {echo "<img src='dist/img/global_logo.png' height='100px' width='100px' >"; } else { echo "<img src=$logosrc height='100px' width='100px' style='padding:10px; border-radius:20px;'>"; } ?>
    </div>
    <div class="col-sm-8" >
       <center><h3 style="  font-family: Lucida Console, Courier, monospace;"><?php echo $companyname ?></h3></center>
       <center><?php echo $address ?></center>
       <center><?php echo "Contact No : ".$mobilenoshop ?></center>
       <center><h5 style="margin-top:5px; margin-bottom:10px;"><b><?php echo "Branch Payment :".$customer_name ?></b><h5></span></center>
      
    </div>
    <div class="col-sm-2" >
      <?php  ?>
    </div>
  </div>


<?php

// Payment . . . . . . . .

$sql = "SELECT * FROM branch_payment where branchid=$sales_branchid";
$result = $conn->query($sql);
$totalpay=0;
echo "<br>";

if ($result->num_rows > 0) {
  

  ?>


<table id="example1" class="table table-bordered" style="width:100%">
<thead class="thead-light">
<tr>
  <th style='text-align:center;'>#</th>
  <th>Payment Date</th>
  <th>Pay Amount</th>
  <th>Discount</th>
  <th>Amount</th>
  <th>Action</th>
  
</tr>
</thead>
<tbody>


  <?php

  $psl=1;


  while($row = $result->fetch_assoc()) {

    $id=$row["id"];
    
    echo "<tr>";

    echo "<td>".$psl."</td>";

    $psl++;

    echo "<td>".$row["payment_date"]."</td>";
    echo "<td>".$row["pay_amount"]."</td>";
    echo "<td>".$row["discount"]."</td>";
    echo "<td>".$row["amount"]."</td>";

    $totalpay=$totalpay+$row["amount"];

    echo "<td class=' py-0 align-middle' style='text-align:left;'>
    <div class='btn-group btn-group-sm'>
      <a onclick=deletedata($id,this,'branch_payment') class='btn btn-danger'><i class='fas fa-trash'></i></a>
    </div>
  </td>";

    echo "</tr>";

  }

  ?>

</tbody>
 <tfoot style="background-color:white; font-weight: bold;">
    <tr>
        <td colspan='4' style='text-align:right;'>Current Due</td>
         <td colspan='2'><?php echo $due; ?></td>
    </tr>                   
</tfoot>
</table>

  <?php

} else {
  
  ?>
  
  <table id="example1" class="table table-bordered" style="width:100%">
  </table>
  
  <?php


}


echo "</div>";

if($due>0)
{

  $currentdue=$due;

    ?>


     
<div class="form-group">               
  <input type="date" id="payment_date" style="width:20%; margin-left:20px; margin-top:0px; float:left;"  placeholder="" value="<?php echo date('Y-m-d'); ?>" class="form-control">
</div>
  <div class="form-group">
  <input type="number" style="width:10%; margin-left:20px; float:left;" class="form-control" id="pay_amount" placeholder="Amount">
</div>

 <div class="form-group">
  <input type="number" style="width:10%; margin-left:20px; float:left;" class="form-control" id="discount_amount" placeholder="Discount">
</div>

<input type="button" style="width:20%; margin-left:20px; float:left;" onclick="addPayment(<?php echo $sales_branchid ?>)" class="btn btn-success" value="Add New Payment">

<input type="button" style="width:20%; margin-left:30px; float:right;" class="btn btn-success" value="Current Due <?php echo $currentdue  ?> /=">

<input type='hidden' id='dueval' value='<?php echo $currentdue  ?>'>

    </div>
    
  </div>
  
</div>

    <?php
}




?>

<br/>

<input type="button" onclick="printDiv('ContentDiv')" style="width:20%; margin-left:20px; float:left; margin-top:20px;" class="btn btn-primary" value="Print">
