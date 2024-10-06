


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
       

       var name=$('#name').val();
       var division=$('#division').val();
       var district=$('#district').val();
       var upazilla=$('#upazilla').val();
       var union=$('#union').val();
       var village=$('#village').val();
       
       debugger;

       if(id==0 || division=='' || district=='' || upazilla=='' || union=='' || village==''){
          alert("Please Select a Data!");
       }
       else{
       
        var sql = "UPDATE customer SET name='"+name+"', division_id='"+division+"', district_id='"+district+"',upazilla_id='"+upazilla+"',union_id='"+union+"',village_id='"+village+"' WHERE id="+id;
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



function getdistrict()
{
  
document.getElementById("district").innerHTML = "";

var did=document.getElementById("division").value;

var dataString = 'did=' + did;

// AJAX code to submit form.
$.ajax({
type: "POST",
url: "Model/getdistrict.php",
data: dataString,
cache: false,
async:false,
success: function(html) {
 document.getElementById("district").innerHTML = html;
}
});

}



function getupazilla()
{

  
document.getElementById("upazilla").innerHTML = "";

var did=document.getElementById("district").value;

var dataString = 'did=' + did;

// AJAX code to submit form.
$.ajax({
type: "POST",
url: "Model/getupazilla.php",
data: dataString,
cache: false,
async:false,
success: function(html) {
 document.getElementById("upazilla").innerHTML = html;
}
});

}

function getunion()
{

   
document.getElementById("union").innerHTML = "";

var did=document.getElementById("upazilla").value;

var dataString = 'did=' + did;

// AJAX code to submit form.
$.ajax({
type: "POST",
url: "Model/getunion.php",
data: dataString,
cache: false,
success: function(html) {
 document.getElementById("union").innerHTML = html;
}
});

}


function getvillage()
{

   
document.getElementById("village").innerHTML = "";

var did=document.getElementById("union").value;

var dataString = 'did=' + did;

// AJAX code to submit form.
$.ajax({
type: "POST",
url: "Model/getvillage.php",
data: dataString,
cache: false,
success: function(html) {
 document.getElementById("village").innerHTML = html;
}
});

}

function AddVillage()
{
       var did=document.getElementById("union").value;
       var name=document.getElementById("newVillage").value;
       if(did=='' || did==0){
           alert("Please Select Union!");
       }
       else if(name=='')
       {
           alert("Please Insert Village Name!");
       }
       else
       {
       var sql="INSERT INTO village (name,union_id) VALUES ('"+name+"','"+did+"')";
       saveOnly(sql);
       document.getElementById("newVillage").value="";
       getvillage();
       }
       
}