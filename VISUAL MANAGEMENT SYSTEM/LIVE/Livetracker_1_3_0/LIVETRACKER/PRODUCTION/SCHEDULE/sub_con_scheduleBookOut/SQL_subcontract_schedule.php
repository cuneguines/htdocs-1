
<?php
$tsql =
        "
        SELECT 
        ISNULL(t0.[Process Order],'N/A')[Process Order],
        t2.docnum [Prod Ord],
        t0.[Sales Person],
        t3.ItemCode,
        FORMAT(CAST (t1.DocDate AS DATE),'dd-MM-yyyy')[GRN_Date],
        t0.ItemName,
        CASE WHEN t0.PrcrmntMtd = 'B' THEN 'BUY' ELSE 'MAKE' END[MAKE OR BUY],
        t0.[Planned Qty],
        isnull(t3.IsCommited,0) [qty_committed], 
        t0.[Issued Qty],
        CAST (t0.IsCommited as decimal)[Commited],
        CAST (t0.ONHand as decimal)[ONHand],  
        t0.[On Order],
        FORMAT(CAST(t0.[Promise Date UNP] AS DATE),'dd-MM-yyyy') [Promise Date UNP],
        CASE 
        WHEN ISNULL(DATEDIFF(WEEK,GETDATE(),t0.[Promise Date UNP])," . ($start_range - 1) . ") < " . $start_range . " THEN " . ($start_range - 1) . "
        WHEN ISNULL(DATEDIFF(WEEK,GETDATE(),t0.[Promise Date UNP])," . ($start_range - 1) . ") > " . $end_range . " AND ISNULL(DATEDIFF(WEEK,GETDATE(),t0.[Promise Date UNP])," . ($start_range - 1) . ") < " . ($end_range + 13) . " THEN " . ($end_range + 1) . "
        WHEN ISNULL(DATEDIFF(WEEK,GETDATE(),t0.[Promise Date UNP])," . ($start_range - 1) . ") >= " . ($end_range + 13) . " AND ISNULL(DATEDIFF(WEEK,GETDATE(),t0.[Promise Date UNP])," . ($start_range - 1) . ") < " . ($end_range + 26) . " THEN " . ($end_range + 2) . "
        WHEN ISNULL(DATEDIFF(WEEK,GETDATE(),t0.[Promise Date UNP])," . ($start_range - 1) . ") >= " . ($end_range + 26) . " THEN " . ($end_range + 3) . "
        
        ELSE ISNULL(DATEDIFF(WEEK,GETDATE(),t0.[Promise Date UNP])," . ($start_range - 1) . ")
        END [Promise Diff Week],
        CASE 
        when t0.[Promise Date UNP] is null  then 14
        WHEN DATEDIFF(DAY,GETDATE(),t0.[Promise Date UNP]) < -14 THEN -4
        WHEN DATEDIFF(DAY,GETDATE(),t0.[Promise Date UNP]) >= -14 AND DATEDIFF(DAY,GETDATE(),t0.[Promise Date UNP]) < -7 THEN -5
        WHEN DATEDIFF(DAY,GETDATE(),t0.[Promise Date UNP]) >= -7 AND DATEDIFF(DAY,GETDATE(),t0.[Promise Date UNP]) <= -4 THEN -4
        WHEN DATEDIFF(DAY,GETDATE(),t0.[Promise Date UNP]) =-1 THEN -1
        WHEN DATEDIFF(DAY,GETDATE(),t0.[Promise Date UNP]) =-2 THEN -2
        WHEN DATEDIFF(DAY,GETDATE(),t0.[Promise Date UNP]) =-3 THEN -3
        WHEN DATEDIFF(DAY,GETDATE(),t0.[Promise Date UNP]) >= 15 THEN 14
        WHEN DATEDIFF(DAY,GETDATE(),t0.[Promise Date UNP]) = 6 THEN 6
        WHEN DATEDIFF(DAY,GETDATE(),t0.[Promise Date UNP]) = 7 THEN 7
        WHEN DATEDIFF(DAY,GETDATE(),t0.[Promise Date UNP]) = 8 THEN 8
        WHEN DATEDIFF(DAY,GETDATE(),t0.[Promise Date UNP]) = 9 THEN 9
        WHEN DATEDIFF(DAY,GETDATE(),t0.[Promise Date UNP]) = 10 THEN 10
        WHEN DATEDIFF(DAY,GETDATE(),t0.[Promise Date UNP]) = 11 THEN 11
        WHEN DATEDIFF(DAY,GETDATE(),t0.[Promise Date UNP]) = 12THEN 12
        WHEN DATEDIFF(DAY,GETDATE(),t0.[Promise Date UNP]) = 13THEN 13
        WHEN DATEDIFF(DAY,GETDATE(),t0.[Promise Date UNP]) =14THEN 14
        WHEN DATEDIFF(DAY,GETDATE(),t0.[Promise Date UNP]) >=15 THEN 15
        ELSE DATEDIFF(DAY,GETDATE(),t0.[Promise Date UNP])
        END [Promise Diff Days], /* DAYS HERE */
        CASE 
        WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Promise Date UNP]) = 0 THEN 'Monday'
        WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Promise Date UNP]) =1 THEN 'Tuesday'
        WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Promise Date UNP]) =2 THEN 'Wednesday'
        WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Promise Date UNP]) =3 THEN 'Thursday'
        WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Promise Date UNP]) =4 THEN 'Friday'
        WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Promise Date UNP]) =5 THEN 'Saturday'
        WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Promise Date UNP]) =6 THEN 'Sunday'
        WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Promise Date UNP]) =7 THEN 'MNW'
        WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Promise Date UNP]) =8 THEN 'TNW'
        WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Promise Date UNP]) =9 THEN 'WNW'
        WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Promise Date UNP]) =10 THEN 'THNW'
        WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Promise Date UNP]) =11 THEN 'FNW'
        WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Promise Date UNP]) =13 THEN 'MNNW'
        WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Promise Date UNP]) =14 THEN 'TNNW'
        WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Promise Date UNP]) =15 THEN 'WNNW'
        WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Promise Date UNP]) =16 THEN 'TNNW'
        WHEN DATEDIFF(DAY,[Monday TW Date],t0.[Promise Date UNP]) <-4 THEN 'Other'
        when  DATEDIFF(DAY,[Monday TW Date],t0.[Promise Date UNP]) =-3 THEN 'LastworkingDay'
        
        ELSE 'Ot'
        
        END [Days of the Week], /* DAYS HERE */
        case
        when  DATEDIFF(DAY,getdate(),t0.[Promise Date UNP]) =-3 THEN 'LastthreeDays'
        when  DATEDIFF(DAY,getdate(),t0.[Promise Date UNP]) =-2 THEN 'LastthreeDays'
        when  DATEDIFF(DAY,getdate(),t0.[Promise Date UNP]) =-1 THEN 'LastthreeDays'
        END [Last three days], /* DAYS HERE */

        
        t0.[IssuedQty],
       t0.[PlannedQty],
        t0.Dscription,
        
        t0.Customer,
        t1.Docnum [Sales Order],
        FORMAT(t0.[Dispatch Date],'dd-MM-yyyy')[Dispatch Date],
        t0.[Latest Purchase Ord], 
        t0.Supplier,
        FORMAT(t0.[Purchase Due],'dd-MM-yyyy')[Purchase Due],
        t0.[Shortage Warning],
        t0.[PO Warning],
        t0.[Type],
        t0.[Weeks Overdue_2],
        t0.[Weeks Overdue_4],
        t0.[Date_Diff],
        FORMAT(t0.[Due Date],'dd-MM-yyyy')[Due Date],
        FORMAT(t0.[Floor Date],'dd-MM-yyyy')[Floor Date],
        t0.[Purchase Overdue],
        t0.[Engineer],
        t0.[Comments_PO],
        t0.[Comments_SO],
        t0.[Stock Check], 
        FORMAT(CAST(t0.Sub_Con_Date AS DATE),'dd-MM-yyyy')[Sub_Con_Date], 
        t0.Sub_Con_Remarks,
        isnull(t0.Sub_Con_Status,'No stat')[Sub_Con_Status],
        t0.[Project], t5.latest_po_date[Latest Puchase Ord], t4.supplier[supplier], 
        FORMAT(CAST(t5.earliest_po_due_date AS DATE),'dd-MM-yyyy') [PO Due Date]
        ----t22.Comments
        
        FROM (
        
              -------Material needed for process orders for customers
            SELECT  
            t7.Dscription[Dscription],
            t0.IssuedQty[IssuedQty],
            t0.PlannedQty[PlannedQty],
            DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE())[Monday TW Date],
            DATEADD(d, 1 - DATEPART(w, GETDATE())+8, GETDATE())[Monday LW Date],
            t1.U_IIS_proPrOrder [Process Order],
                    t1.docnum [Prod Ord],
                    t2.ItemCode,
                    t2.ItemName,
                    t3.firstname + ' ' + t3.lastName [Sales Person],
                    t2.PrcrmntMtd, 
                    ISNULL(t4.U_Client,'000_NO PROJECT_000') [Project],
                    CAST(t0.PlannedQty AS DECIMAL(12,0))[Planned Qty],
                    CAST(t0.IssuedQty AS DECIMAL(12,0))[Issued Qty],
                    t2.ONHand,
                    t2.IsCommited,
                    CAST(t2.ONorder AS DECIMAL(12,0)) [On Order], 
                    isnull(t6.cardname,'Stock') [Customer], 
                    t4.docnum [Sales Order],
                    isnull(ISNULL(t7.U_Delivery_Date,t4.DocDueDate), t1.DueDate) [Dispatch Date], 
                    t9.docnum [Latest Purchase Ord],
                    ISNULL(t9.cardname, 'NO SUPPLIER') [Supplier],
                    isnull(t10.SlpName,t12.U_NAME) [Engineer], 
                    CAST(t8.DocDueDate AS DATE) [Purchase Due],
                    (CASE WHEN t0.PlannedQty < (t2.ONhand - t2.IsCommited + t0.PlannedQty) THEN 'IN STOCK' ELSE 'NOT IN STOCK' END)[Stock Check],
                    (case when t8.DocDueDate > ISNULL(t7.U_Delivery_Date,t4.DocDueDate) then 'PO DUE AFTER DISPATCH DATE' else '' end) [Shortage Warning],
                    (case when t8.DocDueDate < GETDATE() then 'PURCHASE OVERDUE' else '' end) [PO Warning],
                    (CASE
                        WHEN t5.ItmsGrpNam LIKE '%Sheet%' OR t5.ItmsGrpNam LIKE '%Bar%' OR t5.ItmsGrpNam LIKE '%Box%' OR t5.ItmsGrpNam LIKE '%Angle%' OR t5.ItmsGrpNam LIKE '%Pipe%' THEN 'SH'
                        WHEN t5.ItmsGrpNam = 'Sub CON - Purchases' THEN 'SC'
                        WHEN t5.ItmsGrpNam LIKE '%Mesh Grate%' THEN 'GR'
                        WHEN t5.ItmsGrpNam = 'Fixings' THEN 'FX'
                        WHEN t5.ItmsGrpNam = 'Fittings - Springs' OR t5.ItmsGrpNam = 'Fittings 304' OR t5.ItmsGrpNam = 'Fittings 316' OR t5.ItmsGrpNam = 'Fittings NON-SS' OR t5.ItmsGrpNam LIKE '%Gaskets%' THEN 'FT'
                        WHEN t8.DocDueDate is null THEN 'X'
                        ELSE 'N'
                    END) [Type],
                    DATEDIFF(week, ISNULL(t7.U_Promise_date,t1.DueDate), GETDATE()) + 2 [Weeks Overdue_2],
                    DATEDIFF(week, ISNULL(t7.U_Promise_date,t1.DueDate), GETDATE()) + 4 [Weeks Overdue_4],
                    ISNULL((CASE WHEN t8.DocDueDate is not null THEN DATEDIFF(week,t8.DocDueDate,ISNULL(t7.U_Promise_date,t1.DueDate))
                    ELSE DATEDIFF(week,GETDATE(),ISNULL(t7.U_Promise_date,t1.DueDate)) END),-100) [Date_Diff],
                    CAST(ISNULL(t7.U_Promise_date,t1.DueDate) AS DATE) [Due Date],
                    CAST(ISNULL(t4.U_FloorDate,t1.U_Floordate) AS DATE) [Floor Date],
                    CAST(isnull(t0.U_sc_date,DATEADD(d,+0,t7.U_Promise_date)) AS DATE) [Promise Date UNP],
                    (CASE WHEN CAST(t8.DocDueDate AS DATE) < CAST (GETDATE() AS DATE) THEN 'yes' ELSE 'no' END)[Purchase Overdue],
                    t7.U_BOY_38_EXT_REM [Comments_SO],
                    t9.Comments [Comments_PO], 
                            t0.U_sc_date [Sub_Con_Date], 
                            t0.U_sc_remarks [Sub_Con_Remarks], 
                            ---Changed today 21/10/22---
                            t7.U_In_Sub_Con[Sub_Con_Status]
                    FROM  wor1 t0
        
                    LEFT JOIN 
                    (select t0.ItemCode, 
                            MAX(t1.DocDueDate) [DocDueDate], 
                            MAX(t1.DocNum) [DocNum]
                            from por1 t0
        
                            INNER JOIN opor t1 ON t1.DocEntry = t0.DocEntry        
                            where t1.DocStatus = 'O'         
                            group by t0.ItemCode
                    ) t8 ON t8.ItemCode = t0.ItemCode
                
                    INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry
                    INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode
                    LEFT JOIN ordr t4 ON t4.docnum = t1.OriginNum
                    INNER join ohem t3 on t3.empID = t4.OwnerCode
                    INNER JOIN oitb t5 ON t5.ItmsGrpCod = t2.ItmsGrpCod
                    LEFT JOIN ocrd t6 ON t6.CardCode = t1.CardCode
                    left JOIN rdr1 t7 ON t7.DocEntry = t4.DocEntry AND t7.ItemCode = t1.ItemCode
                    left JOIN oslp t10 ON t10.SlpCode = t4.SlpCode
                    LEFT JOIN opor t9 ON t9.docnum = t8.DocNum
                    inner join ousr t12 on t12.USERID = t1.UserSign
                             left join [dbo].[@SUB_CON_STATUS] t13 on t13.Code = t0.U_sc_status
                    where 1=1 
                    AND t1.Status in ('P','R')
                    AND t2.ItemType <> 'L'
                    AND t2.PrcrmntMtd = 'B' 
                    AND (t5.ItmsGrpCod IN (168,232) or t2.ItemName like 'Sub Con%')
                    AND t1.CmpltQty < t0.PlannedQty
                    AND t4.DocStatus <> 'C'
                  
        
            UNION ALL
        
                    -----sales order buy items -----
            SELECT  
            t0.Dscription,
            t0.ActBaseNum[NUM],
            t0.ActBaseNum[NUM],
            DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE())[Monday TW Date],
            DATEADD(d, 1 - DATEPART(w, GETDATE())+8, GETDATE())[Monday LW Date],
            NULL [Process Order], 
            NULL [Prod Ord],
            t2.ItemCode,
            t2.ItemName,
            t13.firstName,
            t2.PrcrmntMtd,
            ISNULL(t1.U_Client,'000_NO PROJECT_000') [Project],
                    CAST(t0.Quantity AS DECIMAL(12,0)) [Planned Qty],
                    isnull(t0.DelivrdQty,0) [Issued Qty], 
                    t2.ONHand,
                    t2.IsCommited,
                    CAST(t2.ONorder AS DECIMAL(12,0)) [On Order], 
                    t1.CardName [Customer], 
                    t1.docnum [Sales Order],
                    t1.DocDueDate [Dispatch Date], 
                    t9.docnum [Latest Purchase Ord],
                    ISNULL(t9.cardname, 'NO SUPPLIER') [Supplier],
                    t10.SlpName [Engineer], 
                    CAST(t8.DocDueDate AS DATE) [Purchase Due], 
                    (CASE WHEN t0.OpenQty < (t2.ONhand - t2.IsCommited + t0.OpenQty) THEN 'IN STOCK' ELSE 'NOT IN STOCK' END) [Stock Check],
                    (case when t8.DocDueDate > t1.DocDueDate then 'PO DUE AFTER DISPATCH DATE' else '' end) [Shortage Warning],
                    (case when t8.DocDueDate < GETDATE() then 'PURCHASE OVERDUE' else '' end) [PO Warning],
                    (CASE
                        WHEN t5.ItmsGrpNam LIKE '%Sheet%' OR t5.ItmsGrpNam LIKE '%Bar%' OR t5.ItmsGrpNam LIKE '%Box%' OR t5.ItmsGrpNam LIKE '%Angle%' OR t5.ItmsGrpNam LIKE '%Pipe%' THEN 'SH'
                        WHEN t5.ItmsGrpNam = 'Sub CON - Purchases' THEN 'SC'
                        WHEN t5.ItmsGrpNam LIKE '%Mesh Grate%' THEN 'GR'
                       WHEN t5.ItmsGrpNam = 'Fixings' THEN 'FX'
                        WHEN t5.ItmsGrpNam = 'Fittings - Springs' OR t5.ItmsGrpNam = 'Fittings 304' OR t5.ItmsGrpNam = 'Fittings 316' OR t5.ItmsGrpNam = 'Fittings NON-SS' OR t5.ItmsGrpNam LIKE '%Gaskets%' THEN 'FT'
                        WHEN t8.DocDueDate is null THEN 'X'
                        ELSE 'N'
                    END) [Type],
                    DATEDIFF(week, t0.U_Promise_Date, GETDATE()) + 2 [Weeks Overdue_2],
                    DATEDIFF(week, t0.U_Promise_Date, GETDATE()) + 4 [Weeks Overdue_4],
                    ISNULL((CASE WHEN t8.DocDueDate is not null THEN DATEDIFF(week,t8.DocDueDate,t0.U_Promise_Date) ELSE DATEDIFF(week,GETDATE(),t0.U_Promise_Date) END),-100) [Date_Diff],
                    CAST(t0.U_Promise_Date AS DATE) [Due Date],
                      CAST(t1.U_FloorDate AS DATE) [Floor Date],
                                                                                CAST(t8.DocDueDate AS DATE) [Promise Date UNP],
                    (CASE WHEN CAST(t8.DocDueDate AS DATE) < CAST (GETDATE() AS DATE) THEN 'yes' ELSE 'no' END)[Purchase Overdue],
                    t0.U_BOY_38_EXT_REM [Comments_SO],
                    t9.Comments[Comments_PO] , 
                            NULL [Sub_Con_Date], 
                            NULL [Sub_Con_Remarks], 
                            NULL [Sub_Con_Status]
                    from rdr1 t0
        
                    LEFT JOIN 
                    (select t0.ItemCode, 
                            MAX(t1.DocDueDate) [DocDueDate], 
                            MAX(t1.DocNum) [DocNum]
                            from por1 t0
                
                            INNER JOIN opor t1 ON t1.DocEntry = t0.DocEntry
                            where t1.DocStatus = 'O'
                            group by t0.ItemCode
                    ) t8 ON t8.ItemCode = t0.ItemCode
                    
                    INNER JOIN ordr t1 ON t1.DocEntry = t0.DocEntry
                    INNER join ohem t13 on t13.empID = t1.OwnerCode
                    INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode
                    INNER JOIN oslp t10 ON t10.SlpCode = t1.SlpCode
                    LEFT JOIN opor t9 ON t9.docnum = t8.DocNum
                    INNER JOIN oitb t5 ON t5.ItmsGrpCod = t2.ItmsGrpCod
        
                    where
                    t0.LineStatus = 'o'
                    AND t1.DocStatus <> 'C'
                    AND t2.ItemCode <> 'TRANSPORT'
                    
                    AND t5.ItmsGrpNam not like '%Sheet%'
                    AND t5.ItmsGrpNam not like '%SITE%'
                            AND t5.ItmsGrpCod IN (168,232)


                                UNION ALL
        
                    -----stock order items -----
  SELECT  
            t2.ItemName,
            NULL[NUM],
            NULL[NUM],
            DATEADD(d, 1 - DATEPART(w, GETDATE())+1, GETDATE())[Monday TW Date],
            DATEADD(d, 1 - DATEPART(w, GETDATE())+8, GETDATE())[Monday LW Date],
            t1.U_IIS_proPrOrder [Process Order], 
            t1.docnum [Prod Ord],
            t2.ItemCode,
            t2.ItemName,
                                                t13.U_NAME [Sales Person],
            t2.PrcrmntMtd,
            '000_NO PROJECT_000' [Project],
                    CAST(t0.PlannedQty AS DECIMAL(12,0)) [Planned Qty],
                    isnull(t0.IssuedQty,0) [Issued Qty], 
                    t2.ONHand,
                    t2.IsCommited,
                    CAST(t2.ONorder AS DECIMAL(12,0)) [On Order], 
                    'Stock' [Customer], 
                    t1.docnum [Sales Order],
                    t1.DueDate [Dispatch Date], 
                    t9.docnum [Latest Purchase Ord],
                    ISNULL(t9.cardname, 'NO SUPPLIER') [Supplier],
                    '' [Engineer], 
                    CAST(t8.DocDueDate AS DATE) [Purchase Due], 
                    (CASE WHEN t0.PlannedQty - t0.IssuedQty < (t2.ONhand - t2.IsCommited + t0.PlannedQty - t0.IssuedQty) THEN 'IN STOCK' ELSE 'NOT IN STOCK' END) [Stock Check],
                    (case when t8.DocDueDate > t1.DueDate then 'PO DUE AFTER DISPATCH DATE' else '' end) [Shortage Warning],
                    (case when t8.DocDueDate < GETDATE() then 'PURCHASE OVERDUE' else '' end) [PO Warning],
                    (CASE
                        WHEN t5.ItmsGrpNam LIKE '%Sheet%' OR t5.ItmsGrpNam LIKE '%Bar%' OR t5.ItmsGrpNam LIKE '%Box%' OR t5.ItmsGrpNam LIKE '%Angle%' OR t5.ItmsGrpNam LIKE '%Pipe%' THEN 'SH'
                        WHEN t5.ItmsGrpNam = 'Sub CON - Purchases' THEN 'SC'
                        WHEN t5.ItmsGrpNam LIKE '%Mesh Grate%' THEN 'GR'
                       WHEN t5.ItmsGrpNam = 'Fixings' THEN 'FX'
                        WHEN t5.ItmsGrpNam = 'Fittings - Springs' OR t5.ItmsGrpNam = 'Fittings 304' OR t5.ItmsGrpNam = 'Fittings 316' OR t5.ItmsGrpNam = 'Fittings NON-SS' OR t5.ItmsGrpNam LIKE '%Gaskets%' THEN 'FT'
                        WHEN t8.DocDueDate is null THEN 'X'
                        ELSE 'N'
                    END) [Type],
                    DATEDIFF(week, t1.DueDate, GETDATE()) + 2 [Weeks Overdue_2],
                    DATEDIFF(week, t1.DueDate, GETDATE()) + 4 [Weeks Overdue_4],
                    ISNULL((CASE WHEN t8.DocDueDate is not null THEN DATEDIFF(week,t8.DocDueDate,t1.DueDate) ELSE DATEDIFF(week,GETDATE(),t1.DueDate) END),-100) [Date_Diff],
                   CAST(t1.DueDate AS DATE) [Due Date],
                    CAST(t1.U_FloorDate AS DATE) [Floor Date],
                                                                                CAST(isnull(t0.U_sc_date, DATEADD(d,0,t1.DueDate)) AS DATE) [Promise Date UNP],
        
                    (CASE WHEN CAST(t8.DocDueDate AS DATE) < CAST (GETDATE() AS DATE) THEN 'yes' ELSE 'no' END)[Purchase Overdue],
                    '' [Comments_SO],
                    t9.Comments[Comments_PO] , 
                    t0.U_sc_date[Sub_Con_date],
                    t0.U_sc_remarks[Sub_Con_Remarks] , 
                    t0.U_sc_status[Sub_Con_Status]
                    from wor1 t0
        
                    LEFT JOIN 
                    (select t0.ItemCode, 
                            MAX(t1.DocDueDate) [DocDueDate], 
                            MAX(t1.DocNum) [DocNum]
                            from por1 t0
                
                            INNER JOIN opor t1 ON t1.DocEntry = t0.DocEntry
                            where t1.DocStatus = 'O'
                            group by t0.ItemCode
                    ) t8 ON t8.ItemCode = t0.ItemCode
                    
                    INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry
                    INNER join ousr t13 on t13.USERID = t1.UserSign
                    INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode
                    LEFT JOIN opor t9 ON t9.docnum = t8.DocNum
                    INNER JOIN oitb t5 ON t5.ItmsGrpCod = t2.ItmsGrpCod
        
                    where
                                                                                1 = 1
                    AND t1.Status not in ('C','L')
                    AND t2.ItemCode <> 'TRANSPORT'
                            AND t5.ItmsGrpCod IN (168,232)
                                                                                                                and t1.OriginNum is null
                        ) t0
        
        LEFT JOIN ordr t1 ON t1.DocNum = t0.[Sales Order]
        LEFT JOIN owor t2 ON t2.DocNum = t0.[Prod Ord]
        INNER JOIN oitm t3 ON t3.ItemCode = t0.ItemCode
        LEFT JOIN opor t4 ON t4.DocNum = t0.[Latest Purchase Ord]
        ----added (29/09/22) get jobs with BOM issued --
        ----where t0.[Issued Qty]<t0.[Planned Qty]--
        left join (
                                                        select t0.ItemCode, 
                                                        MAX(t1.DocDate) [latest_po_date], MIN(t1.DocDueDate) [earliest_po_due_date]
                                                        
                                                        from por1 t0
                                                        inner join opor t1 on t1.DocEntry = t0.DocEntry
                                                        
                                                        where t1.DocStatus = 'O'
                                                        and t0.LineStatus = 'o'
                                                        and t1.DocType = 'I'
                                                        
                                                        group by t0.ItemCode)t5 on t5.ItemCode = t0.ItemCode
        
                                                        
        
       WHERE
        t0.[Promise Date UNP] between ([Monday LW Date]-24) and ([Monday TW Date]+28) AND t2.Cmpltqty < t2.PlannedQty  and t0.ItemCode not in('130236280' ,'130330100')
        ORDER BY  t0.[Project]



";
?>



