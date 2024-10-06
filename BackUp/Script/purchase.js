
function adddata()
{
   var productid=$('#product').val();
   var productname=$('#product option:selected').text();
   var qty=$('#quantity').val();
   var msrp_price=$('#unitprice').val();
   var percentage=$('#percentage').val();
   var unitprice=msrp_price-( (msrp_price*percentage)/100 );
   var amount=qty*unitprice;
   var SubAmount=amount;//qty*msrp_price;

   if(productid=="" || qty=="" || unitprice=="" )
   {
      alert('Plese Insert Data ! !');
   }
   else
   {

      var tabledata="<tr><td style='display:none;' class='detailid'>0</td><td style='text-align:center;' class='slno'></td><td style='display:none;' style='text-align:right;' class='productid'>"+productid+"</td> <td style='display:none;' style='text-align:right;' class='msrp_price'>"+msrp_price+"</td>  <td style='display:none;' style='text-align:right;' class='percentage'>"+percentage+"</td> <td>"+productname+"</td><td class='qty'>"+qty+"</td><td class='unitprice'>"+unitprice+"</td><td class='amount'>"+amount+"</td>"
      +"<td class='text-center py-0 align-middle' style='text-align:center;'>"
      +"<div class='btn-group btn-group-sm'>"
      +"<a onclick=deletedetaildata(0,this,'purchase_detail') id='deletebuttondetail' class='btn btn-danger'><i class='fas fa-trash'></i></a>"
      +"</div>"
      +"</td>"
      +"</tr>";
      
var subuserid=$('#subuserids').val();

if(subuserid>0){
   
   tabledata="<tr><td style='display:none;' class='detailid'>0</td><td style='text-align:center;' class='slno'></td><td style='display:none;' style='text-align:right;' class='productid'>"+productid+"</td> <td style='display:none;' style='text-align:right;' class='msrp_price'>"+msrp_price+"</td>  <td style='display:none;' style='text-align:right;' class='percentage'>"+percentage+"</td> <td>"+productname+"</td><td class='qty'>"+qty+"</td><td style='display:none;' class='unitprice'>"+unitprice+"</td> <td>"+msrp_price+"</td> <td>"+SubAmount+"</td>   <td style='display:none;' class='amount'>"+amount+"</td>"
      +"<td class='text-center py-0 align-middle' style='text-align:center;'>"
      +"<div class='btn-group btn-group-sm'>"
      +"<a onclick=deletedetaildata(0,this,'purchase_detail') id='deletebuttondetail' class='btn btn-danger'><i class='fas fa-trash'></i></a>"
      +"</div>"
      +"</td>"
      +"</tr>";
      
}
     
      $('#detail tbody').append(tabledata);
                   
      addslno();
      calculate_total();                  

      $('#product').val('').change();
      $('#quantity').val('');
      $('#unitprice').val('');
   }

   
   
}

function addslno()
{
  $('#detail tbody tr').each(function (i, row) {

    var $row = $(row);

    $row.find('.slno').text(i+1*1);

  });
}

function calculate_total()
{
  var total=0;
  var totalQty=0;

  $('#detail tbody tr').each(function (i, row) {
    var $row = $(row);   
    var amount=$row.find('.amount').text();
    total=total+amount*1;
    
    var totalquantity=$row.find('.qty').text();
    totalQty=totalQty+totalquantity*1;
    
  });
 
  var grand_discount=$('#grand_discount').val(); //total*(discount_per/100);
  $('#grand_discount_value').val(grand_discount);
  total=total-grand_discount;
 
  $('#total').text(total);
  $('#totalQty').text(totalQty);

  var paid=$('#paid').val();

  if(paid>total)
  {
    alert("Sorry Paid Amount cannot be Greater than Total Amount ! !");
    $('#paid').val('0');
    $('#due').text(total);
  }
  else{
    $('#due').text(total-paid*1);
  }
 

}


$("#paid,#grand_discount").change(function(){
  
  calculate_total();
  
});


