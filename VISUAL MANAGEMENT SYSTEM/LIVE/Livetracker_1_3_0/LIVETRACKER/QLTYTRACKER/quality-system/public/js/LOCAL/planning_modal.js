

function generatePlanningFieldTable(processOrder, qualityStep) {
    console.log(processOrder);



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
        url: '/getPlanningDataByProcessOrder',
        type: 'POST',
        data: formData,
        headers: headers,
        dataType: 'json',
        success: function (response) {

            console.log(response);
            $.each(response, function () {
                $.each(this, function (key, val) {
                    if (key == 'purchase_order_received') {

                        console.log(val);

                        // $(".nav-second-level")

                        //.append('<li value="' + Product_item + '"><a href="#"><span class="tab">' + Product_item + '</span></a> <ul class="nav-third-level" style="overflow-y:scroll"></ul></li>');

                    }


                });
            });
            var generatedHTML = generateHTMLFromResponse_for_planning(response);

            // Append the generated HTML to a container (replace 'yourContainerId' with your actual container ID)
            $('#planningFieldTable').html(generatedHTML);
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

function generateHTMLFromResponse_for_planning_old(response) {
    // You can customize this function to generate HTML based on the response data
    // For example, you can iterate through the data and create table rows
    var html = '<table id=common_table>';
    html += '<thead><tr><th>id</th><th>purchase_order_received</th><th>purchase_order_document</th><th>project_schedule_agreed</th><th>project_schedule_document</th><th>quotation</th><th>quotation_document</th><th>verify_customer_expectations</th><th>user_requirement_specifications_document</th><th>project_risk_category_assessment</th><th>pre_engineering_check_document</th><th>sign_off_planning</th><th>comments_planning</th></tr></thead><tbody>'; // Replace with actual column names


    $.each(response, function (index, item) {
        html += '<tr>';
        html += '<td>' + item.id + '</td>'; // Access 'id' property of each item
        html += '<td>' + (item.purchase_order_received === 'true' ? '✔' : '') + '</td>'; // Show tick if 'reference_job_master_file' is 'on'
        if (item.purchase_order_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/planning_task/' + item.process_order_number + '/' + item.purchase_order_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'reference_job_master_file_document' is empty
        }

        html += '<td>' + (item.project_schedule_agreed === 'true' ? '✔' : '') + '</td>'; // Show tick if 'reference_job_master_file' is 'on'
        if (item.project_schedule_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/planning_task/' + item.process_order_number + '/' + item.project_schedule_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'reference_job_master_file_document' is empty
        }
        html += '<td>' + (item.quotation === 'true' ? '✔' : '') + '</td>';

        if (item.quotation_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/planning_task/' + item.process_order_number + '/' + item.quotation_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'reference_job_master_file_document' is empty
        }


        html += '<td>' + (item.verify_customer_expectations === 'true' ? '✔' : '') + '</td>';

        if (item.user_requirement_specifications_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/planning_task/' + item.process_order_number + '/' + item.user_requirement_specifications_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'reference_job_master_file_document' is empty
        }

        html += '<td>' + (item.project_risk_category_assessment === 'true' ? '✔' : '') + '</td>';

        if (item.pre_engineering_check_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/planning_task/' + item.process_order_number + '/' + item.pre_engineering_check_document;
            var downloadLink = '<a href="' + filePath + '" download>Download File</a>';
            html += '<td>' + downloadLink + '</td>';
        } else {
            html += '<td></td>'; // Empty cell if 'reference_job_master_file_document' is empty
        }
        html += '<td>' + (item.sign_off_planning ? item.sign_off_planning : '') + '</td>';
        html += '<td>' + (item.comments_planning ? item.comments_planning : '') + '</td>';

        // Include other columns as needed
        html += '</tr>';
    });

    html += '</tbody></table>';

    return html;
}



function generateHTMLFromResponse_for_planning(response) {
    var html = '<form id="PlanningForm" class="planning-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">Engineering</legend>';

    // Start table
    html += '<table style="width: 100%; border-collapse: collapse;">';

    // Iterate through each item in the response array
    $.each(response, function (index, item) {
        html += '<tr>';

        // Purchase Order Received
        // Purchase Order Received
            html += '<td style="border: 1px solid #ccc;">';
            html += '<input type="checkbox" id="purchase_order_received_' + index + '" name="purchase_order_received_' + index + '" ' 
                + (item.purchase_order_received === 'true' ? 'checked class="no-pointer-events"' : '') 
                + '>';
                html += '<label for="purchase_order_received_' + index + '" class="' + (item.purchase_order_received === 'true' ? 'no-pointer-events' : '') + '">Purchase Order Received</label>';
                html += '</td>';

        // Purchase Order Document
        html += '<td style=" border: 1px solid #ccc;">';
        html += '<label for="purchase_order_document_' + index + '">Purchase Order Document:</label><br>';
        if (item.purchase_order_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/planning_task/' + item.process_order_number + '/' + item.purchase_order_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">' + item.purchase_order_document + '</a>';
            html += downloadLink;
        } else {
            html += 'No file uploaded';
        }
        html += '</td>';

        // Owner for Purchase Order
        html += '<td id="ownerp_1" style="border: 1px solid #ccc; ">';
        html += '</td>';
        html += '<td id="ndtap_1" style="border: 1px solid #ccc; ">';
        html += '</td>';



        fetchOwnerData_Planning_1(item.process_order_number, 'Purchase Order received', 0,function (ownerData_Planning) {
            console.log('i am inside '.ownerData_Planning);
            if (ownerData_Planning) {
                alert('yes');
                alert(ownerData_Planning.owner);
                // Update owner cell
                document.getElementById('ownerp_1').innerHTML = ownerData_Planning.owner;

                // Update ndta cell
                document.getElementById('ndtap_1').innerHTML = ownerData_Planning.ndta;
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('ownerp_1').innerHTML = 'N/A';
                document.getElementById('ndtap_1').innerHTML = 'N/A';
            }
        });


        html += '</tr>'; // End of Purchase Order row

        // Project Schedule Agreed
        html += '<tr>';

        html += '<td style=" border: 1px solid #ccc;">';
        html += '<input type="checkbox" id="project_schedule_agreed_' + index + '" name="project_schedule_agreed_' + index + '" ' + (item.project_schedule_agreed === '1' ? 'checked' : '') + '>';
        html += '<label for="project_schedule_agreed_' + index + '">Project Schedule Agreed</label>';
        html += '</td>';

        html += '<td style=" border: 1px solid #ccc;">';
        html += '<label for="project_schedule_document_' + index + '">Project Schedule Document:</label><br>';
        if (item.project_schedule_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/planning_task/' + item.process_order_number + '/' + item.project_schedule_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">' + item.project_schedule_document + '</a>';
            html += downloadLink;
        } else {
            html += 'No file uploaded';
        }
        html += '</td>';

        html += '<td id="ownerp_2" style="border: 1px solid #ccc; ">';
        html += '</td>';
        html += '<td id="ndtap_2"style="border: 1px solid #ccc; ">';
        html += '</td>';



        fetchOwnerData_Planning_2(item.process_order_number, 'Project schedule agreed', 1,function (ownerData_Planning) {
            if (ownerData_Planning) {
                // Update owner cell
                document.getElementById('ownerp_2').innerHTML = ownerData_Planning.owner;

                // Update ndta cell
                document.getElementById('ndtap_2').innerHTML = ownerData_Planning.ndta;
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('ownerp_2').innerHTML = 'N/A';
                document.getElementById('ndtap_2').innerHTML = 'N/A';
            }
        });
        html += '</tr>'; // End of Project Schedule Agreed row

        // Quotation
        html += '<tr>';

        html += '<td style=" border: 1px solid #ccc;">';
        html += '<input type="checkbox" id="quotation_' + index + '" name="quotation_' + index + '" ' + (item.quotation === 'true' ? 'checked' : '') + '>';
        html += '<label for="quotation_' + index + '">Quotation</label>';
        html += '</td>';

        html += '<td style=" border: 1px solid #ccc;">';
        html += '<label for="quotation_document_' + index + '">Quotation Document:</label><br>';
        if (item.quotation_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/planning_task/' + item.process_order_number + '/' + item.quotation_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">' + item.quotation_document + '</a>';
            html += downloadLink;
        } else {
            html += 'No file uploaded';
        }
        html += '</td>';

        html += '<td id="ownerp_3"style="border: 1px solid #ccc; ">';
        html += '</td>';
        html += '<td id="ndtap_3"style="border: 1px solid #ccc; ">';
        html += '</td>';



        fetchOwnerData_Planning_3(item.process_order_number, 'Quotation',2, function (ownerData_Planning) {
            if (ownerData_Planning) {
                // Update owner cell
                document.getElementById('ownerp_3').innerHTML = ownerData_Planning.owner;

                // Update ndta cell
                document.getElementById('ndtap_3').innerHTML = ownerData_Planning.ndta;
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('ownerp_3').innerHTML = 'N/A';
                document.getElementById('ndtap_3').innerHTML = 'N/A';
            }
        });

        html += '</tr>'; // End of Quotation row

        // Verify Customer Expectations
        html += '<tr>';

        html += '<td style=" border: 1px solid #ccc;">';
        html += '<input type="checkbox" id="verify_customer_expectations_' + index + '" name="verify_customer_expectations_' + index + '" ' + (item.verify_customer_expectations === 'true' ? 'checked' : '') + '>';
        html += '<label for="verify_customer_expectations_' + index + '">Verify Customer Expectations</label>';
        html += '</td>';

        html += '<td style=" border: 1px solid #ccc;">';
        html += '<label for="user_requirement_specifications_document_' + index + '">User Requirement Specifications Document:</label><br>';
        if (item.user_requirement_specifications_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/planning_task/' + item.process_order_number + '/' + item.user_requirement_specifications_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">' + item.user_requirement_specifications_document + '</a>';
            html += downloadLink;
        } else {
            html += 'No file uploaded';
        }
        html += '</td>';

        html += '<td id="ownerp_4"style="border: 1px solid #ccc; ">';
        html += '</td>';
        html += '<td id="ndtap_4"style="border: 1px solid #ccc; ">';
        html += '</td>';



        fetchOwnerData_Planning_4(item.process_order_number, 'Verify customer expectations', 3,function (ownerData_Planning) {
            if (ownerData_Planning) {
                // Update owner cell
                document.getElementById('ownerp_4').innerHTML = ownerData_Planning.owner;

                // Update ndta cell
                document.getElementById('ndtap_4').innerHTML = ownerData_Planning.ndta;
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('ownerp_4').innerHTML = 'N/A';
                document.getElementById('ndtap_4').innerHTML = 'N/A';
            }
        });
        html += '</tr>'; // End of Verify Customer Expectations row

        // Project Risk Category Assessment
        html += '<tr>';

        html += '<td style="border: 1px solid #ccc;">';
        html += '<input type="checkbox" id="project_risk_category_assessment_' + index + '" name="project_risk_category_assessment_' + index + '" ' + (item.project_risk_category_assessment === 'true' ? 'checked' : '') + '>';
        html += '<label for="project_risk_category_assessment_' + index + '">Project Risk Category Assessment</label>';
        html += '</td>';

        html += '<td style=" border: 1px solid #ccc;">';
        html += '<label for="risk_assessment_document_' + index + '">Risk Assessment Document:</label><br>';
        if (item.risk_assessment_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/planning_task/' + item.process_order_number + '/' + item.risk_assessment_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">' + item.risk_assessment_document + '</a>';
            html += downloadLink;
        } else {
            html += 'No file uploaded';
        }
        html += '</td>';



        html += '</td>';

        html += '<td id="ownerp_5" style="border: 1px solid #ccc; ">';
        html += '</td>';
        html += '<td id="ndtap_5"style="border: 1px solid #ccc; ">';
        html += '</td>';



        fetchOwnerData_Planning_5(item.process_order_number, 'Project risk category assessment',4, function (ownerData) {
            if (ownerData) {
                // Update owner cell
                document.getElementById('ownerp_5').innerHTML = ownerData.owner;

                // Update ndta cell
                document.getElementById('ndtap_5').innerHTML = ownerData.ndta;
            } else {
                // Handle case where no owner data is retrieved
                document.getElementById('ownerp_5').innerHTML = 'N/A';
                document.getElementById('ndtap_5').innerHTML = 'N/A';
            }
        });

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
        html += '</tr>';// End of Project Risk Category Assessment row

    });

    // Close table
    html += '</table>';

    // Submit button and form closing tags
    html += '<div class="form-group" style="margin-top: 20px;">';
    html += '<button type="submit">Submit Planning Form</button>';
    html += '</div>';

    html += '</fieldset></form>';

    return html;
}

function fetchOwnerData_Planning_1(id, Type, index,callback) {

    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Replace with the actual CSRF token
        // Include other headers if needed
    };
    var formData = {
        process_order_number: id,
        Type: Type
    };

    $.ajax({
        url: '/getOwnerData_Planning',
        type: 'POST',
        data: formData,
        headers: headers,
        dataType: 'json',
        success: function (responses) {

            console.log(responses.data[0].owner);
            console.log(index);
           callback(responses.data[0]);
       
          // document.getElementById("owner_1").innerHTML = responses.data[0].owner;
            

        },
        error: function (error) {
            // Handle the error response if needed
            console.error(error);
        }
    });

}
    function fetchOwnerData_Planning_2(id, Type, index,callback) {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Replace with the actual CSRF token
            // Include other headers if needed
        };
        var formData = {
            process_order_number: id,
            Type: Type
        };
    $.ajax({
        url: '/getOwnerData_Planning',
        type: 'POST',
        data: formData,
        headers: headers,
        dataType: 'json',
        success: function (responses) {

            console.log(responses);
            console.log(index);
            callback(responses.data[0]);
          
            

        },
        error: function (error) {
            // Handle the error response if needed
            console.error(error);
        }
    });
    }
    function fetchOwnerData_Planning_3(id, Type, index,callback) {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Replace with the actual CSRF token
            // Include other headers if needed
        };
        var formData = {
            process_order_number: id,
            Type: Type
        };
    $.ajax({
        url: '/getOwnerData_Planning',
        type: 'POST',
        data: formData,
        headers: headers,
        dataType: 'json',
        success: function (responses) {

            console.log(responses);
            console.log(index);
            callback(responses.data[0]);
          
            

        },
        error: function (error) {
            // Handle the error response if needed
            console.error(error);
        }
    });
    }

    function fetchOwnerData_Planning_4(id, Type, index,callback) {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Replace with the actual CSRF token
            // Include other headers if needed
        };
        var formData = {
            process_order_number: id,
            Type: Type
        };
    $.ajax({
        url: '/getOwnerData_Planning',
        type: 'POST',
        data: formData,
        headers: headers,
        dataType: 'json',
        success: function (responses) {

            console.log(responses);
            console.log(index);
            callback(responses.data[0]);
          
            

        },
        error: function (error) {
            // Handle the error response if needed
            console.error(error);
        }
    });


}


