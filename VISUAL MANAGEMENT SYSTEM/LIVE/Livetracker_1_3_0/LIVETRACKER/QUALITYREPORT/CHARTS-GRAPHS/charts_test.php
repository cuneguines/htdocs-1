<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart Page</title>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0-rc"></script>


    <link rel="stylesheet" href="./charts.css">


</head>

<body>
    <?php include './cache.php'; ?>



    <?php

    $results = json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_sql.json'), true); 
    $results_closed_avg = json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_sql_closed_avg.json'), true); 
    $results_closed = json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_sql_closed_status.json'), true); 
    //-----LAST YEAR
    $results_closed_L = json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_sql_closed_status_L.json'), true); 
    //-----
    $results_cc = json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_sql_2023_cc.json'), true); 
    $results_pie = json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_sql_pie.json'), true); 
    
    $results_for_cc= json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_sql_cc.json'), true); 
    $results_closed_cc_avg = json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_sql_closed_cc_avg.json'), true); 
    $results_closed_cc= json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_sql_closed_status_cc.json'), true);
    //----LAST YEAR------
    $results_closed_cc_L= json_decode(file_get_contents(__DIR__ . '\CACHE\qlty_sql_closed_status_cc_L.json'), true);
    //-----------
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
    $daysLeftData_L = [];
    $itemLabels = [];
    $itemLabels_L = [];
    //Area caused
    $data_ac = [];
    $data_ac_L = [];
    //Area Raised
    $data_rd = [];
    $data_rd_L = [];
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
//-----LAST YEAR CC----
$data_ac_cc_L=[];
    foreach ($results_closed_cc_L as $row) {
        $itemLabels[] = $row['ID'];
        $daysLeftData[] = $row['Days_open'];
        $area_ac_cc_L = $row['cc_area_caused'];
       
        if (!isset($data_ac_cc_L[$area_ac_cc_L])) {
            $data_ac_cc_L[$area_ac_cc_L] = 0;
        }
       
        
        $data_ac_cc_L[$area_ac_cc_L]++;
     }
$data_rd_cc_L=[];
    foreach ($results_closed_cc_L as $row) {
        $itemLabels[] = $row['ID'];
        $daysLeftData[] = $row['Days_open'];
       
        $area_rd_cc_L=$row['cc_area_raised_by'];
        if ($area_rd_cc_L!= NULL) {
       
        if (!isset($data_rd_cc_L[$area_rd_cc_L])  ) {
            $data_rd_cc_L[$area_rd_cc_L] = 0;
        }
        $data_rd_cc_L[$area_rd_cc_L]++;
      }
    }

    
    $labels_ac_cc_L= array_keys($data_ac_cc_L);
    $values_ac_cc_L= array_values($data_ac_cc_L);
    //print_r(array_keys($labels1));
    //print_r(array_values($values1));
    $labels_rd_cc_L= array_keys($data_rd_cc_L);
    $values_rd_cc_L= array_values($data_rd_cc_L);



    $combinedData_ac_cc_L = array_combine($labels_ac_cc_L, $values_ac_cc_L);
    $combinedData_rd_cc_L= array_combine($labels_rd_cc_L, $values_rd_cc_L);


// Sort the combined data array in descending order based on values
arsort($combinedData_ac_cc_L);
arsort($combinedData_rd_cc_L);
$count_rd_cc_L=is_array($combinedData_rd_cc_L)  && count($combinedData_rd_cc_L) > 0 ? reset($combinedData_rd_cc_L) : 0;
$count_ac_cc_L=is_array($combinedData_ac_cc_L) && count($combinedData_ac_cc_L) > 0 ? reset($combinedData_ac_cc_L) : 0;

// Extract sorted labels and values back into separate arrays
$Labels_ac_cc_L = array_keys($combinedData_ac_cc_L);
$Values_ac_cc_L = array_values($combinedData_ac_cc_L);
$Labels_rd_cc_L= array_keys($combinedData_rd_cc_L);
$Values_rd_cc_L= array_values($combinedData_rd_cc_L);
//-------------


      $labels_ac_cc= array_keys($data_ac_cc);
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


