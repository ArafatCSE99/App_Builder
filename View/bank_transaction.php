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
            <h1>Bank Transaction</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Bank Transaction</li>
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
                <h3 class="card-title" >List of Bank Transaction</h3>
                <a href="#add"><span style="float:right; cursor:pointer;">Add New</span></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow:auto;">
                <table id="example1" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Date</th>
                    <th>Bank Name</th>
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

$sql = "SELECT * FROM bank_transaction  where (userid=0 or userid=$userid) and companyid=$companyid";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $date=$row["date"];
    $bank_accountid=$row["bank_accountid"];

$bank_name="";
$sqlb = "SELECT * FROM bank_account where  id=$bank_accountid";
$resultb = $conn->query($sqlb);

$classnm="None";

if ($resultb->num_rows > 0) {
  // output data of each row
  while($rowb = $resultb->fetch_assoc()) {
      
       $account_no=$rowb["account_no"];
       $bank_name = $rowb["bank_name"]." - ".$account_no;

     
  }
} else {

  
  
}


    $previous_balance=$row["previous_balance"];
    $amount=$row["amount"];
    $transaction_type=$row["transaction_type"];
    $current_balance=$row["current_balance"];

    $user=$row["userid"];

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='date'>".$date."</td>"; 
     echo "<td class='bank_accountid'>".$bank_name."</td>";
     echo "<td class='previous_balance'>".$previous_balance."</td>"; 
     echo "<td class='amount'>".$amount."</td>"; 
     echo "<td class='transaction_type'>".$transaction_type."</td>"; 
     echo "<td class='current_balance'>".$current_balance."</td>"; 


     
     echo "<td class='text-center py-0 align-middle' style='text-align:center;'>";
                   
     if($user!=0){
                    echo "<div class='btn-group btn-group-sm'>
                        <a onclick='updatedata($id,this)' class='btn btn-info' style='color:white;'><i class='fa fa-edit'></i></a>
                        <a onclick=deletedata($id,this,'bank_transaction') class='btn btn-danger' style='color:white;'><i class='fa fa-trash'></i></a>
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
              <h3 class="card-title">Add Bank Transaction</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">
                
                        <div class="widget-content nopadding" style=" margin:20px;">
        <select class="form-control" id="bank_accountid" onchange="getPreviousBalance()" name="bank_accountid" style="width:50%" >
						<option hidden="" value="">Select Bank</option>


  <?php

$sql = "SELECT * FROM bank_account where  userid=$userid and companyid=$companyid";
$result = $conn->query($sql);

$classnm="None";

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
       $classid=$row["id"];
       $classnm = $row["bank_name"];
        $account_no=$row["account_no"];
        $account_type=$row["account_type"];

     echo  "<option value='$classid'>".$classnm." - ".$account_type."</option>";
  }
} else {

  echo   "<option value='0'>None</option>";
  
}

?>
			
         </select>
         
          <br>

          
              <div class="form-group">              
                <input type="number" id="previous_balance" style="width:50%" class="form-control" placeholder="Previous Balance" disabled>
              </div>

          <select class="form-control" id="transaction_type" name="type" style="width:50%" >
						<option hidden="" value="">Select Transaction Type</option>
            <option value="Deposit">Deposit</option>
            <option value="Withdraw">Withdraw</option>
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
