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
    //$hash = "$2y$10$9i0l3Vv59STI5.Gj5efkP.pUQ3YL/498shkn6au3MOPwZteZMBNFm";
    //if(isset($_POST['password']) && password_verify(isset($_POST['password']) ? $_POST['password'] : '', $hash)){
    //    $_SESSION['logged_in'] = 1;
    //}
    //elseif(isset($_POST['password']) && !password_verify(isset($_POST['password'])? $_POST['password'] : '', $hash)){
    //    $_SESSION['logged_in'] = 0;
    //    header("Location:enter_password.php?message=Access Denied");
    //}
    //else{
    //    $_SESSION['logged_in'] = 0;
    //    header("Location:enter_password.php?message=Access Denied");
    //}
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
        <?php 
            $page_description = 
            "THIS PAGE LISTS ALL EMPLOYEES CURRENTLY IN THE REVIEW STAGE (START DATE WITHIN 2 YEARS) \n\n

            THERE ARE 5 REVIEW STAGES \n
            1 => PROBATION 1 AT 30 DAYS\n
            2 => PROBATION 2 AT 90 DAYS\n
            3 => PROBATION 3 AT 150 DAYS\n
            4 => FULL TIME REVIEW 1 AT 350 DAYS\n
            4 => FULL TIME REVIEW 2 AT 700 DAYS\n\n

            ALL EMPLOYEES HERE LONGER THAN 750 DAYS AND COMPLETED REVIEW 5 WILL NO LONGER APPEAR ON THIS LIST\n\n

            EVERY EMPLOYEE IS CATAGORISED INTO 3 CATEGORIES\n\n

            1 => OVERDUE   => WHEN AN EMPLOYEE HAS GONE PAST THIER NEXT REVIEW DATE
            2 => UPCOMMING => WHEN AN EMPLOYEE HAS A REVIEW DUE IN THE NEXT COUPLE OF WEEKS
            3 => OK        => EMPLOYEE IS NOT OVERDUE OR DUE FOR REVIEW

            ";        
        ?>

        <!-- TABLESORTER INITALISATION -->
        <script>
            $(function() {
                $(".sortable").tablesorter({
                    theme : "blackice",
                    dateFormat : "ddmmyyyy",
                    headers : { 4: {sorter: "shortdate"},
                                6: {sorter: "shortdate"} }
                });
            });
        </script>
    </head>
    <body>
        <div id = "background">
            <div id = "content">
                <div class = "table_title green">
                    <div style = "height:80%; width:50px; float:left; position:relative; top:10%; margin-left:5px; background-color:white; border-radius:5px;" onclick = "alert('<?=$page_description?>');"><img class = "fill" src = "../../../RESOURCES/info_icon.svg"></div>
                    <h1>STAFF PROBATION PERIOD</h1>
                </div>
                <div id = "pages_table_container" class = "table_container" style = "overflow-y:scroll">
                    <table id = "employee_balance" class = "white btext filterable sortable searchable">
                        <thead>
                            <tr class = "dark_grey wtext smedium head">
                                <th width = "5%" class = "lefttext">Staff Number</th>
                                <th width = "11%" class = "lefttext">Employee Name</th>
                                <th width = "11%" class = "lefttext">Department</th>
                                <th width = "11%" class = "lefttext">Supervisor</th>
                                <th width = "2%" class = "lefttext"></th>
                                <th width = "10%" class = "lefttext">Start Date</th>
                                <th width = "10%" class = "lefttext">30 Days</th>
                                <th width = "10%" class = "lefttext">90 Days</th>
                                <th width = "10%" class = "lefttext">150 Days</th>
                                <th width = "10%" class = "lefttext">350 Days</th>
                                <th width = "10%" class = "lefttext">700 Days</th>
                            </tr>
                        </thead>
                        <tbody class = "smedium">
                            <!-- WHILE WE HAVE NOT REACHED END OF DATA ON SPREADSHEET PRINT ROWS WITH ASSIGEND DOM VALUES AND SUBSEQUENCT TABLE DATA FOR ROW FROM EACH ROW IN SPREADSHEET-->
                            <!-- IF AN EMPLOYEE IS LISTED ON THE SPREADSHEET BU NOT ON THE MASTER DATA SKIP TO THE NEXT ROW ON SPREADSHEET WITHOUT PRINTING ANYTHING -->
                            <?php  while($spreadsheet->getActiveSheet()->getCell('A'.$row)->getValue() != ''):  ?>

                                <?php $employee = (int)$spreadsheet->getActiveSheet()->getCell('A'.$row)->getValue()?>

                                <?php $supervisor_filter = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', get_emp_supervisor($employee))); ?>
                                <?php $department_filter = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', get_emp_dept_name($employee))); ?>
                                <?php $start_date = convert_serial_date($spreadsheet->getActiveSheet()->getCell('BB'.$row)->getValue());?>
                                
                                <?php if(get_day_difference($start_date) > 700){$row++; continue;}?>
                                <tr department = '<?=$department_filter?>' supervisor = '<?=$supervisor_filter?>'>
                                    <td class = 'lefttext' style = 'border-right:1px solid #454545;'><?=$employee?></td>
                                    <td class = 'lefttext' style = 'border-right:1px solid #454545;'><?=get_emp_name($employee)?></td>
                                    <td class = 'lefttext' style = 'border-right:1px solid #454545;'><?=get_emp_dept_name($employee)?></td>
                                    <td class = 'lefttext' style = 'border-right:1px solid #454545;'><?=get_emp_supervisor($employee)?></td>
                                    <td style = 'background-color: #454545;'></td>
                                    <td style = 'border-right:1px solid #454545; background-color:lightblue'><?= $start_date;?></td>
                                    <td class = '<?= get_day_difference(add_days_to_date($start_date,30)) > -15 ? "orange" : "baige"?>' style = 'border-right:1px solid #454545;'><?= add_days_to_date($start_date,30)?></td>
                                    <td class = '<?= get_day_difference(add_days_to_date($start_date,90)) > -15 ? "orange" : "baige"?>' style = 'border-right:1px solid #454545;'><?= add_days_to_date($start_date,90)?></td>
                                    <td class = '<?= get_day_difference(add_days_to_date($start_date,150)) > -30 ? "orange" : "baige"?>' style = 'border-right:1px solid #454545;'><?= add_days_to_date($start_date,150)?></td>
                                    <td class = '<?= get_day_difference(add_days_to_date($start_date,350)) > -30 ? "orange" : "baige"?>' style = 'border-right:1px solid #454545;'><?= add_days_to_date($start_date,350)?></td>
                                    <td class = '<?= get_day_difference(add_days_to_date($start_date,700)) > -30 ? "orange" : "baige"?>' style = 'border-right:1px solid #454545;'><?= add_days_to_date($start_date,700)?></td>
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
                                        <button class = "fill red medium wtext">UNUSED</button>
                                    </div>
                                    <div class = "content">
                                        <select class = "selector fill medium">
                                            <option value = "All" selected>All</option>
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