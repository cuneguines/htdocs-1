<!DOCTYPE html>
<html>
    <head>
        <!-- INITALISATION AND META STUFF -->
        <title>TABLE LAYOUT</title>
        <meta charset = "utf-8">
        <meta name = "viewpport" content = "width=device-width, initial-scale = 1">

        <!-- EXTERNAL JAVASCRIPT -->
        <script type = "text/javascript" src = "../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
        <script type = "text/javascript" src = "../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
        <script type = "text/javascript" src = "../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>
        
        <!-- LOCAL JAVASCRIPT -->
        <script type = "text/javascript" src = "../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/JS LIBS/LOCAL/JS_comments.js"></script>
        <script type = "text/javascript" src = "../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/JS LIBS/LOCAL/JS_filters.js"></script>
        <script type = "text/javascript" src = "../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/JS LIBS/LOCAL/JS_search_table.js"></script>
		<script type = "text/javascript" src = "./JS_condition_splits.js"></script>
        <script type = "text/javascript" src = "./JS_table_to_excel.js"></script>

        <!-- STYLING -->
        <link rel = "stylesheet" href = "../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/CSS/LT_STYLE.css">
        <link rel = "stylesheet" href = "../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/css/theme.blackice.min.css">	
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>   

        <!-- PHP INITALISATION -->
       
        
        <?php //include '../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/PHP LIBS/PHP FUNCTIONS/php_functions.php'; ?>
        <?php include "../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/PHP LIBS/PHP FUNCTIONS/php_functions.php"?>
        <?php include '../VISUAL MANAGEMENT SYSTEM/LIVE/Livetracker_1_3_0/SQL CONNECTIONS/conn.php'; ?>
		<?php include './SQL_process_count.php'; ?>
        <?php $results = get_sap_data($conn, $results, DEFAULT_DATA);?>
        <?php $results_1 = get_sap_data($conn, $results_1, DEFAULT_DATA);?>

        <!-- TABLESORTER INITALISATION -->
        <script>
            $(function(){
                $("table.sortable").tablesorter({
                    "theme" : "blackice",
                    "dateFormat" : "ddmmyyyy",
                    "headers" : {
                        7: {sorter : "shortDate"},
                        8: {sorter : "shortDate"},
                        9: {sorter : "shortDate"},
                        14: {sorter : "shortDate"},
                        19: {sorter : "shortDate"}
                    }
                });
            });
        </script>
    </head>
    <body>
        
        <div id = "background" style="float:left;width:50%">
            <div id = "content">
                <div class = "table_title green">
                    <h1>PROCESS ORDER OPENED</h1>
                </div>
                <div id = "pages_table_container" class = "table_container" style = "overflow-y:scroll">
                    <table style="background-color:white;padding:3%"id = "intel_pedestal_production" class = "filterable sortable searchable">
                        <thead>
                            <tr style="font-size:larger"class = "dark_grey wtext small head">
                                <th width = "33.3%" >Year</th>
                                <th width = "33.3%" >Month</th>
                                <th width = "33.%" >Process Order Opened</th>
                                
                                
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php foreach($results as $row) : ?>
                            
                            
                           
                            <?php //$status = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Month"])); ?>
                            <?php //$fabricator = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Fabricator"])); ?>

                                <tr style="padding:3%"class = 'btext smallplus <?=$rowcolor?>' status = '<?=$status?>' fabricator = '<?=$fabricator?>' ntk = '<?=$ntk?>' style = 'height:30px;'>
                                    
                                    <td><?=$row["Year"]?></td>
                                    
                                    <td><?=$row["Month"]?></td>
                                    <td><?=$row["Process Orders Opened"]?></td>
                                  
                                </tr>
                                
                            <?php endforeach; ?>
                    </tbody>
                    </table>
                </div>
                <div id = "table_pages_footer" class = "footer" style="width:47%;">
                    <div id = "top">
                        <div id = "filter_container">
                            <div id = "filters" class = "red fill rounded" style="background-color:#8bc34a">
                                <div class = "filter">
                                    <div class = "text">
                                        <button style="background-color:#8bc34a"class = "fill red medium wtext">Status</button>
                                    </div>
                                    <div class = "content">
                                        <select disabled id = "select_status" class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                            <?php generate_filter_options($results, "Month"); ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class = "filter">
                                    <div class = "text">
                                        <button style="background-color:#8bc34a"class = "fill red medium wtext">Seach Table</button>
                                    </div>
                                    <div class = "content">
                                        <input class = "medium" id = "employee" type = "text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id = "bottom">                        
                        <div id = "button_container">
                            <button class = "grouping_page_corner_buttons fill medium light_blue wtext rounded">UNUSED <?php //round(($total_executed/$total_planned)*100,2);?></button> 
                        </div>
                        <div id = "button_container_wide">
                            <button onclick = "location.href='../../../MAIN MENU/dashboard_menu.php'" class = "grouping_page_corner_buttons fill medium purple wtext rounded">MAIN MENU</button>
                        </div>
                        <div id = "button_container">
                            <button onclick = "export_to_excel('intel_pedestal_production')" class = "grouping_page_corner_buttons fill medium green wtext rounded">EXPORT</button>
                        </div>
                    </div>
                </div>
            </div>
                        </div>
       
        <div id = "background">
            <div id = "content">
                <div class = "table_title green">
                    <h1>PROCESS ORDER DELIVERED</h1>
                </div>
                <div id = "pages_table_container" class = "table_container" style = "overflow-y:scroll">
                    <table style="background-color:white"id = "intel_pedestal_production" class = "filterable sortable searchable">
                        <thead>
                            <tr style="font-size:larger"class = "dark_grey wtext small head">
                                <th width = "33.3%" >Year</th>
                                <th width = "33.3%" >Month</th>
                                <th width = "33.%" >Process Order Delivered</th>
                                
                                
                            </tr>
                        </thead>
                        <tbody>
                        
                        <?php foreach($results_1 as $row) : ?>
                            
                            
                           
                            <?php //$status = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Status"])); ?>
                            <?php //$fabricator = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Fabricator"])); ?>

                                <tr style="padding:3%"class = 'btext smallplus <?=$rowcolor?>' status = '<?=$status?>' fabricator = '<?=$fabricator?>' ntk = '<?=$ntk?>' style = 'height:30px;'>
                                    
                                    <td><?=$row["Year"]?></td>
                                   
                                    <td><?=$row["Month"]?></td>
                                    <td><?=$row["Process Orders Delivered"]?></td>
                                  
                                </tr>
                                
                            <?php endforeach; ?>
                    </tbody>
                    </table>
                </div>
                <div id = "table_pages_footer" class = "footer" style="width:47%">
                    <div id = "top">
                        <div id = "filter_container">
                            <div id = "filters" style="background-color:#8bc34a"class = "red fill rounded">
                                <div class = "filter">
                                    <div class = "text">
                                        <button disabled style="background-color:#8bc34a"class = "fill red medium wtext">Status</button>
                                    </div>
                                    <div class = "content">
                                        <select disabled id = "select_status" class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                            <?php generate_filter_options($results, "Month"); ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class = "filter">
                                    <div class = "text">
                                        <button  style="background-color:#8bc34a"class = "fill red medium wtext">Seach Table</button>
                                    </div>
                                    <div class = "content">
                                        <input class = "medium" id = "employee" type = "text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id = "bottom">                        
                        <div id = "button_container">
                            <button class = "grouping_page_corner_buttons fill medium light_blue wtext rounded">UNUSSED <?php //round(($total_executed/$total_planned)*100,2);?></button>
                        </div>
                        <div id = "button_container_wide">
                            <button onclick = "location.href='../../../MAIN MENU/dashboard_menu.php'" class = "grouping_page_corner_buttons fill medium purple wtext rounded">MAIN MENU</button>
                        </div>
                        <div id = "button_container">
                            <button onclick = "export_to_excel('intel_pedestal_production')" class = "grouping_page_corner_buttons fill medium green wtext rounded">EXPORT</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>