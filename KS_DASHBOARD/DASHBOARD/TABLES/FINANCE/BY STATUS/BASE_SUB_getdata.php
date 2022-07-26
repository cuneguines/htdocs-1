<?php
    // IMPORT TIME LAST SAVED OF DATA
    //$json_last_updated_time = json_decode(file_get_contents(__DIR__.'\CACHED\data_last_updated.json'),true);

    // FIND CURRENT TIME
    $current_time = date(time());
  
    // FOR PASSTHROUGH ONLY NOT USED IN THIS FILE
    $id = $_GET['ID'];
    $drilldown_conditions = explode(',', $id);

    include '../../../../SQL/CONNECTIONS/conn.php';
    include './SQL_filter_by_status_finance_table.php';

    // EXECUTE QUERIES
    $getResults = $conn->prepare($status_table_sql);                                  
    $getResults->execute();
    $status_table_data = $getResults->fetchAll(PDO::FETCH_BOTH);

    // ECODE AND SAVE ALL JSON FORMATTED ARRAYS AS JSON FILES
    file_put_contents("CACHED/data_last_updated.json", $current_time);
    file_put_contents("CACHED/status_table_data.json", json_encode($status_table_data, JSON_NUMERIC_CHECK));

    header('Location:BASE_list_by_status.php?ID='.$drilldown_conditions[0].','.$drilldown_conditions[1].','.$drilldown_conditions[2]);
?>