function generateMaterialPreparationCompleteFieldset(processOrder, qualityStep, username) {
    var formData = {
        process_order_number: processOrder,
    };
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    $("#sign_off_material_preparation").val(username);

    $.ajax({
        url: "/getMaterialPreparationDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML = generateCompleteHTMLFromResponse_for_material_preparation(response);
            $("#materialpreparationCompleteFieldTable").html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        },
    });
}


function generateCompleteHTMLFromResponse_for_material_preparation(response) {
    var html = '<fieldset><legend>Material Complete Preparation</legend>';
    html += '<form id="material_complete_preparation_form">';
    
    $.each(response, function (index, item) {
        html += '<div class="material_item">';
        html += '<label>ID: ' + item.id + '</label><br>';

        html += '<div class="material_field">';
        html +=
            '<label>Material Identification:</label>' +
            (item.material_identification === "true" ?
            '<input type="checkbox" id="material_identification" name="material_identification" checked disabled>' :
            '<input type="checkbox" id="material_identification" name="material_identification" disabled>') +
            '</div><br>';

        html += '<div class="material_field">';
        html +=
            '<label>Material Identification Record:</label>' +
            '<input type="text" name="material_identification_record" value="' + (item.material_identification_record || "") + '">' +
            '</div><br>';

        if (item.material_identification_record_file) {
            var filePath =
                "storage/material_preparation_task/" +
                item.process_order_number +
                "/" +
                item.material_identification_record_file;
            var downloadLink =
                '<a href="' + filePath + '" download>Download Material Identification Record</a>';
            html += '<div class="material_field">' + downloadLink + '</div><br>';
        }

        html += '<div class="material_field">';
        html +=
            '<label>Material Traceability:</label>' +
            '<input type="text" name="material_traceability" value="' + (item.material_traceability || "") + '">' +
            '</div><br>';

        if (item.material_traceability_file) {
            var filePath =
                "storage/material_preparation_task/" +
                item.process_order_number +
                "/" +
                item.material_traceability_file;
            var downloadLink =
                '<a href="' + filePath + '" download>Download Material Traceability Cert</a>';
            html += '<div class="material_field">' + downloadLink + '</div><br>';
        }

        

// Check if Machining is "on" to display the completion checkbox
if (item.cutting === "on") {
    html += '<div class="material_field">';
    html +=
        '<label>Complete Cutting:</label>' +
        '<input type="checkbox" id="cutting" name="compl_cutting">' +
        '</div><br>';
} else {
    html += '<div class="material_field">';
    html +=
    '<label>Complete Cutting:</label>' +
        '<input type="checkbox" id="cutting" name="cutting"disabled>' +
        '</div><br>';
}

if (item.machining === "on") {
    html += '<div class="material_field">';
    html +=
        '<label>Complete Machining:</label>' +
        '<input type="checkbox" id="machining" name="compl_machining">' +
        '</div><br>';
} else {
    html += '<div class="material_field">';
    html +=
    '<label>Complete Machining:</label>' +
        '<input type="checkbox" id="machining" name="machining"disabled>' +
        '</div><br>';
}

if (item.forming === "on") {
    html += '<div class="material_field">';
    html +=
        '<label>Complete Forming:</label>' +
        '<input type="checkbox" id="forming" name="compl_forming">' +
        '</div><br>';
} else {
    html += '<div class="material_field">';
    html +=
    '<label>Complete Forming:</label>' +
        '<input type="checkbox" id="forming" name="forming"disabled>' +
        '</div><br>';
}

if (item.deburring === "on") {
    html += '<div class="material_field">';
    html +=
        '<label>Complete De-burring:</label>' +
        '<input type="checkbox" id="deburring" name="compl_deburring">' +
        '</div><br>';
} else {
    html += '<div class="material_field">';
    html +=
    '<label>Complete De-burring:</label>' +
        '<input type="checkbox" id="deburring" name="deburring"disabled>' +
        '</div><br>';
}
      

        html += '<div class="material_field">';
        html +=
            '<label>Sign Off:</label>' +
            '<input type="text" name="sign_off_material_preparation" value="' + item.sign_off_material_preparation + '">' +
            '</div><br>';

        html += '<div class="material_field">';
        html +=
            '<label>Comments:</label>' +
            '<input type="text" name="comments_material_preparation" value="' + item.comments_material_preparation + '">' +
            '</div><br>';

        html += '</div>'; // Closing div for material_item
        html += '<hr>'; // Horizontal line for separation
    });

    html += '<input type="button" value="Submit" onclick="submitMaterialCompletePreparationForm()">';
    html += '</form>';

    html += '<div id="material_complete_preparation_results"></div>';
    html += '</fieldset>';

    return html;
}








