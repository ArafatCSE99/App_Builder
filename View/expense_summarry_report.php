
<?php

include "../connection.php";

session_start(); 

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
            <h1>Expense Summarry</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Expense Summarry</li>
            </ol>
          </div>
        </div>

        <?php


if(isset($_SESSION["s_dtfrom"])){
  $s_dtfrom=$_SESSION["s_dtfrom"];
  $s_dtto=$_SESSION["s_dtto"];
  $s_ctg=$_SESSION["s_ctg"];
  $s_model=$_SESSION["s_model"];
  $s_code=$_SESSION["s_code"];
  $s_name=$_SESSION["s_name"];
  $s_customer=$_SESSION["s_customer"];
  }
  else{
  $S_dtfrom='';
  $s_dtto='';
  $s_ctg='';
  $s_model='';
  $s_code='';
  $s_name='';
  $s_customer='';
  }

?>

<br>
           <span> 


      <form class = "form-inline" role = "form">

         <div class = "form-group">
            <label class = "sr-only" for = "dtfrom">Date From</label>
            <input type = "date" class = "form-control" id = "s_dtfrom">
         </div>
         &nbsp;&nbsp;
         <div class = "form-group">
            <label class = "sr-only" for = "dtfrom">Date To</label>
            <input type = "date" class = "form-control" id = "s_dtto">
         </div>
         &nbsp;&nbsp;


<button type = "button" onclick='ReportRefresh()' class = "btn btn-primary">Search</button>

      </form>

            </span> 


      </div><!-- /.container-fluid -->
    </section>



  <?php

// Get Report Heading Data ////////////////////////////////////

 // Get Shop Data ...............................................

 $shopname="";
 $mobileno="";
 $facebook="";
 $shopcategory='';
 $division='';
 $district='';
 $upazilla='';
 
 $insertupdateid=0;

$sql = "SELECT * FROM basic_info where userid=$userid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
// output data of each row
while($row = $result->fetch_assoc()) {
 
 $shopname=$row["shop_name"];
 $mobileno=$row["mobileno"];
 $facebook=$row["facebook"];
 $shopcategory=$row["shop_categoryid"];
 $division=$row["division_id"];
 $district=$row["district_id"];
 $upazilla=$row["upazila_id"];
 $logo=$row["logo"];

}
}


// Get Upazilla ......................................

$up_name="";
$sqlsem = "SELECT * FROM upazilas where id=$upazilla";
$resultse = $conn->query($sqlsem);

if ($resultse->num_rows > 0) {
   
    while($rowse = $resultse->fetch_assoc()) {
       	   
       $up_name=$rowse["name"];

    }
} 


// Get District ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,

$dis_name="";
$sqlsem = "SELECT * FROM districts where id=$district";
$resultse = $conn->query($sqlsem);

if ($resultse->num_rows > 0) {
   
    while($rowse = $resultse->fetch_assoc()) {
       	   
       $dis_name=$rowse["name"];

    }
}

$address="";
if($up_name!="" && $dis_name!="")
{
   $address=$up_name.",".$dis_name;
}

  ?>


<?php  //if($s_customer!=""){ 


$customer_name="All";

 $sqls = "SELECT * FROM expense_head where id=$s_customer";
    $results = $conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $customer_name=$rows["name"];
    
  }
} else {
 // echo "0 results";
}

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


  <div class="row">
    <div class="col-sm-2">
      <?php $logosrc="imageUpload/uploads/".$logo; if($logo=="") {echo "<img src='dist/img/global_logo.png' height='100px' width='100px' >"; } else { echo "<img src=$logosrc height='100px' width='100px' style='padding:10px; border-radius:20px;'>"; } ?>
    </div>
    <div class="col-sm-8" >
       <center><h3 style="  font-family: Lucida Console, Courier, monospace;"><?php echo $shopname ?></h3></center>
       <center><?php echo $address ?></center>
       <center><?php echo "Contact No : ".$mobileno ?></center>
       <center><h5 style="margin-top:5px; margin-bottom:10px;"><b><?php echo "Expense Summarry Report" ?></b><h5></span></center>
       <?php 
         if($s_dtfrom!="")
         {
          echo "<center><h5 style='margin-top:5px; margin-bottom:10px;'><b> Date From ".$s_dtfrom." To ".$s_dtto."</b><h5></span></center>";
         }
         else
         {}

       ?>
    </div>
    <div class="col-sm-2" >
      <?php  ?>
    </div>
  </div>


  <table id="" class="table" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th style = "display:none;" class="HideAfterDT">Customerid</th>
                    <!--<th>Customer</th>-->
                    <th>Branch</th>
                    <th>Total Expense</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

     $Previous_Balance=0;
     $total=0;


if($s_dtfrom==""){
  $sql = "SELECT branchid,sum(amount) as amount from expense group by branchid";
}
else
{
     $sql = "SELECT branchid,sum(amount) as amount from expense where  str_to_date(expense_date,'%Y-%m-%d')>='$s_dtfrom' and str_to_date(expense_date,'%Y-%m-%d')<='$s_dtto'   group by branchid";
}
//echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    
    
    $branchid=$row["branchid"];
    $Amount=$row["amount"];

$branch_name="Head Office";
$sqls = "SELECT * FROM branches where id=$branchid";
    $results = $master_conn->query($sqls);

if ($results->num_rows > 0) {
  // output data of each row
  while($rows = $results->fetch_assoc()) {
    $branch_name=$rows["name"];
    
  }
} else {
 // echo "0 results";
}

//$var = $Transaction_Date;
//$dt = str_replace('/', '-', $var);
//$dt=date('Y-m-d', strtotime($dt));

//if(($dt>=$s_dtfrom && $dt<=$s_dtto) or $s_dtfrom==""){


     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='branch_name'>".$branch_name."</td>"; 
     echo "<td class='total_price'>".$row["amount"]."</td>";
     echo "</tr>";
     
     $total=$total+$row["amount"];
//}


  }
} else {
  
}


                ?>
                
                
                <tr>
                    <td colspan='2'><b>Grand Total</b></td>
                    <td><?php echo $total; ?></td>
                    <td></td>
                </tr>
                  
                </table>


              </div> <!-- Report Div Close -->


              </div>
              <!-- /.card-body -->
            </div>


            </div>
        
        </div>
       
      </section>
        
        <?php // } ?>

    <!-- End Table -->



</div>
