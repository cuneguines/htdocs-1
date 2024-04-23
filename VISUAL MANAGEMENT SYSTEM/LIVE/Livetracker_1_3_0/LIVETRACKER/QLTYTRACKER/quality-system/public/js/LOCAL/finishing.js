function generateFinishingFieldset(processOrder, qualityStep, username) {
    $("#sign_off_finishing").val(username);
    return `
    <fieldset>
    <legend>Finishing</legend>

    <!-- Subtask 9.1: Pickle and Passivate -->
    <div class="form-group">
        <label>
            Pickle and Passivate:
            <input type="checkbox" name="pickle_passivate_test" onchange="toggleDropdown(this, 'pickle_passivate_document_ref')">
            <select name="pickle_passivate_document_ref" disabled>
            <option value="NULL">NULL</option>
                <option value="Document_REF_1">Document REF 1</option>
                <option value="Document_REF_2">Document REF 2</option>
                <option value="Document_REF_3">Document REF 3</option>
                <!-- Add more options as needed -->
            </select>
        </label>
    </div>

    <!-- Upload Pickle and Passivate Documents -->
    <div class="form-group">
        <label>
            Upload Pickle and Passivate Documents:
            <input type="file" name="pickle_passivate_documents" multiple>
        </label>
    </div>

    <!-- Subtask 9.2: Select Kent Finish -->
    <div class="form-group">
        <label>
            Select Kent Finish:
            <input type="checkbox" name="select_kent_finish_test" onchange="toggleDropdown(this, 'select_kent_finish_document_ref')">
            <select name="select_kent_finish_document_ref" disabled>
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
            <option value="Sub-Con Hot Dip Galvanised Duplex coating [powder coated]">Hot Dip Galvanised Duplex coating [powder coated] [KF15]</option>
            <option value="Sub-Con Corten steel">Corten steel [KF16]</option>
            <option value="SOP-0321">Welds as laid - refer to weld map [KF17]</option>
            <option value="SOP-0322">Welds ground Flush - refer to weld map [KF18]</option>
            <option value="SOP-0323">Welds Blended and Buffed - refer to weld map [KF19]</option>
            <option value="SOP-0430">Waxed Bead Blasting [KF20]</option>
            <option value="Sub-Con Anodised Aluminium">Anodised Aluminium[ KF21]</option>
            <option value="SOP-0570">Oiled Mild Steel [KF 22]</option>
            <option value="Sub-Con ZINGA coating mild steel">ZINGA coating mild steel [KF 23]</option>
            <!-- Add more options as needed -->
        </select>
        
        </label>
    </div>

    <!-- Upload Select Kent Finish Documents -->
    <div class="form-group">
        <label>
            Upload Select Kent Finish Documents:
            <input type="file" name="select_kent_finish_documents" multiple>
        </label>
    </div>

    <!-- Sign-off for Finishing -->
    <div class="form-group">
        <label>
            Sign-off for Finishing:
            <input type="text" name="sign_off_finishing" value="${username}">
        </label>
    </div>

    <!-- Comments for Finishing -->
    <div class="form-group">
        <label>
            Comments for Finishing:
            <textarea name="comments_finishing" rows="4" cols="50"></textarea>
        </label>
    </div>

    <!-- Submit button -->
    <button type="button" onclick="submitFinishingForm('${processOrder}')">Submit Finishing Form</button>
</fieldset>
    `;
}


