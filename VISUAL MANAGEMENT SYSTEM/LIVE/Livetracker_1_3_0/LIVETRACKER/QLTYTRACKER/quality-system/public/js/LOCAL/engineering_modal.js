

function generateEngineeringFieldTable(processOrder, qualityStep) {
    console.log(processOrder);


    // Assuming you have the process order number in a variable
    var processOrderNumber = "123"; // Replace with the actual process order number

    // Assuming you have some custom headers to include
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Replace with the actual CSRF token
        // Include other headers if needed
    };

    // Assuming you have some data to send in the request
    var formData = {
        process_order_number: processOrder,
        // Include other data if needed
    };

    $.ajax({
        url: '/getEngineerDataByProcessOrder',
        type: 'POST',
        data: formData,
        headers: headers,
        dataType: 'json',
        success: function (response) {

            console.log(response);
            //USe this for testing
           /*  $.each(response, function () {
                $.each(this, function (key, val) {
                    if (key == 'reference_job_master_file') {

                        console.log(val);

                        // $(".nav-second-level")

                        //.append('<li value="' + Product_item + '"><a href="#"><span class="tab">' + Product_item + '</span></a> <ul class="nav-third-level" style="overflow-y:scroll"></ul></li>');

                    }


                });
            }); */
            var generatedHTML = generateHTMLFromResponse_for_eng(response);

            // Append the generated HTML to a container (replace 'yourContainerId' with your actual container ID)
            $('#engineeringFieldTable').html(generatedHTML);
        },
        error: function (error) {
            // Handle the error response if needed
            console.error(error);
        }
    });

    return `
            <div>To be Done</div>
        `;
}

