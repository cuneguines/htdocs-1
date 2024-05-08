<fieldset>
    <legend>Main Task 4: Material Preparation</legend>

    <!-- Process Order Number -->
    <div class="form-group">
        <label>
            <input type="text" name="process_order_number_mp" id="process_order_number_mp" readonly>
            Process Order Number
        </label>
    </div>

    <!-- Subtask 4.1: Material Identification -->
    <div class="form-group">
        <label>
            Material Identification: Confirm grade, thickness
            <input type="checkbox" name="material_identification">
        </label>
    </div>

    <!-- Subtask 4.2: Material Identification Record -->
    <div class="form-group">
        <label>
            Current Material Identification Cert: <span id="old-file-name_3"></span><br>
            Upload Material Identification Record: 3.1 Mill Test Certificate [EN 1024]
            <input type="file" name="material_identification_record">
            <button type="button" onclick="clear_material_identification_cert_file()">Clear File</button>
        </label>
</div>
        <div class="form-group">
        <label class="upload-label">
            Current Material Identification Record: <span id="old-file-name_1"></span><br>
            Upload New Material Identification Record:
            <input type="file" name="material_identification_record_file">
            <button type="button" onclick="clear_material_identification_record_file()">Clear File</button>
        </label>
        
    </div>

    <!-- Subtask 4.3: Material Traceability -->
    <div class="form-group">
        <label>
            Material Traceability: Purchase Order Number
            <input type="checkbox" name="material_traceability">
        </label>
        <label class="upload-label">
            Current Material Traceability Document: <span id="old-file-name_2"></span><br>
            Upload New Material Traceability Document:
            <input type="file" name="material_traceability_file">
            <button type="button" onclick="clear_material_traceability_file()">Clear File</button>
        </label>
    </div>

    <!-- Subtask 4.4: Cutting -->
    <div class="form-group">
        <label>
            Cutting: Part geometry, cut quality, part qty
            <input type="checkbox" name="cutting">
        </label>
    </div>

    <!-- Subtask 4.5: De-burring -->
    <div class="form-group">
        <label>
            De-burring: No sharp edges
            <input type="checkbox" name="deburring">
        </label>
    </div>

    <!-- Subtask 4.6: Forming -->
    <div class="form-group">
        <label>
            Forming: Part geometry, part qty
            <input type="checkbox" name="forming">
        </label>
    </div>

    <!-- Subtask 4.7: Machining -->
    <div class="form-group">
        <label>
            Machining: Part geometry, part qty
            <input type="checkbox" name="machining">
        </label>
    </div>

    <!-- Sign-off for Main Task 4 -->
    <div class="form-group">
        <label>
            Sign-off for Material Preparation:
            <input type="text" id="sign_off_material_preparation" name="sign_off_material_preparation" value="${username}">
        </label>
    </div>

    <!-- Comments for Main Task 4 -->
    <div class="form-group">
        <label>
            Comments for Material Preparation:
            <textarea name="comments_material_preparation" rows="4" cols="50"></textarea>
        </label>
    </div>

    <!-- Submit button -->
    <button type="submit" onclick="submitMaterialPreparationForm()">Submit Material Preparation Form</button>
</fieldset>
<script>
    function clear_material_identification_record_file() {
        document.querySelector('input[name="material_identification_record_file"]').value = ''; // Clear the file input field
        document.getElementById('old-file-name_1').textContent = ''; // Clear the filename display
    }
    function clear_material_identification_cert_file() {
        document.querySelector('input[name="material_identification_record"]').value = ''; // Clear the file input field
        document.getElementById('old-file-name_3').textContent = ''; // Clear the filename display
    }

    function clear_material_traceability_file() {
        document.querySelector('input[name="material_traceability_file"]').value = ''; // Clear the file input field
        document.getElementById('old-file-name_2').textContent = ''; // Clear the filename display
    }
</script>
