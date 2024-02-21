function generateMaterialPreparationFieldset(processOrder, qualityStep, username) {
    $('#sign_off_material_preparation').val(username);
    return `
    <fieldset>
    <legend>Main Task 4: Material Preparation</legend>

    <!-- Subtask 4.1: Material Identification -->
    <div class="form-group">
        <label>
            Material Identification: Confirm grade, thickness
            <input type="text" name="material_identification">
        </label>
    </div>

    <!-- Subtask 4.2: Material Identification Record -->
    <div class="form-group">
        <label>
            Material Identification Record: 3.1 Mill Test Certificate [EN 1024]
            <input type="text" name="material_identification_record">
        </label>
        <label class="upload-label">
        Upload Material Identification Record:
        <input type="file" name="material_identification_record_file">
    </label>
    </div>

    <!-- Subtask 4.3: Material Traceability -->
    <div class="form-group">
        <label>
            Material Traceability: Heat Number
            <input type="text" name="material_traceability">
        </label>
        <label class="upload-label">
    Upload Material Traceability Document:
    <input type="file" name="material_traceability_file">
</label>
    </div>

    <!-- Subtask 4.4: Cutting -->
    <div class="form-group">
        <label>
            Cutting: Part geometry, cut quality, part qty
            <input type="checkbox" name="cutting">
        </label>
    </div>

    <!-- Subtask 4.5: De-burring -->
    <div class="form-group">
        <label>
            De-burring: No sharp edges
            <input type="checkbox" name="deburring">
        </label>
    </div>

    <!-- Subtask 4.6: Forming -->
    <div class="form-group">
        <label>
            Forming: Part geometry, part qty
            <input type="checkbox" name="forming">
        </label>
    </div>

    <!-- Subtask 4.7: Machining -->
    <div class="form-group">
        <label>
            Machining: Part geometry, part qty
            <input type="checkbox" name="machining">
        </label>
    </div>

    <!-- Sign-off for Main Task 4 -->
    <div class="form-group">
        <label>
            Sign-off for Material Preparation:
            <input type="text" name="sign_off_material_preparation"value="${username}">
        </label>
    </div>

    <!-- Comments for Main Task 4 -->
    <div class="form-group">
        <label>
            Comments for Material Preparation:
            <textarea name="comments_material_preparation" rows="4" cols="50"></textarea>
        </label>
    </div>

    <!-- Submit button -->
    <button type="submit" onclick="submitMaterialPreparationForm('${processOrder}')">Submit Material Preparation Form</button>
</fieldset>
    `;
}


function submitMaterialPreparationForm(processOrder) {
    // Add your logic to handle the form submission for the material preparation fieldset

    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };
    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }
    var formData = {
        material_identification: document.querySelector('[name="material_identification"]').value,
        material_identification_record: document.querySelector('[name="material_identification_record"]').value,
        material_traceability: document.querySelector('[name="material_traceability"]').value,
        cutting: document.querySelector('[name="cutting"]').value,
        deburring: document.querySelector('[name="deburring"]').value,
        forming: document.querySelector('[name="forming"]').value,
        machining: document.querySelector('[name="machining"]').value,
        material_identification_record_file: getFileName('material_identification_record_file'),
        material_traceability_file: getFileName('material_traceability_file'),
        sign_off_material_preparation: document.querySelector('[name="sign_off_material_preparation"]').value,
        comments_material_preparation: document.querySelector('[name="comments_material_preparation"]').value,
        submission_date: new Date().toISOString().split('T')[0], // Get today's date in YYYY-MM-DD format
        process_order_number: processOrder,
        // Add other form fields accordingly
    };
    console.log(formData);
    // Send an AJAX request to the server
    $.ajax({
        url: '/submitMaterialPreparationForm',
        type: 'POST',
        data: formData,
        headers: headers,
        success: function (response) {
            // Handle the success response if needed
            console.log(response);
            alert('success');
            $('#myModal').hide();
            updateTable(response);
            function updateTable(response) {
                // Assuming your table has an ID, update the table rows dynamically
                var newRow = '<tr><td>' + response.name + '</td><td>' + response.path + '</td></tr>';
                $('#yourTableId tbody').append(newRow);
            }
        },
        error: function (error) {
            // Handle the error response if needed
            console.error(error);
        }
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
        url: '/handleFileUploadMaterialPreparation',  // Update to your actual route
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

    console.log('Mat Preparation form submitted!');
}






function generateMaterialPreparationFieldTable(processOrder, qualityStep) {
    console.log(processOrder);

    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };

    var formData = {
        process_order_number: processOrder
    };

    $.ajax({
        url: '/getMaterialPreparationDataByProcessOrder',
        type: 'POST',
        data: formData,
        headers: headers,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            var generatedHTML = generateHTMLFromResponse_for_material_preparation(response);
            $('#materialpreparationFieldTable').html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        }
    });

    return `
            <div>To be Done</div>
        `;
}

function generateHTMLFromResponse_for_material_preparation(response) {
    var html = '<table id="common_table" style="width:100%;">';
    html += '<thead><tr><th style="width:5%;">ID</th><th style="width:10%;">Material Identification</th><th style="width:15%;">Material Identification Record</th><th style="width:15%;">Material Identification Cert </th><th style="width:15%;">Material Traceability</th><th style="width:15%;">Material Traceability Cert</th><th style="width:7%;">Cutting</th><th style="width:7%;">De-burring</th><th style="width:7%;">Forming</th><th style="width:7%;">Machining</th><th style="width:12%;">Sign Off</th><th style="width:15%;">Comments</th></tr></thead><tbody>';

    $.each(response, function (index, item) {
        html += '<tr>';
        html += '<td>' + item.id + '</td>';
        html += '<td style="text-align:center;">' + (item.material_identification === 'true' ? '✔' : '') + '</td>';
        html += '<td>' + (item.material_identification_record || '') + '</td>';

        if (item.material_identification_record_file) {
            var filePath = 'storage/material_preparation_task/' + item.process_order_number + '/' + item.material_identification_record_file;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'customer_approval_document' is empty
        }
        html += '<td>' + (item.material_traceability || '') + '</td>';
        if (item.material_traceability_file) {
            var filePath = 'storage/material_preparation_task/' + item.process_order_number + '/' + item.material_traceability_file;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'customer_approval_document' is empty
        }
        html += '<td style="text-align:center;">' + (item.cutting === 'true'||'on' ? '✔' : '') + '</td>';
        html += '<td style="text-align:center;">' + (item.de_burring === 'true'||'on' ? '✔' : '') + '</td>';
        html += '<td style="text-align:center;">' + (item.forming === 'true'||'on' ? '✔' : '') + '</td>';
        html += '<td style="text-align:center;">' + (item.machining === 'true' ||'on'? '✔' : '') + '</td>';
        html += '<td>' + item.sign_off_material_preparation + '</td>';
        html += '<td>' + item.comments_material_preparation + '</td>';
        html += '</tr>';
    });

    html += '</tbody></table>';

    return html;
}
