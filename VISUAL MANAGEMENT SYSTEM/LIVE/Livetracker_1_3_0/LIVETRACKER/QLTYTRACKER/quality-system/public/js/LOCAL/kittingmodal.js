function generateKittingCompleteFieldset(processOrder, qualityStep, username) {
    var formData = {
        process_order_number: processOrder,
    };
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    $("#sign_off_kitting").val(username);

    $.ajax({
        url: "/getKittingDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML = generateCompleteHTMLFromResponse_for_kitting(response);
            $("#kittingCompleteFieldTable").html(generatedHTML);
          
        },
        error: function (error) {
            console.error(error);
        },
    });
}

function generateCompleteHTMLFromResponse_for_kitting(response) {
    var html = '<fieldset><legend>Kitting Complete</legend>';
    html += '<form id="kitting_complete_form">';
    
    $.each(response, function (index, item) {
        
        html += '<div class="kitting_item">';
        html += '<label>ID: ' + item.id + '</label><br>';
        html += '<div class="kitting_item">';
        html += '<label>Process Order: ' + item.ProcessOrderID + '</label><br>';
        html += '<div class="kitting_item">';
        html += '<input type="hidden" name="processorder" value="' + item.ProcessOrderID + '"><br>';
        html += '<div class="kitting_field">';
        html +=
            '<label>Cut Formed Machine Parts:</label>' +
            (item.cut_form_mach_parts === "on" ?
            '<input type="checkbox" id="cut_form_mach_parts" name="cut_form_mach_parts" >' :
            '<input type="checkbox" id="cut_form_mach_parts" name="cut_form_mach_parts" disabled>');
        html += '</div><br>';

        html += '<div class="kitting_field">';
        html +=
            '<label>Bought Out Components:</label>' +
            (item.bought_out_components === "on" ?
            '<input type="checkbox" id="bought_out_components" name="bought_out_components" >' :
            '<input type="checkbox" id="bought_out_components" name="bought_out_components" disabled>');
        html += '</div><br>';

        html += '<div class="kitting_field">';
        html +=
            '<label>Fasteners and Fixings:</label>' +
            (item.fasteners_fixings === "on" ?
            '<input type="checkbox" id="fasteners_fixings" name="fasteners_fixings" >' :
            '<input type="checkbox" id="fasteners_fixings" name="fasteners_fixings" disabled>');
        html += '</div><br>';

        html += '<div class="kitting_field">';
        html +=
            '<label>Site Pack:</label>' +
            (item.site_pack === "on" ?
            '<input type="checkbox" id="site_pack" name="site_pack" >' :
            '<input type="checkbox" id="site_pack" name="site_pack" disabled>');
        html += '</div><br>';

        html += '<div class="kitting_field">';
        html +=
            '<label>Sign Off:</label>' +
            '<input type="text" name="sign_off_kitting" value="' + item.sign_off_kitting + '" disabled>';
        html += '</div><br>';

        html += '<div class="kitting_field">';
        html +=
            '<label>Comments:</label>' +
            '<input type="text" name="comments_kitting" value="' + item.comments_kitting + '" disabled>';
        html += '</div><br>';

        html += '<div class="kitting_field">';
        html +=
            '<label>Kitting Process Completion:</label>' +
            '<select id="kitting_process_completion" name="kitting_process_completion">' +
            '<option value="Completed" ' + (item.kitting_process_completion === "Completed" ? 'selected' : '') + '>Completed</option>' +
            '<option value="Partially Completed" ' + (item.kitting_process_completion === "Partially Completed" ? 'selected' : '') + '>Partially Completed</option>' +
            '</select>';
        html += '</div><br>';

        // Quantity Field
        html += '<div class="kitting_field">';
        html +=
            '<label>Quantity:</label>' +
            '<input type="number" id="quantity" name="quantity" value="' + item.quantity + '" >';
        html += '</div><br>';

        html += '</div>'; // Closing div for kitting_item
        html += '<hr>'; // Horizontal line for separation
    });

    html += '<input type="button" value="Submit" onclick="submitKittingCompleteForm()">';
    html += '  <input type="button" value="View" onclick="ViewKittingCompleteForm()">';
    html += '</form>';

    html += '<div id="kitting_complete_results"></div>';
    html += '</fieldset>';

    return html;
}


function submitKittingCompleteForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        sign_off_kitting: document.querySelector('[name="sign_off_kitting"]').value,
        comments_kitting: document.querySelector('[name="comments_kitting"]').value,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number: document.querySelector('[name="processorder"]').value, // Change this according to your needs
        //cutting: document.querySelector('[name="cutting"]').checked ? "on" : "",
        cut_form_mach_parts: document.querySelector('[name="cut_form_mach_parts"]').checked ? "on" : "",
        bought_out_components: document.querySelector('[name="bought_out_components"]').checked ? "on" : "",
        fasteners_fixings: document.querySelector('[name="fasteners_fixings"]').checked ? "on" : "",
        site_pack: document.querySelector('[name="site_pack"]').checked ? "on" : "",
        status: document.querySelector('[name="kitting_process_completion"]').value, // Include selected value of kitting_process_completion
        quantity: document.querySelector('[name="quantity"]').value, // Include selected value of kitting_process_completion
        // Add other form fields accordingly
    }; // Change this according to your needs
        // Add other form fields accordingly
   
    console.log(formData);
    $.ajax({
        type: "POST",
        url: "/submitKittingCompleteForm",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            //displayKittingCompleteResults(response);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}
function ViewKittingCompleteForm() {

    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
    process_order_number: document.querySelector('[name="processorder"]').value, 
    }
    $.ajax({
        type: "POST",
        url: "/viewKittingCompleteForm",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            displayKittingCompleteResults(response);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}
function displayKittingCompleteResults(values) {
    var resultsHtml = '<table id="kitting_complete_results_table" style="width:100%; border: 1px solid #ddd; text-align: left;">';
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

    document.getElementById('kitting_complete_results').innerHTML = resultsHtml;
}

/*

function generateKittingFieldset(processOrder, qualityStep, username) {
    $("#sign_off_kitting").val(username);
    return `
    <fieldset>
    <legend>Main Task 3: Kitting</legend>

    <!-- Subtask 3.1: Cut Formed Machine Parts -->
    <div class="form-group">
        <label>
            Cut Formed Machine Parts:
            <input type="checkbox" name="cut_form_mach_parts">
        </label>
    </div>

    <!-- Subtask 3.2: Bought Out Components -->
    <div class="form-group">
        <label>
            Bought Out Components:
            <input type="checkbox" name="bought_out_components">
        </label>
    </div>

    <!-- Subtask 3.3: Fasteners and Fixings -->
    <div class="form-group">
        <label>
            Fasteners and Fixings:
            <input type="checkbox" name="fasteners_fixings">
        </label>
    </div>

    <!-- Subtask 3.4: Site Pack -->
    <div class="form-group">
        <label>
            Site Pack:
            <input type="checkbox" name="site_pack">
        </label>
    </div>

    <!-- Sign-off for Main Task 3 -->
    <div class="form-group">
        <label>
            Sign-off for Kitting:
            <input type="text" name="sign_off_kitting" value="${username}">
        </label>
    </div>

    <!-- Comments for Main Task 3 -->
    <div class="form-group">
        <label>
            Comments for Kitting:
            <textarea name="comments_kitting" rows="4" cols="50"></textarea>
        </label>
    </div>

    <!-- Submit button -->
    <button type="button" onclick="submitKittingForm('${processOrder}')">Submit Kitting Form</button>
</fieldset>
    `;
}

function submitKittingForm(processOrder) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        cut_form_mach_parts: document.querySelector('[name="cut_form_mach_parts"]').checked ? "on" : "",
        bought_out_components: document.querySelector('[name="bought_out_components"]').checked ? "on" : "",
        fasteners_fixings: document.querySelector('[name="fasteners_fixings"]').checked ? "on" : "",
        site_pack: document.querySelector('[name="site_pack"]').checked ? "on" : "",
        sign_off_kitting: document.querySelector('[name="sign_off_kitting"]').value,
        comments_kitting: document.querySelector('[name="comments_kitting"]').value,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number: processOrder,
        // Add other form fields accordingly
    };
console.log(formData);
    // Send an AJAX request to the server
    $.ajax({
        url: "/submitKittingForm",
        type: "POST",
        data: formData,
        headers: headers,
        success: function (response) {
            console.log(response);
            alert("Kitting form submitted successfully");
            // Optionally update the table or perform other actions
        },
        error: function (error) {
            console.error("Error:", error);
            alert("Error submitting Kitting form");
        },
    });
}

function generateKittingFieldTable(processOrder, qualityStep) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: processOrder,
    };
console.log(formData);
    $.ajax({
        url: "/getKittingDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML =
                generateHTMLFromResponse_for_kitting(response);

            $("#kittingFieldTable").html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        },
    });

    return `
            <div>To be Done</div>
        `;
}

function generateHTMLFromResponse_for_kitting(response) {
    var html = '<table id="common_table" style="width:100%;">';
    html +=
        '<thead><tr><th style="width:5%;">Kitting ID</th><th style="width:20%;">Process Order ID</th><th style="width:10%;">Cut Form Mach Parts</th><th style="width:10%;">Bought Out Components</th><th style="width:10%;">Fasteners Fixings</th><th style="width:10%;">Site Pack</th><th style="width:10%;">Sign Off Kitting</th><th style="width:15%;">Comments Kitting</th><th style="width:10%;">Submitted Date Time</th><th style="width:10%;">Created At</th><th style="width:10%;">Updated At</th></tr></thead><tbody>';

    $.each(response, function (index, item) {
        html += "<tr>";
        html += "<td>" + item.KittingID + "</td>";
        html += "<td>" + item.ProcessOrderID + "</td>";
        html += "<td>" + ((item.cut_form_mach_parts === "true" || item.cut_form_mach_parts === "on") ? "✔" : "") + "</td>";
html += "<td>" + ((item.bought_out_components === "true" || item.bought_out_components === "on") ? "✔" : "") + "</td>";
html += "<td>" + ((item.fasteners_fixings === "true" || item.fasteners_fixings === "on") ? "✔" : "") + "</td>";
html += "<td>" + ((item.site_pack === "true" || item.site_pack === "on") ? "✔" : "") + "</td>";

            '<td style="text-align:center;">' +
            (item.sign_off_kitting === "true" ? "✔" : "") +
            "</td>";
        html += "<td>" + item.comments_kitting + "</td>";
        html += "<td>" + item.submitted_datetime + "</td>";
        html += "<td>" + item.created_at + "</td>";
        html += "<td>" + item.updated_at + "</td>";
        html += "</tr>";
    });

    html += "</tbody></table>";

    return html;
}

*/
function generateKittingFieldset(processOrder, qualityStep, username) {
    $("#sign_off_kitting").val(username);
    return `
    <fieldset>
    <legend>Main Task 3: Kitting</legend>

    <!-- Subtask 3.1: Cut Formed Machine Parts -->
    <div class="form-group">
        <label>
            Cut Formed Machine Parts:
            <input type="checkbox" name="cut_form_mach_parts">
        </label>
    </div>

    <!-- Subtask 3.2: Bought Out Components -->
    <div class="form-group">
        <label>
            Bought Out Components:
            <input type="checkbox" name="bought_out_components">
        </label>
    </div>

    <!-- Subtask 3.3: Fasteners and Fixings -->
    <div class="form-group">
        <label>
            Fasteners and Fixings:
            <input type="checkbox" name="fasteners_fixings">
        </label>
    </div>

    <!-- Subtask 3.4: Site Pack -->
    <div class="form-group">
        <label>
            Site Pack:
            <input type="checkbox" name="site_pack">
        </label>
    </div>

    <!-- Upload File -->
    <div class="form-group">
        <label>
            Upload File:
            <input type="file" name="kitting_file">
        </label>
    </div>

    <!-- Sign-off for Main Task 3 -->
    <div class="form-group">
        <label>
            Sign-off for Kitting:
            <input type="text" name="sign_off_kitting" value="${username}">
        </label>
    </div>

    <!-- Comments for Main Task 3 -->
    <div class="form-group">
        <label>
            Comments for Kitting:
            <textarea name="comments_kitting" rows="4" cols="50"></textarea>
        </label>
    </div>

    <!-- Submit button -->
    <button type="button" onclick="submitKittingForm('${processOrder}')">Submit Kitting Form</button>
   
</fieldset>
    `;
}

function submitKittingForm(processOrder) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };
    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }

    var formData = new FormData();
    formData.append('cut_form_mach_parts', document.querySelector('[name="cut_form_mach_parts"]').checked ? "on" : "");
    formData.append('bought_out_components', document.querySelector('[name="bought_out_components"]').checked ? "on" : "");
    formData.append('fasteners_fixings', document.querySelector('[name="fasteners_fixings"]').checked ? "on" : "");
    formData.append('site_pack', document.querySelector('[name="site_pack"]').checked ? "on" : "");
    formData.append('kitting_file', getFileName('kitting_file'));
    formData.append('sign_off_kitting', document.querySelector('[name="sign_off_kitting"]').value);
    formData.append('comments_kitting', document.querySelector('[name="comments_kitting"]').value);
    formData.append('submission_date', new Date().toISOString().split("T")[0]); // Get today's date in YYYY-MM-DD format
    formData.append('process_order_number', processOrder);
    // Add other form fields accordingly

    // Send an AJAX request to the server
    $.ajax({
        url: "/submitKittingForm",
        type: "POST",
        data: formData,
        headers: headers,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            alert("Kitting form submitted successfully");
            // Optionally update the table or perform other actions
        },
        error: function (error) {
            console.error("Error:", error);
            alert("Error submitting Kitting form");
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
        url: '/handleFileUploadKitting',  // Update to your actual route
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

function generateKittingFieldTable(processOrder, qualityStep) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: processOrder,
    };

    $.ajax({
        url: "/getKittingDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML =
                generateHTMLFromResponse_for_kitting(response);

            $("#kittingFieldTable").html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        },
    });

    return `
            <div>To be Done</div>
        `;
}

