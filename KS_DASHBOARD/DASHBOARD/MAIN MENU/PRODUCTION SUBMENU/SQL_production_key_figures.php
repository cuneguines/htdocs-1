<?php
$released_today_list_sql=
"SELECT t0.PrOrder [Process Order],
        t0.CreateDate, t1.ItemName [Item Name]
        FROM IIS_EPC_PRO_ORDERH t0
            LEFT JOIN OITM t1 ON t1.ItemCode = t0.EndProduct
            WHERE CAST(t0.CreateDate AS DATE) = CAST(GETDATE() AS DATE)
ORDER BY PrORder Desc";

$released_yesterday_list_sql=
"SELECT t0.PrOrder [Process Order], t0.CreateDate, t1.ItemName [Item Name]
    FROM IIS_EPC_PRO_ORDERH t0
    LEFT JOIN OITM t1 ON t1.ItemCode = t0.EndProduct
        WHERE (DATEPART(WEEKDAY,GETDATE()) = 2 AND CAST(t0.CreateDate AS DATE) = CAST(DATEADD(DAY,-3,GETDATE()) AS DATE)) OR CAST(t0.CreateDate AS DATE) = CAST(DATEADD(DAY,-1,GETDATE()) AS DATE)
            ORDER BY PrORder Desc";

$complete_today_list_sql=
"SELECT t0.PrOrder [Process Order], t3.STOCKDATE, t2.ItemName [Item Name]
    FROM IIS_EPC_PRO_ORDERH t0
    INNER JOIN owor t1 ON t1.U_IIS_proPrOrder = t0.PrOrder AND t1.ItemCode = t0.EndProduct
    LEFT JOIN OITM t2 ON t2.ItemCode = t0.EndProduct
    LEFT JOIN(
        SELECT MAX(t0.Docdate) [STOCKDATE], t1.BaseRef, t1.ItemCode
            FROM oign t0 
            INNER JOIN ign1 t1 ON t1.DocEntry = t0.DocEntry
                GROUP BY t1.BaseRef, t1.ItemCode
    )t3 ON t3.BaseRef = t1.DocNum and t3.ItemCode = t1.ItemCode
        WHERE CAST(t3.[STOCKDATE] AS DATE) = CAST(GETDATE() AS DATE)";

$complete_yesterday_list_sql=
"SELECT t0.PrOrder [Process Order], t3.STOCKDATE, t2.ItemName [Item Name]
    FROM IIS_EPC_PRO_ORDERH t0
    INNER JOIN owor t1 ON t1.U_IIS_proPrOrder = t0.PrOrder AND t1.ItemCode = t0.EndProduct
    LEFT JOIN OITM t2 ON t2.ItemCode = t0.EndProduct
    LEFT JOIN(
        SELECT MAX(t0.Docdate) [STOCKDATE], t1.BaseRef, t1.ItemCode
            FROM oign t0 
            INNER JOIN ign1 t1 ON t1.DocEntry = t0.DocEntry
                GROUP BY t1.BaseRef, t1.ItemCode
    )t3 ON t3.BaseRef = t1.DocNum and t3.ItemCode = t1.ItemCode
WHERE (DATEPART(WEEKDAY,GETDATE()) = 2 AND CAST(t3.STOCKDATE AS DATE) = CAST(DATEADD(DAY,-3,GETDATE()) AS DATE)) OR CAST(t3.STOCKDATE AS DATE) = CAST(DATEADD(DAY,-1,GETDATE()) AS DATE)";

