
<?php

$Quality_results="select t0.code, t0.CreateDate, t0.UpdateDate, t0.U_area_nc, t0.U_area_nc_raised, 
t2.ItemCode, t2.ItemName, t2.U_Product_Group_One, t2.U_Product_Group_Two, t2.U_Product_Group_Three,
t3.ItmsGrpNam [Item Group], 
t0.U_Status, t0.U_nc_type, t0.U_nc_observation, 
t0.U_prev_action_owner, 
case when isnull(t0.U_root_cause_analysis,'N') like 'NA' then 'N' else isnull(t0.U_root_cause_analysis,'N') end [attachments_cause_analysis],

(case 

        WHEN t0.U_prev_action_report is null  then 'N' else t0.U_prev_action_report

END) [attachments_preve_action],
 t4.[attachements_issues]


from [dbo].[@QUALITY] t0

left join oitm t2 on t2.ItemCode = t0.U_itemcode
left join oitb t3 on t3.ItmsGrpCod = t2.ItmsGrpCod
inner join (select t0.code, SUM(case when t0.U_Attachments is null then 0 else 1 end) [attachements_issues]
                     from [dbo].[@QUAL_ATTACH] t0
                     group by t0.code) t4 on t4.Code = t0.Code
";
//Query to filters the rows that are cancelled from the second table and join with the first table which is not a match 
$Quality_results_non_conformance="select *,t0.Id as ID,t20.Status,
(case 
WHEN  t0.attachments ='' then 'N'  else t0.attachments
END) [attachements_issues]
from ms_qual_log t0
left join (select t1.ID,max(t1.date_updated) as Maxdate
    from  dbo.Table_2 t1
       where t1.Status='Cancelled' group by t1.ID )t2 on t2.ID = t0.ID
left join(select t8.Status,t8.ID,t8.date_updated from dbo.Table_2 t8
                    inner join(select t1.ID,max(t1.date_updated) as Mmaxdate
                    from  dbo.Table_2 t1
                    where t1.Status<>'Cancelled' group by t1.ID )t6 on t6.Mmaxdate = t8.date_updated and t6.ID=t8.ID)t20 on t20.ID=t0.ID and t20.Status<>'Cancelled'
where t0.form_type = 'Non Conformance'
and t2.ID is null




";
$Quality_results_customer_complaints="select *,t0.Id as ID,t20.Status,
(case 
WHEN  t0.attachments ='' then 'N'  else t0.attachments
END) [attachements_issues]
from ms_qual_log t0
left join (select t1.ID,max(t1.date_updated) as Maxdate
    from  dbo.Table_2 t1
       where t1.Status='Cancelled' group by t1.ID )t2 on t2.ID = t0.ID
left join(select t8.Status,t8.ID,t8.date_updated from dbo.Table_2 t8
                    inner join(select t1.ID,max(t1.date_updated) as Mmaxdate
                    from  dbo.Table_2 t1
                    where t1.Status<>'Cancelled' group by t1.ID )t6 on t6.Mmaxdate = t8.date_updated and t6.ID=t8.ID)t20 on t20.ID=t0.ID and t20.Status<>'Cancelled'
where t0.form_type = 'Customer Complaints'
and t2.ID is null";

$Quality_results_health_safety="select *,
(case 
WHEN  t0.attachments ='' then 'N'  else t0.attachments
END) [attachements_issues]
from ms_qual_log t0
where t0.form_type = 'Health & Safety - Accidents'
";
?>
<!-- select t0.code, FORMAT(CAST(t0.CreateDate AS DATE), 'dd-MM-yyyy')[CreateDate], FORMAT(CAST(t0.UpdateDate AS DATE), 'dd-MM-yyyy')[UpdateDate], t0.U_area_nc, t0.U_area_nc_raised, 
t2.ItemCode, t2.ItemName, t2.U_Product_Group_One, t2.U_Product_Group_Two, t2.U_Product_Group_Three,
t3.ItmsGrpNam [Item Group], 
t0.U_prev_action_report, 
 t1.U_Description,
t0.U_root_cause_analysis,
t0.U_Status, t0.U_nc_type, t0.U_nc_observation, t0.U_prev_action_owner, 
(case 

        WHEN t0.U_prev_action_report is null  then 'N' else t0.U_prev_action_report

END) [attachments_preve_action],
case when isnull(t0.U_root_cause_analysis,'N') like 'NA' then 'N' else isnull(t0.U_root_cause_analysis,'N') end [attachments_cause_analysis],
(case 
        WHEN  t1.U_Attachments is null  then 'N' else t1.U_Attachments
END) [attachements_issues]

from [dbo].[@QUALITY] t0
inner join [dbo].[@QUAL_ATTACH] t1 on t1.Code = t0.Code
left join oitm t2 on t2.ItemCode = t0.U_itemcode
left join oitb t3 on t3.ItmsGrpCod = t2.ItmsGrpCod -->