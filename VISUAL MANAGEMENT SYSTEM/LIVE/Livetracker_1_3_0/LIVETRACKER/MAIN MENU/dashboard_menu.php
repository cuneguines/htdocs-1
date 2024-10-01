<!DOCTYPE html>
<html>
    <head>
		<meta charset = "utf-8">
    	<meta name = "description" content = "meta description">
    	<meta name = "viewpport" content = "width=device-width, initial-scale = 1">
    	<title>Tracker Dashboard</title>
    	<script type = "text/javascript" src = "../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
    	<script type = "text/javascript" src = "./JS_button_groups.js"></script>
		<link rel = "stylesheet" href = "../../css/LT_style.css">
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>     
        <?php
		set_time_limit(300); 
            $qla_this = 0;
            $qla_this_time_last = 1;
            $qla_last = 2;
        
            $qlb_this = 0;
            $qlb_last = 1;
        
            $qlc_this = 0;
            $qlc_this_time_last = 1;

	

?>
 <script type="text/javascript" src="../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#test').on('click', function() {
                // Send an AJAX request to execute_batch.php
                $.ajax({
                    url: 'execute_batch.php',
                    method: 'POST',
                    success: function(response) {
                        // Display the response (you can modify this based on your requirements)
                        alert(response);
                    },
                    error: function() {
                        alert('Error executing the script');
                    }
                });
            });
        });
    </script>
 
        <?php $pp_exceptions = json_decode(file_get_contents(__DIR__.'\CACHED\pre_production_exceptions.json'),true); ?>
        <?php $p_exceptions = json_decode(file_get_contents(__DIR__.'\CACHED\production_exceptions.json'),true); ?>
        <?php $s_exceptions = json_decode(file_get_contents(__DIR__.'\CACHED\sales_exceptions.json'),true); ?>

        <?php $closed_orders_year_d = json_decode(file_get_contents(__DIR__.'\CACHED\closed_orders_year_data.json'),true); ?>
        <?php $closed_orders_month_d = json_decode(file_get_contents(__DIR__.'\CACHED\closed_orders_month_data.json'),true); ?>
        <?php $closed_orders_week_d = json_decode(file_get_contents(__DIR__.'\CACHED\closed_orders_week_data.json'),true); ?>

        <?php $closed_percentage_year_d = json_decode(file_get_contents(__DIR__.'\CACHED\closed_percentage_year_data.json'),true); ?>
        <?php $closed_percentage_month_d = json_decode(file_get_contents(__DIR__.'\CACHED\closed_percentage_month_data.json'),true); ?>
        <?php $closed_percentage_week_d = json_decode(file_get_contents(__DIR__.'\CACHED\closed_percentage_week_data.json'),true); ?>

        <?php $comp_po_year_d = json_decode(file_get_contents(__DIR__.'\CACHED\complete_process_orders_year_data.json'),true); ?>
        <?php $comp_po_month_d = json_decode(file_get_contents(__DIR__.'\CACHED\complete_process_orders_month_data.json'),true); ?>
        <?php $comp_po_week_d = json_decode(file_get_contents(__DIR__.'\CACHED\complete_process_orders_week_data.json'),true); ?>

        <?php $p_hours_year_d = json_decode(file_get_contents(__DIR__.'\CACHED\process_orders_hours_year_data.json'),true); ?>
        <?php $p_hours_month_d = json_decode(file_get_contents(__DIR__.'\CACHED\process_orders_hours_month_data.json'),true); ?>
        <?php $p_hours_week_d = json_decode(file_get_contents(__DIR__.'\CACHED\process_orders_hours_week_data.json'),true); ?>

        <?php $live_orders_hours = json_decode(file_get_contents(__DIR__.'\CACHED\live_orders_hours.json'),true); ?>
        <?php $live_orders_val = json_decode(file_get_contents(__DIR__.'\CACHED\live_orders_value.json'),true); ?>
        <?php $pre_prod_confirmed = json_decode(file_get_contents(__DIR__.'\CACHED\pre_production_confirmed.json'),true); ?>
        <?php $pre_prod_potential = json_decode(file_get_contents(__DIR__.'\CACHED\pre_production_potential.json'),true); ?>
        <?php $pre_prod_forecast = json_decode(file_get_contents(__DIR__.'\CACHED\pre_production_forecast.json'),true); ?>
        <?php $f_w_a = json_decode(file_get_contents(__DIR__.'\CACHED\process_orders_hours_week_data.json'),true); ?>
        <?php $five_week_average_prod = json_decode(file_get_contents(__DIR__.'\CACHED\process_orders_five_week.json'),true); ?>

        <?php $full_schedule_count = json_decode(file_get_contents(__DIR__.'\CACHED\full_schedule_count.json'),true); ?>
        <?php $last_updated = json_decode(file_get_contents(__DIR__.'\CACHED\data_last_updated.json'),true); ?>
    </head>
    <body>
        <div id = 'background'>
            <div style = "width:100%; height:70vh;">
				<div class = 'background_mask' style = "width:40%; height:100%; float:left;">
					<div style = "width:100%; height:20%; position:relative; vertical-align:top;">
						<div style = "width:95%; margin-left:2.5%; margin-right:2.5%; position:relative; height:80%; top:10%; background-color:#454545; border-radius:20px; border:3px solid green;">
							<div style = "height:40%; position:relative;">
								<h1 style = "color:white; font-size:3vh;">Page Groups</h1>
							</div>
							<div style = "height:55%; position:relative;">
								<button class = 'button_group active' id = 'production' style = "background-color:#ad06cf;height:100%; width:17%; margin-left:2%; font-size:2.5vh; vertical-align:top;">Production</button>
								<button class = 'button_group' id = 'supply_chain' style = "background-color:#ad06cf;height:100%; width:17%; margin-left:2%; font-size:2.5vh; position:relative; top:0%; vertical-align:top;">Supply Chain</button>
								<button class = 'button_group' id = 'hr' style = "background-color:#ad06cf;height:100%; width:17%; margin-left:2%; font-size:2.5vh; position:relative; top:0%; vertical-align:top;">HR</button>
								<button class = 'button_group' id = 'sales' style = "background-color:#ad06cf;height:100%; width:17%; margin-left:2%; font-size:2.5vh; position:relative; top:0%; vertical-align:top;">Sales</button>
								<button class = 'button_group' id = 'other' style = "background-color:#ad06cf;height:100%; width:17%; margin-left:2%; font-size:2.5vh; position:relative; top:0%; vertical-align:top;">Other</button>
							</div>
						</div>
					</div>
					<div style = "width:100%; height:65%; position:relative; vertical-align:top;">
						<div class = "page_buttons" style = "width:95%; margin-left:2.5%; margin-right:2.5%; position:relative; height:95%; top:2.5%; background-color:#454545; border-radius:20px; border:3px solid green;">
							<button class = "green production" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;" onclick = "location.href = '../../../../../KS_DASHBOARD/DASHBOARD/MAIN%20MENU/INTEL%20SUBMENU/BASE_intel_workflow.php'">Intel Graph</button>
	                        <button class = "green production" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;" onclick = "location.href = '../PRODUCTION/TABLE/Intel/BASE_intel_pedetsal_production.php'">Intel P Sheet</button>
	                        <button class = "green sales" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick = "location.href = '../PRODUCTION/TABLE/Richmond/BASE_richmond.php'">Richmond Sheet</button>
	                        <button class = "green supply_chain" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick="location.href='../PRODUCTION/EXCEPTIONS/Purchasing/BASE_purchasing_exceptions.php'">Purchasing</button>
							<button class = "green supply_chain" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick="location.href='../PRODUCTION/EXCEPTIONS/GRN/BASE_grn_exceptions.php'">GRN</button>
	                        <button class = "green supply_chain" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick="location.href='../SALES/EXCEPTIONS/shipped items/BASE_shipped_items.php'">Shipped Items</button>
	                        <button class = "green supply_chain" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick="location.href='../SALES/EXCEPTIONS/book out list/BASE_bookout_list.php'">BOOK OUT</button>
                            <button class = "green supply_chain" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;  display:none;" onclick="location.href='../PRODUCTION/SCHEDULE/fixings schedule/BASE_production_schedule.php'">Fixings Schedule</button>
							<button class = "green supply_chain" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;  display:none;" onclick="location.href='../PRODUCTION/EXCEPTIONS/SUBCONTRACT EXCEPTIONS/Subcontracting_schedule.php'">SCSchedule</button>
							<button class = "green supply_chain" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;  display:none;" onclick="location.href='../PRODUCTION/SCHEDULE/production_schedule_bookout/BASE_production_schedule_bookout.php'">BookOut/Ship</button>
							<button class = "green supply_chain" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;  display:none;" onclick="location.href='../PRODUCTION/EXCEPTIONS/SUBCONTRACT EXCEPTIONS/sub_contract_schedule_jamie/sub_contracting_machine.php'">Machine/SCSchedule</button>
							<button class = "green supply_chain" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;  display:none;" onclick="location.href='../PRODUCTION/SCHEDULE/sub_con_scheduleBookOut/BASE_subcontract_schedule.php'">SCBookout</button>
							<button class = "orange supply_chain" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;  display:none;" onclick="location.href='../PRODUCTION/EXCEPTIONS/PURCHASING SCHEDULE/Purchasinschedule.php'">ItemDeliveries</button>
	                        <button class = "green supply_chain" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick="location.href='../PRODUCTION/TABLE/MRP/BASE_mrp.php'">MRP</button>
	                        <button class = "green production" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;" onclick="location.href='../PRODUCTION/SCHEDULE/stock orders/BASE_stock_orders_schedule.php'">STOCK ORDERS</button>
							<button class = "orange production" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;" onclick="location.href='../PRODUCTION/SCHEDULE/production_project_manager/BASE_project_manager_schedule.php'">EETO</button>
                            <button class = "green production" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;" onclick="location.href='../PRODUCTION/SCHEDULE/subcontract schedule/BASE_subcontract_schedule.php'">SUBCONTRACT</button>
	                        <button class = "green production" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;" onclick="location.href='../PRODUCTION/SCHEDULE/high risk schedule/BASE_high_risk_schedule.php'">HIGH RISK</button>
							<button class = "orange production" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;" onclick="location.href='../PRODUCTION/SCHEDULE/GROUP_schedule/BASE_group_schedule.php?bar_box=1'">BOM Sched(BAR Stock)</button>
							<button class = "orange production" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;" onclick="location.href='../PRODUCTION/SCHEDULE/GROUP_schedule/BASE_group_schedule.php?hardware=1'">BOM Sched (Hardware)</button>
							<button class = "orange production" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;" onclick="location.href='../PRODUCTION/SCHEDULE/GROUP_schedule/BASE_group_schedule.php?misc_items=1'">BOM Sched(Misc)</button>
							<button class = "orange production" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;" onclick="location.href='../PRODUCTION/SCHEDULE/GROUP_schedule/BASE_group_schedule.php?other=1'">BOM Sched(OTHER)</button>
							<button class = "orange production" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;" onclick="location.href='../PRODUCTION/SCHEDULE/GROUP_schedule/BASE_group_schedule.php?sheets=1'">BOM Sched(Sheets)</button>
                            <button class = "green production" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;" onclick="location.href='../PRODUCTION/SCHEDULE/bom schedule/BASE_production_schedule.php?sheet_bar_box_only=1'">BOM Sched (SH)</button>
                            <button class = "green production" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;" onclick="location.href='../PRODUCTION/SCHEDULE/bom schedule/BASE_production_schedule.php?without_sheet_bar_box=1'">BOM Sched (NSH)</button>
	                        <button class = "green hr" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick = "location.href = '../GRAPHS/ENGINEERING CAPACITY/BASE_engineering_capacity.php'">Capacity Graphs</button>
	                        <button class = "green hr" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick = "location.href = '../HR/EMPLOYEE_HOLIDAY_BALANCE/enter_password.php'">Absence Balances</button>
                            <button class = "green hr" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick = "location.href = '../HR/EMPLOYEE_REVIEW_SCHEDULE/enter_password.php'">Review Schedule</button>
                            <button class = "green hr" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick = "location.href = '../HR/EMPLOYEE_CLOCKING/enter_password.php'">Clocking</button>
	                        <button class = "green hr" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick = "location.href = '../HR/HOLIDAY_SCHEDULE/enter_password.php'">Absences Schedule</button>
	                        <button class = "green other" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick="location.href='../../../../../KS_DASHBOARD/DASHBOARD/MAIN%20MENU/MAIN/MAIN_MENU.php'">FINANCE</button>
							<button class = "green other" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick="location.href='../ENGINEER_LOG/enter_password.php'">Engr-Tme-Cptr</button>
						
							<button class = "green other" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick="location.href='../QUALITY/quality_launch_page.php'">QUALITY</button>
							<button class = "green other" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick="location.href='../../../../../MISC/PROCESS_COUNT.php';">QUALITY KPIs</button>
							<button class = "green other" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick="location.href='../../../../../MISC/Engineer_hours/Engineer_hours.php'">Engr-Hrs-Log</button>
							<button class = "green sales" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick="location.href='../SALES/EXCEPTIONS/sales exceptions/BASE_sales_exceptions.php';">Sales Exceptions</button>
							<button class = "green sales" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick="location.href='../SALES/EXCEPTIONS/sales_exceptions_bird/sales_exceptions.php';">Sales Credit Check</button>
                            <button class = "green sales" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick="location.href='../SALES/TABLE/new sales orders margin/BASE_new_sales_orders_margin.php';">New Sales Margins</button>
							<button class = "orange sales" style = "width:35%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick="location.href='../SALES/MARGIN TRACKER/Sales_margin.php';">Planned Sales Margins</button>

							<button class = "green production" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;" onclick="location.href='../PRODUCTION/DEMAND/SCHEDULE_dup/BASE_production_stages.php';">Production Steps</button>
							<button class = "orange production" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;" onclick="location.href='../PRODUCTION/DEMAND/SCHEDULE_dup/BASE_production_stages.php';">Sub Bom Test</button>
							<button class = "orange production" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;" onclick="location.href='../PRODUCTION/DEMAND/FORINTEL/BASE_production_stage_intel.php';">Intel Fab Progress</button>
							<button class = "green production" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;" onclick="location.href='../../../../../KS_DASHBOARD/DASHBOARD/MAIN%20MENU/PRODUCTION%20SUBMENU/BASE_production_menu.php';">Production DB</button>
                            <button class = "green other" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick="location.href='../../../../../SAP READER/SAP READER/BASE_document_search.php';">SAP Reader</button>
							<button class = "orange other" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%; display:none;" onclick="location.href='../PRODUCTION/SCHEDULE/production%20schedule-BU/BASE_production_schedule.php';">BU Shedule</button>
                            <button class = "green production hr" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;" onclick="location.href='../HR/SERVICE PLANNER/Base_service_planner.php';">Service Planner</button>
							<button class = "green production hr" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;" onclick="location.href='../../../../../OPERATOR HOURS REPORT/FABRICATOR HOURS/Base_production_table.php';">BOOKED HOURS</button>
							<button class = "orange production" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;" onclick="location.href='../PRODUCTION/SCHEDULE/SUB BOMs/BASE_bom_schedule.php';">Sub Bom Test</button>
							<button id='test'class = "green other" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;display:none" onclick="window.location.href='http://localhost:3000 ';">Book a Space</button>
							<button id='test'class = "green other" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;display:none" onclick="window.location.href='http://localhost:3000/NEW';">User Database</button>
							<button id='test'class = "green other" style = "width:30%; height:10%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:2%;display:none" onclick="window.location.href='http://kptsvsp:2022/login';">QUALITY TRACKER</button>
							
						</div>
					</div>
                    <div style = "width:100%; height:10%; position:relative; vertical-align:top; top:2%">
						<div style = "width:95%; margin-left:2.5%; margin-right:2.5%; position:relative; height:95%; top:2.5%; background-color:#454545; border-radius:20px; border:3px solid green;">
                            <button class = "light_blue wtext" style = "width:30%; height:80%; margin-left:1%; font-size:2.5vh; position:relative; top:0%; margin-top:1%; display:inline-block;" onclick = "location.href = './BASE_SUB_get_data.php'">Update</button><p style = "display:inline-block; padding-left:10px; font-size:25px;">LAST UPDATED ON <?=date("d-m-Y H:i:s", $last_updated); ?></p>
						</div>
					</div>
                </div>
                <div class = 'background_mask' style = "width:60%; height:100%; box-shadow:0px 0px 0px 5px #454545 inset; float:left;">
					<div style = "height:31vh; width:95%; margin: 1.8vh 2.5% 2vh 2.5%">
						<div style = "display:inline-block; height:100%; width:27%; margin:0% 2% 0% 2%;background-color:#dcdcdc;border-radius:3vh;border:3px solid #39ac39; vertical-align:top; color:black;">
							<div style = "height:4.5vh; border-radius:2.5vh 2.5vh 0 0; font-size:1.6vh; background-color:#39ac39;color:white;">
								<h1>YEAR TO DATE</h1>
							</div>
							<div style = "height:19.5vh; margin-top:0px;">
								<div style = "width:100%; height:4vh; margin-bottom:1vh;">
									<div  style = "width:40%; height:4vh; float:left;">
										<h1 style = "font-size:4vh;"><?= $closed_orders_year_d[$qla_this]["Sales Orders"] == null ? 0 : $closed_orders_year_d[$qla_this]["Sales Orders"];?></h1>
									</div>
									<div  style = "width:20%; height:4vh;  float:left;">
										<h1 style = font-size:4vh;><?= ($closed_orders_year_d[$qla_this]["Sales Orders"] - $closed_orders_year_d[$qla_this_time_last]["Sales Orders"]) >= 0 ? "&#9650" : "&#9660"; ?></h1>
									</div>
									<div  style = "width:40%; height:4vh;  float:right;">
										<p style = "font-size:2.5vh; margin:0px; font-weight:bold;"><?= (($closed_orders_year_d[$qla_this_time_last]["Sales Orders"] == null || $closed_orders_year_d[$qla_this_time_last]["Sales Orders"] == 0) ? ("100%</p><p style = 'font-size:1.5vh;margin:0;'>".($closed_orders_year_d[$qla_this]["Sales Orders"]) == null ? "0" : $closed_orders_year_d[$qla_this]["Sales Orders"]) : abs(round((($closed_orders_year_d[$qla_this]["Sales Orders"] - $closed_orders_year_d[$qla_this_time_last]["Sales Orders"])/$closed_orders_year_d[$qla_this_time_last]["Sales Orders"]),2)*100)."%</p><p style = 'font-size:1.5vh;margin:0;'>".abs($closed_orders_year_d[$qla_this]["Sales Orders"] - $closed_orders_year_d[$qla_this_time_last]["Sales Orders"]));?></p>
									</div>
								</div>
								<div style = "width:100%; height:4vh;  margin-bottom:1vh;">
									<div style = "width:40%; height:4vh;  float:left;">
										<h1 style = "font-size:4vh;"><?= "€".($closed_orders_year_d[$qla_this]["Sales Value"] == null ? "0.00M" : round($closed_orders_year_d[$qla_this]["Sales Value"]/1000000,2)."M");?></h1>
									</div>
									<div  style = "width:20%; height:4vh;  float:left;">
										<h1 style = "font-size:4vh;"><?= ($closed_orders_year_d[$qla_this]["Sales Value"] - $closed_orders_year_d[$qla_this_time_last]["Sales Value"]) >= 0 ? "&#9650" : "&#9660"; ?></h1>
									</div>
									<div  style = "width:40%; height:4vh;  float:right;">
										<p style = "font-size:2.5vh;margin:0;font-weight:bold;"><?= ($closed_orders_year_d[$qla_this_time_last]["Sales Value"] == null || $closed_orders_year_d[$qla_this_time_last]["Sales Value"] == 0) ? ("100%</p><p style = 'font-size:1.5vh;margin:0;'>€".($closed_orders_year_d[$qla_this]["Sales Value"] == null ? 0.00 : round($closed_orders_year_d[$qla_this]["Sales Value"]/1000000,2)." M")) : abs(round(($closed_orders_year_d[$qla_this]["Sales Value"]-$closed_orders_year_d[$qla_this_time_last]["Sales Value"])/$closed_orders_year_d[$qla_this_time_last]["Sales Value"],2)*100)."%</p><p style = 'font-size:1.5vh;margin:0;'>€".abs(round(($closed_orders_year_d[$qla_this]["Sales Value"]-$closed_orders_year_d[$qla_this_time_last]["Sales Value"])/1000000.00,2))." M";?></p>
									</div>
								</div>
								<div style = "height:5vh; border-radius:0 0 3vh 3vh; border-top:0.1vh solid #39ac39">
									<div style = "height:100%; width:50%; float:left; text-align:center;">
										<p style = "font-size:2vh; margin:0px;"><?= "Material</p><p style = 'font-size:2vh;margin:0; font-weight:bold;'>".($closed_percentage_year_d[$qla_this]["Mat Efficiency"] == null ? "0.00%" : $closed_percentage_year_d[$qla_this]["Mat Efficiency"])?></p>
									</div>
									<div style = "height:100%; width:50%; float:right;">
										<p style = "font-size:2vh; margin:0px;"><?= "Labour</p><p style = 'font-size:2vh;margin:0; font-weight:bold;'>".($closed_percentage_year_d[$qla_this]["Lab Efficiency"] == null ? "0.00%" : $closed_percentage_year_d[$qla_this]["Lab Efficiency"])?></p>
									</div>
								</div>
								<div>
									<form action = '../CLOSED ORDERS/TABLE/closed orders table/BASE_closed_orders.php' method='post' style = "display:inline-block; width:45%; height:4vh;"><input id = 'ytd' type = 'submit' name = 'ytd_o%' value = '+ %' style = "background-color:lightcoral; width:100%; height:100%; font-size:2vh;" /></form>
									<form action = '../CLOSED ORDERS/TABLE/closed orders table/BASE_closed_orders.php' method='post' style = "display:inline-block; width:45%; height:4vh;"><input id = 'ytd' type = 'submit' name = 'ytd' value = 'All' style = " width:100%; height:100%; font-size:2vh;"/></form>
								</div>
							</div>
							<div style = "height:1vh;background-color:#39ac39;"></div>
							<div style = "height:5.95vh; border-radius:0 0 3vh 3vh; border-top:0.1vh solid #39ac39">
								<div style = "height:100%; width:30%; float:left;">
									<p style = "font-size:2vh; margin:0px;"><?= "Material</p><p style = 'font-size:2vh;margin:0;font-weight:bold;'>".($closed_percentage_year_d[$qlb_last]["Mat Efficiency"] == null ? "0.00%" : $closed_percentage_year_d[$qlb_last]["Mat Efficiency"])?></p>
								</div>	
								<div style = "height:100%; width:40%; float:left;">
									<p style = "font-size:2vh; margin:0px; font-weight:bold;"><?= $closed_orders_year_d[$qla_this_time_last]["Sales Orders"]+$closed_orders_year_d[$qla_last]["Sales Orders"]?></h1>
									<p style = "font-size:2vh; margin:0px; font-weight:bold;"><?= "€".round(($closed_orders_year_d[$qla_this_time_last]["Sales Value"]+$closed_orders_year_d[$qla_last]["Sales Value"])/1000000,2)."M";?></p>
								</div>
								<div style = "height:100%; width:30%; float:right;">
									<p style = "font-size:2vh; margin:0px;"><?= "Labour</p><p style = 'font-size:2vh;margin:0;font-weight:bold;'>".($closed_percentage_year_d[$qlb_last]["Lab Efficiency"] == null ? "0.00%" : $closed_percentage_year_d[$qlb_last]["Lab Efficiency"])?></p>
								</div>
							</div>
						</div><!--
					 --><div style = "display:inline-block; height:100%; width:28%; margin:0% 2% 0% 2%;background-color:#dcdcdc;border-radius:3vh;border:3px solid #39ac39; vertical-align:top; color:black;">
							<div style = "height:4.5vh; border-radius:2.5vh 2.5vh 0 0; font-size:1.6vh; background-color:#39ac39;color:white;">
								<h1>MONTH TO DATE</h1>
							</div>
							<div style = "height:19.5vh; margin-top:0px;">
								<div style = "width:100%; height:4vh; margin-bottom:1vh;">
									<div  style = "width:40%; height:4vh; float:left;">
										<h1 style = "font-size:4vh;"><?= $closed_orders_month_d[$qla_this]["Sales Orders"] == null ? 0 : $closed_orders_month_d[$qla_this]["Sales Orders"];?></h1>
									</div>
									<div  style = "width:20%; height:4vh;  float:left;">
										<h1 style = "font-size:4vh;"><?= ($closed_orders_month_d[$qla_this]["Sales Orders"] - $closed_orders_month_d[$qla_this_time_last]["Sales Orders"]) >= 0 ? "&#9650" : "&#9660"; ?></h1>
									</div>
									<div style = "width:40%; height:4vh;  float:right;">
										<p style = "font-size:2.5vh; margin:0px; font-weight:bold;"><?= (($closed_orders_month_d[$qla_this_time_last]["Sales Orders"] == null || $closed_orders_month_d[$qla_this_time_last]["Sales Orders"] == 0) ? ("100%</p><p style = 'font-size:1.5vh;margin:0;'>".($closed_orders_month_d[$qla_this]["Sales Orders"] == null ? "0" : $closed_orders_month_d[$qla_this]["Sales Orders"])) : abs(round((($closed_orders_month_d[$qla_this]["Sales Orders"] - $closed_orders_month_d[$qla_this_time_last]["Sales Orders"])/$closed_orders_month_d[$qla_this_time_last]["Sales Orders"]),2)*100)."%</p><p style = 'font-size:1.5vh;margin:0;'>".abs($closed_orders_month_d[$qla_this]["Sales Orders"] - $closed_orders_month_d[$qla_this_time_last]["Sales Orders"]));?></p>
									</div>
								</div>
								<div style = "width:100%; height:4vh;  margin-bottom:1vh;">
									<div style = "width:40%; height:4vh;  float:left;">
										<h1 style = "font-size:4vh;"><?= "€".($closed_orders_month_d[$qla_this]["Sales Value"] == null ? "0.00K" : round($closed_orders_month_d[$qla_this]["Sales Value"]/1000,0)."K");?></h1>
									</div>
									<div  style = "width:20%; height:4vh;  float:left;">
										<h1 style = "font-size:4vh;"><?= ($closed_orders_month_d[$qla_this]["Sales Value"]-$closed_orders_month_d[$qla_this_time_last]["Sales Value"]) >= 0 ? "&#9650" : "&#9660"; ?></h1>
									</div>
									<div  style = "width:40%; height:4vh;  float:right;">
										<p style = "font-size:2.5vh;margin:0;font-weight:bold;"><?= ($closed_orders_month_d[$qla_this_time_last]["Sales Value"] == null || $closed_orders_month_d[$qla_this_time_last]["Sales Value"] == 0) ? ("100%</p><p style = 'font-size:1.5vh;margin:0;'>€".($closed_orders_month_d[$qla_this]["Sales Value"] == null ? 0.00 : round($closed_orders_month_d[$qla_this]["Sales Value"]/1000,2)." K")) : abs(round(($closed_orders_month_d[$qla_this]["Sales Value"]-$closed_orders_month_d[$qla_this_time_last]["Sales Value"])/$closed_orders_month_d[$qla_this_time_last]["Sales Value"],2)*100)."%</p><p style = 'font-size:1.5vh;margin:0;'>€".abs(round(($closed_orders_month_d[$qla_this]["Sales Value"]-$closed_orders_month_d[$qla_this_time_last]["Sales Value"])/1000,2))." K";?></p>
									</div>
								</div>
								<div style = "height:5vh; border-radius:0 0 3vh 3vh; border-top:0.1vh solid #39ac39">
									<div style = "height:100%; width:50%; float:left; text-align:center;">
										<p style = "font-size:2vh; margin:0px;"><?= "Material</p><p style = 'font-size:2vh;margin:0; font-weight:bold;'>".($closed_percentage_month_d[$qla_this]["Mat Efficiency"] == null ? "0.00%" : $closed_percentage_month_d[$qla_this]["Mat Efficiency"])?></p>
									</div>
									<div style = "height:100%; width:50%; float:right;">
										<p style = "font-size:2vh; margin:0px;"><?= "Labour</p><p style = 'font-size:2vh;margin:0; font-weight:bold;'>".($closed_percentage_month_d[$qla_this]["Lab Efficiency"] == null ? "0.00%" : $closed_percentage_month_d[$qla_this]["Lab Efficiency"])?></p>
									</div>
								</div>
								<div>
									<form action = '../CLOSED ORDERS/TABLE/closed orders table/BASE_closed_orders.php' method='post' style = "display:inline-block; width:45%; height:4vh;"><input id = 'mtd' type = 'submit' name = 'mtd_o%' value = '+ %' style = "background-color:lightcoral; width:100%; height:100%; font-size:2vh;" /></form>
									<form action = '../CLOSED ORDERS/TABLE/closed orders table/BASE_closed_orders.php' method='post' style = "display:inline-block; width:45%; height:4vh;"><input id = 'mtd' type = 'submit' name = 'mtd' value = 'All' style = " width:100%; height:100%; font-size:2vh;"/></form>
								</div>
							</div>
							<div style = "height:1vh;background-color:#39ac39;">
							</div>
							<div style = "height:5.95vh; border-radius:0 0 3vh 3vh; border-top:0.1vh solid #39ac39">
								<div style = "height:100%; width:30%; float:left;">
									<p style = "font-size:2vh; margin:0px;"><?= "Material</p><p style = 'font-size:2vh;margin:0;font-weight:bold;'>".($closed_percentage_month_d[$qlb_last]["Mat Efficiency"] == null ? "0.00%" : $closed_percentage_month_d[$qlb_last]["Mat Efficiency"])?></p>
								</div>	
								<div style = "height:100%; width:40%; float:left;">
									<h1 style = "font-size:2vh; margin:0;"><?= $closed_orders_month_d[$qla_this_time_last]["Sales Orders"]+$closed_orders_month_d[$qla_last]["Sales Orders"]?></h1>
									<h1 style = "font-size:2vh; margin:0;"><?= "&#8364 ".round(($closed_orders_month_d[$qla_this_time_last]["Sales Value"]+$closed_orders_month_d[$qla_last]["Sales Value"])/1000,1)."K";?></h1>
								</div>
								<div style = "height:100%; width:30%; float:right;">
									<p style = "font-size:2vh; margin:0px;"><?= "Labour</p><p style = 'font-size:2vh;margin:0;font-weight:bold;'>".($closed_percentage_month_d[$qlb_last]["Lab Efficiency"] == null ? "0.00%" : $closed_percentage_month_d[$qlb_last]["Lab Efficiency"])?></p>
								</div>
							</div>
						</div><!--
					 --><div style = "display:inline-block; height:100%; width:27%; margin:0% 2% 0% 2%;background-color:#dcdcdc;border-radius:3vh;border:3px solid #39ac39; vertical-align:top; color:black;">
							<div style = "height:4.5vh; border-radius:2.5vh 2.5vh 0 0; font-size:1.6vh; background-color:#39ac39;color:white;">
								<h1>WEEK TO DATE</h1>
							</div>
							<div style = "height:19.5vh; margin-top:0px;">
								<div style = "width:100%; height:4vh; margin-bottom:1vh;">
									<div  style = "width:40%; height:4vh; float:left;">
										<h1 style = "font-size:4vh;"><?= $closed_orders_week_d[$qla_this]["Sales Orders"] == null ? 0 : $closed_orders_week_d[$qla_this]["Sales Orders"];?></h1>
									</div>
									<div  style = "width:20%; height:4vh;  float:left;">
										<h1 style = "font-size:4vh;"><?= ($closed_orders_week_d[$qla_this]["Sales Orders"] - $closed_orders_week_d[$qla_this_time_last]["Sales Orders"]) >= 0 ? "&#9650" : "&#9660"; ?></h1>
									</div>
									<div  style = "width:40%; height:4vh;  float:right;">
									<p style = "font-size:2.5vh; margin:0px; font-weight:bold;"><?= (($closed_orders_week_d[$qla_this_time_last]["Sales Orders"] == null || $closed_orders_week_d[$qla_this_time_last]["Sales Orders"] == 0) ? ("100%</p><p style = 'font-size:1.5vh;margin:0;'>".($closed_orders_week_d[$qla_this]["Sales Orders"]) == null ? 0  : $closed_orders_week_d[$qla_this]["Sales Orders"]) : abs(round((($closed_orders_week_d[$qla_this]["Sales Orders"] - $closed_orders_week_d[$qla_this_time_last]["Sales Orders"])/$closed_orders_week_d[$qla_this_time_last]["Sales Orders"]),2)*100)."%</p><p style = 'font-size:1.5vh;margin:0;'>".abs($closed_orders_week_d[$qla_this]["Sales Orders"] - $closed_orders_week_d[$qla_this_time_last]["Sales Orders"]));?></p>
									</div>
								</div>
								<div style = "width:100%; height:4vh;  margin-bottom:1vh;">
									<div style = "width:40%; height:4vh;  float:left;">
										<h1 style = "font-size:4vh;"><?= "€".($closed_orders_week_d[$qla_this]["Sales Value"] == null ? "0.00K" : round($closed_orders_week_d[$qla_this]["Sales Value"]/1000,0)."K");?></h1>
									</div>
									<div  style = "width:20%; height:4vh;  float:left;">
										<h1 style = "font-size:4vh; margin:auto;"><?= ($closed_orders_week_d[$qla_this]["Sales Value"]-$closed_orders_week_d[$qla_this_time_last]["Sales Value"]) >= 0 ? "&#9650" : "&#9660"; ?></h1>
									</div>
									<div  style = "width:40%; height:4vh;  float:right;">
										<p style = "font-size:2.5vh;margin:0;font-weight:bold;"><?= ($closed_orders_week_d[$qla_this_time_last]["Sales Value"] == null || $closed_orders_week_d[$qla_this_time_last]["Sales Value"] == 0) ? ("100%</p><p style = 'font-size:1.5vh;margin:0;'>€".($closed_orders_week_d[$qla_this]["Sales Value"] == null ? 0.00 : round($closed_orders_week_d[$qla_this]["Sales Value"]/1000,2)." K")) : abs(round(($closed_orders_week_d[$qla_this]["Sales Value"]-$closed_orders_week_d[$qla_this_time_last]["Sales Value"])/$closed_orders_week_d[$qla_this_time_last]["Sales Value"],2)*100)."%</p><p style = 'font-size:1.5vh;margin:0;'>€".abs(round(($closed_orders_week_d[$qla_this]["Sales Value"]-$closed_orders_week_d[$qla_this_time_last]["Sales Value"])/1000,2))." K";?></p>
									</div>
								</div>
								<div style = "height:5vh; border-radius:0 0 3vh 3vh; border-top:0.1vh solid #39ac39">
									<div style = "height:100%; width:50%; float:left; text-align:center;">
										<p style = "font-size:2vh; margin:0px;"><?= "Material</p><p style = 'font-size:2vh;margin:0; font-weight:bold;'>".($closed_percentage_week_d[$qla_this]["Mat Efficiency"] == null ? "0.00%" : $closed_percentage_week_d[$qla_this]["Mat Efficiency"])?></p>
									</div>
									<div style = "height:100%; width:50%; float:right;">
										<p style = "font-size:2vh; margin:0px;"><?= "Labour</p><p style = 'font-size:2vh;margin:0; font-weight:bold;'>".($closed_percentage_week_d[$qla_this]["Lab Efficiency"] == null ? "0.00%" : $closed_percentage_week_d[$qla_this]["Lab Efficiency"])?></p>
									</div>
								</div>
								<div>
									<form action = '../CLOSED ORDERS/TABLE/closed orders table/BASE_closed_orders.php' method='post' style = "display:inline-block; width:45%; height:4vh;"><input id = 'wtd' type = 'submit' name = 'wtd_o%' value = '+ %' style = "background-color:lightcoral; width:100%; height:100%; font-size:2vh;" /></form>
									<form action = '../CLOSED ORDERS/TABLE/closed orders table/BASE_closed_orders.php' method='post' style = "display:inline-block; width:45%; height:4vh;"><input id = 'wtd' type = 'submit' name = 'wtd' value = 'All' style = " width:100%; height:100%; font-size:2vh;"/></form>
								</div>
							</div>
							<div style = "height:1vh;background-color:#39ac39;"></div>
							<div style = "height:5.95vh; border-radius:0 0 3vh 3vh; border-top:0.1vh solid #39ac39">
								<div style = "height:100%; width:30%; float:left;">
									<p style = "font-size:2vh; margin:0px;"><?= "Material</p><p style = 'font-size:2vh;margin:0;font-weight:bold;'>".($closed_percentage_week_d[$qlb_last]["Mat Efficiency"] == null ? "0.00%" : $closed_percentage_week_d[$qlb_last]["Mat Efficiency"])?></p>
								</div>	
								<div style = "height:100%; width:40%; float:left;">
									<h1 style = "font-size:2vh; margin:0;"><?= $closed_orders_week_d[$qla_this_time_last]["Sales Orders"]+$closed_orders_week_d[$qla_last]["Sales Orders"]?></h1>
									<h1 style = "font-size:2vh; margin:0;"><?= "&#8364 ".round(($closed_orders_week_d[$qla_this_time_last]["Sales Value"]+$closed_orders_week_d[$qla_last]["Sales Value"])/1000,1)."K";?></h1>
								</div>
								<div style = "height:100%; width:30%; float:right;">
									<p style = "font-size:2vh; margin:0px;"><?= "Material</p><p style = 'font-size:2vh;margin:0;font-weight:bold;'>".($closed_percentage_week_d[$qlb_last]["Lab Efficiency"] == null ? "0.00%" : $closed_percentage_week_d[$qlb_last]["Lab Efficiency"])?></p>
								</div>
							</div>
						</div>
					</div>
					<div style = "height:31vh; width:95%; margin: 2vh 2.5% 2vh 2.5%; color:black;">
						<div style = "display:inline-block; height:100%; width:27%; margin:0% 2% 0% 2%;background-color:#dcdcdc;border-radius:3vh;border:3px solid #ad06cf;";>
							<div style = "height:4.5vh; border-radius:2.5vh 2.5vh 0 0; font-size:1.6vh; background-color:#ad06cf;color:white;">
								<h1>YEAR TO DATE</h1>
							</div>
							<div style = "height:17.5vh; margin-top:0px;">
								<div style = "width:100%; height:4vh; margin-bottom:1vh;">
										<h1 style = "font-size:4vh;"><?=$comp_po_year_d[$qlb_this]["Process Orders"];?></h1>
								</div>
								<div style = "width:100%; height:7vh;  margin-bottom:1vh;">
									<div style = "height:100%; width:50%; float:left; text-align:center;">
										<p style = "font-size:2vh; margin:0;"><?="Material</p><p style = 'font-size:2vh;margin:0;font-weight:bold;'>".$comp_po_year_d[$qlb_this]["Mat Efficiency"]."<br>".($comp_po_year_d[$qlb_this]["Difference_Mat"] >= 0 ? "<p style = 'color:green;font-size:2vh;margin:0;font-weight:bold;'>€".$comp_po_year_d[$qlb_this]["Difference_Mat"]."</p>" : "<p style = 'color:red;font-size:2vh;margin:0;font-weight:bold;'>€".($comp_po_year_d[$qlb_this]["Difference_Mat"]*-1)."</p>")?></p>
									</div>
									<div style = "height:100%; width:50%; float:right;">
										<p style = "font-size:2vh; margin:0;"><?="Labour</p><p style = 'font-size:2vh;margin:0;font-weight:bold;'>".$comp_po_year_d[$qlb_this]["Lab Efficiency"]."<br>".($comp_po_year_d[$qlb_this]["Difference_Lab"] >= 0 ? "<p style = 'color:green;font-size:2vh;margin:0;font-weight:bold;'>".$comp_po_year_d[$qlb_this]["Difference_Lab"]." Hrs</p>" : "<p style = 'color:red;font-size:2vh;margin:0;font-weight:bold;'>".($comp_po_year_d[$qlb_this]["Difference_Lab"]*-1)." Hrs</p>")?></p>
									</div>
								</div>
								<div>
									<form action = '../PRODUCTION/TABLE/production table/BASE_production_table.php' method='post' style = "display:inline-block; width:45%; height:4vh;"><input id = 'comp_ytd' type = 'submit' name = 'comp_ytd_o%' value = '+ %' style = "background-color:lightcoral; width:100%; height:100%; font-size:2vh;" /></form>
									<form action = '../PRODUCTION/TABLE/production table/BASE_production_table.php' method='post' style = "display:inline-block; width:45%; height:4vh;"><input id = 'comp_ytd' type = 'submit' name = 'comp_ytd' value = 'All' style = " width:100%; height:100%; font-size:2vh;"/></form>
								</div>
							</div>
							<div style = "height:1vh;background-color:#ad06cf;"></div>
							<div style = "height:7.95vh; border-radius:0 0 3vh 3vh; border-top:0.1vh solid #ad06cf">
								<div style = "height:2vh; margin:0;">
									<h3 style = "margin:0;">Hours</h3>
								</div>
								<div>
									<div style = "width:40%; height:4vh;  float:left;">
										<h1 style = "font-size:4vh;"><?= $p_hours_year_d[$qlc_this]["Hours Executed"];?></h1>
									</div>
									<div  style = "width:20%; height:4vh;  float:left;">
										<h1 style = "font-size:4vh; margin:auto;"><?= ($p_hours_year_d[$qlc_this]["Hours Executed"]-$p_hours_year_d[$qlc_this_time_last]["Hours Executed"] >= 0) ? "&#9650" : "&#9660" ;?></h1>
									</div>
									<div  style = "width:40%; height:4vh;  float:right;">
										<p style = "font-size:2.5vh;margin:0;font-weight:bold;"><?= (($p_hours_year_d[$qlc_this_time_last]["Hours Executed"] == null || $p_hours_year_d[$qlc_this_time_last]["Hours Executed"] == 0) ? ("100%</p><p style = 'font-size:1.5vh;margin:0;'>".($p_hours_year_d[$qlc_this]["Hours Executed"] == null ? 0 : $p_hours_year_d[$qlc_this]["Hours Executed"])) : abs(round(($p_hours_year_d[$qlc_this]["Hours Executed"]-$p_hours_year_d[$qlc_this_time_last]["Hours Executed"])/$p_hours_year_d[$qlc_this_time_last]["Hours Executed"],2)*100)."%<br></p><p style = 'font-size:1.5vh;margin:0;'>".abs(round(($p_hours_year_d[$qlc_this]["Hours Executed"]-$p_hours_year_d[$qlc_this_time_last]["Hours Executed"]),2)));?></p>
									</div>
								</div>
							</div>
						</div><!--
					--><div style = "display:inline-block;  height:100%; width:28%; margin:0% 2% 0% 2.5%;background-color:#dcdcdc;border-radius:3vh;border:3px solid #ad06cf;";>
							<div style = "height:4.5vh; border-radius:2.5vh 2.5vh 0 0; font-size:1.6vh; background-color:#ad06cf;color:white;">
								<h1>MONTH TO DATE</h1>
							</div>
							<div style = "height:17.5vh; margin-top:0px;">
								<div style = "width:100%; height:4vh; margin-bottom:1vh;">
									<h1 style = "font-size:4vh;"><?= $comp_po_month_d[$qlc_this]["Process Orders"];?></h1>
								</div>
								<div style = "width:100%; height:7vh;  margin-bottom:1vh;">
									<div style = "height:100%; width:50%; float:left; text-align:center;">
										<p style = "font-size:2vh; margin:0;"><?= "Material</p><p style = 'font-size:2vh;margin:0;font-weight:bold;'>".($comp_po_month_d[$qlb_this]["Mat Efficiency"] == 0 ? "0.00%" : $comp_po_month_d[$qlb_this]["Mat Efficiency"])."<br>".($comp_po_month_d[$qlb_this]["Difference_Mat"] >= 0 ? "<p style = 'color:green;font-size:2vh;margin:0;font-weight:bold;'>€".$comp_po_month_d[$qlb_this]["Difference_Mat"]."</p>" : "<p style = 'color:red;font-size:2vh;margin:0;font-weight:bold;'>€".($comp_po_month_d[$qlb_this]["Difference_Mat"]*-1)."</p>")?></p>
									</div>
									<div style = "height:100%; width:50%; float:right;">
										<p style = "font-size:2vh; margin:0;"><?= "Labour</p><p style = 'font-size:2vh;margin:0;font-weight:bold;'>".($comp_po_month_d[$qlb_this]["Lab Efficiency"] == 0 ? "0.00%" : $comp_po_month_d[$qlb_this]["Lab Efficiency"])."<br>".($comp_po_month_d[$qlb_this]["Difference_Lab"] >= 0 ? "<p style = 'color:green;font-size:2vh;margin:0;font-weight:bold;'>".$comp_po_month_d[$qlb_this]["Difference_Lab"]." Hrs</p>" : "<p style = 'color:red;font-size:2vh;margin:0;font-weight:bold;'>".($comp_po_month_d[$qlb_this]["Difference_Lab"]*-1)." Hrs</p>")?></p>
									</div>
								</div>
								<div>
									<form action = '../PRODUCTION/TABLE/production table/BASE_production_table.php' method='post' style = "display:inline-block; width:45%; height:4vh;"><input id = 'comp_mtd' type = 'submit' name = 'comp_mtd_o%' value = '+ %' style = "background-color:lightcoral; width:100%; height:100%; font-size:2vh;" /></form>
									<form action = '../PRODUCTION/TABLE/production table/BASE_production_table.php' method='post' style = "display:inline-block; width:45%; height:4vh;"><input id = 'comp_mtd' type = 'submit' name = 'comp_mtd' value = 'All' style = " width:100%; height:100%; font-size:2vh;"/></form>
								</div>
							</div>
							<div style = "height:1vh;background-color:#ad06cf;"></div>
								<div style = "height:7.95vh; border-radius:0 0 3vh 3vh; border-top:0.1vh solid #ad06cf">
									<div style = "height:2vh; margin:0;">
										<h3 style = "margin:0;">Hours</h3>
									</div>
									<div style = "width:40%; height:4vh;  float:left;">
										<h1 style = "font-size:4vh;"><?= $p_hours_month_d[$qlc_this]["Hours Executed"];?></h1>
									</div>
									<div  style = "width:20%; height:4vh;  float:left;">
										<h1 style = "font-size:4vh; margin:auto;"><?= ($p_hours_month_d[$qlc_this]["Hours Executed"]-$p_hours_month_d[$qlc_this_time_last]["Hours Executed"] >= 0) ? "&#9650" : "&#9660";?></h1>
									</div>
									<div  style = "width:40%; height:4vh;  float:right;">
									<p style = "font-size:2.5vh;margin:0;font-weight:bold;"><?= (($p_hours_month_d[$qlc_this_time_last]["Hours Executed"] == null || $p_hours_month_d[$qlc_this_time_last]["Hours Executed"] == 0) ? ("100%</p><p style = 'font-size:1.5vh;margin:0;'>".($p_hours_month_d[$qlc_this]["Hours Executed"] == null ? 0 : $p_hours_month_d[$qlc_this]["Hours Executed"])) : abs(round(($p_hours_month_d[$qlc_this]["Hours Executed"]-$p_hours_month_d[$qlc_this_time_last]["Hours Executed"])/$p_hours_month_d[$qlc_this_time_last]["Hours Executed"],2)*100)."%<br></p><p style = 'font-size:1.5vh;margin:0;'>".abs(round(($p_hours_month_d[$qlc_this]["Hours Executed"]-$p_hours_month_d[$qlc_this_time_last]["Hours Executed"]),2)))."</p>";?></p>
								</div>
							</div>
						</div><!--
					--><div style = "display:inline-block;  height:100%; width:27%; margin:0% 2% 0% 2%;background-color:#dcdcdc;border-radius:3vh;border:3px solid #ad06cf;";>
							<div style = "height:4.5vh; border-radius:2.5vh 2.5vh 0 0; font-size:1.6vh; background-color:#ad06cf;color:white;">
								<h1>WEEK TO DATE</h1>
							</div>
							<div style = "height:17.5vh; margin-top:0px;">
								<div style = "width:100%; height:4vh; margin-bottom:1vh;">
									<h1 style = "font-size:4vh;"><?= $comp_po_week_d[$qlb_this]["Process Orders"];?></h1>
								</div>
								<div style = "width:100%; height:7vh;  margin-bottom:1vh;">
									<div style = "height:100%; width:50%; float:left; text-align:center;">
										<p style = "font-size:2vh; margin:0;"><?= "Material</p><p style = 'font-size:2vh;margin:0;font-weight:bold;'>".($comp_po_week_d[$qlb_this]["Mat Efficiency"] == null ? "0.00%" : $comp_po_week_d[$qlb_this]["Mat Efficiency"]."<br>").($comp_po_week_d[$qlb_this]["Difference_Mat"] >= 0 ? "<p style = 'color:green;font-size:2vh;margin:0;font-weight:bold;'>€".$comp_po_week_d[$qlb_this]["Difference_Mat"]."</p>" : "<p style = 'color:red;font-size:2vh;margin:0;font-weight:bold;'>€".(($comp_po_week_d[$qlb_this]["Difference_Mat"] != 0 ? $comp_po_week_d[$qlb_this]["Difference_Mat"] : 0 )*-1)."</p>")?></p>  
									</div>
									<div style = "height:100%; width:50%; float:right;">
										<p style = "font-size:2vh; margin:0;"><?= "Labour</p><p style = 'font-size:2vh;margin:0;font-weight:bold;'>".($comp_po_week_d[$qlb_this]["Lab Efficiency"] == 0 ? "0.00%" : $comp_po_week_d[$qlb_this]["Lab Efficiency"]."<br>").($comp_po_week_d[$qlb_this]["Difference_Lab"] >= 0 ? "<p style = 'color:green;font-size:2vh;margin:0;font-weight:bold;'>".$comp_po_week_d[$qlb_this]["Difference_Lab"]." Hrs</p>" : "<p style = 'color:red;font-size:2vh;margin:0;font-weight:bold;'>".($comp_po_week_d[$qlb_this]["Difference_Lab"]*-1)." Hrs</p>")?></p>
									</div>
								</div>
								<div>
									<form action = '../PRODUCTION/TABLE/production table/BASE_production_table.php' method='post' style = "display:inline-block; width:45%; height:4vh;"><input id = 'comp_wtd' type = 'submit' name = 'comp_wtd_o%' value = '+ %' style = "background-color:lightcoral; width:100%; height:100%; font-size:2vh;" /></form>
									<form action = '../PRODUCTION/TABLE/production table/BASE_production_table.php' method='post' style = "display:inline-block; width:45%; height:4vh;"><input id = 'comp_wtd' type = 'submit' name = 'comp_wtd' value = 'All' style = " width:100%; height:100%; font-size:2vh;"/></form>
								</div>
							</div>
							<div style = "height:1vh;background-color:#ad06cf;"></div>
							<div style = "height:7.95vh; border-radius:0 0 3vh 3vh; border-top:0.1vh solid #ad06cf">
								<div style = "height:2vh; margin:0;">
									<h3 style = "margin:0;">Hours</h3>
								</div>
								<div style = "width:40%; height:4vh;  float:left;">
									<h1 style = "font-size:4vh;"><?= $p_hours_week_d[$qlc_this]["Hours Executed"];?></h1>
								</div>
								<div  style = "width:20%; height:4vh;  float:left;">
									<h1 style = "font-size:4vh; margin:auto;"><?= ($p_hours_week_d[$qlc_this]["Hours Executed"]-$p_hours_week_d[$qlc_this_time_last]["Hours Executed"] >= 0) ? "&#9650" : "&#9660";?></h1>
								</div>
								<div  style = "width:40%; height:4vh;  float:right;">
									<p style = "font-size:2.5vh;margin:0;font-weight:bold;"><?= (($p_hours_week_d[$qlc_this_time_last]["Hours Executed"] == null || $p_hours_week_d[$qlc_this_time_last]["Hours Executed"] == 0) ? ("100%</p><p style = 'font-size:1.5vh;margin:0;'>".($p_hours_week_d[$qlc_this]["Hours Executed"] == null ? 0 : $p_hours_week_d[$qlc_this]["Hours Executed"])) : abs(round(($p_hours_week_d[$qlc_this]["Hours Executed"]-$p_hours_week_d[$qlc_this_time_last]["Hours Executed"])/$p_hours_week_d[$qlc_this_time_last]["Hours Executed"],2)*100)."%<br></p><p style = 'font-size:1.5vh;margin:0;'>".abs(round(($p_hours_week_d[$qlc_this]["Hours Executed"]-$p_hours_week_d[$qlc_this_time_last]["Hours Executed"]),2)))."</p>";?></p>
								</div>
							</div>					
						</div>
					</div>
				</div>	
			</div>
			<div style = "width:100%; height:30vh;">
				<div class = 'background_mask' style = "width:30%; box-shadow:0px 0px 0px 5px #454545 inset; height:100%; float:left;">
					<div class = "buttons" style = "height:26vh; margin: 2vh 1% 2vh 1%">
							<div style = "color: white; background-color: #454545; border-radius: 10px; border: 0.4vh solid #39ac39; height: 100%; width: 45%; display: inline-block;">
								<h1 style = "font-size:2.5vh;">PRODUCTION</h1>
								<div>
								<button style = "margin: 0.25vh 0% 0.25vh 0%; width: 60%; height: 7vh; font-size: 2vh; text-align: center; border: none; color:white;" class = "green" onclick = "location.href = '../PRODUCTION/TABLE/production table/BASE_production_table.php'" id = "b_one">TABLE</button><!--
							 --><button style = "margin: 0.25vh 0% 0.25vh 0%; width: 30%; height: 7vh; font-size: 2vh; text-align: center; border: none; color:black;" class = "total_container" id = "green" onclick = "location.href = '../PRODUCTION/TABLE/production table/BASE_production_table.php'"><?= $live_orders_hours[0][0]?></button>
								</div>
								<div>
								<button style = "margin: 0.25vh 0% 0.25vh 0%; width: 60%; height: 7vh; font-size: 2vh; text-align: center; border: none; color:white;" class = "orange" onclick = " location.href = '../PRODUCTION/SCHEDULE/production schedule/BASE_production_schedule.php'" id = "b_two">SCHEDULE</button><!--
							 --><button style = "margin: 0.25vh 0% 0.25vh 0%; width: 30%; height: 7vh; font-size: 2vh; text-align: center; border: none; color:black;" class = "total_container" id = "orange" onclick = "location.href = '../PRODUCTION/SCHEDULE/production schedule/BASE_production_schedule.php'"><?= $full_schedule_count[0]["All Orders"]?></button>
								</div>
								<div>
								<button style = "margin: 0.25vh 0% 0.25vh 0%; width: 60%; height: 7vh; font-size: 2vh; text-align: center; border: none; color:white;" class = "red" id = "b_six" onclick = "location.href = '../PRODUCTION/EXCEPTIONS/production exceptions/BASE_production_exceptions.php'">EXCEPTIONS</button><!--
							 --><button style = "margin: 0.25vh 0% 0.25vh 0%; width: 30%; height: 7vh; font-size: 2vh; text-align: center; border: none; color:black;" class = "total_container" id = "red" onclick = "location.href = '../PRODUCTION/TABLE/production_exceptions/BASE_production_exceptions.php'"><?= $p_exceptions;?></button>
								</div>
							</div>
							<div style = "color: white; background-color: #454545; border-radius: 10px; border: 0.4vh solid #39ac39; height: 100%; width: 45%; display: inline-block;">
								<h1 style = "font-size:2.5vh;">PRE PRODUCTION</h1>
								<div>
								<button style = "margin: 0.25vh 0% 0.25vh 0%; width: 60%; height: 7vh; font-size: 2vh; text-align: center; border: none; color:white;" class = "green" onclick = "location.href = '../PRE PRODUCTION/TABLE/pre production table/BASE_pre_production_table.php'" id = "b_one">TABLE</button><!--
							 --><button style = "margin: 0.25vh 0% 0.25vh 0%; width: 30%; height: 7vh; font-size: 2vh; text-align: center; border: none; color:black;" class = "total_container" id = "green" onclick = "location.href = '../PRE PRODUCTION/TABLE/pre production table/BASE_pre_production_table.php'"><?= $pre_prod_confirmed[0][0]+$pre_prod_potential[0][0]+$pre_prod_forecast[0][0]?></button>
								</div>
								<div>
								<button style = "margin: 0.25vh 0% 0.25vh 0%; width: 60%; height: 7vh; font-size: 2vh; text-align: center; border: none; color:white;" class = "orange" onclick = "location.href = '../PRE PRODUCTION/SCHEDULE/pre production schedule/BASE_pre_production_schedule.php'" id = "b_two">SCHEDULE</button><!--
							 --><button style = "margin: 0.25vh 0% 0.25vh 0%; width: 30%; height: 7vh; font-size: 2vh; text-align: center; border: none; color:black;" class = "total_container" id = "orange" onclick = "location.href = '../PRE PRODUCTION/SCHEDULE/pre production schedule/BASE_pre_production_schedule.php'"><?= $pre_prod_confirmed[0][0]+$pre_prod_potential[0][0]+$pre_prod_forecast[0][0]?></button>
								</div>
								<div>
								<button style = "margin: 0.25vh 0% 0.25vh 0%; width: 60%; height: 7vh; font-size: 2vh; text-align: center; border: none; color:white;" class = "red" id = "b_six" onclick = "location.href = '../PRE PRODUCTION/EXCEPTIONS/pre production exceptions/BASE_pre_production_exceptions.php'">EXCEPTIONS</button><!--
							 --><button style = "margin: 0.25vh 0% 0.25vh 0%; width: 30%; height: 7vh; font-size: 2vh; text-align: center; border: none; color:black;" class = "total_container" id = "red" onclick = "location.href = '../PRE PRODUCTION/EXCEPTIONS/pre production exceptions/BASE_pre_production_exceptions.php'"><?= $pp_exceptions;?></button>
								</div>
							</div>
						</div>
					</div>
					<div class = 'background_mask' style = "width:20%; height:100%; box-shadow:0px 0px 0px 5px #454545 inset; float:left;">
						<div style = "height:26vh; margin:2vh 5% 2vh 5%; width:90%;">
							<table style = 'height:100%; font-size:2vh; border-radius: 1.5vh 1.5vh 0 0;width:98%; margin: 0% 1% 0% 1%; background-color:white;' class = 'sticky'>
								<tr style = "background-color:#454545;">
									<th style = "width:45%; border-radius: 1.5vh 0 0 0;">Job Type</th>
									<th style = "width:27.5%;">Hours</th>
									<th style = "width:27.5%; border-radius: 0 1.5vh 0 0;">Value</th>
								</tr>
								<tr style = "color:black;">
									<td id = 'td_stringdata'>LIVE ORDERS</td>
									<td id = 'td_stringdata'><?= number_format($live_orders_hours[0][1],0);?></td>
									<td id = 'td_stringdata'><?= "€".round(($live_orders_val[0][1]/1000000.00),2)." M";?></td></tr>
								<tr style = "color:black;">
									<td id = 'td_stringdata'>PRE PROD C</td>
									<td id = 'td_stringdata'><?= number_format($pre_prod_confirmed[0][1],0);?></td>
									<td id = 'td_stringdata'><?= "€".round(($pre_prod_confirmed[0][2]/1000000.00),2)." M";?></td>
								</tr>
								<tr style = "color:black;">
									<td id = 'td_stringdata'>PRE PROD P</td>
									<td id = 'td_stringdata'><?= number_format($pre_prod_potential[0][1],0);?></td>
									<td id = 'td_stringdata'><?= "€".round(($pre_prod_potential[0][2]/1000000.00),2)." M";?></td></tr>
								</tr>
								<tr style = "color:black;">
									<td id = 'td_stringdata'>PRE PROD F</td>
									<td id = 'td_stringdata'><?= number_format($pre_prod_forecast[0][1],0);?></td>
									<td id = 'td_stringdata'><?= "€".round(($pre_prod_forecast[0][2]/1000000.00),2)." M";?></td></tr>
								</tr>
								<tr style = "color:black;">
									<td id = 'td_stringdata'>TOTAL</td>
									<td id = 'td_stringdata'><?= number_format($live_orders_hours[0][0]+$pre_prod_confirmed[0][1]+$pre_prod_potential[0][1],0);?></td>
									<td id = 'td_stringdata'><?= "€".round((($live_orders_val[0][1]+$pre_prod_confirmed[0][2]+$pre_prod_potential[0][2])/1000000.00),2)." M";?></td>
								</tr>
							</table>
						</div>
					</div><!--
				--><div class = 'background_mask' style = "width:50%; height:100%; box-shadow:0px 0px 0px 5px #454545 inset; float:right">
						<div style = "height:26vh; margin:2vh 1.5% 2vh 0.75%; width:64%; float:left;">
							<table style = 'height:100%; font-size:2vh; border-radius: 1.5vh 1.5vh 0 0;width:98%; margin: 0% 1% 0% 1%; background-color:white;' class = 'sticky'>
								<tr style = "background:#454545">
									<th style = "width:70%; border-radius:1.5vh 0 0 0;">Hours To Floor</th>
									<th style = "width:30%;  border-radius:0 1.5vh 0 0;"></th>
								</tr>
								<tr style = "color:black;">
									<td class = "lefttext">Planned Hours On Schedule</td>
									<td class = "lefttext"><?= number_format($live_orders_hours[0][1],0);?></td>
								</tr>
								<tr style = "color:black;">	
									<td class = "lefttext">Hours Executed</td>
									<td class = "lefttext"><?= number_format($live_orders_hours[0][2],0);?></td>
									
								</tr>
								<tr style = "color:black;">
									<td class = "lefttext">Remaining Workload</td>
									<td class = "lefttext"><?= number_format($live_orders_hours[0][3],0);?></td>
								</tr>
								<tr style = "color:black;">
									<td class = "lefttext">Unplanned Deficit</td>
									<td class = "lefttext"><?= number_format($live_orders_hours[0][4],0);?></td>
									
								</tr>	
								<tr style = "color:black;">
									<td class = "lefttext">Last Five Weeks Average To Floor</td>
									<td class = "lefttext"><?= number_format($five_week_average_prod[0][1],0)." wtd ".number_format($five_week_average_prod[1][1],0);?></td>
								</tr>	
							</table>
						</div>
						<div style = "width:30%; height:100%; margin:0 0.75% 0 1.5%; float:left;">
                            <img style = "height:85%; position:relative; top:7.5%; width:100%;" src = "../../RESOURCES/KENTS_TRANS.png">
						</div>		
					</div>
				</div>
			</div>
		</div>
	</body>
</html>