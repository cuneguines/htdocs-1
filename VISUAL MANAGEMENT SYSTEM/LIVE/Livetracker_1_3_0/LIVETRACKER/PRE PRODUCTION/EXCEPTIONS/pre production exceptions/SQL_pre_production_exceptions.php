<?php
$pre_production_exceptions =
"SELECT 
    (case when t5.[Name] is null then t1.U_PP_Status else t5.[Name] end) [Status],
    t0.docnum [Sales Order],
    ISNULL(t0.U_Client,t0.CardName) [Project], 
    t0.cardname[Customer],
    t1.Dscription [Description],
    CAST(t1.quantity AS DECIMAL (12,1)) [Quantity],
    ISNULL(CAST(t1.U_Est_Eng_Hours AS DECIMAL(12,0)) - ISNULL(CAST(t1.U_ACT_ENG_TIME AS DECIMAL(12,0)),0), 0) [Est Eng Hrs],
    ISNULL(CAST(t1.U_Est_Prod_Hrs AS DECIMAL(12,0)), 0) [Est Prod Hrs],
    'REDUNDANT' [Action Week],
    t2.SlpName [Engineer],
    CONVERT(date,t1.U_Promise_Date) [Promise Date],
    DATEPART(iso_week,t1.U_Promise_Date)+((DATEPART(year, t1.U_Promise_Date)-DATEPART(year, GETDATE()))*52) [Promise Week Due],
    t3.firstname + ' ' + t3.lastName [Sales Person],
    (CASE
        WHEN (case when t4.U_stages is null then t1.U_PP_Stage else t4.U_stages end) LIKE '1. Drawings Approved (Fab Drawings)' THEN 
            (CASE 
                WHEN t1.U_Est_Prod_Hrs >= 750 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_S_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52) 
                WHEN t1.U_Est_Prod_Hrs < 750 AND t1.U_Est_Prod_Hrs >= 250 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_A_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52) 
                WHEN t1.U_Est_Prod_Hrs < 250 AND t1.U_Est_Prod_Hrs >= 100 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_B_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)  
                WHEN t1.U_Est_Prod_Hrs < 100 AND t1.U_Est_Prod_Hrs >= 40 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_C_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)  
                WHEN t1.U_Est_Prod_Hrs < 40 AND t1.U_Est_Prod_Hrs >= 20 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_D_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)   
                WHEN t1.U_Est_Prod_Hrs < 20  THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_E_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)  
                ELSE DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_NA_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52) 
            END)
        WHEN (case when t4.U_stages is null then t1.U_PP_Stage else t4.U_stages end) LIKE '2. Awaiting Customer Approval' THEN 
            (CASE 
                WHEN t1.U_Est_Prod_Hrs >= 750 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $awaiting_customer_approval_S_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52) 
                WHEN t1.U_Est_Prod_Hrs < 750 AND t1.U_Est_Prod_Hrs >= 250 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $awaiting_customer_approval_A_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 250 AND t1.U_Est_Prod_Hrs >= 100 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $awaiting_customer_approval_B_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 100 AND t1.U_Est_Prod_Hrs >= 40 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $awaiting_customer_approval_C_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 40 AND t1.U_Est_Prod_Hrs >= 20 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $awaiting_customer_approval_D_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 20  THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $awaiting_customer_approval_E_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                ELSE DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $awaiting_customer_approval_NA_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52) 
            END)    
        WHEN (case when t4.U_stages is null then t1.U_PP_Stage else t4.U_stages end) LIKE '3. Revised Drawing Required' THEN 
            (CASE 
                WHEN t1.U_Est_Prod_Hrs >= 750 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $revised_drawing_required_S_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52) 
                WHEN t1.U_Est_Prod_Hrs < 750 AND t1.U_Est_Prod_Hrs >= 250 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $revised_drawing_required_A_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 250 AND t1.U_Est_Prod_Hrs >= 100 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $revised_drawing_required_B_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 100 AND t1.U_Est_Prod_Hrs >= 40 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $revised_drawing_required_C_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 40 AND t1.U_Est_Prod_Hrs >= 20 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $revised_drawing_required_D_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 20  THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $revised_drawing_required_E_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                ELSE DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $revised_drawing_required_NA_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52) 
            END) 
        WHEN (case when t4.U_stages is null then t1.U_PP_Stage else t4.U_stages end) LIKE '4. Awaiting Sample Approval' THEN
            (CASE 
                WHEN t1.U_Est_Prod_Hrs >= 750 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $awaiting_sample_approval_S_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52) 
                WHEN t1.U_Est_Prod_Hrs < 750 AND t1.U_Est_Prod_Hrs >= 250 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $awaiting_sample_approval_A_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 250 AND t1.U_Est_Prod_Hrs >= 100 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $awaiting_sample_approval_B_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 100 AND t1.U_Est_Prod_Hrs >= 40 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $awaiting_sample_approval_C_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 40 AND t1.U_Est_Prod_Hrs >= 20 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $awaiting_sample_approval_D_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 20  THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $awaiting_sample_approval_E_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                ELSE DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $awaiting_sample_approval_NA_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52) 
            END)  
        WHEN (case when t4.U_stages is null then t1.U_PP_Stage else t4.U_stages end) LIKE '5. Engineer Drawing (Approval Drawings)' OR (case when t4.U_stages is null then t1.U_PP_Stage else t4.U_stages end) LIKE '5. Engineer Drawing ( Approval Drawings)' THEN 
            (CASE
                WHEN t1.U_Est_Prod_Hrs >= 750 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $engineer_drawing_S_limit-((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 250 AND t1.U_Est_Prod_Hrs >= 250 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $engineer_drawing_A_limit-((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 250 AND t1.U_Est_Prod_Hrs >= 100 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $engineer_drawing_B_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 100 AND t1.U_Est_Prod_Hrs >= 40 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $engineer_drawing_C_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 40 AND t1.U_Est_Prod_Hrs >= 20 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $engineer_drawing_D_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 20  THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $engineer_drawing_E_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                ELSE DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $engineer_drawing_NA_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52) 
            END)   
        WHEN (case when t4.U_stages is null then t1.U_PP_Stage else t4.U_stages end) LIKE '6. Awaiting Further Instruction' OR (case when t4.U_stages is null then t1.U_PP_Stage else t4.U_stages end) LIKE '6. Awaiting Further Instructions' THEN
            (CASE
                WHEN t1.U_Est_Prod_Hrs >= 750 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $awaiting_further_instruction_S_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 750 AND t1.U_Est_prod_Hrs >= 250 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $awaiting_further_instruction_A_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 250 AND t1.U_Est_Prod_Hrs >= 100 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $awaiting_further_instruction_B_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 100 AND t1.U_Est_Prod_Hrs >= 40 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $awaiting_further_instruction_C_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 40 AND t1.U_Est_Prod_Hrs >= 20 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $awaiting_further_instruction_D_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 20  THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $awaiting_further_instruction_E_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                ELSE DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $awaiting_further_instruction_NA_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52) 
            END) 
        WHEN (case when t4.U_stages is null then t1.U_PP_Stage else t4.U_stages end) LIKE '8. Design Concept' THEN 
            (CASE 
                WHEN t1.U_Est_Prod_Hrs >= 750 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $concept_S_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 750 AND t1.U_Est_Prod_Hrs >= 250 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $concept_A_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 250 AND t1.U_Est_Prod_Hrs >= 100 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $concept_B_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 100 AND t1.U_Est_Prod_Hrs >= 40 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $concept_C_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 40 AND t1.U_Est_Prod_Hrs >= 20 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $concept_D_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                WHEN t1.U_Est_Prod_Hrs < 20  THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $concept_E_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)
                ELSE DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $concept_NA_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52) 
            END) 
        ELSE 0 
    END) [Weeks Overdue], 
    (case when t4.U_stages is null then t1.U_PP_Stage else t4.U_stages end) [Stage],
    t1.U_BOY_38_EXT_REM [Comments]
    FROM ordr t0

    INNER JOIN rdr1 t1 ON t1.DocEntry = t0.DocEntry
    INNER JOIN oslp t2 ON t2.SlpCode = ISNULL(t1.SlpCode, t0.SlpCode)
    INNER JOIN ohem t3 ON t3.empID = t0.OwnerCode
    left join [dbo].[@PRE_PRODUCTION] as t4 on t4.code = t1.U_PP_Stage
    left join [dbo].[@PRE_PROD_STATUS] as t5 on t5.code = t1.U_PP_Status

    
    WHERE t1.LineStatus = 'O'
    AND t1.ItemCode <> 'TRANSPORT'
    AND t0.CANCELED <> 'Y'
    AND (case when t5.[Name] is null then t1.U_PP_Status else t5.[Name] end) IS NOT NULL
    AND (case when t5.[Name] is null then t1.U_PP_Status else t5.[Name] end) != 'Live'
    
    ORDER BY [Weeks Overdue] DESC";
?>