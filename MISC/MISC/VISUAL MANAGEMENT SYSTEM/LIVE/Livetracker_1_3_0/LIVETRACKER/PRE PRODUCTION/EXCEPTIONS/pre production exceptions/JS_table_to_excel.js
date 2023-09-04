function export_to_excel(tableID)
{
        // CREATE DOWNLOADLINK AND SELECT TABLE
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML

        // REMOVE <forms>,<buttons> AND COMMENT ROWS BY REPLACING THE FIRST FEW CHARS OF THAT PARTITION THAT ARE NOT SEEN ELSEWHERE IN THE PAGE WITH '?' AND '~' FOR  SET OF UINIQUE CHARS AT THE END
        tableHTML = tableHTML.replace(/<[/]td><[/]tr><tr type="comment"/gi, '<td>?');           // START OF COMMENT ROW
        tableHTML = tableHTML.replace(/<td colspan="15" id="td_stringdata">/gi, '~');           // JUST BEFORE COMMENT STRING
        tableHTML = tableHTML.replace(/<th width="5%">Action<[/]th>/gi , '');                   // HEADER FOR ACTION BUTTON IS REMOVED
        tableHTML = tableHTML.replace(/<td><button/gi, '?');                                    // START OF BUTTON
        tableHTML = tableHTML.replace(/<[/]button><[/]td>/gi, '~');                             // END OF BUTTON
        tableHTML = tableHTML.replace( / /g, '%20');
        tableHTML = tableHTML.replace( /background-color:#f7FA64;/g, '%20');
        tableHTML = tableHTML.replace( /background-color:#FF8C00;/g, '%20');
        tableHTML = tableHTML.replace( /background-color:#99FF99;/g, '%20');
        
        
        

        tableHTML = removeHtml2(tableHTML);

        // GET TODAYS DATE AND NAME THE FILE WITH IT
        var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        filename = 'Pre_Production_Table_'+date+'.xls';

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