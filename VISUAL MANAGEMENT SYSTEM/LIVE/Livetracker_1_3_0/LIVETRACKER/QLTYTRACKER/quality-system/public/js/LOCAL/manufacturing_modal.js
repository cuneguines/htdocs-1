function generateManufacturingFieldTable(processOrder, qualityStep) {
    console.log(processOrder);

    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };

    var formData = {
        process_order_number: processOrder
    };

    $.ajax({
        url: '/getManufacturingDataByProcessOrder',
        type: 'POST',
        data: formData,
        headers: headers,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            var generatedHTML = generateHTMLFromResponse_for_manufacturing(response);
            $('#manufacturingFieldTable').html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        }
    });

    return `
            <div>To be Done</div>
        `;
}

function generateHTMLFromResponse_for_manufacturing(response) {
    var html = '<table id="common_table">';
    html += '<thead><tr><th>ID</th><th>Production Drawings</th><th>Production Drawings Document</th><th>BOM</th><th>BOM Document</th><th>Machine Programming</th><th>Machine Programming Document</th><th>NDT Documentation</th><th>NDT Documentation Document</th><th>Quality Documents</th><th>Quality Documents Document</th><th>Sign-off</th><th>Comments</th></tr></thead><tbody>';


    $.each(response, function (index, item) {
        html += '<tr>';
        html += '<td>' + item.id + '</td>';
        html += '<td>' + (item.production_drawings === 'true' ? '✔' : '') + '</td>';
        if (item.production_drawings_document) {
            var filePath = 'storage/manufacturing_task/' + item.process_order_number + '/' + item.production_drawings_document;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>';
        }

        html += '<td>' + (item.bom === 'true' ? '✔' : '') + '</td>';
        if (item.bom_document) {
            var filePath = 'storage/manufacturing_task/' + item.process_order_number + '/' + item.bom_document;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>';
        }

        html += '<td>' + (item.machine_programming_files === 'true' ? '✔' : '') + '</td>';
        if (item.machine_programming_files_document) {
            var filePath = 'storage/manufacturing_task/' + item.process_order_number + '/' + item.machine_programming_files_document;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>';
        }

        html += '<td>' + (item.ndt_documentation === 'true' ? '✔' : '') + '</td>';
        if (item.ndt_documentation_document) {
            var filePath = 'storage/manufacturing_task/' + item.process_order_number + '/' + item.ndt_documentation_document;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>';
        }

        html += '<td>' + (item.quality_documents === 'true' ? '✔' : '') + '</td>';
        if (item.quality_documents_document) {
            var filePath = 'storage/manufacturing_task/' + item.process_order_number + '/' + item.quality_documents_document;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>';
        }

        html += '<td>' + (item.sign_off_manufacturing || '') + '</td>';
        html += '<td>' + (item.comments_manufacturing || '') + '</td>';

        html += '</tr>';
    });

    html += '</tbody></table>';

    return html;
}

