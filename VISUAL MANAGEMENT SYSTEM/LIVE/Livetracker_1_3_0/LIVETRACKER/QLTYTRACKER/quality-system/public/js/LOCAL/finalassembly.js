function generateFinalAssemblyFieldset(processOrder, qualityStep, username) {
    $("#sign_off_final_assembly").val(username);
    return `
   
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
    formData.append('process_order_number', document.querySelector('[name="process_order_number_finalassembly"]').value.trim());
   // formData.append('walk_down_inspection', document.querySelector('[name="walk_down_inspection"]').value);
    formData.append('identification', document.querySelector('[name="attach_part_id_labels"]').value?.checked || null);
    formData.append('sign_off_final_assembly', document.querySelector('[name="sign_off_final_assembly"]').value);
    formData.append('comments_final_assembly', document.querySelector('[name="comments_final_assembly"]').value);
    //formData.append('submission_date', new Date().toISOString().split("T")[0]); // Get today's date in YYYY-MM-DD format

    //formData.append('final_assembly_file_3', getFileName('final_assembly_file_3'));
    //formData.append('final_assembly_file_2', getFileName('final_assembly_file_2'));
    //formData.append('final_assembly_file_1', getFileName('final_assembly_file_1'));


    console.log(formData.identification);

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
            $(myModal).hide();
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

function generateHTMLFromResponse_for_final_assembly_old(response) {
    var html = '<table id="final_assembly_table" style="width:100%;">';
    html += '<thead><tr>';
    html += '<th style="width:5%;">Final Assembly ID</th>';
    html += '<th style="width:20%;">Process Order</th>';
   // html += '<th style="width:20%;">Walk-down and Visual Inspection</th>';
    html += '<th style="width:20%;">Identification</th>';
    html += '<th style="width:20%;">Sign-off for Final Assembly</th>';
    html += '<th style="width:20%;">Comments for Final Assembly</th>';
    //html += '<th style="width:20%;">Final Assembly File1</th>';
    //html += '<th style="width:20%;">Final Assembly File2</th>';
    //html += '<th style="width:20%;">Final Assembly File3</th>';

   // html += '<th style="width:20%;">Submission Date</th>';
    html += '<th style="width:5%;">Created At</th>';
    html += '<th style="width:5%;">Updated At</th>';
    html += '</tr></thead><tbody>';

    $.each(response, function (index, item) {
        html += "<tr>";
        html += "<td>" + item.id + "</td>";
        html += "<td>" + item.process_order_number + "</td>";
      //  html += "<td>" + item.walk_down_inspection + "</td>";
        html += "<td>" + item.identification + "</td>";
        html += "<td>" + item.sign_off_final_assembly + "</td>";
        html += "<td>" + item.comments_final_assembly + "</td>";
       // html += '<td>';
      //  if (item.final_assembly_file_1) {
           
      //      var filePath = 'storage/final_assembly_tasks/' + item.process_order_number + '/' + item.final_assembly_file_1;
       //     var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
       //     html += downloadLink;
       // } else {
      //      html += '-';
       // }
       // html += '</td>';
       /*  html += '<td>';
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
        html += "<td>" + item.submission_date + "</td>"; */
        html += "<td>" + item.created_at + "</td>";
        html += "<td>" + item.updated_at + "</td>";
        html += "</tr>";
    });

    html += "</tbody></table>";

    return html;
}
function generateHTMLFromResponse_for_final_assembly(response) {
    var html = '<form id="finalAssemblyForm" class="final-assembly-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Final Assembly</legend>';

    $.each(response, function (index, item) {
        html+='<div style="width:97%">';
        html += '<div class="final-assembly-item">';
        
        //html += '<label for="final_assembly_id">Final Assembly ID:</label>';
        //html += '<input type="text" id="final_assembly_id" name="final_assembly_id" value="' + item.id + '" readonly>';
        html += '<br>';
        
        html += '<div class="final-assembly-field">';
        html += '<label for="process_order_number">Process Order:</label>';
        html += '<input style="width:100%"type="text" id="process_order_number" name="process_order_number" value="' + item.process_order_number + '">';
        html += '</div><br>';
        
        // Uncomment the following lines if needed
        // html += '<div class="final-assembly-field">';
        // html += '<label for="walk_down_inspection">Walk-down and Visual Inspection:</label>';
        // html += '<input type="text" id="walk_down_inspection" name="walk_down_inspection" value="' + item.walk_down_inspection + '">';
        // html += '</div><br>';
        
        html += '<div class="final-assembly-field">';
html += '<label for="identification">Identification:</label>';
html += '<input type="checkbox" id="identification" name="identification" ' + (item.identification === 'on' ? 'checked disabled' : 'disabled') + '>';
//html += '<input type="checkbox" id="dye_pen_test" name="dye_pen_test" ' + (item.dye_pen_test === "1" ? 'checked' : '') + '">';
html += '</div><br>';

        
        html += '<div class="final-assembly-field">';
        html += '<label for="sign_off_final_assembly">Sign-off for Final Assembly:</label>';
        html += '<input style="width:100%"type="text" id="sign_off_final_assembly" name="sign_off_final_assembly" value="' + item.sign_off_final_assembly + '">';
        html += '</div><br>';
        
        html += '<div class="final-assembly-field">';
        html += '<label for="comments_final_assembly">Comments for Final Assembly:</label>';
        html += '<input style="width:100%"type="text" id="comments_final_assembly" name="comments_final_assembly" value="' + item.comments_final_assembly + '">';
        html += '</div><br>';
        
        // Uncomment the following lines if needed
        // html += '<div class="final-assembly-field">';
        // html += '<label for="final_assembly_file_1">Final Assembly File1:</label>';
        // html += '<input type="text" id="final_assembly_file_1" name="final_assembly_file_1" value="' + item.final_assembly_file_1 + '">';
        // html += '</div><br>';
        // Repeat the above lines for other file fields
        
        // Uncomment the following lines if needed
        // html += '<div class="final-assembly-field">';
        // html += '<label for="submission_date">Submission Date:</label>';
        // html += '<input type="text" id="submission_date" name="submission_date" value="' + item.submission_date + '">';
        // html += '</div><br>';
        
        html += '<div class="final-assembly-field">';
        html += '<label for="created_at">Created At:</label>';
        html += '<input style="width:100%"type="text" id="created_at" name="created_at" value="' + item.created_at + '">';
        html += '</div><br>';
        
        html += '<div class="final-assembly-field">';
        html += '<label for="updated_at">Updated At:</label>';
        html += '<input style="width:100%"type="text" id="updated_at" name="updated_at" value="' + item.updated_at + '">';
        html += '</div><br>';
        
        html += '</div>'; // Closing div for final-assembly-item
        html += '<hr>'; // Horizontal line for separation
    });

   // html += '<input type="button" value="Submit" onclick="submitFinalAssemblyForm()">';
   html+='</div>';
    html += '</fieldset></form>';

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
    html+='<div style="width:97%">';
    html += '<form id="final_assembly_complete_form">';

    html += '<div class="final_assembly_item">';
    html += '<label>ID: ' + item.id + '</label><br>';
    html += '<div class="final_assembly_item">';
    html += '<label>Process Order: ' + item.process_order_number + '</label><br>';
    html += '<div class="final_assembly_item">';
    html += '<input type="hidden" name="process_order_number" value="' + item.process_order_number + '"><br>';

    // Field for Walk-down and visual inspection
  // html += '<div class="final_assembly_field">';
   // html += '<label>Walk-down and Visual Inspection:</label>';
   // html += '<input type="text" name="walk_down_inspection" value="' + item.walk_down_inspection + '">';
   // html += '</div><br>';

  

    html += '<div class="final_assembly_field">';
    html +=
        '<label>Identification:part_id_labels:</label>' +
        (item.identification === "on" ?
            '<input type="checkbox" id="identification" name="identification" >' :
            '<input type="checkbox" id="identification" name="identification" disabled>');
    html += '</div><br>';

    // Field for Sign-off for Final Assembly
    html += '<div class="final_assembly_field">';
    html += '<label>Sign-off for Final Assembly:</label>';
    html += '<input style="width:100%"type="text" name="sign_off_final_assembly" value="' + userName + '">';
    html += '</div><br>';

    // Field for Comments for Final Assembly
    html += '<div class="final_assembly_field">';
    html += '<label>Comments for Final Assembly:</label>';
    html += '<textarea style="width:100%"name="comments_final_assembly">' + item.comments_final_assembly + '</textarea>';
    html += '</div><br>';

    
    
    html += '<div class="fabrication_field">';
    html +=
        '<label>Status:</label>' +
        '<select style="width:100%"name="status">' +
        '<option value="partially_completed">Partially Completed</option>' +
        '<option value="completed">Completed</option>' +
        '</select>' +
        '</div><br>';
    html += '</div><br>';

    // Field for Quantity
    html += '<div class="final_assembly_field">';
    html += '<label>Quantity:</label>';
    html += '<input style="width:100%"type="number" name="quantity" value="' + item.quantity + '">';
    html += '</div><br>';

    // Submit button
    html += '<input type="button" value="Submit" onclick="submitFinalAssemblyCompleteForm()">';

    // View button
    html += '<input type="button" value="View" onclick="viewFinalAssemblyCompleteForm(\'' + item.process_order_number + '\')">';
    html += '<div id="final_assembly_results_table"></div>';
    html+='</div>';
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
            displayFinalAssemblyCompleteResults(response.data);
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
                    //resultsHtml += '<tr><td style="padding: 8px; border-bottom: 1px solid #ddd;">' + field + '</td><td style="padding: 8px; border-bottom: 1px solid #ddd;">' + value + '</td></tr>';
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

    document.getElementById('final_assembly_results_table').innerHTML = resultsHtml;
}
function resetFinalAssemblyForm() {
    // Uncheck checkboxes or reset other input fields as needed
    // For example:
    $('input[name="attach_part_id_labels"]').prop('checked', false);
    $('input[name="sign_off_final_assembly"]').val('');
    $('textarea[name="comments_final_assembly"]').val('');
}

function FinalAssembly(processOrder, userName) {
    console.log('Final Assembly');
    console.log(processOrder);
    // Hide other fieldsets and show Final Assembly fieldset
    $('#planningFieldset').hide();
    $('#qualityFieldset').hide();
    $('#manufacturingFieldset').hide();
    $('#engineeringFieldset').hide();
    $('#kittingFieldset').hide();
    $('#finalassemblyFieldset').show();
    // Set default values if needed
    $('input[name="sign_off_final_assembly"]').val(userName);
    $('#process_order_number_finalassembly').val(processOrder);
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // Add other headers if needed
    };

    var formData = {
        process_order_number: processOrder
        // Add other form data if needed
    };

    // Fetch Final Assembly Form Data for the given process order
    $.ajax({
        url: '/getFinalAssemblyDataByProcessOrder', // Adjust URL as needed
        type: 'POST',
        headers: headers,
        data: formData,
        dataType: 'json',
        success: function(response) {
            resetFinalAssemblyForm();

            console.log(userName);
            $('input[name="sign_off_final_assembly"]').val(userName);
            if (response.data != null) {
                console.log('yes process order found');
                console.log(response);
                $('#process_order_number_final_assembly').val(processOrder);

                // Set checkbox states or other field values
                $('input[name="attach_part_id_labels"]').prop('checked', response.data.identification === "on");
                $('input[name="sign_off_final_assembly"]').val(userName);
                $('textarea[name="comments_final_assembly"]').val(response.data.comments_final_assembly);
                
                // Handle other fields if needed

            } else {
                resetFinalAssemblyForm();
                $('#process_order_number_final_assembly').val(processOrder);
                $('input[name="sign_off_final_assembly"]').val(userName);
                $('#finalassemblyFieldset').show();
            }
        },
        error: function(error) {
            console.error(error);
        }
    });
}
