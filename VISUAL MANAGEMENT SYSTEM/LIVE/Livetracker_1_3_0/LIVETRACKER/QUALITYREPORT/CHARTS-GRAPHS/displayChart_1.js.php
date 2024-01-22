

<?php include './cache.php'; ?>



    <?php

    $results = json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_sql.json'), true); 
    $results_closed_avg = json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_sql_closed_avg.json'), true); 
    $results_closed = json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_sql_closed_status.json'), true); 
    $results_cc = json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_sql_2023_cc.json'), true); 
    $results_pie = json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_sql_pie.json'), true); 
    
    $results_for_cc= json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_sql_cc.json'), true); 
    $results_closed_cc_avg = json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_sql_closed_cc_avg.json'), true); 
    $results_closed_cc= json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_sql_closed_status_cc.json'), true);
   // $results_cc = json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_sql_2023_cc.json'), true); 
    $results_pie_cc= json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_sql_pie_cc.json'), true); 
    $results_NEW= json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_SQL_NEW.json'), true); 

$rework=json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_rework_cost.json'), true); 

    //$conn = new PDO("sqlsrv:Server=KPTSVSP;Database=LEARNING_LOG", "sa", "SAPB1Admin");
    //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //$stmt_avg = $conn->query($sql_closed_avg);
    //$results_closed_avg= $stmt_avg->fetchAll(PDO::FETCH_ASSOC);
    //$stmt = $conn->query($sql);
   // $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
   // $stmt_closed = $conn->query($sql_closed_status);
   // $results_closed = $stmt_closed->fetchAll(PDO::FETCH_ASSOC);
    //$stmt_cc = $conn->query($sql_2023_cc);
   // $results_cc = $stmt_cc->fetchAll(PDO::FETCH_ASSOC);

   // $stmt_pie = $conn->query($sql_pie);
   // $results_pie = $stmt_pie->fetchAll(PDO::FETCH_ASSOC);
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
        'To be Actioned' => 0,
        
    );


    //CC 

   // $stmt_cc_avg = $conn->query($sql_closed_cc_avg);
   // $results_closed_cc_avg= $stmt_cc_avg->fetchAll(PDO::FETCH_ASSOC);
   // $stmt_for_cc= $conn->query($sql_cc);
    //$results_for_cc = $stmt_for_cc->fetchAll(PDO::FETCH_ASSOC);
    //$stmt_closed_cc = $conn->query($sql_closed_status_cc);
    //$results_closed_cc = $stmt_closed_cc->fetchAll(PDO::FETCH_ASSOC);
   // $stmt_pie_cc = $conn->query($sql_pie_cc);
   // $results_pie_cc = $stmt_pie_cc->fetchAll(PDO::FETCH_ASSOC);
//OTHER
   
//$stmt_NEW = $conn->query($SQL_NEW);
//$results_NEW= $stmt_NEW->fetchAll(PDO::FETCH_ASSOC);
   
$data_ac_cc=[];
    foreach ($results_closed_cc as $row) {
        $itemLabels[] = $row['ID'];
        $daysLeftData[] = $row['Days_open'];
        $area_ac_cc = $row['cc_area_caused'];
       
        if (!isset($data_ac_cc[$area_ac_cc])) {
            $data_ac_cc[$area_ac_cc] = 0;
        }
       
        
        $data_ac_cc[$area_ac_cc]++;
     }
     $data_rd_cc=[];
    foreach ($results_closed_cc as $row) {
        $itemLabels[] = $row['ID'];
        $daysLeftData[] = $row['Days_open'];
       
        $area_rd_cc=$row['cc_area_raised_by'];
        if ($area_rd_cc != NULL) {
       
        if (!isset($data_rd_cc[$area_rd_cc])  ) {
            $data_rd_cc[$area_rd_cc] = 0;
        }
        $data_rd_cc[$area_rd_cc]++;
      }
    }



      $labels_ac_cc = array_keys($data_ac_cc);
      $values_ac_cc = array_values($data_ac_cc);
      //print_r(array_keys($labels1));
      //print_r(array_values($values1));
      $labels_rd_cc= array_keys($data_rd_cc);
      $values_rd_cc = array_values($data_rd_cc);
  

  
      $combinedData_ac_cc = array_combine($labels_ac_cc, $values_ac_cc);
      $combinedData_rd_cc= array_combine($labels_rd_cc, $values_rd_cc);
  
  
  // Sort the combined data array in descending order based on values
  arsort($combinedData_ac_cc);
  arsort($combinedData_rd_cc);
  $count_rd_cc=is_array($combinedData_rd_cc)  && count($combinedData_rd_cc) > 0 ? reset($combinedData_rd_cc) : 0;
  $count_ac_cc=is_array($combinedData_ac_cc) && count($combinedData_ac_cc) > 0 ? reset($combinedData_ac_cc) : 0;
  
  // Extract sorted labels and values back into separate arrays
  $Labels_ac_cc = array_keys($combinedData_ac_cc);
  $Values_ac_cc = array_values($combinedData_ac_cc);
  $Labels_rd_cc= array_keys($combinedData_rd_cc);
  $Values_rd_cc= array_values($combinedData_rd_cc);

