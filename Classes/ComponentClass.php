<?php

class TableComponent {

    public function GetTable($master_conn, $tableName, $columns) {

        $columnNames = array_keys($columns);
        $displayNames = array_values($columns);

        $sql = "SELECT " . implode(", ", $columnNames) . " FROM $tableName";
        $result = $master_conn->query($sql);

        if (!$result) {
            die("Error: " . $master_conn->error);
        }

        $tableHtml = '<table class="table table-bordered table-striped">';
        $tableHtml .= '<thead><tr>';

        foreach ($displayNames as $displayName) {
            $tableHtml .= "<th>$displayName</th>";
        }
        $tableHtml .= '</tr></thead><tbody>';

        while ($row = $result->fetch_assoc()) {
            $tableHtml .= '<tr>';
            foreach ($columnNames as $column) {
                $tableHtml .= '<td>' . htmlspecialchars($row[$column]) . '</td>';
            }
            $tableHtml .= '</tr>';
        }

        $tableHtml .= '</tbody></table>';

        return $tableHtml;
    }
}


?>
