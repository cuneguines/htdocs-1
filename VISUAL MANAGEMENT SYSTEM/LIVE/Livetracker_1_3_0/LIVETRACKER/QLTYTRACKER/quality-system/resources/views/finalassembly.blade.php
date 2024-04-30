

    <fieldset>
    <legend>Final Assembly</legend>

    <!-- Process Order Number -->
    <div class="form-group">
        <label>
            <input type="text" name="process_order_number_finalassembly" id="process_order_number_finalassembly" readonly>
            Process Order Number
        </label>
    </div>

    <!-- Attach Part ID Labels / Name Plates -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="attach_part_id_labels">
            Attach Part ID Labels / Name Plates
        </label>
    </div>

    <!-- Sign-off for Final Assembly -->
    <div class="form-group">
        <label>
            Sign-off for Final Assembly:
            <input type="text" name="sign_off_final_assembly" value="${username}">
        </label>
    </div>

    <!-- Comments for Final Assembly -->
    <div class="form-group">
        <label>
            Comments for Final Assembly:
            <textarea name="comments_final_assembly" rows="4" cols="50"></textarea>
        </label>
    </div>

    <!-- Submit button -->
    <button type="button" onclick="submitFinalAssemblyForm('${processOrder}')">Submit Final Assembly Form</button>
</fieldset>
