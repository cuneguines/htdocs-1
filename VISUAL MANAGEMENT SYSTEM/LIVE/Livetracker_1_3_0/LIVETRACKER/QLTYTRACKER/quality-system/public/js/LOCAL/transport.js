function generatePackingTransportFieldset(processOrder, username) {
    $("#responsible_person").val(username);
    return `
   
    `;
}

function toggleFileUpload(elementId, checkbox) {
    var uploadDiv = document.getElementById(elementId);
    if (checkbox.checked) {
        uploadDiv.style.display = "block";
    } else {
        uploadDiv.style.display = "none";
    }
}

function submitPackingTransportForm(processOrder) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };
    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }

    var formData = new FormData();
    formData.append('process_order_number', document.querySelector('[name="process_order_number_transport"]').value);
    formData.append('engineer', document.querySelector('[name="responsible_person"]').value);
    // Add Technical File if checkbox is checked
    if ($('[name="technical_file_checkbox"]').is(':checked')) {
        formData.append('technical_file', getFileName('technical_file'));
    }

    // Add Client Hand-over Documentation if checkbox is checked
    if ($('[name="client_handover_checkbox"]').is(':checked')) {
        formData.append('client_handover_documentation', getFileName('client_handover_documentation'));
    }
    // Add Secure Packing status
    formData.append('secure_packing', $('[name="secure_packing_checkbox"]').is(':checked') ? "Yes" : "No");

    var owners_transport = [];
    document.querySelectorAll('#transport tbody tr').forEach(function (row, index) {
        console.log('yes');
        console.log(index);
        if (index >= 0 && index<1) { // Skip the header row
            var owner = row.querySelector('[name="owner_transport"]').value || null;
            var ndt = row.querySelector('[name="ndttype_transport"]').value || null;
    console.log(owner);
    console.log(ndt);
            // Push the owner data to the array
            owners_transport.push({
                type: row.cells[0].innerText.trim(),
                owner: owner,
                ndt: ndt
            });

        // Append each owner and NDT as separate entries
        formData.append('owners_transport[' + (index - 1) + '][type]', row.cells[0].innerText.trim());
        formData.append('owners_transport[' + (index - 1) + '][owner]', owner);
        formData.append('owners_transport[' + (index - 1) + '][ndt]', ndt);
    }
});


    console.log(formData);

    // Send an AJAX request to the server
    $.ajax({
        url: "/submitPackingTransportForm",
        type: "POST",
        data: formData,
        headers: headers,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            alert("Packing and Transport form submitted successfully");
            // Optionally update the table or perform other actions
            $(myModal).hide();
        },
        error: function (error) {
            console.error("Error:", error);
            alert("Error submitting Packing and Transport form");
        },
    });

    var fileData = new FormData();
    var fileInputs = $('[type="file"]');

    // Add process_order_number to FormData
    fileData.append('process_order_number', document.querySelector('[name="process_order_number_transport"]').value);

    // Iterate over each file input and append files to FormData
    fileInputs.each(function (index, fileInput) {
        var files = fileInput.files;
        if (files.length > 0) {
            // Append each file to FormData
            $.each(files, function (i, file) {
                fileData.append(fileInput.name + '_' + i, file);
            });
        }
    });
    console.log(fileData);
    // Send an AJAX request for file uploads
    $.ajax({
        url: '/handleFileUploadPackingTransport',  // Update to your actual route
        type: 'POST',
        data: fileData,
        headers: headers,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            alert('Files uploaded successfully');
        },
        error: function (error) {
            console.error(error);
            alert('Error uploading files');
        }
    });
}
function generatePackingTransportFieldTable(processOrder) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: processOrder,
    };

    $.ajax({
        url: "/getPackingTransportDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML = generateHTMLFromResponse_for_packing_transport(response);

            $("#packingtransportFieldTable").html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        },
    });

    return `
        <div>To be Done</div>
    `;
}

