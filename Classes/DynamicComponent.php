<?php

class DynamicComponent
{
    private $conn;

    // Constructor to receive database connection
    public function __construct($master_conn)
    {
        $this->conn = $master_conn;
    }

    // Method to create form elements based on the input type
    public function createComponent($label, $value, $input_type, $class,$column_name, $tablename = '', $value_column = '', $option_column = '')
    {
        $html = '';
        
        switch ($input_type) {
            case 'textbox':
                $html .= $this->createTextbox($label, $value, $class,$column_name);
                break;

            case 'textarea':
                $html .= $this->createTextarea($label, $value, $class,$column_name);
                break;

            case 'dropdown':
                $html .= $this->createDropdown($label, $value, $class, $tablename, $value_column, $option_column,$column_name);
                break;

            default:
                $html .= 'Invalid input type.';
                break;
        }

        return $html;
    }

    // Method to create a textbox
    private function createTextbox($label, $value, $class,$column_name)
    {
        return "
            <div class='{$class}'>
                <label>{$label}</label>
                <input type='text' name='{$label}' id='{$column_name}' value='{$value}' placeholder='$label' style='width:25%' class='form-control'>
            </div>
        ";
    }

    // Method to create a textarea
    private function createTextarea($label, $value, $class,$column_name)
    {
        return "
            <div class='{$class}'>
                <label>{$label}</label>
                <textarea name='{$label}' id='{$column_name}' class='form-control' style='width:25%'>{$value}</textarea>
            </div>
        ";
    }

    // Method to create a dropdown
    private function createDropdown($label, $value, $class, $tablename, $value_column, $option_column,$column_name)
    {
        $dropdown = "
            <div class='{$class}'>
                <label>{$label}</label>
                <select name='{$label}' id='{$column_name}' class='form-control' style='width:25%'>
        ";

        // Fetch dropdown options from database
        $query = "SELECT {$value_column}, {$option_column} FROM {$tablename}";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $selected = ($row[$value_column] == $value) ? 'selected' : '';
                $dropdown .= "<option value='{$row[$value_column]}' {$selected}>{$row[$option_column]}</option>";
            }
        }

        $dropdown .= "</select></div>";

        return $dropdown;
    }
}

?>

