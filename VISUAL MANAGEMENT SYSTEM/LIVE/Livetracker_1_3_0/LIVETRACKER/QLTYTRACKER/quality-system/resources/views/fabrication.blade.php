<fieldset>
    <legend>Fabrication Fit-Up</legend>
    <div style="width:98%">
    <div class="form-group">
        <label>Process Order Number:
            <input style="width:100%" type="text" name="process_order_number_fabrication_fit_up" id="process_order_number_fabrication_fit_up" readonly>
            
        </label>
    </div>
    <!-- Subtask 6.1: Fit-up -->
    <div class="form-group">
        
    <label>
    <input type="checkbox" name="fit_up_visual_check">
        Fit-up: Visual check fit up - first off</label>
        
    </div>

    <!-- Subtask 6.2: Dimensional check -->
    <div class="form-group">
    <label>
    <input type="checkbox" name="dimensional_check">
        Dimensional check: Dimensional check first off</label>
        
        <!-- Upload File -->
        <label class="upload-label">Link to Drawing: <br><br>
            <span id="old_drawing_filename"></span> <!-- Span for old file name -->
            <input type="file" name="link_to_drawing" id="link_to_drawing" required><br>
            <button type="button" onclick="clear_link_to_drawing()">Clear File</button>
        </label>
    </div>

    <!-- Subtask 6.3: Weldment quantity -->
    <div class="form-group">
    <label>
    <br>
    <input type="checkbox" name="weldment_quantity">
        Weld Check</label>
    </div>

    <!-- Sign-off for Fabrication Fit-Up -->
    <div class="form-group">
    <label> Sign-off for Fabrication Fit-Up:
    <input style="width:100%" type="text" name="sign_off_fabrication_fit_up" value="${username}">
       </label>
        
    </div>

    <!-- Comments for Fabrication Fit-Up -->
    <div class="form-group">
        <label>Comments for Fabrication Fit-Up:</label>
        <textarea style="width:100%"name="comments_fabrication_fit_up" rows="4" cols="50"></textarea>
    </div>

    <!-- Submit button -->
    <button type="submit" onclick="submitFabricationFitUpForm('${processOrder}')">Submit Fabrication Fit-Up
        Form</button>
</div>
</fieldset>
<script>
function clear_link_to_drawing() {
    document.getElementById('link_to_drawing').value = ''; // Clear the file input field
    document.getElementById('old_drawing_filename').textContent = ''; // Clear the filename display
}
</script>