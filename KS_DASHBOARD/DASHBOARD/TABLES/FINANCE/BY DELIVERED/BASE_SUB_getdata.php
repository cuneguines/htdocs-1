<?php
    // IMPORT TIME LAST SAVED OF DATA
    //$json_last_updated_time = json_decode(file_get_contents(__DIR__.'\CACHED\data_last_updated.json'),true);

    // FIND CURRENT TIME
    $current_time = getdate()[0];
  
    // FOR PASSTHROUGH ONLY NOT USED IN THIS FILE
    $id = $_GET['ID'];
    $drilldown_conditions = explode(',', $id);

    include '../../../../SQL/CONNECTIONS/conn.php';
    include './SQL_filter_by_delivered_finance_table.php';

    // EXECUTE QUERIES
    $getResults = $conn->prepare($delivered_table_sql);                                  
    $getResults->execute();
    $delivered_table_data = $getResults->fetchAll(PDO::FETCH_BOTH);

    // ECODE AND SAVE ALL JSON FORMATTED ARRAYS AS JSON FILES
    file_put_contents("CACHED/data_last_updated.json", $current_time);
    file_put_contents("CACHED/delivered_table_data.json", json_encode($delivered_table_data, JSON_NUMERIC_CHECK)); 

    header('Location:BASE_list_by_delivered.php?ID='.$drilldown_conditions[0].','.$drilldown_conditions[1].','.$drilldown_conditions[2]);
?>