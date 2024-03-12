function generateFabricationFitUpFieldset(processOrder, qualityStep, username) {
    $("#sign_off_fabrication_fit_up").val(username);
    return `
    <fieldset>
        <legend>Fabrication Fit-Up</legend>

        <!-- Subtask 6.1: Fit-up -->
        <div class="form-group">
            <label>Fit-up: Visual check fit up - first off</label>
            <input type="checkbox" name="fit_up_visual_check">
        </div>

        <!-- Subtask 6.2: Dimensional check -->
        <div class="form-group">
            <label>Dimensional check: Dimensional check first off</label>
            <input type="checkbox" name="dimensional_check">
            <label class="upload-label">Link to Drawing: <input type="file" name="link_to_drawing" required></label>
        </div>

        <!-- Subtask 6.3: Weldment quantity -->
        <div class="form-group">
            <label>Weldment quantity: Check qty against Process Order</label>
            <input type="checkbox" name="weldment_quantity">
        </div>

        <!-- Sign-off for Fabrication Fit-Up -->
        <div class="form-group">
            <label>Sign-off for Fabrication Fit-Up:</label>
            <input type="text" name="sign_off_fabrication_fit_up" value="${username}">
        </div>

        <!-- Comments for Fabrication Fit-Up -->
        <div class="form-group">
            <label>Comments for Fabrication Fit-Up:</label>
            <textarea name="comments_fabrication_fit_up" rows="4" cols="50"></textarea>
        </div>

        <!-- Submit button -->
        <button type="submit" onclick="submitFabricationFitUpForm('${processOrder}')">Submit Fabrication Fit-Up Form</button>
    </fieldset>
    `;
}


function submitFabricationFitUpForm(processOrder) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }
    var formData = {
        fit_up_visual_check: document.querySelector('[name="fit_up_visual_check"]')?.checked || null,
        dimensional_check: document.querySelector('[name="dimensional_check"]')?.checked || null,
        link_to_drawing: getFileName('link_to_drawing') || null,
        weldment_quantity: document.querySelector('[name="weldment_quantity"]')?.checked || null,
        sign_off_fabrication_fit_up: document.querySelector('[name="sign_off_fabrication_fit_up"]').value.trim() || null,
        comments_fabrication_fit_up: document.querySelector('[name="comments_fabrication_fit_up"]').value.trim() || null,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number: processOrder,
    };
   console.log(formData);

    $.ajax({
        url: "/submitFabricationFitUpForm",
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
    console.log(fileData);
    // Send an AJAX request for file uploads
    $.ajax({
        url: '/handleFileUploadFabricationFitUp',  // Update to your actual route
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

    console.log('Engineering form submitted!');
}


function generateFabricationFitUpFieldTable(processOrder, qualityStep) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: processOrder,
    };

    $.ajax({
        url: "/getFabricationFitUpDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML = generateHTMLFromResponse_for_fabrication_fit_up(response);

            $("#fabricationfitupFieldTable").html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        },
    });

    return `
        <div>To be Done</div>
    `;
}

function generateHTMLFromResponse_for_fabrication_fit_up(response) {
    var html = '<table id="common_table" style="width:100%;">';
    html +=
        '<thead><tr><th style="width:5%;">ID</th><th style="width:15%;">Fit-Up Visual Check</th><th style="width:25%;">Dimensional Check</th><th style="width:20%;">Link to Drawing</th><th style="width:15%;">Weldment Quantity</th><th style="width:15%;">Sign Off</th><th style="width:25%;">Comments</th></tr></thead><tbody>';

    $.each(response, function (index, item) {
        html += "<tr>";
        html += "<td>" + item.Id + "</td>";

        // Fit-Up Visual Check
        html += '<td style="text-align:center;">';
        if (item.FitUpVisualCheck === "true") {
            html += "✔";
        } else if (item.FitUpVisualCheck === null) {
            html += "-";
        }
        html += "</td>";

        // Dimensional Check
        html += '<td style="text-align:center;">';
        if (item.DimensionalCheck === "true") {
            html += "✔";
        } else if (item.DimensionalCheck === null) {
            html += "-";
        }
        html += "</td>";

        // Link to Drawing
        html += '<td>';
        if (item.LinkToDrawing) {
           
            var filePath = 'storage/fabricationfitup_task/' + item.ProcessOrder + '/' + item.LinkToDrawing;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</td>';

        // Weldment Quantity
        html += '<td style="text-align:center;">';
        if (item.WeldmentQuantity === "true") {
            html += "✔";
        } else if (item.WeldmentQuantity === null) {
            html += "-";
        }
        html += "</td>";

        // Sign Off
        html += "<td>" + (item.SignOffUser ? item.SignOffUser : "-") + "</td>";

        // Comments
        html += "<td>" + (item.Comments ? item.Comments : "-") + "</td>";

        // Design Validation Document
       

        html += "</tr>";
    });

    html += "</tbody></table>";

    return html;
}




function generateFabricationFitUpCompleteFieldset(processOrder, qualityStep, username) {
    var formData = {
        process_order_number: processOrder,
    };
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    $("#sign_off_fabrication_fit_up").val(username);

    $.ajax({
        url: "/getFabricationFitUpDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML = generateCompleteHTMLFromResponse_for_fabrication_fit_up(response);
            $("#fabricationfitupCompleteFieldTable").html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        },
    });
}

