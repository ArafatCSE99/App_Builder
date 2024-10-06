
function savedata()
{ 
       var userid=$('#userid').val();
       var companyid=$('#companyid').val();
       var designationname=$('#designation').val();
       if(id==0){
        var sql="INSERT INTO designation (userid,companyid,name) VALUES ("+userid+",'"+companyid+"','"+designationname+"')";
       }
       else{
        var sql = "UPDATE designation SET name='"+designationname+"' WHERE id="+id;
       }
      
       save(sql);

       id=0;

       
       ScrollToTop();
   
}

function updatedata(updateid,e)
{

  id=updateid;
  
  var row=$(e).closest('tr');

  $designationname=row.find('.designationname').text();

  $('#designation').val($designationname);

  
  ScrollToBottom();

}
