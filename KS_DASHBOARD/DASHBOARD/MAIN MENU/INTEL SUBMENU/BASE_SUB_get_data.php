<?php
    function append_string ($str1, $str2){
        $str1 .=$str2;
        return $str1;
    }


    //// READING SELECTED PROJECTS AND PASSING INFO TO QUERY AND TO RELOADED PAGE AS JSON TO SHOW CHECKBOXES ENABLED/DISABLED
    $checked = array();
    if(!empty($_POST['check_list'])) 
    {
        foreach($_POST['check_list'] as $check)
        {
            array_push($checked, $check);
   
        }
    }
    else
    {
        $checked = array('P1276 Pedestals', 'P1272 Pedestals');
    }

    $query_clauses = "";
    for($i = 0 ; $i < sizeof($checked) ; $i++)
    {
        if($i != 0)
        {
            $query_clauses = append_string($query_clauses, " OR ");
        }
        $query_clauses = append_string($query_clauses, "t5.U_Client = '".$checked[$i]."'");
    }


    //// CALCULATING WORKFLOW AND FORMATTING TABLE DATA ////
    $start_year = '2020';
    $start_week = 13;

    include '../../../SQL/connections/conn.php';
    include './SQL_intel_workflow_queries.php';

    $getResults = $conn->prepare($released_hours);
    $getResults->execute();
    $released_hours_ = $getResults->fetchAll(PDO::FETCH_BOTH);

    $getResults = $conn->prepare($hours_history);
    $getResults->execute();
    $hours_hist = $getResults->fetchAll(PDO::FETCH_BOTH);

    $getResults = $conn->prepare($projects_query);
    $getResults->execute();
    $projects = $getResults->fetchAll(PDO::FETCH_BOTH);

    $date = new DateTime();
    $week = $date->format("W") + 52 * ($date->format("Y")-$start_year);
    $chart_visibility = $week - $start_week;

    $labour_achieved = array();
    $released_labour = array();
    $gross_labour = array();
    $labour_efficiency = array();
    $labour_efficiency_detail = array();
    $labour_efficiency_detail_str = array();
    $labour_margin = array();
    $net_labour = array();
    $reaquisitioned_labour = array();
    $reaquisitioned_labour_detail = array();
    $overplanned_labour = array();
    $diff_labour = array();

    $cum_labour_achieved = array();
    $cum_released_labour = array();
    $cum_gross_labour = array();
    $cum_labour_efficiency = array();
    $cum_labour_margin = array();
    $cum_net_labour = array();
    $cum_reaquisitioned_labour = array();
    $cum_overplanned_labour = array();
    $cum_diff_labour = array();
    

    for($i = 0; $i <= $week; $i++)
    {
        array_push($labour_achieved, 0);
        array_push($released_labour, 0);
        array_push($gross_labour, 0);
        array_push($labour_efficiency, 0);
        array_push($labour_efficiency_detail, NULL);
        array_push($labour_efficiency_detail_str, "");
        array_push($labour_margin, 0);
        array_push($net_labour, 0);
        array_push($reaquisitioned_labour, 0);
        array_push($reaquisitioned_labour_detail, 0);
        array_push($overplanned_labour, 0);
        array_push($diff_labour, 0);

        array_push($cum_labour_achieved, 0);
        array_push($cum_released_labour, 0);
        array_push($cum_gross_labour, 0);
        array_push($cum_labour_efficiency, 0);
        array_push($cum_labour_margin, 0);
        array_push($cum_net_labour, 0);
        array_push($cum_reaquisitioned_labour, 0);
        array_push($cum_overplanned_labour, 0);
        array_push($cum_diff_labour, 0);
    }

    // PLACE LABOUR ACHIEVED IN EACH WEEK
    for($i = 0; $i < sizeof($hours_hist,0) ; $i++)
    {
        // IF LABOUR FOR PED WAS LOGGED BEFORE START YEAR OF PROJECT (ANY HOURS LOGGED BEFORE JAN 1 2020)
        if(($hours_hist[$i]["Week Created"] + ($hours_hist[$i]["Year Created"]-$start_year)*52) < 0)
        {
            $labour_achieved[0] += $hours_hist[$i]["Entry Hours Logged"];
        }
        else
        {
            $labour_achieved[$hours_hist[$i]["Week Created"] + ($hours_hist[$i]["Year Created"]-$start_year)*52] += $hours_hist[$i]["Entry Hours Logged"];
        }
    }
    
    // PLACE LABOUR RELEASED EACH WEEK
    for($i = 0; $i < sizeof($released_hours_,0) ; $i++)
    {
        // IF LABOUR FOR PED WAS RELEASED BEFORE START YEAR OF PROJECT (ANY HOURS RELEASED BEFORE JAN 1 2020)
        if(($released_hours_[$i]["Week Released"] + ($released_hours_[$i]["Year Released"]-$start_year)*52) < 0 )
        {
            $released_labour[0] += $released_hours_[$i]["Planned Hours"];
        }
        else
        {
            $released_labour[$released_hours_[$i]["Week Released"] + ($released_hours_[$i]["Year Released"]-$start_year)*52] += $released_hours_[$i]["Planned Hours"];
        }
    }

    // SETUP VARIABLES TO HOLD AND TRACK CURRENT PROCESS ORDER IN LOGGED HOURS HISTORY
    $pr_ord_no = $hours_hist[0][0];
    $planned_hrs = $hours_hist[0][4];
    $planned_hrs_buff = 0;
    $passed = 0;

    // FOR EVERY ENTRY IN LOGGED HOURS TABLE
    for($i = 0; $i < sizeof($hours_hist,0); $i++)
    {
        // IF THERE IS A NEW PROCESS ORDER
        if($pr_ord_no != $hours_hist[$i][0])
        {
            // IF PREVIOUS PROCESS ORDER IS COMPLETE/OTHER CONDITIONS REQUISITION THE HOURS IN THE WEEKNUMBER OF THE LAST ENTRY IN THE LOGGED HOURS TABLE
            if(($hours_hist[$i-1][7] == 'Yes' || $hours_hist[$i-1][7] == '1002' || $hours_hist[$i-1][7] == '1003' || $hours_hist[$i-1][8] == 'L' || $hours_hist[$i-1][9] == 'Y' || $hours_hist[$i-1][5] >= $hours_hist[$i-1][6])  && $planned_hrs_buff < $hours_hist[$i-1]["Planned Labour"])
            {
                $reaquisitioned_labour[$hours_hist[$i-1]["Week Created"] + ($hours_hist[$i-1]["Year Created"] - $start_year)*52] += ($hours_hist[$i-1]["Planned Labour"] - $planned_hrs_buff);
                $reaquisitioned_labour_detail[$hours_hist[$i-1]["Week Created"] + ($hours_hist[$i-1]["Year Created"] - $start_year)*52].="\n ".$hours_hist[$i-1]["Process Order"]." ".($hours_hist[$i-1]["Planned Labour"] - $planned_hrs_buff);
            }
            if(($hours_hist[$i-1][7] == 'Yes' || $hours_hist[$i-1][7] == '1002' || $hours_hist[$i-1][7] == '1003' || $hours_hist[$i-1][8] == 'L' || $hours_hist[$i-1][9] == 'Y' || $hours_hist[$i-1][5] >= $hours_hist[$i-1][6])  && $planned_hrs_buff > $hours_hist[$i-1]["Planned Labour"])
            {
                $overplanned_labour[$hours_hist[$i-1]["Week Created"] + ($hours_hist[$i-1]["Year Created"] - $start_year)*52] += ($hours_hist[$i-1]["Planned Labour"] - $planned_hrs_buff);
            }

            // RESET PROCESS ORDER DETAILS FOR NEXT SET OF ENTRIES
            $pr_ord_no = $hours_hist[$i]["Process Order"];
            $planned_hrs = $hours_hist[$i]["Planned Labour"];
            $planned_hrs_buff = 0;
            $passed = 0;
        }
    
        // IF HOURS LOGGED FOR CONCURRENT PROCESS ORDER HAS EXCEEDED PLANNED HOURS FOR SAID ORDER FOR CURRENT ENTRY
        if(($hours_hist[$i]["Entry Hours Logged"] + $planned_hrs_buff) > $planned_hrs && $passed == 0)
        {
            // SEE ABOVE
            if(($hours_hist[$i][1] + ($hours_hist[$i][2] - $start_year)*52) < 0)
            {
                // PLACE THE EXCESS HOURS IN POSITION (SEE EXAMPLES ABOVE FOR DETAILS ON POSITION)
                $labour_efficiency[0] += (($hours_hist[$i]["Entry Hours Logged"] + $planned_hrs_buff) - $planned_hrs);
            }
            else
            {
                // PLACE THE EXCESS HOURS IN POSITION (SEE EXAMPLES ABOVE FOR DETAILS ON POSITION)
                $labour_efficiency[$hours_hist[$i]["Week Created"] + ($hours_hist[$i]["Year Created"] - $start_year)*52] += (($hours_hist[$i]["Entry Hours Logged"] + $planned_hrs_buff) - $planned_hrs);
                if(isset($labour_efficiency_detail[$hours_hist[$i]["Week Created"] + ($hours_hist[$i]["Year Created"] - $start_year)*52][$hours_hist[$i]["Process Order"]])){
                    $labour_efficiency_detail[$hours_hist[$i]["Week Created"] + ($hours_hist[$i]["Year Created"] - $start_year)*52][$hours_hist[$i]["Process Order"]] += (($hours_hist[$i]["Entry Hours Logged"] + $planned_hrs_buff) - $planned_hrs);
                }
                else{
                    $labour_efficiency_detail[$hours_hist[$i]["Week Created"] + ($hours_hist[$i]["Year Created"] - $start_year)*52][$hours_hist[$i]["Process Order"]] = (($hours_hist[$i]["Entry Hours Logged"] + $planned_hrs_buff) - $planned_hrs);
                }

                //$labour_efficiency_detail[$hours_hist[$i]["Week Created"] + ($hours_hist[$i]["Year Created"] - $start_year)*52] .= "\n ".$hours_hist[$i]["Process Order"]." ".round((($hours_hist[$i]["Entry Hours Logged"] + $planned_hrs_buff) - $planned_hrs),0);
            }
            $passed = 1;
        }

        // IF PLANNED HOURS FOR CONCURRENT PROCESS ORDER HAS ALREADY BEEN PASSED BUT THERE ARE STILL MORE ENTRIES
        else if($passed == 1)
        {
            // SEE ABOVE (LINE 134)
            if(($hours_hist[$i]["Week Created"] + ($hours_hist[$i]["Year Created"] - $start_year)*52) < 0)
            {
                // INCREMENT HOURS IN POSITION (SEE EXAMPLES ABOVE FOR DETAILS ON POSITION)
                $labour_efficiency[0] += $hours_hist[$i][3];
            }
            else
            {
                // INCREMENT HOURS IN POSITION (SEE EXAMPLES ABOVE FOR DETAILS ON POSITION)
                $labour_efficiency[$hours_hist[$i]["Week Created"] + ($hours_hist[$i]["Year Created"] - $start_year)*52] += $hours_hist[$i][3];
                if(isset($labour_efficiency_detail[$hours_hist[$i]["Week Created"] + ($hours_hist[$i]["Year Created"] - $start_year)*52][$hours_hist[$i]["Process Order"]])){
                    $labour_efficiency_detail[$hours_hist[$i]["Week Created"] + ($hours_hist[$i]["Year Created"] - $start_year)*52][$hours_hist[$i]["Process Order"]] += $hours_hist[$i][3];
                }
                else{
                    $labour_efficiency_detail[$hours_hist[$i]["Week Created"] + ($hours_hist[$i]["Year Created"] - $start_year)*52][$hours_hist[$i]["Process Order"]] = $hours_hist[$i][3];
                }
                //$labour_efficiency_detail[$hours_hist[$i]["Week Created"] + ($hours_hist[$i]["Year Created"] - $start_year)*52] .= "\n ".$hours_hist[$i]["Process Order"]." ".round($hours_hist[$i][3],0);
            }
        }
        $planned_hrs_buff += $hours_hist[$i]["Entry Hours Logged"];
    }


    // NET LABOUR IS GROSS LABOUR MINUS HOURS OVER PLANNED
    for($i = 0; $i <= $week ; $i++){
        $net_labour[$i] = $labour_achieved[$i] - $labour_efficiency[$i] + $reaquisitioned_labour[$i];
        $diff_labour[$i] = $net_labour[$i] - $released_labour[$i];
        $labour_margin[$i] = $reaquisitioned_labour[$i]-($overplanned_labour[$i]*-1);
    }

    // CALCUlATE CUMULATIVE TOTALS FOR EACH ARRAY
    for($i = 0; $i <= $week; $i++){
        // FOR FIRST POS TAKE FIRST EEMENT IN ARRAY AND PLACEAT START ONLY
        if($i == 0){
            $cum_labour_achieved[$i] = $labour_achieved[$i];
            $cum_released_labour[$i] = $released_labour[$i];
            $cum_labour_efficiency[$i] = $labour_efficiency[$i];
            $cum_reaquisitioned_labour[$i] = $reaquisitioned_labour[$i];
            $cum_gross_labour[$i] = $gross_labour[$i];
            $cum_net_labour[$i] = $net_labour[$i];
            $cum_diff_labour[$i] = $diff_labour[$i];
            $cum_labour_margin[$i] = $labour_margin[$i];
        }
        // FOR ALL FOLLOWING POSITIONED ADD PREVIOUS POS IM CUMULATIVE PLUS CURRENT POS IN WEEK ARRAY
        else{
            $cum_labour_achieved[$i] = $cum_labour_achieved[$i-1] + $labour_achieved[$i];
            $cum_released_labour[$i] = $cum_released_labour[$i-1] + $released_labour[$i];
            $cum_labour_efficiency[$i] = $cum_labour_efficiency[$i-1] + $labour_efficiency[$i];
            $cum_reaquisitioned_labour[$i] = $cum_reaquisitioned_labour[$i-1] + $reaquisitioned_labour[$i];
            $cum_gross_labour[$i] = $cum_gross_labour[$i-1] + $gross_labour[$i];
            $cum_net_labour[$i] = $cum_net_labour[$i-1] + $net_labour[$i];
            $cum_diff_labour[$i] = $cum_diff_labour[$i-1] + $diff_labour[$i];
            $cum_labour_margin[$i] = $cum_labour_margin[$i-1] + $labour_margin[$i];
        }
    }

    //// CHART DATA /////
    $json_data = array();
    $start_date = date("d-m-y", 1585524600);

    for($i = $week-$chart_visibility; $i <= $week ; $i++)
    {
        array_push($json_data, array(date("d-m-y", 1585524600+604800*(-1*($week-$chart_visibility-$i))), 'Released Hours', $released_labour[$i]));
        array_push($json_data, array(date("d-m-y", 1585524600+604800*(-1*($week-$chart_visibility-$i))), 'Labour Achieved', $labour_achieved[$i]));
        array_push($json_data, array(date("d-m-y", 1585524600+604800*(-1*($week-$chart_visibility-$i))), 'Cumulative Difference', $cum_diff_labour[$i]));
        array_push($json_data, array(date("d-m-y", 1585524600+604800*(-1*($week-$chart_visibility-$i))), 'Margin', $cum_labour_margin[$i]));
    }
    $json_data_js = json_encode($json_data);

    $schema  = array(array('name' => 'Time', 'type' => 'date', 'format' => '%d-%m-%y'),array('name' => 'Type', 'type' => 'string'),array('name' => 'hours', 'type' => 'number'));
    $schema_js = json_encode($schema);



    $chart_data_released = array();
    $chart_data_achieved = array();
    $chart_data_cum_diff_labour = array();
    $chart_data_labour_margin = array();

    $json_data_chart_js = array();
    $json_data_chart_cat = array();
    $json_data_chart_cat_js = array();
    $start_date = date("w", 1585524600);
    for($i = $week-$chart_visibility; $i <= $week ; $i++)
    {
        array_push($chart_data_released, array('value' => $released_labour[$i]));
        array_push($chart_data_achieved, array('value' => $labour_achieved[$i]));
        array_push($chart_data_cum_diff_labour, array('value' => $cum_diff_labour[$i]));
        array_push($chart_data_labour_margin, array('value' => $cum_labour_margin[$i]));

        array_push($json_data_chart_cat, array('label' => (string)(($start_date + $i - 1) > 52 ? ($start_date + $i - 1)-52*(floor($i/52)) : ($start_date + $i - 1))));
    }
    array_push($json_data_chart_js, array('seriesname' => 'Released Hours', 'data' => $chart_data_released));
    array_push($json_data_chart_js, array('seriesname' => 'Booked Hours', 'data' => $chart_data_achieved));
    array_push($json_data_chart_js, array('seriesname' => 'Cumulative Difference', 'data' => $chart_data_cum_diff_labour));
    array_push($json_data_chart_js, array('seriesname' => 'Margin', 'data' => $chart_data_labour_margin));



    foreach($labour_efficiency_detail as $keyw => $week){
        if(gettype($week) != 'array'){
            continue;
        }
        foreach($week as $keyp => $po){
            //print($keyw." ".$keyp." ".$po.' ');
            $labour_efficiency_detail_str[$keyw] .= $keyp." ".round($po)."\n";
        }
    }


    file_put_contents("CACHED/intel_chart_data.json", json_encode($json_data_chart_js));
    file_put_contents('CACHED/intel_chart_data_cat.json',json_encode($json_data_chart_cat));

    //// CACHE ALL DATA ////
    file_put_contents(__DIR__."\CACHED\data_last_updated.json", getdate()[0]);

    file_put_contents("CACHED/projects.json", json_encode($projects));
    file_put_contents('CACHED/selected_projects.json',json_encode($checked));

    file_put_contents("CACHED/labour_achieved.json", json_encode($labour_achieved));
    file_put_contents("CACHED/released_labour.json", json_encode($released_labour));
    file_put_contents("CACHED/gross_labour.json", json_encode($gross_labour));
    file_put_contents("CACHED/labour_efficiency.json", json_encode($labour_efficiency));
    file_put_contents("CACHED/labour_efficiency_detail.json", json_encode($labour_efficiency_detail_str));
    file_put_contents("CACHED/net_labour.json", json_encode($net_labour));
    file_put_contents("CACHED/reaquisitioned_labour.json", json_encode($reaquisitioned_labour));
    file_put_contents("CACHED/reaquisitioned_labour_detail.json", json_encode($reaquisitioned_labour_detail));
    file_put_contents("CACHED/diff_labour.json", json_encode($diff_labour));
    file_put_contents("CACHED/labour_margin.json", json_encode($labour_margin));
    file_put_contents("CACHED/cum_labour_achieved.json", json_encode($cum_labour_achieved));
    file_put_contents("CACHED/cum_released_labour.json", json_encode($cum_released_labour));
    file_put_contents("CACHED/cum_gross_labour.json", json_encode($cum_gross_labour));
    file_put_contents("CACHED/cum_labour_efficiency.json", json_encode($cum_labour_efficiency));
    file_put_contents("CACHED/cum_net_labour.json", json_encode($cum_net_labour));
    file_put_contents("CACHED/cum_reaquisitioned_labour.json", json_encode($cum_reaquisitioned_labour));
    file_put_contents("CACHED/cum_labour_margin.json", json_encode($cum_labour_margin));
    file_put_contents("CACHED/cum_diff_labour.json", json_encode($cum_diff_labour));

    file_put_contents("CACHED/data.json", $json_data_js);
    file_put_contents("CACHED/data_schema.json", $schema_js);

    // RELOAD ORIGINAL PAGE
    header('Location:BASE_intel_workflow.php');
    
    ?>
