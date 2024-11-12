function generateWeldingFieldset(processOrder, qualityStep, username) {
    $("#sign_off_welding").val(username);
    return `
    
    `;
}

function submitWeldingForm(processOrder) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }

    var owners_weld = [];
    document.querySelectorAll('#welding tbody tr').forEach(function (row, index) {
        if (index >= 0) { // Skip the header row
            var ownerElement = row.querySelector('[name="owner_weld"]');
            var ndtElement = row.querySelector('[name="ndttype_weld"]');
    
            owners_weld.push({
                type: row.cells[0].innerText.trim(),
                owner: ownerElement ? ownerElement.value || null : null,
                ndt: ndtElement ? ndtElement.value || null : null
            });
        }
    });

    var formData = {
        weld_map_issued:
            document.querySelector('[name="weld_map_issued"]').checked || null,
        link_to_weld_map:
            document.querySelector('[name="link_to_weld_map"]').files.length > 0
                ? document.querySelector('[name="link_to_weld_map"]').files[0].name
                : document.getElementById("old_weld_map_filename").textContent.trim(),

        weld_procedure_qualification:
            document.querySelector('[name="weld_procedure_qualification"]').checked || null,
        link_to_pqr:
            document.querySelector('[name="link_to_pqr"]').files.length > 0
                ? document.querySelector('[name="link_to_pqr"]').files[0].name
                : document.getElementById("old_pqr_filename").textContent.trim(),

        weld_procedure_specifications:
            document.querySelector('[name="weld_procedure_specifications"]').checked || null,
            link_to_wps:
            document.querySelector('[name="link_to_wps"]').files.length > 0
                ? document.querySelector('[name="link_to_wps"]').files[0].name
                : document.getElementById("old_wps_filename").textContent.trim(),

        welder_performance_qualification:
            document.querySelector('[name="welder_performance_qualification"]').checked || null,
            link_to_wpq:
            document.querySelector('[name="link_to_wpq"]').files.length > 0
                ? document.querySelector('[name="link_to_wpq"]').files[0].name
                : document.getElementById("old_wpq_filename").textContent.trim(),

       
        welding_wire:
            document.querySelector('[name="welding_wire"]').checked || null,
        link_to_wire_certificate:
            document.querySelector('[name="link_to_wire_certificate"]').files.length > 0
                ? document.querySelector('[name="link_to_wire_certificate"]').files[0].name
                : document.getElementById("old_wire_certificate_filename").textContent.trim(),

        link_to_plant_cert:
            document.querySelector('[name="link_to_plant_cert"]').files.length >0
                ? document.querySelector('[name="link_to_plant_cert"]').files[0].name
                : document.getElementById("old_plant_cert_filename").textContent.trim(),
        shielding_gas:
            document.querySelector('[name="shielding_gas"]').checked || null,
        link_to_gas_data_sheet:
            document.querySelector('[name="link_to_gas_data_sheet"]').files.length > 0
                ? document.querySelector('[name="link_to_gas_data_sheet"]').files[0].name
                : document.getElementById("old_gas_data_sheet_filename").textContent.trim(),

        pre_weld_inspection:
            document.querySelector('[name="pre_weld_inspection"]').checked ||
            null,
        inspection_during_welding:
            document.querySelector('[name="inspection_during_welding"]')
                .checked || null,
        post_weld_inspection:
            document.querySelector('[name="post_weld_inspection"]').checked ||
            null,
        sign_off_welding:
            document.querySelector('[name="sign_off_welding"]').value.trim() ||
            null,
        comments_welding:
            document.querySelector('[name="comments_welding"]').value.trim() ||
            null,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number:  document.querySelector('[name="process_order_number_welding"]').value || null,

        owners_weld:owners_weld,
    };

    $.ajax({
        url: "/submitWeldingForm",
        type: "POST",
        data: formData,
        headers: headers,
        success: function (response) {
            console.log(response);
            alert("Form submitted successfully!");
            $(myModal).hide();
        },
        error: function (error) {
            console.error(error);
            alert("Error submitting form. Please try again.");
        },
    });

    // File uploads
    var fileData = new FormData();
    var fileInputs = $('[type="file"]');

    // Add process_order_number to FormData
    fileData.append("process_order_number", document.querySelector('[name="process_order_number_welding"]').value);

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
        url: "/handleFileUploadWelding",
        type: "POST",
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

    console.log("Welding form submitted!");
}
// Function to generate the welding tasks field table
function generateWeldingFieldTable(processOrder, qualityStep) {
    console.log(processOrder);
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: processOrder,
    };

    $.ajax({
        url: "/getWeldingDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML = generateHTMLFromResponse_for_welding(response);
            $("#weldingFieldTable").html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        },
    });

    return `
        <div>To be Done</div>
    `;
}

