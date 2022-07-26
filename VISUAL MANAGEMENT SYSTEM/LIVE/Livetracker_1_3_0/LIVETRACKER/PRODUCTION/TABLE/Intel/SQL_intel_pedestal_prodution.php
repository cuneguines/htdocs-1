<?php
$intel_query = 
"SELECT 
t0.*,
t0.[Kilkishen Date UNP],
t0.[Lab Remainder],
(DateDiff(dd,GETDATE(),t0.[Kilkishen Date UNP]) + 1) - DATEDIFF(ww, GETDATE(), t0.[Kilkishen Date UNP]) * 2 - (CASE WHEN DateName(DW,GETDATE()) = 'Sunday' THEN 1 ELSE 0 END) - (CASE WHEN DateName(DW,t0.[Kilkishen Date UNP]) = 'Saturday' THEN 1 ELSE 0 END) -2 [Workdays To Kilkishen],
CAST((t0.[Lab Remainder]/(8*0.85)) AS DECIMAL(12,0))  [Est Days To Complete],
CAST((t0.[Lab Remainder]/(16*0.85)) AS DECIMAL(12,0)) [Est Days To Complete (OT)],
CASE
        WHEN t0.[Status] = 'D In DPD' THEN 999
        WHEN t0.[Status] = 'G Complete in Intel' THEN 999
        WHEN t0.[Status] = 'F Complete in Kilkishen' THEN 999
        WHEN t0.[Status] = 'E In Kilkishen Powdercoating' THEN 999
		WHEN t0.[Status] = 'C Paused' THEN (DateDiff(dd,GETDATE(),t0.[Kilkishen Date UNP]) + 1) - DATEDIFF(ww, GETDATE(), t0.[Kilkishen Date UNP]) * 2 - (CASE WHEN DateName(DW,GETDATE()) = 'Sunday' THEN 1 ELSE 0 END) - (CASE WHEN DateName(DW,t0.[Kilkishen Date UNP]) = 'Saturday' THEN 1 ELSE 0 END) - CAST((t0.[Lab Remainder]/(10))*0.85 AS DECIMAL(12,0))
        WHEN t0.[Status] = 'B Not Started' THEN (DateDiff(dd,GETDATE(),t0.[Kilkishen Date UNP]) + 1) - DATEDIFF(ww, GETDATE(), t0.[Kilkishen Date UNP]) * 2 - (CASE WHEN DateName(DW,GETDATE()) = 'Sunday' THEN 1 ELSE 0 END) - (CASE WHEN DateName(DW,t0.[Kilkishen Date UNP]) = 'Saturday' THEN 1 ELSE 0 END) - CAST((t0.[Lab Remainder]/(10))*0.85 AS DECIMAL(12,0))
    ELSE  (DateDiff(dd,GETDATE(),t0.[Kilkishen Date UNP]) + 1) - DATEDIFF(ww, GETDATE(), t0.[Kilkishen Date UNP]) * 2 - (CASE WHEN DateName(DW,GETDATE()) = 'Sunday' THEN 1 ELSE 0 END) - (CASE WHEN DateName(DW,t0.[Kilkishen Date UNP]) = 'Saturday' THEN 1 ELSE 0 END) - 2- CAST(t0.[Lab Remainder]/(16*0.85) AS DECIMAL(12,0)) END [Delta]

