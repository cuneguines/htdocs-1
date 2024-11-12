<!--<fieldset>
    <legend>Fabrication Fit-Up</legend>
    <div style="width:98%">
    <div class="form-group">
        <label>Process Order Number:
            <input style="width:100%" type="text" name="process_order_number_fabrication_fit_up" id="process_order_number_fabrication_fit_up" readonly>
            
        </label>
    </div>
    <!-- Subtask 6.1: Fit-up 
    <div class="form-group">
        
    <label>
    <input type="checkbox" name="fit_up_visual_check">
        Fit-up: Visual check fit up - first off</label>
        
    </div>

    <!-- Subtask 6.2: Dimensional check
    <div class="form-group">
    <label>
    <input type="checkbox" name="dimensional_check">
        Dimensional check: Dimensional check first off</label>
        
        <!-- Upload File
        <label class="upload-label">Link to Drawing: <br><br>
            <span id="old_drawing_filename"></span> <!-- Span for old file name 
            <input type="file" name="link_to_drawing" id="link_to_drawing" required><br>
            <button type="button" onclick="clear_link_to_drawing()">Clear File</button>
        </label>
    </div>

    <!-- Subtask 6.3: Weldment quantity 
    <div class="form-group">
    <label>
    <br>
    <input type="checkbox" name="weldment_quantity">
        Weld Check</label>
    </div>

    <!-- Sign-off for Fabrication Fit-Up 
    <div class="form-group">
    <label> Sign-off for Fabrication Fit-Up:
    <input style="width:100%" type="text" name="sign_off_fabrication_fit_up" value="${username}">
       </label>
        
    </div>

    <!-- Comments for Fabrication Fit-Up 
    <div class="form-group">
        <label>Comments for Fabrication Fit-Up:</label>
        <textarea style="width:100%"name="comments_fabrication_fit_up" rows="4" cols="50"></textarea>
    </div>

    <!-- Submit button 
    <button type="submit" onclick="submitFabricationFitUpForm('${processOrder}')">Submit Fabrication Fit-Up
        Form</button>
