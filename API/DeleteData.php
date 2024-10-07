<?php

include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['table']) || !isset($data['id'])) {
        echo json_encode(["error" => "Invalid input."]);
        exit;
    }

    $table = $master_conn->real_escape_string($data['table']);
    $id = $master_conn->real_escape_string($data['id']);

    $sql = "DELETE FROM `$table` WHERE `id` = '$id'";

    if ($master_conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Record deleted successfully."]);
    } else {
        echo json_encode(["error" => "Error: " . $master_conn->error]);
    }
} else {
    echo json_encode(["error" => "Invalid request method."]);
}

$master_conn->close();
?>
