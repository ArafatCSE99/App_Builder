<?php

class DynamicDetailClass {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function createDetailTable($columns, $data = [], $rowCount = 1, $sumColumns = [], $footer = false, $footerFields = []) {
        $tableHtml = '<table class="table table-bordered dynamic-table">';
        
        // Table Header
        $tableHtml .= '<thead><tr>';
        foreach ($columns as $column) {
            $tableHtml .= '<th>' . $column['header'] . '</th>';
        }
        $tableHtml .= '<th>Actions</th></tr></thead>';
        
        // Table Body with Dynamic Rows
        $tableHtml .= '<tbody>';
        for ($i = 0; $i < $rowCount; $i++) {
            $tableHtml .= '<tr>';
            foreach ($columns as $column) {
                // For calculation columns (e.g., amount = qty * price)
                if (isset($column['displayColumn'])) {
                    $tableHtml .= '<td><input type="text" name="' . $column['name'] . '" class="form-control display-field" readonly></td>';
                } else {
                    if ($column['type'] == 'dropdown') {
                        // Create a dropdown component
                        $tableHtml .= '<td>' . $this->createDropdown($column['table'], $column['valueField'], $column['optionField'], $column['name']) . '</td>';
                    } elseif ($column['type'] == 'textbox' || $column['type'] == 'number') {
                        $tableHtml .= '<td><input type="' . $column['type'] . '" name="' . $column['name'] . '" class="form-control ' . (isset($column['onchange']) ? 'calculate' : '') . '"></td>';
                    }
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
                $tableHtml .= '<label>' . $field['label'] . '</label>';
                $tableHtml .= '<input type="' . $field['type'] . '" name="' . $field['name'] . '" class="form-control">';
                $tableHtml .= '</div>';
            }
            $tableHtml .= '</div>';
        }

        return $tableHtml;
    }

    private function createDropdown($table, $valueField, $optionField, $name) {
        // Fetch data from the database to populate the dropdown
        $query = "SELECT $valueField, $optionField FROM $table";
        $result = mysqli_query($this->conn, $query);

        $dropdownHtml = '<select name="' . $name . '" class="form-control">';
        while ($row = mysqli_fetch_assoc($result)) {
            $dropdownHtml .= '<option value="' . $row[$valueField] . '">' . $row[$optionField] . '</option>';
        }
        $dropdownHtml .= '</select>';
        return $dropdownHtml;
    }
}


?>