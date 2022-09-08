<?php
$process_order_step_efficiency_sql = 
"with user_hours as (select t0.PrOrder, t0.UserId, sum(isnull(t0.quantity,0)) [Hours]
from iis_epc_pro_ordert t0
group by t0.PrOrder, t0.UserId),

max_hours as (select t0.PrOrder, MAX(t0.Hours) [max_hours]
from user_hours t0
group by t0.PrOrder
),
max_user as (select t0.PrOrder, MAX(t0.UserId) [Max_User]
from user_hours t0
inner join max_hours t1 on t1.PrOrder = t0.PrOrder and t1.max_hours = t0.Hours
inner join iis_epc_pro_orderh t2 on t2.PrOrder = t0.PrOrder
inner join owor t3 on t3.U_IIS_proPrOrder = t0.PrOrder and t3.ItemCode = t2.EndProduct and t3.Status <> 'C'
where t3.cardcode = 'INT002'
and t0.Hours > 0
group by t0.PrOrder) 



SELECT 
t0.Originnum [Sales Order],
t0.U_IIS_proPrOrder [Process Order],
FORMAT(CAST(t5.DocDueDate AS DATE), 'dd-MM-yyyy') [Promise Date],
t9.ItemName,
t9.ItemCode,
t21.Most_Hours[Most_Hours],
t5.CardName [Customer], 
(case when t1.EndProduct = t0.ItemCode then 'End Product' else 'Sub Component' end) [Type],
ISNULL(t5.U_Client, 'NO PROJECT') [Project], 
t0.CloseDate,
CAST(isnull(t10.Planned_Lab,0) AS DECIMAL (12,0)) [Total Planned Time],
CAST(isnull(t11.Actual_lab,0) AS DECIMAL (12,0)) [Total Act Time],
FORMAT(isnull(t11.Actual_Lab/t10.Planned_Lab,0),'P0') [Labour Efficiency],
isnull(t21.Most_Hours,'No Hours Booked') [Most Hours], isnull(t22.U_Floor_date, t5.U_floordate) [Floordate],
CAST(t5.DocDueDate AS DATE)[Due_Date],  
t7.firstname + ' ' + t7.lastName [Sales Person],   
t8.SlpName [Engineer],
CASE WHEN t0.CmpltQty >= t0.PlannedQty THEN 'Y' ELSE 'N' END [Complete],

t14.[SEQ001],                    t14.[SEQ002],                    t14.[SEQ003],                    t14.[SEQ004],
t14.[SEQ005],                    t14.[SEQ006],                    t14.[SEQ007],                    t14.[SEQ008],
t14.[SEQ009],                    t15.Actual_Old_Fab as [SEQ010],                                            t14.[SEQ010A],
t14.[SEQ010B],                 t14.[SEQ010C],                 t14.[SEQ010D],                 t14.[SEQ010E],
t14.[SEQ011],                    t14.[SEQ012],                    t14.[SEQ013],                    t14.[SEQ014],
t14.[SEQ015],                    t14.[SEQ016],                    t14.[SEQ017],                    t14.[SEQ018],
t14.[SEQ019],                    t14.[SEQ020],                    t14.[SEQ021],                    t14.[SEQ022],
t14.[SEQ023],                    t14.[SEQ024],                    t14.[SEQ025],                    t14.[SEQ026],
t14.[SEQ027],                    t14.[SEQ028],                    t14.[SEQ029],                    t14.[SEQ030],
t14.[SEQ031]

from owor t0

inner join ordr t5 on t5.docnum = t0.OriginNum
inner join ohem t7 on t7.empID = t5.OwnerCode
inner join oslp t8 on t8.SlpCode = t5.SlpCode
left join IIS_EPC_PRO_ORDERH t1 on t1.PrOrder = t0.U_IIS_proPrOrder
inner join oitm t9 on t9.ItemCode = t0.ItemCode
inner join IIS_EPC_PRO_ORDERL t16 on t16.PrOrder = t0.U_IIS_proPrOrder and t16.StepItem = t0.ItemCode

left join (                       
select t1.DocNum, sum(t0.plannedqty) [Planned_Lab]                             
from wor1 t0                             
inner join owor t1 on t1.DocEntry = t0.DocEntry                            
inner join oitm t2 on t2.ItemCode = t0.ItemCode                            
where t2.ItemType = 'L'                         
group by t1.DocNum
)t10 on t10.DocNum = t0.DocNum

