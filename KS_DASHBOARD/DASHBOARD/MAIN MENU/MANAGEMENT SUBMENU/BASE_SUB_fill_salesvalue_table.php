<?php
function fill_salesvalue_table($data)
{
    include '../../../PHP LIBS/PHP FUNCTIONS/php_constants.php';
    $totalstyle = "border-top:1px solid black; border-bottom: 4px double black;";

    // ARRAYS TO HOLD VALUES FOR CATEGORY TOTALS
    $totals_next_four_months = array(0,0,0,0,0,0,0,0,0);
    $totals_rest_of_this_year = array(0,0,0,0,0,0,0,0,0);
    $totals_next_twelve_months = array(0,0,0,0,0,0,0,0,0);
    $totals_this_year = array(0,0,0,0,0,0,0,0,0);

    $year = date('Y');

    // FOR EVERY ENTRY IN QUERY
    foreach($data as $row)
    {
        // IF THE YEAR OF ROW IS THIS YEAR AND GREATER THAN OR EQUAL TO THIS MONTH (ADD TO REST OF THIS YEAR TOTAL)
        if($row["Year"] == date('Y') && $row["Month"] >= date('m'))
        {
            $totals_rest_of_this_year[CLOSED]+=$row["Closed"];
            $totals_rest_of_this_year[PRE_PRODUCTION_FORECAST]+=$row["Pre Production Forecast"];
            $totals_rest_of_this_year[PRE_PRODUCTION_POTENTIAL]+=$row["Pre Production Potential"];
            $totals_rest_of_this_year[PRE_PRODUCTION_CONFIRMED]+=$row["Pre Production Confirmed"];
            $totals_rest_of_this_year[LIVE]+=$row["Live"];
            $totals_rest_of_this_year[TOTAL]+=($row["Closed"]+$row["Pre Production Forecast"]+$row["Pre Production Potential"]+$row["Pre Production Confirmed"]+$row["Live"]);
            $totals_rest_of_this_year[IN_STOCK]+=$row["Complete In Stock"];
            $totals_rest_of_this_year[DELIVERED]+=$row["Delivered"];
            $totals_rest_of_this_year[INVOICED]+=$row["Invoiced"];
        }
        // IF YEAR OF LINE IS THIS YEAR (ADD TO THIS YEAR TOTAL)
        if($row["Year"] == $year)
        {
            $totals_this_year[CLOSED]+=$row["Closed"];
            $totals_this_year[PRE_PRODUCTION_FORECAST]+=$row["Pre Production Forecast"];
            $totals_this_year[PRE_PRODUCTION_POTENTIAL]+=$row["Pre Production Potential"];
            $totals_this_year[PRE_PRODUCTION_CONFIRMED]+=$row["Pre Production Confirmed"];
            $totals_this_year[LIVE]+=$row["Live"];
            $totals_this_year[TOTAL]+=($row["Closed"]+$row["Pre Production Forecast"]+$row["Pre Production Potential"]+$row["Pre Production Confirmed"]+$row["Live"]);
            $totals_this_year[IN_STOCK]+=$row["Complete In Stock"];
            $totals_this_year[DELIVERED]+=$row["Delivered"];
            $totals_this_year[INVOICED]+=$row["Invoiced"];

        }
        // IF LINE IS WITHIN TWELVE MONTHS OF THIS MONTH (ADD TO NEXT FOUR MONTHS TOTAL)
        if(($row["Month"] - date('m') + (($row["Year"]-date('Y'))*12)) <= 3 && ($row["Month"] - date('m') + (($row["Year"]-date('Y'))*12)) >= 0)
        {
            $totals_next_four_months[CLOSED]+=$row["Closed"];
            $totals_next_four_months[PRE_PRODUCTION_FORECAST]+=$row["Pre Production Forecast"];
            $totals_next_four_months[PRE_PRODUCTION_POTENTIAL]+=$row["Pre Production Potential"];
            $totals_next_four_months[PRE_PRODUCTION_CONFIRMED]+=$row["Pre Production Confirmed"];
            $totals_next_four_months[LIVE]+=$row["Live"];
            $totals_next_four_months[TOTAL]+=($row["Closed"]+$row["Pre Production Forecast"]+$row["Pre Production Potential"]+$row["Pre Production Confirmed"]+$row["Live"]);
            $totals_next_four_months[IN_STOCK]+=$row["Complete In Stock"];
            $totals_next_four_months[DELIVERED]+=$row["Delivered"];
            $totals_next_four_months[INVOICED]+=$row["Invoiced"];
        }
        // IF LINE IS WITHIN NEXT TWELVE MONTHS (ADD TO NEXT TWELVE MONTHS TOTAL)
        if(($row["Month"] - date('m') + (($row["Year"]-date('Y'))*12)) <= 12 && ($row["Month"] - date('m') + (($row["Year"]-date('Y'))*12)) >= 0)
        {
            $totals_next_twelve_months[CLOSED]+=$row["Closed"];
            $totals_next_twelve_months[PRE_PRODUCTION_FORECAST]+=$row["Pre Production Forecast"];
            $totals_next_twelve_months[PRE_PRODUCTION_POTENTIAL]+=$row["Pre Production Potential"];
            $totals_next_twelve_months[PRE_PRODUCTION_CONFIRMED]+=$row["Pre Production Confirmed"];
            $totals_next_twelve_months[LIVE]+=$row["Live"];
            $totals_next_twelve_months[TOTAL]+=($row["Closed"]+$row["Pre Production Forecast"]+$row["Pre Production Potential"]+$row["Pre Production Confirmed"]+$row["Live"]);
            $totals_next_twelve_months[IN_STOCK]+=$row["Complete In Stock"];
            $totals_next_twelve_months[DELIVERED]+=$row["Delivered"];
            $totals_next_twelve_months[INVOICED]+=$row["Invoiced"];
        }

        // PRINT VALUES FOR EACH INDIVIDUAL ROW
        // EACH TD WILL HAVE A ONCLICK EVENT TO DRILLDOWN TABLE WITH THREE PIECES OF INFORMATION
        //
        // STATUS NUMBER
        // CLOSED = 0, PRE PRODUCTION FORECAST = 1, PRE PRODUCTION POTENTIAL = 2, PRE PRODUCTION CONFIRMED = 3, LIVE OR PAUSED = 4, TOTAL (ALL PRE PREV STATUSES) = 5, COMPLETE IN STOCK = 6, DELIVERED = 7, INVOICED = 8
        //
        // MONTH
        // STANDARD 10, 11, 12, 1, 2 ETC
        // TOTALROW NEXT FOUR MONTHS == 1111, REST OF YEAR TOTALS = 2222, THIS YEAR TOTALS = 3333, NEXT TWELVE MONTHS TOTALS = 4444
        //
        // YEAR
        // 2020, 2021, 2022 ETC

        $this_month_border = ($row["Month"] == date('m') && $row["Year"] == date('Y')) ? " style = 'border-top:2px solid red;border-bottom:2px solid red;'" : "";
        $this_month_border_2 = ($row["Month"] == date('m') && $row["Year"] == date('Y')) ? "class = 'this_m'" : "";
        echo 
        "<tr $this_month_border_2 id = 'finance_table_content'>
            <td $this_month_border>".$row["Year"]."</td>
            <td $this_month_border>".$row["Month"]."</td>
            <td class = 'td_selector' $this_month_border onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=0,".$row["Month"].",".$row["Year"]."'".'"'."> € ".number_format(round($row["Closed"]/1000))."</td>
            <td class = 'td_selector' $this_month_border onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=1,".$row["Month"].",".$row["Year"]."'".'"'."> € ".number_format(round($row["Pre Production Forecast"]/1000))."</td>
            <td class = 'td_selector' $this_month_border onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=2,".$row["Month"].",".$row["Year"]."'".'"'."> € ".number_format(round($row["Pre Production Potential"]/1000))."</td>
            <td class = 'td_selector' $this_month_border onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=3,".$row["Month"].",".$row["Year"]."'".'"'."> € ".number_format(round($row["Pre Production Confirmed"]/1000))."</td>
            <td class = 'td_selector' $this_month_border onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=4,".$row["Month"].",".$row["Year"]."'".'"'."> € ".number_format(round($row["Live"]/1000))."</td>
            <td class = 'td_selector' $this_month_border onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=5,".$row["Month"].",".$row["Year"]."'".'"'."> € ".number_format(round(($row["Closed"]+$row["Pre Production Forecast"]+$row["Pre Production Potential"]+$row["Pre Production Confirmed"]+$row["Live"])/1000))."</td>
            <td style = 'background-color:#404040'></td>
            <td class = 'td_selector' $this_month_border onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=6,".$row["Month"].",".$row["Year"]."'".'"'."> € ".number_format(round($row["Complete In Stock"]/1000))."</td>
            <td class = 'td_selector' $this_month_border onclick=".'"'."location.href='../../TABLES/FINANCE/BY DELIVERED/BASE_list_by_delivered.php?ID=7,".$row["Month"].",".$row["Year"]."'".'"'."> € ".number_format(round($row["Delivered"]/1000))."</td>
            <td class = 'td_selector' $this_month_border > € ".number_format(round($row["Invoiced"]/1000))."</td>
        </tr>";

        // IF CURRENT ROW IS FOUR MONTHS AFTER THIS MONTH PRINT A ROW WITH THE NEXT FOUR MONTH TOTALS
        if(($row["Month"] - date('m') + (($row["Year"]-date('Y'))*12)) == 3)
        {
            echo 
                "<tr>
                    <td id = 'totaltopline'  style = '$totalstyle' colspan = 2>Next Four Months</td>
                    <td id = 'totaltopline'  style = '$totalstyle' class = 'td_selector' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=0,1111,".date('Y')."'".'"'."> € ".number_format(round($totals_next_four_months[CLOSED]/1000000,2),2)." M</td>
                    <td id = 'totaltopline'  style = '$totalstyle' class = 'td_selector' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=1,1111,".date('Y')."'".'"'."> € ".number_format(round($totals_next_four_months[PRE_PRODUCTION_FORECAST]/1000000,2),2)." M</td>
                    <td id = 'totaltopline'  style = '$totalstyle' class = 'td_selector' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=2,1111,".date('Y')."'".'"'."> € ".number_format(round($totals_next_four_months[PRE_PRODUCTION_POTENTIAL]/1000000,2),2)." M</td>
                    <td id = 'totaltopline'  style = '$totalstyle' class = 'td_selector' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=3,1111,".date('Y')."'".'"'."> € ".number_format(round($totals_next_four_months[PRE_PRODUCTION_CONFIRMED]/1000000,2),2)." M</td>
                    <td id = 'totaltopline'  style = '$totalstyle' class = 'td_selector' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=4,1111,".date('Y')."'".'"'."> € ".number_format(round($totals_next_four_months[LIVE]/1000000,2),2)." M</td>
                    <td id = 'totaltopline'  style = '$totalstyle' class = 'td_selector' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=5,1111,".date('Y')."'".'"'."> € ".number_format(round($totals_next_four_months[TOTAL]/1000000,2),2)." M</td>
                    <td style = 'background-color:#404040'></td>
                    <td id = 'totaltopline'  style = '$totalstyle' class = 'td_selector' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=6,1111,".date('Y')."'".'"'."> € ".number_format(round($totals_next_four_months[IN_STOCK]/1000000,2),2)." M</td>
                    <td id = 'totaltopline'  style = '$totalstyle' class = 'td_selector' onclick=".'"'."location.href='../../TABLES/FINANCE/BY DELIVERED/BASE_list_by_delivered.php?ID=7,1111,".date('Y')."'".'"'."> € ".number_format(round($totals_next_four_months[DELIVERED]/1000000,2),2)." M</td>
                    <td id = 'totaltopline'  style = '$totalstyle' class = 'td_selector' > € ".number_format(round($totals_next_four_months[INVOICED]/1000000,2),2)." M</td>
                </tr>";
        }
        // IF THE CURRENT ROW IS TWELVE MONTHS AFTER THIS MONTH PRINT ALL OTHER TOTAL ROWS
        if(($row["Month"] - date('m') + (($row["Year"]-date('Y'))*12)) == 12)
        {
            echo 
            "<tr>
                <td colspan = 2 style = '$totalstyle'>Remainer of ".date('Y')."</td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=0,2222,".date('Y')."'".'"'."> € ".number_format(round($totals_rest_of_this_year[CLOSED]/1000000,2),2)." M</td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=1,2222,".date('Y')."'".'"'."> € ".number_format(round($totals_rest_of_this_year[PRE_PRODUCTION_FORECAST]/1000000,2),2)." M</td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=2,2222,".date('Y')."'".'"'."> € ".number_format(round($totals_rest_of_this_year[PRE_PRODUCTION_POTENTIAL]/1000000,2),2)." M</td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=3,2222,".date('Y')."'".'"'."> € ".number_format(round($totals_rest_of_this_year[PRE_PRODUCTION_CONFIRMED]/1000000,2),2)." M</td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=4,2222,".date('Y')."'".'"'."> € ".number_format(round($totals_rest_of_this_year[LIVE]/1000000,2),2)." M</td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=5,2222,".date('Y')."'".'"'."> € ".number_format(round($totals_rest_of_this_year[TOTAL]/1000000,2),2)." M</td>
                <td style = 'background-color:#404040'></td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=6,2222,".date('Y')."'".'"'."> € ".number_format(round($totals_rest_of_this_year[IN_STOCK]/1000000,2),2)." M</td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY DELIVERED/BASE_list_by_delivered.php?ID=7,2222,".date('Y')."'".'"'."> € ".number_format(round($totals_rest_of_this_year[DELIVERED]/1000000,2),2)." M</td>
                <td class = 'td_selector' style = '$totalstyle' > € ".number_format(round($totals_rest_of_this_year[INVOICED]/1000000,2),2)." M</td>
            </tr>";
            echo
            "<tr id = 'finance_table_content'>
                <td colspan = '2' style = '$totalstyle'>This Year Total</td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=0,3333,".($row["Year"]-1)."'".'"'."> € ".number_format(round($totals_this_year[CLOSED]/1000))." K</td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=1,3333,".($row["Year"]-1)."'".'"'."> € ".number_format(round($totals_this_year[PRE_PRODUCTION_FORECAST]/1000))." K</td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=2,3333,".($row["Year"]-1)."'".'"'."> € ".number_format(round($totals_this_year[PRE_PRODUCTION_POTENTIAL]/1000))." K</td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=3,3333,".($row["Year"]-1)."'".'"'."> € ".number_format(round($totals_this_year[PRE_PRODUCTION_CONFIRMED]/1000))." K</td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=4,3333,".($row["Year"]-1)."'".'"'."> € ".number_format(round($totals_this_year[LIVE]/1000))." K</td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=5,3333,".($row["Year"]-1)."'".'"'."> € ".number_format(round(($totals_this_year[CLOSED]+$totals_this_year[PRE_PRODUCTION_FORECAST]+$totals_this_year[PRE_PRODUCTION_POTENTIAL]+$totals_this_year[PRE_PRODUCTION_CONFIRMED]+$totals_this_year[LIVE])/1000))." K</td>
                <td style = 'background-color:#404040'></td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=6,3333,".($row["Year"])."'".'"'."> € ".number_format(round($totals_this_year[IN_STOCK]/1000))." K</td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY DELIVERED/BASE_list_by_delivered.php?ID=7,3333,".($row["Year"])."'".'"'."> € ".number_format(round($totals_this_year[DELIVERED]/1000))." K</td>
                <td class = 'td_selector' style = '$totalstyle' > € ".number_format(round($totals_this_year[INVOICED]/1000))." K</td>
            </tr>";     
            echo
            "<tr>
                <td colspan=2 style = '$totalstyle'>Next 12 Months</td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=0,4444,".(date('Y')+1)."'".'"'."> € ".number_format(round($totals_next_twelve_months[CLOSED]/1000000,2),2)." M</td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=1,4444,".(date('Y')+1)."'".'"'."> € ".number_format(round($totals_next_twelve_months[PRE_PRODUCTION_FORECAST]/1000000,2),2)." M</td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=2,4444,".(date('Y')+1)."'".'"'."> € ".number_format(round($totals_next_twelve_months[PRE_PRODUCTION_POTENTIAL]/1000000,2),2)." M</td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=3,4444,".(date('Y')+1)."'".'"'."> € ".number_format(round($totals_next_twelve_months[PRE_PRODUCTION_CONFIRMED]/1000000,2),2)." M</td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=4,4444,".(date('Y')+1)."'".'"'."> € ".number_format(round($totals_next_twelve_months[LIVE]/1000000,2),2)." M</td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=5,4444,".(date('Y')+1)."'".'"'."> € ".number_format(round($totals_next_twelve_months[TOTAL]/1000000,2),2)." M</td>
                <td style = 'background-color:#404040; $totalstyle'></td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY STATUS/BASE_list_by_status.php?ID=6,4444,".(date('Y')+1)."'".'"'."> € ".number_format(round($totals_next_twelve_months[IN_STOCK]/1000000,2),2)." M</td>
                <td class = 'td_selector' style = '$totalstyle' onclick=".'"'."location.href='../../TABLES/FINANCE/BY DELIVERED/BASE_list_by_delivered.php?ID=6,4444,".(date('Y')+1)."'".'"'."> € ".number_format(round($totals_next_twelve_months[DELIVERED]/1000000,2),2)." M</td>
                <td class = 'td_selector' style = '$totalstyle' > € ".number_format(round($totals_next_twelve_months[INVOICED]/1000000,2),2)." M</td>
            </tr>";
        }
    }
}
?>