function generateFinalAssemblyFieldset(processOrder, qualityStep, username) {
    $("#sign_off_final_assembly").val(username);
    return `
    <fieldset>
        <legend>Final Assembly</legend>

        <!-- Subtask 11.1: Walk-down and visual inspection -->
        <div class="form-group">
            <label>
                Walk-down and visual inspection:
                <input type="text" name="walk_down_inspection">
            </label>
        </div>

        <!-- Subtask 11.2: Identification -->
        <div class="form-group">
            <label>
                Identification:
                <input type="text" name="identification">
            </label>
        </div>

        <!-- Upload Images -->
        <div class="form-group">
            <label>
                Upload Images:
                <input type="file" name="images[]" id="imagesInput" multiple>
                <!-- Upload Images button -->
                <br>
        <button type="button" onclick="uploadImages('${processOrder}')">Upload Images</button>
        <br>
            </label>
        </div>

        <!-- File Uploads for Final Assembly -->
        <div class="form-group">
            <label>
                Upload File 1:
                <input type="file" name="final_assembly_file_1" accept=".pdf,.doc,.docx,.txt">
            </label>
        </div>

        <div class="form-group">
            <label>
                Upload File 2:
                <input type="file" name="final_assembly_file_2" accept=".pdf,.doc,.docx,.txt">
            </label>
        </div>

        <div class="form-group">
            <label>
                Upload File 3:
                <input type="file" name="final_assembly_file_3" accept=".pdf,.doc,.docx,.txt">
            </label>
        </div>

        <!-- Sign-off for Final Assembly -->
        <div class="form-group">
            <label>
                Sign-off for Final Assembly:
                <input type="text" name="sign_off_final_assembly" value="${username}">
            </label>
        </div>

        <!-- Comments for Final Assembly -->
        <div class="form-group">
            <label>
                Comments for Final Assembly:
                <textarea name="comments_final_assembly" rows="4" cols="50"></textarea>
            </label>
        </div>

        <!-- Submit button -->
        <button type="button" onclick="submitFinalAssemblyForm('${processOrder}')">Submit Final Assembly Form</button>

        
    </fieldset>
    `;
}


var uploadImagesRoute = "{{ route('upload.images') }}";

// Function to handle image upload
function uploadImages(po) {
    var imagesInput = document.getElementById('imagesInput');
    var formData = new FormData();

    // Append each selected image to the formData
    for (var i = 0; i < imagesInput.files.length; i++) {
        formData.append('images[]', imagesInput.files[i]);
    }

    // Append other form data if needed
    formData.append('process_order_number', po);
    formData.append('username', '{{ $username }}');

    // Send the images using AJAX
    $.ajax({
        url: '/upload',
        type: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        processData: false,
        contentType: false,
        success: function (response) {
            console.log('Images uploaded successfully');
            // Handle success response if needed
        },
        error: function (xhr, status, error) {
            console.error('Error uploading images:', error);
            // Handle error if needed
        }
    });
}
function submitFinalAssemblyForm(processOrder) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };
    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }

    var formData = new FormData();
    formData.append('process_order_number', processOrder);
    formData.append('walk_down_inspection', document.querySelector('[name="walk_down_inspection"]').value);
    formData.append('identification', document.querySelector('[name="identification"]').value);
    formData.append('sign_off_final_assembly', document.querySelector('[name="sign_off_final_assembly"]').value);
    formData.append('comments_final_assembly', document.querySelector('[name="comments_final_assembly"]').value);
    //formData.append('submission_date', new Date().toISOString().split("T")[0]); // Get today's date in YYYY-MM-DD format

    formData.append('final_assembly_file_3', getFileName('final_assembly_file_3'));
    formData.append('final_assembly_file_2', getFileName('final_assembly_file_2'));
    formData.append('final_assembly_file_1', getFileName('final_assembly_file_1'));


    console.log(formData);

    // Send an AJAX request to the server
    $.ajax({
        url: "/submitFinalAssemblyForm",
        type: "POST",
        data: formData,
        headers: headers,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            alert("Final Assembly form submitted successfully");
            // Optionally update the table or perform other actions
        },
        error: function (error) {
            console.error("Error:", error);
            alert("Error submitting Final Assembly form");
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
        url: '/handleFileUploadFinalAssembly',  // Update to your actual route
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

function generateFinalAssemblyFieldTable(processOrder, qualityStep) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: processOrder,
    };

    $.ajax({
        url: "/getFinalAssemblyDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML =
                generateHTMLFromResponse_for_final_assembly(response);

            $("#finalassemblyFieldTable").html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        },
    });

    return `
            <div>To be Done</div>
        `;
}

