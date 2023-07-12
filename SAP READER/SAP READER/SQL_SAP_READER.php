<?php
if(isset($process_order)){
    $sql_process_order = 
    "SELECT
    /* PROCESS ORDER LEVEL (MOSTLY OVERALL HEADER STUFF)*/
    t20.Balance[Balance],
    t1_A.SONum [Sales Order],
    t1_A.PrOrder [Process Order],
    t1_A.EndProduct [End Product Code],
    t1_B.ItemName [End Product Name],
    CAST(t1_A.BatchSize AS DECIMAL(12,2))[Quantity],
    CAST(t1_B.OnHand AS DECIMAL(12,2))[On Hand],
    CAST(t1_F.Planned_Mat AS DECIMAL(12,2))[Planned Material],
    CAST(t1_F.Issued_Mat AS DECIMAL(12,2)) [Issued Material],
    CAST(t1_G.Planned_Lab AS DECIMAL(12,2))[Planned Labour],
    CAST(t1_H.Actual_Lab AS DECIMAL(12,2)) [Actual Labour],
    t1_E.SlpName[Engineer],
    t1_D.firstName + ' ' + t1_D.lastName [Sales Person],
    t1_C.CardName[Customer],
    '| | | | | |'[DIV1],
    
    /* SUBBOM ITEM AND PRODUCTION ORDER SUBLEVEL (LEFT JOIN ONLY ITEM TYPE B FROM IIS..ORDERL*/
    t2_A.StepItem [Item Code],
    t2_A.StepDesc [Item Description],
    t2_A.ParentLine [Parent Line],
    t2_B.DocNum [Production Order],
    '| | | | | |'[DIV2],
    
    /* COMPONENT SUBSUBLEVELS */
    t3_A.IssueType [Step Type],
    '| | | | | |'[DIV3],
    
    /* MATERIAL */
    CASE WHEN t3_A.IssueType = 'M' THEN t3_A.ItemCode ELSE NULL END[Material Code],
    CASE WHEN t3_A.IssueType = 'M' THEN t3_A.ItemName ELSE NULL END[Material Name],
    CASE WHEN t3_A.IssueType = 'M' THEN CAST(t3_A.PlannedQty AS DECIMAL (12,2)) ELSE NULL END[Planned Material Qty],
    CASE WHEN t3_A.IssueType = 'M' THEN CAST(t3_A.PlannedQty * t3_B.AvgPrice AS DECIMAL (12,2))  ELSE NULL END[Planned Material Cost],
    CASE WHEN t3_A.IssueType = 'M' THEN CAST(t3_A.IssuedQty AS DECIMAL (12,2))  ELSE NULL END[Issued Material Qty],
    CASE WHEN t3_A.IssueType = 'M' THEN CAST(t3_A.IssuedQty * t3_B.AvgPrice AS DECIMAL (12,2))  ELSE NULL END[Issued Material Cost],
    '| | | | | |'[DIV4],
        
    /* LABOUR */
    CASE WHEN t3_A.IssueType = 'B' THEN t4_A.LineID ELSE NULL END[Labour Step Number],
    CASE WHEN t3_A.IssueType = 'B' THEN t4_A.StepItem ELSE NULL END[Labour Code],
    CASE WHEN t3_A.IssueType = 'B' THEN t4_A.StepDesc ELSE NULL END[Labour Description],
    CASE WHEN t3_A.IssueType = 'B' THEN t4_A.ProcessTime ELSE NULL END[Planned Labour Step],
    CASE WHEN t3_A.IssueType = 'B' THEN t4_B.Labour ELSE NULL END[Booked Labour Step],
    CASE WHEN t3_A.IssueType = 'B' THEN t4_A.Status ELSE NULL END[Labour Step Status],
    '| | | | | |'[DIV5],
    
    /* LABOUR ENTREIS */
    CASE WHEN t3_A.IssueType = 'B' THEN t5_C.[No Of Entries] ELSE NULL END[No Of Step Entries],
    CASE WHEN t3_A.IssueType = 'B' THEN t5_A.Labour ELSE NULL END[Booked Labour Entry],
    CASE WHEN t3_A.IssueType = 'B' THEN ISNULL((t5B.firstName + ' ' + t5B.Lastname),'NO ENTRIES') ELSE NULL END[Fabricator]
    
    /*	JOINS	t1_X = PROCESS ORDER LEVEL, 
                t2_X = FINAL ITEMS ON PROCESS ORDER (SUB BOM FINAL ITEM WITH LINKED PROD ORDER), 
                t3_X GENERAL JOIN OF PRODUCTION TO PROCESS, 
                t4_X MATERIAL SPECIFIC JOINS (PER STEP ON WOR1 BASIS), 
                t5_X LABOUR SPECIFIC JOINS (PER STEP ON IIS_EPC_PRO_ORDERL BASIS)
    */
    FROM IIS_EPC_PRO_ORDERH t1_A
    LEFT JOIN OITM t1_B ON t1_B.ItemCode = t1_A.EndProduct
    LEFT JOIN ORDR t1_C ON t1_C.DocNum = t1_A.SONum
    LEFT JOIN OHEM t1_D ON t1_D.EmpID = t1_C.OwnerCode
    LEFT JOIN OSLP t1_E ON t1_E.SlpCode = t1_C.SlpCode
    
    LEFT JOIN IIS_EPC_PRO_ORDERL t2_A ON t2_A.PrOrder = t1_A.PrOrder AND t2_A.StepType = 'B'
    LEFT JOIN OWOR t2_B ON t2_B.U_IIS_proPrOrder = t1_A.PrOrder and t2_B.ItemCode = t2_A.StepItem
    
    LEFT JOIN WOR1 t3_A ON t3_A.DocEntry = t2_B.DocEntry
    LEFT JOIN OITM t3_B ON t3_B.ItemCode = t3_A.ItemCode
    
    LEFT JOIN IIS_EPC_PRO_ORDERL t4_A ON t4_A.PrOrder = t1_A.PrOrder AND t4_A.ParentLine = t2_A.LineID AND t4_A.StepType <> 'B' AND t3_A.IssueType = 'B' AND t4_A.StepItem = t3_A.ItemCode AND t4_A.LineID = t3_A.U_IIS_proPrLineID
    LEFT JOIN(SELECT t0.PrOrder, t0.LabourCode, t0.LineID, SUM(t0.Quantity)[Labour] FROM IIS_EPC_PRO_ORDERT t0 GROUP BY t0.PrOrder, t0.LabourCode, t0.LineID) t4_B ON t4_B.PrOrder = t1_A.PrOrder AND t4_B.LabourCode = t3_A.ItemCode AND t4_B.LineID = t4_A.LineID
    
    LEFT JOIN(SELECT t0.PrOrder, t0.LabourCode, t0.LineID, t0.UserID, t0.Quantity[Labour] FROM IIS_EPC_PRO_ORDERT t0) t5_A ON t5_A.PrOrder = t1_A.PrOrder AND t5_A.LabourCode = t3_A.ItemCode AND t5_A.LineID = t4_A.LineID
    LEFT JOIN OHEM t5B ON t5B.EmpID = t5_A.UserID
    LEFT JOIN(SELECT t0.PrOrder, t0.LabourCode, t0.LineID, COUNT(t0.RecId)[No Of Entries] FROM IIS_EPC_PRO_ORDERT t0 GROUP BY t0.PrOrder, t0.LabourCode, t0.LineID) t5_C ON t5_C.PrOrder = t1_A.PrOrder AND t5_C.LabourCode = t3_A.ItemCode AND t5_C.LineID = t4_A.LineID
    
    LEFT JOIN (SELECT t1.U_IIS_proPrOrder,
        SUM(t0.plannedqty * t2.avgprice) [Planned_Mat],   			
        SUM(t0.IssuedQty* t2.avgprice) [Issued_Mat]  			
            FROM wor1 t0
                INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry  			
                INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode
                    WHERE  t2.itemtype <> 'L' 			
                        GROUP BY t1.U_IIS_proPrOrder)
    t1_F on t1_F.U_IIS_proPrOrder = t1_A.PrOrder
    LEFT JOIN (select t1.U_IIS_proPrOrder, 
        SUM(t0.plannedqty) [Planned_Lab]
            FROM wor1 t0
                INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry  				
                INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode
                inner join iis_epc_pro_orderh t3 on t3.PrOrder = t0.U_IIS_proPrOrder 				
                    WHERE t2.ItemType = 'L' 				
                        GROUP BY t1.U_IIS_proPrOrder) 
    t1_G ON t1_G.U_IIS_proPrOrder = t1_A.PrOrder
    LEFT JOIN (SELECT t0.PrOrder, 
        SUM(t0.Quantity) [Actual_Lab]
            FROM iis_epc_pro_ordert t0  				
                GROUP BY t0.PrOrder) 
    t1_H ON t1_H.PrOrder = t1_A.Prorder
    left join (
        select distinct t0.itemcode, 
        sum(t0.inqty - t0.outqty) [Balance]
        from oinm t0
        group by t0.itemcode
        ) t20 on t20.ItemCode = t3_a.ItemCode
    WHERE t1_A.PrOrder = /*41521*/ /*38139*/ /*38611*/ $process_order
    
    ORDER BY t2_A.ParentLine DESC, t2_B.DocNum DESC, t3_A.IssueType DESC, t4_A.LineID ASC
    ";
}

