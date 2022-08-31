function export_to_excel(tableID, filename = '')
{   
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace( / /g, '%20');
    tableHTML = tableHTML.replace(/color:white/g, '');
    tableHTML = tableHTML.replace(/#/g, '');

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