
<?php $margin_tracker_old="with sales_orders as (--- Sales Order Details -----

select t1.docnum [Sales Order], 
t1.cardcode, t1.CardName, 
t1.U_Client, t1.DocDate, 
t0.ItemCode, t0.Dscription, t0.Quantity, 
t0.linetotal, t0.LineNum,

t2.CmpltQty, t2.U_IIS_proPrOrder [Process Order],
CASE
        WHEN t3.[Name] is null THEN 'NO STATUS'
        ELSE t3.[Name]
    END AS [PP Status],
isnull(t0.DelivrdQty,0) [DelivrdQty], 
t0.LineStatus, t1.DocStatus [so_status],
isnull(t0.U_delivery_date, t1.DocDueDate) [Due_Date],
t0.StockPrice * t0.Quantity [SO_Original_Cost]

from rdr1 t0
inner join ordr t1 on t1.DocEntry = t0.DocEntry
left join 
      ( select t0.*

      from owor t0
             inner join (
      --- Valid Process Orders 

             select  distinct t0.prorder 

             from (--- all closed process orders that had some item/hour issued to them

             select t0.docnum, t1.PrOrder
             from owor t0
             inner join iis_epc_pro_orderh t1 on t1.PrOrder = t0.U_IIS_proPrOrder and t1.EndProduct = t0.ItemCode
             inner join wor1 t2 on t2.DocEntry = t0.DocEntry
             where t0.Status <> 'C'
             group by t0.docnum, t1.PrOrder
             having sum(t2.issuedqty) > 0

             UNION ALL 

             --- All released Process Orders
             select t0.docnum, t1.PrOrder
             from owor t0
             inner join iis_epc_pro_orderh t1 on t1.PrOrder = t0.U_IIS_proPrOrder and t1.EndProduct = t0.ItemCode
             where t0.Status = 'R') t0 ) t1 on t1.prorder = t0.U_IIS_proPrOrder) t2 on t2.ItemCode = t0.ItemCode and t2.OriginNum = t1.DocNum


left join [dbo].[@PRE_PROD_STATUS]  t3 on t3.Code = t0.U_PP_Status


where 1=1 
---and t1.DocDate >= '01.01.2022'
and t0.ItemCode <> 'TRANSPORT'
and t1.CANCELED <> 'Y'
),

              

delivery as (
select t0.ItemCode, t0.BaseDocNum, t0.BaseLine, sum(t0.Quantity) [Qty Delivered], sum(t0.Cost_Del) [Cost at Delivery]

from (select t0.ItemCode, t0.BaseDocNum,t0.Quantity, 
             t0.StockPrice, t0.Quantity*t0.StockPrice [Cost_Del], t0.BaseLine

             from dln1 t0
             inner join odln t1 on t1.DocEntry = t0.DocEntry
             inner join oitm t2 on t2.ItemCode = t0.ItemCode

             --where t1.DocDate >= '01.01.2022'
             ) t0

group by t0.ItemCode, t0.BaseDocNum, t0.BaseLine
),

good_returns as (
      select t0.ItemCode, t0.BaseDocNum, t0.BaseLine, -sum(t0.Quantity) [Qty Returned], -sum(t0.Cost_Del) [Cost at Return]

from (select t0.ItemCode, t3.BaseDocNum,t0.Quantity, 
             t0.StockPrice, t0.Quantity*t0.StockPrice [Cost_Del], t3.BaseLine

             from rdn1 t0
             inner join ordn t1 on t1.DocEntry = t0.DocEntry
             inner join oitm t2 on t2.ItemCode = t0.ItemCode
             inner join dln1 t3 on t3.LineNum = t0.BaseLine and t3.DocEntry = t0.BaseEntry and t3.ItemCode = t0.ItemCode

             ---where t1.DocDate >= '01.01.2022'
             ) t0

group by t0.ItemCode, t0.BaseDocNum, t0.BaseLine),

bom_costs as (
select t0.father, sum((t0.quantity*t0.Price)/t1.Qauntity) [BOM Cost]

from itt1 t0
inner join oitt t1 on t1.Code = t0.Father

group by t0.father),