function savedata()
{ 
     
       var userid=$('#userid').val();
       var companyid=$('#companyid').val();
       var branchid=$('#branchid').val();
       var supplierid=$('#supplier').val();
       var warehouseid=$('#warehouse').val();
       var branch=$('#branch').val();
       var purchase_date=$('#purchase_date').val();
       var note=$('#note').val();
       var total=$('#total').text();
       var paid=$('#paid').val();
       var due=$('#due').text();

       var grand_discount=$('#grand_discount_value').val();

       var count=0;
       $('#detail tbody tr').each(function (i, row) {
        
        count++;
    
      });

       if(supplierid=="")
       {
           alert('Please Select Supplier ! !');
       }
       if(warehouseid=="" && branch=="")
       {
           alert("Please Select Warehouse/Branch !!");
       }
       else if(count==0){
          alert('Please Add Product ! !');
       }
       else
       {
           warehouseid=warehouseid==""?0:warehouseid;
           branch=branch==""?0:branch;
           

        if(id==0){
          var sql="INSERT INTO purchase_master (userid,companyid,warehouseid,branchid,supplierid,purchase_date,total_price,paid,due,note,discount) VALUES ("+userid+","+companyid+","+warehouseid+",'"+branch+"','"+supplierid+"','"+purchase_date+"','"+total+"','"+paid+"','"+due+"','"+note+"','"+grand_discount+"')";
         }
         else{
          var sql = "UPDATE purchase_master SET supplierid='"+supplierid+"',purchase_date='"+purchase_date+"',total_price='"+total+"',paid='"+paid+"',due='"+due+"',note='"+note+"',discount='"+grand_discount+"' WHERE id="+id;
         }

         var returnsql="SELECT max(id) as id FROM purchase_master WHERE userid="+userid;
        
         savemaster(sql,returnsql);
  
        
       }

   
}

function savemaster(sql,returnsql)
{
   
var dataString="sql="+sql+"&returnsql=Purchase";

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

  if(id!=0)
  {
    masterid=id;
  }
  
  $('#detail tbody tr').each(function (i, row) {

    var $row = $(row);   

    var userid=$('#userid').val();
    var companyid=$('#companyid').val();
    var warehouseid=$('#warehouse').val();
    var detailid=$row.find('.detailid').text();
    var productid=$row.find('.productid').text();
    var qty=$row.find('.qty').text();
    var unitprice=$row.find('.unitprice').text();
    var amount=$row.find('.amount').text();
    
    var msrp_price=$row.find('.msrp_price').text();
    var percentage=$row.find('.percentage').text();

    //alert(detailid);

     if(detailid==0) {


var sql="INSERT INTO purchase_detail (userid,purchaseid,productid,quantity,unitprice,total_price,msrp_price,percentage) VALUES ("+userid+",'"+masterid+"','"+productid+"','"+qty+"','"+unitprice+"','"+amount+"','"+msrp_price+"','"+percentage+"'); ";
      
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

/*
var branch=$('#branch').val();

if(branch==""){

sql="INSERT INTO stock_warehouse (purchaseid,userid, companyid, warehouseid, productid, initial_purchase, current_stock) VALUES ("+masterid+","+userid+",'"+companyid+"','"+warehouseid+"','"+productid+"','"+qty+"','"+qty+"'); ";

}
else
{
    sql="INSERT INTO stock_branch (purchaseid,userid, companyid, branchid, productid, initial_purchase, current_stock) VALUES ("+masterid+","+userid+",'"+companyid+"','"+branch+"','"+productid+"','"+qty+"','"+qty+"'); ";
    
}
      
dataString="sql="+sql;

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



*/

     }  
     else
     {
      
      // No chance to update . . . . . . . . . . . . . . . 
      //var sql="INSERT INTO purchase_detail (userid,purchaseid,productid,quantity,unitprice,total_price) VALUES ("+userid+",'"+id+"','"+productid+"','"+qty+"','"+unitprice+"','"+amount+"')";
       //  INSERT INTO stock_warehouse (purchaseid,`userid`, `companyid`, `warehouseid`, `productid`, `initial_purchase`, `current_stock`) VALUES ("+masterid+","+userid+",'"+companyid+"','"+warehouseid+"','"+productid+"','"+qty+"','"+qty+"'); 
     }


     // Ajax To Save Data .......
 //alert(sql);      
       


    
  });

  alert('Data Successfully Saved ! !');
  getcontent(viewcontent);
  id=0;

}




function updatedata(updateid,e)
{

  id=updateid;
  
  var row=$(e).closest('tr');
  
  $supplierid=row.find('.supplierid').text();
  $supplier_name=row.find('.supplier_name').text();
  $purchase_date=row.find('.purchase_date').text();
  $total_price=row.find('.total_price').text();
  $paid=row.find('.paid').text();
  $due=row.find('.due').text();
  $note=row.find('.note').text();

  $('#supplier').val($supplierid).change();
  $('#purchase_date').val($purchase_date);
  $('#total').text($total_price);
  $('#paid').val($paid);
  $('#due').text($due);
  $('#note').val($note);
  
  // Get Detail data .............................

  $('#detail tbody').empty();

  var dataString="purchaseid="+updateid;

  $.ajax({
    type: "POST",
    url: "Model/getpurchasedetail.php",
    data: dataString,
    cache: false,
    success: function(html) {
    
      $('#detail tbody').append(html);
    
    }
    });



  ScrollToBottom();

}



function deletemasterdetail(id,e,tablename,detailtablename,masteridname)
{
   if(confirm('Are You Sure?'))
   {

    var dataString="deletedid="+id+"&tablename="+tablename+"&detailtablename="+detailtablename+"&masteridname="+masteridname;

$.ajax({
type: "POST",
url: "Model/deletemasterdetail.php",
data: dataString,
cache: false,
success: function(html) {

 alert(html);
 $(e).closest('tr').remove();
 
 
}
});

   }

}



