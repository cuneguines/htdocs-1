function toggleTable() {
  $.ajax({
    type: "POST",
    url: "SQL_table_details.php",
    cache: false,
    dataType: "json",
    success: function (response) {
      var tableBody = "";
      //console.log(response[0]).U_Product_Group_Three;
      response[0].forEach(function (row) {
        console.log(row.U_Product_Group_Three);
        tableBody += "<tr>";
        tableBody += '<td style="width:10%">' + row["Sales Order"] + "</td>";
        tableBody += '<td style="width:10%">' + row["Process Order"] + "</td>";
        tableBody += '<td style="width:10%">' + row.Status + "</td>";
        tableBody += '<td style="width:10%">' + row.ItemName + "</td>";
        tableBody += '<td style="width:10%">' + row.Customer + "</td>";
        tableBody += '<td style="width:10%">' + row.Project + "</td>";
        tableBody += '<td style="width:10%">' + row.EndProduct + "</td>";
        tableBody += '<td style="width:10%">' + row.ItmsGrpNam + "</td>";
        tableBody +=
          '<td style="width:10%">' + row.U_Product_Group_One + "</td>";
        tableBody +=
          '<td style="width:10%">' + row.U_Product_Group_Two + "</td>";
        tableBody +=
          '<td style="width:10%">' + row.U_Product_Group_Three + "</td>";
        tableBody +=
          '<td style="width:10%">' + row["Last Hour Booked"] + "</td>";
        tableBody += '<td style="width:10%">' + row.CreateDate + "</td>";
        tableBody += '<td style="width:10%">' + row.Year_Cr + "</td>";
        tableBody += '<td style="width:10%">' + row.Month_Cr + "</td>";
        tableBody += '<td style="width:10%">' + row.Week_Cr + "</td>";
        tableBody += '<td style="width:10%">' + row.CloseDate + "</td>";
        tableBody += '<td style="width:10%">' + row.Year_Cl + "</td>";
        tableBody += '<td style="width:10%">' + row.Month_Cl + "</td>";
        tableBody += '<td style="width:10%">' + row.Week_Cl + "</td>";
        tableBody +=
          '<td style="width:10%">' + row["Total Planned Time"] + "</td>";
        tableBody +=
          '<td style="width:10%">' + row["TOTAL_BOOKED_HRS"] + "</td>";
        //  tableBody += '<td style="width:10%">' + (row['TOTAL_BOOKED_HRS'] / row['Total Planned Hrs']).toFixed(2) + '</td>';
     

        // Calculate the percentage
        let percentage =
          (row["TOTAL_BOOKED_HRS"] / row["Total Planned Time"]) * 100;

        // Append the percentage with a percentage sign and format it to two decimal places
        tableBody +=
          '<td style="width:10%">' + percentage.toFixed(2) + "%</td>";
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
