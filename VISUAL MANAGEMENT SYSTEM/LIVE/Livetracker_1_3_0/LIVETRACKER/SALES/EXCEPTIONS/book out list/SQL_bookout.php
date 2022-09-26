<?php
$bookout =
"SELECT  
t3.docnum [Producrion Order], 
t2.DocNum [Sales Order],
t0.[Source],
t1.itemcode [Item Code], 
t0.itemname [Item Name], 
t0.[Customer],
t0.U_Location [Location],
CAST(t0.Qty_on_Order AS DECIMAL (12,0)) [Qty On Order],
t0.[In Stock],
CAST(ISNULL(t0.[DelivrdQty],0) AS DECIMAL(12,0))[DelivrdQty],
CAST(ISNULL(t0.[Qty_on_Order],0) - ISNULL(t0.[In Stock],0) - ISNULL(t0.[DelivrdQty],0) AS DECIMAL(12,0)) [Qty Required],
CAST(t0.[Booked In] AS DECIMAL(12,0)) [Booked In], 
CAST(t0.[Date Booked In] AS DATE) [Date Booked In], 
t0.[Time Booked In],
CAST(t0.[Promise Date] AS DATE)[Promise Date],
CAST(t0.[Due Date] AS DATE)[Due Date],
t0.[User], 
t0.[Sales Person],
t0.[Engineer],
t0.[Ship_To],
CASE WHEN t0.[Booked In] IS NULL THEN 'Y' ELSE 'N' END [Not Booked In],
CASE WHEN CAST(t0.[Promise Date] AS DATE) < CAST(GETDATE() AS DATE) THEN 'Y' ELSE 'N' END [Due Date Passed], 

CASE WHEN CAST(t0.[Date Booked In] AS DATE) = CAST(GETDATE() AS DATE) THEN 'Y' ELSE 'N' END [BI TD],
CASE WHEN CAST(t0.[Date Booked In] AS DATE) = CAST(dateadd(day, -1,GETDATE()) AS DATE) THEN 'Y' 
	 WHEN DATEPART(DW, GETDATE()) = 2 AND CAST(t0.[Date Booked In] AS DATE) = CAST(dateadd(day, -3,GETDATE()) AS DATE) THEN 'Y' 
	 ELSE 'N' END [BI YD],  
CASE WHEN DATEPART(ISO_WEEK,t0.[Date Booked In]) = DATEPART(ISO_WEEK,GETDATE()) AND DATEPART(YEAR,t0.[Date Booked In]) = DATEPART(YEAR,GETDATE()) THEN 'Y' ELSE 'N' END [BI TW],
CASE WHEN DATEPART(ISO_WEEK,t0.[Date Booked In]) = DATEPART(ISO_WEEK,GETDATE()) -1 AND DATEPART(YEAR,t0.[Date Booked In]) = DATEPART(YEAR,GETDATE()) THEN 'Y' ELSE 'N' END [BI LW],
CASE WHEN DATEPART(MONTH,t0.[Date Booked In]) = DATEPART(MONTH,GETDATE()) AND DATEPART(YEAR,t0.[Date Booked In]) = DATEPART(YEAR,GETDATE()) THEN 'Y' ELSE 'N' END [BI TM],
CASE WHEN DATEPART(MONTH,t0.[Date Booked In]) = DATEPART(MONTH,GETDATE()) -1 AND DATEPART(YEAR,t0.[Date Booked In]) = DATEPART(YEAR,GETDATE()) THEN 'Y' ELSE 'N' END [BI LM],
CASE WHEN DATEPART(YEAR,t0.[Date Booked In]) = DATEPART(YEAR,GETDATE()) THEN 'Y' ELSE 'N' END [BI TY],
CASE WHEN t0.[Date Booked In] IS NOT NULL THEN 'Y' ELSE 'N' END [BI ALL],

CASE WHEN CAST(t0.[Promise Date] AS DATE) = CAST(GETDATE() AS DATE) THEN 'Y' ELSE 'N' END [DEL TD],
CASE WHEN CAST(t0.[Promise Date] AS DATE) = CAST(dateadd(day, +1 ,GETDATE()) AS DATE) THEN 'Y' 
	 WHEN DATEPART(DW, GETDATE()) = 6 AND CAST(t0.[Promise Date] AS DATE) = CAST(dateadd(day, 3,GETDATE()) AS DATE) THEN 'Y' 
	 ELSE 'N' END [DEL ND],  
CASE WHEN DATEPART(ISO_WEEK,t0.[Promise Date]) = DATEPART(ISO_WEEK,GETDATE()) AND DATEPART(YEAR,t0.[Promise Date]) = DATEPART(YEAR,GETDATE()) THEN 'Y' ELSE 'N' END [DEL TW],
CASE WHEN DATEPART(ISO_WEEK,t0.[Promise Date]) = (DATEPART(ISO_WEEK,GETDATE()) + 1) AND DATEPART(YEAR,t0.[Promise Date]) = DATEPART(YEAR,GETDATE()) THEN 'Y' ELSE 'N' END [DEL NW],
CASE WHEN DATEPART(MONTH,t0.[Promise Date]) = DATEPART(MONTH,GETDATE()) AND DATEPART(YEAR,t0.[Promise Date]) = DATEPART(YEAR,GETDATE()) THEN 'Y' ELSE 'N' END [DEL TM],
CASE WHEN DATEPART(MONTH,t0.[Promise Date]) = DATEPART(MONTH,GETDATE()) + 1 AND DATEPART(YEAR,t0.[Promise Date]) = DATEPART(YEAR,GETDATE()) THEN 'Y' ELSE 'N' END [DEL NM],
CASE WHEN DATEPART(YEAR,t0.[Promise Date]) = DATEPART(YEAR,GETDATE()) THEN 'Y' ELSE 'N' END [DEL TY],
CASE WHEN t0.[Promise Date] IS NOT NULL THEN 'Y' ELSE 'N' END [DEL ALL]


