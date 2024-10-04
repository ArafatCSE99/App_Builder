
$(document).ready(function(){
 
  adddata();
  adddata();
  adddata();
  adddata();
  adddata();


});  // End Document Ready ..........



function changefunctions(){


$("#detail td .productcode").change(function(){

  var row=$(this).closest('tr');
  var procode=row.find('input.productcode').val();   

    var dataString="code="+procode;
    
    $.ajax({
      type: "POST",
      url: "Model/getProductIdByCode.php",
      data: dataString,
      cache: false,
      success: function(html) {
        var proid=html*1;
        if(proid!=0){
          row.find('select.productid').val(proid).change();
          row.find('input.qty').val(1);
          
        // Focus on next  ,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,
          var focused=0;
          $('#detail tbody tr').each(function (i, row) {
            var $row = $(row);
            var code= $row.find('input.productcode').val();         
            if(code=='' && focused==0){
              $row.find('input.productcode').focus();
              focused=1;
            } 
        
          });
          //...................................................
        }
       
      }
      });

    
});



$("#detail td select.productid").change(function(){

  var row=$(this).closest('tr');
  getstockprice(row);

  

});



var stock=0;
var price=0;

function getstockprice(row)
{

   getstock(row);
   getprice(row);

}


function getstock(row){
 
  var dataString="productid="+row.find('select.productid').val();

  $.ajax({
  type: "POST",
  url: "Model/getstock.php",
  data: dataString,
  cache: false,
  async:false,
  success: function(html) {

    stock=html;

    if(stock==0){
      //alert('Sorry ! Product is Out of Stock ! !');
      row.find('input.qty').val(0);

    }
    
   
  }
  });

}


function getprice(row){

  var dataString="productid="+row.find('select.productid').val();

  $.ajax({
  type: "POST",
  url: "Model/getprice.php",
  data: dataString,
  cache: false,
  success: function(html) {

    price=html;
   
    row.find('input.unitprice').val(price*1);

    row.find('input.unitprice').trigger("change");
   
  }
  });

}




$("#detail td input.qty,.unitprice,.discountdetail").change(function(){
 
  var row=$(this).closest('tr');

  var quantity=row.find('input.qty').val();
  var unitprice=row.find('input.unitprice').val();
  var discountdetail=row.find('input.discountdetail').val();

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

  if(quantity>stock*1)
  {
    alert('Available Quantity '+stock);
    row.find('input.qty').val('');
    row.find('input.qty').focus();
  }
  else{

  var amount=quantity*unitprice;
  var totaldetail=amount-discountdetail;

  row.find('.amount').text(amount);
  row.find('.totaldetail').text(totaldetail);

  }

  

  calculate_total();


});



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


}  // End Change Functions ........................................