if(isset($sales_order)){
    $sql_sales_order_header = 
        "SELECT
        t0.DocEntry,
        t0.DocNum [Sales Order],
        CASE
            WHEN t0.CANCELED  = 'Y'	THEN 'Cancelled'
            WHEN t0.DocStatus = 'C' THEN 'Closed'
            WHEN t0.DocStatus = 'O' THEN 'Open'
        END [Sales Order Status],
        FORMAT(t0.DocDate, 'dd-MM-yyyy')[Create Date],
        t0.DocCur [Currency],
        t0.DocRate,
    
        t0.CardName [Customer Name],
        t0.CardCode [Customer Code],
        t0.Address2 [Delivery Address],
    
        CAST(t2.[Est Eng Time] AS DECIMAL (12,2))[Est Eng Time],
        CAST(t2.[Act Eng Time] AS DECIMAL (12,2))[Act Eng Time],
        CAST(t2.[Est Prod Total] AS DECIMAL (12,2))[Est Prod Total],
        
        t0.DocTotalFC [Total In FC],
        t0.DocTotal [Total],
    
        t0.VatSumFC[Vat In FC],
        t0.VatSum[Vat]
    
        FROM ORDR t0
        LEFT JOIN
            (SELECT
                DocEntry,
                SUM(LineTotal)[Sales Value],
                SUM(ISNULL(DelivrdQty,0)*(LineTotal/Quantity))[Delivered Value],
                SUM(ISNULL(U_Est_Prod_Hrs,0))[Est Prod Total],
                SUM(ISNULL(U_Est_Eng_Hours,0))[Est Eng Time],
                SUM(ISNULL(U_Act_Eng_Time,0))[Act Eng Time]
                    FROM RDR1
                        WHERE ItemCode <> 'TRANSPORT' GROUP BY DocEntry
                )t2 ON t2.DocEntry = t0.DocEntry
                
                WHERE t0.DocNum = $sales_order
    ";

    $sql_sales_order_content = "SELECT
	t0.LineNum[Line Number],
	t0.ItemCode[Item Code],
	t0.Dscription[Item Name],
	t0.Quantity[Quantity],
	t0.Price[Price],
	t0.Currency[Currency],
	t0.TotalFrgn[Total In FC],
	t0.LineTotal[Total],
	t3.U_IIS_proPrOrder[Process Order],
	t0.U_In_Sub_Con[U_In_Sub_Con],
    t0.U_Est_Eng_Hours[Est Eng Time],
	t0.U_Act_Eng_Time[Act Eng Time],
	t0.U_Est_Prod_Hrs[Est Production Time],
    t0.DelivrdQty [Delivered Qty],
    
	t1.OnHand [On Hand],
	FORMAT(t0.U_Promise_Date,'dd-MM-yyyy')[Promise Date],
    t0.DelivrdQty,
    t0.OrderedQty,
          t0.LineStatus
		FROM RDR1 t0
        LEFT JOIN OITM t1 ON t1.ItemCode = t0.ItemCode
        LEFT JOIN ORDR t2 ON t2.DocEntry = t0.DocEntry
        LEFT JOIN OWOR t3 ON t3.OriginNum = t2.DocNum AND t3.ItemCode = t0.ItemCode
        WHERE t2.DocNum = $sales_order
    ";

    $sql_sales_order_attachments = "SELECT 
        t0.DocNum[Sales Order], 
        CASE WHEN t3.AbsEntry IS NOT NULL THEN 'Y' ELSE 'N' END[Has Attachment],
        t3.AbsEntry[Atc Entry],
        ISNULL(t3.[Attachments Count],0)[Attachments Count]
        from ORDR t0 
        LEFT JOIN (SELECT t0.AbsEntry, COUNT(t0.FileName)[Attachments Count] FROM ATC1 t0 GROUP BY t0.AbsEntry)t3 ON t3.AbsEntry = t0.AtcEntry
        WHERE t0.DocNum LIKE '$sales_order'";
}

