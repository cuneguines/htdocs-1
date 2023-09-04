<?php
// IF P EXCEPTIONS DETECTS PROCESS ORDER POST INCLUDE ALL BOM ITEMS NOT ISSUED INCLUDING THOSE IN STOCK
// OTHERWiSE PULL ALL BOM ITEMS ON ALL PROCESS ORDERS THAT ARE IN MATERIAL SHORTAGE REGARDLESS OF IF ITS ISSUED OR NOT
if (isset($_GET['po'])) {
    $clause = "WHERE [Process Order] = " . explode(',', $_GET['po'])[0];

    if (explode(',', $_GET['po'])[1] == 'OBAR') {
        $clause2_a = "AND (t5.ItmsGrpNam LIKE '%Sheet%' OR t5.ItmsGrpNam LIKE '%Bar%' OR t5.ItmsGrpNam LIKE '%Box%')";
        $clause2_b = "AND (t5.ItmsGrpNam LIKE '%Sheet%' OR t5.ItmsGrpNam LIKE '%Bar%' OR t5.ItmsGrpNam LIKE '%Box%')";
    } elseif (explode(',', $_GET['po'])[1] == 'NBAR') {
        $clause2_a = "AND t5.ItmsGrpNam NOT LIKE '%Sheet%' AND t5.ItmsGrpNam NOT LIKE '%Bar%' AND t5.ItmsGrpNam NOT LIKE '%Box%'";
        $clause2_b = "AND t5.ItmsGrpNam NOT LIKE '%Sheet%' AND t5.ItmsGrpNam NOT LIKE '%Bar%' AND t5.ItmsGrpNam NOT LIKE '%Box%'";
    } elseif (explode(',', $_GET['po'])[1] == 'NORMAL') {
        $clause2_a = "AND t2.PrcrmntMtd = 'B' AND t0.PlannedQty > (t2.ONhand - t2.IsCommited + t0.PlannedQty)  AND t1.CmpltQty < t1.PlannedQty";
        $clause2_b = "AND t2.PrcrmntMtd = 'B' AND t0.OpenQty > (t2.ONhand - t2.IsCommited + t0.OpenQty) ";
    }
} else {
    $clause = "";
    $clause2_a = "AND t2.PrcrmntMtd = 'B' AND t0.PlannedQty > (t2.ONhand - t2.IsCommited + t0.PlannedQty)  AND t1.CmpltQty < t1.PlannedQty";
    $clause2_b = "AND t2.PrcrmntMtd = 'B' AND t0.OpenQty > (t2.ONhand - t2.IsCommited + t0.OpenQty) ";
}
?>
<!DOCTYPE html>
<html>