function submitFinishingForm(processOrder) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }

    var formData = new FormData();
    formData.set('pickle_passivate_test', document.querySelector('[name="pickle_passivate_test"]').checked ? 1 : 0);
    formData.set('pickle_passivate_document_ref', document.querySelector('[name="pickle_passivate_document_ref"]').value);
    formData.set('pickle_passivate_document_file_name', getFileName('pickle_passivate_documents'));
    formData.set('select_kent_finish_test', document.querySelector('[name="select_kent_finish_test"]').checked ? 1 : 0);
    formData.set('select_kent_finish_document_ref', document.querySelector('[name="select_kent_finish_document_ref"]').value);
    formData.set('select_kent_finish_document_file_name', getFileName('select_kent_finish_documents'));
    formData.set('sign_off_finishing', document.querySelector('[name="sign_off_finishing"]').value);
    formData.set('comments_finishing', document.querySelector('[name="comments_finishing"]').value);
    formData.set('submission_date', new Date().toISOString().split("T")[0]); // Get today's date in YYYY-MM-DD format
    formData.set('process_order_number', processOrder);

    console.log(formData);

    // Send an AJAX request to the server
    $.ajax({
        url: "/submitFinishingForm",
        type: "POST",
        data: formData,
        headers: headers,
        processData: false, // Prevent jQuery from automatically processing the data
        contentType: false, // Prevent jQuery from setting content type
        success: function (response) {
            console.log(response);
            alert("Finishing form submitted successfully");
            // Optionally update the table or perform other actions
        },
        error: function (error) {
            console.error("Error:", error);
            alert("Error submitting Finishing form");
        },
    });

    var fileData = new FormData();
    var fileInputs = $('[name="pickle_passivate_documents"], [name="select_kent_finish_documents"]');

    // Add process_order_number to FormData
    fileData.append('process_order_number', processOrder);

    // Iterate over each file input and append files to FormData
    fileInputs.each(function (index, fileInput) {
        var files = fileInput.files;
        if (files.length > 0) {
            // Append each file to FormData
            $.each(files, function (i, file) {
                fileData.append(fileInput.name + '_' + i, file);
            });
        }
    });

    console.log(fileData);

    // Send an AJAX request for file uploads
    $.ajax({
        url: '/handleFileUploadFinishing',  // Update to your actual route
        type: 'POST',
        data: fileData,
        headers: headers,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            alert('Files uploaded successfully');
        },
        error: function (error) {
            console.error(error);
            alert('Error uploading files');
        }
    });
}

function generateFinishingFieldTable(processOrder, qualityStep) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: processOrder,
    };

    $.ajax({
        url: "/getFinishingDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML = generateHTMLFromResponse_for_finishing(response);

            $("#finishingFieldTable").html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        },
    });

    return `
        <div>Loading Finishing Data...</div>
    `;
}

function generateHTMLFromResponse_for_finishing(response) {
    var html = '<table id="common_table" style="width:100%;">';
    html += '<thead><tr>';
    html += '<th style="width:5%;">Finishing ID</th>';
    html += '<th style="width:20%;">Process Order</th>';
    html += '<th style="width:20%;">Pickle Passivate Document Ref</th>';
    html += '<th style="width:20%;">Pickle Passivate Test</th>';
    html += '<th style="width:20%;">Select Kent Finish Document Ref</th>';
    html += '<th style="width:20%;">Select Kent Finish Test</th>';
    html += '<th style="width:10%;">Sign-off for Finishing</th>';
    html += '<th style="width:10%;">Finishing Files</th>';
    html += '<th style="width:20%;">Comments for Finishing</th>';
    html += '<th style="width:20%;">Submitted Date Time</th>';
    html += '<th style="width:5%;">Created At</th>';
    html += '<th style="width:5%;">Updated At</th>';
    html += '</tr></thead><tbody>';

    $.each(response, function (index, item) {
        html += "<tr>";
        html += "<td>" + item.id + "</td>";
        html += "<td>" + item.process_order_number + "</td>";
        html += "<td>" + item.pickle_passivate_document_ref + "</td>";
        html += "<td>" + (item.pickle_passivate_test === "1" ? "✔" : "") + "</td>";
        html += "<td>" + item.select_kent_finish_document_ref + "</td>";
        html += "<td>" + (item.select_kent_finish_test === "1" ? "✔" : "") + "</td>";
        html += '<td style="text-align:center;">' + item.sign_off_finishing + "</td>";
        html += '<td style="text-align:center;">';

        if (item.pickle_passivate_document_file_name || item.select_kent_finish_document_file_name) {
            var picklePassivateFilePath = 'storage/finishing_task/' + item.process_order_number + '/' + item.pickle_passivate_document_file_name;
            var selectKentFinishFilePath = 'storage/finishing_task/' + item.process_order_number + '/' + item.select_kent_finish_document_file_name;
            var downloadLinks = '';
            if (item.pickle_passivate_document_file_name) {
                downloadLinks += '<a href="' + picklePassivateFilePath + '" download>Download Pickle Passivate File</a>';
            }
            if (item.select_kent_finish_document_file_name) {
                downloadLinks += (downloadLinks ? '<br>' : '') + '<a href="' + selectKentFinishFilePath + '" download>Download Select Kent Finish File</a>';
            }
            html += downloadLinks;
        } else {
            html += '-';
        }
        html += '</td>';

        html += "<td>" + item.comments_finishing + "</td>";
        html += "<td>" + item.submission_date + "</td>";
        html += "<td>" + item.created_at + "</td>";
        html += "<td>" + item.updated_at + "</td>";
        html += "</tr>";
    });

    html += "</tbody></table>";

    return html;
}

