<?php

include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['table']) || !isset($data['columns']) || !isset($data['condition']) || !is_array($data['columns'])) {
        echo json_encode(["error" => "Invalid input."]);
        exit;
    }

    $table = $master_conn->real_escape_string($data['table']);
    $columns = $data['columns'];
    $condition = $data['condition']; // Example: ["id" => 1]

    $set_clause = implode(", ", array_map(function($key, $value) use ($master_conn) {
        return "`" . $master_conn->real_escape_string($key) . "` = '" . $master_conn->real_escape_string($value) . "'";
    }, array_keys($columns), array_values($columns)));

    $where_clause = implode(" AND ", array_map(function($key, $value) use ($master_conn) {
        return "`" . $master_conn->real_escape_string($key) . "` = '" . $master_conn->real_escape_string($value) . "'";
    }, array_keys($condition), array_values($condition)));

    $sql = "UPDATE `$table` SET $set_clause WHERE $where_clause";

    if ($master_conn->query($sql) === TRUE) {
        echo json_encode(["message" => "Data updated successfully."]);
    } else {
        echo json_encode(["error" => "Error: " . $master_conn->error]);
    }
} else {
    echo json_encode(["error" => "Invalid request method."]);
}

$master_conn->close();
?>
