<?php 

include "../connection.php";

session_start(); 
$userid=$_SESSION["userid"];
$roles=$_POST["roles"];

?>

<div class="row">
        <div class="col-md-12">

    <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title" >List of Role</h3>
                <a href="#add"><span style="float:right; cursor:pointer; display:none;">Add New</span></a>
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="overflow:auto;">
                <table id="example1" class="table table-bordered" style="width:100%">
                  <thead class="thead-light">
                  <tr>
                    <th style='text-align:center;'>#</th>
                    <th>Feature Name</th>
                    <th style='text-align:center;'>View</th>
                    <th style='text-align:center;'>Add</th>
                    <th style='text-align:center;'>Edit</th>
                    <th style='text-align:center;'>Delete</th>
                  </tr>
                  </thead>
                  <tbody>

                  <?php

$slno=0;

$sql = "SELECT * FROM features where userid=$userid order by sequence,id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $slno++;
    $featureid=$row["id"];
    $name=$row["name"];
    
    $view="";
    $add="";
    $edit="";
    $delete="";

$sqlr = "SELECT * FROM role_permissions where roleid=$roles and featureid=$featureid ";
$resultr = $conn->query($sqlr);

if ($resultr->num_rows > 0) {
  // output data of each row
  while($rowr = $resultr->fetch_assoc()) {
    $view=$rowr["is_view"]==1?"checked":"";
    $add=$rowr["is_add"]==1?"checked":"";
    $edit=$rowr["is_edit"]==1?"checked":"";
    $delete=$rowr["is_delete"]==1?"checked":"";
  }
} else {
  $view="";
  $add="";
  $edit="";
  $delete="";
}

     echo "<tr>";
     echo "<td style='text-align:center;'>".$slno."</td>";
     echo "<td class='rolename'>".$name."</td>"; 
     echo "<td style='text-align:center;'><input type='checkbox' onchange=updateRolePermission($roles,$featureid,'is_view',this) $view> </td>";
     echo "<td style='text-align:center;'><input type='checkbox' onchange=updateRolePermission($roles,$featureid,'is_add',this) $add> </td>";
     echo "<td style='text-align:center;'><input type='checkbox' onchange=updateRolePermission($roles,$featureid,'is_edit',this) $edit> </td>";
     echo "<td style='text-align:center;'><input type='checkbox' onchange=updateRolePermission($roles,$featureid,'is_delete',this) $delete> </td>";
    
     echo "</tr>";
      

  }
} else {
  
}
                ?>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>

            </div>
        
        </div>


