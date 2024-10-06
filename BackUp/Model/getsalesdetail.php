<?php 

include "../connection.php";

$salesid=$_POST["salesid"];

$sl=0;

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
    $amount=$quantity*$unitprice;
    $discountdetail=$row["discount"];
    $total_price=$row["total_price"];


    $tabledata="<tr><td style='display:none;' class='detailid'>".$detailid."</td><td style='text-align:center;' class='slno'>".$sl."</td><td style='display:none;' style='text-align:right;' class='productid'>".$productid."</td><td>".$productname."</td><td class='qty'>".$quantity."</td><td class='unitprice'>".$unitprice."</td><td class='amount'>".$amount."</td><td class='discountdetail'>".$discountdetail."</td><td class='totaldetail'>".$total_price."</td>"
    ."<td class='text-center py-0 align-middle' style='text-align:center;'>"
    ."<div class='btn-group btn-group-sm'>"
    ."  <a onclick=deletedetaildata($detailid,this,'sales_detail') id='deletebuttondetail' class='btn btn-danger'><i class='fas fa-trash'></i></a>"
    ."</div>"
    ."</td>"
    ."</tr>";

    echo $tabledata;

  }
} else {
  
}




?>