function generateHTMLFromResponse_for_packing_transport_old(response) {
    console.log('yes');
    var html = '<table id="common_table" style="width:100%;">';
    html +=
        '<thead><tr><th style="width:5%;">ID</th><th style="width:25%;">Documentation Complete</th><th style="width:25%;">Secure Packing</th><th style="width:20%;">Responsible Person</th></tr></thead><tbody>';

    $.each(response, function (index, item) {
        html += "<tr>";
        html += "<td>" + item.id + "</td>";

        // Documentation Complete
        html += '<td>';
        if (item.documentation_complete === "Yes") {
            html += "Yes";
        } else {
            html += "No";
        }
        html += '</td>';

        // Secure Packing
        html += '<td>';
        if (item.secure_packing === "Yes") {
            html += "Yes";
        } else {
            html += "No";
        }
        html += '</td>';

        // Responsible Person
        html += "<td>" + (item.responsible_person ? item.responsible_person : "-") + "</td>";

        html += "</tr>";
    });

    html += "</tbody></table>";

    return html;
}
function generateHTMLFromResponse_for_packing_transport_old(response) {
    console.log('yes');
    var html = '<form id="packingTransportForm" class="packing-transport-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Packing and Transport</legend>';
    html+='<div style="width:97%">';
    $.each(response, function (index, item) {
        html += '<div class="packing_transport_item">';
        //html += '<label>ID:</label><br>';
        //html += '<input type="text" name="id" value="' + item.id + '" readonly><br>';

        // Documentation Complete
        html += '<div class="packing_transport_field">';
       // html += '<label>Documentation Complete:</label><br>';
        //html += '<input type="text" name="documentation_complete" value="' + (item.documentation_complete === "Yes" ? "Yes" : "No") + '" readonly><br>';
        html += '</div>';

        // Secure Packing
        html += '<div class="packing_transport_field">';
        html += '<label>Secure Packing:</label><br>';
        html+='<br>';
        html += '<input style="width:100%"type="text" name="secure_packing" value="' + (item.secure_packing === "Yes" ? "Yes" : "No") + '" readonly><br>';
        html += '</div>';
        html+='<br>';
        // Responsible Person
        html += '<div class="packing_transport_field">';
        html += '<label>Engineer:</label><br>';
        html+='<br>';
        html += '<input style="width:100%"type="text" name="responsible_person" value="' + (item.engineer ? item.engineer : "-") + '" readonly><br>';
        html += '</div>';
        html+='<br>';
        html += '</div>'; // Closing div for packing_transport_item
        html += '<hr>'; // Horizontal line for separation
    });
    html+='</div>';
    html += '</fieldset></form>';

    return html;
}
function generateHTMLFromResponse_for_packing_transport(response) {
    console.log('Generating packing and transport documentation...');
    var html = '<form id="packingTransportForm" class="packing-transport-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Packing and Transport</legend>';
    html += '<div style="width:97%">';
    
    // Start of the table
    html += '<table style="width:100%; border-collapse: collapse;">';
    
    html += '<tbody>';

    $.each(response, function (index, item) {

        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;"><label for="process_order_number">Process Order:</label></td>';
        html += '<td  colspan="4" style="border: 1px solid #ccc;"><input style="width:100%" type="text" id="process_order_number" name="process_order_number" value="' + item.process_order_number + '"></td>';

        html += '<tr>';



     
    html += '<tr>';
    html += '<th style="border: 1px solid #ccc; padding: 8px;">Tasks</th>';
    html += '<th style="border: 1px solid #ccc; padding: 8px;">Files</th>';
    html += '<th style="border: 1px solid #ccc; padding: 8px;">Owner</th>';
    html += '<th style="border: 1px solid #ccc; padding: 8px;">Action</th>';
    html += '</tr>';

     // Tasks column
html += '<td style="border: 1px solid #ccc; padding: 8px;">';
html += '<input type="checkbox" name="secure_packing" ' + (item.secure_packing === "Yes" ? 'checked' : 'disabled') + '>';
html += '<label style="display: inline-block;">Secure Packing:</label>';

html += '</td>';

        // Files column
        html += '<td style="border: 1px solid #ccc; padding: 8px;">';
        html += '<label>Documentation:</label><br>';
        if (item.documentation_file) {
            var filePath = 'http://vms/path_to_your_files/' + item.documentation_file;
            html += '<a href="' + filePath + '" target="_blank">' + item.documentation_file + '</a>';
        } else {
            html += '-';
        }
        html += '</td>';



        html += '<td id="owner_trans_1" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_trans_1" style="border: 1px solid #ccc;"></td>';
        fetchOwnerData_Transport(item.process_order_number, 'Secure Packing:', function(ownerData) {
            document.getElementById('owner_trans_1').innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_trans_1').innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        });
        // Owner and NDT columns
        html += '<tr>';
        html += '<td style="border: 1px solid #ccc; padding: 8px;" >'; // Combine Owner and NDT in one cell
        html += '<label>Engineer:</label><br>';
        html+='</td>';
        html += '<td colspan="3">';
        html += (item.engineer ? item.engineer : '-') + '<br>';
        html += '</td>';
      
       
        
        html += '</tr>'; // End of row

        // New row for NDT
        html += '<tr>';
        html += '<td style="border: 1px solid #ccc; padding: 8px;">';
        html += '<label>Comments:</label><br>';
        html += (item.comments ? item.comments : '-') + '<br>';
        html += '</td>';
        html += '</tr>'; // End of NDT row
    });

    html += '</tbody>';
    html += '</table>'; // End of table

    html += '</div>'; // Closing div
    html += '</fieldset></form>';

    return html;
}
function fetchOwnerData_Transport(id,Type,callback)
{

    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Replace with the actual CSRF token
        // Include other headers if needed
    };
    var formData = {
        process_order_number: id,
       Type:Type
    };
    
$.ajax({
    url: '/getOwnerData_transport',
    type: 'POST',
    data: formData,
    headers: headers,
    dataType: 'json',
    success: function (response) {

        console.log(response);
        
        callback(response.data[0]);
       
    },
    error: function (error) {
        // Handle the error response if needed
        console.error(error);
    }
});
}


function generatePackingTransportCompleteFieldset(processOrder, qualityStep, username) {
    var formData = {
        process_order_number: processOrder,
    };
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    $("#responsible_person_complete").val(username);

    $.ajax({
        url: "/getPackingTransportDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            if(response.data!=null)
                {
            var generatedHTML = generateCompleteHTMLFromResponse_for_packing_transport(response);
            $("#packingtransportCompleteFieldTable").html(generatedHTML);
                }
                else
                {
                    $("#packingtransportCompleteFieldTable").html('');
                }
        },
        error: function (error) {
            console.error(error);

        },
    });
}

