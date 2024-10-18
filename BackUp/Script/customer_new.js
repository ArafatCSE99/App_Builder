


// Image Brows ........................................

$(document).on("click", ".browse", function() {
  var file = $(this)
  .parent()
  .parent()
  .parent()
  .find(".file");
  file.trigger("click");
});
$('input[type="file"]').change(function(e) {
  var fileName = e.target.files[0].name;
  $("#file").val(fileName);

  var reader = new FileReader();
  reader.onload = function(e) {
  // get loaded data and render thumbnail.
  document.getElementById("preview").src = e.target.result;
  };
  // read the image file as a data URL.
  reader.readAsDataURL(this.files[0]);
});

var image_name="";

$("#image-form").on("submit", function() {
  debugger;
  $.ajax({
    type: "POST",
    url: "imageUpload/ajax/action.ajax.php",
    data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
    contentType: false, // The content type used when sending data to the server.
    cache: false, // To unable request pages to be cached
    processData: false, // To send DOMDocument or non processed data file it is set to false
    async:false,
    success: function(data) {

      image_name=data;
   
    },
    error: function(data) {


    }
  });

  });


function savedata()
{ 
       var userid=$('#userid').val();
       var companyid=$('#companyid').val();
       var branchid=$('#branchid').val();

       var name=$('#name').val();
       var proprietor_name=$('#proprietor').val();
       var mobileno=$('#mobileno').val();
       var address=$('#address').val();
       var reference=$('#reference').val();
       var opening_due=$('#opening_due').val();
       var month=$('#month').val();

      $("#image-form").submit();

       if(id==0){
        var sql="INSERT INTO customer (userid,companyid,branchid,name,mobileno,address,reference,image,opening_due,month,proprietor_name) VALUES ("+userid+","+companyid+","+branchid+",'"+name+"','"+mobileno+"','"+address+"','"+reference+"','"+imag_name+"','"+opening_due+"','"+month+"','"+proprietor_name+"')";
       }
       else{
           
           if(imag_name==""){
        var sql = "UPDATE customer SET name='"+name+"', mobileno='"+mobileno+"', address='"+address+"',reference='"+reference+"',opening_due='"+opening_due+"',month='"+month+"',proprietor_name='"+proprietor_name+"' WHERE id="+id;
           }
           else
           {
               var sql = "UPDATE customer SET name='"+name+"', mobileno='"+mobileno+"', address='"+address+"',reference='"+reference+"',image='"+imag_name+"',opening_due='"+opening_due+"',month='"+month+"',proprietor_name='"+proprietor_name+"' WHERE id="+id;
           }
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
  $reference=row.find('.reference').text();
  $opening_due=row.find('.opening_due').text();
  $month=row.find('.month').text();
  $proprietor=row.find('.proprietor').text();

  $('#name').val($name);
  $('#mobileno').val($mobileno);
  $('#address').val($address);
  $('#reference').val($reference);
  $('#opening_due').val($opening_due);
  $('#month').val($month);
  $('#proprietor').val($proprietor);

  ScrollToBottom();

}


function PrintReceipt(viewid,e)
{
  var dataString="customerid="+viewid;

  $.ajax({
    type: "POST",
    url: "Model/getCustomerReceipt.php",
    data: dataString,
    cache: false,
    success: function(html) {
    
      showModal(html);
    
    }
    });
}


function updateDefaulter(customerId,e)
{
    var isDefaulter=$(e).is(":checked")==true?"checked":"";
    var sql = "UPDATE customer SET isDefaulter='"+isDefaulter+"' WHERE id="+customerId;
    saveWithoutMessage(sql);
    
}