//  -------------------THIS YEAR-------------------------
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

     //  -------------------LAST  YEAR-------------------------
     foreach ($results_closed_L as $row) {
        $itemLabels_L[] = $row['ID'];
        $daysLeftData_L[] = $row['Days_open'];
        $area_ac_L = $row['nc_area_caused'];
       
        if (!isset($data_ac_L[$area_ac_L])) {
            $data_ac_L[$area_ac_L] = 0;
        }
       
        
        $data_ac_L[$area_ac_L]++;
     }




    foreach ($results_closed_L as $row) {
        $itemLabels[] = $row['ID'];
        $daysLeftData[] = $row['Days_open'];
       
        $area_rd_L=$row['area_raised_'];
       
        if (!isset($data_rd_L[$area_rd_L])) {
            $data_rd_L[$area_rd_L] = 0;
        }
        $data_rd_L[$area_rd_L]++;
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


    $labels_rd = array_keys($data_rd);
    $values_rd = array_values($data_rd);


    //print_r($labels_ac);
    //print_r($labels_r);
//LAST YEAR
    $labels_ac_L = array_keys($data_ac_L);
    $values_ac_L = array_values($data_ac_L);

    $labels_rd_L= array_keys($data_rd_L);
    $values_rd_L = array_values($data_rd_L);
    //print_r(array_keys($labels1));
    //print_r(array_values($values1)););


    $combinedData_ac = array_combine($labels_ac, $values_ac);

    $combinedData_ac_L = array_combine($labels_ac_L, $values_ac_L);


    $combinedData_rd= array_combine($labels_rd, $values_rd);
    $combinedData_rd_L= array_combine($labels_rd_L, $values_rd_L);
   
// Sort the combined data array in descending order based on values
arsort($combinedData_ac);
arsort($combinedData_ac_L);
arsort($combinedData_rd);
arsort($combinedData_rd_L);

$count_rd = is_array($combinedData_rd) && count($combinedData_rd) > 0 ? reset($combinedData_rd) : 0;
$count_rd_L = is_array($combinedData_rd_L) && count($combinedData_rd_L) > 0 ? reset($combinedData_rd_L) : 0;
//print_r($count_rd);
$count_ac=is_array($combinedData_ac) && count($combinedData_ac) > 0 ? reset($combinedData_ac) : 0;
$count_ac_L=is_array($combinedData_ac_L) && count($combinedData_ac_L) > 0 ? reset($combinedData_ac_L) : 0;

//print_r($count_ac);
// Extract sorted labels and values back into separate arrays
$Labels_ac = array_keys($combinedData_ac);
$Values_ac = array_values($combinedData_ac);
//Last Year
$Labels_ac_L = array_keys($combinedData_ac_L);
$Values_ac_L = array_values($combinedData_ac_L);

$Labels_rd = array_keys($combinedData_rd);
$Values_rd = array_values($combinedData_rd);

$Labels_rd_L = array_keys($combinedData_rd_L);
$Values_rd_L = array_values($combinedData_rd_L);


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



    <div class="sidebar">
        <!-- Create links on the left -->
        <h2>Opportunity For Improvement</h2>
        <ul>
            <li><a href="#" style="text-decoration: underline;" class="nav-link" onclick="displayThisYearData_1()">Open
                    OFIs's-
                    Area Caused</a></li>
            <button class="year-button" onclick="displayLastYearData_1()">Last Year</button>
            <button class="year-button" onclick="displayThisYearData_1()">Current Year</button>
            </li>
            <li><a href="#" style="text-decoration: underline;" class="nav-link" onclick="displayThisYearData_8()">Open
                    OFI's
                    -Area Raised </a>
            </li>
            <button class="year-button" onclick="displayLastYearData_8()">Last Year</button>
            <button class="year-button" onclick="displayThisYearData_8()">Current Year</button>
            <li><a href="#" style="text-decoration: underline;" class="nav-link"
                    onclick="displayChart_2()">Open/Closed</a></li>

            <button class="year-button" onclick="displayLastYearData_2()">Last Year</button>
            <button class="year-button" onclick="displayChart_2()">Current Year</button>
            <li><a href="#" style="text-decoration: underline;" class="nav-link" onclick="displayChart_3()">Average
                    Response Time</a>
            </li>

            <button class="year-button" onclick="displayLastYearData_3()">Last Year</button>
            <button class="year-button" onclick="displayChart_3()">Current Year</button>

            <li><a href="#" style="text-decoration: underline;" class="nav-link" onclick="displayChart_5()">Cost Per
                    Business Unit</a>

            </li>

            <button class="year-button" onclick="displayLastYearData_5()">Last Year</button>
            <button class="year-button" onclick="displayChart_5()">Current Year</button>
            <li><a href="#" style="text-decoration: underline;" class="nav-link" onclick="displayChart_6()">OFI Monthly
                    Overview
                    <?php echo date("Y");?></a></li>
            <button class="year-button" onclick="displayLastYearData_5()">Last Year</button>
            <button class="year-button" onclick="displayChart_6()">Current Year</button>

        </ul>


        <h2>Customer Complaints</h2>
        <ul>

            <li><a href="#" style="text-decoration: underline;" class="nav-link" onclick="displayChart_9()">Open
                    CC's-Area
                    Caused</a></li>
            <li><a href="#" style="text-decoration: underline;" class="nav-link" onclick="displayChart_10()">Open
                    CC's-Area Raised</a></li>
            <li><a href="#" style="text-decoration: underline;" class="nav-link"
                    onclick="displayChart_11()">Open/Closed</a></li>
            <li><a href="#" style="text-decoration: underline;" class="nav-link" onclick="displayChart_12()">Average
                    Response Time</a>
            <li><a href="#" style="text-decoration: underline;" class="nav-link" onclick="displayChart_13()">CC Monthly
                    Overview
                    <?php echo date("Y");?></a></li>
            <!--<li><a href="#" onclick="displayChart_2()">Open/Closed</a></li>
            <li><a href="#" onclick="displayChart_3()">Average Response Time</a></li>
            <li><a href="#" onclick="displayChart_4()">Pie Charts</a></li> -->
        </ul>
        <h2>Other</h2>
        <ul>
            <li><a href="#" style="text-decoration: underline;" class="nav-link" onclick="displayChart_4()">Issues per
                    Product Type </a></li>
        </ul>




        <button class="fill red medium wtext" style="box-shadow: -2px 0px 8px 0px #607D8B;width:70%;position:sticky;left:0;
                                        background: linear-gradient(100deg,#009688, #8BC34A );border-radius:30px;height:7%;    margin-left: -25%;
    margin-top: 30%;" onclick="spinAndReload(this)">UPDATE</button>
    </div>
    <div class="chart-container">



        <!-- Create a canvas for the chart -->
        <div id="ChartTitle"></div>
        <canvas id="myChart" width="500" height="400"></canvas>

    </div>
    <script>
    var links = document.querySelectorAll(".nav-link");
    const layoutOptions = {
        padding: {
            top: 25 // Add 30 pixels of padding to top of chart.
        }
    };
    links.forEach(function(link) {
        link.addEventListener("click", function() {
            // Remove the 'active' class from all links
            links.forEach(function(link) {
                link.classList.remove("active");
            });

            // Add the 'active' class to the clicked link
            this.classList.add("active");
        });
    });

    function spinAndReload(button) {
        // Add a highlighted style to the button
        button.style.background = 'linear-gradient(100deg, #E91E63, #F06292)';
        button.disabled = true;
        button.innerHTML += '<span class="dot-dot-dot"></span>';
        // Refresh cache.php in the background
        fetch('./cache.php', {
                cache: 'reload'
            })
            .then(response => {
                // Success message can be logged here
                console.log('Cache refreshed successfully');
                button.style.background = 'linear-gradient(100deg, #009688, #8BC34A)';
                button.disabled = false;
                location.reload();
            })
            .catch(error => {
                // Error message can be logged here
                console.error('Error refreshing cache: ', error);
                button.style.background = 'linear-gradient(100deg, #009688, #8BC34A)';
                button.disabled = false;
            });
    }
    // Use passive: false to ensure preventDefault works

    let currentChart;
    // Function to display a chart based on the selected chart type


    function displayLastYearData_1() {
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
                labels: <?php echo json_encode($Labels_ac_L); ?>,
                datasets: [{
                    //label: 'Open OFI per Area caused',
                    data: <?php echo json_encode($Values_ac_L); ?>,

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
                        max: <?php echo (int)$count_ac_L+1; ?>

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

    function displayThisYearData_1() {
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

    function displayThisYearData_8() {
        // Remove the existing chart if it exists
        if (currentChart) {
            currentChart.destroy();
        }

        // Get the chart canvas element
        var ctx = document.getElementById('myChart').getContext('2d');
        var gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'orange');
        gradient.addColorStop(1, 'orange');
        // Create the chart
        currentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($Labels_rd); ?>,
                datasets: [{
                    //label: 'Open OFIs-Area Raised',
                    data: <?php echo json_encode($Values_rd); ?>,
                    backgroundColor: gradient
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Area Raised',
                            font: {
                                weight: 'bold',
                                size: 18,

                            }

                        },
                    },
                    y: {
                        beginAtZero: true,
                        max: <?php echo (int)$count_rd+1; ?>,
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
                        font: {
                            weight: 'bold',
                            size: 16

                        },

                        formatter: function(value) {
                            return value; // Display the data value on top of the bar
                        }
                    },
                    title: {
                        display: true, // Display the title
                        // text: 'Open OFIs-Area Raised', // Replace with your desired title text
                        fontSize: 18, // Adjust the font size of the title
                        fontStyle: 'bold' // You can also set the font style (e.g., 'normal', 'italic', 'bold', etc.)
                    }
                },

            }
        });
        document.getElementById('myChart').style.display = 'block';
        // Show the chart canvas
        var titleDiv = document.getElementById('ChartTitle');
        titleDiv.innerHTML = "Open OFI's - Area Raised";

    }

    function displayLastYearData_8() {
        // Remove the existing chart if it exists
        if (currentChart) {
            currentChart.destroy();
        }

        // Get the chart canvas element
        var ctx = document.getElementById('myChart').getContext('2d');
        var gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'orange');
        gradient.addColorStop(1, 'orange');
        // Create the chart
        currentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($Labels_rd_L); ?>,
                datasets: [{
                    //label: 'Open OFIs-Area Raised',
                    data: <?php echo json_encode($Values_rd_L); ?>,
                    backgroundColor: gradient
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Area Raised',
                            font: {
                                weight: 'bold',
                                size: 18,

                            }

                        },
                    },
                    y: {
                        beginAtZero: true,
                        max: <?php echo (int)$count_rd_L+1; ?>,
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
                        font: {
                            weight: 'bold',
                            size: 16

                        },

                        formatter: function(value) {
                            return value; // Display the data value on top of the bar
                        }
                    },
                    title: {
                        display: true, // Display the title
                        // text: 'Open OFIs-Area Raised', // Replace with your desired title text
                        fontSize: 18, // Adjust the font size of the title
                        fontStyle: 'bold' // You can also set the font style (e.g., 'normal', 'italic', 'bold', etc.)
                    }
                },

            }
        });
        document.getElementById('myChart').style.display = 'block';
        // Show the chart canvas
        var titleDiv = document.getElementById('ChartTitle');
        titleDiv.innerHTML = "Open OFI's - Area Raised";

    }

    function displayChart_2() {
        // Remove the existing chart if it exists
        if (currentChart) {
            currentChart.destroy();
        }

        // Retrieve the data from PHP
        var statusLabels = <?php echo $statusLabelsJSON; ?>;
        var statusData = <?php echo $statusDataJSON; ?>;
        // Filter out data that is zero
        var filteredStatusData = statusData.filter(function(value) {
            return value > 0;
        });

        // Filter out corresponding labels
        var filteredStatusLabels = statusLabels.filter(function(_, index) {
            return statusData[index] > 0;
        });
        // Get the chart canvas element
        var ctx = document.getElementById('myChart').getContext('2d');

        // Create the chart with the datalabels plugin
        currentChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: filteredStatusLabels,
                datasets: [{
                    data: filteredStatusData,
                    backgroundColor: [
                        'red',
                        'lightgreen',
                        'lightblue'
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

                    datalabels: { // Add the datalabels configuration
                        formatter: (value, context) => {
                            return value; // Display the count as the label
                        },
                        color: 'white',
                        font: {
                            weight: 'bold',
                            size: 28,
                            fontColor: 'white'
                        },
                        // Customize label color
                        anchor: 'center', // Position the label on the end of the slice
                        align: 'center', // Align the label to the start of the slice
                        offset: 0
                        // Adjust the label's position from the slice
                    },
                    title: {
                        display: true, // Display the title
                        // text: 'Open/Closed OFI (2023)', // Replace with your desired title text
                        fontSize: 18, // Adjust the font size of the title
                        fontStyle: 'bold' // You can also set the font style (e.g., 'normal', 'italic', 'bold', etc.)
                    }
                },

            }
        });
        //ctx.canvas.height = 1300;
        // Show the chart canvas
        document.getElementById('myChart').style.display = 'block';
        var titleDiv = document.getElementById('ChartTitle');
        titleDiv.innerHTML = "Open/Closed OFI's";

    }


    function displayChart_3() {
        // Remove the existing chart if it exists
        if (currentChart) {
            currentChart.destroy();
        }

        // Get the chart canvas element
        var ctx = document.getElementById('myChart').getContext('2d');
        var gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'grey');
        gradient.addColorStop(1, 'lightblue');
        // Create the chart
        currentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($data3['labels']); ?>,
                datasets: [{
                    //label: 'Average Response Time (days)',
                    data: <?php echo json_encode($data3['values']); ?>,
                    backgroundColor: gradient,

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
                            text: 'Days',
                            font: {
                                weight: 'bold',
                                size: 18,

                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Owner',
                            font: {
                                weight: 'bold',
                                size: 18,

                            }

                        },
                    },
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
                        },
                        font: {
                            weight: 'bold',
                            size: 16
                        },
                    },
                    title: {
                        display: true, // Display the title
                        //  text: 'Evaluating Response Times for Each Owner', // Replace with your desired title text
                        fontSize: 18, // Adjust the font size of the title
                        fontStyle: 'bold' // You can also set the font style (e.g., 'normal', 'italic', 'bold', etc.)
                    }
                },

            }
        });
        //ctx.canvas.height = 1300;
        // Show the chart canvas
        document.getElementById('myChart').style.display = 'block';
        var titleDiv = document.getElementById('ChartTitle');
        titleDiv.innerHTML = "Average Response Times Per Owner";

    }

    function displayChart_4() {

        // Remove the existing chart if it exists
        if (currentChart) {
            currentChart.destroy();
        }
        var dummyData = {
            label: 'Dummy Data',
            data: [0], // Set the value to 0
            backgroundColor: 'rgba(0, 0, 0, 0)', // Make it transparent
            borderColor: gradient, // Make it transparent
            borderWidth: 0 // No border
        };
        var ctx = document.getElementById('myChart').getContext('2d');

        var gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'orange');
        gradient.addColorStop(1, 'orange');
        Chart.register(ChartDataLabels);
        currentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_keys($pg2Data)); ?>,
                datasets: [{
                    dummyData,
                    //label: 'Number of Issues',
                    data: <?php echo json_encode(array_values($pg2Data)); ?>,
                    backgroundColor: gradient,

                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Product Type',
                            font: {
                                weight: 'bold',
                                size: 18,

                            }

                        },

                        min: 0,
                        //offset:true// Set the minimum value for the x-axis to 0
                    },
                    y: {
                        min: 0,
                        stepSize: 0
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
                        },
                        font: {
                            weight: 'bold',
                            size: 16
                        },
                    },
                    title: {
                        display: true, // Display the title
                        // text: 'Issues from Each Product Group', // Replace with your desired title text
                        fontSize: 18, // Adjust the font size of the title
                        fontStyle: 'bold' // You can also set the font style (e.g., 'normal', 'italic', 'bold', etc.)
                    }
                },

            }
        });
        document.getElementById('myChart').style.display = 'block';
        var titleDiv = document.getElementById('ChartTitle');
        titleDiv.innerHTML = "Issues Per Product Type";

    }



    function displayChart_5() {
        // Your data
        if (currentChart) {
            currentChart.destroy();
        }

        var data_labels = <?php echo json_encode($itemLabelsJSON_cost) ; ?>;
        var data_cost = <?php echo json_encode($dataCostJSON_cost ); ?>;

        // Create a bar chart
        var ctx = document.getElementById('myChart').getContext('2d');
        var gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'orange');
        gradient.addColorStop(1, 'orange');
        Chart.register(ChartDataLabels);
        currentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data_labels,
                datasets: [{
                    label: 'Cost',
                    data: data_cost,

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
                            text: 'Business',
                            font: {
                                weight: 'bold',
                                size: 18,

                            }

                        },
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

                    font: {
                        weight: 'bold',
                        size: 16
                    },
                    datalabels: { // Configure the datalabels plugin
                        anchor: 'end',
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
                        //  text: 'Business Unit Expenditure Analysis', // Replace with your desired title text
                        fontSize: 18, // Adjust the font size of the title
                        fontStyle: 'bold' // You can also set the font style (e.g., 'normal', 'italic', 'bold', etc.)
                    }
                },

            }


        });
        document.getElementById('myChart').style.display = 'block';
        var titleDiv = document.getElementById('ChartTitle');
        titleDiv.innerHTML = "Costs Per Business Unit";

    }


    function displayChart_6() {

        if (currentChart) {
            currentChart.destroy();
        }

        var ctx = document.getElementById('myChart').getContext('2d');
        var gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, '#f790a7');
        gradient.addColorStop(1, '#f790a7');
        var gradient_1 = ctx.createLinearGradient(0, 0, 0, 400);
        gradient_1.addColorStop(0, 'rgb(3,244,235,0.5)');
        gradient_1.addColorStop(1, 'rgb(3,244,235,0.5)');
        Chart.register(ChartDataLabels);
        // Your data (you can replace this with your data)
        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September",
            "October",
            "November", "December"
        ];
        var data = <?php echo $complaintCountsJSON; ?>;
        var data_closed = <?php echo $complaintCountsJSON_closed; ?>;
        console.log(data);
        console.log(data_closed);
        // Create the chart
        currentChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                        label: 'OFI closed',
                        data: data_closed,
                        backgroundColor: 'rgb(3,244,235,0.4)',
                        borderColor: gradient_1,
                        fill: true,
                        borderWidth: 1
                    },
                    {
                        label: 'OFI Raised',
                        data: data,
                        backgroundColor: gradient,
                        borderColor: gradient,
                        fill: true,
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        max: 30,
                        beginAtZero: true,
                        stepSize: 1
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month',
                            font: {
                                weight: 'bold',
                                size: 18,

                            }

                        },
                    },
                },
                plugins: {
                    legend: {
                        display: true // Hide the legend
                    },
                    font: {
                        weight: 'bold',
                        size: 16
                    },
                    datalabels: { // Configure the datalabels plugin
                        anchor: 'end',
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
                        //text: 'Monthly OFI Raised/Closed Overview', // Replace with your desired title text
                        fontSize: 18, // Adjust the font size of the title
                        fontStyle: 'bold' // You can also set the font style (e.g., 'normal', 'italic', 'bold', etc.)
                    }
                },

            }
        });
        document.getElementById('myChart').style.display = 'block';
        var titleDiv = document.getElementById('ChartTitle');
        titleDiv.innerHTML = "OFI Monthly Overview";


    }


    function displayChart_9() {
        // Remove the existing chart if it exists
        if (currentChart) {
            currentChart.destroy();
        }

        // Get the chart canvas element
        var ctx = document.getElementById('myChart').getContext('2d');
        var gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'orange');
        gradient.addColorStop(1, 'orange');
        Chart.register(ChartDataLabels);
        // Create the chart
        currentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($Labels_ac_cc); ?>,
                datasets: [{
                    label: 'Open Occurrences of CC per Area caused',
                    data: <?php echo json_encode($Values_ac_cc); ?>,
                    backgroundColor: gradient
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: <?php echo (int)$count_ac_cc+1; ?>,
                        stepSize: 1
                    },
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
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    font: {
                        weight: 'bold',
                        size: 16
                    },
                    datalabels: { // Configure the datalabels plugin
                        anchor: 'end',
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
                        //text: 'Open Occurrences of CC per Area caused', // Replace with your desired title text
                        fontSize: 18, // Adjust the font size of the title
                        fontStyle: 'bold' // You can also set the font style (e.g., 'normal', 'italic', 'bold', etc.)
                    }
                },

            }
        });
        document.getElementById('myChart').style.display = 'block';
        var titleDiv = document.getElementById('ChartTitle');
        titleDiv.innerHTML = "Open CC's-Area Caused";
        // Show the chart canvas

    }

    function displayChart_10() {
        // Remove the existing chart if it exists
        if (currentChart) {
            currentChart.destroy();
        }

        // Get the chart canvas element
        var ctx = document.getElementById('myChart').getContext('2d');
        var gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'orange');
        gradient.addColorStop(1, 'orange');
        Chart.register(ChartDataLabels);
        // Create the chart
        currentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($Labels_rd_cc); ?>,
                datasets: [{
                    // label: 'Open Occurrences of CC per Area Raised',
                    data: <?php echo json_encode($Values_rd_cc); ?>,
                    backgroundColor: gradient
                }]
            },
            options: {
                layout: layoutOptions,
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: <?php echo (int)$count_rd_cc+1; ?>,
                        stepSize: 1
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Area Raised',
                            font: {
                                weight: 'bold',
                                size: 18,

                            }

                        },
                    },
                },
                plugins: {
                    legend: {
                        display: false // Hide the legend
                    },
                    font: {
                        weight: 'bold',
                        size: 16
                    },
                    datalabels: { // Configure the datalabels plugin
                        anchor: 'end',
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
                        display: false, // Display the title
                        //text: 'Open Occurrences of CC per Area Raised', // Replace with your desired title text
                        fontSize: 18, // Adjust the font size of the title
                        fontStyle: 'bold' // You can also set the font style (e.g., 'normal', 'italic', 'bold', etc.)
                    }
                },

            }
        });
        document.getElementById('myChart').style.display = 'block';
        var titleDiv = document.getElementById('ChartTitle');
        titleDiv.innerHTML = "Open CC's- Area Raised";
        // Show the chart canvas

    }

    function displayChart_11() {
        // Remove the existing chart if it exists
        if (currentChart) {
            currentChart.destroy();
        }

        // Retrieve the data from PHP
        var statusLabels = <?php echo $statusLabelsJSON_cc; ?>;
        var statusData = <?php echo $statusDataJSON_cc; ?>;
        // Filter out data that is greater than zero
        var filteredStatusData = statusData.filter(function(value) {
            return value > 0;
        });

        // Filter out corresponding labels
        var filteredStatusLabels = statusLabels.filter(function(_, index) {
            return statusData[index] > 0;
        });
        // Get the chart canvas element
        var ctx = document.getElementById('myChart').getContext('2d');

        Chart.register(ChartDataLabels);
        // Create the chart with the datalabels plugin
        currentChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: filteredStatusLabels,
                datasets: [{
                    data: filteredStatusData,
                    backgroundColor: [
                        'red',
                        'lightgreen',
                        'lightblue'
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
                layout: layoutOptions,
                responsive: true,
                maintainAspectRatio: false,
                plugins: {

                    datalabels: { // Add the datalabels configuration
                        formatter: (value, context) => {
                            return value; // Display the count as the label
                        },
                        color: 'white',
                        font: {
                            weight: 'bold',
                            size: 28,
                            fontColor: 'white'
                        },
                        anchor: 'center', // Position the label on the end of the slice
                        align: 'center', // Align the label to the start of the slice
                        offset: 0
                    },
                    title: {
                        display: true, // Display the title
                        //text: 'Open/Closed CC(2023)', // Replace with your desired title text
                        fontSize: 18, // Adjust the font size of the title
                        fontStyle: 'bold' // You can also set the font style (e.g., 'normal', 'italic', 'bold', etc.)
                    }
                },

            }
        });
        //ctx.canvas.height = 1300;
        // Show the chart canvas
        document.getElementById('myChart').style.display = 'block';
        var titleDiv = document.getElementById('ChartTitle');
        titleDiv.innerHTML = "Open/Closed CC's";

    }

    function displayChart_12() {
        // Remove the existing chart if it exists
        if (currentChart) {
            currentChart.destroy();
        }

        // Get the chart canvas element
        var ctx = document.getElementById('myChart').getContext('2d');
        var gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'grey');
        gradient.addColorStop(1, 'lightblue');
        Chart.register(ChartDataLabels);
        // Create the chart
        currentChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($data_12['labels']); ?>,
                datasets: [{
                    label: 'Average Response Time (days)',
                    data: <?php echo json_encode($data_12['values']); ?>,
                    backgroundColor: gradient,
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: false,

                        title: {
                            display: true,
                            text: 'Days',
                            font: {
                                weight: 'bold',
                                size: 18,

                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Owner',
                            font: {
                                weight: 'bold',
                                size: 18,

                            }

                        },
                    },
                },
                plugins: {
                    legend: {
                        display: false // Hide the legend
                    },
                    font: {
                        weight: 'bold',
                        size: 16
                    },
                    datalabels: { // Configure the datalabels plugin
                        anchor: 'end',
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
                        // text: 'Evaluating Response Times for Each Owner', // Replace with your desired title text
                        fontSize: 18, // Adjust the font size of the title
                        fontStyle: 'bold' // You can also set the font style (e.g., 'normal', 'italic', 'bold', etc.)
                    }
                },


            }
        });
        //ctx.canvas.height = 1300;
        // Show the chart canvas
        document.getElementById('myChart').style.display = 'block';
        var titleDiv = document.getElementById('ChartTitle');
        titleDiv.innerHTML = "Average Response Times Per Owner";

    }

    function displayChart_13() {

        if (currentChart) {
            currentChart.destroy();
        }

        var ctx = document.getElementById('myChart').getContext('2d');
        var gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'orange');
        gradient.addColorStop(1, 'orange');
        var gradient_1 = ctx.createLinearGradient(0, 0, 0, 400);
        gradient_1.addColorStop(0, 'grey');
        gradient_1.addColorStop(1, 'grey');
        Chart.register(ChartDataLabels);
        // Your data (you can replace this with your data)
        var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September",
            "October",
            "November", "December"
        ];
        var data = <?php echo $complaintCountsJSON_cc; ?>;
        var data_closed = <?php echo $complaintCountsJSON_cc_closed; ?>;
        console.log(data);
        console.log(data_closed);

        // Create the chart
        currentChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'CC Closed',
                    data: data_closed,
                    backgroundColor: gradient,
                    borderColor: gradient,
                    fill: true,
                    borderWidth: 1
                }, {
                    label: 'CC Raised',
                    data: data,
                    backgroundColor: gradient_1, // You can customize the color
                    fill: true,
                    borderColor: gradient_1, // You can customize the color
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,

                maintainAspectRatio: false,
                scales: {

                    y: {
                        beginAtZero: true,
                        max: 30,
                        stepSize: 1
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month',
                            font: {
                                weight: 'bold',
                                size: 18,

                            }

                        },
                    },
                },
                plugins: {

                    font: {
                        weight: 'bold',
                        size: 16
                    },
                    datalabels: { // Configure the datalabels plugin
                        anchor: 'end',
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
                        //text: 'Monthly CC Raised/Closed Overview', // Replace with your desired title text
                        fontSize: 18, // Adjust the font size of the title
                        fontStyle: 'bold' // You can also set the font style (e.g., 'normal', 'italic', 'bold', etc.)
                    }
                },

            }
        });
        document.getElementById('myChart').style.display = 'block';
        var titleDiv = document.getElementById('ChartTitle');
        titleDiv.innerHTML = "CC Monthly Overview";

    }
    </script>