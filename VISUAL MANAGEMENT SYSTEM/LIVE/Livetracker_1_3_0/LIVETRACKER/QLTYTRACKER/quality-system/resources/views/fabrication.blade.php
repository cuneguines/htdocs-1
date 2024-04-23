<fieldset>
    <legend>Fabrication Fit-Up</legend>
    <div class="form-group">
        <label>
            <input type="text" name="process_order_number_fabrication_fit_up" id="process_order_number_fabrication_fit_up" readonly>
            Process Order Number
        </label>
    </div>
    <!-- Subtask 6.1: Fit-up -->
    <div class="form-group">
        <label>Fit-up: Visual check fit up - first off</label>
        <input type="checkbox" name="fit_up_visual_check">
    </div>

    <!-- Subtask 6.2: Dimensional check -->
    <div class="form-group">
        <label>Dimensional check: Dimensional check first off</label>
        <input type="checkbox" name="dimensional_check">
        <!-- Upload File -->
        <label class="upload-label">Link to Drawing: <br>
            <span id="old_drawing_filename"></span> <!-- Span for old file name -->
            <input type="file" name="link_to_drawing" id="link_to_drawing" required>
        </label>
    </div>

    <!-- Subtask 6.3: Weldment quantity -->
    <div class="form-group">
        <label>Weldment quantity: Check qty against Process Order</label>
        <input type="checkbox" name="weldment_quantity">
    </div>

    <!-- Sign-off for Fabrication Fit-Up -->
    <div class="form-group">
        <label>Sign-off for Fabrication Fit-Up:</label>
        <input type="text" name="sign_off_fabrication_fit_up" value="${username}">
    </div>

    <!-- Comments for Fabrication Fit-Up -->
    <div class="form-group">
        <label>Comments for Fabrication Fit-Up:</label>
        <textarea name="comments_fabrication_fit_up" rows="4" cols="50"></textarea>
    </div>

    <!-- Submit button -->
    <button type="submit" onclick="submitFabricationFitUpForm('${processOrder}')">Submit Fabrication Fit-Up
        Form</button>
</fieldset>