<!DOCTYPE html>
<html>
    <head>
        <!-- META STUFF -->
        <title>Operator Hours</title>
		<meta charset = "utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name = "viewport" content = "width=device-width, initial-scale = 1">
			
        <!-- EXTERNAL JS DEPENDANCIES -->
        <script type = "text/javascript" src = "./jquery-3.4.1.js"></script>				

        <!-- PAGE SPECIFIC JS -->									
		<script type = "text/javascript" src = "./JS.js"></script>

        <!-- STYLEING -->
		<link rel = "stylesheet" href = "./LT_STYLE.css">
        <link rel = "stylesheet" href = "./LT_style_standalone_extras.css">											
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
        
        <!-- PHP FUNCTIONS -->
        <?php date_default_timezone_set('Europe/London'); ?>
        <?php include './HOW_MANY_WEEKS_BACK.php' ?>
        <?php include './conn.php'; ?>
        <?php include './SQL_production_table.php'; ?>
        
        <?php
            $getResults = $conn->prepare($sql_operator_hours_pivot);
            $getResults->execute();
            $operator_hours_pivot_data = $getResults->fetchAll(PDO::FETCH_BOTH);
        ?>
        <?php
            $getResults = $conn->prepare($sql_operator_entries);
            $getResults->execute();
            $operator_entries_data = $getResults->fetchAll(PDO::FETCH_BOTH);
        ?>
    </head>
    <body id = "operator_hours_table">
        <div id = "background">
            <div id = "content">
                <div style = "height:100%; width:40%; float:left;">
                    <div class = "table_title green">
                        <h1>BOOKED HOURS CALANDER</h1>
                    </div>
                    <div id = "pages_table_container" class = "table_container no_scrollbar">
                        <table id = "operator_hours" class = "filterable sortable searchable">
                            <thead>
                                <tr class = "dark_grey wtext smedium head" style = "z-index:+3;">
                                    <th width = "5%">emp No</th>
                                    <th width = "25%" class = "lefttext">Emp Name</th>
                                    <th width = "10%">Mon</th>
                                    <th width = "10%">Tue</th>
                                    <th width = "10%">Wed</th>
                                    <th width = "10%">Thur</th>
                                    <th width = "10%">Fri</th>
                                    <th width = "10%">Sat</th>
                                    <th width = "10%">Total</th>
                                </tr>
                            </thead>
                            <tbody class = "btext white">
                                <?php foreach($operator_hours_pivot_data as $operator): ?>
                                    <?php $week_total = ($operator["Saturday"] ? $operator["Saturday"] : 0) + ($operator["Friday"] ? $operator["Friday"] : 0) + ($operator["Thursday"] ? $operator["Thursday"] : 0) + ($operator["Wednesday"] ? $operator["Wednesday"] : 0) + ($operator["Tuesday"] ? $operator["Tuesday"] : 0) + ($operator["Monday"] ? $operator["Monday"] : 0) ?>
                                    <?php ($operator["Year"] != date('Y') || $operator["Week"] != (int)date('W')) ? $hide = 1 : $hide = 0?>
                                    <tr year = '<?=$operator["Year"]?>' week = '<?=$operator["Week"]?>' emp_no = '<?=$operator["UserId"]?>'  emp_name = '<?=$operator["Name"]?>' style = "<?= $hide ? 'display:none;' : ''?>">
                                        <td style = "border-right:1px solid #454545;"><?= $operator["UserId"]?></td>
                                        <td style = "border-right:2px solid #454545;" class = 'name lefttext'><?= $operator["Name"]?></td>
                                        <td style = "background-color:#CBCBCB; border-right:1px solid #454545;" ><?= $operator["Monday"] != NULL      ? "<button id = 'mon'>".$operator["Monday"]."</button>"       : ""?></td>
                                        <td style = "background-color:#CBCBCB; border-right:1px solid #454545;" ><?= $operator["Tuesday"] != NULL     ? "<button id = 'tue'>".$operator["Tuesday"]."</button>"      : ""?></td>
                                        <td style = "background-color:#CBCBCB; border-right:1px solid #454545;" ><?= $operator["Wednesday"] != NULL   ? "<button id = 'wed'>".$operator["Wednesday"]."</button>"    : ""?></td>
                                        <td style = "background-color:#CBCBCB; border-right:1px solid #454545;" ><?= $operator["Thursday"] != NULL    ? "<button id = 'thu'>".$operator["Thursday"]."</button>"     : ""?></td>
                                        <td style = "background-color:#CBCBCB; border-right:1px solid #454545;" ><?= $operator["Friday"] != NULL      ? "<button id = 'fri'>".$operator["Friday"]."</button>"       : ""?></td>
                                        <td style = "background-color:#CBCBCB; border-right:2px solid #454545;" ><?= $operator["Saturday"] != NULL    ? "<button id = 'sat'>".$operator["Saturday"]."</button>"     : ""?></td>
                                        <td style = "background-color:#ABABAB;"><?= ($week_total == 0 || $week_total != NULL)  ? "<button id = 'tot'>".$week_total."</button>" : ""?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>                   
                    </div>
                </div>
                <div style = "height:100%; width:58%; float:left; margin-left:2%;">
                    <div class = "table_title green">
                        <h1 id = 'empsteps'>NO EMPLOYEE SELECTED</h1> <!-- JS WILL REPLACE THIS DEPENDING ON EMPLOYEE NAME WEEK AND DAY BUTTON CLICKED -->
                    </div>
                    <div id = "pages_table_container" class = "table_container no_scrollbar" style = "max-height:60%;">
                        <table id = "operator_steps" class = "filterable sortable">
                            <thead>
                                <tr class = "dark_grey wtext smedium head">
                                    <th width = "10%">Sales Order</th>
                                    <th width = "10%">Process Order</th>
                                    <th width = "17.5%">Labour Name</th>
                                    <th width = "17.5%">Customer</th>
                                    <th width = "10%">Hours</th>
                                    <th width = "35%">Item Name</th>
                                    <th width = "5%">Year</th>
                                    <th width = "5%">Week</th>
                                    <th width = "5%">Day</th>
                                </tr>
                            </thead>
                            <tbody class = "btext white">
                                <?php foreach($operator_entries_data as $entry):?>
                                    <tr year = '<?=$entry["Year"]?>' week = '<?=$entry["Week no."]?>' weekday = '<?=$entry["Weekday"]?>' emp_no = '<?=$entry["Employee Number"]?>' style = "display:none">
                                        <td><?= $entry["Sales Order"]?></td>
                                        <td><?= $entry["Process Order"]?></td>
                                        <td class = 'lefttext'><?= $entry["Labour Name"]?></td>
                                        <td class = 'lefttext'><?= $entry["CardName"]?></td>
                                        <td><?= $entry["Hours"]?></td>
                                        <td class = 'lefttext'><?= $entry["ItemName"]?></td>
                                        <td><?= $entry["Year"]?></td>
                                        <td><?= $entry["Week no."]?></td>
                                        <td><?= $entry["Weekday"]?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>                   
                    </div>
                    <div class = "light_blue rounded fillw" style = "position:relative; top:5%; height:14%;">
                        <h1 class = "date_holder" style = "font-size:7vh;" start_week = "<?= ((int)date('W') - $week_hist) < 1 ? ((int)date('W') - ($week_hist + 1)) + 52 : ((int)date('W') - ($week_hist + 1))?>" start_year = "<?= date('Y') - (((int)date('W') - ($week_hist + 1)) < 1 ? 1 : 0)?>" end_week = "<?= ((int)date('W') + 1) > 52 ? ((int)date('W') + 1) -52 : ((int)date('W') + 1)?>" end_year = "<?= date('Y') + (((int)date('W')+1) > 52 ? 1 : 0)?>" >Week <?= date('W') == 53 ? 52 : (int)date('W')." ".date('Y')?></h1>
                        <h1 style = "font-size:3vh;">Last Updated <?= date("d-m-Y")." at ".date("H:i:s") ?></h1>
                    </div>
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
                            </div>
                        </div>
                    </div>
                    <div id = "bottom">                        
                        <div id = "button_container">
                            <button id = "previous_week" go_to_week = "<?= (((int)date('W') - 1) < 1 ? ((int)date('W') - 1) + 52 : ((int)date('W') - 1))?>" go_to_year = "<?= (date('Y') - (((int)date('W')-1) < 1 ? 1 : 0))?>" class = "grouping_page_corner_buttons fill large green wtext rounded"><span>&#9754 Week <?= (((int)date('W') - 1) < 1 ? ((int)date('W') - 1) + 52 : ((int)date('W') - 1))." ".(date('Y') - (((int)date('W')-1) < 1 ? 1 : 0))?> &#9754</button>
                        </div>
                        <div id = "button_container_wide">
                            <button id = "this_week" go_to_week = "<?= date('W') == 53 ? 52 : (int)date('W')?>" go_to_year = "<?= date('Y') ?>" onclick = "location.href='./BASE_production_table.php'" class = "grouping_page_corner_buttons fill large purple wtext rounded">BACK TO CURRENT WEEK & UPDATE</button>
                        </div>
                        <div id = "button_container">
                            <button disabled id = "next_week" go_to_week = "<?= (((int)date('W') + 1) > 52 ? ((int)date('W') + 1) -52 : ((int)date('W') + 1))?>" go_to_year = "<?= (date('Y') + (((int)date('W')+1) > 52 ? 1 : 0))?>"  class = "grouping_page_corner_buttons fill large green wtext rounded">&#9755 Week <?= (((int)date('W') + 1) > 52 ? ((int)date('W') + 1) -52 : ((int)date('W') + 1))." ".(date('Y') + (((int)date('W')+1) > 52 ? 1 : 0))?> &#9755</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>