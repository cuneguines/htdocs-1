<fieldset>
    <legend>Main Task 3: Manufacturing</legend>

    <!-- Process Order Number -->
    <div class="form-group">
        <label>
            <input type="text" name="process_order_number_manufacturing" id="process_order_number_manufacturing" readonly>
            Process Order Number
        </label>
    </div>

    <!-- Subtask 3.1: Production Drawings -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="production_drawings">
            Production Drawings
        </label>
        <br>
        <label style="background-color: lightgrey" class="upload-label">
            Current Production Drawings Document: <br>
            <span id="production_drawings_filename"></span>
            <input type="file" name="production_drawings_document" id="production_drawings_document">
        </label>
    </div>

    <!-- Subtask 3.2: BOM -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="bom">
            BOM
        </label>
        <br>
        <label style="background-color: lightgrey" class="upload-label">
            Current BOM Document: <br>
            <span id="bom_filename"></span>
            <input type="file" name="bom_document" id="bom_document">
        </label>
    </div>

    <!-- Subtask 3.3: Machine Programming Files -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="machine_programming_files">
            Machine Programming Files
        </label>
        <br>
        <label style="background-color: lightgrey" class="upload-label">
            Current Machine Programming Files Document: <br>
            <span id="machine_programming_files_filename"></span>
            <input type="file" name="machine_programming_files_document" id="machine_programming_files_document">
        </label>
    </div>

    <!-- Subtask 3.4: NDT Documentation -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="ndt_documentation">
            NDT Documentation
        </label>
        <br>
        <label style="background-color: lightgrey" class="upload-label">
            Current NDT Documentation Document: <br>
            <span id="ndt_documentation_filename"></span>
            <input type="file" name="ndt_documentation_document" id="ndt_documentation_document">
        </label>
    </div>

    <!-- Subtask 3.5: Quality Documents -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="quality_documents">
            Quality Documents
        </label>
        <br>
        <label style="background-color: lightgrey" class="upload-label">
            Current Quality Documents Document: <br>
            <span id="quality_documents_filename"></span>
            <input type="file" name="quality_documents_document" id="quality_documents_document">
        </label>
    </div>

    <!-- Sign-off for Main Task 3 -->
    <div class="form-group">
        <label>
            Sign-off for Manufacturing:
            <input type="text" name="sign_off_manufacturing" id="sign_off_manufacturing">
        </label>
    </div>

    <!-- Comments for Main Task 3 -->
    <div class="form-group">
        <label>
            Comments for Manufacturing:
            <textarea name="comments_manufacturing" id="comments_manufacturing" rows="4" cols="50"></textarea>
        </label>
    </div>

    

    <!-- Submit button -->
    <button type="submit" onclick="submitManufacturingForm()">Submit Manufacturing Form</button>
</fieldset>