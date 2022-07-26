<?php 
$richmond_query =  
"SELECT
	(case when t21.[Name] is null then t20.U_PP_Status else t21.[Name] end) [Status],
	t5.CardName [Customer],
	t5.U_Client [Project],
	t1.OriginNum [Sales Order],
	t0.PrOrder [Process Order],
    t1.DocNum [Prod Order],
	t5.NumAtCard [Ref Number],
    t6.ItemCode [Item Code],
	t6.ItemName [Item Name],
    CAST(t1.PlannedQty AS DECIMAL(12,0)) [Quantity],
	CAST(t20.DelivrdQty AS DECIMAL(12,0)) [Delivered Qty],
	t20.U_Est_Prod_Hrs [Est Prod],
	t20.LineStatus [Line Status],
    ISNULL(CAST(CAST(ISNULL(t10.UTM/t9.Planned_Lab,0) AS DECIMAL(12,2))*100 AS INT),0)[Fab Status %],
    ISNULL(FORMAT(CAST(t5.U_FLOORDATE AS DATE), 'dd-MM-yyyy'), 'NO FLOOR DATE') [Floor Date],
	FORMAT(CAST(t5.DocDueDate AS DATE), 'dd-MM-yyyy') [Dispatch Date],
    FORMAT(CAST(t20.U_Promise_Date AS DATE), 'dd-MM-yyyy') [Promise Date],
    ISNULL(CAST(t9.Planned_Lab AS DECIMAL (12,0)), 0)[Planned Lab],
    ISNULL(CAST(t10.[UTM] AS DECIMAL(12,0)),0) [UTM],
	t5.Comments[Comments],
	t5.Address2[Address]
	FROM IIS_EPC_PRO_ORDERH t0  
	INNER JOIN owor t1 ON t1.U_IIS_proPrOrder = t0.PrOrder AND t1.ItemCode = t0.EndProduct
	LEFT JOIN (select t1.U_IIS_proPrOrder,
		SUM(t0.plannedqty) [Planned_Lab]
			FROM wor1 t0
				INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry
				INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode
					WHERE t2.ItemType = 'L'  and t1.U_IIS_proPrOrder is not null
						GROUP BY t1.U_IIS_proPrOrder)
	t9 ON t9.U_IIS_proPrOrder = t0.PrOrder
	LEFT JOIN (SELECT t0.PrOrder, 
		SUM(t0.Quantity) [UTM]
			FROM iis_epc_pro_ordert t0
				GROUP BY t0.PrOrder)
	t10 ON t10.PrOrder = t0.Prorder
	INNER JOIN ordr t5 ON t5.docnum = t1.OriginNum
	INNER JOIN oitm t6 ON t6.ItemCode = t0.EndProduct
	INNER JOIN ohem t7 ON t7.empID = t5.OwnerCode
	INNER JOIN oslp t8 ON t8.SlpCode = t5.SlpCode
	INNER JOIN rdr1 t20 ON t20.DocEntry = t5.DocEntry and t20.ItemCode = t0.EndProduct
	left join [dbo].[@PRE_PROD_STATUS] as t21 on t21.code = t20.U_PP_Status
        WHERE t5.CardName Like 'Richmond Trading Co Ltd' and t5.DocStatus <> 'C'
        ORDER BY t5.DocNum, t20.U_Est_Prod_Hrs DESC";
?>

