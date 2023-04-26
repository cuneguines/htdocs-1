<!DOCTYPE html>
<html>
    <head>
        <!-- INITALISATION AND META STUFF -->
        <title>PRODUCTION SCHEDULE</title>
        <meta name = "viewpport" content = "width=device-width, initial-scale = 1">
        
        <!-- EXTERNAL JAVASCRIPT -->
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>

        <!-- LOCAL JAVASCRIPT -->
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_update_total_rows.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_filters_w_bd.js"></script>  
        <script type = "text/javascript" src = "./JS_table_to_excel.js"></script>
        <script type = "text/javascript" src = "./JS_job_info_buttons.js"></script>   

        <!-- STYLESHEET -->
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
        <link href='../../../../CSS/LT_STYLE.css' rel='stylesheet' type='text/css'>

        <!-- PHP INITALISATION -->
        <?php 
            $start_time = time()-60*60*24*7*5;
            $start_range = -5;
            $end_range = 30;
        ?>
        <?php
            if(isset($_GET['bar_box'])){
                $clause = "and(t4.ItmsGrpNam LIKE '%Dairy Tube 304%'or t4.ItmsGrpNam LIKE '%Dairy Tube 316%'or t4.ItmsGrpNam LIKE '%Box MS' or t4.ItmsGrpNam LIKE '%Box 304%' or t4.ItmsGrpNam LIKE '%Box 316%' or t4.ItmsGrpNam LIKE '%Box 430%'or t4.ItmsGrpNam LIKE '%Box Aluminium%' or t4.ItmsGrpNam LIKE '%Flat Bar% 304' or t4.ItmsGrpNam LIKE '%Bar/Beam%' or t4.ItmsGrpNam LIKE '%Flat Bar% 304' or t4.ItmsGrpNam LIKE '%Flat Bar%' or t4.ItmsGrpNam LIKE '%Round%' or t4.ItmsGrpNam LIKE '%Sch Pipe 304%' or t4.ItmsGrpNam LIKE '%Sch Pipe 316%' or t4.ItmsGrpNam LIKE '%Square%' OR t4.ItmsGrpNam LIKE '%Super%'OR t4.ItmsGrpNam LIKE '%U-Beam%' Or t4.ItmsGrpNam LIKE '%Angle%' Or t4.ItmsGrpNam LIKE '%Pipe Galv%'Or t4.ItmsGrpNam LIKE '%Pipe MS%')";
                $title = "BOM SCHEDULE /BAR STOCK";
                //$type = "OBAR";
            }
            if(isset($_GET['hardware'])){
                $clause = "and  (t4.ItmsGrpNam LIKE '%Consum- Non Job%'or t4.ItmsGrpNam LIKE '%Timber(Materials)%'or t4.ItmsGrpNam LIKE '%Timber Crate/Pallet%'or t4.ItmsGrpNam LIKE '%Consum- Job Related%'or t4.ItmsGrpNam LIKE '%Mesh Grate Finish%' or t4.ItmsGrpNam LIKE '%Paints%' or t4.ItmsGrpNam LIKE '%Mesh Grate Finish%'or t4.ItmsGrpNam LIKE '%Mesh Grate Unfinished%'or t4.ItmsGrpNam LIKE '%FG - Buy To Stock%'or t4.ItmsGrpNam LIKE '%Made To Stock%'or t4.ItmsGrpNam LIKE '%FG - Buy To Stock%'or t4.ItmsGrpNam LIKE '%FG - Configure To Order%'or t4.ItmsGrpNam LIKE '%FG - Made To Order%'or t4.ItmsGrpNam LIKE '%Hardware%' OR t4.ItmsGrpNam LIKE '%Hydraulic fittings%' OR t4.ItmsGrpNam LIKE '%Fittings%' OR t4.ItmsGrpNam LIKE '%Pneumatic Fittings%' OR t4.ItmsGrpNam LIKE '%Seals & Gaskets%' Or t4.ItmsGrpNam LIKE '%Fixings%' Or t4.ItmsGrpNam LIKE '%Site Fixings%'
                Or t4.ItmsGrpNam LIKE '%Solids Stock%'Or t4.ItmsGrpNam LIKE '%Electrical Component%'Or t4.ItmsGrpNam LIKE '%Fittings-Springs%' or t4.ItmsGrpNam LIKE '%Plastics & Glass%'or t4.ItmsGrpNam LIKE '%Pneumatc Fittings%')";
                $title = "BOM SCHEDULE/ HARDWARE";
                //$type = "NBAR";
            }  
            if(isset($_GET['misc_items'])){
                $clause = "and (t4.ItmsGrpNam LIKE '%Bespoke Goods%'or t4.ItmsGrpNam LIKE '%Branded Products%'or t4.ItmsGrpNam LIKE '%Dollinger%' or t4.ItmsGrpNam LIKE '%H & S  (Labour)%' or t4.ItmsGrpNam LIKE '%Hartecast%'or t4.ItmsGrpNam LIKE '%Internal BoM%' or t4.ItmsGrpNam LIKE '%KS MAch Cell Milling' or t4.ItmsGrpNam LIKE '%Labour Production%' or t4.ItmsGrpNam LIKE '%Labour Site%' or t4.ItmsGrpNam LIKE '%Machine Bead Blast%'  or t4.ItmsGrpNam LIKE '%Machine E/Polish%' or t4.ItmsGrpNam LIKE '%Machine Laser%' or t4.ItmsGrpNam LIKE '%Machined Parts%' OR t4.ItmsGrpNam LIKE '%Non-Productive Time%'OR t4.ItmsGrpNam LIKE '%R&D Projects%' Or t4.ItmsGrpNam LIKE '%Rec Access Covers%' Or t4.ItmsGrpNam LIKE '%Solids Mileage Costs%'Or t4.ItmsGrpNam LIKE '%Sub Con - Sales%'Or t4.ItmsGrpNam LIKE '%Wrapping Shed%')";
                $title = "BOM SCHEDULE /MISC-ITEMS";
                //$type = "OBAR";
            }
            if(isset($_GET['other'])){
                $clause = "and(t4.ItmsGrpNam LIKE '%Acid%'or t4.ItmsGrpNam LIKE '%Bead blast%'or t4.ItmsGrpNam LIKE '%Canteen & Cleaning%'or t4.ItmsGrpNam LIKE '%Diesel%' or t4.ItmsGrpNam LIKE '%Documents & Manuals%' or t4.ItmsGrpNam LIKE '%Capital Works%'or t4.ItmsGrpNam LIKE '%Kitchen%' or t4.ItmsGrpNam LIKE '%Laser Consu%' or t4.ItmsGrpNam LIKE '%Maint - Machine%' or t4.ItmsGrpNam LIKE '%Maint - Premises%' or t4.ItmsGrpNam LIKE '%Marketing Supply%'  or t4.ItmsGrpNam LIKE '%Obsolete%' or t4.ItmsGrpNam LIKE '%Plant Hire%' or t4.ItmsGrpNam LIKE '%Plant Tools%' OR t4.ItmsGrpNam LIKE '%PPE%'OR t4.ItmsGrpNam LIKE '%Service Work%' Or t4.ItmsGrpNam LIKE '%Rework%' Or t4.ItmsGrpNam LIKE '%Stationary%'Or t4.ItmsGrpNam LIKE '%Training%'Or t4.ItmsGrpNam LIKE '%Z_Fixed_Assets%')
                ";
                $title = "BOM SCHEDULE /OTHER";
                //$type = "OBAR";
            }
            if(isset($_GET['sheets'])){
                $clause = "and(t4.ItmsGrpNam LIKE '%Mesh Grate%'or t4.ItmsGrpNam LIKE '%Mesh%'or t4.ItmsGrpNam LIKE '%Sheet%')
                
                ";
                $title = "BOM SCHEDULE /SHEETS";
                //$type = "OBAR";
            }


        ?>

        
       
        <?php include './php_functions.php';?>
        <?php include '../../../../SQL CONNECTIONS/conn.php'; ?>
        <?php include './SQL_bar_stock.php'; ?>
        <?php $results = get_sap_data($conn,$tsql,DEFAULT_DATA); ?>
        <?PHP
