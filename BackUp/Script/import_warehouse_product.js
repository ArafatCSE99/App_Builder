

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
       var name=$('#name').val();
       debugger;
       name=name.replace("'", "/'");
       var warehouse=$('#warehouse').val();
       
        var purchase_price=$('#purchaseprice').val()==""?0:$('#purchaseprice').val();
        var sales_price=$('#salesprice').val()==""?0:$('#salesprice').val();
        var sales_price_smrp=$('#salespricesmrp').val()==""?0:$('#salespricesmrp').val();
        var stock=$('#stock').val()==""?0:$('#stock').val();

       if(name=="")
       {
         alert('Please Insert Product Name ! !');
       }
       else if(warehouse=='' || warehouse==0)
       {
           alert('Please Select Warehouse ! !');
       }
       else{
       
       var code=$('#code').val();
       var model=$('#model').val();
       var selfno=$('#selfno').val();
       var category=$('#category').val();

       if(category=='')
       {
         category=0;
       }

       $("#image-form").submit();

       if(0==0){
        var sql="INSERT INTO product (userid,name,code,model,self,categoryid,image,`warehouseid`) VALUES ('"+userid+"','"+name+"','"+code+"','"+model+"','"+selfno+"','"+category+"','"+imag_name+"','"+warehouse+"')";
       }
       else{

        if(imag_name==""){

          var sql = "UPDATE product SET name='"+name+"',code='"+code+"',model='"+model+"',self='"+selfno+"',categoryid='"+category
          +"',warehouseid='"+warehouse+"',purchase_price='"+purchase_price+"',sales_price='"+sales_price+"',sales_price_smrp='"+sales_price_smrp+"',stock='"+stock+"' WHERE id="+id;
      
        }else{

          var sql = "UPDATE product SET name='"+name+"',code='"+code+"',model='"+model+"',self='"+selfno+"',categoryid='"+category+"',image='"+imag_name+"',warehouseid='"+warehouse+"',purchase_price='"+purchase_price+"',sales_price='"+sales_price+"',sales_price_smrp='"+sales_price_smrp+"',stock='"+stock+"' WHERE id="+id;
        }
      }
      
       var returnsql="SELECT max(id) as id FROM product WHERE userid="+userid;
        
       
       
       if(userid==1 || userid==4)
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
   
var dataString="sql="+sql+"&returnsql="+returnsql;

//alert(dataString);
      
$.ajax({
type: "POST",
url: "Model/savemaster.php",
data: dataString,
cache: false,
success: function(html) {

//alert("Data Successfully Saved");

savedetail(html);
//id=0;
//reload()

}
});

}


function savedetail(masterid)
{

    var userid=$('#userid').val();
    var purchase_price=$('#purchaseprice').val()==""?0:$('#purchaseprice').val();
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
  getcontent(viewcontent);
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
  
  id=0;

  $('#productid').val(id);

  var row=$(e).closest('tr');

  $name=row.find('.name').text();
  $code=row.find('.code').text();
  $model=row.find('.model').text();
  $self=row.find('.self').text();
  $category=row.find('.category').text();
  
  $warehouse=row.find('.warehouse').text();
  $stock=row.find('.stock').text();
  $sales_price=row.find('.sales_price').text();
  $sales_price_smrp=row.find('.sales_price_smrp').text();

  $('#name').val($name);
  $('#code').val($code);
  $('#model').val($model);
  $('#selfno').val($self);
  
  $('#stock').val($stock);
  $('#salesprice').val($sales_price);
  $('#salespricesmrp').val($sales_price_smrp);
  

  $("#category option:contains(" + $category + ")").attr('selected', 'selected').change();
  $("#warehouse option:contains(" + $warehouse + ")").attr('selected', 'selected').change();

  ScrollToBottom();

}




function reload()
{
    getcontent(viewcontent);
}




function Adddata(id,purchaseid,warehouseid,e){
   debugger;
   var row=$(e).closest('tr');
   var transfer_qty=row.find('input.transfer_qty').val();
   var cstock=row.find('.current_stock').text();
   console.log(transfer_qty+" "+cstock);

   if(transfer_qty=="" || transfer_qty<=0 || transfer_qty==undefined ||  transfer_qty*1>cstock*1)
   {
     alert("Please Insert Valid Transfer Qty ! !");
   }
   else{

   var userid=$('#userid').val();
   var companyid=$('#companyid').val();
   var branchid=$('#branchid').val();
   var created_at=$('#current_date').val();
   
   var sql="update stock_warehouse set current_stock=current_stock-"+transfer_qty+" where purchaseid='"+purchaseid+"' and productid='"+id+"'; ";
   console.log(sql);
// Ajax To Save Data .......
       
var dataString="sql="+sql;

//alert(dataString);
      
$.ajax({
type: "POST",
url: "Model/savedetail.php",
data: dataString,
cache: false,
success: function(html) {
   
  //alert('Data Successfully Saved ! !');
  //getcontent(viewcontent);
   
}
});



sql="INSERT INTO stock_branch (purchaseid,`userid`, `companyid`, `warehouseid`,branchid, `productid`, `initial_purchase`, `current_stock`,created_at) VALUES ("+purchaseid+","+userid+",'"+companyid+"','"+warehouseid+"','"+branchid+"','"+id+"','"+transfer_qty+"','"+transfer_qty+"','"+created_at+"'); ";
    
// Ajax To Save Data .......
       
dataString="sql="+sql;

//alert(dataString);
      
$.ajax({
type: "POST",
url: "Model/savedetail.php",
data: dataString,
cache: false,
success: function(html) {
   
  alert('Data Successfully Saved ! !');
  getcontent(viewcontent);
   
}
});

   

   }
   
  
}



