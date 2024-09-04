<?php
try {
    // CONNECT TO SERVER WITH PDO SQL SERVER FUNCTION
    $conn = new PDO("sqlsrv:Server=KPTSVSP;Database=KENTSTAINLESS", "sa", "SAPB1Admin");
    // CREATE QUERY EXECUTION FUNCTION
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    // REPORT ERROR
    die(print_r($e->getMessage()));
}

// Retrieve the week number from POST data
$weekNumber = isset($_POST['weekNumber']) ? intval($_POST['weekNumber']) : 0;

try {
    // SQL query with the passed week number
    $results_operator_entries = "
    select YEAR(t0.created) [Year], datepart(iso_week,t0.created) [Week], 
 FORMAT(t0.created, 'MM/dd/yyyy') AS created,
 t0.UserId,
t3.firstname + ' ' + t3.lastname [Employee], t2.itemname, t10.itemname [Labour Name],
 isnull(sum(t0.Quantity),0) [Hours Booked]

from iis_epc_pro_ordert t0
inner join iis_epc_pro_orderh t1 on t1.PrOrder = t0.PrOrder
inner join oitm t2 on t2.ItemCode = t1.EndProduct
inner join ohem t3 on t0.userid = t3.empid
inner join oitm t10 on t10.itemcode = t0.labourcode
inner join oitb t4 on t4.ItmsGrpCod = t10.ItmsGrpCod
where t4.ItmsGrpNam like '%NON%' and t2.itemname not like '%training%'
and t0.Created >= dateadd(year,-1,GETDATE()) 


group by t0.created , t0.UserId, t3.firstname,t3.lastname, t2.itemname, t10.itemname 


UNION ALL

select YEAR(t0.created) [Year], datepart(iso_week,t0.created) [Week], 
 FORMAT(t0.created, 'MM/dd/yyyy') AS created,
 t0.UserId,
t3.firstname + ' ' + t3.lastname [Employee], t2.itemname, t10.itemname [Labour Name],
 isnull(sum(t0.Quantity),0) [Hours Booked]

from iis_epc_pro_ordert t0
inner join iis_epc_pro_orderh t1 on t1.PrOrder = t0.PrOrder
inner join oitm t2 on t2.ItemCode = t1.EndProduct
inner join ohem t3 on t0.userid = t3.empid
inner join oitm t10 on t10.itemcode = t0.labourcode
inner join oitb t4 on t4.ItmsGrpCod = t2.ItmsGrpCod
inner join oitb t5 on t5.ItmsGrpCod = t10.ItmsGrpCod
where t4.ItmsGrpNam like '%NON%' and t2.itemname not like '%training%'
and t5.ItmsGrpNam not like '%NON%'
and t0.Created >= dateadd(year,-1,GETDATE()) 


group by t0.created , t0.UserId, t3.firstname,t3.lastname, t2.itemname, t10.itemname";

    // Prepare and execute the query
    $getResults = $conn->prepare($results_operator_entries);
    $getResults->execute();
    $qlty_results = $getResults->fetchAll(PDO::FETCH_BOTH);
    
//$results_operator = $getResults->fetchAll(PDO::FETCH_BOTH);

    // Output the results as JSON
    echo json_encode(array($qlty_results));

} catch (PDOException $e) {
    echo $e->getMessage();
}
