
    <fieldset>
    <legend>Testing</legend>
    <div class="form-group">
        <label>
            <input type="text" name="process_order_number_testing" id="process_order_number_testing" readonly>
            Process Order Number
        </label>
    </div>
    <!-- Subtask 8.1: Dye Penetrant Procedure -->
    <div class="form-group">
        <label>
            Dye Penetrant Procedure:
            <input type="checkbox" name="dye_pen_test" onchange="toggleDropdown(this, 'dye_pen_document_ref')">
            <select name="dye_pen_document_ref" disabled>
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
            <select name="hydrostatic_test_document_ref" disabled>
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
            <select name="pneumatic_test_document_ref" disabled>
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
            <select name="fat_protocol_document_ref" disabled>
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
            <input type="file" name="testing_documents" id="testing_documents"multiple>
        </label>
        </label>
    <span id="old_testing_documents">Old Document Name</span>
    </div>

    <!-- Sign-off for Testing -->
    <div class="form-group">
        <label>
            Sign-off for Testing:
            <input type="text" name="sign_off_testing" value="${username}">
        </label>
    </div>

    <!-- Comments for Testing -->
    <div class="form-group">
        <label>
            Comments for Testing:
            <textarea name="comments_testing" rows="4" cols="50"></textarea>
        </label>
    </div>

    <!-- Submit button -->
    <button type="button" onclick="submitTestingForm('${processOrder}')">Submit Testing Form</button>
</fieldset>
    