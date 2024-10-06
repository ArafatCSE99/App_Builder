


function getPreviousBalance()
{



var bank_accountid=document.getElementById("bank_accountid").value;

//alert(bank_accountid);

var dataString = 'bank_accountid=' + bank_accountid;

// AJAX code to submit form.
$.ajax({
type: "POST",
url: "Model/getPreviousBalance.php",
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
    if(type=="Deposit"){
    Total_balance=amount*1+previous_balance*1;
    $("#current_balance").val(Total_balance);
    }
    else
    {
      if(amount>previous_balance)
      {
        alert("Insufficient Balance ! ");
      }
      else{
      Total_balance=previous_balance*1-amount*1;
      $("#current_balance").val(Total_balance);
      }
    }

    

  }

  

}


function savedata()
{ 
       var userid=$('#userid').val();
       var companyid=$('#companyid').val();
       var bank_accountid=$('#bank_accountid').val();
       var previous_balance=$('#previous_balance').val();
       var amount=$('#amount').val();
       var current_balance=$('#current_balance').val();
       var transaction_type=$('#transaction_type').val();
       var dates=$('#dates').val();

       
      
var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
var yyyy = today.getFullYear();

today = dd + '/' + mm + '/' + yyyy;

today=dates;
     
       if(bank_accountid=="" || previous_balance=="" || amount=="" || current_balance=="" || transaction_type=="" ||  dates=="" )
       {
          alert('Please Insert Data');
       }
       else{

       

       if(id==0){
        var sql="INSERT INTO bank_transaction (`userid`,companyid, `date`, `bank_accountid`, `previous_balance`, `amount`, `current_balance`,transaction_type) VALUES ('"+userid+"','"+companyid+"','"+today+"','"+bank_accountid+"','"+previous_balance+"','"+amount+"','"+current_balance+"','"+transaction_type+"')";
        //alert(sql);
       }
       else{
        var sql = "UPDATE bank_transaction SET bank_accountid='"+bank_accountid+"', previous_balance='"+previous_balance+"',amount='"+amount+"',current_balance='"+current_balance+"',transaction_type='"+transaction_type+"' WHERE id="+id;
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

  $bank_accountid=row.find('.bank_accountid').text();
  $previous_balance=row.find('.previous_balance').text();
  $amount=row.find('.amount').text();
  $current_balance=row.find('.current_balance').text();
  $transaction_type=row.find('.transaction_type').text();
  $dates=row.find('.date').text();

  //alert($bank_accountid)

  //$('#bank_accountid).find("option:contains(" + theText+ ")).attr('selected', 'selected');
  
  $('#bank_accountid').find("option:contains(" + $bank_accountid+ ")").attr('selected', 'selected');

  $('#previous_balance').val(parseFloat($previous_balance));
  $('#amount').val(parseFloat($amount));
  $('#current_balance').val(parseFloat($current_balance));
  $('#transaction_type').val($transaction_type).change();
  $('#dates').val($dates)

  
  ScrollToBottom();

}


