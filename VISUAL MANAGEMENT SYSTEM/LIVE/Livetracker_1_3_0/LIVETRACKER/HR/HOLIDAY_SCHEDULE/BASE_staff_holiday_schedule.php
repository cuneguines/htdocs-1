<!--
    CALANDER TABLE OF WHEN EMPLOYEES HAVE BOOKED TIME OFF AND SHORT REASON.
    INCLUDES MONDAY TO FRIDAY FOR NEXT 8 WEEKS FROM 8 SERPEATE SPREADSHEETS (TIMEPOINT CAN ONLY HAVE 1 WEEK OF DATA PER EXPORT SO WE WE GIVE THE SHEETS A WEEK NUMBER AND NUMBER THEM ACCORINGILY 1 TO 8 1 BEING THIS WEEK AND 8 BEING 8 WEEKS AHEAD)
    DATA IS READ FROM A EXCEl SPREADSHEET STORED IN WEB SERVER CAHCE WHICH IS UPDATED BY CLICKING UPDATE IN THE BOTTOM LEFT OF PAGE WHICH PULLS THE MSOT UP TO DATE DATA FROM THE MAIN SERVER ON REUEST.
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
        
        // FIND MOST RECENT WEEK IN SCHEDULE FILES (MUST MATCH "WXX_X") (EXAMPLE: FILES NAMES FOR WEEK 15 = W15_1, W15_2, W15_3, ... , W15_8)
        $j = 0;
        $directory_contents = scandir('C://VMS_MASTER_DATA/HR_EMP_DATA/EMP_HOL_SCHEDULE/', SCANDIR_SORT_DESCENDING);
        while(substr($directory_contents[$j], 0, 1) != 'W'){    $j++;   }
        $most_recent_week = substr($directory_contents[$j], 1, 2);
        
        // USING WEEK NUMBER PULL THE 8 FILES FROM H: AND SAVE TO OWN CACHE
        for($i = 1; $i <= 8; $i++){
            $inputFileName = "W".$most_recent_week."_".$i.".xlsx";
            $spreadsheet = $reader->load('C://VMS_MASTER_DATA/HR_EMP_DATA/EMP_HOL_SCHEDULE/'.$inputFileName);
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save("./CACHE/"."W".$most_recent_week."_".$i.".xlsx");
        }
    }