//OFI
      foreach ($results_closed as $row) {
        $itemLabels[] = $row['ID'];
        $daysLeftData[] = $row['Days_open'];
        $area_ac = $row['nc_area_caused'];
       
        if (!isset($data_ac[$area_ac])) {
            $data_ac[$area_ac] = 0;
        }
       
        
        $data_ac[$area_ac]++;
     }
    
    foreach ($results_closed as $row) {
        $itemLabels[] = $row['ID'];
        $daysLeftData[] = $row['Days_open'];
       
        $area_rd=$row['area_raised_'];
       
        if (!isset($data_rd[$area_rd])) {
            $data_rd[$area_rd] = 0;
        }
        $data_rd[$area_rd]++;
      }
   

  
//AVERAGE RESPONSE TIME FOrEACH PERSON in DAYS DIFFERNEC BETWEEN TIMESTAMP AND UPDATED DATE
$averageResponseTime = []; // Initialize an array to store the average response times for each person

foreach ($results_closed_avg as $row) {
    $person = $row['person'];
    $dateRaised = new DateTime($row['time_stamp']);
    $dateUpdated = new DateTime($row['date_updated']);

    $responseTime = $dateUpdated->diff($dateRaised)->days;
   
    // Check if the person already has recorded response times
    if (isset($averageResponseTime[$person])) {
        // If yes, add the new response time to the existing array
        $averageResponseTime[$person][]= $responseTime;
    } else {
        // If no, create a new array with the current response time
        $averageResponseTime[$person]= [$responseTime];
    }
}

// Calculate the average response time for each person
foreach ($averageResponseTime as $person => $responseTimes) {
    
    $averageResponseTime[$person] = count($responseTimes) > 0 ?floor( array_sum($responseTimes) / count($responseTimes)) : 0;
}

// Sort the average response times array in descending order
arsort($averageResponseTime);

// Prepare the data for the chart
$labels3 = array_keys($averageResponseTime);
$values3 = array_values($averageResponseTime);


$data3 = [
    'labels' => $labels3,
    'values' => $values3
   
];


// AVG RESPONSE TIME FOR CC
//AVERAGE RESPONSE TIME FOrEACH PERSON in DAYS DIFFERNEC BETWEEN TIMESTAMP AND UPDATED DATE
$averageResponseTime_cc = []; // Initialize an array to store the average response times for each person

foreach ($results_closed_cc_avg as $row) {
    $person_cc = $row['person'];
    $dateRaised_cc = new DateTime($row['time_stamp']);
    $dateUpdated_cc = new DateTime($row['date_updated']);

    $responseTime_cc = $dateUpdated->diff($dateRaised_cc)->days;
   
    // Check if the person already has recorded response times
    if (isset($averageResponseTime_cc[$person_cc])) {
        // If yes, add the new response time to the existing array
        $averageResponseTime_cc[$person_cc][]= $responseTime_cc;
    } else {
        // If no, create a new array with the current response time
        $averageResponseTime_cc[$person_cc]= [$responseTime_cc];
    }
}