function generateCompleteHTMLFromResponse_for_fabrication_fit_up(response) {
    var html = '<fieldset><legend>Fabrication Fit-Up Complete</legend>';
    html += '<form id="fabrication_fit_up_complete_form">';
    
    $.each(response, function (index, item) {
        html += '<div class="fabrication_item">';
        html += '<label>ID: ' + item.id + '</label><br>';

        html += '<div class="fabrication_field">';
        html +=
            '<label>Fit-Up:</label>' +
            (item.FitUpVisualCheck === "true" || item.FitUpVisualCheck === "on" ?
            '<input type="checkbox" id="fit_up_visual_check" name="fit_up_visual_check" >' :
            '<input type="checkbox" id="fit_up_visual_check" name="fit_up_visual_check" disabled>') +
            '</div><br>';

        html += '<div class="fabrication_field">';
        html +=
            '<label>Dimensional Check:</label>' +
            (item.DimensionalCheck === "true" || item.DimensionalCheck === "on" ?
            '<input type="checkbox" id="dimensional_check" name="dimensional_check" >' :
            '<input type="checkbox" id="dimensional_check" name="dimensional_check" disabled>') +
            '</div><br>';

        html += '<div class="fabrication_field">';
        html +=
            '<label>Link to Drawing:</label>' +
            '<input type="text" name="link_to_drawing" value="' + item.LinkToDrawing + '">' +
            '</div><br>';

        html += '<div class="fabrication_field">';
        html +=
            '<label>Weldment Quantity:</label>' +
            (item.WeldmentQuantity === "true" || item.WeldmentQuantity === "on" ?
            '<input type="checkbox" id="weldment_quantity" name="weldment_quantity" >' :
            '<input type="checkbox" id="weldment_quantity" name="weldment_quantity" disabled>') +
            '</div><br>';

        html += '<div class="fabrication_field">';
        html +=
            '<label>Sign Off:</label>' +
            '<input type="text" name="sign_off_fabrication_fit_up" value="' + item.SignOffUser + '">' +
            '</div><br>';

        html += '<div class="fabrication_field">';
        html +=
            '<label>Comments:</label>' +
            '<input type="text" name="comments_fabrication_fit_up" value="' + item.Comments + '">' +
            '</div><br>';

        // Added Status dropdown
        html += '<div class="fabrication_field">';
        html +=
            '<label>Status:</label>' +
            '<select name="status">' +
            '<option value="partially_completed">Partially Completed</option>' +
            '<option value="completed">Completed</option>' +
            '</select>' +
            '</div><br>';

        // Added Quantity input box
        html += '<div class="fabrication_field">';
        html +=
            '<label>Quantity:</label>' +
            '<input type="text" name="quantity" value="' + item.Quantity + '">' +
            '</div><br>';

        html += '</div>'; // Closing div for fabrication_item
        html += '<hr>'; // Horizontal line for separation
    });

    html += '<input type="button" value="Submit" onclick="submitFabricationCompleteFitUpForm()">';
    html += '</form>';

    html += '<div id="fabrication_fit_up_complete_results"></div>';
    html += '</fieldset>';

    return html;
}


function submitFabricationCompleteFitUpForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        fit_up_visual_check: document.querySelector('[name="fit_up_visual_check"]').checked ? "on" : "",
        dimensional_check: document.querySelector('[name="dimensional_check"]').checked ? "on" : "",
        link_to_drawing: document.querySelector('[name="link_to_drawing"]').value,
        weldment_quantity: document.querySelector('[name="weldment_quantity"]').checked ? "on" : "",
        sign_off_fabrication_fit_up: document.querySelector('[name="sign_off_fabrication_fit_up"]').value,
        comments_fabrication_fit_up: document.querySelector('[name="comments_fabrication_fit_up"]').value,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number: 2,
    };

    $.ajax({
        type: "POST",
        url: "/submitFabricationCompleteFitUpForm",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            displayFabricationFitUpResults(response);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}

function displayFabricationFitUpResults(values) {
    var resultsHtml = '<table id="fabrication_fit_up_results_table" style="width:100%; border-collapse: collapse; border: 1px solid #ddd; text-align: left;">';
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

    document.getElementById('fabrication_fit_up_complete_results').innerHTML = resultsHtml;
}
