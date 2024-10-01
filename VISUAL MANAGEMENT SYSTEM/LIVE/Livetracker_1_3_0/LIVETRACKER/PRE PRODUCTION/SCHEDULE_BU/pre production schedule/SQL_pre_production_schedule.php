<?php
$pre_production_schedule =
"SELECT 
    t0.cardname [Customer], 
    t0.docnum [Sales Order],
    ISNULL(t0.U_Client, t0.cardname) [Project],
    t1.Dscription [Description],
    t1.U_BOY_38_EXT_REM [Comments],
    CAST(t1.quantity AS DECIMAL (12,1)) [Quantity],
    CONVERT(date,t1.U_Promise_Date) [Promise Date],
    (CASE 
            WHEN ISNULL(DATEPART(iso_week,t1.U_Promise_Date),52) = 53 THEN 52 
            ELSE ISNULL(DATEPART(iso_week,t1.U_Promise_Date),52) 
    END) [Promise Week Due],
    CASE 
        WHEN ISNULL(DATEDIFF(WEEK,GETDATE(),t1.U_Promise_Date),".($start_range-1).") < ".$start_range." THEN ".($start_range -1)."
        WHEN ISNULL(DATEDIFF(WEEK,GETDATE(),t1.U_Promise_Date),".($start_range-1).") > ".$end_range." AND ISNULL(DATEDIFF(WEEK,GETDATE(),t1.U_Promise_Date),".($start_range-1).") < ".($end_range + 13)." THEN ".($end_range +1)."
        WHEN ISNULL(DATEDIFF(WEEK,GETDATE(),t1.U_Promise_Date),".($start_range-1).") >= ".($end_range+13)." AND ISNULL(DATEDIFF(WEEK,GETDATE(),t1.U_Promise_Date),".($start_range-1).") < ".($end_range + 26)." THEN ".($end_range +2)."
        WHEN ISNULL(DATEDIFF(WEEK,GETDATE(),t1.U_Promise_Date),".($start_range-1).") >= ".($end_range+26)." THEN ".($end_range +3)."
        ELSE ISNULL(DATEDIFF(WEEK,GETDATE(),t1.U_Promise_Date),".($start_range-1).")
    END [Promise Diff Week],    
    ISNULL(CAST(t1.U_Est_Eng_Hours AS DECIMAL(12,0)) - ISNULL(CAST(t1.U_ACT_ENG_TIME AS DECIMAL(12,0)),0), 0) [Est Remaining Eng Hrs], 
    ISNULL(CAST(t1.U_Est_Prod_Hrs AS DECIMAL(12,0)),0) [Est Prod Hrs],
    t2.SlpName [Engineer],
    (case when t4.U_stages is null then t1.U_PP_Stage else t4.U_stages end) [Stage],
    (case when t5.[Name] is null then t1.U_PP_Status else t5.[Name] end) [Status],
    t3.firstname + ' ' + t3.lastName [Sales Person],
    t1.U_Est_Eng_hours [Est Eng Hrs],
    t0.U_Dimension1
    FROM ordr t0

    INNER JOIN rdr1 t1 ON t1.DocEntry = t0.DocEntry
    INNER JOIN oslp t2 ON t2.SlpCode = ISNULL(t1.SlpCode, t0.SlpCode)
    INNER JOIN ohem t3 ON t3.empID = t0.OwnerCode
    left join [dbo].[@PRE_PRODUCTION] as t4 on t4.code = t1.U_PP_Stage
    left join [dbo].[@PRE_PROD_STATUS] as t5 on t5.code = t1.U_PP_Status

    WHERE t1.LineStatus = 'O'
    AND t1.ItemCode <> 'TRANSPORT' 
    AND t0.CANCELED <> 'Y' 
    AND  (case when t5.[Name] is null then t1.U_PP_Status else t5.[Name] end)  != 'Live'
    
    ORDER BY [Project]";
?>