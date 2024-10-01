<!--<fieldset>
    <legend>Documentation</legend>
    <div style="width:97%">
    <!-- Process Order Number 
    <div class="form-group">
        <label>
            <input style="width:100%" type="text" name="process_order_number_documentation" id="process_order_number_documentation"
                readonly>
            Process Order Number
        </label>
    </div>
    <!-- Subtask 12.1: Technical File
    <div class="form-group">
        <label>
        <input type="checkbox" name="technical_file_checkbox" value="1">
            Technical File:
           
        </label>
</div>
        <div class="form-group">
            <div id="technical_file_upload">
                <label>Upload New Technical File:</label><br>
                <input type="file" name="technical_file" id="technical_file" accept=".pdf,.doc,.docx,.txt">
                <button type="button" onclick="clearFile_tech()">Clear File</button>
            </div>
            <div>
                <label></label>
                <span id="old_technical_file"></span>
            </div>
        </div>

        <!-- Subtask 12.2: Client Hand-over documentation 
        <div class="form-group">
            <label>
                <input type="checkbox" name="client_handover_checkbox" value="1">
                Client Hand-over documentation:

            </label><br>
            <div class="form-group">
                <div id="client_handover_upload">

                    <label>Upload New Client Hand-over Documentation:<br></label><br>
                    <input type="file" id="client_handover_documentation" name="client_handover_documentation"
                        accept=".pdf,.doc,.docx,.txt">
                    <button type="button" onclick="clearFile_client()">Clear File</button>
                </div>
                <div>

                    <span id="old_client_handover_documentation"></span>




                </div>
            </div>

            <!-- Engineer 
            <div class="form-group">
                <label>
                    Sign_off_Engineer:
                    <input style="width:100%"type="text" name="sign_off_engineer" id="sign_off_engineer" value="${username}">

                </label>
            </div>

            <div class="form-group">
        <label>
            Comments for Documentation:
            <textarea style="width:100%"name="comments_documentation" id="comments_documentation" rows="4" cols="50"></textarea>
        </label>
    </div>

            <!-- Submit button 
            <button type="button" onclick="submitDocumentationForm('${processOrder}')">Submit Documentation
                Form</button>
            </div>
</fieldset>
            -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Documentation</title>
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
        <legend>Documentation</legend>
        <div style="width: 98%">
            <table>
                <tr>
                    <td>Process Order Number:</td>
                    <td colspan="3">
                        <input style="width: 100%" type="text" name="process_order_number_documentation" id="process_order_number_documentation" readonly>
                    </td>
                </tr>
            </table>

            <table id="documentation_checks">
                <thead>
                    <tr>
                        <th>Documentation Type</th>
                        <th>Files </th>
                        <th>Owner</th>
                        <th>NDT Type</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Technical File -->
                    <tr>
                        <td class="form-group">
                            <label>
                                <input type="checkbox" name="technical_file_checkbox" value="1">
                                Technical File:
                            </label>
                        </td>

                        <td >
                            <div id="technical_file_upload">
                                <label>Upload New Technical File:</label><br>
                                <input type="file" name="technical_file" id="technical_file" accept=".pdf,.doc,.docx,.txt">
                                <button type="button" onclick="clearFile_tech()">Clear File</button>
                            </div>
                            <div>
                                <span id="old_technical_file"></span>
                            </div>
                        </td>
                        <td>
                            <select name="owner_technical_file" style="width: 100%">
                                <option value="NULL">Select Owner</option>
                                <option value="PM">PM</option>
                                <option value="QA">QA</option>
                                <option value="Planning">Planning</option>
                                <option value="Operator">Operator</option>
                                <!-- Add more options as needed -->
                            </select>
                        </td>
                        <td>
                            <select name="ndt_type_technical_file" style="width: 100%">
                                <option value="NULL">Select NDT Type</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <!-- Add more options as needed -->
                            </select>
                        </td>
                    </tr>
                    
                       
                  
                    <!-- Client Hand-over Documentation -->
                    <tr>
                        <td class="form-group">
                            <label>
                                <input type="checkbox" name="client_handover_checkbox" value="1">
                                Client Hand-over documentation:
                            </label>
                        </td>
                        <td >
                            <div id="client_handover_upload">
                                <label>Upload New Client Hand-over Documentation:</label><br>
                                <input type="file" id="client_handover_documentation" name="client_handover_documentation" accept=".pdf,.doc,.docx,.txt">
                                <button type="button" onclick="clearFile_client()">Clear File</button>
                            </div>
                            <div>
                                <span id="old_client_handover_documentation"></span>
                            </div>
                        </td>
                    


                        <td>
                            <select name="owner_client_handover" style="width: 100%">
                                <option value="NULL">Select Owner</option>
                                <option value="PM">PM</option>
                                <option value="QA">QA</option>
                                <option value="Planning">Planning</option>
                                <option value="Operator">Operator</option>
                                <!-- Add more options as needed -->
                            </select>
                        </td>
                        <td>
                            <select name="ndt_type_client_handover" style="width: 100%">
                                <option value="NULL">Select NDT Type</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <!-- Add more options as needed -->
                            </select>
                        </td>
                    </tr>
                   
                        

                    <!-- Sign-off Engineer -->
                    <tr>
                        <td>
                            Sign-off Engineer:
                        </td>
                        <td colspan="2">
                            <input style="width: 100%" type="text" name="sign_off_engineer" id="sign_off_engineer" value="${username}">
                        </td>
                    </tr>

                    <!-- Comments -->
                    <tr>
                        <td>
                            Comments for Documentation:
                        </td>
                        <td colspan="2">
                            <textarea style="width: 100%" name="comments_documentation" id="comments_documentation" rows="2" cols="50"></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button type="button" onclick="submitDocumentationForm()">Submit Documentation Form</button>
        </div>
    </fieldset>

    <script>
        function clearFile_tech() {
            document.getElementById('technical_file').value = '';
            document.getElementById('old_technical_file').textContent = '';
        }

        function clearFile_client() {
            document.getElementById('client_handover_documentation').value = '';
            document.getElementById('old_client_handover_documentation').textContent = '';
        }
    </script>
</body>

</html>



<script>
function clearFile_tech() {
    document.getElementById('technical_file').value = '';
    document.getElementById('old_technical_file').textContent = '';



}

function clearFile_client() {
    document.getElementById('client_handover_documentation').value = '';
    document.getElementById('old_client_handover_documentation').textContent = '';
}
</script>