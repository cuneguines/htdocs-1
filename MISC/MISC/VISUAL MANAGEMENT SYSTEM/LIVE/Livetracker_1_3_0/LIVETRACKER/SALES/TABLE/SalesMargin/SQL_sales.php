<?php $sales_margin_results=
"with sales_orders as (--- Sales Order Details -----
 
                     select t1.docnum [Sales Order], 
                     t1.cardcode, t1.CardName, 
                     t1.U_Client, FORMAT(CAST(t1.[DocDate] AS DATE),'dd-MM-yyyy') [DocDate],
                     t0.ItemCode, t0.Dscription, t0.Quantity, 
                     t0.linetotal, t0.LineNum,
                     
                     t2.CmpltQty, t2.U_IIS_proPrOrder [Process Order],
                     t3.Name [PP Status], isnull(t0.DelivrdQty,0) [DelivrdQty], 
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
 
 
 
 
select t0.[Sales Order], t0.CardName, t0.U_Client, 
FORMAT(CAST(MIN(t0.Due_Date) AS DATE),'dd-MM-yyyy') [Earliest Due Date],
sum(t0.[Sales Value]) [Sales Value],
sum(t0.[SO_Original_Cost]) [SO_Original_Cost],
sum(t0.[Planned_BOM_Cost]) [Planned_BOM_Cost],
sum(t0.[Planned Prod Order Cost]) [Planned Prod Order Cost],
sum(t0.[Likely Prod Ord Cost]) [Likely Prod Ord Cost],
case when sum(t0.[Sales Value]) > 0 then (sum(t0.[Sales Value]) - sum(t0.[SO_Original_Cost]))/sum(t0.[Sales Value]) else 0 end [Orig Margin],
case when sum(t0.[Sales Value]) > 0 then (sum(t0.[Sales Value]) - sum(t0.[Planned_BOM_Cost]))/sum(t0.[Sales Value]) else 0 end [Planned BOM Margin],
case when sum(t0.[Sales Value]) > 0 then (sum(t0.[Sales Value]) - sum(t0.[Planned Prod Order Cost]))/sum(t0.[Sales Value]) else 0 end [Planned Prod Ord Margin],
case when sum(t0.[Sales Value]) > 0 then (sum(t0.[Sales Value]) - sum(t0.[Likely Prod Ord Cost]))/sum(t0.[Sales Value]) else 0 end [Likely Prod Ord Margin]
 
 
from (
              select t0.[Sales Order], t0.CardCode, t0.CardName, t0.U_client, t0.[PP Status],
              t0.DocDate, t0.Due_Date, t0.ItemCode, t0.Dscription, t0.Quantity, t0.DelivrdQty, 
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
              inner join oitm t1 on t1.ItemCode = t0.ItemCode
              left join delivery t2 on t2.BaseDocNum = t0.[Sales Order] and t2.itemcode = t0.itemcode and t0.LineNum = t2.BaseLine
              left join good_returns t3 on t3.BaseDocNum = t0.[Sales Order] and t3.itemcode = t0.itemcode and t0.LineNum = t3.BaseLine
              left join bom_costs t4 on t4.Father = t0.ItemCode
              left join extra_prod_costs t5 on t5.[End Product] = t0.ItemCode and t5.OriginNum = t0.[Sales Order]
              left join extra_mat_cost_issued t6 on t6.U_IIS_proPrOrder = t0.[Process Order] and t6.OriginNum = t0.[Sales Order] and t6.ItemCode = t0.ItemCode
              left join extra_lab_cost_issued t7 on t7.U_IIS_proPrOrder = t0.[Process Order] and t7.OriginNum = t0.[Sales Order] and t7.ItemCode = t0.ItemCode
 
 
              where t0.so_status <> 'C') t0
 
 
group by t0.[Sales Order], t0.CardName, t0.U_Client
 
order by MIN(t0.Due_Date)";
?>
 