// Calculate the average response time for each person
foreach ($averageResponseTime_cc as $person_cc => $responseTimes_cc) {
    
    $averageResponseTime_cc[$person_cc] = count($responseTimes_cc) > 0 ? floor(array_sum($responseTimes_cc) / count($responseTimes_cc) ): 0;
}

// Sort the average response times array in descending order
arsort($averageResponseTime_cc);

// Prepare the data for the chart
$labels_12 = array_keys($averageResponseTime_cc);
$values_12 = array_values($averageResponseTime_cc);

$data_12 = [
    'labels' => $labels_12,
    'values' => $values_12
];


//PIE CHART FOR OFI

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

//PIE FOR THE CC

$statusCounts_cc = array(
    'Open' => 0,
    'Closed' => 0,
    'To be Action' => 0,
    
);
foreach ($results_pie_cc as $row) {
    $status_cc = $row['Status'];
            if (isset($statusCounts_cc[$status_cc])) {
                $statusCounts_cc[$status_cc]++;
            }
        }
    // Generate the data for the chart
    $statusLabels_cc = array_keys($statusCounts_cc);
    $statusData_cc= array_values($statusCounts_cc);
    
    // Encode the data as JSON for passing to JavaScript
    $statusLabelsJSON_cc = json_encode($statusLabels_cc);
    $statusDataJSON_cc= json_encode($statusData_cc);
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
$count_rd = is_array($combinedData_rd) && count($combinedData_rd) > 0 ? reset($combinedData_rd) : 0;
//print_r($count_rd);
$count_ac=is_array($combinedData_ac) && count($combinedData_ac) > 0 ? reset($combinedData_ac) : 0;
//print_r($count_ac);
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
    foreach ($results_NEW as $result) {
        $pg2 = $result['U_Product_Group_Two'];
        //print_r($pg2);
        
        if (!empty($pg2)) {
            if (isset($pg2Data[$pg2])) {
                $pg2Data[$pg2]++;
            } else {
                $pg2Data[$pg2] = 1;
            }
        }
    }
    //print_r($pg2Data);
   
    arsort($pg2Data);
    // Initialize an array to store the counts for each month
    $complaintCounts = array_fill(0, 12, 0);
    $complaintCounts_closed= array_fill(0, 12, 0);  // Initialize with zeros for each month

    // Loop through the query results and count complaints for each month
    foreach ($results as $entry) {
        $formType = $entry['form_type'];
        $dateUpdated = strtotime($entry['time_stamp']);
        $status = $entry['Status'];

        // Check if the entry is a Customer Complaint in the year 2023
        if ($status==='Open'&& $formType === 'Opportunity For Improvement' || $formType === 'Non Conformance' && date('Y', $dateUpdated) === date("Y")) {
            $month = date('n', $dateUpdated); // Get the month as a number (1-12)
            $complaintCounts[$month - 1]++; // Subtract 1 to account for zero-based array
        }
    }

    // Convert the array of counts to a JSON format for use in JavaScript for AREA CHART
    $complaintCountsJSON = json_encode($complaintCounts);
    //print_r($complaintCountsJSON);
    foreach ($results as $entry) {
        $formType = $entry['form_type'];
        $dateUpdated = strtotime($entry['time_stamp']);
        $status = $entry['Status'];

        // Check if the entry is a Customer Complaint in the year 2023
        if ($status==='Closed'&& $formType === 'Opportunity For Improvement' || $formType === 'Non Conformance' && date('Y', $dateUpdated) === date("Y")) {
            $month = date('n', $dateUpdated); // Get the month as a number (1-12)
            $complaintCounts_closed[$month - 1]++; // Subtract 1 to account for zero-based array
        }
    }

    // Convert the array of counts to a JSON format for use in JavaScript
    $complaintCountsJSON_closed = json_encode($complaintCounts_closed);

    //CC PER Month for the year 2023


    $complaintCounts_cc = array_fill(0, 12, 0); // Initialize with zeros for each month
    $complaintCounts_cc_closed  = array_fill(0, 12, 0); 
    // Loop through the query results and count complaints for each month
    foreach ($results_for_cc as $entry) {
        $formType_cc = $entry['form_type'];
        $datecreated_cc= strtotime($entry['time_stamp']);
        $status_cc = $entry['Status'];

        // Check if the entry is a Customer Complaint in the year 2023
        if ($formType_cc === 'Customer Complaints' && date('Y', $datecreated_cc) === date("Y")) {
            $month_cc = date('n', $datecreated_cc); // Get the month as a number (1-12)
            $complaintCounts_cc[$month_cc - 1]++; // Subtract 1 to account for zero-based array
        }
    }

    // Convert the array of counts to a JSON format for use in JavaScript
    $complaintCountsJSON_cc = json_encode($complaintCounts_cc);
 
