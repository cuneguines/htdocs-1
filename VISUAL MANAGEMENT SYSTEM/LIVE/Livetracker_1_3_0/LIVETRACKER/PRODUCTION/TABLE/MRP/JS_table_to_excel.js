function export_to_excel(tableID, filename = '')
{
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace( / /g, '%20');
        tableHTML = tableHTML.replace(/%20id="production_table"%20class="sticky"/g, '');
        tableHTML = tableHTML.replace(/%20class="table_header"/g, '');
        tableHTML = tableHTML.replace(/<button%20id="inner_A[0-9];"><[/]button>/g, '');
        tableHTML = tableHTML.replace(/<td%20style="background-color:#454545;color:white;/g, '');
        tableHTML = tableHTML.replace(/<form%20action=".[/]BASE_production_specific_sales_order.php"%20method="post"><input%20id="so_button"%20type="submit"%20name="so"%20value="/g, '');
        tableHTML = tableHTML.replace(/"><[/]form>/g, '');
        tableHTML = tableHTML.replace(/class="comment_r_inactive">">Comment<[/]td><td%20colspan="15">/g, '');
        tableHTML = tableHTML.replace(/%20id="td_stringdata"/g, '');
        tableHTML = tableHTML.replace(/<button%20class="comment_button%20"%20comments="/g, '');
        tableHTML = tableHTML.replace(/<button%20class="comment_button%20has_comment"%20comments="/g, '');
        tableHTML = tableHTML.replace(/"><[/]button>/g, '');
        tableHTML = tableHTML.replace(/#/gi, '');
        
        

        // Specify file name
        var today = new Date();
        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
        filename = filename?filename+'.xls':'MRP_'+date+'.xls';

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