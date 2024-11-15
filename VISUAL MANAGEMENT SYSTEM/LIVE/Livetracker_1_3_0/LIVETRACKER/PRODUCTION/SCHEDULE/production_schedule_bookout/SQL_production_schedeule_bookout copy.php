<!-- Changed 21/02/23 -->

<?php $tsql="declare @counter INT = 0;


with credit_status as (                    select t0.CardCode, t0.CardName, t0.Balance, 
                     isnull(t2.Del_Value,0) [Del Value], isnull(t3.SO_Value,0) [SO Value],
                     isnull(t2.Del_ValueFC,0) [Del ValueFC], isnull(t3.SO_ValueFC,0) [SO ValueFC],
                     t0.CreditLine,
                     t1.PymntGroup, t1.ExtraDays, t1.ExtraMonth, t1.TolDays, t1.PayDuMonth,
                     case 
                                   when t0.U_credit_control = 'On Hold' then 'ON HOLD - BRID BP'
                                  when t0.U_credit_control = 'OK To Go' then 'OK - BRID BP'
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


select
t0.[Sales Order],
t0.[Customer],
t0.[Project],
t0.[Sales Person],
t0.[Days Open],
t0.[Week Opened],
t0.[Weeks Open],
t0.[Month Difference PD],

CASE
WHEN DATEDIFF(DAY,[Monday LW Date],t0.[Del Date Due UNP]) < -6 and  DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP] ) =-3 THEN -1/*LAST FRIDAY*/
WHEN DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP]) < -4 THEN -4
WHEN DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP])  =-3 then -3
WHEN DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP] ) =-2 then -2
WHEN DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP])=-1 Then-1
/*next week*/
/*next week*/
WHEN DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP] ) >= 17 THEN 14
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) > 6 and  DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP] )=3 THEN @counter+1
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) > 6 and  DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP] )=4THEN @counter+2
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) > 6 and  DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP] )=5THEN @counter+3
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) > 6 and  DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP] )=6THEN @counter+4
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) > 6 and  DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP] )=7THEN @counter+5
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) > 6 and  DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP] )=8THEN @counter+6
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) > 6 and  DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP] )=9THEN @counter+7

/*next next week*/
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) > 10 and  DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP] )=16THEN @counter+12
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) > 10 and  DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP] )=15THEN @counter+11
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) > 10 and  DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP] )=14THEN @counter+10
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) > 10 and  DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP] )=13THEN @counter+9
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) > 10 and  DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP] )=12THEN @counter+8
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) > 10 and  DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP] )=11THEN @counter+7
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) > 10 and  DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP] )=10THEN @counter+6
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) > 10 and  DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP] )=9THEN @counter+5

ELSE DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP])
END [Promise Diff Daystest] ,/* DAYS HERE */

CASE 
WHEN DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP]) < -14 THEN -6
WHEN DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP]) >= -14 AND DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP]) < -7 THEN -5
WHEN DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP]) >= -7 AND DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP]) <= -4 THEN -4
WHEN DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP]) =-1 THEN -1
WHEN DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP]) =-2 THEN -2
WHEN DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP]) =-3 THEN -3
WHEN DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP]) >= 15 THEN 14
WHEN DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP]) = 6 THEN 6
WHEN DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP]) = 7 THEN 7
WHEN DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP]) = 8 THEN 8
WHEN DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP]) = 9 THEN 9
WHEN DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP]) = 10 THEN 10
WHEN DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP]) = 11 THEN 11
WHEN DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP]) = 12THEN 12
ELSE DATEDIFF(DAY,GETDATE(),t0.[Del Date Due UNP])
END [Promise Diff Days], /* DAYS HERE */
CASE 
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) = 0 THEN 'Monday'
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) =1 THEN 'Tuesday'
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) =2 THEN 'Wednesday'
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) =3 THEN 'Thursday'
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) =4 THEN 'Friday'
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) =5 THEN 'Saturday'
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) =6 THEN 'Sunday'
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) =7 THEN 'MNW'
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) =8 THEN 'TNW'
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) =9 THEN 'WNW'
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) =10 THEN 'THNW'
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) =11 THEN 'FNW'
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) =13 THEN 'MNNW'
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) =14 THEN 'TNNW'
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) =15 THEN 'WNNW'
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) =16 THEN 'TNNW'
WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) <-4 THEN 'Other'
when  DATEDIFF(DAY,[Monday TW Date],t0.[Del Date Due UNP]) =-3 THEN 'LastworkingDay'

