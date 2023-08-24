<?php
// session_start();
// $user_id = $_SESSION['user_id'];
// $username = $_SESSION['username'];
// $count=$_SESSION['Chart_count'];
// echo "Welcome : ".$username."YUOR CAHRT AHS " .$count."items" ;





$sql = "SELECT  *,CASE WHEN ISNULL(t0.nc_description, '') = '' THEN t0.cc_desc ELSE t0.nc_description END as description, case when t0.nc_area_caused='' then 'No Area' when t0.nc_area_caused is NULL then 'No Area' else t0.nc_area_caused end [nc_area_caused], case when t0.area_raised_by = '' then 'NO Area' when t0.area_raised_by is NULL then 'NO Area' else t0.area_raised_by end [area_raised_], FORMAT(t20.date_updated, 'dd-MM-yyyy')[date_updated], ISNULL(t77.person, 'No Owner')[person], FORMAT(t0.time_stamp, 'dd-MM-yyyy')[time_stamp], t0.Id as ID, (case when t20.Status is NULL then 'Other' when t20.Status='Open' then 'Open' when t20.Status='Closed' then 'Closed' end) [Status], t20.Action, ISNULL(t20.Owner, 'No Owner')[Owner], FORMAT(t20.Date, 'dd-MM-yyyy')[TargetDate], t50.CardName[Customer], t50.U_Client, t11.Dscription, t11.ItemCode, ISNULL(t12.U_Product_Group_One, 'NO PRODUCT GROUP')[U_Product_Group_One], t12.U_Product_Group_Two, t12.U_Product_Group_Three, (case when DateDiff(day, GETDATE(), t20.Date) > 0 and DateDiff(day, GETDATE(), t20.Date) <= 14 and t20.Status='Open' and t20.Date!='01/01/1900 00:00:00' then 'Due_next_two_weeks' when DATEDIFF(DAY, GETDATE(), t20.Date) >= -14 and DATEDIFF(DAY, GETDATE(), t20.Date) < 0 and t20.Status='Closed' and t20.Date!='01/01/1900 00:00:00' then 'Closed_last_two_weeks' end) [new_stat], (case WHEN t20.Date!='01/01/1900 00:00:00' and t20.Date is not null then DateDiff(day, GETDATE(), t20.Date) end)[Days_open], (case WHEN t44.attachments is null then 'N' else t44.attachments END) [attachements_issues] FROM ms_qual_log t0 LEFT JOIN (SELECT t1.ID, MAX(t1.date_updated) as Maxdate FROM dbo.Table_2 t1 WHERE t1.Status='Cancelled' GROUP BY t1.ID) t2 ON t2.ID = t0.ID LEFT JOIN (SELECT t8.Status, t8.Date, t8.ID, t8.Owner, t8.Action, t8.date_updated FROM dbo.Table_2 t8 INNER JOIN (SELECT t1.ID, MAX(t1.date_updated) as Mmaxdate FROM dbo.Table_2 t1 WHERE t1.Status<>'Cancelled' GROUP BY t1.ID) t6 ON t6.Mmaxdate = t8.date_updated AND t6.ID=t8.ID) t20 ON t20.ID=t0.ID AND t20.Status<>'Cancelled' LEFT JOIN (SELECT t0.* FROM KENTSTAINLESS.dbo.ordr t0) t50 ON t50.DocNum=nc_sales_order LEFT JOIN KENTSTAINLESS.dbo.rdr1 t11 ON t11.DocEntry = t50.DocEntry AND t11.U_IIS_proPrOrder = nc_process_order LEFT JOIN KENTSTAINLESS.dbo.oitm t12 ON t12.ItemCode COLLATE SQL_Latin1_General_CP1_CI_AS = COALESCE(nc_itemcode, cc_itemcode) COLLATE SQL_Latin1_General_CP1_CI_AS LEFT JOIN KENTSTAINLESS.dbo.oitb t13 ON t13.ItmsGrpCod = t12.ItmsGrpCod LEFT JOIN (SELECT t55.sap_id, t55.created_date, t55.attachments FROM dbo.attachment_table t55 INNER JOIN (SELECT t1.sap_id, MAX(t1.created_date) as Mmaxdate FROM dbo.attachment_table t1 GROUP BY t1.sap_id) t66 ON t66.Mmaxdate = t55.created_date AND t66.sap_id = t55.sap_id) t44 ON t44.sap_id = t0.ID AND t44.attachments is not NULL LEFT JOIN (SELECT (t0.firstName + ' ' + t0.lastName)[person], t0.email FROM KENTSTAINLESS.dbo.ohem t0 WHERE t0.Active = 'Y' AND t0.email is not NULL) t77 ON t77.email COLLATE SQL_Latin1_General_CP1_CI_AS = t20.Owner COLLATE SQL_Latin1_General_CP1_CI_AS WHERE t0.form_type in ('Non Conformance', 'Customer complaints', 'Opportunity For Improvement') AND t2.ID IS NULL  and nc_description is not null ORDER BY CAST(t0.ID AS int)";
$sql_not_closed_status="SELECT  *,CASE WHEN ISNULL(t0.nc_description, '') = '' THEN t0.cc_desc ELSE t0.nc_description END as description, case when t0.nc_area_caused='' then 'No Area' when t0.nc_area_caused is NULL then 'No Area' else t0.nc_area_caused end [nc_area_caused], case when t0.area_raised_by = '' then 'NO Area' when t0.area_raised_by is NULL then 'NO Area' else t0.area_raised_by end [area_raised_], FORMAT(t20.date_updated, 'dd-MM-yyyy')[date_updated], ISNULL(t77.person, 'No Owner')[person], FORMAT(t0.time_stamp, 'dd-MM-yyyy')[time_stamp], t0.Id as ID, (case when t20.Status is NULL then 'Other' when t20.Status='Open' then 'Open' when t20.Status='Closed' then 'Closed' end) [Status], t20.Action, ISNULL(t20.Owner, 'No Owner')[Owner], FORMAT(t20.Date, 'dd-MM-yyyy')[TargetDate], t50.CardName[Customer], t50.U_Client, t11.Dscription, t11.ItemCode, ISNULL(t12.U_Product_Group_One, 'NO PRODUCT GROUP')[U_Product_Group_One], t12.U_Product_Group_Two, t12.U_Product_Group_Three, (case when DateDiff(day, GETDATE(), t20.Date) > 0 and DateDiff(day, GETDATE(), t20.Date) <= 14 and t20.Status='Open' and t20.Date!='01/01/1900 00:00:00' then 'Due_next_two_weeks' when DATEDIFF(DAY, GETDATE(), t20.Date) >= -14 and DATEDIFF(DAY, GETDATE(), t20.Date) < 0 and t20.Status='Closed' and t20.Date!='01/01/1900 00:00:00' then 'Closed_last_two_weeks' end) [new_stat], (case WHEN t20.Date!='01/01/1900 00:00:00' and t20.Date is not null then DateDiff(day, GETDATE(), t20.Date) end)[Days_open], (case WHEN t44.attachments is null then 'N' else t44.attachments END) [attachements_issues] FROM ms_qual_log t0 LEFT JOIN (SELECT t1.ID, MAX(t1.date_updated) as Maxdate FROM dbo.Table_2 t1 WHERE t1.Status='Cancelled' GROUP BY t1.ID) t2 ON t2.ID = t0.ID LEFT JOIN (SELECT t8.Status, t8.Date, t8.ID, t8.Owner, t8.Action, t8.date_updated FROM dbo.Table_2 t8 INNER JOIN (SELECT t1.ID, MAX(t1.date_updated) as Mmaxdate FROM dbo.Table_2 t1 WHERE t1.Status<>'Cancelled' GROUP BY t1.ID) t6 ON t6.Mmaxdate = t8.date_updated AND t6.ID=t8.ID) t20 ON t20.ID=t0.ID AND t20.Status<>'Cancelled' LEFT JOIN (SELECT t0.* FROM KENTSTAINLESS.dbo.ordr t0) t50 ON t50.DocNum=nc_sales_order LEFT JOIN KENTSTAINLESS.dbo.rdr1 t11 ON t11.DocEntry = t50.DocEntry AND t11.U_IIS_proPrOrder = nc_process_order LEFT JOIN KENTSTAINLESS.dbo.oitm t12 ON t12.ItemCode COLLATE SQL_Latin1_General_CP1_CI_AS = COALESCE(nc_itemcode, cc_itemcode) COLLATE SQL_Latin1_General_CP1_CI_AS LEFT JOIN KENTSTAINLESS.dbo.oitb t13 ON t13.ItmsGrpCod = t12.ItmsGrpCod LEFT JOIN (SELECT t55.sap_id, t55.created_date, t55.attachments FROM dbo.attachment_table t55 INNER JOIN (SELECT t1.sap_id, MAX(t1.created_date) as Mmaxdate FROM dbo.attachment_table t1 GROUP BY t1.sap_id) t66 ON t66.Mmaxdate = t55.created_date AND t66.sap_id = t55.sap_id) t44 ON t44.sap_id = t0.ID AND t44.attachments is not NULL LEFT JOIN (SELECT (t0.firstName + ' ' + t0.lastName)[person], t0.email FROM KENTSTAINLESS.dbo.ohem t0 WHERE t0.Active = 'Y' AND t0.email is not NULL) t77 ON t77.email COLLATE SQL_Latin1_General_CP1_CI_AS = t20.Owner COLLATE SQL_Latin1_General_CP1_CI_AS WHERE t0.form_type in ('Non Conformance', 'Customer complaints', 'Opportunity For Improvement') AND t2.ID IS NULL  and nc_description is not null and status<>'Closed' ORDER BY CAST(t0.ID AS int)";

