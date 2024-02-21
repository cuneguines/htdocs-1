

function generateEngineeringFieldTable(processOrder, qualityStep) {
    console.log(processOrder);


    // Assuming you have the process order number in a variable
    var processOrderNumber = "123"; // Replace with the actual process order number

    // Assuming you have some custom headers to include
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Replace with the actual CSRF token
        // Include other headers if needed
    };

    // Assuming you have some data to send in the request
    var formData = {
        process_order_number: processOrder,
        // Include other data if needed
    };

    $.ajax({
        url: '/getEngineerDataByProcessOrder',
        type: 'POST',
        data: formData,
        headers: headers,
        dataType: 'json',
        success: function (response) {

            console.log(response);
            //USe this for testing
           /*  $.each(response, function () {
                $.each(this, function (key, val) {
                    if (key == 'reference_job_master_file') {

                        console.log(val);

                        // $(".nav-second-level")

                        //.append('<li value="' + Product_item + '"><a href="#"><span class="tab">' + Product_item + '</span></a> <ul class="nav-third-level" style="overflow-y:scroll"></ul></li>');

                    }


                });
            }); */
            var generatedHTML = generateHTMLFromResponse_for_eng(response);

            // Append the generated HTML to a container (replace 'yourContainerId' with your actual container ID)
            $('#engineeringFieldTable').html(generatedHTML);
        },
        error: function (error) {
            // Handle the error response if needed
            console.error(error);
        }
    });

    return `
            <div>To be Done</div>
        `;
}

function generateHTMLFromResponse_for_eng(response) {
    var html = '<table id="common_table">';
    html += '<thead><tr><th>ID</th><th>Reference Job / Master File</th><th>Reference Job / Master File Document</th><th>Concept Design</th><th>Concept Design Document</th><th>Design Validation</th><th>Design Validation Document</th><th>Customer Approval</th><th>Customer Approval Document</th><th>Sample Approval</th><th>Sample Approval Document</th><th>Sign-off Engineering</th><th>Comments Engineering</th></tr></thead><tbody>';

    $.each(response, function (index, item) {
        html += '<tr>';
        html += '<td>' + item.id + '</td>'; // Access 'id' property of each item
        html += '<td>' + (item.reference_job_master_file === 'true' ? '✔' : '') + '</td>'; // Show tick if 'reference_job_master_file' is 'true'
        if (item.reference_job_master_file_document) {
            var filePath = 'storage/engineer_task/' + item.process_order_number + '/' + item.reference_job_master_file_document;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'reference_job_master_file_document' is empty
        }

        html += '<td>' + (item.concept_design_engineering === 'true' ? '✔' : '') + '</td>'; // Show tick if 'concept_design_engineering' is 'true'
        if (item.concept_design_document) {
            var filePath = 'storage/engineer_task/' + item.process_order_number + '/' + item.concept_design_document;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'concept_design_document' is empty
        }

        html += '<td>' + (item.design_validation_sign_off === 'true' ? '✔' : '') + '</td>'; // Show tick if 'design_validation_sign_off' is 'true'
        if (item.design_validation_document) {
            var filePath = 'storage/engineer_task/' + item.process_order_number + '/' + item.design_validation_document;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'design_validation_document' is empty
        }

        html += '<td>' + (item.customer_approval === 'true' ? '✔' : '') + '</td>'; // Show tick if 'customer_approval' is 'true'
        if (item.customer_approval_document) {
            var filePath = 'storage/engineer_task/' + item.process_order_number + '/' + item.customer_approval_document;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'customer_approval_document' is empty
        }

        html += '<td>' + (item.reference_approved_samples === 'true' ? '✔' : '') + '</td>'; // Show tick if 'reference_approved_samples' is 'true'
        if (item.sample_approval_document) {
            var filePath = 'storage/engineer_task/' + item.process_order_number + '/' + item.sample_approval_document;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'sample_approval_document' is empty
        }

        html += '<td>' + (item.sign_off_engineering ? item.sign_off_engineering : '') + '</td>';
        html += '<td>' + (item.comments_engineering ? item. comments_engineering: '') + '</td>'; // Display sign-off info or empty if not available

        html += '</tr>';
    });

    html += '</tbody></table>';

    return html;
}