// Function to generate HTML table from welding tasks response
function generateHTMLFromResponse_for_welding_old(response) {
    var html =
        '<table id="common_table" style="width:100%; border: 1px solid #ddd">';
    html += "<thead><tr>";
    html += "<th>ID</th>";
    html += "<th>Weld_Map_Issued</th>";
    html += "<th>Link_to_Weld_Map</th>";
    html += "<th>Weld_Procedure_Qualification</th>";
    html += "<th>Link_to_PQR</th>";
    html += "<th>Weld_Procedure_Specifications</th>";
    html += "<th>Link_to_WPS</th>";
    html += "<th>Welder_Performance_Qualification</th>";
    html += "<th>Link_to_WPQ</th>";
    html += "<th>Welding_Wire</th>";
    html += "<th>Link_to_Wire_Certificate</th>";
    html += "<th>Shielding_Gas</th>";
    html += "<th>Link_to_Gas_Data_Sheet</th>";
    html += "<th>Pre_Weld_Inspection</th>";
    html += "<th>Inspection_During_Welding</th>";
    html += "<th>Post_Weld_Inspection</th>";
    html += "<th>Sign_Off_Welding_Complete</th>";
    html += "<th>Comments_Welding_Complete</th>";
    html += "<th>Status</th>";
    html += "<th>Submission_Date</th>";
    html += "<th>Created_At</th>";
    html += "<th>Updated_At</th>";
    html += "<th>Link_to_Plant_Cert</th>";
    html += "<th>Process_Order_ID</th>";
    html += "<th>Action</th>";
    html += "</tr></thead><tbody>";

    $.each(response, function (index, item) {
        html += "<tr>";
        html += "<td>" + item.Id + "</td>";
        html += "<td>" + item.weld_map_issued + "</td>";
        html += "<td>";
        if (item.link_to_weld_map) {
            var filePath =
                "http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/welding_task/" +
                item.ProcessOrderID +
                "/" +
                item.link_to_weld_map;
                var downloadLink = '<a href="' + filePath + '" target="_blank">Download</a>';
            html += downloadLink;
        } else {
            html += "-";
        }
        html += "</td>";
        html += "<td>" + item.weld_procedure_qualification + "</td>";
        html += "<td>";
        if (item.link_to_pqr) {
            var filePath =
                "http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/welding_task/" +
                item.ProcessOrderID +
                "/" +
                item.link_to_pqr;
                var downloadLink = '<a href="' + filePath + '" target="_blank">Download</a>';
            html += downloadLink;
        } else {
            html += "-";
        }
        html += "</td>";
        html += "<td>" + item.weld_procedure_specifications + "</td>";
        html += "<td>";
        if (item.link_to_wps) {
            var filePath =
                "http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/welding_task/" +
                item.ProcessOrderID +
                "/" +
                item.link_to_wps;
                var downloadLink = '<a href="' + filePath + '" target="_blank">Download</a>';
            html += downloadLink;
        } else {
            html += "-";
        }
        html += "</td>";
        html += "<td>" + item.welder_performance_qualification + "</td>";
        html += "<td>";
        if (item.link_to_wpq) {
            var filePath =
                "http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/welding_task/" +
                item.ProcessOrderID +
                "/" +
                item.link_to_wpq;
                var downloadLink = '<a href="' + filePath + '" target="_blank">Download</a>';
            html += downloadLink;
        } else {
            html += "-";
        }
        html += "</td>";
        html += "<td>" + item.welding_wire + "</td>";
        html += "<td>";
        if (item.link_to_wire_certificate) {
            var filePath =
                "http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/welding_task/" +
                item.ProcessOrderID +
                "/" +
                item.link_to_wire_certificate;
                var downloadLink = '<a href="' + filePath + '" target="_blank">Download</a>';
            html += downloadLink;
        } else {
            html += "-";
        }
        html += "</td>";
        html += "<td>" + item.shielding_gas + "</td>";
        html += "<td>";
        if (item.link_to_gas_data_sheet) {
            var filePath =
                "http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/welding_task/" +
                item.ProcessOrderID +
                "/" +
                item.link_to_gas_data_sheet;
                var downloadLink = '<a href="' + filePath + '" target="_blank">Download</a>';
            html += downloadLink;
        } else {
            html += "-";
        }
        html += "</td>";
        html += "<td>" + item.pre_weld_inspection + "</td>";
        html += "<td>" + item.inspection_during_welding + "</td>";
        html += "<td>" + item.post_weld_inspection + "</td>";
        html += "<td>" + item.sign_off_welding_complete + "</td>";
        html += "<td>" + item.comments_welding_complete + "</td>";
        html += "<td>" + item.status + "</td>";
        html += "<td>" + item.submission_date + "</td>";
        html += "<td>" + item.created_at + "</td>";
        html += "<td>" + item.updated_at + "</td>";
        html += "<td>";
        if (item.link_to_plant_cert) {
            var filePath =
                "http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/welding_task/" +
                item.ProcessOrderID +
                "/" +
                item.link_to_plant_cert;
                var downloadLink = '<a href="' + filePath + '" target="_blank">Download</a>';
            html += downloadLink;
        } else {
            html += "-";
        }
        html += "</td>";

        html += "</tr>";
    });

    html += "</tbody></table>";

    return html;
}
function generateHTMLFromResponse_for_welding_oldd(response) {
    var html =
        '<form id="weldingForm" class="welding-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Welding</legend>';
    html+='<div style="width:97%">';
    $.each(response, function (index, item) {
        html += '<div class="welding-item">';
       // html += '<label for="id">ID:</label>';
       // html += '<input type="text" id="id" name="id" value="' + item.Id + '" readonly>';
        html += '<br>';

        html += '<div class="welding-field">';
        html += '<label for="weld_map_issued">Weld Map Issued:</label>';
        html += '<input type="checkbox" id="weld_map_issued" name="weld_map_issued"' + (item.weld_map_issued ? 'checked' : 'disabled') + '>';
        html += '</div><br>';

        html += '<div class="welding-field">';
        html += '<label for="link_to_weld_map">Link to Weld Map:</label>';
        if (item.link_to_weld_map) {
            var filePath =
                'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/welding_task/' +
                item.ProcessOrderID +
                '/' +
                item.link_to_weld_map;
                var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.link_to_weld_map+'</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</div><br>';

        html += '<div class="welding-field">';
        html +=
            '<label for="weld_procedure_qualification">Weld Procedure Qualification:</label>';
            html += '<input type="checkbox" id="weld_procedure_qualification" name="weld_procedure_qualification"' + (item.weld_procedure_qualification ? ' checked' : ' disabled') + '>';
        html += '</div><br>';

        html += '<div class="welding-field">';
        html += '<label for="link_to_pqr">Link to PQR:</label>';
        if (item.link_to_pqr) {
            var filePath =
                'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/welding_task/' +
                item.ProcessOrderID +
                '/' +
                item.link_to_pqr;
                var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.link_to_pqr+'</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</div><br>';

        html += '<div class="welding-field">';
        html +=
            '<label for="weld_procedure_specifications">Weld Procedure Specifications:</label>';
        html +=
            '<input type="checkbox" id="weld_procedure_specifications" name="weld_procedure_specifications"' + (item.weld_procedure_specifications? ' checked' : ' disabled') + '>';
        html += '</div><br>';

        html += '<div class="welding-field">';
        html += '<label for="link_to_wps">Link to WPS:</label>';
        if (item.link_to_wps) {
            var filePath =
                'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/welding_task/' +
                item.ProcessOrderID +
                '/' +
                item.link_to_wps;
                var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.link_to_wps+'</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</div><br>';

        html += '<div class="welding-field">';
        html +=
            '<label for="welder_performance_qualification">Welder Performance Qualification:</label>';
        html +=
            '<input type="checkbox" id="welder_performance_qualification" name="welder_performance_qualification"' + (item.welder_performance_qualification ?' checked' : ' disabled') + '>';
        html += '</div><br>';

        html += '<div class="welding-field">';
        html += '<label for="link_to_wpq">Link to WPQ:</label>';
        if (item.link_to_wpq) {
            var filePath =
                'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/welding_task/' +
                item.ProcessOrderID +
                '/' +
                item.link_to_wpq;
                var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.link_to_wpq+'</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</div><br>';

        html += '<div class="welding-field">';
        html += '<label for="welding_wire">Welding Wire:</label>';
        html +=
            '<input type="checkbox" id="welding_wire" name="welding_wire"' +(item.welding_wire ? 'checked' : 'disabled') +'>';
        html += '</div><br>';

        html += '<div class="welding-field">';
        html += '<label for="link_to_wire_certificate">Link to Wire Certificate:</label>';
        if (item.link_to_wire_certificate) {
            var filePath =
                'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/welding_task/' +
                item.ProcessOrderID +
                '/' +
                item.link_to_wire_certificate;
                var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.link_to_wire_certificate+'</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</div><br>';

        html += '<div class="welding-field">';
        html += '<label for="shielding_gas">Shielding Gas:</label>';
        html +=
            '<input type="checkbox" id="shielding_gas" name="shielding_gas"' +(item.shielding_gas ? 'checked' : 'disabled') +'>';
        html += '</div><br>';

        html += '<div class="welding-field">';
        html += '<label for="link_to_gas_data_sheet">Link to Gas Data Sheet:</label>';
        if (item.link_to_gas_data_sheet) {
            var filePath =
                'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/welding_task/' +
                item.ProcessOrderID +
                '/' +
                item.link_to_gas_data_sheet;
                var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.link_to_gas_data_sheet+'</a>';
            html += downloadLink;
        } else {
            html += '-';
        }
        html += '</div><br>';

        html += '<div class="welding-field">';
        html += '<label for="pre_weld_inspection">Pre Weld Inspection:</label>';
        html +=
            '<input type="checkbox" id="pre_weld_inspection" name="pre_weld_inspection"' +
            (item.pre_weld_inspection ? 'checked' : 'disabled') +
            '>';
        html += '</div><br>';

        html += '<div class="welding-field">';
        html += '<label for="inspection_during_welding">Inspection During Welding:</label>';
        html +=
            '<input type="checkbox" id="inspection_during_welding" name="inspection_during_welding"' +
            (item.inspection_during_welding
                ? 'checked' : 'disabled') +
            '>';
        html += '</div><br>';

        html += '<div class="welding-field">';
        html += '<label for="post_weld_inspection">Post Weld Inspection:</label>';
        html +=
            '<input type="checkbox" id="post_weld_inspection" name="post_weld_inspection"' +
            (item.post_weld_inspection ? 'checked' : 'disabled') +
            '>';
            html += '</div><br>';

            html += '<div class="welding-field">';
            html += '<label for="link_to_plant_cert">Link to Plant Cert:</label>';
            if (item.link_to_plant_cert) {
                var filePath =
                    'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/welding_task/' +
                    item.ProcessOrderID +
                    '/' +
                    item.link_to_plant_cert;
                    var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.link_to_plant_cert+'</a>';
                html += downloadLink;
            } else {
                html += '-';
            }
            html += '</div><br>';
        html += '</div><br>';

    //   html += '<div class="welding-field">';
      //  html += '<label for="sign_off_welding_complete">Sign Off Welding Complete:</label>';
       // html +=
         //   '<input type="text" id="sign_off_welding_complete" name="sign_off_welding_complete" value="'+item.sign_off_welding_complete + '">'
          
       // html += '</div><br>';

       html += '<div class="welding-field">';
        html += '<label for="comments_welding_complete">Comments Welding Complete:</label>';
        html +=
            '<input style="width:100%"type="text" id="comments_welding_complete" name="comments_welding_complete" value="'+item.comments_welding_complete + '">'
           
        html += '</div><br>';

        //html += '<div class="welding-field">';
        //html += '<label for="status">Status:</label>';
        //html +=
        //    '<input type="text" id="status" name="status" value="' +
        //    (item.status ? 'checked' : 'disabled') +
        //    '">';
       // html += '</div><br>';



        
        //html += '<div class="welding-field">';
       // html += '<label for="submission_date">Submission Date:</label>';
       // html +=
       //     '<input type="text" id="submission_date" name="submission_date" value="' +
         //   (item.submission_date ? item.submission_date : '') +
       ///     '">';
       // html += '</div><br>';

       // html += '<div class="welding-field">';
       // html += '<label for="created_at">Created At:</label>';
       // html +=
         //   '<input type="text" id="created_at" name="created_at" value="' +
           // (item.created_at ? item.created_at : '') +
           // '">';
        //html += '</div><br>';

      //  html += '<div class="welding-field">';
      //  html += '<label for="updated_at">Updated At:</label>';
      //  html +=
        //    '<input type="text" id="updated_at" name="updated_at" value="' +
        //    (item.updated_at ? item.updated_at : '') +
        //    '">';
       // html += '</div><br>';

       

        html += '<div class="welding-field">';
    html += '<label for="process_order_id">Process Order ID:</label>';
        html +=
           '<input style="width:100%"type="text" id="process_order_id" name="process_order_id" value="' +
           (item.ProcessOrderID ? item.ProcessOrderID : '') +
            '">';
        html += '</div><br>';

       // html += '<div class="welding-field">';
        //html += '<label for="action">Action:</label>';
        //html +=
          //  '<input type="text" id="action" name="action" value="' +
            //(item.Action ? item.Action : '') +
          //  '">';
    //    html += '</div><br>';

        html += '</div>'; // Closing div for welding-item
        html += '<hr>'; // Horizontal line for separation
    });
    html+='</div>';
   // html += '<input type="button" value="Submit" onclick="submitWeldingForm()">';
    html += '</fieldset></form>';

    return html;
}
function generateHTMLFromResponse_for_welding_test(response) {
    var html = '<form id="weldingForm" class="welding-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Welding Tasks</legend>';

    // Start table
    html += '<table style="width: 100%; border-collapse: collapse;">';

    // Table headers
    html += '<tr style="border: 1px solid #ccc;">';
    html += '<th style="border: 1px solid #ccc;">Tasks</th>';
    html += '<th style="border: 1px solid #ccc;">Files</th>';
    html += '<th style="border: 1px solid #ccc;">Owner</th>';
    html += '<th style="border: 1px solid #ccc;">NDT</th>';
    html += '</tr>';

    $.each(response, function(index, item) {
        // Weld Map Issued
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<div class="form-group">';
        html += '<input type="checkbox" id="weld_map_issued_' + index + '" name="weld_map_issued" ' + ((item.weld_map_issued === 'true' || item.weld_map_issued === 'on') ? 'checked' : 'disabled') + '>';
        html += '<label for="weld_map_issued_' + index + '">Weld Map Issued</label>';
        html += '</div>';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;">' + (item.link_to_weld_map ? '<a href="' + item.link_to_weld_map + '" target="_blank">Link</a>' : '') + '</td>';
        html += '<td id="owner_weld_1" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_weld_1" style="border: 1px solid #ccc;"></td>';
        fetchOwnerData_Welding(item.ProcessOrderID, 'Weld Map: Weld Map issued to production', function(ownerData) {
            document.getElementById('owner_weld_1').innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_weld_1').innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        });
        html += '</tr>';

        // Weld Procedure Qualification
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<div class="form-group">';
        html += '<input type="checkbox" id="weld_procedure_qualification_' + index + '" name="weld_procedure_qualification" ' + ((item.weld_procedure_qualification === 'true' || item.weld_procedure_qualification === 'on') ? 'checked' : 'disabled') + '>';
        html += '<label for="weld_procedure_qualification_' + index + '">Weld Procedure Qualification</label>';
        html += '</div>';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;">' + (item.link_to_pqr ? '<a href="' + item.link_to_pqr + '" target="_blank">Link</a>' : '') + '</td>';
        html += '<td id="owner_weld_pqr_' + index + '" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_weld_pqr_' + index + '" style="border: 1px solid #ccc;"></td>';
        fetchOwnerData_Welding(item.ProcessOrderID, 'Weld Procedure Qualification Record:', function(ownerData) {
            document.getElementById('owner_weld_pqr_' + index).innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_weld_pqr_' + index).innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        });
        html += '</tr>';

        // Weld Procedure Specifications
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<div class="form-group">';
        html += '<input type="checkbox" id="weld_procedure_specifications_' + index + '" name="weld_procedure_specifications" ' + ((item.weld_procedure_specifications === 'true' || item.weld_procedure_specifications === 'on') ? 'checked' : 'disabled') + '>';
        html += '<label for="weld_procedure_specifications_' + index + '">Weld Procedure Specifications</label>';
        html += '</div>';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;">' + (item.link_to_wps ? '<a href="' + item.link_to_wps + '" target="_blank">Link</a>' : '') + '</td>';
        html += '<td id="owner_weld_wps_' + index + '" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_weld_wps_' + index + '" style="border: 1px solid #ccc;"></td>';
        fetchOwnerData_Welding(item.ProcessOrderID, 'Weld Procedure Specifications:', function(ownerData) {
            document.getElementById('owner_weld_wps_' + index).innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_weld_wps_' + index).innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        });
        html += '</tr>';

        // Welder Performance Qualification
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<div class="form-group">';
        html += '<input type="checkbox" id="welder_performance_qualification_' + index + '" name="welder_performance_qualification" ' + ((item.welder_performance_qualification === 'true' || item.welder_performance_qualification === 'on') ? 'checked' : 'disabled') + '>';
        html += '<label for="welder_performance_qualification_' + index + '">Welder Performance Qualification</label>';
        html += '</div>';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;">' + (item.link_to_wpq ? '<a href="' + item.link_to_wpq + '" target="_blank">Link</a>' : '') + '</td>';
        html += '<td id="owner_welder_wpq_' + index + '" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_welder_wpq_' + index + '" style="border: 1px solid #ccc;"></td>';
        fetchOwnerData_Welding(item.ProcessOrderID, 'Welder Performance Qualification:', function(ownerData) {
            document.getElementById('owner_welder_wpq_' + index).innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_welder_wpq_' + index).innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        });
        html += '</tr>';

        // Welding Wire
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<div class="form-group">';
        html += '<input type="checkbox" id="welding_wire_' + index + '" name="welding_wire" ' + ((item.welding_wire === 'true' || item.welding_wire === 'on') ? 'checked' : 'disabled') + '>';
        html += '<label for="welding_wire_' + index + '">Welding Wire</label>';
        html += '</div>';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;">' + (item.link_to_wire_certificate ? '<a href="' + item.link_to_wire_certificate + '" target="_blank">Link</a>' : '') + '</td>';
        html += '<td id="owner_welding_wire_' + index + '" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_welding_wire_' + index + '" style="border: 1px solid #ccc;"></td>';
        fetchOwnerData_Welding(item.ProcessOrderID, 'Welding Consumable - Welding Wire:', function(ownerData) {
            document.getElementById('owner_welding_wire_' + index).innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_welding_wire_' + index).innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        });
        html += '</tr>';

        // Shielding Gas
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<div class="form-group">';
        html += '<input type="checkbox" id="shielding_gas_' + index + '" name="shielding_gas" ' + ((item.shielding_gas === 'true' || item.shielding_gas === 'on') ? 'checked' : 'disabled') + '>';
        html += '<label for="shielding_gas_' + index + '">Shielding Gas</label>';
        html += '</div>';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;">' + (item.link_to_gas_data_sheet ? '<a href="' + item.link_to_gas_data_sheet + '" target="_blank">Link</a>' : '') + '</td>';
        html += '<td id="owner_shielding_gas_' + index + '" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_shielding_gas_' + index + '" style="border: 1px solid #ccc;"></td>';
        fetchOwnerData_Welding(item.ProcessOrderID, 'Welding Consumable - Shielding Gas:', function(ownerData) {
            document.getElementById('owner_shielding_gas_' + index).innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_shielding_gas_' + index).innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        });
        html += '</tr>';

        // Pre Weld Inspection
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<div class="form-group">';
        html += '<input type="checkbox" id="pre_weld_inspection_' + index + '" name="pre_weld_inspection" ' + ((item.pre_weld_inspection === 'true' || item.pre_weld_inspection === 'on') ? 'checked' : 'disabled') + '>';
        html += '<label for="pre_weld_inspection_' + index + '">Pre Weld Inspection</label>';
        html += '</div>';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;"></td>';
        html += '<td id="owner_pre_weld_' + index + '" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_pre_weld_' + index + '" style="border: 1px solid #ccc;"></td>';
        fetchOwnerData_Welding(item.ProcessOrderID, 'Pre-Weld inspection: Check weld joint preparation against WPS', function(ownerData) {
            document.getElementById('owner_pre_weld_' + index).innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_pre_weld_' + index).innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        });
        html += '</tr>';

        // Inspection During Welding
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<div class="form-group">';
        html += '<input type="checkbox" id="inspection_during_welding_' + index + '" name="inspection_during_welding" ' + ((item.inspection_during_welding === 'true' || item.inspection_during_welding === 'on') ? 'checked' : 'disabled') + '>';
        html += '<label for="inspection_during_welding_' + index + '">Inspection During Welding</label>';
        html += '</div>';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;"></td>';
        html += '<td id="owner_inspection_during_' + index + '" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_inspection_during_' + index + '" style="border: 1px solid #ccc;"></td>';
        fetchOwnerData_Welding(item.ProcessOrderID, 'Inspection During Welding: Check requirements of the WPS', function(ownerData) {
            document.getElementById('owner_inspection_during_' + index).innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_inspection_during_' + index).innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        });
        html += '</tr>';

        // Post Weld Inspection
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<div class="form-group">';
        html += '<input type="checkbox" id="post_weld_inspection_' + index + '" name="post_weld_inspection" ' + ((item.post_weld_inspection === 'true' || item.post_weld_inspection === 'on') ? 'checked' : 'disabled') + '>';
        html += '<label for="post_weld_inspection_' + index + '">Post Weld Inspection</label>';
        html += '</div>';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;"></td>';
        html += '<td id="owner_post_weld_' + index + '" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_post_weld_' + index + '" style="border: 1px solid #ccc;"></td>';
        fetchOwnerData_Welding(item.ProcessOrderID, 'Post-Weld Inspection: Visual weld inspection - All Welds', function(ownerData) {
            document.getElementById('owner_post_weld_' + index).innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_post_weld_' + index).innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        });
        html += '</tr>';
    });

    // Close table
    html += '</table>';
    html += '</fieldset></form>';

    return html;
}
function generateHTMLFromResponse_for_welding(response) {
    var html = '<form id="weldingForm" class="welding-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Welding Tasks</legend>';

    
    $.each(response, function(index, item) {
        // Weld Map Issued

        // Start table
    html += '<table style="width: 100%; border-collapse: collapse;">';

    // Table headers
    html += '<tr style="border: 1px solid #ccc;">';

    html += '<tr style="border: 1px solid #ccc;">';
    html+='<td>'+item.ProcessOrderID +'</td>';
    html += '</tr>';
    html += '<th style="border: 1px solid #ccc;">Tasks</th>';
    html += '<th style="border: 1px solid #ccc;">Files</th>';
    html += '<th style="border: 1px solid #ccc;">Owner</th>';
    html += '<th style="border: 1px solid #ccc;">Action</th>';
    html += '</tr>';

       
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<div class="form-group">';
        html += '<input type="checkbox" id="weld_map_issued_' + index + '" name="weld_map_issued" ' + ((item.weld_map_issued === 'true' || item.weld_map_issued === 'on') ? 'checked' : 'disabled') + '>';
        html += '<label for="weld_map_issued_' + index + '">Weld Map Issued</label>';
        html += '</div>';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;">' + (item.link_to_weld_map ? '<a href="' + item.link_to_weld_map + '" target="_blank">' + item.link_to_weld_map.split('/').pop() + '</a>' : '') + '</td>';
        html += '<td id="owner_weld_1" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_weld_1" style="border: 1px solid #ccc;"></td>';
        fetchOwnerData_Welding(item.ProcessOrderID, 'Weld Map: Weld Map issued to production', function(ownerData) {
            document.getElementById('owner_weld_1').innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_weld_1').innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        });
        html += '</tr>';

        // Weld Procedure Qualification
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<div class="form-group">';
        html += '<input type="checkbox" id="weld_procedure_qualification_' + index + '" name="weld_procedure_qualification" ' + ((item.weld_procedure_qualification === 'true' || item.weld_procedure_qualification === 'on') ? 'checked' : 'disabled') + '>';
        html += '<label for="weld_procedure_qualification_' + index + '">Weld Procedure Qualification</label>';
        html += '</div>';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;">' + (item.link_to_pqr ? '<a href="' + item.link_to_pqr + '" target="_blank">' + item.link_to_pqr.split('/').pop() + '</a>' : '') + '</td>';
        html += '<td id="owner_weld_2" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_weld_2" style="border: 1px solid #ccc;"></td>';
        fetchOwnerData_Welding(item.ProcessOrderID, 'Weld Procedure Qualification Record:', function(ownerData) {
            document.getElementById('owner_weld_2').innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_weld_2').innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        });
        html += '</tr>';

        // Weld Procedure Specifications
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<div class="form-group">';
        html += '<input type="checkbox" id="weld_procedure_specifications_' + index + '" name="weld_procedure_specifications" ' + ((item.weld_procedure_specifications === 'true' || item.weld_procedure_specifications === 'on') ? 'checked' : 'disabled') + '>';
        html += '<label for="weld_procedure_specifications_' + index + '">Weld Procedure Specifications</label>';
        html += '</div>';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;">' + (item.link_to_wps ? '<a href="' + item.link_to_wps + '" target="_blank">' + item.link_to_wps.split('/').pop() + '</a>' : '') + '</td>';
        html += '<td id="owner_weld_3" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_weld_3" style="border: 1px solid #ccc;"></td>';
        fetchOwnerData_Welding(item.ProcessOrderID, 'Weld Procedure Specifications:', function(ownerData) {
            document.getElementById('owner_weld_3').innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_weld_3').innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        });
        html += '</tr>';

        // Welder Performance Qualification
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<div class="form-group">';
        html += '<input type="checkbox" id="welder_performance_qualification_' + index + '" name="welder_performance_qualification" ' + ((item.welder_performance_qualification === 'true' || item.welder_performance_qualification === 'on') ? 'checked' : 'disabled') + '>';
        html += '<label for="welder_performance_qualification_' + index + '">Welder Performance Qualification</label>';
        html += '</div>';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;">' + (item.link_to_wpq ? '<a href="' + item.link_to_wpq + '" target="_blank">' + item.link_to_wpq.split('/').pop() + '</a>' : '') + '</td>';
        html += '<td id="owner_welder_4" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_welder_4" style="border: 1px solid #ccc;"></td>';
        fetchOwnerData_Welding(item.ProcessOrderID, 'Welder Performance Qualification:', function(ownerData) {
            document.getElementById('owner_welder_4').innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_welder_4').innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        });
        html += '</tr>';

        // Welding Wire
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<div class="form-group">';
        html += '<input type="checkbox" id="welding_wire_' + index + '" name="welding_wire" ' + ((item.welding_wire === 'true' || item.welding_wire === 'on') ? 'checked' : 'disabled') + '>';
        html += '<label for="welding_wire_' + index + '">Welding Wire</label>';
        html += '</div>';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;">' + (item.link_to_wire_certificate ? '<a href="' + item.link_to_wire_certificate + '" target="_blank">' + item.link_to_wire_certificate.split('/').pop() + '</a>' : '') + '</td>';
        html += '<td id="owner_weld_5" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_weld_5" style="border: 1px solid #ccc;"></td>';
        fetchOwnerData_Welding(item.ProcessOrderID, 'Welding Consumable - Welding Wire:', function(ownerData) {
            document.getElementById('owner_weld_5').innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_weld_5').innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        });
        html += '</tr>';

        // Shielding Gas
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<div class="form-group">';
        html += '<input type="checkbox" id="shielding_gas_' + index + '" name="shielding_gas" ' + ((item.shielding_gas === 'true' || item.shielding_gas === 'on') ? 'checked' : 'disabled') + '>';
        html += '<label for="shielding_gas_' + index + '">Shielding Gas</label>';
        html += '</div>';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;">' + (item.link_to_gas_data_sheet ? '<a href="' + item.link_to_gas_data_sheet + '" target="_blank">' + item.link_to_gas_data_sheet.split('/').pop() + '</a>' : '') + '</td>';
        html += '<td id="owner_weld_6" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_weld_6" style="border: 1px solid #ccc;"></td>';
        fetchOwnerData_Welding(item.ProcessOrderID, 'Welding Consumable - Shielding Gas:', function(ownerData) {
            document.getElementById('owner_weld_6').innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_weld_6').innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        });
        html += '</tr>';

        // Pre Weld Inspection
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<div class="form-group">';
        html += '<input type="checkbox" id="pre_weld_inspection_' + index + '" name="pre_weld_inspection" ' + ((item.pre_weld_inspection === 'true' || item.pre_weld_inspection === 'on') ? 'checked' : 'disabled') + '>';
        html += '<label for="pre_weld_inspection_' + index + '">Pre Weld Inspection</label>';
        html += '</div>';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;"></td>';
        html += '<td id="owner_weld_7" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_weld_7" style="border: 1px solid #ccc;"></td>';
        fetchOwnerData_Welding(item.ProcessOrderID, 'Pre-Weld inspection: Check weld joint preparation against WPS', function(ownerData) {
            document.getElementById('owner_weld_7').innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_weld_7').innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        });
        html += '</tr>';

        // Inspection During Welding
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<div class="form-group">';
        html += '<input type="checkbox" id="inspection_during_welding_' + index + '" name="inspection_during_welding" ' + ((item.inspection_during_welding === 'true' || item.inspection_during_welding === 'on') ? 'checked' : 'disabled') + '>';
        html += '<label for="inspection_during_welding_' + index + '">Inspection During Welding</label>';
        html += '</div>';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;"></td>';
        html += '<td id="owner_weld_8" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_weld_8" style="border: 1px solid #ccc;"></td>';
        fetchOwnerData_Welding(item.ProcessOrderID, 'Inspection During Welding: Check requirements of the WPS', function(ownerData) {
            document.getElementById('owner_weld_8').innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_weld_8').innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        });
        html += '</tr>';

        // Post Weld Inspection
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
        html += '<div class="form-group">';
        html += '<input type="checkbox" id="post_weld_inspection_' + index + '" name="post_weld_inspection" ' + ((item.post_weld_inspection === 'true' || item.post_weld_inspection === 'on') ? 'checked' : 'disabled') + '>';
        html += '<label for="post_weld_inspection_' + index + '">Post Weld Inspection</label>';
        html += '</div>';
        html += '</td>';
        html += '<td style="border: 1px solid #ccc;"></td>';
        html += '<td id="owner_weld_9" style="border: 1px solid #ccc;"></td>';
        html += '<td id="ndt_weld_9" style="border: 1px solid #ccc;"></td>';
        fetchOwnerData_Welding(item.ProcessOrderID, 'Post-Weld Inspection: Visual weld inspection - All Welds', function(ownerData) {
            document.getElementById('owner_weld_9').innerHTML = ownerData ? ownerData.owner.trim() : 'N/A';
            document.getElementById('ndt_weld_9').innerHTML = ownerData ? ownerData.ndta.trim() : 'N/A';
        });
        html += '</tr>';




        // Sign-off
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Sign-off</td>';
        html += '<td colspan="3" style="border: 1px solid #ccc;">';
        html += '<input style="width: 100%;" type="text" name="sign_off_welding" value="' + (item.sign_off_welding || '') + '">';
        html += '</td>';
        html += '</tr>';

        // Comments
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">Comments</td>';
        html += '<td colspan="3" style="border: 1px solid #ccc; padding: 10px;">';
        html += '<textarea style="width: 100%;" name="comments_welding">' + (item.comments_welding || '') + '</textarea>';
        html += '</td>';
        html += '</tr>';
    });

    // Close table
    html += '</table>';
    html += '</fieldset></form>';

    return html;
}


function fetchOwnerData_Welding(id,Type,callback)
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
    url: '/getOwnerData_weld',
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


// Function to generate the welding tasks completion form
function generateWeldingCompleteFieldset(processOrder, qualityStep, username) {
    var formData = {
        process_order_number: processOrder,
    };
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    $("#sign_off_welding_complete").val(username);

    $.ajax({
        url: "/getWeldingDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            if (response.data !== null) {
                var generatedHTML =
                    generateCompleteHTMLFromResponse_for_welding(response);
                $("#weldingCompleteFieldTable").html(generatedHTML);
            } else {
                $("#weldingCompleteFieldTable").html("");
            }
        },
        error: function (error) {
            console.error(error);
        },
    });
}

// Function to generate HTML for the welding tasks completion form
function generateCompleteHTMLFromResponse_for_welding(response) {
    var html = "<fieldset><legend>Welding Tasks Complete</legend>";
    html += '<form id="welding_complete_form">';
    html+='<div style="width:97%">';
    $.each(response, function (index, item) {
        html += '<div class="welding_item">';
       // html += "<label>ID: " + item.id + "</label><br>";

        html +=
            '<input type="hidden" name="processorder" value="' +
            item.ProcessOrderID +
            '"><br>';
        // Weld Map
        html += '<div class="welding_field">';
        html +=
            "<label>Weld Map:</label>" +
            (item.weld_map_issued === "true" || item.weld_map_issued === "on"
                ? '<input type="checkbox" id="weld_map_issued_c" name="weld_map_issued_c" >'
                : '<input type="checkbox" id="weld_map_issued_c" name="weld_map_issued_c" disabled>') +
            "</div><br>";

        // Link to Weld Map
        html += '<div class="welding_field">';
        html +=
            "<label>Link to Weld Map:</label>" +
            '<input style="width:100%"type="text" name="link_to_weld_map_c" value="' +
            item.link_to_weld_map +
            '"disabled>' +
            "</div><br> ";

        // Weld Procedure Qualification Record
        html += '<div class="welding_field">';
        html +=
            "<label>Weld Procedure Qualification Record:</label>" +
            (item.weld_procedure_qualification === "true" ||
            item.weld_procedure_qualification === "on"
                ? '<input type="checkbox" id="weld_procedure_qualification_c" name="weld_procedure_qualification_c" >'
                : '<input type="checkbox" id="weld_procedure_qualification_c" name="weld_procedure_qualification_c" disabled>') +
            "</div><br>";

        // Link to PQR
        html += '<div class="welding_field">';
        html +=
            "<label>Link to PQR:</label>" +
            '<input style="width:100%"type="text" name="link_to_pqr_c" value="' +
            item.link_to_pqr +
            '"disabled>' +
            "</div><br>";

        // Weld Procedure Specifications
        html += '<div class="welding_field">';
        html +=
            "<label>Weld Procedure Specifications:</label>" +
            (item.weld_procedure_specifications === "true" ||
            item.weld_procedure_specifications === "on"
                ? '<input type="checkbox" id="weld_procedure_specifications_c" name="weld_procedure_specifications_c" >'
                : '<input type="checkbox" id="weld_procedure_specifications_c" name="weld_procedure_specifications_c" disabled>') +
            "</div><br>";

        // Link to Approved WPS
        html += '<div class="welding_field">';
        html +=
            "<label>Link to Approved WPS:</label>" +
            '<input style="width:100%"type="text" name="link_to_wps_c" value="' +
            item.link_to_wps +
            '"disabled>' +
            "</div><br>";

        // Welder Performance Qualification
        html += '<div class="welding_field">';
        html +=
            "<label>Welder Performance Qualification:</label>" +
            (item.welder_performance_qualification === "true" ||
            item.welder_performance_qualification === "on"
                ? '<input type="checkbox" id="welder_performance_qualification" name="welder_performance_qualification_c" >'
                : '<input type="checkbox" id="welder_performance_qualification" name="welder_performance_qualification_c" disabled>') +
            "</div><br>";

        // Link to WPQ Certificate
        html += '<div class="welding_field">';
        html +=
            "<label>Link to WPQ Certificate:</label>" +
            '<input style="width:100%"type="text" name="link_to_wpq_c" value="' +
            item.link_to_wpq +
            '"disabled>' +
            "</div><br>";

        // Welding Consumable - Welding Wire
        html += '<div class="welding_field">';
        html +=
            "<label>Welding Consumable - Welding Wire:</label>" +
            (item.welding_wire === "true" || item.welding_wire === "on"
                ? '<input type="checkbox" id="welding_wire" name="welding_wire_c" >'
                : '<input type="checkbox" id="welding_wire" name="welding_wire_c" disabled>') +
            "</div><br>";

        // Link to Material Certificate
        html += '<div class="welding_field">';
        html +=
            "<label>Link to Material Certificate:</label>" +
            '<input style="width:100%"type="text" name="link_to_wire_certificate_c" value="' +
            item.link_to_wire_certificate +
            '"disabled>' +
            "</div><br>";

        // Welding Consumable - Shielding Gas
        html += '<div class="welding_field">';
        html +=
            "<label>Welding Consumable - Shielding Gas:</label>" +
            (item.shielding_gas === "true" || item.shielding_gas === "on"
                ? '<input type="checkbox" id="shielding_gas" name="shielding_gas_c" >'
                : '<input type="checkbox" id="shielding_gas" name="shielding_gas_c" disabled>') +
            "</div><br>";

        // Link to Gas Data Sheet
        html += '<div class="welding_field">';
        html +=
            "<label>Link to Gas Data Sheet:</label>" +
            '<input style="width:100%"type="text" name="link_to_gas_data_sheet_c" value="' +
            item.link_to_gas_data_sheet +
            '"disabled>' +
            "</div><br>";

        // Pre-Weld inspection
        html += '<div class="welding_field">';
        html +=
            "<label>Pre-Weld inspection:</label>" +
            (item.pre_weld_inspection === "true" ||
            item.pre_weld_inspection === "on"
                ? '<input type="checkbox" id="pre_weld_inspection" name="pre_weld_inspection_c" >'
                : '<input type="checkbox" id="pre_weld_inspection" name="pre_weld_inspection_c" disabled>') +
            "</div><br>";

        // Inspection During Welding
        html += '<div class="welding_field">';
        html +=
            "<label>Inspection During Welding:</label>" +
            (item.inspection_during_welding === "true" ||
            item.inspection_during_welding === "on"
                ? '<input type="checkbox" id="inspection_during_welding" name="inspection_during_welding_c" >'
                : '<input type="checkbox" id="inspection_during_welding" name="inspection_during_welding_c" disabled>') +
            "</div><br>";

        // Post-Weld Inspection
        html += '<div class="welding_field">';
        html +=
            "<label>Post-Weld Inspection:</label>" +
            (item.post_weld_inspection === "true" ||
            item.post_weld_inspection === "on"
                ? '<input type="checkbox" id="post_weld_inspection" name="post_weld_inspection_c" >'
                : '<input type="checkbox" id="post_weld_inspection" name="post_weld_inspection_c" disabled>') +
            "</div><br>";

        // Sign Off
        html += '<div class="welding_field">';
        html +=
            "<label>Sign Off:</label>" +
            '<input style="width:100%"type="text" name="sign_off_welding_complete_c" value="' +
            userName +
            '">' +
            "</div><br>";

        // Comments
        html += '<div class="welding_field">';
        html +=
            "<label>Comments:</label>" +
            '<input style="width:100%"type="text" name="comments_welding_complete_c" value="' +
            item.comments_welding +
            '">' +
            "</div><br>";

        // Status dropdown
        html += '<div class="welding_field">';
        html +=
            "<label>Status:</label>" +
            '<select style="width:100%"name="status">' +
            '<option value="partially_completed">Partially Completed</option>' +
            '<option value="completed">Completed</option>' +
            "</select>" +
            "</div><br>";

        html += "</div>"; // Closing div for welding_item
        html += "<hr>"; // Horizontal line for separation
    });

    html +=
        '<input type="button" value="Submit" onclick="submitWeldingCompleteForm()">';
    html +=
        '  <input type="button" value="View" onclick="ViewWeldingCompleteForm()">';
    html += "</form>";

    html += '<div id="welding_complete_results"></div>';
    html+='</div>';
    html += "</fieldset>";

    return html;
}

// Function to submit the welding tasks completion form
function submitWeldingCompleteForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        weld_map_issued: document.querySelector('[name="weld_map_issued_c"]')
            .checked
            ? "on"
            : "",
       // link_to_weld_map: document.querySelector('[name="link_to_weld_map_c"]')
          //  .value,
        weld_procedure_qualification: document.querySelector(
            '[name="weld_procedure_qualification_c"]'
        ).checked
            ? "on"
            : "",
     //   link_to_pqr: document.querySelector('[name="link_to_pqr_c"]').value,
        weld_procedure_specifications: document.querySelector(
            '[name="weld_procedure_specifications_c"]'
        ).checked
            ? "on"
            : "",
     //   link_to_wps: document.querySelector('[name="link_to_wps_c]').value,
        welder_performance_qualification: document.querySelector(
            '[name="welder_performance_qualification_c"]'
        ).checked
            ? "on"
            : "",
      //  link_to_wpq: document.querySelector('[name="link_to_wpq_c"]').value,
        welding_wire: document.querySelector('[name="welding_wire_c"]').checked
            ? "on"
            : "",
        link_to_wire_certificate: document.querySelector(
            '[name="link_to_wire_certificate_c"]'
        ).value,
        shielding_gas: document.querySelector('[name="shielding_gas_c"]').checked
            ? "on"
            : "",
       // link_to_gas_data_sheet: document.querySelector(
        //    '[name="link_to_gas_data_sheet_c"]'
        //).value,
        pre_weld_inspection: document.querySelector(
            '[name="pre_weld_inspection_c"]'
        ).checked
            ? "on"
            : "",
        inspection_during_welding: document.querySelector(
            '[name="inspection_during_welding_c"]'
        ).checked
            ? "on"
            : "",
        post_weld_inspection: document.querySelector(
            '[name="post_weld_inspection_c"]'
        ).checked
            ? "on"
            : "",
        sign_off_welding_complete: document.querySelector(
            '[name="sign_off_welding_complete_c"]'
        ).value,
        comments_welding_complete: document.querySelector(
            '[name="comments_welding_complete_c"]'
        ).value,
        status: document.querySelector('[name="status"]').value,
        submission_date: new Date().toISOString().split("T")[0], // Get today's date in YYYY-MM-DD format
        process_order_number: document.querySelector('[name="processorder"]')
            .value, // Update with actual process order number
    };

    $.ajax({
        type: "POST",
        url: "/submitWeldingCompleteForm",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            //displayWeldingCompleteResults(response);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        },
    });
    formData = {};
}
function ViewWeldingCompleteForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: document.querySelector('[name="processorder"]')
            .value,
    };
    console.log(formData);
    $.ajax({
        type: "POST",
        url: "/viewWeldingCompleteForm",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            displayWeldingCompleteResults(response);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        },
    });
}
// Function to display the welding tasks completion results
function displayWeldingCompleteResults(values) {
    var resultsHtml =
        '<table id="welding_complete_results_table" style="width:100%; border-collapse: collapse; border: 1px solid #ddd; text-align: left;">';
    resultsHtml +=
        '<thead><tr style="background-color: #f2f2f2;"><th style="padding: 8px; border-bottom: 1px solid #ddd;">Field</th><th style="padding: 8px; border-bottom: 1px solid #ddd;">Value</th></tr></thead>';
    resultsHtml += "<tbody>";

    function buildTableRows(obj, prefix) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key)) {
                var value = obj[key];
                var field =  key;
                if (typeof value === "object") {
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

    resultsHtml += "</tbody></table>";

    document.getElementById("welding_complete_results").innerHTML = resultsHtml;
}

function resetWeldingForm() {
    // Uncheck checkboxes
    $('input[name="weld_map_issued"]').prop("checked", false);
    $('input[name="weld_procedure_qualification"]').prop("checked", false);
    $('input[name="weld_procedure_specifications"]').prop("checked", false);
    $('input[name="welder_performance_qualification"]').prop("checked", false);
    $('input[name="welding_wire"]').prop("checked", false);
    $('input[name="shielding_gas"]').prop("checked", false);
    $('input[name="pre_weld_inspection"]').prop("checked", false);
    $('input[name="inspection_during_welding"]').prop("checked", false);
    $('input[name="post_weld_inspection"]').prop("checked", false);
    $('input[name="welding_plant_calibration_certificate"]').prop(
        "checked",
        false
    );

    // Clear text inputs
    $('input[name="sign_off_welding"]').val("");
    $('textarea[name="comments_welding"]').val("");

    // Reset file input values and filenames
    $('input[name="link_to_weld_map"]').val("");
    $("#old_weld_map_filename").text("");
    $('input[name="link_to_pqr"]').val("");
    $("#old_pqr_filename").text("");
    $('input[name="link_to_wps"]').val("");
    $("#old_wps_filename").text("");
    $('input[name="link_to_wpq"]').val("");
    $("#old_wpq_filename").text("");
    $('input[name="link_to_wire_certificate"]').val("");
    $("#old_wire_certificate_filename").text("");
    $('input[name="link_to_gas_data_sheet"]').val("");
    $("#old_gas_data_sheet_filename").text("");
    $('input[name="link_to_plant_cert"]').val("");
    $("#old_plant_cert_filename").text("");



    
    $('select[name="owner_weld"]').val('NULL');
    $('select[name="ndttype_weld"]').val('NULL');
}

function Welding(processOrder, userName) {
    console.log("Welding");
    console.log(processOrder);
    // Hide other fieldsets
    $("#planningFieldset").hide();
    $("#qualityFieldset").hide();
    $("#manufacturingFieldset").hide();
    $("#engineeringFieldset").hide();
    $("#kittingFieldset").hide();

    // Show Welding fieldset
    $("#weldingFieldset").show();

    // Set username and process order
    $('input[name="sign_off_welding"]').val(userName);
    $("#process_order_number_welding").val(processOrder);


    
    // Prepare headers and data for AJAX request
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: processOrder,
    };

    // Fetch Welding Form Data for the given process order
    $.ajax({
        url: "/getWeldingDataByProcessOrder", // Adjust URL as needed
        type: "POST",
        headers: headers,
        data: formData,
        dataType: "json",
        success: function (response) {
            resetWeldingForm();

            console.log(userName);
            $('input[name="sign_off_welding"]').val(userName);
            if (response.data != null) {
                console.log("Welding data found");
                console.log(response);
                $("#process_order_number_welding").val(processOrder);

                // Set checkbox states
                $('input[name="weld_map_issued"]').prop(
                    "checked",
                    response.data.weld_map_issued === "true"
                );

                fetchOwnerData_Welding(processOrder, 'Weld Map: Weld Map issued to production', function (ownerData) {
                    if (ownerData) {
                        // Update owner cell
                        $(`select[name="owner_weld"][data-task="weld_map_issued"]`).val(ownerData.owner.trim());
                        // Update NDT cell
                        $(`select[name="ndttype_weld"][data-task="weld_map_issued"]`).val(ownerData.ndta.trim());
                    } else {
                        // Handle case where no owner data is retrieved
                        $(`select[name="owner_weld"][data-task="weld_map_issued"]`).val('NULL');
                        $(`select[name="ndttype_weld"][data-task="weld_map_issued"]`).val('NULL');
                    }
                });


                $('input[name="weld_procedure_qualification"]').prop(
                    "checked",
                    response.data.weld_procedure_qualification === "true"
                );

                fetchOwnerData_Welding(processOrder, 'Weld Procedure Qualification Record:', function (ownerData) {
                    if (ownerData) {
                        // Update owner cell
                        $(`select[name="owner_weld"][data-task="weld_procedure_qualification"]`).val(ownerData.owner.trim());
                        // Update NDT cell
                        $(`select[name="ndttype_weld"][data-task="weld_procedure_qualification"]`).val(ownerData.ndta.trim());
                    } else {
                        // Handle case where no owner data is retrieved
                        $(`select[name="owner_weld"][data-task="weld_procedure_qualification"]`).val('NULL');
                        $(`select[name="ndttype_weld"][data-task="weld_procedure_qualification"]`).val('NULL');
                    }
                });



                $('input[name="weld_procedure_specifications"]').prop(
                    "checked",
                    response.data.weld_procedure_specifications === "true"
                );
                fetchOwnerData_Welding(processOrder, 'Weld Procedure Specifications:', function (ownerData) {
                    if (ownerData) {
                        // Update owner cell
                        $(`select[name="owner_weld"][data-task="weld_procedure_specifications"]`).val(ownerData.owner.trim());
                        // Update NDT cell
                        $(`select[name="ndttype_weld"][data-task="weld_procedure_specifications"]`).val(ownerData.ndta.trim());
                    } else {
                        // Handle case where no owner data is retrieved
                        $(`select[name="owner_weld"][data-task="weld_procedure_specifications"]`).val('NULL');
                        $(`select[name="ndttype_weld"][data-task="weld_procedure_specifications"]`).val('NULL');
                    }
                });

                
                $('input[name="welder_performance_qualification"]').prop(
                    "checked",
                    response.data.welder_performance_qualification === "true"
                );
                fetchOwnerData_Welding(processOrder, 'Welder Performance Qualification:', function (ownerData) {
                    if (ownerData) {
                        // Update owner cell
                        $(`select[name="owner_weld"][data-task="welder_performance_qualification"]`).val(ownerData.owner.trim());
                        // Update NDT cell
                        $(`select[name="ndttype_weld"][data-task="welder_performance_qualification"]`).val(ownerData.ndta.trim());
                    } else {
                        // Handle case where no owner data is retrieved
                        $(`select[name="owner_weld"][data-task="welder_performance_qualification"]`).val('NULL');
                        $(`select[name="ndttype_weld"][data-task="welder_performance_qualification"]`).val('NULL');
                    }
                });


                $('input[name="welding_wire"]').prop(
                    "checked",
                    response.data.welding_wire === "true"
                );
                fetchOwnerData_Welding(processOrder, 'Welding Consumable - Welding Wire:', function (ownerData) {
                    if (ownerData) {
                        // Update owner cell
                        $(`select[name="owner_weld"][data-task="welding_wire"]`).val(ownerData.owner.trim());
                        // Update NDT cell
                        $(`select[name="ndttype_weld"][data-task="welding_wire"]`).val(ownerData.ndta.trim());
                    } else {
                        // Handle case where no owner data is retrieved
                        $(`select[name="owner_weld"][data-task="welding_wire"]`).val('NULL');
                        $(`select[name="ndttype_weld"][data-task="welding_wire"]`).val('NULL');
                    }
                });


                $('input[name="shielding_gas"]').prop(
                    "checked",
                    response.data.shielding_gas === "true"
                );
                fetchOwnerData_Welding(processOrder, 'Welding Consumable - Shielding Gas:', function (ownerData) {
                    if (ownerData) {
                        // Update owner cell
                        $(`select[name="owner_weld"][data-task="shielding_gas"]`).val(ownerData.owner.trim());
                        // Update NDT cell
                        $(`select[name="ndttype_weld"][data-task="shielding_gas"]`).val(ownerData.ndta.trim());
                    } else {
                        // Handle case where no owner data is retrieved
                        $(`select[name="owner_weld"][data-task="shielding_gas"]`).val('NULL');
                        $(`select[name="ndttype_weld"][data-task="shielding_gas"]`).val('NULL');
                    }
                });


                $('input[name="pre_weld_inspection"]').prop(
                    "checked",
                    response.data.pre_weld_inspection === "true"
                );


                fetchOwnerData_Welding(processOrder, 'Pre-Weld inspection: Check weld joint preparation against WPS', function (ownerData) {
                    if (ownerData) {
                        // Update owner cell
                        $(`select[name="owner_weld"][data-task="pre_weld_inspection"]`).val(ownerData.owner.trim());
                        // Update NDT cell
                        $(`select[name="ndttype_weld"][data-task="pre_weld_inspection"]`).val(ownerData.ndta.trim());
                    } else {
                        // Handle case where no owner data is retrieved
                        $(`select[name="owner_weld"][data-task="pre_weld_inspection"]`).val('NULL');
                        $(`select[name="ndttype_weld"][data-task="pre_weld_inspection"]`).val('NULL');
                    }
                });
                $('input[name="inspection_during_welding"]').prop(
                    "checked",
                    response.data.inspection_during_welding === "true"
                );
                fetchOwnerData_Welding(processOrder, 'Inspection During Welding: Check requirements of the WPS', function (ownerData) {
                    if (ownerData) {
                        // Update owner cell
                        $(`select[name="owner_weld"][data-task="inspection_during_welding"]`).val(ownerData.owner.trim());
                        // Update NDT cell
                        $(`select[name="ndttype_weld"][data-task="inspection_during_welding"]`).val(ownerData.ndta.trim());
                    } else {
                        // Handle case where no owner data is retrieved
                        $(`select[name="owner_weld"][data-task="inspection_during_welding"]`).val('NULL');
                        $(`select[name="ndttype_weld"][data-task="inspection_during_welding"]`).val('NULL');
                    }
                });



                $('input[name="post_weld_inspection"]').prop(
                    "checked",
                    response.data.post_weld_inspection === "true"
                );

                fetchOwnerData_Welding(processOrder, 'Post-Weld Inspection: Visual weld inspection - All Welds', function (ownerData) {
                    if (ownerData) {
                        // Update owner cell
                        $(`select[name="owner_weld"][data-task="post_weld_inspection"]`).val(ownerData.owner.trim());
                        // Update NDT cell
                        $(`select[name="ndttype_weld"][data-task="post_weld_inspection"]`).val(ownerData.ndta.trim());
                    } else {
                        // Handle case where no owner data is retrieved
                        $(`select[name="owner_weld"][data-task="post_weld_inspection"]`).val('NULL');
                        $(`select[name="ndttype_weld"][data-task="post_weld_inspection"]`).val('NULL');
                    }
                });


                $('input[name="welding_plant_calibration_certificate"]').prop(
                    "checked",
                    response.data.welding_plant_calibration_certificate === "true"
                );


                fetchOwnerData_Welding(processOrder, 'Welding Plant Calibration Certificate: Check weld log for welding plant number', function (ownerData) {
                    if (ownerData) {
                        // Update owner cell
                        $(`select[name="owner_weld"][data-task="welding_plant_calibration_certificate"]`).val(ownerData.owner.trim());
                        // Update NDT cell
                        $(`select[name="ndttype_weld"][data-task="welding_plant_calibration_certificate"]`).val(ownerData.ndta.trim());
                    } else {
                        // Handle case where no owner data is retrieved
                        $(`select[name="owner_weld"][data-task="welding_plant_calibration_certificate"]`).val('NULL');
                        $(`select[name="ndttype_weld"][data-task="welding_plant_calibration_certificate"]`).val('NULL');
                    }
                });

                // Set other fields
                $('input[name="sign_off_welding"]').val(userName);
                $('textarea[name="comments_welding"]').val(
                    response.data.comments_welding_complete
                );

                // Set file input field
                if (response.data.link_to_weld_map !== null) {
                    $("#old_weld_map_filename").text(
                        response.data.link_to_weld_map
                    );
                }
                if (response.data.link_to_pqr !== null) {
                    $("#old_pqr_filename").text(response.data.link_to_pqr);
                }
                if (response.data.link_to_wps !== null) {
                    $("#old_wps_filename").text(response.data.link_to_wps);
                }
                if (response.data.link_to_wpq !== null) {
                    $("#old_wpq_filename").text(response.data.link_to_wpq);
                }
                if (response.data.link_to_wire_certificate !== null) {
                    $("#old_wire_certificate_filename").text(
                        response.data.link_to_wire_certificate
                    );
                }
                if (response.data.link_to_gas_data_sheet !== null) {
                    $("#old_gas_data_sheet_filename").text(
                        response.data.link_to_gas_data_sheet
                    );
                }
                if (response.data.link_to_plant_cert !== null) {
                    $("#old_plant_cert_filename").text(
                        response.data.link_to_plant_cert
                    );
                }

                // Attach handler for file input change
                $('input[name="link_to_weld_map"]').change(function () {
                    $("#old_weld_map_filename").text(this.files[0].name);
                });
                $('input[name="link_to_pqr"]').change(function () {
                    $("#old_pqr_filename").text(this.files[0].name);
                });
                $('input[name="link_to_wps"]').change(function () {
                    $("#old_wps_filename").text(this.files[0].name);
                });
                $('input[name="link_to_wpq"]').change(function () {
                    $("#old_wpq_filename").text(this.files[0].name);
                });
                $('input[name="link_to_wire_certificate"]').change(function () {
                    $("#old_wire_certificate_filename").text(
                        this.files[0].name
                    );
                });
                $('input[name="link_to_gas_data_sheet"]').change(function () {
                    $("#old_gas_data_sheet_filename").text(this.files[0].name);
                });
                $('input[name="link_to_plant_cert"]').change(function () {
                    $("#old_plant_cert_filename").text(this.files[0].name);
                });
            } else {
                resetWeldingForm();
                $("#process_order_number_welding").val(processOrder);
                $('input[name="sign_off_welding"]').val(userName);
                $("#weldingFieldset").show();
            }
        },
        error: function (error) {
            console.error(error);
        },
    });
}
