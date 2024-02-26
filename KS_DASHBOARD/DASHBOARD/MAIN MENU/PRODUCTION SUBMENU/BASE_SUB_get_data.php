<?php
    // FIND CURRENT TIME
    $current_time = getdate()[0];
    $week = date('W');

    // INCLUDE DB CONNECTION AND QUERIES
    include '../../../SQL/CONNECTIONS/conn.php';
    include './SQL_production_key_figures.php';

    // INCLUDE PHP FUNCTIONS FILE AND CONSTANTS
    include '../../../PHP LIBS/PHP FUNCTIONS/php_function.php';
    include '../../../PHP LIBS/PHP FUNCTIONS/php_constants.php';

    // EXECUTE QUERIES AND PULL DATA
    $released_today_list_data = get_sap_data($conn,$released_today_list_sql,DEFAULT_DATA);
    $released_yesterday_list_data = get_sap_data($conn,$released_yesterday_list_sql,DEFAULT_DATA);
    $complete_today_list_data = get_sap_data($conn,$complete_today_list_sql,DEFAULT_DATA);
    $complete_yesterday_list_data = get_sap_data($conn,$complete_yesterday_list_sql,DEFAULT_DATA);

    $estimated_pp_demand_data = get_sap_data($conn,$estimated_pp_demand_sql,SPECIAL_DATA);
    $planned_po_demand_data = get_sap_data($conn,$planned_po_demand_sql,SPECIAL_DATA);

    $executed_last_week_data = get_sap_data($conn,$executed_last_week_sql,SINGLE_NUMBER);
    $executed_this_week_data = get_sap_data($conn,$executed_this_week_sql,SINGLE_NUMBER);
    $executed_fwa_data = get_sap_data($conn,$executed_fwa_sql,SINGLE_NUMBER);
    $executed_ytd_data = get_sap_data($conn,$executed_ytd_sql,SINGLE_NUMBER);
    $released_last_week_data = get_sap_data($conn,$released_last_week_sql,SINGLE_NUMBER);
    $released_this_week_data = get_sap_data($conn,$released_this_week_sql,SINGLE_NUMBER);
    $released_fwa_data = get_sap_data($conn,$released_fwa_sql,SINGLE_NUMBER);
    $released_ytd_data = get_sap_data($conn,$released_ytd_sql,SINGLE_NUMBER);
    $live_po_count_data = get_sap_data($conn,$live_po_count_sql,SINGLE_NUMBER);
    $live_po_count_comp_data = get_sap_data($conn,$live_po_count_comp_sql,SINGLE_NUMBER);
    $open_hours_on_floor_data = get_sap_data($conn,$open_hours_on_floor_sql,SINGLE_NUMBER);    
    $open_hours_on_floor_details_data = get_sap_data($conn,$open_hours_on_floor_details_sql,DEFAULT_DATA);    
    
    // UNSET BINS EITHER END OF DATA (NOT USED AS OF YET)
    unset($estimated_pp_demand_data[1111]);
    unset($estimated_pp_demand_data[2222]);
    unset($planned_po_demand_data[1111]);
    unset($planned_po_demand_data[2222]);

    // CONVERT NULLS TO ZERO
    for($i = -5; $i < sizeof($estimated_pp_demand_data)-5 ; $i++){
        $estimated_pp_demand_data[$i] = $estimated_pp_demand_data[$i] == NULL ? 0 : $estimated_pp_demand_data[$i];
        $planned_po_demand_data[$i] = $planned_po_demand_data[$i] == NULL ? 0 : $planned_po_demand_data[$i];
    }
    
    // CREATE DISTRIBUTION ROWS 
    $level_1 = array_fill_keys(range(-5,104),0);
    $level_2 = array_fill_keys(range(-5,104),0);
    $level_3 = array_fill_keys(range(-5,104),0);
    $level_4 = array_fill_keys(range(-5,104),0);
    $level_5 = array_fill_keys(range(-5,104),0);
    $distributed_subtotal = array_fill_keys(range(-5,104),0);
    $total = array_fill_keys(range(-5,104),0);

    // (SEE EXEL FILE IN THIS FOLDER FOR VISUAL OF HOW THE FOLLWING FEW LINES OF CODE WORKS) //

    // TAKE WHATEVER HOURS ARE IN ONE PARTICULAR WEEK, SPREAD IT ACCROSS THE FIVE WEEKS BEFOREHAND AND SKIP ANOTHER 5 
    // FOR EX (START AT 0 SPREAD HRS FROM -1 TO -5, SKIP TO 5 SPREAD ACCROSS TO 0 TO 4 UNTIL END OF ARRAY. GO BACK TO POS 1 AND REPEAT 1 -> -4 TO 0, 6 -> 1 - 5)
    // CONTINUE UNTIL ALL WEEKS FROM ESTIMATED PP DEMAND HAS BEEN DISTRIBUTED INTO A DISTRIBUTION ROW
    for($i = 0 ; $i <= 104 ; $i+=5){
        $level_1[$i-5] = $level_1[$i-4] = $level_1[$i-3] = $level_1[$i-2] = $level_1[$i-1] = $estimated_pp_demand_data[$i]/5;
    }
    for($i = 1 ; $i <= 104 ; $i+=5){
        $level_2[$i-5] = $level_2[$i-4] = $level_2[$i-3] = $level_2[$i-2] = $level_2[$i-1] = $estimated_pp_demand_data[$i]/5;
    }
    for($i = 2 ; $i <= 104 ; $i+=5){
        $level_3[$i-5] = $level_3[$i-4] = $level_3[$i-3] = $level_3[$i-2] = $level_3[$i-1] = $estimated_pp_demand_data[$i]/5;
    }
    for($i = 3 ; $i <= 104 ; $i+=5){
        $level_4[$i-5] = $level_4[$i-4] = $level_4[$i-3] = $level_4[$i-2] = $level_4[$i-1] = $estimated_pp_demand_data[$i]/5;
    }
    for($i = 4 ; $i <= 104 ; $i+=5){
        $level_5[$i-5] = $level_5[$i-4] = $level_5[$i-3] = $level_5[$i-2] = $level_5[$i-1] = $estimated_pp_demand_data[$i]/5;
    }
    for($i = -5; $i < 104 ;$i++){
        $distributed_subtotal[$i] += ($level_1[$i] + $level_2[$i] + $level_3[$i] + $level_4[$i] + $level_5[$i]);
    }

    // TAKE ANY HOURS IN THE WEEKS BEFORE THIS WEEK (POSITION 0) IN THE DISTRIBUTED SUBTOTAL AND SPREAD THEM OVER THE NEXT FIVE WEEKS. ALSO TAKE DATA FROM INDEXES -5 TO -1 IN ESTIMATED_PP_DEMAND AS THESE ARE EXCLUDED FROM DISTRIBUTION PROCESS.
    $backlog_propagated_distributed_subtotal = $distributed_subtotal;
    $backlog_propagated_distributed_subtotal[0] += ($estimated_pp_demand_data[-5] + $estimated_pp_demand_data[-4] + $estimated_pp_demand_data[-3] + $estimated_pp_demand_data[-2] + $estimated_pp_demand_data[-1])/(5) + ($distributed_subtotal[-5]+$distributed_subtotal[-4]+$distributed_subtotal[-3]+$distributed_subtotal[-2]+$distributed_subtotal[-1])/5;
    $backlog_propagated_distributed_subtotal[1] += ($estimated_pp_demand_data[-5] + $estimated_pp_demand_data[-4] + $estimated_pp_demand_data[-3] + $estimated_pp_demand_data[-2] + $estimated_pp_demand_data[-1])/(5) + ($distributed_subtotal[-5]+$distributed_subtotal[-4]+$distributed_subtotal[-3]+$distributed_subtotal[-2]+$distributed_subtotal[-1])/5;
    $backlog_propagated_distributed_subtotal[2] += ($estimated_pp_demand_data[-5] + $estimated_pp_demand_data[-4] + $estimated_pp_demand_data[-3] + $estimated_pp_demand_data[-2] + $estimated_pp_demand_data[-1])/(5) + ($distributed_subtotal[-5]+$distributed_subtotal[-4]+$distributed_subtotal[-3]+$distributed_subtotal[-2]+$distributed_subtotal[-1])/5;
    $backlog_propagated_distributed_subtotal[3] += ($estimated_pp_demand_data[-5] + $estimated_pp_demand_data[-4] + $estimated_pp_demand_data[-3] + $estimated_pp_demand_data[-2] + $estimated_pp_demand_data[-1])/(5) + ($distributed_subtotal[-5]+$distributed_subtotal[-4]+$distributed_subtotal[-3]+$distributed_subtotal[-2]+$distributed_subtotal[-1])/5;
    $backlog_propagated_distributed_subtotal[4] += ($estimated_pp_demand_data[-5] + $estimated_pp_demand_data[-4] + $estimated_pp_demand_data[-3] + $estimated_pp_demand_data[-2] + $estimated_pp_demand_data[-1])/(5) + ($distributed_subtotal[-5]+$distributed_subtotal[-4]+$distributed_subtotal[-3]+$distributed_subtotal[-2]+$distributed_subtotal[-1])/5;
    $backlog_propagated_distributed_subtotal[-5] = 0;
    $backlog_propagated_distributed_subtotal[-4] = 0;
    $backlog_propagated_distributed_subtotal[-3] = 0;
    $backlog_propagated_distributed_subtotal[-2] = 0;
    $backlog_propagated_distributed_subtotal[-1] = 0;

    // ADD PLANNED PROCESSER ORDER HOURS DIRECTLY TO THE DISTRIBUTED ESTIMATED PP DATA (PLANNED PO HOURS ARE NOT DISTRIBUTED)
    $distributed_pp_plus_planned_po = array_fill_keys(range(-5,104),0);
    for($i = -5; $i < 104; $i++){
        $distributed_pp_plus_planned_po[$i] = $planned_po_demand_data[$i]+$backlog_propagated_distributed_subtotal[$i];
    }
    
    // TWENTY WEEK AVERAGE TAKES FIVE WEEKS BEFORE AND TWENTY WEEKS AHEAD AND DIVIDES BY TWENTY TO FIND REQUIRED CAPACITY TO MEET CURRENT DEMAND
    // THE LEAD TIME IS CALCULATED BY DIVIDING THE SUM OFF ALL WORK OVER THE NEXT
    $twa = array_sum(array_slice($distributed_pp_plus_planned_po,0,26))/20;
    $twenty_week_workload = array_sum(array_slice($planned_po_demand_data,0,25));
    $lead_time = round($twenty_week_workload/($executed_fwa_data*0.85),2);

    $lead_time_data = array_fill(0,5,NULL);
    for($i = 0 ; $i < ceil($lead_time) ; $i++){
        array_push($lead_time_data,$executed_fwa_data*0.85);
    }
    for($i = 0 ; $i < (25 - 5 - ceil($lead_time)); $i++){
        array_push($lead_time_data,NULL);
    }
     
    $headline_figures = array(
        "Executed Last Week" => $executed_last_week_data,
        "Executed This Week" => $executed_this_week_data,
        "Executed Five Week Average" => $executed_fwa_data,
        "Executed Year To Date" => $executed_ytd_data,
        "Released Last Week" => $released_last_week_data,
        "Released This Week" => $released_this_week_data,
        "Released Five Week Average" => $released_fwa_data,
        "Released Year To Date" => $released_ytd_data,
        "Live PO Count" => $live_po_count_data,
        "Live Complete PO Count" => $live_po_count_comp_data,
        "Hours On Floor" => $open_hours_on_floor_data,
        "Lead Time" => $lead_time
    );

    // CONVERT RELATIVE WEEK DIFFERENCE TO WEEK NUMBERS (CALCULATED USING UNIX TIME DEVIATION)
    $weeks = array(range(-5, 104),array_fill(0,110,0));
    for($i = 0; $i < sizeof($weeks[0]) ; $i++){
        $weeks[1][$i] = array('label' => date('W',getdate()[0]+604800*$weeks[0][$i]));
        $weeks[0][$i] = array('label' => $weeks[0][$i]);
    }

    $estimated_pp_demand_graph_data = array();
    $planned_po_demand_graph_data = array();
    $capacity_graph_data = array();
    $lead_time_graph_data = array();
    $twenty_week_average_graph_data = array();
    $distributed_pp_plus_planned_po_graph_data = array();

    foreach($backlog_propagated_distributed_subtotal as $row){
        array_push($estimated_pp_demand_graph_data, array("value" => is_null($row) ? "0" : (string)$row));
    }
    foreach($planned_po_demand_data as $row){
        array_push($planned_po_demand_graph_data, array("value" => is_null($row) ? "0" : (string)$row));
    }
    for($i = -5; $i < 105 ; $i++){
        array_push($twenty_week_average_graph_data, array("value" => $twa));
    }
    for($i = -5; $i < 105 ; $i++){
        array_push($capacity_graph_data, array("value" => $executed_fwa_data*0.85));
    }
    foreach($distributed_pp_plus_planned_po as $row)
    {
        array_push($distributed_pp_plus_planned_po_graph_data, array("value" => $row));
    }
    foreach($lead_time_data as $row){
        array_push($lead_time_graph_data, array("value" => (string)$row));
    }

    file_put_contents("CACHED/headline_figures.json", json_encode($headline_figures));

    // ECODE AND SAVE ALL JSON FORMATTED ARRAYS AS JSON FILES
    file_put_contents("CACHED/data_last_updated.json", json_encode($current_time));
    file_put_contents("CACHED/released_today_list.json", json_encode($released_today_list_data));
    file_put_contents("CACHED/released_yesterday_list.json",json_encode($released_yesterday_list_data));
    file_put_contents("CACHED/complete_today_list.json", json_encode($complete_today_list_data));
    file_put_contents("CACHED/complete_yesterday_list.json", json_encode($complete_yesterday_list_data));
    file_put_contents("CACHED/open_hours_on_floor_details_data.json", json_encode($open_hours_on_floor_details_data));

    // WRITE DATA TO ARRAYS FORMATTED FOR FUSION CHARTS
    $graph_2_year_pp = array("seriesname" => "Estimated Pre Production", "renderAs" => "spline", "data" => $estimated_pp_demand_graph_data);
    $graph_2_year_po = array("seriesname" => "Planned Po", "renderAs" => "spline", "data" => $planned_po_demand_graph_data);
    $graph_2_year_twa = array("seriesname" => "Twenty_week_average", "renderAs" => "spline", "data" => $twenty_week_average_graph_data);
    $graph_2_year_cap = array("seriesname" => "capacity", "renderAs" => "area", "plotBorderThickness" => "5", "showPlotBorder" => "1",  "plotbordercolor" => "#F7C33E", "data" => $capacity_graph_data);
    $graph_2_year_tot = array("seriesname" => "Total", "initiallyhidden" => "1", "renderAs" => "spline", "data" => $distributed_pp_plus_planned_po_graph_data);

    $graph_1_year_pp = array("seriesname" => "Estimated Pre Production", "renderAs" => "spline", "data" => array_slice($estimated_pp_demand_graph_data,0,57));
    $graph_1_year_po = array("seriesname" => "Planned Po", "renderAs" => "spline", "data" => array_slice($planned_po_demand_graph_data,0,57));
    $graph_1_year_twa = array("seriesname" => "Twenty_week_average", "renderAs" => "spline", "data" => array_slice($twenty_week_average_graph_data,0,57));
    $graph_1_year_cap = array("seriesname" => "capacity", "renderAs" => "area", "plotBorderThickness" => "5", "showPlotBorder" => "1",  "plotbordercolor" => "#F7C33E", "data" => array_slice($capacity_graph_data,0,57));
    $graph_1_year_tot = array("seriesname" => "Total", "initiallyhidden" => "1", "renderAs" => "spline", "data" => array_slice($distributed_pp_plus_planned_po_graph_data,0,57));

    $graph_25w_pp = array("seriesname" => "Estimated Pre Production", "renderAs" => "spline", "data" => array_slice($estimated_pp_demand_graph_data,0,25));
    $graph_25w_po = array("seriesname" => "Planned Po", "renderAs" => "spline", "data" => array_slice($planned_po_demand_graph_data,0,25));
    $graph_25w_cap = array("seriesname" => "Capacity", "renderAs" => "spline", "data" => array_slice($capacity_graph_data,0,25));
    $graph_25w_lt = array("seriesname" => "Lead Time", "renderAs" => "area", "showPlotBorder" => "1", "plotBorderThickness" => "5", "plotbordercolor" => "#E84843", "data" => $lead_time_graph_data);

    // ENCODE ABOVE ARRAYS TO JSON FORMAT AND SAVE TO CAHCE
    file_put_contents("CACHED/two_year_graph_weeks.json", json_encode($weeks[1]));
    file_put_contents("CACHED/two_year_graph_data.json", json_encode([$graph_2_year_pp,$graph_2_year_po,$graph_2_year_twa,$graph_2_year_cap,$graph_2_year_tot]));

    file_put_contents("CACHED/one_year_graph_weeks.json", json_encode(array_slice($weeks[1],0,57)));
    file_put_contents("CACHED/one_year_graph_data.json", json_encode([$graph_1_year_pp,$graph_1_year_po,$graph_1_year_twa,$graph_1_year_cap,$graph_1_year_tot]));

    file_put_contents("CACHED/twenty_five_week_graph_weeks.json", json_encode(array_slice($weeks[1],0,25)));
    file_put_contents("CACHED/twenty_five_week_graph_data.json", json_encode([$graph_25w_pp,$graph_25w_po,$graph_25w_lt,$graph_25w_cap]));

    header('Location:BASE_production_menu.php');
