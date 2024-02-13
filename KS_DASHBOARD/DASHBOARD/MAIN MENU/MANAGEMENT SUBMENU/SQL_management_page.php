<?php
$finance_table_sql = "SELECT *
FROM
(
	SELECT
        'Closed' [Status],
		t0.DelivrdQty * (t0.Linetotal/t0.Quantity) [Value],
        Datepart(month,t0.U_Promise_Date) [Month],
        Datepart(year,t0.U_Promise_Date) [Year]
            FROM RDR1 t0
            INNER JOIN ORDR t1 on t0.DocEntry = t1.DocEntry
                WHERE t1.CANCELED <> 'Y' and t0.ItemCode <> 'TRANSPORT'
                and (
					t0.U_Promise_Date >= dateadd(mm, datediff(mm, 0, getDate()) - 12, 0) and t0.U_Promise_Date < dateadd(mm, datediff(mm, 0, getDate()) + 13, 0)         
                    )

    UNION ALL

    SELECT
        'Pre Production Potential' [Status],
		(t0.Quantity-ISNULL(t0.DelivrdQty,0)) * (t0.Linetotal/t0.Quantity) [Value],
        Datepart(month,t0.U_Promise_Date) [Month],
        Datepart(year,t0.U_Promise_Date) [Year]
            FROM RDR1 t0
            INNER JOIN ORDR t1 on t0.DocEntry = t1.DocEntry
                WHERE (t0.U_PP_Status = 'Pre Production Potential' OR t0.U_PP_Status = '1002') and t1.CANCELED <> 'Y' and t0.ItemCode <> 'TRANSPORT' and t0.LineStatus <> 'C'
                and (
                    t0.U_Promise_Date >= dateadd(mm, datediff(mm, 0, getDate()) - 12, 0) and t0.U_Promise_Date < dateadd(mm, datediff(mm, 0, getDate()) + 13, 0)  
                    )

    UNION ALL

    SELECT
        'Pre Production Forecast' [Status],
        (t0.Quantity-ISNULL(t0.DelivrdQty,0)) * (t0.Linetotal/t0.Quantity) [Value],
        Datepart(month,t0.U_Promise_Date) [Month],
        Datepart(year,t0.U_Promise_Date) [Year]
            FROM RDR1 t0
            INNER JOIN ORDR t1 on t0.DocEntry = t1.DocEntry
                WHERE (t0.U_PP_Status = 'Pre Production Forecast' OR t0.U_PP_Status = '1004') and t1.CANCELED <> 'Y' and t0.ItemCode <> 'TRANSPORT' and t0.LineStatus <> 'C'
                and (
					t0.U_Promise_Date >= dateadd(mm, datediff(mm, 0, getDate()) - 12, 0) and t0.U_Promise_Date < dateadd(mm, datediff(mm, 0, getDate()) + 13, 0)  
                    )

    UNION ALL

    SELECT
        'Pre Production Confirmed' [Status],
        (t0.Quantity-ISNULL(t0.DelivrdQty,0)) * (t0.Linetotal/t0.Quantity) [Value],
        Datepart(month,t0.U_Promise_Date) [Month],
        Datepart(year,t0.U_Promise_Date) [Year]
            FROM RDR1 t0
            INNER JOIN ORDR t1 on t0.DocEntry = t1.DocEntry
                WHERE (t0.U_PP_Status = 'Pre Production Confirmed' OR t0.U_PP_Status = '1003') and t1.CANCELED <> 'Y' and t0.ItemCode <> 'TRANSPORT' and t0.LineStatus <> 'C'
                and(
                    t0.U_Promise_Date >= dateadd(mm, datediff(mm, 0, getDate()) - 12, 0) and t0.U_Promise_Date < dateadd(mm, datediff(mm, 0, getDate()) + 13, 0)  
                    )
    
    UNION ALL

    SELECT
        'Live' [Status],
        (t0.Quantity-ISNULL(t0.DelivrdQty,0)) * (t0.Linetotal/t0.Quantity) [Value],
        Datepart(month,t0.U_Promise_Date) [Month],
        Datepart(year,t0.U_Promise_Date) [Year]
            FROM RDR1 t0
            INNER JOIN ORDR t1 on t0.DocEntry = t1.DocEntry
                WHERE (t0.U_PP_Status IN ('Live','Paused') OR t0.U_PP_Status IS NULL OR t0.U_PP_Status = '1001') and t1.CANCELED <> 'Y' and t0.ItemCode <> 'TRANSPORT' and t0.LineStatus <> 'C'
                and (
					t0.U_Promise_Date >= dateadd(mm, datediff(mm, 0, getDate()) - 12, 0) and t0.U_Promise_Date < dateadd(mm, datediff(mm, 0, getDate()) + 13, 0)         
                    )
	UNION ALL

		SELECT
        'Complete In Stock' [Status],
		CASE
			WHEN (t0.Quantity - ISNULL(t0.DelivrdQty,0)) <= t2.OnHand THEN ((t0.Quantity-ISNULL(t0.DelivrdQty,0))*t0.LineTotal/t0.Quantity)
			ELSE 0.00
		END [Value],
        Datepart(month,t0.U_Promise_Date) [Month],
        Datepart(year,t0.U_Promise_Date) [Year]
            FROM RDR1 t0
            INNER JOIN ORDR t1 ON t0.DocEntry = t1.DocEntry
			INNER JOIN OITM t2 ON t2.ItemCode = t0.ItemCode
                WHERE (t0.U_PP_Status IN ('Live','Paused','Pre Production Confirmed','1001','1003') OR t0.U_PP_Status IS NULL) and t1.CANCELED <> 'Y' and t0.ItemCode <> 'TRANSPORT' and t0.LineStatus <> 'C'
                and (
					t0.U_Promise_Date >= dateadd(mm, datediff(mm, 0, getDate()) - 12, 0) and t0.U_Promise_Date < dateadd(mm, datediff(mm, 0, getDate()) + 13, 0)         
                    )
	UNION ALL

    SELECT
    'Delivered' [Status],
    isnull(t1.Linetotal,0) [Value],
    Datepart(month,t0.DocDate) [Month],
    Datepart(year,t0.DocDate) [Year]
        FROM ODLN t0
        INNER JOIN DLN1 t1 on t1.DocEntry = t0.DocEntry
            WHERE t1.ItemCode <> 'TRANSPORT'
            and (
                t0.DocDate >= dateadd(mm, datediff(mm, 0, getDate()) - 12, 0) and t0.DocDate < dateadd(mm, datediff(mm, 0, getDate()) + 13, 0)
                ) 

    UNION ALL

    SELECT
    'Delivered' [Status],
    isnull(-t2.Linetotal,0) [Value],
    Datepart(month,t0.DocDate) [Month],
    Datepart(year,t0.DocDate) [Year]
        FROM ODLN t0
        INNER JOIN DLN1 t1 on t1.DocEntry = t0.DocEntry
		LEFT JOIN RDN1 t2 ON t2.BaseEntry = t1.DocEntry and t2.ItemCode = t1.ItemCode and t2.BaseLine = t1.LineNum
		LEFT JOIN ORDN t3 on t3.DocEntry = t2.DocEntry
            WHERE t1.ItemCode <> 'TRANSPORT' AND ISNULL(t2.ItemCode,'NONE') <> 'TRANSPORT'
            and (
               t0.DocDate >= dateadd(mm, datediff(mm, 0, getDate()) - 12, 0) and t0.DocDate < dateadd(mm, datediff(mm, 0, getDate()) + 13, 0)
                ) 

   UNION ALL

    SELECT
    'Invoiced' [Status],
    isnull(t1.Linetotal,0) [Value],
    Datepart(month,t0.DocDate) [Month],
    Datepart(year,t0.DocDate) [Year]
        FROM OINV t0
        INNER JOIN INV1 t1 on t1.DocEntry = t0.DocEntry
            WHERE t1.ItemCode <> 'TRANSPORT'
            and (
                t0.DocDate >= dateadd(mm, datediff(mm, 0, getDate()) - 12, 0) and t0.DocDate < dateadd(mm, datediff(mm, 0, getDate()) + 13, 0)
                )
   
   UNION ALL

    SELECT
    'Invoiced' [Status],
    isnull(-t1.Linetotal,0) [Value],
    Datepart(month,t0.DocDate) [Month],
    Datepart(year,t0.DocDate) [Year]
        FROM ORIN t0
        INNER JOIN RIN1 t1 on t1.DocEntry = t0.DocEntry
            WHERE t1.ItemCode <> 'TRANSPORT'
            and (
					t0.DocDate >= dateadd(mm, datediff(mm, 0, getDate()) - 12, 0) and t0.DocDate < dateadd(mm, datediff(mm, 0, getDate()) + 13, 0)
                )
    ) t0