/* function generateHTMLFromResponse_for_eng(response) {
    var html = '<form id="EngineerinForm" class="planning-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Engineering</legend>';
    
    $.each(response, function (index, item) {
        html+='<div style="width:97%">';
        html += '<div class="form-group" >';
       // html += '<label>ID: </label>';
       // html += '<input type="text" name="id" value="' + item.id + '" readonly>';
       
        html += '</div>';
        
        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Reference Job/Master File: </label>';
        html += '<input type="checkbox" name="reference_job_master_file" ' + (item.reference_job_master_file === 'true' ? 'checked' : 'disabled') +  '>';
        html += '</div>';
        
        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Reference Job/Master File Document: </label>';
        if (item.reference_job_master_file_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/engineer_task/' + item.process_order_number + '/' + item.reference_job_master_file_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.reference_job_master_file_document+'</a>';
           // html += '<input type="text" name="existing_reference_job_master_file_document" value="' + item.reference_job_master_file_document + '" readonly>';
            //html += '<input type="file" name="reference_job_master_file_document_new">';
            html += downloadLink;
        } else {
            //html += '<input type="file" name="reference_job_master_file_document">';
        }
        html += '</div>';
        
        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Concept Design & Engineering: </label>';
        html += '<input type="checkbox" name="concept_design_engineering" ' + (item.concept_design_engineering === 'true' ? 'checked' : 'disabled') + '>';
        html += '</div>';
        
        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Concept Design Document: </label>';
        if (item.concept_design_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/engineer_task/' + item.process_order_number + '/' + item.concept_design_document;
            var downloadLink = '<a href="' + filePath + '" download>'+item.concept_design_document+'</a>';
           // html += '<input type="text" name="existing_concept_design_document" value="' + item.concept_design_document + '" readonly>';
            //html += '<input type="file" name="concept_design_document_new">';
            html += downloadLink;
        } else {
            //html += '<input type="file" name="concept_design_document">';
        }
        html += '</div>';

        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Design Sign off [calculations]: </label>';
        html += '<input type="checkbox" name="design_validation_sign_off" ' + (item.design_validation_sign_off === 'true' ? 'checked' : 'disabled') + '>';
        html += '</div>';

        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Design Validation Document: </label>';
        if (item.design_validation_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/engineer_task/' + item.process_order_number + '/' + item.design_validation_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.design_validation_document+'</a>';
           // html += '<input type="text" name="existing_design_validation_document" value="' + item.design_validation_document + '" readonly>';
           // html += '<input type="file" name="design_validation_document_new">';
            html += downloadLink;
        } else {
            //html += '<input type="file" name="design_validation_document">';
        }
        html += '</div>';

        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Customer Submittal Package: </label>';
        html += '<input type="checkbox" name="customer_submittal_package" ' + (item.customer_submittal_package === 'true' ? 'checked' : 'disabled') + '>';
        html += '</div>';

        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Customer Approval Document: </label>';
        if (item.customer_approval_document) {
            var filePath = 'http://localhost/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYUPLOADS/engineer_task/' + item.process_order_number + '/' + item.customer_approval_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.customer_approval_document+'</a>';
            //html += '<input type="text" name="existing_customer_approval_document" value="' + item.customer_approval_document + '" readonly>';
           // html += '<input type="file" name="customer_approval_document_new">';
            html += downloadLink;
        } else {
            //html += '<input type="file" name="customer_approval_document">';
        }
        html += '</div>';

        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Reference Approved Samples: </label>';
        html += '<input type="checkbox" name="reference_approved_samples" ' + (item.reference_approved_samples === 'true' ? 'checked' : 'disabled') + '>';
        html += '</div>';

        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Sample Approval Document: </label>';
        if (item.sample_approval_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/engineer_task/' + item.process_order_number + '/' + item.sample_approval_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.sample_approval_document+'</a>';
            //html += '<input type="text" name="existing_sample_approval_document" value="' + item.sample_approval_document + '" readonly>';
           // html += '<input type="file" name="sample_approval_document_new">';
            html += downloadLink;
        } else {
            //html += '<input type="file" name="sample_approval_document">';
        }
        html += '</div>';

        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Sign-off for Engineering: </label>';
        html += '<input style="width:100%"type="text" name="sign_off_engineering" value="' + (item.sign_off_engineering ? item.sign_off_engineering : '') + '">';
        html += '</div>';

        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Comments for Engineering: </label>';
        html += '<textarea style="width:100%"name="comments_engineering">' + (item.comments_engineering ? item.comments_engineering : '') + '</textarea>';
        html += '</div>';
    });
    
    html += '<div class="form-group" style="margin-top: 20px;">';
  
    html += '</div>';
    html+='</div>';
    html += '</fieldset></form>';

    return html;
}
 */
