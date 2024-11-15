<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Planning / Forward Engineering</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse; 
            font-size:13px;
        }
        td {
             padding: 10px;
        }
        .form-group {
        display: flex; 
            align-items: center;
        }
        .form-group input[type="checkbox"] {
            margin-right: 10px;
        }
        .form-group label {
            flex: 1;


        }
        tr,td
        {
        border: 1px solid black;
        }
td {
    padding: 10px;
    text-align: left; /* Align content to the left */
}
        
    </style>
</head>
<body>
   
  
        
        <div style="width:98%">
        <table>
            <tr>
                <td>Process Order Number:</td>
                <td colspan="3">
                    <input style="width:100%" type="text" name="process_order_number_planning" id="process_order_number_planning" readonly>
                </td>
            </tr>
    </td>
    </table>
    <table id="planning">
        <thead>
            <tr>
            <th>Tasks</th>
                        <th>Files </th>
                        <th>Owner</th>
                        <th>Action</th>
    
    </tr>
    </thead>
            <tr>
                <td class="form-group">
                    <input type="checkbox" name="purchase_order_received" id="purchase_order_received">
                    Purchase Order received
                </td>
                <td>
                   
                        Current Purchase Order Document: 
                        <span id="purchase_order_filename"></span>
                        <input type="file" name="purchase_order_document" id="purchase_order_document">
                        <button type="button" onclick="clear_purchase_order_document()">Clear File</button>
                   
                </td>
                <td>
                            <select name="owner_plan" id="owner" style="width:100%"data-task="purchase_order_received">
                                <option value="NULL">Select Owner</option>
                                <option value="PM">PM</option>
                                <option value="QA">QA</option>
                                <option value="Planning">Planning</option>
                                <option value="Operator">Operator</option>
                                <option value="Kitting">Kitting</option>
                                <option value="Fabricator">Fabricator</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="RWC">RWC</option>
                                <option value="Goods In">Goods In</option>
                                <option value="Goods Out">Goods Out</option>
                                <option value="Client">Client</option>





                                
                            </select>
                        </td>
                        <td>
                      
                            <select name="ndttype_plan" id="ndttype" style="width:100%"data-task="purchase_order_received">
                                <option value="NULL">Select Action</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <option value="Hold">Hold</option>
                            
                            
                            </select>
                        </td>
            </tr>
            <tr>
                <td class="form-group">
                    <input type="checkbox" name="project_schedule_agreed" id="project_schedule_agreed">
                    <label>Project schedule agreed</label>
                </td>
                <td>
                
                        Current Project Schedule Document: <br>
                        <span id="project_schedule_filename"></span>
                        <input type="file" name="project_schedule_document" id="project_schedule_document">
                        <button type="button" onclick="clear_project_schedule_document()">Clear File</button>
                  
                </td>
                <td>
                            <select name="owner_plan" id="owner" style="width:100%"data-task="project_schedule_agreed">
                                <option value="NULL">Select Owner</option>
                                <option value="PM">PM</option>
                                <option value="QA">QA</option>
                                <option value="Planning">Planning</option>
                                <option value="Operator">Operator</option>
                                <option value="Kitting">Kitting</option>
                                <option value="Fabricator">Fabricator</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="RWC">RWC</option>
                                <option value="Goods In">Goods In</option>
                                <option value="Goods Out">Goods Out</option>
                                <option value="Client">Client</option>





                                
                            </select>
                        </td>
                        <td>
                      
                            <select name="ndttype_plan" id="ndttype" style="width:100%"data-task="project_schedule_agreed">
                                <option value="NULL">Select Action</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <option value="Hold">Hold</option>
                            
                            
                            </select>
                        </td>
            </tr>
            
            <tr>
                <td class="form-group">
                    <input type="checkbox" name="quotation" id="quotation">
                    <label>Quotation</label>
                </td>
                <td>
                    
                        Current Quotation Document: <br>
                        <span id="quotation_filename"></span>
                        <input type="file" name="quotation_document" id="quotation_document">
                        <button type="button" onclick="clear_quotation_document()">Clear File</button>
                   
                </td>
                <td>
                            <select name="owner_plan" id="owner" style="width:100%"data-task="quotation">
                                <option value="NULL">Select Owner</option>
                                <option value="PM">PM</option>
                                <option value="QA">QA</option>
                                <option value="Planning">Planning</option>
                                <option value="Operator">Operator</option>
                                <option value="Kitting">Kitting</option>
                                <option value="Fabricator">Fabricator</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="RWC">RWC</option>
                                <option value="Goods In">Goods In</option>
                                <option value="Goods Out">Goods Out</option>
                                <option value="Client">Client</option>





                                
                            </select>
                        </td>
                        <td>
                      
                            <select name="ndttype_plan" id="ndttype" style="width:100%"data-task="quotation">
                                <option value="NULL">Select Action</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <option value="Hold">Hold</option>
                            
                            
                            </select>
                        </td>
            </tr>
            <tr>
                <td class="form-group">
                    <input type="checkbox" name="verify_customer_expectations" id="verify_customer_expectations">
                    <label>Verify customer expectations</label>
                </td>
                <td>
                   
                        Current User Requirement Specifications Document: <br>
                            <span id="user_requirements_filename"></span>
                        <input type="file" name="user_requirement_specifications_document" id="user_requirement_specifications_document">
                        <button type="button" onclick="clear_user_requirement_specifications_document()">Clear File</button>
                    
                </td>
                <td>
                            <select name="owner_plan" id="owner" style="width:100%"data-task="verify_customer_expectations">
                                <option value="NULL">Select Owner</option>
                                <option value="PM">PM</option>
                                <option value="QA">QA</option>
                                <option value="Planning">Planning</option>
                                <option value="Operator">Operator</option>
                                <option value="Kitting">Kitting</option>
                                <option value="Fabricator">Fabricator</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="RWC">RWC</option>
                                <option value="Goods In">Goods In</option>
                                <option value="Goods Out">Goods Out</option>
                                <option value="Client">Client</option>





                                
                            </select>
                        </td>
                        <td>
                      
                            <select name="ndttype_plan" id="ndttype" style="width:100%"data-task="verify_customer_expectations">
                                <option value="NULL">Select Action</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <option value="Hold">Hold</option>
                            
                            
                            </select>
                        </td>
            </tr>
            <tr>
                <td class="form-group">
                    <input type="checkbox" name="project_risk_category_assessment" id="project_risk_category_assessment">
                    <label>Project risk category assessment</label>
                </td>
                <td>
                  
                        Current Pre Engineering Check Document: <br>
                        <span id="pre_engineering_filename"></span>
                        <input type="file" name="pre_engineering_check_document" id="pre_engineering_check_document">
                        <button type="button" onclick="clear_pre_engineering_check_document()">Clear File</button>
                   
                </td>
                <td>
                            <select name="owner_plan" id="owner" style="width:100%"data-task="project_risk_category_assessment">
                                <option value="NULL">Select Owner</option>
                                <option value="PM">PM</option>
                                <option value="QA">QA</option>
                                <option value="Planning">Planning</option>
                                <option value="Operator">Operator</option>
                                <option value="Kitting">Kitting</option>
                                <option value="Fabricator">Fabricator</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="RWC">RWC</option>
                                <option value="Goods In">Goods In</option>
                                <option value="Goods Out">Goods Out</option>
                                <option value="Client">Client</option>





                                
                            </select>
                        </td>
                        <td>
                      
                            <select name="ndttype_plan" id="ndttype" style="width:100%"data-task="project_risk_category_assessment">
                                <option value="NULL">Select Action</option>
                                <option value="Approve">Approve</option>
                                <option value="Inspect">Inspect</option>
                                <option value="Review">Review</option>
                                <option value="Record">Record</option>
                                <option value="Hold">Hold</option>
                            
                            
                            </select>
                        </td>
            </tr>
        </table>
        <div class="form-group">
            <label>Sign-off for Planning / Forward Engineering:
                <input style="width:100%" type="text" name="sign_off_planning" id="sign_off_planning">
            </label>
        </div>
        <div class="form-group">
            <label>Comments for Planning / Forward Engineering:
                <textarea style="width:100%" name="comments_planning" id="comments_planning" rows="4" cols="50"></textarea>
            </label>
        </div>
        <div>
            <button type="submit" onclick="submitPlanningForm()">Submit Planning Form</button>
        </div>
            </div>
  

    <script>
        function clear_purchase_order_document() {

            const processOrderNumber = document.getElementById('process_order_number_planning').value;
        const fileName = document.getElementById('purchase_order_filename').textContent; // Changed to textContent
        
        const tablename = "PlanningFormData";
        const filetype = "purchase_order_document";


        const foldername="planning_task";
        if (processOrderNumber && fileName) {
            $.ajax({
                url: "{{ url('clear-file') }}/" + processOrderNumber,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    file_name: fileName,
                    tablename: tablename,
                    filetype: filetype,
                    foldername:foldername
                },
                success: function(response) {
                    alert("File cleared successfully!");
                    document.getElementById('purchase_order_document').value = ''; // Clear the file input field
                    document.getElementById('purchase_order_filename').textContent = '';
                },
                error: function(xhr) {
                    alert("Error clearing file: " + xhr.responseText);
                    console.error(xhr); // Log the full error for debugging
                }
            });
        } else {
            if (!fileName)
              //  document.getElementById('technical_file').value = '';
           // document.getElementById('old_technical_file').textContent = '';
            //alert('Please enter a valid Process Order Number and file name.');
       // }
           // document.getElementById('customer_approval_document').value = ''; // Clear the file input field
           // document.getElementById('customer_approval_document_filename').textContent = ''; // Clear the filename display
        //}
   // }

       
        


            document.getElementById('purchase_order_document').value = ''; // Clear the file input field
            document.getElementById('purchase_order_filename').textContent = ''; // Clear the filename display
        }
        }

        function clear_project_schedule_document() {




          //  document.getElementById('project_schedule_document').value = ''; // Clear the file input field
          //  document.getElementById('project_schedule_filename').textContent = ''; 
           // 
            
            
            const processOrderNumber = document.getElementById('process_order_number_planning').value;
        const fileName = document.getElementById('project_schedule_filename').textContent; // Changed to textContent
        const tablename = "PlanningFormData";
        const filetype = "project_schedule_document";


        const foldername="planning_task";
        if (processOrderNumber && fileName) {
            $.ajax({
                url: "{{ url('clear-file') }}/" + processOrderNumber,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    file_name: fileName,
                    tablename: tablename,
                    filetype: filetype,
                    foldername:foldername
                },
                success: function(response) {
                    alert("File cleared successfully!");
                    document.getElementById('project_schedule_document').value = ''; // Clear the file input field
                    document.getElementById('project_schedule_filename').textContent = ''; 
                },
                error: function(xhr) {
                    alert("Error clearing file: " + xhr.responseText);
                    console.error(xhr); // Log the full error for debugging
                }
            });
        } else {
            if (!fileName)
              //  document.getElementById('technical_file').value = '';
           // document.getElementById('old_technical_file').textContent = '';
            //alert('Please enter a valid Process Order Number and file name.');
       // }
           // document.getElementById('customer_approval_document').value = ''; // Clear the file input field
           // document.getElementById('customer_approval_document_filename').textContent = ''; // Clear the filename display
        //}
   // }

       
        


   document.getElementById('project_schedule_document').value = ''; // Clear the file input field
   document.getElementById('project_schedule_filename').textContent = ''; 
        }
            
            
            
            
            // Clear the filename display
        }

        function clear_quotation_document() {
          //  document.getElementById('quotation_document').value = ''; // Clear the file input field
        //    document.getElementById('quotation_filename').textContent = ''; // Clear the filename display
//

            const processOrderNumber = document.getElementById('process_order_number_planning').value;
        const fileName = document.getElementById('quotation_filename').textContent; // Changed to textContent

        const tablename = "PlanningFormData";
        const filetype = "quotation_document";

        const foldername="planning_task";

        if (processOrderNumber && fileName) {
            $.ajax({
                url: "{{ url('clear-file') }}/" + processOrderNumber,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    file_name: fileName,
                    tablename: tablename,
                    filetype: filetype,
                    foldername:foldername
                },
                success: function(response) {
                    alert("File cleared successfully!");
                    document.getElementById('quotation_document').value = ''; // Clear the file input field
                    document.getElementById('quotation_filename').textContent = ''; // Clear the filename display
                },
                error: function(xhr) {
                    alert("Error clearing file: " + xhr.responseText);
                    console.error(xhr); // Log the full error for debugging
                }
            });
        } else {
            if (!fileName)
              //  document.getElementById('technical_file').value = '';
           // document.getElementById('old_technical_file').textContent = '';
            //alert('Please enter a valid Process Order Number and file name.');
       // }
           // document.getElementById('customer_approval_document').value = ''; // Clear the file input field
           // document.getElementById('customer_approval_document_filename').textContent = ''; // Clear the filename display
        //}
   // }

       
        


   document.getElementById('quotation_document').value = ''; // Clear the file input field
   document.getElementById('quotation_filename').textContent = ''; // Clear the filename display



        }
    }
        function clear_user_requirement_specifications_document() {
            const processOrderNumber = document.getElementById('process_order_number_planning').value;
        const fileName = document.getElementById('user_requirements_filename').textContent; // Changed to textContent
        const tablename = "PlanningFormData";
        const filetype = "user_requirement_specifications_document";
        const foldername="planning_task";

        if (processOrderNumber && fileName) {
            $.ajax({
                url: "{{ url('clear-file') }}/" + processOrderNumber,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    file_name: fileName,
                    tablename: tablename,
                    filetype: filetype,
                    foldername:foldername
                },
                success: function(response) {
                    alert("File cleared successfully!");
                    document.getElementById('user_requirement_specifications_document').value = ''; // Clear the file input field
                    document.getElementById('user_requirements_filename').textContent = ''; // Clear the filename display
                },
                error: function(xhr) {
                    alert("Error clearing file: " + xhr.responseText);
                    console.error(xhr); // Log the full error for debugging
                }
            });
        } else {
            if (!fileName)
              //  document.getElementById('technical_file').value = '';
           // document.getElementById('old_technical_file').textContent = '';
            //alert('Please enter a valid Process Order Number and file name.');
       // }
           // document.getElementById('customer_approval_document').value = ''; // Clear the file input field
           // document.getElementById('customer_approval_document_filename').textContent = ''; // Clear the filename display
        //}
   // }

       
        


 



        

            document.getElementById('user_requirement_specifications_document').value = ''; // Clear the file input field
            document.getElementById('user_requirements_filename').textContent = ''; // Clear the filename display

        }

        }

        function clear_pre_engineering_check_document() {


            const processOrderNumber = document.getElementById('process_order_number_planning').value;
        const fileName = document.getElementById('pre_engineering_filename').textContent; // Changed to textContent
        const tablename = "PlanningFormData";
        const filetype = "pre_engineering_check_document";

        const foldername="planning_task";

        if (processOrderNumber && fileName) {
            $.ajax({
                url: "{{ url('clear-file') }}/" + processOrderNumber,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    file_name: fileName,
                    tablename: tablename,
                    filetype: filetype,
                    foldername:foldername
                },
                success: function(response) {
                    alert("File cleared successfully!");
                    document.getElementById('pre_engineering_check_document').value = ''; // Clear the file input field
                    document.getElementById('pre_engineering_filename').textContent = ''; // Clear the filename display
                },
                error: function(xhr) {
                    alert("Error clearing file: " + xhr.responseText);
                    console.error(xhr); // Log the full error for debugging
                }
            });
        } else {
            if (!fileName)
              //  document.getElementById('technical_file').value = '';
           // document.getElementById('old_technical_file').textContent = '';
            //alert('Please enter a valid Process Order Number and file name.');
       // }
           // document.getElementById('customer_approval_document').value = ''; // Clear the file input field
           // document.getElementById('customer_approval_document_filename').textContent = ''; // Clear the filename display
        //}
   // }

       
        


  



            document.getElementById('pre_engineering_check_document').value = ''; // Clear the file input field
            document.getElementById('pre_engineering_filename').textContent = ''; // Clear the filename display
        }

    }
    </script>
</body>
</html>
