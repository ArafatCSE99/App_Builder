

function savedata(stockid,id,e)
{ 

  var userid=$('#userid').val();

  var productid=id;

  var row=$(e).closest('tr');
  var previous_qty=row.find('.previous_qty input').val();
  var purchase_qty=row.find('.purchase_qty').text();
  var sales_qty=row.find('.sales_qty').text();
  var current_stock=row.find('.current_stock').text();
 
  var stock=(previous_qty*1+purchase_qty*1)-sales_qty;
  row.find('.current_stock').text(stock);

 
  var sql="INSERT INTO stock_manager (userid,productid,previous_qty) VALUES ("+userid+",'"+productid+"','"+previous_qty+"')";

  deletestock(stockid,'stock_manager')
  saveWithoutMessage(sql);

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