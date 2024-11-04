<?php

class TableComponent {

    public function GetTable($master_conn, $tableName, $columns, $page = 1, $limit = 10, $search = '',$IsMasterDetail=false,$detailTable='',$foreignKey='',$form_id='') {

        $columnNames = array_keys($columns);
        $displayNames = array_values($columns);

        // Search condition (applies search across all columns)
        $searchCondition = '';
        if (!empty($search)) {
            $searchTerms = [];
            foreach ($columnNames as $column) {
                $searchTerms[] = "$column LIKE '%$search%'";
            }
            $searchCondition = "WHERE " . implode(' OR ', $searchTerms);
        }

        // Calculate offset for pagination
        $offset = ($page - 1) * $limit;

        // SQL query to get the paginated data with search
        $sql = "SELECT id, " . implode(", ", $columnNames) . " FROM $tableName $searchCondition ORDER BY id desc LIMIT $limit OFFSET $offset";
        //echo $sql;
        $result = $master_conn->query($sql);

        if (!$result) {
            die("Error: " . $master_conn->error);
        }

        // SQL query to get the total number of records (with search)
        $countSql = "SELECT COUNT(*) AS total FROM $tableName $searchCondition";
        $countResult = $master_conn->query($countSql);
        $totalRecords = $countResult->fetch_assoc()['total'];

        // Calculate total pages
        $totalPages = ceil($totalRecords / $limit);

$tableHtml = '<div class="search-container">
  <input type="text" class="search-input" placeholder="Search...">
  <button onclick="searchContent()" class="search-btn ">Search</button>
</div>
<br>';

        // Build the HTML table
        $tableHtml .= '<table id="example1" class="table table-bordered" style="width:100%">';
        $tableHtml .= '<thead class="thead-light"><tr>';

        // Add table headers
        $tableHtml .= "<th>Sl</th>";
        foreach ($displayNames as $displayName) {
            $tableHtml .= "<th>$displayName</th>";
        }
        $tableHtml .= '<th>Action</th></tr></thead><tbody>';

$columnTypes = [];
$columnTypeQuery = "SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS 
                    WHERE TABLE_NAME = '$tableName' AND TABLE_SCHEMA = DATABASE()";
$typeResult = $master_conn->query($columnTypeQuery);

if ($typeResult) {
    while ($typeRow = $typeResult->fetch_assoc()) {
        $columnTypes[$typeRow['COLUMN_NAME']] = $typeRow['DATA_TYPE'];
    }
}


        // Add table rows
        $slno=$offset;
        while ($row = $result->fetch_assoc()) {
            $slno++;
            $tableHtml .= '<tr>';
            $tableHtml .= '<td class="slno">' . $slno . '</td>';
            foreach ($columnNames as $column) {
                $columnType = $columnTypes[$column];
                if ($columnType == 'tinyint' && ($row[$column] == 1 || $row[$column] == 0)) {
                   
                    $checked = $row[$column] == 1 ? 'checked' : '';
                    $tableHtml .= '<td class="'.$column.'">
                                    <input type="checkbox" '.$checked.' onchange="updateValue(this,\''.$column.'\',\''.$tableName.'\',\''.$row["id"].'\')">
                                   </td>';
                }
                else if ($column=="image_name")
                {
                     $imageurl = "imageUpload/uploads/".$row[$column];
                     $tableHtml .= "<td class='image'><img src=$imageurl height='50px' width='50px'></td>"; 
                } 
                else {
                    $tableHtml .= '<td class="'.$column.'">' . htmlspecialchars($row[$column]) . '</td>';
                }
            }

            // Add action buttons
            $tableHtml .= "<td class='text-center py-0 align-middle' style='text-align:center;'>
                <div class='btn-group btn-group-sm'>";
                  

                  if($IsMasterDetail){
                    $tableHtml .= "<a onclick='updateMasterdetailData($row[id],$form_id,this)' class='btn btn-info'><i class='fas fa-edit'></i></a>
                    <a onclick=deleteMasterDetailData($row[id],'$tableName','$detailTable','$foreignKey',this) class='btn btn-danger'><i class='fas fa-trash'></i></a>";
                  }
                  else{
                  $tableHtml .= "<a onclick='updatedata($row[id],this)' class='btn btn-info'><i class='fas fa-edit'></i></a>
                  <a onclick=deletedata($row[id],'$tableName',this) class='btn btn-danger'><i class='fas fa-trash'></i></a>";
                  }

                  $tableHtml .=   "</div>
              </td>";
            $tableHtml .= '</tr>';
        }

        $tableHtml .= '</tbody></table>';

        // Add pagination controls
        $paginationHtml = '<br><div class="pagination">';

        // Previous button
        if ($page > 1) {
            $prevPage = $page - 1;
            $paginationHtml .= "<a href='#' class='page-link' 
                                 onclick=\"getcontent('$tableName','page=$prevPage&limit=$limit&search=$search')\">&laquo; Previous</a>";
        }

        // Page numbers
        for ($i = $page; $i <= $page + 9 && $i <= $totalPages; $i++) {
            $activeClass = ($i == $page) ? 'active' : '';
            $paginationHtml .= "<a href='#' class='page-link $activeClass' 
                                 onclick=\"getcontent('$tableName','page=$i&limit=$limit&search=$search')\">$i</a>";
        }

        // Next button
        if ($page < $totalPages) {
            $nextPage = $page + 1;
            $paginationHtml .= "<a href='#' class='page-link' 
                                 onclick=\"getcontent('$tableName','page=$nextPage&limit=$limit&search=$search')\">Next &raquo;</a>";
        }

        $paginationHtml .= '</div>';

        // Display total records and current page info
        $paginationHtml .= "<div>Total Records: $totalRecords | Page $page of $totalPages</div>";

        return $tableHtml . $paginationHtml;
    }
}

?>
