<!-- <!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Toggle Rows Example</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    table {
      border-collapse: collapse;
    }
    
    th, td {
      border: 1px solid black;
      padding: 5px;
      cursor: pointer;
    }
    
    .hidden {
      display: none;
    }
  </style>
</head>
<body>
  <table>
    <tr class="header-row">
      <th>Header 1</th>
      <th>Header 2</th>
    </tr>
    <tr class="data-row">
      <td>Value 1</td>
      <td>Details 1</td>
    </tr>
    <tr class="data-row">
      <td>Value 1</td>
      <td>Details 2</td>
    </tr>
    <tr class="data-row">
      <td>Value 2</td>
      <td>Details 3</td>
    </tr>
    <tr class="data-row hidden">
      <td>Value 2</td>
      <td>Details 4</td>
    </tr>
    <tr class="data-row">
      <td>Value 3</td>
      <td>Details 5</td>
    </tr>
  </table>
<script>
  $(document).ready(function() {
  $('.data-row').click(function() {
    var value = $(this).find('th:first-child').text();
    console.log(value);
    $('.data-row').each(function() {
      if ($(this).find('td:first-child').text() === 'Value 1') {
        $(this).toggleClass('hidden');
      }
    });
  });
});
<script>
</body>
</html>
 -->


 <!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Show/Hide Rows Example</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    table {
      border-collapse: collapse;
    }
    
    th, td {
      border: 1px solid black;
      padding: 5px;
      cursor: pointer;
    }
    
    .hidden {
      display: none;
    }
    
    .toggle-button {
      cursor: pointer;
      text-decoration: underline;
      color: blue;
    }
  </style>
</head>
<body>
  <table>
    <tr class="header-row">
      <th>Header 1</th>
      <th>Header 2</th>
    </tr>
    <tr class="data-row">
      <td>Value 1</td>
      <td>Details 1</td>
    </tr>
    <tr class="data-row">
      <td>Value 1</td>
      <td>Details 2</td>
    </tr>
    <tr class="data-row">
      <td>Value 2</td>
      <td>Details 3</td>
    </tr>
    <tr class="data-row">
      <td>Value 2</td>
      <td>Details 4</td>
    </tr>
    <tr class="data-row">
      <td>Value 3</td>
      <td>Details 5</td>
    </tr>
  </table>

  <script>
    $(document).ready(function() {
      var uniqueValues = [];
      
      // Find unique values in the first column
      $('.data-row').each(function() {
        var value = $(this).find('td:first-child').text();
        if (uniqueValues.indexOf(value) === -1) {
          uniqueValues.push(value);
        }
      });
      
      // Create toggle buttons for each unique value with more than one occurrence
      uniqueValues.forEach(function(value) {
        var rows = $('.data-row').filter(function() {
          return $(this).find('td:first-child').text() === value;
        });
        
        var rowCount = rows.length;
        
        if (rowCount > 1) {
          var toggleButton = $('<td class="toggle-cell"><span class="toggle-button">Toggle ' + value + '</span></td>');
          toggleButton.click(function() {
            rows.not(':first').toggleClass('hidden');
          });
          
          rows.eq(0).prepend(toggleButton);
        }
      });
    });
  </script>
</body>
</html>
 --> 
 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Show/Hide Rows Example</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    table {
      border-collapse: collapse;
    }
    
    th, td {
      border: 1px solid black;
      padding: 5px;
      cursor: pointer;
    }
    
    .hidden {
      display: none;
    }
    
    .toggle-button {
      cursor: pointer;
      text-decoration: underline;
      color: blue;
    }
  </style>
</head>
<body>
  <table>
    <tr class="header-row">
      <th>Header 1</th>
      <th>Header 2</th>
    </tr>
    <tr class="data-row">
      <td>Value 1</td>
      <td>Details 1</td>
    </tr>
    <tr class="data-row">
      <td>Value 1</td>
      <td>Details 2</td>
    </tr>
    <tr class="data-row">
      <td>Value 1</td>
      <td>Details 2</td>
    </tr>
    <tr class="data-row">
      <td>Value 1</td>
      <td>Details 2</td>
    </tr>
    <tr class="data-row">
      <td>Value 1</td>
      <td>Details 2</td>
    </tr>

    <tr class="data-row">
      <td>Value 2</td>
      <td>Details 3</td>
    </tr>
    <tr class="data-row">
      <td>Value 2</td>
      <td>Details 4</td>
    </tr>
    <tr class="data-row">
      <td>Value 3</td>
      <td>Details 5</td>
    </tr>
  </table>

  <script>
    $(document).ready(function() {
  var uniqueValues = [];
  
  // Find unique values in the first column
  $('.data-row').each(function() {
    var value = $(this).find('td:first-child').text();
    if (uniqueValues.indexOf(value) === -1) {
      uniqueValues.push(value);
    }
  });
  
  // Create toggle buttons for each unique value with more than one occurrence
  uniqueValues.forEach(function(value) {
    var rows = $('.data-row').filter(function() {
      return $(this).find('td:first-child').text() === value;
    });
    
    var rowCount = rows.length;
    
    if (rowCount > 1) {
      var toggleButton = $('<span class="toggle-button">Toggle ' + value + '</span>');
      toggleButton.click(function() {
        rows.not(':first').toggleClass('hidden');
      });
      
      rows.eq(0).find('td:first-child').prepend(toggleButton);
      rows.not(':first').addClass('hidden'); // Initially hide the rows
    }
  });
});

  </script>
</body>
</html>
