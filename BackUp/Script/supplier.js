
function savedata()
{ 
       var userid=$('#userid').val();
       var companyid=$('#companyid').val();
       var branchid=$('#branchid').val();
       var name=$('#name').val();
       var mobileno=$('#mobileno').val();
       var address=$('#address').val();
       var opening_due=$('#opening_due').val();

       if(id==0){
        var sql="INSERT INTO supplier (userid,companyid,branchid,name,mobileno,address,opening_due) VALUES ("+userid+","+companyid+","+branchid+",'"+name+"','"+mobileno+"','"+address+"','"+opening_due+"')";
       }
       else{
        var sql = "UPDATE supplier SET name='"+name+"', mobileno='"+mobileno+"', address='"+address+"',opening_due='"+opening_due+"' WHERE id="+id;
       }
      
       save(sql);

       id=0;

       ScrollToTop();
   
}

function updatedata(updateid,e)
{
  
  id=updateid;

  var row=$(e).closest('tr');

  $name=row.find('.name').text();
  $mobileno=row.find('.mobileno').text();
  $address=row.find('.address').text();
  $opening_due=row.find('.opening_due').text();

  $('#name').val($name);
  $('#mobileno').val($mobileno);
  $('#address').val($address);
  $('#opening_due').val($opening_due);

  ScrollToBottom();

}

$( document ).ready(function() {
     var subuserid=$('#subuserids').val();
     if(subuserid!=0)
     {   console.log('Hiding  . . .');
         $('.HideData').hide();
         console.log('Hiden . . .');
     }
});
