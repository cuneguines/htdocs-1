<?php

// Create an associative array representing the JSON data
$data = [
    'message' => 'Hello from Laravel!',
    'status' => 'success',
];

// Encode the array as JSON
$jsonData = json_encode($data);

// Set the appropriate headers for JSON response
header('Content-Type: application/json');

// Output the JSON data
echo $jsonData;
