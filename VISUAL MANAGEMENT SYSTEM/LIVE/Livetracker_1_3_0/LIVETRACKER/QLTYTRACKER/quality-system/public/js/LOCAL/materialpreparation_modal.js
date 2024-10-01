function generateMaterialPreparationFieldset(processOrder, qualityStep, username) {
    $("#sign_off_material_preparation").val(username);
    
}

function generateMaterialPreparationCompleteFieldset(processOrder, qualityStep, username) {
    var formData = {
        process_order_number: processOrder,
    };
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    $("#sign_off_material_preparation").val(username)

    $.ajax({
        url: "/getMaterialPreparationDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            if(response.data)
            {
            var generatedHTML = generateCompleteHTMLFromResponse_for_material_preparation(response);
            $("#materialpreparationCompleteFieldTable").html(generatedHTML);
            }
            else{
                $("#materialpreparationCompleteFieldTable").html('');
            }
        },
        error: function (error) {
            console.error(error);
        },
    });
}


function generateCompleteHTMLFromResponse_for_material_preparation(response) {
    var html = '<fieldset><legend>Material Complete Preparation</legend>';
    html += '<form id="material_complete_preparation_form">';
    html+='<div style="width:97%">';
    $.each(response, function (index, item) {
        html += '<div class="material_item">';
        //html += '<label>ID: ' + item.id + '</label><br>';
        html += '<input style="width:100%"name="process_order_number_mp_c" type="text" value="' + item.process_order_number.trim() + '" readonly>';
        if(item.material_identification)
        {
        html += '<div class="material_field">';
        html +=
        '<label>Material Identification:</label>' +
        (item.material_identification === "on" ?
        '<input type="checkbox" id="compl_material_identification" name="compl_material_identification"  >' :
        '<input type="checkbox" id="compl_material_identification" name="compl_material_identification" disabled>') +
        '</div><br>';
        }
        html += '<div class="material_field">';
        html +=
            '<label>Material Identification Record:</label>' +
            '<input style="width:100%" type="text" name="material_identification_record" value="' + (item.material_identification_record || "") + '">' +
            '</div><br>';

        if (item.material_identification_record_file) {
            var filePath =
                "http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/material_preparation_task/" +
                item.process_order_number +
                "/" +
                item.material_identification_record_file;
           
            var downloadLink = '<a href="' + filePath + '" target="_blank">Download Material Identification Record</a>';
           // html += '<div class="material_field">' + downloadLink + '</div><br>';
        }

       /*  html += '<div class="material_field">';
        html +=
            '<label>Material Traceability:</label>' +
            '<input type="text" name="material_traceability" value="' + (item.material_traceability || "") + '">' +
            '</div><br>'; */

            if (item.material_traceability === "on") {
                html += '<div class="material_field">';
                html +=
                    '<label>Material Traceability:</label>' +
                    '<input type="checkbox" id="material_traceability" name="compl_material_traceability">' +
                    '</div><br>';
            } else {
                html += '<div class="material_field">';
                html +=
                    '<label>Material Traceability:</label>' +
                    '<input type="checkbox" id="material_traceability" name="compl_material_traceability" disabled>' +
                    '</div><br>';
            }
            

        if (item.material_traceability_file) {
            var filePath =
                "http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/material_preparation_task/" +
                item.process_order_number +
                "/" +
                item.material_traceability_file;
                
                var downloadLink = '<a href="' + filePath + '" target="_blank">Download Material Traceability Cert</a>';
           // html += '<div class="material_field">' + downloadLink + '</div><br>';
        }

        

// Check if Machining is "on" to display the completion checkbox
if (item.cutting === "on") {
    html += '<div class="material_field">';
    html +=
        '<label>Complete Cutting:</label>' +
        '<input type="checkbox" id="cutting" name="compl_cutting">' +
        '</div><br>';
} else {
    html += '<div class="material_field">';
    html +=
    '<label>Complete Cutting:</label>' +
        '<input type="checkbox" id="cutting" name="cutting"disabled>' +
        '</div><br>';
}

if (item.machining === "on") {
    html += '<div class="material_field">';
    html +=
        '<label>Complete Machining:</label>' +
        '<input type="checkbox" id="machining" name="compl_machining">' +
        '</div><br>';
} else {
    html += '<div class="material_field">';
    html +=
    '<label>Complete Machining:</label>' +
        '<input type="checkbox" id="machining" name="machining"disabled>' +
        '</div><br>';
}

if (item.forming === "on") {
    html += '<div class="material_field">';
    html +=
        '<label>Complete Forming:</label>' +
        '<input type="checkbox" id="forming" name="compl_forming">' +
        '</div><br>';
} else {
    html += '<div class="material_field">';
    html +=
    '<label>Complete Forming:</label>' +
        '<input type="checkbox" id="forming" name="forming"disabled>' +
        '</div><br>';
}


if (item.deburring === "on") {
    html += '<div class="material_field">';
    html +=
        '<label>Complete De-burring:</label>' +
        '<input type="checkbox" id="deburring" name="compl_deburring">' +
        '</div><br>';
} else {
    html += '<div class="material_field">';
    html +=
    '<label>Complete De-burring:</label>' +
        '<input type="checkbox" id="deburring" name="deburring"disabled>' +
        '</div><br>';
}
      

        html += '<div class="material_field">';
        html +=
            '<label>Sign Off:</label>' +
            '<input style="width:100%"type="text" name="sign_off_material_preparation_c" value="' + userName + '">' +
            '</div><br>';

        html += '<div class="material_field">';
        html +=
            '<label>Comments:</label>' +
            '<input style="width:100%" type="text" name="comments_material_preparation" value="' + item.comments_material_preparation + '">' +
            '</div><br>';

        html += '</div>'; // Closing div for material_item
        html += '<hr>'; // Horizontal line for separation
        html += '<input type="button" value="View" onclick="viewMaterialCompletePreparationForm(\'' + item.process_order_number + '\')">';
    });

    html += '<input type="button" value="Submit" onclick="submitMaterialCompletePreparationForm()">';
    html += '</form>';

    html += '<div id="material_complete_preparation_results"></div>';
    html+='</div>';
    html += '</fieldset>';

    return html;
}

