function generateSubContractFieldset(processOrder, qualityStep, username) {
    $("#sign_off_sub_contract").val(username);
    return `
    <fieldset>
    <legend>Sub-Contract</legend>

    <!-- Subtask 10.1: Sub-Contract Action -->
    <div class="form-group">
        <label>
            Sub-Contract Action:
            <select name="sub_contract_action">
                <option value="NULL">Select Action</option>
                <option value="Goods In">Goods In</option>
                
                <!-- Add more options as needed -->
            </select>
        </label>
    </div>
    <!-- File Upload for Sub-Contract -->
    <div class="form-group">
        <label>
            Upload File:
            <input type="file" name="sub_contract_file" accept=".pdf,.doc,.docx,.txt">
        </label>
    </div>
    <!-- Sign-off for Sub-Contract -->
    <div class="form-group">
        <label>
            Sign-off for Sub-Contract:
            <input type="text" name="sign_off_sub_contract" value="${username}">
        </label>
    </div>

    <!-- Comments for Sub-Contract -->
    <div class="form-group">
        <label>
            Comments for Sub-Contract:
            <textarea name="comments_sub_contract" rows="4" cols="50"></textarea>
        </label>
    </div>

    <!-- Submit button -->
    <button type="button" onclick="submitSubContractForm('${processOrder}')">Submit Sub-Contract Form</button>
    </fieldset>
    `;
}
function submitSubContractForm(processOrder) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };
    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }
    var formData = new FormData();
    formData.set('sub_contract_action', document.querySelector('[name="sub_contract_action"]').value);
    formData.set('sub_contract_file', getFileName('sub_contract_file'));
    formData.set('sign_off_sub_contract', document.querySelector('[name="sign_off_sub_contract"]').value);
    formData.set('comments_sub_contract', document.querySelector('[name="comments_sub_contract"]').value);
    formData.set('submission_date', new Date().toISOString().split("T")[0]); // Get today's date in YYYY-MM-DD format
    formData.set('process_order_number', processOrder);
    //formData.append('testing_document_file_name', getFileName('testing_documents'));
    // Send an AJAX request to the server
    $.ajax({
        url: "/submitSubContractForm",
        type: "POST",
        data: formData,
        headers: headers,
        processData: false, // Prevent jQuery from automatically processing the data
        contentType: false, // Prevent jQuery from setting content type
        success: function (response) {
            console.log(response);
            alert("Sub-Contract form submitted successfully");
            // Optionally update the table or perform other actions
        },
        error: function (error) {
            console.error("Error:", error);
            alert("Error submitting Sub-Contract form");
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
        url: '/handleFileUploadSubContract',  // Update to your actual route
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
function generateSubContractFieldTable(processOrder, qualityStep) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: processOrder,
    };

    $.ajax({
        url: "/getSubContractDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML = generateHTMLFromResponse_for_sub_contract(response);

            $("#subcontractFieldTable").html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        },
    });

    return `
        <div>To be Done</div>
    `;
}
function generateHTMLFromResponse_for_sub_contract(response) {
    var html = '<table id="sub_contract_table" style="width:100%;">';
    html += '<thead><tr>';
    html += '<th style="width:5%;">Sub-Contract ID</th>';
    html += '<th style="width:20%;">Process Order</th>';
    html += '<th style="width:20%;">Sub-Contract Action</th>';
    html += '<th style="width:20%;">Sub-Contract File</th>';
    html += '<th style="width:20%;">Sign-off for Sub-Contract</th>';
    html += '<th style="width:20%;">Comments for Sub-Contract</th>';
    html += '<th style="width:20%;">Submission Date</th>';

    html += '<th style="width:5%;">Created At</th>';
    html += '<th style="width:5%;">Updated At</th>';
    html += '</tr></thead><tbody>';

    $.each(response, function (index, item) {
        html += "<tr>";
        html += "<td>" + item.id + "</td>";
        html += "<td>" + item.process_order_number + "</td>";
        html += "<td>" + item.sub_contract_action + "</td>";
        html += '<td style="text-align:center;">';

        if (item.sub_contract_file) {
            var filePath = 'storage/subcontract_task/' + item.process_order_number + '/' + item.sub_contract_file;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</td>';
        html += "<td>" + item.sign_off_sub_contract + "</td>";
        html += "<td>" + item.comments_sub_contract + "</td>";
        html += "<td>" + item.submission_date + "</td>";

        html += "<td>" + item.created_at + "</td>";
        html += "<td>" + item.updated_at + "</td>";
        html += "</tr>";
    });

    html += "</tbody></table>";

    return html;
}
function generateSubContractCompleteFieldset(processOrder, qualityStep, username) {
    var formData = {
        process_order_number: processOrder,
    };
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    $("#sign_off_sub_contract").val(username);

    $.ajax({
        url: "/getSubContractDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);

            if (response.data !== null) {
                var generatedHTML = generateCompleteHTMLFromResponse_for_sub_contract(response.data);
                $("#subcontractCompleteFieldTable").html(generatedHTML);
            } else {
                $("#subcontractCompleteFieldTable").html('');
            }
        },
        error: function (error) {
            console.error(error);
        },
    });
}
function generateCompleteHTMLFromResponse_for_sub_contract(item) {
    var html = '<fieldset><legend>Complete Sub-Contract</legend>';
    html += '<form id="complete_sub_contract_form">';
    
    html += '<div class="sub_contract_item">';
    html += '<label>ID: ' + item.id + '</label><br>';
    html += '<div class="sub_contract_item">';
    html += '<label>Process Order: ' + item.process_order_number + '</label><br>';
    html += '<div class="sub_contract_item">';
    html += '<input type="hidden" name="process_order_number" value="' + item.process_order_number + '"><br>';
   
    html += '<div class="sub_contract_field">';
    html +=
        '<label>Sub-Contract Action:</label>' +
        '<input type="text" name="sub_contract_action" value="' + item.sub_contract_action + '" >';
    html += '</div><br>';

    html += '<div class="sub_contract_field">';
    html +=
        '<label>Sign-off for Sub-Contract:</label>' +
        '<input type="text" name="sign_off_sub_contract" value="' + item.sign_off_sub_contract + '" >';
    html += '</div><br>';

    html += '<div class="sub_contract_field">';
    html +=
        '<label>Comments for Sub-Contract:</label>' +
        '<textarea name="comments_sub_contract">' + item.comments_sub_contract + '</textarea>';
    html += '</div><br>';

    html += '<div class="sub_contract_field">';
    html +=
        '<label>Submission Date:</label>' +
        '<input type="text" name="submission_date" value="' + item.submission_date + '" disabled>';
    html += '</div><br>';

    // Quantity Field
    html += '<div class="sub_contract_field">';
    html +=
        '<label>Quantity:</label>' +
        '<input type="number" name="quantity" value="' + item.quantity + '" >';
    html += '</div><br>';

    html += '</div>'; // Closing div for sub_contract_item
    html += '<hr>'; // Horizontal line for separation

    html += '<input type="button" value="Submit" onclick="submitCompleteSubContractForm()">';
    html += '  <input type="button" value="View" onclick="viewCompleteSubContractForm()">';
    html += '</form>';

    html += '<div id="complete_sub_contract_results"></div>';
    html += '</fieldset>';

    return html;
}
function submitCompleteSubContractForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        sign_off_sub_contract: 0, // Change this according to your needs
        comments_sub_contract: document.querySelector('[name="comments_sub_contract"]').value,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number: document.querySelector('[name="process_order_number"]').value, // Change this according to your needs
        sub_contract_action: document.querySelector('[name="sub_contract_action"]').value,
        sign_off_sub_contract: document.querySelector('[name="sign_off_sub_contract"]').value,
        // Add other form fields accordingly
    };

    console.log(formData);
    $.ajax({
        type: "POST",
        url: "/submitSubContractCompleteForm",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}
function viewCompleteSubContractForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: document.querySelector('[name="process_order_number"]').value,
    };
    $.ajax({
        type: "POST",
        url: "/viewSubContractCompleteForm",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            displayCompleteSubContractResults(response);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}
function displayCompleteSubContractResults(values) {
    var resultsHtml = '<table id="complete_sub_contract_results_table" style="width:100%; border: 1px solid #ddd; text-align: left;">';
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

    document.getElementById('complete_sub_contract_results').innerHTML = resultsHtml;
}