PIVOT( 
    SUM(Value) 
    FOR Status IN (
    [Pre Production Confirmed],
    [Pre Production Potential],
    [Pre Production Forecast],
    [Live],
	[Complete In Stock],
	[Closed],
    [Delivered],
    [Invoiced])
) AS pivot_table;
";


$delivered_this_month_sql =
"SELECT SUM(t2.LineTotal)-SUM(ISNULL(t4.LineTotal,0)) FROM ODLN t3
INNER JOIN DLN1 t2 ON t2.DocEntry = t3.DocEntry
LEFT JOIN RDN1 t4 ON t4.BaseEntry = t2.DocEntry and t4.ItemCode = t2.ItemCode and t4.BaseLine = t2.LineNum
LEFT JOIN ORDN t5 on t5.DocEntry = t4.DocEntry
LEFT JOIN RDR1 t1 ON t1.DocEntry = t2.BaseEntry and t1.Itemcode = t2.ItemCode and t1.LineNum = t2.BaseLine
LEFT JOIN ORDR t0 ON t0.DocEntry = t1.DocEntry
LEFT JOIN OHEM t6 on t6.empID = t0.OwnerCode
WHERE DATEPART(month, t3.DocDate) = DATEPART(month,GETDATE()) AND DATEPART(YEAR, t3.DocDate) = DATEPART(year,GETDATE())
AND t2.ItemCode <> 'TRANSPORT' AND ISNULL(t4.ItemCode,'') <> 'TRANSPORT'";

