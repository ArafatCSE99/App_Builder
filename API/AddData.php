<?php

include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['table']) || !isset($data['columns']) || !is_array($data['columns'])) {
        echo json_encode(["error" => "Invalid input."]);
        exit;
    }

    $table = $master_conn->real_escape_string($data['table']);
    $columns = $data['columns'];

    $keys = implode(", ", array_keys($columns));
    $values = implode(", ", array_map(function($value) use ($master_conn) {
        return "'" . $master_conn->real_escape_string($value) . "'";
    }, array_values($columns)));

    $sql = "INSERT INTO `$table` ($keys) VALUES ($values)";

    if ($master_conn->query($sql) === TRUE) {
        //echo json_encode(["message" => "Data inserted successfully."]);
        echo json_encode(["message" => $sql]);
    } else {
        echo json_encode(["error" => "Error: " . $master_conn->error]);
    }
} else {
    echo json_encode(["error" => "Invalid request method."]);
}

$master_conn->close();
?>
