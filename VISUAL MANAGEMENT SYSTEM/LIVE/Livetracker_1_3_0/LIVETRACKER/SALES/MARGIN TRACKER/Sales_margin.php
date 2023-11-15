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
    <script type="text/javascript" src="./filter.js"></script>
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
    <?php include './SQL_Margin_tracker.php'; ?>
   <?php include '../../../SQL CONNECTIONS/conn.php';?>
  


    <?php

        $getResults = $conn->prepare($margin_tracker);
        $getResults->execute();
        $sales_margin = $getResults->fetchAll(PDO::FETCH_BOTH);
       // $sales_margin = json_decode(file_get_contents(__DIR__ . '\CACHE\salesmargin.json'), true); ?>

    <?php
/* require 'vendor/autoload.php';
Predis\Autoloader::register();

// Redis configuration
$redis = new Predis\Client();
$redis->connect('127.0.0.1', 6379); // Replace with your Redis server details

// Read the cached JSON data from the file
$cached_data = file_get_contents("CACHE/salesmargin.json");

// Store the JSON data in Redis
$redis->set('sales_margin_data', $cached_data);
$redis->expire('sales_margin_data', 3600); // 3600 seconds = 1 hour

// Retrieve the JSON data from Redis
$retrieved_data = $redis->get('sales_margin_data');

// Convert the JSON data to an associative array
$sales_margin = json_decode($retrieved_data, true);
 */
  ?>
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







    function spinAndReload(button) {
        // Add a highlighted style to the button
        button.style.background = 'linear-gradient(100deg, #E91E63, #F06292)';
        button.disabled = true;
        button.innerHTML += '<span class="dot-dot-dot"></span>';
        // Refresh cache.php in the background
        fetch('./cache.php', {
                cache: 'reload'
            })
            .then(response => {
                // Success message can be logged here
                console.log('Cache refreshed successfully');
                button.style.background = 'linear-gradient(100deg, #009688, #8BC34A)';
                button.disabled = false;
                location.reload();
            })
            .catch(error => {
                // Error message can be logged here
                console.error('Error refreshing cache: ', error);
                button.style.background = 'linear-gradient(100deg, #009688, #8BC34A)';
                button.disabled = false;
            });
    }
    </script>
    <style>
    @keyframes blink {
        50% {
            opacity: 0;
        }
    }

    .dot-dot-dot::after {
        content: ' ...';
        animation: blink 1s infinite;
    }

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


    .light_red {
        color: red;
    }
    </style>

