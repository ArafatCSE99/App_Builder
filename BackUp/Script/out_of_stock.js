

function savedata(stockid,id,e)
{ 

  var userid=$('#userid').val();

  var productid=id;

  var row=$(e).closest('tr');
  var previous_qty=row.find('.previous_qty input').val();

 
  var sql="INSERT INTO stock_manager (userid,productid,previous_qty) VALUES ("+userid+",'"+productid+"','"+previous_qty+"')";

  deletestock(stockid,'stock_manager')
  save(sql);

  ScrollToTop();
   
}


function deletestock(id,tablename)
{
   
var dataString="deletedid="+id+"&tablename="+tablename;

$.ajax({
type: "POST",
url: "Model/delete.php",
data: dataString,
cache: false,
async:false,
success: function(html) {

}
});


}



/*
function updatedata(updateid,e)
{
  
  id=updateid;

  $('#productid').val(updateid);

  var row=$(e).closest('tr');

  $name=row.find('.name').text();
  $code=row.find('.code').text();
  $category=row.find('.category').text();

  $('#name').val($name);
  $('#code').val($code);
  $('#category').val($category);

}
*/