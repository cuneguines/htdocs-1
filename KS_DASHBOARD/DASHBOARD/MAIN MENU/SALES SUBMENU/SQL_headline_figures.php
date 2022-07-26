<?php
    $sales_per_day_query = 
    "SELECT (CASE WHEN t1.OcrCode IN ('BP','ST','EC') THEN t1.OcrCode ELSE 'OT' END) [Business Unit], FORMAT(CAST(t0.DocDate AS DATE), 'dd-MM-yy') [Date], CAST(SUM(CASE WHEN t1.LineStatus = 'C' THEN t1.DelivrdQty * (t1.LineTotal/t1.quantity) ELSE t1.LineTotal END)AS DECIMAL(12,0)) [Sales Value]
    FROM ORDR t0 
    INNER JOIN RDR1 t1 ON t1.DocEntry = t0.DocEntry
    WHERE t1.ItemCode <> 'TRANSPORT' AND t0.CANCELED <> 'Y' AND DATEPART(year,t0.DocDate) > 2017
    GROUP BY CAST(t0.DocDate AS DATE), t1.OcrCode
    ORDER BY CAST(t0.DocDate AS DATE)";

    $today_sales_query = 
    "SELECT t0. CardName [Customer], CAST(SUM(t1.LineTotal) AS DECIMAL(12,0)) [Value]
    FROM ORDR t0
    INNER JOIN RDR1 t1 ON t1.DocEntry = t0.DocEntry
    WHERE t1.ItemCode <> 'TRANSPORT' AND t0.CANCELED <> 'Y' AND CAST(t0.DocDate AS DATE) = CAST(GETDATE() AS DATE)
    GROUP By t0.CardName ORDER BY [Value] DESC";

    $yesterday_sales_query = 
    "SELECT t0. CardName [Customer], CAST(SUM(t1.LineTotal) AS DECIMAL(12,0)) [Value]
    FROM ORDR t0
    INNER JOIN RDR1 t1 ON t1.DocEntry = t0.DocEntry
    WHERE t1.ItemCode <> 'TRANSPORT' AND t0.CANCELED <> 'Y' AND CAST(t0.DocDate AS DATE) = CAST(DATEADD(day,-1,GETDATE()) AS DATE)
    GROUP By t0.CardName ORDER BY [Value] DESC";

    $top_customers_query = 
    "SELECT TOP 15 t0. CardName [Customer], CAST(SUM(t1.LineTotal) AS DECIMAL(12,0)) [Value]
    FROM ORDR t0
    INNER JOIN RDR1 t1 ON t1.DocEntry = t0.DocEntry
    WHERE t1.ItemCode <> 'TRANSPORT' AND t0.CANCELED <> 'Y' AND DATEPART(year, t0.DocDate) = DATEPART(year, GETDATE())
    GROUP By t0.CardName ORDER BY [Value] DESC";

    $top_sales_people_query = 
    "SELECT t3.firstName + ' ' + t3.LastName [Sales Person], CAST(SUM(t1.LineTotal) AS DECIMAL(12,0)) [Value]
    FROM ORDR t0
    INNER JOIN RDR1 t1 ON t1.DocEntry = t0.DocEntry
    INNER JOIN ohem t3 on t3.empID = t0.OwnerCode
    WHERE t1.ItemCode <> 'TRANSPORT' AND t0.CANCELED <> 'Y' AND DATEPART(year, t0.DocDate) = DATEPART(year, GETDATE())
    GROUP By (t3.firstName + ' ' + t3.LastName) ORDER BY [Value] DESC";
?>