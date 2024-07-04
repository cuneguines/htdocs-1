<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Planning / Forward Engineering</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse; 
            font-size:13px;
        }
        td {
             padding: 10px;
        }
        .form-group {
        display: flex; 
            align-items: center;
        }
        .form-group input[type="checkbox"] {
            margin-right: 10px;
        }
        .form-group label {
            flex: 1;


        }
        tr,td
        {
        border: 1px solid black;
        }
td {
    padding: 10px;
    text-align: left; /* Align content to the left */
}
        
    </style>
</head>
<body>
   
  
        
        <div style="width:98%">
        <table>
            <tr>
                <td>Process Order Number:</td>
                <td colspan="3">
                    <input style="width:100%" type="text" name="process_order_number_planning" id="process_order_number_planning" readonly>
                </td>
            </tr>
    </td>
    </table>
    <table id="planning">
        <thead>
            <tr>
            <th>1
    </th>
    <th>2
    </th>
    <th>3
    </th>
    <th>4
    </th>
    </tr>
    </thead>
            <tr>
                <td class="form-group">
                    <input type="checkbox" name="purchase_order_received" id="purchase_order_received">
                    Purchase Order received
                </td>
                <td>
                   
                        Current Purchase Order Document: 
                        <span id="purchase_order_filename"></span>
                        <input type="file" name="purchase_order_document" id="purchase_order_document">
                        <button type="button" onclick="clear_purchase_order_document()">Clear File</button>
                   
                </td>
                <td>
                    <select name="owner" id="owner" style="width:100%">
                        <option value="NULL">Select Owner</option>
                        <option value="high">Engineer</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </td>
                <td>
                    <select name="ndttype" id="ndttype" style="width:100%">
                        <option value="NULL">Select NDT Type</option>
                        <option value="manager_1">Manager 1</option>
                        <option value="manager_2">Manager 2</option>
                        <option value="manager_3">Manager 3</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="form-group">
                    <input type="checkbox" name="project_schedule_agreed" id="project_schedule_agreed">
                    <label>Project schedule agreed</label>
                </td>
                <td>
                
                        Current Project Schedule Document: <br>
                        <span id="project_schedule_filename"></span>
                        <input type="file" name="project_schedule_document" id="project_schedule_document">
                        <button type="button" onclick="clear_project_schedule_document()">Clear File</button>
                  
                </td>
                <td>
                    <select name="owner" id="owner" style="width:100%">
                        <option value="">Select Owner</option>
                        <option value="high">Engineer</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </td>
                <td>
                    <select name="ndttype" id="ndttype" style="width:100%">
                        <option value="NULL">Select NDT Type</option>
                        <option value="manager_1">Manager 1</option>
                        <option value="manager_2">Manager 2</option>
                        <option value="manager_3">Manager 3</option>
                    </select>
                </td>
            </tr>
            
            <tr>
                <td class="form-group">
                    <input type="checkbox" name="quotation" id="quotation">
                    <label>Quotation</label>
                </td>
                <td>
                    
                        Current Quotation Document: <br>
                        <span id="quotation_filename"></span>
                        <input type="file" name="quotation_document" id="quotation_document">
                        <button type="button" onclick="clear_quotation_document()">Clear File</button>
                   
                </td>

                <td>
                    <select name="owner" id="owner" style="width:100%">
                        <option value="NULL">Select Owner</option>
                        <option value="high">Engineer</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </td>
                <td>
                    <select name="ndttype" id="ndttype" style="width:100%">
                        <option value="NULL">Select NDT Type</option>
                        <option value="manager_1">Manager 1</option>
                        <option value="manager_2">Manager 2</option>
                        <option value="manager_3">Manager 3</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="form-group">
                    <input type="checkbox" name="verify_customer_expectations" id="verify_customer_expectations">
                    <label>Verify customer expectations</label>
                </td>
                <td>
                   
                        Current User Requirement Specifications Document: <br>
                            <span id="user_requirements_filename"></span>
                        <input type="file" name="user_requirement_specifications_document" id="user_requirement_specifications_document">
                        <button type="button" onclick="clear_user_requirement_specifications_document()">Clear File</button>
                    
                </td>
                <td>
                    <select name="owner" id="owner" style="width:100%">
                        <option value="NULL">Select Owner</option>
                        <option value="high">Engineer</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </td>
                <td>
                    <select name="ndttype" id="ndttype" style="width:100%">
                        <option value="NULL">Select NDT Type</option>
                        <option value="manager_1">Manager 1</option>
                        <option value="manager_2">Manager 2</option>
                        <option value="manager_3">Manager 3</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="form-group">
                    <input type="checkbox" name="project_risk_category_assessment" id="project_risk_category_assessment">
                    <label>Project risk category assessment</label>
                </td>
                <td>
                  
                        Current Pre Engineering Check Document: <br>
                        <span id="pre_engineering_filename"></span>
                        <input type="file" name="pre_engineering_check_document" id="pre_engineering_check_document">
                        <button type="button" onclick="clear_pre_engineering_check_document()">Clear File</button>
                   
                </td>
                <td>
                    <select name="owner" id="owner" style="width:100%">
                        <option value="NULL">Select Owner</option>
                        <option value="high">Engineer</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </td>
                <td>
                    <select name="ndttype" id="ndttype" style="width:100%">
                        <option value="NULL">Select NDT Type</option>
                        <option value="manager_1">Manager 1</option>
                        <option value="manager_2">Manager 2</option>
                        <option value="manager_3">Manager 3</option>
                    </select>
                </td>
            </tr>
        </table>
        <div class="form-group">
            <label>Sign-off for Planning / Forward Engineering:
                <input style="width:100%" type="text" name="sign_off_planning" id="sign_off_planning">
            </label>
        </div>
        <div class="form-group">
            <label>Comments for Planning / Forward Engineering:
                <textarea style="width:100%" name="comments_planning" id="comments_planning" rows="4" cols="50"></textarea>
            </label>
        </div>
        <div>
            <button type="submit" onclick="submitPlanningForm()">Submit Planning Form</button>
        </div>
            </div>
  

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
</body>
</html>
