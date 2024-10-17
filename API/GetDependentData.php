<?php

include '../connection.php';

$thisId=$_POST["thisId"];
$thisValue = $_POST["thisValue"];
$onchange_table=$_POST["onchange_table"];

$query = "SELECT id,name FROM {$onchange_table} where {$thisId} = {$thisValue}";
        $result = $master_conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dropdown .= "<option value='{$row["id"]}' >{$row["name"]}</option>";
            }
        }

        echo $dropdown;
?>