ELSE 'Ot'

END [Days of the Week], /* DAYS HERE */
case
when  DATEDIFF(DAY,getdate(),t0.[Del Date Due UNP]) =-3 THEN 'LastthreeDays'
when  DATEDIFF(DAY,getdate(),t0.[Del Date Due UNP]) =-2 THEN 'LastthreeDays'
when  DATEDIFF(DAY,getdate(),t0.[Del Date Due UNP]) =-1 THEN 'LastthreeDays'
END [Last three days], /* DAYS HERE */
case
when  DATEDIFF(DAY,getdate(),t0.[Del Date Due UNP]) =-5 THEN 'LastfiveDays'
when  DATEDIFF(DAY,getdate(),t0.[Del Date Due UNP]) =-4 THEN 'LastfiveDays'
when  DATEDIFF(DAY,getdate(),t0.[Del Date Due UNP]) =-3 THEN 'LastfiveDays'
when  DATEDIFF(DAY,getdate(),t0.[Del Date Due UNP]) =-2 THEN 'LastfiveDays'
when  DATEDIFF(DAY,getdate(),t0.[Del Date Due UNP]) =-1 THEN 'LastfiveDays'
END [Last five days], /* DAYS HERE */
t0.[Dscription],
t0.[Non Deliverable],
t0.[Quantity],
t0.[On Hand],
t0.[Promise Date],
t0.[Promise Week Due],
FORMAT(CONVERT(DATE,t0.[Del Date Due UNP]),'dd-MM-yyyy' )[Del Date Due UNP],
[Del Date Due PD_DD],
  t0.U_delivery_date[DDATE],
t0.[Promise_date_now],
t0.[Engineer],
t0.[risk],
t0.[Status],
t0.[Stage],
t0.[Paused],
t0.[Comments],
t0.[Comments_2],
t0.[Addr],
--Changed 30/11/22--
t0.[Contact],
t0.[Phone],
t0.[DueDate],
t0.[Process Order],
t0.[Planned Hrs],
t0.[Sub Contract Status],
t0.[Complete],
CASE WHEN t0.[Est Prod Hrs] < 0 THEN 0 ELSE t0.[Est Prod Hrs] END [Est Prod Hrs], 
isnull(t0.[Product Group],'No Group') [Product Group],
t0.U_EORI [EORI], 
t0.U_BNComCod [Commodity Code],
isnull(t1.[Acc Status],'OK TO GO') [Account Status], t0.LineNum



