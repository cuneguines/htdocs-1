<!DOCTYPE html>
<html>

<head>
    <!-- INITALISATION AND META STUFF -->
    <title>Kent Stainless</title>
    <meta charset="utf-8">
    <meta name="viewpport" content="width=device-width, initial-scale = 1">

    <!-- EXTERNAL JAVASCRIPT -->
    <script type="text/javascript" src="../../../JS/LIBS/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="../../../JS/LIBS/canvasjs.min.js"></script>
    <script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <script type="text/javascript"
        src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            cache: false
        });
    });
    </script>

    <!-- LOCAL JAVASCRIPT -->
    <script type="text/javascript" src="../../../JS/LOCAL/JS_menu_select.js"></script>
    <script type="text/javascript" src="../../../JS/LOCAL/JS_radio_buttons.js"></script>
    <script type="text/javascript" src="./show_table.js"></script>

    <!-- STYLING -->
    <link rel="stylesheet" href="../../../css/KS_DASH_STYLE.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <script>
    function if_undefined(number) {
        if (typeof number === 'undefined') {
            return 0;
        } else {
            return number;
        }
    }
    </script>

    <!-- PHP DEPENDANCIES -->
    <?php date_default_timezone_set('Europe/London'); ?>

    <!-- GET CACHED DATA -->
    <?php   $released_today_list = json_decode(file_get_contents(__DIR__.'\CACHED\released_today_list.json'),true);          ?>
    <?php   $released_yesterday_list = json_decode(file_get_contents(__DIR__.'\CACHED\released_yesterday_list.json'),true);  ?>
    <?php   $complete_today_list = json_decode(file_get_contents(__DIR__.'\CACHED\complete_today_list.json'),true);          ?>
    <?php   $complete_yesterday_list = json_decode(file_get_contents(__DIR__.'\CACHED\complete_yesterday_list.json'),true);  ?>
    <?php   $headline_figures = json_decode(file_get_contents(__DIR__.'\CACHED\headline_figures.json'),true);  ?>
    <?php   $open_hours_on_floor_details_data = json_decode(file_get_contents(__DIR__.'\CACHED\open_hours_on_floor_details_data.json'),true);  ?>
    <style>
    /* Modal styles - adjust as needed */
    /* Modal styles - adjust as needed */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1000;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.5);
        /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        /* Center modal on screen */
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        max-height: 70%;
        /* Set maximum height for modal */
        overflow: auto;
        /* Enable vertical scrolling if content exceeds height */
    }

    /* Close Button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Table Styling */
    #modalTable {
        width: 100%;
        border-collapse: collapse;
    }

    #modalTable th,
    #modalTable td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    /* Header Styles */
    #modalTable th {
        background-color: #7cbfa0;
        /* Green */
        color: white;
        font-weight: bold;
    }

    /* Fixed Header */
    #modalTable thead {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    /* Scrollable Body */
    #modalTable tbody {
        display: block;
        height: 300px;
        /* Adjust as needed */
        overflow-y: scroll;
        width: 100%;

    }

    /* Even and Odd Row Coloring */
    #modalTable tbody tr:nth-child(even) {
        background-color: #f2f2f2;
        padding: 3px;
    }

    #modalTable tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }

    /* Specific Row Coloring */
    #modalTable tbody tr.special-row {
        background-color: #FFD700;
        /* Yellow */
    }
/* Table Styling */
#modalTable_1 { /* Ensure the ID matches your HTML */
    width: 100%;
    border-collapse: collapse;
}

#modalTable_1 th,
#modalTable_1 td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

/* Header Styles */
#modalTable_1 th {
    background-color: #7cbfa0; /* Green */
    color: white;
    font-weight: bold;
}

/* Fixed Header */
#modalTable_1 thead {
    display: table;
    width: 100%;
    table-layout: fixed;
}

/* Scrollable Body */
#modalTable_1 tbody {
    display: block;
    height: 300px; /* Adjust as needed */
    overflow-y: scroll;
    width: 100%;
}

/* Even and Odd Row Coloring */
#modalTable_1 tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