<head>
    <!-- INITALISATION AND META STUFF -->
    <title>TIERED BUTTON GROUPING LAYOUT</title>
    <meta charset="utf-8">
    <meta name="viewpport" content="width=device-width, initial-scale = 1">

    <!-- EXTERNAL JAVASCRIPT -->
    <script type="text/javascript" src="../../../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="../../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="../../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

    <!-- LOCAL JAVASCRIPT -->
    <script type="text/javascript" src="./JS_FILTERS_CUSTOM.JS"></script>
    <script type="text/javascript" src="../../../../JS LIBS/LOCAL/JS_comments.js"></script>
    <script type="text/javascript" src="./JS_exceptions_buttons.js"></script>
    <!-- <script type="text/javascript" src="./jquery-1.10.2.js"></script> -->
    <script type="text/javascript" src="./JS_table_to_excel.js"></script>

    <!-- STYLING -->
    <link href='../../../../../CSS/LT_STYLE.css' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../../../../../CSS/theme.blackice.min.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

    <!-- PHP INITALISATION -->
    <?php include '../../../../../PHP LIBS/PHP FUNCTIONS/php_functions.php'; ?>
    <?php include './BASE_SUB_contracting_exceptions_count.php'; ?>

    <!-- TABLESORTER SETUP -->
    <script>
        $(function() {
            $("table.sortable").tablesorter({
                "theme": "blackice",
                "dateFormat": "ddmmyyyy",
                "headers": {
                    8: {
                        sorter: "shortDate"
                    },
                    10: {
                        sorter: "shortDate"
                    },
                    11: {
                        sorter: "shortDate"
                    },
                    13: {
                        sorter: "shortDate"
                    }
                }
            });
        });





        $(document).ready(function() {
            //console.log(rows);
            var template = $('table.searchable tfoot tr td');
            allenabled = 0;
            $('.multiselector_checkbox').click(function() {
                //alert("hello");
                //$('.selector').prop('selectedIndex', 0);
                //console.log($(this).parent().parent().parent().parent().parent().parent().attr('id').substring(12));
                filter_field = $(this).parent().parent().parent().parent().parent().parent().attr('id').substring(12);
                console.log(filter_field);
                if ($(this).val() == 'All') {
                    if (allenabled) {
                        console.log("PASS_OFF");
                        $('.multiselector_checkbox').addClass('checked');
                        $("table.searchable tr:not('.head')").show();
                        $("table.searchable tr:not('.head')").attr('active_in_multiselect', 'Y');
                        allenabled = 0;
                    } else {
                        console.log("PASS_ON");
                        $('.multiselector_checkbox').removeClass('checked', '');
                        $("table.searchable tr:not('.head')").hide();
                        $("table.searchable tr:not('.head')").attr('active_in_multiselect', 'N');
                        allenabled = 1;
                    }
                } else {
                    if ($(this).attr('class').includes('checked')) {
                        console.log("REMOVING ATTR");
                        $("table.searchable tr:not('.head')").filter("[" + filter_field + " = " + $(this).val() + "]").hide();
                        $("table.searchable tr:not('.head')").filter("[" + filter_field + " = " + $(this).val() + "]").attr('active_in_multiselect', 'N');
                        $(this).removeClass('checked');
                    } else {
                        console.log("ADDING ATTR");
                        $("table.searchable tr:not('.head')").filter("[" + filter_field + " = " + $(this).val() + "]").show();
                        $("table.searchable tr:not('.head')").filter("[" + filter_field + " = " + $(this).val() + "]").attr('active_in_multiselect', 'Y');
                        $(this).addClass('checked', '');
                    }
                }
                //rows = $("table.searchable tbody tr:visible");
                //update_total_row(rows, template);
            });
        });






        $(document).ready(function() {
            var rows = $("table.searchable tbody tr");
            var template = $('table.searchable tfoot tr td');
            active = 0;
            $('.search_option_button').click(function() {
                $('.selector').prop('selectedIndex', 0);
                if (!$(this).hasClass('active')) {
                    $('#' + $(this).attr('id') + '.search_option_field').show();
                    $(this).addClass('active');
                } else {
                    console.log($('#' + $(this).attr('id') + '.search_option_field'));
                    $('#' + $(this).attr('id') + '.search_option_field').hide();
                    $(this).removeClass('active');
                }
                //if (typeof __update_rows__ !== 'undefined') {
                //update_total_row(rows, template);}
            });
        })
    </script>
    <style>
        .box {

            width: 15%;
            height: 15%;
            border: 1px solid rgba(0, 0, 0, .2);
        }

        #button_containers {
            float: left;
            width: 10%;
            height: 100%;
        }

        .footer #grouping_pages_footer #filter_containers {
            width: 80%;
            margin-left: 2%;
            margin-right: 2%;
        }

        .filter widers {
            width: 20%;

        }

        .filter {
            float: left;
        }

        .checkmark {
            position: relative;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #eee;
        }

        .fill {
            height: 100%;
            width: 100%;
        }

        /* When the checkbox is checked, add a blue background */
        .container input.checked~.checkmark {
            background-color: #2196F3;
        }

        /* Create the checkmark/indicator (hidden when not checked) */

        /* Show the checkmark when checked */
        .container input.checked~.checkmark {
            display: block;
        }

        /* Style the checkmark/indicator */
        .container input.checked~.checkmark div {
            position: relative;
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);

        }

        .container {
            display: block;
            position: relative;
            padding-left: 0px;
            margin-bottom: 15px;
            cursor: pointer;
            font-size: 22px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default checkbox */
        .container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        /* Create a custom checkbox */
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #eee;
        }

        /* On mouse-over, add a grey background color */
        .container:hover input~.checkmark {
            background-color: #ccc;
        }

        /*/////////////////////////////////////////////////////////////////////////*/
        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            margin-left: 0%;
            margin-top: 0%;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            /* Safari */
            animation: spin 2s linear infinite;
        }

        .search_option_button:hover {
            background-color: rgb(240, 135, 135);
            ;
            color: #000000;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .grouping_category {
            float: left;
        }

        /*/////////////////////////////////////////////////////////////////////////*/
    </style>