FROM(
                              
                                                                                                                  
                                                ----CUSTOMER ORDERS ONLY-----

                                                SELECT (CASE 
                                                WHEN t20.qrygroup26 = 'N' THEN 'OK' 
                                                ELSE 
                                                    (CASE WHEN t20.Balance + t7.[Order Value] <= 0 THEN 'OK' ELSE 'ON HOLD' END) 
                                                END)[Account Status],
												t1.U_delivery_date,
                                                --Changed 30-11-22--
                                                t0.U_site_contact[Contact],
                                                t0.U_site_phone[Phone],
                                                               DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE())[Monday TW Date],
                                                               DATEADD(d, 1 - DATEPART(w, GETDATE())+8, GETDATE())[Monday LW Date],
                                                                isnull(t1.U_delivery_date, t0.DocDueDate)[DueDate],
                                                                t0.docnum [Sales Order],
                                                                t0.cardname [Customer],
                                                                ISNULL(t0.U_Client,'000_NO PROJECT_000') [Project],
                                                                t3.firstname + ' ' + t3.lastName [Sales Person],
                                                                DATEDIFF(DAY, t0.CreateDate, GETDATE())[Days Open],
                                                                DATEPART(ISO_WEEK, t0.CreateDate)[Week Opened],
                                                                DATEDIFF(WEEK, t0.CreateDate, GETDATE())[Weeks Open],
                                                                DATEDIFF(MONTH, GETDATE(),t1.U_Promise_Date) [Month Difference PD],
    
                                                                t0.Address2[Addr],
                                                                t1.Dscription [Dscription],
                                                                ---mark non-stock items as non deliverables
                                                                (CASE WHEN (t6.ItmsGrpNam LIKE 'LABOUR SITE' OR 
                                                                t6.ItmsGrpNam LIKE 'TRAINING' OR 
                                                                t6.ItmsGrpNam LIKE 'Documents & Manuals' OR 
                                                                t6.ItmsGrpNam LIKE 'Contract Phased Sale') 
                                                                THEN 'yes' ELSE 'no' END) [Non Deliverable],
                                                                CAST(t1.quantity AS DECIMAL (12,1)) [Quantity],
                                                                CAST(t5.OnHand AS DECIMAL (12,1))[On Hand],
                                                                FORMAT(CONVERT(DATE,t1.U_Promise_Date),'dd-MM-yyyy') [Promise Date],
                                                                /*If delivery date is null take docduedate ,if delivery date is less than -4 then take promise date*/
                                                                /*If delivery date is null take docduedate ,if delivery date is less than -4 then take promise date*/ 
                                                                (case when t1.U_delivery_date is null then t1.U_Promise_Date        
                                                          when DATEDIFF(DAY,getdate(),t1.U_delivery_date )< =-4 then t1.U_Promise_Date         
                                                        else t1.U_delivery_date end ) [Del Date Due UNP],
                                                                (case 
                                                                    WHEN t1.U_delivery_date IS NOT NULL THEN 'DD'
                                                                    else 'PD'
                                                                end)[Del Date Due PD_DD],
