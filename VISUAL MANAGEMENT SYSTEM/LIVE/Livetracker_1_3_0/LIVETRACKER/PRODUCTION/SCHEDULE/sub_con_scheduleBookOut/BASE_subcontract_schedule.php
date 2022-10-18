<?php if (isset($_GET['po'])) {
    $clause = "WHERE [Process Order] = " . explode(',', $_GET['po'])[0];

    if (explode(',', $_GET['po'])[1] == 'OBAR') {
        $clause2_a = "AND (t5.ItmsGrpNam LIKE '%Sheet%' OR t5.ItmsGrpNam LIKE '%Bar%' OR t5.ItmsGrpNam LIKE '%Box%')";
        $clause2_b = "AND (t5.ItmsGrpNam LIKE '%Sheet%' OR t5.ItmsGrpNam LIKE '%Bar%' OR t5.ItmsGrpNam LIKE '%Box%')";
    } elseif (explode(',', $_GET['po'])[1] == 'NBAR') {
        $clause2_a = "AND t5.ItmsGrpNam NOT LIKE '%Sheet%' AND t5.ItmsGrpNam NOT LIKE '%Bar%' AND t5.ItmsGrpNam NOT LIKE '%Box%'";
        $clause2_b = "AND t5.ItmsGrpNam NOT LIKE '%Sheet%' AND t5.ItmsGrpNam NOT LIKE '%Bar%' AND t5.ItmsGrpNam NOT LIKE '%Box%'";
    } elseif (explode(',', $_GET['po'])[1] == 'NORMAL') {
        $clause2_a = "AND t2.PrcrmntMtd = 'B' AND t0.PlannedQty > (t2.ONhand - t2.IsCommited + t0.PlannedQty)  AND t1.CmpltQty < t1.PlannedQty";
        $clause2_b = "AND t2.PrcrmntMtd = 'B' AND t0.OpenQty > (t2.ONhand - t2.IsCommited + t0.OpenQty) ";
    }
} else {
    $clause = "";
    $clause2_a = "AND t2.PrcrmntMtd = 'B' AND t0.PlannedQty > (t2.ONhand - t2.IsCommited + t0.PlannedQty)  AND t1.CmpltQty < t1.PlannedQty";
    $clause2_b = "AND t2.PrcrmntMtd = 'B' AND t0.OpenQty > (t2.ONhand - t2.IsCommited + t0.OpenQty) ";
}
?>

<!DOCTYPE html>
<html>

<head>
    <!-- INITALISATION AND META STUFF -->
    <title>PRODUCTION SCHEDULE</title>
    <meta name="viewpport" content="width=device-width, initial-scale = 1">

    <!-- EXTERNAL JAVASCRIPT -->
    <script type="text/javascript" src="../../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>

    <!-- LOCAL JAVASCRIPT -->
    <script type="text/javascript" src="../../../../JS LIBS/LOCAL/JS_update_total_rows.js"></script>
    <script type="text/javascript" src="../../../../JS LIBS/LOCAL/JS_filters_w_bd.js"></script>
    <script type="text/javascript" src="./JS_table_to_excel.js"></script>
    <script type="text/javascript" src="./JS_job.js"></script>

    <!-- STYLESHEET -->
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <link href='../../../../CSS/LT_STYLE.css' rel='stylesheet' type='text/css'>

    <!-- PHP INITALISATION -->
    <?php
    $start_time = time() - 60 * 60 * 24 * 7 * 5;
    $start_range = -3;
    $end_range = 15; #function array_sort($array){sort($array); return $array;}

    function generate_filter_optionss($table, $field)
    {
        foreach (array_sort(array_unique(array_column($table, $field))) as $element) {
            //IF TODAY IS MONDAY GET LASTWORKINGDAY FROM TABLE
            if (date("w") == 1) {
                if ($element == 'Monday' || $element == 'Friday' || $element == 'Tuesday' || $element == 'Wednesday' || $element == 'Thursday' || $element == 'Friday' || $element == 'Other' || $element == 'Last Working Day') {
                    echo "<option value = '" . str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $element)) . "'>" . ($element) . "</option>";
                }
            } else
                if ($element == 'Monday' || $element == 'Friday' || $element == 'Tuesday' || $element == 'Wednesday' || $element == 'Thursday' || $element == 'Friday' || $element == 'Other') {
                echo "<option value = '" . str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $element)) . "'>" . ($element) . "</option>";
            }
        }
    }
    ?>

    <?php include './php_functions.php'; ?>
    <?php include '../../../../SQL CONNECTIONS/conn.php'; ?>
    <?php //include './SQL_production_schedule_new.php'; 
    ?>
    <?php include './SQL_subcontract_schedule.php'; ?>
    <?php $results = get_sap_data($conn, $tsql, DEFAULT_DATA); ?>

    <?php


    $days = array(
        0 => 'Sun',
        1 => 'Mon',
        2 => 'Tue',
        3 => 'Wed',
        4 => 'Thur',
        5 => 'Fri',
        6 => 'Sat'
    );
    ?>
    <style>
        .bred {
            border: 1px solid #eb3434;
        }

        .lightgreen {
            background-color: lightgreen
        }

        .brorange {
            border: 4px solid orange;
        }

        .brired {
            outline: 4px solid red;
        }
        
    </style>
