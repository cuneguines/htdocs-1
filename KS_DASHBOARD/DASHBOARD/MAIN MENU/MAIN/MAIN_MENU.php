<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
    	<meta name = "description" content = "meta description">
    	<meta name = "viewpport" content = "width=device-width, initial-scale = 1">
    	<title>Kent Stainless</title>
        <!--<link rel = "stylesheet" href = "../css/style.css">-->
		<link rel = "stylesheet" href = "../../../css/KS_DASH_STYLE.css">
        <script type = "text/javascript" src = "../../../JS/LIBS/jquery-3.4.1.js"></script>
        <script type = "text/javascript" src = "../../../JS/LIBS/canvasjs.min.js"></script>
        <script type = "text/javascript" src = "../../../JS/LOCAL/JS_menu_select.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>     
        <link rel = "stylesheet" href = "../../../CSS/KS_DASH_STYLE.css">
    </head>
    <body>
        <div id = "background">
            <div id = "navmenu">
                <div>
                    <p id = "title">Kent Stainless</p>
                </div>
                <nav>
                    <ul id = "dashboard_list">
                        <li id = "management_option"       class = "dashboard_option inactivebtn mediumplus" onclick="location.href='../MANAGEMENT SUBMENU/BASE_management_menu.php'"    >Management</li>
                        <li id = "sales_option"         class = "dashboard_option inactivebtn mediumplus" onclick="location.href='../SALES SUBMENU/BASE_sales_menu.php'"              >Sales</li>
                        <li id = "engineering_option"   class = "dashboard_option inactivebtn mediumplus" onclick="location.href='../ENGINEERING SUBMENU/BASE_engineering_menu.php'"  >Engineering</li>
                        <li id = "production_option"    class = "dashboard_option inactivebtn mediumplus" onclick="location.href='../PRODUCTION SUBMENU/BASE_production_menu.php'"    >Production</li>
                        <li id = "intel_option"         class = "dashboard_option inactivebtn mediumplus" onclick="location.href='../INTEL SUBMENU/BASE_intel_workflow.php'"          >Intel</li>
                        <li id = "ncr_option"           class = "dashboard_option inactivebtn mediumplus" onclick="location.href='../NCR SUBMENU/BASE_ncr_menu.php'"                  >NCR</li>
                        <br>
                        <li id = "livetracker_option"   class = "dashboard_option inactivebtn" onclick="location.href='../../../../VISUAL Management SYSTEM/LIVE/Livetracker_1_3_0'"     >LIVETRACKER</li>
                    </ul>    
                </nav>
                <div id = "lastupdateholder">
                    
                </div>
            </div>

            <!-- HEADER MENU-->
            <div id = "title_menu" class = "submenu">
                <img id = "logo" src = "logo.png">
            </div>
            <?php include("../BASE_TEMPLATE.html")?>
        </div>
    </body>
</html>