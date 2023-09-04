<?php
$new_sales_orders_margin_query =
"SELECT t1.DocNum [Sales Order],
t1.CardName [Customer], t1.U_Client [Project],
t0.Dscription,
CAST(t1.docdate AS DATE) [Created], 
CAST(t1.DocDueDate AS DATE) [Delivery Date], 
datepart(iso_week,t1.DocDueDate) [Delivery Week], 
DATEDIFF(d, GETDATE(), t1.DocDueDate) [Days to Delivery],
t0.[Sales Value EUR], 
t0.[Cost Price EUR], t0.Margin, 
t3.firstname + ' ' + t3.lastName [Sales Person], t2.SlpName [Engineer], 
t1.U_Dimension1, t1.Comments

from (
select t1.DocNum [Sales Order],
isnull(t0.linetotal,0) [Sales Value EUR],
(t0.quantity * t0.[Margin Cost]) [Cost Price EUR],
t0.Dscription,

CAST ((isnull(t0.linetotal,0) - (t0.quantity * t0.[Margin Cost]))/isnull((t0.linetotal),1) AS DECIMAL(16,2)) 
 [Margin]



from ( select 
t1.docnum [Sales Order], 
t0.ItemCode, t0.Dscription, t0.Quantity, nullif(t0.LineTotal,0) [LineTotal], t2.AvgPrice [ICW],
t3.Price [Cost Price], t3.Currency, 
(case when t2.AvgPrice = 0 then t3.Price else t2.AvgPrice end) [Margin Cost]

from rdr1 t0
inner join ordr t1 on t1.DocEntry = t0.DocEntry
inner join oitm t2 on t2.ItemCode = t0.ItemCode
inner join itm1 t3 on t3.ItemCode = t0.ItemCode and t3.PriceList = 1
and t2.ItemCode <> 'TRANSPORT'
and t0.Dscription not like '%Placeholder%') t0

inner join ordr t1 on t1.DocNum = t0.[Sales Order]

) t0

inner join ordr t1 on t1.docnum = t0.[Sales Order]

inner join ohem t3 on t3.empID = t1.OwnerCode
inner join oslp t2 on t2.SlpCode = t1.SlpCode
WHERE t0.[Sales Order] LIKE '$sales_order'

order by DATEDIFF(d, GETDATE(), t1.DocDueDate)";
?>