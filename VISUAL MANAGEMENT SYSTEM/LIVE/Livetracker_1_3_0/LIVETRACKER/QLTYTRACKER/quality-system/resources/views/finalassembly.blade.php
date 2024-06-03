

    <fieldset>
    <legend>Final Assembly</legend>
    <div style="width:98%">
    <!-- Process Order Number -->
    <div class="form-group">
        <label>
        Process Order Number:
            <input style="width:100%"type="text" name="process_order_number_finalassembly" id="process_order_number_finalassembly" readonly>
           
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
            <input style="width:100%"type="text" name="sign_off_final_assembly" value="${username}">
        </label>
    </div>

    <!-- Comments for Final Assembly -->
    <div class="form-group">
        <label>
            Comments for Final Assembly:
            <textarea style="width:100%"name="comments_final_assembly" rows="4" cols="50"></textarea>
        </label>
    </div>

    <!-- Submit button -->
    <button type="button" onclick="submitFinalAssemblyForm('${processOrder}')">Submit Final Assembly Form</button>
    </div>
</fieldset>
