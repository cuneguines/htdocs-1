<!DOCTYPE html>
<html>
    <head>
        <!-- INITALISATION AND META STUFF -->
        <title>GRN</title>
        <meta name = "viewport" content = "width=device-width, initial-scale = 1">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
        <link href='./CSS/LT_STYLE.css' rel='stylesheet' type='text/css'>

        <!-- EXTERNAL JAVASCRIPT -->
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>
        
        <!-- LOCAL JAVASCRIPT -->
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_update_total_rows.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_filters.js"></script>
        <script type = "text/javascript" src = "../../../../JS lIBS/LOCAL/JS_comments.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_exceptions_buttons.js"></script>
        <script type = "text/javascript" src = "./JS_table_to_excel.js"></script>
        

        <!-- STYLING -->
        <link rel = "stylesheet" href = "../../../../css/LT_STYLE.css">
        <link rel = "stylesheet" href = "../../../../css/theme.blackice.min.css">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

        <!-- PHP INIT -->
        <?php include '../../../../PHP LIBS/PHP FUNCTIONS/php_functions.php'; ?>
        <?php include '../../../../SQL CONNECTIONS/conn.php'; ?>
        <?php include './SQL_grn_exceptions.php'; ?>
        <?php $production_exceptions_results = get_sap_data($conn,$grn,DEFAULT_DATA); ?>
        
        <!-- TABLESORT SETUP -->
        <script>
            $(function()
            {
                $(".sortable").tablesorter({
                    "theme" : "blackice",
                    "dateFormat" : "ddmmyyyy",
                    "timeFormat" : "hhmm",
                    "headers" : {
                        8: {sorter : "shortDate"}
                    }
                });
            });
        </script>
    </head>
    <body>
        <div id = 'background'>
            <div id = 'content'>
                <div id = 'grouping_buttons_container'>
                    <div id = 'grouping_buttons' class = 'light_grey'>
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
                    <h1>GOODS RECIEVED IN<h1>
                </div>
                <div id = 'grouping_table_container' class = 'table_container' style = "overflow-y:scroll;">
                    <table id = "grn_table" class = "filterable sortable">
                        <thead>
                            <tr class = "dark_grey wtext smedium head">
                                <th width = "5%">SAP Item Number</th>
                                <th width = "22.5%">Description</th>    
                                <th width = "3%">Quantity <br> GRN'd</th>
                                <th width = "3.5%">Quantity Ordered</th>
                                <th width = "3.5%">On Hand</th>
                                <th width = "5%">Purchase Order</th>
                                <th width = "17.5%">Supplier</th>
                                <th width = "10%">Reciepted By</th>
                                <th width = "5%">Date</th>
                                <th width = "5%">Time</th>
                                <th width = "15%">Stock Group</th>
                                <th width = "5%">Comments</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($production_exceptions_results as $row): ?>
                                <?php
                                    switch($row["stock_group"])
                                    {
                                        case "Fixings":                 $stage = "Fixings";             break;
                                        case "Mesh Grate unfinishd":    $stage = "Gratings";            break;
                                        case "Fittings 304":            $stage = "Fittings";            break;
                                        case "Fittings 316":            $stage = "Fittings";            break;
                                        case "Fittings Non-SS":         $stage = "Fittings";            break;
                                        case "Seals & Gaskets":         $stage = "Fittings";            break;
                                        case "Sub Con - Purchases":     $stage = "Subcontract";         break;
                                        case "Sheet MS":                $stage = "Sheets";              break;
                                        case "Sheet 316":               $stage = "Sheets";              break;
                                        case "Sheet 304":               $stage = "Sheets";              break;
                                        case "Box MS":                  $stage = "Sheets";              break;
                                        case "Box 316":                 $stage = "Sheets";              break;
                                        case "Box 304":                 $stage = "Sheets";              break;
                                        case "Sheet Aluminium":         $stage = "Sheets";              break;
                                        case "Consum- Job related":     $stage = "Consum";              break;
                                        case "Consum- Non Job":         $stage = "Consum";              break;
                                        case "PPE":                     $stage = "Consum";              break;
                                        case "Canteen & Cleaning":      $stage = "Consum";              break;
                                        default:                        $stage = "Other";        
                                    }
                                    $row["Supplier"] == "Kilkishen Coatings Ltd" ?  $stage = "Intel" : $stage = $stage;
                                ?>
                                <?php   $supplier = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Supplier"])); ?>
                                <?php   $stock_group = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["stock_group"])); ?>
                                <?php   $recipient = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Reciepted_By"])); ?>

                                <tr stage = '<?= $stage ?>' supplier = '<?= $supplier ?>' stock_group = '<?= $stock_group ?>' recipient = '<?=$recipient?>' class = "white btext smedium">
                                    <td><?= $row["itemcode"] ?></td>
                                    <td class = 'lefttext'><?= $row["Description"] ?></td>
                                    <td><?= $row["Qty Receipted"] ?></td>
                                    <td><?= $row["Qty on PO"] ?></td>
                                    <td><?= $row["OnHand"] ?></td>
                                    <td><?= $row["Purchase Order"] ?></td>
                                    <td class = 'lefttext'><?= $row["Supplier"] ?></td>
                                    <td><?= $row["Reciepted_By"] ?></td>
                                    <td><?= $row["GRN_Date"] ?></td>
                                    <td><?= $row["time_of_day_receipted"] ?></td>
                                    <td class = 'lefttext'><?= $row["stock_group"] ?></td>
                                    <td><button class = 'comment_button <?= $row["Comments"] != null ? 'has_comment' : ''?>' comments = '<?= $row["Comments"] == null ? "NO COMMENTS" : $row["Comments"]?>'></button></td>  
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot style = "position:sticky; bottom: 0; z-index:+1;">
                            <tr class = "light_grey btext">
                                <td aggregateable = 'Y' operation = 'COUNT'>        </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'Y' operation = 'COUNT_UNIQUE'> </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div id = "grouping_pages_footer" class = "footer">
                    <div id = "button_container">
                        <button onclick = "location.href='../../../MAIN MENU/dashboard_menu.php'"class = "grouping_page_corner_buttons fill medium light_blue wtext rounded">MAIN MENU</button>
                    </div>
                    <div id = "filter_container">
                        <div id = "filters" class="fill red rounded">
                            <div class = "filter wider">
                                <div class = "text">
                                    <button class = "fill red medium wtext">Supplier</button>
                                </div>
                                <div class = "content">
                                    <select class = "selector fill medium" id = "select_supplier">
                                        <option value = "All" selected>All</option>
                                        <?php   generate_filter_options($production_exceptions_results, "Supplier");    ?>
                                    </select>
                                </div>
                            </div>
                            <div class = "filter wider">
                                <div class = "text">
                                    <button class = "fill red medium wtext">Stock Group</button>
                                </div>
                                <div class = "content">
                                    <select class = "selector fill medium" id = "select_stock_group">
                                        <option value = "All" selected>All</option>
                                        <?php   generate_filter_options($production_exceptions_results, "stock_group");     ?>
                                    </select>
                                </div>
                            </div>
                            <div class = "filter wider">
                                <div class = "text">
                                    <button class = "fill red medium wtext">Recipient</button>
                                </div>
                                <div class = "content">
                                    <select id = 'select_recipient' class = "selector fill medium">
                                        <option value = "All" selected>All</option>
                                        <?php   generate_filter_options($production_exceptions_results, "Reciepted_By");    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id = "button_container">
                        <button onclick="export_to_excel('grn_table')" class = "grouping_page_corner_buttons fill medium green wtext rounded">EXPORT</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>