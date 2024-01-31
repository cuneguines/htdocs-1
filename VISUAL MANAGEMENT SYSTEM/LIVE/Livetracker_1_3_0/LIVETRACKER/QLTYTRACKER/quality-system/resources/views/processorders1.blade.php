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
</head>

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

        <!-- FINANCE MENU -->
        <h2 style="color:red">Welcome to Engineering Page, {{ Session::get('user_id') }}</h2>
        <div id="background" style="float: left;width:85%;">
            <div id="content">
                <div class="table_title green" style="box-shadow: -3px 3px 6px #03A9F4, 0 1px 4px #03A9F4;">
                    <h1>PROCESS ORDER OPENED</h1>


                    <label for="process_order">Select Process Order</label>
                    <select id="processOrderSelect" name="processorder" required style="width: 200px;">
                        @foreach ($processOrders as $processOrder)
                        <option value="{{ $processOrder->PrOrder }}">{{ $processOrder->PrOrder }}</option>
                        <!-- Adjust the value and display text based on your ProcessOrder model structure -->
                        @endforeach
                    </select>
                    <div id="pages_table_container">
                        <div id="lineItemsContainer">

                        </div>
                    </div>
                </div>
            </div>
            <!-- Other form elements go here -->
            <style>
            /* Add this in your CSS file or in a style tag within your HTML */
            </style>
        </div>
</body>
<script>
// Wait for the DOM to be ready
$(document).ready(function() {
    // Handle change event on the select element
    $('#processOrderSelect').change(function() {
        // Get the selected process order id
        var selectedProcessOrderId = $(this).val();
        console.log(selectedProcessOrderId);
        // Make an AJAX request to get line items
        $.ajax({
            url: '/get-line-items/' + selectedProcessOrderId,
            type: 'GET',
            success: function(data) {
                // Assuming data is an array of items
                //Assuming data is your JSON array
                var html =
                    '<table border="1"><thead><tr><th>Step Description</th><th>PrOrder</th></tr></thead><tbody>';

                $.each(data, function(index, item) {
                    html += '<tr>';
                    // Adjust the property name based on your actual JSON structure
                    html += '<td >' + item.StepDesc +
                        '</td><td  style="text-align: center;">' + item.PrOrder +
                        '</td>';


                    html += '</tr>';
                });

                html += '</tbody></table>';

                // Update the line items container with the generated HTML
                $('#lineItemsContainer').html(html);
            },
            error: function(error) {
                console.error('Error fetching line items:', error);
            }
        });

    });
});
</script>


</div>
</body>

</html>