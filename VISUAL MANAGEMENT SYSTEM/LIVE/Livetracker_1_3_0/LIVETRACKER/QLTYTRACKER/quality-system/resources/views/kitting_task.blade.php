
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="description" content="meta description">
    <meta name="viewpport" content="width=device-width, initial-scale = 1">
    <title>Kent Stainless</title>
    <link rel="stylesheet" href="../../../css/KS_DASH_STYLE.css">
    <script type="text/javascript" src="../../../JS/LIBS/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="../../../JS/LIBS/canvasjs.min.js"></script>
    <script type="text/javascript" src="../../../JS/LOCAL/JS_menu_select.js"></script>
    <script type="text/javascript" src="./JS_togglecharttable.js"></script>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../../CSS/KS_DASH_STYLE.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css')}}">
</head>
<style>
     button {
            
            padding: 10px;
            background-color: #FACB57;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            border-radius: 20px;
        }
    </style>

<body>
    <div id="background">
        <div id="navmenu">
            <div>
                <p id="title" id="title" onclick="location.href='../MAIN/MAIN_MENU.php'">Kent Stainless</p>
            </div>
            <nav>
                <ul id="dashboard_list">
                    <li id="management_option" class="dashboard_option inactivebtn"
                        onclick="location.href='../MANAGEMENT SUBMENU/BASE_management_menu.php'">Operator</li>
                    <li id="sales_option" class="dashboard_option inactivebtn"
                        onclick="location.href='http://127.0.0.1:8000/kitting_task'">Kitting</li>
                    <li id="engineering_option" class="dashboard_option activebtn"
                        onclick="location.href='../ENGINEERING SUBMENU/BASE_engineering_menu.php'">Engineer</li>
                    <li id="production_option" class="dashboard_option inactivebtn"
                        onclick="location.href='../PRODUCTION SUBMENU/BASE_production_menu.php'">RWC</li>
                    <li id="intel_option" class="dashboard_option inactivebtn"
                        onclick="location.href='../INTEL SUBMENU/BASE_intel_workflow.php'">QA</li>
                  
                    <br>
                    <li id="livetracker_option" class="dashboard_option inactivebtn"
                        onclick="location.href='../../../../VISUAL Management SYSTEM/LIVE/Livetracker_1_3_0'">
                        LIVETRACKER</li>
                </ul>
            </nav>
            <div id="lastupdateholder">
            </div>
        </div>
        <form action="process_form.php" method="post" enctype="multipart/form-data">
       

       <h1>KITTING</h1>
       <!-- Additional Main Tasks and Subtasks can be added as needed -->
       <fieldset>
           <legend>Kitting</legend>

           <!-- Subtask 2.1: Reference Job / Master File -->
           <label>
               <input type="checkbox" name="reference_job_master_file">
               All parts as per GA drawings and BOM
           </label>
           <br>

           <!-- Subtask 2.2: Concept Design -->
           <label>
               <input type="checkbox" name="concept_design_engineering_details">
               All parts, qty's as per BOM
           </label>
           <br>

           <!-- Subtask 2.3: Design Validation -->
           <label>
               <input type="checkbox" name="design_validation_sign_off">
               All fasteners, fixings as per BOM
               <br>

               <!-- Subtask 2.4: Customer Approval -->
               <label>
                   <input type="checkbox" name="customer_submittal_package">
                   As per site pack BOM
               </label>
               <br>
               <a href="#">Link to Data Sheet </a>

               <label>

                   <br>
       </fieldset>
       
       <button  type="submit">Submit</button>
   </form>

        <!-- FINANCE MENU -->


    </div>
</body>

</html>





