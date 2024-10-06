<?php

include "../connection.php";

session_start(); 

$userid=$_SESSION["userid"];
$subuserid=$_SESSION["subuserid"];
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
            <h1>Expense</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Expense</li>
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
                <h3 class="card-title" >List of Expense</h3>
                <a href="#add"><span style="float:right; cursor:pointer;">Add New</span></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow:auto;">
                <table id="example1" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Branch</th>
                    <th>Expense From</th>
                    <th>Expense By</th>
                    <th>Expense For</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Note</th>
                    <th style='text-align:center;'>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;
if($subuserid==0 || $subuserid==7) { 
    $sql = "SELECT * FROM expense where userid=$userid and companyid=$companyid  order by id desc";
}
else
{
    $sql = "SELECT * FROM expense where userid=$userid and companyid=$companyid and expense_from!='Head Office'  order by id desc";
}
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $expense_head_id=$row["expense_head_id"];
    $branchid=$row["branchid"];
    $note=$row["Note"];
    $employeeid=$row["employeeid"];
    
$expense_for="";
$sqlb = "SELECT * FROM expense_head where  id=$expense_head_id";
$resultb = $conn->query($sqlb);
if ($resultb->num_rows > 0) {
  // output data of each row
  while($rowb = $resultb->fetch_assoc()) {
       $expense_for=$rowb["name"];
  }
}

$Barnch="Head Office";
$sqlb = "SELECT * FROM branches where  id=$branchid";
$resultb = $master_conn->query($sqlb);
if ($resultb->num_rows > 0) {
  // output data of each row
  while($rowb = $resultb->fetch_assoc()) {
       $Barnch=$rowb["name"];
  }
}

$expense_by="";
$sqlb = "SELECT * FROM employee where  id=$employeeid";
$resultb = $conn->query($sqlb);
if ($resultb->num_rows > 0) {
  // output data of each row
  while($rowb = $resultb->fetch_assoc()) {
       $expense_by=$rowb["name"];
  }
}

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='branch'>".$Barnch."</td>";
     echo "<td class='expense_from'>".$row["expense_from"]."</td>"; 
     echo "<td class='expense_by'>".$expense_by."</td>"; 
     echo "<td class='expense_for'>".$expense_for."</td>"; 
     echo "<td class='amount'>".$row['amount']."</td>"; 
     echo "<td class='expense_date'>".$row["expense_date"]."</td>"; 
     echo "<td class='note'>".$note."</td>"; 
     
     echo "<td class='text-center py-0 align-middle' style='text-align:center;'>
                      <div class='btn-group btn-group-sm'>
                        <a onclick='updatedata($id,this)' class='btn btn-info'><i class='fas fa-edit'></i></a>
                        <a onclick=deletedata($id,this,'expense') class='btn btn-danger'><i class='fas fa-trash'></i></a>
                      </div>
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

    <!-- End Table -->




    <!-- Main content -->
<section class="content" id="add">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Expense</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">



              <div class="widget-content nopadding" style=" margin:20px;">
                  
                  <select class="form-control" id="branchesid"  name="branchesid" style="width:25%" >
						<option hidden="" value="0">Select Branch</option>
						
  <?php
$sql = "SELECT * FROM branches where  user_id=$userid and company_id=$companyid";
$result = $master_conn->query($sql);
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
          
            <select class="form-control" id="expense_from"  name="expense_from" style="width:25%" >
						<option hidden="" value="Branch">Select Expense From</option>
						<option value='Branch'>Branch</option>
						<option value='Head Office'>Head Office</option>
			</select>
         
          <br>
                  
        <select class="form-control" id="expense_head_id"  name="expense_head_id" style="width:25%" >
						<option hidden="" value="">Select Expense Head</option>
  <?php
$sql = "SELECT * FROM expense_head where  userid=$userid and companyid=$companyid";
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
          
          
              
              <?php
$sqlsem = "SELECT * FROM employee where userid=$userid and companyid=$companyid";
$resultse = $conn->query($sqlsem);
echo "<select  class='form-control' style='width:25%;' id='employeeid' name='employee' >";
echo "<option hidden='' value=''>Select Expense By</option>";
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

<br>
          
 
              <div class="form-group">
                <label for="category">Amount</label>
                <input type="number" id="amount" style="width:25%" class="form-control"  placeholder="Amount">
              </div>

              <div class="form-group">
                <label for="category">Date</label>
                <input type="date" id="date" style="width:25%" class="form-control"  placeholder="Date">
              </div>
              
              <div class="form-group">
                <label for="category">Note</label>
                <input type="text" id="note" style="width:25%" class="form-control"  placeholder="Note">
              </div>
              


              <input type="button" onclick="savedata()"  value="Save" class="btn btn-success float-left">
              
               <input type="button" onclick="reload()" style="margin-left:20px;" class="btn btn-success float-left" value="Refresh Page" name="" id="" class="btn"/>
              
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        
      </div>
     
    </section>
    <!-- /.content -->




</div>
