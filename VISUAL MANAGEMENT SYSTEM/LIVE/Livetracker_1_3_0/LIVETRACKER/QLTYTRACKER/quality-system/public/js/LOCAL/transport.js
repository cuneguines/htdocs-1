function generatePackingTransportFieldset(processOrder, username) {
    $("#responsible_person").val(username);
    return `
    <fieldset>
        <legend>Packing and Transport</legend>

        <!-- Subtask 13.1: Documentation Complete -->
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

        <!-- Subtask 13.2: Secure Packing -->
        <div class="form-group">
            <label>
                Secure Packing:
                <input type="checkbox" name="secure_packing_checkbox" value="1">
            </label>
        </div>

        <!-- Responsible Person -->
        <div class="form-group">
            <label>
                Responsible Person:
                <input type="text" name="responsible_person" value="${username}">
            </label>
        </div>

        <!-- Submit button -->
        <button type="button" onclick="submitPackingTransportForm('${processOrder}')">Submit Packing and Transport Form</button>
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

function submitPackingTransportForm(processOrder) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };
    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }

    var formData = new FormData();
    formData.append('process_order_number', processOrder);
    formData.append('responsible_person', document.querySelector('[name="responsible_person"]').value);
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
        },
        error: function (error) {
            console.error("Error:", error);
            alert("Error submitting Packing and Transport form");
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

function generateHTMLFromResponse_for_packing_transport(response) {
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
            var generatedHTML = generateCompleteHTMLFromResponse_for_packing_transport(response);
            $("#packingtransportCompleteFieldTable").html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        },
    });
}

function generateCompleteHTMLFromResponse_for_packing_transport(response) {
    var html = '<fieldset><legend>Packing and Transport Complete</legend>';
    html += '<form id="packing_transport_complete_form">';

    $.each(response, function (index, item) {
        html += '<div class="packing_transport_item">';
        html += '<label>ID: ' + item.id + '</label><br>';

        // Documentation Complete
        html += '<div class="packing_transport_field">';
        html +=
            '<label>Documentation Complete:</label>' +
            (item.documentation_complete === "Yes" ?
                '<input type="checkbox" id="documentation_complete" name="documentation_complete" checked>' :
                '<input type="checkbox" id="documentation_complete" name="documentation_complete">') +
            '</div><br>';

        // Secure Packing
        html += '<div class="packing_transport_field">';
        html +=
            '<label>Secure Packing:</label>' +
            (item.secure_packing === "Yes" ?
                '<input type="checkbox" id="secure_packing" name="secure_packing" checked>' :
                '<input type="checkbox" id="secure_packing" name="secure_packing">') +
            '</div><br>';

        // Responsible Person
        html += '<div class="packing_transport_field">';
        html +=
            '<label>Responsible Person:</label>' +
            '<input type="text" name="responsible_person_complete" value="' + item.responsible_person + '">' +
            '</div><br>';

        // Comments
        html += '<div class="packing_transport_field">';
        html +=
            '<label>Comments:</label>' +
            '<input type="text" name="comments_packing_transport" value="' + item.comments + '">' +
            '</div><br>';

        // Added Status dropdown
        html += '<div class="packing_transport_field">';
        html +=
            '<label>Status:</label>' +
            '<select name="status">' +
            '<option value="partially_completed">Partially Completed</option>' +
            '<option value="completed">Completed</option>' +
            '</select>' +
            '</div><br>';

        // Added Quantity input box
        html += '<div class="packing_transport_field">';
        // Field for Quantity
        html += '<label>Quantity:</label>';
        html += '<input type="number" name="quantity" value="' + item.quantity + '">';
        html += '</div><br>';

        // Added Photos Attached checkbox
        html += '<div class="packing_transport_field">';
        html +=
            '<label>Photos Attached:</label>' +
            (item.photos_attached === "Yes" ?
                '<input type="checkbox" id="photos_attached" name="photos_attached" checked>' :
                '<input type="checkbox" id="photos_attached" name="photos_attached">') +
            '</div><br>';

        html += '</div>'; // Closing div for packing_transport_item
        html += '<hr>'; // Horizontal line for separation
    });

    html += '<input type="button" value="Submit" onclick="submitPackingTransportCompleteForm()">';
    html += '</form>';

    html += '<div id="packing_transport_complete_results"></div>';
    html += '</fieldset>';

    return html;
}
function submitPackingTransportCompleteForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        documentation_complete: document.querySelector('[name="documentation_complete"]').checked ? "Yes" : "No",
        secure_packing: document.querySelector('[name="secure_packing"]').checked ? "Yes" : "No",
        responsible_person_complete: document.querySelector('[name="responsible_person_complete"]').value,
        comments_packing_transport: document.querySelector('[name="comments_packing_transport"]').value,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number: 2, // Adjust as needed
        status: document.querySelector('[name="status"]').value,
        quantity: document.querySelector('[name="quantity"]').value,
        photos_attached: document.querySelector('[name="photos_attached"]').checked ? "Yes" : "No",
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

    document.getElementById('packing_transport_complete_results').innerHTML = resultsHtml;
}
