<fieldset>
    <legend>Main Task 4: Material Preparation</legend>
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
            <input type="text" name="material_identification" id="material_identification">
        </label>
    </div>

    <!-- Subtask 4.2: Material Identification Record -->
    <div class="form-group">
        <label>
            Material Identification Record: 3.1 Mill Test Certificate [EN 1024]
            <input type="text" name="material_identification_record" id="material_identification_record">
        </label>
        <label class="upload-label">
            Upload Material Identification Record:
            <input type="file" name="material_identification_record_file">
            <span id="old-file-name_1"></span> <!-- Space for old file name -->
        </label>
    </div>

    <!-- Subtask 4.3: Material Traceability -->
    <div class="form-group">
        <label>
            Material Traceability: Heat Number
            <input type="text" name="material_traceability" id="material_traceability">
        </label>
        <label class="upload-label">
            Upload Material Traceability Document:
            <input type="file" name="material_traceability_file">
            <span id="old-file-name_2"></span> <!-- Space for old file name -->
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
            <input type="text" name="sign_off_material_preparation">
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
    <button type="submit" onclick="submitMaterialPreparationForm('${processOrder}')">Submit Material Preparation Form</button>
</fieldset>