function generateHTMLFromResponse_for_eng(response) {

    
    var html = '<form id="EngineerinForm" class="planning-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Engineering</legend>';

    // Start table
    html += '<table style="width: 100%; border-collapse: collapse;">';

    // Iterate over each item in the response
    $.each(response, function (index, item) {
        // Start a new row for each item
       
       

        

        // Reference Job/Master File
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
       
        html += '<input type="checkbox" name="reference_job_master_file" ' + (item.reference_job_master_file === 'true' ? 'checked' : 'disabled') + '>';
        html +='Reference Job/Master Fil';
        html += '</td>';

        // Reference Job/Master File Document
        html += '<td style="border: 1px solid #ccc; ">Reference Job/Master File Document</strong>';
       
        if (item.reference_job_master_file_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/engineer_task/' + item.process_order_number + '/' + item.reference_job_master_file_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.reference_job_master_file_document+'</a>';
            html += downloadLink;
        }
        html += '<td id="owner_eng1"colspan="2" style="border: 1px solid #ccc; ">';
        html+='</td>';
        html += '<td id="ndta_eng1"colspan="2" style="border: 1px solid #ccc; ">';
        html+='</td>';



        fetchOwnerData_eng(item.process_order_number, 'Reference Job / Master File if applicable', function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('owner_eng1').innerHTML =  ownerData.owner;

                // Update ndta cell
                document.getElementById('ndta_eng1').innerHTML = ownerData.ndta;
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('owner_eng1').innerHTML = 'N/A';
                document.getElementById('ndta_eng1').innerHTML = ' N/A';
            }
        });


        // Close the row
        html += '</tr>';

        // Concept Design & Engineering
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
       
        html += '<input type="checkbox" name="concept_design_engineering" ' + (item.concept_design_engineering === 'true' ? 'checked' : 'disabled') + '>';
        html+='Concept Design & Engineering';
        html += '</td>';

     

        // Concept Design Document
      
        html += '<td style="border: 1px solid #ccc; ">Concept Design Document</strong>';
      
        if (item.concept_design_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/engineer_task/' + item.process_order_number + '/' + item.concept_design_document;
            var downloadLink = '<a href="' + filePath + '" download>'+item.concept_design_document+'</a>';
            html += downloadLink;
        }
        html += '<td id="owner_eng5"colspan="2" style="border: 1px solid #ccc; ">';
        html+='</td>';
        html += '<td id="ndta_eng5"colspan="2" style="border: 1px solid #ccc; ">';
        html+='</td>';



        fetchOwnerData_eng(item.process_order_number, 'Concept design & engineering details', function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('owner_eng5').innerHTML =  ownerData.owner;

                // Update ndta cell
                document.getElementById('ndta_eng5').innerHTML = ownerData.ndta;
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('owner_eng5' ).innerHTML = 'N/A';
                document.getElementById('ndta_eng5' ).innerHTML = ' N/A';
            }
        });
        // Close the row
        html += '</tr>';

        // Design Sign off [calculations]
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
       
        html += '<input type="checkbox" name="design_validation_sign_off" ' + (item.design_validation_sign_off === 'true' ? 'checked' : 'disabled') + '>';
        html+='Design Sign off [calculations]';
        html += '</td>';

      

        // Design Validation Document
     
        html += '<td style="border: 1px solid #ccc; ">Design Validation Document</>';
       
        if (item.design_validation_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/engineer_task/' + item.process_order_number + '/' + item.design_validation_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.design_validation_document+'</a>';
            html += downloadLink;
        }
        html += '<td id="owner_eng6"colspan="2" style="border: 1px solid #ccc; ">';
        html+='</td>';
        html += '<td id="ndta_eng6"colspan="2" style="border: 1px solid #ccc; ">';
        html+='</td>';



        fetchOwnerData_eng(item.process_order_number, 'Design sign off [calculations]', function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('owner_eng6').innerHTML =  ownerData.owner;

                // Update ndta cell
                document.getElementById('ndta_eng6').innerHTML = ownerData.ndta;
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('owner_eng6' + index).innerHTML = 'N/A';
                document.getElementById('ndta_eng6' + index).innerHTML = ' N/A';
            }
        });
        // Close the row
        html += '</tr>';

        // Customer Submittal Package
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc;">';
       
        html += '<input type="checkbox" name="customer_submittal_package" ' + (item.customer_submittal_package === 'true' ? 'checked' : 'disabled') + '>';
        html+='Customer Submittal Package';
        html += '</td>';

        // Close the row
       

        // Customer Approval Document
      
        html += '<td style="border: 1px solid #ccc; ">Customer Approval Document</>';
      
        if (item.customer_approval_document) {
            var filePath = 'http://localhost/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYUPLOADS/engineer_task/' + item.process_order_number + '/' + item.customer_approval_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.customer_approval_document+'</a>';
            html += downloadLink;
        }
        html += '<td id="owner_eng3"colspan="2" style="border: 1px solid #ccc; ">';
        html+='</td>';
        html += '<td id="ndta_eng3"colspan="2" style="border: 1px solid #ccc; ">';
        html+='</td>';



        fetchOwnerData_eng(item.process_order_number, 'Customer submittal package', function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('owner_eng3').innerHTML =  ownerData.owner;

                // Update ndta cell
                document.getElementById('ndta_eng3').innerHTML = ownerData.ndta;
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('owner_eng3' ).innerHTML = 'N/A';
                document.getElementById('ndta_eng3' ).innerHTML = ' N/A';
            }
        });
