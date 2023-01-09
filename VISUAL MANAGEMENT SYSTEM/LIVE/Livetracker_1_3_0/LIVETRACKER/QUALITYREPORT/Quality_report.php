<!DOCTYPE html>
<html>

<head>
    <!-- INITALISATION -->
    <meta charset="utf-8">
    <meta name="description" content="meta description">
    <meta name="viewpport" content="width=device-width, initial-scale = 1">
    <title>Purchasing</title>

    <!-- EXTERNAL JAVASCRIPT -->
    <script type="text/javascript" src="../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

    <!-- LOCAL JAVASCRIPT -->
    <script type="text/javascript" src="../../JS LIBS/LOCAL/JS_update_total_rows.js"></script>
    <script type="text/javascript" src="../../JS LIBS/LOCAL/JS_exceptions_buttons.js"></script>
    <script type="text/javascript" src="../../JS LIBS/LOCAL/JS_filters.js"></script>
    <script type="text/javascript" src="../../JS LIBS//LOCAL/JS_comments.js"></script>
    <script type="text/javascript" src="./JS_table_to_excel.js"></script>

    <!-- STYLING -->
    <link rel="stylesheet" href="../../css/LT_style.css">
    <link rel="stylesheet" href="../../css/theme.blackice.min.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

    <?php include '../../PHP LIBS/PHP FUNCTIONS/php_functions.php'; ?>

    <?php include './SQL_quality_data.php'; ?>
    <?php
    try {
        // CONNECT TO SEVER WITH PDO SQL SERVER FUNCTION
        $conn = new PDO("sqlsrv:Server=KPTSVSP;Database=LEARNING_LOG", "sa", "SAPB1Admin");
        // CREATE QUERY EXECUTION FUNCTION
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        // REPORT ERROR
        die(print_r($e->getMessage()));
    }

    $getResults = $conn->prepare($Quality_results);
    $getResults->execute();
    $quality_results = $getResults->fetchAll(PDO::FETCH_BOTH);
    /* Filters for the product group */
    $group_array=array();
    foreach ($quality_results as $row) :
    $group_array = array('product_group_one' => $row['U_Product_Group_One'], 'product_group_two' => $row['U_Product_Group_Two'], 'product_group_three' => $row['U_Product_Group_Three'] );
endforeach;
foreach($group_array as $row):
//print_r($group_array);
endforeach;
    ?>
    <!-- TABLESORT SETUP -->
    <script>
        $(function() {
            $("table").tablesorter({
                "theme": "blackice",
                "dateFormat": "ddmmyyyy",
                "headers": {
                    1: {
                        sorter: "shortDate"
                    },
                    2: {
                        sorter: "shortDate"
                    },
                    7: {
                        sorter: false
                    }
                }
            });
        });
    </script>
</head>
<style>
    .blue {
        background-color: blue;

    }

    .red {
        background-color: red;

    }

    .green {
        background-color: green;

    }
</style>

