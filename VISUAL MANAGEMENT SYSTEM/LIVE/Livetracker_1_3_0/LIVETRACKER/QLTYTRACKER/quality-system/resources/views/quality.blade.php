<fieldset>
    <legend>Main Task 1: Engineering Checks</legend>
    <div class="form-group">
        <label>
            <input type="text" name="process_order_number_quality" id="process_order_number_quality" readonly>
            Process Order Number
        </label>
    </div>
    <!-- Walk-down and Visual Inspection -->
    <div class="form-group">
        <label>
            <input type="checkbox" name="walk_down_visual_inspection" id="walk_down_visual_inspection">
            Walk-down and Visual Inspection
        </label>
    </div>

    <!-- Photographic Record -->

    <!-- Upload Images -->
    <div class="form-group">
        <label>
            Upload Images:
            <input type="file" name="images[]" id="imagesInput" multiple>
            <!-- Upload Images button -->
            <br>
            <button type="button" onclick="uploadImages_QLTY()">Upload Images</button>
            <br>
        </label>
    </div>
    <div class="form-group">
                            <label>
                                Sign-off for Quality:
                                <input type="text" name="sign_off_quality" id="sign_off_quality"value="${username}">
                            </label>
                        </div>

                        <!-- Comments for Main Task 1 -->
                        <div class="form-group">
                            <label>
                                Comments for Quality:
                                <textarea name="comments_quality" id="comments_quality" rows="4" cols="50"></textarea>
                            </label>
                        </div>

    <!-- Submit button -->
    <div name="uuidDisplay"id="uuidDisplay"></div>
    <button type="submit" onclick="submitQualityForm()">Submit Quality Checks</button>
</fieldset>

<script>
   /*  $(document).ready(function() {
        $("#photographic_record").change(function() {
            if ($(this).is(":checked")) {
                $("#photographic_record_upload").show();
            } else {
                $("#photographic_record_upload").hide();
            }
        });
    }); */
    
   


        // JavaScript code to generate and display UUID
        const uuidDisplay = document.getElementById('uuidDisplay');

        // Function to generate UUID
        function generateUUID() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                const r = Math.random() * 16 | 0,
                    v = c === 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }

        // Generate and display UUID
        const uuid = generateUUID();
        uuidDisplay.textContent =uuid;
  
    
</script>
