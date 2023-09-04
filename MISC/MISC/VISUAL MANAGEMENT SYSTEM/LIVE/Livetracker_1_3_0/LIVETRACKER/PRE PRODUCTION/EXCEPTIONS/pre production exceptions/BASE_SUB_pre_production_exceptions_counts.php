<?php
    define("DRAWINGS_APPROVED", 0);
    define("AWAITING_DRAWING_APPROVAL", 1);
    define("REVISED_DRAWING_REQUIRED", 2);
    define("AWAITING_SAMPLE_APPROVAL", 3);
    define("ENGINEER_DRAWING", 4);
    define("AWAITING_FURTHER_INFORMATION", 5);
    define("CONCEPT", 6);

    define("PPE_SELF", 0);
    define("LATE", 1);
    define("OK", 3);

    // INCLUDE DB CONNECTION FILE AND SQL QUERY
    include '../../../../SQL CONNECTIONS/conn.php';
    include '../../../../PHP LIBS/PHP SETTINGS/php_settings.php';
    include './SQL_pre_production_exceptions.php';
        
    // PREPARE DB CONNECTION WITH QUERY
    $getResults = $conn->prepare($pre_production_exceptions);
    $getResults->execute();
    $pre_production_exceptions_results = $getResults->fetchAll(PDO::FETCH_BOTH);
    $pre_production_exceptions_counters = array_fill(0,7,array_fill(0,4,0));

    // EACH SAP LINEITEM (FROM QUERY)
    foreach($pre_production_exceptions_results  as $row){
        if($row["Stage"] == "1. Drawings Approved" || $row["Stage"] == "1. Drawings Approved ( Fabrication Drawings)" || $row["Stage"] == "1. Drawings Approved (Fab Drawings)")
        {
            $pre_production_exceptions_counters[DRAWINGS_APPROVED][PPE_SELF]++;
            if($row["Weeks Overdue"] > 0){
                $pre_production_exceptions_counters[DRAWINGS_APPROVED][LATE]++;
            }
            $pre_production_exceptions_counters[DRAWINGS_APPROVED][OK] = $pre_production_exceptions_counters[DRAWINGS_APPROVED][PPE_SELF] - $pre_production_exceptions_counters[DRAWINGS_APPROVED][LATE];
        }

        if($row["Stage"] == "2. Awaiting Customer Approval"){
            $pre_production_exceptions_counters[AWAITING_DRAWING_APPROVAL][PPE_SELF]++;
            if($row["Weeks Overdue"] > 0){
                $pre_production_exceptions_counters[AWAITING_DRAWING_APPROVAL][LATE]++;
            }
            $pre_production_exceptions_counters[AWAITING_DRAWING_APPROVAL][OK] = $pre_production_exceptions_counters[AWAITING_DRAWING_APPROVAL][PPE_SELF] - $pre_production_exceptions_counters[AWAITING_DRAWING_APPROVAL][LATE];
        }

        if($row["Stage"] == "3. Revised Drawing Required"){
            $pre_production_exceptions_counters[REVISED_DRAWING_REQUIRED][PPE_SELF]++;
            if($row["Weeks Overdue"] > 0){
                $pre_production_exceptions_counters[REVISED_DRAWING_REQUIRED][LATE]++;
            }
            $pre_production_exceptions_counters[REVISED_DRAWING_REQUIRED][OK] = $pre_production_exceptions_counters[REVISED_DRAWING_REQUIRED][PPE_SELF] - $pre_production_exceptions_counters[REVISED_DRAWING_REQUIRED][LATE];    
        }

        if($row["Stage"] == "4. Awaiting Sample Approval"){
            $pre_production_exceptions_counters[AWAITING_SAMPLE_APPROVAL][PPE_SELF]++;
            if($row["Weeks Overdue"] > 0){
                $pre_production_exceptions_counters[AWAITING_SAMPLE_APPROVAL][LATE]++;
            }
            $pre_production_exceptions_counters[AWAITING_SAMPLE_APPROVAL][OK] = $pre_production_exceptions_counters[AWAITING_SAMPLE_APPROVAL][PPE_SELF] - $pre_production_exceptions_counters[AWAITING_SAMPLE_APPROVAL][LATE];  
        }

        if($row["Stage"] == "5. Engineer Drawing" || $row["Stage"] == "5. Engineer Drawing (Approval Drawings)"){
            $pre_production_exceptions_counters[ENGINEER_DRAWING][PPE_SELF]++;
            if($row["Weeks Overdue"] > 0){
                $pre_production_exceptions_counters[ENGINEER_DRAWING][LATE]++;
            }
            $pre_production_exceptions_counters[ENGINEER_DRAWING][OK] = $pre_production_exceptions_counters[ENGINEER_DRAWING][PPE_SELF] - $pre_production_exceptions_counters[ENGINEER_DRAWING][LATE];    
        }

        if($row["Stage"] == "6. Awaiting Further Instruction" || $row["Stage"] == "6. Awaiting Further Instructions"){
            $pre_production_exceptions_counters[AWAITING_FURTHER_INFORMATION][PPE_SELF]++;
            if($row["Weeks Overdue"] > 0){
                $pre_production_exceptions_counters[AWAITING_FURTHER_INFORMATION][LATE]++;
            }
            $pre_production_exceptions_counters[AWAITING_FURTHER_INFORMATION][OK] = $pre_production_exceptions_counters[AWAITING_FURTHER_INFORMATION][PPE_SELF] - $pre_production_exceptions_counters[AWAITING_FURTHER_INFORMATION][LATE];    
        }
        
        if($row["Stage"] == "8. Design Concept"){
            $pre_production_exceptions_counters[CONCEPT][PPE_SELF]++;
            if($row["Weeks Overdue"] > 0){
                $pre_production_exceptions_counters[CONCEPT][LATE]++;
            }
            $pre_production_exceptions_counters[CONCEPT][OK] = $pre_production_exceptions_counters[CONCEPT][PPE_SELF] - $pre_production_exceptions_counters[CONCEPT][LATE];    
        }
    }
?>