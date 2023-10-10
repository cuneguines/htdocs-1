<!DOCTYPE html>
<html>

<head>
    <!-- INITALISATION AND META STUFF -->
    <title>New Sales Orders</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale = 1">

    <!-- EXTERNAL JAVASCRIPT -->
    <script type="text/javascript" src="../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

    <!-- LOCAL JS -->
    <script type="text/javascript" src="../../../JS LIBS/LOCAL/JS_filters.js"></script>
    <script type="text/javascript" src="../../../JS LIBS/LOCAL/JS_comments.js"></script>
    <script type="text/javascript" src="./JS_table_to_excel.js"></script>

    <!-- STYLING -->
    <link rel="stylesheet" href="../../../CSS/LT_STYLE.css">
    <link rel="stylesheet" href="../../../css/theme.blackice.min.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

    <!-- PHP INITALISATION -->
    <!-- GET SALES ORDER FROM POST BEFORE INCLUDING QUERY (VARIABLE INLCUDED IN WHERE CLAUSE)-->
    <?php   $sales_order = isset($_GET['so']) ? $_GET['so'] : 000000;   ?>

    <?php include '../../../PHP LIBS/PHP FUNCTIONS/php_functions.php'; ?>
    <?php include '../../../SQL CONNECTIONS/conn.php'; ?>
    <?php include './SQL_Margin_tracker.php'; ?>

    <?php
        $getResults = $conn->prepare($margin_tracker);
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
<style>
@keyframes slideInLeft {
    0% {
        transform: translateX(-100%);
    }

    100% {
        transform: translateX(0);
    }
}

h1 {
    animation-duration: 2s;
    animation-timing-function: ease-in-out;
    animation-delay: 0s;
    animation-iteration-count: 1;
    animation-name: slideInLeft;

}
</style>

