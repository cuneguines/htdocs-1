
$(document).ready(function() {
  console.log($('.date_holder').text());
  $('.operator').text($('.date_holder').text());

});
function toggleTable() {
  $.ajax({
    type: "POST",
    url: "SQL_table_details.php",
    cache: false,
    dataType: "json",
    success: function (response) {
      var tableBody = "";
      console.log(response);
      response[0].forEach(function (row) {
        // Calculate the percentage with proper formatting
        let percentage = (row["Total Hours from Subquery"] / row["Planned_Lab"]) * 100;
        let formattedPercentage = (isNaN(percentage) ? 0 : percentage.toFixed(2)) + '%';
        let plannedLab = parseFloat(row["Planned_Lab"]) || 0;
        let totalHours = parseFloat(row["Total Hours from Subquery"]) || 0;
        let delta = plannedLab - totalHours;
        let formattedDelta = delta.toFixed(2);
        // Generate table row
        tableBody += "<tr>";
        tableBody += '<td style="width:5%">' + (row["PrOrder"] || '') + "</td>";
        tableBody += '<td style="width:5%">' + (row["SoNum"] || '') + "</td>";
        tableBody += '<td style="width:5%">' + (row["ItmsGrpNam"] || '') + "</td>";
       
        tableBody += '<td style="width:5%">' + (row["Itemname"] || '') + "</td>";
        tableBody += '<td style="width:5%">' + (row["EndProduct"] || '') + "</td>";
        tableBody += '<td style="width:5%">' + (row["CreateDate"] || '') + "</td>";
        tableBody += '<td style="width:5%">' + (row["Year"] || '') + "</td>";
        tableBody += '<td style="width:5%">' + (row["Month"] || '') + "</td>";
        tableBody += '<td style="width:5%">' + (row["Week"] || '') + "</td>";
        tableBody += '<td style="width:10%">' + (row["U_Product_Group_One"] || '') + "</td>";
        tableBody += '<td style="width:10%">' + (row["U_Product_Group_Two"] || '') + "</td>";
        tableBody += '<td style="width:10%">' + (row["U_Product_Group_Three"] || '') + "</td>";
        tableBody += '<td style="width:5%">' + (row["Status"] || '') + "</td>";
        tableBody += '<td style="width:10%">' + (row["Date of Last Entry"] || '') + "</td>";
        tableBody += '<td style="width:10%">' + (row["Total Hours from Subquery"] || '') + "</td>";
        tableBody += '<td style="width:10%">' + (row["Planned_Lab"] || '') + "</td>";
        tableBody += '<td style="width:10%">' + formattedDelta + "</td>";
        tableBody += '<td style="width:10%">' + formattedPercentage + "</td>";
        tableBody += "</tr>";
    });
    // Append the table body to the modal table
    $("#modalTable tbody").html(tableBody);

    // Display the modal
    $("#myModal").css("display", "block");
},
error: function () {
    alert("Error");
},
  });
}

$(document).on("click", ".close", function () {
  $("#myModal").css("display", "none");
  $("#myModal_1").css("display", "none");
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