left join (
select t1.PrOrder, t5.Stepitem, sum(t0.Quantity) [Actual_Lab]                           
from iis_epc_pro_ordert t0
inner join iis_epc_pro_orderh t1 on t1.PrOrder = t0.PrOrder
inner join iis_epc_pro_orderl t4 on t4.lineid = t0.LineID and t4.PrOrder = t0.PrOrder
inner join iis_epc_pro_orderl t5 on t5.PrOrder = t0.PrOrder and t5.LineID = t4.ParentLine
group by t1.PrOrder, t5.Stepitem
)t11 on t11.PrOrder = t0.U_IIS_proPrOrder and t11.StepItem = t0.ItemCode


left join (
select t0.DocNum, 
[SEQ001],                       [SEQ002],                           [SEQ003],                           [SEQ004],
[SEQ005],                       [SEQ006],                           [SEQ007],                           [SEQ008],
[SEQ009],                       [SEQ010A],                        [SEQ010B],                        [SEQ010C],
[SEQ010D],                    [SEQ010E],                         [SEQ011],                           [SEQ012],
[SEQ013],                       [SEQ014],                           [SEQ015],                           [SEQ016],
[SEQ017],                       [SEQ018],                           [SEQ019],                           [SEQ020],
[SEQ021],                       [SEQ022],                           [SEQ023],                           [SEQ024],
[SEQ025],                       [SEQ026],                           [SEQ027],                           [SEQ028],
[SEQ029],                       [SEQ030],                           [SEQ031]

from (
select t1.docnum, t1.[Labour_Sequence], (isnull(t2.Actual_Lab,0)/t1.Planned_Lab) [Lab_Status]
from (
select t1.docnum, t2.U_OldCode [Labour_Sequence], sum(t0.plannedqty) [Planned_Lab]
from wor1 t0
inner join owor t1 on t1.DocEntry = t0.DocEntry
inner join oitm t2 on t2.ItemCode = t0.ItemCode

where t2.ItemType = 'L' and t1.Status <> 'C'
group by t1.docnum, t2.U_OldCode
) t1

left join (
select t3.docnum, t2.U_OldCode [Labour_Sequence], sum(t0.Quantity) [Actual_Lab]                           
from iis_epc_pro_ordert t0
inner join iis_epc_pro_orderh t1 on t1.PrOrder = t0.PrOrder
inner join iis_epc_pro_orderl t4 on t4.lineid = t0.LineID and t4.PrOrder = t0.PrOrder
inner join iis_epc_pro_orderl t5 on t5.PrOrder = t0.PrOrder and t5.LineID = t4.ParentLine
inner join oitm t2 on t2.ItemCode = t0.LabourCode
inner join owor t3 on t3.U_IIS_proPrOrder = t1.PrOrder and t3.ItemCode = t5.stepitem
group by t3.docnum, t2.U_OldCode
)t2 on t2.docnum = t1.docnum and t2.Labour_Sequence = t1.[Labour_Sequence]      
)as t0

PIVOT (SUM([Lab_Status])
FOR t0.[Labour_Sequence] IN (
[SEQ001], [SEQ002],[SEQ003], [SEQ004],
[SEQ005], [SEQ006],[SEQ007], [SEQ008],
[SEQ009], [SEQ010A],[SEQ010B],[SEQ010C],
[SEQ010D],[SEQ010E],
[SEQ011], [SEQ012],
[SEQ013], [SEQ014],[SEQ015], [SEQ016],
[SEQ017], [SEQ018],[SEQ019], [SEQ020],
[SEQ021], [SEQ022],[SEQ023], [SEQ024],
[SEQ025], [SEQ026],[SEQ027], [SEQ028],
[SEQ029], [SEQ030],[SEQ031]))
as t0
)t14 on t14.DocNum = t0.DocNum

