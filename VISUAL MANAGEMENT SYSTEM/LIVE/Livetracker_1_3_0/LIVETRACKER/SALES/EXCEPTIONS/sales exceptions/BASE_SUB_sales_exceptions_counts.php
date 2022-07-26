
<?php
    define("NO_TRANSPORT_CHARGE", 0);
    define("NO_DEL_ADD", 1);
    define("ACCOUNT_ON_HOLD", 2);
    define("NOT_CLEARED_FOR_INVOICE", 3);

    define("SE_SELF", 0);
    define("LATE_TWO_WEEKS", 1);
    define("LATE_FOUR_WEEKS", 2);
    define("OK", 3);

    include '../../../../SQL CONNECTIONS/conn.php';
    include './SQL_sales_exceptions.php';
    
    $getResults = $conn->prepare($sales_exceptions);
    $getResults->execute();
    $results = $getResults->fetchAll(PDO::FETCH_BOTH);

    $sales_exceptions_counters = array_fill(0,4,array_fill(0,4,0));

    foreach($results as $row){
        if($row["Transport Charge"] == null){
            if($row["Weeks Overdue_2"] > 0){
                $sales_exceptions_counters[NO_TRANSPORT_CHARGE][LATE_TWO_WEEKS]++;
            }
            if($row["Weeks Overdue_4"] > 0){
                $sales_exceptions_counters[NO_TRANSPORT_CHARGE][LATE_FOUR_WEEKS]++;
            }
            else{
                $sales_exceptions_counters[NO_TRANSPORT_CHARGE][OK]++;
            }
        }
        if($row["Delivery Address Complete"] != "Y"){
            if($row["Weeks Overdue_2"] > 0){
                $sales_exceptions_counters[NO_DEL_ADD][LATE_TWO_WEEKS]++;
            }
            if($row["Weeks Overdue_4"] > 0){
                $sales_exceptions_counters[NO_DEL_ADD][LATE_FOUR_WEEKS]++;
            }
            else{
                $sales_exceptions_counters[NO_DEL_ADD][OK]++;
            }
        }
        if($row["Account Status"] == "ON HOLD"){
            if($row["Weeks Overdue_2"] > 0){
                $sales_exceptions_counters[ACCOUNT_ON_HOLD][LATE_TWO_WEEKS]++;
            }
            if($row["Weeks Overdue_4"] > 0){
                $sales_exceptions_counters[ACCOUNT_ON_HOLD][LATE_FOUR_WEEKS]++;
            }
            else{
                $sales_exceptions_counters[ACCOUNT_ON_HOLD][OK]++;
            }
        }
        if($row["Cleared to Invoice"] == "No"){
            if($row["Weeks Overdue_2"] > 0){
                $sales_exceptions_counters[NOT_CLEARED_FOR_INVOICE][LATE_TWO_WEEKS]++;
            }
            if($row["Weeks Overdue_4"] > 0){
                $sales_exceptions_counters[NOT_CLEARED_FOR_INVOICE][LATE_FOUR_WEEKS]++;
            }
            else{
                $sales_exceptions_counters[NOT_CLEARED_FOR_INVOICE][OK]++;
            }
        }
    }
?>