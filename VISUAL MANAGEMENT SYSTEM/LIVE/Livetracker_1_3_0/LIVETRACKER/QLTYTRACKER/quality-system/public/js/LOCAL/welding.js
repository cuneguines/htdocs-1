function generateWeldingFieldset(processOrder, qualityStep, username) {
    $("#sign_off_welding").val(username);
    return `
    
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
        weld_map_issued:
            document.querySelector('[name="weld_map_issued"]').checked || null,
        link_to_weld_map:
            document.querySelector('[name="link_to_weld_map"]').files.length > 0
                ? document.querySelector('[name="link_to_weld_map"]').files[0].name
                : document.getElementById("old_weld_map_filename").textContent.trim(),

        weld_procedure_qualification:
            document.querySelector('[name="weld_procedure_qualification"]').checked || null,
        link_to_pqr:
            document.querySelector('[name="link_to_pqr"]').files.length > 0
                ? document.querySelector('[name="link_to_pqr"]').files[0].name
                : document.getElementById("old_pqr_filename").textContent.trim(),

        weld_procedure_specifications:
            document.querySelector('[name="weld_procedure_specifications"]').checked || null,
        link_to_wpq:
            document.querySelector('[name="link_to_wpq"]').files.length > 0
                ? document.querySelector('[name="link_to_wpq"]').files[0].name
                : document.getElementById("old_wpq_filename").textContent.trim(),

        welder_performance_qualification:
            document.querySelector('[name="welder_performance_qualification"]').checked || null,

       
        welding_wire:
            document.querySelector('[name="welding_wire"]').checked || null,
        link_to_wire_certificate:
            document.querySelector('[name="link_to_wire_certificate"]').files.length > 0
                ? document.querySelector('[name="link_to_wire_certificate"]').files[0].name
                : document.getElementById("old_wire_certificate_filename").textContent.trim(),

        link_to_plant_cert:
            document.querySelector('[name="link_to_plant_cert"]').files.length >0
                ? document.querySelector('[name="link_to_plant_cert"]').files[0].name
                : document.getElementById("old_plant_cert_filename").textContent.trim(),
        shielding_gas:
            document.querySelector('[name="shielding_gas"]').checked || null,
        link_to_gas_data_sheet:
            document.querySelector('[name="link_to_gas_data_sheet"]').files.length > 0
                ? document.querySelector('[name="link_to_gas_data_sheet"]').files[0].name
                : document.getElementById("old_gas_data_sheet_filename").textContent.trim(),

        pre_weld_inspection:
            document.querySelector('[name="pre_weld_inspection"]').checked ||
            null,
        inspection_during_welding:
            document.querySelector('[name="inspection_during_welding"]')
                .checked || null,
        post_weld_inspection:
            document.querySelector('[name="post_weld_inspection"]').checked ||
            null,
        sign_off_welding:
            document.querySelector('[name="sign_off_welding"]').value.trim() ||
            null,
        comments_welding:
            document.querySelector('[name="comments_welding"]').value.trim() ||
            null,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number:  document.querySelector('[name="process_order_number_welding"]').value || null,
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
    fileData.append("process_order_number", document.querySelector('[name="process_order_number_welding"]').value);

    // Iterate over each file input and append files to FormData
    fileInputs.each(function (index, fileInput) {
        var files = fileInput.files;
        if (files.length > 0) {
            // Append each file to FormData
            $.each(files, function (i, file) {
                fileData.append(fileInput.name + "_" + i, file);
            });
        }
    });
    console.log(fileData);
    // Send an AJAX request for file uploads
    $.ajax({
        url: "/handleFileUploadWelding",
        type: "POST",
        data: fileData,
        headers: headers,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            alert("Files uploaded successfully");
        },
        error: function (error) {
            console.error(error);
            alert("Error uploading files");
        },
    });

    console.log("Welding form submitted!");
}
// Function to generate the welding tasks field table
function generateWeldingFieldTable(processOrder, qualityStep) {
    console.log(processOrder);
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
    var html =
        '<table id="common_table" style="width:100%; border: 1px solid #ddd">';
    html += "<thead><tr>";
    html += "<th>ID</th>";
    html += "<th>Weld_Map_Issued</th>";
    html += "<th>Link_to_Weld_Map</th>";
    html += "<th>Weld_Procedure_Qualification</th>";
    html += "<th>Link_to_PQR</th>";
    html += "<th>Weld_Procedure_Specifications</th>";
    html += "<th>Link_to_WPS</th>";
    html += "<th>Welder_Performance_Qualification</th>";
    html += "<th>Link_to_WPQ</th>";
    html += "<th>Welding_Wire</th>";
    html += "<th>Link_to_Wire_Certificate</th>";
    html += "<th>Shielding_Gas</th>";
    html += "<th>Link_to_Gas_Data_Sheet</th>";
    html += "<th>Pre_Weld_Inspection</th>";
    html += "<th>Inspection_During_Welding</th>";
    html += "<th>Post_Weld_Inspection</th>";
    html += "<th>Sign_Off_Welding_Complete</th>";
    html += "<th>Comments_Welding_Complete</th>";
    html += "<th>Status</th>";
    html += "<th>Submission_Date</th>";
    html += "<th>Created_At</th>";
    html += "<th>Updated_At</th>";
    html += "<th>Link_to_Plant_Cert</th>";
    html += "<th>Process_Order_ID</th>";
    html += "<th>Action</th>";
    html += "</tr></thead><tbody>";

    $.each(response, function (index, item) {
        html += "<tr>";
        html += "<td>" + item.Id + "</td>";
        html += "<td>" + item.weld_map_issued + "</td>";
        html += "<td>";
        if (item.link_to_weld_map) {
            var filePath =
                "storage/welding_task/" +
                item.ProcessOrderID +
                "/" +
                item.link_to_weld_map;
            var downloadLink =
                '<a href="' + filePath + '" download>Download</a>';
            html += downloadLink;
        } else {
            html += "-";
        }
        html += "</td>";
        html += "<td>" + item.weld_procedure_qualification + "</td>";
        html += "<td>";
        if (item.link_to_pqr) {
            var filePath =
                "storage/welding_task/" +
                item.ProcessOrderID +
                "/" +
                item.link_to_pqr;
            var downloadLink =
                '<a href="' + filePath + '" download>Download</a>';
            html += downloadLink;
        } else {
            html += "-";
        }
        html += "</td>";
        html += "<td>" + item.weld_procedure_specifications + "</td>";
        html += "<td>";
        if (item.link_to_wps) {
            var filePath =
                "storage/welding_task/" +
                item.ProcessOrderID +
                "/" +
                item.link_to_wps;
            var downloadLink =
                '<a href="' + filePath + '" download>Download</a>';
            html += downloadLink;
        } else {
            html += "-";
        }
        html += "</td>";
        html += "<td>" + item.welder_performance_qualification + "</td>";
        html += "<td>";
        if (item.link_to_wpq) {
            var filePath =
                "storage/welding_task/" +
                item.ProcessOrderID +
                "/" +
                item.link_to_wpq;
            var downloadLink =
                '<a href="' + filePath + '" download>Download</a>';
            html += downloadLink;
        } else {
            html += "-";
        }
        html += "</td>";
        html += "<td>" + item.welding_wire + "</td>";
        html += "<td>";
        if (item.link_to_wire_certificate) {
            var filePath =
                "storage/welding_task/" +
                item.ProcessOrderID +
                "/" +
                item.link_to_wire_certificate;
            var downloadLink =
                '<a href="' + filePath + '" download>Download</a>';
            html += downloadLink;
        } else {
            html += "-";
        }
        html += "</td>";
        html += "<td>" + item.shielding_gas + "</td>";
        html += "<td>";
        if (item.link_to_gas_data_sheet) {
            var filePath =
                "storage/welding_task/" +
                item.ProcessOrderID +
                "/" +
                item.link_to_gas_data_sheet;
            var downloadLink =
                '<a href="' + filePath + '" download>Download</a>';
            html += downloadLink;
        } else {
            html += "-";
        }
        html += "</td>";
        html += "<td>" + item.pre_weld_inspection + "</td>";
        html += "<td>" + item.inspection_during_welding + "</td>";
        html += "<td>" + item.post_weld_inspection + "</td>";
        html += "<td>" + item.sign_off_welding_complete + "</td>";
        html += "<td>" + item.comments_welding_complete + "</td>";
        html += "<td>" + item.status + "</td>";
        html += "<td>" + item.submission_date + "</td>";
        html += "<td>" + item.created_at + "</td>";
        html += "<td>" + item.updated_at + "</td>";
        html += "<td>";
        if (item.link_to_plant_cert) {
            var filePath =
                "storage/welding_task/" +
                item.ProcessOrderID +
                "/" +
                item.link_to_plant_cert;
            var downloadLink =
                '<a href="' + filePath + '" download>Download</a>';
            html += downloadLink;
        } else {
            html += "-";
        }
        html += "</td>";

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
            if (response.data !== null) {
                var generatedHTML =
                    generateCompleteHTMLFromResponse_for_welding(response);
                $("#weldingCompleteFieldTable").html(generatedHTML);
            } else {
                $("#weldingCompleteFieldTable").html("");
            }
        },
        error: function (error) {
            console.error(error);
        },
    });
}

// Function to generate HTML for the welding tasks completion form
function generateCompleteHTMLFromResponse_for_welding(response) {
    var html = "<fieldset><legend>Welding Tasks Complete</legend>";
    html += '<form id="welding_complete_form">';

    $.each(response, function (index, item) {
        html += '<div class="welding_item">';
        html += "<label>ID: " + item.id + "</label><br>";

        html +=
            '<input type="hidden" name="processorder" value="' +
            item.ProcessOrderID +
            '"><br>';
        // Weld Map
        html += '<div class="welding_field">';
        html +=
            "<label>Weld Map:</label>" +
            (item.weld_map_issued === "true" || item.weld_map_issued === "on"
                ? '<input type="checkbox" id="weld_map_issued" name="weld_map_issued" >'
                : '<input type="checkbox" id="weld_map_issued" name="weld_map_issued" disabled>') +
            "</div><br>";

        // Link to Weld Map
        html += '<div class="welding_field">';
        html +=
            "<label>Link to Weld Map:</label>" +
            '<input type="text" name="link_to_weld_map" value="' +
            item.link_to_weld_map +
            '">' +
            "</div><br>";

        // Weld Procedure Qualification Record
        html += '<div class="welding_field">';
        html +=
            "<label>Weld Procedure Qualification Record:</label>" +
            (item.weld_procedure_qualification === "true" ||
            item.weld_procedure_qualification === "on"
                ? '<input type="checkbox" id="weld_procedure_qualification" name="weld_procedure_qualification" >'
                : '<input type="checkbox" id="weld_procedure_qualification" name="weld_procedure_qualification" disabled>') +
            "</div><br>";

        // Link to PQR
        html += '<div class="welding_field">';
        html +=
            "<label>Link to PQR:</label>" +
            '<input type="text" name="link_to_pqr" value="' +
            item.link_to_pqr +
            '">' +
            "</div><br>";

        // Weld Procedure Specifications
        html += '<div class="welding_field">';
        html +=
            "<label>Weld Procedure Specifications:</label>" +
            (item.weld_procedure_specifications === "true" ||
            item.weld_procedure_specifications === "on"
                ? '<input type="checkbox" id="weld_procedure_specifications" name="weld_procedure_specifications" >'
                : '<input type="checkbox" id="weld_procedure_specifications" name="weld_procedure_specifications" disabled>') +
            "</div><br>";

        // Link to Approved WPS
        html += '<div class="welding_field">';
        html +=
            "<label>Link to Approved WPS:</label>" +
            '<input type="text" name="link_to_wps" value="' +
            item.link_to_wps +
            '">' +
            "</div><br>";

        // Welder Performance Qualification
        html += '<div class="welding_field">';
        html +=
            "<label>Welder Performance Qualification:</label>" +
            (item.welder_performance_qualification === "true" ||
            item.welder_performance_qualification === "on"
                ? '<input type="checkbox" id="welder_performance_qualification" name="welder_performance_qualification" >'
                : '<input type="checkbox" id="welder_performance_qualification" name="welder_performance_qualification" disabled>') +
            "</div><br>";

        // Link to WPQ Certificate
        html += '<div class="welding_field">';
        html +=
            "<label>Link to WPQ Certificate:</label>" +
            '<input type="text" name="link_to_wpq" value="' +
            item.link_to_wpq +
            '">' +
            "</div><br>";

        // Welding Consumable - Welding Wire
        html += '<div class="welding_field">';
        html +=
            "<label>Welding Consumable - Welding Wire:</label>" +
            (item.welding_wire === "true" || item.welding_wire === "on"
                ? '<input type="checkbox" id="welding_wire" name="welding_wire" >'
                : '<input type="checkbox" id="welding_wire" name="welding_wire" disabled>') +
            "</div><br>";

        // Link to Material Certificate
        html += '<div class="welding_field">';
        html +=
            "<label>Link to Material Certificate:</label>" +
            '<input type="text" name="link_to_wire_certificate" value="' +
            item.link_to_wire_certificate +
            '">' +
            "</div><br>";

        // Welding Consumable - Shielding Gas
        html += '<div class="welding_field">';
        html +=
            "<label>Welding Consumable - Shielding Gas:</label>" +
            (item.shielding_gas === "true" || item.shielding_gas === "on"
                ? '<input type="checkbox" id="shielding_gas" name="shielding_gas" >'
                : '<input type="checkbox" id="shielding_gas" name="shielding_gas" disabled>') +
            "</div><br>";

        // Link to Gas Data Sheet
        html += '<div class="welding_field">';
        html +=
            "<label>Link to Gas Data Sheet:</label>" +
            '<input type="text" name="link_to_gas_data_sheet" value="' +
            item.link_to_gas_data_sheet +
            '">' +
            "</div><br>";

        // Pre-Weld inspection
        html += '<div class="welding_field">';
        html +=
            "<label>Pre-Weld inspection:</label>" +
            (item.pre_weld_inspection === "true" ||
            item.pre_weld_inspection === "on"
                ? '<input type="checkbox" id="pre_weld_inspection" name="pre_weld_inspection" >'
                : '<input type="checkbox" id="pre_weld_inspection" name="pre_weld_inspection" disabled>') +
            "</div><br>";

        // Inspection During Welding
        html += '<div class="welding_field">';
        html +=
            "<label>Inspection During Welding:</label>" +
            (item.inspection_during_welding === "true" ||
            item.inspection_during_welding === "on"
                ? '<input type="checkbox" id="inspection_during_welding" name="inspection_during_welding" >'
                : '<input type="checkbox" id="inspection_during_welding" name="inspection_during_welding" disabled>') +
            "</div><br>";

        // Post-Weld Inspection
        html += '<div class="welding_field">';
        html +=
            "<label>Post-Weld Inspection:</label>" +
            (item.post_weld_inspection === "true" ||
            item.post_weld_inspection === "on"
                ? '<input type="checkbox" id="post_weld_inspection" name="post_weld_inspection" >'
                : '<input type="checkbox" id="post_weld_inspection" name="post_weld_inspection" disabled>') +
            "</div><br>";

        // Sign Off
        html += '<div class="welding_field">';
        html +=
            "<label>Sign Off:</label>" +
            '<input type="text" name="sign_off_welding_complete" value="' +
            item.sign_off_welding +
            '">' +
            "</div><br>";

        // Comments
        html += '<div class="welding_field">';
        html +=
            "<label>Comments:</label>" +
            '<input type="text" name="comments_welding_complete" value="' +
            item.comments_welding +
            '">' +
            "</div><br>";

        // Status dropdown
        html += '<div class="welding_field">';
        html +=
            "<label>Status:</label>" +
            '<select name="status">' +
            '<option value="partially_completed">Partially Completed</option>' +
            '<option value="completed">Completed</option>' +
            "</select>" +
            "</div><br>";

        html += "</div>"; // Closing div for welding_item
        html += "<hr>"; // Horizontal line for separation
    });

    html +=
        '<input type="button" value="Submit" onclick="submitWeldingCompleteForm()">';
    html +=
        '  <input type="button" value="View" onclick="ViewWeldingCompleteForm()">';
    html += "</form>";

    html += '<div id="welding_complete_results"></div>';
    html += "</fieldset>";

    return html;
}

// Function to submit the welding tasks completion form
function submitWeldingCompleteForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        weld_map_issued: document.querySelector('[name="weld_map_issued"]')
            .checked
            ? "on"
            : "",
        link_to_weld_map: document.querySelector('[name="link_to_weld_map"]')
            .value,
        weld_procedure_qualification: document.querySelector(
            '[name="weld_procedure_qualification"]'
        ).checked
            ? "on"
            : "",
        link_to_pqr: document.querySelector('[name="link_to_pqr"]').value,
        weld_procedure_specifications: document.querySelector(
            '[name="weld_procedure_specifications"]'
        ).checked
            ? "on"
            : "",
        link_to_wps: document.querySelector('[name="link_to_wps"]').value,
        welder_performance_qualification: document.querySelector(
            '[name="welder_performance_qualification"]'
        ).checked
            ? "on"
            : "",
        link_to_wpq: document.querySelector('[name="link_to_wpq"]').value,
        welding_wire: document.querySelector('[name="welding_wire"]').checked
            ? "on"
            : "",
        link_to_wire_certificate: document.querySelector(
            '[name="link_to_wire_certificate"]'
        ).value,
        shielding_gas: document.querySelector('[name="shielding_gas"]').checked
            ? "on"
            : "",
        link_to_gas_data_sheet: document.querySelector(
            '[name="link_to_gas_data_sheet"]'
        ).value,
        pre_weld_inspection: document.querySelector(
            '[name="pre_weld_inspection"]'
        ).checked
            ? "on"
            : "",
        inspection_during_welding: document.querySelector(
            '[name="inspection_during_welding"]'
        ).checked
            ? "on"
            : "",
        post_weld_inspection: document.querySelector(
            '[name="post_weld_inspection"]'
        ).checked
            ? "on"
            : "",
        sign_off_welding_complete: document.querySelector(
            '[name="sign_off_welding_complete"]'
        ).value,
        comments_welding_complete: document.querySelector(
            '[name="comments_welding_complete"]'
        ).value,
        status: document.querySelector('[name="status"]').value,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number: document.querySelector('[name="processorder"]')
            .value, // Update with actual process order number
    };

    $.ajax({
        type: "POST",
        url: "/submitWeldingCompleteForm",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            //displayWeldingCompleteResults(response);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        },
    });
    formData = {};
}
function ViewWeldingCompleteForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: document.querySelector('[name="processorder"]')
            .value,
    };
    console.log(formData);
    $.ajax({
        type: "POST",
        url: "/viewWeldingCompleteForm",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            displayWeldingCompleteResults(response);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        },
    });
}
// Function to display the welding tasks completion results
function displayWeldingCompleteResults(values) {
    var resultsHtml =
        '<table id="welding_complete_results_table" style="width:100%; border-collapse: collapse; border: 1px solid #ddd; text-align: left;">';
    resultsHtml +=
        '<thead><tr style="background-color: #f2f2f2;"><th style="padding: 8px; border-bottom: 1px solid #ddd;">Field</th><th style="padding: 8px; border-bottom: 1px solid #ddd;">Value</th></tr></thead>';
    resultsHtml += "<tbody>";

    function buildTableRows(obj, prefix) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key)) {
                var value = obj[key];
                var field = prefix ? prefix + "." + key : key;
                if (typeof value === "object") {
                    buildTableRows(value, field);
                } else {
                    resultsHtml +=
                        '<tr><td style="padding: 8px; border-bottom: 1px solid #ddd;">' +
                        field +
                        '</td><td style="padding: 8px; border-bottom: 1px solid #ddd;">' +
                        value +
                        "</td></tr>";
                }
            }
        }
    }

    buildTableRows(values);

    resultsHtml += "</tbody></table>";

    document.getElementById("welding_complete_results").innerHTML = resultsHtml;
}

function resetWeldingForm() {
    // Uncheck checkboxes
    $('input[name="weld_map_issued"]').prop("checked", false);
    $('input[name="weld_procedure_qualification"]').prop("checked", false);
    $('input[name="weld_procedure_specifications"]').prop("checked", false);
    $('input[name="welder_performance_qualification"]').prop("checked", false);
    $('input[name="welding_wire"]').prop("checked", false);
    $('input[name="shielding_gas"]').prop("checked", false);
    $('input[name="pre_weld_inspection"]').prop("checked", false);
    $('input[name="inspection_during_welding"]').prop("checked", false);
    $('input[name="post_weld_inspection"]').prop("checked", false);
    $('input[name="welding_plant_calibration_certificate"]').prop(
        "checked",
        false
    );

    // Clear text inputs
    $('input[name="sign_off_welding"]').val("");
    $('textarea[name="comments_welding"]').val("");

    // Reset file input values and filenames
    $('input[name="link_to_weld_map"]').val("");
    $("#old_weld_map_filename").text("");
    $('input[name="link_to_pqr"]').val("");
    $("#old_pqr_filename").text("");
    $('input[name="link_to_wps"]').val("");
    $("#old_wps_filename").text("");
    $('input[name="link_to_wpq"]').val("");
    $("#old_wpq_filename").text("");
    $('input[name="link_to_wire_certificate"]').val("");
    $("#old_wire_certificate_filename").text("");
    $('input[name="link_to_gas_data_sheet"]').val("");
    $("#old_gas_data_sheet_filename").text("");
    $('input[name="link_to_plant_cert"]').val("");
    $("#old_plant_cert_filename").text("");
}

function Welding(processOrder, userName) {
    console.log("Welding");
    console.log(processOrder);
    // Hide other fieldsets
    $("#planningFieldset").hide();
    $("#qualityFieldset").hide();
    $("#manufacturingFieldset").hide();
    $("#engineeringFieldset").hide();
    $("#kittingFieldset").hide();

    // Show Welding fieldset
    $("#weldingFieldset").show();

    // Set username and process order
    $('input[name="sign_off_welding"]').val(userName);
    $("#process_order_number_welding").val(processOrder);

    // Prepare headers and data for AJAX request
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: processOrder,
    };

    // Fetch Welding Form Data for the given process order
    $.ajax({
        url: "/getWeldingDataByProcessOrder", // Adjust URL as needed
        type: "POST",
        headers: headers,
        data: formData,
        dataType: "json",
        success: function (response) {
            resetWeldingForm();

            console.log(userName);
            $('input[name="sign_off_welding"]').val(userName);
            if (response.data != null) {
                console.log("Welding data found");
                console.log(response);
                $("#process_order_number_welding").val(processOrder);

                // Set checkbox states
                $('input[name="weld_map_issued"]').prop(
                    "checked",
                    response.data.weld_map_issued === "true"
                );
                $('input[name="weld_procedure_qualification"]').prop(
                    "checked",
                    response.data.weld_procedure_qualification === "true"
                );
                $('input[name="weld_procedure_specifications"]').prop(
                    "checked",
                    response.data.weld_procedure_specifications === "true"
                );
                $('input[name="welder_performance_qualification"]').prop(
                    "checked",
                    response.data.welder_performance_qualification === "true"
                );
                $('input[name="welding_wire"]').prop(
                    "checked",
                    response.data.welding_wire === "true"
                );
                $('input[name="shielding_gas"]').prop(
                    "checked",
                    response.data.shielding_gas === "true"
                );
                $('input[name="pre_weld_inspection"]').prop(
                    "checked",
                    response.data.pre_weld_inspection === "true"
                );
                $('input[name="inspection_during_welding"]').prop(
                    "checked",
                    response.data.inspection_during_welding === "true"
                );
                $('input[name="post_weld_inspection"]').prop(
                    "checked",
                    response.data.post_weld_inspection === "true"
                );
                $('input[name="welding_plant_calibration_certificate"]').prop(
                    "checked",
                    response.data.welding_plant_calibration_certificate === "true"
                );

                // Set other fields
                $('input[name="sign_off_welding"]').val(userName);
                $('textarea[name="comments_welding"]').val(
                    response.data.comments_welding
                );

                // Set file input field
                if (response.data.link_to_weld_map !== null) {
                    $("#old_weld_map_filename").text(
                        response.data.link_to_weld_map
                    );
                }
                if (response.data.link_to_pqr !== null) {
                    $("#old_pqr_filename").text(response.data.link_to_pqr);
                }
                if (response.data.link_to_wps !== null) {
                    $("#old_wps_filename").text(response.data.link_to_wps);
                }
                if (response.data.link_to_wpq !== null) {
                    $("#old_wpq_filename").text(response.data.link_to_wpq);
                }
                if (response.data.link_to_wire_certificate !== null) {
                    $("#old_wire_certificate_filename").text(
                        response.data.link_to_wire_certificate
                    );
                }
                if (response.data.link_to_gas_data_sheet !== null) {
                    $("#old_gas_data_sheet_filename").text(
                        response.data.link_to_gas_data_sheet
                    );
                }
                if (response.data.link_to_plant_cert !== null) {
                    $("#old_plant_cert_filename").text(
                        response.data.link_to_plant_cert
                    );
                }

                // Attach handler for file input change
                $('input[name="link_to_weld_map"]').change(function () {
                    $("#old_weld_map_filename").text(this.files[0].name);
                });
                $('input[name="link_to_pqr"]').change(function () {
                    $("#old_pqr_filename").text(this.files[0].name);
                });
                $('input[name="link_to_wps"]').change(function () {
                    $("#old_wps_filename").text(this.files[0].name);
                });
                $('input[name="link_to_wpq"]').change(function () {
                    $("#old_wpq_filename").text(this.files[0].name);
                });
                $('input[name="link_to_wire_certificate"]').change(function () {
                    $("#old_wire_certificate_filename").text(
                        this.files[0].name
                    );
                });
                $('input[name="link_to_gas_data_sheet"]').change(function () {
                    $("#old_gas_data_sheet_filename").text(this.files[0].name);
                });
                $('input[name="link_to_plant_cert"]').change(function () {
                    $("#old_plant_cert_filename").text(this.files[0].name);
                });
            } else {
                resetWeldingForm();
                $("#process_order_number_welding").val(processOrder);
                $('input[name="sign_off_welding"]').val(userName);
                $("#weldingFieldset").show();
            }
        },
        error: function (error) {
            console.error(error);
        },
    });
}
