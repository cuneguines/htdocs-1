function generateTestingFieldset(processOrder, qualityStep, username) {
    $("#sign_off_testing").val(username);
    return `
    <fieldset>
    <legend>Testing</legend>

    <!-- Subtask 8.1: Dye Penetrant Procedure -->
    <div class="form-group">
        <label>
            Dye Penetrant Procedure:
            <input type="checkbox" name="dye_pen_test" onchange="toggleDropdown(this, 'dye_pen_document_ref')">
            <select name="dye_pen_document_ref" disabled>
            <option value="NULL">NULL</option>
                <option value="Document_REF_1">Document REF 1</option>
                <option value="Document_REF_2">Document REF 2</option>
                <option value="Document_REF_3">Document REF 3</option>
                <!-- Add more options as needed -->
            </select>
        </label>
    </div>

    <!-- Subtask 8.2: Hydrostatic Leak Test -->
    <div class="form-group">
        <label>
            Hydrostatic Leak Test:
            <input type="checkbox" name="hydrostatic_test" onchange="toggleDropdown(this, 'hydrostatic_test_document_ref')">
            <select name="hydrostatic_test_document_ref" disabled>
            <option value="NULL">NULL</option>
                <option value="Document_REF_1">Document REF 1</option>
                <option value="Document_REF_2">Document REF 2</option>
                <option value="Document_REF_3">Document REF 3</option>
                <!-- Add more options as needed -->
            </select>
        </label>
    </div>

    <!-- Subtask 8.3: Pneumatic Leak Test -->
    <div class="form-group">
        <label>
            Pneumatic Leak Test:
            <input type="checkbox" name="pneumatic_test" onchange="toggleDropdown(this, 'pneumatic_test_document_ref')">
            <select name="pneumatic_test_document_ref" disabled>
            <option value="NULL">NULL</option>
                <option value="Document_REF_1">Document REF 1</option>
                <option value="Document_REF_2">Document REF 2</option>
                <option value="Document_REF_3">Document REF 3</option>
                <!-- Add more options as needed -->
            </select>
        </label>
    </div>

    <!-- Subtask 8.4: FAT -->
    <div class="form-group">
        <label>
            FAT:
            <input type="checkbox" name="fat_protocol" onchange="toggleDropdown(this, 'fat_protocol_document_ref')">
            <select name="fat_protocol_document_ref" disabled>
            <option value="NULL">NULL</option>
                <option value="Document_REF_1">Document REF 1</option>
                <option value="Document_REF_2">Document REF 2</option>
                <option value="Document_REF_3">Document REF 3</option>
                <!-- Add more options as needed -->
            </select>
        </label>
    </div>

    <!-- Upload Testing Documents -->
    <div class="form-group">
        <label>
            Upload Testing Documents:
            <input type="file" name="testing_documents" multiple>
        </label>
    </div>

    <!-- Sign-off for Testing -->
    <div class="form-group">
        <label>
            Sign-off for Testing:
            <input type="text" name="sign_off_testing" value="${username}">
        </label>
    </div>

    <!-- Comments for Testing -->
    <div class="form-group">
        <label>
            Comments for Testing:
            <textarea name="comments_testing" rows="4" cols="50"></textarea>
        </label>
    </div>

    <!-- Submit button -->
    <button type="button" onclick="submitTestingForm('${processOrder}')">Submit Testing Form</button>
</fieldset>
    `;
}

function toggleDropdown(checkbox, dropdownName) {
    var dropdown = checkbox.parentElement.querySelector(`select[name="${dropdownName}"]`);
    dropdown.disabled = !checkbox.checked;
}


function submitTestingForm(processOrder) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };
    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }
    var formData = new FormData();
    formData.set('dye_pen_document_ref', document.querySelector('[name="dye_pen_document_ref"]').value);
    formData.set('hydrostatic_test_document_ref', document.querySelector('[name="hydrostatic_test_document_ref"]').value);
    formData.set('pneumatic_test_document_ref', document.querySelector('[name="pneumatic_test_document_ref"]').value);
    formData.set('fat_protocol_document_ref', document.querySelector('[name="fat_protocol_document_ref"]').value);
    formData.set('sign_off_testing', document.querySelector('[name="sign_off_testing"]').value);
    formData.set('comments_testing', document.querySelector('[name="comments_testing"]').value);
    formData.set('submission_date', new Date().toISOString().split("T")[0]); // Get today's date in YYYY-MM-DD format
    formData.set('process_order_number', processOrder);

    // Checkbox values
    formData.set('dye_pen_test', document.querySelector('[name="dye_pen_test"]').checked ? 1 : 0);
    formData.set('hydrostatic_test', document.querySelector('[name="hydrostatic_test"]').checked ? 1 : 0);
    formData.set('pneumatic_test', document.querySelector('[name="pneumatic_test"]').checked ? 1 : 0);
    formData.set('fat_protocol', document.querySelector('[name="fat_protocol"]').checked ? 1 : 0);
  
    formData.append('testing_document_file_name', getFileName('testing_documents'));
