<?php
$purchasing =
"SELECT 
T0.[DocNum] [Purchase Order Number], 
T0.DocNum,
FORMAT(cast(T0.[DocDueDate] as date),'dd-MM-yyyy')[Due Date], 
T1.[U_In_Sub_con][Sub Contract Status],
T0.Comments,
CASE 
WHEN DATEDIFF(DAY,GETDATE(),T0.[DocDueDate]) < -14 THEN -6
WHEN DATEDIFF(DAY,GETDATE(),T0.[DocDueDate]) >= -14 AND DATEDIFF(DAY,GETDATE(),T0.[DocDueDate]) < -7 THEN -5
WHEN DATEDIFF(DAY,GETDATE(),T0.[DocDueDate]) >= -7 AND DATEDIFF(DAY,GETDATE(),T0.[DocDueDate]) <= -4 THEN -4
WHEN DATEDIFF(DAY,GETDATE(),T0.[DocDueDate]) =-1 THEN -1
WHEN DATEDIFF(DAY,GETDATE(),T0.[DocDueDate]) =-2 THEN -2
WHEN DATEDIFF(DAY,GETDATE(),T0.[DocDueDate]) =-3 THEN -3
WHEN DATEDIFF(DAY,GETDATE(),T0.[DocDueDate]) >= 15 THEN 14
WHEN DATEDIFF(DAY,GETDATE(),T0.[DocDueDate]) = 6 THEN 6
WHEN DATEDIFF(DAY,GETDATE(),T0.[DocDueDate]) = 7 THEN 7
WHEN DATEDIFF(DAY,GETDATE(),T0.[DocDueDate]) = 8 THEN 8
WHEN DATEDIFF(DAY,GETDATE(),T0.[DocDueDate]) = 9 THEN 9
WHEN DATEDIFF(DAY,GETDATE(),T0.[DocDueDate]) = 10 THEN 10
WHEN DATEDIFF(DAY,GETDATE(),T0.[DocDueDate]) = 11 THEN 11
WHEN DATEDIFF(DAY,GETDATE(),T0.[DocDueDate]) = 12 THEN 12
ELSE DATEDIFF(DAY,GETDATE(),T0.[DocDueDate])
END [Promise Diff Week], /* DAYS HERE */
CASE 
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),T0.[DocDueDate]) = 0 THEN 'Monday'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),T0.[DocDueDate]) =1 THEN 'Tuesday'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),T0.[DocDueDate]) =2 THEN 'Wednesday'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),T0.[DocDueDate]) =3 THEN 'Thursday'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),T0.[DocDueDate]) =4 THEN 'Friday'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),T0.[DocDueDate]) =5 THEN 'Saturday'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),T0.[DocDueDate]) =6 THEN 'Sunday'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),T0.[DocDueDate]) =7 THEN 'MNW'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),T0.[DocDueDate]) =8 THEN 'TNW'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),T0.[DocDueDate]) =9 THEN 'WNW'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),T0.[DocDueDate]) =10 THEN 'THNW'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),T0.[DocDueDate]) =11 THEN 'FNW'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),T0.[DocDueDate]) =13 THEN 'MNNW'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),T0.[DocDueDate]) =14 THEN 'TNNW'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),T0.[DocDueDate]) =15 THEN 'WNNW'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),T0.[DocDueDate]) =16 THEN 'TNNW'
WHEN DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),T0.[DocDueDate]) <-4 THEN 'Other'
when  DATEDIFF(DAY,DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE()),T0.[DocDueDate]) =-3 THEN 'LastworkingDay'


ELSE 'Ot'



END [Days of the Week], /* DAYS HERE */
case
when  DATEDIFF(DAY,getdate(),T0.[DocDueDate]) =-3 THEN 'LastthreeDays'
when  DATEDIFF(DAY,getdate(),T0.[DocDueDate]) =-2 THEN 'LastthreeDays'
when  DATEDIFF(DAY,getdate(),T0.[DocDueDate]) =-1 THEN 'LastthreeDays'
END [Last three days], /* DAYS HERE */
case
when  DATEDIFF(DAY,getdate(),T0.[DocDueDate]) =-5 THEN 'LastfiveDays'
when  DATEDIFF(DAY,getdate(),T0.[DocDueDate]) =-4 THEN 'LastfiveDays'
when  DATEDIFF(DAY,getdate(),T0.[DocDueDate]) =-3 THEN 'LastfiveDays'
when  DATEDIFF(DAY,getdate(),T0.[DocDueDate]) =-2 THEN 'LastfiveDays'
when  DATEDIFF(DAY,getdate(),T0.[DocDueDate]) =-1 THEN 'LastfiveDays'
END [Last five days], /* DAYS HERE */

FORMAT(t0.docdate,'dd-MM-yyyy') [Order Date],
FORMAT(cast(T0.[DocDueDate] as date),'dd-MM-yyyy')[Due Date], 
T0.[CardName][Project],
cast(T1.[Quantity] as decimal)[Quantity], 
cast((t1.[Quantity]-T1.openqty)as decimal)[OutQty],
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