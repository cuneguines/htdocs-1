<?php


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////                                      COUNT FOR EXCEPTIONS                                         ////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
include "../PRE PRODUCTION/EXCEPTIONS/pre production exceptions/SQL_pre_production_exceptions.php";
include "../PRODUCTION/EXCEPTIONS/production exceptions/SQL_production_exceptions.php";
include "../SALES/EXCEPTIONS/sales exceptions/SQL_sales_exceptions.php";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////                           COUNTS AND VALUES FOR CLOSED SALES ORDERS                               ////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$closed_orders_year_q =
    "SELECT t1.* FROM DMS_COP_YEAR_10702020 t0
        LEFT OUTER JOIN(SELECT COUNT (DISTINCT t0.DocEntry)[Sales Orders], CAST(SUM(t0.linetotal) AS DECIMAL(12,0)) [Sales Value],
        (CASE
            WHEN DATEPART(year, t2.[Close Date]) = DATEPART(year, GETDATE()) THEN 'a_ytd'
            WHEN DATEPART(year, t2.[Close Date]) = (DATEPART(year, GETDATE())-1) AND t2.[Close Date] < DATEADD(year,-1,GETDATE()) THEN 'b_ttly'
            WHEN DATEPART(year, t2.[Close Date]) = (DATEPART(year, GETDATE())-1) THEN 'c_ly'
            ELSE 'd_n/a'
        END) [Date_Bracket]
        From rdr1 t0
            left join ordr t1 on t1.docentry = t0.docentry
            left join(select t1.BaseRef, MAX(t0.DocDate) [Close Date]
                from odln t0
                    inner join dln1 t1 on t1.DocEntry  = t0.DocEntry
                        group by t1.BaseRef)
            t2 On t2.BaseRef = t1.DocNum
                WHERE t1.DocStatus = 'C'
                GROUP BY
                (CASE
                    WHEN DATEPART(year, t2.[Close Date]) = DATEPART(year, GETDATE()) THEN 'a_ytd'
                    WHEN DATEPART(year, t2.[Close Date]) = (DATEPART(year, GETDATE())-1) AND t2.[Close Date] < DATEADD(year,-1,GETDATE()) THEN 'b_ttly'
                    WHEN DATEPART(year, t2.[Close Date]) = (DATEPART(year, GETDATE())-1) THEN 'c_ly'
                    ELSE 'd_n/a' 
                END)
                )
                t1 ON t1.[Date_Bracket] = t0.[date_range]
                ORDER BY t0.[date_range]";

$closed_orders_month_q =
    "SELECT t1.* FROM DMS_COP_MONTH_10702020 t0
        LEFT OUTER JOIN (SELECT COUNT (DISTINCT t0.DocEntry)[Sales Orders], CAST(sum(t0.linetotal) AS DECIMAL(12,0)) [Sales Value],
        (CASE
            WHEN DATEPART(month, t2.[Close Date]) = DATEPART(month, GETDATE()) AND DATEPART(year, t2.[Close Date]) = DATEPART(year, GETDATE()) THEN 'a_mtd'
            WHEN DATEPART(month, t2.[Close Date]) = DATEPART(month, DATEADD(month, -1, GETDATE())) AND DATEPART(yyyy, t2.[Close Date]) = DATEPART(yyyy, DATEADD(month, -1, GETDATE())) AND t2.[Close Date] <= DATEADD(month,-1,GETDATE()) THEN 'b_ttlm'
            WHEN DATEPART(month, t2.[Close Date]) = DATEPART(month, DATEADD(month, -1, GETDATE())) AND DATEPART(yyyy, t2.[Close Date]) = DATEPART(yyyy, DATEADD(month, -1, GETDATE())) THEN 'c_lm'
            ELSE 'd_n/a' 
        END) [Date_Bracket]
        From rdr1 t0
            left join ordr t1 on t1.docentry = t0.docentry
            left join(select t1.BaseRef, MAX(t0.DocDate) [Close Date]
                        from odln t0
                            inner join dln1 t1 on t1.DocEntry  = t0.DocEntry
                            group by t1.BaseRef)
            t2 On t2.BaseRef = t1.DocNum
                WHERE t1.DocStatus = 'C'
                GROUP BY
                (CASE
                    WHEN DATEPART(month, t2.[Close Date]) = DATEPART(month, GETDATE()) AND DATEPART(year, t2.[Close Date]) = DATEPART(year, GETDATE()) THEN 'a_mtd'
                    WHEN DATEPART(month, t2.[Close Date]) = DATEPART(month, DATEADD(month, -1, GETDATE())) AND DATEPART(yyyy, t2.[Close Date]) = DATEPART(yyyy, DATEADD(month, -1, GETDATE())) AND t2.[Close Date] <= DATEADD(month,-1,GETDATE()) THEN 'b_ttlm'
                    WHEN DATEPART(month, t2.[Close Date]) = DATEPART(month, DATEADD(month, -1, GETDATE())) AND DATEPART(yyyy, t2.[Close Date]) = DATEPART(yyyy, DATEADD(month, -1, GETDATE())) THEN 'c_lm'
                    ELSE 'd_n/a' 
                END)
                )
                t1 ON t1.[Date_Bracket] = t0.[date_range]
                ORDER BY t0.[date_range]";

