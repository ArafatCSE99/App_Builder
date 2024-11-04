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
        
        $footerSum = [];
        // Render rows based on rowCount or data count
        $numRows = !empty($data) ? count($data) : $rowCount;
        for ($i = 0; $i < $numRows; $i++) {
            $tableHtml .= '<tr>';
            
            foreach ($columns as $column) {
                $value = isset($data[$i][$column['name']]) ? $data[$i][$column['name']] : '';

                if(is_numeric($value))
                {
                    $columnName=$column['name'];
                    
                    if (isset($footerSum[$columnName])) {
                        $footerSum[$columnName]+=$value;
                    } else {
                        $footerSum[$columnName]=$value;
                    }

                }

               

                if ($column['type'] === 'dropdown') {
                    if(isset($column['onchangeTable']))
                    {
                        $tableHtml .= '<td>' . $this->createDropdown($column['table'], $column['valueField'], $column['optionField'], $column['name'], $value,$column['onchangeTable'],$column['onchangeField'],$column['onchangeSetField']) . '</td>';
                    }
                    else{
                        $tableHtml .= '<td>' . $this->createDropdown($column['table'], $column['valueField'], $column['optionField'], $column['name'], $value) . '</td>';
                    }
                
                } elseif (in_array($column['type'], ['textbox', 'number'])) {

                    if(!isset($column['changeRowField']))
                    {
                        $column['changeRowField']='';
                        $column['equation']='';
                    }

                    $changeRowField = $column['changeRowField'];
                    $equation = $column['equation'];

                    $tableHtml .= '<td><input type="' . htmlspecialchars($column['type']) . '" name="' . htmlspecialchars($column['name']) . '" class="form-control" value="' . htmlspecialchars($value) . '" onchange="CalculateTotal(this,\''.$changeRowField.'\',\''.$equation.'\')"></td>';
                
                } elseif ($column['displayColumn']=='true') {
                    $tableHtml .= '<td><input type="text" name="' . htmlspecialchars($column['name']) . '" class="form-control display-field" value="' . htmlspecialchars($value) . '" readonly></td>';
                }
                elseif ($column['displayColumn']=='false') {
                    $tableHtml .= '<td><input type="text" name="' . htmlspecialchars($column['name']) . '" class="form-control display-field" value="' . htmlspecialchars($value) . '" ></td>';
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
                    $columnName=$column['name'];
                    if (!isset($footerSum[$columnName])) {
                        $footerSum[$columnName]='';
                    }
                    $tableHtml .= '<td><input type="text" class="form-control sum" id="'.$column['name'].'Sum" value="'.$footerSum[$columnName].'" readonly></td>';
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

                if(!isset($field['changeRowField']))
                {
                    $field['changeRowField']='';
                    $field['equation']='';
                }

                $changeRowField = $field['changeRowField'];
                $equation = $field['equation'];

                $readonly="";
                if($field['displayColumn']=='true')
                {
                    $readonly="readonly";
                }
                $tableHtml .= '<div class="form-group">';
                $tableHtml .= '<label>' . htmlspecialchars($field['label']) . '</label>';
                $tableHtml .= '<input type="' . htmlspecialchars($field['type']) . '" name="' . htmlspecialchars($field['name']) . '" id="' . htmlspecialchars($field['name']) . '" class="form-control" value="' . htmlspecialchars($field['value'] ?? '') . '" onchange="CalculateTotalFooter(this,\''.$changeRowField.'\',\''.$equation.'\')" style="width:25%" '.$readonly.'>';
                $tableHtml .= '</div>';
            }
            $tableHtml .= '</div>';
        }
        $tableHtml .= '</div>';
        
        return $tableHtml;
    }

    private function createDropdown($table, $valueField, $optionField, $name, $selectedValue = null,$onchangeTable="",$onchangeField="",$onchangeSetField="") {
        $query = "SELECT $valueField, $optionField FROM $table";
        $result = mysqli_query($this->conn, $query);
        if($onchangeTable==""){
          $dropdownHtml = '<select name="' . htmlspecialchars($name) . '" class="form-control">';
        }
        else
        {
            $dropdownHtml = '<select name="' . htmlspecialchars($name) . '" class="form-control" onchange="GetValueById(this,\''.$onchangeTable.'\',\''.$onchangeField.'\',\''.$onchangeSetField.'\')">'; 
        }
        while ($row = mysqli_fetch_assoc($result)) {
            $isSelected = ($row[$valueField] == $selectedValue) ? ' selected' : '';
            $dropdownHtml .= '<option value="' . htmlspecialchars($row[$valueField]) . '"' . $isSelected . '>' . htmlspecialchars($row[$optionField]) . '</option>';
        }
        $dropdownHtml .= '</select>';
        return $dropdownHtml;
    }
}
?>
