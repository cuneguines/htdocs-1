<!-- NOTE: IN THE COMMENTS/VARIABLE NAMES, PRODUCTION STAGE/LABOUR STEP CAN BE USED INTERCHANGEABLY BUT THE BOTH MEAN THE SAME THING, ALSO PRODUCTION GROUP OR ANY REFERENCE TO GROUP MEANS A GROUP OF LABOUR STEPS DETAILED IN THE PHP CONSTANTS FILE-->
<!DOCTYPE html>
<html>
    <head>
        <!-- INITALISATION AND META STUFF -->
        <meta charset = "utf-8">
        <title>Kent Stainless</title>
        <meta name = "viewpport" content = "width=device-width, initial-scale = 1">

        <!-- EXTERNAL JAVASCRIPT -->
        <script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
        <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
        <script type = "text/javascript" src = "../../JS/LIBS/jquery-3.4.1.js"></script>

        <!-- LOCAL JAVASCRIPT -->
        <script type = "text/javascript" src = "../../JS/LOCAL/JS_radio_buttons.js"></script>
        <script type = "text/javascript" src = "../../JS/LOCAL/JS_menu_select.js"></script>
        <script type = "text/javascript" src = "../../JS/LIBS/jquery.tablesorter.js"></script>
        <script type = "text/javascript" src = "../../JS/LIBS/jquery.tablesorter.js"></script>
        <script type = "text/javascript" src = "./JS_update_rows.js"></script>
        <script type = "text/javascript" src = "./JS_func.js"></script>
        <script type = "text/javascript">$(document).ready(function() {$.ajaxSetup({ cache: false });});</script>

        <!-- STYLING -->
		<link rel = "stylesheet" href = "../../css/KS_DASH_STYLE.css">
        <link rel = "stylesheet" href = "../../css/theme.blackice.min.css">
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

        <!-- PHP DEPENDANCIES -->
        <?php date_default_timezone_set('Europe/London'); ?>
        <?php include '../../PHP LIBS/PHP FUNCTIONS/php_constants.php'; ?>
        <?php include '../../PHP LIBS/PHP FUNCTIONS/php_function.php';  ?>
        <?php

            // GETNAME OF PRODUCTION GROUP THAT PAGE WILL DETAIL FROM POST (BUTTON PRESS ON MAIN PRODUCTION MENU)
            // USING THIS VAR READ IN THE NAMES OF THE STEPSIN THAT GROUP FROM FILE
            // ALSO PULL IN THE MAIN LABOUR STEP DETAIL
            $production_group = ($_GET['production_group']);          
            $group_steps_template = json_decode(file_get_contents(__DIR__."/CACHED/group_steps_template.json"),true);
            foreach($group_steps_template as $key => $group)
            {
                if($group["name"] == $production_group){
                    $prod_group_steps = $group["steps"];
                    $group_number = $key;
                }
            }
            $prod_group_steps_table = json_decode(file_get_contents(__DIR__."/CACHED/production_step_table.json"),true);

        ?>
        <?php $bkd_hrs_details = json_decode(file_get_contents(__DIR__."./CACHED/booked_hours_details.json"),true); ?>
        <?php $remarks_details = json_decode(file_get_contents(__DIR__."./CACHED/remarks.json"),true); ?>
        <?php $week_range = json_decode(file_get_contents(__DIR__."./CACHED/week_range.json"),true); ?>
        <?php $start_week = $week_range["start_week"]; $end_week = $week_range["end_week"]; ?>

        <?php $step_demand = json_decode(file_get_contents(__DIR__."./CACHED/step_demand.json"),true);?>
        <?php $step_capacity = json_decode(file_get_contents(__DIR__."./CACHED/step_capacity.json"),true);?>



        <!-- CHART SETUP FOR GROUP DEMAND VS CAPACITY-->
        <script type = "text/javascript">
            $(document).ready(function(){
                $.getJSON('./CACHED/group_steps_template.json', function(template)
                {
                    $.getJSON('./CACHED/step_demand.json', function(demand)
                    {
                        $.getJSON('./CACHED/step_capacity.json', function(capacity)
                        {
                            const dataSource = {
                                chart: {
                                    caption: "Demand Vs Capacity",
                                    yaxisname: "Hours",
                                    formatnumberscale: "1",
                                    plottooltext:
                                    "<b>$dataValue</b> <b>$seriesName</b> For $label",
                                    theme: "fusion",
                                    drawcrossline: "1",
                                    legendPosition: "top-middle",
                                    showLegend: "1",
                                    showLabels: "0"
                                },
                                categories: [
                                    {
                                    category: [
                                        {   label: template[<?=$group_number?>]["steps"][1] },
                                        {   label: template[<?=$group_number?>]["steps"][2] },
                                        {   label: template[<?=$group_number?>]["steps"][3] },
                                        {   label: template[<?=$group_number?>]["steps"][4] },
                                        {   label: template[<?=$group_number?>]["steps"][5] },
                                        {   label: template[<?=$group_number?>]["steps"][6] },
                                        {   label: template[<?=$group_number?>]["steps"][7] },
                                        {   label: template[<?=$group_number?>]["steps"][8] }
                                    ]
                                    }
                                ],
                                dataset: [
                                    {
                                        seriesname:"Demand",
                                        data:[
                                            {   value: demand[template[<?=$group_number?>]["steps"][1]],    },
                                            {   value: demand[template[<?=$group_number?>]["steps"][2]],    },
                                            {   value: demand[template[<?=$group_number?>]["steps"][3]],    },
                                            {   value: demand[template[<?=$group_number?>]["steps"][4]],    },
                                            {   value: demand[template[<?=$group_number?>]["steps"][5]],    },
                                            {   value: demand[template[<?=$group_number?>]["steps"][6]],    },
                                            {   value: demand[template[<?=$group_number?>]["steps"][7]],    },
                                            {   value: demand[template[<?=$group_number?>]["steps"][8]],    }
                                        ]
                                    },
                                    {
                                        seriesname:"Working Executed Average",
                                        data:[
                                            {   value: capacity[template[<?=$group_number?>]["steps"][1]],  },
                                            {   value: capacity[template[<?=$group_number?>]["steps"][2]],  },
                                            {   value: capacity[template[<?=$group_number?>]["steps"][3]],  },
                                            {   value: capacity[template[<?=$group_number?>]["steps"][4]],  },
                                            {   value: capacity[template[<?=$group_number?>]["steps"][5]],  },
                                            {   value: capacity[template[<?=$group_number?>]["steps"][6]],  },
                                            {   value: capacity[template[<?=$group_number?>]["steps"][7]],  },
                                            {   value: capacity[template[<?=$group_number?>]["steps"][8]],  }
                                        ]
                                    }
                                ]
                                };

                                FusionCharts.ready(function() {
                                    var myChart = new FusionCharts({
                                        type: "mscolumn2d",
                                        renderAt: "production_groups_bar_chart",
                                        width: "100%",
                                        height: "100%",
                                        dataFormat: "json",
                                        dataSource
                                    }).render();
                                });
                            });
                        })
                    });
                });
        </script>
        <!-- CHART SETUP FOR EACH WEEKLY DEMAND FOR EACH LABOUR STEP IN THE PRODUCTION GROUP -->
        <script type = "text/javascript">
            $(document).ready(function(){
                $.getJSON('./CACHED/group_steps_template.json', function(template)
                {
                    $.getJSON('./CACHED/pivot_week_numbers.json', function(categories)
                    {
                        $.getJSON('./CACHED/step_capacity.json', function(step_capacity)
                        {
                            $.getJSON('./CACHED/pivot_week_demand2.json', function(step_demand)
                            {   
                                // DATA SOURCE IS A FORMATTED JSON ARRAY BUILT BY construct_chart_data THAT TAKES IN THE, STEP SEQUNCE CODE, LIST OF WEEK NUMBERS, THE CHART DATA, AND THE CHART CAPACITY
                                // THE DEMAND AND CAPACITY ARE REFERENCED FROM THIER ASSOCIATED ARRAYS BY THE SEQUENCE CODE OF THE LABOUR STEP
                                const dataSource1 = construct_chart_data(template[<?=$group_number?>]["steps"][1], categories, step_demand[template[<?=$group_number?>]["steps"][1]],step_capacity[template[<?=$group_number?>]["steps"][1]]);
                                const dataSource2 = construct_chart_data(template[<?=$group_number?>]["steps"][2], categories, step_demand[template[<?=$group_number?>]["steps"][2]],step_capacity[template[<?=$group_number?>]["steps"][2]]);   
                                const dataSource3 = construct_chart_data(template[<?=$group_number?>]["steps"][3], categories, step_demand[template[<?=$group_number?>]["steps"][3]],step_capacity[template[<?=$group_number?>]["steps"][3]]);
                                const dataSource4 = construct_chart_data(template[<?=$group_number?>]["steps"][4], categories, step_demand[template[<?=$group_number?>]["steps"][4]],step_capacity[template[<?=$group_number?>]["steps"][4]]);
                                const dataSource5 = construct_chart_data(template[<?=$group_number?>]["steps"][5], categories, step_demand[template[<?=$group_number?>]["steps"][5]],step_capacity[template[<?=$group_number?>]["steps"][5]]);
                                const dataSource6 = construct_chart_data(template[<?=$group_number?>]["steps"][6], categories, step_demand[template[<?=$group_number?>]["steps"][6]],step_capacity[template[<?=$group_number?>]["steps"][6]]);
                                const dataSource7 = construct_chart_data(template[<?=$group_number?>]["steps"][7], categories, step_demand[template[<?=$group_number?>]["steps"][7]],step_capacity[template[<?=$group_number?>]["steps"][7]]);
                                const dataSource8 = construct_chart_data(template[<?=$group_number?>]["steps"][8], categories, step_demand[template[<?=$group_number?>]["steps"][8]],step_capacity[template[<?=$group_number?>]["steps"][8]]);

                                // RENDER EACH CHART USING NUMBER OF STEP IN GROUP AND ITS DATASOURCE
                                FusionCharts.ready(function(){
                                    render_chart(1,dataSource1);
                                    render_chart(2,dataSource2);
                                    render_chart(3,dataSource3);
                                    render_chart(4,dataSource4);
                                    render_chart(5,dataSource5);
                                    render_chart(6,dataSource6);
                                    render_chart(7,dataSource7);
                                    render_chart(8,dataSource8);
                                });
                            });
                        });
                    });
                });
            });
        </script>

        <!-- TABLESORTER DECLERATON WILL OPERATE ON ANY TABLE GIVEN A SORTABLE CLASS -->
        <script>
            $(function(){
                $("table.sortable").tablesorter({
                    "theme" : "blackice",
                    "dateFormat" : "ddmmyyyy",
                    "headers" : {
                    }
                });
            });
        </script>
    </head>
    <body id = "production_step_db">
        <div id = "background">
            <?php foreach($group_steps_template[$group_number]["steps"] as $step){
                $capacity = isset($step_capacity[$step]) ? $step_capacity[$step] : 0;
                $demand = isset($step_demand[$step]) ? $step_demand[$step] : 0;
                $lead_time = $capacity == 0 ? 0 : $demand/$capacity;

                $lead_time_arr[$step] = number_format($lead_time,0);
            };?>
            <div id = "navmenu">
                <div>
                    <p id = "title" id = "title" onclick="location.href='../MAIN MENU/MAIN/MAIN_MENU.php'">Kent Stainless</p>
                </div>
                <nav>
                    <ul id = "dashboard_list">
                        <!-- DEPENDING ON WHAT THE PRODUCTION GROUP IS SELECTED SET THE NAVEBUTTONS ACTIVE/INACTIVE APPROPRIATELY --> <!-- ONCLICK FOR EACH OPTION RECALLS THE PAGE WITH THE RESPECTIVE GROUP AS THE POST VARIABLE -->
                        <?php foreach($group_steps_template as $group) :?>
                        <li id = "<?=$group["name"]?>_option"   class = "dashboard_option <?= $production_group == $group["name"] ? 'activebtn' :'inactivebtn' ?>" onclick="location.href='./BASE_production_groups.php?production_group=<?=$group['name']?>'"><?=$group['stringname']?></li>
                        <?php endforeach;?>
                        <li id = "back_option" class = "dashboard_option <?= $production_group == 'back_option' ? 'activebtn' :'inactivebtn' ?>" onclick="location.href='../MAIN MENU/PRODUCTION SUBMENU/BASE_production_menu.php'" >Back</li>
                    </ul>    
                </nav>
                <div id = "lastupdateholder">
                    <p>Last Updated</p>
                    <p><?php echo date("d-m-Y H:i:s" , json_decode(file_get_contents(__DIR__."/CACHED/data_last_updated.json"),true)); ?><p>
                    <button id = "reload_button" class = "dashboard_option_"><img src = "../../RESOURCES/reload.png" width="100%" height="100%" onclick = "location.href='BASE_SUB_get_data.php?production_group=<?=$production_group?>'"></button> 
                </div>
            </div>
            <!-- CONTENT -->
            <div id = "docs_and_deliverables_menu" class = "submenu">

                <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

                <div class = "white sector top full" style = "width:98%;">
                    <div class = "fill inactive">
                        <div class = "content" style = "height:82%;">
                            <div class = "radio_btn_page production_rbtns fill" id = "production_groups_bar_chart"></div>
                            <div class = "radio_btn_page production_rbtns fill inactive" id = "step_1" style = "display:none;"></div>
                            <div class = "radio_btn_page production_rbtns fill inactive" id = "step_2" style = "display:none;"></div>
                            <div class = "radio_btn_page production_rbtns fill inactive" id = "step_3" style = "display:none;"></div>
                            <div class = "radio_btn_page production_rbtns fill inactive" id = "step_4" style = "display:none;"></div>
                            <div class = "radio_btn_page production_rbtns fill inactive" id = "step_5" style = "display:none;"></div>
                            <div class = "radio_btn_page production_rbtns fill inactive" id = "step_6" style = "display:none;"></div>
                            <div class = "radio_btn_page production_rbtns fill inactive" id = "step_7" style = "display:none;"></div>
                            <div class = "radio_btn_page production_rbtns fill inactive" id = "step_8" style = "display:none;"></div>
                        </div>
                        <!-- CREATE DUMMY BUTTONS UNDER CHART CONTAINING THE NAMES OF THE STEPS IN THE PRODUCTION GROUP (MAX 8) IF NOT ALL STEPS ARE USED "Step Available" IS PRINTED TO BOX -->
                        <div class = "head" style = "height:15%; width:96.5%; margin-left:3.5%;">
                            <button class = "white btext br_green chart_button" id = "step_1" style = "width:7.9%; margin-left:4%;"><?= $prod_group_steps[1] ? constant($prod_group_steps[1])[DEFAULT_STAGE_NAME] : "Step Available";?></button>
                            <button class = "white btext br_green chart_button" id = "step_2" style = "width:7.9%; margin-left:4%;"><?= $prod_group_steps[2] ? constant($prod_group_steps[2])[DEFAULT_STAGE_NAME] : "Step Available";?></button>
                            <button class = "white btext br_green chart_button" id = "step_3" style = "width:7.9%; margin-left:4%;"><?= $prod_group_steps[3] ? constant($prod_group_steps[3])[DEFAULT_STAGE_NAME] : "Step Available";?></button>
                            <button class = "white btext br_green chart_button" id = "step_4" style = "width:7.9%; margin-left:4%;"><?= $prod_group_steps[4] ? constant($prod_group_steps[4])[DEFAULT_STAGE_NAME] : "Step Available";?></button>
                            <button class = "white btext br_green chart_button" id = "step_5" style = "width:7.9%; margin-left:4%;"><?= $prod_group_steps[5] ? constant($prod_group_steps[5])[DEFAULT_STAGE_NAME] : "Step Available";?></button>
                            <button class = "white btext br_green chart_button" id = "step_6" style = "width:7.9%; margin-left:4%;"><?= $prod_group_steps[6] ? constant($prod_group_steps[6])[DEFAULT_STAGE_NAME] : "Step Available";?></button>
                            <button class = "white btext br_green chart_button" id = "step_7" style = "width:7.9%; margin-left:4%;"><?= $prod_group_steps[7] ? constant($prod_group_steps[7])[DEFAULT_STAGE_NAME] : "Step Available";?></button>
                            <button class = "white btext br_green chart_button" id = "step_8" style = "width:7.9%; margin-left:4%;"><?= $prod_group_steps[8] ? constant($prod_group_steps[8])[DEFAULT_STAGE_NAME] : "Step Available";?></button>
                        </div>
                        <div class = "head" style = "position:absolute; height:15%; width:96.5%; margin-left:3.5%; top:74%;">
                            <button class = "white btext smedium" id = "step_1" style = "width:7.9%; margin-left:4%; background:none;"><?= $lead_time_arr[$prod_group_steps[1]]." Wks"?></button>
                            <button class = "white btext smedium" id = "step_2" style = "width:7.9%; margin-left:4%; background:none;"><?= $lead_time_arr[$prod_group_steps[2]]." Wks"?></button>
                            <button class = "white btext smedium" id = "step_3" style = "width:7.9%; margin-left:4%; background:none;"><?= $lead_time_arr[$prod_group_steps[3]]." Wks"?></button>
                            <button class = "white btext smedium" id = "step_4" style = "width:7.9%; margin-left:4%; background:none;"><?= $lead_time_arr[$prod_group_steps[4]]." Wks"?></button>
                            <button class = "white btext smedium" id = "step_5" style = "width:7.9%; margin-left:4%; background:none;"><?= $lead_time_arr[$prod_group_steps[5]]." Wks"?></button>
                            <button class = "white btext smedium" id = "step_6" style = "width:7.9%; margin-left:4%; background:none;"><?= $lead_time_arr[$prod_group_steps[6]]." Wks"?></button>
                            <button class = "white btext smedium" id = "step_7" style = "width:7.9%; margin-left:4%; background:none;"><?= $lead_time_arr[$prod_group_steps[7]]." Wks"?></button>
                            <button class = "white btext smedium" id = "step_8" style = "width:7.9%; margin-left:4%; background:none;"><?= $lead_time_arr[$prod_group_steps[8]]." Wks"?></button>
                        </div>
                    </div>
                </div>

                <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

                <div id = "bottomright" class = "white sector bottom full" style = "width:98%">
                    <div style = "height:95%; position:relative; top:2.5%;">
                        <!--
                            PRINT PRODUCTION TABLE FOR EACH STEP IN THE PRODUCTION GROUP. print_production_step_table TAKES IN THREE ARGS; 
                            THE FULL PRODUCTION TABLE ITSELF, THE LIST OF STEPS IN THE PRODUCTION GROUP, THE INDEX OF THE STEP THE TABLE 
                            IS GOINGTO GENERATE DATA FOR AND WILL PRINT A TABLE FROM THE FULL PRODUCTION STEP TABLE BU ONLY ON THE ONE STEP
                            DEFINED BY SECOND TWO INPUT ARGUMENTS.
                        -->
                        <div class = "radio_btn_page production_rbtns table_cont fill inactive no_scrollbar" id = "step_N">
                            <div class = "content_table_margin_wide">
                                <h1 style = "position:relative; top:45%; margin-left:40%;">NO STEP SELECTED</h1>
                            </div>
                        </div>
                        <div class = "radio_btn_page production_rbtns table_cont fill inactive no_scrollbar" style="overflow-y:scroll"id = "step_1" style = "display:none;">
                            <div class = "content_table_margin_wide">
                                <?php print_production_step_table($prod_group_steps_table, $prod_group_steps, 1, $bkd_hrs_details, $remarks_details); ?>
                            </div>
                        </div>
                        <div class = "radio_btn_page production_rbtns table_cont fill inactive no_scrollbar"style="overflow-y:scroll" id = "step_2" style = "display:none;">
                            <div class = "content_table_margin_wide">
                                <?php print_production_step_table($prod_group_steps_table, $prod_group_steps, 2, $bkd_hrs_details, $remarks_details); ?>
                            </div>
                        </div>
                        <div class = "radio_btn_page production_rbtns table_cont fill inactive no_scrollbar" style="overflow-y:scroll"id = "step_3" style = "display:none;">
                            <div class = "content_table_margin_wide">
                                <?php print_production_step_table($prod_group_steps_table, $prod_group_steps, 3, $bkd_hrs_details, $remarks_details); ?>
                            </div>
                        </div>
                        <div class = "radio_btn_page production_rbtns table_cont fill inactive no_scrollbar" style="overflow-y:scroll"id = "step_4" style = "display:none;">
                            <div class = "content_table_margin_wide">
                                <?php print_production_step_table($prod_group_steps_table, $prod_group_steps, 4, $bkd_hrs_details, $remarks_details); ?>
                            </div>
                        </div>
                        <div class = "radio_btn_page production_rbtns table_cont fill inactive no_scrollbar"style="overflow-y:scroll" id = "step_5" style = "display:none;">
                            <div class = "content_table_margin_wide">
                                <?php print_production_step_table($prod_group_steps_table, $prod_group_steps, 5, $bkd_hrs_details, $remarks_details); ?>
                            </div>
                        </div>
                        <div class = "radio_btn_page production_rbtns table_cont fill inactive no_scrollbar" style="overflow-y:scroll"id = "step_6" style = "display:none;">
                            <div class = "content_table_margin_wide">
                                <?php print_production_step_table($prod_group_steps_table, $prod_group_steps, 6, $bkd_hrs_details, $remarks_details); ?>
                            </div>
                        </div>
                        <div class = "radio_btn_page production_rbtns table_cont fill inactive no_scrollbar" style="overflow-y:scroll"id = "step_7" style = "display:none;">
                            <div class = "content_table_margin_wide">
                                <?php print_production_step_table($prod_group_steps_table, $prod_group_steps, 7, $bkd_hrs_details, $remarks_details); ?>
                            </div>
                        </div>
                        <div class = "radio_btn_page production_rbtns table_cont fill inactive no_scrollbar" style="overflow-y:scroll"id = "step_8" style = "display:none;">
                            <div class = "content_table_margin_wide">
                                <?php print_production_step_table($prod_group_steps_table, $prod_group_steps, 8, $bkd_hrs_details, $remarks_details); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

                <div id = "bottom_banner" class = "white sector banner fullwidth">
                    <button id = "go_to_google_sheets"          class = "search_option_button banner_button yellow br_yellow">EXTRA PRODUCTION SHEETS</button>
                    <button id = "search_docno"                 class = "search_option_button banner_button green br_green">SEARCH PRO/SALES OERDER</button>
                    <button id = "multiselect_customer"         class = "search_option_button banner_button red br_red">SELECT CUSTOMERS</button>
                    <button id = "multiselect_project"          class = "search_option_button banner_button yellow br_yellow">SELECT PROJECT</button>
                    <button id = "export"                       class = "banner_button red br_red" onclick = "$('document').ready(function(){export_production_table_to_excel($('.radio_btn_page.active table').attr('id'))});">TEMP EXPORT</button>

                    <div id = "go_to_google_sheets" class = "search_option_field white" style = "opacity:1; height:100%; width:38%; position:absolute; bottom:110%; left:1%; z-index:+4; border-radius:20px; border:4px solid #FACB57; display:none;">
                        <div style = "height:80%; position:relative; top:10%; text-align:center;">
                            <button class = "rounded green medium wtext" style = "height:100%; display:inline-block; width:30%;" onclick = "location.href='https://docs.google.com/spreadsheets/d/1oVAMMIc7q6JP9d1svp8Jo_FYQMbcO2QRXv3IJQaTud4/edit#gid=314860047'">Laser Schedule</button>
                            <button class = "rounded green medium wtext" style = "height:100%; display:inline-block; width:30%;margin-left:20px;" onclick = "location.href='https://docs.google.com/spreadsheets/d/1oVAMMIc7q6JP9d1svp8Jo_FYQMbcO2QRXv3IJQaTud4/edit#gid=868141021'">Intel Material Stock</button>
                        </div>
                    </div>

                    <div id = "search_docno" class = "search_option_field white" style = "opacity:1; height:100%; width:38%; position:absolute; bottom:110%; left:21%; z-index:+4; border-radius:20px; border:4px solid #7cbfa0; display:none;">
                        <p style = "float:left; height:60%; position:relative; top:35%; left:5%; font-size:2vh; margin:0;">Search Pro/Sales Order</p>
                        <input type = "text" placeholder = "Document Number" style = "float:left; height:60%; width:55%; position:relative; top:16%; left:10%; padding-left:10px;" class = "search_docno medium">
                    </div>

                    <div id = "multiselect_customer" class = "search_option_field white" style = "opacity:1; height:700%; width:25%; position:absolute; bottom:110%; left:41%; z-index:+4; border-radius:25px; border:5px solid #f08787; overflow-y:scroll; display:none;">
                        <table style = "width:100%;" class = "rh_small">
                            <?php generate_multiselect_filter_options($prod_group_steps_table, "Customer");?>
                        </table>
                    </div>

                    <div id = "multiselect_project" class = "search_option_field white" style = "opacity:1; height:700%; width:25%; position:absolute; bottom:110%; left:61%; z-index:+4; border-radius:25px; border:5px solid #FACB57; overflow-y:scroll; display:none;">
                        <table style = "width:100%;" class = "rh_small">
                            <?php generate_multiselect_filter_options($prod_group_steps_table, "Project");?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>