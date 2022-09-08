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

        <?php include '../../../../PHP LIBS/PHP FUNCTIONS/php_functions.php';?>
        <?php include '../../../../SQL CONNECTIONS/conn.php'; ?>
        <?php include './SQL_production_schedule.php'; ?>
        <?php $results = get_sap_data($conn, $tsql, DEFAULT_DATA);?>
        <?php
    function generate_multiselect_filter_options($table, $field)
    {
        echo "<tr class = 'btext' style = 'border:none;'><td width = '90%' class = 'lefttext'>All</td><td width = '10%'><label class='container fill' style = 'margin-bottom:25px;'><input class = 'multiselector_checkbox checked' type='checkbox' name = 'check_list[]' value='All'><span class='checkmark'><div></div></span></label></td></tr>";
        foreach (array_sort(array_unique(array_column($table, $field))) as $element) {
            echo "<tr class = 'btext' style = 'border:none;'><td width = '90%' class = 'lefttext'>$element</td><td width = '10%'><label class='container fill' style = 'margin-bottom:25px;'><input class = 'multiselector_checkbox checked' type='checkbox' name = 'check_list[]' value='" . str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $element)) . "'><span class='checkmark'><div></div></span></label></td></tr>";
        }
    }
    ?>
        
    </head>
    <style>
        .box {

            width: 15%;
            height: 15%;
            border: 1px solid rgba(0, 0, 0, .2);
        }

        #button_containers {
            float: left;
            width: 10%;
            height: 100%;
        }

        .footer #grouping_pages_footer #filter_containers {
            width: 80%;
            margin-left: 2%;
            margin-right: 2%;
        }

        .filter widers {
            width: 20%;

        }

        .filter {
            float: left;
        }

        .checkmark {
            position: relative;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #eee;
        }

        .fill {
            height: 100%;
            width: 100%;
        }

        /* When the checkbox is checked, add a blue background */
        .container input.checked~.checkmark {
            background-color: #2196F3;
        }

        /* Create the checkmark/indicator (hidden when not checked) */

        /* Show the checkmark when checked */
        .container input.checked~.checkmark {
            display: block;
        }

        /* Style the checkmark/indicator */
        .container input.checked~.checkmark div {
            position: relative;
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);

        }

        .container {
            display: block;
            position: relative;
            padding-left: 0px;
            margin-bottom: 15px;
            cursor: pointer;
            font-size: 22px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default checkbox */
        .container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        /* Create a custom checkbox */
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #eee;
        }

        /* On mouse-over, add a grey background color */
        .container:hover input~.checkmark {
            background-color: #ccc;
        }

        /*/////////////////////////////////////////////////////////////////////////*/
        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            margin-left: 0%;
            margin-top: 0%;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            /* Safari */
            animation: spin 2s linear infinite;
        }

        .search_option_button:hover {
            background-color: rgb(240, 135, 135);
            ;
            color: #000000;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .grouping_category {
            float: left;
        }

        /*/////////////////////////////////////////////////////////////////////////*/
    </style>
    <body>
        <div id = "background">
            <div id = "content">
                <div id = "sched_left">
                    <div style = "width:94%;position:relative; left:0; top:2%; margin-bottom:4%;" class = "btext rounded brgreen white">
                        <p class = "smedium">Sales Order</p>
                        <h2 class = "inner first medium">Nothing Selected</h2>
                        <br>
                        <p class = "smedium">Process Order</p>
                        <h2 class = "inner thirteenth medium">Nothing Selected</h2>
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
                        <h1>PRODUCTION SCHEDULE</h1>
                    </div>
                    <div id = "pages_schedule_container" class = "table_container" style = "overflow-y:scroll">
                        <table id = "production_schedule" class = "filterable searchable">
                            <thead>
                                <tr class = "dark_grey wtext smedium">
                                    <th style = "width:14%">Project</th>
                                    <th style = 'width:3%;'><<<</th>
                                    <?php for($i = $start_range ; $i <= $end_range ; $i++) : ?>
                                        <th style = 'width:<?=(string)(74/($end_range+(-$start_range)))?>%; <?=($i == 0 ? 'background-color:red;' : "")?>'><?=idate('W',time()+(60*60*24*7*$i))?></th>
                                    <?php endfor; ?>
                                    <th style = 'width:3%;'><?=idate('W',time()+(60*60*24*7*($end_range+1)))."-".idate('W',time()+(60*60*24*7*($end_range+12)))?></th>
                                    <th style = 'width:3%;'><?=idate('W',time()+(60*60*24*7*($end_range+13)))."-".idate('W',time()+(60*60*24*7*($end_range+25)))?></th>
                                    <th style = 'width:3%;'>>>></th>
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
        
                                            // PRINT BREAKDOWN ROW WITH BUTTONS FROM BUFFER OF ACTIVE PROJECT
                                            echo "<tr class = 'row white smedium' productgp = '".$productgp."'customer = '".$customer."' project = '".$project."' engineers = '".$engineers_str."' sales_person = '".$sales_person."' promise_week_due = '".$promise_week_due."' type =  breakdown>";
                                                echo "<td style = 'border-right:1px solid #454545;'>".$customer_unp."<br><br>".$project_unp."</td>";
                                                print_values_2($project_button_buffer,$start_range,$end_range);
                                            echo"</tr>";
                                            // PRINT SUM ROW WITH SUM ARRAY FOR CURRENT ACTIVE PROJECT
                                            echo "<tr class = 'row smedium' style = 'background-color:#DCDCDC;' type = 'data' customer = '".$customer."' engineers = '".$engineers_str."' project = '".$project."' sales_person = '".$sales_person."'><td style = 'background-color:#454545;color:white;'>".$project_unp."</td>";
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
                                            $project_button_buffer = $sum = array_fill(($start_range - 1), ($end_range + (-$start_range) + 2 + 3),NULL);
                                            $engineers_str = "";
        
                                            $customer = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Project"] == '000_NO PROJECT_000' ? '000_NO_PROJECT_000' : $results[$i]["Customer"]));
                                            $project = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Project"]));
                                            $engineer = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Engineer"]));
                                            $sales_person = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Sales Person"]));
                                            $productgp = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Product Group"]));
                                            
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
                                        $str = generate_schedule_button($base_color,
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
                                            $results[$i]["Est Prod Hrs"] < 0 ? 0 : $results[$i]["Est Prod Hrs"] 
                                        );
        
                                        if(!in_array(str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Engineer"])), $project_engineers_buffer))
                                        {
                                            array_push($project_engineers_buffer, str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $results[$i]["Engineer"])));
                                        }
        
                                        $project_button_buffer[$results[$i]["Promise Diff Week"]] = $project_button_buffer[$results[$i]["Promise Diff Week"]].$str;
                                        $sum[$results[$i]["Promise Diff Week"]] = $sum[$results[$i]["Promise Diff Week"]] + $results[$i]["Est Prod Hrs"];                                                    
                                        
                                        $base_color = "";
                                        $border_color = "";
                                        $overwrite = "";  
                                    ?>
                                <?php endfor; ?>
                            </tbody>
                            <tfoot style = "position:sticky; bottom: 0; z-index:+1;">
                                <tr class = "light_grey btext small" role = "row">
                                    <td aggregateable = 'Y' operation = 'COUNT'>        </td>
                                    <td aggregateable = 'Y' operation = 'SUM'>        </td>
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
                                            <button class = "fill red medium wtext">Sales Person</button>
                                        </div>
                                        <div class = "content">
                                            <select id = "select_sales_person" class = "selector fill medium">
                                                <option value = "All" selected>All</option>
                                                <?php generate_filter_options($results,"Sales Person"); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class = "filter"style="display:none">
                                        <div class = "text">
                                            <button class = "fill red medium wtext">ProductGroup</button>
                                        </div>
                                        <div class = "content">
                                            <select id = "select_productgp" class = "selector fill medium">
                                                <option value = "All" selected>All</option>
                                                <?php //generate_filter_options($results,"Product Group"); ?>
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="filter widers">
                                       <div class="text" style="width:70%">
                                          <button class="search_option_button fill white medium rtext" id="multiselect_engineer" style="width:100%;border-radius: 12px;">SELECT ENGINEERS</button>
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
                    <div id="multiselect_engineer" class="search_option_field white" style="opacity:1; height:50%; width:20%; position:relative; bottom:38%; left:72%; z-index:+4; border-radius:25px; border:5px solid #f08787; overflow-y:scroll; display:none;">
                        <table style="width:100%;" class="rh_small">
                    <?php generate_multiselect_filter_options($results, "Engineer"); ?>
                </div>
            </div>
        </div>
    </body>
</html>