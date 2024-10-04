

function savedata(priceid,id,e)
{ 

  var userid=$('#userid').val();

  var productid=id;

  var row=$(e).closest('tr');
  var purchase_price=row.find('.purchase_price input').val();
  var sales_price=row.find('.sales_price input').val();
  var sales_price_smrp=row.find('.sales_price_smrp input').val();
 
  var profit=sales_price-purchase_price;
  row.find('.profit').text(profit+'/=');
 
  var sql="INSERT INTO price_manager (userid,productid,purchase_price,sales_price,sales_price_smrp) VALUES ("+userid+",'"+productid+"','"+purchase_price+"','"+sales_price+"','"+sales_price_smrp+"')";

  deleteprice(priceid,'price_manager')
  saveWithoutMessage(sql);

  ScrollToTop();
   
}


function deleteprice(id,tablename)
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