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
    var html = '<form id="manufacturingForm" class="manufacturing-Form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Main Task 2: Engineering</legend>';
    html+='<div style="width:97%">';
    $.each(response, function(index, item) {
        html += '<div class="form-group">';
       // html += '<label for="id">ID:</label>';
        //html += '<input type="text" id="id" name="id" value="' + item.id + '" readonly>';
        html += '</div>';
        
        html += '<div class="form-group">';
        html += '<label for="production_drawings">Production Drawings:</label>';
        html += '<input type="checkbox" id="production_drawings" name="production_drawings" ' + (item.production_drawings === 'true' ? 'checked' : 'disabled') + '>';
        html += '</div>';
        
        html += '<div class="form-group">';
        html += '<label for="production_drawings_document">Production Drawings Document:</label>';
        if (item.production_drawings_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/manufacturing_task/' + item.process_order_number + '/' + item.production_drawings_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.production_drawings_document+'</a>';
           //html += '<input type="file" id="production_drawings_document" name="production_drawings_document">';
            html += downloadLink;
        } else {
            //html += '<input type="file" id="production_drawings_document" name="production_drawings_document">';
        }
        html += '</div>';
        
        html += '<div class="form-group">';
        html += '<label for="bom">BOM:</label>';
        html += '<input type="checkbox" id="bom" name="bom" ' + (item.bom === 'true' ? 'checked' : 'disabled') + '>';
        html += '</div>';
        
        html += '<div class="form-group">';
        html += '<label for="bom_document">BOM Document:</label>';
        if (item.bom_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/manufacturing_task/' + item.process_order_number + '/' + item.bom_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.bom_document+'</a>';
            //html += '<input type="file" id="bom_document" name="bom_document">';
            html += downloadLink;
        } else {
           // html += '<input type="file" id="bom_document" name="bom_document">';
        }
        html += '</div>';
        
        html += '<div class="form-group">';
        html += '<label for="machine_programming_files">Machine Programming:</label>';
        html += '<input type="checkbox" id="machine_programming_files" name="machine_programming_files" ' + (item.machine_programming_files === 'true' ? 'checked' : 'disabled') + '>';
        html += '</div>';
        
        html += '<div class="form-group">';
        html += '<label for="machine_programming_files_document">Machine Programming Document:</label>';
        if (item.machine_programming_files_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/manufacturing_task/' + item.process_order_number + '/' + item.machine_programming_files_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.machine_programming_files_document+'</a>';
            //html += '<input type="file" id="machine_programming_files_document" name="machine_programming_files_document">';
            html += downloadLink;
        } else {
           // html += '<input type="file" id="machine_programming_files_document" name="machine_programming_files_document">';
        }
        html += '</div>';
        
        html += '<div class="form-group">';
        html += '<label for="ndt_documentation">NDT Documentation:</label>';
        html += '<input type="checkbox" id="ndt_documentation" name="ndt_documentation" ' + (item.ndt_documentation === 'true' ? 'checked' : 'disabled') + '>';
        html += '</div>';
        
        html += '<div class="form-group">';
        html += '<label for="ndt_documentation_document">NDT Documentation Document:</label>';
        if (item.ndt_documentation_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/manufacturing_task/' + item.process_order_number + '/' + item.ndt_documentation_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.ndt_documentation_document+'</a>';
            //html += '<input type="file" id="ndt_documentation_document" name="ndt_documentation_document">';
            html += downloadLink;
        } else {
            //html += '<input type="file" id="ndt_documentation_document" name="ndt_documentation_document">';
        }
        html += '</div>';
        
        html += '<div class="form-group">';
        html += '<label for="quality_documents">Quality Documents:</label>';
        html += '<input type="checkbox" id="quality_documents" name="quality_documents" ' + (item.quality_documents === 'true' ? 'checked' : 'disabled') + '>';
        html += '</div>';
        
        html += '<div class="form-group">';
        html += '<label for="quality_documents_document">Quality Documents Document:</label>';
        if (item.quality_documents_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/manufacturing_task/' + item.process_order_number + '/' + item.quality_documents_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.quality_documents_document+'</a>';
          //  html += '<input type="file" id="quality_documents_document" name="quality_documents_document">';
            html += downloadLink;
        } else {
            //html += '<input type="file" id="quality_documents_document" name="quality_documents_document">';
        }
        html += '</div>';
        
        html += '<div class="form-group">';
        html += '<label for="sign_off_manufacturing">Sign-off:</label>';
        html += '<input style="width:100%"type="text" id="sign_off_manufacturing" name="sign_off_manufacturing" value="' + (item.sign_off_manufacturing || '') + '">';
        html += '</div>';
        
        html += '<div class="form-group">';
        html += '<label for="comments_manufacturing">Comments:</label>';
        html += '<textarea style="width:100%"id="comments_manufacturing" name="comments_manufacturing">' + (item.comments_manufacturing || '') + '</textarea>';
        html += '</div>';
        
        html += '<hr>'; // Add a separator between items
    });
    
    html += '</div>';
    html += '</fieldset></form>';

    return html;
}