FROM (
SELECT 
    t0.U_IIS_proPrOrder [Prod Order], 
	t0.OriginNum [Sales Order],
	(case when t2.PrcrmntMtd = 'B' then 'Bought In' else 'Made' end) [Source],
	t0.itemcode, 
	t2.itemname, 
	t2.U_Location,
	CAST((case when t0.OriginNum is null then t0.PlannedQty else t3.Quantity end) AS DECIMAL (12,0)) [Qty_on_Order],
	CAST(t2.onhand AS DECIMAL (12,0)) [In Stock],
    t3.DelivrdQty,
	t4.[Booked In], t4.[Date Booked In], t4.[Time Booked In],
	(case when t0.OriginNum is null then t0.DueDate else t1.DocDueDate end) [Due Date],
	t3.U_Promise_Date [Promise Date],
	t4.[User],
	t1.CardName [Customer],
	t9.firstname + ' ' + t9.lastName [Sales Person], 
	t10.SlpName [Engineer],
	t1.Address2 [Ship_To]
	from owor t0
		inner join ordr t1 on t1.docnum = t0.OriginNum
		inner join rdr1 t3 on t3.DocEntry = t1.DocEntry and t3.ItemCode = t0.ItemCode
		inner join oitm t2 on t2.itemcode = t0.itemcode
		inner join ohem t9 on t9.empID = t1.OwnerCode
		inner join oslp t10 on t10.SlpCode = t1.SlpCode
		left join (select t4.docnum [Prod_Order],  t0.itemcode, t0.InQty [Booked In],
                          t0.DocDate [Date Booked In], t0.doctime [Time Booked In], t1.U_NAME [User]
                                                from oinm t0
                                                inner join ousr t1 on t1.USERID = t0.UserSign
                                                inner join oign t2 on t2.docnum = t0.Ref1
                                                inner join ign1 t3 on t3.DocEntry = t2.DocEntry and t3.ItemCode = t0.ItemCode
                                                inner join owor t4 on t4.docnum = t3.BaseEntry and t4.ItemCode = t0.ItemCode
                                                inner join iis_epc_pro_orderh t5 on t5.PrOrder = t4.U_IIS_proPrOrder and t5.EndProduct = t4.ItemCode
                                                where 1=1
                                                and t0.inqty > 0
                                                and t0.TransType not in (67,20)
                                                and t0.CardCode = '111070') t4 on t4.Prod_Order = t0.DocNum and t4.ItemCode = t0.ItemCode

inner join iis_epc_pro_orderh t8 on t8.PrOrder = t0.U_IIS_proPrOrder and t8.EndProduct = t0.ItemCode

where t0.Status not in ('C')
and (t3.LineStatus = 'o' or t3.LineStatus is null)


UNION ALL


select NULL [Prod Order], t0.docnum [Sales Order],
(case when t2.PrcrmntMtd = 'B' then 'Bought In' else 'Made' end) [Source], 
 t2.ItemCode, t2.ItemName, t2.U_Location [Location],
t1.Quantity [Qty on SO], CAST(t2.onhand AS DECIMAL (12,0)) [In Stock],  
t1.DelivrdQty,
NULL [Booked In],
NULL [Date Booked In], NULL [Time Booked In],
ISNULL(t1.U_Delivery_Date,t0.DocDueDate) [SO Due Date], 
t1.U_Promise_Date [Promise Date],
NULL [User], t0.CardName [Customer],
t9.firstname + ' ' + t9.lastName [Sales Person], t10.SlpName [Engineer], 
t0.Address2 [Ship To]
from ordr t0
inner join rdr1 t1 on t1.DocEntry = t0.DocEntry
inner join oitm t2 on t2.ItemCode = t1.ItemCode
inner join ohem t9 on t9.empID = t0.OwnerCode
inner join oslp t10 on t10.SlpCode = t0.SlpCode
left join owor t4 on t4.OriginNum = t0.docnum and t4.ItemCode = t1.ItemCode

where 1=1
and t1.ItemCode <> 'TRANSPORT'
and t4.docnum is null
and t1.LineStatus = 'o' ) t0

inner join oitm t1 on t1.ItemCode = t0.ItemCode
left join ordr t2 on t2.DocNum = t0.[Sales Order]
left join owor t3 on t3.DocNum = t0.[Prod Order]

where
t0.[Due Date] >= dateadd(d,-5000,CONVERT(date, GETDATE())) 
and t0.[Due Date] < dateadd(d,60,CONVERT(date, GETDATE()))

order by t0.[Promise Date], t0.[Sales Order]
";
?>





