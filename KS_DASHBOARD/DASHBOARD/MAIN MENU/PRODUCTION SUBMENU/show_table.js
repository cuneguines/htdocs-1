
    function toggleTable() {
        //alert('hell');
        $.ajax({
            type: "POST",
            url: "SQL_planned_hrs_details.php",
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
                tableBody += '<th>PrOrder</th>';
                tableBody += '<th>PlannedLab</th>';
                tableBody += '<th>ActualLab</th>';
                tableBody += '<th>Card Name</th>';
                tableBody += '<th>Project Manager</th>';
                tableBody += '<th>U Product Group One</th>';
               
                tableBody += '<th>U Product Group Two</th>';
                tableBody += '<th>U Product Group Three</th>';
                tableBody += '<th>Engineer</th>';
                tableBody += '<th>Sales Person</th>';
                tableBody += '</tr>';
                tableBody += '</thead>';

                // Generate table rows
                tableBody += '<tbody>';
                response[0].forEach(function(row) {
                    tableBody += '<tr>';
                    tableBody += '<td>' + row.PrOrder + '</td>';
                    tableBody += '<td>' + row.Planned_Lab + '</td>';
                    tableBody += '<td>' + row.Actual_Lab + '</td>';
                    tableBody += '<td>' + row.CardName + '</td>';
                    tableBody += '<td>' + row.U_NAME + '</td>';
                    tableBody += '<td>' + row.U_Product_Group_One + '</td>';
                    
                    tableBody += '<td>' + row.U_Product_Group_Two + '</td>';
                    tableBody += '<td>' + row.U_Product_Group_Three + '</td>';
                    tableBody += '<td>' + row.Engineer + '</td>';
                    tableBody += '<td>' + row['Sales Person'] + '</td>';
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
