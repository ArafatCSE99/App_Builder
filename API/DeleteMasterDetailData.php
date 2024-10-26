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

$master_conn->close();
?>