extra_prod_costs  as (

select t0.[End Product], t0.[Process Order], t0.originnum, sum(t0.[Extra Cost]) [Extra Prod Ord Cost]

             from (
             select t1.ItemCode [End Product], t0.ItemCode, t0.PlannedQty [Prod Ord Planned Qty], 
             isnull((t3.Quantity*t1.PlannedQty)/t2.Qauntity,0) [BOM Planned Qty], 
             t0.PlannedQty -isnull((t3.Quantity*t1.PlannedQty)/t2.Qauntity,0) [Qty Over BOM], 
             t1.U_IIS_proPrOrder [Process Order],
             (t0.PlannedQty - isnull((t3.Quantity*t1.PlannedQty)/t2.Qauntity,0))*t5.AvgPrice [Extra Cost], t1.originnum

             from wor1 t0
             inner join owor t1 on t1.DocEntry = t0.DocEntry
             inner join oitt t2 on t2.code = t1.ItemCode
             left join itt1 t3 on t3.Code = t0.ItemCode and t3.Father = t2.Code
             inner join iis_epc_pro_orderh t4 on t4.PrOrder = t1.U_IIS_proPrOrder and t4.EndProduct = t1.ItemCode
             inner join oitm t5 on t5.ItemCode = t0.ItemCode) t0

group by t0.[End Product], t0.[Process Order], t0.originnum),

extra_mat_cost_issued as (
             select t1.U_IIS_proPrOrder, t1.OriginNum, t1.ItemCode, sum((t0.IssuedQty- t0.PlannedQty)*t2.AvgPrice) [Extra Mat Cost Issued]

             from wor1 t0
             inner join owor t1 on t1.DocEntry = t0.DocEntry
             inner join oitm t2 on t2.ItemCode = t0.ItemCode
             where t0.IssuedQty > t0.PlannedQty
             and t2.ItemType <> 'L'

             group by t1.U_IIS_proPrOrder, t1.OriginNum, t1.ItemCode
             ),

extra_lab_cost_issued as(
             select t1.U_IIS_proPrOrder, t1.OriginNum, t1.ItemCode, sum((t3.[Act Hours]- t0.PlannedQty)*t2.AvgPrice) [Extra Lab Cost Issued]

             from wor1 t0
             inner join owor t1 on t1.DocEntry = t0.DocEntry
             inner join oitm t2 on t2.ItemCode = t0.ItemCode

             left join (select t0.PrOrder, t1.EndProduct, t0.labourcode, sum(t0.Quantity) [Act Hours]

                                  from iis_epc_pro_ordert t0
                                  inner join iis_epc_pro_orderh t1 on t1.PrOrder = t0.PrOrder

                                  group by t0.PrOrder, t1.EndProduct, t0.labourcode) t3 on t3.LabourCode = t0.ItemCode and t3.PrOrder = t1.U_IIS_proPrOrder and t3.EndProduct = t1.ItemCode

             where t0.IssuedQty > t0.PlannedQty
             and t2.ItemType = 'L'

             group by t1.U_IIS_proPrOrder, t1.OriginNum, t1.ItemCode)






select t0.[Sales Order], t0.CardCode, t0.CardName, t0.U_client, t0.[PP Status],
FORMAT(t8.RlsDate, 'dd-MM-yy') AS RlsDate,
CASE
WHEN CAST(t8.RlsDate AS DATE) = CAST(GETDATE() AS DATE) THEN 'Today'
WHEN CAST(t8.RlsDate AS DATE) = CAST(DATEADD(DAY, -1, GETDATE()) AS DATE) THEN 'Yesterday'
WHEN CAST(t8.RlsDate AS DATE) = CAST(DATEADD(DAY, -2, GETDATE()) AS DATE) THEN 'Two Days Ago'
WHEN CAST(t8.RlsDate AS DATE) >= CAST(DATEADD(DAY, -3, GETDATE()) AS DATE) THEN 'Last Three Days'
WHEN CAST(t8.RlsDate AS DATE) >= CAST(DATEADD(DAY, -5, GETDATE()) AS DATE) THEN 'Last Five Days'
WHEN CAST(t8.RlsDate AS DATE) >= CAST(DATEADD(WEEK, -1, GETDATE()) AS DATE) THEN 'Last Week'
        WHEN CAST(t8.RlsDate AS DATE) >= CAST(DATEADD(MONTH, -1, GETDATE()) AS DATE) THEN 'Last Month'
        WHEN YEAR(t8.RlsDate) = 2022 THEN 'Year 2022'
        WHEN YEAR(t8.RlsDate) = 2021 THEN 'Year 2021'
        WHEN YEAR(t8.RlsDate) = 2023 THEN 'Year 2023'
