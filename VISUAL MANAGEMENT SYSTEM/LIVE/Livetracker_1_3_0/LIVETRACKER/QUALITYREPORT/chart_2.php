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
        // Initialize the arrays to store the counts for each month
        $openedIssuesPerMonth = array();
        $closedIssuesPerMonth = array();
    
        // Get the current month and year
        $currentMonthYear = date("F Y");
    
        // Loop through the results and group issues by month based on "Date Updated" For Non Conformance and Opportunity For Improvement
        foreach ($results as $entry) {
            $formType = $entry['form_type'];
            $complaintStatus = $entry['Status'];
            $dateUpdated = $entry['date_updated'];
    
            // Check if the entry is a customer complaint and if it's in the year 2023 and before or equal to the current month
            if ($formType === 'Non Conformance'|| $formType === 'Opportunity For Improvement'&& date('Y', strtotime($dateUpdated)) === '2023' && strtotime($dateUpdated) <= strtotime('last day of ' . $currentMonthYear)) {
                // Extract the month and year from the "Date Updated"
                $monthYear = date("F Y", strtotime($dateUpdated));
    
                // Increment the count for the corresponding month and status
                if ($complaintStatus === 'Open') {
                    if (isset($openedIssuesPerMonth[$monthYear])) {
                        $openedIssuesPerMonth[$monthYear]++;
                    } else {
                        $openedIssuesPerMonth[$monthYear] = 1;
                    }
                } elseif ($complaintStatus === 'Closed') {
                    if (isset($closedIssuesPerMonth[$monthYear])) {
                        $closedIssuesPerMonth[$monthYear]++;
                    } else {
                        $closedIssuesPerMonth[$monthYear] = 1;
                    }
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
    
        // Fill the data arrays with 0 for months with no issues
        foreach ($months2023 as $month) {
            if (!isset($openedIssuesPerMonth[$month])) {
                $openedIssuesPerMonth[$month] = 0;
            }
            if (!isset($closedIssuesPerMonth[$month])) {
                $closedIssuesPerMonth[$month] = 0;
            }
        }
    
        // Sort the data arrays based on month
        ksort($openedIssuesPerMonth);
        ksort($closedIssuesPerMonth);
    
        // Get the total counts for opened and closed issues
        $totalOpenedIssues = array_values($openedIssuesPerMonth);
        $totalClosedIssues = array_values($closedIssuesPerMonth);

  // Loop through the results and group issues by month based on "Date Updated" For Customer complaints
  $openedIssuesPerMonth_op= array();
  $closedIssuesPerMonth_op = array();

  // Get the current month and year
  $currentMonthYear_op= date("F Y");
        foreach ($results_op as $entry) {
            $formType_op = $entry['form_type'];
            $complaintStatus_op = $entry['Status'];
            $dateUpdated_op = $entry['date_updated'];
   // print_r($entry);
            // Check if the entry is a customer complaint and if it's in the year 2023 and before or equal to the current month
            if ($formType_op === 'Customer Complaints' && date('Y', strtotime($dateUpdated_op)) === '2023' && strtotime($dateUpdated_op) <= strtotime('last day of ' . $currentMonthYear_op)) {
                // Extract the month and year from the "Date Updated"
                $monthYear_op = date("F Y", strtotime($dateUpdated));
    
                // Increment the count for the corresponding month and status
                if ($complaintStatus_op === 'Open') {
                    if (isset($openedIssuesPerMonth_op[$monthYear_op])) {
                        $openedIssuesPerMonth_op[$monthYear_op]++;
                    } else {
                        $openedIssuesPerMonth_op[$monthYear_op] = 1;
                    }
                } elseif ($complaintStatus_op === 'Closed') {
                    if (isset($closedIssuesPerMonth_op[$monthYear_op])) {
                        $closedIssuesPerMonth_op[$monthYear_op]++;
                    } else {
                        $closedIssuesPerMonth_op[$monthYear_op] = 1;
                    }
                }
            }
        }


        // Get all months in the year 2023 up to the current month
        $months2023_op = array();
        $startDate_op= strtotime('2023-01-01');
        $endDate_op= strtotime('last day of ' . $currentMonthYear);
        while ($startDate_op<= $endDate_op) {
            $months2023_op[] = date("F Y", $startDate_op);
            $startDate_op = strtotime("+1 month", $startDate_op);
        }
    
        // Fill the data arrays with 0 for months with no issues
        foreach ($months2023_op as $month) {
            if (!isset($openedIssuesPerMonth_op[$month])) {
                $openedIssuesPerMonth_op[$month] = 0;
            }
            if (!isset($closedIssuesPerMonth_op[$month])) {
                $closedIssuesPerMonth_op[$month] = 0;
            }
        }
    // Sort the data arrays based on month
    ksort($openedIssuesPerMonth_op);
    ksort($closedIssuesPerMonth_op);

    // Get the total counts for opened and closed issues
    $totalOpenedIssues_op = array_values($openedIssuesPerMonth_op);
    $totalClosedIssues_op = array_values($closedIssuesPerMonth_op);
    
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
            // Convert the PHP data to JavaScript array
            var months2023 = <?php echo json_encode($months2023); ?>;
            var openedIssuesData = <?php echo json_encode($totalOpenedIssues); ?>;
            var closedIssuesData = <?php echo json_encode($totalClosedIssues); ?>;

            // Create the data table for opened issues
            var openedData = new google.visualization.DataTable();
            openedData.addColumn('string', 'Month');
            openedData.addColumn('number', 'Opened Issues');

            // Add data rows to the table
            for (var i = 0; i < months2023.length; i++) {
                openedData.addRow([months2023[i], openedIssuesData[i]]);
            }

            // Set chart options for opened issues
            var openedOptions = {
                title: 'Opportunity For improvement - Opened Issues per Month in 2023',
                hAxis: {title: 'Month'},
                vAxis: {title: 'Number of Opened Issues'},
                legend: {position: 'none'},
                colors: ['#33FF57']
            };

            // Create and draw the opened issues chart
            var openedChart = new google.visualization.ColumnChart(document.getElementById('opened_chart_div'));
            openedChart.draw(openedData, openedOptions);

            // Create the data table for closed issues
            var closedData = new google.visualization.DataTable();
            closedData.addColumn('string', 'Month');
            closedData.addColumn('number', 'Closed Issues');

            // Add data rows to the table
            for (var i = 0; i < months2023.length; i++) {
                closedData.addRow([months2023[i], closedIssuesData[i]]);
            }

            // Set chart options for closed issues
            var closedOptions = {
                title: 'Opportunity For improvement - Closed Issues per Month in 2023',
                hAxis: {title: 'Month'},
                vAxis: {title: 'Number of Closed Issues'},
                legend: {position: 'none'},
                colors: ['#33FF57']
            };

            // Create and draw the closed issues chart
            var closedChart = new google.visualization.ColumnChart(document.getElementById('closed_chart_div'));
            closedChart.draw(closedData, closedOptions);
        }
        </script>
        <script type="text/javascript">
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawCharts_op);
        function drawCharts_op() {
            // Convert the PHP data to JavaScript array
            var months2023_op = <?php echo json_encode($months2023_op); ?>;
            var openedIssuesData_op = <?php echo json_encode($totalOpenedIssues_op); ?>;
            var closedIssuesData_op = <?php echo json_encode($totalClosedIssues_op); ?>;

            // Create the data table for opened issues
            var openedData_op = new google.visualization.DataTable();
            openedData_op.addColumn('string', 'Month');
            openedData_op.addColumn('number', 'Opened Issues');

            // Add data rows to the table
            for (var i = 0; i < months2023_op.length; i++) {
                openedData_op.addRow([months2023_op[i], openedIssuesData_op[i]]);
            }

            // Set chart options for opened issues
            var openedOptions_op = {
                title: 'Customer Complaints- Opened Issues per Month in 2023',
                hAxis: {title: 'Month'},
                vAxis: {title: 'Number of Opened Issues'},
                legend: {position: 'none'},
                colors: ['#FFD700']
               
            };

            // Create and draw the opened issues chart
            var openedChart_op = new google.visualization.ColumnChart(document.getElementById('opened_chart_op_div'));
            openedChart_op.draw(openedData_op, openedOptions_op);

            // Create the data table for closed issues
            var closedData_op= new google.visualization.DataTable();
            closedData_op.addColumn('string', 'Month');
            closedData_op.addColumn('number', 'Closed Issues');

            // Add data rows to the table
            for (var i = 0; i < months2023_op.length; i++) {
                closedData_op.addRow([months2023_op[i], closedIssuesData_op[i]]);
            }

            // Set chart options for closed issues
            var closedOptions_op = {
                title: 'Customer Complaints - Closed Issues per Month in 2023',
                hAxis: {title: 'Month'},
                vAxis: {title: 'Number of Closed Issues'},
                legend: {position: 'none'},
                colors: ['#FFD700']
            };

            // Create and draw the closed issues chart
            var closedChart_op = new google.visualization.ColumnChart(document.getElementById('closed_chart_op_div'));
            closedChart_op.draw(closedData_op, closedOptions_op);
        }
    </script>
    <style>
    body {
        top: 0;
        height: 100vh;
       background-color:black;
       overflow:hidden;
       padding:1%;
    }
    </style>
</head>

<body>
    <div style="height:90% ;width:100%;position:relative ;box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3)">
  
    <!-- Display the charts -->
    <div style="padding:1%;background-color:beige; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3)">
    <h2 style="text-align:center">Opportunities For Improvement 2023</h2>
    <div id="opened_chart_div" style=" box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);position:relative;width:49% ;height: 40%; display: inline-block;"></div>
    <div id="closed_chart_div" style=" box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);position:relative;width: 50%; height: 40%; display: inline-block;"></div>
    </div>
    <div style="padding:1%;background-color:lightgreen; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3)" >
    <h2 style="text-align:center">Customer Complaints 2023</h2>
    <div id="opened_chart_op_div" style=" box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);position:relative;width: 49%; height: 40%; display: inline-block;"></div>
    <div id="closed_chart_op_div" style=" box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);position:relative;width: 50%; height: 40%; display: inline-block;"></div>
    </div>
    </div>
    
</body>
</html>
