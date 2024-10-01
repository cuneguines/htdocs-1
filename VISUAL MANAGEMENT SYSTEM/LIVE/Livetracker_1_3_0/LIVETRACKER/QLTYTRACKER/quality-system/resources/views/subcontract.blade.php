
<!--<fieldset>
    <legend>Sub-Contract</legend>
    <div style="width:97%">
         Process Order Number 
        <div class="form-group">
            <label>
                Process Order Number:
                <input style="width:100%" type="text" name="process_order_number_subcontract"
                    id="process_order_number_subcontract" readonly>

            </label>
        </div>
        <!-- Subtask 10.1: Sub-Contract Action 
        <div class="form-group">
            <label>
                Sub-Contract Inspection Responsibilty:
                <select style="width:100%" name="sub_contract_action">
                    <option value="NULL">Select Action</option>
                    <option value="Goods In">Goods In</option>
                    <option value="Quality">Quality</option>

                    <!-- Add more options as needed 
            </label>
        </div>
        <!-- File Upload for Sub-Contract 
        <div class="form-group">
            <label>
                Upload File:
                <br>
                <br>
                <input type="file" id="sub_contract_file" name="sub_contract_file" accept=".pdf,.doc,.docx,.txt">
                <br>
                <br>
            </label>
            <span id="old_sub_contract_file">Old File Name</span>
            <button type="button" onclick="clear_sub_contract_file()">Clear File</button>
        </div>

        <!-- Sign-off for Sub-Contract 
        <div class="form-group">
            <label>
                Sign-off for Sub-Contract:
                <input style="width:100%" type="text" name="sign_off_sub_contract" value="${username}">
            </label>
        </div>

        <!-- Comments for Sub-Contract 
        <div class="form-group">
            <label>
                Comments for Sub-Contract:
                <textarea style="width:100%" name="comments_sub_contract" rows="4" cols="50"></textarea>
            </label>
        </div>

        <!-- Submit button 
        <button type="button" onclick="submitSubContractForm('${processOrder}')">Submit Sub-Contract Form</button>
    </div>
</fieldset>
                -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sub-Contract</title>
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    td,
    th {
        padding: 10px;
        text-align: left;
        border: 1px solid black;
    }

    .form-group {
        display: flex;
        align-items: center;
    }

    .form-group label {
        flex: 1;
    }
    </style>
</head>

<body>
    <fieldset>
        <legend>Sub-Contract</legend>
        <div style="width: 98%">
            <table>
                <tr>
                    <td>Process Order Number:</td>
                    <td colspan="4">
                        <input style="width: 100%" type="text" name="process_order_number_subcontract"
                            id="process_order_number_subcontract" readonly>
                    </td>
                </tr>
            </table>

            <table id="subcontract">
                <thead>
                    <tr>
                        <th>Sub-Contract Action</th>
                        <th>Files</yh>
                        <th>Owner</th>
                        <th>NDT Type</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="form-group">
                            <label>
                                <select style="width: 100%" name="sub_contract_action">
                                    <option value="NULL">Select Action</option>
                                    <option value="Goods In">Goods In</option>
                                    <option value="Quality">Quality</option>

                                </select>
                            </label>
                        </td>
                        <td>
                        </td>
                        <td>
                            <select name="owner_sub_contract" style="width: 100%">
                                <option value="NULL">Select Owner</option>
                                <option value="PM">PM</option>
                                <option value="QA">QA</option>
                                <option value="Planning">Planning</option>
                                <option value="Operator">Operator</option>
                                <option value="Supervisor">Supervisor</option>
                                <!-- Add more options as needed -->
                            </select>
                        </td>
                        <td>
                            <select name="ndt_type_sub_contract" style="width: 100%">
                                <option value="NULL">Select NDT Type</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <option value="None">None</option>
                                <!-- Add more options as needed -->
                            </select>
                        </td>
                    </tr>

                    <!-- File Upload for Sub-Contract in a separate row -->
                    <tr>
                        <td><label>Current File:</lable>
                        </td>
                        <td colspan="3" class="form-group">
                            <label>
                                Upload File:
                                <br><br>
                                <input type="file" id="sub_contract_file" name="sub_contract_file"
                                    accept=".pdf,.doc,.docx,.txt">
                                <br><br>
                            </label>
                            <span id="old_sub_contract_file">Old File Name</span>
                            <button type="button" onclick="clear_sub_contract_file()">Clear File</button>
                        </td>




                        <td>
                            <select name="owner_sub_contract" style="width: 100%">
                                <option value="NULL">Select Owner</option>
                                <option value="PM">PM</option>
                                <option value="QA">QA</option>
                                <option value="Planning">Planning</option>
                                <option value="Operator">Operator</option>
                                <option value="Supervisor">Supervisor</option>
                                <!-- Add more options as needed -->
                            </select>
                        </td>
                        <td>
                            <select name="ndt_type_sub_contract" style="width: 100%">
                                <option value="NULL">Select NDT Type</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <option value="None">None</option>
                                <!-- Add more options as needed -->
                            </select>
                        </td>
                    </tr>

                    <!-- Sign-off for Sub-Contract -->
                    <tr>
                        <td colspan="4">
                            <label>
                                Sign-off for Sub-Contract:
                                <input style="width: 100%" type="text" name="sign_off_sub_contract" value="${username}">
                            </label>
                        </td>
                                </tr>
                                <tr>
                        <td colspan="4">
                            <label>
                                Comments for Sub-Contract:
                                <textarea style="width: 100%" name="comments_sub_contract" rows="4"
                                    cols="50"></textarea>
                            </label>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Submit button -->
            <button type="button" onclick="submitSubContractForm('${processOrder}')">Submit Sub-Contract Form</button>
        </div>
    </fieldset>

    <script>
    function clear_sub_contract_file() {
        document.getElementById('sub_contract_file').value = ''; // Clear the file input field
        document.getElementById('old_sub_contract_file').textContent = ''; // Clear the filename display
    }
    </script>
</body>

</html>

<script>
function clear_sub_contract_file() {
    document.getElementById('sub_contract_file').value = ''; // Clear the file input field
    document.getElementById('old_sub_contract_file').textContent = ''; // Clear the filename display
}
</script>