#modalTable_1 tbody tr:nth-child(odd) {
    background-color: #ffffff;
}

/* Specific Row Coloring */
#modalTable_1 tbody tr.special-row {
    background-color: #FFD700; /* Yellow */
}
    .banner_button_ {
        float: left;
        margin-left: 1%;
        margin-right: 1%;
        color: white;
        font-size: 2vh;
        position: relative;
        top: 10%;
        height: 80%;
        width: 18%;
        border-radius: 20px;
        border: 5px solid #FACB57;
        background-color: #FACB57;
    }
    </style>
    <!-- CHARTS SETUP -->
    <script type="text/javascript">
    $(document).ready(function() {
        $.getJSON('../../PRODUCTION/CACHED/group_steps_template.json', function(steps_template) {
            $.getJSON('../../PRODUCTION/CACHED/step_capacity.json', function(capacity) {
                $.getJSON('../../PRODUCTION/CACHED/step_demand.json', function(demand) {
                    console.log(Number(if_undefined(demand[steps_template[2].steps[
                        3]])));
                    //console.log(capacity);
                    //console.log(steps_template[2].steps[2]);
                    const dataSource = {
                        chart: {
                            caption: "Total Production Demand Vs Operating Weekly Average",
                            yaxisname: "Hours",
                            formatnumberscale: "1",
                            plottooltext: "<b>$dataValue</b> <b>$seriesName</b> For $label",
                            theme: "fusion",
                            drawcrossline: "1",
                            legendPosition: "top-middle",
                            showLegend: "1",
                            showLabels: "0"
                        },
                        categories: [{
                            category: [{
                                    label: steps_template[1].name
                                },
                                {
                                    label: steps_template[2].name
                                },
                                {
                                    label: steps_template[3].name
                                },
                                {
                                    label: steps_template[4].name
                                },
                                {
                                    label: steps_template[5].name
                                },
                                {
                                    label: steps_template[6].name
                                }
                            ]
                        }],
                        dataset: [{
                                seriesname: "Total Demand",
                                color: "#7cbfa0",
                                data: [{
                                        value: Number(if_undefined(demand[
                                                steps_template[1]
                                                .steps[1]])) +
                                            Number(if_undefined(demand[
                                                steps_template[1]
                                                .steps[2]])) +
                                            Number(if_undefined(demand[
                                                steps_template[1]
                                                .steps[3]])) +
                                            Number(if_undefined(demand[
                                                steps_template[1]
                                                .steps[4]])) +
                                            Number(if_undefined(demand[
                                                steps_template[1]
                                                .steps[5]])) +
                                            Number(if_undefined(demand[
                                                steps_template[1]
                                                .steps[6]])) +
                                            Number(if_undefined(demand[
                                                steps_template[1]
                                                .steps[7]])) +
                                            Number(if_undefined(demand[
                                                steps_template[1]
                                                .steps[8]])),
                                    },
                                    {
                                        value: Number(if_undefined(demand[
                                                steps_template[2]
                                                .steps[2]])) +
                                            Number(if_undefined(demand[
                                                steps_template[2]
                                                .steps[2]])) +
                                            Number(if_undefined(demand[
                                                steps_template[2]
                                                .steps[3]])) +
                                            Number(if_undefined(demand[
                                                steps_template[2]
                                                .steps[4]])) +
                                            Number(if_undefined(demand[
                                                steps_template[2]
                                                .steps[5]])) +
                                            Number(if_undefined(demand[
                                                steps_template[2]
                                                .steps[6]])) +
                                            Number(if_undefined(demand[
                                                steps_template[2]
                                                .steps[7]])) +
                                            Number(if_undefined(demand[
                                                steps_template[2]
                                                .steps[8]])),
                                    },
                                    {
                                        value: Number(if_undefined(demand[
                                                steps_template[3]
                                                .steps[1]])) +
                                            Number(if_undefined(demand[
                                                steps_template[3]
                                                .steps[2]])) +
                                            Number(if_undefined(demand[
                                                steps_template[3]
                                                .steps[3]])) +
                                            Number(if_undefined(demand[
                                                steps_template[3]
                                                .steps[4]])) +
                                            Number(if_undefined(demand[
                                                steps_template[3]
                                                .steps[5]])) +
                                            Number(if_undefined(demand[
                                                steps_template[3]
                                                .steps[6]])) +
                                            Number(if_undefined(demand[
                                                steps_template[3]
                                                .steps[7]])) +
                                            Number(if_undefined(demand[
                                                steps_template[3]
                                                .steps[8]])),
                                    },
                                    {
                                        value: Number(if_undefined(demand[
                                                steps_template[4]
                                                .steps[1]])) +
                                            Number(if_undefined(demand[
                                                steps_template[4]
                                                .steps[2]])) +
                                            Number(if_undefined(demand[
                                                steps_template[4]
                                                .steps[3]])) +
                                            Number(if_undefined(demand[
                                                steps_template[4]
                                                .steps[4]])) +
                                            Number(if_undefined(demand[
                                                steps_template[4]
                                                .steps[5]])) +
                                            Number(if_undefined(demand[
                                                steps_template[4]
                                                .steps[6]])) +
                                            Number(if_undefined(demand[
                                                steps_template[4]
                                                .steps[7]])) +
                                            Number(if_undefined(demand[
                                                steps_template[4]
                                                .steps[8]])),
                                    },
                                    {
                                        value: Number(if_undefined(demand[
                                                steps_template[5]
                                                .steps[1]])) +
                                            Number(if_undefined(demand[
                                                steps_template[5]
                                                .steps[2]])) +
                                            Number(if_undefined(demand[
                                                steps_template[5]
                                                .steps[3]])) +
                                            Number(if_undefined(demand[
                                                steps_template[5]
                                                .steps[4]])) +
                                            Number(if_undefined(demand[
                                                steps_template[5]
                                                .steps[5]])) +
                                            Number(if_undefined(demand[
                                                steps_template[5]
                                                .steps[6]])) +
                                            Number(if_undefined(demand[
                                                steps_template[5]
                                                .steps[7]])) +
                                            Number(if_undefined(demand[
                                                steps_template[5]
                                                .steps[8]])),
                                    },
                                    {
                                        value: Number(if_undefined(demand[
                                                steps_template[6]
                                                .steps[1]])) +
                                            Number(if_undefined(demand[
                                                steps_template[6]
                                                .steps[2]])) +
                                            Number(if_undefined(demand[
                                                steps_template[6]
                                                .steps[3]])) +
                                            Number(if_undefined(demand[
                                                steps_template[6]
                                                .steps[4]])) +
                                            Number(if_undefined(demand[
                                                steps_template[6]
                                                .steps[5]])) +
                                            Number(if_undefined(demand[
                                                steps_template[6]
                                                .steps[6]])) +
                                            Number(if_undefined(demand[
                                                steps_template[6]
                                                .steps[7]])) +
                                            Number(if_undefined(demand[
                                                steps_template[6]
                                                .steps[8]])),
                                    }
                                ]
                            },
                            {
                                seriesname: "Operating Weekly Average",
                                color: "#f08787",
                                data: [{
                                        value: Number(if_undefined(capacity[
                                                steps_template[1]
                                                .steps[1]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[1]
                                                .steps[2]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[1]
                                                .steps[3]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[1]
                                                .steps[4]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[1]
                                                .steps[5]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[1]
                                                .steps[6]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[1]
                                                .steps[7]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[1]
                                                .steps[8]])),
                                    },
                                    {
                                        value: Number(if_undefined(capacity[
                                                steps_template[2]
                                                .steps[2]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[2]
                                                .steps[2]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[2]
                                                .steps[3]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[2]
                                                .steps[4]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[2]
                                                .steps[5]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[2]
                                                .steps[6]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[2]
                                                .steps[7]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[2]
                                                .steps[8]])),
                                    },
                                    {
                                        value: Number(if_undefined(capacity[
                                                steps_template[3]
                                                .steps[1]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[3]
                                                .steps[2]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[3]
                                                .steps[3]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[3]
                                                .steps[4]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[3]
                                                .steps[5]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[3]
                                                .steps[6]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[3]
                                                .steps[7]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[3]
                                                .steps[8]])),
                                    },
                                    {
                                        value: Number(if_undefined(capacity[
                                                steps_template[4]
                                                .steps[1]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[4]
                                                .steps[2]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[4]
                                                .steps[3]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[4]
                                                .steps[4]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[4]
                                                .steps[5]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[4]
                                                .steps[6]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[4]
                                                .steps[7]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[4]
                                                .steps[8]])),
                                    },
                                    {
                                        value: Number(if_undefined(capacity[
                                                steps_template[5]
                                                .steps[1]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[5]
                                                .steps[2]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[5]
                                                .steps[3]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[5]
                                                .steps[4]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[5]
                                                .steps[5]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[5]
                                                .steps[6]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[5]
                                                .steps[7]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[5]
                                                .steps[8]])),
                                    },
                                    {
                                        value: Number(if_undefined(capacity[
                                                steps_template[6]
                                                .steps[1]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[6]
                                                .steps[2]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[6]
                                                .steps[3]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[6]
                                                .steps[4]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[6]
                                                .steps[5]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[6]
                                                .steps[6]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[6]
                                                .steps[7]])) +
                                            Number(if_undefined(capacity[
                                                steps_template[6]
                                                .steps[8]])),
                                    }
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
            });
        });
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $.getJSON('./CACHED/one_year_graph_data.json', function(data_d) {
            $.getJSON('./CACHED/one_year_graph_weeks.json', function(weeks) {
                const dataSource = {
                    chart: {
                        drawAnchors: "0",
                        yaxisname: "Hours",
                        numdivlines: "3",
                        showvalues: "0",
                        legenditemfontsize: "15",
                        legenditemfontbold: "1",
                        theme: "fusion",
                        lineThickness: "2",
                        drawFullAreaBorder: "0",
                        plotFillColor: "#DBDBDB",

                    },
                    categories: [{
                        category: weeks
                    }],
                    dataset: data_d

                };

                FusionCharts.ready(function() {
                    var myChart = new FusionCharts({
                        type: "mscombi2d",
                        renderAt: "demand_vs_capacity_one_y",
                        width: "100%",
                        height: "100%",
                        dataFormat: "json",
                        dataSource
                    }).render();
                });
            });
        });
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $.getJSON('./CACHED/two_year_graph_data.json', function(data_d) {
            $.getJSON('./CACHED/two_year_graph_weeks.json', function(weeks) {
                const dataSource = {
                    chart: {
                        drawAnchors: "0",
                        yaxisname: "Hours",
                        numdivlines: "3",
                        showvalues: "0",
                        legenditemfontsize: "15",
                        legenditemfontbold: "1",
                        theme: "fusion",
                        lineThickness: "2",
                        drawFullAreaBorder: "0",
                        plotFillColor: "#DBDBDB"
                    },
                    categories: [{
                        category: weeks
                    }],
                    dataset: data_d

                };

                FusionCharts.ready(function() {
                    var myChart = new FusionCharts({
                        type: "mscombi2d",
                        renderAt: "demand_vs_capacity_two_y",
                        width: "100%",
                        height: "100%",
                        dataFormat: "json",
                        dataSource
                    }).render();
                });
            });
        });
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $.getJSON('./CACHED/twenty_five_week_graph_data.json', function(data_d) {
            $.getJSON('./CACHED/twenty_five_week_graph_weeks.json', function(weeks) {
                const dataSource = {
                    chart: {
                        drawAnchors: "0",
                        yaxisname: "Hours",
                        numdivlines: "3",
                        showvalues: "0",
                        legenditemfontsize: "15",
                        legenditemfontbold: "1",
                        theme: "fusion",
                        lineThickness: "2",
                        drawFullAreaBorder: "0"
                    },
                    categories: [{
                        category: weeks
                    }],
                    dataset: data_d

                };

                FusionCharts.ready(function() {
                    var myChart = new FusionCharts({
                        type: "mscombidy2d",
                        renderAt: "demand_vs_capacity_tfive_weeks",
                        width: "100%",
                        height: "100%",
                        dataFormat: "json",
                        dataSource
                    }).render();
                });
            });
        });
    });
    </script>

</head>

<body>
    <div id="background">
        <div id="navmenu">
            <div>
                <p id="title" onclick="location.href='../MAIN/MAIN_MENU.php'">Kent Stainless</p>
            </div>
            <nav>
                <ul id="dashboard_list">
                    <li id="management_option" class="dashboard_option inactivebtn"
                        onclick="location.href='../MANAGEMENT SUBMENU/BASE_management_menu.php'">Management</li>
                    <li id="sales_option" class="dashboard_option inactivebtn"
                        onclick="location.href='../SALES SUBMENU/BASE_sales_menu.php'">Sales</li>
                    <li id="engineering_option" class="dashboard_option inactivebtn"
                        onclick="location.href='../ENGINEERING SUBMENU/BASE_engineering_menu.php'">Engineering</li>
                    <li id="production_option" class="dashboard_option activebtn"
                        onclick="location.href='../PRODUCTION SUBMENU/BASE_production_menu.php'">Production</li>
                    <li id="intel_option" class="dashboard_option inactivebtn"
                        onclick="location.href='../INTEL SUBMENU/BASE_intel_workflow.php'">Intel</li>
                    <li id="ncr_option" class="dashboard_option inactivebtn"
                        onclick="location.href='../NCR SUBMENU/BASE_ncr_menu.php'">NCR</li>
                    <br>
                    <li id="livetracker_option" class="dashboard_option inactivebtn"
                        onclick="location.href='../../../../VISUAL Management SYSTEM/LIVE/Livetracker_1_3_0'">
                        LIVETRACKER</li>
                </ul>
            </nav>
            <div id="lastupdateholder">
                <p>Last Updated</p>
                <p><?php echo date("d-m-Y H:i:s" , json_decode(file_get_contents(__DIR__.'\CACHED\data_last_updated.json'),true)); ?>
                <p>
                    <button id="reload_button" class="dashboard_option_"><img src="../../../RESOURCES/reload.png"
                            width="100%" height="100%" onclick="location.href='BASE_SUB_get_data.php'"></button>
            </div>
        </div>

        <!-- PRODUCTION MENU -->
        <div id="production_menu" class="submenu">
            <div id="topleft" class="sector top left" style="width:35%">
                <div class="totalgrid white top left" id="innertopleft">
                    <p class="totaltitle smedium">Released Last Week</p>
                    <p class="totalvalue larger"><?= $headline_figures["Released Last Week"]?></p>
                    <p class="totaltitle smedium">Released Week To Date</p>
                    <p class="totalvalue larger"><?= $headline_figures["Released This Week"]?></p>
                </div>
                <div class="totalgrid white top middle" id="innertopmiddle">
                    <p class="totaltitle smedium">Released Five Week Avg</p>
                    <p class="totalvalue larger"><?= $headline_figures["Released Five Week Average"]?></p>
                    <p class="totaltitle smedium">Released This Year</p>
                    <p class="totalvalue larger"><?= $headline_figures["Released Year To Date"]?></p>
                    <button onclick="toggleTable_Year()">Show Table</button>
                </div>
                <div class="totalgrid white top right" id="innertopright">
                    <p class="totaltitle smedium">Open Process Orders</p>
                    <p class="totalvalue larger"><?= $headline_figures["Live PO Count"]?></p>
                    <p class="totaltitle smedium">Complete</p>
                    <p class="totalvalue larger"><?= $headline_figures["Live Complete PO Count"]?></p>
                </div>
                <div class="totalgrid white bottom left" id="innerbottomleft">
                    <p class="totaltitle smedium">Booked Last Week (hrs)</p>
                    <p class="totalvalue larger"><?= $headline_figures["Executed Last Week"]?></p>
                    <p class="totaltitle smedium">Booked Week To Date</p>
                    <p class="totalvalue larger"><?= $headline_figures["Executed This Week"]?></p>
                </div>
                <div class="totalgrid white bottom middle" id="innerbottommiddle">
                    <p class="totaltitle smedium">Booked Five Week Avg</p>
                    <p class="totalvalue larger"><?= $headline_figures["Executed Five Week Average"]?></p>
                    <p class="totaltitle smedium">Booked This Year</p>
                    <p class="totalvalue larger"><?= $headline_figures["Executed Year To Date"]?></p>
                </div>
                <div class="totalgrid white bottom right" id="innerbottomright">
                    <p class="totaltitle smedium">On Floor</p>
                    <p class="totalvalue larger"><?= $headline_figures["Hours On Floor"]?></p>
                    <p class="totaltitle smedium">Current Lead Time</p>
                    <p class="totalvalue larger"><?= $headline_figures["Lead Time"]?></p>
                    <button onclick="toggleTable()">Show Table</button>
                </div>
                <div id="myModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <table id="modalTable">
                            <!-- Table content will be dynamically added here -->
                        </table>
                        <button onclick="export_to_excel('modalTable')" id="exportExcel" class="banner_button_">Export to Excel</button>
                    </div>
                </div>
                <div id="myModal_1" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <table id="modalTable_1">
                            <!-- Table content will be dynamically added here -->
                        </table>
                        <button onclick="export_to_excel('modalTable_1')" id="exportExcel_1" class="banner_button_">Export to Excel</button>
                    </div>
                </div>

            </div>
            <div id="topright" class="white sector top right" style="width:62%">
                <div class="content">
                    <div id="production_groups_bar_chart" class="fill">
                    </div>
                </div>
                <div class="head">
                    <button class="green br_green wtext"
                        onclick="location.href='../../PRODUCTION/BASE_production_groups.php?production_group=material_prep'">Mat
                        Prep</button>
                    <button class="green br_green wtext"
                        onclick="location.href='../../PRODUCTION/BASE_production_groups.php?production_group=fabrication_1'">
                        1</button>
                    <button class="green br_green wtext"
                        onclick="location.href='../../PRODUCTION/BASE_production_groups.php?production_group=fabrication_2'">Fabrication
                        2</button>
                    <button class="green br_green wtext"
                        onclick="location.href='../../PRODUCTION/BASE_production_groups.php?production_group=finishing'">Finishing</button>
                    <button class="green br_green wtext"
                        onclick="location.href='../../PRODUCTION/BASE_production_groups.php?production_group=docs_and_deliverables'">Docs
                        & Deliv</button>
                    <button class="green br_green wtext"
                        onclick="location.href='../../PRODUCTION/BASE_production_groups.php?production_group=stores'">Stores</button>
                </div>
            </div>

            <div class="white sector bottom left" style="width:54%">
                <div class="head">
                    <div style="height:100%;">
                        <div class="radio_title large">
                            <div class="title_tray">
                                Production Vs Demand
                            </div>
                        </div>
                        <div class="radio_buttons">
                            <div class="radio_buttons_tray dark_grey">
                                <div class="radio_buttons_inner_tray">
                                    <div class="radio_button cap_vs_dem mediumplus inactive" id="tfive_weeks"
                                        style="width:32%">25 Weeks</div>
                                    <div class="radio_breaker" style="width:2%"></div>
                                    <div class="radio_button cap_vs_dem mediumplus active" id="one_year"
                                        style="width:32%">1 Year</div>
                                    <div class="radio_breaker" style="width:2%"></div>
                                    <div class="radio_button cap_vs_dem mediumplus inactive" id="two_years"
                                        style="width:32%">2 Years</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <div class="radio_btn_page cap_vs_dem fill" id="tfive_weeks" style="display:none">
                        <div id="demand_vs_capacity_tfive_weeks" class="fill"></div>
                    </div>
                    <div class="radio_btn_page cap_vs_dem fill" id="one_year">
                        <div id="demand_vs_capacity_one_y" class="fill"></div>
                    </div>
                    <div class="radio_btn_page cap_vs_dem fill" id="two_years" style="display:none">
                        <div id="demand_vs_capacity_two_y" class="fill"></div>
                    </div>
                </div>
            </div>

            <div class="white sector bottom middle" style="width:21%">
                <div class="head">
                    <div style="height:100%;">
                        <div class="radio_title large">
                            <div class="title_tray">
                                Released
                            </div>
                        </div>
                        <div class="radio_buttons">
                            <div class="radio_buttons_tray dark_grey">
                                <div class="radio_buttons_inner_tray">
                                    <div class="radio_button released_pos mediumplus active" id="today"
                                        style="width:46%">TD</div>
                                    <div class="radio_breaker" style="width:8%"></div>
                                    <div class="radio_button released_pos mediumplus inactive" id="yesterday"
                                        style="width:46%">YD</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <div id="today" class="radio_btn_page released_pos table_cont fill no_scrollbar">
                        <div class="content_table_margin">
                            <table class="alt_rcolor medium rh_med fillw">
                                <thead>
                                    <tr class="dark_grey wtext sticky">
                                        <th width="20%">PO</th>
                                        <th width="80%">Item</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($released_today_list as $po): ?>
                                    <tr>
                                        <td><?=$po["Process Order"]?></td>
                                        <td class="lefttext"><?=$po["Item Name"]?></td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="yesterday" class="radio_btn_page released_pos table_cont fill no_scrollbar"
                        style=display:none;>
                        <div class="content_table_margin">
                            <table class="alt_rcolor medium rh_med fillw">
                                <thead>
                                    <tr class="dark_grey wtext sticky">
                                        <th width="20%">PO</th>
                                        <th width="80%">Item</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($released_yesterday_list as $po): ?>
                                    <tr>
                                        <td><?=$po["Process Order"]?></td>
                                        <td class="lefttext"><?=$po["Item Name"]?></td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="white sector bottom right" style="width:21%">
                <div class="head">
                    <div style="height:100%;">
                        <div class="radio_title large">
                            <div class="title_tray">
                                Complete
                            </div>
                        </div>
                        <div class="radio_buttons">
                            <div class="radio_buttons_tray dark_grey">
                                <div class="radio_buttons_inner_tray">
                                    <div class="radio_button complete_pos mediumplus active" id="today"
                                        style="width:46%">TD</div>
                                    <div class="radio_breaker" style="width:8%"></div>
                                    <div class="radio_button complete_pos mediumplus inactive" id="yesterday"
                                        style="width:46%">YD</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <div id="today" class="radio_btn_page complete_pos table_cont fill no_scrollbar">
                        <div class="content_table_margin">
                            <table class="alt_rcolor medium rh_med fillw">
                                <thead>
                                    <tr class="dark_grey wtext sticky">
                                        <th width="20%">PO</th>
                                        <th width="80%">Item</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($complete_today_list as $po): ?>
                                    <tr>
                                        <td><?=$po["Process Order"]?></td>
                                        <td class="lefttext"><?=$po["Item Name"]?></td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="yesterday" class="radio_btn_page complete_pos table_cont fill no_scrollbar"
                        style=display:none;>
                        <div class="content_table_margin">
                            <table class="alt_rcolor medium rh_med fillw">
                                <thead>
                                    <tr class="dark_grey wtext sticky">
                                        <th width="20%">PO</th>
                                        <th width="80%">Item</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($complete_yesterday_list as $po): ?>
                                    <tr>
                                        <td><?=$po["Process Order"]?></td>
                                        <td class="lefttext"><?=$po["Item Name"]?></td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="bottom_banner" class="white sector banner fullwidth">
                <button class="banner_button green br_green">TEST BUTTON ONE</button>
                <button class="banner_button yellow br_yellow">TEST BUTTON TWO</button>
                <button class="banner_button red br_red">TEST BUTTON THREE</button>
                <button class="banner_button green br_green">TEST BUTTON FOUR</button>
                <button class="banner_button red br_red">TEST BUTTON FIVE</button>
            </div>
        </div>
        <?php include("../BASE_TEMPLATE.html")?>
    </div>
    </div>
</body>

</html>