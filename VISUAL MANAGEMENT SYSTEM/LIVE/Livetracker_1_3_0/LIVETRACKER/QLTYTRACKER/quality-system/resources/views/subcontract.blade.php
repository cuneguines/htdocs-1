
    <fieldset>
    <legend>Sub-Contract</legend>
<!-- Process Order Number -->
<div class="form-group">
        <label>
            <input type="text" name="process_order_number_subcontract" id="process_order_number_subcontract" readonly>
            Process Order Number
        </label>
    </div>
    <!-- Subtask 10.1: Sub-Contract Action -->
    <div class="form-group">
        <label>
            Sub-Contract Action:
            <select name="sub_contract_action">
                <option value="NULL">Select Action</option>
                <option value="Goods In">Goods In</option>
                
                <!-- Add more options as needed -->
            </select>
        </label>
    </div>
    <!-- File Upload for Sub-Contract -->
    <div class="form-group">
    <label>
        Upload File:
        <input type="file" name="sub_contract_file" accept=".pdf,.doc,.docx,.txt">
    </label>
    <span id="old_sub_contract_file">Old File Name</span>
</div>
    <!-- Sign-off for Sub-Contract -->
    <div class="form-group">
        <label>
            Sign-off for Sub-Contract:
            <input type="text" name="sign_off_sub_contract" value="${username}">
        </label>
    </div>

    <!-- Comments for Sub-Contract -->
    <div class="form-group">
        <label>
            Comments for Sub-Contract:
            <textarea name="comments_sub_contract" rows="4" cols="50"></textarea>
        </label>
    </div>

    <!-- Submit button -->
    <button type="button" onclick="submitSubContractForm('${processOrder}')">Submit Sub-Contract Form</button>
    </fieldset>
