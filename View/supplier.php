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
            <h1>Suppliers</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">supplier</li>
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
                <h3 class="card-title" >List of Supplier</h3>
                <a href="#add"><span style="float:right; cursor:pointer;">Add New</span></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow:auto;">
                <table id="example1" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Supplier Name</th>
                    <th>Mobile No</th>
                    <th>Address</th>
                    <?php if($subuserid==0) { ?> 
                    <th class='HideData'>Opening<br>Balance</th>
                    <?php } else { ?>
                    <th class='HideData' style="display:none;">Opening<br>Balance</th>
                    <?php } ?>
                     <th>Current<br>Balance</th>
                    <th style='text-align:center;'>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

$sql = "SELECT id,name,mobileno,address,opening_due FROM supplier where userid=$userid and companyid=$companyid and branchid=$branchid";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $name=$row["name"];


// Check Supplier is in Purchase . . .
$isDelete=true;
$sqlc = "SELECT id FROM purchase_master where supplierid=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $isDelete=false;
  }
}  

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='name'>".$name."</td>"; 
     echo "<td class='mobileno'>".$row['mobileno']."</td>"; 
     echo "<td class='address'>".$row["address"]."</td>"; 
     if ($subuserid==0){
     echo "<td class='opening_due HideData'>".$row["opening_due"]."</td>"; 
     }
     else{
       echo "<td style='display:none;' class='opening_due HideData'>".$row["opening_due"]."".$subuserid."</td>"; 
     }
     
     // Balance calculation ...........................
     
$sqls = "SELECT sum(due) as total_due FROM purchase_master where userid=$userid and supplierid=$id";
$results = $conn->query($sqls);

if (mysqli_num_rows($results) > 0) {
  // output data of each row
  while($rows = mysqli_fetch_assoc($results)) {
   $total_duetk=$rows["total_due"];
  }
} else {
  $total_duetk=0;
}


$sqls = "SELECT sum(out_account) as total_due_app FROM app_supplier_account where userid=$userid and supplierid=$id";
$results = $conn->query($sqls);

if (mysqli_num_rows($results) > 0) {
  // output data of each row
  while($rows = mysqli_fetch_assoc($results)) {
   $total_due_app=$rows["total_due_app"];
  }
} else {
  $total_due_app=0;
}




// Payments ...................................

$sqls = "SELECT sum(in_account) as total_pay_app FROM app_supplier_account where userid=$userid and supplierid=$id";
$results = $conn->query($sqls);

if (mysqli_num_rows($results) > 0) {
  // output data of each row
  while($rows = mysqli_fetch_assoc($results)) {
   $total_pay_app=$rows["total_pay_app"];
  }
} else {
  $total_pay_app=0;
}


$sqls = "SELECT sum(amount) as sales_pay FROM purchase_payment_inv where  purchaseid in(select id from purchase_master where supplierid=$id)";
$results = $conn->query($sqls);

if (mysqli_num_rows($results) > 0) {
  // output data of each row
  while($rows = mysqli_fetch_assoc($results)) {
   $total_sales_pay=$rows["sales_pay"];
  }
} else {
  $total_sales_pay=0;
}

$TotalDue=$row["opening_due"]+$total_duetk+$total_pay_app;

$total_pay=$total_sales_pay+$total_due_app;

$balance=$TotalDue-$total_pay;

echo "<td class='current_due'>".$balance."</td>";
     
     
     echo "<td class='text-center py-0 align-middle' style='text-align:center;'>
                      <div class='btn-group btn-group-sm'>
                        <a onclick='updatedata($id,this)' class='btn btn-info'><i class='fas fa-edit'></i></a>";
                        if($isDelete){
                         echo "<a onclick=deletedata($id,this,'supplier') class='btn btn-danger'><i class='fas fa-trash'></i></a>";
                        }
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

    <!-- End Table -->




    <!-- Main content -->
<section class="content" id="add">
      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add Supplier</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">

              <div class="form-group">
                <label for="category">Supplier Name</label>
                <input type="text" id="name" style="width:25%" class="form-control" placeholder="Supplier Name">
              </div>

              <div class="form-group">
                <label for="category">Mobile No</label>
                <input type="text" id="mobileno" style="width:25%" class="form-control" placeholder="Mobile No">
              </div>

              <div class="form-group">
                <label for="category">Address</label>
                <input type="text" id="address" style="width:25%" class="form-control" placeholder="Address">
              </div>
              
             <?php if($subuserid==0) { ?>
               <div class="form-group HideData">
                <label for="category">Opening Balance</label>
                <input type="number" id="opening_due" style="width:25%" class="form-control"  placeholder="Balance">
              </div>
             <?php } else { ?>
             <div class="form-group HideData">
                <label for="category">Opening Balance</label>
                <input type="number" id="opening_due" style="width:25%" class="form-control"  placeholder="Balance">
              </div>
              <?php } ?>
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