ELSE 'Other'
END AS DateCategory,
FORMAT(t0.DocDate, 'dd-MM-yy') AS DocDate,  FORMAT(t0.Due_Date, 'dd-MM-yy') AS Due_Date, t0.ItemCode, t0.Dscription, t0.Quantity, t0.DelivrdQty, 
(case when t0.LineStatus = 'C' then 0
else (t0.Quantity - t0.DelivrdQty) end) [OpenQty], t0.[Process Order], t0.CmpltQty, 
t0.LineStatus,t0.LineNum, t0.so_status, 
t1.PrcrmntMtd, t2.[Qty Delivered], t2.[Cost at Delivery], 
(case when t2.[Qty Delivered] > t0.DelivrdQty then 'Return'
else '' end) [Delivery Return], 
t3.[Cost at Return], t3.[Qty Returned],
t0.LineTotal [Sales Value],
t0.SO_Original_Cost,
case when t1.PrcrmntMtd = 'B' then t1.avgprice * t0.quantity else 
isnull(t4.[BOM Cost] * t0.Quantity,t0.SO_Original_Cost ) end [Planned_BOM_Cost],
case when t1.PrcrmntMtd = 'B' then t1.avgprice * t0.quantity else 
isnull(t4.[BOM Cost] * t0.Quantity,t0.SO_Original_Cost) + isnull(t5.[Extra Prod Ord Cost],0) end [Planned Prod Order Cost],
case when t1.PrcrmntMtd = 'B' then t1.avgprice * t0.quantity else 
isnull(t4.[BOM Cost] * t0.Quantity,t0.SO_Original_Cost) + isnull(t5.[Extra Prod Ord Cost],0) + isnull(t6.[Extra Mat Cost Issued],0) + isnull(t7.[Extra Lab Cost Issued],0) end [Likely Prod Ord Cost],
case when t1.PrcrmntMtd = 'B' and t0.LineTotal > 0 then (t0.LineTotal - (t1.avgprice * t0.quantity))/t0.LineTotal 
when t1.PrcrmntMtd = 'B' and t0.LineTotal = 0 then 0 
when t0.LineTotal > 0 then (t0.LineTotal - t0.SO_Original_Cost)/t0.LineTotal else 
0 end [Orig Margin],
case when t1.PrcrmntMtd = 'B' and t0.LineTotal > 0 then (t0.LineTotal - (t1.avgprice * t0.quantity))/t0.LineTotal 
when t1.PrcrmntMtd = 'B' and t0.LineTotal = 0 then 0 
when t0.LineTotal > 0 then (t0.LineTotal - (isnull(t4.[BOM Cost] * t0.Quantity,t0.SO_Original_Cost)))/t0.LineTotal else 0 end [Planned BOM Margin],
case when t1.PrcrmntMtd = 'B' and t0.LineTotal > 0 then (t0.LineTotal - (t1.avgprice * t0.quantity))/t0.LineTotal 
when t1.PrcrmntMtd = 'B' and t0.LineTotal = 0 then 0 
when t0.LineTotal > 0 then (t0.LineTotal -(isnull(t4.[BOM Cost] * t0.Quantity,t0.SO_Original_Cost) + isnull(t5.[Extra Prod Ord Cost],0)))/t0.LineTotal else 0 
end [Planned Prod Ord Margin],
case when t1.PrcrmntMtd = 'B' and t0.LineTotal > 0 then (t0.LineTotal - (t1.avgprice * t0.quantity))/t0.LineTotal 
when t1.PrcrmntMtd = 'B' and t0.LineTotal = 0 then 0 
when t0.LineTotal > 0 then (t0.LineTotal -(isnull(t4.[BOM Cost] * t0.Quantity,t0.SO_Original_Cost) + isnull(t5.[Extra Prod Ord Cost],0) + isnull(t6.[Extra Mat Cost Issued],0) + isnull(t7.[Extra Lab Cost Issued],0)))/t0.LineTotal else 0 
end [Likely Prod Ord Margin]


