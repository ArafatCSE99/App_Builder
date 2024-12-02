<?php
// Include database configuration
include '../connection.php'; // Update with your database configuration file

// Set content type to JSON

// Class for handling database operations
class DropdownDataFetcher {
    private $master_conn;

    // Constructor to initialize the MySQLi connection
    public function __construct($host, $username, $password, $database) {
        $this->master_conn = new mysqli($host, $username, $password, $database);

        // Check for connection errors
        if ($this->master_conn->connect_error) {
            die(json_encode(['error' => 'Database connection failed: ' . $this->master_conn->connect_error]));
        }
    }

    // Method to fetch dropdown data and return it as HTML <option> tags
    public function getDropdownOptions($table, $valueColumn, $optionColumn, $conditionField, $conditionValue) {
        // Prepare the SQL query
        $stmt = $this->master_conn->prepare("SELECT `$valueColumn` AS value, `$optionColumn` AS label FROM `$table` WHERE `$conditionField` = ?");
        if (!$stmt) {
            return ['error' => 'Query preparation failed: ' . $this->master_conn->error];
        }

        // Bind parameters and execute the query
        $stmt->bind_param('s', $conditionValue);
        $stmt->execute();
        $result = $stmt->get_result();

        // Build the HTML <option> tags
        $dropdown = "<option value='' hidden=''>-- Select --</option>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dropdown .= "<option value='{$row['value']}'>{$row['label']}</option>";
            }
        } else {
            $dropdown = "<option value=''>No options available</option>";
        }

        // Close the statement and return the HTML
        $stmt->close();
        return $dropdown;
    }

    // Destructor to close the connection
    public function __destruct() {
        $this->master_conn->close();
    }
}

// Handle the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $onchange_table = $_POST['onchange_table'] ?? '';
    $onchange_value_column = $_POST['onchange_value_column'] ?? '';
    $onchange_option_column = $_POST['onchange_option_column'] ?? '';
    $conditionField = $_POST['conditionField'] ?? '';
    $conditionValue = $_POST['conditionValue'] ?? '';

    // Validate inputs
    if (empty($onchange_table) || empty($onchange_value_column) || empty($onchange_option_column) || empty($conditionField) || empty($conditionValue)) {
        echo json_encode(['error' => 'Invalid input parameters.']);
        exit;
    }

    // Instantiate the class and fetch data
    try {
        $fetcher = new DropdownDataFetcher($master_servername, $master_username, $master_password, $master_dbname);
        $result = $fetcher->getDropdownOptions($onchange_table, $onchange_value_column, $onchange_option_column, $conditionField, $conditionValue);
        echo $result; // Return HTML as a JSON response
    } catch (Exception $e) {
        echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>
