<?php
$Quality_results="select *,t0.Id as ID,t20.Status,t20.Owner,t20.Date[TargetDate],t50.CardName[Customer],t50.U_Client,
(case
WHEN t20.Date!='01/01/1900  00:00:00' and
 t20.Date is not null then DateDiff(day,t20.Date,GETDATE())
end)[Days_open],
    (case 
    WHEN  t0.attachments ='' then 'N'  else t0.attachments
    END) [attachements_issues]
    from ms_qual_log t0
    left join (select t1.ID,max(t1.date_updated) as Maxdate
        from  dbo.Table_2 t1
           where t1.Status='Cancelled' group by t1.ID )t2 on t2.ID = t0.ID
    left join(select t8.Status,t8.Date,t8.ID,t8.Owner,t8.date_updated from dbo.Table_2 t8
                        inner join(select t1.ID,max(t1.date_updated) as Mmaxdate
                        from  dbo.Table_2 t1
                        where t1.Status<>'Cancelled' group by t1.ID )t6 on t6.Mmaxdate = t8.date_updated and t6.ID=t8.ID)t20 on t20.ID=t0.ID and t20.Status<>'Cancelled'
    left join (select t0.* from  KENTSTAINLESS.dbo.ordr t0 )t50 on  t50.DocNum= nc_sales_order
    where t0.form_type = 'Non Conformance'
    and t2.ID is null ORDER BY t0.ID"
;