<!DOCTYPE html>
<html>
    <head>
        <!-- INITALISATION AND META STUFF -->
        <title>TABLE LAYOUT</title>
        <meta charset = "utf-8">
        <meta name = "viewpport" content = "width=device-width, initial-scale = 1">

        <!-- EXTERNAL JAVASCRIPT -->
        <script type = "text/javascript" src = "../../../../JS LIBS/THIRD PARTY/jquery-3.4.1.js"></script>

        <!-- LOCAL JAVASCRIPT -->
        <script type = "text/javascript" src = "./JS_dropdown.js"></script>
		<script type = "text/javascript" src = "./JS_table_to_excel.js"></script>

        <!-- STYLING -->
        <link rel='stylesheet' href='../../../../CSS/LT_STYLE.css'>
        <link rel = "stylesheet" href = "../../../../css/theme.blackice.min.css">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
        
        <!-- PHP INITALISATION -->
        <?php include '../../../../SQL CONNECTIONS/conn.php'; ?>
        <?php include './SQL_richmond.php'; ?>
        <?php
            $getResults = $conn->prepare($richmond_query);
            $getResults->execute();
            $richmond_data = $getResults->fetchAll(PDO::FETCH_BOTH);
        ?>
    </head>
    <body>
        <div id = "background">
            <div id = "content">
                <div class = "table_title green">
                    <h1>RICHMOND</h1>
                </div>
                <div id = "pages_table_container" class = "table_container" style = "overflow-y:scroll">
                    <table id = "richmond_table">
                        <thead class = "wtext smallplus">
                            <tr class = "dark_grey">
                                <th width = "3%" >Collapse</th>
                                <th width = "4%">Sales Orders</th>
                                <th width = "7%">Customer</th>
                                <th width = "5%">Project</th>
                                <th width = "3%">Process Order</th>
                                <th width = "3%">Production Order</th>
                                <th width = "3%">Ref Number</th>
                                <th width = "5%">ItemCode</th>
                                <th width = "10%">Item Name</th>
                                <th width = "2%">Qty</th>
                                <th width = "2%">Delivered Qty</th>
                                <th width = "2%">Fab Status</th>
                                <th width = "4%">Floor Date</th>
                                <th width = "4%">Dispatch Date</th>
                                <th width = "4%">Promise Date</th>
                                <th width = "2%">Planned Lab</th>
                                <th width = "2%">UTM</th>
                                <th width = "16%">Comments</th>
                                <th width = "16%">Address</th>
                            </tr>
                        </thead>
                        <tbody class = 'smallplus btext white'>
                            <?php $current_sales_order = $richmond_data[0]["Sales Order"]; ?>
                            <?php for($i = 0; $i < sizeof($richmond_data) ; $i++): ?>
                                
                                <?php $subitem = $richmond_data[$i]["Est Prod"] ? 'N' : 'Y';?>
                                <?php $richmond_data[$i]["Sales Order"] == $current_sales_order ? $border = 'no_border' : $border = 'top_border'; ?>
                                <?php $richmond_data[$i]["Sales Order"] == $current_sales_order ?  : $current_sales_order = $richmond_data[$i]["Sales Order"];?>

                                <tr sales_order = '<?=$richmond_data[$i]["Sales Order"]?>' subitem = '<?=$subitem?>' style = '<?=$subitem == 'N' ? '' : 'background-color:#DCDCDC; display:none;'?>' class = '<?=$border?>'>
                                    <td><button class = 'dropdown_button inactive' sales_order = '<?=$richmond_data[$i]["Sales Order"]?>'></button></td><!--endexcludebtn-->
                                    <td class = 'saleso_td'><?=$richmond_data[$i]["Sales Order"]?></td>
                                    <td class = 'lefttext'><?=$richmond_data[$i]["Customer"]?></td>
                                    <td id = 'td_stringdata' class = 'lefttext'><?=$richmond_data[$i]["Project"]?></td>
                                    <td excludeproo><?=$richmond_data[$i]["Process Order"]?></td><!--endexcludeproo-->
                                    <td excludeprdo><?=$richmond_data[$i]["Prod Order"]?></td><!--endexcludeprdo-->
                                    <td><?=$richmond_data[$i]["Ref Number"]?></td>
                                    <td excludeitmcd><?=$richmond_data[$i]["Item Code"]?></td><!--endexcludeitmcd-->
                                    <td class = 'lefttext'><?=$richmond_data[$i]["Item Name"]?></td>
                                    <td><?=$richmond_data[$i]["Quantity"]?></td>
                                    <td><?=$richmond_data[$i]["Delivered Qty"]?></td>
                                    <td excludefs><?=$richmond_data[$i]["Fab Status %"]?></td><!--endexcludefs-->
                                    <td excludefd><?=$richmond_data[$i]["Floor Date"]?></td><!--endexcludefd-->
                                    <td><?=$richmond_data[$i]["Dispatch Date"]?></td>
                                    <td excludepd><?=$richmond_data[$i]["Promise Date"]?></td><!--endexcludepd-->
                                    <td excludepl><?=$richmond_data[$i]["Planned Lab"]?></td><!--endexcludepl-->
                                    <td excludeutm><?=$richmond_data[$i]["UTM"]?></td><!--endexcludeutm-->
                                    <td excludecom class = 'lefttext'><?=$richmond_data[$i]["Comments"]?></td><!--endexcludecom-->
                                    <td class = 'lefttext'><?=$richmond_data[$i]["Address"]?></td>
                                </tr>
                                <?php $rowcolor = ''; ?>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <div id = "table_pages_footer" class = "footer">
                    <div id = "top">
                        <div id = "filter_container">
                            <div id = "filters" class = "red fill rounded">
                                <div class = "filter">
                                    <div class = "text">
                                        <button class = "fill red medium wtext">UNUSED</button>
                                    </div>
                                    <div class = "content">
                                        <select class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                        </select>
                                    </div>
                                </div>
                                <div class = "filter">
                                    <div class = "text">
                                        <button class = "fill red medium wtext">UNUSED</button>
                                    </div>
                                    <div class = "content">
                                        <select class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                        </select>
                                    </div>
                                </div>
                                <div class = "filter">
                                    <div class = "text">
                                        <button class = "fill red medium wtext">UNUSED</button>
                                    </div>
                                    <div class = "content">
                                        <select class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                        </select>
                                    </div>
                                </div>
                                <div class = "filter">
                                    <div class = "text">
                                        <button class = "fill red medium wtext">UNUSED</button>
                                    </div>
                                    <div class = "content">
                                        <select class = "selector fill medium">
                                            <option value = "All" selected>All</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id = "bottom">                        
                        <div id = "button_container">
                            <button class = "grouping_page_corner_buttons fill medium light_blue wtext rounded">UNUSED</button>
                        </div>
                        <div id = "button_container_wide">
                            <button onclick = "location.href='../../../MAIN MENU/dashboard_menu.php'" class = "grouping_page_corner_buttons fill medium purple wtext rounded">MAIN MENU</button>
                        </div>
                        <div id = "button_container">
                            <button onclick = "export_to_excel('richmond_table')" class = "grouping_page_corner_buttons fill medium green wtext rounded">EXCEL</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>