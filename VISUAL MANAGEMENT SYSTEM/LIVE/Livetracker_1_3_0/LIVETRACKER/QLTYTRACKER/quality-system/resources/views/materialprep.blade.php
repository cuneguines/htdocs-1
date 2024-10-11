<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Material Preparation</title>
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
        <legend>Material Preparation</legend>
        <div class="form-group">
            <label>
                <input style="width:100%" type="text" name="process_order_number_mp" id="process_order_number_mp"
                    readonly>
                Process Order Number
            </label>
        </div>
        <div style="width: 98%">
            <table id="materialprep">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Details</th>
                        <th>Owner</th>
                        <th>NDT Type</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>
                            <label>

                                Upload Material Identification Mill Cert
                            </label>
                        </td>
                        <td>
                            <span id="old-file-name_3"></span>
                            <input type="file" name="material_identification_record_file">
                            <button type="button" onclick="clear_material_identification_record_file()">Clear
                                File</button>
                        </td>

                        <td>

                            <select name="owner_mat" id="owner" style="width:100%">
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
                            <select name="ndttype_mat" style="width: 100%">
                                <option value="NULL">Select NDT Type</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <!-- Add other options as needed -->
                            </select>
                        </td>




                    </tr>
                    <tr>
                        <td>
                            <label>

                                Upload Material Identification Heat Number
                            </label>
                        </td>
                        <td>
                            <span id="old-file-name_1"></span>
                            <input type="file" name="material_identification_record">
                            <button type="button" onclick="clear_material_identification_record_heat_number()">Clear
                                File</button>
                        </td>


                        <td>

                            <select name="owner_mat" id="owner" style="width:100%">
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
                            <select name="ndttype_mat" style="width: 100%">
                                <option value="NULL">Select NDT Type</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <!-- Add other options as needed -->
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>
                                <input type="checkbox" name="material_traceability" >
                                Material Traceability
                            </label>
                        </td>
                        <td>
                        <td>

                            <select name="owner_mat" id="owner" data-task="Material Traceability"style="width:100%">
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
                            <select name="ndttype_mat" style="width: 100%"data-task="Material Traceability">
                                <option value="NULL">Select NDT Type</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <!-- Add other options as needed -->
                            </select>
                        </td>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>
                                <input type="checkbox" name="cutting">
                                Cutting Part geometry, cut quality, part qty

                            </label>
                        </td>

                        <td>
                            <span id="old-file-name_4"></span>
                            <Label>Upload Tube Laser Pack:</label>
                            <input type="file" name="tube_laser_pack_file">
                            <button type="button" onclick="clear_tube_laser_pack_file()">Clear
                                File</button>
                        </td>
                        <td>
                            <select name="owner_mat" id="owner" data-task="Cutting"style="width:100%" data-task="cutting">
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
                            <select name="ndttype_mat" id="owner"data-task="Cutting" style="width:100%" data-task="cutting">
                                <option value="NULL">Select NDT type</option>
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
                    </tr>

                    <tr>
                        <td>
                            <label>
                                <input type="checkbox" name="deburring" >
                                De-burring
                            </label>
                        </td>


                        <td>
                        </td>
                        <td>

                            <select name="owner_mat" id="owner" style="width:100%" data-task="deburring">
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
                            </select>
                        </td>
                        <td>
                            <select name="ndttype_mat" style="width: 100%" data-task="deburring">
                                <option value="NULL">Select NDT Type</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <!-- Add other options as needed -->
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>
                                <input type="checkbox" name="forming">
                                Forming
                            </label>

                        </td>



                        <td>
                            <span id="old-file-name_5"></span>

                            <Label>Upload Laser and Press Brake:</label>
                            <input type="file" name="laser_and_press_brake_file">
                            <button type="button" onclick="clear_laser_and_press_brake_file()">Clear
                                File</button>
                        </td>
                        <td>

                            <select name="owner_mat" id="owner" style="width:100%" data-task="forming">
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
                            <select name="ndttype_mat" style="width: 100%" data-task="forming">
                                <option value="NULL">Select NDT Type</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <!-- Add other options as needed -->
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>
                                <input type="checkbox" name="machining">
                                Machining
                            </label>




                        </td>
                        <td>
                        </td>
                        <td>
                            <select name="owner_mat" id="owner" style="width:100%" data-task="machining">
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
                            <select name="ndttype_mat" style="width: 100%" data-task="machining">
                                <option value="NULL">Select NDT Type</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <!-- Add other options as needed -->
                            </select>
                        </td>
                    </tr>


                    <tr>
                        <td>
                            <label>
                                <input type="checkbox" name="material_identification">
                                Material Identification Confirm grade, thickness
                            </label>
                        </td>

                        <td>
                        </td>

                        <td>
                            <select name="owner_mat" id="owner" style="width:100%" data-task="material_identification">
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
                            <select name="ndttype_mat" style="width: 100%" data-task="material_identification">
                                <option value="NULL">Select NDT Type</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <!-- Add other options as needed -->
                            </select>
                        </td>
                    </tr>
                    <!-- Add other rows for De-burring, Forming, Machining, etc. following similar structure -->
                </tbody>
            </table>

            <div class="form-group">
                <label>Sign-off for Material Preparation:</label>
                <input style="width: 100%" type="text" name="sign_off_material_preparation"
                    id="sign_off_material_preparation" value="${username}">
            </div>

            <div class="form-group">
                <label>Comments for Material Preparation:</label>
                <textarea style="width: 100%" name="comments_material_preparation" id="comments_material_preparation"
                    rows="4" cols="50"></textarea>
            </div>

            <div>
                <button type="submit" onclick="submitMaterialPreparationForm()">Submit Material Preparation
                    Form</button>
            </div>
        </div>
    </fieldset>

    <script>
    function clear_material_identification_record_file() {
        document.querySelector('input[name="material_identification_record_file"]').value =
            ''; // Clear the file input field
        //document.getElementById('old-file-name_1').textContent = ''; // Clear the filename display
    }

    function clear_material_identification_record_heat_number() {
        alert('yes');
        document.querySelector('input[name="material_identification_record_heat_number"]').value =
        ''; // Clear the file input field
        //document.getElementById('old-file-name_3').textContent = ''; // Clear the filename display
    }

    function clear_material_traceability_file() {
        document.querySelector('input[name="material_traceability_file"]').value = ''; // Clear the file input field
        //document.getElementById('old-file-name_2').textContent = ''; // Clear the filename display
    }

    function clear_laser_and_press_brake_file() {
        document.querySelector('input[name="laser_and_press_brake_file"]').value = ''; // Clear the file input field
        //document.getElementById('old-file-name_2').textContent = ''; // Clear the filename display
    }

    function clear_tube_laser_pack_file() {
        document.querySelector('input[name="tube_laser_pack_file"]').value = ''; // Clear the file input field
        //document.getElementById('old-file-name_2').textContent = ''; // Clear the filename display
    }
    </script>


</body>

</html>