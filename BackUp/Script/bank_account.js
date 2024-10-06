
function savedata()
{ 
       var account_no=$('#account_no').val();
       var bank_name=$('#bank_name').val();
       var account_title=$('#account_title').val();
       var branch_name=$('#branch_name').val();
       var account_type=$('#account_type').val();
       var branch_address=$('#branch_address').val();
       var phone_no=$('#phone_no').val();
       var starting_amount=$('#starting_amount').val();

       var userid=$('#userid').val();
       var companyid=$('#companyid').val();

       if(account_no=="" || bank_name=="" || account_type=="" || starting_amount=="")
       {
          alert('Please Insert Account No/Bank Name/Account Type/Startung Amount');
       }
       else{

       

       if(id==0){
        var sql="INSERT INTO bank_account (`userid`,companyid, `account_no`, `bank_name`, `account_title`, `branch_name`, `account_type`, `branch_address`, `phone_no`, `starting_amount`) VALUES ('"+userid+"','"+companyid+"','"+account_no+"','"+bank_name+"','"+account_title+"','"+branch_name+"','"+account_type+"','"+branch_address+"','"+phone_no+"','"+starting_amount+"')";
        //alert(sql);
       }
       else{
        var sql = "UPDATE bank_account SET account_no='"+account_no+"', bank_name='"+bank_name+"',account_title='"+account_title+"',branch_name='"+branch_name+"',account_type='"+account_type+"',branch_address='"+branch_address+"',phone_no='"+phone_no+"',starting_amount='"+starting_amount+"' WHERE id="+id;
       }
      
       save(sql);

       id=0;

       
       ScrollToTop();

      }
   
}

function updatedata(updateid,e)
{

  id=updateid;
  
  var row=$(e).closest('tr');

 
  
       var account_no=row.find('.account_no').text();  
       var bank_name=row.find('.bank_name').text(); 
       var account_title=row.find('.account_title').text(); 
       var branch_name=row.find('.branch_name').text(); 
       var account_type=row.find('.account_type').text(); 
       var branch_address=row.find('.branch_address').text(); 
       var phone_no=row.find('.phone_no').text(); 
       var starting_amount=row.find('.starting_amount').text(); 
  
       $('#account_no').val(account_no);
       $('#bank_name').val(bank_name);
       $('#account_title').val(account_title);
       $('#branch_name').val(branch_name);
       $('#account_type').val(account_type).change();
       $('#branch_address').val(branch_address);
       $('#phone_no').val(phone_no);
       $('#starting_amount').val(starting_amount);

  
  ScrollToBottom();

}



function getgroup()
{

var cls=document.getElementById("ddlclassid").value;

var dataString = 'clsid=' + cls;

// AJAX code to submit form.
$.ajax({
type: "POST",
url: "Model/getgroup.php",
data: dataString,
cache: false,
async:false,
success: function(html) {

 document.getElementById("rgn").innerHTML = html;
 
}
});


}