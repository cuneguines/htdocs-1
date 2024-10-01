<?php
$pre_production_exceptions_old =
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
            WHEN (case when t4.U_stages is null then t1.U_PP_Stage else t4.U_stages end) LIKE '9. Submitted to Planning' THEN 
           (CASE 
                
                
                WHEN t1.U_Est_Prod_Hrs < 20  THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + 100 + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)  
                ELSE DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_NA_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52) 
            END)
        ELSE 0 
    END) [Weeks Overdue], 
    (case when t4.U_stages is null then t1.U_PP_Stage else t4.U_stages end) [Stage],
    t1.U_BOY_38_EXT_REM [Comments],

    CAST(t9.Planned_Lab AS DECIMAL(10,1)) AS Planned_Hrs,
	t_4.U_IIS_proPrOrder

    FROM ordr t0

    INNER JOIN rdr1 t1 ON t1.DocEntry = t0.DocEntry
    INNER JOIN oslp t2 ON t2.SlpCode = ISNULL(t1.SlpCode, t0.SlpCode)
    INNER JOIN ohem t3 ON t3.empID = t0.OwnerCode
    left join [dbo].[@PRE_PRODUCTION] as t4 on t4.code = t1.U_PP_Stage
    left join [dbo].[@PRE_PROD_STATUS] as t5 on t5.code = t1.U_PP_Status
	 LEFT join owor t_4 on t_4.OriginNum = t0.DocNum AND t_4.ItemCode = t1.ItemCode and t_4.Status <> 'C'
    
    LEFT JOIN IIS_EPC_PRO_ORDERH t99 ON t99.PrOrder = t_4.U_IIS_proPrOrder
     left JOIN 
    (
        SELECT 
            t1.U_IIS_proPrOrder, 
            SUM(t0.plannedqty) AS [Planned_Lab]                                                  
        FROM 
            wor1 t0                                                     
        INNER JOIN 
            owor t1 ON t1.DocEntry = t0.DocEntry                                                                 
        INNER JOIN 
            oitm t2 ON t2.ItemCode = t0.ItemCode                                                                
        WHERE 
            t2.ItemType = 'L'                                                                 
        GROUP BY 
            t1.U_IIS_proPrOrder
    ) t9 ON t9.U_IIS_proPrOrder = t_4.U_IIS_proPrOrder
    WHERE t1.LineStatus = 'O'
    AND t1.ItemCode <> 'TRANSPORT'
    AND t0.CANCELED <> 'Y'
    AND (case when t5.[Name] is null then t1.U_PP_Status else t5.[Name] end) IS NOT NULL
    AND (case when t5.[Name] is null then t1.U_PP_Status else t5.[Name] end) != 'Live'
    
    ORDER BY [Weeks Overdue] DESC";






$pre_production_exceptions_oold="select
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

