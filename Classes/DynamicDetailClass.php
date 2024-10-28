<?php

class DynamicDetailClass {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function getDetailData($detailTable, $columns, $masterIdField, $masterIdValue) {
        $fields = array_map(fn($column) => $column['name'], $columns);
        $fieldList = implode(', ', $fields);

        $query = "SELECT $fieldList FROM $detailTable WHERE $masterIdField = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $masterIdValue);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();
        return $data;
    }

    public function createDetailTable($columns, $data = [], $rowCount = 1, $sumColumns = [], $footer = false, $footerFields = []) {
        $tableHtml = '<div id="detailSection"><table class="table table-bordered dynamic-table">';

        // Table Header
        $tableHtml .= '<thead><tr>';
        foreach ($columns as $column) {
            $tableHtml .= '<th>' . htmlspecialchars($column['header']) . '</th>';
        }
        $tableHtml .= '<th>Actions</th></tr></thead>';

        // Table Body with Dynamic Rows
        $tableHtml .= '<tbody>';
        
        // Render rows based on rowCount or data count
        $numRows = !empty($data) ? count($data) : $rowCount;
        for ($i = 0; $i < $numRows; $i++) {
            $tableHtml .= '<tr>';
            
            foreach ($columns as $column) {
                $value = isset($data[$i][$column['name']]) ? $data[$i][$column['name']] : '';

                if ($column['type'] === 'dropdown') {
                    $tableHtml .= '<td>' . $this->createDropdown($column['table'], $column['valueField'], $column['optionField'], $column['name'], $value) . '</td>';
                
                } elseif (in_array($column['type'], ['textbox', 'number'])) {
                    $tableHtml .= '<td><input type="' . htmlspecialchars($column['type']) . '" name="' . htmlspecialchars($column['name']) . '" class="form-control" value="' . htmlspecialchars($value) . '"></td>';
                
                } elseif (isset($column['displayColumn'])) {
                    $tableHtml .= '<td><input type="text" name="' . htmlspecialchars($column['name']) . '" class="form-control display-field" value="' . htmlspecialchars($value) . '" readonly></td>';
                }
            }

            // Action buttons for adding/removing rows
            $tableHtml .= '<td><button type="button" class="btn btn-success add-row">+</button>';
            $tableHtml .= '<button type="button" class="btn btn-danger delete-row">-</button></td>';
            $tableHtml .= '</tr>';
        }
        $tableHtml .= '</tbody>';

        // Table Footer for Sum Columns
        if ($footer) {
            $tableHtml .= '<tfoot><tr>';
            foreach ($columns as $column) {
                if (in_array($column['name'], $sumColumns)) {
                    $tableHtml .= '<td><input type="text" class="form-control sum" readonly></td>';
                } else {
                    $tableHtml .= '<td></td>';
                }
            }
            $tableHtml .= '<td></td></tr></tfoot>';
        }

        $tableHtml .= '</table>';

        // Adding footer fields like Total, Paid, and Due
        if (!empty($footerFields)) {
            $tableHtml .= '<div class="footer-fields">';
            foreach ($footerFields as $field) {
                $tableHtml .= '<div class="form-group">';
                $tableHtml .= '<label>' . htmlspecialchars($field['label']) . '</label>';
                $tableHtml .= '<input type="' . htmlspecialchars($field['type']) . '" name="' . htmlspecialchars($field['name']) . '" class="form-control" value="' . htmlspecialchars($field['value'] ?? '') . '">';
                $tableHtml .= '</div>';
            }
            $tableHtml .= '</div>';
        }
        $tableHtml .= '</div>';
        
        return $tableHtml;
    }

    private function createDropdown($table, $valueField, $optionField, $name, $selectedValue = null) {
        $query = "SELECT $valueField, $optionField FROM $table";
        $result = mysqli_query($this->conn, $query);

        $dropdownHtml = '<select name="' . htmlspecialchars($name) . '" class="form-control">';
        while ($row = mysqli_fetch_assoc($result)) {
            $isSelected = ($row[$valueField] == $selectedValue) ? ' selected' : '';
            $dropdownHtml .= '<option value="' . htmlspecialchars($row[$valueField]) . '"' . $isSelected . '>' . htmlspecialchars($row[$optionField]) . '</option>';
        }
        $dropdownHtml .= '</select>';
        return $dropdownHtml;
    }
}
?>