$closed_orders_week_q =
    "SELECT t1.* FROM DMS_COP_WEEK_10702020 t0
        LEFT OUTER JOIN (SELECT COUNT (DISTINCT t0.DocEntry)[Sales Orders], CAST(sum(t0.linetotal) AS DECIMAL(12,0)) [Sales Value],
            (CASE
                WHEN t2.[Close Date] >= DATEADD(wk, DATEDIFF(wk,0,GETDATE()), -1) AND t2.[Close Date] <= DATEADD(wk, DATEDIFF(wk,0,GETDATE()), 5) THEN 'a_wtd'
                WHEN DATEPART(ISO_WEEK,t2.[Close Date]) = DATEPART(ISO_WEEK,DATEADD(week, -1,GETDATE())) AND DATEPART(year,t2.[Close Date]) = DATEPART(year, DATEADD(week,-1,GETDATE())) AND t2.[Close Date] < DATEADD(week,-1,GETDATE()) THEN 'b_ttlw'
                WHEN DATEPART(ISO_WEEK, t2.[Close Date]) = DATEPART(ISO_WEEK, DATEADD(week, -1, GETDATE())) AND DATEPART(yyyy, t2.[Close Date]) = DATEPART(yyyy, DATEADD(week, -1, GETDATE())) THEN 'c_lw'
                ELSE 'd_n/a' 
            END) [Date_Bracket]
            From rdr1 t0
                left join ordr t1 on t1.docentry = t0.docentry
                left join(select t1.BaseRef, MAX(t0.DocDate) [Close Date]
                            from odln t0
                                inner join dln1 t1 on t1.DocEntry  = t0.DocEntry
                                group by t1.BaseRef)
                t2 On t2.BaseRef = t1.DocNum
                    WHERE t1.DocStatus = 'C'
                    GROUP BY
                    (CASE
                        WHEN t2.[Close Date] >= DATEADD(wk, DATEDIFF(wk,0,GETDATE()), -1) AND t2.[Close Date] <= DATEADD(wk, DATEDIFF(wk,0,GETDATE()), 5) THEN 'a_wtd'
                        WHEN DATEPART(ISO_WEEK,t2.[Close Date]) = DATEPART(ISO_WEEK,DATEADD(week, -1,GETDATE())) AND DATEPART(year,t2.[Close Date]) = DATEPART(year, DATEADD(week,-1,GETDATE())) AND t2.[Close Date] < DATEADD(week,-1,GETDATE()) THEN 'b_ttlw'
                        WHEN DATEPART(ISO_WEEK, t2.[Close Date]) = DATEPART(ISO_WEEK, DATEADD(week, -1, GETDATE())) AND DATEPART(yyyy, t2.[Close Date]) = DATEPART(yyyy, DATEADD(week, -1, GETDATE())) THEN 'c_lw'
                        ELSE 'd_n/a'
                    END)
                    )
                    t1 ON t1.[Date_Bracket] = t0.[date_range]
                    ORDER BY t0.[date_range]";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////             LABOUR AND MATERTIAL EFFICIENCY PER DATERANGES ON CLOSED SALES ORDERS                 ////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$closed_percentage_year_q =
    "SELECT t1.* FROM DMS_COP_LBMAT_YEAR_10702020 t0
        LEFT JOIN (SELECT
        FORMAT(CAST(SUM(t3.[Actual_Lab])/SUM(t2.[Planned_Lab]) AS DECIMAL(12,4)),'P2') [Lab Efficiency], FORMAT(CAST(SUM(t4.[Issued_Mat])/SUM(t4.[Planned_Mat]) AS DECIMAL(12,4)),'P2') [Mat Efficiency],
        (CASE 
            WHEN DATEPART(year, t6.[Close Date]) = DATEPART(year,GETDATE()) THEN 'a_lbmat_ytd'
            WHEN DATEPART(year, t6.[Close Date]) = DATEPART(year, DATEADD(year, -1, GETDATE())) THEN 'b_lbmat_ly'
            ELSE 'c_lbmat_n/a' 
        END) [date_bracket]
        FROM IIS_EPC_PRO_ORDERH t0  
            INNER JOIN owor t1 ON t1.U_IIS_proPrOrder = t0.PrOrder AND t1.ItemCode = t0.EndProduct    
            INNER JOIN ordr t5 ON t5.docnum = t1.OriginNum
            LEFT JOIN (select t1.U_IIS_proPrOrder, 
                SUM(t0.plannedqty) [Planned_Lab]
                FROM wor1 t0
                    INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry  				
                    INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode  				
                        WHERE t2.ItemType = 'L' 				
                        GROUP BY t1.U_IIS_proPrOrder) 
            t2 ON t2.U_IIS_proPrOrder = t1.U_IIS_proPrOrder
            LEFT JOIN (SELECT t0.PrOrder, 
                SUM(t0.Quantity) [Actual_Lab]
                    FROM iis_epc_pro_ordert t0  				
                        GROUP BY t0.PrOrder) 
            t3 ON t3.PrOrder = t1.U_IIS_proPrOrder
            LEFT JOIN (SELECT t1.U_IIS_proPrOrder,
                SUM(t0.plannedqty * t2.avgprice) [Planned_Mat],   			
                SUM(t0.IssuedQty* t2.avgprice) [Issued_Mat]  			
                FROM wor1 t0
                    INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry  			
                    INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode
                        WHERE  t2.itemtype <> 'L' 			
                        GROUP BY t1.U_IIS_proPrOrder)
            t4 on t4.U_IIS_proPrOrder = t0.PrOrder
            LEFT JOIN(select t1.BaseRef, MAX(t0.DocDate) [Close Date]
                        from odln t0
                            inner join dln1 t1 on t1.DocEntry  = t0.DocEntry
                            group by t1.BaseRef)
            t6 On t6.BaseRef = t5.DocNum           
                WHERE t5.DocStatus = 'C' AND t1.Status <> 'C'
                GROUP BY 
                (CASE WHEN DATEPART(year, t6.[Close Date]) = DATEPART(year,GETDATE()) THEN 'a_lbmat_ytd'
                WHEN DATEPART(year, t6.[Close Date]) = DATEPART(year, DATEADD(year, -1, GETDATE())) THEN 'b_lbmat_ly'
                ELSE 'c_lbmat_n/a' END))
                t1 ON t1.[date_bracket] = t0.[date_range]
                ORDER BY t0.[date_range]";