<body>
    <div id='background'>
        <div id='content'>
            <div id='grouping_buttons_container'>
                <div id='grouping_buttons' class='fw light_grey'>
                    <div id='margin'>
                        <div class="grouping_category">
                            <button class="fill medium red wtext rounded" stage="All">All</button>
                        </div>
                        <!--
                            -->
                        <div class="grouping_category">
                            <button class="fill medium red wtext rounded" stage="Gratings">All</button>
                        </div>
                        <!--
                            -->
                        <div class="grouping_category">
                            <button class="fill medium red wtext rounded" stage="Fixings">ALL</button>
                        </div>
                        <!--
                            -->
                        <div class="grouping_category">
                            <button class="fill medium red wtext rounded" stage="Fittings">All</button>
                        </div>
                        <!--
                            -->
                        <div class="grouping_category">
                            <button class="fill medium red wtext rounded" stage="Subcontract">ALL</button>
                        </div>
                        <!--
                            -->
                        <div class="grouping_category">
                            <button class="fill medium red wtext rounded" stage="Sheets">ALL</button>
                        </div>
                        <!--
                            -->
                        <div class="grouping_category">
                            <button class="fill medium red wtext rounded" stage="Consum">Consumables</button>
                        </div>
                        <!--
                            -->
                        <div class="grouping_category">
                            <button class="fill medium red wtext rounded" stage="Other">Other</button>
                        </div>
                        <!--
                            -->
                        <div class="grouping_category">
                            <button class="fill medium red wtext rounded" stage="Intel">Intel</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table_title green" id="grouping_table_title">
                <h1>QUALITY REPORT<h1>
            </div>
            <div id='grouping_table_container' class='table_container' style="overflow-y:scroll;overflow-x:scroll;">
                <table id="purchasing_table" class="filterable sortable">
                    <thead>
                        <tr class="dark_grey wtext smedium head">
                            <th width="150px">Item no</th>
                            <th width="120px">Date raised</th>

                            <th width="170px">Owner</th>
                            <th width="200px">Target date</th>
                            <th width="120px">Days left</th>
                            <th width="120px">Sap code</th>
                            <th width="300px">Customer</th>
                            <th width="150px">SO</th>
                            <th width="200px">Project</th>
                            <th width="200px">Description</th>
                            <th width="200px">ItemCode</th>
                            <th width="150px">Product group1</th>
                            <th width="150px">Pg2</th>
                            <th width="150px">pg3</th>
                            <th width="150px">Status</th>
                            <th width="150px">Type</th>
                            <th width="150px">Response type</th>
                            <th width="150px">Admin cost</th>
                            <th width="150px">RW Cost</th>
                            <th width="150px">Materail Cost</th>
                            <th width="150px">Logistics Cost</th>
                            <th width="150px">Outside vendor cost</th>
                            <th width="150px">Total cost</th>
                            <th width="150px">Rework Type</th>
                            <th width="150px"> Time to Close</th>
                            <th width="150px"> Link to improvement</th>
                            <th width="150px"> RW Process Order</th>
                            <th width="105px"> RW SO number
                            <th>



                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($quality_results as $row) : ?>
                            <?php
                            ?>
                            <?php //   $supplier = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Supplier"]));  
                            ?>
                            <?php   $product_group = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["U_Product_Group_One"]));  
                            ?>
                            <tr stage='<?= $stage ?>' supplier='<?= $supplier ?>' product_group='<?= $product_group ?>' class="white btext smedium">
                                <td><?= $row["ID"] ?></td>
                                <td><?= $row["time_stamp"] ?></td>
                                <td><?= $row["Owner"] ?></td>
                                <td><?= $row["TargetDate"] ?></td>



                                <td style="border-left:1px solid pink;border-right:1px solid pink;width:10px; box-shadow: 0px -2px 10px 0px rgb(0 0 0 / 50%);">
                                    <?php for ($i = 0; $i < - ($row["Days_open"]); $i++) :

                                        switch ($row["Days_open"]) {
                                            case ($row["Days_open"] < 17):
                                                $color = 'green';
                                                break;
                                            case ($row["Days_open"] > 30):
                                                $color = 'green';
                                                break;
                                            default:
                                                $color = 'white';
                                                break;
                                        }
                                    ?>

                                        <div style="height:50px; margin:0; border:0;float:left;width:3px" class=<?= $color ?>></div>
                                    <?php endfor; ?><div style=width:50px;margin-left:80px;><?=-($row["Days_open"])?></div></td>
                                <td class='lefttext'><?= $row["nc_itemcode"] ?></td>


                                <td class='lefttext'><?= $row["Customer"] ?></td>
                                <td><?= $row["nc_sales_order"] ?></td>
                                <td class='lefttext'><?= $row["U_Client"] ?></td>
                                <td class='lefttext'><?= $row["Dscription"] ?></td>
                                <td ><?= $row["ItemCode"] ?></td>
                                <td class='lefttext'><?= $row["U_Product_Group_One"] ?></td>
                                <td class='lefttext'><?= $row["U_Product_Group_Two"] ?></td>
                                <td class='lefttext'><?= $row["U_Product_Group_Three"] ?></td>
                                <td class='lefttext'><?= $row["Status"] ?></td>
                                <td class='lefttext'><?= $row["form_type"] ?></td>
                                <td class='lefttext'><?= $row["Action"] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
            <div id="grouping_pages_footer" class="footer">
                <div id="button_container">
                    <button onclick="location.href='../../../MAIN MENU/dashboard_menu.php'" class="grouping_page_corner_buttons fill medium light_blue wtext rounded">MAIN MENU</button>
                </div>
                <div id="filter_container">
                    <div id="filters" class="fill red rounded">
                        <div class="filter wider">
                            <div class="text">
                                <button class="fill red medium wtext">Supplier</button>
                            </div>
                            <div class="content">
                                <select id="select_supplier" class="selector fill medium">
                                    <option value="All" selected>All</option>
                                    <?php //generate_filter_options($production_exceptions_results, "Supplier"); 
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="filter wider">
                            <div class="text">
                                <button class="fill red medium wtext">Product Group</button>
                            </div>
                            <div class="content">
                                <select id="select_product_group" class="selector fill medium">
                                    <option value="All" selected>All</option>
                                    <?php generate_filter_options($quality_results, "U_Product_Group_One"); 
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="filter wider">
                            <div class="text">
                                <button class="fill red medium wtext">UNUSED</button>
                            </div>
                            <div class="content">
                                <select class="selector fill medium">
                                    <option value="All" selected>All</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="button_container">
                    <button onclick="export_to_excel('purchasing_table')" class="grouping_page_corner_buttons fill medium green wtext rounded">EXPORT</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>