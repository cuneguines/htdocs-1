<!DOCTYPE html>
<html>
    <head>
        <!-- META STUFF -->
        <meta charset = "utf-8">
    	<title>Kent Stainless</title>
    	<meta name = "viewpport" content = "width=device-width, initial-scale = 1">

        <!-- EXTERNAL JAVASCRIPT LIBRARIES -->
        <script type = "text/javascript" src = "../../../JS/LIBS/jquery-3.4.1.js"></script>
        <script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
        <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
        <script type = "text/javascript">$(document).ready(function() {$.ajaxSetup({ cache: false });});</script> <!-- DISBLE AJAX CACHING SO THAT IT WILL ALWAYS READ IN JSON FROM LOCAL CACHE INSTEAD OF USING AJAX MEMORY -->

        <!-- LOCAL JS -->
        <script type = "text/javascript" src = "../../../JS/LOCAL/JS_menu_select.js"></script>
        <script type = "text/javascript" src = "../../../JS/LOCAL/JS_radio_buttons.js"></script>
        
         <!-- STYLESHEET -->
		<link rel = "stylesheet" href = "../../../css/KS_DASH_STYLE.css">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
        
        <!-- PHP DEPENDANCIES + SETUP-->
        <?php include './BASE_SUB_fill_salesvalue_table.php' ;?>
        <?php date_default_timezone_set('Europe/London'); ?>

        <!-- IMPORT CACHED DATA -->
        <?php $table_data = json_decode(file_get_contents(__DIR__.'\CACHED\table_data.json'),true); ?>
        <?php $headline_figures = json_decode(file_get_contents(__DIR__.'\CACHED\headline_figures_data.json'),true); ?>
        <?php $top_customers = json_decode(file_get_contents(__DIR__.'\CACHED\top_customers.json'),true); ?>
        <?php $top_bp_d_customers = json_decode(file_get_contents(__DIR__.'\CACHED\top_bp_d_customers.json'),true); ?>
        <?php $top_bp_prbp_customers = json_decode(file_get_contents(__DIR__.'\CACHED\top_bp_prbp_customers.json'),true); ?>
        <?php $top_bp_prksp_customers = json_decode(file_get_contents(__DIR__.'\CACHED\top_bp_prksp_customers.json'),true); ?>
        <?php $top_ec_in_customers = json_decode(file_get_contents(__DIR__.'\CACHED\top_ec_in_customers.json'),true); ?>
        <?php $top_ec_mb_customers = json_decode(file_get_contents(__DIR__.'\CACHED\top_ec_mb_customers.json'),true); ?>
        <?php $top_st_customers = json_decode(file_get_contents(__DIR__.'\CACHED\top_st_customers.json'),true); ?>

        <!-- CHART SETUP -->
        <!-- THIS MONTH KPIS -->
        <script type="text/javascript">
            $(document).ready(function()
            {
                // Define the colorVariations of the angular gauge
                const colorRange2 = {
                color: [{
                    minValue: 0,
                    maxValue: 60,
                    code: '#F2726F'
                    },{
                    minValue: 60,
                    maxValue: 90,
                    code: '#FFC533'
                    },{
                    minValue: 90,
                    maxValue: 120,
                    code: '#62B58F'
                    }]
                };
                //Set up the dial value
                const dials2 = 
                {
                    dial: 
                    [
                        {value: 60,
                        showValue: 0}
                    ]
                };

                //STEP 3 - Chart Configurations
                var chartConfigurations2 = {
                    type: 'angulargauge',
                    width: '100%',
                    height: '100%',
                    dataFormat: 'json',
                    renderAt:'kpi_1_month',
                    dataSource: 
                    {
                        chart: 
                        {
                            adjustTM: 0,
                            majorTMNumber: 13,
                            minorTMNumber: 3,
                            bgColor : '#FFFFFF',
                            caption: 'UNUSED',
                            captionFontSize : 25, 
                            lowerLimit: '0',
                            upperLimit: '120',
                            showValue: '1',
                            numberSuffix: '%',
                            theme: 'fusion',
                        },
                        // Chart Data
                        colorRange: colorRange2,
                        dials: dials2
                    }
                }

                FusionCharts.ready(function()
                {
                    var fusioncharts2 = new FusionCharts(chartConfigurations2);
                    fusioncharts2.render();
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function()
            {
                $.getJSON('./CACHED/ontime_delivery_this_month_kpi.json', function(data_test)
                {
                    // Define the colorVariations of the angular gauge
                    const colorRange3 = {
                    color: [{
                        minValue : 0,
                        maxValue : 60,
                        code : "#F2726F"
                        },{
                        minValue : 60,
                        maxValue : 90,
                        code : "#FFC533"
                        },{
                        minValue : 90,
                        maxValue : 120,
                        code : "#62B58F"
                        }]
                    };
                    //Set up the dial value
                    const dials3 = {
                        dial: [
                            {
                                value: (data_test["Delivered On Time This Month"] /data_test["Delivered This Month"])*100, 
                                label :"Dial1",
                                showValue : 0
                            }
                        ]
                    };

                    //STEP 3 - Chart Configurations
                    var chartConfigurations3 = {
                        type: 'angulargauge', // The gauge type
                        width: '100%', // Width of the gauge
                        height: '100%', // Height of the gauge
                        dataFormat: 'json', // Data type
                        renderAt:'kpi_2_month', //Container where the chart will render
                        dataSource: {
                            // Gauge Configuration
                            chart: {
                                adjustTM: 0,
                                majorTMNumber: 13,
                                minorTMNumber: 3,
                                bgColor : "#FFFFFF",
                                caption : "Ontime Delivery This Month",
                                captionFontSize : 25, 
                                lowerLimit : "0",
                                upperLimit : "120",
                                showValue : "1",
                                numberSuffix : "%",
                                theme : "fusion"
                            },
                            // Chart Data
                            "colorRange": colorRange3,
                            "dials": dials3
                        }
                    }

                    FusionCharts.ready(function(){
                        var fusioncharts3 = new FusionCharts(chartConfigurations3);
                    fusioncharts3.render();
                    });
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function()
            {
                FusionCharts.ready(function()
                {
                    $.getJSON('./CACHED/delivered_this_month_kpi.json', function(del_this_month)
                    {   
                        // Define the colorVariations of the angular gauge
                        const colorRange1 = {
                            color: [{
                                    minvalue: "0",
                                    maxvalue: (del_this_month["Delivered This Month"]/del_this_month["Total This Month"]*100),
                                    code: "#F2726F"
                                },
                                {
                                    minvalue: (del_this_month["Delivered This Month"]/del_this_month["Total This Month"]*100),
                                    maxvalue: (del_this_month["In Stock This Month"]/del_this_month["Total This Month"]*100)+(del_this_month["Delivered This Month"]/del_this_month["Total This Month"]*100),
                                    label: "Delivered",
                                    code: "#FFC533"
                                },{
                                    minvalue: (del_this_month["In Stock This Month"]/del_this_month["Total This Month"]*100)+(del_this_month["Delivered This Month"]/del_this_month["Total This Month"]*100),
                                    maxvalue: 120,
                                    label: "",
                                    code: "#E8E8E8"
                                }]
                        };
                        //Set up the dial value
                        

                        //STEP 3 - Chart Configurations
                        var chartConfigurations1 = {
                            type: 'angulargauge', // The gauge type
                            width: '100%', // Width of the gauge
                            height: '100%', // Height of the gauge
                            dataFormat: 'json', // Data type
                            renderAt:'kpi_3_month', //Container where the chart will render
                            dataSource: {
                                // Gauge Configuration
                                "chart": {
                                    adjustTM: 0,
                                    majorTMNumber: 13,
                                    minorTMNumber: 3,
                                    bgColor : "#FFFFFF",
                                    caption: "Delivered This Month",
                                    captionFontSize : 25,
                                    showHoverEffect: "1",
                                    lowerLimit: "0",
                                    upperLimit: "120",
                                    showValue: "1",
                                    numberSuffix: "%",
                                    theme: "fusion"
                                },
                                // Chart Data
                                "colorRange": colorRange1,
                                dials: {
                                    dial : [{
                                    value : (del_this_month["In Stock This Month"]/del_this_month["Total This Month"]*100)+(del_this_month["Delivered This Month"]/del_this_month["Total This Month"]*100),
                                    showValue : 0
                                    }]
                                },
                                trendpoints: {
                                point: [
                                {
                                    startvalue: "100",
                                    displayvalue: " ",
                                    thickness: "2",
                                    color: "#E15A26",
                                    usemarker: "1",
                                    markerbordercolor: "#E15A26",
                                    markertooltext: "80%"
                                }
                                ]
                            },
                            annotations: {
                                    origw : 400,
                                    origh : 350,
                                    autoscale : 1,
                                    showBelow : 0,
                                    groups : [{
                                    id : "arcs",
                                    x : "0",
                                    y : "0",
                                    items : [{
                                        id : "state-cs-bg",
                                        type : "rectangle",
                                        x : "$chartCenterX-2",
                                        y : "$chartEndY - 45",
                                        tox : "$chartCenterX - 110",
                                        toy : "$chartEndY - 25",
                                        fillcolor : "#F2726F"
                                    }, {
                                        id : "state-cs-text",
                                        type : "Text",
                                        color : "#ffffff",
                                        label : "Delivered",
                                        fontSize : "12",
                                        align : "right",
                                        x : "$chartCenterX - 26",
                                        y : "$chartEndY - 35"
                                    },
                                    {
                                        id : "national-cs-bg",
                                        type : "rectangle",
                                        x : "$chartCenterX+2",
                                        y : "$chartEndY - 45",
                                        tox : "$chartCenterX + 110",
                                        toy : "$chartEndY - 25",
                                        fillcolor : "#FFC533"
                                    }, {
                                        id: "national-cs-text",
                                        type : "Text",
                                        color : "#ffffff",
                                        label : "In Stock",
                                        fontSize : "12",
                                        align : "left",
                                        x : "$chartCenterX + 32",
                                        y : "$chartEndY - 35"
                                    }, 
                                    {
                                        id : "store-cs-bg",
                                        type : "rectangle",
                                        x : "$chartCenterX-110",
                                        y : "$chartEndY - 22",
                                        tox : "$chartCenterX + 110",
                                        toy : "$chartEndY - 2",
                                        fillcolor : "#FF0000"
                                    }, {
                                        id : "state-cs-text",
                                        type : "Text",
                                        color : "#ffffff",
                                        label : "Target For This Month",
                                        fontSize : "12",
                                        align : "center",
                                        x : "$chartCenterX",
                                        y : "$chartEndY - 12"
                                    }]
                                    }]
                                }
                            }
                        }
                        var fusioncharts1 = new FusionCharts(chartConfigurations1);
                        fusioncharts1.render();
                    });
                });
            });
        </script>
        <!-- THIS YEAR KPIS -->
        <script type="text/javascript">
            $(document).ready(function()
            {
                $.getJSON('./CACHED/table_data.json', function(data_test)
                {
                    // Define the colorVariations of the angular gauge
                    const colorRange1 = 
                    {
                        color : [{
                            minValue : 0,
                            maxValue : 60,
                            code : "#F2726F"
                            },{
                            minValue : 60,
                            maxValue : 90,
                            code : "#FFC533"
                            },{
                            minValue : 90,
                            maxValue : 120,
                            code : "#62B58F"
                            }]
                    };
                    //Set up the dial value
                    const dials1 = {
                        dial : [{value: 60,
                                showValue : 0}
                        ]
                    };

                    //STEP 3 - Chart Configurations
                    var chartConfigurations1 = {
                        type: 'angulargauge', // The gauge type
                        width: '100%', // Width of the gauge
                        height: '100%', // Height of the gauge
                        dataFormat: 'json', // Data type
                        renderAt:'kpi_1_this_year', //Container where the chart will render
                        dataSource: {
                            // Gauge Configuration
                            chart: {
                                adjustTM: 0,
                                majorTMNumber: 13,
                                minorTMNumber: 3,
                                bgColor : "#FFFFFF",
                                caption : "UNUSED",
                                captionFontSize : 25,
                                lowerLimit : 0,
                                upperLimit : 120,
                                showValue : 1,
                                numberSuffix : "%",
                                theme : "fusion"
                            },
                            // Chart Data
                            colorRange : colorRange1,
                            dials : dials1
                        }
                    }

                    FusionCharts.ready(function()
                    {
                        var fusioncharts1 = new FusionCharts(chartConfigurations1);
                        fusioncharts1.render();
                    });
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function()
            {
                $.getJSON('./CACHED/ontime_delivery_this_year_kpi.json', function(data_test)
                {
                    // Define the colorVariations of the angular gauge
                    const colorRange3 = {
                    color: [{
                        minValue: 0,
                        maxValue: 60,
                        code: "#F2726F"
                        },{
                        minValue: 60,
                        maxValue: 90,
                        code: "#FFC533"
                        },{
                        minValue: 90,
                        maxValue: 120,
                        code: "#62B58F"
                        }]
                    };
                    //Set up the dial value
                    const dials3 = {
                        dial: [
                            {
                                value: (data_test["Delivered On Time This Year"] /data_test["Delivered This Year"])*100, 
                                showValue : 0
                            }
                        ]
                    };

                    //STEP 3 - Chart Configurations
                    var chartConfigurations3 = {
                        type: 'angulargauge', // The gauge type
                        width: '100%', // Width of the gauge
                        height: '100%', // Height of the gauge
                        dataFormat: 'json', // Data type
                        renderAt:'kpi_2_this_year',
                        dataSource: {
                            // Gauge Configuration
                            chart: {
                                adjustTM: 0,
                                majorTMNumber: 13,
                                minorTMNumber: 3,
                                bgColor : "#FFFFFF",
                                caption : "Ontime Delivery This Year",
                                captionFontSize : 25,
                                lowerLimit : 0,
                                upperLimit : 120,
                                showValue : 1,
                                numberSuffix : "%",
                                theme : "fusion"
                            },
                            // Chart Data
                            colorRange : colorRange3,
                            dials : dials3
                        }
                    }

                    FusionCharts.ready(function()
                    {
                        var fusioncharts3 = new FusionCharts(chartConfigurations3);
                        fusioncharts3.render();
                    });
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function()
            {
                FusionCharts.ready(function()
                {
                    $.getJSON('./CACHED/delivered_this_year_kpi.json', function(del_this_year)
                    {   
                        // Define the colorVariations of the angular gauge
                        const colorRange1 = {
                            color: [{
                                    minvalue: "0",
                                    maxvalue: (del_this_year["Delivered This Year"]/del_this_year["Total This Year"]*100),
                                    code: "#F2726F"
                                },
                                {
                                    minvalue: (del_this_year["Delivered This Year"]/del_this_year["Total This Year"]*100),
                                    maxvalue: (del_this_year["In Stock This Year"]/del_this_year["Total This Year"]*100)+(del_this_year["Delivered This Year"]/del_this_year["Total This Year"]*100),
                                    label: "Delivered",
                                    code: "#FFC533"
                                },{
                                    minvalue: (del_this_year["In Stock This Year"]/del_this_year["Total This Year"]*100)+(del_this_year["Delivered This Year"]/del_this_year["Total This Year"]*100),
                                    maxvalue: 120,
                                    label: "",
                                    code: "#E8E8E8"
                                }]
                        };
                        //Set up the dial value
                        

                        //STEP 3 - Chart Configurations
                        var chartConfigurations1 = {
                            type: 'angulargauge', // The gauge type
                            width: '100%', // Width of the gauge
                            height: '100%', // Height of the gauge
                            dataFormat: 'json', // Data type
                            renderAt:'kpi_3_this_year', //Container where the chart will render
                            dataSource: {
                                // Gauge Configuration
                                "chart": {
                                    adjustTM: 0,
                                    majorTMNumber: 13,
                                    minorTMNumber: 3,
                                    bgColor : "#FFFFFF",
                                    caption: "Delivered This Year",
                                    captionFontSize : 25,
                                    showHoverEffect: "1",
                                    lowerLimit: "0",
                                    upperLimit: "120",
                                    showValue: "1",
                                    numberSuffix: "%",
                                    theme: "fusion"
                                },
                                // Chart Data
                                "colorRange": colorRange1,
                                dials: {
                                    dial : [{
                                    value : (del_this_year["In Stock This Year"]/del_this_year["Total This Year"]*100)+(del_this_year["Delivered This Year"]/del_this_year["Total This Year"]*100),
                                    showValue : 0
                                    }]
                                },
                                trendpoints: {
                                point: [
                                {
                                    startvalue: "100",
                                    displayvalue: " ",
                                    thickness: "2",
                                    color: "#E15A26",
                                    usemarker: "1",
                                    markerbordercolor: "#E15A26",
                                    markertooltext: "80%"
                                }
                                ]
                            },
                            annotations: {
                                    origw : 400,
                                    origh : 350,
                                    autoscale : 1,
                                    showBelow : 0,
                                    groups : [{
                                    id : "arcs",
                                    x : "0",
                                    y : "0",
                                    items : [{
                                        id : "state-cs-bg",
                                        type : "rectangle",
                                        x : "$chartCenterX-2",
                                        y : "$chartEndY - 45",
                                        tox : "$chartCenterX - 110",
                                        toy : "$chartEndY - 25",
                                        fillcolor : "#F2726F"
                                    }, {
                                        id : "state-cs-text",
                                        type : "Text",
                                        color : "#ffffff",
                                        label : "Delivered",
                                        fontSize : "12",
                                        align : "right",
                                        x : "$chartCenterX - 26",
                                        y : "$chartEndY - 35"
                                    },
                                    {
                                        id : "national-cs-bg",
                                        type : "rectangle",
                                        x : "$chartCenterX+2",
                                        y : "$chartEndY - 45",
                                        tox : "$chartCenterX + 110",
                                        toy : "$chartEndY - 25",
                                        fillcolor : "#FFC533"
                                    }, {
                                        id: "national-cs-text",
                                        type : "Text",
                                        color : "#ffffff",
                                        label : "In Stock",
                                        fontSize : "12",
                                        align : "left",
                                        x : "$chartCenterX + 32",
                                        y : "$chartEndY - 35"
                                    }, 
                                    {
                                        id : "store-cs-bg",
                                        type : "rectangle",
                                        x : "$chartCenterX-110",
                                        y : "$chartEndY - 22",
                                        tox : "$chartCenterX + 110",
                                        toy : "$chartEndY - 2",
                                        fillcolor : "#FF0000"
                                    }, {
                                        id : "state-cs-text",
                                        type : "Text",
                                        color : "#ffffff",
                                        label : "Target For This Month",
                                        fontSize : "12",
                                        align : "center",
                                        x : "$chartCenterX",
                                        y : "$chartEndY - 12"
                                    }]
                                    }]
                                }
                            }
                        }
                        var fusioncharts1 = new FusionCharts(chartConfigurations1);
                        fusioncharts1.render();
                    });
                });
            });
        </script>
        <!-- LAST YEAR KPIS -->
        <script type="text/javascript">
            $(document).ready(function()
            {
                $.getJSON('./CACHED/table_data.json', function(data_test)
                {
                    // Define the colorVariations of the angular gauge
                    const colorRange1 = 
                    {
                        color: [{
                            minValue : 0,
                            maxValue : 60,
                            code : "#F2726F"
                            },{
                            minValue : 60,
                            maxValue : 90,
                            code : "#FFC533"
                            },{
                            minValue : 90,
                            maxValue : 120,
                            code : "#62B58F"
                            }]
                    };
                    //Set up the dial value
                    const dials1 = {
                        dial: [
                            {value : 60,
                            showValue : 0}
                        ]
                    };

                    //STEP 3 - Chart Configurations
                    var chartConfigurations1 = {
                        type: 'angulargauge', // The gauge type
                        width: '100%', // Width of the gauge
                        height: '100%', // Height of the gauge
                        dataFormat: 'json', // Data type
                        renderAt:'kpi_1_last_year', //Container where the chart will render
                        dataSource: {
                            // Gauge Configuration
                            chart: {
                                adjustTM: 0,
                                majorTMNumber: 13,
                                minorTMNumber: 3,
                                bgColor : "#FFFFFF",
                                caption : "UNUSED",
                                captionFontSize : 25,
                                lowerLimit : 0,
                                upperLimit : 120,
                                showValue : 1,
                                numberSuffix : "%",
                                theme : "fusion"
                            },
                            // Chart Data
                            colorRange : colorRange1,
                            dials : dials1
                        }
                    }

                    FusionCharts.ready(function()
                    {
                        var fusioncharts1 = new FusionCharts(chartConfigurations1);
                        fusioncharts1.render();
                    });
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function()
            {
                $.getJSON('./CACHED/ontime_delivery_last_year_kpi.json', function(data_test)
                {
                    // Define the colorVariations of the angular gauge
                    const colorRange3 = {
                    color: 
                    [
                        {
                            minValue: 0,
                            maxValue: 60,
                            code: "#F2726F"
                        },
                        {
                            minValue: 60,
                            maxValue: 90,
                            code: "#FFC533"
                        },
                        {
                            minValue: 90,
                            maxValue: 120,
                            code: "#62B58F"
                        }
                    ]
                    };
                    //Set up the dial value
                    const dials3 = {
                        dial: [
                            {
                                value: (data_test["Delivered On Time Last Year"]/data_test["Delivered Last Year"])*100, 
                                showValue : 0
                            }
                        ]
                    };

                    //STEP 3 - Chart Configurations
                    var chartConfigurations3 = {
                        type: 'angulargauge', // The gauge type
                        width: '100%', // Width of the gauge
                        height: '100%', // Height of the gauge
                        dataFormat: 'json', // Data type
                        renderAt:'kpi_2_last_year', //Container where the chart will render
                        dataSource: {
                            // Gauge Configuration
                            chart: {
                                adjustTM: 0,
                                majorTMNumber: 13,
                                minorTMNumber: 3,
                                bgColor  : "#FFFFFF",
                                caption : "Ontime Delivery Last Year",
                                captionFontSize : 25,
                                lowerLimit : 0,
                                upperLimit : 120,
                                showValue : 1,
                                numberSuffix : "%",
                                theme : "fusion"
                            },
                            // Chart Data
                            colorRange : colorRange3,
                            dials : dials3
                        }
                    }

                    FusionCharts.ready(function()
                    {
                        var fusioncharts3 = new FusionCharts(chartConfigurations3);
                        fusioncharts3.render();
                    });
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function()
                {
                FusionCharts.ready(function()
                {
                    $.getJSON('./CACHED/delivered_last_year_kpi.json', function(del_last_year)
                    {   
                        // Define the colorVariations of the angular gauge
                        const colorRange1 = {
                            color: [{
                                    minvalue: "0",
                                    maxvalue: (del_last_year["Delivered Last Year"]/del_last_year["Total Last Year"]*100),
                                    code: "#F2726F"
                                },
                                {
                                    minvalue: (del_last_year["Delivered Last Year"]/del_last_year["Total Last Year"]*100),
                                    maxvalue: (del_last_year["In Stock Last Year"]/del_last_year["Total Last Year"]*100)+(del_last_year["Delivered Last Year"]/del_last_year["Total Last Year"]*100),
                                    label: "Delivered",
                                    code: "#FFC533"
                                },{
                                    minvalue: (del_last_year["In Stock Last Year"]/del_last_year["Total Last Year"]*100)+(del_last_year["Delivered Last Year"]/del_last_year["Total Last Year"]*100),
                                    maxvalue: 120,
                                    label: "",
                                    code: "#E8E8E8"
                                }]
                        };
                        //Set up the dial value
                        

                        //STEP 3 - Chart Configurations
                        var chartConfigurations1 = 
                        {
                            type: 'angulargauge', // The gauge type
                            width: '100%', // Width of the gauge
                            height: '100%', // Height of the gauge
                            dataFormat: 'json', // Data type
                            renderAt:'kpi_3_last_year', //Container where the chart will render
                            dataSource: {
                                // Gauge Configuration
                                "chart": {
                                    adjustTM: 0,
                                    majorTMNumber: 13,
                                    minorTMNumber: 3,
                                    bgColor : "#FFFFFF",
                                    caption: "Delivered Last Year",
                                    captionFontSize : 25,
                                    showHoverEffect: "1",
                                    lowerLimit: "0",
                                    upperLimit: "120",
                                    showValue: "1",
                                    numberSuffix: "%",
                                    theme: "fusion"
                                },
                                // Chart Data
                                "colorRange": colorRange1,
                                dials: {
                                    dial : [{
                                    value : (del_last_year["In Stock Last Year"]/del_last_year["Total Last Year"]*100)+(del_last_year["Delivered Last Year"]/del_last_year["Total Last Year"]*100),
                                    showValue : 0
                                    }]
                                },
                                trendpoints: {
                                point: [
                                {
                                    startvalue: "100",
                                    displayvalue: " ",
                                    thickness: "2",
                                    color: "#E15A26",
                                    usemarker: "1",
                                    markerbordercolor: "#E15A26",
                                    markertooltext: "80%"
                                }
                                ]
                            },
                            annotations: {
                                    origw : 400,
                                    origh : 350,
                                    autoscale : 1,
                                    showBelow : 0,
                                    groups : [{
                                    id : "arcs",
                                    x : "0",
                                    y : "0",
                                    items : [{
                                        id : "state-cs-bg",
                                        type : "rectangle",
                                        x : "$chartCenterX-2",
                                        y : "$chartEndY - 45",
                                        tox : "$chartCenterX - 110",
                                        toy : "$chartEndY - 25",
                                        fillcolor : "#F2726F"
                                    }, {
                                        id : "state-cs-text",
                                        type : "Text",
                                        color : "#ffffff",
                                        label : "Delivered",
                                        fontSize : "12",
                                        align : "right",
                                        x : "$chartCenterX - 26",
                                        y : "$chartEndY - 35"
                                    },
                                    {
                                        id : "national-cs-bg",
                                        type : "rectangle",
                                        x : "$chartCenterX+2",
                                        y : "$chartEndY - 45",
                                        tox : "$chartCenterX + 110",
                                        toy : "$chartEndY - 25",
                                        fillcolor : "#FFC533"
                                    }, {
                                        id: "national-cs-text",
                                        type : "Text",
                                        color : "#ffffff",
                                        label : "In Stock",
                                        fontSize : "12",
                                        align : "left",
                                        x : "$chartCenterX + 32",
                                        y : "$chartEndY - 35"
                                    }, 
                                    {
                                        id : "store-cs-bg",
                                        type : "rectangle",
                                        x : "$chartCenterX-110",
                                        y : "$chartEndY - 22",
                                        tox : "$chartCenterX + 110",
                                        toy : "$chartEndY - 2",
                                        fillcolor : "#FF0000"
                                    }, {
                                        id : "state-cs-text",
                                        type : "Text",
                                        color : "#ffffff",
                                        label : "Target For This Month",
                                        fontSize : "12",
                                        align : "center",
                                        x : "$chartCenterX",
                                        y : "$chartEndY - 12"
                                    }]
                                    }]
                                }
                            }
                        }
                        var fusioncharts1 = new FusionCharts(chartConfigurations1);
                        fusioncharts1.render();
                    });
                });
            });
        </script>
        <!-- 12 MONTH + 24 MONTH SPLNE GRAPHS -->
        <script type = "text/javascript">
            $(document).ready(function()
            {
                $.getJSON('./CACHED/line_chart_values_data.json', function(data_test)
                {
                    $.getJSON('./CACHED/line_chart_catagories_data.json', function(data_cat)
                    {
                        const dataSource = 
                        {
                            chart: 
                            {
                                caption: "Value Of Sales",
                                yaxisname: "Value in €",
                                subcaption: "Next 12 Months",
                                showhovereffect: "1",
                                numberprefix: "€",
                                drawcrossline: 1,
                                anchorRadius : 3,
                        
                                theme: "fusion"
                            },
                            categories: 
                            [
                                {
                                category: data_cat
                                }
                            ],
                            dataset: data_test
                        };

                        FusionCharts.ready(function()
                        {
                            var myChart = new FusionCharts({
                                type: "msspline",
                                renderAt: "chart-container_1",
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
    	<script type = "text/javascript">
            $(document).ready(function()
            {
                $.getJSON('./CACHED/line_chart_2_values_data.json', function(data_test)
                {
                    $.getJSON('./CACHED/line_chart_2_catagories_data.json', function(data_cat)
                    {

                    const dataSource = {
                        chart: {
                            caption: "Value Of Sales",
                            yaxisname: "Value in €",
                            subcaption: "Next 12 Months",
                            showhovereffect: "1",
                            numberprefix: "€",
                            drawcrossline: 1,
                            anchorRadius : 3,
                            theme: "fusion"
                        },
                        categories: [
                            {
                            category: data_cat
                            }
                        ],
                        dataset: data_test
                        };

                    FusionCharts.ready(function() {
                    var myChart = new FusionCharts({
                        type: "msspline",
                        renderAt: "chart-container_2",
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
        <div id = "background">
            <!-- NAVIGATION -->
            <div id = "navmenu">
                <div>
                    <p id = "title" onclick="location.href='../MAIN/MAIN_MENU.php'">Kent Stainless</p>
                </div>
                <nav>
                    <ul id = "dashboard_list">
                        <li id = "management_option"    class = "dashboard_option activebtn"   onclick="location.href='../MANAGEMENT SUBMENU/BASE_management_menu.php'"                 >Management</li>
                        <li id = "sales_option"         class = "dashboard_option inactivebtn" onclick="location.href='../SALES SUBMENU/BASE_sales_menu.php'"                           >Sales</li>
                        <li id = "engineering_option"   class = "dashboard_option inactivebtn" onclick="location.href='../ENGINEERING SUBMENU/BASE_engineering_menu.php'"               >Engineering</li>
                        <li id = "production_option"    class = "dashboard_option inactivebtn" onclick="location.href='../PRODUCTION SUBMENU/BASE_production_menu.php'"                 >Production</li>
                        <li id = "intel_option"         class = "dashboard_option inactivebtn" onclick="location.href='../INTEL SUBMENU/BASE_intel_workflow.php'"                       >Intel</li>
                        <li id = "ncr_option"           class = "dashboard_option inactivebtn" onclick="location.href='../NCR SUBMENU/BASE_ncr_menu.php'"                               >NCR</li>
                        <br>
                        <li id = "livetracker_option"   class = "dashboard_option inactivebtn" onclick="location.href='../../../../VISUAL Management SYSTEM/LIVE/Livetracker_1_3_0'"     >LIVETRACKER</li>
                    </ul>
                </nav>
                <div id = "lastupdateholder">
                    <p>Last Updated</p>
                    <p><?= date("d-m-Y H:i:s" , json_decode(file_get_contents(__DIR__.'\CACHED\data_last_updated.json'),true)); ?><p>
                    <button id = "reload_button" class = "dashboard_option"><img src = "../../../RESOURCES/reload.png" width="100%" height="100%" onclick = "location.href='./BASE_SUB_get_data.php'"></button> 
                </div>
            </div>
            <!-- CONTENT -->
            <div id = "finance_menu" class = "submenu">
                
                <!-- 3 BY 2 BOXES IN TOP LEFT -->
                <div id = "topleft" class = "sector top left" style = "width:35%">
                    <div class = "totalgrid white top left" id = "innertopleft">
                        <p class = "totaltitle smedium">Delivered Sales Current Year</p>
                        <p class = "totalvalue larger"><br>€<?= number_format($headline_figures["Del This Y"]/1000000,2)." M"?></p>
                    </div>
                    <div class = "totalgrid white top middle" id = "innertopmiddle">
                        <p class = "totaltitle smedium">Confirmed Sales Due Next Four Months</p>
                        <p class = "totalvalue larger"><br>€<?= number_format($headline_figures["Confirmed Four Months"]/1000000,2)." M"?></p>
                    </div>
                    <div class = "totalgrid white top right" id = "innertopright">
                        <p class = "totaltitle smedium">Confirmed Sales Current Year</p>
                        <p class = "totalvalue larger"><br>€<?= number_format($headline_figures["Confirmed Total"]/1000000,2)." M"?></p>
                    </div>
                    <div class = "totalgrid white bottom left" id = "innerbottomleft">
                        <p class = "totaltitle smedium">Delivered Sales For Last Year</p>
                        <p class = "totalvalue larger"><br>€<?= number_format($headline_figures["Del Last Y"]/1000000,2)." M"?></p>
                    </div>
                    <div class = "totalgrid white bottom middle" id = "innerbottommiddle">
                        <p class = "totaltitle smedium">Predicted Sales Next Four Months</p>
                        <p class = "totalvalue larger"><br>€<?= number_format($headline_figures["Total Four Months"]/1000000,2)." M"?></p>
                    </div>
                    <div class = "totalgrid white bottom right" id = "innerbottomright">
                        <p class = "totaltitle smedium">Predicted Sales For Current Year</p>
                        <p class = "totalvalue larger"><br>€<?= number_format($headline_figures["Total Overall"]/1000000,2)." M"?></p>
                    </div>
                </div>

                <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

                <!-- 3 SPEDO KPIS WITH RADIO SELECTOR -->
                <div id = "topright" class = "sector top right white" style = "width:62%">
                    <div class = "head">
                        <div class = "radio_title large">
                            <div class = "title_tray">
                                KPI
                            </div>
                        </div>
                        <div class = "radio_buttons">
                            <div class = "radio_buttons_tray dark_grey">
                                <div class = "radio_buttons_inner_tray">
                                    <div class = "radio_button kpis medium inactive" id = "last_year_kpi" style = "width:30%">Last Year</div>
                                    <div class = "radio_breaker" style = "width:5%"></div>
                                    <div class = "radio_button kpis medium inactive" id = "this_year_kpi" style = "width:30%">This Year</div>
                                    <div class = "radio_breaker" style = "width:5%"></div>
                                    <div class = "radio_button kpis medium active" id = "this_month_kpi" style = "width:30%">This Month</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "content">
                        <div id = "this_month_kpi" class = "radio_btn_page kpis fill">
                            <div id = "kpi_1_month" class = "kpi"></div>
                            <div id = "kpi_2_month" class = "kpi"></div>
                            <div id = "kpi_3_month" class = "kpi"></div>      
                        </div>
                        <div id = "this_year_kpi" class = "radio_btn_page kpis fill" style = "display:none">
                            <div id = "kpi_1_this_year" class = "kpi"></div>
                            <div id = "kpi_2_this_year" class = "kpi"></div>
                            <div id = "kpi_3_this_year" class = "kpi"></div>
                        </div>
                        <div id = "last_year_kpi" class = "radio_btn_page kpis fill" style = "display:none">
                            <div id = "kpi_1_last_year" class = "kpi"></div>
                            <div id = "kpi_2_last_year" class = "kpi"></div>
                            <div id = "kpi_3_last_year" class = "kpi"></div>
                        </div>
                    </div>
                </div>

                <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

                <!-- GRAPHS AND TABLE WITH RADIO SELECTOR -->
                <div id = "bottomleft" class = "sector bottom left white" style = "width:63%;">
                    <div class = "head">
                        <div style = "height:100%;">
                            <div class = "radio_title large">
                                <div class = "title_tray">
                                    Sales Value
                                </div>
                            </div>
                            <div class = "radio_buttons">
                                <div class = "radio_buttons_tray dark_grey">
                                    <div class = "radio_buttons_inner_tray">
                                        <div class = "radio_button sales_values mediumplus inactive" id = "table" style = "width:30%">Table</div>
                                        <div class = "radio_breaker" style = "width:5%"></div>
                                        <div class = "radio_button sales_values mediumplus active" id = "twelve_months" style = "width:30%">12 Months</div>
                                        <div class = "radio_breaker" style = "width:5%"></div>
                                        <div class = "radio_button sales_values mediumplus inactive" id = "twenty_four_months" style = "width:30%">24 Months</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "content">
                        <div id = "table" class = "radio_btn_page sales_values table_cont fill no_scrollbar propscroll" style = "display:none;">
                            <div class = "content_table_margin_wide">
                                <table id = "finance_table" class = "fill alt_rcolor rh_small">
                                    <thead>
                                        <tr class = "dark_grey wtext smedium sticky">
                                            <th width=6.5%>Year</th>
                                            <th width=6.5%>Month</th>
                                            <th width=10%>Complete</th>
                                            <th width=10%>Forecast</th>
                                            <th width=9%>Potential</th>
                                            <th width=9%>Confirmed</th>
                                            <th width=9%>Live</th>
                                            <th width=9%>Total</th>
                                            <th width=3% style = 'background-color:#404040;'></th>
                                            <th width=9%>In Stock</th>
                                            <th width=9%>Delivered</th>
                                            <th width=9%>Invoiced</th>
                                        </tr>
                                    <tbody>
                                        <?php fill_salesvalue_table($table_data) ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id = "twelve_months" class = "radio_btn_page sales_values fill">
                            <div id  = "chart-container_1" style = "width:100%; height:100%;"></div>
                        </div>
                        <div id = "twenty_four_months" class = "radio_btn_page sales_values fill" style = "display:none;">
                            <div id  = "chart-container_2" style = "width:100%; height:100%;"></div>
                        </div>
                    </div>
                </div>

                <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

                <!-- SALES VALUE TABLES READ IN FROM XLSX SPREADSHEET -->
                <div id = "bottomright" class = "sector bottom right white" style = "width:34%;">
                    <div class = "head">
                        <div style = "height:100%;">
                            <div class = "radio_buttons" style = "width:100%;">
                                <div class = "radio_buttons_tray dark_grey">
                                    <div class = "radio_buttons_inner_tray">
                                        <div class = "radio_button value_table medium active" id = "all" style = "width:10.4%">ALL</div>
                                        <div class = "radio_breaker" style = "width:2.2%"></div>
                                        <div class = "radio_button value_table medium inactive" id = "bp-d" style = "width:11.4%">BP-D</div>
                                        <div class = "radio_breaker" style = "width:2.2%"></div>
                                        <div class = "radio_button value_table medium inactive" id = "bp-prbp" style = "width:13.9%">BP-BP</div>
                                        <div class = "radio_breaker" style = "width:2.2%"></div>
                                        <div class = "radio_button value_table medium inactive" id = "bp-prksp" style = "width:16.4%">BP-KSP</div>
                                        <div class = "radio_breaker" style = "width:2.2%"></div>
                                        <div class = "radio_button value_table medium inactive" id = "ec-in" style = "width:11.9%">EC-IN</div>
                                        <div class = "radio_breaker" style = "width:2.2%"></div>
                                        <div class = "radio_button value_table medium inactive" id = "ec-mb" style = "width:14.4%">EC-MB</div>
                                        <div class = "radio_breaker" style = "width:2.2%"></div>
                                        <div class = "radio_button value_table medium inactive" id = "st" style = "width:8.4%">ST</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "content">
                        <div id = "all" class = "radio_btn_page value_table fill">
                            <div class = "content_table_margin_wide">
                                <table class = "alt_rcolor fill">
                                    <thead>
                                        <tr style = "background-color:#454545; color:white;">
                                            <th width = "50%">Customer</th>
                                            <th width = "12.5%">Value</th>
                                            <th width = "12.5%">Margin</th>
                                            <th width = "12.5%">Of Total</th>
                                            <th width = "12.5%">Cumul</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($top_customers as $customer):?>
                                            <?php if($customer["customer name"] == 'Grand Total' || $customer["customer name"] == ''){echo "<tr><td>----</td><td>----</td><td>----</td><td>----</td><td>----</td></tr>"; continue;}?>
                                            <tr>   
                                                <td id = 'td_stringdata'><?= $customer["customer name"]?></td>
                                                <td>€ <?= $customer["sales value"]." M"?></td>
                                                <td> <?= $customer["sales margin"]." %"?></td>
                                                <td> <?= $customer["percentage of total"]." %"?></td>
                                                <td> <?= $customer["percentage of total cum"]." %"?></td>
                                            </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id = "bp-d" class = "radio_btn_page value_table fill" style = "display:none">
                            <div class = "content_table_margin_wide">
                                <table class = "alt_rcolor fill">
                                    <thead>
                                        <tr style = "background-color:#454545; color:white;">
                                            <th width = "50%">Customer</th>
                                            <th width = "12.5%">Value</th>
                                            <th width = "12.5%">Margin</th>
                                            <th width = "12.5%">Of Total</th>
                                            <th width = "12.5%">Cumul</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($top_bp_d_customers as $customer):?>
                                            <?php if($customer["customer name"] == 'Grand Total' || $customer["customer name"] == ''){echo "<tr><td>----</td><td>----</td><td>----</td><td>----</td><td>----</td></tr>"; continue;}?>
                                            <tr> 
                                                <td id = 'td_stringdata'><?= $customer["customer name"]?></td>
                                                <td>€ <?= $customer["sales value"]." M"?></td>
                                                <td> <?= $customer["sales margin"]." %"?></td>
                                                <td> <?= $customer["percentage of total"]." %"?></td>
                                                <td> <?= $customer["percentage of total cum"]." %"?></td>
                                            </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id = "bp-prbp" class = "radio_btn_page value_table fill" style = "display:none; max-height:100%;">
                            <div class = "content_table_margin_wide">
                                <table class = "alt_rcolor fill">
                                    <thead>
                                        <tr style = "background-color:#454545; color:white;">
                                            <th width = "50%">Customer</th>
                                            <th width = "12.5%">Value</th>
                                            <th width = "12.5%">Margin</th>
                                            <th width = "12.5%">Of Total</th>
                                            <th width = "12.5%">Cumul</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($top_bp_prbp_customers as $customer):?>
                                            <?php if($customer["customer name"] == 'Grand Total' || $customer["customer name"] == ''){echo "<tr><td>----</td><td>----</td><td>----</td><td>----</td><td>----</td></tr>"; continue;}?>
                                            <tr>
                                                <td id = 'td_stringdata'><?= $customer["customer name"]?></td>
                                                <td>€ <?= $customer["sales value"]." M"?></td>
                                                <td> <?= $customer["sales margin"]." %"?></td>
                                                <td> <?= $customer["percentage of total"]." %"?></td>
                                                <td> <?= $customer["percentage of total cum"]." %"?></td>
                                            </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id = "bp-prksp" class = "radio_btn_page value_table fill" style = "display:none">
                            <div class = "content_table_margin_wide">
                                <table class = "alt_rcolor fill">
                                    <thead>
                                        <tr style = "background-color:#454545; color:white;">
                                            <th width = "50%">Customer</th>
                                            <th width = "12.5%">Value</th>
                                            <th width = "12.5%">Margin</th>
                                            <th width = "12.5%">Of Total</th>
                                            <th width = "12.5%">Cumul</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($top_bp_prksp_customers as $customer):?>
                                            <?php if($customer["customer name"] == 'Grand Total' || $customer["customer name"] == ''){echo "<tr><td>----</td><td>----</td><td>----</td><td>----</td><td>----</td></tr>"; continue;}?>
                                        <tr>
                                            <td id = 'td_stringdata'><?= $customer["customer name"]?></td>
                                            <td>€ <?= $customer["sales value"]." M"?></td>
                                            <td> <?= $customer["sales margin"]." %"?></td>
                                            <td> <?= $customer["percentage of total"]." %"?></td>
                                            <td> <?= $customer["percentage of total cum"]." %"?></td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id = "ec-in" class = "radio_btn_page value_table fill" style = "display:none;">
                            <div class = "content_table_margin_wide">
                                <table class = "alt_rcolor fill">
                                    <thead>
                                        <tr style = "background-color:#454545; color:white;">
                                            <th width = "50%">Customer</th>
                                            <th width = "12.5%">Value</th>
                                            <th width = "12.5%">Margin</th>
                                            <th width = "12.5%">Of Total</th>
                                            <th width = "12.5%">Cumul</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($top_ec_in_customers as $customer):?>
                                            <?php if($customer["customer name"] == 'Grand Total' || $customer["customer name"] == ''){echo "<tr><td>----</td><td>----</td><td>----</td><td>----</td><td>----</td></tr>"; continue;}?>
                                        <tr>
                                            <td id = 'td_stringdata'><?= $customer["customer name"]?></td>
                                            <td>€ <?= $customer["sales value"]." M"?></td>
                                            <td> <?= $customer["sales margin"]." %"?></td>
                                            <td> <?= $customer["percentage of total"]." %"?></td>
                                            <td> <?= $customer["percentage of total cum"]." %"?></td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                        <div id = "ec-mb" class = "radio_btn_page value_table fill" style = "display:none">
                            <div class = "content_table_margin_wide">
                                <table class = "alt_rcolor fill">
                                    <thead>
                                        <tr style = "background-color:#454545; color:white;">
                                            <th width = "50%">Customer</th>
                                            <th width = "12.5%">Value</th>
                                            <th width = "12.5%">Margin</th>
                                            <th width = "12.5%">Of Total</th>
                                            <th width = "12.5%">Cumul</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($top_ec_mb_customers as $customer):?>
                                        <?php if($customer["customer name"] == 'Grand Total' || $customer["customer name"] == ''){echo "<tr><td>----</td><td>----</td><td>----</td><td>----</td><td>----</td></tr>"; continue;}?>
                                        <tr>
                                            <td id = 'td_stringdata'><?= $customer["customer name"]?></td>
                                            <td>€ <?= $customer["sales value"]." M"?></td>
                                            <td> <?= $customer["sales margin"]." %"?></td>
                                            <td> <?= $customer["percentage of total"]." %"?></td>
                                            <td> <?= $customer["percentage of total cum"]." %"?></td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>  
                        <div id = "st" class = "radio_btn_page value_table fill" style = "display:none">
                            <div class = "content_table_margin_wide">
                                <table class = "alt_rcolor fill">
                                    <thead>
                                        <tr style = "background-color:#454545; color:white;">
                                            <th width = "50%">Customer</th>
                                            <th width = "12.5%">Value</th>
                                            <th width = "12.5%">Margin</th>
                                            <th width = "12.5%">Of Total</th>
                                            <th width = "12.5%">Cumul</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($top_st_customers as $customer):?>
                                        <?php if($customer["customer name"] == 'Grand Total' || $customer["customer name"] == ''){echo "<tr><td>----</td><td>----</td><td>----</td><td>----</td><td>----</td></tr>"; continue;}?>
                                        <tr>
                                            <td id = 'td_stringdata'><?= $customer["customer name"]?></td>
                                            <td>€ <?= $customer["sales value"]." M"?></td>
                                            <td> <?= $customer["sales margin"]." %"?></td>
                                            <td> <?= $customer["percentage of total"]." %"?></td>
                                            <td> <?= $customer["percentage of total cum"]." %"?></td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>              
                    </div>
                </div>

                <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

                <div id = "bottom_banner" class = "white sector banner fullwidth">
                    <button class = "banner_button green br_green">TEST BUTTON ONE</button>
                    <button class = "banner_button yellow br_yellow">TEST BUTTON TWO</button>
                    <button class = "banner_button red br_red">TEST BUTTON THREE</button>
                    <button class = "banner_button green br_green">TEST BUTTON FOUR</button>
                    <button class = "banner_button red br_red">TEST BUTTON FIVE</button>
                </div>
            </div>
            <?php include("../BASE_TEMPLATE.html")?>
        </div>
    </body>
</html>