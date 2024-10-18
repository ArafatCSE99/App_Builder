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
    public function createComponent($label='', $value='', $input_type='', $class='',$column_name='',$required='', $tablename = '', $value_column = '', $option_column = '',$onchnge_table='',$onchange_value_column = '', $onchange_option_column = '')
    {
        $html = '';
        
        switch ($input_type) {
            case 'textbox':
                $html .= $this->createTextbox($label, $value, $class,$column_name,$required);
                break;

            case 'textarea':
                $html .= $this->createTextarea($label, $value, $class,$column_name,$required);
                break;

            case 'dropdown':
                $html .= $this->createDropdown($label, $value, $class, $tablename, $value_column, $option_column,$column_name,$required,$onchnge_table,$onchange_value_column,$onchange_option_column);
                break;
            case 'image':
                $html .= $this->createImage();
                break;

            default:
                $html .= 'Invalid input type.';
                break;
        }

        return $html;
    }

    // Method to create a textbox
    private function createTextbox($label, $value, $class,$column_name,$required)
    {
        return "
            <div class='{$class}'>
                <label>{$label}</label>
                <input type='text' name='{$label}' id='{$column_name}' value='{$value}' placeholder='$label' style='width:25%' class='form-control' $required>
            </div>
        ";
    }

    // Method to create a textarea
    private function createTextarea($label, $value, $class,$column_name,$required)
    {
        return "
            <div class='{$class}'>
                <label>{$label}</label>
                <textarea name='{$label}' id='{$column_name}'  placeholder='$label' class='form-control' style='width:25%' $required>{$value}</textarea>
            </div>
        ";
    }

    // Method to create a dropdown
    private function createDropdown($label, $value, $class, $tablename, $value_column, $option_column,$column_name,$required,$onchnge_table,$onchange_value_column,$onchange_option_column)
    {
        if($onchnge_table==""){
        $dropdown = "
            <div class='{$class}'>
                <label>{$label}</label>
                <select name='{$label}' id='{$column_name}' class='form-control' style='width:25%' $required>
        ";
        }
        else{
            $dropdown = "
            <div class='{$class}'>
                <label>{$label}</label>
                <select name='{$label}' id='{$column_name}' onchange='getDepndentData(this,\"$onchnge_table\",\"$onchange_value_column\",\"$onchange_option_column\")' class='form-control' style='width:25%' $required>
        "; 
        }

        // Fetch dropdown options from database
        $query = "SELECT {$value_column}, {$option_column} FROM {$tablename}";
        $result = $this->conn->query($query);

        $dropdown .= "<option hidden='0' value='0'>-- Select {$label} --</option>";
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $selected = ($row[$value_column] == $value) ? 'selected' : '';
                $dropdown .= "<option value='{$row[$value_column]}' {$selected}>{$row[$option_column]}</option>";
            }
        }

        $dropdown .= "</select></div>";

        return $dropdown;
    }

    private function createImage(){
       
       $ImageHtml = '<form method="post" id="image-form" enctype="multipart/form-data" onSubmit="return false;">
        <div class="form-group">
            <input type="file" name="file" class="file">
            <div class="input-group my-3" style="width:350px;">
                <input type="text" style="width:20px; display:none;" class="form-control" disabled placeholder="Upload Product Image" id="image_name">
                <div class="input-group-append">
                    <button type="button" style="display:none;" class="browse btn btn-primary">Browse...</button>
                </div>
            </div>
        </div>

<div class="form-group">

            <img src="dist/img/global_logo.png" height="400px;" width="150px;" id="preview"  class="img-thumbnail preview">
    
</div>

        <div class="form-group">
            <input type="submit" name="submit" value="Upload" style="display:none;" class="btn btn-danger">
        </div>
</form>';

return $ImageHtml;

    }


}

?>

