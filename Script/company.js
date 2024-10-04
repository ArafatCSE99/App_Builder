
function savedata()
{ 
     
       var userid=$('#userid').val();

       var name=$('#name').val();
       var mobileno=$('#mobileno').val();
       var address=$('#address').val();
       var facebook=$('#facebook').val();
       if(id==0){
        var sql="INSERT INTO company (userid,name,mobileno,address,facebook) VALUES ("+userid+",'"+name+"','"+mobileno+"','"+address+"','"+facebook+"')";
       }
       else{
        var sql = "UPDATE company SET name='"+name+"',mobileno='"+mobileno+"',address='"+address+"',facebook='"+facebook+"' WHERE id="+id;
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
  $facebook=row.find('.facebook').text();

  $('#name').val($name);
  $('#mobileno').val($mobileno);
  $('#address').val($address);
  $('#facebook').val($facebook);

  ScrollToBottom();

}
