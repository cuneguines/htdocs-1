
<?php 
            $tsql="SELECT
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
			ISNULL(t12.U_Product_Group_One,'NO GROUP')[U_Product_Group_One],
            ISNULL(t12.U_Product_Group_Two,'NO GROUP')[U_Product_Group_Two]
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
            INNER JOIN IIS_EPC_PRO_ORDERL t1 ON t1.PrOrder = t0.PrOrder
            INNER JOIN OITM t2 ON t2.ItemCode = t1.StepItem
            LEFT JOIN OWOR t3 ON t3.U_IIS_proPrOrder = t0.PrOrder AND t3.itemCode = t0.EndProduct
            LEFT JOIN ORDR t7 ON t7.DocNum = t3.OriginNum
            LEFT JOIN RDR1 t8 ON t8.DocEntry = t7.DocEntry AND t8.ItemCode = t0.EndProduct AND T8.LineStatus = 'O'
			left join oitm t12 on t12.ItemCode = t8.ItemCode
            left join oitb t13 on t13.ItmsGrpCod = t12.ItmsGrpCod
            LEFT JOIN OSLP t99 ON t99.SlpCode = t8.SlpCode
            LEFT JOIN OHEM t22 ON t22.EmpID = t7.OwnerCode
            ---Changed 18-01-23--
            left join [dbo].[@PRE_PROD_STATUS] as t24 on t24.code    = t8.U_PP_Status
    

    
            LEFT JOIN(
            SELECT t0.PrOrder, t0.StepItem, t0.StepCode, ROW_NUMBER() OVER (PARTITION BY t0.PrOrder ORDER BY t0.StepCode ASC)[RowNum] 
                FROM IIS_EPC_PRO_ORDERL t0
                    WHERE t0.StepType = 'P' AND t0.StepDesc NOT LIKE '%LABOUR%'
            )t17 ON t17.PrOrder = t0.PrOrder AND t17.StepItem = t1.StepItem AND t17.StepCode = t1.StepCode
    
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
        
        
    
    ORDER BY [Sub Component]"?>