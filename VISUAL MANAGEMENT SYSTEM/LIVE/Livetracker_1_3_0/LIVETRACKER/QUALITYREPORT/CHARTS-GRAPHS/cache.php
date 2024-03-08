<?php

//include '../../../../SQL CONNECTIONS/conn.php'; 
include './SQL_Charts.php'; 
define("DEFAULT_DATA",0);

try{
// CONNECT TO SEVER WITH PDO SQL SERVER FUNCTION
$conn = new PDO("sqlsrv:Server=KPTSVSP;Database=LEARNING_LOG","sa","SAPB1Admin");
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
$sql = get_sap_data($conn, $sql_cache, 0);
$sql_monthly = get_sap_data($conn, $sql_monthly_cache, 0);
$sql_closed_status = get_sap_data($conn, $sql_closed_status_cache, 0);
//LAST YEAR OFI
$sql_closed_status_L = get_sap_data($conn, $sql_closed_status_cache_L, 0);
//.......
$sql_closed_avg = get_sap_data($conn, $sql_closed_avg_cache, 0);
$sql_2023_cc = get_sap_data($conn, $sql_2023_cc_cache, 0);

$sql_pie = get_sap_data($conn, $sql_pie_cache, 0);

$sql_cc = get_sap_data($conn, $sql_cc_cache, 0);
$sql_closed_status_cc = get_sap_data($conn, $sql_closed_status_cc_cache, 0);
//LAST YEAR CC
$sql_closed_status_cc_L = get_sap_data($conn, $sql_closed_status_cc_cache_L, 0);
//......
$sql_closed_cc_avg = get_sap_data($conn, $sql_closed_cc_avg_cache, 0);

$sql_pie_cc = get_sap_data($conn, $sql_pie_cc_cache, 0);


$SQL_NEW = get_sap_data($conn, $SQL_NEW_cache, 0);
$SQL_NEW_L = get_sap_data($conn, $SQL_NEW_cache_L, 0);
$SQL_rework = get_sap_data($conn, $sql_qlty_results_cost, 0);


//$production_group_step_table_data = get_sap_data($conn,$tsql,0);
    file_put_contents("./CACHE/qlty_sql.json", json_encode($sql));
    file_put_contents("./CACHE/qlty_sql_monthly.json", json_encode($sql_monthly));
    file_put_contents("./CACHE/qlty_sql_closed_status.json", json_encode($sql_closed_status));

    file_put_contents("./CACHE/qlty_sql_closed_status_L.json", json_encode($sql_closed_status_L));
    


    file_put_contents("./CACHE/qlty_sql_closed_avg.json", json_encode($sql_closed_avg));
    file_put_contents("./CACHE/qlty_sql_2023_cc.json", json_encode($sql_2023_cc));
    file_put_contents("./CACHE/qlty_sql_pie.json", json_encode($sql_pie));
    file_put_contents("./CACHE/qlty_sql_cc.json", json_encode($sql_cc));
    file_put_contents("./CACHE/qlty_sql_closed_status_cc.json", json_encode($sql_closed_status_cc));
    file_put_contents("./CACHE/qlty_sql_closed_status_cc_L.json", json_encode($sql_closed_status_cc_L));


    file_put_contents("./CACHE/qlty_sql_closed_cc_avg.json", json_encode($sql_closed_cc_avg));
    file_put_contents("./CACHE/qlty_sql_pie_cc.json", json_encode($sql_pie_cc));
    file_put_contents("./CACHE/qlty_SQL_NEW.json", json_encode($SQL_NEW));
    file_put_contents("./CACHE/qlty_SQL_NEW_L.json", json_encode($SQL_NEW_L));
    file_put_contents("./CACHE/qlty_rework_cost.json", json_encode($SQL_rework));
    

    
    ?>



