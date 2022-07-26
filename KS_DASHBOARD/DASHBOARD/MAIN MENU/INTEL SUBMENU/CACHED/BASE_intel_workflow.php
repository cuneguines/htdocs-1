<?php
    $checked = json_decode(file_get_contents('CACHED/selected_projects.json'),true);
    $projects = json_decode(file_get_contents('CACHED/projects.json'),true);

    $labour_achieved = json_decode(file_get_contents('CACHED/labour_achieved.json'),true);
    $released_labour = json_decode(file_get_contents('CACHED/released_labour.json'),true);
    $gross_labour = json_decode(file_get_contents('CACHED/gross_labour.json'),true);
    $labour_efficiency = json_decode(file_get_contents('CACHED/labour_efficiency.json'),true);
    $labour_margin = json_decode(file_get_contents('CACHED/labour_margin.json'),true);
    $net_labour = json_decode(file_get_contents('CACHED/net_labour.json'),true);
    $reaquisitioned_labour = json_decode(file_get_contents('CACHED/reaquisitioned_labour.json'),true);
    $diff_labour = json_decode(file_get_contents('CACHED/diff_labour.json'),true);

    $cum_labour_achieved = json_decode(file_get_contents('CACHED/cum_labour_achieved.json'),true);
    $cum_released_labour = json_decode(file_get_contents('CACHED/cum_released_labour.json'),true);
    $cum_gross_labour = json_decode(file_get_contents('CACHED/cum_gross_labour.json'),true);
    $cum_labour_efficiency = json_decode(file_get_contents('CACHED/cum_labour_efficiency.json'),true);
    $cum_labour_margin = json_decode(file_get_contents('CACHED/cum_labour_margin.json'),true);
    $cum_net_labour = json_decode(file_get_contents('CACHED/cum_net_labour.json'),true);
    $cum_reaquisitioned_labour = json_decode(file_get_contents('CACHED/cum_reaquisitioned_labour.json'),true);
    $cum_diff_labour = json_decode(file_get_contents('CACHED/cum_diff_labour.json'),true);

    $start_year = '2020';
    $start_week = 13;
    $visibility = 13;

    $date = new DateTime();
    $week = $date->format("W") + 52 * ($date->format("Y")-$start_year);
    $chart_visibility = $week - $start_week;
    $year = $start_year;
?>

