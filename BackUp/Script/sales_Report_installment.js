 // Export PDF ....................................

 $("#print,#pdf").on("click", function() {
  exportPDF();
});

 function exportPDF()
 {
   // var printContents = document.getElementById('Report').innerHTML;
   // var originalContents = document.body.innerHTML;
   // document.body.innerHTML = printContents;
 
     $("#print,#pdf,#excel,.main-footer").hide();
      window.print();
     $("#print,#pdf,#excel,.main-footer").show();
 
   // document.body.innerHTML = originalContents; 
 
 }


 
 $("[id$=excel]").click(function(e) {
  window.open('data:application/vnd.ms-excel,' + encodeURIComponent( $('div[id$=section-to-print]').html()));
  e.preventDefault();
});


// set report parametesr .....

$(document).ready(function(){

  $('#s_ctg').hide();
  $('#s_code').hide();
  $('#s_model').hide();
  $('#s_name').hide();
  
});