function viewMaterialCompletePreparationForm(po)
{
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };
    var formData = {po:document.querySelector('[name="process_order_number_mp_c"]').value};
    var formData = {po:document.querySelector('[name="process_order_number_mp_c"]').value};
   
    var formData = {po:document.querySelector('[name="process_order_number_mp_c"]').value};
   
    var formData = {po:document.querySelector('[name="process_order_number_mp_c"]').value};
   
   
console.log(formData);

    $.ajax({
        type: "POST",
        url: "/viewMaterialCompletePreparationForm",
        data: formData,
        headers: headers,
        dataType: "json",
       
        success: function (response) {
            console.log(response);
            displayMaterialPreparationResults(response);
            
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}
 







function submitMaterialCompletePreparationForm() {
   // var formData = new FormData(document.getElementById("material_complete_preparation_form"));
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }
    var formData = {
        material_identification: document.querySelector(
            '[name="compl_material_identification"]'
        )? (document.querySelector(
            '[name="compl_material_identification"]').checked ? "on" : null) : null,
        material_identification_record: document.querySelector(
            '[name="material_identification_record"]'
        ).value,
        material_traceability: document.querySelector('[name="compl_material_traceability"]') ? (document.querySelector('[name="compl_material_traceability"]').checked ? "on" : null) : null,
        cutting: document.querySelector('[name="compl_cutting"]') ? (document.querySelector('[name="compl_cutting"]').checked ? "on" : null) : null,
       

        deburring: document.querySelector('[name="compl_deburring"]') ? (document.querySelector('[name="compl_deburring"]').checked ? "on" : null) : null,
        forming: document.querySelector('[name="compl_forming"]') ? (document.querySelector('[name="compl_forming"]').checked ? "on" : null) : null,
        machining: document.querySelector('[name="compl_machining"]') ? (document.querySelector('[name="compl_machining"]').checked ? "on" : null) : null,
        
          //  "material_identification_record_file"
      //  ),
        //material_traceability_file: getFileName("material_traceability_file"),
        sign_off_material_preparation: document.querySelector(
            '[name="sign_off_material_preparation_c"]'
        ).value,
        comments_material_preparation: document.querySelector(
            '[name="comments_material_preparation"]'
        ).value,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number: document.querySelector('[name="process_order_number_mp_c"]').value,
        // Add other form fields accordingly
    };

    if(formData.cutting)
        {
   // cutting: document.querySelector('[name="compl_cutting"]') ? (document.querySelector('[name="compl_cutting"]').checked ? "on" : null) : null,
   formData.cutting_person = document.querySelector('[name="sign_off_material_preparation_c"]').value;

}
if(formData.deburring)
    {
// cutting: document.querySelector('[name="compl_cutting"]') ? (document.querySelector('[name="compl_cutting"]').checked ? "on" : null) : null,
formData.deburring_person = document.querySelector('[name="sign_off_material_preparation_c"]').value;

}
if(formData.machining)
    {
// cutting: document.querySelector('[name="compl_cutting"]') ? (document.querySelector('[name="compl_cutting"]').checked ? "on" : null) : null,
formData.machining_person = document.querySelector('[name="sign_off_material_preparation_c"]').value;

}
if(formData.forming)
    {
// cutting: document.querySelector('[name="compl_cutting"]') ? (document.querySelector('[name="compl_cutting"]').checked ? "on" : null) : null,
formData.forming_person = document.querySelector('[name="sign_off_material_preparation_c"]').value;

}


    console.log(formData);
    $.ajax({
        type: "POST",
        url: "/submitMaterialCompletePreparationForm",
        data: formData,
        headers:headers,
        dataType: "json",
        success: function (response) {
            displayMaterialPreparationResults(response);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}

function displayMaterialPreparationResults(values) {
    var resultsHtml = '<table id="material_preparation_results_table" style="width:100%; border-collapse: collapse; border: 1px solid #ddd; text-align: left;">';
    resultsHtml += '<thead><tr style="background-color: #f2f2f2;"><th style="padding: 8px; border-bottom: 1px solid #ddd;">Field</th><th style="padding: 8px; border-bottom: 1px solid #ddd;">Value</th></tr></thead>';
    resultsHtml += '<tbody>';

    function buildTableRows(obj, prefix) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key)) {
                var value = obj[key];
                console.log(key);
                var field = key;
                if (typeof value === 'object') {
                    console.log('YES');
                    buildTableRows(value, field);
                } else {
                    if (value=="on")
                    {
                    resultsHtml += '<tr><td style="padding: 8px; border-bottom: 1px solid #ddd;">' + field + '</td><td style="padding: 8px; border-bottom: 1px solid #ddd;"> &#10003;</td></tr>';
                    }
                    else
                    {
                        resultsHtml += '<tr><td style="padding: 8px; border-bottom: 1px solid #ddd;">' + field + '</td><td style="padding: 8px; border-bottom: 1px solid #ddd;">' + value + '</td></tr>';
                    }

                }
            }
        }
    }

    buildTableRows(values);

    resultsHtml += '</tbody></table>';

    document.getElementById('material_complete_preparation_results').innerHTML = resultsHtml;
}



    
function generateMaterialPreparationFieldset(
    processOrder,
    qualityStep,
    username
) {
    $("#sign_off_material_preparation").val(username);
    return `
   
    `;
}

