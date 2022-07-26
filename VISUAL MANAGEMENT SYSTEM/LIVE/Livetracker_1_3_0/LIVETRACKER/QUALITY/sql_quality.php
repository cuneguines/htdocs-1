-<?php
$pre_production_table_query =
"SELECT 
    CASE
        WHEN (case when t4.[Name] is null then t1.U_PP_Status else t4.[Name] end) = 'Pre Production Confirmed' THEN 'C'
        WHEN (case when t4.[Name] is null then t1.U_PP_Status else t4.[Name] end) = 'Pre Production Potential' THEN 'P'
        WHEN (case when t4.[Name] is null then t1.U_PP_Status else t4.[Name] end) = 'Pre Production Forecast'  THEN 'F'
        ELSE 'N'
    END [Status],
    t0.docnum [Sales Order],
    t0.cardname [Customer], 
    ISNULL(t0.U_Client,'NO PROJECT') [Project],
    t1.Dscription [Description],
    CAST(t1.quantity AS DECIMAL (12,1)) [Quantity],
    (case when t5.U_stages is null then t1.U_PP_Stage else t5.U_stages end)  [Stage],
    ISNULL(CAST(t1.U_Est_Eng_Hours AS DECIMAL(12,0)) - ISNULL(CAST(t1.U_ACT_ENG_TIME AS DECIMAL(12,0)),0), 0) [Est Eng Hrs],
    ISNULL(CAST(t1.U_Est_Prod_Hrs AS DECIMAL(12,0)), 0) [Est Prod Hrs],
    FORMAT(t1.U_Promise_Date,'dd-MM-yyyy')[Promise Date], 
    t2.SlpName [Engineer],
    (CASE 
        WHEN DATEPART(iso_week,t1.U_Promise_Date)+((DATEPART(year, t1.U_Promise_Date)-DATEPART(year, GETDATE()))*52) = 53 THEN 52 
        ELSE DATEPART(iso_week,t1.U_Promise_Date)+((DATEPART(year, t1.U_Promise_Date)-DATEPART(year, GETDATE()))*52) 
    END) [Promise Week Due],
    t3.firstname + ' ' + t3.lastName [Sales Person],
    t1.U_BOY_38_EXT_REM [Comments]
    FROM ordr t0
        INNER JOIN rdr1 t1 on t1.DocEntry = t0.DocEntry
        INNER JOIN oslp t2 on t2.SlpCode = ISNULL(t1.SlpCode, t0.SlpCode)
        INNER JOIN ohem t3 on t3.empID = t0.OwnerCode
        left join [dbo].[@PRE_PROD_STATUS] as t4 on t4.code = t1.U_PP_Status
        left join [dbo].[@PRE_PRODUCTION] as t5 on t5.code = t1.U_PP_Stage
            WHERE t1.LineStatus = 'O'
            AND t1.ItemCode <> 'TRANSPORT' 
            AND t0.CANCELED <> 'Y' 
            AND (case when t4.[Name] is null then t1.U_PP_Status else t4.[Name] end) is not null 
            AND (case when t4.[Name] is null then t1.U_PP_Status else t4.[Name] end) <> 'LIVE'
                ORDER BY [Stage]";
?>


[
 {
  "sales order": 1232,
  "Process order": 6,
  "U_Product_Group_One": "Access Covers",
  "t1.U_Product_Group_Two": "NULL",
  "t1.U_Product_Group_Three": "NULL",
  "Issues": "Drawings"
 },
 {
  "sales order": 1233,
  "Process order": 7,
  "U_Product_Group_One": "Access Covers",
  "t1.U_Product_Group_Two": "Access Boxes",
  "t1.U_Product_Group_Three": "NULL",
  "Issues": "Fixings"
 },
 {
  "sales order": 1234,
  "Process order": 8,
  "U_Product_Group_One": "Consumables",
  "t1.U_Product_Group_Two": "Access Boxes",
  "t1.U_Product_Group_Three": "No Group",
  "Issues": "Drawings"
 },
 {
  "sales order": 1235,
  "Process order": 9,
  "U_Product_Group_One": "Consumables",
  "t1.U_Product_Group_Two": "Access Cover",
  "t1.U_Product_Group_Three": "NULL",
  "Issues": "Fixings"
 },
 {
  "sales order": 1236,
  "Process order": 10,
  "U_Product_Group_One": "Furniture",
  "t1.U_Product_Group_Two": "bollard",
  "t1.U_Product_Group_Three": "NULL",
  "Issues": "width"
 },
 {
  "sales order": 1237,
  "Process order": 12,
  "U_Product_Group_One": "Furniture",
  "t1.U_Product_Group_Two": "Bollards",
  "t1.U_Product_Group_Three": "coffin",
  "Issues": "sheet width"
 },
 {
  "sales order": 1238,
  "Process order": 13,
  "U_Product_Group_One": "Furniture",
  "t1.U_Product_Group_Two": "Bollards",
  "t1.U_Product_Group_Three": "Fixed",
  "Issues": "measurement"
 },
 {
  "sales order": 1239,
  "Process order": 14,
  "U_Product_Group_One": "Drianage",
  "t1.U_Product_Group_Two": "Gullies",
  "t1.U_Product_Group_Three": "NULL",
  "Issues": "measurement"
 },
 {
  "sales order": 1240,
  "Process order": 15,
  "U_Product_Group_One": "Drianage",
  "t1.U_Product_Group_Two": "Gullies",
  "t1.U_Product_Group_Three": "Commercial",
  "Issues": "Drawings"
 },
 {
  "sales order": 1241,
  "Process order": 16,
  "U_Product_Group_One": "Drianage",
  "t1.U_Product_Group_Two": "Gullies",
  "t1.U_Product_Group_Three": "Heavy Duty",
  "Issues": "Fixings"
 }
]