-----to see if the job s new date is Promise date -----
(case                  when DATEDIFF(DAY,getdate(),t1.U_delivery_date )< =-4 then 'Yes' else 'No'  end)[Promise_date_now],
                                                                ----get the week of due date ----
                                                                (CASE 
                                                                                WHEN DATEPART(iso_week,isnull(t1.U_delivery_date, t0.DocDueDate)) = 53 THEN 52 
                                                                                WHEN DATEPART(iso_week,isnull(t1.U_delivery_date, t0.DocDueDate)) IS NULL THEN 52
                                                                                ELSE DATEPART(iso_week,isnull(t1.U_delivery_date, t0.DocDueDate)) 
                                                                END) [Promise Week Due],
                                                                ISNULL(t2.SlpName,'NO NAME') [Engineer],
                                                                t1.U_risk_rating [risk],
                                                                case when t14.[Name] is null then t1.U_PP_Status else t14.[Name] end [Status],
                                                                case when t13.U_stages is null then t1.U_PP_Stage else t13.U_stages end [Stage],
                                                                t1.U_Paused [Paused],
                                                                t1.U_BOY_38_EXT_REM [Comments],
                                                                t99.Remarks [Comments_2],

    
                                                                t4.U_IIS_proPrOrder [Process Order],
                                                                ISNULL(CAST(t11.Planned_Lab as DECIMAL(12,0)),0)[Planned Hrs],
                                                                t1.U_In_Sub_Con [Sub Contract Status],
                                                                CAST(t4.PlannedQty - t4.CmpltQty AS DECIMAL(12,2)) [Complete],
                                                                ----get est prod hours----
                                                                CAST((CASE
                                                                                WHEN t1.U_In_Sub_Con = 'Yes' THEN 0
                                                                                WHEN CAST(t4.PlannedQty - t4.CmpltQty AS DECIMAL(12,0)) <= 0 THEN 0

                                                                                WHEN   case when t14.[Name] is null 
                                                                                                                then t1.U_PP_Status else t14.[Name] end <> 'Live' AND 
                                                                                                                                case when t14.[Name] is null then t1.U_PP_Status else t14.[Name] end 
                                                                                                                IN ('Pre Production Confirmed', 'Pre Production Potential', 'Pre Production Forecast') 
                                                                                                                THEN ISNULL(t1.U_Est_Prod_hrs,0)
                                                                                ELSE 
                                                                                                (CASE WHEN t4.CmpltQty < t4.PlannedQty 
                                                                                                                THEN ISNULL(ISNULL(t11.[Planned_Lab],0)-ISNULL(t10.[Actual_Lab],0),t11.[Planned_Lab]) 
                                                                                                                ELSE 0 END)
                                                                                END) AS DECIMAL (12,0)) [Est Prod Hrs], 
                                
                                                                                t5.U_Product_Group_One [Product Group],
                                                                                                                t20.U_EORI, t5.U_BNComCod, t1.LineNum
   
                                                                FROM ordr t0
                                                                INNER JOIN rdr1 t1 on t1.DocEntry = t0.DocEntry
                                                                INNER join oslp t2 on t2.SlpCode = ISNULL(t1.SlpCode,t0.SlpCode)
                                                                INNER join ohem t3 on t3.empID = t0.OwnerCode
                                                                LEFT join owor t4 on t4.OriginNum = t0.DocNum AND t4.ItemCode = t1.ItemCode and t4.Status<>('C')
                                                                INNER JOIN oitm t5 on t5.ItemCode = t1.ItemCode
                                                                INNER JOIN oitb t6 on t6.ItmsGrpCod = t5.ItmsGrpCod
                                                                LEFT JOIN IIS_EPC_PRO_ORDERH t99 ON t99.PrOrder = t4.U_IIS_proPrOrder
                                                                LEFT JOIN 
                                                                (SELECT t0.PrOrder, t1.EndProduct,
                                                                                SUM(t0.Quantity) [Actual_Lab]
                                                                                FROM iis_epc_pro_ordert t0  
                                                                                                                                INNER JOIN iis_epc_pro_orderh t1 ON t1.PrOrder = t0.PrOrder
                                                                                GROUP BY t0.PrOrder, t1.EndProduct
                                                                ) t10 ON t10.PrOrder = t4.U_IIS_proProrder AND t10.EndProduct = t1.ItemCode
                                                                LEFT JOIN 
                                                                (SELECT t1.U_IIS_proPrOrder, t1.ItemCode,
                                                                                SUM(t0.plannedqty) [Planned_Lab]
                                                                                FROM wor1 t0
                                                                                                INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry                                                      
                                                                                                INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode
                                                                                                                                inner join iis_epc_pro_orderh t3 on t3.PrOrder = t0.U_IIS_proPrOrder                                         
                                                                                                WHERE t2.ItemType = 'L'                                                         
                                                                                                GROUP BY t1.U_IIS_proPrOrder, t1.ItemCode
                                                                ) t11 ON t11.U_IIS_proPrOrder = t4.U_IIS_proPrOrder and t11.ItemCode = t1.ItemCode
                                                                left join [dbo].[@PRE_PRODUCTION] as t13 on t13.code     = t1.U_PP_Stage
                                                                left join [dbo].[@PRE_PROD_STATUS] as t14 on t14.code    = t1.U_PP_Status

       
                                                                   left join (select t1.U_IIS_proPrOrder, sum(t0.issuedqty) [Issued], sum(t1.CmpltQty) [Completed]
                                                                                                                                                   from wor1 t0
                                                                                                                                                   inner join owor t1 on t1.DocEntry = t0.DocEntry
                                                                                                                                                   where 1 = 1 
                                                                                                                                                   and t1.Status in ('L','C')
                           
                                                                                                                                                   group by t1.U_IIS_proPrOrder
                                                                                                                                                   Having sum(t0.issuedqty) = 0 and sum(t1.CmpltQty) = 0
                                                                                                                                                   ) t15 on t15.U_IIS_proPrOrder = t4.U_IIS_proPrOrder
                        left join  ocrd t20 on t20.CardCode = t0.CardCode
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    LEFT JOIN 
        (
            SELECT DocEntry, SUM(LineTotal) [Order Value]
            FROM rdr1
            GROUP BY DocEntry
        )
        t7 ON t7.DocEntry = t0.DocEntry
   
       WHERE t1.LineStatus = 'O'
       AND t1.ItemCode <> 'TRANSPORT' 
       AND t0.CANCELED <> 'Y' 
                

    UNION ALL

                  ----STOCK ORDERS ONLY-----
                  SELECT
                                                                                                                                                      NULL,
                  NULL,
				  NULL,
                  NULL,
                                  DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE())[Monday TW Date],
                                  DATEADD(d, 1 - DATEPART(w, GETDATE())+8, GETDATE())[Monday LW Date],
                                  t0.CardCode[cardcode],
                                  000000 [Sales Order],
                                  'Kent Stainless'[Customer], 
                                  ISNULL(t5.U_Product_Group_One, 'NOT PART OF PROJECT') [Project],
                                  'Peter Edwards' [Sales Person],
                                  DATEDIFF(DAY, t0.CreateDate, GETDATE())[Days Open],
                                  DATEPART(ISO_WEEK, t0.CreateDate)[Week Opened],
                                  DATEDIFF(WEEK, t0.CreateDate, GETDATE())[Weeks Open],
                                  DATEDIFF(month, GETDATE(), t0.DueDate) [Month Difference PD],

                                  t0.CardCode[CardCode],     
                                  t5.ItemName [Dscription],
                                  (CASE WHEN (t6.ItmsGrpNam LIKE 'LABOUR SITE' OR t6.ItmsGrpNam LIKE 'TRAINING' OR t6.ItmsGrpNam LIKE 'Documents & Manuals' OR t6.ItmsGrpNam LIKE 'Contract Phased Sale') THEN 'yes' ELSE 'no' END) [Non Deliverable],
                                  CAST(t0.plannedqty AS DECIMAL (12,1)) [Quantity],
                                  CAST(t5.OnHand AS DECIMAL (12,1))[On Hand],
                                  FORMAT(CONVERT(DATE,(t0.DueDate)),'dd-MM-yyyy') [Promise Date],
                                  CAST(t0.DueDate AS DATE) [Del Date Due UNP],
                                  NULL [Del Date Due PD_DD],
                                  NULL,
                                  (CASE 
                                                  WHEN DATEPART(iso_week,t0.DueDate) = 53 THEN 52 
                                                  WHEN DATEPART(iso_week,t0.DueDate) IS NULL THEN 52
                                                  ELSE DATEPART(iso_week,t0.DueDate) 
                                  END) [Promise Week Due],
                                  t2.U_NAME [Engineer],
                                  'N/A' [risk],
                                  'Live' [Status],
                                  'N/A' [Stage],
                                  'N/A' [Paused],
                                  t7.Remarks [Comments],
                                  t7.Remarks [Comments_2],

  
                                  t0.U_IIS_proPrOrder [Process Order],
                                  ISNULL(CAST(t11.Planned_Lab as DECIMAL(12,0)),0)[Planned Hrs],
                                  NULL [Sub Contract Status],
                                  CAST(t0.PlannedQty - t0.CmpltQty AS DECIMAL(12,2)) [Complete],
                                 CAST((CASE
                                  WHEN CAST(t0.PlannedQty - t0.CmpltQty AS DECIMAL(12,0)) <= 0 THEN 0
                                                                                  ELSE 
                                                  (CASE
                                                                  WHEN t0.CmpltQty < t0.PlannedQty THEN ISNULL(ISNULL(t11.[Planned_Lab],0)-ISNULL(t10.[Actual_Lab],0),t11.[Planned_Lab]) 
                                                                  ELSE 0 
                                                  END)
                                  END) AS DECIMAL (12,0)) [Est Prod Hrs], t5.U_Product_Group_One [Product Group],
                                                                                  t12.U_EORI, t5.U_BNComCod, NULL
   
                     FROM owor t0
   
                     inner join ousr t2 on t2.USERID= t0.UserSign
                     INNER JOIN oitm t5 on t5.ItemCode = t0.ItemCode
                     INNER JOIN oitb t6 on t6.ItmsGrpCod = t5.ItmsGrpCod
                     LEFT JOIN IIS_EPC_PRO_ORDERH t7 ON t7.PrOrder = t0.U_IIS_proProrder
                     LEFT JOIN 
                     (SELECT t0.PrOrder, t1.EndProduct, 
                                                     SUM(t0.Quantity) [Actual_Lab]
                                                     FROM iis_epc_pro_ordert t0  
                                                                                     inner join iis_epc_pro_orderh t1 on t1.PrOrder = t0.PrOrder
                                                     GROUP BY t0.PrOrder, t1.EndProduct
                     ) t10 ON t10.PrOrder = t0.U_IIS_proProrder and t10.EndProduct = t0.ItemCode
                     LEFT JOIN 
                     (SELECT t1.U_IIS_proPrOrder, t1.ItemCode,
                                                     SUM(t0.plannedqty) [Planned_Lab]
                                                     FROM wor1 t0
                                                                     INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry                            
                                                                     INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode   
                                                                                                  inner join iis_epc_pro_orderh t3 on t3.PrOrder = t0.U_IIS_proPrOrder                        
                                                                     WHERE t2.ItemType = 'L'                         
                                                                     GROUP BY t1.U_IIS_proPrOrder,t1.ItemCode
                     ) t11 ON t11.U_IIS_proPrOrder = t0.U_IIS_proPrOrder and t11.ItemCode = t0.ItemCode
                     left join  ocrd t12 on t12.CardCode = t0.CardCode
                     WHERE t0.Status not in ('D','L','C')
                     and t0.OriginNum is null
                                                                                                ) t0


