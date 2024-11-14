<style>
thead tr {
    position: sticky;
    top: 0;
    border: 1px solid black;
}

.accordion {
    background-color: #eee;
    color: #444;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
}

.active,
.accordion:hover {
    background-color: #ccc;
}

.accordion:after {
    content: '\002B';
    color: #777;
    font-weight: bold;
    float: right;
    margin-left: 5px;
}

.panel {
    padding: 0 18px;
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
}

.pagination {
    text-align: center;
    float: right;
}

.prev-btn,
.next-btn {
    padding: 10px 20px;
    background-color: #f1f1f1;
    border: none;
    color: #333;
    font-size: 16px;
    cursor: pointer;
    margin-right: 10px;
}

.prev-btn:hover,
.next-btn:hover {
    background-color: #ddd;
}

.search-container {
    display: flex;
    align-items: center;
}

.search-input {
    padding: 10px;
    width: 200px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.search-btn {
    padding: 10px 20px;
    background-color: gray;
    border: none;
    color: white;
    font-size: 16px;
    margin-left: 10px;
    cursor: pointer;
}

.search-btn:hover {
    background-color: #ddd;
}
</style>

<?php

include "connection.php";

session_start(); 

$userid=$_SESSION["userid"];
$subuserid=$_SESSION["subuserid"];
$user_name=$_SESSION["username"];

$companyid=$_SESSION["companyid"];
$branchid=$_SESSION["branchid"];
$moduleid=$_SESSION["moduleid"];
$module_short_name=$_SESSION["module_short_name"];

echo "<input type='hidden' id='userid' value=$userid >";
echo "<input type='hidden' id='subuserids' value=$subuserid >";
echo "<input type='hidden' id='logged_username' value='$user_name' >";

echo "<input type='hidden' id='companyid' value=$companyid >";
echo "<input type='hidden' id='branchid' value=$branchid >";
echo "<input type='hidden' id='moduleid' value='$moduleid' >";
echo "<input type='hidden' id='module_short_name' value='$module_short_name' >";

date_default_timezone_set('Asia/Dhaka');
$current_date=date('Y-m-d');

?>
<input type="hidden" id="current_date" value="<?php echo date('Y-m-d'); ?>">
<?php

// Get User Data ..................................................

$username="";

$sql = "SELECT * FROM users where id=$userid";
$result = $master_conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $username=$row["name"];
  }
} else {
  
}


$company="";

$sql = "SELECT * FROM companies where id=$companyid";
$result = $master_conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $company=$row["name"];
    $companyname=$row["name"];
  }
}

echo "<input type='hidden' id='companyname' value='$companyname' >";

$branch="";
$branch_Manager="";
$branch_Address="";
$branch_Phone="";
$sql = "SELECT * FROM branches where id=$branchid";
$result = $master_conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $branch=$row["name"];
    $branch_Manager=$row["Branch_Manager_Name"];
    $branch_Address=$row["Branch_Address"];
    $branch_Phone=$row["Branch_Phone_No"];
  }
}

$_SESSION["Branch_Manager_Name"]=$branch_Manager;
$_SESSION["Branch_Address"]=$branch_Address;
$_SESSION["Branch_Phone_No"]=$branch_Phone;


