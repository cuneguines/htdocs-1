<?php
$sales_exceptions ="with credit_status as (                  select t0.CardCode, t0.CardName, t0.Balance, 
isnull(t2.Del_Value,0) [Del Value], isnull(t3.SO_Value,0) [SO Value],
isnull(t2.Del_ValueFC,0) [Del ValueFC], isnull(t3.SO_ValueFC,0) [SO ValueFC],
t0.CreditLine,
t1.PymntGroup, t1.ExtraDays, t1.ExtraMonth, t1.TolDays, t1.PayDuMonth,
case 
when t0.CardCode in ('INT002', 'RIC001') then 'OK - MAJOR CUSTOMERS'
when t0.Balance <= (isnull(t3.SO_Value,0) + isnull(t2.Del_Value,0))  and t0.Balance < 0 then 'OK - PAID IN ADV'
when t0.BalanceFC <= (isnull(t3.SO_ValueFC,0) + isnull(t2.Del_ValueFC,0))  and t0.BalanceFC < 0 then 'OK - PAID IN ADV'
when t0.CreditLine = 0.01 then 'ON HOLD - NO TERMS'
when t4.[Value Overdue] > 0 and t4.[Value Overdue] is not null and t0.Balance > 0 then 'ON HOLD - INV DUE'
when t0.Balance > t0.CreditLine then 'ON HOLD - CURRENT BALANCE OVER TERMS' 
when (t0.Balance + isnull(t3.SO_Value,0) + isnull(t2.Del_Value,0)) <= t0.creditline then 'OK - UNDER TERMS'
when (t0.Balance + isnull(t2.Del_Value,0)) > t0.creditline then 'ON HOLD - CURRENT DELIVERIES PUSH OVER TERMS'
else 'OK' 
end [Within_Line], 
t4.[Overdue Invoices], t4.[Value Overdue]


from ocrd t0
inner join OCTG t1 on t1.GroupNum = t0.GroupNum

left join (
             select t1.cardcode, sum(t0.linetotal) [Del_Value], sum(t0.TotalFrgn) [Del_ValueFC]

             from dln1 t0
             inner join odln t1 on t1.DocEntry = t0.DocEntry
             where t0.LineStatus = 'o'

             group by t1.CardCode) t2 on t2.CardCode = t0.CardCode

left join (
             select t1.cardcode, sum(t0.linetotal/(t0.openqty/t0.quantity)) [SO_Value], sum(t0.TotalFrgn/(t0.openqty/t0.quantity)) [SO_ValueFC]

             from rdr1 t0
             inner join odln t1 on t1.DocEntry = t0.DocEntry
             where t0.LineStatus = 'o'

             group by t1.CardCode
             )t3 on t3.CardCode = t0.CardCode

left join (
             select t0.cardcode, count(case when t0.[Invoice Status] like 'Overdue' then 1 end) [Overdue Invoices],
             sum(case when t0.[Invoice Status] like 'Overdue' then isnull(t0.DocTotal,0) end) [Value Overdue]


             from (
             select t1.CardCode, datediff(d, t1.DocDate, getdate()) [Days Unpaid], 
             t1.DocDueDate [due_date],
             datediff(d, t1.DocDueDate, getdate()) [Days Over Due Date],
             case when datediff(d, t1.DocDueDate, getdate())  > 0 then 'Overdue'
             else 'In Terms' end [Invoice Status], t1.DocTotal

             from  oinv t1 

             where t1.DocStatus = 'o') t0

             group by t0.cardcode) t4 on t4.CardCode = t0.CardCode


where t0.CardType = 'C' and t0.validFor = 'Y')





select t1.docnum [Sales Order], t6.PrOrder [Process Order], t1.CardCode, 
t1.cardname, t0.ItemCode, left(t0.Dscription,40) [Item Desc], t0.LineTotal [Item Value], t2.[Open SO Value], --t3.Name [Pre Prod Status],
CAST(isnull(t0.U_delivery_date, t1.DocDueDate) AS DATE) [Book Out Date], 
CAST(t0.U_Promise_Date  AS DATE) [Promise Date], --t4.Within_Line,
case 
when t4.Within_Line like 'ON HOLD%' then t4.Within_Line
when t5.country not like 'IE' and (t2.[Open SO Value FC] + t4.[Del ValueFC] + t5.BalanceFC) > t4.creditline then 'ON HOLD - THIS WILL PUSH OVER TERMS'
when t5.country  like 'IE' and (t2.[Open SO Value] + t4.[Del Value] + t4.Balance) > t4.creditline + 100 then 'ON HOLD - THIS WILL PUSH OVER TERMS'
else t4.Within_Line end [Acc Status], t5.CreditLine [Credit Terms], (case when t5.Currency = 'EUR' then t5.Balance else t5.BalanceFC end) [Balance], t5.currency [Curr], t10.firstname + ' ' + t10.lastName [Sales Person], t20.SlpName [Engineer]

from rdr1 t0
inner join ordr t1 on t1.DocEntry = t0.DocEntry

inner join (
select t1.docnum, t0.U_Promise_Date, sum(t0.linetotal) [Open SO Value], sum(t0.TotalFrgn) [Open SO Value FC]
from rdr1 t0
inner join ordr t1 on t1.DocEntry = t0.DocEntry
where t0.LineStatus = 'o'
group by t1.docnum, t0.U_Promise_Date) t2 on t2.DocNum = t1.DocNum and t2.U_Promise_Date = t0.U_Promise_Date

inner join [dbo].[@PRE_PROD_STATUS] t3 on t0.U_PP_Status = t3.Code

left join credit_status t4 on t4.CardCode = t1.CardCode

inner join ocrd t5 on t5.CardCode = t1.CardCode

left join iis_epc_pro_orderh t6 on t6.SONum = t1.docnum and t6.EndProduct = t0.ItemCode

inner join ohem t10 on t10.empID = t1.OwnerCode
inner join oslp t20 on t20.SlpCode = t1.SlpCode

where t0.LineStatus = 'o'
and t3.Name not like 'Pre Production Potential'
and t0.ItemCode <> 'TRANSPORT'
and ((t2.[Open SO Value FC] + t4.[Del ValueFC] + t5.BalanceFC) > t4.creditline OR (t2.[Open SO Value] + t4.[Del Value] + t4.Balance) > t4.creditline + 100) 
AND 
(case 
when t4.Within_Line like 'ON HOLD%' then t4.Within_Line
when t5.country not like 'IE' and (t2.[Open SO Value FC] + t4.[Del ValueFC] + t5.BalanceFC) > t4.creditline then 'ON HOLD - THIS WILL PUSH OVER TERMS'
when t5.country  like 'IE' and (t2.[Open SO Value] + t4.[Del Value] + t4.Balance) > t4.creditline + 100 then 'ON HOLD - THIS WILL PUSH OVER TERMS'
else t4.Within_Line end ) like 'ON HOLD%'
and t1.CardCode <> 'KEN021'

order by t0.U_Promise_Date,isnull(t0.U_delivery_date, t1.DocDueDate)
";
?>