function submitMaterialPreparationForm(processOrder) {
    // Add your logic to handle the form submission for the material preparation fieldset

    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };
    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }


    var owners_mat = [];
    document.querySelectorAll('#materialprep tbody tr').forEach(function (row, index) {
        if (index >= 0) { // Skip the header row
            var ownerElement = row.querySelector('[name="owner_mat"]');
            var ndtElement = row.querySelector('[name="ndttype_mat"]');
    
            owners_mat.push({
                type: row.cells[0].innerText.trim(),
                owner: ownerElement ? ownerElement.value || null : null,
                ndt: ndtElement ? ndtElement.value || null : null
            });
        }
    });
    var formData = {
        material_identification: document.querySelector( '[name="material_identification"]').checked ? "on" : "",
        //material_identification_record: document.querySelector('[name="material_identification_record"]).checked ? "on" : "",
        material_traceability: document.querySelector('[name="material_traceability"]').checked ? "on" : "",
        cutting: document.querySelector('[name="cutting"]').checked ? "on" : "",
        deburring: document.querySelector('[name="deburring"]').checked ? "on" : "",
        forming: document.querySelector('[name="forming"]').checked ? "on" : "",
        machining: document.querySelector('[name="machining"]').checked ? "on" : "",

        material_identification_record: (document.querySelector('[name="material_identification_record_file"]').files.length > 0)
        ? document.querySelector('[name="material_identification_record_file"]').files[0].name
        : document.getElementById('old-file-name_3').textContent.trim(),

        material_identification_record_file: (document.querySelector('[name="material_identification_record"]').files.length > 0)
        ? document.querySelector('[name="material_identification_record"]').files[0].name
        : document.getElementById('old-file-name_1').textContent.trim(),


        tube_laser_pack_file: (document.querySelector('[name="tube_laser_pack_file"]').files.length > 0)
        ? document.querySelector('[name="tube_laser_pack_file"]').files[0].name
        : document.getElementById('old-file-name_4').textContent.trim(),

        laser_and_press_brake_file: (document.querySelector('[name="laser_and_press_brake_file"]').files.length > 0)
       ? document.querySelector('[name="laser_and_press_brake_file"]').files[0].name
       : document.getElementById('old-file-name_5').textContent.trim(),
     
        sign_off_material_preparation: document.querySelector(
            '[name="sign_off_material_preparation"]'
        ).value,
        comments_material_preparation: document.querySelector(
            '[name="comments_material_preparation"]'
        ).value,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number: (document.querySelector('[name="process_order_number_mp"]').value.trim() !== "")
        ? document.querySelector('[name="process_order_number_mp"]').value.trim()
        : null,
        // Add other form fields accordingly
        owners_mat:owners_mat,

    };
    console.log(formData);
    // Send an AJAX request to the server
    $.ajax({
        url: "/submitMaterialPreparationForm",
        type: "POST",
        data: formData,
        headers: headers,
        success: function (response) {
            // Handle the success response if needed
            console.log(response);
            alert("success");
            $("#myModal").hide();
            updateTable(response);
            function updateTable(response) {
                // Assuming your table has an ID, update the table rows dynamically
                var newRow =
                    "<tr><td>" +
                    response.name +
                    "</td><td>" +
                    response.path +
                    "</td></tr>";
                $("#yourTableId tbody").append(newRow);
            }
        },
        error: function (error) {
            // Handle the error response if needed
            console.error(error);
        },
    });
    // File uploads
    // File uploads
    var fileData = new FormData();
    var fileInputs = $('[type="file"]');

    // Add process_order_number to FormData
    fileData.append("process_order_number", document.querySelector('[name="process_order_number_mp"]').value.trim());

    // Iterate over each file input and append files to FormData
    fileInputs.each(function (index, fileInput) {
        var files = fileInput.files;
        if (files.length > 0) {
            // Append each file to FormData
            $.each(files, function (i, file) {
                fileData.append(fileInput.name + "_" + i, file);
            });
        }
    });
    console.log(fileData);
    // Send an AJAX request for file uploads
    $.ajax({
        url: "/handleFileUploadMaterialPreparation", // Update to your actual route
        type: 'POST',
        data: fileData,
        headers: headers,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            alert("Files uploaded successfully");
        },
        error: function (error) {
            console.error(error);
            alert("Error uploading files");
        },
    });


    
    console.log("Mat Preparation form submitted!");
}

