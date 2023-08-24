<?php
// session_start();
// $_SESSION['user_id'] = 123;
// $_SESSION['username'] = 'john_doe';
// $_SESSION['Chart_count']=3;

$sql_2023_cc = "SELECT  *,CASE WHEN ISNULL(t0.nc_description, '') = '' THEN t0.cc_desc ELSE t0.nc_description END as description, case when t0.nc_area_caused='' then 'No Area' when t0.nc_area_caused is NULL then 'No Area' else t0.nc_area_caused end [nc_area_caused], case when t0.area_raised_by = '' then 'NO Area' when t0.area_raised_by is NULL then 'NO Area' else t0.area_raised_by end [area_raised_], FORMAT(t20.date_updated, 'dd-MM-yyyy')[date_updated], ISNULL(t77.person, 'No Owner')[person], FORMAT(t0.time_stamp, 'dd-MM-yyyy')[time_stamp], t0.Id as ID, (case when t20.Status is NULL then 'Other' when t20.Status='Open' then 'Open' when t20.Status='Closed' then 'Closed' end) [Status], t20.Action, ISNULL(t20.Owner, 'No Owner')[Owner], FORMAT(t20.Date, 'dd-MM-yyyy')[TargetDate], t50.CardName[Customer], t50.U_Client, t11.Dscription, t11.ItemCode, ISNULL(t12.U_Product_Group_One, 'NO PRODUCT GROUP')[U_Product_Group_One], t12.U_Product_Group_Two, t12.U_Product_Group_Three, (case when DateDiff(day, GETDATE(), t20.Date) > 0 and DateDiff(day, GETDATE(), t20.Date) <= 14 and t20.Status='Open' and t20.Date!='01/01/1900 00:00:00' then 'Due_next_two_weeks' when DATEDIFF(DAY, GETDATE(), t20.Date) >= -14 and DATEDIFF(DAY, GETDATE(), t20.Date) < 0 and t20.Status='Closed' and t20.Date!='01/01/1900 00:00:00' then 'Closed_last_two_weeks' end) [new_stat], (case WHEN t20.Date!='01/01/1900 00:00:00' and t20.Date is not null then DateDiff(day, GETDATE(), t20.Date) end)[Days_open], (case WHEN t44.attachments is null then 'N' else t44.attachments END) [attachements_issues] FROM ms_qual_log t0 LEFT JOIN (SELECT t1.ID, MAX(t1.date_updated) as Maxdate FROM dbo.Table_2 t1 WHERE t1.Status='Cancelled' GROUP BY t1.ID) t2 ON t2.ID = t0.ID LEFT JOIN (SELECT t8.Status, t8.Date, t8.ID, t8.Owner, t8.Action, t8.date_updated FROM dbo.Table_2 t8 INNER JOIN (SELECT t1.ID, MAX(t1.date_updated) as Mmaxdate FROM dbo.Table_2 t1 WHERE t1.Status<>'Cancelled' GROUP BY t1.ID) t6 ON t6.Mmaxdate = t8.date_updated AND t6.ID=t8.ID) t20 ON t20.ID=t0.ID AND t20.Status<>'Cancelled' LEFT JOIN (SELECT t0.* FROM KENTSTAINLESS.dbo.ordr t0) t50 ON t50.DocNum=nc_sales_order LEFT JOIN KENTSTAINLESS.dbo.rdr1 t11 ON t11.DocEntry = t50.DocEntry AND t11.U_IIS_proPrOrder = nc_process_order LEFT JOIN KENTSTAINLESS.dbo.oitm t12 ON t12.ItemCode COLLATE SQL_Latin1_General_CP1_CI_AS = COALESCE(NULLIF(nc_itemcode,''), cc_itemcode) COLLATE SQL_Latin1_General_CP1_CI_AS LEFT JOIN KENTSTAINLESS.dbo.oitb t13 ON t13.ItmsGrpCod = t12.ItmsGrpCod LEFT JOIN (SELECT t55.sap_id, t55.created_date, t55.attachments FROM dbo.attachment_table t55 INNER JOIN (SELECT t1.sap_id, MAX(t1.created_date) as Mmaxdate FROM dbo.attachment_table t1 GROUP BY t1.sap_id) t66 ON t66.Mmaxdate = t55.created_date AND t66.sap_id = t55.sap_id) t44 ON t44.sap_id = t0.ID AND t44.attachments is not NULL LEFT JOIN (SELECT (t0.firstName + ' ' + t0.lastName)[person], t0.email FROM KENTSTAINLESS.dbo.ohem t0 WHERE t0.Active = 'Y' AND t0.email is not NULL) t77 ON t77.email COLLATE SQL_Latin1_General_CP1_CI_AS = t20.Owner COLLATE SQL_Latin1_General_CP1_CI_AS WHERE t0.form_type in ('Customer Complaints') AND t2.ID IS NULL  and nc_description is not null  ORDER BY CAST(t0.ID AS int) ";


    try {
        $conn = new PDO("sqlsrv:Server=KPTSVSP;Database=LEARNING_LOG", "sa", "SAPB1Admin");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $stmt = $conn->query($sql_2023_cc);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $areaCounts = array();
      
        foreach ($results as $entry) {
            $areaCaused = $entry['U_Product_Group_Two'];
    
            if ($areaCaused) {
                if (!isset($areaCounts[$areaCaused])) {
                    $areaCounts[$areaCaused] = 1;
                } else {
                    $areaCounts[$areaCaused]++;
                }
            }
        }
    arsort($areaCounts);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        exit();
    }

    ?>
    
    <!DOCTYPE html>
    <html>
    <head>
        <title>Bar Chart Example</title>
        <!-- Include the Google Charts API -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    </head>
    <body>
        <div id="chart_div" style="width: 100%; height: 400px;"></div>
    
        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);
    
            function drawChart() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Area');
                data.addColumn('number', 'Issue Count');
    
                <?php foreach ($areaCounts as $area => $count) { ?>
                    data.addRow(['<?php echo $area; ?>', <?php echo $count; ?>]);
                <?php } ?>
    
                var options = {
                    title: 'Number Of Customer Complaints in Each Product Group ',
                    vAxis: {title: 'Issue Count'},
                    hAxis: {title: 'Area'},
                    chartArea: {width: '50%'}
                };
    
                var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
        </script>
    </body>
    </html>