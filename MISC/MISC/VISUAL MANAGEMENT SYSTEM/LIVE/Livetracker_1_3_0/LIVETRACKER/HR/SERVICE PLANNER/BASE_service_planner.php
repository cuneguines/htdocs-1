<!-- FUNCTION TO PRINT DATA FROM SLSX TO TABLE -->
<?php
    function fill_service_planner_table($spreadsheet,$year){
        echo "<table class = 'alterable' style = 'white-space:nowrap;'>";
            echo "<thead class = 'wtext'>";
                echo "<tr style = 'height:20px;'>";
                    echo "<th class = 'sticky darker_grey' style = 'width:100px; left:0;'>$year</th>";
                    $col = 'B';
                    $curr_col = 2;
                    $row = 2;
                    $col_in_month = 1;
                    $color = "";
                    while($curr_col < 134){
                        echo "<th class = 'sticky darker_grey' style = 'width:30px; left:100px;'></th>";
                        $col++;
                        $j = 0;
                        for($i = $curr_col ; $i < $curr_col + 10; $i++){
                            if($j%2 == 1){
                                echo "<th class = 'sticky dark_grey' style = 'width:30px;'></th>";
                            }
                            else{
                                echo "<th class = 'sticky dark_grey' style = 'width:150px;'>".($j == 4 ? $spreadsheet->getSheet(0)->getCell($col.$row)->getValue() : "")."</th>";
                            }
                            $j++;
                            $col++;
                        }
                        $curr_col+=11;
                    }
                echo "</tr>";
                echo "<tr style = 'height:20px;'>";
                    echo "<th class = 'sticky darker_grey' style = 'width:100px; top:20px; left:0px;'></th>";
                    $col = 'B';
                    $curr_col = 2;
                    $row = 3;
                    while($curr_col < 134){
                        if($spreadsheet->getSheet(0)->getCell($col.$row)->getValue() == NULL){
                            echo "<th class = 'sticky darker_grey' style = 'width:30px; top:20px; left:100px;'></th>";
                        }
                        else if($spreadsheet->getSheet(0)->getCell($col.$row)->getValue() == 'S'){
                            echo "<th class = 'sticky dark_grey' style = 'width:65px; top:20px;'>".$spreadsheet->getSheet(0)->getCell($col.$row)->getValue()."</th>";
                        }
                        else{ 
                            echo "<th class = 'sticky dark_grey' style = 'width:160px; top:20px;'>".$spreadsheet->getSheet(0)->getCell($col.$row)->getValue()."</th>";
                        }
                        $col++;
                        $curr_col++;
                    }
                echo "</tr>";
            echo "</thead>";
            echo "<tbody class = 'btext smallplus'>";
            $row = 4;
            while($spreadsheet->getSheet(0)->getCell('A'.$row)->getValue()){
                $col = 'A';
                if(in_array($spreadsheet->getSheet(0)->getCell($col.$row)->getValue(), array("Sat"))){
                    echo "<tr style = 'border-top:2px solid red; color:white; background-color:#ff9999; height:20px;'>";
                }
                else if(in_array($spreadsheet->getSheet(0)->getCell($col.$row)->getValue(), array("Sun"))){
                    echo "<tr style = 'border-bottom:2px solid red; color:white; background-color:#ff9999; height:20px;'>";
                }
                else{
                    echo "<tr style = 'height:20px;'>";
                }
                
                    echo "<th class='fix' style = 'background-color:#454545; color:white; position:sticky; left:0;'>".$spreadsheet->getSheet(0)->getCell($col.$row)->getValue()."</th>";
                    $col = 'B';
                    $curr_col = 1;
                    while($curr_col < 134){
                        if(($curr_col%11)-1  == 0){
                            if($spreadsheet->getSheet(0)->getCell($col.$row)->getValue()==NULL){
                                echo "<td style = 'border-left:2px solid #454545; border-right:2px solid #454545; background-color:red; color:white; position:sticky; left:100px;'>".$spreadsheet->getSheet(0)->getCell($col.$row)->getValue()."</td>";
                                $color = 'background-color:#ABABAB;';
                            }
                            else{
                                echo "<td style = 'border-left:2px solid #454545; border-right:2px solid #454545; background-color:#39ac39; color:white; position:sticky; left:100px;'>".$spreadsheet->getSheet(0)->getCell($col.$row)->getValue()."</td>";
                                $color = '';
                            }
                        }
                        else{
                            echo "<td style = 'border-left:2px solid #454545; border-right:2px solid #454545; $color'>".$spreadsheet->getSheet(0)->getCell($col.$row)->getValue()."</td>";
                        }
                        $col++;
                        $curr_col++;
                    } 
                echo "</tr>";
                $row++;
            }
            echo "</tbody>";
        echo "</table>";
    }
