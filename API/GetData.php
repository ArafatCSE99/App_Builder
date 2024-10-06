<?php
// Include the database connection
include '../connection.php';

// Get the table name from the request (you can pass it as a POST parameter)
$table_name = isset($_POST['table']) ? $conn->real_escape_string($_POST['table']) : '';

// Get the page and limit from the request (defaults to page 1 and 10 records per page)
$page = isset($_POST['page']) && is_numeric($_POST['page']) ? intval($_POST['page']) : 1;
$limit = isset($_POST['limit']) && is_numeric($_POST['limit']) ? intval($_POST['limit']) : 10;

if (empty($table_name)) {
    // Return an error if the table name is not provided
    echo json_encode(['error' => 'Table name is required']);
    exit;
}

// Calculate the offset for pagination
$offset = ($page - 1) * $limit;

// First, get the total number of records in the table
$total_sql = "SELECT COUNT(*) AS total FROM $table_name";
$total_result = $master_conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_records = intval($total_row['total']);

// Calculate the total number of pages
$total_pages = ceil($total_records / $limit);

// SQL query to select data from the provided table with limit and offset for pagination
$sql = "SELECT * FROM $table_name LIMIT $limit OFFSET $offset";

// Execute the query
$result = $master_conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Fetch all rows into an array
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Return the data along with the total number of pages
    echo json_encode([
        'data' => $data,
        'total_pages' => $total_pages,
        'current_page' => $page,
        'total_records' => $total_records
    ]);
} else {
    // Return an error if no data is found
    echo json_encode(['error' => 'No data found or invalid table name']);
}

// Close the database connection
$conn->close();
?>