function submitMaterialCompletePreparationForm() {
   // var formData = new FormData(document.getElementById("material_complete_preparation_form"));
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }
    var formData = {
        material_identification: document.querySelector(
            '[name="material_identification"]'
        ).value,
        material_identification_record: document.querySelector(
            '[name="material_identification_record"]'
        ).value,
        material_traceability: document.querySelector(
            '[name="material_traceability"]'
        ).value,
        cutting: document.querySelector('[name="compl_cutting"]') ? (document.querySelector('[name="compl_cutting"]').checked ? "on" : null) : null,
        deburring: document.querySelector('[name="compl_deburring"]') ? (document.querySelector('[name="compl_deburring"]').checked ? "on" : null) : null,
        forming: document.querySelector('[name="compl_forming"]') ? (document.querySelector('[name="compl_forming"]').checked ? "on" : null) : null,
        machining: document.querySelector('[name="compl_machining"]') ? (document.querySelector('[name="compl_machining"]').checked ? "on" : null) : null,
        
          //  "material_identification_record_file"
      //  ),
        //material_traceability_file: getFileName("material_traceability_file"),
        sign_off_material_preparation: document.querySelector(
            '[name="sign_off_material_preparation"]'
        ).value,
        comments_material_preparation: document.querySelector(
            '[name="comments_material_preparation"]'
        ).value,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number: 2,
        // Add other form fields accordingly
    };
    console.log(formData);
    $.ajax({
        type: "POST",
        url: "/submitMaterialCompletePreparationForm",
        data: formData,
        headers:headers,
        dataType: "json",
        success: function (response) {
            displayMaterialPreparationResults(response);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}

function displayMaterialPreparationResults(values) {
    var resultsHtml = '<table id="material_preparation_results_table" style="width:100%; border-collapse: collapse; border: 1px solid #ddd; text-align: left;">';
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

    document.getElementById('material_complete_preparation_results').innerHTML = resultsHtml;
}



    
function generateMaterialPreparationFieldset(
    processOrder,
    qualityStep,
    username
) {
    $("#sign_off_material_preparation").val(username);
    return `
    <fieldset>
    <legend>Main Task 4: Material Preparation</legend>

    <!-- Subtask 4.1: Material Identification -->
    <div class="form-group">
        <label>
            Material Identification: Confirm grade, thickness
            <input type="text" name="material_identification">
        </label>
    </div>

    <!-- Subtask 4.2: Material Identification Record -->
    <div class="form-group">
        <label>
            Material Identification Record: 3.1 Mill Test Certificate [EN 1024]
            <input type="text" name="material_identification_record">
        </label>
        <label class="upload-label">
        Upload Material Identification Record:
        <input type="file" name="material_identification_record_file">
    </label>
    </div>

    <!-- Subtask 4.3: Material Traceability -->
    <div class="form-group">
        <label>
            Material Traceability: Heat Number
            <input type="text" name="material_traceability">
        </label>
        <label class="upload-label">
    Upload Material Traceability Document:
    <input type="file" name="material_traceability_file">
</label>
    </div>

    <!-- Subtask 4.4: Cutting -->
    <div class="form-group">
        <label>
            Cutting: Part geometry, cut quality, part qty
            <input type="checkbox" name="cutting">
        </label>
    </div>

    <!-- Subtask 4.5: De-burring -->
    <div class="form-group">
        <label>
            De-burring: No sharp edges
            <input type="checkbox" name="deburring">
        </label>
    </div>

    <!-- Subtask 4.6: Forming -->
    <div class="form-group">
        <label>
            Forming: Part geometry, part qty
            <input type="checkbox" name="forming">
        </label>
    </div>

    <!-- Subtask 4.7: Machining -->
    <div class="form-group">
        <label>
            Machining: Part geometry, part qty
            <input type="checkbox" name="machining">
        </label>
    </div>

    <!-- Sign-off for Main Task 4 -->
    <div class="form-group">
        <label>
            Sign-off for Material Preparation:
            <input type="text" name="sign_off_material_preparation"value="${username}">
        </label>
    </div>

    <!-- Comments for Main Task 4 -->
    <div class="form-group">
        <label>
            Comments for Material Preparation:
            <textarea name="comments_material_preparation" rows="4" cols="50"></textarea>
        </label>
    </div>

    <!-- Submit button -->
    <button type="submit" onclick="submitMaterialPreparationForm('${processOrder}')">Submit Material Preparation Form</button>
</fieldset>
    `;
}

function submitMaterialPreparationForm(processOrder) {
    // Add your logic to handle the form submission for the material preparation fieldset

    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };
    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }
    var formData = {
        material_identification: document.querySelector(
            '[name="material_identification"]'
        ).value,
        material_identification_record: document.querySelector(
            '[name="material_identification_record"]'
        ).value,
        material_traceability: document.querySelector(
            '[name="material_traceability"]'
        ).value,
        cutting: document.querySelector('[name="cutting"]').checked ? "on" : "",
        deburring: document.querySelector('[name="deburring"]').checked ? "on" : "",
        forming: document.querySelector('[name="forming"]').checked ? "on" : "",
        machining: document.querySelector('[name="machining"]').checked ? "on" : "",
        material_identification_record_file: getFileName(
            "material_identification_record_file"
        ),
        material_traceability_file: getFileName("material_traceability_file"),
        sign_off_material_preparation: document.querySelector(
            '[name="sign_off_material_preparation"]'
        ).value,
        comments_material_preparation: document.querySelector(
            '[name="comments_material_preparation"]'
        ).value,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number: processOrder,
        // Add other form fields accordingly
    };
    console.log(formData);
    // Send an AJAX request to the server
    $.ajax({
        url: "/submitMaterialPreparationForm",
        type: "POST",
        data: formData,
        headers: headers,
        success: function (response) {
            // Handle the success response if needed
            console.log(response);
            alert("success");
            $("#myModal").hide();
            updateTable(response);
            function updateTable(response) {
                // Assuming your table has an ID, update the table rows dynamically
                var newRow =
                    "<tr><td>" +
                    response.name +
                    "</td><td>" +
                    response.path +
                    "</td></tr>";
                $("#yourTableId tbody").append(newRow);
            }
        },
        error: function (error) {
            // Handle the error response if needed
            console.error(error);
        },
    });
    // File uploads
    // File uploads
    var fileData = new FormData();
    var fileInputs = $('[type="file"]');

    // Add process_order_number to FormData
    fileData.append("process_order_number", processOrder);

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
        url: "/handleFileUploadMaterialPreparation", // Update to your actual route
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

    console.log("Mat Preparation form submitted!");
}

