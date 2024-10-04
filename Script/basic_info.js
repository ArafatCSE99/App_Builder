
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



function savedata()
{ 
     
       var userid=$('#userid').val();
       var companyid=$('#companyid').val();
       var name=$('#name').val();
       var mobileno=$('#mobileno').val();
       var facebook=$('#facebook').val();

       var shopcategory=$('#shop_category').val();
       var division=$('#division').val();
       var district=$('#district').val();
       var upazila=$('#upazilla').val();
       var caddress=$('#caddress').val();

       if(shopcategory=='')
       {
        shopcategory=0;
       }
       if(division=='')
       {
        division=0;
       }
       if(district=='')
       {
        district=0;
       }
       if(upazila=='')
       {
        upazila=0;
       }

       $("#image-form").submit();

       id=$('#insertupdateid').val();

       if(id==0){
        var sql="INSERT INTO `basic_info`( `userid`,companyid, `shop_name`, `shop_categoryid`, `mobileno`, `facebook`, `division_id`, `district_id`, `upazila_id`, `union_id`,address, `logo`) VALUES ("+userid+","+companyid+",'"+name+"','"+shopcategory+"','"+mobileno+"','"+facebook+"','"+division+"','"+district+"','"+upazila+"','0','"+caddress+"','"+imag_name+"')";
       }
       else{

          if(imag_name==""){

             var sql = "UPDATE basic_info SET shop_name='"+name+"',mobileno='"+mobileno+"',shop_categoryid='"+shopcategory+"',facebook='"+facebook+"',division_id='"+division+"',district_id='"+district+"',upazila_id='"+upazila+"',address='"+caddress+"' WHERE id="+id;
         
           }else{

             var sql = "UPDATE basic_info SET shop_name='"+name+"',mobileno='"+mobileno+"',shop_categoryid='"+shopcategory+"',facebook='"+facebook+"',division_id='"+division+"',district_id='"+district+"',upazila_id='"+upazila+"',address='"+caddress+"',logo='"+imag_name+"' WHERE id="+id;

           }
       }
       console.log(sql);
       save(sql);

       id=0;

       ScrollToTop();
     
   
}


// Update ....................................................

if($('#insertupdateid').val()!=0){

getdistrict();


var dis=$('#updatedistrict').val();
if(dis!='')
{
   $('#district').val(dis).change();
}


var up=$('#updateupazila').val();
if(up!='')
{
   $('#upazilla').val(up).change();
}

}