function export_to_excel(tableID)
{
        // CREATE DOWNLOADLINK AND SELECT TABLE
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML
        var tableHTML = tableSelect.outerHTML.replace( / /g, '%20');

        // REMOVE <forms>,<buttons> AND COMMENT ROWS BY REPLACING THE FIRST FEW CHARS OF THAT PARTITION THAT ARE NOT SEEN ELSEWHERE IN THE PAGE WITH '?' AND '~' FOR  SET OF UINIQUE CHARS AT THE END
        tableHTML = tableHTML.replace(/<th width="5%">Action<[/]th>/gi , '');                   // HEADER FOR ACTION BUTTON IS REMOVED
        tableHTML = tableHTML.replace(/<button%20class="comment_button%20"%20comments="/g,'');
        tableHTML = tableHTML.replace(/<button%20class="comment_button%20has_comment"%20comments="/g,'');
        tableHTML = tableHTML.replace(/"><[/]button>/g, '');
        tableHTML = tableHTML.replace(/#/gi, '');

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