

<fieldset>
    <legend>Main Task 2: Engineering</legend>

    <!-- Process Order Number -->
    <div class="form-group">
        <label>
            <input type="text" name="process_order_number_engineering" id="process_order_number_engineering" readonly>
            Process Order Number
        </label>
    </div>
    
    
    <!-- Subtask 2.1: Reference Job / Master File -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="reference_job_master_file">
            Reference Job / Master File if applicable
        </label>
        <br>


        
        <label style="background-color: lightgrey" class="upload-label">
            Current Reference Job / Master File Document: <br><span id="reference_job_master_file_document_filename"></span>
            
            <input type="file" name="reference_job_master_file_document" id="reference_job_master_file_document">

            <button type="button" onclick="clear_reference_job_master_file()">Clear File</button>
        </label>
    </div>

    <!-- Subtask 2.2: Concept Design -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="concept_design_engineering">
            Concept design & engineering details
        </label>
        <br>
        <label style="background-color: lightgrey" class="upload-label">
            Current Concept Design Document: <br><span id="concept_design_document_filename"></span>
            
            <input type="file" name="concept_design_document" id="concept_design_document">

            <button type="button" onclick="clear_concept_design_document()">Clear File</button>
        </label>
    </div>

    <!-- Subtask 2.3: Design Validation -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="design_validation_sign_off">
            Design sign off [calculations]
        </label>
        <br>
        <label style="background-color: lightgrey" class="upload-label">
            Current Design Validation Document: <br>  <span id="design_validation_document_filename"></span>
          
            <input type="file" name="design_validation_document" id="design_validation_document">

            <button type="button" onclick="clear_design_validation_document()">Clear File</button>
        </label>
    </div>

    <!-- Subtask 2.4: Customer Approval -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="customer_submittal_package">
            Customer submittal package
        </label>
        <br>
        <label style="background-color: lightgrey" class="upload-label">
            Current Customer Approval Document: <br>   <span id="customer_approval_document_filename"></span>
         
            <input type="file" name="customer_approval_document" id="customer_approval_document">

            <button type="button" onclick="clear_customer_approval_document()">Clear File</button>
        </label>
    </div>

    <!-- Subtask 2.5: Sample Approval -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="reference_approved_samples">
            Reference approved samples
        </label>
        <br>
        <label style="background-color: lightgrey" class="upload-label">
            Current Sample Approval Document: <br> <span id="sample_approval_document_filename"></span>
           
            <input type="file" name="sample_approval_document" id="sample_approval_document">

            <button type="button" onclick="claer_sample_approval_document()">Clear File</button>
        </label>
    </div>

    <!-- Sign-off for Main Task 2 -->
    <div class="form-group">
        <label>
            Sign-off for Engineering:
            <input type="text" name="sign_off_engineering" id="sign_off_engineering">
        </label>
    </div>

    <!-- Comments for Main Task 2 -->
    <div class="form-group">
        <label>
            Comments for Engineering:
            <textarea name="comments_engineering" id="comments_engineering" rows="4" cols="50"></textarea>
        </label>
    </div>

    <!-- Submit button -->
    <button type="submit" onclick="submitEngineeringForm()">Submit Engineering Form</button>
</fieldset>
<script>
  function clear_reference_job_master_file() {
    document.getElementById('reference_job_master_file_document').value = ''; // Clear the file input field
    document.getElementById('reference_job_master_file_document_filename').textContent = ''; // Clear the filename display
}

function clear_concept_design_document() {
    document.getElementById('concept_design_document').value = ''; // Clear the file input field
    document.getElementById('concept_design_document_filename').textContent = ''; // Clear the filename display
}

function clear_design_validation_document() {
    document.getElementById('design_validation_document').value = ''; // Clear the file input field
    document.getElementById('design_validation_document_filename').textContent = ''; // Clear the filename display
}

function clear_customer_approval_document() {
    document.getElementById('customer_approval_document').value = ''; // Clear the file input field
    document.getElementById('customer_approval_document_filename').textContent = ''; // Clear the filename display
}

function clear_sample_approval_document() {
    document.getElementById('sample_approval_document').value = ''; // Clear the file input field
    document.getElementById('sample_approval_document_filename').textContent = ''; // Clear the filename display
}


</script>