function generateHTMLFromResponse_for_kitting(response) {
    var html = '<table id="common_table" style="width:100%;">';
    html +=
        '<thead><tr><th style="width:5%;">Kitting_ID</th><th style="width:5%;">Process_Order</th><th style="width:20%;">Cut_Form_MachParts</th><th style="width:15%;">Bought_Out_Components</th><th style="width:15%;">Fasteners_Fixings</th><th style="width:10%;">Site_Pack</th><th style="width:50%;">Link_to_Drawing</th><th style="width:5%;">Sign_Off_Kitting</th><th style="width:15%;">Comments_Kitting</th><th style="width:15%;">Submitted_Date_Time</th><th style="width:5%;">Created At</th><th style="width:5%;">Updated_At</th></tr></thead><tbody>';

    $.each(response, function (index, item) {
        html += "<tr>";
        html += "<td>" + item.KittingID + "</td>";
        html += "<td>" + item.ProcessOrderID + "</td>";
        html += "<td>" + ((item.cut_form_mach_parts === "true" || item.cut_form_mach_parts === "on") ? "✔" : "") + "</td>";
        html += "<td>" + ((item.bought_out_components === "true" || item.bought_out_components === "on") ? "✔" : "") + "</td>";
        html += "<td>" + ((item.fasteners_fixings === "true" || item.fasteners_fixings === "on") ? "✔" : "") + "</td>";
        html += "<td>" + ((item.site_pack === "true" || item.site_pack === "on") ? "✔" : "") + "</td>";
        html += '<td style="text-align:center;">';
        if (item.kitting_file) {
            var filePath = 'storage/kitting_task/' + item.ProcessOrderID + '/' + item.kitting_file;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</td>';
        html += "<td style='text-align:center;'>" + (item.sign_off_kitting === "true" ? "✔" : "") + "</td>";
        html += "<td>" + item.comments_kitting + "</td>";
        html += "<td>" + item.submitted_datetime + "</td>";
        html += "<td>" + item.created_at + "</td>";
        html += "<td>" + item.updated_at + "</td>";
        html += "</tr>";
    });

    html += "</tbody></table>";

    return html;
}
