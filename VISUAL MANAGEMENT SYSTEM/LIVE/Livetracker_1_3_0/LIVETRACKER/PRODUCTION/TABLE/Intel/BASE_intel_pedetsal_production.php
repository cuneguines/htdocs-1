<!DOCTYPE html>
<html>
    <head>
        <!-- INITALISATION AND META STUFF -->
        <title>TABLE LAYOUT</title>
        <meta charset = "utf-8">
        <meta name = "viewpport" content = "width=device-width, initial-scale = 1">

        <!-- EXTERNAL JAVASCRIPT -->
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>
        
        <!-- LOCAL JAVASCRIPT -->
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_comments.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_filters.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_search_table.js"></script>
		<script type = "text/javascript" src = "./JS_condition_splits.js"></script>
        <script type = "text/javascript" src = "./JS_table_to_excel.js"></script>

        <!-- STYLING -->
        <link rel = "stylesheet" href = "../../../../CSS/LT_STYLE.css">
        <link rel = "stylesheet" href = "../../../../css/theme.blackice.min.css">	
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>   

        <!-- PHP INITALISATION -->
        <?php include '../../../../PHP LIBS/PHP FUNCTIONS/php_functions.php'; ?>
        <?php include '../../../../SQL CONNECTIONS/conn.php'; ?>
		<?php include './SQL_intel_pedestal_prodution.php'; ?>
        <?php $results = get_sap_data($conn, $intel_query, DEFAULT_DATA);?>

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
        <div id = "background">
            <div id = "content">
                <div class = "table_title green">
                    <h1>INTEL PEDESTALS</h1>
                </div>
                <div id = "pages_table_container" class = "table_container" style = "overflow-y:scroll">
                    <table id = "intel_pedestal_production" class = "filterable sortable searchable">
                        <thead>
                            <tr class = "dark_grey wtext small head">
                                <th width = "3%" >Sales Order</th>
                                <th width = "3%" >Process Order</th>
                                <th width = "3%" >Production Order</th>
                                <th width = "4%" >ItemCode</th>
                                <th width = "8%">Item Name</th>
                                <th width = "2%" >Qty</th>	
                                <th width = "4%" >Fab Ststus</th>
                                <th width = "5%" >Floor Date</th>
                                <th width = "5%" >Intel Delivery Date</th>
                                <th width = "5%" >Kilkishin Date</th>
                                <th width = "4%" >Planned Lab</th>
                                <th width = "3%" >UTM</th>
                                <th width = "4%" >Lazer Top Plates Cut</th>
                                <th width = "4%" >Lazer Labour</th>
                                <th width = "5%" >Lazer Start Date</th>
                                <th width = "6%" >Fabricator</th>
                                <th width = "2%" >Hours</th>
                                <th width = "4%" >Status</th>
                                <th width = "4%" >Lab Remainer</th>
                                <th width = "6%" >Last Fab Date</th>
                                <td style = "display:none;">Kilkishen Date UNP</td>
                                <td style = "display:none;">Lab Remainder</td>
                                <td style = "display:none;">Workdays To Kilkishen</td>
                                <td style = "display:none;">Est Days To Complete</td>
                                <td width = "4%">Est Days To Comp (OT)</td>
                                <td width = "3%">Delta</td>
                                <th width = "5%">Comments</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $peds_on_floor = 0;
                            $under_40_hours = 0;
                            $under_80_hours = 0;
                            $over_80_hours = 0;
                            $paused = 0;
                            $in_dpd = 0;

                            $ntk_count = 0;

                            $total_planned = 0;
                            $total_executed = 0;
                            $comp_peds = 0;
                            $total_comp_peds = 0;

                            $remaining_workload = 0;
                            $first_dpd = 1;

                            $ntk = '';
                        ?>

                        <?php foreach($results as $row) : ?>
                            <?php
                                $ntk = 'N';
                                if($row["Status"] == "A In Production" || $row["Status"] == "C Paused" || $row["Status"] == "D In DPD" || $row["Status"] == "B Not Started")
                                { 	
                                    $peds_on_floor++;	

                                    if($row["Lab Remainder"] < 40 && $row["Lab Remainder"] >= 0 && $row["Status"] != "D In DPD" )
                                    {	
                                        $under_40_hours++;
                                    }
                                    if($row["Lab Remainder"] < 80 && $row["Lab Remainder"] >= 40 && $row["Status"] != "D In DPD")
                                    {	
                                        $under_80_hours++;
                                    }
                                    if($row["Lab Remainder"] > 80 && $row["Status"] != "D In DPD")
                                    {	
                                        $over_80_hours++;	
                                    }
                                    if($row["Status"] == 'C Paused')
                                    {	
                                        $paused++;	
                                    }
                                    if($row["Status"] == 'D In DPD')
                                    {	
                                        $in_dpd++;
                                    }
                                }

                                if($row["Status"] == 'G Complete in Intel' || $row["Status"] == 'D In DPD' || $row["Status"] == 'E In Kilkishen Powdercoating' || $row["Status"] == 'F Complete in Kilkishen'){

                                    $total_comp_peds++;

                                    if($row["Last Six Months"] == 'Y'){
                                        $total_executed+=$row["UTM"];
                                        $total_planned+=$row["Planned Lab"];
                                        $comp_peds++;
                                    }
                                }

                                switch($row["Status"])
                                {
                                    case 'D In DPD' : $rowcolor = 'orange'; break;
                                    case 'G Complete in Intel' : $rowcolor = 'light_green'; break;
                                    case 'F Complete in Kilkishen' : $rowcolor = 'purple'; break;
                                    case 'E In Kilkishen Powdercoating' : $rowcolor = 'yellow'; break;
                                    case 'C Paused' : $rowcolor = 'light_grey'; break;
                                    case 'A In Production' : $rowcolor = 'white'; break;
                                    case 'B Not Started' : $rowcolor = 'light_red'; break;
                                }

                                if($row["Status"] == 'D In DPD'){
                                    if($first_dpd){
                                        $ntk_count = $row["Kilkishen Date Week"];
                                        $first_dpd = 0;
                                        $ntk = 'Y';
                                    }
                                }

                                if($row["Delta"] <= 4){$textcolor = 'rtext bold';}
                                else if($row["Delta"] > 4 && $row["Delta"] < 9){$textcolor = 'otext bold';}
                                else{$textcolor = 'btext';}
                            ?>
                            <?php $remaining_workload += $row["Lab Remainder"]; ?>
                            <?php $status = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Status"])); ?>
                            <?php $fabricator = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Fabricator"])); ?>

                                <tr class = 'btext smallplus <?=$rowcolor?>' status = '<?=$status?>' fabricator = '<?=$fabricator?>' ntk = '<?=$ntk?>' style = 'height:30px;'>
                                    <td style = 'font-weight:bold;'><?=$row["Sales Order"]?></td>
                                  
                                    <td><?=$row["Process Order"]?></td>
                                    <td><?=$row["Prod Order"]?></td>
                                    <td><?=$row["Item Code"]?></td>
                                    <td id = 'td_stringdata' style = 'font-weight:bold; padding-left:10px;'><?=$row["Item Name"]?></td>
                                    <td><?=$row["Quantity"]?></td>
                                    <td><?=$row["Fab Status %"]?></td>
                                    <td><?=$row["Floor Date"]?></td>
                                    <td><?=$row["Intel Delivery Date"]?></td>
                                    <td class = "<?=$textcolor;?>"><?=$row["Kilkishen Date"]?></td>
                                    <td><?=$row["Planned Lab"]?></td>
                                    <td><?=$row["UTM"]?></td>
                                    <td><?=$row["Lazer Top Plates Cut"]?></td>
                                    <td><?=$row["Lazer Labour Hrs"]?></td>
                                    <td><?=$row["Lazer Start Date"]?></td>
                                    <td><?=$row["Fabricator"]?></td>
                                    <td><?=$row["SUM"]?></td>
                                    <td><?=$row["Status"]?></td>
                                    <td class = 'labremaining'><?=$row["Lab Remainder"]?></td>
                                    <td><?=$row["Last_Fab_Date"]?></td>
                                    <td style = "display:none;"><?=$row["Kilkishen Date UNP"]?></td>
                                    <td style = "display:none;"><?=$row["Lab Remainder"]?></td>
                                    <td style = "display:none;"><?=$row["Workdays To Kilkishen"]?></td>
                                    <td style = "display:none;"><?=$row["Est Days To Complete"]?></td>
                                    <td><?=$row["Est Days To Complete (OT)"]?></td>
                                    <td class = "<?=$textcolor;?>"><?=$row["Delta"]?></td>
                                    <td><button class = 'comment_button <?= $row["Comments"] != null ? 'has_comment' : ''?>' comments = '<?= $row["Comments"] == null ? "NO COMMENTS" : $row["Comments"]?>'></button></td>
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
                                        <button class = "fill red medium wtext">Status</button>
                                    </div>
                                    <div class = "content">
                                        <select id = "select_status" class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                            <?php generate_filter_options($results, "Status"); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class = "filter" id = "larger">
                                    <div style = "display:inline-block; width:15%; height:100%;">
                                        <table id = "selector">
                                            <thead>
                                                <tr class = "smallplus" style = "height:20px;">
                                                    <th width=100%>Workload</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class = "smallplus" style = "height:20px; border:none;">
                                                    <td><button class = "intel_click_options rounded red wtext" id = "remaining_workload"><?php echo $remaining_workload;?></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div><!--
                                 --><div style = "display:inline-block; width:70%; height:100%;">
                                        <table id = "selector">
                                            <thead>
                                                <tr class = "smallplus" style = "height:20px;">
                                                    <th width=16%>On Floor</th>
                                                    <th width=16%>< 40 Hours</th>
                                                    <th width=16%>< 80 Hours</th>
                                                    <th width=16%>> 80 Hours</th>
                                                    <th width=16%>Paused</th>
                                                    <th width=16%>In DPD</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class = "smallplus" style = "height:20px; border:none;">
                                                    <td><button class = "intel_click_options rounded red wtext" id = "peds_on_floor"><?php echo $peds_on_floor;?></button></td>
                                                    <td><button class = "intel_click_options rounded red wtext" id = "under_40_hours"><?php echo $under_40_hours?></td>
                                                    <td><button class = "intel_click_options rounded red wtext" id = "under_80_hours"><?php echo $under_80_hours?></td>
                                                    <td><button class = "intel_click_options rounded red wtext" id = "over_80_hours"><?php echo $over_80_hours?></td>
                                                    <td><button class = "intel_click_options rounded red wtext" id = "paused"><?php echo $paused?></td>
                                                    <td><button class = "intel_click_options rounded red wtext" id = "in_dpd"><?php echo $in_dpd?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div><!--
                                 --><div style = "display:inline-block; width:15%; height:100%;">
                                        <table id = "selector">
                                            <thead>
                                                <tr class = "smallplus" style = "height:20px;">
                                                    <th width=100%>Nxt Wk To Kilk</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class = "smallplus" style = "height:20px; border:none;">
                                                    <td><button class = "intel_click_options rounded red wtext" id = "next_to_kilkishen"><?php echo $ntk_count;?></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class = "filter">
                                    <div class = "text">
                                        <button class = "fill red medium wtext">Seach Table</button>
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
                            <button class = "grouping_page_corner_buttons fill medium light_blue wtext rounded">6 Month Fab Efficiency <?=round(($total_executed/$total_planned)*100,2);?>% (<?=$comp_peds;?>/<?=$total_comp_peds?>)</button>
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