<fieldset>
        <legend>Packing and Transport</legend>

        <!-- Subtask 13.1: Documentation Complete -->
         <!-- Process Order Number -->
    <div class="form-group">
        <label>
            <input type="text" name="process_order_number_transport" id="process_order_number_transport" readonly>
            Process Order Number
        </label>
    </div>

       

        <!-- Subtask 13.2: Secure Packing -->
        <div class="form-group">
            <label>
            <input type="checkbox" name="secure_packing_checkbox" value="1">
                Secure Packing:
               
            </label>
        </div>

        <!-- Responsible Person -->
        <div class="form-group">
            <label>
                Responsible Person:
                <input type="text" name="responsible_person" value="${username}">
            </label>
        </div>

        <!-- Submit button -->
        <button type="button" onclick="submitPackingTransportForm('${processOrder}')">Submit Packing and Transport Form</button>
    </fieldset>