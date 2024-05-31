<fieldset>
    <legend>Main Task 3: Kitting</legend>
<div style="width:97%">
    <!-- Process Order Number -->
    <div class="form-group">
        <label>
        Process Order Number
        <br>
            <input style="width:100%"type="text" name="process_order_number_kitting" id="process_order_number_kitting" readonly>
            
        </label>
    </div>

    <!-- Subtask 3.1: Cut Formed Machine Parts -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="cut_form_mach_parts">
            Cut Formed Machine Parts
        </label>
    </div>

    <!-- Subtask 3.2: Bought Out Components -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="bought_out_components">
            Bought Out Components
        </label>
    </div>

    <!-- Subtask 3.3: Fasteners and Fixings -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="fasteners_fixings">
            Fasteners and Fixings
        </label>
    </div>

    <!-- Subtask 3.4: Site Pack -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="site_pack">
            Site Pack
        </label>
    </div>

    <!-- Upload File -->
    <div class="form-group">
        <label class="upload-label">
            Current Kitting File: <br><br>
            <span id="kitting_file_filename"></span>
            <input type="file" name="kitting_file_document" id="kitting_file_document">
            <button type="button" onclick="clear_kitting_file_document()">Clear File</button>
        </label>
    </div>

    <!-- Sign-off for Main Task 3 -->
    <div class="form-group">
        <label>
            Sign-off for Kitting:
            <input style="width:100%"type="text" name="sign_off_kitting" id="sign_off_kitting" value="${username}">
        </label>
    </div>

    <!-- Comments for Main Task 3 -->
    <div class="form-group">
        <label>
            Comments for Kitting:
            <textarea style="width:100%"name="comments_kitting" id="comments_kitting" rows="4" cols="50"></textarea>
        </label>
    </div>

    <!-- Submit button -->
    <button type="button" onclick="submitKittingForm()">Submit Kitting Form</button>
            </div>
</fieldset>
<script>
    function clear_kitting_file_document() {
        document.getElementById('kitting_file_document').value = ''; // Clear the file input field
        document.getElementById('kitting_file_filename').textContent = ''; // Clear the filename display
    }
</script>