left join (   
                                                                   select --distinct t6.PrOrder [Process Order], 
                                                                  t1.docnum [Sales Order], t1.CardCode, 
                                                                t1.cardname, t0.ItemCode, t0.Dscription, t0.LineTotal [Item Value], t2.[Open SO Value], t3.Name [Pre Prod Status],
                                                                CAST(isnull(t0.U_delivery_date, t1.DocDueDate) AS DATE) [Book Out Date], 
                                                                CAST(t0.U_Promise_Date  AS DATE) [Promise Date], ---t4.Within_Line,
                                                                case 
                                                                when t4.Within_Line like 'ON HOLD%' then t4.Within_Line
                                                                when t5.country not like 'IE' and (t2.[Open SO Value FC] + t4.[Del ValueFC] + t5.BalanceFC) > t4.creditline then 'ON HOLD - THIS WILL PUSH OVER TERMS'
                                                                when t5.country  like 'IE' and (t2.[Open SO Value] + t4.[Del Value] + t4.Balance) > t4.creditline + 100 then 'ON HOLD - THIS WILL PUSH OVER TERMS'
                                                                when t8.U_credit_choice = 'On Hold' then 'ON HOLD - Brid SO'
                                                                else t4.Within_Line end [Acc Status], t5.CreditLine, t5.Balance, t5.BalanceFC, t0.LineNum

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
                                                                left join [dbo].[@BP_CREDIT_CONTROL] t7 on t7.U_credit_choice = t5.U_credit_control
                                                                left join [dbo].[@SO_CREDIT_CONTROL] t8 on t8.U_credit_choice = t1.U_credit_control
                                                                ---left join iis_epc_pro_orderh t6 on t6.SONum = t1.docnum and t6.EndProduct = t0.ItemCode

                                                                where t0.LineStatus = 'o'
                                                                and t3.Name not like 'Pre Production Potential'
                                                                and t0.ItemCode <> 'TRANSPORT'
                                                                and t1.CardCode <> 'KEN021'
                                                                AND 
                                                                (case 
                                                                when t4.Within_Line like 'ON HOLD%' then t4.Within_Line
                                                                when t5.country not like 'IE' and (t2.[Open SO Value FC] + t4.[Del ValueFC] + t5.BalanceFC) > t4.creditline then 'ON HOLD - THIS WILL PUSH OVER TERMS'
                                                                when t5.country  like 'IE' and (t2.[Open SO Value] + t4.[Del Value] + t4.Balance) > t4.creditline + 100 then 'ON HOLD - THIS WILL PUSH OVER TERMS'
                                                                when t8.U_credit_choice = 'On Hold' then 'On Hold - Brid SO'
                                                                else t4.Within_Line end ) like 'ON HOLD%'
                                                                and (t7.U_credit_choice not like 'OK to Go' or t7.U_credit_choice is null or t7.U_credit_choice like 'On Hold')
                                                                and (t8.U_credit_choice not like 'OK to Go' or t8.U_credit_choice is null or t8.U_credit_choice like 'On Hold')

                                ) t1 on  t1.[Sales Order] = t0.[Sales Order] and t1.LineNum = t0.LineNum 
   
   
   where t0.[Del Date Due UNP] <= [Monday TW Date]+18
    and t0.[Project] not like 'Training'and t0.[Project] not like 'Stock'
    
 ORDER BY t0.[Project]









";
