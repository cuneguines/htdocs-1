function toggleTable_operator_details() {
//console.log(data);
    $.ajax({
      type: "POST",
        url: "SQL_operator_details.php",
        cache: false,
        dataType: "json",
        // Pass the data parameter here
        success: function (response) {
        var tableBody = "";
        console.log(response);
        response[0].forEach(function (row) {
          // Calculate the percentage with proper formatting
          let percentage = (row["Total Hours from Subquery"] / row["Planned_Lab"]) * 100;
          let formattedPercentage = (isNaN(percentage) ? 0 : percentage.toFixed(2)) + '%';
      
          // Generate table row
          tableBody += "<tr>";
          tableBody += '<td style="width:5%">' + (row["Year"] || '') + "</td>"; // Year
          tableBody += '<td style="width:5%">' + (row["Week"] || '') + "</td>"; // Week
          tableBody += '<td style="width:5%">' + (row["created"] || '') + "</td>"; // Created
          tableBody += '<td style="width:5%">' + (row["UserId"] || '') + "</td>"; // UserId
          tableBody += '<td style="width:5%">' + (row["Employee"] || '') + "</td>"; // Employee
          tableBody += '<td style="width:10%">' + (row["itemname"] || '') + "</td>"; // Item Name
          tableBody += '<td style="width:10%">' + (row["Labour Name"] || '') + "</td>"; // Labour Name
          tableBody += '<td style="width:10%">' + (row["Hours Booked"] || '') + "</td>"; // Hours Booked
          tableBody += "</tr>";
          
          
      });
      // Append the table body to the modal table
      $("#anotherModalTable tbody").html(tableBody);
  
      // Display the modal
      $("#anotherModal").css("display", "block");
  },
  error: function () {
      alert("Error");
  },
    });
  }
  
  $(document).on("click", ".close", function () {
    $("#myModal").css("display", "none");
    $("#anotherModal").css("display", "none");
  });
  
  function export_to_excel(tableID, filename = "") {
    var downloadLink;
    var dataType = "application/vnd.ms-excel";
    var tableSelect = document.getElementById(tableID);
  
    // Check if the table exists
    if (!tableSelect) {
      console.error("Table not found: " + tableID);
      return;
    }
  
    var tableHTML = tableSelect.outerHTML.replace(/ /g, "%20");
  
    // Cleanup HTML if necessary
    tableHTML = tableHTML.replace(/%20id="inteltotal"%20class="rh_med"/g, "");
    tableHTML = tableHTML.replace(/<button%20id="inner_A[0-9];"><\/button>/g, "");
    tableHTML = tableHTML.replace(
      /class="comment_r_inactive">">Comment<\/td><td%20colspan="15">/g,
      ""
    );
    tableHTML = tableHTML.replace(/%20id="td_stringdata"/g, "");
    tableHTML = tableHTML.replace(
      /<button%20class="comment_button%20"%20comments="/g,
      ""
    );
    tableHTML = tableHTML.replace(
      /<button%20class="comment_button%20has_comment"%20comments="/g,
      ""
    );
    tableHTML = tableHTML.replace(/"><\/button>/g, "");
    tableHTML = tableHTML.replace(/#/gi, "");
  
    // Specify file name
    var today = new Date();
    var date =
      today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate();
    filename = filename ? filename + ".xls" : "NON PRODUCTIVE " + date + ".xls";
  
    // Create download link element
    downloadLink = document.createElement("a");
  
    document.body.appendChild(downloadLink);
  
    if (navigator.msSaveOrOpenBlob) {
      var blob = new Blob(["\ufeff", tableHTML], { type: dataType });
      navigator.msSaveOrOpenBlob(blob, filename);
    } else {
      // Create a link to the file
      downloadLink.href = "data:" + dataType + ", " + tableHTML;
  
      // Setting the file name
      downloadLink.download = filename;
  
      // Triggering the function
      downloadLink.click();
    }
  
    // Remove the download link from the DOM
    document.body.removeChild(downloadLink);
  }
  