function generateFinishingFieldset(processOrder, qualityStep, username) {
    $("#sign_off_finishing").val(username);
    
}


function submitFinishingForm(processOrder) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }

    var formData = new FormData();
    formData.set('pickle_passivate_test', document.querySelector('[name="pickle_passivate_test"]').checked ? 1 : 0);
    formData.set('pickle_passivate_document_ref', document.querySelector('[name="pickle_passivate_document_ref"]').value);
    //formData.set('pickle_passivate_document_file_name', getFileName('pickle_passivate_documents'));

   
    formData.set('pickle_passivate_document_file', (document.querySelector('[name="pickle_passivate_documents"]').files.length > 0)
    ? document.querySelector('[name="pickle_passivate_documents"]').files[0].name
    : document.getElementById('old_pickle_passivate_documents').textContent.trim());

    formData.set('select_kent_finish_test', document.querySelector('[name="select_kent_finish_test"]').checked ? 1 : 0);
    formData.set('select_kent_finish_document_ref', document.querySelector('[name="select_kent_finish_document_ref"]').value);
    //formData.set('select_kent_finish_document_file_name', getFileName('select_kent_finish_documents'));

    formData.set('select_kent_finish_document_file', (document.querySelector('[name="select_kent_finish_documents"]').files.length > 0)
    ? document.querySelector('[name="select_kent_finish_documents"]').files[0].name
    : document.getElementById('old_select_kent_finish_documents').textContent.trim());
    formData.set('sign_off_finishing', document.querySelector('[name="sign_off_finishing"]').value);
    formData.set('comments_finishing', document.querySelector('[name="comments_finishing"]').value);
    formData.set('submission_date', new Date().toISOString().split("T")[0]); // Get today's date in YYYY-MM-DD format
    formData.set('process_order_number', document.querySelector('[name="process_order_number_finishing"]').value);

    console.log(formData);

    // Send an AJAX request to the server
    $.ajax({
        url: "/submitFinishingForm",
        type: "POST",
        data: formData,
        headers: headers,
        processData: false, // Prevent jQuery from automatically processing the data
        contentType: false, // Prevent jQuery from setting content type
        success: function (response) {
            console.log(response);
            alert("Finishing form submitted successfully");
            // Optionally update the table or perform other actions
        },
        error: function (error) {
            console.error("Error:", error);
            alert("Error submitting Finishing form");
        },
    });

    var fileData = new FormData();
    var fileInputs = $('[name="pickle_passivate_documents"], [name="select_kent_finish_documents"]');

    // Add process_order_number to FormData
    fileData.append('process_order_number', document.querySelector('[name="process_order_number_finishing"]').value);

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
        url: '/handleFileUploadFinishing',  // Update to your actual route
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

function generateFinishingFieldTable(processOrder, qualityStep) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: processOrder,
    };

    $.ajax({
        url: "/getFinishingDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML = generateHTMLFromResponse_for_finishing(response);

            $("#finishingFieldTable").html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        },
    });

    return `
        <div>Loading Finishing Data...</div>
    `;
}