$closed_percentage_month_q =
    "SELECT t1.* FROM DMS_COP_LBMAT_MONTH_10702020 t0
        LEFT JOIN(SELECT
        FORMAT(CAST(SUM(t3.[Actual_Lab])/SUM(t2.[Planned_Lab]) AS DECIMAL(12,4)),'P2') [Lab Efficiency], FORMAT(CAST(SUM(t4.[Issued_Mat])/SUM(t4.[Planned_Mat]) AS DECIMAL(12,4)),'P2') [Mat Efficiency],
        (CASE 
            WHEN DATEPART(month, t6.[Close Date]) = DATEPART(month,GETDATE()) AND DATEPART(year, t6.[Close Date]) = DATEPART(year,GETDATE()) THEN 'a_lbmat_mtd'
            WHEN DATEPART(month, t6.[Close Date]) = DATEPART(month, DATEADD(month, -1, GETDATE())) AND DATEPART(yyyy, t6.[Close Date]) = DATEPART(yyyy, DATEADD(month, -1, GETDATE())) THEN 'b_lbmat_lm'
            ELSE 'c_lbmat_n/a' 
        END) [date_bracket]
        FROM IIS_EPC_PRO_ORDERH t0  
            INNER JOIN owor t1 ON t1.U_IIS_proPrOrder = t0.PrOrder AND t1.ItemCode = t0.EndProduct    
            INNER JOIN ordr t5 ON t5.docnum = t1.OriginNum
            LEFT JOIN (select t1.U_IIS_proPrOrder, 
            SUM(t0.plannedqty) [Planned_Lab]
            FROM wor1 t0
                INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry  				
                INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode  				
                    WHERE t2.ItemType = 'L' 				
                    GROUP BY t1.U_IIS_proPrOrder) 
            t2 ON t2.U_IIS_proPrOrder = t1.U_IIS_proPrOrder
            LEFT JOIN (SELECT t0.PrOrder, 
                SUM(t0.Quantity) [Actual_Lab]
                    FROM iis_epc_pro_ordert t0  				
                        GROUP BY t0.PrOrder) 
            t3 ON t3.PrOrder = t1.U_IIS_proPrOrder
            LEFT JOIN (SELECT t1.U_IIS_proPrOrder,
                SUM(t0.plannedqty * t2.avgprice) [Planned_Mat],   			
                SUM(t0.IssuedQty* t2.avgprice) [Issued_Mat]  			
                FROM wor1 t0
                    INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry  			
                    INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode
                        WHERE  t2.itemtype <> 'L' 			
                        GROUP BY t1.U_IIS_proPrOrder)
        t4 on t4.U_IIS_proPrOrder = t0.PrOrder
        left join(select t1.BaseRef, MAX(t0.DocDate) [Close Date]
                        from odln t0
                            inner join dln1 t1 on t1.DocEntry  = t0.DocEntry
                            group by t1.BaseRef)
            t6 On t6.BaseRef = t5.DocNum          
            WHERE t5.DocStatus = 'C' AND t1.Status <> 'C'
            GROUP BY 
            (CASE 
            WHEN DATEPART(month, t6.[Close Date]) = DATEPART(month,GETDATE()) AND DATEPART(year, t6.[Close Date]) = DATEPART(year,GETDATE()) THEN 'a_lbmat_mtd'
            WHEN DATEPART(month, t6.[Close Date]) = DATEPART(month, DATEADD(month, -1, GETDATE())) AND DATEPART(yyyy, t6.[Close Date]) = DATEPART(yyyy, DATEADD(month, -1, GETDATE())) THEN 'b_lbmat_lm'
            ELSE 'c_lbmat_n/a' END))
            t1 ON t1.[date_bracket] = t0.[date_range]
            ORDER BY t0.[date_range]";

$closed_percentage_week_q =
    "SELECT t1.* FROM DMS_COP_LBMAT_WEEK_10702020 t0
     LEFT JOIN(SELECT
        FORMAT(CAST(SUM(t3.[Actual_Lab])/SUM(t2.[Planned_Lab]) AS DECIMAL(12,4)),'P2') [Lab Efficiency], FORMAT(CAST(SUM(t4.[Issued_Mat])/SUM(t4.[Planned_Mat]) AS DECIMAL(12,4)),'P2') [Mat Efficiency],
        (CASE 
            WHEN t6.[Close Date] >= DATEADD(wk, DATEDIFF(wk,0,GETDATE()), -1) AND t6.[Close Date] <= DATEADD(wk, DATEDIFF(wk,0,GETDATE()), 5) THEN 'a_lbmat_wtd'
            WHEN DATEPART(ISO_WEEK, t6.[Close Date]) = DATEPART(ISO_WEEK, DATEADD(week, -1, GETDATE())) AND DATEPART(yyyy, t6.[Close Date]) = DATEPART(yyyy, DATEADD(week, -1, GETDATE()))  THEN 'b_lbmat_lw'
        ELSE 'c_lbmat_n/a' 
        END) [date_bracket]
        FROM IIS_EPC_PRO_ORDERH t0  
            INNER JOIN owor t1 ON t1.U_IIS_proPrOrder = t0.PrOrder AND t1.ItemCode = t0.EndProduct    
            INNER JOIN ordr t5 ON t5.docnum = t1.OriginNum
            LEFT JOIN (select t1.U_IIS_proPrOrder, 
            SUM(t0.plannedqty) [Planned_Lab]
            FROM wor1 t0
                INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry  				
                INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode  				
                    WHERE t2.ItemType = 'L' 				
                    GROUP BY t1.U_IIS_proPrOrder) 
            t2 ON t2.U_IIS_proPrOrder = t1.U_IIS_proPrOrder
            LEFT JOIN (SELECT t0.PrOrder, 
                SUM(t0.Quantity) [Actual_Lab]
                    FROM iis_epc_pro_ordert t0  				
                        GROUP BY t0.PrOrder) 
            t3 ON t3.PrOrder = t1.U_IIS_proPrOrder
            LEFT JOIN (SELECT t1.U_IIS_proPrOrder,
                SUM(t0.plannedqty * t2.avgprice) [Planned_Mat],   			
                SUM(t0.IssuedQty* t2.avgprice) [Issued_Mat]  			
                FROM wor1 t0
                    INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry  			
                    INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode
                        WHERE  t2.itemtype <> 'L' 			
                        GROUP BY t1.U_IIS_proPrOrder)
        t4 on t4.U_IIS_proPrOrder = t0.PrOrder
        left join(select t1.BaseRef, MAX(t0.DocDate) [Close Date]
                        from odln t0
                            inner join dln1 t1 on t1.DocEntry  = t0.DocEntry
                            group by t1.BaseRef)
            t6 On t6.BaseRef = t5.DocNum           
            WHERE t5.DocStatus = 'C' AND t1.Status <> 'C'
            GROUP BY 
            (CASE 
                WHEN t6.[Close Date] >= DATEADD(wk, DATEDIFF(wk,0,GETDATE()), -1) AND t6.[Close Date] <= DATEADD(wk, DATEDIFF(wk,0,GETDATE()), 5) THEN 'a_lbmat_wtd'
                WHEN DATEPART(ISO_WEEK, t6.[Close Date]) = DATEPART(ISO_WEEK, DATEADD(week, -1, GETDATE())) AND DATEPART(yyyy, t6.[Close Date]) = DATEPART(yyyy, DATEADD(week, -1, GETDATE()))  THEN 'b_lbmat_lw'
            ELSE 'c_lbmat_n/a' END))
            t1 ON t1.[date_bracket] = t0.[date_range]
            ORDER BY t0.[date_range]";
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////                                   COMPLETE PROCESS ORDERS                                         ////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$comp_po_w_q ="SELECT   
COUNT(t1.DocNum)[Process Orders],   

   (CASE 
    WHEN SUM(t2.Planned_mat) = 0 THEN FORMAT(0,'P0')
    ELSE FORMAT((SUM(t2.Issued_Mat))/SUM(t2.Planned_Mat),'P0')
END) [Mat Efficiency],

   (CASE 
    WHEN SUM(t9.Planned_Lab) = 0 THEN FORMAT(0,'P0')
    ELSE FORMAT(SUM(t10.Actual_Lab)/SUM(t9.Planned_Lab),'P0') 
END) [Lab Efficiency],
   
   CAST(SUM(t2.Planned_Mat) - SUM(isnull(t2.Issued_Mat,0)) AS DECIMAL(12,0)) [Difference_Mat],

   CAST(SUM(t9.Planned_Lab) - SUM(isnull(t10.Actual_Lab,0)) AS DECIMAL(12,0)) [Difference_Lab]