$module="";
$sql = "SELECT * FROM modules where id=$moduleid";
$result = $master_conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $module=$row["name"];
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mkrow Admin | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- For Common Modal -->

    <style>
    /* The Modal (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 10;
        /* Sit on top */
        padding-top: 120px;
        /* Location of the box */
        left: 125px;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    @media print {
        #content {
            height: 500px;
        }
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }

    /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        padding-left: 98%;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    .Gradient {
        background: rgb(2, 0, 36);
        background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(198, 231, 222, 1) 0%, rgba(0, 212, 255, 1) 100%);
    }

    .Gradient {
        background: rgb(2, 0, 36);
        background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(198, 231, 222, 1) 0%, rgba(0, 212, 255, 1) 100%);
    }

    .Gradient2 {
        background: rgb(34, 193, 195);
        background: linear-gradient(0deg, rgba(34, 193, 195, 1) 0%, rgba(106, 90, 186, 1) 100%);
    }

    .Gradient3 {
        background: rgb(2, 0, 36);
        background: radial-gradient(circle, rgba(2, 0, 36, 1) 0%, rgba(2, 2, 25, 1) 69%, rgba(11, 79, 93, 1) 100%);
    }

    .Gradient4 {

        background: linear-gradient(to right, #33cccc 0%, #66ffcc 100%);
        color: white;

    }

    .Gradient5 {
        background: linear-gradient(to left, #0033cc 0%, #0066ff 100%);
    }

    .card-header {
        background: linear-gradient(to right, #33cccc 0%, #66ffcc 100%);
        color: white;
    }

    .headings {
        padding: 5px;
        border-radius: 2px;
        color: black;
    }
    </style>

    <!-- End Style For Common Modal -->

</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <!-- Modal -->

    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modal-body">Some text in the Modal..</div>
        </div>

    </div>

    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light Gradient" style="">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" id="menubar" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="home.php" style='color:black !important;' class="nav-link">Home</a>
                </li>

                <li class="nav-item d-none d-sm-inline-block">
                    <a href="ChangeModule.php" class="nav-link" style='color:black !important;'>Exchange Module</a>
                </li>

                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" style="">


                        <b> <span style='color:white;'><?php echo $company; ?> </span> - <span
                                style='color:white;'><?php echo $branch; ?></span> - <span
                                style='color:white;'><?php echo $module; ?></span>
                        </b>

                        <span class="badge badge-warning navbar-badge"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="calculator"
                        style="height:450px; overflow:hidden;">

                    </div>
                </li>

                &nbsp;&nbsp;

                <li class="nav-item d-none d-sm-inline-block">
                    <select class='form-control' id='ddlBranch'>
                        <?php
    $subuser_branchid=0;
    if(isset($_SESSION["subuser_branchid"]))
    {
        $subuser_branchid=$_SESSION["subuser_branchid"];
    }
$sqlsem = "SELECT * FROM branches where user_id=$userid and company_id=$companyid and ($subuser_branchid=0 OR id=$subuser_branchid)";
//echo $sqlsem;
$resultse = $master_conn->query($sqlsem);
echo "<option value='' hidden=''>Branch</option>";
if ($resultse->num_rows > 0) {
   
    while($rowse = $resultse->fetch_assoc()) {
       $ctg_id=$rowse["id"];
       $ctg_name=$rowse["name"];
       echo "<option value='$ctg_id'>".$ctg_name."</option>";

    }
} 
           ?>
                    </select>
                </li>

                &nbsp;&nbsp;

                <li class="nav-item d-none d-sm-inline-block">
                    <select class="form-control" id="ddlModule">
                        <option hidden="" value="">Module</option>
                        <?php
            $sql = "SELECT id,name FROM modules where id in (select module_id from user_wise_modules where user_id=$userid) ";
            //echo $sql;
            $result = $master_conn->query($sql);
            $validatuser=0;
            if ($result->num_rows > 0) {
              // output data of each row
              while($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $name = $row["name"];
                echo "<option value=$id>".$name."</option>";
              }
            } 
            ?>
                    </select>
                </li>

                &nbsp;&nbsp;
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index.html" class="nav-link btn btn-danger"
                        style='color:white; background: linear-gradient(to right, #996600 0%, #ff9900 100%);'>Log
                        Out</a>
                </li>
            </ul>

            <!-- SEARCH FORM -->
            <form class="form-inline ml-3" style='display:none;'>
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>

                    <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>


                </li>


                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4 gradient3" style="color:black !important;">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light"><?php echo $companyname ?></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?php echo $username ?></a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item has-treeview menu-open">
                            <a href="#" class="nav-link active gradient4">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="home.php" class="nav-link active gradient">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Dashboard</p>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <!-- Dynamic menu -->
                        <?php
$sqlsem = "SELECT * FROM features_category where module_id=$moduleid ";
$resultse = $master_conn->query($sqlsem);
if ($resultse->num_rows > 0) {
    while($rowse = $resultse->fetch_assoc()) {

      $category_id=$rowse["id"];

     echo '<li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                '.$rowse["name"].'
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">';

            $sqlsems = "SELECT * FROM features where category_id=$category_id ";
            $resultses = $master_conn->query($sqlsems);
            if ($resultses->num_rows > 0) {
                while($rowses = $resultses->fetch_assoc()) {
                  
                  $name=$rowses["name"];
                  $file_name=$rowses["file_name"];

                echo '<li class="nav-item">
                <a href="#" onclick="getcontent(\''.$file_name.'\')" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>'.$name.'</p>
                </a>
              </li>';

                }
              }
            
             
             echo '</ul>';

    }
  }
?>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    Settings
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" onclick="getcontent('employees_vw')" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Role</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" onclick="getcontent('role_permission')" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Role Permission</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" onclick="getcontent('subuser')" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>User Info</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#" onclick="getcontent('Change_Password')" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Change Password</p>
                                    </a>
                                </li>

                            </ul>

                        <li class="nav-item">
                            <a href="index.html" class="nav-link">
                                <i class="nav-icon fas fa-key"></i>
                                <p>
                                    Log Out
                                </p>
                            </a>

                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>


        <div id="content">
            <!-- Content Div -->


            <?php 

$display="display:block;";
if($subuserid!=0)
{
    $display="display:block;";
}

?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper dashboard-view" style="<?php echo $display ?>">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">

                                <h1 class="m-0 text-dark"> Dashboard </a> </h1>

                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Dashboard</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->


                <!-- Main content -->




                <!-- Main content -->
                <section class="content" style="display:none;">
                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                            <div class="col-lg-3 col-6 ">
                                <!-- small box -->
                                <div class="small-box bg-info Gradient ">
                                    <div class="inner headings">
                                        <h3> 5 </h3>

                                        <h4>Category</h4>
                                    </div>
                                    <div class="icon">
                                        <i class="ion-stats-bars"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success Gradient">
                                    <div class="inner headings">
                                        <h3> 9</h3>

                                        <h4>Product</h4>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-warning Gradient">
                                    <div class="inner headings">
                                        <h3>6 </h3>
                                        <h4>Customer</h4>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger Gradient">
                                    <div class="inner headings">
                                        <h3>7 </h3>

                                        <h4>Supplier</h4>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>

                </section>

            </div>
            <!-- /.content-wrapper -->

        </div> <!-- Content Div -->

        <footer class="main-footer">

            <div class="float-right d-none d-sm-inline-block">

            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
</body>

</html>

<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$("#ddlBranch").on('change', function() {
    debugger;
    var NewId = $(this).val();
    changeBranchModule('Branch', NewId);
});


$("#ddlModule").on('change', function() {
    var NewId = $(this).val();
    changeBranchModule('Module', NewId);
});


function changeBranchModule(type, NewId) {

    var dataString = 'type=' + type + '&NewId=' + NewId;
    console.log(dataString);
    // AJAX code to submit form.
    $.ajax({
        type: "POST",
        url: "Model/changeBranchModule.php",
        data: dataString,
        cache: false,
        async: false,
        success: function(html) {
            location.reload();
        }
    });

}

var id=0;
var viewcontent="";
function getcontent(viewname,viewdata="page=1&limit=10&search=")
{
debugger;
viewcontent = viewname;
document.getElementById("content").innerHTML="<center><img style='opacity:0.9;'   src='dist/img/loader.gif' /><center>";

$.ajax({
type: "POST",
url: "View/"+viewname+".php",
data: viewdata,
cache: false,
success: function(html) {

 document.getElementById("content").innerHTML = html;
 $('#content').show(300);

 var scripturl="Script/common.js";
 $.getScript( scripturl, function( data, textStatus, jqxhr ) {
        // do some stuff after script is loaded
    } );
    id=0;
}

});

}

function searchContent()
{
    var searchValue=$('.search-input').val();
    getcontent(viewcontent,"page=1&limit=10&search="+searchValue);
}


function deletedata(id,tablename,e)
{
    
   if(confirm('Are You Sure?'))
   {
    debugger;
    tablename = tablename.split('_')[0];
    var deleteData = {
                    "table": tablename,  // Example table
                    "id": id
                };

                // Make AJAX request
                $.ajax({
                    url: "API/DeleteData.php", 
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify(deleteData),
                    success: function(response) {
                        $(e).closest('tr').remove();
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.status + ': ' + xhr.statusText;
                        alert("<p>Error - " + errorMessage + "</p>");
                    }
                });
   }

}

function saveData(tableName) {
    // Object to store the request data
    var requestData = {
        "table": tableName,
        "columns": {},
        "condition": { id: id }
    };

    var isValid = true;  // Flag to track if the form is valid
    var missingFields = [];  // Array to store labels of missing required fields

    // Get all input, select, and textarea elements within the .card-body class
    $('.card-body').find('input, select, textarea').each(function () {
        var inputType = $(this).attr('type');
        var inputName = $(this).attr('id');
        var inputValue = $(this).val();

        // Get the label text associated with this input (by finding the nearest preceding label)
        var labelText = $(this).closest('.form-group').find('label').text().trim();

        // Check if the input is required
        if ($(this).prop('required')) {
            // If a dropdown (select) has value 0, or input/textarea is empty
            if ($(this).is('select') && inputValue == 0) {
                isValid = false;
                missingFields.push(labelText);  // Add the label text to the missing fields list
            } else if (inputValue.trim() === "") {
                isValid = false;
                missingFields.push(labelText);  // Add the label text to the missing fields list
            }
        }

        if(inputName){
        // Handle specific field logic for image_name
        if (inputName == "image_name") {
            $("#image-form").submit();
            if (image_name != "") {
                requestData.columns[inputName] = image_name;
            }
        } else {
            requestData.columns[inputName] = inputValue;
        }
    }
    });

    // If the form is invalid, show an error message and stop the function
    if (!isValid) {
        var errorMessage = "The following fields are required: " + missingFields.join(', ');
        alert(errorMessage);
        return;  // Stop the function if validation fails
    }

    // Log the requestData for debugging
    console.log(requestData);

    // Make AJAX request if validation is successful
    $.ajax({
        url: id == 0 ? "API/AddData.php" : "API/UpdateData.php",  // Replace with your API endpoint
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(requestData),
        success: function (response) {
            getcontent(viewcontent);
        },
        error: function (xhr, status, error) {
            var errorMessage = xhr.status + ': ' + xhr.statusText;
            alert("<p>Error - " + errorMessage + "</p>");
        }
    });
}




function updatedata(update_id, row) {
    var $cells = $(row).closest('tr').find('td');

    $cells.each(function() {
        var $cell = $(this);
        var className = $cell.attr('class').trim(); 
        console.log(className);
        if (className) {
            var formFieldId = className.replace('_name', '_id');
            var $formField = $('#' + formFieldId); 

            if ($formField.length) {
                if ($formField.is('input[type="text"]')) {
                    $formField.val($cell.text().trim());
                } else if ($formField.is('textarea')) {
                    $formField.val($cell.text().trim());
                } else if ($formField.is('select')) {
                    $formField.find('option').each(function() {
                        if ($(this).text().trim() === $cell.text().trim()) {
                            $(this).prop('selected', true);
                        }
                    });
                }
            }
        }
    });

    $('.saveButton').val('Update');  // Change button value to 'Update'
    id=update_id;
    ScrollToBottom();
}

function updateValue(checkbox, column, tableName,updateId) {
    var isChecked = $(checkbox).is(':checked') ? 1 : 0;

    var requestData = {
        "table": tableName,
        "columns": {},
        "condition": { id: updateId}
    };

    requestData.columns[column] = isChecked;

    $.ajax({
        url: "API/UpdateData.php",  // Replace with your API endpoint
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(requestData),
        success: function(response) {
        },
        error: function(xhr, status, error) {
            var errorMessage = xhr.status + ': ' + xhr.statusText;
            alert("<p>Error - " + errorMessage + "</p>");
        }
    });
}

function getDepndentData(e,onchange_table,onchange_value_column,onchange_option_column)
{
    var thisId = $(e).attr('id');
    var thisValue =  $(e).val();  // Get the id of the element using jQuery
    //alert("value: " + thisValue);   // Display the id
    //alert("Table: " + onchange_table); 

    $.ajax({
        url: 'API/GetDependentData.php',  // Replace with the correct path to your PHP file
        type: 'POST',
        data: {
            thisId: thisId,
            thisValue: thisValue,
            onchange_table: onchange_table,
            onchange_value_column:onchange_value_column,
            onchange_option_column:onchange_option_column
        },
        success: function(response) {
            // Update your dropdown (or any other element) with the response options
            $('#'+onchange_table+'_id').html(response);
        },
        error: function(xhr, status, error) {
            console.error("Error: " + error);
        }
    });

}




function saveMasterDetailData(tableName, detailTableName, foreignKey) {
    // Prepare master data
    var masterData = {
        "table": tableName,
        "columns": {},
        "condition": { id: id }
    };

    var isValid = true;  // Flag to track if the form is valid
    var missingFields = [];  // Array to store labels of missing required fields

    // Get all input, select, and textarea elements within the .card-body class for master data
    $('.card-body').find('input, select, textarea').each(function () {
        var inputType = $(this).attr('type');
        var inputName = $(this).attr('id');
        var inputValue = $(this).val();

        // Get the label text associated with this input (by finding the nearest preceding label)
        var labelText = $(this).closest('.form-group').find('label').text().trim();

        // Check if the input is required
        if ($(this).prop('required')) {
            // If a dropdown (select) has value 0, or input/textarea is empty
            if ($(this).is('select') && inputValue == 0) {
                isValid = false;
                missingFields.push(labelText);  // Add the label text to the missing fields list
            } else if (inputValue.trim() === "") {
                isValid = false;
                missingFields.push(labelText);  // Add the label text to the missing fields list
            }
        }

        if(inputName){

            /*if (inputName.endsWith("Sum")) {
              return; // Skip this iteration
            }*/

            // Handle specific field logic for image_name
            if (inputName == "image_name") {
                $("#image-form").submit();
                if (image_name != "") {
                    masterData.columns[inputName] = image_name;
                }
            } else {
                masterData.columns[inputName] = inputValue;
            }
        }
    });

    // If the form is invalid, show an error message and stop the function
    if (!isValid) {
        var errorMessage = "The following fields are required: " + missingFields.join(', ');
        alert(errorMessage);
        return;  // Stop the function if validation fails
    }

    // Get detail data from table
    var detailData = getTableData();  // Uses getTableData function to retrieve table data

    // Create a combined request payload
    var requestData = {
        "master": masterData.columns,  // Master data
        "detail": detailData,  // Detail data from table
        "master_table": tableName,  // Master table name
        "detail_table": detailTableName,  // Detail table name
        "foreign_key": foreignKey,  // Foreign key linking detail to master
        "id":id
    };

    // Log the requestData for debugging
    console.log("Request Data:", requestData);

    // Make AJAX request if validation is successful
    $.ajax({
        url: id == 0 ? "API/AddMasterDetailData.php" : "API/UpdateMasterDetailData.php",  // Replace with your API endpoint
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(requestData),
        success: function (response) {
            getcontent(viewcontent);
            alert("Data saved successfully!");
        },
        error: function (xhr, status, error) {
            var errorMessage = xhr.status + ': ' + xhr.statusText;
            alert("Error - " + errorMessage);
        }
    });
}



function deleteMasterDetailData(id, masterTable, detailTable, foreignKey, element) {
    masterTable = masterTable.split('_')[0];
    if (confirm('Are You Sure?')) {
        var deleteData = {
            "master_table": masterTable,
            "detail_table": detailTable,
            "foreign_key": foreignKey,
            "id": id
        };

        // Make AJAX request to delete API
        $.ajax({
            url: "API/DeleteMasterDetailData.php",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(deleteData),
            success: function(response) {
                // Remove the row from the table if deletion is successful
                $(element).closest('tr').remove();
                alert("Record deleted successfully.");
            },
            error: function(xhr, status, error) {
                var errorMessage = xhr.status + ': ' + xhr.statusText;
                alert("Error - " + errorMessage);
            }
        });
    }
}



function updateMasterdetailData(update_id,form_id, row) {
    var $cells = $(row).closest('tr').find('td');

    // Call detail and replace the table
    $.ajax({
        url: 'API/FetchDetailTable.php',  // Assuming this is the endpoint to fetch detail data
        type: 'POST',
        data: { id: update_id,form_id:form_id },
        dataType: 'html',
        success: function(response) {
            // Replace the current detail table with the fetched data
            $('#detailSection').html(response);

            // Update the save button text
            $('.saveButton').val('Update');  // Change button value to 'Update'
            id = update_id;

            // Scroll to the bottom if needed
            ScrollToBottom();

            // Reinitialize table events
            reinitializeTableEvents();

            // Run the $cells.each loop only after the AJAX call is complete
            $cells.each(function() {
                var $cell = $(this);
                var className = $cell.attr('class').trim(); 
                console.log(className);

                if (className) {
                    var formFieldId = className.replace('_name', '_id');
                    var $formField = $('#' + formFieldId); 

                    if ($formField.length) {
                        if ($formField.is('input[type="text"]')) {
                            $formField.val($cell.text().trim());
                        } else if ($formField.is('textarea')) {
                            $formField.val($cell.text().trim());
                        } else if ($formField.is('select')) {
                            $formField.find('option').each(function() {
                                if ($(this).text().trim() === $cell.text().trim()) {
                                    $(this).prop('selected', true);
                                }
                            });
                        }
                    }
                }
            });
        },
        error: function() {
            alert("Error fetching detail data.");
        }
    });
}



function ScrollToBottom()
{
  window.scrollTo(0, document.body.scrollHeight);
}  

function ScrollToTop()
{
  document.documentElement.scrollTop = 0;
}  


function ReportRefresh() {
    var searchValue = "";
    
    // Loop through each input element in the form
    $('.form-inline :input').each(function() {
        var input = $(this);
        
        // Check if the input has a value and it’s not empty
        if (input.val() !== "" && input.val() !== "0") {
            var id = input.attr('id');
            var value = input.val();
            
            // Append the condition to searchValue
            if (searchValue !== "") {
                searchValue += " and ";
            }
            searchValue += id + "='" + value + "'";
        }
    });
    
    // Check if there’s a condition created
    if (searchValue) {
        // Call the getcontent function with searchValue
        getcontent(viewcontent, "page=1&limit=10&search=" + searchValue);
    } else {
        alert("Please enter at least one search criteria.");
    }
}


function buildProcess(id, builder, element) {
    let apiUrl = "";

    // Determine the API URL based on the value of builder
    switch(builder) {
        case 1:
            apiUrl = "API/CreateParameterForm.php";
            break;
        case 2:
            apiUrl = "API/CreateMasterDetailForm.php";
            break;
        case 3:
            apiUrl = "API/CreateReport.php";
            break;
        default:
            console.error("Invalid builder value.");
            return; // Exit the function if the builder value is not recognized
    }

    // Perform an AJAX GET request to the selected API
    $.ajax({
        url: apiUrl,
        method: "GET",
        data: { form_id: id },
        success: function(response) {
            // Handle the response here
            console.log("API response:", response);
            alert("Process Successfuly Executed");
            // Optional: Update the element or perform other actions based on the response
        },
        error: function(xhr, status, error) {
            // Handle errors here
            console.error("API request failed:", error);
        }
    });
}


/* Test 
function save(sql)
{

var sql=encodeURI(sql);
var subuserid=$('#subuserids').val();

var dataString="sql="+sql;

//alert(dataString);
      
$.ajax({
type: "POST",
url: "Model/master_DB_save.php",
data: dataString,
cache: false,
success: function(html) {

 //alert(html);
 
  toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
 
 toastr.success(html); // display success message
 

 
 getcontent(viewcontent);
 id=0;
 //document.getElementById("content").innerHTML = html;

}
});



}




function APITest(){

    var deleteData = {
                    "table": "roles",  // Example table
                    "id": 4
                };

                // Make AJAX request
                $.ajax({
                    url: "API/DeleteData.php", 
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify(deleteData),
                    success: function(response) {
                        $("#response").html("<p>" + response.message + "</p>");
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.status + ': ' + xhr.statusText;
                        $("#response").html("<p>Error - " + errorMessage + "</p>");
                    }
                });

}

APITest();

*/


</script>