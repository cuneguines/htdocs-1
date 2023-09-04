function export_to_excel(tableID, filename = '')
{
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace( / /g, '%20');
        tableHTML = tableHTML.replace(/style="background-color:lightGreen;border:none;/g, '');
        tableHTML = tableHTML.replace(/type="head"/g, '');
        tableHTML = tableHTML.replace(/background-color:lightCoral;border:none;/g,'');
        tableHTML = tableHTML.replace(/background-color:#DCDCDC;/g,'');
        tableHTML = tableHTML.replace(/border-top:1px/g,  '');
        tableHTML = tableHTML.replace(/solid/g,  '');
        tableHTML = tableHTML.replace(/#000000;/g,  '');
        tableHTML = tableHTML.replace(/=""/g,  '');

        // REMOVE DETAIL FROM TABLE HEADERS
        tableHTML = tableHTML.replace(/<th.*%">/g, "<th>");

        // RMOVE HEADERS FOR COLUMNS NOT WANTED IN EXPORT
        tableHTML = tableHTML.replaceAll(/<th>Collapse<[/]th>/g, '');
        tableHTML = tableHTML.replaceAll(/<th>Fab%20Status<[/]th>/g, '');
        tableHTML = tableHTML.replaceAll(/<th>Floor%20Date<[/]th>/g, '');
        tableHTML = tableHTML.replaceAll(/<th>Promise%20Date<[/]th>/g, '');
        tableHTML = tableHTML.replaceAll(/<th>Planned%20Lab<[/]th>/g, '');
        tableHTML = tableHTML.replaceAll(/<th>UTM<[/]th>/g, '');
        tableHTML = tableHTML.replaceAll(/<th>Process%20Order<[/]th>/g, '');
        tableHTML = tableHTML.replaceAll(/<th>Production%20Order<[/]th>/g, '');
        tableHTML = tableHTML.replaceAll(/<th>ItemCode<[/]th>/g, '');
        tableHTML = tableHTML.replaceAll(/<th>Comments<[/]th>/g, '');

        // REMOVE DATA FROM COLUMNS NOT WANTED IN EXPORT
        tableHTML = tableHTML.replaceAll(/<td%20excludefs>.*<[/]td><!--endexcludefs-->/g, '');
        tableHTML = tableHTML.replaceAll(/<td%20excludefd>.*<[/]td><!--endexcludefd-->/g, '');
        tableHTML = tableHTML.replaceAll(/<td%20excludepd>.*<[/]td><!--endexcludepd-->/g, '');
        tableHTML = tableHTML.replaceAll(/<td%20excludepl>.*<[/]td><!--endexcludepl-->/g, '');
        tableHTML = tableHTML.replaceAll(/<td%20excludeutm>.*<[/]td><!--endexcludeutm-->/g, '');
        tableHTML = tableHTML.replaceAll(/<td%20excludeproo>.*<[/]td><!--endexcludeproo-->/g, '');
        tableHTML = tableHTML.replaceAll(/<td%20excludeprdo>.*<[/]td><!--endexcludeprdo-->/g, '');
        tableHTML = tableHTML.replaceAll(/<td%20excludeitmcd>.*<[/]td><!--endexcludeitmcd-->/g, '');
        tableHTML = tableHTML.replaceAll(/<td%20excludecom.*<[/]td><!--endexcludecom-->/g, '');

        // REMOVE BUTTON FROM TABLE WIH SPECIFIC START AND END POSITION
        tableHTML = tableHTML.replaceAll(/<td%20class="saleso_btn_head_td">.*<[/]td><!--endexcludebtn-->/g, '');
        tableHTML = tableHTML.replaceAll(/<td>.*<[/]td><!--endexcludebtn-->/g, '');
        tableHTML = tableHTML.replaceAll(/#/g, '');


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