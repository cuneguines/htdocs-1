function generateFinalAssemblyFieldset(processOrder, qualityStep, username) {
    $("#sign_off_final_assembly").val(username);
    return `
    <fieldset>
        <legend>Final Assembly</legend>

        <!-- Subtask 11.1: Walk-down and visual inspection -->
        <div class="form-group">
            <label>
                Walk-down and visual inspection:
                <input type="text" name="walk_down_inspection">
            </label>
        </div>

        <!-- Subtask 11.2: Identification -->
        <div class="form-group">
            <label>
                Identification:
                <input type="text" name="identification">
            </label>
        </div>

        <!-- Upload Images -->
        <div class="form-group">
            <label>
                Upload Images:
                <input type="file" name="images[]" id="imagesInput" multiple>
            </label>
        </div>

        <!-- File Uploads for Final Assembly -->
        <div class="form-group">
            <label>
                Upload File 1:
                <input type="file" name="final_assembly_file_1" accept=".pdf,.doc,.docx,.txt">
            </label>
        </div>

        <div class="form-group">
            <label>
                Upload File 2:
                <input type="file" name="final_assembly_file_2" accept=".pdf,.doc,.docx,.txt">
            </label>
        </div>

        <div class="form-group">
            <label>
                Upload File 3:
                <input type="file" name="final_assembly_file_3" accept=".pdf,.doc,.docx,.txt">
            </label>
        </div>

        <!-- Sign-off for Final Assembly -->
        <div class="form-group">
            <label>
                Sign-off for Final Assembly:
                <input type="text" name="sign_off_final_assembly" value="${username}">
            </label>
        </div>

        <!-- Comments for Final Assembly -->
        <div class="form-group">
            <label>
                Comments for Final Assembly:
                <textarea name="comments_final_assembly" rows="4" cols="50"></textarea>
            </label>
        </div>

        <!-- Submit button -->
        <button type="button" onclick="submitFinalAssemblyForm('${processOrder}')">Submit Final Assembly Form</button>

        <!-- Upload Images button -->
        <button type="button" onclick="uploadImages('${processOrder}')">Upload Images</button>
    </fieldset>
    `;
}


var uploadImagesRoute = "{{ route('upload.images') }}";

// Function to handle image upload
function uploadImages(po) {
    var imagesInput = document.getElementById('imagesInput');
    var formData = new FormData();
    
    // Append each selected image to the formData
    for (var i = 0; i < imagesInput.files.length; i++) {
        formData.append('images[]', imagesInput.files[i]);
    }

    // Append other form data if needed
    formData.append('process_order_number', po);
    formData.append('username', '{{ $username }}');

    // Send the images using AJAX
    $.ajax({
        url: '/upload',
        type: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        processData: false,
        contentType: false,
        success: function(response) {
            console.log('Images uploaded successfully');
            // Handle success response if needed
        },
        error: function(xhr, status, error) {
            console.error('Error uploading images:', error);
            // Handle error if needed
        }
    });
}
