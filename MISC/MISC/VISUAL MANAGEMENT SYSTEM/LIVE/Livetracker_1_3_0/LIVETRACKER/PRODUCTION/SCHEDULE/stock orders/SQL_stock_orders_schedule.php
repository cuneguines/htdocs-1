<?php
$tsql =
"SELECT
/* SALES ORDER RELATED CONTENT (SELF DEFINED IN THIS CASE) */
000000 [Sales Order],
'Kent Stainless'[Customer],
ISNULL(t5.U_Product_Group_One, '000_NO GROUP_000') [Project],
'Peter Edwards' [Sales Person],
DATEDIFF(DAY,  t0.CreateDate, GETDATE()) [Days Open],
DATEPART(ISO_WEEK, t0.CreateDate) [Week Opened],
DATEDIFF(WEEK, t0.CreateDate, GETDATE()) [Weeks Open],
DATEDIFF(month, GETDATE(), t0.DueDate) [Month Difference],
CASE 
    WHEN ISNULL(DATEDIFF(WEEK,GETDATE(),t0.DueDate),".($start_range-1).") < ".$start_range." THEN ".($start_range -1)."
    WHEN ISNULL(DATEDIFF(WEEK,GETDATE(),t0.DueDate),".($start_range-1).") > ".$end_range." AND ISNULL(DATEDIFF(WEEK,GETDATE(),t0.DueDate),".($start_range-1).") < ".($end_range + 13)." THEN ".($end_range +1)."
    WHEN ISNULL(DATEDIFF(WEEK,GETDATE(),t0.DueDate),".($start_range-1).") >= ".($end_range+13)." AND ISNULL(DATEDIFF(WEEK,GETDATE(),t0.DueDate),".($start_range-1).") < ".($end_range + 26)." THEN ".($end_range +2)."
    WHEN ISNULL(DATEDIFF(WEEK,GETDATE(),t0.DueDate),".($start_range-1).") >= ".($end_range+26)." THEN ".($end_range +3)."
    ELSE ISNULL(DATEDIFF(WEEK,GETDATE(),t0.DueDate),".($start_range-1).")
END [Promise Diff Week],

/* SALES ORDER ITEMS RELATED CONTENT (SELF DEFINED OR USES PRODUCTION ORDER DETAILS IN THIS CASE)*/
t5.ItemName[Dscription],
(CASE WHEN (t6.ItmsGrpNam LIKE 'LABOUR SITE' OR t6.ItmsGrpNam LIKE 'TRAINING' OR t6.ItmsGrpNam LIKE 'Documents & Manuals' OR t6.ItmsGrpNam LIKE 'Contract Phased Sale') THEN 'yes' ELSE 'no' END) [Non Deliverable],
CAST(t0.plannedqty AS DECIMAL (12,1)) [Quantity],
CAST(t5.OnHand AS DECIMAL (12,1)) [OnHand],
CONVERT(DATE,(t0.DueDate)) [Promise Date],
(CASE 
    WHEN DATEPART(iso_week,t0.DueDate) = 53 THEN 52 
    WHEN DATEPART(iso_week,t0.DueDate) IS NULL THEN 52
    ELSE DATEPART(iso_week,t0.DueDate) 
END) [Promise Week Due],
t2.U_NAME [Engineer],
NULL [risk],
'Live' [Status],
'N/A' [Stage],
'N/A' [Paused],
t7.Remarks [Comments],

/* PROCESS ORDER AND PRODUCTION RELATED CONTENT */
t0.U_IIS_proPrOrder [Process Order],
ISNULL(CAST(t11.Planned_Lab AS DECIMAL(12,0)),0)[Planned Hrs],
FORMAT(t0.U_FloorDate , 'dd-MM-yyyy')[Floor Date],
DATEDIFF(WEEK, t0.U_FLOORDATE, GETDATE())[Weeks On Floor],
NULL [Sub Contract Status],
CAST(t0.PlannedQty - t0.CmpltQty AS DECIMAL(12,0)) [Complete],
CAST((CASE
    WHEN CAST(t0.PlannedQty - t0.CmpltQty AS DECIMAL(12,0)) <= 0 THEN 0
                ELSE 
        (CASE
            WHEN t0.CmpltQty < t0.PlannedQty THEN CASE WHEN ISNULL(ISNULL(t11.[Planned_Lab],0)-ISNULL(t10.[Actual_Lab],0),t11.[Planned_Lab])  < 0 THEN 0 ELSE ISNULL(ISNULL(t11.[Planned_Lab],0)-ISNULL(t10.[Actual_Lab],0),t11.[Planned_Lab]) END
            ELSE 0 
        END)
END) AS DECIMAL (12,0)) [Est Prod Hrs]
 
FROM owor t0
 
inner join ousr t2 on t2.USERID= t0.UserSign
INNER JOIN oitm t5 on t5.ItemCode = t0.ItemCode
INNER JOIN oitb t6 on t6.ItmsGrpCod = t5.ItmsGrpCod
LEFT JOIN IIS_EPC_PRO_ORDERH t7 ON t7.PrOrder = t0.U_IIS_proProrder
 
LEFT JOIN 
(SELECT t0.PrOrder, t1.EndProduct, 
        SUM(t0.Quantity) [Actual_Lab]
        FROM iis_epc_pro_ordert t0  
                   inner join iis_epc_pro_orderh t1 on t1.PrOrder = t0.PrOrder
        GROUP BY t0.PrOrder, t1.EndProduct
) t10 ON t10.PrOrder = t0.U_IIS_proProrder and t10.EndProduct = t0.ItemCode
LEFT JOIN 
(SELECT t1.U_IIS_proPrOrder, t1.ItemCode,
        SUM(t0.plannedqty) [Planned_Lab]
        FROM wor1 t0
            INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry                            
            INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode               
            WHERE t2.ItemType = 'L'                         
            GROUP BY t1.U_IIS_proPrOrder,t1.ItemCode
) t11 ON t11.U_IIS_proPrOrder = t0.U_IIS_proPrOrder and t11.ItemCode = t0.ItemCode
 
WHERE t0.Status not in ('D','L','C')
and t0.OriginNum is null
 
ORDER BY [Project] ASC";
?>