function generateMaterialPreparationFieldTable(processOrder, qualityStep) {
    console.log(processOrder);

    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: processOrder,
    };

    $.ajax({
        url: "/getMaterialPreparationDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML =
                generateHTMLFromResponse_for_material_preparation(response);

            $("#materialpreparationFieldTable").html(generatedHTML);
           
        },
        error: function (error) {
            console.error(error);
        },
    });

    return `
            <div>To be Done</div>
        `;
}

function generateHTMLFromResponse_for_material_preparation_old(response) {
    var html = '<form id="materialPreparationForm" class="material-preparation-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Material Preparation</legend>';
    html+='<div style="width:97%">';
    $.each(response, function(index, item) {
        
        html += '<div class="form-group">';
       // html += '<label for="id">ID:</label>';
        //html += '<input type="text" id="id" name="id" value="' + item.id + '" readonly>';
        html += '</div>';
        
      
        html += '<div class="form-group">';
        html += '<label for="material_identification">Material Identification:</label>';
        html += '<input type="checkbox" id="material_identification" name="material_identification" ' + (item.material_identification ? 'checked' : 'disabled') + '>';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="material_identification_record">Material Identification Cert:</label>';
        
        //html += '<input type="text" id="material_identification_record" name="material_identification_record" value="' + (item.material_identification_record || '') + '">';


        if (item.material_identification_record) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/material_preparation_task/' + item.process_order_number + '/' + item.material_identification_record;
            var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.material_identification_record+'</a>';
            //html += '<input type="file" id="material_identification_record" name="material_identification_record">';
            
            html +=downloadLink;
        } else {
            html += '<label  id="material_identification_record" name="material_identification_record">';
        }
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="material_identification_record_file">Material Identification Record File:</label>';
        if (item.material_identification_record_file) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/material_preparation_task/' + item.process_order_number + '/' + item.material_identification_record_file;
            var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.material_identification_record_file+'</a>';
            //html += '<input type="file" id="material_identification_record_file" name="material_identification_record_file">';
         
            html+=downloadLink;
        } else {
            html += '<label id="material_identification_record_file" name="material_identification_record_file">';
        }
        html += '</div>';

        if(item.material_traceability)
        {
        html += '<div class="form-group">';
        html += '<label for="material_traceability">Material Traceability:</label>';
        html += '<input type="checkbox" id="material_traceability" name="material_traceability" ' + (item.material_traceability ? 'checked' : 'disabled') + '>';

        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="material_traceability_file">Material Traceability File:</label>';
        }
        if (item.material_traceability_file) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/material_preparation_task/' + item.process_order_number + '/' + item.material_traceability_file;
            var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.material_traceability_file+ '</a>';
           // html += '<input type="file" id="material_traceability_file" name="material_traceability_file">';
            
            html +=downloadLink;
        } else {
            html += '<label id="material_traceability_file" name="material_traceability_file">';
        }
        html += '</div>';

       
        html += '<div class="form-group">';
        html += '<label for="cutting">Tube Laser Pack:</label>';
        html += '<input type="checkbox" id="cutting" name="cutting" ' + ((item.cutting === 'true' || item.cutting === 'on') && item.cutting !== null ? 'checked' : 'disabled') + '>';
        html += '</div>';
        
        if (item.tube_laser_pack_file) {
           
            var filePath =
                "http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/material_preparation_task/" +item.process_order_number +"/" +item.tube_laser_pack_file;
           
                var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.tube_laser_pack_file+'</a>';
                //html += '<input type="file" id="material_identification_record_file" name="material_identification_record_file">';
             
                html+=downloadLink;
           // html += '<div class="material_field">' + downloadLink + '</div><br>';
        }
        html += '<div class="form-group">';
        html += '<label for="deburring">De-burring:</label>';
        html += '<input type="checkbox" id="deburring" name="deburring" ' + ((item.deburring === 'true' || item.deburring === 'on') && item.deburring !== null ? 'checked' : 'disabled') + '>';
        html += '</div>';
       
        html += '<div class="form-group">';
        html += '<label for="forming">Laser and Press Brake Pack</label>';
        html += '<input type="checkbox" id="forming" name="forming" ' + ((item.forming === 'true' || item.forming === 'on') && item.forming !== null ? 'checked' : 'disabled') + '>';
        html += '</div>';
        if (item.laser_and_press_brake_file) {
            var filePath =
                "http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/material_preparation_task/" +
                item.process_order_number +
                "/" +
                item.laser_and_press_brake_file;
           
                var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.laser_and_press_brake_file+'</a>';
                //html += '<input type="file" id="material_identification_record_file" name="material_identification_record_file">';
             
                html+=downloadLink;
           // html += '<div class="material_field">' + downloadLink + '</div><br>';
        }
        html += '<div class="form-group">';
        html += '<label for="machining">Machining:</label>';
        html += '<input type="checkbox" id="machining" name="machining" ' + ((item.machining === 'true' || item.machining === 'on') && item.machining !== null ? 'checked' : 'disabled') + '>';
        html += '</div>';
        
    
        html += '<div class="form-group">';
        html += '<label for="sign_off_material_preparation">Sign-off:</label>';
        html += '<input style="width:100%" type="text" id="sign_off_material_preparation" name="sign_off_material_preparation" value="' + (item.sign_off_material_preparation || '') + '">';
        html += '</div>';

        html += '<div class="form-group">';
        html += '<label for="comments_material_preparation">Comments:</label>';
        html += '<textarea  style="width:100%"id="comments_material_preparation" name="comments_material_preparation">' + (item.comments_material_preparation || '') + '</textarea>';
        html += '</div>';

        html += '<hr>'; // Add a separator between items
    });

    html+='</div>';
    html += '</fieldset></form>';

    return html;
}