function generateHTMLFromResponse_for_finishing(response) {
    var html = '<table id="common_table" style="width:100%;">';
    html += '<thead><tr>';
    html += '<th style="width:5%;">Finishing ID</th>';
    html += '<th style="width:20%;">Process Order</th>';
    html += '<th style="width:20%;">Pickle Passivate Document Ref</th>';
    html += '<th style="width:20%;">Pickle Passivate Test</th>';
    html += '<th style="width:20%;">Select Kent Finish Document Ref</th>';
    html += '<th style="width:20%;">Select Kent Finish Test</th>';
    html += '<th style="width:10%;">Sign-off for Finishing</th>';
    html += '<th style="width:10%;">Finishing Files</th>';
    html += '<th style="width:20%;">Comments for Finishing</th>';
    html += '<th style="width:20%;">Submitted Date Time</th>';
    html += '<th style="width:5%;">Created At</th>';
    html += '<th style="width:5%;">Updated At</th>';
    html += '</tr></thead><tbody>';

    $.each(response, function (index, item) {
        html += "<tr>";
        html += "<td>" + item.id + "</td>";
        html += "<td>" + item.process_order_number + "</td>";
        html += "<td>" + item.pickle_passivate_document_ref + "</td>";
        html += "<td>" + (item.pickle_passivate_test === "1" ? "✔" : "") + "</td>";
        html += "<td>" + item.select_kent_finish_document_ref + "</td>";
        html += "<td>" + (item.select_kent_finish_test === "1" ? "✔" : "") + "</td>";
        html += '<td style="text-align:center;">' + item.sign_off_finishing + "</td>";
        html += '<td style="text-align:center;">';

        if (item.pickle_passivate_document_file_name || item.select_kent_finish_document_file_name) {
            var picklePassivateFilePath = 'storage/finishing_task/' + item.process_order_number + '/' + item.pickle_passivate_document_file_name;
            var selectKentFinishFilePath = 'storage/finishing_task/' + item.process_order_number + '/' + item.select_kent_finish_document_file_name;
            var downloadLinks = '';
            if (item.pickle_passivate_document_file_name) {
                downloadLinks += '<a href="' + picklePassivateFilePath + '" download>Download Pickle Passivate File</a>';
            }
            if (item.select_kent_finish_document_file_name) {
                downloadLinks += (downloadLinks ? '<br>' : '') + '<a href="' + selectKentFinishFilePath + '" download>Download Select Kent Finish File</a>';
            }
            html += downloadLinks;
        } else {
            html += '-';
        }
        html += '</td>';

        html += "<td>" + item.comments_finishing + "</td>";
        html += "<td>" + item.submission_date + "</td>";
        html += "<td>" + item.created_at + "</td>";
        html += "<td>" + item.updated_at + "</td>";
        html += "</tr>";
    });

    html += "</tbody></table>";

    return html;
}



function generateFinishingFieldTable(processOrder, qualityStep) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: processOrder,
    };

    $.ajax({
        url: "/getFinishingDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML =
                generateHTMLFromResponse_for_finishing(response);

            $("#finishingFieldTable").html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        },
    });

    return `
            <div>To be Done</div>
        `;
}

function generateHTMLFromResponse_for_finishing(response) {
    var html = '<table id="common_table" style="width:100%;">';
    // Add table headers
    html += '<thead><tr>';
    // Add table header cells
    html += '<th style="width:5%;">ID</th>';
    html += '<th style="width:20%;">Process Order</th>';
    html += '<th style="width:20%;">Pickle and Passivate</th>';
    html += '<th style="width:20%;">Pickle and Passivate Documents</th>';
    html += '<th style="width:20%;">Select Kent Finish</th>';
    html += '<th style="width:20%;">Select Kent Finish Documents</th>';
    html += '<th style="width:20%;">Sign-off for Finishing</th>';
    html += '<th style="width:20%;">Comments for Finishing</th>';
    html += '<th style="width:20%;">Submitted Date Time</th>';
    html += '<th style="width:5%;">Created At</th>';
    html += '<th style="width:5%;">Updated At</th>';
    html += '</tr></thead><tbody>';

    // Loop through response data and populate table rows
    $.each(response, function (index, item) {
        html += "<tr>";
        html += "<td>" + item.id + "</td>";
        html += "<td>" + item.process_order_number + "</td>";
        html += "<td>" + item.pickle_passivate_test + "</td>";
        html += "<td>" + item.pickle_passivate_document_file_name + "</td>";
        html += "<td>" + item.select_kent_finish_test + "</td>";
        html += "<td>" + item.select_kent_finish_document_file_name + "</td>";
        html += "<td>" + item.sign_off_finishing + "</td>";
        html += "<td>" + item.comments_finishing + "</td>";
        html += "<td>" + item.submission_date + "</td>";
        html += "<td>" + item.created_at + "</td>";
        html += "<td>" + item.updated_at + "</td>";
        html += "</tr>";
    });

    // Close table body and table
    html += "</tbody></table>";

    return html;
}

