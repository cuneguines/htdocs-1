<?php // WHICH DATERANGE BUTTON WAS PRESSED
	if (isset($_POST['ytd'])){
		$daterange = "AND t5.DocStatus = 'C' AND DATEPART(year, [Close Date]) = DATEPART(year, GETDATE())";
		$hide_ok_orders = "";
    }
	else if(isset($_POST['mtd'])){
		$daterange = "AND t5.DocStatus = 'C' AND DATEPART(month, [Close Date]) = DATEPART(month, GETDATE()) AND DATEPART(year, [Close Date]) = DATEPART(year, GETDATE())";
		$hide_ok_orders = "";
	}
	else if(isset($_POST['wtd'])){
		$daterange = "AND t5.DocStatus = 'C' AND DATEPART(week, [Close Date]) = DATEPART(week, GETDATE()) AND DATEPART(year, [Close Date]) = DATEPART(year, GETDATE())";
		$hide_ok_orders = "";
	}
	else if (isset($_POST['ytd_o%'])){
		$daterange = "AND t5.DocStatus = 'C' AND DATEPART(year, [Close Date]) = DATEPART(year, GETDATE())";
		$hide_ok_orders = "AND (CASE WHEN t4.Actual_Fab = 0 THEN 0 ELSE ISNULL(t4.Actual_Fab/ISNULL(t3.Planned_Fab,t4.Actual_Fab),0) END)*100 > 115";
	}
	else if(isset($_POST['mtd_o%'])){
		$daterange = "AND t5.DocStatus = 'C' AND DATEPART(month, [Close Date]) = DATEPART(month, GETDATE()) AND DATEPART(year, [Close Date]) = DATEPART(year, GETDATE())";
		$hide_ok_orders = "AND (CASE WHEN t4.Actual_Fab = 0 THEN 0 ELSE ISNULL(t4.Actual_Fab/ISNULL(t3.Planned_Fab,t4.Actual_Fab),0) END)*100 > 115";
	}
	else if(isset($_POST['wtd_o%'])){
		$daterange = "AND t5.DocStatus = 'C' AND DATEPART(week, [Close Date]) = DATEPART(week, GETDATE()) AND DATEPART(year, [Close Date]) = DATEPART(year, GETDATE())";
		$hide_ok_orders = "AND (CASE WHEN t4.Actual_Fab = 0 THEN 0 ELSE ISNULL(t4.Actual_Fab/ISNULL(t3.Planned_Fab,t4.Actual_Fab),0) END)*100 > 115";
	}
	else{
		$daterange = "AND t5.DocStatus = 'C' AND DATEPART(week, [Close Date]) = DATEPART(week, GETDATE()) AND DATEPART(year, [Close Date]) = DATEPART(year, GETDATE())";
		$hide_ok_orders = "";
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- INITALISATION AND META STUFF -->
        <title>CLOSED ORDERS</title>
        <meta charset = "utf-8">
        <meta name = "viewpport" content = "width=device-width, initial-scale = 1">

        <!-- EXTERNAL JAVASCRIPT -->
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

        <!-- LOCAL JAVASCRIPT -->
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_filters.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_search_table.js"></script>
        <script type = "text/javascript" src = "./JS_table_to_excel.js"></script>

        <!-- STYLING -->
        <link href='../../../../CSS/LT_STYLE.css' rel='stylesheet' type='text/css'>
        <link rel = "stylesheet" href = "../../../../css/theme.blackice.min.css">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
          
        <!-- PHP FUNCTIONS -->
        <?php include '../../../../PHP LIBS/PHP FUNCTIONS/php_functions.php'; ?>
        <?php include '../../../../SQL CONNECTIONS/conn.php'; ?>
		<?php include './SQL_closed_orders.php'; ?>
        <?php $closed_orders_table = get_sap_data($conn,$closed_orders_sql,DEFAULT_DATA); ?>

        <!-- TABLESORTER INITALISATION -->
        <script>
            $(function() {
                $(".filterable").tablesorter({"theme" : "blackice"});
            });
        </script>
    </head>
    <body>
        <div id = "background">
            <div id = "content">
                <div class = "table_title green">
                    <h1>CLOSED ORDERS</h1>
                </div>
                <div id = "pages_table_container" class = "table_container">
                    <table id = "closed_orders" class = "filterable sortable searchable">
                        <thead>
                            <tr class = "smedium dark_grey wtext head">
                                <th width = "5%">Sales Order</th>
                                <th width = "4%">Process Order</th>
                                <th width = "12%">Customer</th>
                                <th width = "4%">Qty</th>
                                <th width = "24%">Item Name</th>
                                <th width = "4%">Mat Efficiency</th>
                                <th width = "3%">Over<br>.€.</th>
                                <th width = "4.5%">Fab Complete</th>
                                <th width = "3%">Over Hrs</th>
                                <th width = "4.5%">Lab Complete</th>
                                <th width = "3%">Over<br>Hrs</th>
                                <th width = "3%">Job Size</th>
                                <th width = "5%">Close Date</th>
                                <th width = "7%">Engineer</th>
                                <th width = "9%">Sales<br>Person</th>
                            </tr>
                        </thead>
                        <tbody class = "white btext smedium">
                            <?php foreach($closed_orders_table as $row) : ?>
                                <?php $sales_person = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Sales Person"])); ?>
                                <?php $customer = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Customer"])); ?>
                                <?php $project = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Project"])); ?>
                                
                                <tr customer = '<?=$customer?>' project  = '<?=$project?>' sales_person = '<?=$sales_person?>'>
                                    <td><?=$row["Sales Order"]?></td>
                                    <td><?=$row["Process Order"]?></td>
                                    <td class= 'lefttext'><?=$row["Customer"]?></td>
                                    <td><?= $row["Quantity"]?></td>
                                    <td class = "lefttext"><?= $row["Item Name"]?></td>
                                    <td class = '<?=(str_replace(',', '', $row["Material Efficiency"]) < 105 ? 'light_green' : (str_replace(',', '', $row["Material Efficiency"]) < 115 ? 'amber' : 'red'))?>'><?=str_replace(',', '', $row["Material Efficiency"])?></td>
                                    <td class = '<?=(str_replace(',', '', $row["Material Efficiency"]) < 105 ? 'light_green' : (str_replace(',', '', $row["Material Efficiency"]) < 115 ? 'amber' : 'red'))?>'><?=str_replace(',', '', -$row["Remaining Material"])?></td>
                                    <td class = '<?=(str_replace(',', '', $row["Fabrication Complete"]) < 105 ? 'light_green' : (str_replace(',', '', $row["Fabrication Complete"]) < 115 ? 'amber' : 'red'))?>'><?=str_replace(',', '', $row["Fabrication Complete"])?></td>
                                    <td class = '<?=(str_replace(',', '', $row["Fabrication Complete"]) < 105 ? 'light_green' : (str_replace(',', '', $row["Fabrication Complete"]) < 115 ? 'amber' : 'red'))?>'><?=str_replace(',', '', -$row["Remaining Fab Hrs"])?></td>
                                    <td class = '<?=(str_replace(',', '', $row["Labour Efficiency"]) < 105 ? 'light_green' : (str_replace(',', '', $row["Labour Efficiency"]) < 115 ? 'amber' : 'red'))?>'><?=str_replace(',', '', $row["Labour Efficiency"])?></td>
                                    <td class = '<?=(str_replace(',', '', $row["Labour Efficiency"]) < 105 ? 'light_green' : (str_replace(',', '', $row["Labour Efficiency"]) < 115 ? 'amber' : 'red'))?>'><?=str_replace(',', '', -$row["Remaining Lab Hrs"])?></td>
                                    <td><?=$row["Job Size Class"]?></td>
                                    <td><?=$row["Close Date"]?></td>
                                    <td class = "lefttext"><?=$row["Engineer"]?></td>
                                    <td class = "lefttext"><?=$row["Sales Person"]?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- MORE DETAILED TABLE FOR EXPORTING (HIDDEN FROM HTML VIEW (ONLY FOR EXPORT))-->
                    <table id = "closed_orders_export" class = "filterable" style = "display:none;">
                        <thead>
                            <tr class = "smedium dark_grey wtext head">
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
                                <th>Over .€.</th>
                                <th>Planned Fab Hrs</th>
                                <th>Actual Fab Hrs</th>
                                <th>Fab Complete</th>
                                <th>Over Hrs</th>
                                <th>Planned Labour</th>
                                <th>Actual Labour</th>
                                <th>Lab Complete</th>
                                <th>Over Hrs</th>
                                <th>Underplanned Deficit</th>
                                <th>Job Size</th>
                                <th>Close Date</th>
                                <th>Engineer</th>
                                <th>Sales Person</th>
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
                        <tbody class = "white btext">
                            <?php foreach($closed_orders_table as $row) : ?>
                                <?php $sales_person = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Sales Person"])); ?>
                                <?php $customer = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Customer"])); ?>
                                <?php $project = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Project"])); ?>
                                
                                <tr customer = '<?=$customer?>' project  = '<?=$project?>' sales_person = '<?=$sales_person?>'>
                                    <td><?=$row["Sales Order"]?></td>
                                    <td><?=$row["Process Order"]?></td>
                                    <td class= 'lefttext'><?=$row["Customer"]?></td>
                                    <td><?=$row["Project"]?></td>
                                    <td><?= $row["Quantity"]?></td>
                                    <td><?=$row["Planned Qty"]?></td>
                                    <td><?=$row["Complete Qty"]?></td>
                                    <td><?=$row["Delta"]?></td>
                                    <td class = "lefttext"><?= $row["Item Name"]?></td>
                                    <td><?=$row["Planned Material"]?></td>
                                    <td><?=$row["Issued Material"]?></td>
                                    <td><?=str_replace(',', '', $row["Material Efficiency"])?></td>
                                    <td><?=str_replace(',', '', -$row["Remaining Material"])?></td>
                                    <td><?=$row["Planned Fab Hrs"]?></td>
                                    <td><?=$row["Actual Fab Hrs"]?></td>
                                    <td><?=str_replace(',', '', $row["Fabrication Complete"])?></td>
                                    <td><?=str_replace(',', '', -$row["Remaining Fab Hrs"])?></td>
                                    <td><?=$row["Planned Lab Hrs"]?></td>
                                    <td><?=$row["Actual Lab Hrs"]?></td>
                                    <td><?=str_replace(',', '', $row["Labour Efficiency"])?></td>
                                    <td><?=str_replace(',', '', -$row["Remaining Lab Hrs"])?></td>
                                    <td><?=$row["Unplanned Deficit"]?></td>
                                    <td><?=$row["Job Size Class"]?></td>
                                    <td><?=$row["Close Date"]?></td>
                                    <td class = "lefttext"><?=$row["Engineer"]?></td>
                                    <td class = "lefttext"><?=$row["Sales Person"]?></td>
                                    <td><?=$row["Item Code"]?></td>
                                    <td><?=$row["Create Date"]?></td>
                                    <td><?=$row["Create Date Year"]?></td>
                                    <td><?=$row["Create Date Week"]?></td>
                                    <td><?=$row["Creating User"]?></td>
                                    <td><?=$row["Group One"]?></td>
                                    <td><?=$row["Group Two"]?></td>
                                    <td><?=$row["Group Three"]?></td>
                                    <td><?=$row["Comments"]?></td>
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
                                        <button class = "fill red medium wtext">Customer</button>
                                    </div>
                                    <div class = "content">
                                        <select id = "select_customer" class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                            <?php generate_filter_options($closed_orders_table, "Customer"); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class = "filter">
                                    <div class = "text">
                                        <button class = "fill red medium wtext">Project</button>
                                    </div>
                                    <div class = "content">
                                        <select id = "select_project" class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                            <?php generate_filter_options($closed_orders_table, "Project"); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class = "filter">
                                    <div class = "text">
                                        <button class = "fill red medium wtext">Salesperson</button>
                                    </div>
                                    <div class = "content">
                                        <select id = "select_sales_person" class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                            <?php generate_filter_options($closed_orders_table, "Sales Person"); ?>
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
                            <button onclick = "export_to_excel('closed_orders_export')" class = "grouping_page_corner_buttons fill medium green wtext rounded">EXCEL</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>