
<?php
$sql_2023_all_open = "SELECT Person[Name], MAX(Days_Open)[Least Urgent Action], MIN(Days_Open)[Most Urgent Action], COUNT(Days_OPEN)[No Of Actions]
FROM (SELECT CASE WHEN ISNULL(t0.nc_description, '') = '' THEN t0.cc_desc ELSE t0.nc_description END as description, case when t0.nc_area_caused='' then 'No Area' when t0.nc_area_caused is NULL then 'No Area' else t0.nc_area_caused end [nc_area_caused], case when t0.area_raised_by = '' then 'NO Area' when t0.area_raised_by is NULL then 'NO Area' else t0.area_raised_by end [area_raised_], FORMAT(t20.date_updated, 'dd-MM-yyyy')[date_updated], ISNULL(t77.person, 'No Owner')[person], FORMAT(t0.time_stamp, 'dd-MM-yyyy')[time_stamp], t0.Id as ID, (case when t20.Status is NULL then 'Other' when t20.Status='Open' then 'Open' when t20.Status='Closed' then 'Closed' end) [Status], t20.Action, ISNULL(t20.Owner, 'No Owner')[Owner], FORMAT(t20.Date, 'dd-MM-yyyy')[TargetDate], t50.CardName[Customer], t50.U_Client, t11.Dscription, t11.ItemCode, ISNULL(t12.U_Product_Group_One, 'NO PRODUCT GROUP')[U_Product_Group_One], t12.U_Product_Group_Two, t12.U_Product_Group_Three, (case when DateDiff(day, GETDATE(), t20.Date) > 0 and DateDiff(day, GETDATE(), t20.Date) <= 14 and t20.Status='Open' and t20.Date!='01/01/1900 00:00:00' then 'Due_next_two_weeks' when DATEDIFF(DAY, GETDATE(), t20.Date) >= -14 and DATEDIFF(DAY, GETDATE(), t20.Date) < 0 and t20.Status='Closed' and t20.Date!='01/01/1900 00:00:00' then 'Closed_last_two_weeks' end) [new_stat], (case WHEN t20.Date!='01/01/1900 00:00:00' and t20.Date is not null then DateDiff(day, GETDATE(), t20.Date) end)[Days_open], (case WHEN t44.attachments is null then 'N' else t44.attachments END) [attachements_issues] FROM ms_qual_log t0 LEFT JOIN (SELECT t1.ID, MAX(t1.date_updated) as Maxdate FROM dbo.Table_2 t1 WHERE t1.Status='Cancelled' GROUP BY t1.ID) t2 ON t2.ID = t0.ID LEFT JOIN (SELECT t8.Status, t8.Date, t8.ID, t8.Owner, t8.Action, t8.date_updated FROM dbo.Table_2 t8 INNER JOIN (SELECT t1.ID, MAX(t1.date_updated) as Mmaxdate FROM dbo.Table_2 t1 WHERE t1.Status<>'Cancelled' GROUP BY t1.ID) t6 ON t6.Mmaxdate = t8.date_updated AND t6.ID=t8.ID) t20 ON t20.ID=t0.ID AND t20.Status<>'Cancelled' LEFT JOIN (SELECT t0.* FROM KENTSTAINLESS.dbo.ordr t0) t50 ON t50.DocNum=nc_sales_order LEFT JOIN KENTSTAINLESS.dbo.rdr1 t11 ON t11.DocEntry = t50.DocEntry AND t11.U_IIS_proPrOrder = nc_process_order LEFT JOIN KENTSTAINLESS.dbo.oitm t12 ON t12.ItemCode COLLATE SQL_Latin1_General_CP1_CI_AS = COALESCE(nc_itemcode, cc_itemcode) COLLATE SQL_Latin1_General_CP1_CI_AS LEFT JOIN KENTSTAINLESS.dbo.oitb t13 ON t13.ItmsGrpCod = t12.ItmsGrpCod LEFT JOIN (SELECT t55.sap_id, t55.created_date, t55.attachments FROM dbo.attachment_table t55 INNER JOIN (SELECT t1.sap_id, MAX(t1.created_date) as Mmaxdate FROM dbo.attachment_table t1 GROUP BY t1.sap_id) t66 ON t66.Mmaxdate = t55.created_date AND t66.sap_id = t55.sap_id) t44 ON t44.sap_id = t0.ID AND t44.attachments is not NULL LEFT JOIN (SELECT (t0.firstName + ' ' + t0.lastName)[person], t0.email FROM KENTSTAINLESS.dbo.ohem t0 WHERE t0.Active = 'Y' AND t0.email is not NULL) t77 ON t77.email COLLATE SQL_Latin1_General_CP1_CI_AS = t20.Owner COLLATE SQL_Latin1_General_CP1_CI_AS WHERE t0.form_type in ('Non Conformance', 'Customer complaints', 'Opportunity For Improvement') AND t2.ID IS NULL  and nc_description is not null and Status='Open')t0
GROUP BY PERSON
ORDER BY COUNT(Days_Open) DESC";
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Include Google Charts library -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
    <style>
    <style>
    body {
        top: 0;
        height: 100vh;
        overflow-y: hidden;
        overflow-x: hidden;
        
        margin: 0;
    }

    #chart_div_area_raised,
    #chart_div_area_cause {
        background-color: white;
        box-shadow: 0px -1px 8px 6px #9E9E9E;
        border-radius: 8px;
        margin-top: .8%;
        width: 98%;
        height: 40vh;
        margin-left:1%; /* Adjust this value as needed */
    }

    #chart_div_area_raised {
        margin-bottom: 2%;
    }

    h2 {
        background-color: white;
        text-align: center;
        margin: 0;
        padding: 10px;
    }
