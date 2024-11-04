<?php

include '../connection.php';

$thisId=$_POST["thisId"];
$thisValue = $_POST["thisValue"];
$onchange_table=$_POST["onchange_table"];
$onchange_value_column=$_POST["onchange_value_column"];
$onchange_option_column=$_POST["onchange_option_column"];

$dropdown="";
$query = "SELECT {$onchange_value_column},{$onchange_option_column} FROM {$onchange_table} where {$thisId} = {$thisValue}";
        $result = $master_conn->query($query);
        $label=ucfirst($onchange_table);
        $dropdown .= "<option hidden='0' value='0'>-- Select {$label} --</option>";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dropdown .= "<option value='{$row[$onchange_value_column]}' >{$row[$onchange_option_column]}</option>";
            }
        }

        echo $dropdown;
?>