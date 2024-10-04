


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

var imag_name="";

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

      imag_name=data;
   
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
       var mobileno=$('#mobileno').val();
       var address=$('#address').val();
       var reference=$('#reference').val();
       
       var visiting_date=$('#visit_date').val();
       var note=$('#note').val();
      

      $("#image-form").submit();

       if(id==0){
        var sql="INSERT INTO visiting_info (userid,companyid,branchid,name,mobileno,address,employeeid,image,visiting_date,note) VALUES ("+userid+","+companyid+","+branchid+",'"+name+"','"+mobileno+"','"+address+"','"+reference+"','"+imag_name+"','"+visiting_date+"','"+note+"')";
       }
       else{
           
           if(imag_name==""){
        var sql = "UPDATE visiting_info SET name='"+name+"', mobileno='"+mobileno+"', address='"+address+"',employeeid='"+reference+"' WHERE id="+id;
           }
           else
           {
               var sql = "UPDATE visiting_info SET name='"+name+"', mobileno='"+mobileno+"', address='"+address+"',employeeid='"+reference+"',image='"+imag_name+"' WHERE id="+id;
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
  
  $('#name').val($name);
  $('#mobileno').val($mobileno);
  $('#address').val($address);
  $('#opening_due').val($opening_due);
  $('#month').val($month);
  
  $("#reference option:contains(" + $reference + ")").attr('selected', 'selected').change();

  ScrollToBottom();

}

$('#mobileno').on('change', function() {
  
     var mobile=$('#mobileno').val();
     $(".mobileno").each(function(){
        // Test if 
        if($(this).text()==mobile){
            alert('Mobile No Already Exist !');
            $('#mobileno').val('');
        }
    });
  
});
