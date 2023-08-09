<?php
// ... Your SQL query and database connection code ...for the year 2023 from the time stamp okay there is bo opne close to capture so status is 'Other'
$sql_2023_cc = "SELECT  *,CASE WHEN ISNULL(t0.nc_description, '') = '' THEN t0.cc_desc ELSE t0.nc_description END as description, case when t0.nc_area_caused='' then 'No Area' when t0.nc_area_caused is NULL then 'No Area' else t0.nc_area_caused end [nc_area_caused], case when t0.area_raised_by = '' then 'NO Area' when t0.area_raised_by is NULL then 'NO Area' else t0.area_raised_by end [area_raised_], FORMAT(t20.date_updated, 'dd-MM-yyyy')[date_updated], ISNULL(t77.person, 'No Owner')[person], FORMAT(t0.time_stamp, 'dd-MM-yyyy')[time_stamp], t0.Id as ID, (case when t20.Status is NULL then 'Other' when t20.Status='Open' then 'Open' when t20.Status='Closed' then 'Closed' end) [Status], t20.Action, ISNULL(t20.Owner, 'No Owner')[Owner], FORMAT(t20.Date, 'dd-MM-yyyy')[TargetDate], t50.CardName[Customer], t50.U_Client, t11.Dscription, t11.ItemCode, ISNULL(t12.U_Product_Group_One, 'NO PRODUCT GROUP')[U_Product_Group_One], t12.U_Product_Group_Two, t12.U_Product_Group_Three, (case when DateDiff(day, GETDATE(), t20.Date) > 0 and DateDiff(day, GETDATE(), t20.Date) <= 14 and t20.Status='Open' and t20.Date!='01/01/1900 00:00:00' then 'Due_next_two_weeks' when DATEDIFF(DAY, GETDATE(), t20.Date) >= -14 and DATEDIFF(DAY, GETDATE(), t20.Date) < 0 and t20.Status='Closed' and t20.Date!='01/01/1900 00:00:00' then 'Closed_last_two_weeks' end) [new_stat], (case WHEN t20.Date!='01/01/1900 00:00:00' and t20.Date is not null then DateDiff(day, GETDATE(), t20.Date) end)[Days_open], (case WHEN t44.attachments is null then 'N' else t44.attachments END) [attachements_issues] FROM ms_qual_log t0 LEFT JOIN (SELECT t1.ID, MAX(t1.date_updated) as Maxdate FROM dbo.Table_2 t1 WHERE t1.Status='Cancelled' GROUP BY t1.ID) t2 ON t2.ID = t0.ID LEFT JOIN (SELECT t8.Status, t8.Date, t8.ID, t8.Owner, t8.Action, t8.date_updated FROM dbo.Table_2 t8 INNER JOIN (SELECT t1.ID, MAX(t1.date_updated) as Mmaxdate FROM dbo.Table_2 t1 WHERE t1.Status<>'Cancelled' GROUP BY t1.ID) t6 ON t6.Mmaxdate = t8.date_updated AND t6.ID=t8.ID) t20 ON t20.ID=t0.ID AND t20.Status<>'Cancelled' LEFT JOIN (SELECT t0.* FROM KENTSTAINLESS.dbo.ordr t0) t50 ON t50.DocNum=nc_sales_order LEFT JOIN KENTSTAINLESS.dbo.rdr1 t11 ON t11.DocEntry = t50.DocEntry AND t11.U_IIS_proPrOrder = nc_process_order LEFT JOIN KENTSTAINLESS.dbo.oitm t12 ON t12.ItemCode COLLATE SQL_Latin1_General_CP1_CI_AS = COALESCE(NULLIF(nc_itemcode,''), cc_itemcode) COLLATE SQL_Latin1_General_CP1_CI_AS LEFT JOIN KENTSTAINLESS.dbo.oitb t13 ON t13.ItmsGrpCod = t12.ItmsGrpCod LEFT JOIN (SELECT t55.sap_id, t55.created_date, t55.attachments FROM dbo.attachment_table t55 INNER JOIN (SELECT t1.sap_id, MAX(t1.created_date) as Mmaxdate FROM dbo.attachment_table t1 GROUP BY t1.sap_id) t66 ON t66.Mmaxdate = t55.created_date AND t66.sap_id = t55.sap_id) t44 ON t44.sap_id = t0.ID AND t44.attachments is not NULL LEFT JOIN (SELECT (t0.firstName + ' ' + t0.lastName)[person], t0.email FROM KENTSTAINLESS.dbo.ohem t0 WHERE t0.Active = 'Y' AND t0.email is not NULL) t77 ON t77.email COLLATE SQL_Latin1_General_CP1_CI_AS = t20.Owner COLLATE SQL_Latin1_General_CP1_CI_AS WHERE t0.form_type in ('Customer Complaints') AND t2.ID IS NULL  and nc_description is not null and YEAR(t0.time_stamp) = '2023' ORDER BY CAST(t0.ID AS int)";

