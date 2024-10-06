<style>
@media only screen and (max-width: 768px) {
    .card-body {
        padding: 0.5rem;
    }

    .card-title {
        font-size: 1.25rem;
    }

    table.dataTable {
        width: 100% !important;
    }

    table.dataTable thead {
        display: none;
    }

    table.dataTable tbody tr {
        display: block;
        margin-bottom: 0.625rem;
    }

    table.dataTable tbody tr td {
        display: block;
        text-align: right;
        font-size: 0.8rem;
        border-bottom: 1px solid #ddd;
        position: relative;
        padding-left: 50%;
    }

    table.dataTable tbody tr td::before {
        content: attr(data-label);
        position: absolute;
        left: 0;
        width: 50%;
        padding-left: 0.5rem;
        font-weight: bold;
        text-align: left;
    }

    table.dataTable tbody tr td:last-child {
        border-bottom: 0;
    }
}
</style>

<?php

include "../connection.php";

//session_start(); 

$userid=$_SESSION["userid"];
$companyid=$_SESSION["companyid"];
$branchid=$_SESSION["branchid"];
$subuserid=$_SESSION["subuserid"];
// Content  ......................................................

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Purchase</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Purchase</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>






    <!-- Table -->   

    <section class="content">
      <div class="row">
        <div class="col-md-12">

    <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title" >List of Purchase</h3>
                <a href="#add"><span style="float:right; cursor:pointer;">Add New</span></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow:auto;">
                <table id="example1" class="table table-bordered" style="width:100%; overflow:scroll !important;">
                  <thead class="thead-light" style=" overflow:scroll !important;">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Model</th>
                    <th style = "display:none;" class="HideAfterDT" >Supplierid</th>
                    <th>Supplier</th>
                    <th>Branch</th>
                    <th>Mobile No</th>
                    <th>Date</th>
                    <th>Qty</th>
                    <th>Total Price</th>
                    <th>Paid</th>
                    <th>Due</th>
                    <th>Note</th>
                    <th>Status</th>
                    <th style='text-align:center;'>Action</th>
                  </tr>
                  </thead>
                  <tbody style=" overflow:scroll !important;">

                  <?php

$slno=0;
if($subuserid==0)
{
    $sql = "SELECT * FROM purchase_master where userid=$userid and companyid=$companyid order by id desc";
}
else
{
    $sql = "SELECT * FROM purchase_master where userid=$userid and companyid=$companyid and (branchid=0 or branchid=$branchid) order by id desc";
}

$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $supplierid=$row["supplierid"];
    $supplier_name="";
    $mobileno="";
    $p_branchid=$row["branchid"];

    $sqls = "SELECT name,mobileno FROM supplier where id=$supplierid";
    $results = $conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $supplier_name=$rows["name"];
    $mobileno=$rows["mobileno"];
  }
} else {
 // echo "0 results";
}

    $purchase_date=$row["purchase_date"];
    $grand_total=$row["grand_total"];
    $paid=$row["paid"];
    $due=$row["due"];
    $note=$row["note"];

     echo "<tr>";
     echo "<td  data-label='#' style='text-align:right;'>".$slno."</td>";
     
$totQty=0;     
$sqls = "SELECT a.*,b.name FROM purchase_detail a,product b where purchaseid=$id and a.productid=b.id";
$results = $conn->query($sqls);
echo "<td  data-label='Model'>";
if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $pro_name=$rows["name"];
    $quantity=$rows["quantity"];
    
    echo "".$pro_name."-".$quantity."<br>";
    $totQty=$totQty+$quantity;
    
  }
} else {
 // echo "0 results";
}


// Check Warehouse ........................
$isDelete=1;
$sqlw = "SELECT initial_purchase,current_stock FROM stock_warehouse where purchaseid=$id";
$resultw = $conn->query($sqlw);

if ($resultw->num_rows > 0) {
  // output data of each row
  while($roww = $resultw->fetch_assoc()) {
    if($roww["initial_purchase"]!=$roww["current_stock"]){
       $isDelete=0;
    }
  }
}

$branchname="";
$sqlsem = "SELECT * FROM branches where user_id=$userid and company_id=$companyid and id=$p_branchid";
//echo $sqlsem;
$resultse = $master_conn->query($sqlsem);

if ($resultse->num_rows > 0) {
  // output data of each row
  while($rowse = $resultse->fetch_assoc()) {
    $branchname=$rowse["name"];
     
    
  }
}

echo "</td>";
     
     echo "<td style='display:none;' class='supplierid HideAfterDT'>".$supplierid."</td>"; 
    echo "<td data-label='Supplier' class='supplier_name'>".$supplier_name."</td>";
