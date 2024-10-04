
function savedata()
{ 
       var userid=$('#userid').val();
       var companyid=$('#companyid').val();
       var expense_headname=$('#expense_head').val();
       
       if(id==0){
        var sql="INSERT INTO expense_head (userid,companyid,name) VALUES ("+userid+","+companyid+",'"+expense_headname+"')";
       }
       else{
        var sql = "UPDATE expense_head SET name='"+expense_headname+"' WHERE id="+id;
       }
      
       save(sql);

       id=0;

       
       ScrollToTop();
   
}

function updatedata(updateid,e)
{

  id=updateid;
  
  var row=$(e).closest('tr');

  $expense_headname=row.find('.expense_headname').text();
  $('#expense_head').val($expense_headname);
 
  
  ScrollToBottom();

}



function update_profit_type(expense_id)
{
     var profit_type=$('.profit_type'+expense_id).val();
     var sql = "UPDATE expense_head SET profit_type='"+profit_type+"' WHERE id="+expense_id;
     console.log(sql);
      
       saveWithoutMessage(sql);
}