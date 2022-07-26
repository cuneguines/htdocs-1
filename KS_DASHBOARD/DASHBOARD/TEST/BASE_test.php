<!DOCTYPE html>
<html>
    <head>
        <!-- META STUFF -->
        <meta charset = "utf-8">
    	<title>Kent Stainless</title>
    	<meta name = "viewpport" content = "width=device-width, initial-scale = 1">

        <!-- EXTERNAL JAVASCRIPT LIBRARIES -->
        <script type = "text/javascript" src = "../../JS/LIBS/jquery-3.4.1.js"></script>
        <script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
        <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
        <script type = "text/javascript">$(document).ready(function() {$.ajaxSetup({ cache: false });});</script> <!-- DISBLE AJAX CACHING SO THAT IT WILL ALWAYS READ IN JSON FROM LOCAL CACHE INSTEAD OF USING AJAX MEMORY -->

        
         <!-- STYLESHEET -->
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

        <script>
            $.getJSON('./CACHE/oil_reserve_data.json', function(oil_reserve_data)
            {
                const dataSource = {
                    chart: {
                        caption: "Countries With Most Oil Reserves [2017-18]",
                        subcaption: "In MMbbl = One Million barrels",
                        xaxisname: "Country",
                        yaxisname: "Reserves (MMbbl)",
                        numbersuffix: "K",
                        theme: "fusion"
                    },
                    data: oil_reserve_data
                    };

                    FusionCharts.ready(function() {
                    var myChart = new FusionCharts({
                        type: "column2d",
                        renderAt: "chart-container",
                        width: "100%",
                        height: "100%",
                        dataFormat: "json",
                        dataSource,
                        events: {
                            dataplotClick: function (eventObj, dataObj) {
                                console.log(dataObj.categoryLabel);

                                filter_var = dataObj.categoryLabel;

                                rows.hide();
                                rows.filter("[ country " + filter_var + "]").show()
                            }
                        }
                    }).render();
                    });

            });
        </script>

        <script>
            $.getJSON('./CACHE/sales_per_month_2021.json', function(data_test)
            {
                const dataSource = {
                    chart: {
                        caption: "Sales Per Month 2021",
                        xaxisname: "Month",
                        yaxisname: "Sales Value",
                        theme: "fusion"
                    },
                    data: data_test
                    };

                    FusionCharts.ready(function() {
                    var myChart = new FusionCharts({
                        type: "area2d",
                        renderAt: "chart-container2",
                        width: "100%",
                        height: "100%",
                        dataFormat: "json",
                        dataSource
                    }).render();
                    });

            });
        </script>

        <script>
            $.getJSON('./CACHE/multiseries_sales_per_month.json', function(data)
            {
            const dataSource = {
                chart: {
                    caption: "Sales",
                    yaxisname: "Value",
                    xaxisname: "Month",
                    subcaption: "2019-2021",
                    showhovereffect: "1",
                    drawcrossline: "1",
                    plottooltext: "<b>$dataValue</b> of sales were on month $label",
                    theme: "fusion"
                },
                categories: [
                    {
                    category: [
                        {
                        label: "Jan"
                        },
                        {
                        label: "Feb"
                        },
                        {
                        label: "March"
                        },
                        {
                        label: "Apr"
                        },
                        {
                        label: "May"
                        },
                        {
                        label: "June"
                        },
                        {
                        label: "July"
                        },
                        {
                        label: "Aug"
                        },
                        {
                        label: "Sept"
                        },
                        {
                        label: "Oct"
                        },
                        {
                        label: "Nov"
                        },
                        {
                        label: "Dec"
                        }
                    ]
                    }
                ],
                dataset: data
                };

                FusionCharts.ready(function() {
                var myChart = new FusionCharts({
                    type: "msspline",
                    renderAt: "chart-container3",
                    width: "100%",
                    height: "100%",
                    dataFormat: "json",
                    dataSource
                }).render();
                });
            });
        </script>

        <script>
            $.getJSON('./CACHE/multiseries_sales_per_month.json', function(data)
            {
            const dataSource = {
                chart: {
                    caption: "Sales",
                    yaxisname: "Value",
                    xaxisname: "Month",
                    subcaption: "2019-2021",
                    showhovereffect: "1",
                    drawcrossline: "1",
                    plottooltext: "<b>$dataValue</b> of sales were on month $label",
                    theme: "fusion"
                },
                categories: [
                    {
                    category: [
                        {
                        label: "Jan"
                        },
                        {
                        label: "Feb"
                        },
                        {
                        label: "March"
                        },
                        {
                        label: "Apr"
                        },
                        {
                        label: "May"
                        },
                        {
                        label: "June"
                        },
                        {
                        label: "July"
                        },
                        {
                        label: "Aug"
                        },
                        {
                        label: "Sept"
                        },
                        {
                        label: "Oct"
                        },
                        {
                        label: "Nov"
                        },
                        {
                        label: "Dec"
                        }
                    ]
                    }
                ],
                dataset: data
                };

                FusionCharts.ready(function() {
                var myChart = new FusionCharts({
                    type: "stackedcolumn2d",
                    renderAt: "chart-container4",
                    width: "100%",
                    height: "100%",
                    dataFormat: "json",
                    dataSource,
                    events: {
                            dataplotClick: function (eventObj, dataObj) {
                                console.log(dataObj.datasetName);
                                console.log(dataObj.categoryLabel);

                                filter_var = dataObj.categoryLabel;

                               
                            }
                    }
                }).render();
                });
            });
        </script>

        <script>
            $.getJSON('./CACHE/multiseries_sales_per_month.json', function(data)
            {
            const dataSource = {
                chart: {
                    caption: "Sales",
                    yaxisname: "Value",
                    xaxisname: "Month",
                    subcaption: "2019-2021",
                    showhovereffect: "1",
                    drawcrossline: "1",
                    plottooltext: "<b>$dataValue</b> of sales were on month $label",
                    theme: "fusion"
                },
                categories: [
                    {
                    category: [
                        {
                        label: "Jan"
                        },
                        {
                        label: "Feb"
                        },
                        {
                        label: "March"
                        },
                        {
                        label: "Apr"
                        },
                        {
                        label: "May"
                        },
                        {
                        label: "June"
                        },
                        {
                        label: "July"
                        },
                        {
                        label: "Aug"
                        },
                        {
                        label: "Sept"
                        },
                        {
                        label: "Oct"
                        },
                        {
                        label: "Nov"
                        },
                        {
                        label: "Dec"
                        }
                    ]
                    }
                ],
                dataset: data
                };

                FusionCharts.ready(function() {
                var myChart = new FusionCharts({
                    type: "mscombi2d",
                    renderAt: "chart-container5",
                    width: "100%",
                    height: "100%",
                    dataFormat: "json",
                    dataSource
                }).render();
                });
            });
        </script>

        <script>
            // Define the colorVariations of the angular gauge
            const colorRange3 = {
                color: [{
                    minValue: 0,
                    maxValue: 80,
                    code: "#F2726F"
                    },{
                    minValue: 60,
                    maxValue: 100,
                    code: "#FFC533"
                    },{
                    minValue: 90,
                    maxValue: 200,
                    code: "#62B58F"
                    }]
                };
                //Set up the dial value
                const dials3 = {
                    dial: [
                        {
                            value: 65, 
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
                    renderAt:'chart-container6',
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
                            upperLimit : 200,
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
        </script>

        <script>
            const dataSource = {
                chart:  {
                        "caption": "Split of Visitors by Age Group",
                        "subCaption": "Last year",
                        "use3DLighting": "0",
                        "showPercentValues": "1",
                        "decimals": "1",
                        "useDataPlotColorForLabels": "1",
                        "theme": "fusion"
                    },
                    "data": [
                        {
                            "label": "Teenage",
                            "value": "1250400"
                        },
                        {
                            "label": "Adult",
                            "value": "1463300"
                        },
                        {
                            "label": "Mid-age",
                            "value": "1050700"
                        },
                        {
                            "label": "Senior",
                            "value": "491000"
                        }
                    ]
                };


                FusionCharts.ready(function() {
                var myChart = new FusionCharts({
                    type: "pie2d",
                    renderAt: "chart-container7",
                    width: "100%",
                    height: "100%",
                    dataFormat: "json",
                    dataSource
                }).render();
                });
        </script>

        <script>
            $(document).ready(function(){
                const dataSource = {
                chart:  {
                        "caption": "Split of Visitors by Age Group",
                        "subCaption": "Last year",
                        "use3DLighting": "0",
                        "showPercentValues": "1",
                        "decimals": "1",
                        "useDataPlotColorForLabels": "1",
                        "theme": "fusion"
                    },
                    "data": [
                        {
                            "label": "Teenage",
                            "value": "1250400"
                        },
                        {
                            "label": "Adult",
                            "value": "1463300"
                        },
                        {
                            "label": "Mid-age",
                            "value": "1050700"
                        },
                        {
                            "label": "Senior",
                            "value": "491000"
                        }
                    ]
                };


                FusionCharts.ready(function() {
                var myChart = new FusionCharts({
                    type: "pyramid",
                    renderAt: "chart-container8",
                    width: "100%",
                    height: "100%",
                    dataFormat: "json",
                    dataSource
                }).render();
                });
            });  
        </script>
        
    </head>
    <body>
        <div style = "height:500px; width:800px; float:left;" id="chart-container"></div>
        <div style = "height:500px; width:800px; float:left;" id="chart-container2"></div>
        <div style = "height:500px; width:800px; float:left;" id="chart-container3"></div>
        <div style = "height:500px; width:800px; float:left;" id="chart-container4"></div>
        <div style = "height:500px; width:800px; float:left;" id="chart-container5"></div>
        <div style = "height:500px; width:800px; float:left;" id="chart-container6"></div>
        <div style = "height:500px; width:700px; float:left;" id="chart-container7"></div>
        <div style = "height:500px; width:700px; float:left;" id="chart-container8"></div>

        <button style = "height:100px; width:100px;" onclick = "location.href='./BASE_SUB_get_data.php'"></button>
    </body>