FROM(SELECT 
    (case when t5.[Name] is null then t1.U_PP_Status else t5.[Name] end) [Status],
    t0.docnum [Sales Order],
		t_4.U_IIS_proPrOrder,
		t44.[Sub Con Items],
    ISNULL(t0.U_Client,t0.CardName) [Project], 
    t0.cardname[Customer],
	t18.StepDesc,
	t_1.StepDesc[desc],
    t1.Dscription [Description],
    CAST(t1.quantity AS DECIMAL (12,1)) [Quantity],
    ISNULL(CAST(t1.U_Est_Eng_Hours AS DECIMAL(12,0)) - ISNULL(CAST(t1.U_ACT_ENG_TIME AS DECIMAL(12,0)),0), 0) [Est Eng Hrs],
    ISNULL(CAST(t1.U_Est_Prod_Hrs AS DECIMAL(12,0)), 0) [Est Prod Hrs],
    'REDUNDANT' [Action Week],
    t2.SlpName [Engineer],
    CONVERT(date,t1.U_Promise_Date) [Promise Date],
    DATEPART(iso_week,t1.U_Promise_Date)+((DATEPART(year, t1.U_Promise_Date)-DATEPART(year, GETDATE()))*52) [Promise Week Due],
    t3.firstname + ' ' + t3.lastName [Sales Person],

   
    (case when t4.U_stages is null then t1.U_PP_Stage else t4.U_stages end) [Stage],
    t1.U_BOY_38_EXT_REM [Comments],

    CAST(t9.Planned_Lab AS DECIMAL(10,1)) AS Planned_Hrs,

	CAST(t15.[TOTAL PLANNED HOURS] AS DECIMAL (12,0))[Planned Hours (Process Order)],        
	(Select sum(CAST(t20.ProcessTime AS DECIMAL(12,2))) from IIS_EPC_PRO_ORDERL t20 where t20.PrOrder = t_1.PrOrder AND t20.LineID >= t_1.LineID)[REMAINING],



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
            WHEN (case when t4.U_stages is null then t1.U_PP_Stage else t4.U_stages end) LIKE '9. Submitted to Planning' THEN 
           (CASE 
                WHEN t1.U_Est_Prod_Hrs >= 750 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_S_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52) 
                WHEN t1.U_Est_Prod_Hrs < 750 AND t1.U_Est_Prod_Hrs >= 250 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_A_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52) 
                WHEN t1.U_Est_Prod_Hrs < 250 AND t1.U_Est_Prod_Hrs >= 100 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_B_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)  
                WHEN t1.U_Est_Prod_Hrs < 100 AND t1.U_Est_Prod_Hrs >= 40 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_C_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)  
                WHEN t1.U_Est_Prod_Hrs < 40 AND t1.U_Est_Prod_Hrs >= 20 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_D_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)   
                WHEN t1.U_Est_Prod_Hrs < 20  THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_E_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)  
                ELSE DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_NA_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52) 
            END)
        ELSE 0 
    END) [Weeks Overdue]

    FROM ordr t0

    INNER JOIN rdr1 t1 ON t1.DocEntry = t0.DocEntry
    INNER JOIN oslp t2 ON t2.SlpCode = ISNULL(t1.SlpCode, t0.SlpCode)
    INNER JOIN ohem t3 ON t3.empID = t0.OwnerCode
    left join [dbo].[@PRE_PRODUCTION] as t4 on t4.code = t1.U_PP_Stage
    left join [dbo].[@PRE_PROD_STATUS] as t5 on t5.code = t1.U_PP_Status
	 LEFT join owor t_4 on t_4.OriginNum = t0.DocNum AND t_4.ItemCode = t1.ItemCode and t_4.Status <> 'C'
     
    LEFT JOIN IIS_EPC_PRO_ORDERH t99 ON t99.PrOrder = t_4.U_IIS_proPrOrder
	INNER JOIN IIS_EPC_PRO_ORDERL t_1 ON t_1.PrOrder = t99.PrOrder 
	
	left join (select t0.U_IIS_proPrOrder, count(t1.itemcode) [Sub Con Items]

from owor t0
inner join wor1 t1 on t1.DocEntry = t0.DocEntry
inner join oitm t2 on t2.ItemCode = t1.ItemCode
inner join oitb t3 on t3.ItmsGrpCod = t2.ItmsGrpCod

where t2.ItemName like 'SUBCONTRACT'
and t0.Status not in ('L','C')


group by t0.U_IIS_proPrOrder)t44 on t44.U_IIS_proPrOrder =t_4.U_IIS_proPrOrder
	

     left JOIN 
    (
        SELECT 
            t1.U_IIS_proPrOrder, 
            SUM(t0.plannedqty) AS [Planned_Lab]                                                  
        FROM 
            wor1 t0                                                     
        INNER JOIN 
            owor t1 ON t1.DocEntry = t0.DocEntry                                                                 
        INNER JOIN 
            oitm t2 ON t2.ItemCode = t0.ItemCode                                                                
        WHERE 
            t2.ItemType = 'L'                                                                 
        GROUP BY 
            t1.U_IIS_proPrOrder
    ) t9 ON t9.U_IIS_proPrOrder =  t_4.U_IIS_proPrOrder


	LEFT JOIN(
               SELECT t0.PrOrder, SUM(t0.ProcessTime) [TOTAL PLANNED HOURS] 
                    FROM IIS_EPC_PRO_ORDERL t0
                        GROUP BY t0.PrOrder
            )t15 ON t15.PrOrder = t_4.U_IIS_proPrOrder


			LEFT JOIN(
                SELECT t0.PrOrder, t0.LineID, t0.ParentLine, t0.StepItem, t0.StepDesc FROM IIS_EPC_Pro_ORDERL t0
            )t18 ON t18.PrOrder = t_4.U_IIS_proPrOrder AND t18.LineID = t_1.ParentLine
    WHERE t1.LineStatus = 'O'
    AND t1.ItemCode <> 'TRANSPORT'
    AND t0.CANCELED <> 'Y'
    AND (case when t5.[Name] is null then t1.U_PP_Status else t5.[Name] end) IS NOT NULL
    AND (case when t5.[Name] is null then t1.U_PP_Status else t5.[Name] end) != 'Live'
	)t0
	)t0

    
   ---where t0.U_IIS_proPrOrder=57008";



   $pre_production_exceptions="SELECT 
