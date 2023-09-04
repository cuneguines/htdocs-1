<?php
$closed_orders_sql = 
"SELECT 
t1.OriginNum [Sales Order],
t0.PrOrder [Process Order],
t5.CardName [Customer],
ISNULL(t5.U_Client, 'NO PROJECT') [Project],
CAST(t1.PlannedQty AS DECIMAL(12,2)) [Quantity],
CAST(t1.PlannedQty AS DECIMAL (12,1)) [Planned Qty],
CAST(t1.CmpltQty AS DECIMAL (12,1)) [Complete Qty],
CAST(t1.PlannedQty AS DECIMAL (12,1)) - CAST(t1.CmpltQty AS DECIMAL (12,1)) [Delta],
t6.ItemName [Item Name],

CAST(t2.Planned_Mat AS DECIMAL (12,0)) [Planned Material],
CAST(t2.Issued_Mat AS DECIMAL (12,0))[Issued Material],
(CASE WHEN t2.Issued_Mat = 0 THEN FORMAT(0,'P0')
ELSE FORMAT(ISNULL(t2.Issued_Mat/ISNULL(t2.Planned_Mat,t2.Issued_Mat),0),'P0') END) [Material Efficiency],
ISNULL(CAST(t2.Planned_Mat AS DECIMAL (12,0)),0) - ISNULL(CAST(ISNULL(t2.Issued_Mat,0) AS DECIMAL (12,0)),0) [Remaining Material],  

ISNULL(CAST(t3.Planned_Fab AS DECIMAL (12,0)),0) [Planned Fab Hrs],
ISNULL(CAST(t4.Actual_Fab AS DECIMAL (12,0)),0) [Actual Fab Hrs],
(CASE WHEN t4.Actual_Fab = 0 THEN FORMAT(0,'P0')
ELSE FORMAT(ISNULL(t4.Actual_Fab/ISNULL(t3.Planned_Fab,t4.Actual_Fab),0),'P0') END) [Fabrication Complete],
ISNULL(CAST(t3.Planned_Fab AS DECIMAL(12,0)),0) - ISNULL(CAST(ISNULL(t4.Actual_Fab,0) AS DECIMAL (12,0)),0) [Remaining Fab Hrs],  

ISNULL(CAST(t9.Planned_Lab AS DECIMAL (12,0)),0) [Planned Lab Hrs],
ISNULL(CAST(t10.Actual_Lab AS DECIMAL (12,0)),0) [Actual Lab Hrs],
(CASE WHEN t10.Actual_Lab = 0 THEN FORMAT(0,'P0')
ELSE FORMAT(ISNULL(t10.Actual_Lab/ISNULL(t9.Planned_Lab,t10.Actual_Lab),0),'P0') END) [Labour Efficiency],
ISNULL(CAST(t9.Planned_Lab AS DECIMAL(12,0)),0) - ISNULL(CAST(ISNULL(t10.Actual_Lab,0) AS DECIMAL (12,0)),0) [Remaining Lab Hrs],
CASE 
    WHEN (t9.[Planned_Lab] - ISNULL(t10.[Actual_Lab],0)) >= 0 THEN 0
    ELSE CAST(t10.[Actual_Lab] AS DECIMAL (12,0)) - CAST(ISNULL(t9.[Planned_Lab],0) AS DECIMAL (12,0))
END [Unplanned Deficit],

(case
    WHEN t3.Planned_Fab >= 750 THEN 'S'
    WHEN t3.Planned_Fab < 750 AND t3.Planned_Fab >= 250 THEN 'A'
    WHEN t3.Planned_Fab < 250 AND t3.Planned_Fab >= 100 THEN 'B'
    WHEN t3.Planned_Fab < 100 AND t3.Planned_Fab >= 40 THEN 'C'
    WHEN t3.Planned_Fab < 40 AND t3.Planned_Fab >= 20 THEN 'D'
    WHEN t3.Planned_Fab < 20  THEN 'E' ELSE 'NA'
END) [Job Size Class],


CAST(t11.[Close Date] AS DATE)[Close Date],
t7.firstname + ' ' + t7.lastName [Sales Person],
t8.SlpName [Engineer],
t5.Comments [Comments],

