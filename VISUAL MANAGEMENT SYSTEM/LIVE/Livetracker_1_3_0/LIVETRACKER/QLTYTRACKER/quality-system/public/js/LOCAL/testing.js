function generateTestingFieldset(processOrder, qualityStep, username) {
    $("#sign_off_testing").val(username);
   
}

function toggleDropdown(checkbox, dropdownName) {
    var dropdown = checkbox.parentElement.querySelector(`select[name="${dropdownName}"]`);
    dropdown.disabled = !checkbox.checked;
}


function submitTestingForm(processOrder) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };
    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');

        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }
    var formData = new FormData();
    formData.set('dye_pen_document_ref', document.querySelector('[name="dyependocumentref"]').value || null);
    formData.set('hydrostatic_test_document_ref', document.querySelector('[name="hydrostatictestdocumentref"]').value || null);
    formData.set('pneumatic_test_document_ref', document.querySelector('[name="pneumatictestdocumentref"]').value || null);
    formData.set('fat_protocol_document_ref', document.querySelector('[name="fatprotocoldocumentref"]').value || null);
    formData.set('sign_off_testing', document.querySelector('[name="sign_off_testing"]').value);
    formData.set('comments_testing', document.querySelector('[name="comments_testing"]').value);
    formData.set('submission_date', new Date().toISOString().split("T")[0]); // Get today's date in YYYY-MM-DD format
    formData.set('process_order_number', document.querySelector('[name="process_order_number_testing"]').value);
    
    // Checkbox values
    formData.set('dye_pen_test', document.querySelector('[name="dye_pen_test"]').checked ? 1 : 0);
    formData.set('hydrostatic_test', document.querySelector('[name="hydrostatic_test"]').checked ? 1 : 0);
    formData.set('pneumatic_test', document.querySelector('[name="pneumatic_test"]').checked ? 1 : 0);
    formData.set('fat_protocol', document.querySelector('[name="fat_protocol"]').checked ? 1 : 0);

    var testingDocumentFileName = (document.querySelector('[name="testing_documents"]').files.length > 0)
    ? document.querySelector('[name="testing_documents"]').files[0].name
    : document.getElementById('old_testing_documents').textContent.trim();

formData.set('testing_document_file_name', testingDocumentFileName);
var owners_test = [];
document.querySelectorAll('#testing tbody tr').forEach(function (row, index) {
    console.log('yes');
    console.log(index);
    if (index >= 0 && index<4) { // Skip the header row
        var owner = row.querySelector('[name="owner_test"]').value || null;
        var ndt = row.querySelector('[name="ndttype_test"]').value || null;
console.log(owner);
console.log(ndt);
        // Push the owner data to the array
        owners_test.push({
            type: row.cells[0].innerText.trim(),
            owner: owner,
            ndt: ndt
        });

        // Append each owner and NDT as separate entries
        formData.append('owners_test[' + (index - 1) + '][type]', row.cells[0].innerText.trim());
        formData.append('owners_test[' + (index - 1) + '][owner]', owner);
        formData.append('owners_test[' + (index - 1) + '][ndt]', ndt);
    }
});
    
    console.log(formData);
    // Send an AJAX request to the server
    $.ajax({
        url: "/submitTestingForm",
        type: "POST",
        data: formData,
        headers: headers,
        processData: false, // Prevent jQuery from automatically processing the data
        contentType: false, // Prevent jQuery from setting content type
        success: function (response) {
            console.log(response);
            alert("Testing form submitted successfully");
            // Optionally update the table or perform other actions
            $(myModal).hide();
        },
        error: function (error) {
            console.error("Error:", error);
            alert("Error submitting Testing form");
        },
    });

    var fileData = new FormData();
    var fileInputs = $('[type="file"]');

    // Add process_order_number to FormData
    fileData.append('process_order_number', document.querySelector('[name="process_order_number_testing"]').value);

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
        url: '/handleFileUploadTesting',  // Update to your actual route
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


function generateTestingFieldTable(processOrder, qualityStep) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: processOrder,
    };

    $.ajax({
        url: "/getTestingDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML =
                generateHTMLFromResponse_for_testing(response);

            $("#testingFieldTable").html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        },
    });

    return `
            <div>To be Done</div>
        `;
}