FROM IIS_EPC_PRO_ORDERH t0  
INNER JOIN owor t1 ON t1.U_IIS_proPrOrder = t0.PrOrder AND t1.ItemCode = t0.EndProduct   AND t1.Status <> 'C' 

LEFT JOIN (SELECT t1.U_IIS_proPrOrder, 
                SUM(t0.plannedqty * t2.avgprice) [Planned_Mat],             
                SUM(isnull(t0.IssuedQty,0)* t2.avgprice) + sum(isnull(t21.[Manual Mat],0)) [Issued_Mat], 
                                    SUM(t0.plannedqty * t2.avgprice)  - SUM(isnull(t0.IssuedQty,0)* t2.avgprice) - sum(isnull(t21.[Manual Mat],0)) [Mat_Diff]          
             FROM wor1 t0
                 INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry             
                 INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode
                    left join (select t2.PrOrder, t0.itemcode, sum(t0.linetotal) [Manual Mat]
                                                                              from ige1 t0
                                                                              inner join oige t1 on t1.DocEntry = t0.DocEntry
                                                                              inner join IIS_EPC_PRO_ORDERH t2 on t2.PrOrder = t0.U_IIS_proPrOrder
                                                                              where t0.U_IIS_proPrOrder is not null
                                                                              and t0.BaseEntry is null
                                                                              group by t2.PrOrder, t0.itemcode
                                                                                            ) t21 on t21.PrOrder = t1.U_IIS_proPrOrder and t21.ItemCode = t0.ItemCode
                 WHERE  t2.itemtype <> 'L'   AND 
                                            t1.Status <> 'C'
              --and t1.U_IIS_proPrOrder = '34463'        
                 GROUP BY t1.U_IIS_proPrOrder )
                          t2 on t2.U_IIS_proPrOrder = t0.PrOrder    

LEFT JOIN (select t1.U_IIS_proPrOrder, 
                SUM(t0.plannedqty) [Planned_Lab]
                FROM wor1 t0
                    INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry                 
                    INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode                 
                        WHERE t2.ItemType = 'L' AND 
                                                          t1.Status <> 'C'                
                        GROUP BY t1.U_IIS_proPrOrder) 
                          t9 ON t9.U_IIS_proPrOrder = t0.PrOrder    
LEFT JOIN (SELECT t0.PrOrder, 
                SUM(t0.Quantity) [Actual_Lab]
                    FROM iis_epc_pro_ordert t0                  
                        GROUP BY t0.PrOrder) 
                          t10 ON t10.PrOrder = t0.Prorder


inner join (select t0.PrOrder
                 from iis_epc_pro_orderh t0
                 INNER JOIN oitm t6 ON t6.ItemCode = t0.EndProduct
                 INNER JOIN oitb t17 ON t17.ItmsGrpCod = t6.ItmsGrpCod
                 WHERE  t17.ItmsGrpNam <> 'TRAINING' ) t11 on t11.PrOrder = t0.PrOrder


WHERE t1.CmpltQty >= t1.PlannedQty AND 
DATEPART(year,GETDATE()) = DATEPART(year,t1.CloseDate) ";




    

$comp_po_m_q =
    "SELECT   
    COUNT(t1.DocNum)[Process Orders],   
    (CASE 
        WHEN SUM(t2.Planned_mat) = 0 THEN FORMAT(0,'P0')
        ELSE FORMAT((SUM(t2.Issued_Mat))/SUM(t2.Planned_Mat),'P0')
    END) [Mat Efficiency],
    (CASE 
        WHEN SUM(t9.Planned_Lab) = 0 THEN FORMAT(0,'P0')
        ELSE FORMAT(SUM(t10.Actual_Lab)/SUM(t9.Planned_Lab),'P0') 
    END) [Lab Efficiency],
    CAST(SUM(t2.Planned_Mat) - SUM(isnull(t2.Issued_Mat,0)) AS DECIMAL(12,0)) [Difference_Mat],
    CAST(SUM(t9.Planned_Lab) - SUM(isnull(t10.Actual_Lab,0)) AS DECIMAL(12,0)) [Difference_Lab]