<body>
    <div id="background">
        <div id="content">

            <div class="table_title " style="top:0">
                <h1 style="background:linear-gradient(100deg,black, orange)">PLANNED SALES MARGIN</h1>
            </div>

            <!--  <table id="products" style="position: sticky;overflow-x:scroll;">
                            <thead style="position:sticky;top:0;z-index:+2">
                                <tr class="head">
                                    <th style="position: sticky;width:100px;left:0px;color:white;padding-left:3px">Code</th>
                                    <th style="position: sticky;width:200px;left:100px;color:white">ItemName</th>
                                    <th style="position: sticky;width:200px;left:300px;color:white">Issue</th>
                                    <th style="width:100px">ItemCode</th>
                                    <th style="width:200px">ItemGroup</th> -->

            <div id="pages_table_container" style="overflow-x:scroll;height:80%;top:0;" class="table_container">
                <table id="new_sales_orders_margin" class="filterable sortable colborders"  style="background:linear-gradient(100deg,black, green)">
                    <thead style="position:sticky;top:0;z-index:+2;background-color:black">
                        <!-- 		LineNum	so_status	PrcrmntMth	Qty Delivered	Cost at Delivery	Delivery Return	Cost at Return	Qty Returned	Sales Value	SO_Original_Cost	Planned_BOM_Cost	Planned Prod Order Cost	Likely Prod Ord Cost	Orig Margin	Planned BOM Margin	Planned Prod Ord Margin	Likely Prod Ord Margin -->

                        <tr class="dark_grey wtext smedium head">
                            <th width="9%">Sales Order</th>
                            <th width="12%">Project</th>
                            <th width="9%">Process Order</th>
                            <th width="12%">Customer </th>
                            <th width="8%">Proj Margin in %</th>
                            <th width="12%">PP Status</th>
                            <th width="18%">Description</th>
                            <th width="10%">Delivery Status</th>
                            <th width="6%">Floor Date</th>
                            <th width="12%">Planned Margin</th>


                          
                            <!-- <th>Dscription</th>
                            <th>Quantity</th>
                            <th>Buy or Make</th>


                            <th>Sub BOMS?</th>
                           

                            <th>BOM Size</th>
                            <th>Total Cost per BOM</th>

                            <th>Material Lines</th>
                            <th>Materail Fully Issued</th>
                            <th>Material Planned Cost</th>
                            <th>Material Issued Cost</th>
                            <th>Sub Con Items</th>
                            <th>Sub Con Items Issued</th>

                            <th>Sub Con Planned Cost</th>
                            <th>Sub Con Issued Cost</th>
                           
                            <th>Labour Planned Hours</th>
                            <th>Act Labour Hours</th>
                            <th>Labour Planned cost</th>
                            <th>Act Labout Cost</th>
                            

                            <th>Machine Planned Hours</th>
                            <th>Act Machine Hours</th>
                            <th>Machine Planned Cost</th>
                            <th>Act Machine Cost</th>
                            <th>Total Planned Prod Cost</th>
                            <th>Materials TBI</th>

                            <th>Sub Con TBI</th>
                            <th>Labour Hours TBI</th>
                            <th>Machine Hours TBI</th>
                            <th>Unissued Mat SC Cost</th>
                            <th>Open Lab Laser Cost</th>
                            <th>Prod Status</th>


                            <th>Qty Made In Prod</th>
                            <th>Del Status</th>
                            <th>Del Qty</th>
                            <th>SO Sales Value EUR</th>
                            <th>Original SO Cost</th>
                            <th>Original SO Margin</th>


                            <th>Planned Cost</th>
                            <th>Projected Cost</th>
                            <th>Planned Margin</th>
                            <th>Floor Date</th>
                            -->



                        </tr>
                    </thead>
                    <tbody class="white">
                        <?php foreach ($sales_margin as $sales_order) : ?>
                        <?php $row_color = ""; ?>
                        <?php $customer = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["cardname"]));         ?>
                        <?php $status = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["PP Status"]));         ?>
                        <?php $project = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["Project"]));           ?>
                        <?php $datecategory = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["DateCategory"]));           ?>
                        <?php $today = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["TD"]));           ?>
                        <?php $yesterday = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["YD"]));           ?>
                        <?php $thisweek = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["TW"]));           ?>
                        <?php $lastweek = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["LW"]));           ?>
                        <?php $thismonth = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["TM"]));           ?>
                        <?php $lastmonth = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["LM"]));           ?>
                        <?php $thisyear = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["TY"]));           ?>
                        <?php //$engineer = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["Engineer"]));         ?>
                        <?php //$sales_person = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $sales_order["Sales Person"])); ?>
                        <?php //$cell_color = $sales_order["Margin"] < 0.5 ? 'light_red' : '';?>
                        <?php if ($sales_order["SO Sales Value EUR"] !=0)number_format(($sales_order["Proj Margin"] / $sales_order["SO Sales Value EUR"]) * 100, 2)< 40? $cell_color_margin='red':$cell_color_margin=''?>
                        <?php //$sales_order["Planned BOM Margin"]<.4 ? $cell_color='light_red':$cell_color=''?>
                        <?php //$sales_order["Planned Prod Ord Margin"]<.4 ? $cell_color_plan='light_red':$cell_color_plan=''?>
                        <?php //$sales_order["Likely Prod Ord Margin"]<.4 ? $cell_color_likely='light_red':$cell_color_likely=''?>

                        <tr style="box-shadow: 0px 0px 8px 0px #607D8B;
    background: linear-gradient(201deg,#9E9E9E, #009688 );"class='smedium btext' status='<?= $status ?>' datecategory='<?= $datecategory ?>'today='<?= $today ?>'yesterday='<?= $yesterday ?>'thisweek='<?= $thisweek ?>'lastweek='<?= $lastweek?>'thismonth='<?= $thismonth ?>'lastmonth='<?= $lastmonth ?>'thisyear='<?= $thisyear ?>'
                            customer='<?= $customer ?>' project='<?= $project ?>' engineer='<?= $engineer ?>'
                            sales_person='<?= $sales_person ?>'>
                            <td class="bold">
    <button class="brred rounded btext medium" onclick="location.href='../../../../../../SAP%20READER/SAP%20READER/BASE_sales_order.php?sales_order=<?= $sales_order['Sales Order'] ?>'">
        <?= $sales_order["Sales Order"] ?>
    </button>
</td>
                            <td class='lefttext'><?= $sales_order["Project"] ?></td>
                            <td calss="bold">
    <button class="brred rounded btext medium" onclick="location.href='../../../../../../SAP%20READER/SAP%20READER/BASE_process_order.php?process_order=<?php echo isset($sales_order['Process Order']) ? $sales_order['Process Order'] : 'NULL'; ?>'">
        <?php echo isset($sales_order['Process Order']) ? $sales_order["Process Order"] : 'NULL'; ?>
    </button>
</td>
                            <td class='lefttext'><?= $sales_order["cardname"] ?></td>
                        <td
                                style="color:<?=$cell_color_margin?>;">
                                <?php
                        if ($sales_order["SO Sales Value EUR"] != 0){
                                 $value = number_format(($sales_order["Proj Margin"] / $sales_order["SO Sales Value EUR"]) * 100, 2);
                                    if ($value < 40) {
                                echo '<span style="color:red;font-weight:bold"> &#x2193;&nbsp;</span>' .  '<span style="font-weight:bold;">' . $value . '%</span>';
                                        } else {
                                    echo $value . '%';
                                                 }
                                    } else {
                                echo 'N/A';
                                    }
                            ?></td>
                          




                            <td><?=$sales_order["PP Status"]?></td>



                          



                    
                           


                            <td class='lefttext'><?= $sales_order["Dscription"] ?></td>

                            <td ><?= $sales_order["Del Status"] ?></td>
                            <td ><?= $sales_order["floor_date"] ?></td>

                            
                            <td ><?= $sales_order["Planned Margin"] ?></td>







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
                                    background: linear-gradient(100deg,#009688, #8BC34A );border-radius:30px"
                                        >UPDATE</button>

                                </div>

                            </div>
                            <div class="filter">
                                <div class="text">
                                    <button class="fill red medium wtext button" style="box-shadow: -2px 0px 8px 0px #607D8B;
                                    background: linear-gradient(100deg,#009688, #8BC34A );">Customer</button>
                                </div>
                                <div class="content">
                                    <select id="select_customer" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <?php generate_filter_options($sales_margin, "cardname"); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="filter">
                                <div class="text">
                                    <button class="fill red medium wtext" style="box-shadow: -2px 0px 8px 0px #607D8B;
                                        background: linear-gradient(100deg,#009688, #8BC34A )">DateCategory</button>
                                </div>
                                <div class="content">
                                    <select id="select_datecategory" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <option value="TD" selected>Today</option>
                                        <option value="YD" selected>Yesterday</option>
                                        <option value="TW" selected>This Week</option>
                                        <option value="LW" selected>Last Week</option>
                                        <option value="TM" selected>This Month</option>
                                        <option value="LM" selected>Last Month</option>
                                        
                                        <option value="TY" selected>Year 2023</option>
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
                                        <?php generate_filter_options($sales_margin, "PP Status"); ?>
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