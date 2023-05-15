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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
</script>
        <?php
            $qla_this = 0;
            $qla_this_time_last = 1;
            $qla_last = 2;
        
            $qlb_this = 0;
            $qlb_last = 1;
        
            $qlc_this = 0;
            $qlc_this_time_last = 1;
        ?>
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
            <div style = "width:100%; height:100%;">
                <div class = 'background_mask' style = "width:100%; height:100%; box-shadow:0px 0px 0px 5px #454545 inset; float:left;">
					<div style = "height:45vh; width:95%; margin: 1.8vh 2.5% 2vh 2.5%">
						<div style = "display:inline-block; height:100%; width:27%; margin:0% 2% 0% 2%;background-color:#dcdcdc;border-radius:3vh;border:3px solid #39ac39; vertical-align:top; color:black;">
							<div style = "height:4.5vh; border-radius:2.5vh 2.5vh 0 0; font-size:1.6vh; background-color:#39ac39;color:white;">
								<h1>YEAR TO DATE</h1>
							</div>
							<div style = "height:19.5vh; margin-top:0px;">
								<div style = "width:100%; height:4vh; margin-bottom:1vh;">
<!--									<div  style = "width:40%; height:4vh; float:left;">
										<h1 style = "font-size:4vh;"><?= $closed_orders_year_d[$qla_this]["Sales Orders"] == null ? 0 : $closed_orders_year_d[$qla_this]["Sales Orders"];?></h1>


									</div>
									<div  style = "width:20%; height:4vh;  float:left;">
										<h1 style = font-size:4vh;><?= ($closed_orders_year_d[$qla_this]["Sales Orders"] - $closed_orders_year_d[$qla_this_time_last]["Sales Orders"]) >= 0 ? "&#9650" : "&#9660"; ?></h1>
									</div>
									<div  style = "width:40%; height:4vh;  float:right;">
										<p style = "font-size:2.5vh; margin:0px; font-weight:bold;"><?= (($closed_orders_year_d[$qla_this_time_last]["Sales Orders"] == null || $closed_orders_year_d[$qla_this_time_last]["Sales Orders"] == 0) ? ("100%</p><p style = 'font-size:1.5vh;margin:0;'>".($closed_orders_year_d[$qla_this]["Sales Orders"]) == null ? "0" : $closed_orders_year_d[$qla_this]["Sales Orders"]) : abs(round((($closed_orders_year_d[$qla_this]["Sales Orders"] - $closed_orders_year_d[$qla_this_time_last]["Sales Orders"])/$closed_orders_year_d[$qla_this_time_last]["Sales Orders"]),2)*100)."%</p><p style = 'font-size:1.5vh;margin:0;'>".abs($closed_orders_year_d[$qla_this]["Sales Orders"] - $closed_orders_year_d[$qla_this_time_last]["Sales Orders"]));?></p>
									</div>


-->

									<p id="demo">STUFF! </p>

									<canvas id="myChart" style="width:100%;max-width:700px"></canvas>
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
					<div style = "height:45vh; width:95%; margin: 2vh 2.5% 2vh 2.5%; color:black;">
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

						<div style = "width:30%; height:100%; margin:0 0.75% 0 1.5%; float:left;">
                            <img style = "height:85%; position:relative; top:7.5%; width:100%;" src = "../../RESOURCES/KENTS_TRANS.png">
						</div>		
					</div>
				</div>
			</div>
		</div>


<script>

   getData();
   async function getData() 
   {
    const response = await fetch("\CACHED\\closed_orders_year_data.json");
    const data = await response.json();
    console.log(data);

//document.getElementById("demo").innerHTML = document.getElementById("demo").innerHTML + "is this working!!!"
// + "<BR/>";

      length = data.length;
      console.log(length);
      labels = [];
      values = [];

      for (i = 0; i < length; i++) 
      {
         labels.push(i);
         values.push(data[i]["Sales Orders"]);

//document.getElementById("demo").innerHTML = document.getElementById("demo").innerHTML + "SHOWTIME!!!!"
// + "<BR/>";

      }



      new Chart(document.getElementById("myChart"), 
      {
         type: 'bar',
         data: 
         {
            labels: labels,
            datasets: 
            [
               {
                  label: "Sales Orders",
                  backgroundColor: ["#3a90cd",
                     "#8e5ea2",
                     "#3bba9f",
                     "#e8c3b9",
                     "#c45850",
                     "#CD9C5C",
                     "#40E0D0"],
                  data: values
               }
            ]
         },
         options: 
         {
            legend: { display: false },
            title: {
               display: true,
               text: 'Closed Sales Orders Year'
            }
         }


     }

     )
}




</script>

	</body>
</html>