t50.[Est LS Start Date],
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
    
    (case when t4.U_stages is null then t1.U_PP_Stage else t4.U_stages end) [Stage],
    t1.U_BOY_38_EXT_REM [Comments],

    CAST(t9.Planned_Lab AS DECIMAL(10,1)) AS Planned_Hrs,
	t_4.U_IIS_proPrOrder,

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
            WHEN (case when t4.U_stages is null then t1.U_PP_Stage else t4.U_stages end) LIKE '9. Submitted to Planning' THEN 
           (CASE 
                WHEN t1.U_Est_Prod_Hrs >= 750 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_S_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52) 
                WHEN t1.U_Est_Prod_Hrs < 750 AND t1.U_Est_Prod_Hrs >= 250 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_A_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52) 
                WHEN t1.U_Est_Prod_Hrs < 250 AND t1.U_Est_Prod_Hrs >= 100 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_B_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)  
                WHEN t1.U_Est_Prod_Hrs < 100 AND t1.U_Est_Prod_Hrs >= 40 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_C_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)  
                WHEN t1.U_Est_Prod_Hrs < 40 AND t1.U_Est_Prod_Hrs >= 20 THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_D_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)   
                WHEN t1.U_Est_Prod_Hrs < 20  THEN DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_E_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52)  
                ELSE DATEPART(iso_week, GETDATE()) - DATEPART(iso_week,t1.U_Promise_Date) + $drawings_approved_NA_limit + ((DATEPART(year, GETDATE())-DATEPART(year, t1.U_Promise_Date))*52) 
            END)
        ELSE 0 
    END) [Weeks Overdue]



    FROM ordr t0

    INNER JOIN rdr1 t1 ON t1.DocEntry = t0.DocEntry
    INNER JOIN oslp t2 ON t2.SlpCode = ISNULL(t1.SlpCode, t0.SlpCode)
    INNER JOIN ohem t3 ON t3.empID = t0.OwnerCode
    left join [dbo].[@PRE_PRODUCTION] as t4 on t4.code = t1.U_PP_Stage
    left join [dbo].[@PRE_PROD_STATUS] as t5 on t5.code = t1.U_PP_Status
	 LEFT join owor t_4 on t_4.OriginNum = t0.DocNum AND t_4.ItemCode = t1.ItemCode and t_4.Status <> 'C'
    
    LEFT JOIN IIS_EPC_PRO_ORDERH t99 ON t99.PrOrder = t_4.U_IIS_proPrOrder
     left JOIN 
    (
        SELECT 
            t1.U_IIS_proPrOrder, 
            SUM(t0.plannedqty) AS [Planned_Lab]                                                  
        FROM 
            wor1 t0                                                     
        INNER JOIN 
            owor t1 ON t1.DocEntry = t0.DocEntry                                                                 
        INNER JOIN 
            oitm t2 ON t2.ItemCode = t0.ItemCode                                                                
        WHERE 
            t2.ItemType = 'L'                                                                 
        GROUP BY 
            t1.U_IIS_proPrOrder
    ) t9 ON t9.U_IIS_proPrOrder = t_4.U_IIS_proPrOrder

	LEFT JOIN (
    SELECT * 
	FROM (
        SELECT 
            CASE 
                WHEN DATEPART(dw, DATEADD(DAY, -(t0.[WORKDAYS] + FLOOR(t0.[WORKDAYS]/7)*2), t0.[Promise Date])) IN (1, 7) 
                    THEN CONVERT(varchar, DATEADD(DAY, -2, DATEADD(DAY, -(t0.[WORKDAYS] + FLOOR(t0.[WORKDAYS]/7)*2), t0.[Promise Date])), 10)
                    ELSE CONVERT(varchar, DATEADD(DAY, -(t0.[WORKDAYS] + FLOOR(t0.[WORKDAYS]/7)*2), t0.[Promise Date]), 10)
            END [Est LS Start Date],
            CASE 
                WHEN DATEPART(dw, DATEADD(DAY, -(t0.[WORKDAYS] + FLOOR(t0.[WORKDAYS]/7)*2), t0.[Promise Date])) IN (1, 7) 
                    THEN DATEADD(DAY, -2, DATEADD(DAY, -(t0.[WORKDAYS] + FLOOR(t0.[WORKDAYS]/7)*2), t0.[Promise Date]))
                    ELSE DATEADD(DAY, -(t0.[WORKDAYS] + FLOOR(t0.[WORKDAYS]/7)*2), t0.[Promise Date])
            END [Est LS Start Date1],
            DATEDIFF(WEEK, GETDATE(), CASE 
                WHEN DATEPART(dw, DATEADD(DAY, -(t0.[WORKDAYS] + FLOOR(t0.[WORKDAYS]/7)*2), t0.[Promise Date])) IN (1, 7) 
                    THEN DATEADD(DAY, -2, DATEADD(DAY, -(t0.[WORKDAYS] + FLOOR(t0.[WORKDAYS]/7)*2), t0.[Promise Date]))
                    ELSE DATEADD(DAY, -(t0.[WORKDAYS] + FLOOR(t0.[WORKDAYS]/7)*2), t0.[Promise Date])
            END) [Est LS Start Date DIFFWEEK],
            DATEPART(ISO_WEEK, CASE 
                WHEN DATEPART(dw, DATEADD(DAY, -(t0.[WORKDAYS] + FLOOR(t0.[WORKDAYS]/7)*2), t0.[Promise Date])) IN (1, 7) 
                    THEN DATEADD(DAY, -2, DATEADD(DAY, -(t0.[WORKDAYS] + FLOOR(t0.[WORKDAYS]/7)*2), t0.[Promise Date]))
                    ELSE DATEADD(DAY, -(t0.[WORKDAYS] + FLOOR(t0.[WORKDAYS]/7)*2), t0.[Promise Date])
            END) [Est LS Start Date WEEKNO],
            CASE 
                WHEN DATEPART(dw, DATEADD(DAY, -(t0.[WORKDAYS] + FLOOR(t0.[WORKDAYS]/7)*2), t0.[Promise Date])) IN (1, 7) 
                    THEN t0.[WORKDAYS] + FLOOR(t0.[WORKDAYS]/7)*2 + 2
                    ELSE t0.[WORKDAYS] + FLOOR(t0.[WORKDAYS]/7)*2
            END [DAYS],
            t0.*, 
            ROW_NUMBER() OVER (PARTITION BY t0.[Process Order] ORDER BY 
            CASE 
                WHEN DATEPART(dw, DATEADD(DAY, -(t0.[WORKDAYS] + FLOOR(t0.[WORKDAYS]/7)*2), t0.[Promise Date])) IN (1, 7) 
                    THEN DATEADD(DAY, -2, DATEADD(DAY, -(t0.[WORKDAYS] + FLOOR(t0.[WORKDAYS]/7)*2), t0.[Promise Date]))
                    ELSE DATEADD(DAY, -(t0.[WORKDAYS] + FLOOR(t0.[WORKDAYS]/7)*2), t0.[Promise Date])
            END) AS rn -- Rank based on the earliest date per Process Order
        FROM (
            SELECT 
                (t0.[REMAINING]/(8*0.63)) / ((0.2/90)*t0.[REMAINING] + 0.5 + 2) [PRECALCULATED WORKDAYS],
                FLOOR(0.22 * (t0.[Planned Hours (Process Order)]/(8*0.63) / ((0.2/90)*t0.[Planned Hours (Process Order)] + 0.5)) + 7) [SUBCON ADJUSTMENT],
                (t0.[REMAINING]/(8*0.63)) / ((0.2/90)*t0.[REMAINING] + 0.5) + 2 + 
                    CASE 
                        WHEN t0.[Sub Con Items] IS NOT NULL 
                        THEN FLOOR(0.22 * (t0.[Planned Hours (Process Order)]/(8*0.63) / ((0.2/90)*t0.[Planned Hours (Process Order)] + 0.5)) + 14 * t0.[Sub Con Items]) 
                        ELSE 0 
                    END [WORKDAYS],
					*
					FROM(SELECT
                CONVERT(date,t1.U_Promise_Date) [Promise Date],
                t4.[U_IIS_proPrOrder] [Process Order],
                (SELECT SUM(CAST(t20.ProcessTime AS DECIMAL(12,2))) 
                    FROM IIS_EPC_PRO_ORDERL t20 
                    WHERE t20.PrOrder = t11.PrOrder AND t20.LineID >= t11.LineID) [REMAINING],
                t44.[Sub Con Items],
                CAST(t15.[TOTAL PLANNED HOURS] AS DECIMAL(12,0)) [Planned Hours (Process Order)]
            FROM ordr t0 
            INNER JOIN rdr1 t1 ON t1.DocEntry = t0.DocEntry
            LEFT JOIN owor t4 ON t4.OriginNum = t0.DocNum AND t4.ItemCode = t1.ItemCode AND t4.Status <> 'C'
            LEFT JOIN IIS_EPC_PRO_ORDERH t99 ON t99.PrOrder = t4.U_IIS_proPrOrder
            INNER JOIN IIS_EPC_PRO_ORDERL t11 ON t11.PrOrder = t99.PrOrder
            LEFT JOIN (
                SELECT t0.U_IIS_proPrOrder, COUNT(t1.ItemCode) [Sub Con Items]
                FROM owor t0
                INNER JOIN wor1 t1 ON t1.DocEntry = t0.DocEntry
                INNER JOIN oitm t2 ON t2.ItemCode = t1.ItemCode
                INNER JOIN oitb t3 ON t3.ItmsGrpCod = t2.ItmsGrpCod
                WHERE t2.ItemName LIKE 'SUBCONTRACT' AND t0.Status NOT IN ('L', 'C')
                GROUP BY t0.U_IIS_proPrOrder
            ) t44 ON t44.U_IIS_proPrOrder = t4.U_IIS_proPrOrder
            LEFT JOIN (
                SELECT t0.PrOrder, SUM(t0.ProcessTime) [TOTAL PLANNED HOURS]
                FROM IIS_EPC_PRO_ORDERL t0
                GROUP BY t0.PrOrder
            ) t15 ON t15.PrOrder = t4.U_IIS_proPrOrder
        ) t0
		)t0
    ) t50
    WHERE rn = 1 
     -- Select only the earliest date for each Process Order
) t50 ON t50.[Process Order] = t_4.U_IIS_proPrOrder -- Assuming the main table has Process Order field




    WHERE t1.LineStatus = 'O' 
    AND t1.ItemCode <> 'TRANSPORT' 
    AND t0.CANCELED <> 'Y'
    AND (case when t5.[Name] is null then t1.U_PP_Status else t5.[Name] end) IS NOT NULL
    AND (case when t5.[Name] is null then t1.U_PP_Status else t5.[Name] end) != 'Live'
    ORDER BY [Weeks Overdue] DESC";
  
?>