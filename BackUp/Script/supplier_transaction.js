


function getPreviousBalance()
{



var supplierid=document.getElementById("supplierid").value;

//alert(bank_accountid);

var dataString = 'supplierid=' + supplierid;

// AJAX code to submit form.
$.ajax({
type: "POST",
url: "Model/getSupplierPreviousBalance.php",
data: dataString,
cache: false,
async:false,
success: function(html) {

 document.getElementById("previous_balance").value = parseFloat(html);
 
}
});


}



$("#amount,#transaction_type").change(function() {

  Calculate_Total();

});


function Calculate_Total()
{
  var amount=$( "#amount" ).val();
  var previous_balance=$( "#previous_balance").val();
  var Total_balance=0;

  var type=$("#transaction_type").val();

  if(amount!="" && type!="")
  {
    if(type=="Given"){
    Total_balance=amount*1+previous_balance*1;
    $("#current_balance").val(Total_balance);
    }
    else
    {
      
      Total_balance=previous_balance*1-amount*1;
      $("#current_balance").val(Total_balance);
      
    }

    

  }

  

}


function savedata()
{ 
       var userid=$('#userid').val();
       var companyid=$('#companyid').val();
       var supplierid=$('#supplierid').val();
       var previous_balance=$('#previous_balance').val();
       var amount=$('#amount').val();
       var current_balance=$('#current_balance').val();
       var transaction_type=$('#transaction_type').val();
       var dates=$('#dates').val();
       
       if(transaction_type=="Given")
       {
           var out_account=amount;
           var in_account=0;
       }
       else
       {
           var out_account=0;
           var in_account=amount;
       }

       
      
var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();

today = dd + '/' + mm + '/' + yyyy;

today=dates;
debugger;
previous_balance=0;
     
       if(supplierid=="" || amount=="" || current_balance=="" || transaction_type=="" ||  dates=="" )
       {
          alert('Please Insert Data');
       }
       else{

       

       if(id==0){
        var sql="INSERT INTO app_supplier_account (`userid`,companyid, `supplierid`, `previous_balance`, `in_account`, `out_account`, `balance`, `transaction_date`) VALUES ('"+userid+"','"+companyid+"','"+supplierid+"','"+previous_balance+"','"+in_account+"','"+out_account+"','"+current_balance+"','"+today+"')";
        //alert(sql);
       }
       else{
        var sql = "UPDATE app_supplier_account SET supplierid='"+supplierid+"', previous_balance='"+previous_balance+"',in_account='"+in_account+"',current_balance='"+current_balance+"',out_account='"+out_account+"' WHERE id="+id;
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

  $supplierid=row.find('.supplierid').text();
  $previous_balance=row.find('.previous_balance').text();
  $amount=row.find('.amount').text();
  $current_balance=row.find('.current_balance').text();
  $transaction_type=row.find('.transaction_type').text();
  $dates=row.find('.date').text();

  //alert($bank_accountid)

  //$('#bank_accountid).find("option:contains(" + theText+ ")).attr('selected', 'selected');
  
  $('#supplierid').find("option:contains(" + $supplierid+ ")").attr('selected', 'selected');

  $('#previous_balance').val(parseFloat($previous_balance));
  $('#amount').val(parseFloat($amount));
  $('#current_balance').val(parseFloat($current_balance));
  $('#transaction_type').val($transaction_type).change();
  $('#dates').val($dates)

  
  ScrollToBottom();

}


