

function generatePlanningFieldTable(processOrder, qualityStep) {
    console.log(processOrder);


   
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
        url: '/getPlanningDataByProcessOrder',
        type: 'POST',
        data: formData,
        headers: headers,
        dataType: 'json',
        success: function (response) {

            console.log(response);
            $.each(response, function () {
                $.each(this, function (key, val) {
                    if (key == 'purchase_order_received') {

                        console.log(val);

                        // $(".nav-second-level")

                        //.append('<li value="' + Product_item + '"><a href="#"><span class="tab">' + Product_item + '</span></a> <ul class="nav-third-level" style="overflow-y:scroll"></ul></li>');

                    }


                });
            });
            var generatedHTML = generateHTMLFromResponse_for_planning(response);

            // Append the generated HTML to a container (replace 'yourContainerId' with your actual container ID)
            $('#planningFieldTable').html(generatedHTML);
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

function generateHTMLFromResponse_for_planning(response) {
    // You can customize this function to generate HTML based on the response data
    // For example, you can iterate through the data and create table rows
    var html = '<table id=common_table>';
    html += '<thead><tr><th>id</th><th>purchase_order_received</th><th>purchase_order_document</th><th>project_schedule_agreed</th><th>project_schedule_document</th><th>quotation</th><th>quotation_document</th><th>verify_customer_expectations</th><th>user_requirement_specifications_document</th><th>project_risk_category_assessment</th><th>pre_engineering_check_document</th><th>sign_off_planning</th><th>comments_planning</th></tr></thead><tbody>'; // Replace with actual column names
      

    $.each(response, function (index, item) {
        html += '<tr>';
        html += '<td>' + item.id + '</td>'; // Access 'id' property of each item
        html += '<td>' + (item.purchase_order_received === 'true' ? '✔' : '') + '</td>'; // Show tick if 'reference_job_master_file' is 'on'
         if (item.purchase_order_document) {
            var filePath = 'storage/planning_task/' + item.process_order_number + '/' + item.purchase_order_document;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'reference_job_master_file_document' is empty
        }

        html += '<td>' + (item.project_schedule_agreed === 'true' ? '✔' : '') + '</td>'; // Show tick if 'reference_job_master_file' is 'on'
        if (item.project_schedule_document) {
            var filePath = 'storage/planning_task/' + item.process_order_number + '/' + item.project_schedule_document;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'reference_job_master_file_document' is empty
        } 
        html += '<td>' + (item.quotation === 'true' ? '✔' : '') + '</td>';

        if (item.quotation_document) {
            var filePath = 'storage/planning_task/' + item.process_order_number + '/' + item.quotation_document;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'reference_job_master_file_document' is empty
        } 


        html += '<td>' + (item.verify_customer_expectations === 'true' ? '✔' : '') + '</td>';

        if (item.user_requirement_specifications_document) {
            var filePath = 'storage/planning_task/' + item.process_order_number + '/' + item.user_requirement_specifications_document;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'reference_job_master_file_document' is empty
        } 

        html += '<td>' + (item.project_risk_category_assessment === 'true' ? '✔' : '') + '</td>';

        if (item.pre_engineering_check_document) {
            var filePath = 'storage/planning_task/' + item.process_order_number + '/' + item.pre_engineering_check_document;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'reference_job_master_file_document' is empty
        } 
        html += '<td>' + (item.sign_off_planning === 'true' ? '✔' : '') + '</td>';
        html += '<td>' + (item.comments_planning === 'true' ? '✔' : '') + '</td>';

        // Include other columns as needed
        html += '</tr>';
    });

    html += '</tbody></table>';
    
    return html;
}



function generatePlanningFieldset(processOrder, qualityStep) {
   
    return `
<fieldset>
    <legend>Main Task 1: Planning / Forward Engineering</legend>

    <!-- Subtask 1.1: Purchase Order -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="purchase_order_received">
            Purchase Order received
        </label>
        <br>
        <label class="upload-label">
            Upload Purchase Order Document:
            <input type="file" name="purchase_order_document">
        </label>
    </div>

    <!-- Subtask 1.2: Project Schedule -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="project_schedule_agreed">
            Project schedule agreed
        </label>
        <br>
        <label class="upload-label">
            Upload Project Schedule Document:
            <input type="file" name="project_schedule_document">
        </label>
    </div>

    <!-- Subtask 1.3: Quotation -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="quotation">
            Quotation
        </label>
        <br>
        <label class="upload-label">
            Upload Quotation Document:
            <input type="file" name="quotation_document">
        </label>
    </div>

    <!-- Subtask 1.4: User Requirement Specifications -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="verify_customer_expectations">
            Verify customer expectations
        </label>
        <br>
        <label class="upload-label">
            Upload User Requirement Specifications Document:
            <input type="file" name="user_requirement_specifications_document">
        </label>
    </div>

    <!-- Subtask 1.5: Pre Engineering Check -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="project_risk_category_assessment">
            Project risk category assessment
        </label>
        <br>
        <label class="upload-label">
            Upload Pre Engineering Check Document:
            <input type="file" name="pre_engineering_check_document">
        </label>
    </div>

    <!-- Sign-off for Main Task 1 -->
    <div class="form-group">
        <label>
            Sign-off for Planning / Forward Engineering:
            <input type="text" name="sign_off_planning">
        </label>
    </div>

    <!-- Comments for Main Task 1 -->
    <div class="form-group">
        <label>
            Comments for Planning / Forward Engineering:
            <textarea name="comments_planning" rows="4" cols="50"></textarea>
        </label>
    </div>

    <!-- Submit button -->
    <button type="submit" onclick="submitPlanningForm('${processOrder}')">Submit Planning Form</button>
</fieldset> `;
           
   
}

function submitPlanningForm(processOrder) {
    // Add your logic to handle the form submission for the engineering fieldset
  
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };
    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }

   
    var formData = {
        purchase_order_received: document.querySelector('[name="purchase_order_received"]')?.checked || null,
        project_schedule_agreed: document.querySelector('[name="project_schedule_agreed"]')?.checked || null,
        
        quotation: document.querySelector('[name="quotation"]')?.checked || null,
        verify_customer_expectations: document.querySelector('[name="verify_customer_expectations"]')?.checked || null,
        project_risk_category_assessment: document.querySelector('[name="project_risk_category_assessment"]')?.checked || null,
        
        purchase_order_document: getFileName('purchase_order_document'),
        project_schedule_document: getFileName('project_schedule_document'),
        user_requirement_specifications_document: getFileName('user_requirement_specifications_document'),
        pre_engineering_check_document: getFileName('pre_engineering_check_document'),
        quotation_document: getFileName('quotation_document'),
        sign_off_engineering: 'eys',
        comments_engineering: document.querySelector('[name="comments_planning"]')?.checked || null,
        // Get today's date in YYYY-MM-DD format
        process_order_number: processOrder,
        // Add other form fields accordingly
    };
    console.log(formData);

    // Send an AJAX request to the server
    $.ajax({
        url: '/submitPlanningForm',
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
        url: '/handleFileUploadPlanning',  // Update to your actual route
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

    console.log('Planning form submitted!');
}
