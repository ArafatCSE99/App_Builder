<?php

$master_servername = "localhost";
$master_username = "root";
$master_password = "";
$master_dbname = "master_db";

// Create connection
$master_conn = new mysqli($master_servername, $master_username, $master_password, $master_dbname);
// Check connection
if ($master_conn->connect_error) {
    die("Connection failed: " . $master_conn->connect_error);
} 


// Connecto To Client DB .......

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_db_1";

session_start(); 
if(isset($_SESSION["userid"])){
    //echo $_SESSION["userid"];
    $dbname = "user_db_".$_SESSION["userid"];
    if($_SESSION["userid"]>1)
    {
        $dbname = "mkrojcjv_user_db_2";
    }
    if($_SESSION["userid"]==29)
    {
        $dbname = "mkrojcjv_user_db_3";
    }
}
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


?>