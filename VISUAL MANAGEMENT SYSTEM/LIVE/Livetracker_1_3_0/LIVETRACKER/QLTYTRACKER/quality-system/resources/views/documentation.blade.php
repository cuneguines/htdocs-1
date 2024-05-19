<fieldset>
    <legend>Documentation</legend>
    <!-- Process Order Number -->
    <div class="form-group">
        <label>
            <input type="text" name="process_order_number_documentation" id="process_order_number_documentation"
                readonly>
            Process Order Number
        </label>
    </div>
    <!-- Subtask 12.1: Technical File -->
    <div class="form-group">
        <label>
        <input type="checkbox" name="technical_file_checkbox" value="1">
            Technical File:
           
        </label>
</div>
        <div class="form-group">
            <div id="technical_file_upload">
                <label>Upload New Technical File:</label>
                <input type="file" name="technical_file" id="technical_file" accept=".pdf,.doc,.docx,.txt">
                <button type="button" onclick="clearFile_tech()">Clear File</button>
            </div>
            <div>
                <label></label>
                <span id="old_technical_file"></span>
            </div>
        </div>

        <!-- Subtask 12.2: Client Hand-over documentation -->
        <div class="form-group">
            <label>
                <input type="checkbox" name="client_handover_checkbox" value="1">
                Client Hand-over documentation:

            </label>
            <div class="form-group">
                <div id="client_handover_upload">

                    <label>Upload New Client Hand-over Documentation:</label>
                    <input type="file" id="client_handover_documentation" name="client_handover_documentation"
                        accept=".pdf,.doc,.docx,.txt">
                    <button type="button" onclick="clearFile_client()">Clear File</button>
                </div>
                <div>

                    <span id="old_client_handover_documentation"></span>




                </div>
            </div>

            <!-- Engineer -->
            <div class="form-group">
                <label>
                    Sign_off_Engineer:
                    <input type="text" name="sign_off_engineer" id="sign_off_engineer" value="${username}">

                </label>
            </div>

            <div class="form-group">
        <label>
            Comments for Documentation:
            <textarea name="comments_documentation" id="comments_documentation" rows="4" cols="50"></textarea>
        </label>
    </div>

            <!-- Submit button -->
            <button type="button" onclick="submitDocumentationForm('${processOrder}')">Submit Documentation
                Form</button>
</fieldset>

<script>
function clearFile_tech() {
    document.getElementById('technical_file').value = '';
    document.getElementById('old_technical_file').textContent = '';



}

function clearFile_client() {
    document.getElementById('client_handover_documentation').value = '';
    document.getElementById('old_client_handover_documentation').textContent = '';
}
</script>