<!DOCTYPE HTML>
<html>

<head>
    <!-- META STUFF -->
    <meta charset="utf-8">
    <meta name="description" content="meta description">
    <meta name="viewpport" content="width=device-width, initial-scale = 1">

    <!-- JS LIBRARY DEPENDANCIES -->
    <script type="text/javascript" src="../../../js/libs/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="../../../JS/LIBS/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="../../../JS/LIBS/jquery.tablesorter.widgets.js"></script>

    <!-- JS FILES -->
    <!-- <script type = "text/javascript" src = "./JS_filters.js"></script>
		<script type = "text/javascript" src = "./JS_table_to_excel.js"></script> -->

    <!-- CSS FILES -->
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../../../CSS/KS_DASH_STYLE.css">
    <link rel="stylesheet" href="../../../css/theme.blackice.min.css">

    <?php include '../../../PHP LIBS/PHP FUNCTIONS/php_function.php'; ?>
    <style>
        .new_css {
            float: left;
            margin-left: 2%;
            margin-right: 1%;
            color: white;
            font-size: 2vh;
            position: relative;
            top: 25%;
            height: 80%;
            width: 15%;
            border-radius: 20px;
        }

        .submenu .sector {
            float: left;
            position: relative;
            vertical-align: top;
            opacity: 1;
        }

        .submenu .sector.fullwidth {
            width: 98%;
            margin-left: 1%;
            margin-right: 1%;
        }

        .submenu .sector.banner {
            height: 17%;
            top: 10.5%;
        }

        body {
            font-weight: 300;
            height: 100vh;
            margin: 0;
            text-align: center;
            font-family: Source Sans Pro;
            
            font-size: 2vh;
        }

        #content {
            width: 98%;
            height: 100%;
            margin: 0% 1% 0% 1%;
        }

        .table_title {
            width: 100%;
            height: 6%;
            position: relative;
            top: 2%;
        }

        h1 {
            display: block;
            font-size: 2em;
            margin-block-start: 0.67em;
            margin-block-end: 0.67em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            font-weight: bold;
        }

        .table_container#pages_table_container {
            top: 2%;
            height: 79%;
        }

        .table_container {
            position: relative;
            width: 100%;
            overflow-y: scroll;
        }
    </style>

    <script>
        $(function() {
            $("table.sortable").tablesorter({
                theme: "blackice",
                dateFormat: "ddmmyyyy",
                headers: {
                    9: {
                        sorter: "shortDate"
                    }
                }
            });
        });
    </script>

