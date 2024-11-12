<!--<fieldset>
    <legend> Kitting</legend>
    <div style="width:97%">
        <!-- Process Order Number 
        <div class="form-group">
            <label>
                Process Order Number
                <br>
                <input style="width:100%" type="text" name="process_order_number_kitting"
                    id="process_order_number_kitting" readonly>

            </label>
        </div>

        <!-- Subtask 3.1: Cut Formed Machine Parts 
        <div class="form-group">
            <label>
                <input type="checkbox" name="cut_form_mach_parts">
                Cut Formed Machine Parts
            </label>
        </div>

        <!-- Subtask 3.2: Bought Out Components
        <div class="form-group">
            <label>
                <input type="checkbox" name="bought_out_components">
                Bought Out Components
            </label>
        </div>

        <!-- Subtask 3.3: Fasteners and Fixings 
        <div class="form-group">
            <label>
                <input type="checkbox" name="fasteners_fixings">
                Fasteners and Fixings
            </label>
        </div>

        <!-- Subtask 3.4: Site Pack
        <div class="form-group">
            <label>
                <input type="checkbox" name="site_pack">
                Site Pack
            </label>
        </div>

        <!-- Upload File 
        <div class="form-group">
            <label class="upload-label">
                Current Kitting File: <br><br>
                <span id="kitting_file_filename"></span>
                <input type="file" name="kitting_file_document" id="kitting_file_document">
                <button type="button" onclick="clear_kitting_file_document()">Clear File</button>
            </label>
        </div>

        <!-- Sign-off for Main Task 3 
        <div class="form-group">
            <label>
                Sign-off for Kitting:
                <input style="width:100%" type="text" name="sign_off_kitting" id="sign_off_kitting" value="${username}">
            </label>
        </div>

        <!-- Comments for Main Task 3 
        <div class="form-group">
            <label>
                Comments for Kitting:
                <textarea style="width:100%" name="comments_kitting" id="comments_kitting" rows="4"
                    cols="50"></textarea>
            </label>
        </div>

        <!-- Submit button 
        <button type="button" onclick="submitKittingForm()">Submit Kitting Form</button>
    </div>
</fieldset>
<script>
function clear_kitting_file_document() {
    document.getElementById('kitting_file_document').value = ''; // Clear the file input field
    document.getElementById('kitting_file_filename').textContent = ''; // Clear the filename display
}
</script>

-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kitting</title>
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
        <legend>Kitting</legend>
        <div style="width: 98%">
            <table >
                <tr>
                    <td>Process Order Number:</td>
                    <td colspan="4">
                        <input style="width: 100%" type="text" name="process_order_number_kitting"
                            id="process_order_number_kitting" readonly>
                    </td>
                </tr>
            </table>
            <table id="kitting">
                <thead>
                    <tr>
                    <th>Tasks</th>
                        <th>Files </th>
                        <th>Owner</th>
                        <th>Action</th>
                   
                    </tr>
                </thead>
                <tbody>
                    <!-- Subtask: Cut Formed Machine Parts -->
                    <tr>
                        <td class="form-group">
                            <label>
                                <input type="checkbox" name="cut_form_mach_parts">
                                Cut Formed Machine Parts
                        
                        Details about cutting formed machine parts</td>
                        <td>
</td>
                        <td>
                            <select name="owner_kit" style="width: 100%"data-task="cut_form_mach_parts">
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
                            <select name="ndttype_kit" style="width: 100%"data-task="cut_form_mach_parts">
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

                    <!-- Subtask: Bought Out Components -->
                    <tr>
                        <td class="form-group">
                            <label>
                                <input type="checkbox" name="bought_out_components">
                                Bought Out Components
                          
                        Details about bought out components</td>
                        <td>
</td>
                        <td>
                            <select name="owner_kit" style="width: 100%"data-task="bought_out_components">
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
                            <select name="ndttype_kit" style="width: 100%"data-task="bought_out_components">
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

                    <!-- Subtask: Fasteners and Fixings -->
                    <tr>
                        <td class="form-group">
                            <label>
                                <input type="checkbox" name="fasteners_fixings">
                                Fasteners and Fixings
                           
                        Details about fasteners and fixings</td>
                        <td>
</td>
                        <td>
                            <select name="owner_kit" style="width: 100%"data-task="fasteners_fixings">
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
                            <select name="ndttype_kit" style="width: 100%"data-task="fasteners_fixings">
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

                    <!-- Subtask: Site Pack -->
                    <tr>
                        <td class="form-group">
                            <label>
                                <input type="checkbox" name="site_pack">
                               SitePAck
                           
                        Details about site pack</td>
                        
                            <td>
</td>
<td>
<select name="owner_kit" style="width: 100%"data-task="site_pack">
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
                            <select name="ndttype_kit" style="width: 100%"data-task="site_pack">
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

                    <tr>
                        <td class="form-group">
                            <label>
                              
                               Current file:
                            </label>
                        </td>
                        <td><label class="upload-label">
                                Current Kitting File: <br><br>
                                <span id="kitting_file_filename"></span>
                                <input type="file" name="kitting_file_document" id="kitting_file_document">
                                <button type="button" onclick="clear_kitting_file_document()">Clear File</button>
                            </label></td>
                        <td>
                            <select name="owner_kit" style="width: 100%">
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
                            <select name="ndttype_kit" style="width: 100%">
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
                </tbody>
            </table>
            <div class="form-group">
                <label>Sign-off for Kitting:
                    <input style="width: 100%" type="text" name="sign_off_kitting" id="sign_off_kitting">
                </label>
            </div>
            <div class="form-group">
                <label>Comments for Kitting:
                    <textarea style="width: 100%" name="comments_kitting" id="comments_kitting" rows="4"
                        cols="50"></textarea>
                </label>
            </div>
            <div>
                <button type="submit" onclick="submitKittingForm()">Submit Kitting Form</button>
            </div>
        </div>
    </fieldset>

    <script>
     function clear_kitting_file_document() {

        const processOrderNumber = document.getElementById('process_order_number_kitting').value;
        const fileName = document.getElementById('kitting_file_filename').textContent; // Changed to textContent
        const tablename = "KittingFormData";
        const filetype = "kitting_file";
        const foldername="kitting_task";


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
                    document.getElementById('kitting_file_document').value = ''; // Clear the file input field
        document.getElementById('kitting_file_filename').textContent = ''; // Clear the filename display
                },
                error: function(xhr) {
                    alert("Error clearing file: " + xhr.responseText);
                    console.error(xhr); // Log the full error for debugging
                }
            });
        } else {
            if (!fileName)
               // document.getElementById('technical_file').value = '';
           // document.getElementById('old_technical_file').textContent = '';
            //alert('Please enter a valid Process Order Number and file name.');
        //}
           // document.getElementById('sample_approval_document').value = ''; // Clear the file input field
           // document.getElementById('sample_approval_document_filename').textContent = ''; // Clear the filename display
      //  }

        document.getElementById('kitting_file_document').value = ''; // Clear the file input field
        document.getElementById('kitting_file_filename').textContent = ''; // Clear the filename display
    }
}
    </script>
</body>

</html>