function fetchOwnerData_Planning_5(id, Type, index,callback) {

    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Replace with the actual CSRF token
        // Include other headers if needed
    };
    var formData = {
        process_order_number: id,
        Type: Type
    };
$.ajax({
    url: '/getOwnerData_Planning',
    type: 'POST',
    data: formData,
    headers: headers,
    dataType: 'json',
    success: function (responses) {

        console.log(responses);
        console.log(index);
        callback(responses.data[0]);
      
        

    },
    error: function (error) {
        // Handle the error response if needed
        console.error(error);
    }
});

}
/* function generateHTMLFromResponse_for_planning(response) {
    // You can customize this function to generate HTML based on the response data
    // For example, you can iterate through the data and create form fields
  
    var html = '<form id="planningForm" class="planning-form" style="font-family: Arial, sans-serif; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">';
    html += '<fieldset style="margin-bottom: 20px;">';
    html += '<legend style="font-size: 20px; font-weight: bold; margin-bottom: 10px;"> Planning / Forward Engineering</legend>';
    html+='<div style="width:97%">';
    $.each(response, function (index, item) {
        html += '<div class="form-group" style="margin-bottom: 15px;">';
        html += '<label for="purchase_order_received_' + index + '" style="">Purchase Order Received:</label>';
        html += '<input type="checkbox" id="purchase_order_received_' + index + '" name="purchase_order_received"' + (item.purchase_order_received === 'true' ? 'on' : '') + '" ' + (item.purchase_order_received === 'true' ? 'checked' : 'disabled') + '>';
        html += '</div>';

        html += '<div class="form-group" style="margin-bottom: 15px;">';
        html += '<label for="purchase_order_document_' + index + '" style="">Purchase Order Document:</label>';
        if (item.purchase_order_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/planning_task/' + item.process_order_number + '/' + item.purchase_order_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">' + item.purchase_order_document + '</a>';
            html += downloadLink;
        } else {
            html += 'No file uploaded';
        }
        html += '</div>';

        html += '<div class="form-group" style="margin-bottom: 15px;">';
        html += '<label for="project_schedule_agreed_' + index + '" style="">Project Schedule Agreed:</label>';
        html += '<input type="checkbox" id="project_schedule_agreed_' + index + '" name="project_schedule_agreed"' + (item.project_schedule_agreed === '1' ? 'on' : '') + '" ' + (item.project_schedule_agreed === '1' ? 'checked' : 'disabled') + '>';
        html += '</div>';

        html += '<div class="form-group" style="margin-bottom: 15px;">';
        html += '<label for="project_schedule_document_' + index + '" style="">Project Schedule Document:</label>';
        if (item.project_schedule_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/planning_task/' + item.process_order_number + '/' + item.project_schedule_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">' + item.project_schedule_document + '</a>';
            html += downloadLink;
        } else {
            html += 'No file uploaded';
        }
        html += '</div>';

        html += '<div class="form-group" style="margin-bottom: 15px;">';
        html += '<label for="quotation_' + index + '" style="">Quotation:</label>';
        html += '<input type="checkbox" id="quotation_' + index + '" name="quotation"' + (item.quotation === 'true' ? 'on' : '') + '" ' + (item.quotation === 'true' ? 'checked' : 'disabled') + '>';
        html += '</div>';

        html += '<div class="form-group" style="margin-bottom: 15px;">';
        html += '<label for="quotation_document_' + index + '" style="">Quotation Document:</label>';
        if (item.quotation_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/planning_task/' + item.process_order_number + '/' + item.quotation_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">' + item.quotation_document + '</a>';
            html += downloadLink;
        } else {
            html += 'No file uploaded';
        }
        html += '</div>';

        html += '<div class="form-group" style="margin-bottom: 15px;">';
        html += '<label for="verify_customer_expectations_' + index + '" style="">Verify Customer Expectations:</label>';
        html += '<input type="checkbox" id="verify_customer_expectations_' + index + '" name="verify_customer_expectations"' + (item.verify_customer_expectations === 'true' ? 'on' : '') + '" ' + (item.verify_customer_expectations === 'true' ? 'checked' : 'disabled') + '>';
        html += '</div>';

        html += '<div class="form-group" style="margin-bottom: 15px;">';
        html += '<label for="user_requirement_specifications_document_' + index + '" style="">User Requirement Specifications Document:</label>';
        if (item.user_requirement_specifications_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/planning_task/' + item.process_order_number + '/' + item.user_requirement_specifications_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">' + item.user_requirement_specifications_document + '</a>';
            html += downloadLink;
        } else {
            html += 'No file uploaded';
        }
        html += '</div>';

        html += '<div class="form-group" style="margin-bottom: 15px;">';
        html += '<label for="project_risk_category_assessment_' + index + '" style="">Project Risk Category Assessment:</label>';
        html += '<input type="checkbox" id="project_risk_category_assessment_' + index + '" name="project_risk_category_assessment"' + (item.project_risk_category_assessment === 'true' ? 'on' : '') + '" ' + (item.project_risk_category_assessment === 'true' ? 'checked' : 'disabled') + '>';
        html += '</div>';

        html += '<div class="form-group" style="margin-bottom: 15px;">';
        html += '<label for="pre_engineering_check_document_' + index + '" style="">Pre Engineering Check Document:</label>';
        if (item.pre_engineering_check_document) {
            var filePath = 'http://vms/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/QLTYTRACKER/quality-system/storage/app/public/planning_task/' + item.process_order_number + '/' + item.pre_engineering_check_document;
            var downloadLink = '<a href="' + filePath + '" target="_blank">' + item.pre_engineering_check_document + '</a>';
            html += downloadLink;
        } else {
            html += 'No file uploaded';
        }
        html += '</div>';

        html += '<div class="form-group" style="margin-bottom: 15px;">';
        html += '<label for="sign_off_planning_' + index + '" style="">Sign-off for Planning / Forward Engineering:</label>';
        html += '<input style="width:100%"type="text" id="sign_off_planning_' + index + '" name="sign_off_planning" value="' + (item.sign_off_planning ? item.sign_off_planning : '') + '">';
        html += '</div>';

        html += '<div class="form-group" style="margin-bottom: 15px;">';
        html += '<label for="comments_planning_' + index + '" style="">Comments for Planning / Forward Engineering:</label>';
        html += '<textarea style="width:100%"id="comments_planning_' + index + '" name="comments_planning" rows="4" cols="50">' + (item.comments_planning ? item.comments_planning : '') + '</textarea>';
        html += '</div>';
    });

    html += '<div class="form-group" style="margin-top: 20px;">';
  
    html += '</div>';
    html+='</div>';

    html += '</fieldset></form>';

    return html;
} */













