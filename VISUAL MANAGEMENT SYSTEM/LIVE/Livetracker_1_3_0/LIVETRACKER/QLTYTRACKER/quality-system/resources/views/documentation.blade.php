
<fieldset>
    <legend>Documentation</legend>
 <!-- Process Order Number -->
 <div class="form-group">
        <label>
            <input type="text" name="process_order_number_documentation" id="process_order_number_documentation" readonly>
            Process Order Number
        </label>
    </div>
    <!-- Subtask 12.1: Technical File -->
    <div class="form-group">
        <label>
            Technical File:
            <input type="checkbox" name="technical_file_checkbox" value="1" onclick="toggleFileUpload('technical_file_upload', this)">
        </label>
        <div id="technical_file_upload" style="display: none;">
            <label>Upload New Technical File:</label>
            <input type="file" name="technical_file" accept=".pdf,.doc,.docx,.txt">
        </div>
        <div>
            <label></label>
            <span id="old_technical_file"></span>
        </div>
    </div>

    <!-- Subtask 12.2: Client Hand-over documentation -->
    <div class="form-group">
        <label>
            Client Hand-over documentation:
            <input type="checkbox" name="client_handover_checkbox" value="1" onclick="toggleFileUpload('client_handover_upload', this)">
        </label>
        <div id="client_handover_upload" style="display: none;">
            <label>Upload New Client Hand-over Documentation:</label>
            <input type="file" name="client_handover_documentation" accept=".pdf,.doc,.docx,.txt">
        </div>
        <div>
            
            <span id="old_client_handover_documentation"></span>
        </div>
    </div>

    <!-- Engineer -->
    <div class="form-group">
        <label>
            Sign_off_Engineer:
            <input type="text" name="sign_off_engineer" id="sign_off_engineer"value="${username}">
        </label>
    </div>

    <!-- Process Order -->
    <div class="form-group">
        <label>
            Process Order:
            <input type="text" name="process_order" value="">
        </label>
    </div>

    <!-- Submit button -->
    <button type="button" onclick="submitDocumentationForm('${processOrder}')">Submit Documentation Form</button>
</fieldset>

<script>
    function toggleFileUpload(elementId, checkbox) {
        var uploadDiv = document.getElementById(elementId);
        if (checkbox.checked) {
            uploadDiv.style.display = "block";
        } else {
            uploadDiv.style.display = "none";
        }
    }
</script>

    <script>
    function toggleFileUpload(elementId, checkbox) {
    var uploadDiv = document.getElementById(elementId);
    if (checkbox.checked) {
        uploadDiv.style.display = "block";
    } else {
        uploadDiv.style.display = "none";
    }
}
</script>