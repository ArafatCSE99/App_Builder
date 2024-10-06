
function savedata()
{ 
       var userid=$('#userid').val();
       var companyid=$('#companyid').val();
       var categoryname=$('#category').val();
       var percentage=$('#percentage').val()==""?0:$('#percentage').val();
       var processing_fee=$('#processing_fee').val()==""?0:$('#processing_fee').val();
       if(id==0){
        var sql="INSERT INTO category (userid,companyid,name,percentage,processing_fee) VALUES ("+userid+","+companyid+",'"+categoryname+"','"+percentage+"','"+processing_fee+"')";
       }
       else{
        var sql = "UPDATE category SET name='"+categoryname+"',percentage='"+percentage+"',processing_fee='"+processing_fee+"' WHERE id="+id;
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
  $processing_fee=row.find('.processing_fee').text();

  $('#category').val($categoryname);
  $('#percentage').val($percentage);
  $('#processing_fee').val($processing_fee);

  
  ScrollToBottom();

}


function updateDiscountFormula(categoryId,e)
{
    var isDiscountFormula=$(e).is(":checked")==true?"checked":"";
    var sql = "UPDATE category SET isDiscountFormula='"+isDiscountFormula+"' WHERE id="+categoryId;
    saveWithoutMessage(sql);
    
}