function generateManufacturingFieldset(processOrder, qualityStep,username) {
    $('#sign_off_manufacturing').val(username);
    return `
        <fieldset>
            <legend>Main Task 3: Manufacturing</legend>
            
            <!-- Subtask 3.1: Production Drawings -->
            <div class="form-group">
                <label>
                    <input type="checkbox" name="production_drawings">
                    Production Drawings
                </label>
                <br>
                <label class="upload-label">
                    Upload Production Drawings Package:
                    <input type="file" name="production_drawings_document" required>
                </label>
                <span id="upload-error" class="upload-message" style="display:none;">Please upload a file.</span>
            </div>

            <!-- Subtask 3.2: BOM -->
            <div class="form-group">
                <label>
                    <input type="checkbox" name="bom">
                    BOM
                </label>
                <br>
                <label class="upload-label">
                    Upload BOM Document:
                    <input type="file" name="bom_document">
                </label>
            </div>

            <!-- Subtask 3.3: Machine Programming Files -->
            <div class="form-group">
                <label>
                    <input type="checkbox" name="machine_programming_files">
                    Machine Programming Files
                </label>
                <br>
                <label class="upload-label">
                    Upload Machine Programming Files:
                    <input type="file" name="machine_programming_files_document">
                </label>
            </div>

            <!-- Subtask 3.4: NDT Documentation -->
            <div class="form-group">
                <label>
                    <input type="checkbox" name="ndt_documentation">
                    NDT Documentation
                </label>
                <br>
                <label class="upload-label">
                    Upload NDT Documentation:
                    <input type="file" name="ndt_documentation_document">
                </label>
            </div>

            <!-- Subtask 3.5: Quality Documents -->
            <div class="form-group">
                <label>
                    <input type="checkbox" name="quality_documents">
                    Quality Documents
                </label>
                <br>
                <label class="upload-label">
                    Upload Quality Documents:
                    <input type="file" name="quality_documents_document">
                </label>
            </div>

            <!-- Sign-off for Main Task 3 -->
            <div class="form-group">
                <label>
                    Sign-off for Manufacturing:
                    <input type="text" name="sign_off_manufacturing"value="${username}" >
                </label>
            </div>

            <!-- Comments for Main Task 3 -->
            <div class="form-group">
                <label>
                    Comments for Manufacturing:
                    <textarea name="comments_manufacturing" rows="4" cols="50"></textarea>
                </label>
            </div>

            <!-- Submit button -->
            <button type="submit" onclick="submitManufacturingForm('${processOrder}')">Submit Manufacturing Form</button>
        </fieldset>`;
}
// Assuming this function is called when the form is submitted
function validateForm() {
    var fileInput = document.querySelector('input[name="production_drawings_document"]');
    if (fileInput.value === "") {
        document.getElementById("upload-error").style.display = "block";
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}


function submitManufacturingForm(processOrder) {
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };

    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }
    const sign_off_manufacturing = document.querySelector('[name="sign_off_manufacturing"]').value;
    var formData = {
        production_drawings: document.querySelector('[name="production_drawings"]').checked || null,
        bom: document.querySelector('[name="bom"]').checked || null,
        machine_programming_files: document.querySelector('[name="machine_programming_files"]').checked || null,
        ndt_documentation: document.querySelector('[name="ndt_documentation"]').checked || null,
        quality_documents: document.querySelector('[name="quality_documents"]').checked || null,
        sign_off_manufacturing: sign_off_manufacturing,
        comments_manufacturing: document.querySelector('[name="comments_manufacturing"]').value || null,
        process_order_number: processOrder,
        production_drawings_document: getFileName('production_drawings_document'),
        bom_document: getFileName('bom_document'),
        machine_programming_files_document: getFileName('machine_programming_files_document'),
        ndt_documentation_document: getFileName('ndt_documentation_document'),
        quality_documents_document: getFileName('quality_documents_document'),
        // Add other file inputs accordingly
    };
    

    $.ajax({
        url: '/submitManufacturingForm',
        type: 'POST',
        data: formData,
        headers: headers,
        success: function (response) {
            console.log(response);
            alert('Manufacturing form submitted successfully');
            // If you need to update the UI or do anything after form submission, do it here
        },
        error: function (error) {
            console.error(error);
            alert('Error submitting manufacturing form');
        }
    });

    var fileData = new FormData();
    var fileInputs = $('[type="file"]');
    fileData.append('process_order_number', processOrder);

    fileInputs.each(function (index, fileInput) {
        var files = fileInput.files;
        if (files.length > 0) {
            $.each(files, function (i, file) {
                fileData.append(fileInput.name + '_' + i, file);
            });
        }
    });

    $.ajax({
        url: '/handleFileUploadManufacturing',
        type: 'POST',
        data: fileData,
        headers: headers,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            alert('Files uploaded successfully');
            // If you need to update the UI or do anything after file upload, do it here
        },
        error: function (error) {
            console.error(error);
            alert('Error uploading files');
        }
    });

    console.log('Manufacturing form submitted!');
}