try {
    $conn = new PDO("sqlsrv:Server=KPTSVSP;Database=LEARNING_LOG", "sa", "SAPB1Admin");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query($sql);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt_closed = $conn->query($sql_not_closed_status);
    $results_closed = $stmt_closed->fetchAll(PDO::FETCH_ASSOC);


    $daysLeftData = [];
    $itemLabels = [];
    $data1 = [];
    $data3=[];

    $statusCounts = array(
        'Open' => 0,
        'Closed' => 0,
        
    );


    $responseTimeData = [
        'Engineering' => [],
        'Inspection' => [],
        'Fabrication' => []
    ];

  
    foreach ($results_closed as $row) {
        $itemLabels[] = $row['ID'];
        $daysLeftData[] = $row['Days_open'];
        $area = $row['nc_area_caused'];

        if (!isset($data1[$area])) {
            $data1[$area] = 0;
        }

        
        $data1[$area]++;
        $areaRaised = $row['area_raised_'];
        $dateRaised = new DateTime($row['time_stamp']);
        $dateUpdated = new DateTime($row['date_updated']);

        $responseTime = $dateUpdated->diff($dateRaised)->days;

        $responseTimeData[$areaRaised][] = $responseTime;
    }
    

  
//print_r($data1);
$averageResponseTime = [];
foreach ($responseTimeData as $areaRaised => $responseTimes) {
    $averageResponseTime[$areaRaised] = count($responseTimes) > 0 ? array_sum($responseTimes) / count($responseTimes) : 0;
}

// Prepare the data for the chart
$labels3 = array_keys($averageResponseTime);
$values3 = array_values($averageResponseTime);

$data3 = [
    'labels' => $labels3,
    'values' => $values3
];
// Combine labels and values into an associative array
$combinedData = array_combine($data3['labels'], $data3['values']);

// Sort the combined data array in descending order based on values
arsort($combinedData);

// Extract sorted labels and values back into separate arrays
$sortedLabels = array_keys($combinedData);
$sortedValues = array_values($combinedData);

// Update the data array with sorted labels and values
$data3['labels'] = $sortedLabels;
$data3['values'] = $sortedValues;

foreach ($results as $row) {
$status = $row['Status'];
        if (isset($statusCounts[$status])) {
            $statusCounts[$status]++;
        }
    }
// Generate the data for the chart
$statusLabels = array_keys($statusCounts);
$statusData = array_values($statusCounts);

// Encode the data as JSON for passing to JavaScript
$statusLabelsJSON = json_encode($statusLabels);
$statusDataJSON = json_encode($statusData);
//print_r($statusLabelsJSON);
//print_r($statusDataJSON);

    // Prepare the data for the chart
    $labels1 = array_keys($data1);
    $values1 = array_values($data1);
    //print_r(array_keys($labels1));
    //print_r(array_values($values1));



    $combinedData = array_combine($labels1, $values1);

// Sort the combined data array in descending order based on values
arsort($combinedData);

// Extract sorted labels and values back into separate arrays
$Labels1 = array_keys($combinedData);
$Values1 = array_values($combinedData);
    //die;
    $data = [
        'labels' => $itemLabels,
        'datasets' => [
            [
                'label' => 'Days Left',
                'data' => $daysLeftData,
                'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                'borderColor' => 'rgba(54, 162, 235, 1)',
                'borderWidth' => 1
            ]
        ]
    ];
    //Chart 4
    $pg2Data = array();
    foreach ($results as $result) {
        $pg2 = $result['U_Product_Group_Two'];
        if (!empty($pg2)) {
            if (isset($pg2Data[$pg2])) {
                $pg2Data[$pg2]++;
            } else {
                $pg2Data[$pg2] = 1;
            }
        }
    }
   
    arsort($pg2Data);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    body {
        top: 0;
        height: 100vh;
        display: flex;
        overflow-y: hidden;
    }

    .chart-container {
        float: left;
        width: 50%;
        margin-right: 0.5%;
        padding: 1%;
        background-color: black;
        height: 98%;
        position: relative;

    }

    .float-container {
        border: 3px solid #fff;
        padding: 20px;
    }

    .float-child {
        width: 50%;
        float: left;
        padding: 20px;
        border: 2px solid red;
    }

    canvas {
        max-width: 100%;
        max-height: 31.5%;
        background-color: cornsilk;
        box-shadow: 0 0 20px #009688;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;

    }

    th,
    td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tbody tr:hover {
        background-color: #e9e9e9;
    }

    .float-container {
        border: 3px solid #fff;
        padding: 20px;
    }

    .float-child {
        width: 50%;
        float: left;
        padding: 20px;
        border: 2px solid red;
    }
    </style>
</head>

<body>


    <div class="chart-container">



        <canvas id="myChart"></canvas>
        <div
            style="margin-top: 1%; overflow-y: scroll; height: 33%; background-color: cornsilk; box-shadow: 0 0 20px #009688;">
            <div style="position: sticky; top:0;background-color: cornsilk;text-align:center;font-size:larger">
                <h3 style="background-color:cornsilk;margin-top:-2%;margin-bottom:-2%">Quality Table</h3>
            </div>
            <div style="padding:2%">
                <table style="height:33%">
                    <thead style="position: sticky;top:25px;background-color: blue">
                        <tr>
                            <th style="width:25%">Item No</th>
                            <th style="width:25%">Description</th>
                            <th style="width:25%">Owner</th>
                            <th style="width:25%">Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row) : ?>
                        <tr>
                            <td style="text-align:center"><?php echo $row['ID']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['Owner']; ?></td>
                            <td><?php echo $row['form_type']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <canvas style="margin-top:1%" id="myChart2"></canvas>

    </div>

    <div class="chart-container"style="float:left;background-color: black;padding: 1%;width:45%;height:100%">
        <canvas id="statusChart"></canvas>


        <canvas style="margin-top:1%;top:50px" id="responseTimeChart"></canvas>
        <canvas style="margin-top:1%;top:50px" id="myChart4"></canvas>
    </div>
    </div>

    <script>
    var chartData = <?php echo json_encode($data); ?>;
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Days Left'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Item'
                    }
                }
            }
        }
    });
    </script>
    <script>
    // Get the chart canvas element
    var ctx = document.getElementById('myChart2').getContext('2d');

    // Create the chart
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($Labels1); ?>,
            datasets: [{
                label: 'Open Occurances of OFI per Area caused',
                data: <?php echo json_encode($Values1); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.7)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            }
        }
    });
    </script>

    <script>
    // Retrieve the data from PHP
    var statusLabels = <?php echo $statusLabelsJSON; ?>;
    var statusData = <?php echo $statusDataJSON; ?>;

    // Create the chart
    var ctx = document.getElementById('statusChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusData,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
    </script>
    <script>
    var chartData = <?php echo json_encode($data3); ?>;
    var ctx = document.getElementById('responseTimeChart').getContext('2d');
    var responseTimeChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Average Response Time (days)',
                data: chartData.values,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Days'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Area Raised'
                    }
                }
            }
        }
    });
    </script>
    <script>
    // Create the chart
    var ctx = document.getElementById('myChart4').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($pg2Data)); ?>,
            datasets: [{
                label: 'Number of Issues',
                data: <?php echo json_encode(array_values($pg2Data)); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
    </div>
</body>

</html>