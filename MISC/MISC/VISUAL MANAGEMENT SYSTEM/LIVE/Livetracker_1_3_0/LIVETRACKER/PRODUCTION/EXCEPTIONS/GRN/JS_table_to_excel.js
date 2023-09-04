function export_to_excel(tableID, filename = ''){
    // CREATE DOWNLOADLINK AND SELECT TABLE
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML;
    tableHTML = tableHTML.replace( / /g, '%20');
    tableHTML = tableHTML.replace(/<button%20class="comment_button%20"%20comments="/g,'');
    tableHTML = tableHTML.replace(/<button%20class="comment_button%20has_comment"%20comments="/g,'');
    tableHTML = tableHTML.replace(/"><[/]button>/g, '');
    tableHTML = tableHTML.replace(/background-color:#ff7a7a;/gi , '');
    tableHTML = tableHTML.replace(/background-color:#FF8C00;/gi , '');
    tableHTML = tableHTML.replace(/background-color:#99FF99;/gi , '');
    tableHTML = tableHTML.replace(/color:%20white;/gi , '');
    tableHTML = tableHTML.replace(/#/gi, '');

    // GET TODAYS DATE AND NAME THE FILE WITH IT
    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    filename = filename?filename+'.xls':'Production_Schedule_'+date+'.xls';

    // CREATE DOWNLOAD OBJECT
    downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);

    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {type: dataType});
        navigator.msSaveOrOpenBlob( blob, filename);
    }
    else{
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        downloadLink.download = filename;
        downloadLink.click();
    }
}


  