
<?php
$Quality_results_non_conformance_update="select *,t0.Id as ID,t20.Status,t20.Owner,t20.Action,t20.date_updated,
(case 
WHEN  t44.attachments is null then 'N'  else t44.attachments
END) [attachements_issues]
from ms_qual_log t0
left join (select t1.ID,max(t1.date_updated) as Maxdate
    from  dbo.Table_2 t1
       where t1.Status='Cancelled' group by t1.ID )t2 on t2.ID = t0.ID
left join(select t8.Status,t8.ID,t8.Owner,t8.Action,t8.date_updated from dbo.Table_2 t8
                    inner join(select t1.ID,max(t1.date_updated) as Mmaxdate
                    from  dbo.Table_2 t1
					

                    where t1.Status<>'Cancelled' group by t1.ID )t6 on t6.Mmaxdate = t8.date_updated and t6.ID=t8.ID)t20 on t20.ID=t0.ID and t20.Status<>'Cancelled'
					left join(select t55.sap_id,t55.created_date,t55.attachments from dbo.attachment_table t55
                    inner join(select t1.sap_id,max(t1.created_date) as Mmaxdate
                    from  dbo.attachment_table t1
					

                     group by t1.sap_id )t66 on t66.Mmaxdate = t55.created_date and t66.sap_id=t55.sap_id)t44 on t44.sap_id = t0.ID and t44.attachments is not NULL

where t0.form_type = 'Non Conformance'
and t2.ID is null

";?>