function generateFinishingCompleteFieldset(processOrder, qualityStep, username) {
    var formData = {
        process_order_number: processOrder,
    };
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    $("#sign_off_finishing").val(username);

    $.ajax({
        url: "/getFinishingDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);

            if (response.data !== null) {
                var generatedHTML = generateCompleteHTMLFromResponse_for_finishing(response.data);
                $("#finishingCompleteFieldTable").html(generatedHTML);
            } else {
                $("#finishingCompleteFieldTable").html('');
            }
        },
        error: function (error) {
            console.error(error);
        },
    });
}

function generateCompleteHTMLFromResponse_for_finishing(item) {
    var html = '<fieldset><legend>Finishing Complete</legend>';
    html += '<form id="finishing_complete_form">';

    // Add form fields based on the response data
    html += '<div class="finishing_item">';
    html += '<label>ID: ' + item.id + '</label><br>';
    html += '<input type="hidden" name="process_order_number_f" value="' + item.process_order_number + '"><br>';

    // Add checkboxes for Pickle and Passivate and Select Kent Finish
    html += '<div class="finishing_field">';
    html +=
        '<label>Pickle and Passivate:</label>' +
        (item.pickle_passivate_test === "1" ?
            '<input type="checkbox" id="pickle_passivate_test" name="pickle_passivate_test" >' :
            '<input type="checkbox" id="pickle_passivate_test" name="pickle_passivate_test" disabled>');
    html += '</div><br>';

    html += '<div class="finishing_field">';
    html +=
        '<label>Select Kent Finish:</label>' +
        (item.select_kent_finish_test === "1" ?
            '<input type="checkbox" id="select_kent_finish_test" name="select_kent_finish_test" >' :
            '<input type="checkbox" id="select_kent_finish_test" name="select_kent_finish_test" disabled>');
    html += '</div><br>';

    // Add input fields for document references and file uploads
    html += '<div class="finishing_field">';
    html +=
        '<label>Pickle and Passivate Document Ref:</label>' +
        '<input type="text" name="pickle_passivate_document_ref" value="' + item.pickle_passivate_document_ref + '" disabled>';
    html += '</div><br>';

    html += '<div class="finishing_field">';
    html +=
        '<label>Select Kent Finish Document Ref:</label>' +
        '<input type="text" name="select_kent_finish_document_ref" value="' + item.select_kent_finish_document_ref + '" disabled>';
    html += '</div><br>';

    html += '<div class="finishing_field">';
    html +=
        '<label>Comments:</label>' +
        '<input type="text" name="comments_finishing" value="' + item.comments_finishing + '">';
    html += '</div><br>';

    html += '<div class="finishing_field">';
    html += '<label for="sign_off_finishing">Sign-off:</label>';
    html += '<input type="text" id="sign_off_finishing_c" name="sign_off_finishing_c" value="' + userName + '">';
    html += '</div><br>';

 // Dropdown for status
 html += '<div class="finishing_field">';
 html +=
     '<label>Status:</label>' +
     '<select id="status" name="status">' +
     '<option value="Completed" ' + (item.status === "Completed" ? 'selected' : '') + '>Completed</option>' +
     '<option value="Partially Completed" ' + (item.status === "Partially Completed" ? 'selected' : '') + '>Partially Completed</option>' +
     '</select>';
 html += '</div><br>';

 // Quantity Field
 html += '<div class="finishing_field">';
 html +=
     '<label>Quantity:</label>' +
     '<input type="number" id="quantity" name="quantity" value="' + item.quantity + '" >';
 html += '</div><br>';

    html += '<input type="button" value="Submit" onclick="submitFinishingCompleteForm()">';
    html += '  <input type="button" value="View" onclick="viewFinishingCompleteForm()">';
    html += '</form>';

    html += '<div id="finishing_complete_results"></div>';
    html += '</fieldset>';

    return html;
}

function submitFinishingCompleteForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        // Populate form data from the form fields
        process_order_number: document.querySelector('[name="process_order_number_f"]').value,
        pickle_passivate_test: document.querySelector('[name="pickle_passivate_test"]').checked ? "1" : "0",
        select_kent_finish_test: document.querySelector('[name="select_kent_finish_test"]').checked ? "1" : "0",
        pickle_passivate_document_ref: document.querySelector('[name="pickle_passivate_document_ref"]').value,
        select_kent_finish_document_ref: document.querySelector('[name="select_kent_finish_document_ref"]').value,
        comments_finishing: document.querySelector('[name="comments_finishing"]').value,
        sign_off_finishing: document.querySelector('[name="sign_off_finishing_c"]').value,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format

        status: document.querySelector('#status').value, // Adding status field
        quantity: document.querySelector('[name="quantity"]').value, // Adding quantity field
        // Add other form fields accordingly
    };
