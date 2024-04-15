<fieldset>
                        <legend>Main Task 1: Planning / Forward Engineering</legend>

                        <!-- Process Order Number -->
                        <div class="form-group">
                            <label>
                                <input type="text" name="process_order_number" id="process_order_number" readonly>
                                Process Order Number
                            </label>
                        </div>

                        <!-- Subtask 1.1: Purchase Order -->
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="purchase_order_received" id="purchase_order_received">
                                Purchase Order received
                            </label>
                            <br>
                            <label style="background-color: lightgrey" class="upload-label"
                                id="purchase_order_file_label">
                                Current Purchase Order Document: <br><span id="purchase_order_filename"></span>
                                <input type="file" name="purchase_order_document" id="purchase_order_document">
                            </label>
                        </div>

                        <!-- Subtask 1.2: Project Schedule -->
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="project_schedule_agreed" id="project_schedule_agreed">
                                Project schedule agreed
                            </label>
                            <br>
                            <label style="background-color: lightgrey" class="upload-label"
                                id="project_schedule_file_label">
                                Current Project Schedule Document:<br> <span id="project_schedule_filename"></span>
                                <input type="file" name="project_schedule_document" id="project_schedule_document">
                            </label>
                        </div>

                        <!-- Subtask 1.3: Quotation -->
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="quotation" id="quotation">
                                Quotation
                            </label>
                            <br>
                            <label style="background-color: lightgrey" class="upload-label" id="quotation_file_label">
                                Current Quotation Document: <br><span id="quotation_filename"></span>
                                <input type="file" name="quotation_document" id="quotation_document">
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
                            <label style="background-color: lightgrey" ;class="upload-label"
                                id="user_requirements_file_label">
                                Current User Requirement Specifications Document: <br><span
                                    id="user_requirements_filename"></span>
                                <input type="file" name="user_requirement_specifications_document"
                                    id="user_requirement_specifications_document">
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
                            <label style="background-color: lightgrey" class="upload-label"
                                id="pre_engineering_file_label">
                                Current Pre Engineering Check Document:<br> <span id="pre_engineering_filename"></span>
                                <input type="file" name="pre_engineering_check_document"
                                    id="pre_engineering_check_document">
                            </label>
                        </div>

                        <!-- Sign-off for Main Task 1 -->
                        <div class="form-group">
                            <label>
                                Sign-off for Planning / Forward Engineering:
                                <input type="text" name="sign_off_planning" id="sign_off_planning">
                            </label>
                        </div>

                        <!-- Comments for Main Task 1 -->
                        <div class="form-group">
                            <label>
                                Comments for Planning / Forward Engineering:
                                <textarea name="comments_planning" id="comments_planning" rows="4" cols="50"></textarea>
                            </label>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" onclick="submitPlanningForm()">Submit Planning Form</button>
                    </fieldset>