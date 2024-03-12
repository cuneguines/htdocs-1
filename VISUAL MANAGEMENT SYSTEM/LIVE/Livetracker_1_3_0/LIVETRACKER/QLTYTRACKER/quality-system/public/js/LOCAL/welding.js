function generateWeldingFieldset(processOrder, qualityStep, username) {
    $("#sign_off_welding").val(username);
    return `
    <fieldset>
        <legend>Welding Tasks</legend>

        <!-- Task 7.1: Weld Map -->
        <div class="form-group">
            <label>Weld Map: Weld Map issued to production</label>
            <input type="checkbox" name="weld_map_issued">
            <label class="upload-label">Link to Weld Map: <input type="file" name="link_to_weld_map" required></label>
        </div>

        <!-- Task 7.2: Weld Procedure Qualification Record -->
        <div class="form-group">
            <label>Weld Procedure Qualification Record: EN ISO 15614</label>
            <input type="checkbox" name="weld_procedure_qualification">
            <label class="upload-label">Link to PQR: <input type="file" name="link_to_pqr" required></label>
        </div>

        <!-- Task 7.3: Weld Procedure Specifications -->
        <div class="form-group">
            <label>Weld Procedure Specifications: EN ISO 15615</label>
            <input type="checkbox" name="weld_procedure_specifications">
            <label class="upload-label">Link to Approved WPS: <input type="file" name="link_to_wps" required></label>
        </div>

        <!-- Task 7.4: Welder Performance Qualification -->
        <div class="form-group">
            <label>Welder Performance Qualification: EN 9606</label>
            <input type="checkbox" name="welder_performance_qualification">
            <label class="upload-label">Link to WPQ Certificate: <input type="file" name="link_to_wpq" required></label>
        </div>

        <!-- Task 7.5: Welding Consumable - Welding Wire -->
        <div class="form-group">
            <label>Welding Consumable - Welding Wire: EN 1024 Type 3.1</label>
            <input type="checkbox" name="welding_wire">
            <label class="upload-label">Link to Material Certificate: <input type="file" name="link_to_wire_certificate" required></label>
        </div>

        <!-- Task 7.6: Welding Consumable - Shielding Gas -->
        <div class="form-group">
            <label>Welding Consumable - Shielding Gas: EN ISO 14175</label>
            <input type="checkbox" name="shielding_gas">
            <label class="upload-label">Link to Gas Data Sheet: <input type="file" name="link_to_gas_data_sheet" required></label>
        </div>

        <!-- Task 7.7: Pre-Weld inspection -->
        <div class="form-group">
            <label>Pre-Weld inspection: Check weld joint preparation against WPS</label>
            <input type="checkbox" name="pre_weld_inspection">
        </div>

        <!-- Task 7.8: Inspection During Welding -->
        <div class="form-group">
            <label>Inspection During Welding: Check requirements of the WPS</label>
            <input type="checkbox" name="inspection_during_welding">
        </div>

        <!-- Task 7.9: Post-Weld Inspection -->
        <div class="form-group">
            <label>Post-Weld Inspection: Visual weld inspection - All Welds</label>
            <input type="checkbox" name="post_weld_inspection">
        </div>
        <!-- Task 7.9.1: Welding Plant Calibration Certificate -->
        <div class="form-group">
            <label>Welding Plant Calibration Certificate: Check weld log for welding plant number</label>
            <input type="checkbox" name="welding_plant_calibration_certificate">
            <label class="upload-label">Link to Plant Cert: <input type="file" name="link_to_plant_cert" required></label>
        </div>
        <!-- Sign-off for Welding Tasks -->
        <div class="form-group">
            <label>Sign-off for Welding Tasks:</label>
            <input type="text" name="sign_off_welding" value="${username}">
        </div>

        <!-- Comments for Welding Tasks -->
        <div class="form-group">
            <label>Comments for Welding Tasks:</label>
            <textarea name="comments_welding" rows="4" cols="50"></textarea>
        </div>

        <!-- Submit button -->
        <button type="submit" onclick="submitWeldingForm('${processOrder}')">Submit Welding Form</button>
    </fieldset>
    `;
}

