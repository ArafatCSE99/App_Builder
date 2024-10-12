
function savedata()
{ 
       var userid=$('#userid').val();
       var rolename=$('#role').val();
       if(id==0){
        var sql="INSERT INTO roles (user_id,name) VALUES ("+userid+",'"+rolename+"')";
       }
       else{
        var sql = "UPDATE roles SET name='"+rolename+"' WHERE id="+id;
       }
      
       save(sql);

       id=0;

       
       ScrollToTop();
   
}

function updatedata(updateid,e)
{

  id=updateid;
  
  var row=$(e).closest('tr');

  $rolename=row.find('.rolename').text();

  $('#role').val($rolename);

  
  ScrollToBottom();

}
