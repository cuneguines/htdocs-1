<!--<fieldset>
    <legend>Welding Tasks</legend>
    <div style="width:97%">
    <!-- Process Order Number 
    <div class="form-group">
        <label>
            <input  <input style="width:100%"type="text" name="process_order_number_welding" id="process_order_number_welding" readonly>
            Process Order Number
        </label>
    </div>

    <!-- Task 7.1: Weld Map 
    <div class="form-group">
    <label>
    <input type="checkbox" name="weld_map_issued">
        Weld Map: Weld Map issued to production</label>
       
    </div>
    <div class="form-group">
        <label  class="upload-label">Link to Weld Map: <br><br>
            <span id="old_weld_map_filename"></span>
            <input type="file" name="link_to_weld_map" id="link_to_weld_map" required>
            <button type="button" onclick="clear_link_to_weld_map()">Clear File</button>
        </label>
    </div>
    <!-- Task 7.2: Weld Procedure Qualification Record 
    <div class="form-group">
    <label>
    <input type="checkbox" name="weld_procedure_qualification">
        Weld Procedure Qualification Record:</label>
        
    </div>
    <div class="form-group">
        <label  class="upload-label">Link to PQR: <br><br>
            <span id="old_pqr_filename"></span>
            <input type="file" name="link_to_pqr" id="link_to_pqr" required>
            <button type="button" onclick="clear_link_to_pqr()">Clear File</button>
        </label>
    </div>
    <!-- Task 7.3: Weld Procedure Specifications 
    <div class="form-group">
    <label>
    <input type="checkbox" name="weld_procedure_specifications">
        Weld Procedure Specifications:</label>
       
    </div>
    <div class="form-group">
        <label  class="upload-label">Link to Approved WPS: <br><br>
            <span id="old_wps_filename"></span>
            <input type="file" name="link_to_wps" id="link_to_wps" required>
            <button type="button" onclick="clear_link_to_wps()">Clear File</button>
        </label>
    </div>

    <!-- Task 7.4: Welder Performance Qualification 
    <div class="form-group">

    <label>
    <input type="checkbox" name="welder_performance_qualification">
        Welder Performance Qualification:</label>
        
    </div>
    <div class="form-group">
        <label  class="upload-label">Link to WPQ Certificate: <br><br>
            <span id="old_wpq_filename"></span>
            <input type="file" name="link_to_wpq" id="link_to_wpq" required>
            <button type="button" onclick="clear_link_to_wpq()">Clear File</button>
        </label>
    </div>

    <!-- Task 7.5: Welding Consumable - Welding Wire 
    <div class="form-group"><label>
    <input type="checkbox" name="welding_wire">
        Welding Consumable - Welding Wire: </label>
        
    </div>

    <div class="form-group">
        <label  class="upload-label">Link to Material Certificate: <br><br>
            <span id="old_wire_certificate_filename"></span>
            <input type="file" name="link_to_wire_certificate" id="link_to_wire_certificate" required>
            <button type="button" onclick="clear_link_to_wire_certificate()">Clear File</button>
        </label>
    </div>

    <!-- Task 7.6: Welding Consumable - Shielding Gas 
    <div class="form-group"><label>
    <input type="checkbox" name="shielding_gas">
        Welding Consumable - Shielding Gas: </label>
        
    </div>

    <div class="form-group">
        <label  class="upload-label">Link to Gas Data Sheet: <br><br>
            <span id="old_gas_data_sheet_filename"></span>
            <input type="file" name="link_to_gas_data_sheet" id="link_to_gas_data_sheet" required>
            <button type="button" onclick="clear_link_to_gas_data_sheet()">Clear File</button>
        </label>
    </div>

    <!-- Task 7.7: Pre-Weld inspection 
    <div class="form-group"><label>
    <input type="checkbox" name="pre_weld_inspection">
        Pre-Weld inspection: Check weld joint preparation against WPS</label>
        
    </div>

    <!-- Task 7.8: Inspection During Welding 
    <div class="form-group"><label>
    <input type="checkbox" name="inspection_during_welding">Inspection During Welding: Check requirements of the WPS</label>
       
    </div>

    <!-- Task 7.9: Post-Weld Inspection -
    <div class="form-group"><label>
    <input type="checkbox" name="post_weld_inspection">
        Post-Weld Inspection: Visual weld inspection - All Welds</label>
       
    </div>
    
    <!-- Task 7.9.1: Welding Plant Calibration Certificate -
    <div class="form-group"><label>
    <input type="checkbox" name="welding_plant_calibration_certificate">
        Welding Plant Calibration Certificate: Check weld log for welding plant number</label>
       
    </div>

    <div class="form-group">
        <label  class="upload-label">Link to Plant Cert: <br><br>
            <span id="old_plant_cert_filename"></span>
            <input type="file" name="link_to_plant_cert" id="link_to_plant_cert" required>
            <button type="button" onclick="clear_link_to_plant_cert()">Clear File</button>
        </label>
    </div>

    <!-- !-- Upload Files -->
