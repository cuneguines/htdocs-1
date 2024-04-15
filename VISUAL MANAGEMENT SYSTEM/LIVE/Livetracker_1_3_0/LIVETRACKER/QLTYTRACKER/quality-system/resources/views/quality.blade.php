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
                                <input type="text" name="sign_off_quality" id="sign_off_quality">
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

    // Function to handle image upload
    function uploadImages_QLTY() {
        var imagesInput = document.getElementById('imagesInput');
        var po = document.querySelector('[name="process_order_number_quality"]').value || null;
        console.log(po);

        var formData = new FormData();

        // Append each selected image to the formData
        for (var i = 0; i < imagesInput.files.length; i++) {
            formData.append('images[]', imagesInput.files[i]);
        }

        // Append other form data if needed
        formData.append('process_order_number', po);

        // Send the images using AJAX
        $.ajax({
            url: '/upload_qltyimages',
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
            success: function (response) {
                console.log('Images uploaded successfully');
                // Handle success response if needed
            },
            error: function (xhr, status, error) {
                console.error('Error uploading images:', error);
                // Handle error if needed
            }
        });
    }
</script>
