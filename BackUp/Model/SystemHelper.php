<?php

class Inventory {
 
function getDashboardInfo($userid,$companyid,$branchid,$conn,$type,$date)
{ 
    
    //session_start(); 
    if($_SESSION["DType"]=="Company")
    {
        $branchid=0;
    }

if($type=="category")
{
    $sql = "SELECT id FROM category where userid=$userid and companyid=$companyid";
    $result = $conn->query($sql);
    $data=$result->num_rows;
}
if($type=="product")
{
    $sql = "SELECT id FROM product where userid=$userid and companyid=$companyid";
    $result = $conn->query($sql);
    $data=$result->num_rows;
}
if($type=="customer")
{
    $sql = "SELECT id FROM customer where userid=$userid and companyid=$companyid and (branchid=$branchid or $branchid=0)";
    $result = $conn->query($sql);
    $data=$result->num_rows;
}
if($type=="supplier")
{
    $sql = "SELECT id FROM supplier where userid=$userid and companyid=$companyid and (branchid=$branchid or $branchid=0)";
    $result = $conn->query($sql);
    $data=$result->num_rows;
}

if($type=="RetailSale" || $type=="WholeSale" || $type=="RetailSaleWarehouse" || $type=="WholeSaleWarehouse"  )
{

    $mode=$type=="RetailSale"?1:2;
    $from=1;
    if($type=="RetailSaleWarehouse" || $type=="WholeSaleWarehouse" )
    {
        $from=2;
    }

$sql = "SELECT sum(b.quantity) as datas FROM sales_master a, sales_detail b where a.id=b.salesid and sales_mode=$mode and sales_from=$from and a.userid=$userid and a.companyid=$companyid and (a.branchid=$branchid or $branchid=0) and str_to_date(sales_date,'%Y-%m-%d')>='$date'";
$result = $conn->query($sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
   $data=$row["datas"];
  }
} else {
  $data=0;
}

}
if($type=="Purchase")
{
$sql = "SELECT sum(b.quantity) as datas FROM purchase_master a, purchase_detail b where a.id=b.purchaseid and a.userid=$userid and a.companyid=$companyid and str_to_date(purchase_date,'%Y-%m-%d')>='$date'";
$result = $conn->query($sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
   $data=$row["datas"];
  }
} else {
  $data=0;
}

}
if($type=="StockTransfer")
{

$sql = "SELECT sum(initial_purchase) as datas FROM  stock_branch where userid=$userid and companyid=$companyid and (branchid=$branchid or $branchid=0) and str_to_date(created_at,'%Y-%m-%d')>='$date'";
$result = $conn->query($sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
   $data=$row["datas"];
  }
} else {
  $data=0;
}


}

if($type=="StockBranch")
{

$sql = "SELECT sum(current_stock) as datas FROM  stock_branch where userid=$userid and companyid=$companyid and (branchid=$branchid or $branchid=0)";
$result = $conn->query($sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
   $data=$row["datas"];
  }
} else {
  $data=0;
}


}

if($type=="StockWarehouse")
{

$sql = "SELECT sum(current_stock) as datas FROM  stock_warehouse where userid=$userid and companyid=$companyid ";
$result = $conn->query($sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
   $data=$row["datas"];
  }
} else {
  $data=0;
}


}

$data=$data==""?0:$data;
$data=$data<0?0:$data;
return $data;

} // Function End 





function getDashboardInfoAccounts($userid,$companyid,$branchid,$conn,$type,$date)
{ 
  if($type=="RetailSale" || $type=="WholeSale" || $type=="RetailSaleWarehouse" || $type=="WholeSaleWarehouse"  )
  {
  
      $mode=$type=="RetailSale"?1:2;
      $from=1;
      if($type=="RetailSaleWarehouse" || $type=="WholeSaleWarehouse" )
      {
          $from=2;
      }
  
  $sql = "SELECT sum(b.total_price) as datas FROM sales_master a, sales_detail b where a.id=b.salesid and sales_mode=$mode and sales_from=$from and a.userid=$userid and a.companyid=$companyid and a.branchid=$branchid and str_to_date(sales_date,'%Y-%m-%d')>='$date'";
  $result = $conn->query($sql);
  
  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
     $data=$row["datas"];
    }
  } else {
    $data=0;
  }
  
  }


