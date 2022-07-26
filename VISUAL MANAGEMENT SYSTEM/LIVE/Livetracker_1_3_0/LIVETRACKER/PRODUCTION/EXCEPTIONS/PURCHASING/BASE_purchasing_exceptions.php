<!DOCTYPE html>
<html>
    <head>
        <!-- INITALISATION -->
        <meta charset = "utf-8">
        <meta name = "description" content = "meta description">
        <meta name = "viewpport" content = "width=device-width, initial-scale = 1">
        <title>Purchasing</title>
        
        <!-- EXTERNAL JAVASCRIPT -->     
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

        <!-- LOCAL JAVASCRIPT -->
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_update_total_rows.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_exceptions_buttons.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_filters.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS//LOCAL/JS_comments.js"></script>
        <script type = "text/javascript" src = "./JS_table_to_excel.js"></script>

        <!-- STYLING -->
        <link rel = "stylesheet" href = "../../../../css/LT_style.css">
        <link rel = "stylesheet" href = "../../../../css/theme.blackice.min.css">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

        <?php include '../../../../PHP LIBS/PHP FUNCTIONS/php_functions.php';?> 
        <?php include '../../../../SQL CONNECTIONS/conn.php'; ?>
        <?php include './SQL_purchasing_exceptions.php'; ?>
        
        <?php $production_exceptions_results = get_sap_data($conn,$production_exceptions,DEFAULT_DATA)?>

        <!-- TABLESORT SETUP -->
        <script>
            $(function() {
                $("table").tablesorter(
                {
                    "theme" : "blackice",
                    "dateFormat" : "ddmmyyyy",
                    "headers" : {
                        1: {sorter : "shortDate"},
                        2: {sorter : "shortDate"},
                        7: {sorter : false}
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
                                <button class = "fill medium red wtext rounded" stage = "All">All</button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "fill medium red wtext rounded" stage = "Gratings">Gratings</button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "fill medium red wtext rounded" stage = "Fixings">Fixings</button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "fill medium red wtext rounded" stage = "Fittings">Fittings & Gaskets</button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "fill medium red wtext rounded" stage = "Subcontract">Subcontract</button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "fill medium red wtext rounded" stage = "Sheets">Sheets & Bar Stock</button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "fill medium red wtext rounded" stage = "Consum">Consumables</button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "fill medium red wtext rounded" stage = "Other">Other</button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "fill medium red wtext rounded" stage = "Intel">Intel<br>Subcontract<br>(Kilkishen)</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "table_title green" id = "grouping_table_title">
                    <h1>PURCHASING<h1>
                </div>
                <div id = 'grouping_table_container' class = 'table_container' style = "overflow-y:scroll;">
                    <table id = "purchasing_table" class = "filterable sortable">
                        <thead>
                            <tr class = "dark_grey wtext smedium head">
                                <th width = "15%">Vendor</th>
                                <th width = "12%">Order Date</th>
                                <th width = "12%">Due Date</th>
                                <th width = "12%">Purchase Order</th>
                                <th width = "20%">Description</th>
                                <th width = "12%">On Order</th>
                                <th width = "12%">Stock Group</th>
                                <th width = "5%">Comments</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($production_exceptions_results as $row) : ?>
                                <?php
                                    switch($row["stock_group"])
                                    {
                                        case "Fixings":                 $stage = "Fixings";            break;
                                        case "Mesh Grate unfinishd":    $stage = "Gratings";           break;
                                        case "Fittings 304":            $stage = "Fittings";           break;
                                        case "Fittings 316":            $stage = "Fittings";           break;
                                        case "Fittings Non-SS":         $stage = "Fittings";           break;
                                        case "Seals & Gaskets":         $stage = "Fittings";           break;
                                        case "Sub Con - Purchases":     $stage = "Subcontract";        break;
                                        case "Sheet MS":                $stage = "Sheets";             break;
                                        case "Sheet 316":               $stage = "Sheets";             break;
                                        case "Sheet 304":               $stage = "Sheets";             break;
                                        case "Box MS":                  $stage = "Sheets";             break;
                                        case "Box 316":                 $stage = "Sheets";             break;
                                        case "Box 304":                 $stage = "Sheets";             break;
                                        case "Sheet Aluminium":         $stage = "Sheets";             break;
                                        case "Consum- Job related":     $stage = "Consum";             break;
                                        case "Consum- Non Job":         $stage = "Consum";             break;
                                        case "PPE":                     $stage = "Consum";             break;
                                        case "Canteen & Cleaning":      $stage = "Consum";             break;
                                        default:                        $stage = "Other";       
                                    }
                                    $row["Supplier"] == "Kilkishen Coatings Ltd" ?  $stage = "Intel" : $stage = $stage;
                                ?>
                                <?php   $supplier = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Supplier"]));  ?>
                                <?php   $stock_group = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["stock_group"]));  ?>
                                <tr stage = '<?= $stage ?>' supplier = '<?= $supplier ?>' stock_group = '<?= $stock_group ?>' class = "white btext smedium">
                                    <td class = 'lefttext'><?= $row["Supplier"] ?></td>
                                    <td><?= $row["Order Date"] ?></td>
                                    <td><?= $row["Due Date"] ?></td>
                                    <td><?= $row["Purchase Order Number"] ?></td>
                                    <td class = 'lefttext'><?= $row["Dscription"] ?></td>
                                    <td><?= $row["Quantity"] ?></td>
                                    <td class = 'lefttext'><?= $row["stock_group"] ?></td>
                                    <td><button class = 'comment_button <?= $row["Comments"] != null ? 'has_comment' : ''?>' comments = '<?= $row["Comments"] == null ? "NO COMMENTS" : $row["Comments"]?>'></button></td>   
                                </tr>
                            <?php endforeach; ?>                             
                        </tbody>
                        <tfoot style = "position:sticky; bottom: 0; z-index:+1;">
                            <tr class = "light_grey btext">
                                <td aggregateable = 'Y' operation = 'COUNT_UNIQUE'> </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                            </tr>
                        </tfoot>
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
                                    <button class = "fill red medium wtext">Supplier</button>
                                </div>
                                <div class = "content">
                                    <select id = "select_supplier" class = "selector fill medium">
                                        <option value = "All" selected>All</option>
                                        <?php generate_filter_options($production_exceptions_results, "Supplier"); ?>
                                    </select>
                                </div>
                            </div>
                            <div class = "filter wider">
                                <div class = "text">
                                    <button class = "fill red medium wtext">Stock Group</button>
                                </div>
                                <div class = "content">
                                    <select id = "select_stock_group" class = "selector fill medium">
                                        <option value = "All" selected>All</option>
                                        <?php generate_filter_options($production_exceptions_results, "stock_group"); ?>
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
                        <button onclick="export_to_excel('purchasing_table')" class = "grouping_page_corner_buttons fill medium green wtext rounded">EXPORT</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>