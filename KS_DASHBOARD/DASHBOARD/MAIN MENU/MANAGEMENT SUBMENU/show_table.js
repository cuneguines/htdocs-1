
function toggleTable() {
    //alert('hell');
    $.ajax({
        type: "POST",
        url: "sql_delivered_sales.php",
        cache: false,
        
        dataType: 'json',
        success: function (response) {
            //$("#contact").html(response)
            //$("#contact-modal").modal('hide');
            console.log(response[0]);
            var tableBody = '';
            // Title row
           
            // Generate table headers
            tableBody += '<thead>';
            tableBody += '<tr>';
            tableBody += '<th>Sales Order</th>';
            tableBody += '<th>  Customer  </th>';
            tableBody += '<th>  Project        </th>';
           
            tableBody += '<th>Sales Order Qty</th>';
           
           
            tableBody += '<th>Delivery Note</th>';
            tableBody += '<th>Del Note Quatity</th>';
            tableBody += '<th>Del Note Line Value</th>';
            tableBody += '<th>Delivery Return Note</th>';
            tableBody += '<th>Ret Qty</th>';
            tableBody += '<th>Del Minus Ret Quantity</th>'; 
           
            tableBody += '<th>Del Minus Ret Value</th>'; 
            tableBody += '<th>Item Code</th>';
            tableBody += '<th>Code Create Date</th>';
            tableBody += '<th>Item Group Name</th>';
            tableBody += '<th>Product Group 1</th>';
            tableBody += '<th>Product Group 2	</th>';
            tableBody += '<th>Product Group 3</th>';
            tableBody += '<th>Project</th>';
            tableBody += '<th>Promise Date	</th>';
            tableBody += '<th>Delivery Note Date</th>';
            tableBody += '<th>Del Note Year	</th>';
            tableBody += '<th>Del Note Month</th>';
            tableBody += '<th>Del Note Week</th>';
            tableBody += '<th>Sales Person	</th>';
            tableBody += '<th>Market Sector	</th>';	
            tableBody += '<th>Business Unit</th>';
            tableBody += '<th>Engineer</th>';
            

            tableBody += '</tr>';
            tableBody += '</thead>';
          

            // Generate table rows
            tableBody += '<tbody>';
            response[0].forEach(function(row) {
                tableBody += '<tr>';
                tableBody += '<td>' + row['Sales Order'] + '</td>';
                tableBody += '<td>' + row['Customer'] + '</td>';
                tableBody += '<td>' + row['Project']+ '</td>';
                tableBody += '<td>' + parseFloat(row['Sales Order Qty']).toFixed(2) + '</td>';
                tableBody += '<td>' + row['Delivery Note'] + '</td>';
                tableBody += '<td>' + row['Del Note Quatity'] + '</td>';
                
                tableBody += '<td>' + row['Del Note Line Value'] + '</td>';
                tableBody += '<td>' + row['Delivery Return Note'] + '</td>';
                tableBody += '<td>' + row['Ret Qty'] + '</td>';
                tableBody += '<td>' + row['Del Minus Ret Quantity'] + '</td>';
                tableBody += '<td>' + row['Del Minus Ret Value'] + '</td>';
                tableBody += '<td>' + row['Item Code'] + '</td>';
                tableBody += '<td>' + row['Code Create Date'] + '</td>';
                tableBody += '<td>' + row['Item Group Name'] + '</td>';
                tableBody += '<td>' + row['Product Group 1'] + '</td>';
                tableBody += '<td>' + row['Product Group 2'] + '</td>';
                tableBody += '<td>' + row['Product Group 3'] + '</td>';
                tableBody += '<td>' + row['Project	Promise Date'] + '</td>';
                tableBody += '<td>' + row['Delivery Note Date'] + '</td>';
                tableBody += '<td>' + row['Del Note Year'] + '</td>';
                tableBody += '<td>' + row['Del Note Month'] + '</td>';
                tableBody += '<td>' + row['Del Note Week'] + '</td>';
                tableBody += '<td>' + row['Sales Person'] + '</td>';
                tableBody += '<td>' + row['Market Sector'] + '</td>';
                tableBody += '<td>' + row['Business Unit'] + '</td>';
                tableBody += '<td>' + row['Engineer'] + '</td>';


                tableBody += '</tr>';
            });
            tableBody += '</tbody>';

            // Append the table body to the modal table
            $('#modalTable').html(tableBody);

            // Display the modal
            $('#myModal').css('display', 'block');




            //length=response[0].length;

           /*  $.each(response[0], function () {
                $.each(this, function (key, val) {
                    if (key == 'U_Product_Group_Two') {
                        Product_item = val;
                        console.log(val);
                        productgp2.push(val);
                        console.log(productgp2[0]);
                        console.log(i);
                        // $(".nav-second-level")

                        //.append('<li value="' + Product_item + '"><a href="#"><span class="tab">' + Product_item + '</span></a> <ul class="nav-third-level" style="overflow-y:scroll"></ul></li>');

                    }


                });
            });





            //CODE TO FIND THE UNIQUE VALUES FROM THE AJAX CALL 
            for (var i = 0; i < productgp2.length; i++) {
                console.log(productgp2[i]);
            }
            var unique = productgp2.filter((v, i, a) => a.indexOf(v) === i);

            console.log(unique);
            for (var i = 0; i < unique.length; i++) {
                if (unique[i] != null) {
                    var option = new Option(unique[i], unique[i].replace(/[^A-Z0-9]/ig, ""));
                    $(option).html(unique[i]);
                    //Append the option to our Select element.
                    $("#select_product_group_two").append(option);

                }
            }

            //alert('input recieved');
            //location.reload(); */
            
        },
        error: function () {
            alert("Error");
        }
    });
    
}
$(document).on('click', '.close', function() {
    $('#myModal').css('display', 'none');
});
//Function to export table data to Excel
$(document).on('click', '#exportExcel', function() {
    var table = $('#modalTable');
    var rows = table.find('tr');
    var csv = [];
    rows.each(function(index, row) {
        var rowData = [];
        $(row).find('td, th').each(function() {
            rowData.push($(this).text());
        });
        csv.push(rowData.join(","));
    });
    var csvContent = csv.join("\n");

    // Create a temporary link element
    var downloadLink = document.createElement("a");
    downloadLink.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csvContent);
    downloadLink.download = "table_data.csv";

    // Trigger the download
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
});