function generateHTMLFromResponse_for_testing_old(response) {
    var html = '<table id="common_table" style="width:100%;">';
    html += '<thead><tr>';
    html += '<th style="width:5%;">Testing ID</th>';
    html += '<th style="width:20%;">Process Order</th>';
    html += '<th style="width:20%;">Dye Penetrant Procedure Ref</th>';
    html += '<th style="width:20%;">Hydrostatic Leak Test Ref</th>';
    html += '<th style="width:20%;">Pneumatic Leak Test Ref</th>';
    html += '<th style="width:20%;">FAT Ref</th>';
    html += '<th style="width:20%;">Dye Penetrant Test</th>';
    html += '<th style="width:20%;">Hydrostatic Leak Test</th>';
    html += '<th style="width:20%;">Pneumatic Leak Test</th>';
    html += '<th style="width:20%;">FAT Test</th>';
    html += '<th style="width:10%;">Sign-off for Testing</th>';
    html += '<th style="width:10%;">Testing Files</th>';
    html += '<th style="width:20%;">Comments for Testing</th>';
    html += '<th style="width:20%;">Submitted Date Time</th>';
    html += '<th style="width:5%;">Created At</th>';
    html += '<th style="width:5%;">Updated At</th>';
    html += '</tr></thead><tbody>';

    $.each(response, function (index, item) {
        html += "<tr>";
        html += "<td>" + item.id + "</td>";
        html += "<td>" + item.process_order_number + "</td>";
        html += "<td>" + item.dye_pen_document_ref + "</td>";
        html += "<td>" + item.hydrostatic_test_document_ref + "</td>";
        html += "<td>" + item.pneumatic_test_document_ref + "</td>";
        html += "<td>" + item.fat_protocol_document_ref + "</td>";
        html += "<td>" + (item.dye_pen_test === "1" ? "✔" : "") + "</td>";
        html += "<td>" + (item.hydrostatic_test === "1" ? "✔" : "") + "</td>";
        html += "<td>" + (item.pneumatic_test === "1" ? "✔" : "") + "</td>";
        html += "<td>" + (item.fat_protocol === "1" ? "✔" : "") + "</td>";
        html += '<td style="text-align:center;">' + (item.sign_off_testing === "1" ? "✔" : "") + "</td>";
        html += '<td style="text-align:center;">';

        if (item.testing_document_file_name) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/testing_task/' + item.process_order_number + '/' + item.testing_document_file_name;
            var downloadLink = '<a href="' + filePath + '" target="_blank">Download File</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</td>';

        html += "<td>" + item.comments_testing + "</td>";
        html += "<td>" + item.submission_date + "</td>";
        html += "<td>" + item.created_at + "</td>";
        html += "<td>" + item.updated_at + "</td>";
        html += "</tr>";
    });

    html += "</tbody></table>";

    return html;
}
function generateHTMLFromResponse_for_testing_old(response) {
    var html = '<form id="testingForm" class="testing-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Testing</legend>';
    html+='<div style="width:97%">';
    $.each(response, function (index, item) {
        html += '<div class="testing-item">';
        
       // html += '<label for="testing_id">Testing ID:</label>';
        //html += '<input type="text" id="testing_id" name="testing_id" value="' + item.id + '" readonly>';
        html += '<br>';
        
        html += '<div class="testing-field">';
        html += '<label for="process_order_number">Process Order:</label>';
        html += '<input style="width:100%"type="text" id="process_order_number" name="process_order_number" value="' + item.process_order_number + '"disabled>';
        html += '</div><br>';
        
        html += '<div class="testing-field">';
        html += '<label for="dye_pen_document_ref">Dye Penetrant Procedure Ref:</label>';
        html += '<input style="width:100%"type="text" id="dye_pen_document_ref" name="dye_pen_document_ref" value="' + item.dye_pen_document_ref + '"disabled>';
        html += '</div><br>';
        
        html += '<div class="testing-field">';
        html += '<label for="hydrostatic_test_document_ref">Hydrostatic Leak Test Ref:</label>';
        html += '<input style="width:100%"type="text" id="hydrostatic_test_document_ref" name="hydrostatic_test_document_ref" value="' + item.hydrostatic_test_document_ref + '"disabled>';
        html += '</div><br>';
        
        html += '<div class="testing-field">';
        html += '<label for="pneumatic_test_document_ref">Pneumatic Leak Test Ref:</label>';
        html += '<input style="width:100%"type="text" id="pneumatic_test_document_ref" name="pneumatic_test_document_ref" value="' + item.pneumatic_test_document_ref + '"disabled>';
        html += '</div><br>';
        
        html += '<div class="testing-field">';
        html += '<label for="fat_protocol_document_ref">FAT Ref:</label>';
        html += '<input style="width:100%"type="text" id="fat_protocol_document_ref" name="fat_protocol_document_ref" value="' + item.fat_protocol_document_ref + '"disabled>';
        html += '</div><br>';
        
        html += '<div class="testing-field">';
        html += '<label for="dye_pen_test">Dye Penetrant Test:</label>';
        html += '<input type="checkbox" id="dye_pen_test" name="dye_pen_test" ' + (item.dye_pen_test === "1" ? 'checked' : 'disabled') + '>';
        html += '</div><br>';
        
        html += '<div class="testing-field">';
        html += '<label for="hydrostatic_test">Hydrostatic Leak Test:</label>';
        html += '<input type="checkbox" id="hydrostatic_test" name="hydrostatic_test" ' + (item.hydrostatic_test === "1" ? 'checked' : 'disabled') + '>';
        html += '</div><br>';
        
        html += '<div class="testing-field">';
        html += '<label for="pneumatic_test">Pneumatic Leak Test:</label>';
        html += '<input type="checkbox" id="pneumatic_test" name="pneumatic_test" ' + (item.pneumatic_test === "1" ? 'checked'  : 'disabled') + '>';
        html += '</div><br>';
        
        html += '<div class="testing-field">';
        html += '<label for="fat_protocol">FAT Test:</label>';
        html += '<input type="checkbox" id="fat_protocol" name="fat_protocol" ' + (item.fat_protocol === "1" ? 'checked' : 'disabled') + '>';
        html += '</div><br>';
        
        html += '<div class="testing-field">';
        html += '<label for="sign_off_testing">Sign-off for Testing:</label>';
        html += '<input style="width:100%"type="text" id="sign_off_testing" name="sign_off_testing" value="' + item.sign_off_testing + '">';
        html += '</div><br>';
        
        html += '<div class="testing-field">';
        html += '<label for="testing_document_file_name">Testing Files:</label>';
        if (item.testing_document_file_name) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/testing_task/' + item.process_order_number + '/' + item.testing_document_file_name;
            var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.testing_document_file_name+'</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</div><br>';
        
        html += '<div class="testing-field">';
        html += '<label for="comments_testing">Comments for Testing:</label>';
        html += '<input style="width:100%"type="text" id="comments_testing" name="comments_testing" value="' + item.comments_testing + '">';
        html += '</div><br>';
        
        html += '<div class="testing-field">';
        html += '<label for="submission_date">Submitted Date Time:</label>';
        html += '<input style="width:100%"type="text" id="submission_date" name="submission_date" value="' + item.submission_date + '">';
        html += '</div><br>';
        
        html += '<div class="testing-field">';
        html += '<label for="created_at">Created At:</label>';
        html += '<input style="width:100%"type="text" id="created_at" name="created_at" value="' + item.created_at + '">';
        html += '</div><br>';
        
        html += '<div class="testing-field">';
        html += '<label for="updated_at">Updated At:</label>';
        html += '<input style="width:100%"type="text" id="updated_at" name="updated_at" value="' + item.updated_at + '">';
        html += '</div><br>';
        
        html += '</div>'; // Closing div for testing-item
        html += '<hr>'; // Horizontal line for separation
    });

    html+='</div>';
    html += '</fieldset></form>';

    return html;
}
function generateHTMLFromResponse_for_testing_oldd(response) {
    var html = '<form id="testingForm" class="testing-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Testing</legend>';

    // Start table
    html += '<table style="width: 100%; border-collapse: collapse;">';
    
    // Table headers
    html += '<tr style="border: 1px solid #ccc;">';
    html += '<th style="border: 1px solid #ccc;">Field</th>';
    html += '<th style="border: 1px solid #ccc;">Value</th>';
    html += '<th style="border: 1px solid #ccc;">Owner</th>';
    html += '<th style="border: 1px solid #ccc;">NDT</th>';
    html += '</tr>';

    $.each(response, function (index, item) {
        // Process Order
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<div class="form-group">';
        html += '<input type="checkbox" id="process_order_' + index + '" name="process_order" ' + (item.dye_pen_test === "1" ? 'checked' : 'disabled') + '>';
        html += '<label for="process_order_' + index + '">Process Order:</label>';
        html += '</div>';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="process_order_number" value="' + item.process_order_number + '" disabled></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_test0"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_test0"></td>';
        
       
        html += '</tr>';

        // Dye Penetrant Procedure Ref
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Dye Penetrant Procedure Ref:</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="dye_pen_document_ref" value="' + item.dye_pen_document_ref + '" disabled></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_test1"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_test1"></td>';


        fetchOwnerData_Testing(item.process_order_number, 'Dye Penetrant Procedure', function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('owner_test0').innerHTML = ownerData.owner.trim();

                // Update ndt cell
                document.getElementById('ndt_test0').innerHTML = ownerData.ndta.trim();
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('owner_test0').innerHTML = 'N/A';
                document.getElementById('ndt_test0').innerHTML = 'N/A';
            }
        });

        html += '</tr>';

        // Hydrostatic Leak Test Ref
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Hydrostatic Leak Test Ref:</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="hydrostatic_test_document_ref" value="' + item.hydrostatic_test_document_ref + '" disabled></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_test2"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_test2"></td>';
        fetchOwnerData_Testing(item.process_order_number, '', function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('owner_test2').innerHTML = ownerData.owner.trim();

                // Update ndt cell
                document.getElementById('ndt_test2').innerHTML = ownerData.ndta.trim();
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('owner_test2').innerHTML = 'N/A';
                document.getElementById('ndt_test2').innerHTML = 'N/A';
            }
        });
        html += '</tr>';

        // Pneumatic Leak Test Ref
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Pneumatic Leak Test Ref:</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="pneumatic_test_document_ref" value="' + item.pneumatic_test_document_ref + '" disabled></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';

        fetchOwnerData_Manufacturing(item.process_order_number, 'Production Drawings', function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('owner_man1').innerHTML = ownerData.owner.trim();

                // Update ndt cell
                document.getElementById('ndt_man1').innerHTML = ownerData.ndta.trim();
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('owner_man1').innerHTML = 'N/A';
                document.getElementById('ndt_man1').innerHTML = 'N/A';
            }
        });
        html += '</tr>';

        // FAT Ref
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">FAT Ref:</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="fat_protocol_document_ref" value="' + item.fat_protocol_document_ref + '" disabled></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';

        fetchOwnerData_Manufacturing(item.process_order_number, 'Production Drawings', function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('owner_man1').innerHTML = ownerData.owner.trim();

                // Update ndt cell
                document.getElementById('ndt_man1').innerHTML = ownerData.ndta.trim();
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('owner_man1').innerHTML = 'N/A';
                document.getElementById('ndt_man1').innerHTML = 'N/A';
            }
        });
        html += '</tr>';

        // Checkbox Fields
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Dye Penetrant Test:</td>';
        html += '<td style="border: 1px solid #ccc;"><input type="checkbox" name="dye_pen_test" ' + (item.dye_pen_test === "1" ? 'checked' : 'disabled') + '></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Hydrostatic Leak Test:</td>';
        html += '<td style="border: 1px solid #ccc;"><input type="checkbox" name="hydrostatic_test" ' + (item.hydrostatic_test === "1" ? 'checked' : 'disabled') + '></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Pneumatic Leak Test:</td>';
        html += '<td style="border: 1px solid #ccc;"><input type="checkbox" name="pneumatic_test" ' + (item.pneumatic_test === "1" ? 'checked' : 'disabled') + '></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">FAT Test:</td>';
        html += '<td style="border: 1px solid #ccc;"><input type="checkbox" name="fat_protocol" ' + (item.fat_protocol === "1" ? 'checked' : 'disabled') + '></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        // Sign-off Testing
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Sign-off for Testing:</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="sign_off_testing" value="' + item.sign_off_testing + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        // Testing Files
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Testing Files:</td>';
        html += '<td style="border: 1px solid #ccc;">';
        if (item.testing_document_file_name) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/testing_task/' + item.process_order_number + '/' + item.testing_document_file_name;
            var downloadLink = '<a href="' + filePath + '" target="_blank">' + item.testing_document_file_name + '</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        // Comments
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Comments for Testing:</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="comments_testing" value="' + item.comments_testing + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        // Submitted Date Time
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Submitted Date Time:</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="submission_date" value="' + item.submission_date + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        // Created At
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Created At:</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="created_at" value="' + item.created_at + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        // Updated At
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Updated At:</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="updated_at" value="' + item.updated_at + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        html += '<tr><td colspan="4"><hr></td></tr>'; // Separator
    });

    // Close table
    html += '</table>';
    html += '</fieldset></form>';

    return html;
}