function generateMaterialPreparationFieldTable(processOrder, qualityStep) {
    console.log(processOrder);

    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: processOrder,
    };

    $.ajax({
        url: "/getMaterialPreparationDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML =
                generateHTMLFromResponse_for_material_preparation(response);

            $("#materialpreparationFieldTable").html(generatedHTML);
           
        },
        error: function (error) {
            console.error(error);
        },
    });

    return `
            <div>To be Done</div>
        `;
}

function generateHTMLFromResponse_for_material_preparation(response) {
    var html = '<table id="common_table" style="width:100%;">';
    html +=
        '<thead><tr><th style="width:5%;">ID</th><th style="width:10%;">Material Identification</th><th style="width:15%;">Material Identification Record</th><th style="width:15%;">Material Identification Cert </th><th style="width:15%;">Material Traceability</th><th style="width:15%;">Material Traceability Cert</th><th style="width:7%;">Cutting</th><th style="width:7%;">De-burring</th><th style="width:7%;">Forming</th><th style="width:7%;">Machining</th><th style="width:12%;">Sign Off</th><th style="width:15%;">Comments</th></tr></thead><tbody>';

    $.each(response, function (index, item) {
        html += "<tr>";
        html += "<td>" + item.id + "</td>";
        html +=
            '<td style="text-align:center;">' +
            (item.material_identification === "true" ? "✔" : "") +
            "</td>";
        html += "<td>" + (item.material_identification_record || "") + "</td>";

        if (item.material_identification_record_file) {
            var filePath =
                "storage/material_preparation_task/" +
                item.process_order_number +
                "/" +
                item.material_identification_record_file;
            var downloadLink =
                '<a href="' + filePath + '" download>Download File</a>';
            html += "<td>" + downloadLink + "</td>";
        } else {
            html += "<td></td>"; // Empty cell if 'customer_approval_document' is empty
        }
        html += "<td>" + (item.material_traceability || "") + "</td>";
        if (item.material_traceability_file) {
            var filePath =
                "storage/material_preparation_task/" +
                item.process_order_number +
                "/" +
                item.material_traceability_file;
            var downloadLink =
                '<a href="' + filePath + '" download>Download File</a>';
            html += "<td>" + downloadLink + "</td>";
        } else {
            html += "<td></td>"; // Empty cell if 'customer_approval_document' is empty
        }
        html +=
    '<td style="text-align:center;">' +
    ((item.cutting === "true" || item.cutting === "on") && item.cutting !== null ? "✔" : "") +
    "</td>";
html +=
    '<td style="text-align:center;">' +
    ((item.deburring === "true" || item.deburring === "on") && item.deburring !== null ? "✔" : "") +
    "</td>";
html +=
    '<td style="text-align:center;">' +
    ((item.forming === "true" || item.forming === "on") && item.forming !== null ? "✔" : "") +
    "</td>";
html +=
    '<td style="text-align:center;">' +
    ((item.machining === "true" || item.machining === "on") && item.machining !== null ? "✔" : "") +
    "</td>";

        html += "<td>" + item.sign_off_material_preparation + "</td>";
        html += "<td>" + item.comments_material_preparation + "</td>";
        html += "</tr>";
    });

    html += "</tbody></table>";

    return html;
}
