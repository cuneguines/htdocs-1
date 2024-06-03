
    <fieldset>
    <legend>Testing</legend>
    <div style="width:97%">
    <div class="form-group">
        <label>
        Process Order Number:
            <input style="width:100%"type="text" name="process_order_number_testing" id="process_order_number_testing" readonly>
          
        </label>
    </div>
    <!-- Subtask 8.1: Dye Penetrant Procedure -->
    <div class="form-group">
        <label>
            Dye Penetrant Procedure:
            <input type="checkbox" name="dye_pen_test" onchange="toggleDropdown(this, 'dye_pen_document_ref')">
            <select style="width:100%"name="dye_pen_document_ref" disabled>
            <option value="NULL">NULL</option>
            
                <option value="PED Standard">PED Standard</option>
                <option value="ASME Standard">ASME Standard</option>
                <option value="Leak Through Test">Leak Through Test</option>
                <!-- Add more options as needed -->
            </select>
        </label>
    </div>

    <!-- Subtask 8.2: Hydrostatic Leak Test -->
    <div class="form-group">
        <label>
            Hydrostatic Leak Test:
            <input type="checkbox" name="hydrostatic_test" onchange="toggleDropdown(this, 'hydrostatic_test_document_ref')">
            <select style="width:100%"name="hydrostatic_test_document_ref" disabled>
            <option value="NULL">NULL</option>
                <option value="KS-HD-01">KS-HD-01</option>
               
                <!-- Add more options as needed -->
            </select>
        </label>
    </div>

    <!-- Subtask 8.3: Pneumatic Leak Test -->
    <div class="form-group">
        <label>
            Pneumatic Leak Test:
            <input type="checkbox" name="pneumatic_test" onchange="toggleDropdown(this, 'pneumatic_test_document_ref')">
            <select style="width:100%"name="pneumatic_test_document_ref" disabled>
            <option value="NULL">NULL</option>
                <option value="KS-PN-01">KS-PN-01</option>
               
                <!-- Add more options as needed -->
            </select>
        </label>
    </div>

    <!-- Subtask 8.4: FAT -->
    <div class="form-group">
        <label>
            FAT:
            <input type="checkbox" name="fat_protocol" onchange="toggleDropdown(this, 'fat_protocol_document_ref')">
            <select style="width:100%" name="fat_protocol_document_ref" disabled>
            <option value="NULL">NULL</option>
 


                <option value="QF-0226">QF-0226</option>
                <option value="Custom">Custom</option>
                
                <!-- Add more options as needed -->
            </select>
        </label>
    </div>

    <!-- Upload Testing Documents -->
    <div class="form-group">
        <label>
            Upload Testing Documents:
            <input type="file" name="testing_documents" id="testing_documents"multiple><br>
        </label>
        </label>
    <span id="old_testing_documents">Old Document Name</span>
    <button type="button" onclick="clear_testing_documents()">Clear File</button>
    </div>

    <!-- Sign-off for Testing -->
    <div class="form-group">
        <label>
            Sign-off for Testing:
            <input style="width:100%"type="text" name="sign_off_testing" value="${username}">
        </label>
    </div>

    <!-- Comments for Testing -->
    <div class="form-group">
        <label>
            Comments for Testing:
            <textarea style="width:100%"name="comments_testing" rows="4" cols="50"></textarea>
        </label>
    </div>

    <!-- Submit button -->
    <button type="button" onclick="submitTestingForm('${processOrder}')">Submit Testing Form</button>
            </div>
</fieldset>
<script>
function clear_testing_documents() {
    var input = document.getElementById('testing_documents');
    var oldDocuments = document.getElementById('old_testing_documents');

    // Clear the file input field
    input.value = '';

    // Clear the old document display
    oldDocuments.textContent = '';
    
}
</script>