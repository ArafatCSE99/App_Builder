
console.log($('#companyname').val());

$("#discountdetailpercent").change(function(){
    
    var discountdetailpercent=$("#discountdetailpercent").val();
    var unitprice=$("#unitprice").val();
    var quantity=$("#quantity").val();
    var discountdetail=quantity*unitprice*(discountdetailpercent/100);
    $('#discountdetail').val(discountdetail).change();
    
});


$("#quantity,#unitprice,#discountdetail").change(function(){
 
  //var quantity=$("#quantity").val();
  //var unitprice=$("#unitprice").val();
  
    var discountdetailpercent=$("#discountdetailpercent").val();
    var unitprice=$("#unitprice").val();
    var quantity=$("#quantity").val();
    var discountdetail=quantity*unitprice*(discountdetailpercent/100);
    $('#discountdetail').val(discountdetail);
    
  var discountdetail=$("#discountdetail").val();

  if(quantity=="")
  {
    quantity=0;
  }
  if(unitprice=="")
  {
    unitprice=0;
  }
  if(discountdetail=="")
  {
    discountdetail=0;
  }

  var totaldetail=(quantity*unitprice)-discountdetail;
  $("#totaldetail").val(totaldetail);

});


function adddata()
{
   var productid=$('#product').val();
   var stockid=$('#product_warehouse').val();
   var productname=$('#product option:selected').text();
   var qty=$('#quantity').val();
   var unitprice=$('#unitprice').val();
   var amount=qty*unitprice;
   var discountdetail=$('#discountdetail').val();
   discountdetail=discountdetail==""?0:discountdetail;
   var totaldetail=amount-discountdetail;
   console.log(" hi "+productname);

   if(productid=="" || qty=="" || unitprice=="" )
   {
      alert('Plese Insert Data ! !');
   }
   else
   {

      var tabledata="<tr><td style='display:none;' class='detailid'>0</td><td style='text-align:center;' class='slno'></td> <td style='display:none;' style='text-align:right;' class='stockid'>"+stockid+"</td> <td style='display:none;' style='text-align:right;' class='productid'>"+productid+"</td><td>"+productname+"</td><td class='qty'>"+qty+"</td><td class='unitprice'>"+unitprice+"</td><td class='amount'>"+amount+"</td><td class='discountdetail'>"+discountdetail+"</td><td class='totaldetail'>"+totaldetail+"</td>"
      +"<td class='text-center py-0 align-middle' style='text-align:center;'>"
      +"<div class='btn-group btn-group-sm'>"
      +"<a onclick=deletedetaildata(0,this,'sales_detail') id='deletebuttondetail' class='btn btn-danger'><i class='fas fa-trash'></i></a>"
      +"</div>"
      +"</td>"
      +"</tr>";
     
      $('#detail tbody').append(tabledata);
                   
      addslno();
      calculate_total();                  

      $('#product').val('').change();
      $('#quantity').val('');
      $('#unitprice').val('');
      $('#discountdetail').val('');
      $('#totaldetail').val('');
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
    var totalamount=$row.find('.totaldetail').text();
    total=total+totalamount*1;
    
    var totalquantity=$row.find('.qty').text();
    totalQty=totalQty+totalquantity*1;
    
  });
 
  $('#inittotal').text(total);
  //var discount_per=$('#grand_discount').val();
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

$('#warehouse').next(".select2-container").hide(300);
$('#product_warehouse').next(".select2-container").hide(300);

$('#product_branch').next(".select2-container").hide(300);
$('#product_warehouse').next(".select2-container").show(300);

var des=2;

$("#sales_destination").change(function(){
  
   des=$(this).val();
   
   if(des==1)
   {
    $('#warehouse').next(".select2-container").hide(300);
    $('#product_branch').next(".select2-container").show(300);
    $('#product_warehouse').next(".select2-container").hide(300);
   }
   else{
    //$('#warehouse').next(".select2-container").show(300);
    $('#product_branch').next(".select2-container").hide(300);
    $('#product_warehouse').next(".select2-container").show(300);
   }
  
});

$("#paid,#grand_discount").change(function(){
  
  calculate_total();
  
});