html+='</tr>';
        // Reference Approved Samples
    
        html += '<td style="border: 1px solid #ccc;">';
     
        html += '<input type="checkbox" name="reference_approved_samples" ' + (item.reference_approved_samples === 'true' ? 'checked' : 'disabled') + '>';
        html += 'Reference Approved Samples';

        html += '</td>';

        // Close the row
      

        // Sample Approval Document
    
        html += '<td style="border: 1px solid #ccc;">Sample Approval Document</>';
      
        if (item.sample_approval_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/engineer_task/' + item.process_order_number + '/' + item.sample_approval_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">'+item.sample_approval_document+'</a>';
            html += downloadLink;
        }
        html += '<td id="owner_eng4"colspan="2" style="border: 1px solid #ccc; ">';
        html+='</td>';
        html += '<td id="ndta_eng4"colspan="2" style="border: 1px solid #ccc; ">';
        html+='</td>';



        fetchOwnerData_eng(item.process_order_number, 'Reference approved samples', function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('owner_eng4').innerHTML =  ownerData.owner;

                // Update ndta cell
                document.getElementById('ndta_eng4').innerHTML = ownerData.ndta;
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('owner_eng4' ).innerHTML = 'N/A';
                document.getElementById('ndta_eng4' ).innerHTML = ' N/A';
            }
        });
        // Close the row
        html += '</tr>';

        // Sign-off for Engineering
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc; ">Sign-off for Engineering</>';
        html += '<td colspan="5" style="border: 1px solid #ccc; ">';
        html += '<input style="width: 100%;" type="text" name="sign_off_engineering" value="' + (item.sign_off_engineering ? item.sign_off_engineering : '') + '">';
        html += '</td>';
       
        // Close the row
        html += '</tr>';

        // Comments for Engineering
        html += '<tr style="border: 1px solid #ccc;">';
        html += '<td style="border: 1px solid #ccc; ">Comments for Engineering</></td>';
        html += '<td colspan="5" style="border: 1px solid #ccc; padding: 10px;">';
        html += '<textarea style="width: 100%;" name="comments_engineering">' + (item.comments_engineering ? item.comments_engineering : '') + '</textarea>';
        html += '</td>';

        // Close the row
        html += '</tr>';
    });

    // Close table
    html += '</table>';

    // Submit button
    html += '<div class="form-group" style="margin-top: 20px; text-align: center;">';
  
    html += '</div>';

    html += '</fieldset></form>';

    return html;
}


function fetchOwnerData_eng(id,Type,callback)
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
    url: '/getOwnerData',
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
/* function generateHTMLFromResponse_for_eng(response) {
    var html = '<table id="common_table">';
    html += '<thead><tr><th>ID</th><th>Reference_Job / Master_File</th><th>Reference_Job / Master_File_Document</th><th>Concept_Design</th><th>Concept_Design_Document</th><th>Design_Validation</th><th>Design_Validation_Document</th><th>Customer_Approval</th><th>Customer_Approval_Document</th><th>Sample_Approval</th><th>Sample_Approval_Document</th><th>Sign_off_Engineering</th><th>Comments_Engineering</th></tr></thead><tbody>';

    $.each(response, function (index, item) {
        html += '<tr>';
        html += '<td>' + item.id + '</td>'; // Access 'id' property of each item
        html += '<td>' + (item.reference_job_master_file === 'true' ? '✔' : '') + '</td>'; // Show tick if 'reference_job_master_file' is 'true'
        if (item.reference_job_master_file_document) {
            var filePath = 'storage/engineer_task/' + item.process_order_number + '/' + item.reference_job_master_file_document;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'reference_job_master_file_document' is empty
        }

        html += '<td>' + (item.concept_design_engineering === 'true' ? '✔' : '') + '</td>'; // Show tick if 'concept_design_engineering' is 'true'
        if (item.concept_design_document) {
            var filePath = 'storage/engineer_task/' + item.process_order_number + '/' + item.concept_design_document;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'concept_design_document' is empty
        }

        html += '<td>' + (item.design_validation_sign_off === 'true' ? '✔' : '') + '</td>'; // Show tick if 'design_validation_sign_off' is 'true'
        if (item.design_validation_document) {
            var filePath = 'storage/engineer_task/' + item.process_order_number + '/' + item.design_validation_document;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'design_validation_document' is empty
        }

        html += '<td>' + (item.customer_approval === 'true' ? '✔' : '') + '</td>'; // Show tick if 'customer_approval' is 'true'
        if (item.customer_approval_document) {
            var filePath = 'storage/engineer_task/' + item.process_order_number + '/' + item.customer_approval_document;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'customer_approval_document' is empty
        }

        html += '<td>' + (item.reference_approved_samples === 'true' ? '✔' : '') + '</td>'; // Show tick if 'reference_approved_samples' is 'true'
        if (item.sample_approval_document) {
            var filePath = 'storage/engineer_task/' + item.process_order_number + '/' + item.sample_approval_document;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'sample_approval_document' is empty
        }

        html += '<td>' + (item.sign_off_engineering ? item.sign_off_engineering : '') + '</td>';
        html += '<td>' + (item.comments_engineering ? item. comments_engineering: '') + '</td>'; // Display sign-off info or empty if not available

        html += '</tr>';
    });

    html += '</tbody></table>';

    return html;
} */