function deletedetaildata(id,e,tablename)
{
   if(confirm('Are You Sure?'))
   {

    var dataString="deletedid="+id+"&tablename="+tablename;

$.ajax({
type: "POST",
url: "Model/delete.php",
data: dataString,
cache: false,
success: function(html) {

 alert(html);
 $(e).closest('tr').remove();
 
 calculate_total();
 
}
});

   }

}



$("#barcode").change(function(){

  var procode=$("#barcode").val();

  var dataString="code="+procode;
  
  $.ajax({
    type: "POST",
    url: "Model/getProductIdByCode.php",
    data: dataString,
    cache: false,
    success: function(html) {
      var proid=html*1;
      if(proid!=0){
      $("#product").val(proid).change();
      }
     
    }
    });


  
});



$(document).ready(function(){
 
  if($(window).width()<=768){ 

    $('.form-control').css('margin','0px');

  }

});


var init_msrp_prise=0;
var init_percentage=0;

$("#product").change(function(){
    
    var dataString="productid="+$('#product').val();

  $.ajax({
  type: "POST",
  url: "Model/getAllDataByProductId.php",
  data: dataString,
  cache: false,
  success: function(html) {

    var duce = jQuery.parseJSON(html);

var i;
for (i = 0; i < duce.length; ++i) {

  var proid = duce[i]["proid"];
  var procode = duce[i]["procode"];
  var pronm = duce[i]["pronm"];
  var proself = duce[i]["proself"];
  var type = duce[i]["model"];
  var batchno = duce[i]["batchno"];
  var msrp_prise = duce[i]["msrp_prise"];
  var percentage = duce[i]["percentage"];
  
  $('#quantity').val(1);
  $('#unitprice').val(msrp_prise);
  $('#percentage').val(percentage);
  
  var purchase_Unitprice=msrp_prise-( (percentage/100)*msrp_prise );
  
  $('#purchase_unitprice').val(purchase_Unitprice);
  
  init_msrp_prise=msrp_prise;
  init_percentage=percentage;
  
   
}
  
  }
  
  });
    
});


var subuserid=$('#subuserids').val();

/*
if(subuserid>0){
    $('#percentage').hide();
    $('#psign').hide();
}
*/

/*
$("#unitprice").change(function(){
  
   var current_price=$("#unitprice").val();
   if(init_msrp_prise>current_price){
       var change_price=init_msrp_prise-current_price;
       var increase_percenteage=(change_price*100)/init_msrp_prise;
       var newPercentage=Math.round(init_percentage*1+increase_percenteage*1,2);
       $('#percentage').val(newPercentage);
   }
   else
   {
       var change_price=current_price-init_msrp_prise;
       var increase_percenteage=(change_price*100)/current_price;
       var newPercentage=Math.round(init_percentage*1-increase_percenteage*1,2);
       $('#percentage').val(newPercentage);
   }
  
});




$("#percentage").change(function(){
  
   var current_percentage=$("#percentage").val();
   if(init_percentage>current_percentage){
       var change_percentage=init_percentage-current_percentage;
       var increase_price=(change_percentage/100)*init_msrp_prise;
       var newPrice=Math.round(init_msrp_prise*1+increase_price*1,2);
       $('#unitprice').val(newPrice);
   }
   else
   {
       var change_percentage=current_percentage-init_percentage;
       var increase_price=(change_percentage/100)*init_msrp_prise;
       var newPrice=Math.round(init_msrp_prise*1-increase_price*1,2);
       $('#unitprice').val(newPrice);
   }
  
});
*/


$("#percentage").change(function(){
   var percentage=$(this).val();
   var unitprice=$("#unitprice").val();
   current_price=unitprice-( (percentage/100)*unitprice );
   $("#purchase_unitprice").val(current_price);
});


$("#purchase_unitprice").change(function(){
   var unitprice=$(this).val();
   var current_unit=$("#unitprice").val();
   current_price=100-( (unitprice/current_unit)*100);
   $("#percentage").val(current_price);
});


function PrintReceipt(viewid,e)
{
  var dataString="salesid="+viewid;

  $.ajax({
    type: "POST",
    url: "Model/getQuickPurchaseReceipt.php",
    data: dataString,
    cache: false,
    success: function(html) {
    
      showModal(html);
    
    }
    });
}


function updatestatus(id,e)
{
    if(confirm('Are You Sure?')){
   

    var dataString="id="+id;

    $.ajax({
    type: "POST",
    url: "Model/updatePurchaseStatus.php",
    data: dataString,
    cache: false,
    success: function(html) {
    
       $(e).hide(300);
       id=0;
    
    }
    });
    

    }
}
