<?php
    // CHECK FROM $_POST (SEARCH ON FRONT) IF NOT CHECK FROM $_GET (PO BUTTON ON SALES ORDER) OTHERWISE KILL PAGE AND PRINT ERROR 
    //isset($_POST['tags']) ? $customer = $_POST['tags'] : $customer = $_GET['cust'];
    if(isset($_POST['submit'])){
        // SET CLAUSES FOR SQL QUERY
        $customer = $_POST['customer']; 
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        $start_date = date('Y-m-d', strtotime($start_date));
        $end_date = date('Y-m-d', strtotime($end_date));
    }
    elseif(isset($_GET['cust'])){
        $customer = $_GET['cust'];
    }
    else{
        die();
    }
    if(!$customer){
        echo "<h1 class = 'black'>No Customer Selected</h1><button onclick = 'history.back();'>Back</button>"; die();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- META STUFF -->
        <title><?=$customer?> Orders</title>
		<meta charset = "utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name = "viewport" content = "width=device-width, initial-scale = 1">

        <!-- STYLEING -->
		<link rel = "stylesheet" href = "./LT_STYLE.css">	
        <link rel = "stylesheet" href = "./theme.blackice.min.css">									
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

        <!-- JS FILES -->
        <script type = "text/javascript" src = "./jquery-3.4.1.js"></script>
        <script type = "text/javascript" src = "./JS_filters.js"></script>
        <script type = "text/javascript" src = "./jquery.tablesorter.js"></script>
        
        <!-- PHP FUNCTIONS -->
        <?php date_default_timezone_set('Europe/London'); ?>
        <?php 
            include './conn.php';      
            include './SQL_SAP_READER.php';
            include './php_functions.php';
            include './php_constants.php';
        ?>
        <?php
            $customer_header_data = get_sap_data($conn,$sql_customer_header,DEFAULT_DATA);
            $customer_content_data = get_sap_data($conn,$sql_customer_content,DEFAULT_DATA);
            if(!$customer_header_data){
            echo "<h1 class = 'black'>Cannot Find Sales Order</h1>"; die();
            }
        ?>

        <script>
            $(function(){
                $("table.sortable").tablesorter({
                    "theme" : "blackice",
                    "dateFormat" : "ddmmyyyy",
                    "headers" : {
                        7: {sorter : "shortDate"},
                        8: {sorter : "shortDate"},
                        9: {sorter : "shortDate"},
                        14: {sorter : "shortDate"},
                        19: {sorter : "shortDate"}
                    }
                });
            });
        </script>
    </head>
    <body id = "sap_viewer">
        <div id = "background">
            <div id = "content">
                <div class = "header">
                    <div class = "light_grey headerbox left">
                        <div class = "title green large"><h1 class = "large">Customer Details</h1></div>
                        <div class = "content">
                            <div class = "subdiv left" style = "width:46%;">
                                <div class = "element short"><div class = "lefttext title_text">Customer Code</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Customer Name</div></div>
                            </div>
                            <div class = "subdiv right" style = "width:52%;">
                                <div class = "element short"><button class = "textbox short"><?=$customer_header_data[0]["CardCode"]?></button></div>
                                <div class = "element short"><button class = "textbox short"><?=$customer_header_data[0]["CardName"]?></button></div>
                            </div>
                        </div>
                    </div>
                    <div class = "light_grey headerbox left">
                        <div class = "title green large"><h1 class = "large">Contact Details</h1></div>
                        <div class = "content">
                            <div class = "subdiv left" style = "width:40%;">
                                <div class = "element short"><div class = "lefttext title_text">Phone</div></div>
                                <div class = "element tall"><div class = "lefttext title_text">Address</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Contact Person</div></div>
                            </div>
                            <div class = "subdiv right" style = "width:58%;">
                                <div class = "element short"><button class = "textbox short"><?=$customer_header_data[0]["Phone1"]?></button></div>
                                <div class = "element tall"><button class = "textbox tall"><?=$customer_header_data[0]["Address"]?></button></div>
                                <div class = "element short"><button class = "textbox short"><?=$customer_header_data[0]["CntctPrsn"]?></button></div>
                                
                            </div>
                        </div>
                    </div>
                    <div class = "center green">
                        <h1 style = "margin-top:10%;">Customer<br>Code<br><?=$customer_header_data[0]["CardCode"]?></h1>
                    </div>
                    <div class = "light_grey headerbox right">
                        <div class = "title green large"><h1 class = "large">Sales Figures</h1></div>
                        <div class = "content">
                            <div class = "subdiv left" style = "width:54%;">
                                <div class = "element short"><div class = "lefttext title_text">Sales Orders</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Sales Value</div></div>
                            </div>
                            <div class = "subdiv right" style = "width:44%;">
                                <div class = "element short"><button class = "textbox short"><?=floatval($customer_header_data[0]["Sales Orders"])?></button></div>
                                <div class = "element short"><button class = "textbox short">€ <?=number_format($customer_header_data[0]["Total Sales"],2)?></button></div>
                            </div>
                        </div>
                    </div>
                    <div class = "light_grey headerbox right">
                        <div class = "title green large"><h1 class = "large"></h1></div>
                        <div class = "content">
                            <div class = "subdiv left" style = "width:48%;">              
                            </div>
                            <div class = "subdiv right" style = "width:50%;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "tables_container">
                    <div id = "pages_table_container" class = "table_container" style = "top:0%;">
                        <table id = "sap_reader" class = "filterable sortable searchable" style = "border-collapse: collapse;">
                            <thead>
                                <tr class = "dark_grey wtext smedium head" style = "z-index:+3;">
                                    <th width = "6%">Sales Order</th>
                                    <th class = "lefttext" width = "5%">Status</th>
                                    <td class = "lefttext" width = "25%">Customer</td>
                                    <td class = "lefttext" width = "10%">Sales Person</td>
                                    <th class = "lefttext" width = "10%">Project</th>
                                    <th class = "lefttext" width = "10%">Promise Date</th>
                                    <th class = "lefttext" width = "10%">Sales Value</th>
                                    <th class = "lefttext" width = "10%">Engineer</th>
                                </tr>
                            </thead>
                            <tbody class = "btext white">
                                <!-- -> SET UP TRACKER VARIABLES THAT STORE INFO FOR EACH SALES ORDER (THERE MAY BE MORE THAN ONE LINE OF INFO FOR A SALES ORDER IN QUERY) -->
                                <!-- -> STORE INFO FOR FIRST ENTRY -->
                                <?php 
                                    if(sizeof($customer_content_data) == 0){
                                        echo "NO ORDERS BEYWEEN DATES GIVEN";
                                    }
                                    else{
                                        $items = $engineers = $engineers_for_filter = array();
                                        $current_so = $customer_content_data[0]["Sales Order"];
                                        array_push($engineers, $customer_content_data[0]["Engineer"]);
                                        array_push($engineers_for_filter, str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $customer_content_data[0]["Engineer"])));
                                    }
                                ?>

                                <!-- FOR EACH LINE IN QUERY -->
                                <?php if(sizeof($customer_content_data) == 0){echo "NO ORDERS BEYWEEN DATES GIVEN";}
                                        else{
                                    for($i = 0; $i <= sizeof($customer_content_data); $i++): ?>

                                    <!-- IF THE END OF THE CONTENT ARRAY HAS BEEN REACHED OR THERE IS A NEW SALES ORDER PRINT THE DATA FROM THE PREVIOUS CURRENT SALES ORDER THEN UPDATE BUFFER VARIBLES FOR CURRENT SALES ORDER -->
                                    <?php if($i == sizeof($customer_content_data) || $customer_content_data[$i]["Sales Order"] != $current_so): ?>

                                        <?php 
                                            $sales_person = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $customer_content_data[$i-1]["Sales Person"]));
                                            $project = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $customer_content_data[$i-1]["Project"]));
                                            $engineers_list = implode(",",$engineers_for_filter);
                                        ?>

                                        <tr sales_person = "<?=$sales_person?>" project = "<?=$project?>" engineer = "<?=$engineers_list;?>">
                                            <td><button onclick = "location.href='./BASE_sales_order.php?sales_order=<?=$customer_content_data[$i-1]['Sales Order']?>'"><?=$customer_content_data[$i-1]["Sales Order"]?></button></td>
                                            <td class = "lefttext"><?=$customer_content_data[$i-1]["Status"]?></td>
                                            <td class = "lefttext"><?=$customer_content_data[$i-1]["Customer"]?></td>
                                            <td class = "lefttext"><?=$customer_content_data[$i-1]["Sales Person"]?></td>
                                            <td class = "lefttext"><?=$customer_content_data[$i-1]["Project"]?></td>
                                            <td class = "lefttext"><?=$customer_content_data[$i-1]["Promise Date"]?></td>
                                            <td class = "lefttext">€ <?=number_format($customer_content_data[$i-1]["Sales Value"],2)?></td>
                                            <td class = "lefttext"><?=implode("<br><br>",$engineers)?></td>
                                        </tr>

                                        <?php if($i == sizeof($customer_content_data)){ break; }?>

                                        <?php
                                            $items = $engineers =  $engineers_for_filter = array();
                                            $current_so = $customer_content_data[$i]["Sales Order"];
                                        ?>
                                    <?php endif; ?>

                                    <!-- PUSH DATA FROM CURRENT ROW INTO VARIABLES -->
                                    <?php
                                        array_push($items, $customer_content_data[$i]["Item Name"]);
                                        !in_array($customer_content_data[$i]["Engineer"], $engineers) ? array_push($engineers, $customer_content_data[$i]["Engineer"]):NULL;
                                        !in_array(str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $customer_content_data[$i]["Engineer"])), $engineers_for_filter) ? array_push($engineers_for_filter, str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $customer_content_data[$i]["Engineer"]))):NULL;
                                    ?>
                                <?php endfor;} ?>
                            </tbody>
                        </table>                   
                    </div>         
                </div>
                <div id = "grouping_pages_footer" class = "footer">
                    <div id = "button_container">
                        <button class = "grouping_page_corner_buttons fill medium green wtext rounded" onclick = "history.back();">BACK</button>
                    </div>
                    <div id = "filter_container">
                        <div id = "filters" class="fill red rounded">
                            <div class = "filter wider" style="width:20%">
                                <div class = "text">
                                    <button class = "fill red medium wtext">Salesperson</button>
                                </div>
                                <div class = "content">
                                    <select id = "select_sales_person" class = "selector fill medium">
                                        <option value = "All" selected>All</option>
                                        <?php if(sizeof($customer_content_data) != 0){generate_filter_options($customer_content_data, "Sales Person");}?>
                                    </select>
                                </div>
                            </div>
                            <div class = "filter wider" style="width:20%">
                                <div class = "text">
                                    <button class = "fill red medium wtext">Project</button>
                                </div>
                                <div class = "content">
                                    <select id = "select_project" class = "selector fill medium">
                                        <option value = "All" selected>All</option>
                                        <?php if(sizeof($customer_content_data) != 0){generate_filter_options($customer_content_data, "Project");}?>
                                    </select>
                                </div>
                            </div>
                            <div class = "filter wider"style="width:20%">
                                <div class = "text">
                                    <button class = "fill red medium wtext">Engineer</button>
                                </div>
                                <div class = "content">
                                    <select id = "select_engineer" class = "selector multi_option fill medium">
                                        <option value = "All" selected>All</option>
                                        <?php if(sizeof($customer_content_data) != 0){generate_filter_options($customer_content_data, "Engineer");}?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id = "button_container">
                        <button class = "grouping_page_corner_buttons fill medium light_blue wtext rounded" onclick = "location.href='./BASE_document_search.php';">BACK TO SEARCH</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>