</div>
</fieldset>
<script>
function clear_link_to_drawing() {
    document.getElementById('link_to_drawing').value = ''; // Clear the file input field
    document.getElementById('old_drawing_filename').textContent = ''; // Clear the filename display
}
</script>
    -->


    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fabrication Fit-Up</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid black;
        }
        .form-group {
            /*display: flex;*/
            align-items: center;
        }
        .form-group input[type="checkbox"] {
            margin-right: 10px;
        }
        .form-group label {
            flex: 1;
        }
        .upload-label {
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <fieldset>
        <legend>Fabrication Fit-Up</legend>
        <div style="width: 98%">
            <table id="fabrication">
                <thead>
                <tr>
                    <td>Process Order Number:</td>
                    <td colspan="3">
                        <input style="width:100%" type="text" name="process_order_number_fabrication_fit_up" id="process_order_number_fabrication_fit_up" readonly>
                    </td>
                </tr>
                    <tr>
                    <th>Tasks</th>
                        <th>Files </th>
                        <th>Owner</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Subtask 6.1: Fit-up -->
                    <tr>
                        <td class="form-group">
                            <label>
                                <input type="checkbox" name="fit_up_visual_check">
                                Fit-up: Visual check fit up - first off
                            </label>
                        </td>
                        <td>Details about fit-up visual check</td>
                        <td>
                            <select name="owner_fab" style="width: 100%" data-task="fit_up_visual_check">
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


                                <!-- Add more options as needed -->
                            </select>
                        </td>
                        <td>
                            <select name="ndttype_fab" style="width: 100%"data-task="fit_up_visual_check">
                                <option value="NULL">Select Action</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <option value="Hold">Hold</option>
                                <!-- Add more options as needed -->
                            </select>
                        </td>
                    </tr>

                    <!-- Subtask 6.2: Dimensional check -->
                    <tr>
                        <td class="form-group">
                            <label>
                                <input type="checkbox" name="dimensional_check">
                                Dimensional check: Dimensional check first off
                            </label>
                        </td>
                        <td>Details about dimensional check</td>
                        <td>
                            <select name="owner_fab" style="width: 100%" data-task="dimensional_check">
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


                                <!-- Add more options as needed -->
                            </select>
                        </td>
                        <td>
                            <select name="ndttype_fab" style="width: 100%"data-task="dimensional_check">
                                <option value="NULL">Select Action</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <option value="Hold">Hold</option>
                                <!-- Add more options as needed -->
                            </select>
                        </td>
                    </tr>

                    <!-- Subtask 6.3: Weldment quantity -->
                    <tr>
                        <td class="form-group">
                            <label>
                                <input type="checkbox" name="weldment_quantity">
                                Weld Check
                            </label>
                        </td>
                        <td>Details about weld check</td>
                        <td>
                            <select name="owner_fab" style="width: 100%"data-task="dimensional_check">
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


                                <!-- Add more options as needed -->
                            </select>
                        </td>
                        <td>
                            <select name="ndttype_fab" style="width: 100%"data-task="dimensional_check">
                                <option value="NULL">Select Action</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <option value="Hold">Hold</option>

                                <!-- Add more options as needed -->
                            </select>
                        </td>
                    </tr>

                    <!-- File Upload - Link to Drawing -->
                    <tr>
                        <td>Link to Drawing</td>
                        <td>
                            <span id="old_drawing_filename"></span><br>
                            <input type="file" name="link_to_drawing" id="link_to_drawing" required>
                            <button type="button" onclick="clear_link_to_drawing()">Clear File</button>
                        </td>
                        <td>
                            <select name="owner_fab" style="width: 100%"data-task="weldment_quantity">
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


                                <!-- Add more options as needed -->
                            </select>
                        </td>
                        <td>
                            <select name="ndttype_fab" style="width: 100%"data-task="weldment_quantity">
                                <option value="NULL">Select Action</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <option value="Hold">Hold</option>
                                <!-- Add more options as needed -->
                            </select>
                        </td>
                    </tr>

                    <!-- Sign-off and Comments -->
                    <tr>
                        <td colspan="4">
                            <div class="form-group">
                                <label>Sign-off for Fabrication Fit-Up:</label>
                                <input style="width: 100%" type="text" name="sign_off_fabrication_fit_up">
                            </div>
                            <div class="form-group">
                                <label>Comments for Fabrication Fit-Up:</label>
                                <textarea style="width: 100%" name="comments_fabrication_fit_up" rows="4" cols="50"></textarea>
                            </div>
<div>
                            <button type="submit" onclick="submitFabricationFitUpForm('${processOrder}')">Submit Fabrication Fit-Up
        Form</button>
    </div>
                        </td>
                        
                    </tr>
                </tbody>
            </table>
        </div>
    </fieldset>

    <script>
        function clear_link_to_drawing() {



            
            const processOrderNumber = document.getElementById('process_order_number_fabrication_fit_up').value;
        const fileName = document.getElementById('old_drawing_filename').textContent; // Changed to textContent
        const tablename = "FabricationFitUpFormData";
        const filetype = "link_to_drawing";
        const foldername="fabricationfitup_task";

        if (processOrderNumber && fileName) {
            $.ajax({
                url: "{{ url('clear-file') }}/" + processOrderNumber,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    file_name: fileName,
                    tablename: tablename,
                    filetype: filetype,
                    foldername:foldername
                },
                success: function(response) {
                    alert("File cleared successfully!");
                    document.getElementById('link_to_drawing').value = '';
                    document.getElementById('old_drawing_filename').textContent = '';
                },
                error: function(xhr) {
                    alert("Error clearing file: " + xhr.responseText);
                    console.error(xhr); // Log the full error for debugging
                }
            });
        } else {
            if (!fileName)
              //  document.getElementById('technical_file').value = '';
           // document.getElementById('old_technical_file').textContent = '';
            //alert('Please enter a valid Process Order Number and file name.');
       // }
            //document.getElementById('customer_approval_document').value = ''; // Clear the file input field
            //document.getElementById('customer_approval_document_filename').textContent = ''; // Clear the filename display
        //}
    //}
            document.getElementById('link_to_drawing').value = '';
            document.getElementById('old_drawing_filename').textContent = '';
        }
    }

        
    </script>
</body>
</html>
