<?php
$shippeditems =
"SELECT FORMAT(cast(t1.DocDate as date),'dd-MM-yyyy') [Date Shipped], 
t1.CardName [Customer], 
ISNULL(t1.U_Client,'NO PROJECT')[Project], 
t0.BaseDocNum [Sales Order],
t0.ItemCode, t0.Dscription, cast(t0.Quantity as decimal(12,0)) [Qty Shipped], 
cast(t3.OpenQty as decimal(12,0)) [Qty Remaining], FORMAT(cast(t3.U_Promise_Date as date),'dd-MM-yyyy') [Promise Date], 
t1.DocNum [Docket No], 
t1.Address2 [Delivery Address], 
ISNULL(t1.U_site_contact, 'NO CONTACT') [Site Contact],
datediff(d,t1.DocDate, GETDATE()) [Days_Open],
t4.firstname + ' ' + t4.lastName [Sales Person],
t3.U_BOY_38_EXT_REM [Comments_SO],
t1.Comments [Comments_DLN]
 
from dln1 t0
inner join odln t1 on t1.DocEntry = t0.DocEntry
inner join oitm t2 on t2.ItemCode = t0.ItemCode
left join rdr1 t3 on t3.itemcode = t0.ItemCode and t3.DocEntry = t0.BaseEntry and t3.LineNum = t0.BaseLine
inner join ohem t4 on t4.empID = t0.OwnerCode
 
where t1.DocDate >= dateadd(d,-31,getDATE())
and t2.InvntItem = 'Y'

order by [Date Shipped] desc


";
?>