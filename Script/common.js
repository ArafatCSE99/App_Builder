
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

});

function reinitializeTableEvents() {
  if (!jQuery._data(document, 'events') || 
      !jQuery._data(document, 'events').click ||
      !jQuery._data(document, 'events').click.some(e => e.selector === '.dynamic-table .add-row')) {

      // Add new row functionality
      $(document).on('click', '.dynamic-table .add-row', function() {
          var row = $(this).closest('tr').clone();
          row.find('input').val(''); // Clear input values
          $(this).closest('tbody').append(row);
      });
  }

  if (!jQuery._data(document, 'events') || 
      !jQuery._data(document, 'events').click ||
      !jQuery._data(document, 'events').click.some(e => e.selector === '.dynamic-table .delete-row')) {

      // Delete row functionality
      $(document).on('click', '.dynamic-table .delete-row', function() {
          if ($(this).closest('tbody').find('tr').length > 1) {
              $(this).closest('tr').remove();
          }
      });
  }
}

function getTableData() {
  let tableData = {};

  // Loop through each row of the table
  $('.dynamic-table tbody tr').each(function (rowIndex) {
     let rowData = {};

     // Loop through each column's input/select in the row
     $(this).find('td').each(function () {
        let input = $(this).find('input, select');

        if (input.length) {
           let name = input.attr('name');
           let value = input.val();

           // Store the input's name (key) and value
           rowData[name] = value;
        }
     });

     // Add row data to the main tableData object
     tableData[rowIndex] = rowData;
  });

  return tableData;
}

/*
// Example usage:
$(document).ready(function () {
  // Bind to the button that adds rows or form submission as needed
  $('.add-row, .delete-row').click(function () {
     let data = getTableData();
     console.log(data); // Output the collected table data for debugging
  });
});
*/

function checkData()
{
     let data = getTableData();
     console.log(data); // Output the collected table data for debugging
}