console.log(formData);
    $.ajax({
        type: "POST",
        url: "/submitFinishingCompleteForm",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}
function viewFinishingCompleteForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: document.querySelector('[name="process_order_number_f"]').value,
    };

    $.ajax({
        type: "POST",
        url: "/viewFinishingCompleteForm",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            displayFinishingCompleteResults(response.data);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}

function displayFinishingCompleteResults(values) {
    var resultsHtml = '<table id="complete_finishing_results_table" style="width:100%; border: 1px solid #ddd; text-align: left;">';
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

    document.getElementById('finishing_complete_results').innerHTML = resultsHtml;
}


function resetFinishingForm() {
    // Uncheck checkboxes
    $('input[name="pickle_passivate_test"]').prop('checked', false);
    $('input[name="select_kent_finish_test"]').prop('checked', false);

    // Clear text inputs
    $('input[name="sign_off_finishing"]').val('');
    $('textarea[name="comments_finishing"]').val('');

    // Reset file input values and filenames
    $('input[name="pickle_passivate_documents"]').val('');
    $('#old_pickle_passivate_documents').text('');
    $('input[name="select_kent_finish_documents"]').val('');
    $('#old_select_kent_finish_documents').text('');

    // Show the finishing form section if it was hidden
    $('#finishingFieldset').show();
}

function Finishing(processOrder, userName) {
    console.log('Finishing');
    console.log(processOrder);
    $('#planningFieldset').hide();
    $('#qualityFieldset').hide();
    $('#manufacturingFieldset').hide();
    $('#engineeringFieldset').hide();
    $('#finishingFieldset').hide();
    $('#finishingFieldset').show();
    $('input[name="sign_off_finishing"]').val(userName);
    $('#process_order_number_finishing').val(processOrder);
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // Add other headers if needed
    };

    var formData = {
        process_order_number: processOrder
        // Add other form data if needed
    };

    // Fetch Finishing Form Data for the given process order
    $.ajax({
        url: '/getFinishingDataByProcessOrder', // Adjust URL as needed
        type: 'POST',
        headers: headers,
        data: formData,
        dataType: 'json',
        success: function(response) {
            resetFinishingForm();

            console.log(userName);
            $('input[name="sign_off_finishing"]').val(userName);
            if (response.data != null) {
                console.log('Finishing data found');
                console.log(response);
                $('#process_order_number_finishing').val(processOrder);

                // Set checkbox states
                $('input[name="pickle_passivate_test"]').prop('checked', response.data.pickle_passivate_test === "1");
                $('input[name="select_kent_finish_test"]').prop('checked', response.data.select_kent_finish_test === "1");

                // Set other fields
                $('input[name="sign_off_finishing"]').val(userName);
                $('textarea[name="comments_finishing"]').val(response.data.comments_finishing);

                // Set file input field
                if (response.data.pickle_passivate_document_file !== null) {
                    $('#old_pickle_passivate_documents').text(response.data.pickle_passivate_document_file);
                }
                if (response.data.select_kent_finish_document_file !== null) {
                    $('#old_select_kent_finish_documents').text(response.data.select_kent_finish_document_file);
                }

                // Attach handler for file input change
                $('input[name="pickle_passivate_documents"]').change(function() {
                    $('#old_pickle_passivate_documents').text(this.files[0].name);
                });
                $('input[name="select_kent_finish_documents"]').change(function() {
                    $('#old_select_kent_finish_documents').text(this.files[0].name);
                });
            } else {
                resetFinishingForm();
                $('#process_order_number_finishing').val(processOrder);
                $('input[name="sign_off_finishing"]').val(userName);
                $('#finishingFieldset').show();
            }
        },
        error: function(error) {
            console.error(error);
        }
    });
}
