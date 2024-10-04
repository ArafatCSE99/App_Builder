

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


// product is not saved fro here 
function savedata()
{ 

       var userid=$('#userid').val();
       var companyid=$('#companyid').val();
       var name=$('#name').val();
       debugger;
       name=name.replace("'", "/'");

       if(name=="")
       {
         alert('Please Insert Employee Name ! !');
       }
       else{
       
       var code=$('#code').val();
       var mobile_no=$('#mobile_no').val();
       var address=$('#address').val();
       var designation=$('#designation').val();
       var department=$('#department').val();
       var salary=$('#salary').val();
       var joining_date=$('#joining_date').val();

       if(designation=='')
       {
        designation=0;
       }

       $("#image-form").submit();

       if(id==0){
        var sql="INSERT INTO employee (userid,companyid,name,employeeid,mobile_no,address,departmentid,salary,designationid,joining_date,image) VALUES ('"+userid+"','"+companyid+"','"+name+"','"+code+"','"+mobile_no+"','"+address+"','"+department+"','"+salary+"','"+designation+"','"+joining_date+"','"+imag_name+"')";
       }
       else{

        if(imag_name==""){

          var sql = "UPDATE employee SET name='"+name+"',employeeid='"+code+"',mobile_no='"+mobile_no+"',address='"+address+"',designationid='"+designation+"',joining_date='"+joining_date+"',departmentid='"+department+"',salary='"+salary+"' WHERE id="+id;
      
        }else{

          var sql = "UPDATE employee SET name='"+name+"',employeeid='"+code+"',mobile_no='"+mobile_no+"',address='"+address+"',designationid='"+designation+"',joining_date='"+joining_date+"',image='"+imag_name+"',departmentid='"+department+"',salary='"+salary+"' WHERE id="+id;
        }
      }
      
     
      save(sql);

      id=0;    

       ScrollToTop();

    }
   
}


function updatedata(updateid,e)
{
  
  id=updateid;

  $('#employeeid').val(updateid);

  var row=$(e).closest('tr');

  $name=row.find('.name').text();
  $code=row.find('.code').text();
  $mobile_no=row.find('.mobile_no').text();
  $salary=row.find('.salary').text();
  $address=row.find('.address').text();
  $designation=row.find('.designation').text();
  $department=row.find('.department').text();
  $joining_date=row.find('.joining_date').text();

  $('#name').val($name);
  $('#code').val($code);
  $('#mobile_no').val($mobile_no);
  $('#salary').val($salary);
  $('#address').val($address);
  $('#joining_date').val($joining_date);
  

  $("#designation option:contains(" + $designation + ")").attr('selected', 'selected').change();
  $("#department option:contains(" + $department + ")").attr('selected', 'selected').change();

  ScrollToBottom();

}