FROM IIS_EPC_PRO_ORDERH t0  
INNER JOIN owor t1 ON t1.U_IIS_proPrOrder = t0.PrOrder AND t1.ItemCode = t0.EndProduct    
LEFT JOIN (SELECT t1.U_IIS_proPrOrder, 
                    SUM(t0.plannedqty * t2.avgprice) [Planned_Mat],             
                    SUM(isnull(t0.IssuedQty,0)* t2.avgprice) + sum(isnull(t21.[Manual Mat],0)) [Issued_Mat], 
                                        SUM(t0.plannedqty * t2.avgprice)  - SUM(isnull(t0.IssuedQty,0)* t2.avgprice) - sum(isnull(t21.[Manual Mat],0)) [Mat_Diff]          
                 FROM wor1 t0
INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry             
INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode
   left join (select t2.PrOrder, t0.itemcode, sum(t0.linetotal) [Manual Mat]
                                     from ige1 t0
                                     inner join oige t1 on t1.DocEntry = t0.DocEntry
                                     inner join IIS_EPC_PRO_ORDERH t2 on t2.PrOrder = t0.U_IIS_proPrOrder
                                     where t0.U_IIS_proPrOrder is not null
                                     and t0.BaseEntry is null
                                     group by t2.PrOrder, t0.itemcode
                                            ) t21 on t21.PrOrder = t1.U_IIS_proPrOrder and t21.ItemCode = t0.ItemCode
         WHERE  t2.itemtype <> 'L'   
                  --and t1.U_IIS_proPrOrder = '34463'        
         GROUP BY t1.U_IIS_proPrOrder )
                              t2 on t2.U_IIS_proPrOrder = t0.PrOrder    
LEFT JOIN (select t1.U_IIS_proPrOrder, 
                    SUM(t0.plannedqty) [Planned_Lab]
                    FROM wor1 t0
                        INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry                 
                        INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode                 
                            WHERE t2.ItemType = 'L'                 
                            GROUP BY t1.U_IIS_proPrOrder) 
                              t9 ON t9.U_IIS_proPrOrder = t0.PrOrder    
LEFT JOIN (SELECT t0.PrOrder, 
                    SUM(t0.Quantity) [Actual_Lab]
                        FROM iis_epc_pro_ordert t0                  
                            GROUP BY t0.PrOrder) 
                              t10 ON t10.PrOrder = t0.Prorder
LEFT JOIN(SELECT MAX(t0.Docdate) [STOCKDATE], t1.BaseRef, t1.ItemCode FROM oign t0 
                INNER JOIN ign1 t1 ON t1.DocEntry = t0.DocEntry
                GROUP BY t1.BaseRef, t1.ItemCode)
                              t14 ON t14.BaseRef = t1.DocNum and t14.ItemCode = t1.ItemCode 
LEFT JOIN ordr t5 ON t5.docnum = t1.OriginNum
LEFT JOIN oitm t6 ON t6.ItemCode = t0.EndProduct
LEFT JOIN oitb t17 ON t17.ItmsGrpCod = t6.ItmsGrpCod
LEFT JOIN rdr1 t15 ON t15.DocEntry = t5.DocEntry AND t15.ItemCode = t1.ItemCode  

WHERE t1.CmpltQty >= t1.PlannedQty AND 
DATEPART(MONTH,GETDATE()) = DATEPART(MONTH,t1.CloseDate) AND DATEPART(year,GETDATE()) = DATEPART(year,t1.CloseDate) AND 
t17.ItmsGrpNam <> 'TRAINING' AND 
t1.Status <> 'C'";


$comp_po_y_q =
    "SELECT   
    COUNT(t1.DocNum)[Process Orders],   
    (CASE 
        WHEN SUM(t2.Planned_mat) = 0 THEN FORMAT(0,'P0')
        ELSE FORMAT((SUM(t2.Issued_Mat))/SUM(t2.Planned_Mat),'P0')
    END) [Mat Efficiency],
    (CASE 
        WHEN SUM(t9.Planned_Lab) = 0 THEN FORMAT(0,'P0')
        ELSE FORMAT(SUM(t10.Actual_Lab)/SUM(t9.Planned_Lab),'P0') 
    END) [Lab Efficiency],
    CAST(SUM(t2.Planned_Mat) - SUM(isnull(t2.Issued_Mat,0)) AS DECIMAL(12,0)) [Difference_Mat],
    CAST(SUM(t9.Planned_Lab) - SUM(isnull(t10.Actual_Lab,0)) AS DECIMAL(12,0)) [Difference_Lab]
FROM IIS_EPC_PRO_ORDERH t0  
INNER JOIN owor t1 ON t1.U_IIS_proPrOrder = t0.PrOrder AND t1.ItemCode = t0.EndProduct    
LEFT JOIN (SELECT t1.U_IIS_proPrOrder, 
                    SUM(t0.plannedqty * t2.avgprice) [Planned_Mat],             
                    SUM(isnull(t0.IssuedQty,0)* t2.avgprice) + sum(isnull(t21.[Manual Mat],0)) [Issued_Mat], 
                                        SUM(t0.plannedqty * t2.avgprice)  - SUM(isnull(t0.IssuedQty,0)* t2.avgprice) - sum(isnull(t21.[Manual Mat],0)) [Mat_Diff]          
                 FROM wor1 t0
INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry             
INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode
   left join (select t2.PrOrder, t0.itemcode, sum(t0.linetotal) [Manual Mat]
                                     from ige1 t0
                                     inner join oige t1 on t1.DocEntry = t0.DocEntry
                                     inner join IIS_EPC_PRO_ORDERH t2 on t2.PrOrder = t0.U_IIS_proPrOrder
                                     where t0.U_IIS_proPrOrder is not null
                                     and t0.BaseEntry is null
                                     group by t2.PrOrder, t0.itemcode
                                            ) t21 on t21.PrOrder = t1.U_IIS_proPrOrder and t21.ItemCode = t0.ItemCode
         WHERE  t2.itemtype <> 'L'   
                  --and t1.U_IIS_proPrOrder = '34463'        
         GROUP BY t1.U_IIS_proPrOrder )
                              t2 on t2.U_IIS_proPrOrder = t0.PrOrder    