function submitPlanningForm() {
    // Add your logic to handle the form submission for the engineering fieldset

    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    };
    function getFileName(inputName) {
        var fileInput = document.querySelector('[name="' + inputName + '"]');
        return fileInput.files.length > 0 ? fileInput.files[0].name : null;
    }

    var owners = [];
    document.querySelectorAll('#planning tbody tr').forEach(function (row, index) {
        if (index >= 0) { // Skip the header row
            owners.push({
                type: row.cells[0].innerText.trim(),
                owner: row.querySelector('[name="owner"]').value || null,
                ndt: row.querySelector('[name="ndttype"]').value || null
            });
        }
    });
    console.log(owners);
    const sign_off_planning = document.querySelector('[name="sign_off_planning"]').value;
    var formData = {
        purchase_order_received: document.querySelector('[name="purchase_order_received"]')?.checked || null,
        project_schedule_agreed: document.querySelector('[name="project_schedule_agreed"]')?.checked || null,

        quotation: document.querySelector('[name="quotation"]')?.checked || null,
        verify_customer_expectations: document.querySelector('[name="verify_customer_expectations"]')?.checked || null,
        project_risk_category_assessment: document.querySelector('[name="project_risk_category_assessment"]')?.checked || null,

        purchase_order_document: (document.querySelector('[name="purchase_order_document"]').files.length > 0)
            ? document.querySelector('[name="purchase_order_document"]').files[0].name
            : document.getElementById('purchase_order_filename').textContent.trim(),
        project_schedule_document: (document.querySelector('[name="project_schedule_document"]').files.length > 0)
            ? document.querySelector('[name="project_schedule_document"]').files[0].name
            : document.getElementById('project_schedule_filename').textContent.trim(),
        user_requirement_specifications_document: (document.querySelector('[name="user_requirement_specifications_document"]').files.length > 0)
            ? document.querySelector('[name="user_requirement_specifications_document"]').files[0].name
            : document.getElementById('user_requirements_filename').textContent.trim(),
        pre_engineering_check_document: (document.querySelector('[name="pre_engineering_check_document"]').files.length > 0)
            ? document.querySelector('[name="pre_engineering_check_document"]').files[0].name
            : document.getElementById('pre_engineering_filename').textContent.trim(),
        quotation_document: (document.querySelector('[name="quotation_document"]').files.length > 0)
            ? document.querySelector('[name="quotation_document"]').files[0].name
            : document.getElementById('quotation_filename').textContent.trim(),
        sign_off_planning: document.querySelector('[name="sign_off_planning"]').value || null,
        comments_planning: document.querySelector('[name="comments_planning"]').value || null,
        // Get today's date in YYYY-MM-DD format
        process_order_number: document.querySelector('[name="process_order_number_planning"]').value || null,
        owners: owners
        // Add other form fields accordingly
    };



    console.log(formData);

    // Send an AJAX request to the server
    $.ajax({
        url: '/submitPlanningForm',
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
    console.log(document.getElementById('process_order_number_planning').value);
    // Add process_order_number to FormData
    fileData.append('process_order_number', document.getElementById('process_order_number_planning').value);

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
        url: '/handleFileUploadPlanning',  // Update to your actual route
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

    // console.log('Planning form submitted!');
}
function generatePlanningUpdateFieldTable(processOrder, qualityStep) {

    // Assuming you have some custom headers to include
    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Replace with the actual CSRF token
        // Include other headers if needed
    };
    var html = '<table id="update_table">';
    html += '<thead><tr><th>Field</th><th>Value</th></tr></thead><tbody>';
    var formData = {
        process_order_number: processOrder,
        // Include other data if needed
    };
    console.log(processOrder);


    // Fetch Planning Form Data for the given process order
    $.ajax({
        url: '/getPlanningDataByProcessOrder',// Adjust URL as needed
        type: 'POST',
        headers: headers,
        data: formData,
        dataType: 'json',
        success: function (response) {
            console.log(response);
            // Clear the loading indicator
            //$('#update_table tbody').html('');
            var generatedHTML = generateEditableFormFromResponse(response);
            $('#planningUpdateFieldTable').html(generatedHTML);
            // Populate the update table with fetched data

        },
        error: function (error) {
            console.error(error);

        }
    });


}
function generateEditableFormFromResponse(response) {
    var html = '<form id="editableForm" enctype="multipart/form-data">';

    $.each(response, function (index, item) {
        html += '<div class="form-group" >';
        html += '<label>ID: </label>';
        html += '<input type="text" name="id" value="' + item.id + '" readonly>';
        html += '</div>';

        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Purchase Order Received: </label>';
        html += '<input type="checkbox" name="purchase_order_received" ' + (item.purchase_order_received === 'true' ? 'checked' : '') + '>';
        html += '</div>';

        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Purchase Order Document: </label>';
        if (item.purchase_order_document) {
            html += '<input type="text" name="existing_purchase_order_document" value="' + item.purchase_order_document + '" readonly>';
            html += '<input type="file" name="purchase_order_document_new">';
        } else {
            html += '<input type="file" name="purchase_order_document">';
        }
        html += '</div>';

        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Project Schedule Agreed: </label>';
        html += '<input type="checkbox" name="project_schedule_agreed" ' + (item.project_schedule_agreed === 'true' ? 'checked' : '') + '>';
        html += '</div>';

        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Project Schedule Document: </label>';
        if (item.project_schedule_document) {
            html += '<input type="text" name="existing_project_schedule_document" value="' + item.project_schedule_document + '" readonly>';
            html += '<input type="file" name="project_schedule_document_new">';
        } else {
            html += '<input type="file" name="project_schedule_document">';
        }
        html += '</div>';

        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Quotation: </label>';
        html += '<input type="checkbox" name="quotation" ' + (item.quotation === 'true' ? 'checked' : '') + '>';
        html += '</div>';

        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Quotation Document: </label>';
        if (item.quotation_document) {
            html += '<input type="text" name="existing_quotation_document" value="' + item.quotation_document + '" readonly>';
            html += '<input type="file" name="quotation_document_new">';
        } else {
            html += '<input type="file" name="quotation_document">';
        }
        html += '</div>';

        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Verify Customer Expectations: </label>';
        html += '<input type="checkbox" name="verify_customer_expectations" ' + (item.verify_customer_expectations === 'true' ? 'checked' : '') + '>';
        html += '</div>';

        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>User Requirement Specifications Document: </label>';
        if (item.user_requirement_specifications_document) {
            html += '<input type="text" name="existing_user_requirement_specifications_document" value="' + item.user_requirement_specifications_document + '" readonly>';
            html += '<input type="file" name="user_requirement_specifications_document_new">';
        } else {
            html += '<input type="file" name="user_requirement_specifications_document">';
        }
        html += '</div>';

        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Project Risk Category Assessment: </label>';
        html += '<input type="checkbox" name="project_risk_category_assessment" ' + (item.project_risk_category_assessment === 'true' ? 'checked' : '') + '>';
        html += '</div>';

        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Pre Engineering Check Document: </label>';
        if (item.pre_engineering_check_document) {
            html += '<input type="text" name="existing_pre_engineering_check_document" value="' + item.pre_engineering_check_document + '" readonly>';
            html += '<input type="file" name="pre_engineering_check_document_new">';
        } else {
            html += '<input type="file" name="pre_engineering_check_document">';
        }
        html += '</div>';

        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Sign-off Planning: </label>';
        html += '<input type="text" name="sign_off_planning" value="' + (item.sign_off_planning ? item.sign_off_planning : '') + '">';
        html += '</div>';

        html += '<div class="form-group" style="text-align: left; padding: 5px;">';
        html += '<label>Comments Planning: </label>';
        html += '<textarea name="comments_planning">' + (item.comments_planning ? item.comments_planning : '') + '</textarea>';
        html += '</div>';
    });

    html += '<div class="form-group" style="text-align: center; padding: 10px;">';
    html += '<button type="submit" style="background-color: #007bff; color: #fff; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px;">Submit</button>';
    html += '</div>';

    html += '</form>';

    return html;
}



