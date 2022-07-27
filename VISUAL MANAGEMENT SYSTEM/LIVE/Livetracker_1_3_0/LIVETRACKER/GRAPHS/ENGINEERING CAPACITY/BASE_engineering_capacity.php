<?php
    // IRRELEVANT HERE (NEED FOR ASSOCIATED QUERIES TO RUN PROPERLY)
    $start_time = time()-60*60*24*7*5;
    $start_range = -5;
    $end_range = 40;
?>
<?php

//FUNCTIONS
    //POSTION ZERO IS UNUSED WEEK ONE STARTS AT INDEX 1 IF YEAR HAS 53 WEEKS INCLUDE WORKING DAYS FOR BOTH WEEKS INSIDE POSITION 52
    $week_number =                array(0,1,2,3,4,5,6,7,8,9,0,1,2,3,4,5,6,7,8,9,0,1,2,3,4,5,6,7,8,9,0,1,2,3,4,5,6,7,8,9,0,1,2,3,4,5,6,7,8,9,0,1,2);
    $working_days_per_week_2020 = array(0,3,5,5,5,5,5,5,5,5,5,5,4,5,5,5,3,5,5,4,5,5,5,4,5,5,5,5,5,5,5,5,4,5,5,5,5,5,5,5,5,5,5,5,4,5,5,5,5,5,5,5,3);
    $working_days_per_week_2021 = array(0,5,5,5,5,5,5,5,5,5,5,4,5,5,3,5,5,5,4,5,5,5,5,4,5,5,5,5,5,5,5,4,5,5,5,5,5,5,5,5,5,5,5,4,5,5,5,5,5,5,5,4,0);
    $working_days_per_week_2022 = array(0,1,5,5,5,5,5,5,5,5,5,5,4,5,5,5,3,5,5,4,5,5,5,4,5,5,5,5,5,5,5,5,4,5,5,5,5,5,5,5,5,5,5,5,4,5,5,5,5,5,5,5,3);

    switch(2020){
        case 2020:  $working_days_per_week = $working_days_per_week_2020;   break;
        case 2021:  $working_days_per_week = $working_days_per_week_2021;   break;
        case 2022:  $working_days_per_week = $working_days_per_week_2022;   break;
        default:    $working_days_per_week = $working_days_per_week_2020;   break;
    }

    $build_plan_L1 = array(null);
    $build_plan_L2 = array(null);
    $build_plan_L3 = array(null);
    $build_plan_L4 = array(null);
    $build_plan_L5 = array(null);

    for($i = 0 ; $i <= 52 ; $i++)
    {
        array_push($build_plan_L1, 0);
        array_push($build_plan_L2, 0);
        array_push($build_plan_L3, 0);
        array_push($build_plan_L4, 0);
        array_push($build_plan_L5, 0);
    }

    function print_engineers($input_array)
    {
        for($i = 1; $i < sizeof($input_array) ; $i++)
        {
            echo "<p style = 'margin-top:0px; margin-top:2px; font-size:13px; padding:0; text-align:left; padding-left:5px; color:black;'>".$input_array[$i]."</p>";
        }
    }
    function print_engineers_capacity($input_array)
    {
        for($i = 1; $i < sizeof($input_array) ; $i++)
        {
            echo "<p style = 'margin-top:0px; margin-top:2px; font-size:13px; padding:0; color:black;'>".$input_array[$i]."</p>";
        }
    }
    function buildplan_calculator($input_array, $week, $print)
    {
        $backlog = 0;

        //////////////////////////////////////
        for($j = 11; $j <= 52 ; $j = $j+5)
        {
            $build_spread = $input_array[$j]/5;
            for($k = $j-10 ; $k < $j - 5 ; $k++)
            {
                $build_plan_L1[$k] = $build_spread;
            }
        }
        for($j = 12; $j <= 52 ; $j = $j+5)
        {
            $build_spread = $input_array[$j]/5;
            for($k = $j-10 ; $k < $j - 5 ; $k++)
            {
                $build_plan_L2[$k] = $build_spread;
            }
        }
        for($j = 13; $j <= 52 ; $j = $j+5)
        {
            $build_spread = $input_array[$j]/5;
            for($k = $j-10 ; $k < $j - 5 ; $k++)
            {
                $build_plan_L3[$k] = $build_spread;
            }
        }
        for($j = 14; $j <= 52 ; $j = $j+5)
        {
            $build_spread = $input_array[$j]/5;
            for($k = $j-10 ; $k < $j - 5 ; $k++)
            {
                $build_plan_L4[$k] = $build_spread;
            }
        }
        for($j = 15; $j <= 52 ; $j = $j+5)
        {
            $build_spread = $input_array[$j]/5;
            for($k = $j-10 ; $k < $j - 5 ; $k++)
            {
                $build_plan_L5[$k] = $build_spread;
            }
        }
        //////////////////////////////////////

        //////////////////////////////////////
        for($i = 43 ; $i <= 47 ; $i++)
        {
            $build_plan_L3[$i] = $input_array[1]/5;
        }
        for($i = 44 ; $i <= 48 ; $i++)
        {
            $build_plan_L4[$i] = $input_array[2]/5;
        }
        for($i = 45 ; $i <= 49 ; $i++)
        {
            $build_plan_L5[$i] = $input_array[3]/5;
        }
        ////////////////////////////////

        ////////////////////////////////
        for($i = 46 ; $i <= 52 ; $i++)
        {
            $build_plan_L1[$i] = round($input_array[4]/7 + $input_array[5]/7,1);
        }

        for($i = 47 ; $i <= 52 ; $i++)
        {
            $build_plan_L2[$i] = round($input_array[6]/7,1);
        }
        $build_plan_L2[1] = round($input_array[6]/7,1);

        for($i = 48 ; $i <= 52 ; $i++)
        {
            $build_plan_L3[$i] = round($input_array[7]/7,1);
        }
        $build_plan_L3[1] = round($input_array[7]/7,1);
        $build_plan_L3[2] = round($input_array[7]/7,1);

        for($i = 49 ; $i <= 52 ; $i++)
        {
            $build_plan_L4[$i] = round($input_array[8]/7,1);
        }
        $build_plan_L4[1] = round($input_array[8]/7,1);
        $build_plan_L4[2] = round($input_array[8]/7,1);
        $build_plan_L4[3] = round($input_array[8]/7,1);

        for($i = 50 ; $i <= 52 ; $i++)
        {
            $build_plan_L5[$i] = round($input_array[9]/7 + $input_array[10]/7,1);
        }
        $build_plan_L5[1] = round($input_array[9]/7 + $input_array[10]/7,1);
        $build_plan_L5[2] = round($input_array[9]/7 + $input_array[10]/7,1);
        $build_plan_L5[3] = round($input_array[9]/7 + $input_array[10]/7,1);
        $build_plan_L5[4] = round($input_array[9]/7 + $input_array[10]/7,1);
        /////////////////////////////////


        //////////////////////////////////
        for($i = 1; $i <= 52 ; $i++)
        {
            $required_engineering_hours[$i] = $build_plan_L1[$i] + $build_plan_L2[$i] + $build_plan_L3[$i] + $build_plan_L4[$i] + $build_plan_L5[$i];
        }
        for($i = $week -1; $i >= $week - 10 ; $i--)
        {
            if($i < 1)
            {
                $backlog += $required_engineering_hours[$i+52];
            }
            else
            {
                $backlog += $required_engineering_hours[$i];
            }
        }
        
        for($i = $week; $i < $week + 5 ; $i++)
        {
            if($i > 52)
            {
                $required_engineering_hours[$i-52] += $backlog/5;
            }
            else
            {
                $required_engineering_hours[$i] += $backlog/5;
            }
        }

        for($i = $week -1; $i >= $week - 10; $i--)
        {
            if($i < 1)
            {
                $required_engineering_hours[$i+52] = 0;
            }
            else
            {
                $required_engineering_hours[$i] = 0;
            }
        }

        if($print)
        {
            echo "<table style = 'width:100%; font-size:10px;'><tr>";
            for($i = 1 ; $i <= 52; $i++)
            {
                echo "<td style = 'width:1.9%;'>$i</td>";
            }
            echo "</tr><tr>";
            for($i = 1 ; $i <= 52; $i++)
            {
                echo "<td style = 'width:1.9%;'>$input_array[$i]</td>";
            }
            echo "</tr><tr>";
            for($i = 1 ; $i <= 52; $i++)
            {
                echo "<td style = 'width:1.9%;'>$build_plan_L1[$i]</td>";
            }
            echo "</tr><tr>";
            for($i = 1 ; $i <= 52; $i++)
            {
                echo "<td style = 'width:1.9%;'>$build_plan_L2[$i]</td>";
            }
            echo "</tr><tr>";
            for($i = 1 ; $i <= 52; $i++)
            {
                echo "<td style = 'width:1.9%;'>$build_plan_L3[$i]</td>";
            }
            echo "</tr><tr>";
            for($i = 1 ; $i <= 52; $i++)
            {
                echo "<td style = 'width:1.9%;'>$build_plan_L4[$i]</td>";
            }
            echo "</tr><tr>";
            for($i = 1 ; $i <= 52; $i++)
            {
                echo "<td style = 'width:1.9%;'>$build_plan_L5[$i]</td>";
            }
            echo "</tr><tr>";
            for($i = 1 ; $i <= 52; $i++)
            {
                echo "<td style = 'width:1.9%;'>$required_engineering_hours[$i]</td>";
            }
            echo "</tr></table>";

            echo $backlog;
        }

        return $required_engineering_hours;
    }

    // INCLUDE DB CONNECTION FILEAND SQL QUERY
    include '../../../SQL CONNECTIONS/conn.php';
    include '../../PRE PRODUCTION/SCHEDULE/pre production schedule/SQL_pre_production_schedule.php';
    include './SQL_engineers.php';
    
    // PREPARES DB ONNECTION WITH QUERY
    $getResults = $conn->prepare($pre_production_schedule);

    // EXECUTES QUERY AND ASSIGNS DATA TO $results
    $getResults->execute();
    $results = $getResults->fetchAll(PDO::FETCH_BOTH);

    $getResults = $conn->prepare($engineers);
    $getResults->execute();
    $engineers_c = $getResults->fetchAll(PDO::FETCH_BOTH);

    // ENGINEER LISTS
    $branded_products_civil_engineers = array(null);
    $branded_products_building_engineers = array(null);
    $engineering_contracts_engineers = array(null);
    $r_and_d_engineers = array(null);

    $branded_products_civil_engineers_capacity = array(null);
    $branded_products_building_engineers_capacity = array(null);
    $engineering_contracts_engineers_capacity = array(null);
    $r_and_d_engineers_capacity = array(null);

    $branded_products_civil_engineers_hours = array(null);
    $branded_products_building_engineers_hours = array(null);
    $engineering_contracts_engineers_hours = array(null);
    $r_and_d_engineers_hours = array(null);

    $branded_products_civil_engineers_available_hours = array(null);
    $branded_products_building_engineers_available_hours = array(null);
    $engineering_contracts_engineers_available_hours = array(null);
    $r_and_d_engineers_available_hours = array(null);

    $branded_products_civil_capacity = array(null);
    $branded_products_building_capacity = array(null);
    $engineering_contracts_capacity = array(null);
    $r_and_d_capacity = array(null);

    $branded_products_civil_difference = array(null);
    $branded_products_building_difference = array(null);
    $engineering_contracts_difference = array(null);
    $r_and_d_difference = array(null);

    $date = new DateTime();
    $week = $date->format("W") == 53 ? 52 : $date->format("W");
    $backlog = 0;

    // PADS OUT THE ARRAYS TO 53 COLUMNS (WEEKS 1 TO 52)
    for($i = 0 ; $i <= 52 ; $i++)
    {
        array_push($branded_products_civil_engineers_hours,0);
        array_push($branded_products_building_engineers_hours,0);
        array_push($engineering_contracts_engineers_hours,0);
        array_push($r_and_d_engineers_hours,0);
        array_push($branded_products_civil_engineers_available_hours,0);
        array_push($branded_products_building_engineers_available_hours,0);
        array_push($engineering_contracts_engineers_available_hours,0);
        array_push($r_and_d_engineers_available_hours,0);
    }

    array_push($branded_products_civil_engineers, "Sean Keating");
    array_push($branded_products_building_engineers, "Stephen Roche");
    array_push($engineering_contracts_engineers, "Ger Maguire");
    array_push($r_and_d_engineers, "Declan Heffernan"); 
    array_push($branded_products_civil_engineers_capacity, 0);
    array_push($branded_products_building_engineers_capacity, 0);
    array_push($engineering_contracts_engineers_capacity, 0);
    array_push($r_and_d_engineers_capacity, 0); 
    foreach($engineers_c as $row)
    {
        switch($row["Department"]){
            case 6:
                array_push($branded_products_building_engineers, $row ["Engineer Name"]);
                //print_r($branded_products_building_engineers);
                array_push($branded_products_building_engineers_capacity, $row["Capacity"]);
                //print_r($branded_products_building_engineers_capacity);
                break;
            case 7:
                array_push($branded_products_civil_engineers, $row ["Engineer Name"]);
                
                array_push($branded_products_civil_engineers_capacity, $row["Capacity"]);
                
                break;
            case 8:
                array_push($engineering_contracts_engineers, $row["Engineer Name"]);
                
                array_push($engineering_contracts_engineers_capacity, $row["Capacity"]);

                break;
            /* case 9:
                array_push($engineering_contracts_engineers, $row["Engineer Name"]);
                array_push($engineering_contracts_engineers_capacity, $row["Capacity"]);
                break; */
            case 10:
                array_push($r_and_d_engineers, $row["Engineer Name"]);
                array_push($r_and_d_engineers_capacity, $row["Capacity"]);
                break;
        }
    }
    
    foreach($results as $row)
    {
        if($row["Promise Week Due"] == 53)
        {
            $promise_week = 52;
        }
        else
        {
            $promise_week = $row["Promise Week Due"];
        }

        if(in_array($row["Engineer"],$branded_products_civil_engineers))
        {
            $branded_products_civil_engineers_hours[$promise_week] += $row["Est Remaining Eng Hrs"];
            if($row["Stage"] == '1. Drawings Approved' || $row["Stage"] == '1. Drawings Approved ( Fabrication Drawings)' || $row["Stage"] == '1. Drawings Approved (Fab Drawings)' || $row["Stage"] == '5. Engineer Drawing' || $row["Stage"] == '5. Engineer Drawing (Approval Drawings)' || $row["Stage"] == '3. Revised Drawing Required')
            {
                $branded_products_civil_engineers_available_hours[$promise_week] += $row["Est Remaining Eng Hrs"];
            }
        }   
        else if(in_array($row["Engineer"],$branded_products_building_engineers))
        {
            $branded_products_building_engineers_hours[$promise_week] += $row["Est Remaining Eng Hrs"];
            if($row["Stage"] == '1. Drawings Approved' || $row["Stage"] == '1. Drawings Approved ( Fabrication Drawings)' || $row["Stage"] == '1. Drawings Approved (Fab Drawings)' || $row["Stage"] == '5. Engineer Drawing' || $row["Stage"] == '5. Engineer Drawing (Approval Drawings)' || $row["Stage"] == '3. Revised Drawing Required')
            {
                $branded_products_building_engineers_available_hours[$promise_week] += $row["Est Remaining Eng Hrs"];
            }
        }
        else if(in_array($row["Engineer"],$engineering_contracts_engineers))
        {
            $engineering_contracts_engineers_hours[$promise_week] += $row["Est Remaining Eng Hrs"];
            if($row["Stage"] == '1. Drawings Approved' || $row["Stage"] == '1. Drawings Approved ( Fabrication Drawings)' || $row["Stage"] == '1. Drawings Approved (Fab Drawings)' || $row["Stage"] == '5. Engineer Drawing' || $row["Stage"] == '5. Engineer Drawing (Approval Drawings)' || $row["Stage"] == '3. Revised Drawing Required')
            {
                $engineering_contracts_engineers_available_hours[$promise_week] += $row["Est Remaining Eng Hrs"];
            }
        }
        else if(in_array($row["Engineer"],$r_and_d_engineers))
        {
            $r_and_d_engineers_hours[$promise_week] += $row["Est Remaining Eng Hrs"];
            if($row["Stage"] == '1. Drawings Approved' || $row["Stage"] == '1. Drawings Approved ( Fabrication Drawings)' || $row["Stage"] == '1. Drawings Approved (Fab Drawings)' || $row["Stage"] == '5. Engineer Drawing' || $row["Stage"] == '5. Engineer Drawing (Approval Drawings)' || $row["Stage"] == '3. Revised Drawing Required')
            {
                $r_and_d_engineers_available_hours[$promise_week] += $row["Est Remaining Eng Hrs"];
            }
        }
    }

    $required_branded_products_civil_engineering_hours = buildplan_calculator($branded_products_civil_engineers_hours, $week,0);
    $required_branded_products_building_engineering_hours = buildplan_calculator($branded_products_building_engineers_hours, $week,0);
    $required_engineering_contracts_engineering_hours = buildplan_calculator($engineering_contracts_engineers_hours, $week,0);
    $required_r_and_d_engineering_hours = buildplan_calculator($r_and_d_engineers_hours, $week,0);

    $required_branded_products_civil_engineering_available_hours = buildplan_calculator($branded_products_civil_engineers_available_hours, $week,0);
    $required_branded_products_building_engineering_available_hours = buildplan_calculator($branded_products_building_engineers_available_hours, $week,0);
    $required_engineering_contracts_engineering_available_hours = buildplan_calculator($engineering_contracts_engineers_available_hours, $week,0);
    $required_r_and_d_engineering_available_hours = buildplan_calculator($r_and_d_engineers_available_hours, $week,0);

    $total = array(array_sum($branded_products_civil_engineers_hours), array_sum($branded_products_building_engineers_hours), array_sum($engineering_contracts_engineers_hours), array_sum($r_and_d_engineers_hours));
    $total_available = array(array_sum($branded_products_civil_engineers_available_hours), array_sum($branded_products_building_engineers_available_hours), array_sum($engineering_contracts_engineers_available_hours), array_sum($r_and_d_engineers_available_hours));

    for($i = 1; $i <= 52 ; $i++)
    {
        $branded_products_civil_capacity[$i] = $working_days_per_week[$i]*(array_sum($branded_products_civil_engineers_capacity)/5);
        $branded_products_building_capacity[$i] = $working_days_per_week[$i]*(array_sum($branded_products_building_engineers_capacity)/5);
        $engineering_contracts_capacity[$i] = $working_days_per_week[$i]*(array_sum($engineering_contracts_engineers_capacity)/5);
        $r_and_d_capacity[$i] = $working_days_per_week[$i]*(array_sum($r_and_d_engineers_capacity)/5);
        $total_capacity[$i] = $branded_products_civil_capacity[$i] + $branded_products_building_capacity[$i] + $engineering_contracts_capacity[$i] + $r_and_d_capacity[$i];
    }
    for($i = 1 ; $i <= 52 ; $i++)
    {
        $branded_products_civil_difference[$i] = $required_branded_products_civil_engineering_hours[$i] - $branded_products_civil_capacity[$i];
        $branded_products_building_difference[$i] = $required_branded_products_building_engineering_hours[$i] - $branded_products_building_capacity[$i];
        $engineering_contracts_difference[$i] = $required_engineering_contracts_engineering_hours[$i] - $engineering_contracts_capacity[$i];
        $r_and_d_difference[$i] = $required_r_and_d_engineering_hours[$i] - $r_and_d_capacity[$i];
        if($branded_products_civil_difference[$i] < 0)
        {
            $branded_products_civil_difference[$i] = 0;
        }
        if($branded_products_building_difference[$i] < 0)
        {
            $branded_products_building_difference[$i] = 0;
        }
        if($engineering_contracts_difference[$i] < 0)
        {
            $engineering_contracts_difference[$i] = 0;
        }
        if($r_and_d_difference[$i] < 0)
        {
            $r_and_d_difference[$i] = 0;
        }
    }

    $required_branded_products_civil_hours_dp = array();
    $required_branded_products_civil_available_hours_dp = array();
    $branded_products_civil_capacity_hours_dp = array();
    $branded_products_civil_difference_hours_dp = array();

    $required_branded_products_building_hours_dp = array();
    $required_branded_products_building_available_hours_dp = array();
    $branded_products_building_capacity_hours_dp = array();
    $branded_products_building_difference_hours_dp = array();

    $required_engineering_contracts_hours_dp = array();
    $required_engineering_contracts_available_hours_dp = array();
    $engineering_contracts_capacity_hours_dp = array();
    $engineering_contracts_difference_hours_dp = array();

    $required_r_and_d_hours_dp = array();
    $required_r_and_d_available_hours_dp = array();
    $r_and_d_capacity_hours_dp = array();
    $r_and_d_difference_hours_dp = array();

    $total_hours_dp = array();

    $total_capacity_hours_dp = array();

    for($i = 0; $i <= 51 ; $i++)
    {
        $j = $i+1;
        array_push($required_branded_products_civil_hours_dp, array('y' => $required_branded_products_civil_engineering_hours[$j], 'label' => $j));
    }
    for($i = 0; $i <= 51 ; $i++)
    {
        $j = $i+1;
        array_push($required_branded_products_civil_available_hours_dp, array('y' => $required_branded_products_civil_engineering_available_hours[$j], 'label' => $j));
    }
    for($i = 0; $i <= 51 ; $i++)
    {
        $j = $i+1;
        array_push($branded_products_civil_capacity_hours_dp, array('y' => $branded_products_civil_capacity[$j], 'label' => $j));
    }
    for($i = 0; $i <= 51 ; $i++)
    {
        $j = $i+1;
        array_push($branded_products_civil_difference_hours_dp, array('y' => $branded_products_civil_difference[$j], 'label' => $j));
    }
    for($i = 0; $i <= 51 ; $i++)
    {
        $j = $i+1;
        array_push($required_branded_products_building_hours_dp, array('y' => $required_branded_products_building_engineering_hours[$j], 'label' => $j));
    }
    for($i = 0; $i <= 51 ; $i++)
    {
        $j = $i+1;
        array_push($required_branded_products_building_available_hours_dp, array('y' => $required_branded_products_building_engineering_available_hours[$j], 'label' => $j));
    }
    for($i = 0; $i <= 51 ; $i++)
    {
        $j = $i+1;
        array_push($branded_products_building_capacity_hours_dp, array('y' => $branded_products_building_capacity[$j], 'label' => $j));
    }
    for($i = 0; $i <= 51 ; $i++)
    {
        $j = $i+1;
        array_push($branded_products_building_difference_hours_dp, array('y' => $branded_products_building_difference[$j], 'label' => $j));
    }
    for($i = 0; $i <= 51 ; $i++)
    {
        $j = $i+1;
        array_push($required_engineering_contracts_hours_dp, array('y' => $required_engineering_contracts_engineering_hours[$j], 'label' => $j));
    }
    for($i = 0; $i <= 51 ; $i++)
    {
        $j = $i+1;
        array_push($required_engineering_contracts_available_hours_dp, array('y' => $required_engineering_contracts_engineering_available_hours[$j], 'label' => $j));
    }
    for($i = 0; $i <= 51 ; $i++)
    {
        $j = $i+1;
        array_push($engineering_contracts_capacity_hours_dp, array('y' => $engineering_contracts_capacity[$j], 'label' => $j));
    }
    for($i = 0; $i <= 51 ; $i++)
    {
        $j = $i+1;
        array_push($engineering_contracts_difference_hours_dp, array('y' => $engineering_contracts_difference[$j], 'label' => $j));
    }
    for($i = 0; $i <= 51 ; $i++)
    {
        $j = $i+1;
        array_push($required_r_and_d_hours_dp, array('y' => $required_r_and_d_engineering_hours[$j], 'label' => $j));
    }
    for($i = 0; $i <= 51 ; $i++)
    {
        $j = $i+1;
        array_push($required_r_and_d_available_hours_dp, array('y' => $required_r_and_d_engineering_available_hours[$j], 'label' => $j));
    }
    for($i = 0; $i <= 51 ; $i++)
    {
        $j = $i+1;
        array_push($r_and_d_capacity_hours_dp, array('y' => $r_and_d_capacity[$j], 'label' => $j));
    }
    for($i = 0; $i <= 51 ; $i++)
    {
        $j = $i+1;
        array_push($r_and_d_difference_hours_dp, array('y' => $r_and_d_difference[$j], 'label' => $j));
    }
    for($i = 0; $i <= 51 ; $i++)
    {
        $j = $i+1;
        array_push($total_capacity_hours_dp, array('y' => $total_capacity[$j], 'label' => $j));
    }

    array_push($total_hours_dp, array('y' => $total[0], 'label' => 'Branded Products Civil'));
    array_push($total_hours_dp, array('y' => $total[1], 'label' => 'Branded Products Building'));
    array_push($total_hours_dp, array('y' => $total[2], 'label' => 'Engineering Contracts & Solids Technology'));
    array_push($total_hours_dp, array('y' => $total[3], 'label' => 'R & D'));
  

