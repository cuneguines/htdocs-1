<?php
    // CHECK FROM POST (SEARCH ON FRONT) IF NOT CHECK FROM GET (PO BUTTON ON SALES ORDER) OTHERWISE KILL PAGE AND PRINT ERROR 
    if(isset($_POST['sales_order'])){$sales_order = $_POST['sales_order'];}else{$sales_order = $_GET['sales_order'];}
    if(!$sales_order){
        echo "<h1 class = 'black'>invalid Sales Order</h1>";
        die();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- META STUFF -->
        <title>Sales Order</title>
		<meta charset = "utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name = "viewport" content = "width=device-width, initial-scale = 1">

        <!-- STYLEING -->
		<link rel = "stylesheet" href = "./LT_STYLE.css">							
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
        
        <!-- PHP FUNCTIONS -->
        <?php date_default_timezone_set('Europe/London');?>
        <?php
            // INCLUDE PHP FILES 
            include './conn.php';   
            include './SQL_SAP_READER.php';
            include './php_functions.php';
            include './php_constants.php';
        ?>
        <?php
            // CHECK IF SALES ORDER EXITS FOR GIVEN SALES ORDER NUMBER IF SO READ IN SALES ORDER CONTENT (LINE ITEMS) OTHERWISE KILL PAGE
            $sales_order_header = get_sap_data($conn,$sql_sales_order_header,DEFAULT_DATA);
            $sales_order_content = get_sap_data($conn,$sql_sales_order_content,DEFAULT_DATA);
            if(!$sales_order_header){
                echo "<h1 class = 'black'>Cannot Find Sales Order</h1>";
                die();
            }
            $sales_order_attachments = get_sap_data($conn,$sql_sales_order_attachments,DEFAULT_DATA);
            if($sales_order_attachments[0]["Has Attachment"] == 'Y'){
                $so_post = "window.open('./filereader_filespage.php?so=$sales_order')";
            }
            else{
                $so_post = "alert('no attachments found')";
            }
            $attachments_count = ($sales_order_attachments[0]["Attachments Count"]);
        ?>
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
                                <div class = "element short"><div class = "lefttext title_text">Raise Date</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Currency</div></div>
                            </div>
                            <div class = "subdiv right" style = "width:52%;">
                                <div class = "element short"><button class = "textbox short"><?=$sales_order_header[0]["Sales Order"]?></button></div>
                                <div class = "element short"><button class = "textbox short"><?=$sales_order_header[0]["Sales Order Status"]?></button></div>
                                <div class = "element short"><button class = "textbox short"><?=$sales_order_header[0]["Create Date"]?></button></div>
                                <div class = "element short"><button class = "textbox short"><?=$sales_order_header[0]["Currency"]." @ ".floatval($sales_order_header[0]["DocRate"])?></button></div>
                            </div>
                        </div>
                    </div>
                    <div class = "light_grey headerbox left">
                        <div class = "title green large"><h1 class = "large">Customer Details</h1></div>
                        <div class = "content">
                            <div class = "subdiv left" style = "width:40%;">
                                <div class = "element tall"><div class = "lefttext title_text">Name</div></div>
                                <div class = "element tall"><div class = "lefttext title_text">Address</div></div>
                            </div>
                            <div class = "subdiv right" style = "width:58%;">
                                <div class = "element tall"><button class = "textbox short"><?=$sales_order_header[0]["Customer Name"]?></button></div>
                                <div class = "element tall"><button class = "textbox tall"><?=$sales_order_header[0]["Delivery Address"]?></button></div>
                            </div>
                        </div>
                    </div>
                    <div class = "center green">
                        <h1 style = "margin-top:10%;">Sales<br>Order<br><?=$sales_order_header[0]["Sales Order"]?></h1>
                    </div>
                    <div class = "light_grey headerbox right">
                        <div class = "title green large"><h1 class = "large">Production Details</h1></div>
                        <div class = "content">
                            <div class = "subdiv left" style = "width:54%;">
                                <div class = "element short"><div class = "lefttext title_text">Est Engineering Time</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Act Engineering Time</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Est Production Time</div></div>
                            </div>
                            <div class = "subdiv right" style = "width:44%;">
                                <div class = "element short"><button class = "textbox short"><?=floatval($sales_order_header[0]["Est Eng Time"])?> Hrs</button></div>
                                <div class = "element short"><button class = "textbox short"><?=floatval($sales_order_header[0]["Act Eng Time"])?> Hrs</button></div>
                                <div class = "element short"><button class = "textbox short"><?=floatval($sales_order_header[0]["Est Prod Total"])?> Hrs</button></div>
                            </div>
                        </div>
                    </div>
                    <div class = "light_grey headerbox right">
                        <div class = "title green large"><h1 class = "large">Value & Currency Details</h1></div>
                        <div class = "content">
                            <div class = "subdiv left" style = "width:48%;">
                                <div class = "element short"><div class = "lefttext title_text">Value</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Vat</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Total</div></div>
                            </div>
                            <div class = "subdiv right" style = "width:50%;">
                                <!--
                                    VALUE = TOTAL MINUS VAT (DOCTOAL ON ORDR TABLE INCLUDES VAT SO WE SUBSTRACT)
                                    VAT = VAT
                                    TOTAL = TOTAL

                                    ALSO CHECKS IF SALES ORDER IS BEING PAID FOR IN FOREIGN CURRENCY AND DISPLAYS VALUE IF SO
                                -->
                                <div class = "element short"><button class = "textbox short">€ <?=number_format($sales_order_header[0]["Total"]-$sales_order_header[0]["Vat"]).($sales_order_header[0]["Currency"] != "EUR" ? " (".$sales_order_header[0]["Currency"]." ".number_format($sales_order_header[0]["Total In FC"]-$sales_order_header[0]["Vat In FC"])." )" : "")?></button></div>
                                <div class = "element short"><button class = "textbox short">€ <?=number_format($sales_order_header[0]["Vat"]).($sales_order_header[0]["Currency"] != "EUR" ? " (".$sales_order_header[0]["Currency"]." ".number_format($sales_order_header[0]["Vat In FC"]).")" : "")?></button></div>
                                <div class = "element short"><button class = "textbox short">€ <?=number_format($sales_order_header[0]["Total"]).($sales_order_header[0]["Currency"] != "EUR" ? " (".$sales_order_header[0]["Currency"]." ".number_format($sales_order_header[0]["Total In FC"]).")" : "")?></button></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "tables_container">
                    <div id = "pages_table_container" class = "table_container" style = "top:0%;">
                        <table id = "sap_reader" class = "filterable sortable searchable" style = "border-collapse: collapse;">
                            <thead>
                                <tr class = "dark_grey wtext smedium head" style = "z-index:+3;">
                                    <th width = "3%">#</th>
                                    <th class = "lefttext" width = "24%">Item Name</th>
                                    <th class = "lefttext" width = "8%">Item Code</th>
                                    <th class = "lefttext" width = "3%">Qty</th>
                                    <th class = "lefttext" width = "3%">Ordered Qty</th>
                                    <th class = "lefttext" width = "5%">Quantity Delivered</th>
                                    <th class = "lefttext" width = "4%">In Stock</th>
                                    <th class = "lefttext" width = "8%">Price</th>
                                    <th class = "lefttext" width = "11%">Sales Value</th>
                                   
                                    <!-- <th class = "lefttext" width = "4%" >Est Eng Time</th>
                                    <th class = "lefttext" width = "4%" >Act Eng Time</th>
                                    <th class = "lefttext" width = "5%" >Est Fab Hours</th> -->
                                    <th class = "lefttext" width = "6%" >Process Order</th>
                                    <th class = "lefttext" width = "5%" >SubContract</th>
                                    <th class = "lefttext" width = "7%" >Promise Date</th>
                                </tr>
                            </thead>
                            <tbody class = "btext white smedium">
                                <?php foreach($sales_order_content as $row): ?>
                                    <tr>
                                        <?php
                                    if ($row["LineStatus"] =="C") {
                                $rowcolor = "style = 'background-color:pink;'";
                            }
                            else $rowcolor='white';
                            ?>
                            
                                
                                        <td><?=$row["Line Number"]+1?></td>
                                        <td  class="lefttext"<?= $rowcolor ?>><?=$row["Item Name"]?></td>
                                        <td class = "lefttext"<?= $rowcolor ?>><button onclick = "location.href='./BASE_item_code.php?itm_code=<?=$row['Item Code']?>'"><?=$row["Item Code"]?></button></td>
                                        <td class = "righttext"<?=$rowcolor ?>><?=number_format($row["Quantity"])?></td> 
                                   <td class = "righttext"<?php $rowcolor ?>><?=number_format($row["OrderedQty"])?></td>
                                        <td class = "righttext"<?= $rowcolor ?>><?=floatval($row["Delivered Qty"])?></td>
                                        <td class = "righttext"<?= $rowcolor ?>><?=floatval($row["On Hand"])?></td>
                                        <td class = "righttext"<?= $rowcolor ?>><?=$row["Currency"]." ".number_format($row["Price"],2)?></th>
                                        <td class = "righttext"<?= $rowcolor ?>><?="EUR ".number_format($row["Total"],2).($sales_order_header[0]["Currency"] != "EUR" ? " (".$row["Currency"]." ".number_format($row["Total In FC"],2).")" : "")?></td>
                                        
                                        <!-- IF ITEM CODE IS A TARIFF OR TRANSPORT DONT PRINT REMAINING TD ELEMENTS SEE SALES ORDER 166111 FOR EX -->
                                        <?php if($row["Item Code"] != '2018 US STEEL TARIFF' && $row["Item Code"] != 'TRANSPORT'):?>
                                        
                                        <!-- <td class = "righttext"<?php // $rowcolor ?>><?php //number_format($row["Est Eng Time"])?></td>
                                        <td class = "righttext"<?php //$rowcolor ?>><?php //number_format($row["Act Eng Time"])?></td>
                                        <td class = "righttext"<?php // $rowcolor ?>><?php //number_format($row["Est Production Time"])?></td> -->
                                        <td <?= $rowcolor ?>><?php if($row['Process Order']):?> <button onclick = "location.href='./BASE_process_order.php?process_order=<?=$row['Process Order']?>'"><?=$row["Process Order"]?></button><?php endif; ?></td>
                                        <td <?= $rowcolor ?>><?=$row["U_In_Sub_Con"]?></td>
                                        <td <?= $rowcolor ?>><?=$row["Promise Date"]?></td>
                                        <?php endif; ?>
                                    </tr>   
                                <?php endforeach; ?>
                            </tbody>
                        </table>                   
                    </div>         
                </div>
                <div id = "grouping_pages_footer" class = "footer">
                    <div id = "button_container" style = "width:47%;">
                        <button class = "grouping_page_corner_buttons fill medium green wtext rounded" onclick = "history.back()">BACK</button>
                    </div>
                    <div class = "white rounded" style = "width:4%; float:left; margin-left:1%; height:100%;" onclick = "<?=$so_post?>">
                        <img style = "height:90%; margin-top:5%; width:50%; float:left;" src = "./paperclip.png">
                        <div style = "height:100%; width:50%; float:left; color:black;"><p style = "font-size:3.75vh;"><?=$attachments_count?></p></div>
                    </div>
                    <div id = "button_container" style = "width:47%; margin-left:1%;">
                        <button class = "grouping_page_corner_buttons fill medium light_blue wtext rounded" onclick = "location.href='./BASE_document_search.php';">BACK TO SEARCH</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>