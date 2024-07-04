
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
                tableBody += '<th>Customer</th>';
                tableBody += '<th>Sales Order</th>';
                tableBody += '<th>Floor Date</th>';
                tableBody += '<th>Promise Date</th>';
                tableBody += '<th>Adjusted Promise Date</th>';
               

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
                   // tableBody += '<td>' + row.U_NAME + '</td>';
                   tableBody += '<td>' + row.Sales_Order + '</td>';
                   tableBody += '<td>' + row.Floor_Date + '</td>';
                   tableBody += '<td>' + row.Promise_Date + '</td>';
                   tableBody += '<td>' + row.Adjusted_Promise_Date+ '</td>';
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
        $('#myModal_1').css('display', 'none');
    });
   
    function export_to_excel(tableID, filename = '') {
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        
        // Check if the table exists
        if (!tableSelect) {
            console.error("Table not found: " + tableID);
            return;
        }
        
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
        
        // Cleanup HTML if necessary
        tableHTML = tableHTML.replace(/%20id="inteltotal"%20class="rh_med"/g, '');
        tableHTML = tableHTML.replace(/<button%20id="inner_A[0-9];"><\/button>/g, '');
        tableHTML = tableHTML.replace(/class="comment_r_inactive">">Comment<\/td><td%20colspan="15">/g, '');
        tableHTML = tableHTML.replace(/%20id="td_stringdata"/g, '');
        tableHTML = tableHTML.replace(/<button%20class="comment_button%20"%20comments="/g, '');
        tableHTML = tableHTML.replace(/<button%20class="comment_button%20has_comment"%20comments="/g, '');
        tableHTML = tableHTML.replace(/"><\/button>/g, '');
        tableHTML = tableHTML.replace(/#/gi, ''); 
    
        // Specify file name
        var today = new Date();
        var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
        filename = filename ? filename + '.xls' : 'Intel Total ' + date + '.xls';
    
        // Create download link element
        downloadLink = document.createElement("a");
    
        document.body.appendChild(downloadLink);
    
        if (navigator.msSaveOrOpenBlob) {
            var blob = new Blob(['\ufeff', tableHTML], { type: dataType });
            navigator.msSaveOrOpenBlob(blob, filename);
        } else {
            // Create a link to the file
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
            // Setting the file name
            downloadLink.download = filename;
    
            // Triggering the function
            downloadLink.click();
        }
    
        // Remove the download link from the DOM
        document.body.removeChild(downloadLink);
    }
    
    // Event listener to close the modal
    document.querySelector('.close').onclick = function() {
        document.getElementById('myModal_1').style.display = "none";
    };
    
  


    function toggleTable_Year() {
        //alert('hell');
        $.ajax({
            type: "POST",
            url: "SQL_released_todate_details.php",
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
                //tableBody += '<th>PrOdOrder</th>';
                tableBody += '<th>Process Order</th>';
               // tableBody += '<th>Sales Order</th>';
                //tableBody += '<th>Customer</th>';
                //tableBody += '<th>Project</th>';

               // tableBody += '<th>Item Group Name</th>';
                tableBody += '<th>PlannedHours</th>';
                tableBody += '<th></th>';

               // tableBody += '<th>ItemName</th>';
               // tableBody += '<th>PG1</th>';
               

              //  tableBody += '<th>PG2</th>';
               
               // tableBody += '<th>Pg3</th>';
               // tableBody += '<th>Released Date</th>';
               // tableBody += '<th>Released Year</th>';

                //tableBody += '<th>Engineer</th>';
                //tableBody += '<th>Sales Person</th>';
                tableBody += '</tr>';
                tableBody += '</thead>';

                // Generate table rows
                tableBody += '<tbody>';
                response[0].forEach(function(row) {
                    tableBody += '<tr>';
                   //tableBody += '<td>' + row['Production Order'] + '</td>';
                    tableBody += '<td>' + row['Process Order'] + '</td>';
//tableBody += '<td>' + row['Sales Order'] + '</td>';
                  //  tableBody += '<td>' + row.Customer + '</td>';
                 //   tableBody += '<td>' + row.U_Client + '</td>';

                   // tableBody += '<td>' + row.U_NAME + '</td>';
                  // tableBody += '<td>' + row.ItmsGrpNam + '</td>';
                   tableBody += '<td>' + row['Process Planned Time'] + '</td>';
                  // tableBody += '<td>' + row.ItemName + '</td>';
                   //tableBody += '<td>' + row.Adjusted_Promise_Date+ '</td>';
                   // tableBody += '<td>' + row.U_Product_Group_One + '</td>';
                    
                    //tableBody += '<td>' + row.U_Product_Group_Two + '</td>';
                   // tableBody += '<td>' + row.U_Product_Group_Three + '</td>';
                    //tableBody += '<td>' + row['Released Date'] + '</td>';
                   // tableBody += '<td>' + row['Released Year'] + '</td>';
                    //tableBody += '<td>' + row['Sales Person'] + '</td>';
                    tableBody += '</tr>';
                });
                tableBody += '</tbody>';
    
                // Append the table body to the modal table
                $('#modalTable_1').html(tableBody);
    
                // Display the modal
                $('#myModal_1').css('display', 'block');




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
