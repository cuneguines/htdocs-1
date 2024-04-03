function generateDocumentationFieldset(processOrder, username) {
    $("#sign_off_engineer").val(username);
    return `
    <fieldset>
        <legend>Documentation</legend>

        <!-- Subtask 12.1: Technical File -->
        <div class="form-group">
            <label>
                Technical File:
                <input type="checkbox" name="technical_file_checkbox" value="1" onclick="toggleFileUpload('technical_file_upload', this)">
            </label>
            <div id="technical_file_upload" style="display: none;">
                <label>Upload Technical File:</label>
                <input type="file" name="technical_file" accept=".pdf,.doc,.docx,.txt">
            </div>
        </div>

        <!-- Subtask 12.2: Client Hand-over documentation -->
        <div class="form-group">
            <label>
                Client Hand-over documentation:
                <input type="checkbox" name="client_handover_checkbox" value="1" onclick="toggleFileUpload('client_handover_upload', this)">
            </label>
            <div id="client_handover_upload" style="display: none;">
                <label>Upload Client Hand-over Documentation:</label>
                <input type="file" name="client_handover_documentation" accept=".pdf,.doc,.docx,.txt">
            </div>
        </div>

        <!-- Engineer -->
        <div class="form-group">
            <label>
                Sign_off_Engineer:
                <input type="text" name="sign_off_engineer" value="${username}">
            </label>
        </div>

        

        <!-- Submit button -->
        <button type="button" onclick="submitDocumentationForm('${processOrder}')">Submit Documentation Form</button>

      
    </fieldset>
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

function submitDocumentationForm(processOrder) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };
    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }

    var formData = new FormData();
    formData.append('process_order_number', processOrder);
    formData.append('engineer', document.querySelector('[name="sign_off_engineer"]').value);
   // formData.append('link_to_file', document.querySelector('[name="link_to_file"]').value);

    // Add Technical File if checkbox is checked
    if ($('[name="technical_file_checkbox"]').is(':checked')) {
        formData.append('technical_file', getFileName('technical_file'));
    }

    // Add Client Hand-over Documentation if checkbox is checked
    if ($('[name="client_handover_checkbox"]').is(':checked')) {
        formData.append('client_handover_documentation', getFileName('client_handover_documentation'));
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
    fileData.append('process_order_number', processOrder);

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

function generateHTMLFromResponse_for_documentation(response) {
    console.log('yes');
    var html = '<table id="common_table" style="width:100%;">';
    html +=
        '<thead><tr><th style="width:5%;">ID</th><th style="width:25%;">Technical File</th><th style="width:25%;">Client Hand-over Documentation</th><th style="width:20%;">Sign Off Engineer</th><th style="width:25%;">Comments</th></tr></thead><tbody>';

    $.each(response, function (index, item) {
        html += "<tr>";
        html += "<td>" + item.id + "</td>";

        html += '<td>';
        if (item.technical_file!='null') {
           
            var filePath = 'storage/documentation_tasks/' + item.process_order_number + '/' + item.technical_file;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</td>';
        html += '<td>';
        if (item.client_handover_documentation!='null') {
           
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
            var generatedHTML = generateCompleteHTMLFromResponse_for_documentation(response);
            $("#documentationCompleteFieldTable").html(generatedHTML);
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
            '<input type="text" name="sign_off_documentation" value="' + item.sign_off_engineer + '">' +
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
        html += '<div class="documentation_field">';
        html +=
            '<label>Labels Attached:</label>' +
            (item.labels_attached === "true" || item.labels_attached === "on" ?
            '<input type="checkbox" id="labels_attached" name="labels_attached" checked>' :
            '<input type="checkbox" id="labels_attached" name="labels_attached">') +
            '</div><br>';

        html += '</div>'; // Closing div for documentation_item
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
        process_order_number: 2, // Adjust as needed
        status: document.querySelector('[name="status"]').value,
        quantity: document.querySelector('[name="quantity"]').value,
        labels_attached: document.querySelector('[name="labels_attached"]').checked ? "on" : "",
    };

    $.ajax({
        type: "POST",
        url: "/submitDocumentationCompleteForm",
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
