function export_to_excel(tableID, filename = '')
{
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace( / /g, '%20');
        tableHTML = tableHTML.replace(/style="background-color:#FF4D4D;"/g, '');
        tableHTML = tableHTML.replace(/style="background-color:#99FF99;"/g, '');
        tableHTML = tableHTML.replace(/style="background-color:#FF8C00;"/g, '');
        tableHTML = tableHTML.replace(/background-color:#DCDCDC;/g,  '');
        tableHTML = tableHTML.replace(/background-color:#454545;/g,  '');
        tableHTML = tableHTML.replace(/background-color:#f7FA64;/g,  '');
        tableHTML = tableHTML.replace(/background-color:purple;/g,  '');
        tableHTML = tableHTML.replace(/background-color:yellow;/g,  '');
        tableHTML = tableHTML.replace(/background-color:#4d79ff/g,  '');
        tableHTML = tableHTML.replace(/background-color:green;/g,  '');
        tableHTML = tableHTML.replace(/border-right:1px/g,  '');
        tableHTML = tableHTML.replace(/solid/g,  '');
        tableHTML = tableHTML.replace(/#/g,  '');
        tableHTML = tableHTML.replace(/color:white/g, '');


        // Specify file name

        var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        filename = filename?filename+'.xls':'Pre_Production_Schedule_'+date+'.xls';

        // Create download link element
        downloadLink = document.createElement("a");

        document.body.appendChild(downloadLink);

        if(navigator.msSaveOrOpenBlob)
        {
            var blob = new Blob(['\ufeff', tableHTML], {type: dataType});
            navigator.msSaveOrOpenBlob( blob, filename);
        }
        else
        {
            // Create a link to the file
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

            // Setting the file name
            downloadLink.download = filename;
        
            //triggering the function
            downloadLink.click();
        }
}

  