?>
<?php
    // SECURITY
    // IF PASSWORD IS SUBMITTED AND CORRECT ALLOW TO CONTINUE
    // IF PASSWORD IS SUBMITTED AND INCORRECT REDIVERT TO LOGIN PAGE WITH ERROR MESSAGE
    // IF UPDATE DATA OPTION IS CLICKED REDIVERT TO LOGIN PAGE AND ASK FOR PASSWORD AGAIN
    // OTHERWISE REDIVERT TO LOGIN PAGE
    session_start();
    $hash = "$2y$10$9i0l3Vv59STI5.Gj5efkP.pUQ3YL/498shkn6au3MOPwZteZMBNFm"; 
    if(isset($_POST['password']) && password_verify(isset($_POST['password'])? $_POST['password'] : '', $hash)){
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
        <meta charset = "utf-8">
        <meta name = "viewpport" content = "width=device-width, initial-scale = 1">

        <!-- EXTERNAL JS DEPENDANCIES -->
        <script type = "text/javascript" src = "../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>				
        <script type = "text/javascript" src = "../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
        <script type = "text/javascript" src = "../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

        <!-- LOCAL JS -->
        <script type = "text/javascript" src = "../../../JS LIBS/LOCAL/JS_filters.js"></script>
        <script type = "text/javascript" src = "../../../JS LIBS/LOCAL/JS_search_table.js"></script>
		<script type = "text/javascript" src = "./JS_table_to_excel.js"></script>

        <!-- STYLEING -->
        <link rel = "stylesheet" href = "../../../css/LT_STYLE.css">
        <link rel = "stylesheet" href = "../../../css/theme.blackice.min.css">									
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

        <!-- PHP INITALISATION -->
        <?php include '../../../PHP LIBS/PHP FUNCTIONS/php_functions.php' ?>
        <?php
            // GETS WEEK NUMBER OF SCHEDULE DATA IN CACHE
            $j = 0;
            $directory_contents = scandir('./CACHE/', SCANDIR_SORT_DESCENDING);
            while(substr($directory_contents[$j], 0, 1) != 'W' && $j < sizeof($directory_contents)){    $j++;   }
            $most_recent_week = substr($directory_contents[$j], 1, 2);
       
            // PULL SPREADSHEETS FROM CAHCE AND STORE
            $spreadsheets = array();
            for($i = 1 ; $i <= 8; $i++){
                $inputFileName = "W".$most_recent_week."_".$i.".xlsx";
                $spreadsheet = $reader->load('./CACHE/'.$inputFileName);
                array_push($spreadsheets, $reader->load('./CACHE/'.$inputFileName));
            }
        ?>
        <!-- TABLESORTER INITALISATION -->
        <script>
            $(function() {
                $("table.sortable").tablesorter({
                    theme : "blackice",
                    dateFormat : "ddmmyyyy",
                    headers : {
                        4:{sorter: false},  10:{sorter: false}, 16:{sorter: false},
                        22:{sorter: false}, 28:{sorter: false}, 34:{sorter: false},
                        40:{sorter: false}, 46:{sorter: false}
                    }
                });
            });
        </script>
    </head>
    <body>
        <div id = "background">
            <div id = "content">
                <div class = "table_title green">
                    <h1>STAFF HOLIDAY CALANDER</h1>
                </div>
                <div id = "pages_table_container" class = "table_container modified" style = "overflow-y:scroll; overflow-x:scroll;">
                    <table id = "employee_absences_schedule" class = "sortable filterable searchable">
                        <thead class = "smedium wtext">
                            <tr class = "head">
                                <th width = "80px"  class = "sticky darker_grey" style = "left:0px;">Staff Number</th>
                                <th width = "160px" class = "sticky darker_grey" style = "left:80px;">Employee Name</th>
                                <th width = "160px" class = "sticky darker_grey" style = "left:240px;">Department</th>
                                <th width = "160px" class = "sticky darker_grey" style = "left:400px;">Supervisor</th>
                                <!-- ECHO MONDAY TO FIRDAY 8 TIMES 1 FOR EACH WEEK OF DATA INCLUDED (1 WEEK PER SPREADSHEET)-->
                                <?php for($i = 0 ; $i < 8; $i++): ?>
                                    <td class = "sticky red" style = 'width:50px; z-index:+4; left:560px;'><?=($most_recent_week+$i)?></td>
                                    <td class = "dark_grey sticky">Mon</td>
                                    <td class = "dark_grey sticky">Tue</td>
                                    <td class = "dark_grey sticky">Wed</td>
                                    <td class = "dark_grey sticky">Thur</td>
                                    <td class = "dark_grey sticky">Fri</td>
                                <?php endfor; ?>
                            </tr>
                        </thead>
                        <tbody class = "btext smedium">
                        <?php
                                $base_row = 6;              // ROW ON FIRST SHEET (STARTS AT SIX)
                                $base_row_index = 6;        // ROW INDEX OF EMPLOYEE FROM SHEET 0 ON OTHER SHEETS
                                $sheet = 0;                 // CURRENT SHEET - SET TO ZERO INITALLY
                        ?>
                        <!-- WHILE THE END OF THE FIRST SHEET HAS NOT BEEN REACHED -->
                        <?php while($spreadsheets[0]->getSheet(0)->getCell('A'.$base_row)->getValue()) :?>
                            <?php
                                // GET EMP NUMBER OF CURRENT ROW
                                $emp_number = $spreadsheets[0]->getSheet(0)->getCell('A'.$base_row)->getValue(); 

                                // IF THE CURRENT EMPLOYEE DOES NOT APPEAR ON THE MASTER SKIP TO THE NEXT LINE (EMPLOYEE)
                                if(!check_emp_on_master($emp_number)){$base_row++; continue;}

                                // GET SUPERVISOR AND DEPARTMENT OF EMPLOYEE + PROCESS IT FOR JAVASCRIPT FILTERING (NO NON ALPHANUMERIC CHARACTERS)
                                $supervisor = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', get_emp_supervisor($emp_number)));
                                $department = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', get_emp_dept_name($emp_number)));
                            ?>

                            <!-- START OF TABLE ROW AND MAIN EMPLOYEE DETAILS -->
                            <tr department = '<?=$department?>' supervisor = '<?=$supervisor?>'>
                                <th class='light_grey sticky' style = "left:0px;"><?=$emp_number?></th>
                                <th class='light_grey sticky' style = "left:80px;"><?=get_emp_name($emp_number)?></th>
                                <th class='light_grey sticky' style = "left:240px;"><?=get_emp_dept_name($emp_number)?></th>
                                <th class='light_grey sticky' style = "left:400px;"><?=get_emp_supervisor($emp_number)?></th>
                                <td class = 'dark_grey sticky' style = 'left:560px;'></td>
                                <?php
                                    /* 
                                        PRINTS MONDAY TO FRIDAY ABSENTEES DETAILS FOR EMPLOYEE
                                        NEXT, SEARCHES FOR CURRENT EMPLOYEE ON WEEK 2 SPREADSHEET AND PRINTS MONDAY TO FRIDAY ON SAME LINE
                                        DOES THIS FOR EVERY WEEK 1 - 8
                                    */

                                    // START CELL
                                    $cell = 'D';

                                    // RESET DAY OF WEEK TO 1
                                    $daycount = 1;
    
                                    // RESET SHEET TO ZERO
                                    $sheet = 0;
    
                                    // START AT ONE AND EXTEND TO 56 - 7 DAYS BY 8 WEEKS
                                    for($i = 1 ; $i < 56 ; $i++)
                                    {
                                        // IF DAY ENTIERLY DIVISABLE BY SIX (SATURDAY) DONT DO ANYTHING JUST INCREMENT DAY
                                        if($daycount%6 == 0){
                                            $daycount++;
                                        }

                                        // IF DAY IS AT END OF WEEK
                                        else if($daycount%7 == 0){

                                            // PRINT WEEK DIVIDOR FOR CURRENT ROW
                                            echo "<td class = 'dark_grey'></td>";

                                            // RESET DAY OF WEEK TO ZERO AND CELL BACK TO D
                                            $daycount=1;
                                            $cell = 'D';

                                            // INCREMENT SHEET FOR NEXT WEEKS DATA (NEXT SHEET (1...8))
                                            $sheet++;
    
                                            // SCAN SHEET FOR THE CURRENT EMPLOYEE AND WHAT INDEX THEY ARE ON THE CURRENT SHEET - START AT 6 
                                            $index_scanner = 6;
                                            while($spreadsheets[$sheet]->getSheet(0)->getCell('A'.$index_scanner)->getValue())
                                            {
                                                // WHEN IT FINDS THE ACTIVE EMPLOYEE
                                                if($spreadsheets[$sheet]->getSheet(0)->getCell('A'.$index_scanner)->getValue() == $emp_number)
                                                {
                                                    // SET ITS INDEX FOR THE CURRENT SHEET (WEEKS DATA)
                                                    $base_row_index = $index_scanner;
                                                }
                                                $index_scanner++;
                                            }
                                        }

                                        // IF DAY OF WEEK IS 1 TO 5
                                        else
                                        {
                                            // PRINT DETAILS OF DAY FOR EMPLOYEE BY COLUMN D-H = DAY AND ROW FOR EMPLOYEE  
                                            if($spreadsheets[$sheet]->getSheet(0)->getCell($cell.$base_row_index)->getValue()){
                                                echo "<td ".($daycount%2 == 0 ? "class = 'light_grey'" : "class = 'white'").">".get_ref_abreviation($spreadsheets[$sheet]->getSheet(0)->getCell($cell.$base_row_index)->getValue())."</td>";
                                            }
                                            else{
                                                echo "<td ".($daycount%2 == 0 ? "class = 'light_grey'" : "class = 'white'")."></td>";
                                            }
                                            // IMCREMENT DAY COUNT AND CELL
                                            $daycount++;
                                            $cell++;
                                        }
                                        // END OF LOOP NEXT ITERATION WILL MOVE TO NEXT EMPLOYEE ON SHEET ZERO
                                    }
                                ?>
                            </tr>
                            <?php
                                // AT THE END OF PRINTINT 8 WEEKS OF DATA FOR ONE EMPLOYEE RESET EVERYTHING 
                                $base_row++;
                                $base_row_index = $base_row;
                                $emp_number = $spreadsheets[0]->getSheet(0)->getCell('A'.$base_row)->getValue();
                            ?>
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
                                            <?php generate_filter_options($full_emp_list, "emp_dept_name");?>
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
                                            <?php generate_filter_options($full_emp_list, "emp_supervisor");?>
                                        </select>
                                    </div>
                                </div>
                                <div class = "filter">
                                    <div class = "text">
                                        <button class = "fill red medium wtext">UNUSED</button>
                                    </div>
                                    <div class = "content">
                                        <select id = "select_sales_person" class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id = "bottom">                       
                        <div id = "button_container">
                            <button onclick = 'location.href="BASE_staff_holiday_schedule.php?UPDATE=1"' class = "grouping_page_corner_buttons fill medium light_blue wtext rounded">UPDATE</button>
                        </div>
                        <div id = "button_container_wide">
                            <button onclick = "location.href='../../MAIN MENU/dashboard_menu.php'" class = "grouping_page_corner_buttons fill medium purple wtext rounded">MAIN MENU</button>
                        </div>
                        <div id = "button_container">
                            <button onclick = "export_to_excel('employee_absences_schedule')" class = "grouping_page_corner_buttons fill medium green wtext rounded">EXCEL</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>