if(isset($item_code)){
    // SUMS AND GROUPS ON HAND FOR ALL WAREHOUESES AND LISTS IF THERE ARE ANY QTY ON ORDER AND WHEN THE NEXT DEL DATE IS DUE
    $sql_item_code_header = 
    "SELECT 
        distinct T0.ItemCode[Item Code],
        t1.ItemName[Item Name],
        t5.ItmsGrpNam[Item Group],
        t0.Balance [On Hand],
        t1.IsCommited[Committed],
        t1.AvgPrice [Standard Price],
        CAST((t0.Balance * t1.AvgPrice) AS DECIMAL (12,2)) [Value], 
        t1.PrcrmntMtd,
        t6.[On Order],
        FORMAT(t6.[Next Del Date],'dd-MM-yyyy')[Next Del Date]
        
        from(
        select distinct t0.itemcode, 
        sum(t0.inqty - t0.outqty) [Balance]
        from oinm t0
        group by t0.itemcode
        ) t0
        
        inner join oitm t1 on t1.ItemCode = t0.ItemCode
        LEFT join oitb t5 on t5.ItmsGrpCod = t1.ItmsGrpCod
        LEFT JOIN(SELECT t1.ItemCode, SUM(t1.OpenQty)[On Order], MAX(t0.DocDueDate)[Next Del Date]
            FROM POR1 t1 
            LEFT JOIN OPOR t0 ON t0.DocEntry = t1.DocEntry
                WHERE t0.DocStatus <> 'C' AND t0.CANCELED <> 'Y'
                GROUP BY t1.ItemCode
        )t6 ON t6.ItemCode = t0.ItemCode
        
        where t0.ItemCode = '$item_code'
        order by t0.ItemCode
    ";
          /* SELECT 
          COALESCE(T0.ItemCode, T1.ItemCode) AS [Item Code],
           T1.ItemName AS [Item Name],
           T5.ItmsGrpNam AS [Item Group],
           T0.Balance AS [On Hand],
           T1.IsCommited AS [Committed],
           T1.AvgPrice AS [Standard Price],
           CAST((T0.Balance * T1.AvgPrice) AS DECIMAL (12, 2)) AS [Value], 
           T1.PrcrmntMtd,
           T6.[On Order],
           FORMAT(T6.[Next Del Date], 'dd-MM-yyyy') AS [Next Del Date]
       FROM oitm T1
       LEFT JOIN (
           SELECT 
               DISTINCT t0.itemcode, 
               SUM(t0.inqty - t0.outqty) AS [Balance]
           FROM oinm t0
           GROUP BY t0.itemcode
       ) T0 ON T1.ItemCode = T0.ItemCode
       LEFT JOIN oitb T5 ON T5.ItmsGrpCod = T1.ItmsGrpCod
       LEFT JOIN (
           SELECT 
               T1.ItemCode, 
               SUM(T1.OpenQty) AS [On Order], 
               MAX(T0.DocDueDate) AS [Next Del Date]
           FROM POR1 T1 
           LEFT JOIN OPOR T0 ON T0.DocEntry = T1.DocEntry
           WHERE T0.DocStatus <> 'C' AND T0.CANCELED <> 'Y'
           GROUP BY T1.ItemCode
       ) T6 ON T6.ItemCode = T1.ItemCode
       WHERE T1.ItemCode = '130466420'
       ORDER BY T0.ItemCode; */
       
    $sql_item_code_content = 
    "SELECT 
	DISTINCT T0.ItemCode [Item Code],
	t1.ItemName [Item Name],
    FORMAT(t1.CreateDate, 'dd-MM-yyyy')[Create Date],
    t0.Balance [On Hand],
    t1.IsCommited [Comitted],
	t5.ItmsGrpNam [Item Group Name],
	t0.Warehouse [Warehouse],
	
	t1.AvgPrice [Standard Price],
	(t0.Balance * t1.AvgPrice) [Value], 
	t1.PrcrmntMtd [Prc]
	FROM(
		SELECT DISTINCT t0.itemcode, t0.Warehouse, 
			SUM(t0.inqty - t0.outqty) [Balance]
				FROM oinm t0
					GROUP BY t0.itemcode, t0.Warehouse
	) t0
    inner join oitm t1 ON t1.ItemCode = t0.ItemCode
	LEFt join oitb t5 ON t5.ItmsGrpCod = t1.ItmsGrpCod
		WHERE t0.ItemCode = '$item_code'
				ORDER BY t0.Warehouse,T0.ItemCode";
                /* SELECT 
                DISTINCT T0.ItemCode AS [Item Code],
                T1.ItemName AS [Item Name],
                CONVERT(NVARCHAR(10), T1.CreateDate, 103) AS [Create Date],
                T0.Balance AS [On Hand],
                T1.IsCommited AS [Committed],
                T5.ItmsGrpNam AS [Item Group Name],
                T0.Warehouse AS [Warehouse],
                T1.AvgPrice AS [Standard Price],
                (T0.Balance * T1.AvgPrice) AS [Value], 
                T1.PrcrmntMtd AS [Prc]
            FROM oitm T1
            LEFT JOIN (
                SELECT 
                    DISTINCT t0.itemcode, 
                    t0.Warehouse, 
                    SUM(t0.inqty - t0.outqty) AS [Balance]
                FROM oinm t0
                GROUP BY t0.itemcode, t0.Warehouse
            ) T0 ON T1.ItemCode = T0.ItemCode
            LEFT JOIN oitb T5 ON T5.ItmsGrpCod = T1.ItmsGrpCod
            WHERE T1.ItemCode = '130466420'
            ORDER BY t0.Warehouse,T0.ItemCode
 */
    // ORIGINAL QUERY YOU SENT ME WHERE THERE IS A LINE FOR EACH WAREHOSUE            
    $sql_item_code_content_2 = 
    "SELECT 
        t0.DocNum,
        t0.CardName,
        CAST(t0.DocDate AS DATE)[Create Date],
        t2.firstName + ' ' + t2.lastName,
        t1.Currency,
        t1.Price
        FROM ORDR t0
            LEFT JOIN RDR1 t1 ON t1.DocEntry = t0.DocEntry
            LEFT JOIN OHEM t2 ON t2.empID = t0.OwnerCode
                WHERE t1.ItemCode = '$item_code'
    ";

    $sql_item_code_attachments = 
    "SELECT 
	t0.ItemCode, 
	CASE WHEN t3.AbsEntry IS NOT NULL THEN 'Y' ELSE 'N' END[Has Attachment],
	t3.AbsEntry,
	ISNULL(t3.[Attachments Count],0)[Attachments Count]
	from OITM t0 
	LEFT JOIN (SELECT t0.AbsEntry, COUNT(t0.FileName)[Attachments Count] FROM ATC1 t0 GROUP BY t0.AbsEntry)t3 ON t3.AbsEntry = t0.AtcEntry
    WHERE t0.ItemCode = '$item_code'";
}