$estimated_pp_demand_sql=
"SELECT * FROM
(
    SELECT
    /* GET EST PROD HRS FOR SALES ORDERS WITH NO PRODUCTION ORDER TO AVOID DOUBLE COUNTING */
    CAST(ISNULL(t3.U_Est_Prod_Hrs,0) AS DECIMAL (12,0)) [LAB],
    CASE 
        WHEN CAST(t3.U_promise_Date AS DATE) < DATEADD(DAY, -DATEPART(WEEKDAY, GETDATE())+2 ,DATEADD(WEEK, -5, CAST(GETDATE() AS DATE))) THEN 1111  /* WHEN PROMISE DATE IS BEFORE MONDAY OF WEEK 5 WEEKS AGO */
        WHEN CAST(t3.U_promise_Date AS DATE) > DATEADD(DAY, +(6-DATEPART(WEEKDAY, GETDATE())) ,DATEADD(WEEK, 104, CAST(GETDATE() AS DATE))) THEN 2222 /* WHEN PROMISE DATE IS AFTER FRIDAY OF WEEK 104 WEEKS TO COME */
        ELSE DATEDIFF(WEEK,CAST(GETDATE() AS DATE),CAST(t3.U_promise_Date AS DATE))
    END [WEEK_NO]
    FROM ORDR t2
    LEFT JOIN RDR1 t3 ON t3.DocEntry = t2.DocEntry
    LEFT JOIN OWOR t1 ON t1.OriginNum = t2.DocNum
    WHERE t2.DocStatus <> 'C' AND t2.CANCELED <> 'Y' AND t1.DocNum IS NULL
)t0
PIVOT
(
    SUM(LAB)
    FOR [WEEK_NO] IN ([1111], [-5], [-4] ,[-3], [-2], [-1], 
                        [0], [1], [2], [3], [4], [5], [6], [7], [8], [9], 
                        [10], [11], [12], [13], [14], [15], [16], [17], [18], [19],
                        [20], [21], [22], [23], [24], [25], [26], [27], [28], [29],
                        [30], [31], [32], [33], [34], [35], [36], [37], [38], [39],
                        [40], [41], [42], [43], [44], [45], [46], [47], [48], [49],
                        [50], [51], [52], [53], [54], [55], [56], [57], [58], [59],
                        [60], [61], [62], [63], [64], [65], [66], [67], [68], [69],
                        [70], [71], [72], [73], [74], [75], [76], [77], [78], [79],
                        [80], [81], [82], [83], [84], [85], [86], [87], [88], [89],
                        [90], [91], [92], [93], [94], [95], [96], [97], [98], [99],
                        [100], [101], [102], [103], [104], [2222])
) AS pivot_table;";