LEFT JOIN (select t1.U_IIS_proPrOrder, 
                    SUM(t0.plannedqty) [Planned_Lab]
                    FROM wor1 t0
                        INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry                 
                        INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode                 
                            WHERE t2.ItemType = 'L'                 
                            GROUP BY t1.U_IIS_proPrOrder) 
                              t9 ON t9.U_IIS_proPrOrder = t0.PrOrder    
LEFT JOIN (SELECT t0.PrOrder, 
                    SUM(t0.Quantity) [Actual_Lab]
                        FROM iis_epc_pro_ordert t0                  
                            GROUP BY t0.PrOrder) 
                              t10 ON t10.PrOrder = t0.Prorder
LEFT JOIN(SELECT MAX(t0.Docdate) [STOCKDATE], t1.BaseRef, t1.ItemCode FROM oign t0 
                INNER JOIN ign1 t1 ON t1.DocEntry = t0.DocEntry
                GROUP BY t1.BaseRef, t1.ItemCode)
                              t14 ON t14.BaseRef = t1.DocNum and t14.ItemCode = t1.ItemCode 
LEFT JOIN ordr t5 ON t5.docnum = t1.OriginNum
LEFT JOIN oitm t6 ON t6.ItemCode = t0.EndProduct
LEFT JOIN oitb t17 ON t17.ItmsGrpCod = t6.ItmsGrpCod
LEFT JOIN rdr1 t15 ON t15.DocEntry = t5.DocEntry AND t15.ItemCode = t1.ItemCode  

WHERE t1.CmpltQty >= t1.PlannedQty AND 
DATEPART(year,GETDATE()) = DATEPART(year,t1.CloseDate) AND 
t17.ItmsGrpNam <> 'TRAINING' AND 
t1.Status <> 'C'";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////                                      TOTAL WORKED HOURS                                           ////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$p_hours_w_q =
    "SELECT t1.* FROM DMS_COP_WEEK_10702020 t0
    LEFT JOIN (SELECT ISNULL(CAST(SUM(Quantity) AS DECIMAL(12,0)),0) [Hours Executed],
    CASE
        WHEN DATEPART(ISO_WEEK,Created) = DATEPART(ISO_WEEK,GETDATE()) AND DATEPART(Year,Created) = DATEPART(Year, GETDATE()) THEN 'a_wtd'
        WHEN DATEPART(ISO_WEEK,Created) = DATEPART(ISO_WEEK,DATEADD(week,-1,GETDATE())) AND DATEPART(year,Created) = DATEPART(year,DATEADD(week,-1,GETDATE())) AND CAST(Created AS DATE) < CAST(DATEADD(week,-1,GETDATE()) AS DATE) THEN 'b_ttlw'
        ELSE 'd_n/a'
    END [Date_Bracket]
    FROM IIS_EPC_PRO_ORDERT t0
    INNER JOIN IIS_EPC_PRO_ORDERH  t1 on t1.PrOrder = t0.PrOrder
    INNER JOIN oitm t2 ON t2.ItemCode = t1.EndProduct
    INNER JOIN oitb t3 ON t3.ItmsGrpCod = t2.ItmsGrpCod
    WHERE t3.ItmsGrpNam <> 'TRAINING'
    GROUP BY CASE
        WHEN DATEPART(ISO_WEEK,Created) = DATEPART(ISO_WEEK,GETDATE()) AND DATEPART(Year,Created) = DATEPART(Year, GETDATE()) THEN 'a_wtd'
        WHEN DATEPART(ISO_WEEK,Created) = DATEPART(ISO_WEEK,DATEADD(week,-1,GETDATE())) AND DATEPART(year,Created) = DATEPART(year,DATEADD(week,-1,GETDATE())) AND CAST(Created AS DATE) < CAST(DATEADD(week,-1,GETDATE()) AS DATE) THEN 'b_ttlw'
        ELSE 'd_n/a'
    END)
    t1 ON t1.[Date_Bracket] = t0.[date_range]
    ORDER BY t0.[date_range]";

$p_hours_m_q =
    "SELECT t1.* FROM DMS_COP_MONTH_10702020 t0
    LEFT JOIN (SELECT ISNULL(CAST(SUM(Quantity) AS DECIMAL(12,0)),0) [Hours Executed],
    CASE
        WHEN DATEPART(month,Created) = DATEPART(month,GETDATE()) AND DATEPART(Year,Created) = DATEPART(Year, GETDATE()) THEN 'a_mtd'
        WHEN DATEPART(month,Created) = DATEPART(month,DATEADD(month,-1,GETDATE())) AND DATEPART(year,Created) = DATEPART(year,DATEADD(month,-1,GETDATE())) AND CAST(Created AS DATE) < CAST(DATEADD(month,-1,GETDATE()) AS DATE) THEN 'b_ttlm'
        ELSE 'd_n/a'
    END [Date_Bracket]
    FROM IIS_EPC_PRO_ORDERT t0
    INNER JOIN IIS_EPC_PRO_ORDERH  t1 on t1.PrOrder = t0.PrOrder
    INNER JOIN oitm t2 ON t2.ItemCode = t1.EndProduct
    INNER JOIN oitb t3 ON t3.ItmsGrpCod = t2.ItmsGrpCod
    WHERE t3.ItmsGrpNam <> 'TRAINING'
    GROUP BY CASE
        WHEN DATEPART(month,Created) = DATEPART(month,GETDATE()) AND DATEPART(Year,Created) = DATEPART(Year, GETDATE()) THEN 'a_mtd'
        WHEN DATEPART(month,Created) = DATEPART(month,DATEADD(month,-1,GETDATE())) AND DATEPART(year,Created) = DATEPART(year,DATEADD(month,-1,GETDATE())) AND CAST(Created AS DATE) < CAST(DATEADD(month,-1,GETDATE()) AS DATE) THEN 'b_ttlm'
        ELSE 'd_n/a'
    END
    )
    t1 ON t1.[Date_Bracket] = t0.[date_range]
    ORDER BY t0.[date_range]";

