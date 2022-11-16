function export_pre_production_table_to_excel(tableID)
{
        // CREATE DOWNLOADLINK AND SELECT TABLE
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML
        
        tableHTML = tableHTML.replace( /€/g, '%20');                   
        tableHTML = tableHTML.replace( / /g, '%20');
        tableHTML = tableHTML.replace( /#/g, '%20');
        tableHTML = tableHTML.replace( /display:none;/g, '%20');

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