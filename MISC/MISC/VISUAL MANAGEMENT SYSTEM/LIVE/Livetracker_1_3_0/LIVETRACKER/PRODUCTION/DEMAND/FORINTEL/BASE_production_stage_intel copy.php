<!DOCTYPE html>
<html>

<head>
    <!-- INITALISATION AND META STUFF -->
    <meta name="viewpport" content="width=device-width, initial-scale = 1">
    <title>TABLE LAYOUT</title>

    <!-- EXTERNAL JS DEPENDANCIES -->
    <script type="text/javascript" src="../../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="../../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

    <!-- LOCAL JS -->
    <script type="text/javascript" src="./JS_filters.js"></script>
    <script type="text/javascript" src="../../../../JS LIBS/LOCAL/JS_search_table.js"></script>
    <script type = "text/javascript" src = "./JS_table_to_excel.js"></script>
    <!-- STYLEING -->
    <link rel="stylesheet" href="../../../../css/LT_STYLE.css">
    <link rel="stylesheet" href="../../../../css/theme.blackice.min.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../../../../css/awsome-fonts.css">" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />


    <!-- PHP INITALISATION -->
    <?php include '../../../../SQL CONNECTIONS/conn.php' ?>
    <?php include '../../../../PHP LIBS/PHP FUNCTIONS/php_functions.php' ?>
    <?php include './SQL_production_stages_intel copy.php'; ?>
    <style>
        .bluee {
            box-shadow: 5px 10px red;
        }
        
      
        .ButtonState:checked + .Button{background:#fff;}
        .brsolidpink{border: solid 6px #E601BA;}

        .bryellow{border: solid 6px yellow;
    }
        .brdottedyellow{border: dashed 6px yellow;}
        .pre_prod_color{background-color:#4d79ef;}
        .risk_color{background-color:red;}
       .back_grey{background-color:#DCDCDC;}
    .exce{background-color:pink;}
    .hidden {
      display: none;
    }

    
    
    .toggle-button {
      cursor: pointer;
      text-decoration: underline;
      color: blue;
    }
    button
    {
        width:70%;
    }
    </style>
    <?php
    $process_order_step_efficiency_data = get_sap_data($conn, $process_order_step_efficiency_sql, DEFAULT_DATA);

    // REFORMATS LOOKUP DATA LIST TO ARRAY WITH PROCESS ORDERS AND SEQUENCE CODES AS ARRAY KEYS
    // INPUTING A PROCESS ORDER, MAKE ITEM CODE, AND SEQUENCE CODE RETURNS THE STEP STATUS, LINEID(ON PROCESS ORDER), PLANNED TIME, AND BOOKED TIME FOR THAT SECUENCE STEP
    $step_status_lookup_data = get_sap_data($conn, $sql_step_lookup, DEFAULT_DATA);
    $step_status_lookup = array();
    foreach ($step_status_lookup_data as $step_per_lookup_list) {
        $step_status_lookup[$step_per_lookup_list["Process Order"]][$step_per_lookup_list["Sub Item Code"]][$step_per_lookup_list["Sequence Code"]] = array("status" => $step_per_lookup_list["Step Status"], "line_id" => $step_per_lookup_list["Step Line ID"], "planned_time" => $step_per_lookup_list["ProcessTime"], "booked_time" => $step_per_lookup_list["BookedTime"]);
    }
    ?>

    <?php
    /////////////////////////////////////////////////////////////
    //          FOR BOOKED HOURS ENTRIES ON EACH STEP          //
    /////////////////////////////////////////////////////////////

    /* USING LIST OF LOGGED ENTRIES CREATES KEYED ARRAY CONTAINING ENTIRES FOR EACH PROCESS ORDER AND PROCESS STEP BY LINEID*/
    $logged_entries_json_data = array();
    $logged_entries_data = get_sap_data($conn, $sql_logged_entries, DEFAULT_DATA);

    $current_pr_order = $logged_entries_data[0]["PrOrder"];
    $current_seq_code = $logged_entries_data[0]["LineID"];
    $seq_code_buff = array();
    $pr_order_buff = array();
    $entry_no = 0;
    foreach ($logged_entries_data as $row) {
        if ($current_pr_order != $row["PrOrder"]) {
            $pr_order_buff[$current_seq_code] = $seq_code_buff;
            $logged_entries_json_data[$current_pr_order] = $pr_order_buff;
            $pr_order_buff = $seq_code_buff = array();
            $current_seq_code = $row["LineID"];
            $current_pr_order = $row["PrOrder"];
            $entry_no = 1;
        } else if ($current_seq_code != $row["LineID"]) {
            $pr_order_buff[$current_seq_code] = $seq_code_buff;
            $seq_code_buff = array();
            $current_seq_code = $row["LineID"];
            $entry_no = 1;
        }

        $seq_code_buff[$entry_no] = array("date" => $row["Date"], "name" => $row["Name"], "booked_qty" => $row["Qty"]);
        $entry_no++;
    }
    $bkd_hrs_details = $logged_entries_json_data;

    //////////////////////////////////////////////////////////////////////////////////
    //                         FOR BOOKED STEP REMARKS                             //
    /////////////////////////////////////////////////////////////////////////////////

    $remarks = array();
    $step_remarks_data = get_sap_data($conn, $sql_step_remarks, DEFAULT_DATA);


    $current_pr_order = $step_remarks_data[0]["PrOrder"];
    $current_seq_code = $step_remarks_data[0]["U_OldCode"];
    $seq_code_buff = array();
    $pr_order_buff = array();
    $entry_no = 0;
    foreach ($step_remarks_data as $row) {
        if ($current_pr_order != $row["PrOrder"]) {
            $pr_order_buff[$current_seq_code] = $seq_code_buff;
            $remarks[$current_pr_order] = $pr_order_buff;
            $pr_order_buff = $seq_code_buff = array();
            $current_seq_code = $row["U_OldCode"];
            $current_pr_order = $row["PrOrder"];
            $entry_no = 1;
        } else if ($current_seq_code != $row["U_OldCode"]) {
            $pr_order_buff[$current_seq_code] = $seq_code_buff;
            $seq_code_buff = array();
            $current_seq_code = $row["U_OldCode"];
            $entry_no = 1;
        }

        $seq_code_buff[$entry_no] = array("date" => $row["Date"], "name" => $row["Name"], "sequence" => $row["U_OldCode"], "remarks" => $row["Remarks"]);
        $entry_no++;
    }
    $pr_order_buff[$current_seq_code] = $seq_code_buff;
    $remarks[$current_pr_order] = $pr_order_buff;


    ?>

    <script>
        $(function() {
            $("table.sortable").tablesorter({
                theme: "blackice",
                dateFormat: "ddmmyyyy",
                headers: {
                    2: {
                        sorter: "shortDate"
                    },
                    8: {
                        sorter: true
                    },
                    9: {
                        sorter: true
                    },
                    10: {
                        sorter: false
                    },
                    11: {
                        sorter: false
                    },
                    12: {
                        sorter: false
                    },
                    13: {
                        sorter: false
                    },
                    14: {
                        sorter: false
                    },
                    15: {
                        sorter: false
                    },
                    16: {
                        sorter: false
                    },
                    17: {
                        sorter: false
                    },
                    18: {
                        sorter: false
                    },
                    19: {
                        sorter: false
                    },
                    20: {
                        sorter: false
                    },
                    21: {
                        sorter: false
                    },
                    22: {
                        sorter: false
                    },
                    23: {
                        sorter: false
                    },
                    24: {
                        sorter: false
                    },
                    25: {
                        sorter: false
                    },
                    26: {
                        sorter: false
                    },
                    27: {
                        sorter: false
                    },
                    28: {
                        sorter: false
                    },
                    29: {
                        sorter: false
                    },
                    30: {
                        sorter: false
                    },
                    31: {
                        sorter: false
                    },
                    32: {
                        sorter: false
                    },
                    33: {
                        sorter: false
                    },
                    34: {
                        sorter: false
                    },
                    35: {
                        sorter: false
                    },
                    36: {
                        sorter: false
                    },
                    37: {
                        sorter: false
                    },
                    38: {
                        sorter: false
                    }
                    
                    
                }
            });
        });
    </script>
</head>

<body>
    <div id="background">
        <div id="content">
            <div class="table_title green">
                <h1>PRODUCTION STEPS/INTEL</h1>
            </div>
            <div id="pages_table_container" class="table_container modified" style="overflow-y:scroll; overflow-x:scroll;">
                <table id="custom_hr_table" class="sticky sortable filterable searchable">
                    <thead class="smallplus wtext">
                        <tr class="head">
                            <th width="70px" class="sticky darker_grey lefttext" style="left:0px;">Sales<br>Order</th>
                            <th width="70px" class="sticky darker_grey lefttext" style="left:80px;">Process Order</th>
                            <th width="90px" class="sticky darker_grey lefttext" style="left:160px;">Promise Date</th>

                            <th width="190px" class="sticky darker_grey lefttext" style="left:160px;">Item Name</th>
                            <th width="60px" class="sticky darker_grey lefttext" style="left:360px;">SCon Date</th>
                            <th width="70px" class="sticky darker_grey lefttext" style="left:360px;">Fabricator</th>
                            <th width="50px" class="sticky darker_grey lefttext" style="left:460px;">PLanned</th>
                            <th width="50px" class="sticky darker_grey lefttext" style="left:460px;">EXecuted</th>
                            <th width="50px" class="sticky darker_grey lefttext" style="left:460px;">Plan-Exe</th>
                            


                            <?php foreach ($group_steps_template_intel as $group) : ?>
                                <?php foreach ($group["steps"] as $step) : ?>
                                    <?php if (!$step) {
                                        continue;
                                    } ?>
                                    <td width="75px" class="dark_grey sticky <?= $group["name"] ?>"><?= constant($step)[SHORTHAND_STAGE_NAME]; ?></td>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody class="btext smedium">
                        <?php foreach ($process_order_step_efficiency_data as $row) : ?>
                            <?php if ($row["Complete"] == 'Y') {
                                continue;
                            } ?>
                            <?php $sales_person = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $row["Sales Person"])); ?>
                            <?php $engineer = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $row["Engineer"])); ?>
                            <?php $project = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $row["Project"])); ?>
                            <?php $customer = str_replace(' ', '', preg_replace("/[^A-Za-z0-9 ]/", '', $row["Customer"])); ?>
                            <?php $saleso_alert = "Customer:" . '\n' . $row['Customer'] . '\n' . '\n' . "Project:" . '\n' . $row['Project'] . '\n' . '\n' . "Engineer:" . '\n' . $row["Engineer"] . '\n' . '\n' . "Sales Person:" . '\n' . $row["Sales Person"]; ?>
                            <?php $complete_marker = $row["Complete"] == 'Y' ? "light_green" : "light_grey"; ?>

                            <?php $remarks_line_details = $row["Process Order"] . ":"; ?>
                            <?php if (isset($remarks[$row["Process Order"]])) {
                                $has_comment = 1;
                                foreach ($remarks[$row["Process Order"]] as $step_code => $entry) {
                                    $remarks_line_details = $remarks_line_details . '\n' . '\n' . constant($step_code)[0];
                                    foreach ($entry as $ent) {
                                        $remarks_line_details = $remarks_line_details . '\n' . str_replace(["'", ".", "\r", "\n"], ["", "", "", ""], $ent["date"]) . "\t" . str_replace(["'", ".", "\r", "\n"], ["", "", "", ""], $ent["name"]) . '\n' . '->' . str_replace(["'", ".", "\r", "\n"], ["", "", "", ""], $ent["remarks"]);
                                    }
                                }
                            } else {
                                $has_comment = 0;
                            }
                            //For risks
                            if ($row["Risk"] == 'R3') 
                                $risk=true;
                            else
                           $risk=false;
                            /* if ($row["Status"]=='R') {
                                    $color = 'bluee';
                                } else
                                    $color = ''; */

                            //print_r($row["Status"]);
                            if ($row["Status"] == 'Pre Production Confirmed' || $row["Status"] == 'Pre Production Potential' || $row["Status"] == 'Pre Production Forecast') {
                                $pre_prod=true;
                            } 
                           else
                           $pre_prod=false;
                            $base_color = 'light_grey';
                            /* //print_r($base_color);
                            if ($risk && $pre_prod)
                            $back_color='pre_prod_color';
                            else if ($risk && !$pre_prod)
                            $back_color='risk_color';
                           
else if(!$risk && !$pre_prod)
$back_color='back_grey'; */
if($pre_prod && $risk)
{
  $back_color='pre_prod_color';
  print_r('true');
  $backg_color='risk_color';
}
else if($pre_prod && !$risk)
{
    $back_color='pre_prod_color';
    $backg_color='back_grey';

}
else if(!$pre_prod && $risk)
{
$back_color='risk_color';
$backg_color='risk_color';
}
else if(!$pre_prod && !$risk)
{
$back_color='back_grey';
$backg_color='back_grey';
}


                            ?>


                            <!-- TO FIND THE ROWS WITH COMPLETE PACKAGING -->
                            <?php foreach ($group_steps_template_intel as $group) : ?>
                                <?php foreach ($group["steps"] as $step) : ?>
                                    <?php if (!$step) {
                                        continue;
                                    } ?>

                                    <?php $step_exists = isset($row[(string)$step]) ? 1 : 0 ?>

                                    <?php $step_status = isset($step_status_lookup[$row["Process Order"]][$row["ItemCode"]][$step]['status']) ? ($step_status_lookup[$row["Process Order"]][$row["ItemCode"]][$step]['status'] == 'C' ? "&#x2714" : "") : ""; ?>

                                    <?php $width = isset($row[(string)$step]) ? (string)((($row[(string)$step] >= 1 ? 1 : $row[(string)$step]) * 59)) : 1; ?>
                                    <?php $fill_level_color = isset($row[(string)$step]) ? ($row[(string)$step] < 0.8 ? "green" : ($row[(string)$step] < 1 ? "orange" : "red")) : "" ?>

                                    <?php if (isset($step_status_lookup[$row["Process Order"]][$row["ItemCode"]][$step])) : ?>

                                        <?php $booked_hrs_line_details = constant($step)[0] . ":" . '\n' . '\n' . "Planned Time:" . '\n' . floatval($step_status_lookup[$row["Process Order"]][$row["ItemCode"]][$step]["planned_time"]) . '\n' . '\n' . "Booked Time:" . '\n' . floatval($step_status_lookup[$row["Process Order"]][$row["ItemCode"]][$step]["booked_time"]) . '\n' . '\n' . "Entries:"; ?>

                                        <?php if (isset($bkd_hrs_details[$row["Process Order"]][$step_status_lookup[$row["Process Order"]][$row["ItemCode"]][$step]['line_id']])) {
                                            foreach ($bkd_hrs_details[$row["Process Order"]][$step_status_lookup[$row["Process Order"]][$row["ItemCode"]][$step]['line_id']] as $entry) {
                                                $booked_hrs_line_details = $booked_hrs_line_details . '\n' . str_replace("'", "", $entry["date"]) . "\t " . str_replace("'", "", $entry["name"]) . "\t" . str_replace("'", "", floatval($entry["booked_qty"]));
                                            }
                                        } ?>
                                    <?php endif;
                                    //Stages are over 
                                    if ($group["name"] == 'stores' && $step_status == '&#x2714') {
                                        $status = 'complete';
                                    } else {

                                        $status = 'notcomplete';
                                    }


                                    /* if ($step == 'SEQ001' &&  $step_status == '&#x2714')
                                        {
                                           $statuslaserp ='completed';

                                        } */


                                    ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
