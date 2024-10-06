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
$sql = "SELECT c.id, c.name, mobileno, address, reference, image, opening_due, month, proprietor_name, isDefaulter,dv.name as dvName,dc.name as dcName,up.name as upName,un.name AS unName,vl.name AS vlName
        FROM customer c
        left join divisions dv on dv.id=c.division_id
        left join districts dc on dc.id=c.district_id
        left join upazilas up on up.id=c.upazilla_id
        left join unions un on un.id=c.union_id
        left join village vl on vl.id=c.village_id
        WHERE c.userid=$userid AND c.companyid=$companyid AND c.branchid=$branchid";
//echo $sql;
if (!empty($search)) {
    $sql .= " AND (c.name LIKE '%$search%' OR c.mobileno LIKE '%$search%'  OR c.address  LIKE '%$search%' )";
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
                    <th>Mobile No</th>
                    <th>Division</th>
                    <th>District</th>
                    <th>Upazilla</th>
                    <th>Union</th>
                    <th>Village</th>
                    
                    <th style='text-align:center;'>Def/Action</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $id=$row["id"];
    $name=$row["name"];
    
    

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
     echo "<td class='mobileno'>".$row["mobileno"]."</td>"; 
     echo "<td class='dvName'>".$row["dvName"]."</td>"; 
     echo "<td class='dcName'>".$row["dcName"]."</td>"; 
     echo "<td class='upName'>".$row["upName"]."</td>"; 
     echo "<td class='unName'>".$row["unName"]."</td>"; 
     echo "<td class='vlName'>".$row["vlName"]."</td>"; 

     
     echo "<td class='text-center py-0 align-middle' style='text-align:center;'>
                      <div class='btn-group btn-group-sm'>
                      <a onclick='PrintReceipt($id,this)' class='btn btn-info'><i class='fas fa-print'></i></a>";
                      if($subuserid==0){
                       echo "<a onclick='updatedata($id,this)' class='btn btn-info'><i class='fas fa-edit'></i></a>";
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
 
             
             <?php

$sqlsem = "SELECT * FROM divisions";
$resultse = $conn->query($sqlsem);
echo '<div class="form-group"><label for="name">Division</label>';
echo "<select  class='form-control' onchange='getdistrict()' style='width:50%; margin-left:0px;' id='division' name='division'>";

echo "<option hidden='' value=''>--Select Division--</option>";

if ($resultse->num_rows > 0) {

while($rowse = $resultse->fetch_assoc()) {

$name=$rowse["name"];
$bnname=$rowse["bn_name"];
$id=$rowse["id"];

  echo  "<option value='$id'>".$name."</option>";

}

} else {

echo  "<option >None</option>";

}

echo " </select></div>";

?>



<?php

echo '<div class="form-group"><label for="name">District</label>';
echo "<select  class='form-control' onchange='getupazilla()' style='width:50%; margin-left:0px;' id='district' name='district' required>";

echo "<option hidden='' value=''>--Select District--</option>";

echo " </select></div>";

?>



<?php

echo '<div class="form-group"><label for="name">Upazilla</label>';
echo "<select  class='form-control' onchange='getunion()' style='width:50%; margin-left:0px;' id='upazilla' name='upazilla' required>";
echo "<option hidden='' value=''>--Select Upazilla--</option>";
echo " </select></div>";

?>

<?php

echo '<div class="form-group"><label for="name">Union</label>';
echo "<select  class='form-control' onchange='getvillage()' style='width:50%; margin-left:0px;' id='union' name='union' required>";
echo "<option hidden='' value=''>--Select Union--</option>";
echo " </select></div>";

?>

<?php

echo '<div class="form-group"><label for="name">Village</label>';
echo "<select  class='form-control' style='width:50%; margin-left:0px;' id='village' name='village' required>";
echo "<option hidden='' value=''>--Select Village--</option>";
echo " </select></div>";

?>

<div class="form-group">
                <label for="category">Village Name</label>
                <input type="text" id="newVillage" style="width:50%" class="form-control" placeholder="New Village">
                <button class="btn btn-default" onclick="AddVillage()">Add New Village</button>
</div>
 

              <input type="button" onclick="savedata()"  value="Save" class="btn btn-success float-left">
              
              </div>
              
               <div class="col-sm-4">
                   
                
                   
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