//FOR CC CLOSED LINE CHART
    foreach ($results_for_cc as $entry) {
        $formType_cc = $entry['form_type'];
        $datecreated_cc= strtotime($entry['time_stamp']);
        $status_cc = $entry['Status'];

        // Check if the entry is a Customer Complaint in the year 2023
        if ($status_cc==='Closed'&& $formType_cc === 'Customer Complaints' && date('Y', $datecreated_cc) === date("Y")) {
            $month_cc = date('n', $datecreated_cc); // Get the month as a number (1-12)
            $complaintCounts_cc_closed[$month_cc - 1]++; // Subtract 1 to account for zero-based array
        }
    }

    // Convert the array of counts to a JSON format for use in JavaScript
    $complaintCountsJSON_cc_closed = json_encode($complaintCounts_cc_closed);


    //print_r($complaintCountsJSON_cc_closed);
//} catch (PDOException $e) {
 //   echo 'Connection failed: ' . $e->getMessage();
 //   exit();
//}
//COST REWORK
$rework_cost = []; // Replace this with your actual data
$itemLabels_cost = [];
$dataCost = [];

foreach ($rework as $row) {
    $dimension1 = $row['U_Dimension1'];
    $cost = $row['RoundedCost'];

    // Skip if U_Dimension1 is NULL
    if ($dimension1 === null) {
        continue;
    }

    if (!isset($dataCost[$dimension1])) {
        $dataCost[$dimension1] = 0;
    }

    $dataCost[$dimension1] += $cost;

    // Add process order to labels
    $itemLabels_cost[] = $dimension1;
}

// Sort the data array based on keys (dimension1) in ascending order
ksort($dataCost);

// Extract sorted keys and values
$itemLabelsJSON_cost = array_keys($dataCost);
$dataCostJSON_cost = array_values($dataCost);
?>

<script>



    let currentChart;
function displayChart_1() {
    // Remove the existing chart if it exists
    if (currentChart) {
        currentChart.destroy();
    }

    // Get the chart canvas element
    var ctx = document.getElementById('myChart').getContext('2d');
    Chart.register(ChartDataLabels);
    var gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'orange');
    gradient.addColorStop(1, 'orange');
    // Create the chart
    currentChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($Labels_ac); ?>,
            datasets: [{
                //label: 'Open OFI per Area caused',
                data: <?php echo json_encode($Values_ac); ?>,

                backgroundColor: gradient

            }]
        },
        options: {
            layout: layoutOptions,
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Area Caused',
                        font: {
                            weight: 'bold',
                            size: 18,

                        }

                    },
                },
                y: {
                    beginAtZero: true,
                    max: <?php echo (int)$count_ac+1; ?>

                }

            },
            plugins: {
                legend: {
                    display: false
                },

                datalabels: { // Configure the datalabels plugin
                    anchor: 'end', // Set the anchor to the center
                    align: 'top',

                    formatter: function(value) {
                        return value; // Display the data value on top of the bar
                    },

                    font: {
                        weight: 'bold',
                        size: 16
                    },

                },
                title: {
                    display: true, // Display the title
                    //text: 'Open OFI s-Area caused', // Replace with your desired title text
                    weight: 136, // Adjust the font size of the title
                    fontStyle: 'bold'
                    // You can also set the font style (e.g., 'normal', 'italic', 'bold', etc.)
                }
            },

        }
    });

    // Show the chart canvas
    document.getElementById('myChart').style.display = 'block';
    var titleDiv = document.getElementById('ChartTitle');
    titleDiv.innerHTML = "Open OFI's - Area Caused";

}
</script>