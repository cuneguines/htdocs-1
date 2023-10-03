<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart Page</title>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>

    
    
    <style>
    /* Add a light blue background to the entire page */
    body {


        top: 0;
        height: 100vh;

        display: flex;
        background:linear-gradient(black,white)
        /* You can adjust the color code as needed */
    }

    /* Style the container for the links on the left */
    .sidebar {
        background-color: #f0f8ff;
        float: left;
        width: 30%;
        padding-bottom: 3%;
        
        margin-left: 7%;
        height: 70%;
        margin-top: 5%;
        padding-left: 5%;
        border-right: 5px solid white;
        box-shadow: 5px 5px 5px 5px;
        background:linear-gradient(beige,#0866c6);
    }

    /* Style the links in the sidebar */
    .sidebar ul {
        list-style-type: none;
        padding: 0;
    }

    .sidebar ul li {
        margin-bottom: 10px;
    }

    .sidebar a {
        text-decoration: none;
        color: #333;
    }

    .sidebar a:hover {
        color: #007bff;
        /* Change link color on hover */
    }

    /* Style the container for the chart on the right */
    .chart-container {
        float: left;
        width: 50%;
        height: 70%;
        margin-top: 5%;
        background-color: #f0f8ff;
        padding-bottom: 3%;
        box-shadow: 5px 5px 5px 5px;
        background-color:beige;

    }
    li
    {
        font-size:20px;
    }
    .sidebar ul li {
    margin-bottom: 10px;
    list-style-type: disc; /* Add bullet points */
}
    </style>
</head>

<body>
<?php include './SQL_Charts.php'; ?>
<?php
try {
    $conn = new PDO("sqlsrv:Server=KPTSVSP;Database=LEARNING_LOG", "sa", "SAPB1Admin");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->query($sql);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt_closed = $conn->query($sql_not_closed_status);
    $results_closed = $stmt_closed->fetchAll(PDO::FETCH_ASSOC);
    $stmt_cc = $conn->query($sql_2023_cc);
    $results_cc = $stmt_cc->fetchAll(PDO::FETCH_ASSOC);

    $stmt_pie = $conn->query($sql_pie);
    $results_pie = $stmt_pie->fetchAll(PDO::FETCH_ASSOC);
    $daysLeftData = [];
    $itemLabels = [];
    //Area caused
    $data_ac = [];
    //Area Raised
    $data_rd = [];
    $data3=[];

    $statusCounts = array(
        'Open' => 0,
        'Closed' => 0,
        'Other' => 0,
        
    );


    $responseTimeData = [
        'Engineering' => [],
        'Inspection' => [],
        'Fabrication' => []
    ];

  
    foreach ($results_closed as $row) {
        $itemLabels[] = $row['ID'];
        $daysLeftData[] = $row['Days_open'];
        $area_ac = $row['nc_area_caused'];
       
        if (!isset($data_ac[$area_ac])) {
            $data_ac[$area_ac] = 0;
        }
       
        
        $data_ac[$area_ac]++;
     
        $areaRaised = $row['area_raised_'];
        $dateRaised = new DateTime($row['time_stamp']);
        $dateUpdated = new DateTime($row['date_updated']);

        $responseTime = $dateUpdated->diff($dateRaised)->days;

        $responseTimeData[$areaRaised][] = $responseTime;
    }
    
    foreach ($results_closed as $row) {
        $itemLabels[] = $row['ID'];
        $daysLeftData[] = $row['Days_open'];
       
        $area_rd=$row['area_raised_'];
       
        if (!isset($data_rd[$area_rd])) {
            $data_rd[$area_rd] = 0;
        }
        
      
        $data_rd[$area_rd]++;
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

foreach ($results_pie as $row) {
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
    $labels_ac = array_keys($data_ac);
    $values_ac = array_values($data_ac);
    //print_r(array_keys($labels1));
    //print_r(array_values($values1));
    $labels_rd = array_keys($data_rd);
    $values_rd = array_values($data_rd);


    $combinedData_ac = array_combine($labels_ac, $values_ac);
    $combinedData_rd= array_combine($labels_rd, $values_rd);


// Sort the combined data array in descending order based on values
arsort($combinedData_ac);
arsort($combinedData_rd);

// Extract sorted labels and values back into separate arrays
$Labels_ac = array_keys($combinedData_ac);
$Values_ac = array_values($combinedData_ac);
$Labels_rd = array_keys($combinedData_rd);
$Values_rd = array_values($combinedData_rd);

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
    // Initialize an array to store the counts for each month
    $complaintCounts = array_fill(0, 12, 0); // Initialize with zeros for each month

    // Loop through the query results and count complaints for each month
    foreach ($results as $entry) {
        $formType = $entry['form_type'];
        $dateUpdated = strtotime($entry['time_stamp']);
        $status = $entry['Status'];

        // Check if the entry is a Customer Complaint in the year 2023
        if ($formType === 'Opportunity For Improvement' || $formType === 'Non Conformance' && date('Y', $dateUpdated) === '2023') {
            $month = date('n', $dateUpdated); // Get the month as a number (1-12)
            $complaintCounts[$month - 1]++; // Subtract 1 to account for zero-based array
        }
    }

    // Convert the array of counts to a JSON format for use in JavaScript
    $complaintCountsJSON = json_encode($complaintCounts);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}
?>

    <div class="sidebar">
        <!-- Create links on the left -->
        <h2>Opportunity For Improvement</h2>
        <ul>
            <li><a href="#"style="text-decoration: underline;" onclick="displayChart_1()">Open OFI Area Caused</a></li>
            <li><a href="#"style="text-decoration: underline;" onclick="displayChart_8()">Open OFI Area Raised </a></li>
            <li><a href="#" style="text-decoration: underline;"onclick="displayChart_2()">Open/Closed</a></li>
            <li><a href="#" style="text-decoration: underline;"onclick="displayChart_3()">Average Response Time</a></li>
            
            <li><a href="#" style="text-decoration: underline;"onclick="displayChart_5()">Cost</a></li>
            <li><a href="#" style="text-decoration: underline;"onclick="displayChart_6()">OFI PER Month for the year 2023</a></li>
            
        </ul>

       
        <h2>Customer Complaints</h2>
        <ul>
       
            <li><a href="#" style="text-decoration: underline;"onclick="">Open CC Per Area</a></li>
            <!--<li><a href="#" onclick="displayChart_2()">Open/Closed</a></li>
            <li><a href="#" onclick="displayChart_3()">Average Response Time</a></li>
            <li><a href="#" onclick="displayChart_4()">Pie Charts</a></li> -->
        </ul>
        <h2>Other</h2>
        <ul>
        <li><a href="#" style="text-decoration: underline;"onclick="displayChart_4()">Issues per Product</a></li>
</ul>
    </div>
    <div class="chart-container">
        <!-- Create a canvas for the chart -->
        <canvas id="myChart" width="500" height="400" ></canvas>
       
    </div>
<script>
 // Use passive: false to ensure preventDefault works

    let currentChart;
    // Function to display a chart based on the selected chart type
    function displayChart_1() {
    // Remove the existing chart if it exists
    if (currentChart) {
        currentChart.destroy();
    }

    // Get the chart canvas element
    var ctx = document.getElementById('myChart').getContext('2d');

    // Create the chart
    currentChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($Labels_ac); ?>,
            datasets: [{
                label: 'Open Occurrences of OFI per Area caused',
                data: <?php echo json_encode($Values_ac); ?>,
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
            },
            plugins: {
                legend: {
                    display: false // Hide the legend
                },
                datalabels: { // Configure the datalabels plugin
                    anchor: 'end',
                    align: 'top',
                    formatter: function(value) {
                        return value; // Display the data value on top of the bar
                    }
                }
            }
        }
    });

    // Show the chart canvas
    document.getElementById('myChart').style.display = 'block';
}
function displayChart_8() {
    // Remove the existing chart if it exists
    if (currentChart) {
        currentChart.destroy();
    }

    // Get the chart canvas element
    var ctx = document.getElementById('myChart').getContext('2d');

    // Create the chart
    currentChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($Labels_rd); ?>,
            datasets: [{
                label: 'Open Occurrences of OFI per Area Raised',
                data: <?php echo json_encode($Values_rd); ?>,
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
            },
            plugins: {
                legend: {
                    display: false // Hide the legend
                },
                datalabels: { // Configure the datalabels plugin
                    anchor: 'end',
                    align: 'top',
                    formatter: function(value) {
                        return value; // Display the data value on top of the bar
                    }
                }
            }
        }
    });

    // Show the chart canvas
    document.getElementById('myChart').style.display = 'block';
}