<!-- <div class="form-group">
        <label  class="upload-label">Link to Weld Map: <br>
            <span id="old_weld_map_filename"></span>
            <input type="file" name="link_to_weld_map" id="link_to_weld_map" required>
            <button type="button" onclick="clear_link_to_weld_map()">Clear File</button>
        </label>
    </div> -->

<!--  <div class="form-group">
        <label  class="upload-label">Link to PQR: <br>
            <span id="old_pqr_filename"></span>
            <input type="file" name="link_to_pqr" id="link_to_pqr" required>
            <button type="button" onclick="clear_link_to_pqr()">Clear File</button>
        </label>
    </div>
    
    <div class="form-group">
        <label  class="upload-label">Link to Approved WPS: <br>
            <span id="old_wps_filename"></span>
            <input type="file" name="link_to_wps" id="link_to_wps" required>
            <button type="button" onclick="clear_link_to_wps()">Clear File</button>
        </label>
    </div>
    
    <div class="form-group">
        <label  class="upload-label">Link to WPQ Certificate: <br>
            <span id="old_wpq_filename"></span>
            <input type="file" name="link_to_wpq" id="link_to_wpq" required>
            <button type="button" onclick="clear_link_to_wpq()">Clear File</button>
        </label>
    </div>
    
    <div class="form-group">
        <label  class="upload-label">Link to Material Certificate: <br>
            <span id="old_wire_certificate_filename"></span>
            <input type="file" name="link_to_wire_certificate" id="link_to_wire_certificate" required>
            <button type="button" onclick="clear_link_to_wire_certificate()">Clear File</button>
        </label>
    </div>
    
    <div class="form-group">
        <label  class="upload-label">Link to Gas Data Sheet: <br>
            <span id="old_gas_data_sheet_filename"></span>
            <input type="file" name="link_to_gas_data_sheet" id="link_to_gas_data_sheet" required>
            <button type="button" onclick="clear_link_to_gas_data_sheet()">Clear File</button>
        </label>
    </div>
    
    <div class="form-group">
        <label  class="upload-label">Link to Plant Cert: <br>
            <span id="old_plant_cert_filename"></span>
            <input type="file" name="link_to_plant_cert" id="link_to_plant_cert" required>
            <button type="button" onclick="clear_link_to_plant_cert()">Clear File</button>
        </label>
    </div> -->

<!-- Sign-off for Welding Tasks 
    <div class="form-group">
        <label>Sign-off for Welding Tasks:</label>
        <input  <input style="width:100%"type="text" name="sign_off_welding" id="sign_off_welding" value="${username}">
    </div>

    <!-- Comments for Welding Tasks 
    <div class="form-group">
        <label>Comments for Welding Tasks:</label>
        <textarea  <input style="width:100%"name="comments_welding" id="comments_welding" rows="4" cols="50"></textarea>
    </div>

    <!-- Submit button 
    <button type="submit" onclick="submitWeldingForm('${processOrder}')">Submit Welding Form</button>
