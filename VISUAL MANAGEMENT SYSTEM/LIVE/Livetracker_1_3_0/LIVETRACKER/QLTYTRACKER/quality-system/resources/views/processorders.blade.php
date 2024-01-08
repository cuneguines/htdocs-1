<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="description" content="meta description">
    <meta name="viewpport" content="width=device-width, initial-scale = 1">
    <title>Kent Stainless</title>
    <link rel="stylesheet" href="../../../css/KS_DASH_STYLE.css">
    <script type="text/javascript" src="../../../JS/LIBS/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="../../../JS/LIBS/canvasjs.min.js"></script>
    <script type="text/javascript" src="../../../JS/LOCAL/JS_menu_select.js"></script>
    <script type="text/javascript" src="./JS_togglecharttable.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../../CSS/KS_DASH_STYLE.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/KS_DASH_STYLE.css')}}">
</head>
<style>
<style>#table-container {
    max-height: 100px;
    overflow-y: scroll;
    position: relative;
    max-width: 70%;
    /* Set a fixed height */
    margin-top: 20px;
}

#table {

    /* Use a fixed layout */
    border-collapse: collapse;
    height: 100%;
    position: relative;
    width: 100%;
    /* Fill the container height */
}

#table th,
#table td {
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
    white-space: nowrap;
    /* Prevent text wrapping */
}

#table th {
    background-color: #f08787;
    color: white;
    position: sticky;
    top: 0;
}

#table tr:nth-child(even) {
    background-color: #f9f9f9;
}

#table tr:nth-child(odd) {
    background-color: white;
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
}

.modal-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
    cursor: pointer;
}
</style>


</style>


