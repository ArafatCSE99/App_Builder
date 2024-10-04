<br>
           <span> 


      <form class = "form-inline" role = "form">

      <div class = "form-group" style='display:none;'>
            <label class = "sr-only" for = "">Customer</label>
            
  <select class="form-control s_parameter" id="s_customer">
    <?php 

$ctg_id=0;
$ctg_name="";
$sqlsem = "SELECT * FROM customer where userid=$userid and companyid=$companyid";
$resultse = $conn->query($sqlsem);
echo "<option value='' hidden=''>All Customer</option>";
if ($resultse->num_rows > 0) {
   
    while($rowse = $resultse->fetch_assoc()) {
       $ctg_id=$rowse["id"];
       $ctg_name=$rowse["name"];
       echo "<option value='$ctg_id'>".$ctg_name."</option>";

    }
} 

    ?>
  </select>

         </div>
         &nbsp;&nbsp;

         <div class = "form-group">
            <label class = "sr-only" for = "dtfrom">Date From</label>
            <input type = "date" class = "form-control" id = "s_dtfrom">
         </div>
         &nbsp;&nbsp;
         <div class = "form-group">
            <label class = "sr-only" for = "dtfrom">Date To</label>
            <input type = "date" class = "form-control" id = "s_dtto">
         </div>
         &nbsp;&nbsp;
         <div class = "form-group">
            <label class = "sr-only" for = "dtfrom">Category</label>
            
  <select class="form-control" id="s_ctg">
    <?php 

$ctg_id=0;
$ctg_name="";
$sqlsem = "SELECT * FROM category where userid=$userid and companyid=$companyid";
$resultse = $conn->query($sqlsem);
echo "<option value='' hidden=''>All Category</option>";
if ($resultse->num_rows > 0) {
   
    while($rowse = $resultse->fetch_assoc()) {
       $ctg_id=$rowse["id"];
       $ctg_name=$rowse["name"];
       echo "<option value='$ctg_id'>".$ctg_name."</option>";

    }
} 

    ?>
  </select>

         </div>
         &nbsp;&nbsp;
         <div class = "form-group">
            <label class = "sr-only" for = "dtfrom">Model</label>
            <input type = "text" class = "form-control" id = "s_model" placeholder='All Model'>
          </div>
          &nbsp;&nbsp;
          <div class = "form-group">
            <label class = "sr-only" for = "dtfrom">code</label>
            <input type = "text" class = "form-control" id = "s_code" placeholder='Code'  style='width:150px;'>
          </div>
          &nbsp;&nbsp;
          <div class = "form-group">
            <label class = "sr-only" for = "dtfrom">Name</label>
            <input type = "text" class = "form-control" id = "s_name" placeholder='Name'>
          </div>
          &nbsp;&nbsp;
         <button type = "button" onclick='ReportRefresh()' class = "btn btn-primary">Search</button>

      </form>

            </span> 
            