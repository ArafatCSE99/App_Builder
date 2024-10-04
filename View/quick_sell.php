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
            <h1>Point of Sale</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Point of Sale</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>






   


     
<!-- Main content -->
<section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">New sales</h3>

             

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body" style="overflow:auto;">

            <form class="form-inline" action="#">

            <div class="form-group">
                
                

              </div>

              <div class="form-group">               
                <input type="date" id="sales_date" style="width:100%; margin-left:20px; display:none;"  placeholder="" value="<?php echo date('Y-m-d'); ?>" class="form-control">
              </div>

              <div class="form-group">              
                <input type="text" id="note" style="width:100%; margin-left:20px; display:none;" placeholder="Notes" class="form-control">
              </div>

              </form>

          
              <!-- Table -->

              <table id="detail" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th style="min-width:120px;">Bar Code</th>
                    <th style="min-width:200px;">Product</th>
                    <th style="min-width:100px;">Quantity</th>
                    <th style="min-width:120px;">Unit Price</th>
                    <th style="min-width:120px;">Amount</th>
                    <th style="min-width:120px;">Discount</th>
                    <th style="min-width:150px;">Total</th>
                    <th style='text-align:center;'>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  
                  </tbody>
                  <tfoot style="background-color:white; font-weight: bold;">
                    <tr>
                       <td></td>
                       <td><center><button class="btn btn-primary" onclick="adddata()"><i class="fas fa-Plus"> Add </i></button></center></td>
                       <td colspan="4"></td>
                       <td>Total</td>
                       <td id="total">0</td>
                       <td></td>
                    </tr>
                    <tr>
                       <td></td>
                       <td></td>
                       <td colspan="">
                       <input class="form-control" style="border:2px solid gray;" type="number" id="pay" value="" placeholder="Pay"></td>
                       <td colspan="2" id=""><input class="form-control" style="border:2px solid gray;" type="number" id="change" value="" placeholder="Change" disabled></td>                    
                       <td></td>
                       <td>Paid</td>
                       <td ><input class="form-control" style="border:2px solid gray;" type="number" id="paid" value="0"></td>
                       <td></td>
                    </tr>
                    <tr>
                      <td colspan="6"></td>
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

  <div class="row">
    <div class="col-sm-5">
    
            <div class="form-group">               
             <input type="text" id="customercode" style="width:50%; "  placeholder="Customer Code" value="" class="form-control">
            </div>
    
    <?php

$sqlsem = "SELECT * FROM customer where userid=$userid";
$resultse = $conn->query($sqlsem);

echo "<select  class='form-control  hideElement' style='width:400px; float:left; margin-bottom:20px;' id='customer' name='customer' required>";

echo "<option hidden='' value=''>--Select customer--</option>";

if ($resultse->num_rows > 0) {

    while($rowse = $resultse->fetch_assoc()) {
       
     $up_name=$rowse["name"];
     $mobile=$rowse["mobileno"];
	   $upid=$rowse["id"];
	    
	  echo  "<option value='$upid'>".$up_name." ( ".$mobile." )</option>";
	   
	   
    }

} else {

   echo  "<option >None</option>";

}
		
echo " </select>";

echo "<br>";

?>

    </div>
    <div class="col-sm-7">

    <input type="button" onclick="savedata()"  value="Save" class="btn btn-success float-left">
    
    </div>
  </div>

             

            
              
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        
      </div>
     
    </section>
    <!-- /.content -->



</div>
