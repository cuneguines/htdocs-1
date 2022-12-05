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
    <?php include '../../../../SQL CONNECTIONS/conn.php';?>
    <?php include './SQL_sales_exceptions.php'; ?>
    
    <?php
        $getResults = $conn->prepare($sales_exceptions);
        $getResults->execute();
        $sales_order_items = $getResults->fetchAll(PDO::FETCH_BOTH);
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
                <h1>SALES EXCEPTIONS</h1>
            </div>

           <!--  <table id="products" style="position: sticky;overflow-x:scroll;">
                            <thead style="position:sticky;top:0;z-index:+2">
                                <tr class="head">
                                    <th style="position: sticky;width:100px;left:0px;color:white;padding-left:3px">Code</th>
                                    <th style="position: sticky;width:200px;left:100px;color:white">ItemName</th>
                                    <th style="position: sticky;width:200px;left:300px;color:white">Issue</th>
                                    <th style="width:100px">ItemCode</th>
                                    <th style="width:200px">ItemGroup</th> -->

            <div id="pages_table_container"style="overflow-x:scroll;" class="table_container">
                <table id="new_sales_orders_margin" class="filterable sortable colborders" style="overflow:xscroll">
                <thead>
                    <!-- 		LineNum	so_status	PrcrmntMtd	Qty Delivered	Cost at Delivery	Delivery Return	Cost at Return	Qty Returned	Sales Value	SO_Original_Cost	Planned_BOM_Cost	Planned Prod Order Cost	Likely Prod Ord Cost	Orig Margin	Planned BOM Margin	Planned Prod Ord Margin	Likely Prod Ord Margin -->
                    

                        <tr class="dark_grey wtext smedium head">
                            
                            <th width="5%">Sales Order</th>
                            <th width="4%">Process Order</th>
                            <th width="4.5%">Card Code</th>
                            <th width="7%">Customer</th>
                            
                            <th width="5%">Item Code</th>
                           
                            <th width="20%">Dscription</th>
                            <th width="6%">Item Value</th>
                            <th width="7%">Open SO Value</th>
                            
                            <th width="6%">Book Out Date</th>
                            <th width="6%">Promise Date</th>
                            <th width="9%">AccStatus</th>
                            <th width="7%">Credit Terms</th>
                            <th width="7%">Balance</th>
                            <!-- <th width="5%">Curr</th> -->
                            <th width="5%">Balance FC</th>
                            <!-- <th width="5%">Engineer</th> -->
                            
                            
                        </tr>
                    </thead>
                    <tbody class="white">
                        <?php foreach ($sales_order_items as $sales_order) : ?>
                            <?php $row_color = ""; ?>
                            <?php $customer = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["cardname"]));         ?>
                            <?php //$project = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["U_client"]));           ?>
                            <?php //$engineer = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["Engineer"]));         ?>
                            <?php //$sales_person = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["Sales Person"])); ?>
                            <?php //$cell_color = $sales_order["Margin"] < 0.5 ? 'light_red' : '';?>
                            
                            <tr class='smedium btext' customer='<?= $customer ?>' project='<?= $project ?>' engineer='<?= $engineer ?>' sales_person='<?= $sales_person ?>'>
                                <td  class="bold"><?= $sales_order["Sales Order"]?></td>
                                <td ><?= $sales_order["Process Order"] ?></td>
                                <td ><?= $sales_order["CardCode"] ?></td>
                                <td class="lefttext"><?= $sales_order["cardname"] ?></td>
                                <td ><?= $sales_order["ItemCode"] ?></td>
                                <td class='lefttext'><?= $sales_order["Dscription"] ?></td>
                                <td class="righttext"><?= number_format($sales_order["Item Value"]) ?></td>
                                <td class="righttext"><?= number_format($sales_order["Open SO Value"]) ?></td>
                                <!-- <td ><?php // $sales_order["Pre Prod Status"] ?></td> -->
                                <td ><?=$sales_order["Book Out Date"]?></td>
                                <td ><?= $sales_order["Promise Date"] ?></td>
                                <td class="lefttext"><?= $sales_order["Acc Status"] ?></td>
                                <td class="righttext"><?=number_format($sales_order["CreditLine"]) ?></td>
                                <td class="righttext"><?= number_format($sales_order["Balance"])?></td>
                                <!-- <td class='lefttext'><?php //$sales_order["Curr"] ?></td> -->
                                <td class='lefttext'><?= number_format($sales_order["BalanceFC"]) ?></td>
                                <!-- <td class='lefttext'><?php //$sales_order["Engineer"] ?></td> -->
                                
                                
                                
                                
                                	


                            </tr>
                            <?
                                $cell_color='';
                                $cell_color_plan='';
                                $cell_color_likely='';
                                $cell_color_margin='';
                                ?>
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
                                        <?php generate_filter_options($sales_order_items, "cardname"); ?>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="filter">
                                <div class="text">
                                    <button class="fill red medium wtext">Project</button>
                                </div>
                                <div class="content">
                                    <select id="select_project" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <?php //generate_filter_options($new_sales_orders_margin_data, "Project"); ?>
                                    </select>
                                </div>
                            </div> -->
                           <!--  <div class="filter">
                                <div class="text">
                                    <button class="fill red medium wtext">Engineeer</button>
                                </div>
                                <div class="content">
                                    <select id="select_engineer" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <?php //generate_filter_options($new_sales_orders_margin_data, "Engineer"); ?>
                                    </select>
                                </div>
                            </div> -->
                           <!--  <div class="filter">
                                <div class="text">
                                    <button class="fill red medium wtext">Sales Person</button>
                                </div>
                                <div class="content">
                                    <select id="select_sales_person" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <?php //generate_filter_options($new_sales_orders_margin_data, "Sales Person"); ?>
                                    </select>
                                </div>
                            </div> -->
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