if(isset($customer)){
    // SUMS AND GROUPS ON HAND FOR ALL WAREHOUESES AND LISTS IF THERE ARE ANY QTY ON ORDER AND WHEN THE NEXT DEL DATE IS DUE
    $sql_customer_header = 
    "SELECT 
    t0.CardCode,
    t0.CardName,
    t0.Address,
    Phone1, 
    CntctPrsn,
    COUNT(t1.DocNum)[Sales Orders],
    SUM(t1.DocTotal)-SUM(t1.VatSum)[Total Sales]
        FROM OCRD t0
        LEFT JOIN ORDR t1 ON t1.CardCode = t0.CardCode
            WHERE t0.CardName LIKE '$customer'
                GROUP BY t0.CardCode, t0.CardName, t0.Address, Phone1, CntctPrsn
                ORDER BY CardName
    ";
    // ORIGINAL QUERY YOU SENT ME WHERE THERE IS A LINE FOR EACH WAREHOSUE            
    $sql_customer_content = 
    "SELECT 
        CASE WHEN t0.DocStatus = 'O' THEN 'Open' ELSE 'Closed' END[Status],
	    t0.DocNum[Sales Order],
	    t0.U_Client[Project],
        t0.CardName[Customer],
        t2.firstName + ' ' + t2.lastName[Sales Person],
	    t0.DocTotal-t0.VatSum[Sales Value],
        t1.Dscription[Item Name],
        t3.slpName[Engineer],
        t4.[Promise Date]
        
	        FROM ORDR t0
	        LEFT JOIN RDR1 t1 ON t1.DocEntry = t0.DocEntry
            LEFT JOIN OHEM t2 ON t2.EmpID = t0.OwnerCode
            LEFT JOIN OSLP t3 ON t3.SlpCode = t1.SlpCode
            LEFT JOIN (SELECT DocEntry, FORMAT(MIN(U_Promise_Date), 'dd-MM-yyyy')[Promise Date] FROM RDR1 WHERE LineStatus = 'O'  AND ItemCode <> 'TRANSPORT' AND U_Promise_Date IS NOT NULL GROUP BY DocEntry)t4 ON t4.DocEntry = t0.DocEntry
		        WHERE t0.CardName LIKE '$customer' AND t0.CANCELED <> 'Y' AND t0.DocDate > '$start_date' AND t0.DocDate < '$end_date'
		            ORDER BY t0.DocNum DESC"; 
}