function generateEngineeringFieldset(processOrder, qualityStep,username) {
   console.log('username from modal',username);
   $('#sign_off_engineering').val(username);
    return `
           
    <fieldset>
    <legend>Main Task 2: Engineering</legend>

    <!-- Subtask 2.1: Reference Job / Master File -->
    <div class="form-group">
        <label>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="checkbox" name="reference_job_master_file">
            Reference Job / Master File if applicable
        </label>
        <br>
        <label class="upload-label">
            Upload Document:
            <input type="file" name="reference_job_master_file_document">
        </label>
    </div>
    
    <!-- Subtask 2.2: Concept Design -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="concept_design_engineering">
            Concept design & engineering details
        </label>
        <br>
        <label class="upload-label">
            Upload Concept Design Document:
            <input type="file" name="concept_design_document">
        </label>
    </div>

    <!-- Subtask 2.3: Design Validation -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="design_validation_sign_off">
            Design sign off [calculations]
        </label>
        <br>
        <label class="upload-label">
            Upload Design Validation Document:
            <input type="file" name="design_validation_document">
        </label>
    </div>

    <!-- Subtask 2.4: Customer Approval -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="customer_submittal_package">
            Customer submittal package
        </label>
        <br>
        <label class="upload-label">
            Upload Customer Approval Document:
            <input type="file" name="customer_approval_document">
        </label>
    </div>

    <!-- Subtask 2.5: Sample Approval -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="reference_approved_samples">
            Reference approved samples
        </label>
        <br>
        <label class="upload-label">
            Upload Sample Approval Document:
            <input type="file" name="sample_approval_document">
        </label>
    </div>

    <!-- Sign-off for Main Task 2 -->
    <div class="form-group">
        <label>
            Sign-off for Engineering:
            <input type="text" name="sign_off_engineering"value="${username}">
    </div>

    <!-- Comments for Main Task 2 -->
    <div class="form-group">
        <label>
            Comments for Engineering:
            <textarea name="comments_engineering" rows="4" cols="50"></textarea>
        </label>
    </div>

    <!-- Submit button -->
    <button type="submit" onclick="submitEngineeringForm('${processOrder}')">Submit Engineering Form</button>
</fieldset>


           
    `;
}

function submitEngineeringForm(processOrder) {
    // Add your logic to handle the form submission for the engineering fieldset
  
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };
    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }
    const sign_off_engineering = document.querySelector('[name="sign_off_engineering"]').value;
    
    var formData = {
        reference_job_master_file: document.querySelector('[name="reference_job_master_file"]')?.checked || null,
        concept_design_engineering: document.querySelector('[name="concept_design_engineering"]')?.checked || null,
        design_validation_sign_off: document.querySelector('[name="design_validation_sign_off"]')?.checked || null,
        customer_submittal_package: document.querySelector('[name="customer_submittal_package"]')?.checked || null,
        reference_approved_samples: document.querySelector('[name="reference_approved_samples"]')?.checked || null,
        reference_job_master_file_document: getFileName('reference_job_master_file_document'),
        concept_design_document: getFileName('concept_design_document'),
        customer_approval_document: getFileName('customer_approval_document'),
        design_validation_document: getFileName('design_validation_document'),
        sample_approval_document: getFileName('design_validation_document'),
        
        sign_off_engineering: sign_off_engineering,
        comments_engineering: document.querySelector('[name="comments_engineering"]').value || null,
        submission_date: new Date().toISOString().split('T')[0],  // Get today's date in YYYY-MM-DD format
        process_order_number: processOrder,
        // Add other form fields accordingly
    };
    console.log(formData);

    // Send an AJAX request to the server
    $.ajax({
        url: '/submitEngineeringForm',
        type: 'POST',
        data: formData,
        headers: headers,
        success: function (response) {
            // Handle the success response if needed

            console.log(response);
            alert('success')
            $('#myModal').hide();
            // location.reload();
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
        url: '/handleFileUploadEngineer',  // Update to your actual route
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