function generateHTMLFromResponse_for_material_preparation(response) {
    var html = '<form id="materialPreparationForm" class="material-preparation-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Material Preparation</legend>';
    html += '<table style="width: 100%; border-collapse: collapse;">';
    html += '<thead>';
    html += '<tr>';
    html += '<th style="border: 1px solid #ddd; padding: 8px;">Description</th>';
    html += '<th style="border: 1px solid #ddd; padding: 8px;">File Link</th>';
    html += '</tr>';
    html += '</thead>';
    html += '<tbody>';
    
    $.each(response, function(index, item) {
        // Material Identification
        html += '<tr>';
        html += '<td style="border: 1px solid #ddd; padding: 8px;">';
        html += '<input type="checkbox" id="material_identification_' + index + '" name="material_identification" ' + (item.material_identification ? 'checked' : 'disabled') + '>';
        html += ' Material Identification:';
        html += '</td>';
        html += '<td style="border: 1px solid #ddd; padding: 8px;">';
        if (item.material_identification_record) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/material_preparation_task/' + item.process_order_number + '/' + item.material_identification_record;
            html += '<a href="' + filePath + '" target="_blank">' + item.material_identification_record + '</a>';
        } else {
            html += 'N/A';
        }
        html += '</td>';


        html += '</td>';
        html += '<td id="owner_1" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_1" style="border: 1px solid #ccc;"></td>';

        fetchOwnerData_mat(item.process_order_number, 'Upload Material Identification Mill Cert', function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('owner_1').innerHTML = ownerData.owner.trim();

                // Update ndt cell
                document.getElementById('ndt_1').innerHTML = ownerData.ndta.trim();
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('owner_1').innerHTML = 'N/A';
                document.getElementById('ndt_1').innerHTML = 'N/A';
            }
        });
        html += '</tr>';

        // Material Identification Record File
        html += '<tr>';
        html += '<td style="border: 1px solid #ddd; padding: 8px;">';
        html += '<input type="checkbox" id="material_identification_record_file_' + index + '" name="material_identification_record_file" ' + (item.material_identification_record_file ? 'checked' : 'disabled') + '>';
        html += ' Material Identification Record File:';
        html += '</td>';
        html += '<td style="border: 1px solid #ddd; padding: 8px;">';
        if (item.material_identification_record_file) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/material_preparation_task/' + item.process_order_number + '/' + item.material_identification_record_file;
            html += '<a href="' + filePath + '" target="_blank">' + item.material_identification_record_file + '</a>';
        } else {
            html += 'N/A';
        }
        html += '</td>';

        html += '</td>';
        html += '<td id="owner_2" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_2" style="border: 1px solid #ccc;"></td>';

        fetchOwnerData_mat(item.process_order_number, 'Upload Material Identification Heat Number', function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('owner_2').innerHTML = ownerData.owner.trim();

                // Update ndt cell
                document.getElementById('ndt_2').innerHTML = ownerData.ndta.trim();
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('owner_2').innerHTML = 'N/A';
                document.getElementById('ndt_2').innerHTML = 'N/A';
            }
        });
        html += '</tr>';

        // Material Traceability
        if (item.material_traceability) {
            html += '<tr>';
            html += '<td style="border: 1px solid #ddd; padding: 8px;">';
            html += '<input type="checkbox" id="material_traceability_' + index + '" name="material_traceability" ' + (item.material_traceability ? 'checked' : 'disabled') + '>';
            html += ' Material Traceability:';
            html += '</td>';
            html += '<td style="border: 1px solid #ddd; padding: 8px;">';
            if (item.material_traceability_file) {
                var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/material_preparation_task/' + item.process_order_number + '/' + item.material_traceability_file;
                html += '<a href="' + filePath + '" target="_blank">' + item.material_traceability_file + '</a>';
            } else {
                html += 'N/A';
            }
            html += '</td>';
            html += '</td>';
        html += '<td id="owner_3" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_3" style="border: 1px solid #ccc;"></td>';

        fetchOwnerData_mat(item.process_order_number, 'Material Traceability', function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('owner_3').innerHTML = ownerData.owner.trim();

                // Update ndt cell
                document.getElementById('ndt_3').innerHTML = ownerData.ndta.trim();
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('owner_3').innerHTML = 'N/A';
                document.getElementById('ndt_3').innerHTML = 'N/A';
            }
        });
            html += '</tr>';
        }

        // Tube Laser Pack
        html += '<tr>';
        html += '<td style="border: 1px solid #ddd; padding: 8px;">';
        html += '<input type="checkbox" id="cutting_' + index + '" name="cutting" ' + ((item.cutting === 'true' || item.cutting === 'on') && item.cutting !== null ? 'checked' : 'disabled') + '>';
        html += ' Tube Laser Pack:';
        html += '</td>';
        html += '<td style="border: 1px solid #ddd; padding: 8px;">';
        if (item.tube_laser_pack_file) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/material_preparation_task/' + item.process_order_number + '/' + item.tube_laser_pack_file;
            html += '<a href="' + filePath + '" target="_blank">' + item.tube_laser_pack_file + '</a>';
        } else {
            html += 'N/A';
        }
        html += '</td>';
        html += '</td>';
        html += '<td id="owner_4" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_4" style="border: 1px solid #ccc;"></td>';

        fetchOwnerData_mat(item.process_order_number, 'Cutting Part geometry, cut quality, part qty', function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('owner_4').innerHTML = ownerData.owner.trim();

                // Update ndt cell
                document.getElementById('ndt_4').innerHTML = ownerData.ndta.trim();
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('owner_4').innerHTML = 'N/A';
                document.getElementById('ndt_4').innerHTML = 'N/A';
            }
        });
        html += '</tr>';

        // De-burring
        html += '<tr>';
        html += '<td style="border: 1px solid #ddd; padding: 8px;">';
        html += '<input type="checkbox" id="deburring_' + index + '" name="deburring" ' + ((item.deburring === 'true' || item.deburring === 'on') && item.deburring !== null ? 'checked' : 'disabled') + '>';
        html += ' De-burring:';
        html += '</td>';
        html += '<td style="border: 1px solid #ddd; padding: 8px;">N/A</td>';
        html += '<td id="owner_5" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_5" style="border: 1px solid #ccc;"></td>';

        fetchOwnerData_mat(item.process_order_number, 'De-burring', function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('owner_5').innerHTML = ownerData.owner.trim();

                // Update ndt cell
                document.getElementById('ndt_5').innerHTML = ownerData.ndta.trim();
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('owner_5').innerHTML = 'N/A';
                document.getElementById('ndt_5').innerHTML = 'N/A';
            }
        });
        html += '</tr>';

        // Laser and Press Brake Pack
        html += '<tr>';
        html += '<td style="border: 1px solid #ddd; padding: 8px;">';
        html += '<input type="checkbox" id="forming_' + index + '" name="forming" ' + ((item.forming === 'true' || item.forming === 'on') && item.forming !== null ? 'checked' : 'disabled') + '>';
        html += ' Laser and Press Brake Pack:';
        html += '</td>';
        html += '<td style="border: 1px solid #ddd; padding: 8px;">';
        if (item.laser_and_press_brake_file) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/material_preparation_task/' + item.process_order_number + '/' + item.laser_and_press_brake_file;
            html += '<a href="' + filePath + '" target="_blank">' + item.laser_and_press_brake_file + '</a>';
        } else {
            html += 'N/A';
        }
        html += '</td>';
        html += '</td>';
        html += '<td id="owner_6" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_6" style="border: 1px solid #ccc;"></td>';

        fetchOwnerData_mat(item.process_order_number, 'Forming', function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('owner_6').innerHTML = ownerData.owner.trim();

                // Update ndt cell
                document.getElementById('ndt_6').innerHTML = ownerData.ndta.trim();
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('owner_6').innerHTML = 'N/A';
                document.getElementById('ndt_6').innerHTML = 'N/A';
            }
        });
        html += '</tr>';

        // Machining
        html += '<tr>';
        html += '<td style="border: 1px solid #ddd; padding: 8px;">';
        html += '<input type="checkbox" id="machining_' + index + '" name="machining" ' + ((item.machining === 'true' || item.machining === 'on') && item.machining !== null ? 'checked' : 'disabled') + '>';
        html += ' Machining:';
        html += '</td>';
        html += '<td style="border: 1px solid #ddd; padding: 8px;">N/A</td>';
        html += '</td>';
        html += '<td id="owner_7" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_7" style="border: 1px solid #ccc;"></td>';

        fetchOwnerData_mat(item.process_order_number, 'Machining', function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('owner_7').innerHTML = ownerData.owner.trim();

                // Update ndt cell
                document.getElementById('ndt_7').innerHTML = ownerData.ndta.trim();
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('owner_7').innerHTML = 'N/A';
                document.getElementById('ndt_7').innerHTML = 'N/A';
            }
        });
        html += '</tr>';

        // Sign-off
        html += '<tr>';
        html += '<td style="border: 1px solid #ddd; padding: 8px;">';
        html += 'Sign-off:';
        html += '</td>';
        html += '<td style="border: 1px solid #ddd; padding: 8px;" colspan="4"><input style="width:100%" type="text" id="sign_off_material_preparation_' + index + '" name="sign_off_material_preparation" value="' + (item.sign_off_material_preparation || '') + '"></td>';
        html += '</td>';
       

       
        html += '</tr>';

        // Comments
        html += '<tr>';
        html += '<td style="border: 1px solid #ddd; padding: 8px;">';
        html += 'Comments:';
        html += '</td>';
        html += '<td style="border: 1px solid #ddd; padding: 8px;" colspan="4"><textarea style="width:100%" id="comments_material_preparation_' + index + '" name="comments_material_preparation">' + (item.comments_material_preparation || '') + '</textarea></td>';
        html += '</td>';
       

       
        html += '</tr>';
        
         // Add a separator between items
    });

    html += '</tbody>';
    html += '</table>';
    html += '</fieldset></form>';

    return html;
}




