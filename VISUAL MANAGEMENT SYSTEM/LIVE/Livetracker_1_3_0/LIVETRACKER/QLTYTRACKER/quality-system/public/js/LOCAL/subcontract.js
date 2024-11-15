function generateSubContractFieldset(processOrder, qualityStep, username) {
    $("#sign_off_sub_contract").val(username);
    
}
function submitSubContractForm(processOrder) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };
    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }
    var formData = new FormData();
    formData.set('sub_contract_action', document.querySelector('[name="sub_contract_action"]').value);
    //formData.set('sub_contract_file', getFileName('sub_contract_file'));
    formData.set('sub_contract_file', (document.querySelector('[name="sub_contract_file"]').files.length > 0)
    ? document.querySelector('[name="sub_contract_file"]').files[0].name
    : document.getElementById('old_sub_contract_file').textContent.trim());
    formData.set('sign_off_sub_contract', document.querySelector('[name="sign_off_sub_contract"]').value);
    formData.set('comments_sub_contract', document.querySelector('[name="comments_sub_contract"]').value);
    formData.set('submission_date', new Date().toISOString().split("T")[0]); // Get today's date in YYYY-MM-DD format
    formData.set('process_order_number', document.querySelector('[name="process_order_number_subcontract"]').value);
    //formData.append('testing_document_file_name', getFileName('testing_documents'));




    var owners_sub = [];
    document.querySelectorAll('#subcontract tbody tr').forEach(function (row, index) {
        console.log('yes');
        if (index >= 0 && index <=1) { // Skip the header row
            var owner = row.querySelector('[name="owner_sub"]').value || null;
            var ndt = row.querySelector('[name="ndttype_sub"]').value || null;
           var type= 'SUB CON ACTION:'+index;
            console.log(owner);
             console.log(ndt);
            // Push the owner data to the array
            owners_sub.push({
                type: 'SUB CON ACTION:'+index,
                owner: owner,
                ndt: ndt
            });
    
            // Append each owner and NDT as separate entries
            formData.append('owners_sub[' + (index - 1) + '][type]', type);
            formData.append('owners_sub[' + (index - 1) + '][owner]', owner);
            formData.append('owners_sub[' + (index - 1) + '][ndt]', ndt);
        }
    });

    // Send an AJAX request to the server
    $.ajax({
        url: "/submitSubContractForm",
        type: "POST",
        data: formData,
        headers: headers,
        processData: false, // Prevent jQuery from automatically processing the data
        contentType: false, // Prevent jQuery from setting content type
        success: function (response) {
            console.log(response);
            alert("Sub-Contract form submitted successfully");
            // Optionally update the table or perform other actions
            $(myModal).hide();
        },
        error: function (error) {
            console.error("Error:", error);
            alert("Error submitting Sub-Contract form");
        },
    });
    var fileData = new FormData();
    var fileInputs = $('[type="file"]');

    // Add process_order_number to FormData
    fileData.append('process_order_number', document.querySelector('[name="process_order_number_subcontract"]').value);

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
        url: '/handleFileUploadSubContract',  // Update to your actual route
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
function generateSubContractFieldTable(processOrder, qualityStep) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: processOrder,
    };

    $.ajax({
        url: "/getSubContractDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML = generateHTMLFromResponse_for_sub_contract(response);

            $("#subcontractFieldTable").html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        },
    });

    return `
        <div>To be Done</div>
    `;
}
function generateHTMLFromResponse_for_sub_contract_old(response) {
    var html = '<table id="sub_contract_table" style="width:100%;">';
    html += '<thead><tr>';
    html += '<th style="width:5%;">Sub-Contract ID</th>';
    html += '<th style="width:20%;">Process Order</th>';
    html += '<th style="width:20%;">Sub-Contract Action</th>';
    html += '<th style="width:20%;">Sub-Contract File</th>';
    html += '<th style="width:20%;">Sign-off for Sub-Contract</th>';
    html += '<th style="width:20%;">Comments for Sub-Contract</th>';
    html += '<th style="width:20%;">Submission Date</th>';

    html += '<th style="width:5%;">Created At</th>';
    html += '<th style="width:5%;">Updated At</th>';
    html += '</tr></thead><tbody>';

    $.each(response, function (index, item) {
        html += "<tr>";
        html += "<td>" + item.id + "</td>";
        html += "<td>" + item.process_order_number + "</td>";
        html += "<td>" + item.sub_contract_action + "</td>";
        html += '<td style="text-align:center;">';

        if (item.sub_contract_file) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/subcontract_task/' + item.process_order_number + '/' + item.sub_contract_file;
            var downloadLink = '<a href="' + filePath + '" target="_blank">Download File</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</td>';
        html += "<td>" + item.sign_off_sub_contract + "</td>";
        html += "<td>" + item.comments_sub_contract + "</td>";
        html += "<td>" + item.submission_date + "</td>";

        html += "<td>" + item.created_at + "</td>";
        html += "<td>" + item.updated_at + "</td>";
        html += "</tr>";
    });

    html += "</tbody></table>";

    return html;
}
function generateHTMLFromResponse_for_sub_contract_old(response) {
    var html = '<form id="subContractForm" class="sub-contract-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Sub-Contract</legend>';
    html+='<div style="width:97%">';
    $.each(response, function (index, item) {
        html += '<div class="sub-contract-item">';
        
       // html += '<label for="sub_contract_id">Sub-Contract ID:</label>';
       // html += '<input type="text" id="sub_contract_id" name="sub_contract_id" value="' + item.id + '" readonly>';
        html += '<br>';
        
        html += '<div class="sub-contract-field">';
        html += '<label for="process_order_number">Process Order:</label>';
        html += '<input style="width:100%"type="text" id="process_order_number" name="process_order_number" value="' + item.process_order_number + '">';
        html += '</div><br>';
        
        html += '<div class="sub-contract-field">';
        html += '<label for="sub_contract_action">Sub-Contract Inspection Reponsibility:</label>';
        html += '<input style="width:100%"type="text" id="sub_contract_action" name="sub_contract_action" value="' + item.sub_contract_action + '">';
        html += '</div><br>';
        
        html += '<div class="sub-contract-field">';
        html += '<label for="sub_contract_file">Sub-Contract File:</label>';
        if (item.sub_contract_file) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/subcontract_task/' + item.process_order_number + '/' + item.sub_contract_file;
            var downloadLink = '<a href="' + filePath + '" target="_blank">Download File</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</div><br>';
        
        html += '<div class="sub-contract-field">';
        html += '<label for="sign_off_sub_contract">Sign-off for Sub-Contract:</label>';
        html += '<input style="width:100%"type="text" id="sign_off_sub_contract" name="sign_off_sub_contract" value="' + item.sign_off_sub_contract + '">';
        html += '</div><br>';
        
        html += '<div class="sub-contract-field">';
        html += '<label for="comments_sub_contract">Comments for Sub-Contract:</label>';
        html += '<input style="width:100%"type="text" id="comments_sub_contract" name="comments_sub_contract" value="' + item.comments_sub_contract + '">';
        html += '</div><br>';
        
        html += '<div class="sub-contract-field">';
        html += '<label for="submission_date">Submission Date:</label>';
        html += '<input style="width:100%"type="text" id="submission_date" name="submission_date" value="' + item.submission_date + '">';
        html += '</div><br>';
        
        html += '<div class="sub-contract-field">';
        html += '<label for="created_at">Created At:</label>';
        html += '<input style="width:100%"type="text" id="created_at" name="created_at" value="' + item.created_at + '">';
        html += '</div><br>';
        
        html += '<div class="sub-contract-field">';
        html += '<label for="updated_at">Updated At:</label>';
        html += '<input style="width:100%"type="text" id="updated_at" name="updated_at" value="' + item.updated_at + '">';
        html += '</div><br>';
        
        html += '</div>'; // Closing div for sub-contract-item
        html += '<hr>'; // Horizontal line for separation
    });

   // html += '<input type="button" value="Submit" onclick="submitSubContractForm()">';
    html += '</fieldset></form>';

    return html;
}
function generateHTMLFromResponse_for_sub_contract(response) {
    var html = '<form id="subContractForm" class="sub-contract-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Sub-Contract</legend>';

    // Start table
    html += '<table style="width: 100%; border-collapse: collapse;">';

   
    // Iterate over each item in the response
    $.each(response, function (index, item) {
        // Process Order
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;"><label for="process_order_number">Process Order:</label></td>';
        html += '<td  colspan="4" style="border: 1px solid #ccc;"><input style="width:100%" type="text" id="process_order_number" name="process_order_number" value="' + item.process_order_number + '"></td>';
       // Table headers
    html += '<tr style="border: 1px solid #ccc;">';
    html += '<th style="border: 1px solid #ccc;">Field</th>';
    html += '<th style="border: 1px solid #ccc;">Value</th>';
    html += '<th style="border: 1px solid #ccc;">Owner</th>';
    html += '<th style="border: 1px solid #ccc;">Action</th>';
    html += '</tr>';

        // Fetch owner data here if needed
       /*  fetchOwnerData_SubContract(item.process_order_number, '',function (ownerData) {
            document.getElementById('owner_sub1').innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_sub1').innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        }); */
        html += '</tr>';

        // Sub-Contract Inspection Responsibility
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;"><label for="sub_contract_action">Sub-Contract Inspection Responsibility:</label></td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width:100%" type="text" id="sub_contract_action" name="sub_contract_action" value="' + item.sub_contract_action + '"></td>';
        html += '<td id="owner_sub2" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_sub2" style="border: 1px solid #ccc;"></td>';
        // Fetch owner data here if needed
         fetchOwnerData_SubContract(item.process_order_number, 'SUB CON ACTION:',function (ownerData) {
            document.getElementById('owner_sub2').innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_sub2').innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        }); 
        html += '</tr>';

        // Sub-Contract File
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;"><label for="sub_contract_file">Sub-Contract File:</label></td>';
        html += '<td colspan="4" style="border: 1px solid #ccc;">';
        if (item.sub_contract_file) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/subcontract_task/' + item.process_order_number + '/' + item.sub_contract_file;
            var downloadLink = '<a href="' + filePath + '" target="_blank">Download File</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</td>';
      //  html += '<td colspan="4" style="border: 1px solid #ccc;"></td>'; // Placeholder for Owner and NDT
        html += '</tr>';

        // Sign-off for Sub-Contract
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;"><label for="sign_off_sub_contract">Sign-off for Sub-Contract:</label></td>';
        html += '<td colspan="4"style="border: 1px solid #ccc;"><input style="width:100%" type="text" id="sign_off_sub_contract" name="sign_off_sub_contract" value="' + item.sign_off_sub_contract + '"></td>';
        // Placeholder for Owner and NDT
        html += '</tr>';

        // Comments for Sub-Contract
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;"><label for="comments_sub_contract">Comments for Sub-Contract:</label></td>';
        html += '<td colspan="4" style="border: 1px solid #ccc;"><input style="width:100%" type="text" id="comments_sub_contract" name="comments_sub_contract" value="' + item.comments_sub_contract + '"></td>';
      
        html += '</tr>';

    });

    // Close table
    html += '</table>';
    html += '</fieldset></form>';

    return html;
}




function fetchOwnerData_SubContract(id,Type,callback)
{

    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Replace with the actual CSRF token
        // Include other headers if needed
    };
    var formData = {
        process_order_number: id,
       Type:Type
    };
    
$.ajax({
    url: '/getOwnerData_subcontract',
    type: 'POST',
    data: formData,
    headers: headers,
    dataType: 'json',
    success: function (response) {

        console.log(response);
        
        callback(response.data[0]);
       
    },
    error: function (error) {
        // Handle the error response if needed
        console.error(error);
    }
});
}

function generateSubContractCompleteFieldset(processOrder, qualityStep, username) {
    var formData = {
        process_order_number: processOrder,
    };
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    $("#sign_off_sub_contract").val(username);

    $.ajax({
        url: "/getSubContractDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);

            if (response.data !== null) {
                var generatedHTML = generateCompleteHTMLFromResponse_for_sub_contract(response.data);
                $("#subcontractCompleteFieldTable").html(generatedHTML);
            } else {
                $("#subcontractCompleteFieldTable").html('');
            }
        },
        error: function (error) {
            console.error(error);
        },
    });
}
function generateCompleteHTMLFromResponse_for_sub_contract(item) {
    var html = '<fieldset><legend>Complete Sub-Contract</legend>';
    html+='<div style="width:97%">';
    html += '<form id="complete_sub_contract_form">';
    
    html += '<div class="sub_contract_item">';
   // html += '<label>ID: ' + item.id + '</label><br>';
    html += '<div class="sub_contract_item">';
    html += '<label>Process Order: ' + item.process_order_number + '</label><br>';
    html += '<div class="sub_contract_item">';
    html += '<input type="hidden" name="process_order_number" value="' + item.process_order_number + '"><br>';
   
    html += '<div class="sub_contract_field">';
    html +=
        '<label>Sub-Contract Inspection Responsibilty:</label>' +
        '<input style="width:100%"type="text" name="sub_contract_action_c" value="' + item.sub_contract_action + '" >';
    html += '</div><br>';

    html += '<div class="sub_contract_field">';
    html +=
        '<label>Sign-off for Sub-Contract:</label>' +
        '<input style="width:100%"type="text" name="sign_off_sub_contract_c" value="' + userName + '" >';
    html += '</div><br>';

    html += '<div class="sub_contract_field">';
    html +=
        '<label>Comments for Sub-Contract:</label>' +
        '<textarea style="width:100%"name="comments_sub_contract">' + item.comments_sub_contract + '</textarea>';
    html += '</div><br>';

    html += '<div class="sub_contract_field">';
    html +=
        '<label>Submission Date:</label>' +
        '<input style="width:100%"type="text" name="submission_date" value="' + item.submission_date + '" disabled>';
    html += '</div><br>';

//SC 

html += '<div class="sub_contract_field">';
html +=
    '<label>Status:</label>' +
    '<select style="width:100%"name="status_c">' +
    '<option value="partially_completed">Partially Completed</option>' +
    '<option value="completed">Completed</option>' +
    '</select>' +
    '</div><br>';

    // Quantity Field
    html += '<div class="sub_contract_field">';
    html +=
        '<label>Quantity:</label>' +
        '<input style="width:100%"type="number" name="quantity_c" value="' + item.quantity + '" >';
    html += '</div><br>';

    html += '</div>'; // Closing div for sub_contract_item
    html += '<hr>'; // Horizontal line for separation

    html += '<input type="button" value="Submit" onclick="submitCompleteSubContractForm()">';
    html += '  <input type="button" value="View" onclick="viewCompleteSubContractForm()">';
    html += '</form>';

    html += '<div id="complete_sub_contract_results"></div>';
    html+='</div>';
    html += '</fieldset>';

    return html;
}

function submitCompleteSubContractForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        sign_off_sub_contract: 0, // Change this according to your needs
        comments_sub_contract: document.querySelector('[name="comments_sub_contract"]').value,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number: document.querySelector('[name="process_order_number"]').value, // Change this according to your needs
        sub_contract_action: document.querySelector('[name="sub_contract_action_c"]').value,
        sign_off_sub_contract: document.querySelector('[name="sign_off_sub_contract_c"]').value,
        quantity: document.querySelector('[name="quantity_c"]').value,
        status: document.querySelector('[name="status_c"]').value,
        // Add other form fields accordingly
    };

    console.log(formData);
    $.ajax({
        type: "POST",
        url: "/submitSubContractCompleteForm",
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
function viewCompleteSubContractForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: document.querySelector('[name="process_order_number"]').value,
    };
    $.ajax({
        type: "POST",
        url: "/viewSubContractCompleteForm",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            displayCompleteSubContractResults(response);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}
function displayCompleteSubContractResults(values) {
    var resultsHtml = '<table id="complete_sub_contract_results_table" style="width:100%; border: 1px solid #ddd; text-align: left;">';
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
                    resultsHtml += '<tr><td style="padding: 8px; border-bottom: 1px solid #ddd;">' + field + '</td><td style="padding: 8px; border-bottom: 1px solid #ddd;">' + value + '</td></tr>';
                }
            }
        }
    }

    buildTableRows(values);

    resultsHtml += '</tbody></table>';

    document.getElementById('complete_sub_contract_results').innerHTML = resultsHtml;
}

