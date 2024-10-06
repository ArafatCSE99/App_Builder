function getRolePermission()
{
var roles=$('#roles').val();
var dataString="roles="+roles;
//alert(s_code);
$.ajax({
type: "POST",
url: "Model/getRolePermission.php",
data: dataString,
cache: false,
success: function(html) {

  $('.content').html(html);
 
}
});

}


function updateRolePermission(roleid,featureid,field,e)
{
   var flag=$(e).is(':checked')==true?1:0; 
   //alert(roleid+" "+featureid+" "+field+" "+flag);
   
var dataString="roleid="+roleid+"&featureid="+featureid+"&field="+field+"&flag="+flag;
//alert(s_code);
$.ajax({
type: "POST",
url: "Model/updateRolePermission.php",
data: dataString,
cache: false,
success: function(html) {
 
}
});

}