function generateHTMLFromResponse_for_final_assembly(response) {
    var html = '<table id="final_assembly_table" style="width:100%;">';
    html += '<thead><tr>';
    html += '<th style="width:5%;">Final Assembly ID</th>';
    html += '<th style="width:20%;">Process Order</th>';
    html += '<th style="width:20%;">Walk-down and Visual Inspection</th>';
    html += '<th style="width:20%;">Identification</th>';
    html += '<th style="width:20%;">Sign-off for Final Assembly</th>';
    html += '<th style="width:20%;">Comments for Final Assembly</th>';
    html += '<th style="width:20%;">Final Assembly File1</th>';
    html += '<th style="width:20%;">Final Assembly File2</th>';
    html += '<th style="width:20%;">Final Assembly File3</th>';

    html += '<th style="width:20%;">Submission Date</th>';
    html += '<th style="width:5%;">Created At</th>';
    html += '<th style="width:5%;">Updated At</th>';
    html += '</tr></thead><tbody>';

    $.each(response, function (index, item) {
        html += "<tr>";
        html += "<td>" + item.id + "</td>";
        html += "<td>" + item.process_order_number + "</td>";
        html += "<td>" + item.walk_down_inspection + "</td>";
        html += "<td>" + item.identification + "</td>";
        html += "<td>" + item.sign_off_final_assembly + "</td>";
        html += "<td>" + item.comments_final_assembly + "</td>";
        html += '<td>';
        if (item.final_assembly_file_1) {
           
            var filePath = 'storage/final_assembly_tasks/' + item.process_order_number + '/' + item.final_assembly_file_1;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</td>';
        html += '<td>';
        if (item.final_assembly_file_2) {
           
            var filePath = 'storage/final_assembly_tasks/' + item.process_order_number + '/' + item.final_assembly_file_2;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</td>';
        html += '<td>';
        if (item.final_assembly_file_3) {
           
            var filePath = 'storage/final_assembly_tasks/' + item.process_order_number + '/' + item.final_assembly_file_3;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</td>';
        html += "<td>" + item.submission_date + "</td>";
        html += "<td>" + item.created_at + "</td>";
        html += "<td>" + item.updated_at + "</td>";
        html += "</tr>";
    });

    html += "</tbody></table>";

    return html;
}


function generateFinalAssemblyCompleteFieldset(processOrder, qualityStep, username) {
    var formData = {
        process_order_number: processOrder,
    };
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    $("#sign_off_final_assembly").val(username);

    $.ajax({
        url: "/getFinalAssemblyDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);

            if (response.data !== null) {
                var generatedHTML = generateCompleteHTMLFromResponse_for_final_assembly(response.data);
                $("#finalassemblyCompleteFieldTable").html(generatedHTML);
            } else {
                $("#finalassemblyCompleteFieldTable").html('');
            }
        },
        error: function (error) {
            console.error(error);
        },
    });
}

function generateCompleteHTMLFromResponse_for_final_assembly(item) {
    var html = '<fieldset><legend>Final Assembly Complete</legend>';
    html += '<form id="final_assembly_complete_form">';

    html += '<div class="final_assembly_item">';
    html += '<label>ID: ' + item.id + '</label><br>';
    html += '<div class="final_assembly_item">';
    html += '<label>Process Order: ' + item.process_order_number + '</label><br>';
    html += '<div class="final_assembly_item">';
    html += '<input type="hidden" name="process_order_number" value="' + item.process_order_number + '"><br>';

    // Field for Walk-down and visual inspection
    html += '<div class="final_assembly_field">';
    html += '<label>Walk-down and Visual Inspection:</label>';
    html += '<input type="text" name="walk_down_inspection" value="' + item.walk_down_inspection + '">';
    html += '</div><br>';

    // Field for Identification
    html += '<div class="final_assembly_field">';
    html += '<label>Identification:</label>';
    html += '<input type="text" name="identification" value="' + item.identification + '">';
    html += '</div><br>';

    // Field for Sign-off for Final Assembly
    html += '<div class="final_assembly_field">';
    html += '<label>Sign-off for Final Assembly:</label>';
    html += '<input type="text" name="sign_off_final_assembly" value="' + item.sign_off_final_assembly + '">';
    html += '</div><br>';

    // Field for Comments for Final Assembly
    html += '<div class="final_assembly_field">';
    html += '<label>Comments for Final Assembly:</label>';
    html += '<textarea name="comments_final_assembly">' + item.comments_final_assembly + '</textarea>';
    html += '</div><br>';

    // Field for Final Assembly File 1
    html += '<div class="final_assembly_field">';
    html += '<label>Final Assembly File 1:</label>';
    html += '<input type="file" name="final_assembly_file_1" accept=".pdf,.doc,.docx,.txt">';
    html += '</div><br>';

    // Field for Final Assembly File 2
    html += '<div class="final_assembly_field">';
    html += '<label>Final Assembly File 2:</label>';
    html += '<input type="file" name="final_assembly_file_2" accept=".pdf,.doc,.docx,.txt">';
    html += '</div><br>';

    // Field for Final Assembly File 3
    html += '<div class="final_assembly_field">';
    html += '<label>Final Assembly File 3:</label>';
    html += '<input type="file" name="final_assembly_file_3" accept=".pdf,.doc,.docx,.txt">';
    html += '</div><br>';

    // Field for Status
    html += '<div class="final_assembly_field">';
    html += '<label>Status:</label>';
    // Added Status dropdown
    html += '<div class="fabrication_field">';
    html +=
        '<label>Status:</label>' +
        '<select name="status">' +
        '<option value="partially_completed">Partially Completed</option>' +
        '<option value="completed">Completed</option>' +
        '</select>' +
        '</div><br>';
    html += '</div><br>';

    // Field for Quantity
    html += '<div class="final_assembly_field">';
    html += '<label>Quantity:</label>';
    html += '<input type="number" name="quantity" value="' + item.quantity + '">';
    html += '</div><br>';

    // Submit button
    html += '<input type="button" value="Submit" onclick="submitFinalAssemblyCompleteForm()">';

    // View button
    html += '<input type="button" value="View" onclick="viewFinalAssemblyCompleteForm(\'' + item.process_order_number + '\')">';
    html += '<div id="final_assembly_results_table"></div>';
    html += '</form></fieldset>';

    return html;
}


function submitFinalAssemblyCompleteForm() {
    var formData = new FormData(document.getElementById('final_assembly_complete_form'));
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    $.ajax({
        type: "POST",
        url: "/submitFinalAssemblyCompleteForm",
        data: formData,
        headers: headers,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);
            
            //alert("Final Assembly Complete form submitted successfully");
            // Optionally update the table or perform other actions
        },
        error: function (error) {
            console.error("Error:", error);
            alert("Error submitting Final Assembly Complete form");
        },
    });
}

function viewFinalAssemblyCompleteForm(processOrderNumber) {
    var formData = {
        process_order_number: processOrderNumber,
    };
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    $.ajax({
        url: "/viewFinalAssemblyCompleteForm",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            displayFinalAssemblyCompleteResults(response);
        },
        error: function (error) {
            console.error(error);
            alert("Error fetching Final Assembly Complete form data");
        },
    });
}

function displayFinalAssemblyCompleteResults(values) {
    var resultsHtml = '<table id="final_assembly_results_table" style="width:100%; border: 1px solid #ddd; text-align: left;">';
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

    document.getElementById('final_assembly_results_table').innerHTML = resultsHtml;
}
