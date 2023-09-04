<?php
$purchasing =
"SELECT 
T0.[DocNum] [Purchase Order Number], 
T0.DocNum,
FORMAT(cast(T0.[DocDueDate] as date),'dd-MM-yyyy')[Due Date], 
T1.[U_In_Sub_con][Sub Contract Status],
T0.Comments,
T1.LineStatus,
T2.AvgPrice,
T1.U_BOY_38_EXT_REM[comment2],

case when cast(T1.[Quantity] as decimal) > cast(T1.openqty as decimal) then 'Partial_del' end [Partial_del],
case when DATEDIFF(DAY,GETDATE(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date))>= 15 THEN 14 end[test],
CASE 
WHEN DATEDIFF(DAY,GETDATE(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) < -14 THEN -6
WHEN DATEDIFF(DAY,GETDATE(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) >= -14 AND DATEDIFF(DAY,GETDATE(), cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) < -7 THEN -5
WHEN DATEDIFF(DAY,GETDATE(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) >= -7 AND DATEDIFF(DAY,GETDATE(), cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) <= -4 THEN -4
WHEN DATEDIFF(DAY,GETDATE(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =-1 THEN -1
WHEN DATEDIFF(DAY,GETDATE(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =-2 THEN -2
WHEN DATEDIFF(DAY,GETDATE(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =-3 THEN -3
WHEN DATEDIFF(DAY,GETDATE(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) >= 15 THEN 14
WHEN DATEDIFF(DAY,GETDATE(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) = 6 THEN 6
WHEN DATEDIFF(DAY,GETDATE(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) = 7 THEN 7
WHEN DATEDIFF(DAY,GETDATE(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) = 8 THEN 8
WHEN DATEDIFF(DAY,GETDATE(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) = 9 THEN 9
WHEN DATEDIFF(DAY,GETDATE(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) = 10 THEN 10
WHEN DATEDIFF(DAY,GETDATE(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) = 11 THEN 11
WHEN DATEDIFF(DAY,GETDATE(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) = 12 THEN 12

ELSE DATEDIFF(DAY,GETDATE(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date))

END [Promise Diff Week], /* DAYS HERE */
CASE 
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) = 0 THEN 'Monday'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =1 THEN 'Tuesday'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =2 THEN 'Wednesday'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =3 THEN 'Thursday'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =4 THEN 'Friday'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =5 THEN 'Saturday'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =6 THEN 'Sunday'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =7 THEN 'MNW'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =8 THEN 'TNW'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =9 THEN 'WNW'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =10 THEN 'THNW'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =11 THEN 'FNW'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =13 THEN 'MNNW'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =14 THEN 'TNNW'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =15 THEN 'WNNW'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =16 THEN 'TNNW'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) <=-3 THEN 'Other'
--when  DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),T0.[DocDueDate]) =-3 THEN 'LastworkingDay'


ELSE 'Ot'



END [Days of the Week], /* DAYS HERE */
case
when  DATEDIFF(DAY,getdate(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =-3 THEN 'LastthreeDays'
when  DATEDIFF(DAY,getdate(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =-2 THEN 'LastthreeDays'
when  DATEDIFF(DAY,getdate(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =-1 THEN 'LastthreeDays'
END [Last three days], /* DAYS HERE */
case
when  DATEDIFF(DAY,getdate(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =-5 THEN 'LastfiveDays'
when  DATEDIFF(DAY,getdate(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =-4 THEN 'LastfiveDays'
when  DATEDIFF(DAY,getdate(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =-3 THEN 'LastfiveDays'
when  DATEDIFF(DAY,getdate(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =-2 THEN 'LastfiveDays'
when  DATEDIFF(DAY,getdate(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =-1 THEN 'LastfiveDays'
END [Last five days], /* DAYS HERE */
case 
when DATEDIFF(DAY,getdate(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) < 0 THEN 'Late'
 when DATEDIFF(DAY,getdate(),cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date)) =0 THEN 'On time'
 
end [Date_delay],

case when cast(T1.[Quantity] as decimal) > cast(T1.openqty as decimal) then 'Partial_del' end [Partial_del],
FORMAT(t0.docdate,'dd-MM-yyyy') [Order Date],
FORMAT(cast(COALESCE(T1.U_del_date_rev2,T1.U_del_date_rev1,T1.ShipDate,T0.[DocDueDate] )as date),'dd-MM-yyyy')[Due Date],
---FORMAT(cast(T0.[DocDueDate] as date),'dd-MM-yyyy')[Due Date], 
T0.[CardName][Project],
cast(T1.[Quantity] as decimal)[Quantity], 
cast(T1.openqty as decimal)[OutQty],
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
ORDER BY T0.[CardName]

";
?>