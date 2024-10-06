<?php 

$type=$_POST["type"];
$NewId=$_POST["NewId"];

session_start();

if($type=="Branch")
{
    $_SESSION["branchid"]=$NewId;
}

if($type=="Module")
{
    $_SESSION["moduleid"]=$NewId;
    if($NewId==2)
    {
        $_SESSION["module_short_name"]="INV";
    }
    if($NewId==3)
    {
        $_SESSION["module_short_name"]="ACC";
    }
    if($NewId==4)
    {
        $_SESSION["module_short_name"]="HRM";
    }
}

echo $_SESSION["branchid"];

?>