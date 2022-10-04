<?php
$production_exceptions =
"SELECT 
    T0.[DocNum] [Purchase Order Number], 
  T0.DocNum,
    FORMAT(t0.docdate,'dd-MM-yyyy') [Order Date],
    FORMAT(cast(T0.[DocDueDate] as date),'dd-MM-yyyy')[Due Date], 
    T0.[CardName] [Supplier],
    cast(T1.[Quantity] as decimal)[Quantity], 
    T1.[Dscription], cast(t1.Quantity as decimal), 
    t3.ItmsGrpNam [stock_group],
    t0.Comments [Comments]
        FROM OPOR T0  
        INNER JOIN POR1 T1 ON T0.DocEntry = T1.DocEntry 
        inner join oitm t2 on t2.ItemCode = t1.ItemCode
        inner join oitb t3 on t3.ItmsGrpCod = t2.ItmsGrpCod
            WHERE T1.LineStatus = 'O' AND  
(T0.[U_Destination] = 'Plant' OR T0.[U_Destination] = 'Service') AND T1.ItemCode <> 'Transport' 
AND T1.[Dscription] <> 'Transport'
$clause
$clause_a
ORDER BY T0.[DocDueDate] asc, T0.[CardName]
";
?>