function generateCompleteHTMLFromResponse_for_packing_transport(response) {
    var html = '<fieldset><legend>Packing and Transport Complete</legend>';
    html+='<div style="width:97%">';
    html += '<form id="packing_transport_complete_form">';



    
     // JavaScript code to generate and display UUID
     const uuidDisplay = document.getElementById('uuidDisplay_qlty');

     // Function to generate UUID
     function generateUUID() {
         return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
             const r = Math.random() * 16 | 0,
                 v = c === 'x' ? r : (r & 0x3 | 0x8);
             return v.toString(16);
         });
     }

     // Generate and display UUID
     const uuid = generateUUID();
     //uuidDisplay_qlty.textContent =uuid;
    
       // html += '<label>ID: ' + item.ID + '</label><br>';
    $.each(response, function (index, item) {

        html += '<form id="quality_complete_form">';

    html += '<div name="uuidDisplay_qlty" id="uuidDisplay_qlty">' + uuid + '</div>';
        html += '<div class="quality_item">';
        html += '<div class="packing_transport_item">';
      //  html += '<label>ID: ' + item.id + '</label><br>';
        html += '<div class="packing_transport_item">';
        html += '<label>Process Order: ' + item.process_order_number + '</label><br>';
        html += '<div class="packing_transport_item">';
        html += '<input type="hidden" name="process_order_number_pt" value="' + item.process_order_number + '"><br>';
        // Documentation Complete
        /* html += '<div class="packing_transport_field">';
        html +=
            '<label>Documentation Complete:</label>' +
            (item.documentation_complete === "Yes" ?
                '<input type="checkbox" id="documentation_complete" name="documentation_complete">' :
                '<input type="checkbox" id="documentation_complete" name="documentation_complete" disabled>') +
            '</div><br>'; */

        // Secure Packing
        html += '<div class="packing_transport_field">';
        html +=
            '<label>Secure Packing:</label>' +
            (item.secure_packing === "Yes" ?
                '<input type="checkbox" id="secure_packing_c" name="secure_packing_c" >' :
                '<input type="checkbox" id="secure_packing_c" name="secure_packing_c" disabled>') +
            '</div><br>';

        // Responsible Person
        html += '<div class="packing_transport_field">';
        html +=
            '<label>Responsible Person:</label>' +
            '<input style="width:100%"type="text" name="responsible_person_complete" value="' + userName + '">' +
            '</div><br>';

        // Comments
        html += '<div class="packing_transport_field">';
        html +=
            '<label>Comments:</label>' +
            '<input style="width:100%"type="text" name="comments_packing_transport" value="' + item.comments + '">' +
            '</div><br>';

        // Added Status dropdown
        html += '<div class="packing_transport_field">';
        html +=
            '<label>Status:</label>' +
            '<select style="width:100%"name="status">' +
            '<option value="partially_completed">Partially Completed</option>' +
            '<option value="completed">Completed</option>' +
            '</select>' +
            '</div><br>';

        // Added Quantity input box
        html += '<div class="packing_transport_field">';
        // Field for Quantity
        html += '<label>Quantity:</label>';
        html += '<input style="width:100%"type="number" name="quantity" value="' + item.quantity + '">';
        html += '</div><br>';

        // Added Photos Attached checkbox
        html += '<div class="packing_transport_field">';
        html +=
            '<label>Photos Attached:</label>' +
           
                '<input type="checkbox" id="photos_attached" name="photos_attached">' 
                
            '</div><br>';
            html+='<div>     <br></div>';

        html += '</div>'; // Closing div for packing_transport_item

        html += '<div class="packing_transport_field">';
        html +=
            '<label>Upload Images:</label>' +
            '<input type="file" id="InputImages"name="packing_transport_field_images" multiple>' +
            '</div><br>';

        // Comments
        html += '<div class="quality_field">';
        html += '<hr>'; // Horizontal line for separation
    });

    html += '<input type="button" value="Submit" onclick="submitPackingTransportCompleteForm()">';
    html += '<input type="button" value="View" onclick="viewPackingTransportCompleteForm()">';
    html += '</form>';

    html += '<div id="packing_transport_complete_results"></div>';
    html += '<div id="quality_images_container"></div>';
    html+='</div>';
    html += '</fieldset>';

    return html;
}
function viewPackingTransportCompleteForm()
{
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: document.querySelector('[name="process_order_number_pt"]').value,
    };
    console.log(formData);
    $.ajax({
        type: "POST",
        url: "/viewPackingTransportCompleteForm",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            displayPackingTransportResults(response);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}
function uploadImages_CompleteTransport() {
    var imagesInput = document.getElementById('InputImages');
    var po = document.querySelector('[name="process_order_number_pt"]').value || null;
    var uuid_qlty = document.querySelector('[name="uuidDisplay_qlty"]').innerText.trim();
    console.log(po);

    var formData = new FormData();
    if (imagesInput.files.length > 0) {
        // Append each selected image to the formData
        for (var i = 0; i < imagesInput.files.length; i++) {
            formData.append('images[]', imagesInput.files[i]);
        }

        // Append other form data if needed
        formData.append('process_order_number', po);
        formData.append('uuid_qlty', uuid_qlty);

        // Send the images using AJAX
        $.ajax({
            url: '/upload_completetransportimages',
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
            success: function (response) {
                console.log('Images uploaded successfully');
                // Handle success response if needed
            },
            error: function (xhr, status, error) {
                console.error('Error uploading images:', error);
                // Handle error if needed
            }
        });
    }
    

}
function submitPackingTransportCompleteForm() {
    uploadImages_CompleteTransport();
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
       // documentation_complete: document.querySelector('[name="documentation_complete"]').checked ? "Yes" : "No",
        secure_packing: document.querySelector('[name="secure_packing_c"]').checked ? "Yes" : "No",
        photos_attached: document.querySelector('[name="photos_attached"]').checked ? "Yes" : "No",
        responsible_person_complete: document.querySelector('[name="responsible_person_complete"]').value,
        comments_packing_transport: document.querySelector('[name="comments_packing_transport"]').value,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number: document.querySelector('[name="process_order_number_pt"]').value, // Adjust as needed
        status: document.querySelector('[name="status"]').value,
        quantity: document.querySelector('[name="quantity"]').value,
        uuid_qlty: document.querySelector('[name="uuidDisplay_qlty"]').textContent,
        
        //photos_attached: document.querySelector('[name="photos_attached"]').checked ? "Yes" : "No",
    };

    $.ajax({
        type: "POST",
        url: "/submitPackingTransportCompleteForm",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            displayPackingTransportResults(response);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}
function displayPackingTransportResults(values) {
    var resultsHtml = '<table id="packing_transport_results_table" style="width:100%; border-collapse: collapse; border: 1px solid #ddd; text-align: left;">';
    resultsHtml += '<thead><tr style="background-color: #f2f2f2;"><th style="padding: 8px; border-bottom: 1px solid #ddd;">Field</th><th style="padding: 8px; border-bottom: 1px solid #ddd;">Value</th></tr></thead>';
    resultsHtml += '<tbody>';

    function buildTableRows(obj, prefix) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key)) {
                var value = obj[key];
                var field =key;
                if (typeof value === 'object') {
                    buildTableRows(value, field);
                } else {
                    //resultsHtml += '<tr><td style="padding: 8px; border-bottom: 1px solid #ddd;">' + field + '</td><td style="padding: 8px; border-bottom: 1px solid #ddd;">' + value + '</td></tr>';
                    var valueStr = String(value).trim(); // Ensure value is a string before trimming
                if (valueStr === "Yes")
                   
                        {
                        resultsHtml += '<tr><td style="padding: 8px; border-bottom: 1px solid #ddd;">' + field + '</td><td style="padding: 8px; border-bottom: 1px solid #ddd;"> &#10003;</td></tr>';
                        }
                        else
                        {
                            resultsHtml += '<tr><td style="padding: 8px; border-bottom: 1px solid #ddd;">' + field + '</td><td style="padding: 8px; border-bottom: 1px solid #ddd;">' + value + '</td></tr>';
                        }
                }
            }
        }
    }

    buildTableRows(values);

    resultsHtml += '</tbody></table>';

    document.getElementById('packing_transport_complete_results').innerHTML = resultsHtml;



   // document.getElementById('quality_complete_results').innerHTML = resultsHtml;
    console.log(values.data.process_order_number);
        fetchImages_cmplt_tr(values.data.process_order_number, function(images) {
            //alert('yes');
            var imagesHtml = '';
            if (images && images.length > 0) {
                images.forEach(function(imageUrl) {
                    console.log(imageUrl);
                    console.log(values.data.process_order_number.trim());
                    imagesHtml += '<div style="display: inline-block; margin-right: 10px;">';
                    imagesHtml += '<a target = "_blank"href="http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/images_transport_complete/' + values.data.process_order_number.trim() + '/'   + imageUrl + '" download>';
                    imagesHtml += '<img src="http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/images_transport_complete/' + values.data.process_order_number.trim() + '/'  + imageUrl + '" style="max-width: 50px; max-height: 50px;"></a></div>';
                 // imagesHtml+='<img src="http://localhost/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/images_transport_complete/50000/1fa98025-696b-4e6c-be49-68108d110d7b/1716740385_Pic2.jpg">';
                                        // http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/images_transport_complete/50000/c2573be1-c302-48a9-9323-8c4efaa5a158/1716378927_Pic2.jpg
                });
            } else {
                imagesHtml += '-';
            }
    
            document.getElementById('quality_images_container').innerHTML = imagesHtml;
        });
    }
    function fetchImages_cmplt_tr(id, callback) {
    
        var headers = {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        };
        $.ajax({
            url: '/getImages_completetransport', // Your API endpoint to fetch images
            method: 'POST',
            headers: headers, // Include CSRF token in headers
            data: {
                id: id
            },
            success: function (response) {
                console.log(response);
                callback(response.filenames || []); // Ensure response.filenames is an array or use an empty array
            },
            error: function (error) {
                console.error('Error fetching images:', error);
                callback([]);
            }
        });
    }