$delivered_on_time_this_month_sql =
"SELECT SUM(t2.LineTotal)-SUM(ISNULL(t4.LineTotal,0)) FROM ODLN t3
INNER JOIN DLN1 t2 ON t2.DocEntry = t3.DocEntry
LEFT JOIN RDN1 t4 ON t4.BaseEntry = t2.DocEntry and t4.ItemCode = t2.ItemCode and t4.BaseLine = t2.LineNum
LEFT JOIN ORDN t5 on t5.DocEntry = t4.DocEntry
LEFT JOIN RDR1 t1 ON t1.DocEntry = t2.BaseEntry and t1.Itemcode = t2.ItemCode and t1.LineNum = t2.BaseLine
LEFT JOIN ORDR t0 ON t0.DocEntry = t1.DocEntry
LEFT JOIN OHEM t6 on t6.empID = t0.OwnerCode
WHERE DATEPART(month, t3.DocDate) = DATEPART(month,GETDATE()) AND DATEPART(YEAR, t3.DocDate) = DATEPART(year,GETDATE())
AND t2.ItemCode <> 'TRANSPORT' AND ISNULL(t4.ItemCode,'') <> 'TRANSPORT' AND DATEADD(day,-2,t3.DocDate) <= t1.U_Promise_Date";

$delivered_this_year_sql =
"SELECT SUM(t2.LineTotal)-SUM(ISNULL(t4.LineTotal,0)) FROM ODLN t3
INNER JOIN DLN1 t2 ON t2.DocEntry = t3.DocEntry
LEFT JOIN RDN1 t4 ON t4.BaseEntry = t2.DocEntry and t4.ItemCode = t2.ItemCode and t4.BaseLine = t2.LineNum
LEFT JOIN ORDN t5 on t5.DocEntry = t4.DocEntry
LEFT JOIN RDR1 t1 ON t1.DocEntry = t2.BaseEntry and t1.Itemcode = t2.ItemCode and t1.LineNum = t2.BaseLine
LEFT JOIN ORDR t0 ON t0.DocEntry = t1.DocEntry
LEFT JOIN OHEM t6 on t6.empID = t0.OwnerCode
WHERE DATEPART(YEAR, t3.DocDate) = DATEPART(YEAR,GETDATE())
AND t2.ItemCode <> 'TRANSPORT' AND ISNULL(t4.ItemCode,'') <> 'TRANSPORT'";

