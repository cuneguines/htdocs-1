<?php
$sql_operator_hours_pivot = 
"SELECT * FROM(
    SELECT 
        CONVERT(INT,t0.UserId)[UserId],
        t1.firstName + ' ' + t1.lastName [Name],
        DATEPART(YEAR,t0.Created)[Year],
        DATEPART(ISO_WEEK,t0.CREATED)[Week],
        CASE
            WHEN DATEPART(WEEKDAY,t0.CREATED) = 2 THEN 'Monday'
            WHEN DATEPART(WEEKDAY,t0.CREATED) = 3 THEN 'Tuesday'
            WHEN DATEPART(WEEKDAY,t0.CREATED) = 4 THEN 'Wednesday'
            WHEN DATEPART(WEEKDAY,t0.CREATED) = 5 THEN 'Thursday'
            WHEN DATEPART(WEEKDAY,t0.CREATED) = 6 THEN 'Friday'
            WHEN DATEPART(WEEKDAY,t0.CREATED) = 7 THEN 'Saturday'
            WHEN DATEPART(WEEKDAY,t0.CREATED) = 1 THEN 'Sunday'
        END[WeekDay],
        CAST(ISNULL(t0.Quantity,0) AS DECIMAL(12,2)) [Hours]
        FROM IIS_EPC_PRO_ORDERT t0
        LEFT JOIN OHEM t1 ON t0.UserId = t1.empID
            WHERE t0.Created > DATEADD(WEEK,-$week_hist,DATEADD(DAY,-DATEPART(WEEKDAY,GETDATE()),GETDATE())) and t0.LabourCode ='3000623'
    ) t0
    
    PIVOT
    (
        SUM([Hours])
        FOR [WeekDay]
        IN (
            [Monday],
            [Tuesday],
            [Wednesday],
            [Thursday],
            [Friday],
            [Saturday],
            [Sunday]
        )
    
    ) AS PivotTable
    
    ORDER BY PivotTable.UserID, PivotTable.Year, PivotTable.Week
    ";

$sql_operator_entries =
"SELECT

ISNULL(t3.SOnum,'STOCK ORDER') [Sales Order],
t0.prorder [Process Order],
CAST(t0.Quantity AS DECIMAL (12,2))[Hours],
t0.Created [Date of Entry],
DATEPART (ISO_WEEK, t0.Created) [Week no.],
datepart (ISO_WEEK, getdate()) [This week No.], 
CASE
    WHEN DATEPART(WEEKDAY,t0.CREATED) = 2 THEN 'mon'
    WHEN DATEPART(WEEKDAY,t0.CREATED) = 3 THEN 'tue'
    WHEN DATEPART(WEEKDAY,t0.CREATED) = 4 THEN 'wed'
    WHEN DATEPART(WEEKDAY,t0.CREATED) = 5 THEN 'thu'
    WHEN DATEPART(WEEKDAY,t0.CREATED) = 6 THEN 'fri'
    WHEN DATEPART(WEEKDAY,t0.CREATED) = 7 THEN 'sat'
    WHEN DATEPART(WEEKDAY,t0.CREATED) = 1 THEN 'sun'
END[Weekday],
t0.labourcode,
t2.ItemName [Labour Name],
t3.EndProduct, 
(case when t0.userid is not null then  (t1.firstname + ' ' + t1.lastname) else 'Unknown' end) as 'Operator', t0.UserId [Employee Number],
t0.RecId,
t4.ItemName,
t44.CardName,
(case when t3.endproduct = '1000000' then t0.Quantity else '0' end) [NP Time],
t5.Name,
DATEPART (YEAR, t0.Created) [Year]


FROM IIS_EPC_PRO_ORDERT t0

RIGHT JOIN ohem t1 on t0.userid = t1.empid
JOIN oitm t2 on t0.labourcode = t2.ItemCode 
JOIN IIS_EPC_PRO_ORDERH t3 on t0.prorder = t3.PrOrder


LEFT JOIN(
    SELECT t1.itemcode, t1.ItemName FROM OITM t1
) t4 ON t3.endproduct = t4.itemcode
LEFT JOIN(
    SELECT t11.CardName,t11.DocNum FROM ordr t11
) t44 ON t44.DocNum =t3.SONum

LEFT JOIN oubr t5 on t5.Code = t1.branch

--inner join owor t1 on t1.U_IIS_proPrOrder = t0.PrOrder and t1.ItemCode = t0.EndProduct  
WHERE t0.userid is not null and t1.U_IIS_disEmpPin <> '505' and t1.U_IIS_disEmpPin <> '514' and t0.LabourCode <> '3000004' and t0.LabourCode <> '2999999' AND t0.Created > DATEADD(WEEK,-$week_hist,DATEADD(DAY,-DATEPART(WEEKDAY,GETDATE()),GETDATE()))
and t0.Labourcode='3000623'
GROUP BY  t0.prorder , t3.SONum , t0.Quantity, t0.Created, t0.labourcode, t44.CardName,t2.ItemName , t3.EndProduct, (case when t0.userid is not null then  (t1.firstname + ' ' + t1.lastname) else 'Unknown' end), t0.UserId, t4.ItemName, t0.recid, t5.Name

ORDER BY [Date of Entry] DESC


";          
?>