$p_hours_y_q =
    "SELECT t1.* FROM DMS_COP_YEAR_10702020 t0
    LEFT JOIN (SELECT ISNULL(CAST(SUM(Quantity) AS DECIMAL(12,0)),0) [Hours Executed],
    CASE
        WHEN DATEPART(year,Created) = DATEPART(year,GETDATE()) THEN 'a_ytd'
        WHEN DATEPART(Year,DATEADD(year,-1,GETDATE())) = DATEPART(year,Created) AND CAST(Created AS DATE) < CAST(DATEADD(year,-1,GETDATE()) AS DATE) THEN 'b_ttly'
        ELSE 'd_n/a'
    END [Date_Bracket]
    FROM IIS_EPC_PRO_ORDERT t0
    INNER JOIN IIS_EPC_PRO_ORDERH  t1 on t1.PrOrder = t0.PrOrder
    INNER JOIN oitm t2 ON t2.ItemCode = t1.EndProduct
    INNER JOIN oitb t3 ON t3.ItmsGrpCod = t2.ItmsGrpCod
    WHERE t3.ItmsGrpNam <> 'TRAINING'
    GROUP BY CASE
        WHEN DATEPART(year,Created) = DATEPART(year,GETDATE()) THEN 'a_ytd'
        WHEN DATEPART(Year,DATEADD(year,-1,GETDATE())) = DATEPART(year,Created) AND CAST(Created AS DATE) < CAST(DATEADD(year,-1,GETDATE()) AS DATE) THEN 'b_ttly'
        ELSE 'd_n/a'
    END
    )
    t1 ON t1.[Date_Bracket] = t0.[date_range]
    ORDER BY t0.[date_range]";

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////                                 COUNTS FOR ALL ACTIVE ORDERS                                      ////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$full_schedule =
    "SELECT COUNT(t0.DocNum) [All Orders] 
        FROM ordr t0
            INNER JOIN rdr1 t1 ON t1.DocEntry = t0.DocEntry
            INNER JOIN oslp t2 ON t2.SlpCode = t0.SlpCode
            INNER JOIN ohem t3 ON t3.empID = t0.OwnerCode
            LEFT JOIN  owor t4 ON t4.OriginNum = t0.DocNum AND t4.ItemCode = t1.ItemCode
                WHERE t1.LineStatus = 'O' AND t1.ItemCode <> 'TRANSPORT' AND t0.CANCELED <> 'Y' AND t0.DocStatus <> 'C'";

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////                      COUNTS AND VALUES FOR ALL ACTIVE AND POTENTIAL WORK                          ////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$lo_val =
    "SELECT COUNT (t5.DocNum) [live_order_count], CAST(SUM(t15.[LineTotal]) AS DECIMAL(12,0))
            FROM IIS_EPC_PRO_ORDERH t0  
                INNER JOIN owor t1 ON t1.U_IIS_proPrOrder = t0.PrOrder AND t1.ItemCode = t0.EndProduct    
                INNER JOIN ordr t5 ON t5.docnum = t1.OriginNum
                INNER JOIN oitm t6 ON t6.ItemCode = t0.EndProduct  
                INNER JOIN ohem t7 ON t7.empID = t5.OwnerCode  
                INNER JOIN oslp t8 ON t8.SlpCode = t5.SlpCode
                LEFT JOIN rdr1 t15 on t15.docentry = t5.DocEntry and t15.ItemCode = t1.itemcode   
                WHERE t1.CmpltQty < t1.PlannedQty AND t5.DocStatus = 'O' AND t1.Status not in ('C','L')";

$pp_con =
    "SELECT COUNT(t0.DocNum), CAST(SUM(t1.U_Est_Prod_hrs) AS DECIMAL(12,0)), CAST(SUM(t1.LineTotal) AS DECIMAL(12,0))
        FROM ordr t0
            INNER JOIN rdr1 t1 ON t1.DocEntry = t0.DocEntry
            WHERE t1.LineStatus = 'O' AND t0.DocStatus != 'C' AND t1.ItemCode <> 'TRANSPORT' AND t0.CANCELED <> 'Y' AND t1.U_PP_Status IN ('Pre Production Confirmed','1003')";

$pp_pot =
    "SELECT COUNT(t0.DocNum), CAST(SUM(t1.U_Est_Prod_hrs) AS DECIMAL(12,0)), CAST(SUM(t1.LineTotal) AS DECIMAL(12,0))
        FROM ordr t0
            INNER JOIN rdr1 t1 ON t1.DocEntry = t0.DocEntry
            WHERE t1.LineStatus = 'O' AND t0.DocStatus != 'C' AND t1.ItemCode <> 'TRANSPORT' AND t0.CANCELED <> 'Y' AND t1.U_PP_Status IN ('Pre Production Potential','1002')";

$pp_for =
    "SELECT COUNT(t0.DocNum), CAST(SUM(t1.U_Est_Prod_Hrs) AS DECIMAL(12,0)), CAST(SUM(t1.LineTotal) AS DECIMAL(12,0))
        FROM ordr t0
            INNER JOIN rdr1 t1 ON t1.DocEntry = t0.DocEntry
            WHERE t1.LineStatus = 'O' AND t0.DocStatus != 'C' AND t1.ItemCode <> 'TRANSPORT' AND t0.CANCELED <> 'Y' AND t1.U_PP_Status IN ('Pre Production Forecast','1004')";

