<!DOCTYPE html>
<html>

<head>
    <!-- INITALISATION -->
    <meta charset="utf-8">
    <meta name="description" content="meta description">
    <meta name="viewpport" content="width=device-width, initial-scale = 1">
    <title>Quality</title>

    <!-- EXTERNAL JAVASCRIPT -->
    <script type="text/javascript" src="../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

    <!-- LOCAL JAVASCRIPT -->
    <script type="text/javascript" src="../../JS LIBS/LOCAL/JS_update_total_rows.js"></script>
    <script type="text/javascript" src="./JS_exceptions_buttons.js"></script>
    <!-- <script type="text/javascript" src="../../JS LIBS/LOCAL/JS_filters.js"></script> -->
    <script type="text/javascript" src="../../JS LIBS//LOCAL/JS_comments.js"></script>
    <script type="text/javascript" src="./JS_table_to_excel.js"></script>
    <script type="text/javascript" src="./test.js"></script>
    <script type="text/javascript" src="./JS_to_excel.js"></script>

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
        background-color: #4d79ef;

    }

    .red {
        background-color: red;

    }

    .green {
        background-color: green;

    }


    .comment_button.has_attachment {
        background-color: rgb(198, 155, 64);
    }
    .blue_pur
{
    background-color: #4d4dff
}

    .comment_button {
        height: 30px;
        width: 40px;
        border: 2px solid #454545;
        background-color: white;
        border-radius: 7px;
        vertical-align: middle;

    }
    .red_grad
    {
        background:linear-gradient(100deg,#f44336, transparent );
    }
    .green_grad
    {
        background:linear-gradient(100deg,green, transparent );
    }
    .orange_grad
    {
        background:linear-gradient(100deg,orange, transparent );
    }
    .filter.wider {
    width: 24%;
 
}
.filter {
    height: 80%;
    position: relative;
    top: 10%;
    width: 22%;
    margin: 0% 0% 0% 0%;
    display: inline-block;
    vertical-align: top;
}
.table_container#grouping_table_container {
   
    height: 57%;
}




tr.alternate {
    background-color:#CEECF5;
}
#grouping_buttons .grouping_category_new
{
    position:relative;
    vertical-align:top;
    width:8%; 
    margin:0% 1.5% 0% 1.5%;
    height:100%; 
    float:left;
}

</style>

