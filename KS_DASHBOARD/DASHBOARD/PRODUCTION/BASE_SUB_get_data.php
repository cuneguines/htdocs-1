 <?php
    // REMAINING HOURS TO DAYS FUNCTION PARAMITERS
    $efficiency = 0.63;
    $slope_decay_factor = 0.2;
    $subcon_add_weight = 0.22;
    $median_job_size = 90;

    // INITALISE WEEKS IN YEAR
    $weeks_in_this_year = 52;
    $weeks_in_last_year = 52;

    // CALCUKATE START AND END WEEK NUMBER BASED ON START WEEK 5 WEEKS BEFORE THIS WEEK AND END WEEK 25 WEEKS AHEAD OF THIS WEEK
    // ALSO DEFINE IF THE OVERLAP WILL OCCUR AT THE START OF THIS YEAR (5 WEEKS BEFORE ON WEEK 3 = 50,51,52,1,2,3,4,...) OR END OF THIS YEAR (25 WEEKS AHEAD ON WEEK 50 = 50,51,52,1,2,3,4,...) 
    $start_week = (date('W') - 5) < 1 ? $weeks_in_last_year - (-(date('W') - 5)) : date('W') - 5;
    $end_week = (date('W') + 25) > $weeks_in_this_year ? (date('W') + 25) - $weeks_in_this_year : (date('W') + 25);
    $year_overlap_ragion = date('W') <= 5 ? "LY" : "TY";
    
    // BUILD THE LIST OF WEEKS INCLUDED IN THE RANGE USING WEEKS IN THIS YEAR / LAST YEAR TO INCLUDE/ EXCLUDE ANY WEEK 53 WHEN THEY OCCUR (2016,2020,2024)
    $week_numbers = array();
    $week_loop = $start_week;
    for($i = 0 ; $i <= 30 ; $i++)
    {
        $week_numbers[$week_loop] = NULL;
        // IF WE ARE OVERLAPPING FROM LAST YEAR TO THIS YEAR USE WEEKS IN LAST YEAR OTHERWISE USE WEEKS IN THIS YEAR (ACCOUNTS FOR 53 VS 52 WEEKS YEARS)
        if($year_overlap_ragion == "LY"){$week_loop = $week_loop++ == $weeks_in_last_year ? 1 : $week_loop++;} 
        if($year_overlap_ragion == "TY"){$week_loop = $week_loop++ == $weeks_in_this_year ? 1 : $week_loop++;} 
    }

    include '../../PHP LIBS/PHP FUNCTIONS/php_function.php';
    include '../../PHP LIBS/PHP FUNCTIONS/php_constants.php';
    include '../../SQL/CONNECTIONS/conn.php';
    include './SQL_material_prep.php';

    $query_clause_list = $production_group_step_categories_graph_data = $production_group_step_demand_graph_data = $production_group_step_capacity_graph_data = $step_capacity_json = $step_demand_list_json = $graph_week_numbers_json = array();

    // INITALISE ARRAY THAT HOLDS THE PRODUCTION DEMAND FOR EACH WEEK PER STATUS OF PRODUCTION ITEMS IN EACH LABUR STAGE ()
    // EACH LINE EQUALS NAME OF STEP AND CONTAINS FOUR ARRAYS WITH THE WEEK NUMBERS ONE FOR EACH STATUS
    $pivot_graph_data = $pivot_graph_week_demand2 = array(
        $group_steps_template[1]["steps"][1] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[1]["steps"][2] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[1]["steps"][3] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[1]["steps"][4] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[1]["steps"][5] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[1]["steps"][6] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[1]["steps"][7] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[1]["steps"][8] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[2]["steps"][1] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[2]["steps"][2] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[2]["steps"][3] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[2]["steps"][4] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[2]["steps"][5] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[2]["steps"][6] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[2]["steps"][7] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[2]["steps"][8] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[3]["steps"][1] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[3]["steps"][2] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[3]["steps"][3] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[3]["steps"][4] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[3]["steps"][5] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[3]["steps"][6] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[3]["steps"][7] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[3]["steps"][8] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[4]["steps"][1] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[4]["steps"][2] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[4]["steps"][3] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[4]["steps"][4] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[4]["steps"][5] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[4]["steps"][6] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[4]["steps"][7] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[4]["steps"][8] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[5]["steps"][1] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[5]["steps"][2] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[5]["steps"][3] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[5]["steps"][4] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[5]["steps"][5] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[5]["steps"][6] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[5]["steps"][7] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[5]["steps"][8] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[6]["steps"][1] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[6]["steps"][2] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[6]["steps"][3] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[6]["steps"][4] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[6]["steps"][5] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[6]["steps"][6] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[6]["steps"][7] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers),
        $group_steps_template[6]["steps"][8] => array("NS" => $week_numbers, "NC" => $week_numbers, "IP" => $week_numbers, "RD" => $week_numbers, "BKLG" => $week_numbers)
    );
    
    /////////////////////////////////////////////////////////////////////////////////////////
    //          FOR THE DEMAND VS CAPACITY FRONT PAGE CHART ON EACH GROUP PAGE             //
    /////////////////////////////////////////////////////////////////////////////////////////


    // STORE GROUP STEP TEMPLATE IN CACHE
    file_put_contents("CACHED/group_steps_template.json", json_encode($group_steps_template));


    // RUN AVG EXECUTION TIME PER WEEK QUERY AND STORE IN JSON FORMATTED ARRAY IN CACHE, USED HERE AND FOR EACH INDIVUDAL LABOUR STEP WEEKLY DEMAND CHART
    $production_group_step_avg_execution_data = get_sap_data($conn,$sql_production_group_step_avg_execution,DEFAULT_DATA);
    foreach($production_group_step_avg_execution_data as $row){
        $step_capacity_json[$row["U_OldCode"]] = $row["AVG OF BEST 5 WEEKS FROM LAST 10"] == NULL ? 0 : $row["AVG OF BEST 5 WEEKS FROM LAST 10"];
    }
    file_put_contents("CACHED/step_capacity.json", json_encode($step_capacity_json));


    // RUN DEMAND PER STEP AND STORE IN JSON FORMATTED ARRAY IN CAHCE
    $step_demand_list = get_sap_data($conn,$production_group_step_demand_all_sql,DEFAULT_DATA);
    foreach($step_demand_list as $step){
        $step_demand_list_json[$step["Sequence Code"]] = $step["QTY"];
    }
    file_put_contents("CACHED/step_demand.json", json_encode($step_demand_list_json));


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    //          FOR STEP DETAIL TABLE AND INDIVUAL LABOUR STEP DEMAND VS OPERATING AVERAGE GRAPHS            //
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////


    // RUN PRODUCTION DETAIL TABLE FOR ALL INSTANES OF ALL STEPS
    $production_group_step_table_data = get_sap_data($conn,$production_group_step_table_sql,DEFAULT_DATA);
    file_put_contents("CACHED/production_step_table.json", json_encode($production_group_step_table_data));


    // BUILD WEEK NUMBER CATEGORIES FOR WEEKLY BAR CHART AND SAVE AS JSON FORMATTED FOR FUSIONCHARTS
    foreach($pivot_graph_data["SEQ001"]['NS'] as $weekno => $data){
        array_push($graph_week_numbers_json,array("label" => (string)$weekno));
    }
    file_put_contents("CACHED/pivot_week_numbers.json", json_encode($graph_week_numbers_json));
    
    // PUT RAMAINING TIME FOR INSTANCE OF STEP ON ITS STEP LINE IN GRAPH DATA ARRAY IN WEEK ESTIMATED TO START (CALCULATED IN QUERY), IF BEFORE 5 WEEKS AGO PUT 5 WEEKS AGO, IF AFTER 25 WEEKS TO COME PUT IN WEEK 25 WEEKS FROM NOW
    foreach($production_group_step_table_data as $row){
        $pivot_graph_data[$row["Sequence Code"]][$row["Prev Step Status"] == 'FS' ? 'RD' : $row["Prev Step Status"]][$row["Est LS Start Date DIFFWEEK"] < -5 ? $start_week : ($row["Est LS Start Date DIFFWEEK"] > 25 ? $end_week : $row["Est LS Start Date WEEKNO"])] += ($row["Remaining Hours Stage"]);
        if($row["Est LS Start Date DIFFWEEK"] < 0){
            if($year_overlap_region = 'TY'){
                $pivot_graph_data[$row["Sequence Code"]]['BKLG'][(int)date('W')] += ($row["Remaining Hours Stage"])*0.5;
                $pivot_graph_data[$row["Sequence Code"]]['BKLG'][date('W') + 1 >= $weeks_in_this_year ? 1 : date('W') + 1] += ($row["Remaining Hours Stage"])*0.3;
                $pivot_graph_data[$row["Sequence Code"]]['BKLG'][date('W') + 2 >= $weeks_in_this_year ? 2 : date('W') + 2] += ($row["Remaining Hours Stage"])*0.2;
            }
        }
    }

    // BUFFER VARIABLES
    $pivot_graph_week_demand = array("NC" => array(), "NS" => array(), "RD" => array(), "IP" => array(), "BKLG" => array());

    // TAKES ARRAY FROM ABOVE AND FORMATS IT TO FUSIONCHARTS JSON ARRAY
    foreach($pivot_graph_data as $key => $labour_step){
        
        // RESET BUFFFER
        $pivot_graph_week_demand_buffer = array("NC" => array(), "NS" => array(), "RD" => array(), "IP" => array(), "BKLG" => array());

        // FOR EACH WEEK DEMAND OF EACH PREV STEP STATUS OF EACH PRODUCTION PROCESS
        foreach($labour_step as $status_key => $status){
            foreach($status as $week_no => $remaining_time){
                array_push($pivot_graph_week_demand_buffer[$status_key], array("value" => $remaining_time));
            }
        }

        // INSERT THE REMAINING HOURS AND BACKLOG HOURS PER WEEK ARRAY FOR THIS LABOUR STEP IN PLACE ON THE MAIN PIVOT ARRAY
        $pivot_graph_week_demand2[$key] = array(array("seriesname" => "NS", "color" => "#5D62B5", "data" => $pivot_graph_week_demand_buffer["NS"]),
                                                array("seriesname" => "IP", "color" => "#FACB57", "data" => $pivot_graph_week_demand_buffer["IP"]),
                                                array("seriesname" => "NC", "color" => "#AFD8C5", "data" => $pivot_graph_week_demand_buffer["NC"]),
                                                array("seriesname" => "RD", "color" => "#7cbfa0", "data" => $pivot_graph_week_demand_buffer["RD"]),
                                                array("seriesname" => "BKLG", "color" => "#f08787", "data" => $pivot_graph_week_demand_buffer["BKLG"])
                                                );
    }
    file_put_contents("CACHED/pivot_week_demand2.json", json_encode($pivot_graph_week_demand2));
    file_put_contents("CACHED/data_last_updated.json", json_encode(time()));

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    //          FOR BOOKED HOURS ENTRIES ON EACH STEP                                                 //
    ////////////////////////////////////////////////////////////////////////////////////////////////////

    $logged_entries_json_data = array();
    $logged_entries_data = get_sap_data($conn,$sql_logged_entries,DEFAULT_DATA);

    $current_pr_order = $logged_entries_data[0]["PrOrder"];
    $current_seq_code = $logged_entries_data[0]["LineID"];
    $seq_code_buff = array();
    $pr_order_buff = array();
    $entry_no = 0;
    foreach($logged_entries_data as $row){
        if($current_pr_order != $row["PrOrder"]){
            $pr_order_buff[$current_seq_code] = $seq_code_buff;
            $logged_entries_json_data[$current_pr_order] = $pr_order_buff;
            $pr_order_buff = $seq_code_buff = array();
            $current_seq_code = $row["LineID"];
            $current_pr_order = $row["PrOrder"];
            $entry_no = 1;
        }
        else if($current_seq_code != $row["LineID"]){
            $pr_order_buff[$current_seq_code] = $seq_code_buff;
            $seq_code_buff = array();
            $current_seq_code = $row["LineID"];
            $entry_no = 1;
        }
        
        $seq_code_buff[$entry_no] = array("date" => $row["Date"], "name" => $row["Name"], "booked_qty" => $row["Qty"]);
        $entry_no++;   
    }

    //print_r($logged_entries_json_data);
    file_put_contents("CACHED/booked_hours_details.json", json_encode($logged_entries_json_data));

    
    //////////////////////////////////////////////////////////////////////////////////
    //                         FOR BOOKED STEP REMARKS                             //
    /////////////////////////////////////////////////////////////////////////////////

    $step_remarks_json_data = array();
    $step_remarks_data = get_sap_data($conn,$sql_step_remarks,DEFAULT_DATA);
    
    $current_pr_order = $step_remarks_data[0]["PrOrder"];
    $current_seq_code = $step_remarks_data[0]["U_OldCode"];
    $seq_code_buff = array();
    $pr_order_buff = array();
    $entry_no = 0;
    foreach($step_remarks_data as $row){
        if($current_pr_order != $row["PrOrder"]){
            $pr_order_buff[$current_seq_code] = $seq_code_buff;
            $step_remarks_json_data[$current_pr_order] = $pr_order_buff;
            $pr_order_buff = $seq_code_buff = array();
            $current_seq_code = $row["U_OldCode"];
            $current_pr_order = $row["PrOrder"];
            $entry_no = 1;
        }
        else if($current_seq_code != $row["U_OldCode"]){
            $pr_order_buff[$current_seq_code] = $seq_code_buff;
            $seq_code_buff = array();
            $current_seq_code = $row["U_OldCode"];
            $entry_no = 1;
        }
        
        $seq_code_buff[$entry_no] = array("date" => $row["Date"], "name" => $row["Name"], "sequence" => $row["U_OldCode"], "remarks" => $row["Remarks"]);
        $entry_no++;   
    }
    $pr_order_buff[$current_seq_code] = $seq_code_buff;
    $step_remarks_json_data[$current_pr_order] = $pr_order_buff;

    file_put_contents("CACHED/remarks.json", json_encode($step_remarks_json_data));



    //
    // PRODUCT TABLE
    //

    include '../TABLES/PRODUCT/SQL_product.php'; 

    $product_table = get_sap_data($conn,$tsql,0);
    file_put_contents("../TABLES/PRODUCT/CACHED/production_step_table.json", json_encode($product_table));


    // GET PAGE THE RELOAD WAS CALLED FROM AND REDIRECT TO THAT PAGE
    $group_callback = $_GET['production_group'];
    header("Location:BASE_production_groups.php?production_group=$group_callback");
?>