if(isset($item_group)){
    // SUMS AND GROUPS ON HAND FOR ALL WAREHOUESES AND LISTS IF THERE ARE ANY QTY ON ORDER AND WHEN THE NEXT DEL DATE IS DUE
    $sql_item_group_header = 
    "SELECT 
        ItmsGrpCod,
        ItmsGrpNam
        FROM OITB
            WHERE ItmsGrpNam LIKE '$item_group'
    ";
    // ORIGINAL QUERY YOU SENT ME WHERE THERE IS A LINE FOR EACH WAREHOSUE            
    $sql_item_group_content = 
    "SELECT
        t0.ItmsGrpCod,
        t0.ItmsGrpCod,
        t0.ItmsGrpNam,
        t0.ItemCode,
        t0.ItemName,
        t0.OnHand,
        t0.IsCommited,
        t0.OnOrder,
        STRING_AGG(CONCAT(t0.WAREHOUSE , ': ', t0.[WAREHOUSE QTY]),'<br>')[WAREHOUSE & QTY]
        FROM(
                SELECT
                    t0.ItmsGrpCod,
                    t0.ItmsGrpNam,
                    t1.ItemCode,
                    t1.ItemName,
                    CAST(t1.OnHand AS DECIMAL(12,1))[OnHand],
                    CAST(t1.IsCommited AS DECIMAL(12,1))[IsCommited],
                    CAST(t1.OnOrder AS DECIMAL(12,1))[OnOrder],
                    t2.Warehouse[WAREHOUSE],
                    CONVERT(NVARCHAR,CAST(t2.[SUM] AS DECIMAL (12,3)))[WAREHOUSE QTY]
                        FROM OITB t0
                            LEFT JOIN OITM t1 ON t1.ItmsGrpCod = t0.ItmsGrpCod
                            LEFT JOIN (SELECT DISTINCT t0.ItemCode, t0.Warehouse, SUM(t0.inqty - t0.outqty)[SUM] FROM OINM t0 GROUP BY t0.ItemCode, t0.Warehouse) t2 ON t2.ItemCode = t1.ItemCode
        )t0
            WHERE t0.ItmsGrpNam LIKE '$item_group'
            GROUP BY t0.ItmsGrpCod, t0.ItmsGrpCod, t0.ItmsGrpNam, t0.ItemCode, t0.ItemName, t0.OnHand, t0.IsCommited, t0.OnOrder
            ORDER BY t0.ItemName
    "; 
}