from sales_orders t0
--left JOIN owor ow ON ow.U_IIS_proPrOrder = t0.[Process Order]
inner join oitm t1 on t1.ItemCode = t0.ItemCode
left join delivery t2 on t2.BaseDocNum = t0.[Sales Order] and t2.itemcode = t0.itemcode and t0.LineNum = t2.BaseLine
left join good_returns t3 on t3.BaseDocNum = t0.[Sales Order] and t3.itemcode = t0.itemcode and t0.LineNum = t3.BaseLine
left join bom_costs t4 on t4.Father = t0.ItemCode
left join extra_prod_costs t5 on t5.[End Product] = t0.ItemCode and t5.OriginNum = t0.[Sales Order]
left join extra_mat_cost_issued t6 on t6.U_IIS_proPrOrder = t0.[Process Order] and t6.OriginNum = t0.[Sales Order] and t6.ItemCode = t0.ItemCode
left join extra_lab_cost_issued t7 on t7.U_IIS_proPrOrder = t0.[Process Order] and t7.OriginNum = t0.[Sales Order] and t7.ItemCode = t0.ItemCode join owor t8 on t8.U_IIS_proPrOrder=t0.[Process Order]

where t0.so_status <> 'C'



order by  t0.Due_Date";


$margin_tracker="WITH PROD_ORD AS (

      select t1.U_IIS_proPrOrder, 
      sum(case when t3.ItmsGrpNam <> 'Sub Con - Purchases' and t2.ItemType <> 'L' then 1 else 0 end)  [Material Lines],
      sum(case when t3.ItmsGrpNam <> 'Sub Con - Purchases' and t2.ItemType <> 'L' and  t0.issuedqty >= t0.PlannedQty then 1 else 0 end) [Material Fully Issued], 
      sum(case when t3.ItmsGrpNam <> 'Sub Con - Purchases' and t2.ItemType <> 'L' then t0.plannedqty* t2.avgprice else 0 end) [Material Planned Cost], 
      sum(case when t3.ItmsGrpNam <> 'Sub Con - Purchases' and t2.ItemType <> 'L' then t0.issuedqty* t2.avgprice else 0 end) [Material Issued Cost], 
      sum(case when t3.ItmsGrpNam <> 'Sub Con - Purchases' and t2.ItemType <> 'L' and t0.issuedqty = 0 then t0.PlannedQty* t2.avgprice else 0 end) [Material UnIssued Cost], 
      sum(case when t3.ItmsGrpNam = 'Sub Con - Purchases' and t2.ItemType <> 'L' then 1 else 0 end) [Sub Con Items],
      sum(case when t3.ItmsGrpNam = 'Sub Con - Purchases' and t2.ItemType <> 'L' and t0.issuedQty > 0 then 1 else 0 end) [Sub Con Items Issued],
      sum(case when t3.ItmsGrpNam = 'Sub Con - Purchases' and t2.ItemType <> 'L' then (t0.plannedqty* t2.avgprice) else 0 end) [Sub Con Planned Cost],
      sum(case when t3.ItmsGrpNam = 'Sub Con - Purchases' and t2.ItemType <> 'L' then (t0.Issuedqty* t2.avgprice) else 0 end) [Sub Con Issued Cost],
      sum(case when t3.ItmsGrpNam = 'Sub Con - Purchases' and t2.ItemType <> 'L' and t0.issuedqty = 0 then t0.PlannedQty* t2.avgprice else 0 end) [Sub Con UnIssued Cost], 
      sum(case when t2.ItemType = 'L'  and t3.itmsgrpnam = 'LABOUR PRODUCTION' then 1 else 0 end) [Labour Items],
      sum(case when t2.ItemType = 'L'  and t3.itmsgrpnam = 'LABOUR PRODUCTION' then (t0.plannedqty) else 0 end) [Labour Planned Hours],
      sum(case when t2.ItemType = 'L'  and t3.itmsgrpnam = 'LABOUR PRODUCTION' then (t0.plannedqty* t2.avgprice) else 0 end) [Labour Planned Cost],
      sum(case when t2.ItemType = 'L'  and t3.itmsgrpnam <> 'LABOUR PRODUCTION' then 1 else 0 end) [Machine Items],
      sum(case when t2.ItemType = 'L'  and t3.itmsgrpnam <> 'LABOUR PRODUCTION' then (t0.plannedqty) else 0 end) [Machine Planned Hours],
      sum(case when t2.ItemType = 'L'  and t3.itmsgrpnam <> 'LABOUR PRODUCTION' then (t0.plannedqty* t2.avgprice) else 0 end) [Machine Planned Cost],



      count(DISTINCT t1.docnum) [No. Prod Orders]


      from wor1 t0
      inner join owor t1 on t1.DocEntry = t0.DocEntry
      inner join oitm t2 on t2.ItemCode = t0.ItemCode
      inner join oitb t3 on t3.ItmsGrpCod = t2.ItmsGrpCod
      where t0.U_IIS_proPrOrder is not null

      group by t1.U_IIS_proPrOrder),
      
