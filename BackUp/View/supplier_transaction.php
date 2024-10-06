<?php

include "../connection.php";

session_start(); 

$userid=$_SESSION["userid"];
// $userit=$_SESSION["userit"];
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
            <h1>Supplier Transaction</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Supplier Transaction</li>
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
                <h3 class="card-title" >List of Supplier Transaction</h3>
                <a href="#add"><span style="float:right; cursor:pointer;">Add New</span></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow:auto;">
                <table id="example1" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Date</th>
                    <th>Supplier Name</th>
                    <th>Previous Balance</th>
                    <th>Transaction Amount</th>      
                    <th>Transaction Type</th>
                    <th>Current Balance</th>
                    <th style='text-align:center;'>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

$balances = [];
$prevBalances = [];
$lastSupplierId=0;

$sql = "SELECT * FROM app_supplier_account  where (userid=0 or userid=$userid) and companyid=$companyid order by supplierid,transaction_date asc";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $date=$row["transaction_date"];
    $in_account=$row["in_account"];
    $out_account=$row["out_account"];
    $supplierid=$row["supplierid"];



    $previous_balance=$row["previous_balance"];
    $amount=$in_account>0?$in_account:$out_account;
    $transaction_type=$in_account>0?"Taken":"Given";
    $current_balance=$row["balance"];
    
   // echo "Test Supplier=".$supplierid." Last ".$lastSupplierId;
    
    // Reset previous balance if the supplier changes
    if ($supplierid != $lastSupplierId) {
        $prevBalances[$supplierid] = 0;
        $balances[$supplierid] = 0;
    }
    
    $lastSupplierId = $supplierid;
    
    $prevBalance = $balances[$supplierid];
    
    if($in_account>0){
      $currentBalance = $prevBalance + $amount;
    }
    else
    {
        $currentBalance = $prevBalance - $amount;
    }

    $prevBalances[$supplierid] = $prevBalance;
    $balances[$supplierid] = $currentBalance;
    

    $user=$row["userid"];
    
    
$customer_name="";
$sqlb = "SELECT * FROM supplier where id=$supplierid";
$resultb = $conn->query($sqlb);
//echo $sqlb;

if ($resultb->num_rows > 0) {
  // output data of each row
  while($rowb = $resultb->fetch_assoc()) {
     
       $supplier_name = $rowb["name"];
       //echo "hi";
     
  }
} else {
  
}
    

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='date'>".$date."</td>"; 
     echo "<td class='customerid'>".$supplier_name."</td>"; 
     echo "<td class='previous_balance'>".$prevBalance."</td>"; 
     echo "<td class='amount'>".$amount."</td>"; 
     echo "<td class='transaction_type'>".$transaction_type."</td>"; 
     echo "<td class='current_balance'>".$currentBalance."</td>"; 


     
     echo "<td class='text-center py-0 align-middle' style='text-align:center;'>";
                   
     if($user!=0){
                    echo "<div class='btn-group btn-group-sm'>
                        <a onclick='updatedata($id,this)' class='btn btn-info' style='color:white;'><i class='fa fa-edit'></i></a>
                        <a onclick=deletedata($id,this,'app_supplier_account') class='btn btn-danger' style='color:white;'><i class='fa fa-trash'></i></a>
                      </div>";
     }

                    echo "</td>";
     echo "</tr>";
      

  }
} else {
  
}
                ?>
                  
                 </tbody></table>
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
              <h3 class="card-title">Add Supplier Transaction</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
                
                        <div class="widget-content nopadding" style=" margin:20px;">
                            
        <select class="form-control" id="supplierid" onchange="getPreviousBalance()" name="supplierid" style="width:50%; display:none;" >

<option hidden="" value="">Select Supplier</option>

          <?php

$sql = "SELECT * FROM supplier where  userid=$userid and companyid=$companyid";
$result = $conn->query($sql);

$classnm="None";

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
       $classid=$row["id"];
       $classnm = $row["name"];

     echo  "<option value='$classid'>".$classnm."</option>";
  }
} else {

  echo   "<option value='0'>None</option>";
  
}

?>
 
			
         </select>
         
          <br>
          
              <div class="form-group" style="display:none;">              
                <input type="number" id="previous_balance" style="width:50%" class="form-control" placeholder="Previous Balance" disabled>
              </div>

          <select class="form-control" id="transaction_type" name="type" style="width:50%" >
						<option hidden="" value="">Select Transaction Type</option>
            <option value="Given">Given</option>
            <option value="Taken">Taken</option>
          </select>  
<br>
              <div class="form-group">              
                <input type="number" id="amount" style="width:50%" class="form-control" placeholder="Amount">
              </div>   

              <div class="form-group">              
                <input type="number" id="current_balance" style="width:50%" class="form-control" placeholder="Total Balance" disabled>
              </div>  
<br>
              <div class="form-group">              
                <input type="date" id="dates" style="width:50%" class="form-control" placeholder="Date">
              </div>   
              <br>

              <input type="button" onclick="savedata()"  value="Save Transaction" class="btn btn-success float-left">


              
           
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
