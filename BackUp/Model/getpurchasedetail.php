<?php 

include "../connection.php";

$purchaseid=$_POST["purchaseid"];

$sl=0;

$sql = "SELECT * FROM purchase_detail where purchaseid=$purchaseid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {

    $sl++;
    $detailid=$row["id"];
    $productid=$row["productid"];
    
    // Get Product Name ........................................
    $productname="";
    $sqlp = "SELECT name FROM product where id=$productid";
    $resultp = $conn->query($sqlp);
    
    if ($resultp->num_rows > 0) {
      // output data of each row
      while($rowp = $resultp->fetch_assoc()) {
        $productname=$rowp["name"];
      }
    } else {
      echo "0 results";
    }

    $quantity=$row["quantity"];
    $unitprice=$row["unitprice"];
    $total_price=$row["total_price"];
    
    $msrp_price=$row["msrp_price"];
    $percentage=$row["percentage"];


    $tabledata="<tr><td style='display:none;' class='detailid'>".$detailid."</td><td style='text-align:center;' class='slno'>".$sl."</td><td style='display:none;' style='text-align:right;' class='productid'>".$productid."</td> <td style='display:none;' style='text-align:right;' class='msrp_price'>".$msrp_price."</td>  <td style='display:none;' style='text-align:right;' class='percentage'>".$percentage."</td>  <td>".$productname."</td><td class='qty'>".$quantity."</td><td class='unitprice'>".$unitprice."</td><td class='amount'>".$total_price."</td>"
    ."<td class='text-center py-0 align-middle' style='text-align:center;'>"
    ."<div class='btn-group btn-group-sm'>"
    ."  <a onclick=deletedetaildata($detailid,this,'purchase_detail') id='deletebuttondetail' class='btn btn-danger'><i class='fas fa-trash'></i></a>"
    ."</div>"
    ."</td>"
    ."</tr>";

    echo $tabledata;

  }
} else {
  
}




?>