?>
<!DOCTYPE HTML>
<html>
    <head>
    <link rel = "stylesheet" href = "../../../css/LT_style.css">
    <script type = "text/javascript" src = "../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
    <script type = "text/javascript" src = "../../../JS LIBS/THIRD PARTY/jquery.canvasjs.min.js"></script>
    <script>
        window.onload = function () 
        {
            var branded_products_civil_chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                animationDuration: 500,
                title:
                {
                    text: "Civil"
                },
                axisY:
                {
                    title: "Hours",
                    maximum: 1000
                },
                axisX:
                {
                    title: "Week Number",
                    minimum: 0,
                    interval:2,
                },
                toolTip:
                        {
                            shared: true
                        },
                data: 
                [
                    {
                        type: "spline",
                        name: "Engineering Hours",
                        showInLegend: true,
                        markerType: "none",
                        dataPoints: <?php echo json_encode($required_branded_products_civil_hours_dp , JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "spline",
                        name: "Engineering Capacity",
                        showInLegend: true,
                        markerType: "none",
                        dataPoints: <?php echo json_encode($branded_products_civil_capacity_hours_dp, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "spline",
                        name: "Available Workload",
                        showInLegend: true,
                        markerType: "none",
                        dataPoints: <?php echo json_encode($required_branded_products_civil_available_hours_dp, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                    type: "column",
                    name: "Overcapacity",
                    showInLegend: true,
                    dataPoints: <?php echo json_encode($branded_products_civil_difference_hours_dp, JSON_NUMERIC_CHECK); ?>
                    }
                ]
            });
            var branded_products_building_chart = new CanvasJS.Chart("chartContainer1", {
                animationEnabled: true,
                animationDuration: 500,
                title:
                {
                    text: "Building"
                },
                axisY:
                {
                    title: "Hours",
                    maximum: 200
                },
                axisX:
                {
                    title: "Week Number",
                    minimum: 0,
                    interval:2,
                },
                toolTip:
                        {
                            shared: true
                        },
                data: 
                [
                    {
                        type: "spline",
                        name: "Engineering Hours",
                        showInLegend: true,
                        markerType: "none",
                        dataPoints: <?php echo json_encode($required_branded_products_building_hours_dp , JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "spline",
                        name: "Engineering Capacity",
                        showInLegend: true,
                        markerType: "none",
                        dataPoints: <?php echo json_encode($branded_products_building_capacity_hours_dp, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "spline",
                        name: "Available Workload",
                        showInLegend: true,
                        markerType: "none",
                        dataPoints: <?php echo json_encode($required_branded_products_building_available_hours_dp, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "column",
                        name: "Overcapacity",
                        showInLegend: true,
                        dataPoints: <?php echo json_encode($branded_products_building_difference_hours_dp, JSON_NUMERIC_CHECK); ?>
                    }
                ]
            });
            var engineering_contracts_chart = new CanvasJS.Chart("chartContainer2", {
                animationEnabled: true,
                animationDuration: 500,
                title:
                {
                    text: "Enginering Contracts & Solids Technology"
                },
                axisY:
                {
                    title: "Hours",
                    maximum: 700
                },
                    axisX: {
                    title: "Week Number",
                    minimum: 0,
                    interval:2,
                },
                toolTip:
                        {
                            shared: true
                        },
                data: 
                [
                    {
                        type: "spline",
                        name: "Engineering Hours",
                        showInLegend: true,
                        markerType: "none",
                        dataPoints: <?php echo json_encode($required_engineering_contracts_hours_dp , JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "spline",
                        name: "Engineering Capacity",
                        showInLegend: true,
                        markerType: "none",
                        dataPoints: <?php echo json_encode($engineering_contracts_capacity_hours_dp, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "spline",
                        name: "Available Workload",
                        showInLegend: true,
                        markerType: "none",
                        dataPoints: <?php echo json_encode($required_engineering_contracts_available_hours_dp, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "column",
                        name: "Overcapacity",
                        showInLegend: true,
                        dataPoints: <?php echo json_encode($engineering_contracts_difference_hours_dp, JSON_NUMERIC_CHECK); ?>
                    }
                ]
            });
            var r_and_d_chart = new CanvasJS.Chart("chartContainer4", {
                animationEnabled: true,
                animationDuration: 500,
                title:
                {
                    text: "R & D"
                },
                axisY:
                {
                    title: "Hours",
                    maximum: 200
                },
                axisX:
                {
                    title: "Week Number",
                    minimum: 0,
                    interval:2,
                },
                toolTip:
                        {
                            shared: true
                        },
                data: 
                [
                    {
                        type: "spline",
                        name: "Engineering Hours",
                        showInLegend: true,
                        markerType: "none",
                        dataPoints: <?php echo json_encode($required_r_and_d_hours_dp , JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "spline",
                        name: "EngineeringCapacity",
                        showInLegend: true,
                        markerType: "none",
                        dataPoints: <?php echo json_encode($r_and_d_capacity_hours_dp, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "spline",
                        name: "Available Workload",
                        showInLegend: true,
                        markerType: "none",
                        dataPoints: <?php echo json_encode($required_r_and_d_available_hours_dp, JSON_NUMERIC_CHECK); ?>
                    },
                    {
                        type: "column",
                        name: "Overcapacity",
                        showInLegend: true,
                        dataPoints: <?php echo json_encode($r_and_d_difference_hours_dp, JSON_NUMERIC_CHECK); ?>
                    }
                ]
            });
            var total = new CanvasJS.Chart("chartContainer5", {
                animationEnabled: true,
                animationDuration: 500,
                interactivityEnabled: true,
                title:
                {
                    text: "Total Breakdown",
                },
                axisX:
                {
                    interval: 1,
                    minimum: 0,
                    intervalType: "week"
                },
                axisY:
                {
                    title: "Hours",
                    maximum: 1500,
                    gridColor: "#B6B1A8",
                    tickColor: "#B6B1A8"
                },
                data: 
                [
                    {        
                        type: "stackedColumn",
                        showInLegend: true,
                        name: "Civil",
                        dataPoints: <?php echo json_encode($required_branded_products_civil_hours_dp , JSON_NUMERIC_CHECK);?>
                    },
                    {
                        type: "stackedColumn",
                        showInLegend: true,
                        name: "Building",
                        dataPoints: <?php echo json_encode($required_branded_products_building_hours_dp , JSON_NUMERIC_CHECK);?>
                    },
                    {        
                        type: "stackedColumn",
                        showInLegend: true,
                        name: "Engineering Contracts & Solids Technology",
                        dataPoints: <?php echo json_encode($required_engineering_contracts_hours_dp , JSON_NUMERIC_CHECK);?>
                    },
                    {        
                        type: "stackedColumn",
                        showInLegend: true,
                        name: "R & D",
                        dataPoints: <?php echo json_encode($required_r_and_d_hours_dp , JSON_NUMERIC_CHECK);?>
                    },
                    {
                        type: "spline",
                        name: "total capacity",
                        showInLedgend:true,
                        markerType: "none",
                        dataPoints: <?php echo json_encode($total_capacity_hours_dp, JSON_NUMERIC_CHECK); ?>

                    }
                ],
                legend: {
                            cursor: "pointer",
                            itemclick: function (e) {
                                //console.log("legend click: " + e.dataPointIndex);
                                //console.log(e);
                                if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                    e.dataSeries.visible = false;
                                } else {
                                    e.dataSeries.visible = true;
                                }
                
                                e.chart.render();
                            }
                        }
            });
            var total_pie = new CanvasJS.Chart("chartContainer6", {
                animationEnabled: true,
                animationDuration: 500,
                title:
                {
                    text: "Business Units",
                },
                axisX:
                {
                    interval: 1,
                    intervalType: "week"
                },
                axisY:
                {
                    valueFormatString:"$#0bn",
                    gridColor: "#B6B1A8",
                    tickColor: "#B6B1A8"
                },
                data:
                [
                    {
                        type: "pie",
                        startAngle: 25,
                        toolTipContent: "<b>{label}</b>: {y}%",
                        legendText: "{label}",
                        indexLabelFontSize: 16,
                        indexLabel: "{label} - {y}",
                        dataPoints: <?php echo json_encode($total_hours_dp, JSON_NUMERIC_CHECK);?>
                    }
                ]
            });
                
            branded_products_building_chart.render();
            branded_products_civil_chart.render();
            engineering_contracts_chart.render();
            r_and_d_chart.render();
            total.render();
            total_pie.render();
        }
        </script>
    </head>
    <body>
        
        <div id = "background">
        <?php
        $k=sizeof($branded_products_civil_engineers );
        $p=sizeof($branded_products_civil_engineers_capacity);
        //echo($k);
        //echo($p);
        for ($i=1;$i<$k;$i++)
        {
            if(($branded_products_civil_engineers_capacity[$i])==null)
            {
                $branded_products_civil_engineers_capacity[$i]=0;
            }
                //echo ($branded_products_civil_engineers[$i].'-'.$branded_products_civil_engineers_capacity[$i]);
            
        }
        $k=sizeof($branded_products_building_engineers );
        echo($k);
        for ($i=1;$i<$k;$i++)
        {
            if(empty($branded_products_building_engineers_capacity[$i]))
            {
                $branded_products_building_engineers_capacity[$i]=0;
            }
                //echo ($branded_products_building_engineers[$i].'-'.$branded_products_building_engineers_capacity[$i]);
            
        }
        $k=sizeof($engineering_contracts_engineers );
        echo($k);
        for ($i=1;$i<$k;$i++)
        {
            if(empty($engineering_contracts_engineers_capacity[$i]))
            {
                $engineering_contracts_engineers_capacity[$i]=0;
            }
                //echo ($engineering_contracts_engineers[$i].'-'.$engineering_contracts_engineers_capacity[$i]);
            
        }
        $k=sizeof($r_and_d_engineers);
        echo($k);
        for ($i=1;$i<$k;$i++)
        {
            if(empty($r_and_d_engineers_capacity[$i]))
            {
                $r_and_d_engineers_capacity[$i]=0;
            }
                //echo ($r_and_d_engineers[$i].'-'.$r_and_d_engineers_capacity[$i]);
            
        }
    

    ?>
            <div id="engineer_names" style="height: 28vh; width: 8%; margin-left:1%; margin-top:1%; float:left; background-color:white;"><div style = "width:80%; display:inline-block; color:white;"><?php print_engineers($branded_products_civil_engineers ); ?></div><div style = "width:20%; display:inline-block;"><?php print_engineers_capacity($branded_products_civil_engineers_capacity); ?></div></div>
            <div id="chartContainer" style="height: 28vh; width: 40%; margin-top:1%; float:left;"></div>

            <div id="engineer_names" style="height: 28vh; width: 8%; margin-right:1%; margin-top:1%; float:right; background-color:white;"><div style = "width:80%; display:inline-block;"><?php print_engineers($branded_products_building_engineers); ?></div><div style = "width:20%; display:inline-block;"><?php print_engineers_capacity($branded_products_building_engineers_capacity); ?></div></div>
            <div id="chartContainer1" style="height: 28vh; width: 40%; margin-top:1%; float:right;"></div><br>

            <div id="engineer_names" style="height: 28vh; width: 8%; margin-left:1%; margin-top:1%; float:left; background-color:white;"><div style = "width:80%; display:inline-block;"><?php print_engineers($engineering_contracts_engineers); ?></div><div style = "width:20%; display:inline-block;"><?php print_engineers_capacity($engineering_contracts_engineers_capacity); ?></div></div>
            <div id="chartContainer2" style="height: 28vh; width: 40%; margin-top:1%; float:left;"></div>

            <div id="engineer_names" style="height: 28vh; width: 8%; margin-right:1%; margin-top:1%; float:right; background-color:white;"><div style = "width:80%; display:inline-block;"><?php print_engineers($r_and_d_engineers); ?></div><div style = "width:20%; display:inline-block;"><?php print_engineers_capacity($r_and_d_engineers_capacity); ?></div></div>
            <div id="chartContainer4" style="height: 28vh; width: 40%; margin-top:1%; float:right;"></div><br>

            <div id="chartContainer5" style="height: 28vh; width: 69%; margin-right:1%; margin-top:1%; margin-bottom:1%; float:right;"></div>
            <div id="chartContainer6" style="height: 28vh; width: 27%; margin-left:1%; margin-top:1%; margin-bottom:1%; float:left;"></div>
            <div>
                <button onclick='history.go(-1);' style = 'display: block; width: 98%; height: auto; margin-left: auto; margin-right: auto; font-size: 30px; margin-top:5px;'>Go Back</button>
            </div>
        </div>
    </body>
</html>                              