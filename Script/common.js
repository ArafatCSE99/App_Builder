
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
        //let input = $(this).find('input, select').not('[readonly]');
        let input = $(this).find('input, select');

        // Check if input or select exists and does not have the "display" attribute
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



function CalculateTotal(e, changeRowField, equation) {

  // Get the name attribute of the triggered input field
  let fieldName = e.name;
  console.log(fieldName);

  // Get the parent row of the triggered input field
  let row = $(e).closest('tr');

  // Dynamically calculate the result based on the provided equation
  let calculatedValue = equation.replace(/\b\w+\b/g, function(match) {
      // Find the input with the name matching each variable in the equation
      let input = row.find(`input[name='${match}']`);
      if (input.length && $.isNumeric(input.val())) {
          return parseFloat(input.val());
      } else {
          console.warn(`Field with name '${match}' not found or is not numeric`);
          return 0; // Default to 0 if the field is missing or not numeric
      }
  });

  try {
      // Evaluate the equation with the replaced values
      let result = eval(calculatedValue);
      row.find(`input[name='${changeRowField}']`).val(result);
  } catch (error) {
      console.error("Error evaluating the equation: ", error);
  }

  // Row equation Calculate Total Sum
  let total = 0;
  let isNumber = true;

  // Check if #nameSum element exists
  if ($("#" + fieldName + "Sum").length === 0) {
      console.warn("#nameSum element not found");
      return;
  }

  // Iterate over all input fields with the given name
  $(`input[name='${fieldName}']`).each(function() {
      let value = $(this).val();

      // Check if the input value is a number
      if ($.isNumeric(value)) {
          total += parseFloat(value);
      } else {
          isNumber = false;
      }
  });

  // Only update the total if all fields contain numbers
  if (isNumber) {
      $("#" + fieldName + "Sum").val(total);
  } else {
      console.warn("One or more fields contain non-numeric values");
  }
}



function CalculateTotalFooter(e, changeRowField, equation) {
  // Dynamically calculate the result based on the provided equation using IDs
  let calculatedValue = equation.replace(/\b\w+\b/g, function(match) {
      // Find the input with the specified ID
      let input = $(`#${match}`);
      if (input.length && $.isNumeric(input.val())) {
          return parseFloat(input.val());
      } else {
          console.warn(`Element with ID '${match}' not found or is not numeric`);
          return 0; // Default to 0 if the field is missing or not numeric
      }
  });

  try {
      // Evaluate the equation with the replaced values
      let result = eval(calculatedValue);
      $(`#${changeRowField}`).val(result); // Update the specified field by ID
  } catch (error) {
      console.error("Error evaluating the equation: ", error);
  }
}



/*
function CalculateTotal(e)
{
    var CurrentValue = $(e).val();
    alert(CurrentValue);
}
*/

/*
function CalculateTotal(e,changeRowField,equation) {

   // Row equation Calculate 

  // Get the name attribute of the triggered input field
  let fieldName =  e.name;//e.getSource().get("v.name"); //e.target.getAttribute('name'); //$(e.target).attr('name');
  console.log(fieldName);
  // Check if #nameSum element exists
  if ($("#"+fieldName+"Sum").length === 0) {
      console.warn("#nameSum element not found");
      return;
  }

  let total = 0;
  let isNumber = true;

  // Iterate over all input fields with the given name
  $(`input[name='${fieldName}']`).each(function() {
      let value = $(this).val();

      // Check if the input value is a number
      if ($.isNumeric(value)) {
          total += parseFloat(value);
      } else {
          isNumber = false;
      }
  });

  // Only update the total if all fields contain numbers
  if (isNumber) {
      $("#"+fieldName+"Sum").val(total);
  } else {
      console.warn("One or more fields contain non-numeric values");
  }
}
*/

function GetValueById(e, onchangeTable, onchangeField, onchangeSetField) {
  let id = $(e).val();
  if (!id) {
      alert("No ID provided");
      return;
  }

  $.ajax({
      url: 'API/GetValueByCondition.php',  // Update to the actual path of your API
      method: 'POST',
      data: {
        table: onchangeTable,
        field: onchangeField,
        conditionField: 'id',  // Assuming 'id' as the condition field
        conditionValue: id
      },
      dataType: 'json',
      success: function(response) {
              console.log(response.value);
              $(e).closest('tr').find(`input[name='${onchangeSetField}']`).val(response.value);
         
      },
      error: function(xhr, status, error) {
          console.error("Error fetching field value:", error);
      }
  });
}



  $("#print,#pdf").on("click", function() {
    exportPDF();
  });
  
   function exportPDF()
   {
       $("#print,#pdf,#excel,.main-footer").hide();
        window.print();
       $("#print,#pdf,#excel,.main-footer").show();   
   }


 $("[id$=excel]").click(function(e) {
    window.open('data:application/vnd.ms-excel,' + encodeURIComponent( $('div[id$=section-to-print]').html()));
    e.preventDefault();
  });
  