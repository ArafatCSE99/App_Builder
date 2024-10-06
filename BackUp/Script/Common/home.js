
var Param="";

function getDropDownListByTableField(table,field,getFromId,SetToId,name)
{
var fieldValue=document.getElementById(getFromId).value;
var dataString = 'table='+table+'&field='+field+'&fieldValue=' + fieldValue+'&name='+name+'&Param='+Param;
// AJAX code to submit form.
$.ajax({
type: "POST",
url: "DB/Common/getDropDownListByTableField.php",
data: dataString,
cache: false,
async:false,
success: function(html) {
 document.getElementById(SetToId).innerHTML = html;
 Param="";
}
});
}
