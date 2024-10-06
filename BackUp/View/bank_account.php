<?php


session_start(); 

$userid=$_SESSION["userid"];
//$userit=$_SESSION["userit"];
$companyid=$_SESSION["companyid"];
$branchid=$_SESSION["branchid"];

include "../connection.php";


// Content  ......................................................

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Bank</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Bank</li>
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
                <h3 class="card-title" >List of Bank</h3>
                <a href="#add"><span style="float:right; cursor:pointer;">Add New</span></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow:auto;">
                <table id="example1" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Account No</th>
                    <th>Bank Name</th>
                    <th>Account Title</th>
                    
                    <th>Branch Name</th>
                    <th>Account Type</th>
                    <th>Branch Address</th>
                    <th>Phone No</th>
                    <th>Starting Amount</th>
                    <th style='text-align:center;'>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

$sql = "SELECT * FROM bank_account where (userid=0 or userid=$userid) and companyid=$companyid";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $account_no=$row["account_no"];
    $bank_name=$row["bank_name"];
    $userid=$row["userid"];
    $account_title=$row["account_title"];
    $branch_name=$row["branch_name"];
    $account_type=$row["account_type"];
    $branch_address=$row["branch_address"];
    $phone_no=$row["phone_no"];
    $starting_amount=$row["starting_amount"];

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='account_no'>".$account_no."</td>"; 
     echo "<td class='bank_name'>".$bank_name."</td>"; 
     echo "<td class='account_title'>".$account_title."</td>";
     echo "<td class='branch_name'>".$branch_name."</td>"; 
     echo "<td class='account_type'>".$account_type."</td>"; 
     echo "<td class='branch_address'>".$branch_address."</td>"; 
     echo "<td class='phone_no'>".$phone_no."</td>";
     echo "<td class='starting_amount'>".$starting_amount."</td>"; 
     

     
     echo "<td class='text-center py-0 align-middle' style='text-align:center;'>
                      <div class='btn-group btn-group-sm'>";

                        echo "<a onclick='updatedata($id,this)' class='btn btn-info' style='color:white;'><i class='fa fa-edit'></i></a>";

                        echo "<a onclick=deletedata($id,this,'bank_account') class='btn btn-danger' style='color:white;'><i class='fa fa-trash'></i></a>";

                      echo "</div>
                    </td>";
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
              <h3 class="card-title">Add Bank</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">

                        <div class="row">
                          <div class="col-sm-4" style="float:left; width:200px; margin-left:10px;">

              <div class="form-group">             
                <input id="account_no" type="number" style="width:100%" class="form-control" placeholder="Account No">
              </div>

              <div class="form-group">              
                <input type="text" id="bank_name" style="width:100%" class="form-control" placeholder="Bank Name">
              </div>

            
              <div class="form-group">              
                <input type="text" id="account_title" style="width:100%" class="form-control" placeholder="Account Title">
              </div>

              <div class="form-group">              
                <input type="text" id="branch_name" style="width:100%" class="form-control" placeholder="Branch Name">
              </div>

              <br>

              <input type="button" onclick="savedata()"  value="Save Data" class="btn btn-primary float-left">


</div>
<div class="col-sm-4" style="float:left; margin-left:40px;  width:200px;">


        <select class="form-control" id="account_type" onchange=""  style="width:100%" >
					           	<option hidden="" value="">Select Account Type</option>
                     <option value='Saving'>Saving</option>
                     <option value='FDR'>FDR</option>
                     <option value='Current'>Current</option>
                     <option value='CD'>CD</option>
                     <option value='SND'>SND</option>
         </select>

         <br>

         <div class="form-group">              
                <input type="text" id="branch_address" style="width:100%" class="form-control" placeholder="Branch Address">
              </div>

            
              <div class="form-group">              
                <input  id="phone_no" type="number" style="width:100%" class="form-control" placeholder="Phone No">
              </div>

              <div class="form-group">              
                <input  id="starting_amount" type="number" style="width:100%" class="form-control" placeholder="Starting Amount">
              </div>
         

            

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