function resetsubcontract() {
    // Clear the process order number
    $('#process_order_number_subcontract').val('');

    // Reset the sub-contract action dropdown
    $('select[name="sub_contract_action"]').val('NULL');

    // Reset file input values and filenames
    $('input[name="sub_contract_file"]').val('');
    $('#old_sub_contract_file').text('Old File Name');

    // Clear the sign-off for sub-contract
    $('input[name="sign_off_sub_contract"]').val('');

    // Clear the comments for sub-contract
    $('textarea[name="comments_sub_contract"]').val('');
    $('select[name="owner_sub"]').val('NULL');
    $('select[name="ndttype_sub"]').val('NULL');


}

function Subcontract(processOrder, userName) {
    console.log('Sub-Contract');
    console.log(processOrder);

    // Hide other fieldsets
    $("#planningFieldset").hide();
    $("#qualityFieldset").hide();
    $("#manufacturingFieldset").hide();
    $("#engineeringFieldset").hide();
    $("#kittingFieldset").hide();
    $("#fabricationfitupFieldset").hide();
    $("#finishingFieldset").hide();

    // Show Sub-Contract fieldset
    $("#subcontractFieldset").show();

    // Set username and process order
    $('input[name="sign_off_sub_contract"]').val(userName);
    $('#process_order_number_subcontract').val(processOrder);

    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // Add other headers if needed
    };

    var formData = {
        process_order_number: processOrder
        // Add other form data if needed
    };

    // Fetch Sub-Contract Form Data for the given process order
    $.ajax({
        url: '/getSubContractDataByProcessOrder', // Adjust URL as needed
        type: 'POST',
        headers: headers,
        data: formData,
        dataType: 'json',
        success: function(response) {
            resetsubcontract();

            console.log(userName);
            $('input[name="sign_off_sub_contract"]').val(userName);
            if (response.data != null) {
                console.log('Sub-Contract data found');
                console.log(response);
                $('#process_order_number_subcontract').val(processOrder);

                // Set sub-contract action dropdown value
                $('select[name="sub_contract_action"]').val(response.data.sub_contract_action);

                fetchOwnerData_SubContract(processOrder, 'SUB CON ACTION:0', function (ownerData) {
                    if (ownerData) {
                        // Update owner cell
                        $(`select[name="owner_sub"][data-task="sub_contract_action"]`).val(ownerData.owner.trim());
                        // Update NDT cell
                        $(`select[name="ndttype_sub"][data-task="sub_contract_action"]`).val(ownerData.ndta.trim());
                    } else {
                        // Handle case where no owner data is retrieved
                        $(`select[name="owner_sub"][data-task="sub_contract_action"]`).val('NULL');
                        $(`select[name="ndttype_sub"][data-task="sub_contract_action"]`).val('NULL');
                    }
                });





                // Set file input field
                if (response.data.sub_contract_file !== null) {
                    $('#old_sub_contract_file').text(response.data.sub_contract_file);
                }

                // Attach handler for file input change
                $('input[name="sub_contract_file"]').change(function() {
                    $('#old_sub_contract_file').text(this.files[0].name);
                });

                // Set other fields
                $('input[name="sign_off_sub_contract"]').val(userName);
                $('textarea[name="comments_sub_contract"]').val(response.data.comments_sub_contract);
            } else {
                resetsubcontract();
                $('#process_order_number_subcontract').val(processOrder);
                $('input[name="sign_off_sub_contract"]').val(userName);
                $('#subcontractFieldset').show();
            }
        },
        error: function(error) {
            console.error(error);
        }
    });
}

