<!DOCTYPE html>
<html>
    <head>
        <!-- INITALISATION AND META STUFF -->
        <meta name = "viewpport" content = "width=device-width, initial-scale = 1">
        <title>Pre Production Exceptions</title>
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

        <!-- EXTERNAL JAVASCRIPT -->
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

        <!-- LOCAL JAVASCRIPT -->
        <script type = "text/javascript" src = "../../../../JS LIBS/LOCAL/JS_comments.js"></script>
        <script type="text/javascript" src="../../../../JS LIBS/LOCAL/JS_filters.js"></script>
        <script type = "text/javascript" src = "./JS_exceptions_buttons.js"></script>
        <script type = "text/javascript" src = "./JS_table_to_excel.js"></script>

        <!-- STYLING -->
        <link href='../../../../CSS/LT_STYLE.css' rel='stylesheet' type='text/css'>
        <link rel = "stylesheet" href = "../../../../css/theme.blackice.min.css">
        
        <!-- PHP INIT -->
        <?php include '../../../../PHP LIBS/PHP FUNCTIONS/php_functions.php'; ?>
        <?php include './BASE_SUB_pre_production_exceptions_counts.php';?>

        <!-- TABLESORTER SETUP -->
        <script>
            $(function()
            {
                $("table").tablesorter({
                    "theme" : "blackice",
                    "dateFormat" : "ddmmyyyy",
                    "headers" : {
                        7: {sorter : "shortDate"},
                        10: {sorter : "shortDate"},
                        13: {sorter : "shortDate"},
                        14: {sorter : false}
                    }
                });
            });
        </script>
    </head>
    <body>
        <div id = 'background'>
            <div id = 'content'>
                <div id = 'grouping_buttons_container'>
                    <div id = 'grouping_buttons' class = 'fw light_grey'>
                        <div id = 'margin'>
                            <div class = "grouping_category">
                                <button class = "stage_ok quarter medium light_blue wtext rounded-top" stage = "1-drawings-approved"><?php echo $pre_production_exceptions_counters[DRAWINGS_APPROVED][PPE_SELF]." (".$pre_production_exceptions_counters[DRAWINGS_APPROVED][OK].")"; ?></button>
                                <button class = "stage_name half medium dark_grey wtext" stage = "All">Drawings Approved</button>
                                <button class = "stage_not_ok quarter medium red wtext rounded-bottom" stage = "1-drawings-approved-expired"><?php echo $pre_production_exceptions_counters[DRAWINGS_APPROVED][LATE];?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "stage_ok quarter medium light_blue wtext rounded-top" stage = "2-awaiting-customer-approval"><?php echo $pre_production_exceptions_counters[AWAITING_DRAWING_APPROVAL][PPE_SELF]." (".$pre_production_exceptions_counters[AWAITING_DRAWING_APPROVAL][OK].")";?></button>
                                <button class = "stage_name half medium dark_grey wtext" stage = "All">Awaiting Customer Approval</button>
                                <button class = "stage_not_ok quarter medium red wtext rounded-bottom" stage = "2-awaiting-customer-approval-expired"><?php echo $pre_production_exceptions_counters[AWAITING_DRAWING_APPROVAL][LATE];?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "stage_ok quarter medium light_blue wtext rounded-top" stage = "3-revised-drawing-required"><?php echo $pre_production_exceptions_counters[REVISED_DRAWING_REQUIRED][PPE_SELF]." (".$pre_production_exceptions_counters[REVISED_DRAWING_REQUIRED][OK].")"; ?></button>
                                <button class = "stage_name half medium dark_grey wtext" stage = "All">Revised Drawing Required</button>
                                <button class = "stage_not_ok quarter medium red wtext rounded-bottom" stage = "3-revised-drawing-required-expired"><?php echo $pre_production_exceptions_counters[REVISED_DRAWING_REQUIRED][LATE];?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "stage_ok quarter medium light_blue wtext rounded-top" stage = "4-awaiting-sample-approval"><?php echo $pre_production_exceptions_counters[AWAITING_SAMPLE_APPROVAL][PPE_SELF]." (".$pre_production_exceptions_counters[AWAITING_SAMPLE_APPROVAL][OK].")"; ?></button>
                                <button class = "stage_name half medium dark_grey wtext" stage = "All">Awaiting Sample Approval</button>
                                <button class = "stage_not_ok quarter medium red wtext rounded-bottom" stage = "4-awaiting-sample-approval-expired"><?php echo $pre_production_exceptions_counters[AWAITING_SAMPLE_APPROVAL][LATE];?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "stage_ok quarter medium light_blue wtext rounded-top" stage = "5-engineer-drawing"><?php echo $pre_production_exceptions_counters[ENGINEER_DRAWING][PPE_SELF]." (".$pre_production_exceptions_counters[ENGINEER_DRAWING][OK].")"; ?></button>
                                <button class = "stage_name half medium dark_grey wtext" stage = "All">Engineer Drawing</button>
                                <button class = "stage_not_ok quarter medium red wtext rounded-bottom" stage = "5-engineer-drawing-expired"><?php echo $pre_production_exceptions_counters[ENGINEER_DRAWING][LATE]; ?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "stage_ok quarter medium light_blue wtext rounded-top" stage = "6-awaiting-further-information"><?php echo $pre_production_exceptions_counters[AWAITING_FURTHER_INFORMATION][PPE_SELF]." (".$pre_production_exceptions_counters[AWAITING_FURTHER_INFORMATION][OK].")"; ?></button>
                                <button class = "stage_name half medium dark_grey wtext" stage = "All">Awaiting Further Instruction</button>
                                <button class = "stage_not_ok quarter medium red wtext rounded-bottom" stage = "6-awaiting-further-information-expired"><?php echo $pre_production_exceptions_counters[AWAITING_FURTHER_INFORMATION][LATE];?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "stage_ok quarter medium light_blue wtext rounded-top" stage = "8-design-concept"><?php echo $pre_production_exceptions_counters[CONCEPT][PPE_SELF]." (".$pre_production_exceptions_counters[CONCEPT][OK].")"; ?></button>
                                <button class = "stage_name half medium dark_grey wtext" stage = "All">Design Concept</button>
                                <button class = "stage_not_ok quarter medium red wtext rounded-bottom" stage = "8-design-concept-expired"><?php echo $pre_production_exceptions_counters[CONCEPT][LATE];?></button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "stage_ok quarter medium light_blue wtext rounded-top" stage = "All">0</button>
                                <button class = "stage_name half medium dark_grey wtext" stage = "All">UNUSED</button>
                                <button class = "stage_not_ok quarter medium red wtext rounded-bottom" stage = "All">0</button>
                            </div><!--
                            --><div class = "grouping_category">
                                <button class = "stage_ok quarter medium light_blue wtext rounded-top" stage = "All">0</button>
                                <button class = "stage_name half medium dark_grey wtext" stage = "All">UNUSED</button>
                                <button class = "stage_not_ok quarter medium red wtext rounded-bottom" stage = "All">0</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "table_title green" id = "grouping_table_title">
                    <h1>PRE PRODUCTION EXCEPTIONS<h1>
                </div>
                <div id = 'grouping_table_container' class = 'table_container' style = "overflow-y:scroll;">
                    <table id = "pre_production_exceptions" class = "tablesorter filterable">
                        <thead>
                            <tr class = "dark_grey smedium head">
                                <th width = "6%" >Sales Order</th>
                                <th width = "15%">Project</th>
                                <th width = "15%">Description</th>
                                <th width = "5%" >Quantity</th>
                                <th width = "5%" >Engineering Hours</th>
                                <th width = "5%" >Action Wk Due</th>
                                <th width = "10%">Engineer</th>
                                <th width = "5%" >Fab Hrs</th>
                                <th width = "9%" >Promise Date</th>
                                <th width = "5%" >Week No.</th>
                                <th width = "9%" >Sales Person</th>
                                <th width = "6%" >Stage Wks Overdue</th>
                                <th width = "5%" >Comments</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach($pre_production_exceptions_results  as $row): ?>
                                <?php
                                    if($row["Stage"] == "1. Drawings Approved" || $row["Stage"] == "1. Drawings Approved ( Fabrication Drawings)" || $row["Stage"] == "1. Drawings Approved (Fab Drawings)"){
                                        $stage = "1-drawings-approved";
                                        $row["Weeks Overdue"] > 0 ? $stage = "1-drawings-approved-expired'" : $stage = $stage;
                                    }
                                    else if($row["Stage"] == "2. Awaiting Customer Approval"){
                                        $stage = "2-awaiting-customer-approval";
                                        $row["Weeks Overdue"] > 0 ? $stage = "2-awaiting-customer-approval-expired" : $stage = $stage;
                                    }
                                    else if($row["Stage"] == "3. Revised Drawing Required"){
                                        $stage = "3-revised-drawing-required";
                                        $row["Weeks Overdue"] > 0 ? $stage = "3-revised-drawing-required-expired" : $stage = $stage;
                                    }
                                    else if($row["Stage"] == "4. Awaiting Sample Approval"){
                                        $stage = "4-awaiting-sample-approval";
                                        $row["Weeks Overdue"] > 0 ? $stage = "4-awaiting-sample-approval-expired" : $stage = $stage;
                                    }
                                    else if($row["Stage"] == "5. Engineer Drawing ( Approval Drawings)" || $row["Stage"] == "5. Engineer Drawing (Approval Drawings)"){
                                        $stage = "5-engineer-drawing";
                                        $row["Weeks Overdue"] > 0 ? $stage = "5-engineer-drawing-expired" : $stage = $stage;
                                    }
                                    else if($row["Stage"] == "6. Awaiting Further Instruction" || $row["Stage"] == "6. Awaiting Further Instructions"){
                                        $stage = "6-awaiting-further-information";
                                        $row["Weeks Overdue"] > 0 ? $stage = "6-awaiting-further-information-expired" : $stage = $stage;
                                    }
                                    else if($row["Stage"] == "8. Design Concept"){
                                        $stage = "8-design-concept";
                                        $row["Weeks Overdue"] > 0 ? $stage = "8-design-concept-expired" : $stage = $stage;
                                    }
                                    else{
                                        $stage = "";
                                    }
                                ?>
                            <?php $customer = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $row["Customer"]));         ?>
                            <?php $project = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $row["Project"]));           ?>
                            <?php $engineer = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $row["Engineer"]));         ?>
                            <?php $sales_person = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $row["Sales Person"])); ?>
                                <?php $row["Status"] == "Pre Production Potential" ? $row_color = "style = 'background-color:#f7FA64;'" : ($row["Status"] == "Pre Production Forecast" ? $row_color = "style = 'background-color:#FF8C00;'" : ($row["Stage"] == "1. Drawings Approved ( Fabrication Drawings)" || $row["Stage"] == "1. Drawings Approved (Fab Drawings)" ? $row_color = "style = 'background-color:#99FF99;'" : $row_color = "")); ?>
                                <?php $row["Status"] == "Pre Production Confirmed" ? $status = "C" : ($row["Status"] == "Pre Production Potential" ? $status = "P" : ($row["Status"] == "Pre Production Forecast" ? $status = "F" : $status = "N"));    ?>
                                <tr class = 'white btext' stage = '<?=$stage?>' comments = '".$row["Comments"]."' <?=$row_color?> customer='<?= $customer ?>' project='<?= $project ?>' engineer='<?= $engineer ?>' sales_person='<?= $sales_person ?>'>
                                    <td><?=$status.$row["Sales Order"]?></td>
                                    <td class = "lefttext"><?=$row["Project"]?></td>
                                    <td class = "lefttext"><?=$row["Description"]?></td>
                                    <td><?=$row["Quantity"]?></td>
                                    <td><?=$row["Est Eng Hrs"]?></td>
                                    <td><?=$row["Action Week"]?></td>
                                    <td><?=$row["Engineer"]?></td>
                                    <td><?=$row["Est Prod Hrs"]?></td>
                                    <td><?=$row["Promise Date"]?></td>
                                    <td><?=$row["Promise Week Due"] >= 52 ? $row["Promise Week Due"]." (".($row["Promise Week Due"]-52).")" : $row["Promise Week Due"]?></td>
                                    <td><?=$row["Sales Person"]?></td>
                                    <td><?=$row["Weeks Overdue"]?></td>
                                    <td><button class = 'comment_button <?= $row["Comments"] != null ? 'has_comment' : ''?>' comments = '<?= $row["Comments"] == null ? "NO COMMENTS" : $row["Comments"]?>'></button></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div id = "grouping_pages_footer" class = "footer">
                    <div id = "button_container">
                        <button onclick = "location.href='../../../MAIN MENU/dashboard_menu.php'" class = "grouping_page_corner_buttons fill medium light_blue wtext rounded">MAIN MENU</button>
                    </div>
                    <div id = "filter_container">
                        <div id = "filters" class="fill red rounded">
                            <div class = "filter wider">
                                <div class = "text">
                                    <button class = "fill red medium wtext">Project</button>
                                </div>
                                <div class = "content">
                                    <select id = "select_project"class = "selector fill medium">
                                        <option value = "All" selected>All</option>
                                        <?php generate_filter_options($pre_production_exceptions_results, "Project"); ?>
                                    </select>
                                </div>
                            </div>
                            <div class = "filter wider">
                                <div class = "text">
                                    <button class = "fill red medium wtext">Sales Person</button>
                                </div>
                                <div class = "content">
                                    <select id = "select_sales_person"class = "selector fill medium">
                                        <option value = "All" selected>All</option>
                                        <?php generate_filter_options($pre_production_exceptions_results, "Sales Person"); ?>
                                    </select>
                                </div>
                            </div>
                            <div class = "filter wider">
                                <div class = "text">
                                    <button class = "fill red medium wtext">Engineer</button>
                                </div>
                                <div class = "content">
                                    <select id="select_engineer"class = "selector fill medium">
                                        <option value = "All" selected>All</option>
                                        <?php generate_filter_options($pre_production_exceptions_results, "Engineer"); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id = "button_container">
                        <button onclick = "export_to_excel('pre_production_exceptions')" class = "grouping_page_corner_buttons fill medium green wtext rounded">EXCEL</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>