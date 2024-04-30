function generateMaterialPreparationFieldset(processOrder, qualityStep, username) {
    $("#sign_off_material_preparation").val(username);
    
}

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
        html += '<input name="process_order_number_mp_c" type="text" value="' + item.process_order_number.trim() + '" readonly>';
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
            '<input type="text" name="sign_off_material_preparation" value="' + userName + '">' +
            '</div><br>';

        html += '<div class="material_field">';
        html +=
            '<label>Comments:</label>' +
            '<input type="text" name="comments_material_preparation" value="' + item.comments_material_preparation + '">' +
            '</div><br>';

        html += '</div>'; // Closing div for material_item
        html += '<hr>'; // Horizontal line for separation
        html += '<input type="button" value="View" onclick="viewMaterialCompletePreparationForm(\'' + item.process_order_number + '\')">';
    });

    html += '<input type="button" value="Submit" onclick="submitMaterialCompletePreparationForm()">';
    html += '</form>';

    html += '<div id="material_complete_preparation_results"></div>';
    html += '</fieldset>';

    return html;
}

function viewMaterialCompletePreparationForm(po)
{
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };
    var formData = {po:document.querySelector('[name="process_order_number_mp_c"]').value};
   
console.log(formData);

    $.ajax({
        type: "POST",
        url: "/viewMaterialCompletePreparationForm",
        data: formData,
        headers: headers,
        dataType: "json",
       
        success: function (response) {
            console.log(response);
            displayMaterialPreparationResults(response);
            
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
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
        process_order_number: document.querySelector('[name="process_order_number_mp_c"]').value,
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

        material_identification_record_file: (document.querySelector('[name="material_identification_record_file"]').files.length > 0)
        ? document.querySelector('[name="material_identification_record_file"]').files[0].name
        : document.getElementById('old-file-name_1').textContent.trim(),
        material_traceability_file: (document.querySelector('[name="material_traceability_file"]').files.length > 0)
        ? document.querySelector('[name="material_traceability_file"]').files[0].name
        : document.getElementById('old-file-name_2').textContent.trim(),
     
        sign_off_material_preparation: document.querySelector(
            '[name="sign_off_material_preparation"]'
        ).value,
        comments_material_preparation: document.querySelector(
            '[name="comments_material_preparation"]'
        ).value,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number: (document.querySelector('[name="process_order_number_mp"]').value.trim() !== "")
        ? document.querySelector('[name="process_order_number_mp"]').value.trim()
        : null,
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
    fileData.append("process_order_number", document.querySelector('[name="process_order_number_mp"]').value.trim());

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
        type: 'POST',
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
    var html = '<form id="materialPreparationForm" class="material-preparation-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Material Preparation</legend>';

    $.each(response, function(index, item) {
        html += '<div class="form-group">';
        html += '<label for="id">ID:</label>';
        html += '<input type="text" id="id" name="id" value="' + item.id + '" readonly>';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="material_identification">Material Identification:</label>';
        html += '<input type="checkbox" id="material_identification" name="material_identification" ' + (item.material_identification === 'true' ? 'checked' : '') + '>';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="material_identification_record">Material Identification Record:</label>';
        html += '<input type="text" id="material_identification_record" name="material_identification_record" value="' + (item.material_identification_record || '') + '">';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="material_identification_record_file">Material Identification Record File:</label>';
        if (item.material_identification_record_file) {
            var filePath = 'storage/material_preparation_task/' + item.process_order_number + '/' + item.material_identification_record_file;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<input type="file" id="material_identification_record_file" name="material_identification_record_file">';
            html += downloadLink;
        } else {
            html += '<input type="file" id="material_identification_record_file" name="material_identification_record_file">';
        }
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="material_traceability">Material Traceability:</label>';
        html += '<input type="text" id="material_traceability" name="material_traceability" value="' + (item.material_traceability || '') + '">';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="material_traceability_file">Material Traceability File:</label>';
        if (item.material_traceability_file) {
            var filePath = 'storage/material_preparation_task/' + item.process_order_number + '/' + item.material_traceability_file;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<input type="file" id="material_traceability_file" name="material_traceability_file">';
            html += downloadLink;
        } else {
            html += '<input type="file" id="material_traceability_file" name="material_traceability_file">';
        }
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="cutting">Cutting:</label>';
        html += '<input type="checkbox" id="cutting" name="cutting" ' + ((item.cutting === 'true' || item.cutting === 'on') && item.cutting !== null ? 'checked' : '') + '>';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="deburring">De-burring:</label>';
        html += '<input type="checkbox" id="deburring" name="deburring" ' + ((item.deburring === 'true' || item.deburring === 'on') && item.deburring !== null ? 'checked' : '') + '>';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="forming">Forming:</label>';
        html += '<input type="checkbox" id="forming" name="forming" ' + ((item.forming === 'true' || item.forming === 'on') && item.forming !== null ? 'checked' : '') + '>';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="machining">Machining:</label>';
        html += '<input type="checkbox" id="machining" name="machining" ' + ((item.machining === 'true' || item.machining === 'on') && item.machining !== null ? 'checked' : '') + '>';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="sign_off_material_preparation">Sign-off:</label>';
        html += '<input type="text" id="sign_off_material_preparation" name="sign_off_material_preparation" value="' + (item.sign_off_material_preparation || '') + '">';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="comments_material_preparation">Comments:</label>';
        html += '<textarea id="comments_material_preparation" name="comments_material_preparation">' + (item.comments_material_preparation || '') + '</textarea>';
        html += '</div>';

        html += '<hr>'; // Add a separator between items
    });

    html += '<input type="submit" value="Submit">';
    html += '</fieldset></form>';

    return html;
}

function resetMaterialPrepForm() {
    // Uncheck checkboxes
    $('[name="cutting"]').prop('checked', false);
    $('[name="deburring"]').prop('checked', false);
    $('[name="forming"]').prop('checked', false);
    $('[name="machining"]').prop('checked', false);

    // Clear text inputs
    $('[name="material_identification"]').val('');
    $('[name="material_identification_record"]').val('');
    $('[name="material_traceability"]').val('');
    $('[name="sign_off_material_preparation"]').val('');
    $('[name="comments_material_preparation"]').val('');

    // Reset file input values and old file name display
    $('[name="material_identification_record_file"]').val('');
    $('[name="material_traceability_file"]').val('');
    $('.old-file-name_1').text('');
    $('.old-file-name_2').text('');
}
function MaterialPrep(processOrder, userName) {
    console.log('Material Preparation');
    console.log(userName);
    
    // Hide other fieldsets and show Material Preparation fieldset
    $('#planningFieldset').hide();
    $('#qualityFieldset').hide();
    $('#manufacturingFieldset').hide();
    $('#materialpreparationFieldset').show();

    // Set process order and user name
    $('#sign_off_material_preparation').val(userName);
    $('#process_order_number').val(processOrder);

    // AJAX request headers
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // Add other headers if needed
    };

    var formData = {
        process_order_number: processOrder
        // Add other form data if needed
    };

    // Fetch Material Preparation Form Data for the given process order
    $.ajax({
        url: '/getMaterialPreparationDataByProcessOrder', // Adjust URL as needed
        type: 'POST',
        headers: headers,
        data: formData,
        dataType: 'json',
        success: function (response) {
            resetMaterialPrepForm();
            console.log(response);
            $('#sign_off_material_preparation').val(userName);
            
            if (response.data != null) {
                console.log('Material Prep data found');
                $.each(response, function (index, item) {
                    console.log(item.cutting);
                    $('#process_order_number_mp').val(processOrder);

                    // Set checkbox values
                    $('input[name="cutting"]').prop('checked', item.cutting === 'on');
                    $('input[name="deburring"]').prop('checked', item.deburring === 'on');
                    $('input[name="forming"]').prop('checked', item.forming === 'on');
                    $('input[name="machining"]').prop('checked', item.machining === 'on');

                    // Other fields
                    $('#sign_off_material_preparation').val(userName);
                    $('#comments_material_preparation').val(item.comments_material_preparation);

                    // File input fields
                    $('#material_identification_record').val(item.material_identification_record);
                    $('#material_identification').val(item.material_identification);
                    
                    $('#material_traceability').val(item.material_traceability);
                    $('#old-file-name_1').text(item.material_identification_record_file);
                    $('#old-file-name_2').text(item.material_traceability_file);

                    // Set the labels for file inputs
                    $('#material_identification_record_file_label').show();
                    $('#material_traceability_file_label').show();

                    // Attach handlers for file input changes
                    $('#material_identification_record_file').change(function () {
                        $('#old-file-name_1').text(this.files[0].name);
                    });

                    $('#material_traceability_file').change(function () {
                        $('#old-file-name_1').text(this.files[0].name);
                    });
                });
            } else {
                resetMaterialPrepForm();
                console.log('hete');
                $('#sign_off_material_preparation').val(userName);
                $('#materialpreparationFieldset').show();
                $('#process_order_number_mp').val(processOrder);
            }
        },
        error: function (error) {
            console.error(error);
        }
    });
}
