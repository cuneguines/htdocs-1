<?php $results="select YEAR(t0.CreateDate) [Year], 
MONTH(t0.CreateDate) [Month],
count(t1.PrOrder) [Process Orders Opened]

from owor t0
inner join iis_epc_pro_orderh t1 on t1.PrOrder = t0.U_IIS_proPrOrder and t1.EndProduct = t0.ItemCode

where 
YEAR(t0.CreateDate) >= YEAR(dateadd(YEAR,-1,GETDATE()))
and t0.Status <> 'C'

group by YEAR(t0.CreateDate), 
MONTH(t0.CreateDate) 

order by YEAR(t0.CreateDate), 
MONTH(t0.CreateDate)";
$results_1="select YEAR(T0.docdate) [Year],MONTH(T0.docdate) [Month], count(t0.[Process Order]) [Process Orders Delivered]


from(
              select distinct t0.ItemCode, t1.cardname, t0.BaseDocNum, t2.U_IIS_proPrOrder [Process Order], t1.DocDate
              
              from dln1 t0
              inner join odln t1 on t1.DocEntry = t0.DocEntry
              inner join owor t2 on t2.ItemCode = t0.ItemCode and t2.OriginNum = t0.BaseDocNum
              where 1=1 
              and t1.DocDate >= dateadd(m,-12,GETDATE())
              ---and t1.CardCode <> 'INT002'
) t0

group by YEAR(T0.docdate), MONTH(T0.docdate)

order by  YEAR(T0.docdate), MONTH(T0.docdate)";




?>
