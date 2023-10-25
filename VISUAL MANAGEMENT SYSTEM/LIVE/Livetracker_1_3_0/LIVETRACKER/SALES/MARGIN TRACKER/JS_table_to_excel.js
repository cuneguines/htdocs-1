function export_to_excel(tableID) {
    // CREATE DOWNLOAD LINK AND SELECT TABLE
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);

    // CREATE EMPTY TABLE ELEMENT
    var visibleTable = document.createElement('table');

    // CLONE THE TABLE HEADER
    visibleTable.appendChild(tableSelect.getElementsByTagName('thead')[0].cloneNode(true));

    // CREATE TABLE BODY AND APPEND VISIBLE ROWS
    var tableBody = document.createElement('tbody');
    Array.from(tableSelect.getElementsByTagName('tbody')[0].getElementsByTagName('tr')).forEach(function(row) {
      if (row.style.display !== 'none') {
        tableBody.appendChild(row.cloneNode(true));
      }
    });
    visibleTable.appendChild(tableBody);

    // GET VISIBLE TABLE HTML
    var tableHTML = visibleTable.outerHTML;

    // REMOVE UNNECESSARY ATTRIBUTES AND STYLES
    tableHTML = tableHTML.replace(/<input[^>]*>/gi, '');
    tableHTML = tableHTML.replace(/<\/?button[^>]*>/gi, '');
    tableHTML = tableHTML.replace(/style="[^"]*?"/gi, '');

    // GET TODAY'S DATE AND NAME THE FILE WITH IT
    var today = new Date();
    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
    var filename = 'Sales_Margin' + date + '.xls';

    // CREATE DOWNLOAD OBJECT
    downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);

    if (navigator.msSaveOrOpenBlob) {
      // IE-specific code
      var blob = new Blob(['\ufeff', tableHTML], { type: dataType });
      navigator.msSaveOrOpenBlob(blob, filename);
    } else {
      // CREATE LINK TO FILE
      downloadLink.href = 'data:' + dataType + ', ' + encodeURIComponent(tableHTML);
      // SET NAME TO DOWNLOAD
      downloadLink.download = filename;
      // TRIGGER DOWNLOAD
      downloadLink.click();
    }
  }