function generateEngineeringFieldset(processOrder, qualityStep,username) {

   console.log('username from modal',username);
   $('#sign_off_engineering').val(username);
    return `
           
    


           
    `;
}

function submitEngineeringForm(processOrder) {
    // Add your logic to handle the form submission for the engineering fieldset
  
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };
    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }
    const sign_off_engineering = document.querySelector('[name="sign_off_engineering"]').value;
    var owners = [];
    document.querySelectorAll('#engineering tbody tr').forEach(function (row, index) {
        if (index >=0) { // Skip the header row
            owners.push({
                type: row.cells[0].innerText.trim(),
                owner: row.querySelector('[name="owner_eng"]').value || null,
                ndt: row.querySelector('[name="ndttype_eng"]').value || null
            });
        }
    });
console.log(owners);
    var formData = {
        reference_job_master_file: document.querySelector('[name="reference_job_master_file"]').checked || null,
        concept_design_engineering: document.querySelector('[name="concept_design_engineering"]').checked || null,
        design_validation_sign_off: document.querySelector('[name="design_validation_sign_off"]').checked || null,
        customer_submittal_package: document.querySelector('[name="customer_submittal_package"]').checked || null,
        reference_approved_samples: document.querySelector('[name="reference_approved_samples"]').checked || null,
       
        reference_job_master_file_document: (document.querySelector('[name="reference_job_master_file_document"]').files.length > 0)
        ? document.querySelector('[name="reference_job_master_file_document"]').files[0].name
        : document.getElementById('reference_job_master_file_document_filename').textContent.trim(), 
        concept_design_document: (document.querySelector('[name="concept_design_document"]').files.length > 0)
            ? document.querySelector('[name="concept_design_document"]').files[0].name
            : document.getElementById('concept_design_document_filename').textContent.trim(), // Check if element exists and not empty
        customer_approval_document: (document.querySelector('[name="customer_approval_document"]').files.length > 0)
            ? document.querySelector('[name="customer_approval_document"]').files[0].name
            :  document.getElementById('customer_approval_document_filename').textContent.trim(), 
        design_validation_document: (document.querySelector('[name="design_validation_document"]').files.length > 0)
            ? document.querySelector('[name="design_validation_document"]').files[0].name
            : document.getElementById('design_validation_document_filename').textContent.trim(),
        sample_approval_document: (document.querySelector('[name="sample_approval_document"]').files.length > 0)
            ? document.querySelector('[name="sample_approval_document"]').files[0].name
            : document.getElementById('sample_approval_document_filename').textContent.trim(),
    


           
        sign_off_engineering: sign_off_engineering,
        comments_engineering: document.querySelector('[name="comments_engineering"]').value || null,
        submission_date: new Date().toISOString().split('T')[0],  // Get today's date in YYYY-MM-DD format
        process_order_number: (document.querySelector('[name="process_order_number_engineering"]').value.trim() !== "")
    ? document.querySelector('[name="process_order_number_engineering"]').value.trim()
    : null,
        // Add other form fields accordingly
        owners:owners,
    };
    
    
    console.log(formData);

    // Send an AJAX request to the server
    $.ajax({
        url: '/submitEngineeringForm',
        type: 'POST',
        data: formData,
        headers: headers,
        success: function (response) {
            // Handle the success response if needed

            console.log(response);
            alert('success')
            $('#myModal').hide();
            // location.reload();
            updateTable(response);
            function updateTable(response) {
                // Assuming your table has an ID, update the table rows dynamically
                var newRow = '<tr><td>' + response.name + '</td><td>' + response.path + '</td></tr>';
                $('#yourTableId tbody').append(newRow);
            }
        },
        error: function (error) {
            // Handle the error response if needed
            console.error(error);
        }
    });
    // File uploads
    // File uploads
    var fileData = new FormData();
    var fileInputs = $('[type="file"]');

    // Add process_order_number to FormData
    fileData.append('process_order_number', document.querySelector('[name="process_order_number_engineering"]').value.trim());

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
        url: '/handleFileUploadEngineer',  // Update to your actual route
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

    console.log('Engineering form submitted!');
}
/* function generateEngineeringFieldset(processOrder, qualityStep,username) {
    console.log('username from modal',username);
    $('#sign_off_engineering').val(username);
     return `
            
     <fieldset>
     <legend>Main Task 2: Engineering</legend>
 
     <!-- Subtask 2.1: Reference Job / Master File -->
     <div class="form-group">
         <label>
         <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <input type="checkbox" name="reference_job_master_file">
             Reference Job / Master File if applicable
         </label>
         <br>
         <label class="upload-label">
             Upload Document:
             <input type="file" name="reference_job_master_file_document">
         </label>
     </div>
     
     <!-- Subtask 2.2: Concept Design -->
     <div class="form-group">
         <label>
             <input type="checkbox" name="concept_design_engineering">
             Concept design & engineering details
         </label>
         <br>
         <label class="upload-label">
             Upload Concept Design Document:
             <input type="file" name="concept_design_document">
         </label>
     </div>
 
     <!-- Subtask 2.3: Design Validation -->
     <div class="form-group">
         <label>
             <input type="checkbox" name="design_validation_sign_off">
             Design sign off [calculations]
         </label>
         <br>
         <label class="upload-label">
             Upload Design Validation Document:
             <input type="file" name="design_validation_document">
         </label>
     </div>
 
     <!-- Subtask 2.4: Customer Approval -->
     <div class="form-group">
         <label>
             <input type="checkbox" name="customer_submittal_package">
             Customer submittal package
         </label>
         <br>
         <label class="upload-label">
             Upload Customer Approval Document:
             <input type="file" name="customer_approval_document">
         </label>
     </div>
 
     <!-- Subtask 2.5: Sample Approval -->
     <div class="form-group">
         <label>
             <input type="checkbox" name="reference_approved_samples">
             Reference approved samples
         </label>
         <br>
         <label class="upload-label">
             Upload Sample Approval Document:
             <input type="file" name="sample_approval_document">
         </label>
     </div>
 
     <!-- Sign-off for Main Task 2 -->
     <div class="form-group">
         <label>
             Sign-off for Engineering:
             <input type="text" name="sign_off_engineering"value="${username}">
     </div>
 
     <!-- Comments for Main Task 2 -->
     <div class="form-group">
         <label>
             Comments for Engineering:
             <textarea name="comments_engineering" rows="4" cols="50"></textarea>
         </label>
     </div>
 
     <!-- Submit button -->
     <button type="submit" onclick="submitEngineeringForm('${processOrder}')">Submit Engineering Form</button>
 </fieldset>
 
 
            
     `;
 } */

 function resetEngineeringForm() {
    // Uncheck checkboxes
    $('#reference_job_master_file').prop('checked', false);
    $('#concept_design_engineering').prop('checked', false);
    $('#design_validation_sign_off').prop('checked', false);
    $('#customer_submittal_package').prop('checked', false);
    $('#reference_approved_samples').prop('checked', false);

    // Clear text inputs
    $('#sign_off_engineering').val('');
    $('#comments_engineering').val('');
    $('#process_order_number_engineering').val('');

    // Reset file input values and filenames
    $('#reference_job_master_file_document_filename').text('');
    $('#concept_design_document_filename').text('');
    $('#design_validation_document_filename').text('');
    $('#customer_approval_document_filename').text('');
    $('#sample_approval_document_filename').text('');

    $('#reference_job_master_file_document').val('');
    $('#concept_design_document').val('');
    $('#design_validation_document').val('');
    $('#customer_approval_document').val('');
    $('#sample_approval_document').val('');
    $('select[name="owner_eng"]').val('NULL');
    $('select[name="ndttype_eng"]').val('NULL');
    // Show the engineering form section if it was hidden
    $('#engineeringFieldset').show();
}

