
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
            <h1>Stock Transfer</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Stock Transfer</li>
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
                <h3 class="card-title" >List of Stock Transfer</h3>
                <a href="#add"><span style="float:right; cursor:pointer;">Add New</span></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow:auto;">
                <table id="example1" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    
                    <th style = "display:none;" class="HideAfterDT">Customerid</th>
                    <th>Branch</th>
                    <th>Model</th>
                    <th>Date</th>
                    <!--<th>Initial<br>Price</th>
                    <th>Discount</th>-->
                    <th>Total Price</th>
                    <th>Note</th>
                    <th style='text-align:center;'>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

$sql = "SELECT * FROM stock_transfer_master where userid=$userid and companyid=$companyid order by id desc";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    
    $sales_type=$row["sales_type"];
    $payment_type=$row["payment_type"];
    $payment_no=$row["payment_no"];
    $sales_date=$row["sales_date"];
    $customerid=$row["customerid"];
    $customer_name="";
    $mobileno="";

    $sqls = "SELECT name FROM branches where id=$customerid";
    $results = $master_conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $customer_name=$rows["name"];
    //$mobileno=$rows["mobileno"];
  }
} else {
 // echo "0 results";
}


// . . . . . . . . . .

$totalpay=0;
$pay_count=0;

$sqlp = "SELECT * FROM sales_payment where salesid=$id";
$resultp = $conn->query($sqlp);

if ($resultp->num_rows > 0) {

  while($rowp = $resultp->fetch_assoc()) {
    $totalpay=$totalpay+$rowp["amount"];
    $pay_count++;
  }

}

// . . . . . . . . .

    $sales_date=$row["sales_date"];
    $grand_total=$row["grand_total"];
    $paid=$row["paid"]+$totalpay;
    $due=$row["due"]-$totalpay;
    $note=$row["note"];
    
    $bgcolor="";
    $color="";
    // check due date exist . . . .........................
    if($due>0 && ($payment_type=="Monthly" || $payment_type=="Weekly") )
    {
        $installment_date=$sales_date;
        for($i=0;$i<$payment_no;$i++)
        {
            
                
// Create Date .....................
$tdt=date_create($installment_date);
if($payment_type=="Monthly"){
    date_add($tdt,date_interval_create_from_date_string("30 days"));
}
else
{
    date_add($tdt,date_interval_create_from_date_string("7 days"));
}
$tdt=date_format($tdt,"Y-m-d");
$installment_date=$tdt;

date_default_timezone_set("Asia/Dhaka");
$cd=date("Y-m-d");
    
if($cd>=$installment_date && $i==$pay_count)
{
    
    $bgcolor="green";
    $color="white";
}

// .................................................


        }
    }

 //................................................




// Calculate Profit .............

$total_price=$row["total_price"];
$due=$row["due"];
$masterid=$row["id"];
$total_profit=0;
$cash_profit=0;
$due_profit=0;

$sqls = "SELECT * FROM sales_detail where salesid=$masterid";
$results = $conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $quantity=$rows["quantity"];
    $unitprice=$rows["unitprice"]-($rows["discount"]/$quantity);
    $productid=$rows["productid"];
    
    $purchase_unitprice=0;
      // Find Product Purchase Unit Price 
$sqlsp = "SELECT avg(unitprice) as unitprice  FROM purchase_detail where productid=$productid";
$resultsp = $conn->query($sqlsp);

if ($resultsp->num_rows > 0) {
  // output data of each row
  while($rowsp = $resultsp->fetch_assoc()) {
    $purchase_unitprice=$rowsp["unitprice"];
  }
}
else
{
    //echo "0 result";
}
      // End ...........................
    
    $unit_profit=  $unitprice-$purchase_unitprice;
    $total_profit=$total_profit+($unit_profit*$quantity);
    
  }
} else {
  //echo "0 results";
}

$total_profit=$total_profit-$row["discount"];
$cash_profit=($total_profit/$total_price)*$paid;
if($due>0)
{
   $due_profit=($total_profit/$total_price)*$due;
}

// End Calculate Profit .........



     echo "<tr style='background-color:$bgcolor; color:$color;'>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     


