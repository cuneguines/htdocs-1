<?php
$Quality_results = "select *,FORMAT(t20.date_updated,'dd-MM-yyyy')[date_updated],t77.person,FORMAT(t0.time_stamp,'dd-MM-yyyy')[time_stamp],t0.Id as ID,t20.Status,t20.Action,t20.Owner,FORMAT(t20.Date,'dd-MM-yyyy')[TargetDate],t50.CardName[Customer],t50.U_Client,t11.Dscription,t11.ItemCode,ISNULL(t12.U_Product_Group_One,'NO PRODUCT GROUP')[U_Product_Group_One],t12.U_Product_Group_Two,t12.U_Product_Group_Three,
(case
WHEN t20.Date!='01/01/1900  00:00:00' and
 t20.Date is not null then DateDiff(day,t20.Date,GETDATE())
end)[Days_open],
    (case 
WHEN  t44.attachments is null then 'N'  else t44.attachments
END) [attachements_issues]
    from ms_qual_log t0
    left join (select t1.ID,max(t1.date_updated) as Maxdate
        from  dbo.Table_2 t1
           where t1.Status='Cancelled' group by t1.ID )t2 on t2.ID = t0.ID
    left join(select t8.Status,t8.Date,t8.ID,t8.Owner,t8.Action,t8.date_updated from dbo.Table_2 t8
                        inner join(select t1.ID,max(t1.date_updated) as Mmaxdate
                        from  dbo.Table_2 t1
                        where t1.Status<>'Cancelled' group by t1.ID )t6 on t6.Mmaxdate = t8.date_updated and t6.ID=t8.ID)t20 on t20.ID=t0.ID and t20.Status<>'Cancelled'
    left join (select t0.* from  KENTSTAINLESS.dbo.ordr t0 )t50 on  t50.DocNum= nc_sales_order
left JOIN KENTSTAINLESS.dbo.rdr1 t11 on t11.DocEntry = t50.DocEntry and t11.U_IIS_proPrOrder=nc_process_order
left join KENTSTAINLESS.dbo.oitm t12 on t12.ItemCode = t11.ItemCode
left join KENTSTAINLESS.dbo.oitb t13 on t13.ItmsGrpCod = t12.ItmsGrpCod
left join(select t55.sap_id,t55.created_date,t55.attachments from dbo.attachment_table t55
inner join(select t1.sap_id,max(t1.created_date) as Mmaxdate
                    from  dbo.attachment_table t1
					

                     group by t1.sap_id )t66 on t66.Mmaxdate = t55.created_date and t66.sap_id=t55.sap_id)t44 on t44.sap_id = t0.ID and t44.attachments is not NULL
left join(select (t0.firstName + ' ' + t0.lastName)[person], t0.email

   from KENTSTAINLESS.dbo.ohem t0
   
   where t0.Active = 'Y' and t0.email is not NULL)t77 on t77.email COLLATE SQL_Latin1_General_CP1_CI_AS =t20.Owner COLLATE SQL_Latin1_General_CP1_CI_AS
   
    where t0.form_type = 'Non Conformance'
    and t2.ID is null ORDER BY t0.ID";

