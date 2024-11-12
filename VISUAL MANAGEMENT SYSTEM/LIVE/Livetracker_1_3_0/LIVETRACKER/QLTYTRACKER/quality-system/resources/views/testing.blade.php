<!-- <fieldset>
    <legend>Testing</legend>
    <div style="width:97%">
    <div class="form-group">
        <label>
        Process Order Number:
            <input style="width:100%"type="text" name="process_order_number_testing" id="process_order_number_testing" readonly>
          
        </label>
    </div>
    <!-- Subtask 8.1: Dye Penetrant Procedure 
    <div class="form-group">
        <label>
            Dye Penetrant Procedure:
            <input type="checkbox" name="dye_pen_test" onchange="Show(this, 'dyependocumentref')">
            <select style="width:100%"name="dyependocumentref" >
            <option value="NULL">NULL</option>
            <option value="PED Standard">PED Standard</option>
                <option value="ASME Standard">ASME Standard</option>
                <option value="Leak Through Test">Leak Through Test</option>
                <!-- Add more options as needed 
        </label>
    </div>

    <!-- Subtask 8.2: Hydrostatic Leak Test 
    <div class="form-group">
        <label>
            Hydrostatic Leak Test:
            <input type="checkbox" name="hydrostatic_test" onchange="toggleDropdown(this, 'hydrostatictestdocumentref')">
            <select style="width:100%"name="hydrostatictestdocumentref" >
            <option value="NULL">NULL</option>
                <option value="KS-HD-01">KS-HD-01</option>
               
                <!-- Add more options as needed 
            </select>
        </label>
    </div>

    <!-- Subtask 8.3: Pneumatic Leak Test 
    <div class="form-group">
        <label>
            Pneumatic Leak Test:
            <input type="checkbox" name="pneumatic_test" onchange="toggleDropdown(this, 'pneumatictestdocumentref')">
            <select style="width:100%"name="pneumatictestdocumentref" >
            <option value="NULL">NULL</option>
                <option value="KS-PN-01">KS-PN-01</option>
               
                <!-- Add more options as needed 
            </select>
        </label>
    </div>

    <!-- Subtask 8.4: FAT 
    <div class="form-group">
        <label>
            FAT:
            <input type="checkbox" name="fat_protocol" onchange="toggleDropdown(this, 'fatprotocoldocumentref')">
            <select style="width:100%" name="fatprotocoldocumentref" >
            <option value="NULL">NULL</option>
 


                <option value="QF-0226">QF-0226</option>
                <option value="Custom">Custom</option>
                
                <!-- Add more options as needed 
            </select>
        </label>
    </div>

    <!-- Upload Testing Documents 
    <div class="form-group">
        <label>
            Upload Testing Documents:
            <input type="file" name="testing_documents" id="testing_documents"multiple><br>
        </label>
        </label>
    <span id="old_testing_documents">Old Document Name</span>
    <button type="button" onclick="clear_testing_documents()">Clear File</button>
    </div>

    <!-- Sign-off for Testing 
    <div class="form-group">
        <label>
            Sign-off for Testing:
            <input style="width:100%"type="text" name="sign_off_testing" value="${username}">
        </label>
    </div>

    <!-- Comments for Testing 
    <div class="form-group">
        <label>
            Comments for Testing:
            <textarea style="width:100%"name="comments_testing" rows="4" cols="50"></textarea>
        </label>
    </div>

    <!-- Submit button 
    <button type="button" onclick="submitTestingForm('${processOrder}')">Submit Testing Form</button>
            </div>
