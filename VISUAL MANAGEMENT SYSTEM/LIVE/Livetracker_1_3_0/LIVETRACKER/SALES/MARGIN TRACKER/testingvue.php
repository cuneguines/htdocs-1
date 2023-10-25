<!DOCTYPE html>
<html>

<head>
    <!-- INITALISATION AND META STUFF -->
    <title>New Sales Orders</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale = 1">

    <!-- EXTERNAL JAVASCRIPT -->
    <script type="text/javascript" src="../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="../../../JS LIBS/THIRD PARTY/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="../../../JS LIBS/THIRD PARTY/jquery.tablesorter.widgets.js"></script>

    <!-- LOCAL JS -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script>
    
    <script type="text/javascript" src="../../../JS LIBS/LOCAL/JS_filters.js"></script>
    <script type="text/javascript" src="../../../JS LIBS/LOCAL/JS_comments.js"></script>
    <script type="text/javascript" src="./JS_table_to_excel.js"></script>

    <!-- STYLING -->
    <link rel="stylesheet" href="../../../CSS/LT_STYLE.css">
    <link rel="stylesheet" href="../../../css/theme.blackice.min.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

    <!-- PHP INITALISATION -->
    <!-- GET SALES ORDER FROM POST BEFORE INCLUDING QUERY (VARIABLE INLCUDED IN WHERE CLAUSE)-->
    <?php   $sales_order = isset($_GET['so']) ? $_GET['so'] : 000000;   ?>

    <?php include '../../../PHP LIBS/PHP FUNCTIONS/php_functions.php'; ?>
    <?php include '../../../SQL CONNECTIONS/conn.php'; ?>
    

    <?php
        //$getResults = $conn->prepare($margin_tracker);
        //$getResults->execute();
        //$sales_o = $getResults->fetchAll(PDO::FETCH_BOTH);
        $sales_margin = json_decode(file_get_contents(__DIR__ . '\CACHE\salesmargin.json'), true); ?>
    


    <!-- TABLESORTER INITALISATION -->
    <script>
    $(function() {
        $("table.sortable").tablesorter({
            "theme": "blackice",
            "dateFormat": "ddmmyyyy",
            "headers": {
                8: {
                    sorter: "shortDate"
                }
            }
        });
    });
    </script>
</head>
<style>
@keyframes slideInLeft {
    0% {
        transform: translateX(-100%);
    }

    100% {
        transform: translateX(0);
    }
}

h1 {
    animation-duration: 2s;
    animation-timing-function: ease-in-out;
    animation-delay: 0s;
    animation-iteration-count: 1;
    animation-name: slideInLeft;

}

th {
    width:200px;
}
</style>

<body>
    <div id="background">
        <div id="content">

            <div class="table_title " style="top:0">
                <h1 style="background:linear-gradient(100deg,black, orange)">SALES ORDER MARGIN</h1>
            </div>

            <!--  <table id="products" style="position: sticky;overflow-x:scroll;">
                            <thead style="position:sticky;top:0;z-index:+2">
                                <tr class="head">
                                    <th style="position: sticky;width:100px;left:0px;color:white;padding-left:3px">Code</th>
                                    <th style="position: sticky;width:200px;left:100px;color:white">ItemName</th>
                                    <th style="position: sticky;width:200px;left:300px;color:white">Issue</th>
                                    <th style="width:100px">ItemCode</th>
                                    <th style="width:200px">ItemGroup</th> -->

            <div id="pages_table_container" style="overflow-x:scroll;height:80%;top:0" class="table_container">
                <table id="new_sales_orders_margin" class="filterable sortable colborders">
                    <thead style="position:sticky;top:0;z-index:+2;background-color:black">
                        <!-- 		LineNum	so_status	PrcrmntMth	Qty Delivered	Cost at Delivery	Delivery Return	Cost at Return	Qty Returned	Sales Value	SO_Original_Cost	Planned_BOM_Cost	Planned Prod Order Cost	Likely Prod Ord Cost	Orig Margin	Planned BOM Margin	Planned Prod Ord Margin	Likely Prod Ord Margin -->

                        <tr class="dark_grey wtext smedium head">
                            <th style="position:sticky;width:100px;left:0px;padding-left:3px;background-color:black">
                                Sales Order</th>
                            <th style="position:sticky;width:300px;left:100px;color:white;background-color:black">
                                Project</th>
                            <th style="position:sticky;width:200px;left:400px;color:white;background-color:black">Process Order
                                </th>
                            <th style="position:sticky;width:200px;left:600px;background-color:black">Customer</th>

                            <th>Customer PO</th>
                           
                           
                           
                            <th>PP Status</th>

                          
                            <th>SO Opened</th>
                            
                            <th>Promise Date</th>
                            
                            
                           
                            <th>PG1</th>
                            <th>In Stock</th>

                            <th>ItemCode</th>
                            <th>Dscription</th>
                            <th>Quantity</th>
                            <th>Buy or Make</th>
                         
                           
                            <th>Sub BOMS?</th>
                            <th>BOM Created?</th>
                           
                            <th>BOM Size</th>
                            <th>Total Cost per BOM</th>
                           
                            <th>Material Lines</th>
                            <th>Materail Fully Issued</th>
                            <th>Material Planned Cost</th>
                            <th>Material Issued Cost</th>
                            <th>Sub Con Items</th>
                            <th>Sub Con Items Issued</th>

                            <th>Sub Con Planned Cost</th>
                            <th>Sub Con Issued Cost</th>
                            <th>Labour Items</th>
                            <th>Labour Planned Hours</th>
                            <th>Act Labour Hours</th>
                            <th>Labour Planned cost</th>
                            <th>Act Labout Cost</th>
                            <th>Machine Items</th>

                            <th>Machine Planned Hours</th>
                            <th>Act Machine Hours</th>
                            <th>Machine Planned Cost</th>
                            <th>Act Machine Cost</th>
                            <th>Total Planned Prod Cost</th>
                            <th>Materials TBI</th>

                            <th>Sub Con TBI</th>
                            <th>Labour Hours TBI</th>
                            <th>Machine Hours TBI</th>
                            <th>Unissued Mat SC Cost</th>
                            <th>Open Lab Laser Cost</th>
                            <th>Prod Status</th>


                            <th>Qty Made In Prod</th>
                            <th>Del Status</th>
                            <th>Del Qty</th>
                            <th>SO Sales Value EUR</th>
                            <th>Original SO Cost</th>
                            <th>Original SO Margin</th>


                            <th>Planned Cost</th>
                            <th>Projected Cost</th>
                            <th>Planned Margin</th>
                            <th>Proj Margin</th>


                        </tr>
                    </thead>
                    <tbody class="white">
                    <tr v-for="user in users" :key="user.id">
                        
                    <td style="position:sticky;left:0px;background-color: #009688;box-shadow: -2px 0px 8px 10px #607D8B;background:linear-gradient(100deg,#009688, white )" class="bold">
    <button class="brred rounded btext medium" v-bind:onclick="`location.href='../../../../../../SAP%20READER/SAP%20READER/BASE_sales_order.php?sales_order=' + ${user['Sales Order']}`">
        {{user['Sales Order']}}
    </button>
