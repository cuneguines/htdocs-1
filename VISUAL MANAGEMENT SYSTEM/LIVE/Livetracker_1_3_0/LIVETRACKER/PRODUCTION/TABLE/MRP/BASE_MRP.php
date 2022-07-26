<!DOCTYPE html>
<html>
    <head>
        <meta name = "viewpport" content = "width=device-width, initial-scale = 1">
        <title>MRP</title>
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
        <link href='../../../../CSS/LT_STYLE.css' rel='stylesheet' type='text/css'>
        <link rel = "stylesheet" href = "../../../../css/theme.blackice.min.css">   

        <!-- EXTERNAL JS DEPENDANCIES -->
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>              
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

        <!-- LOCAL JS -->
        <script type = "text/javascript" src = "./JS_table_to_excel.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_filters.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_search_table.js"></script>


        <?php include '../../../../PHP LIBS/PHP FUNCTIONS/php_functions.php'; ?>
        <?php include '../../../../SQL CONNECTIONS/conn.php'; ?>
        <?php include './SQL_mrp.php'; ?>
        <?php $mrp_data = get_sap_data($conn,$mrp_sql,DEFAULT_DATA); ?>

        <script>
            $(function() {
                $("table.sortable").tablesorter({
                    theme : "blackice",
                    dateFormat : "ddmmyyyy",
                    headers : {
                        0 : {sorter: "shortDate"},
                    }
                });
            });
        </script>  
    </head>
    <body>
        <div id = "background">
            <div id = "content">
                <div class = "table_title green">
                    <h1>MRP</h1>
                </div>
                <div id = "pages_table_container" class = "table_container">
                    <table id = "mrp_table" class = "filterable sortable searchable">
                        <thead>
                            <tr class = "dark_grey smedium wtext head">
                                <td width="7%">Date Created</td>
                                <td width="5%">SAP Code</td>
                                <td width="14%">Item Name</td>
                                <td width="8%">Stock Group</td>
                                <td width="5%">Commited</td>
                                <td width="4%">In Stock</td>
                                <td width="4%">Ordered</td>
                                <td width="4%">Offcuts</td>
                                <td width="4%">Min Level</td>
                                <td width="4%">Max Level</td>
                                <td width="4%">Recent PO</td>
                                <td width="4%">No Of PO's</td>
                                <td width="7%">Code Creator</td>
                                <td width="7%">Code Created</td>
                                <td width="8%">Earliest Promise Date</td>
                                <td width="10%">Engineer</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($mrp_data as $row) : ?>

                                <?php $stock_group = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Stock Group"]));    ?>
                                <?php $code_creator = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Code Creator"]));  ?>
                                <?php $engineer = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Engineer"]));  ?>

                                <tr class = "white smedium btext" stock_group = "<?=$stock_group?>" code_creator = "<?=$code_creator?>" engineer = "<?=$engineer?>">
                                    <td><?=$row["Code Created"]?></td>
                                    <td><?=$row["itemcode"]?></td>
                                    <td class = "lefttext"><?=$row["itemname"]?></td>
                                    <td><?=$row["Stock Group"]?></td>
                                    <td><?=$row["Committed"]?></td>
                                    <td><?=$row["In Stock"]?></td>
                                    <td><?=$row["Ordered"]?></td>
                                    <td><?=$row["Offcuts"]?></td>
                                    <td><?=$row["MinLevel"]?></td>
                                    <td><?=$row["MaxLevel"]?></td>
                                    <td><?=$row["Recent Process Order"]?></td>
                                    <td><?=$row["Process Orders Open"]?></td>
                                    <td><?=$row["Code Creator"]?></td>
                                    <td><?=$row["Code Created"]?></td>
                                    <td><?=$row["Earliest Promise Date"]?></td>
                                    <td><?=$row["Engineer"]?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div id = "table_pages_footer" class = "footer">
                    <div id = "top">
                        <div id = "filter_container">
                            <div id = "filters" class = "red fill rounded">
                                <div class = "filter">
                                    <div class = "text">
                                        <button class = "fill red medium wtext">Seach Table</button>
                                    </div>
                                    <div class = "content">
                                        <input class = "medium" id = "employee" type = "text">
                                    </div>
                                </div>
                                <div class = "filter">
                                    <div class = "text">
                                        <button class = "fill red medium wtext">Stock Group</button>
                                    </div>
                                    <div class = "content">
                                        <select id = "select_stock_group" class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                            <?php generate_filter_options($mrp_data, "Stock Group");?>
                                        </select>
                                    </div>
                                </div>
                                <div class = "filter">
                                    <div class = "text">
                                        <button class = "fill red medium wtext">Code Creator</button>
                                    </div>
                                    <div class = "content">
                                        <select id = "select_code_creator" class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                            <?php generate_filter_options($mrp_data, "Code Creator");?>
                                        </select>
                                    </div>
                                </div>
                                <div class = "filter">
                                    <div class = "text">
                                        <button class = "fill red medium wtext">Engineer</button>
                                    </div>
                                    <div class = "content">
                                        <select id = "select_engineer" class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                            <?php generate_filter_options($mrp_data, "Engineer");?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id = "bottom">                        
                        <div id = "button_container">
                            <button class = "grouping_page_corner_buttons fill medium light_blue wtext rounded">UNUSED</button>
                        </div>
                        <div id = "button_container_wide">
                            <button onclick = "location.href='../../../MAIN MENU/dashboard_menu.php'" class = "grouping_page_corner_buttons fill medium purple wtext rounded">MAIN MENU</button>
                        </div>
                        <div id = "button_container">
                            <button onclick = "export_to_excel('mrp_table')" class = "grouping_page_corner_buttons fill medium green wtext rounded">EXCEL</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>