</style>

</style>


</head>

    <?php
try {
    // ... Your SQL query and database connection code ...
    $conn = new PDO("sqlsrv:Server=KPTSVSP;Database=LEARNING_LOG", "sa", "SAPB1Admin");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query($sql_2023_all_open);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

   
   
    $dataAreaRaised = array();
    $dataAreaCause = array();
    
    
        foreach ($results as $entry) {
            // Get the areas raised and days left from the current entry
            $areaRaised = $entry['person'];
            $dayLeft = $entry['Days_open'];
        
            // Increment the count for the specified area raised and days left combination
            $key = $areaRaised . '-Days Left' . $dayLeft;
           
            //$dataAreaCause = array();
            if (isset($areaRaisedCounts[$key])) {
                $areaRaisedCounts[$key] += 1;
            } else {
                $areaRaisedCounts[$key] = 1;
            }
        }
        
    print_r($areaRaisedCounts);
    // Populate data arrays for both charts
   
    
    foreach ($areaRaisedCounts as $area => $count) {
        $dataAreaRaised[] = array($area, $count);
    }
    
    foreach ($areaCausedCounts as $area => $count) {
        $dataAreaCause[] = array($area, $count);
    }
    
    
 
   
   
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}
?>


<body>
    <div style="position:relative;width:100%;">
    <h2 >Open/Issues Raised Per Area</h2>
<div id="chart_div_area_raised" ></div>
<h2 >Open/Issues Caused Per Area</h2>
<div id="chart_div_area_cause" ></div>
</div>
</body>

    <!-- JavaScript for Google Charts -->
    <script type="text/javascript">
        // Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages':['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
    // Create data table for Area Raised chart.
    var dataAreaRaised = new google.visualization.DataTable();
    dataAreaRaised.addColumn('string', 'Category'); // Changed column label
    dataAreaRaised.addColumn('number', 'Number of Issues');
   dataAreaRaised.addRows(<?php echo json_encode($dataAreaRaised); ?>);

    // Create data table for Area of Cause chart.
    var dataAreaCause = new google.visualization.DataTable();
    dataAreaCause.addColumn('string', 'Category'); // Changed column label
    dataAreaCause.addColumn('number', 'Number of Issues');
    dataAreaCause.addRows(<?php echo json_encode($dataAreaCause); ?>);

    // Set chart options for both charts.
    var options = {
        chartArea: { height: '80%' },
        hAxis: {
            title: 'Number of Issues',
            titleTextStyle: {
            fontSize: 12 // Change font size for hAxis title
        },
        textStyle: {
            fontSize: 10 // Change font size for hAxis labels
        } // Changed axis title
        },
        vAxis: {
            title: 'Category',
            titleTextStyle: {
            fontSize: 12 // Change font size for hAxis title
        },
        textStyle: {
            fontSize: 10 // Change font size for hAxis labels
        },
            minValue: 0,
        },
        bar: { groupWidth: '10%' },
    };

    // Instantiate and draw the charts.
    var chartAreaRaised = new google.visualization.ColumnChart(document.getElementById('chart_div_area_raised'));
    chartAreaRaised.draw(dataAreaRaised, options);

    var chartAreaCause = new google.visualization.ColumnChart(document.getElementById('chart_div_area_cause'));
    chartAreaCause.draw(dataAreaCause, options);
}

    </script>

</html>
