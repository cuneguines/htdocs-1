<?php
// ... Your SQL query and database connection code ...
$sql_2023_cc = "SELECT  *,CASE WHEN ISNULL(t0.nc_description, '') = '' THEN t0.cc_desc ELSE t0.nc_description END as description, case when t0.nc_area_caused='' then 'No Area' when t0.nc_area_caused is NULL then 'No Area' else t0.nc_area_caused end [nc_area_caused], case when t0.area_raised_by = '' then 'NO Area' when t0.area_raised_by is NULL then 'NO Area' else t0.area_raised_by end [area_raised_], FORMAT(t20.date_updated, 'dd-MM-yyyy')[date_updated], ISNULL(t77.person, 'No Owner')[person], FORMAT(t0.time_stamp, 'dd-MM-yyyy')[time_stamp], t0.Id as ID, (case when t20.Status is NULL then 'Other' when t20.Status='Open' then 'Open' when t20.Status='Closed' then 'Closed' end) [Status], t20.Action, ISNULL(t20.Owner, 'No Owner')[Owner], FORMAT(t20.Date, 'dd-MM-yyyy')[TargetDate], t50.CardName[Customer], t50.U_Client, t11.Dscription, t11.ItemCode, ISNULL(t12.U_Product_Group_One, 'NO PRODUCT GROUP')[U_Product_Group_One], t12.U_Product_Group_Two, t12.U_Product_Group_Three, (case when DateDiff(day, GETDATE(), t20.Date) > 0 and DateDiff(day, GETDATE(), t20.Date) <= 14 and t20.Status='Open' and t20.Date!='01/01/1900 00:00:00' then 'Due_next_two_weeks' when DATEDIFF(DAY, GETDATE(), t20.Date) >= -14 and DATEDIFF(DAY, GETDATE(), t20.Date) < 0 and t20.Status='Closed' and t20.Date!='01/01/1900 00:00:00' then 'Closed_last_two_weeks' end) [new_stat], (case WHEN t20.Date!='01/01/1900 00:00:00' and t20.Date is not null then DateDiff(day, GETDATE(), t20.Date) end)[Days_open], (case WHEN t44.attachments is null then 'N' else t44.attachments END) [attachements_issues] FROM ms_qual_log t0 LEFT JOIN (SELECT t1.ID, MAX(t1.date_updated) as Maxdate FROM dbo.Table_2 t1 WHERE t1.Status='Cancelled' GROUP BY t1.ID) t2 ON t2.ID = t0.ID LEFT JOIN (SELECT t8.Status, t8.Date, t8.ID, t8.Owner, t8.Action, t8.date_updated FROM dbo.Table_2 t8 INNER JOIN (SELECT t1.ID, MAX(t1.date_updated) as Mmaxdate FROM dbo.Table_2 t1 WHERE t1.Status<>'Cancelled' GROUP BY t1.ID) t6 ON t6.Mmaxdate = t8.date_updated AND t6.ID=t8.ID) t20 ON t20.ID=t0.ID AND t20.Status<>'Cancelled' LEFT JOIN (SELECT t0.* FROM KENTSTAINLESS.dbo.ordr t0) t50 ON t50.DocNum=nc_sales_order LEFT JOIN KENTSTAINLESS.dbo.rdr1 t11 ON t11.DocEntry = t50.DocEntry AND t11.U_IIS_proPrOrder = nc_process_order LEFT JOIN KENTSTAINLESS.dbo.oitm t12 ON t12.ItemCode COLLATE SQL_Latin1_General_CP1_CI_AS = COALESCE(nc_itemcode, cc_itemcode) COLLATE SQL_Latin1_General_CP1_CI_AS LEFT JOIN KENTSTAINLESS.dbo.oitb t13 ON t13.ItmsGrpCod = t12.ItmsGrpCod LEFT JOIN (SELECT t55.sap_id, t55.created_date, t55.attachments FROM dbo.attachment_table t55 INNER JOIN (SELECT t1.sap_id, MAX(t1.created_date) as Mmaxdate FROM dbo.attachment_table t1 GROUP BY t1.sap_id) t66 ON t66.Mmaxdate = t55.created_date AND t66.sap_id = t55.sap_id) t44 ON t44.sap_id = t0.ID AND t44.attachments is not NULL LEFT JOIN (SELECT (t0.firstName + ' ' + t0.lastName)[person], t0.email FROM KENTSTAINLESS.dbo.ohem t0 WHERE t0.Active = 'Y' AND t0.email is not NULL) t77 ON t77.email COLLATE SQL_Latin1_General_CP1_CI_AS = t20.Owner COLLATE SQL_Latin1_General_CP1_CI_AS WHERE t0.form_type in ('Non Conformance', 'Customer complaints', 'Opportunity For Improvement') AND t2.ID IS NULL  and nc_description is not null and YEAR(t20.date_updated) = '2023' ORDER BY CAST(t0.ID AS int)";
$sql_2023_op= "SELECT  *,CASE WHEN ISNULL(t0.nc_description, '') = '' THEN t0.cc_desc ELSE t0.nc_description END as description, case when t0.nc_area_caused='' then 'No Area' when t0.nc_area_caused is NULL then 'No Area' else t0.nc_area_caused end [nc_area_caused], case when t0.area_raised_by = '' then 'NO Area' when t0.area_raised_by is NULL then 'NO Area' else t0.area_raised_by end [area_raised_], FORMAT(t20.date_updated, 'dd-MM-yyyy')[date_updated], ISNULL(t77.person, 'No Owner')[person], FORMAT(t0.time_stamp, 'dd-MM-yyyy')[time_stamp], t0.Id as ID, (case when t20.Status is NULL then 'Other' when t20.Status='Open' then 'Open' when t20.Status='Closed' then 'Closed' end) [Status], t20.Action, ISNULL(t20.Owner, 'No Owner')[Owner], FORMAT(t20.Date, 'dd-MM-yyyy')[TargetDate], t50.CardName[Customer], t50.U_Client, t11.Dscription, t11.ItemCode, ISNULL(t12.U_Product_Group_One, 'NO PRODUCT GROUP')[U_Product_Group_One], t12.U_Product_Group_Two, t12.U_Product_Group_Three, (case when DateDiff(day, GETDATE(), t20.Date) > 0 and DateDiff(day, GETDATE(), t20.Date) <= 14 and t20.Status='Open' and t20.Date!='01/01/1900 00:00:00' then 'Due_next_two_weeks' when DATEDIFF(DAY, GETDATE(), t20.Date) >= -14 and DATEDIFF(DAY, GETDATE(), t20.Date) < 0 and t20.Status='Closed' and t20.Date!='01/01/1900 00:00:00' then 'Closed_last_two_weeks' end) [new_stat], (case WHEN t20.Date!='01/01/1900 00:00:00' and t20.Date is not null then DateDiff(day, GETDATE(), t20.Date) end)[Days_open], (case WHEN t44.attachments is null then 'N' else t44.attachments END) [attachements_issues] FROM ms_qual_log t0 LEFT JOIN (SELECT t1.ID, MAX(t1.date_updated) as Maxdate FROM dbo.Table_2 t1 WHERE t1.Status='Cancelled' GROUP BY t1.ID) t2 ON t2.ID = t0.ID LEFT JOIN (SELECT t8.Status, t8.Date, t8.ID, t8.Owner, t8.Action, t8.date_updated FROM dbo.Table_2 t8 INNER JOIN (SELECT t1.ID, MAX(t1.date_updated) as Mmaxdate FROM dbo.Table_2 t1 WHERE t1.Status<>'Cancelled' GROUP BY t1.ID) t6 ON t6.Mmaxdate = t8.date_updated AND t6.ID=t8.ID) t20 ON t20.ID=t0.ID AND t20.Status<>'Cancelled' LEFT JOIN (SELECT t0.* FROM KENTSTAINLESS.dbo.ordr t0) t50 ON t50.DocNum=nc_sales_order LEFT JOIN KENTSTAINLESS.dbo.rdr1 t11 ON t11.DocEntry = t50.DocEntry AND t11.U_IIS_proPrOrder = nc_process_order LEFT JOIN KENTSTAINLESS.dbo.oitm t12 ON t12.ItemCode COLLATE SQL_Latin1_General_CP1_CI_AS = COALESCE(nc_itemcode, cc_itemcode) COLLATE SQL_Latin1_General_CP1_CI_AS LEFT JOIN KENTSTAINLESS.dbo.oitb t13 ON t13.ItmsGrpCod = t12.ItmsGrpCod LEFT JOIN (SELECT t55.sap_id, t55.created_date, t55.attachments FROM dbo.attachment_table t55 INNER JOIN (SELECT t1.sap_id, MAX(t1.created_date) as Mmaxdate FROM dbo.attachment_table t1 GROUP BY t1.sap_id) t66 ON t66.Mmaxdate = t55.created_date AND t66.sap_id = t55.sap_id) t44 ON t44.sap_id = t0.ID AND t44.attachments is not NULL LEFT JOIN (SELECT (t0.firstName + ' ' + t0.lastName)[person], t0.email FROM KENTSTAINLESS.dbo.ohem t0 WHERE t0.Active = 'Y' AND t0.email is not NULL) t77 ON t77.email COLLATE SQL_Latin1_General_CP1_CI_AS = t20.Owner COLLATE SQL_Latin1_General_CP1_CI_AS WHERE t0.form_type in ('Non Conformance', 'Customer complaints', 'Opportunity For Improvement') AND t2.ID IS NULL  and nc_description is not null and YEAR(t20.date_updated) = '2023' ORDER BY CAST(t0.ID AS int)";
try {
    // ... Your SQL query and database connection code ...
    $conn = new PDO("sqlsrv:Server=KPTSVSP;Database=LEARNING_LOG", "sa", "SAPB1Admin");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query($sql_2023_cc);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt_op = $conn->query($sql_2023_op);
    $results_op = $stmt_op->fetchAll(PDO::FETCH_ASSOC);

    // Initialize the arrays to store the counts for each month and area
    $openedIssuesPerMonthAndArea = array();

    // Get the current month and year
    $currentMonthYear = date("F Y");

    // Loop through the results and group opened issues by month and area based on "Date Updated" and "Status"
    foreach ($results_op as $entry) {
        $complaintStatus = $entry['Status'];
        $dateUpdated = $entry['date_updated'];
        $areaCaused = $entry['nc_area_caused'];

        // Check if the entry is an opened issue in the year 2023 and before or equal to the current month
        if ($complaintStatus === 'Open' && date('Y', strtotime($dateUpdated)) === '2023' && strtotime($dateUpdated) <= strtotime('last day of ' . $currentMonthYear)) {
            // Extract the month and year from the "Date Updated"
            $monthYear = date("F Y", strtotime($dateUpdated));

            // Increment the count for the corresponding month and area
            if (!isset($openedIssuesPerMonthAndArea[$areaCaused][$monthYear])) {
                $openedIssuesPerMonthAndArea[$areaCaused][$monthYear] = 1;
            } else {
                $openedIssuesPerMonthAndArea[$areaCaused][$monthYear]++;
            }
        }
    }

    // Get all months in the year 2023 up to the current month
    $months2023 = array();
    $startDate = strtotime('2023-01-01');
    $endDate = strtotime('last day of ' . $currentMonthYear);
    while ($startDate <= $endDate) {
        $months2023[] = date("F Y", $startDate);
        $startDate = strtotime("+1 month", $startDate);
    }

    // Fill the data arrays with 0 for months with no opened issues for each area
    foreach ($openedIssuesPerMonthAndArea as &$openedIssuesPerArea) {
        foreach ($months2023 as $month) {
            if (!isset($openedIssuesPerArea[$month])) {
                $openedIssuesPerArea[$month] = 0;
            }
        }
    }

    // Sort the data arrays based on month for each area
    foreach ($openedIssuesPerMonthAndArea as &$openedIssuesPerArea) {
        ksort($openedIssuesPerArea);
    }

    // Get the total counts for opened issues for each area
    $totalOpenedIssuesByArea = array();
    foreach ($openedIssuesPerMonthAndArea as $area => $openedIssuesPerArea) {
        $totalOpenedIssuesByArea[$area] = array_values($openedIssuesPerArea);
    }
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
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Convert the PHP data to JavaScript array
            var months2023 = <?php echo json_encode($months2023); ?>;
            var openedIssuesData = <?php echo json_encode($totalOpenedIssuesByArea); ?>;
            var areas = <?php echo json_encode(array_keys($totalOpenedIssuesByArea)); ?>;

            // Create the data table
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Month');
            for (var i = 0; i < areas.length; i++) {
                data.addColumn('number', areas[i]);
            }

            for (var i = 0; i < months2023.length; i++) {
                var rowData = [months2023[i]];
                for (var j = 0; j < areas.length; j++) {
                    rowData.push(openedIssuesData[areas[j]][i]);
                }
                data.addRow(rowData);
            }

            // Chart options
            var options = {
                title: 'Number of Opened Issues per Month in 2023',
                hAxis: {title: 'Month'},
                vAxis: {title: 'Number of Opened Issues'},
                colors: ['#33FF57', '#FF5733', '#3399FF', '#FF33CC'], // Add more colors if needed
                legend: {position: 'top'},
                chartArea: {left: '10%', top: '10%', width: '80%', height: '70%'},
                isStacked: true,
                annotations: {
                    textStyle: {
                        fontSize: 10,
                        bold: true,
                        color: '#ffffff',
                    },
                },
            };

            // Create the chart
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
    <style>
        body {
            top: 0;
            height: 100vh;
            background-color: black;
            overflow: hidden;
            padding: 1%;
        }
    </style>
</head>

<body>
<div style="height: 90%; width: 100%; position: relative; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3)">
    <div style="padding: 1%; background-color: beige; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3)">
        <h2 style="text-align: center">Number of Opened Issues per Month in 2023</h2>
        <div id="chart_div" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); position: relative; width: 100%; height: 80%"></div>
    </div>
</div>
</body>
</html>
