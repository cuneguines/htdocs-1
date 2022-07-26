<?php

$mrp_sql = 
"SELECT 
t0.itemcode,
t0.itemname,
t0.itmsgrpnam [Stock Group],
CAST(t0.Committed AS DECIMAL (12,0)) [Committed],
CAST(t0.OnHand AS DECIMAL (12,0)) [In Stock],
CAST(t0.Ordered AS DECIMAL (12,0)) [Ordered],
CAST(t0.Offcuts AS DECIMAL (12,0)) [Offcuts],
CAST(t1.MinLevel AS DECIMAL (12,0)) [MinLevel],
CAST(t1.MaxLevel AS DECIMAL (12,0)) [MaxLevel], 
(case when ((t0.committed + t1.MinLevel) < t0.OnHand) then 'NULL' else t6.[Last Process Order] end) [Recent Process Order], t0.[Process Orders Open], 
t7.U_NAME [Code Creator],
CAST(t0.CreateDate AS DATE)[Code Created],
CAST(t8.[Promise Date] AS DATE) [Earliest Promise Date],
t9.SlpCode,
ISNULL(t10.SlpName, 'NO_ENGINEER') [Engineer]

from (
select t0.itemcode, t0.itemname, t2.itmsgrpnam, t0.DfltWH  [Warehouse], 
-((isnull(t1.onhand,0)) - (isnull(t3.Committed,0)) + (isnull(t0.OnOrder,0) - t0.MinLevel)) [Needed],
isnull(t1.onhand,0)[OnHand], 
isnull(t3.Committed,0) + isnull(t7.[CommittedSO],0) [Committed],
isnull(t0.OnOrder,0) [Ordered], 
isnull(t5.OnHand,0) [Offcuts],
t3.[Process Orders Open], t0.UserSign, t0.CreateDate


from oitm t0

----stock on hand
left join (
       select t0.itemcode,sum( t0.inqty - t0.outqty) [OnHand]
       from oinm t0
       where t0.Warehouse not in ('WAR_010', 'WAR_020') 
       group by t0.itemcode
       having sum( t0.inqty - t0.outqty) > 0 
       )t1 on t1.itemcode = t0.itemcode

---add in stock group name
inner join oitb t2 on t2.itmsgrpcod = t0.itmsgrpcod

---how many are committed to Pro Order 
left join (select t0.itemcode, t0.wareHouse, sum(t0.plannedqty - t0.issuedqty) [Committed], count(t2.U_IIS_proPrOrder) [Process Orders Open]
       from wor1 t0
       inner join oitm t1 on t1.itemcode = t0.itemcode
       inner join owor t2 on t2.docentry = t0.docentry
       left join ordr t3 on t3.DocNum = t2.OriginNum
       left join rdr1 t4 on t4.DocEntry = t3.DocEntry and t4.ItemCode = t2.ItemCode
       left join [dbo].[@PRE_PRODUCTION] as t5 on t5.code     = t4.U_PP_Stage
       left join [dbo].[@PRE_PROD_STATUS] as t6 on t6.code    = t4.U_PP_Status

       where 1= 1 
       --and t1.Invntitem = 'Y'
       and t2.status = 'R'
       and (t0.plannedqty - t0.issuedqty) > 0
       and (t4.U_In_Sub_Con not like 'Yes' or t4.U_In_Sub_Con is null)
       and (case when t6.[Name] is null then t4.U_PP_Status else t6.[Name] end) like 'Live'
       group by t0.itemcode, t0.wareHouse
       having sum(t0.plannedqty - t0.issuedqty) > 0) t3 on t3.itemcode = t0.itemcode 


--- how many in offcuts
left join (select t0.itemcode, t0.warehouse,sum( t0.inqty - t0.outqty) [OnHand]
       from oinm t0
       where t0.warehouse in ('WAR_020', 'WAR_010')
       group by t0.itemcode, t0.warehouse
       having sum( t0.inqty - t0.outqty) > 0 ) t5 on t5.itemcode = t0.ItemCode

---how many are committed to a sales order (not Prod)
left join(select t2.itemcode, sum(t0.openqty) [CommittedSO]
       from rdr1 t0
       inner join ordr t1 on t1.docentry = t0.docentry
       inner join oitm t2 on t2.itemcode = t0.itemcode
       where t0.linestatus = 'O'
       and t2.planingsys = 'M'
       and t2.PrcrmntMtd = 'M'
       and (t0.U_In_Sub_Con not like 'Yes')
       group by t2.itemcode) t7 on t7.itemcode = t0.itemcode

) t0

inner join oitm t1 on t1.ItemCode = t0.ItemCode

left join (select t0.ItemCode, MAX(t1.U_IIS_proPrOrder) [Last Process Order]
from wor1 t0 
inner join owor t1 on t1.DocEntry = t0.DocEntry
where t1.Status = 'R'
group by t0.ItemCode) t6 on t6.ItemCode = t0.ItemCode

inner join ousr t7 on t7.USERID = t0.UserSign

left join (select t0.itemcode, MIN(t0.U_promise_date) [Promise Date], MAX(t0.docentry) [Doc_entry]

from rdr1 t0
where t0.LineStatus = 'O'
group by t0.itemcode) t8 on t8.ItemCode = t0.ItemCode

left join rdr1 t9 on t9.DocEntry = t8.Doc_entry and t9.ItemCode = t0.ItemCode
left join oslp t10 on t10.SlpCode = t9.SlpCode

where 1=1 

and (t0.Committed + t1.Minlevel)  > (t0.OnHand + t0.Ordered)
and t1.InvntItem = 'Y'
and t1.PrcrmntMtd = 'M'
and (t0.Warehouse not in ('WAR_010', 'WAR_020') or t0.warehouse is null)
and t1.planingsys = 'M'
--and t1.itmsgrpcod <> '168'

order by t8.[Promise Date], t0.ItmsGrpNam, t0.ItemCode
";

?>