function savedata()
{ 
     
       var userid=$('#userid').val();
       var companyid=$('#companyid').val();
       var branchid=$('#branchid').val();
       var sales_mode=$('#sales_mode').val();
       var sales_from=$('#sales_destination').val();
       var subuserid=$('#subuserids').val();
       var logged_username=$('#logged_username').val();

       var customerid=$('#customer').val();
       var sales_date=$('#sales_date').val();
       var note=$('#note').val();
       var total=$('#total').text();
       var grand_discount=$('#grand_discount_value').val();
       var paid=$('#paid').val();
       var due=$('#due').text();
       
       var sales_type=$('#cp').val();
       var payment_type=$('#ptype').val();
       var pn=$('#pn').val();
       
       var count=0;
       $('#detail tbody tr').each(function (i, row) {
        
        count++;
    
      });

       if(customerid=="")
       {
           alert('Please Select branch ! !');
       }
       else if(due>0 && pn=="")
       {
           alert('Please Insert No of Payment ! !');
           $('#pn').focus();
       }
       else if(count==0){
          alert('Please Add Product ! !');
       }
       else
       {
           
           if(pn=="")
           {
               pn=0;
           }
           if(subuserid=="")
           {
               subuserid=0;
           }

        if(id==0){
          var sql="INSERT INTO stock_transfer_master (userid,companyid,branchid,sales_mode,sales_from,subuserid,username,customerid,sales_date,total_price,paid,due,note,`sales_type`, `payment_type`, `payment_no`,discount) VALUES ("+userid+","+companyid+","+branchid+","+sales_mode+","+sales_from+","+subuserid+",'"+logged_username+"','"+customerid+"','"+sales_date+"','"+total+"','"+paid+"','"+due+"','"+note+"','"+sales_type+"','"+payment_type+"','"+pn+"','"+grand_discount+"')";
         }
         else{
          //var sql = "UPDATE sales_master SET customerid='"+customerid+"',sales_date='"+sales_date+"',total_price='"+total+"',paid='"+paid+"',due='"+due+"',note='"+note+"',sales_type='"+sales_type+"',payment_type='"+payment_type+"',payment_no='"+pn+"',discount='"+grand_discount+"' WHERE id="+id;
         }

         var returnsql="SELECT max(id) as id FROM stock_transfer_master WHERE userid="+userid;
        
         savemaster(sql,returnsql);
  
         //SendSMSSales(total,due);
        
       }

   
}

