
<?php
    // ACCEPS A DATABSE CONNECTION, QUERY AND RETURN TYPE AND RETURNS DATA ACCORDING TO RETURN TYPE  
    function get_sap_data($connection, $sql_query, $rtype){
        $getResults = $connection->prepare($sql_query);                                  
        $getResults->execute();

        switch ($rtype){
            case 0: return $getResults->fetchAll(PDO::FETCH_BOTH);
            case 1: return $getResults->fetchAll(PDO::FETCH_NUM)[0][0];
            case 2: return $getResults->fetchAll(PDO::FETCH_ASSOC)[0];
        }
    }
?>
<?php
function array_sort($array){sort($array); return $array;}

function generate_filter_options($table, $field)
{
    foreach(array_sort(array_unique(array_column($table, $field))) as $element)
    {
        echo "<option value = '".str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $element))."'>".($element)."</option>";
    }
} 
?>
<?php
    function generate_multiselect_filter_options($table, $field)
    {
        echo "<tr class = 'btext' style = 'border:none;'><td width = '90%' class = 'lefttext'>All</td><td width = '10%'><label class='container fill' style = 'margin-bottom:25px;'><input class = 'multiselector_checkbox checked' type='checkbox' name = 'check_list[]' value='All'><span class='checkmark'><div></div></span></label></td></tr>";
        foreach(array_sort(array_unique(array_column($table, $field))) as $element)
        {
            echo "<tr class = 'btext' style = 'border:none;'><td width = '90%' class = 'lefttext'>$element</td><td width = '10%'><label class='container fill' style = 'margin-bottom:25px;'><input class = 'multiselector_checkbox checked' type='checkbox' name = 'check_list[]' value='".str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $element))."'><span class='checkmark'><div></div></span></label></td></tr>";
        }
    }
?>

<?php 
    function generate_cache_dir_prefix($depth){
        if($depth == 0){return '.';}
        
        $str = "..";
        for($i = 1 ; $i < $depth ; $i++){
            $str .= '/..';
        }
        return $str;
    }
?>