$delivered_on_time_this_year_sql =
"SELECT SUM(t2.LineTotal)-SUM(ISNULL(t4.LineTotal,0)) FROM ODLN t3
INNER JOIN DLN1 t2 ON t2.DocEntry = t3.DocEntry
LEFT JOIN RDN1 t4 ON t4.BaseEntry = t2.DocEntry and t4.ItemCode = t2.ItemCode and t4.BaseLine = t2.LineNum
LEFT JOIN ORDN t5 on t5.DocEntry = t4.DocEntry
LEFT JOIN RDR1 t1 ON t1.DocEntry = t2.BaseEntry and t1.Itemcode = t2.ItemCode and t1.LineNum = t2.BaseLine
LEFT JOIN ORDR t0 ON t0.DocEntry = t1.DocEntry
LEFT JOIN OHEM t6 on t6.empID = t0.OwnerCode
WHERE DATEPART(YEAR, t3.DocDate) = DATEPART(YEAR,GETDATE())
AND t2.ItemCode <> 'TRANSPORT' AND ISNULL(t4.ItemCode,'') <> 'TRANSPORT' AND DATEADD(day,-2,t3.DocDate) <= t1.U_Promise_Date";

$delivered_last_year_sql =
"SELECT SUM(t2.LineTotal)-SUM(ISNULL(t4.LineTotal,0)) FROM ODLN t3
INNER JOIN DLN1 t2 ON t2.DocEntry = t3.DocEntry
LEFT JOIN RDN1 t4 ON t4.BaseEntry = t2.DocEntry and t4.ItemCode = t2.ItemCode and t4.BaseLine = t2.LineNum
LEFT JOIN ORDN t5 on t5.DocEntry = t4.DocEntry
LEFT JOIN RDR1 t1 ON t1.DocEntry = t2.BaseEntry and t1.Itemcode = t2.ItemCode and t1.LineNum = t2.BaseLine
LEFT JOIN ORDR t0 ON t0.DocEntry = t1.DocEntry
LEFT JOIN OHEM t6 on t6.empID = t0.OwnerCode
WHERE DATEPART(YEAR, t3.DocDate) = (DATEPART(YEAR,GETDATE()) - 1)
AND ISNULL(t2.ItemCode,'') <> 'TRANSPORT' AND ISNULL(t4.ItemCode,'') <> 'TRANSPORT' AND t0.CANCELED <> 'Y' AND t3.DocStatus = 'C'
";

