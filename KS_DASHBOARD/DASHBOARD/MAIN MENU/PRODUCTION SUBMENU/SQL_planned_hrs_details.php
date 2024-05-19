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
try{
$results=" SELECT 
--  SUM(CASE 
--WHEN (t2.[Planned_Lab] - ISNULL(t3.[Actual_Lab],0)) < 0 THEN 0
--ELSE CAST(t2.[Planned_Lab] AS DECIMAL (12,0)) - CAST(ISNULL(t3.[Actual_Lab],0) AS DECIMAL (12,0))
--END)[Remaining_Lab]

t0.PrOrder,
t2.Planned_Lab,
t3.Actual_Lab,
isNULL(t4.CardName,'KENT')[CardName],
t4.DocNum[Sales_Order],

--t88.U_NAME,
FORMAT(CONVERT(DATE,t5.U_floor_date),'dd-MM-yyyy') [Floor_Date],
 FORMAT(CONVERT(DATE,t5.U_Promise_Date),'dd-MM-yyyy') [Promise Date],
FORMAT( ISNULL(t5.U_floor_date, DATEADD(WEEK, 4, GETDATE())),'dd-MM-yyyy') AS [Adjusted_Promise_Date],
 t6.U_Product_Group_One,
t6.U_Product_Group_Two,
t6.U_Product_Group_Three,
---t4.OwnerCode,
t10.SlpName [Engineer],
t13.firstname + ' ' + t13.lastName [Sales Person]
 --ISNULL(t7.SlpName,'NO NAME') [Engineer]

FROM IIS_EPC_PRO_ORDERH t0
INNER JOIN owor t1 ON t1.U_IIS_proPrOrder = t0.PrOrder AND t1.ItemCode = t0.EndProduct    
INNER JOIN (select t1.U_IIS_proPrOrder, 
    SUM(t0.plannedqty) [Planned_Lab]
    FROM wor1 t0
        INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry                        
        INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode               
            WHERE t2.ItemType = 'L'                      
            GROUP BY t1.U_IIS_proPrOrder) 
t2 ON t2.U_IIS_proPrOrder = t0.PrOrder    

LEFT JOIN (SELECT t0.PrOrder, 
    SUM(t0.Quantity) [Actual_Lab]
        FROM iis_epc_pro_ordert t0                       
            GROUP BY t0.PrOrder) 
t3 ON t3.PrOrder = t0.Prorder

LEFT JOIN ORDR t4 ON t4.DocNum = t1.OriginNum

LEFT JOIN RDR1 t5 ON t5.DocEntry = t4.DocENtry and t5.ItemCode = t0.EndProduct

left join oitm t6 on t6.ItemCode=t0.EndProduct
--LEFT JOIN ORDR t4 ON t4.DocNum = t1.OriginNum
left JOIN oslp t10 ON t10.SlpCode = t4.SlpCode
 left  join ohem t13 on t13.empID = t4.OwnerCode
--LEFT JOIN RDR1 t5 ON t5.DocEntry = t4.DocENtry and t5.ItemCode = t0.EndProduct
left join [dbo].ousr as t88 on t88.USERID=t4.U_Proj_Mgr 

WHERE t1.CmpltQty < t1.PlannedQty AND 
   t0.Status NOT IN ('D','C') AND 
   t1.Status NOT IN ('C','L') AND 
   (t5.U_PP_status IN ('Live','1001') or t5.U_PP_status is null)

";
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
