<?php include '../../../../SQL CONNECTIONS/conn.php'; ?>
<?php 
            $start_time = time()-60*60*24*7*5;
            $start_range = -5;
            $end_range = 30;
        ?>
<?php
//$item=(!empty($_POST['item'])? $_POST['item'] : 0);

// IF P EXCEPTIONS DETECTS PROCESS ORDER POST INCLUDE ALL BOM ITEMS NOT ISSUED INCLUDING THOSE IN STOCK
// OTHERWiSE PULL ALL BOM ITEMS ON ALL PROCESS ORDERS THAT ARE IN MATERIAL SHORTAGE REGARDLESS OF IF ITS ISSUED OR NOT
if (isset($_GET['po'])) {
    $clause = "WHERE [Process Order] = " . explode(',', $_GET['po'])[0];

    if (explode(',', $_GET['po'])[1] == 'OBAR') {
        $clause2_a = "AND (t5.ItmsGrpNam LIKE '%Sheet%' OR t5.ItmsGrpNam LIKE '%Bar%' OR t5.ItmsGrpNam LIKE '%Box%')";
        $clause2_b = "AND (t5.ItmsGrpNam LIKE '%Sheet%' OR t5.ItmsGrpNam LIKE '%Bar%' OR t5.ItmsGrpNam LIKE '%Box%')";
    } elseif (explode(',', $_GET['po'])[1] == 'NBAR') {
        $clause2_a = "AND t5.ItmsGrpNam NOT LIKE '%Sheet%' AND t5.ItmsGrpNam NOT LIKE '%Bar%' AND t5.ItmsGrpNam NOT LIKE '%Box%'";
        $clause2_b = "AND t5.ItmsGrpNam NOT LIKE '%Sheet%' AND t5.ItmsGrpNam NOT LIKE '%Bar%' AND t5.ItmsGrpNam NOT LIKE '%Box%'";
    } elseif (explode(',', $_GET['po'])[1] == 'NORMAL') {
        $clause2_a = "AND t2.PrcrmntMtd = 'B' AND t0.PlannedQty > (t2.ONhand - t2.IsCommited + t0.PlannedQty)  AND t1.CmpltQty < t1.PlannedQty";
        $clause2_b = "AND t2.PrcrmntMtd = 'B' AND t0.OpenQty > (t2.ONhand - t2.IsCommited + t0.OpenQty) ";
    }
} else {
    $clause = '';
    $clause2_a = "AND t2.PrcrmntMtd = 'B' AND t0.PlannedQty > (t2.ONhand - t2.IsCommited + t0.PlannedQty)  AND t1.CmpltQty < t1.PlannedQty";
    $clause2_b = "AND t2.PrcrmntMtd = 'B' AND t0.OpenQty > (t2.ONhand - t2.IsCommited + t0.OpenQty) ";
}

if(isset($_POST['item'])) {
    $sales_order=(!empty($_POST['item'])? $_POST['item'] : 0);
    $porder=(!empty($_POST['porder'])? $_POST['porder'] : 0);
    //$clause = "WHERE [Process Order] =  $item";
    
    $clause2_a = "AND t2.PrcrmntMtd = 'B' AND t0.PlannedQty > (t2.ONhand - t2.IsCommited + t0.PlannedQty)  AND t1.CmpltQty < t1.PlannedQty";
    $clause2_b = "AND t2.PrcrmntMtd = 'B' AND t0.OpenQty > (t2.ONhand - t2.IsCommited + t0.OpenQty) ";
}
?>
 
<?php

$subcontracting_results=
"SELECT 
t0.LineNum[Line Number],
t0.ItemCode[Item Code],
t0.Dscription[Item Name],
t0.Quantity[Quantity],
t1.OnHand [On Hand],
t0.Price[Price],
t0.Currency[Currency],
t0.TotalFrgn[Total In FC],
t0.LineTotal[Total],
t3.U_IIS_proPrOrder[Process Order],
t0.U_In_Sub_Con[U_In_Sub_Con],
t0.U_Est_Eng_Hours[Est Eng Time],
t0.U_Act_Eng_Time[Act Eng Time],
t0.U_Est_Prod_Hrs[Est Production Time],
t0.DelivrdQty [Delivered Qty],


FORMAT(t0.U_Promise_Date,'dd-MM-yyyy')[Promise Date],
t0.DelivrdQty,
t0.OrderedQty,
  t0.LineStatus
FROM RDR1 t0
LEFT JOIN OITM t1 ON t1.ItemCode = t0.ItemCode
LEFT JOIN ORDR t2 ON t2.DocEntry = t0.DocEntry
LEFT JOIN OWOR t3 ON t3.OriginNum = t2.DocNum AND t3.ItemCode = t0.ItemCode
WHERE t2.DocNum = $sales_order and t3.U_IIS_proPrOrder= $porder";


$getResults = $conn->prepare($subcontracting_results);
$getResults->execute();
$production_exceptions_results = $getResults->fetchAll(PDO::FETCH_BOTH);
//$json_array = array();
//var_dump($production_exceptions_results);
echo json_encode(array('data'=>$production_exceptions_results));
?>


