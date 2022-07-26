<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
    	<meta name = "description" content = "meta description">
    	<meta name = "viewpport" content = "width=device-width, initial-scale = 1">
    	<title>Kent Stainless</title>
		<link rel = "stylesheet" href = "../../../css/KS_DASH_STYLE.css">
        <script type = "text/javascript" src = "../../../JS/LIBS/jquery-3.4.1.js"></script>
        <script type = "text/javascript" src = "../../../JS/LIBS/fusioncharts/resources/js/fusioncharts.js"></script>
        <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
        <script type = "text/javascript" src = "../../../JS/LOCAL/JS_menu_select.js"></script>
        <script type = "text/javascript" src = "./JS_togglecharttable.js"></script>
        <script type = "text/javascript" src = "../../../JS/LOCAL/JS_radio_buttons.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
        <?php date_default_timezone_set('Europe/London'); ?>    
        <?php $today_sales = json_decode(file_get_contents('CACHED/today_sales.json'),true) ?>
        <?php $yesterday_sales = json_decode(file_get_contents('CACHED/yesterday_sales.json'),true) ?>
        <?php $top_customers = json_decode(file_get_contents('CACHED/top_customers.json'),true) ?>
        <?php $top_sales_people = json_decode(file_get_contents('CACHED/top_sales_people.json'),true) ?>
    </head>
    <body>
        <div id = "background">
            <div id = "navmenu">
                <div>
                    <p id = "title" onclick="location.href='../MAIN/MAIN_MENU.php'">Kent Stainless</p>
                </div>
                <nav>
                    <ul id = "dashboard_list">
                        <li id = "management_option"       class = "dashboard_option inactivebtn" onclick="location.href='../MANAGEMENT SUBMENU/BASE_management_menu.php'"          >Management</li>
                        <li id = "sales_option"         class = "dashboard_option activebtn" onclick="location.href='../SALES SUBMENU/BASE_sales_menu.php'"                >Sales</li>
                        <li id = "engineering_option"   class = "dashboard_option inactivebtn" onclick="location.href='../ENGINEERING SUBMENU/BASE_engineering_menu.php'"  >Engineering</li>
                        <li id = "production_option"    class = "dashboard_option inactivebtn" onclick="location.href='../PRODUCTION SUBMENU/BASE_production_menu.php'"    >Production</li>
                        <li id = "intel_option"         class = "dashboard_option inactivebtn" onclick="location.href='../INTEL SUBMENU/BASE_intel_workflow.php'"          >Intel</li>
                        <li id = "ncr_option"           class = "dashboard_option inactivebtn" onclick="location.href='../NCR SUBMENU/BASE_ncr_menu.php'"                  >NCR</li>
                        <br>
                        <li id = "livetracker_option"   class = "dashboard_option inactivebtn" onclick="location.href='../../../../VISUAL Management SYSTEM/LIVE/Livetracker_1_3_0'"     >LIVETRACKER</li>
                    </ul>    
                </nav>
                <div id = "lastupdateholder">
                    <p>Last Updated</p>
                    <p><?php echo date("d-m-Y H:i:s" , json_decode(file_get_contents(__DIR__.'\CACHED\data_last_updated.json'),true))." GMT"; ?><p>
                    <button id = "reload_button" class = "dashboard_option"><img src = "../../../RESOURCES/reload.png" width="100%" height="100%" onclick = "location.href='BASE_SUB_get_data.php'"></button>
                </div>
            </div>

            <!-- FINANCE MENU -->
            <div id = "sales_menu" class = "submenu">
                <div id = "topleft" class = "sector top left" style = "width:35%">
                    <div class = "totalgrid white top left" id = "innertopleft">
                        <p class = "totaltitle smedium">Number 1</p>
                        <p class = "totalvalue larger"><br>€ 1,000 </p>
                    </div>
                    <div class = "totalgrid white top middle" id = "innertopmiddle">
                        <p class = "totaltitle smedium">Number 1</p>
                        <p class = "totalvalue larger"><br>€ 1,000</p>
                    </div>
                    <div class = "totalgrid white top right" id = "innertopright">
                        <p class = "totaltitle smedium">Number 1</p>
                        <p class = "totalvalue larger"><br>€ 1,000</p>
                    </div>
                    <div class = "totalgrid white bottom left" id = "innerbottomleft">
                        <p class = "totaltitle smedium">Number 1</p>
                        <p class = "totalvalue larger"><br>€ 1,000</p>
                    </div>
                    <div class = "totalgrid white bottom middle" id = "innerbottommiddle">
                        <p class = "totaltitle smedium">Number 1</p>
                        <p class = "totalvalue larger"><br>€ 1,000</p>
                    </div>
                    <div class = "totalgrid white bottom right" id = "innerbottomright">
                        <p class = "totaltitle smedium">Number 1</p>
                        <p class = "totalvalue larger"><br>€ 1,000</p>
                    </div>
                </div>
                <div id = "topright" class = "white sector top right" style = "width:62%">  
                </div>





                <div class = "white sector bottom left" style = "width:54%">
                    <script type = "text/javascript">
                        $.getJSON('./CACHED/data.json', function(Json_data_js)
                        {
                            $.getJSON('./CACHED/data_schema.json', function(schema_js)
                            {
                                console.log(Json_data_js);
                                console.log(schema_js);

                                const dataStore = new FusionCharts.DataStore();
                                const dataSource = {
                                    chart: {theme: "fusion", bgColor: "#000000",},
                                    caption: 
                                    {
                                        text: "Sales Per Day"
                                    },
                                    subcaption:
                                    {
                                        text: "Post 2017"
                                    },
                                    series: "BU",
                                    yaxis: [
                                    {
                                        plot: [
                                        {
                                            value: "Sales Value",
                                            aggregation: "Sum",
                                            type: "column"
                                        }
                                        ],
                                        title: "Sales Value",
                                        format:
                                        {
                                            prefix: "€ "
                                        }
                                    }
                                    ]
                                };
                                dataSource.data = dataStore.createDataTable(Json_data_js, schema_js);

                                new FusionCharts({
                                    type: "timeseries",
                                    renderAt: "chart-container",
                                    width: "100%",
                                    height: "100%",
                                    dataSource: dataSource
                                }).render();
                            });
                        });
                    </script>
                    <div id = 'chart-container'></div>
                </div>


                <div class = "white sector bottom middle" style = "width:21%">
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
                                        <div class = "radio_button sales_value mediumplus active" id = "sales_today" style = "width:46%">TD</div>
                                        <div class = "radio_breaker" style = "width:8%"></div>
                                        <div class = "radio_button sales_value mediumplus inactive" id = "sales_yesterday" style = "width:46%">YD</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "content">
                        <div id = "sales_today" class = "radio_btn_page sales_value table_cont fill no_scrollbar" >
                            <div class = "content_table_margin">
                                <table class = "alt_rcolor medium rh_med fillw">
                                    <thead>
                                        <tr class = "dark_grey wtext sticky">
                                            <th width = "60%">Customer</th>
                                            <th width = "40%">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($today_sales as $sale)
                                            {
                                                echo "<tr>";
                                                    echo "<td id = 'td_stringdata'>".$sale["Customer"]."</td>";
                                                    echo "<td>€ ".number_format($sale["Value"])."</td>";
                                                echo "</tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id = "sales_yesterday" class = "radio_btn_page sales_value table_cont fill no_scrollbar" style = "display:none">
                            <div class = "content_table_margin">    
                                <table class = "alt_rcolor medium rh_med fillw">
                                    <thead>
                                        <tr class = "dark_grey wtext sticky">
                                            <th width = "60%">Customer</th>
                                            <th width = "40%">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($yesterday_sales as $sale)
                                            {
                                                echo "<tr>";
                                                    echo "<td id = 'td_stringdata'>".$sale["Customer"]."</td>";
                                                    echo "<td>€ ".number_format($sale["Value"])."</td>";
                                                echo "</tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>




                <div class = "white sector bottom right" style = "width:21%">
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
                                        <div class = "radio_button sales_this_y mediumplus active" id = "customer" style = "width:46%">CUST</div>
                                        <div class = "radio_breaker" style = "width:8%"></div>
                                        <div class = "radio_button sales_this_y mediumplus inactive" id = "sales_person" style = "width:46%">SP</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "content">
                        <div id = "customer" class = "radio_btn_page sales_this_y table_cont fill no_scrollbar">
                            <div class = "content_table_margin">
                                <table class = "alt_rcolor medium rh_med fill">
                                    <thead>
                                        <tr class = "dark_grey wtext sticky">
                                            <th width = "60%">Customer</th>
                                            <th width = "40%">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($top_customers as $customer)
                                            {
                                                echo "<tr>";
                                                    echo "<td id = 'td_stringdata'>".$customer["Customer"]."</td>";
                                                    echo "<td>€ ".number_format($customer["Value"])."</td>";
                                                echo "</tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id = "sales_person" class = "radio_btn_page sales_this_y table_cont fill no_scrollbar" style = display:none;>
                            <div class = "content_table_margin">    
                                <table class = "alt_rcolor medium rh_med fill">
                                    <thead>
                                        <tr class = "dark_grey wtext sticky">
                                            <th width = "60%">Sales Person</th>
                                            <th width = "40%">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($top_sales_people as $sales_person)
                                            {
                                                echo "<tr>";
                                                    echo "<td id = 'td_stringdata'>".$sales_person["Sales Person"]."</td>";
                                                    echo "<td>€ ".number_format($sales_person["Value"])."</td>";
                                                echo "</tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>






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


