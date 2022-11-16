<!DOCTYPE HTML> 
<html> 
	<head>
		<!-- META STUFF -->
		<meta charset = "utf-8">
		<meta name = "description" content = "meta description">
		<meta name = "viewpport" content = "width=device-width, initial-scale = 1">

		<!-- JS LIBRARY DEPENDANCIES -->
		<script type = "text/javascript" src = "../../../../js/libs/jquery-3.4.1.js"></script>
        <script type = "text/javascript" src = "../../../../JS/LIBS/jquery.tablesorter.js"></script>
        <script type = "text/javascript" src = "../../../../JS/LIBS/jquery.tablesorter.widgets.js"></script>

		<!-- JS FILES -->
		<script type = "text/javascript" src = "./JS_filters.js"></script>
		<script type = "text/javascript" src = "./JS_table_to_excel.js"></script>
		
		<!-- CSS FILES -->
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>  
		<link rel = "stylesheet" href = "../../../../CSS/KS_DASH_STYLE.css">
        <link rel = "stylesheet" href = "../../../../css/theme.blackice.min.css">	

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

		<!-- GET JSON DATA -->
		<?php $delivered_orders = json_decode(file_get_contents(__DIR__.'\CACHED\delivered_table_data.json'),true); ?>

		<!-- PHP HEADER CALCULATIONS -->
		<?php
			date_default_timezone_set('Europe/London');
			// GET DATA FROM ONCLICK EVENT FROM TD ELEMENT IN FINANCE TABLE OR FROM REFRESH PASSTHROUGH AND CONVERT TO ARRAY
			$id = $_GET['ID'];
			$drilldown_conditions = explode(',', $id);
		
			// INDEXES FOR GET DATA
			$status_index = 0;
			$month_index = 1;
			$year_index = 2;

			// TABLE TOTAL TRACKERS
			$sum = 0;
			$sum_late = 0;
		
			// GET MONTH NUMBER IN STRING FORMAT AND YEAR
			$month_name = date('F', mktime(0, 0, 0, $drilldown_conditions[$month_index], 10));
			$year = $drilldown_conditions[$year_index]; 
		
			// SET TABLE TITLE DEPENDING ON TABLE CELL CLICKED ON PREVIOUS PAGE
			// NEXT FOUR MONTHS == 1111, REST OF YEAR TOTALS = 2222, THIS YEAR TOTALS = 3333, NEXT TWELVE MONTHS TOTALS = 4444
			switch($drilldown_conditions[$month_index])
			{
				case 1111 :		$table_title = "All Delivery Notes Orders For Next Four Months";	break;
				case 2222 : 	$table_title = "All Delivery Notes Orders For Rest Of This Year";	break;
				case 3333 : 	$table_title = "All Delivery Notes Orders For This Year";			break;
				case 4444 : 	$table_title = "All Delivery Notes Orders For Net Twelve Months";	break;
				default : 		$table_title = "Delivery Notes Orders For ".date('F', mktime(0, 0, 0, $drilldown_conditions[$month_index], 10))." ".$drilldown_conditions[$year_index];		break;
			}
		?>
	</head>
    <body>
        <div id = 'background'>
            <div id = 'navmenu'>
                <div>
                    <p id = 'title'>Kent Stainless</p>
                </div>
                <nav>
                    <ul id = 'dashboard_list'>
					<li id = "management_option" class = "dashboard_option activebtn" onclick = "history.go(-1);">Back<li>
                    </ul>    
                </nav>
				<div id = "lastupdateholder">
                    <p>Last Updated</p>
                    <p><?php echo date("d-m-Y H:i:s" , json_decode(file_get_contents(__DIR__.'\CACHED\data_last_updated.json'),true))." GMT"; ?><p>
					<!-- RELOAD BUTTON CALLS GETDATA PHP FILE PASSING ON DRILLDOWN CONDITIONS SO IT CAN BE PASSED BACK WHEN GETDATA RECALLS CURRENT PAGE -->
                    <button id = "reload_button" class = "dashboard_option"><img src = "./reload.png" width="100%" height="100%" onclick = "location.href='BASE_SUB_getdata.php?ID=<?php echo $drilldown_conditions[0].','.$drilldown_conditions[1].','.$drilldown_conditions[2]; ?>'"></button> 
                </div> 
            </div>
			<div id = "finance_delivered_table" class = "submenu_fulltable">
				<div id = 'tablehead'>
					<p id = 'tablehead_text' style = "width:70%;"><?php echo $table_title;?></p>
					<button style = "position:relative; vertical-align:top; height:65%; top:25%; width:2%; padding:0; border:none; left:13%; background:none;" onclick="export_pre_production_table_to_excel('finance_drilldown')"><img src="Excel.svg" style = "height:100%; width:100%;" alt="Italian Trulli"></button>
				</div>
				<div id = "table_container">
					<div id = "scroll">
						<table id = "finance_drilldown" style = 'font-size:15px;' class = "sortable">
							<thead>
								<tr style = 'font-size:15px;'>
									<th width = "6%;"> 		Issue Date 				</th>
									<th width = "6%;"> 		Promse Date 			</th>
									<th width = "6%;" style = "display:none;"> 	    Delivery Note			</th>
                                    <th width = "5%;"> 	    Item Code 				</th>  
									<th width = "22%;"> 	Item Description		</th>
                                    <th width = "5%;"> 	    Delivered Qty			</th>  
									<th width = "5%;"> 		Delivery Value 			</th> 
									<th width = "5%;"> 		Line Qty 				</th> 
									<th width = "5%;"> 		Line Value 				</th>
									<th width = "5%;"> 		Remaining Quantity 		</th>
                                    <th width = "13%;"> 	Customer 				</th>
                                    <th width = "5%;"> 		Sales Order 			</th>
                                    <th width = "12%;">     Engineer		 		</th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($delivered_orders as $row)
									{
										// DEPENDING ON WHICH MONTH CONDITION IS ACTIVE (NEXT FOUR MONTHS, THIS YEAR, THIS MONTH ONLY ETC) FROM FINANCE TABLE ONCLICK SKIP TO NEXT ROW APPROOPRIATY NOT PRINTING OR ADDING TO TOTALS FOR CURRENT ROW)
										if($drilldown_conditions[$month_index] == 1111  && (date('m') + 4 - $row["Month"]+ (date('Y') - $row["Year"])*12) > 4){continue;}
										if($drilldown_conditions[$month_index] == 1111  && (date('m') + 4 - $row["Month"]+ (date('Y') - $row["Year"])*12) <= 0){continue;}
										if($drilldown_conditions[$month_index] == 2222  && ($row["Year"] != date('Y') || ($row["Year"] == date('Y') && $row["Month"] < date('m')))){continue;}
										if($drilldown_conditions[$month_index] == 3333  && ($row["Year"] != date('Y'))){continue;}
										if($drilldown_conditions[$month_index] == 4444  && (date('m') + 12 - $row["Month"]+ (date('Y') - $row["Year"])*12) > 12 || (date('m') + 12 - $row["Month"]+ (date('Y') - $row["Year"])*12) <= 0){continue;}	
										if($drilldown_conditions[$month_index]  < 1000 	&& $row["Month"] != $drilldown_conditions[$month_index]) {continue;}
										if($drilldown_conditions[$month_index]  < 1000 	&& $row["Year"] != $drilldown_conditions[$year_index]) {continue;}
										

										// REMOVE SPACES AND NON ALPHANUMERIC CHARACTERS FROM ATTRIBUTES WE WANT TO FILTER BY
										$customer = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Customer"]));
										$engineer = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Engineer"]));
										$ontime_status = ($row["Ontime"] == 'LATE' ? 'Late' : 'Ontime');

										// ECHO ROW AND ASSIGN FILTERABLE ATTRIBUTES FOLLOWED BY TD ELEMENTS FOR EACH OF THE ROWS FIGURES
										echo "<tr customer = $customer engineer = $engineer ontime_status = $ontime_status>";
											echo "<td>"							.$row["Issue Date"]																	."</td>";
											echo "<td>"							.$row["Promise Date"]																."</td>";
											echo "<td style = 'display:none;'>"	                        .$row["Delivery Note Number"]														."</td>";
											echo "<td>"	                        .$row["Item Code"]																	."</td>";
											echo "<td id = 'td_stringdata'>"	.$row["Description"]																."</td>";
											echo "<td>"							.$row["Delivery Qty"]																."</td>";
											echo "<td>"							.($row["Delivery Value"] == 0 ? '0.00' : number_format($row["Delivery Value"],0))	."</td>";
											echo "<td>"							.$row["Line Qty"]																	."</td>";
											echo "<td>"							.number_format($row["Line Value"],0)												."</td>";
                                            echo "<td>"							.$row["Remaining Qty"]																."</td>";
                                            echo "<td id = 'td_stringdata'>"	.$row["Customer"]																	."</td>";
                                            echo "<td>"							.$row["Sales Order"]																."</td>";
                                            echo "<td id = 'td_stringdata'>"	.$row["Engineer"]																	."</td>";
										echo "</tr>";

										// ADD DELIVERY VALUE TO TOTAL AND IF IT LATE AS PER SQL QUERY ALSO ADD TO LATE TOTAL
										$sum+=$row["Delivery Value"];
										if($row["Ontime"] == 'LATE')
										{
											$sum_late+=$row["Delivery Value"];
										}
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
				<div id = "suppliments">
					<div id = "supplimentary_block">
						<div class = "centered">
							<p id = "select_title" >Customer</p>
							<select id = "select_customer">
							<option value = "All">All</option>
								<?php
									// DYNAMICALLY CREATE FILTER OPTIONS BY ALL UNIQUE CUSTOMER NAMES
									$customers = array($delivered_orders[0]["Customer"]);
									foreach($delivered_orders as $row)
									{
										// DEPENDING ON WHICH MONTH CONDITION IS ACTIVE (NEXT FOUR MONTHS, THIS YEAR, THIS MONTH ONLY ETC) FROM FINANCE TABLE ONCLICK SKIP TO NEXT ROW APPROOPRIATY NOT PRINTING OR ADDING TO TOTALS FOR CURRENT ROW)
										if($drilldown_conditions[$month_index] == 1111  && (date('m') + 4 - $row["Month"]+ (date('Y') - $row["Year"])*12) > 4){continue;}
										if($drilldown_conditions[$month_index] == 1111  && (date('m') + 4 - $row["Month"]+ (date('Y') - $row["Year"])*12) <= 0){continue;}
										if($drilldown_conditions[$month_index] == 2222  && ($row["Year"] != date('Y') || ($row["Year"] == date('Y') && $row["Month"] < date('m')))){continue;}
										if($drilldown_conditions[$month_index] == 3333  && ($row["Year"] != date('Y'))){continue;}
										if($drilldown_conditions[$month_index] == 4444  && (date('m') + 12 - $row["Month"]+ (date('Y') - $row["Year"])*12) > 12 || (date('m') + 12 - $row["Month"]+ (date('Y') - $row["Year"])*12) <= 0){continue;}	
										if($drilldown_conditions[$month_index]  < 1000 &&  $row["Month"] != $drilldown_conditions[$month_index] || $row["Year"] != $drilldown_conditions[$year_index]) {continue;}


										for($i = 0 ; $i < sizeof($customers) ; $i++)
										{
											if($row["Customer"] == $customers[$i])
											{
												break;
											}
											else if($row["Customer"] != $customers[$i] && $i == sizeof($customers)-1)
											{
												array_push($customers, $row["Customer"]);
												break;
											}
										}
									}
									//sort($customers);
									for($i = 0; $i < sizeof($customers); $i++)
									{
										echo "<option value = '".str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $customers[$i]))."'>".$customers[$i]."</option>";
									}
								?>
							</select>
						</div>
					</div><div id = "supplimentary_block">
						<div class = "centered">
							<!-- PRINT TOTALS -->
							<p id = "valuetext" style = "text-align:left; padding-left:5vh;"><?php echo "Total: € ".number_format($sum,2); ?></p>
							<p id = "valuetext" style = "text-align:left; padding-left:5vh;"><?php echo "Late : € ".number_format($sum_late,2); ?></p>
							<p id = "valuetext" style = "text-align:left; padding-left:5vh;"><?php echo "On Time : ".number_format($sum_late == 0 ? 0 :($sum-$sum_late)/$sum*100,2)."%"; ?></p>
						</div>
					</div><div id = "supplimentary_block">
						<div class = "centered">
							<p id = "select_title">On time Status</p>
							<select id = "select_ontime_status">
								<option value = "All">All</option>
								<option value = "Ontime">On Time</option>
								<option value = "Late">Late</option>
							</select>
						</div>
					</div><div id = "supplimentary_block">
						<div class = "centered">
							<p id = "select_title">Engineer</p>
							<select id = "select_engineer">
							<option value = "All">All</option>
								<?php
									// DYNAMICALLY CREATE FILTER OPTIONS BY ALL UNIQUE ENGINEER NAMES
									$engineers = array($delivered_orders[0]["Engineer"]);
									foreach($delivered_orders as $row)
									{
										// DEPENDING ON WHICH MONTH CONDITION IS ACTIVE (NEXT FOUR MONTHS, THIS YEAR, THIS MONTH ONLY ETC) FROM FINANCE TABLE ONCLICK SKIP TO NEXT ROW APPROOPRIATY NOT PRINTING OR ADDING TO TOTALS FOR CURRENT ROW)
										if($drilldown_conditions[$month_index] == 1111  && (date('m') + 4 - $row["Month"]+ (date('Y') - $row["Year"])*12) > 4){continue;}
										if($drilldown_conditions[$month_index] == 1111  && (date('m') + 4 - $row["Month"]+ (date('Y') - $row["Year"])*12) <= 0){continue;}
										if($drilldown_conditions[$month_index] == 2222  && ($row["Year"] != date('Y') || ($row["Year"] == date('Y') && $row["Month"] < date('m')))){continue;}
										if($drilldown_conditions[$month_index] == 3333  && ($row["Year"] != date('Y'))){continue;}
										if($drilldown_conditions[$month_index] == 4444  && (date('m') + 12 - $row["Month"]+ (date('Y') - $row["Year"])*12) > 12 || (date('m') + 12 - $row["Month"]+ (date('Y') - $row["Year"])*12) <= 0){continue;}	
										if($drilldown_conditions[$month_index]  < 1000 &&  $row["Month"] != $drilldown_conditions[$month_index] || $row["Year"] != $drilldown_conditions[$year_index]) {continue;}


										for($i = 0 ; $i < sizeof($engineers) ; $i++)
										{
											if($row["Engineer"] == $engineers[$i])
											{
												break;
											}
											else if($row["Engineer"] != $engineers[$i] && $i == sizeof($engineers)-1)
											{
												array_push($engineers, $row["Engineer"]);
												break;
											}
										}
									}
									sort($engineers);
									for($i = 0; $i < sizeof($engineers); $i++)
									{
										echo "<option value = '".str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $engineers[$i]))."'>".$engineers[$i]."</option>";
									}
								?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body> 
</html>