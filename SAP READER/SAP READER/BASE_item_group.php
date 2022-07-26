<?php
    // CHECK FROM $_POST (SEARCH ON FRONT) IF NOT CHECK FROM $_GET (PO BUTTON ON SALES ORDER) OTHERWISE KILL PAGE AND PRINT ERROR 
    //isset($_POST['tags']) ? $customer = $_POST['tags'] : $customer = $_GET['cust'];
    
    if(isset($_POST['item_group'])){
        $item_group = $_POST['item_group']; 
    }
    else{
        echo"TEST";die();
    }
    if(!$item_group){
        echo "<h1 class = 'black'>No Item Group Selected</h1><button onclick = 'history.back();'>Back</button>"; die();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- META STUFF -->
        <title><?=$item_group?></title>
		<meta charset = "utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name = "viewport" content = "width=device-width, initial-scale = 1">

        <!-- STYLEING -->
		<link rel = "stylesheet" href = "./LT_STYLE.css">
        <link rel = "stylesheet" href = "./theme.blackice.min.css">											
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

        <!-- JS FILES -->
        <script type = "text/javascript" src = "./jquery-3.4.1.js"></script>
        <script type = "text/javascript" src = "./JS_filters.js"></script>
        <script type = "text/javascript" src = "./JS_search_table.js"></script>
        <script type = "text/javascript" src = "./jquery.tablesorter.js"></script>
        
        <!-- PHP FUNCTIONS -->
        <?php date_default_timezone_set('Europe/London'); ?>
        <?php 
            include './conn.php';      
            include './SQL_SAP_READER.php';
            include './php_functions.php';
            include './php_constants.php';
        ?>
        <?php 
            $item_group_header_data = get_sap_data($conn,$sql_item_group_header,DEFAULT_DATA);
            $item_group_content_data = get_sap_data($conn,$sql_item_group_content,DEFAULT_DATA);
            if(!$item_group_header_data){
            echo "<h1 class = 'black'>Cannot Find Sales Order</h1>"; die();
            }
        ?>

        <script>
            $(function(){
                $("table.sortable").tablesorter({
                    "theme" : "blackice",
                    "dateFormat" : "ddmmyyyy",
                    "headers" : {
                    }
                });
            });
        </script>
    </head>
    <body id = "sap_viewer">
        <div id = "background">
            <div id = "content">
                <div class = "header">
                    <div class = "light_grey headerbox left">
                        <div class = "title green large"><h1 class = "large"></h1></div>
                        <div class = "content">
                            <div class = "subdiv left" style = "width:46%;">
                            </div>
                            <div class = "subdiv right" style = "width:52%;">
                            </div>
                        </div>
                    </div>
                    <div class = "light_grey headerbox left">
                        <div class = "title green large"><h1 class = "large"></h1></div>
                        <div class = "content">
                            <div class = "subdiv left" style = "width:40%;">   
                            </div>
                            <div class = "subdiv right" style = "width:58%;">       
                            </div>
                        </div>
                    </div>
                    <div class = "center green">
                        <h1 style = "margin-top:10%;"><?=$item_group_header_data[0]["ItmsGrpNam"]?></h1>
                    </div>
                    <div class = "light_grey headerbox right">
                        <div class = "title green large"><h1 class = "large"></h1></div>
                        <div class = "content">
                            <div class = "subdiv left" style = "width:54%;">
                            </div>
                            <div class = "subdiv right" style = "width:44%;">
                            </div>
                        </div>
                    </div>
                    <div class = "light_grey headerbox right">
                        <div class = "title green large"><h1 class = "large"></h1></div>
                        <div class = "content">
                            <div class = "subdiv left" style = "width:48%;">              
                            </div>
                            <div class = "subdiv right" style = "width:50%;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "tables_container">
                    <div id = "pages_table_container" class = "table_container" style = "top:0%;">
                        <table id = "sap_reader" class = "filterable sortable searchable" style = "border-collapse: collapse;">
                            <thead>
                                <tr class = "dark_grey wtext smedium head" style = "z-index:+3;">
                                    <th width = "12%">Item Code</th>
                                    <th class = "lefttext" width = "22%">Item Name</th>
                                    <td class = "lefttext" width = "8%">Item Group Code</td>
                                    <td class = "lefttext" width = "20%">Item Group Name</td>
                                    <td class = "lefttext" width = "11%;">On Hand</td>
                                    <td class = "lefttext" width = "11%;">Committed</td>
                                    <td class = "lefttext" width = "11%;">Balance</td>
                                    <td class = "lefttext" width = "11%;">On Order</td>
                                    <td class = "lefttext" width = "11%;">Available</td>
                                    <td class = "lefttext" width = "13%;">Warehouse & QTY</td>
                                </tr>
                            </thead>
                            <tbody class = "btext white">
                                <!-- FOR EACH LINE IN QUERY -->
                                <?php foreach($item_group_content_data as $item): ?>
                                        <tr>
                                            <td><button onclick = "location.href='./BASE_item_code.php?itm_code=<?=$item['ItemCode']?>'"><?=$item['ItemCode']?></button></td>
                                            <td class = "lefttext"><?=$item['ItemName']?></td>
                                            <td class = "lefttext"><?=$item['ItmsGrpCod']?></td>
                                            <td class = "lefttext"><?=$item['ItmsGrpNam']?></td>
                                            <td class = "righttext"><?=floatval($item['OnHand'])?></td>
                                            <td class = "righttext"><?=floatval($item['IsCommited'])?></td>
                                            <td class = "righttext"><?=floatval($item['OnHand']-$item['IsCommited'])?></td>
                                            <td class = "righttext"><?=floatval($item['OnOrder'])?></td>
                                            <td class = "righttext"><?=floatval($item['OnHand']+$item['OnOrder']-$item['IsCommited'])?></td>
                                            <td class = "lefttext" width = "8%;"><?=$item['WAREHOUSE & QTY']?></td>
                                        </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>                   
                    </div>         
                </div>
                <div id = "grouping_pages_footer" class = "footer">
                    <div id = "button_container">
                        <button class = "grouping_page_corner_buttons fill medium green wtext rounded" onclick = "history.back();">BACK</button>
                    </div>
                    <div id = "filter_container">
                        <div id = "filters" class="fill red rounded">
                            <div class = "filter wider">
                                <div class = "text">
                                    <button class = "fill red medium wtext">Group 1</button>
                                </div>
                                <div class = "content">
                                    <select id = "select_sales_person" class = "selector fill medium">
                                        <option value = "All" selected>All</option>
                                    </select>
                                </div>
                            </div>
                            <div class = "filter wider">
                                <div class = "text">
                                    <button class = "fill red medium wtext">Group 2</button>
                                </div>
                                <div class = "content">
                                    <select id = "select_project" class = "selector fill medium">
                                        <option value = "All" selected>All</option>
                                    </select>
                                </div>
                            </div>
                            <div class = "filter wider">
                                <div class = "text">
                                    <button class = "fill red medium wtext">Group 3</button>
                                </div>
                                <div class = "content">
                                    <select id = "select_engineer" class = "selector multi_option fill medium">
                                        <option value = "All" selected>All</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id = "button_container">
                        <button class = "grouping_page_corner_buttons fill medium light_blue wtext rounded"><input type = "text" placeholder = "Search Table" style = "width:90%; height:80%; font-size:2vh;"></input></button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>