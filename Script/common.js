
$('input[type="file"]').change(function(e) {
  var fileName = e.target.files[0].name;
  $("#image_name").val(fileName);

  var reader = new FileReader();
  reader.onload = function(e) {
  // get loaded data and render thumbnail.
  document.getElementById("preview").src = e.target.result;
  };
  // read the image file as a data URL.
  reader.readAsDataURL(this.files[0]);
});

var image_name="";

$("#image-form").on("submit", function() {
  $.ajax({
    type: "POST",
    url: "imageUpload/ajax/action.ajax.php",
    data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
    contentType: false, // The content type used when sending data to the server.
    cache: false, // To unable request pages to be cached
    processData: false, // To send DOMDocument or non processed data file it is set to false
    async:false,
    success: function(data) {

      image_name=data;
   
    },
    error: function(data) {
    }
  });

  });


$(document).ready(function() {
    // Add new row functionality
    $('.dynamic-table').on('click', '.add-row', function() {
        var row = $(this).closest('tr').clone();
        row.find('input').val(''); // Clear input values
        $(this).closest('tbody').append(row);
    });

    // Delete row functionality
    $('.dynamic-table').on('click', '.delete-row', function() {
        if ($(this).closest('tbody').find('tr').length > 1) {
            $(this).closest('tr').remove();
        }
    });

    // Calculate sum for columns
    $('.dynamic-table').on('input', 'input[name="salary"]', function() {
        var sum = 0;
        $('input[name="salary"]').each(function() {
            sum += parseFloat($(this).val()) || 0;
        });
        $('.sum').val(sum);
    });
});
