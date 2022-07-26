<!DOCTYPE html>
<html>

<head>
    <!-- INITALISATION AND META STUFF -->
    <title>Pre Production Table</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale = 1">

    <!-- EXTERNAL JAVASCRIPT -->
    <script type="text/javascript" src="../../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

    <!-- LOCAL JS -->
    <script type="text/javascript" src="../../../../JS LIBS/LOCAL/JS_update_total_rows.js"></script>
    <script type="text/javascript" src="../../../../JS LIBS/LOCAL/JS_filters.js"></script>
    <script type="text/javascript" src="../../../../JS LIBS/LOCAL/JS_comments.js"></script>
    <script type="text/javascript" src="./JS_table_to_excel.js"></script>

    <!-- STYLING -->
    <link rel="stylesheet" href="../../../../CSS/LT_STYLE.css">
    <link rel="stylesheet" href="../../../../css/theme.blackice.min.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

    <!-- PHP INITALISATION -->
    <?php include '../../../../PHP LIBS/PHP FUNCTIONS/php_functions.php'; ?>
    <?php include '../../../../SQL CONNECTIONS/conn.php'; ?>
    <?php include './SQL_pre_production_table.php'; ?>
    <?php
        $getResults = $conn->prepare($pre_production_table_query);
        $getResults->execute();
        $pre_production_table_data = $getResults->fetchAll(PDO::FETCH_BOTH);
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
    </script>
</head>

<body>
    <div id="background">
        <div id="content">
            <div class="table_title green">
                <h1>PRE PRODUCTION</h1>
            </div>
            <div id="pages_table_container" class="table_container">
                <table id="pre_production_table" class="filterable sortable">
                    <thead>
                        <tr class="dark_grey wtext smedium head">
                            <th width="5%">Sales Order</th>
                            <th width="12%">Customer</th>
                            <th width="12%">Project</th>
                            <th width="16%">Description</th>
                            <th width="4%">Quantity</th>
                            <th width="12%">Stage</th>
                            <th width="5%">Engineering Hours</th>
                            <th width="10%">Engineer</th>
                            <th width="5%">Fab Hrs</th>
                            <th width="5%">Promise Week</th>
                            <th width="9%">Sales Person</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody class="white">
                        <?php foreach ($pre_production_table_data as $sales_order) : ?>
                            <?php $row_color = ""; ?>
                            <?php $customer = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["Customer"]));         ?>
                            <?php $project = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["Project"]));           ?>
                            <?php $engineer = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["Engineer"]));         ?>
                            <?php $sales_person = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["Sales Person"])); ?>
                            <?php
                                switch ($sales_order["Stage"]) {
                                    case "1. Drawings Approved (Fab Drawings)":             $row_color = "light_green";     break;
                                    case "1. Drawings Approved ( Fabrication Drawings)":    $row_color = "light_green";     break;
                                    case "Pre Production Potential":                        $row_color = "baige";           break;
                                    case "Pre Production Forecast":                         $row_color = "amber";           break;
                                    default:    $row_color = "";
                                }
                            ?>
                            
                            <tr class='smedium btext <?= $row_color ?>' customer='<?= $customer ?>' project='<?= $project ?>' engineer='<?= $engineer ?>' sales_person='<?= $sales_person ?>'>
                                <td><?= $sales_order["Status"] . $sales_order["Sales Order"] ?></td>
                                <td class='lefttext'><?= $sales_order['Customer'] ?></td>
                                <td class='lefttext'><?= $sales_order["Project"] ?></td>
                                <td class='lefttext'><?= $sales_order["Description"] ?></td>
                                <td><?= $sales_order["Quantity"] ?></td>
                                <td class='lefttext'><?= $sales_order["Stage"] ?></td>
                                <td><?= $sales_order["Est Eng Hrs"] ?></td>
                                <td class = 'lefttext'><?= $sales_order["Engineer"] ?></td>
                                <td><?= $sales_order["Est Prod Hrs"] ?></td>
                                <td><?= ($sales_order["Promise Week Due"] > 52 ? $sales_order["Promise Week Due"] . " (" . ($sales_order["Promise Week Due"] - 52) . ")" : $sales_order["Promise Week Due"]) ?></td>
                                <td class = 'lefttext'><?= $sales_order["Sales Person"] ?></td>
                                <td><button class='comment_button <?= ($sales_order["Comments"] != null ? 'has_comment' : '') . "' comments = '" . $sales_order["Comments"] ?>'></button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot style = "position:sticky; bottom: 0; z-index:+1;">
                        <tr class = "light_grey btext">
                            <td aggregateable = 'Y' operation = 'COUNT_UNIQUE'> </td>
                            <td aggregateable = 'N' operation = ''>             </td>
                            <td aggregateable = 'N' operation = ''>             </td>
                            <td aggregateable = 'N' operation = ''>             </td>
                            <td aggregateable = 'N' operation = ''>             </td>
                            <td aggregateable = 'N' operation = ''>             </td>
                            <td aggregateable = 'Y' operation = 'SUM'>          </td>
                            <td aggregateable = 'N' operation = ''>             </td>
                            <td aggregateable = 'Y' operation = 'SUM'>          </td>
                            <td aggregateable = 'N' operation = ''>             </td>
                            <td aggregateable = 'N' operation = ''>             </td>
                            <td aggregateable = 'N' operation = ''>             </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div id="table_pages_footer" class="footer">
                <div id="top">
                    <div id="filter_container">
                        <div id="filters" class="red fill rounded">
                            <div class="filter">
                                <div class="text">
                                    <button class="fill red medium wtext">Customer</button>
                                </div>
                                <div class="content">
                                    <select id="select_customer" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <?php generate_filter_options($pre_production_table_data, "Customer"); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="filter">
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
                                    <button class="fill red medium wtext">Engineeer</button>
                                </div>
                                <div class="content">
                                    <select id="select_engineer" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <?php generate_filter_options($pre_production_table_data, "Engineer"); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="filter">
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