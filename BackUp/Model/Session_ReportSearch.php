<?php

session_start(); 

$_SESSION["s_dtfrom"]=$_POST["s_dtfrom"];
$_SESSION["s_dtto"]=$_POST["s_dtto"];
$_SESSION["s_ctg"]=$_POST["s_ctg"];
$_SESSION["s_model"]=$_POST["s_model"];
$_SESSION["s_code"]=$_POST["s_code"];
$_SESSION["s_name"]=$_POST["s_name"];
$_SESSION["s_customer"]=$_POST["s_customer"];

?>