function Engineering(processOrder, userName) {
    console.log('engineering');
    console.log(userName);
    $('#planningFieldset').hide();
    $('#qualityFieldset').hide();
    $('#manufacturingFieldset').hide();
    $('#engineeringFieldset').hide();
    $('#engineeringFieldset').show();
    $('#sign_off_engineering').val(userName);
    $('#process_order_number_engineering').val(processOrder);

    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // Add other headers if needed
    };

    var formData = {
        process_order_number: processOrder
        // Add other form data if needed
    };

    // Fetch Engineering Form Data for the given process order
    $.ajax({
        url: '/getEngineerDataByProcessOrder', // Adjust URL as needed
        type: 'POST',
        headers: headers,
        data: formData,
        dataType: 'json',
        success: function(response) {
            resetEngineeringForm();

            console.log(userName);
            $('#sign_off_engineering').val(userName);
            $('#process_order_number_engineering').val(processOrder);
            if (response.data != null) {
                console.log('yes po found');
                console.log(response);
                $.each(response, function(index, item) {

                    console.log(item.process_order_number);
                    $('#process_order_number_engineering').val(item.process_order_number);

                    $('input[name="reference_job_master_file"]').prop('checked', item
                        .reference_job_master_file === 'true');



                        fetchOwnerData_eng(processOrder, 'Reference Job / Master File if applicable', function (ownerData) {
                            if (ownerData) {
                                // Update owner cell
                                $(`select[name="owner_eng"][data-task="reference_job_master_file"]`).val(ownerData.owner.trim());
                                // Update NDT cell
                                $(`select[name="ndttype_eng"][data-task="reference_job_master_file"]`).val(ownerData.ndta.trim());
                            } else {
                                // Handle case where no owner data is retrieved
                                $(`select[name="owner_eng"][data-task="reference_job_master_file"]`).val('NULL');
                                $(`select[name="ndttype_eng"][data-task="reference_job_master_file"]`).val('NULL');
                            }
                        });
                    $('input[name="concept_design_engineering"]').prop('checked', item
                        .concept_design_engineering === 'true');


                        fetchOwnerData_eng(processOrder, 'Concept design & engineering details', function (ownerData) {
                            if (ownerData) {
                                // Update owner cell
                                $(`select[name="owner_eng"][data-task="concept_design_engineering"]`).val(ownerData.owner.trim());
                                // Update NDT cell
                                $(`select[name="ndttype_eng"][data-task="concept_design_engineering"]`).val(ownerData.ndta.trim());
                            } else {
                                // Handle case where no owner data is retrieved
                                $(`select[name="owner_eng"][data-task="concept_design_engineering"]`).val('NULL');
                                $(`select[name="ndttype_eng"][data-task="concept_design_engineering"]`).val('NULL');
                            }
                        });
                    $('input[name="design_validation_sign_off"]').prop('checked', item
                        .design_validation_sign_off === 'true');



                        fetchOwnerData_eng(processOrder, 'Design sign off [calculations]', function (ownerData) {
                            if (ownerData) {
                                // Update owner cell
                                $(`select[name="owner_eng"][data-task="design_validation_sign_off"]`).val(ownerData.owner.trim());
                                // Update NDT cell
                                $(`select[name="ndttype_eng"][data-task="design_validation_sign_off"]`).val(ownerData.ndta.trim());
                            } else {
                                // Handle case where no owner data is retrieved
                                $(`select[name="owner_eng"][data-task="design_validation_sign_off"]`).val('NULL');
                                $(`select[name="ndttype_eng"][data-task="design_validation_sign_off"]`).val('NULL');
                            }
                        });
                    $('input[name="customer_submittal_package"]').prop('checked', item
                        .customer_submittal_package === 'true');


                        fetchOwnerData_eng(processOrder, 'Customer submittal package', function (ownerData) {
                            if (ownerData) {
                                // Update owner cell
                                $(`select[name="owner_eng"][data-task="customer_submittal_package"]`).val(ownerData.owner.trim());
                                // Update NDT cell
                                $(`select[name="ndttype_eng"][data-task="customer_submittal_package"]`).val(ownerData.ndta.trim());
                            } else {
                                // Handle case where no owner data is retrieved
                                $(`select[name="owner_eng"][data-task="customer_submittal_package"]`).val('NULL');
                                $(`select[name="ndttype_eng"][data-task="customer_submittal_package"]`).val('NULL');
                            }
                        });
                    $('input[name="reference_approved_samples"]').prop('checked', item
                        .reference_approved_samples === 'true');



                        fetchOwnerData_eng(processOrder, 'Reference approved samples', function (ownerData) {
                            if (ownerData) {
                                // Update owner cell
                                $(`select[name="owner_eng"][data-task="reference_approved_samples"]`).val(ownerData.owner.trim());
                                // Update NDT cell
                                $(`select[name="ndttype_eng"][data-task="reference_approved_samples"]`).val(ownerData.ndta.trim());
                            } else {
                                // Handle case where no owner data is retrieved
                                $(`select[name="owner_eng"][data-task="reference_approved_samples"]`).val('NULL');
                                $(`select[name="ndttype_eng"][data-task="reference_approved_samples"]`).val('NULL');
                            }
                        });

                    // Other fields
                    $('#sign_off_engineering').val(userName);
                    $('#comments_engineering').val(item.comments_engineering);

                    // File input fieldsfetc
                    $('#reference_job_master_file_document_filename').text(item
                        .reference_job_master_file_document);
                    $('#concept_design_document_filename').text(item.concept_design_document);
                    $('#design_validation_document_filename').text(item
                        .design_validation_document);
                    $('#customer_approval_document_filename').text(item
                        .customer_approval_document);
                    $('#sample_approval_document_filename').text(item.sample_approval_document);

                    // Set the labels for file inputs
                    $('#reference_job_master_file_document_file_label').show();
                    $('#concept_design_document_file_label').show();
                    $('#design_validation_document_file_label').show();
                    $('#customer_approval_document_file_label').show();
                    $('#sample_approval_document_file_label').show();

                    // Attach handlers for file input changes
                    $('#reference_job_master_file_document').change(function() {
                        $('#reference_job_master_file_document_filename').text(this.files[0].name);
                    });

                    $('#concept_design_document').change(function() {
                        $('#concept_design_document_filename').text(this.files[0].name);
                    });

                    $('#design_validation_document').change(function() {
                        $('#design_validation_document_filename').text(this.files[0].name);
                    });

                    $('#customer_approval_document').change(function() {
                        $('#customer_approval_document_filename').text(this.files[0].name);
                    });

                    $('#sample_approval_document').change(function() {
                        $('#sample_approval_document_filename').text(this.files[0].name);
                    });
                });
            } else {
                resetEngineeringForm();
                
                $('#process_order_number_engineering').val(processOrder);
                $('#sign_off_engineering').val(userName);
                $('#engineeringFieldset').show();
            }



            
        },
        error: function(error) {
            console.error(error);
        }
    });
}