$price=$row["total_price"];
$discount=$row["discount"];
$init_price=$price*1+$discount*1;
     
     echo "<td style='display:none;' class='customerid  HideAfterDT'>".$customerid."</td>"; 
     echo "<td class='customer_name'>".$customer_name."</td>"; 
    // echo "<td class='mobileno'>".$mobileno."</td>"; 
     
$sqls = "SELECT a.*,b.name FROM stock_transfer_detail a,product b where salesid=$id and a.productid=b.id";
$results = $conn->query($sqls);
echo "<td>";
if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $pro_name=$rows["name"];
    $quantity=$rows["quantity"];
    
    echo "".$pro_name."-".$quantity."<br>";
    
  }
} else {
 // echo "0 results";
}
echo "</td>";
     
     echo "<td class='sales_date'>".$row["sales_date"]."</td>";
     //echo "<td class='init_price'>".$init_price."</td>";
    // echo "<td class='discount'>".$discount."</td>";
     echo "<td class='total_price'>".$row["total_price"]."</td>";
     //echo "<td class='paid'>".$paid."<br>[".round($cash_profit,2)."]</td>";
    // echo "<td class='due'>".$due."<br>[".round($due_profit,2)."]</td>";
     
     if($payment_type=="Monthly" || $payment_type=="Weekly")
     {
        if($row["due"]>0 && $payment_no!=0){
        $installment=round($row["due"]/$payment_no);
        }
        else
        {
            $installment=0;
        }
        $payment_type=$payment_type." [".$payment_no."] - ".$installment." Tk/=  ";
     }
     
     //echo "<td class='payment_type' style='cursor:pointer;' onclick='getPaymentDetails($id,this)'>".$payment_type."</td>";
     echo "<td class='note'>".$note."</td>";
     
     echo "<td class='text-center py-0 align-middle' style='text-align:center;'>
                      <div class='btn-group btn-group-sm'>
                      <a onclick='PrintTransferReceipt($id,this)' class='btn btn-info'><i class='fas fa-print'></i></a>";
                        
                        echo "<a onclick=deletemasterdetail($id,this,'stock_transfer_master','stock_transfer_detail','salesid') class='btn btn-danger'><i class='fas fa-trash'></i></a>";
                        
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
                  
                
    


     
<!-- Main content -->
<section class="content" id="add">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">New Stock Transfer</h3>

             

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body" style="overflow:auto;">

            <form class="form-inline" action="#">

            <div class="form-group" style='display:none;'>               
             <input type="text" id="customercode" style="width:100%; "  placeholder="Customer Code" value="" class="form-control">
            </div>

            <div class="form-group">
                
                <?php

$sqlsem = "SELECT * FROM branches where user_id=$userid and company_id=$companyid";
$resultse = $master_conn->query($sqlsem);

echo "<select  class='form-control' style='width:200px;' id='customer' name='customer' required>";

echo "<option hidden='' value=''>--Select branch--</option>";

if ($resultse->num_rows > 0) {

    while($rowse = $resultse->fetch_assoc()) {
       
	   $up_name=$rowse["name"];
	   $upid=$rowse["id"];
	   
	    
	  echo  "<option value='$upid'>".$up_name."</option>";
	   
	   
    }

} else {

   echo  "<option >None</option>";

}
		
echo " </select>";

?>

              </div>

              <div class="form-group">               
                <input type="date" id="sales_date" style="width:100%; margin-left:20px;"  placeholder="" value="<?php echo date('Y-m-d'); ?>" class="form-control">
              </div>

              <div class="form-group">              
                <input type="text" id="note" style="width:100%; margin-left:20px;" placeholder="Notes" class="form-control">
              </div>
              
              <select  class='form-control' onchange='changePrice()' style='width:0px; margin-left:20px; display:none;' id='cp' name='' >
              <option value='1'></option>
              <option value='2'></option>
              </select>
              
              <br>
               <div class="form-group" style='display:none;'>       
               <select  class='form-control' style='width:0px; margin-left:20px; margin-top:10px; display:none;' id='ptype'>
              <option value=''></option>
              <option value=''></option>
              <option value=''></option>
              </select>
              </div>

              <div class="form-group" style='display:none;'>              
                <input type="number" value='0' id="pn" style="width:0%; margin-left:0px; " placeholder="" class="form-control">
              </div>

              <select  class='form-control'  style='width:0px; margin-left:20px; display:none;' id='sales_mode' name='sales_mode' required>
              <option value='1'></option>
              <option value='2'></option>
              </select>
