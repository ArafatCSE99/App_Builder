
function savedata()
{ 
       var userid=$('#userid').val();
       var companyid=$('#companyid').val();
       var warehousename=$('#warehouse').val();
       if(id==0){
        var sql="INSERT INTO warehouse (userid,companyid,name) VALUES ("+userid+","+companyid+",'"+warehousename+"')";
       }
       else{
        var sql = "UPDATE warehouse SET name='"+warehousename+"' WHERE id="+id;
       }
      
       save(sql);

       id=0;

       
       ScrollToTop();
   
}

function updatedata(updateid,e)
{

  id=updateid;
  
  var row=$(e).closest('tr');

  $warehousename=row.find('.warehousename').text();

  $('#warehouse').val($warehousename);

  
  ScrollToBottom();

}
