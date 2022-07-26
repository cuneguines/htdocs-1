
<?php
    // IF P EXCEPTIONS DETECTS PROCESS ORDER POST INCLUDE ALL BOM ITEMS NOT ISSUED INCLUDING THOSE IN STOCK
    // OTHERWiSE PULL ALL BOM ITEMS ON ALL PROCESS ORDERS THAT ARE IN MATERIAL SHORTAGE REGARDLESS OF IF ITS ISSUED OR NOT
    if(isset($_GET['po'])){
        $clause = "WHERE [Process Order] = ".explode(',',$_GET['po'])[0];

        if(explode(',',$_GET['po'])[1] == 'OBAR'){
            $clause2_a="AND (t5.ItmsGrpNam LIKE '%Sheet%' OR t5.ItmsGrpNam LIKE '%Bar%' OR t5.ItmsGrpNam LIKE '%Box%')";
            $clause2_b="AND (t5.ItmsGrpNam LIKE '%Sheet%' OR t5.ItmsGrpNam LIKE '%Bar%' OR t5.ItmsGrpNam LIKE '%Box%')";
        }
        elseif(explode(',',$_GET['po'])[1] == 'NBAR'){
            $clause2_a="AND t5.ItmsGrpNam NOT LIKE '%Sheet%' AND t5.ItmsGrpNam NOT LIKE '%Bar%' AND t5.ItmsGrpNam NOT LIKE '%Box%'";
            $clause2_b="AND t5.ItmsGrpNam NOT LIKE '%Sheet%' AND t5.ItmsGrpNam NOT LIKE '%Bar%' AND t5.ItmsGrpNam NOT LIKE '%Box%'";
        }
        elseif(explode(',',$_GET['po'])[1] == 'NORMAL'){
            $clause2_a="AND t2.PrcrmntMtd = 'B' AND t0.PlannedQty > (t2.ONhand - t2.IsCommited + t0.PlannedQty)  AND t1.CmpltQty < t1.PlannedQty";
            $clause2_b="AND t2.PrcrmntMtd = 'B' AND t0.OpenQty > (t2.ONhand - t2.IsCommited + t0.OpenQty) ";
        }
    }
    else{
        $clause = "";
        $clause2_a="AND t2.PrcrmntMtd = 'B' AND t0.PlannedQty > (t2.ONhand - t2.IsCommited + t0.PlannedQty)  AND t1.CmpltQty < t1.PlannedQty";
        $clause2_b="AND t2.PrcrmntMtd = 'B' AND t0.OpenQty > (t2.ONhand - t2.IsCommited + t0.OpenQty) ";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- INITALISATION AND META STUFF -->
        <title>TIERED BUTTON GROUPING LAYOUT</title>
        <meta charset = "utf-8">
        <meta name = "viewpport" content = "width=device-width, initial-scale = 1">
        
        <!-- EXTERNAL JAVASCRIPT -->
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

        <!-- LOCAL JAVASCRIPT -->
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_filters.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_comments.js"></script>
        <script type = "text/javascript" src = "./JS_exceptions_buttons.js"></script>
        <script type = "text/javascript" src = "./JS_table_to_excel.js"></script>

        <!-- STYLING -->
        <link href='../../../../CSS/LT_STYLE.css' rel='stylesheet' type='text/css'>
        <link rel = "stylesheet" href = "../../../../css/theme.blackice.min.css">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

        <!-- PHP INITALISATION -->
        <?php include '../../../../PHP LIBS/PHP FUNCTIONS/php_functions.php'; ?>
        <?php include './BASE_SUB_production_exceptions_counts.php'; ?>

        <!-- TABLESORTER SETUP -->
        <script>
            $(function(){
                $("table.sortable").tablesorter({
                    "theme" : "blackice",
                    "dateFormat" : "ddmmyyyy",
                    "headers" : {
                        7: {sorter : "shortDate"},
                        10: {sorter : "shortDate"},
                        13: {sorter : "shortDate"}
                    }
                });
            });
        </script>
    </head>
    <body>
        <div id = 'background'>
            <div id = 'content'>
                <div id = 'grouping_buttons_container'>
                    <div id = 'grouping_buttons' class = 'fw light_grey rounded'>
                        <div id = 'margin'>
                            <div class = "grouping_category">
                                <button class = "stage_not_ok_2 quarter medium red wtext rounded-top" stage = "Mat-Not-Purchased"><?=$production_exceptions_counters[NOT_PURCHASED][TWO_WEEKS]?></button>
                                <button class = "stage_name half medium dark_grey wtext" stage = "Mat-Not-Purchased">Material Not Purchased</button>
                                <button class = "stage_not_ok_4 quarter medium light_blue wtext rounded-bottom" stage = "Mat-Not-Purchased"><?=$production_exceptions_counters[NOT_PURCHASED][FOUR_WEEKS]?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "stage_not_ok_2 quarter medium red wtext rounded-top" stage = "Mat-Not-In"><?= $production_exceptions_counters[MATERIAL_NOT_IN][TWO_WEEKS] ?></button>
                                <button class = "stage_name half medium dark_grey wtext" stage = "Mat-Not-In">Material Not In</button>
                                <button class = "stage_not_ok_4 quarter medium light_blue wtext rounded-bottom" stage = "Mat-Not-In"><?= $production_exceptions_counters[MATERIAL_NOT_IN][FOUR_WEEKS] ?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "stage_not_ok_2 quarter medium red wtext rounded-top" stage = "Gratings"><?= $production_exceptions_counters[GRATINGS][TWO_WEEKS] ?></button>
                                <button class = "stage_name half medium dark_grey wtext" stage = "Gratings">Gratings</button>
                                <button class = "stage_not_ok_4 quarter medium light_blue wtext rounded-bottom" stage = "Gratings"><?= $production_exceptions_counters[GRATINGS][FOUR_WEEKS] ?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "stage_not_ok_2 quarter medium red wtext rounded-top" stage = "Fixings"><?= $production_exceptions_counters[FIXINGS][TWO_WEEKS] ?></button>
                                <button class = "stage_name half medium dark_grey wtext" stage = "Fixings">Fixings</button>
                                <button class = "stage_not_ok_4 quarter medium light_blue wtext rounded-bottom" stage = "Fixings"><?= $production_exceptions_counters[FIXINGS][FOUR_WEEKS] ?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "stage_not_ok_2 quarter medium red wtext rounded-top" stage = "Fittings"><?= $production_exceptions_counters[FITTINGS][TWO_WEEKS] ?></button>
                                <button class = "stage_name half medium dark_grey wtext" stage = "Fittings">Fittings & Gaskets</button>
                                <button class = "stage_not_ok_4 quarter medium light_blue wtext rounded-bottom" stage = "Fittings"><?= $production_exceptions_counters[FITTINGS][FOUR_WEEKS] ?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "stage_not_ok_2 quarter medium red wtext rounded-top" stage = "Subcontract"><?= $production_exceptions_counters[SUBCONTRACT][TWO_WEEKS] ?></button>
                                <button class = "stage_name half medium dark_grey wtext" stage = "Subcontract">Subcontract</button>
                                <button class = "stage_not_ok_4 quarter medium light_blue wtext rounded-bottom" stage = "Subcontract"><?= $production_exceptions_counters[SUBCONTRACT][FOUR_WEEKS] ?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "stage_not_ok_2 quarter medium red wtext rounded-top" stage = "Sheets"><?= $production_exceptions_counters[SHEETS][TWO_WEEKS] ?></button>
                                <button class = "stage_name half medium dark_grey wtext" stage = "Sheets">Sheets & Bar Stock</button>
                                <button class = "stage_not_ok_4 quarter medium light_blue wtext rounded-bottom" stage = "Sheets"><?= $production_exceptions_counters[SHEETS][FOUR_WEEKS] ?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "stage_not_ok_2 quarter medium red wtext rounded-top" stage = "Intel-Materials"><?= $production_exceptions_counters[INTEL_MATERIAL][TWO_WEEKS] ?></button>
                                <button class = "stage_name half medium dark_grey wtext" stage = "Intel-Materials">Intel Materials</button>
                                <button class = "stage_not_ok_4 quarter medium light_blue wtext rounded-bottom" stage = "Intel-Materials"><?= $production_exceptions_counters[INTEL_MATERIAL][FOUR_WEEKS] ?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "stage_not_ok_2 quarter medium red wtext rounded-top" stage = "Intel-Subcontract"><?= $production_exceptions_counters[INTEL_SUBCONTRACT][TWO_WEEKS] ?></button>
                                <button class = "stage_name half medium dark_grey wtext" stage = "Intel-Subcontract">Intel Subcontract</button>
                                <button class = "stage_not_ok_4 quarter medium light_blue wtext rounded-bottom" stage = "Intel-Subcontract"><?= $production_exceptions_counters[INTEL_SUBCONTRACT][FOUR_WEEKS] ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "table_title green rounded-top" id = "grouping_table_title">
                    <h1>PRODUCTION EXCEPTIONS<h1>
                </div>
                <div id = 'grouping_table_container' class = 'table_container' style = "overflow-y:scroll;">
                    <table id = "production_exceptions" class = "sortable filterable">
                        <thead>
                            <!-- IF PAGE IS ACCESED BY 'po' POST DO NOT PRINT CUSTOMER COLUMN AN INSTEAD PRINT A IN STOCK AND COMMITTED QTY COLUMN (NOT ENOUGH SPACE FOR BOTH) (IF PAGE IS ACCESSED BY MAIN MENU WITH NO 'po' POST DO THE OPPOSITE)-->
                            <tr class = "dark_grey smedium head">
                                <?php if(!isset($_GET['po'])) : ?><th width = "10%">Customer</th><?php endif;?>
                                <th width = "4%" >Sales Order</th>
                                <th width = "5%" >Process Order</th>
                                <th width = "15%">Description</th>
                                <?php if(isset($_GET['po'])) : ?><th width = "5%">Stock</th><?php endif;?>
                                <th width = "5%">Issued</th>
                                <?php if(isset($_GET['po'])) : ?><th width = "5%">Comitt.</th><?php endif;?>
                                <th width = "5%" >PlndQty</th>
                                <th width = "5%" >On Ord</th>
                                <th width = "4%" >PO</th>
                                <th width = "6%" >Due In</th>
                                <th width = "4%" >Status</th>
                                <th width = "10%">Supplier</th>
                                <th width = "6%" >Promise Date</th>
                                <th width = "3%" >Delta</th>
                                <th width = "8%" >Engineer</th>
                                <th width = "6%" >Floor Date</th>
                                <th width = "4.5%" >PO<br>Comments</th>
                                <th width = "4.5%" >SO<br>Comments</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $overdue = ""?>
                            <?php foreach($production_exceptions_results as $row): ?>
                                <?php
                                    if($row["Type"] == "X" && $row["Customer"] != 'Intel Ireland Ltd'){
                                        $stage = "Mat-Not-Purchased";
                                        if($row["Weeks Overdue_2"] > 0){
                                            $overdue = '2W';
                                        }
                                        else if($row["Weeks Overdue_4"] > 0){
                                            $overdue = '4W';
                                        }
                                    }
                                    else if($row["Type"] == "N" && $row["Customer"] != 'Intel Ireland Ltd'){
                                        $stage = "Mat-Not-In";
                                        if($row["Weeks Overdue_2"] > 0){
                                            $overdue = "2W";
                                        }
                                        else if($row["Weeks Overdue_4"] > 0){
                                            $overdue = "4W";
                                        }
                                    }
                                    else if($row["Type"] == "SC" && $row["Customer"] != 'Intel Ireland Ltd'){
                                        $stage = "Subcontract";
                                        if($row["Weeks Overdue_2"] > 0){
                                            $overdue = "2W";
                                        }
                                        else if($row["Weeks Overdue_4"] > 0){
                                            $overdue = "4W";
                                        }
                                    }
                                    else if($row["Type"] == "GR" && $row["Customer"] != 'Intel Ireland Ltd'){
                                        $stage = "Gratings";
                                        if($row["Weeks Overdue_2"] > 0){
                                            $overdue = "2W";
                                        }
                                        else if($row["Weeks Overdue_4"] > 0){
                                            $overdue = "4W";
                                        }
                                    }
                                    else if($row["Type"] == "FX" && $row["Customer"] != 'Intel Ireland Ltd'){
                                        $stage = "Fixings";
                                        if($row["Weeks Overdue_2"] > 0){
                                            $overdue = "2W";
                                        }
                                        else if($row["Weeks Overdue_4"] > 0){
                                            $overdue = "4W";
                                        }
                                    }
                                    else if($row["Type"] == "FT" && $row["Customer"] != 'Intel Ireland Ltd'){
                                        $stage = "Fittings";
                                        if($row["Weeks Overdue_2"] > 0){
                                            $overdue = "2W";
                                        }
                                        else if($row["Weeks Overdue_4"] > 0){
                                            $overdue = "4W";
                                        }
                                    }
                                    else if($row["Type"] == "SH" && $row["Customer"] != 'Intel Ireland Ltd'){
                                        $stage = "Sheets";
                                        if($row["Weeks Overdue_2"] > 0){
                                            $overdue = "2W";
                                        }
                                        else if($row["Weeks Overdue_4"] > 0){
                                            $overdue = "4W";
                                        }
                                    }
                                    else if($row["Customer"] == "Intel Ireland Ltd" && $row["Type"] != 'SC'){
                                        $stage = "Intel-Materials";
                                        if($row["Weeks Overdue_2"] > 0){
                                            $overdue = "2W";
                                        }
                                        else if($row["Weeks Overdue_4"] > 0){
                                            $overdue = "4W";
                                        }
                                    }
                                    else if($row["Customer"] == "Intel Ireland Ltd" && $row["Type"] == 'SC'){
                                        $stage = "Intel-Subcontract";
                                        if($row["Weeks Overdue_2"] > 0){
                                            $overdue = "2W";
                                        }
                                        else if($row["Weeks Overdue_4"] > 0){
                                            $overdue = "4W";
                                        }
                                    }

                                    if($row["Date_Diff"] < 0){
                                        $rowcolor = "style = 'background-color:#ff7a7a;'";
                                    }
                                    else if($row["Date_Diff"] < 2){
                                        $rowcolor = "style = 'background-color:#FF8C00;'";
                                    }
                                    else if($row["Date_Diff"] < 4){
                                        $rowcolor = "style = 'background-color:#99FF99;'";
                                    }
                                    else{
                                        $rowcolor = "";
                                    }
                                ?>
                                <?php   $supplier = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Supplier"])); ?>
                                <?php   $customer = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Customer"])); ?>
                                <?php   $engineer = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Engineer"])); ?>

                                <!-- IF PAGE IS ACCESED BY 'po' POST DO NOT PRINT CUSTOMER COLUMN AN INSTEAD PRINT A IN STOCK AND COMMITTED QTY COLUMN (NOT ENOUGH SPACE FOR BOTH) (IF PAGE IS ACCESSED BY MAIN MENU WITH NO 'po' POST DO THE OPPOSITE)-->
                                <tr stage = '<?=$stage?>' overdue = '<?=$overdue?>' supplier = '<?=$supplier?>' customer = '<?=$customer?>' engineer = '<?=$engineer?>' class = 'white btext smedium' <?=$rowcolor?>>
                                    <?php if(!isset($_GET['po'])) : ?><td class = 'lefttext'><?=$row["Customer"]?></td><?php endif;?>
                                    <td><?=$row["Sales Order"]?></td>
                                    <td><?=$row["Process Order"]?></td>
                                    <td class = 'lefttext'><?=$row["ItemName"]?></td>
                                    <?php if(isset($_GET['po'])) : ?><td width = "5%"><?=$row["ONHand"]?></td><?php endif;?>
                                    <td><?= floatval($row["Issued Qty"])?></td>
                                    <?php if(isset($_GET['po'])) : ?><td width = "5%"><?=$row["Commited"]?></td><?php endif;?>
                                    <td><?=$row["Planned Qty"]?></td>
                                    <td><?=$row["On Order"]?></td>
                                    <td><?=$row["Latest Purchase Ord"] == NULL ? 'N/A' : $row["Latest Purchase Ord"]?></td>
                                    <td><?=$row["Purchase Due"] == NULL ? 'N/A' : $row["Purchase Due"]?></td>
                                    <td <?= ($row["MAKE OR BUY"] == 'BUY' ? ($row["Stock Check"] != 'IN STOCK' ? ($row["Purchase Due"] == null ? "style = 'background:rgba(225,225,225,0.6); color:brown;'>NOT PURCHASED" : ($row["Purchase Overdue"] == 'yes' ?  "style = 'background:rgba(225,225,225,0.6); color:red;'>LATE" : "style = 'background:rgba(225,225,225,0.6);color:green;'>ON TIME")) : "style = 'background:rgba(225,225,225,0.6);color:green;'>IN STOCK") : "style = 'background:rgba(225,225,225,0.6);color:green;'>MAKE")?></td>
                                    <td class = 'lefttext'><?=$row["Supplier"]?></td>
                                    <td><?=$row["Due Date"] == NULL ? "NO FLOOR DATE" : $row["Due Date"]?></td>
                                    <td id = 'td_stringdata'><?=($row["Date_Diff"])?></td>
                                    <td><?=$row["Engineer"]?></td>
                                    <td><?=$row["Floor Date"] == NULL ? "NO FLOOR DATE" : $row["Floor Date"]?></td>
                                    <td><button class = 'comment_button <?= $row["Comments_PO"] != null ? 'has_comment' : ''?>' comments = '<?= $row["Comments_PO"] == null ? "NO COMMENTS" : $row["Comments_PO"]?>'></button></td>
                                    <td><button class = 'comment_button <?= $row["Comments_SO"] != null ? 'has_comment' : ''?>' comments = '<?= $row["Comments_SO"] == null ? "NO COMMENTS" : $row["Comments_SO"]?>'></button></button></td>
                                </tr>
                                <?php $str = ''; $rowcolor = ""; $stage = ""; $overdue = ""?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div id = "grouping_pages_footer" class = "footer">
                    <div id = "button_container">
                        <button onclick = "history.back();" class = "grouping_page_corner_buttons fill medium light_blue wtext rounded">BACK</button>
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
                                        <?php   generate_filter_options($production_exceptions_results, "Customer");?>
                                    </select>
                                </div>
                            </div>
                            <div class = "filter wider">
                                <div class = "text">
                                    <button class = "fill red medium wtext">Supplier</button>
                                </div>
                                <div class = "content">
                                    <select id = "select_supplier" class = "selector fill medium">
                                        <option value = "All" selected>All</option>
                                        <?php   generate_filter_options($production_exceptions_results, "Supplier");    ?>
                                    </select>
                                </div>
                            </div>
                            <div class = "filter wider">
                                <div class = "text">
                                    <button class = "fill red medium wtext">Engineer</button>
                                </div>
                                <div class = "content">
                                    <select id = "select_engineer" class = "selector fill medium">
                                        <option value = "All" selected>All</option>
                                        <?php   generate_filter_options($production_exceptions_results, "Engineer");    ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id = "button_container">
                        <button onclick="export_production_exceptions_to_excel('production_exceptions')" class = "grouping_page_corner_buttons fill medium green wtext rounded">EXCEL</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>