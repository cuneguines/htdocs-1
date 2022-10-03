<!DOCTYPE html>
<html>

<head>
    <!-- INITALISATION AND META STUFF -->
    <title>New Sales Orders</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale = 1">

    <!-- EXTERNAL JAVASCRIPT -->
    <script type="text/javascript" src="../../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

    <!-- LOCAL JS -->
    <script type="text/javascript" src="../../../../JS LIBS/LOCAL/JS_filters.js"></script>
    <script type="text/javascript" src="../../../../JS LIBS/LOCAL/JS_comments.js"></script>
    <script type="text/javascript" src="./JS_table_to_excel.js"></script>

    <!-- STYLING -->
    <link rel="stylesheet" href="../../../../CSS/LT_STYLE.css">
    <link rel="stylesheet" href="../../../../css/theme.blackice.min.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

    <!-- PHP INITALISATION -->
    <!-- GET SALES ORDER FROM POST BEFORE INCLUDING QUERY (VARIABLE INLCUDED IN WHERE CLAUSE)-->
    <?php   $sales_order = isset($_GET['so']) ? $_GET['so'] : 000000;   ?>

    <?php include '../../../../PHP LIBS/PHP FUNCTIONS/php_functions.php'; ?>
    <?php include '../../../../SQL CONNECTIONS/conn.php'; ?>
    <?php include './SQL_sales.php'; ?>
    
    <?php
        $getResults = $conn->prepare($sales_margin_results);
        $getResults->execute();
        $sales_margin_results = $getResults->fetchAll(PDO::FETCH_BOTH);
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
                <h1>SALES ANALYSIS</h1>
            </div>
            <div id="pages_table_container" class="table_container">
                <table id="new_sales_orders_margin" class="filterable sortable colborders">
                    <thead>
                   

                        <tr class="dark_grey wtext smedium head">
                            <th width="5%">Sales Order</th>
                            <th width="8%">Customer</th>
                            <th width="10%">Project</th>
                            <th width="10%">Earliest Due Date</th>
                            <th width="7%">Sales Value</th>
                            <th width="7%">SO_Original_Cost</th>
                            <th width="10%">Planned_BOM_Cost</th>
                            <th width="8%">Planned Prod Order Cost</th>
                            <th width="6%">Likely Prod Ord Cost</th>
                            <th width="6%">Orig Margin</th>
                            <th width="6%">Planned BOM Margin</th>
                            
                            <th width="7%">Planned Prod Ord Margin</th>
                            <th width="6%">Likely Prod Ord Margin</th>
                            <!-- <th width="4%">Comm</th> -->
                        </tr>
                    </thead>
                    <tbody class="white">
                        <?php foreach ($sales_margin_results as $sales_order) : ?>
                            <?php $row_color = ""; ?>
                            <?php $customer = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["CardName"]));         ?>
                            <?php $project = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["U_Client"]));           ?>
                            <?php //$engineer = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["Engineer"]));         ?>
                            <?php //$sales_person = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["Sales Person"])); ?>
                            <?php //$cell_color = $sales_order["Margin"] < 0.5 ? 'light_red' : '';?>
                            
                            <tr class='smedium btext' customer='<?= $customer ?>' project='<?= $project ?>' engineer='<?= $engineer ?>' sales_person='<?= $sales_person ?>'>
                                <td><?= $sales_order["Sales Order"]?></td>
                                <td class='lefttext'><?= $sales_order["CardName"] ?></td>
                                <td class = 'lefttext'><?= $sales_order["U_Client"] ?></td>
                                <td><?= $sales_order["Earliest Due Date"]?></td>
                                <td><?= floatval($sales_order["Sales Value"] )?></td>
                                <td><?= floatval($sales_order["SO_Original_Cost"]) ?></td>
                                <td class = "righttext"><?=floatval ($sales_order["Planned_BOM_Cost"] )?></td>
                                
                                <td class = "righttext">€<?= floatval($sales_order["Planned Prod Order Cost"])?></td>
                                <td class = "righttext"><?= floatval($sales_order["Likely Prod Ord Cost"] )?></td>
                                <td class = "righttext bold"><?= number_format($sales_order["Orig Margin"]*100)?>%</td>
                                <td class = "righttext bold <?=$cell_color?>"><?= number_format($sales_order["Planned BOM Margin"]*100)?> %</td>
                                <td class = 'righttext bold'><?= number_format($sales_order["Planned Prod Ord Margin"]*100) ?>%</td>
                                <td class = 'righttext bold'><?= number_format($sales_order["Likely Prod Ord Margin"] *100)?>%</td>
                                <!-- <td class = 'lefttext'><?// $sales_order["U_Dimension1"] ?></td> -->
                                <!-- <td><button class='comment_button <?// ($sales_order["Comments"] != null ? 'has_comment' : '') . "' comments = '" . $sales_order["Comments"] ?>'></button></td> -->
                            </tr>
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
                                    <button class="fill red medium wtext">Customer</button>
                                </div>
                                <div class="content">
                                    <select id="select_customer" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <?php generate_filter_options($sales_margin_results, "CardName"); ?>
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
                                        <?php generate_filter_options($sales_margin_results, "U_Client"); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="filter" style ="display:none">
                                <div class="text">
                                    <button class="fill red medium wtext">Engineeer</button>
                                </div>
                                <div class="content">
                                    <select id="select_engineer" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <?php generate_filter_options($new_sales_orders_margin_data, "Engineer"); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="filter"style ="display:none">
                                <div class="text">
                                    <button class="fill red medium wtext">Sales Person</button>
                                </div>
                                <div class="content">
                                    <select id="select_sales_person" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <?php generate_filter_options($new_sales_orders_margin_data, "Sales Person"); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="bottom">
                    <div id="button_container">
                        <button class="grouping_page_corner_buttons fill medium light_blue wtext rounded" onclick = 'window.history.go(-1);'>BACK</button>
                    </div>
                    <div id="button_container_wide">
                        <button onclick="location.href='../../../MAIN MENU/dashboard_menu.php'" class="grouping_page_corner_buttons fill medium purple wtext rounded">MAIN MENU</button>
                    </div>
                    <div id="button_container">
                        <button onclick="export_to_excel('new_sales_orders_margin')" class="grouping_page_corner_buttons fill medium green wtext rounded">EXCEL</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>