$lo_hrs =
    "SELECT
	COUNT(ISNULL(t5.DocNum,1)) [Sales Orders],
	SUM(CAST(t2.[Planned_Lab] AS DECIMAL(12,0))) [Planned_Lab], 
	SUM(CAST(t3.[Actual_Lab] AS DECIMAL(12,0))) [Actual_Lab],
	SUM(CASE 
		WHEN (t2.[Planned_Lab] - ISNULL(t3.[Actual_Lab],0)) < 0 THEN 0
		ELSE CAST(t2.[Planned_Lab] AS DECIMAL (12,0)) - CAST(ISNULL(t3.[Actual_Lab],0) AS DECIMAL (12,0))
	END)[Remaining_Lab],
	SUM(CASE 
		WHEN (t2.[Planned_Lab] - ISNULL(t3.[Actual_Lab],0)) >= 0 THEN 0
		ELSE CAST(t3.[Actual_Lab] AS DECIMAL (12,0)) - CAST(ISNULL(t2.[Planned_Lab],0) AS DECIMAL (12,0))
	END) [Unplanned Deficit]
	FROM IIS_EPC_PRO_ORDERH t0
		INNER JOIN owor t1 ON t1.U_IIS_proPrOrder = t0.PrOrder AND t1.ItemCode = t0.EndProduct    
		LEFT JOIN ordr t5 ON t5.docnum = t1.OriginNum
		LEFT join rdr1 t6 on t6.DocEntry = t5.DocEntry and t6.ItemCode = t1.ItemCode
		LEFT JOIN (select t1.U_IIS_proPrOrder, 
			SUM(t0.plannedqty) [Planned_Lab]
			FROM wor1 t0
				INNER JOIN owor t1 ON t1.DocEntry = t0.DocEntry  				
				INNER JOIN oitm t2 ON t2.ItemCode = t0.ItemCode
				INNER join iis_epc_pro_orderh t3 on t3.PrOrder = t0.U_IIS_proPrOrder 				
					WHERE t2.ItemType = 'L' 				
					GROUP BY t1.U_IIS_proPrOrder) 
		t2 ON t2.U_IIS_proPrOrder = t0.PrOrder    
		LEFT JOIN (SELECT t0.PrOrder, 
			SUM(t0.Quantity) [Actual_Lab]
				FROM iis_epc_pro_ordert t0  				
					GROUP BY t0.PrOrder) 
		t3 ON t3.PrOrder = t0.Prorder
		
		WHERE t1.CmpltQty < t1.PlannedQty AND t1.Status not in ('C','L') AND ISNULL(t5.DocStatus,'O') <> 'C' AND ISNULL(t5.CANCELED,'N') <> 'Y'";


$five_week_average =
    "SELECT * FROM(
            SELECT
                'FIVE WEEK AVG' [Range],
                SUM(case when (t7.PlannedLabourProdn + t7.PlannedLabourSite) is null then '0' else (t7.PlannedLabourProdn + t7.PlannedLabourSite) end)/5 [Planned Hours] 
                       FROM owor t0
                       LEFT JOIN
                    (
                              SELECT t7.docnum, 
                                     sum(case when t6.ItmsGrpNam='LABOUR PRODUCTION' then t4.PlannedQty else 0 end) [PlannedLabourProdn],
                                     sum(case when t6.ItmsGrpNam='LABOUR SITE' then t4.PlannedQty else 0 end) [PlannedLabourSite]
                                     FROM WOR1 t4 
                                           INNER JOIN OITM t5 on t4.ItemCode=t5.ItemCode
                                           INNER JOIN OITB t6 on t5.ItmsGrpCod=t6.ItmsGrpCod
                                           LEFT JOIN owor t7 on t4.docentry = t7.DocEntry
                                                  GROUP BY t7.DocNum
                       )t7 on T0.docnum =t7.DocNum
                    INNER JOIN IIS_EPC_PRO_ORDERH t9 on t0.U_IIS_proPrOrder = t9.PrOrder AND t9.EndProduct = t0.ItemCode 
                              WHERE t0.RlsDate >= DATEADD(WEEK,-5,DATEADD(WEEK, DATEDIFF(WEEK,0,GETDATE()),0)) AND t0.RlsDate <= DATEADD(WEEK,-1,DATEADD(DAY, 6 - DATEPART(WEEKDAY, GETDATE()), GETDATE())) /* FROM MONDAY SIX WEEKS AGO UNTIL FRIDAY LAST WEEEK (FIVE WORKING WEEKS)(MON 18th OCT TO FRI 19TH NOV AS OF TODAY) */
            UNION ALL
            SELECT
                'THIS WEEK' [Range],
                SUM(case when (t7.PlannedLabourProdn + t7.PlannedLabourSite) is null then '0' else (t7.PlannedLabourProdn + t7.PlannedLabourSite) end)/5 [Planned Hours] 
                       FROM owor t0
                       LEFT JOIN
                    (
                              SELECT t7.docnum, 
                                     sum(case when t6.ItmsGrpNam='LABOUR PRODUCTION' then t4.PlannedQty else 0 end) [PlannedLabourProdn],
                                     sum(case when t6.ItmsGrpNam='LABOUR SITE' then t4.PlannedQty else 0 end) [PlannedLabourSite]
                                     FROM WOR1 t4 
                                           INNER JOIN OITM t5 on t4.ItemCode=t5.ItemCode
                                           INNER JOIN OITB t6 on t5.ItmsGrpCod=t6.ItmsGrpCod
                                           LEFT JOIN owor t7 on t4.docentry = t7.DocEntry
                                                  GROUP BY t7.DocNum
                       )t7 on T0.docnum =t7.DocNum
                    INNER JOIN IIS_EPC_PRO_ORDERH t9 on t0.U_IIS_proPrOrder = t9.PrOrder AND t9.EndProduct = t0.ItemCode 
                              WHERE t0.RlsDate >= DATEADD(WEEK, DATEDIFF(WEEK,0,GETDATE()),0) AND t0.RlsDate <= DATEADD(DAY, 6 - DATEPART(WEEKDAY, GETDATE()), GETDATE())
            )t0";
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////