?>
<?php
            // READ IN LIBS
            require '../../../PHP LIBS/phpspreadsheets/vendor/autoload.php';
            use PhpOffice\PhpSpreadsheet\Spreadsheet;
            use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

            // CREATE READER
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

            // IF UPDATE DATA IS CLICKED
            if(isset($_GET["RELOAD"])){
                $files = glob('./CACHE'.'/*');
                foreach($files as $file){
                    if(is_file($file))
                    {
                        unlink($file);
                    }
                }
                // FIND NEWEST FILE IN H DRIVE HOLIDAY BALANCE FOLDER FOLDER
                $spreadsheet_last = $reader->load('C://VMS_MASTER_DATA/SERVICE PLANNER/Service_Planner_Last_Year.xlsx');
                $spreadsheet_this = $reader->load('C://VMS_MASTER_DATA/SERVICE PLANNER/Service_Planner_This_Year.xlsx');
                $spreadsheet_next = $reader->load('C://VMS_MASTER_DATA/SERVICE PLANNER/Service_Planner_Next_Year.xlsx');

                // SAVE THE FILE TO OWN CACHE
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet_last);
                $writer->save("./CACHE/data_last.xlsx");
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet_this);
                $writer->save("./CACHE/data_this.xlsx");
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet_next);
                $writer->save("./CACHE/data_next.xlsx");
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
        <script type = "text/javascript" src = "./JS_swap_year_table.js"></script>												

        <!-- STYLEING -->
        <link rel = "stylesheet" href = "../../../css/LT_STYLE.css">
        <link rel = "stylesheet" href = "../../../css/theme.blackice.min.css">									
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

        <!-- PHP INITALISATION -->
        <?php include '../../../PHP LIBS/PHP FUNCTIONS/php_functions.php'  ?>
        <?php $spreadsheet_this = $reader->load('./CACHE/data_this.xlsx'); ?>
        <?php $spreadsheet_last = $reader->load('./CACHE/data_last.xlsx'); ?>
        <?php $spreadsheet_next = $reader->load('./CACHE/data_next.xlsx'); ?>
    </head>
    <body>
        <div id = "background">
            <div id = "content">
                <div class = "table_title green">
                    <h1>SITE WORK SCHEDULE</h1>
                </div>
                <div id = "pages_table_container" class = "table_container modified" style = "overflow-y:scroll; overflow-x:scroll;">
                    <div class= "subtable_container hide" id = "service_planner_last">
                    <?php fill_service_planner_table($spreadsheet_last, date('o')-1); ?>
                    </div>

                    <div class= "subtable_container" id = "service_planner_this">
                        <?php fill_service_planner_table($spreadsheet_this, date('o')); ?>
                    </div>

                    <div class= "subtable_container hide" id = "service_planner_next">
                        <?php fill_service_planner_table($spreadsheet_next, date('o')+1); ?>
                    </div>
                </div>
                <div id = "table_pages_footer" class = "footer">
                    <div id = "top">
                        <div id = "filter_container">
                            <div id = "filters" class = "red fill rounded">
                                <button class = "rounded red wtext medium brblack service_year_selector" style = "display:inline-block; position:relative; top:5%; height:90%; width:10%;" id = "service_last">Last Year</button>
                                <button class = "rounded red wtext medium brblack service_year_selector pressed" style = "display:inline-block; position:relative; top:5%; height:90%; width:10%;" id = "service_this">This Year</button>
                                <button class = "rounded red wtext medium brblack service_year_selector" style = "display:inline-block; position:relative; top:5%; height:90%; width:10%;" id = "service_next">Next Year</button>
                            </div>
                        </div>
                    </div>
                    <div id = "bottom">                        
                        <div id = "button_container">
                            <button onclick = 'location.href="BASE_service_planner.php?RELOAD=1"' class = "grouping_page_corner_buttons fill medium light_blue wtext rounded">UPDATE</button>
                        </div>
                        <div id = "button_container_wide">
                            <button onclick = "location.href='../../MAIN MENU/dashboard_menu.php'" class = "grouping_page_corner_buttons fill medium purple wtext rounded">MAIN MENU</button>
                        </div>
                        <div id = "button_container">
                            <button class = "grouping_page_corner_buttons fill medium green wtext rounded">UNUSED</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>