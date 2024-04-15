function submitQualityForm() {
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };

    var formData = {
        process_order_number: document.querySelector('[name="process_order_number_quality"]').value || null,
        walk_down_visual_inspection: document.querySelector('[name="walk_down_visual_inspection"]').checked ? 'Yes' : 'No',
        // Add other form fields accordingly
    };

    // Send an AJAX request to the server
    $.ajax({
        url: '/submitQualityForm',
        type: 'POST',
        data: formData,
        headers: headers,
        success: function (response) {
            console.log(response);
            alert('Quality Engineering checks form submitted successfully');
            // Optionally update the table or perform other actions
        },
        error: function (error) {
            console.error('Error submitting Quality Engineering checks form:', error);
            alert('Error submitting Quality Engineering checks form');
        }
    });
}

function generateQualityFieldTable(processOrder) {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        process_order_number: processOrder,
    };
   console.log( formData

   );
    $.ajax({
        url: "/getQualityDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            if(response!==null)
            {
            var generatedHTML = generateHTMLFromResponse_for_quality(response);

            $("#qualityFieldTable").html(generatedHTML);
            }
            else

        {
            $("#qualityFieldTable").html(''); 
        }
        },
        error: function (error) {
            console.error(error);
        },
    });

    return `
        <div>To be Done</div>
    `;
}

function generateHTMLFromResponse_for_quality(response) {
    var html = '<table id="quality_table" style="width:100%;">';
    html += '<thead><tr>';
    html += '<th style="width:5%;">Quality ID</th>';
    html += '<th style="width:20%;">Process Order</th>';
    html += '<th style="width:20%;">Walk-down and Visual Inspection</th>';
    html += '<th style="width:20%;">Upload Images</th>';
    html += '<th style="width:20%;">Comments Quality</th>';
    html += '<th style="width:20%;">Sign-off Quality</th>';
    html += '<th style="width:20%;">Submission Date</th>';
    html += '<th style="width:5%;">Created At</th>';
    html += '<th style="width:5%;">Updated At</th>';
    html += '</tr></thead><tbody>';

    if (Array.isArray(response)) {
        response.forEach(function (item, index) {
            html += "<tr>";
            html += "<td>" + item.ID + "</td>";
            html += "<td>" + item.process_order_number + "</td>";
            html += "<td>" + (item.walk_down_visual_inspection ? "Yes" : "No") + "</td>";
            html += '<td id="images_' + item.ID + '">'; // Unique ID for images container

            // Call fetchImages to get image URLs
            fetchImages(item.ID, function(images) {
                if (images && images.length > 0) {
                    images.forEach(function (imageUrl) {
                        console.log(imageUrl)
                        html += '<img src="' + imageUrl + '" style="max-width: 100px; max-height: 100px;">';
                    });
                } else {
                    html += '-';
                }

                html += '</td>';
                html += "<td>" + (item.comments_quality ? item.comments_quality : '-') + "</td>";
                html += "<td>" + (item.sign_off_quality ? item.sign_off_quality : '-') + "</td>";
                html += "<td>" + item.submission_date + "</td>";
                html += "<td>" + item.created_at + "</td>";
                html += "<td>" + item.updated_at + "</td>";
                html += "</tr>";

                // Append the HTML to the table after processing all items
                if (index === response.length - 1) {
                    html += "</tbody></table>";
                    $('#quality_table').html(html);
                }
            });
        });
    } else if (typeof response === 'object') {
        console.log(response.ID);
        html += "<tr>";
        html += "<td>" + response.ID + "</td>";
        html += "<td>" + response.process_order_number + "</td>";
        html += "<td>" + (response.walk_down_visual_inspection ? "Yes" : "No") + "</td>";
        html += '<td id="images_' + response.ID + '">'; // Unique ID for images container

        // Call fetchImages to get image URLs
        fetchImages(response.process_order_number, function(images) {
            if (images && images.length > 0) {
                
                images.forEach(function (imageUrl) {
                    html += '<div style="display: inline-block; margin-right: 10px;">';
                    html += '<a href="/storage/images_qlty/' + response.process_order_number.trim() + '/' + imageUrl + '" download>';
                    html += '<img src="/storage/images_qlty/' + response.process_order_number.trim() + '/' + imageUrl + '" style="max-width: 100px; max-height: 100px;"></a></div>';
                });
            } else {
                html += '-';
            }

            html += '</td>';
            html += "<td>" + (response.comments_quality ? response.comments_quality : '-') + "</td>";
            html += "<td>" + (response.sign_off_quality ? response.sign_off_quality : '-') + "</td>";
            html += "<td>" + response.submission_date + "</td>";
            html += "<td>" + response.created_at + "</td>";
            html += "<td>" + response.updated_at + "</td>";
            html += "</tr>";

            html += "</tbody></table>";
            $('#quality_table').html(html);
            
        });
    }
    return(html);
}
// Function to fetch images for a given ID
// Function to fetch images for a given ID
function fetchImages(id, callback) {

    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };
    $.ajax({
        url: '/getImages_qlty', // Your API endpoint to fetch images
        method: 'POST',
        headers: headers, // Include CSRF token in headers
        data: {
            id: id
        },
        success: function (response) {
            callback(response.filenames || []); // Ensure response.filenames is an array or use an empty array
        },
        error: function (error) {
            console.error('Error fetching images:', error);
            callback([]);
        }
    });
}