<!DOCTYPE HTML>
    <html>
        <head>
            <link rel = "stylesheet" href = "../../../CSS/KS_DASH_STYLE.css">
            <script type = "text/javascript" src = "../../../js/libs/jquery-3.4.1.js"></script>
            <script type = "text/javascript" src = "../../../JS/LOCAL/JS_menu_select.js"></script>
            <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
            <script type = "text/javascript" src = "../../../JS/LIBS/fusioncharts/resources/js/fusioncharts.js"></script>
            <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
            <script type = "text/javascript">$(document).ready(function() {$.ajaxSetup({ cache: false });});</script>
            <?php date_default_timezone_set('Europe/London'); ?>
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
                            <li id = "sales_option"         class = "dashboard_option inactivebtn" onclick="location.href='../SALES SUBMENU/BASE_sales_menu.php'"              >Sales</li>
                            <li id = "engineering_option"   class = "dashboard_option inactivebtn" onclick="location.href='../ENGINEERING SUBMENU/BASE_engineering_menu.php'"  >Engineering</li>
                            <li id = "production_option"    class = "dashboard_option inactivebtn" onclick="location.href='../PRODUCTION SUBMENU/BASE_production_menu.php'"    >Production</li>
                            <li id = "intel_option"         class = "dashboard_option activebtn" onclick="location.href='../INTEL SUBMENU/BASE_intel_workflow.php'"            >Intel</li>
                            <li id = "ncr_option"           class = "dashboard_option inactivebtn" onclick="location.href='../NCR SUBMENU/BASE_ncr_menu.php'"                  >NCR</li>
                        </ul>    
                    </nav>
                    <div id = "lastupdateholder">
                        <p>Last Updated</p>
                        <p><?php echo date("d-m-Y H:i:s" , json_decode(file_get_contents(__DIR__.'\CACHED\data_last_updated.json'),true))." GMT"; ?><p>
                        <button id = "reload_button" class = "dashboard_option"><img src = "../../../RESOURCES/reload.png" width="100%" height="100%" onclick = "location.href='./BASE_SUB_get_data.php'"></button> 
                    </div>
                </div><div id = "intel_menu" class = "submenu">
                    <div id = "intel_top" class = "white sector top fullwidth">
                        <script>
                            $(document).ready(function(){
                                $.getJSON('./CACHED/intel_chart_data.json', function(data_test)
                                        {
                                            $.getJSON('./CACHED/intel_chart_data_cat.json', function(data_cat)
                                            {

                                            const dataSource = {
                                                chart: {
                                                    caption: "Intel Production Hours",
                                                    yaxisname: "Hours",
                                                    subcaption: "None",
                                                    showhovereffect: "1",
                                                    numbersuffix: " Hrs",
                                                    drawcrossline: "1",
                                                    yAxisMaxValue: "2500",
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
                                                renderAt: "chart-container",
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
                        <div id="chart-container">
                        </div> 
                    </div>
                    <div id = "intel_bottom" class = "white sector bottom fullwidth">
                        <div id = "inner">
                            <div id = "table_container">
                                <table id = "inteltotal">
                                    <tbody>
                                        <tr><td colspan = 27 style = "text-align:center;">Previous 25 Weeks</td></tr>
                                        <tr >
                                            <td style = "width:16%; color:black; border-bottom:1px solid green;">Title</td>
                                            <?php 
                                                for($i = $week-$visibility; $i <= $week; $i++)
                                                {
                                                    echo "<td style = 'width:6%; color:white;background-color:#404040'>".($i > 52 ? ($i - floor($i/52.00)*52)." (Y".(floor($i/52)+1).")" : $i)."</td>";
                                                }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>Booked Hours</td>
                                            <?php 
                                                for($i = $week-$visibility; $i <= $week ; $i++)
                                                {
                                                    echo "<td style = 'background-color:#29C3BE;'>".round($labour_achieved[$i],0)."</td>";
                                                }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>Hours Over Planned</td>
                                            <?php 
                                                for($i = $week-$visibility; $i <= $week ; $i++)
                                                {
                                                    echo "<td>".round($labour_efficiency[$i],0)."</td>";
                                                }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>Reaquisitioned Hours</td>
                                            <?php 
                                                for($i = $week-$visibility; $i <= $week ; $i++)
                                                {
                                                    echo "<td>".round($reaquisitioned_labour[$i],0)."</td>";
                                                }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>Net Labour</td>
                                            <?php 
                                                for($i = $week-$visibility; $i <= $week ; $i++)
                                                {
                                                    echo "<td style = 'border-top:1px solid green;'>".round($net_labour[$i],0)."</td>";
                                                }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>Released Hours</td>
                                            <?php 
                                                for($i = $week-$visibility; $i <= $week ; $i++)
                                                {
                                                    echo "<td style = 'background-color:#5D62B5;'>".round($released_labour[$i],0)."</td>";
                                                }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>Reamaining Labour Hours</td>
                                            <?php 
                                                for($i = $week-$visibility; $i <= $week ; $i++)
                                                {
                                                    echo "<td style = 'border-top:1px solid green;border-bottom:3px double green;'>".round($diff_labour[$i],0)."</td>";
                                                }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>Cum Labour Achieved</td>
                                            <?php 
                                                for($i = $week-$visibility; $i <= $week ; $i++)
                                                {
                                                    echo "<td>".round($cum_labour_achieved[$i],0)."</td>";
                                                }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>Cumulative Labour Over planned</td>
                                            <?php 
                                                for($i = $week-$visibility; $i <= $week ; $i++)
                                                {
                                                    echo "<td>".round($cum_labour_efficiency[$i]*-1,0)."</td>";
                                                }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>Cumlative Requisitioned Labour</td>
                                            <?php 
                                                for($i = $week-$visibility; $i <= $week ; $i++)
                                                {
                                                    echo "<td>".round($cum_reaquisitioned_labour[$i],0)."</td>";
                                                }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>Cumulative Net Labour</td>
                                            <?php 
                                                for($i = $week-$visibility; $i <= $week ; $i++)
                                                {
                                                    echo "<td style = 'border-top:1px solid green;'>".round($cum_net_labour[$i],0)."</td>";
                                                }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>Cumlative Released Labour</td>
                                            <?php 
                                                for($i = $week-$visibility; $i <= $week ; $i++)
                                                {
                                                    echo "<td>".round($cum_released_labour[$i],0)."</td>";
                                                }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>Cumlative Requisitioned Labour</td>
                                            <?php 
                                                for($i = $week-$visibility; $i <= $week ; $i++)
                                                {
                                                    echo "<td>".round($cum_reaquisitioned_labour[$i],0)."</td>";
                                                }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td>Cumulative Labour Remaining</td>
                                            <?php
                                                $final_val = ""; 
                                                for($i = $week-$visibility; $i <= $week ; $i++)
                                                {
                                                    
                                                    if($i == $week)
                                                    {
                                                        $final_val = 'border-left:1px solid red; border-right:1px solid red;';
                                                    }
                                                    echo "<td style = 'border-top:1px solid red;border-bottom:3px double red; $final_val'>".round($cum_diff_labour[$i],0)."</td>";
                                                    
                                                }
                                            ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div><!--
                        --><div id = "checkbox_holder">
                                <div id = "inner">
                                    <form id = "UpdateGraph" action = "./BASE_SUB_get_data.php" method="post">
                                        <h4 style = 'margin-top:10%;margin-bottom:10%;'>Project</h4>
                                        <?php
                                            foreach($projects as $row)
                                            {
                                                    echo "<label class='container'>".$row['Project'];
                                                    echo "<input type='checkbox'".(in_array($row["Project"], $checked) ? "checked='checked'" : "")."name = 'check_list[]' value='".$row["Project"]."'>";
                                                    echo "<span class='checkmark'></span>";
                                                    echo "</label>";
                                            }
                                        ?>                                  
                                        <input id = "submit_project" type="submit" name="submit" value="Refresh">
                                    </form>
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
        </div>
    </body>
</html>
    