&nbsp;
              <select  class='form-control'  style='width:0px; margin-left:40px; display:none;' id='sales_destination' name='sales_destination' required>
              <option value='2'></option>
              <option value='1'></option>
              </select>

              <?php

$sqlsem = "SELECT * FROM WAREHOUSE where userid=$userid and companyid=$companyid";
$resultse = $conn->query($sqlsem);

echo "<select  class='form-control' style='width:200px;' id='warehouse' name='warehouse' >";

echo "<option hidden='' value=''>--Select warehouse--</option>";

if ($resultse->num_rows > 0) {

    while($rowse = $resultse->fetch_assoc()) {
       
	   $up_name=$rowse["name"];
	   $upid=$rowse["id"];
	    
	  echo  "<option value='$upid'>".$up_name."</option>";
	   
	   
    }

} else {

   echo  "<option >None</option>";

}
		
echo " </select>";

              ?>


              </form>

              <br>

              <form class="form-inline" action="#">

  <div class="form-group" style='display:none;'>               
    <input type="text" id="barcode" style="width:100%; "  placeholder="Bar Code" value="" class="form-control">
  </div>

<div class="form-group">

<!--<input type='hidden' name='product' id='product' value='0'>-->

    <?php
    
    
$sqlsem = "SELECT * FROM product where userid=$userid and  companyid=$companyid";
$resultse = $conn->query($sqlsem);
echo "<select  class=''  style='display:none; width:2px; visibilty:hidden;' id='product' name='product'>";
echo "<option hidden='' value=''>--Select Product--</option>";
if ($resultse->num_rows > 0) {
while($rowse = $resultse->fetch_assoc()) {
$up_name=$rowse["name"];
$upid=$rowse["id"];
$model=$rowse["model"];
echo  "<option value='$upid'>".$up_name."</option>";
}
} else {
echo  "<option >None</option>";
}
echo " </select>";

    

$sqlsem = "SELECT a.*,b.current_stock,b.id as stockid FROM product a,stock_branch b  where a.id=b.productid and b.current_stock>0 and a.userid=$userid and a.companyid=$companyid and b.branchid=$branchid";
//echo $sqlsem;
$resultse = $conn->query($sqlsem);

echo "<select  class='form-control'  style='width:200px; margin-left:20px;' id='product_branch' name='product_branch' >";

echo "<option hidden='' value=''>--Select Models--</option>";

if ($resultse->num_rows > 0) {

while($rowse = $resultse->fetch_assoc()) {

$up_name=$rowse["name"];
$upid=$rowse["id"];
$model=$rowse["model"];
$stockid=$rowse["stockid"];
$current_stock=$rowse["current_stock"];


  $sqla = "SELECT sum(total_price)/sum(quantity) as avgprice FROM purchase_detail where productid=$upid";
  $result = $conn->query($sqla);
  
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $avg_price= $row["avgprice"];
    }
  } else {
    $avg_price= 0;
  }


echo  "<option value='$stockid'>".$up_name." [B-".$stockid." Q-".$current_stock."] [".$avg_price."]</option>";



}

} else {

echo  "<option >None</option>";

}

echo " </select>";




$sqlsem = "SELECT a.*,b.current_stock,b.id as stockid,c.name as warehousename FROM product a,stock_warehouse b,warehouse c  where a.id=b.productid and b.warehouseid=c.id and b.current_stock>0 and a.userid=$userid and a.companyid=$companyid";
$resultse = $conn->query($sqlsem);

echo "<select  class='form-control'  style='width:200px; margin-left:20px;' id='product_warehouse' name='product_warehouse' >";

echo "<option hidden='' value=''>--Select Modelss--</option>";