<body>
    <div id="background">
        <div id="content">
           
            <div class="table_title "style="top:0">
                <h1 style="background:linear-gradient(100deg,black, orange)">SALES ORDER MARGIN</h1>
            </div>

            <!--  <table id="products" style="position: sticky;overflow-x:scroll;">
                            <thead style="position:sticky;top:0;z-index:+2">
                                <tr class="head">
                                    <th style="position: sticky;width:100px;left:0px;color:white;padding-left:3px">Code</th>
                                    <th style="position: sticky;width:200px;left:100px;color:white">ItemName</th>
                                    <th style="position: sticky;width:200px;left:300px;color:white">Issue</th>
                                    <th style="width:100px">ItemCode</th>
                                    <th style="width:200px">ItemGroup</th> -->

            <div id="pages_table_container" style="overflow-x:scroll;height:80%;top:0" class="table_container">
                <table id="new_sales_orders_margin" class="filterable sortable colborders">
                    <thead style="position:sticky;top:0;z-index:+2;background-color:black">
                        <!-- 		LineNum	so_status	PrcrmntMtd	Qty Delivered	Cost at Delivery	Delivery Return	Cost at Return	Qty Returned	Sales Value	SO_Original_Cost	Planned_BOM_Cost	Planned Prod Order Cost	Likely Prod Ord Cost	Orig Margin	Planned BOM Margin	Planned Prod Ord Margin	Likely Prod Ord Margin -->

                        <tr class="dark_grey wtext smedium head">
                            <th style="position:sticky;width:100px;left:0px;padding-left:3px;background-color:black">Sales Order</th>
                            <th style="position:sticky;width:300px;left:100px;color:white;background-color:black">Item Name</th>
                            <th style="position:sticky;width:200px;left:400px;color:white;background-color:black">Customer</th>
                            <th style="position:sticky;width:200px;left:600px;background-color:black">Project</th>
                            <th width="100px">PP Status</th>
                            <th width="100px">Doc Date</th>
                            <th width="100px">Due Date</th>
                            <th width="100px">Rel Date</th>
                            <th width="100px">Item Code</th>

                            <th width="100px">Quantity</th>
                            <th width="100px">Delivered Qty</th>
                            <th width="100px">Open qty</th>
                            <th width="100px">Process Order</th>
                            <th width="100px">CompletedQty</th>
                            <th width="100px">Line Status</th>
                            <th width="100px">Line Number</th>
                            <th width="100px">Sales Order Status</th>
                            <th width="100px">Prcrmnt Mtd</th>
                            <th width="100px">Qty Delivered</th>
                            <th width="200px">Cost at delivery</th>
                            <th width="200px">Delivery return</th>
                            <th width="200px">Cost at return</th>
                            <th width="200px">Sales Value</th>
                            <th width="200px">SO Original Cost</th>
                            <th width="200px">Planned BOM Cost</th>
                            <th width="200px">Planned Production Order Cost</th>
                            <th width="200px">Likely Production Order Cost</th>
                            <th width="100px">Origin Margin</th>
                            <th width="200px">Planned BOM Margin</th>
                            <th width="200px">Planned Pro Ord Margin</th>
                            <th width="200px">Likely Production Order Margin</th>
                        </tr>
                    </thead>
                    <tbody class="white">
                        <?php foreach ($sales_order_items as $sales_order) : ?>
                        <?php $row_color = ""; ?>
                        <?php $customer = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["cardname"]));         ?>
                        <?php $status = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["PP Status"]));         ?>
                        <?php $project = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["U_client"]));           ?>
                        <?php $release_date = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["DateCategory"]));           ?>
                        <?php //$engineer = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["Engineer"]));         ?>
                        <?php //$sales_person = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["Sales Person"])); ?>
                        <?php //$cell_color = $sales_order["Margin"] < 0.5 ? 'light_red' : '';?>
                        <?php $sales_order["Orig Margin"]<.4 ? $cell_color_margin='light_red':$cell_color_margin=''?>
                        <?php $sales_order["Planned BOM Margin"]<.4 ? $cell_color='light_red':$cell_color=''?>
                        <?php $sales_order["Planned Prod Ord Margin"]<.4 ? $cell_color_plan='light_red':$cell_color_plan=''?>
                        <?php $sales_order["Likely Prod Ord Margin"]<.4 ? $cell_color_likely='light_red':$cell_color_likely=''?>

                        <tr class='smedium btext' status='<?= $status ?>' release_date='<?= $release_date ?>'
                            customer='<?= $customer ?>' project='<?= $project ?>' engineer='<?= $engineer ?>'
                            sales_person='<?= $sales_person ?>'>
                            <td style="position:sticky;left:0px;background-color: #009688;box-shadow: -2px 0px 8px 10px #607D8B;background:linear-gradient(100deg,#009688, white )"
                                class="bold"><button class="brred rounded btext medium"
                                    onclick="location.href='../../../../../../SAP%20READER/SAP READER/BASE_sales_order.php?sales_order=<?=$sales_order['Sales Order']?>'"><?= $sales_order["Sales Order"]?><button>
                            </td>
                            <td style="position:sticky;left:100px;background-color: #009688;box-shadow: -2px 0px 8px 10px #607D8B;background:linear-gradient(100deg,#009688, white )"
                                class='lefttext'><?= $sales_order["Project"] ?></td>
                            <td
                                style="position:sticky;left:400px;background-color: #009688;box-shadow: -2px 0px 8px 10px #607D8B;background:linear-gradient(100deg,#009688, white )">
                                <?= $sales_order["cardname"] ?></td>
                            <td
                                style="position:sticky;left:600px;background-color: #009688;box-shadow: -2px 0px 8px 10px #607D8B;background:linear-gradient(100deg,#009688, white )">
                                <?= $sales_order["Project"] ?></td>
                            <td><?= $sales_order["PP Status"]==NULL?'NULL':$sales_order["PP Status"]?></td>
                            <td><?= $sales_order["DocDate"]?></td>
                            <td><?=$sales_order["Promise Date"]?></td>
                            <td><?=$sales_order["RlsDate"]?></td>
                            <td><?=$sales_order["ItemCode"]?></td>

                            <td><?= $sales_order["Quantity"] ?></td>
                            <td><?= $sales_order["DelivrdQty"] ?></td>
                            <td><?= $sales_order["OpenQty"] ?></td>
                            <td><?= $sales_order["Process Order"] ?></td>
                            <td><?= $sales_order["CmpltQty"] ?></td>
                            <td><?= $sales_order["LineStatus"] ?></td>
                            <td><?= $sales_order["LineNum"] ?></td>
                            <td><?= $sales_order["so_status"] ?></td>
                            <td><?= $sales_order["PrcrmntMtd"] ?></td>
                            <td><?= round($sales_order["Qty Delivered"],0) ?></td>
                            <td><?= round($sales_order["Cost at Delivery"] ,0)?></td>
                            <td><?= $sales_order["Delivery Return"] ?></td>
                            <td><?= round($sales_order["Cost at Return"],0) ?></td>

                            <td><?= round($sales_order["Sales Value"],0) ?></td>
                            <td><?= round($sales_order["SO_Original_Cost"],0) ?></td>
                            <td><?= round($sales_order["Planned_BOM_Cost"] ,0)?></td>
                            <td><?= round($sales_order["Planned Prod Order Cost"],0) ?></td>
                            <td><?= round($sales_order["Likely Prod Ord Cost"] ,0)?></td>
                            <td class="righttext bold <?=$cell_color_margin?>">
                                <?= number_format($sales_order["Orig Margin"]*100)?>%</td>
                            <td class="righttext bold <?=$cell_color?>">
                                <?= number_format($sales_order["Orig Margin"]*100)>number_format($sales_order["Planned BOM Margin"]*100)?'<span style=color:red> &#x2193;&nbsp;</span>'.number_format($sales_order["Planned BOM Margin"]*100):number_format($sales_order["Planned BOM Margin"]*100)?>
                                %</td>
                            <td class="righttext bold <?=$cell_color_plan?>">
                                <?= number_format($sales_order["Planned BOM Margin"]*100)>number_format($sales_order["Planned Prod Ord Margin"]*100)?'<span style=color:red> &#x2193;&nbsp;</span>'.number_format($sales_order["Planned Prod Ord Margin"]*100):number_format($sales_order["Planned Prod Ord Margin"]*100) ?>%
                            </td>
                            <td class="righttext bold <?=$cell_color_likely?>">
                                <?= number_format($sales_order["Planned Prod Ord Margin"]*100)>number_format($sales_order["Likely Prod Ord Margin"] *100)?'<span style=color:red> &#x2193;&nbsp;</span>'.number_format($sales_order["Likely Prod Ord Margin"]*100):number_format($sales_order["Likely Prod Ord Margin"]*100)?>%
                            </td>





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
                        <div id="filters" class="red fill rounded" style="box-shadow: -2px 0px 8px 0px #607D8B;
    background: linear-gradient(100deg,#009688, #8BC34A )">
                            <div class="filter">
                                <div class="text">
                                    <button class="fill red medium wtext" style="box-shadow: -2px 0px 8px 0px #607D8B;
    background: linear-gradient(100deg,#009688, #8BC34A )">Customer</button>
                                </div>
                                <div class="content">
                                    <select id="select_customer" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <?php generate_filter_options($sales_order_items, "CardName"); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="filter">
                                <div class="text">
                                    <button class="fill red medium wtext" style="box-shadow: -2px 0px 8px 0px #607D8B;
    background: linear-gradient(100deg,#009688, #8BC34A )">DateCategory</button>
                                </div>
                                <div class="content">
                                    <select id="select_release_date" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <option value="Today" selected>Today</option>
                                        <option value="Yesterday" selected>Yesterday</option>
                                        <option value="LastThreeDays" selected>Last Three Days</option>
                                        <option value="LastFiveDays" selected>Last Five Days</option>
                                        <option value="LastMonth" selected>Last Month</option>
                                        <option value="Year2021" selected>Year 2021</option>
                                        <option value="Year2022" selected>Year 2022</option>
                                        <option value="Year2023" selected>Year 2023</option>
                                        <option value="Other" selected>Other</option>


                                    </select>

                                </div>
                            </div>
                            <div class="filter">
                                <div class="text">
                                    <button class="fill red medium wtext" style="box-shadow: -2px 0px 8px 0px #607D8B;
    background: linear-gradient(100deg,#009688, #8BC34A )">Status</button>
                                </div>
                                <div class="content">
                                    <select id="select_status" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <?php generate_filter_options($sales_order_items, "PP Status"); ?>
                                    </select>
                                </div>
                            </div>
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
                        <button class="grouping_page_corner_buttons fill medium light_blue wtext rounded"
                            onclick='window.history.go(-1);'>BACK</button>
                    </div>
                    <div id="button_container_wide">
                        <button onclick="location.href='../../../MAIN MENU/dashboard_menu.php'"
                            class="grouping_page_corner_buttons fill medium purple wtext rounded">MAIN MENU</button>
                    </div>
                    <div id="button_container">
                        <button onclick="export_to_excel('new_sales_orders_margin')"
                            class="grouping_page_corner_buttons fill medium green wtext rounded">EXCEL</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>