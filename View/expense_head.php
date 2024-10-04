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
            <h1>Expense head</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Expense head</li>
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
                <h3 class="card-title" >List of Expense Head</h3>
                <a href="#add"><span style="float:right; cursor:pointer;">Add New</span></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow:auto;">
                <table id="example1" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Name</th>
                   <th>Profit Type</th>
                    <th style='text-align:center;'>Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

$sql = "SELECT * FROM expense_head where userid=$userid and companyid=$companyid";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $name=$row["name"];
    $profit_type=$row["profit_type"];
    
    $cash_flag="";
    if($profit_type=="Cash Profit")
    {
        $cash_flag="selected";
    }
    
    $due_flag="";
    if($profit_type=="Due Profit")
    {
        $due_flag="selected";
    }
    
    $ins_flag="";
    if($profit_type=="Installment Profit")
    {
        $ins_flag="selected";
    }

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='expense_headname'>".$name."</td>"; 
     $pc="profit_type".$id;
     echo "<td><select onchange='update_profit_type($id)'  class='$pc' >";
     echo "<option hidden='' value='' >Select Profit Type</option>";
     echo "<option value='Cash Profit' $cash_flag>Cash Profit</option>";
     echo "<option value='Due Profit' $due_flag>Due Profit</option>";
     echo "<option value='Installment Profit' $ins_flag>Installment Profit</option>";
     echo "</select></td>";
     
     echo "<td class='text-center py-0 align-middle' style='text-align:center;'>
                      <div class='btn-group btn-group-sm'>
                        <a onclick='updatedata($id,this)' class='btn btn-info'><i class='fas fa-edit'></i></a>";
                      
                       echo  "<a onclick=deletedata($id,this,'expense_head') class='btn btn-danger'><i class='fas fa-trash'></i></a>";
                       
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
              <h3 class="card-title">Add Expense head</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">

              <div class="form-group">
                <label for="expense_head">Expense head Name</label>
                <input type="text" id="expense_head" style="width:25%" class="form-control" placeholder="Expense head Name">
              </div>

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