$(document).on('submit', '#updatePlanningForm', function (e) {
    e.preventDefault(); // Prevent default form submission

    var formData = new FormData(this);

    // Make an AJAX call to submit the updated planning form
    $.ajax({
        url: '/submitPlanningForm',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            alert('Update successful');
            // You can perform additional actions after successful update
        },
        error: function (error) {
            console.error(error);
            alert('Update failed');
            // Handle error
        }
    });
});

function resetPlanningForm() {
    // Uncheck checkboxes
    $('#purchase_order_received').prop('checked', false);
    $('#project_schedule_agreed').prop('checked', false);
    $('#quotation').prop('checked', false);
    $('#verify_customer_expectations').prop('checked', false);
    $('#project_risk_category_assessment').prop('checked', false);

    // Clear text inputs
    $('#sign_off_planning').val('');
    $('#comments_planning').val('');

    // Reset file input values
    $('#purchase_order_filename').text('');
    $('#project_schedule_filename').text('');
    $('#quotation_filename').text('');
    $('#user_requirements_filename').text('');
    $('#pre_engineering_filename').text('');

    // Reset file input values
    $('#purchase_order_document').val('');
    $('#project_schedule_document').val('');
    $('#quotation_document').val('');
    $('#user_requirement_specifications_document').val('');
    $('#pre_engineering_check_document').val('');
    $('#planningFieldset').show();
}
function Planning(processOrder, userName) {
    console.log('planning');
    console.log(userName);
    $('#planningFieldset').hide();
    $('#qualityFieldset').hide();

    $('#manufacturingFieldset').hide();
    $('#planningFieldset').show();
    $('#sign_off_planning').val(userName);
    $('#process_order_number_planning').val(processOrder);

    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // Add other headers if needed
    };

    var formData = {
        process_order_number: processOrder
        // Add other form data if needed
    };

    // Fetch Planning Form Data for the given process order
    $.ajax({
        url: '/getPlanningDataByProcessOrder', // Adjust URL as needed
        type: 'POST',
        headers: headers,
        data: formData,
        dataType: 'json',
        success: function (response) {
            resetPlanningForm();
            $('#sign_off_planning').val(userName);
            $('#process_order_number_planning').val(processOrder);

            console.log(response);
            if (response.data != null) {
                console.log('yes po found');
                $.each(response, function (index, item) {
                    $('#process_order_number_planning').val(processOrder);
                    $('input[name="purchase_order_received"]').prop('checked', item
                        .purchase_order_received === 'true');
                    $('input[name="project_schedule_agreed"]').prop('checked', parseInt(item
                        .project_schedule_agreed) === 1);
                    $('input[name="quotation"]').prop('checked', item.quotation === 'true');
                    $('input[name="verify_customer_expectations"]').prop('checked', item
                        .verify_customer_expectations === 'true');
                    $('input[name="project_risk_category_assessment"]').prop('checked', item
                        .project_risk_category_assessment === 'true');

                    // Other fields
                    $('#sign_off_planning').val(userName);
                    $('#comments_planning').val(item.comments_planning);

                    // File input fields
                    $('#purchase_order_filename').text(item.purchase_order_document);
                    $('#project_schedule_filename').text(item.project_schedule_document);
                    $('#quotation_filename').text(item.quotation_document);
                    $('#user_requirements_filename').text(item
                        .user_requirement_specifications_document);
                    $('#pre_engineering_filename').text(item
                        .pre_engineering_check_document);

                    // Set the labels for file inputs
                    $('#purchase_order_file_label').show();
                    $('#project_schedule_file_label').show();
                    $('#quotation_file_label').show();
                    $('#user_requirements_file_label').show();
                    $('#pre_engineering_file_label').show();

                    // Attach handlers for file input changes
                    $('#purchase_order_document').change(function () {
                        $('#purchase_order_filename').text(this.files[0].name);

                    });

                    $('#project_schedule_document').change(function () {
                        $('#project_schedule_filename').text(this.files[0].name);
                    });

                    $('#quotation_document').change(function () {
                        $('#quotation_filename').text(this.files[0].name);
                    });

                    $('#user_requirement_specifications_document').change(function () {
                        $('#user_requirements_filename').text(this.files[0].name);
                    });

                    $('#pre_engineering_check_document').change(function () {
                        $('#pre_engineering_filename').text(this.files[0].name);
                    });
                });
            } else {

                resetPlanningForm();
                $('#sign_off_planning').val(userName);
                $('#planningFieldset').show();
                $('#process_order_number_planning').val(processOrder);
            }

        },
        error: function (error) {
            console.error(error);
        }
    });
}