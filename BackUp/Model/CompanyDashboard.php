<?php 


$username="";

$sql = "SELECT * FROM user where id=$companyid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $usernameD=$row["name"];
  }
} else {
  
}

// Get Purchase .........................

$sql = "SELECT * FROM purchase_master where userid=$companyid";
$result = $conn->query($sql);
$total_purchase=$result->num_rows;

$sql = "SELECT * FROM sales_master where userid=$companyid";
$result = $conn->query($sql);
$total_sales=$result->num_rows;

$sql = "SELECT * FROM customer where userid=$companyid";
$result = $conn->query($sql);
$total_customer=$result->num_rows;


$sql = "SELECT * FROM product where userid=$companyid";
$result = $conn->query($sql);
$total_product=$result->num_rows;

date_default_timezone_set("Asia/dhaka");
$today=date("Y-m-d");

$sql = "SELECT sum(total_price) as today_sales FROM sales_master where userid=$companyid and sales_date='$today'";
$result = $conn->query($sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
   $today_sales=$row["today_sales"];
  }
} else {
  $today_sales=0;
}


$sql = "SELECT sum(total_price) as total_sales FROM sales_master where userid=$companyid";
$result = $conn->query($sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
   $total_salestk=$row["total_sales"];
  }
} else {
  $total_salestk=0;
}


$sql = "SELECT sum(due) as total_due FROM sales_master where userid=$companyid";
$result = $conn->query($sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
   $total_duetk=$row["total_due"];
  }
} else {
  $total_duetk=0;
}


$sql = "SELECT sum(amount) as total_pay FROM sales_payment where salesid in(select id from sales_master where userid=$companyid)";
$result = $conn->query($sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
   $total_paytk=$row["total_pay"];
  }
} else {
  $total_paytk=0;
}

$total_duetk=$total_duetk-$total_paytk;


$sql = "SELECT sum(total_price) as total_purchasetk FROM purchase_master where userid=$companyid";
$result = $conn->query($sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
   $total_purchasetk=$row["total_purchasetk"];
  }
} else {
  $total_purchasetk=0;
}


$sql = "SELECT sum(purchase_price) as total_purchasetk FROM price_manager where userid=$companyid";
$result = $conn->query($sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
   $total_purchasetk=$row["total_purchasetk"];
  }
} else {
  $total_purchasetk=0;
}

echo "<h4>Dashboard - ".$usernameD."</h4>";
echo "<hr>";

?>



 <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $total_product-$total_sales ?></h3>

                <h4>Total Products</h4>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" onclick="getcontent('product')" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $total_sales ?><sup style="font-size: 20px"><sup style="font-size: 20px"></sup></h3>

                <h4>Total Sales</h4>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" onclick="getcontent('sales')" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $total_customer ?></h3>
                <h4>Total Customer</h4>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" onclick="getcontent('customer')" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $total_product ?></h3>

                <h4>Total Purchase</h4>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" onclick="getcontent('purchase')" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->


 <!-- Main content -->
 <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $today_sales ?> Tk/=</h3>

                <h4>Sales Today</h4>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" onclick="getcontent('sales')" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $total_salestk ?> Tk/=<sup style="font-size: 20px"><sup style="font-size: 20px"></sup></h3>

                <h4>Total Sales</h4>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" onclick="getcontent('sales')" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $total_duetk ?> Tk/=</h3>
                <h4>Total Due</h4>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" onclick="getcontent('sales')" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $total_purchasetk ?> Tk/=</h3>

                <h4>Total Purchase</h4>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" onclick="getcontent('purchase')" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->