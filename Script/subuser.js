
function savedata()
{ 

       var userid=$('#userid').val();
       var name=$('#name').val();
       debugger;
       name=name.replace("'", "/'");

       if(name=="")
       {
         alert('Please Insert subuser Name ! !');
       }
       else{
       
       var user_name=$('#user_name').val();
       var password=$('#password').val();
       var role=$('#role').val();
      
       if(role=='')
       {
        role=0;
       }      

       if(id==0){
        var sql="INSERT INTO subuser (userid,name,user_name,password,roleid) VALUES ('"+userid+"','"+name+"','"+user_name+"','"+password+"','"+role+"')";
       }
       else{
          var sql = "UPDATE subuser SET name='"+name+"',user_name='"+user_name+"',password='"+password+"',roleid='"+role+"' WHERE id="+id;
      }
      
     
      save_master(sql);
      id=0;    
      ScrollToTop();

    }
   
}


function updatedata(updateid,e)
{
  
  id=updateid;

  $('#subuserid').val(updateid);

  var row=$(e).closest('tr');

  $name=row.find('.name').text();
  $user_name=row.find('.user_name').text();
  $password=row.find('.password').text();
  $role=row.find('.role').text();

  $('#name').val($name);
  $('#user_name').val($user_name);
  $('#password').val($password);

  $("#role option:contains(" + $role + ")").attr('selected', 'selected').change();

  ScrollToBottom();

}
