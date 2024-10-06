
function savedata()
{ 
       var userid=$('#userid').val();

       var category=$('#category').val();
       var amount=$('#amount').val();
       var date=$('#date').val();
       
       if(category=="" || amount=="" || date=="")
       {
           alert("Please Insert Data !");
       }
       else{

       if(id==0){
        var sql="INSERT INTO purchase_cost (userid,category,amount,cost_date) VALUES ("+userid+",'"+category+"','"+amount+"','"+date+"')";
       }
       else{
        var sql = "UPDATE purchase_cost SET category='"+category+"', amount='"+amount+"', cost_date='"+date+"' WHERE id="+id;
       }
      
       save(sql);

       id=0;

       ScrollToTop();
       
       }
   
}

function updatedata(updateid,e)
{
  
  id=updateid;

  var row=$(e).closest('tr');

  $category=row.find('.category').text();
  $amount=row.find('.amount').text();
  $date=row.find('.expense_date').text();
  

  $("#category option:contains(" + $category + ")").attr('selected', 'selected').change();
  
  $('#amount').val($amount);
  $('#date').val($date);

  ScrollToBottom();

}
