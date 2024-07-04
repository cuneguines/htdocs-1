
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
$results_old="
SELECT 
       t0.U_IIS_proPrOrder[Process Order], 
       t0.DocNum[Production Order],
       CONVERT(DATE,t0.CreateDate)[Released Date],
	   YEAR(CONVERT(DATE, t0.CreateDate, 105)) AS [Released Year],
       t4.DocNum[Sales Order],
       t4.CardName[Customer],
	   t4.U_Client,
       t0_1.ItemName [End Product],
       t0_1.U_Product_Group_One ,
       t0_1.U_Product_Group_Two,
       t0_1.U_Product_Group_Three,
       --t1.[ItemName] Process,
      -- t3.ItmsGrpCod[Process Group Code],
       --t3.ItmsGrpNam[Process Group Name],
       ISNULL(CAST(t1.PlannedQty AS DECIMAL (12,2)),0)[Process Planned Time],
	   t17.ItmsGrpNam
	   ---,t10.EndProduct
FROM OWOR t0
       INNER JOIN WOR1 t1 ON t1.DocEntry = t0.DocEntry
       INNER JOIN OITM t2 ON t2.ItemCode = t1.ItemCode
       INNER JOIN OITM t0_1 ON t0_1.ItemCode = t0.ItemCode
       INNER JOIN OITB t3 ON t3.ItmsGrpCod = t2.ItmsGrpCod
       LEFT JOIN ORDR t4 ON t4.DocNum = t0.OriginNum

	  left join IIS_EPC_PRO_ORDERH t10 on t10.PrOrder=t0.U_IIS_proPrOrder
	 left join oitm t16 on t16.ItemCode=t10.EndProduct
	 LEFT JOIN oitb t17 ON t17.ItmsGrpCod = t16.ItmsGrpCod

       WHERE 
       t0.CreateDate > DATEADD(DAY,-DATEPART(DY,GETDATE()),GETDATE())
       AND t0.Status NOT IN ('C')
       AND t3.ItmsGrpNam NOT LIKE '%MACHINE%'
       AND t2.ItemType LIKE 'L'

       AND ISNULL(CAST(t1.PlannedQty AS DECIMAL (12,0)),0) > 0
	   order  by [Process Order]
";
$results="select t11.TotalPlannedQty [Process Planned Time],t11.U_IIS_proPrOrder[Process Order] from IIS_EPC_PRO_ORDERH t10
inner join	(select SUM(t4.PlannedQty) as  TotalPlannedQty,t4.U_IIS_proPrOrder
FROM WOR1 t4 
       inner join OITM t5 on t4.ItemCode=t5.ItemCode
       inner join OITB t6 on t5.ItmsGrpCod=t6.ItmsGrpCod
       inner join owor t7 on t4.docentry = t7.DocEntry

       WHERE --t7.CreateDate > DATEADD(DAY,-DATEPART(DY,GETDATE()),GETDATE())AND 
       t7.Status NOT IN ('C')
                      AND t6.ItmsGrpNam not like '%MACHINE%'
                      AND t5.ItemType = 'L'
					  group by t4.U_IIS_proPrOrder) t11 on t11.U_IIS_proPrOrder=t10.PrOrder";
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
