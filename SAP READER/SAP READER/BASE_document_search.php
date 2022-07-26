<!DOCTYPE html>
<html>
    <head>
        <!-- META STUFF -->
        <title>Process Order</title>
		<meta charset = "utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name = "viewport" content = "width=device-width, initial-scale = 1">

        <!-- STYLEING -->
		<link rel = "stylesheet" href = "./LT_STYLE.css">									
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
        
        
        <!-- PHP FUNCTIONS -->
        <?php date_default_timezone_set('Europe/London'); ?>
        <?php include './php_functions.php';?>
        <?php include './php_constants.php';?>
        <?php include './conn.php';?>
        <?php $customers = get_sap_data($conn, "SELECT DISTINCT t0.CardName FROM OCRD t0 RIGHT JOIN ORDR t1 ON t1.CardCode = t0.CardCode WHERE t0.CardName IS NOT NULL" , NUMERICAL_DATA);?>
        <?php $customers_as_strings = array(); foreach($customers as $customer){array_push($customers_as_strings, $customer[0]);} ?>

        <?php $items = get_sap_data($conn, "SELECT t0.ItemCode, t0.ItemName, t0.ItmsGrpCod, t1.ItmsGrpNam FROM OITM t0 LEFT JOIN OITB t1 ON t1.ItmsGrpCod = t0.ItmsGrpCod WHERE t0.ItemName IS NOT NULL AND t1.ItmsGrpNam IS NOT NULL AND t0.ItemName NOT LIKE '%Obsolete%'" , DEFAULT_DATA);?>
        <?php $items_as_strings = array(); foreach($items as $item){array_push($items_as_strings, $item[1]);} ?>

        <?php $item_groups = get_sap_data($conn, "SELECT t0.ItmsGrpNam, t0.ItmsGrpCod FROM OITB t0" , DEFAULT_DATA);?>
        <?php $item_groups_as_strings = array(); foreach($item_groups as $item_group){array_push($item_groups_as_strings, $item_group[0]);} ?>

        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        <script type = "text/javascript" src = "JS_filters.js"></script>

        <script>var customers = <?= json_encode($customers_as_strings);?>; console.log(customers)</script>
        <script>var items = <?= json_encode($items_as_strings);?>; console.log(items)</script>
    </head>
    <body id = "sap_viewer">
        <div id = "background">
            <div id = "content">
                <div style = "float:left;width:33.3%; height:100%;">


                    <div style = "width:80%; height:25%; background-color:#ABABAB; position:relative; top:30%; margin-left:10%; margin-right:10%;">
                        <div style = "height:15%; width:100%; background-color:green; font-size:3vh">
                           Customer
                        </div>
                        <div class="wrapper" style = "height:85%; width:100%;">
                            <!--<div class="search-input" style = "height:30%; width:90%; left:5%; position:relative; top:35%;">
                                <a href="" target="_blank" hidden></a>
                                <form action="./BASE_customer.php" method="post">
                                    <input class = "input_box" type="text" placeholder="Type to search.." name = "cust" autocomplete="off">
                                    <input class = "submit_button" value = "Search" type="submit">
                                </form>
                                <div class="autocom-box no_scrollbar" style = "height:500px; overflow:scroll;">
                                here list are inserted from javascript
                                </div>
                                <div class="icon"><i class="fas fa-search"></i></div>
                               
                            </div> -->
                            <div class="ui-widget">
                                <form action = "./BASE_customer.php" method = "post">
                                    <!--Open<input type = "checkbox" name = "status" value = "Open" style = "display:inline-block; width:5%; margin-top:15px; margin-bottom:15px; height:20px;">
                                    Closed<input type = "checkbox" name = "status" value = "Open" style = "display:inline-block; width:5%; margin-top:15px; margin-bottom:15px; height:20px;">
                                    Both<input type = "checkbox" name = "status" value = "Open" style = "display:inline-block; width:5%; margin-top:15px; margin-bottom:15px; height:20px;">-->
                                    <p style = "color:black; display:inline-block; margin-right:5px;">Start Date</p><input style = "width:300px; height:40px; border:1px solid green; margin-top:2.5px; margin-bottom:2.5px; font-size:2vh;" type="text" id="datepicker" name = "start_date">
                                    <br>
                                    <p style = "color:black; display:inline-block; margin-right:5px;">End Date</p><input style = "width:300px; height:40px; border:1px solid green; margin-top:2.5px; margin-bottom:2.5px; font-size:2vh;" type="text" id="datepicker2" name = "end_date">
                                    <br>
                                    <p style = "color:black; display:inline-block; margin-right:5px;">Customer</p><input style = "width:300px; height:40px; border:1px solid green; margin-top:2.5px; margin-bottom:2.5px; font-size:2vh;" id="customers" name = "customer" placeholder = "Search">
                                    <br>
                                    <input style = "width:100px; height:40px; background-color:white; border-radius:7.5px; border:3px solid green; font-size:2vh; margin-top:8px;" value = "Search" type="submit" name = "submit">
                                </form>
                            </div>
                        </div>
                        <script>
                            $( function() {
                                var availableTags = customers;
                                $( "#customers" ).autocomplete({
                                source: availableTags
                                });
                            } );
                        </script>
                        <script>
                            $(document).ready(function(){
                                $("#datepicker").datepicker({
                                    dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                                    dateFormat:'dd-mm-yy',
                                    changeMonth:true,
                                    changeYear:true
                                }).datepicker('setDate', '-365');
                            });
                            $(document).ready(function(){
                                $("#datepicker2").datepicker({
                                    dateFormat:'dd-mm-yy',
                                    changeMonth:true,
                                    changeYear:true
                                }).datepicker('setDate', '0');
                            });
                            
                        </script>
                        <style>
                            .ui-menu-item{
                                text-align:left;
                            }
                            .ui-datepicker-calander thead tr{
                                position:relative;
                                top:0;
                            }
                            .ui-autocomplete {
                                max-height: 200px;
                                width:400px;
                                overflow-y: auto;   /* prevent horizontal scrollbar */
                                overflow-x: hidden; /* add padding to account for vertical scrollbar */
                                z-index:1000 !important;
                            }
                        </style>
                    </div>
                    <br>
                    <div style = "width:80%; height:15%; background-color:#ABABAB; position:relative; top:30%; margin-left:10%; margin-right:10%;">
                        <div style = "height:25%; width:100%; background-color:green; font-size:3vh">
                           Sales Order
                        </div>
                        <div style = "height:75%; width:100%;">
                            <div style = "height:30%; width:100%; position:relative; top:5%;">
                                <form action="./BASE_sales_order.php" method="post">
                                    <input style = "width:300px; height:40px; border:1px solid green; font-size:2vh; margin-top:2.5px; margin-bottom:2.5px;" placeholder="Enter Sales Order" type="text" name="sales_order">
                                    <br>
                                    <input style = "width:100px; height:40px; background-color:white; border-radius:7.5px; border:3px solid green; font-size:2vh;" value = "Search" type="submit">
                                    
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div style = "float:left;width:33.3%; height:100%;">
                    <div style = "width:80%; height:15%; background-color:#ABABAB; position:relative; top:40%; margin-left:10%; margin-right:10%;">
                        <div style = "height:25%; width:100%; background-color:green; font-size:3vh">
                           Process Order
                        </div>
                        <div style = "height:75%; width:100%;">
                            <div style = "height:30%; width:100%; position:relative; top:35%;">
                                <form action="./BASE_process_order.php" method="post">
                                    <input style = "width:300px; height:40px; border:1px solid green; font-size:2vh" placeholder="Enter Process Order" type="text" name="process_order">
                                    <input style = "width:100px; height:40px; background-color:white; border-radius:7.5px; border:3px solid green; font-size:2vh;" value = "Search" type="submit">
                                </form>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div style = "width:80%; height:15%; background-color:#ABABAB; position:relative; top:40%; margin-left:10%; margin-right:10%;">
                        <div style = "height:25%; width:100%; background-color:green; font-size:3vh">
                           Purchase Order
                        </div>
                        <div style = "height:75%; width:100%;">
                            <div style = "height:30%; width:100%; position:relative; top:35%;">
                                <form action="./BASE_purchase_order.php" method="post">
                                    <input style = "width:300px; height:40px; border:1px solid green; font-size:2vh" placeholder="Enter Purchase Order" type="text" name="purchase_order">
                                    <input style = "width:100px; height:40px; background-color:white; border-radius:7.5px; border:3px solid green; font-size:2vh;" value = "Search" type="submit">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div style = "float:left;width:33.3%; height:100%;">
                    <div style = "width:80%; height:15%; background-color:#ABABAB; position:relative; top:40%; margin-left:10%; margin-right:10%;">
                        <div style = "height:25%; width:100%; background-color:green; font-size:3vh">
                            Item Code
                        </div>
                        <div style = "height:75%; width:100%;">
                            <div style = "height:30%; width:100%; position:relative; top:35%;">
                                <form action="./BASE_item_code.php" method="post">
                                    <input style = "width:300px; height:40px; border:1px solid green; font-size:2vh" placeholder="Enter Product Code" id = "items" type="text" name="itm_code">
                                    <input style = "width:100px; height:40px; background-color:white; border-radius:7.5px; border:3px solid green; font-size:2vh;" value = "Search" type="submit">
                                </form>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div style = "width:80%; height:15%; background-color:#ABABAB; position:relative; top:40%; margin-left:10%; margin-right:10%;">
                        <div style = "height:25%; width:100%; background-color:green; font-size:3vh">
                            Find Items By Group Name
                        </div>
                        <div style = "height:75%; width:100%;">
                            <div style = "height:30%; width:100%; position:relative; top:35%;">
                                <form action="./BASE_item_group.php" method="post">
                                    <select class = "selector" id = "select_group" style = "width:300px; height:40px; background-color:white; border:1px solid #454545; font-size:1.8vh;" name="item_group">
                                    <?php generate_filter_options_unp($item_groups,"ItmsGrpNam");?>
                                    </select>
                                    <input style = "width:100px; height:40px; background-color:white; border-radius:7.5px; border:3px solid green; font-size:2vh;" value = "Search" type="submit">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>