<?php function print_production_step_table($data, $step_list, $exclude_step, $bkd_hrs_details, $remarks) { ?>
    <?php $week_five_weeks_ago = date('W', strtotime(date('Y-m-d'))-(5*7*24*60*60));?>
    <?php $week_twenty_five_weeks_ahead = date('W', strtotime(date('Y-m-d'))+(25*7*24*60*60)) ?>
    <script>function show_alert(message){alert(message);}</script>
    <table id = "p_table_<?=$exclude_step?>" class = "tfill alt_rcolor rh_med nopad active_p_row searchable sortable">
        <thead>
            <tr class = "white wtext smedium sticky head dark_grey">
                <th width="5%"  class = 'lefttext'>S Order</th>
                <th class="hide">Customer</th>
                <th class="hide">Project</th>
                <th class="hide">Engineer</th>
                <th width="5%"  class = 'lefttext'>P Order</th>
                <th width="20%" class = 'lefttext'>Description</th>
                <th width="10%"  class = 'lefttext'>Start Due</th>
                <th width="5%"  class = 'lefttext'>Step</th>
                <th width="5%"  class = 'lefttext'>Planned</th>
                <th width="5%"  class = 'lefttext'>Booked</th>
                <th width="5%"  class = 'lefttext'>Remaining</th>
                <th width="12.5%" class = 'lefttext'>Previous Step</th>
                <th width="5%"  class = 'lefttext'>Planned</th>
                <th width="5%"  class = 'lefttext'>Status</th>
                <th width="12.5%" class = 'lefttext'>Next Step</th>
                <th width="5%">Notes</th>
            </tr>
        <tbody>
        <?php //print_r($data);?>
            <?php foreach($data as $row): ?>
               
                <?php $customer = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Customer"])); ?>
                <?php $project = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Project"])); ?>
                <?php $stat = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Prev Step Status"])); ?>
                <?php $booked_hrs_line_details = constant($row["Sequence Code"])[0].'\n'.floatval($row["Planned Hours"]).' Hours\n'; ?>
                <?php if(isset($bkd_hrs_details[$row["Process Order"]][(string)$row["Step Number"]])){
                    foreach($bkd_hrs_details[$row["Process Order"]][$row["Step Number"]] as $entry){
                        $booked_hrs_line_details = $booked_hrs_line_details.'\n'.str_replace("'","",$entry["date"])."\t ".str_replace("'","",$entry["name"])."\t".str_replace("'","",floatval($entry["booked_qty"]));
                    }
                }?>
                <?php $remarks_line_details = $row["Process Order"].":"; ?>
                <?php if(isset($remarks[$row["Process Order"]])){
                    $has_comment = 1;
                    foreach($remarks[$row["Process Order"]] as $step_code => $entry){
                        $remarks_line_details = $remarks_line_details.'\n\n'.constant($step_code)[0];
                        foreach($entry as $ent){
                        $remarks_line_details = $remarks_line_details.'\n'.str_replace(["'",".","\r","\n"],["","","",""],$ent["date"])."\t ".str_replace(["'",".","\r","\n"],["","","",""],$ent["name"]).'\n'.str_replace(["'",".","\r","\n"],["","","",""],$ent["remarks"]);
                        }
                    }
                }
                else{
                    $has_comment = 0;
                }?>

                <?php
                    if($row["Booked Hours"] > $row["Planned Hours"]){
                        $booked_cell_color = 'red';
                    }
                    elseif($row["Booked Hours"] > $row["Planned Hours"]*0.75){
                        $booked_cell_color = 'yellow';
                    }
                    elseif($row["Booked Hours"] == 0){
                        $booked_cell_color = 'white';
                    }
                    else{
                        $booked_cell_color = 'green';
                    }
                ?>
                <!-- changed 13-12-22 -->
                <?php if($row["Sequence Code"] != $step_list[$exclude_step]){continue;}?>
                <?php $so = "location.href='http://vms/SAP%20READER/BASE_sales_order.php?sales_order=".$row["Sales Order"]."'" ?>
                <?php $po = "location.href='http://vms/SAP%20READER/BASE_process_order.php?process_order=".$row["Process Order"]."'" ?>
                <?php //if($row["Prev Step Status"] != 'RD' && $row["Prev Step Status"] != 'FS'){$hide = "display:none;";}else{$hide = "";}?>
                <tr customer = '<?=$customer?>' project = '<?=$project?>' est_step_start_due = "<?=(int)($row["Est LS Start Date DIFFWEEK"] <= -5 ? $week_five_weeks_ago : ($row["Est LS Start Date DIFFWEEK"] >= 25 ? $week_twenty_five_weeks_ahead : $row["Est LS Start Date WEEKNO"]))?>" prev_step_status = "<?=$row["Prev Step Status"] == 'FS' ? 'RD' :  $row["Prev Step Status"]?>" class = "active_p_row" style = "<?=$hide." ";?> <?=$row["Complete_Prd"] == 'Y' ? 'background-color:#7cbfa0' : ($row["Sub Component"] == 'Y' ? 'background-color:#FCF9A1' : '')?>" active_in_multiselect = 'Y'>
                    <td><button class = 'smedium so' onclick="<?=$so?>" style = "<?=$row["SUBCON"] == 'Y' ? 'background-color:#FACB57' : ''?>"><?=$row["Sales Order"]?></button></td>
                    <td class = "hide"><?=$row["Customer"]?></td>
                    <td class="hide"><?=$row["Project"]?></td>
                    <td class="hide"><?=$row["Engineer"]?></td>
                    <td><button class = 'smedium rm' style = "<?= $has_comment ? "background-color:#7cbfa0" : ""?>" onclick="<?=$po?>"><?=$row["Process Order"]?></button></td>
                    <td class = "lefttext"><?=$row["Item Name"]?></td>
                    <td><?=$row["Est LS Start Date"] ? $row["Est LS Start Date"]." (".$row["Est LS Start Date WEEKNO"].")" : "N/A"?></td>
                    <td class = "light_green righttext"><?=$row["Step Number"]?></td>
                    <td class = "p_hours light_green righttext"><?=floatval($row["Planned Hours"])?></td>
                    <td class = "b_hours light_green righttext" style = "padding:0;"><button class = 'smedium be righttext <?=$booked_cell_color?>' style = "float:right; padding:0; padding-right:5px;" onclick="alert('<?=(string)$booked_hrs_line_details?>')"><?=floatval($row["Booked Hours"])?></button></td>
                    <td class = "r_hours light_green righttext"><?=floatval($row["Remaining Hours Stage"])?></td>
                    <td class = "light_red lefttext"><?=$row["Previous Step"]?></td>
                    <td class = "light_red righttext"><?=floatval($row["Prev Step Planned Hours"])?></td>
                    <td class = "light_red"><?=$row["Prev Step Status"]?></td>
                    <td class = "Light_yellow lefttext"><?=$row["Next Step"]?></td>
                    <td class = "light_grey"><?= $row["Instructions"] ? "<button class = 'instructions active' onclick='show_alert(".'"'.$row["Instructions"].'"'.")'></button>" : "<button style = 'background-color:white; color:white' class = 'instructions'></button>"?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot style = "position:sticky; bottom: 0; z-index:+1;">
            <tr class = "light_red btext">
                <td aggregateable = 'Y' operation = 'COUNT'>                            </td>
                <td aggregateable = 'N' operation = ''>             </td>
                <td aggregateable = 'N' operation = ''>             </td>
                <td aggregateable = 'N' operation = ''>             </td>
                <td aggregateable = 'N' operation = ''>             </td>
                <td style="text-align:right"aggregateable = 'Y' operation = 'SUM_P'> </td>
                <td style="text-align:right"aggregateable = 'Y' operation = 'SUM_B'>             </td>
                <td style="text-align:right"aggregateable = 'Y' operation = 'SUM_R'>             </td>
                <td aggregateable = 'N' operation = ''>             </td>
                <td aggregateable = 'N' operation = ''>             </td>
                <td aggregateable = 'N' operation = ''>             </td>
                <td aggregateable = 'N' operation = ''>             </td>
                <td aggregateable = 'N' operation = ''>             </td>
            </tr>
        </tfoot>
    </table>
<?php } ?>
<?php function print_production_step_table_new($data, $step_list, $exclude_step, $bkd_hrs_details, $remarks) { ?>
    <?php $week_five_weeks_ago = date('W', strtotime(date('Y-m-d'))-(5*7*24*60*60));?>
    <?php $week_twenty_five_weeks_ahead = date('W', strtotime(date('Y-m-d'))+(25*7*24*60*60)) ?>
    <script>function show_alert(message){alert(message);}</script>
    <table id = "p_table_<?=$exclude_step?>" class = "tfill alt_rcolor rh_med nopad active_p_row searchable sortable">
        <thead>
            <tr class = "white wtext smedium sticky head dark_grey">
                <th width="6%"  class = 'lefttext'>S Order</th>
                <th class="hide">Customer</th>
                <th class="hide">Project</th>
                <th class="hide">Engineer</th>
                <th width="6%"  class = 'lefttext'>P Order</th>
                <th width="18%" class = 'lefttext'>Description</th>
                <th width="10%"  class = 'lefttext'>Start Due</th>
                <th >Start Due</th>
                <th width="5%"  class = 'lefttext'>Step</th>
                <th width="5%"  class = 'lefttext'>Planned</th>
                <th width="5%"  class = 'lefttext'>Booked</th>
                <th width="5%"  class = 'lefttext'>Remaining</th>
                <th width="6.75%" class = 'lefttext'>Previous Step</th>
                <th width="6.75%" class = 'lefttext'>PDM </th>
                <th width="5%"  class = 'lefttext'>PrSteps</th>
                <th width="5%"  class = 'lefttext'>Planned</th>
                <th width="5%"  class = 'lefttext'>Status</th>
                <th width="7.5%" class = 'lefttext'>Next Step</th>
                <th width="5%" class = 'lefttext'>Name</th>
                <th width="5%">Notes</th>
            </tr>
        <tbody>
        <?php //print_r($data);?>
            <?php foreach($data as $row): ?>
               
                <?php $customer = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Customer"])); ?>
                <?php $project = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Project"])); ?>
                <?php $stat = str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $row["Prev Step Status"])); ?>
                <?php $booked_hrs_line_details = constant($row["Sequence Code"])[0].'\n'.floatval($row["Planned Hours"]).' Hours\n'; ?>
                <?php if(isset($bkd_hrs_details[$row["Process Order"]][(string)$row["Step Number"]])){
                    foreach($bkd_hrs_details[$row["Process Order"]][$row["Step Number"]] as $entry){
                        $last_name=$entry["name"];
                        $booked_hrs_line_details = $booked_hrs_line_details.'\n'.str_replace("'","",$entry["date"])."\t ".str_replace("'","",$entry["name"])."\t".str_replace("'","",floatval($entry["booked_qty"]));
                    }
                    
                }
                else
                //Changed 18-01-23
            {
                $last_name="";
            }?>
                <?php $remarks_line_details = $row["Process Order"].":"; ?>
                <?php if(isset($remarks[$row["Process Order"]])){
                    $has_comment = 1;
                    foreach($remarks[$row["Process Order"]] as $step_code => $entry){
                        $remarks_line_details = $remarks_line_details.'\n\n'.constant($step_code)[0];
                        foreach($entry as $ent){
                        $remarks_line_details = $remarks_line_details.'\n'.str_replace(["'",".","\r","\n"],["","","",""],$ent["date"])."\t ".str_replace(["'",".","\r","\n"],["","","",""],$ent["name"]).'\n'.str_replace(["'",".","\r","\n"],["","","",""],$ent["remarks"]);
                        }
                    }
                }
                else{
                    $has_comment = 0;
                   
                }?>

                <?php
                    if($row["Booked Hours"] > $row["Planned Hours"]){
                        $booked_cell_color = 'red';
                    }
                    elseif($row["Booked Hours"] > $row["Planned Hours"]*0.75){
                        $booked_cell_color = 'yellow';
                    }
                    elseif($row["Booked Hours"] == 0){
                        $booked_cell_color = 'white';
                    }
                    else{
                        $booked_cell_color = 'green';
                    }
                    if ($row["Status"] == 'Pre Production Confirmed' || $row["Status"] == 'Pre Production Potential' || $row["Status"] == 'Pre Production Forecast') {
                        $pre_prod='light_blue';
                    } 
                   else
                   $pre_prod=''; 
                ?>
                <!-- changed 13-12-22 -->
                <?php if($row["Sequence Code"] != $step_list[$exclude_step]){continue;}?>
                <?php $so = "location.href='http://vms/SAP%20READER/BASE_sales_order.php?sales_order=".$row["Sales Order"]."'" ?>
                <?php $po = "location.href='http://vms/SAP%20READER/BASE_process_order.php?process_order=".$row["Process Order"]."'" ?>
                <?php $saleo = "location.href='http://localhost/VISUAL%20MANAGEMENT%20SYSTEM/LIVE/Livetracker_1_3_0/LIVETRACKER/PRODUCTION/DEMAND/SCHEDULE/BASE_production_stages%20copy.php?saleo=".$row["Sales Order"]. "," . $row["Process Order"]."'" ?>

                <?php //if($row["Prev Step Status"] != 'RD' && $row["Prev Step Status"] != 'FS'){$hide = "display:none;";}else{$hide = "";}?>
                <tr customer = '<?=$customer?>' project = '<?=$project?>' est_step_start_due = "<?=(int)($row["Est LS Start Date DIFFWEEK"] <= -5 ? $week_five_weeks_ago : ($row["Est LS Start Date DIFFWEEK"] >= 25 ? $week_twenty_five_weeks_ahead : $row["Est LS Start Date WEEKNO"]))?>" prev_step_status = "<?=$row["Prev Step Status"] == 'FS' ? 'RD' :  $row["Prev Step Status"]?>" class = "active_p_row" style = "<?=$hide." ";?> <?=$row["Complete_Prd"] == 'Y' ? 'background-color:#7cbfa0' : ($row["Sub Component"] == 'Y' ? 'background-color:#FCF9A1' : '')?>" active_in_multiselect = 'Y'>

                
                    <td class=<?=$pre_prod?>><button class = 'smedium so' onclick="<?=$so?>" style = "<?=$row["SUBCON"] == 'Y' ? 'background-color:#FACB57' : ''?>"><?=$row["Sales Order"]?></button></td>
                    <td class = "hide"><?=$row["Customer"]?></td>
                    <td class="hide"><?=$row["Project"]?></td>
                    <td class="hide"><?=$row["Engineer"]?></td>
                    <td class=<?=$pre_prod?>><button class = 'smedium rm' style = "<?= $has_comment ? "background-color:#7cbfa0" : ""?>" onclick="<?=$po?>"><?=$row["Process Order"]?></button></td>
                    <td class = "lefttext"><?=$row["Item Name"]?></td>
                    <td ><?=$row["Est LS Start Date1"] ? $row["Est LS Start Date1"]." (".$row["Est LS Start Date WEEKNO"].")" : "N/A"?></td>
                    <td><?=$row["Est LS Start Date"] ? $row["Est LS Start Date"]." <b>(".$row["Est LS Start Date WEEKNO"].")</b>" : "N/A"?></td>
                    <!-- <td class = "light_green righttext"><?//$row["Step Number"]?></td> -->
                    <td class="light_green"><button class = 'smedium so' onclick="alert('Customer:\n<?=$row['Customer']?> \n\n Project:\n<?=$row['Project']?> \n\nEngineer:\n<?=$row['Engineer']?> \n\nSales Person:\n<?=$row['Sales Person']?> \n\nEst Start Date + Workdays + Days + Remaining + Promise Date + SC Detail:\n<?=$row['Est LS Start Date']?> \t <?=$row['WORKDAYS']?> \t <?=$row['DAYS']?> \t <?=$row['REMAINING']?> \t <?=$row['Promise Date']?> \t <?=$row['SUBCON']?>');" style = "<?=$row["SUBCON"] == 'Y' ? 'background-color:#FACB57' : ''?>"><?=$row["Step Number"]?></button></td>
                    <td class="p_hours light_green"><button class = 'smedium rm' style = "<?= $has_comment ? "background-color:#7cbfa0" : ""?>" onclick="alert('<?=$remarks_line_details;?>')"><?=floatval($row["Planned Hours"])?></button></td>
                    <!-- <td class = "p_hours light_green righttext"><?//floatval($row["Planned Hours"])?></td> -->
                    <td class = "b_hours light_green righttext" style = "padding:0;"><button class = 'smedium be righttext <?=$booked_cell_color?>' style = "float:right; padding:0; padding-right:5px;" onclick="alert('<?=(string)$booked_hrs_line_details?>')"><?=floatval($row["Booked Hours"])?></button></td>
                    <td class = "r_hours light_green righttext"><?=floatval($row["Remaining Hours Stage"])?></td>
                    <td class = "light_red lefttext"><?=$row["Previous Step"]?></td>
                    <td class = "light_red "><?=$row["PDM"]?></td>

                    <td class="light_red"><button class = 'light_red smedium rm'  onclick="<?=$saleo?>"><? $row["Sales Order"]?>View</button></td>

                    <td class = "light_red righttext"><?=floatval($row["Prev Step Planned Hours"])?></td>
                    
                    <td class = "light_red"><?=$row["Prev Step Status"]?></td>
                    <td class = "Light_yellow lefttext"><?=$row["Next Step"]?></td>
                    <td class = "lefttext"><?=$last_name?></td>
                    <td class = "light_grey"><?= $row["Instructions"] ? "<button class = 'instructions active' onclick='show_alert(".'"'.$row["Instructions"].'"'.")'></button>" : "<button style = 'background-color:white; color:white' class = 'instructions'></button>"?></td>
                </tr>
              
            <?php endforeach; ?>
         
        </tbody>
        <tfoot style = "position:sticky; bottom: 0; z-index:+1;">
            <tr class = "light_red btext">
                <td aggregateable = 'Y' operation = 'COUNT'>                            </td>
                <td aggregateable = 'N' operation = ''>             </td>
                <td aggregateable = 'N' operation = ''>             </td>
                <td aggregateable = 'N' operation = ''>             </td>
                <td aggregateable = 'N' operation = ''>             </td>
                <td aggregateable = 'N' operation = ''>             </td>
                <td aggregateable = 'Y' operation = 'SUM_P'> </td>
                <td aggregateable = 'Y' operation = 'SUM_B'>             </td>
                <td style="text-align:right"aggregateable = 'Y' operation = 'SUM_R'>             </td>
                <td aggregateable = 'N' operation = ''>             </td>
                <td aggregateable = 'N' operation = ''>             </td>
                <td aggregateable = 'N' operation = ''>             </td>
                <td aggregateable = 'N' operation = ''>             </td>
                <td aggregateable = 'N' operation = ''>             </td>
                <td aggregateable = 'N' operation = ''>             </td>
                <td aggregateable = 'N' operation = ''>             </td>
            </tr>
        </tfoot>
    </table>
<?php }