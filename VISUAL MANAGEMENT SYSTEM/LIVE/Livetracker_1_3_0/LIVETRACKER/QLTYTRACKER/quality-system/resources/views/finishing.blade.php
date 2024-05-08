
<fieldset>
    <legend>Finishing</legend>
 <!-- Process Order Number -->
 <div class="form-group">
        <label>
            <input type="text" name="process_order_number_finishing" id="process_order_number_finishing" readonly>
            Process Order Number
        </label>
    </div>
    <div class="form-group">
        <label>
            Pickle and Passivate:
            <input type="checkbox" name="pickle_passivate_test"
                onchange="updateDropdown(this, 'pickle_passivate_document_ref')">
            <select name="pickle_passivate_document_ref" >
                <option value="NULL">NULL</option>
                <option value="Document_REF_1">Document REF 1</option>
                <option value="Document_REF_2">Document REF 2</option>
                <option value="Document_REF_3">Document REF 3</option>
                <!-- Add more options as needed -->
            </select>
        </label>
    </div>

    <div class="form-group">
        <label>
            Upload Pickle and Passivate Documents:
            <input type="file" name="pickle_passivate_documents" multiple>
        </label>
        <span id="old_pickle_passivate_documents">Old Document Name</span>
        <button type="button" onclick="clear_pickle_passivate_documents()">Clear File</button>
    </div>

    <div class="form-group">
        <label>
            Select Kent Finish:
            <input type="checkbox" name="select_kent_finish_test"
                onchange="updateDropdown(this, 'select_kent_finish_document_ref')">
            <select name="select_kent_finish_document_ref">
                <option value="NULL">NULL</option>
                <option value="SOP-0312">Acid Dip Pickle and Passivate [KF1]</option>
                <option value="SOP-0770">KF1 (B) Acid Dip and Passivation</option>
                <option value="SOP-0313">Spray Pickle and Passivate [KF2]</option>
                <option value="SOP-0314">Tig Mop Cleaning [KF3]</option>
                <option value="SOP-0315">Bead Blasting [KF4]</option>
                <option value="SOP-0316">Hot Rolled Electro-Polished [KF5]</option>
                <option value="SOP-0317">Cold Rolled Electro-Polished [KF6]</option>
                <option value="SOP-0318">Electro-Polished Glass Bead Blasting [KF7]</option>
                <option value="SOP-0319">Electro-Polished Brushed 320 Grit [KF8]</option>
                <option value="SOP-0320">320 Grit Brushed Finish [0.5 Ra] [KF9]</option>
                <option value="Sub-Con Painted stainless steel">Painted stainless steel [KF10]</option>
                <option value="Sub-Con Painted mild steel">Painted mild steel [KF11]</option>
                <option value="Sub-Con Powder coated stainless steel">Powder coated stainless steel [KF12]</option>
                <option value="Sub-Con Powder coated mild steel">Powder coated mild steel[KF13]</option>
                <option value="Sub-Con Hot Dip Galvanising">Hot Dip Galvanising [KF14]</option>
                <option value="Sub-Con Hot Dip Galvanised Duplex coating [powder coated]">Hot Dip Galvanised Duplex
                    coating [powder coated] [KF15]</option>
                <option value="Sub-Con Corten steel">Corten steel [KF16]</option>
                <option value="SOP-0321">Welds as laid - refer to weld map [KF17]</option>
                <option value="SOP-0322">Welds ground Flush - refer to weld map [KF18]</option>
                <option value="SOP-0323">Welds Blended and Buffed - refer to weld map [KF19]</option>
                <option value="SOP-0430">Waxed Bead Blasting [KF20]</option>
                <option value="Sub-Con Anodised Aluminium">Anodised Aluminium[ KF21]</option>
                <option value="SOP-0570">Oiled Mild Steel [KF 22]</option>
                <option value="Sub-Con ZINGA coating mild steel">ZINGA coating mild steel [KF 23]</option>
            </select>
        </label>
    </div>

    <div class="form-group">
        <label>
            Upload Select Kent Finish Documents:
            <input type="file" name="select_kent_finish_documents" multiple>
        </label>
        <span id="old_select_kent_finish_documents">Old Document Name</span>
        <button type="button" onclick="clear_kent_finish_documents()">Clear File</button>
    </div>

    <div class="form-group">
        <label>
            Sign-off for Finishing:
            <input type="text" name="sign_off_finishing" value="${username}">
        </label>
    </div>

    <div class="form-group">
        <label>
            Comments for Finishing:
            <textarea name="comments_finishing" rows="4" cols="50"></textarea>
        </label>
    </div>

    <button type="button" onclick="submitFinishingForm('${processOrder}')">Submit Finishing Form</button>
</fieldset>
<script>
function clear_pickle_passivate_documents() {
    document.querySelector('input[name="pickle_passivate_documents"]').value = ''; // Clear the file input field
    document.getElementById('old_pickle_passivate_documents').textContent = ''; // Clear the filename display
}

function clear_kent_finish_documents() {
    document.querySelector('input[name="select_kent_finish_documents"]').value = ''; // Clear the file input field
    document.getElementById('old_select_kent_finish_documents').textContent = ''; // Clear the filename display
}

function updateDropdown(checkbox, selectName) {
    var select = checkbox.parentElement.querySelector('select[name="' + selectName + '"]');
    if (!checkbox.checked) {
        select.value = "NULL";
    }
}

</script>