<!DOCTYPE html>
<html>
    <head>
        <!-- INITALISATION AND META STUFF -->
        <title>BOOKOUT GROUPING LIST</title>
        <meta name = "viewpport" content = "width=device-width, initial-scale = 1">

        <!-- EXTERNAL JAVASCRIPT -->
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

        <!-- LOCAL JAVASCRIPT -->
        <script type = "text/javascript" src = "./JS_filters.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_search_table.js"></script>
        <script type = "text/javascript" src = "./JS_exceptions_buttons.js"></script>
        <script type = "text/javascript" src = "./JS_table_to_excel.js"></script>

        <!-- STYLING -->
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
        <link rel = "stylesheet" href = "../../../../css/theme.blackice.min.css">
        <link href='../../../..//CSS/LT_STYLE.css' rel='stylesheet' type='text/css'>

        <!-- PHP INIT -->
        <?php include './SQL_bookout.php'; ?>
        <?php include '../../../../SQL CONNECTIONS/conn.php'; ?>
        <?php include '../../../../PHP LIBS/PHP FUNCTIONS/php_functions.php'; ?>
        <?php
            $getResults = $conn->prepare($bookout);                      
            $getResults->execute();                    
            $bookout_list_data = $getResults->fetchAll(PDO::FETCH_BOTH);
        ?>

        <!-- TABLESORTER INITALISATION -->
        <script>
            $(function() {
                $("table").tablesorter({
                    "theme" : "blackice",
                    "dateFormat" : "ddmmyyyy",
                    "headers" : {
                        10: {sorter : "shortDate"},
                        11: {sorter : "shortDate"},
                        12: {sorter : false}
                    }
                });
            });
        </script>
    </head>
    <body>
        <div id = 'background'>
            <div id = 'content'>
                <div id = 'grouping_buttons_container'>
                    <div id = 'grouping_buttons' class = 'book_out_left light_grey'>
                        <div id = 'H20'>
                            <div class = "content">
                                <input placeholder = "Search table" class = "medium" id = "employee" type = "text">
                            </div>   
                        </div>
                        <div id = 'H80' class = 'b'>
                            <div class = 'book_out_groupings_button_holder'>
                                <button class = "fill red rounded wtext medium" stage = "expired">Overdue</button>
                            </div>
                            <div class = 'book_out_groupings_button_holder'>
                                <button class = "fill red rounded wtext medium" stage = "not_booked_in">Not Booked In</button>
                            </div>
                            <div class = 'book_out_groupings_button_holder'>
                                <button class = "fill red rounded wtext medium" stage = "All">Reset</button>
                            </div>
                        </div>
                    </div><!--
                 --><div id = 'grouping_buttons' class = 'book_out_middle light_grey'>
                        <div id = 'H20' class = 'btext'>
                            <h1>Booked In</h1>  
                        </div>
                        <div id = 'H80'>
                            <div class = 'book_out_groupings_button_holder'>
                                <button class = "fill red rounded wtext medium" stage = "booked_in_this_year">This Year</button>
                            </div><!--
                         --><div class = 'book_out_groupings_button_holder'>
                                <button class = "fill red rounded wtext medium" stage = "booked_in_this_month">This Month</button>
                            </div><!--
                         --><div class = 'book_out_groupings_button_holder'>
                                <button class = "fill red rounded wtext medium" stage = "booked_in_this_week">This Week</button>
                            </div><!--
                         --><div class = 'book_out_groupings_button_holder'>
                                <button class = "fill red rounded wtext medium" stage = "booked_in_today">Today</button>
                            </div><!--
                         --><div class = 'book_out_groupings_button_holder'>
                                <button class = "fill red rounded wtext medium" stage = "booked_in_all">All</button>
                            </div><!--
                         --><div class = 'book_out_groupings_button_holder'>
                                <button class = "fill red rounded wtext medium" stage = "booked_in_last_month">Last Month</button>
                            </div><!--
                         --><div class = 'book_out_groupings_button_holder'>
                                <button class = "fill red rounded wtext medium" stage = "booked_in_last_week">Last Week</button>
                            </div><!--
                         --><div class = 'book_out_groupings_button_holder'>
                                <button class = "fill red rounded wtext medium" stage = "booked_in_yesterday">Yesterday</button>
                            </div> 
                        </div>
                    </div><!--
                 --><div id = 'grouping_buttons' class = 'book_out_right light_grey'>
                        <div id = 'H20' class = 'btext'>
                            <h1>Promise Date</h1>  
                        </div>
                        <div id = 'H80'>
                            <div class = 'book_out_groupings_button_holder'>
                                <button class = "fill red rounded wtext medium" stage = "due_this_year">This Year</button>
                            </div><!--
                         --><div class = 'book_out_groupings_button_holder'>
                                <button class = "fill red rounded wtext medium" stage = "due_this_month">This Month</button>
                            </div><!--
                         --><div class = 'book_out_groupings_button_holder'>
                                <button class = "fill red rounded wtext medium" stage = "due_this_week">This Week</button>
                            </div><!--
                         --><div class = 'book_out_groupings_button_holder'>
                                <button class = "fill red rounded wtext medium" stage = "due_today">Today</button>
                            </div><!--
                         --><div class = 'book_out_groupings_button_holder'>
                                <button class = "fill red rounded wtext medium" stage = "due_all">All</button>
                            </div><!--
                         --><div class = 'book_out_groupings_button_holder'>
                                <button class = "fill red rounded wtext medium" stage = "due_next_month">Next Month</button>
                            </div><!--
                         --><div class = 'book_out_groupings_button_holder'>
                                <button class = "fill red rounded wtext medium" stage = "due_next_week">Next Week</button>
                            </div><!--
                         --><div class = 'book_out_groupings_button_holder'>
                                <button class = "fill red rounded wtext medium" stage = "due_tomorrow">Tomorrow</button>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class = "table_title green" id = "grouping_table_title">
                    <h1>BOOK OUT LIST<h1>
                </div>
                <div id = 'grouping_table_container' class = 'table_container' style = "overflow-y:scroll;">
                    <table id = "bookout_list" class = "filterable searchable">
                        <thead>
                            <tr class = "dark_grey wtext smedium">
                                <th width = "3%">PO</th>
                                <th width = "3%">SO</th>
                                <th width = "3%">SRC</th>
                                <th width = "5%">Item Code</th>
                                <th width = "10%">Item Name</th>
                                <th width = "2.4%">On<br> Order</th>
                                <th width = "2.4%">In<br>Stock</th>
                                <th width = "2.4%">Del<br>Qty</th>
                                <th width = "2.4%">Req</th>
                                <th width = "2.4%">Bkd In</th>
                                <th width = "6%">Date Booked In</th>
                                <th width = "6%">Promise Date</th>
                                <th width = "6%">Del Date</th>
                                <th width = "3%">Location</th>
                                <th width = "6%">Bkd User</th>
                                <th width = "6%">Sales Person</th>
                                <th width = "6%">Engineer</th>
                                <th width = "5%">Project</th>
                                <th width = "10%">Ship To</th>
                                <th width = "10%">Customer</th>
                            </tr>
                        </thead>
                        <tbody class = 'white btext smedium'>
                        <?php foreach($bookout_list_data as $row): ?>

                            <?php $sales_order = $row["Sales Order"]; ?>
                            <?php $customer = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Customer"])); ?>
                            <?php $sales_person = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Sales Person"])); ?>
                            <?php $engineer = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Engineer"])); ?>
                            <?php $project = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Project"])); ?>

                            <tr class = 'active_in_selection' project = '<?=$project?>'sales_order = '<?=$sales_order?>' sales_person = '<?=$sales_person?>' engineer = '<?=$engineer?>' customer = '<?=$customer?>' nbi = '<?=$row["Not Booked In"]?>' exp = '<?=$row["Due Date Passed"]?>' booked_in_today = '<?=$row["BI TD"]?>' booked_in_yesterday = '<?=$row["BI YD"]?>' booked_in_this_week = '<?=$row["BI TW"]?>' booked_in_last_week = '<?=$row["BI LW"]?>' booked_in_this_month = '<?=$row["BI TM"]?>' booked_in_last_month = '<?=$row["BI LM"]?>' booked_in_this_year = '<?=$row["BI TY"]?>' booked_in_all = '<?=$row["BI ALL"]?>' due_today = '<?=$row["DEL TD"]?>' due_tomorrow = '<?=$row["DEL ND"]?>' due_this_week = '<?=$row["DEL TW"]?>' due_next_week = '<?=$row["DEL NW"]?>' due_this_month = '<?=$row["DEL TM"]?>' due_next_month = '<?=$row["DEL NM"]?>' due_this_year = '<?=$row["DEL TY"]?>' due_all = '<?=$row["DEL ALL"]?>'>
                                <td><?=$row["Producrion Order"]?></td>
                                <td><?=$row["Sales Order"]?></td>
                                <td><?=($row["Source"] == 'Made' ? "M" : "BI")?></td>
                                <td><?=$row["Item Code"]?></td>
                                <td class = "lefttext"><?=$row["Item Name"]?></td>
                                <td style = 'background-color:#E8E8E8'><?=$row["Qty On Order"]?></td>
                                <td style = 'background-color:#E8E8E8'><?=$row["In Stock"]?></td>
                                <td style = 'background-color:#E8E8E8'><?=$row["DelivrdQty"]?></td>
                                <td <?=($row["Qty Required"] > 0 ? "style = 'background-color:#ff7a7a'" : "style = 'background-color:#99ff99'")?>><?=$row["Qty Required"]?></td>
                                <td style = 'background-color:#E8E8E8'><?=($row["Booked In"] == null ? "N/A" : $row["Booked In"])?></td>
                                <td><?=($row["Date Booked In"] == null ? "NOT BKD IN" : $row["Date Booked In"])?></td>
                                <td><?=$row["Promise Date"]?></td>
                                <td><?=$row["Due Date"]?></td>
                                <td><?=$row["Location"]?></td>
                                <td><?=($row["User"] == null ? "N/A" : $row["User"])?></td>
                                <td><?=$row["Sales Person"]?></td>
                                <td><?=$row["Engineer"]?></td>
                                <td><?=$row["Project"]?></td>
                                <td class = 'lefttext'><?=$row["Ship_To"]?></td>
                                <td class = 'lefttext'><?=$row["Customer"]?></td>
                            </tr>
                            <?php $str = ''; ?>
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
                                    <button class = "fill red medium wtext">Customer</button>
                                </div>
                                <div class = "content">
                                    <select id = "select_customer" class = "selector fill medium">
                                        <option value = "All" selected>All</option>
                                        <?php generate_filter_options($bookout_list_data, "Customer")?>
                                    </select>
                                </div>
                            </div>
                            <div class = "filter wider">
                                <div class = "text">
                                    <button class = "fill red medium wtext">Salesperson</button>
                                </div>
                                <div class = "content">
                                    <select id = "select_sales_person" class = "selector fill medium">
                                        <option value = "All" selected>All</option>
                                        <?php generate_filter_options($bookout_list_data, "Sales Person")?>
                                    </select>
                                </div>
                            </div>
                            <div class = "filter wider">
                                <div class = "text">
                                    <button class = "fill red medium wtext">Project</button>
                                </div>
                                <div class = "content">
                                    <select id = "select_project" class = "selector fill medium">
                                        <option value = "All" selected>All</option>
                                        <?php generate_filter_options($bookout_list_data, "Project")?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id = "button_container">
                        <button onclick = "export_to_excel('bookout_list')" class = "grouping_page_corner_buttons fill medium green wtext rounded">EXCEL</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>