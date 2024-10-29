<?php
include '../connection.php';


$table_name = isset($_POST['table']) ? $conn->real_escape_string($_POST['table']) : '';

$page = isset($_POST['page']) && is_numeric($_POST['page']) ? intval($_POST['page']) : 1;
$limit = isset($_POST['limit']) && is_numeric($_POST['limit']) ? intval($_POST['limit']) : 10;

if (empty($table_name)) {
    echo json_encode(['error' => 'Table name is required']);
    exit;
}

$offset = ($page - 1) * $limit;

$total_sql = "SELECT COUNT(*) AS total FROM $table_name";
$total_result = $master_conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_records = intval($total_row['total']);

$total_pages = ceil($total_records / $limit);

$sql = "SELECT * FROM $table_name LIMIT $limit OFFSET $offset";

$result = $master_conn->query($sql);

if ($result && $result->num_rows > 0) {
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode([
        'data' => $data,
        'total_pages' => $total_pages,
        'current_page' => $page,
        'total_records' => $total_records
    ]);
} else {
    echo json_encode(['error' => 'No data found or invalid table name']);
}
$conn->close();
?>