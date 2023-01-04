<?php
	$status_table_sql = 
	"SELECT
	t0.DocNum [Sales Order],
	CASE
		WHEN t1.DelivrdQty >= t1.Quantity OR t1.LineStatus = 'C' Then 'Delivered'
		WHEN (t1.Quantity - ISNULL(t1.DelivrdQty,0)) <= t2.OnHand THEN 'In Stock'
		WHEN ISNULL(t1.U_PP_STATUS,'NO STATUS') = 'Pre Production Confirmed' OR t1.U_PP_Status = '1003' THEN 'Confirmed'
		WHEN ISNULL(t1.U_PP_STATUS,'NO STATUS') IN ('Live','NO STATUS') OR t1.U_PP_Status = '1001' THEN 'Live'
		WHEN ISNULL(t1.U_PP_STATUS,'NO STATUS') = 'Pre Production Forecast' OR t1.U_PP_Status = '1004' THEN 'Forecast'
		WHEN ISNULL(t1.U_PP_STATUS,'NO STATUS') = 'Pre Production Potential' OR t1.U_PP_Status = '1002' THEN 'Potential'	
	END [Status Name],
	t0.CardName [Customer],
	t1.Dscription [Description],
	t1.ItemCode[Item Code],
	t5.ItmsGrpNam[Item Group Name],
	t2.U_Product_Group_One[Product Group One],
	t2.U_Product_Group_Two[Product Group Two],
	CAST(t2.CreateDate AS DATE)[Date Master Created],

	ISNULL(t0.U_Client,'No Project Name') [Project],
	t1.Quantity [Full Order Qty],
	(t1.LineTotal/t1.Quantity) [Unit Price],
	ISNULL(t1.DelivrdQty,0) * (t1.LineTotal/t1.Quantity) [Complete Total],
	CASE WHEN t1.LineStatus = 'C' THEN 0 ELSE (t1.Quantity - ISNULL(t1.DelivrdQty,0)) END [Remaining Qty],
	CASE WHEN t1.LineStatus <> 'C' THEN (t1.Quantity - ISNULL(t1.DelivrdQty,0)) * (t1.LineTotal/t1.Quantity) ELSE 0 END[Open Live Total],
	CASE WHEN t1.LineStatus <> 'C' THEN (t1.Quantity - ISNULL(t1.DelivrdQty,0)) - ISNULL(t2.OnHand,0) ELSE 0 END [Open Live Qty],
	CASE WHEN t1.LineStatus <> 'C' AND (t1.Quantity - ISNULL(t1.DelivrdQty,0)) <= t2.OnHand THEN ((t1.Quantity-ISNULL(t1.DelivrdQty,0))*t1.LineTotal/t1.Quantity) ELSE 0.00 END [In Stock Live Total],
	FORMAT(CAST(t1.U_Promise_Date AS DATE), 'dd-MM-yyyy') [Promise Date],
	DATEPART(WEEK,t1.U_Promise_Date),

	t4.firstname + ' ' + t4.lastName [Sales Person],

	DATEPART(year,t1.U_Promise_Date) [Year], 
	DATEPART(month,t1.U_Promise_Date)[Month],
	DATEPART(WEEK,t1.U_Promise_Date)[Week],
	CASE
		WHEN CASE WHEN t1.DelivrdQty >= t1.Quantity OR t1.LineStatus = 'C' THEN 0 ELSE (t1.Quantity - t1.DelivrdQty) END = 0 THEN 'Complete'
		WHEN ISNULL(t1.U_PP_STATUS,'NO STATUS') = 'Pre Production Forecast' OR t1.U_PP_Status = '1004' THEN 'Pre Production Forecast'
		WHEN ISNULL(t1.U_PP_STATUS,'NO STATUS') = 'Pre Production Potential' OR t1.U_PP_Status = '1002' THEN 'Pre Production Potential'
		WHEN ISNULL(t1.U_PP_STATUS,'NO STATUS') = 'Pre Production Confirmed' OR t1.U_PP_Status = '1003' THEN 'Pre Production Confirmed'
		WHEN ISNULL(t1.U_PP_STATUS,'NO STATUS') IN ('Live','Paused','NO STATUS') OR t1.U_PP_Status = '1001' THEN 'Live'
		WHEN (t1.Quantity - ISNULL(t1.DelivrdQty,0)) <= t2.OnHand THEN 'In Stock'
	END [Status LHS],
	CASE
		WHEN (t1.Quantity - ISNULL(t1.DelivrdQty,0)) <= t2.OnHand AND t1.LineStatus <> 'C' THEN 'In Stock'
	END [Status RHS],	
	ISNULL(t1.DelivrdQty,0) [Delivered Qty],
	ISNULL(t2.OnHand,0) [On Hand],
	t0.U_Dimension1[Business Unit],
	t6.Country[Country]

	FROM ORDR t0
		INNER JOIN RDR1 t1 ON t1.DocEntry = t0.DocEntry
		LEFT JOIN OITM t2 ON t2.ItemCode = t1.ItemCode
		LEFT JOIN OITB t5 ON t5.ItmsGrpCod = t2.ItmsGrpCod
		LEFT JOIN OSLP t3 on t3.SlpCode = ISNULL(t1.SlpCode, t0.SlpCode)
		LEFT JOIN OHEM t4 on t4.empID = t0.OwnerCode
		LEFT JOIN OCRD t6 ON t6.CardCode = t0.CardCode
			WHERE t0.CANCELED <> 'Y' AND t1.ItemCode <> 'TRANSPORT' AND t1.U_Promise_Date >= dateadd(mm, datediff(mm, 0, getDate()) - 12, 0) and t1.U_Promise_Date <= dateadd(mm, datediff(mm, 0, getDate()) + 13, 0)
				ORDER BY
					DATEPART(YEAR,t1.U_Promise_Date) ASC, 
					DATEPART(Month,t1.U_Promise_Date) ASC";
?>