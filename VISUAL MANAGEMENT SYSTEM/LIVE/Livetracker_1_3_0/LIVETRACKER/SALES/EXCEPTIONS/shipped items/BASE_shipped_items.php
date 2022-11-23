<!DOCTYPE html>
<html>
    <head>
        <!-- INITALISATION AND META STUFF -->
        <title>SHIPPING</title>
        <meta name = "viewpport" content = "width=device-width, initial-scale = 1">

        <!-- EXTERNAL JAVASCRIPT -->
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

        <!-- LOCAL JAVASCRIPT -->
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_filters.js"></script>
        <script type = "text/javascript" src = "./JS_exceptions_buttons.js"></script>
        <script type = "text/javascript" src = "./JS_comments.js"></script>
        <script type = "text/javascript" src = "./JS_table_to_excel.js"></script>

        <!-- STYLING -->
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
        <link href='../../../../CSS/LT_STYLE.css' rel='stylesheet' type='text/css'>
        <link rel = "stylesheet" href = "../../../../css/theme.blackice.min.css">

        <!-- PHP INIT -->
        <?php   include '../../../../PHP LIBS/PHP FUNCTIONS/php_functions.php'; ?>
        <?php   include '../../../../SQL CONNECTIONS/conn.php'; ?>
        <?php   include './SQL_shipped_items.php'; ?>
        <?php
            $getResults = $conn->prepare($shippeditems);
            $getResults->execute();
            $shipped_exceptions_results = $getResults->fetchAll(PDO::FETCH_BOTH);
        ?>

        <!-- TABLESORTER INITALISATION -->
        <script>
            $(function() {
                $("table").tablesorter({
                    "theme" : "blackice",
                    "dateFormat" : "ddmmyyyy",
                    "headers" : {
                        0: {sorter : "shortDate"},
                        9: {sorter : "shortDate"},
                        13: {sorter : false},
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
                                <button class = "fill medium red wtext rounded" stage = "All">Everything</button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "fill medium red wtext rounded" stage = "today">Today<br><br><?php echo date("d/m/y")?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "fill medium red wtext rounded" stage = "past_day">Past Day<br><br><?php echo date("d/m/y", strtotime("yesterday"));?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "fill medium red wtext rounded" stage = "three_days">Past 3 Days<br><br><?php echo date("d/m/y",strtotime("-3 days"));?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "fill medium red wtext rounded" stage = "five_days">Past 5 Days<br><br><?php echo date("d/m/y",strtotime("-5 days"))?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "fill medium red wtext rounded" stage = "ten_days">Past 10 Days<br><br><?php echo date("d/m/y",strtotime("-10 days"))?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "fill medium red wtext rounded" stage = "thirty_days">Past 31 Days<br><br><?php echo date("d/m/y",strtotime("-31 days"))?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "fill medium red wtext rounded" stage = "All">All</button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "fill medium red wtext rounded" stage = "All">All</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "table_title green" id = "grouping_table_title">
                    <h1>SHIPPED<h1>
                </div>
                <div id = 'grouping_table_container' class = 'table_container' style = "overflow-y:scroll;">
                    <table id = "shipping" class = "filterable">
                        <thead>
                            <tr class = "dark_grey wtext smedium head">
                                <th width = "5%" >Date Shipped</th>
                                <th width = "2%" >Days</th>
                                <th width = "12%">Customer</th>
                                <th width = "10%">Project</th>
                                <th width = "6%" >Sales Person</th>
                                <th width = "5%" >Sales Order</th>
                                <th width = "15%">Description</th>
                                <th width = "4%" >Shipped</th>
                                <th width = "4%" >Remaining</th>
                                <th width = "4%" >Promise Date</th>
                                <th width = "4%" >Docket No.</th>
                                <th width = "16%">Delivery Address</th>
                                <th width = "8%" >Site Contact</th>
                                <th width = "4%" >SO<br>Comms</th>
                                <th width = "4%" >DL<br>Comms</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  foreach($shipped_exceptions_results as $row): ?>
                            <?php
                                $days =$row["Days_Open"];
                                
                                
                                if($row["Days_Open"] == 1)
                                {
                                    $stage = "past_day";

                                }
                                if($row["Days_Open"] > 1 || $row["Days_Open"] <= 3)
                                {
                                    $stage = "three";     
                                }

                                if($row["Days_Open"] > 3 || $row["Days_Open"] <= 5)
                                {
                                    $stage = "five";    
                                }
                                if($row["Days_Open"] > 5 || $row["Days_Open"] <= 10)
                                {
                                    $stage = "ten";    
                                } 
                                if($row["Days_Open"] > 10 || $row["Days_Open"] <= 20)
                                {
                                    $stage = "thirty";
                                }
                            ?>
                            <?php $sales_person = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Sales Person"])); ?>
                            <?php $site_contact = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Site Contact"])); ?>
                            <?php $project = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Project"])); ?>

                            <tr sales_person = '<?=$sales_person?>' site_contact = '<?=$site_contact?>' project = '<?=$project?>' daysopen = '<?=$days?>' stage = '<?=$stage?>' class = 'white btext'>  
                                <td><?=$row["Date Shipped"]?></td>
                                <td class = 'delivery_note_days_open'><?=$row["Days_Open"]?></td>
                                <td class = 'lefttext'><?=$row["Customer"]?></td>
                                <td class = 'lefttext'><?=$row["Project"]?></td>
                                <td><?=$row["Sales Person"]?></td>
                                <td><?=$row["Sales Order"]?></td>
                                <td class = 'lefttext'><?=$row["Dscription"]?></td>
                                <td><?=$row["Qty Shipped"]?></td>
                                <td><?=$row["Qty Remaining"]?></td>
                                <td><?=$row["Promise Date"]?></td>
                                <td><?=$row["Docket No"]?></td>
                                <td class = 'lefttext'><?=$row["Delivery Address"]?></td>
                                <td><?=$row["Site Contact"]?></td>
                                <td><button class = 'comment_button <?= $row["Comments_SO"] != null ? 'has_comment' : ''?>' comments = '<?= $row["Comments_SO"] == null ? "NO COMMENTS" : $row["Comments_SO"]?>'></button></td>  
                                <td><button class = 'comment_button <?= $row["Comments_DLN"] != null ? 'has_comment' : ''?>' comments = '<?= $row["Comments_DLN"] == null ? "NO COMMENTS" : $row["Comments_DLN"]?>'></button></td>  
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
                                    <button class = "fill red medium wtext">Salesperson</button>
                                </div>
                                <div class = "content">
                                    <select id = "select_sales_person" class = "selector fill medium">
                                        <option value = "All" selected>All</option>
                                        <?php generate_filter_options($shipped_exceptions_results, 'Sales Person'); ?>
                                    </select>
                                </div>
                            </div>
                            <div class = "filter wider">
                                <div class = "text">
                                    <button class = "fill red medium wtext">Site Contact</button>
                                </div>
                                <div class = "content">
                                    <select id = "select_site_contact" class = "selector fill medium">
                                        <option value = "All" selected>All</option>
                                        <?php generate_filter_options($shipped_exceptions_results, 'Site Contact'); ?>
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
                                        <?php generate_filter_options($shipped_exceptions_results, 'Project');?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id = "button_container">
                    <button style=width:40% onclick = "" class = "reset_buttons fill medium grey rtext rounded">RESET</button>
                        <button style=width:40% onclick = "export_to_excel('shipping')" class = "grouping_page_corner_buttons fill medium green wtext rounded">EXPORT</button>
                        
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>