left join (
select t1.PrOrder, t5.Stepitem, sum(t0.Quantity) [Actual_Old_Fab]                           
from iis_epc_pro_ordert t0
inner join oitm t2 on t2.ItemCode = t0.LabourCode
inner join iis_epc_pro_orderh t1 on t1.PrOrder = t0.PrOrder
inner join iis_epc_pro_orderl t4 on t4.lineid = t0.LineID and t4.PrOrder = t0.PrOrder
inner join iis_epc_pro_orderl t5 on t5.PrOrder = t0.PrOrder and t5.LineID = t4.ParentLine
where t2.itemname = 'Fabrication'  
group by t1.PrOrder, t5.Stepitem
)t15 on t15.PrOrder = t0.U_IIS_proPrOrder and t15.StepItem = t0.ItemCode


left join (
select distinct t0.PrOrder, t0.[Max_User], (t1.firstname + ' ' + t1.lastname) [Most_Hours]

from max_user t0
inner join ohem t1 on t1.empID = t0.Max_User) t21 on t21.PrOrder = t0.U_IIS_proPrOrder

left join rdr1 t22 on t22.DocEntry = t5.DocEntry and t22.ItemCode = t0.ItemCode


where 1 = 1 and t5.CANCELED <> 'Y' and t0.Status <> 'C'
AND t1.Status IN ('P','R','S','I')
and isnull(t22.U_Floor_date, t5.U_floordate) is not null
and t0.CardCode = 'INT002'
order by t0.U_IIS_proPrOrder, t16.LineID"

;

$sql_step_lookup = 
"SELECT t0.PrORder[Process Order], t0.LineID[Sub Item Line ID], t0.StepItem[Sub Item Code], t0.StepDesc, t1.StepItem, t1.StepDesc, t2.U_OldCode[Sequence Code], t1.LineID[Step Line ID], t1.Status[Step Status], t1.ProcessTime, t4.BookedTime FROM IIS_EPC_PRO_ORDERL t0
LEFT JOIN IIS_EPC_PRO_ORDERL t1 ON t1.PrORder = t0.PrORder AND t1.ParentLine = t0.LineID
LEFT JOIN OITM t2 ON t2.ItemCode = t1.StepItem
LEFT JOIN IIS_EPC_pro_ORDERH t3 ON t3.PrORder = t0.PrORder
LEFT JOIN(
    SELECT PrORder, LineID, SUM(Quantity)[BookedTime] 
        FROM IIS_EPC_PRO_ORDERT 
            GROUP BY PrORder, LineID
)t4 ON t4.PrORder = t0.PrORder AND t4.LineID = t1.LineID

    WHERE t0.Steptype = 'B' AND t0.UseStock IN ('N') AND t1.UseStock IN ('N') AND t3.Status IN ('P','R','S','I')
    ORDER BY t0.PrOrder, t0.LineID, t1.LineID";

$sql_logged_entries = 
"SELECT 
    t0.PrOrder, t1.U_OldCode, t0.UserId, t0.LineID, t2.firstName + ' ' + t2.lastName[Name], t0.Quantity[Qty], FORMAT(t0.Created, 'dd-MM-yyyy')[Date], t0.Remarks
        FROM IIS_EPC_PRO_ORDERT t0
        LEFT JOIN OITM t1 ON t1.ItemCode = t0.LabourCode
        LEFT JOIN OHEM t2 ON t2.EmpID = t0.UserId
        LEFT JOIN IIS_EPC_PRO_ORDERH t4 ON t4.PrOrder = t0.PrOrder
            WHERE t1.U_OldCode LIKE '%SEQ%' AND t4.Status IN ('P','R','S','I')
                ORDER BY t0.PrOrder DESC, t0.LineID, t1.U_OldCode, t0.Created ASC
    ";

$sql_step_remarks = "SELECT 
t0.PrOrder, t1.U_OldCode, t0.UserId, t0.LineID, t2.firstName + ' ' + t2.lastName[Name], FORMAT(t0.Created, 'dd-MM-yyyy')[Date], t0.Remarks
    FROM IIS_EPC_PRO_ORDERT t0
    LEFT JOIN OITM t1 ON t1.ItemCode = t0.LabourCode
    LEFT JOIN OHEM t2 ON t2.EmpID = t0.UserId
    LEFT JOIN IIS_EPC_PRO_ORDERH t4 ON t4.PrOrder = t0.PrOrder
        WHERE t1.U_OldCode LIKE '%SEQ%' AND t4.Status IN ('P','R','S','I') AND t0.Remarks <> ''
            ORDER BY t0.PrOrder DESC, t1.U_OldCode, t0.Created ASC";