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
        
        <script>
            $(function() {
                $("table.sortable").tablesorter({
                    theme : "blackice",
                    dateFormat : "ddmmyyyy",
                    headers : {
                        9: {sorter: "shortDate"}
                    }
                });
            });
        </script>

		<!-- GET JSON DATA -->
		<?php $status_orders = json_decode(file_get_contents(__DIR__.'\CACHED\status_table_data.json'),true); ?>

		<!-- PHP HEADER CALCULATIONS -->
		<?php
			date_default_timezone_set('Europe/London');
			// GET DATA FROM ONCLICK EVENT FROM TD ELEMENT IN FINANCE TABLE AND CONVERT TO ARRAY
			$id = $_GET['ID'];
			$drilldown_conditions = explode(',', $id);

			// INDEXES FOR GET DATA
			$status_index = 0;
			$month_index = 1;
			$year_index = 2;

			// TABLE TOTAL TRACKER
			$sum = 0;

			// SET TABLE STATUS TITLE DEPENDING ON TABLE CELL CLICKED ON PREVIOUS PAGE SWITCH 1 = STATUS, SWITCH 2 = MONTH NO. OR TOTAL I.D.
			// NEXT FOUR MONTHS == 1111, REST OF YEAR TOTALS = 2222, THIS YEAR TOTALS = 3333, NEXT TWELVE MONTHS TOTALS = 4444
			switch ($drilldown_conditions[$status_index])
			{
				case 0: $status_title = "Complete ";  					break;
				case 1: $status_title = "Pre Production Forecast ";		break;
				case 2: $status_title = "Pre Production Potential ";	break;
				case 3: $status_title = "Pre Production Confirmed ";	break;
				case 4: $status_title = "Live and Paused ";				break;
				case 5: $status_title = "All";							break;
				case 6: $status_title = "Complete In Stock";			break;
			}
			switch($drilldown_conditions[$month_index])
			{
				case 1111 :	$table_title = "$status_title Deliverables For Next Four Months";		break;
				case 2222 : $table_title = "$status_title Deliverable For Rest Of This Year";		break;
				case 3333 : $table_title = "$status_title Deliverable For This Year";				break;
				case 4444 : $table_title = "$status_title Deliverables For Net Twelve Months";		break;
				default : $table_title = "$status_title Deliverables For ".date('F', mktime(0, 0, 0, $drilldown_conditions[$month_index], 10))." ".$drilldown_conditions[$year_index];	break;
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
                    <p><?php echo date("d-m-Y H:i:s" , json_decode(file_get_contents(__DIR__.'\CACHED\data_last_updated.json'),true)); ?><p>
					<!-- RELOAD BUTTON CALLS GETDATA PHP FILE PASSING ON DRILLDOWN CONDITIONS SO IT CAN BE PASSED BACK WHEN GETDATA RECALLS CURRENT PAGE -->
                    <button id = "reload_button" class = "dashboard_option"><img src = "./reload.png" width="100%" height="100%" onclick = "location.href='BASE_SUB_getdata.php?ID=<?php echo $drilldown_conditions[0].','.$drilldown_conditions[1].','.$drilldown_conditions[2]; ?>'"></button> 
                </div> 
            </div>
			<div id = "finance_status_table" class = "submenu_fulltable">
				<div id = 'tablehead'>
					<p id = 'tablehead_text' style = "width:70%;"><?php echo $table_title;?></p>
					<button style = "position:relative; vertical-align:top; height:65%; top:25%; width:2%; padding:0; border:none; left:13%; background:none;" onclick="export_pre_production_table_to_excel('finance_drilldown')"><img src="Excel.svg" style = "height:100%; width:100%;" alt="Italian Trulli"></button>
				</div>
				<div id = "table_container">
					<div id = "scroll">
						<table id = "finance_drilldown" style = 'font-size:15px;' class = "sortable">
							<thead>
								<tr>
									<?php 
										switch($drilldown_conditions[$status_index])
										{
											case 0: $quantity_reference = "Complete Quantity"; break;
											case 1: $quantity_reference = "Open Quantity"; break;
											case 2: $quantity_reference = "Open Quantity"; break;
											case 3: $quantity_reference = "Open Quantity"; break;
											case 4: $quantity_reference = "To Make"; break;
											case 5: $quantity_reference = "Open Quantity"; break;
											case 6: $quantity_reference = "In Stock"; break;
										}
									?>
									<th width = "5%;" class = "lefttext">SO 						        </th>
									<th width = "5%;" class = "lefttext">Status		 						</th>
									<th width = "15%;"class = "lefttext">Customer 							</th> 
									<th width = "20%;"class = "lefttext">Item Description					</th>
                                    <th style = "display:none;">SAP Code                                    </th>
                                    <th style = "display:none;">Item Group Name                             </th> 
                                    <th style = "display:none;">Product Group 1                             </th> 
                                    <th style = "display:none;">Product Group 2                             </th> 
                                    <th style = "display:none;">Date Master Created                         </th> 
									<th width = "10%;"class = "lefttext">Project 							</th> 
									<th width = "6%;" class = "lefttext"> Order Quantity 					</th> 
									<th width = "6%;" class = "lefttext"><?php echo $quantity_reference; ?>	</th> 
									<th width = "6%;" class = "lefttext">Unit Price 					    </th>  
									<th width = "6%;" class = "lefttext">Value 								</th> 
									<th width = "8%;" class = "lefttext">Promise Date 						</th>
                                    <th style = "display:none">Promise Week                                 </th>
                                    <th style = "display:none">Promise Month                                </th>
                                    <th style = "display:none">Promise Year                                 </th>
									<th width = "8%;" class = "lefttext">Sales Person 						</th>
                                    <th style = "display:none">Business Unit                                </th>
                                    <th style = "display:none">Country                                      </th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($status_orders as $row)
									{
										// DEPENDING ON WHICH TABLE CELL WAS CLICKED NON RELEVANT LINES WILL BE SKIPPED
										// MONTH NO OR I.D.
										if($drilldown_conditions[$month_index] == 1111  && (date('m') + 4 - $row["Month"]+ (date('Y') - $row["Year"])*12) > 4){continue;}
										if($drilldown_conditions[$month_index] == 1111  && (date('m') + 4 - $row["Month"]+ (date('Y') - $row["Year"])*12) <= 0){continue;}
										if($drilldown_conditions[$month_index] == 2222  && ($row["Year"] != date('Y') || ($row["Year"] == date('Y') && $row["Month"] < date('m')))){continue;}
										if($drilldown_conditions[$month_index] == 3333  && ($row["Year"] != date('Y'))){continue;}
										if($drilldown_conditions[$month_index] == 4444  && (date('m') + 12 - $row["Month"] + (date('Y') - $row["Year"])*12) > 12){continue;}	
										if($drilldown_conditions[$month_index]  < 1000 &&  ($row["Month"] != $drilldown_conditions[$month_index] || $row["Year"] != $drilldown_conditions[$year_index])) {continue;}
										// PRE PRODUCTION STATUS
										if($drilldown_conditions[$status_index] == 0 && $row["Delivered Qty"] == 0){continue;}
										if($drilldown_conditions[$status_index] == 1 && $row["Status LHS"] != 'Pre Production Forecast'){continue;}
										if($drilldown_conditions[$status_index] == 2 && $row["Status LHS"] != 'Pre Production Potential'){continue;}
										if($drilldown_conditions[$status_index] == 3 && $row["Status LHS"] != 'Pre Production Confirmed'){continue;}
										if($drilldown_conditions[$status_index] == 4 && $row["Status LHS"] != 'Live'){continue;}
										if($drilldown_conditions[$status_index] == 6 && $row["Status RHS"] != 'In Stock'){continue;}
										

										// IF COMPLETE COLUMN IS CLICKED SHOW QUANTITY AND VALUE OF THE ITEM THAT IS DELIVERED
										if($drilldown_conditions[$status_index] == 0)
										{	
											$value = $row["Complete Total"];
											$qty = 	$row["Delivered Qty"]; 
										}
										// IF TOTAL COLUMN  IS CLICKED ADD BOTH AND DISPLAY
										else if($drilldown_conditions[$status_index] == 5)
										{	
											$value = $row["Complete Total"] + $row["Open Live Total"];
											$qty = 	$row["Delivered Qty"] + $row["Remaining Qty"];
										}
										else if($drilldown_conditions[$status_index] == 6)
										{	
											$value = $row["In Stock Live Total"];
											$qty = 	$row["On Hand"]; 
										}
                                        else if($drilldown_conditions[$status_index] == 4)
										{
											$value = $row["Open Live Total"];
											$qty = $row["Open Live Qty"] < 0 ? 0 : $row["Open Live Qty"];
										}

										// IF OPEN COLUMN (PP_For, PP_Pot ETC) IS CLICKED SHOW QUANTITY AND VALUE OF THE REMAINING QUANTITY OF THE ITEM
										else
										{
											$value = $row["Open Live Total"];
											$qty = $row["Remaining Qty"];
										}

										// REMOVE SPACES AND NON ALPHANUMERIC CHARACTERS FROM ATTRIBUTES WE WANT TO FILTER BY
										$sales_person = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Sales Person"]));
										$customer = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Customer"]));

										// ECHO ROW AND ASSIGN FILTERABLE ATTRIBUTES FOLLOWED BY TD ELEMENTS FOR EACH OF THE ROWS FIGURES
										echo "<tr sales_person = $sales_person customer = $customer>";
											echo "<td class = 'lefttext'>"	.$row["Sales Order"]																			."</td>";
											echo "<td class = 'lefttext'>"  .$row["Status Name"]																			."</td>";
											echo "<td class = 'lefttext'>"	.$row["Customer"]																				."</td>";
											echo "<td class = 'lefttext'>"	.$row["Description"]																			."</td>";
                                            echo "<th style = 'display:none;'>".$row["Item Code"]                                                                           ."</th>";
                                            echo "<th style = 'display:none;'>".$row["Item Group Name"]                                                                     ."</th>"; 
                                            echo "<th style = 'display:none;'>".$row["Product Group One"]                                                                   ."</th>"; 
                                            echo "<th style = 'display:none;'>".$row["Product Group Two"]                                                                   ."</th>"; 
                                            echo "<th style = 'display:none;'>".$row["Date Master Created"]                                                                 ."</th>";
											echo "<td class = 'lefttext'>"	.$row["Project"]																				."</td>";
											echo "<td class = 'righttext'>"	.(($drilldown_conditions[$status_index] == 6 ? floatval($row["Remaining Qty"]) : floatval($row["Full Order Qty"])))."</td>";
											echo "<td class = 'righttext'>"	.floatval($qty)																			        ."</td>";
											echo "<td class = 'righttext'>"	."€ ".number_format($row["Unit Price"],2)														."</td>";
											echo "<td class = 'righttext'>"	."€ ".number_format($value,2)																	."</td>";
											echo "<td class = 'righttext'>"	.$row["Promise Date"]																			."</td>";
                                            echo "<th style = 'display:none;'>".$row["Week"]                                                                        ."</th>"; 
                                            echo "<th style = 'display:none;'>".$row["Month"]                                                                       ."</th>"; 
                                            echo "<th style = 'display:none;'> ".$row["Year"]                                                                       ."</th>";
											echo "<td class = 'lefttext'>"	.$row["Sales Person"]																			."</td>";
                                            echo "<th style = 'display:none;'>".$row["Business Unit"]                                                                       ."</th>"; 
                                            echo "<th style = 'display:none;'>".$row["Country"]                                                                             ."</th>";
										echo "</tr>";

										// ADD VALUE TO TOTAL
										$sum+=$value;
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
									// DYNAMICALLY CREATE FILTER OPTIONS BY ALL UNIQUE PROJECT NAMES IN QUERY
									$customers = array($status_orders[0]["Customer"]);
									foreach($status_orders as $row)
									{
										// DEPENDING ON WHICH TABLE CELL WAS CLICKED NON RELEVANT LINES WILL BE SKIPPED
										// MONTH NO OR I.D.
										if($drilldown_conditions[$month_index] == 1111  && (date('m') + 4 - $row["Month"]+ (date('Y') - $row["Year"])*12) > 4){continue;}
										if($drilldown_conditions[$month_index] == 1111  && (date('m') + 4 - $row["Month"]+ (date('Y') - $row["Year"])*12) <= 0){continue;}
										if($drilldown_conditions[$month_index] == 2222  && ($row["Year"] != date('Y') || ($row["Year"] == date('Y') && $row["Month"] < date('m')))){continue;}
										if($drilldown_conditions[$month_index] == 3333  && ($row["Year"] != date('Y'))){continue;}
										if($drilldown_conditions[$month_index] == 4444  && (date('m') + 12 - $row["Month"] + (date('Y') - $row["Year"])*12) > 12){continue;}	
										if($drilldown_conditions[$month_index]  < 1000 &&  ($row["Month"] != $drilldown_conditions[$month_index] || $row["Year"] != $drilldown_conditions[$year_index])) {continue;}
										// PRE PRODUCTION STATUS
										if($drilldown_conditions[$status_index] == 0 && !in_array($row["Sales Order Status"], array('C'))){continue;}
										if($drilldown_conditions[$status_index] == 1 && ($row["Sales Order Status"] == 'C' || !in_array($row["PP_Status"], array('Pre Production Forecast')))){continue;}
										if($drilldown_conditions[$status_index] == 2 && ($row["Sales Order Status"] == 'C' || !in_array($row["PP_Status"], array('Pre Production Potential')))){continue;}
										if($drilldown_conditions[$status_index] == 3 && ($row["Sales Order Status"] == 'C' || !in_array($row["PP_Status"], array('Pre Production Confirmed')))){continue;}
										if($drilldown_conditions[$status_index] == 4 && ($row["Sales Order Status"] == 'C' || !in_array($row["PP_Status"], array('Live','Paused','NO STATUS')))){continue;}

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
									sort($customers);
									for($i = 0; $i < sizeof($customers); $i++)
									{
										echo "<option value = '".str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $customers[$i]))."'>".$customers[$i]."</option>";
									}
								?>
							</select>
						</div>
					</div><div id = "supplimentary_block">
						<div class = "centered">
							<p id = "valuetext"><br></p>
							<p id = "valuetext"><?php echo "€ ".number_format($sum,2); ?></p>
							<p id = "valuetext"><br></p>
						</div>
					</div><div id = "supplimentary_block">
						<div class = "centered">
							<p id = "valuetext"><br></p>
							<p id = "valuetext">Value 2</p>
							<p id = "valuetext"><br></p>	
						</div>
					</div><div id = "supplimentary_block">
						<div class = "centered">
							<p id = "select_title">Sales Person</p>
							<select id = "select_sales_person">
							<option value = "All">All</option>
								<?php
									// DYNAMICALLY CREATE FILTER OPTIONS BY ALL UNIQUE PROJECT NAMES IN QUERY
									$sales_people = array($status_orders[0]["Sales Person"]);
									foreach($status_orders as $row)
									{
										// DEPENDING ON WHICH TABLE CELL WAS CLICKED NON RELEVANT LINES WILL BE SKIPPED
										// MONTH NO OR I.D.
										if($drilldown_conditions[$month_index] == 1111  && (date('m') + 4 - $row["Month"]+ (date('Y') - $row["Year"])*12) > 4){continue;}
										if($drilldown_conditions[$month_index] == 1111  && (date('m') + 4 - $row["Month"]+ (date('Y') - $row["Year"])*12) <= 0){continue;}
										if($drilldown_conditions[$month_index] == 2222  && ($row["Year"] != date('Y') || ($row["Year"] == date('Y') && $row["Month"] < date('m')))){continue;}
										if($drilldown_conditions[$month_index] == 3333  && ($row["Year"] != date('Y'))){continue;}
										if($drilldown_conditions[$month_index] == 4444  && (date('m') + 12 - $row["Month"] + (date('Y') - $row["Year"])*12) > 12){continue;}	
										if($drilldown_conditions[$month_index]  < 1000 &&  ($row["Month"] != $drilldown_conditions[$month_index] || $row["Year"] != $drilldown_conditions[$year_index])) {continue;}
										// PRE PRODUCTION STATUS
										if($drilldown_conditions[$status_index] == 0 && !in_array($row["Sales Order Status"], array('C'))){continue;}
										if($drilldown_conditions[$status_index] == 1 && ($row["Sales Order Status"] == 'C' || !in_array($row["PP_Status"], array('Pre Production Forecast')))){continue;}
										if($drilldown_conditions[$status_index] == 2 && ($row["Sales Order Status"] == 'C' || !in_array($row["PP_Status"], array('Pre Production Potential')))){continue;}
										if($drilldown_conditions[$status_index] == 3 && ($row["Sales Order Status"] == 'C' || !in_array($row["PP_Status"], array('Pre Production Confirmed')))){continue;}
										if($drilldown_conditions[$status_index] == 4 && ($row["Sales Order Status"] == 'C' || !in_array($row["PP_Status"], array('Live','Paused','NO STATUS')))){continue;}

										for($i = 0 ; $i < sizeof($sales_people) ; $i++)
										{
											if($row["Sales Person"] == $sales_people[$i])
											{
												break;
											}
											else if($row["Sales Person"] != $sales_people[$i] && $i == sizeof($sales_people)-1)
											{
												array_push($sales_people, $row["Sales Person"]);
												break;
											}
										}
									}
									sort($sales_people);
									for($i = 0; $i < sizeof($sales_people); $i++)
									{
										echo "<option value = '".str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $sales_people[$i]))."'>".$sales_people[$i]."</option>";
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