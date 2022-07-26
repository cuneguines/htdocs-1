function export_to_excel(tableID, filename = ''){
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace( / /g, '%20');
        tableHTML = tableHTML.replace(/%20id="intel_production_table"%20class="sticky"%20style="font-size:12px;"/g, '');
        tableHTML = tableHTML.replace(/%20class="table_header"/g, '');
        tableHTML = tableHTML.replace(/%20style="font-size:10px;"%20width="2%"/g, '');
        tableHTML = tableHTML.replace(/%20style="font-size:10px;"%20width="4%"/g, '');
        tableHTML = tableHTML.replace(/%20style="font-size:10px;"%20width="5%"/g, '');
        tableHTML = tableHTML.replace(/%20style="font-size:10px;"%20width="6%"/g, '');
        tableHTML = tableHTML.replace(/%20style="font-size:10px;"%20width="7%"/g, '');
        tableHTML = tableHTML.replace(/%20style="font-size:10px;"%20width="10%"/g, '');
        tableHTML = tableHTML.replace(/style="font-weight:bold;"/g, '');
        tableHTML = tableHTML.replace(/%20id="td_stringdata"%20style="font-weight:bold;%20padding-left:10px;"/g, '');
        tableHTML = tableHTML.replace(/%20class="labremaining"/g, '');
        tableHTML = tableHTML.replace(/%20date="{0-9}"/g, '');
        tableHTML = tableHTML.replace(/style="display:none;"/g, '');

        // Specify file name
        var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        filename = filename?filename+'.xls':'Pre_Production_Schedule_'+date+'.xls';

        // Create download link element
        downloadLink = document.createElement("a");

        document.body.appendChild(downloadLink);

        if(navigator.msSaveOrOpenBlob){
            var blob = new Blob(['\ufeff', tableHTML], {type: dataType});
            navigator.msSaveOrOpenBlob( blob, filename);
        }
        else{
            // Create a link to the file
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

            // Setting the file name
            downloadLink.download = filename;
                
            //triggering the function
            downloadLink.click();
        }
}

  