function submitWeldingForm(processOrder) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }

    var formData = {
        weld_map_issued: document.querySelector('[name="weld_map_issued"]').checked || null,
        link_to_weld_map: getFileName('link_to_weld_map') || null,
        weld_procedure_qualification: document.querySelector('[name="weld_procedure_qualification"]').checked || null,
        link_to_pqr: getFileName('link_to_pqr') || null,
        weld_procedure_specifications: document.querySelector('[name="weld_procedure_specifications"]').checked || null,
        link_to_wps: getFileName('link_to_wps') || null,
        welder_performance_qualification: document.querySelector('[name="welder_performance_qualification"]').checked || null,
        link_to_wpq: getFileName('link_to_wpq') || null,
        welding_wire: document.querySelector('[name="welding_wire"]').checked || null,
        link_to_wire_certificate: getFileName('link_to_wire_certificate') || null,
        link_to_plant_cert: getFileName('link_to_plant_cert') || null,
        shielding_gas: document.querySelector('[name="shielding_gas"]').checked || null,
        link_to_gas_data_sheet: getFileName('link_to_gas_data_sheet') || null,
        pre_weld_inspection: document.querySelector('[name="pre_weld_inspection"]').checked || null,
        inspection_during_welding: document.querySelector('[name="inspection_during_welding"]').checked || null,
        post_weld_inspection: document.querySelector('[name="post_weld_inspection"]').checked || null,
        sign_off_welding: document.querySelector('[name="sign_off_welding"]').value.trim() || null,
        comments_welding: document.querySelector('[name="comments_welding"]').value.trim() || null,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number: processOrder,
    };

    $.ajax({
        url: "/submitWeldingForm",
        type: "POST",
        data: formData,
        headers: headers,
        success: function (response) {
            console.log(response);
            alert("Form submitted successfully!");
        },
        error: function (error) {
            console.error(error);
            alert("Error submitting form. Please try again.");
        },
    });

    // File uploads
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

    // Send an AJAX request for file uploads
    $.ajax({
        url: '/handleFileUploadWelding',
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

    console.log('Welding form submitted!');
}
// Function to generate the welding tasks field table
function generateWeldingFieldTable(processOrder, qualityStep) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: processOrder,
    };

    $.ajax({
        url: "/getWeldingDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML = generateHTMLFromResponse_for_welding(response);
            $("#weldingFieldTable").html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        },
    });

    return `
        <div>To be Done</div>
    `;
}

// Function to generate HTML table from welding tasks response
function generateHTMLFromResponse_for_welding(response) {
    var html = '<table id="welding_table" style="width:100%;">';
    html +=
        '<thead><tr><th style="width:5%;">ID</th><th style="width:25%;">Task</th><th style="width:25%;">Specification</th><th style="width:25%;">Responsible</th><th style="width:20%;">Action</th></tr></thead><tbody>';

    $.each(response, function (index, item) {
        html += "<tr>";
        html += "<td>" + item.Id + "</td>";
        html += "<td>" + item.Task + "</td>";
        html += "<td>" + item.Specification + "</td>";
        html += "<td>" + item.Responsible + "</td>";

        // Action column for file download
        html += '<td>';
        if (item.Link) {
            var filePath = 'storage/welding_task/' + item.ProcessOrder + '/' + item.Link;
            var downloadLink = '<a href="' + filePath + '" download>Download</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</td>';

        html += "</tr>";
    });

    html += "</tbody></table>";

    return html;
}

// Function to generate the welding tasks completion form
function generateWeldingCompleteFieldset(processOrder, qualityStep, username) {
    var formData = {
        process_order_number: processOrder,
    };
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    $("#sign_off_welding_complete").val(username);

    $.ajax({
        url: "/getWeldingDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML = generateCompleteHTMLFromResponse_for_welding(response);
            $("#weldingCompleteFieldTable").html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        },
    });
}

