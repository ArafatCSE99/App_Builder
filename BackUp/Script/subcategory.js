
function savedata()
{ 
       var userid=$('#userid').val();
       var subcategoryname=$('#subcategory').val();
       var categoryid=$('#category').val();
       if(id==0){
        var sql="INSERT INTO subcategory (admin_user_id,categoryid,subcategoryname) VALUES ("+userid+",'"+categoryid+"','"+subcategoryname+"')";
       }
       else{
        var sql = "UPDATE subcategory SET categoryid='"+categoryid+"',subcategoryname='"+subcategoryname+"' WHERE subcategoryid="+id;
       }
      
       save(sql);

       id=0;

       
       ScrollToTop();
   
}

function updatedata(updateid,e)
{

  id=updateid;
  
  var row=$(e).closest('tr');

  $subcategoryname=row.find('.subcategoryname').text();

  $category=row.find('.categoryname').text();

  $('#subcategory').val($subcategoryname);

  $("#category option:contains(" + $category + ")").attr('selected', 'selected').change();
  
  ScrollToBottom();

}