$planned_po_demand_sql=
"SELECT * FROM
(
    /* GETS PLANNED MINUS EXECUTED HOURS FOR EACH PROCESS ORDER AND THE WEEK IT IS DUE (PROMISE DATE IF SALES ORDER EXISTS AND DUE DATE OF PRODUCION ORDER IF NOT) */
    SELECT
        CASE WHEN ISNULL(t4.Planned_lab,0)-ISNULL(t5.Actual_Lab,0) < 0 THEN 0 ELSE CAST(ISNULL(t4.Planned_lab,0)-ISNULL(t5.Actual_Lab,0) AS DECIMAL (12,0)) END[LAB],
        CASE 
            WHEN CAST(ISNULL(t3.U_promise_Date,t1.DueDate) AS DATE) < DATEADD(DAY, -DATEPART(WEEKDAY, GETDATE())+2 ,DATEADD(WEEK, -5, CAST(GETDATE() AS DATE))) THEN 1111  /* WHEN PROMISE DATE OR PROD ORDER DUE DATE IS BEFORE MONDAY OF WEEK     X WEEKS AGO */
            WHEN CAST(ISNULL(t3.U_promise_Date,t1.DueDate) AS DATE) > DATEADD(DAY, +(6-DATEPART(WEEKDAY, GETDATE())) ,DATEADD(WEEK, 52, CAST(GETDATE() AS DATE))) THEN 2222 /* WHEN PROMISE DATE OR PROD ORDER DUE DATE IS AFTER FRIDAY OF WEEK      X WEEKS IN FUTURE */
            ELSE DATEDIFF(WEEK,CAST(GETDATE() AS DATE),CAST(ISNULL(t3.U_promise_Date,t1.DueDate) AS DATE))																	/* ELSE GET DELTA WEEK DIFFERENCE BETWEEN DUE DATE AND CURRENT DATE */ 
        END [WEEK_NO]
        FROM IIS_EPC_PRO_ORDERH t0
        INNER JOIN owor t1 ON t1.U_IIS_proPrOrder = t0.PrOrder AND t1.ItemCode = t0.EndProduct
        LEFT JOIN ordr t2 ON t2.docnum = t1.OriginNum
        LEFT JOIN rdr1 t3 ON t3.DocEntry = t2.DocEntry AND t3.ItemCode = t1.ItemCode
        LEFT JOIN (select t1.U_IIS_proPrOrder, 
            SUM(t0.plannedqty) [Planned_Lab]
            FROM wor1 t0
                INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry  				
                INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode
                inner join iis_epc_pro_orderh t3 on t3.PrOrder = t0.U_IIS_proPrOrder 				
                    WHERE t2.ItemType = 'L' 				
                    GROUP BY t1.U_IIS_proPrOrder) 
        t4 ON t4.U_IIS_proPrOrder = t0.PrOrder
        LEFT JOIN (SELECT t0.PrOrder, 
            SUM(t0.Quantity) [Actual_Lab]
                FROM iis_epc_pro_ordert t0  				
                    GROUP BY t0.PrOrder) 
        t5 ON t5.PrOrder = t0.Prorder
        /* IF SALES ORDER EXISTS AND IS OPEN AND NOT CANCELLED *//* EXCLUDE ALL PRODUCTION ORDERS STAT ARE EITHER CLOSED OR CANCELLED */
        WHERE ISNULL(t2.DocStatus,'O') <> 'C' AND ISNULL(t2.CANCELED,'N') <> 'Y' AND t1.[Status] NOT IN ('L','C')	
)t0
PIVOT(
    SUM(LAB)
    FOR [WEEK_NO] IN ([1111], [-5], [-4], [-3], [-2], [-1],
                        [0], [1], [2], [3], [4], [5], [6], [7], [8], [9], 
                        [10], [11], [12], [13], [14], [15], [16], [17], [18], [19],
                        [20], [21], [22], [23], [24], [25], [26], [27], [28], [29],
                        [30], [31], [32], [33], [34], [35], [36], [37], [38], [39],
                        [40], [41], [42], [43], [44], [45], [46], [47], [48], [49],
                        [50], [51], [52], [53], [54], [55], [56], [57], [58], [59],
                        [60], [61], [62], [63], [64], [65], [66], [67], [68], [69],
                        [70], [71], [72], [73], [74], [75], [76], [77], [78], [79],
                        [80], [81], [82], [83], [84], [85], [86], [87], [88], [89],
                        [90], [91], [92], [93], [94], [95], [96], [97], [98], [99],
                        [100], [101], [102], [103], [104], [2222])
    ) AS pivot_table;";

/* SUM OF BOOKED HOURS ON ENTRIES LOGGED BETWEEN MONDAY AND FRIDAY OF THE PREVIOUS WEEK */
$executed_last_week_sql = 
"SELECT ISNULL(CAST(SUM(t0.Quantity) AS DECIMAL(12,0)),0)[Booked Last Week] FROM IIS_EPC_PRO_ORDERT t0
    WHERE t0.Created > DATEADD(WEEK,-1,DATEADD(DAY,-DATEPART(WEEKDAY,GETDATE()),GETDATE())) AND t0.Created < DATEADD(DAY,-DATEPART(WEEKDAY,GETDATE()),GETDATE())";

/* SUM OF BOOKED HOURS ON ENTRIES LOGGED BETWEEN MONDAY THIS WEEK AND TODAY */
$executed_this_week_sql = 
"SELECT ISNULL(CAST(SUM(t0.Quantity) AS DECIMAL(12,0)),0)[Booked This Week] FROM IIS_EPC_PRO_ORDERT t0
    WHERE t0.Created > DATEADD(DAY,-DATEPART(WEEKDAY,GETDATE()),GETDATE())";