$delivered_on_time_last_year_sql =
"SELECT SUM(t2.LineTotal)-SUM(ISNULL(t4.LineTotal,0)) FROM ODLN t3
INNER JOIN DLN1 t2 ON t2.DocEntry = t3.DocEntry
LEFT JOIN RDN1 t4 ON t4.BaseEntry = t2.DocEntry and t4.ItemCode = t2.ItemCode and t4.BaseLine = t2.LineNum
LEFT JOIN ORDN t5 on t5.DocEntry = t4.DocEntry
LEFT JOIN RDR1 t1 ON t1.DocEntry = t2.BaseEntry and t1.Itemcode = t2.ItemCode and t1.LineNum = t2.BaseLine
LEFT JOIN ORDR t0 ON t0.DocEntry = t1.DocEntry
LEFT JOIN OHEM t6 on t6.empID = t0.OwnerCode
WHERE DATEPART(YEAR, t3.DocDate) = (DATEPART(YEAR,GETDATE()) -1)
AND t2.ItemCode <> 'TRANSPORT' AND ISNULL(t4.ItemCode,'') <> 'TRANSPORT' AND DATEADD(day,-2,t3.DocDate) <= t1.U_Promise_Date";

$confirmed_four_months_sql = 
"SELECT SUM(CASE WHEN t1.LineStatus = 'C' THEN t1.DelivrdQty * t1.LineTotal/t1.Quantity ELSE t1.LineTotal END)
    FROM ORDR t0
    INNER JOIN RDR1 t1 ON t1.DocEntry = t0.DocEntry
        WHERE t1.U_PP_STATUS IN ('Pre Production Confirmed','1003') AND t0.CANCELED <> 'Y' AND t1.ItemCode <> 'TRANSPORT' AND t1.U_Promise_Date >= DATEADD(month, DATEDIFF(month, 0, GETDATE()), 0) AND t1.U_Promise_Date < DATEADD(month, 4,DATEADD(month, DATEDIFF(month, 0, GETDATE()), 0))";

$total_four_months_sql = 
"SELECT SUM(CASE WHEN t1.LineStatus = 'C' THEN t1.DelivrdQty * t1.LineTotal/t1.Quantity ELSE t1.LineTotal END)
    FROM ORDR t0
    INNER JOIN RDR1 t1 ON t1.DocEntry = t0.DocEntry
        WHERE t0.CANCELED <> 'Y' AND t1.ItemCode <> 'TRANSPORT' AND t1.U_Promise_Date >= DATEADD(month, DATEDIFF(month, 0, GETDATE()), 0) AND t1.U_Promise_Date < DATEADD(month, 4,DATEADD(month, DATEDIFF(month, 0, GETDATE()), 0))";
        
$total_this_month_sql = 
"SELECT SUM(CASE WHEN t1.LineStatus = 'C' THEN t1.DelivrdQty * (t1.LineTotal/t1.Quantity) ELSE t1.LineTotal END)
    FROM ORDR t0
    INNER JOIN RDR1 t1 ON t1.DocEntry = t0.DocEntry
        WHERE t0.CANCELED <> 'Y' AND t1.ItemCode <> 'TRANSPORT' AND DATEPART(year,t1.U_Promise_Date) = DATEPART(year,GETDATE()) AND DATEPART(month,t1.U_Promise_Date) = DATEPART(month,GETDATE())";

$confirmed_this_year_sql = 
"SELECT SUM(CASE WHEN t1.LineStatus = 'C' THEN t1.DelivrdQty * (t1.LineTotal/t1.Quantity) ELSE t1.LineTotal END)
FROM ORDR t0
INNER JOIN RDR1 t1 ON t1.DocEntry = t0.DocEntry
    WHERE t1.U_PP_STATUS IN ('Pre Production Confirmed','1003') AND t0.CANCELED <> 'Y' AND t1.ItemCode <> 'TRANSPORT' AND DATEPART(year,t1.U_Promise_Date) = DATEPART(year,GETDATE()) AND t1.LineStatus <> 'C'";

