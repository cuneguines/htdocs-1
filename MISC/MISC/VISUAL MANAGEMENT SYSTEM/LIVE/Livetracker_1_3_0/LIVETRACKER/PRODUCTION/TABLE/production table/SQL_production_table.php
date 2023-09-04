<?php
$production_table_query =
"SELECT   
ISNULL(STR(t1.OriginNum),'N/A') [Sales Order],
t0.PrOrder [Process Order],
ISNULL(t5.CardName, 'Kent Stainless Stock') [Customer],
ISNULL(t5.U_Client, 'NO PROJECT') [Project],
CAST(t1.PlannedQty AS DECIMAL(12,2)) [Quantity],
CAST(t1.PlannedQty AS DECIMAL (12,1)) [Planned Qty],
CAST(t1.CmpltQty AS DECIMAL (12,1)) [Complete Qty],
CAST(t1.PlannedQty AS DECIMAL (12,1)) - CAST(t1.CmpltQty AS DECIMAL (12,1)) [Delta],
t6.ItemName [Item Name],

CAST(t2.Planned_Mat AS DECIMAL (12,0)) [Planned Material],
CAST(t2.Issued_Mat AS DECIMAL (12,0))[Issued Material],
(CASE WHEN t2.Issued_Mat = 0 THEN 0 ELSE ISNULL(t2.Issued_Mat/ISNULL(t2.Planned_Mat,t2.Issued_Mat),0) END) [Material Efficiency],
ISNULL(CAST(t2.Planned_Mat AS DECIMAL (12,0)),0) - ISNULL(CAST(ISNULL(t2.Issued_Mat,0) AS DECIMAL (12,0)),0) [Remaining Material],  

ISNULL(CAST(t3.Planned_Fab AS DECIMAL (12,0)),0) [Planned Fab Hrs],
ISNULL(CAST(t4.Actual_Fab AS DECIMAL (12,0)),0) [Actual Fab Hrs],
(CASE WHEN t4.Actual_Fab = 0 THEN 0 ELSE ISNULL(t4.Actual_Fab/ISNULL(t3.Planned_Fab,t4.Actual_Fab),0) END) [Fabrication Complete],
ISNULL(CAST(t3.Planned_Fab AS DECIMAL(12,0)),0) - ISNULL(CAST(ISNULL(t4.Actual_Fab,0) AS DECIMAL (12,0)),0) [Remaining Fab Hrs],  

ISNULL(CAST(t9.Planned_Lab AS DECIMAL (12,0)),0) [Planned Lab Hrs],
ISNULL(CAST(t10.Actual_Lab AS DECIMAL (12,0)),0) [Actual Lab Hrs],
(CASE WHEN t10.Actual_Lab = 0 THEN 0 ELSE ISNULL(t10.Actual_Lab/ISNULL(t9.Planned_Lab,t10.Actual_Lab),0) END) [Labour Efficiency],
ISNULL(CAST(t9.Planned_Lab AS DECIMAL(12,0)),0) - ISNULL(CAST(ISNULL(t10.Actual_Lab,0) AS DECIMAL (12,0)),0) [Remaining Lab Hrs],

CASE 
	WHEN (t9.[Planned_Lab] - ISNULL(t10.[Actual_Lab],0)) >= 0 THEN 0
	ELSE CAST(t10.[Actual_Lab] AS DECIMAL (12,0)) - CAST(ISNULL(t9.[Planned_Lab],0) AS DECIMAL (12,0))
END [Unplanned Deficit],

(case
    WHEN t9.Planned_Lab >= 750 THEN 'S'
    WHEN t9.Planned_Lab < 750 AND t9.Planned_Lab >= 250 THEN 'A'
    WHEN t9.Planned_Lab < 250 AND t9.Planned_Lab >= 100 THEN 'B'
    WHEN t9.Planned_Lab < 100 AND t9.Planned_Lab >= 40 THEN 'C'
    WHEN t9.Planned_Lab < 40 AND t9.Planned_Lab >= 20 THEN 'D'
    WHEN t9.Planned_Lab < 20  THEN 'E' ELSE 'NA'
END) [Job Size Class],

ISNULL(FORMAT(CAST(t15.U_Promise_Date AS DATE), 'dd-MM-yyyy'),'N/A')[Due_Date],
DATEPART(ISO_WEEK, t15.U_Promise_Date) [Promise Week],
ISNULL(t7.firstname + ' ' + t7.lastName,'N/A') [Sales Person],
ISNULL(t8.SlpName, 'N/A') [Engineer],
t5.Comments [Comments],
t15.U_In_Sub_Con [Sub Contract],   

t1.CmpltQty - t1.PlannedQty [Complete],
CAST(t14.[STOCKDATE] AS DATE) [STOCKDATE],


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
        SUM(t0.IssuedQty* t2.avgprice) [Issued_Mat]  			
        FROM wor1 t0
            INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry  			
            INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode
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
LEFT JOIN(SELECT MAX(t0.Docdate) [STOCKDATE], t1.BaseRef, t1.ItemCode FROM oign t0 
    INNER JOIN ign1 t1 ON t1.DocEntry = t0.DocEntry
    GROUP BY t1.BaseRef, t1.ItemCode)
t14 ON t14.BaseRef = t1.DocNum and t14.ItemCode = t1.ItemCode
     
LEFT JOIN ordr t5 ON t5.docnum = t1.OriginNum
LEFT JOIN oslp t8 ON t8.SlpCode = t5.SlpCode
LEFT JOIN ohem t7 ON t7.empID = t5.OwnerCode
LEFT JOIN rdr1 t15 ON t15.DocEntry = t5.DocEntry AND t15.ItemCode = t1.ItemCode

INNER JOIN oitm t6 ON t6.ItemCode = t0.EndProduct
INNER JOIN oitb t16 ON t16.ItmsGrpCod = t6.ItmsGrpCod
LEFT JOIN ousr t17 ON t17.UserID = t6.UserSign

WHERE $clause AND t1.Status <> 'C'

ORDER BY [Material Efficiency] DESC";          
?>