function fetchOwnerData_mat(id,Type,callback)
{

    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Replace with the actual CSRF token
        // Include other headers if needed
    };
    var formData = {
        process_order_number: id,
       Type:Type
    };
    
$.ajax({
    url: '/getOwnerData_mat',
    type: 'POST',
    data: formData,
    headers: headers,
    dataType: 'json',
    success: function (response) {

        console.log(response);
        
        callback(response.data[0]);
       
    },
    error: function (error) {
        // Handle the error response if needed
        console.error(error);
    }
});
}



function resetMaterialPrepForm() {
    // Uncheck checkboxes
    $('[name="cutting"]').prop('checked', false);
    $('[name="deburring"]').prop('checked', false);
    $('[name="forming"]').prop('checked', false);
    $('[name="machining"]').prop('checked', false);
    $('[name="material_identification"]').prop('checked', false);
    $('[name="material_traceability"]').prop('checked', false);

    // Clear text inputs
   // $('[name="material_identification"]').val('');
    //$('[name="material_identification_record"]').val('');
   // $('[name="material_traceability"]').val('');
    $('[name="sign_off_material_preparation"]').val('');
    $('[name="comments_material_preparation"]').val('');

    // Reset file input values and old file name display
    $('[name="material_identification_record"]').val('');
    $('[name="material_identification_record_file"]').val('');
    $('[name="material_traceability_file"]').val('');
    $('[name="tube_laser_pack_file"]').val('');
    $('[name="laser_and_press_brake_file"]').val('');
    $('.old-file-name_1').text('');
    $('.old-file-name_2').text('');
    $('.old-file-name_4').text('');
    $('.old-file-name_5').text('');
    $('#old-file-name_1').text('');
    $('#old-file-name_2').text('');
    $('#old-file-name_4').text('');
    $('#old-file-name_5').text('');
    // Reset owner and NDT selects
    $('select[name="owner_mat"]').val('NULL');
    $('select[name="ndttype_mat"]').val('NULL');
}
function MaterialPrep(processOrder, userName) {
    console.log('Material Preparation');
    console.log(userName);
    
    // Hide other fieldsets and show Material Preparation fieldset
    $('#planningFieldset').hide();
    $('#qualityFieldset').hide();
    $('#manufacturingFieldset').hide();
    $('#materialpreparationFieldset').show();

    // Set process order and user name
    $('#sign_off_material_preparation').val(userName);
    $('#process_order_number').val(processOrder);

    // AJAX request headers
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // Add other headers if needed
    };

    var formData = {
        process_order_number: processOrder
        // Add other form data if needed
    };

    // Fetch Material Preparation Form Data for the given process order
    $.ajax({
        url: '/getMaterialPreparationDataByProcessOrder', // Adjust URL as needed
        type: 'POST',
        headers: headers,
        data: formData,
        dataType: 'json',
        success: function (response) {
            resetMaterialPrepForm();
            console.log(response);
            $('#sign_off_material_preparation').val(userName);
            
            if (response.data != null) {
                console.log('Material Prep data found');
                $.each(response, function (index, item) {
                    console.log(item.cutting);
                    $('#process_order_number_mp').val(processOrder);

                    // Set checkbox values
                    $('input[name="cutting"]').prop('checked', item.cutting === 'on');
                    fetchOwnerData_mat(processOrder, 'Cutting Part geometry, cut quality, part qty', function (ownerData) {
                        if (ownerData) {
                            // Update owner cell
                            $(`select[name="owner_mat"][data-task="Cutting"]`).val(ownerData.owner.trim());
                            // Update NDT cell
                            $(`select[name="ndttype_mat"][data-task="Cutting"]`).val(ownerData.ndta.trim());
                        } else {
                            // Handle case where no owner data is retrieved
                            $(`select[name="owner_mat"][data-task="Cutting"]`).val('NULL');
                            $(`select[name="ndttype_mat"][data-task="Cutting"]`).val('NULL');
                        }
                    });
                  
                    $('input[name="deburring"]').prop('checked', item.deburring === 'on');
                    $('input[name="forming"]').prop('checked', item.forming === 'on');
                    $('input[name="machining"]').prop('checked', item.machining === 'on');
                    $('input[name="material_traceability"]').prop('checked', item.material_traceability === 'on');


                    fetchOwnerData_mat(processOrder, 'Material Traceability', function (ownerData) {
                        if (ownerData) {
                            // Update owner cell
                            $(`select[name="owner_mat"][data-task="Material Traceability"]`).val(ownerData.owner.trim());
                            // Update NDT cell
                            $(`select[name="ndttype_mat"][data-task="Material Traceability"]`).val(ownerData.ndta.trim());
                        } else {
                            // Handle case where no owner data is retrieved
                            $(`select[name="owner_mat"][data-task="Material Traceability"]`).val('NULL');
                            $(`select[name="ndttype_mat"][data-task="Material Traceability"]`).val('NULL');
                        }
                    });
                    $('input[name="material_identification"]').prop('checked', item.material_identification === 'on');

                    // Other fields
                    $('#sign_off_material_preparation').val(userName);
                    $('#comments_material_preparation').val(item.comments_material_preparation);

                    // File input fields
                    $('#material_identification_record').val(item.material_identification_record);
                    //$('#material_identification').val(item.material_identification);
                    
                   // $('#material_traceability').val(item.material_traceability);
                    $('#old-file-name_1').text(item.material_identification_record_file);
                    $('#old-file-name_2').text(item.material_traceability_file);
                    $('#old-file-name_3').text(item.material_identification_record);
                    $('#old-file-name_4').text(item.tube_laser_pack_file);
                    $('#old-file-name_5').text(item.laser_and_press_brake_file);

                    // Set the labels for file inputs
                    $('#material_identification_record_file_label').show();
                    $('#material_traceability_file_label').show();

                    // Attach handlers for file input changes
                    $('#material_identification_record_file').change(function () {
                        $('#old-file-name_1').text(this.files[0].name);
                    });

                    $('#material_traceability_file').change(function () {
                        $('#old-file-name_1').text(this.files[0].name);
                    });

                    $('#material_identification_record').change(function () {
                        $('#old-file-name_3').text(this.files[0].name);
                    });
                    $('#tube_laser_pack_file').change(function () {
                        $('#old-file-name_4').text(this.files[0].name);
                    });
                    $('#laser_and_press_brake_file').change(function () {
                        $('#old-file-name_5').text(this.files[0].name);
                    });


                });
            } else {
                resetMaterialPrepForm();
                console.log('hete');
                $('#sign_off_material_preparation').val(userName);
                $('#materialpreparationFieldset').show();
                $('#process_order_number_mp').val(processOrder);
            }
        },
        error: function (error) {
            console.error(error);
        }
    });
}
