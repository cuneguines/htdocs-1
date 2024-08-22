

  <!--  <fieldset>
    <legend>Final Assembly</legend>
    <div style="width:98%">
    <!-- Process Order Number 
    <div class="form-group">
        <label>
        Process Order Number:
            <input style="width:100%"type="text" name="process_order_number_finalassembly" id="process_order_number_finalassembly" readonly>
           
        </label>
    </div>

    <!-- Attach Part ID Labels / Name Plates 
    <div class="form-group">
        <label>
            <input type="checkbox" name="attach_part_id_labels">
            Attach Part ID Labels / Name Plates
        </label>
    </div>

    <!-- Sign-off for Final Assembly 
    <div class="form-group">
        <label>
            Sign-off for Final Assembly:
            <input style="width:100%"type="text" name="sign_off_final_assembly" value="${username}">
        </label>
    </div>

    <!-- Comments for Final Assembly
    <div class="form-group">
        <label>
            Comments for Final Assembly:
            <textarea style="width:100%"name="comments_final_assembly" rows="4" cols="50"></textarea>
        </label>
    </div>

    <!-- Submit button 
    <button type="button" onclick="submitFinalAssemblyForm('${processOrder}')">Submit Final Assembly Form</button>
    </div>
</fieldset>

            -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Final Assembly</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        td, th {
            padding: 10px;
            text-align: left;
            border: 1px solid black;
        }
        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
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
        <legend>Final Assembly</legend>
        <div style="width: 98%">
            <table id="final_assembly">
                <thead>
                    
                </thead>
                <tbody>
                    <tr>
                        <td>Process Order Number:</td>
                        <td colspan="3">
                            <input style="width:100%" type="text" name="process_order_number_finalassembly"
                                id="process_order_number_finalassembly" readonly>
                        </td>
                    </tr>
                    <tr>
                        <th>1</th>
                        
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                    </tr>
                    <tr>
                    <td>Attach Part ID Labels / Name Plates:</td>
                        <td class="form-group">
                            <input type="checkbox" name="attach_part_id_labels">
                            Attach Part ID Labels / Name Plates
                        </td>
                        
                        <td>
                            <select style="width:100%" name="attach_part_id_labels_owner">
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
                            <select style="width:100%" name="attach_part_id_labels_inspection_type">
                                <option value="NULL">Select Inspection Type</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <!-- Add more options as needed -->
                            </select>
                        </td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
            <div class="form-group">
                <label>Sign-off for Final Assembly:
                    <input style="width:100%" type="text" name="sign_off_final_assembly" value="${username}">
                </label>
            </div>
            <div class="form-group">
                <label>Comments for Final Assembly:
                    <textarea style="width:100%" name="comments_final_assembly" rows="4" cols="50"></textarea>
                </label>
            </div>
            <button type="button" onclick="submitFinalAssemblyForm('${processOrder}')">Submit Final Assembly Form</button>
        </div>
    </fieldset>

    <script>
    function updateDropdown(checkbox, selectName) {
        var select = checkbox.parentElement.parentElement.querySelector('select[name="' + selectName + '"]');
        if (!checkbox.checked) {
            select.value = "NULL";
        }
    }

    function submitFinalAssemblyForm(processOrder) {
        // Implement your form submission logic here
        console.log('Submitting Final Assembly Form for Process Order: ' + processOrder);
    }
    </script>
</body>
</html>
