
<?php
    define("MATERIAL_NOT_IN", 0);
    define("SUBCONTRACT", 1);
    define("GRATINGS", 2);
    define("NOT_PURCHASED", 3);
    define("FIXINGS", 4);
    define("FITTINGS", 5);
    define("INTEL_SUBCONTRACT", 6);
    define("INTEL_MATERIAL", 7);
    define("SHEETS", 8);
    define("TOTAL", 9);

    define("PE_SELF", 0);
    define("TWO_WEEKS", 1);
    define("FOUR_WEEKS", 2);
    define("OK", 3);

    // INCLUDE DB CONNECTION FILE AND SQL QUERY
    include '../../../../SQL CONNECTIONS/conn.php';
    include './SQL_production_exception.php';
    
    // PREPARE DB CONNECTION WITH QUERY
    $getResults = $conn->prepare($production_exceptions);
    
    // EXECUTE QUERY AND ASSIGN DATA TO RESULTS
    $getResults->execute();
    $production_exceptions_results = $getResults->fetchAll(PDO::FETCH_BOTH);

    $production_exceptions_counters = array_fill(0,10,array_fill(0,4,0));
    $total_late_p = 0;

    // EACH SAP LINEITEM (FROM QUERY)
    
    foreach($production_exceptions_results as $row){
        if($row["Type"] == "X" && $row["Customer"] != "Intel Ireland Ltd"){
            if($row["Weeks Overdue_2"] > 0){
                $total_late_p++;
                $production_exceptions_counters[NOT_PURCHASED][TWO_WEEKS]++;
            }
            if($row["Weeks Overdue_4"] > 0){
                $production_exceptions_counters[NOT_PURCHASED][FOUR_WEEKS]++;
            }
            else{
                $production_exceptions_counters[NOT_PURCHASED][OK]++;
            }
        }
        if($row["Type"] == "SC" and $row["Customer"] != "Intel Ireland Ltd"){
            if($row["Weeks Overdue_2"] > 0){
                $total_late_p++;
                $production_exceptions_counters[SUBCONTRACT][TWO_WEEKS]++;
            }
            if($row["Weeks Overdue_4"] > 0){
                $production_exceptions_counters[SUBCONTRACT][FOUR_WEEKS]++;
            }
            else{
                $production_exceptions_counters[SUBCONTRACT][OK]++;
            }
        }
        if($row["Type"] == "SH" && $row["Customer"] != "Intel Ireland Ltd"){
            if($row["Weeks Overdue_2"] > 0){
                $total_late_p++;
                $production_exceptions_counters[SHEETS][TWO_WEEKS]++;
            }
            if($row["Weeks Overdue_4"] > 0){
                $production_exceptions_counters[SHEETS][FOUR_WEEKS]++;
            }
            else{
                $production_exceptions_counters[SHEETS][OK]++;
            }
        }
        if($row["Type"] == "GR" && $row["Customer"] != "Intel Ireland Ltd"){
            if($row["Weeks Overdue_2"] > 0){
                $total_late_p++;
                $production_exceptions_counters[GRATINGS][TWO_WEEKS]++;
            }
            if($row["Weeks Overdue_4"] > 0){
                $production_exceptions_counters[GRATINGS][FOUR_WEEKS]++;
            }
            else{
                $production_exceptions_counters[GRATINGS][OK]++;
            }
        }
        if($row["Type"] == "FX" && $row["Customer"] != "Intel Ireland Ltd"){
            if($row["Weeks Overdue_2"] > 0){
                $total_late_p++;
                $production_exceptions_counters[FIXINGS][TWO_WEEKS]++;
            }
            if($row["Weeks Overdue_4"] > 0){
                $production_exceptions_counters[FIXINGS][FOUR_WEEKS]++;
            }
            else{
                $production_exceptions_counters[FIXINGS][OK]++;
            }
        }
        if($row["Type"] == "FT" && $row["Customer"] != "Intel Ireland Ltd"){
            if($row["Weeks Overdue_2"] > 0){
                $total_late_p++;
                $production_exceptions_counters[FITTINGS][TWO_WEEKS]++;
            }
            if($row["Weeks Overdue_4"] > 0){
                $production_exceptions_counters[FITTINGS][FOUR_WEEKS]++;
            }
            else{
                $production_exceptions_counters[FITTINGS][OK]++;
            }
        }
        if($row["Type"] == "N" && $row["Customer"] != "Intel Ireland Ltd"){
            if($row["Weeks Overdue_2"] > 0){
                $total_late_p++;
                $production_exceptions_counters[MATERIAL_NOT_IN][TWO_WEEKS]++;
            }
            if($row["Weeks Overdue_4"] > 0){
                $production_exceptions_counters[MATERIAL_NOT_IN][FOUR_WEEKS]++;
            }
            else{
                $production_exceptions_counters[MATERIAL_NOT_IN][OK]++;
            }
        }
        if($row["Customer"] == "Intel Ireland Ltd" && $row["Type"] == "SC"){
            if($row["Weeks Overdue_2"] > 0){
                $total_late_p++;
                $production_exceptions_counters[INTEL_SUBCONTRACT][TWO_WEEKS]++;
            }
            if($row["Weeks Overdue_4"] > 0){
                $production_exceptions_counters[INTEL_SUBCONTRACT][FOUR_WEEKS]++;
            }
            else{
                $production_exceptions_counters[INTEL_SUBCONTRACT][OK]++;
            }
        }
        if($row["Customer"] == "Intel Ireland Ltd" && $row["Type"] != "SC"){
            if($row["Weeks Overdue_2"] > 0)
            {
                $total_late_p++;
                $production_exceptions_counters[INTEL_MATERIAL][TWO_WEEKS]++;
            }
            if($row["Weeks Overdue_4"] > 0){
                $production_exceptions_counters[INTEL_MATERIAL][FOUR_WEEKS]++;
            }
            else{
                $production_exceptions_counters[INTEL_MATERIAL][OK]++;
            }
        }
    }
?>