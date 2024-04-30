
function generateQualityFieldset(processOrder, qualityStep, username) {
    $("#sign_off_quality").val(username);
    
}
// Function to handle image upload
function uploadImages_QLTY() {
    var imagesInput = document.getElementById('imagesInput');
    var po = document.querySelector('[name="process_order_number_quality"]').value || null;
    console.log(po);

    var formData = new FormData();
    if (imagesInput.files.length > 0) {
        // Append each selected image to the formData
        for (var i = 0; i < imagesInput.files.length; i++) {
            formData.append('images[]', imagesInput.files[i]);
        }

        // Append other form data if needed
        formData.append('process_order_number', po);
        formData.append('uuid', uuid);

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
    

}
function uploadImages_CompleteQLTY() {
    var imagesInput = document.getElementById('InputImages');
    var po = document.querySelector('[name="process_order_number_qlty"]').value || null;
    var uuid_qlty = document.querySelector('[name="uuidDisplay_qlty"]').innerText.trim();
    console.log(po);

    var formData = new FormData();
    if (imagesInput.files.length > 0) {
        // Append each selected image to the formData
        for (var i = 0; i < imagesInput.files.length; i++) {
            formData.append('images[]', imagesInput.files[i]);
        }

        // Append other form data if needed
        formData.append('process_order_number', po);
        formData.append('uuid_qlty', uuid_qlty);

        // Send the images using AJAX
        $.ajax({
            url: '/upload_completeqltyimages',
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
    

}
function submitQualityForm() {
    uploadImages_QLTY();
    // Function to handle image upload



    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };

    var formData = {
        process_order_number: document.querySelector('[name="process_order_number_quality"]').value || null,
        walk_down_visual_inspection: document.querySelector('[name="walk_down_visual_inspection"]').checked ? 'Yes' : 'No',
        uuid: document.getElementById('uuidDisplay').textContent || null,

        // Add other form fields accordingly
    };
    console.log(formData);
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
    console.log(formData

    );
    $.ajax({
        url: "/getQualityDataByProcessOrder",
        type: "POST",
        data: formData,
        headers: headers,
        dataType: "json",
        success: function (response) {
            console.log(response);
            if (response !== null) {
                var generatedHTML = generateHTMLFromResponse_for_quality(response);

                $("#qualityFieldTable").html(generatedHTML);
            }
            else {
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

function generateHTMLFromResponse_for_quality_old(response) {
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
            fetchImages(item.ID, function (images) {
                if (images && images.length > 0) {
                    images.forEach(function (imageUrl) {
                        console.log(imageUrl);
                        console.log(response.uuid);
                        html += '<div style="display: inline-block; margin-right: 10px;">';
                        html += '<a href="/storage/images_qlty/' + response.process_order_number.trim() + '/' + response.uuid + '/'+ imageUrl +'" download>';
                        html += '<img src="/storage/images_qlty/' + response.process_order_number.trim() +  '/' + response.uuid + '/' + imageUrl + '" style="max-width: 50px; max-height: 50px;"></a></div>';
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
        console.log(response.uuid);
        html += "<tr>";
        html += "<td>" + parseInt(response.ID) + "</td>";
        html += "<td>" + response.process_order_number + "</td>";
        html += "<td>" + (response.walk_down_visual_inspection ? "Yes" : "No") + "</td>";
        html += '<td id="images_' + response.ID + '">'; // Unique ID for images container

        // Call fetchImages to get image URLs
        fetchImages(response.process_order_number, function (images) {
           // alert('OK');
            if (images && images.length > 0) {

                images.forEach(function (imageUrl) {
                    console.log(imageUrl);
                    console.log(response.process_order_number.trim());
                    console.log(response.uuid());

                    html += '<div style="display: inline-block; margin-right: 10px;">';
                    html += '<a href="/storage/images_qlty/' + response.process_order_number.trim() + '/' + response.uuid + '/'+ imageUrl +'" download>';
                    html += '<img src="/storage/images_qlty/' + response.process_order_number.trim() +  '/' + response.uuid + '/' + imageUrl + '" style="max-width: 50px; max-height: 50px;"></a></div>';
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
    return (html);
}
function generateHTMLFromResponse_for_quality(response) {
    var html = '<form id="qualityForm" class="quality-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Quality</legend>';

    if (Array.isArray(response)) {
        response.forEach(function (item, index) {
            html += '<div class="quality-item">';
            
            html += '<div class="quality-field">';
            html += '<label for="quality_id">Quality ID:</label>';
            html += '<input type="text" id="quality_id" name="quality_id" value="' + item.ID + '" readonly>';
            html += '</div><br>';
            
            html += '<div class="quality-field">';
            html += '<label for="process_order_number">Process Order:</label>';
            html += '<input type="text" id="process_order_number" name="process_order_number" value="' + item.process_order_number + '" readonly>';
            html += '</div><br>';
            
            html += '<div class="quality-field">';
            html += '<label for="walk_down_visual_inspection">Walk-down and Visual Inspection:</label>';
            html += '<input type="text" id="walk_down_visual_inspection" name="walk_down_visual_inspection" value="' + (item.walk_down_visual_inspection ? "Yes" : "No") + '" readonly>';
            html += '</div><br>';
            
            html += '<div class="quality-field">';
            html += '<label for="images">Images:</label>';
            html += '<div id="images_' + item.ID + '">'; // Unique ID for images container
            html += '</div><br>'; // Closing div for images container

            // Fetch images and append them dynamically
            fetchImages(item.process_order_number, function (images) {
                var imagesContainer = document.getElementById('images_' + item.ID);
                if (images && images.length > 0) {
                    images.forEach(function (imageUrl) {
                        var imgElement = document.createElement('img');
                        imgElement.src = imageUrl;
                        imgElement.style.maxWidth = '100px';
                        imgElement.style.maxHeight = '100px';
                        imagesContainer.appendChild(imgElement);

                        // Adding download link
                        var downloadLink = document.createElement('a');
                        downloadLink.href = '/storage/images_qlty/' + item.process_order_number.trim() + '/' + item.uuid + '/' + imageUrl;
                        downloadLink.download = 'image_' + index + '.jpg'; // Setting download attribute
                        downloadLink.innerText = 'Download Image'; // Text for download link
                        imagesContainer.appendChild(downloadLink); // Appending download link
                    });
                } else {
                    imagesContainer.innerHTML = '-';
                }
            });

            // Remaining fields...
            
            html += '</div>'; // Closing div for quality-item
            html += '<hr>'; // Horizontal line for separation
        });
    } else if (typeof response === 'object') {
        // Handling for object response
        html += '<div class="quality-item">';
        
        html += '<div class="quality-field">';
        html += '<label for="quality_id">Quality ID:</label>';
        html += '<input type="text" id="quality_id" name="quality_id" value="' + parseInt(response.ID) + '" readonly>';
        html += '</div><br>';
        
        html += '<div class="quality-field">';
        html += '<label for="process_order_number">Process Order:</label>';
        html += '<input type="text" id="process_order_number" name="process_order_number" value="' + response.process_order_number + '" readonly>';
        html += '</div><br>';
        
        html += '<div class="quality-field">';
        html += '<label for="walk_down_visual_inspection">Walk-down and Visual Inspection:</label>';
        html += '<input type="text" id="walk_down_visual_inspection" name="walk_down_visual_inspection" value="' + (response.walk_down_visual_inspection ? "Yes" : "No") + '" readonly>';
        html += '</div><br>';
        
        html += '<div class="quality-field">';
        html += '<label for="images">Images:</label>';
        html += '<div id="images_' + response.ID + '">'; // Unique ID for images container

        // Fetch images and append them dynamically
        fetchImages(response.process_order_number, function (images) {
            var imagesContainer = document.getElementById('images_' + response.ID);
            if (images && images.length > 0) {
                images.forEach(function (imageUrl) {
                    var imgElement = document.createElement('img');
                    imgElement.src = imageUrl;
                    imgElement.style.maxWidth = '100px';
                    imgElement.style.maxHeight = '100px';
                    imagesContainer.appendChild(imgElement);

                    // Adding download link
                    var downloadLink = document.createElement('a');
                    downloadLink.href = '/storage/images_qlty/' + response.process_order_number.trim() + '/' + response.uuid + '/' + imageUrl;
                    downloadLink.download = 'image.jpg'; // Setting download attribute
                    downloadLink.innerText = 'Download Image'; // Text for download link
                    imagesContainer.appendChild(downloadLink); // Appending download link
                });
            } else {
                imagesContainer.innerHTML = '-';
            }
        });
        
        // Remaining fields...

        html += '</div>'; // Closing div for images container
        html += '</div><br>'; // Closing div for quality-field
        
        html += '<div class="quality-field">';
        html += '<label for="comments_quality">Comments Quality:</label>';
        html += '<input type="text" id="comments_quality" name="comments_quality" value="' + (response.comments_quality ? response.comments_quality : '-') + '" readonly>';
        html += '</div><br>';
        
        html += '<div class="quality-field">';
        html += '<label for="sign_off_quality">Sign-off Quality:</label>';
        html += '<input type="text" id="sign_off_quality" name="sign_off_quality" value="' + (response.sign_off_quality ? response.sign_off_quality : '-') + '" readonly>';
        html += '</div><br>';
        
        html += '<div class="quality-field">';
        html += '<label for="submission_date">Submission Date:</label>';
        html += '<input type="text" id="submission_date" name="submission_date" value="' + response.submission_date + '" readonly>';
        html += '</div><br>';
        
        html += '<div class="quality-field">';
        html += '<label for="created_at">Created At:</label>';
        html += '<input type="text" id="created_at" name="created_at" value="' + response.created_at + '" readonly>';
        html += '</div><br>';
        
        html += '<div class="quality-field">';
        html += '<label for="updated_at">Updated At:</label>';
        html += '<input type="text" id="updated_at" name="updated_at" value="' + response.updated_at + '" readonly>';
        html += '</div><br>';
        
        html += '</div>'; // Closing div for quality-item
        html += '<hr>'; // Horizontal line for separation
    }

    html += '</fieldset></form>';

    return html;
}


// Function to fetch images for a given ID
// Function to fetch images for a given ID
function fetchImages(id, callback) {
console.log(id);
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
            console.log(response);
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
            
               // $("#qualityCompleteFieldTable").html('');
            
        },
        error: function (error) {
            console.error(error);
        },
    });
}



function generateCompleteHTMLFromResponse_for_quality(item) {
    var html = '<fieldset><legend>Quality Complete</legend>';


     // JavaScript code to generate and display UUID
     const uuidDisplay = document.getElementById('uuidDisplay_qlty');

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
     //uuidDisplay_qlty.textContent =uuid;
    html += '<form id="quality_complete_form">';

    html += '<div name="uuidDisplay_qlty" id="uuidDisplay_qlty">' + uuid + '</div>';
        html += '<div class="quality_item">';
        html += '<label>ID: ' + item.ID + '</label><br>';
        html += '<div class="quality_item">';
        html += '<input name="process_order_number_qlty"type="text" value="' + item.process_order_number.trim() + '" readonly>';

      
        // Walk-down and Visual Inspection
        html += '<div class="quality_field">';
        html +=
            '<label>Walk-down and Visual Inspection:</label>' +
            (item.walk_down_visual_inspection === "1" ?
                '<input type="checkbox" id="walk_down_visual_inspection" name="walk_down_visual_inspection_c" >' :
                '<input type="checkbox" id="walk_down_visual_inspection" name="walk_down_visual_inspection_c" disabled>') +
            '</div><br>';

        // Upload Images
        html += '<div class="quality_field">';
        html +=
            '<label>Upload Images:</label>' +
            '<input type="file" id="InputImages"name="quality_images" multiple>' +
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
            '<input type="text" name="sign_off_quality_c" value="' + userName + '">' +
            '</div><br>';

        // Submission Date (hidden)
        html += '<input type="hidden" name="submission_date" value="' + new Date().toISOString().split("T")[0] + '">';
       
        html += '</div>'; // Closing div for quality_item
        html += '<hr>'; // Horizontal line for separation


    html += '<input type="button" value="Submit" onclick="submitQualityCompleteForm()">';
    html += '<input type="button" value="View" onclick="viewQualityResults()">';
    html += '</form>';

    html += '<div id="quality_complete_results"></div>';
    html += '<div id="quality_images_container"></div>';
    html += '</fieldset>';

    return html;
}
function submitQualityCompleteForm() {
    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };
    uploadImages_CompleteQLTY();
    var formData = {
        walk_down_visual_inspection: document.querySelector('[name="walk_down_visual_inspection_c"]').checked ? "Yes" : "No",
        comments_quality: document.querySelector('[name="comments_quality"]').value,
        sign_off_quality: document.querySelector('[name="sign_off_quality_c"]').value,
       // submission_date: document.querySelector('[name="submission_date"]').value,
        process_order_number: document.querySelector('[name="process_order_number_qlty"]').value,
        uuid_qlty: document.querySelector('[name="uuidDisplay_qlty"]').textContent,
    };
console.log(formData);
   

    $.ajax({
        type: "POST",
        url: "/submitQualityCompleteForm",
        data: formData,
        headers: headers,
        dataType: "json",
       
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
console.log(values.data.process_order_number);
    fetchImages_cmplt(values.data.process_order_number, function(images) {
        //alert('yes');
        var imagesHtml = '';
        if (images && images.length > 0) {
            images.forEach(function(imageUrl) {
                console.log(imageUrl)
                imagesHtml += '<div style="display: inline-block; margin-right: 10px;">';
                imagesHtml += '<a href="/storage/images_qlty_complete/' + values.data.process_order_number.trim() + '/' + values.data.uuid + '/' + imageUrl + '" download>';
                imagesHtml += '<img src="/storage/images_qlty_complete/' + values.data.process_order_number.trim() + '/' + values.data.uuid + '/' + imageUrl + '" style="max-width: 50px; max-height: 50px;"></a></div>';
            });
        } else {
            imagesHtml += '-';
        }

        document.getElementById('quality_images_container').innerHTML = imagesHtml;
    });
}
function fetchImages_cmplt(id, callback) {

    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };
    $.ajax({
        url: '/getImages_completeqlty', // Your API endpoint to fetch images
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

function viewQualityResults()
{
    //alert('yes');

    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };
    var formData = {po:document.querySelector('[name="process_order_number_qlty"]').value};
   


    $.ajax({
        type: "POST",
        url: "/getQualityCompleteDataByProcessOrder",
        data: formData,
        headers: headers,
        dataType: "json",
       
        success: function (response) {
            console.log(response);
            displayQualityResultss(response);
            
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });
}

function displayQualityResultss(values) {
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
console.log(values.data.process_order_number);
    fetchImages_cmplt(values.data.process_order_number, function(images) {
        //alert('yes');
        var imagesHtml = '';
        if (images && images.length > 0) {
            images.forEach(function(imageUrl) {
                console.log(imageUrl)
                imagesHtml += '<div style="display: inline-block; margin-right: 10px;">';
                imagesHtml += '<a href="/storage/images_qlty_complete/' + values.data.process_order_number.trim() + '/' + values.data.uuid + '/' + imageUrl + '" download>';
                imagesHtml += '<img src="/storage/images_qlty_complete/' + values.data.process_order_number.trim() + '/' + values.data.uuid + '/' + imageUrl + '" style="max-width: 50px; max-height: 50px;"></a></div>';
            });
        } else {
            imagesHtml += '-';
        }

        document.getElementById('quality_images_container').innerHTML = imagesHtml;
    });
}
function fetchImages_cmplt(id, callback) {

    var headers = {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    };
    $.ajax({
        url: '/getImages_completeqlty', // Your API endpoint to fetch images
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
