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
            if(isset($_POST['process_order'])){$process_order = $_POST['process_order'];}else{$process_order = $_GET['process_order'];}
            
            if(!$process_order){
                echo "<h1 class = 'black'>Invalid Process Order</h1>"; die();
            }
            if($process_order=='NO PO'){
                echo "<h1 class = 'black'>Invalid Process Order</h1>";die();
            }
        ?>

        <?php include './conn.php'; ?>        
        <?php include './SQL_SAP_READER.php';?>
        <?php include './php_functions.php';?>
        <?php include './php_constants.php';?>
        <?php $process_order_data = get_sap_data($conn,$sql_process_order,DEFAULT_DATA); ?>

        <?php if(!$process_order_data){
            echo "<h1 class = 'black'>Cannot Find Process Order</h1>"; die();
        }
        ?>
    </head>
    <body id = "sap_viewer">
        <div id = "background">
            <div id = "content">
                <div class = "header">
                    <div class = "light_grey headerbox left">
                        <div class = "title green large"><h1 class = "large">Doccument Numbers</h1></div>
                        <div class = "content">
                            <div class = "subdiv left" style = "width:46%;">
                                <div class = "element short"><div class = "lefttext title_text">Process Order</div></div>
                                <div class = "element short"><div class = "lefttext title_text">End Product</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Sales Order</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Production Orders</div></div>
                            </div>
                            <div class = "subdiv right" style = "width:52%;">
                                <div class = "element short"><button class = "textbox short"><?=$process_order_data[0]["Process Order"]?></button></div>
                                <div class = "element short"><button class = "button short"><?=$process_order_data[0]["End Product Code"]?></button></div>
                                <div class = "element short"><button class = "button short" onclick = "location.href='./BASE_sales_order.php?sales_order=<?=$process_order_data[0]['Sales Order']?>'"><?=$process_order_data[0]["Sales Order"]?></button></div>
                                <div class = "element short"><button class = "textbox short"></button></div>
                            </div>
                        </div>
                    </div>
                    <div class = "light_grey headerbox left">
                        <div class = "title green large"><h1 class = "large">End Product Details</h1></div>
                        <div class = "content">
                            <div class = "subdiv left" style = "width:40%;">
                                <div class = "element tall"><div class = "lefttext title_text">Item Name</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Quantity</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Oh Hand</div></div>
                            </div>
                            <div class = "subdiv right" style = "width:58%;">
                                <div class = "element tall"><button class = "textbox tall"><?=$process_order_data[0]["End Product Name"]?></button></div>
                                <div class = "element short"><button class = "textbox short"><?=floatval($process_order_data[0]["Quantity"])?></button></div>
                                <div class = "element short"><button class = "textbox short"><?=floatval($process_order_data[0]["On Hand"])?></button></div>
                            </div>
                        </div>
                    </div>
                    <div class = "center green">
                        <h1 style = "margin-top:10%;">Process<br>Order<br><?=$process_order_data[0]["Process Order"]?></h1>
                    </div>
                    <div class = "light_grey headerbox right">
                        <div class = "title green large"><h1 class = "large">Production Information</h1></div>
                        <div class = "content">
                            <div class = "subdiv left" style = "width:50%;">
                                <div class = "element short"><div class = "lefttext title_text">Planned Material</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Issued Material</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Planned Labour</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Booked Labour</div></div>
                            </div>
                            <div class = "subdiv right" style = "width:48%;">
                                <div class = "element short"><button class = "textbox short">€ <?=number_format($process_order_data[0]["Planned Material"],2)?></button></div>
                                <div class = "element short"><button class = "textbox short">€ <?= !$process_order_data[0]["Planned Material"] ? "0.00" : number_format($process_order_data[0]["Issued Material"],2)." ".number_format($process_order_data[0]["Issued Material"]/$process_order_data[0]["Planned Material"]*100,2)."%"?></button></div>
                                <div class = "element short"><button class = "textbox short"><?=floatval($process_order_data[0]["Planned Labour"])?> Hrs</button></div>
                                <div class = "element short"><button class = "textbox short"><?= !$process_order_data[0]["Planned Labour"] ? "0 Hrs" : floatval($process_order_data[0]["Actual Labour"])." Hrs ".number_format($process_order_data[0]["Actual Labour"]/$process_order_data[0]["Planned Labour"]*100,2)."%"?></button></div>
                            </div>
                        </div>
                    </div>
                    <div class = "light_grey headerbox right">
                        <div class = "title green large"><h1 class = "large">Key Stakeholders</h1></div>
                        <div class = "content">
                            <div class = "subdiv left" style = "width:48%;">
                                <div class = "element short"><div class = "lefttext title_text">Engineer</div></div>
                                <div class = "element short"><div class = "lefttext title_text">Sales Person</div></div>
                                <div class = "element tall"><div class = "lefttext title_tall">Customer</div></div>
                            </div>
                            <div class = "subdiv right" style = "width:50%;">
                                <div class = "element short"><button class = "textbox short"><?=$process_order_data[0]["Engineer"]?></button></div>
                                <div class = "element short"><button class = "textbox short"><?=$process_order_data[0]["Sales Person"]?></button></div>
                                <div class = "element tall"><button class = "textbox tall"><?=$process_order_data[0]["Customer"]?></button></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "tables_container">
                    <div class = "tables">
                        <div class = "table_title green">
                            <h1 class = 'title_banner'>MATERIAL</h1>
                        </div>
                        <div id = "pages_table_container" class = "table_container no_scrollbar" style = "height:93.5%; top:0%;">
                            <table id = "sap_reader" class = "filterable sortable searchable">
                                <thead>
                                    <tr class = "dark_grey wtext smedium head" style = "z-index:+3;">
                                        <th width = "16%">Item Code</th>
                                        <th class = "lefttext" width = "50%">Part Name</th>
                                        <th class = "lefttext" width = "7%">Planned<br>Qty</th>
                                        <th width = "10%">Price</th>
                                        <th class = "lefttext" width = "7%">Issued<br>Qy</th>
                                        <th width = "10%">Cost</th>
                                    </tr>
                                </thead>
                                <tbody class = "btext white">
                                    <!-- SET UP CHECK VARIABLE (NO STEP CODE THIS TIME AS EACH STEP CODE WILL ONLY HAVE ONE ENTRY) -->
                                    <?php $production_order = ""; ?>

                                    <?php foreach($process_order_data as $row): ?>
                                        <!-- IF THE PRODUCTION ORDER ON THE NEXT LINE IS DIFFERENT PRINT A FULLSPAN ROW WITH THE NAME OF THE MAKE ITEM FOR THE PRODUCTION ORDER -->
                                        <!-- ALSO CHECK IF THE MAKE ITEM FOR THE PRODUCTION ORDER IS THE END PRODUCT FOR THE PROCESS ORDER AND COLOURS ROWS ACCORDINGLY -->
                                        <?php if($production_order != $row["Production Order"]) : ?>
                                            <tr style = "border-top:3px solid #454545; position:sticky; top:6.5%; z-index:+3;"><td colspan = 7 class = "<?=$row["End Product Code"] == $row["Item Code"] ? "light_green" : "baige"?>">Production Order <?=$row["Production Order"]?><br>(<?=$row["Item Description"]?>)</td></tr>
                                            <?php $production_order = $row["Production Order"]; $production_step_code = "";?>
                                        <?php endif;?>

                                        <!-- IF STEP TYPE IS NOT MATERIAL SKIP TO NEXT LINE ELSE PRINT DETAILS AS NORMAL TABLE ROW -->
                                        <?php if($row["Step Type"] != 'M'){continue;} ?>
                                        <tr>
                                                <td style = "border-right:1px solid #454545;"                     ><button onclick = "location.href='./BASE_item_code.php?itm_code=<?=$row['Material Code']?>'"><?=$row["Material Code"]?></button></td>
                                                <td style = "border-right:1px solid #454545;" class = "lefttext"  ><?=$row["Material Name"]?></td>
                                                <td style = "border-right:1px solid #454545;"                     ><?=floatval($row["Planned Material Qty"])?></td>
                                                <td style = "border-right:1px solid #454545;"                     ><?=floatval($row["Planned Material Cost"])?></td>
                                                <td style = "border-right:3px solid #454545;"                     ><?=floatval($row["Issued Material Qty"])?></td>
                                                <td style = "border-right:3px solid #454545;"                     ><?=floatval($row["Issued Material Cost"])?></td>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>                   
                        </div>
                    </div>
                    <div class = "tables"  style = "margin-left:2%;">
                        <div class = "table_title green">
                            <h1 class = 'title_banner'>LABOUR</h1>
                        </div>
                        <div id = "pages_table_container" class = "table_container no_scrollbar" style = "top:0%; height:93.5%;">
                            <table id = "sap_reader" class = "filterable sortable searchable" style = "border-collapse: collapse;">
                                <thead>
                                    <tr class = "dark_grey wtext smedium head" style = "z-index:+3;">
                                        <th width = "9%">Step</th>
                                        <th class = "lefttext" width = "30%">Step Description</th>
                                        <th class = "lefttext" width = "8%">Plnned<br>Hours</th>
                                        <th class = "lefttext" width = "8%" >Booked<br>Hours</th>
                                        <th width = "5%">Status</th>
                                        <th class = "lefttext" width = "30%" >Fabricator</th>
                                        <th width = "10%">Hours</th>
                                    </tr>
                                </thead>
                                <tbody class = "btext white">
                                    <!-- SET UP CHECK VARIABLES -->
                                    <?php $production_order = $production_step_code = ""; ?>

                                    <?php foreach($process_order_data as $row): ?>
                                        
                                        <!-- IF THE PRODUCTION ORDER ON THE NEXT LINE IS DIFFERENT PRINT A FULLSPAN ROW WITH THE NAME OF THE MAKE ITEM FOR THE PRODUCTION ORDER -->
                                        <!-- ALSO CHECK IF THE MAKE ITEM FOR THE PRODUCTION ORDER IS THE END PRODUCT FOR THE PROCESS ORDER AND COLOURS ROWS ACCORDINGLY -->
                                        <?php if($production_order != $row["Production Order"]) : ?>
                                           
                                            <tr style = "border-top:3px solid #454545;"><td colspan = 7 class = "<?=$row["End Product Code"] == $row["Item Code"] ? "light_green" : "baige"?>">Production Order <?=$row["Production Order"]?><br>(<?=$row["Item Description"]?>)</td></tr>
                                            <?php $production_order = $row["Production Order"]; $production_step_code = "";?>
                                        <?php endif;?>

                                        <!-- IF STEP TYPE OF ROW IS NOT LABOUR THEN SKIP TO NEXT -->
                                        <?php if($row["Step Type"] != 'B'){continue;} ?>
                                        <tr >
                                            <!-- IF THERE IS A NEW LABOUR STEP CODE ECHO THE DETAILS OF THAT STEP WITH A ROWSPAN EUQAL TO THE NUMBER OF ENTREIS FOR THAT STEP (IN QUERY) -->
                                            <!-- THEN PRINT DETAILS OF ENRTY (QTY OF HRS AND NAME OF FAB) -->
                                            <?php if($row["Labour Code"] != $production_step_code || $row["Labour Code"]=='3000617'): ?>
                                                <?php $production_step_code = $row["Labour Code"]; ?>
                                                <?php $brtop = "border-top:3px solid #454545;"; ?>
                                                <td rowspan = "<?=$row["No Of Step Entries"] == 0 ? 1 : $row["No Of Step Entries"]?>" style = "border-right:1px solid #454545; border-top:3px solid #454545;"                     ><?=$row["Labour Step Number"]?></td>
                                                <td rowspan = "<?=$row["No Of Step Entries"] == 0 ? 1 : $row["No Of Step Entries"]?>" style = "border-right:1px solid #454545; border-top:3px solid #454545;" class = "lefttext"  ><?=$row["Labour Description"]?></td>
                                                <td rowspan = "<?=$row["No Of Step Entries"] == 0 ? 1 : $row["No Of Step Entries"]?>" style = "border-right:1px solid #454545; border-top:3px solid #454545;"                     ><?=floatval($row["Planned Labour Step"])?></td>
                                                <td rowspan = "<?=$row["No Of Step Entries"] == 0 ? 1 : $row["No Of Step Entries"]?>" style = "border-right:1px solid #454545; border-top:3px solid #454545;"                     ><?=floatval($row["Booked Labour Step"])?></td>
                                                <td rowspan = "<?=$row["No Of Step Entries"] == 0 ? 1 : $row["No Of Step Entries"]?>" style = "border-right:3px solid #454545; border-top:3px solid #454545;"                     ><?=$row["Labour Step Status"]?></td>
                                            <?php endif; ?>
                                            <td rowspan = "1" style = "<?=$brtop?> border-right:1px solid #454545" class = "lefttext"><?=$row["Fabricator"]?></td>
                                            <td rowspan = "1" style = "<?=$brtop?> border-left:1px solid #454545"><?=floatval($row["Booked Labour Entry"])?></td>
                                            <?=$brtop = "";?>
                                        </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>                   
                        </div>
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