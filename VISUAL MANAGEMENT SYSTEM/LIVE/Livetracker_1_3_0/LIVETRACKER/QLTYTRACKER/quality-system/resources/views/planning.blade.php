<fieldset>
                        <legend>Main Task 1: Planning / Forward Engineering</legend>
                        <div style="width:97%">
                        <!-- Process Order Number -->
                        <div class="form-group">
                            <label>
                            Process Order Number:
                                <input style="width:100%"type="text" name="process_order_number_planning" id="process_order_number_planning" readonly>
                               
                            </label>
                        </div>

                        <!-- Subtask 1.1: Purchase Order -->
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="purchase_order_received" id="purchase_order_received">
                                Purchase Order received
                            </label>
                            <br>
                            <label class="upload-label"
                                id="purchase_order_file_label">
                                Current Purchase Order Document: <br><br><span id="purchase_order_filename"></span>
                                <input type="file" name="purchase_order_document" id="purchase_order_document">
                                <button type="button" onclick="clear_purchase_order_document()">Clear File</button>
                            </label>
                        </div>

                        <!-- Subtask 1.2: Project Schedule -->
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="project_schedule_agreed" id="project_schedule_agreed">
                                Project schedule agreed
                            </label>
                            <br>
                            <label  class="upload-label"
                                id="project_schedule_file_label">
                                Current Project Schedule Document:<br> <br><span id="project_schedule_filename"></span>
                                <input type="file" name="project_schedule_document" id="project_schedule_document">
                                <button type="button" onclick="clear_project_schedule_document()">Clear File</button>
                            </label>
                        </div>

                        <!-- Subtask 1.3: Quotation -->
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="quotation" id="quotation">
                                Quotation
                            </label>
                            <br>
                            <label  class="upload-label" id="quotation_file_label">
                                Current Quotation Document: <br><br><span id="quotation_filename"></span>
                                <input type="file" name="quotation_document" id="quotation_document">
                                <button type="button" onclick="clear_quotation_document()">Clear File</button>
                            </label>
                        </div>

                        <!-- Subtask 1.4: User Requirement Specifications -->
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="verify_customer_expectations"
                                    id="verify_customer_expectations">
                                Verify customer expectations
                            </label>
                            <br>
                            <label  ;class="upload-label"
                                id="user_requirements_file_label">
                                Current User Requirement Specifications Document: <br><br><span
                                    id="user_requirements_filename"></span>
                                <input type="file" name="user_requirement_specifications_document"
                                    id="user_requirement_specifications_document">
                                    <button type="button" onclick="clear_user_requirement_specifications_document()">Clear File</button>
                            </label>
                        </div>

                        <!-- Subtask 1.5: Pre Engineering Check -->
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="project_risk_category_assessment"
                                    id="project_risk_category_assessment">
                                Project risk category assessment
                            </label>
                            <br>
                            <label class="upload-label"
                                id="pre_engineering_file_label">
                                Current Pre Engineering Check Document:<br><br> <span id="pre_engineering_filename"></span>
                                <input type="file" name="pre_engineering_check_document"
                                    id="pre_engineering_check_document">
                                    <button type="button" onclick="clear_pre_engineering_check_document()">Clear File</button>
                            </label>
                        </div>

                        <!-- Sign-off for Main Task 1 -->
                        <div class="form-group">
                            <label>
                                Sign-off for Planning / Forward Engineering:
                                <input style="width:100%"type="text" name="sign_off_planning" id="sign_off_planning">
                            </label>
                        </div>

                        <!-- Comments for Main Task 1 -->
                        <div class="form-group">
                            <label>
                                Comments for Planning / Forward Engineering:
                                <textarea style="width:100%"name="comments_planning" id="comments_planning" rows="4" cols="50"></textarea>
                            </label>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" onclick="submitPlanningForm()">Submit Planning Form</button>
                                </div>
                    </fieldset>
                    <script>
    function clear_purchase_order_document() {
        document.getElementById('purchase_order_document').value = ''; // Clear the file input field
        document.getElementById('purchase_order_filename').textContent = ''; // Clear the filename display
    }

    function clear_project_schedule_document() {
        document.getElementById('project_schedule_document').value = ''; // Clear the file input field
        document.getElementById('project_schedule_filename').textContent = ''; // Clear the filename display
    }

    function clear_quotation_document() {
        document.getElementById('quotation_document').value = ''; // Clear the file input field
        document.getElementById('quotation_filename').textContent = ''; // Clear the filename display
    }

    function clear_user_requirement_specifications_document() {
        document.getElementById('user_requirement_specifications_document').value = ''; // Clear the file input field
        document.getElementById('user_requirements_filename').textContent = ''; // Clear the filename display
    }

    function clear_pre_engineering_check_document() {
        document.getElementById('pre_engineering_check_document').value = ''; // Clear the file input field
        document.getElementById('pre_engineering_filename').textContent = ''; // Clear the filename display
    }
</script>
