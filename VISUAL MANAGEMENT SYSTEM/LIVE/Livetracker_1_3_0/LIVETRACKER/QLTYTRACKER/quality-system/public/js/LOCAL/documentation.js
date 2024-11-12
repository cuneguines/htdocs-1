
function generateDocumentationFieldset(processOrder, username) {
    $("#sign_off_engineer").val(username);
   
}



function submitDocumentationForm(processOrder) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };
    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }

    var formData = new FormData();
    formData.append('process_order_number', document.querySelector('[name="process_order_number_documentation"]').value);
    formData.append('engineer', document.querySelector('[name="sign_off_engineer"]').value);
    formData.append('technical_file_check', document.querySelector('[name="technical_file_checkbox"]').checked ? 1:0);
    formData.append('client_handover_check', document.querySelector('[name="client_handover_checkbox"]').checked ? 1:0);
    formData.append('comments_documentation', document.querySelector('[name="comments_documentation"]').value);
   // formData.append('link_to_file', document.querySelector('[name="link_to_file"]').value);
   
    var technicalFileInput = document.querySelector('[name="technical_file"]');
    if (technicalFileInput.files.length > 0) {
        formData.append('technical_file', document.querySelector('[name="technical_file"]').files[0].name);
    } else {
        // Add old technical file name if no new file is selected
        formData.append('technical_file', document.getElementById('old_technical_file').textContent.trim());
    }


// Add Client Hand-over Documentation if checkbox is checked

    var clientHandoverInput = document.querySelector('[name="client_handover_documentation"]');
    if (clientHandoverInput.files.length > 0) {
        formData.append('client_handover_documentation', document.querySelector('[name="client_handover_documentation"]').files[0].name);
    } else {
        // Add old client handover file name if no new file is selected
        formData.append('client_handover_documentation', document.getElementById('old_client_handover_documentation').textContent.trim());
    }


    var owners_docu = [];
document.querySelectorAll('#docu tbody tr').forEach(function (row, index) {
    console.log(index);
    if (index >= 0 && index <=1) { // Skip the header row
        var owner = row.querySelector('[name="owner_docu"]').value || null;
        var ndt = row.querySelector('[name="ndttype_docu"]').value || null;
console.log(owner);
console.log(ndt);
        // Push the owner data to the array
        owners_docu.push({
            type: row.cells[0].innerText.trim(),
            owner: owner,
            ndt: ndt
        });

        // Append each owner and NDT as separate entries
        formData.append('owners_docu[' + (index - 1) + '][type]', row.cells[0].innerText.trim());
        formData.append('owners_docu[' + (index - 1) + '][owner]', owner);
        formData.append('owners_docu[' + (index - 1) + '][ndt]', ndt);
    }
});

    console.log(formData);

    // Send an AJAX request to the server
    $.ajax({
        url: "/submitDocumentationForm",
        type: "POST",
        data: formData,
        headers: headers,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            alert("Documentation form submitted successfully");
            // Optionally update the table or perform other actions
            $(myModal).hide();
        },
        error: function (error) {
            console.error("Error:", error);
            alert("Error submitting Documentation form");
        },
    });

    var fileData = new FormData();
    var fileInputs = $('[type="file"]');

    // Add process_order_number to FormData
    fileData.append('process_order_number', document.querySelector('[name="process_order_number_documentation"]').value);

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
        url: '/handleFileUploadDocumentation',  // Update to your actual route
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
function generateDocumentationFieldTable(processOrder) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: processOrder,
    };

    $.ajax({
        url: "/getDocumentationDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML = generateHTMLFromResponse_for_documentation(response);

            $("#documentationFieldTable").html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        },
    });

    return `
        <div>To be Done</div>
    `;
}