<?php
if($row["SubConVal"]=='subconnull') 
{
$date_color='green';
}
else
{
    $date_color='light_grey';
}
if($row["U_In_Sub_Con"]=='1002')
{
    $sc_status='bryellow';
}
else if ($row["U_In_Sub_Con"]=='1003')
{
    $sc_status='brdottedyellow';

}
else if ($row["U_In_Sub_Con"]=='1005')
{
    $sc_status='brsolidpink';
}
else 
$sc_status='NULL';

?>
<?php $so = "location.href='http://vms/SAP%20READER/BASE_sales_order.php?sales_order=".$row["Sales Order"]."'" ?>
                <?php $po = "location.href='http://vms/SAP%20READER/BASE_process_order.php?process_order=".$row["Process Order"]."'" ?>

                            <tr class="data-row" sales_person=<?= $sales_person ?> engineer=<?= $engineer ?> project=<?= $project ?> status=<?= $status ?> customer=<?= $customer ?>>
                                <?php ?>
                                <td class="sticky lefttext step_detail  <?= $back_color ?> <?= $base_color ?>" style="background-color:<?php // $backcolor ?>" background-clip: padding-box; left:0px;"><button onclick="<?=$so?>" class="btext smedium rounded brblack" style="height:80%; width:80%; <?= $row["SC_RN"] != 1 ? "background-color:black" : ""?>"><?= $row["Sales Order"] ?></button></td>
                                <td class="sticky lefttext step_detail <?= $back_color ?> <?= $base_color ?>" style="background-color:<?= $backcolor ?>" background-clip: padding-box; left:80px;"><button onclick="<?=$po?>"class="btext smedium rounded brblack <?= $has_comment == 1 ? "lighter_green" : ""; ?>" style="height:80%; width:80%;"><?= $row["Process Order"] ?></button></td>
                                <td class="sticky lefttext step_detail  <?= $backg_color ?> <?= $base_color ?>" style="background-color:<?php //$backcolor ?>" background-clip: padding-box;left:160px;"><?= $row["Promise Date"] ?></td>

                                <td class="sticky lefttext step_detail  <?= $complete_marker ?>" style="background-color:<?= $backcolor ?>" background-clip: padding-box;left:160px;"><button class="btext lefttext <?=$sc_status?>" style="font-size: 1.5vh;height:80%; width:95%;background-color:#DCDCDC;"><?= $row["ItemName"] ?></button></td>
                                <td class="sticky lefttext step_detail <?= $date_color ?> " style="background-color:<?= $backcolor ?>" background-clip: padding-box;left:260px;"><?= $row["SubConDate"] == NULL ? 'NULL' : $row["SubConDate"];//subtract 14 days?></td>
                                <td class="sticky lefttext step_detail <?= $backg_color ?> <?= $base_color ?>" style="background-color:<?= $backcolor ?>" background-clip: padding-box;left:360px;"><?= $row["Most_Hours"] ?></td>
                                <td class="sticky righttext step_detail <?= $backg_color ?> <?= $base_color ?>" style="background-color:<?= $backcolor ?>" background-clip: padding-box;left:460px;"><?= $row["Total Planned Time"] ?></td>
                                <td class="sticky righttext step_detail <?= $backg_color ?> <?= $base_color ?>" style="background-color:<?= $backcolor ?>" background-clip: padding-box;left:460px;"><?= $row["Total Act Time"] ?></td>
                                <td class="sticky righttext step_detail <?= $backg_color ?> <?= $base_color ?>" style="background-color:<?= $backcolor ?>" background-clip: padding-box;left:460px;"><?= $row["Total Planned Time"] - $row["Total Act Time"] //$row["Labour Efficiency"]?></td>
                                 

                                <!-- LOOPS THROUGH THE STEPS IN EACH GROUP FROM THE GROUP TEMPLATE -->
                                <!-- IF THE STEP EXISTS FOR THE CURRENT PO IT WILL PRINT A VISIBLE FILLBAR WITH RESPECTIVE FILLEVEL OF BOOKED VS PLANNED TIME FOR THAT STEP -->
                                <!-- IF THE STEP DOES NOT EXIST IN THE CURRENT PO IT WILL PRINT A OPAQUE ELEMENT -->
                                <?php foreach ($group_steps_template_intel as $group) : ?>
                                    <?php foreach ($group["steps"] as $step) : ?>
                                        <?php if (!$step) {
                                            continue;
                                        } ?>

                                        <?php $step_exists = isset($row[(string)$step]) ? 1 : 0 ?>

                                        <?php $step_status = isset($step_status_lookup[$row["Process Order"]][$row["ItemCode"]][$step]['status']) ? ($step_status_lookup[$row["Process Order"]][$row["ItemCode"]][$step]['status'] == 'C' ? "&#x2714" : "") : ""; ?>

                                        <?php $width = isset($row[(string)$step]) ? (string)((($row[(string)$step] >= 1 ? 1 : $row[(string)$step]) * 59)) : 1; ?>
                                        <?php $fill_level_color = isset($row[(string)$step]) ? ($row[(string)$step] < 0.8 ? "green" : ($row[(string)$step] < 1 ? "orange" : "red")) : "" ?>

                                        <?php if (isset($step_status_lookup[$row["Process Order"]][$row["ItemCode"]][$step])) : ?>

                                            <?php $booked_hrs_line_details = constant($step)[0] . ":" . '\n' . '\n' . "Planned Time:" . '\n' . floatval($step_status_lookup[$row["Process Order"]][$row["ItemCode"]][$step]["planned_time"]) . '\n' . '\n' . "Booked Time:" . '\n' . floatval($step_status_lookup[$row["Process Order"]][$row["ItemCode"]][$step]["booked_time"]) . '\n' . '\n' . "Entries:"; ?>

                                            <?php if (isset($bkd_hrs_details[$row["Process Order"]][$step_status_lookup[$row["Process Order"]][$row["ItemCode"]][$step]['line_id']])) {
                                                foreach ($bkd_hrs_details[$row["Process Order"]][$step_status_lookup[$row["Process Order"]][$row["ItemCode"]][$step]['line_id']] as $entry) {
                                                    $booked_hrs_line_details = $booked_hrs_line_details . '\n' . str_replace("'", "", $entry["date"]) . "\t " . str_replace("'", "", $entry["name"]) . "\t" . str_replace("'", "", floatval($entry["booked_qty"]));
                                                }
                                            } ?>
                                        <?php endif; ?>

                                        <td step_laser=<?= $step.$step_status ?> class="<?= $group['name'] ?>" style="background-color:<?= $group['color'] ?>" onclick="alert('<?= $booked_hrs_line_details ?>')">
                                            <div class="progress_bar_container <?= !$step_exists ? 'opaque' : '' ?>">
                                                <div class="progress_bar <?= $fill_level_color ?>" style="width:<?= $width ?>px; position:absolute;"></div>
                                                <div style="width:100%; height:100%; position:absolute;"><?= $step_status ?></div>
                                        </td>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </tr>

                        <?php endforeach; ?>

                    </tbody>
                    <tfoot style = "position:sticky; bottom: 0; z-index:+2;">
                    <tr class = "lighter_blue btext">
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td ><button value="SEQ001\u2714"id="laserh_id"class="button_group fill red medium wtext" style="border-radius:50%;margin-left:25%;width:50%;height:40%;float:left">Hide</button>
      <td ><button id="sawh_id"value='sawh'class="button_group  fill red medium wtext" style="border-radius:50%;margin-left:25%;width:50%;height:40%;float:left">Hide</button>
      <td><button id="millingh_id"value='millingh'class="button_group  fill red medium wtext" style="border-radius:50%;margin-left:25%;width:50%;height:40%;float:left">Hide</button>
      <td><button id="lasermh_id"value='lasermh'class="button_group  fill red medium wtext" style="border-radius:50%;margin-left:25%;width:50%;height:40%;float:left">Hide</button>
      <td><button id="fabch_id"value='fabch'class="button_group  fill red medium wtext" style="border-radius:50%;margin-left:25%;width:50%;height:40%;float:left">Hide</button>
      <td><button id="qualch_id"value='qualch'class="button_group  fill red medium wtext" style="border-radius:50%;margin-left:25%;width:50%;height:40%;float:left">Hide</button>
      <td><button id="pklh_id"value='pklh'class="button_group  fill red medium wtext" style="border-radius:50%;margin-left:25%;width:50%;height:40%;float:left">Hide</button>
      <td><button id="pckh_id"value='pckh'class="button_group  fill red medium wtext" style="border-radius:50%;margin-left:25%;width:50%;height:40%;float:left">Hide</button>
    </tr>
  </tfoot>
                </table>
            </div>
            <div id="table_pages_footer" class="footer">
                <div id="top">
                    <div id="filter_container">
                        <div id="filters" class="red fill rounded">
                            <div class="filter">
                                <div class="text">
                                    <button class="red medium wtext">Customer</button>
                                </div>
                                <div class="content">
                                    <select id="select_customer" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <?php generate_filter_options($process_order_step_efficiency_data, "Customer") ?>
                                    </select>
                                </div>
                            </div>
                            <div class="filter">
                                <div class="text">
                                    <button class="fill red medium wtext">Project</button>
                                </div>
                                <div class="content">
                                    <select id="select_project" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <?php generate_filter_options($process_order_step_efficiency_data, "Project") ?>
                                    </select>
                                </div>
                            </div>
                            <div class="filter">
                                <!-- <div class="text">
                                    <button class="fill red medium wtext">Engineer</button>
                                </div>
                                <div class="content">
                                    <select id="select_engineer" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <?php generate_filter_options($process_order_step_efficiency_data, "Engineer") ?>
                                    </select>
                                </div> -->
                                <div class="text">
                                    <button name="Button" class="fill bred medium btext ButtonState" style="background-color:blue;float:left;margin-left: 21%;display:none">Hide</button>
                                    <button class="fill bblue medium wtext" style="float:left;position: relative;background-color:blue;
    margin-left: 106%;
    margin-top: -.8%;
    float: left">Reset Hide</button>
                                </div>
                            </div>
                            <div class="filter">

                                <div class="text">
                                    <button class="fill red medium wtext">Production Group</button>
                                </div>
                                <div class="content">
                                    <select id="select_production_group" class="col_selector fill medium">
                                        <option value="All" selected>All</option>
                                        <?php foreach ($group_steps_template as $group) : ?>
                                            <option value="<?= $group["name"] ?>"><?= $group["name"] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!-- <div class="text">
                                    <button class="fill bred medium btext" style ="background-color:blue">Hide</button>
                                    <button class="fill bred medium btext">Show</button>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div id="bottom">
                    <div id="button_container">
                        <button class="grouping_page_corner_buttons fill medium light_blue wtext rounded">
                            <input class="medium" id="employee" type="text" style="width:80%;" placeholder="Search Table">
                        </button>
                    </div>
                    <div id="button_container_wide">
                        <button onclick="location.href='../../../MAIN MENU/dashboard_menu.php'" class="grouping_page_corner_buttons fill medium purple wtext rounded">MAIN MENU</button>
                    </div>
                    <div id = "button_container">
                            <button onclick="export_to_excel('custom_hr_table')" class = "grouping_page_corner_buttons fill medium green wtext rounded">EXCEL</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>