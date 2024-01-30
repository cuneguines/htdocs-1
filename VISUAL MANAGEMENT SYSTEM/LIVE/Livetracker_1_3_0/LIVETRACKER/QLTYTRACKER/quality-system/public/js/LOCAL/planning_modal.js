function generatePlanningFieldset() {
    return `
<fieldset>
    <legend>Main Task 1: Planning / Forward Engineering</legend>

    <!-- Subtask 1.1: Purchase Order -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="purchase_order_received">
            Purchase Order received
        </label>
        <br>
        <label class="upload-label">
            Upload Purchase Order Document:
            <input type="file" name="purchase_order_document">
        </label>
    </div>

    <!-- Subtask 1.2: Project Schedule -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="project_schedule_agreed">
            Project schedule agreed
        </label>
        <br>
        <label class="upload-label">
            Upload Project Schedule Document:
            <input type="file" name="project_schedule_document">
        </label>
    </div>

    <!-- Subtask 1.3: Quotation -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="quotation">
            Quotation
        </label>
        <br>
        <label class="upload-label">
            Upload Quotation Document:
            <input type="file" name="quotation_document">
        </label>
    </div>

    <!-- Subtask 1.4: User Requirement Specifications -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="verify_customer_expectations">
            Verify customer expectations
        </label>
        <br>
        <label class="upload-label">
            Upload User Requirement Specifications Document:
            <input type="file" name="user_requirement_specifications_document">
        </label>
    </div>

    <!-- Subtask 1.5: Pre Engineering Check -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="project_risk_category_assessment">
            Project risk category assessment
        </label>
        <br>
        <label class="upload-label">
            Upload Pre Engineering Check Document:
            <input type="file" name="pre_engineering_check_document">
        </label>
    </div>

    <!-- Sign-off for Main Task 1 -->
    <div class="form-group">
        <label>
            Sign-off for Planning / Forward Engineering:
            <input type="text" name="sign_off_planning">
        </label>
    </div>

    <!-- Comments for Main Task 1 -->
    <div class="form-group">
        <label>
            Comments for Planning / Forward Engineering:
            <textarea name="comments_planning" rows="4" cols="50"></textarea>
        </label>
    </div>

    <!-- Submit button -->
    <button type="submit" onclick="submitPlanningForm()">Submit Planning Form</button>
</fieldset> `;
}

function submitPlanningForm() {
    // Add your logic for submitting the Planning/Forward Engineering form
    console.log('Planning form submitted');
}