function generateManufacturingFieldset(processOrder, qualityStep,username) {
  /*   $('#sign_off_manufacturing').val(username);
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
        </fieldset>`; */
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
        process_order_number: document.querySelector('[name="process_order_number_manufacturing"]').value || null,
        
        production_drawings_document: (document.querySelector('[name="production_drawings_document"]').files.length > 0)
        ? document.querySelector('[name="production_drawings_document"]').files[0].name
        : document.getElementById('production_drawings_filename').textContent.trim(),
    
    bom_document: (document.querySelector('[name="bom_document"]').files.length > 0)
        ? document.querySelector('[name="bom_document"]').files[0].name
        : document.getElementById('bom_filename').textContent.trim(),
    
    machine_programming_files_document: (document.querySelector('[name="machine_programming_files_document"]').files.length > 0)
        ? document.querySelector('[name="machine_programming_files_document"]').files[0].name
        : document.getElementById('machine_programming_files_filename').textContent.trim(),
    
    ndt_documentation_document: (document.querySelector('[name="ndt_documentation_document"]').files.length > 0)
        ? document.querySelector('[name="ndt_documentation_document"]').files[0].name
        : document.getElementById('ndt_documentation_filename').textContent.trim(),
    
    quality_documents_document: (document.querySelector('[name="quality_documents_document"]').files.length > 0)
        ? document.querySelector('[name="quality_documents_document"]').files[0].name
        : document.getElementById('quality_documents_filename').textContent.trim()



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
            $(myModal).hide();
            // If you need to update the UI or do anything after form submission, do it here
        },
        error: function (error) {
            console.error(error);
            alert('Error submitting manufacturing form');
        }
    });

    var fileData = new FormData();
    var fileInputs = $('[type="file"]');
    fileData.append('process_order_number', document.querySelector('[name="process_order_number_manufacturing"]').value);

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
function resetManufacturingForm() {
    // Uncheck checkboxes
    $('#production_drawings').prop('checked', false);
    $('#bom').prop('checked', false);
    $('#machine_programming_files').prop('checked', false);
    $('#ndt_documentation').prop('checked', false);
    $('#quality_documents').prop('checked', false);

    // Clear text inputs
    $('#sign_off_manufacturing').val('');
    $('#comments_manufacturing').val('');
    $('#process_order_number_manufacturing').val('');

    // Reset file input values and filenames
    $('#production_drawings_filename').text('');
    $('#bom_filename').text('');
    $('#machine_programming_files_filename').text('');
    $('#ndt_documentation_filename').text('');
    $('#quality_documents_filename').text('');

    $('#production_drawings_document').val('');
    $('#bom_document').val('');
    $('#machine_programming_files_document').val('');
    $('#ndt_documentation_document').val('');
    $('#quality_documents_document').val('');

    // Reset old file links
    $('#previous_production_drawings_link').attr('href', '');
    $('#previous_bom_link').attr('href', '');
    $('#previous_machine_programming_files_link').attr('href', '');
    $('#previous_ndt_documentation_link').attr('href', '');
    $('#previous_quality_documents_link').attr('href', '');

    // Show the manufacturing form section if it was hidden
    $('#manufacturingFieldset').show();
}
function Manufacturing(processOrder,userName)
{
 console.log('manufacturing');
            console.log(userName);
            $('#planningFieldset').hide();
            $('#qualityFieldset').hide();
            $('#manufacturingFieldset').hide();
            $('#manufacturingFieldset').show();
            $('#sign_off_manufacturing').val(userName);
            $('#process_order_number_manufacturing').val(processOrder);
            var headers = {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // Add other headers if needed
            };

            var formData = {
                process_order_number: processOrder
                // Add other form data if needed
            };

            // Fetch Manufacturing Form Data for the given process order
            $.ajax({
                url: '/getManufacturingDataByProcessOrder', // Adjust URL as needed
                type: 'POST',
                headers: headers,
                data: formData,
                dataType: 'json',
                success: function(response) {
                    resetManufacturingForm();

                    console.log(userName);
                    $('#sign_off_manufacturing').val(userName);
                    $('#process_order_number_manufacturing').val(processOrder);
                    // console.log(response.process_order_number);
                    if (response.data != null) {
                        console.log('yes po found');
                        console.log(response);
                        $.each(response, function(index, item) {

                            console.log(item.process_order_number);
                            $('#process_order_number_manufacturing').val(item.process_order_number);


                            $('input[name="production_drawings"]').prop('checked', item
                                .production_drawings === 'true');
                            $('input[name="bom"]').prop('checked', item.bom === 'true');
                            $('input[name="machine_programming_files"]').prop('checked', item
                                .machine_programming_files === 'true');
                            $('input[name="ndt_documentation"]').prop('checked', item
                                .ndt_documentation === 'true');
                            $('input[name="quality_documents"]').prop('checked', item
                                .quality_documents === 'true');

                            // Other fields
                            $('#sign_off_manufacturing').val(userName);
                            $('#comments_manufacturing').val(item.comments_manufacturing);

                            // File input fields
                            $('#production_drawings_filename').text(item
                                .production_drawings_document);
                            $('#bom_filename').text(item.bom_document);
                            $('#machine_programming_files_filename').text(item
                                .machine_programming_files_document);
                            $('#ndt_documentation_filename').text(item.ndt_documentation_document);
                            $('#quality_documents_filename').text(item.quality_documents_document);

                            // Set the labels for file inputs
                            $('#production_drawings_file_label').show();
                            $('#bom_file_label').show();
                            $('#machine_programming_files_file_label').show();
                            $('#ndt_documentation_file_label').show();
                            $('#quality_documents_file_label').show();

                            // Attach handlers for file input changes
                            $('#production_drawings_document').change(function() {
                                $('#production_drawings_filename').text(this.files[0].name);
                            });

                            $('#bom_document').change(function() {
                                $('#bom_filename').text(this.files[0].name);
                            });

                            $('#machine_programming_files_document').change(function() {
                                $('#machine_programming_files_filename').text(this.files[0]
                                    .name);
                            });

                            $('#ndt_documentation_document').change(function() {
                                $('#ndt_documentation_filename').text(this.files[0].name);
                            });

                            $('#quality_documents_document').change(function() {
                                $('#quality_documents_filename').text(this.files[0].name);
                            });
                        });
                    } else {

                        resetManufacturingForm();
                        alert('hello');
                        $('#process_order_number_manufacturing').val(processOrder);
                        $('#sign_off_manufacturing').val(userName);
                        $('#manufacturingFieldset').show();
                    }

                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
