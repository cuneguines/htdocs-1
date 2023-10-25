<?php

//include '../../../../SQL CONNECTIONS/conn.php'; 
include './SQL_Margin_tracker.php'; 
define("DEFAULT_DATA",0);

try{
// CONNECT TO SEVER WITH PDO SQL SERVER FUNCTION
$conn = new PDO("sqlsrv:Server=KPTSVSP;Database=KENTSTAINLESS","sa","SAPB1Admin");
// CREATE QUERY EXECUTION FUNCTION
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e){
// REPORT ERROR
die(print_r($e->getMessage()));
}



function get_sap_data($connection, $sql_query, $rtype){
$getResults = $connection->prepare($sql_query);                                  
$getResults->execute();

switch ($rtype){
    case 0: return $getResults->fetchAll(PDO::FETCH_BOTH);
    case 1: return $getResults->fetchAll(PDO::FETCH_NUM)[0][0];
    case 2: return $getResults->fetchAll(PDO::FETCH_ASSOC)[0];
}
}
$results = get_sap_data($conn, $margin_tracker, 0);
//$production_group_step_table_data = get_sap_data($conn,$tsql,0);
    file_put_contents("CACHE/salesmargin.json", json_encode($results));?>