function generateQualityCompleteFieldset(processOrder, qualityStep, username) {
    var formData = {
        process_order_number: processOrder,
    };
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    $("#responsible_person_complete").val(username);

    $.ajax({
        url: "/getQualityDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            var generatedHTML = generateCompleteHTMLFromResponse_for_quality(response);
            $("#qualityCompleteFieldTable").html(generatedHTML);
        },
        error: function (error) {
            console.error(error);
        },
    });
}

function generateCompleteHTMLFromResponse_for_quality(response) {
    var html = '<fieldset><legend>Quality Complete</legend>';
    html += '<form id="quality_complete_form">';

    $.each(response, function (index, item) {
        html += '<div class="quality_item">';
        html += '<label>ID: ' + item.id + '</label><br>';

        // Walk-down and Visual Inspection
        html += '<div class="quality_field">';
        html +=
            '<label>Walk-down and Visual Inspection:</label>' +
            (item.walk_down_visual_inspection === "Yes" ?
                '<input type="checkbox" id="walk_down_visual_inspection" name="walk_down_visual_inspection" checked>' :
                '<input type="checkbox" id="walk_down_visual_inspection" name="walk_down_visual_inspection">') +
            '</div><br>';

        // Upload Images
        html += '<div class="quality_field">';
        html +=
            '<label>Upload Images:</label>' +
            '<input type="file" name="quality_images" multiple>' +
            '</div><br>';

        // Comments
        html += '<div class="quality_field">';
        html +=
            '<label>Comments:</label>' +
            '<input type="text" name="comments_quality" value="' + (item.comments_quality ? item.comments_quality : '') + '">' +
            '</div><br>';

        // Sign-off Quality
        html += '<div class="quality_field">';
        html +=
            '<label>Sign-off Quality:</label>' +
            '<input type="text" name="sign_off_quality" value="' + (item.sign_off_quality ? item.sign_off_quality : '') + '">' +
            '</div><br>';

        // Submission Date (hidden)
        html += '<input type="hidden" name="submission_date" value="' + new Date().toISOString().split("T")[0] + '">';

        html += '</div>'; // Closing div for quality_item
        html += '<hr>'; // Horizontal line for separation
    });

    html += '<input type="button" value="Submit" onclick="submitQualityCompleteForm()">';
    html += '</form>';

    html += '<div id="quality_complete_results"></div>';
    html += '</fieldset>';

    return html;
}
function submitQualityCompleteForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };

    var formData = {
        walk_down_visual_inspection: document.querySelector('[name="walk_down_visual_inspection"]').checked ? "Yes" : "No",
        comments_quality: document.querySelector('[name="comments_quality"]').value,
        sign_off_quality: document.querySelector('[name="sign_off_quality"]').value,
        submission_date: document.querySelector('[name="submission_date"]').value,
        process_order_number: 2, // Adjust as needed
    };

    var files = document.querySelector('[name="quality_images"]').files;
    if (files.length > 0) {
        formData.quality_images = files;
    }

    $.ajax({
        type: "POST",
        url: "/submitQualityCompleteForm",
        data: formData,
        headers: headers,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function (response) {
            displayQualityResults(response);
            console.log(response);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}
function displayQualityResults(values) {
    var resultsHtml = '<table id="quality_results_table" style="width:100%; border-collapse: collapse; border: 1px solid #ddd; text-align: left;">';
    resultsHtml += '<thead><tr style="background-color: #f2f2f2;"><th style="padding: 8px; border-bottom: 1px solid #ddd;">Field</th><th style="padding: 8px; border-bottom: 1px solid #ddd;">Value</th></tr></thead>';
    resultsHtml += '<tbody>';

    function buildTableRows(obj, prefix) {
        for (var key in obj) {
            if (obj.hasOwnProperty(key)) {
                var value = obj[key];
                var field = prefix ? prefix + '.' + key : key;
                if (typeof value === 'object') {
                    buildTableRows(value, field);
                } else {
                    resultsHtml += '<tr><td style="padding: 8px; border-bottom: 1px solid #ddd;">' + field + '</td><td style="padding: 8px; border-bottom: 1px solid #ddd;">' + value + '</td></tr>';
                }
            }
        }
    }

    buildTableRows(values);

    resultsHtml += '</tbody></table>';

    document.getElementById('quality_complete_results').innerHTML = resultsHtml;
}

