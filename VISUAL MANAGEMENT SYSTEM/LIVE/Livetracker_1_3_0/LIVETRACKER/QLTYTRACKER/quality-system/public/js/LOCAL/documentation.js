
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
   // formData.append('link_to_file', document.querySelector('[name="link_to_file"]').value);
   if ($('[name="technical_file_checkbox"]').is(':checked')) {
    var technicalFileInput = document.querySelector('[name="technical_file"]');
    if (technicalFileInput.files.length > 0) {
        formData.append('technical_file', document.querySelector('[name="technical_file"]').files[0].name);
    } else {
        // Add old technical file name if no new file is selected
        formData.append('technical_file', document.getElementById('old_technical_file').textContent.trim());
    }
}

// Add Client Hand-over Documentation if checkbox is checked
if ($('[name="client_handover_checkbox"]').is(':checked')) {
    var clientHandoverInput = document.querySelector('[name="client_handover_documentation"]');
    if (clientHandoverInput.files.length > 0) {
        formData.append('client_handover_documentation', document.querySelector('[name="client_handover_documentation"]').files[0].name);
    } else {
        // Add old client handover file name if no new file is selected
        formData.append('client_handover_documentation', document.getElementById('old_client_handover_documentation').textContent.trim());
    }
}

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
           
            var filePath = 'storage/documentation_tasks/' + item.process_order_number + '/' + item.technical_file;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</td>';
        html += '<td>';
        if (item.client_handover_documentation!=null) {
           
            var filePath = 'storage/documentation_tasks/' + item.process_order_number + '/' + item.client_handover_documentation;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
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
function generateHTMLFromResponse_for_documentation(response) {
    console.log('yes');
    var html = '<form id="documentationForm" class="documentation-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Documentation</legend>';

    $.each(response, function (index, item) {
        html += '<div class="documentation_item">';
        html += '<label>ID:</label><br>';
        html += '<input type="text" name="id" value="' + item.id + '" readonly><br>';

        // Technical File
        html += '<div class="documentation_field">';
        if (item.technical_file) {
            var technicalFilePath = 'storage/documentation_tasks/' + item.process_order_number + '/' + item.technical_file;
            html += '<a href="' + technicalFilePath + '" download>' + item.technical_file + '</a>';
        } else {
            html += '-';
        }
        html += '</div><br>';

        // Client Hand-over Documentation
        html += '<div class="documentation_field">';
        if (item.client_handover_documentation) {
            var clientHandoverFilePath = 'storage/documentation_tasks/' + item.process_order_number + '/' + item.client_handover_documentation;
            html += '<a href="' + clientHandoverFilePath + '" download>' + item.client_handover_documentation + '</a>';
        } else {
            html += '-';
        }
        html += '</div><br>';

        // Sign Off Engineer
        html += '<div class="documentation_field">';
        html +=
            '<label>Sign Off Engineer:</label>' +
            '<input type="text" name="sign_off_engineer" value="' + (item.sign_off_engineer ? item.sign_off_engineer : '-') + '" readonly>' +
            '</div><br>';

        // Comments
        html += '<div class="documentation_field">';
        html +=
            '<label>Comments:</label>' +
            '<input type="text" name="comments" value="' + (item.comments ? item.comments : '-') + '" readonly>' +
            '</div><br>';

        html += '</div>'; // Closing div for documentation_item
        html += '<hr>'; // Horizontal line for separation
    });

   
    html += '</fieldset></form>';

    return html;
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
    
    $.each(response, function (index, item) {
        html += '<div class="documentation_item">';
        html += '<label>ID: ' + item.id + '</label><br>';
        html += '<input name="process_order_number_dm" value="' + item.process_order_number + '"><br>';

        html += '<div class="documentation_field">';
        html +=
            '<label>Technical File:</label>' +
            (item.technical_file === "true" || item.technical_file === "on" ?
            '<input type="checkbox" id="technical_file" name="technical_file" checked>' :
            '<input type="checkbox" id="technical_file" name="technical_file">') +
            '</div><br>';

        html += '<div class="documentation_field">';
        html +=
            '<label>Client Hand-over Documentation:</label>' +
            (item.client_handover_documentation === "true" || item.client_handover_documentation === "on" ?
            '<input type="checkbox" id="client_handover_documentation" name="client_handover_documentation" checked>' :
            '<input type="checkbox" id="client_handover_documentation" name="client_handover_documentation">') +
            '</div><br>';

        html += '<div class="documentation_field">';
        html +=
            '<label>Sign Off:</label>' +
            '<input type="text" name="sign_off_documentation" value="' + userName + '">' +
            '</div><br>';

        html += '<div class="documentation_field">';
        html +=
            '<label>Comments:</label>' +
            '<input type="text" name="comments_documentation" value="' + item.comments + '">' +
            '</div><br>';

        // Added Status dropdown
        html += '<div class="documentation_field">';
        html +=
            '<label>Status:</label>' +
            '<select name="status">' +
            '<option value="partially_completed">Partially Completed</option>' +
            '<option value="completed">Completed</option>' +
            '</select>' +
            '</div><br>';

        // Added Quantity input box
        html += '<div class="documentation_field">';
        // Field for Quantity
  
    html += '<label>Quantity:</label>';
    html += '<input type="number" name="quantity" value="' + item.quantity + '">';
    html += '</div><br>';

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

    html += '<input type="button" value="Submit" onclick="submitDocumentationCompleteForm()">';
    html += '</form>';

    html += '<div id="documentation_complete_results"></div>';
    html += '</fieldset>';

    return html;
}

function submitDocumentationCompleteForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        technical_file: document.querySelector('[name="technical_file"]').checked ? "on" : "",
        client_handover_documentation: document.querySelector('[name="client_handover_documentation"]').checked ? "on" : "",
        sign_off_documentation: document.querySelector('[name="sign_off_documentation"]').value,
        comments_documentation: document.querySelector('[name="comments_documentation"]').value,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number: document.querySelector('[name="process_order_number_dm"]').value,
        status: document.querySelector('[name="status"]').value,
        quantity: document.querySelector('[name="quantity"]').value,
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
                var field = prefix ? prefix + '.' + key : key;
                if (typeof value === 'object') {
                    buildTableRows(value, field);
                } else {
                    resultsHtml += '<tr><td style="padding: 8px; border-bottom: 1px solid #ddd;">' + field + '</td><td style="padding: 8px; border-bottom: 1px solid #ddd;">' + value + '</td></tr>';
                }
            }
        }
    }

    buildTableRows(values);

    resultsHtml += '</tbody></table>';

    document.getElementById('documentation_complete_results').innerHTML = resultsHtml;
}
function resetDocumentationForm() {
    // Uncheck checkboxes
    $('input[name="technical_file_checkbox"]').prop('checked', false);
    $('input[name="client_handover_checkbox"]').prop('checked', false);

    // Clear text inputs
    $('#process_order_number_documentation').val('');
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
                $('input[name="technical_file_checkbox"]').prop('checked', response.data.technical_file_checkbox === '1');
                $('input[name="client_handover_checkbox"]').prop('checked', response.data.client_handover_checkbox === '1');

                // Example: Populate file upload fields
                $('#old_technical_file').text(response.data.technical_file);
                $('#old_client_handover_documentation').text(response.data.client_handover_documentation);

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