t6.ItemCode [Item Code],
FORMAT(t6.CreateDate, 'dd-MM-yyyy') [Create Date],
DATEPART(ISO_WEEK, t6.CreateDate) [Create Date Week],
DATEPART(YEAR, t6.CreateDate) [Create Date Year],
t17.U_NAME [Creating User],
ISNULL(t6.U_Product_Group_One, 'NO GROUP ONE') [Group One],
ISNULL(t6.U_Product_Group_Two, 'NO GROUP TWO') [Group Two],
ISNULL(t6.U_Product_Group_Three, 'NO GROUP THREE') [Group Three]
 

FROM IIS_EPC_PRO_ORDERH t0  
     INNER JOIN owor t1 ON t1.U_IIS_proPrOrder = t0.PrOrder AND t1.ItemCode = t0.EndProduct    
        LEFT JOIN (SELECT t1.U_IIS_proPrOrder, 
            SUM(t0.plannedqty * t2.avgprice) [Planned_Mat],             
            SUM(isnull(t0.IssuedQty,0)* t2.avgprice) + sum(isnull(t21.[Manual Mat],0)) [Issued_Mat], 
            SUM(t0.plannedqty * t2.avgprice)  - SUM(isnull(t0.IssuedQty,0)* t2.avgprice) - sum(isnull(t21.[Manual Mat],0)) [Mat_Diff]        
                FROM wor1 t0
                    INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry             
                    INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode
                    left join (select t2.PrOrder, t0.itemcode, sum(t0.linetotal) [Manual Mat]
                        from ige1 t0
                            inner join oige t1 on t1.DocEntry = t0.DocEntry
                            inner join IIS_EPC_PRO_ORDERH t2 on t2.PrOrder = t0.U_IIS_proPrOrder
                                where t0.U_IIS_proPrOrder is not null and t0.BaseEntry is null
                                group by t2.PrOrder, t0.itemcode
                    ) t21 on t21.PrOrder = t1.U_IIS_proPrOrder and t21.ItemCode = t0.ItemCode
                        WHERE  t2.itemtype <> 'L'        
                        GROUP BY t1.U_IIS_proPrOrder)
        t2 on t2.U_IIS_proPrOrder = t0.PrOrder    
        LEFT JOIN (SELECT t1.U_IIS_proPrOrder, 
                SUM(t0.plannedqty) [Planned_Fab]
                FROM wor1 t0
                    INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry         
                    INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode
                        inner join iis_epc_pro_orderh t3 on t3.PrOrder = t0.U_IIS_proPrOrder   
                        WHERE t2.itemcode = '3000002'                   
                        GROUP BY t1.U_IIS_proPrOrder) 
        t3 ON t3.U_IIS_proPrOrder = t0.PrOrder
        LEFT JOIN (select t1.U_IIS_proPrOrder, 
                SUM(t0.plannedqty) [Planned_Lab]
                FROM wor1 t0
                    INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry                 
                    INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode
                        inner join iis_epc_pro_orderh t3 on t3.PrOrder = t0.U_IIS_proPrOrder
                        WHERE t2.ItemType = 'L'                 
                        GROUP BY t1.U_IIS_proPrOrder) 
        t9 ON t9.U_IIS_proPrOrder = t0.PrOrder    
        LEFT JOIN (SELECT t0.PrOrder, 
                SUM(t0.Quantity) [Actual_Fab]
                    FROM iis_epc_pro_ordert t0                  
                        WHERE t0.LabourCode = '3000002'
                        GROUP BY t0.PrOrder) 
        t4 ON t4.PrOrder = t0.Prorder    
        LEFT JOIN (SELECT t0.PrOrder, 
                SUM(t0.Quantity) [Actual_Lab]
                    FROM iis_epc_pro_ordert t0                  
                        GROUP BY t0.PrOrder) 
        t10 ON t10.PrOrder = t0.Prorder    
        INNER JOIN ordr t5 ON t5.docnum = t1.OriginNum
        INNER JOIN oitm t6 ON t6.ItemCode = t0.EndProduct  
        INNER JOIN ohem t7 ON t7.empID = t5.OwnerCode  
        INNER JOIN oslp t8 ON t8.SlpCode = t5.SlpCode
        LEFT JOIN(select t1.BaseRef, MAX(t0.DocDate) [Close Date]
                from odln t0
                    inner join dln1 t1 on t1.DocEntry  = t0.DocEntry
                    group by t1.BaseRef)
        t11 On t11.BaseRef = t5.DocNum
        LEFT JOIN ousr t17 ON t17.UserID = t6.UserSign
            WHERE t5.DocStatus = 'C' AND t1.Status <> 'C' $daterange $hide_ok_orders
            ORDER BY [Remaining Fab Hrs] ASC
";           
?>