<body>
    <?php $results = json_decode(file_get_contents(__DIR__ . '\CACHED\production_step_table.json'), true); ?>
    <div id='background'>
        <div id="content">
            <div class="table_title green">
                <h1>PRODUCT TABLE</h1>
            </div>
            <div id="pages_table_container" class="table_container">
                <table id="p_table_<?= $exclude_step ?>" class="tfill alt_rcolor rh_med nopad active_p_row searchable sortable">
                    <thead>
                        <tr class="white wtext smedium sticky head dark_grey">
                            <th width="5%" class='lefttext'>S Order</th>
                           
                            <th width="5%" class='lefttext'>P Order</th>
                            <th width="20%" class='lefttext'>Product Group One</th>
                            <th width="10%" class='lefttext'>Product Group Two</th>
                            <th >Customer</th>
                            <th >Project</th>
                            <th >Engineer</th>
                            <!-- <th width="5%" class='lefttext'>Step</th> -->
                           <!--  <th width="5%" class='lefttext'>Planned</th>
                            <th width="5%" class='lefttext'>Booked</th>
                            <th width="5%" class='lefttext'>Remaining</th>
                            <th width="12.5%" class='lefttext'>Previous Step</th>
                            <th width="5%" class='lefttext'>Planned</th>
                            <th width="5%" class='lefttext'>Status</th>
                            <th width="12.5%" class='lefttext'>Next Step</th>
                            <th width="5%">Notes</th> -->
                        </tr>
                    <tbody>
                        <?php //print_r($data);
                        ?>
                        <?php foreach ($results as $row) : ?>



                            <?php $so = "location.href='http://vms/SAP%20READER/BASE_sales_order.php?sales_order=" . $row["Sales Order"] . "'" ?>
                            <?php $po = "location.href='http://vms/SAP%20READER/BASE_process_order.php?process_order=" . $row["Process Order"] . "'" ?>
                            <?php //if($row["Prev Step Status"] != 'RD' && $row["Prev Step Status"] != 'FS'){$hide = "display:none;";}else{$hide = "";}
                            ?>
                            <tr customer='<?= $customer ?>' project='<?= $project ?>'>
                                <td><button class='smedium so' onclick="<?= $so ?>" style="<?= $row["SUBCON"] == 'Y' ? 'background-color:#FACB57' : '' ?>"><?= $row["Sales Order"] ?></button></td>
                               
                                <td><button class='smedium rm' style="<?= $has_comment ? "background-color:#7cbfa0" : "" ?>" onclick="<?= $po ?>"><?= $row["Process Order"] ?></button></td>
                                <td class="lefttext"><?= $row["U_Product_Group_One"] ?></td>
                                <td class="lefttext"><?= $row["U_Product_Group_Two"] ?></td>
                                <td class="lefttext"><?= $row["Customer"] ?></td>
                                <td class="lefttext"><?= $row["Project"] ?></td>
                                <td class="lefttext"><?= $row["Engineer"] ?></td>
                               <!--  <td><?= '' ?></td>
                                <td><?= '' ?></td>
                                <td><?= '' ?></td>
                                <td><?= '' ?></td>
                                <td><?= '' ?></td>  -->
                                
                                <!-- <td class="light_grey"><?// $row["Instructions"] ? "<button class = 'instructions active' onclick='show_alert(" . '"' . $row["Instructions"] . '"' . ")'></button>" : "<button style = 'background-color:white; color:white' class = 'instructions'></button>" ?></td> -->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
            </div>
            <!-- <tfoot style="position:sticky; bottom: 0; z-index:+1;">
                <tr class="light_red btext">
                    <td aggregateable='Y' operation='COUNT'> </td>
                    <td aggregateable='N' operation=''> </td>
                    <td aggregateable='N' operation=''> </td>
                    <td aggregateable='N' operation=''> </td>
                    <td aggregateable='N' operation=''> </td>
                    <td style="text-align:right" aggregateable='Y' operation='SUM_P'> </td>
                    <td style="text-align:right" aggregateable='Y' operation='SUM_B'> </td>
                    <td style="text-align:right" aggregateable='Y' operation='SUM_R'> </td>
                    <td aggregateable='N' operation=''> </td>
                    <td aggregateable='N' operation=''> </td>
                    <td aggregateable='N' operation=''> </td>
                    <td aggregateable='N' operation=''> </td>
                    <td aggregateable='N' operation=''> </td>
                </tr>
            </tfoot> -->
            </table>
        </div>

        <?php  ?>
        <div id="bottom_banner" class="white sector banner fullwidth" style="height:6%;position:relative;width:100%;top:2.5%;background-color:#404040">
            <!-- <button id="go_to_google_sheets" class="new_css search_option_button banner_button yellow br_yellow">EXTRA PRODUCTION SHEETS</button> -->
            <div style="height:80%">
                <div class="text new_css">
                    <button class="fill red medium wtext">Customer</button>
                </div>
                <div class="new_css" style="margin-left: -1%;height:80%">
                    <select id="select_customer" class="selector fill medium">
                        <option value="All" selected>All</option>
                        <?php generate_filter_options($results, "Customer"); 
                        ?>
                    </select>
                </div>


                <div class="text new_css">
                    <button class="fill red medium wtext">Product Group</button>
                </div>
                <div class="new_css" style="margin-left: -1%;height:80%">
                    <select id="select_salesperson" class="selector fill medium">
                        <option value="All" selected>All</option>
                        <?php generate_filter_options($results, "U_Product_Group_One"); 
                        ?>
                    </select>

                </div>
                <div class="text new_css">
                    <button class="fill red medium wtext">Product Group</button>
                </div>
                <div class="new_css" style="margin-left: -1%;height:80%">
                    <select id="select_salesperson" class="selector fill medium">
                        <option value="All" selected>All</option>
                        <?php generate_filter_options($results, "U_Product_Group_Two"); 
                        ?>
                    </select>

                </div>
            </div>
            <!-- <button id="search_docno" class="new_css search_option_button banner_button green br_green">SEARCH PRO/SALES OERDER</button>
            <button id="multiselect_customer" class="new_css search_option_button banner_button red br_red">SELECT CUSTOMERS</button>
            <button id="multiselect_project" class="new_css search_option_button banner_button yellow br_yellow">SELECT PROJECT</button>
            <button id="export" class="new_css banner_button red br_red" onclick="$('document').ready(function(){export_production_table_to_excel($('.radio_btn_page.active table').attr('id'))});">TEMP EXPORT</button>-->

            <!-- <div id="go_to_google_sheets" class="search_option_field white" style="opacity:1; height:100%; width:38%; position:absolute; bottom:110%; left:1%; z-index:+4; border-radius:20px; border:4px solid #FACB57; display:none;">
                <div style="height:80%; position:relative; top:10%; text-align:center;">
                    <button class="rounded green medium wtext" style="height:100%; display:inline-block; width:30%;" onclick="location.href='https://docs.google.com/spreadsheets/d/1oVAMMIc7q6JP9d1svp8Jo_FYQMbcO2QRXv3IJQaTud4/edit#gid=314860047'">Laser Schedule</button>
                    <button class="rounded green medium wtext" style="height:100%; display:inline-block; width:30%;margin-left:20px;" onclick="location.href='https://docs.google.com/spreadsheets/d/1oVAMMIc7q6JP9d1svp8Jo_FYQMbcO2QRXv3IJQaTud4/edit#gid=868141021'">Intel Material Stock</button>
                </div>
            </div>

            <div id="search_docno" class="search_option_field white" style="opacity:1; height:100%; width:38%; position:absolute; bottom:110%; left:21%; z-index:+4; border-radius:20px; border:4px solid #7cbfa0; display:none;">
                <p style="float:left; height:60%; position:relative; top:35%; left:5%; font-size:2vh; margin:0;">Search Pro/Sales Order</p>
                <input type="text" placeholder="Document Number" style="float:left; height:60%; width:55%; position:relative; top:16%; left:10%; padding-left:10px;" class="search_docno medium">
            </div>

            <div id="multiselect_customer" class="search_option_field white" style="opacity:1; height:700%; width:25%; position:absolute; bottom:110%; left:41%; z-index:+4; border-radius:25px; border:5px solid #f08787; overflow-y:scroll; display:none;">
                <table style="width:100%;" class="rh_small">
                    <?php //generate_multiselect_filter_options($prod_group_steps_table, "Customer"); 
                    ?>
                </table>
            </div>

            <div id="multiselect_project" class="search_option_field white" style="opacity:1; height:700%; width:25%; position:absolute; bottom:110%; left:61%; z-index:+4; border-radius:25px; border:5px solid #FACB57; overflow-y:scroll; display:none;">
                <table style="width:100%;" class="rh_small">
                    <?php //generate_multiselect_filter_options($prod_group_steps_table, "Project"); 
                    ?> 
                </table>

            </div>-->
        </div>
    </div>
</body>

</html>