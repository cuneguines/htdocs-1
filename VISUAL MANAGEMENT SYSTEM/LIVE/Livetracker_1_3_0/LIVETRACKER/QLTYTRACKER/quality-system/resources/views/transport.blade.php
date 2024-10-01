<!--<fieldset>
        <legend>Packing and Transport</legend>
        <div style="width:97%">
        <!-- Subtask 13.1: Documentation Complete -->
         <!-- Process Order Number 
        <label>
            <input style="width:100%"type="text" name="process_order_number_transport" id="process_order_number_transport" readonly>
            Process Order Number
        </label>
    </div>

       

        <!-- Subtask 13.2: Secure Packing
        <div class="form-group">
            <label>
            <input type="checkbox" name="secure_packing_checkbox" value="1">
                Secure Packing:
               
            </label>
        </div>

        <!-- Responsible Person 
        <div class="form-group">
            <label>
                Engineer:
                <input style="width:100%"type="text" name="responsible_person" value="${username}">
            </label>
        </div>

        <!-- Submit button
        <button type="button" onclick="submitPackingTransportForm('${processOrder}')">Submit Packing and Transport Form</button>
</div>
    </fieldset>

-->


    <fieldset>
    <legend>Packing and Transport</legend>
    <div style="width:97%">
        <table id="packing_transport">
            <thead>
                <tr>
                    <th colspan="3">Process Order Number:</th>
                </tr>
                <tr>
                    <td colspan="3">
                        <div class="form-group" style="display: flex; align-items: center;">
                            <label style="flex: 1;">Process Order Number:</label>
                            <input style="flex: 2; width: 100%" type="text" name="process_order_number_transport" id="process_order_number_transport" readonly>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Task</th>
                    <th>Owner</th>
                    <th>NDT Type</th>
                </tr>
            </thead>
            <tbody>
                <!-- Secure Packing -->
                <tr>
                    <td class="form-group">
                        <label>
                            <input type="checkbox" name="secure_packing_checkbox" value="1">
                            Secure Packing:
                        </label>
                    </td>
                    <td>
                        <select name="owner_transport" style="width: 100%">
                            <option value="NULL">Select Owner</option>
                            <option value="PM">PM</option>
                            <option value="QA">QA</option>
                            <option value="Planning">Planning</option>
                            <option value="Operator">Operator</option>
                            <!-- Add more options as needed -->
                        </select>
                    </td>
                    <td>
                        <select name="ndt_type_transport" style="width: 100%">
                            <option value="NULL">Select NDT Type</option>
                            <option value="Approve">Approve</option>
                            <option value="Inspect">Inspect</option>
                            <option value="Review">Review</option>
                            <option value="Record">Record</option>
                            <!-- Add more options as needed -->
                        </select>
                    </td>

                </tr>
                <tr>




        <!-- Responsible Person -->
        <td class="form-group" style="flex:2"colspan="3">
            <label>
                Engineer:
                <input style="width:100%" type="text" name="responsible_person" value="${username}">
            </label>
</td>
        </tr>
            </tbody>
        </table>
        <!-- Submit button -->
        <button type="button" onclick="submitPackingTransportForm('${processOrder}')">Submit Packing and Transport Form</button>
    </div>
</fieldset>
