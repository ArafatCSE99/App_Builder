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

session_start(); 

$userid=$_SESSION["userid"];
// $userit=$_SESSION["userit"];
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
            <h1>Branch Transaction</h1>
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





    <!-- Table -->   
    <section class="content">
      <div class="row">
        <div class="col-md-12">

    <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title" >List of Branch Transaction</h3>
                <a href="#add"><span style="float:right; cursor:pointer;">Add New</span></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow:auto;">
                <table id="example1" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Date</th>
                    <th>Transaction Amount</th>      
                    <th>Transaction Type</th>
                    <th>Note</th>
                    <th>Status</th>
                    <th style='text-align:center;'>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

$sql = "SELECT * FROM branch_payment_new  where (userid=0 or userid=$userid) and companyid=$companyid and branchid=$branchid order by id desc";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $date=$row["date"];
    $bank_accountid=$row["bank_accountid"];

$bank_name="";



    $previous_balance=$row["previous_balance"];
    $amount=$row["amount"];
    
    if($row["status"]=="Pending"){
           $amount=$row["requested_amount"];
    }

    $transaction_type=$row["transaction_type"];
    $transaction_by=$row["transaction_by"];
    $current_balance=$row["current_balance"];

    $user=$row["userid"];

     echo "<tr>";
     echo "<td data-label='#' style='text-align:right;'>".$slno."</td>";
     echo "<td data-label='date' class='date'>".$date."</td>"; 
     //echo "<td class='previous_balance'>".$previous_balance."</td>"; 
     echo "<td data-label='Amount' class='amount'>".$amount."</td>"; 
     echo "<td data-label='Transaction Type' class='transaction_type'>".$transaction_type." (".$transaction_by.")</td>"; 
     echo "<td data-label='Amount' class='amount'>".$row["Note"]."</td>";
     echo "<td data-label='Status' class='status'>".$row["status"]."</td>"; 


     
     echo "<td data-label='Action' class='text-center py-0 align-middle' style='text-align:right;'>";
                   
     if($subuserid==0){
                    echo "<div class='btn-group btn-group-sm'>";
                    
                    if($row["status"]=="Pending"){
                    echo    "<a title='Approve' onclick='updatestatus($id)' class='btn btn-info' style='color:white;'><i class='fa fa-check'></i></a>";
                    }
                    
                    echo    "<a onclick='updatedata($id,this)' class='btn btn-info' style='color:white;'><i class='fa fa-edit'></i></a>
                        <a onclick=deletedata($id,this,'branch_payment_new') class='btn btn-danger' style='color:white;'><i class='fa fa-trash'></i></a>
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
              <h3 class="card-title">Add Branch Transaction</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
                
                        <div class="widget-content nopadding" style=" margin:20px;">
        <select class="form-control" id="bank_accountid" onchange="getPreviousBalance()" name="bank_accountid" style="width:50%; display:none;" >
						<option  value="0">Branch Payment</option>


 
			
         </select>
         
          <br>

             <?php
             if($current_balance=="")
             {
                 $current_balance=0;
             }
             ?>
          
              <div class="form-group" style="display:none;">              
                <input type="number" id="previous_balance" style="width:50%" class="form-control" placeholder="Previous Balance" disabled  value='<?php echo $current_balance; ?>'>
              </div>

          <select class="form-control" id="transaction_type" name="type" style="width:50%" >
						<option hidden="" value="">Select Transaction Type</option>
			<option value="Opening Balance">Opening Balance</option>
			<option value="Opening Balance">Admin Balance</option>
            <option value="Deposit">Deposit</option>
            <option value="Deposit Purchase">Deposit Purchase</option>
          </select>  
<br>
<select class="form-control" id="transaction_by" name="by" style="width:50%" >
						<option hidden="" value="Cash">Select Transaction By</option>
			<option value="Cash">Cash</option>
			<option value="Bkash">Bkash</option>
            <option value="Rocked">Rocket</option>
            <option value="Nagad">Nagad</option>
            <option value="Bank Account">Bank Account</option>
          </select>  
<br>
              <div class="form-group">              
                <input type="number" id="amount" style="width:50%" class="form-control" placeholder="Amount">
              </div>   

              <div class="form-group" style="display:none;">              
                <input type="number" id="current_balance" style="width:50%" class="form-control" placeholder="Total Balance" disabled>
              </div>  
<br>
              <div class="form-group">              
                <input type="date" id="dates" style="width:50%" class="form-control" placeholder="Date">
              </div>   
              
              <div class="form-group">              
                <input type="text" id="note" style="width:50%" class="form-control" placeholder="Note">
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