/* AVERAGE OF THE TOP 5 WEEKS WITH MOST BOOKED HOURS FROM ENTRIES LOGGED IN THE PREVIOUS 10 STARTING MONDAY 10 WEEKS AGO TO FRIDAY LAST WEEK */
$executed_fwa_sql = 
"SELECT ISNULL(CAST(SUM(t0.[Booked Week Sum])/5 AS DECIMAL (12,0)),0)[Booked Five Week Average] FROM
(
    SELECT ROW_NUMBER() OVER (ORDER BY SUM(t0.Quantity) DESC) [Row Number], SUM(t0.Quantity)[Booked Week Sum], DATEPART(WEEK,t0.Created)[Week] FROM IIS_EPC_PRO_ORDERT t0
        WHERE t0.Created > DATEADD(WEEK,-10,DATEADD(DAY,-DATEPART(WEEKDAY,GETDATE()),GETDATE())) AND t0.Created < DATEADD(DAY,-DATEPART(WEEKDAY,GETDATE()),GETDATE())
            GROUP BY DATEPART(WEEK,t0.Created)
)t0
WHERE t0.[Row Number] <= 5";

/* SUM OF BOOKED HOURS FROM ENRTEIS LOGGED SINCE THE START OF THIS YEAR */
$executed_ytd_sql = 
"SELECT ISNULL(CAST(SUM(t0.Quantity) AS DECIMAL (12,0)),0)[Booked This Year]
    FROM IIS_EPC_PRO_ORDERT t0
        WHERE t0.Created > DATEADD(DAY,-DATEPART(DY,GETDATE()),GETDATE())";


/* SUM OF PROCESSTIME FOR PROCESS ORDERS CREATED BETWEEN MONDAY AND FRIDAY OF THE PREVIOUS WEEK */
$released_last_week_sql = 
"SELECT ISNULL(CAST(SUM(t4.PlannedQty) AS DECIMAL(12,0)),0)[Released Last Week]
FROM WOR1 t4 
       inner join OITM t5 on t4.ItemCode=t5.ItemCode
       inner join OITB t6 on t5.ItmsGrpCod=t6.ItmsGrpCod
       inner join owor t7 on t4.docentry = t7.DocEntry

       WHERE t7.CreateDate > DATEADD(WEEK,-1,DATEADD(DAY,-DATEPART(WEEKDAY,GETDATE()),GETDATE())) AND t7.CreateDate < DATEADD(DAY,-DATEPART(WEEKDAY,GETDATE()),GETDATE())
              AND t7.Status NOT IN ('C')
                      AND t6.ItmsGrpCod not like '%MACHINE%'
                      AND t5.ItemType = 'L'";

/* SUM OF PROCESSTEIM FOR PROCESS ORDERS CREATED BETWEEN MONDAY THIS WEEK AND TODAY */
$released_this_week_sql = 
"SELECT ISNULL(CAST(SUM(t4.PlannedQty) AS DECIMAL(12,0)),0)[Released This Week]
FROM WOR1 t4 
       inner join OITM t5 on t4.ItemCode=t5.ItemCode
       inner join OITB t6 on t5.ItmsGrpCod=t6.ItmsGrpCod
       inner join owor t7 on t4.docentry = t7.DocEntry

       WHERE t7.CreateDate > DATEADD(DAY,-DATEPART(WEEKDAY,GETDATE()),GETDATE())
              AND t7.Status NOT IN ('C')
                      AND t6.ItmsGrpCod not like '%MACHINE%'
                      AND t5.ItemType = 'L'";

