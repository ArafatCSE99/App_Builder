
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
            <h1>Branch Payment</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Branch Payment</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>








                  
                   <!-- Table -- ---------------------------------------------------------- -->   

    <section class="content">
      <div class="row">
        <div class="col-md-12">

    <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title" >List of Branch Balance</h3>
                <a href="#add"><span style="float:right; cursor:pointer;"></span></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow:auto;">
                <table id="example1" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    
                    <th style = "display:none;" class="HideAfterDT">Customerid</th>
                    <th>Branch</th>
                    <th>Total Price</th>
                    <th>Paid</th>
                    <th>Payments</th>
                    <th>Due</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

$sql = "SELECT customerid,sum(total_price) as total_price,sum(paid) as paid,sum(due) as due FROM `stock_transfer_master` 
 where userid=$userid and companyid=$companyid GROUP by customerid order by id desc";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    
    
    $customerid=$row["customerid"];
    $customer_name="";
    $mobileno="";

    $sqls = "SELECT name FROM branches where id=$customerid";
    $results = $master_conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $customer_name=$rows["name"];
  }
} else {
}


// . . . . . . . . . .

$totalpay=0;
$pay_count=0;

$sqlp = "SELECT * FROM branch_payment where branchid=$customerid";
$resultp = $conn->query($sqlp);

if ($resultp->num_rows > 0) {

  while($rowp = $resultp->fetch_assoc()) {
    $totalpay=$totalpay+$rowp["amount"];
    $pay_count++;
  }

}

// . . . . . . . . .
    $paid=$row["paid"]+$totalpay;
    $due=$row["due"]-$totalpay;

    $bgcolor="";
    $color="";

     echo "<tr style='background-color:$bgcolor; color:$color;'>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     


$price=$row["total_price"];
$discount=0;//$row["discount"];
$init_price=$price*1+$discount*1;
     
     echo "<td style='display:none;' class='customerid  HideAfterDT'>".$customerid."</td>"; 
     echo "<td class='customer_name'>".$customer_name."</td>"; 
     
$sqls = "SELECT a.*,b.name FROM stock_transfer_detail a,product b where salesid=$id and a.productid=b.id";
$results = $conn->query($sqls);
//echo "<td>";
if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $pro_name=$rows["name"];
    $quantity=$rows["quantity"];
    
    //echo "".$pro_name."-".$quantity."<br>";
    
  }
} else {
 // echo "0 results";
}
//echo "</td>";
     
    
     echo "<td class='total_price'>".round($row["total_price"],2)."</td>";
     echo "<td class='paid'>".round($paid,2)."</td>";
     echo "<td class='due'>".round($totalpay,2)."</td>";
     echo "<td class='due'>".round($due,2)."</td>";
    
     
     echo "<td class='text-center py-0 align-middle' style='text-align:center;'>
                      <div class='btn-group btn-group-sm'>
                      <a onclick='viewdata($customerid,$due,this)' class='btn btn-info'><i class='fas fa-eye'></i></a>";
                        /*
                        echo "<a onclick=deletemasterdetail($id,this,'stock_transfer_master','stock_transfer_detail','salesid') class='btn btn-danger'><i class='fas fa-trash'></i></a>";
                        */
                        
                      echo "</div>
                    </td>";
     echo "</tr>";
      

  }
} else {
  
}
                ?>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>


            </div>
        
        </div>
       
      </section>
        

    <!-- End Table -------------------------------------------------------- -->
                  
                
    



</div>