<body>
    <div id='background'>
        <div id='content'>
            <div id='grouping_buttons_container'>
                <div id='grouping_buttons' class='fw light_grey'>
                    <div id='margin'>
                        <div class="grouping_category">
                            <button class="fill medium blue wtext rounded" stat="Open">Open</button>
                        </div>
                        <!--
                            -->
                        <div class="grouping_category">
                            <button class="fill medium blue wtext rounded" stat="Closed">Closed</button>
                        </div>
                        <!--
                            -->
                        <div class="grouping_category_new">
                            <button class="fill medium blue wtext rounded" new_stat="Duenexttwoweeks">Due next two weeks</button>
                        </div>
                        <!--
                            -->
                        <div class="grouping_category_new">
                            <button class="fill medium blue wtext rounded" new_stat="Closedlasttwoweeks">Closed last two weeks</button>
                        </div>
                        <!--
                            -->
                        <div class="grouping_category">
                            <button class="fill medium blue wtext rounded" stage="Subcontract">ALL</button>
                        </div>
                        <!--
                            -->
                        <div class="grouping_category">
                            <button class="fill medium blue wtext rounded" stage="Sheets">ALL</button>
                        </div>
                        <!--
                            -->
                        <div class="grouping_category">
                            <button class="fill medium blue wtext rounded" stage="Consum">Consumables</button>
                        </div>
                        <!--
                            -->
                        <div class="grouping_category">
                            <button class="fill medium blue wtext rounded" stat="Other">New</button>
                        </div>
                        <!--
                            -->
                        <div class="grouping_category">
                            <button class="fill medium blue wtext rounded" stage="Intel">Intel</button>
                        </div>
                    </div>
                </div>
            </div>
            <div style="color:#495c77"class="table_title white" id="grouping_table_title">
                <h1>QUALITY REPORT<h1>
            </div>
            <div id='grouping_table_container' class='table_container' style="overflow-y:scroll;overflow-x:scroll;">
                <table id="purchasing_table"  class="filterable sortable">
                    <thead>
                        <tr class="blue_pur wtext smedium head">
                            <th width="100px">Item no</th>
                            <th width="400px">Description</th>
                            <th width="120px">Date raised</th>
                            <th width="140px">Date Updated</th>
                            
                            <th width="170px">Owner</th>
                            <th width="200px">Target date</th>
                            <th width="120px">Days left</th>
                            <th width="150px"> Link to improvement</th>
                            <th width="200px">Area raised</th>
                            <th width="120px">Area Caused</th>
                            <th width="200px">Response type</th>
                            <th width="70px">Status</th>
                            <th width="300px">Customer</th>
                            <th width="200px">Type</th>
                            <th width="120px">Sap code</th>
                            
                            <th width="150px">SO</th>
                            <th width="300px">Project</th>
                            <th width="400px">Description</th>
                            <!-- <th width="200px">ItemCode</th> -->
                            <th width="200px">Product group1</th>
                            <th width="150px">Pg2</th>
                            <th width="150px">pg3</th>
                            
                            
                         
                            
                           <th width="150px">Admin cost</th>
                            <th width="150px">RW Cost</th>
                            <th width="150px">Materail Cost</th>
                            <th width="150px">Logistics Cost</th>
                            <th width="150px">Outside vendor cost</th>
                            <th width="150px">Total cost</th>
                            <th width="150px">Rework Type</th>
                            <th width="150px"> Time to Close</th>
                           
                            <th width="150px"> RW Process Order</th>
                            <th width="105px"> RW SO number</th>



                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($quality_results as $row) : ?>
                            <?php
                            ?>
                            <?php $stat = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Status"]));  
                            ?>
                            <?php   $product_group = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["U_Product_Group_One"]));  
                                  $product_group_two = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["U_Product_Group_Two"]));
                                  $product_group_three = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["U_Product_Group_Three"]));
                                  $person = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["person"]));
                                  $area_raised = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["area_raised_"]));
                                  $new_stat= str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["new_stat"]));  
                                  $area_caused= str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["nc_area_caused"])); 
                            ?>
                            
                            <tr stat='<?= $stat ?>'new_stat='<?= $new_stat?>'area_raised='<?= $area_raised ?>'area_caused='<?= $area_caused?>'person='<?= $person ?>'stage='<?= $stage ?>' supplier='<?= $supplier ?>' product_group='<?= $product_group ?>' product_group_two='<?= $product_group_two ?>'product_group_three='<?= $product_group_three ?>'class="white btext smedium">
                                <td><?= $row["ID"] ?></td>
                                <td class='lefttext'><?= $row["nc_description"]!=NULL?$row["nc_description"]:$row["cc_desc"]?></td> 
                                <td><?= $row["time_stamp"] ?></td>
                                <td><?= $row["date_updated"] ?></td>
                                <td><?= $row["person"] ?></td>
                                <td><?= $row["TargetDate"] ?></td>
                                <!-- Date Assigned -->
                                


                                <td style="border-left:1px solid pink;border-right:1px solid pink;width:10px; box-shadow: 0px -2px 10px 0px rgb(0 0 0 / 50%);">
                                <?php 
                                if ($row["Status"]=="Open")
                                {
                                switch ($row["Days_open"]) {
                                            case ($row["Days_open"] < -13):
                                                $color='red_grad';
                                                
                                                     for ($i = 0; $i <  -($row["Days_open"]); $i++) :?>
                                                   <div style="height:50px; margin:0; border:7px;float:left;width:3px" class=<?=$color ?>></div> 
                                                   <?php endfor;
                                                   break;
                                            case ($row["Days_open"] >= -13 && $row["Days_open"] <=-1):
                                                $color='orange_grad';
                                               
                                                     for ($i = 0; $i <  -($row["Days_open"]); $i++) :?>
                                                   <div style="height:50px; margin:0; border:7px;float:left;width:3px" class=<?=$color ?>></div> 
                                                   <?php endfor;
                                                   break;
                                            case ($row["Days_open"] >=0):
                                                $color='green_grad';
                                                for ($i = 0; $i <  ($row["Days_open"]); $i++) :?>
                                                <div style="height:50px; margin:0; border:7px;float:left;width:3px" class=<?=$color ?>></div> 
                                                   <?php endfor;
                                                   default:
                                                   //$color = 'white';
                                                   break;
                                                     }
                                                    }
                                      ?>
                                      
                                    <?= $row["Days_open"]==NULL?'NULL':$row["Days_open"]?></td> 
                                                    
                                    <td><input type="button" onclick=location.href="files_view_issues.php?q=<?= trim($row['ID']) ?>" style="position:relative;margin-left:37%" class='comment_button <?= $row["attachements_issues"] != 'N' ? 'has_attachment' : '' ?>'></td>
                                    <td class='lefttext'><?= $row["area_raised_"] ?></td>
                                    <td class='lefttext'><?= $row["nc_area_caused"] ?></td>
                                    <td class='lefttext'><?= $row["Action"] ?></td>
                                    <td class='lefttext Status'><?= $row["Status"] ?></td>
                                    <td class='lefttext'><?= $row["Customer"] ?></td>
                                    <td class='lefttext'><?= $row["form_type"] ?></td>
                                    <td class='lefttext'><?=$row["nc_itemcode"] ?></td>
                                


                               
                                <td><?= $row["nc_sales_order"] ?></td>
                                <td class='lefttext'><?= $row["U_Client"] ?></td>
                                <td class='lefttext'><?= $row["Dscription"] ?></td>
                                <!-- <td ><?// $row["ItemCode"] ?></td> -->
                                <td class='lefttext'><?= $row["U_Product_Group_One"] ?></td>
                                <td class='lefttext'><?= $row["U_Product_Group_Two"] ?></td>
                                <td class='lefttext'><?= $row["U_Product_Group_Three"] ?></td>
                                
                                
                                
                                
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
            <div id="grouping_pages_footer" style="bottom:7%"class="footer">
                <div id="button_container"style="width:10%">
                    <button onclick="location.href='../QUALITY1/non_conformance/non.php'" class="grouping_page_corner_buttons fill medium light_blue wtext rounded">MAIN MENU</button>
                </div>
                <div id="filter_container">
                    <div id="filters" class="fill blue rounded"style="margin-left:-6%;    width: 152%;">
                        <div class="filter wider">
                            <div class="text">
                                <button class="fill blue medium wtext">Owner</button>
                            </div>
                            <div class="content">
                                <select id="select_person" class="selector fill medium">
                                    <option value="All" selected>All</option>
                                    <?php generate_filter_options($quality_results, "person"); 
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="filter wider">
                            <div class="text">
                                <button class="fill blue medium wtext">Product Group</button>
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
                                <button class="fill blue medium wtext">Product Group two</button>
                            </div>
                            <div class="content">
                                <select id="select_product_group_two"class="selector fill medium">
                                    <option value="All" selected>All</option>
                                </select>
                            </div>
                        </div>
                        <div class="filter wider">
                            <div class="text">
                                <button class="fill blue medium wtext">Product Group three</button>
                            </div>
                            <div class="content">
                                <select id="select_product_group_three"class="selector_p3 fill medium">
                                    <option value="All" selected>All</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                   
                    <button onclick="export_to_excel('purchasing_table')" style="width:10%;margin-left: 20%;"id='resett_butt' class="grouping_page_corner_buttons fill medium blue_pur wtext rounded">EXPORT</button>
                                                
                   
                    
                                             
                                                </div>
                                               
            <div id="grouping_pages_footer" style="bottom:1%"class="footer">
                <div id="button_container"style="width:10%">
                    <!-- <button onclick="location.href='../QUALITY1/non_conformance/non.php'" class="grouping_page_corner_buttons fill medium light_blue wtext rounded">MAIN MENU</button> -->
                </div>
                <div id="filter_container">
                    <div id="filters" class="fill blue rounded"style="margin-left:-6%;    width: 152%;">
                        <div class="filter wider"style="display:none">
                            <div class="text">
                                <button class="fill blue medium wtext">Unused</button>
                            </div>
                            <div class="content">
                                <select id="select_person" class="selector fill medium">
                                    <option value="All" selected>All</option>
                                    <?php //generate_filter_options($quality_results, "person"); 
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="filter wider">
                            <div class="text">
                                <button class="fill blue medium wtext">Area Raised</button>
                            </div>
                            <div class="content">
                                <select id="select_area_raised" class="selector fill medium">
                                    <option value="All" selected>All</option>
                                    <?php generate_filter_options($quality_results, "area_raised_"); 
                                    ?>
                                </select>
                            </div>
                        </div>
                        <button style="width:10%;margin-left:1%;border:2px solid white"id='resett_but' class="grouping_page_corner_buttons fill medium blue_pur rtext rounded">RESET</button>
                        <div class="filter wider" >
                            <div class="text">
                                <button class="fill blue medium wtext">Area caused</button>
                            </div>
                            <div class="content">
                                <select id="select_area_caused"class="selector fill medium">
                                    <option value="All" selected>All</option>
                                    <?php generate_filter_options($quality_results, "nc_area_caused"); 
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="filter wider"style="display:none">
                            <div class="text">
                                <button class="fill blue medium wtext">Product Group three</button>
                            </div>
                            <div class="content">
                                <select id="select_product_group_three"class="selector_p3 fill medium">
                                    <option value="All" selected>All</option>
                                </select>
                            </div>
                        </div>

                        
                    </div>
                </div>
                <div id="button_container"style="width:10%;margin-left: 20%;">
                    <!-- <button id='file_test'onclick=//"export_to_excel('purchasing_table')" class="grouping_page_corner_buttons fill medium blue_pur wtext rounded">EXPORT</button> -->
                </div>
            </div>





        </div>
    </div>
</body>

</html>