console.log(formData);
    // Send an AJAX request to the server
    $.ajax({
        url: "/submitTestingForm",
        type: "POST",
        data: formData,
        headers: headers,
        processData: false, // Prevent jQuery from automatically processing the data
        contentType: false, // Prevent jQuery from setting content type
        success: function (response) {
            console.log(response);
            alert("Testing form submitted successfully");
            // Optionally update the table or perform other actions
        },
        error: function (error) {
            console.error("Error:", error);
            alert("Error submitting Testing form");
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
        url: '/handleFileUploadTesting',  // Update to your actual route
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


function generateTestingFieldTable(processOrder, qualityStep) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: processOrder,
    };

    $.ajax({
        url: "/getTestingDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML =
                generateHTMLFromResponse_for_testing(response);

            $("#testingFieldTable").html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        },
    });

    return `
            <div>To be Done</div>
        `;
}

function generateHTMLFromResponse_for_testing(response) {
    var html = '<table id="common_table" style="width:100%;">';
    html += '<thead><tr>';
    html += '<th style="width:5%;">Testing ID</th>';
    html += '<th style="width:20%;">Process Order</th>';
    html += '<th style="width:20%;">Dye Penetrant Procedure Ref</th>';
    html += '<th style="width:20%;">Hydrostatic Leak Test Ref</th>';
    html += '<th style="width:20%;">Pneumatic Leak Test Ref</th>';
    html += '<th style="width:20%;">FAT Ref</th>';
    html += '<th style="width:20%;">Dye Penetrant Test</th>';
    html += '<th style="width:20%;">Hydrostatic Leak Test</th>';
    html += '<th style="width:20%;">Pneumatic Leak Test</th>';
    html += '<th style="width:20%;">FAT Test</th>';
    html += '<th style="width:10%;">Sign-off for Testing</th>';
    html += '<th style="width:10%;">Testing Files</th>';
    html += '<th style="width:20%;">Comments for Testing</th>';
    html += '<th style="width:20%;">Submitted Date Time</th>';
    html += '<th style="width:5%;">Created At</th>';
    html += '<th style="width:5%;">Updated At</th>';
    html += '</tr></thead><tbody>';

    $.each(response, function (index, item) {
        html += "<tr>";
        html += "<td>" + item.id + "</td>";
        html += "<td>" + item.process_order_number + "</td>";
        html += "<td>" + item.dye_pen_document_ref + "</td>";
        html += "<td>" + item.hydrostatic_test_document_ref + "</td>";
        html += "<td>" + item.pneumatic_test_document_ref + "</td>";
        html += "<td>" + item.fat_protocol_document_ref + "</td>";
        html += "<td>" + (item.dye_pen_test === "1" ? "✔" : "") + "</td>";
        html += "<td>" + (item.hydrostatic_test === "1" ? "✔" : "") + "</td>";
        html += "<td>" + (item.pneumatic_test === "1" ? "✔" : "") + "</td>";
        html += "<td>" + (item.fat_protocol === "1" ? "✔" : "") + "</td>";
        html += '<td style="text-align:center;">' + (item.sign_off_testing === "1" ? "✔" : "") + "</td>";
        html += '<td style="text-align:center;">';

        if (item.testing_document_file_name) {
            var filePath = 'storage/testing_task/' + item.process_order_number + '/' + item.testing_document_file_name;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</td>';
        
        html += "<td>" + item.comments_testing + "</td>";
        html += "<td>" + item.submission_date + "</td>";
        html += "<td>" + item.created_at + "</td>";
        html += "<td>" + item.updated_at + "</td>";
        html += "</tr>";
    });

    html += "</tbody></table>";

    return html;
}

function generateTestingCompleteFieldset(processOrder, qualityStep, username) {
    console.log(processOrder);
    var formData = {
        process_order_number: processOrder,
    };
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    $("#sign_off_testing").val(username);

    $.ajax({
        url: "/getTestingDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);

            if (response.data !== null) {
                var generatedHTML = generateCompleteHTMLFromResponse_for_testing(response.data);
                $("#testingCompleteFieldTable").html(generatedHTML);
            } else {
                $("#testingCompleteFieldTable").html('');
            }
        },
        error: function (error) {
            console.error(error);
        },
    });
}

