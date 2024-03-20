<!DOCTYPE html>
<html>

<head>

    <!-- ... (other head elements) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <meta charset="utf-8">
    <meta name="description" content="meta description">
    <meta name="viewpport" content="width=device-width, initial-scale = 1">
    <title>Kent Stainless</title>
    <link rel="stylesheet" href="../../../css/KS_DASH_STYLE.css">
    <script type="text/javascript" src="../../../JS/LIBS/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="../../../JS/LIBS/canvasjs.min.js"></script>
    <script type="text/javascript" src="../../../JS/LOCAL/JS_menu_select.js"></script>
    <script type="text/javascript" src="../../../JS/LOCAL/engineering_modal.js"></script>
    <script type="text/javascript" src="../../../JS/LOCAL/planning_modal.js"></script>
    <script type="text/javascript" src="../../../JS/LOCAL/manufacturing_modal.js"></script>
    <script type="text/javascript" src="../../../JS/LOCAL/materialpreparation_modal.js"></script>
    <script type="text/javascript" src="../../../JS/LOCAL/kittingmodal.js"></script>
    <script type="text/javascript" src="../../../JS/LOCAL/fabricationfitup.js"></script>
    <script type="text/javascript" src="../../../JS/LOCAL/welding.js"></script>
    <script type="text/javascript" src="../../../JS/LOCAL/testing.js"></script>
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
    overflow-x: auto;
    overflow-y: scroll;
    /* Enable horizontal scrolling */
    max-width: 100%;
    /* Ensure the container doesn't overflow its parent */
}

