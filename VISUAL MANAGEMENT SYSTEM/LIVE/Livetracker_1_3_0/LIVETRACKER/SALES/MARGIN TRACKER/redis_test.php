<?php

// Include the Redis library
require "vendor/autoload.php";


// Redis configuration
$redis = new Predis\Client();
$redis->connect('127.0.0.1', 6379); // Replace with your Redis server details

// Include the SQL_Margin_tracker.php file
include './SQL_Margin_tracker.php'; 

define("DEFAULT_DATA",0);

try {
    // Connect to the SQL Server with PDO
    $conn = new PDO("sqlsrv:Server=KPTSVSP;Database=KENTSTAINLESS","sa","SAPB1Admin");
    // Set the error mode to throw exceptions
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $e) {
    // Report any errors
    die(print_r($e->getMessage()));
}

function get_sap_data($connection, $sql_query, $rtype) {
    $getResults = $connection->prepare($sql_query);                                  
    $getResults->execute();

    switch ($rtype) {
        case 0: return $getResults->fetchAll(PDO::FETCH_BOTH);
        case 1: return $getResults->fetchAll(PDO::FETCH_NUM)[0][0];
        case 2: return $getResults->fetchAll(PDO::FETCH_ASSOC)[0];
    }
}

// Check if the data is available in the Redis cache
if (!$redis->exists('sales_margin_data')) {
    // If not, fetch the data from the SQL server
    $results = get_sap_data($conn, $margin_tracker, 0);
    // Store the data in the Redis cache with an expiration time
    $redis->set('sales_margin_data', json_encode($results));
    $redis->expire('sales_margin_data', 3600); // 3600 seconds = 1 hour
} else {
    // If the data is in the cache, retrieve it from Redis
    $results = json_decode($redis->get('sales_margin_data'), true);
}

// Close the connection to the SQL server
$conn = null;

// Save the data in a file if needed
file_put_contents("CACHE/salesmargin.json", json_encode($results));
?>