function resetTransportForm() {
    // Uncheck checkboxes or reset other input fields as needed
    // For example:
    $('input[name="secure_packing_checkbox"]').prop('checked', false);
    $('input[name="responsible_person"]').val('');


    $('select[name="owner_transport"]').val('NULL');
    $('select[name="ndttype_transport"]').val('NULL');
}

function Transport(processOrder, userName) {
    console.log('Transport');
    console.log(processOrder);
    // Hide other fieldsets and show Packing and Transport fieldset
    $('#planningFieldset').hide();
    $('#qualityFieldset').hide();
    $('#manufacturingFieldset').hide();
    $('#engineeringFieldset').hide();
    $('#kittingFieldset').hide();
    $('#finalAssemblyFieldset').hide();
    $('#packingtransportFieldset').show();
    // Set default values if needed
    $('input[name="responsible_person"]').val(userName);
    $('#process_order_number_transport').val(processOrder);
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // Add other headers if needed
    };

    var formData = {
        process_order_number: processOrder
        // Add other form data if needed
    };

    // Fetch Packing and Transport Form Data for the given process order
    $.ajax({
        url: '/getPackingTransportDataByProcessOrder', // Adjust URL as needed
        type: 'POST',
        headers: headers,
        data: formData,
        dataType: 'json',
        success: function(response) {
            resetTransportForm();

            console.log(userName);
            $('input[name="responsible_person"]').val(userName);
            if (response.data != null) {
                console.log('yes process order found');
                console.log(response);
                $('#process_order_number_transport').val(processOrder);

                // Set checkbox states or other field values
                $('input[name="secure_packing_checkbox"]').prop('checked', response.data.secure_packing === "Yes");

                fetchOwnerData_Transport(processOrder, 'Secure Packing:', function (ownerData) {
                    if (ownerData) {
                        // Update owner cell
                        $(`select[name="owner_transport"][data-task="secure_packing"]`).val(ownerData.owner.trim());
                        // Update NDT cell
                        $(`select[name="ndttype_transport"][data-task="secure_packing"]`).val(ownerData.ndta.trim());
                    } else {
                        // Handle case where no owner data is retrieved
                        $(`select[name="owner_transport"][data-task="secure_packing"]`).val('NULL');
                        $(`select[name="ndttype_transport"][data-task="secure_packing"]`).val('NULL');
                    }
                });

                $('input[name="responsible_person"]').val(userName);
                
                // Handle other fields if needed

            } else {
                resetTransportForm();
                $('#process_order_number_transport').val(processOrder);
                $('input[name="responsible_person"]').val(userName);
                $('#packingtransportFieldset').show();
            }
        },
        error: function(error) {
            console.error(error);
        }
    });
}