ACT_HOURS as (select t1.PrOrder, t1.EndProduct,
sum(case when t3.ItmsGrpNam = 'LABOUR PRODUCTION' then t0.Quantity else 0 end) [Act Labour Hours], 
sum(case when t3.ItmsGrpNam = 'LABOUR PRODUCTION' then t0.Quantity*t2.AvgPrice else 0 end) [Act Labour Cost], 
sum(case when t3.ItmsGrpNam like '%MACHINE%' then t0.Quantity else 0 end) [Act Machine Hours],
sum(case when t3.ItmsGrpNam like '%MACHINE%' then t0.Quantity*t2.AvgPrice else 0 end) [Act Machine Cost]

from iis_epc_pro_ordert t0
inner join IIS_EPC_PRO_ORDERH t1 on t1.PrOrder = t0.PrOrder
inner join oitm t2 on t2.ItemCode = t0.LabourCode
inner join oitb t3 on t3.ItmsGrpCod = t2.ItmsGrpCod

where t2.ItemType = 'L'

group by t1.PrOrder, t1.EndProduct) ,

OPEN_TIME as (select t0.prorder, t0.[End Product], 
sum(case when t0.ItmsGrpNam = 'LABOUR PRODUCTION' then t0.[Open Time] else 0 end) [Open Labour Hours], 
sum(case when t0.ItmsGrpNam = 'LABOUR PRODUCTION' then t0.[Open Time]*t0.AvgPrice else 0 end) [Open Labour Cost], 
sum(case when t0.ItmsGrpNam like '%MACHINE%' then t0.[Open Time] else 0 end) [Open Machine Hours],
sum(case when t0.ItmsGrpNam like '%MACHINE%' then t0.[Open Time]*t0.AvgPrice else 0 end) [Open Machine Cost]

from (
      select t0.PrOrder, t1.StepItem [End Product], t0.StepItem, 
      case when t4.status in ('C','D') then 'C' else t0.Status end [Process Status], 
      isnull(t3.PlannedQty, t1.ProcessTime) [planned_time], t6.ItmsGrpNam, t5.AvgPrice, isnull(t7.[Hours Booked],0) [Act Hours], 
      case when isnull(t3.PlannedQty, t1.ProcessTime) > isnull(t7.[Hours Booked],0) then isnull(t3.PlannedQty, t1.ProcessTime) - isnull(t7.[Hours Booked],0) 
      else 0 end [Open Time]

      from iis_epc_pro_orderl t0
      inner join iis_epc_pro_orderl t1 on t1.PrOrder = t0.PrOrder and t1.StepType = 'B' and t0.ParentLine = t1.LineID
      inner join owor t2 on t2.U_IIS_proPrOrder = t0.PrOrder and t2.ItemCode = t1.StepItem
      left join wor1 t3 on t3.ItemCode = t0.StepItem and t3.DocEntry = t2.DocEntry
      inner join iis_epc_pro_orderh t4 on t4.PrOrder = t0.PrOrder
      inner join oitm t5 on t5.ItemCode = t0.StepItem
      inner join oitb t6 on t6.ItmsGrpCod = t5.ItmsGrpCod
      left join (
                                      select t0.PrOrder, t1.LineID, isnull(sum(t0.quantity),0) [Hours Booked]

                                      from iis_epc_pro_ordert t0
                                      inner join iis_epc_pro_orderl t1 on t1.PrOrder = t0.PrOrder and t1.LineID = t0.LineID

                                      group by t0.PrOrder, t1.LineID) t7 on t7.PrOrder = t0.PrOrder and t7.LineID = t0.LineID
                      

      where t0.StepType = 'P'
      and (case when t4.status in ('C','D') then 'C' else t0.Status end)  in ('O','P')) t0

group by t0.prorder, t0.[End Product])



select t1.DocNum [Sales Order], t1.U_Client [Project],t1.CardCode, t1.cardname, t1.NumAtCard [Customer PO], 
t1.docstatus [SO Status] , t0.LineStatus, t0.OcrCode, case when t5.Name is NULL then 'NO Stataus'  else t5.Name end as [PP Status],
t8.Name [PP Stage],
t1.DocDate [SO Opened],
isnull(FORMAT(t0.U_promise_date,'dd-MM-yy'), FORMAT(t1.docduedate,'dd-MM-yy')) [Promise Date],
FORMAT(t0.U_floor_date,'dd-MM-yyyy')[floor_date],