?>

<!-- PRINT DEBUG DATA (COMMENT OUT HEADER REDIRECT ABOVE)

    <table style = 'width:5700px; font-size:15px; text-align:center; table-layout:fixed;'><tbody>
        <tr>
            <td style = 'width:200; text-align:left;'>Relative Promise Week No</td>
            <?php for($i = -5 ; $i < sizeof($estimated_pp_demand_data) -5 ; $i++): ?>
                <td style = 'width:50px;'><?=$i?></td>
            <?php endfor ?>
        </tr>
        <tr>
            <td style = 'width:200; text-align:left;'>Estimated PP Hours</td>
            <?php for($i = -5 ; $i < sizeof($estimated_pp_demand_data) -5 ; $i++): ?>
                <td style = 'width:50px;'><?=$estimated_pp_demand_data[$i]?></td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td style = 'width:200; text-align:left;'>------------------------------------------------</td>
            <?php for($i = -5 ; $i < sizeof($estimated_pp_demand_data) -5 ; $i++):?>
                <td style = 'width:50px;'>------------</td>
            <?php endfor; ?>
        </tr>
    <table>
    <table style = 'width:5700px; font-size:15px; text-align:center; table-layout:fixed;'><tbody>
        <tr>
            <td style = 'width:200; text-align:left;'>Distribution Row 1</td>
                <?php for($i = -5 ; $i < sizeof($level_1) -5 ; $i++):?>
                    <td style = 'width:50px'><?=$level_1[$i]?></td>
                <?php endfor;?>
        </tr>
        <tr>
            <td style = 'width:200; text-align:left;'>Distribution Row 2</td>
                <?php for($i = -5 ; $i < sizeof($level_2) -5 ; $i++):?>
                    <td style = 'width:50px;'><?=$level_2[$i]?></td>
                <?php endfor;?>
        </tr>
        <tr>
            <td style = 'width:200; text-align:left;'>Distribution Row 3</td>
            <?php for($i = -5 ; $i < sizeof($level_3) -5 ; $i++):?>
                <td style = 'width:50px;'><?=$level_3[$i]?></td>
            <?php endfor;?>
        </tr>
        <tr>
            <td style = 'width:200; text-align:left;'>Distribution Row 4</td>
            <?php for($i = -5 ; $i < sizeof($level_4) -5 ; $i++):?>
                <td style = 'width:50px;'><?=$level_4[$i]?></td>
            <?php endfor;?>
        </tr>
        <tr>
        <td style = 'width:200; text-align:left;'>Distribution Row 5</td>
            <?php for($i = -5 ; $i < sizeof($level_5) -5 ; $i++):?>
                <td style = 'width:50px;'><?=$level_5[$i]?></td>
            <?php endfor;?>
        </tr>
        <tr>
            <td style = 'width:200; text-align:left;'>--------------------------------------------</td>
            <?php for($i = -5 ; $i < sizeof($distributed_subtotal) -5 ; $i++):?>
                <td style = 'width:50px;'>------------</td>
            <?php endfor;?>
        </tr>
        <tr>
            <td style = 'width:200; text-align:left;'>Distributed Sum</td>
            <?php for($i = -5 ; $i < sizeof($distributed_subtotal) -5 ; $i++):?>
                <td style = 'width:50px;'><?=$distributed_subtotal[$i]?></td>
            <?php endfor; ?>
        </tr>
    <table>
    <table style = 'width:5700px; font-size:15px; text-align:center; table-layout:fixed;'><tbody>
        <tr>
            <td style = 'width:200'>-----------------------------------------</td>
            <?php for($i = -5 ; $i < sizeof($backlog_propagated_distributed_subtotal) -5 ; $i++):?>
                <td style = 'width:50px;'>------------</td>
            <?php endfor; ?>
        </tr>
        <tr>
            <td style = 'width:200; text-align:left;'>Forward Distributed Backlog</td>
            <?php for($i = -5 ; $i < sizeof($backlog_propagated_distributed_subtotal) -5 ; $i++):?>
                <td style = 'width:50px;'><?=$backlog_propagated_distributed_subtotal[$i]?></td>
            <?php endfor; ?>
        </tr>
    </table>
    <table style = 'width:5700px; font-size:15px; text-align:center; table-layout:fixed;'><tbody>
        <tr>
            <td style = 'width:200'>-----------------------------------------</td>
            <?php for($i = -5 ; $i < sizeof($planned_po_demand_data) -5 ; $i++): ?>
                <td style = 'width:50px;'>------------</td>
            <?php endfor; ?>
        </tr>    
        <tr>
            <td style = 'width:200; text-align:left;'>Live Work</td>
            <?php for($i = -5 ; $i < sizeof($planned_po_demand_data) -5 ; $i++):?>
                <td style = 'width:50px;'><?=$planned_po_demand_data[$i]?></td>
            <?php endfor;?>
        </tr>
    </table>
    <table style = 'width:5700px; font-size:15px; text-align:center; table-layout:fixed;'><tbody>
        <tr>
            <td style = 'width:200'>-----------------------------------------</td>
            <?php for($i = -5 ; $i < sizeof($distributed_pp_plus_planned_po) -5 ; $i++): ?>
                <td style = 'width:50px;'>------------</td>
            <?php endfor;?>
        </tr> 
        <tr>
            <td style = 'width:200; text-align:left;'>Total</td>
            <?php for($i = -5 ; $i < sizeof($distributed_pp_plus_planned_po) -5 ; $i++):?>
                <td style = 'width:50px;'><?=$distributed_pp_plus_planned_po[$i]?></td>
            <?php endfor;?>
        </tr>
    </table>
-->

