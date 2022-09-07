<?php 
    $released_hours = 
    "SELECT (CASE WHEN DATEPART(iso_week,t1.CreateDate) = 53 THEN 52 ELSE DATEPART(iso_week,t1.CreateDate) END)[Week Released], 
            DATEPART(year,t1.CreateDate)[Year Released], 
            SUM(t9.Planned_Lab) [Planned Hours]
        FROM IIS_EPC_PRO_ORDERH t0  
            INNER JOIN owor t1 ON t1.U_IIS_proPrOrder = t0.PrOrder AND t1.ItemCode = t0.EndProduct    
            LEFT JOIN (select t1.U_IIS_proPrOrder, 
                    SUM(t0.plannedqty) [Planned_Lab]
                    FROM wor1 t0
                        INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry  				
                        LEFT JOIN oitm t2 ON t2.ItemCode = t0.ItemCode  				
                            WHERE t2.ItemType = 'L' AND t2.ItemCode <> '3000004' 				
                            GROUP BY t1.U_IIS_proPrOrder) 
            t9 ON t9.U_IIS_proPrOrder = t0.PrOrder         
            INNER JOIN ordr t5 ON t5.docnum = t1.OriginNum
            LEFT JOIN rdr1 t6 ON t6.DocEntry = t5.DocEntry AND t6.ItemCode = t1.ItemCode
                WHERE t5.CardName Like 'Intel Ireland Ltd' AND ($query_clauses) AND t5.DocDueDate > '2020/04/01' AND t1.Status <> 'C'
				GROUP BY DATEPART(year,t1.CreateDate),DATEPART(iso_week,t1.CreateDate)
                ORDER BY [Year Released],[Week Released]";

        
    $hours_history = 
    "SELECT t0.PrOrder [Process Order], 
    (CASE WHEN DATEPART(iso_week,t0.Created) = 53 THEN 52 ELSE DATEPART(iso_week,t0.Created) END) [Week Created], 
    DATEPART(year,t0.Created) [Year Created], 
    t0.Quantity[Entry Hours Logged], 
    t9.Planned_Lab [Planned Labour], 
    t3.CmpltQty [Complete Qty], 
    t3.PlannedQty [Planned Qty], 
    t6.U_In_Sub_Con [Subcontract], 
    t3.Status [Status], 
    CASE WHEN t6.U_BOY_38_EXT_REM LIKE '%DPD%' THEN 'Y' ELSE 'N' END [Courier]
        FROM IIS_EPC_PRO_ORDERT t0
LEFT JOIN IIS_EPC_PRO_ORDERH t2 ON t2.PrOrder = t0.PrOrder
LEFT JOIN owor t3 ON t3.U_IIS_proPrOrder = t0.PrOrder AND t3.ItemCode = t2.EndProduct
LEFT JOIN ordr t5 ON t5.docnum = t3.OriginNum
LEFT JOIN rdr1 t6 ON t6.DocEntry = t5.DocEntry AND t6.ItemCode = t2.EndProduct
LEFT JOIN (SELECT t1.U_IIS_proPrOrder, 
                    SUM(t0.plannedqty) [Planned_Lab]
                    FROM wor1 t0
                        INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry  				
                        INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode  				
                            WHERE t2.ItemType = 'L' AND t2.itemCode <> '3000004'				
                            GROUP BY t1.U_IIS_proPrOrder) 
t9 ON t9.U_IIS_proPrOrder = t2.PrOrder   
WHERE t5.CardName Like 'Intel Ireland Ltd' AND ($query_clauses) AND t5.DocDueDate > '2020/04/01' AND t3.Status <> 'C'
ORDER BY t0.PrOrder,t0.Created";
    
    $projects_query = 
    "SELECT DISTINCT U_Client [Project] FROM ORDR WHERE CardName LIKE 'Intel Ireland Ltd' AND U_Client NOT IN ('','Intel Ireland Ltd','Intel Ireland','Intel','int002', 'Intel Operator Training','TEST PROJECT') ORDER BY U_Client DESC";
?>