CASE WHEN CAST(t0.[U_floor_date] AS DATE) = CAST(GETDATE() AS DATE) then 'TD' end [TD],
CASE WHEN CAST(t0.[U_floor_date] AS DATE) = CAST(dateadd(day, -1,GETDATE()) AS DATE) THEN 'YD' end [YD],
	   
CASE WHEN DATEPART(ISO_WEEK,t0.[U_floor_date]) = DATEPART(ISO_WEEK,GETDATE()) AND DATEPART(YEAR,t0.[U_floor_date]) = DATEPART(YEAR,GETDATE()) then 'TW' end [TW],
CASE WHEN DATEPART(ISO_WEEK,t0.[U_floor_date]) = DATEPART(ISO_WEEK,GETDATE()) -1 AND DATEPART(YEAR,t0.[U_floor_date]) = DATEPART(YEAR,GETDATE()) THEN 'LW' END [LW],
CASE WHEN DATEPART(MONTH,t0.[U_floor_date]) = DATEPART(MONTH,GETDATE()) AND DATEPART(YEAR,t0.[U_floor_date]) = DATEPART(YEAR,GETDATE()) then 'TM' END [TM],
CASE WHEN DATEPART(MONTH,t0.[U_floor_date]) = DATEPART(MONTH,GETDATE()) -1 AND DATEPART(YEAR,t0.[U_floor_date]) = DATEPART(YEAR,GETDATE()) then 'LM' END [LM],
CASE WHEN DATEPART(YEAR,t0.[U_floor_date]) = DATEPART(YEAR,GETDATE()) THEN 'TY'end [TY],
CASE WHEN t0.[U_floor_date] IS NOT NULL THEN t0.[U_floor_date] END [DateCategory],
case when t10.[Same Codes?] is null then 'No'
else 'Yes' end [Duplicate items on SO?],
t4.InvntItem [Stock Item?],
t4.PrcrmntMtd [Make or Buy?],t4.U_Product_Group_One [PG1],
t4.onhand [In Stock], 
t0.ItemCode, t0.Dscription, 
t0.Quantity,
t4.PrcrmntMtd [Buy or Make], 
isnull(t3.[No. Prod Ord],0) [No. Process Orders],
isnull(t11.[No. Prod Orders],0)  [No. Prod Orders],
case when isnull(t3.[No. Prod Ord],0)  < isnull(t11.[No. Prod Orders],0)  then 'Yes' else 'No' end [Sub BOMs?],
case when t7.Code is not null then 'Yes' else 'No' end [BOM Created?],
t7.[BOM Created] [BOM Create Date],
isnull(t7.[BOM Size],0) [BOM Size],
t7.[BOM Cost] * t0.Quantity as [Total Cost per BOM], 
t9.PrOrder [Process Order], 
T11.[Material Lines], T11.[Material Fully Issued], T11.[Material Planned Cost], T11.[Material Issued Cost], 
T11.[Sub Con Items],  T11.[Sub Con Items Issued], T11.[Sub Con Planned Cost], T11.[Sub Con Issued Cost],
T11.[Labour Items], T11.[Labour Planned Hours] , t12.[Act Labour Hours], t11.[Labour Planned Cost],t12.[Act Labour Cost],
T11.[Machine Items], T11.[Machine Planned Hours], t12.[Act Machine Hours], t11.[Machine Planned Cost], t12.[Act Machine Cost],
isnull(T11.[Material Planned Cost],0) + isnull(T11.[Sub Con Planned Cost],0) + isnull(T11.[Labour Planned Cost],0) + isnull(T11.[Machine Planned Cost],0) as [Total Planned Prod Cost],
isnull(T11.[Material Issued Cost],0) +  isnull(T11.[Sub Con Issued Cost],0) + isnull(t12.[Act Labour Cost],0) + isnull(t12.[Act Machine Cost],0) As [Total Actual Prod Cost],
T11.[Material Lines] - T11.[Material Fully Issued] [Materials TBI],
T11.[Sub Con Items] -  T11.[Sub Con Items Issued] [Sub Con TBI],
T11.[Labour Planned Hours] -  isnull(t12.[Act Labour Hours],0) [Labour Hours TBI],
T11.[Machine Planned Hours] - isnull(t12.[Act Machine Hours],0) [Machine Hours TBI],
isnull(t11.[Material UnIssued Cost],0) + isnull([Sub Con UnIssued Cost],0) [Unissued Mat SC Cost],
isnull(t13.[Open Labour Cost],0) + isnull(t13.[Open Machine Cost],0) [Open Lab Laser Cost],
case when isnull(t3.[Cmplt In Prod],0)  > t0.Quantity then 'Excess Made in Prod' 
when isnull(t3.[Cmplt In Prod],0)  = t0.Quantity then 'Fully Made in Prod' 
when isnull(t3.[Cmplt In Prod],0) < t0.Quantity and isnull(t3.[Cmplt In Prod],0) > 0 then 'Part Made in Prod' 
when isnull(t3.[Cmplt In Prod],0) = 0  and isnull(t3.[Planned Prod],0) > 0 then 'In Prod' 
when t4.Itemcode = 'TRANSPORT' then 'Transport' 
when t4.PrcrmntMtd = 'B' then 'Buy Item' 
when isnull(t3.[Planned Prod],0) = 0  and t4.PrcrmntMtd = 'M' and t0.LineStatus = 'O' then 'No Prod Yet' 
else 'Stock Only' end [Prod Status],
isnull(t3.[Cmplt In Prod],0) [Qty Made In Prod],
(case 
when isnull(t0.DelivrdQty,0)  = t0.Quantity then 'Closed - Fully Delivered'
when isnull(t0.DelivrdQty,0)  < t0.Quantity and isnull(t0.DelivrdQty,0)  > 0 and t0.LineStatus = 'C' then 'Closed - Part Delivered'
when isnull(t0.DelivrdQty,0)  < t0.Quantity and isnull(t0.DelivrdQty,0)  > 0 and t0.LineStatus = 'O' then 'Open - Part Delivered'
when isnull(t0.DelivrdQty,0)  = 0 and t0.LineStatus = 'C' then 'Closed - No Delivery'
when isnull(t0.DelivrdQty,0)  = 0 and t0.LineStatus = 'O' then 'Open - No Delivery'
else'Other' end) [Del Status], 
isnull(t0.DelivrdQty,0) [Del Qty],
t0.LineTotal [SO Sales Value EUR],
t0.StockPrice * t0.Quantity [Original SO Cost], 
t0.linetotal - (t0.StockPrice * t0.Quantity) [Original SO Margin],
case when t0.linetotal - (t0.StockPrice * t0.Quantity) > 0 then 
(t0.linetotal - (t0.StockPrice * t0.Quantity))/t0.linetotal else 0 end [Original SO Margin],
case when t4.PrcrmntMtd = 'B' then t0.StockPrice *t0.Quantity
when t4.PrcrmntMtd = 'M' and t9.PrOrder is not null then 
isnull(T11.[Material Planned Cost],0) + isnull(T11.[Sub Con Planned Cost],0) + isnull(T11.[Labour Planned Cost],0) + isnull(T11.[Machine Planned Cost],0)
when t4.PrcrmntMtd = 'M' and t9.PrOrder is null and t7.Code is not null then t7.[BOM Cost] * t0.Quantity
else 0 end as [Planned Cost],
case when t4.PrcrmntMtd = 'B' then t0.StockPrice *t0.Quantity
when t4.PrcrmntMtd = 'M' and t9.PrOrder is not null then 
isnull(T11.[Material Issued Cost],0) +  isnull(T11.[Sub Con Issued Cost],0) + isnull(t12.[Act Labour Cost],0) + isnull(t12.[Act Machine Cost],0) +
isnull(t11.[Material UnIssued Cost],0) + isnull(t11.[Sub Con UnIssued Cost],0) + isnull(t13.[Open Labour Cost],0) + isnull(t13.[Open Machine Cost],0) 
when t4.PrcrmntMtd = 'M' and t9.PrOrder is null and t7.Code is not null then t7.[BOM Cost] * t0.Quantity
else 0 end [Projected Cost], 
(t0.LineTotal - 
(case when t4.PrcrmntMtd = 'B' then t0.StockPrice *t0.Quantity
when t4.PrcrmntMtd = 'M' and t9.PrOrder is not null then 
isnull(T11.[Material Planned Cost],0) + isnull(T11.[Sub Con Planned Cost],0) + isnull(T11.[Labour Planned Cost],0) + isnull(T11.[Machine Planned Cost],0)
when t4.PrcrmntMtd = 'M' and t9.PrOrder is null and t7.Code is not null then t7.[BOM Cost] * t0.Quantity
else 0 end)) [Planned Margin],
(t0.LineTotal - 
case when t4.PrcrmntMtd = 'B' then t0.StockPrice *t0.Quantity
when t4.PrcrmntMtd = 'M' and t9.PrOrder is not null then 
isnull(T11.[Material Issued Cost],0) +  isnull(T11.[Sub Con Issued Cost],0) + isnull(t12.[Act Labour Cost],0) + isnull(t12.[Act Machine Cost],0) +
isnull(t11.[Material UnIssued Cost],0) + isnull(t11.[Sub Con UnIssued Cost],0) + isnull(t13.[Open Labour Cost],0) + isnull(t13.[Open Machine Cost],0) 
when t4.PrcrmntMtd = 'M' and t9.PrOrder is null and t7.Code is not null then t7.[BOM Cost] * t0.Quantity
else 0 end) [Proj Margin],
t0.U_floor_date,
t1.U_Dimension1[BU]
,t_3.firstname + ' ' + t_3.lastName [Sales Person],


