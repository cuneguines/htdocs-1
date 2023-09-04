<?php
    // READ IN LIBS
    require '../../../PHP LIBS/phpspreadsheets/vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    include '../../../PHP LIBS/PHP FUNCTIONS/phpspreadsheets_lookup_data.php';
?>
<?php
    // SECURITY
    // IF PASSWORD IS SUBMITTED AND CORRECT ALLOW TO CONTINUE
    // IF PASSWORD IS SUBMITTED AND INCORRECT REDIVERT TO LOGIN PAGE WITH ERROR MESSAGE
    // IF RELOAD DATA OPTION IS CLICKED REDIVERT TO LOGIN PAGE (ABOVE WILL STILL BE EXECUTED) AND ASK FOR PASSWORD AGAIN
    // OTHERWISE REDIVERT TO LOGIN PAGE
    session_start();
    $hash = "$2y$10$9i0l3Vv59STI5.Gj5efkP.pUQ3YL/498shkn6au3MOPwZteZMBNFm";
    if(isset($_POST['password']) && password_verify(isset($_POST['password']) ? $_POST['password'] : '', $hash)){
        $_SESSION['logged_in'] = 1;
    }
    elseif(isset($_POST['password']) && !password_verify(isset($_POST['password'])? $_POST['password'] : '', $hash)){
        $_SESSION['logged_in'] = 0;
        header("Location:enter_password.php?message=Access Denied");
    }
    else{
        $_SESSION['logged_in'] = 0;
        header("Location:enter_password.php?message=Access Denied");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- INITALISATION AND META STUFF -->
        <title>TABLE LAYOUT</title>
        <meta name = "viewpport" content = "width=device-width, initial-scale = 1">

        <!-- EXTERNAL JS DEPNDENCIES -->
        <script type = "text/javascript" src = "../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>				
        <script type = "text/javascript" src = "../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
        <script type = "text/javascript" src = "../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

        <!-- LOCAL JS DEPENDENCIES -->
        <script type = "text/javascript" src = "../../../JS LIBS/LOCAL/JS_filters.js"></script>
        <script type = "text/javascript" src = "../../../JS LIBS/LOCAL/JS_search_table.js"></script>
		<script type = "text/javascript" src = "./JS_table_to_excel.js"></script>

        <!-- STYLING -->
        <link href='../../../CSS/LT_STYLE.css' rel='stylesheet' type='text/css'>
        <link rel = "stylesheet" href = "../../../css/theme.blackice.min.css">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
        
        <!-- PHP DEPENDENCIES -->
        <?php include '../../../PHP LIBS/PHP FUNCTIONS/php_functions.php'; ?>
        <?php
            // LOAD SHEET FROM CACHE AND SET SHEET INDEX (ONLY ONE FOR THIS PAGE) + DEFINE FIRST ROW OF SPREADSHEET WITH DATA
            $spreadsheet = $reader->load('C://VMS_MASTER_DATA/HR_EMP_DATA/EMP_STATIC_DATA/EMPLOYEES.xlsx');
            $spreadsheet->setActiveSheetIndex(0);
            $row = 2;
        ?>
        <script> 
            const page_description = 
            "THIS PAGE LISTS ALL EMPLOYEES CURRENTLY IN THE REVIEW STAGE (START DATE WITHIN 2 YEARS)\r\n\nTHERE ARE 5 REVIEW STAGES\n1 => PROBATION 1 AT 30 DAYS\n2 => PROBATION 2 AT 90 DAYS\n3 => PROBATION 3 AT 150 DAYS\n4 => FULL TIME REVIEW 1 AT 350 DAYS\n5 => FULL TIME REVIEW 2 AT 700 DAYS\r\n\nALL EMPLOYEES HERE LONGER THAN 750 DAYS AND COMPLETED REVIEW 5 WILL NO LONGER APPEAR ON THIS LIST\r\n\nEVERY EMPLOYEE IS CATAGORISED INTO 3 CATEGORIES\n1 => OVERDUE EMPLOYEE PAST NEXT REVIEW DATE (RED)\n2 => UPCOMMING EMPLOYEE HAS REVIEW DUE SOON (ORANGE)\n3 => OK EMPLOYEE IS NOT OVERDUE OR DUE FOR REVIEW (BLUE)";
        </script>


        <!-- TABLESORTER INITALISATION -->
        <script>
            $(function() {
                $(".sortable").tablesorter({
                    theme : "blackice",
                    dateFormat : "ddmmyyyy",
                    headers : { 4: {sorter: "shortdate"},6: {sorter: "shortdate"} }
                });
            });
        </script>
    </head>
    <body>
        <div id = "background">
            <div id = "content">
                <div class = "table_title green">
                    <div class = "page_info_button" onclick = 'alert(page_description);'><img class = "fill" src = "../../../RESOURCES/info_icon.svg"></div>
                    <h1>STAFF REVIEW SCHEDULE</h1>
                </div>
                <div id = "pages_table_container" class = "table_container" style = "overflow-y:scroll">
                    <table id = "employee_balance" class = "white btext filterable sortable searchable">
                        <thead>
                            <tr class = "dark_grey wtext smedium head">
                                <th width = "4%" class = "lefttext">Staff Number</th>
                                <th width = "9%" class = "lefttext">Employee Name</th>
                                <th width = "9%" class = "lefttext">Department</th>
                                <th width = "9%" class = "lefttext">Supervisor</th>
                                <th width = "6%" class = "lefttext">Start Date</th>
                                <th width = "2%" class = "lefttext">#</th> 
                                <th width = "6%" class = "lefttext">Next Date</th> 
                                <th width = "1%" class = "lefttext"></th>
                                <?php for($i = 0; $i < 750; $i++):?>
                                    <?php
                                        $color = "";
                                        switch($i){
                                            case 30: $color = "red"; $day = $i." Days"; break;
                                            case 90: $color = "red"; $day = $i." Days"; break;
                                            case 150: $color = "red"; $day = $i." Days"; break;
                                            case 350: $color = "red"; $day = $i." Days"; break;
                                            case 700: $color = "red"; $day = $i." Days"; break;
                                            default: $color = ""; $day = NULL;
                                        }
                                    ?>
                                    <th class = "<?=$color?>" style = "width:<?=54/750?>%"><?=$day?></th>
                                <?php endfor;?>
                            </tr>
                        </thead>
                        <tbody class = "smedium">
                            <!-- WHILE WE HAVE NOT REACHED END OF DATA ON SPREADSHEET PRINT ROWS WITH ASSIGEND DOM VALUES AND SUBSEQUENCT TABLE DATA FOR ROW FROM EACH ROW IN SPREADSHEET-->
                            <!-- IF AN EMPLOYEE IS LISTED ON THE SPREADSHEET BU NOT ON THE MASTER DATA SKIP TO THE NEXT ROW ON SPREADSHEET WITHOUT PRINTING ANYTHING -->
                            <?php  while($spreadsheet->getActiveSheet()->getCell('A'.$row)->getValue() != ''):  ?>

                                <?php $employee = (int)$spreadsheet->getActiveSheet()->getCell('A'.$row)->getValue()?>
                                <?php if((int)$employee==510||(int)$employee ==511||(int)$employee>=800){$row++;continue;}?>
                                
                                <?php $supervisor_filter = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', get_emp_supervisor($employee))); ?>
                                <?php $department_filter = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', get_emp_dept_name($employee))); ?>
                                <?php $start_date = convert_serial_date($spreadsheet->getActiveSheet()->getCell('BB'.$row)->getValue());?>
                                <?php $probation_no = $spreadsheet->getActiveSheet()->getCell('AH'.$row)->getValue();?>

                                <?php if(get_day_difference($start_date) > 750){$row++; continue;}?>

                                <?php
                                    $days = get_day_difference($start_date);
                                    $probation_dates = array(
                                        "probation_date_1" => add_days_to_date($start_date,30),
                                        "probation_date_2" => add_days_to_date($start_date,90),
                                        "probation_date_3" => add_days_to_date($start_date,150),
                                        "probation_date_4" => add_days_to_date($start_date,350),
                                        "probation_date_5" => add_days_to_date($start_date,700)
                                    );
                                   //$next_probation_date='';
                                    switch($probation_no){
                                        case 0: $next_probation_date = $probation_dates["probation_date_1"];    break;
                                        case 1: $next_probation_date = $probation_dates["probation_date_2"];    break;
                                        case 2: $next_probation_date = $probation_dates["probation_date_3"];    break;
                                        case 3: $next_probation_date = $probation_dates["probation_date_4"];    break;
                                        case 4: $next_probation_date = $probation_dates["probation_date_5"];    break;
                                        case 5: $next_probation_date = NULL;            break;
                                        default: $next_probation_date = "NO DATE";      break;
                                    }

                                    switch($probation_no){
                                        case 0: $row_color = $days > 30-15      ?   ($days > 30 ? "red" : "orange")   :   "light_blue"; $waring = $days > 30-15        ?   ($days > 30  ? "OVERDUE" : "UPCOMMING")   :   "OK"; break;
                                        case 1: $row_color = $days > 90-15      ?   ($days > 90 ? "red" : "orange")   :   "light_blue"; $warning = $days > 90-15       ?   ($days > 90  ? "OVERDUE" : "UPCOMMING")   :   "OK"; break;
                                        case 2: $row_color = $days > 150 - 30   ?   ($days > 150 ? "red" : "orange")  :   "light_blue"; $warning = $days > 150-30      ?   ($days > 150 ? "OVERDUE" : "UPCOMMING")   :   "OK"; break;
                                        case 3: $row_color = $days > 350 - 30   ?   ($days > 350 ? "red" : "orange")  :   "light_blue"; $warning = $days > 350-30      ?   ($days > 350 ? "OVERDUE" : "UPCOMMING")   :   "OK"; break;
                                        case 4: $row_color = $days > 700 - 30   ?   ($days > 700 ? "red" : "orange")  :   "light_blue"; $warning = $days > 700-30      ?   ($days > 700 ? "OVERDUE" : "UPCOMMING")   :   "OK"; break;
                                        case 5: $row_color = "light_blue";  break;
                                        case 6: $row_color = "green";  break;
                                        default: $row_color = "red"; $warning = "OVERDUE"; break;
                                    }
                                ?>
                                
                                <tr warning = '<?=$warning?>' department = '<?=$department_filter?>' supervisor = '<?=$supervisor_filter?>'>
                                    <td class = 'lefttext' style = 'border-right:1px solid #454545;'><?=$employee?></td>
                                    <td class = 'lefttext' style = 'border-right:1px solid #454545;'><?=get_emp_name($employee)?></td>
                                    <td class = 'lefttext' style = 'border-right:1px solid #454545;'><?=get_emp_dept_name($employee)?></td>
                                    <td class = 'lefttext' style = 'border-right:1px solid #454545;'><?=get_emp_supervisor($employee)?></td>
                                    <td class = 'lefttext' style = 'border-right:1px solid #454545;'><?=$start_date?></td>
                                    <td class = 'lefttext' style = 'border-right:1px solid #454545;'><?=$probation_no?></td>
                                    <td class = 'lefttext' style = 'border-right:1px solid #454545;'><?=$next_probation_date?></td>
                                    <td style = 'background-color: #454545;'></td>
                                    <?php for($i = 0; $i < 750; $i++):
                                        $color = $i < $days ? $row_color : "light_grey"?>
                                        <?php
                                            switch($i){
                                                case 30: $color = "black"; break;
                                                case 90: $color = "black"; break;
                                                case 150: $color = "black"; break;
                                                case 350: $color = "black"; break;
                                                case 700: $color = "black"; break;
                                                default: $color = $color;
                                            }
                                        ?>
                                        <td style = "width:<?=54/750?>%">   <div style = "height:20px; margin:0; border:0;" class = "<?=$color?>"></div></td>
                                    <?php endfor;?>                                 
                                </tr>
                                <?php $row++; ?>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <div id = "table_pages_footer" class = "footer">
                    <div id = "top">
                        <div id = "filter_container">
                            <div id = "filters" class = "red fill rounded">
                                <div class = "filter">
                                    <div class = "text">
                                        <button class = "fill red medium wtext">Seach Table</button>
                                    </div>
                                    <div class = "content">
                                        <input class = "medium" id = "employee" type = "text">
                                    </div>
                                </div>
                                <div class = "filter">
                                    <div class = "text">
                                        <button class = "fill red medium wtext">Department</button>
                                    </div>
                                    <div class = "content">
                                        <select id = "select_department" class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                            <?php generate_filter_options($full_emp_list, 'emp_dept_name'); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class = "filter">
                                    <div class = "text">
                                        <button class = "fill red medium wtext">Supervisor</button>
                                    </div>
                                    <div class = "content">
                                        <select id = "select_supervisor" class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                            <?php generate_filter_options($full_emp_list, "emp_supervisor"); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class = "filter">
                                    <div class = "text">
                                        <button class = "fill red medium wtext">Notifications</button>
                                    </div>
                                    <div class = "content">
                                        <select id = "select_warning" class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                            <option value = "OVERDUE" selected>Overdue</option>
                                            <option value = "UPCOMMING" selected>Upcomming</option>
                                            <option value = "OK" selected>Ok</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id = "bottom">                        
                        <div id = "button_container">
                            <button class = "grouping_page_corner_buttons fill medium light_blue wtext rounded">UNUSED</button>
                        </div>
                        <div id = "button_container_wide">
                            <button onclick = "location.href='../../MAIN MENU/dashboard_menu.php'" class = "grouping_page_corner_buttons fill medium purple wtext rounded">MAIN MENU</button>
                        </div>
                        <div id = "button_container">
                            <button onclick = "export_to_excel('employee_balance')" class = "grouping_page_corner_buttons fill medium green wtext rounded">EXCEL</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>