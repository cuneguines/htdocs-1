<?php
$delivered_table_sql =
"SELECT
CASE WHEN DATEADD(day,-2,t3.DocDate) <= ISNULL(t1.U_Promise_Date,0) THEN 'ONTIME' ELSE 'LATE' END [Ontime],
FORMAT(CAST(T3.[DocDate] AS DATE), 'dd-MM-yyyy') [Issue Date],
DATEPART(month,T3.[DocDate]) [Month],
DATEPART(year,T3.[DocDate]) [Year],
T3.DocNum [Delivery Note Number],
FORMAT(CAST(t1.U_Promise_date AS DATE), 'dd-MM-yyyy')[Promise Date],
t2.ItemCode [Item Code],
t2.Dscription [Description],
CAST(T2.Quantity AS DECIMAL (12)) [Delivery Qty],
CAST((t2.Linetotal-ISNULL(t4.LineTotal,0))AS DECIMAL (12,2)) [Delivery Value],
ISNULL(CAST(t1.Quantity AS DECIMAL (12)),0)[Line Qty],
ISNULL(CAST(t1.Linetotal AS DECIMAL (12,2)),0)[Line Value],
CASE
    WHEN t1.LineStatus = 'C' THEN 0
    ELSE ISNULL(CAST(t1.Quantity - t1.delivrdQty AS DECIMAL (12,0)),0)
END [Remaining Qty],
ISNULL(t0.CardName, 'NO SALES ORDER') [Customer],
ISNULL(t0.DocNum, '999999') [Sales Order],
ISNULL(t7.SlpName, 'NO SALES ORDER')[Engineer]

FROM ODLN t3
INNER JOIN DLN1 t2 ON t2.DocEntry = t3.DocEntry
LEFT JOIN RDN1 t4 ON t4.BaseEntry = t2.DocEntry and t4.ItemCode = t2.ItemCode and t4.BaseLine = t2.LineNum
LEFT JOIN ORDN t5 on t5.DocEntry = t4.DocEntry
LEFT JOIN RDR1 t1 ON t1.DocEntry = t2.BaseEntry and t1.Itemcode = t2.ItemCode and t1.LineNum = t2.BaseLine
LEFT JOIN ORDR t0 ON t0.DocEntry = t1.DocEntry
LEFT JOIN OHEM t6 on t6.empID = t0.OwnerCode
LEFT JOIN OSLP t7 on t7.SlpCode = ISNULL(t1.SlpCode, t0.SlpCode)
LEFT JOIN OITM t8 ON t8.ItemCode = t2.ItemCode
LEFT JOIN OITB t9 ON t8.ItmsGrpCod = t9.ItemsGrpCod


where t2.ItemCode <> 'TRANSPORT' AND ISNULL(t4.ItemCode,'NONE') <> 'TRANSPORT' AND t3.DocDate >= dateadd(mm, datediff(mm, 0, getDate()) - 12, 0) AND t3.DocDate <= dateadd(mm, datediff(mm, 0, getDate()) + 13, 0)

ORDER BY t3.DOCNUM DESC, t1.ItemCode";
?>