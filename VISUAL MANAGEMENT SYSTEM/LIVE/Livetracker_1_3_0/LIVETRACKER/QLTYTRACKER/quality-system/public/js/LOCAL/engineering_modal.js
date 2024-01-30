function generateEngineeringFieldset(processOrder, qualityStep) {
    console.log(processOrder);
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
            <input type="text" name="sign_off_engineering">
        </label>
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
    var formData = {
        reference_job_master_file: document.querySelector('[name="reference_job_master_file"]')?.checked||null,
        concept_design_engineering: document.querySelector('[name="concept_design_engineering"]')?.checked||null,
        design_validation_sign_off: document.querySelector('[name="design_validation_sign_off"]')?.checked||null,
        customer_submittal_package: document.querySelector('[name="customer_submittal_package"]')?.checked || null,
        reference_approved_samples: document.querySelector('[name="reference_approved_samples"]')?.checked || null,
        reference_job_master_file_document: getFileName('reference_job_master_file_document'),
        concept_design_document: getFileName('concept_design_document'),
        customer_approval_document: getFileName('customer_approval_document'),
        design_validation_document: getFileName('design_validation_document'),
        sample_approval_document: getFileName('design_validation_document'),
        sign_off_engineering: document.querySelector('[name="sign_off_engineering"]')?.checked|| null,
        comments_engineering: document.querySelector('[name="comments_engineering"]')?.checked || null,
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
           // location.reload();
        },
        error: function (error) {
            // Handle the error response if needed
            console.error(error);
        }
    });
    // File uploads
    var fileData = new FormData();
    var fileInputs = $('[type="file"]');

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

    // Send an AJAX request for file uploads
    $.ajax({
        url: '/handleFileUpload',  // Update to your actual route
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
   