<script>
    function clear_production_drawings_document() {
        document.getElementById('production_drawings_document').value = ''; // Clear the file input field
        document.getElementById('production_drawings_filename').textContent = ''; // Clear the filename display
    }

    function clear_bom_document() {
        document.getElementById('bom_document').value = ''; // Clear the file input field
        document.getElementById('bom_filename').textContent = ''; // Clear the filename display
    }

    function clear_machine_programming_files_document() {
        document.getElementById('machine_programming_files_document').value = ''; // Clear the file input field
        document.getElementById('machine_programming_files_filename').textContent = ''; // Clear the filename display
    }

    function clear_ndt_documentation_document() {
        document.getElementById('ndt_documentation_document').value = ''; // Clear the file input field
        document.getElementById('ndt_documentation_filename').textContent = ''; // Clear the filename display
    }

    function clear_quality_documents_document() {
        document.getElementById('quality_documents_document').value = ''; // Clear the file input field
        document.getElementById('quality_documents_filename').textContent = ''; // Clear the filename display
    }
</script>


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
    

    <!-- Manufacturing Blade -->
    <fieldset>
        <legend>Manufacturing:</legend>
        <div style="width:98%">
            <table>
                <tr>
                    <td>Process Order Number:</td>
                    <td colspan="3">
                        <input style="width:100%" type="text" name="process_order_number_manufacturing" id="process_order_number_manufacturing" readonly>
                    </td>
                </tr>
            </table>
            <table id="manufacturing">
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
                            <input type="checkbox" name="production_drawings" id="production_drawings">
                            Production Drawings
                        </td>
                        <td>
                            Current Production Drawings Document:<br><span id="production_drawings_filename"></span>
                            <input type="file" name="production_drawings_document" id="production_drawings_document">
                            <button type="button" onclick="clear_production_drawings_document()">Clear File</button>
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
                                <option value="NULL">Select Inspection Type</option>
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
                            <input type="checkbox" name="bom" id="bom">
                            BOM
                        </td>
                        <td>
                            Current BOM Document:<br><span id="bom_filename"></span>
                            <input type="file" name="bom_document" id="bom_document">
                            <button type="button" onclick="clear_bom_document()">Clear File</button>
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
                                <option value="NULL">Select Inspection Type</option>
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
                            <input type="checkbox" name="machine_programming_files" id="machine_programming_files">
                            Machine Programming Files
                        </td>
                        <td>
                            Current Machine Programming Files Document:<br><span id="machine_programming_files_filename"></span>
                            <input type="file" name="machine_programming_files_document" id="machine_programming_files_document">
                            <button type="button" onclick="clear_machine_programming_files_document()">Clear File</button>
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
                                <option value="NULL">Select Inspection Type</option>
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
                            <input type="checkbox" name="ndt_documentation" id="ndt_documentation">
                            NDT Documentation
                        </td>
                        <td>
                            Current NDT Documentation:<br><span id="ndt_documentation_filename"></span>
                            <input type="file" name="ndt_documentation_document" id="ndt_documentation_document">
                            <button type="button" onclick="clear_ndt_documentation_document()">Clear File</button>
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
                                <option value="NULL">Select Inspection Type</option>
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
                            <input type="checkbox" name="quality_documents" id="quality_documents">
                            Quality Documents
                        </td>
                        <td>
                            Current Quality Documents:<br><span id="quality_documents_filename"></span>
                            <input type="file" name="quality_documents_document" id="quality_documents_document">
                            <button type="button" onclick="clear_quality_documents_document()">Clear File</button>
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
                                <option value="NULL">Select Inspection Type</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <option value="Hold">Hold</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <label>Sign-off for Manufacturing:
                    <input style="width:100%" type="text" name="sign_off_manufacturing" id="sign_off_manufacturing">
                </label>
            </div>
            <div class="form-group">
                <label>Comments for Manufacturing:
                    <textarea style="width:100%" name="comments_manufacturing" id="comments_manufacturing" rows="4" cols="50"></textarea>
                </label>
            </div>
            <div>
                <button type="submit" onclick="submitManufacturingForm()">Submit Manufacturing Form</button>
            </div>
        </div>
    </fieldset>
</body>
</html>