if(isset($purchase_order)){
    $sql_purchase_order_header = 
    "SELECT 
        DocNum[Purchase Order],
        DocStatus[Status],
        CardCode[Supplier Code],
        CardName[Supplier Name],
        Address[Supplier Address],
        DocCur[Currency],
        DocTotalFC[Foreign Currency Total],
        DocRate[Rate],
        DocTotal[Total],
        VatSum[Vat],
        VatSumFC[Vat In FC],
        PaidToDate[Total Paid],
        PaidFC[Total Paid In FC]
        
        FROM OPOR WHERE DocNum LIKE $purchase_order
    ";

    $sql_purchase_order_data = 
    "SELECT 
        t1.LineNum[Line Number],
        CASE WHEN t1.LineStatus = 'O' THEN 'Open' ELSE 'Closed' END[Line Status],
        t1.ItemCode[Item Code],
        t1.Dscription[Item Name],
        t1.Quantity[Quantity],
        t1.Currency[Currency],
        t1.Price[Price],
        Linetotal[Total],
        t1.TotalFrgn [Foreign Currency Total]
            FROM OPOR t0
	        LEFT JOIN POR1 t1 ON t1.DocEntry = t0.DocEntry
	            WHERE t0.DocNum LIKE $purchase_order
    ";
}
?>