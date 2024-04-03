<?php
$Quality_results_old = "select *,case when t0.nc_area_caused=''then 'No Area' when t0.nc_area_caused is NULL then 'No Area' else t0.nc_area_caused end [nc_area_caused],case when t0.area_raised_by ='' then 'NO Area' when t0.area_raised_by  is NULL then 'NO Area' else  t0.area_raised_by end [area_raised_],FORMAT(t20.date_updated,'dd-MM-yyyy')[date_updated],ISNULL(t77.person,'No Owner')[person],FORMAT(t0.time_stamp,'dd-MM-yyyy')[time_stamp],t0.Id as ID,
(case when t20.Status is NULL then 'Other'


when t20.Status='Open' then 'Open'
when t20.Status='Closed' then 'Closed'
end)
[Status],
t20.Action,ISNULL(t20.Owner,'No Owner')[Owner],FORMAT(t20.Date,'dd-MM-yyyy')[TargetDate],t50.CardName[Customer],t50.U_Client,t11.Dscription,t11.ItemCode,ISNULL(t12.U_Product_Group_One,'NO PRODUCT GROUP')[U_Product_Group_One],t12.U_Product_Group_Two,t12.U_Product_Group_Three,
(case 
when DateDiff(day,GETDATE(),t20.Date) >0 and DateDiff(day,GETDATE(),t20.Date) <=14 and t20.Status='Open' and t20.Date!='01/01/1900  00:00:00' then 'Due_next_two_weeks'


WHEN DATEDIFF(DAY,GETDATE(),t20.Date) >=-14  AND DATEDIFF(DAY,GETDATE(),t20.Date) <0 and t20.Status='Closed' and t20.Date!='01/01/1900  00:00:00' then 'Closed_last_two_weeks'
end )[new_stat],
(case
WHEN t20.Date!='01/01/1900  00:00:00' and
 t20.Date is not null then DateDiff(day,GETDATE(),t20.Date)
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
left join KENTSTAINLESS.dbo.oitm t12 on t12.ItemCode COLLATE SQL_Latin1_General_CP1_CI_AS= nc_itemcode COLLATE SQL_Latin1_General_CP1_CI_AS
left join KENTSTAINLESS.dbo.oitb t13 on t13.ItmsGrpCod = t12.ItmsGrpCod
left join(select t55.sap_id,t55.created_date,t55.attachments from dbo.attachment_table t55
inner join(select t1.sap_id,max(t1.created_date) as Mmaxdate
                    from  dbo.attachment_table t1
					

                     group by t1.sap_id )t66 on t66.Mmaxdate = t55.created_date and t66.sap_id=t55.sap_id)t44 on t44.sap_id = t0.ID and t44.attachments is not NULL
left join(select (t0.firstName + ' ' + t0.lastName)[person], t0.email

   from KENTSTAINLESS.dbo.ohem t0
   
   where t0.Active = 'Y' and t0.email is not NULL)t77 on t77.email COLLATE SQL_Latin1_General_CP1_CI_AS =t20.Owner COLLATE SQL_Latin1_General_CP1_CI_AS
   
   where t0.form_type in ('Non Conformance','Customer complaints','Opportunity For Improvement')
    and t2.ID is null ORDER BY  CAST(t0.ID AS int)";
    $Quality_results="SELECT  *,CASE WHEN ISNULL(t0.nc_description, '') = '' THEN t0.cc_desc ELSE t0.nc_description END as description, case when t0.nc_area_caused='' or t0.nc_area_caused is NULL then cc_area_caused else t0.nc_area_caused end [nc_area_caused], case when t0.area_raised_by = '' then 'NO Area' when t0.area_raised_by is NULL then 'NO Area' else t0.area_raised_by end [area_raised_], FORMAT(t20.date_updated, 'dd-MM-yyyy')[date_updated], ISNULL(t77.person, 'No Owner')[person], FORMAT(t0.time_stamp, 'dd-MM-yyyy')[time_stamp], t0.Id as ID, (case when t20.Status is NULL then 'Other' when t20.Status='Open' then 'Open' when t20.Status='Closed' then 'Closed' end) [Status], t20.Action, ISNULL(t20.Owner, 'No Owner')[Owner], FORMAT(t20.Date, 'dd-MM-yyyy')[TargetDate], t50.CardName[Customer], t50.U_Client, t11.Dscription, t11.ItemCode, ISNULL(t12.U_Product_Group_One, 'NO PRODUCT GROUP')[U_Product_Group_One], t12.U_Product_Group_Two, t12.U_Product_Group_Three, (case when DateDiff(day, GETDATE(), t20.Date) > 0 and DateDiff(day, GETDATE(), t20.Date) <= 14 and t20.Status='Open' and t20.Date!='01/01/1900 00:00:00' then 'Due_next_two_weeks' when DATEDIFF(DAY, GETDATE(), t20.Date) >= -14 and DATEDIFF(DAY, GETDATE(), t20.Date) < 0 and t20.Status='Closed' and t20.Date!='01/01/1900 00:00:00' then 'Closed_last_two_weeks' end) [new_stat], (case WHEN t20.Date!='01/01/1900 00:00:00' and t20.Date is not null then DateDiff(day, GETDATE(), t20.Date) end)[Days_open], (case WHEN t44.attachments is null then 'N' else t44.attachments END) [attachements_issues] FROM ms_qual_log t0 LEFT JOIN (SELECT t1.ID, MAX(t1.date_updated) as Maxdate FROM dbo.Table_2 t1 WHERE t1.Status='Cancelled' GROUP BY t1.ID) t2 ON t2.ID = t0.ID LEFT JOIN (SELECT t8.Status, t8.Date, t8.ID, t8.Owner, t8.Action, t8.date_updated FROM dbo.Table_2 t8 INNER JOIN (SELECT t1.ID, MAX(t1.date_updated) as Mmaxdate FROM dbo.Table_2 t1 WHERE t1.Status<>'Cancelled' GROUP BY t1.ID) t6 ON t6.Mmaxdate = t8.date_updated AND t6.ID=t8.ID) t20 ON t20.ID=t0.ID AND t20.Status<>'Cancelled' LEFT JOIN (SELECT t0.* FROM KENTSTAINLESS.dbo.ordr t0) t50 ON t50.DocNum=nc_sales_order LEFT JOIN KENTSTAINLESS.dbo.rdr1 t11 ON t11.DocEntry = t50.DocEntry AND t11.U_IIS_proPrOrder = nc_process_order or t11.U_IIS_proPrOrder = cc_process_order LEFT JOIN KENTSTAINLESS.dbo.oitm t12 ON t12.ItemCode COLLATE SQL_Latin1_General_CP1_CI_AS =  COALESCE(NULLIF(nc_itemcode,''), cc_itemcode) COLLATE SQL_Latin1_General_CP1_CI_AS LEFT JOIN KENTSTAINLESS.dbo.oitb t13 ON t13.ItmsGrpCod = t12.ItmsGrpCod LEFT JOIN (SELECT t55.sap_id, t55.created_date, t55.attachments FROM dbo.attachment_table t55 INNER JOIN (SELECT t1.sap_id, MAX(t1.created_date) as Mmaxdate FROM dbo.attachment_table t1 GROUP BY t1.sap_id) t66 ON t66.Mmaxdate = t55.created_date AND t66.sap_id = t55.sap_id) t44 ON t44.sap_id = t0.ID AND t44.attachments is not NULL LEFT JOIN (SELECT (t0.firstName + ' ' + t0.lastName)[person], t0.email FROM KENTSTAINLESS.dbo.ohem t0 WHERE t0.Active = 'Y' AND t0.email is not NULL) t77 ON t77.email COLLATE SQL_Latin1_General_CP1_CI_AS = t20.Owner COLLATE SQL_Latin1_General_CP1_CI_AS WHERE t0.form_type in ('Non Conformance', 'Customer complaints', 'Opportunity For Improvement') AND t2.ID IS NULL  and nc_description is not null ORDER BY CAST(t0.ID AS int)";

$qlty_results_cost="SELECT  
form_type,U_Dimension1,
t_new.U_rework_num,
CAST(t_new.[Issued Cost] AS DECIMAL(10)) AS RoundedCost,
t_new.[Process Order][R-ProcessOrder],
nc_process_order,
cc_process_order,
t_new.Date as reworkDate,


CASE 
       -- 
		When rtrim(ltrim(t0.cc_area_caused))='Wrapping/Dispatch' THEN 'Wrapping/Despatch'
       
		When rtrim(ltrim(t0.nc_area_caused))='Wrapping/Dispatch' THEN 'Wrapping/Despatch'

        When rtrim(ltrim(t0.cc_area_caused))='Packing/Despatch' THEN 'Wrapping/Despatch'
       
		When rtrim(ltrim(t0.nc_area_caused))='Packing/Despatch' THEN 'Wrapping/Despatch'
		When rtrim(ltrim(t0.cc_area_caused))='Line Feeding/Kitting ' THEN 'Line Feed/Kitting'
			When rtrim(ltrim(t0.nc_area_caused))='Line Feeding/Kitting ' THEN 'Line Feed/Kitting'
		When rtrim(ltrim(t0.cc_area_caused))='Sub Contractor' THEN 'Sub Contract Vendor'
		When rtrim(ltrim(t0.nc_area_caused))='Sub Contractor' THEN 'Sub Contract Vendor'
		When rtrim(ltrim(t0.nc_area_caused))='Subcontractor' THEN 'Sub Contract Vendor'
		When rtrim(ltrim(t0.cc_area_caused))='Subcontractor' THEN 'Sub Contract Vendor'
		When rtrim(ltrim(t0.cc_area_caused))='Incoming Goods/Store' THEN 'Goods Inward/Store'
		When rtrim(ltrim(t0.nc_area_caused))='Incoming Goods/Store' THEN 'Goods Inward/Store'


		WHEN t0.nc_area_caused='' or t0.nc_area_caused is NULL THEN cc_area_caused 
        ELSE t0.nc_area_caused 
    END [nc_area_caused_], 
CASE 
    WHEN ISNULL(t0.nc_description, '') = '' THEN t0.cc_desc 
    ELSE t0.nc_description 
END as description, 
CASE 
    WHEN t0.nc_area_caused='' or t0.nc_area_caused is NULL THEN cc_area_caused 
    ELSE t0.nc_area_caused 
END [nc_area_caused], 
CASE 
    WHEN t0.area_raised_by = '' THEN 'NO Area' 
    WHEN t0.area_raised_by is NULL THEN 'NO Area' 
    ELSE t0.area_raised_by 
END [area_raised_], 
FORMAT(t20.date_updated, 'dd-MM-yyyy')[date_updated], 
ISNULL(t77.person, 'No Owner')[person], 
FORMAT(t0.time_stamp, 'dd-MM-yyyy')[time_stamp], 
t0.Id as ID, 
(CASE 
    WHEN t20.Status is NULL THEN 'Other' 
    WHEN t20.Status='Open' THEN 'Open' 
    WHEN t20.Status='Closed' THEN 'Closed' 
END) [Status], 
t20.Action, 
ISNULL(t20.Owner, 'No Owner')[Owner], 
FORMAT(t20.Date, 'dd-MM-yyyy')[TargetDate], 
t50.CardName[Customer], 
t50.U_Client, 
t11.Dscription, 
t11.ItemCode, 
ISNULL(t12.U_Product_Group_One, 'NO PRODUCT GROUP')[U_Product_Group_One], 
t12.U_Product_Group_Two, 
t12.U_Product_Group_Three, 
(CASE 
    WHEN DateDiff(day, GETDATE(), t20.Date) > 0 
        AND DateDiff(day, GETDATE(), t20.Date) <= 14 
        AND t20.Status='Open' 
        AND t20.Date!='01/01/1900 00:00:00' 
    THEN 'Due_next_two_weeks' 
    WHEN DATEDIFF(DAY, GETDATE(), t20.Date) >= -14 
        AND DATEDIFF(DAY, GETDATE(), t20.Date) < 0 
        AND t20.Status='Closed' 
        AND t20.Date!='01/01/1900 00:00:00' 
    THEN 'Closed_last_two_weeks' 
END) [new_stat], 
(CASE 
    WHEN t20.Date!='01/01/1900 00:00:00' 
        AND t20.Date is not null 
    THEN DateDiff(day, GETDATE(), t20.Date) 
END) [Days_open], 
(CASE 
    WHEN t44.attachments is null THEN 'N' 
    ELSE t44.attachments 
END) [attachements_issues] 
FROM ms_qual_log t0 
LEFT JOIN (
SELECT 
    t1.ID, 
    MAX(t1.date_updated) as Maxdate 
FROM dbo.Table_2 t1 
WHERE t1.Status='Cancelled' 
GROUP BY t1.ID
) t2 ON t2.ID = t0.ID 
LEFT JOIN (
SELECT 
    t8.Status, 
    t8.Date, 
    t8.ID, 
    t8.Owner, 
    t8.Action, 
    t8.date_updated 
FROM dbo.Table_2 t8 
INNER JOIN (
    SELECT 
        t1.ID, 
        MAX(t1.date_updated) as Mmaxdate 
    FROM dbo.Table_2 t1 
    WHERE t1.Status<>'Cancelled' 
    GROUP BY t1.ID
) t6 ON t6.Mmaxdate = t8.date_updated AND t6.ID=t8.ID
) t20 ON t20.ID=t0.ID AND t20.Status<>'Cancelled' 
LEFT JOIN (
SELECT 
    t0.* 
FROM KENTSTAINLESS.dbo.ordr t0
) t50 ON t50.DocNum=nc_sales_order 
LEFT JOIN KENTSTAINLESS.dbo.rdr1 t11 ON t11.DocEntry = t50.DocEntry AND  (t11.U_IIS_proPrOrder = COALESCE(NULLIF(nc_process_order,''),cc_process_order))
LEFT JOIN KENTSTAINLESS.dbo.oitm t12 ON t12.ItemCode COLLATE SQL_Latin1_General_CP1_CI_AS = COALESCE(NULLIF(nc_itemcode,''), cc_itemcode) COLLATE SQL_Latin1_General_CP1_CI_AS 
LEFT JOIN KENTSTAINLESS.dbo.oitb t13 ON t13.ItmsGrpCod = t12.ItmsGrpCod 
LEFT JOIN (
SELECT 
    t55.sap_id, 
    t55.created_date, 
    t55.attachments 
FROM dbo.attachment_table t55 
INNER JOIN (
    SELECT 
        t1.sap_id, 
        MAX(t1.created_date) as Mmaxdate 
    FROM dbo.attachment_table t1 
    GROUP BY t1.sap_id
) t66 ON t66.Mmaxdate = t55.created_date AND t66.sap_id = t55.sap_id
) t44 ON t44.sap_id = t0.ID AND t44.attachments is not NULL 
LEFT JOIN (
SELECT 
    (t0.firstName + ' ' + t0.lastName)[person], 
    t0.email 
FROM KENTSTAINLESS.dbo.ohem t0 
WHERE t0.Active = 'Y' AND t0.email is not NULL
) t77 ON t77.email COLLATE SQL_Latin1_General_CP1_CI_AS = t20.Owner COLLATE SQL_Latin1_General_CP1_CI_AS 
LEFT JOIN (
select t0.U_rework_num, t0.U_IIS_proPrOrder [Process Order], sum(t0.[Issued Cost At Time]) [Issued Cost],max(t25.CreateDate) as Date


from (
select t1.ItemCode [End Product], t3.ItemName [EP Name], t1.project, t1.OriginNum, t1.U_IIS_proPrOrder, t1.DocNum [Prod Order], t0.ItemCode, t2.ItemName, 
t0.PlannedQty, t0.IssuedQty
, (t0.PlannedQty * t2.AvgPrice) [Planned Cost]
, t0.IssuedQty * t2.AvgPrice [Issued Cost Now]
, isnull(t5.[Issued Cost],0) [Issued Cost At Time]
, t2.PrcrmntMtd, t4.ItmsGrpNam, 'MATERIAL' [TYPE], t1.CreateDate, t1.CloseDate, t1.Status, t1.PlannedQty [EP Planned], t1.CmpltQty [Completed], t3.U_rework_num

from KENTSTAINLESS.dbo.wor1 t0
inner join KENTSTAINLESS.dbo.owor t1 on t1.DocEntry = t0.DocEntry
inner join KENTSTAINLESS.dbo.oitm t2 on t2.itemcode = t0.ItemCode
inner join KENTSTAINLESS.dbo.oitm t3 on t3.itemcode = t1.ItemCode
inner join KENTSTAINLESS.dbo.oitb t4 on t4.ItmsGrpCod = t2.ItmsGrpCod

left join (----- Issue to Productions -----
select  t1.[Prod Order], 
 t1.[U_IIS_proPrOrder], t0.ItemCode, t1.[Prod_Ord_Line],
sum(-t0.TransValue) [Issued Cost], sum(t0.OutQty) [Issued Qty]

from KENTSTAINLESS.dbo.oinm t0
inner join (select t1.DocNum [Issue_Num], t1.ObjType, t0.baseref [Prod Order], t0.ItemCode, t0.LineNum, t2.U_IIS_proPrOrder, t2.OriginNum, t0.BaseLine [Prod_Ord_Line]

                     from KENTSTAINLESS.dbo.ige1 t0
                     inner join KENTSTAINLESS.dbo.oige t1 on t1.DocEntry = t0.DocEntry
                     inner join KENTSTAINLESS.dbo.owor t2 on t2.DocNum = t0.BaseRef 
                     where t0.BaseLine is not null
                     ) t1 on t1.Issue_Num = t0.BASE_REF and t1.ItemCode = t0.ItemCode and t0.TransType = t1.ObjType
inner join KENTSTAINLESS.dbo.oitm t4 on t4.ItemCode = t0.ItemCode
inner join KENTSTAINLESS.dbo.oitb t5 on t5.ItmsGrpCod = t4.ItmsGrpCod
group by t1.[Prod Order], 
 t1.[U_IIS_proPrOrder], t0.ItemCode, t1.[Prod_Ord_Line]) t5 on t5.[Prod Order] = t1.DocNum and t5.U_IIS_proPrOrder = t1.U_IIS_proPrOrder and t5.ItemCode = t0.ItemCode and t5.Prod_Ord_Line = t0.LineNum

where  t2.ItemType <> 'L'
and t1.U_IIS_proPrOrder is not null
and t3.U_rework_num is not null


and t1.Status <> 'C'
---and t1.ItemCode  in ()
--and t1.OriginNum in ()


UNION ALL 


select t1.ItemCode [End Product], t3.ItemName [EP Name], t1.project, t1.OriginNum,t1.U_IIS_proPrOrder, t1.DocNum [Prod Order], t0.StepItem, t2.ItemName, 
t0.PlannedHrs, t5.[Hours Booked]
, (t0.PlannedHrs * t2.AvgPrice) [Planned Cost]
, t5.[Hours Booked] * t2.AvgPrice [Issued Cost Now]
, t5.[Hours Booked] * t2.AvgPrice [Issued Cost At Time]
, t2.PrcrmntMtd, t4.ItmsGrpNam,  case when t4.ItmsGrpNam like 'MACHINE LASER' then 'MACHINE LASER' else 'LABOUR' end [TYPE], t1.CreateDate, t1.CloseDate, 
t1.Status, t1.PlannedQty [EP Planned], t1.CmpltQty [Completed],
t3.U_rework_num

from  KENTSTAINLESS.dbo.owor t1
inner join KENTSTAINLESS.dbo.IIS_EPC_PRO_ORDERH t25 on t25.PrOrder = t1.U_IIS_proPrOrder and t25.EndProduct = t1.ItemCode
inner join (
              select t0.PrOrder, t0.stepitem, sum(t0.processtime) [PlannedHrs]

              from KENTSTAINLESS.dbo.iis_epc_pro_orderl t0
              inner join (select t0.PrOrder, t0.StepItem, t0.LineID

                                  from KENTSTAINLESS.dbo.iis_epc_pro_orderl t0
                                  left join KENTSTAINLESS.dbo.owor t1 on t1.ItemCode = t0.StepItem and t1.U_IIS_proPrOrder = t0.PrOrder

                                  where 
                                  1=1
                                  and t1.Status <> 'C') as t1 on t1.PrOrder = t0.PrOrder and t0.ParentLine = t1.LineID

              where t0.StepType = 'P'

              group by t0.PrOrder, t0.stepitem) as t0 on t0.PrOrder = t1.U_IIS_proPrOrder


inner join KENTSTAINLESS.dbo.oitm t2 on t2.itemcode = t0.StepItem
inner join KENTSTAINLESS.dbo.oitm t3 on t3.itemcode = t1.ItemCode
inner join KENTSTAINLESS.dbo.oitb t4 on t4.ItmsGrpCod = t2.ItmsGrpCod
left join (
                           select t0.prorder, t0.labourcode, isnull(sum(t0.quantity),0) [Hours Booked]
                           from KENTSTAINLESS.dbo.iis_epc_pro_ordert t0
                           group by t0.prorder, t0.labourcode) t5 on t5.PrOrder = t1.U_IIS_proPrOrder and t5.LabourCode = t0.StepItem

where  t2.ItemType = 'L' 
--and t1.U_IIS_proPrOrder = 52927
and t3.U_rework_num is not null
and t1.Status <> 'C'

) t0
left join kentstainless.dbo.IIS_EPC_PRO_ORDERH t25 on t25.PrOrder = t0.U_IIS_proPrOrder ---and t25.EndProduct = t0.ItemCode
group by t0.U_rework_num, t0.U_IIS_proPrOrder

) t_new ON t_new.U_rework_num=t0.ID
where  t0.form_type IN ('Non Conformance', 'Customer complaints', 'Opportunity For Improvement') 
AND t2.ID IS NULL 
AND nc_description IS NOT NULL 
---and t20.Date<>'01-01-1900'
ORDER BY 
CAST(t0.ID AS int) desc";