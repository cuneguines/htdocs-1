<?php
$tsql =
"SELECT
    /* SALES ORDER RELATED CONTENT */
    t0.docnum [Sales Order],
    t0.cardname [Customer],
    ISNULL(t0.U_Client, '000_NO PROJECT_000') [Project],
    t3.firstname + ' ' + t3.lastName [Sales Person],
    DATEDIFF(DAY,t0.CreateDate, GETDATE()) [Days Open],
    DATEPART(ISO_WEEK, t0.CreateDate) [Week Opened],
    DATEDIFF(WEEK,t0.CreateDate, GETDATE()) [Weeks Open],
    DATEDIFF(m,GETDATE(),t1.U_Promise_Date) [Month Difference],

    /* SALES ORDER ITEMS RELATED CONTENT */
    t1.Dscription,
    (CASE WHEN (t6.ItmsGrpNam LIKE 'LABOUR SITE' OR t6.ItmsGrpNam LIKE 'TRAINING' OR t6.ItmsGrpNam LIKE 'Documents & Manuals' OR t6.ItmsGrpNam LIKE 'Contract Phased Sale') THEN 'yes' ELSE 'no' END) [Non Deliverable],
    CAST(t1.quantity AS DECIMAL (12,1)) [Quantity],
    CAST(t5.OnHand AS DECIMAL (12,1)) [On Hand],
    FORMAT(CONVERT(DATE,t1.U_Promise_Date),'dd-MM-yyyy') [Promise Date],
    (CASE 
        WHEN DATEPART(ISO_WEEK,t1.U_Promise_Date) = 53 THEN 52 
        WHEN DATEPART(ISO_WEEK,t1.U_Promise_Date) IS NULL THEN 52
        ELSE DATEPART(ISO_WEEK,t1.U_Promise_Date) 
    END) [Promise Week Due],
    CASE 
        WHEN ISNULL(DATEDIFF(WEEK,GETDATE(),t1.U_Promise_Date),".($start_range-1).") < ".$start_range." THEN ".($start_range -1)."
        WHEN ISNULL(DATEDIFF(WEEK,GETDATE(),t1.U_Promise_Date),".($start_range-1).") > ".$end_range." AND ISNULL(DATEDIFF(WEEK,GETDATE(),t1.U_Promise_Date),".($start_range-1).") < ".($end_range + 13)." THEN ".($end_range +1)."
        WHEN ISNULL(DATEDIFF(WEEK,GETDATE(),t1.U_Promise_Date),".($start_range-1).") >= ".($end_range+13)." AND ISNULL(DATEDIFF(WEEK,GETDATE(),t1.U_Promise_Date),".($start_range-1).") < ".($end_range + 26)." THEN ".($end_range +2)."
        WHEN ISNULL(DATEDIFF(WEEK,GETDATE(),t1.U_Promise_Date),".($start_range-1).") >= ".($end_range+26)." THEN ".($end_range +3)."
        ELSE ISNULL(DATEDIFF(WEEK,GETDATE(),t1.U_Promise_Date),".($start_range-1).")
    END [Promise Diff Week],
    ISNULL(t2.SlpName,'NO NAME') [Engineer],
    t1.U_risk_rating [risk],
    (case when t14.[Name] is null then t1.U_PP_Status else t14.[Name] end) [Status],
    (case when t13.U_stages is null then t1.U_PP_Stage else t13.U_stages end) [Stage],
    t1.U_Paused [Paused],
    t1.U_BOY_38_EXT_REM[Comments],

    /* PROCESS ORDER AND PRODUCTION RELATED CONTENT */
    t11.U_IIS_proPrOrder [Process Order],
    ISNULL(CAST(t11.Planned_Lab AS DECIMAL(12,0)),0)[Planned Hrs],
    FORMAT(ISNULL(t4.U_FLOORDATE,t0.U_FLOORDATE), 'yyyy-MM-dd')[Floor Date],
    DATEDIFF(WEEK, ISNULL(t4.U_FLOORDATE,t0.U_FLOORDATE), GETDATE()) [Weeks On Floor],
    t1.U_In_Sub_Con [Sub Contract Status],
    CAST(t4.PlannedQty - t4.CmpltQty AS DECIMAL(12,0)) [Complete],
    CAST((CASE
        WHEN t1.U_In_Sub_Con = 'Yes' THEN 0
        WHEN CAST(t4.PlannedQty - t4.CmpltQty AS DECIMAL(12,0)) <= 0 THEN 0
        WHEN(case when t14.[Name] is null then t1.U_PP_Status else t14.[Name] end) <> 'Live' AND ((case when t14.[Name] is null then t1.U_PP_Status else t14.[Name] end) = 'Pre Production Confirmed' OR (case when t14.[Name] is null then t1.U_PP_Status else t14.[Name] end) = 'Pre Production Potential' OR (case when t14.[Name] is null then t1.U_PP_Status else t14.[Name] end) = 'Pre Production Forecast' OR t0.U_PP_STATUS = 'Pre Production Confirmed' OR (case when t14.[Name] is null then t1.U_PP_Status else t14.[Name] end) = 'Pre Production Potential' OR (case when t14.[Name] is null then t1.U_PP_Status else t14.[Name] end) = 'Pre Production Forecast') THEN ISNULL(t1.U_Est_Prod_hrs,0)
        ELSE 
            (CASE
                WHEN t4.CmpltQty < t4.PlannedQty THEN CASE WHEN ISNULL(ISNULL(t11.[Planned_Lab],0)-ISNULL(t10.[Actual_Lab],0),t11.[Planned_Lab]) < 0 THEN 0 ELSE ISNULL(ISNULL(t11.[Planned_Lab],0)-ISNULL(t10.[Actual_Lab],0),t11.[Planned_Lab]) END
                ELSE 0 
            END)
    END) AS DECIMAL (12,0)) [Est Prod Hrs]
    FROM ordr t0

    INNER JOIN rdr1 t1 on t1.DocEntry = t0.DocEntry
    inner join oslp t2 on t2.SlpCode = ISNULL(t1.SlpCode,t0.SlpCode)
    inner join ohem t3 on t3.empID = t0.OwnerCode
    left join  owor t4 on t4.OriginNum = t0.DocNum AND t4.ItemCode = t1.ItemCode
    INNER JOIN oitm t5 on t5.ItemCode = t1.ItemCode
    INNER JOIN oitb t6 on t6.ItmsGrpCod = t5.ItmsGrpCod

    LEFT JOIN 
    (SELECT t0.PrOrder, 
            SUM(t0.Quantity) [Actual_Lab]
        FROM iis_epc_pro_ordert t0
            GROUP BY t0.PrOrder
    ) t10 ON t10.PrOrder = t4.U_IIS_proProrder
    LEFT JOIN 
    (SELECT t1.U_IIS_proPrOrder, 
            SUM(t0.plannedqty) [Planned_Lab]
            FROM wor1 t0
                INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry                                                      
                INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode                                   
                WHERE t2.ItemType = 'L'                                                         
                GROUP BY t1.U_IIS_proPrOrder
    ) t11 ON t11.U_IIS_proPrOrder = t4.U_IIS_proPrOrder
    left join [dbo].[@PRE_PRODUCTION] as t13 on t13.code     = t1.U_PP_Stage
    left join [dbo].[@PRE_PROD_STATUS] as t14 on t14.code    = t1.U_PP_Status

    WHERE 
    t1.LineStatus = 'O' 
    AND t1.ItemCode <> 'TRANSPORT' 
    AND t0.CANCELED <> 'Y'
    AND ((T1.U_risk_rating = 'R3' OR  T1.U_risk_rating = 'R2') OR  t0.CreateDate > DATEADD(day, -14, GETDATE()))

    ORDER BY [Project]
";
?>

