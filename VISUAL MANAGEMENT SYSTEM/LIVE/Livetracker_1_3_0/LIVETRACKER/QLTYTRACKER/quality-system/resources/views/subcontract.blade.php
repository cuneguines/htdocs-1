
    <fieldset>
    <legend>Sub-Contract</legend>
    <div style="width:97%">
<!-- Process Order Number -->
<div class="form-group">
        <label>
        Process Order Number:
            <input style="width:100%"type="text" name="process_order_number_subcontract" id="process_order_number_subcontract" readonly>
            
        </label>
    </div>
    <!-- Subtask 10.1: Sub-Contract Action -->
    <div class="form-group">
        <label>
            Sub-Contract Action:
            <select style="width:100%"name="sub_contract_action">
                <option value="NULL">Select Action</option>
                <option value="Goods In">Goods In</option>
                <option value="Quality">Quality</option>
                
                <!-- Add more options as needed -->
            </select>
        </label>
    </div>
    <!-- File Upload for Sub-Contract -->
    <div class="form-group">
    <label>
        Upload File:
        <br>
        <br>
        <input type="file" id="sub_contract_file"name="sub_contract_file" accept=".pdf,.doc,.docx,.txt">
        <br>
        <br>
    </label>
    <span id="old_sub_contract_file">Old File Name</span>
    <button type="button" onclick="clear_sub_contract_file()">Clear File</button>
</div>

    <!-- Sign-off for Sub-Contract -->
    <div class="form-group">
        <label>
            Sign-off for Sub-Contract:
            <input style="width:100%"type="text" name="sign_off_sub_contract" value="${username}">
        </label>
    </div>

    <!-- Comments for Sub-Contract -->
    <div class="form-group">
        <label>
            Comments for Sub-Contract:
            <textarea style="width:100%"name="comments_sub_contract" rows="4" cols="50"></textarea>
        </label>
    </div>

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
    