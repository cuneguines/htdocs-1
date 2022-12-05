<!-- 
    TABLE OF HOLIDAY BALANCES FOR EACH EMPLOYEE. DATA IS READ FROM A EXCEl SPREADSHEET STORED IN WEB SERVER CAHCE WHICH IS UPDATED BY CLICKING UPDATE IN THE BOTTOM LEFT OF PAGE WHICH PULLS THE MSOT UP TO DATE DATA FROM THE MAIN SERVER ON REUEST.
    THE EMPLOYEE NAME, DEPARTMENT AND SUPERVISOR ARE NOT READ FROM THE BALANCE SPREADSHEET IN CAHCE, INSTEAD THEY ARE READ FROM A MASTER SHEEET, SEE phpspreadsheets_lookup_data.php IN THE PHP FUNCTIONS FOLDER FOR LOOKUP FUNCTIONS.
    THE PAGE INCLUDES A SEARCH TABLE FUNCTION AND THREE FILTERS. THERE IS ALSO A FACILITY TO EXPORT DATA.
-->
<?php
    // READ IN LIBS
    require '../../../PHP LIBS/phpspreadsheets/vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    include '../../../PHP LIBS/PHP FUNCTIONS/phpspreadsheets_lookup_data.php';

    // IF UPDATE DATA IS CLICKED
    if(isset($_GET["UPDATE"])){
        // DELETE CONTENTS OF CACHE FOLDER
        $files = glob('./CACHE'.'/*');
        foreach($files as $file){
            if(is_file($file)){
                unlink($file);
            }
        }

        // FIND NEWEST FILE IN H: DRIVE HOLIDAY BALANCE FOLDER FOLDER AND LOAD TO VARIABLE
        $inputFileNames = scandir('C://VMS_MASTER_DATA/HR_EMP_DATA/EMP_HOL_BAL/', SCANDIR_SORT_DESCENDING);
        $spreadsheet = $reader->load('C://VMS_MASTER_DATA/HR_EMP_DATA/EMP_HOL_BAL/'.$inputFileNames[0]);

        // SAVE THE VARIABLE TO OWN CACHE AS EXCEL FILE
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save("./CACHE/data.xlsx");
    }
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
    elseif(isset($_GET['UPDATE'])){
        $_SESSION['logged_in'] = 0;
        header("Location:enter_password.php?message=Reenter Password After Data Refresh");
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
            $spreadsheet = $reader->load('./CACHE/data.xlsx');
            $spreadsheet->setActiveSheetIndex(0);
            $row = 6;
        ?>

        <!-- TABLESORTER INITALISATION -->
        <script>
            $(function() {
                $(".sortable").tablesorter({
                    theme : "blackice",
                    dateFormat : "ddmmyyyy",
                    headers : { 4: {sorter: false} }
                });
            });
        </script>
    </head>
    <body>
        <div id = "background">
            <div id = "content">
                <div class = "table_title green">
                    <div style = "height:80%; width:50px; float:left; position:relative; top:10%; margin-left:5px; background-color:white; border-radius:5px;" onclick = "alert('message');"><img class = "fill" src = "../../../RESOURCES/info_icon.svg"></div>
                    <h1>STAFF HOURS BALANCE <?= $spreadsheet->getActiveSheet()->getCell('E3')->getValue(); ?></h1>
                </div>
                <div id = "pages_table_container" class = "table_container" style = "overflow-y:scroll">
                    <table id = "employee_balance" class = "white btext filterable sortable searchable">
                        <thead>
                            <tr class = "dark_grey wtext smedium head">
                                <th width = "5%" class = "lefttext">Staff Number</th>
                                <th width = "8%" class = "lefttext">Employee Name</th>
                                <th width = "8%" class = "lefttext">Department</th>
                                <th width = "8%" class = "lefttext">Supervisor</th>
                                <th width = "2%" class = "lefttext"></th>
                                <th width = "8%" class = "lefttext">Left to Take</th>
                                <th width = "8%" class = "lefttext">Carried Forward</th>
                                <th width = "9%" class = "lefttext">Earned</th>
                                <th width = "9%" class = "lefttext" >Total Earned</th>
                                <th width = "9%" class = "lefttext">Taken</th>
                                <th width = "9%" class = "lefttext">Adjustment</th>
                                <th width = "8%" class = "lefttext">Balance</th>
                                <th width = "9%" class = "lefttext">Planned</th>
                            </tr>
                        </thead>
                        <tbody class = "smedium">
                            <!-- WHILE WE HAVE NOT REACHED END OF DATA ON SPREADSHEET PRINT ROWS WITH ASSIGEND DOM VALUES AND SUBSEQUENCT TABLE DATA FOR ROW FROM EACH ROW IN SPREADSHEET-->
                            <!-- IF AN EMPLOYEE IS LISTED ON THE SPREADSHEET BU NOT ON THE MASTER DATA SKIP TO THE NEXT ROW ON SPREADSHEET WITHOUT PRINTING ANYTHING -->
                            <?php  while($spreadsheet->getActiveSheet()->getCell('B'.$row)->getValue() != 'Overall Total'):  ?>
                                
                               
                                <?php $employee = (int)$spreadsheet->getSheet(0)->getCell('A'.$row)->getValue()?>
                                <!-- Removed Management team from the list. -->
                                <?php if(!check_emp_on_master($employee)){$row++; continue;} ?>
                                <?php if(get_emp_dept_name($employee)=='Management Team')
                                {$row++; continue;} ?>
                              
                               


                                <?php $supervisor_filter = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', get_emp_supervisor($employee))); ?>
                                <?php $department_filter = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', get_emp_dept_name($employee))); ?>

                                <tr department = '<?=$department_filter?>' supervisor = '<?=$supervisor_filter?>'>
                                    <td class = 'lefttext' style = 'border-right:1px solid #454545;'><?=$employee?></td>
                                    <td class = 'lefttext' style = 'border-right:1px solid #454545;'><?=get_emp_name($employee)?></td>
                                    <td class = 'lefttext' style = 'border-right:1px solid #454545;'><?=get_emp_dept_name($employee)?></td>
                                    <td class = 'lefttext' style = 'border-right:1px solid #454545;'><?=get_emp_supervisor($employee)?></td>
                                    <td style = 'background-color: #454545;'></td>

                                    <td style = 'border-right:5px solid #454545;'><?=$spreadsheet->getActiveSheet()->getCell('J'.$row)->getValue()?></td>
                                    <td style = 'border-right:1px solid #454545;'><?=$spreadsheet->getActiveSheet()->getCell('C'.$row)->getValue()?></td>
                                    <td style = 'border-right:5px double #454545;'><?=$spreadsheet->getActiveSheet()->getCell('D'.$row)->getValue()?></td>
                                    <td style = 'border-right:1px solid #454545;'><?=$spreadsheet->getActiveSheet()->getCell('E'.$row)->getValue()?></td>
                                    <td style = 'border-right:1px solid #454545;'><?=$spreadsheet->getActiveSheet()->getCell('F'.$row)->getValue()?></td>
                                    <td style = 'border-right:5px double #454545;'><?=$spreadsheet->getActiveSheet()->getCell('G'.$row)->getValue()?></td>
                                    <td style = 'border-right:1px solid #454545;'><?=$spreadsheet->getActiveSheet()->getCell('H'.$row)->getValue()?></td>
                                    <td><?=$spreadsheet->getActiveSheet()->getCell('I'.$row)->getValue()?></td>
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
                            <button onclick = "location.href='BASE_staff_holiday_balance.php?UPDATE=1'" class = "grouping_page_corner_buttons fill medium light_blue wtext rounded">UPDATE</button>
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