<!DOCTYPE HTML> 
<html>
    <head>
        <meta charset = "utf-8">
		<meta name = "description" content = "meta description">
		<meta name = "viewpport" content = "width=device-width, initial-scale = 1">
    </head>
    <body>
        <h1>TEST</h1>
        <table style="width:6000px; text-align:left;">
            <thead>
                <tr><td style="width:300px;">IND NO</td><?php for($i = 0; $i <= ((date('Y')-2020)*52 - (13 - (int)date('W'))) ; $i++){echo "<th style='width:200px;''>$i</th>";}?></tr>
                <tr><td style="width:300px;">WEEK NO</td><?php for($i = 1; $i <= ((date('Y')-2020)*52 + 13 - (13 - (int)date('W'))) ; $i++){echo "<th style='width:200px;''>".($i > 52 ? (($i -52) > 52 ? $i -104 : $i -52) : $i)."</th>";}?></tr>
            </thead>
            <tbody>
                <tr><td>BOOKED HOURS</td><?php foreach($labour_achieved as $week){echo "<td>".round($week)."</td>";}?></tr>
                <tr><td>OVERPLANNED</td><?php foreach($labour_efficiency as $week){echo "<td>".round($week)."</td>";}?></tr>
                <tr><td>REQUISITIOND</td><?php foreach($reaquisitioned_labour as $week){echo "<td>".round($week)."</td>";}?></tr>
                <tr><td>NET</td><?php foreach($net_labour as $week){echo "<td>".round($week)."</td>";}?></tr>
                
            </tbody>
        </table>
    </body>
</html>