try {
    // ... Your SQL query and database connection code ...
    $conn = new PDO("sqlsrv:Server=KPTSVSP;Database=LEARNING_LOG", "sa", "SAPB1Admin");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query($sql_2023_cc);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

   
   
   
    $openedIssuesPerMonth = array();

    // Get the current month and year
    $currentMonthYear = date("F Y");

    // Loop through the results and populate the openedIssuesPerMonth array
    foreach ($results as $entry) {
        $formType = $entry['form_type'];
        $dateUpdated = $entry['time_stamp'];
        $areaCaused = $entry['cc_area_caused'];
        $status=$entry['Status'];
        // Check if the entry is a Customer complaint in the year 2023 and before or equal to the current month
        if (($formType === 'Customer Complaints') && $status==='Other' && date('Y', strtotime($dateUpdated)) === '2023' && strtotime($dateUpdated) <= strtotime('last day of ' . $currentMonthYear)) {
            // Extract the month and year from the "Date Updated"
            $monthYear = date("F Y", strtotime($dateUpdated));

            // Initialize the area caused count for the specific month if not exists
            if (!isset($openedIssuesPerMonth[$monthYear])) {
                $openedIssuesPerMonth[$monthYear] = array();
            }

            // Increment the count for the corresponding area caused
            if (!isset($openedIssuesPerMonth[$monthYear][$areaCaused])) {
                $openedIssuesPerMonth[$monthYear][$areaCaused] = 1;
            } else {
                $openedIssuesPerMonth[$monthYear][$areaCaused]++;
                
            }
        }
    }
//print_r( $openedIssuesPerMonth);
//die;
    // List of unique area caused values
    $areas = array_unique(array_reduce($results, function ($carry, $entry) {
        if ($entry['form_type'] === 'Customer Complaints') {
            $carry[] = $entry['cc_area_caused'];
            
        }
        return $carry;
    }, array()));

   /*  foreach ($results as $entry) {
        $formType = $entry['form_type'];
        $dateUpdated = $entry['date_updated'];
        $areaCaused = $entry['cc_area_caused'];
        $status=$entry['Status'];
        // Check if the entry is a Customer complaint in the year 2023 and before or equal to the current month
        if (($formType === 'Customer Complaints')&& $status==='Open' && date('Y', strtotime($dateUpdated)) === '2023' && strtotime($dateUpdated) <= strtotime('last day of ' . $currentMonthYear)) {
            // Extract the month and year from the "Date Updated"
            $monthYear = date("F Y", strtotime($dateUpdated));

            // Initialize the area caused count for the specific month if not exists
            if (!isset($closedIssuesPerMonth[$monthYear])) {
                $closedIssuesPerMonth[$monthYear] = array();
            }

            // Increment the count for the corresponding area caused
            if (!isset($closedIssuesPerMonth[$monthYear][$areaCaused])) {
                $closedIssuesPerMonth[$monthYear][$areaCaused] = 1;
            } else {
                $closedIssuesPerMonth[$monthYear][$areaCaused]++;
                
            }
        }
    }

    // List of unique area caused values
    $areas_new = array_unique(array_reduce($results_op, function ($carry_new, $entry) {
        if ($entry['form_type'] === 'Customer Complaints') {
            $carry_new[] = $entry['cc_area_caused'];
            
        }
        return $carry_new;
    }, array())); */
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}
?>