</div>
</fieldset>

<script>
function clear_link_to_weld_map() {
    document.getElementById('link_to_weld_map').value = ''; // Clear the file input field
    document.getElementById('old_weld_map_filename').textContent = ''; // Clear the filename display
}

function clear_link_to_pqr() {
    document.getElementById('link_to_pqr').value = ''; // Clear the file input field
    document.getElementById('old_pqr_filename').textContent = ''; // Clear the filename display
}

function clear_link_to_wps() {
    document.getElementById('link_to_wps').value = ''; // Clear the file input field
    document.getElementById('old_wps_filename').textContent = ''; // Clear the filename display
}

function clear_link_to_wpq() {
    document.getElementById('link_to_wpq').value = ''; // Clear the file input field
    document.getElementById('old_wpq_filename').textContent = ''; // Clear the filename display
}

function clear_link_to_wire_certificate() {
    document.getElementById('link_to_wire_certificate').value = ''; // Clear the file input field
    document.getElementById('old_wire_certificate_filename').textContent = ''; // Clear the filename display
}

function clear_link_to_gas_data_sheet() {
    document.getElementById('link_to_gas_data_sheet').value = ''; // Clear the file input field
    document.getElementById('old_gas_data_sheet_filename').textContent = ''; // Clear the filename display
}

