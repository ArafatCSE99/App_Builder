
function savedata()
{ 
       var userid=$('#userid').val();
       var companyid=$('#companyid').val();
       var departmentname=$('#department').val();
       if(id==0){
        var sql="INSERT INTO department (userid,companyid,name) VALUES ("+userid+",'"+companyid+"','"+departmentname+"')";
       }
       else{
        var sql = "UPDATE department SET name='"+departmentname+"' WHERE id="+id;
       }
      
       save(sql);

       id=0;

       
       ScrollToTop();
   
}

function updatedata(updateid,e)
{

  id=updateid;
  
  var row=$(e).closest('tr');

  $departmentname=row.find('.departmentname').text();

  $('#department').val($departmentname);

  
  ScrollToBottom();

}
