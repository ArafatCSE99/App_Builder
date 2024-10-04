<?php 

include "connection.php";

$name=$_POST["name"];
$company=$_POST["company"];
$mobileno=$_POST["mobileno"];
$email=$_POST["email"];
$password=$_POST["password"];
$repassword=$_POST["repassword"];

    $sql="INSERT INTO users(name,email,mobile_no,password,is_active)
    VALUES ('$name','$email','$mobileno','$password',0)";

    if ($master_conn->query($sql) === TRUE) {

      $userid=$master_conn-> insert_id;

      // insert Company Branch . . . . .
    $sqlc="INSERT INTO companies(user_id,name)
    VALUES ($userid,'$company')";

    if ($master_conn->query($sqlc) === TRUE) {
        $companyid=$master_conn-> insert_id;

        $sqlcb="INSERT INTO branches(user_id,company_id,name)
        VALUES ($userid,$companyid,'Head Office')";
        if ($master_conn->query($sqlcb) === TRUE) { }

        $sqlcb="INSERT INTO user_wise_modules(user_id,module_id,is_active)
        VALUES ($userid,2,1)";
        if ($master_conn->query($sqlcb) === TRUE) { }

        $sqlcb="INSERT INTO user_wise_modules(user_id,module_id,is_active)
        VALUES ($userid,3,1)";
        if ($master_conn->query($sqlcb) === TRUE) { }

    }

     
      //echo "<script> alert('Registration Successful ! ! !'); window.location.href='login.html'; </script>";
      $_SESSION["id"]=$companyid;
      $_SESSION["payment_type_id"]=101;
      echo "<script> window.location.href='https://shikkhafirst.com/sims/bkash.php?id=".$userid."&payment_type_id=101'; </script>";

    } else {
      echo "Error: " . $sql . "<br>" . $master_conn->error;
    }

?>