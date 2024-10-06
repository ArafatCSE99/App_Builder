

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
         alert('Please Insert Product Name ! !');
       }
       else{
       
       var code=$('#code').val();
       var model=$('#model').val();
       var selfno=$('#selfno').val();
       var category=$('#category').val();
       var subcategory=$('#subcategory').val();
       var msrp_price=$('#msrp').val()==""?0:$('#msrp').val();

       if(category=='')
       {
         category=0;
       }

       $("#image-form").submit();

       if(id==0){
        var sql="INSERT INTO product (userid,companyid,name,code,model,self,categoryid,subcategoryid,image,msrp_price) VALUES ('"+userid+"','"+companyid+"','"+name+"','"+code+"','"+model+"','"+selfno+"','"+category+"','"+subcategory+"','"+imag_name+"','"+msrp_price+"')";
       }
       else{

        if(imag_name==""){

          var sql = "UPDATE product SET name='"+name+"',code='"+code+"',model='"+model+"',self='"+selfno+"',categoryid='"+category+"',subcategoryid='"+subcategory+"',msrp_price='"+msrp_price+"' WHERE id="+id;
      
        }else{

          var sql = "UPDATE product SET name='"+name+"',code='"+code+"',model='"+model+"',self='"+selfno+"',categoryid='"+category+"',subcategoryid='"+subcategoryid+"',msrp_price='"+msrp_price+"',image='"+imag_name+"' WHERE id="+id;
        }
      }
      
       var returnsql="SELECT max(id) as id FROM product WHERE userid="+userid;
        
       
        
       if(userid==0 || userid==0)
       {
            var OtherUserId=userid==1?4:1;
            var sqlOther="INSERT INTO product (userid,name,code,model,self,categoryid,image) VALUES ('"+OtherUserId+"','"+name+"','"+code+"','"+model+"','"+selfno+"','"+category+"','"+imag_name+"')";
            
            var returnsqlOther="SELECT max(id) as id FROM product WHERE userid="+OtherUserId;
           
           console.log(sql,sqlOther,returnsqlOther,OtherUserId);
           savemasterOther(sqlOther,returnsqlOther,OtherUserId);
           
       }
       
    
       savemaster(sql,returnsql);
       
       

       ScrollToTop();

    }
   
}





function savemaster(sql,returnsql)
{
   
var dataString="sql="+sql+"&returnsql=Product";

//alert(dataString);
      
$.ajax({
type: "POST",
url: "Model/savemaster.php",
data: dataString,
cache: false,
success: function(html) {

savedetail(html);

}
});

}


function savedetail(masterid)
{

    var userid=$('#userid').val();
    var purchase_price=$('#purchaseprice').val()==""?0:$('#purchaseprice').val();
    var percentagep=$('#percentage').val();
    if(percentagep!="" && percentagep!=0)
    {
        purchase_price=purchase_price*1-(percentagep/100)*purchase_price;
    }
    var sales_price=$('#salesprice').val()==""?0:$('#salesprice').val();
    var sales_price_smrp=$('#salespricesmrp').val()==""?0:$('#salespricesmrp').val();
    var stock=$('#stock').val()==""?0:$('#stock').val();
   
 if(id==0){

  var sql="INSERT INTO price_manager (userid,productid,purchase_price,sales_price,sales_price_smrp) VALUES ("+userid+",'"+masterid+"','"+purchase_price+"','"+sales_price+"','"+sales_price_smrp+"')";
    
// Ajax To Save Data .......
 //alert(sql);      
       
var dataString="sql="+sql;

//alert(dataString);
      
$.ajax({
type: "POST",
url: "Model/savedetail.php",
data: dataString,
cache: false,
success: function(html) {
    //alert(html);
}
});



var sql="INSERT INTO stock_manager (userid,productid,previous_qty) VALUES ("+userid+",'"+masterid+"','"+stock+"')";
    
// Ajax To Save Data .......
 //alert(sql);      
       
var dataString="sql="+sql;

//alert(dataString);
      
$.ajax({
type: "POST",
url: "Model/savedetail.php",
data: dataString,
cache: false,
success: function(html) {
    //alert(html);
}
});



}
 
  alert('Data Successfully Saved ! !');
  //getcontent(viewcontent);
  id=0;

}


// for other user .......

function savemasterOther(sqlOther,returnsqlOther,OtherUserId)
{
   
var dataString="sql="+sqlOther+"&returnsql="+returnsqlOther;
console.log(dataString);
//alert(dataString);
      
$.ajax({
type: "POST",
url: "Model/savemaster.php",
data: dataString,
cache: false,
async:false,
success: function(html) {

//console.log(html,sql,returnsql,OtherUserId);
savedetailOther(html,OtherUserId);

}
});

}


function savedetailOther(masterid,OtherUserId)
{

    var userid=OtherUserId;
    var purchase_price=$('#purchaseprice').val()==""?0:$('#purchaseprice').val();
    var percentagep=$('#percentage').val();
    if(percentagep!="" && percentagep!=0)
    {
        purchase_price=purchase_price*1-(percentagep/100)*purchase_price;
    }
    var sales_price=$('#salesprice').val()==""?0:$('#salesprice').val();
    var sales_price_smrp=$('#salespricesmrp').val()==""?0:$('#salespricesmrp').val();
    var stock=$('#stock').val()==""?0:$('#stock').val();
   
 if(id==0){

  var sql="INSERT INTO price_manager (userid,productid,purchase_price,sales_price,sales_price_smrp) VALUES ("+userid+",'"+masterid+"','"+purchase_price+"','"+sales_price+"','"+sales_price_smrp+"')";
    
// Ajax To Save Data .......
 //alert(sql);      
       
var dataString="sql="+sql;

//alert(dataString);
      
$.ajax({
type: "POST",
url: "Model/savedetail.php",
data: dataString,
cache: false,
async:false,
success: function(html) {
    //alert(html);
}
});



var sql="INSERT INTO stock_manager (userid,productid,previous_qty) VALUES ("+userid+",'"+masterid+"','"+stock+"')";
    
// Ajax To Save Data .......
 //alert(sql);      
       
var dataString="sql="+sql;

//alert(dataString);
      
$.ajax({
type: "POST",
url: "Model/savedetail.php",
data: dataString,
cache: false,
async:false,
success: function(html) {
    //alert(html);
}
});



}
 
  //alert('Data Successfully Saved ! !');
  //getcontent(viewcontent);
  //id=0;
  //console.log(sql,returnsql);
 
  

}






function updatedata(updateid,e)
{
  
  id=updateid;

  $('#productid').val(updateid);

  var row=$(e).closest('tr');

  $name=row.find('.name').text();
  $code=row.find('.code').text();
  $model=row.find('.model').text();
  $self=row.find('.self').text();
  $category=row.find('.category').text();
  $subcategory=row.find('.subcategory').text();

  $('#name').val($name);
  $('#code').val($code);
  $('#model').val($model);
  $('#selfno').val($self);
  

  $("#category option:contains(" + $category + ")").attr('selected', 'selected').change();
  $("#subcategory option:contains(" + $subcategory + ")").attr('selected', 'selected').change();

  ScrollToBottom();

}




function reload()
{
    getcontent(viewcontent);
}


function getPercentage()
{
    getValueByTableField('category','percentage','category');
    //alert($('#percentage').val());
}
