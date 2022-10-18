<?php  
    include 'php_constants.php';
    function array_sort($array){sort($array); return $array;}

    function generate_filter_options($table, $field){
        foreach(array_sort(array_unique(array_column($table, $field))) as $element){
            echo "<option value = '".str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $element))."'>".($element)."</option>";
        }
    }

    function integer_seconds_to_duration($seconds){
        return floor($seconds/3600).":".((round(round($seconds % 3600)/60)) < 10 ? "0".(round(round($seconds % 3600)/60)) : (round(round($seconds % 3600)/60)));
    }
    function duration_to_integer_seconds($duration){
        return (int)substr($duration,0,2)*3600 + (int)substr($duration,3,5)*60;
    }

    // FOR SCHEDULE PAGES //
    // FILL SCHEDULE TABLE ROW GIVEN BUTTON BUFFER
    function print_values_2(array $data, $start_range, $end_range){
        $date = new DateTime();
        $week = $date->format("W");
        if($week == 53){
            $week = 52;
        }
        // HOW MANY WEEKS AHEAD OF THE CURRENT DATE THE BACKGROUND COLORS SHOULD EXTEND ON SCHEDULE
        $red = 4;       // 0 - 4
        $orange = 8;    // 4 - 8
        $green = 11;    // 8 - 11
        $concept = 15;    // 15

        for($j = $start_range-1 ; $j <= $end_range + 3; $j++){
            // READS FROM PROJECT_BUTTON_BUFFER
            $str_t = $data[$j];

            // PRINTS PROJECT JOB BUTTON DATA IN PLACE TO HTML
            if($j >= 0 && $j <= $red){
                echo "<td class = 'small' style = 'background-color:#ff9595'>".$str_t."</td>";
            }
            elseif($j >= 0 && $j <= $orange){
                echo "<td class = 'small' style = 'background-color:#ffc795'>".$str_t."</td>";
            }
            elseif($j >= 0 && $j <= $green){
                echo "<td class = 'small' style = 'background-color:#97ff95'>".$str_t."</td>";
            }
            else if($j == $concept){
                echo "<td class = 'small' style = 'border-right:2px solid #454545;'>".$str_t."</td>";
            }
            else{
                echo "<td  class = 'small'>".$str_t."</td>";
            }
        }
    }




    function print_values_22(array $data, $start_range, $end_range){
        $days = array(
            0 => 'Sun',
            1 => 'Mon',
            2 => 'Tue',
            3 => 'Wed',
            4 => 'Thur',
            5 => 'Fri',
            6 => 'Sat');
        
        $date = new DateTime();
        $week = $date->format("W");
        if($week == 53){
            $week = 52;
        }
        // HOW MANY WEEKS AHEAD OF THE CURRENT DATE THE BACKGROUND COLORS SHOULD EXTEND ON SCHEDULE
        $red = 4;       // 0 - 4
        $orange = 8;    // 4 - 8
        $green = 13;    // 8 - 11
        $concept = 15;   
       
        
        for($j = $start_range-3 ; $j <= $end_range ; $j++){
            // READS FROM PROJECT_BUTTON_BUFFER
            $str_t = $data[$j];
            if($j ==-1||$j ==-2||$j ==-3)
                
                echo "<td class = 'small' style = 'border: 1px dotted black;background-color:#f4433694'>".$str_t."</td>";
            
            else
            // PRINTS PROJECT JOB BUTTON DATA IN PLACE TO HTML
            if($j >= 0 && $j <= $green)
            {
                if($days[(date("w")+$j) %7]=='Sun'||$days[(date("w")+$j) %7]=='Sat')
                
                    echo "<td class = 'small' style = 'border: 1px dotted black;background-color:#25ac9975'>".$str_t."</td>";
                   
                    else
                  echo "<td class = 'small' style = 'border: 1px dotted black;background-color:#ffeb3bb3'>".$str_t."</td>";
                
            }
          /* elseif($j >= 0 && $j <= $orange){
                echo "<td class = 'small' style = 'background-color:#ffc795'>".$str_t."</td>";
            }
            elseif($j >= 0 && $j <= $green){
                echo "<td class = 'small' style = 'background-color:#97ff95'>".$str_t."</td>";
            }
            else if($j == $concept){
                echo "<td class = 'small' style = 'border-right:2px solid #454545;'>".$str_t."</td>";
            }  */
            else{
                echo "<td  class = 'small'>".$str_t."</td>";
            }
        } 
    }
    // FOR SCEDHULE PAGES //
    // GIVEN ALL BUTON DETAILS CREATES THE BUTTON AS A STRING FOR PRINTING //
    function generate_schedule_button($base_color, $border_color, $overwrite, $sales_order, $process_order, $floor_date, $weeks_on_floor, $customer, $engineer, $engineer_nsp, $sales_person, $description, $promise_date, $promise_week_due, $est_fab_hrs, $status, $stage, $comments, $comments_2, $qty, $days_open, $week_opened, $weeks_open, $planned_hrs,$est_prod_hrs){
        $str = 
        "<button id = 'eng_btn'
            style = 'margin-bottom:3px;' 
            class = 'rounded project_item $base_color $border_color $overwrite' 
            sales_order = '$sales_order'
            process_order = '$process_order'
            floor_date = '$floor_date'
            weeks_on_floor = '$weeks_on_floor'
            customer = '$customer'
            engineer = '$engineer'
            engineer_nsp = '$engineer_nsp'
            sales_person = '$sales_person' 
            description = '$description'
            promise_date = '$promise_date'
            promise_week_due = '$promise_week_due'
            
            est_fab_hrs = '$est_fab_hrs'
            status = '$status'
            stage = '$stage'
            comments = '".$comments."'
            comments_2 = '".$comments_2."'
            qty = '$qty'
            days_open = '$days_open'
            week_opened = '$week_opened'
            weeks_open = '$weeks_open'
            planned_hrs = '$planned_hrs'
            
        >$est_prod_hrs
        </button>";

        return $str;
    }





    function generate_schedule_buttonsss($border_color_for_date,$color,$base_color, $border_color, $overwrite, $sales_order, $color_for_date,$process_order, $floor_date, $weeks_on_floor, $customer, $engineer, $engineer_nsp, $sales_person, $description, $promise_date, $promise_week_due, $est_fab_hrs, $status, $stage, $comments, $comments_2, $qty, $days_open, $week_opened, $weeks_open, $planned_hrs,$est_prod_hrs,$days_week,$lthree_days,$lfive_days){
       
        $str = 
        "<button id = 'eng_btn'
            style = 'margin-bottom:3px ;'
            class = 'rounded project_item $base_color $border_color $overwrite' 
            border_color_date='$border_color_for_date'
            color_for_date='$color_for_date'
            sales_order = '$sales_order'
            process_order = '$process_order'
            floor_date = '$floor_date'
            weeks_on_floor = '$weeks_on_floor'
            customer = '$customer'
            engineer = '$engineer'
            
            engineer_nsp = '$engineer_nsp'
            sales_person = '$sales_person' 
            description = '$description'
            promise_date = '$promise_date'
            promise_week_due = '$promise_week_due'
            
            est_fab_hrs = '$est_fab_hrs'
            status = '$status'
            stage = '$stage'
            comments = '".$comments."'
            comments_2 = '".$comments_2."'
            qty = '$qty'
            days_open = '$days_open'
            week_opened = '$week_opened'
            weeks_open = '$weeks_open'
            planned_hrs = '$planned_hrs'
            days_week='$days_week'
            lastthreedays='$lthree_days'
            lastfivedays='$lfive_days'
        >$est_prod_hrs
        </button>";

        return $str;
    }
    


    function generate_cache_dir_prefix($depth){
        if($depth == 0){return '.';}
        
        $str = "..";
        for($i = 1 ; $i < $depth ; $i++){
            $str .= '/..';
        }
        return $str;
    }
?>

<?php
    // ACCEPS A DATABSE CONNECTION, QUERY AND RETURN TYPE AND RETURNS DATA ACCORDING TO RETURN TYPE  
    function get_sap_data($connection, $sql_query, $rtype){
        $getResults = $connection->prepare($sql_query);                                  
        $getResults->execute();

        switch ($rtype){
            case 0: return $getResults->fetchAll(PDO::FETCH_BOTH);
            case 1: return $getResults->fetchAll(PDO::FETCH_NUM)[0][0];
            case 2: return $getResults->fetchAll(PDO::FETCH_ASSOC)[0];
        }
    }
?>