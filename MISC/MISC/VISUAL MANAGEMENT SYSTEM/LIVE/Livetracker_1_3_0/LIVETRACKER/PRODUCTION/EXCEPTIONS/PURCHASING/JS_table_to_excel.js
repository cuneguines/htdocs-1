function export_to_excel(tableID, filename = '')
{
    // CREATE DOWNLOADLINK AND SELECT TABLE
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML;
    tableHTML = tableHTML.replace( / /g, '%20');
    tableHTML = tableHTML.replace(/background-color:#ff7a7a;/gi , '');
    tableHTML = tableHTML.replace(/background-color:#FF8C00;/gi , '');
    tableHTML = tableHTML.replace(/background-color:#99FF99;/gi , '');
    tableHTML = tableHTML.replace(/<button%20class="comment_button%20"%20comments="NO%20COMMENTS/g,'');
    tableHTML = tableHTML.replace(/<button%20class="comment_button%20has_comment"%20comments="/g,'');
    tableHTML = tableHTML.replace(/"><[/]button>/g, '');
    tableHTML = tableHTML.replace(/color:%20white/gi , '');
    tableHTML = tableHTML.replace(/#/gi, '');

    

    // GET TODAYS DATE AND NAME THE FILE WITH IT
    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    filename = filename?filename+'.xls':'Production_Schedule_'+date+'.xls';

    // CREATE DOWNLOAD OBJECT
    downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);

    if(navigator.msSaveOrOpenBlob)
    {
        var blob = new Blob(['\ufeff', tableHTML], {type: dataType});
        navigator.msSaveOrOpenBlob( blob, filename);
    }
    else
    {
        // CREATE LINK TO FILE
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
            // APPLYS NAME TO DOWNLOAD
        downloadLink.download = filename;
        //TRIGGERS DOWNLOAD
        downloadLink.click();
    }
}


function removeHtml2(str) {
    var result = '';
    var ignore = false;
    for (var i = 0; i < str.length; i++) {
      var c = str.charAt(i);
      switch (c) {
        case '?': ignore = true; break;
        case '~': ignore = false; break;
        default: if (!ignore) result += c;
      }
    }
    return result;
  }

  