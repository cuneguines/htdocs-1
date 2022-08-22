
<!DOCTYPE html>
<html>

<head>
    <!-- INITALISATION AND META STUFF -->
    <title>Pre Production Table</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale = 1">

    <!-- EXTERNAL JAVASCRIPT -->
    <script type="text/javascript" src="../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
    

    <!-- STYLING -->
    <link rel="stylesheet" href="./assets/css/LT_STYLE.css">
    <link rel="stylesheet" href="../../../../css/theme.blackice.min.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

    <!-- PHP INITALISATION -->
    <?php //include './php_functions.php'; ?>
    <?php include '../../SQL CONNECTIONS/conn.php'; ?>
    <?php //include 'assets/furniture_issues.json ;'?>

    <?php
    $pre_production_table_data = json_decode(file_get_contents('assets/furniture_issues.json'), true);
    /* $getResults = $conn->prepare($pre_production_table_query);
    $getResults->execute();
    $pre_production_table_data = $getResults->fetchAll(PDO::FETCH_BOTH); */
    function generate_filter_option($table, $field)
    {
        foreach (array_sort(array_unique(array_column($table, $field))) as $element) {
            echo "<option type=checkbox value = '" . str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $element)) . "'>" . ($element) . "</option>";
        }
    }
    ?>

    <!-- TABLESORTER INITALISATION -->
    <script>
        $(function() {
            $("table.sortable").tablesorter({
                "theme": "blackice",
                "dateFormat": "ddmmyyyy",
                "headers": {
                    8: {
                        sorter: "shortDate"
                    }
                }
            });
        });

        $(document).ready(function() {

            // ON PAGE LOAD RESET ANY INSTANCE OF THE TWO TYPES OF FILTER TO ALL (0)(RESET)
            $('.selector').prop('selectedIndex', 0);
            $('.col_selector').prop('selectedIndex', 0);

            // READ IN ROWS FROM FILTERABLE TABLE
            var rows = $("table.filterable tbody tr:not('.head')");
            var template = $('table.filterable tfoot tr td');

            if (typeof __update_rows__ !== 'undefined') {
                update_total_row(rows, template);
            }

            // IF A ROW SELECTOR FILTER IS CHANGED
            // PROP ALL OTHER FILTERS TO ALL
            // IF FILTER IS CHANGED FROM ONE OPTION TO ALL SHOW ALL ROWS
            // OTHERWIE FILTER ALL ROWS WHOOSE DOM VARIABLE MATCHING THE REMAINDER OF THE ID STRiNG AFTER select_xxxvarnamexxx MATHING THE OPTION SELECTED ON THE FILTER
            $(".selector").on("change", function filter() {
                //$('.selector').not(this).prop('selectedIndex', 0);
                $('button').removeClass('pressed');
                if ($(this).children("option:selected").val() === 'All') {
                    rows.show();
                    if (typeof __update_rows__ !== 'undefined') {
                        update_total_row(rows, template);
                    }
                } else {
                    rows.show();
                    rows.not('[' + $(this).attr('id').substring(7) + ' = ' + $(this).children("option:selected").val() + ']').hide();
                    if (typeof __update_rows__ !== 'undefined') {
                        update_total_row(rows.filter('[' + $(this).attr('id').substring(7) + ' = ' + $(this).children("option:selected").val() + ']'), template);
                    }
                }
                var customerId = '';
                $('#selec_engineer').empty();
                var sum=0;
                $("#pre_production_table tr:visible td.Group3").each(function() {

                    var customerId = $(this).html();
                   // console.log(customerId);
                    sum += parseFloat($(this).text());

                    var option = new Option();
                    //Convert the HTMLOptionElement into a JQuery object that can be used with the append method.
                    $(option).html(customerId);
                    //Append the option to our Select element.
                    $("#selec_engineer").append(option);

                });
               // console.log(sum);

            });
            
            $("#selec_engineer").on("change", function filter() {
                var data = this.value;
                //console.log(data);
                var rows = $("#pre_production_table").find("tr:not('.head')");
                console.log(rows);
                if (data == '') {
                    rows.show();
                } else {
                    rows.hide();
                    rows.filter(":contains('" + data + "')").show();

                }
                var sum=0;
                $("#pre_production_table tr:visible td.Group3").each(function() {
                    
                    var customerId = $(this).html();
                    sum += parseFloat($(this).text());
                    //console.log(customerId);





                });
                //console.log(sum);
            });
            var sum=0;
            $("#pre_production_table").on("change",'input',function () {
                $("#pre_production_table tr:visible td.Group3").each(function() {
                    
                    var customerId = $(this).html();
                    sum += parseFloat($(this).text());
                    //console.log(customerId);





                });

            });
            console.log(sum);
            $('.sortable').on('change',function () {
    var row = $(this).closest('tr');
    var total = 1;
    console.log(row);
            });
        });
    </script>
    <style>
        .box {
            margin-top: 10%;
            margin-left: 10%;
            width: 20px;
            height: 20px;
            border: 1px solid rgba(0, 0, 0, .2);
        }
    </style>
