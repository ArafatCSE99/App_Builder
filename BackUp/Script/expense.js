
function savedata()
{ 
       var userid=$('#userid').val();
       var companyid=$('#companyid').val();
       var expense_for=$('#expense_head_id').val();
       var amount=$('#amount').val();
       var date=$('#date').val();
       var branchesid=$('#branchesid').val();
       var note=$('#note').val();
       var expense_from=$('#expense_from').val();
       var employeeid=$('#employeeid').val();
       
       if(expense_for=="" || amount=="" || date=="")
       {
           alert("Please Insert Data !");
       }
       else{

       if(id==0){
        var sql="INSERT INTO expense (userid,companyid,branchid,expense_head_id,amount,expense_date,Note,expense_from,employeeid) VALUES ("+userid+",'"+companyid+"','"+branchesid+"','"+expense_for+"','"+amount+"','"+date+"','"+note+"','"+expense_from+"','"+employeeid+"')";
       }
       else{
        var sql = "UPDATE expense SET expense_head_id='"+expense_for+"', amount='"+amount+"', expense_date='"+date+"',branchid='"+branchesid+"',Note='"+note+"',expense_from='"+expense_from+"',employeeid='"+employeeid+"' WHERE id="+id;
       }
      
       saveWithoutMessage(sql);
       
       id=0;

       //ScrollToTop();
       alert('Data Successfully Saved!')
       
       }
   
}

function updatedata(updateid,e)
{
  
  id=updateid;

  var row=$(e).closest('tr');

  $expense_for=row.find('.expense_for').text();
  $branch=row.find('.branch').text();
  $amount=row.find('.amount').text();
  $date=row.find('.expense_date').text();
  $note=row.find('.note').text();
  $expense_by=row.find('.expense_by').text();
  

  //$('#expense_for').val($expense_for);
  $('#amount').val($amount);
  $('#date').val($date);
  $('#note').val($note);
  
  $('#expense_head_id').find("option:contains(" + $expense_for+ ")").attr('selected', 'selected');
  $('#expense_head_id').trigger('change');
  
  $('#branchesid').find("option:contains(" + $branch+ ")").attr('selected', 'selected');
  $('#branchesid').trigger('change');
  
   $('#employeeid').find("option:contains(" + $expense_by+ ")").attr('selected', 'selected');
  $('#employeeid').trigger('change');

  ScrollToBottom();

}



function reload()
{
    getcontent(viewcontent);
}