$weekNumber = date("W");
$end=10;
    ?>
        <style>
    .bred{   border: 1px solid #eb3434;}
    </style>
    </head>
    <body>
        <div id = "background">
            <div id = "content">
                <div id = "sched_left">
                    <div style = "width:94%;position:relative; left:0; top:2%; margin-bottom:4%;" class = "btext rounded brgreen white">
                        <p class = "smedium">Sales Order</p>
                        <h2 class = "inner first medium">Nothing Selected</h2>
                        <br>
                        <p class = "smedium">Process Order</p>
                        <h2 class = "inner thirteenth medium"><button class = 'brred rounded btext white medium' style = 'height:30px; width:150px;' onclick = "location.href='./test.php?po=0'">000000</button></h2>
                        <br>
                        <p class = "smedium">Customer</p>
                        <h2 class = "inner second medium">Nothing Selected</h2>
                        <br>
                        <p class = "smedium">Description & Qty.</p>
                        <h2 class = "inner third medium">Nothing Selected</h2>
                        <br>
                        <p class = "smedium">Sales Person</p>
                        <h2 class = "inner fourth medium">Nothing Selected</h2>
                        <br>
                        <p class = "smedium">Engineer</p>
                        <h2 class = "inner fifth medium">Nothing Selected</h2>
                        <br>
                        <p class = "smedium">Promise Date and Week Number</p>
                        <h2 class = "inner fourteenth medium">Nothing Selected</h2>
                        <br>
                        <p class = "smedium">Floor Date And Week On Floor</p>
                        <h2 class = "inner fifteenth medium">Nothing Selected</h2>
                    </div>
                    <div style = "width:94%;position:relative; left:0; top:2%; margin-bottom:4%;" class = "btext rounded brgreen white">
                        <p class = "smedium">Status</p>
                        <h2 class = "inner sixth medium">Nothing Selected</h2>
                        <br>
                        <p class = "smedium">Stage</p>
                        <h2 class = "inner seventh medium">Nothing Selected</h2>
                        <br>
                        <p class = "smedium">Production</p>
                        <h2 class = "inner eighth medium">Nothing Selected</h2>
                        <br>
                        <p class = "smedium">Comments</p>
                        <h2 class = "inner eleventh medium">Nothing Selected</h2>
                        <br>
                        <p class = "smedium">Comments 2</p>
                        <h2 class = "inner twent medium">Nothing Selected</h2>
                        
                    </div>
                </div><!--
             --><div id = "sched_right">
                    <div class = "table_title green">
                    <h1 class = 'page_type' type = '<?=$type?>'><?=$title?></h1>
                    </div>
                    <div id = "pages_schedule_container" class = "table_container" style = "overflow-y:scroll">
                        <table id = "production_schedule" class = "filterable">
                            <thead>
                                <tr class = "dark_grey wtext smedium">
                                <th style = "width:14%">Project</th>
                                    <th style = 'width:3%;'><<<</th>
                                    <th style='width:3.64%;'>Week<< </th>
                                    <th style='width:3.64%;'>Wk-4</th>
                                    <th style='width:3.64%;'>Wk-3</th>
                                <th style='width:3.64%;'>Wk-2</th>
                                <th style='width:3.64%;'>Wk-1</th>
                                    <?php for ($i = 0; $i < $end+2; $i++) : ?>




<th style='width:<?= (string)(62 / ($end + (-$start_range))) ?>%; <?= ($i == 0 ? 'background-color:red;' : "") ?>'><?= 'Wk'. $weekNumber+$i ?></th>


                                    <?php endfor; ?>
                                    <th style='width:4.2%;'><?= 'Wk'.$weekNumber+$i?></th>
                                    <th style = 'width:4.2%;'><?='Wk'.$weekNumber+$i+1?></th>
                                    <th style = 'width:4.2%;'><?='Wk'.$weekNumber+$i+2?></th>
                                    <th style = 'width:4.2%;'>>>></th>
                                </tr>
                            </thead>
                            <tbody class = "medium btext">
                                <?php
                                    $active_project = $str = $engineers_str = $base_color = $border_color = $overwrite =  "";                                        
                                    $project_button_buffer = $sum = array_fill(($start_range - 1), ($end_range + (-$start_range) + 2 + 3),NULL);
                                    $project_engineers_buffer = array(null);                         
                                    $first = 1;
                                ?>
                                <?php for($i = 0 ; $i <= sizeof($results) ; $i++):?>
                                    <?php
                                        // IF PAST LAST ROW OF DATA SKIP INTO AND PRINT LAST ROW, OTHERWISE PROCEED NORMALLY AND CHECK IF PROJECT ON CURRENT ROW DOES NOT MATCH THE CURRENT ACTIVE PROJECT
                                        if($i == sizeof($results)){goto printrow;}
                                        if(($results[$i]["Project"] != $active_project && $first == 0) || $i == sizeof($results)){
                                            printrow:
                                            $engineers_str = implode(" ",$project_engineers_buffer);

                                            $days_str = implode(" ", $project_days_buffer);
        
                                            // PRINT BREAKDOWN ROW WITH BUTTONS FROM BUFFER OF ACTIVE PROJECT
                                            echo "<tr class = 'row white smedium' customer = '".$customer."' project = '".$project."' engineers = '".$engineers_str."' sales_person = '".$sales_person."' promise_week_due = '".$promise_week_due."'days_week = '" . $days_str."'type =  breakdown>";
                                                echo "<td style = 'border-right:1px solid #454545;'>".$customer_unp."<br><br>".$project_unp."</td>";
                                                print_values_2($project_button_buffer,$start_range,$end_range);
                                            echo"</tr>";
                                            // PRINT SUM ROW WITH SUM ARRAY FOR CURRENT ACTIVE PROJECT
                                            echo "<tr class = 'row smedium' style = 'background-color:#DCDCDC;' type = 'data' customer = '".$customer."' engineers = '".$engineers_str."' project = '".$project."' sales_person = '".$sales_person."'days_week = '" . $days_str."'><td style = 'background-color:#454545;color:white;'>".$project_unp."</td>";
                                                print_values_2($sum,$start_range,$end_range);
                                            echo "</tr>";
        
                                            // IF IF STATMENT WAS ENTERED BY SKIPPING INTO ON LAST ROW OF QUERY BREAK OUT OF LOOP
                                            if($i == sizeof($results)){break;}
                                        }

                                        // IF PROJECT ON CURRENT ROW DOES NOT MATCH THE CURRENT ACTIVE PROJECT OR WE ARE ON FIRST ROW OF QUERY
                                        // RESET BUFFERS AND ASSIGN ROW DETAILS TO TRACKER VARIABLES
                                        // NOTE: IF A SALES ORDER DOES NOT HAVE A PROJECT THE CUSTOMER DEFAULTS TO "000_NO_PROJECT_000"
                                        if($results[$i]["Project"] != $active_project || $first == 1){
                                            $active_project = $results[$i]["Project"];
                                            $project_engineers_buffer = array();
                                            $project_days_buffer = array();
                                            $project_button_buffer = $sum = array_fill(($start_range - 1), ($end_range + (-$start_range) + 2 + 3),NULL);
                                            $engineers_str = "";
                                            $days_str = "";
        
                                            $customer = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Project"] == '000_NO PROJECT_000' ? '000_NO_PROJECT_000' : $results[$i]["Customer"]));
                                            $project = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Project"]));
                                            $engineer = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Engineer"]));
                                            $sales_person = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Sales Person"]));
                                            $days_week = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Days of the Week"]));
                                            $promise_week_due = $results[$i]["Promise Week Due"];
                                            $project_unp = $results[$i]["Project"];
                                            $customer_unp = $results[$i]["Project"] == '000_NO PROJECT_000' && $first == 1 ? '000_NO_PROJECT_000' : $results[$i]["Customer"];
                                            $first = 0;
                                        }
                                        

                                        if($results[$i]["Stage"] == "8. Design Concept"){
                                            $base_color = "lime_blue";
                                        }
                                        else if($results[$i]["Non Deliverable"] == 'yes'){
                                            $base_color = 'pink';
                                        }
                                        else if($results[$i]["Status"] == 'Pre Production Confirmed' || $results[$i]["Status"] == 'Pre Production Potential' || $results[$i]["Status"] == 'Pre Production Forecast'){
                                            $base_color = 'light_blue';
                                        }
                                        else if(($results[$i]["Status"] == 'Live' || $results[$i]["Status"] == '') && $results[$i]["Process Order"] != null){
                                            $base_color = 'green';
                                        }
                                        else if(($results[$i]["Status"] == 'Live' || $results[$i]["Status"] == '') && $results[$i]["Process Order"] == null){
                                            $base_color = 'orange';
                                        }
                                        else{
                                            $base_color = 'Light_grey';
                                        }
                                        
                                        // BORDER COLOR
                                        if($results[$i]["Sub Contract Status"] == 'Gone To Sub Con' || $results[$i]["Sub Contract Status"] == 'Yes' || $results[$i]["Sub Contract Status"] == '1002'){
                                            $border_color = "bryellow";
                                        }
                                        else if($results[$i]["Sub Contract Status"] == "1003"){
                                            $border_color = "brdottedyellow";
                                        }
                                        else if($results[$i]["Sub Contract Status"] == "1005"){
                                            $border_color = "brsolidpink";
                                        }
                                        else if($results[$i]["Sub Contract Status"] == "1004"){
                                            $border_color = "brdottedpink";
                                        }
                                        
                                        if(($results[$i]["On Hand"] >= $results[$i]["Quantity"] && $results[$i]["Status"] != 'Live' && $results[$i]["Status"] != '') || (($results[$i]["Complete"] <= 0 && $results[$i]["Process Order"] != NULL) && ($results[$i]["Status"] == 'Live' || $results[$i]["Status"] == '')) || ($results[$i]["Status"] == 'Live' || $results[$i]["Status"] == '') &&  $results[$i]["Process Order"] == NULL && $results[$i]["On Hand"] >= $results[$i]["Quantity"]){
                                            $border_color = "brpurple";
                                        }
        
                                        // CONDITIONAL APPLICATIONS
                                        if($results[$i]["Paused"] == 'Yes'){
                                            $overwrite = "greenshadow";
                                        }
                                        else if($results[$i]["risk"] == 'R3'){
                                            $overwrite = "redshadow";
                                        }
                                       
                                        $comments = $results[$i]["Comments"] == "" ? "NONE" : $results[$i]["Comments"];
                                        $comments_2 = $results[$i]["Comments_2"] == "" ? "NONE" : $results[$i]["Comments_2"];
                                        
                                        // ASSIGN A BUTTON WITH ALL ATTRIUTES OF THE JOB TO A STRING
                                        $str = generate_schedule_buttonsss($base_color,
                                            $border_color,
                                            $overwrite,
                                            $results[$i]["Sales Order"] == NULL ? "NO SO" : $results[$i]["Sales Order"],
                                            $results[$i]["Process Order"] == NULL ? "NO PO" : $results[$i]["Process Order"],
                                            $results[$i]["Floor Date"] == NULL ? "NO FLOOR DATE" : $results[$i]["Floor Date"],
                                            $results[$i]["Weeks On Floor"],
                                            $results[$i]["Customer"],
                                            $results[$i]["Engineer"],
                                            str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Engineer"])),
                                            $results[$i]["Sales Person"],
                                            str_replace("''","Inch",str_replace("'","",$results[$i]["Dscription"])),
                                            $results[$i]["Promise Date"],
                                            $results[$i]["Promise Week Due"],
                                            $results[$i]["Est Prod Hrs"],
                                            $results[$i]["Status"],
                                            $results[$i]["Stage"],
                                            $comments,
                                            $comments_2,
                                            $results[$i]["Quantity"],
                                            $results[$i]["Days Open"],
                                            $results[$i]["Week Opened"],
                                            $results[$i]["Weeks Open"],
                                            $results[$i]["Planned Hrs"],
                                            $results[$i]["Est Prod Hrs"],
                                            str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Days of the Week"])),
                                            6
                                        );
        
                                        if(!in_array(str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Engineer"])), $project_engineers_buffer))
                                        {
                                            array_push($project_engineers_buffer, str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Engineer"])));
                                        }
                                        if (!in_array(str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Days of the Week"])), $project_days_buffer)) {
                                            array_push($project_days_buffer, str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Days of the Week"])));
                                        }
                                        $project_button_buffer[$results[$i]["Promise Diff Week"]] = $project_button_buffer[$results[$i]["Promise Diff Week"]].$str;
                                        $sum[$results[$i]["Promise Diff Week"]] = $sum[$results[$i]["Promise Diff Week"]] + 1;                                                    
                                        
                                        $base_color = "";
                                        $border_color = "";
                                        $overwrite = "";  
                                    ?>
                                <?php endfor; ?>
                            </tbody>
                            <tfoot style = "position:sticky; bottom: 0; z-index:+1;">
                                <tr class = "light_grey btext small" role = "row">
                                    <td aggregateable = 'Y' operation = 'COUNT'>        </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>          </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class = "ledgend btext medium">
                        <div class = "fill">
                           <div class = "subdividor light_grey rounded-left">
                                <div class = "half">
                                    <div class = "textholder"><p>Pre Production</p></div><div class = "button_holder"><button class = "light_blue"></button></div>
                                </div>
                                <div class = "half">
                                    <div class = "textholder"><p>Non Del</p></div><div class = "button_holder"><button class = "pink"></button></div>
                                </div>
                            </div><!--
                         --><div class = "subdividor light_grey">
                                <div class = "half">
                                    <div class = "textholder"><p>Live Make</p></div><div class = "button_holder"><button class = "green"></div>
                                </div>
                                <div class = "half">
                                    <div class = "textholder"><p>Live Bought In</p></div><div class = "button_holder"><button class = "orange"></div>
                                </div>
                            </div><!--
                         --><div id = "centergroup_left" class = "subdividor light_grey">
                                <p style = "margin-bottom:0%;margin-top:0.5vh;">In Stock/ Complete</p><button style = "background-color:#DBDBDB; border:5px solid #9964ED; height:20px;"></button>
                            </div><!--
                         --><div class = "subdividor light_grey">
                                <div class = "half">
                                    <div class = "textholder"><p>In Subcontract</p></div><div class = "button_holder"><button style = "background-color:#DBDBDB; border:5px solid yellow; height:20px;"></button></div>
                                </div>
                                <div class = "half">
                                    <div class = "textholder"><p>In Man Subcon</p></div><div class = "button_holder"><button style = "background-color:#DBDBDB; border:5px solid #E601BA; height:20px;"></button></div>
                                </div>
                            </div><!--
                         --><div id = "centergroup_right" class = "subdividor light_grey">
                                <div class = "half">
                                    <div class = "textholder"><p>Back From SC</p></div><div class = "button_holder"><button style = "background-color:#DBDBDB; border:5px dotted yellow; height:20px;"></button></div>
                                </div>
                                <div class = "half">
                                    <div class = "textholder"><p>Req Man Sc</p></div><div class = "button_holder"><button style = "background-color:#DBDBDB; border:5px dotted #E601BA; height:20px;"></button></div>
                                </div>
                            </div><!--
                         --><div class = "subdividor light_grey">
                                <div class = "half">
                                    <div class = "textholder"><p>Notification</p></div><div class = "button_holder"><button class = "greenshadow"></button></div>
                                </div>
                                <div class = "half">
                                    <div class = "textholder"><p>High Risk</p></div><div class = "button_holder"><button class = "light_grey brlightgrey redshadow"></button></div>
                                </div>
                            </div><!--
                         --><div class = "subdividor light_grey rounded-right">
                                <div class = "half">
                                    <!--<div class = "textholder"><p>Next Year</p></div><div class = "button_holder"><button class = "green brpurple opaque"></button></div>-->
                                </div>
                                <div class = "half">
                                    <div class = "textholder"><p>Obsolete</p></div><div class = "button_holder"><button class = "black"></button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id = "schedule_pages_footer" class = "footer">
                        <div id = "top">
                            <div id = "filter_container">
                                <div id = "filters" class = "red fill rounded">
                                    <div class = "filter">
                                        <div class = "text">
                                            <button class = "fill red medium wtext">Customer</button>
                                        </div>
                                        <div class = "content">
                                            <select id = "select_customer" class = "selector fill medium">
                                                <option value = "All" selected>All</option>
                                                <?php generate_filter_options($results,"Customer"); ?>
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
                                                <?php generate_filter_options($results,"Project"); ?>
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
                                                <?php generate_filter_options($results,"Engineer"); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class = "filter">
                                        <div class = "text">
                                            <button class = "fill red medium wtext">Week</button>
                                        </div>
                                        <div class = "content">
                                            <select id = "select_days_week" class = "selector fill medium">
                                                <option value = "All" selected>All</option>
                                                <option value="ThisWeek" selected>Week0</option>
                                            <option value="Nextweek" selected>Week1</option>
                                            
                                            <option value="Week2" selected>Week2</option>
                                            <option value="Week3" selected>Week3</option>
                                            <option value="Week4" selected>Week4</option>
                                            <option value="Week5" selected>Week5</option>
                                            <option value="Week6" selected>Week6</option>
                                            <option value="Week7" selected>Week7</option>
                                            <option value="Ot" selected>Other</option>
                                            
                                          
                                                <?php //generate_filter_options($results,"Days of the Week"); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id = "bottom">                        
                            <div id = "button_container_sched_left">
                                <button onclick = "location.href='../../../PRODUCTION/EXCEPTIONS/production exceptions/BASE_production_exceptions.php'" class = "grouping_page_corner_buttons fill medium red wtext rounded-left" style = "float:left; width:35%">EXCEPTIONS</button>
                                <button onclick = "location.href='../../../PRODUCTION/EXCEPTIONS/GRN/BASE_grn_exceptions.php'" class = "grouping_page_corner_buttons fill medium red wtext" style = "float:left; width:30%">GRN</button>
                                <button onclick = "location.href='../../../PRODUCTION/EXCEPTIONS/PURCHASING/BASE_purchasing_exceptions.php'" class = "grouping_page_corner_buttons fill medium red wtext rounded-right" style = "float:left; width:35%">PURCHASING</button>
                            </div>
                            <div id = "button_container_sched_btn">
                                <button id = "bd" class = "grouping_page_corner_buttons fill medium orange wtext rounded" style = "float:left; width:100%">BREAKDOWN</button>
                            </div>
                            <div id = "button_container_sched_flip_flop">
                                <button onclick = "location.href='../../../PRODUCTION/SCHEDULE/HIGH RISK SCHEDULE/BASE_high_risk_schedule.php'" class = "grouping_page_corner_buttons fill medium red wtext rounded-left" style = "float:left; width:50%">HIGH R</button>
                                <button onclick = "location.href='../../../PRE PRODUCTION/SCHEDULE/PRE PRODUCTION SCHEDULE/BASE_pre_production_schedule.php'" class = "grouping_page_corner_buttons fill medium light_blue wtext rounded-right" style = "float:left; width:50%">ENG</button>
                            </div>
                            <div id = "button_container_sched_btn">
                                <button onclick = "export_to_excel('production_schedule')" class = "grouping_page_corner_buttons fill medium green wtext rounded" style = "float:left; width:100%">EXCEL</button>
                            </div>
                            <div id = "button_container_sched_btn">
                                <button onclick = "location.href='../../../MAIN MENU/dashboard_menu.php'" class = "grouping_page_corner_buttons fill medium purple wtext rounded" style = "float:left; width:100%">MAIN MENU</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>