function clear_link_to_plant_cert() {
    document.getElementById('link_to_plant_cert').value = ''; // Clear the file input field
    document.getElementById('old_plant_cert_filename').textContent = ''; // Clear the filename display
}
</script>
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welding Tasks</title>
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    th,
    td {
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

    .upload-label {
        display: block;
        margin-top: 10px;
    }
    </style>
</head>

<body>
    <fieldset>
        <legend>Welding Tasks</legend>
        <div style="width:98%">
            <table>
                <tr>
                    <td>Process Order Number:</td>
                    <td colspan="4">
                        <input style="width:100%" type="text" name="process_order_number_welding"
                            id="process_order_number_welding" readonly>
                    </td>
                </tr>
                <tr>
                    <th>1</th>

                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                </tr>
                <tr>
                    <td class="form-group">
                        <input type="checkbox" name="weld_map_issued">
                        Weld Map: Weld Map issued to production
                    </td>

                    <td >
                        <label class="upload-label">Link to Weld Map: <br>
                            <span id="old_weld_map_filename"></span>
                            <input type="file" name="link_to_weld_map" id="link_to_weld_map" required>
                            <button type="button" onclick="clear_link_to_weld_map()">Clear File</button>
                        </label>
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
                        <input type="checkbox" name="weld_procedure_qualification">
                        Weld Procedure Qualification Record:
                    </td>

                    <td >
                        <label class="upload-label">Link to PQR: <br>
                            <span id="old_pqr_filename"></span>
                            <input type="file" name="link_to_pqr" id="link_to_pqr" required>
                            <button type="button" onclick="clear_link_to_pqr()">Clear File</button>
                        </label>
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
                        <input type="checkbox" name="weld_procedure_specifications">
                        Weld Procedure Specifications:
                    </td>

                    <td >
                        <label class="upload-label">Link to Approved WPS: <br>
                            <span id="old_wps_filename"></span>
                            <input type="file" name="link_to_wps" id="link_to_wps" required>
                            <button type="button" onclick="clear_link_to_wps()">Clear File</button>
                        </label>
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
                        <input type="checkbox" name="welder_performance_qualification">
                        Welder Performance Qualification:
                    </td>

                    <td >
                        <label class="upload-label">Link to WPQ Certificate: <br>
                            <span id="old_wpq_filename"></span>
                            <input type="file" name="link_to_wpq" id="link_to_wpq" required>
                            <button type="button" onclick="clear_link_to_wpq()">Clear File</button>
                        </label>
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
                        <input type="checkbox" name="welding_wire">
                        Welding Consumable - Welding Wire:
                    </td>

                    <td >
                        <label class="upload-label">Link to Material Certificate: <br>
                            <span id="old_wire_certificate_filename"></span>
                            <input type="file" name="link_to_wire_certificate" id="link_to_wire_certificate" required>
                            <button type="button" onclick="clear_link_to_wire_certificate()">Clear File</button>
                        </label>
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
                        <input type="checkbox" name="shielding_gas">
                        Welding Consumable - Shielding Gas:
                    </td>

                    <td >
                        <label class="upload-label">Link to Gas Data Sheet: <br>
                            <span id="old_gas_data_sheet_filename"></span>
                            <input type="file" name="link_to_gas_data_sheet" id="link_to_gas_data_sheet" required>
                            <button type="button" onclick="clear_link_to_gas_data_sheet()">Clear File</button>
                        </label>
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
                        <input type="checkbox" name="pre_weld_inspection">
                        Pre-Weld inspection: Check weld joint preparation against WPS
                    </td>

                    <td ></td>
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
                        <input type="checkbox" name="inspection_during_welding">
                        Inspection During Welding: Check requirements of the WPS
                    </td>

                    <td ></td>



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
                        <input type="checkbox" name="post_weld_inspection">
                        Post-Weld Inspection: Visual weld inspection - All Welds
                    </td>

                    <td >
                        <label class="upload-label">Link to Plant Cert: <br>
                            <span id="old_plant_cert_filename"></span>
                            <input type="file" name="link_to_plant_cert" id="link_to_plant_cert" required>
                            <button type="button" onclick="clear_link_to_plant_cert()">Clear File</button>
                        </label>
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
                        <input type="checkbox" name="welding_plant_calibration_certificate">
                        Welding Plant Calibration Certificate: Check weld log for welding plant number
                    </td>

                    <td ></td>

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
            </table>
            <div class="form-group">
                <label>Sign-off for Welding Tasks:
                    <input style="width:100%" type="text" name="sign_off_welding" id="sign_off_welding"
                        value="${username}">
                </label>
            </div>
            <div class="form-group">
                <label>Comments for Welding Tasks:
                    <textarea style="width:100%" name="comments_welding" id="comments_welding" rows="4"
                        cols="50"></textarea>
                </label>
            </div>
            <div>
                <button type="submit" onclick="submitWeldingForm('${processOrder}')">Submit Welding Form</button>
            </div>
        </div>
    </fieldset>

    <script>
    function clear_link_to_weld_map() {
        document.getElementById('link_to_weld_map').value = ''; // Clear the file input field
        document.getElementById('old_weld_map_filename').textContent = ''; // Clear the filename display
    }

    function clear_link_to_pqr() {
        document.getElementById('link_to_pqr').value = ''; // Clear the file input field
        document.getElementById('old_pqr_filename').textContent = ''; // Clear the filename display
    }

    function clear_link_to_wps() {
        document.getElementById('link_to_wps').value = ''; // Clear the file input field
        document.getElementById('old_wps_filename').textContent = ''; // Clear the filename display
    }

    function clear_link_to_wpq() {
        document.getElementById('link_to_wpq').value = ''; // Clear the file input field
        document.getElementById('old_wpq_filename').textContent = ''; // Clear the filename display
    }

    function clear_link_to_wire_certificate() {
        document.getElementById('link_to_wire_certificate').value = ''; // Clear the file input field
        document.getElementById('old_wire_certificate_filename').textContent = ''; // Clear the filename display
    }

    function clear_link_to_gas_data_sheet() {
        document.getElementById('link_to_gas_data_sheet').value = ''; // Clear the file input field
        document.getElementById('old_gas_data_sheet_filename').textContent = ''; // Clear the filename display
    }

    function clear_link_to_plant_cert() {
        document.getElementById('link_to_plant_cert').value = ''; // Clear the file input field
        document.getElementById('old_plant_cert_filename').textContent = ''; // Clear the filename display
    }
    </script>