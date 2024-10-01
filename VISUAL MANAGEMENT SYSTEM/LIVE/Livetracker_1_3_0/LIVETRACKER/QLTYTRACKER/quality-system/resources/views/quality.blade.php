<!--<fieldset>

    <legend>Quality Checks</legend>
    <div style="width:97%">
    <div class="form-group">
        <label>
        Process Order Number:
            <input style="width:100%"type="text" name="process_order_number_quality" id="process_order_number_quality" readonly>
            
        </label>
    </div>
    <!-- Walk-down and Visual Inspection 
    <div class="form-group">
        <label>
            <input type="checkbox" name="walk_down_visual_inspection" id="walk_down_visual_inspection">
            Walk-down and Visual Inspection
        </label>
    </div>

    <!-- Photographic Record -->

    <!-- Upload Images 
    <div class="form-group">
        <label>
           
            <input type="checkbox" name="upload_images" id="upload_images">
            Upload Images:
            <!-- Upload Images button -->
            <br>
            <!-- <button type="button" onclick="uploadImages_QLTY()">Upload Images</button> 
            <br>
        </label>
    </div>
    <div class="form-group">
        <label>
            Sign-off for Quality:
            <!-- <input type="text" name="sign_off_quality_l" id="sign_off_quality_l" value="${username}"> 
            <input style="width:100%" type="text" name="sign_off_quality_m" value="${username}" id="sign_off_quality">

           

        </label>
    </div>

    <!-- Comments for Main Task 1 
    <div class="form-group">
        <label>
            Comments for Quality:
            <textarea style="width:100%"name="comments_quality_m" id="comments_quality" rows="4" cols="50"></textarea>
        </label>
    </div>

    <!-- Submit button 
    <div style="display:none" name="uuidDisplay" id="uuidDisplay"></div>
    <button type="submit" onclick="submitQualityForm()">Submit Quality Checks</button>
            </div>
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
uuidDisplay.textContent = uuid;
//$('#sign_off_quality_m').val(username);
console.log(username);

</script>
            -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quality Checks</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        td,
        th {
            padding: 10px;
            text-align: left;
            border: 1px solid black;
        }

        .form-group {
            display: flex;
            align-items: center;
        }

        .form-group label {
            flex: 1;
        }
    </style>
</head>

<body>
    <fieldset>
        <legend>Quality Checks</legend>
        <div style="width: 98%">
            <table>
                <tr>
                    <td>Process Order Number:</td>
                    <td colspan="4">
                        <input style="width: 100%" type="text" name="process_order_number_quality" id="process_order_number_quality" readonly>
                    </td>
                </tr>
            </table>

            <table id="quality_checks">
                <thead>
                    <tr>
                        <th>Quality Check</th>
                        <th>Owner</th>
                        <th>NDT Type</th>
                     
                    </tr>
                </thead>
                <tbody>
                    <!-- Walk-down and Visual Inspection -->
                    <tr>
                        <td class="form-group">
                            <label>
                                <input type="checkbox" name="walk_down_visual_inspection" id="walk_down_visual_inspection">
                                Walk-down and Visual Inspection
                            </label>
                        </td>
                        <td>
                            <select name="owner_quality" style="width: 100%">
                                <option value="NULL">Select Owner</option>
                                <option value="PM">PM</option>
                                <option value="QA">QA</option>
                                <option value="Planning">Planning</option>
                                <option value="Operator">Operator</option>
                                <!-- Add more options as needed -->
                            </select>
                        </td>
                        <td>
                            <select name="ndt_type_quality" style="width: 100%">
                                <option value="NULL">Select NDT Type</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <!-- Add more options as needed -->
                            </select>
                        </td>
                       

                    <!-- Upload Images -->
                    <tr>
                        <td colspan="4" class="form-group">
                            <label>
                                <input type="checkbox" name="upload_images" id="upload_images">
                                Upload Images:
                            </label>
                            <br>
                            <input type="file" id="quality_images" name="quality_images" multiple accept="image/*">
                            <br>
                        </td>
                    </tr>
                    <tr>
                    <label>
                               
                                Sign_off_quality:
                            </label>
                        <td>
                            <input style="width: 100%" type="text" name="sign_off_quality" value="${username}" id="sign_off_quality">
                        </td>
    </tr>
    <tr>
    <label>
                               
                               Comments:
                           </label>
                        <td>
                            <textarea style="width: 100%" name="comments_quality" id="comments_quality" rows="2" cols="50"></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div style="display:none" name="uuidDisplay" id="uuidDisplay"></div>
            <button type="submit" onclick="submitQualityForm()">Submit Quality Checks</button>
        </div>
    </fieldset>

    <script>
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
        uuidDisplay.textContent = uuid;
        console.log(username);
    </script>
</body>

</html>
