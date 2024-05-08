<fieldset>
    <legend>Main Task 3: Welding Tasks</legend>

    <!-- Process Order Number -->
    <div class="form-group">
        <label>
            <input type="text" name="process_order_number_welding" id="process_order_number_welding" readonly>
            Process Order Number
        </label>
    </div>

    <!-- Task 7.1: Weld Map -->
    <div class="form-group">
        <label>Weld Map: Weld Map issued to production</label>
        <input type="checkbox" name="weld_map_issued">
    </div>

    <!-- Task 7.2: Weld Procedure Qualification Record -->
    <div class="form-group">
        <label>Weld Procedure Qualification Record: EN ISO 15614</label>
        <input type="checkbox" name="weld_procedure_qualification">
    </div>

    <!-- Task 7.3: Weld Procedure Specifications -->
    <div class="form-group">
        <label>Weld Procedure Specifications: EN ISO 15615</label>
        <input type="checkbox" name="weld_procedure_specifications">
    </div>

    <!-- Task 7.4: Welder Performance Qualification -->
    <div class="form-group">
        <label>Welder Performance Qualification: EN 9606</label>
        <input type="checkbox" name="welder_performance_qualification">
    </div>

    <!-- Task 7.5: Welding Consumable - Welding Wire -->
    <div class="form-group">
        <label>Welding Consumable - Welding Wire: EN 1024 Type 3.1</label>
        <input type="checkbox" name="welding_wire">
    </div>

    <!-- Task 7.6: Welding Consumable - Shielding Gas -->
    <div class="form-group">
        <label>Welding Consumable - Shielding Gas: EN ISO 14175</label>
        <input type="checkbox" name="shielding_gas">
    </div>

    <!-- Task 7.7: Pre-Weld inspection -->
    <div class="form-group">
        <label>Pre-Weld inspection: Check weld joint preparation against WPS</label>
        <input type="checkbox" name="pre_weld_inspection">
    </div>

    <!-- Task 7.8: Inspection During Welding -->
    <div class="form-group">
        <label>Inspection During Welding: Check requirements of the WPS</label>
        <input type="checkbox" name="inspection_during_welding">
    </div>

    <!-- Task 7.9: Post-Weld Inspection -->
    <div class="form-group">
        <label>Post-Weld Inspection: Visual weld inspection - All Welds</label>
        <input type="checkbox" name="post_weld_inspection">
    </div>
    
    <!-- Task 7.9.1: Welding Plant Calibration Certificate -->
    <div class="form-group">
        <label>Welding Plant Calibration Certificate: Check weld log for welding plant number</label>
        <input type="checkbox" name="welding_plant_calibration_certificate">
    </div>

    <!-- Upload Files -->
    <div class="form-group">
        <label style="background-color: lightgrey" class="upload-label">Link to Weld Map: <br>
            <span id="old_weld_map_filename"></span>
            <input type="file" name="link_to_weld_map" id="link_to_weld_map" required>
            <button type="button" onclick="clear_link_to_weld_map()">Clear File</button>
        </label>
    </div>
    
    <div class="form-group">
        <label style="background-color: lightgrey" class="upload-label">Link to PQR: <br>
            <span id="old_pqr_filename"></span>
            <input type="file" name="link_to_pqr" id="link_to_pqr" required>
            <button type="button" onclick="clear_link_to_pqr()">Clear File</button>
        </label>
    </div>
    
    <div class="form-group">
        <label style="background-color: lightgrey" class="upload-label">Link to Approved WPS: <br>
            <span id="old_wps_filename"></span>
            <input type="file" name="link_to_wps" id="link_to_wps" required>
            <button type="button" onclick="clear_link_to_wps()">Clear File</button>
        </label>
    </div>
    
    <div class="form-group">
        <label style="background-color: lightgrey" class="upload-label">Link to WPQ Certificate: <br>
            <span id="old_wpq_filename"></span>
            <input type="file" name="link_to_wpq" id="link_to_wpq" required>
            <button type="button" onclick="clear_link_to_wpq()">Clear File</button>
        </label>
    </div>
    
    <div class="form-group">
        <label style="background-color: lightgrey" class="upload-label">Link to Material Certificate: <br>
            <span id="old_wire_certificate_filename"></span>
            <input type="file" name="link_to_wire_certificate" id="link_to_wire_certificate" required>
            <button type="button" onclick="clear_testing_documents()">Clear File</button>
        </label>
    </div>
    
    <div class="form-group">
        <label style="background-color: lightgrey" class="upload-label">Link to Gas Data Sheet: <br>
            <span id="old_gas_data_sheet_filename"></span>
            <input type="file" name="link_to_gas_data_sheet" id="link_to_gas_data_sheet" required>
            <button type="button" onclick="clear_link_to_gas_data_sheet()">Clear File</button>
        </label>
    </div>
    
    <div class="form-group">
        <label style="background-color: lightgrey" class="upload-label">Link to Plant Cert: <br>
            <span id="old_plant_cert_filename"></span>
            <input type="file" name="link_to_plant_cert" id="link_to_plant_cert" required>
            <button type="button" onclick="clear_to_plant_cert()">Clear File</button>
        </label>
    </div>

    <!-- Sign-off for Welding Tasks -->
    <div class="form-group">
        <label>Sign-off for Welding Tasks:</label>
        <input type="text" name="sign_off_welding" id="sign_off_welding" value="${username}">
    </div>

    <!-- Comments for Welding Tasks -->
    <div class="form-group">
        <label>Comments for Welding Tasks:</label>
        <textarea name="comments_welding" id="comments_welding" rows="4" cols="50"></textarea>
    </div>

    <!-- Submit button -->
    <button type="submit" onclick="submitWeldingForm('${processOrder}')">Submit Welding Form</button>
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