// Function to generate HTML for the welding tasks completion form
function generateCompleteHTMLFromResponse_for_welding(response) {
    var html = '<fieldset><legend>Welding Tasks Complete</legend>';
    html += '<form id="welding_complete_form">';

    $.each(response, function (index, item) {
        html += '<div class="welding_item">';
        html += '<label>ID: ' + item.id + '</label><br>';

        // Weld Map
        html += '<div class="welding_field">';
        html +=
            '<label>Weld Map:</label>' +
            (item.weld_map_issued === "true" || item.weld_map_issued === "on" ?
            '<input type="checkbox" id="weld_map_issued" name="weld_map_issued" >' :
            '<input type="checkbox" id="weld_map_issued" name="weld_map_issued" disabled>') +
            '</div><br>';

        // Link to Weld Map
        html += '<div class="welding_field">';
        html +=
            '<label>Link to Weld Map:</label>' +
            '<input type="text" name="link_to_weld_map" value="' + item.link_to_weld_map + '">' +
            '</div><br>';

        // Weld Procedure Qualification Record
        html += '<div class="welding_field">';
        html +=
            '<label>Weld Procedure Qualification Record:</label>' +
            (item.weld_procedure_qualification === "true" || item.weld_procedure_qualification === "on" ?
            '<input type="checkbox" id="weld_procedure_qualification" name="weld_procedure_qualification" >' :
            '<input type="checkbox" id="weld_procedure_qualification" name="weld_procedure_qualification" disabled>') +
            '</div><br>';

        // Link to PQR
        html += '<div class="welding_field">';
        html +=
            '<label>Link to PQR:</label>' +
            '<input type="text" name="link_to_pqr" value="' + item.link_to_pqr + '">' +
            '</div><br>';

        // Weld Procedure Specifications
        html += '<div class="welding_field">';
        html +=
            '<label>Weld Procedure Specifications:</label>' +
            (item.weld_procedure_specifications === "true" || item.weld_procedure_specifications === "on" ?
            '<input type="checkbox" id="weld_procedure_specifications" name="weld_procedure_specifications" >' :
            '<input type="checkbox" id="weld_procedure_specifications" name="weld_procedure_specifications" disabled>') +
            '</div><br>';

        // Link to Approved WPS
        html += '<div class="welding_field">';
        html +=
            '<label>Link to Approved WPS:</label>' +
            '<input type="text" name="link_to_wps" value="' + item.link_to_wps + '">' +
            '</div><br>';

        // Welder Performance Qualification
        html += '<div class="welding_field">';
        html +=
            '<label>Welder Performance Qualification:</label>' +
            (item.welder_performance_qualification === "true" || item.welder_performance_qualification === "on" ?
            '<input type="checkbox" id="welder_performance_qualification" name="welder_performance_qualification" >' :
            '<input type="checkbox" id="welder_performance_qualification" name="welder_performance_qualification" disabled>') +
            '</div><br>';

        // Link to WPQ Certificate
        html += '<div class="welding_field">';
        html +=
            '<label>Link to WPQ Certificate:</label>' +
            '<input type="text" name="link_to_wpq" value="' + item.link_to_wpq + '">' +
            '</div><br>';

        // Welding Consumable - Welding Wire
        html += '<div class="welding_field">';
        html +=
            '<label>Welding Consumable - Welding Wire:</label>' +
            (item.welding_wire === "true" || item.welding_wire === "on" ?
            '<input type="checkbox" id="welding_wire" name="welding_wire" >' :
            '<input type="checkbox" id="welding_wire" name="welding_wire" disabled>') +
            '</div><br>';

        // Link to Material Certificate
        html += '<div class="welding_field">';
        html +=
            '<label>Link to Material Certificate:</label>' +
            '<input type="text" name="link_to_wire_certificate" value="' + item.link_to_wire_certificate + '">' +
            '</div><br>';

        // Welding Consumable - Shielding Gas
        html += '<div class="welding_field">';
        html +=
            '<label>Welding Consumable - Shielding Gas:</label>' +
            (item.shielding_gas === "true" || item.shielding_gas === "on" ?
            '<input type="checkbox" id="shielding_gas" name="shielding_gas" >' :
            '<input type="checkbox" id="shielding_gas" name="shielding_gas" disabled>') +
            '</div><br>';

        // Link to Gas Data Sheet
        html += '<div class="welding_field">';
        html +=
            '<label>Link to Gas Data Sheet:</label>' +
            '<input type="text" name="link_to_gas_data_sheet" value="' + item.link_to_gas_data_sheet + '">' +
            '</div><br>';

        // Pre-Weld inspection
        html += '<div class="welding_field">';
        html +=
            '<label>Pre-Weld inspection:</label>' +
            (item.pre_weld_inspection === "true" || item.pre_weld_inspection === "on" ?
            '<input type="checkbox" id="pre_weld_inspection" name="pre_weld_inspection" >' :
            '<input type="checkbox" id="pre_weld_inspection" name="pre_weld_inspection" disabled>') +
            '</div><br>';

        // Inspection During Welding
        html += '<div class="welding_field">';
        html +=
            '<label>Inspection During Welding:</label>' +
            (item.inspection_during_welding === "true" || item.inspection_during_welding === "on" ?
            '<input type="checkbox" id="inspection_during_welding" name="inspection_during_welding" >' :
            '<input type="checkbox" id="inspection_during_welding" name="inspection_during_welding" disabled>') +
            '</div><br>';

        // Post-Weld Inspection
        html += '<div class="welding_field">';
        html +=
            '<label>Post-Weld Inspection:</label>' +
            (item.post_weld_inspection === "true" || item.post_weld_inspection === "on" ?
            '<input type="checkbox" id="post_weld_inspection" name="post_weld_inspection" >' :
            '<input type="checkbox" id="post_weld_inspection" name="post_weld_inspection" disabled>') +
            '</div><br>';

        // Sign Off
        html += '<div class="welding_field">';
        html +=
            '<label>Sign Off:</label>' +
            '<input type="text" name="sign_off_welding_complete" value="' + item.sign_off_welding + '">' +
            '</div><br>';

        // Comments
        html += '<div class="welding_field">';
        html +=
            '<label>Comments:</label>' +
            '<input type="text" name="comments_welding_complete" value="' + item.comments_welding + '">' +
            '</div><br>';

        // Status dropdown
        html += '<div class="welding_field">';
        html +=
            '<label>Status:</label>' +
            '<select name="status">' +
            '<option value="partially_completed">Partially Completed</option>' +
            '<option value="completed">Completed</option>' +
            '</select>' +
            '</div><br>';

        html += '</div>'; // Closing div for welding_item
        html += '<hr>'; // Horizontal line for separation
    });

    html += '<input type="button" value="Submit" onclick="submitWeldingCompleteForm()">';
    html += '</form>';

    html += '<div id="welding_complete_results"></div>';
    html += '</fieldset>';

    return html;
}

