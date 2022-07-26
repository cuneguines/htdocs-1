<?php
    /*
        TABLE OF EMPLOYEE CLOCKS FOR A MONTH. TABLE CONTAINS SLCOCKING DETAIL FOR EACH DAY AND A SUMMARY LINE FOR THE MONTH, THE CLOCKING DETAIL PER DAY IS HIDDEN BY DEFAULT AND CAN ONLY BE SHOWN BY LOOKING AT EACH EMPLOYEE INDIVIDUALLY
        OR SELECTING THE PIVOTT OPTION FOR EXPORTS. THE TABLE CAN BE FILTERED BY DEPARTMENT, SUPERVISOR AND EMPLOYEE
    */
    // READ IN LIBS   
    require '../../../PHP LIBS/phpspreadsheets/vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $month_names = array(NULL,'JAN','FEB','MAR','APR','MAY','JUN','JUL','AUG','SEPT','OCT','NOV','DEC');

    // IF UPDATE DATA IS CLICKED
    if(isset($_GET["UPDATE"])){

        // DELETE CONTENTS OF CACHE FOLDER
        $files = glob('./CACHE'.'/*');
        foreach($files as $file){
            if(is_file($file)){
                unlink($file);
            }
        }

        // CUSTOM SCAN DIR (CANT REMEMBER WHY I DID THIS)
        function scan_dir($dir){
            $ignored = array('.', '..', '.svn', '.htaccess');

            $files = array();    
            foreach (scandir($dir) as $file) {
                if (in_array($file, $ignored)) continue;
                    $files[$file] = filemtime($dir . '/' . $file);
            }
            arsort($files);
            $files = array_keys($files);

            return ($files) ? $files : false;
        }
             
        // LOAD FILES FROM SERVER AND STORE TO OWN CACHE
        $inputFileNames = scan_dir('C://VMS_MASTER_DATA/HR_EMP_DATA/CLOCKING/');
       // print_r($inputFileNames);
 

        foreach($inputFileNames as $fname){
            $sh = $reader->load('C://VMS_MASTER_DATA/HR_EMP_DATA/CLOCKING/'.$fname);
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($sh);
            $writer->save("./CACHE/".$fname);
        }
        // REDIVERT TO LOGIN WITH MESSAGE (STOPS PAGE ACCESS BY ATTEMPTIN TO SKIP AND UNDLUDE UPDATE IN URL MANUALLY) 
        header("Location:enter_password.php?message=Reenter Password After Data Refresh");
    }
   
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- INITALISATION AND META STUFF -->
        <title>TABLE LAYOUT</title>
        <meta name = "viewpport" content = "width=device-width, initial-scale = 1">

        <!-- EXTERNAL JS DEPNDANCIES -->
        <script type = "text/javascript" src = "../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>				
        <script type = "text/javascript" src = "../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
        <script type = "text/javascript" src = "../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

        <!-- LOCAL JS -->
        <script type = "text/javascript" src = "./JS_hr_clock_month_selector.js"></script>
        <script type = "text/javascript" src = "./JS_filters_page_specific.js"></script>
		<script type = "text/javascript" src = "./JS_table_to_excel.js"></script>
        <script type = "text/javascript" src = "../../../JS LIBS/LOCAL/JS_search_table.js"></script>

        <!-- STYLING -->
        <link href='../../../CSS/LT_STYLE.css' rel='stylesheet' type='text/css'>
        <link rel = "stylesheet" href = "../../../css/theme.blackice.min.css">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
        
        <!-- PHP DEPENDANCIES -->
        <?php   include '../../../PHP LIBS/PHP FUNCTIONS/php_functions.php';    ?>
        <?php   include '../../../PHP LIBS/PHP FUNCTIONS/phpspreadsheets_lookup_data.php'; ?>
        <?php
            if(isset($_POST['month'])){
                $fname = $_POST['month'];
            }
            $spreadsheet = $reader->load('./CACHE/'.$fname);
        ?>
    </head>
    <body>
        <div id = "background">
            <div id = "content">
                <div class = "table_title green">
                    <h1>STAFF CLOCKING SUMMARY FOR <?=substr($fname,5,-5)." ".(substr($fname,5,-5) == 'Sept' ? substr($fname,0,-10) : substr($fname,0,-9))?></h1><!-- MONTH AND YEAR EXTRACTED FROM FILENAME AS SUBSTRING (SEPT IS SPECIAL CASE AS IT CONTAINS 4 LETTERS) -->
                </div>
                <div id = "pages_table_container" class = "table_container" style = "overflow-y:scroll">
                    <table id = "employee_clocking" class = "btext filterable">
                        <thead>
                            <tr class = "dark_grey wtext smedium head" style = "z-index:+2;">
                                <th class = "supp_data" style = "display:none;" width = "5%">Day</th>
                                <th class = "supp_data" style = "display:none;" width = "5%">Date</th>
                                <th width = "10%">Employee</th>
                                <th width = "4%">Roster Start</th>
                                <th class = "supp_data" style = "display:none;" width = "4%">Actual Start</th>
                                <th width = "2%">L IN</th>
                                <th width = "4%">Roster End</th>
                                <th class = "supp_data" style = "display:none;" width = "4%">Actual End</th>
                                <th width = "2%">E OUT</th>
                                <th width = "6%">Expected Attendance</th>
                                <th width = "6%">Expected Paid Attendance</th>
                                <th width = "6%">Rounded Attendance</th>
                                <th width = "6%">Unpaid Absence</th>
                                <th width = "6%">Break Duration</th>
                                <th width = "6%">Basic Hours Paid</th>
                                <th width = "6%">Holidays Paid</th>
                                <th width = "6%">Total Basic Time Paid</th>
                                <th width = "6%">Overtime 1.5</th>
                                <th width = "6%">Overtime 2.0</th>
                                <th width = "6%">Total Paid Hours</th>
                            </tr>
                        </thead>
                        <tbody class = "smedium">
                            <?php
                                $row =  7;
                                $avg_start_time_seconds_buff = $avg_finish_time_seconds_buff = $avg_roster_start_time_seconds_buff = $avg_roster_finish_time_seconds_buff = array();
                                $late_ins_buff = $early_outs_buff = $expected_attendance_month = $expected_paid_attendance_month = $rounded_attendance_month = $unpaid_absence_month = $break_duration_month = $basic_hours_month = $overtime_1_5_month = $overtime_2_0_month = $holidays_month = $total_basic_paid_time = $total_paid_time_time = 0;
                            ?>
                            <?php
                                $current_employee = explode(" ",$spreadsheet->GetActiveSheet()->getCell('C'.$row)->getValue())[0];
                                $current_employee_name = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', get_emp_name($current_employee)));
                                $current_dept = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', get_emp_dept_name($current_employee)));
                                $current_supervisor = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', get_emp_supervisor($current_employee)));
                            ?>
                            
                            <?php while($spreadsheet->GetActiveSheet()->getCell('C'.$row)->getValue() != ''):?>

                                <!-- IF NAME IN CELL IS EMPTY SKIP ROW (SKIPS INTERMEDIATE TOTAL ROWS IN EXCEL SHEET)-->
                                <?php if($spreadsheet->GetActiveSheet()->getCell('C'.$row)->getValue() == 'Total'){$row+=1; continue;} ?>

                                <!-- WHEN THE NEW ENTRY ON THE SPREADSHEET IS OF A DIFFERENT EMPLOYEE CALCULATE ROLLING SUMS/AVERAGES PRINT THE TITLE ROW AND RESET THE BUFFERS-->
                                <?php if(explode(" ",$spreadsheet->getActiveSheet()->getCell('C'.$row)->getValue())[0] != $current_employee):?>
                                    
                                    <!-- FIND THE AVERAGE/SUM OF THE BUFFER TIMES (AS INEGERS) FOR PREVIOUS EMPLOYEE AND CONVERT THAT BACK INTO HH:MM FORMAT -->
                                    <?php
                                        $avg_start_time_seconds = count($avg_start_time_seconds_buff) ? round(array_sum($avg_start_time_seconds_buff)/count($avg_start_time_seconds_buff)) : 0;
                                        $avg_finish_time_seconds = count($avg_finish_time_seconds_buff) ? round(array_sum($avg_finish_time_seconds_buff)/count($avg_finish_time_seconds_buff)) : 0;
                                        $avg_roster_start_time_seconds = count($avg_roster_start_time_seconds_buff) ? round(array_sum($avg_roster_start_time_seconds_buff)/count($avg_roster_start_time_seconds_buff)) : 0;
                                        $avg_roster_finish_time_seconds = count($avg_roster_finish_time_seconds_buff) ? round(array_sum($avg_roster_finish_time_seconds_buff)/count($avg_roster_finish_time_seconds_buff)) : 0;
                                        
                                        $avg_start_time_time = integer_seconds_to_duration($avg_start_time_seconds);
                                        $avg_finish_time_time = integer_seconds_to_duration($avg_finish_time_seconds);
                                        $avg_roster_start_time_time = integer_seconds_to_duration($avg_roster_start_time_seconds);
                                        $avg_roster_finish_time_time = integer_seconds_to_duration($avg_roster_finish_time_seconds);
                                        $expected_attendance_time_time = integer_seconds_to_duration($expected_attendance_month);
                                        $expected_paid_attendance_time_time = integer_seconds_to_duration($expected_paid_attendance_month);
                                        $rounded_attendance_time_time = integer_seconds_to_duration($rounded_attendance_month);
                                        $unpaid_absence_time_time = integer_seconds_to_duration($unpaid_absence_month);
                                        $break_duration_time_time = integer_seconds_to_duration($break_duration_month);
                                        $basic_hours_time_time = integer_seconds_to_duration($basic_hours_month);
                                        $overtime_1_5_time_time = integer_seconds_to_duration($overtime_1_5_month);
                                        $overtime_2_0_time_time = integer_seconds_to_duration($overtime_2_0_month);
                                        $holidays_time_time = integer_seconds_to_duration($holidays_month);
                                        $total_basic_paid_time_time = integer_seconds_to_duration($total_basic_paid_time);
                                        $total_paid_time_time = integer_seconds_to_duration($total_basic_paid_time + $overtime_1_5_month + $overtime_2_0_month);
                                    ?>
                                    <?php
                                        $t_basic_color = $total_basic_paid_time >= $expected_paid_attendance_month ? "light_green" : "light_red";
                                        $t_total_color = ($total_basic_paid_time + $overtime_1_5_month + $overtime_2_0_month) >= $expected_paid_attendance_month ? "light_green" : "light_red";
                                    ?>

                                    <!-- ECHO SUMMARY ROW FOR PREVIOUS EMPLOYEE -->
                                    <tr type = 'total' employee = "<?=$current_employee_name?>" department = "<?=$current_dept?>" supervisor = "<?= $current_supervisor?>" month = "<?=$month?>" class = "white btext smedium">
                                        <td class = "supp_data" style = "display:none;">------</td>
                                        <td class = "supp_data" style = "display:none;">------</td>
                                        <td class = "lefttext"><?=$employee?></td>
                                        <td class = "tablebr_solidleft tablebr_dottedright"><?=$avg_roster_start_time_time?></td>
                                        <td class = "supp_data tablebr_dottedleft tablebr_dottedright" style = "display:none;"><?=$avg_start_time_time?></td>
                                        <td class = "tablebr_dottedleft tablebr_solidright"><?=$late_ins_buff?></td>
                                        <td class = "tablebr_solidleft tablebr_dottedright"><?=$avg_roster_finish_time_time?></td>
                                        <td class = "supp_data tablebr_dottedleft tablebr_dottedright" style = "display:none;"><?=$avg_finish_time_time?></td>
                                        <td class = "tablebr_dottedleft tablebr_solidright"><?=$early_outs_buff?></td>
                                        <td class = "tablebr_solidleft tablebr_dottedright"><?=$expected_attendance_time_time?></td>
                                        <td class = "tablebr_dottedleft tablebr_dottedright lighter_green"><?=$expected_paid_attendance_time_time?></td>
                                        <td class = "tablebr_dottedleft tablebr_dottedright"><?= $rounded_attendance_time_time?></td>
                                        <td class = "tablebr_dottedleft tablebr_dottedright"><?= $unpaid_absence_time_time?></td>
                                        <td class = "tablebr_dottedleft tablebr_solidright"><?= $break_duration_time_time?></td>
                                        <td class = "tablebr_solidleft tablebr_dottedright"><?= $basic_hours_time_time?></td>
                                        <td class = "tablebr_dottedleft tablebr_dottedright"><?= $holidays_time_time?></td>
                                        <td class = "tablebr_dottedleft tablebr_solidright <?=$t_basic_color?>"><?= $total_basic_paid_time_time?></td>
                                        <td class = "tablebr_solidleft tablebr_dottedright"><?= $overtime_1_5_time_time?></td>
                                        <td class = "tablebr_dottedleft"><?= $overtime_2_0_time_time?></td>
                                        <td class = "tablebr_dottedleft <?=$t_total_color?>"><?= $total_paid_time_time ?></td>
                                        
                                        
                                    </tr>
                                    <tr type = 'total' employee = "<?=$employee?>" department = "<?=$current_dept?>" month = "<?=$month?>" class = "red wtext smedium" rtype = "emp_detail" style = "display:none; background-color:#130564;"></tr>

                                    <?php
                                        // IF THE EMPLOYEE ON THE ROW IS NOT ON THE MASTER ROLL ON THE ROW NUMBER UNTIL IT REACHES THE FIRST ROW WITH AN EMPLOYEE ON THE MASTER LIST
                                        if(check_emp_on_master(explode(" ",$spreadsheet->GetActiveSheet()->getCell('C'.$row)->getValue())[0]) == 0){
                                            while(check_emp_on_master(explode(" ",$spreadsheet->GetActiveSheet()->getCell('C'.$row)->getValue())[0]) == 0){
                                                if($spreadsheet->GetActiveSheet()->getCell('C'.$row)->getValue() == 'Overall Total'){
                                                    break;
                                                }
                                            $row++;
                                            }
                                        }
                                        // IF Overall Total IS IN THE EMPLOYEE NAME CELL THE END OF THE DATA HAS BEEN REACHED SO BREAK OUT OF READING->PRINTING LOOP
                                        if($spreadsheet->GetActiveSheet()->getCell('C'.$row)->getValue() == 'Overall Total'){
                                            break;
                                        }
                                    ?>
                                    <?php
                                        // ASSIGN NEW EMPLOYEE TO CURRENT EMPLOYEE
                                        $current_employee = explode(" ",$spreadsheet->GetActiveSheet()->getCell('C'.$row)->getValue())[0];
                                        $current_employee_name = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', get_emp_name($current_employee)));
                                        $current_dept = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', get_emp_dept_name($current_employee)));
                                        $current_supervisor = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', get_emp_supervisor($current_employee)));

                                        // RESET BUFFERS
                                        $avg_start_time_seconds_buff = $avg_finish_time_seconds_buff = array();
                                        $late_ins_buff = $early_outs_buff = $expected_attendance_month = $expected_paid_attendance_month = $rounded_attendance_month = $unpaid_absence_month = $break_duration_month = $basic_hours_month = $overtime_1_5_month = $overtime_2_0_month = $holidays_month = $total_basic_paid_time = 0;
                                    
                                        $month = strtoupper(date('M',strtotime(str_replace('/','-',$spreadsheet->getActiveSheet()->getCell('A'.$row)->getValue()))));
                                        $row+=1;

                                        
                                    ?>

                                <?php endif?>

                                <?php
                                    // PROCESS CLOCK DETAILS FOR CURRENT ROW AND PRINT
                                    $day = $spreadsheet->getActiveSheet()->getCell('B'.$row)->getValue();
                                    $date = $spreadsheet->getActiveSheet()->getCell('A'.$row)->getValue();
                                    $employee  = $spreadsheet->getActiveSheet()->getCell('C'.$row)->getValue();
                                    $roster_start = $spreadsheet->getActiveSheet()->getCell('D'.$row)->getValue();
                                    $actual_start = $spreadsheet->getActiveSheet()->getCell('I'.$row)->getValue();
                                    $late_in = $spreadsheet->getActiveSheet()->getCell('K'.$row)->getValue() ? ($spreadsheet->getActiveSheet()->getCell('K'.$row)->getValue() > $spreadsheet->getActiveSheet()->getCell('D'.$row)->getValue() ? '&#10060' : '&#x2714;') : "";
                                    $roster_end = $spreadsheet->getActiveSheet()->getCell('E'.$row)->getValue();
                                    $actual_end = $spreadsheet->getActiveSheet()->getCell('J'.$row)->getValue();
                                    $early_out = $spreadsheet->getActiveSheet()->getCell('L'.$row)->getValue() ? ($spreadsheet->getActiveSheet()->getCell('L'.$row)->getValue() < $spreadsheet->getActiveSheet()->getCell('E'.$row)->getValue() ? '&#10060' : '&#x2714;') : "";
                                    $expected_attendance = $spreadsheet->getActiveSheet()->getCell('F'.$row)->getValue();
                                    $expected_paid_attendance = $expected_attendance ? integer_seconds_to_duration(duration_to_integer_seconds($spreadsheet->getActiveSheet()->getCell('F'.$row)->getValue())-1800) : NULL;
                                    $rounded_attendance = substr($spreadsheet->getActiveSheet()->getCell('M'.$row)->getValue(),2);
                                    $unpaid_absence = $spreadsheet->getActiveSheet()->getCell('N'.$row)->getValue();
                                    $break_duration = substr($spreadsheet->getActiveSheet()->getCell('R'.$row)->getValue(),2);
                                    $basic_hours = $spreadsheet->getActiveSheet()->getCell('S'.$row)->getValue();
                                    $overtime_1_5 = $spreadsheet->getActiveSheet()->getCell('T'.$row)->getValue();
                                    $overtime_2_0 = $spreadsheet->getActiveSheet()->getCell('U'.$row)->getValue();
                                    $holidays = $spreadsheet->getActiveSheet()->getCell('V'.$row)->getValue() ? $spreadsheet->getActiveSheet()->getCell('V'.$row)->getValue() : $spreadsheet->getActiveSheet()->getCell('W'.$row)->getValue();
                                    $total_paid = integer_seconds_to_duration(duration_to_integer_seconds($basic_hours) + duration_to_integer_seconds($holidays));
                                ?>
                                
                                <?php $rowstyle = $spreadsheet->getActiveSheet()->getCell('B'.$row) == 'Mon' ? "border-top:4px solid #2c2c2c;" : "";?>
                                <tr employee = "<?=$current_employee_name?>" department = "<?=$current_dept?>" supervisor = "<?= $current_supervisor?>"  month = "<?=$month?>" class = "white" rtype = "emp_detail" style = "display:none; <?=$rowstyle?>">
                                    <td class = "supp_data" style = "display:none;">                                            <?=$day?>                       </td>
                                    <td class = "supp_data" style = "display:none;">                                            <?=$date?>                      </td>
                                    <td class = "lefttext">                                                                     <?=$employee?>                  </td>
                                    <td class = "tablebr_solidleft tablebr_dottedright">                                        <?=$roster_start?>              </td>
                                    <td class = "supp_data tablebr_dottedleft tablebr_dottedright" style = "display:none;">     <?=$actual_start?>              </td>
                                    <td class = "tablebr_dottedleft tablebr_solidright">                                        <?=$late_in?>                   </td>
                                    <td class = "tablebr_solidleft tablebr_dottedright">                                        <?=$roster_end?>                </td>
                                    <td class = "supp_data tablebr_dottedleft tablebr_dottedright" style = "display:none;">     <?=$actual_end?>                </td>
                                    <td class = "tablebr_dottedleft tablebr_solidright">                                        <?=$early_out?>                 </td>
                                    <td class = "tablebr_solidleft tablebr_dottedright">                                        <?=$expected_attendance?>       </td>
                                    <td class = "tablebr_dottedleft tablebr_dottedright">                                       <?=$expected_paid_attendance?>  </td>
                                    <td class = "tablebr_dottedleft tablebr_dottedright">                                       <?=$rounded_attendance?>        </td>
                                    <td class = "tablebr_dottedleft tablebr_dottedright">                                       <?=$unpaid_absence?>            </td>
                                    <td class = "tablebr_dottedleft tablebr_solidright">                                        <?=$break_duration?>            </td>
                                    <td class = "tablebr_solidleft tablebr_dottedright">                                        <?=$basic_hours?>               </td>
                                    <td class = "tablebr_dottedleft tablebr_dottedright">                                       <?=$holidays?>                  </td>
                                    <td class = "tablebr_dottedleft tablebr_solidright">                                        <?=$total_paid?>                </td>
                                    <td class = "tablebr_solidleft tablebr_dottedright">                                        <?=$overtime_1_5?>              </td>
                                    <td class = "tablebr_dottedleft tablebr_dottedright">                                       <?=$overtime_2_0?>              </td>
                                    <td class = "tablebr_dottedleft tablebr_dottedright">                                                                       </td>
                                </tr>

                                <?php
                                    // UPDATE BUFFER VARIABLES WITH INFO FROM CURRENT ROW
                                    if($actual_start){array_push($avg_start_time_seconds_buff, duration_to_integer_seconds($actual_start));}
                                    if($actual_end){array_push($avg_finish_time_seconds_buff, duration_to_integer_seconds($actual_end));}
                                    if($roster_start){array_push($avg_roster_start_time_seconds_buff, duration_to_integer_seconds($roster_start));}
                                    if($roster_end){array_push($avg_roster_finish_time_seconds_buff, duration_to_integer_seconds($roster_end));}
                                    if($expected_attendance){$expected_attendance_month+=duration_to_integer_seconds($expected_attendance);} 
                                    if($expected_paid_attendance){$expected_paid_attendance_month+=duration_to_integer_seconds($expected_paid_attendance);} 
                                    if($rounded_attendance){$rounded_attendance_month+=duration_to_integer_seconds($rounded_attendance);}
                                    if($unpaid_absence){$unpaid_absence_month+=duration_to_integer_seconds($unpaid_absence);}
                                    if($break_duration){$break_duration_month+=duration_to_integer_seconds($break_duration);}
                                    if($basic_hours){$basic_hours_month+=duration_to_integer_seconds($basic_hours);}
                                    if($overtime_1_5){$overtime_1_5_month+=duration_to_integer_seconds($overtime_1_5);}
                                    if($overtime_2_0){$overtime_2_0_month+=duration_to_integer_seconds($overtime_2_0);}
                                    if($holidays){$holidays_month+=duration_to_integer_seconds($holidays);}
                                    if($total_paid){$total_basic_paid_time+=duration_to_integer_seconds($total_paid);}
                                ?>

                                <?php $row++;?>
                                <?php if($spreadsheet->getActiveSheet()->getCell('G'.$row)->getValue() == 'BRK'){$row++;}?>
                                <?php 
                                    $spreadsheet->getActiveSheet()->getCell('K'.$row)->getValue() ? ($spreadsheet->getActiveSheet()->getCell('K'.$row)->getValue() > $spreadsheet->getActiveSheet()->getCell('D'.$row)->getValue() ? $late_ins_buff++ : NULL) : NULL;
                                    $spreadsheet->getActiveSheet()->getCell('L'.$row)->getValue() ? ($spreadsheet->getActiveSheet()->getCell('L'.$row)->getValue() < $spreadsheet->getActiveSheet()->getCell('E'.$row)->getValue() ? $early_outs_buff++ : NULL) : NULL;
                                ?>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <div id = "table_pages_footer" class = "footer">
                    <div id = "top">
                        <div id = "filter_container">
                            <div id = "filters" class = "red fill rounded">
                                <div class = "filter" style = "width:15%;">
                                    <div class = "text">
                                        <button class = "fill red medium wtext">Employee</button>
                                    </div>
                                    <div class = "content">
                                        <select id = "select_employee" class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                            <?php   generate_filter_options($full_emp_list, 'emp_name');  ?>
                                        </select>
                                    </div>
                                </div>
                                <div class = "filter" style = "width:15%;">
                                    <div class = "text">
                                        <button class = "fill red medium wtext">Department</button>
                                    </div>
                                    <div class = "content">
                                        <select id = "select_department" class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                            <?php   generate_filter_options($full_emp_list, "emp_dept_name");  ?>
                                        </select>
                                    </div>
                                </div>
                                <div class = "filter" style = "width:15%;">
                                    <div class = "text">
                                        <button class = "fill red medium wtext">Supervisor</button>
                                    </div>
                                    <div class = "content">
                                        <select id = "select_supervisor" class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                            <?php   generate_filter_options($full_emp_list, "emp_supervisor");  ?>
                                        </select>
                                    </div>
                                </div>
                                <div id = "hr_clock_month_buttons" class = "filter" style = "width:45%;">
                                    <button id = "H100" class = "rounded brred red wtext medium" style = "width:10.6%;">PIVOT</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id = "bottom">                        
                        <div id = "button_container">
                            <button onclick = "location.href='BASE_staff_clocking.php?UPDATE=1'" class = "grouping_page_corner_buttons fill medium light_blue wtext rounded">UPDATE</button>
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