function generateCompleteHTMLFromResponse_for_testing(item) {
    console.log(item);
    var html = '<fieldset><legend>Testing Complete</legend>';
    html += '<form id="testing_complete_form">';
    
    html += '<div class="testing_item">';
    html += '<label>ID: ' + item.id + '</label><br>';
    html += '<div class="testing_item">';
    html += '<label>Process Order: ' + item.process_order_number + '</label><br>';
    html += '<div class="testing_item">';
    html += '<input type="hidden" name="process_order_number" value="' + item.process_order_number + '"><br>';
   
    html += '<div class="testing_field">';
    html +=
        '<label>Dye Penetrant Test:</label>' +
        (item.dye_pen_test === "1" ?
            '<input type="checkbox" id="dye_pen_test" name="dye_pen_test" >' :
            '<input type="checkbox" id="dye_pen_test" name="dye_pen_test" disabled>');
    html += '</div><br>';

    html += '<div class="testing_field">';
    html +=
        '<label>Dye Penetrant Document Ref:</label>' +
        '<input type="text" name="dye_pen_document_ref" value="' + item.dye_pen_document_ref + '" disabled>';
    html += '</div><br>';

    html += '<div class="testing_field">';
    html +=
        '<label>Hydrostatic Leak Test:</label>' +
        (item.hydrostatic_test === "1" ?
            '<input type="checkbox" id="hydrostatic_test" name="hydrostatic_test" >' :
            '<input type="checkbox" id="hydrostatic_test" name="hydrostatic_test" disabled>');
    html += '</div><br>';

    html += '<div class="testing_field">';
    html +=
        '<label>Hydrostatic Leak Test Document Ref:</label>' +
        '<input type="text" name="hydrostatic_test_document_ref" value="' + item.hydrostatic_test_document_ref + '" disabled>';
    html += '</div><br>';

    html += '<div class="testing_field">';
    html +=
        '<label>Pneumatic Leak Test:</label>' +
        (item.pneumatic_test === "1" ?
            '<input type="checkbox" id="pneumatic_test" name="pneumatic_test" >' :
            '<input type="checkbox" id="pneumatic_test" name="pneumatic_test" disabled>');
    html += '</div><br>';

    html += '<div class="testing_field">';
    html +=
        '<label>Pneumatic Leak Test Document Ref:</label>' +
        '<input type="text" name="pneumatic_test_document_ref" value="' + item.pneumatic_test_document_ref + '" disabled>';
    html += '</div><br>';

    html += '<div class="testing_field">';
    html +=
        '<label>FAT Protocol:</label>' +
        (item.fat_protocol === "1" ?
            '<input type="checkbox" id="fat_protocol" name="fat_protocol" >' :
            '<input type="checkbox" id="fat_protocol" name="fat_protocol" disabled>');
    html += '</div><br>';

    html += '<div class="testing_field">';
    html +=
        '<label>Status:</label>' +
        '<select id="status" name="status">' +
        '<option value="Completed" ' + (item.status === "Completed" ? 'selected' : '') + '>Completed</option>' +
        '<option value="Partially Completed" ' + (item.status === "Partially Completed" ? 'selected' : '') + '>Partially Completed</option>' +
        '</select>';
    html += '</div><br>';
    html += '<input  name="comments_testing" value="' + item.comments_testing + '"><br>';
    // Quantity Field
    html += '<div class="testing_field">';
    html +=
        '<label>Quantity:</label>' +
        '<input type="number" id="quantity" name="quantity" value="' + item.quantity + '" >';
    html += '</div><br>';

    html += '</div>'; // Closing div for testing_item
    html += '<hr>'; // Horizontal line for separation

    html += '<input type="button" value="Submit" onclick="submitTestingCompleteForm()">';
    html += '  <input type="button" value="View" onclick="viewTestingCompleteForm()">';
    html += '</form>';

    html += '<div id="testing_complete_results"></div>';
    html += '</fieldset>';

    return html;
}

function submitTestingCompleteForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        sign_off_testing: 0, // Change this according to your needs
        comments_testing: document.querySelector('[name="comments_testing"]').value,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number: document.querySelector('[name="process_order_number"]').value, // Change this according to your needs
        dye_pen_test: document.querySelector('[name="dye_pen_test"]').checked ? "1" : '',
        dye_pen_document_ref: document.querySelector('[name="dye_pen_document_ref"]').value,
        hydrostatic_test: document.querySelector('[name="hydrostatic_test"]').checked ? 1 : 0,
        hydrostatic_test_document_ref: document.querySelector('[name="hydrostatic_test_document_ref"]').value,
        pneumatic_test: document.querySelector('[name="pneumatic_test"]').checked ? 1 : 0,
        pneumatic_test_document_ref: document.querySelector('[name="pneumatic_test_document_ref"]').value,
        fat_protocol: document.querySelector('[name="fat_protocol"]').checked ? 1 : 0,
        status: document.querySelector('#status').value,
        quantity: document.querySelector('[name="quantity"]').value,
        // Add other form fields accordingly
    };

    console.log(formData);
    $.ajax({
        type: "POST",
        url: "/submitTestingCompleteForm",
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




function viewTestingCompleteForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: document.querySelector('[name="process_order_number"]').value,
    };
    $.ajax({
        type: "POST",
        url: "/viewTestingCompleteForm",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            displayTestingCompleteResults(response);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}

function displayTestingCompleteResults(values) {
    var resultsHtml = '<table id="testing_complete_results_table" style="width:100%; border: 1px solid #ddd; text-align: left;">';
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

    document.getElementById('testing_complete_results').innerHTML = resultsHtml;
}