function displayChart_2() {
    // Remove the existing chart if it exists
    if (currentChart) {
        currentChart.destroy();
    }

    // Retrieve the data from PHP
    var statusLabels = <?php echo $statusLabelsJSON; ?>;
    var statusData = <?php echo $statusDataJSON; ?>;

    // Get the chart canvas element
    var ctx = document.getElementById('myChart').getContext('2d');

    // Create the chart with the datalabels plugin
    currentChart = new Chart(ctx, {
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
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                },
                datalabels: {  // Add the datalabels configuration
                    formatter: (value, context) => {
                        return value; // Display the count as the label
                    },
                    color: 'red', // Customize label color
                    anchor: 'end', // Position the label on the end of the slice
                    align: 'start', // Align the label to the start of the slice
                    offset: 2 // Adjust the label's position from the slice
                }
            }
        }
    });
    //ctx.canvas.height = 1300;
    // Show the chart canvas
    document.getElementById('myChart').style.display = 'block';
}



function displayChart_3() {
    // Remove the existing chart if it exists
    if (currentChart) {
        currentChart.destroy();
    }

    // Get the chart canvas element
    var ctx = document.getElementById('myChart').getContext('2d');

    // Create the chart
    currentChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($data3['labels']); ?>,
            datasets: [{
                label: 'Average Response Time (days)',
                data: <?php echo json_encode($data3['values']); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
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
    //ctx.canvas.height = 1300;
    // Show the chart canvas
    document.getElementById('myChart').style.display = 'block';
}

function displayChart_4() {
    // Remove the existing chart if it exists
    if (currentChart) {
        currentChart.destroy();
    }

    var ctx = document.getElementById('myChart').getContext('2d');
    currentChart = new Chart(ctx, {
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
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            },
            plugins: {
                legend: {
                    display: false // Hide the legend
                },
                datalabels: { // Configure the datalabels plugin
                    anchor: 'end',
                    align: 'top',
                    formatter: function(value) {
                        return value; // Display the data value on top of the bar
                    }
                }
            }
        }
    });

    document.getElementById('myChart').style.display = 'block';
}