FROM
(
    SELECT   
    t1.OriginNum [Sales Order], 
    t1.DocNum [Prod Order],
    t0.PrOrder [Process Order],
    t5.CardName [Customer],
    t20.U_BOY_38_EXT_REM [Comments],
    t6.ItemCode [Item Code],
    CAST(t1.PlannedQty AS DECIMAL(12,0)) [Quantity],
    t6.ItemName [Item Name],
    ISNULL(CAST(CAST(ISNULL(t10.UTM/t9.Planned_Lab,0) AS DECIMAL(12,2))*100 AS INT),0)[Fab Status %],
    ISNULL(FORMAT(CAST(t5.U_FLOORDATE AS DATE), 'dd-MM-yyyy'), 'NO FLOOR DATE') [Floor Date],
    FORMAT(CAST(t20.U_Promise_Date AS DATE), 'dd-MM-yyyy') [Intel Delivery Date],
    FORMAT(CAST(DATEADD(week,-2,t20.U_Promise_Date) AS DATE), 'dd-MM-yyyy') [Kilkishen Date],
    CAST(DATEADD(week,-2,t20.U_Promise_Date) AS DATE) [Kilkishen Date UNP],
    DATEPART(week, (DATEADD(week,-2,t20.U_Promise_Date))) [Kilkishen Date Week],
    ISNULL(CAST(t9.Planned_Lab AS DECIMAL (12,0)), 0)[Planned Lab],
    ISNULL(CAST(t10.[UTM] AS DECIMAL(12,0)),0) [UTM],      
    (CASE 
        WHEN t11.[Lazer Labour Hrs] is not null THEN 'YES'
    ELSE 'NO' END) [Lazer Top Plates Cut],
    ISNULL(CAST(t11.[Lazer Labour Hrs] AS DECIMAL(12,1)),0) [Lazer Labour Hrs],
    ISNULL(FORMAT(CAST(t12.[Lazer Start Date] AS  DATE), 'dd-MM-yyyy'), 'NOT STARTED')[Lazer Start Date],
    ISNULL(t13.[Name], 'NONE') [Fabricator],
    ISNULL(CAST(t13.[SUM] AS DECIMAL(12,0)),0) [SUM],
    CASE
        WHEN t5.DocStatus = 'C' THEN 'G Complete in Intel'
        WHEN t20.U_BOY_38_EXT_REM like '%DPD%' then 'D In DPD'
        WHEN t20.U_PP_Status LIKE 'Paused' OR t20.U_Paused LIKE 'Yes' THEN 'C Paused'
        WHEN t1.CmpltQty >= t1.PlannedQty THEN 'F Complete in Kilkishen'
        WHEN t20.U_In_Sub_Con = 'YES' OR t20.U_In_Sub_Con = 'Gone To Sub Con' OR  t20.U_In_Sub_Con = '1002' THEN 'E In Kilkishen Powdercoating'
        WHEN t10.[UTM] is null THEN 'B Not Started'
    ELSE 'A In Production' END [Status],
    ISNULL(CAST(CASE
        WHEN t5.DocStatus = 'C' THEN 0
        WHEN t20.U_BOY_38_EXT_REM like '%DPD%' then 0
        WHEN t1.CmpltQty >= t1.PlannedQty THEN 0
        WHEN t20.U_In_Sub_Con = 'YES' OR t20.U_In_Sub_Con = 'Gone To Sub Con' OR  t20.U_In_Sub_Con = '1002' THEN 0
        WHEN t10.[UTM] is null THEN t9.Planned_Lab
        WHEN (t20.U_PP_Status LIKE 'Paused' OR t20.U_Paused LIKE 'Yes') and t9.Planned_Lab >= t10.[UTM]  THEN t9.Planned_Lab - t10.[UTM]
        WHEN (t20.U_PP_Status LIKE 'Paused' OR t20.U_Paused LIKE 'Yes') and t9.Planned_Lab < t10.[UTM]  THEN 0
        WHEN t9.Planned_Lab >= t10.[UTM]  THEN t9.Planned_Lab - t10.[UTM]
    ELSE 0
    END AS DECIMAL(12,0)),0)[Lab Remainder],

    ISNULL(FORMAT(CAST(t21.Last_Fab_Date AS DATE), 'dd-MM-yyyy' ), 'NONE')[Last_Fab_Date],
    CASE
        WHEN t21.Last_Fab_Date > DATEADD(m, -6, current_timestamp) THEN 'Y'
        ELSE 'N'
    END [Last Six Months],
    CASE
        WHEN DATEADD(week,-2,t20.U_Promise_Date) < DATEADD(week, +1 , GETDATE()) THEN 'Y'
        ELSE 'N'
    END [Next To Kilkishen]

    FROM IIS_EPC_PRO_ORDERH t0  
    INNER JOIN owor t1 ON t1.U_IIS_proPrOrder = t0.PrOrder AND t1.ItemCode = t0.EndProduct    
    LEFT JOIN (SELECT t1.U_IIS_proPrOrder,
        SUM(t0.plannedqty * t2.avgprice) [Planned_Mat],                                      
        SUM(t0.IssuedQty* t2.avgprice) [Issued_Mat]                                              
            FROM wor1 t0
                INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry                                                 
                INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode
                    WHERE  t2.itemtype <> 'L'   and t1.U_IIS_proPrOrder is not null                                          
                        GROUP BY t1.U_IIS_proPrOrder)
    t2 on t2.U_IIS_proPrOrder = t0.PrOrder    
    LEFT JOIN (SELECT t1.U_IIS_proPrOrder, 
        SUM(t0.plannedqty) [Planned_Fab]
            FROM wor1 t0
                INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry                                                                 
                INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode
                    WHERE t2.itemcode in ('3000002', '3000608', '3000609', '3000610', '3000611', '3000612') and t1.U_IIS_proPrOrder is not null                                                                 
                        GROUP BY t1.U_IIS_proPrOrder) 
    t3 ON t3.U_IIS_proPrOrder = t0.PrOrder
    LEFT JOIN (select t1.U_IIS_proPrOrder, 
        SUM(t0.plannedqty) [Planned_Lab]
            FROM wor1 t0
                INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry                                                                 
                INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode                                                               
                    WHERE t2.ItemType = 'L'  and t1.U_IIS_proPrOrder is not null                                                                   
                        GROUP BY t1.U_IIS_proPrOrder) 
    t9 ON t9.U_IIS_proPrOrder = t0.PrOrder    
    LEFT JOIN (SELECT t0.PrOrder, 
        SUM(t0.Quantity) [Actual_Fab]
            FROM iis_epc_pro_ordert t0                                                            
                WHERE t0.LabourCode in ('3000002', '3000608', '3000609', '3000610', '3000611', '3000612') 
                    GROUP BY t0.PrOrder) 
    t4 ON t4.PrOrder = t0.Prorder  
    LEFT JOIN (SELECT t0.PrOrder, 
        SUM(t0.Quantity) [UTM]
            FROM iis_epc_pro_ordert t0                                                            
                GROUP BY t0.PrOrder) 
    t10 ON t10.PrOrder = t0.Prorder
    LEFT JOIN (SELECT t0.PrOrder, 
        SUM(t0.Quantity) [Lazer Labour Hrs]
            FROM iis_epc_pro_ordert t0
                WHERE t0.LabourCode = '3000004'                                                           
                    GROUP BY t0.PrOrder) 
    t11 ON t11.PrOrder = t0.Prorder
    LEFT JOIN (SELECT t0.PrOrder, 
        MIN(t0.Created) [Lazer Start Date]
            FROM iis_epc_pro_ordert t0
                WHERE t0.LabourCode = '3000004'
                    GROUP BY t0.PrOrder) 
    t12 ON t12.PrOrder = t0.Prorder
    LEFT JOIN(select t0.prorder, 
        t0.useriD, t0.[SUM], 
        t3.firstName + ' ' + t3.lastName [Name]
            FROM 
                (SELECT 
                    SUM(t2.Quantity) [SUM], 
                    t2.userID, 
                    t2.PrOrder
                        FROM iis_epc_pro_ordert t2
                            WHERE t2.LabourCode in ('3000002', '3000608', '3000609', '3000610', '3000611', '3000612') 
                            GROUP BY t2.PrOrder, t2.userID 
                )t0
                inner join 
                    (select t0.prorder, 
                        MAX(t0.[SUM]) [SUM]
                        FROM 
                                (SELECT SUM(t2.Quantity) [SUM], t2.userID, t2.PrOrder
                                    FROM iis_epc_pro_ordert t2
                                        WHERE t2.LabourCode in ('3000002', '3000608', '3000609', '3000610', '3000611', '3000612') 
                                GROUP BY t2.PrOrder, t2.userID
                                ) t0
                        group by t0.prorder
                    ) t1 on t1.prorder = t0.prorder and t1.[SUM] = t0.[SUM]
                LEFT JOIN ohem t3 ON t3.empID = t0.userID
                )t13 ON t13.PrOrder = t0.PrOrder

    INNER JOIN ordr t5 ON t5.docnum = t1.OriginNum
    INNER JOIN oitm t6 ON t6.ItemCode = t0.EndProduct  
    INNER JOIN ohem t7 ON t7.empID = t5.OwnerCode   
    INNER JOIN oslp t8 ON t8.SlpCode = t5.SlpCode
    left JOIN rdr1 t20 ON t20.DocEntry = t5.DocEntry AND t20.ItemCode = t1.ItemCode and t20.ItemCode = t0.EndProduct


    LEFT JOIN (SELECT t0.PrOrder, 
        max(t0.created) [Last_Fab_Date]
            FROM iis_epc_pro_ordert t0                                                            
                WHERE t0.LabourCode in ('3000002', '3000608', '3000609', '3000610', '3000611', '3000612') 
                    GROUP BY t0.PrOrder) 
    t21 ON t21.PrOrder = t0.Prorder  


    WHERE t5.CardName Like 'Intel Ireland Ltd' AND (t5.U_Client LIKE 'P1276 Pedestals' OR t5.U_Client LIKE 'P1272 Pedestals' OR t5.U_Client LIKE 'P1276 AMHS' OR ISNULL(t5.U_Client,t5.CardName) LIKE 'Intel Ireland' OR ISNULL(t5.U_Client,t5.CardName) LIKE 'Intel Ireland Ltd') AND ((CAST(t5.DocDueDate AS DATE)) > '2020/04/01')
    and t1.status <> 'C'
)t0
ORDER BY [DELTA]";
?>

