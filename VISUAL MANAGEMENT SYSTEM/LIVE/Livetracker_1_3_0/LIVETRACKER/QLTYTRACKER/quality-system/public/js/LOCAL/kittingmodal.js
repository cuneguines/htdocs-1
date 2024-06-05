function generateKittingCompleteFieldset(processOrder, qualityStep, username) {
    console.log(processOrder);
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
            
            if (response.data !== null) 
            {
            var generatedHTML = generateCompleteHTMLFromResponse_for_kitting(response);
            $("#kittingCompleteFieldTable").html(generatedHTML);
            }
          else
          {
            $("#kittingCompleteFieldTable").html('');
          }
        },
        error: function (error) {
            console.error(error);
        },
    });
}

function generateCompleteHTMLFromResponse_for_kitting(response) {
    var html = '<fieldset><legend>Kitting Complete</legend>';
    html += '<form id="kitting_complete_form">';
    html+='<div style="width:97%">';
    $.each(response, function (index, item) {
      
        html += '<div class="kitting_item">';
        
        //html += '<label>ID: ' + item.id + '</label><br>';
        html += '<div class="kitting_item">';
        html += '<label style="width:100%">Process Order: ' + item.ProcessOrderID + '</label><br>';
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
            '<input style="width:100%"type="text" id="sign_off_kitting_c"name="sign_off_kitting_c" value="' + userName + '" >';
        html += '</div><br>';

        html += '<div class="kitting_field">';
        html +=
            '<label>Comments:</label>' +
            '<input style="width:100%"type="text" name="comments_kitting" value="' + item.comments_kitting + '" disabled>';
        html += '</div><br>';

        html += '<div class="kitting_field">';
        html +=
            '<label>Kitting Process Completion:</label>' +
            '<select style="width:103%"id="kitting_process_completion" name="kitting_process_completion">' +
            '<option value="Completed" ' + (item.kitting_process_completion === "Completed" ? 'selected' : '') + '>Completed</option>' +
            '<option value="Partially Completed" ' + (item.kitting_process_completion === "Partially Completed" ? 'selected' : '') + '>Partially Completed</option>' +
            '</select>';
        html += '</div><br>';

        // Quantity Field
        html += '<div class="kitting_field">';
        html +=
            '<label>Quantity:</label>' +
            '<input style="width:100%"type="number" id="quantity" name="quantity" value="' + item.quantity + '" >';
        html += '</div><br>';

        html += '</div>'; // Closing div for kitting_item
        html += '<hr>'; // Horizontal line for separation
    });

    html += '<input type="button" value="Submit" onclick="submitKittingCompleteForm()">';
    html += '  <input type="button" value="View" onclick="ViewKittingCompleteForm()">';
    html += '</form>';

    html += '<div id="kitting_complete_results"></div>';
    html+='</div>';
    html += '</fieldset>';

    return html;
}


function submitKittingCompleteForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };
   
    var formData = {
        sign_off_kitting: document.querySelector('[name="sign_off_kitting_c"]').value.trim(),
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
    formData = {};
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
                var field = key;
                if (typeof value === 'object') {
                    buildTableRows(value, field);
                } else {
                    if (value=="on")
                        {
                        resultsHtml += '<tr><td style="padding: 8px; border-bottom: 1px solid #ddd;">' + field + '</td><td style="padding: 8px; border-bottom: 1px solid #ddd;"> &#10003;</td></tr>';
                        }
                        else
                        {
                            resultsHtml += '<tr><td style="padding: 8px; border-bottom: 1px solid #ddd;">' + field + '</td><td style="padding: 8px; border-bottom: 1px solid #ddd;">' + value + '</td></tr>';
                        }
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
/* function generateKittingFieldset(processOrder, qualityStep, username) {
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
} */

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
    //formData.append('kitting_file', getFileName('kitting_file'));
    formData.append('kitting_file', (document.querySelector('[name="kitting_file_document"]').files.length > 0)
    ? document.querySelector('[name="kitting_file_document"]').files[0].name
    : document.getElementById('kitting_file_filename').textContent.trim());
    formData.append('sign_off_kitting', document.querySelector('[name="sign_off_kitting"]').value);
    formData.append('comments_kitting', document.querySelector('[name="comments_kitting"]').value);
    formData.append('submission_date', new Date().toISOString().split("T")[0]); // Get today's date in YYYY-MM-DD format
    formData.append('process_order_number', document.querySelector('[name="process_order_number_kitting"]').value);
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
            $(myModal).hide();
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
    fileData.append('process_order_number', document.querySelector('[name="process_order_number_kitting"]').value);

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

function generateHTMLFromResponse_for_kitting_old(response) {
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
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/kitting_task/' + item.ProcessOrderID + '/' + item.kitting_file;
            var downloadLink = '<a href="' + filePath + '" target="_blank">Download File</a>';
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
function generateHTMLFromResponse_for_kitting(response) {
    var html = '<form id="kittingForm" class="kitting-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Kitting</legend>';
    html+='<div style="width:97%">';
    $.each(response, function(index, item) {
        html += '<div class="form-group">';
        //html += '<label for="KittingID">Kitting ID:</label>';
        //html += '<input type="text" id="KittingID" name="KittingID" value="' + item.KittingID + '" readonly>';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="ProcessOrderID">Process Order:</label>';
        html += '<input style="width:100%"type="text" id="ProcessOrderID" name="ProcessOrderID" value="' + item.ProcessOrderID + '" readonly>';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="cut_form_mach_parts">Cut Formed Machine Parts:</label>';
        html += '<input type="checkbox" id="cut_form_mach_parts" name="cut_form_mach_parts" ' + ((item.cut_form_mach_parts === 'true' || item.cut_form_mach_parts === 'on') ? 'checked disabled' : 'disabled') + '>';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="bought_out_components">Bought Out Components:</label>';
        html += '<input type="checkbox" id="bought_out_components" name="bought_out_components" ' + ((item.bought_out_components === 'true' || item.bought_out_components === 'on') ? 'checked disabled' : 'disabled') + '>';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="fasteners_fixings">Fasteners and Fixings:</label>';
        html += '<input type="checkbox" id="fasteners_fixings" name="fasteners_fixings" ' + ((item.fasteners_fixings === 'true' || item.fasteners_fixings === 'on') ? 'checked disabled' : 'disabled') + '>';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="site_pack">Site Pack:</label>';
        html += '<input type="checkbox" id="site_pack" name="site_pack" ' + ((item.site_pack === 'true' || item.site_pack === 'on') ? 'checked disabled' : 'disabled') + '>';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="link_to_drawing">Link to Drawing:</label>';
        if (item.kitting_file) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/kitting_task/' + item.ProcessOrderID + '/' + item.kitting_file;
            var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.kitting_file+'</a>';
            
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="sign_off_kitting">Sign-off:</label>';
        html += '<input style="width:100%"type="text" id="sign_off_kitting" name="sign_off_kitting" value="' + (item.sign_off_kitting || '') + '">';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="comments_kitting">Comments:</label>';
        html += '<input style="width:100%"type="text" id="comments_kitting" name="comments_kitting" value="' + (item.comments_kitting || '') + '">';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="submitted_datetime">Submitted Date Time:</label>';
        html += '<input style="width:100%"type="text" id="submitted_datetime" name="submitted_datetime" value="' + (item.submitted_datetime || '') + '" readonly>';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="created_at">Created At:</label>';
        html += '<input style="width:100%"type="text" id="created_at" name="created_at" value="' + (item.created_at || '') + '" readonly>';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="updated_at">Updated At:</label>';
        html += '<input style="width:100%"type="text" id="updated_at" name="updated_at" value="' + (item.updated_at || '') + '" readonly>';
        html += '</div>';

        html += '<hr>'; // Add a separator between items
    });

   //html += '<input type="submit" value="Submit">';
    html += '</fieldset></form>';

    return html;
}

function resetKittingForm() {
    // Uncheck checkboxes
    $('input[name="cut_form_mach_parts"]').prop('checked', false);
    $('input[name="bought_out_components"]').prop('checked', false);
    $('input[name="fasteners_fixings"]').prop('checked', false);
    $('input[name="site_pack"]').prop('checked', false);

    // Clear text inputs
    $('input[name="sign_off_kitting"]').val('');
    $('textarea[name="comments_kitting"]').val('');

    // Reset file input values and filenames
    $('input[name="kitting_file"]').val('');
    $('#kitting_file_filename').text('');

    // Show the kitting form section if it was hidden
    $('#kittingFieldset').show();
}

function Kitting(processOrder, userName) {
    console.log('Kitting');
    console.log(processOrder);
    $('#planningFieldset').hide();
    $('#qualityFieldset').hide();
    $('#manufacturingFieldset').hide();
    $('#engineeringFieldset').hide();
    $('#kittingFieldset').hide();
    $('#kittingFieldset').show();
    $('input[name="sign_off_kitting"]').val(userName);
    $('#process_order_number_kitting').val(processOrder);
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // Add other headers if needed
    };

    var formData = {
        process_order_number: processOrder
        // Add other form data if needed
    };

    // Fetch Kitting Form Data for the given process order
    $.ajax({
        url: '/getKittingDataByProcessOrder', // Adjust URL as needed
        type: 'POST',
        headers: headers,
        data: formData,
        dataType: 'json',
        success: function(response) {
            resetKittingForm();

            console.log(userName);
            $('input[name="sign_off_kitting"]').val(userName);
            if (response.data != null) {
                console.log('yes po found');
                console.log(response);
                $('#process_order_number_kitting').val(processOrder);

                // Set checkbox states
                $('input[name="cut_form_mach_parts"]').prop('checked', response.data.cut_form_mach_parts === "on");
                $('input[name="bought_out_components"]').prop('checked', response.data.bought_out_components === "on");
                $('input[name="fasteners_fixings"]').prop('checked', response.data.fasteners_fixings === "on");
                $('input[name="site_pack"]').prop('checked', response.data.site_pack === "on");

                // Set other fields
                $('input[name="sign_off_kitting"]').val(userName);
                $('textarea[name="comments_kitting"]').val(response.data.comments_kitting);

                // Set file input field
                if (response.kitting_file_filename !== null) {
                    $('#kitting_file_filename').text(response.data.kitting_file_filename);
                }

                // Attach handler for file input change
                $('input[name="kitting_file_document"]').change(function() {
                    $('#kitting_file_filename').text(this.files[0].name);
                });
            } else {
                resetKittingForm();
                $('#process_order_number_kitting').val(processOrder);
                $('input[name="sign_off_kitting"]').val(userName);
                $('#kittingFieldset').show();
            }
        },
        error: function(error) {
            console.error(error);
        }
    });
}