// Function to submit the welding tasks completion form
function submitWeldingCompleteForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        weld_map_issued: document.querySelector('[name="weld_map_issued"]').checked ? "on" : "",
        link_to_weld_map: document.querySelector('[name="link_to_weld_map"]').value,
        weld_procedure_qualification: document.querySelector('[name="weld_procedure_qualification"]').checked ? "on" : "",
        link_to_pqr: document.querySelector('[name="link_to_pqr"]').value,
        weld_procedure_specifications: document.querySelector('[name="weld_procedure_specifications"]').checked ? "on" : "",
        link_to_wps: document.querySelector('[name="link_to_wps"]').value,
        welder_performance_qualification: document.querySelector('[name="welder_performance_qualification"]').checked ? "on" : "",
        link_to_wpq: document.querySelector('[name="link_to_wpq"]').value,
        welding_wire: document.querySelector('[name="welding_wire"]').checked ? "on" : "",
        link_to_wire_certificate: document.querySelector('[name="link_to_wire_certificate"]').value,
        shielding_gas: document.querySelector('[name="shielding_gas"]').checked ? "on" : "",
        link_to_gas_data_sheet: document.querySelector('[name="link_to_gas_data_sheet"]').value,
        pre_weld_inspection: document.querySelector('[name="pre_weld_inspection"]').checked ? "on" : "",
        inspection_during_welding: document.querySelector('[name="inspection_during_welding"]').checked ? "on" : "",
        post_weld_inspection: document.querySelector('[name="post_weld_inspection"]').checked ? "on" : "",
        sign_off_welding_complete: document.querySelector('[name="sign_off_welding_complete"]').value,
        comments_welding_complete: document.querySelector('[name="comments_welding_complete"]').value,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number: 2, // Update with actual process order number
    };

    $.ajax({
        type: "POST",
        url: "/submitWeldingCompleteForm",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            displayWeldingCompleteResults(response);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}

// Function to display the welding tasks completion results
function displayWeldingCompleteResults(values) {
    var resultsHtml = '<table id="welding_complete_results_table" style="width:100%; border-collapse: collapse; border: 1px solid #ddd; text-align: left;">';
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

    document.getElementById('welding_complete_results').innerHTML = resultsHtml;
}
