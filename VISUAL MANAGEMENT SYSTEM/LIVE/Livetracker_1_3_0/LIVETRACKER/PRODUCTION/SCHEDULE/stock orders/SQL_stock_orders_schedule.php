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
    WHEN ISNULL(DATEDIFF(WEEK,GETDATE(),t77.[Earliest Promise Date]),".($start_range-1).") < ".$start_range." THEN ".($start_range -1)."
    WHEN ISNULL(DATEDIFF(WEEK,GETDATE(),t77.[Earliest Promise Date]),".($start_range-1).") > ".$end_range." AND ISNULL(DATEDIFF(WEEK,GETDATE(),t77.[Earliest Promise Date]),".($start_range-1).") < ".($end_range + 13)." THEN ".($end_range +1)."
    WHEN ISNULL(DATEDIFF(WEEK,GETDATE(),t77.[Earliest Promise Date]),".($start_range-1).") >= ".($end_range+13)." AND ISNULL(DATEDIFF(WEEK,GETDATE(),t77.[Earliest Promise Date]),".($start_range-1).") < ".($end_range + 26)." THEN ".($end_range +2)."
    WHEN ISNULL(DATEDIFF(WEEK,GETDATE(),t77.[Earliest Promise Date]),".($start_range-1).") >= ".($end_range+26)." THEN ".($end_range +3)."
    ELSE ISNULL(DATEDIFF(WEEK,GETDATE(),t77.[Earliest Promise Date]),".($start_range-1).")
END [Promise Diff Week],

/* SALES ORDER ITEMS RELATED CONTENT (SELF DEFINED OR USES PRODUCTION ORDER DETAILS IN THIS CASE)*/
t5.ItemName[Dscription],
(CASE WHEN (t6.ItmsGrpNam LIKE 'LABOUR SITE' OR t6.ItmsGrpNam LIKE 'TRAINING' OR t6.ItmsGrpNam LIKE 'Documents & Manuals' OR t6.ItmsGrpNam LIKE 'Contract Phased Sale') THEN 'yes' ELSE 'no' END) [Non Deliverable],
CAST(t0.plannedqty AS DECIMAL (12,1)) [Quantity],
CAST(t5.OnHand AS DECIMAL (12,1)) [OnHand],
CONVERT(DATE,(t77.[Earliest Promise Date])) [Promise Date],
(CASE 
    WHEN DATEPART(iso_week,t77.[Earliest Promise Date]) = 53 THEN 52 
    WHEN DATEPART(iso_week,t77.[Earliest Promise Date]) IS NULL THEN 52
    ELSE DATEPART(iso_week,t77.[Earliest Promise Date]) 
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
 left join(select t0.ItemCode, t0.itemname, t2.U_IIS_proPrOrder, t2.DocNum [Prod Ord], 
case 
when t1.[Earliest Promise Date SO] is null and t3.[Earliest Prom Date] is null then t2.DueDate
when t1.[Earliest Promise Date SO] is not null and t3.[Earliest Prom Date] is null then t1.[Earliest Promise Date SO]
when t1.[Earliest Promise Date SO] is null and t3.[Earliest Prom Date] is not null then t3.[Earliest Prom Date]
when t1.[Earliest Promise Date SO] is not null and t3.[Earliest Prom Date] is not null and t3.[Earliest Prom Date] <= t1.[Earliest Promise Date SO] then t3.[Earliest Prom Date]
else t3.[Earliest Prom Date] end [Earliest Promise Date],
case 
when t1.[Earliest Promise Date SO] is null and t3.[Earliest Prom Date] is null then 'Own Prod Order'
when t1.[Earliest Promise Date SO] is not null and t3.[Earliest Prom Date] is null then 'Sales Order Line Item'
when t1.[Earliest Promise Date SO] is null and t3.[Earliest Prom Date] is not null then 'Sales Order Sub BOM'
when t1.[Earliest Promise Date SO] is not null and t3.[Earliest Prom Date] is not null and t3.[Earliest Prom Date] <= t1.[Earliest Promise Date SO] then 'Sales Order Sub BOM'
else 'Sales Order Line Item' end [Promise Date Source]



from oitm t0
inner join (select t0.ItemCode, t0.U_IIS_proPrOrder, t0.DocNum, t0.DueDate

                                                                from owor t0 
                                                                inner join iis_epc_pro_orderh t1 on t1.PrOrder = t0.U_IIS_proPrOrder

                                                                where t0.Status not in ('C','L')
                                                                and t0.OriginNum is null) t2 on t2.ItemCode = t0.ItemCode

---- promise date when on sales order
left join (select t0.ItemCode, min(t0.U_promise_date) [Earliest Promise Date SO]

                                                from rdr1 t0
                                                inner join [@PRE_PROD_STATUS] t3 on t3.Code = t0.U_PP_Status
                                                inner join oitm t1 on t1.ItemCode = t0.ItemCode
                                                inner join oitb t2 on t2.ItmsGrpCod = t1.ItmsGrpCod
                                                where t0.LineStatus = 'o'
                                                                                                and t1.PrcrmntMtd = 'M'
                                                                                                and t3.Name = 'Live'

                                                                group by t0.ItemCode) t1 on t1.ItemCode = t0.ItemCode

---- promise date when sub component
left join (select t0.ItemCode, min(t4.U_promise_date) [Earliest Prom Date]

                                                from oitm t0
                                                inner join wor1 t1 on t1.ItemCode = t0.ItemCode
                                                inner join owor t2 on t2.DocEntry = t1.DocEntry
                                                inner join iis_epc_pro_orderh t3 on t3.PrOrder = t2.U_IIS_proPrOrder
                                                inner join rdr1 t4 on t4.ItemCode = t3.EndProduct 
                                                inner join ordr t5 on t5.DocEntry = t4.DocEntry and t5.docnum = t3.SONum
                                                inner join [@PRE_PROD_STATUS] t6 on t6.Code = t4.U_PP_Status

                                                where t4.LineStatus = 'o'
                                                and t6.Name = 'Live'
                                                and t0.PrcrmntMtd = 'M'
                                                group by t0.ItemCode) t3 on t3.ItemCode = t0.ItemCode) t77 on t77.U_IIS_proPrOrder=t0.U_IIS_proPrOrder



WHERE t0.Status not in ('D','L','C')
and t0.OriginNum is null
 
ORDER BY [Project] ASC";
?>