</head>

<body>
    <div id="background">
        <div id="content">
            <div id="sched_left">
                <div style="width:94%;position:relative; left:0; top:2%; margin-bottom:4%;" class="btext rounded brgreen white">
                    <p class="smedium">Sales Order</p>
                    <h2 class="inner first medium">Nothing Selected</h2>
                    
                     <h2 class = "inner fourth medium">Nothing Selected</h2>
                        <br>
                    <p class="smedium">Process Order</p>
                    <h2 class="inner thirteenth medium">Nothing Selected</h2>
                    <br>
                    <p class="smedium">Customer</p>
                    <h2 class="inner second medium">Nothing Selected</h2>
                    <br>
                    <p class="smedium">Description & Qty.</p>
                    <h2 class="inner third medium">Nothing Selected</h2>
                    <br>
                    
                    <br>
                    <p class="smedium">Engineer</p>
                    <h2 class="inner fifth medium">Nothing Selected</h2>
                    <br>
                    <p class="smedium">SC BookOut Date </p>
                    <h2 class="inner fourteenth medium">Nothing Selected</h2>
                    <br>
                    <!-- <p class = "smedium">Promise Date</p>
                        <h2 class = "inner fifteenth medium">Nothing Selected</h2> -->
                </div>
                <div style="width:94%;position:relative; left:0; top:2%; margin-bottom:4%;" class="btext rounded brgreen white">
                    <p class="smedium">Purchase Order</p>
                    <h2 class="inner sixth medium">Nothing Selected</h2>
                    <br>
                    <p class="smedium">Supplier</p>
                    <h2 class="inner seventh medium">Nothing Selected</h2>
                    <br>
                    <!-- <p class = "smedium">Production</p>
                        <h2 class = "inner eighth medium">Nothing Selected</h2> -->

                    <p class="smedium">Purchase due date</p>
                    <h2 class="inner eleventh medium">Nothing Selected</h2>
                    <br>
                    <p class="smedium">Comments </p>
                    <h2 class="inner twenty medium">Nothing Selected</h2>
                </div>
                <div style="width:94%;position:relative; left:0; top:2%; margin-bottom:4%;" class="btext rounded brgreen white">
                    <p class="smedium">Subcon comments</p>
                    <h2 class="inner twentyone medium">Nothing Selected</h2>
                    <br>
                    
                </div>
            </div>
            <!--
             -->
            <div id="sched_right">
                <div class="table_title green">
                    <h1>SUB CONTRACT SCHEDULE/BOOKOUT</h1>
                </div>
                <div id="pages_schedule_container" class="table_container" style="overflow-y:scroll">
                    <table id="production_schedule" class="filterable">
                        <thead>
                            <tr class="dark_grey wtext smedium">
                                <th style="width:14%">Project</th>

                                <th style='width:5.0%;'>Week <<</th>
                                <th style='width:5.0%;'>Week -2</th>
                                <th style='width:5.0%;'>Week -1</th>

                                <!-- NEGATIVE NUMBERS -->
                                <th style='width:5.0%;'><?= $days[date("w") - 3 < 0 ? date("w") % 7 + 4 : date("w") - 3] ?></th>
                                <th style='width:5.0%;'><?= $days[date("w") - 2 < 0 ? date("w") % 7 + 5 : date("w") - 2] ?></th>
                                <th style='width:5.0%;'><?= $days[date("w") - 1 < 0 ? date("w") % 7 + 6 : date("w") - 1] ?></th>

                                <?php for ($i = 0; $i < $end_range - 1; $i++) : ?>




                                    <th style='width:<?= (string)(100 / ($end_range + 2 + (-$start_range))) ?>%;<?= ($days[(date("w") + $i) % 7] == 'Sun' || $days[(date("w") + $i) % 7] == 'Sat' ? 'background-color:#25ac9975;' : "") ?> <?= ($i == 0 ? 'background-color:red;' : "") ?>'><?= $days[(date("w") + $i) % 7] ?></th>

                                <?php endfor; ?>
                                <th style='width:5.0%;'><?= $end_range - 1 ?> +1</th>

                        </thead>
                        <tbody class="medium btext">
                            <?php
                            $active_project = $str = $engineers_str = $days_lthree = $days_str = $base_color = $border_color = $overwrite =  "";
                            $project_button_buffer = $sum = array_fill(($start_range - 3), ($end_range + (-$start_range) + 2 + 3), NULL);
                            /* foreach ($project_button_buffer as $p)
                                    {
                                        echo ($p);
                                    } */
                            $project_engineers_buffer = array(null);
                            $project_days_buffer = array(null);
                            $project_days_lthree_buffer = array(null);
                            $first = 1;
                            ?>
                            <?php for ($i = 0; $i <= sizeof($results); $i++) : ?>
                                <?php




                                // IF PAST LAST ROW OF DATA SKIP INTO AND PRINT LAST ROW, OTHERWISE PROCEED NORMALLY AND CHECK IF PROJECT ON CURRENT ROW DOES NOT MATCH THE CURRENT ACTIVE PROJECT
                                if ($i == sizeof($results)) {

                                    goto printrow;
                                }
                                if (($results[$i]["Project"] != $active_project && $first == 0) || $i == sizeof($results)) {

                                    printrow:

                                    $engineers_str = implode(" ", $project_engineers_buffer);
                                    $days_str = implode(" ", $project_days_buffer);
                                    $days_lthree = implode(" ", $project_days_lthree_buffer);
                                    $productgp = 'r';
                                    $promise_week_due = '10';
                                    /*  if(($project_unp=="Intel Non Ped"))
                                    $bgcolor='red';
                                    else
                                    $bgcolor=''; */
                                    $bgcolor = '';

                                    // PRINT BREAKDOWN ROW WITH BUTTONS FROM BUFFER OF ACTIVE PROJECT
                                    echo "<tr class = 'row white smedium' lastthreedays = '" . $days_lthree . "'productgp = '" . $productgp . "'days_week = '" . $days_str . "'customer = '" . $customer . "' project = '" . $project . "' engineers = '" . $engineers_str . "' sales_person = '" . $sales_person . "' promise_week_due = '" . $promise_week_due . "' type =  breakdown>";
                                    echo "<td style = 'background-color:$bgcolor;border-right:1px solid #454545;'>" . $customer_unp . "<br><br>" . $project_unp . "</td>";

                                    print_values_22($project_button_buffer, $start_range, $end_range - 1);

                                    //Empty table data 
                                    echo "<td style = 'border-right:1px solid #454545;'></td>";
                                    //echo ($start_range);
                                    //echo ($end_range);
                                    echo "</tr>";
                                    // PRINT SUM ROW WITH SUM ARRAY FOR CURRENT ACTIVE PROJECT
                                    echo "<tr class = 'row smedium' style = 'background-color:#DCDCDC;' type = 'data' lastthreedays = '" . $days_lthree . "'days_week = '" . $days_str . "'customer = '" . $customer . "' engineers = '" . $engineers_str . "' project = '" . $project . "' sales_person = '" . $sales_person . "'><td style = 'background-color:#454545;color:white;'>" . $project_unp . "</td>";
                                    print_values_22($sum, $start_range, $end_range - 1);
                                    echo "<td style = 'background-color:#DCDCDC;color:white;'></td>";
                                    echo "</tr>";

                                    // IF IF STATMENT WAS ENTERED BY SKIPPING INTO ON LAST ROW OF QUERY BREAK OUT OF LOOP
                                    if ($i == sizeof($results)) {
                                        break;
                                    }
                                }




                                // IF PROJECT ON CURRENT ROW DOES NOT MATCH THE CURRENT ACTIVE PROJECT OR WE ARE ON FIRST ROW OF QUERY
                                // RESET BUFFERS AND ASSIGN ROW DETAILS TO TRACKER VARIABLES
                                // NOTE: IF A SALES ORDER DOES NOT HAVE A PROJECT THE CUSTOMER DEFAULTS TO "000_NO_PROJECT_000"
                                if ($results[$i]["Project"] != $active_project || $first == 1) {
                                    $active_project = $results[$i]["Project"];
                                    $project_engineers_buffer = array();
                                    $project_days_buffer = array();
                                    $project_days_lthree_buffer = array();
                                    $project_button_buffer = $sum = array_fill(($start_range - 3), ($end_range + (-$start_range) + 2 + 3), NULL);
                                    //$project_button_buffer = $sum = array_fill(($start_range - 1), ($end_range + (-$start_range) + 2 + 3),NULL);
                                    //print_r($project_button_buffer);
                                    $engineers_str = "";
                                    $days_str = "";
                                    $days_lthree = "";

                                    $customer = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Project"] == '000_NO PROJECT_000' ? '000_NO_PROJECT_000' : $results[$i]["Customer"]));
                                    $project = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Project"]));
                                    $engineer = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Engineer"]));
                                    $sales_person = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Sales Person"]));
                                    //$productgp = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Product Group"]));

                                    $days_week = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Days of the Week"]));
                                    // $promise_week_due = $results[$i]["Promise Week Due"];
                                    $project_unp = $results[$i]["Project"];
                                    $customer_unp = $results[$i]["Project"] == '000_NO PROJECT_000' && $first == 1 ? '000_NO_PROJECT_000' : $results[$i]["Customer"];
                                    $first = 0;
                                }





                                /*  if($results[$i]["Stage"] == "8. Design Concept"){
                                            $base_color = "lime_blue";
                                        } */
                                /*  if($results[$i]["Non Deliverable"] == 'yes'){
                                            $base_color = 'pink';
                                        } */
                                /* else if($results[$i]["Status"] == 'Pre Production Confirmed' || $results[$i]["Status"] == 'Pre Production Potential' || $results[$i]["Status"] == 'Pre Production Forecast'){
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
                                        } */
                                /*
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
                                       
                                        $commentss = $results[$i]["Comments"] == "" ? "NONE" : $results[$i]["Comments"];
                                        $comments_2 = $results[$i]["Comments_2"] == "" ? "NONE" : $results[$i]["Comments_2"]; */

                                if ($results[$i]["Issued Qty"]!='0'&&$results[$i]["Planned Qty"]!='0')
                                {
                                    
                                if($results[$i]["Issued Qty"]>= $results[$i]["Planned Qty"])
                                    $color = "brorange";
                                else
                                    $color =  '';
                                }
                                else
                                $color='';
                                
                                
                                /* if ($results[$i]["Issued Qty"] == NULL || $results[$i]["Planned Qty"] == NULL)

                                $border_color = '';
                                else
                                $border_color =  ''; */
                                if ($results[$i]["Latest Purchase Ord"] != NULL)
                                    $border_color = 'brired';
                                    
                                 if ($results[$i]["Sub_Con_Status"]== 'Gone to Sub Con')
                                   $overwrite = 'brdottedyellow';
                                   else
                                   $overwrite='';

                                if ($results[$i]["Sub_Con_Date"] == '')
                                    $base_color = 'green';
                                else
                                    $base_color = 'lightgreen';
                                //$color = 'blue';

                                $str = generate_schedule_buttons_forsc(
                                    $color,
                                    $base_color,
                                    $border_color,
                                    $overwrite,
                                    $results[$i]["Sales Order"] == NULL ? "NO SO" : $results[$i]["Sales Order"],
                                    $results[$i]["Process Order"] == NULL ? "NO PO" : $results[$i]["Process Order"],
                                    //Description in sales order
                                    $results[$i]["Dscription"],
                                    $results[$i]["Sub_Con_Remarks"]==NULL? "NO Rem":$results[$i]["Sub_Con_Remarks"],
                                    $results[$i]["Customer"],
                                    $results[$i]["Engineer"],
                                    str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Engineer"])),
                                    $results[$i]["Sales Person"],

                                    str_replace("''", "Inch", str_replace("'", "", $results[$i]["ItemName"])),

                                    $results[$i]["Promise Date UNP"],

                                    //$results[$i]["Promise Week Due"],
                                    NULL,
                                    //$results[$i]["Est Prod Hrs"],
                                    NULL,
                                    //$results[$i]["Stage"],
                                    $results[$i]["Latest Purchase Ord"] == NULL ? "NO PurO" :$results[$i]["Latest Purchase Ord"],
                                    //$comments,
                                    $results[$i]["supplier"] == NULL ? "NO Sup":$results[$i]["supplier"],
                                    //$comments_2,
                                    $results[$i]["Purchase Due"] == NULL ? " ":$results[$i]["Purchase Due"],
                                    //str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Sub_Con_Remarks"])),
                                    //$results[$i]["Comments"] == NULL ? "NO R":$results[$i][""],
                                    NULL,
                                    //$results[$i]["Quantity"],
                                    NULL,
                                    //$results[$i]["Days Open"],
                                    NULL,
                                    //$results[$i]["Week Opened"],
                                    NULL,
                                    //$results[$i]["Weeks Open"],
                                    NULL,
                                    //$results[$i]["Planned Hrs"],
                                    NULL,
                                    //$results[$i]["Est Prod Hrs"] < 0 ? 0 : $results[$i]["Est Prod Hrs"],
                                    NULL,
                                    str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Days of the Week"])),
                                    str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Last three days"]))

                                );

                                if (!in_array(str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Engineer"])), $project_engineers_buffer)) {
                                    array_push($project_engineers_buffer, str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Engineer"])));
                                }
                                if (!in_array(str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Days of the Week"])), $project_days_buffer)) {
                                    array_push($project_days_buffer, str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Days of the Week"])));
                                }
                                if (!in_array(str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Last three days"])), $project_days_lthree_buffer)) {
                                    array_push($project_days_lthree_buffer, str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Last three days"])));
                                }
                                //echo($results[$i]["Promise Diff Days"]);
                                //echo("<br>");
                                $project_button_buffer[$results[$i]["Promise Diff Days"]] = $project_button_buffer[$results[$i]["Promise Diff Days"]] . $str;
                                //$sum[$results[$i]["Promise Diff Days"]] = $sum[$results[$i]["Promise Diff Days"]] + $results[$i]["Est Prod Hrs"];                                                    

                                $base_color = "";
                                $border_color = "";
                                $overwrite = "";

                                ?>
                            <?php endfor; ?>
                        </tbody>
                        <!-- <tfoot style = "position:sticky; bottom: 0; z-index:+1;">
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
                                    -->
                    </table>
                </div>
                <div class="ledgend btext medium">
                    <div class="fill">
                        <div class="subdividor light_grey rounded-left">
                            <div class="half">
                                <div class="textholder">
                                    <p>SC Date</p>
                                </div>
                                <div class="button_holder"><button class="light_green"></button></div>
                            </div>
                            <div class="half">
                                <div class="textholder">
                                    <!-- <p>Non Del</p> -->
                                </div>
                                <!-- <div class="button_holder"><button class="pink"></button></div> -->
                            </div>
                        </div><!--
                         --><div class="subdividor light_grey">
                            <div class="half">
                                <div class="textholder">
                                    <p>SC no SCdate</p>
                                </div>
                                <div class="button_holder"><button class="green"></div>
                            </div>
                            <div class="half">
                                <div class="textholder">
                                    <!-- <p>Live Bought In</p> -->
                                </div>
                                <!-- <div class="button_holder"><button class="orange"></div> -->
                            </div>
                        </div><!--
                         --><div id="centergroup_left" class="subdividor light_grey">
                            <!-- <p style="margin-bottom:0%;margin-top:0.5vh;">In Stock/ Complete</p><button style="background-color:#DBDBDB; border:5px solid #9964ED; height:20px;"></button> -->
                             <p style="margin-bottom:0%;margin-top:0.5vh;">Advice note</p>
                             <button style="background-color:#DBDBDB; border:5px dotted yellow; height:20px;"></button> 
                        </div><!--
                         --><div class="subdividor light_grey">
                            <div class="half">
                                <div class="textholder">
                                    <p>PO Raised</p>
                                </div>
                                <div class="button_holder"><button style="background-color:#DBDBDB; border:5px solid red; height:20px;"></button></div>
                            </div>
                            <div class="half">
                                <div class="textholder">
                                    <!-- <p>BOM Issued</p> -->
                                </div>
                                <!-- <div class="button_holder"><button style="background-color:#DBDBDB; border:5px solid orange; height:20px;"></button></div> -->
                            </div>
                        </div><!--
                         --><div id="centergroup_right" class="subdividor light_grey">
                            <div class="half">
                                <div class="textholder">
                                   <p>BOM Issued</p>
                                </div>
                                <!-- <div class="button_holder"><button style="background-color:#DBDBDB; border:5px dotted yellow; height:20px;"></button></div> -->
                                <div class="button_holder"><button style="background-color:#DBDBDB; border:5px solid orange; height:20px;"></button></div>
                            </div>
                            <div class="half">
                                <div class="textholder">
                                    <!-- <p>Req Man Sc</p> -->
                                </div>
                                <!-- <div class="button_holder"><button style="background-color:#DBDBDB; border:5px dotted #E601BA; height:20px;"></button></div> -->
                            </div>
                        </div><!--
                         --><div class="subdividor light_grey">
                            <div class="half">
                                <div class="textholder">
                                    <p>Notification</p>
                                </div>
                                <div class="button_holder"><button class="greenshadow"></button></div>
                            </div>
                            <div class="half">
                                <div class="textholder">
                                    <p>High Risk</p>
                                </div>
                                <div class="button_holder"><button class="light_grey brlightgrey redshadow"></button></div>
                            </div>
                        </div><!--
                         --><div class="subdividor light_grey rounded-right">
                            <div class="half">
                                <div class="textholder">
                                    <p>Next Year</p>
                                </div>
                                <div class="button_holder"><button class="green brpurple opaque"></button></div>
                            </div>
                            <div class="half">
                                <div class="textholder">
                                    <p>Obsolete</p>
                                </div>
                                <div class="button_holder"><button class="black"></button></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="schedule_pages_footer" class="footer">
                    <div id="top">
                        <div id="filter_container">
                            <div id="filters" class="red fill rounded">
                                <div class="filter">
                                    <div class="text">
                                        <button class="fill red medium wtext">Customer</button>
                                    </div>
                                    <div class="content">
                                        <select id="select_customer" class="selector fill medium">
                                            <option value="All" selected>All</option>
                                            <?php generate_filter_options($results, "Customer"); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="filter">
                                    <div class="text">
                                        <button class="fill red medium wtext">Project</button>
                                    </div>
                                    <div class="content">
                                        <select id="select_project" class="selector fill medium">
                                            <option value="All" selected>All</option>
                                            <?php generate_filter_options($results, "Project"); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="filter">
                                    <div class="text">
                                        <button class="fill red medium wtext">Engineer</button>
                                    </div>
                                    <div class="content">
                                        <select id="select_engineer" class="selector fill medium">
                                            <option value="All" selected>All</option>
                                            <?php generate_filter_options($results, "Engineer"); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="filter" style="display:none">
                                    <div class="text">
                                        <button class="fill red medium wtext">Sales Person</button>
                                    </div>
                                    <div class="content">
                                        <select id="select_sales_person" class="selector fill medium">
                                            <option value="All" selected>All</option>
                                            <?php generate_filter_options($results, "Sales Person"); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="filter">
                                    <div class="text">
                                        <button class="fill red medium wtext">WeekDays</button>
                                    </div>
                                    <div class="content">
                                        <select id="select_days_week" class="selector fill medium">
                                            
                                            <option value="All" selected>All</option>
                                            <option value="LastthreeDays" selected>Last three Days</option>
                                            <!-- <option value="LastfiveDays" selected>Last five Days</option>  -->
                                            <option value="Monday" selected>Monday</option>
                                            <option value="Tuesday" selected>Tuesday</option>
                                            <option value="Wednesday" selected>Wednesday</option>
                                            <option value="Thursday" selected>Thursday</option>
                                            <option value="Friday" selected>Friday</option>
                                            <option value="MNW" selected>MondayN</option>
                                            <option value="TNW" selected>TuesdayN</option>
                                            <option value="WNW" selected>WednesdayN</option>
                                            <option value="THNW" selected>ThursdayN</option>
                                            <option value="FNW" selected>FridayN</option>

                                            <option value="Other" selected>Other</option>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="bottom">
                        <div id="button_container_sched_left">
                            <button onclick="location.href='../../../PRODUCTION/EXCEPTIONS/production exceptions/BASE_production_exceptions.php'" class="grouping_page_corner_buttons fill medium red wtext rounded-left" style="float:left; width:35%">EXCEPTIONS</button>
                            <button onclick="location.href='../../../PRODUCTION/EXCEPTIONS/GRN/BASE_grn_exceptions.php'" class="grouping_page_corner_buttons fill medium red wtext" style="float:left; width:30%">GRN</button>
                            <button onclick="location.href='../../../PRODUCTION/EXCEPTIONS/PURCHASING/BASE_purchasing_exceptions.php'" class="grouping_page_corner_buttons fill medium red wtext rounded-right" style="float:left; width:35%">PURCHASING</button>
                        </div>
                        <div id="button_container_sched_btn">
                            <button id="bd" class="grouping_page_corner_buttons fill medium orange wtext rounded" style="float:left; width:100%">BREAKDOWN</button>
                        </div>
                        <div id="button_container_sched_flip_flop">
                            <button onclick="location.href='../../../PRODUCTION/SCHEDULE/HIGH RISK SCHEDULE/BASE_high_risk_schedule.php'" class="grouping_page_corner_buttons fill medium red wtext rounded-left" style="float:left; width:50%">HIGH R</button>
                            <button onclick="location.href='../../../PRE PRODUCTION/SCHEDULE/PRE PRODUCTION SCHEDULE/BASE_pre_production_schedule.php'" class="grouping_page_corner_buttons fill medium light_blue wtext rounded-right" style="float:left; width:50%">ENG</button>
                        </div>
                        <div id="button_container_sched_btn">
                            <button onclick="export_to_excel('production_schedule')" class="grouping_page_corner_buttons fill medium green wtext rounded" style="float:left; width:100%">EXCEL</button>
                        </div>
                        <div id="button_container_sched_btn">
                            <button onclick="location.href='../../../../MAIN MENU/dashboard_menu.php'" class="grouping_page_corner_buttons fill medium purple wtext rounded" style="float:left; width:100%">MAIN MENU</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>