
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
            <h1>Sales Detail Report  
            
           
            </h1> 

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sales Detail Report</li>
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

      <div class = "form-group" style='display:none;'>
            <label class = "sr-only" for = "">Customer</label>
            
  <select class="form-control s_parameter" id="s_customer">
    <?php 

$ctg_id=0;
$ctg_name="";
$sqlsem = "SELECT * FROM customer where userid=$userid and companyid=$companyid";
$resultse = $conn->query($sqlsem);
echo "<option value='' hidden=''>All Customer</option>";
if ($resultse->num_rows > 0) {
   
    while($rowse = $resultse->fetch_assoc()) {
       $ctg_id=$rowse["id"];
       $ctg_name=$rowse["name"];
       echo "<option value='$ctg_id'>".$ctg_name."</option>";

    }
} 

    ?>
  </select>

         </div>
         &nbsp;&nbsp;

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
         <div class = "form-group">
            <label class = "sr-only" for = "dtfrom">Category</label>
            
  <select class="form-control" id="s_ctg">
    <?php 

$ctg_id=0;
$ctg_name="";
$sqlsem = "SELECT * FROM category where userid=$userid and companyid=$companyid";
$resultse = $conn->query($sqlsem);
echo "<option value='' hidden=''>All Category</option>";
if ($resultse->num_rows > 0) {
   
    while($rowse = $resultse->fetch_assoc()) {
       $ctg_id=$rowse["id"];
       $ctg_name=$rowse["name"];
       echo "<option value='$ctg_id'>".$ctg_name."</option>";

    }
} 

    ?>
  </select>

         </div>
         &nbsp;&nbsp;
          <div class = "form-group"  id='customerDiv'>
            <label class = "sr-only" for = "">Model</label>
            
  <select class="form-control s_parameter" id="s_model">
    <?php 

$ctg_id=0;
$ctg_name="";
$sqlsem = "SELECT * FROM product where userid=$userid and companyid=$companyid";
$resultse = $conn->query($sqlsem);
echo "<option value='0' hidden=''>Select Model</option>";
if ($resultse->num_rows > 0) {
   
    while($rowse = $resultse->fetch_assoc()) {
       $ctg_id=$rowse["id"];
       $ctg_name=$rowse["name"];
       echo "<option value='$ctg_id'>".$ctg_name."</option>";

    }
} 

    ?>
  </select>

         </div>
          &nbsp;&nbsp;
          <div class = "form-group" style="display:none;">
            <label class = "sr-only" for = "dtfrom">code</label>
            <input type = "text" class = "form-control" id = "s_code" placeholder='Code'  style='width:150px;'>
          </div>
          &nbsp;&nbsp;
          <div class = "form-group"  style="display:none;">
            <label class = "sr-only" for = "dtfrom">Name</label>
            <input type = "text" class = "form-control" id = "s_name" placeholder='Name'>
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

$sql = "SELECT * FROM basic_info where userid=$userid and companyid=$companyid";

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
    <div class="col-sm-1">
    <?php $logosrc="imageUpload/uploads/".$logo; if($logo=="") {echo "<img src='dist/img/global_logo.png' height='80px' width='80px' >"; } else { echo "<img src=$logosrc height='80px' width='80px' style='padding:10px; border-radius:20px;'>"; } ?>    </div>
    <div class="col-sm-9" style="padding-left:20px;">
       <h3 style="  font-family: Lucida Console, Courier, monospace;"><?php echo $shopname ?></h3>
       <?php echo $address ?>
       <?php echo "Contact No : ".$mobileno ?>
       <h5 style="margin-top:5px; margin-bottom:10px;"><b><?php echo "Sales Detail Report" ?></b><h5></span>
       <?php 
         if($s_dtfrom!="")
         {
          echo "<h5 style='margin-top:5px; margin-bottom:10px;'><b>Date From ".$s_dtfrom." To ".$s_dtto."</b><h5></span>";
         }
       ?>
      
    </div>
    <div class="col-sm-2" >
      <?php  ?>
    </div>
  </div>

                <table id="" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th style='width:100px;'>Date</th>
                   
                    <th>Model</th>
                    <th>Category</th>
                    
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Discount</th>
                    <th>Total Price</th>
                   
                    
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

     $Total_Qty=0;
     $Total_Price=0;
     $Total_Discount=0;
     $Total_Percentage=0;

$sql = "SELECT a.id,a.name,a.image,a.categoryid,a.code,a.model,b.quantity,b.unitprice,b.discount,b.total_price,c.sales_date FROM product a,sales_detail b,sales_master c where a.id=b.productid and b.salesid=c.id and a.userid=$userid and c.companyid=$companyid and c.branchid=$branchid and (a.categoryid='$s_ctg' or '$s_ctg'='') and (a.id='$s_model' or '$s_model'='') and (a.code='$s_code' or '$s_code'='') and (a.name='$s_name' or '$s_name'='')";
//echo $sql;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    
    $id=$row["id"];
    $name=$row["name"];
    if($row["image"]!="")
    {
      $imageurl="imageUpload/uploads/".$row["image"];

    }
    else{
      $imageurl="dist/img/global_logo.png";
    }
    $categoryid=$row["categoryid"];

    $categoryname="";

$sqlc = "SELECT * FROM category where id=$categoryid";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $categoryname=$rowc["name"];
  }
} else {
 
}

$var = $row['sales_date'];
$dt = str_replace('/', '-', $var);
$dt=date('Y-m-d', strtotime($dt));

if(($dt>=$s_dtfrom && $dt<=$s_dtto) or $s_dtfrom==""){
    
    $slno++;
    
    $discount_percent=0;
    if($row["discount"]>0)
    {
        $discount_percent=(($row["discount"]*100)/($row["unitprice"]*$row['quantity']));
        
        $Total_Discount=$Total_Discount+$row["discount"];
        $Total_Percentage=$Total_Percentage+ $discount_percent;
    }

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='total_price'>".$row['sales_date']."</td>"; 
    // echo "<td class='code'>".$row['code']."</td>"; 
     echo "<td class='name'>".$name."</td>"; 
     
     echo "<td class='category'>".$categoryname."</td>"; 
     //echo "<td class='model'>".$row['model']."</td>"; 

     echo "<td class='quantity'>".$row['quantity']."</td>"; 
     echo "<td class='unitprice'>".$row['unitprice']."</td>"; 
     echo "<td class='discount'>".$row['discount']." (".$discount_percent."%)</td>"; 
     echo "<td class='total_price'>".$row['total_price']."</td>"; 
     
    
     echo "</tr>";

     $Total_Qty=$Total_Qty+$row['quantity'];
     $Total_Price=$Total_Price+$row['total_price'];

}

  }
} else {
  
}

$td=($Total_Percentage/$slno);

echo "<tr>";

echo "<td class='' colspan='4'><b>Grand Total</b></td>";
     echo "<td class=''><b>".$Total_Qty."</b></td>";
     echo "<td></td>";
     echo "<td>".$Total_Discount." (".round($td,2)."%)</td>";
     echo "<td class=''><b>".$Total_Price."</b></td>";
echo "</tr>";
                ?>
                  
               </tbody> </table>


              </div> <!-- Report Div Close -->


              </div>
              <!-- /.card-body -->
            </div>


            </div>
        
        </div>
       
      </section>
        

    <!-- End Table -->



</div>
