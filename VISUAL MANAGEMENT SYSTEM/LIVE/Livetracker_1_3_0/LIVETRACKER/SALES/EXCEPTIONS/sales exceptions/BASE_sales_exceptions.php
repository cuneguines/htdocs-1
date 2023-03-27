<!doctype html>
<html>
    <head>
        <!-- INITALISATION AND META STUFF -->
        <meta charset = "utf-8">
        <meta name = "description" content = "meta description">
        <meta name = "viewpport" content = "width=device-width, initial-scale = 1">
        <title>Sales Exceptions</title>

        <!-- EXTERNAL JAVASCRIPT -->
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

        <!-- LOCAL JAVASCRIPT -->
        <script type = "text/javascript" src = "./JS_exceptions_buttons.js"></script>
        <script type = "text/javascript" src = "./JS_table_to_excel.js"></script>

        <!-- STYLING -->
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
        <link rel = "stylesheet" href = "../../../../css/LT_style.css">
        <link rel = "stylesheet" href = "../../../../css/theme.blackice.min.css">
        
        <!-- PHP INIT -->
        <?php include './BASE_SUB_sales_exceptions_counts.php' ?>

        <!-- TABLESORTER SETUP -->
        <script>
            $(function()
            {
                $("table").tablesorter({
                    "theme" : "blackice",
                    "dateFormat" : "ddmmyyyy",
                    "headers" : {
                        7: {sorter : "shortDate"},
                        10: {sorter : "shortDate"},
                        13: {sorter : "shortDate"},
                        14: {sorter : false}
                    }
                });
            });
        </script>
        
    </head>
    <body>
        <div id = 'background'>
            <div id = 'content'>
                <div id = 'grouping_buttons_container'>
                    <div id = 'grouping_buttons' class = 'fw light_grey'>
                        <div id = 'margin'>
                            <div class = "grouping_category">
                                <button class = "quarter medium red wtext rounded-top" stage = 'No-Transport-Charge' status_w = 'two_w'><?php echo $sales_exceptions_counters[NO_TRANSPORT_CHARGE][LATE_TWO_WEEKS];?></button>
                                <button class = "half medium dark_grey wtext" stage = 'No-Transport-Charge' status_w = 'name'>Live With No Transport Chrage</button>
                                <button class = "quarter medium light_blue wtext rounded-bottom" stage = 'No-Transport-Charge' status_w = 'four_w'><?php echo $sales_exceptions_counters[NO_TRANSPORT_CHARGE][LATE_FOUR_WEEKS];?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "quarter medium red wtext rounded-top" stage = 'Delivery-Address-Not-Complete' status_w = 'two_w'><?php echo $sales_exceptions_counters[NO_DEL_ADD][LATE_TWO_WEEKS];?></button>
                                <button class = "half medium dark_grey wtext" stage = 'Delivery-Address-Not-Complete' status_w = 'name'>Live With No Delivery Address</button>
                                <button class = "quarter medium light_blue wtext rounded-bottom" stage = 'Delivery-Address-Not-Complete' status_w = 'four_w'><?php echo $sales_exceptions_counters[NO_DEL_ADD][LATE_FOUR_WEEKS];?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "quarter medium red wtext rounded-top" stage = 'Accounts-On-Hold' status_w = 'two_w'><?php echo $sales_exceptions_counters[ACCOUNT_ON_HOLD][LATE_TWO_WEEKS];?></button>
                                <button class = "half medium dark_grey wtext" stage = 'Accounts-On-Hold' status_w = 'name'>Live With Accounts On Hold</button>
                                <button class = "quarter medium light_blue wtext rounded-bottom" stage = 'Accounts-On-Hold' status_w = 'four_w'><?php echo $sales_exceptions_counters[ACCOUNT_ON_HOLD][LATE_FOUR_WEEKS];?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "quarter medium red wtext rounded-top" stage = 'Cleared-To-Invoice' status_w = 'two_w'><?php echo $sales_exceptions_counters[NOT_CLEARED_FOR_INVOICE][LATE_TWO_WEEKS];?></button>
                                <button class = "half medium dark_grey wtext" stage = 'Cleared-To-Invoice' status_w = 'name'>Not Cleared For Invoice</button>
                                <button class = "quarter medium light_blue wtext rounded-bottom" stage = 'Cleared-To-Invoice' status_w = 'four_w'><?php echo $sales_exceptions_counters[NOT_CLEARED_FOR_INVOICE][LATE_FOUR_WEEKS];?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "quarter medium red wtext rounded-top" stage = "All">0</button>
                                <button class = "half medium dark_grey wtext" stage = "All">STAGE NAME</button>
                                <button class = "quarter medium light_blue wtext rounded-bottom" stage = "All">0</button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "quarter medium red wtext rounded-top" stage = "All">0</button>
                                <button class = "half medium dark_grey wtext" stage = "All">STAGE NAME</button>
                                <button class = "quarter medium light_blue wtext rounded-bottom" stage = "All">0</button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "quarter medium red wtext rounded-top" stage = "All">0</button>
                                <button class = "half medium dark_grey wtext" stage = "All">STAGE NAME</button>
                                <button class = "quarter medium light_blue wtext rounded-bottom" stage = "All">0</button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "quarter medium red wtext rounded-top" stage = "All">0</button>
                                <button class = "half medium dark_grey wtext" stage = "All">STAGE NAME</button>
                                <button class = "quarter medium light_blue wtext rounded-bottom" stage = "All">0</button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "quarter medium red wtext rounded-top" stage = "All">0</button>
                                <button class = "half medium dark_grey wtext" stage = "All">STAGE NAME</button>
                                <button class = "quarter medium light_blue wtext rounded-bottom" stage = "All">0</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "table_title green" id = "grouping_table_title">
                    <h1>SALES EXCEPTIONS<h1>
                </div>
                <div id = 'grouping_table_container' class = 'table_container' style = 'overflow-y:scroll;'>
                    <table id = "sales_exceptions" class = "filerable">
                        <thead>
                            <tr class = "dark_grey smedium">
                                <th width = "5%">Sales Order</th>
                                <th width = "10%">Customer</th>
                                <th width = "10%">Promise Date</th>
                                <th width = "20%">Delivary Address</th>
                                <th width = "10%">Sales Person</th>
                                <th width = "10%">Engineer</th>
                                <th width = "5%">Transport Charge</th>
                                <th width = "5%">Account Status</th>
                                <th width = "5%">SO Clear to Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php   foreach($results as $row) : ?>
                                <?php
                                    $stage = array();
                                    $two_w = 'N';
                                    $four_w = 'N';
                                    if($row["Transport Charge"] == null){
                                        array_push($stage, "No-Transport-Charge");
                                    }
                                    if($row["Delivery Address Complete"] != 'Y'){
                                        array_push($stage, "Delivery-Address-Not-Complete");
                                    }
                                    if($row["Account Status"] == "ON HOLD"){
                                        array_push($stage, "Accounts-On-Hold");
                                    }
                                    /* if($row["Cleared to Invoice"] == "No"){
                                        //array_push($stage, "Cleared-To-Invoice");
                                    }*/
                                    

                                    if($row["Weeks Overdue_2"] > 0){
                                        $two_w = 'Y';
                                    }
                                    if($row["Weeks Overdue_4"] > 0){
                                        $four_w = 'Y';
                                    }

                                  /*   if($row["Score"] == 4){
                                        $str = "style = 'background-color:#FF4D4D'";
                                    }
                                    else if($row["Score"] == 3){
                                        $str = "style = 'background-color:#FF8C00'";
                                    }
                                    else if($row["Score"] == 0){
                                        $str = "style = 'background-color:#99FF99'";
                                    }
                                    else{
                                        $str = "";
                                    }  */
                                    $str = "";
                                ?>
                                <tr <?=$str?> stage = '<?=implode(", ",$stage)?>' class = "row white btext smedium" two_w = '<?=$two_w?>' four_w = '<?=$four_w?>' name = 'Y'>
                                    <td><?=$row["Sales Order"]?></td>
                                    <td class = 'lefttext'><?=$row["Customer"]?></td>
                                    <td><?=$row["Promise Date"]?></td>
                                    <td class = 'lefttext'><?=$row["Delivery Address"]?></td>
                                    <td><?=$row["Sales Person"]?></td>
                                    <td><?=$row["Engineer"]?></td>
                                    <td class = 'lefttext'><?=(($row["Transport Charge"] == null) ? "NO CHARGE" : "€".$row["Transport Charge"])?></td>
                                    <td><?=$row["Account Status"]?></td>
                                    <td><?//$row["Cleared to Invoice"]?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div id = "grouping_pages_footer" class = "footer">
                    <div id = "button_container">
                        <button onclick = "location.href='../../../MAIN MENU/dashboard_menu.php'" class = "grouping_page_corner_buttons fill medium light_blue wtext rounded">MAIN MENU</button>
                    </div>
                    <div id = "filter_container">
                        <div id = "filters" class="fill red rounded">
                            <div class = "filter wider">
                                <div class = "text">
                                    <button class = "fill red medium wtext">UNUSED</button>
                                </div>
                                <div class = "content">
                                    <select class = "selector fill medium">
                                        <option value = "All" selected>All</option>
                                    </select>
                                </div>
                            </div>
                            <div class = "filter wider">
                                <div class = "text">
                                    <button class = "fill red medium wtext">UNUSED</button>
                                </div>
                                <div class = "content">
                                    <select class = "selector fill medium">
                                        <option value = "All" selected>All</option>
                                    </select>
                                </div>
                            </div>
                            <div class = "filter wider">
                                <div class = "text">
                                    <button class = "fill red medium wtext">UNUSED</button>
                                </div>
                                <div class = "content">
                                    <select class = "selector fill medium">
                                        <option value = "All" selected>All</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id = "button_container">
                        <button onclick = "export_to_excel('sales_exceptions')" class = "grouping_page_corner_buttons fill medium green wtext rounded">EXCEL</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>