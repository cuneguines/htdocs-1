<!DOCTYPE html>
<html>
    <head>
        <!-- META STUFF -->
        <title>Purchase Order</title>
		<meta charset = "utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name = "viewport" content = "width=device-width, initial-scale = 1">

        <!-- STYLEING -->
		<link rel = "stylesheet" href = "./LT_STYLE.css">									
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
        
        <!-- PHP FUNCTIONS -->
        <?php date_default_timezone_set('Europe/London'); ?>
        
        
        <?php
            // CHECK FROM POST (SEARCH ON FRONT) IF NOT CHECK FROM GET (PO BUTTON ON SALES ORDER) OTHERWISE KILL PAGE AND PRINT ERROR 
            if(isset($_POST['purchase_order'])){$purchase_order = $_POST['purchase_order'];}else{$purchase_order = $_GET['purchase_order'];}
            
            if(!$purchase_order){
                echo "<h1 class = 'black'>invalid Purchase Order</h1>"; die();
            }
        ?>
        <?php include './conn.php'; ?>       
        <?php include './SQL_SAP_READER.php';?>
        <?php include './php_functions.php';?>
        <?php include './php_constants.php';?>
        <?php $purchase_order_header = get_sap_data($conn,$sql_purchase_order_header,DEFAULT_DATA); ?>
        <?php if(!$purchase_order_header){
            echo "<h1 class = 'black'>Cannot Find Purchase Order</h1>"; die();
        }
        ?>
        <?php $purchase_order_data = get_sap_data($conn,$sql_purchase_order_data,DEFAULT_DATA); ?>
    </head>
    <body id = "sap_viewer">
        <div id = "background">
            <div id = "content">
                <div class = "header">
                    <div class = "light_grey headerbox left">
                        <div class = "title green large"><h1 class = "large">Doccument Details</h1></div>
                        <div class = "content">
                            <div class = "subdiv left" style = "width:46%;">
                                <div class = "element short"><div class = "lefttext title_text">Sales Order No.</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Status</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Currency</div></div>
                            </div>
                            <div class = "subdiv right" style = "width:52%;">
                                <div class = "element short"><button class = "textbox short"><?=$purchase_order_header[0]["Purchase Order"]?></button></div>
                                <div class = "element short"><button class = "textbox short"><?=$purchase_order_header[0]["Status"]?></button></div>
                                <div class = "element short"><button class = "textbox short"><?=$purchase_order_header[0]["Currency"]?></button></div>
                            </div>
                        </div>
                    </div>
                    <div class = "light_grey headerbox left">
                        <div class = "title green large"><h1 class = "large">Supplier Details</h1></div>
                        <div class = "content">
                            <div class = "subdiv left" style = "width:40%;">
                                <div class = "element tall"><div class = "lefttext title_text">Name</div></div>
                                <div class = "element tall"><div class = "lefttext title_text">Address</div></div>
                            </div>
                            <div class = "subdiv right" style = "width:58%;">
                                <div class = "element tall"><button class = "textbox tall"><?=$purchase_order_header[0]["Supplier Name"]?></button></div>
                                <div class = "element tall"><button class = "textbox tall"><?=$purchase_order_header[0]["Supplier Address"]?></button></div>
                            </div>
                        </div>
                    </div>
                    <div class = "center green">
                        <h1 style = "margin-top:10%;">Purchase<br>Order<br><?=$purchase_order_header[0]["Purchase Order"]?></h1>
                    </div>
                    <div class = "light_grey headerbox right">
                        <div class = "title green large"><h1 class = "large">Foreign Currency Details</h1></div>
                        <div class = "content">
                            <div class = "subdiv left" style = "width:54%;">
                                <div class = "element short"><div class = "lefttext title_text">Currency</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Total</div></div>
                            </div>
                            <div class = "subdiv right" style = "width:44%;">
                                <div class = "element short"><button class = "textbox short"><?= $purchase_order_header[0]["Currency"] != 'EUR' ? $purchase_order_header[0]["Currency"]." @ ".floatval($purchase_order_header[0]["Rate"]) : 'N/A' ?></button></div>
                                <div class = "element short"><button class = "textbox short"><?= $purchase_order_header[0]["Currency"] != 'EUR' ? $purchase_order_header[0]["Currency"]." ".number_format($purchase_order_header[0]["Foreign Currency Total"]-$purchase_order_header[0]["Vat In FC"],2) : 'N/A'?></button></div>
                            </div>
                        </div>
                    </div>
                    <div class = "light_grey headerbox right">
                        <div class = "title green large"><h1 class = "large">Costs</h1></div>
                        <div class = "content">
                            <div class = "subdiv left" style = "width:48%;">
                                <div class = "element short"><div class = "lefttext title_text">Value</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Vat</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Total</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Paid</div></div>
                            </div>
                            <div class = "subdiv right" style = "width:50%;">
                                <div class = "element short"><button class = "textbox short">€ <?=number_format($purchase_order_header[0]["Total"] - $purchase_order_header[0]["Vat"],2)." ".($purchase_order_header[0]["Currency"] != 'EUR' ? " (".$purchase_order_header[0]["Currency"]." ".(number_format($purchase_order_header[0]["Foreign Currency Total"]-$purchase_order_header[0]["Vat In FC"],2)).")" : "")?></button></div>
                                <div class = "element short"><button class = "textbox short">€ <?=number_format($purchase_order_header[0]["Vat"],2)." ".($purchase_order_header[0]["Currency"] != 'EUR' ? " (".$purchase_order_header[0]["Currency"]." ".(number_format($purchase_order_header[0]["Vat In FC"],2)).")" : "")?></button></div>
                                <div class = "element short"><button class = "textbox short">€ <?=number_format($purchase_order_header[0]["Total"],2)." ".($purchase_order_header[0]["Currency"] != 'EUR' ? " (".$purchase_order_header[0]["Currency"]." ".(number_format($purchase_order_header[0]["Foreign Currency Total"],2)).")" : "")?></button></div>
                                <div class = "element short"><button class = "textbox short">€ <?=number_format($purchase_order_header[0]["Total Paid"],2)." ".($purchase_order_header[0]["Currency"] != 'EUR' ? " (".$purchase_order_header[0]["Currency"]." ".(number_format($purchase_order_header[0]["Total Paid In FC"],2)).")" : "")?></button></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "tables_container">
                    <div id = "pages_table_container" class = "table_container no_scrollbar" style = "top:0%;">
                        <table id = "sap_reader" class = "filterable sortable searchable" style = "border-collapse: collapse;">
                            <thead>
                                <tr class = "dark_grey wtext smedium head" style = "z-index:+3;">
                                    <th width = "3%">#</th>
                                    <th>Status</th>
                                    <th class = "lefttext" width = "45%">Item Name</th>
                                    <th class = "lefttext" width = "8%">Item Code</th>
                                    <th class = "lefttext" width = "3%">Qty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody class = "btext white">
                                <?php foreach($purchase_order_data as $row): ?>
                                    <tr>
                                        <td><?=$row["Line Number"]+1?></td>
                                        <td><?=$row["Line Status"]?></td>
                                        <td class = "lefttext"><?=$row["Item Name"]?></td>
                                        <td class = "lefttext"><?=$row["Item Code"]?></td>
                                        <td><?=floatval($row["Quantity"])?></td>
                                        <td class = "lefttext"><?=$row["Currency"]." ".floatval($row["Price"])?></td>
                                        <td class = "lefttext">€ <?=number_format($row["Total"],2)." ".($row["Currency"] != 'EUR' ? " (".$row["Currency"]." ".(number_format($row["Foreign Currency Total"],2)).")" : "")?></td>
                                    </tr>   
                                <?php endforeach; ?>
                            </tbody>
                        </table>                   
                    </div>         
                </div>
                <div id = "grouping_pages_footer" class = "footer">
                    <div id = "button_container" style = "width:49%;">
                        <button class = "grouping_page_corner_buttons fill medium green wtext rounded" onclick = "history.back()">BACK</button>
                    </div>
                    <div id = "button_container" style = "width:49%; margin-left:2%;">
                        <button class = "grouping_page_corner_buttons fill medium light_blue wtext rounded" onclick = "location.href='./BASE_document_search.php';">BACK TO SEARCH</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>