
<?php

include "../connection.php";
include "../Classes/ReportComponentClass.php";

session_start(); 

$userid=$_SESSION["userid"];
$companyid=$_SESSION["companyid"];

$page=$_POST["page"];
$limit=$_POST["limit"];
$search=$_POST["search"];

// Content  ......................................................

?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product Report  
            
           
            </h1> 

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product Report</li>
            </ol>
          </div>
        </div>




      </div><!-- /.container-fluid -->
    </section>



  <?php
 

  ?>




    <!-- Table -->   

    <section class="content">
      <div class="row">
        <div class="col-md-12">

    <div class="card ">
              <div class="card-header">
                <h3 class="card-title" >
                <img src="dist/img/print.png" height="50px;" style="cursor:pointer;" id="print">
                <img src="dist/img/pdf.png" height="50px;" style="cursor:pointer;" id="pdf">
                <img src="dist/img/exel.jpg" height="50px;" style="cursor:pointer;" id="excel">
              </h3> 
              </div>
              <!-- /.card-header -->
              <div class="card-body" id="section-to-print">

           <div id="Report" style="border:0px solid gray; ">

<?php

$headerComponent = new HeaderComponent();
echo $headerComponent->GetHeader($master_conn,1,1,'Dinajpur','Birganj');

$tableComponent = new TableComponent();
$columns = [
    'name' => 'Full Name',
    'image_name' => 'Image',
    'department_name' => 'Department Name',
    'designation_name' => 'Designation Name',
    'is_active' => 'Is Active',
    'note' => 'Note',
    'total_hours_done' => 'Total Hours Done',
    'total_remaining_hours' => 'Total Remaining Hours',
];
echo $tableComponent->GetTable($master_conn,'employees_report_test', $columns,$page,$limit,$search,false,'','');

                ?>


              </div> <!-- Report Div Close -->


              </div>
              <!-- /.card-body -->
            </div>


            </div>
        
        </div>
       
    </section>

    <!-- End Table -->
</div>
