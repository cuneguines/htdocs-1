<?php
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
//$Id = (!empty($_POST['id']) ? $_POST['id'] : '');
try
{
$results="SELECT 
t3.DocNum [Sales Order], 
t3.CardName [Customer],
t3.U_Client[Project],
t2.Dscription [Item Name], 
t2.Quantity [Sales Order Qty],
t0.DocNum [Delivery Note], 
t1.Quantity[Del Note Quatity], 
t1.LineTotal[Del Note Line Value],
t5.DocNum [Delivery Return Note], 
t4.Quantity [Ret Qty], 
ISNULL(t1.Quantity,0)-ISNULL(t4.Quantity,0) [Del Minus Ret Quantity], 
ISNULL(t1.LineTotal,0)-ISNULL(t4.LineTotal,0) [Del Minus Ret Value],

 
t6.ItemCode [Item Code],
t6.CreateDate [Code Create Date],
t7.ItmsGrpNam [Item Group Name], 
t6.U_Product_Group_One [Product Group 1], 
t6.U_Product_Group_Two [Product Group 2], 
t6.U_Product_Group_Three [Product Group 3], 
t3.U_Client [Project], 
FORMAT(t1.U_Promise_Date,'dd/MM/yyyy') [Promise Date],
FORMAT(t0.DocDate,'dd/MM/yyyy') [Delivery Note Date],
DATEPART(YEAR,t0.DocDate) [Del Note Year], 
DATEPART(MONTH,t0.DocDate) [Del Note Month], 
DATEPART(WEEK,t0.DocDate) [Del Note Week],
t8.firstName + ' ' + t8.lastName [Sales Person],
t3.U_Market_Sector [Market Sector],
t3.U_Dimension1 [Business Unit],
t9.SlpName [Engineer]

FROM ODLN t0
INNER JOIN DLN1 t1 ON t1.DocEntry = t0.DocEntry
LEFT JOIN RDR1 t2 ON t2.DocEntry = t1.BaseEntry AND t2.LineNum = t1.BaseLine
LEFT JOIN ORDR t3 ON t3.DocENtry = t2.DocEntry
LEFT JOIN RDN1 t4 ON t4.BaseENtry = t1.DocEntry AND t4.BaseLine = t1.LineNum
LEFT JOIN ORDN t5 ON t5.DocEntry = t4.DocEntry

LEFT JOIN OITM t6 ON t6.ItemCode = t1.ItemCode
LEFT JOIN OITB t7 ON t7.ItmsGrpCod = t6.ItmsGrpCod
LEFT JOIN OHEM t8 ON t8.empID = t3.OwnerCode
LEFT JOIN OSLP t9 ON t9.SlpCode = t2.SlpCode
WHERE t0.DocDate >= '01/01/2018' 
AND t1.ItemCode <> 'TRANSPORT' AND t3.CANCELED <> 'Y' AND t0.DocStatus = 'C' 
 
 
ORDER BY t0.DocNum";
 $getResults = $conn->prepare($results);
 $getResults->execute();
 $qlty_results = $getResults->fetchAll(PDO::FETCH_BOTH);
 //$json_array = array();
 //var_dump($production_exceptions_results);
 echo json_encode(array($qlty_results));
}
catch(PDOException $e){
  echo $e->getMessage();
$e->getMessage();
}