/* AVERAGE OF THE TOP 5 WEEKS WITH MOST RELEASED HOURS FROM PROCESS ORDERS CREATED FROM THE PREVIOUS 10 STARTING MONDAY 10 WEEKS AGO TO FRIDAY LAST WEEK */
$released_fwa_sql = 
"SELECT ISNULL(CAST(SUM(t0.[Released Week Sum])/5 AS DECIMAL (12,0)),0)[Released Five Week Average] FROM
(
SELECT ROW_NUMBER() OVER (ORDER BY ISNULL(CAST(SUM(t4.PlannedQty) AS DECIMAL(12,0)),0) DESC) [Row Number], ISNULL(CAST(SUM(t4.PlannedQty) AS DECIMAL(12,0)),0)[Released Week Sum], DATEPART(WEEK,t7.CreateDate)[Week No]
	FROM WOR1 t4 
	inner join OITM t5 on t4.ItemCode=t5.ItemCode
	inner join OITB t6 on t5.ItmsGrpCod=t6.ItmsGrpCod
	inner join owor t7 on t4.docentry = t7.DocEntry
		WHERE t7.CreateDate > DATEADD(WEEK,-10,DATEADD(DAY,-DATEPART(WEEKDAY,GETDATE()),GETDATE())) AND t7.CreateDate < DATEADD(DAY,-DATEPART(WEEKDAY,GETDATE()),GETDATE())
			AND t7.Status NOT IN ('C')
			AND t6.ItmsGrpCod not like '%MACHINE%'
			AND t5.ItemType = 'L'
		GROUP BY DATEPART(WEEK,t7.CreateDate)
)t0
WHERE t0.[Row Number] <= 5";

/* SUM OF PROCESSTIME FROM PROCESS ORDERS CREATED SINCE THE START OF THIS YEAR */
$released_ytd_sql = 
"SELECT ISNULL(CAST(SUM(t4.PlannedQty) AS DECIMAL(12,0)),0)[Released YTD]
FROM WOR1 t4 
       inner join OITM t5 on t4.ItemCode=t5.ItemCode
       inner join OITB t6 on t5.ItmsGrpCod=t6.ItmsGrpCod
       inner join owor t7 on t4.docentry = t7.DocEntry

       WHERE t7.CreateDate > DATEADD(DAY,-DATEPART(DY,GETDATE()),GETDATE())
              AND t7.Status NOT IN ('C')
                      AND t6.ItmsGrpCod not like '%MACHINE%'
                      AND t5.ItemType = 'L'";

/* LIVE PO COUNT */
$live_po_count_sql = 
"SELECT COUNT(PrOrder)
    FROM IIS_EPC_PRO_ORDERH t0
    INNER JOIN OWOR t1 ON t1.U_IIS_proPrOrder = t0.PrOrder
        WHERE t0.Status IN ('I','S')";

/* LIVE COMP PO COUNT */
$live_po_count_comp_sql = 
"SELECT COUNT(PrOrder)
    FROM IIS_EPC_PRO_ORDERH t0
    LEFT JOIN OWOR t1 ON t1.U_IIS_proPrOrder = t0.PrOrder AND t1.ItemCode = t0.EndProduct
        WHERE t0.Status IN ('I','S') AND t1.CmpltQty >= t1.PlannedQty";

/* OPEN HOURS ON FLOOR */
/*Changed 18 September 2023 query slowed*/
$open_hours_on_floor_sql = "SELECT SUM(CASE 
WHEN (t2.[_Lab] - ISNULL(t3.[Actual_Lab],0)) < 0 THEN 0
ELSE CAST(t2.[Planned_Lab] AS DECIMAL (12,0)) - CAST(ISNULL(t3.[Actual_Lab],0) AS DECIMAL (12,0))
END)[Remaining_Lab]



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

WHERE t1.CmpltQty < t1.PlannedQty AND 
   t0.Status NOT IN ('D','C') AND 
   t1.Status NOT IN ('C','L') AND 
   t5.U_PP_status IN ('Live','1001')
";



?>