<?php

include '../connection.php';

//header('Content-Type: application/json');

// Retrieve and sanitize input parameters
$table_name = $_POST['table'];
$field_name = $_POST['field'];
$condition_field = $_POST['conditionField'];
$condition_value = $_POST['conditionValue'];

/*
if (empty($table_name) || empty($field_name) || empty($condition_field) || empty($condition_value)) {
    echo json_encode(['error' => 'Missing required parameters']);
    exit;
}
*/

// Construct and execute the query safely
$sql = "SELECT $field_name AS value FROM $table_name WHERE $condition_field = ? LIMIT 1";
echo $sql;
$stmt = $master_conn->prepare($sql);
$stmt->bind_param("s", $condition_value);  // Bind parameter to prevent SQL injection

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['value' => $row['value']]);
    } else {
        echo json_encode(['error' => 'Record not found']);
    }
} else {
    echo json_encode(['error' => 'Query execution failed']);
}

$stmt->close();
$conn->close();
?>