if($type=="TotalSale")
{
$sql = "SELECT sum(b.total_price) as datas FROM sales_master a, sales_detail b where a.id=b.salesid and a.userid=$userid and a.companyid=$companyid and a.branchid=$branchid and str_to_date(sales_date,'%Y-%m-%d')>='$date'";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
   $data=$row["datas"];
  }
} else {
  $data=0;
}

}


if($type=="TotalCash")
{
$sql = "SELECT sum(a.paid) as datas FROM sales_master a, sales_detail b where a.id=b.salesid and a.userid=$userid and a.companyid=$companyid and a.branchid=$branchid and str_to_date(sales_date,'%Y-%m-%d')>='$date'";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
   $data=$row["datas"];
  }
} else {
  $data=0;
}

}


if($type=="TotalDue")
{
$sql = "SELECT sum(a.due) as datas FROM sales_master a, sales_detail b where a.id=b.salesid and a.userid=$userid and a.companyid=$companyid and a.branchid=$branchid and str_to_date(sales_date,'%Y-%m-%d')>='$date'";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
   $data=$row["datas"];
  }
} else {
  $data=0;
}

}


if($type=="Installment")
{
$sql = "SELECT sum(amount) as datas FROM sales_payment where salesid in(Select id from sales_master where userid=$userid and companyid=$companyid and branchid=$branchid)  and str_to_date(payment_date,'%Y-%m-%d')>='$date'";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
   $data=$row["datas"];
  }
} else {
  $data=0;
}

}


if($type=="Purchase")
{
$sql = "SELECT sum(b.total_price) as datas FROM purchase_master a, purchase_detail b where a.id=b.purchaseid and a.userid=$userid and a.companyid=$companyid and a.branchid=$branchid and str_to_date(purchase_date,'%Y-%m-%d')>='$date'";
$result = $conn->query($sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
   $data=$row["datas"];
  }
} else {
  $data=0;
}

}


if($type=="StockReceived")
{
$sql = "SELECT sum(b.total_price) as datas FROM stock_transfer_master a, stock_transfer_detail b where a.id=b.stockid and a.userid=$userid and a.companyid=$companyid and a.branchid=$branchid and str_to_date(sales_date,'%Y-%m-%d')>='$date'";
$result = $conn->query($sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
   $data=$row["datas"];
  }
} else {
  $data=0;
}

}



if($type=="BranchPayment")
{
$sql = "SELECT sum(amount) as datas FROM branch_payment where   branchid=$branchid and str_to_date(payment_date,'%Y-%m-%d')>='$date'";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
   $data=$row["datas"];
  }
} else {
  $data=0;
}

}



if($type=="StockValue")
{
$sql = "SELECT sum(total_price) as datas FROM purchase_detail where  purchaseid in (select id from purchase_master where userid=$userid and companyid=$companyid and branchid=$branchid and str_to_date(purchase_date,'%Y-%m-%d')>='$date' ) and 
purchaseid in (
Select purchaseid from stock_warehouse where current_stock>0
union 
Select purchaseid from stock_branch where current_stock>0
)";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
   $data=$row["datas"];
  }
} else {
  $data=0;
}

}


if($type=="TotalExpense")
{
$sql = "SELECT sum(amount) as datas FROM expense where userid=$userid and companyid=$companyid and branchid=$branchid and str_to_date(expense_date,'%Y-%m-%d')>='$date'";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
   $data=$row["datas"];
  }
} else {
  $data=0;
}

}


if($type=="TotalCashProfit" || $Type=="TotalDueProfit")
{
  
$data=0;    
$sql = "SELECT sum(a.total_cash_profit) as cash_profit,sum(a.total_due_profit) as due_profit FROM sales_master a, sales_detail b where a.id=b.salesid and a.userid=$userid and a.companyid=$companyid and a.branchid=$branchid and str_to_date(sales_date,'%Y-%m-%d')>='$date'";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
      
   if($type=="TotalCashProfit"){
     $data=$data+$row["cash_profit"];
   }
   else
   {
      $data=$data+$row["due_profit"];
   }
   
  }
} else {
  $data=0;
}

}


$data=$data==""?0:$data;
return round($data,2);



}


}