function Returndata(id,stockid,purchaseid,warehouseid,e){
   debugger;
   var row=$(e).closest('tr');
   var transfer_qty=row.find('input.transfer_qty').val();
   var cstock=row.find('.current_stock').text();
   console.log(transfer_qty+" "+cstock);

   if(transfer_qty=="" || transfer_qty<=0 || transfer_qty==undefined ||  transfer_qty*1>cstock*1)
   {
     alert("Please Insert Valid Transfer Qty ! !");
   }
   else{

   var userid=$('#userid').val();
   var companyid=$('#companyid').val();
   var branchid=$('#branchid').val();
   var created_at=$('#current_date').val();
   
   var sql="update stock_warehouse set current_stock=current_stock+"+transfer_qty+" , return_qty=return_qty+"+transfer_qty+" where purchaseid='"+purchaseid+"' and productid='"+id+"'; ";
   console.log(sql);
// Ajax To Save Data .......
       
var dataString="sql="+encodeURIComponent(sql);

//alert(dataString);
      
$.ajax({
type: "POST",
url: "Model/savedetail.php",
data: dataString,
cache: false,
success: function(html) {
   
   console.log(html); 
  //alert('Data Successfully Saved ! !');
  //getcontent(viewcontent);
   
}
});


sql="update stock_branch set current_stock=current_stock-"+transfer_qty+"  where id='"+stockid+"'; ";
console.log(sql);    
// Ajax To Save Data .......
       
dataString="sql="+sql;

//alert(dataString);
      
$.ajax({
type: "POST",
url: "Model/savedetail.php",
data: dataString,
cache: false,
success: function(html) {
   
  alert('Data Successfully Saved ! !');
  getcontent(viewcontent);
   
}
});

   

   }
   
  
}




function Updatedata(id,purchaseid,warehouseid,e){
    
   if(confirm('Are You Sure')){ 
   debugger;
   var row=$(e).closest('tr');
   var update_qty=row.find('input.update_qty').val();
   var cstock=row.find('.current_stock').text();
   var initial_purchase=row.find('.initial_purchase').text();
   console.log(update_qty+" "+cstock);

   if(update_qty=="" || update_qty<0 || update_qty==undefined ||  update_qty*1>initial_purchase*1)
   {
     alert("Please Insert Valid Update Qty ! !");
   }
   else{

   var userid=$('#userid').val();
   var companyid=$('#companyid').val();
   var branchid=$('#branchid').val();
   var created_at=$('#current_date').val();
   
   var sql="update stock_warehouse set original_current_stock=current_stock, current_stock="+update_qty+" where purchaseid='"+purchaseid+"' and productid='"+id+"'; ";
   console.log(sql);
// Ajax To Save Data .......
       
var dataString="sql="+sql;

//alert(dataString);
      
$.ajax({
type: "POST",
url: "Model/savedetail.php",
data: dataString,
cache: false,
success: function(html) {
   
  //alert('Data Successfully Saved ! !');
   getcontent(viewcontent);
   
}
});

   }
   
   }
   
  
}    





function UpdatedataBranch(id,stockid,purchaseid,warehouseid,e){
    
   if(confirm('Are You Sure')){ 
   debugger;
   var row=$(e).closest('tr');
   var update_qty=row.find('input.update_qty').val();
   var cstock=row.find('.current_stock').text();
   var initial_purchase=row.find('.initial_purchase').text();
   console.log(update_qty+" "+cstock);

   if(update_qty=="" || update_qty<0 || update_qty==undefined ||  update_qty*1>initial_purchase*1)
   {
     alert("Please Insert Valid Update Qty ! !");
   }
   else{

   var userid=$('#userid').val();
   var companyid=$('#companyid').val();
   var branchid=$('#branchid').val();
   var created_at=$('#current_date').val();
   
   var sql="update stock_branch set original_current_stock=current_stock, current_stock="+update_qty+" where id='"+stockid+"'; ";
   console.log(sql);
// Ajax To Save Data .......
       
var dataString="sql="+sql;

//alert(dataString);
      
$.ajax({
type: "POST",
url: "Model/savedetail.php",
data: dataString,
cache: false,
success: function(html) {
   
  //alert('Data Successfully Saved ! !');
   getcontent(viewcontent);
   
}
});

   }
   
   }
   
  
}    



$("#example2").DataTable({
      "responsive": true,
      "autoWidth": false,
});    
    
