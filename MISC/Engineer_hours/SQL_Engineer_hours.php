<?php
$engr="SELECT 
t1.sales_order AS Sales_Order, 
t2.DocEntry,
t1.Engineer_name,
t2.CardName,t2.U_Dimension1,
t2.U_Client[Project Name],
t1.Engineer_hrs,
FORMAT(t1.Date, 'dd-MM-yyyy') AS Date,
YEAR(t1.Date) AS Year,
DATEPART(ISO_WEEK, t1.Date) AS WeekNumber
FROM ENGINEER_HRS.dbo.Engrhrs_table01 t1
LEFT JOIN KENTSTAINLESS.dbo.ordr t2 ON TRY_CAST(TRIM(t1.Sales_order) AS INT) = t2.DocNum
WHERE 
t1.sales_order IS NOT NULL
AND (ISNUMERIC(t1.sales_order) = 1 OR ISNUMERIC(t1.sales_order) = 0)

";