<body>
    <div id="background">
        <div id="navmenu">
            <div>
                <p id="title" id="title" onclick="location.href='../MAIN/MAIN_MENU.php'">Kent Stainless</p>
            </div>
            <nav>
                <ul id="dashboard_list">
                    <li id="management_option" class="dashboard_option inactivebtn"
                        onclick="location.href='../MANAGEMENT SUBMENU/BASE_management_menu.php'">Management</li>
                    <li id="sales_option" class="dashboard_option inactivebtn"
                        onclick="location.href='../SALES SUBMENU/BASE_sales_menu.php'">Sales</li>
                    <li id="engineering_option" class="dashboard_option inactivebtn"
                        onclick="location.href='../ENGINEERING SUBMENU/BASE_engineering_menu.php'">Engineering</li>
                    <li id="production_option" class="dashboard_option inactivebtn"
                        onclick="location.href='../PRODUCTION SUBMENU/BASE_production_menu.php'">Production</li>
                    <li id="intel_option" class="dashboard_option inactivebtn"
                        onclick="location.href='../INTEL SUBMENU/BASE_intel_workflow.php'">Intel</li>
                    <li id="ncr_option" class="dashboard_option activebtn"
                        onclick="location.href='../NCR SUBMENU/BASE_ncr_menu.php'">NCR</li>
                    <br>
                    <li id="livetracker_option" class="dashboard_option inactivebtn"
                        onclick="location.href='../../../../VISUAL Management SYSTEM/LIVE/Livetracker_1_3_0'">
                        LIVETRACKER</li>
                </ul>
            </nav>
            <div id="lastupdateholder">
            </div>
        </div>

        <label for="manualProcessOrder">Enter Process Order:</label>
        <input type="text" id="manualProcessOrder" name="manualProcessOrder" required style="width: 200px;">

        <button id="searchButton">Search</button>

        <div id="lineItemsContainer">
            <!-- This is where the line items table will be displayed -->
        </div>
        <h2>Process Order Table</h2>
        <div id="table-container"
            style="max-height: 500px;overflow-y: scroll;position: relative;max-width: 84%; margin-top: 20px;">
            <table id="table" style="display:none;">

            </table>
        </div>

        <!-- HTML for the modal -->
        <div style="display:none" id="myModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <p id="modalContent">Modal Content Goes Here</p>
                <div id="engineeringFieldset"></div>
            </div>
        </div>

        <script>
        // Wait for the DOM to be ready
        $(document).ready(function() {

            $('#myModal').hide();
            // Handle click event on the search button
            $('#searchButton').click(function() {
                // Get the manually entered process order
                $('#table').show();
                var manualProcessOrder = $('#manualProcessOrder').val();

                // Make an AJAX request to get line items
                /*   $.ajax({
                      url: '/get-line-items/' + manualProcessOrder,
                      type: 'GET',
                      success: function(data) {
                          // Assuming data is an array of items
                          var html =
                              '<table><thead><tr><th>Step Description</th><th>PrOrder</th></tr></thead><tbody>';

                          $.each(data, function(index, item) {
                              html += '<tr>';
                              // Adjust the property name based on your actual JSON structure
                              html += '<td>' + item.StepDesc +
                                  '</td><td style="text-align: center;">' + item
                                  .PrOrder + '</td>';
                              html += '</tr>';
                          });

                          html += '</tbody></table>';

                          // Update the line items container with the generated HTML
                          $('#lineItemsContainer').html(html);
                      },
                      error: function(error) {
                          console.error('Error fetching line items:', error);
                      }
                  }); */
            });
        });

        /* MODAL */
        function updateTable(processOrder, qualitySteps) {
            // Get the table element
            var table = $('#table');

            // Clear existing rows
            table.html('');

            // Add header row
            var headerRow = $('<tr>');
            headerRow.append('<th>Process Order</th>');
            headerRow.append('<th>Quality Steps</th>');
            table.append(headerRow);

            // Add data rows
            for (var i = 0; i < qualitySteps.length; i++) {
                var row = $('<tr>');

                // Insert cell for processOrder
                row.append('<td>' + processOrder + '</td>');

                // Insert cell for qualitySteps with a button to open the modal
                var qualityStepButton = $('<button>', {
                    text: qualitySteps[i],
                    click: function() {
                        var clickedRow = $(this).closest('tr');
                        var processOrderValue = clickedRow.find('td:first').text();
                        var qualityStepValue = $(this).text();
                        openModal(processOrderValue, qualityStepValue);
                    }
                });


                row.append('<td>').find('td:last').append(qualityStepButton);




                table.append(row);
            }
        }

        // JavaScript functions for modal with jQuery
        function openModal(processOrder, qualityStep) {
            $('#modalContent').text('Process Order: ' + processOrder + ', Quality Step: ' + qualityStep);
            if (qualityStep === 'Engineering') {
                var engineeringFieldset = `
            <fieldset>
                <legend>Main Task 2: Engineering</legend>

                <!-- Subtask 2.1: Reference Job / Master File -->
                <label>
                    <input type="checkbox" name="reference_job_master_file">
                    Reference Job / Master File if applicable
                </label>
                <br>

                <!-- Subtask 2.2: Concept Design -->
                <label>
                    <input type="checkbox" name="concept_design_engineering_details">
                    Concept design & engineering details
                </label>
                <br>

                <!-- Subtask 2.3: Design Validation -->
                <label>
                    <input type="checkbox" name="design_validation_sign_off">
                    Design sign off [calculations]
                </label>
                <br>

                <!-- Subtask 2.4: Customer Approval -->
                <label>
                    <input type="checkbox" name="customer_submittal_package">
                    Customer submittal package
                </label>
                <br>

                <!-- Subtask 2.5: Sample Approval -->
                <label>
                    <input type="checkbox" name="reference_approved_samples">
                    Reference approved samples
                </label>
                <br>

                <!-- Upload Document for Subtask 2.2 -->
                <label>
                    Upload Concept Design Document:
                    <input type="file" name="concept_design_document">
                </label>
                <br>

                <!-- Upload Document for Subtask 2.4 -->
                <label>
                    Upload Customer Approval Document:
                    <input type="file" name="customer_approval_document">
                </label>
                <br>

                <!-- Sign-off for Main Task 2 -->
                <label>
                    Sign-off for Engineering:
                    <input type="text" name="sign_off_engineering">
                </label>
                <br>

                <!-- Comments for Main Task 2 -->
                <label>
                    Comments for Engineering:
                    <textarea name="comments_engineering" rows="4" cols="50"></textarea>
                </label>
                <br>
            </fieldset>
            `;
                $('#engineeringFieldset').html(engineeringFieldset);
            } else {
                // Clear the fieldset content if the quality step is not "Engineering"
                $('#engineeringFieldset').html('');
            }

            $('#myModal').show();
        }

        function closeModal() {
            $('#myModal').hide();
        }

        // Close the modal if the user clicks outside of it
        /* $(document).click(function(event) {
          var modal = $('#myModal');
          if ($(event.target).is(modal) || $(event.target).closest(modal).length) {
            modal.hide();
          }
        }); */
        /*MODAL ENDS HERE*/
        // Handle click event on the search button
        document.getElementById('searchButton').addEventListener('click', function() {
            // Get the manually entered process order
            var manualProcessOrder = document.getElementById('manualProcessOrder').value;

            // Assuming you have a function to get quality steps based on the entered order
            function getQualitySteps(manualProcessOrder) {
                // Implement your logic to fetch quality steps
                // For demonstration purposes, return a sample array
                return ['Planning / Forward Engineering', 'Engineering', 'Manufacturing Package',
                    'Material Preparation', 'Kitting', 'Fabrication Fit-Up', 'Welding', 'Testing',
                    'Finishing', 'Sub-Contract', 'Final Assembly', 'Documentation', 'Packing and Transport',
                    'OFI'
                ];
            }

            // Get the quality steps
            var qualitySteps = getQualitySteps(manualProcessOrder);

            // Update the table
            updateTable(manualProcessOrder, qualitySteps);
        });
        </script>

    </div>
</body>

</html>