<!-- Your HTML and chart rendering code -->
<html>
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawCharts);
       
       

function drawCharts() {
    // ... your other code ...

    var dataArray = [];
    
    <?php
    // Prepare data for each month and area caused
    foreach ($openedIssuesPerMonth as $month => $data) {
        $values = array($month);
        foreach ($areas as $area) {
            $value = isset($data[$area]) ? $data[$area] : 0;
            $values[] = (int)$value;
        }
        echo "dataArray.push(" . json_encode($values) . ");\n";
    }
    ?>

    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Month');
    <?php
    foreach ($areas as $area) {
        echo "data.addColumn('number', '$area');\n";
    }
    ?>

    data.addRows(dataArray);

    var options = {
        title: 'Number of Issues by Area Caused and Month for the year 2023',
        isStacked: true,
        vAxis: { title: 'Month' },
        hAxis: { title: 'Number of Issues' },
        legend: {  position: 'top',
        maxLines: 2, // Set the maximum number of lines for each legend item
        textStyle: {
            fontSize: 10, // Set the font size of the legend labels
        }, },
        bar: { groupWidth: '75%' },
    };

    var chart = new google.visualization.BarChart(document.getElementById('chart_div_one'));
    chart.draw(data, options);
}
</script>

<!-- <script type="text/javascript">
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawCharts_new);
       
    function drawCharts_new() {
    // ... your other code ...

    var dataArray = [];
    
    <?php
    // Prepare data for each month and area caused
    foreach ($closedIssuesPerMonth as $month => $data) {
        $values = array($month);
        foreach ($areas as $area) {
            $value = isset($data[$area]) ? $data[$area] : 0;
            $values[] = (int)$value;
        }
        echo "dataArray.push(" . json_encode($values) . ");\n";
    }
    ?>

    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Month');
    <?php
    foreach ($areas_new as $area) {
        echo "data.addColumn('number', '$area');\n";
    }
    ?>

    data.addRows(dataArray);

    var options = {
        title: 'Number of Issues/Open by Area Caused and Month',
        isStacked: true,
        vAxis: { title: 'Month' },
        hAxis: { title: 'Number of Issues' },
        legend: {  position: 'top',
        maxLines: 2, // Set the maximum number of lines for each legend item
        textStyle: {
            fontSize: 10, // Set the font size of the legend labels
        }, },
        bar: { groupWidth: '75%' },
    };

    var chart = new google.visualization.BarChart(document.getElementById('chart_div_two'));
    chart.draw(data, options);
}
 -->



</script>
    <style>
    body {
        top: 0;
        height: 100vh;
       
        overflow-y: hidden;
        overflow-x: hidden;
        background-color:#0866c6;
    }
    </style>
</head>

<body>
    <div style="position:relative;width:100%;">
    <h2 style="background-color:white;text-align:center;box-shadow: 0px -2px 8px 6px #9E9E9E;">Count of Customer Complaints every month for the year 2023</h2>
<div id="chart_div_one" style="background-color:white;    box-shadow: 0px -2px 8px 6px #9E9E9E;
            border-radius: 8px;grey;position:relative;width: 98%; height: 35%;padding:1%"></div>
<!-- <div id="chart_div_two" style="background-color:black;    box-shadow: 0px -2px 8px 6px #9E9E9E;
            border-radius: 8px;grey;position:relative;width: 100%; height: 35%;padding:1%"></div> -->
</div>
</body>
</html>