</td>



                            <td style="position:sticky;left:100px;background-color: #009688;box-shadow: -2px 0px 8px 10px #607D8B;background:linear-gradient(100deg,#009688, white )"
                                class='lefttext'>{{user.Project}}</td>
                            <td
                                style="position:sticky;left:400px;background-color: #009688;box-shadow: -2px 0px 8px 10px #607D8B;background:linear-gradient(100deg,#009688, white )">
                                <?= $sales_order["Process Order"] ?></td>
                            <td
                                style="position:sticky;left:600px;background-color: #009688;box-shadow: -2px 0px 8px 10px #607D8B;background:linear-gradient(100deg,#009688, white )">
                                <?= $sales_order["cardname"] ?></td>
                            <td><?= $sales_order["Customer PO"]==NULL?'NULL':$sales_order["Customer PO"]?></td>
                           
                            
                           
                            <td><?=$sales_order["PP Status"]?></td>

                         
                          
                            <td><?= $sales_order["Promise Date"] ?></td>
                            
                           
                           
                            <td><?= $sales_order["PG1"] ?></td>
                            <td><?= $sales_order["In Stock"] ?></td>

                            <td><?= $sales_order["ItemCode"] ?></td>
                            <td><?= $sales_order["Dscription"] ?></td>
                            <td><?= $sales_order["Quantity"] ?></td>
                            <td><?= $sales_order["Buy or Make"] ?></td>
                           
                            <td><?= $sales_order["Sub BOMs?"] ?></td>
                            <td><?= $sales_order["BOM Created?"] ?></td>
                            <td><?= $sales_order["BOM Create Date"] ?></td>
                            <td><?= $sales_order["BOM Size"] ?></td>
                            <td><?= $sales_order["Total Cost per BOM"] ?></td>
                           
                            <td><?= $sales_order["Material Lines"] ?></td>
                            <td><?= $sales_order["Material Fully Issued"] ?></td>
                            <td><?= $sales_order["Material Planned Cost"] ?></td>
                            <td><?= $sales_order["Material Issued Cost"] ?></td>
                            <td><?= $sales_order["Sub Con Items"] ?></td>
                            <td><?= $sales_order["Sub Con Items Issued"] ?></td>

                            <td><?= $sales_order["Sub Con Planned Cost"] ?></td>
                            <td><?= $sales_order["Sub Con Issued Cost"] ?></td>
                            <td><?= $sales_order["Labour Items"] ?></td>
                            <td><?= $sales_order["Labour Planned Hours"] ?></td>
                            <td><?= $sales_order["Act Labour Hours"] ?></td>
                            <td><?= $sales_order["Labour Planned Cost"] ?></td>
                            <td><?= $sales_order["Act Labour Cost"] ?></td>
                            <td><?= $sales_order["Machine Items"] ?></td>

                            <td><?= $sales_order["Machine Planned Hours"] ?></td>
                            <td><?= $sales_order["Act Machine Hours"] ?></td>
                            <td><?= $sales_order["Machine Planned Cost"] ?></td>
                            <td><?= $sales_order["Act Machine Cost"] ?></td>
                            <td><?= $sales_order["Total Planned Prod Cost"] ?></td>
                            <td><?= $sales_order["Materials TBI"] ?></td>

                            <td><?= $sales_order["Sub Con TBI"] ?></td>
                            <td><?= $sales_order["Labour Hours TBI"] ?></td>
                            <td><?= $sales_order["Machine Hours TBI"] ?></td>
                            <td><?= $sales_order["Unissued Mat SC Cost"] ?></td>
                            <td><?= $sales_order["Open Lab Laser Cost"] ?></td>
                            <td><?= $sales_order["Prod Status"] ?></td>


                            <td><?= $sales_order["Qty Made In Prod"] ?></td>
                            <td><?= $sales_order["Del Status"] ?></td>
                            <td><?= $sales_order["Del Qty"] ?></td>
                            <td><?= $sales_order["SO Sales Value EUR"] ?></td>
                            <td><?= $sales_order["Original SO Cost"] ?></td>
                            <td><?= $sales_order["Original SO Margin"] ?></td>


                            <td><?= $sales_order["Planned Cost"] ?></td>
                            <td><?= $sales_order["Projected Cost"] ?></td>
                            <td><?= $sales_order["Planned Margin"] ?></td>
                            <td><?= $sales_order["Proj Margin"] ?></td>











                        </tr>
                        <?
                                $cell_color='';
                                $cell_color_plan='';
                                $cell_color_likely='';
                                $cell_color_margin='';
                                ?>
                       
                    </tbody>
                </table>
            </div>
            <div id="table_pages_footer" class="footer">
                <div id="top">
                    <div id="filter_container">
                        <div id="filters" class="red fill rounded" style="box-shadow: -2px 0px 8px 0px #607D8B;
    background: linear-gradient(100deg,#009688, #8BC34A )">
                            <div class="filter">
                                <div class="text">
                                    <button class="fill red medium wtext" style="box-shadow: -2px 0px 8px 0px #607D8B;
    background: linear-gradient(100deg,#009688, #8BC34A )">Customer</button>
                                </div>
                                <div class="content">
                                    <select id="select_customer" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <?php generate_filter_options($sales_margin, "cardname"); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="filter">
                                <div class="text">
                                    <button class="fill red medium wtext" style="box-shadow: -2px 0px 8px 0px #607D8B;
    background: linear-gradient(100deg,#009688, #8BC34A )">DateCategory</button>
                                </div>
                                <div class="content">
                                    <select id="select_datecategory" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <option value="Today" selected>Today</option>
                                        <option value="Yesterday" selected>Yesterday</option>
                                        <option value="LastThreeDays" selected>Last Three Days</option>
                                        <option value="LastFiveDays" selected>Last Five Days</option>
                                        <option value="LastMonth" selected>Last Month</option>
                                        <option value="Year2021" selected>Year 2021</option>
                                        <option value="Year2022" selected>Year 2022</option>
                                        <option value="Year2023" selected>Year 2023</option>
                                        <option value="Other" selected>Other</option>


                                    </select>

                                </div>
                            </div>
                            <div class="filter">
                                <div class="text">
                                    <button class="fill red medium wtext" style="box-shadow: -2px 0px 8px 0px #607D8B;
    background: linear-gradient(100deg,#009688, #8BC34A )">Status</button>
                                </div>
                                <div class="content">
                                    <select id="select_status" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <?php generate_filter_options($sales_margin, "PP Status"); ?>
                                    </select>
                                </div>
                            </div>
                            <!--  <div class="filter">
                                <div class="text">
                                    <button class="fill red medium wtext">Sales Person</button>
                                </div>
                                <div class="content">
                                    <select id="select_sales_person" class="selector fill medium">
                                        <option value="All" selected>All</option>
                                        <?php //generate_filter_options($new_sales_orders_margin_data, "Sales Person"); ?>
                                    </select>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div id="bottom">
                    <div id="button_container">
                        <button class="grouping_page_corner_buttons fill medium light_blue wtext rounded"
                            onclick='window.history.go(-1);'>BACK</button>
                    </div>
                    <div id="button_container_wide">
                        <button onclick="location.href='../../../MAIN MENU/dashboard_menu.php'"
                            class="grouping_page_corner_buttons fill medium purple wtext rounded">MAIN MENU</button>
                    </div>
                    <div id="button_container">
                        <button onclick="export_to_excel('new_sales_orders_margin')"
                            class="grouping_page_corner_buttons fill medium green wtext rounded">EXCEL</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script>
        new Vue({
            el: '#new_sales_orders_margin',
            data: {
                users: []
            },
            mounted() {
                this.fetchData();
            },
            methods: {
                fetchData() {
                    $.ajax({
                        url: './CACHE/salesmargin.json',
                        method: 'GET',
                        success: (data) => {
                            this.users = data;
                        },
                        error: (error) => {
                            console.error('Error fetching data:', error);
                        }
                    });
                }
            }
        });
    </script>
</body>

</html>