</head>

<body>
    <div id="background">
        <div id="content">
            <div class="table_title green">
                <h1> QUALITY</h1>
            </div>

            <div id="pages_table_container" class="table_container" style="overflow-y:scroll;">
                <table id="pre_production_table" class="filterable sortable ">
                    <thead>
                        <!-- Legends for the table starts here -->
                        <div style="background:black;opacity:0.7;width:150px;height:140px;position:fixed;z-index:2;
                             top:40px;left:20px;">
                            <div class="box light_green">
                                <div style="position:relative;margin-left:150%;">DrApproved</div>
                            </div>
                            <div class="box baige">
                                <div style="position:relative;margin-left:150%;">Potential</div>
                            </div>
                            <div class="box amber">
                                <div style="position:relative;margin-left:150%;">Forecast</div>
                            </div>
                        </div>
                        <!-- Legend Ends here -->
                        <tr class="dark_grey wtext smedium head">
                            <th width="7%">Sales Order</th>
                            <th width="14%">Process Order</th>
                            <th width="14%">Product_One</th>
                            <th width="18%">Product_Two</th>
                            <th width="6%">Product_Three</th>
                            <th width="14%">Issues</th>
                            <th width="14%">Issues Caused</th>
                            <th width="14%">Issues Raised by</th>


                        </tr>
                    </thead>
                    <tbody class="white btext smedium">
                        <?php foreach ($pre_production_table_data as $row) :
                            if ($row["U_Product_Group_One"] == 'Furniture') { ?>

                                <?php $group2 = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $row["U_Product_Group_Two"])); ?>
                                <tr group2='<?= $group2 ?>'>
                                    <td><?= $row["sales order"] ?></td>
                                    <td><?= $row["Process order"] ?></td>
                                    <td><?= $row["U_Product_Group_One"] ?></td>
                                    <td><?= $row["U_Product_Group_Two"] ?></td>
                                    <td class='Group3'><?= $row["U_Product_Group_Three"] ?></td>
                                    <td class="righttext"><?= $row["Issues"] ?></td>
                                    <td><?= '' ?></td>
                                    <td><?= '' ?></td>
                                </tr>
                            <?php } ?>
                            <?php $str = ''; ?>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div id="table_pages_footer" class="footer">
                <div id="top">
                    <div id="filter_container">
                        <div id="filters" class="red fill rounded">
                            <div class="filter">
                                <div class="text">
                                    <button class="fill red medium wtext">By Group</button>
                                </div>
                                <div class="content">
                                    <select id="select_group2" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <?php generate_filter_option($pre_production_table_data, "U_Product_Group_Two"); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="filter" style="display:none">
                                <div class="text">
                                    <button class="fill red medium wtext">Project</button>
                                </div>
                                <div class="content">
                                    <select id="select_project" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <?php generate_filter_options($pre_production_table_data, "Project"); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="filter">
                                <div class="text">
                                    <button class="fill red medium wtext">By Sub Group</button>
                                </div>
                                <div class="content">
                                    <select id="selec_engineer" class=" fill medium">
                                        <option value="All" selected>All</option>
                                        <?php generate_filter_options($pre_production_table_data, "Engineer"); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="filter" style="display:none">
                                <div class="text">
                                    <button class="fill red medium wtext">Sales Person</button>
                                </div>
                                <div class="content">
                                    <select id="select_sales_person" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <?php generate_filter_options($pre_production_table_data, "Sales Person"); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="bottom">
                    <div id="button_container">
                        <button class="grouping_page_corner_buttons fill medium light_blue wtext rounded">UNUSED</button>
                    </div>
                    <div id="button_container_wide">
                        <button onclick="location.href='../../../MAIN MENU/dashboard_menu.php'" class="grouping_page_corner_buttons fill medium purple wtext rounded">MAIN MENU</button>
                    </div>
                    <div id="button_container">
                        <button onclick="export_to_excel('pre_production_table')" class="grouping_page_corner_buttons fill medium green wtext rounded">EXCEL</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>