</fieldset>
<script>
function clear_testing_documents() {
    var input = document.getElementById('testing_documents');
    var oldDocuments = document.getElementById('old_testing_documents');

    // Clear the file input field
    input.value = '';

    // Clear the old document display
    oldDocuments.textContent = '';
    
}
</script>
            -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Testing</title>
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
        /* Align content to the left */
        border: 1px solid black;
    }

    .form-group {
        display: flex;
        align-items: center;
        border: none;
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
        <legend>Testing:</legend>
        <div style="width:98%">
            <table>
                <tr>
                    <td>Process Order Number:</td>
                    <td colspan="4">
                        <input style="width:100%" type="text" name="process_order_number_testing"
                            id="process_order_number_testing" readonly>
                    </td>
                </tr>
            </table>
            <table id="testing">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Description</th>
                       
                        <th>Owner</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Subtask 8.1: Dye Penetrant Procedure -->
                    <tr>
                        <td class="form-group">
                            <input type="checkbox" name="dye_pen_test" id="dye_pen_test"
                                onchange="Show(this, 'dyependocumentref')">
                            Dye Penetrant Procedure
                        </td>
                        <td>
                            <select style="width:100%" name="dyependocumentref" >
                                <option value="NULL">NULL</option>
                                <option value="PED Standard">PED Standard</option>
                                <option value="ASME Standard">ASME Standard</option>
                                <option value="Leak Through Test">Leak Through Test</option>
                                <!-- Add more options as needed -->
                            </select>
                        </td>
                        
                        <td>
                            <select style="width:100%" name="owner_test"data-task="dye_pen_test">
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
                            <select style="width:100%" name="ndttype_test"data-task="dye_pen_test">
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
                    <!-- Subtask 8.2: Hydrostatic Leak Test -->
                    <tr>
                        <td class="form-group">
                            <input type="checkbox" name="hydrostatic_test" id="hydrostatic_test"
                                onchange="toggleDropdown(this, 'hydrostatictestdocumentref')">
                            Hydrostatic Leak Test
                        </td>
                        <td>
                            <select style="width:100%" name="hydrostatictestdocumentref">
                                <option value="NULL">NULL</option>
                                <option value="KS-HD-01">KS-HD-01</option>
                                <!-- Add more options as needed -->
                            </select>
                        </td>
                       
                        <td>
                            <select style="width:100%" name="owner_test"data-task="hydrostatic_test">
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
                            <select style="width:100%" name="ndttype_test"data-task="hydrostatic_test">
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
                    <!-- Subtask 8.3: Pneumatic Leak Test -->
                    <tr>
                        <td class="form-group">
                            <input type="checkbox" name="pneumatic_test" id="pneumatic_test"
                                onchange="toggleDropdown(this, 'pneumatictestdocumentref')">
                            Pneumatic Leak Test
                        </td>
                        <td>
                            <select style="width:100%" name="pneumatictestdocumentref">
                                <option value="NULL">NULL</option>
                                <option value="KS-PN-01">KS-PN-01</option>
                                <!-- Add more options as needed -->
                            </select>
                        </td>
                      
                        <td>
                            <select style="width:100%" name="owner_test"data-task="pneumatic_test">
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
                            <select style="width:100%" name="ndttype_test"data-task="pneumatic_test">
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
                    <!-- Subtask 8.4: FAT -->
                    <tr>
                        <td class="form-group">
                            <input type="checkbox" name="fat_protocol" id="fat_protocol"
                                onchange="toggleDropdown(this, 'fatprotocoldocumentref')">
                            FAT
                        </td>
                        <td>
                            <select style="width:100%" name="fatprotocoldocumentref">
                                <option value="NULL">NULL</option>
                                <option value="QF-0226">QF-0226</option>
                                <option value="Custom">Custom</option>
                                <!-- Add more options as needed -->
                            </select>
                        </td>
                       
                        <td>
                            <select style="width:100%" name="owner_test"data-task="fat_protocol">
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
                        <select style="width:100%" name="ndttype_test"data-task="fat_protocol">
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
<td>
    <label>Upload Files :
</label>
</td>

                    <td colspan="3">
                            <input type="file" name="testing_documents" id="testing_documents" multiple>
                            <span id="old_testing_documents">Old Document Name</span>
                            <button type="button" onclick="clear_fat_protocol_documents()">Clear File</button>
                        </td>
</tr>
                    <!-- Repeat similar rows for other testing tasks -->
                </tbody>
            </table>
            <div class="form-group">
                <label>Sign-off for Testing:
                    <input style="width:100%" type="text" name="sign_off_testing" id="sign_off_testing"
                        value="${username}">
                </label>
            </div>
            <div class="form-group">
                <label>Comments for Testing:
                    <textarea style="width:100%" name="comments_testing" id="comments_testing" rows="4"
                        cols="50"></textarea>
                </label>
            </div>
            <div>
                <button type="submit" onclick="submitTestingForm('${processOrder}')">Submit Testing Form</button>
            </div>
        </div>
    </fieldset>

    <script>
    

    function clear_fat_protocol_documents() {
       
alert('yes');
         const processOrderNumber = document.getElementById('process_order_number_testing').value;
        const fileName = document.getElementById('old_testing_documents').textContent;
        const tablename = "TestingFormDatas";
        const filetype = "testing_document_file_name";

        const foldername="testing_task";
console.log(fileName);
console.log(tablename);

console.log(filetype);


       // .textContent; // Changed to textContent

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
                    document.getElementById('testing_documents').value = ''; // Clear the file input field
        document.getElementById('old_testing_documents').textContent = ''; // Clear the filename display
                },
                error: function(xhr) {
                    alert("Error clearing file: " + xhr.responseText);
                    console.error(xhr); // Log the full error for debugging
                }
            });
        } else {
            if (!fileName)
            document.getElementById('testing_documents').value = ''; // Clear the file input field
        document.getElementById('old_testing_documents').textContent = ''; // Clear the filename display
        }
 


    }

    // Add similar functions for other document clear buttons as needed
    </script>
</body>

</html>