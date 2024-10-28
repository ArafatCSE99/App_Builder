<?php

include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate required input
    if (!isset($data['master_table']) || !isset($data['detail_table']) || !isset($data['foreign_key']) || !isset($data['id'])) {
        echo json_encode(["error" => "Invalid input."]);
        exit;
    }

    $masterTable = $master_conn->real_escape_string($data['master_table']);
    $detailTable = $master_conn->real_escape_string($data['detail_table']);
    $foreignKey = $master_conn->real_escape_string($data['foreign_key']);
    $masterId = $master_conn->real_escape_string($data['id']);

    // Start transaction
    $master_conn->begin_transaction();

    try {
        // Delete details related to the master
        $detailSql = "DELETE FROM `$detailTable` WHERE `$foreignKey` = '$masterId'";
        if (!$master_conn->query($detailSql)) {
            throw new Exception("Error deleting detail records: " . $master_conn->error);
        }

        // Delete master record
        $masterSql = "DELETE FROM `$masterTable` WHERE `id` = '$masterId'";
        if (!$master_conn->query($masterSql)) {
            throw new Exception("Error deleting master record: " . $master_conn->error);
        }

        // Commit transaction if both deletions succeed
        $master_conn->commit();
        echo json_encode(["message" => "Master and related detail records deleted successfully."]);
    } catch (Exception $e) {
        // Rollback transaction if an error occurs
        $master_conn->rollback();
        echo json_encode(["error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Invalid request method."]);
}

//$master_conn->close();
?>



<?php

//include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Check required data for master and details
    if (!isset($data['master']) || !isset($data['detail']) || !isset($data['master_table']) || !isset($data['detail_table']) || !isset($data['foreign_key'])) {
        echo json_encode(["error" => "Invalid input. Required data missing."]);
        exit;
    }

    $masterData = $data['master'];
    $detailsData = $data['detail'];
    $masterTable = $master_conn->real_escape_string($data['master_table']);
    $detailTable = $master_conn->real_escape_string($data['detail_table']);
    $foreignKey = $master_conn->real_escape_string($data['foreign_key']);

    // Insert into master table
    $masterKeys = implode(", ", array_keys($masterData));
    $masterValues = implode(", ", array_map(function($value) use ($master_conn) {
        return "'" . $master_conn->real_escape_string($value) . "'";
    }, array_values($masterData)));

    $masterSql = "INSERT INTO `$masterTable` ($masterKeys) VALUES ($masterValues)";

    if ($master_conn->query($masterSql) === TRUE) {
        // Get the inserted master ID
        $masterId = $master_conn->insert_id;

        // Insert each detail row in detail table
        $detailErrors = [];
        foreach ($detailsData as $detailRow) {
            // Add master foreign key to each detail row
            $detailRow[$foreignKey] = $masterId;

            // Prepare the detail row keys and values
            $detailKeys = implode(", ", array_keys($detailRow));
            $detailValues = implode(", ", array_map(function($value) use ($master_conn) {
                return "'" . $master_conn->real_escape_string($value) . "'";
            }, array_values($detailRow)));

            $detailSql = "INSERT INTO `$detailTable` ($detailKeys) VALUES ($detailValues)";

            if ($master_conn->query($detailSql) !== TRUE) {
                $detailErrors[] = "Error inserting detail row: " . $master_conn->error;
            }
        }

        // Final response
        if (empty($detailErrors)) {
            echo json_encode(["message" => "Master and detail data inserted successfully."]);
        } else {
            echo json_encode(["message" => "Master inserted, but some details failed.", "errors" => $detailErrors]);
        }
    } else {
        echo json_encode(["error" => "Error inserting master data: " . $master_conn->error]);
    }
} else {
    echo json_encode(["error" => "Invalid request method."]);
}

$master_conn->close();
?>
