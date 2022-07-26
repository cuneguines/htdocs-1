<?php
$sales_exceptions =
"SELECT t0.DocNum [Sales Order],
        t0.CardName [Customer],
        (CASE WHEN t0.U_Del_add_complete = 'Y' THEN 'Y' ELSE 'N' END) [Delivery Address Complete],
        (CASE WHEN t0.U_Del_add_complete = 'Y' THEN t0.Address2 ELSE '' END) [Delivery Address],
        (CASE WHEN t0.U_Transport_Charge = 'Y' THEN 'Y' ELSE 'N' END) [Transport Charge Complete],
        (CASE WHEN t0.U_Transport_Charge = 'Yes' THEN CAST(t3.LineTotal AS DECIMAL(12,0)) ELSE NULL END)[Transport Charge],  
        (CASE 
            WHEN t4.qrygroup26 = 'N' THEN 'OK' 
            ELSE 
                (CASE WHEN t4.Balance + t7.[Order Value] <= 0 THEN 'OK' ELSE 'ON HOLD' END) 
            END)[Account Status],
        (CASE WHEN t0.U_Cleared_to_invoice = 'Yes' THEN 'Yes' ELSE 'No' END)[Cleared to Invoice], 
        CAST(t5.U_Promise_Date AS DATE)[Promise Date], 
        t1.firstname + ' ' + t1.lastName [Sales Person],   
        t2.SlpName [Engineer],
        DATEDIFF(week,t5.U_Promise_Date,GETDATE())+2 [Weeks Overdue_2],
        DATEDIFF(week,t5.U_Promise_Date,GETDATE())+4 [Weeks Overdue_4],
        (CASE WHEN t0.U_Del_add_complete <> 'Y' THEN 1 ELSE 0 END) + (CASE WHEN t0.U_Transport_Charge is null or t0.U_Transport_Charge = 'No' THEN 1 ELSE 0 END) + (CASE WHEN t4.qrygroup26 = 'Y' THEN 1 ELSE 0 END) + (CASE WHEN t0.U_Cleared_to_invoice is null or t0.U_Cleared_to_invoice = 'No' THEN 1 ELSE 0 END)[Score]
        FROM ordr t0

        INNER JOIN ohem t1 ON t1.empID = t0.OwnerCode  
        INNER JOIN oslp t2 ON t2.SlpCode = t0.SlpCode
        INNER JOIN ocrd t4 ON t4.CardCode = t0.CardCode

        LEFT JOIN 
        (
            SELECT DocEntry, LineTotal
            FROM rdr1
            WHERE Dscription LIKE 'Packaging & Delivery'
        )
        t3 ON t3.DocEntry = t0.DocEntry

        LEFT JOIN 
        (
            SELECT DocEntry, SUM(LineTotal) [Order Value]
            FROM rdr1
            GROUP BY DocEntry
        )
        t7 ON t7.DocEntry = t0.DocEntry

        LEFT JOIN 
        (
            SELECT DocEntry, MIN(U_Promise_Date)[U_Promise_Date]
            FROM rdr1
            WHERE LineStatus = 'O'
            GROUP BY DocEntry
        )
        t5 ON t5.DocEntry = t0.DocEntry

        LEFT JOIN 
        (
            SELECT DocEntry, MAX(U_PP_Status)[U_PP_Status]
            FROM rdr1
            WHERE U_PP_Status = 'Live' OR U_PP_Status is null
            GROUP BY DocEntry
        )
        t6 ON t6.DocEntry = t0.DocEntry

        WHERE t0.DocStatus = 'O' AND (ISNULL(t6.U_PP_Status,t0.U_PP_Status) is null OR ISNULL(t6.U_PP_Status,t0.U_PP_Status) = 'Live')
        
        ORDER BY Score DESC";           
?>