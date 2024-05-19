
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
$results=" SELECT sum(t4.PlannedQty) as Plannedhours,max(t1.DocEntry) as [Production Order] ,max(t10.PrOrder) as [Process Order],
max( t17.ItmsGrpNam ) as Descp,
max(t1.OriginNum) as [Sales Order],max(t8.CardName) as CardName,max(t10.EndProduct) as ItemCode,max(t16.U_Product_Group_One) as U_Product_Group_One ,max(t16.U_Product_Group_Two) as U_Product_Group_Two,max(t16.U_Product_Group_Three) as U_Product_Group_Three,
max(FORMAT(CONVERT(DATE,t1.CreateDate),'dd-MM-yyyy')) as [Relased Date]

FROM WOR1 t4 
       inner join OITM t5 on t4.ItemCode=t5.ItemCode
       inner join OITB t6 on t5.ItmsGrpCod=t6.ItmsGrpCod
       --inner join owor t7 on t4.docentry = t7.DocEntry
	 
	   left join IIS_EPC_PRO_ORDERH t10 on t10.PrOrder=t4.U_IIS_proPrOrder
	   left join oitm t16 on t16.ItemCode=t10.EndProduct
	   LEFT JOIN oitb t17 ON t17.ItmsGrpCod = t6.ItmsGrpCod
left JOIN owor t1 ON t1.DocEntry= t4.DocEntry ---AND t1.ItemCode = t10.EndProduct 
  left JOIN ORDR t8 ON t8.DocNum = t1.OriginNum
       WHERE t1.CreateDate > DATEADD(DAY,-DATEPART(DY,GETDATE()),GETDATE())
	    --t10.PrOrder=43312
              AND t1.Status NOT IN ('C')
                      AND t6.ItmsGrpCod not like '%MACHINE%'
                      AND t5.ItemType = 'L'
					  group by t10.PrOrder order by t10.PrOrder 
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