function savemaster(sql,returnsql)
{
   
   //var sqln=encodeURI(sql);
   
var dataString="sql="+sql+"&returnsql=stock_transfer";
//dataString="sql=Hello";
dataString=encodeURI(dataString);

console.log(dataString);
      
$.ajax({
type: "POST",
url: "https://mkrow.tech/Model/savemaster.php",
data: dataString,
cache: false,
success: function(html) {

console.log(html);
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
    var detailid=$row.find('.detailid').text();
    var stockid=$row.find('.stockid').text();
    var productid=$row.find('.productid').text();
    var qty=$row.find('.qty').text();
    var unitprice=$row.find('.unitprice').text();
    var discountdetail=$row.find('.discountdetail').text();
    var totaldetail=$row.find('.totaldetail').text();

    var StockTable=des==1?"stock_branch":"stock_warehouse";

    //alert(detailid);

     if(detailid==0) {

var sql="INSERT INTO stock_transfer_detail (userid,salesid,stockid,productid,quantity,unitprice,discount,total_price) VALUES ("+userid+",'"+masterid+"',"+stockid+",'"+productid+"','"+qty+"','"+unitprice+"','"+discountdetail+"','"+totaldetail+"');  ";

var sqln=encodeURI(sql);
       
var dataString="sql="+sqln;

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



sql="update "+StockTable+" set current_stock=current_stock-"+qty+" where id="+stockid+" ";

sqln=encodeURI(sql);
       
dataString="sql="+sqln;

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
       

// Add To Branch ...........................

var created_at=$('#current_date').val();
var branchid=$('#customer').val();
sql="INSERT INTO stock_branch (purchaseid,`userid`, `companyid`, `warehouseid`,branchid, `productid`, `initial_purchase`, `current_stock`,created_at,stock_transfer_masterid) Select purchaseid,"+userid+",'"+companyid+"',warehouseid,'"+branchid+"','"+productid+"','"+qty+"','"+qty+"','"+created_at+"','"+masterid+"' from stock_warehouse where id='"+stockid+"'; ";

sqln=encodeURI(sql);
       
dataString="sql="+sqln;

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
     else
     {
      
      // No chance to update . . . . . . . . . . . . . . . 
      //var sql="INSERT INTO sales_detail (userid,salesid,productid,quantity,unitprice,total_price) VALUES ("+userid+",'"+id+"','"+productid+"','"+qty+"','"+unitprice+"','"+amount+"')";

     }


    
  });

  alert('Data Successfully Saved ! !');
  getcontent(viewcontent);
  id=0;

}




function updatedata(updateid,e)
{

  id=updateid;
  
  var row=$(e).closest('tr');
  
  $customerid=row.find('.customerid').text();
  $customer_name=row.find('.customer_name').text();
  $sales_date=row.find('.sales_date').text();
  $total_price=row.find('.total_price').text();
  $paid=row.find('.paid').text();
  $due=row.find('.due').text();
  $note=row.find('.note').text();

  $('#customer').val($customerid).change();
  $('#sales_date').val($sales_date);
  $('#total').text($total_price);
  $('#paid').val($paid);
  $('#due').text($due);
  $('#note').val($note);
  
  // Get Detail data .............................

  $('#detail tbody').empty();

  var dataString="salesid="+updateid;

  $.ajax({
    type: "POST",
    url: "Model/getsalesdetail.php",
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
  if(delete_permission==1){
    
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
  else{
    alert("Sorry, Access Denied !");
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


var stock=0;
var price=0;

function getstockprice()
{

   getstock();
   changePrice();

}


function getstock(){
 
  if(des==1){
    var dataString="stockid="+$('#product_branch').val()+"&des="+des;
  }
  else{
    var dataString="stockid="+$('#product_warehouse').val()+"&des="+des;
  }

  $.ajax({
  type: "POST",
  url: "Model/getstockByDestination.php",
  data: dataString,
  cache: false,
  success: function(html) {
    //alert(html);
    stock=html;
    $('#quantity').trigger('change');
   
  }
  });

}


function getprice(){

  var dataString="productid="+$('#product').val();

  $.ajax({
  type: "POST",
  url: "Model/getprice.php",
  data: dataString,
  cache: false,
  success: function(html) {

    price=html;
   
    $('#unitprice').val(price*1);

   
  }
  });

}



function getSMRPprice(){

  var dataString="productid="+$('#product').val();

  $.ajax({
  type: "POST",
  url: "Model/getSMRPprice.php",
  data: dataString,
  cache: false,
  success: function(html) {

    price=html;
   
    $('#unitprice').val(price*1);

   
  }
  });

}


$("#quantity").change(function(){
  
  var qty=$(this).val();
 
  if(qty>stock*1)
  {
    alert('Available Quantity '+stock);
    $(this).val('');
  }

  if(qty==0)
  {
    alert('Quantity Cannot be Zero ! !');
    $(this).val('');
  }
  

});


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
        $('#quantity').val(1);
        }
       
      }
      });

       


    
});




function viewdata(viewid,due,e)
{
  var dataString="branchid="+viewid+"&due="+due;

  $.ajax({
    type: "POST",
    url: "Model/getBranchPayment.php",
    data: dataString,
    cache: false,
    success: function(html) {
    
      showModal(html);
    
    }
    });
}



function addPayment(branchid)
{
       var pay_date=$('#payment_date').val();
       var pay_amount=$('#pay_amount').val();
       var discount_amount=$('#discount_amount').val();
       discount_amount=discount_amount==""?0:discount_amount;

       if(pay_amount!=""){

       var amounts=pay_amount*1+discount_amount*1;
      
        var sql="INSERT INTO branch_payment (branchid,payment_date,pay_amount,discount,amount) VALUES ("+branchid+",'"+pay_date+"','"+pay_amount+"','"+discount_amount+"','"+amounts+"')";
       
  // Ajax To Save Data .......
              
  var dataString="sql="+sql;
        
  $.ajax({
  type: "POST",
  url: "Model/savedetail.php",
  data: dataString,
  cache: false,
  success: function(html) {
      
    //viewdata(salesid,'');
    hideModal();
    getcontent('branch_payment');
    

  }
  });
  
  //SendSMS(amounts);
  
       }

}


function addPaymentDetails(salesid)
{
       var pay_date=$('#payment_date').val();
       var pay_amount=$('#pay_amountNew').val();

       var discount_amount=$('#discount_amountNew').val();
       discount_amount=discount_amount==""?0:discount_amount;

       if(pay_amount!=""){

       var amounts=pay_amount*1+discount_amount*1;
      
        var sql="INSERT INTO sales_payment (salesid,payment_date,pay_amount,discount,amount) VALUES ("+salesid+",'"+pay_date+"','"+pay_amount+"','"+discount_amount+"','"+amounts+"')";
       
  // Ajax To Save Data .......
              
  var dataString="sql="+sql;
        
  $.ajax({
  type: "POST",
  url: "Model/savedetail.php",
  data: dataString,
  cache: false,
  success: function(html) {
      
    getPaymentDetails(salesid,'');
    
    

  }
  });
  
  SendSMS(amounts);
  
       }

}



function SendSMS(payamount)
{
    
 var cname=$('#cname').text();
 var cmob=$('#cmob').text();
 cmob=encodeURIComponent(cmob);
 
 var duebefore=$('#dueval').val();
 var duenow=(duebefore*1-payamount);
 
 var companyname=$('#companyname').val();
 
 console.log(cmob);
 var message="প্রিয় "+cname+" আপনি "+companyname+"  এ  "+payamount+" টাকা পরিশোধ করেছেন , "+duenow+"  টাকা  বাকি রয়েছ , ধন্যবাদ। ";
 
  var ApiUrl= "https://24smsbd.com/api/bulkSmsApi";
 
 var dataString="apiKey=TUtyb3c6TUtyb3cxMjM=&mobileNo="+cmob+"&message="+message+"&sender_id=90"; 

 $.ajax({
  type: "POST",
  url: ApiUrl,
  data: dataString,
  cache: false,
  success: function(html) {
  console.log(html);
   
  }
  });

}



$("#pay").change(function(){

  var pay=$(this).val();
  var total=$('#total').text();



  if(pay*1>=total*1)
  {

     $('#paid').val(total);
     $('#change').val(pay-total);
  }
  else{

    $('#paid').val(pay);
    $('#change').val(0);

  }

  calculate_total();

});

  // End Change Functions ........................................

 
function PrintTransferReceipt(viewid,e)
{
  var dataString="salesid="+viewid;

  $.ajax({
    type: "POST",
    url: "Model/getTransferReceipt.php",
    data: dataString,
    cache: false,
    success: function(html) {
    
      showModal(html);
    
    }
    });
}




$(document).ready(function(){
 
  if($(window).width()<=768){ 

    $('.form-control').css('margin','0px');

  }

});



$("#customercode").change(function(){

  var custcode=$("#customercode").val();
  var dataString="code="+custcode;
  
  $.ajax({
    type: "POST",
    url: "Model/getCustomerIdByCode.php",
    data: dataString,
    cache: false,
    success: function(html) {
      var custid=html*1;
      if(custid!=0){
      $("#customer").val(custid).change();
      }
    }
    });
  
});


function changePrice()
{
   
    var type=$('#cp').val();
    if(type==1)
    {
      getprice();
      
      //$('#ptype').val('Cash').change();
      //$('#pn').hide();
      
    }
    else{
      getSMRPprice();
      
       //$('#ptype').val('Monthly').change();
       //$('#pn').show();
      
    }
    
}





function SendSMSSales(total,due)
{
      var html=$('#customer').find("option:selected").text();
    
      var name= html.substr( 0, html.indexOf(',')); 
      var mobile= "+88"+html.substr(html.indexOf( ',')+1);
      
      mobile=encodeURIComponent(mobile);
      
      var cp=$('#cp').val();
      var message="";
      
      var companyname=$('#companyname').val();
      
    if(cp==2){
      message="প্রিয় "+name+" আপনি "+companyname+" থেকে " +total+" টাকার পণ্য ক্রয় করেছেন , "+due+"  টাকা  বাকি রয়েছে,  ধন্যবাদ। ";
    }
    else
    {
      message="প্রিয় "+name+" আপনি "+companyname+" থেকে " +total+" টাকার পণ্য ক্রয় করেছেন ,  ধন্যবাদ। ";
    }
 
 var ApiUrl= "https://24smsbd.com/api/bulkSmsApi";
 
 var dataString="apiKey=TUtyb3c6TUtyb3cxMjM=&mobileNo="+mobile+"&message="+message+"&sender_id=90"; 
 
 
 
console.log(ApiUrl);
 $.ajax({
  type: "POST",
  url: ApiUrl,
  data: dataString,
  cache: false,
  success: function(html) {
 
   
  }
  });
  

}


function getPaymentDetails(viewid,e)
{
    

  document.getElementById("content").innerHTML="<center><img style='opacity:0.4;'   src='dist/img/loader.gif' /><center>";    
    
  var dataString="salesid="+viewid;

  $.ajax({
    type: "POST",
    url: "Model/getPaymentDetails.php",
    data: dataString,
    cache: false,
    success: function(html) {
    
      document.getElementById("content").innerHTML = html;
    
    }
    });
}

$('#product_branch').change(function(){


  var dataString="stock_branchid="+$('#product_branch').val();
  $.ajax({
    type: "POST",
    url: "Model/getProductIdByStockBranchid.php",
    data: dataString,
    cache: false,
    success: function(html) {
      document.getElementById("product").value = html;
      $("#product").trigger('change');
    }
    });

});

$('#product_warehouse').change(function(){

  var dataString="stock_warehouseid="+$('#product_warehouse').val();
  $.ajax({
    type: "POST",
    url: "Model/getProductIdByStockWarehouseid.php",
    data: dataString,
    cache: false,
    success: function(html) {
      document.getElementById("product").value = html;
      $("#product").trigger('change');
    }
    });

});

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
  
  getstock();
  
  $('#quantity').val(1);
  
  $('#unitprice').val(msrp_prise);
  $('#discountdetailpercent').val(percentage);
  var subuserid=$('#subuserids').val();

if(subuserid>0){
    $('#discountdetailpercent').val(0);
}
  
  $('#discountdetailpercent').trigger('change');
   
}
  
  }
  
  });
    
});