$total_this_year_sql = 
"SELECT SUM(CASE WHEN t1.LineStatus = 'C' THEN t1.DelivrdQty * (t1.LineTotal/t1.Quantity) ELSE t1.LineTotal END)
    FROM ORDR t0
    INNER JOIN RDR1 t1 ON t1.DocEntry = t0.DocEntry
        WHERE t0.CANCELED <> 'Y' AND t1.ItemCode <> 'TRANSPORT' AND DATEPART(year,t1.U_Promise_Date) = DATEPART(year,GETDATE()) ";

$total_last_year_sql = 
"SELECT SUM(CASE WHEN t1.LineStatus = 'C' THEN t1.DelivrdQty * (t1.LineTotal/t1.Quantity) ELSE t1.LineTotal END)
    FROM ORDR t0
        INNER JOIN RDR1 t1 ON t1.DocEntry = t0.DocEntry
            WHERE t1.ItemCode <> 'TRANSPORT' AND t0.Canceled <> 'Y' AND DATEPART(year, t1.U_Promise_Date) = datepart(year,GetDate())-1";

$in_stock_this_month_sql =
"SELECT SUM(CASE WHEN (t0.Quantity - ISNULL(t0.DelivrdQty,0)) <= t2.OnHand THEN ((t0.Quantity-ISNULL(t0.DelivrdQty,0))*t0.LineTotal/t0.Quantity) ELSE 0.00 END) [Value]
    FROM RDR1 t0
        INNER JOIN ORDR t1 ON t0.DocEntry = t1.DocEntry
		INNER JOIN OITM t2 ON t2.ItemCode = t0.ItemCode
            WHERE (t0.U_PP_Status IN ('Live','Paused','Pre Production Confirmed','1001','1003') OR t0.U_PP_Status IS NULL) and t1.CANCELED <> 'Y' and t0.ItemCode <> 'TRANSPORT' and t0.LineStatus <> 'C'
                and DATEPART(month,t0.U_Promise_Date) = DATEPART(month,getDate()) AND DATEPART(YEAR,t0.U_Promise_Date) = DATEPART(YEAR,getDate())";
                
$in_stock_this_year_sql =
"SELECT SUM(CASE WHEN (t0.Quantity - ISNULL(t0.DelivrdQty,0)) <= t2.OnHand THEN ((t0.Quantity-ISNULL(t0.DelivrdQty,0))*t0.LineTotal/t0.Quantity) ELSE 0.00 END) [Value]
    FROM RDR1 t0
        INNER JOIN ORDR t1 ON t0.DocEntry = t1.DocEntry
		INNER JOIN OITM t2 ON t2.ItemCode = t0.ItemCode
            WHERE (t0.U_PP_Status IN ('Live','Paused','Pre Production Confirmed','1001','1003') OR t0.U_PP_Status IS NULL) and t1.CANCELED <> 'Y' and t0.ItemCode <> 'TRANSPORT' and t0.LineStatus <> 'C'
                AND DATEPART(YEAR,t0.U_Promise_Date) = DATEPART(YEAR,GETDATE())";

$in_stock_last_year_sql =
"SELECT SUM(CASE WHEN (t0.Quantity - ISNULL(t0.DelivrdQty,0)) <= t2.OnHand THEN ((t0.Quantity-ISNULL(t0.DelivrdQty,0))*t0.LineTotal/t0.Quantity) ELSE 0.00 END) [Value]
    FROM RDR1 t0
        INNER JOIN ORDR t1 ON t0.DocEntry = t1.DocEntry
		INNER JOIN OITM t2 ON t2.ItemCode = t0.ItemCode
            WHERE (t0.U_PP_Status IN ('Live','Paused','Pre Production Confirmed','1001','1003') OR t0.U_PP_Status IS NULL) and t1.CANCELED <> 'Y' and t0.ItemCode <> 'TRANSPORT' and t0.LineStatus <> 'C'
                AND DATEPART(YEAR,t0.U_Promise_Date) = DATEPART(YEAR,getDate())-1";
?>