<?php
    // LISTS THE REMAINING DEMAND FOR EACH PROCESS ON ALL OPEN PROCESS ORDERS BY SEQUENCE CODE
    //Changed 10-01-23 not updating
    //changed 12-02-23
    $production_group_step_demand_all_sql = 
    "SELECT
    t2.U_OldCode [Sequence Code],
    SUM(CAST(CASE WHEN (t1.ProcessTime - ISNULL(t6.[Booked Hours],0)) < 0 THEN 0 ELSE (t1.ProcessTime - ISNULL(t6.[Booked Hours],0)) END  AS DECIMAL(12,2)))[QTY]

    FROM IIS_EPC_PRO_ORDERH t0
        INNER JOIN IIS_EPC_PRO_ORDERL t1 ON t1.PrOrder = t0.PrOrder
        INNER JOIN OITM t2 ON t2.ItemCode = t1.StepItem
        left JOIN OWOR t3 ON t3.U_IIS_proPrOrder = t0.PrOrder AND t3.itemCode = t0.EndProduct
    
        LEFT JOIN(
            SELECT t0.PrOrder, t0.LineID, ISNULL(SUM(t0.Quantity),0)[Booked Hours]
                FROM IIS_EPC_PRO_ORDERT t0
                GROUP BY t0.PrORder, t0.LineID
        )t6 ON t6.PrOrder = t0.PrOrder AND t6.LineID = t1.StepCode


        LEFT JOIN(SELECT t0.PrOrder, t0.LineID, t0.StepItem, t0.ParentLine, t1.StepItem [To_Make],
                    CASE WHEN t2.PrOrder is null THEN 'Sub Component' else 'End Product' END [Class],
                    t1.UseStock
                    from IIS_EPC_PRO_ORDERL t0
                    inner join (
                        SELECT t0.PrOrder, t0.LineID, t0.StepItem, t0.UseStock
                        from IIS_EPC_PRO_ORDERL t0
                            WHERE t0.StepType = 'B'
                    )t1 ON t1.PrOrder = t0.PrOrder and t1.LineID = t0.ParentLine
                    left join iis_epc_pro_orderh t2 ON t2.PrOrder = t0.PrOrder and t2.EndProduct = t1.StepItem

                        WHERE t0.StepType <> 'B'

        )t10 ON t10.PrOrder = t1.PrOrder and t10.lineid= t1.LineID
        
        inner join oitm t11 ON t11.ItemCode = t10.To_Make
        
        WHERE t1.StepType <> 'B' AND t0.Status IN ('P','I','S','R') AND t1.Status IN ('O','P') AND t3.Status IN ('R','L') AND t10.UseStock <> 'Y' AND t2.U_OldCode LIKE 'SEQ%'
        GROUP BY t2.U_OldCode
