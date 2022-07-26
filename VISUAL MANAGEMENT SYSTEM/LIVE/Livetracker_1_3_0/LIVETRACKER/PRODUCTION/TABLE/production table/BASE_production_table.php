<?php
	// PAGE CAN BE ACCESSED BY MULTIPLE LOCATION EACH BUTTON TO ACCESS HAS A SPECIFIC SET OF CLAUSES EG DATE AND STATUS
	// THESE CLAUSES ARE DEFINED IN SQL FOR THE QUERY HERE NAD APPENDED
	if(isset($_POST['comp_wtd'])){
		// COMPLETE WEEK TO DATE
		$clause = "t1.CmpltQty >= t1.PlannedQty AND DATEPART(WEEK,GETDATE()) = DATEPART(WEEK,t1.CloseDate) AND DATEPART(year,GETDATE()) = DATEPART(year,t1.CloseDate) AND t1.Status <> 'C'";
		$closed = true;
	}
	else if(isset($_POST['comp_wtd_o%'])){
		// COMPLETE WEEK TO DATE AND 5% OVER PLANNED IN MATERIAS OR LABOUR
		$clause = "t1.CmpltQty >= t1.PlannedQty AND DATEPART(WEEK,GETDATE()) = DATEPART(WEEK,t1.CloseDate) AND DATEPART(year,GETDATE()) = DATEPART(year,t1.CloseDate) AND ((CASE WHEN t2.Issued_Mat = 0 THEN 0 ELSE ISNULL(t2.Issued_Mat/ISNULL(t2.Planned_Mat,t2.Issued_Mat),0) END) >= 1.05 OR (CASE WHEN t10.Actual_Lab = 0 THEN 0 ELSE ISNULL(t10.Actual_Lab/ISNULL(t9.Planned_Lab,t10.Actual_Lab),0) END) >= 1.05) AND t1.Status <> 'C'";
		$closed = true;
	}
	else if(isset($_POST['comp_mtd'])){
		// COMPLETE MONTH TO DATE
		$clause = "t1.CmpltQty >= t1.PlannedQty AND DATEPART(MONTH,GETDATE()) = DATEPART(MONTH,t1.CloseDate) AND DATEPART(year,GETDATE()) = DATEPART(year,t1.CloseDate) AND t1.Status <> 'C'";
		$closed = true;
	}
	else if(isset($_POST['comp_mtd_o%'])){
		// COMPLETE MONTH TO DATE AND 5% OVER PLANNED IN MATERIAS OR LABOUR
		$clause = "t1.CmpltQty >= t1.PlannedQty AND DATEPART(MONTH,GETDATE()) = DATEPART(MONTH,t1.CloseDate) AND DATEPART(year,GETDATE()) = DATEPART(year,t1.CloseDate) AND ((CASE WHEN t2.Issued_Mat = 0 THEN 0 ELSE ISNULL(t2.Issued_Mat/ISNULL(t2.Planned_Mat,t2.Issued_Mat),0) END) >= 1.05 OR (CASE WHEN t10.Actual_Lab = 0 THEN 0 ELSE ISNULL(t10.Actual_Lab/ISNULL(t9.Planned_Lab,t10.Actual_Lab),0) END) >= 1.05) AND t1.Status <> 'C'";
		$closed = true;
	}
	else if(isset($_POST['comp_ytd'])){
		// COMPLETE YEAR TO DATE
		$clause = "t1.CmpltQty >= t1.PlannedQty AND DATEPART(year,GETDATE()) = DATEPART(year,t1.CloseDate) AND t16.ItmsGrpNam <> 'TRAINING' AND t1.Status <> 'C'";
		$closed = true;
	}
	else if(isset($_POST['comp_ytd_o%'])){
		// COMPLETE YEAR TO DATE AND 5% OVER PLANNED IN MATERIAS OR LABOUR
		$clause = "t1.CmpltQty >= t1.PlannedQty AND DATEPART(year,GETDATE()) = DATEPART(year,t1.CloseDate) AND ((CASE WHEN t2.Issued_Mat = 0 THEN 0 ELSE ISNULL(t2.Issued_Mat/ISNULL(t2.Planned_Mat,t2.Issued_Mat),0) END) >= 1.05 OR (CASE WHEN t10.Actual_Lab = 0 THEN 0 ELSE ISNULL(t10.Actual_Lab/ISNULL(t9.Planned_Lab,t10.Actual_Lab),0) END) >= 1.05) AND t1.Status <> 'C'";
		$closed = true;
	}
	else{
		// ELSE PULL EVERYTHING THATS NOT CLOSED (WILL NEVER HAPPEN)
		$clause = "ISNULL(t5.DocStatus, 'O') <> 'C' AND t1.Status not in ('C','L')";
		$closed = false;
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- META STUFF -->
        <title>Production Table</title>
		<meta charset = "utf-8">
		<meta name = "viewport" content = "width=device-width, initial-scale = 1">
			
        <!-- EXTERNAL JS DEPENDANCIES -->
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>				
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

        <!-- PAGE SPECIFIC JS -->
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_search_table.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_update_total_rows.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_filters.js"></script>									
		<script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_comments.js"></script>
        <script type = "text/javascript" src = "./JS_table_to_excel.js"></script>	

        <!-- STYLEING -->
		<link rel = "stylesheet" href = "../../../../css/LT_STYLE.css">
        <link rel = "stylesheet" href = "../../../../css/theme.blackice.min.css">									
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
        
        <!-- PHP FUNCTIONS -->
        <?php include '../../../../PHP LIBS/PHP FUNCTIONS/php_functions.php'; ?>
        <?php include '../../../../PHP LIBS/PHP SETTINGS/php_settings.php'; ?>
        <?php include '../../../../SQL CONNECTIONS/conn.php'; ?>
        <?php include './SQL_production_table.php'; ?>
        <?php $production_table_data = get_sap_data($conn,$production_table_query,DEFAULT_DATA); ?>
        
        <!-- TABLESORTER INITALISATION -->
        <script>
            $(function() {
                $("table.sortable").tablesorter({
                    theme : "blackice",
                    dateFormat : "ddmmyyyy",
                    headers : {
                        12: {sorter: "shortDate"},
                        15: {sorter: false}
                    }
                });
            });
        </script>
    </head>
    <body>
        <div id = "background">
            <div id = "content">
                <div class = "table_title green">
                    <h1>PRODUCTION TABLE</h1>
                </div>
                <div id = "pages_table_container" class = "table_container">
                    <table id = "production_table" class = "filterable sortable searchable">
                        <thead>
                            <tr class = "dark_grey wtext smedium head">
                                <th width = "5%">Sales Order</th>
                                <th width = "4%">Process Order</th>
                                <th width = "12%">Customer</th>
                                <th width = "4%">Qty</th>
                                <th width = "24%">Item Name</th>
                                <th width = "4%">Mat Efficiency</th>
                                <th width = "3%">Over .€.</th>
                                <th width = "4.5%">Fab Complete</th>
                                <th width = "3%">Over Hrs</th>
                                <th width = "4.5%">Lab Complete</th>
                                <th width = "3%">Over<br>Hrs</th>
                                <th width = "3%">Job Size</th>
                                <th width = "5%"><?php echo $closed ? "Complate Date" : "Promise Date";?></th>
                                <th width = "9%">Sales<br>Person</th>
                                <th width = "7%">Engineer</th>
                                <th width = "5%">Comments</th>
                            </tr>
                        </thead>
                        <tbody class = "btext smedium white">
                            <?php foreach($production_table_data as $process_order) : ?>

                                <?php $sales_person = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $process_order["Sales Person"])); ?>
                                <?php $engineer = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $process_order["Engineer"])); ?>
                                <?php
                                    $mat_eff = number_format($process_order["Material Efficiency"]*100,2);
                                    $fab_eff = number_format($process_order["Fabrication Complete"]*100,2);
                                    $lab_eff = number_format($process_order["Labour Efficiency"]*100,2);
                                ?>
                                
                                <tr job_size_class = '<?=$process_order["Job Size Class"]?>' sales_person = '<?=$sales_person?>' engineer = '<?=$engineer?>'>
                                    <td><?=$process_order["Sales Order"]?></td>
                                    <td><?=$process_order["Process Order"]?></td>
                                    <td class = "lefttext"><?=$process_order["Customer"]?></td>
                                    <td><?=$process_order["Quantity"]?></td>
                                    <td class = "lefttext"><?=$process_order["Item Name"]?></td>
                                    <td class = '<?=(str_replace(',', '', $mat_eff) < $amber ? 'light_green' : (str_replace(',', '', $mat_eff) < $red ? 'amber' : 'red'))?>'><?=$mat_eff?> %</td>
                                    <td class = '<?=(str_replace(',', '', $mat_eff) < $amber ? 'light_green' : (str_replace(',', '', $mat_eff) < $red ? 'amber' : 'red'))?>'><?=-$process_order["Remaining Material"]?></td>
                                    <td class = '<?=(str_replace(',', '', $fab_eff) < $amber ? 'light_green' : (str_replace(',', '', $fab_eff) < $red ? 'amber' : 'red'))?>'><?=$fab_eff?> %</td>
                                    <td class = '<?=(str_replace(',', '', $fab_eff) < $amber ? 'light_green' : (str_replace(',', '', $fab_eff) < $red ? 'amber' : 'red'))?>'><?=-$process_order["Remaining Fab Hrs"]?></td>
                                    <td class = '<?=(str_replace(',', '', $lab_eff) < $amber ? 'light_green' : (str_replace(',', '', $lab_eff) < $red ? 'amber' : 'red'))?>'><?=$lab_eff?> %</td>
                                    <td class = '<?=(str_replace(',', '', $lab_eff) < $amber ? 'light_green' : (str_replace(',', '', $lab_eff) < $red ? 'amber' : 'red'))?>'><?=-$process_order["Remaining Lab Hrs"]?></td>
                                    <td><?=$process_order["Job Size Class"]?></td>
                                    <td><?=($closed ? $process_order["STOCKDATE"] : $process_order["Due_Date"])?></td>
                                    <td><?=$process_order["Sales Person"]?></td>
                                    <td><?=$process_order["Engineer"]?></td>
                                    <td><button class = 'comment_button <?= $process_order["Comments"] != null ? 'has_comment' : ''?>' comments = '<?= $process_order["Comments"] == null ? "NO COMMENTS" : $process_order["Comments"]?>'></button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot style = "position:sticky; bottom: 0; z-index:+1;">
                            <tr class = "light_grey btext">
                                <td aggregateable = 'Y' operation = 'COUNT_UNIQUE'> </td>
                                <td aggregateable = 'Y' operation = 'COUNT_UNIQUE'> </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                                <td aggregateable = 'N' operation = ''>             </td>
                            </tr>
                        </tfoot>
                    </table>

                    <!-- HIDDEN TABLE (EXCEL EXPORT ONLY) -->
                    <table id = "production_table_export" style = "display:none;">
                        <thead>
                            <tr class = "dark_grey wtext smedium head">
                                <th>Sales Order</th>
                                <th>Process Order</th>
                                <th>Customer</th>
                                <th>Project</th>
                                <th>Qty</th>
                                <th>Planned Qty</th>
                                <th>Complete Qty</th>
                                <th>Delta</th>
                                <th>Item Name</th>
                                <th>Planned Material</th>
                                <th>Actual Material</th>
                                <th>Mat Efficiency</th>
                                <th>Over Euro</th>
                                <th>Planned Fab Hrs</th>
                                <th>Actual Fab Hrs</th>
                                <th>Fab Complete</th>
                                <th>Over Hrs</th>
                                <th>Planned Labour</th>
                                <th>Actual Labour</th>
                                <th>Lab Complete</th>
                                <th>Over Hrs</th>
                                <th>Unplanned Deficit</th>
                                <th>Job Size</th>
                                <th><?php echo $closed ? "Complate Date" : "Promise Date";?></th>
                                <th>Sales Person</th>
                                <th>Engineer</th>
                                <th>ItemCode</th>
                                <th>Date Created</th>
                                <th>Year Created</th>
                                <th>Week Created</th>
                                <th>Created By</th>
                                <th>Group One</th>
                                <th>Group Two</th>
                                <th>Group Three</th>
                                <th>Comments</th>
                            </tr>
                        </thead>
                        <tbody class = "btext smedium white">
                            <?php foreach($production_table_data as $process_order) : ?>
                                <?php $sales_person = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $process_order["Sales Person"])); ?>
                                <?php $engineer = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $process_order["Engineer"])); ?>
                                
                                <?php
                                    $mat_eff = number_format($process_order["Material Efficiency"]*100,2);
                                    $fab_eff = number_format($process_order["Fabrication Complete"]*100,2);
                                    $lab_eff = number_format($process_order["Labour Efficiency"]*100,2);
                                ?>
                                <tr job_size_class = '<?=$process_order["Job Size Class"]?>' sales_person = '<?=$sales_person?>' engineer = '<?=$engineer?>'>
                                    <td><?=$process_order["Sales Order"]?></td>
                                    <td><?=$process_order["Process Order"]?></td>
                                    <td><?=$process_order["Customer"]?></td>
                                    <td><?=$process_order["Project"]?></td>
                                    <td><?=$process_order["Quantity"]?></td>
                                    <td><?=$process_order["Planned Qty"]?></td>
                                    <td><?=$process_order["Complete Qty"]?></td>
                                    <td><?=$process_order["Delta"]?></td>
                                    <td><?=$process_order["Item Name"]?></td>
                                    <td><?=$process_order["Planned Material"]?></td>
                                    <td><?=$process_order["Issued Material"]?></td>
                                    <td><?=$mat_eff?> %</td>
                                    <td><?=-str_replace(',', '', $process_order["Remaining Material"])?></td>
                                    <td><?=$process_order["Planned Fab Hrs"]?></td>
                                    <td><?=$process_order["Actual Fab Hrs"]?></td>
                                    <td><?=$fab_eff?> %</td>
                                    <td><?=-str_replace(',', '', $process_order["Remaining Fab Hrs"])?></td>
                                    <td><?=$process_order["Planned Lab Hrs"]?></td>
                                    <td><?=$process_order["Actual Lab Hrs"]?></td>
                                    <td><?=$lab_eff?> %</td>
                                    <td><?=-str_replace(',', '', $process_order["Remaining Lab Hrs"])?></td>
                                    <td><?=$process_order["Unplanned Deficit"]?></td>
                                    <td><?=$process_order["Job Size Class"]?></td>
                                    <td><?=($closed ? $process_order["STOCKDATE"] : $process_order["Due_Date"])?></td>
                                    <td><?=$process_order["Sales Person"]?></td>
                                    <td><?=$process_order["Engineer"]?></td>
                                    <td><?=$process_order["Item Code"]?></td>
                                    <td><?=$process_order["Create Date"]?></td>
                                    <td><?=$process_order["Create Date Year"]?></td>
                                    <td><?=$process_order["Create Date Week"]?></td>
                                    <td><?=$process_order["Creating User"]?></td>
                                    <td><?=$process_order["Group One"]?></td>
                                    <td><?=$process_order["Group Two"]?></td>
                                    <td><?=$process_order["Group Three"]?></td>
                                    <td><?=$process_order["Comments"]?></td>
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
                                        <button class = "fill red medium wtext">Job Size Class</button>
                                    </div>
                                    <div class = "content">
                                        <select id = "select_job_size_class" class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                            <?php generate_filter_options($production_table_data, "Job Size Class"); ?>
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
                                            <?php generate_filter_options($production_table_data, "Engineer"); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class = "filter">
                                    <div class = "text">
                                        <button class = "fill red medium wtext">Sales Person</button>
                                    </div>
                                    <div class = "content">
                                        <select id = "select_sales_person" class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                            <?php generate_filter_options($production_table_data, "Sales Person"); ?>
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
                            <button onclick="export_to_excel('production_table_export')" class = "grouping_page_corner_buttons fill medium green wtext rounded">EXCEL</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>