.modal-global-content {
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
        <h2 style="color:#f08787">Welcome to Quality Management Page, {{ Session::get('user_id') }}</h2>
        <label for="manualProcessOrder">Enter Process Order:</label>
        <input type="text" id="manualProcessOrder" name="manualProcessOrder" required style="width: 200px;">

        <button id="searchButton">Search</button>

        <div id="lineItemsContainer">
            <!-- This is where the line items table will be displayed -->
        </div>
        <h3>Process Order Table</h3>
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
                <div id="engineeringFieldset" style="overflow-y:scroll;max-height:500px"></div>
                <div id="planningFieldset" style="overflow-y:scroll;max-height:500px"></div>
                <div id="manufacturingFieldset" style="overflow-y:scroll;max-height:500px"></div>
                <div id="materialpreparationFieldset" style="overflow-y:scroll;max-height:500px"></div>
                <div id="kittingFieldset" style="overflow-y:scroll;max-height:500px"></div>
                <div id="fabricationfitupFieldset" style="overflow-y:scroll;max-height:500px"></div>
                <div id="weldingFieldset" style="overflow-y:scroll;max-height:500px"></div>
                <div id="testingFieldset" style="overflow-y:scroll;max-height:500px"></div>
            </div>
        </div>
        <!-- Your table HTML -->
        <div style="display:none" id="globalModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeglobalModal()">&times;</span>
                <p id="global-modal-content">Modal Content Goes Here</p>
                <div id="engineeringFieldTable" style="width:1100px;font-size:14px"></div>
                <div id="planningFieldTable" style="width:1100px;font-size:14px"></div>
                <div id="manufacturingFieldTable" style="width:1100px;font-size:14px"></div>
                <div id="materialpreparationFieldTable" style="width:1100px;font-size:14px"></div>
                <div id="kittingFieldTable" style="width:1100px;font-size:14px"></div>
                <div id="fabricationfitupFieldTable" style="width:1100px;font-size:14px"></div>
                <div id="weldingFieldTable" style="width:1100px;font-size:14px"></div>
                <div id="testingFieldTable" style="width:1100px;font-size:14px"></div>
            </div>
        </div>
        <div style="display:none" id="globalCompleteModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeglobalCompleteModal()">&times;</span>
                <p id="global-complete-modal-content">Modal Content Goes Here</p>
                <div id="engineeringFieldTable" style="overflow-y:scroll;max-height:500px"></div>
                <div id="planningFieldTable" style="overflow-y:scroll;max-height:500px"></div>
                <div id="manufacturingFieldTable" style="overflow-y:scroll;max-height:500px"></div>
                <div id="materialpreparationCompleteFieldTable" style="overflow-y:scroll;max-height:500px"></div>
                <div id="kittingCompleteFieldTable" style="overflow-y:scroll;max-height:500px"></div>

                <div id="fabricationfitupCompleteFieldTable" style="overflow-y:scroll;max-height:500px"></div>
                <div id="weldingCompleteFieldTable" style="overflow-y:scroll;max-height:500px"></div>
                <div id="testingCompleteFieldTable" style="overflow-y:scroll;max-height:500px"></div>
            </div>
        </div>
    </div>
    <div style="display:none" id="globalUpdateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeglobalUpdateModal()">&times;</span>
            <p id="global-update-modal-content">Modal Content Goes Here</p>
            <div id="engineeringUpdateFieldTable" style="overflow-y:scroll;max-height:500px;background-color:white">
            </div>
            <div id="planningUpdateFieldTable" style="overflow-y:scroll;max-height:500px;background-color:white"></div>
            <div id="manufacturingUpdateFieldTable" style="overflow-y:scroll;max-height:500px"></div>
            <div id="materialpreparationUpdateFieldTable" style="overflow-y:scroll;max-height:500px"></div>
            <div id="kittingUpdateFieldTable" style="overflow-y:scroll;max-height:500px"></div>

            <div id="fabricationfitupUpdateFieldTable" style="overflow-y:scroll;max-height:500px"></div>
            <div id="weldingUpdateFieldTable" style="overflow-y:scroll;max-height:500px"></div>
            <div id="testingUpdateFieldTable" style="overflow-y:scroll;max-height:500px"></div>
        </div>
    </div>
    <script>
    var welcomeMessage = $('h2').text();
    var userName = welcomeMessage.split(',')[1].trim();
    var loggedInUser = 'admin';

    // Now, you have the user name in the variable 'userName'
    console.log('User Name:', userName);
    // Wait for the DOM to be ready
    $(document).ready(function() {
        console.log('User Name:', userName);
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
                          html += '<td>' + item.Quantity +
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
    function updateTable_test(processOrder, qualitySteps, userName) {
        console.log('User Name:', userName);
        // Get the table element
        var table = $('#table');

        // Clear existing rows
        table.html('');

        // Add header row
        var headerRow = $('<tr>');
        headerRow.append('<th>Process Order</th>');
        headerRow.append('<th>Quality Steps</th>');
        headerRow.append('<th>View</th>');
        headerRow.append('<th>Complete</th>');
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
                    openModal(processOrderValue, qualityStepValue, userName);
                }
            });

            var qualityStepButtonWithId = $('<button>', {

                text: 'View',
                id: 'button_' + qualitySteps[i], // Add the id based on the quality step
                click: function() {
                    var qualityStepId = $(this).attr('id').split('_')[1];
                    // Handle button click with the quality step id
                    console.log('Button clicked for quality step: ' + qualityStepId);
                    openglobalModal(processOrder, qualityStepId);

                }

            });
            var qualityStepButtonWithCompleteId = $('<button>', {

                text: 'Complete',
                id: 'button_' + qualitySteps[i], // Add the id based on the quality step
                click: function() {
                    var qualityStepId = $(this).attr('id').split('_')[1];
                    // Handle button click with the quality step id
                    console.log('Button clicked for quality step: ' + qualityStepId);
                    openglobalCompleteModal(processOrder, qualityStepId);

                }

            });

            row.append('<td>').find('td:last').append(qualityStepButton);
            row.append('<td style="text-align:center">').find('td:last').append(qualityStepButtonWithId);
            row.append('<td style="text-align:center">').find('td:last').append(qualityStepButtonWithCompleteId);





            table.append(row);
        }
    }

    function updateTable(processOrder, qualitySteps, userName, loggedInUser) {
        console.log('User Name:', userName);
        console.log('User Role:', loggedInUser);
        // Get the table element
        var table = $('#table');

        // Clear existing rows
        table.html('');

        // Add header row
        var headerRow = $('<tr>');
        headerRow.append('<th>Process Order</th>');
        headerRow.append('<th>Quality Steps</th>');

        // Check if loggedInUser is admin to show all buttons
        if (loggedInUser === 'admin') {
            headerRow.append('<th>View</th>');
            headerRow.append('<th>Update</th>');
            headerRow.append('<th>Complete</th>');
        }

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
                    openModal(processOrderValue, qualityStepValue, userName);
                }
            });

            row.append('<td>').find('td:last').append(qualityStepButton);

            // Check if loggedInUser is admin to show all buttons
            if (loggedInUser === 'admin') {
                var qualityStepButtonWithId = $('<button>', {
                    text: 'View',
                    id: 'button_' + qualitySteps[i], // Add the id based on the quality step
                    click: function() {
                        var qualityStepId = $(this).attr('id').split('_')[1];
                        // Handle button click with the quality step id
                        console.log('Button clicked for quality step: ' + qualityStepId);
                        openglobalModal(processOrder, qualityStepId);
                    }
                });

                row.append('<td style="text-align:center">').find('td:last').append(qualityStepButtonWithId);
                var qualityStepButtonWithId = $('<button>', {
                    text: 'Update',
                    id: 'button_' + qualitySteps[i], // Add the id based on the quality step
                    click: function() {
                        var qualityStepId = $(this).attr('id').split('_')[1];
                        // Handle button click with the quality step id
                        console.log('Button clicked for quality step: ' + qualityStepId);
                        openglobalUpdateModal(processOrder, qualityStepId);
                    }
                });

                row.append('<td style="text-align:center">').find('td:last').append(qualityStepButtonWithId);

                var qualityStepButtonWithCompleteId = $('<button>', {
                    text: 'Complete',
                    id: 'button_complete_' + qualitySteps[i], // Add the id based on the quality step
                    click: function() {
                        var qualityStepId = $(this).attr('id').split('_')[2];
                        // Handle button click with the quality step id
                        console.log('Button clicked for quality step: ' + qualityStepId);
                        openglobalCompleteModal(processOrder, qualityStepId);
                    }
                });

                row.append('<td style="text-align:center">').find('td:last').append(
                    qualityStepButtonWithCompleteId);
            } else {
                // For operators, only show the "Complete" button
                var completeButton = $('<button>', {
                    text: 'Complete',
                    id: 'button_complete_' + qualitySteps[i], // Add the id based on the quality step
                    click: function() {
                        var qualityStepId = $(this).attr('id').split('_')[2];
                        // Handle button click with the quality step id
                        console.log('Button clicked for quality step: ' + qualityStepId);
                        openglobalCompleteModal(processOrder, qualityStepId);
                    }
                });

                row.append('<td style="text-align:center">').find('td:last').append(completeButton);
            }

            table.append(row);
        }
    }

    // JavaScript functions for modal with jQuery
    function openModal(processOrder, qualityStep, userName) {
        console.log('i am in openmodal', userName);
        $('#modalContent').text('Process Order: ' + processOrder + ', Quality Step: ' + qualityStep);
        if (qualityStep === 'Engineering') {
            var engineeringFieldset = generateEngineeringFieldset(processOrder, qualityStep, userName);

            $('#engineeringFieldset').html(engineeringFieldset);
        } else {
            // Clear the fieldset content if the quality step is not "Engineering"
            $('#engineeringFieldset').html('');
        }
        if (qualityStep === 'Planning / Forward Engineering') {

            var planningFieldset = generatePlanningFieldset(processOrder, qualityStep, userName);

            $('#planningFieldset').html(planningFieldset);
        } else {
            // Clear the fieldset content if the quality step is not "Engineering"
            $('#planningFieldset').html('');
        }

        if (qualityStep === 'Manufacturing Package') {

            var manufacturingFieldset = generateManufacturingFieldset(processOrder, qualityStep, userName);

            $('#manufacturingFieldset').html(manufacturingFieldset);
        } else {
            // Clear the fieldset content if the quality step is not "Engineering"
            $('#manufacturingFieldset').html('');
        }
        if (qualityStep === 'Material Preparation') {

            var materialpreparationFieldset = generateMaterialPreparationFieldset(processOrder, qualityStep,
                userName);

            $('#materialpreparationFieldset').html(materialpreparationFieldset);
        } else {
            // Clear the fieldset content if the quality step is not "Engineering"
            $('#materialpreparationFieldset').html('');
        }
        if (qualityStep === 'Kitting') {

            var kittingFieldset = generateKittingFieldset(processOrder, qualityStep,
                userName);

            $('#kittingFieldset').html(kittingFieldset);
        } else {
            // Clear the fieldset content if the quality step is not "Engineering"
            $('#kittingFieldset').html('');
        }
        if (qualityStep === 'Fabrication Fit-Up') {

            var fabricationfitupFieldset = generateFabricationFitUpFieldset(processOrder, qualityStep,
                userName);

            $('#fabricationfitupFieldset').html(fabricationfitupFieldset);
        } else {
            // Clear the fieldset content if the quality step is not "Engineering"
            $('#fabricationfitupFieldset').html('');
        }
        if (qualityStep === 'Welding') {

            var weldingFieldset = generateWeldingFieldset(processOrder, qualityStep,
                userName);

            $('#weldingFieldset').html(weldingFieldset);
        } else {
            // Clear the fieldset content if the quality step is not "Engineering"
            $('#weldingFieldset').html('');
        }
        if (qualityStep === 'Testing') {

            var testingFieldset = generateTestingFieldset(processOrder, qualityStep,
                userName);

            $('#testingFieldset').html(testingFieldset);
        } else {
            // Clear the fieldset content if the quality step is not "Engineering"
            $('#testingFieldset').html('');
        }

        $('#myModal').show();
    }

    function closeModal() {
        $('#myModal').hide();
    }
    //FOR VIEW BUTTON 
    function openglobalModal(processOrder, qualityStep) {
        $('#global-modal-content').text('Process Order: ' + processOrder + ', Quality Step: ' + qualityStep);

        // Hide all content divs initially
        $('#engineeringFieldTable').hide();
        $('#planningFieldTable').hide();
        $('#manufacturingFieldTable').hide();
        $('#materialpreparationFieldTable').hide();
        $('#kittingFieldTable').hide();
        $('#fabricationfitupFieldTable').hide();
        $('#weldingFieldTable').hide();

        // Determine which content div to display based on qualityStep
        if (qualityStep === 'Engineering') {
            var engineeringFieldTable = generateEngineeringFieldTable(processOrder, qualityStep);
            $('#engineeringFieldTable').html(engineeringFieldTable).show();
        } else if (qualityStep === 'Planning / Forward Engineering') {
            var planningFieldsetTable = generatePlanningFieldTable(processOrder, qualityStep);
            $('#planningFieldTable').html(planningFieldsetTable).show();
        } else if (qualityStep === 'Manufacturing Package') {
            var manufacturingFieldsetTable = generateManufacturingFieldTable(processOrder, qualityStep);
            $('#manufacturingFieldTable').html(manufacturingFieldsetTable).show();
        } else if (qualityStep === 'Material Preparation') {
            var materialpreparationFieldsetTable = generateMaterialPreparationFieldTable(processOrder, qualityStep);
            $('#materialpreparationFieldTable').html(materialpreparationFieldsetTable).show();
        } else if (qualityStep === 'Kitting') {
            var kittingFieldsetTable = generateKittingFieldTable(processOrder, qualityStep);
            $('#kittingFieldTable').html(kittingFieldsetTable).show();
        } else if (qualityStep === 'Fabrication Fit-Up') {
            var fabricationfitupFieldsetTable = generateFabricationFitUpFieldTable(processOrder, qualityStep);
            $('#fabricationfitupFieldTable').html(fabricationfitupFieldsetTable).show();
        } else if (qualityStep === 'Welding') {
            var weldingFieldsetTable = generateWeldingFieldTable(processOrder, qualityStep);
            $('#weldingFieldTable').html(weldingFieldsetTable).show();
        } else if (qualityStep === 'Testing') {
            var testingFieldsetTable = generateTestingFieldTable(processOrder, qualityStep);
            $('#testingFieldTable').html(testingFieldsetTable).show();
        }

        $('#globalModal').show();
    }

    function openglobalCompleteModal(processOrder, qualityStep) {
        $('#global-complete-modal-content').text('Process Order: ' + processOrder + ', Quality Step: ' +
            qualityStep);

        // Hide all content divs initially
        $('#engineeringCompleteFieldTable').hide();
        $('#planningCompleteFieldTable').hide();
        $('#manufacturingCompleteFieldTable').hide();
        $('#materialpreparationCompleteFieldTable').hide();
        $('#kittingCompleteFieldTable').hide();
        $('#fabricationfitupCompleteFieldTable').hide();
        $('#weldingCompleteFieldTable').hide();

        // Determine which content div to display based on qualityStep
        if (qualityStep === 'Engineering') {
            var engineeringCompleteFieldTable = generateEngineeringCompleteFieldTable(processOrder, qualityStep);
            $('#engineeringCompleteFieldTable').html(engineeringFieldTable).show();
        } else if (qualityStep === 'Planning / Forward Engineering') {
            var planningCompleteFieldsetTable = generatePlanningCompleteFieldTable(processOrder, qualityStep);
            $('#planningCompleteFieldTable').html(planningFieldsetTable).show();
        } else if (qualityStep === 'Manufacturing Package') {
            var manufacturingCompleteFieldsetTable = generateManufacturingCompleteFieldTable(processOrder,
                qualityStep);
            $('#manufacturingCompleteFieldTable').html(manufacturingFieldsetTable).show();
        } else if (qualityStep === 'Material Preparation') {
            var materialpreparationCompleteFieldsetTable = generateMaterialPreparationCompleteFieldset(processOrder,
                qualityStep);
            $('#materialpreparationCompleteFieldTable').html(materialpreparationCompleteFieldsetTable).show();
        } else if (qualityStep === 'Kitting') {
            var kittingCompleteFieldsetTable = generateKittingCompleteFieldset(processOrder,
                qualityStep);
            $('#kittingCompleteFieldTable').html(kittingCompleteFieldsetTable).show();
        } else if (qualityStep === 'Fabrication Fit-Up') {

            var fabricationfitupCompleteFieldsetTable = generateFabricationFitUpCompleteFieldset(processOrder,
                qualityStep);
            $('#fabricationfitupCompleteFieldTable').html(fabricationfitupCompleteFieldsetTable).show();

        } else if (qualityStep === 'Welding') {

            var weldingCompleteFieldsetTable = generateWeldingCompleteFieldset(processOrder,
                qualityStep);
            $('#weldingCompleteFieldTable').html(weldingCompleteFieldsetTable).show();
        } else if (qualityStep === 'Testing') {

            var testingCompleteFieldsetTable = generateTestingCompleteFieldset(processOrder,
                qualityStep);
            $('#testingCompleteFieldTable').html(testingCompleteFieldsetTable).show();
        }

        $('#globalCompleteModal').show();
    }

    function openglobalUpdateModal(processOrder, qualityStep) {
        $('#global-update-modal-content').text('Process Order: ' + processOrder + ', Quality Step: ' +
            qualityStep);

        // Hide all content divs initially
        $('#engineeringUpdateFieldTable').hide();
        $('#planningUpdateFieldTable').hide();
        $('#manufacturingUpdateFieldTable').hide();
        $('#materialpreparationUpdateFieldTable').hide();
        $('#kittingUpdateFieldTable').hide();
        $('#fabricationfitupUpdateFieldTable').hide();
        $('#weldingUpdateFieldTable').hide();

        // Determine which content div to display based on qualityStep
        if (qualityStep === 'Engineering') {
            var engineeringCompleteFieldTable = generateEngineeringCompleteFieldTable(processOrder, qualityStep);
            $('#engineeringCompleteFieldTable').html(engineeringFieldTable).show();
        } else if (qualityStep === 'Planning / Forward Engineering') {
            var planningUpdateFieldsetTable = generatePlanningUpdateFieldTable(processOrder, qualityStep);
            $('#planningUpdateFieldTable').html(planningUpdateFieldsetTable).show();
        } else if (qualityStep === 'Manufacturing Package') {
            var manufacturingCompleteFieldsetTable = generateManufacturingCompleteFieldTable(processOrder,
                qualityStep);
            $('#manufacturingCompleteFieldTable').html(manufacturingFieldsetTable).show();
        } else if (qualityStep === 'Material Preparation') {
            var materialpreparationCompleteFieldsetTable = generateMaterialPreparationCompleteFieldset(processOrder,
                qualityStep);
            $('#materialpreparationCompleteFieldTable').html(materialpreparationCompleteFieldsetTable).show();
        } else if (qualityStep === 'Kitting') {
            var kittingCompleteFieldsetTable = generateKittingCompleteFieldset(processOrder,
                qualityStep);
            $('#kittingCompleteFieldTable').html(kittingCompleteFieldsetTable).show();
        } else if (qualityStep === 'Fabrication Fit-Up') {

            var fabricationfitupCompleteFieldsetTable = generateFabricationFitUpCompleteFieldset(processOrder,
                qualityStep);
            $('#fabricationfitupCompleteFieldTable').html(fabricationfitupCompleteFieldsetTable).show();

        } else if (qualityStep === 'Welding') {

            var weldingCompleteFieldsetTable = generateWeldingCompleteFieldset(processOrder,
                qualityStep);
            $('#weldingCompleteFieldTable').html(weldingCompleteFieldsetTable).show();
        }

        $('#globalUpdateModal').show();
    }

    function closeglobalCompleteModal() {
        $('#globalCompleteModal').hide();
    }

    function closeglobalUpdateModal() {
        $('#globalUpdateModal').hide();
    }

    function closeglobalModal() {
        $('#globalModal').hide();
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
        updateTable(manualProcessOrder, qualitySteps, userName, loggedInUser);
    });
    </script>

    </div>
</body>

</html>