t_8.SlpName[Engineer]
from rdr1 t0

inner join ordr t1 on t1.DocEntry = t0.DocEntry

INNER join ohem t_3 on t_3.empID = t1.OwnerCode
  INNER JOIN oslp t_8 ON t_8.SlpCode = t1.SlpCode






      ----------checking status of completion in production -------
left join (
      select t1.DocNum, t2.LineNum, t2.ItemCode, count(t0.docnum) [No. Prod Ord], 
      sum(t0.CmpltQty) [Cmplt In Prod],  sum(t0.PlannedQty) [Planned Prod]

      from owor t0
      inner join ordr t1 on t1.docnum = t0.OriginNum
      inner join rdr1 t2 on t2.docentry = t1.DocEntry and t2.ItemCode = t0.ItemCode

      group by t1.DocNum, t2.LineNum, t2.ItemCode) as t3 on t3.DocNum = t1.docnum and t3.linenum = t0.linenum and t3.itemcode = t0.itemcode

inner join oitm t4 on t4.ItemCode = t0.ItemCode

      ---- PP Status -----
left join dbo.[@PRE_PROD_STATUS] as t5 on t5.code = t0.U_PP_Status


      ---------BOM Cost details ----------
left join (
      select t0.CreateDate [BOM Created], t0.code, count(t1.code) [BOM Size], sum(t1.price * t1.quantity) [BOM Cost]

      from oitt t0
      inner join itt1 t1 on t1.Father = t0.Code

      group by t0.CreateDate, t0.code
      ) t7 on t7.Code = t0.ItemCode

      ------adding Pre Production Stage ---