function fetchOwnerData_Testing(id,Type,callback)
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
    url: '/getOwnerData_testing',
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


function generateHTMLFromResponse_for_testing_nnno(response) {
    var html = '<form id="testingForm" class="testing-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Testing</legend>';

    // Start table
    html += '<table style="width: 100%; border-collapse: collapse;">';
    
    // Table headers
    html += '<tr style="border: 1px solid #ccc;">';
    html += '<th style="border: 1px solid #ccc;">Field</th>';
    html += '<th style="border: 1px solid #ccc;">Value</th>';
    html += '<th style="border: 1px solid #ccc;">Owner</th>';
    html += '<th style="border: 1px solid #ccc;">NDT</th>';
    html += '</tr>';

    $.each(response, function (index, item) {
        // Process Order
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Process Order:</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="process_order_number" value="' + item.process_order_number + '" disabled></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        // Document References
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Dye Penetrant Procedure Ref:</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="dye_pen_document_ref" value="' + item.dye_pen_document_ref + '" disabled></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_test1"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_test1"></td>';


        fetchOwnerData_Testing(item.process_order_number, 'Dye Penetrant Procedure', function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('owner_test1').innerHTML = ownerData.owner.trim();

                // Update ndt cell
                document.getElementById('ndt_test1').innerHTML = ownerData.ndta.trim();
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('owner_test1').innerHTML = 'N/A';
                document.getElementById('ndt_test1').innerHTML = 'N/A';
            }
        });
        html += '</tr>';

        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Hydrostatic Leak Test Ref:</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="hydrostatic_test_document_ref" value="' + item.hydrostatic_test_document_ref + '" disabled></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Pneumatic Leak Test Ref:</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="pneumatic_test_document_ref" value="' + item.pneumatic_test_document_ref + '" disabled></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">FAT Ref:</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="fat_protocol_document_ref" value="' + item.fat_protocol_document_ref + '" disabled></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        // Checkbox Fields
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<input type="checkbox" name="dye_pen_test" ' + (item.dye_pen_test === "1" ? 'checked' : 'disabled') + '>';
        html += ' Dye Penetrant Test:';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;"></td>'; // Value column empty for checkboxes
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<input type="checkbox" name="hydrostatic_test" ' + (item.hydrostatic_test === "1" ? 'checked' : 'disabled') + '>';
        html += ' Hydrostatic Leak Test:';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;"></td>'; // Value column empty for checkboxes
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<input type="checkbox" name="pneumatic_test" ' + (item.pneumatic_test === "1" ? 'checked' : 'disabled') + '>';
        html += ' Pneumatic Leak Test:';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;"></td>'; // Value column empty for checkboxes
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<input type="checkbox" name="fat_protocol" ' + (item.fat_protocol === "1" ? 'checked' : 'disabled') + '>';
        html += ' FAT Test:';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;"></td>'; // Value column empty for checkboxes
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        // Sign-off Testing
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Sign-off for Testing:</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="sign_off_testing" value="' + item.sign_off_testing + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        // Testing Files
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Testing Files:</td>';
        html += '<td style="border: 1px solid #ccc;">';
        if (item.testing_document_file_name) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/testing_task/' + item.process_order_number + '/' + item.testing_document_file_name;
            var downloadLink = '<a href="' + filePath + '" target="_blank">' + item.testing_document_file_name + '</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        // Comments
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Comments for Testing:</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="comments_testing" value="' + item.comments_testing + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        // Submitted Date Time
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Submitted Date Time:</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="submission_date" value="' + item.submission_date + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        // Created At
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Created At:</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="created_at" value="' + item.created_at + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        // Updated At
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Updated At:</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="updated_at" value="' + item.updated_at + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_' + index + '"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_' + index + '"></td>';
        html += '</tr>';

        html += '<tr><td colspan="4"><hr></td></tr>'; // Separator
    });

    // Close table
    html += '</table>';
    html += '</fieldset></form>';

    return html;
}
function generateHTMLFromResponse_for_testing(response) {
    var html = '<form id="testingForm" class="testing-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Testing</legend>';

    

    $.each(response, function (index, item) {
        // Process Order
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Process Order:</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="process_order_number" value="' + item.process_order_number + '" disabled></td>';
        
        
        html += '</tr>';
// Start table
html += '<table style="width: 100%; border-collapse: collapse;">';
    
// Table headers
html += '<tr style="border: 1px solid #ccc;">';
html += '<th style="border: 1px solid #ccc;">Field</th>';
html += '<th style="border: 1px solid #ccc;">Value</th>';
html += '<th style="border: 1px solid #ccc;">Owner</th>';
html += '<th style="border: 1px solid #ccc;">Action</th>';
html += '</tr>';
        // Document References
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<input type="checkbox" name="dye_pen_test" ' + (item.dye_pen_test === "1" ? 'checked' : 'disabled') + '>';
        html += ' Dye Penetrant Test:';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="dye_pen_document_ref" value="' + item.dye_pen_document_ref + '" disabled></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_test2"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_test2"></td>';


        fetchOwnerData_Testing(item.process_order_number, 'Dye Penetrant Procedure', function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('owner_test2').innerHTML = ownerData.owner.trim();

                // Update ndt cell
                document.getElementById('ndt_test2').innerHTML = ownerData.ndta.trim();
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('owner_test2').innerHTML = 'N/A';
                document.getElementById('ndt_test2').innerHTML = 'N/A';
            }
        });
        html += '</tr>';

        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<input type="checkbox" name="hydrostatic_test" ' + (item.hydrostatic_test === "1" ? 'checked' : 'disabled') + '>';
        html += ' Hydrostatic Leak Test:';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="hydrostatic_test_document_ref" value="' + item.hydrostatic_test_document_ref + '" disabled></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_test3"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_test3"></td>';
        fetchOwnerData_Testing(item.process_order_number, 'Hydrostatic Leak Test', function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('owner_test3').innerHTML = ownerData.owner.trim();

                // Update ndt cell
                document.getElementById('ndt_test3').innerHTML = ownerData.ndta.trim();
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('owner_test3').innerHTML = 'N/A';
                document.getElementById('ndt_test3').innerHTML = 'N/A';
            }
        });


        html += '</tr>';

        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<input type="checkbox" name="pneumatic_test" ' + (item.pneumatic_test === "1" ? 'checked' : 'disabled') + '>';
        html += ' Pneumatic Leak Test:';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="pneumatic_test_document_ref" value="' + item.pneumatic_test_document_ref + '" disabled></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_test4"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_test4"></td>';

        fetchOwnerData_Testing(item.process_order_number, 'Pneumatic Leak Test', function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('owner_test4').innerHTML = ownerData.owner.trim();

                // Update ndt cell
                document.getElementById('ndt_test4').innerHTML = ownerData.ndta.trim();
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('owner_test4').innerHTML = 'N/A';
                document.getElementById('ndt_test4').innerHTML = 'N/A';
            }
        });
       
        html += '</tr>';

        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<input type="checkbox" name="fat_protocol" ' + (item.fat_protocol === "1" ? 'checked' : 'disabled') + '>';
        html += ' FAT Test:';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="fat_protocol_document_ref" value="' + item.fat_protocol_document_ref + '" disabled></td>';
        html += '<td style="border: 1px solid #ccc;" id="owner_test5"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_test5"></td>';

        fetchOwnerData_Testing(item.process_order_number, 'FAT', function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('owner_test5').innerHTML = ownerData.owner.trim();

                // Update ndt cell
                document.getElementById('ndt_test5').innerHTML = ownerData.ndta.trim();
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('owner_test5').innerHTML = 'N/A';
                document.getElementById('ndt_test5').innerHTML = 'N/A';
            }
        });
        html += '</tr>';

       /*  // Checkbox Fields
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<input type="checkbox" name="dye_pen_test" ' + (item.dye_pen_test === "1" ? 'checked' : 'disabled') + '>';
        html += ' Dye Penetrant Test:';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;"></td>'; // Value column empty for checkboxes
        html += '<td style="border: 1px solid #ccc;" id="owner_6"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_6"></td>';



        html += '</tr>';

        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<input type="checkbox" name="hydrostatic_test" ' + (item.hydrostatic_test === "1" ? 'checked' : 'disabled') + '>';
        html += ' Hydrostatic Leak Test:';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;"></td>'; // Value column empty for checkboxes
        html += '<td style="border: 1px solid #ccc;" id="owner_7"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_7"></td>';


       
        html += '</tr>';

        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<input type="checkbox" name="pneumatic_test" ' + (item.pneumatic_test === "1" ? 'checked' : 'disabled') + '>';
        html += ' Pneumatic Leak Test:';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;"></td>'; // Value column empty for checkboxes
        html += '<td style="border: 1px solid #ccc;" id="owner_8"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_8"></td>';
        html += '</tr>';

        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<input type="checkbox" name="fat_protocol" ' + (item.fat_protocol === "1" ? 'checked' : 'disabled') + '>';
        html += ' FAT Test:';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;"></td>'; // Value column empty for checkboxes
        html += '<td style="border: 1px solid #ccc;" id="owner_9"></td>';
        html += '<td style="border: 1px solid #ccc;" id="ndt_9"></td>';
        html += '</tr>'; */
  // Testing Files
  html += '<tr style="border: 1px solid #ccc;">';
  html += '<td style="border: 1px solid #ccc;">Testing Files:</td>';
  html += '<td colspan="3"style="border: 1px solid #ccc;">';
  if (item.testing_document_file_name) {
      var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/testing_task/' + item.process_order_number + '/' + item.testing_document_file_name;
      var downloadLink = '<a href="' + filePath + '" target="_blank">' + item.testing_document_file_name + '</a>';
      html += downloadLink;
  } else {
      html += '-';
  }
  html += '</td>';
  
  html += '</tr>';

        // Sign-off Testing
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Sign-off for Testing:</td>';
        html += '<td colspan="3"style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="sign_off_testing" value="' + item.sign_off_testing + '"></td>';
       
        html += '</tr>';

      
        // Comments
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Comments for Testing:</td>';
        html += '<td colspan="3"style="border: 1px solid #ccc;"><input style="width: 100%;" type="text" name="comments_testing" value="' + item.comments_testing + '"></td>';
        
        html += '</tr>';

        

        html += '<tr><td colspan="4"><hr></td></tr>'; // Separator
    });

    // Close table
    html += '</table>';
    html += '</fieldset></form>';

    return html;
}



