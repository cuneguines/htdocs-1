function generateFabricationFitUpFieldset(processOrder, qualityStep, username) {
    $("#sign_off_fabrication_fit_up").val(username);
    return `
    
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
        process_order_number: (document.querySelector('[name="process_order_number_fabrication_fit_up"]').value.trim() !== "")
        ? document.querySelector('[name="process_order_number_fabrication_fit_up"]').value.trim()
        : null,
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
            $(myModal).hide();
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
    fileData.append('process_order_number', document.querySelector('[name="process_order_number_fabrication_fit_up"]').value.trim());

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
    var html = '<form id="fabricationFitUpForm" class="fabrication-fit-up-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Fabrication Fit-Up</legend>';

    $.each(response, function(index, item) {
        html += '<div class="fabrication-item">';
       // html += '<label for="id">ID:</label>';
       // html += '<input type="text" id="id" name="id" value="' + item.Id + '" readonly>';
        html += '<br>';

        html += '<div class="fabrication-field">';
        html += '<label for="fit_up_visual_check">Fit-Up Visual Check:</label>';
        html += '<input type="checkbox" id="fit_up_visual_check" name="fit_up_visual_check" ' + (item.FitUpVisualCheck === 'true' ? 'checked disabled' : 'disabled') + '>';
        html += '</div><br>';

        html += '<div class="fabrication-field">';
        html += '<label for="dimensional_check">Dimensional Check:</label>';
        html += '<input type="checkbox" id="dimensional_check" name="dimensional_check" ' + (item.DimensionalCheck === 'true' ? 'checked disabled' : 'disabled') + '>';
        html += '</div><br>';

        html += '<div class="fabrication-field">';
        html += '<label for="link_to_drawing">Link to Drawing:</label>';
        if (item.LinkToDrawing) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/fabricationfitup_task/' + item.ProcessOrder + '/' + item.LinkToDrawing;
            var downloadLink = '<a href="' + filePath + '" download>' +item.LinkToDrawing +'</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</div><br>';

        html += '<div class="fabrication-field">';
        html += '<label for="weldment_quantity">Weldment Quantity:</label>';
        html += '<input type="checkbox" id="weldment_quantity" name="weldment_quantity" ' + (item.WeldmentQuantity === 'true' ? 'checked disabled' : 'disabled') + '>';
        html += '</div><br>';

        html += '<div class="fabrication-field">';
        html += '<label for="sign_off_fabrication_fit_up">Sign Off:</label>';
        html += '<input type="text" id="sign_off_fabrication_fit_up" name="sign_off_fabrication_fit_up" value="' + (item.SignOffUser ? item.SignOffUser : '') + '">';
        html += '</div><br>';

        html += '<div class="fabrication-field">';
        html += '<label for="comments_fabrication_fit_up">Comments:</label>';
        html += '<input type="text" id="comments_fabrication_fit_up" name="comments_fabrication_fit_up" value="' + (item.Comments ? item.Comments : '') + '">';
        html += '</div><br>';

        html += '</div>'; // Closing div for fabrication-item
        html += '<hr>'; // Horizontal line for separation
    });

   // html += '<input type="button" value="Submit" onclick="submitFabricationFitUpForm()">';
   

    return html;
}

function viewFabricationFitUpCompleteForm(processOrderNumber) {
    var formData = {
        process_order_number: processOrderNumber,
    };
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    $.ajax({
        url: "/viewFabricationFitUpCompleteForm",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            displayFabricationFitUpResults(response.data);
        },
        error: function (error) {
            console.error(error);
            alert("Error fetching Final Assembly Complete form data");
        },
    });
}

/* function displayFabCompleteResults(values) {
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
} */

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
            if (response.data!=null)
            {
            var generatedHTML = generateCompleteHTMLFromResponse_for_fabrication_fit_up(response);
            $("#fabricationfitupCompleteFieldTable").html(generatedHTML);
            }
            else
            {
                $("#fabricationfitupCompleteFieldTable").html('');
            }
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
        //html += '<label>ID: ' + item.id + '</label><br>';
        html += '<br><input name="process_order_fabc" type="text" value="' + item.ProcessOrder + '"><br><br>';

        html += '<div class="fabrication_field">';
        html +=
            '<label>Fit-Up:</label>' +
            (item.FitUpVisualCheck === "true" || item.FitUpVisualCheck === "on" ?
            '<input type="checkbox" id="fit_up_visual_check" name="fit_up_visual_check_c" >' :
            '<input type="checkbox" id="fit_up_visual_check" name="fit_up_visual_check_c" disabled>') +
            '</div><br>';

        html += '<div class="fabrication_field">';
        html +=
            '<label>Dimensional Check:</label>' +
            (item.DimensionalCheck === "true" || item.DimensionalCheck === "on" ?
            '<input type="checkbox" id="dimensional_check" name="dimensional_check_c" >' :
            '<input type="checkbox" id="dimensional_check" name="dimensional_check_c" disabled>') +
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
            '<input type="checkbox" id="weldment_quantity" name="weldment_quantity_c" >' :
            '<input type="checkbox" id="weldment_quantity" name="weldment_quantity_c" disabled>') +
            '</div><br>';

        html += '<div class="fabrication_field">';
        html +=
            '<label>Sign Off:</label>' +
            '<input type="text" name="sign_off_fabrication_fit_up_c" value="' + userName + '">' +
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
            '<input type="number" name="quantity_fb" value="' + item.Quantity + '">' +
            '</div><br>';

        html += '</div>'; // Closing div for fabrication_item
        html += '<hr>'; // Horizontal line for separation
        html += '<input type="button" value="View" onclick="viewFabricationFitUpCompleteForm(\'' + item.ProcessOrder + '\')">';
    });

    html += '<input type="button" value="Submit" onclick="submitFabricationCompleteFitUpForm()">';
    //html += '<input type="button" value="View" onclick="viewFabricationFitUpCompleteForm(\'' + item.ProcessOrder + '\')">';
    html += '</fieldset></form>';
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
        fit_up_visual_check: document.querySelector('[name="fit_up_visual_check_c"]').checked ? 1:0,
        dimensional_check: document.querySelector('[name="dimensional_check_c"]').checked ? 1:0,
        link_to_drawing: document.querySelector('[name="link_to_drawing"]').value,
        weldment_quantity: document.querySelector('[name="weldment_quantity_c"]').checked ? 1:0,
        signOffUser: document.querySelector('[name="sign_off_fabrication_fit_up_c"]').value,
        comments_fabrication_fit_up: document.querySelector('[name="comments_fabrication_fit_up"]').value,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number: document.querySelector('[name="process_order_fabc"]').value,
        Quantity: document.querySelector('[name="quantity_fb"]').value,
    };
    console.log(formData);

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
                    if (value=="1")
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

    document.getElementById('fabrication_fit_up_complete_results').innerHTML = resultsHtml;
}


function resetFabricationFitUpForm() {
    // Uncheck checkboxes
    $('input[name="fit_up_visual_check"]').prop('checked', false);
    $('input[name="dimensional_check"]').prop('checked', false);
    $('input[name="weldment_quantity"]').prop('checked', false);

    // Clear text inputs
    $('input[name="sign_off_fabrication_fit_up"]').val('');
    $('textarea[name="comments_fabrication_fit_up"]').val('');

    // Reset file input values and filenames
    $('input[name="link_to_drawing"]').val('');
    $('#old_drawing_filename').text('');

    // Show the fabrication fit-up form section if it was hidden
    $('#fabricationFitUpFieldset').show();
}

function FabricationFitUp(processOrder, userName) {
    console.log('Fabrication Fit-Up');
    console.log(processOrder);
    $('#planningFieldset').hide();
    $('#qualityFieldset').hide();
    $('#manufacturingFieldset').hide();
    $('#engineeringFieldset').hide();
    $('#fabricationfitupFieldset').hide();
    $('#fabricationfitupFieldset').show();
    $('input[name="sign_off_fabrication_fit_up"]').val(userName);
    $('#process_order_number_fabrication_fit_up').val(processOrder);
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // Add other headers if needed
    };

    var formData = {
        process_order_number: processOrder
        // Add other form data if needed
    };

    // Fetch Fabrication Fit-Up Form Data for the given process order
    $.ajax({
        url: '/getFabricationFitUpDataByProcessOrder', // Adjust URL as needed
        type: 'POST',
        headers: headers,
        data: formData,
        dataType: 'json',
        success: function(response) {
            resetFabricationFitUpForm();

            console.log(userName);
            $('input[name="sign_off_fabrication_fit_up"]').val(userName);
            if (response.data != null) {
                console.log('yes po found');
                console.log(response);
                $('#process_order_number_fabrication_fit_up').val(processOrder);

                // Set checkbox states
                $('input[name="fit_up_visual_check"]').prop('checked', response.data.FitUpVisualCheck === "true");
                $('input[name="dimensional_check"]').prop('checked', response.data.DimensionalCheck === "true");
                $('input[name="weldment_quantity"]').prop('checked', response.data.WeldmentQuantity === "true");

                // Set other fields
                $('input[name="sign_off_fabrication_fit_up"]').val(userName);
                $('textarea[name="comments_fabrication_fit_up"]').val(response.data.Comments);

                // Set file input field
                if (response.data.LinkToDrawing !== null) {
                    $('#old_drawing_filename').text(response.data.LinkToDrawing);
                }

                // Attach handler for file input change
                $('input[name="link_to_drawing"]').change(function() {
                    $('#old_drawing_filename').text(this.files[0].name);
                });
            } else {
                resetFabricationFitUpForm();
                $('#process_order_number_fabrication_fit_up').val(processOrder);
                $('input[name="sign_off_fabrication_fit_up"]').val(userName);
                $('#fabricationfitupFieldset').show();
            }
        },
        error: function(error) {
            console.error(error);
        }
    });
}
