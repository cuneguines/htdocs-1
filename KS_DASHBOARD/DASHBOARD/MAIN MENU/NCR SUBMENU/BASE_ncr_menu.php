<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
    	<meta name = "description" content = "meta description">
    	<meta name = "viewpport" content = "width=device-width, initial-scale = 1">
    	<title>Kent Stainless</title>
		<link rel = "stylesheet" href = "../../../css/KS_DASH_STYLE.css">
        <script type = "text/javascript" src = "../../../JS/LIBS/jquery-3.4.1.js"></script>
        <script type = "text/javascript" src = "../../../JS/LIBS/canvasjs.min.js"></script>
        <script type = "text/javascript" src = "../../../JS/LOCAL/JS_menu_select.js"></script>
        <script type = "text/javascript" src = "./JS_togglecharttable.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>     
        <link rel = "stylesheet" href = "../../CSS/KS_DASH_STYLE.css">
    </head>
    <body>
        <div id = "background">
            <div id = "navmenu">
                <div>
                    <p id = "title" id = "title" onclick="location.href='../MAIN/MAIN_MENU.php'">Kent Stainless</p>
                </div>
                <nav>
                    <ul id = "dashboard_list">
                        <li id = "management_option"       class = "dashboard_option inactivebtn" onclick="location.href='../MANAGEMENT SUBMENU/BASE_management_menu.php'"           >Management</li>
                        <li id = "sales_option"         class = "dashboard_option inactivebtn" onclick="location.href='../SALES SUBMENU/BASE_sales_menu.php'"               >Sales</li>
                        <li id = "engineering_option"   class = "dashboard_option inactivebtn" onclick="location.href='../ENGINEERING SUBMENU/BASE_engineering_menu.php'"   >Engineering</li>
                        <li id = "production_option"    class = "dashboard_option inactivebtn" onclick="location.href='../PRODUCTION SUBMENU/BASE_production_menu.php'"     >Production</li>
                        <li id = "intel_option"         class = "dashboard_option inactivebtn" onclick="location.href='../INTEL SUBMENU/BASE_intel_workflow.php'"           >Intel</li>
                        <li id = "ncr_option"           class = "dashboard_option activebtn" onclick="location.href='../NCR SUBMENU/BASE_ncr_menu.php'"                     >NCR</li>
                        <br>
                        <li id = "livetracker_option"   class = "dashboard_option inactivebtn" onclick="location.href='../../../../VISUAL Management SYSTEM/LIVE/Livetracker_1_3_0'"     >LIVETRACKER</li>
                    </ul>    
                </nav>
                <div id = "lastupdateholder">
                </div>
            </div>

            <!-- FINANCE MENU -->
            <div id = "ncr_menu" class = "submenu">
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
                <!-- NOTHING -->
                </div>

                <div id = "bottomleft" class = "white sector bottom left" style = "width:65%">       
                </div><div id = "bottomright" class = "white sector bottom right" style = "width:32%">
                    <!-- NOTHING -->
                </div>
                <div id = "bottom_banner" class = "white sector banner fullwidth">
                    <button class = "banner_button green br_green"   onclick="location.href='http://127.0.0.1:8000/login'">LOGIN</button>
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