</head>

<body>
    <?php
    function generate_multiselect_filter_options($table, $field)
    {
        echo "<tr class = 'btext' style = 'border:none;'><td width = '90%' class = 'lefttext'>All</td><td width = '10%'><label class='container fill' style = 'margin-bottom:25px;'><input class = 'multiselector_checkbox checked' type='checkbox' name = 'check_list[]' value='All'><span class='checkmark'><div></div></span></label></td></tr>";
        foreach (array_sort(array_unique(array_column($table, $field))) as $element) {
            echo "<tr class = 'btext' style = 'border:none;'><td width = '90%' class = 'lefttext'>$element</td><td width = '10%'><label class='container fill' style = 'margin-bottom:25px;'><input class = 'multiselector_checkbox checked' type='checkbox' name = 'check_list[]' value='" . str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $element)) . "'><span class='checkmark'><div></div></span></label></td></tr>";
        }
    }
    ?>

    <div id='background'>
        <div id='content'>
            <div id='grouping_buttons_container'>
                <div id='grouping_buttons' class='fw light_grey rounded'>
                    <div id='margin'>
                        <div class="grouping_category">
                            <button class="stage_not_ok_2 quarter medium red wtext rounded-top" stage="Mat-Not-Purchased"><?= $production_exceptions_counters[NOT_PURCHASED][TWO_WEEKS] ?></button>
                            <button class="stage_name half medium dark_grey wtext" stage="Mat-Not-Purchased">Material Not Purchased</button>
                            <button class="stage_not_ok_4 quarter medium light_blue wtext rounded-bottom" stage="Mat-Not-Purchased"><?= $production_exceptions_counters[NOT_PURCHASED][FOUR_WEEKS] ?></button>
                        </div>
                        <div class="grouping_category">
                            <button class="stage_not_ok_2 quarter medium red wtext rounded-top" stage="Mat-Not-In"><?= $production_exceptions_counters[MATERIAL_NOT_IN][TWO_WEEKS] ?></button>
                            <button class="stage_name half medium dark_grey wtext" stage="Mat-Not-In">Material Not In</button>
                            <button class="stage_not_ok_4 quarter medium light_blue wtext rounded-bottom" stage="Mat-Not-In"><?= $production_exceptions_counters[MATERIAL_NOT_IN][FOUR_WEEKS] ?></button>
                        </div>
                        <div class="grouping_category">
                            <button class="stage_not_ok_2 quarter medium red wtext rounded-top" stage="Gratings"><?= $production_exceptions_counters[GRATINGS][TWO_WEEKS] ?></button>
                            <button class="stage_name half medium dark_grey wtext" stage="Gratings">Gratings</button>
                            <button class="stage_not_ok_4 quarter medium light_blue wtext rounded-bottom" stage="Gratings"><?= $production_exceptions_counters[GRATINGS][FOUR_WEEKS] ?></button>
                        </div>
                        <div class="grouping_category">
                            <button class="stage_not_ok_2 quarter medium red wtext rounded-top" stage="Fixings"><?= $production_exceptions_counters[FIXINGS][TWO_WEEKS] ?></button>
                            <button class="stage_name half medium dark_grey wtext" stage="Fixings">Fixings</button>
                            <button class="stage_not_ok_4 quarter medium light_blue wtext rounded-bottom" stage="Fixings"><?= $production_exceptions_counters[FIXINGS][FOUR_WEEKS] ?></button>
                        </div>
                        <div class="grouping_category">
                            <button class="stage_not_ok_2 quarter medium red wtext rounded-top" stage="Fittings"><?= $production_exceptions_counters[FITTINGS][TWO_WEEKS] ?></button>
                            <button class="stage_name half medium dark_grey wtext" stage="Fittings">Fittings & Gaskets</button>
                            <button class="stage_not_ok_4 quarter medium light_blue wtext rounded-bottom" stage="Fittings"><?= $production_exceptions_counters[FITTINGS][FOUR_WEEKS] ?></button>
                        </div>
                        <div class="grouping_category">
                            <button class="stage_not_ok_2 quarter medium red wtext rounded-top" stage="Subcontract"><?= $production_exceptions_counters[SUBCONTRACT][TWO_WEEKS] ?></button>
                            <button class="stage_name half medium dark_grey wtext" stage="Subcontract">Subcontract</button>
                            <button class="stage_not_ok_4 quarter medium light_blue wtext rounded-bottom" stage="Subcontract"><?= $production_exceptions_counters[SUBCONTRACT][FOUR_WEEKS] ?></button>
                        </div>
                        <div class="grouping_category">
                            <button class="stage_not_ok_2 quarter medium red wtext rounded-top" stage="Sheets"><?= $production_exceptions_counters[SHEETS][TWO_WEEKS] ?></button>
                            <button class="stage_name half medium dark_grey wtext" stage="Sheets">Sheets & Bar Stock</button>
                            <button class="stage_not_ok_4 quarter medium light_blue wtext rounded-bottom" stage="Sheets"><?= $production_exceptions_counters[SHEETS][FOUR_WEEKS] ?></button>
                        </div>
                        <div class="grouping_category">
                            <button class="stage_not_ok_2 quarter medium red wtext rounded-top" stage="Intel-Materials"><?= $production_exceptions_counters[INTEL_MATERIAL][TWO_WEEKS] ?></button>
                            <button class="stage_name half medium dark_grey wtext" stage="Intel-Materials">Intel Materials</button>
                            <button class="stage_not_ok_4 quarter medium light_blue wtext rounded-bottom" stage="Intel-Materials"><?= $production_exceptions_counters[INTEL_MATERIAL][FOUR_WEEKS] ?></button>
                        </div>
                        <div class="grouping_category">
                            <button class="stage_not_ok_2 quarter medium red wtext rounded-top" stage="Intel-Subcontract"><?= $production_exceptions_counters[INTEL_SUBCONTRACT][TWO_WEEKS] ?></button>
                            <button class="stage_name half medium dark_grey wtext" stage="Intel-Subcontract">Intel Subcontract</button>
                            <button class="stage_not_ok_4 quarter medium light_blue wtext rounded-bottom" stage="Intel-Subcontract"><?= $production_exceptions_counters[INTEL_SUBCONTRACT][FOUR_WEEKS] ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table_title green rounded-top" id="grouping_table_title">
                <button class='ledgend_btn' style='float:left; height:100%; width:100px; background-color:black;'><img class="fill" src="../../../../../RESOURCES/info-icon.webp"></button>
                <h1 style='float:left;margin-left:30%'>MACHINED/SUBCONTRACT SCHEDULE</h1>

                <script>
                    let active = 0;
                    $('.ledgend_btn').click(function() {
                        console.log('CLCIK');

                        if (active === 0) {
                            $('.ledgend').show();
                            active = 1;
                        } else if (active === 1) {
                            $('.ledgend').hide();
                            active = 0;
                        }
                    });
                </script>
            </div>
            <div id='grouping_table_container' class='table_container' style="overflow-y:scroll;">
                <table id="production_exceptions" class="sortable filterable searchable">
                    <div class='ledgend' style="display:none;background:black;opacity:0.7;width:22%;height:39%;position:absolute;z-index:6; left:0%; top:0%;">
                        <div style="position:relative;height:10%; margin-bottom:7%; margin-top:7%;">
                            <div style="float:left; margin-left:5%; background:red;width:15%;height:100%;"></div>
                            <button style="float:left; margin-left:5%; background-color:black; font-size:1.6vh;"> Promise Date - Due Date(alert!!)</button>
                        </div>
                        <div style="position:relative;height:10%; margin-bottom:7%;">
                            <div style="float:left; margin-left:5%; background:orange;width:15%;height:100%;"></div>
                            <button style="float:left; margin-left:5%; background-color:black; font-size:1.5vh;"> Promise Date - Due Date(within 2 weeks)</button>
                        </div>
                        <div style="position:relative;height:10%; margin-bottom:7%;">
                            <div style="float:left; margin-left:5%; background:green;width:15%;height:100%;"></div>
                            <button style="float:left; margin-left:5%; background-color:black; font-size:1.5vh;">Promise Date - Due Date(within 4 weeks)</button>
                        </div>
                        <div style="position:relative;height:10%;">
                            <div style="float:left; margin-left:5%; background:white;width:15%;height:100%;"></div>
                            <button style="float:left; margin-left:5%; background-color:black; font-size:1.5vh;"> Promise Date - Due Date(more than 4 weeks)</button>
                        </div>
                    </div>
                    <thead>
                        <!-- IF PAGE IS ACCESED BY 'po' POST DO NOT PRINT CUSTOMER COLUMN AN INSTEAD PRINT A IN STOCK AND COMMITTED QTY COLUMN (NOT ENOUGH SPACE FOR BOTH) (IF PAGE IS ACCESSED BY MAIN MENU WITH NO 'po' POST DO THE OPPOSITE)-->
                        <tr class="dark_grey smedium head">
                            <?php if (!isset($_GET['po'])) : ?><th width="10%">Customer</th><?php endif; ?>
                            <th width="5%">Sales Ordr</th>
                            <th width="5%">Process Order</th>
                            <th width="5%">Supplier</th>
                            <th width="15%">Description</th>
                            <?php if (isset($_GET['po'])) : ?><th width="5%">Stock</th><?php endif; ?>
                            <th width="6%">ItemCode</th>
                            <?php if (isset($_GET['po'])) : ?><th width="5%">Comitt.</th><?php endif; ?>
                            <th width="5%">PlndQty</th>
                            <th width="5%">SC Date</th>
                            <th width="4%">PO</th>
                            <th width="6%">Due In</th>
                            
                            <th width="8%">Promise Date</th>

                            <th width="9%">Engineer</th>
                            <th width="6%">Floor Date</th>
                            <th width="4.5%">Pur<br>Comments</th>
                            <th width="4.5%">SO<br>Comments</th>
                            <th width="4.5%">SC<br>Comments</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $overdue = "" ?>
                        <?php foreach ($production_exceptions_results as $row) : ?>
                            <?php if ($row["ItemCode"] == 130236280 || $row["ItemCode"] == 130330100) {
                                continue;
                            }

                            if ($row["Type"] == "X" && $row["Customer"] != 'Intel Ireland Ltd') {
                                $stage = "Mat-Not-Purchased";
                                if ($row["Weeks Overdue_2"] > 0) {
                                    $overdue = '2W';
                                } else if ($row["Weeks Overdue_4"] > 0) {
                                    $overdue = '4W';
                                }
                            } else if ($row["Type"] == "N" && $row["Customer"] != 'Intel Ireland Ltd') {
                                $stage = "Mat-Not-In";
                                if ($row["Weeks Overdue_2"] > 0) {
                                    $overdue = "2W";
                                } else if ($row["Weeks Overdue_4"] > 0) {
                                    $overdue = "4W";
                                }
                            } else if ($row["Type"] == "SC" && $row["Customer"] != 'Intel Ireland Ltd') {
                                $stage = "Subcontract";
                                if ($row["Weeks Overdue_2"] > 0) {
                                    $overdue = "2W";
                                } else if ($row["Weeks Overdue_4"] > 0) {
                                    $overdue = "4W";
                                }
                            } else if ($row["Type"] == "GR" && $row["Customer"] != 'Intel Ireland Ltd') {
                                $stage = "Gratings";
                                if ($row["Weeks Overdue_2"] > 0) {
                                    $overdue = "2W";
                                } else if ($row["Weeks Overdue_4"] > 0) {
                                    $overdue = "4W";
                                }
                            } else if ($row["Type"] == "FX" && $row["Customer"] != 'Intel Ireland Ltd') {
                                $stage = "Fixings";
                                if ($row["Weeks Overdue_2"] > 0) {
                                    $overdue = "2W";
                                } else if ($row["Weeks Overdue_4"] > 0) {
                                    $overdue = "4W";
                                }
                            } else if ($row["Type"] == "FT" && $row["Customer"] != 'Intel Ireland Ltd') {
                                $stage = "Fittings";
                                if ($row["Weeks Overdue_2"] > 0) {
                                    $overdue = "2W";
                                } else if ($row["Weeks Overdue_4"] > 0) {
                                    $overdue = "4W";
                                }
                            } else if ($row["Type"] == "SH" && $row["Customer"] != 'Intel Ireland Ltd') {
                                $stage = "Sheets";
                                if ($row["Weeks Overdue_2"] > 0) {
                                    $overdue = "2W";
                                } else if ($row["Weeks Overdue_4"] > 0) {
                                    $overdue = "4W";
                                }
                            } else if ($row["Customer"] == "Intel Ireland Ltd" && $row["Type"] != 'SC') {
                                $stage = "Intel-Materials";
                                if ($row["Weeks Overdue_2"] > 0) {
                                    $overdue = "2W";
                                } else if ($row["Weeks Overdue_4"] > 0) {
                                    $overdue = "4W";
                                }
                            } else if ($row["Customer"] == "Intel Ireland Ltd" && $row["Type"] == 'SC') {
                                $stage = "Intel-Subcontract";
                                if ($row["Weeks Overdue_2"] > 0) {
                                    $overdue = "2W";
                                } else if ($row["Weeks Overdue_4"] > 0) {
                                    $overdue = "4W";
                                }
                            }

                            if ($row["Date_Diff"] < 0) {
                                $rowcolor = "style = 'background-color:#ff7a7a;'";
                            } else if ($row["Date_Diff"] < 2) {
                                $rowcolor = "style = 'background-color:#FF8C00;'";
                            } else if ($row["Date_Diff"] < 4) {
                                $rowcolor = "style = 'background-color:#99FF99;'";
                            } else {
                                $rowcolor = "";
                            }
                            ?>
                            <?php $supplier = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $row["Supplier"])); ?>
                            <?php $customer = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $row["Customer"])); ?>
                            <?php $engineer = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $row["Engineer"])); ?>
                            <?php //$status = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $row["Sub_Con_Status"])); ?>


                            <!-- IF PAGE IS ACCESED BY 'po' POST DO NOT PRINT CUSTOMER COLUMN AN INSTEAD PRINT A IN STOCK AND COMMITTED QTY COLUMN (NOT ENOUGH SPACE FOR BOTH) (IF PAGE IS ACCESSED BY MAIN MENU WITH NO 'po' POST DO THE OPPOSITE)-->
                            <tr status='<?= $status ?>' stage='<?= $stage ?>' overdue='<?= $overdue ?>' supplier='<?= $supplier ?>' customer='<?= $customer ?>' engineer='<?= $engineer ?>' class='white btext smedium' <?= $rowcolor ?> active_in_multiselect = "Y">
                                <?php if (!isset($_GET['po'])) : ?><td class='lefttext'><?= $row["Customer"] ?></td><?php endif; ?>
                                <td><?= $row["Sales Order"] ?></td>
                                <td><?= $row["Process Order"] ?></td>
                                <td class='lefttext'><?= $row["Supplier"] ?></td>
                                <td class='lefttext'><?= $row["ItemName"] ?></td>
                                <?php if (isset($_GET['po'])) : ?><td width="5%"><?= $row["ONHand"] ?></td><?php endif; ?>
                                <td><?= $row["ItemCode"] ?></td>
                                <?php if (isset($_GET['po'])) : ?><td width="5%"><?= $row["Commited"] ?></td><?php endif; ?>
                                <td><?= $row["Planned Qty"] ?></td>
                                <td><?=$row["Sub_Con_Date"] ?></td>
                                <td><?= $row["Latest Purchase Ord"] == NULL ? 'N/A' : $row["Latest Purchase Ord"] ?></td>
                                <td><?= $row["Purchase Due"] == NULL ? 'N/A' : $row["Purchase Due"] ?></td>
                               
                                <td><?= $row["Due Date"] == NULL ? "NO FLOOR DATE" : $row["Due Date"] ?></td>

                                <td class='lefttext'><?= $row["Engineer"] ?></td>
                                <td><?= $row["Floor Date"] == NULL ? "NO FLOOR DATE" : $row["Floor Date"] ?></td>
                                <td><button class='comment_button <?= $row["Comments_PO"] != null ? 'has_comment' : '' ?>' comments='<?= $row["Comments_PO"] == null ? "NO COMMENTS" : $row["Comments_PO"] ?>'></button></td>
                                <td><button class='comment_button <?= $row["Comments_SO"] != null ? 'has_comment' : '' ?>' comments='<?= $row["Comments_SO"] == null ? "NO COMMENTS" : $row["Comments_SO"] ?>'></button></button></td>
                                <td><button class='comment_button <?= $row["Sub_Con_Remarks"] != null ? 'has_comment' : '' ?>' comments='<?= $row["Sub_Con_Remarks"] == null ? "NO COMMENTS" : $row["Sub_Con_Remarks"] ?>'></button></button></td>
                            </tr>
                            </tr>
                            <?php $str = '';
                            $rowcolor = "";
                            $stage = "";
                            $overdue = "" ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div id="grouping_pages_footer" class="footer">
                <div id="button_containers" style="width:10%">
                    <button onclick="history.back();" class="grouping_page_corner_buttons fill medium light_blue wtext rounded">BACK</button>
                </div>
                <div id="filter_container" style="width:75%;margin-left:2%;margin-right:2%">
                    <div id="filters" class="fill red rounded">
                        <!-- <div class="filter widers">
                            <div class="text">
                                <button class="fill red medium wtext">Status</button>
                            </div>
                            <div class="content">
                                <select id="select_status" class="selector fill medium">
                                    <option value="All" selected>All</option>
                                    <?php generate_filter_options($production_exceptions_results, "Due Within"); ?>
                                </select>
                            </div>
                        </div> -->
                        <div class="filter widers"style="position:relative;margin-left:7%">
                            <div class="text">
                                <button class="fill red medium wtext">Customer</button>
                            </div>
                            <div class="content">
                                <select id="select_customer" class="selector fill medium">
                                    <option value="All" selected>All</option>
                                    <?php generate_filter_options($production_exceptions_results, "Customer"); ?>
                                </select>
                            </div>
                        </div>
                        <div class="filter widers"style="position:relative;margin-left:7%">
                            <div class="text">
                                <button class="fill red medium wtext">Supplier</button>
                            </div>
                            <div class="content">
                                <select id="select_supplier" class="selector fill medium">
                                    <option value="All" selected>All</option>
                                    <?php generate_filter_options($production_exceptions_results, "Supplier");    ?>
                                </select>
                            </div>
                        </div>
                        <div class="filter widers" style="position:relative;margin-left:7%">
                            <div class="text">
                                <button class="fill red medium wtext">Engineer</button>
                            </div>
                            <div class="content">
                                <select id="select_engineer" class="selector fill medium">
                                    <option value="All" selected>All</option>
                                    <?php generate_filter_options($production_exceptions_results, "Engineer");    ?>
                                </select>
                            </div>
                        </div>
                        <div class="filter widers" style="float:left;margin-left:15%;display:none">
                            <div class="text" style="width:70%">
                                <button class="search_option_button fill white medium rtext " id="multiselect_customer" style="width:100%;border-radius: 12px;">SELECT CUSTOMERS</button>
                            </div>


                        </div>
                    </div>
                </div>
                <div id="button_containers" style="width:10%">
                    <button onclick="export_production_exceptions_to_excel('production_exceptions')" class="grouping_page_corner_buttons fill medium green wtext rounded">EXCEL</button>
                </div>
            </div>
        </div>
    </div>

    <div id="multiselect_customer" class="search_option_field white" style="opacity:1; height:50%; width:20%; position:relative; bottom:58%; left:72%; z-index:+4; border-radius:25px; border:5px solid #f08787; overflow-y:scroll; display:none;">
        <table style="width:100%;" class="rh_small">
            <?php generate_multiselect_filter_options($production_exceptions_results, "Customer"); ?>
        </table>
    </div>
</body>

</html>