";

    // TAKES THE BOOKED TIME FOR EACH LABOUR CODE WITH A SEQUENCE CODE FOR THE PAST 10 WEEKS, TAKES THE TOP 5 AND FINDS THE AVERAGE OF THAT TO GIVE A GENERAL OPERATING EXECUTION TIME FOR EACH LABOUR STEP
    $sql_production_group_step_avg_execution = "WITH rws as(
        select 
            t0.LabourCode,
            t1.U_OldCode,
            DATEPART(WEEK,t0.Created)[WEEK],
            SUM(t0.Quantity)[SUM], 
               row_number () over (
                 partition by t0.LabourCode
                 order by SUM(t0.Quantity) DESC
               ) rn
        from  IIS_EPC_PRO_ORDERT t0
        LEFT JOIN OITM t1 ON t1.ItemCode  = t0.LabourCode
        WHERE t0.Created > DATEADD(WEEK,-10,DATEADD(DAY,-DATEPART(WEEKDAY,GETDATE()),GETDATE())) AND t0.Created < DATEADD(DAY,-DATEPART(WEEKDAY,GETDATE()),GETDATE()) AND t1.U_OldCode LIKE 'SEQ%'
        GROUP BY t0.LabourCode, t1.U_OldCode, DATEPART(WEEK,t0.Created)
        )
        SELECT U_OldCode, SUM([SUM])/5[AVG OF BEST 5 WEEKS FROM LAST 10] FROM rws
            WHERE rn <= 5
                GROUP BY U_OldCode
                    ORDER BY U_OldCode;";

    // RETURNS A LOG OF ALL BOOKED ENTRIES TO PROCESS STEPS ON OPEN PROCESS ORDERS
    $sql_logged_entries = "SELECT 
    t0.PrOrder, t1.U_OldCode, t0.UserId, t0.LineID, t5.ProcessTime, t2.firstName + ' ' + t2.lastName[Name], t0.Quantity[Qty], (t0.Created, 'dd-MM-yyyy')[Date], t0.Remarks
        FROM IIS_EPC_PRO_ORDERT t0
        LEFT JOIN OITM t1 ON t1.ItemCode = t0.LabourCode
        LEFT JOIN OHEM t2 ON t2.EmpID = t0.UserId
        LEFT JOIN IIS_EPC_PRO_ORDERH t4 ON t4.PrOrder = t0.PrOrder
		LEFT JOIN IIS_EPC_PRO_ORDERL t5 ON t5.LineID = t0.LineID AND t5.PrOrder = t0.PrORder
            WHERE t1.U_OldCode LIKE '%SEQ%' AND t4.Status IN ('P','R','S','I')
                ORDER BY t0.PrOrder DESC, t0.LineID, t1.U_OldCode, t0.Created ASC
    ";

    // RETURNS A LOG OF ALL REMAKRS TO PROCESS STEPS ON OPEN PROCESS ORDERS
    $sql_step_remarks = "SELECT 
    t0.PrOrder, t1.U_OldCode, t0.UserId, t0.LineID, t2.firstName + ' ' + t2.lastName[Name], FORMAT(t0.Created, 'dd-MM-yyyy')[Date], t0.Remarks
        FROM IIS_EPC_PRO_ORDERT t0
        LEFT JOIN OITM t1 ON t1.ItemCode = t0.LabourCode
        LEFT JOIN OHEM t2 ON t2.EmpID = t0.UserId
        LEFT JOIN IIS_EPC_PRO_ORDERH t4 ON t4.PrOrder = t0.PrOrder
            WHERE t1.U_OldCode LIKE '%SEQ%' AND t4.Status IN ('P','R','S','I') AND t0.Remarks <> '' AND t0.Remarks LIKE '% %'
                ORDER BY t0.PrOrder DESC, t1.U_OldCode, t0.Created ASC";

    // RETURNS A TABLE OF ALL OPEN LABOUR ENTRIES ON OPEN PROCESS ORDERS AND ASSOCIATED DETAILS
    $production_group_step_table_sql = 
    "select
    CASE 

        WHEN DATEPART(dw,DATEADD(DAY,-(t0.[WORKDAYS] + FLOOR(t0.[WORKDAYS]/7)*2),t0.[Promise Date])) IN (1,7) THEN convert(varchar,DATEADD(DAY,-2,DATEADD(DAY,-(t0.[WORKDAYS]+FLOOR(t0.[WORKDAYS]/7)*2),t0.[Promise Date])),10)
        ELSE convert(varchar,DATEADD(DAY,-(t0.[WORKDAYS]+FLOOR(t0.[WORKDAYS]/7)*2),t0.[Promise Date]),10)
    END[Est LS Start Date],
    CASE 
        WHEN DATEPART(dw,DATEADD(DAY,-(t0.[WORKDAYS] + FLOOR(t0.[WORKDAYS]/7)*2),t0.[Promise Date])) IN (1,7) THEN DATEADD(DAY,-2,DATEADD(DAY,-(t0.[WORKDAYS]+FLOOR(t0.[WORKDAYS]/7)*2),t0.[Promise Date]))
        ELSE DATEADD(DAY,-(t0.[WORKDAYS]+FLOOR(t0.[WORKDAYS]/7)*2),t0.[Promise Date])
    END[Est LS Start Date1],
    DATEDIFF(WEEK,GETDATE(),CASE 
        WHEN DATEPART(dw,DATEADD(DAY,-(t0.[WORKDAYS]+FLOOR(t0.[WORKDAYS]/7)*2),t0.[Promise Date])) IN (1,7) THEN DATEADD(DAY,-2,DATEADD(DAY,-(t0.[WORKDAYS]+FLOOR(t0.[WORKDAYS]/7)*2),t0.[Promise Date]))
        ELSE DATEADD(DAY,-(t0.[WORKDAYS]+FLOOR(t0.[WORKDAYS]/7)*2),t0.[Promise Date])
    END)[Est LS Start Date DIFFWEEK],
    DATEPART(ISO_WEEK,CASE 
        WHEN DATEPART(dw,DATEADD(DAY,-(t0.[WORKDAYS]+FLOOR(t0.[WORKDAYS]/7)*2),t0.[Promise Date])) IN (1,7) THEN DATEADD(DAY,-2,DATEADD(DAY,-(t0.[WORKDAYS]+FLOOR(t0.[WORKDAYS]/7)*2),t0.[Promise Date]))
        ELSE DATEADD(DAY,-(t0.[WORKDAYS]+FLOOR(t0.[WORKDAYS]/7)*2),t0.[Promise Date])
    END)[Est LS Start Date WEEKNO],
    CASE 
        WHEN DATEPART(dw,DATEADD(DAY,-(t0.[WORKDAYS]+FLOOR(t0.[WORKDAYS]/7)*2),t0.[Promise Date])) IN (1,7) THEN t0.[WORKDAYS]+FLOOR(t0.[WORKDAYS]/7)*2 + 2
        ELSE t0.[WORKDAYS]+FLOOR(t0.[WORKDAYS]/7)*2
    END[DAYS],
    *
    FROM(
        SELECT  (t0.[REMAINING]/(8*0.63))/((0.2/90)*t0.[REMAINING]+ 0.5+2)[PRECALCULATED WORKDAYS],
                FLOOR(0.22*(t0.[Planned Hours (Process Order)]/(8*0.63)/((0.2/90)*t0.[Planned Hours (Process Order)]+0.5))+7) [SUBCON ADJUSTMENT],
                (t0.[REMAINING]/(8*0.63))/((0.2/90)*t0.[REMAINING]+ 0.5) +2+ CASE WHEN t0.[Sub Con Items] is not null THEN FLOOR(0.22*(t0.[Planned Hours (Process Order)]/(8*0.63)/((0.2/90)*t0.[Planned Hours (Process Order)]+0.5))+14*t0.[Sub Con Items] ) ELSE 0 END[WORKDAYS],
                * 
        FROM(

            SELECT
			t44.[Sub Con Items],
            ISNULL(t16.[SUBCON],'N')[SUBCON],
            ISNULL(t7.DocNum, 000000) [Sales Order],
            ISNULL(t7.CardName,'STOCK')[Customer],
            ISNULL(t7.U_Client,'NO PROJECT')[Project],
            t22.firstName + ' ' + t22.LastName [Sales Person],
            t99.SlpName[Engineer],
            CAST(ISNULL(t8.U_Promise_Date, t3.DueDate) AS DATE)[Promise Date],
            
            CASE WHEN (t18.StepItem <> t0.EndProduct) THEN 'Y' ELSE 'N' END [Sub Component],
            t18.StepDesc[Item Name],
            

            t0.PrOrder [Process Order],
            ---Changed 18-01-23--
            
            case when t24.[Name] is null then t8.U_PP_Status else t24.[Name] end [Status],
            ---changed 23-01-23---
            t8.U_PDM_Project[PDM],
            t1.StepCode[Step Number],
            t17.RowNum,
            t2.U_OldCode [Sequence Code],
            t1.StepItem[Step Labour Code],
            t1.StepDesc[Step Description],
            t1.Instructions[Instructions],
            CAST(t1.ProcessTime AS DECIMAL (12,2))[Planned Hours],
            CAST(t6.[Booked Hours] AS DECIMAL (12,2))[Booked Hours],
            CAST(CASE WHEN (t1.ProcessTime - ISNULL(t6.[Booked Hours],0)) < 0 THEN 0 ELSE (t1.ProcessTime - ISNULL(t6.[Booked Hours],0)) END  AS DECIMAL(12,2))[Remaining Hours Stage],

            (Select sum(CAST(t20.ProcessTime AS DECIMAL(12,2))) from IIS_EPC_PRO_ORDERL t20 WHERE t20.PrOrder = t1.PrOrder AND t20.LineID <= t1.LineID)[CUMULATIVE],
            (Select sum(CAST(t20.ProcessTime AS DECIMAL(12,2))) from IIS_EPC_PRO_ORDERL t20 where t20.PrOrder = t1.PrOrder AND t20.LineID >= t1.LineID)[REMAINING],

            CAST(t15.[TOTAL PLANNED HOURS] AS DECIMAL (12,0))[Planned Hours (Process Order)],          
        
            /* LEFT JOIN PREVIOUS STEP ON PRORDER WHERE STEPCODE IS ONE LESS THAN THE CURRENT STEPCODE */
            ISNULL(t_LS_1.[Step],'N/A')[Previous Step],
            CAST(t_LS_2.[PlannedQty] AS DECIMAL(12,1))[Prev Step Planned Hours],
            CAST(t_LS_1.[Hours_Booked] AS DECIMAL(12,1))[Prev Step Booked Hours],
            CASE
                WHEN t_LS_1.Status LIKE 'C' THEN 'RD'
                WHEN t_LS_1.[Step] IS NULL THEN 'FS'
                WHEN t_LS_1.Status <> 'C' AND ISNULL(t_LS_1.[Hours_Booked],0) = 0 THEN 'NS'
                WHEN t_LS_1.Status <> 'C' AND (t_LS_1.[Hours_Booked]/t_LS_2.[PlannedQty]) > 0.75 THEN 'NC'
                WHEN t_LS_1.Status <> 'C' AND ISNULL(t_LS_2.[PlannedQty],0) <> 0 THEN 'IP'
                ELSE 'NS'
            END[Prev Step Status],  
        
            /* LEFT JOIN NEXT STEP ON PRORDER WHERE STEPCODE IS ONE MORE THAN THE CURRENT STEPCODE */
            ISNULL(t_NS_1.[Step],'N/A')[Next Step],
            CAST(t_NS_2.PlannedQty AS DECIMAL(12,1))[Next Step Planned Hours],
            CAST(t_NS_1.[Hours_Booked] AS DECIMAL(12,1))[Next Step Booked Hours],

            CAST(t9.[LAST FAB DATE] AS DATE)[LAST FAB DATE],
            DATEDIFF(DAY,t9.[LAST FAB DATE],GETDATE())[DAYS DIFF],
            CASE WHEN t3.CmpltQty >= t3.PlannedQty THEN 'Y' ELSE 'N' END[Complete_Prd]
        
    
            FROM IIS_EPC_PRO_ORDERH t0
            INNER JOIN IIS_EPC_PRO_ORDERL t1 ON t1.PrOrder = t0.PrOrder and t1.Released = 'Y'
            INNER JOIN OITM t2 ON t2.ItemCode = t1.StepItem
            LEFT JOIN OWOR t3 ON t3.U_IIS_proPrOrder = t0.PrOrder AND t3.itemCode = t0.EndProduct
            LEFT JOIN ORDR t7 ON t7.DocNum = t3.OriginNum 
            LEFT JOIN RDR1 t8 ON t8.DocEntry = t7.DocEntry AND t8.ItemCode = t0.EndProduct AND T8.LineStatus = 'O' and t8.Quantity = t0.BatchSize and t8.u_IIS_proPrOrder=t0.PrOrder
            LEFT JOIN OSLP t99 ON t99.SlpCode = t8.SlpCode
            LEFT JOIN OHEM t22 ON t22.EmpID = t7.OwnerCode
            ---Changed 18-01-23--
            left join [dbo].[@PRE_PROD_STATUS] as t24 on t24.code    = t8.U_PP_Status
    

    
            LEFT JOIN(
            SELECT t0.PrOrder, t0.StepItem, t0.StepCode, ROW_NUMBER() OVER (PARTITION BY t0.PrOrder ORDER BY t0.StepCode ASC)[RowNum] 
                FROM IIS_EPC_PRO_ORDERL t0
                    WHERE t0.StepType = 'P' AND t0.StepDesc NOT LIKE '%LABOUR%'
            )t17 ON t17.PrOrder = t0.PrOrder AND t17.StepItem = t1.StepItem AND t17.StepCode = t1.StepCode

			/*changed 14/03/23 addedd sub con items to find nuber of suncon items*/

			left join (select t0.U_IIS_proPrOrder, count(t1.itemcode) [Sub Con Items]

from owor t0
inner join wor1 t1 on t1.DocEntry = t0.DocEntry
inner join oitm t2 on t2.ItemCode = t1.ItemCode
inner join oitb t3 on t3.ItmsGrpCod = t2.ItmsGrpCod

where t2.ItemName like 'SUBCONTRACT'
and t0.Status not in ('L','C')


group by t0.U_IIS_proPrOrder)t44 on t44.U_IIS_proPrOrder =t0.PrOrder




    
        /* NEXT STEP AND LAST STEP JOINS */
            LEFT JOIN(
                SELECT t0.PrOrder, t0.StepCode, t0.Status, ISNULL(t0.StepDesc,'FIRST STEP')[Step], t0.Status[Step Status], t1.Hours_Booked, ROW_NUMBER() OVER (PARTITION BY t0.PrOrder ORDER BY t0.StepCode ASC)[RowNum]
                    FROM IIS_EPC_PRO_ORDERL t0
                        LEFT JOIN(
                            SELECT t1.PrOrder, t1.LabourCode, t1.LineID, sum(t1.Quantity) [Hours_Booked]
                                FROM IIS_EPC_PRO_ORDERT t1 
                                    GROUP BY t1.PrOrder, t1.LabourCode, t1.LineID
                        )t1 ON t1.PrOrder = t0.PrOrder and t1.LabourCode = t0.StepItem and t1.LineID = t0.LineID
                        WHERE t0.StepType = 'P' AND t0.StepDesc NOT LIKE '%LABOUR%'
            )t_LS_1 ON t_LS_1.PrOrder = t1.PrOrder AND t_LS_1.[RowNum] = t17.[RowNum] - 1
            LEFT JOIN(
                SELECT t0.PrOrder, t0.StepCode, t0.Status, ISNULL(t0.StepDesc,'FIRST STEP')[Step], t0.Status[Step Status], t1.Hours_Booked, ROW_NUMBER() OVER (PARTITION BY t0.PrOrder ORDER BY t0.StepCode ASC)[RowNum]
                        FROM IIS_EPC_PRO_ORDERL t0
                            LEFT JOIN(
                                SELECT t1.PrOrder, t1.LabourCode, t1.LineID, sum(t1.Quantity) [Hours_Booked]
                                    FROM IIS_EPC_PRO_ORDERT t1 
                                        GROUP BY t1.PrOrder, t1.LabourCode, t1.LineID
                            )t1 ON t1.PrOrder = t0.PrOrder and t1.LabourCode = t0.StepItem and t1.LineID = t0.LineID
                            WHERE t0.StepType = 'P' AND t0.StepDesc NOT LIKE '%LABOUR%'
            )t_NS_1 ON t_NS_1.PrOrder = t1.PrOrder AND t_NS_1.[RowNum] = t17.[RowNum] + 1
    
            /* PROCESS->PRODUCTION ORDER JOINS */
            LEFT JOIN(SELECT t0.PrOrder, t0.LineID, t0.StepItem, t0.ParentLine, t1.StepItem [To_Make], 
                        CASE WHEN t2.PrOrder is null THEN 'Sub Component' else 'End Product' END [Class],
                        CASE WHEN t3.DocNum is null THEN 'No Prod Ord' else 'Prod Ord' END [In Prod?],
                        t1.UseStock
                        from IIS_EPC_PRO_ORDERL t0
                        inner join (
                            SELECT t0.PrOrder, t0.LineID, t0.StepItem, t0.UseStock
                            from IIS_EPC_PRO_ORDERL t0
                                WHERE t0.StepType = 'B'
                        )t1 ON t1.PrOrder = t0.PrOrder and t1.LineID = t0.ParentLine
                        left join iis_epc_pro_orderh t2 ON t2.PrOrder = t0.PrOrder and t2.EndProduct = t1.StepItem
                        left join owor t3 ON t3.U_IIS_proPrOrder = t0.prorder and t3.ItemCode = t1.StepItem
                            WHERE t0.StepType <> 'B'
            )t10 ON t10.PrOrder = t1.PrOrder and t10.lineid= t1.LineID
            inner join oitm t11 ON t11.ItemCode = t10.To_Make
    
            /* NEXT AND PREVIOUS STEP DETAILS P2 */
            LEFT JOIN (
                SELECT t0.U_IIS_proPrOrder, t1.ItemCode, t1.U_IIS_proPrLineID, t1.PlannedQty, t0.ItemCode [To Make], t1.LineNum
                    FROM owor t0
                    INNER JOIN wor1 t1 ON t1.DocEntry = t0.DocEntry
                    INNER JOIN oitm t2 ON t2.ItemCode = t1.ItemCode
                        WHERE t2.ItemType = 'L'
            ) t_LS_2 ON t_LS_2.U_IIS_proPrOrder = t0.PrOrder and t_LS_2.U_IIS_proPrLineID = t_LS_1.StepCode and t_LS_2.[To Make] = t10.To_Make
            LEFT JOIN (
                SELECT t0.U_IIS_proPrOrder, t1.ItemCode, t1.U_IIS_proPrLineID, t1.PlannedQty, t0.ItemCode [To Make], t1.LineNum
                    from owor t0
                        inner join wor1 t1 ON t1.DocEntry = t0.DocEntry
                        inner join oitm t2 ON t2.ItemCode = t1.ItemCode
                            WHERE t2.ItemType = 'L'
            ) t_NS_2 ON t_NS_2.U_IIS_proPrOrder = t0.PrOrder and t_NS_2.U_IIS_proPrLineID = t_NS_1.StepCode and t_NS_2.[To Make] = t10.To_Make
        
            /* OTHER DETAILS */
            LEFT JOIN(
               SELECT t0.PrOrder, MAX(t0.Created)[LAST FAB DATE]
                      FROM IIS_EPC_PRO_ORDERT t0
                               inner join oitm t1 ON t1.itemcode = t0.LabourCode
                      GROUP By t0.PrORder
            )t9 ON t9.PrOrder = t0.PrORder
            LEFT JOIN(
               SELECT t0.PrOrder, SUM(t0.ProcessTime) [TOTAL PLANNED HOURS] 
                    FROM IIS_EPC_PRO_ORDERL t0
                        GROUP BY t0.PrOrder
            )t15 ON t15.PrOrder = t0.PrOrder
            LEFT JOIN(
                SELECT t0.PrOrder, t0.LineID, ISNULL(SUM(t0.Quantity),0)[Booked Hours] 
                    FROM IIS_EPC_PRO_ORDERT t0
                    GROUP BY t0.PrORder, t0.LineID
            )t6 ON t6.PrOrder = t0.PrOrder AND t6.LineID = t1.StepCode
            LEFT JOIN(
                SELECT t0.PrOrder, MAX(t0.LineID)[LineID] ,'Y'[SUBCON]
                    FROM IIS_EPC_PRO_ORDERL t0
                    LEFT JOIN OITM t1 ON t1.ItemCode = t0.StepItem
                        WHERE t1.U_OldCode LIKE 'SEQ026'
                            GROUP BY t0.PrOrder
            )t16 ON t16.PrOrder = t0.PrORder

            LEFT JOIN(
                SELECT t0.PrOrder, t0.LineID, t0.ParentLine, t0.StepItem, t0.StepDesc FROM IIS_EPC_Pro_ORDERL t0
            )t18 ON t18.PrOrder = t0.PrOrder AND t18.LineID = t1.ParentLine
    
        
            WHERE t1.StepType <> 'B' AND t0.Status IN ('P','I','S','R') AND t1.Status IN ('O','P') AND t3.Status IN ('R','L') AND t10.UseStock <> 'Y'
            AND t2.U_OldCode LIKE 'SEQ%' 
        
        )t0
    )t0
---t0.[Process Order]=47773

    ORDER BY [Est LS Start Date1]

    ";