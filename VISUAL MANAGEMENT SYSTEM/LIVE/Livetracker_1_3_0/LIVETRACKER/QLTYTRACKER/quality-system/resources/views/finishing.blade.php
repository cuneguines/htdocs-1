
<fieldset>
    <legend>Finishing</legend>
    <div style="width:98%">
 <!-- Process Order Number -->
 <div class="form-group">
        <label>
        Process Order Number:
            <input style="width:100%"type="text" name="process_order_number_finishing" id="process_order_number_finishing" readonly>
          
        </label>
    </div>
    <div class="form-group">
        <label>
            Pickle and Passivate:
            <input type="checkbox" name="pickle_passivate_test"
                onchange="updateDropdown(this, 'pickle_passivate_document_ref')">
            <select style="width:100%"name="pickle_passivate_document_ref" >
                <option value="NULL">NULL</option>



                <option value="SOP_0312_KF1_Acid_Dip_Pickling">SOP_0312_KF1 Acid Dip Pickling</option>
                <option value="SOP _0770_KF1_Acid_Dip_and_Passivation">SOP _0770_KF1 Acid Dip and Passivation</option>
                <option value="SOP_0313_KF2_Spray_Pickle_Cleaning">SOP_0313_KF2 Spray Pickle Cleaning</option>
                <!-- Add more options as needed -->
            </select>
        </label>
    </div>

    <div class="form-group">
        <label>
            Upload Pickle and Passivate Documents:
            <input type="file" name="pickle_passivate_documents" multiple>
        
        <span id="old_pickle_passivate_documents">Old Document Name</span>
        <button type="button" onclick="clear_pickle_passivate_documents()">Clear File</button>
        </label>
    </div>

    <div class="form-group">
        <label>
        Required Finish Applied:
            <input type="checkbox" name="select_kent_finish_test"
                onchange="updateDropdown(this, 'select_kent_finish_document_ref')">
                <select style="width:100%" name="select_kent_finish_document_ref">
    <option value="NULL">NULL</option>
    <option value="SOP-0312_Acid_Dip_Pickle_and_Passivate_[KF1]">SOP-0312_Acid_Dip_Pickle_and_Passivate_[KF1]</option>
    <option value="SOP-0770_KF1_(B)_Acid_Dip_and_Passivation">SOP-0770_KF1_(B)_Acid_Dip_and_Passivation</option>
    <option value="SOP-0313_Spray_Pickle_and_Passivate_[KF2]">SOP-0313_Spray_Pickle_and_Passivate_[KF2]</option>
    <option value="SOP-0314_Tig_Mop_Cleaning_[KF3]">SOP-0314_Tig_Mop_Cleaning_[KF3]</option>
    <option value="SOP-0315_Bead_Blasting_[KF4]">SOP-0315_Bead_Blasting_[KF4]</option>
    <option value="SOP-0316_Hot_Rolled_Electro-Polished_[KF5]">SOP-0316_Hot_Rolled_Electro-Polished_[KF5]</option>
    <option value="SOP-0317_Cold_Rolled_Electro-Polished_[KF6]">SOP-0317_Cold_Rolled_Electro-Polished_[KF6]</option>
    <option value="SOP-0318_Electro-Polished_Glass_Bead_Blasting_[KF7]">SOP-0318_Electro-Polished_Glass_Bead_Blasting_[KF7]</option>
    <option value="SOP-0319_Electro-Polished_Brushed_320_Grit_[KF8]">SOP-0319_Electro-Polished_Brushed_320_Grit_[KF8]</option>
    <option value="SOP-0320_320_Grit_Brushed_Finish_[0.5_Ra]_[KF9]">SOP-0320_320_Grit_Brushed_Finish_[0.5_Ra]_[KF9]</option>
    <option value="Sub-Con_Painted_stainless_steel">Sub-Con_Painted_stainless_steel_[KF10]</option>
    <option value="Sub-Con_Painted_mild_steel">Sub-Con_Painted_mild_steel_[KF11]</option>
    <option value="Sub-Con_Powder_coated_stainless_steel">Sub-Con_Powder_coated_stainless_steel_[KF12]</option>
    <option value="Sub-Con_Powder_coated_mild_steel">Sub-Con_Powder_coated_mild_steel[KF13]</option>
    <option value="Sub-Con_Hot_Dip_Galvanising">Sub-Con_Hot_Dip_Galvanising_[KF14]</option>
    <option value="Sub-Con_Hot_Dip_Galvanised_Duplex_coating_[powder_coated]">Sub-Con_Hot_Dip_Galvanised_Duplex_coating_[powder_coated]_[KF15]</option>
    <option value="Sub-Con_Corten_steel">Sub-Con_Corten_steel_[KF16]</option>
    <option value="SOP-0321_Welds_as_laid_-_refer_to_weld_map_[KF17]">SOP-0321_Welds_as_laid_-_refer_to_weld_map_[KF17]</option>
    <option value="SOP-0322_Welds_ground_Flush_-_refer_to_weld_map_[KF18]">SOP-0322_Welds_ground_Flush_-_refer_to_weld_map_[KF18]</option>
    <option value="SOP-0323_Welds_Blended_and_Buffed_-_refer_to_weld_map_[KF19]">SOP-0323_Welds_Blended_and_Buffed_-_refer_to_weld_map_[KF19]</option>
    <option value="SOP-0430_Waxed_Bead_Blasting_[KF20]">SOP-0430_Waxed_Bead_Blasting_[KF20]</option>
    <option value="Sub-Con_Anodised_Aluminium">Sub-Con_Anodised_Aluminium_[KF21]</option>
    <option value="SOP-0570_Oiled_Mild_Steel_[KF_22]">SOP-0570_Oiled_Mild_Steel_[KF_22]</option>
    <option value="Sub-Con_ZINGA_coating_mild_steel">Sub-Con_ZINGA_coating_mild_steel_[KF_23]</option>
</select>

        </label>
    </div>

    <div class="form-group">
        <label>
            Required Finish Applied Documents:
            <input type="file" name="select_kent_finish_documents" multiple>
       
        <span id="old_select_kent_finish_documents">Old Document Name</span>
        <button type="button" onclick="clear_kent_finish_documents()">Clear File</button>
        </label>
    </div>

    <div class="form-group">
        <label>
            Sign-off for Finishing:
            <input style="width:100%"type="text" name="sign_off_finishing" value="${username}">
        </label>
    </div>

    <div class="form-group">
        <label>
            Comments for Finishing:
            <textarea style="width:100%"name="comments_finishing" rows="4" cols="50"></textarea>
        </label>
    </div>

    <button type="button" onclick="submitFinishingForm('${processOrder}')">Submit Finishing Form</button>
            </div>
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