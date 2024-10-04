<?php 

include "../connection.php";


//session_start(); 

$userid=$_SESSION["userid"];
$id=$_POST["productid"];
$pay_month=0;
if(isset($_POST["pay_month"])){
$pay_month=$_POST["pay_month"];
}

// Get Product  .......
$sqlc = "SELECT a.*,b.percentage,b.isDiscountFormula FROM product a,category b where a.categoryid=b.id and a.userid=$userid and a.id=$id";
$resultc = $conn->query($sqlc);

if ($resultc->num_rows > 0) {
  // output data of each row
  while($rowc = $resultc->fetch_assoc()) {
    $proid=$rowc["id"];
    $procode=$rowc["code"];
    $pronm=$rowc["name"];
    $proself=$rowc["self"];
    $model=$rowc["model"];
    $batchno=0;//$rowc["batchno"];
    $msrp_prise=$rowc["msrp_price"];
    $percentage=$rowc["percentage"];
    $isDiscountFormula=$rowc["isDiscountFormula"];
    if($isDiscountFormula=="checked"){
        if($pay_month=="" || $pay_month==0 || $pay_month==3)
        {
            $insDisCharge=0;
            $insDisChargePer=0;
        }
        else if($pay_month==1)
        {
            $insDisChargePer=5;
            $insPer=(5/100)*$msrp_prise;
            $msrp_prise=$msrp_prise-$insPer;
            $insDisCharge=-$insPer;
        
        }
        else if($pay_month==2)
        {
            $insDisChargePer=3;
            $insPer=(3/100)*$msrp_prise;
            $msrp_prise=$msrp_prise-$insPer;
            $insDisCharge=-$insPer;
        }
        else if($pay_month==4)
        {
            $insDisChargePer=4;
            $insPer=(4/100)*$msrp_prise;
            $msrp_prise=$msrp_prise+$insPer;
            $insDisCharge=$insPer;
        }
        else if($pay_month>=5)
        {
            $insDisChargePer=8;  
            $insPer=(8/100)*$msrp_prise;
            $msrp_prise=$msrp_prise+$insPer;
            $insDisCharge=$insPer;
        }
        else
        {
           $insDisCharge=0; 
           $insDisChargePer=0;
        }
    }
    else
    {
        $insDisCharge=0;
        $insDisChargePer=0;
    }
    
    $insDisCharge=round($insDisCharge);
    $msrp_prise=round($msrp_prise);

    $return_arr[] = array("proid" => $proid,
    "procode" => $procode,
    "pronm" => $pronm,
    "proself" => $proself,
    "model" => $model,
    "batchno" => $batchno,
    "msrp_prise" =>$msrp_prise,
    "percentage" =>$percentage,
    "insDisCharge" =>$insDisCharge,
    "insDisChargePer" =>$insDisChargePer
    );

    

    
  }
} else {
 
}

echo json_encode($return_arr);


?>