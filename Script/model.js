
function savedata()
{ 
       var userid=$('#userid').val();
       var categoryname=$('#category').val();
       var percentage=$('#percentage').val()==""?0:$('#percentage').val();
       if(id==0){
        var sql="INSERT INTO category (userid,name,percentage) VALUES ("+userid+",'"+categoryname+"','"+percentage+"')";
       }
       else{
        var sql = "UPDATE category SET name='"+categoryname+"',percentage='"+percentage+"' WHERE id="+id;
       }
      
       save(sql);

       id=0;

       
       ScrollToTop();
   
}

function updatedata(updateid,e)
{

  id=updateid;
  
  var row=$(e).closest('tr');

  $categoryname=row.find('.categoryname').text();
  $percentage=row.find('.percentage').text();

  $('#category').val($categoryname);
  $('#percentage').val($percentage);

  
  ScrollToBottom();

}