echo "<td data-label='Branch'>".$branchname."</td>";
echo "<td data-label='Mobile No' class='mobileno'>".$mobileno."</td>";
echo "<td data-label='Date' class='purchase_date'>".$row["purchase_date"]."</td>";
echo "<td data-label='Qty' class='tot_qty'>".$totQty."</td>";
echo "<td data-label='Total Price' class='total_price'>".$row["total_price"]."</td>";
echo "<td data-label='Paid' class='paid'>".$row["paid"]."</td>";
echo "<td data-label='Due' class='due'>".$due."</td>";
echo "<td data-label='Note' class='note'>".$note."</td>";
echo "<td data-label='Status' class='note'>".$row["status"]."</td>";
     
     if($isDelete==1){
     echo "<td class='text-center py-0 align-middle' style='text-align:center;'>
                      <div class='btn-group btn-group-sm'>";
                      
                   if($row["status"]=="Pending" && $subuserid==0){
                    echo    "<a title='Approve' onclick='updatestatus($id,this)' class='btn btn-info' style='color:white;'><i class='fa fa-check'></i></a>";
                    }
                      
                      
                      if($subuserid==0){
                       echo "<a onclick='PrintReceipt($id,this)' class='btn btn-info'><i class='fas fa-print'></i></a>";
                       
                        /*<a onclick='updatedata($id,this)' class='btn btn-info'><i class='fas fa-edit'></i></a>*/
                       
                       echo "<a onclick=deletemasterdetail($id,this,'purchase_master','purchase_detail','purchaseid') class='btn btn-danger'><i class='fas fa-trash'></i></a>";
                      }
                     
                     echo "</div>
                    </td>";
     }
     else{
      echo "<td></td>";
     }
     echo "</tr>";
      

  }
} else {
  
}
                ?>
                  
               </tbody> </table>
              </div>
              <!-- /.card-body -->
            </div>


            </div>
        
        </div>
       
      </section>
        

    <!-- End Table -->


     
<!-- Main content -->
<section class="content" id="add">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">New Purchase</h3>

             

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body" style="overflow:auto;">

            <form class="form-inline" action="#">

            <div class="form-group">
                
                <?php

$sqlsem = "SELECT * FROM supplier where userid=$userid and companyid=$companyid";
$resultse = $conn->query($sqlsem);

echo "<select  class='form-control' style='width:200px;' id='supplier' name='supplier' required>";

echo "<option hidden='' value=''>--Select Supplier--</option>";

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


$sqlsem = "SELECT * FROM warehouse where userid=$userid and companyid=$companyid";
$resultse = $conn->query($sqlsem);
//echo $sqlsem;
echo "<select  class='form-control' style='width:200px;' id='warehouse' name='warehouse' required>";
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


$sqlsem = "SELECT * FROM branches where user_id=$userid and company_id=$companyid and id=$branchid";

$resultse = $master_conn->query($sqlsem);
//echo $sqlsem;
echo "<select  class='form-control' style='width:200px;' id='branch' name='warehouse' required>";
echo "<option hidden='' value=''>--Select Branch--</option>";
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
                <input type="date" id="purchase_date" style="width:100%; margin-left:20px;"  placeholder="" value="<?php echo date('Y-m-d'); ?>" class="form-control">
              </div>

              <div class="form-group">              
                <input type="text" id="note" style="width:100%; margin-left:20px;" placeholder="Notes" class="form-control">
              </div>

              </form>

              <form class="form-inline" action="#">

  <div class="form-group" style='display:none;'>               
    <input type="text" id="barcode" style="width:100%; "  placeholder="Bar Code" value="" class="form-control">
  </div>

<div class="form-group">
    
    <?php

$sqlsem = "SELECT * FROM product where userid=$userid and companyid=$companyid and  categoryid in (Select id from category where percentage>0) and msrp_price>0";
$resultse = $conn->query($sqlsem);

echo "<select  class='form-control' style='width:200px; margin-left:20px;' id='product' name='product' required>";

echo "<option hidden='' value=''>--Select Model--</option>";

if ($resultse->num_rows > 0) {

while($rowse = $resultse->fetch_assoc()) {

$up_name=$rowse["name"];
$model=$rowse["model"];
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
     <input type="number" id="quantity" style="width:100%; margin-left:20px;"  placeholder="Quantity" value="" class="form-control">
  </div>

  <div class="form-group">              
     <input type="number" id="unitprice" style="width:100%; margin-left:20px;" placeholder="Unit Price(MSRP)" class="form-control" disabled> 
  </div>
  
   <div class="form-group">              
     <input type="number" id="purchase_unitprice" style="width:100%; margin-left:20px;" placeholder="Purchase Price" class="form-control"> 
  </div>
  
  <div class="form-group" >              
     <input type="number" id="percentage" style="width:100%; margin-left:20px;" placeholder="Percentage" class="form-control">
  </div> <span id='psign'>%</span>
  

  <input type="button" onclick="adddata()" style="margin-left:20px;"  value="Add" class="btn btn-success float-left">

  </form>


              <!-- Table -->

              <table id="detail" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Amount</th>
                    <th style='text-align:center;'>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot style="background-color:white; font-weight: bold;">
                    <tr>
                       <td colspan=""></td>
                       <td>Total Qty</td>
                       <td id='totalQty'>0</td>
                       <td>Total</td>
                       <td id="total">0</td>
                       <td></td>
                    </tr>
                    <tr>
                      
                       <td colspan="3"></td>
                       <td>Discount</td>
                       <td><input class="form-control" type="number" id="grand_discount" value="0"><input type="hidden" value="0" id="grand_discount_value"></td>
                       <td></td>
                    </tr>
                    <tr>
                       <td colspan="3"></td>
                       <td>Paid</td>
                       <td style="min-width:120px;"><input class="form-control" type="number" id="paid" value="0"></td>
                       <td></td>
                    </tr>
                    <tr>
                      <td colspan="3"></td>
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