left join dbo.[@PRE_PRODUCTION] as t8 on t8.code = t0.U_PP_Stage


      ------- Pulling in Process Order for each line item -----
left join (
      select t0.endproduct, t0.prorder, t1.OriginNum

      from iis_epc_pro_orderh t0
      inner join owor t1 on t1.U_IIS_proPrOrder = t0.PrOrder and t0.EndProduct = t1.itemcode

      where t1.Status <> 'C')t9 on t9.OriginNum = t1.DocNum and t9.EndProduct = t0.ItemCode

      ------- checking to see if duplicate codes are on multiple lines of Sales Order------
left join (
      select t1.DocNum, t0.ItemCode, count(t0.linenum) [Same Codes?]

      from rdr1 t0 
      inner join ordr t1 on t1.DocEntry = t0.DocEntry
      inner join oitm t2 on t2.ItemCode = t0.ItemCode

      where t1.CANCELED <> 'Y'
      and t2.InvntItem = 'Y'

      group by t1.DocNum, t0.ItemCode

      Having count(t0.linenum) > 1) t10 on t10.DocNum = t1.DocNum and t10.ItemCode = t0.ItemCode


      ----- adding in production Order data-- check for sub BOMS
left join PROD_ORD T11 ON T11.U_IIS_proPrOrder = T9.PrOrder

left join ACT_HOURS t12 on t12.PrOrder = t9.PrOrder and t12.EndProduct = t0.ItemCode
left join OPEN_TIME t13 on t13.PrOrder = t9.PrOrder and t13.[End Product] = t0.ItemCode


where t1.CANCELED <> 'Y'
and t1.DocDate >= '2023-01-01' 
and t0.ItemCode <> 'TRANSPORT'
---order by t1.docnum, t0.linenum, t0.U_Promise_Date
and t1.DocStatus<>'c'

order by t1.docnum";