function displayChart_5()
{
       // Your data
       if (currentChart) {
        currentChart.destroy();
    }

       var labels = ['DR', 'ST', 'Int', 'BPSP', 'BPBP', 'MB'];
        var data = [156, 2569, 2469, 3464, 2647, 3467];

        // Create a bar chart
        var ctx = document.getElementById('myChart').getContext('2d');
        currentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Cost',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Business Unit'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Cost'
                        },
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false // Hide the legend
                    },
                    datalabels: { // Configure the datalabels plugin
                        anchor: 'end',
                        align: 'top',
                        formatter: function(value) {
                            return value; // Display the data value on top of the bar
                        }
                    }
                }
            }
           

        });
        document.getElementById('myChart').style.display = 'block';
}


function displayChart_6()
{
       
       if (currentChart) {
        currentChart.destroy();
    }

    var ctx = document.getElementById('myChart').getContext('2d');
    // Your data (you can replace this with your data)
    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var data = <?php echo $complaintCountsJSON; ?>;

    // Create the chart
  currentChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'OFI Count',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
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
            },
            plugins: {
                legend: {
                    display: false // Hide the legend
                },
                datalabels: { // Configure the datalabels plugin
                    anchor: 'end',
                    align: 'top',
                    formatter: function(value) {
                        return value; // Display the data value on top of the bar
                    }
                }
            }
        }
    });
    document.getElementById('myChart').style.display = 'block';

}
</script>