if ($resultse->num_rows > 0) {

while($rowse = $resultse->fetch_assoc()) {

$up_name=$rowse["name"];
$upid=$rowse["id"];
$model=$rowse["model"];
$stockid=$rowse["stockid"];
$current_stock=$rowse["current_stock"];
$warehousename=$rowse["warehousename"];

$sqla = "Select round( (Sum(unitprice*current_stock)/Sum(current_stock) ),2) as avgprice from ( Select a.unitprice,b.current_stock from purchase_detail a, stock_warehouse b where a.purchaseid=b.purchaseid and a.productid=b.productid and b.current_stock>0 and a.productid=$upid ) NewT";
  $result = $conn->query($sqla);
  
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $avg_price= $row["avgprice"];
    }
  } else {
    $avg_price= 0;
  }

echo  "<option value='$stockid'>".$up_name." [B-".$stockid." Q-".$current_stock." W-".$warehousename."] [".$avg_price."]</option>";



}

} else {

echo  "<option >None</option>";

}

echo " </select>";




?>

  </div>


  <div class="form-group">               
    <input type="number" id="quantity" style="width:110px; margin-left:20px;"  placeholder="Quantity" value="" class="form-control">
  </div>

  <div class="form-group">              
    <input type="number" id="unitprice" style="width:110px; margin-left:20px;" placeholder="Unit Price" class="form-control">
  </div>
  
   <div class="form-group">              
    <input type="number" id="discountdetailpercent" style="width:110px; margin-left:20px;" placeholder="Dis.(%)" class="form-control"> %
  </div>

  <div class="form-group">              
    <input type="number" id="discountdetail" style="width:110px; margin-left:20px;" placeholder="Discount" class="form-control">
  </div>

  <div class="form-group">              
    <input type="number" id="totaldetail" style="width:110px; margin-left:20px;" placeholder="Total" class="form-control" disabled>
  </div>

  <input type="button" onclick="adddata()" style="margin-left:20px;"  value="Add" class="btn btn-success float-left">

  </form>


              <!-- Table -->

              <table id="detail" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th style="min-width:120px;">Unit Price</th>
                    <th style="min-width:120px;">Amount</th>
                    <th>Discount</th>
                    <th style="min-width:120px;">Total</th>
                    <th style='text-align:center;'>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot style="background-color:white; font-weight: bold;">
                    <tr>
                       <td></td>
                       <td>Total Qty</td>
                       <td id='totalQty'>0</td>
                       <td colspan="2"></td>
                       <td>Total</td>
                       <td id="inittotal">0</td>
                       <td></td>
                    </tr>
                    
                    
                    <tr>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td colspan="2"></td>
                       <td>Discount</td>
                       <td><input class="form-control" type="number" id="grand_discount" value="0"><input type="hidden" value="0" id="grand_discount_value"></td>
                       <td></td>
                    </tr>
                    
                    <tr>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td colspan="2"></td>
                       <td>Grand Total</td>
                       <td id="total">0</td>
                       <td></td>
                    </tr>
                    
                     <tr>
                       <td></td>
                       <td colspan="2"></td>
                       <td colspan="">
                       <input class="form-control" style="border:2px solid gray;" type="number" id="pay" value="" placeholder="Pay"></td>
                       <td colspan="" id=""><input class="form-control" style="border:2px solid gray;" type="number" id="change" value="" placeholder="Change" disabled></td>             
                       <td>Paid</td>
                       <td ><input class="form-control" type="number" id="paid" value="0"></td>
                       <td></td>
                    </tr>
                    <tr>
                      <td colspan="5"></td>
                       <td>Due</td>
                       <td id="due">0</td>
                       <td></td>
                    </tr>
                  
                  <!--
                    <tr>
                       <td colspan="3"></td>
                       <td>Grand Total</td>
                       <td id="grand_total">0</td>
                       <td></td>
                    </tr>

                    -->
                   
                  </tfoot>
                  </table>

              <br>

              <input type="button" onclick="savedata()"  value="Save" class="btn btn-success float-left">
              
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        
      </div>
     
    </section>
    <!-- /.content -->



</div>