function generateTestingCompleteFieldset(processOrder, qualityStep, username) {
    console.log(processOrder);
    var formData = {
        process_order_number: processOrder,
    };
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    $("#sign_off_testing").val(username);

    $.ajax({
        url: "/getTestingDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);

            if (response.data !== null) {
                var generatedHTML = generateCompleteHTMLFromResponse_for_testing(response.data);
                $("#testingCompleteFieldTable").html(generatedHTML);
            } else {
                $("#testingCompleteFieldTable").html('');
            }
        },
        error: function (error) {
            console.error(error);
        },
    });
}

function generateCompleteHTMLFromResponse_for_testing(item) {
    console.log(item);
    var html = '<fieldset><legend>Testing Complete</legend>';
    html+='<div style="width:97%">';
    html += '<form id="testing_complete_form">';

    html += '<div class="testing_item">';
   // html += '<label>ID: ' + item.id + '</label><br>';
    html += '<div class="testing_item">';
    html += '<label>Process Order: ' + item.process_order_number + '</label><br>';
    html += '<div class="testing_item">';
    html += '<input type="hidden" name="process_order_number_t" value="' + item.process_order_number + '"><br>';

    html += '<div class="testing_field">';
    html +=
        '<label>Dye Penetrant Test:</label>' +
        (item.dye_pen_test === "1" ?
            '<input type="checkbox" id="dye_pen_test_c" name="dye_pen_test_c" >' :
            '<input type="checkbox" id="dye_pen_test_c" name="dye_pen_test_c" disabled>');
    html += '</div><br>';

    html += '<div class="testing_field">';
    html +=
        '<label>Dye Penetrant Document Ref:</label>' +
        '<input style="width:100%"type="text" name="dye_pen_document_ref" value="' + item.dye_pen_document_ref + '" disabled>';
    html += '</div><br>';

    html += '<div class="testing_field">';
    html +=
        '<label>Hydrostatic Leak Test:</label>' +
        (item.hydrostatic_test === "1" ?
            '<input type="checkbox" id="hydrostatic_test_c" name="hydrostatic_test_c" >' :
            '<input type="checkbox" id="hydrostatic_test_c" name="hydrostatic_test_c" disabled>');
    html += '</div><br>';

    html += '<div class="testing_field">';
    html +=
        '<label>Hydrostatic Leak Test Document Ref:</label>' +
        '<input style="width:100%"type="text" name="hydrostatic_test_document_ref" value="' + item.hydrostatic_test_document_ref + '" disabled>';
    html += '</div><br>';

    html += '<div class="testing_field">';
    html +=
        '<label>Pneumatic Leak Test:</label>' +
        (item.pneumatic_test === "1" ?
            '<input type="checkbox" id="pneumatic_test_c" name="pneumatic_test_c" >' :
            '<input type="checkbox" id="pneumatic_test_c" name="pneumatic_test_c" disabled>');
    html += '</div><br>';

    html += '<div class="testing_field">';
    html +=
        '<label>Pneumatic Leak Test Document Ref:</label>' +
        '<input style="width:100%"type="text" name="pneumatic_test_document_ref" value="' + item.pneumatic_test_document_ref + '" disabled>';
    html += '</div><br>';

    html += '<div class="testing_field">';
    html +=
        '<label>FAT Protocol:</label>' +
        (item.fat_protocol === "1" ?
            '<input type="checkbox" id="fat_protocol_c" name="fat_protocol_c" >' :
            '<input type="checkbox" id="fat_protocol_c" name="fat_protocol_c" disabled>');
    html += '</div><br>';

    html += '<div class="testing_field">';
    html +=
        '<label>FAT Protocol Test Document Ref:</label>' +
        '<input style="width:100%"type="text" name="fat_protocol_document_ref" value="' + item.fat_protocol_document_ref + '" disabled>';
    html += '</div><br>';

    html += '<div class="signoff_field">';
    html +=
        '<label>Sign-off for Testing:</label>' +
        '<input style="width:100%"type="text" name="sign_off_testing_c" value="' + userName + '" >';
    html += '</div><br>';



    html += '<div class="testing_field">';
    html +=
        '<label>Status:</label>' +
        '<select style="width:100%" id="status" name="status">' +
        '<option value="Completed" ' + (item.status === "Completed" ? 'selected' : '') + '>Completed</option>' +
        '<option value="Partially Completed" ' + (item.status === "Partially Completed" ? 'selected' : '') + '>Partially Completed</option>' +
        '</select>';
    html += '</div><br>';
   // html += '<input  name="comments_testing" value="' + item.comments_testing + '"><br>';
    // Quantity Field
    html += '<div class="testing_field">';
    html +=
        '<label>Quantity:</label>' +
        '<input style="width:100%"type="number" id="quantity" name="quantity_c" value="' + item.quantity + '" >';
    html += '</div><br>';
    ///html += '<div class="testing_field">';
    //html +=
       //// '<label style="display:none">Quantity:</label>' +
       // '<input style="width:100%"style="display:none"type="number" id="quantity" name="process" value="' + item.process_order_number + '" >';
    //html += '</div><br>';

    html += '</div>'; // Closing div for testing_item
    html += '<hr>'; // Horizontal line for separation

    html += '<input type="button" value="Submit" onclick="submitTestingCompleteForm()">';
    html += '  <input type="button" value="View" onclick="viewTestingCompleteForm()">';
    html += '</form>';

    html += '<div id="testing_complete_results"></div>';
    html+='</div>';
    html += '</fieldset>';

    return html;
}

function submitTestingCompleteForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };
    console.log(document.querySelector('[name="process_order_number_t"]').value);
    var formData = {
        sign_off: document.querySelector('[name="sign_off_testing_c"]').value, // Change this according to your needs
        comments_testing: document.querySelector('[name="comments_testing"]').value,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        //process_order_number: document.querySelector('[name="process_order_number"]').value, // Change this according to your needs
        process_order_number: document.querySelector('[name="process_order_number_t"]').value,
        dye_pen_testing: document.querySelector('[name="dye_pen_test_c"]').checked ? "on" : "",
        dye_pen_document_ref: document.querySelector('[name="dye_pen_document_ref"]').value,
        hydrostatic_testing: document.querySelector('[name="hydrostatic_test_c"]').checked ? "on" : "",
        hydrostatic_test_document_ref: document.querySelector('[name="hydrostatic_test_document_ref"]').value,
        pneumatic_testing: document.querySelector('[name="pneumatic_test_c"]').checked ? "on" : "",
        pneumatic_test_document_ref: document.querySelector('[name="pneumatic_test_document_ref"]').value,
        fat_protocoll: document.querySelector('[name="fat_protocol_c"]').checked ? "on" : "",
        status: document.querySelector('#status').value,
        quantity: document.querySelector('[name="quantity_c"]').value,
        // Add other form fields accordingly
    };
    console.log(document.querySelector('[name="process_order_number_t"]').value);
    console.log(formData);
    $.ajax({
        type: "POST",
        url: "/submitTestingCompleteForm",
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




function viewTestingCompleteForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: document.querySelector('[name="process_order_number_t"]').value,
    };
    $.ajax({
        type: "POST",
        url: "/viewTestingCompleteForm",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            displayTestingCompleteResults(response);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}

function displayTestingCompleteResults(values) {
    var resultsHtml = '<table id="testing_complete_results_table" style="width:100%; border: 1px solid #ddd; text-align: left;">';
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

    document.getElementById('testing_complete_results').innerHTML = resultsHtml;
}
function resetTesting() {
    // Uncheck checkboxes
    $('input[name="dye_pen_test"]').prop("checked", false);
    $('input[name="hydrostatic_test"]').prop("checked", false);
    $('input[name="pneumatic_test"]').prop("checked", false);
    $('input[name="fat_protocol"]').prop("checked", false);

    // Disable dropdowns
    $('select[name="dyependocumentref"]').val("NULL");
    $('select[name="hydrostatictestdocumentref"]').val("NULL");
    $('select[name="pneumatictestdocumentref"]').val("NULL");
    $('select[name="fatprotocoldocumen_ref"]').val("NULL");

    // Reset text inputs
    $('input[name="sign_off_testing"]').val("");
    $('textarea[name="comments_testing"]').val("");

    // Reset file input values and filenames
    $('input[name="testing_documents"]').val("");
    $("#old_testing_documents").text("Old Document Name");


    $('select[name="owner_test"]').val('NULL');
    $('select[name="ndttype_test"]').val('NULL');
}

function Testing(processOrder, userName) {
    console.log("Testing");
    console.log(processOrder);
    // Hide other fieldsets
    $("#planningFieldset").hide();
    $("#qualityFieldset").hide();
    $("#manufacturingFieldset").hide();
    $("#engineeringFieldset").hide();
    $("#kittingFieldset").hide();
    $("#weldingFieldset").hide();

    // Show Testing fieldset
    $("#testingFieldset").show();

    // Set username and process order
    $('input[name="sign_off_testing"]').val(userName);
    $("#process_order_number_testing").val(processOrder);

    // Prepare headers and data for AJAX request
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: processOrder,
    };

    // Fetch Testing Form Data for the given process order
    $.ajax({
        url: "/getTestingDataByProcessOrder", // Adjust URL as needed
        type: "POST",
        headers: headers,
        data: formData,
        dataType: "json",
        success: function (response) {
            resetTesting();

            console.log(userName);
            $('input[name="sign_off_testing"]').val(userName);
            if (response.data != null) {
                console.log("Testing data found");
                console.log(response);
                $("#process_order_number_testing").val(processOrder);

                // Set checkbox states
                $('input[name="dye_pen_test"]').prop(
                    "checked",
                    response.data.dye_pen_test === "1"
                );
                fetchOwnerData_Testing(processOrder, 'Dye Penetrant Procedure', function (ownerData) {
                    if (ownerData) {
                        // Update owner cell
                        $(`select[name="owner_test"][data-task="dye_pen_test"]`).val(ownerData.owner.trim());
                        // Update NDT cell
                        $(`select[name="ndttype_test"][data-task="dye_pen_test"]`).val(ownerData.ndta.trim());
                    } else {
                        // Handle case where no owner data is retrieved
                        $(`select[name="owner_test"][data-task="dye_pen_test"]`).val('NULL');
                        $(`select[name="ndttype_test"][data-task="dye_pen_test"]`).val('NULL');
                    }
                });



                $('input[name="hydrostatic_test"]').prop(
                    "checked",
                    response.data.hydrostatic_test === "1"
                );

                fetchOwnerData_Testing(processOrder, 'Hydrostatic Leak Test', function (ownerData) {
                    if (ownerData) {
                        // Update owner cell
                        $(`select[name="owner_test"][data-task="hydrostatic_test"]`).val(ownerData.owner.trim());
                        // Update NDT cell
                        $(`select[name="ndttype_test"][data-task="hydrostatic_test"]`).val(ownerData.ndta.trim());
                    } else {
                        // Handle case where no owner data is retrieved
                        $(`select[name="owner_test"][data-task="hydrostatic_test"]`).val('NULL');
                        $(`select[name="ndttype_test"][data-task="hydrostatic_test"]`).val('NULL');
                    }
                });



                $('input[name="pneumatic_test"]').prop(
                    "checked",
                    response.data.pneumatic_test === "1"
                );

                fetchOwnerData_Testing(processOrder, 'Pneumatic Leak Test', function (ownerData) {
                    if (ownerData) {
                        // Update owner cell
                        $(`select[name="owner_test"][data-task="pneumatic_test"]`).val(ownerData.owner.trim());
                        // Update NDT cell
                        $(`select[name="ndttype_test"][data-task="pneumatic_test"]`).val(ownerData.ndta.trim());
                    } else {
                        // Handle case where no owner data is retrieved
                        $(`select[name="owner_test"][data-task="pneumatic_test"]`).val('NULL');
                        $(`select[name="ndttype_test"][data-task="pneumatic_test"]`).val('NULL');
                    }
                });


                $('input[name="fat_protocol"]').prop(
                    "checked",
                    response.data.fat_protocol === "1"
                );


                fetchOwnerData_Testing(processOrder, 'FAT', function (ownerData) {
                    if (ownerData) {
                        // Update owner cell
                        $(`select[name="owner_test"][data-task="fat_protocol"]`).val(ownerData.owner.trim());
                        // Update NDT cell
                        $(`select[name="ndttype_test"][data-task="fat_protocol"]`).val(ownerData.ndta.trim());
                    } else {
                        // Handle case where no owner data is retrieved
                        $(`select[name="owner_test][data-task="fat_protocol"]`).val('NULL');
                        $(`select[name="ndttype_test"][data-task="fat_protocol"]`).val('NULL');
                    }
                });


                // Set other fields
                $('input[name="sign_off_testing"]').val(userName);
                $('textarea[name="comments_testing"]').val(
                    response.data.comments_testing
                );

                // Set dropdown selections
                if(response.data.dye_pen_document_ref)
                $('select[name="dyependocumentref"]').val(
                    response.data.dye_pen_document_ref
                );

                else


{
                $('select[name="dyependocumentref"]').val("NULL");
}
             
              
           
            if(response.data.hydrostatic_test_document_ref)
{
                $('select[name="hydrostatictestdocumentref"]').val(
                    response.data.hydrostatic_test_document_ref
                );
            }
            else
            {
                $('select[name="hydrostatictestdocumentref"]').val("NULL"); 
            }
            if(response.data.pneumatic_test_document_ref)
                {
                $('select[name="pneumatictestdocumentref"]').val(
                    response.data.pneumatic_test_document_ref
                );
            }
            else
            {
                $('select[name="pneumatictestdocumentref"]').val("NULL");
            }
            if( response.data.fat_protocol_document_ref)
                {
                $('select[name="fatprotocoldocumentref"]').val(
                    response.data.fat_protocol_document_ref
                );
            }
            else
            {
                $('select[name="fatprotocoldocumen_ref"]').val("NULL");
            }


                $('#old_testing_documents').text(response.data.testing_document_file_name);

                $('#testing_documents').change(function() {
                    $('#old_testing_documents').text(this.files[0].name);
                   
                });
            } else {
                resetTesting();
                $("#process_order_number_testing").val(processOrder);
                $('input[name="sign_off_testing"]').val(userName);
                $("#testingFieldset").show();
            }
        },
        error: function (error) {
            console.error(error);
        },
    });
}
