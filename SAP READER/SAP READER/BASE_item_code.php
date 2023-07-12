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
        
        <?php
            // CHECK FROM POST (SEARCH ON FRONT) IF NOT CHECK FROM GET (PO BUTTON ON SALES ORDER) OTHERWISE KILL PAGE AND PRINT ERROR 
            if(isset($_POST['itm_code'])){$item_code = $_POST['itm_code'];}else{$item_code = $_GET['itm_code'];}
            
            if(!$item_code){
                echo "<h1 class = 'black'>invalid Item Code</h1>"; die();
            }
        ?>
        <?php include './conn.php'; ?>        
        <?php include './SQL_SAP_READER.php';?>
        <?php include './php_functions.php';?>
        <?php include './php_constants.php';?>
        <?php $item_code_header_data = get_sap_data($conn,$sql_item_code_header,DEFAULT_DATA); ?>
        <?php $item_code_content_data = get_sap_data($conn,$sql_item_code_content,DEFAULT_DATA); ?>
        <?php $item_code_content_data_2 = get_sap_data($conn,$sql_item_code_content_2,DEFAULT_DATA); ?>
        
        
        
        
        <?php if(!$item_code_content_data){
            echo "<h1 class = 'black'>Cannot Find Item Code</h1>"; die();
        }?>
        <?php
            $item_code_attachments = get_sap_data($conn,$sql_item_code_attachments,DEFAULT_DATA);
            if($item_code_attachments[0]["Has Attachment"] == 'Y'){
                $itm_post = "window.open('./filereader_filespage.php?itm=$item_code')";
            }
            else{
                $itm_post = "alert('no attachments found')";
            }
            $attachments_count = ($item_code_attachments[0]["Attachments Count"]);
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
                                <div class = "element short"><div class = "lefttext title_text">Item Code</div></div>
                                <div class = "element tall"><div class = "lefttext title_text">Description</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Item Group</div></div>
                            </div>
                            <div class = "subdiv right" style = "width:52%;">
                                <div class = "element short"><button class = "textbox short"><?=$item_code_header_data[0]["Item Code"]?></button></div>
                                <div class = "element tall"><button class = "textbox tall"><?=$item_code_header_data[0]["Item Name"]?></button></div>
                                <div class = "element short"><button class = "textbox short"><?=$item_code_header_data[0]["Item Group"]?></button></div>
                            </div>
                        </div>
                    </div>
                    <div class = "light_grey headerbox left">
                        <div class = "title green large"><h1 class = "large">General Stock Level Details</h1></div>
                        <div class = "content">
                            <div class = "subdiv left" style = "width:45%;">
                                <div class = "element short"><div class = "lefttext title_text">Total On Hand</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Est Unit Cost</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Stock Value</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Total Committed</div></div>
                            </div>
                            <div class = "subdiv right" style = "width:53%;">
                                <div class = "element short"><button class = "textbox short"><?=floatval($item_code_header_data[0]["On Hand"])?></button></div>
                                <div class = "element short"><button class = "textbox short">€ <?=floatval($item_code_header_data[0]["Standard Price"])?></button></div>
                                <div class = "element short"><button class = "textbox short">€ <?=floatval($item_code_header_data[0]["Value"])?></button></div>
                                <div class = "element short"><button class = "textbox short"><?=floatval($item_code_header_data[0]["Committed"])?></button></div>
                            </div>
                        </div>
                    </div>
                    <div class = "center green">
                        <h1 style = "margin-top:10%;">Item<br>Code<br><?=$item_code_content_data[0]["Item Code"]?></h1>
                    </div>
                    <div class = "light_grey headerbox right">
                        <div class = "title green large"><h1 class = "large">Order Details</h1></div>
                        <div class = "content">
                            <div class = "subdiv left" style = "width:54%;">
                                <div class = "element short"><div class = "lefttext title_text">Qty On Order</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Next Delivery Due</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Item Group Name</div></div>
                            </div>
                            <div class = "subdiv right" style = "width:44%;">
                                <div class = "element short"><button class = "textbox short"><?=floatval($item_code_header_data[0]["On Order"])?></button></div>
                                <div class = "element short"><button class = "textbox short"><?=(($item_code_header_data[0]["Next Del Date"])?($item_code_header_data[0]["Next Del Date"]):"NOT ON ORDER")?></button></div>
                                <div class = "element short"><button class = "textbox short"><?=$item_code_content_data[0]["Item Group Name"]?></button></div>
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
                    <div id = "pages_table_container" class = "table_container " style = "top:0%; overflow-y:hidden;">
                        <div class = "tables"  style = "width:50%; height:100%;">
                            <div class = "table_title green">
                                <h1 class = 'title_banner'>STOCK LEVELS</h1>
                            </div>
                            <div id = "pages_table_container" class = "table_container" style = "top:0%;">
                                <table id = "sap_reader" class = "filterable sortable searchable" style = "border-collapse: collapse;">
                                    <thead>
                                        <tr class = "dark_grey wtext">
                                            <th width="20%" class = "lefttext">Warehouse</th>
                                            <th width="20%" class = "lefttext">On Hand</th>
                                            <th width="20%" class = "lefttext">Value</th>
                                            <th width="20%" class = "lefttext">PrcmntMtd</th>
                                        </tr>
                                    </thead>
                                    <tbody class = "white">
                                        <?php foreach($item_code_content_data as $row):?>
                                            <tr class = "btext">
                                            <td class="lefttext"><?= $row["Warehouse"] ?? "N/A" ?></td>
                                                <td class = "righttext"><?//floatval($row["On Hand"])?></td>
                                                <td class = "righttext"><?//floatval($row["Value"])?></td>
                                                <td><?=$row["Prc"]?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>                   
                            </div>
                        </div>   
                        <div class = "tables"  style = "width:48%;margin-left:2%; height:100%;">
                            <div class = "table_title green">
                                <h1 class = 'title_banner'>SALES ORDERS</h1>
                            </div>
                            <div id = "pages_table_container" class = "table_container no_scrollbar" style = "top:0%;">
                                <table id = "sap_reader" class = "filterable sortable searchable" style = "border-collapse: collapse;">
                                    <thead>
                                        <tr class = "dark_grey wtext">
                                            <th width="20%" class = "lefttext">Sales Order</th>
                                            <th width="20%" class = "lefttext">Customer</th>
                                            <th width="20%" class = "lefttext">Created</th>
                                            <th width="20%" class = "lefttext">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody class = "white">
                                        <?php foreach($item_code_content_data_2 as $row):?>
                                            <tr class = "btext">
                                                <td class = "lefttext"><button onclick = "location.href='./BASE_sales_order.php?sales_order=<?=$row['DocNum']?>'"><?=$row['DocNum']?></button></td>
                                                <td class = "righttext"><?=$row["CardName"]?></td>
                                                <td class = "righttext"><?=$row["Create Date"]?></td>
                                                <td><?=$row["Currency"]." ".number_format($row["Price"],2)?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>                   
                            </div>
                        </div>                 
                    </div>         
                </div>
                <div id = "grouping_pages_footer" class = "footer">
                    <div id = "button_container" style = "width:47%;">
                        <button class = "grouping_page_corner_buttons fill medium green wtext rounded" onclick = "history.back()">BACK</button>
                    </div>
                    <div class = "white rounded" style = "width:4%; float:left; margin-left:1%; height:100%;" onclick = "<?=$itm_post?>">
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