function generateHTMLFromResponse_for_documentation_old(response) {
    console.log('yes');
    var html = '<table id="common_table" style="width:100%;">';
    html +=
        '<thead><tr><th style="width:5%;">ID</th><th style="width:25%;">Technical File</th><th style="width:25%;">Client Hand-over Documentation</th><th style="width:20%;">Sign Off Engineer</th><th style="width:25%;">Comments</th></tr></thead><tbody>';

    $.each(response, function (index, item) {
        html += "<tr>";
        html += "<td>" + item.id + "</td>";

        html += '<td>';
        if (item.technical_file!=null) {
           
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/documentation_tasks/' + item.process_order_number + '/' + item.technical_file;
            var downloadLink = '<a href="' + filePath + '" target="_blank">Download File</a>';

            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</td>';
        html += '<td>';
        if (item.client_handover_documentation!=null) {
           
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/documentation_tasks/' + item.process_order_number + '/' + item.client_handover_documentation;
            var downloadLink = '<a href="' + filePath + '" target="_blank">Download File</a>';

            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</td>';

        // Sign Off Engineer
        html += "<td>" + (item.sign_off_engineer ? item.sign_off_engineer : "-") + "</td>";

        // Comments
        html += "<td>" + (item.comments ? item.comments : "-") + "</td>";

        html += "</tr>";
    });

    html += "</tbody></table>";

    return html;
}
function generateHTMLFromResponse_for_documentation_old(response) {
    console.log('yes');
    var html = '<form id="documentationForm" class="documentation-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Documentation</legend>';
    html+='<div style="width:97%">';
    $.each(response, function (index, item) {
        html += '<div class="documentation_item">';
        //html += '<label>ID:</label><br>';
        //html += '<input type="text" name="id" value="' + item.id + '" readonly><br>';

        // Technical File
        html += '<div class="documentation_field">';
        if (item.technical_file) {
            '<label>Technical File:</label>' 
            var technicalFilePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/documentation_tasks/' + item.process_order_number + '/' + item.technical_file;
            html +=  '<label>Technical File:</label>' +'<a href="' + technicalFilePath + '" target="_blank">' + item.technical_file + '</a>';
        } else {
            html += '-';
        }
        html += '</div><br>';

        // Client Hand-over Documentation
        html += '<div class="documentation_field">';
        if (item.client_handover_documentation) {
            var clientHandoverFilePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/documentation_tasks/' + item.process_order_number + '/' + item.client_handover_documentation;
            html += '<label>Client Hand Over Documentation:</label>' +'<a href="' + clientHandoverFilePath + '" target="_blank">' + item.client_handover_documentation + '</a>';
        } else {
            html += '-';
        }
        html += '</div><br>';

        // Sign Off Engineer
        html += '<div class="documentation_field">';
        html +=
            '<label>Sign Off Engineer:</label>' +
            '<input style="width:100%"type="text" name="sign_off_engineer" value="' + (item.engineer ? item.engineer : '-') + '" readonly>' +
            '</div><br>';

        // Comments
        html += '<div class="documentation_field">';
        html +=
            '<label>Comments:</label>' +
            '<input style="width:100%"type="text" name="comments" value="' + (item.comments_documentation? item.comments_documentation: '-') + '" readonly>' +
            '</div><br>';

        html += '</div>'; // Closing div for documentation_item
        html += '<hr>'; // Horizontal line for separation
    });

    html+='</div>';
    html += '</fieldset></form>';

    return html;
}
function generateHTMLFromResponse_for_documentation(response) {
    console.log('Generating welding documentation...');
    var html = '<form id="weldingDocumentationForm" class="documentation-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Welding Documentation</legend>';
    html += '<div style="width:97%">';
    
    

    $.each(response, function (index, item) {
        html += '<tr>';

        // Tasks column
        html += '<td style="border: 1px solid #000; padding: 8px;">';
        html += '<label>Process Order Number:</label><br>';
        html += '<input style="width:100%" name="process_order_number_dm" value="' + item.process_order_number + '" readonly><br>';
        html += '</td>';
// Start of the table
html += '<table style="width:100%; border-collapse: collapse;">';
html += '<thead>';
html += '<tr>';
html += '<th style="border: 1px solid #000; padding: 8px;">Tasks</th>';
html += '<th style="border: 1px solid #000; padding: 8px;">Files</th>';
html += '<th style="border: 1px solid #000; padding: 8px;">Owner</th>';
html += '<th style="border: 1px solid #000; padding: 8px;">Action</th>';
html += '</tr>';
html += '</thead>';
html += '<tbody>';
html+='<tr>';
        // Files column
        html += '<td style="border: 1px solid #000; padding: 8px;">';
        html += '<div class="documentation_field">';
        if (item.technical_file) {
            var technicalFilePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/documentation_tasks/' + item.process_order_number + '/' + item.technical_file;
            html += '<label>Technical File:</label><br>';
            html += '<a href="' + technicalFilePath + '" target="_blank">' + item.technical_file + '</a><br>';
        } else {
            html += '-';
        }
        html += '</div>';

        html+='<td>';
        html += '</td>';
        html += '<td id="owner_doc_1" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_doc_1" style="border: 1px solid #ccc;"></td>';

        fetchOwnerData_Documentation(item.process_order_number, 'Technical File:',function (ownerData) {
            document.getElementById('owner_doc_1').innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_doc_1').innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        });

        html+='</tr>';
        html+='<tr>';
        html += '<td style="border: 1px solid #000; padding: 8px;">';
        html += '<div class="documentation_field">';
        if (item.client_handover_documentation) {
            var clientHandoverFilePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/documentation_tasks/' + item.process_order_number + '/' + item.client_handover_documentation;
            html += '<label>Client Hand Over Documentation:</label><br>';
            html += '<a href="' + clientHandoverFilePath + '" target="_blank">' + item.client_handover_documentation + '</a><br>';
        } else {
            html += '-';
        }
        html += '</div>';
        html += '</td>';
html+='<td>';
html += '</td>';

        html += '<td id="owner_process_' + index + '" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_process_' + index + '" style="border: 1px solid #ccc;"></td>';
        // Fetch owner data here if needed
        fetchOwnerData_Documentation(item.process_order_number, 'Client Hand-over documentation:',function (ownerData) {
            document.getElementById('owner_process_' + index).innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_process_' + index).innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        });
        html+='</tr>';
        // Owner column
        html += '<tr>';
        html += '<td style="border: 1px solid #000; padding: 8px;">';
        html += '<label>Owner:</label><br>';
        html += '</td>';
        html += '<td>';
        html += (item.engineer ? item.engineer : '-') + '<br>';
        html += '</td>';
      
        // NDT column
        html += '<tr>';
        html += '<td style="border: 1px solid #000; padding: 8px;">';
        html += '<label>Comments:</label><br>';
        html += '</td>';
        html += '<td>';
        html += (item.comments_documentation ? item.comments_documentation : '-') + '<br>';
        html += '</td>';

        html += '</tr>'; // End of row
    });
    html += '</div>'; // Closing div
    html += '</fieldset></form>';

    return html;
}

function fetchOwnerData_Documentation(id,Type,callback)
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
    url: '/getOwnerData_docu',
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



function generateDocumentationCompleteFieldset(processOrder, qualityStep, username) {
    var formData = {
        process_order_number: processOrder,
    };
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    $("#sign_off_documentation").val(username);

    $.ajax({
        url: "/getDocumentationDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            if (response.data !== null) {
            var generatedHTML = generateCompleteHTMLFromResponse_for_documentation(response);
            $("#documentationCompleteFieldTable").html(generatedHTML);

            }
            else
        {
            $("#documentationCompleteFieldTable").html('');
        }

        },
        error: function (error) {
            console.error(error);
        },
    });
}

function generateCompleteHTMLFromResponse_for_documentation(response) {
    var html = '<fieldset><legend>Documentation Complete</legend>';
    html += '<form id="documentation_complete_form">';
    html+='<div style="width:97%">';
    $.each(response, function (index, item) {
        html += '<div class="documentation_item">';
        //html += '<label>ID: ' + item.id + '</label><br>';
        html += '<input style="width:100%"name="process_order_number_dm" value="' + item.process_order_number + '"><br><br>';

        html += '<div class="documentation_field">';
        html += '<label>Technical File:</label>';
        
        html +=
           
        
            '<input type="checkbox" id="technical_file" name="technical_file_c" >'
            
            '</div><br><br>';
            html+='<div>     <br></div>';
        html += '<div class="documentation_field">';
        html += '<label>Client Handover Documentation:</label>';
        html +=
            
        
            '<input type="checkbox" id="client_handover_documentation" name="client_handover_documentation_c" >'
            
            '</div><br><br>';
            html+='<div>     <br></div>';
        html += '<div class="documentation_field">';
        html +=
            '<label>Sign Off:</label>' +
            '<input style="width:100%"type="text" name="sign_off_documentation" value="' + userName + '">' +
            '</div><br>';

        html += '<div class="documentation_field">';
        html +=
            '<label>Comments:</label>' +
            '<input style="width:100%"type="text" name="comments_documentation" value="' + item.comments + '">' +
            '</div><br>';

        // Added Status dropdown
        html += '<div class="documentation_field">';
        html +=
            '<label>Status:</label>' +
            '<select style="width:100%"name="status">' +
            '<option value="partially_completed">Partially Completed</option>' +
            '<option value="completed">Completed</option>' +
            '</select>' +
            '</div><br>';

        // Added Quantity input box
        html += '<div class="documentation_field">';
        // Field for Quantity
  
   // html += '<label>Quantity:</label>';
   // html += '<input type="number" name="quantity" value="' + item.quantity + '">';
    //html += '</div><br>';

        // Added Labels Attached checkbox
       /*  html += '<div class="documentation_field">';
        html +=
            '<label>Labels Attached:</label>' +
            (item.labels_attached === "true" || item.labels_attached === "on" ?
            '<input type="checkbox" id="labels_attached" name="labels_attached" checked>' :
            '<input type="checkbox" id="labels_attached" name="labels_attached">') +
            '</div><br>';

        html += '</div>'; */  // Closing div for documentation_item
        html += '<hr>'; // Horizontal line for separation
    });

    html += '<input class="btn"type="button" value="Submit" onclick="submitDocumentationCompleteForm(this)">';
    html += '<input class="btn"type="button" value="View" onclick="viewDocumentationCompleteForm()">';
   
    html += '</form>';

    html += '<div id="documentation_complete_results"></div>';
    html+='</div>';
    html += '</fieldset>';

    return html;
}


function submitDocumentationCompleteForm($button) {
   $button.classList.add("active");
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        technical_file: document.querySelector('[name="technical_file_c"]').checked ? "on" : "",
        client_handover_documentation: document.querySelector('[name="client_handover_documentation_c"]').checked ? "on" : "",
        sign_off_documentation: document.querySelector('[name="sign_off_documentation"]').value,
        comments_documentation: document.querySelector('[name="comments_documentation"]').value,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number: document.querySelector('[name="process_order_number_dm"]').value,
        status: document.querySelector('[name="status"]').value,
       // quantity: document.querySelector('[name="quantity"]').value,
        //labels_attached: document.querySelector('[name="labels_attached"]').checked ? "on" : "",
    };

    $.ajax({
        type: "POST",
        url: "/submitDocumentationCompleteForm",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            displayDocumentationResults(response.data);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}

function displayDocumentationResults(values) {
    var resultsHtml = '<table id="documentation_results_table" style="width:100%; border-collapse: collapse; border: 1px solid #ddd; text-align: left;">';
    resultsHtml += '<thead><tr style="background-color: #f2f2f2;"><th style="padding: 8px; border-bottom: 1px solid #ddd;">Field</th><th style="padding: 8px; border-bottom: 1px solid #ddd;">Value</th></tr></thead>';
    resultsHtml += '<tbody>';

    function buildTableRows(obj, prefix) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key)) {
                var value = obj[key];
                var field =  key;
                if (typeof value === 'object') {
                    buildTableRows(value, field);
                } else {
                    //resultsHtml += '<tr><td style="padding: 8px; border-bottom: 1px solid #ddd;">' + field + '</td><td style="padding: 8px; border-bottom: 1px solid #ddd;">' + value + '</td></tr>';
                    if (value=="on")
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

    document.getElementById('documentation_complete_results').innerHTML = resultsHtml;
}



function viewDocumentationCompleteForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: document.querySelector('[name="process_order_number_dm"]').value,
    };
    $.ajax({
        type: "POST",
        url: "/viewDocumentationCompleteForm",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            displayDocumentationResults(response);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}
function resetDocumentationForm() {
    // Uncheck checkboxes
    $('input[name="technical_file_checkbox"]').prop('checked', false);
    $('input[name="client_handover_checkbox"]').prop('checked', false);

    // Clear text inputs
    $('#process_order_number_documentation').val('');
    $('#comments_documentation').val('');
    // Add more text inputs if needed

    // Reset file input values and filenames
    $('#technical_file').val('');
    $('#client_handover_documentation').val('');

    // Reset other elements as needed
    $('#old_technical_file').text('');
    $('#old_client_handover_documentation').text('');
    // Add more elements to reset if needed

    // Show the documentation form section if it was hidden
    $('#documentationFieldset').show();
       // Reset owner and NDT selects
       $('select[name="owner_docu"]').val('NULL');
       $('select[name="ndttype_docu"]').val('NULL');
}


function Documentation(processOrder, userName) {
    console.log('documentation');
    console.log(userName);

    // Hide other fieldsets if needed
    $('#planningFieldset').hide();
    $('#qualityFieldset').hide();
    $('#manufacturingFieldset').hide();
    $('#engineeringFieldset').hide();

    // Show documentation fieldset
    $('#documentationFieldset').show();

    // Set default values for process order number
    $('#process_order_number_documentation').val(processOrder);

    // Define headers for AJAX request
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // Add other headers if needed
    };

    // Prepare form data
    var formData = {
        process_order_number: processOrder,
        // Add other form data if needed
    };

    // Fetch Documentation Form Data for the given process order
    $.ajax({
        url: '/getDocumentationDataByProcessOrder', // Adjust URL as needed
        type: 'POST',
        headers: headers,
        data: formData,
        dataType: 'json',
        success: function(response) {
            // Reset the form first
            resetDocumentationForm();
            $('#process_order_number_documentation').val(processOrder);
            $('#sign_off_engineer').val(userName);
            // Populate form fields with response data
            if (response.data != null) {
                console.log('yes po found');
                console.log(response);

                // Example: Populate checkboxes
                $('input[name="technical_file_checkbox"]').prop('checked', response.data.technical_file_check === '1');

                fetchOwnerData_Documentation(processOrder, 'Technical File:', function (ownerData) {
                    if (ownerData) {
                        // Update owner cell
                        $(`select[name="owner_docu"][data-task="technical_file_checkbox"]`).val(ownerData.owner.trim());
                        // Update NDT cell
                        $(`select[name="ndttype_docu"][data-task="technical_file_checkbox"]`).val(ownerData.ndta.trim());
                    } else {
                        // Handle case where no owner data is retrieved
                        $(`select[name="owner_docu"][data-task="technical_file_checkbox"]`).val('NULL');
                        $(`select[name="ndttype_docu"][data-task="technical_file_checkbox"]`).val('NULL');
                    }
                });

                
                $('input[name="client_handover_checkbox"]').prop('checked', response.data.client_handover_check === '1');

                fetchOwnerData_Documentation(processOrder, 'Client Hand-over documentation:', function (ownerData) {
                    if (ownerData) {
                        // Update owner cell
                        $(`select[name="owner_docu"][data-task="client_handover_checkbox"]`).val(ownerData.owner.trim());
                        // Update NDT cell
                        $(`select[name="ndttype_docu"][data-task="client_handover_checkbox"]`).val(ownerData.ndta.trim());
                    } else {
                        // Handle case where no owner data is retrieved
                        $(`select[name="owner_docu"][data-task="client_handover_checkbox"]`).val('NULL');
                        $(`select[name="ndttype_docu"][data-task="client_handover_checkbox"]`).val('NULL');
                    }
                });
                // Example: Populate file upload fields
                $('#old_technical_file').text(response.data.technical_file);
                $('#old_client_handover_documentation').text(response.data.client_handover_documentation);
                $('input[name="comments"]').val(response.data.comments_documentation);
                // Example: Populate other fields
                // $('#other_field_id').val(response.data.other_field_value);
            } else {
                // If no data found, reset the form or set default values
                resetDocumentationForm();
                $('#process_order_number_documentation').val(processOrder);
                $('#sign_off_engineer').val(userName);

            }
        },
        error: function(error) {
            console.error(error);
        }
    });
}

