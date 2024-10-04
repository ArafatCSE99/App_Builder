<?php
include "../connection.php";

//session_start(); 

$userid = $_SESSION["userid"];
$subuserid = $_SESSION["subuserid"];
$companyid = $_SESSION["companyid"];
$branchid = $_SESSION["branchid"];

// Capture pagination and search parameters
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$limit = isset($_POST['limit']) ? intval($_POST['limit']) : 10;
$search = isset($_POST['search']) ? $_POST['search'] : '';

$offset = ($page - 1) * $limit;

// Query to fetch customers with search and pagination
$sql = "SELECT id, name, mobileno, address, reference, image, opening_due, month, proprietor_name, isDefaulter
        FROM customer 
        WHERE userid=$userid AND companyid=$companyid AND branchid=$branchid";

if (!empty($search)) {
    $sql .= " AND (name LIKE '%$search%' OR mobileno LIKE '%$search%'  OR address  LIKE '%$search%' )";
}

$sql .= " ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

// Get total records
$total_sql = "SELECT COUNT(*) as total FROM customer WHERE userid=$userid AND companyid=$companyid AND branchid=$branchid";
if (!empty($search)) {
    $total_sql .= " AND (name LIKE '%$search%' OR mobileno LIKE '%$search%' OR address  LIKE '%$search%' )";
}
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];

$total_pages = ceil($total_records / $limit);
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Customers New</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Customer</li>
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
                <h3 class="card-title" >List of Customer</h3>
                <a href="#add"><span style="float:right; cursor:pointer;">Add New</span></a> &nbsp; &nbsp;
                <!-- <a onclick="getcontent('customer','limit=10000')"><span style="float:right; cursor:pointer; margin-right:10px;">View All</span></a>&nbsp; &nbsp; -->
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow:auto;">
                  
<div class="search-container">
  <input type="text" class="search-input" placeholder="Search...">
  <button onclick='searchContent()' class="search-btn ">Search</button>
</div>
<br>
                  
                <table id="" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Name</th>
                    <th>Proprietor</th>
                    <th>Image</th>
                    <th>Mobile No</th>
                    <th>Address</th>
                    <th>Reference</th>
                    <th>Opening<br>Balance</th>
                    <th>Month</th>
                    <th>Current<br>Balance</th>
                    
                    <th style='text-align:center;'>Def/Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

//$sql = "SELECT id,name,mobileno,address,reference,image,opening_due,month,proprietor_name,isDefaulter FROM customer where userid=$userid and companyid=$companyid and branchid=$branchid order by id desc limit $limit";
//$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $name=$row["name"];
    $proprietor_name=$row["proprietor_name"];
    $isDefaulter=$row["isDefaulter"];
    $imageurl="";
    if($row["image"]!="")
    {
      $imageurl="imageUpload/uploads/".$row["image"];

    }

// Check Customer is in Sales . . .
$isDelete=true;
$sqlc = "SELECT id FROM sales_master where customerid=$id";
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
     echo "<td class='proprietor'>".$proprietor_name."</td>";
     echo "<td class='image'><img src=$imageurl height='50px' width='50px'></td>"; 
     echo "<td class='mobileno'>".$row['mobileno']."</td>"; 
     echo "<td class='address'>".$row["address"]."</td>"; 
     echo "<td class='reference'>".$row["reference"]."</td>"; 
     echo "<td class='opening_due'>".$row["opening_due"]."</td>"; 
     echo "<td class='month'>".$row["month"]."</td>";
     
     // Balance calculation ...........................
     
$sqls = "SELECT sum(due) as total_due FROM sales_master where userid=$userid and customerid=$id";
$results = $conn->query($sqls);

if (mysqli_num_rows($results) > 0) {
  // output data of each row
  while($rows = mysqli_fetch_assoc($results)) {
   $total_duetk=$rows["total_due"];
  }
} else {
  $total_duetk=0;
}


$sqls = "SELECT sum(out_account) as total_due_app FROM app_customer_account where userid=$userid and customerid=$id";
$results = $conn->query($sqls);

if (mysqli_num_rows($results) > 0) {
  // output data of each row
  while($rows = mysqli_fetch_assoc($results)) {
   $total_due_app=$rows["total_due_app"];
  }
} else {
  $total_due_app=0;
}

$TotalDue=$row["opening_due"]+$total_duetk+$total_due_app;


// Payments ...................................

$sqls = "SELECT sum(in_account) as total_pay_app FROM app_customer_account where userid=$userid and customerid=$id";
$results = $conn->query($sqls);

if (mysqli_num_rows($results) > 0) {
  // output data of each row
  while($rows = mysqli_fetch_assoc($results)) {
   $total_pay_app=$rows["total_pay_app"];
  }
} else {
  $total_pay_app=0;
}


