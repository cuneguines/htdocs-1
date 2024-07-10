

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Planning / Forward Engineering</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse; 
            font-size: 13px;
        }
        td {
            padding: 10px;
            text-align: left; /* Align content to the left */
            border: 1px solid black;
        }
        .form-group {
            display: flex; 
            align-items: center;
            border:none;
        }
        .form-group input[type="checkbox"] {
            margin-right: 10px;
        }
        .form-group label {
            flex: 1;
        }
    </style>
</head>
<body>
    <fieldset>
        <legend>Engineering:</legend>
        <div style="width:98%">
            <table>
                <tr>
                    <td>Process Order Number:</td>
                    <td colspan="3">
                        <input style="width:100%" type="text" name="process_order_number_engineering" id="process_order_number_engineering" readonly>
                    </td>
                </tr>
            </table>
            <table id="engineering">
                <thead>
                    <tr>
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="form-group">
                            <input type="checkbox" name="reference_job_master_file" id="reference_job_master_file">
                            Reference Job / Master File if applicable
                        </td>
                        <td>
                            Current Reference Job / Master File Document:<br><span id="reference_job_master_file_document_filename"></span>
                            <input type="file" name="reference_job_master_file_document" id="reference_job_master_file_document">
                            <button type="button" onclick="clear_reference_job_master_file()">Clear File</button>
                        </td>
                        <td>
                            <select name="owner" id="owner" style="width:100%">
                                <option value="NULL">Select Owner</option>
                                <option value="PM">PM</option>
                                <option value="QA">QA</option>
                                <option value="Planning">Planning</option>
                                <option value="Operator">Operator</option>
                                <option value="Kitting">Kitting</option>
                                <option value="Fabricator">Fabricator</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="RWC">RWC</option>
                                <option value="Goods In">Goods In</option>
                                <option value="Goods Out">Goods Out</option>
                                <option value="Client">Client</option>





                                
                            </select>
                        </td>
                        <td>
                      
                            <select name="ndttype" id="ndttype" style="width:100%">
                                <option value="NULL">Select Inpection Type</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <option value="Hold">Hold</option>
                            
                            
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-group">
                            <input type="checkbox" name="concept_design_engineering" id="concept_design_engineering">
                            Concept design & engineering details
                        </td>
                        <td>
                            Current Concept Design Document:<br><span id="concept_design_document_filename"></span>
                            <input type="file" name="concept_design_document" id="concept_design_document">
                            <button type="button" onclick="clear_concept_design_document()">Clear File</button>
                        </td>
                        <td>
                            <select name="owner" id="owner" style="width:100%">
                                <option value="NULL">Select Owner</option>
                                <option value="PM">PM</option>
                                <option value="QA">QA</option>
                                <option value="Planning">Planning</option>
                                <option value="Operator">Operator</option>
                                <option value="Kitting">Kitting</option>
                                <option value="Fabricator">Fabricator</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="RWC">RWC</option>
                                <option value="Goods In">Goods In</option>
                                <option value="Goods Out">Goods Out</option>
                                <option value="Client">Client</option>





                                
                            </select>
                        </td>
                        <td>
                      
                            <select name="ndttype" id="ndttype" style="width:100%">
                                <option value="NULL">Select Inpection Type</option>
                                <option value="Approve">Approve</option>
                                <option value="Inpect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <option value="Hold">Hold</option>
                            
                            
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-group">
                            <input type="checkbox" name="design_validation_sign_off" id="design_validation_sign_off">
                            Design sign off [calculations]
                        </td>
                        <td>
                            Current Design Validation Document:<br><span id="design_validation_document_filename"></span>
                            <input type="file" name="design_validation_document" id="design_validation_document">
                            <button type="button" onclick="clear_design_validation_document()">Clear File</button>
                        </td>
                        <td>
                            <select name="owner" id="owner" style="width:100%">
                                <option value="NULL">Select Owner</option>
                                <option value="PM">PM</option>
                                <option value="QA">QA</option>
                                <option value="Planning">Planning</option>
                                <option value="Operator">Operator</option>
                                <option value="Kitting">Kitting</option>
                                <option value="Fabricator">Fabricator</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="RWC">RWC</option>
                                <option value="Goods In">Goods In</option>
                                <option value="Goods Out">Goods Out</option>
                                <option value="Client">Client</option>





                                
                            </select>
                        </td>
                        <td>
                      
                            <select name="ndttype" id="ndttype" style="width:100%">
                                <option value="NULL">Select Inpection Type</option>
                                <option value="Approve">Approve</option>
                                <option value="Inpect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <option value="Hold">Hold</option>
                            
                            
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-group">
                            <input type="checkbox" name="customer_submittal_package" id="customer_submittal_package">
                            Customer submittal package
                        </td>
                        <td>
                            Current Customer Approval Document:<br><span id="customer_approval_document_filename"></span>
                            <input type="file" name="customer_approval_document" id="customer_approval_document">
                            <button type="button" onclick="clear_customer_approval_document()">Clear File</button>
                        </td>
                        <td>
                            <select name="owner" id="owner" style="width:100%">
                                <option value="NULL">Select Owner</option>
                                <option value="PM">PM</option>
                                <option value="QA">QA</option>
                                <option value="Planning">Planning</option>
                                <option value="Operator">Operator</option>
                                <option value="Kitting">Kitting</option>
                                <option value="Fabricator">Fabricator</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="RWC">RWC</option>
                                <option value="Goods In">Goods In</option>
                                <option value="Goods Out">Goods Out</option>
                                <option value="Client">Client</option>





                                
                            </select>
                        </td>
                        <td>
                      
                            <select name="ndttype" id="ndttype" style="width:100%">
                                <option value="NULL">Select Inpection Type</option>
                                <option value="Approve">Approve</option>
                                <option value="Inpect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <option value="Hold">Hold</option>
                            
                            
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-group">
                            <input type="checkbox" name="reference_approved_samples" id="reference_approved_samples">
                            Reference approved samples
                        </td>
                        <td>
                            Current Sample Approval Document:<br><span id="sample_approval_document_filename"></span>
                            <input type="file" name="sample_approval_document" id="sample_approval_document">
                            <button type="button" onclick="clear_sample_approval_document()">Clear File</button>
                        </td>
                        <td>
                            <select name="owner" id="owner" style="width:100%">
                                <option value="NULL">Select Owner</option>
                                <option value="PM">PM</option>
                                <option value="QA">QA</option>
                                <option value="Planning">Planning</option>
                                <option value="Operator">Operator</option>
                                <option value="Kitting">Kitting</option>
                                <option value="Fabricator">Fabricator</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="RWC">RWC</option>
                                <option value="Goods In">Goods In</option>
                                <option value="Goods Out">Goods Out</option>
                                <option value="Client">Client</option>





                                
                            </select>
                        </td>
                        <td>
                      
                            <select name="ndttype" id="ndttype" style="width:100%">
                                <option value="NULL">Select Inpection Type</option>
                                <option value="Approve">Approve</option>
                                <option value="Inpect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <option value="Hold">Hold</option>
                            
                            
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <label>Sign-off for Engineering:
                    <input style="width:100%" type="text" name="sign_off_engineering" id="sign_off_engineering">
                </label>
            </div>
            <div class="form-group">
                <label>Comments for Engineering:
                    <textarea style="width:100%" name="comments_engineering" id="comments_engineering" rows="4" cols="50"></textarea>
                </label>
            </div>
            <div>
                <button type="submit" onclick="submitEngineeringForm()">Submit Engineering Form</button>
            </div>
        </div>
    </fieldset>

    <script>
        function clear_reference_job_master_file() {
            document.getElementById('reference_job_master_file_document').value = ''; // Clear the file input field
            document.getElementById('reference_job_master_file_document_filename').textContent = ''; // Clear the filename display
        }

        function clear_concept_design_document() {
            document.getElementById('concept_design_document').value = ''; // Clear the file input field
            document.getElementById('concept_design_document_filename').textContent = ''; // Clear the filename display
        }

        function clear_design_validation_document() {
            document.getElementById('design_validation_document').value = ''; // Clear the file input field
            document.getElementById('design_validation_document_filename').textContent = ''; // Clear the filename display
        }

        function clear_customer_approval_document() {
            document.getElementById('customer_approval_document').value = ''; // Clear the file input field
            document.getElementById('customer_approval_document_filename').textContent = ''; // Clear the filename display
        }

        function clear_sample_approval_document() {
            document.getElementById('sample_approval_document').value = ''; // Clear the file input field
            document.getElementById('sample_approval_document_filename').textContent = ''; // Clear the filename display
        }
    </script>
</body>
</html>