function adddata()
{
   var productid='';

   var productcode='<input type="text" class="form-control productcode" placeholder="Bar Code"></input>';

   var productname='';


   productname+='<select class="form-control clsselect2 productid" style="">';

   productname+='<option hidden="" value="">-- Select Product --</option>';

   // Get  All Products .......

   $.ajax({
    type: "POST",
    url: "Model/getAllProduct.php",
    data: "",
    cache: false,
    async:false,
    success: function(html) {
    
      var duce = jQuery.parseJSON(html);

var i;
for (i = 0; i < duce.length; ++i) {

  var proid = duce[i]["proid"];
  var procode = duce[i]["procode"];
  var pronm = duce[i]["pronm"];
  var proself = duce[i]["proself"];
  
  productname+='<option value='+proid+'>'+pronm+' '+proself+'</option>';
   
}
     


    
    }
    });

    productname+='<select>';


   // End Get Products .......

   var qty='<input type="number" class="form-control qty" placeholder="Quantity" value="1"></input>';
   var unitprice='<input type="number" class="form-control unitprice" placeholder="Unit Price" value="0"></input>';
   var amount='0';
   var discountdetail='<input type="number" class="form-control discountdetail" placeholder="Discount" value="0"></input>';;
   discountdetail=discountdetail==""?0:discountdetail;
   var totaldetail=0;

      var tabledata="<tr><td style='display:none;' class='detailid'>0</td><td style='text-align:center;' class='slno'></td><td style='display:none;' style='text-align:right;' class='productid'>"+productid+"</td><td class='productcode'>"+productcode+"</td><td class='productname'>"+productname+"</td><td class='qty'>"+qty+"</td><td class='unitprice'>"+unitprice+"</td><td class='amount'>"+amount+"</td><td class='discountdetail'>"+discountdetail+"</td><td class='totaldetail'>"+totaldetail+"</td>"
      +"<td class='text-center py-0 align-middle' style='text-align:center;'>"
      +"<div class='btn-group btn-group-sm'>"
      +"<a onclick=deletedetaildata(0,this,'sales_detail') id='deletebuttondetail' class='btn btn-danger'><i class='fas fa-trash'></i></a>"
      +"</div>"
      +"</td>"
      +"</tr>";
     
      $('#detail tbody').append(tabledata);
                   
      addslno();
      calculate_total(); 
      
      changefunctions();

  
      
      $(".clsselect2").select2({
        theme: "bootstrap"
      });
   
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

  $('#detail tbody tr').each(function (i, row) {
    var $row = $(row);   
    var totalamount=$row.find('.totaldetail').text();
    total=total+totalamount*1;
  });
 
  $('#total').text(total);

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


$("#paid").change(function(){
  
  calculate_total();
  
});


function savedata()
{ 
     
       var userid=$('#userid').val();

       var customerid=$('#customer').val();
       var sales_date=$('#sales_date').val();
       var note=$('#note').val();
       var total=$('#total').text();
       var paid=$('#paid').val();
       var due=$('#due').text();

       var count=0;
       $('#detail tbody tr').each(function (i, row) {
        
        count++;
    
      });

       if(customerid=="")
       {
           //alert('Please Select customer ! !');
           customerid=0;
       }
       
       if(count==0){
          alert('Please Add Product ! !');
       }
       else
       {

        if(id==0){
          var sql="INSERT INTO sales_master (userid,customerid,sales_date,total_price,paid,due,note) VALUES ("+userid+",'"+customerid+"','"+sales_date+"','"+total+"','"+paid+"','"+due+"','"+note+"')";
         }
         else{
          var sql = "UPDATE sales_master SET customerid='"+customerid+"',sales_date='"+sales_date+"',total_price='"+total+"',paid='"+paid+"',due='"+due+"',note='"+note+"' WHERE id="+id;
         }

         var returnsql="SELECT max(id) as id FROM sales_master WHERE userid="+userid;
        
         savemaster(sql,returnsql);
  
        
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
    var detailid=$row.find('.detailid').text();
    var productid=$row.find('select.productid').val();
    var qty=$row.find('input.qty').val();
    var unitprice=$row.find('input.unitprice').val();
    var discountdetail=$row.find('input.discountdetail').val();
    var totaldetail=$row.find('.totaldetail').text();

    //alert(detailid);

     if(detailid==0 && productid!="" && qty>0) {
      var sql="INSERT INTO sales_detail (userid,salesid,productid,quantity,unitprice,discount,total_price) VALUES ("+userid+",'"+masterid+"','"+productid+"','"+qty+"','"+unitprice+"','"+discountdetail+"','"+totaldetail+"')";
     }  
     else
     {
      
      // No chance to update . . . . . . . . . . . . . . . 
      //var sql="INSERT INTO sales_detail (userid,salesid,productid,quantity,unitprice,total_price) VALUES ("+userid+",'"+id+"','"+productid+"','"+qty+"','"+unitprice+"','"+amount+"')";

     }


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

    
  });

  

  PrintReceipt(masterid,'');

  getcontent(viewcontent);
  id=0;

}



function deletedetaildata(id,e,tablename)
{
  

var dataString="deletedid="+id+"&tablename="+tablename;

$.ajax({
type: "POST",
url: "Model/delete.php",
data: dataString,
cache: false,
success: function(html) {

 //alert(html);
 $(e).closest('tr').remove();
 
 calculate_total();
 addslno();
 
}
});

   

}



function PrintReceipt(viewid,e)
{
  var dataString="salesid="+viewid;

  $.ajax({
    type: "POST",
    url: "Model/getQuickSalesReceipt.php",
    data: dataString,
    cache: false,
    success: function(html) {
    
      showModal(html);
    
    }
    });
}



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