$sqls = "SELECT sum(amount) as sales_pay FROM sales_payment where  salesid in(select id from sales_master where customerid=$id)";
$results = $conn->query($sqls);

if (mysqli_num_rows($results) > 0) {
  // output data of each row
  while($rows = mysqli_fetch_assoc($results)) {
   $total_sales_pay=$rows["sales_pay"];
  }
} else {
  $total_sales_pay=0;
}

$total_pay=$total_sales_pay+$total_pay_app;

$balance=$TotalDue-$total_pay;

echo "<td class='current_due'>".$balance."</td>";
     
     echo "<td class='text-center py-0 align-middle' style='text-align:center;'>
                      <div class='btn-group btn-group-sm'>
                      <input type='checkbox' onchange='updateDefaulter($id,this)' $isDefaulter>
                      &nbsp; &nbsp; &nbsp;
                      <a onclick='PrintReceipt($id,this)' class='btn btn-info'><i class='fas fa-print'></i></a>";
                      if($subuserid==0){
                       echo "<a onclick='updatedata($id,this)' class='btn btn-info'><i class='fas fa-edit'></i></a>";
                      }
                        if($isDelete){
                        echo "<a onclick=deletedata($id,this,'customer') class='btn btn-danger'><i class='fas fa-trash'></i></a>";
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
            
              <!-- Pagination -->
                <?php
                if ($total_pages > 1) {
                    echo "<nav aria-label='Page navigation example'><ul class='pagination'>";
                   
                    
                   if ($page > 1) {
    $prev_page = $page - 1;
    echo "<li class='page-item'>
            <a class='page-link' 
               onclick=\"getcontent('customer_new','page=$prev_page&limit=$limit&search=$search')\">
               Previous
            </a>
          </li>";
}

for ($i = $page; $i <= $page + 9 && $i <= $total_pages; $i++) {
    $active = ($i == $page) ? "active" : "";
    echo "<li class='page-item $active'>
            <a class='page-link' 
               onclick=\"getcontent('customer_new','page=$i&limit=$limit&search=$search')\">
               $i
            </a>
          </li>";
}

if ($page < $total_pages) {
    $next_page = $page + 1;
    echo "<li class='page-item'>
            <a class='page-link' 
               onclick=\"getcontent('customer_new','page=$next_page&limit=$limit&search=$search')\">
               Next
            </a>
          </li>";
}

                    
                    echo "</ul></nav>";
                }
                ?>

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
              <h3 class="card-title">Add Customer</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
            <div class="card-body">

<div class="row">
    
    <div class="col-sm-8">

              <div class="form-group">
                <label for="category">Customer Name</label>
                <input type="text" id="name" style="width:50%" class="form-control" placeholder="Customer Name">
              </div>
              
               <div class="form-group">
                <label for="proprietor">Proprietor Name</label>
                <input type="text" id="proprietor" style="width:50%" class="form-control" placeholder="Proprietor Name">
              </div>
 
              <div class="form-group">
                <label for="category">Mobile No</label>
                <input type="text" id="mobileno" style="width:50%" class="form-control"  placeholder="Mobile No">
              </div>

              <div class="form-group">
                <label for="category">Address</label>
                <input type="text" id="address" style="width:50%" class="form-control"  placeholder="Address">
              </div>
              
              <div class="form-group">
                <label for="category">Reference</label>
                <input type="text" id="reference" style="width:50%" class="form-control"  placeholder="Reference">
              </div>

              <div class="form-group">
                <label for="category">Opening Balance</label>
                <input type="number" id="opening_due" style="width:50%" class="form-control"  placeholder="Balance">
              </div>
              
              <div class="form-group">
                <label for="category">Month</label>
                <input type="number" id="month" style="width:50%" class="form-control"  placeholder="Month">
              </div>

 

              <input type="button" onclick="savedata()"  value="Save" class="btn btn-success float-left">
              
              </div>
              
               <div class="col-sm-4">
                   
                   <form method="post" id="image-form" enctype="multipart/form-data" onSubmit="return false;">
				<div class="form-group">
					<input type="file" name="file" class="file">
					<div class="input-group my-3" style="width:350px;">
						<input type="text" style="width:20px; display:none;" class="form-control" disabled placeholder="Upload Product Image" id="file">
						<div class="input-group-append">
							<button type="button" style="display:none;" class="browse btn btn-primary">Browse...</button>
						</div>
					</div>
				</div>

      <div class="form-group">
       
					<img src="dist/img/global_logo.png" height="400px;" width="150px;" id="preview" class="img-thumbnail">
			
      </div>

				<div class="form-group">
					<input type="submit" name="submit" value="Upload" style="display:none;" class="btn btn-danger">
				</div>
    </form>

                   
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
